<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class equipos extends Model
{
    use HasFactory;

        /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $table = 'equipos'; 

    protected $fillable = [
        'nombre',
        'fotografia',
    ];

    /**
     * Get the partidos donde el equipo es local.
     */
    public function equipo_local()
    {
        return $this->hasMany(partidos::class, 'equipo_local_id');
    }

    /**
     * Get the partidos donde el equipo es visitante.
     */
    public function equipo_visitante()
    {
        return $this->hasMany(partidos::class, 'equipo_visitante_id');
    }
}
