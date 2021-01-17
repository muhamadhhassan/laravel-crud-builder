<?php

namespace CrudBuilder\Providers;

use CrudBuilder\Console\MakeController;
use Illuminate\Support\ServiceProvider;

class CrudBuilderServiceProvider extends ServiceProvider
{
    public function register()
    {
        
    }

    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                MakeController::class,
            ]);
        }
    }
}