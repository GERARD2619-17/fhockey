<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class jugadores extends Model
{
    use HasFactory;

    protected $table = 'jugadores';

    protected $fillable = [
        'fotografia',
        'nombre',
        'edad',
        'posicion',
        'nacionalidad'
    ];//falta corregir mas el codigo estamos con el controlador jugador y luego veremos las vistas
}
