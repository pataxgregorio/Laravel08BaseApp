<?php
/**
* Realizado por @author Tarsicio Carrizales Agosto 2021
* Correo: telecom.com.ve@gmail.com
*/
namespace App\Http\Controllers\Rol;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Rol\StoreRol;
use App\Http\Requests\Rol\UpdateRol;
use App\Models\User\User;
use App\Http\Controllers\User\Colores;
use App\Models\Security\Modulo;
use App\Models\Security\Rol;
use App\Models\Security\Permiso;
use Auth;

class RolController extends Controller
{
    /**
     * Display a listing of the resource.
     * @author Tarsicio Carrizales telecom.com.ve@gmail.com
     * @return \Illuminate\Http\Response
     */
    public function index()
    {        
        $count_notification = (new User)->count_noficaciones_user();
        $tipo_alert = "";
        if(session('delete') == true){
            $tipo_alert = "Delete";
            session(['delete' => false]);
        }
        if(session('delete_02') == true){
            $tipo_alert = "Delete_02";
            session(['delete_02' => false]);
        }
        if(session('update') == true ){
            $tipo_alert = "Update";
            session(['update' => false]);
        }
        $array_color = (new Colores)->getColores();
        return view('Rol.rols',compact('count_notification','tipo_alert','array_color'));
    }

    /**
     * Display a listing of the resource.
     * @author Tarsicio Carrizales telecom.com.ve@gmail.com
     * @return \Illuminate\Http\Response
     */
    public function getRols(Request $request){     
        try{
            if ($request->ajax()) {
                $data =  (new Rol)->getRolsList_DataTable();                
                return datatables()->of($data)
                ->addColumn('edit', function ($data) {
                    $user = Auth::user();                    
                    if($data->name == 'ROOT'){
                        $edit ='<a href="'.route('rols.edit', $data->id).'" id="edit_'.$data->id.'" class="btn btn-xs btn-primary disabled" style="background-color: #2962ff;"><b><i class="fa fa-pencil"></i>&nbsp;' .trans('message.botones.edit').'</b></a>';
                    }else{
                        $edit ='<a href="'.route('rols.edit', $data->id).'" id="edit_'.$data->id.'" class="btn btn-xs btn-primary" style="background-color: #2962ff;"><b><i class="fa fa-pencil"></i>&nbsp;' .trans('message.botones.edit').'</b></a>';
                    }
                    return $edit;
                })
                ->addColumn('view', function ($data) {
                    return '<a href="'.route('rols.show', $data->id).'" id="view_'.$data->id.'" class="btn btn-xs btn-primary" style="background-color: #5333ed;"><b><i class="fa fa-eye"></i>&nbsp;' .trans('message.botones.view').'</b></a>';
                })
                ->addColumn('del', function ($data) {
                    $user = Auth::user();                    
                    if($data->name == 'ROOT'){
                        $del ='<a href="javascript:void(0)" action=""><button type="submit" class="btn btn-danger btn-xs" data-toggle="tooltip" data-title="Eliminar" data-container="body" style="background-color: #900C3F;" disabled><b><i class="fa fa-trash"></i>&nbsp;' .trans('message.botones.delete').'</b>';
                    }else{
                        $del ='<a href="javascript:void(0)" action="'.route('rols.destroy', $data->id).'" onclick="deleteData(this)"><button type="submit" class="btn btn-danger btn-xs" data-toggle="tooltip" data-title="Eliminar" data-container="body" style="background-color: #900C3F;"><b><i class="fa fa-trash"></i>&nbsp;' .trans('message.botones.delete').'</b>';
                    }
                    return $del;
                })                
                ->rawColumns(['edit','view','del'])->toJson();        
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
        $count_notification = (new User)->count_noficaciones_user();
        $titulo_modulo = trans('message.rols_action.new_rols');
        $array_color = (new Colores)->getColores();        
        return view('Rol.rols_create',compact('count_notification','titulo_modulo','array_color'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRol $request){    
        $count_notification = (new User)->count_noficaciones_user();
        $rol = new Rol([                            
                        'name' => strtoupper($request->name),
                        'description' => $request->description,
                        'created_at' => \Carbon\Carbon::now(),
                        'updated_at' => \Carbon\Carbon::now(),
                    ]);
        $rol->save();
        $tipo_alert = "Create";
        $array_color = (new Colores)->getColores();               
        return view('Rol.rols',compact('count_notification','tipo_alert','array_color'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id){
        $rol = Rol::find($id);
        $count_notification = (new User)->count_noficaciones_user();
        $titulo_modulo = trans('message.rols_action.show_rols');
        $array_color = (new Colores)->getColores();               
        return view('Rol.rols_show',compact('count_notification','titulo_modulo','rol','array_color'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id){
        $rol = Rol::find($id);
        $count_notification = (new User)->count_noficaciones_user();
        $titulo_modulo = trans('message.rols_action.edit_rols');
        $array_color = (new Colores)->getColores();               
        return view('Rol.rols_edit',compact('count_notification','titulo_modulo','rol','array_color'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRol $request, $id){
        $rol_Update = Rol::find($id);
        $rol_Update->description = $request->description;
        $rol_Update->updated_at = \Carbon\Carbon::now();
        $rol_Update->save();
        session(['update' => true]);        
        return redirect('/rols');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id){
        $rol_Delete = Rol::find($id);        
        $nombre_rol = $rol_Delete->name;        
        $no_Asociado = (new Rol)->buscarTablasAsociados($id);
        //dd($no_Asociado);
        if(!$no_Asociado){
            Rol::destroy($id);
            session(['delete' => true]);            
        }else{
            session(['delete_02' => true]);            
        }        
        return redirect('/rols');
    }

    public function rolsPrint(){
        
        return redirect()->back();
    }
}
