<?php

namespace App\Models\Status;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Status extends Model{

    protected $table = 'status';
    protected $fillable = [
        'nombre',
    ];


public function getStatus(){

    return DB::table('status')->where('id', '!=' , 1)->select('id','nombre')->orderBy('id')->pluck('nombre', 'id')->toArray();
}
}
?>