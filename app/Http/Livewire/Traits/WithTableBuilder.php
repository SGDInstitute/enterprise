<?php

namespace App\Http\Livewire\Traits;

trait WithTableBuilder
{
    // Required Params
    // public $table;

    public function addColumn()
    {
        foreach($this->table as &$row) {
            $row[] = '';
        }
    }

    public function addRow()
    {
        $this->table[] = array_fill(0, count($this->table[0]), '');
    }
}
