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
        Schema::table('rifas', function (Blueprint $table) {
            $table->integer('serieoculta')->default(1);
            $table->string('serie',50)->nullable(true);
            $table->foreignId('idserie')->unsigned()->default(1);
            $table->foreign('idserie')->references('id')->on('series');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
