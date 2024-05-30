<?php

namespace App\Models\Tipo_Solicitud;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class Tipo_Solicitud extends Model
{
    use HasFactory;
    protected $fillable = [     
        'nombre',
        
    ];
    public function datos_tipo_solicitud(){
        try {
            $tipo_solicitud = DB::table('tipo_solicitud')->select('id','nombre')->orderBy('id')->pluck('nombre', 'id')->toArray();
            return $tipo_solicitud;
        }catch(Throwable $e){
            $tipo_solicitud = [];
            return $tipo_solicitud;
        }
        
    }
}
