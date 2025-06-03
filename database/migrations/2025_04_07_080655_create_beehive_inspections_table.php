<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBeehiveInspectionsTable extends Migration
{
    public function up()
    {
        Schema::create('beehive_inspections', function (Blueprint $table) {
            $table->id();  // Auto-incrementing ID
            $table->string('beekeeper_name');
            $table->date('date');
            $table->string('apiary_location');
            $table->string('weather_conditions');

            // Hive Information
            $table->string('hive_id');
            $table->string('hive_type');
            $table->string('hive_condition');
            $table->enum('presence_of_queen', ['Yes', 'No']);
            $table->enum('queen_cells_present', ['Yes', 'No']);
            $table->string('brood_pattern');
            $table->enum('eggs_and_larvae_present', ['Yes', 'No']);
            $table->string('honey_stores');
            $table->string('pollen_stores');

            // Colony Health & Activity
            $table->string('bee_population');
            $table->string('aggressiveness_of_bees');
            $table->enum('diseases_or_pests_observed', ['Yes', 'No']);
            $table->string('disease_details')->nullable();
            $table->enum('presence_of_beetles', ['Yes', 'No']);
            $table->enum('presence_of_other_pests', ['Yes', 'No']);

            // Maintenance & Actions Taken
            $table->integer('frames_checked');
            $table->enum('any_frames_replaced', ['Yes', 'No']);
            $table->enum('hive_cleaned', ['Yes', 'No']);
            $table->enum('supers_added_or_removed', ['Yes', 'No']);
            $table->text('any_other_actions_taken')->nullable();

            // General Comments & Recommendations
            $table->text('comments_and_recommendations')->nullable();

            // Inspected by and Signature
            $table->string('inspected_by');
            $table->string('signature')->nullable();

            $table->timestamps();  // created_at and updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('beehive_inspections');
    }
}

