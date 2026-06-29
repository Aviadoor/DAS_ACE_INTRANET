<?php

namespace App\Http\Controllers;

use App\Models\Permiso;
use Illuminate\Http\Request;

class PermisoController extends Controller
{
    // 1. INDEX: Listar permisos
    public function index()
    {
        $permisos = Permiso::all();
        return view('Permiso.index', compact('permisos'));
    }

    // 2. CREATE: Mostrar formulario de creación
    public function create()
    {
        return view('Permiso.create');
    }

    // 3. STORE: Guardar en base de datos
    public function store(Request $request)
    {
        $request->validate([
            'Nombre'      => 'required|string|max:100',
            'Slug'        => 'required|string|max:100|unique:Permisos,Slug',
            'Descripcion' => 'nullable|string|max:255',
            'Habilitado'  => 'nullable|boolean' // Si el checkbox no se marca, no viaja en el request
        ]);

        $permiso = new Permiso();
        $permiso->Nombre = $request->input('Nombre');
        $permiso->Slug = $request->input('Slug');
        $permiso->Descripcion = $request->input('Descripcion');
        $permiso->Habilitado = $request->has('Habilitado') ? 1 : 0;
        $permiso->save();

        return redirect()->route('permiso.index')
            ->with('success', 'Permiso creado exitosamente.');
    }

    // 4. SHOW: Ver detalle de un permiso
    public function show($id)
    {
        $permiso = Permiso::findOrFail($id);
        return view('Permiso.show', compact('permiso'));
    }

    // 5. EDIT: Mostrar formulario de edición
    public function edit($id)
    {
        $permiso = Permiso::findOrFail($id);
        return view('Permiso.edit', compact('permiso'));
    }

    // 6. UPDATE: Actualizar en base de datos
    public function update(Request $request, $id)
    {
        $permiso = Permiso::findOrFail($id);

        $request->validate([
            'Nombre'      => 'required|string|max:100',
            'Slug'        => 'required|string|max:100|unique:Permisos,Slug,' . $permiso->id,
            'Descripcion' => 'nullable|string|max:255',
        ]);

        $permiso->Nombre = $request->input('Nombre');
        $permiso->Slug = $request->input('Slug');
        $permiso->Descripcion = $request->input('Descripcion');
        $permiso->Habilitado = $request->has('Habilitado') ? 1 : 0;
        $permiso->save();

        return redirect()->route('permiso.index')
            ->with('success', 'Permiso actualizado correctamente.');
    }

    // 7. DESTROY: Eliminar permiso (o puedes optar por solo cambiar el Habilitado)
    public function destroy($id)
    {
        $permiso = Permiso::findOrFail($id);
        
        // Opcional: Si quieres desvincularlo de los roles antes de borrar
        // $permiso->roles()->detach(); 

        $permiso->delete();

        return redirect()->route('Permiso.index')
            ->with('success', 'Permiso eliminado del sistema.');
    }
}
