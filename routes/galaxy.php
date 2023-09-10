<?php

use Illuminate\Support\Facades\Route;

Route::get('/', App\Livewire\Galaxy\Dashboard::class)->name('galaxy.dashboard');

Route::view('config/donations', 'livewire.galaxy.config.donations', ['title' => 'Configure Donations'])->name('galaxy.config.donations');
Route::view('config/emails', 'livewire.galaxy.config.emails', ['title' => 'Configure Emails'])->name('galaxy.config.emails');

Route::get('donations', App\Livewire\Galaxy\Donations::class)->name('galaxy.donations');
Route::get('donations/{donation}', App\Livewire\Galaxy\Donations\Show::class)->name('galaxy.donations.show');

Route::get('events', App\Livewire\Galaxy\Events::class)->name('galaxy.events');
Route::get('events/create', App\Livewire\Galaxy\Events\Create::class)->name('galaxy.events.create');
Route::get('events/{event}/queue', App\Livewire\Galaxy\Events\Edit\Queue::class)->name('galaxy.events.edit.queue');
Route::get('events/{event}/edit/{page?}', App\Livewire\Galaxy\Events\Edit::class)->name('galaxy.events.edit');
Route::get('events/{event}/slots/{item}', App\Livewire\Galaxy\Events\Edit\Slots::class)->name('galaxy.events.edit.slots');
Route::get('events/{event}/{page?}', App\Livewire\Galaxy\Events\Show::class)->name('galaxy.events.show');

Route::get('forms', App\Livewire\Galaxy\Forms::class)->name('galaxy.forms');
Route::get('forms/create', App\Livewire\Galaxy\Forms\Form::class)->name('galaxy.forms.create');
Route::get('forms/{form}/edit', App\Livewire\Galaxy\Forms\Form::class)->name('galaxy.forms.edit');

Route::get('orders', App\Livewire\Galaxy\Orders::class)->name('galaxy.orders');
Route::get('orders/{order}', App\Livewire\Galaxy\Orders\Show::class)->name('galaxy.orders.show');

Route::get('reservations', App\Livewire\Galaxy\Reservations::class)->name('galaxy.reservations');
Route::get('reservations/{order}', App\Livewire\Galaxy\Orders\Show::class)->name('galaxy.reservations.show');

Route::get('responses', App\Livewire\Galaxy\Responses::class)->name('galaxy.responses');
Route::get('responses/{response}', App\Livewire\Galaxy\Responses\Show::class)->name('galaxy.responses.show');

Route::get('surveys', App\Livewire\Galaxy\Surveys::class)->name('galaxy.surveys');
Route::get('surveys/create', App\Livewire\Galaxy\Surveys\Create::class)->name('galaxy.surveys.create');
Route::get('surveys/{survey}', App\Livewire\Galaxy\Surveys\Show::class)->name('galaxy.surveys.show');
Route::get('surveys/{survey}/edit', App\Livewire\Galaxy\Surveys\Edit::class)->name('galaxy.surveys.edit');

Route::get('ticket-types/create/flat', App\Livewire\Galaxy\TicketTypes\Flat::class)->name('galaxy.ticket-types.create.flat');
Route::get('ticket-types/create/scaled', App\Livewire\Galaxy\TicketTypes\Scaled::class)->name('galaxy.ticket-types.create.scaled');
Route::get('ticket-types/{ticketType}/edit', App\Livewire\Galaxy\TicketTypes\Form::class)->name('galaxy.ticket-types.edit');

Route::get('users', App\Livewire\Galaxy\Users::class)->name('galaxy.users');
Route::get('users/create', App\Livewire\Galaxy\Users\Create::class)->name('galaxy.users.create');
Route::get('users/{user}/{page?}', App\Livewire\Galaxy\Users\Show::class)->name('galaxy.users.show');
