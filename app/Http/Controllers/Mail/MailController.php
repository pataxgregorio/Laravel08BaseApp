<?php

namespace App\Http\Controllers\Mail;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User\User;
use Auth;
use Dompdf\Dompdf;
use App\Http\Controllers\User\Colores;

class MailController extends Controller
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
        return view('Correo.correos',compact('count_notification','array_color'));
    }

    public function getMail(Request $request){
        try{
            if ($request->ajax()) {
               
            }
        }catch(Throwable $e){
            echo "Captured Throwable: " . $e->getMessage(), "\n";
        }
        return true;        
    }

} // Fin de la clase UserController.
