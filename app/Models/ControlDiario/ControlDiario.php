<?php
/**
* Realizado por @author Tarsicio Carrizales Agosto 2021
* Correo: telecom.com.ve@gmail.com
*/

namespace App\Models\ControlDiario;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Auth;

class ControlDiario extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'control_diario';
    protected $fillable = [
        'Nombre',
        'Cedula',        
        'Sexo',
        'Generacion',
        'Asunto',
        'Respuesta',
        'Organizacion',
        'Fecha',
        'Telefono',
    ];

    public function getControlDiarioList_DataTable(){        
        return DB::table('control_diario')->select('id','Nombre','Cedula','Sexo','Generacion','Asunto','Respuesta','Organizacion','Fecha','Telefono',)->get();
    }

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
}