<?php
/**
* Realizado por @author Tarsicio Carrizales Agosto 2021
* Correo: telecom.com.ve@gmail.com
*/
namespace App\Models\Security;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Rol extends Model
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
    public function users(){
        return $this->hasMany('App\Models\User\User');
    }

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
    public function datos_roles(){
        $rols_id = auth()->user()->rols_id;
        if($rols_id == 1){
            return DB::table('rols')->select('id','name')->orderBy('id')->pluck('name', 'id')->toArray();
        }else{
            return DB::table('rols')->select('id','name')
                    ->where('id',$rols_id)->orderBy('id')->pluck('name', 'id')->toArray();
        }
    }

    /**
    * Realizado por @author Tarsicio Carrizales 
    * Correo: telecom.com.ve@gmail.com
    */
    public function get_nombre_rol($user_rols_id){
        try{
            $nombre = "";
            $nombres = DB::table('rols')->select('name')                    
                    ->where('id',$user_rols_id)->get();
                    if(!$nombres->isEmpty()){
                        foreach($nombres as $nombre_01){
                            $nombre = $nombre_01->name;
                        }
                    }
        }catch(Throwable $e){
            return $nombre;
        }
        return $nombre;
    }

    /**
    * Realizado por @author Tarsicio Carrizales 
    * Correo: telecom.com.ve@gmail.com
    */
    public function getRolsList_DataTable(){        
        return DB::table('rols')->select('id','name','description')->get();
    }

    public function buscarTablasAsociados($id){
        $count_users = DB::table('users')->where('rols_id', $id)->count();
        $count_permisos = DB::table('permisos')->where('rols_id', $id)->count();        
        if($count_users == 0 && $count_permisos == 0){
            return false;    
        }else{
            return true;
        }        
    }  
} // END CLASS
