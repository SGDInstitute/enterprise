<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAnswersToTickets extends Migration
{
    public function up()
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->json('answers')->after('user_id')->nullable();
        });
    }
}
