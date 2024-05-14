<?php
/**
* Realizado por @author Tarsicio Carrizales Agosto 2021
* Correo: telecom.com.ve@gmail.com
*/
namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User\User;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Http\Controllers\User\Colores;

/**
 * Class HomeController
 * @package App\Http\Controllers
 */
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(){
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return Response
     * Realizado por @author Tarsicio Carrizales
     */
    public function index(){
        $confirmation_code = auth()->user()->confirmation_code;
        $confirmed_at = auth()->user()->confirmed_at;        
        session(['menu_color' => auth()->user()->colores['menu']]);
        session(['encabezado_color' => auth()->user()->colores['encabezado']]);
        session(['group_button_color' => auth()->user()->colores['group_button']]);
        session(['back_button_color' => auth()->user()->colores['back_button']]);
        session(['process_button_color' => auth()->user()->colores['process_button']]);
        session(['create_button_color' => auth()->user()->colores['create_button']]);
        session(['update_button_color' => auth()->user()->colores['update_button']]);
        session(['edit_button_color' => auth()->user()->colores['edit_button']]);
        session(['view_button_color' => auth()->user()->colores['view_button']]);
        if(is_null($confirmation_code) && isset($confirmed_at)){            
            return redirect('/dashboard');
        }else{
            auth()->logout();
            return redirect('/check_your_mail');            
        }
    }

    /**
    * Realizado por @author Tarsicio Carrizales
    */
    public function dashboard(){        
        $confirmation_code = auth()->user()->confirmation_code;
        $confirmed_at = auth()->user()->confirmed_at;         
        $user_deny_allow = auth()->user()->activo;
        $fecha = false;
        if(auth()->user()->end_day == null && auth()->user()->init_day == null){
            $fecha = true;
        }else{            
            $fecha_actual = date('Y-m-d');            
            $fecha_end_day = Carbon::parse(auth()->user()->end_day)->format('Y-m-d');            
            if($fecha_actual <= $fecha_end_day ){
                $fecha = true;
            }
        }
        if($user_deny_allow == 'DENY' || !$fecha){
            auth()->logout();
            alert()->warning(trans('message.mensajes_alert.denegado'),trans('message.mensajes_alert.mensaje'));
            return redirect('/deny');            
        }else if(is_null($confirmation_code) && isset($confirmed_at)){
            $count_notification = (new User)->count_noficaciones_user();
            $user_total_activos = (new User)->userTotalActivo();
            $total_roles = (new User)->totalRoles();
            $user_total_Deny = (new User)->userTotalDeny();
            $array_color = (new Colores)->getColores();      //
            //funcion que retorna todas las solicitudes en estado en registradas
            //funcion que retorna todas las solicitudes en estado en proceso
            //funcion que retorna todas las solicitudes en estado en terminadas
            return view('adminlte::home',compact('count_notification','user_total_activos',
                                                  'total_roles','user_total_Deny','array_color'));
        }else{
            auth()->logout();
            alert()->info(trans('message.mensajes_alert.view_mail'),trans('message.mensajes_alert.view_mail_02'));
            return redirect('/check_your_mail');
        }
    }
}
