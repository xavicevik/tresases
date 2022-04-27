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
        Schema::create('roles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre', 30)->unique();
            $table->string('descripcion', 100)->nullable();
            $table->boolean('estado')->default(1);
        });
        DB::table('roles')->insert(array('id'=>'1','nombre'=>'Administrador', 'descripcion'=>'Administradores'));
        DB::table('roles')->insert(array('id'=>'2','nombre'=>'Cliente', 'descripcion'=>'Clientes'));
        DB::table('roles')->insert(array('id'=>'3','nombre'=>'Distribuidor', 'descripcion'=>'Distribuidores de rifas'));
        DB::table('roles')->insert(array('id'=>'4','nombre'=>'Mayorista', 'descripcion'=>'Vendedor Mayorista'));
        DB::table('roles')->insert(array('id'=>'5','nombre'=>'Vendedor', 'descripcion'=>'Vendedores de área'));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('roles');
    }
};
