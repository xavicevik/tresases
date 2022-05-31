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
        Schema::create('transacciones', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->foreignId('idusuarioori')->unsigned();
            $table->foreign('idusuarioori')->references('id')->on('users');
            $table->foreignId('idusuariodest')->unsigned();
            $table->foreign('idusuariodest')->references('id')->on('users');
            $table->foreignId('idconcepto')->unsigned();
            $table->foreign('idconcepto')->references('id')->on('conceptos');
            $table->string('origen',100)->nullable(true);
            $table->string('destino',100)->nullable(true);
            $table->string('signo',2)->nullable(false);
            $table->decimal('valor', 10, 2)->nullable(false);
            $table->decimal('impuesto', 10, 2)->nullable(false)->default(0);
            $table->string('descripcion', 200)->nullable(true);
            $table->string('soporte', 100)->nullable(true);
            $table->integer('mes')->nullable(false);
            $table->integer('ano')->nullable(false);
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
        Schema::dropIfExists('transaccion');
    }
};
