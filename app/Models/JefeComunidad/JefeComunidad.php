<?php

namespace App\Models\JefeComunidad;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class JefeComunidad extends Model
{   
    protected $table = 'jefecomunidad'; 
    protected $fillable = [
        'comuna_id',        
        'nombre_consejo_comunal',
        'nombre_jefe_comunidad',
        'telefono_jefe_comunidad',
        'nombre_jefe_ubch',
        'telefono_jefe_ubch',
        'nombre_ubch',
    ];
    public function getJefe($comuna_id){
        $resultados = DB::table('jefecomunidad')
        ->leftJoin('comuna', 'jefecomunidad.comuna_id', '=', 'comuna.id')
        ->where('jefecomunidad.comuna_id', '=', $comuna_id)
        ->select(
            'jefecomunidad.nombre_jefe_comunidad AS Nombre_Jefe_Comunidad',
            'jefecomunidad.id AS id',
            'jefecomunidad.telefono_jefe_comunidad AS Telefono_Jefe_Comunidad',
            'jefecomunidad.nombre_ubch AS Nombre_Ubch',
            'jefecomunidad.nombre_jefe_ubch AS Nombre_Jefe_Ubch',
            'jefecomunidad.telefono_jefe_ubch AS Telefono_Jefe_Ubch',)
        ->get();
        return $resultados;
        }
        public function getJefe2($jefecomunidadID){            
            $resultados = DB::table('jefecomunidad')
            ->where('jefecomunidad.id', '=', $jefecomunidadID)
            ->select(
                'jefecomunidad.id AS id',
                'jefecomunidad.nombre_jefe_comunidad AS Nombre_Jefe_Comunidad',
                'jefecomunidad.telefono_jefe_comunidad AS Telefono_Jefe_Comunidad',
                'jefecomunidad.nombre_ubch AS Nombre_Ubch',
                'jefecomunidad.nombre_jefe_ubch AS Nombre_Jefe_Ubch',
                'jefecomunidad.telefono_jefe_ubch AS Telefono_Jefe_Ubch',)
            ->get();                    
            return $resultados;
    }
    use HasFactory;
}
