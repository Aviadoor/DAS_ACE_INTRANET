<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Personal;

class PersonalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request -> validate([
            'NombreCompleto' => ['required', 'string', 'max:255'],
            'Telefono' => ['required', 'string', 'max:15'],
            'fk_id_tipo_documento' => ['required'],
            'Codigo_Documento' => ['required', 'max:15']
        ]);
        $nombre_completo = explode(' ', $request -> NombreCompleto);
        $personal = Personal::create([
            'Nombre_1' => $nombre_completo[0],
            'Nombre_2' => $nombre_completo[1] ?? ' ',
            'Apellido_1' => $nombre_completo[2] ?? ' ',
            'Apellido_2' => $nombre_completo[3] ?? ' ',
            'telefono' => $request -> Telefono,
            'Codigo_Documento' => $request -> Codigo_Documento,
            'fk_id_tipo_documento' => $request -> fk_id_tipo_documento
        ]);
    
        // Devuelve el objeto recién creado para que el JS lo use
        return response()->json($personal);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
