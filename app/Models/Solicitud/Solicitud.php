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
        'tipo_subsolicitud_id',
        'enter_descentralizados_id',
        'estado_id',
        'municipio_id',
        'parroquia_id',
        'comuna_id',
        'comunidad_id',
        'jefecomunidad_id',
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

    public function encasodeemergencia()
    {
        $resultados = DB::table('solicitud')
        ->leftJoin('tipo_solicitud', 'solicitud.tipo_solicitud_id', '=', 'tipo_solicitud.id')
        ->leftJoin('users', 'solicitud.users_id', '=', 'users.id')
        ->leftJoin('status', 'solicitud.status_id', '=', 'status.id')
        ->select(
            'tipo_solicitud.id AS SOLICITUD_ID',
            'tipo_solicitud.nombre AS SOLICITUD_NOMBRE',
            DB::raw('COUNT(*) AS TOTAL_SOLICITUD'),
            DB::raw('COUNT(CASE WHEN solicitud.status_id = 1 THEN 1 END) AS TOTAL_REGISTRADAS'),
            DB::raw('COUNT(CASE WHEN solicitud.status_id = 2 THEN 1 END) AS TOTAL_PROCESADAS'),
            DB::raw('COUNT(CASE WHEN solicitud.status_id = 5 THEN 1 END) AS TOTAL_FINALIZADAS')
        )
        ->groupBy('tipo_solicitud.id', 'tipo_solicitud.nombre')
        ->orderByDesc('TOTAL_SOLICITUD')
        ->get();

    return $resultados;
    }
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
            $solicitud = DB::table('solicitud')
                    ->join('tipo_solicitud', 'solicitud.tipo_solicitud_id', '=', 'tipo_solicitud.id')
                    ->join('direccion', 'solicitud.direccion_id', '=', 'direccion.id')
                    ->join('status', 'solicitud.status_id', '=','status.id')
                    ->join('users', 'solicitud.users_id', '=', 'users.id')
                    ->join('rols', 'users.rols_id', '=', 'rols.id')
                    ->where('tipo_solicitud.id', '!=', 6)
                    ->where('tipo_solicitud.id', '!=', 4)
                    ->where('tipo_solicitud.id', '!=', 5)
                    ->where('rols_id', $rols_id)
                    ->where('status_id', '!=', 5)
                    ->select(
                        'solicitud.id',
                        'solicitud.nombre AS solicitante',
                        'solicitud.cedula AS cedula',
                        'tipo_solicitud.nombre AS nombretipo',
                        'direccion.nombre AS direccionnombre',
                        'status.nombre AS nombrestatus',
                        'solicitud.denunciado'
                    ) // Extraer cedula     
                    ->get(); // Manejar otros roles
                    foreach ($solicitud as $item) {
                        $denunciado = json_decode($item->denunciado, true);                    
                        $item->cedula2 = $denunciado[0]['cedula'] ?? null; // Asignar cédula o null
                        
                        // Opcional: Eliminar el campo denunciado original si no lo necesitas
                        unset($item->denunciado); 
                    }

                    return $solicitud;
        }
        if($rols_id == 10){
            $solicitud = DB::table('solicitud')
                    ->join('tipo_solicitud', 'solicitud.tipo_solicitud_id', '=', 'tipo_solicitud.id')
                    ->join('direccion', 'solicitud.direccion_id', '=', 'direccion.id')
                    ->join('status', 'solicitud.status_id', '=','status.id')
                    ->join('users', 'solicitud.users_id', '=', 'users.id')
                    ->join('rols', 'users.rols_id', '=', 'rols.id')
                    ->where('tipo_solicitud.id', '!=', 4)
                    ->where('tipo_solicitud.id', '!=', 5)
                    ->where('rols_id', $rols_id)
                    ->where('status_id', '!=', 5)
                    ->select(
                        'solicitud.id',
                        'solicitud.nombre AS solicitante',
                        'solicitud.cedula AS cedula',
                        'tipo_solicitud.nombre AS nombretipo',
                        'direccion.nombre AS direccionnombre',
                        'status.nombre AS nombrestatus',
                        'solicitud.beneficiario' // Seleccionar el campo beneficiario completo
                    ) // Extraer cedula                    
                    ->get();

                
                // Parsear el JSON y agregar cedulabeneficiario
                foreach ($solicitud as $item) {
                    $beneficiario = json_decode($item->beneficiario, true);                    
                    $item->cedula2 = $beneficiario[0]['cedula'] ?? null; // Asignar cédula o null
                    
                    // Opcional: Eliminar el campo beneficiario original si no lo necesitas
                    unset($item->beneficiario); 
                }
    
                return $solicitud;
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
    public function getSolicitudList_DataTable2() {
        try {            
            $rols_id = auth()->user()->rols_id;            
            if ($rols_id === 10) {         
                $solicitud = DB::table('solicitud')
                    ->join('tipo_solicitud', 'solicitud.tipo_solicitud_id', '=', 'tipo_solicitud.id')
                    ->join('direccion', 'solicitud.direccion_id', '=', 'direccion.id')
                    ->join('status', 'solicitud.status_id', '=','status.id')
                    ->join('users', 'solicitud.users_id', '=', 'users.id')
                    ->join('rols', 'users.rols_id', '=', 'rols.id')
                    ->where('tipo_solicitud.id', '!=', 4)
                    ->where('tipo_solicitud.id', '!=', 5)
                    ->where('rols_id', $rols_id)
                    ->where('status_id', '!=', 5)
                    ->select(
                        'solicitud.id',
                        'solicitud.nombre AS solicitante',
                        'solicitud.cedula AS cedula',
                        'tipo_solicitud.nombre AS nombretipo',
                        'direccion.nombre AS direccionnombre',
                        'status.nombre AS nombrestatus',
                        'solicitud.beneficiario' // Seleccionar el campo beneficiario completo
                    ) // Extraer cedula                    
                    ->get();

                
                // Parsear el JSON y agregar cedulabeneficiario
                foreach ($solicitud as $item) {
                    $beneficiario = json_decode($item->beneficiario, true);                    
                    $item->cedula2 = $beneficiario[0]['cedula'] ?? null; // Asignar cédula o null
                    
                    // Opcional: Eliminar el campo beneficiario original si no lo necesitas
                    unset($item->beneficiario); 
                }
    
                return $solicitud;
            } else {
                    $solicitud = DB::table('solicitud')
                    ->join('tipo_solicitud', 'solicitud.tipo_solicitud_id', '=', 'tipo_solicitud.id')
                    ->join('direccion', 'solicitud.direccion_id', '=', 'direccion.id')
                    ->join('status', 'solicitud.status_id', '=','status.id')
                    ->join('users', 'solicitud.users_id', '=', 'users.id')
                    ->join('rols', 'users.rols_id', '=', 'rols.id')
                    ->where('tipo_solicitud.id', '!=', 6)
                    ->where('tipo_solicitud.id', '!=', 4)
                    ->where('tipo_solicitud.id', '!=', 5)
                    ->where('rols_id', $rols_id)
                    ->where('status_id', '!=', 5)
                    ->select(
                        'solicitud.id',
                        'solicitud.nombre AS solicitante',
                        'solicitud.cedula AS cedula',
                        'tipo_solicitud.nombre AS nombretipo',
                        'direccion.nombre AS direccionnombre',
                        'status.nombre AS nombrestatus',
                        'solicitud.denunciado'
                    ) // Extraer cedula     
                    ->get(); // Manejar otros roles
                    foreach ($solicitud as $item) {
                        $denunciado = json_decode($item->denunciado, true);                    
                        $item->cedula2 = $denunciado[0]['cedula'] ?? null; // Asignar cédula o null
                        
                        // Opcional: Eliminar el campo denunciado original si no lo necesitas
                        unset($item->denunciado); 
                    }

                    return $solicitud;
            }
        } catch (Throwable $e) {
            Log::error("Error en getSolicitudList_DataTable2: " . $e->getMessage()); 
            return [];
        }
    }
    
    public function getSolicitudList_DataTable3($params){
        try {
            return $solicitud = DB::table('solicitud')
            ->join('tipo_solicitud', 'solicitud.tipo_solicitud_id', '=', 'tipo_solicitud.id')
            ->join('direccion', 'solicitud.direccion_id', '=', 'direccion.id')
            ->join('status', 'solicitud.status_id', '=', 'status.id')
            ->join('users', 'solicitud.users_id', '=', 'users.id')
            ->join('comuna', 'solicitud.comuna_id', '=', 'comuna.id')
            ->select('solicitud.id','solicitud.nombre AS solicitante','comuna.codigo AS comuna','tipo_solicitud.nombre AS nombretipo','users.name AS analista','solicitud.beneficiario as beneficiario','solicitud.quejas AS quejas','solicitud.reclamo AS reclamo','solicitud.denuncia as denuncia','solicitud.denunciado as denunciado','direccion.nombre AS direccionnombre','status.nombre AS nombrestatus')
            ->orWhere('solicitud.id', $params)
            ->orWhere('solicitud.cedula', $params)->get();
        }catch(Throwable $e){
            $solicitud = [];
            return $solicitud;
        }
    }
    public function getSolicitudList_DataTable4($params){
        try {
            return $solicitud = DB::table('solicitud')
            ->join('tipo_solicitud', 'solicitud.tipo_solicitud_id', '=', 'tipo_solicitud.id')
            ->join('direccion', 'solicitud.direccion_id', '=', 'direccion.id')
            ->join('status', 'solicitud.status_id', '=', 'status.id')
            ->join('users', 'solicitud.users_id', '=', 'users.id')
            ->join('comuna', 'solicitud.comuna_id', '=', 'comuna.id')
            ->select('solicitud.id','solicitud.denunciado as denunciado')
            ->orWhere('solicitud.id', $params)
            ->orWhere('solicitud.cedula', $params)->get();
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
    public function count_solictud2()
    {

        return DB::table('solicitud')
            ->join('tipo_solicitud', 'solicitud.tipo_solicitud_id', '=', 'tipo_solicitud.id')
            ->join('users', 'solicitud.users_id', '=', 'users.id')
            ->select('tipo_solicitud.nombre AS SOLICITUD_NOMBRE', DB::raw('COUNT(solicitud.tipo_solicitud_id) AS TOTAL_SOLICITUD'))
            ->groupBy('tipo_solicitud.id')
            ->orderByDesc('TOTAL_SOLICITUD')->get();
    }
    public function count_solictud3()
    {
      
        return DB::table('solicitud')
            ->join('tipo_solicitud', 'solicitud.tipo_solicitud_id', '=', 'tipo_solicitud.id')
            ->join('users', 'solicitud.users_id', '=', 'users.id')
            ->join('status', 'solicitud.status_id', '=', 'status.id')
            ->select('tipo_solicitud.nombre AS SOLICITUD_NOMBRE', DB::raw('COUNT(solicitud.tipo_solicitud_id) AS TOTAL_SOLICITUD'))
            ->where('solicitud.status_id', 2)
            ->groupBy('tipo_solicitud.id')
            ->orderByDesc('TOTAL_SOLICITUD')->get();
    }

    public function count_solictud4()
    {
      
        return DB::table('solicitud')
            ->join('tipo_solicitud', 'solicitud.tipo_solicitud_id', '=', 'tipo_solicitud.id')
            ->join('users', 'solicitud.users_id', '=', 'users.id')
            ->join('status', 'solicitud.status_id', '=', 'status.id')
            ->select('tipo_solicitud.nombre AS SOLICITUD_NOMBRE', DB::raw('COUNT(solicitud.tipo_solicitud_id) AS TOTAL_SOLICITUD'))
            ->where('solicitud.status_id', 5)
            ->groupBy('tipo_solicitud.id')
            ->orderByDesc('TOTAL_SOLICITUD')->get();
    }

    public function count_solictud5()
    {
        $resultados = DB::table('solicitud')
        ->leftJoin('status', 'solicitud.status_id', '=', 'status.id')
        ->select(
            DB::raw('COUNT(*) AS TOTAL_SOLICITUD'),
            DB::raw('COUNT(CASE WHEN solicitud.status_id = 1 THEN 1 END) AS TOTAL_REGISTRADAS'),
            DB::raw('COUNT(CASE WHEN solicitud.status_id = 2 THEN 1 END) AS TOTAL_PROCESADAS'),
            DB::raw('COUNT(CASE WHEN solicitud.status_id = 5 THEN 1 END) AS TOTAL_FINALIZADAS')
        )
        ->first();

    return $resultados;
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
            ->where('users.rols_id', $rols_id)
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
