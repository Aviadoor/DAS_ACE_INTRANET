<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Usuario;
use App\Notifications\SendMfaCode;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('login'); 
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Esto verifica si las credenciales son correctas SIN iniciar sesión.
        if (Auth::validate(['Email' => $credentials['email'], 'password' => $credentials['password']])) {
            
            // Buscamos al usuario en la base de datos
            $user = Usuario::where('Email', $credentials['email'])->first();

            // Generamos el código de 6 dígitos
            $code = sprintf("%06d", mt_rand(0, 999999));

            // Guardamos el código en la nueva tabla usando la relación
            $user->mfaCodes()->create([
                'codigo' => $code,
                'expires_at' => now()->addMinutes(10),
                'codigo_usado' => false,
            ]);

            // Enviamos el correo electrónico con la notificación
            $user->notify(new SendMfaCode($code));

            // Guardamos el ID del usuario en una sesión temporal
            session(['mfa_user_id' => $user->id]);

            // Redirigimos a la pantalla para ingresar el código
            return redirect()->route('mfa.index');
        }

        // Si el correo o la contraseña son incorrectos, regresa con el error
        return back()->withErrors([
            'email' => 'Las credenciales proporcionadas no coinciden con nuestros registros.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
