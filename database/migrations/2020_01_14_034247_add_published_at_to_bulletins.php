<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPublishedAtToBulletins extends Migration
{
    public function up()
    {
        Schema::table('bulletins', function (Blueprint $table) {
            $table->dateTime('published_at')->nullable();
        });
    }
}
