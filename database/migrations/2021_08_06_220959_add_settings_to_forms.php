<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSettingsToForms extends Migration
{
    public function up()
    {
        Schema::table('forms', function (Blueprint $table) {
            $table->schemalessAttributes('settings')->after('form');
        });
    }
}
