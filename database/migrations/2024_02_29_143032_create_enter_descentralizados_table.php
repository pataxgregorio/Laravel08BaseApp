<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEnterDescentralizadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('enter_descentralizados', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('despacho_id');
            $table->string('nombre');
            $table->timestamps();
            $table->foreign('despacho_id')->references('id')->on('despacho');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('enter_descentralizados');
    }
}
