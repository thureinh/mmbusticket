<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItineraryLocationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('itinerary_location', function (Blueprint $table) {
            $table->id();
            $table->foreignId('itinerary_id')
                  ->nullable(false)
                  ->constrained()
                  ->onDelete('cascade');
            $table->foreignId('location_id')
                  ->nullable(false)
                  ->constrained()
                  ->onDelete('cascade');
            $table->unsignedTinyInteger('sequence_number');
            $table->mediumText('extra_info');
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
        Schema::dropIfExists('itinerary_location');
    }
}
