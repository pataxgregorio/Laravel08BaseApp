<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecaudosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recaudos', function (Blueprint $table) {
            $table->id(); 
            $table->unsignedBigInteger('tipo_solicitud_id');
            $table->string('nombre');
            $table->timestamps();
            $table->foreign('tipo_solicitud_id')->references('id')->on('tipo_solicitud');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('recaudos');
    }
}
