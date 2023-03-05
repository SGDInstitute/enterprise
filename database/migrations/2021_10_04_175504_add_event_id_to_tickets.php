<?php

use App\Models\Ticket;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->foreignId('event_id')->nullable()->after('order_id')->constrained('events');
        });

        Ticket::with('order:id,event_id')->get()
            ->each(function ($ticket) {
                if ($ticket->order) {
                    $ticket->event_id = $ticket->order->event_id;
                    $ticket->save();
                } else {
                    $ticket->event_id = $ticket->order()->withTrashed()->first()->event_id;
                    $ticket->save();
                }
            });
    }
};
