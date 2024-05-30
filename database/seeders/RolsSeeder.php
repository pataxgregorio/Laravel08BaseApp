<?php
/**
* Realizado por @author Tarsicio Carrizales Agosto 2021
* Correo: telecom.com.ve@gmail.com
*/
namespace Database\Seeders;

use Illuminate\Database\Seeder;

class RolsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('rols')->insert([
            [
                'name' => 'ROOT',
                'description' => 'Rol principal del sistema, tiene control de toda la aplicación, el maximo control',               
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ],
            [
                'name' => 'ADMINISTRADOR',
                'description' => 'Rol de Administrador, gestiona el sistema',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ],
            [
                'name' => 'GERENTE',
                'description' => 'Rol de Gerente operativo dentro del sistema',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ],
            [
                'name' => 'COORDINADOR',
                'description' => 'Rol de Coordinador',               
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ],
            [
                'name' => 'SUPERVIDOR',
                'description' => 'Rol de Supervisor',               
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ],
            [
                'name' => 'SECRETARIA',
                'description' => 'Rol de Secretaria', 
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ],
            [
                'name' => 'ASISTENTE',
                'description' => 'Rol de Asistente', 
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ],
            [
                'name' => 'INVITADO',
                'description' => 'Rol de Invitado', 
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ],
            [
                'name' => 'BASICO',
                'description' => 'Rol Básico, muy limitado, por lo general sólo lectura',   
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ],
        ]);
    }
}
