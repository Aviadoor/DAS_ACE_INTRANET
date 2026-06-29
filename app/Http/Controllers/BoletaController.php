<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Boleta;
use App\Models\Personal;
use App\Models\Tipo_Documento;

class BoletaController extends Controller
{
    public function index()
    {
        $boletas = Boleta::all();
        return view('Boleta.index', compact('boletas'));
    }

    public function create()
    {
        $tipos_documentos = Tipo_Documento::all();
        $personas = Personal::all();
        return view('Boleta.create', compact('personas', 'tipos_documentos'));
    }

    public function store(Request $request)
    {
        $datosValidados = $request -> validate([
            'fk_id_personal' => ['required', 'integer'],
            'Fecha_Inicio' => ['required', 'date'],
            'Dias_Laborados' => ['required', 'integer'],
            'Total_Horas' => ['required', 'integer'],
            'Sueldo_Bruto' => ['required', 'numeric'],
            'Prima_Seguro' => ['required', 'numeric'],
            'Sueldo_Neto' => ['required', 'numeric']
        ],[
            'fk_id_personal.required' => 'Campo obligatorio',
            'Fecha_Inicio.required' => 'Campo obligatorio',
            'Dias_Laborados.required' => 'Campo obligatorio',
            'Total_Horas.required' => 'Campo obligatorio',
            'Sueldo_Bruto.required' => 'Campo obligatorio',
            'Prima_Seguro.required' => 'Campo obligatorio',
            'Sueldo_Neto.required' => 'Campo obligatorio'
        ]);

        Boleta::create($datosValidados);

        return redirect(route('boleta.index'));
    }

    public function show(string $id)
    {
        $boleta = Boleta::find($id);
        return view('Boleta.show', compact('boleta'));
    }

    public function edit(string $id)
    {
        $boleta = Boleta::find($id);
        $id_persona = $boleta -> personal -> id; 
        $personas = Personal::all();
        return view('Boleta.edit', compact('boleta', 'personas', 'id_persona'));
    }

    public function update(Request $request, string $id)
    {
        $datosValidados = $request -> validate([
            'fk_id_personal' => ['required', 'integer'],
            'Fecha_Inicio' => ['required', 'date'],
            'Dias_Laborados' => ['required', 'integer'],
            'Total_Horas' => ['required', 'integer'],
            'Sueldo_Bruto' => ['required', 'numeric'],
            'Prima_Seguro' => ['required', 'numeric'],
            'Sueldo_Neto' => ['required', 'numeric']
        ],[
            'Fecha_Inicio.required' => 'Campo obligatorio',
            'Dias_Laborados.required' => 'Campo obligatorio',
            'Total_Horas.required' => 'Campo obligatorio',
            'Sueldo_Bruto.required' => 'Campo obligatorio',
            'Prima_Seguro.required' => 'Campo obligatorio',
            'Sueldo_Neto.required' => 'Campo obligatorio'
        ]);

        Boleta::where('id', $id)
            -> update($datosValidados);

        return redirect(route('boleta.index'));
    }

    public function destroy(string $id)
    {
        Boleta::destroy($id);
        return redirect(route('boleta.index'));
    }
}
