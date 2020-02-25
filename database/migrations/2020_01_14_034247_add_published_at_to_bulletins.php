<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPublishedAtToBulletins extends Migration
{
    public function up()
    {
        Schema::table('bulletins', function (Blueprint $table) {
            $table->dateTime('published_at')->nullable();
        });
    }
}
