<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InventarioController;
use App\Http\Controllers\BoletaController;
use App\Http\Controllers\VentaController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\AuthController;


Route::middleware('guest') -> group(function(){
    Route::get('/login', [AuthController::class, 'showLoginForm']) -> name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::middleware('auth')->group(function() {
    Route::get('home', function(){
        return view('home');
    }) -> name('home');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::resource('venta', VentaController::class)->only(['index', 'show'])
        ->middleware('permission:ventas-index');
        
    Route::resource('venta', VentaController::class)->except(['index', 'show'])
        ->middleware('permission:ventas-create,ventas-edit');

    Route::resource('inventario', InventarioController::class)
        ->middleware('permission:inventario-crud');

    Route::resource('boleta', BoletaController::class)
        ->middleware('permission:boletas-crud');

    Route::resource('usuario', UsuarioController::class)->middleware('permission:admin-all');
});