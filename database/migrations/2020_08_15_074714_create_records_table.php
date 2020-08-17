<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('records', function (Blueprint $table) {
            $table->id();
            $table->timestamp('buy_date')->nullable(false);
            $table->date('departure')->nullable(false);
            $table->unsignedBigInteger('leaving')->nullable(false);;
            $table->unsignedBigInteger('going')->nullable(false);;
            $table->unsignedBigInteger('bus')->nullable(false);;
            $table->boolean('is_foreigner')->nullable(false);;
            $table->unsignedTinyInteger('price')->nullable(false);
            $table->text('code')->nullable(false);
            $table->foreign('leaving')
                  ->references('id')
                  ->on('locations')
                  ->onDelete('cascade');;
            $table->foreign('going')
                  ->references('id')
                  ->on('locations')
                  ->onDelete('cascade');;
            $table->foreign('bus')
                  ->references('id')
                  ->on('buses')
                  ->onDelete('cascade');;
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
