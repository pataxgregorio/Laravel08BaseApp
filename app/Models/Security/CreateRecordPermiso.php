<?php
/**
* Realizado por @author Tarsicio Carrizales Agosto 2021
* Correo: telecom.com.ve@gmail.com
*/
namespace App\Models\Security;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CreateRecordPermiso
{
    public function generarPermisosModuloRol($modulos_id,$rols_id){
        try{
            if($rols_id == 1){
                \DB::table('permisos')->insert([
            [
                'modulos_id' => $modulos_id,                        
                'rols_id'    => $rols_id,
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
            }else{
                \DB::table('permisos')->insert([
            [
                'modulos_id' => $modulos_id,                        
                'rols_id'    => $rols_id,
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
        }catch(Throwable $e){
            //echo "Captured Throwable: " . $e->getMessage(), "\n";
            return false;
        }
        return true;
    }
}