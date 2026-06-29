<?php

namespace App\Http\Controllers;

use App\Models\Permiso;
use Illuminate\Http\Request;
use App\Models\Rol;

class RolController extends Controller
{
    public function index()
    {
        $roles = Rol::all();
        return view('Rol.index', compact('roles'));
    }

    public function create()
    {
        $permisos = Permiso::all();
        return view('Rol.create', compact('permisos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'Rol'         => 'required|string|max:100|unique:Roles,Rol',
            'Descripcion' => 'nullable|string|max:255',
            'permisos'    => 'required|array',
            'permisos.*'  => 'exists:Permisos,id',
        ], [
            'Rol.required'      => 'El nombre del rol es obligatorio.',
            'Rol.unique'        => 'Este rol ya se encuentra registrado.',
            'permisos.required' => 'Debes seleccionar al menos un permiso para este rol.',
        ]);

        // 2. Crear el registro en la tabla de Roles (respetando mayúsculas)
        $rol = new Rol();
        $rol->Rol = $request->input('Rol');
        $rol->Descripcion = $request->input('Descripcion');
        $rol->save();

        $rol->permisos()->sync($request->input('permisos'));

        return redirect()->route('rol.index')
            ->with('success', 'El rol "' . $rol->Rol . '" ha sido creado exitosamente con sus permisos.');
    }

    public function show(string $id)
    {
        $rol = Rol::find($id);
        return view('Rol.show', compact('rol'));
    }

    public function edit(string $id)
    {
        $rol = Rol::findOrFail($id);
        $permisos = Permiso::all();
        
        $permisosAsignados = $rol->permisos->pluck('id')->toArray();

        return view('Rol.edit', compact('rol', 'permisos', 'permisosAsignados'));
    }

    public function update(Request $request, $id)
    {
        $rol = Rol::findOrFail($id);

        $request->validate([
            'Rol'         => 'required|string|max:100|unique:Roles,Rol,' . $rol->id,
            'Descripcion' => 'nullable|string|max:255',
            'permisos'    => 'required|array',
            'permisos.*'  => 'exists:Permisos,id', 
        ], [
            'Rol.required'      => 'El nombre del rol es obligatorio.',
            'Rol.unique'        => 'Este rol ya se encuentra registrado.',
            'permisos.required' => 'Debes mantener al menos un permiso para este rol.',
        ]);

        $rol->Rol = $request->input('Rol');
        $rol->Descripcion = $request->input('Descripcion');
        $rol->save();

        $rol->permisos()->sync($request->input('permisos'));

        return redirect()->route('rol.index')
            ->with('success', 'El rol "' . $rol->Rol . '" ha sido actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Rol::destroy($id);
        return redirect()->route('rol.index')
            ->with('success', 'El rol ha sido eliminado.');
    }
}
