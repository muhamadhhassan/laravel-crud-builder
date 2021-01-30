<?php

namespace CrudBuilder\Views\Components\Utils;

use Illuminate\View\Component;

class ErrorMessage extends Component
{
    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view(config('crudbuilder.views.utils.error-message'));
    }
}
