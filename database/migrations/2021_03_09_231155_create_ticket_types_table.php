<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketTypesTable extends Migration
{
    public function up()
    {
        Schema::create('ticket_types', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained('events');
            $table->string('stripe_product_id')->nullable();
            $table->string('name');
            $table->string('description')->nullable();
            $table->string('structure')->nullable();
            $table->dateTime('start');
            $table->dateTime('end');
            $table->string('timezone');
            $table->timestamps();
        });
    }
}
