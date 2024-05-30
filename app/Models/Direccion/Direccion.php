<?php

namespace App\Models\Direccion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class Direccion extends Model
{
    use HasFactory;
    protected $fillable = [     
        'nombre',
        
    ];
    public function datos_direccion(){
        try {
            $direccion = DB::table('direccion')->select('id','nombre')->orderBy('id')->pluck('nombre', 'id')->toArray();
            return $direccion;
        }catch(Throwable $e){
            $direccion = [];
            return $direccion;
        }
        
    }
}