<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_infos', function (Blueprint $table) {
            $table->id();
            $table->string('name')
                  ->charset('utf8mb4')
                  ->collation('utf8mb4_unicode_ci')
                  ->nullable(false);
            $table->string('gender')->nullable(false);
            $table->string('email')->nullable(true);
            $table->string('phone_no')->nullable(false);
            $table->text('note')->nullable(true);
            $table->boolean('is_foreigner')->nullable(false);
            $table->unsignedTinyInteger('seat_qty')->default(1);
            $table->foreignId('itinerary_id')
                  ->nullable(false)
                  ->constrained()
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
        Schema::dropIfExists('customer_infos');
    }
}
