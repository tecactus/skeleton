<?php

namespace Tecactus\Skeleton\Console;

use Illuminate\Console\Command;
use Illuminate\Console\DetectsApplicationNamespace;

class InstallCommand extends Command
{
    use DetectsApplicationNamespace;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'skeleton:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Instala Skeleton en la aplicación actual';

    /**
     * The skeleton directory list.
     *
     * @var array
     */
    protected $directories = [
        'public/images',
        'public/fonts',
        'public/css',
        'public/images',
        'resources/assets/js/datatables',
        'resources/views/layouts',
        'resources/views/auth/passwords',
        'resources/views/users',
        'app/Http/Requests',
        'app/DataTables',
    ];

    /**
     * The migrations that need to be exported.
     *
     * @var array
     */
    protected $migrations = [
        '2014_10_11_000000_create_user_types_table.stub' => '2014_10_11_000000_create_user_types_table.php',
        '2014_10_12_000000_create_users_table.stub' => '2014_10_12_000000_create_users_table.php',
        '2014_10_12_200000_create_account_activations_table.stub' => '2014_10_12_200000_create_account_activations_table.php',
    ];

    /**
     * The seeds that need to be exported.
     *
     * @var array
     */
    protected $seeds = [
        'DatabaseSeeder.stub' => 'DatabaseSeeder.php',
        'UserTypesTableSeeder.stub' => 'UserTypesTableSeeder.php',
        'UsersTableSeeder.stub' => 'UsersTableSeeder.php',
    ];

    /**
     * The configs that need to be exported.
     *
     * @var array
     */
    protected $configs = [
        'datatables-buttons.php' => 'datatables-buttons.php',
        'datatables.php' => 'datatables.php',
        'excel.php' => 'excel.php',
        'skeleton.php' => 'skeleton.php',
        'snappy.php' => 'snappy.php',
    ];

    /**
     * The models that need to be exported.
     *
     * @var array
     */
    protected $models = [
        'UserType.stub' => 'UserType.php',
    ];

    /**
     * The controllers that need to be exported.
     *
     * @var array
     */
    protected $controllers = [
        'auth/ActivateAccountController.stub' => 'Auth/ActivateAccountController.php',
        'HomeController.stub' => 'HomeController.php',
        'UserTypesController.stub' => 'UserTypesController.php',
        'UsersController.stub' => 'UsersController.php',
    ];

    /**
     * The requests that need to be exported.
     *
     * @var array
     */
    protected $requests = [
        'UserRequest.stub' => 'UserRequest.php',
    ];

    /**
     * The datatables that need to be exported.
     *
     * @var array
     */
    protected $datatables = [
        'UserDataTable.stub' => 'UserDataTable.php',
        'UserTypeDataTable.stub' => 'UserTypeDataTable.php',
    ];

    /**
     * The views that need to be exported.
     *
     * @var array
     */
    protected $views = [
        'auth/login.blade.php' => 'auth/login.blade.php',
        'auth/register.blade.php' => 'auth/register.blade.php',
        'auth/passwords/email.blade.php' => 'auth/passwords/email.blade.php',
        'auth/passwords/reset.blade.php' => 'auth/passwords/reset.blade.php',
        'users/creation-form.blade.php' => 'users/creation-form.blade.php',
        'layouts/app.blade.php' => 'layouts/app.blade.php',
        'home.blade.php' => 'home.blade.php',
        'welcome.blade.php' => 'welcome.blade.php',
    ];

    /**
     * The routes that need to be exported.
     *
     * @var array
     */
    protected $routes = [
        'api.php' => 'api.php',
        'web.php' => 'web.php',
    ];

    /**
     * The assets that need to be exported.
     *
     * @var array
     */
    protected $assets = [
        'js/datatables/buttons.server-side.js' => 'js/datatables/buttons.server-side.js',
    ];

    /**
     * The public assets that need to be exported.
     *
     * @var array
     */
    protected $publicAssets = [
        'css/app.css' => 'css/app.css',
        'js/app.js' => 'js/app.js',
        'images/logo.png' => 'images/logo.png',
        'images/logo_white.png' => 'images/logo_white.png',
        'fonts/element-icons.eot' => 'fonts/element-icons.eot',
        'fonts/element-icons.ttf' => 'fonts/element-icons.ttf',
        'fonts/fontawesome-webfont.eot' => 'fonts/fontawesome-webfont.eot',
        'fonts/fontawesome-webfont.ttf' => 'fonts/fontawesome-webfont.ttf',
        'fonts/fontawesome-webfont.woff2' => 'fonts/fontawesome-webfont.woff2',
        'fonts/glyphicons-halflings-regular.svg' => 'fonts/glyphicons-halflings-regular.svg',
        'fonts/glyphicons-halflings-regular.woff' => 'fonts/glyphicons-halflings-regular.woff',
        'fonts/element-icons.svg' => 'fonts/element-icons.svg',
        'fonts/element-icons.woff' => 'fonts/element-icons.woff',
        'fonts/fontawesome-webfont.svg' => 'fonts/fontawesome-webfont.svg',
        'fonts/fontawesome-webfont.woff' => 'fonts/fontawesome-webfont.woff',
        'fonts/glyphicons-halflings-regular.eot' => 'fonts/glyphicons-halflings-regular.eot',
        'fonts/glyphicons-halflings-regular.ttf' => 'fonts/glyphicons-halflings-regular.ttf',
        'fonts/glyphicons-halflings-regular.woff2' => 'fonts/glyphicons-halflings-regular.woff2',
    ];

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function fire()
    {
        $this->createDirectories();
        $this->exportMigrations();
        $this->exportSeeds();
        $this->exportModels();
        $this->exportControllers();
        $this->exportRequests();
        $this->exportDatatables();
        $this->exportViews();
        $this->exportRoutes();
        $this->exportAssets();
        $this->exportPublicAssets();
        $this->setReferencesOnAuthControllers();
    }

    protected function setReferencesOnAuthControllers()
    {
        $this->setAuthControllers();
        $this->exportConfigurations();
        $this->commentTranslationServiceProvider();
    }

    protected function setAuthControllers()
    {
        file_put_contents(
            app_path('Http/Controllers/Auth/RegisterController.php'),
            str_replace(
                'use Illuminate\Foundation\Auth\RegistersUsers',
                'use Tecactus\Skeleton\Foundation\Auth\RegistersUsers',
                file_get_contents(app_path('Http/Controllers/Auth/RegisterController.php'))
            )
        );
        
        file_put_contents(
            app_path('Http/Controllers/Auth/LoginController.php'),
            str_replace(
                'use Illuminate\Foundation\Auth\AuthenticatesUsers',
                'use Tecactus\Skeleton\Foundation\Auth\AuthenticatesUsers',
                file_get_contents(app_path('Http/Controllers/Auth/LoginController.php'))
            )
        );
        
        file_put_contents(
            app_path('Http/Controllers/Auth/ForgotPasswordController.php'),
            str_replace(
                'use Illuminate\Foundation\Auth\SendsPasswordResetEmails',
                'use Tecactus\Skeleton\Foundation\Auth\SendsPasswordResetEmails',
                file_get_contents(app_path('Http/Controllers/Auth/ForgotPasswordController.php'))
            )
        );
    }

    protected function exportConfigurations()
    {
        foreach ($this->configs as $key => $value) {
            copy(
                __DIR__.'/stubs/config/'.$key,
                config_path($value)
            );
        }
    }

    protected function commentTranslationServiceProvider()
    {
        if (strpos(file_get_contents(config_path('app.php')), "// Illuminate\Translation\TranslationServiceProvider::class,") == false) {
            $searchTranslationServiceProvider = "Illuminate\Translation\TranslationServiceProvider::class,";
            $replaceTranslationServiceProvider = "// Illuminate\Translation\TranslationServiceProvider::class,";

            file_put_contents(
                config_path('app.php'),
                str_replace(
                    $searchTranslationServiceProvider,
                    $replaceTranslationServiceProvider,
                    file_get_contents(config_path('app.php'))
                )
            );
        }
    }

    protected function setUserModel()
    {
        $searchReferences = "use Illuminate\Foundation\Auth\User as Authenticatable;";
        $replaceReferences = "use Tecactus\Skeleton\Foundation\Auth\User as Authenticatable;";

        file_put_contents(
            app_path('User.php'),
            str_replace(
                $searchReferences,
                $replaceReferences,
                file_get_contents(app_path('User.php'))
            )
        );

        if (strpos(file_get_contents(app_path('User.php')), "'user_type_id', 'api_token',") == false) {

            $searchFillable = "'name', 'email', 'password',";
            $replaceFillable = "'name', 'email', 'password', 'user_type_id', 'api_token',";

            file_put_contents(
                app_path('User.php'),
                str_replace(
                    $searchFillable,
                    $replaceFillable,
                    file_get_contents(app_path('User.php'))
                )
            );

        }

        if (! method_exists($this->getAppNamespace() . 'User', 'user_type')) {

            $searchEndOfFile = <<<EOD
}
EOD;
            $replaceEndOfFile = <<<EOD

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected \$with = [
        'user_type',
    ];

    /**
     * Get the user's type.
     */
    public function user_type()
    {
        return \$this->belongsTo(UserType::class);
    }
}
EOD;
            file_put_contents(
                app_path('User.php'),
                last_str_replace(
                    $searchEndOfFile,
                    $replaceEndOfFile,
                    file_get_contents(app_path('User.php'))
                )
            );

        }

        if (! method_exists($this->getAppNamespace() . 'User', 'getIsAdminAttribute')) {

            $searchEndOfFile = <<<EOD
}
EOD;
            $replaceEndOfFile = <<<EOD

    /**
     * Admin verification attribute accesor.
     * @return boolean
     */
    public function getIsAdminAttribute()
    {
        return \$this->user_type_id == UserType::ADMIN;
    }
}
EOD;
            file_put_contents(
                app_path('User.php'),
                last_str_replace(
                    $searchEndOfFile,
                    $replaceEndOfFile,
                    file_get_contents(app_path('User.php'))
                )
            );

            $searchAppends = <<<EOD
    /**
     * Get the user's type.
     */
EOD;
            $replaceAppends = <<<EOD
    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected \$appends = [
        'is_admin'
    ];

    /**
     * Get the user's type.
     */
EOD;
            file_put_contents(
                app_path('User.php'),
                last_str_replace(
                    $searchAppends,
                    $replaceAppends,
                    file_get_contents(app_path('User.php'))
                )
            );

        }

    }

    /**
     * Export the skeleton migrations.
     *
     * @return void
     */
    protected function exportMigrations()
    {
        foreach ($this->migrations as $key => $value) {
            copy(
                __DIR__.'/stubs/database/migrations/'.$key,
                base_path('database/migrations/'.$value)
            );
        }
    }

    /**
     * Export the skeleton seeds.
     *
     * @return void
     */
    protected function exportSeeds()
    {
        foreach ($this->seeds as $key => $value) {
            file_put_contents(
                base_path('database/seeds/'.$value),       
                $this->setNamespaceOnStub(__DIR__.'/stubs/database/seeds/'.$key, true)
            );
        }
    }

    /**
     * Export the skeleton controllers.
     *
     * @return void
     */
    protected function exportControllers()
    {
        foreach ($this->controllers as $key => $value) {
            file_put_contents(
                app_path('Http/Controllers/'.$value),
                $this->setNamespaceOnStub(__DIR__.'/stubs/app/controllers/'.$key, true)
            );
        }
    }

    /**
     * Export the skeleton requests.
     *
     * @return void
     */
    protected function exportRequests()
    {
        foreach ($this->requests as $key => $value) {
            file_put_contents(
                app_path('Http/Requests/'.$value),
                $this->setNamespaceOnStub(__DIR__.'/stubs/app/requests/'.$key, true)
            );
        }
    }

    /**
     * Export the skeleton datatables.
     *
     * @return void
     */
    protected function exportDatatables()
    {
        foreach ($this->datatables as $key => $value) {
            file_put_contents(
                app_path('DataTables/'.$value),
                $this->setNamespaceOnStub(__DIR__.'/stubs/app/datatables/'.$key, true)
            );
        }
    }

    /**
     * Export the skeleton models.
     *
     * @return void
     */
    protected function exportModels()
    {
        foreach ($this->models as $key => $value) {
            file_put_contents(
                base_path('app/'.$value),        
                $this->setNamespaceOnStub(__DIR__.'/stubs/app/models/'.$key, true)
            );
        }
        $this->setUserModel();
    }

    /**
     * Export the skeleton views.
     *
     * @return void
     */
    protected function exportViews()
    {
        foreach ($this->views as $key => $value) {
            copy(
                __DIR__.'/stubs/views/'.$key,
                base_path('resources/views/'.$value)
            );
        }
    }

    /**
     * Export the skeleton routes.
     *
     * @return void
     */
    protected function exportRoutes()
    {
        foreach ($this->routes as $key => $value) {
            copy(
                __DIR__.'/stubs/routes/'.$key,
                base_path('routes/'.$value)
            );
        }
    }

    /**
     * Export the skeleton assets.
     *
     * @return void
     */
    protected function exportAssets()
    {
        foreach ($this->assets as $key => $value) {
            copy(
                __DIR__.'/stubs/resources/assets/'.$key,
                base_path('resources/assets/'.$value)
            );
        }
    }

    /**
     * Export the skeleton public assets.
     *
     * @return void
     */
    protected function exportPublicAssets()
    {
        foreach ($this->publicAssets as $key => $value) {
            copy(
                __DIR__.'/stubs/public/'.$key,
                base_path('public/'.$value)
            );
        }
    }

    /**
     * Set namespace on stub.
     *
     * @return string
     */
    protected function setNamespaceOnStub($stub, $justNamespace)
    {
        return str_replace(
            '{{namespace}}',
            ($justNamespace ? str_replace('\\', '', $this->getAppNamespace()) : $this->getAppNamespace()),
            file_get_contents($stub)
        );
    }

    /**
     * Create the directories for the files.
     *
     * @return void
     */
    protected function createDirectories()
    {
        foreach ($this->directories as $directory) {
            if (! is_dir(base_path($directory))) {
                mkdir(base_path($directory), 0755, true);
            }
        }
    }
}
