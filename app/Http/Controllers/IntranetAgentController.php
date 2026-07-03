<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\GeminiService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class IntranetAgentController extends Controller
{
    protected $gemini;

    public function __construct(GeminiService $gemini) { $this->gemini = $gemini; }

    public function preguntar(Request $request)
{
    $pregunta = mb_strtolower($request->input('pregunta', ''));

    // 1. Verificación de BD
    $articulos = DB::table('articulo')->get();
    //asdas
    // ¡DEBUG! Esto es lo más importante.
    // Revisa tu archivo storage/logs/laravel.log después de preguntar
    Log::info('DEBUG: Cantidad de artículos encontrados: ' . $articulos->count());

    if ($articulos->isEmpty()) {
        $contexto = "ADVERTENCIA: La tabla 'articulo' está vacía o no tiene registros.";
    } else {
        $lista = $articulos->map(function($a) {
            // Asegúrate de que estos nombres de columnas coincidan EXACTAMENTE con tu BD
            // Si el objeto $a no tiene 'Modelo', cámbialo por el nombre real de tu columna
            return "Modelo: " . ($a->Modelo ?? 'N/A') . " | Precio: " . ($a->PrecioVenta ?? 'N/A');
        })->implode("\n");
        $contexto = "LISTADO DE ARTÍCULOS:\n" . $lista;
    }

    $respuestaIa = $this->gemini->consultarAsistente($request->pregunta, $contexto);

    return response()->json(['status' => 'success', 'respuesta' => $respuestaIa]);
}
}
