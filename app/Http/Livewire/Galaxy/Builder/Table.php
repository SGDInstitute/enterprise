<?php

namespace App\Http\Livewire\Galaxy\Builder;

use Livewire\Component;

class Table extends Component
{
    public $table;
    public $model;

    public $rules = [
        'table' => 'required',
    ];

    public function mount($table, $model)
    {
        $this->table = $table->toArray();
        $this->model = $model;
    }

    public function render()
    {
        return view('livewire.galaxy.builder.table');
    }

    public function addColumn()
    {
        foreach ($this->table as $row => $column) {
            $this->table[$row][] = '';
        }
    }

    public function addRow()
    {
        $this->table[] = array_fill(0, count($this->table[0]), '');
    }

    public function smartDelete($row, $column)
    {
        if ($row === 0) {
            foreach ($this->table as $row => $columns) {
                unset($this->table[$row][$column]);
            }
        }
        if ($column === 0) {
            unset($this->table[$row]);
        }
    }

    public function save()
    {
        $this->model->form = $this->table;

        $this->model->save();
        $this->emit('notify', ['type' => 'success', 'message' => 'Successfully saved rubric table']);
    }
}
