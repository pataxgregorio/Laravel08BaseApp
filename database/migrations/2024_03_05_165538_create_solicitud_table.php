<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSolicitudTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('solicitud', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('users_id');
            $table->unsignedBigInteger('direccion_id');
            $table->unsignedBigInteger('coordinacion_id')->nullable();;
            $table->unsignedBigInteger('tipo_solicitud_id');
            $table->unsignedBigInteger('enter_descentralizados_id')->nullable();;
            $table->unsignedBigInteger('estado_id');
            $table->unsignedBigInteger('municipio_id');
            $table->unsignedBigInteger('parroquia_id');
            $table->unsignedBigInteger('comuna_id');
            $table->unsignedBigInteger('comunidad_id');
            $table->string('Nombre');
            $table->string('Cedula');
            $table->string('Sexo');
            $table->string('email');
            $table->string('Organizacion');
            $table->string('Fecha');
            $table->string('Telefono');
            $table->string('datoDenuncia');
            $table->string('organismo');
            $table->string('edocivil');
            $table->string('fechaNacimiento');
            $table->string('Nivelestudio');
            $table->string('profesion');
            $table->json('recaudos')->nullable();
            $table->json('beneficiario')->nullable();
            $table->json('quejas')->nullable();
            $table->json('reclamo')->nullable();
            $table->json('denunciado')->nullable();
            $table->foreign('users_id')->references('id')->on('users');
            $table->foreign('direccion_id')->references('id')->on('direccion');
            $table->foreign('coordinacion_id')->references('id')->on('coordinacion');
            $table->foreign('tipo_solicitud_id')->references('id')->on('tipo_solicitud');
            $table->foreign('enter_descentralizados_id')->references('id')->on('enter_descentralizados');
            $table->foreign('estado_id')->references('id')->on('estado');
            $table->foreign('municipio_id')->references('id')->on('municipio');
            $table->foreign('parroquia_id')->references('id')->on('parroquia');
            $table->foreign('comuna_id')->references('id')->on('comuna');
            $table->foreign('comunidad_id')->references('id')->on('comunidad');
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
        Schema::dropIfExists('solicitud');
    }
}
