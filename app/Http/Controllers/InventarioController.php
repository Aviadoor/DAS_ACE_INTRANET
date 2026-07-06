<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Articulo;
use App\Models\Unidad;

class InventarioController extends Controller
{
    public function index()
    {
        $articulos = Articulo::select('*') -> get();

        return view('Inventario.index', compact('articulos'));
    }

    public function create()
    {
        $unidades = Unidad::all();
        return view('Inventario.create', compact('unidades'));
    }

    public function store(Request $request)
    {
        $datosValidados = $request -> validate([
            'Modelo' => ['required'],
            'Costo' => ['required'],
            'PrecioVenta' => ['required'],
            'Stock' => ['required', 'integer', 'min:0', 'max:100'],
            'fk_id_unidad' => ['required']
        ],[
            'Modelo.required' => 'Campo obligatorio',
            'Costo.required' => 'Campo obligatorio',
            'PrecioVenta.required' => 'Campo obligatorio',
            'Stock.required' => 'Campo obligatorio',
            'Stock.min' => 'El stock debe ser mayor o igual a cero',
            'Stock.max' => 'El stock no puede superar a 100',
            'fk_id_unidad.required' => 'Campo obligatorio'
        ]);
        
        Articulo::create($datosValidados);

        return redirect(route('inventario.index'));
    }

    public function show(string $id)
    {
        $articulo = Articulo::find($id);
        return view('Inventario.show', compact('articulo'));
    }

    public function edit(string $id)
    {
        $articulo = Articulo::find($id);
        $unidades = Unidad::all();
        return view('Inventario.edit', compact('articulo', 'unidades'));
    }

    public function update(Request $request, string $id)
    {
        $datosValidados = $request -> validate([
            'Modelo' => ['required'],
            'Costo' => ['required'],
            'PrecioVenta' => ['required'],
            'Stock' => ['required', 'integer', 'min:0', 'max:100'],
            'fk_id_unidad' => ['required'],
            'Descripcion' => ['string'],
            'Peso' => ['numeric'],
            'Largo' => ['numeric'],
            'Ancho' => ['numeric'],
            'Alto' => ['numeric']

        ],[
            'Modelo.required' => 'Campo obligatorio',
            'Costo.required' => 'Campo obligatorio',
            'PrecioVenta.required' => 'Campo obligatorio',
            'Stock.required' => 'Campo obligatorio',
            'Stock.min' => 'El stock debe ser mayor o igual a cero',
            'Stock.max' => 'El stock no puede superar a 100',
            'fk_id_unidad.required' => 'Campo obligatorio',
        ]);
        
        Articulo::where('id', $id)
            -> update($datosValidados);
        return redirect(route('inventario.index'));
    }

    public function destroy(string $id)
    {
        Articulo::destroy($id);
        return redirect(route('inventario.index'));
    }
}
