<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Console\GeneratorCommand;

class GenerateRepositoryServicePattern extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:rspattern {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate a repository service pattern';

    protected function getStub()
    {
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $count = 4;
        if (!$this->alreadyExists($this->argument('name') . 'Repository')) {
            $this->callSilent('make:repository', ['name' => $this->argument('name') . 'Repository']);
            $count--;
        }
        if (!$this->alreadyExists($this->argument('name') . 'Service')) {
            $this->callSilent('make:service', ['name' => $this->argument('name') . 'Service']);
            $count--;
        }
        if (!$this->alreadyExists($this->argument('name') . 'RepositoryInterface')) {
            $this->callSilent('make:repository', ['name' => $this->argument('name') . 'RepositoryInterface']);
            $count--;
        }
        if (!$this->alreadyExists($this->argument('name') . 'ServiceInterface')) {
            $this->callSilent('make:service', ['name' => $this->argument('name') . 'ServiceInterface']);
            $count--;
        }
        if (!$this->alreadyExists('BaseRepositoryInterface')) {
            $this->callSilent('make:repository', ['name' => 'BaseRepositoryInterface']);
        }
        if (!$this->alreadyExists('BaseRepository')) {
            $this->callSilent('make:repository', ['name' => 'BaseRepository']);
        }
        if (!$this->alreadyExists('BaseServiceInterface')) {
            $this->callSilent('make:service', ['name' => 'BaseServiceInterface']);
        }
        if (!$this->alreadyExists('BaseService')) {
            $this->callSilent('make:service', ['name' => 'BaseService']);
        }
        if ($count === 4) {
            $this->error($this->type . ' already exists!');
            return false;
        }
        return Command::SUCCESS;
    }
}
