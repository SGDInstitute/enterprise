<?php

namespace App\Http\Livewire\App\Orders;

use Livewire\Component;

class Checklist extends Component
{
    public function render()
    {
        return view('livewire.app.orders.checklist', ['checklist' => $this->checklist]);
    }

    public function getChecklistProperty()
    {
        return [
            ['id' => 'estimate-cost', 'label' => 'Estimate your cost of attendance and secure funding'],
            ['id' => 'book-hotel', 'label' => 'Book your hotel'],
            ['id' => 'arrange-travel', 'label' => 'Arrange your travel'],
            ['id' => 'organize-group', 'label' => 'Coordinate a group sign-up with students from your school, college, or university'],
            ['id' => 'register-group', 'label' => 'Register your group'],
            ['id' => 'pay-for-order', 'label' => "Pay for your group's registration"],
            ['id' => 'fill-tickets', 'label' => 'Fill tickets with attendees information', 'description' => 'Please use a valid email so they can receive our emails and update their information with name or pronoun changes'],
            ['id' => 'distribute-info', 'label' => 'Distribute trip info to your group or make sure they receive our emails'],
            ['id' => 'schedule', 'label' => 'Make your schedule for the weekend'],
            ['id' => 'arrive', 'label' => 'Arrive and check in'],
        ];
    }
}
