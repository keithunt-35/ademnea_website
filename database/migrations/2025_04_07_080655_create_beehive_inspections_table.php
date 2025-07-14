<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBeehiveInspectionsTable extends Migration
{
    public function up()
    {
        Schema::create('beehive_inspections', function (Blueprint $table) {
            $table->id();

            $table->string('hiveId');
            $table->dateTime('inspection_date');
            $table->string('inspector_name');
            $table->string('weather_conditions');

            // Hive Info
            $table->string('hive_type');
            $table->string('hive_condition');
            $table->string('queen_presence');
            $table->string('queen_cells');
            $table->string('brood_pattern');
            $table->string('eggs_larvae');
            $table->string('honey_stores');
            $table->string('pollen_stores');

            // Colony Health
            $table->string('bee_population');
            $table->string('aggressiveness');
            $table->string('diseases_observed');
            $table->string('diseases_specify')->nullable();
            $table->string('pests_present')->nullable();

            // Maintenance
            $table->string('frames_checked');
            $table->string('frames_replaced');
            $table->string('hive_cleaned');
            $table->string('supers_changed');
            $table->string('other_actions')->nullable();

            // Comments
            $table->text('comments')->nullable();

            $table->timestamps(); // created_at, updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('beehive_inspections');
    }
}
