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

    public function getSubtiposolicitudbyID($id){
        $resultados = DB::table('solicitud')
            ->join('users', 'solicitud.users_id', '=', 'users.id')
            ->join('tipo_subsolicitud', 'solicitud.tipo_subsolicitud_id', '=', 'tipo_subsolicitud.id')
            ->where('tipo_subsolicitud.id', '=', $id)
            ->select('tipo_subsolicitud.id as id', 'tipo_subsolicitud.nombre as nombre')
            ->first();
        return $resultados;
    }

}
