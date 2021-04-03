<?php

use Illuminate\Support\Facades\Route;

Route::mediaLibrary();

Route::get('/', App\Http\Livewire\App\Home::class)->name('app.home');
Route::get('/events/{event}', App\Http\Livewire\App\Events\Show::class)->name('app.events.show');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';

Route::middleware('auth')->group(function () {
    Route::get('/billing-portal', function () {
        return request()->user()->redirectToBillingPortal();
    });
});
