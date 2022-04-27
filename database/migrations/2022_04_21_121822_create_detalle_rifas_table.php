<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalle_rifas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('idrifa')->unsigned();
            $table->foreign('idrifa')->references('id')->on('rifas');
            $table->integer('cantdad')->unsigned();
            $table->integer('reservados')->unsigned();

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
        Schema::dropIfExists('detalle_rifas');
    }
};
