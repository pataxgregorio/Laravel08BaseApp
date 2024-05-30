<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSeguimientoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // seguimiento es un objeto con descripcion fecha y evidencias
        Schema::create('seguimiento', function (Blueprint $table) {
            $table->unsignedBigInteger('solicitud_id')->nullable();
            $table->json('seguimiento')->nullable();
            $table->timestamps();
            $table->foreign('solicitud_id')->references('id')->on('solicitud');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('seguimiento');
    }
}
