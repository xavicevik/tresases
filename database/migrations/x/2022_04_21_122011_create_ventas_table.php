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
        Schema::create('ventas', function (Blueprint $table) {
            $table->increments('id');
            $table->decimal('valorventa', 10, 2);
            $table->decimal('impuesto', 10, 2);
            $table->decimal('comision', 10, 2);
            $table->decimal('valortotal', 10, 2);
            $table->integer('cantidad');
            $table->foreignId('idvendedor');
            $table->foreign('idvendedor')->references('id')->on('users');
            $table->foreignId('idcliente');
            $table->foreign('idcliente')->references('id')->on('users');
            $table->foreignId('idpuntoventa')->unsigned();
            //$table->foreign('idpuntoventa')->references('id')->on('puntosventas');
            $table->dateTime('fechaventa');
            $table->string('comprobante', 250)->nullable(true);
            $table->boolean('estado')->default(1);
            $table->integer('transaccion')->nullable(true);
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
        Schema::dropIfExists('ventas');
    }
};
