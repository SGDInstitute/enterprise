<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFloorsTable extends Migration
{
    public function up()
    {
        Schema::create('floors', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('location_id');
            $table->string('title')->nullable();
            $table->string('level');
            $table->string('floor_plan')->nullable();
            $table->timestamps();
        });
    }
}
