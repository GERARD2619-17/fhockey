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
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/profile',[UsuarioController::class,'profile']);

    Route::resource('jugadores', JugadoresController::class);

    Route::resource('equipos', EquiposController::class);

    // Ruta para la actualización de partidos
    Route::post('/partidos/actualizar', [PartidosController::class, 'actualizar'])->name('partidos.actualizar');

    Route::resource('partidos', PartidosController::class);

    // Nueva ruta para el panel de juego
    Route::get('/partidos/{partido}/paneljuego', [PartidosController::class, 'panelJuego'])->name('partidos.paneljuego');

    // Ruta para ver los detalles de un partido
    Route::get('/partidos/{id}', [PartidosController::class, 'show'])->name('partidos.show');

    Route::post('/partidos/{partido}/actualizar-goles', [PartidosController::class, 'actualizarGoles']);
    Route::post('/partidos/{partido}/actualizar-tarjetas', [PartidosController::class, 'actualizarTarjetas']);
    Route::post('/partidos/{partido}/actualizar-estado', [PartidosController::class, 'actualizarEstado']);
    

});
