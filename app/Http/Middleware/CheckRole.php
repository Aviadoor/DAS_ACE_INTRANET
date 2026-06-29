<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // 1. Verificar si el usuario está autenticado
        if (!Auth::check()) {
            return redirect('/login');
        }

        $user = Auth::user();

        // 2. Verificar si el usuario tiene al menos uno de los roles solicitados
        foreach ($roles as $role) {
            if ($user->hasRole($role)) {
                return $next($request); // Déjalo pasar
            }
        }

        // 3. Si no tiene el rol, lanzar un error 403 (Prohibido)
        abort(403, 'No tienes autorización para realizar esta acción.');
    }
}
