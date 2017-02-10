<?php

namespace Tecactus\Skeleton\Foundation\Console;

use Illuminate\Support\Str;
use Illuminate\Console\GeneratorCommand;
use Symfony\Component\Console\Input\InputOption;

class DatatableMakeCommand extends GeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'skeleton:make-datatable';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new DataTable for the given model class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'DataTable';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__.'/stubs/datatable.stub';
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace.'\DataTables';
    }

    /**
     * Get the destination class path.
     *
     * @param  string  $name
     * @return string
     */
    protected function getPath($name)
    {
        $name = str_replace_first($this->rootNamespace(), '', $name);

        if (! Str::startsWith($name, 'DataTables\\')){
            $name = 'DataTables\\' . $name;
        }

        $ssd = $this->laravel['path'].'/'.str_replace('\\', '/', $name).'DataTable.php';

        echo PHP_EOL . PHP_EOL . $name . PHP_EOL . PHP_EOL;
        echo PHP_EOL . PHP_EOL . $ssd . PHP_EOL . PHP_EOL;

        return $ssd;
    }
}
