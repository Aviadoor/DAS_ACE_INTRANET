<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InventarioController;
use App\Http\Controllers\BoletaController;
use App\Http\Controllers\VentaController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PermisoController;
use App\Http\Controllers\PersonalController;
use App\Http\Controllers\RolController;
use App\Http\Controllers\MfaController;

// Ruta raíz (la que faltaba para el 404)
Route::get('/', function () {
    return view('home');
})->name('home');

// Rutas de autenticación (guest)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/login/mfa', [MfaController::class, 'index']) -> name('mfa.index');
    Route::post('/login/mfa', [MfaController::class, 'verify']) -> name('mfa.verify') -> middleware('throttle:5,1');
    Route::post('/login/mfa/reenviar', [MfaController::class, 'resend']) -> name('mfa.resend');
});

// Rutas protegidas por autenticación
Route::middleware('auth')->group(function () {
    // Home (ya tenemos una ruta '/' que apunta a home, pero esta también existe)
    Route::get('home', function () {
        return view('home');
    })->name('home');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Ventas
    Route::resource('venta', VentaController::class)->except(['index', 'show'])
        ->middleware('permission:ventas-create,ventas-edit');
    Route::resource('venta', VentaController::class)->only(['index', 'show'])
        ->middleware('permission:ventas-index');

    // Inventario
    Route::resource('inventario', InventarioController::class)
        ->middleware('permission:inventario-crud');

    // Boletas
    Route::resource('boleta', BoletaController::class)
        ->middleware('permission:boletas-crud');

    // Usuarios
    Route::resource('usuario', UsuarioController::class)
        ->middleware('permission:admin-all');

    // Roles
    Route::resource('rol', RolController::class)
        ->middleware('permission:admin-all');

    // Permisos
    Route::resource('permiso', PermisoController::class)
        ->middleware('permission:admin-all');

    // Personal
    Route::resource('personal', PersonalController::class)
        ->middleware('permission:admin-all');
});
