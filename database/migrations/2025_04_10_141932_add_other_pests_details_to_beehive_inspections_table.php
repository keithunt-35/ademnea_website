<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOtherPestsDetailsToBeehiveInspectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('beehive_inspections', function (Blueprint $table) {
            $table->string('other_pests_details')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('beehive_inspections', function (Blueprint $table) {
            $table->dropColumn('other_pests_details');
        });
    }
    
}
