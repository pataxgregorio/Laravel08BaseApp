<?php
/**
* Realizado por @author Tarsicio Carrizales Agosto 2021
* Correo: telecom.com.ve@gmail.com
*/
namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PermisosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Los presente permiso corresponden al rol = Root
        \DB::table('permisos')->insert([
            [
                'modulos_id' => 1, //user                       
                'rols_id'    => 1, //ROOT
                'delete'     => 'ALLOW',
                'update'     => 'ALLOW',
                'edit'       => 'ALLOW',
                'add'        => 'ALLOW',
                'view'       => 'ALLOW',
                'print'      => 'ALLOW',
                'download'   => 'ALLOW',
                'upload'     => 'ALLOW',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ],
            [
                'modulos_id' => 2, //notification                       
                'rols_id'    => 1,
                'delete'     => 'ALLOW',
                'update'     => 'ALLOW',
                'edit'       => 'ALLOW',
                'add'        => 'ALLOW',
                'view'       => 'ALLOW',
                'print'      => 'ALLOW',
                'download'   => 'ALLOW',
                'upload'     => 'ALLOW',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ],
            [
                'modulos_id' => 3, //modulo                      
                'rols_id'    => 1,
                'delete'     => 'ALLOW',
                'update'     => 'ALLOW',
                'edit'       => 'ALLOW',
                'add'        => 'ALLOW',
                'view'       => 'ALLOW',
                'print'      => 'ALLOW',
                'download'   => 'ALLOW',
                'upload'     => 'ALLOW',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ],
            [
                'modulos_id' => 4, //permiso                       
                'rols_id'    => 1,
                'delete'     => 'ALLOW',
                'update'     => 'ALLOW',
                'edit'       => 'ALLOW',
                'add'        => 'ALLOW',
                'view'       => 'ALLOW',
                'print'      => 'ALLOW',
                'download'   => 'ALLOW',
                'upload'     => 'ALLOW',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ],
            [
                'modulos_id' => 5, //rol                       
                'rols_id'    => 1,
                'delete'     => 'ALLOW',
                'update'     => 'ALLOW',
                'edit'       => 'ALLOW',
                'add'        => 'ALLOW',
                'view'       => 'ALLOW',
                'print'      => 'ALLOW',
                'download'   => 'ALLOW',
                'upload'     => 'ALLOW',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ],
        ]);
        //Asinación de Permisos para el resto de Roles y sus Módulos
        for($j=2;$j<=9;$j++){ //ROLES
            for($k=1;$k<=5;$k++){ //MODULOS
                if($k==1){
                    \DB::table('permisos')->insert([
                        [
                            'modulos_id' => $k, 
                            'rols_id'    => $j,
                            'delete'     => 'DENY',
                            'update'     => 'ALLOW',
                            'edit'       => 'DENY',
                            'add'        => 'DENY',
                            'view'       => 'ALLOW',
                            'print'      => 'DENY',
                            'download'   => 'DENY',
                            'upload'     => 'DENY',
                            'created_at' => \Carbon\Carbon::now(),
                            'updated_at' => \Carbon\Carbon::now(),
                        ],
                    ]);
                }else{
                    \DB::table('permisos')->insert([
                        [
                            'modulos_id' => $k, 
                            'rols_id'    => $j,
                            'delete'     => 'DENY',
                            'update'     => 'DENY',
                            'edit'       => 'DENY',
                            'add'        => 'DENY',
                            'view'       => 'DENY',
                            'print'      => 'DENY',
                            'download'   => 'DENY',
                            'upload'     => 'DENY',
                            'created_at' => \Carbon\Carbon::now(),
                            'updated_at' => \Carbon\Carbon::now(),
                        ],
                    ]);
                }                
            } 
        }        
    }
}
