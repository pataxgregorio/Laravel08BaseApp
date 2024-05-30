<?php

namespace App\Http\Controllers\Lenguaje;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LenguajeController extends Controller
{
    public function cambioLenguaje($lang)
    {
        // Almacenar el lenguaje en la session
        session()->put('locale', $lang);
        return redirect()->back();
    }
}
