<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('buses', function (Blueprint $table) {
            $table->id();
            $table->string('license')->unique()->nullable(false);
            $table->foreignId('company_id')
                  ->nullable(false)
                  ->constrained()
                  ->onDelete('cascade');
            $table->foreignId('bustype_id')
                  ->nullable(false)
                  ->constrained()
                  ->onDelete('cascade');
            $table->json('photos')->nullable(true);
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
        Schema::dropIfExists('buses');
    }
}
