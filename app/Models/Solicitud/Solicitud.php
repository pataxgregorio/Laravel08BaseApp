<?php

namespace App\Models\Solicitud;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Solicitud extends Model
{
    use HasFactory;
    protected $fillable = [
        'users_id',
        'direccion_id',        
        'coordinacion_id',
        'tipo_solicitud_id',
        'enter_descentralizados_id',
        'estado_id',
        'municipio_id',
        'parroquia_id',
        'comuna_id',
        'comunidad_id',
        'comuna_id',
        'codigo_control',
        'nombre',
        'cedula',
        'sexo',
        'email',
        'fecha',
        'telefono',
        'organismo',
        'edocivil',
        'fechaNacimiento',
        'profesion',
        'recaudos',
        'beneficiario',
        'quejas',
        'reclamo',
        'sugerecia',
        'asesoria',
        'denuncia',
        'denunciado',
        'status'
    ];
    public function getSolicitudList_DataTable(){
        try {
            $solicitud = DB::table('solicitud')
            ->join('tipo_solicitud', 'solicitud.tipo_solicitud_id', '=', 'tipo_solicitud.id')
            ->join('direccion', 'solicitud.direccion_id', '=', 'direccion.id')
            ->select('solicitud.id','solicitud.nombre AS Solicitante','tipo_solicitud.nombre AS Nombretipo','direccion.nombre AS direccionNombre','solicitud.status')->get();
            return $solicitud;
        }catch(Throwable $e){
            $solicitud = [];
            return $solicitud;
        }
        
    }
}
