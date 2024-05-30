<?php

namespace App\Models\Municipio;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class Municipio extends Model
{
    use HasFactory;
    protected $fillable = [     
        'nombre',
        
    ];
    public function datos_municipio(){
        try {
            $municipio = DB::table('municipio')->select('id','nombre')->orderBy('id')->pluck('nombre', 'id')->toArray();
            return $municipio;
        }catch(Throwable $e){
            $municipio = [];
            return $municipio;
        }
        
    }
}
