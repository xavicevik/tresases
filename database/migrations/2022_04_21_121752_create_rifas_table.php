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
        Schema::create('rifas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('titulo',200)->nullable(false);
            $table->string('resolucion', 100);
            $table->boolean('estado')->default(1);
            $table->string('nombre', 200)->nullable(true);
            $table->text('descripcion')->nullable(false);
            $table->string('nombre_tecnico',200)->nullable(false);
            $table->string('resumen', 500)->nullable(true);;
            $table->string('url', 100)->nullable(true);
            $table->integer('idloteria')->unsigned();
            $table->integer('idloteria')->references('id')->on('loterias');
            $table->integer('idpais')->unsigned();
            $table->foreign('idpais')->references('id')->on('paises');
            $table->integer('iddepartamento')->unsigned();
            $table->foreign('iddepartamento')->references('id')->on('departamentos');
            $table->integer('idciudad')->unsigned();
            $table->foreign('idciudad')->references('id')->on('ciudades');
            $table->integer('cifras')->unsigned();
            $table->string('precio', 20)->nullable(false);
            $table->dateTime('fechainicio');
            $table->dateTime('fechafin');
            $table->boolean('promocional');
            $table->boolean('publicar');
            $table->boolean('destacada');
            $table->boolean('principal');
            $table->string('urlimagen1')->nullable(false);;
            $table->string('urlimagen2')->nullable(false);;
            $table->integer('idterminos')->unsigned();
            $table->foreign('idterminos')->references('id')->on('terminos_condiciones');
            $table->foreignId('idcreador');
            $table->foreign('idcreador')->references('id')->on('users');
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
        Schema::dropIfExists('rifas');
    }
};
