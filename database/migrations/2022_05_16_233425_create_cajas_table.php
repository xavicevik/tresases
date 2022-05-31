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
        Schema::create('cajas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('idvendedor')->unsigned()->nullable(true);
            $table->integer('idpuntoventa')->unsigned();
            $table->foreign('idpuntoventa')->references('id')->on('puntos_ventas');
            $table->decimal('montoapertura', 10, 2);
            $table->decimal('montocierre', 10, 2);
            $table->timestamp('fechaapertura')->nullable(true);
            $table->timestamp('fechacierre')->nullable(true);
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
        Schema::dropIfExists('cajas');
    }
};
