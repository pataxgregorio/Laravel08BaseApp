<?php
/**
* Realizado por @author Tarsicio Carrizales Agosto 2021
* Correo: telecom.com.ve@gmail.com
*/
namespace App\Http\Controllers\Notification;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User\User;
use App\Models\Security\Modulo;
use App\Models\Security\Rol;
use App\Models\Security\Permiso;
use Auth;
use App\Notifications\NotificarEventos;
use App\Http\Controllers\User\Colores;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     * @author Tarsicio Carrizales telecom.com.ve@gmail.com
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $count_notification = (new User)->count_noficaciones_user();
        $array_color = (new Colores)->getColores();
        return view('Notificacion.notificaciones',compact('count_notification','array_color'));
    }

    public function getNotifications(Request $request){        
        try{
            if ($request->ajax()) {                
                $data =  (new User)->getNotificationsList_DataTable();            
                return datatables()->of($data)
                ->editColumn('data', function($data){
                    return $data->data;
                })
                ->editColumn('read_at', function($data){
                    return '<a href="'.route('notificaciones.setNotifications', $data->id).'" id="read_'.$data->id.'" class="btn btn-xs btn-success" style="color:black;"><b><i class="fa fa-pencil"></i>&nbsp;' .trans('message.botones.read').'</b></a>';
                })
                ->editColumn('created_at', function($data){
                    if($data->created_at == null){
                        return  $data->created_at = 'DATE NULL';
                    }else{
                        return date('d-m-Y', strtotime($data->created_at));
                    }                
                })->rawColumns(['data','read_at'])->toJson();        
            }
        }catch(Throwable $e){
            echo "Captured Throwable: " . $e->getMessage(), "\n";
        }        
    }

    /**
    * Realizado por @author Tarsicio Carrizales Agosto 2021
    * Correo: telecom.com.ve@gmail.com
    */
    public function setNotifications($id){                
        $set_read_at = (new User)->setRead_at($id);
        toast(trans('message.mensajes_alert.notification_read'),'success')->timerProgressBar();
        return redirect()->back();
    }
    
}
