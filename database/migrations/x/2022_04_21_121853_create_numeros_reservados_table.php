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
        Schema::create('numeros_reservados', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('idrifa')->unsigned();
            $table->foreign('idrifa')->references('id')->on('rifas');
            $table->string('numero');
            $table->boolean('estado')->default(1);
            $table->string('rangoinicial');
            $table->string('rangofinal');
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
        Schema::dropIfExists('numeros_reservados');
    }
};
