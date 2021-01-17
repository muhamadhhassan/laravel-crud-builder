<?php

namespace CrudBuilder\Tests\Feature;

use CrudBuilder\Tests\TestCase;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Artisan;

class MakeControllerCommandTest extends TestCase
{
    /** @test */
    function it_creates_a_new_crud_controller_class()
    {
        // destination path of the Foo class
        $testController = app_path('Http/Controllers/Admin/TestController.php');

        // make sure we're starting from a clean state
        if (File::exists($testController)) {
            unlink($testController);
        }

        $this->assertFalse(File::exists($testController));

        // Run the make command
        Artisan::call('make:crud-controller Admin/TestController');

        // Assert a new file is created
        $this->assertTrue(File::exists($testController));

        // Assert the file contains the right contents
        $expectedContents = <<<CLASS
<?php

namespace App\Http\Controllers\Admin;

use CrudBuilder\Controllers\CRUDController;

class TestController extends CRUDController
{
    public function setup()
    {
        // setup your resource
    }
}
CLASS;

        $this->assertEquals($expectedContents, file_get_contents($testController));
    }
}