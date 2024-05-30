<?php
/**
* Realizado por @author Tarsicio Carrizales Agosto 2021
* Correo: telecom.com.ve@gmail.com
*/
namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {        
        $this->call(ModulosSeeder::class);
        $this->call(RolsSeeder::class);
        $this->call(UsersSeeder::class);
        $this->call(PermisosSeeder::class);
        $this->call(NotificationSeeder::class);
    }
}
