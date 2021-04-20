<?php

use Illuminate\Support\Facades\Route;


Route::get('/', App\Http\Livewire\Galaxy\Dashboard::class)->name('galaxy.dashboard');
Route::get('/events', App\Http\Livewire\Galaxy\Events::class)->name('galaxy.events');
Route::get('/events/create', App\Http\Livewire\Galaxy\Events\Create::class)->name('galaxy.events.create');
Route::get('/events/{event}/edit/{page?}', App\Http\Livewire\Galaxy\Events\Edit::class)->name('galaxy.events.edit');
Route::get('/events/{event}/{page?}', App\Http\Livewire\Galaxy\Events\Show::class)->name('galaxy.events.show');

Route::get('/responses/{response}', App\Http\Livewire\Galaxy\Responses\Show::class)->name('galaxy.responses.show');
