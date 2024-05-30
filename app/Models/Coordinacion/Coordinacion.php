<?php

namespace App\Models\Coordinacion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class Coordinacion extends Model
{
    use HasFactory;
    protected $fillable = [     
        'nombre',
        
    ];
    public function datos_coordinacion($direccion){
        try {
            $coordinacion = DB::table('coordinacion')->select('id','nombre')->where('direccion_id',$direccion)->orderBy('id')->pluck('nombre', 'id')->toArray();
            return $coordinacion;
        }catch(Throwable $e){
            $comuna = [];
            return $coordinacion;
        }
        
    }
}