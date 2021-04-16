<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCollaboratorsTable extends Migration
{
    public function up()
    {
        Schema::create('collaborators', function (Blueprint $table) {
            $table->integer('response_id')->unsigned()->index();
            $table->foreign('response_id')->references('id')->on('responses')->onDelete('cascade');

            $table->integer('user_id')->unsigned()->index();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->primary(['user_id', 'role_id']);
        });
    }
}
