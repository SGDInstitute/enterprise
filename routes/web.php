<?php

use Illuminate\Support\Facades\Route;

Route::mediaLibrary();

Route::get('/', App\Http\Livewire\App\Home::class)->name('app.home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
