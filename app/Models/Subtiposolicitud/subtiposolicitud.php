<?php

namespace App\Models\Subtiposolicitud;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use DB;


class subtiposolicitud extends Model
{
    protected $table = 'tipo_subsolicitud';

    protected $fillable = [
        'id',
        'nombre',
        ];

    public function getSubtiposolicitud()
    {
        $resultados = DB::table('tipo_subsolicitud')
        ->select(
            'tipo_subsolicitud.id AS id',
            'tipo_subsolicitud.nombre AS nombre',
            )
        ->get();
        return $resultados;
    }
}
