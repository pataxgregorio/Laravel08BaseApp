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
            $comuna = DB::table('comuna')
            ->leftJoin('parroquia', 'comuna.parroquia_id', '=', 'parroquia.id')
            ->select('comuna.id','comuna.codigo')
            ->where('comuna.parroquia_id', '=',$parroquia)
            ->get();           
            return $comuna;
        }catch(Throwable $e){
            $comuna = [];
            return $comuna;
        }
        
    }
  
}

