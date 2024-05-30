<?php
/**
* Realizado por @author Tarsicio Carrizales Agosto 2021
* Correo: telecom.com.ve@gmail.com
*/
namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Colores
{
    public function getColores(){
        return $array_color = [
                    'menu_color'           => session('menu_color'),
                    'encabezado_color'     => session('encabezado_color'),
                    'group_button_color'   => session('group_button_color'),
                    'back_button_color'    => session('back_button_color'),
                    'process_button_color' => session('process_button_color'),
                    'create_button_color'  => session('create_button_color'),
                    'update_button_color'  => session('update_button_color'),
                    'edit_button_color'    => session('edit_button_color'),
                    'view_button_color'    => session('view_button_color')
                ];
    }
}                            