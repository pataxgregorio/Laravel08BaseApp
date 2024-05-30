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
            $table->unsignedBigInteger('direccion_id')->nullable();
            $table->unsignedBigInteger('coordinacion_id')->nullable();
            $table->unsignedBigInteger('tipo_solicitud_id')->nullable();
            $table->unsignedBigInteger('enter_descentralizados_id')->nullable();
            $table->unsignedBigInteger('estado_id')->nullable();
            $table->unsignedBigInteger('municipio_id')->nullable();
            $table->unsignedBigInteger('parroquia_id')->nullable();
            $table->unsignedBigInteger('comuna_id')->nullable();
            $table->unsignedBigInteger('comunidad_id')->nullable();
            $table->unsignedBigInteger('codigo_control')->nullable();
            $table->unsignedBigInteger('status_id')->nullable();
            $table->string('nombre')->nullable();
            $table->string('cedula')->nullable();
            $table->string('sexo')->nullable();
            $table->string('email')->nullable();
            $table->string('direccion')->nullable();
            $table->dateTime('fecha')->nullable();
            $table->string('telefono')->nullable();
            $table->string('telefono2')->nullable();
            $table->string('organismo')->nullable();
            $table->string('edocivil')->nullable();
            $table->string('fechaNacimiento')->nullable();
            $table->string('nivelestudio')->nullable();
            $table->string('profesion')->nullable();
            $table->json('recaudos')->nullable();
            $table->json('beneficiario')->nullable();
            $table->json('quejas')->nullable();
            $table->json('reclamo')->nullable();
            $table->json('sugerecia')->nullable();
            $table->json('asesoria')->nullable();
            $table->string('denuncia')->nullable();
            $table->json('denunciado')->nullable();
            $table->string('asignacion')->nullable();
            $table->foreign('users_id')->references('id')->on('users');
            $table->foreign('status_id')->references('id')->on('status');
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
