<?php

namespace Tecactus\Skeleton\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Config;
use Tecactus\Skeleton\Observers\UserObserver;
use Tecactus\Skeleton\Auth\Activation\ActivationTokenRepository;
use Tecactus\Skeleton\Console\InstallCommand;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Str;

class SkeletonServiceProvider extends ServiceProvider
{
    /**
     * The skeleton command list.
     *
     * @var array
     */
    protected $commands = [
        InstallCommand::class,
    ];

    /**
     * The skeleton midlware list.
     *
     * @var array
     */
    protected $middlewares = [
        'user_only' => \Tecactus\Skeleton\Foundation\Http\Middleware\RedirectIfAdmin::class,
        'admin_only' => \Tecactus\Skeleton\Foundation\Http\Middleware\RedirectIfUser::class,
    ];

    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'Illuminate\Auth\Events\Registered' => [
            'Tecactus\Skeleton\Listeners\UserRegisteredListener',
        ],
        'Tecactus\Skeleton\Events\UserRequestActivationEmail' => [
            'Tecactus\Skeleton\Listeners\UserRequestActivationEmailListener',
        ],
    ];

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViews();
        $this->loadTranslations();
        $this->registerUserObserver();
        $this->registerActivationTokenRepository();
        $this->loadFormComponents();
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerCommands();
        $this->registerMiddlwares();
        $this->registerPackagesServiceProviders();
        $this->registerPackagesAliases();
        $this->registerEventListeners();
    }

    /**
     * Register the packages service providers.
     *
     * @return void
     */
    public function registerPackagesServiceProviders()
    {
        if (Config::get("skeleton.autoload.providers", false)) {
            $this->app->register(\Overtrue\LaravelLang\TranslationServiceProvider::class);
            $this->app->register(\Yajra\Datatables\DatatablesServiceProvider::class);
            $this->app->register(\Yajra\Datatables\ButtonsServiceProvider::class);
            $this->app->register(\Barryvdh\Snappy\ServiceProvider::class);
            $this->app->register(\Collective\Html\HtmlServiceProvider::class);
        }
    }

    /**
     * Register the packages aliases.
     *
     * @return void
     */
    public function registerPackagesAliases()
    {
        if (Config::get("skeleton.autoload.aliases", false)) {
            $aliasLoader = \Illuminate\Foundation\AliasLoader::getInstance();

            $aliasLoader->alias('Datatables', \Yajra\Datatables\Facades\Datatables::class);
            $aliasLoader->alias('PDF', \Barryvdh\Snappy\Facades\SnappyPdf::class);
            $aliasLoader->alias('SnappyImage', \Barryvdh\Snappy\Facades\SnappyImage::class);
            $aliasLoader->alias('Form', \Collective\Html\FormFacade::class);
            $aliasLoader->alias('Html', \Collective\Html\HtmlFacade::class);
        }
    }

    /**
     * Register the event listeners.
     *
     * @return void
     */
    public function registerEventListeners()
    {
        if (Config::get("skeleton.enable_activations", false)) {
            foreach ($this->listen as $event => $listeners) {
                foreach ($listeners as $listener) {
                    Event::listen($event, $listener);
                }
            }
        }
    }

    /**
     * Register the commands.
     *
     * @return void
     */
    protected function registerCommands()
    {
        $this->commands($this->commands);
    }

    /**
     * Register the middlwares.
     *
     * @return void
     */
    protected function registerMiddlwares()
    {
        foreach ($this->middlewares as $name => $class) {
            $this->app->router->aliasMiddleware($name, $class);
        }
    }

    /**
     * Load skeleton views.
     *
     * @return void
     */
    protected function loadViews()
    {
        $this->loadViewsFrom(__DIR__.'/../../views', 'skeleton');
        $this->publishes([
            __DIR__.'/../../views' => resource_path('views/vendor/skeleton'),
        ], 'views');
    }

    /**
     * Load skeleton translations.
     *
     * @return void
     */
    protected function loadTranslations()
    {
        $this->loadTranslationsFrom(__DIR__.'/../../translations', 'skeleton');
        $this->publishes([
            __DIR__.'/../../translations' => resource_path('lang/vendor/skeleton'),
        ], 'translations');
    }

    /**
     * Register the user observer.
     *
     * @return void
     */
    protected function registerUserObserver()
    {        
        $defaultGuard = Config::get("auth.defaults.guard");
        $guardProvider = Config::get("auth.guards.{$defaultGuard}.provider");
        $providerModel = Config::get("auth.providers.{$guardProvider}.model");
        $providerModel::observe(UserObserver::class);
    }

    /**
     * Register the activation token repository.
     *
     * @return void
     */
    protected function registerActivationTokenRepository()
    {
        $this->app->singleton('activations.repository', function ($app) {

            $key = $app['config']['app.key'];
            $config = $this->getActivationConfig($this->getActivationDefaultDriver());

            if (Str::startsWith($key, 'base64:')) {
                $key = base64_decode(substr($key, 7));
            }

            $connection = isset($config['connection']) ? $config['connection'] : null;

            return new ActivationTokenRepository(
                $app['db']->connection($connection),
                $config['table'],
                $key,
                $config['expire']
            );
        });
    }

    /**
     * Load custom form components.
     *
     * @return void
     */
    protected function loadFormComponents()
    {
        $aliasLoader = \Illuminate\Foundation\AliasLoader::getInstance();
        if (in_array(\Collective\Html\FormFacade::class, $aliasLoader->getAliases())) {
            \Form::component('dtDeleteButton', 'skeleton::datatables.delete-button', ['action']);

            \Form::component('bsText', 'skeleton::forms.bs.text', ['name', 'label', 'value', 'attributes' => []]);
            \Form::component('bsSelect', 'skeleton::forms.bs.select', ['name', 'label', 'options' => [], 'value', 'attributes' => []]);

            \Form::component('vueErrors', 'skeleton::forms.vue.errors', ['name']);
            
            \Form::component('vueHFButtonOpen', 'skeleton::forms.vue.horizontal-form-button-open', ['attributes' => []]);
            \Form::component('vueHFButtonClose', 'skeleton::forms.vue.horizontal-form-button-close', ['attributes' => []]);

            \Form::component('vueButton', 'skeleton::forms.vue.button', ['name', 'attributes' => []]);

            \Form::component('vueInputOpen', 'skeleton::forms.vue.input-open', ['name', 'label', 'attributes' => []]);
            \Form::component('vueInputClose', 'skeleton::forms.vue.input-close', ['name']);

            \Form::component('vueButon', 'skeleton::forms.vue.button', ['name', 'attributes' => []]);
            \Form::component('vueText', 'skeleton::forms.vue.text', ['model', 'attributes' => []]);
            \Form::component('vueSelect', 'skeleton::forms.vue.select', ['model', 'collection' => [], 'attributes' => [], 'label' => 'item.name', 'value' => 'item.id']);
            \Form::component('vueSwitch', 'skeleton::forms.vue.switch', ['model', 'attributes' => []]);
            \Form::component('vueDatePicker', 'skeleton::forms.vue.date-picker', ['model', 'attributes' => []]);
        }
    }

    /**
     * Get the password broker configuration.
     *
     * @param  string  $name
     * @return array
     */
    protected function getActivationConfig($name)
    {
        return $this->app['config']["skeleton.activations.{$name}"];
    }

    /**
     * Get the default password broker name.
     *
     * @return string
     */
    public function getActivationDefaultDriver()
    {
        return $this->app['config']['skeleton.defaults.activations'];
    }
}
