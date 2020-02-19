<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColorToActivityType extends Migration
{
    public function up()
    {
        Schema::table('activity_types', function (Blueprint $table) {
            $table->string('color')->nullable()->after('title');
        });
    }
}
