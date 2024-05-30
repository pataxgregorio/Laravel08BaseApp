<?php
/**
* Realizado por @author Tarsicio Carrizales Agosto 2021
* Correo: telecom.com.ve@gmail.com
*/
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePermisosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permisos', function (Blueprint $table) {
            $table->id();            
            $table->unsignedBigInteger('modulos_id');
            $table->unsignedBigInteger('rols_id');
            $table->enum('delete', ['ALLOW','DENY'])->nullable()->default('DENY');
            $table->enum('update', ['ALLOW','DENY'])->nullable()->default('DENY');
            $table->enum('edit', ['ALLOW','DENY'])->nullable()->default('DENY');
            $table->enum('add', ['ALLOW','DENY'])->nullable()->default('DENY');
            $table->enum('view', ['ALLOW','DENY'])->nullable()->default('DENY');
            $table->enum('print', ['ALLOW','DENY'])->nullable()->default('DENY');
            $table->enum('download', ['ALLOW','DENY'])->nullable()->default('DENY');
            $table->enum('upload', ['ALLOW','DENY'])->nullable()->default('DENY');
            $table->timestamps();
            $table->unique(['modulos_id','rols_id']);            
            $table->foreign('modulos_id')->references('id')->on('modulos');
            $table->foreign('rols_id')->references('id')->on('rols');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('permisos');
    }
}
