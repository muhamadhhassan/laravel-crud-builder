<?php

namespace CrudBuilder\Tests\Unit;

use CrudBuilder\Tests\TestCase;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Artisan;

class InstallPackageTest extends TestCase
{
    /** @test */
    function the_install_command_copies_the_configuration()
    {        
        // make sure we're starting from a clean state
        if (File::exists(config_path('crudbuilder.php'))) {
            unlink(config_path('crudbuilder.php'));
        }

        $this->assertFalse(File::exists(config_path('crudbuilder.php')));

        Artisan::call('crudbuilder:install');

        $this->assertTrue(File::exists(config_path('crudbuilder.php')));
    }
}