<?php

namespace App\Http\Controllers\Subtiposolicitud;

use App\Http\Models\Subtiposolicitud\Subtiposolicitud;
use Illuminate\Http\Request;

class SubtiposolicitudController extends Controller
{
    public function getSubtiposolicitud(Request $request)
    {
        $subtiposolicitud = (new Subtiposolicitud)->getSubtiposolicitud();
        
        return $subtiposolicitud;
    }
}
