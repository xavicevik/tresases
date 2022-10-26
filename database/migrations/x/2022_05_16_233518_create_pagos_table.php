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
        Schema::create('pagos', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->integer('idventa')->unsigned();
            $table->foreign('idventa')->references('id')->on('ventas');
            $table->decimal('valortotal', 10, 2)->default(0);
            $table->foreignId('idcliente')->unsigned();
            $table->foreign('idcliente')->references('id')->on('users');
            $table->foreignId('idvendedor')->unsigned();
            $table->foreign('idvendedor')->references('id')->on('users');
            $table->decimal('saldo', 10, 2)->default(0);
            $table->string('canal')->nullable(true);
            $table->string('descripcion')->nullable(true);
            $table->string('tipo')->nullable(true);
            $table->string('soporte', 200)->nullable(true);
            $table->bigInteger('idtransaccion')->unsigned();
            $table->integer('idpuntoventa')->unsigned();
            $table->foreign('idpuntoventa')->references('id')->on('puntos_ventas');
            $table->foreignId('idcaja')->unsigned();
            $table->foreign('idcaja')->references('id')->on('cajas');
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
        Schema::dropIfExists('pagos');
    }
};
