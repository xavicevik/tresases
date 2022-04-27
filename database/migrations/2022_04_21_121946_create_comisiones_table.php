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
        Schema::create('comisiones', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('idrifa')->unsigned();
            $table->foreign('idrifa')->references('id')->on('rifas');
            $table->string('numero');
            $table->decimal('valor', 10, 5);
            $table->boolean('estado')->default(1);
            $table->foreignId('idvendedor');
            $table->foreign('idvendedor')->references('id')->on('users');
            $table->foreignId('idcliente');
            $table->foreign('idcliente')->references('id')->on('users');
            $table->dateTime('fecha');
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
        Schema::dropIfExists('comisiones');
    }
};
