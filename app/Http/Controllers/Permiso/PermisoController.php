<?php
/**
* Realizado por @author Tarsicio Carrizales Agosto 2021
* Correo: telecom.com.ve@gmail.com
*/
namespace App\Http\Controllers\Permiso;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User\User;
use App\Http\Controllers\User\Colores;
use App\Models\Security\Modulo;
use App\Models\Security\Rol;
use App\Models\Security\Permiso;
use Auth;
use App\Models\Security\CreateRecordPermiso AS InsertRecord;

class PermisoController extends Controller{
    /**
     * Display a listintostg of the resource.
     * @author Tarsicio Carrizales telecom.com.ve@gmail.com
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request){        
        if($request->name == null){
            $rols_id = Auth::user()->rols_id;
        }else{
            $rols_id = $request->name;
        }        
        $buscar = (new Rol)->find($rols_id); 
        if($buscar == null){
            $rols_id = 1;
            alert()->info(trans('message.mensajes_alert.url_alterada'),
                trans('message.mensajes_alert.url_mensaje'));
        }        
        $int = (int)$rols_id;        
        session(['rols_id' => $int]);
        $count_notification = (new User)->count_noficaciones_user();        
        $permisos = (new Permiso)->datos_Permiso($rols_id);
        $roles = (new Rol)->datos_roles();
        $nombre_rol = (new Rol)->get_nombre_rol($rols_id);
        $total_registros = $permisos->count();
        if($total_registros == 0){            
            alert()->info(trans('message.mensajes_alert.creando'),
                trans('message.mensajes_alert.creando_permisos'));
            /**
             * success
             * error
             * warning
             * info
             * question 
             */
            $modulos = (new Modulo)->datos_modulos();
            foreach($modulos as $modulo){
                $bolean = (new InsertRecord)->generarPermisosModuloRol($modulo->id,$rols_id);
            }            
            alert()->success(trans('message.mensajes_alert.permisos_creado'),trans('message.mensajes_alert.mensaje_permiso_new'));
        }
        /**
        * Si se genera un nuevo módulo, al pasar por esta sección será verificado
        * y de no existir se creará, de acuerdo a la normativa establecida.
        * */
        $modulos = (new Modulo)->datos_modulos();
        foreach($modulos as $modulo){
            $existe = (new permiso)->existe_Permiso($modulo->id,$rols_id);
            if(!$existe){
                $bolean = (new InsertRecord)->generarPermisosModuloRol($modulo->id,$rols_id);
                toast(trans('message.mensajes_alert.new_permission') .$modulo->name,'success')->timerProgressBar();
            }                
        }
        $array_color = (new Colores)->getColores();                              
        return view('Permiso.permisos',
            compact('count_notification','permisos',
                    'roles','nombre_rol','rols_id','array_color'));        
    }

    /**
     * Display a listing of the resource.
     * @author Tarsicio Carrizales telecom.com.ve@gmail.com
     * @return \Illuminate\Http\Response
     */
    public function getModulos(Request $request){    
        try{
            if ($request->ajax()) {
                $data =  (new Modulo)->getModulosList_DataTable();                
                return datatables()->of($data)
                ->addColumn('edit', function ($data) {
                    $rols_id = Auth::user()->rols_id;                    
                    if(session('rols_id') == 1){
                        $edit ='<a href="" id="edit_'.$data->id.'" class=" editar_permiso btn btn-xs btn-primary disabled" style="background-color: #2962ff;" data-toggle="modal" data-backdrop="static" data-target="#edit_permisos" onclick="update_permisos('.$data->id.')"><b><i class="fa fa-pencil"></i>&nbsp;' .trans('message.botones.edit').'</b></a>';
                    }else{
                        $edit ='<a href="" id="edit_'.$data->id.'" class=" editar_permiso btn btn-xs btn-primary" style="background-color: #2962ff;" data-toggle="modal" data-backdrop="static" data-target="#edit_permisos" onclick="update_permisos('.$data->id.')"><b><i class="fa fa-pencil"></i>&nbsp;' .trans('message.botones.edit').'</b></a>';
                    }
                    return $edit;
                })
                ->addColumn('view', function ($data) {
                    return '<a href="" id="view_'.$data->id.'" class="ver_permiso btn btn-xs btn-primary" style="background-color: #5333ed;" data-toggle="modal" data-backdrop="static" data-target="#view_permisos" onclick="mostrar_permisos('.$data->id.')"><b><i class="fa fa-eye"></i>&nbsp;' .trans('message.botones.view').'</b></a>';
                })
                ->rawColumns(['edit','view'])->toJson();
            }
        }catch(Throwable $e){
            echo "Captured Throwable: " . $e->getMessage(), "\n";
        }        
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        //
    }

    /**
     * Display the specified resource.
     * @author Tarsicio Carrizales telecom.com.ve@gmail.com
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,$rols_id){        
        
        return view('Permiso.permisos',
            compact('count_notification','permisos',
                    'roles','nombre_rol','rols_id'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id){
        //
    }

    /**
     * Update the specified resource in storage.
     * @author Tarsicio Carrizales telecom.com.ve@gmail.com
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id,$accion,$allow_deny){        
        if($request->ajax()) {
            $resultado = (new Permiso)->setUpdatePermiso($id,$accion,$allow_deny);            
            return response()->json($resultado);        
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id){
        return response()->json($id);
    }

    /**     
     * @author Tarsicio Carrizales telecom.com.ve@gmail.com 
     */
    public function getPermisos(Request $request, $modulo_id,$rol_id){
        if($request->ajax()) {
            $resultado = (new Permiso)->get_Permisos_Rol_Modulos($modulo_id,$rol_id);
            return response()->json($resultado);        
        }
    }

    /**     
     * @author Tarsicio Carrizales telecom.com.ve@gmail.com 
     */
    public function updateAllPermisos(Request $request, $id,$allow_deny){        
        if($request->ajax()) {
            $resultado = (new Permiso)->setUpdateAllPermisos($id,$allow_deny);            
            return response()->json($resultado);        
        }        
    }

}
