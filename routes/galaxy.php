<?php

use Illuminate\Support\Facades\Route;


Route::get('/', App\Http\Livewire\Galaxy\Dashboard::class)->name('galaxy.dashboard');

Route::get('/events', App\Http\Livewire\Galaxy\Events::class)->name('galaxy.events');
Route::get('/events/create', App\Http\Livewire\Galaxy\Events\Create::class)->name('galaxy.events.create');
Route::get('/events/{event}/edit/{page?}', App\Http\Livewire\Galaxy\Events\Edit::class)->name('galaxy.events.edit');
Route::get('/events/{event}/slots/{item}', App\Http\Livewire\Galaxy\Events\Show\SLots::class)->name('galaxy.events.show.slots');
Route::get('/events/{event}/{page?}', App\Http\Livewire\Galaxy\Events\Show::class)->name('galaxy.events.show');

Route::get('/orders', App\Http\Livewire\Galaxy\Orders::class)->name('galaxy.orders');
Route::get('/orders/{order}', App\Http\Livewire\Galaxy\Orders\Show::class)->name('galaxy.orders.show');

Route::get('/reservations', App\Http\Livewire\Galaxy\Reservations::class)->name('galaxy.reservations');
Route::get('/reservations/{order}', App\Http\Livewire\Galaxy\Orders\Show::class)->name('galaxy.reservations.show');

Route::get('/responses/{response}', App\Http\Livewire\Galaxy\Responses\Show::class)->name('galaxy.responses.show');

Route::get('/ticket-types/create', App\Http\Livewire\Galaxy\TicketTypes\Form::class)->name('galaxy.ticket-types.create');
Route::get('/ticket-types/{ticketType}/edit', App\Http\Livewire\Galaxy\TicketTypes\Form::class)->name('galaxy.ticket-types.edit');

Route::get('/users', App\Http\Livewire\Galaxy\Users::class)->name('galaxy.users');
Route::get('/users/{user}/{page?}', App\Http\Livewire\Galaxy\Users\Show::class)->name('galaxy.users.show');
