<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Personal;
use App\Models\Tipo_Documento;

class PersonalController extends Controller
{
    public function index()
    {
        $personal = Personal::all();
        return view('personal.index', compact('personal'));
    }

    public function create()
    {
        $tiposDocumentos = Tipo_Documento::all(); 
        
        return view('personal.create', compact('tiposDocumentos'));
    }

    public function store(Request $request)
    {
        $request -> validate([
            'Nombre_1' => ['required', 'max:100'],
            'Nombre_2' => ['max:100'],
            'Apellido_1' => ['required', 'max:100'],
            'Apellido_2' => ['max:100'],
            'Telefono' => ['required', 'string', 'max:15'],
            'fk_id_tipo_documento' => ['required'],
            'Codigo_Documento' => ['required', 'max:15']
        ],[
            'Nombre_1.required' => 'Nombre 1 obligatorio',
            'Apellido_1.required' => 'Apellido 1 obligatorio',
            'Telefono.required' => 'Telefono obligatorio',
            'Codigo_Documento.required' => 'Numero de Documento obligatorio',
            'fk_id_tipo_documento.required' => 'Seleccionar tipo de documento'
        ]);
        $personal = Personal::create([
            'Nombre_1' => $request -> Nombre_1,
            'Nombre_2' => $request -> Nombre_2,
            'Apellido_1' => $request -> Apellido_1,
            'Apellido_2' => $request -> Apellido_2,
            'telefono' => $request -> Telefono,
            'Codigo_Documento' => $request -> Codigo_Documento,
            'fk_id_tipo_documento' => $request -> fk_id_tipo_documento
        ]);
    
        return response()->json($personal);
    }
    public function show($id)
    {
        $personal = Personal::findOrFail($id);
        return view('personal.show', compact('personal'));
    }

    public function edit($id)
    {
        $personal = Personal::findOrFail($id);
        $tiposDocumentos = Tipo_Documento::all(); 
        
        return view('personal.edit', compact('personal', 'tiposDocumentos'));
    }

    public function update(Request $request, string $id)
    {
        $request -> validate([
            'Nombre_1' => ['required', 'max:100'],
            'Nombre_2' => ['max:100'],
            'Apellido_1' => ['required', 'max:100'],
            'Apellido_2' => ['max:100'],
            'Telefono' => ['required', 'string', 'max:15'],
            'fk_id_tipo_documento' => ['required'],
            'Codigo_Documento' => ['required', 'max:15']
        ],[
            'Nombre_1.required' => 'Nombre 1 obligatorio',
            'Apellido_1.required' => 'Apellido 1 obligatorio',
            'Telefono.required' => 'Telefono obligatorio',
            'Codigo_Documento.required' => 'Numero de Documento obligatorio',
            'fk_id_tipo_documento.required' => 'Seleccionar tipo de documento'
        ]);

        $nombre_completo = explode(' ', $request->NombreCompleto);
        
        $personal = Personal::findOrFail($id);

        $personal->update([
            'Nombre_1'             => $request -> Nombre_1,
            'Nombre_2'             => $request -> Nombre_2 ?? ' ',
            'Apellido_1'           => $request -> Apellido_1,
            'Apellido_2'           => $request -> Apellido_2 ?? ' ',
            'telefono'             => $request -> Telefono,
            'Codigo_Documento'     => $request -> Codigo_Documento,
            'fk_id_tipo_documento' => $request -> fk_id_tipo_documento
        ]);
        
        return redirect()->route('personal.index')
            ->with('success', 'Datos del trabajador actualizados correctamente.');
    }

    public function destroy($id)
    {
        $personal = Personal::findOrFail($id);
        $personal->delete();

        return redirect()->route('personal.index')
            ->with('success', 'Trabajador eliminado del sistema.');
    }
}
