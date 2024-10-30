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
            $table->integer('edad'); // Edad: int
            $table->string('posicion'); // Posicion: string
            $table->string('nacionalidad'); // Nacionalidad: string
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
