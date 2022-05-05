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
        Schema::table('users', function (Blueprint $table) {
            $table->renameColumn('name', 'nombre')->nullable();;
            $table->renameColumn('email', 'correo');
            $table->string('username')->unique();
            $table->string('apellido');
            $table->integer('idrol')->unsigned();
            $table->foreign('idrol')->references('id')->on('roles');
            $table->boolean('estado')->default(1);
            $table->integer('idtipos_documento')->unsigned()->default(1);;
            $table->foreign('idtipos_documento')->references('id')->on('tipos_documentos');
            $table->string('documento', 20)->nullable();
            $table->string('direccion', 70)->nullable();
            $table->string('indicativo',5)->nullable();
            $table->integer('idpais')->unsigned()->default(999999);
            $table->foreign('idpais')->references('id')->on('paises');
            $table->integer('idciudad')->unsigned()->default(999999);;
            $table->foreign('idciudad')->references('id')->on('ciudades');
            $table->integer('iddepartamento')->unsigned()->default(999999);;
            $table->foreign('iddepartamento')->references('id')->on('departamentos');
            $table->string('observaciones', 250)->nullable();
            $table->string('telefono', 20)->nullable();
            $table->string('movil', 50)->nullable();
            $table->boolean('isnatural')->default(true);
            $table->string('camaracomercio', 200)->nullable();
            $table->string('rut', 200)->nullable();
            $table->string('url', 200)->nullable();
            $table->integer('idempresa')->unsigned();
            $table->foreign('idempresa')->references('id')->on('empresas');
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
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
