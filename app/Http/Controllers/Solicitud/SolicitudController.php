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
    public function index()
    {
        $count_notification = (new User)->count_noficaciones_user();
        $tipo_alert = "";
        if (session('delete') == true) {
            $tipo_alert = "Delete";
            session(['delete' => false]);
        }
        if (session('update') == true) {
            $tipo_alert = "Update";
            session(['update' => false]);
        }
        $array_color = (new Colores)->getColores();
        return view('Solicitud.solicitud', compact('count_notification', 'tipo_alert', 'array_color'));
    }

    public function getSolicitud(Request $request)
    {
        try {
            if ($request->ajax()) {
                $data = (new Solicitud)->getSolicitudList_DataTable();
                return datatables()->of($data)
                    ->addColumn('edit', function ($data) {
                        $user = Auth::user();
                        if (($user->id != 1)) {
                            $edit = '<a href="' . route('solicitud.edit', $data->id) . '" id="edit_' . $data->id . '" class="btn btn-xs btn-primary" style="background-color: #2962ff;"><b><i class="fa fa-pencil"></i>&nbsp;' . trans('message.botones.edit') . '</b></a>';
                        } else {
                            $edit = '<a href="' . route('solicitud.edit', $data->id) . '" id="edit_' . $data->id . '" class="btn btn-xs btn-primary" style="background-color: #2962ff;"><b><i class="fa fa-pencil"></i>&nbsp;' . trans('message.botones.edit') . '</b></a>';
                        }
                        return $edit;
                    })
                    ->addColumn('view', function ($data) {
                        return '<a style="background-color: #5333ed;" href="' . route('solicitud.view', $data->id) . '" id="view_' . $data->id . '" class="btn btn-xs btn-primary"><b><i class="fa fa-eye"></i>&nbsp;' . trans('message.botones.view') . '</b></a>';
                    })

                    ->rawColumns(['edit', 'view', 'del'])->toJson();
            }
        } catch (Throwable $e) {
            echo "Captured Throwable: " . $e->getMessage(), "\n";
        }
    }

    public function profile()
    {
        $count_notification = (new User)->count_noficaciones_user();
        $user = Auth::user();
        $array_color = (new Colores)->getColores();
        return view('User.profile', compact('count_notification', 'user', 'array_color'));
    }

    public function usersPrint()
    {
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
        $dompdf->stream("Tarsicio_Carrizales_Proyecto_Horus.pdf", array("Attachment" => 1));
        return redirect()->back();
    }

    public function update_avatar(Request $request, $id)
    {
        $count_notification = (new User)->count_noficaciones_user();
        $user = Auth::user();
        $user_Update = User::find($id);
        $avatar_viejo = $user_Update->avatar;
        $this->update_image($request, $avatar_viejo, $user_Update);
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
    public function create()
    {
        $titulo_modulo = trans('message.users_action.new_user');
        $count_notification = (new User)->count_noficaciones_user();
        $roles = (new Rol)->datos_roles();
        $estado = (new Estados)->datos_estados();
        $municipio = (new Municipio)->datos_municipio();
        $parroquia = (new Parroquia)->datos_parroquia();
        $array_color = (new Colores)->getColores();
        $tipo_solicitud = (new Tipo_Solicitud)->datos_tipo_solicitud();
        $direcciones = (new Direccion)->datos_direccion();
        $enter = (new Enter)->datos_enter();
        $comuna = [];
        $coordinacion = [];
        $comunidad = [];
        return view('Solicitud.solicitud_create', compact('count_notification', 'titulo_modulo', 'roles', 'municipio', 'comuna', 'comunidad', 'direcciones', 'parroquia', 'estado', 'coordinacion', 'enter', 'tipo_solicitud', 'array_color'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
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


        $recaudos = NULL;
        $input['quejas'] = NULL;
        $input['reclamos'] = NULL;
        $input['sugerencia'] = NULL;
        $input['asesoria'] = NULL;
        $input['beneficiario'] = NULL;
        $input['denuncia'] = NULL;
        $input['denunciado'] = NULL;
        $input['recaudos'] = $recaudos;
        $input['codigocontrol'] = "001";
        if ($input['tipo_solicitud_id'] == 1) {
            $denuncia = [
                [
                    "relato" => $input['relato'],
                    "observacion" => $input['observacion'],
                    "expliquepresentada" => $input['explique'],
                    "explique competencia" => $input['explique2']
                ]
            ];
            $denunciado = [
                [
                    "cedula" => $input['ceduladenunciado'],
                    "nombre" => $input['nombredenunciado'],
                    "testigo" => $input['testigo']
                ]
            ];
            $recaudos = [
                [
                    "cedula" => isset($input['checkcedula']) ? $input['checkcedula'] : NULL,
                    "motivo" => isset($input['checkmotivo']) ? $input['checkmotivo'] : NULL,
                    "video" => isset($input['checkvideo']) ? $input['checkvideo'] : NULL,
                    "foto" => isset($input['checkfoto']) ? $input['checkfoto'] : NULL,
                    "grabacion" => isset($input['checkgrabacion']) ? $input['checkgrabacion'] : NULL,
                    "testigo" => isset($input['checktestigo']) ? $input['checktestigo'] : NULL,
                    "residencia" => isset($input['checkresidencia']) ? $input['checkresidencia'] : NULL
                ]
            ];

            $input['denuncia'] = json_encode($denuncia);
            $input['denunciado'] = json_encode($denunciado);
            $input['recaudos'] = json_encode($recaudos);

        }
        if ($input['tipo_solicitud_id'] == 2) {
            $queja = [
                [
                    "relato" => $input['relato'],
                    "observacion" => $input['observacion'],
                    "expliquepresentada" => $input['explique'],
                    "explique competencia" => $input['explique2']
                ]
            ];
            $denunciado = [
                [
                    "cedula" => $input['ceduladenunciado'],
                    "nombre" => $input['nombredenunciado'],
                    "testigo" => $input['testigo']
                ]
            ];
            $recaudos = [
                [
                    "cedula" => isset($input['checkcedula']) ? $input['checkcedula'] : NULL,
                    "motivo" => isset($input['checkmotivo']) ? $input['checkmotivo'] : NULL,
                    "video" => isset($input['checkvideo']) ? $input['checkvideo'] : NULL,
                    "foto" => isset($input['checkfoto']) ? $input['checkfoto'] : NULL,
                    "grabacion" => isset($input['checkgrabacion']) ? $input['checkgrabacion'] : NULL,
                    "testigo" => isset($input['checktestigo']) ? $input['checktestigo'] : NULL,
                    "residencia" => isset($input['checkresidencia']) ? $input['checkresidencia'] : NULL
                ]
            ];

            $input['quejas'] = json_encode($queja);
            $input['denunciado'] = json_encode($denunciado);
            $input['recaudos'] = json_encode($recaudos);
        }
        if ($input['tipo_solicitud_id'] == 3) {
            $reclamo = [
                [
                    "relato" => $input['relato'],
                    "observacion" => $input['observacion'],
                    "expliquepresentada" => $input['explique'],
                    "explique competencia" => $input['explique2']
                ]
            ];
            $denunciado = [
                [
                    "cedula" => $input['ceduladenunciado'],
                    "nombre" => $input['nombredenunciado'],
                    "testigo" => $input['testigo']
                ]
            ];
            $recaudos = [
                [
                    "cedula" => isset($input['checkcedula']) ? $input['checkcedula'] : NULL,
                    "motivo" => isset($input['checkmotivo']) ? $input['checkmotivo'] : NULL,
                    "video" => isset($input['checkvideo']) ? $input['checkvideo'] : NULL,
                    "foto" => isset($input['checkfoto']) ? $input['checkfoto'] : NULL,
                    "grabacion" => isset($input['checkgrabacion']) ? $input['checkgrabacion'] : NULL,
                    "testigo" => isset($input['checktestigo']) ? $input['checktestigo'] : NULL,
                    "residencia" => isset($input['checkresidencia']) ? $input['checkresidencia'] : NULL
                ]
            ];

            $input['reclamos'] = json_encode($reclamo);
            $input['denunciado'] = json_encode($denunciado);
            $input['recaudos'] = json_encode($recaudos);
        }
        if ($input['tipo_solicitud_id'] == 4) {
            $sugerencia = [
                [
                    "observacion" => $input['observacion2'],
                    ]
                ];
                $recaudos = [
                    [
                        "motivo" => isset($input['checkmotivo2']) ? $input['checkmotivo2'] : NULL
                        ]
                    ];
            $input['direcciones_id'] =  14;
            $input['sugerencia'] = json_encode($sugerencia);
            $input['recaudos'] = json_encode($recaudos);
        }
        if ($input['tipo_solicitud_id'] == 5) {
            $asesoria = [
                [
                    "observacion" => isset($input['observacion2']) ? $input['observacion2'] : NULL,
                ]
            ];
            $recaudos = [
                [
                    "motivo" => isset($input['checkmotivo2']) ? $input['checkmotivo2'] : NULL
                ]
            ];
            $input['direcciones_id'] =  14;
            $input['asesoria'] = json_encode($asesoria);
            $input['recaudos'] = json_encode($recaudos);
        }
        if ($input['tipo_solicitud_id'] == 6) {
            $beneficiario = [
                [
                    "cedula" => isset($input['cedulabeneficiario']) ? $input['cedulabeneficiario'] : NULL,
                    "nombre" => isset($input['nombrebeneficiario']) ? $input['nombrebeneficiario'] : NULL,
                    "direccion" => isset($input['direccionbeneficiario']) ? $input['direccionbeneficiario'] : NULL
                ]
            ];
            $recaudos = [
                [
                    "cedula" => isset($input['checkcedula2']) ? $input['checkcedula2'] : NULL,
                    "motivo" => isset($input['checkmotivo3']) ? $input['checkmotivo3'] : NULL,
                    "informe" => isset($input['checkinforme']) ? $input['checkinforme'] : NULL,
                    "beneficiario" => isset($input['checkcedulabeneficiario']) ? $input['checkcedulabeneficiario'] : NULL
                ]
            ];
            $input['beneficiario'] = json_encode($beneficiario);
            $input['recaudos'] = json_encode($recaudos);
        }
        $solicitud = new Solicitud([
            'users_id' => $input['users_id'],
            'direccion_id' => $input['direcciones_id'],
            'coordinacion_id' => $input['coordinacion_id'],
            'tipo_solicitud_id' => $input['tipo_solicitud_id'],
            'enter_descentralizados_id' => $input['enter_id'],
            'estado_id' => $input['estado_id'],
            'municipio_id' => $input['municipio_id'],
            'parroquia_id' => $input['parroquia_id'],
            'comuna_id' => $input['comuna_id'],
            'comunidad_id' => $input['comunidad_id'],
            'codigo_control' => $input['codigocontrol'],
            'status_id' => 1,
            'nombre' => $input['nombre'],
            'cedula' => $input['cedula'],
            'sexo' => $input['sexo'],
            'email' => $input['email'],
            'direccion' => $input['direccion'],
            'fecha' => \Carbon\Carbon::now(),
            'telefono' => $input['telefono'],
            'telefono2' => $input['telefono2'],
            'organismo' => NULL,
            'asignacion' => $input['asignacion'],
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
        return view('Solicitud.solicitud', compact('count_notification', 'tipo_alert', 'array_color'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function view($id)
    {

        $solicitud_edit = Solicitud::find($id);
        $valores = $solicitud_edit->all();

        $denuncia = NULL;
        $quejas = NULL;
        $reclamo = NULL;
        $asesoria = NULL;
        $sugerecia = NULL;
        $beneficiario = NULL;
        if (!(is_null($solicitud_edit->denuncia))) {
            $denuncia = $solicitud_edit->denuncia;
            $denuncia = json_decode($denuncia, true);


        }

        if (!(is_null($solicitud_edit->quejas))) {
            $quejas = $solicitud_edit->quejas;
            $quejas = json_decode($quejas, true);

        }
        if (!(is_null($solicitud_edit->reclamo))) {
            $reclamo = $solicitud_edit->reclamo;
            $reclamo = json_decode($reclamo, true);

        }
        if (!(is_null($solicitud_edit->sugerecia))) {
            $sugerecia = $solicitud_edit->sugerecia;
            $sugerecia = json_decode($sugerecia, true);

        }
        if (!(is_null($solicitud_edit->asesoria))) {
            $asesoria = $solicitud_edit->asesoria;
            $asesoria = json_decode($asesoria, true);

        }
        if (!(is_null($solicitud_edit->beneficiario))) {
            $beneficiario = $solicitud_edit->beneficiario;
            $beneficiario = json_decode($beneficiario, true);

        }
        $denunciado = $solicitud_edit->denunciado;
        $denunciado = json_decode($denunciado, true);

        $recaudos = $solicitud_edit->recaudos;
        $recaudos = json_decode($recaudos, true);


        $titulo_modulo = trans('message.users_action.edit_user');
        $count_notification = (new User)->count_noficaciones_user();
        $array_color = (new Colores)->getColores();
        $estado = (new Estados)->datos_estados();
        $municipio = (new Municipio)->datos_municipio();
        $parroquia = (new Parroquia)->datos_parroquia();
        $array_color = (new Colores)->getColores();
        $tipo_solicitud = (new Tipo_Solicitud)->datos_tipo_solicitud();
        $direcciones = (new Direccion)->datos_direccion();
        $enter = (new Enter)->datos_enter();
        $comunidad = [];
        $asignacion = array('DIRECCION' => 'DIRECCION', 'ENTER' => 'ENTER');
        $sexo = array('MASCULINO' => 'MASCULINO', 'FEMENINO' => 'FEMENINO');
        $edocivil = array('SOLTERO' => 'SOLTERO', 'CASADO' => 'CASADO', 'VIUDO' => 'VIUDO', 'DIVORCIADO' => 'DIVORCIADO');
        $nivelestudio = array('PRIMARIA' => 'PRIMARIA', 'SECUNDARIA' => 'SECUNDARIA', 'BACHILLERATO' => 'BACHILLERATO', 'UNIVERSITARIO' => 'UNIVERSITARIO', 'ESPECIALIZACION' => 'ESPECIALIZACION');
        $profesion = array('TECNICO MEDIO' => 'TECNICO MEDIO', 'TECNICO SUPERIOR' => 'TECNICO SUPERIOR', 'INGENIERO' => 'INGENIERO', 'ABOGADO' => 'ABOGADO', 'MEDICO CIRUJANO' => 'MEDICO CIRUJANO', 'HISTORIADOR' => 'HISTORIADOR', 'PALEONTOLOGO' => 'PALEONTOLOGO', 'GEOGRAFO' => 'GEOGRAFO', 'BIOLOGO' => 'BIOLOGO', 'PSICOLOGO' => 'PSICOLOGO', 'MATEMATICO' => 'MATEMATICO', 'ARQUITECTO' => 'ARQUITECTO', 'COMPUTISTA' => 'COMPUTISTA', 'PROFESOR' => 'PROFESOR', 'PERIODISTA' => 'PERIODISTA', 'BOTANICO' => 'BOTANICO', 'FISICO' => 'FISICO', 'SOCIOLOGO' => 'SOCIOLOGO', 'FARMACOLOGO' => 'FARMACOLOGO', 'QUIMICO' => 'QUIMICO', 'POLITOLOGO' => 'POLITOLOGO', 'ENFERMERO' => 'ENFERMERO', 'ELECTRICISTA' => 'ELECTRICISTA', 'BIBLIOTECOLOGO' => 'BIBLIOTECOLOGO', 'PARAMEDICO' => 'PARAMEDICO', 'TECNICO DE SONIDO' => 'TECNICO DE SONIDO', 'ARCHIVOLOGO' => 'ARCHIVOLOGO', 'MUSICO' => 'MUSICO', 'FILOSOFO' => 'FILOSOFO', 'SECRETARIA' => 'SECRETARIA', 'TRADUCTOR' => 'TRADUCTOR', 'ANTROPOLOGO' => 'ANTROPOLOGO', 'TECNICO TURISMO' => 'TECNICO TURISMO', 'ECONOMISTA' => 'ECONOMISTA', 'ADMINISTRADOR' => 'ADMINISTRADOR', 'CARPITERO' => 'CARPITERO', 'RADIOLOGO' => 'RADIOLOGO', 'COMERCIANTE' => 'COMERCIANTE', 'CERRAJERO' => 'CERRAJERO', 'COCINERO' => 'COCINERO', 'ALBAÑIL' => 'ALBAÑIL', 'PLOMERO' => 'PLOMERO', 'TORNERO' => 'TORNERO', 'EDITOR' => 'EDITOR', 'ESCULTOR' => 'ESCULTOR', 'ESCRITOR' => 'ESCRITOR', 'BARBERO' => 'BARBERO');

        $comuna = (new Comuna)->datos_comuna($solicitud_edit->parroquia_id);

        $comunidad = (new Comunidad)->datos_comunidad($solicitud_edit->comuna_id);
        $coordinacion = (new Coordinacion)->datos_coordinacion($solicitud_edit->direccion_id);


        return view('Solicitud.show', compact('count_notification', 'titulo_modulo', 'solicitud_edit', 'estado', 'municipio', 'parroquia', 'asignacion', 'comuna', 'comunidad', 'tipo_solicitud', 'direcciones', 'enter', 'sexo', 'edocivil', 'nivelestudio', 'coordinacion', 'denuncia', 'beneficiario', 'quejas', 'sugerecia', 'asesoria', 'reclamo', 'profesion', 'recaudos', 'denunciado', 'array_color'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $solicitud_edit = Solicitud::find($id);
        $valores = $solicitud_edit->all();

        $denuncia = NULL;
        $quejas = NULL;
        $reclamo = NULL;
        $asesoria = NULL;
        $sugerecia = NULL;
        $beneficiario = NULL;
        if (!(is_null($solicitud_edit->denuncia))) {
            $denuncia = $solicitud_edit->denuncia;
            $denuncia = json_decode($denuncia, true);


        }

        if (!(is_null($solicitud_edit->quejas))) {
            $quejas = $solicitud_edit->quejas;
            $quejas = json_decode($quejas, true);

        }
        if (!(is_null($solicitud_edit->reclamo))) {
            $reclamo = $solicitud_edit->reclamo;
            $reclamo = json_decode($reclamo, true);

        }
        if (!(is_null($solicitud_edit->sugerecia))) {
            $sugerecia = $solicitud_edit->sugerecia;
            $sugerecia = json_decode($sugerecia, true);

        }
        if (!(is_null($solicitud_edit->asesoria))) {
            $asesoria = $solicitud_edit->asesoria;
            $asesoria = json_decode($asesoria, true);

        }
        if (!(is_null($solicitud_edit->beneficiario))) {
            $beneficiario = $solicitud_edit->beneficiario;
            $beneficiario = json_decode($beneficiario, true);

        }
        $denunciado = $solicitud_edit->denunciado;
        $denunciado = json_decode($denunciado, true);

        $recaudos = $solicitud_edit->recaudos;
        $recaudos = json_decode($recaudos, true);


        $titulo_modulo = trans('message.users_action.edit_user');
        $count_notification = (new User)->count_noficaciones_user();
        $array_color = (new Colores)->getColores();
        $estado = (new Estados)->datos_estados();
        $municipio = (new Municipio)->datos_municipio();
        $parroquia = (new Parroquia)->datos_parroquia();
        $array_color = (new Colores)->getColores();
        $tipo_solicitud = (new Tipo_Solicitud)->datos_tipo_solicitud();
        $direcciones = (new Direccion)->datos_direccion();
        $enter = (new Enter)->datos_enter();
        $comunidad = [];
        $asignacion = array('DIRECCION' => 'DIRECCION', 'ENTER' => 'ENTER');
        $sexo = array('MASCULINO' => 'MASCULINO', 'FEMENINO' => 'FEMENINO');
        $edocivil = array('SOLTERO' => 'SOLTERO', 'CASADO' => 'CASADO', 'VIUDO' => 'VIUDO', 'DIVORCIADO' => 'DIVORCIADO');
        $nivelestudio = array('PRIMARIA' => 'PRIMARIA', 'SECUNDARIA' => 'SECUNDARIA', 'BACHILLERATO' => 'BACHILLERATO', 'UNIVERSITARIO' => 'UNIVERSITARIO', 'ESPECIALIZACION' => 'ESPECIALIZACION');
        $profesion = array('TECNICO MEDIO' => 'TECNICO MEDIO', 'TECNICO SUPERIOR' => 'TECNICO SUPERIOR', 'INGENIERO' => 'INGENIERO', 'ABOGADO' => 'ABOGADO', 'MEDICO CIRUJANO' => 'MEDICO CIRUJANO', 'HISTORIADOR' => 'HISTORIADOR', 'PALEONTOLOGO' => 'PALEONTOLOGO', 'GEOGRAFO' => 'GEOGRAFO', 'BIOLOGO' => 'BIOLOGO', 'PSICOLOGO' => 'PSICOLOGO', 'MATEMATICO' => 'MATEMATICO', 'ARQUITECTO' => 'ARQUITECTO', 'COMPUTISTA' => 'COMPUTISTA', 'PROFESOR' => 'PROFESOR', 'PERIODISTA' => 'PERIODISTA', 'BOTANICO' => 'BOTANICO', 'FISICO' => 'FISICO', 'SOCIOLOGO' => 'SOCIOLOGO', 'FARMACOLOGO' => 'FARMACOLOGO', 'QUIMICO' => 'QUIMICO', 'POLITOLOGO' => 'POLITOLOGO', 'ENFERMERO' => 'ENFERMERO', 'ELECTRICISTA' => 'ELECTRICISTA', 'BIBLIOTECOLOGO' => 'BIBLIOTECOLOGO', 'PARAMEDICO' => 'PARAMEDICO', 'TECNICO DE SONIDO' => 'TECNICO DE SONIDO', 'ARCHIVOLOGO' => 'ARCHIVOLOGO', 'MUSICO' => 'MUSICO', 'FILOSOFO' => 'FILOSOFO', 'SECRETARIA' => 'SECRETARIA', 'TRADUCTOR' => 'TRADUCTOR', 'ANTROPOLOGO' => 'ANTROPOLOGO', 'TECNICO TURISMO' => 'TECNICO TURISMO', 'ECONOMISTA' => 'ECONOMISTA', 'ADMINISTRADOR' => 'ADMINISTRADOR', 'CARPITERO' => 'CARPITERO', 'RADIOLOGO' => 'RADIOLOGO', 'COMERCIANTE' => 'COMERCIANTE', 'CERRAJERO' => 'CERRAJERO', 'COCINERO' => 'COCINERO', 'ALBAÑIL' => 'ALBAÑIL', 'PLOMERO' => 'PLOMERO', 'TORNERO' => 'TORNERO', 'EDITOR' => 'EDITOR', 'ESCULTOR' => 'ESCULTOR', 'ESCRITOR' => 'ESCRITOR', 'BARBERO' => 'BARBERO');

        $comuna = (new Comuna)->datos_comuna($solicitud_edit->parroquia_id);

        $comunidad = (new Comunidad)->datos_comunidad($solicitud_edit->comuna_id);
        $coordinacion = (new Coordinacion)->datos_coordinacion($solicitud_edit->direccion_id);


        return view('Solicitud.solicitud_edit', compact('count_notification', 'titulo_modulo', 'solicitud_edit', 'estado', 'municipio', 'parroquia', 'asignacion', 'comuna', 'comunidad', 'tipo_solicitud', 'direcciones', 'enter', 'sexo', 'edocivil', 'nivelestudio', 'coordinacion', 'denuncia', 'beneficiario', 'quejas', 'sugerecia', 'asesoria', 'reclamo', 'profesion', 'recaudos', 'denunciado', 'array_color'));
    }
    public function getComunas(Request $request)
    {

        $comuna = (new Comuna)->datos_comuna($request['parroquia']);

        return $comuna;

    }

    public function getComunidad(Request $request)
    {

        $comunidad = (new Comunidad)->datos_comunidad($request['comuna']);

        return $comunidad;

    }
    public function getCoodinacion(Request $request)
    {

        $coordinacion = (new Coordinacion)->datos_coordinacion($request['direccion']);

        return $coordinacion;

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        // $count_notification = (new User)->count_noficaciones_user();
        $input = $request->all();
        $recaudos = NULL;
        $input['quejas'] = NULL;
        $input['reclamos'] = NULL;
        $input['sugerencia'] = NULL;
        $input['asesoria'] = NULL;
        $input['beneficiario'] = NULL;
        $input['denuncia'] = NULL;
        $input['denunciado'] = NULL;
        $input['recaudos'] = $recaudos;
        $input['codigocontrol'] = "001";

        if ($input['tipo_solicitud_id'] == 1) {
            $denuncia = [
                [
                    "relato" => $input['relato'],
                    "observacion" => $input['observacion'],
                    "expliquepresentada" => $input['explique'],
                    "explique competencia" => $input['explique2']
                ]
            ];
            $denunciado = [
                [
                    "cedula" => $input['ceduladenunciado'],
                    "nombre" => $input['nombredenunciado'],
                    "testigo" => $input['testigo']
                ]
            ];
            $recaudos = [
                [
                    "cedula" => isset($input['checkcedula']) ? $input['checkcedula'] : NULL,
                    "motivo" => isset($input['checkmotivo']) ? $input['checkmotivo'] : NULL,
                    "video" => isset($input['checkvideo']) ? $input['checkvideo'] : NULL,
                    "foto" => isset($input['checkfoto']) ? $input['checkfoto'] : NULL,
                    "grabacion" => isset($input['checkgrabacion']) ? $input['checkgrabacion'] : NULL,
                    "testigo" => isset($input['checktestigo']) ? $input['checktestigo'] : NULL,
                    "residencia" => isset($input['checkresidencia']) ? $input['checkresidencia'] : NULL
                ]
            ];

            $input['denuncia'] = json_encode($denuncia);
            $input['denunciado'] = json_encode($denunciado);
            $input['recaudos'] = json_encode($recaudos);

        }
        if ($input['tipo_solicitud_id'] == 2) {
            $queja = [
                [
                    "relato" => $input['relato'],
                    "observacion" => $input['observacion'],
                    "expliquepresentada" => $input['explique'],
                    "explique competencia" => $input['explique2']
                ]
            ];
            $denunciado = [
                [
                    "cedula" => $input['ceduladenunciado'],
                    "nombre" => $input['nombredenunciado'],
                    "testigo" => $input['testigo']
                ]
            ];
            $recaudos = [
                [
                    "cedula" => isset($input['checkcedula']) ? $input['checkcedula'] : NULL,
                    "motivo" => isset($input['checkmotivo']) ? $input['checkmotivo'] : NULL,
                    "video" => isset($input['checkvideo']) ? $input['checkvideo'] : NULL,
                    "foto" => isset($input['checkfoto']) ? $input['checkfoto'] : NULL,
                    "grabacion" => isset($input['checkgrabacion']) ? $input['checkgrabacion'] : NULL,
                    "testigo" => isset($input['checktestigo']) ? $input['checktestigo'] : NULL,
                    "residencia" => isset($input['checkresidencia']) ? $input['checkresidencia'] : NULL
                ]
            ];

            $input['quejas'] = json_encode($queja);
            $input['denunciado'] = json_encode($denunciado);
            $input['recaudos'] = json_encode($recaudos);
        }
        if ($input['tipo_solicitud_id'] == 3) {
            $reclamo = [
                [
                    "relato" => $input['relato'],
                    "observacion" => $input['observacion'],
                    "expliquepresentada" => $input['explique'],
                    "explique competencia" => $input['explique2']
                ]
            ];
            $denunciado = [
                [
                    "cedula" => $input['ceduladenunciado'],
                    "nombre" => $input['nombredenunciado'],
                    "testigo" => $input['testigo']
                ]
            ];
            $recaudos = [
                [
                    "cedula" => isset($input['checkcedula']) ? $input['checkcedula'] : NULL,
                    "motivo" => isset($input['checkmotivo']) ? $input['checkmotivo'] : NULL,
                    "video" => isset($input['checkvideo']) ? $input['checkvideo'] : NULL,
                    "foto" => isset($input['checkfoto']) ? $input['checkfoto'] : NULL,
                    "grabacion" => isset($input['checkgrabacion']) ? $input['checkgrabacion'] : NULL,
                    "testigo" => isset($input['checktestigo']) ? $input['checktestigo'] : NULL,
                    "residencia" => isset($input['checkresidencia']) ? $input['checkresidencia'] : NULL
                ]
            ];

            $input['reclamos'] = json_encode($reclamo);
            $input['denunciado'] = json_encode($denunciado);
            $input['recaudos'] = json_encode($recaudos);
        }
        if ($input['tipo_solicitud_id'] == 4) {
            $sugerencia = [
                [
                    "observacion" => $input['observacion2'],
                ]
            ];
            $recaudos = [
                [
                    "motivo" => isset($input['checkmotivo2']) ? $input['checkmotivo2'] : NULL
                ]
            ];

            $input['sugerencia'] = json_encode($sugerencia);
            $input['recaudos'] = json_encode($recaudos);
        }
        if ($input['tipo_solicitud_id'] == 5) {
            $asesoria = [
                [
                    "observacion" => isset($input['observacion2']) ? $input['observacion2'] : NULL
                ]
            ];
            $recaudos = [
                [
                    "motivo" => isset($input['checkmotivo2']) ? $input['checkmotivo2'] : NULL
                ]
            ];

            $input['asesoria'] = json_encode($asesoria);
            $input['recaudos'] = json_encode($recaudos);
        }
        if ($input['tipo_solicitud_id'] == 6) {
            $beneficiario = [
                [
                    "cedula" => isset($input['cedulabeneficiario']) ? $input['cedulabeneficiario'] : NULL,
                    "nombre" => isset($input['nombrebeneficiario']) ? $input['nombrebeneficiario'] : NULL,
                    "direccion" => isset($input['direccionbeneficiario']) ? $input['direccionbeneficiario'] : NULL
                ]
            ];
            $recaudos = [
                [
                    "cedula" => isset($input['checkcedula2']) ? $input['checkcedula2'] : NULL,
                    "motivo" => isset($input['checkmotivo3']) ? $input['checkmotivo3'] : NULL,
                    "informe" => isset($input['checkinforme']) ? $input['checkinforme'] : NULL,
                    "beneficiario" => isset($input['checkcedulabeneficiario']) ? $input['checkcedulabeneficiario'] : NULL
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
        $solicitud_Update = Solicitud::find($id);
        $solicitud_Update->update($input);

        return redirect('/solicitud');
    }

    private function update_image($request, $avatar_viejo, &$user_Update)
    {
        /** Se actualizan todos los datos solicitados por el Cliente 
         *  y eliminamos del Storage/avatars, el archivo indicado.
         */
        if ($request->hasFile('avatar')) {
            $esta = file_exists(public_path('/storage/avatars/' . $avatar_viejo));
            if ($avatar_viejo != 'default.jpg' && $esta) {
                unlink(public_path('/storage/avatars/' . $avatar_viejo));
            }
            $avatar = $request->file('avatar');
            $filename = time() . '.' . $avatar->getClientOriginalExtension();
            \Image::make($avatar)->resize(300, 300)
                ->save(public_path('/storage/avatars/' . $filename));
            $user_Update->avatar = $filename;
        }
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $user_delete = User::find($id);
        $nombre = $user_delete->name;
        User::destroy($id);
        $esta = file_exists(public_path('/storage/avatars/' . $user_delete->avatar));
        if ($user_delete->avatar != 'default.jpg' && $esta) {
            unlink(public_path('/storage/avatars/' . $user_delete->avatar));
        }
        session(['delete' => true]);
        return redirect('/users');
    }

    public function usuarioRol(Request $request)
    {
        if ($request->ajax()) {
            $countUserRol = (new User)->count_User_Rol();
            return response()->json($countUserRol);
        }
    }

    public function notificationsUser(Request $request)
    {
        if ($request->ajax()) {
            $countNotificationsUsers = (new User)->count_User_notifications();
            return response()->json($countNotificationsUsers);
        }
    }
    public function solicitudTipo(Request $request)
    {
        if ($request->ajax()) {
            $countSolicitud = (new Solicitud)->count_solictud();

            return response()->json($countSolicitud);
        }
    }
    public function solicitudTotalTipo(Request $request)
    {
        if ($request->ajax()) {
            $countTotalSolicitud = (new Solicitud)->count_total_solictud();

            return response()->json($countTotalSolicitud);
        }
    }
    public function colorView()
    {
        $titulo_modulo = trans('message.users_action.cambiar_colores');
        $count_notification = (new User)->count_noficaciones_user();
        $array_color = (new Colores)->getColores();
        return view('User.color_view', compact('count_notification', 'titulo_modulo', 'array_color'));
    }

    public function colorChange(Request $request)
    {
        $id = auth()->user()->id;
        $user = User::find($id);
        $colores = $user->colores;
        if ($request->dafault_color_01 == 'NO') {
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
        } elseif ($request->dafault_color_01 == 'YES') {
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
        } elseif ($request->dafault_color_01 == 'BLUE') {
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
        } elseif ($request->dafault_color_01 == 'GREEN') {
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
        } else {
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
    public function imprimir(Request $request)
    {
        $activardenuncia = "";
        $activarqueja = "";
        $activarsugerencia = "";
        $activarasesoria = "";
        $activarreclamos = "";
        $activarpeticiones = "";
        $activarrecaudoCedula = "";
        $activarrecaudoMotivo = "";
        $activarrecaudoVideo = "";
        $activarrecaudoFoto = "";
        $activarrecaudoGrabacion = "";
        $activarrecaudoCedulaTestigo = "";
        $activarrecaudoCartaResidencia = "";
        $activarrecaudoExposiciondeMotivo = "";
        $activarrecaudoInforme = "";
        $activarrecaudoBeneficiario = "";

        $quejasRelato = NULL;
        $quejasObservacion = NULL;
        $quejasExpliquePresentada = NULL;
        $quejasExpliqueCompetencia = NULL;

        $dompdf = new DOMPDF();
        $request = $request->all();
        $idsolicitud = $request["idsolicitud"];
        $nombreUsuario = $request["usuario"];
        $solicitud = Solicitud::find($idsolicitud);
        
        $direccionAsignada = (new Direccion)->datos_direccion()[$solicitud->direccion_id];
        $idestado = $solicitud["estado_id"];
        $idmunicipio = $solicitud["municipio_id"];
        $idparroquia = $solicitud["parroquia_id"];
        $idcomuna = $solicitud["comuna_id"];
        $idcomunidad = $solicitud["comunidad_id"];
        $estado = (new Solicitud)->nombreestado($idestado, $idmunicipio, $idparroquia, $idcomuna, $idcomunidad);
        foreach ($estado as $estado2);
        $fecha = date('d-m-Y', strtotime($solicitud->fecha));
        $dia = date('d', strtotime($solicitud->fecha));
        $mes = date('m', strtotime($solicitud->fecha));
        $anno = date('Y', strtotime($solicitud->fecha));
        $hora = date('h:i A', strtotime($solicitud->fecha));

        $nombreDenunciado = "";
        $testigoDenunciado = "";
        $quejasRelato = "";
        $quejasObservacion = "";
        $quejasExpliquePresentada = "";
        $quejasExpliqueCompetencia = "";
        $cedulaDenunciado = "";

        $cwd = getcwd();
        $valor = "";
        $htmlsolicitud = "";

        if ($solicitud["tipo_solicitud_id"] === 1) {
            $activardenuncia = "checked";
            $valor = "Denuncia";
            $recaudos = $solicitud->recaudos;
            $recaudos = json_decode($recaudos, true);
            // var_dump($recaudos);
            // exit();
            $fotoRecaudos = $recaudos[0]["foto"];
            $videoRecaudos = $recaudos[0]["video"];
            $motivoRecaudos = $recaudos[0]["motivo"];
            $testigoRecaudos = $recaudos[0]["testigo"];
            $grabacionRecaudos = $recaudos[0]["grabacion"];
            $cedulaRecaudos = $recaudos[0]["cedula"];
            $residenciaRecaudos = $recaudos[0]["residencia"];
            if($fotoRecaudos === "on"){
                $activarrecaudoFoto = "checked";
            }
            if($videoRecaudos === "on"){
                $activarrecaudoVideo = "checked";
            }
            if($motivoRecaudos === "on"){
                $activarrecaudoMotivo = "checked";
            }
            if($testigoRecaudos === "on"){
                $activarrecaudoCedulaTestigo = "checked";
            }
            if($grabacionRecaudos === "on"){
                $activarrecaudoGrabacion = "checked";
            }
            if($cedulaRecaudos === "on"){
                $activarrecaudoCedulaTestigo = "checked";
            }
            if($residenciaRecaudos === "on"){
                $activarrecaudoCartaResidencia = "checked";
            }
            $htmlsolicitud = <<<HTML
            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <title>Planilla</title>
                <style>
                    body {
                        font-family: sans-serif;
                    }
    
                    table {
                        width: 100%;
                        border-collapse: collapse;
                    }
    
                    th, td {
                        text-align:center;
                        border: 1px solid #ddd;
                    }
    
                    th {
                        font-size: 12px;
                        background-color: #f0f0f0;
                    }
                    td{
                        font-size: 12px;
                    }
                </style>
            </head>
            <body>
            <!-- <img src="/images/icons/unnamed.png" alt="" srcset=""> -->
                <table>
                    <tr>
                        <th>Numero de Registro $idsolicitud</th>
                        <th>Oficina de Atencion Ciudadana</th>
                        <th>Planilla de Solicitud</th>
                        <th>Dia: $dia</th>
                        <th>Mes: $mes</th>
                        <th>Año: $anno</th>
                    </tr>
                </table>
                
                <table>
                    <tr>
                        <th>Denuncia</th>
                        <th>Queja</th>
                        <th>Sugerencia</th>
                        <th>Asesoria</th>
                        <th>Reclamos</th>
                        <th>Peticion</th>
                        <tr>
                        <td><input type="checkbox" $activardenuncia></td>
                        <td><input type="checkbox" $activarqueja></td>
                        <td><input type="checkbox" $activarsugerencia></td>
                        <td><input type="checkbox" $activarasesoria></td>
                        <td><input type="checkbox" $activarreclamos></td>
                        <td><input type="checkbox" $activarpeticiones></td>
                        </tr>
                    </tr>
                </table>
                <table>
                    <tr>
                        <th>Datos del ciudadano(a) Solicitante</th>
                    </tr>
                </table>
                <table class="table table-bordered" border="0">
                    <tr>
                        <th class="text-primary" >Nombre Y Apellido</th>
                        <th>Cedula</th>
                        <th>Telefono</th>
                        <th>Telefono Casa</th>
                        <th>Correo Electronico</th>
                        <th>Sexo</th>
                        <th>Estado Civil</th>
                        <th>Fecha de Nacimiento</th>
                        <th>Nivel Educativo</th>
                        <th>Ocupacion O/U Oficio</th>
                    </tr>
                    <tr>
                        <td>$solicitud->nombre</td>
                        <td>$solicitud->cedula</td>
                        <td>$solicitud->telefono</td>
                        <td>$solicitud->telefono2</td>
                        <td>$solicitud->email</td>
                        <td>$solicitud->sexo</td>
                        <td>$solicitud->edocivil</td>
                        <td>$solicitud->fechaNacimiento</td>
                        <td>$solicitud->nivelestudio</td> 
                        <td>$solicitud->profesion</td> 
                    </tr>
            </table>
    
            <table>
            <tr >
                        <th class="text-primary" >Estado</th>
                        <th>Municipio</th>
                        <th>Parroquia</th>
                        <th>Comuna</th>
                        <th>Comunidad</th>
                        <th>Direccion Habitacion</th>
                        <th>Tipo de Solicitud</th>
                    </tr>
                    <tr>
                        <td>$estado2->estado2</td>
                        <td>$estado2->municipio</td>
                        <td>$estado2->parroquia</td>
                        <td>$estado2->comuna</td>
                        <td>$estado2->comunidad</td>
                        <td>$solicitud->direccion</td>
                        <td>$valor</td>
                    </tr>
                        </table>
                        <table>
                    <tr>
                        <th>Recaudos de la Peticion</th>
                    </tr>
            </table>

                <table>
                    <tr>
                        <!-- <th>Asignacion</th> -->
                        <th>Direccion Asignada</th>
                        <!-- <th>Coordinacion Asignada</th> -->
                    </tr>
                    <tr>
                        <!-- <td>$solicitud->asignacion</td> -->
                        <td>$direccionAsignada</td>
                        <!-- <td></td> -->
                    </tr>
                </table>

                <table>
                    <tr>
                        <th>Datos de Denuncia, Reclamo o Queja</th>
                    </tr>
                </table>

                <table>
                    <tr>
                        <th>Cedula de Denunciado</th>
                        <!-- <th>Tipo de Registro</th> -->
                        <th>Nombre del Denunciado</th>
                        <th>Testigos</th>
                        <!-- <th>Edad</th>
                        <th>Estado Civil</th>
                        <th>Fecha de nacimiento</th>
                        <th>Nivel Educativo</th>
                        <th>Profesion</th>
                        <th>Parentesco</th> -->
                    </tr>
                    <tr>
                        <td>$cedulaDenunciado</td>
                        <!-- <td></td> -->
                        <td>$nombreDenunciado</td>
                        <td>$testigoDenunciado</td>
                        <!-- <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td> -->
                    </tr>
                </table>
                <table>
                    <tr>
                        <th>Descripcion de Hechos</th>
                        <th>Observacion</th>
                        <th>Denuncia Presentada</th>
                        <th>Explique</th>
                    </tr>
                    <tr>
                        <td>$quejasRelato</td>
                        <td>$quejasObservacion</td>
                        <td>$quejasExpliquePresentada</td>
                        <td>$quejasExpliqueCompetencia</td>
                    </tr>
                </table>
                    <table>
                        <tr><th>
                            Recaudos de la Solicitud
                        </th></tr>
                    </table>

                    <table>
                    <tr>
                        <th>Copia de Cedula</th>
                        <th>Carta Exposicion de Motivo</th>
                        <th>Video</th>
                        <th>Foto</th>
                        <th>Grabacion</th>
                        <th>Cedula Testigo</th>
                        <th>Carta de Residencia</th>
                    </tr>
                    <tr>
                        <td><input type='checkbox' $activarrecaudoCedula></td>
                        <td><input type='checkbox' $activarrecaudoMotivo></td>
                        <td><input type='checkbox' $activarrecaudoVideo></td>
                        <td><input type='checkbox' $activarrecaudoFoto></td>
                        <td><input type='checkbox' $activarrecaudoGrabacion></td>
                        <td><input type='checkbox' $activarrecaudoCedulaTestigo></td>
                        <td><input type='checkbox' $activarrecaudoCartaResidencia></td>
                    </tr>
                </table>
                <table>
                    <tr>
                        <th style="padding:1rem;">Declaro que los datos suministrados son fidedignos y estoy en conocimiento que cualquier falta o falsedad, en los mismos involucra sanciones o a la no aceptacion de la solicitud.</th>                            
                    </tr>
                </table>
                <table>
                    <tr>
                        <th>Firma del Solicitante</th>
                        <th>Huella Dactilar</th>
                    </tr>
                    <tr>
                        <td style="padding:2rem;"></td>
                        <td></td>
                    </tr>
                </table>

                <table>
                    <tr>
                        <th>Solo para ser llenado por la Unidad Receptora</th>
                    </tr>
                </table>

                <table>
                    <tr>
                        <th>Prioridad del tramite</th>
                    </tr>
                </table>

                <table>
                    <tr>
                        <td>Alta<input type='checkbox'></td>
                        <td>Media<input type='checkbox'></td>
                        <td>Baja<input type='checkbox'></td>
                    </tr>
                </table>
                <table>
                    <tr>
                        <th>Descripcion de el tramite</th>
                    </tr>
                    <tr>
                        <td style="padding: 2rem"></td>
                    </tr>
                </table>
                <table>
                    <tr>
                        <th>Nombre del Funcionario Receptor</th>
                        <!-- <th>Cedula de Identidad</th> -->
                        <th>Sello y Firma</th>
                    </tr>
                    <tr>
                        <td style="padding: 15px">$nombreUsuario</td>
                        <!-- <td></td> -->
                        <td></td>
                    </tr>
                </table>

                <table style="margin-top: 20px">
                    <tr>
                        <th>Oficina de Atencion Ciudadana <span style="text-align: right">Numero de Registro $idsolicitud</span></th>
                    </tr>
                </table>

                <table>
                    <tr>
                        <th>
                            Planilla de Solicitud:
                        </th>
                    </tr>
                </table>

                    <table>
                        <tr>
                            <th>Denuncia</th>
                            <th>Queja</th>
                            <th>Sugerencia</th>
                            <th>Asesoria</th>
                            <th>Reclamos</th>
                            <th>Peticion</th>
                            <tr>
                            <td><input type="checkbox" $activardenuncia></td>
                            <td><input type="checkbox" $activarqueja></td>
                            <td><input type="checkbox" $activarsugerencia></td>
                            <td><input type="checkbox" $activarasesoria></td>
                            <td><input type="checkbox" $activarreclamos></td>
                            <td><input type="checkbox" $activarpeticiones></td>
                            </tr>
                        </tr>
                    </table>
                </table>
                <table>
                        <tr>
                            <th>Fecha de Solicitud</th>
                            <th>Hora</th>
                        <th>Nombre y Apellido del Ciudadano Solicitante</th>                    
                        <th>Nombre del Funcionario Receptor</th>                    
                    </tr>
                    <tr>
                        <td>$fecha</td>
                        <td>$hora</td>
                        <td>$solicitud->nombre</td>
                        <td>$nombreUsuario</td>
                    </tr>
                </table>
                <table>
                    <tr>
                        <th>Firma del Funcionario Receptor</th>
                        <th>Sello</th>
                    </tr>
                    <tr>
                        <td style="padding: 2rem"></td>
                        <td></td>
                    </tr>
                </table>
                <h5 style="text-align: center">Usted podra solicitar informacion sobre su solicitud en la Oficina de Atencion Ciudadana a traves de los telefonos (0414 1572028) (0412 5526701)</h5>
                <h5 style="text-align: center">Todos los tramites realizados ante esta oficina son absolutamente gratuitos</h5>
                    </body>
                    </html>
            HTML;
        }

        if ($solicitud["tipo_solicitud_id"] === 2) {
            $activarqueja = "checked";
            $valor = "Queja";
            $recaudos = $solicitud->recaudos;
            $recaudos = json_decode($recaudos, true);
            $denunciado = $solicitud->denunciado;
            $denunciado = json_decode($denunciado, true);

            $cedulaDenunciado = $denunciado[0]["cedula"];
            $nombreDenunciado = $denunciado[0]["nombre"];
            $testigoDenunciado = $denunciado[0]["testigo"];

            $quejas = $solicitud->quejas;
            $quejas = json_decode($quejas, true);
            $quejasRelato = $quejas[0]["relato"];
            $quejasObservacion = $quejas[0]["observacion"];
            $quejasExpliquePresentada = $quejas[0]["expliquepresentada"];
            $quejasExpliqueCompetencia = $quejas[0]["explique competencia"];

            $fotoRecaudos = $recaudos[0]["foto"];
            $videoRecaudos = $recaudos[0]["video"];
            $motivoRecaudos = $recaudos[0]["motivo"];
            $testigoRecaudos = $recaudos[0]["testigo"];
            $grabacionRecaudos = $recaudos[0]["grabacion"];
            $cedulaRecaudos = $recaudos[0]["cedula"];
            $residenciaRecaudos = $recaudos[0]["residencia"];
            if($fotoRecaudos === "on"){
                $activarrecaudoFoto = "checked";
            }
            if($videoRecaudos === "on"){
                $activarrecaudoVideo = "checked";
            }
            if($motivoRecaudos === "on"){
                $activarrecaudoMotivo = "checked";
            }
            if($testigoRecaudos === "on"){
                $activarrecaudoCedulaTestigo = "checked";
            }
            if($grabacionRecaudos === "on"){
                $activarrecaudoGrabacion = "checked";
            }
            if($cedulaRecaudos === "on"){
                $activarrecaudoCedula = "checked";
            }
            if($residenciaRecaudos === "on"){
                $activarrecaudoCartaResidencia = "checked";
            }
            $htmlsolicitud = <<<HTML
            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <title>Planilla</title>
                <style>
                    body {
                        font-family: sans-serif;
                    }
    
                    table {
                        width: 100%;
                        border-collapse: collapse;
                    }
    
                    th, td {
                        text-align:center;
                        border: 1px solid #ddd;
                    }
    
                    th {
                        font-size: 12px;
                        background-color: #f0f0f0;
                    }
                    td{
                        font-size: 12px;
                    }
                </style>
            </head>
            <body>
            <!-- <img src="/images/icons/unnamed.png" alt="" srcset=""> -->
                <table>
                    <tr>
                        <th>Numero de Registro $idsolicitud</th>
                        <th>Oficina de Atencion Ciudadana</th>
                        <th>Planilla de Solicitud</th>
                        <th>Dia: $dia</th>
                        <th>Mes: $mes</th>
                        <th>Año: $anno</th>
                    </tr>
                </table>
                
                <table>
                    <tr>
                        <th>Denuncia</th>
                        <th>Queja</th>
                        <th>Sugerencia</th>
                        <th>Asesoria</th>
                        <th>Reclamos</th>
                        <th>Peticion</th>
                        <tr>
                        <td><input type="checkbox" $activardenuncia></td>
                        <td><input type="checkbox" $activarqueja></td>
                        <td><input type="checkbox" $activarsugerencia></td>
                        <td><input type="checkbox" $activarasesoria></td>
                        <td><input type="checkbox" $activarreclamos></td>
                        <td><input type="checkbox" $activarpeticiones></td>
                        </tr>
                    </tr>
                </table>
                <table>
                    <tr>
                        <th>Datos del ciudadano(a) Solicitante</th>
                    </tr>
                </table>
                <table class="table table-bordered" border="0">
                    <tr>
                        <th class="text-primary" >Nombre Y Apellido</th>
                        <th>Cedula</th>
                        <th>Telefono</th>
                        <th>Telefono Casa</th>
                        <th>Correo Electronico</th>
                        <th>Sexo</th>
                        <th>Estado Civil</th>
                        <th>Fecha de Nacimiento</th>
                        <th>Nivel Educativo</th>
                        <th>Ocupacion O/U Oficio</th>
                    </tr>
                    <tr>
                        <td>$solicitud->nombre</td>
                        <td>$solicitud->cedula</td>
                        <td>$solicitud->telefono</td>
                        <td>$solicitud->telefono2</td>
                        <td>$solicitud->email</td>
                        <td>$solicitud->sexo</td>
                        <td>$solicitud->edocivil</td>
                        <td>$solicitud->fechaNacimiento</td>
                        <td>$solicitud->nivelestudio</td> 
                        <td>$solicitud->profesion</td> 
                    </tr>
            </table>
    
            <table>
            <tr >
                        <th class="text-primary" >Estado</th>
                        <th>Municipio</th>
                        <th>Parroquia</th>
                        <th>Comuna</th>
                        <th>Comunidad</th>
                        <th>Direccion Habitacion</th>
                        <th>Tipo de Solicitud</th>
                    </tr>
                    <tr>
                        <td>$estado2->estado2</td>
                        <td>$estado2->municipio</td>
                        <td>$estado2->parroquia</td>
                        <td>$estado2->comuna</td>
                        <td>$estado2->comunidad</td>
                        <td>$solicitud->direccion</td>
                        <td>$valor</td>
                    </tr>
                        </table>
                        <table>
                    <tr>
                        <th>Recaudos de la Peticion</th>
                    </tr>
            </table>

                <table>
                    <tr>
                        <!-- <th>Asignacion</th> -->
                        <th>Direccion Asignada</th>
                        <!-- <th>Coordinacion Asignada</th> -->
                    </tr>
                    <tr>
                        <!-- <td>$solicitud->asignacion</td> -->
                        <td>$direccionAsignada</td>
                        <!-- <td></td> -->
                    </tr>
                </table>

                <table>
                    <tr>
                        <th>Datos de Denuncia, Reclamo o Queja</th>
                    </tr>
                </table>

                <table>
                    <tr>
                        <th>Cedula de Denunciado</th>
                        <!-- <th>Tipo de Registro</th> -->
                        <th>Nombre del Denunciado</th>
                        <th>Testigos</th>
                        <!-- <th>Edad</th>
                        <th>Estado Civil</th>
                        <th>Fecha de nacimiento</th>
                        <th>Nivel Educativo</th>
                        <th>Profesion</th>
                        <th>Parentesco</th> -->
                    </tr>
                    <tr>
                        <td>$cedulaDenunciado</td>
                        <!-- <td></td> -->
                        <td>$nombreDenunciado</td>
                        <td>$testigoDenunciado</td>
                        <!-- <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td> -->
                    </tr>
                </table>
                <table>
                    <tr>
                        <th>Descripcion de Hechos</th>
                        <th>Observacion</th>
                        <th>Denuncia Presentada</th>
                        <th>Explique</th>
                    </tr>
                    <tr>
                        <td>$quejasRelato</td>
                        <td>$quejasObservacion</td>
                        <td>$quejasExpliquePresentada</td>
                        <td>$quejasExpliqueCompetencia</td>
                    </tr>
                </table>
                    <table>
                        <tr><th>
                            Recaudos de la Solicitud
                        </th></tr>
                    </table>

                    <table>
                    <tr>
                        <th>Copia de Cedula</th>
                        <th>Carta Exposicion de Motivo</th>
                        <th>Video</th>
                        <th>Foto</th>
                        <th>Grabacion</th>
                        <th>Cedula Testigo</th>
                        <th>Carta de Residencia</th>
                    </tr>
                    <tr>
                        <td><input type='checkbox' $activarrecaudoCedula></td>
                        <td><input type='checkbox' $activarrecaudoMotivo></td>
                        <td><input type='checkbox' $activarrecaudoVideo></td>
                        <td><input type='checkbox' $activarrecaudoFoto></td>
                        <td><input type='checkbox' $activarrecaudoGrabacion></td>
                        <td><input type='checkbox' $activarrecaudoCedulaTestigo></td>
                        <td><input type='checkbox' $activarrecaudoCartaResidencia></td>
                    </tr>
                </table>
                <table>
                    <tr>
                        <th style="padding:1rem;">Declaro que los datos suministrados son fidedignos y estoy en conocimiento que cualquier falta o falsedad, en los mismos involucra sanciones o a la no aceptacion de la solicitud.</th>                            
                    </tr>
                </table>
                <table>
                    <tr>
                        <th>Firma del Solicitante</th>
                        <th>Huella Dactilar</th>
                    </tr>
                    <tr>
                        <td style="padding:2rem;"></td>
                        <td></td>
                    </tr>
                </table>

                <table>
                    <tr>
                        <th>Solo para ser llenado por la Unidad Receptora</th>
                    </tr>
                </table>

                <table>
                    <tr>
                        <th>Prioridad del tramite</th>
                    </tr>
                </table>

                <table>
                    <tr>
                        <td>Alta<input type='checkbox'></td>
                        <td>Media<input type='checkbox'></td>
                        <td>Baja<input type='checkbox'></td>
                    </tr>
                </table>
                <table>
                    <tr>
                        <th>Descripcion de el tramite</th>
                    </tr>
                    <tr>
                        <td style="padding: 2rem"></td>
                    </tr>
                </table>
                <table>
                    <tr>
                        <th>Nombre del Funcionario Receptor</th>
                        <!-- <th>Cedula de Identidad</th> -->
                        <th>Sello y Firma</th>
                    </tr>
                    <tr>
                        <td style="padding: 15px">$nombreUsuario</td>
                        <!-- <td></td> -->
                        <td></td>
                    </tr>
                </table>

                <table style="margin-top: 20px">
                    <tr>
                        <th>Oficina de Atencion Ciudadana <span style="text-align: right">Numero de Registro $idsolicitud</span></th>
                    </tr>
                </table>

                <table>
                    <tr>
                        <th>
                            Planilla de Solicitud:
                        </th>
                    </tr>
                </table>

                    <table>
                        <tr>
                            <th>Denuncia</th>
                            <th>Queja</th>
                            <th>Sugerencia</th>
                            <th>Asesoria</th>
                            <th>Reclamos</th>
                            <th>Peticion</th>
                            <tr>
                            <td><input type="checkbox" $activardenuncia></td>
                            <td><input type="checkbox" $activarqueja></td>
                            <td><input type="checkbox" $activarsugerencia></td>
                            <td><input type="checkbox" $activarasesoria></td>
                            <td><input type="checkbox" $activarreclamos></td>
                            <td><input type="checkbox" $activarpeticiones></td>
                            </tr>
                        </tr>
                    </table>
                </table>
                <table>
                        <tr>
                            <th>Fecha de Solicitud</th>
                            <th>Hora</th>
                        <th>Nombre y Apellido del Ciudadano Solicitante</th>                    
                        <th>Nombre del Funcionario Receptor</th>                    
                    </tr>
                    <tr>
                        <td>$fecha</td>
                        <td>$hora</td>
                        <td>$solicitud->nombre</td>
                        <td>$nombreUsuario</td>
                    </tr>
                </table>
                <table>
                    <tr>
                        <th>Firma del Funcionario Receptor</th>
                        <th>Sello</th>
                    </tr>
                    <tr>
                        <td style="padding: 2rem"></td>
                        <td></td>
                    </tr>
                </table>
                <h5 style="text-align: center">Usted podra solicitar informacion sobre su solicitud en la Oficina de Atencion Ciudadana a traves de los telefonos (0414 1572028) (0412 5526701)</h5>
                <h5 style="text-align: center">Todos los tramites realizados ante esta oficina son absolutamente gratuitos</h5>
                    </body>
                    </html>
            HTML;
        }

        if ($solicitud["tipo_solicitud_id"] === 3) {
            $activarreclamos = "checked";
            $valor = "Reclamos";

            $recaudos = $solicitud->recaudos;
            $recaudos = json_decode($recaudos, true);
            $denunciado = $solicitud->denunciado;
            $denunciado = json_decode($denunciado, true);
            
            $cedulaDenunciado = $denunciado[0]["cedula"];
            $nombreDenunciado = $denunciado[0]["nombre"];
            $testigoDenunciado = $denunciado[0]["testigo"];
            
            $quejas = $solicitud->reclamo;
            $quejas = json_decode($quejas, true);
            $quejasRelato = $quejas[0]["relato"];
            $quejasObservacion = $quejas[0]["observacion"];
            $quejasExpliquePresentada = $quejas[0]["expliquepresentada"];
            $quejasExpliqueCompetencia = $quejas[0]["explique competencia"];

            $fotoRecaudos = $recaudos[0]["foto"];
            $videoRecaudos = $recaudos[0]["video"];
            $motivoRecaudos = $recaudos[0]["motivo"];
            $testigoRecaudos = $recaudos[0]["testigo"];
            $grabacionRecaudos = $recaudos[0]["grabacion"];
            $cedulaRecaudos = $recaudos[0]["cedula"];
            $residenciaRecaudos = $recaudos[0]["residencia"];
            if($fotoRecaudos === "on"){
                $activarrecaudoFoto = "checked";
            }
            if($videoRecaudos === "on"){
                $activarrecaudoVideo = "checked";
            }
            if($motivoRecaudos === "on"){
                $activarrecaudoMotivo = "checked";
            }
            if($testigoRecaudos === "on"){
                $activarrecaudoCedulaTestigo = "checked";
            }
            if($grabacionRecaudos === "on"){
                $activarrecaudoGrabacion = "checked";
            }
            if($cedulaRecaudos === "on"){
                $activarrecaudoCedula = "checked";
            }
            if($residenciaRecaudos === "on"){
                $activarrecaudoCartaResidencia = "checked";
            }
            $htmlsolicitud = <<<HTML
            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <title>Planilla</title>
                <style>
                    body {
                        font-family: sans-serif;
                    }
    
                    table {
                        width: 100%;
                        border-collapse: collapse;
                    }
    
                    th, td {
                        text-align:center;
                        border: 1px solid #ddd;
                    }
    
                    th {
                        font-size: 12px;
                        background-color: #f0f0f0;
                    }
                    td{
                        font-size: 12px;
                    }
                </style>
            </head>
            <body>
            <!-- <img src="/images/icons/unnamed.png" alt="" srcset=""> -->
                <table>
                    <tr>
                        <th>Numero de Registro $idsolicitud</th>
                        <th>Oficina de Atencion Ciudadana</th>
                        <th>Planilla de Solicitud</th>
                        <th>Dia: $dia</th>
                        <th>Mes: $mes</th>
                        <th>Año: $anno</th>
                    </tr>
                </table>
                
                <table>
                    <tr>
                        <th>Denuncia</th>
                        <th>Queja</th>
                        <th>Sugerencia</th>
                        <th>Asesoria</th>
                        <th>Reclamos</th>
                        <th>Peticion</th>
                        <tr>
                        <td><input type="checkbox" $activardenuncia></td>
                        <td><input type="checkbox" $activarqueja></td>
                        <td><input type="checkbox" $activarsugerencia></td>
                        <td><input type="checkbox" $activarasesoria></td>
                        <td><input type="checkbox" $activarreclamos></td>
                        <td><input type="checkbox" $activarpeticiones></td>
                        </tr>
                    </tr>
                </table>
                <table>
                    <tr>
                        <th>Datos del ciudadano(a) Solicitante</th>
                    </tr>
                </table>
                <table class="table table-bordered" border="0">
                    <tr>
                        <th class="text-primary" >Nombre Y Apellido</th>
                        <th>Cedula</th>
                        <th>Telefono</th>
                        <th>Telefono Casa</th>
                        <th>Correo Electronico</th>
                        <th>Sexo</th>
                        <th>Estado Civil</th>
                        <th>Fecha de Nacimiento</th>
                        <th>Nivel Educativo</th>
                        <th>Ocupacion O/U Oficio</th>
                    </tr>
                    <tr>
                        <td>$solicitud->nombre</td>
                        <td>$solicitud->cedula</td>
                        <td>$solicitud->telefono</td>
                        <td>$solicitud->telefono2</td>
                        <td>$solicitud->email</td>
                        <td>$solicitud->sexo</td>
                        <td>$solicitud->edocivil</td>
                        <td>$solicitud->fechaNacimiento</td>
                        <td>$solicitud->nivelestudio</td> 
                        <td>$solicitud->profesion</td> 
                    </tr>
            </table>
    
            <table>
            <tr >
                        <th class="text-primary" >Estado</th>
                        <th>Municipio</th>
                        <th>Parroquia</th>
                        <th>Comuna</th>
                        <th>Comunidad</th>
                        <th>Direccion Habitacion</th>
                        <th>Tipo de Solicitud</th>
                    </tr>
                    <tr>
                        <td>$estado2->estado2</td>
                        <td>$estado2->municipio</td>
                        <td>$estado2->parroquia</td>
                        <td>$estado2->comuna</td>
                        <td>$estado2->comunidad</td>
                        <td>$solicitud->direccion</td>
                        <td>$valor</td>
                    </tr>
                        </table>
                        <table>
                    <tr>
                        <th>Recaudos de la Peticion</th>
                    </tr>
            </table>

                <table>
                    <tr>
                        <!-- <th>Asignacion</th> -->
                        <th>Direccion Asignada</th>
                        <!-- <th>Coordinacion Asignada</th> -->
                    </tr>
                    <tr>
                        <!-- <td>$solicitud->asignacion</td> -->
                        <td>$direccionAsignada</td>
                        <!-- <td></td> -->
                    </tr>
                </table>

                <table>
                    <tr>
                        <th>Datos de Denuncia, Reclamo o Queja</th>
                    </tr>
                </table>

                <table>
                    <tr>
                        <th>Cedula de Denunciado</th>
                        <!-- <th>Tipo de Registro</th> -->
                        <th>Nombre del Denunciado</th>
                        <th>Testigos</th>
                        <!-- <th>Edad</th>
                        <th>Estado Civil</th>
                        <th>Fecha de nacimiento</th>
                        <th>Nivel Educativo</th>
                        <th>Profesion</th>
                        <th>Parentesco</th> -->
                    </tr>
                    <tr>
                        <td>$cedulaDenunciado</td>
                        <!-- <td></td> -->
                        <td>$nombreDenunciado</td>
                        <td>$testigoDenunciado</td>
                        <!-- <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td> -->
                    </tr>
                </table>
                <table>
                    <tr>
                        <th>Descripcion de Hechos</th>
                        <th>Observacion</th>
                        <th>Denuncia Presentada</th>
                        <th>Explique</th>
                    </tr>
                    <tr>
                        <td>$quejasRelato</td>
                        <td>$quejasObservacion</td>
                        <td>$quejasExpliquePresentada</td>
                        <td>$quejasExpliqueCompetencia</td>
                    </tr>
                </table>
                    <table>
                        <tr><th>
                            Recaudos de la Solicitud
                        </th></tr>
                    </table>

                    <table>
                    <tr>
                        <th>Copia de Cedula</th>
                        <th>Carta Exposicion de Motivo</th>
                        <th>Video</th>
                        <th>Foto</th>
                        <th>Grabacion</th>
                        <th>Cedula Testigo</th>
                        <th>Carta de Residencia</th>
                    </tr>
                    <tr>
                        <td><input type='checkbox' $activarrecaudoCedula></td>
                        <td><input type='checkbox' $activarrecaudoMotivo></td>
                        <td><input type='checkbox' $activarrecaudoVideo></td>
                        <td><input type='checkbox' $activarrecaudoFoto></td>
                        <td><input type='checkbox' $activarrecaudoGrabacion></td>
                        <td><input type='checkbox' $activarrecaudoCedulaTestigo></td>
                        <td><input type='checkbox' $activarrecaudoCartaResidencia></td>
                    </tr>
                </table>
                <table>
                    <tr>
                        <th style="padding:1rem;">Declaro que los datos suministrados son fidedignos y estoy en conocimiento que cualquier falta o falsedad, en los mismos involucra sanciones o a la no aceptacion de la solicitud.</th>                            
                    </tr>
                </table>
                <table>
                    <tr>
                        <th>Firma del Solicitante</th>
                        <th>Huella Dactilar</th>
                    </tr>
                    <tr>
                        <td style="padding:2rem;"></td>
                        <td></td>
                    </tr>
                </table>

                <table>
                    <tr>
                        <th>Solo para ser llenado por la Unidad Receptora</th>
                    </tr>
                </table>

                <table>
                    <tr>
                        <th>Prioridad del tramite</th>
                    </tr>
                </table>

                <table>
                    <tr>
                        <td>Alta<input type='checkbox'></td>
                        <td>Media<input type='checkbox'></td>
                        <td>Baja<input type='checkbox'></td>
                    </tr>
                </table>
                <table>
                    <tr>
                        <th>Descripcion de el tramite</th>
                    </tr>
                    <tr>
                        <td style="padding: 2rem"></td>
                    </tr>
                </table>
                <table>
                    <tr>
                        <th>Nombre del Funcionario Receptor</th>
                        <!-- <th>Cedula de Identidad</th> -->
                        <th>Sello y Firma</th>
                    </tr>
                    <tr>
                        <td style="padding: 15px">$nombreUsuario</td>
                        <!-- <td></td> -->
                        <td></td>
                    </tr>
                </table>

                <table style="margin-top: 20px">
                    <tr>
                        <th>Oficina de Atencion Ciudadana <span style="text-align: right">Numero de Registro $idsolicitud</span></th>
                    </tr>
                </table>

                <table>
                    <tr>
                        <th>
                            Planilla de Solicitud:
                        </th>
                    </tr>
                </table>

                    <table>
                        <tr>
                            <th>Denuncia</th>
                            <th>Queja</th>
                            <th>Sugerencia</th>
                            <th>Asesoria</th>
                            <th>Reclamos</th>
                            <th>Peticion</th>
                            <tr>
                            <td><input type="checkbox" $activardenuncia></td>
                            <td><input type="checkbox" $activarqueja></td>
                            <td><input type="checkbox" $activarsugerencia></td>
                            <td><input type="checkbox" $activarasesoria></td>
                            <td><input type="checkbox" $activarreclamos></td>
                            <td><input type="checkbox" $activarpeticiones></td>
                            </tr>
                        </tr>
                    </table>
                </table>
                <table>
                        <tr>
                            <th>Fecha de Solicitud</th>
                            <th>Hora</th>
                        <th>Nombre y Apellido del Ciudadano Solicitante</th>                    
                        <th>Nombre del Funcionario Receptor</th>                    
                    </tr>
                    <tr>
                        <td>$fecha</td>
                        <td>$hora</td>
                        <td>$solicitud->nombre</td>
                        <td>$nombreUsuario</td>
                    </tr>
                </table>
                <table>
                    <tr>
                        <th>Firma del Funcionario Receptor</th>
                        <th>Sello</th>
                    </tr>
                    <tr>
                        <td style="padding: 2rem"></td>
                        <td></td>
                    </tr>
                </table>
                <h5 style="text-align: center">Usted podra solicitar informacion sobre su solicitud en la Oficina de Atencion Ciudadana a traves de los telefonos (0414 1572028) (0412 5526701)</h5>
                <h5 style="text-align: center">Todos los tramites realizados ante esta oficina son absolutamente gratuitos</h5>
                    </body>
                    </html>
            HTML;
        }

        if ($solicitud["tipo_solicitud_id"] === 4) {
            $observacion = $solicitud->sugerecia;
            $observacion = json_decode($observacion, true);
            $observacionAsesoria = $observacion[0]["observacion"];
            $activarsugerencia = "checked";
            $valor = "Sugerencia";
            $htmlsolicitud = <<<HTML
            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <title>Planilla</title>
                <style>
                    body {
                        font-family: sans-serif;
                    }
    
                    table {
                        width: 100%;
                        border-collapse: collapse;
                    }
    
                    th, td {
                        text-align:center;
                        border: 1px solid #ddd;
                    }
    
                    th {
                        font-size: 12px;
                        background-color: #f0f0f0;
                    }
                    td{
                        font-size: 12px;
                    }
                </style>
            </head>
            <body>
            <!-- <img src="/images/icons/unnamed.png" alt="" srcset=""> -->
                <table>
                    <tr>
                        <th>Numero de Registro $idsolicitud</th>
                        <th>Oficina de Atencion Ciudadana</th>
                        <th>Planilla de Solicitud</th>
                        <th>Dia: $dia</th>
                        <th>Mes: $mes</th>
                        <th>Año: $anno</th>
                    </tr>
                </table>
                
                <table>
                    <tr>
                        <th>Denuncia</th>
                        <th>Queja</th>
                        <th>Sugerencia</th>
                        <th>Asesoria</th>
                        <th>Reclamos</th>
                        <th>Peticion</th>
                        <tr>
                        <td><input type="checkbox" $activardenuncia></td>
                        <td><input type="checkbox" $activarqueja></td>
                        <td><input type="checkbox" $activarsugerencia></td>
                        <td><input type="checkbox" $activarasesoria></td>
                        <td><input type="checkbox" $activarreclamos></td>
                        <td><input type="checkbox" $activarpeticiones></td>
                        </tr>
                    </tr>
                </table>
                <table>
                    <tr>
                        <th>Datos del ciudadano(a) Solicitante</th>
                    </tr>
                </table>
                <table class="table table-bordered" border="0">
                    <tr>
                        <th class="text-primary" >Nombre Y Apellido</th>
                        <th>Cedula</th>
                        <th>Telefono</th>
                        <th>Telefono Casa</th>
                        <th>Correo Electronico</th>
                        <th>Sexo</th>
                        <th>Estado Civil</th>
                        <th>Fecha de Nacimiento</th>
                        <th>Nivel Educativo</th>
                        <th>Ocupacion O/U Oficio</th>
                    </tr>
                    <tr>
                        <td>$solicitud->nombre</td>
                        <td>$solicitud->cedula</td>
                        <td>$solicitud->telefono</td>
                        <td>$solicitud->telefono2</td>
                        <td>$solicitud->email</td>
                        <td>$solicitud->sexo</td>
                        <td>$solicitud->edocivil</td>
                        <td>$solicitud->fechaNacimiento</td>
                        <td>$solicitud->nivelestudio</td> 
                        <td>$solicitud->profesion</td> 
                    </tr>
            </table>
    
            <table>
            <tr >
                        <th class="text-primary" >Estado</th>
                        <th>Municipio</th>
                        <th>Parroquia</th>
                        <th>Comuna</th>
                        <th>Comunidad</th>
                        <th>Direccion Habitacion</th>
                        <th>Tipo de Solicitud</th>
                    </tr>
                    <tr>
                        <td>$estado2->estado2</td>
                        <td>$estado2->municipio</td>
                        <td>$estado2->parroquia</td>
                        <td>$estado2->comuna</td>
                        <td>$estado2->comunidad</td>
                        <td>$solicitud->direccion</td>
                        <td>$valor</td>
                    </tr>
                        </table>
                        <table>
                    <tr>
                        <th>Recaudos de la Peticion</th>
                    </tr>
            </table>

                <table>
                    <tr>
                        <!-- <th>Asignacion</th> -->
                        <th>Direccion Asignada</th>
                        <!-- <th>Coordinacion Asignada</th> -->
                    </tr>
                    <tr>
                        <!-- <td>$solicitud->asignacion</td> -->
                        <td>$direccionAsignada</td>
                        <!-- <td></td> -->
                    </tr>
                </table>

                <table>
                    <tr>
                        <th>Sugerencia o Asesoria</th>
                    </tr>
                </table>

                <table>
                    <tr>
                        <th>Observacion</th>
                    </tr>
                    <tr>
                        <td>$observacionAsesoria</td>
                    </tr>
                </table>
                
                    <table>
                        <tr>
                            <th>Documentos que anexa</th>
                        </tr>
                    </table>
                    <table>
                        <tr>
                            <th>Carta Exposicion de Motivo</th>
                        </tr>
                        <tr>
                            <td><input type='checkbox' $activarrecaudoMotivo></td>
                        </tr>
                    </table>
                <table>
                    <tr>
                        <th style="padding:1rem;">Declaro que los datos suministrados son fidedignos y estoy en conocimiento que cualquier falta o falsedad, en los mismos involucra sanciones o a la no aceptacion de la solicitud.</th>                            
                    </tr>
                </table>
                <table>
                    <tr>
                        <th>Firma del Solicitante</th>
                        <th>Huella Dactilar</th>
                    </tr>
                    <tr>
                        <td style="padding:2rem;"></td>
                        <td></td>
                    </tr>
                </table>

                <table>
                    <tr>
                        <th>Solo para ser llenado por la Unidad Receptora</th>
                    </tr>
                </table>

                <table>
                    <tr>
                        <th>Prioridad del tramite</th>
                    </tr>
                </table>

                <table>
                    <tr>
                        <td>Alta<input type='checkbox'></td>
                        <td>Media<input type='checkbox'></td>
                        <td>Baja<input type='checkbox'></td>
                    </tr>
                </table>
                <table>
                    <tr>
                        <th>Descripcion de el tramite</th>
                    </tr>
                    <tr>
                        <td style="padding: 2rem"></td>
                    </tr>
                </table>
                <table>
                    <tr>
                        <th>Nombre del Funcionario Receptor</th>
                        <!-- <th>Cedula de Identidad</th> -->
                        <th>Sello y Firma</th>
                    </tr>
                    <tr>
                        <td style="padding: 15px">$nombreUsuario</td>
                        <!-- <td></td> -->
                        <td></td>
                    </tr>
                </table>

                <table style="margin-top: 20px">
                    <tr>
                        <th>Oficina de Atencion Ciudadana <span style="text-align: right">Numero de Registro $idsolicitud</span></th>
                    </tr>
                </table>

                <table>
                    <tr>
                        <th>
                            Planilla de Solicitud:
                        </th>
                    </tr>
                </table>

                    <table>
                        <tr>
                            <th>Denuncia</th>
                            <th>Queja</th>
                            <th>Sugerencia</th>
                            <th>Asesoria</th>
                            <th>Reclamos</th>
                            <th>Peticion</th>
                            <tr>
                            <td><input type="checkbox" $activardenuncia></td>
                            <td><input type="checkbox" $activarqueja></td>
                            <td><input type="checkbox" $activarsugerencia></td>
                            <td><input type="checkbox" $activarasesoria></td>
                            <td><input type="checkbox" $activarreclamos></td>
                            <td><input type="checkbox" $activarpeticiones></td>
                            </tr>
                        </tr>
                    </table>
                </table>
                <table>
                        <tr>
                        <th>Fecha de Solicitud</th>
                        <th>Hora</th>
                        <th>Nombre y Apellido del Ciudadano Solicitante</th>                    
                        <th>Nombre del Funcionario Receptor</th>                    
                    </tr>
                    <tr>
                        <td>$fecha</td>
                        <td>$hora</td>
                        <td>$solicitud->nombre</td>
                        <td>$nombreUsuario</td>
                    </tr>
                </table>
                <table>
                    <tr>
                        <th>Firma del Funcionario Receptor</th>
                        <th>Sello</th>
                    </tr>
                    <tr>
                        <td style="padding: 2rem"></td>
                        <td></td>
                    </tr>
                </table>
                <h5 style="text-align: center">Usted podra solicitar informacion sobre su solicitud en la Oficina de Atencion Ciudadana a traves de los telefonos (0414 1572028) (0412 5526701)</h5>
                <h5 style="text-align: center">Todos los tramites realizados ante esta oficina son absolutamente gratuitos</h5>
                    </body>
                    </html>
            HTML;
        }

        if ($solicitud["tipo_solicitud_id"] === 5) {
            $observacion = $solicitud->asesoria;
            $observacion = json_decode($observacion, true);
            $observacionAsesoria = $observacion[0]["observacion"];
            $activarasesoria = "checked";
            $valor = "Asesoria";

            $htmlsolicitud = <<<HTML
            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <title>Planilla</title>
                <style>
                    body {
                        font-family: sans-serif;
                    }
    
                    table {
                        width: 100%;
                        border-collapse: collapse;
                    }
    
                    th, td {
                        text-align:center;
                        border: 1px solid #ddd;
                    }
    
                    th {
                        font-size: 12px;
                        background-color: #f0f0f0;
                    }
                    td{
                        font-size: 12px;
                    }
                </style>
            </head>
            <body>
            <!-- <img src="/images/icons/unnamed.png" alt="" srcset=""> -->
                <table>
                    <tr>
                        <th>Numero de Registro $idsolicitud</th>
                        <th>Oficina de Atencion Ciudadana</th>
                        <th>Planilla de Solicitud</th>
                        <th>Dia: $dia</th>
                        <th>Mes: $mes</th>
                        <th>Año: $anno</th>
                    </tr>
                </table>
                
                <table>
                    <tr>
                        <th>Denuncia</th>
                        <th>Queja</th>
                        <th>Sugerencia</th>
                        <th>Asesoria</th>
                        <th>Reclamos</th>
                        <th>Peticion</th>
                        <tr>
                        <td><input type="checkbox" $activardenuncia></td>
                        <td><input type="checkbox" $activarqueja></td>
                        <td><input type="checkbox" $activarsugerencia></td>
                        <td><input type="checkbox" $activarasesoria></td>
                        <td><input type="checkbox" $activarreclamos></td>
                        <td><input type="checkbox" $activarpeticiones></td>
                        </tr>
                    </tr>
                </table>
                <table>
                    <tr>
                        <th>Datos del ciudadano(a) Solicitante</th>
                    </tr>
                </table>
                <table class="table table-bordered" border="0">
                    <tr>
                        <th class="text-primary" >Nombre Y Apellido</th>
                        <th>Cedula</th>
                        <th>Telefono</th>
                        <th>Telefono Casa</th>
                        <th>Correo Electronico</th>
                        <th>Sexo</th>
                        <th>Estado Civil</th>
                        <th>Fecha de Nacimiento</th>
                        <th>Nivel Educativo</th>
                        <th>Ocupacion O/U Oficio</th>
                    </tr>
                    <tr>
                        <td>$solicitud->nombre</td>
                        <td>$solicitud->cedula</td>
                        <td>$solicitud->telefono</td>
                        <td>$solicitud->telefono2</td>
                        <td>$solicitud->email</td>
                        <td>$solicitud->sexo</td>
                        <td>$solicitud->edocivil</td>
                        <td>$solicitud->fechaNacimiento</td>
                        <td>$solicitud->nivelestudio</td> 
                        <td>$solicitud->profesion</td> 
                    </tr>
            </table>
    
            <table>
            <tr >
                        <th class="text-primary" >Estado</th>
                        <th>Municipio</th>
                        <th>Parroquia</th>
                        <th>Comuna</th>
                        <th>Comunidad</th>
                        <th>Direccion Habitacion</th>
                        <th>Tipo de Solicitud</th>
                    </tr>
                    <tr>
                        <td>$estado2->estado2</td>
                        <td>$estado2->municipio</td>
                        <td>$estado2->parroquia</td>
                        <td>$estado2->comuna</td>
                        <td>$estado2->comunidad</td>
                        <td>$solicitud->direccion</td>
                        <td>$valor</td>
                    </tr>
                        </table>
                        <table>
                    <tr>
                        <th>Recaudos de la Peticion</th>
                    </tr>
            </table>

                <table>
                    <tr>
                        <!-- <th>Asignacion</th> -->
                        <th>Direccion Asignada</th>
                        <!-- <th>Coordinacion Asignada</th> -->
                    </tr>
                    <tr>
                        <!-- <td>$solicitud->asignacion</td> -->
                        <td>$direccionAsignada</td>
                        <!-- <td></td> -->
                    </tr>
                </table>

                <table>
                    <tr>
                        <th>Sugerencia o Asesoria</th>
                    </tr>
                </table>

                <table>
                    <tr>
                        <th>Observacion</th>
                    </tr>
                    <tr>
                        <td>$observacionAsesoria</td>
                    </tr>
                </table>
                
                    <table>
                        <tr>
                            <th>Documentos que anexa</th>                            
                        </tr>
                        <tr>
                            <td>
                                <div style="display:flex; justify-content: space-between;">                                    
                                    Carta Exposicion de Motivo 
                                    <input type='checkbox' $activarrecaudoMotivo>
                                </div>
                            </td>
                        </tr>
                    </table>
                <table>
                    <tr>
                        <th style="padding:1rem;">Declaro que los datos suministrados son fidedignos y estoy en conocimiento que cualquier falta o falsedad, en los mismos involucra sanciones o a la no aceptacion de la solicitud.</th>                            
                    </tr>
                </table>
                <table>
                    <tr>
                        <th>Firma del Solicitante</th>
                        <th>Huella Dactilar</th>
                    </tr>
                    <tr>
                        <td style="padding:2rem;"></td>
                        <td></td>
                    </tr>
                </table>

                <table>
                    <tr>
                        <th>Solo para ser llenado por la Unidad Receptora</th>
                    </tr>
                </table>

                <table>
                    <tr>
                        <th>Prioridad del tramite</th>
                    </tr>
                </table>

                <table>
                    <tr>
                        <td>Alta<input type='checkbox'></td>
                        <td>Media<input type='checkbox'></td>
                        <td>Baja<input type='checkbox'></td>
                    </tr>
                </table>
                <table>
                    <tr>
                        <th>Descripcion de el tramite</th>
                    </tr>
                    <tr>
                        <td style="padding: 2rem"></td>
                    </tr>
                </table>
                <table>
                    <tr>
                        <th>Nombre del Funcionario Receptor</th>
                        <!-- <th>Cedula de Identidad</th> -->
                        <th>Sello y Firma</th>
                    </tr>
                    <tr>
                        <td style="padding: 15px">$nombreUsuario</td>
                        <!-- <td></td> -->
                        <td></td>
                    </tr>
                </table>

                <table style="margin-top: 20px">
                    <tr>
                        <th>Oficina de Atencion Ciudadana <span style="text-align: right">Numero de Registro $idsolicitud</span></th>
                    </tr>
                </table>

                <table>
                    <tr>
                        <th>
                            Planilla de Solicitud:
                        </th>
                    </tr>
                </table>

                    <table>
                        <tr>
                            <th>Denuncia</th>
                            <th>Queja</th>
                            <th>Sugerencia</th>
                            <th>Asesoria</th>
                            <th>Reclamos</th>
                            <th>Peticion</th>
                            <tr>
                            <td><input type="checkbox" $activardenuncia></td>
                            <td><input type="checkbox" $activarqueja></td>
                            <td><input type="checkbox" $activarsugerencia></td>
                            <td><input type="checkbox" $activarasesoria></td>
                            <td><input type="checkbox" $activarreclamos></td>
                            <td><input type="checkbox" $activarpeticiones></td>
                            </tr>
                        </tr>
                    </table>
                </table>
                <table>
                        <tr>
                            <th>Fecha de Solicitud</th>
                            <th>Hora</th>
                        <th>Nombre y Apellido del Ciudadano Solicitante</th>                    
                        <th>Nombre del Funcionario Receptor</th>                    
                    </tr>
                    <tr>
                        <td>$fecha</td>
                        <td>$hora</td>
                        <td>$solicitud->nombre</td>
                        <td>$nombreUsuario</td>
                    </tr>
                </table>
                <table>
                    <tr>
                        <th>Firma del Funcionario Receptor</th>
                        <th>Sello</th>
                    </tr>
                    <tr>
                        <td style="padding: 2rem"></td>
                        <td></td>
                    </tr>
                </table>
                <h5 style="text-align: center">Usted podra solicitar informacion sobre su solicitud en la Oficina de Atencion Ciudadana a traves de los telefonos (0414 1572028) (0412 5526701)</h5>
                <h5 style="text-align: center">Todos los tramites realizados ante esta oficina son absolutamente gratuitos</h5>
                    </body>
                    </html>
            HTML;
        }

        if ($solicitud["tipo_solicitud_id"] === 6) {
            $beneficiario = $solicitud->beneficiario;
            $beneficiario = json_decode($beneficiario, true);
            $cedulabeneficiario = $beneficiario[0]["cedula"];
            $nombrebeneficiario = $beneficiario[0]["nombre"];
            $direccionbeneficiario = $beneficiario[0]["direccion"];
            $recaudos = $solicitud->recaudos;
            $recaudos = json_decode($recaudos, true);
            $cedularecaudos = $recaudos[0]["cedula"];
            $motivorecaudos = $recaudos[0]["motivo"];
            $informerecaudos = $recaudos[0]["informe"];
            $beneficiariorecaudos = $recaudos[0]["beneficiario"];
            if($cedularecaudos === "on"){
                $activarrecaudoCedula = "checked";
            }
            if($motivorecaudos === "on"){
                $activarrecaudoMotivo = "checked";
            }
            if($informerecaudos === "on"){
                $activarrecaudoInforme = "checked";
            }
            if($beneficiariorecaudos === "on"){
                $activarrecaudoBeneficiario = "checked";
            }
            $activarpeticiones = "checked";
            $valor = "Peticion";
            $htmlsolicitud = <<<HTML
            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <title>Planilla</title>
                <style>
                    body {
                        font-family: sans-serif;
                    }
    
                    table {
                        width: 100%;
                        border-collapse: collapse;
                    }
    
                    th, td {
                        text-align:center;
                        border: 1px solid #ddd;
                    }
    
                    th {
                        font-size: 12px;
                        background-color: #f0f0f0;
                    }
                    td{
                        font-size: 12px;
                    }
                </style>
            </head>
            <body>
            <!-- <img src="/images/icons/unnamed.png" alt="" srcset=""> -->
                <table>
                    <tr>
                        <th>Numero de Registro $idsolicitud</th>
                        <th>Oficina de Atencion Ciudadana</th>
                        <th>Planilla de Solicitud</th>
                        <th>Dia: $dia</th>
                        <th>Mes: $mes</th>
                        <th>Año: $anno</th>
                    </tr>
                </table>
                
                <table>
                    <tr>
                        <th>Denuncia</th>
                        <th>Queja</th>
                        <th>Sugerencia</th>
                        <th>Asesoria</th>
                        <th>Reclamos</th>
                        <th>Peticion</th>
                        <tr>
                        <td><input type="checkbox" $activardenuncia></td>
                        <td><input type="checkbox" $activarqueja></td>
                        <td><input type="checkbox" $activarsugerencia></td>
                        <td><input type="checkbox" $activarasesoria></td>
                        <td><input type="checkbox" $activarreclamos></td>
                        <td><input type="checkbox" $activarpeticiones></td>
                        </tr>
                    </tr>
                </table>
                <table>
                    <tr>
                        <th>Datos del ciudadano(a) Solicitante</th>
                    </tr>
                </table>
                <table class="table table-bordered" border="0">
                    <tr>
                        <th class="text-primary" >Nombre Y Apellido</th>
                        <th>Cedula</th>
                        <th>Telefono</th>
                        <th>Telefono Casa</th>
                        <th>Correo Electronico</th>
                        <th>Sexo</th>
                        <th>Estado Civil</th>
                        <th>Fecha de Nacimiento</th>
                        <th>Nivel Educativo</th>
                        <th>Ocupacion O/U Oficio</th>
                    </tr>
                    <tr>
                        <td>$solicitud->nombre</td>
                        <td>$solicitud->cedula</td>
                        <td>$solicitud->telefono</td>
                        <td>$solicitud->telefono2</td>
                        <td>$solicitud->email</td>
                        <td>$solicitud->sexo</td>
                        <td>$solicitud->edocivil</td>
                        <td>$solicitud->fechaNacimiento</td>
                        <td>$solicitud->nivelestudio</td> 
                        <td>$solicitud->profesion</td> 
                    </tr>
            </table>
    
            <table>
            <tr >
                        <th class="text-primary" >Estado</th>
                        <th>Municipio</th>
                        <th>Parroquia</th>
                        <th>Comuna</th>
                        <th>Comunidad</th>
                        <th>Direccion Habitacion</th>
                        <th>Tipo de Solicitud</th>
                    </tr>
                    <tr>
                        <td>$estado2->estado2</td>
                        <td>$estado2->municipio</td>
                        <td>$estado2->parroquia</td>
                        <td>$estado2->comuna</td>
                        <td>$estado2->comunidad</td>
                        <td>$solicitud->direccion</td>
                        <td>$valor</td>
                    </tr>
                        </table>
                        <table>
                    <tr>
                        <th>Recaudos de la Peticion</th>
                    </tr>
            </table>

                <table>
                    <tr>
                        <!-- <th>Asignacion</th> -->
                        <th>Direccion Asignada</th>
                        <!-- <th>Coordinacion Asignada</th> -->
                    </tr>
                    <tr>
                        <!-- <td>$solicitud->asignacion</td> -->
                        <td>$direccionAsignada</td>
                        <!-- <td></td> -->
                    </tr>
                </table>

                <table>
                    <tr>
                        <th>Datos del Ciudadano Beneficiario(a)/Comunidad</th>
                    </tr>
                </table>

                <table>
                    <tr>
                        <th>Cedula de Identidad</th>
                        <!-- <th>Tipo de Registro</th> -->
                        <th>Apellido y Nombre</th>
                        <th>Direccion de Benificiario</th>
                        <!-- <th>Edad</th>
                        <th>Estado Civil</th>
                        <th>Fecha de nacimiento</th>
                        <th>Nivel Educativo</th>
                        <th>Profesion</th>
                        <th>Parentesco</th> -->
                    </tr>
                    <tr>
                        <td>$cedulabeneficiario</td>
                        <!-- <td></td> -->
                        <td>$nombrebeneficiario</td>
                        <td>$direccionbeneficiario</td>
                        <!-- <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td> -->
                    </tr>
                </table>
                <table>
                    <!-- <tr>
                        <th>Direccion de habitacion</th>
                    </tr>
                    <tr>
                        <td></td>
                    </tr>
                </table>

                <table>
                    <tr>
                        <th>Parroquia</th>
                        <th>Municipio</th>
                        <th>Ciudad</th>
                        <th>Correo Electronico</th>
                        <th>Telefono Habitacion</th>
                        <th>Telefono Celular</th>
                        <th>Telefono Trabajo</th>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr> -->
                </table>
                    <table>
                        <tr><th>
                            Documentos que anexa
                        </th></tr>
                    </table>

                    <table>
                    <tr>
                        <th>Copia de Cedula</th>
                        <th>Carta Exposicion de Motivo</th>
                        <th>Informe Medico</th>
                        <th>Copia de Cedula de Beneficiario</th>
                    </tr>
                    <tr>
                        <td><input type='checkbox' $activarrecaudoCedula></td>
                        <td><input type='checkbox' $activarrecaudoMotivo></td>
                        <td><input type='checkbox' $activarrecaudoInforme></td>
                        <td><input type='checkbox' $activarrecaudoBeneficiario></td>
                    </tr>
                </table>
                <table>
                    <tr>
                        <th style="padding:1rem;">Declaro que los datos suministrados son fidedignos y estoy en conocimiento que cualquier falta o falsedad, en los mismos involucra sanciones o a la no aceptacion de la solicitud.</th>                            
                    </tr>
                </table>
                <table>
                    <tr>
                        <th>Firma del Solicitante</th>
                        <th>Huella Dactilar</th>
                    </tr>
                    <tr>
                        <td style="padding:2rem;"></td>
                        <td></td>
                    </tr>
                </table>

                <table>
                    <tr>
                        <th>Solo para ser llenado por la Unidad Receptora</th>
                    </tr>
                </table>

                <table>
                    <tr>
                        <th>Prioridad del tramite</th>
                    </tr>
                </table>

                <table>
                    <tr>
                        <td>Alta<input type='checkbox'></td>
                        <td>Media<input type='checkbox'></td>
                        <td>Baja<input type='checkbox'></td>
                    </tr>
                </table>
                <table>
                    <tr>
                        <th>Descripcion de el tramite</th>
                    </tr>
                    <tr>
                        <td style="padding: 2rem"></td>
                    </tr>
                </table>
                <table>
                    <tr>
                        <th>Nombre del Funcionario Receptor</th>
                        <!-- <th>Cedula de Identidad</th> -->
                        <th>Sello y Firma</th>
                    </tr>
                    <tr>
                        <td style="padding: 15px">$nombreUsuario</td>
                        <!-- <td></td> -->
                        <td></td>
                    </tr>
                </table>

                <table style="margin-top: 20px">
                    <tr>
                        <th>Oficina de Atencion Ciudadana <span style="text-align: right">Numero de Registro $idsolicitud</span></th>
                    </tr>
                </table>

                <table>
                    <tr>
                        <th>
                            Planilla de Solicitud:
                        </th>
                    </tr>
                </table>

                    <table>
                        <tr>
                            <th>Denuncia</th>
                            <th>Queja</th>
                            <th>Sugerencia</th>
                            <th>Asesoria</th>
                            <th>Reclamos</th>
                            <th>Peticion</th>
                            <tr>
                            <td><input type="checkbox" $activardenuncia></td>
                            <td><input type="checkbox" $activarqueja></td>
                            <td><input type="checkbox" $activarsugerencia></td>
                            <td><input type="checkbox" $activarasesoria></td>
                            <td><input type="checkbox" $activarreclamos></td>
                            <td><input type="checkbox" $activarpeticiones></td>
                            </tr>
                        </tr>
                    </table>
                </table>
                <table>
                        <tr>
                            <th>Fecha de Solicitud</th>
                            <th>Hora</th>
                        <th>Nombre y Apellido del Ciudadano Solicitante</th>                    
                        <th>Nombre del Funcionario Receptor</th>                    
                    </tr>
                    <tr>
                        <td>$fecha</td>
                        <td>$hora</td>
                        <td>$solicitud->nombre</td>
                        <td>$nombreUsuario</td>
                    </tr>
                </table>
                <table>
                    <tr>
                        <th>Firma del Funcionario Receptor</th>
                        <th>Sello</th>
                    </tr>
                    <tr>
                        <td style="padding: 2rem"></td>
                        <td></td>
                    </tr>
                </table>
                <h5 style="text-align: center">Usted podra solicitar informacion sobre su solicitud en la Oficina de Atencion Ciudadana a traves de los telefonos (0414 1572028) (0412 5526701)</h5>
                <h5 style="text-align: center">Todos los tramites realizados ante esta oficina son absolutamente gratuitos</h5>
                    </body>
                    </html>
            HTML;
        }

        $html = $htmlsolicitud;
        $dompdf->loadHtml($html);
        $dompdf->setPaper('legal', 'portrait');
        $dompdf->render();
        $dompdf->stream("Atencion al Ciudadano.pdf", array("Attachment" => 1));
        return redirect()->back();

    }

}