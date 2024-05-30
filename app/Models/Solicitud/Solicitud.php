<?php

namespace App\Models\Solicitud;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class Solicitud extends Model
{
    use HasFactory;
    protected $table = 'solicitud';
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
        'codigo_control',
        'status_id',
        'nombre',
        'cedula',
        'sexo',
        'email',
        'direccion',
        'fecha',
        'telefono',
        'telefono2',
        'organismo',
        'edocivil',
        'asignacion',
        'fechaNacimiento',
        'nivelestudio',
        'profesion',
        'recaudos',
        'beneficiario',
        'quejas',
        'reclamo',
        'sugerecia',
        'asesoria',
        'denuncia',
        'denunciado',
        
    ];

    public function verificarJSON($id){
        return DB::table('seguimiento')->where('solicitud_id', $id)->get();
    }
    public function SolicitudRegistradas($status){
        $rols_id = auth()->user()->rols_id;
        $user_id = auth()->user()->id;
        return DB::table('solicitud')
        ->Where('solicitud.users_id', $user_id)
        ->Where('status_id',$status)
        ->get();
    }
    public function getSolicitudList_DataTable(){
        try {
            $rols_id = auth()->user()->rols_id;
            $user_id = auth()->user()->id;
        if($rols_id == 1){
            return $solicitud = DB::table('solicitud')
            ->join('tipo_solicitud', 'solicitud.tipo_solicitud_id', '=', 'tipo_solicitud.id')
            ->join('direccion', 'solicitud.direccion_id', '=', 'direccion.id')
            ->join('status', 'solicitud.status_id', '=', 'status.id')
            ->select('solicitud.id','solicitud.nombre AS solicitante','tipo_solicitud.nombre AS nombretipo','direccion.nombre AS direccionnombre','status.nombre AS nombrestatus')
            ->where ('status_id',1)->get(); 
        }
        if($rols_id == 10){
            return DB::table('solicitud')
            ->join('tipo_solicitud', 'solicitud.tipo_solicitud_id', '=', 'tipo_solicitud.id')
            ->join('direccion', 'solicitud.direccion_id', '=', 'direccion.id')
            ->join('status', 'solicitud.status_id', '=', 'status.id')
            ->join('users', 'solicitud.users_id', '=', 'users.id')
            ->select('solicitud.id','solicitud.nombre AS solicitante','tipo_solicitud.nombre AS nombretipo','direccion.nombre AS direccionnombre','status.nombre AS nombrestatus')
            ->where ('rols_id',10)
            ->where ('status_id',1)->get();
        }else{
            return $solicitud = DB::table('solicitud')
            ->join('tipo_solicitud', 'solicitud.tipo_solicitud_id', '=', 'tipo_solicitud.id')
            ->join('direccion', 'solicitud.direccion_id', '=', 'direccion.id')
            ->join('status', 'solicitud.status_id', '=', 'status.id')
            ->select('solicitud.id','solicitud.nombre AS solicitante','tipo_solicitud.nombre AS nombretipo','direccion.nombre AS direccionnombre','status.nombre AS nombrestatus')
            ->where ('status_id',1)->get();
        }    
        }catch(Throwable $e){
            $solicitud = [];
            return $solicitud;
        }
        
    }
    public function getSolicitudList_DataTable2(){
        try {
            $rols_id = auth()->user()->rols_id;
            if($rols_id == 1){
                return DB::table('solicitud')
                ->join('tipo_solicitud', 'solicitud.tipo_solicitud_id', '=', 'tipo_solicitud.id')
                ->join('direccion', 'solicitud.direccion_id', '=', 'direccion.id')
                ->join('status', 'solicitud.status_id', '=', 'status.id')
                ->join('users', 'solicitud.users_id', '=', 'users.id')
                ->select('solicitud.id','solicitud.nombre AS solicitante','tipo_solicitud.nombre AS nombretipo','direccion.nombre AS direccionnombre','status.nombre AS nombrestatus')
                ->where ('rols_id', $rols_id);
            }else{
            return DB::table('solicitud')
            ->join('tipo_solicitud', 'solicitud.tipo_solicitud_id', '=', 'tipo_solicitud.id')
            ->join('direccion', 'solicitud.direccion_id', '=', 'direccion.id')
            ->join('status', 'solicitud.status_id', '=', 'status.id')
            ->join('users', 'solicitud.users_id', '=', 'users.id')
            ->select('solicitud.id','solicitud.nombre AS solicitante','tipo_solicitud.nombre AS nombretipo','direccion.nombre AS direccionnombre','status.nombre AS nombrestatus')
            ->where ('rols_id', $rols_id)
            ->where ('tipo_solicitud.id', '!=',4)
            ->where ('tipo_solicitud.id', '!=',5)
            ->where ('status_id', '!=',5)->get();
        }
        }catch(Throwable $e){
            $solicitud = [];
            return $solicitud;
        }
        
    }
    public function count_solictud(){    
        $rols_id = auth()->user()->rols_id;
        return DB::table('solicitud')
            ->join('tipo_solicitud', 'solicitud.tipo_solicitud_id', '=', 'tipo_solicitud.id')
            ->join('users', 'solicitud.users_id', '=', 'users.id')
            ->select('tipo_solicitud.nombre AS SOLICITUD_NOMBRE', DB::raw('COUNT(solicitud.tipo_solicitud_id) AS TOTAL_SOLICITUD'))
            ->where('users.rols_id', $rols_id)
            ->groupBy('tipo_solicitud.id')
            ->orderByDesc('TOTAL_SOLICITUD')->get();
    }
    
    public function count_total_solictud(){      
        $rols_id = auth()->user()->rols_id;
        if($rols_id === 1){
            $resultado = DB::table('solicitud')
            ->join('tipo_solicitud', 'solicitud.tipo_solicitud_id', '=', 'tipo_solicitud.id')
            ->join('users', 'solicitud.users_id', '=', 'users.id')
            ->join('status', 'solicitud.status_id','=','status.id')
            ->select('tipo_solicitud.nombre AS SOLICITUD_NOMBRE', DB::raw('COUNT(tipo_solicitud.id) AS TOTAL_SOLICITUD'))
            ->where('solicitud.status_id', 5)
            ->groupBy('tipo_solicitud.id')
            ->orderByDesc('TOTAL_SOLICITUD')->get();
            return $resultado;
        }else{
            $resultado = DB::table('solicitud')
            ->join('tipo_solicitud', 'solicitud.tipo_solicitud_id', '=', 'tipo_solicitud.id')
            ->join('users', 'solicitud.users_id', '=', 'users.id')
            ->join('status', 'solicitud.status_id','=','status.id')
            ->select('tipo_solicitud.nombre AS SOLICITUD_NOMBRE', DB::raw('COUNT(tipo_solicitud.id) AS TOTAL_SOLICITUD'))
            ->where('solicitud.status_id', 5)
            ->groupBy('tipo_solicitud.id')
            ->orderByDesc('TOTAL_SOLICITUD')->get();
            return $resultado;}
        
    }
    public function nombreestado($idestado, $idmunicipio, $idparroquia, $idcomuna, $idcomunidad){
        $resultado = DB::table('solicitud')->join('estado', 'solicitud.estado_id', '=', 'estado.id')
        ->join('municipio', 'solicitud.municipio_id', '=', 'municipio.id')
        ->join('parroquia', 'solicitud.parroquia_id', '=', 'parroquia.id')
        ->join('comuna', 'solicitud.comuna_id', '=', 'comuna.id')
        ->join('comunidad', 'solicitud.comunidad_id', '=', 'comunidad.id')
        ->select('estado.nombre as estado2', 'municipio.nombre as municipio', 'parroquia.nombre as parroquia', 'comuna.codigo as comuna', 'comunidad.nombre as comunidad')
        ->where('estado.id', $idestado)
        ->where('municipio.id', $idmunicipio)
        ->where('parroquia.id', $idparroquia)
        ->where('comuna.id', $idcomuna)
        ->where('comunidad.id', $idcomunidad)
        ->get();
        return $resultado;
    }
}
