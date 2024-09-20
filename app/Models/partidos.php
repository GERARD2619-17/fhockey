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
    // La tabla asociada con el modelo
    protected $table = 'partidos';

    // Los atributos que son asignables en masa.
    protected $fillable = [
        'equipo_local_id',
        'equipo_visitante_id',
        'fecha_juego',
        'hora_juego',
        'tiempo_seleccionado',
        'tiempo_transcurrido',
        'goles_local',
        'goles_visitante',
        'tarjetas_amarillas_local',
        'tarjetas_amarillas_visitante',
        'tarjetas_rojas_local',
        'tarjetas_rojas_visitante',
        'tarjetas_verdes_local',
        'tarjetas_verdes_visitante',
        'penales_local',
        'penales_visitante',
        'estado',
        'inicio',
        'descanso_inicio',
    ];

    // Los atributos que deberían ser convertidos a tipos de datos nativos.
    protected $casts = [
        'fecha_juego' => 'date',
        'hora_juego' => 'datetime:H:i',
        'inicio' => 'datetime:H:i',
        'descanso_inicio' => 'datetime:H:i',
    ];

    // Definir las relaciones con otros modelos, si es necesario
    public function equipo_local()
    {
        return $this->belongsTo(Equipos::class, 'equipo_local_id');
    }

    public function equipo_visitante()
    {
        return $this->belongsTo(Equipos::class, 'equipo_visitante_id');
    }
}
