<?php

namespace CrudBuilder\Console;

use Illuminate\Console\GeneratorCommand;

class MakeController extends GeneratorCommand
{
    protected $name = 'make:crud-controller';

    protected $description = 'create a controller that extends the base CRUDController';

    protected $type = 'CRUDController';

    protected function getStub()
    {
        return __DIR__.'./stubs/crud-controller';
    }

    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace.'\Http\Controllers';
    }

    public function handle()
    {
        parent::handle();

        $this->createController();
    }

    public function createController()
    {
        // Get the fully qualified class name (FQN)
        $class = $this->qualifyClass($this->getNameInput());

        // get the destination path, based on the default namespace
        $path = $this->getPath($class);

        $content = file_get_contents($path);

        // Update the file content with additional data (regular expressions)

        file_put_contents($path, $content);
    }
}