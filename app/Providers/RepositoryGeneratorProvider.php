<?php

namespace App\Providers;

use App\Console\Commands\CreateRepository;
use App\Console\Commands\CreateRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryGeneratorProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                CreateRepository::class,
            ]);
        }
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * 获取由提供者提供的服务。
     *
     * @return array
     */
    public function provides()
    {
        return [CreateRepository::class, CreateRepositoryInterface::class];
    }
}
