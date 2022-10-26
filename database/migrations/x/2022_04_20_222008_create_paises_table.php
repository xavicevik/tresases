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
        Schema::create('paises', function (Blueprint $table) {
            $table->integer('id')->unsigned();
            $table->string('nombre', 50);
            $table->string('zona', 50)->nullable();
            $table->string('descripcion', 100);
            $table->string('moneda', 5)->nullable(true);
        });
        DB::table('paises')->insert(array('id'=>'1','nombre'=>'Colombia', 'zona'=>'LATAM', 'descripcion' => 'Colombia', 'moneda' => '$'));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('paises');
    }
};
