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
        Schema::create('puntos_ventas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre', 200);
            $table->string('direccion', 200);
            $table->string('latitud', 50)->nullable(true);
            $table->string('altitud', 50)>nullable(true);;
            $table->string('codigo', 50);
            $table->boolean('estado')->default(0);
            $table->string('descripcion', 500);
            $table->string('url')>nullable(true);;
            $table->integer('idpais')->unsigned();
            $table->integer('idpais')->references('id')->on('paises');
            $table->integer('idciudad')->unsigned();
            $table->integer('idciudad')->references('id')->on('ciudades');
            $table->integer('iddepartamento')->unsigned();
            $table->integer('iddepartamento')->references('id')->on('departamentos');
            $table->integer('idempresa')->unsigned();
            $table->integer('idempresa')->references('id')->on('empresas');
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
        Schema::dropIfExists('puntos_ventas');
    }
};
