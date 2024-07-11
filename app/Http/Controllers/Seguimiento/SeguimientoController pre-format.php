<?php

namespace App\Http\Controllers\Seguimiento;
use DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User\User;
use App\Models\Solicitud\Solicitud;
use App\Models\Seguimiento\Seguimiento;
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

class SeguimientoController extends Controller
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
        return view('Seguimiento.seguimiento',compact('count_notification','tipo_alert','array_color'));
    }

    public function getSeguimiento(Request $request){
        try{
           
            if ($request->ajax()) {                
                $data =  (new Solicitud)-> getSolicitudList_DataTable2();                
                return datatables()->of($data)
                          
                ->addColumn('edit', function ($data) {
                    $user = Auth::user();                    
                    if(($user->id != 1)){
                        $edit ='<a href="'.route('seguimiento.edit', $data->id).'" id="edit_'.$data->id.'" class="btn btn-xs btn-primary" style="background-color: #2962ff;"><b><i class="fa fa-pencil"></i>&nbsp;' .trans('message.botones.go').'</b></a>';
                    }else{
                        $edit ='<a href="'.route('seguimiento.edit', $data->id).'" id="edit_'.$data->id.'" class="btn btn-xs btn-primary" style="background-color: #2962ff;"><b><i class="fa fa-pencil"></i>&nbsp;' .trans('message.botones.go').'</b></a>';
                    }
                    return $edit;
                })
                ->addColumn('view', function ($data) {
                    return '<a style="background-color: #5333ed;" href="'.route('seguimiento.view', $data->id).'" id="view_'.$data->id.'" class="btn btn-xs btn-primary"><b><i class="fa fa-eye"></i>&nbsp;' .trans('message.botones.view').'</b></a>';
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
                "cedula" =>  isset($input['checkcedula'])? $input['checkcedula']:NULL ,
                "motivo" =>  isset($input['checkmotivo'])? $input['checkmotivo']:NULL ,
                "video" =>  isset($input['checkvideo'])? $input['checkvideo']:NULL ,
                "foto" =>  isset($input['checkfoto']) ? $input['checkfoto']:NULL ,
                "grabacion" =>  isset($input['checkgrabacion'])? $input['checkgrabacion']:NULL ,
                "testigo" =>  isset($input['checktestigo'])? $input['checktestigo']:NULL ,
                "residencia" =>  isset($input['checkresidencia'])? $input['checkresidencia']:NULL 
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
                "cedula" =>  isset($input['checkcedula'])? $input['checkcedula']:NULL ,
                "motivo" =>  isset($input['checkmotivo'])? $input['checkmotivo']:NULL ,
                "video" =>  isset($input['checkvideo'])? $input['checkvideo']:NULL ,
                "foto" =>  isset($input['checkfoto']) ? $input['checkfoto']:NULL ,
                "grabacion" =>  isset($input['checkgrabacion'])? $input['checkgrabacion']:NULL ,
                "testigo" =>  isset($input['checktestigo'])? $input['checktestigo']:NULL ,
                "residencia" =>  isset($input['checkresidencia'])? $input['checkresidencia']:NULL 
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
                "cedula" =>  isset($input['checkcedula'])? $input['checkcedula']:NULL ,
                "motivo" =>  isset($input['checkmotivo'])? $input['checkmotivo']:NULL ,
                "video" =>  isset($input['checkvideo'])? $input['checkvideo']:NULL ,
                "foto" =>  isset($input['checkfoto']) ? $input['checkfoto']:NULL ,
                "grabacion" =>  isset($input['checkgrabacion'])? $input['checkgrabacion']:NULL ,
                "testigo" =>  isset($input['checktestigo'])? $input['checktestigo']:NULL ,
                "residencia" =>  isset($input['checkresidencia'])? $input['checkresidencia']:NULL 
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
                "motivo" => isset($input['checkmotivo2']) ?$input['checkmotivo2']: NULL
            ]
        ];

         $input['sugerencia'] = json_encode($sugerencia);
         $input['recaudos'] = json_encode($recaudos);
     }
     if ($input['tipo_solicitud_id']== 5){
        $asesoria = [
            [
                "observacion" =>  isset($input['observacion2']) ?$input['observacion2']: NULL
            ]
        ];  
        $recaudos = [
            [
                "motivo" => isset($input['checkmotivo2']) ?$input['checkmotivo2']: NULL
            ]
        ];

         $input['asesoria'] = json_encode($asesoria);
         $input['recaudos'] = json_encode($recaudos);
     }
     if ($input['tipo_solicitud_id']== 6){
      $beneficiario = [
            [
                "cedula" =>  isset($input['cedulabeneficiario'])?$input['cedulabeneficiario']: NULL,
                "nombre" =>  isset($input['nombrebeneficiario'])?$input['nombrebeneficiario']: NULL,
                "direccion" =>  isset($input['direccionbeneficiario'])?$input['direccionbeneficiario']: NULL
            ]
        ];
        $recaudos = [
            [
                "cedula" =>  isset($input['checkcedula2'])? $input['checkcedula2']:NULL ,
                "motivo" =>  isset($input['checkmotivo3'])? $input['checkmotivo3']:NULL ,
                "recipe" =>  isset($input['recipe'])? $input['recipe']:NULL,
                "informe" =>  isset($input['checkinforme'])? $input['checkinforme']:NULL ,
                "beneficiario" =>  isset($input['checkcedulabeneficiario']) ? $input['checkcedulabeneficiario']:NULL,
                "presupuesto" =>  isset($input['checkpresupuesto']) ? $input['checkpresupuesto']:NULL,
                "evifotobeneficiario" =>  isset($input['evifotobeneficiario']) ? $input['evifotobeneficiario']:NULL,
                "permisoinhumacion" =>  isset($input['permisoinhumacion']) ? $input['permisoinhumacion']:NULL,
                "certificadodefuncion" =>  isset($input['certificadodefuncion']) ? $input['certificadodefuncion']:NULL,
                "ordenexamen" =>  isset($input['ordenexamen']) ? $input['ordenexamen']:NULL,
            ]
        ];

         $input['beneficiario'] = json_encode($beneficiario);
         $input['recaudos'] = json_encode($recaudos);
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
            'email' => $input['email'],
            'direccion' => $input['direccion'],
            'fecha'  => \Carbon\Carbon::now(),
            'telefono' => $input['telefono'],
            'telefono2' => $input['telefono2'],
            'organismo' => NULL,
            'asignacion'  => $input['asignacion'],
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

        $solicitud_edit = Solicitud::find($id);
        $valores = $solicitud_edit->all();

        $denuncia = NULL;
        $quejas = NULL;
        $reclamo = NULL;
        $asesoria = NULL;
        $sugerecia = NULL;
        $beneficiario  = NULL;
        if (!(is_null( $solicitud_edit->denuncia))){
            $denuncia= $solicitud_edit->denuncia;
            $denuncia = json_decode($denuncia, true);
         
          
        }

        if (!(is_null( $solicitud_edit->quejas))){
            $quejas= $solicitud_edit->quejas;
            $quejas = json_decode($quejas, true);
           
        }
        if (!(is_null( $solicitud_edit->reclamo))){
            $reclamo= $solicitud_edit->reclamo;
            $reclamo = json_decode($reclamo, true);
            
        }
        if (!(is_null( $solicitud_edit->sugerecia))){
            $sugerecia= $solicitud_edit->sugerecia;
            $sugerecia = json_decode($sugerecia, true);
            
        }
        if (!(is_null( $solicitud_edit->asesoria))){
            $asesoria= $solicitud_edit->asesoria;
            $asesoria = json_decode($asesoria, true);
            
        }
        if (!(is_null( $solicitud_edit->beneficiario))){
            $beneficiario= $solicitud_edit->beneficiario;
            $beneficiario = json_decode($beneficiario, true);
            
        }
        $denunciado= $solicitud_edit->denunciado;
        $denunciado = json_decode($denunciado, true);
       
        $recaudos= $solicitud_edit->recaudos;
        $recaudos = json_decode($recaudos, true);

        
        $titulo_modulo = trans('message.users_action.edit_user');
        $count_notification = (new User)->count_noficaciones_user();
        $array_color = (new Colores)->getColores();
        $estado = (new Estados)->datos_estados();
        $municipio = (new Municipio)->datos_municipio();
        $parroquia = (new Parroquia)->datos_parroquia();
        $array_color = (new Colores)->getColores();
        $tipo_solicitud =(new Tipo_Solicitud)->datos_tipo_solicitud();   
        $direcciones =(new Direccion)->datos_direccion();   
        $enter =(new Enter)->datos_enter(); 
        $comunidad = [];
        $asignacion =  array('DIRECCION'=>'DIRECCION','ENTER'=>'ENTER'); 
        $sexo =  array('MASCULINO'=>'MASCULINO','FEMENINO'=>'FEMENINO'); 
        $edocivil =  array('SOLTERO'=>'SOLTERO','CASADO'=>'CASADO','VIUDO'=>'VIUDO','DIVORCIADO'=>'DIVORCIADO');
        $nivelestudio =  array('PRIMARIA'=>'PRIMARIA','SECUNDARIA'=>'SECUNDARIA','BACHILLERATO'=>'BACHILLERATO','UNIVERSITARIO'=>'UNIVERSITARIO','ESPECIALIZACION'=>'ESPECIALIZACION');
        $profesion =  array('TECNICO MEDIO'=>'TECNICO MEDIO','TECNICO SUPERIOR'=>'TECNICO SUPERIOR','INGENIERO'=>'INGENIERO','ABOGADO'=>'ABOGADO','MEDICO CIRUJANO'=>'MEDICO CIRUJANO','HISTORIADOR'=>'HISTORIADOR','PALEONTOLOGO'=>'PALEONTOLOGO','GEOGRAFO'=>'GEOGRAFO','BIOLOGO'=>'BIOLOGO','PSICOLOGO'=>'PSICOLOGO','MATEMATICO'=>'MATEMATICO','ARQUITECTO'=>'ARQUITECTO','COMPUTISTA'=>'COMPUTISTA','PROFESOR'=>'PROFESOR','PERIODISTA'=>'PERIODISTA','BOTANICO'=>'BOTANICO','FISICO'=>'FISICO','SOCIOLOGO'=>'SOCIOLOGO','FARMACOLOGO'=>'FARMACOLOGO','QUIMICO'=>'QUIMICO','POLITOLOGO'=>'POLITOLOGO','ENFERMERO'=>'ENFERMERO','ELECTRICISTA'=>'ELECTRICISTA','BIBLIOTECOLOGO'=>'BIBLIOTECOLOGO','PARAMEDICO'=>'PARAMEDICO','TECNICO DE SONIDO'=>'TECNICO DE SONIDO','ARCHIVOLOGO'=>'ARCHIVOLOGO','MUSICO'=>'MUSICO','FILOSOFO'=>'FILOSOFO','SECRETARIA'=>'SECRETARIA','TRADUCTOR'=>'TRADUCTOR','ANTROPOLOGO'=>'ANTROPOLOGO','TECNICO TURISMO'=>'TECNICO TURISMO','ECONOMISTA'=>'ECONOMISTA','ADMINISTRADOR'=>'ADMINISTRADOR','CARPITERO'=>'CARPITERO','RADIOLOGO'=>'RADIOLOGO','COMERCIANTE'=>'COMERCIANTE','CERRAJERO'=>'CERRAJERO','COCINERO'=>'COCINERO','ALBAÑIL'=>'ALBAÑIL','PLOMERO'=>'PLOMERO','TORNERO'=>'TORNERO','EDITOR'=>'EDITOR','ESCULTOR'=>'ESCULTOR','ESCRITOR'=>'ESCRITOR','BARBERO'=>'BARBERO');
     
         $comuna =  (new Comuna)->datos_comuna( $solicitud_edit->parroquia_id);
        
         $comunidad = (new Comunidad)->datos_comunidad( $solicitud_edit->comuna_id);
         $coordinacion = (new Coordinacion)->datos_coordinacion( $solicitud_edit->direccion_id);
        

        return view('Solicitud.show',compact('count_notification','titulo_modulo','solicitud_edit','estado','municipio','parroquia','asignacion','comuna','comunidad','tipo_solicitud','direcciones','enter','sexo','edocivil','nivelestudio','coordinacion','denuncia','beneficiario','quejas','sugerecia','asesoria','reclamo','profesion','recaudos','denunciado','array_color'));
      
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    
    public function edit($id){

      
      //  $seguimiento_edit = Seguimiento::find('solicitud_id',$id);
        $seguimiento_edit = DB::table("seguimiento")->where("solicitud_id",$id)->get();
        foreach( $seguimiento_edit as  $seguimiento_edit_2);
        $solicitud_edit = Solicitud::find($id);
       // $input2 =$seguimiento_edit->all();
     //   var_dump(isset($seguimiento_edit_2));
    //    var_dump(isset($seguimiento_edit_2->solicitud_id));
      //  var_dump(isset($seguimiento_edit['solicitud_id']));
      //  exit();
        if (isset($seguimiento_edit_2->solicitud_id)) {
            $entro = true;

        }else{
            $seguimiento = new Seguimiento([
                'solicitud_id' =>$id,
                'seguimiento' => NULL]);
            $seguimiento->save();
         
             $solicitud_Update = Solicitud::find( $id);
             
            $solicitud_Update['status_id'] = 2;
            $solicitud_Update->save();
       
        }

        $valores = $solicitud_edit->all();

        $denuncia = NULL;
        $quejas = NULL;
        $reclamo = NULL;
        $asesoria = NULL;
        $sugerecia = NULL;
        $beneficiario  = NULL;
        if (!(is_null( $solicitud_edit->denuncia))){
            $denuncia= $solicitud_edit->denuncia;
            $denuncia = json_decode($denuncia, true);
       
          
        }

        if (!(is_null( $solicitud_edit->quejas))){
            $quejas= $solicitud_edit->quejas;
            $quejas = json_decode($quejas, true);
           
        }
        if (!(is_null( $solicitud_edit->reclamo))){
            $reclamo= $solicitud_edit->reclamo;
            $reclamo = json_decode($reclamo, true);
            
        }
        if (!(is_null( $solicitud_edit->sugerecia))){
            $sugerecia= $solicitud_edit->sugerecia;
            $sugerecia = json_decode($sugerecia, true);
            
        }
        if (!(is_null( $solicitud_edit->asesoria))){
            $asesoria= $solicitud_edit->asesoria;
            $asesoria = json_decode($asesoria, true);
            
        }
        if (!(is_null( $solicitud_edit->beneficiario))){
            $beneficiario= $solicitud_edit->beneficiario;
            $beneficiario = json_decode($beneficiario, true);
            
        }
        $denunciado= $solicitud_edit->denunciado;
        $denunciado = json_decode($denunciado, true);
       
        $recaudos= $solicitud_edit->recaudos;
        $recaudos = json_decode($recaudos, true);

        
        $titulo_modulo = trans('message.users_action.edit_user');
        $count_notification = (new User)->count_noficaciones_user();
        $array_color = (new Colores)->getColores();
        $estado = (new Estados)->datos_estados();
        $municipio = (new Municipio)->datos_municipio();
        $parroquia = (new Parroquia)->datos_parroquia();
        $array_color = (new Colores)->getColores();
        $tipo_solicitud =(new Tipo_Solicitud)->datos_tipo_solicitud();   
        $direcciones =(new Direccion)->datos_direccion();   
        $enter =(new Enter)->datos_enter(); 
        $comunidad = [];
        $asignacion =  array('DIRECCION'=>'DIRECCION','ENTER'=>'ENTER'); 
        $sexo =  array('MASCULINO'=>'MASCULINO','FEMENINO'=>'FEMENINO'); 
        $edocivil =  array('SOLTERO'=>'SOLTERO','CASADO'=>'CASADO','VIUDO'=>'VIUDO','DIVORCIADO'=>'DIVORCIADO');
        $nivelestudio =  array('PRIMARIA'=>'PRIMARIA','SECUNDARIA'=>'SECUNDARIA','BACHILLERATO'=>'BACHILLERATO','UNIVERSITARIO'=>'UNIVERSITARIO','ESPECIALIZACION'=>'ESPECIALIZACION');
        $profesion =  array('TECNICO MEDIO'=>'TECNICO MEDIO','TECNICO SUPERIOR'=>'TECNICO SUPERIOR','INGENIERO'=>'INGENIERO','ABOGADO'=>'ABOGADO','MEDICO CIRUJANO'=>'MEDICO CIRUJANO','HISTORIADOR'=>'HISTORIADOR','PALEONTOLOGO'=>'PALEONTOLOGO','GEOGRAFO'=>'GEOGRAFO','BIOLOGO'=>'BIOLOGO','PSICOLOGO'=>'PSICOLOGO','MATEMATICO'=>'MATEMATICO','ARQUITECTO'=>'ARQUITECTO','COMPUTISTA'=>'COMPUTISTA','PROFESOR'=>'PROFESOR','PERIODISTA'=>'PERIODISTA','BOTANICO'=>'BOTANICO','FISICO'=>'FISICO','SOCIOLOGO'=>'SOCIOLOGO','FARMACOLOGO'=>'FARMACOLOGO','QUIMICO'=>'QUIMICO','POLITOLOGO'=>'POLITOLOGO','ENFERMERO'=>'ENFERMERO','ELECTRICISTA'=>'ELECTRICISTA','BIBLIOTECOLOGO'=>'BIBLIOTECOLOGO','PARAMEDICO'=>'PARAMEDICO','TECNICO DE SONIDO'=>'TECNICO DE SONIDO','ARCHIVOLOGO'=>'ARCHIVOLOGO','MUSICO'=>'MUSICO','FILOSOFO'=>'FILOSOFO','SECRETARIA'=>'SECRETARIA','TRADUCTOR'=>'TRADUCTOR','ANTROPOLOGO'=>'ANTROPOLOGO','TECNICO TURISMO'=>'TECNICO TURISMO','ECONOMISTA'=>'ECONOMISTA','ADMINISTRADOR'=>'ADMINISTRADOR','CARPITERO'=>'CARPITERO','RADIOLOGO'=>'RADIOLOGO','COMERCIANTE'=>'COMERCIANTE','CERRAJERO'=>'CERRAJERO','COCINERO'=>'COCINERO','ALBAÑIL'=>'ALBAÑIL','PLOMERO'=>'PLOMERO','TORNERO'=>'TORNERO','EDITOR'=>'EDITOR','ESCULTOR'=>'ESCULTOR','ESCRITOR'=>'ESCRITOR','BARBERO'=>'BARBERO');
     
         $comuna =  (new Comuna)->datos_comuna( $solicitud_edit->parroquia_id);
        
         $comunidad = (new Comunidad)->datos_comunidad( $solicitud_edit->comuna_id);
         $coordinacion = (new Coordinacion)->datos_coordinacion( $solicitud_edit->direccion_id);
        

        return view('Seguimiento.seguimiento_edit',compact('count_notification','titulo_modulo','solicitud_edit','estado','municipio','parroquia','asignacion','comuna','comunidad','tipo_solicitud','direcciones','enter','sexo','edocivil','nivelestudio','coordinacion','denuncia','beneficiario','quejas','sugerecia','asesoria','reclamo','profesion','recaudos','denunciado','array_color'));
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
    public function addSeguimiento(Request $request){
        var_dump('test');
        exit();
    }

    public function update(Request $request, $id){
       // $count_notification = (new User)->count_noficaciones_user();
      $input = $request->all();
      $recaudos =NULL;
      $input['quejas'] = NULL;
      $input['reclamos'] = NULL;
      $input['sugerencia'] = NULL;
      $input['asesoria'] = NULL;
      $input['beneficiario'] = NULL;
      $input['denuncia'] = NULL;
      $input['denunciado'] = NULL;
      $input['nombredenunciado'] = NULL;
      $input['recaudos']=$recaudos;
      $input['codigocontrol']="001";
      $input['seguimiento']=NULL;
        
    if($input['seguimiento'] == NULL){

    }
    if($input['seguimiento'] != NULL){
        
    }
     
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
                "cedula" =>  isset($input['checkcedula'])? $input['checkcedula']:NULL ,
                "motivo" =>  isset($input['checkmotivo'])? $input['checkmotivo']:NULL ,
                "video" =>  isset($input['checkvideo'])? $input['checkvideo']:NULL ,
                "foto" =>  isset($input['checkfoto']) ? $input['checkfoto']:NULL ,
                "grabacion" =>  isset($input['checkgrabacion'])? $input['checkgrabacion']:NULL ,
                "testigo" =>  isset($input['checktestigo'])? $input['checktestigo']:NULL ,
                "residencia" =>  isset($input['checkresidencia'])? $input['checkresidencia']:NULL 
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
                "cedula" =>  isset($input['checkcedula'])? $input['checkcedula']:NULL ,
                "motivo" =>  isset($input['checkmotivo'])? $input['checkmotivo']:NULL ,
                "video" =>  isset($input['checkvideo'])? $input['checkvideo']:NULL ,
                "foto" =>  isset($input['checkfoto']) ? $input['checkfoto']:NULL ,
                "grabacion" =>  isset($input['checkgrabacion'])? $input['checkgrabacion']:NULL ,
                "testigo" =>  isset($input['checktestigo'])? $input['checktestigo']:NULL ,
                "residencia" =>  isset($input['checkresidencia'])? $input['checkresidencia']:NULL 
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
                "cedula" =>  isset($input['checkcedula'])? $input['checkcedula']:NULL ,
                "motivo" =>  isset($input['checkmotivo'])? $input['checkmotivo']:NULL ,
                "video" =>  isset($input['checkvideo'])? $input['checkvideo']:NULL ,
                "foto" =>  isset($input['checkfoto']) ? $input['checkfoto']:NULL ,
                "grabacion" =>  isset($input['checkgrabacion'])? $input['checkgrabacion']:NULL ,
                "testigo" =>  isset($input['checktestigo'])? $input['checktestigo']:NULL ,
                "residencia" =>  isset($input['checkresidencia'])? $input['checkresidencia']:NULL 
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
                "motivo" => isset($input['checkmotivo2']) ?$input['checkmotivo2']: NULL
            ]
        ];

         $input['sugerencia'] = json_encode($sugerencia);
         $input['recaudos'] = json_encode($recaudos);
     }
     if ($input['tipo_solicitud_id']== 5){
        $asesoria = [
            [
                "observacion" =>  isset($input['observacion2']) ?$input['observacion2']: NULL
            ]
        ];  
        $recaudos = [
            [
                "motivo" => isset($input['checkmotivo2']) ?$input['checkmotivo2']: NULL
            ]
        ];

         $input['asesoria'] = json_encode($asesoria);
         $input['recaudos'] = json_encode($recaudos);
     }
     if ($input['tipo_solicitud_id']== 6){
      $beneficiario = [
            [
                "cedula" =>  isset($input['cedulabeneficiario'])?$input['cedulabeneficiario']: NULL,
                "nombre" =>  isset($input['nombrebeneficiario'])?$input['nombrebeneficiario']: NULL,
                "direccion" =>  isset($input['direccionbeneficiario'])?$input['direccionbeneficiario']: NULL
            ]
        ];
        $recaudos = [
            [
                "cedula" =>  isset($input['checkcedula2'])? $input['checkcedula2']:NULL ,
                "motivo" =>  isset($input['checkmotivo3'])? $input['checkmotivo3']:NULL ,
                "recipe" =>  isset($input['recipe'])? $input['recipe']:NULL,
                "informe" =>  isset($input['checkinforme'])? $input['checkinforme']:NULL ,
                "beneficiario" =>  isset($input['checkcedulabeneficiario']) ? $input['checkcedulabeneficiario']:NULL,
                "presupuesto" =>  isset($input['checkpresupuesto']) ? $input['checkpresupuesto']:NULL,
                "evifotobeneficiario" =>  isset($input['evifotobeneficiario']) ? $input['evifotobeneficiario']:NULL,
                "permisoinhumacion" =>  isset($input['permisoinhumacion']) ? $input['permisoinhumacion']:NULL,
                "certificadodefuncion" =>  isset($input['certificadodefuncion']) ? $input['certificadodefuncion']:NULL,
                "ordenexamen" =>  isset($input['ordenexamen']) ? $input['ordenexamen']:NULL,
            ]
        ];

         $input['beneficiario'] = json_encode($beneficiario);
         $input['recaudos'] = json_encode($recaudos);
     }
    // $input = $request->except('relato');

    unset($input['relato']);
    unset($input['observacion']);
    unset($input['explique']);
    unset($input['explique2']);
    unset($input['ceduladenunciado']);
    unset($input['nombredenunciado']);
    unset($input['testigo']);
    unset($input['checkcedula']);
    unset($input['checkmotivo']);
    unset($input['checkvideo']);
    unset($input['checkfoto']);
    unset($input['checkgrabacion']);
    unset($input['checktestigo']);
    unset($input['checkresidencia']);
    unset($input['observacion2']);
    unset($input['checkmotivo2']);
    unset($input['cedulabeneficiario']);
    unset($input['nombrebeneficiario']);
    unset($input['direccionbeneficiario']);
    unset($input['checkcedula2']);
    unset($input['checkmotivo3']);
    unset($input['checkinforme']);
    unset($input['checkcedulabeneficiario']);
    unset($input['presentada']);
    unset($input['competencia']);
    $solicitud_Update = Solicitud::find( $id);
    $solicitud_Update->update($input);
     
        return redirect('/solicitud');
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
    public function solicitudTipo(Request $request){
        if($request->ajax()){
          $countSolicitud = (new Solicitud)->count_solictud();     
          
          return response()->json($countSolicitud);
        }
      }
      public function solicitudTotalTipo(Request $request){
        if($request->ajax()){
          $countTotalSolicitud = (new Solicitud)->count_total_solictud();     
          
          return response()->json($countTotalSolicitud);
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
