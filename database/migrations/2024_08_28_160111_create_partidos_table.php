<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('partidos', function (Blueprint $table) {
            $table->id();
             // Relaciones con equipos
             $table->foreignId('equipo_local_id')->constrained('equipos')->onDelete('cascade');
             $table->foreignId('equipo_visitante_id')->constrained('equipos')->onDelete('cascade');
             
             // Logos de los equipos
             $table->string('logo_equipo_local')->nullable(); 
             $table->string('logo_equipo_visitante')->nullable(); 
 
             // Fecha y hora del partido
             $table->date('fecha_juego'); 
             $table->time('hora_juego');  
 
             // Goles
             $table->integer('goles_local')->default(0);
             $table->integer('goles_visitante')->default(0);
 
             // Tiempo transcurrido
             $table->integer('tiempo_transcurrido')->default(0);
 
             // Estado del partido (con posibilidad de agregar otros estados si es necesario)
             $table->enum('estado', ['no_iniciado', 'primer_tiempo', 'descanso', 'segundo_tiempo', 
             'tercer_tiempo', 'cuarto_tiempo', 'tiempo_extra_1', 'tiempo_extra_2', 'penales', 'finalizado'])
                   ->default('no_iniciado');
 
             // Tarjetas y penales para equipo local
             $table->integer('tarjetas_amarillas_local')->default(0);
             $table->integer('tarjetas_rojas_local')->default(0);
             $table->integer('tarjetas_verdes_local')->default(0);
             $table->integer('penales_local')->default(0);
 
             // Tarjetas y penales para equipo visitante
             $table->integer('tarjetas_amarillas_visitante')->default(0);
             $table->integer('tarjetas_rojas_visitante')->default(0);
             $table->integer('tarjetas_verdes_visitante')->default(0);
             $table->integer('penales_visitante')->default(0);
 
             // Campos adicionales para control del cronómetro
             $table->timestamp('inicio')->nullable();  // Marca el inicio del partido
             $table->timestamp('descanso_inicio')->nullable();  // Marca el inicio del descanso
             $table->integer('tiempo_seleccionado')->default(0);  // Duración seleccionada del partido en minutos
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('partidos');
    }
};
