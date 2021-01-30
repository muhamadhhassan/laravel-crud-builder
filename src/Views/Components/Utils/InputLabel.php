<?php

namespace CrudBuilder\Views\Components\Utils;

use Illuminate\View\Component;

class InputLabel extends Component
{
    /**
     * The input name
     */
    public string $name;

    /**
     * The label to be displayed
     */
    public string $label;
    
    /**
     * Is the input mandatory
     */
    public bool $mandatory;

    public function __construct(string $name, string $label, bool $mandatory)
    {
        $this->name = $name;
        $this->label = $label;
        $this->mandatory = $mandatory;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view(config('crudbuilder.views.utils.input-label'));
    }
}
