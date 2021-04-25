<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained('users');
            $table->foreignId('user_id')->constrained('users');
            $table->string('confirmation_number')->nullable();
            $table->string('transaction_id')->nullable();
            $table->string('amount')->nullable();
            $table->dateTime('reservation_ends')->nullable();
            $table->schemalessAttributes('settings');
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
