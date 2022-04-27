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
        Schema::create('ciudades', function (Blueprint $table) {
            $table->integer('id')->unsigned();
            $table->integer('idlocal')->unsigned();
            $table->integer('idpais')->unsigned();
            $table->foreign('idpais')->references('id')->on('paises');
            $table->integer('iddepartamento')->unsigned();
            $table->foreign('iddepartamento')->references('id')->on('departamentos');
            $table->string('nombre');
            $table->string('descripcion');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ciudades');
    }
};
