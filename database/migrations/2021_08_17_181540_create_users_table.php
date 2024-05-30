<?php
/**
* Realizado por @author Tarsicio Carrizales Agosto 2021
* Correo: telecom.com.ve@gmail.com
*/
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('rols_id')->default(8);;
            $table->string('name')->index();            
            $table->string('avatar')->nullable()->default('default.jpg');
            $table->string('email')->unique()->index();            
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->enum('activo', ['ALLOW','DENY'])->nullable()->default('DENY');
            $table->dateTime('init_day')->nullable();// Fecha inicio para entrar al sistema
            $table->dateTime('end_day')->nullable();// Fecha final para entrar el sistema
            $table->rememberToken();
            $table->string('confirmation_code')->nullable();
            $table->dateTime('confirmed_at')->nullable();
            $table->json('colores')->nullable();
            $table->timestamps();
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
        Schema::dropIfExists('users');
    }
}
