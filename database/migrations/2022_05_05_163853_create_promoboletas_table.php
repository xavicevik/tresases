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
        Schema::create('promoboletas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('idrifa')->unsigned();
            $table->foreign('idrifa')->references('id')->on('rifas');
            $table->foreignId('idpromocional')->unsigned();
            $table->foreign('idpromocional')->references('id')->on('promocionales');
            $table->string('numero', 100)->nullable(false);
            $table->string('serie', 100)->nullable(true);
            $table->bigInteger('codigo')->nullable(false);
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
        Schema::dropIfExists('boletas');
    }
};
