<?php
/**
* Realizado por @author Tarsicio Carrizales Agosto 2021
* Correo: telecom.com.ve@gmail.com
*/
namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ModulosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('modulos')->insert([
            [
                'name' => 'user',
                'description' => 'Módulo para llevar el control de todos los usuarios del sistema',                
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ],
            [
                'name' => 'notification',
                'description' => 'Módulo para llevar el control de todas las notificaciones que se le envian a los diferentes usuarios del sistema',                   
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ],
            [
                'name' => 'modulo',
                'description' => 'Para llevar el control de los módulos del sistema',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ],
            [
                'name' => 'permiso',
                'description' => 'Este módulo lleva el control de todos los permisos que se le asignan a un rol',                               
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ],
            [
                'name' => 'rol',
                'description' => 'Lleva el control de los roles creados en el sistema',                
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ],
        ]);
    }
}
