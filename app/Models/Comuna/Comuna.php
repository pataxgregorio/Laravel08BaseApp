<?php

namespace App\Models\Comuna;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class Comuna extends Model
{
    use HasFactory;
    protected $fillable = [     
        'nombre',
        
    ];
    public function datos_comuna($parroquia){
        try {
            
            $comuna = DB::table('comuna')->select('id','codigo')->where('parroquia_id',$parroquia)->orderBy('id')->pluck('codigo', 'id')->toArray();
            return $comuna;
        }catch(Throwable $e){
            $comuna = [];
            return $comuna;
        }
        
    }
  
}

