<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDiscountsToTicketTypes extends Migration
{

    public function up()
    {
        Schema::table('ticket_types', function (Blueprint $table) {
            $table->string('type')->default('regular')->after('event_id');
            $table->unsignedInteger('num_tickets')->nullable()->after('cost');
        });
    }

    public function down()
    {
        Schema::table('ticket_types', function (Blueprint $table) {
            //
        });
    }
}