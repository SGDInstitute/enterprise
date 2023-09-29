<?php

use App\Http\Controllers\InvitationController;
use App\Http\Controllers\SlackWebhookController;
use App\Http\Controllers\StripeWebhookController;
use App\Http\Middleware\VerifySlack;
use Illuminate\Support\Facades\Route;

Route::post('stripe/webhook', [StripeWebhookController::class, 'handleWebhook']);
Route::post('slack/webhook', [SlackWebhookController::class, 'handleWebhook'])->middleware(VerifySlack::class);

Route::get('impersonation/leave', App\Http\Controllers\ImpersonationController::class)->name('impersonation.leave');

Route::get('invitations/{invitation}', [InvitationController::class, 'accept'])->middleware(['signed'])->name('invitations.accept');

Route::get('/', App\Livewire\App\Home::class)->name('app.home');

Route::get('changelog', function () {
    return view('app.changelog', ['content' => markdown(app('files')->get(base_path('/CHANGELOG.md')))]);
});

Route::get('checkin/{ticket?}', App\Livewire\App\Checkin::class)->name('app.checkin');

Route::get('donations/create', App\Livewire\App\Donations\Create::class)->name('app.donations.create');
Route::get('donations/process', App\Http\Controllers\DonationsProcessController::class)->name('app.donations.process');

Route::get('events', App\Livewire\App\Events::class)->name('app.events');
Route::get('events/{event:slug}', App\Livewire\App\Events\Show::class)->name('app.events.show');
Route::get('orders/process', App\Http\Controllers\OrdersProcessController::class)->name('app.orders.process');

Route::get('forms/{form:slug}', App\Livewire\App\Forms\Show::class)->name('app.forms.show');
Route::get('forms/{form:slug}/finalize/{parent}', App\Livewire\App\Forms\Show::class)->name('app.forms.finalize');
Route::get('forms/{form:slug}/thank-you', App\Livewire\App\Forms\ThankYou::class)->name('app.forms.thanks');

Route::get('onsite-checkin', App\Livewire\App\OnsiteCheckin::class)->name('app.onsite-checkin');

require __DIR__ . '/auth.php';

Route::middleware('auth')->group(function () {
    Route::get('dashboard/{page?}', App\Livewire\App\Dashboard::class)->name('app.dashboard');
    Route::get('donations/{donation}', App\Livewire\App\Donations\Show::class)->name('app.donations.show');

    Route::get('billing-portal', function () {
        return request()->user()->redirectToBillingPortal();
    })->name('app.billing-portal');

    Route::get('reservations/{order}', App\Livewire\App\Orders\Show::class)->name('app.reservations.show');

    Route::get('orders/{order}/receipt', function (App\Models\Order $order) {
        return view('pdf.receipt', ['order' => $order]);
    })->name('app.orders.show.receipt');
    Route::get('orders/{order}/{page?}', App\Livewire\App\Orders\Show::class)->name('app.orders.show');

    Route::get('{event:slug}/program/{page?}', App\Livewire\App\Program::class)->name('app.program');
    Route::get('{event:slug}/program/schedule/{item:slug}', App\Livewire\App\Program\ScheduleItem::class)->name('app.program.schedule-item');

    Route::middleware(['verified', 'has-ticket'])->group(function () {
        Route::get('events/{event:slug}/message-board', App\Livewire\App\MessageBoard::class)->name('message-board');
    });

    Route::middleware(['verified'])->group(function () {
        Route::get('events/{event:slug}/volunteer', App\Livewire\App\Volunteer::class)->name('app.volunteer');
    });
});
