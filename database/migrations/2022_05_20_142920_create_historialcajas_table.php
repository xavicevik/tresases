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
        Schema::create('historialcajas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('idcaja')->unsigned();
            $table->foreign('idcaja')->references('id')->on('cajas');
            $table->foreignId('idvendedor')->unsigned();
            $table->foreign('idvendedor')->references('id')->on('users');
            $table->integer('idpuntoventa')->unsigned();
            $table->foreign('idpuntoventa')->references('id')->on('puntos_ventas');
            $table->decimal('montoapertura', 10, 2);
            $table->decimal('montocierre', 10, 2);
            $table->decimal('recaudoefectivo', 10, 2);
            $table->timestamp('fechaapertura');
            $table->timestamp('fechacierre')->nullable(true);
            $table->decimal('sobrante', 10, 2);
            $table->decimal('faltante', 10, 2);
            $table->boolean('estado')->default(false);
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
        Schema::dropIfExists('historialcajas');
    }
};
