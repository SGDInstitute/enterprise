<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCollaboratorsTable extends Migration
{
    public function up()
    {
        Schema::create('collaborators', function (Blueprint $table) {
            $table->foreignId('response_id')->constrained('responses');
            $table->foreignId('user_id')->constrained('users');

            $table->primary(['response_id', 'user_id']);
        });
    }
}
