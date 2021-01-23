<?php

namespace CrudBuilder\Providers;

use CrudBuilder\Console\Install;
use Illuminate\Support\Facades\Blade;
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

        $this->loadViewsFrom(__DIR__.'/../resources/views', 'crudbuilder');

        Blade::componentNamespace('CrudBuilder\\Views\\Components', 'crudbuilder');
        
        if ($this->app->runningInConsole()) {
            $this->commands([
                Install::class,
                MakeController::class,
            ]);
        }
    }
}