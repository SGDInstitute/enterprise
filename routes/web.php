<?php

use App\Http\Controllers\WebhookController;
use Illuminate\Support\Facades\Route;


Route::post('/stripe/webhook',[WebhookController::class, 'handleWebhook']);

Route::mediaLibrary();

Route::get('/', App\Http\Livewire\App\Home::class)->name('app.home');

Route::get('/donations/create/{type?}', App\Http\Livewire\App\Donations\Create::class)->name('app.donations.create');

Route::get('/events', App\Http\Livewire\App\Events::class)->name('app.events');
Route::get('/events/{event:slug}', App\Http\Livewire\App\Events\Show::class)->name('app.events.show');

Route::get('/forms/{form:slug}', App\Http\Livewire\App\Forms\Show::class)->name('app.forms.show');

require __DIR__.'/auth.php';

Route::middleware('auth')->group(function () {
    Route::get('/dashboard/{page?}', App\Http\Livewire\App\Dashboard::class)->name('app.dashboard');

    Route::get('/billing-portal', function () {
        return request()->user()->redirectToBillingPortal();
    })->name('app.billing-portal');

    Route::get('/reservations/{order}', App\Http\Livewire\App\Orders\Show::class)->name('app.reservations.show');

    Route::get('/orders/{order}', App\Http\Livewire\App\Orders\Show::class)->name('app.orders.show');
    Route::get('/orders/{order}/receipt', function(App\Models\Order $order) {
        return view('pdf.receipt', ['order' => $order]);
    })->name('app.orders.show.receipt');
});
