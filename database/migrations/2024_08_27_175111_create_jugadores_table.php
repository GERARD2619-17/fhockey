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
        Schema::create('jugadores', function (Blueprint $table) {
            $table->id();// ID: int
            $table->string('fotografia'); // Fotografia: string
            $table->string('nombre'); // Nombre: string
            $table->date('fecha_nacimiento'); // fechanac: date
            $table->integer('edad'); // Edad: int
            $table->string('posicion'); // Posicion: string
            $table->string('nacionalidad'); // Nacionalidad: striing
            // Agregar la relación con equipo
            $table->unsignedBigInteger('equipo_id');
            $table->foreign('equipo_id')->references('id')->on('equipos')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jugadores');
    }
};
