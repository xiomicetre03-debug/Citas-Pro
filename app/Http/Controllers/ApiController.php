<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use App\Models\Especialista;

class ApiController extends Controller
{
    public function especialistas()
    {
        return response()->json([
            'data' => Especialista::orderBy('nombre')->get(),
        ]);
    }

    public function citas()
    {
        return response()->json([
            'data' => Cita::with(['user:id,name,email', 'especialista:id,nombre,especialidad'])->latest('fecha')->get(),
        ]);
    }
}