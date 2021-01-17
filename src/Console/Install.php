<?php

namespace CrudBuilder\Console;

use Illuminate\Console\Command;

class Install extends Command
{
    protected $signature = 'crudbuilder:install';

    protected $description = 'Install Laravel CRUD builder';

    public function handle()
    {
        $this->info('Installing CRUD Builder...');

        $this->info('Publishing configuration...');

        $this->call('vendor:publish', [
            '--provider' => "CrudBuilder\Providers\CrudBuilderServiceProvider",
            '--tag' => "config"
        ]);

        $this->info('Installed CRUD builder');
    }
}