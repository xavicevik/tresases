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
        Schema::create('tipos_documentos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre')->unique();
            $table->string('nombre_corto')->unique();
            $table->string('descripcion')->nullable();
            $table->boolean('estado')->default(1);
            $table->timestamps();
        });
        DB::table('tipos_documentos')->insert(array('id'=>'1','nombre'=>'Cédula de Ciudadanía', 'nombre_corto' => 'CC', 'descripcion' => 'Cédula de ciudadanía Colombiana'));
        DB::table('tipos_documentos')->insert(array('id'=>'2','nombre'=>'Pasaporte', 'nombre_corto' => 'Pasaporte','descripcion' => 'Pasaporte de identificación'));
        DB::table('tipos_documentos')->insert(array('id'=>'3','nombre'=>'Cédula de Extranjería', 'nombre_corto' => 'CE', 'descripcion' => 'Cédula de extranjería'));
        DB::table('tipos_documentos')->insert(array('id'=>'4','nombre'=>'NUI', 'nombre_corto' => 'NUI', 'descripcion' => 'NUI'));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tipos_documentos');
    }
};
