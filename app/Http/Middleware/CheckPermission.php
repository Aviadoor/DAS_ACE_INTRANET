<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckPermission
{
    public function handle(Request $request, Closure $next, ...$permissions)
    {
        if (!Auth::check()) {
            return redirect('/login');
        }

        $user = Auth::user();

        if (!$user -> Habilitado){
            Auth::logout();
            return redirect('/login') -> with('error_permiso', 'Tu cuenta esta deshabilitada.');
        }

        // Verificar si el usuario cuenta con al menos uno de los permisos requeridos
        foreach ($permissions as $permission) {
            if ($user->hasPermission($permission)) {
                return $next($request);
            }
        }

        return redirect()->route('home')
            ->with('error_permiso', 'No tienes los permisos necesarios para acceder a esta sección.');
    }
}
