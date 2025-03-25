<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBatteryReadingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('battery_readings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('hive_id');
            $table->float('voltage');
            $table->float('battery_percentage');
            $table->timestamp('measured_at');
            $table->timestamps();

            $table->foreign('hive_id')->references('id')->on('hives')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('battery_readings');
    }
}
