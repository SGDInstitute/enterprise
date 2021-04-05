<?php

use Illuminate\Support\Facades\Route;

Route::mediaLibrary();

Route::get('/', App\Http\Livewire\App\Home::class)->name('app.home');
Route::get('/events/{event:slug}', App\Http\Livewire\App\Events\Show::class)->name('app.events.show');
Route::get('/forms/{form:slug}', App\Http\Livewire\App\Forms\Show::class)->name('app.forms.show');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';

Route::middleware('auth')->group(function () {
    Route::get('/billing-portal', function () {
        return request()->user()->redirectToBillingPortal();
    });
});
