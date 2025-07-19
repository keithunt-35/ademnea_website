<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusColumnsToHivesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
{
    Schema::table('hives', function (Blueprint $table) {
        $table->boolean('connected')->default(true); // initial sensor reading
        $table->boolean('colonized')->default(true); // initial sensor reading
    });
}

public function down()
{
    Schema::table('hives', function (Blueprint $table) {
        $table->dropColumn(['connected', 'colonized']);
    });
}

}
