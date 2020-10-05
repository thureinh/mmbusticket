<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
          $table->id();
          $table->timestamp('buy_date');
          $table->unsignedInteger('totalprice')->nullable(false);
          $table->text('code')->nullable(false);
          $table->foreignId('customer_info_id')
                ->nullable(false)
                ->constrained('customer_infos')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('records');
    }
}
