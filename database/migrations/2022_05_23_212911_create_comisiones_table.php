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
        Schema::create('comisiones', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('idventa')->unsigned();
            $table->foreign('idventa')->references('id')->on('ventas');
            $table->foreignId('idconfiguracion')->unsigned();
            $table->foreign('idconfiguracion')->references('id')->on('confcomisiones');
            $table->decimal('valorventa', 10, 5);
            $table->decimal('comisionmayorista', 10, 5);
            $table->decimal('comisiondistribuidor', 10, 5);
            $table->decimal('comisionvendedor', 10, 5);
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
        Schema::dropIfExists('comisiones');
    }
};
