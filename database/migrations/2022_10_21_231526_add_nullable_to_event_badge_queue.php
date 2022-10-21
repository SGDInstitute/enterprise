<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('event_badge_queue', function (Blueprint $table) {
            $table->foreignId('ticket_id')->nullable()->change();
            $table->foreignId('user_id')->nullable()->change();
            $table->string('email')->nullable()->change();
        });
    }
};
