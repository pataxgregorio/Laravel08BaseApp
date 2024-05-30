<?php
/**
* Realizado por @author Tarsicio Carrizales Agosto 2021
* Correo: telecom.com.ve@gmail.com
*/
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Security\Permiso;
use Carbon\Carbon;

class RolPermisoIsAllow
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     *  Realizado por @author Tarsicio Carrizales Agosto 2021
     * Correo: telecom.com.ve@gmail.com
     */
    public function handle(Request $request, Closure $next, $modulo = null, $accion = null)
    {
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
        $user_deny_allow = auth()->user()->activo;
        $allow = (new Permiso)->userAccess($modulo,$accion,$request->user()->rols_id);        
        if (!is_null($request->user()->rols_id) && 
            $allow == 'ALLOW' && $fecha && $user_deny_allow == 'ALLOW') {            
            return $next($request);    
        }        
        alert()->warning(trans('message.mensajes_alert.denegado'),trans('message.mensajes_alert.mensaje'));
        return redirect('/dashboard');
    }
}
