<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('event_badge_queue', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ticket_id')->constrained('tickets');
            $table->foreignId('user_id')->constrained('users');
            $table->string('name');
            $table->string('pronouns')->nullable();
            $table->string('email');
            $table->boolean('printed')->default(false);
            $table->timestamps();
        });
    }
};
