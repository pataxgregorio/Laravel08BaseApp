<?php

namespace App\Http\Controllers\JefeComunidad;

use App\Http\Controllers\Controller;
use App\Models\JefeComunidad\JefeComunidad;
use Illuminate\Http\Request;

class JefeComunidadController extends Controller
{
    public function getJefeComunidad(Request $request)
    {
        $jefeComunidad = (new JefeComunidad)->getJefe($request->comuna_id);
        return $jefeComunidad;
    }
    public function getJefeComunidad2(Request $request)
    {
        $jefeComunidad = (new JefeComunidad)->getJefe2($request->jefecomunidadID);
        return $jefeComunidad;
    }
}
