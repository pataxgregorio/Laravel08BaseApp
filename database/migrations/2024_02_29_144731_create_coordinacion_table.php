<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoordinacionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coordinacion', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('direccion_id');
            $table->string('nombre');
            $table->timestamps();
            $table->foreign('direccion_id')->references('id')->on('direccion');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('coordinacion');
    }
}
