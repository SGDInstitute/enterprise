<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActivityUserTable extends Migration
{
    public function up()
    {
        Schema::create('activity_user', function (Blueprint $table) {
            $table->unsignedBigInteger('activity_id');
            $table->unsignedInteger('user_id');
            $table->timestamps();
        });
    }
}
