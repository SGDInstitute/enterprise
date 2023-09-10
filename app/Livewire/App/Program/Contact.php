<?php

namespace App\Livewire\App\Program;

use App\Mail\SupportEmail;
use App\Models\Event;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class Contact extends Component
{
    public Event $event;

    public $contact = [
        'name' => '',
        'pronouns' => '',
        'email' => '',
        'phone' => '',
        'subject' => '',
        'message' => '',
    ];

    public function mount()
    {
        $this->contact['name'] = auth()->user()->name;
        $this->contact['pronouns'] = auth()->user()->pronouns;
        $this->contact['email'] = auth()->user()->email;
    }

    public function render()
    {
        return view('livewire.app.program.contact');
    }

    public function contact()
    {
        Mail::to('support@sgdinstitute.org')->send(new SupportEmail($this->contact));

        $this->reset('contact');
        $this->dispatch('notify', ['message' => 'Successfully sent email to support.', 'type' => 'success']);
    }
}
