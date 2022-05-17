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
        Schema::create('empresas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('documento');
            $table->integer('idpadre')->unsigned();
            $table->foreign('idpadre')->references('id')->on('usuarios');
            $table->string('razon_social', 200);
            $table->integer('idtipoempresa')->unsigned();
            $table->foreign('idtipoempresa')->references('id')->on('tipoempresas');
            $table->string('digit');
            $table->boolean('estado')->default(1);
            $table->integer('idtipos_documento')->unsigned();
            $table->foreign('idtipos_documento')->references('id')->on('tipos_documentos');
            $table->integer('idpais')->unsigned();
            $table->integer('idciudad')->unsigned();
            $table->integer('iddepartamento')->unsigned();
            $table->string('observaciones', 250)->nullable();
            $table->boolean('isnatural')->default(true);
            $table->string('telefono', 20)->nullable();
            $table->string('direccion', 100)->nullable();
            $table->string('camaracomercio', 200)->nullable();
            $table->string('rut', 200)->nullable();
            $table->string('url', 200)->nullable();
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
        Schema::dropIfExists('empresas');
    }
};
