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
        'fecha_nacimiento',
        'edad',
        'posicion',
        'nacionalidad',
        'equipo_id'
    ];//falta corregir mas el codigo estamos con el controlador jugador y luego veremos las vistas

     //Relación con Equipo
     public function equipo()
     {
         return $this->belongsTo(equipos::class, 'equipo_id');
     }
}
