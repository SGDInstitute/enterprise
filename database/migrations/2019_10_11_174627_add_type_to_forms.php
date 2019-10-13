<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTypeToForms extends Migration
{

    public function up()
    {
        Schema::table('forms', function (Blueprint $table) {
            $table->string('type')->nullable()->after('name');
        });
    }
}
