<?php

use App\Http\Controllers\EquiposController;
use App\Http\Controllers\JugadoresController;
use App\Http\Controllers\PartidosController;
use App\Http\Controllers\UsuarioController;
use Illuminate\Support\Facades\Route;

Route::get('/', function(){
    return view('auth.login');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
     // Dashboard principal
     Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Perfil de usuario
    Route::get('/profile', [UsuarioController::class, 'profile']);

    // Rutas de jugadores (CRUD)
    Route::resource('jugadores', JugadoresController::class);

    // Rutas de equipos (CRUD)
    Route::resource('equipos', EquiposController::class);

   // Rutas para Partidos (CRUD)
   Route::get('partidos/create', [PartidosController::class, 'create'])->name('partidos.create');

    Route::resource('partidos', PartidosController::class);

    Route::get('/paneljuego', [PartidosController::class, 'paneljuego'])->name('paneljuego');
    Route::get('/paneljuego/{id}', [PartidosController::class, 'paneljuego'])->name('paneljuego');

    // Ruta para acceder al panel de juego de un partido específico
    Route::get('partidos', [PartidosController::class, 'index'])->name('partidos.index');
    Route::get('partidos/cardview', [PartidosController::class, 'cardview'])->name('partidos.cardview');
    Route::get('partidos/create', [PartidosController::class, 'create'])->name('partidos.create');
    Route::post('/partidos', [PartidosController::class, 'store'])->name('partidos.store');

    Route::get('partidos/{id}/edit', [PartidosController::class, 'edit'])->name('partidos.edit');
    Route::put('partidos/{id}', [PartidosController::class, 'update'])->name('partidos.update');
    Route::delete('partidos/{id}', [PartidosController::class, 'destroy'])->name('partidos.destroy');
    Route::get('partidos/calendar', [PartidosController::class, 'calendar'])->name('partidos.calendar');
    Route::get('partidos/{id}', [PartidosController::class, 'show'])->name('partidos.show');
    Route::get('partidos/{id}/paneljuego', [PartidosController::class, 'paneljuego'])->name('partidos.paneljuego');
    Route::post('partidos/{id}/actualizar-marcador', [PartidosController::class, 'actualizarMarcador'])->name('partidos.actualizarMarcador');
    Route::post('/partidos/{partido}/actualizar-tiempo-seleccionado', [PartidosController::class, 'actualizarTiempoSeleccionado'])->name('partidos.actualizarTiempoSeleccionado');
    Route::post('/partidos/{partido}/actualizar-tiempo', [PartidosController::class, 'actualizarTiempo'])->name('partidos.actualizarTiempo');
    Route::post('/partidos/{partido}/actualizar-estado', [PartidosController::class, 'actualizarEstado'])->name('partidos.actualizarEstado');
    Route::post('partidos/{id}/actualizar-tarjetas', [PartidosController::class, 'actualizarTarjetas'])->name('partidos.actualizarTarjetas');
    Route::post('partidos/{id}/asignar-penal', [PartidosController::class, 'asignarPenal'])->name('partidos.asignarPenal');

});
