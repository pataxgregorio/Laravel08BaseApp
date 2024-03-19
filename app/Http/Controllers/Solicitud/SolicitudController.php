<?php

namespace App\Http\Controllers\Solicitud;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User\User;
use App\Models\Solicitud\Solicitud;
use App\Http\Requests\User\StoreUser;
use App\Http\Requests\User\UpdateUser;
use App\Models\Security\Rol;
use App\Models\Estados\Estados;
use App\Models\Municipio\Municipio;
use App\Models\Parroquia\Parroquia;
use App\Models\Comuna\Comuna;
use App\Models\Comunidad\Comunidad;
use App\Models\Direccion\Direccion;
use App\Models\Enter\Enter;
use App\Models\Coordinacion\Coordinacion;
use App\Models\Tipo_Solicitud\Tipo_Solicitud;
use Auth;
use Dompdf\Dompdf;
use App\Notifications\WelcomeUser;
use App\Notifications\RegisterConfirm;
use App\Notifications\NotificarEventos;
use Carbon\Carbon;
use App\Http\Controllers\User\Colores;


class SolicitudController extends Controller
{
    /**
     * Display a listing of the resource.
     * @author Tarsicio Carrizales telecom.com.ve@gmail.com
     * @return \Illuminate\Http\Response
     */
    public function index(){        
        $count_notification = (new User)->count_noficaciones_user();
        $tipo_alert = "";
        if(session('delete') == true){
            $tipo_alert = "Delete";
            session(['delete' => false]);
        }        
        if(session('update') == true ){
            $tipo_alert = "Update";
            session(['update' => false]);
        }        
        $array_color = (new Colores)->getColores();
        return view('Solicitud.solicitud',compact('count_notification','tipo_alert','array_color'));
    }

    public function getSolicitud(Request $request){
        try{
           
            if ($request->ajax()) {                
                $data =  (new Solicitud)-> getSolicitudList_DataTable();                
                return datatables()->of($data)
                          
                ->addColumn('edit', function ($data) {
                    $user = Auth::user();                    
                    if(($user->id != 1)){
                        $edit ='<a href="'.route('users.edit', $data->id).'" id="edit_'.$data->id.'" class="btn btn-xs btn-primary disabled" style="background-color: #2962ff;"><b><i class="fa fa-pencil"></i>&nbsp;' .trans('message.botones.edit').'</b></a>';
                    }else{
                        $edit ='<a href="'.route('users.edit', $data->id).'" id="edit_'.$data->id.'" class="btn btn-xs btn-primary" style="background-color: #2962ff;"><b><i class="fa fa-pencil"></i>&nbsp;' .trans('message.botones.edit').'</b></a>';
                    }
                    return $edit;
                })
                ->addColumn('view', function ($data) {
                    return '<a style="background-color: #5333ed;" href="'.route('users.view', $data->id).'" id="view_'.$data->id.'" class="btn btn-xs btn-primary"><b><i class="fa fa-eye"></i>&nbsp;' .trans('message.botones.view').'</b></a>';
                })
                ->addColumn('del', function ($data) {
                    if($data->id == 1){
                        $del ='<a href="javascript:void(0)" action=""><button type="submit" class="btn btn-danger btn-xs" data-toggle="tooltip" data-title="Eliminar" data-container="body" style="background-color: #900C3F;" disabled><b><i class="fa fa-trash"></i>&nbsp;' .trans('message.botones.delete').'</b>';
                    }else{
                        $del ='<a href="javascript:void(0)" action="'.route('users.destroy', $data->id).'" onclick="deleteData(this)"><button type="submit" class="btn btn-danger btn-xs" data-toggle="tooltip" data-title="Eliminar" data-container="body" style="background-color: #900C3F;"><b><i class="fa fa-trash"></i>&nbsp;' .trans('message.botones.delete').'</b>';
                    }
                    return $del;
                })                
                ->rawColumns(['edit','view','del'])->toJson();  
            }
        }catch(Throwable $e){
            echo "Captured Throwable: " . $e->getMessage(), "\n";
        }        
    }

    public function profile(){
        $count_notification = (new User)->count_noficaciones_user();
        $user = Auth::user();
        $array_color = (new Colores)->getColores();
        return view('User.profile',compact('count_notification','user','array_color'));
    }
    
    public function usersPrint(){
        //generate some PDFs!
        $html = '<div style="text-align:center"><h1>(PROYECT / PROYECTO) HORUS-1221</h1></div>
        <div style="text-align:center">(Create By / Creado Por) - Tarsicio Carrizales</div>
        <div style="text-align:center">(Mail / Correo) -  telecom.com.ve@gmail.com</div>
        <div style="text-align:center">(Contact Cell Phone / Número Movil Contacto) - +58+412-054.53.69</div>
        <div style="text-align:center">LARAVEL 8 and PWA, PHP 7.4 DATE: NOV / 2021</div>';
        $dompdf = new DOMPDF();  //if you use namespaces you may use new \DOMPDF()
        $dompdf->loadHtml($html);
        $dompdf->setPaper('latter', 'portrait');
        $dompdf->render();
        $dompdf->stream("Tarsicio_Carrizales_Proyecto_Horus.pdf", array("Attachment"=>1));        
        return redirect()->back();
    }    

    public function update_avatar(Request $request, $id){
        $count_notification = (new User)->count_noficaciones_user();
        $user = Auth::user();
        $user_Update = User::find($id);
        $avatar_viejo = $user_Update->avatar; 
        $this->update_image($request,$avatar_viejo,$user_Update);
        $user_Update->updated_at = \Carbon\Carbon::now();
        $user_Update->save();
        session(['update' => true]);        
        return redirect('/users');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
        $titulo_modulo = trans('message.users_action.new_user');
        $count_notification = (new User)->count_noficaciones_user();
        $roles = (new Rol)->datos_roles();
        $estado = (new Estados)->datos_estados();
        $municipio = (new Municipio)->datos_municipio();
        $parroquia = (new Parroquia)->datos_parroquia();
        $array_color = (new Colores)->getColores();
        $tipo_solicitud =(new Tipo_Solicitud)->datos_tipo_solicitud();   
        $direcciones =(new Direccion)->datos_direccion();   
        $enter =(new Enter)->datos_enter(); 
        $comuna = [];
        $coordinacion = [];
        $comunidad = [];
        return view('Solicitud.solicitud_create',compact('count_notification','titulo_modulo','roles','municipio','comuna','comunidad','direcciones','parroquia','estado','coordinacion','enter','tipo_solicitud','array_color'));        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        /**
         * Recuerde de Activar la cola de trabajo con
         * php artisan queue:work database --tries=3 --backoff=10
         * o instalar en su servidor linux (Debian ó Ubuntu) el supervisor de la siguiente manera
         * sudo apt-get install supervisor
         * Si no realiza ninguna configuración todos los trabajos se iran guardando en la 
         * tabla jobs, y una vez configure, los trabajos en cola se iran ejecutando
         * Si se ejecuta algún error estos se guardan en la tabla failed_jobs.
         * Para ejcutar los trabajos en failed_jobs ejecute:
         * php artisan queue:retry all
         * Debe realizar configuraciones adicionales, en caso de requerir
         * busque información en Internet para culminar la configuracion de requerir.
         * https://laravel.com/docs/8.x/queues#supervisor-configuration
         */
        // Target URL


        $input = $request->all();
       $input['users_id'] = Auth::user()->id;
     //  $data['is_deleted'] = false;
    // var_dump ($input);
 //   exit();
      $recaudos =NULL;

      $input['quejas'] = NULL;
      $input['reclamos'] = NULL;
      $input['sugerencia'] = NULL;
      $input['asesoria'] = NULL;
      $input['beneficiario'] = NULL;
      $input['denuncia'] = NULL;
      $input['denunciado'] = NULL;
      $input['recaudos']=$recaudos;
      $input['codigocontrol']="001";
    if ($input['tipo_solicitud_id']== 1){
        $denuncia = [
            [
                "relato" => $input['relato'],
                "observacion" => $input['observacion'],
                "expliquepresentada" => $input['explique'],
                "explique competencia" => $input['explique2']
            ]
        ];   $denunciado = [
            [
                "cedula" =>  $input['ceduladenunciado'],
                "nombre" =>  $input['nombredenunciado'],
                "testigo" =>  $input['testigo']
            ]
        ];
        $recaudos = [
            [
                "cedula" =>  $input['checkcedula']?: NULL,
                "motivo" =>  $input['checkmotivo']?: NULL,
                "video" =>  $input['checkvideo']?: NULL,
                "foto" =>  isset($input['checkfoto']) ? NULL : $input['checkfoto'],
                "grabacion" =>  $input['checkgrabacion']?: NULL,
                "testigo" =>  $input['checktestigo']?: NULL,
                "residencia" =>  $input['checkresidencia']?: NULL
            ]
        ];

         $input['denuncia'] = json_encode($denuncia);
         $input['denunciado'] = json_encode($denunciado);
         $input['recaudos'] = json_encode($recaudos);

     }
     if ($input['tipo_solicitud_id']== 2){
        $queja = [
            [
                "relato" => $input['relato'],
                "observacion" => $input['observacion'],
                "expliquepresentada" => $input['explique'],
                "explique competencia" => $input['explique2']
            ]
        ];   $denunciado = [
            [
                "cedula" =>  $input['ceduladenunciado'],
                "nombre" =>  $input['nombredenunciado'],
                "testigo" =>  $input['testigo']
            ]
        ];
        $recaudos = [
            [
                "cedula" =>  $input['checkcedula']?: NULL,
                "motivo" =>  $input['checkmotivo']?: NULL,
                "video" =>  $input['checkvideo']?: NULL,
                "foto" =>  isset($input['checkfoto']) ? NULL : $input['checkfoto'],
                "grabacion" =>  $input['checkgrabacion']?: NULL,
                "testigo" =>  $input['checktestigo']?: NULL,
                "residencia" =>  $input['checkresidencia']?: NULL
            ]
        ];

         $input['quejas'] = json_encode($queja);
         $input['denunciado'] = json_encode($denunciado);
         $input['recaudos'] = json_encode($recaudos);
     }
     if ($input['tipo_solicitud_id']== 3){
        $reclamo = [
            [
                "relato" => $input['relato'],
                "observacion" => $input['observacion'],
                "expliquepresentada" => $input['explique'],
                "explique competencia" => $input['explique2']
            ]
        ];   $denunciado = [
            [
                "cedula" =>  $input['ceduladenunciado'],
                "nombre" =>  $input['nombredenunciado'],
                "testigo" =>  $input['testigo']
            ]
        ];
        $recaudos = [
            [
                "cedula" =>  $input['checkcedula']?: NULL,
                "motivo" =>  $input['checkmotivo']?: NULL,
                "video" =>  $input['checkvideo']?: NULL,
                "foto" =>  isset($input['checkfoto']) ? NULL : $input['checkfoto'],
                "grabacion" =>  $input['checkgrabacion']?: NULL,
                "testigo" =>  $input['checktestigo']?: NULL,
                "residencia" =>  $input['checkresidencia']?: NULL
            ]
        ];

         $input['reclamos'] = json_encode($reclamo);
         $input['denunciado'] = json_encode($denunciado);
         $input['recaudos'] = json_encode($recaudos);
     }
     if ($input['tipo_solicitud_id']== 4){
        $sugerencia = [
            [
                "observacion" => $input['observacion2'],
            ]
        ];  
        $recaudos = [
            [
                "motivo" =>  $input['checkmotivo']?: NULL
            ]
        ];

         $input['sugerencia'] = json_encode($sugerencia);
         $input['recaudos'] = json_encode($recaudos);
     }
     if ($input['tipo_solicitud_id']== 5){
        $asesoria = [
            [
                "observacion" => $input['observacion2'],
            ]
        ];  
        $recaudos = [
            [
                "motivo" =>  $input['checkmotivo']?: NULL
            ]
        ];

         $input['asesoria'] = json_encode($asesoria);
         $input['recaudos'] = json_encode($recaudos);
     }
     if ($input['tipo_solicitud_id']== 6){
      $beneficiario = [
            [
                "cedula" =>  $input['cedulabeneficiario']?: NULL,
                "nombre" =>  $input['nombrebeneficiario']?: NULL,
                "direccion" =>  $input['direccionbeneficiario']?: NULL
            ]
        ];

         $input['beneficiario'] = json_encode($beneficiario);
     }
        $solicitud = new Solicitud([
            'users_id' =>$input['users_id'],
            'direccion_id' => $input['direcciones_id'],
            'coordinacion_id' => $input['coordinacion_id'],                        
            'tipo_solicitud_id' => $input['tipo_solicitud_id'],
            'enter_descentralizados_id' => $input['enter_id'],
            'estado_id' => $input['estado_id'],
            'municipio_id' => $input['municipio_id'],
            'parroquia_id' =>$input['parroquia_id'],                        
            'comuna_id' => $input['comuna_id'],
            'comunidad_id' => $input['comunidad_id'],
            'codigo_control' => $input['codigocontrol'],
            'status_id' => 1,
            'nombre' => $input['nombre'],
            'cedula' => $input['cedula'],
            'sexo' => $input['sexo'],
            'email' => $input['cedula'],
            'direccion' => $input['direccion'],
            'fecha'  => \Carbon\Carbon::now(),
            'telefono' => $input['telefono'],
            'telefono2' => $input['telefono2'],
            'organismo' => NULL,
            'edocivil' => $input['edocivil'],
            'fechaNacimiento' => $input['fechanacimiento'],
            'nivelestudio' => $input['niveleducativo'],
            'profesion' => $input['profesion'],
            'recaudos' => $input['recaudos'],
            'beneficiario' => $input['beneficiario'],
            'quejas' => $input['quejas'],
            'reclamo' => $input['reclamos'],
            'sugerecia' => $input['sugerencia'],
            'asesoria' => $input['asesoria'],
            'denuncia' => $input['denuncia'],
            'denunciado' => $input['denunciado'],
           
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
        ]);
        $solicitud->save();    
        $count_notification = (new User)->count_noficaciones_user();        
        $tipo_alert = "Create";
        $array_color = (new Colores)->getColores();
        return view('Solicitud.solicitud',compact('count_notification','tipo_alert','array_color'));
    }        

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function view($id){
        $user_View =  (new User)->ver_User($id);        
        if($user_View[0]->ID != 1){
            $init_day = Carbon::parse($user_View[0]->FECHA_INICIO)->format('Y-m-d');
            $end_day = Carbon::parse($user_View[0]->FECHA_FIN)->format('Y-m-d');
            $user_View[0]->FECHA_INICIO = $init_day;
            $user_View[0]->FECHA_FIN = $end_day;
        }        
        $count_notification = (new User)->count_noficaciones_user();
        $titulo_modulo = trans('message.users_action.show_user');
        $array_color = (new Colores)->getColores();        
        return view('User.show',compact('count_notification','titulo_modulo','user_View','array_color'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id){
        $user_edit = User::find($id);
        $rols_id = auth()->user()->rols_id;        
        if($user_edit->id != 1){
            $init_day = Carbon::parse($user_edit->init_day)->format('Y-m-d');
            $end_day = Carbon::parse($user_edit->end_day)->format('Y-m-d');
            $user_edit->init_day = $init_day;
            $user_edit->end_day = $end_day;        
        }        
        $titulo_modulo = trans('message.users_action.edit_user');
        $count_notification = (new User)->count_noficaciones_user();
        $roles = (new Rol)->datos_roles();
        $array_color = (new Colores)->getColores();
        return view('User.user_edit',compact('count_notification','titulo_modulo','roles','user_edit','array_color','rols_id'));
    }
public function getComunas(Request $request){
  
    $comuna = (new Comuna)->datos_comuna( $request['parroquia']);
         
    return $comuna;

}
public function getComunidad(Request $request){
  
    $comunidad = (new Comunidad)->datos_comunidad( $request['comuna']);
         
    return $comunidad;

}
public function getCoodinacion(Request $request){
  
    $coordinacion = (new Coordinacion)->datos_coordinacion( $request['direccion']);
         
    return $coordinacion;

}

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUser $request, $id){        
        $count_notification = (new User)->count_noficaciones_user();
        $user = Auth::user();        
        $user_Update = User::find( $id);
        $avatar_viejo = $user_Update->avatar;            
        if($id == 1){            
            $user_Update->password = \Hash::make('123456789');
            //$user_Update->password = \Hash::make($request->password);
            $this->update_image($request,$avatar_viejo,$user_Update);
            $user_Update->updated_at = \Carbon\Carbon::now();
            $user_Update->save();
        }else{
            $user_Update->name = $request->name;
            $user_Update->password = \Hash::make($request->password);
            if($user->rols_id == 1){
                $user_Update->activo = $request->activo;
                $user_Update->rols_id = $request->rols_id;
                $user_Update->init_day = $request->init_day;
                $user_Update->end_day = $request->end_day;
            }            
            $this->update_image($request,$avatar_viejo,$user_Update);
            $user_Update->updated_at = \Carbon\Carbon::now();
            $user_Update->save();
        }
        session(['update' => true]);            
        return redirect('/users');
    }

    private function update_image($request,$avatar_viejo,&$user_Update){
        /** Se actualizan todos los datos solicitados por el Cliente 
        *  y eliminamos del Storage/avatars, el archivo indicado.
        */
        if($request->hasFile('avatar')){
            $esta = file_exists(public_path('/storage/avatars/'.$avatar_viejo));            
            if($avatar_viejo != 'default.jpg' && $esta){                
                unlink(public_path('/storage/avatars/'.$avatar_viejo));               
            }  
            $avatar = $request->file('avatar');          
            $filename = time() . '.' . $avatar->getClientOriginalExtension();            
            \Image::make($avatar)->resize(300, 300)
            ->save( public_path('/storage/avatars/' . $filename ) );            
            $user_Update->avatar = $filename;                
        }
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id){        
        $user_delete = User::find($id);
        $nombre = $user_delete->name;
        User::destroy($id);
        $esta = file_exists(public_path('/storage/avatars/'.$user_delete->avatar));            
        if($user_delete->avatar != 'default.jpg' && $esta){                            
            unlink(public_path('/storage/avatars/'.$user_delete->avatar));
        }  
        session(['delete' => true]);
        return redirect('/users');
    }

    public function usuarioRol(Request $request){
      if($request->ajax()){
        $countUserRol = (new User)->count_User_Rol();        
        return response()->json($countUserRol);
      }
    }

    public function notificationsUser(Request $request){
      if($request->ajax()){
        $countNotificationsUsers = (new User)->count_User_notifications();        
        return response()->json($countNotificationsUsers);
      }
    }

    public function colorView(){
        $titulo_modulo = trans('message.users_action.cambiar_colores');
        $count_notification = (new User)->count_noficaciones_user();
        $array_color = (new Colores)->getColores();
        return view('User.color_view',compact('count_notification','titulo_modulo','array_color'));
    }

    public function colorChange(Request $request){
        $id = auth()->user()->id;            
        $user = User::find($id);            
        $colores = $user->colores;            
        if($request->dafault_color_01 == 'NO'){            
            $colores['encabezado'] = $request->encabezado_user;
            $colores['menu'] = $request->menu_user;
            $colores['group_button'] = $request->group_button;
            $colores['back_button'] = $request->back_button;                        
            $user->colores = $colores;            
            $user->save();
            session(['menu_color' => $request->menu_user]);
            session(['encabezado_color' => $request->encabezado_user]);
            session(['group_button_color' => $request->group_button]);
            session(['back_button_color' => $request->back_button]);            
        }elseif($request->dafault_color_01 == 'YES'){
            $colores['encabezado'] = '#5333ed';
            $colores['menu'] = '#0B0E66';
            $colores['group_button'] = '#5333ed';
            $colores['back_button'] = '#5333ed';                        
            $user->colores = $colores;            
            $user->save();
            session(['menu_color' => '#0B0E66']);
            session(['encabezado_color' => '#5333ed']);
            session(['group_button_color' => '#5333ed']);
            session(['back_button_color' => '#5333ed']);
        }elseif($request->dafault_color_01 == 'BLUE'){
            $colores['encabezado'] = '#81898f';
            $colores['menu'] = '#3e5f8a';
            $colores['group_button'] = '#474b4e';
            $colores['back_button'] = '#474b4e';                        
            $user->colores = $colores;            
            $user->save();
            session(['menu_color' => '#3e5f8a']);
            session(['encabezado_color' => '#81898f']);
            session(['group_button_color' => '#474b4e']);
            session(['back_button_color' => '#474b4e']);
        }elseif($request->dafault_color_01 == 'GREEN'){
            $colores['encabezado'] = '#0b9a93';
            $colores['menu'] = '#198c86';
            $colores['group_button'] = '#008080';
            $colores['back_button'] = '#008080';                        
            $user->colores = $colores;            
            $user->save();
            session(['menu_color' => '#198c86']);
            session(['encabezado_color' => '#0b9a93']);
            session(['group_button_color' => '#008080']);
            session(['back_button_color' => '#008080']);
        }else{
            $colores['encabezado'] = '#000000';
            $colores['menu'] = '#000000';
            $colores['group_button'] = '#000000';
            $colores['back_button'] = '#000000';                        
            $user->colores = $colores;            
            $user->save();
            session(['menu_color' => '#000000']);
            session(['encabezado_color' => '#000000']);
            session(['group_button_color' => '#000000']);
            session(['back_button_color' => '#000000']);
        }    
        return redirect('/dashboard');    
    }

}