<?php

namespace App\Console\Commands;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Filesystem\Filesystem;

class BaseCustomCommand extends GeneratorCommand
{
    protected $signature = 'make:repository {name?}';
    protected $type_command;
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Filesystem $files)
    {
        parent::__construct($files);
    }

    protected function getStub()
    {
        $stub_file = $this->type_command . '/' . $this->type_command;
        if (in_array($this->convertInterfaceName(), ['BaseRepository', 'BaseService'])) {
            $stub_file .= '.base';
        }
        if (strpos($this->argument('name'), 'Interface')) {
            $stub_file .= '.interface';
        }
        $stub_file .= '.stub';
        return __DIR__ . '/template/' . $stub_file;
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        $upper_name_folder = $this->type_command === 'service' ? "\Services\\" : "\Repositories\\";
        if (!in_array($this->convertInterfaceName(), ['BaseRepository', 'BaseService'])) {
            return $rootNamespace . $upper_name_folder . $this->convertInterfaceName();
        }
        return $rootNamespace . $upper_name_folder;
    }

    private function convertInterfaceName()
    {
        return strpos($this->getNameInput(), 'Interface') ? str_replace('Interface', '', $this->getNameInput()) : $this->getNameInput();
    }

    protected function replaceNamespace(&$stub, $name)
    {
        $stub = str_replace(
            [
                'Dummy',
            ],
            [
                $this->convertInterfaceName(),
            ],
            $stub
        );

        return $this;
    }
}
