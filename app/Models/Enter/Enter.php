<?php

namespace App\Models\Enter;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class Enter extends Model
{
    use HasFactory;
    protected $fillable = [     
        'nombre',
        
    ];
    public function datos_enter(){
        try {
            $direccion = DB::table('enter_descentralizados')->select('id','nombre')->orderBy('id')->pluck('nombre', 'id')->toArray();
            return $direccion;
        }catch(Throwable $e){
            $direccion = [];
            return $direccion;
        }
        
    }
}