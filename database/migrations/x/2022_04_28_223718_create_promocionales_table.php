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
        Schema::create('promocionales', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('idrifa')->unsigned();
            $table->foreign('idrifa')->references('id')->on('rifas');
            $table->integer('idloteria')->unsigned();
            $table->foreign('idloteria')->references('id')->on('loterias');
            $table->boolean('estado')->default(1);
            $table->dateTime('fecha');
            $table->integer('cifras');
            $table->string('premio');
            $table->string('descripcion')->nullable(true);
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
        Schema::dropIfExists('promocionales');
    }
};
