<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColorToActivityType extends Migration
{
    public function up()
    {
        Schema::table('activity_types', function (Blueprint $table) {
            $table->string('color')->nullable()->after('title');
        });
    }
}
