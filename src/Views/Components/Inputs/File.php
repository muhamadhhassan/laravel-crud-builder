<?php

namespace CrudBuilder\Views\Components\Inputs;

use Illuminate\View\Component;

class File extends Component
{
    public $mandatory;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(bool $mandatory = true)
    {
        $this->mandatory = $mandatory;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view(config('crudbuilder.views.inputs.file'));
    }
}
