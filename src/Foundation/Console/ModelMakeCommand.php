<?php

namespace Tecactus\Skeleton\Foundation\Console;

use Illuminate\Support\Str;
use Illuminate\Console\GeneratorCommand;
use Symfony\Component\Console\Input\InputOption;

class ModelMakeCommand extends GeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'skeleton:make-model';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new Eloquent model class with Skeleton resources';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Model';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function fire()
    {
        if (parent::fire() === false) {
            return;
        }

        $this->createMigration();

        $this->createController();

        $this->createDataTable();
    }

    /**
     * Create a migration file for the model.
     *
     * @return void
     */
    protected function createMigration()
    {
        $table = Str::plural(Str::snake(class_basename($this->argument('name'))));

        $this->call('make:migration', [
            'name' => "create_{$table}_table",
            '--create' => $table,
        ]);
    }

    /**
     * Create a controller for the model.
     *
     * @return void
     */
    protected function createController()
    {
        $controller = str_plural(Str::studly(class_basename($this->argument('name'))));

        $modelName = $this->qualifyClass($this->getNameInput());

        $this->call('skeleton:make-controller', [
            'name' => "{$controller}Controller",
            '--model' => $modelName,
        ]);
    }

    /**
     * Create a datatable for the model.
     *
     * @return void
     */
    protected function createDataTable()
    {
        $controller = Str::studly(class_basename($this->argument('name')));

        $modelName = $this->qualifyClass($this->getNameInput());

        $this->call('skeleton:make-datatable', [
            'name' => $modelName
        ]);
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__.'/stubs/model.stub';
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace;
    }
}
