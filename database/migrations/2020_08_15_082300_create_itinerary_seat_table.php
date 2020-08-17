<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItinerarySeatTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('itinerary_seat', function (Blueprint $table) {
            $table->id();
            $table->foreignId('itinerary_id')
                  ->nullable(false)
                  ->constrained()
                  ->onDelete('cascade');
            $table->foreignId('seat_id')
                  ->nullable(false)
                  ->constrained()
                  ->onDelete('cascade');
            $table->string('status', 100);
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
        Schema::dropIfExists('itinerary_seat');
    }
}
