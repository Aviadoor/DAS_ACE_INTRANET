<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    public function preguntar(Request $request)
    {
        return response()->json([
            'status' => 'success',
            'respuesta' => 'Hola desde TestController. Pregunta: ' . $request->input('pregunta')
        ]);
    }
}
