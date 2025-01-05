<?php

namespace App\Http\Controllers;

use App\Models\equipos;
use App\Models\Jugadores;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class JugadoresController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jugadores = Jugadores::all();
        return view('jugadores.index', compact('jugadores'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //return view('jugadores.create');
        $equipos = equipos::all();
        return view('jugadores.create', compact('equipos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //arreglar esta seccion por que da error
        $request->validate([
            'fotografia' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'nombre' => 'required|string|max:255',
            'fecha_nacimiento' => 'required|date',
            'edad' => 'required|numeric',
            'posicion' => 'required|string|max:255',
            'nacionalidad' => 'required|string|max:255',
            'equipo_id' => 'required|exists:equipos,id'
        ]);

        $jugador = new Jugadores();
        $jugador->nombre = $request->input('nombre');
        $jugador->fecha_nacimiento = $request->input('fecha_nacimiento');
        $jugador->edad = $request->input('edad');
        $jugador->posicion = $request->input('posicion');
        $jugador->nacionalidad = $request->input('nacionalidad');
        $jugador->equipo_id = $request->input('equipo_id');

        if ($request->hasFile('fotografia')) {
            $path = $request->file('fotografia')->store('public/uploads/players');
            $jugador->fotografia = str_replace('public/', '', $path); // Guardar solo la ruta relativa
        }

        $jugador->save();

        return redirect()->route('jugadores.index')->with('success', 'Jugador creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $jugador = Jugadores::findOrFail($id);
        return view('jugadores.show', compact('jugador'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $jugador = Jugadores::findOrFail($id);
        return view('jugadores.edit', compact('jugador'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'edad' => 'required|integer',
            'posicion' => 'required|string|max:255',
            'nacionalidad' => 'required|string|max:255',
            'fotografia' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $jugador = Jugadores::findOrFail($id);
        $jugador->nombre = $request->input('nombre');
        $jugador->edad = $request->input('edad');
        $jugador->posicion = $request->input('posicion');
        $jugador->nacionalidad = $request->input('nacionalidad');

        if ($request->hasFile('fotografia')) {
            // Elimina la imagen antigua si existe
            if ($jugador->fotografia) {
                Storage::delete('public/' . $jugador->fotografia);
            }

            $path = $request->file('fotografia')->store('public/uploads/players');
            $jugador->fotografia = str_replace('public/', '', $path); // Guardar solo la ruta relativa
        }

        $jugador->save();

        return redirect()->route('jugadores.index')->with('success', 'Jugador actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $jugador = Jugadores::findOrFail($id);

        // Elimina la fotografía si existe
        if ($jugador->fotografia) {
            Storage::delete('public/' . $jugador->fotografia);
        }

        $jugador->delete();

        return redirect()->route('jugadores.index')->with('success', 'Jugador eliminado exitosamente.');
    }
}
