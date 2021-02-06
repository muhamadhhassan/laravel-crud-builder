<?php

namespace CrudBuilder\Foundation;

use CrudBuilder\Helpers\IndexColumn;

class Listing
{
    /**
     * The columns that will be in the index page.
     *
     * @var array
     */
    public $columns = [];

    /**
     * Add a column(s) to the index columns array.
     *
     * @param mixed $columns
     * 
     * @return void
     */
    public function addColumns($columns): void
    {
        if (! is_array($columns)) {
            $this->addColumn($columns);

            return;
        }

        foreach ($columns as $column) {
            $this->addColumn($column);
        }
    }

    /**
     * Push a column to the index column array.
     *
     * @param \CrudBuilder\Helpers\IndexColumn $column
     * @return Void
     */
    protected function addColumn(IndexColumn $column): Void
    {
        array_push($this->columns, $column);
    }
}