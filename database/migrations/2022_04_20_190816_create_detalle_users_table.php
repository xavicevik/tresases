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
        Schema::create('detalle_users', function (Blueprint $table) {
            $table->id();
            $table->foreign('id')->references('id')->on('users');
            $table->integer('idrol')->unsigned();
            $table->foreign('idrol')->references('id')->on('roles');
            $table->boolean('estado')->default(1);
            $table->integer('idtipos_documento')->unsigned();
            $table->foreign('idtipos_documento')->references('id')->on('tipos_documentos');
            $table->string('num_documento', 20)->nullable();
            $table->string('direccion', 70)->nullable();
            $table->string('indicativo',5)->nullable();
            $table->integer('idpais')->unsigned();
            $table->integer('idciudad')->unsigned();
            $table->integer('iddepartamento')->unsigned();
            $table->string('obervaciones', 250)->nullable();
            $table->string('telefono', 20)->nullable();
            $table->string('movil', 50)->nullable();
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
        Schema::dropIfExists('detalle_users');
    }
};
