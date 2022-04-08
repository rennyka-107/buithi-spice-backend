<?php

namespace App\Console\Commands;

class CreateService extends BaseCustomCommand
{
    protected $type_command = 'service';
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:service {name=BaseService}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create service';
}
