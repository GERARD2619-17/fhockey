<?php

namespace App\Http\Controllers;

use App\Models\Equipos;
use App\Models\Partidos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PartidosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $partidos = Partidos::with('equipo_local', 'equipo_visitante')->get();
        return view('partidos.index', compact('partidos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $equipos = Equipos::all();
        return view('partidos.create', compact('equipos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $partido = Partidos::with('equipo_local', 'equipo_visitante')->findOrFail($id);
        return view('partidos.show', compact('partido'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $partido = Partidos::findOrFail($id);
        $equipos = Equipos::all();
        return view('partidos.edit', compact('partido', 'equipos'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'goles_local' => 'nullable|integer',
            'goles_visitante' => 'nullable|integer',
            'tiempo_transcurrido' => 'nullable|string',
            'estado' => 'required|in:no_iniciado,primer_tiempo,segundo_tiempo,finalizado',
            'tarjetas_amarillas_local' => 'nullable|integer',
            'tarjetas_rojas_local' => 'nullable|integer',
            'tarjetas_verdes_local' => 'nullable|integer',
            'penales_local' => 'nullable|integer',
            'tarjetas_amarillas_visitante' => 'nullable|integer',
            'tarjetas_rojas_visitante' => 'nullable|integer',
            'tarjetas_verdes_visitante' => 'nullable|integer',
            'penales_visitante' => 'nullable|integer',
        ]);

        $partido = Partidos::findOrFail($id);

        $partido->goles_local = $request->input('goles_local', 0);
        $partido->goles_visitante = $request->input('goles_visitante', 0);
        $partido->tiempo_transcurrido = $request->input('tiempo_transcurrido', '');
        $partido->estado = $request->input('estado');
        $partido->tarjetas_amarillas_local = $request->input('tarjetas_amarillas_local', 0);
        $partido->tarjetas_rojas_local = $request->input('tarjetas_rojas_local', 0);
        $partido->tarjetas_verdes_local = $request->input('tarjetas_verdes_local', 0);
        $partido->penales_local = $request->input('penales_local', 0);
        $partido->tarjetas_amarillas_visitante = $request->input('tarjetas_amarillas_visitante', 0);
        $partido->tarjetas_rojas_visitante = $request->input('tarjetas_rojas_visitante', 0);
        $partido->tarjetas_verdes_visitante = $request->input('tarjetas_verdes_visitante', 0);
        $partido->penales_visitante = $request->input('penales_visitante', 0);

        $partido->save();

        return redirect()->back()->with('success', 'Partido actualizado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $partido = Partidos::findOrFail($id);

        if ($partido->logo_equipo_local) {
            Storage::disk('public')->delete($partido->logo_equipo_local);
        }

        if ($partido->logo_equipo_visitante) {
            Storage::disk('public')->delete($partido->logo_equipo_visitante);
        }

        $partido->delete();

        return redirect()->route('partidos.index')->with('success', 'Partido eliminado con éxito.');
    }

    /**
     * Show the game panel for the specified partido.
     */
    public function panelJuego($id)
    {
        $partido = Partidos::findOrFail($id);
        return view('partidos.paneljuego', compact('partido'));
    }

    /**
     * Update the goals for the specified partido.
     */
    public function actualizarGoles(Request $request, $id)
    {
        $partido = Partidos::findOrFail($id);

        if ($request->input('equipo') === 'local') {
            $partido->goles_local += 1;
        } else {
            $partido->goles_visitante += 1;
        }

        $partido->save();
        
    }
}