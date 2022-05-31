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
        Schema::create('confcomisiones', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('idmayorista')->unsigned();
            $table->foreign('idmayorista')->references('id')->on('empresas');
            $table->integer('iddistribuidor')->unsigned();
            $table->foreign('iddistribuidor')->references('id')->on('empresas');
            $table->integer('idvendedor')->unsigned();
            $table->foreign('idvendedor')->references('id')->on('empresas');
            $table->decimal('comisionmayorista',10,2);
            $table->decimal('comisiondistribuidor',10,2);
            $table->decimal('comisionvendedor',10,2);
            $table->boolean('estado')->default(true);
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
        Schema::dropIfExists('confcomisiones');
    }
};
