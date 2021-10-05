<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserScheduleTable extends Migration
{
    public function up()
    {
        Schema::create('user_schedule', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('event_id')->constrained('events');
            $table->foreignId('item_id')->constrained('event_items');
        });
    }
}
