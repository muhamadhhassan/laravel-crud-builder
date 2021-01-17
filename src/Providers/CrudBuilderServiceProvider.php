<?php

namespace CrudBuilder\Providers;

use CrudBuilder\Console\Install;
use CrudBuilder\Console\MakeController;
use Illuminate\Support\ServiceProvider;

class CrudBuilderServiceProvider extends ServiceProvider
{
    public function register()
    {
        
    }

    public function boot()
    {
        $this->publishes([
            __DIR__.'/../../config/config.php' => config_path('crudbuilder.php'),
        ], 'config');

        if ($this->app->runningInConsole()) {
            $this->commands([
                Install::class,
                MakeController::class,
            ]);
        }
    }
}