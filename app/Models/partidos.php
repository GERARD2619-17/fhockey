<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class partidos extends Model
{
    use HasFactory;
      /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $table = 'partidos';

    protected $fillable = [
        'equipo_local_id',
        'logo_equipo_local',
        'equipo_visitante_id',
        'logo_equipo_visitante',
        'fecha_juego',
        'hora_juego',
        'goles_local',
        'goles_visitante',
        'tarjetas_amarillas_local',
        'tarjetas_rojas_local',
        'tarjetas_verdes_local',
        'penales_local',
        'tarjetas_amarillas_visitante',
        'tarjetas_rojas_visitante',
        'tarjetas_verdes_visitante',
        'penales_visitante',
        'estado', 
        'tiempo_seleccionado', 
        'inicio', 
        'descanso_inicio'
    ];

    public function equipo_local()
    {
        return $this->belongsTo(Equipos::class, 'equipo_local_id');
    }

    public function equipo_visitante()
    {
        return $this->belongsTo(Equipos::class, 'equipo_visitante_id');
    }
}
