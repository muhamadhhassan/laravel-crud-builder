<?php

return [

    'layouts' => [
        
        /**
         * The blade stack that a component script will be appended to
         * The stacks must be defined in your application main layout at the end of the body tag
         * more information about stacks here: https://laravel.com/docs/8.x/blade#stacks
         */
        'stacks' => [
            'scripts' => 'crud-builder-scripts',
        ],
    ],

    'views' => [

        /**
         * This defines where the default pages live
         * and will be used like this in the CRUDController "return view('crud.create')"
         */
        'pages' => [
            'create' => 'crud.create',
            'edit' => 'crud.edit',
            'index' => 'crud.index',
        ],

        /**
         * This determines the view of the input components
         * It is used in the component class
         */
        'inputs' => [
            'text' => 'crudbuilder::components.inputs.text',
            'test-area' => 'crudbuilder::components.inputs.text-area',
            'text-editor' => 'crudbuilder::components.inputs.text-editor',
            'select' => 'crudbuilder::components.inputs.select',
            'select-two' => 'crudbuilder::components.inputs.select-two',
            'radios' => 'crudbuilder::components.inputs.radios',
            'checkboxes' => 'crudbuilder::components.inputs.checkboxes',
            'date-range' => 'crudbuilder::components.inputs.date-range',
            'file' => 'crudbuilder::components.inputs.file',
            'image' => 'crudbuilder::components.inputs.image',
        ],

        /**
         * This determines the view of the utilities components
         * It is used in the component class
         */
        'utils' => [
            'error-message' => 'crudbuilder::components.utils.error-message',
            'help-text' => 'crudbuilder::components.utils.help-text',
            'input-label' => 'crudbuilder::components.utils.input-label',
            'index-table' => 'crudbuilder::components.utils.index-table',
        ],
    ],

];