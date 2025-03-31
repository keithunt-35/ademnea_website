<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBatteriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('batteries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hive_id')->constrained()->onDelete('cascade');  // foreign key relation to Hive
            $table->decimal('voltage', 8, 2);  // Example field for battery voltage
            $table->integer('battery_percentage');  // Example field for battery percentage
            $table->timestamp('measured_at');  // Timestamp for when the reading was taken
            $table->timestamps();  // Laravel's default created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('batteries');
    }
}
