<?php

use App\Http\Controllers\DocenteController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EventoController;
use App\Http\Controllers\PagoController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\DirectivaController;
use App\Http\Controllers\CargoUniversitarioController;
use Illuminate\Support\Facades\Route;

// Rutas públicas
Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

// Rutas protegidas
Route::middleware(['auth'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
    
    // CRUD de Docentes
    Route::resource('docentes', DocenteController::class);
    // CRUD de Eventos
    
Route::resource('eventos', EventoController::class);

// Rutas adicionales para eventos
Route::post('/eventos/{evento}/inscribir', [EventoController::class, 'inscribir'])->name('eventos.inscribir');
Route::post('/eventos/{evento}/asistencia', [EventoController::class, 'marcarAsistencia'])->name('eventos.asistencia');
// CRUD de Pagos
Route::resource('pagos', PagoController::class);

// Rutas adicionales para pagos
Route::post('/pagos/{pago}/verificar', [PagoController::class, 'verificar'])->name('pagos.verificar');
Route::get('/pagos/reporte/general', [PagoController::class, 'reporteGeneral'])->name('pagos.reporte-general');
Route::get('/pagos/reporte/docente/{docente}', [PagoController::class, 'reporteDocente'])->name('pagos.reporte-docente');
// CRUD de Directiva
Route::resource('directiva', DirectivaController::class);
Route::post('/directiva/{directiva}/finalizar', [DirectivaController::class, 'finalizar'])->name('directiva.finalizar');
// CRUD de Usuarios
Route::resource('usuarios', UsuarioController::class);

// Rutas adicionales para usuarios
Route::post('/usuarios/{usuario}/activar', [UsuarioController::class, 'activar'])->name('usuarios.activar');
Route::post('/usuarios/{usuario}/desactivar', [UsuarioController::class, 'desactivar'])->name('usuarios.desactivar');
// CRUD de Cargos Universitarios
Route::resource('cargos-universitarios', CargoUniversitarioController::class);
Route::post('/cargos-universitarios/{cargoUniversitario}/activar', [CargoUniversitarioController::class, 'activar'])->name('cargos-universitarios.activar');
Route::post('/cargos-universitarios/{cargoUniversitario}/desactivar', [CargoUniversitarioController::class, 'desactivar'])->name('cargos-universitarios.desactivar');
});

