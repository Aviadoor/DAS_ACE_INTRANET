<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use Illuminate\Support\Facades\Auth;
use App\Notifications\SendMfaCode;

class MfaController extends Controller
{
    public function index()
    {
        // Si no existe un ID temporal en la sesión, lo mandamos al login principal
        if (!session()->has('mfa_user_id')) {
            return redirect()->route('login');
        }

        return view('auth.mfa');
    }

    public function verify(Request $request)
    {
        date_default_timezone_set('America/Lima');
        $request->validate([
            'code' => 'required|string|size:6',
        ]);

        if (!session()->has('mfa_user_id')) {
            return redirect()->route('login');
        }

        $user = Usuario::findOrFail(session('mfa_user_id'));

        // Buscar si el código coincide, no ha sido usado y no ha expirado
        $mfaRecord = $user->mfaCodes()
            ->where('codigo', $request->code)
            ->where('codigo_usado', false)
            ->where('expires_at', '>', now())
            ->first();

        if (!$mfaRecord) {
            return back()->withErrors(['code' => 'El código introducido es incorrecto o ya expiró.']);
        }

        // Marcar el código como usado para que nadie lo vuelva a reutilizar
        $mfaRecord->update(['codigo_usado' => true]);

        // Limpiar la sesión temporal
        session()->forget('mfa_user_id');

        // LOGUEAR OFICIALMENTE AL USUARIO EN LARAVEL
        Auth::login($user);

        // Redireccionar a home si no se coloco ruta
        return redirect()->intended('/home');
    }

    public function resend()
    {
        date_default_timezone_set('America/Lima');
        if (!session()->has('mfa_user_id')) {
            return redirect()->route('login');
        }

        $user = Usuario::findOrFail(session('mfa_user_id'));

        // Opcional: Invalidar códigos anteriores no usados para mayor seguridad
        $user->mfaCodes()->where('codigo_usado', false)->update(['codigo_usado' => true]);

        // Generar nuevo código
        $code = sprintf("%06d", mt_rand(0, 999999));

        $user->mfaCodes()->create([
            'codigo' => $code,
            'expires_at' => now()->addMinutes(10),
            'codigo_usado' => false,
        ]);

        $user->notify(new SendMfaCode($code));

        return back()->with('status', 'Se ha enviado un nuevo código a tu correo electrónico.');
    }
}
