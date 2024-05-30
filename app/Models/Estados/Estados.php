<?php

namespace App\Models\Estados;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class Estados extends Model
{
    use HasFactory;
    protected $fillable = [     
        'nombre',
        
    ];
    public function datos_estados(){
        try {
            $estados = DB::table('estado')->select('id','nombre')->orderBy('id')->pluck('nombre', 'id')->toArray();
            return $estados;
        }catch(Throwable $e){
            $estados = [];
            return $estados;
        }
        
    }
}
