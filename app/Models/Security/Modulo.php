<?php
/**
* Realizado por @author Tarsicio Carrizales Agosto 2021
* Correo: telecom.com.ve@gmail.com
*/
namespace App\Models\Security;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Modulo extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',        
    ];

    /**
    * Realizado por @author Tarsicio Carrizales 
    * Correo: telecom.com.ve@gmail.com
    */
    public function permisos(){
        return $this->hasMany('App\Models\Security\Permiso');
    }

    /**
    * Realizado por @author Tarsicio Carrizales 
    * Correo: telecom.com.ve@gmail.com
    */
    public function datos_modulos(){
        return DB::table('modulos')->select('id','name')->orderBy('id')->get();
    }

    /**
    * Realizado por @author Tarsicio Carrizales 
    * Correo: telecom.com.ve@gmail.com
    */
    public function getModulosList_DataTable(){        
        return DB::table('modulos')->select('id','name','description')->get();
    }

    public function buscarTablasAsociados($id){        
        $count_permisos = DB::table('permisos')->where('modulos_id', $id)->count();        
        if($count_permisos == 0){
            return false;    
        }else{
            return true;
        }        
    }

}
