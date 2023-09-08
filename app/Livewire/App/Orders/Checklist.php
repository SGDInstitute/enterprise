<?php

namespace App\Livewire\App\Orders;

use Livewire\Component;

class Checklist extends Component
{
    public function render()
    {
        return view('livewire.app.orders.checklist', ['checklist' => $this->checklist]);
    }

    public function getChecklistProperty()
    {
        // create, pay, fill
        return [
            ['id' => 'create-order', 'label' => 'Create your order'],
            ['id' => 'fill-tickets', 'label' => 'Assign tickets to attendees', 'description' => 'Please use a valid email so they can receive our emails and update their information with name or pronoun changes'],
            ['id' => 'pay', 'label' => 'Pay for your order'],
            ['id' => 'travel', 'label' => 'Arrange your travel'],
            ['id' => 'book-hotel', 'label' => 'Book your hotel'],
            ['id' => 'schedule', 'label' => 'Make your schedule for the weekend'],
            ['id' => 'arrive', 'label' => 'Arrive and check in'],
        ];
    }
}
