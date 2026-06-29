<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use App\Models\Personal;
use App\Models\Rol;
use App\Models\Usuario_Rol;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    public function index()
    {
        $usuarios = Usuario::all();
        return view('Usuario.index', compact('usuarios'));
    }

    public function create()
    {
        $roles = Rol::all();
        $personas = Personal::all();
        return view('Usuario.create', compact('personas', 'roles'));
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try{
            $datosValidados = $request -> validate([
                'fk_id_personal' => ['required'],
                'Email' => ['required', 'email'],
                'Username' => ['required'],
                'Password' => ['required', 'confirmed'],
                'roles.*' => ['exists:Roles,id']
            ],[
                'Email.required' => 'Campo obligatorio',
                'Email.email' => 'Debe ser un email valido',

                'Username.required' => 'Campo obligatorio',
                
                'Password.required' => 'Campo obligatorio',
                'Password.confirmed' => 'Password no coincide'
            ]);

            $passwordHash = Hash::make($datosValidados['Password']);
    
            $usuario = Usuario::create([
                'fk_id_personal' => $datosValidados['fk_id_personal'],
                'Email' => $datosValidados['Email'],
                'Username' => $datosValidados['Username'],
                'Password' => $passwordHash,
                'Habilitado' => $request -> Habilitado ? 1 : 0
            ]);
    
            $roles_seleccionados = $request->input('roles') ?? [];
            foreach($roles_seleccionados as $id_rol){
                Usuario_Rol::create([
                    'fk_id_usuario' => $usuario->id,
                    'fk_id_rol' => $id_rol,
                ]);
            }

            DB::commit();
    
            return redirect(route('usuario.index'));
        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            throw $e; 

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Ocurrió un error inesperado: ' . $e->getMessage()]);
        }
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        $usuario = Usuario::find($id);
        $roles_asignados = $usuario->roles;
        $roles = Rol::all();
        return view('Usuario.edit', compact('usuario', 'roles_asignados', 'roles'));
    }

    public function update(Request $request, string $id)
    {
        DB::beginTransaction();
        try{
            $datosValidados = $request -> validate([
                'Username' => ['required'],
                'roles.*' => ['exists:Roles,id']
            ],[
                'Username.required' => 'Campo obligatorio'
            ]);

            $usuario = Usuario::find($id);

            $usuario -> update([
                'Username' => $datosValidados['Username'],
                'Habilitado' => $request -> Habilitado ? 1 : 0
                ]);

            if($request -> check_cambiar_password != null){
                $datosValidados = $request -> validate([
                    'Cambiar_Password' => ['required', 'confirmed'],
                ],[
                    'Cambiar_Password.confirmed' => ['Password no coincide']
                ]);
                $passwordHash = Hash::make($request -> Cambiar_Password);
                $usuario -> update([
                    'Password' => $passwordHash
                ]);
            }

    
            $roles_seleccionados = $request->input('roles') ?? [];
            Usuario_Rol::where('fk_id_usuario', $id) -> delete();
            foreach($roles_seleccionados as $id_rol){
                Usuario_Rol::Create([
                    'fk_id_usuario' => $id,
                    'fk_id_rol' => $id_rol,
                ],
                [
                    'fk_id_usuario' => $id,
                    'fk_id_rol' => $id_rol,
                ]);
            }

            DB::commit();
    
            return redirect(route('usuario.index'));
        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            throw $e; 

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Ocurrió un error inesperado: ' . $e->getMessage()]);
        }
    }

    public function destroy(string $id)
    {
        Usuario::destroy($id);

        return redirect(route('usuario.index'));
    }
}
