<?php

namespace App\Console\Commands;

class CreateRepository extends BaseCustomCommand
{
    protected $type_command = 'repository';
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:repository {name=BaseRepository}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create repository';
}
