<?php
/**
* Realizado por @author Tarsicio Carrizales Agosto 2021
* Correo: telecom.com.ve@gmail.com
*/
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Ramsey\Uuid\Uuid;

class NotificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */    
    public function run()
    {
         \DB::table('notifications')->insert([
            [    
                'id'                => Uuid::uuid4(),
                'type'              => 'App\Notifications\NotificarEventos',                
                'notifiable_type'   => 'App\Models\User\User',
                'notifiable_id'     => 1,
                'data'              => '{"title":"Bienvenido a nuestro sistema base HORUS Venezuela","body":"Les doy las gracias por utilizar nuestro sistema base para Laravel 8, Atentamente, Tarsicio Carrizales telecom.com.ve@gmail.com, | 2023"}',
                'read_at'           => null,
                'created_at'        => \Carbon\Carbon::now(),
                'updated_at'        => \Carbon\Carbon::now(),
            ],
            [                
                'id'                => Uuid::uuid4(),
                'type'              => 'App\Notifications\NotificarEventos',                
                'notifiable_type'   => 'App\Models\User\User',
                'notifiable_id'     => 2,
                'data'              => '{"title":"Bienvenido a nuestro sistema base HORUS Venezuela","body":"Les doy las gracias por utilizar nuestro sistema base para Laravel 8, Atentamente, Tarsicio Carrizales telecom.com.ve@gmail.com, | 2023"}',
                'read_at'           => null,
                'created_at'        => \Carbon\Carbon::now(),
                'updated_at'        => \Carbon\Carbon::now(),
            ],
            [                
                'id'                => Uuid::uuid4(),
                'type'              => 'App\Notifications\NotificarEventos',                
                'notifiable_type'   => 'App\Models\User\User',
                'notifiable_id'     => 3,
                'data'              => '{"title":"Bienvenido a nuestro sistema base HORUS Venezuela","body":"Les doy las gracias por utilizar nuestro sistema base para Laravel 8, Atentamente, Tarsicio Carrizales telecom.com.ve@gmail.com, | 2023"}',
                'read_at'           => null,
                'created_at'        => \Carbon\Carbon::now(),
                'updated_at'        => \Carbon\Carbon::now(),
            ],
        ]);
    }
}
