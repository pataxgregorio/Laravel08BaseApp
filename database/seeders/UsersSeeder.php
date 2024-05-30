<?php
/**
* Realizado por @author Tarsicio Carrizales Agosto 2021
* Correo: telecom.com.ve@gmail.com
*/
namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         \DB::table('users')->insert([
            [
                'rols_id'           => 1,
                'name'              => 'Jose Carrasco',                
                'avatar'            => 'default.jpg',
                'email'             => 'pataxjose@gmail.com',
                'email_verified_at' => null,
                'password'          => \Hash::make('123456789'), // Password de entrada -> 123456789
                'activo'            => 'ALLOW', 
                'init_day'          => null, // Fecha inicio desde cuando puede entrar al sistema
                'end_day'           => null, // hasta cuando puede entrar al sistema
                'remember_token'    => \Str::random(100),
                'confirmation_code' => null,
                'confirmed_at'      => \Carbon\Carbon::now(),
                'colores'           => '{
                                            "encabezado":"#5333ed",
                                            "menu":"#0B0E66",
                                            "group_button":"#5333ed",
                                            "back_button":"#5333ed",
                                            "process_button":"#5333ed",
                                            "create_button":"#5333ed",
                                            "update_button":"#5333ed",
                                            "edit_button":"#2962ff",
                                            "view_button":"#5333ed"
                                        }',
                'created_at'        => \Carbon\Carbon::now(),
                'updated_at'        => \Carbon\Carbon::now(),
            ],
            
        ]);
    }
}
