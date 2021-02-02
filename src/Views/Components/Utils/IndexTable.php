<?php

namespace CrudBuilder\Views\Components\Utils;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\Component;

class IndexTable extends Component
{

    
    /**
     * The records to be listed in the table.
     *
     * @var \Illuminate\Pagination\LengthAwarePaginator
     */
    public $records;
    
    /**
     * array of table columns
     */
    public array $columns;

    /**
     * the property that is used as label.
     */
    public string $labeledBy;

    /**
     * are the records editable.
     *
     * @var bool
     */
    public bool $editable;
    
    /**
     * are the records deletable
     *
     * @var bool
     */
    public bool $deletable;

    /**
     * The resource routes to be used in edit and delete actions
     * 
     * @var string
     */
    public string $route;


    /**
     * Create a new component instance.
     *
     * @param \Illuminate\Pagination\LengthAwarePaginator $records
     * @param boolean $editable
     * @param boolean $deletable
     * @param string $route
     */
    public function __construct(LengthAwarePaginator $records, array $columns, string $labeledBy, bool $editable, bool $deletable, string $route)
    {
        $this->records = $records;
        $this->columns = $columns;
        $this->labeledBy = $labeledBy;
        $this->editable = $editable;
        $this->deletable = $deletable;
        $this->route = $route;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view(config('crudbuilder.views.utils.index-table'));
    }
}
