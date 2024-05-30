<?php

namespace App\Models\Parroquia;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class Parroquia extends Model
{
    use HasFactory;
    protected $fillable = [     
        'nombre',
        
    ];
    public function datos_parroquia(){
        try {
            $parroquia = DB::table('parroquia')->select('id','nombre')->orderBy('id')->pluck('nombre', 'id')->toArray();
            return  $parroquia;
        }catch(Throwable $e){
            $parroquia = [];
            return  $parroquia;
        }
        
    }
}
