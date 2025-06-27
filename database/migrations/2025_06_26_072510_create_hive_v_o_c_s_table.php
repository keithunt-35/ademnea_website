<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHiveVocsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
public function up()
{
    Schema::create('hive_vocs', function (Blueprint $table) {
        $table->id();

        // make hive_id unsignedBigInteger and nullable if you want onDelete set null
        $table->unsignedBigInteger('hive_id')->nullable();

        // your record column
        $table->float('record');

        $table->timestamps();

        // foreign key constraint
        $table->foreign('hive_id')
              ->references('id')->on('hives')
              ->onDelete('set null');  // make sure hive_id is nullable to allow this
    });
}


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hive_vocs');
    }
}
