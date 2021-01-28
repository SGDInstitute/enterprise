<?php

use Illuminate\Support\Facades\Route;


Route::get('/', App\Http\Livewire\Galaxy\Dashboard::class)->name('galaxy.dashboard');
Route::get('/events', App\Http\Livewire\Galaxy\Events::class)->name('galaxy.events');
Route::get('/events/create', App\Http\Livewire\Galaxy\Events\Create::class)->name('galaxy.events.create');
