<?php
/**
* Realizado por @author Tarsicio Carrizales Agosto 2021
* Correo: telecom.com.ve@gmail.com
*/

namespace App\Models\Solicitud;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Auth;

class Solicitud extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
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
        'comuna_id',
        'codigo_control',
        'Nombre',
        'Cedula',
        'Sexo',
        'email',
        'Fecha',
        'Telefono',
        'organismo',
        'edocivil',
        'fechaNacimiento',
        'profesion',
        'recaudos',
        'beneficiario',
        'quejas',
        'reclamo',
        'sugerecia',
        'asesoria',
        'denuncia',
        'denunciado',
        'status'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',        
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'colores' => 'array',
    ];

    /**
    * Realizado por @author Tarsicio Carrizales 
    * Correo: telecom.com.ve@gmail.com
    */    
    public function rol(){
        return $this->belongsTo('App\Models\Security\Rol');
    }

    /**
    * Realizado por @author Tarsicio Carrizales 
    * Correo: telecom.com.ve@gmail.com
    */
    public function count_noficaciones_user(){
        $user_id = auth()->user()->id;
        $sql_count_notifications = DB::table('notifications')
                                        ->where('notifiable_id', $user_id)
                                        ->where('read_at', null)->count();        
        return $sql_count_notifications;
    }

    /**
    * Realizado por @author Tarsicio Carrizales 
    * Correo: telecom.com.ve@gmail.com
    */
    public function getUsersList_DataTable(){
        $rols_id = auth()->user()->rols_id;
        $user_id = auth()->user()->id;
        if($rols_id == 1){
            return DB::table('users')
                    ->join('rols', 'users.rols_id', '=', 'rols.id')
                    ->select('users.id','users.name','rols.name AS rol','users.avatar',
                        'users.email','users.activo','users.confirmed_at')->get();
        }else{
            return DB::table('users')
                    ->join('rols', 'users.rols_id', '=', 'rols.id')
                    ->select('users.id','users.name','rols.name AS rol','users.avatar',
                        'users.email','users.activo','users.confirmed_at')
                    ->where('users.id',$user_id)->get();
        }
    }

    /**
    * Realizado por @author Tarsicio Carrizales 
    * Correo: telecom.com.ve@gmail.com
    */
    public function count_User_Rol(){        
        return DB::table('users')
            ->join('rols', 'users.rols_id', '=', 'rols.id')
            ->select('users.rols_id AS ID_ROLS',
                    'rols.name AS NAME_ROLS',DB::raw('COUNT(users.rols_id) AS TOTAL_USERS'))
            ->groupBy('users.rols_id')
            ->orderByDesc('TOTAL_USERS')->limit(10)->get();
    }

    /**
    * Realizado por @author Tarsicio Carrizales 
    * Correo: telecom.com.ve@gmail.com
    */
    public function count_User_notifications(){        
        return DB::table('users')
            ->join('notifications', 'users.id', '=', 'notifications.notifiable_id')
            ->select('users.name AS USER_NAME',
                DB::raw('COUNT(notifications.notifiable_id) AS TOTAL_NOTIFICATIONS'))
            ->where('users.activo','ALLOW')                    
            ->groupBy('notifications.notifiable_id')
            ->orderByDesc('TOTAL_NOTIFICATIONS')->limit(10)->get();
    }

    /**
    * Realizado por @author Tarsicio Carrizales 
    * Correo: telecom.com.ve@gmail.com
    */
    public function userTotalActivo(){
        $countActivos = DB::table('users')            
                            ->select(DB::raw('COUNT(users.activo) AS TOTAL_ALLOW'))
                            ->where('users.activo','ALLOW')                    
                            ->groupBy('users.activo')->get();
            if(!$countActivos->isEmpty()){
                foreach($countActivos as $countActivo){
                   $total = $countActivo->TOTAL_ALLOW;
                }
            }else{
                $total = 0;
                return $total;
            }
        return $total;
    }
    

    /**
    * Realizado por @author Tarsicio Carrizales 
    * Correo: telecom.com.ve@gmail.com
    */
    public function totalRoles(){
        $totalRoles = DB::table('rols')            
                            ->select(DB::raw('COUNT(rols.id) AS TOTAL_ALLOW'))->get();
            if(!$totalRoles->isEmpty()){
                foreach($totalRoles as $totalRole){
                   $total = $totalRole->TOTAL_ALLOW;
                }
            }else{
                $total = 0;
                return $total;
            }
        return $total;
    }

    /**
    * Realizado por @author Tarsicio Carrizales 
    * Correo: telecom.com.ve@gmail.com
    */
    public function userTotalDeny(){
        $countActivos = DB::table('users')            
                            ->select(DB::raw('COUNT(users.activo) AS TOTAL_DENY'))
                            ->where('users.activo','DENY')                    
                            ->groupBy('users.activo')->get();
            if(!$countActivos->isEmpty()){
                foreach($countActivos as $countActivo){
                   $total = $countActivo->TOTAL_DENY;
                }
            }else{
                $total = 0;
                return $total;
            }
        return $total;
    }   

    /**
    * Realizado por @author Tarsicio Carrizales 
    * Correo: telecom.com.ve@gmail.com
    */
    public function getNotificationsList_DataTable(){
        $user = Auth::user();
        return DB::table('notifications')        
                    ->where('notifiable_id',$user->id)
                    ->where('read_at',null)                    
                    ->select('id',DB::raw('CONCAT(JSON_UNQUOTE(JSON_EXTRACT(notifications.data, "$.title")), ", ",JSON_UNQUOTE(JSON_EXTRACT(notifications.data, "$.body"))) AS data'),'read_at','created_at')
                    ->orderByDesc('created_at')->get();
    } 

    /**
    * Realizado por @author Tarsicio Carrizales 
    * Correo: telecom.com.ve@gmail.com
    * El usuario esta marcando como leida la Notificación.
    */
    public function setRead_at($id){
        return  DB::table('notifications')
                    ->where('id',$id)                        
                    ->update(['read_at' => NOW()]);
    }    

    public function ver_User($id){
        return DB::table('users')
            ->join('rols', 'users.rols_id', '=', 'rols.id')
            ->select('users.id AS ID','users.name AS NAME','users.email AS MAIL','users.avatar AS AVATAR','users.activo AS ACTIVO','rols.name AS ROLS_NAME','users.init_day AS FECHA_INICIO','users.end_day AS FECHA_FIN')
            ->where('users.id',$id)->get();
    }
}