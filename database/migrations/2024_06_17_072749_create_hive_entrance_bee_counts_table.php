<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHiveEntranceBeeCountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hive_entrance_bee_counts', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('detected_bees');
            $table->unsignedBigInteger('hive_id');

            $table->foreign('hive_id')
                ->references('id')->on('hives')
                ->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hive_entrance_bee_counts');
    }
}