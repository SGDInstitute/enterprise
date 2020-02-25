 <?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    class AddLocationIdToActivitiesTable extends Migration
    {
        public function up()
        {
            Schema::table('activities', function (Blueprint $table) {
                $table->unsignedBigInteger('location_id')->nullable()->after('description');

                $table->foreign('location_id')
                    ->references('id')->on('locations');
            });
        }
    }
