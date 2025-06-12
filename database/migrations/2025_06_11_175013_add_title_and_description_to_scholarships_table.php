<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTitleAndDescriptionToScholarshipsTable extends Migration
{
    public function up()
    {
        Schema::table('scholarships', function (Blueprint $table) {
            // Add new columns
            $table->string('title')->nullable()->after('category');
            $table->text('description')->nullable()->after('title');

            // Remove unwanted columns
            $table->dropColumn('country');
            $table->dropColumn('category');
        });
    }

    public function down()
    {
        Schema::table('scholarships', function (Blueprint $table) {
            // Reverse the changes
            $table->dropColumn('title');
            $table->dropColumn('description');

            $table->string('country')->nullable();
            $table->string('category')->nullable();
        });
    }
}
