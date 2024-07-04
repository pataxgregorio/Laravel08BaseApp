<?php

namespace App\Models\Comunidad;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class Comunidad extends Model
{
    use HasFactory;
    protected $fillable = [     
        'nombre',
        
    ];
    public function datos_comunidad($comuna){
        try {
            //$comunidad = DB::table('comunidad')->select('id','nombre')->where('comuna_id',$comuna)->orderBy('id')->pluck('nombre', 'id')->toArray();
            $comunidad = DB::table('comunidad')
            ->select('comunidad.id','comunidad.nombre')
            ->where('comuna_id',$comuna)
            ->leftjoin('comuna', 'comunidad.comuna_id', '=', 'comuna.id')
            ->get();            
            return $comunidad;
        }catch(Throwable $e){
            $comuna = [];
            return $comunidad;
        }
        
    }
}
