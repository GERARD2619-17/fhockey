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
            $table->foreignId('equipo_local_id')->constrained('equipos')->onDelete('cascade');
            $table->foreignId('equipo_visitante_id')->constrained('equipos')->onDelete('cascade');
            $table->string('logo_equipo_local')->nullable(); // Campo para el logo del equipo local
            $table->string('logo_equipo_visitante')->nullable(); // Campo para el logo del equipo visitante
            $table->date('fecha_juego'); // Columna para la fecha del juego
            $table->time('hora_juego');  // Columna para la hora del juego
            $table->integer('goles_local')->default(0);
            $table->integer('goles_visitante')->default(0);
            $table->integer('tiempo_transcurrido')->default(0);
            $table->enum('estado', ['no_iniciado', 'primer_tiempo', 'segundo_tiempo', 'finalizado'])->default('no_iniciado');
            $table->integer('tarjetas_amarillas_local')->default(0);
            $table->integer('tarjetas_rojas_local')->default(0);
            $table->integer('tarjetas_verdes_local')->default(0);
            $table->integer('penales_local')->default(0);
            $table->integer('tarjetas_amarillas_visitante')->default(0);
            $table->integer('tarjetas_rojas_visitante')->default(0);
            $table->integer('tarjetas_verdes_visitante')->default(0);
            $table->integer('penales_visitante')->default(0);
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
