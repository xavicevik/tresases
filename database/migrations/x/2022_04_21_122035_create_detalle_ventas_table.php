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
        Schema::create('detalle_ventas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('idventa')->unsigned();
            $table->foreign('idventa')->references('id')->on('ventas');
            $table->foreignId('idboleta')->unsigned();
            $table->foreign('idboleta')->references('id')->on('boletas');
            $table->increments('idrifa')->unsigned();
            $table->foreign('idrifa')->references('id')->on('rifas');
            $table->decimal('valor', 10, 2);
            $table->decimal('impuesto', 10, 2);
            $table->decimal('comision', 10, 2);
            $table->decimal('valortotal', 10, 2);
            $table->string('numero', 100);
            $table->string('serie', 100);
            $table->integer('cantidad');
            $table->boolean('estado')->default(1);
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
        Schema::dropIfExists('detalle_ventas');
    }
};
