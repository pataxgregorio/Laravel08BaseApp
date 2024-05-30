<?php
/**
* Realizado por @author Tarsicio Carrizales Agosto 2021
* Correo: telecom.com.ve@gmail.com
*/
namespace App\Models\Security;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Permiso extends Model
{
    use HasFactory;

    protected $fillable = [        
        'modulos_id',
        'rols_id',
        'delete',
        'edit',
        'add',
        'view',     
    ];

    public function rol(){
        return $this->belongsTo('App\Models\Security\Rol');
    }

    public function modulo(){
        return $this->belongsTo('App\Models\Security\modulo');
    }

    /**
    * Realizado por @author Tarsicio Carrizales 
    * Correo: telecom.com.ve@gmail.com
    */
    public function userAccess($modulo,$accion,$user_rols_id){
        $permiso = 'DENY';                
        switch ($accion) {
            case 'view':            
                $permiso = $this->permisoReturn($accion,$user_rols_id,$modulo,$permiso);                
                break;
            case 'add':
                $permiso = $this->permisoReturn($accion,$user_rols_id,$modulo,$permiso);
                break;
            case 'edit':
                $permiso = $this->permisoReturn($accion,$user_rols_id,$modulo,$permiso);
                break;
            case 'update':
                $permiso = $this->permisoReturn($accion,$user_rols_id,$modulo,$permiso);
                break;    
            case 'delete':
                $permiso = $this->permisoReturn($accion,$user_rols_id,$modulo,$permiso);
                break;
                case 'print':
                $permiso = $this->permisoReturn($accion,$user_rols_id,$modulo,$permiso);
                break;
            case 'download':
                $permiso = $this->permisoReturn($accion,$user_rols_id,$modulo,$permiso);
                break;    
            case 'upload':
                $permiso = $this->permisoReturn($accion,$user_rols_id,$modulo,$permiso);
                break;
        }            
        return $permiso;
    }

    /**
    * Realizado por @author Tarsicio Carrizales 
    * Correo: telecom.com.ve@gmail.com
    */
    public function permisoReturn($accion,$user_rols_id,$modulo,$permiso){                
        try {
            $permisos = DB::table('permisos')
                    ->join('modulos', 'modulos.id', '=', 'permisos.modulos_id')
                    ->select('permisos.'.$accion)                                
                    ->where('permisos.rols_id',$user_rols_id)
                    ->where('modulos.name',$modulo)->get();                    
                    if(!$permisos->isEmpty()){
                        foreach($permisos as $permiso_02){
                            switch ($accion) {
                                case 'view':            
                                    $permiso = $permiso_02->view;
                                    break;
                                case 'add':
                                    $permiso = $permiso_02->add;
                                    break;
                                case 'edit':
                                    $permiso = $permiso_02->edit;
                                    break;
                                case 'update':
                                    $permiso = $permiso_02->update;
                                    break;    
                                case 'delete':
                                    $permiso = $permiso_02->delete;
                                    break;
                                    case 'print':
                                    $permiso = $permiso_02->print;
                                    break;
                                case 'download':
                                    $permiso = $permiso_02->download;
                                    break;    
                                case 'upload':
                                    $permiso = $permiso_02->upload;
                                    break;
                                }                            
                        }
                    }                    
        } catch (Throwable $e){
            //echo "Captured Throwable: " . $e->getMessage(), "\n";
            return $permiso;
        }        
        return $permiso;
    }

    /**
    * Realizado por @author Tarsicio Carrizales 
    * Correo: telecom.com.ve@gmail.com
    */
    public function datos_Permiso($user_rols_id){
        try {
            $permisos = DB::table('permisos')
                    ->join('modulos','modulos.id', '=', 'permisos.modulos_id')
                    ->select('permisos.id',
                        'permisos.modulos_id',
                        'permisos.rols_id',
                        'modulos.name',
                        'permisos.delete',
                        'permisos.update',
                        'permisos.edit',
                        'permisos.delete',
                        'permisos.add',
                        'permisos.view',
                        'permisos.print',
                        'permisos.download',
                        'permisos.upload')                                
                    ->where('permisos.rols_id',$user_rols_id)->get();
        }catch(Throwable $e){
            $permisos = [];
            return $permisos;
        }
        return $permisos;
    }

    /**
    * Realizado por @author Tarsicio Carrizales 
    * Correo: telecom.com.ve@gmail.com
    */
    public function setUpdatePermiso($id,$accion,$allow_deny){        
        try{        
        $updateSQL = DB::table('permisos')
                        ->where('id',$id)                        
                        ->update([$accion => $allow_deny,
                            'updated_at' => NOW()]);                        
        }catch(Throwable $e){            
            return $updateSQL = $e;
        }
        return $updateSQL;
    }

    /**
    * Realizado por @author Tarsicio Carrizales 
    * Correo: telecom.com.ve@gmail.com
    */
    public function setUpdateAllPermisos($id,$allow_deny){        
        try{        
        $updateSQL = DB::table('permisos')
                        ->where('id',$id)                        
                        ->update(['delete' => $allow_deny,
                            'update' => $allow_deny,
                            'edit' => $allow_deny,
                            'add' => $allow_deny,
                            'view' => $allow_deny,
                            'print' => $allow_deny,
                            'download' => $allow_deny,
                            'upload' => $allow_deny,
                            'updated_at' => NOW()]);                        
        }catch(Throwable $e){            
            return $updateSQL = $e;
        }
        return $updateSQL;
    }    

    /**
    * Realizado por @author Tarsicio Carrizales 
    * Correo: telecom.com.ve@gmail.com
    */
    public function get_Permisos_Rol_Modulos($modulo_id,$rol_id){
        try {
            $permisos = DB::table('permisos')
                    ->join('modulos','modulos.id', '=', 'permisos.modulos_id')
                    ->join('rols','rols.id', '=', 'permisos.rols_id')
                    ->select('permisos.id',
                        'permisos.modulos_id',
                        'permisos.rols_id',
                        'modulos.name AS NAME_MODULO',
                        'rols.name AS NAME_ROL',
                        'permisos.delete',
                        'permisos.update',
                        'permisos.edit',                        
                        'permisos.add',
                        'permisos.view',
                        'permisos.print',
                        'permisos.download',
                        'permisos.upload')                                
                    ->where('permisos.rols_id',$rol_id)
                    ->where('permisos.modulos_id',$modulo_id)->get();
        }catch(Throwable $e){
            $permisos = [];
            return $permisos;
        }
        return $permisos;
    }

    public function existe_Permiso($modulo_id,$rol_id){
        $count = DB::table('permisos')
                    ->where('permisos.rols_id',$rol_id)
                    ->where('permisos.modulos_id',$modulo_id)->count();
        if($count == 0){
            return false;
        }else{
            return true;
        }
    }
    
}
