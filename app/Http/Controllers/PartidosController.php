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
        // Validar los datos del formulario
        $request->validate([
            'equipo_local' => 'required|exists:equipos,id',
            'logo_equipo_local' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'equipo_visitante' => 'required|exists:equipos,id',
            'logo_equipo_visitante' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'fecha_juego' => 'required|date',
            'hora_juego' => 'required',
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

        // Crear un nuevo partido
        $partido = new Partidos();
        $partido->equipo_local_id = $request->input('equipo_local');
        $partido->equipo_visitante_id = $request->input('equipo_visitante');
        $partido->fecha_juego = $request->input('fecha_juego');
        $partido->hora_juego = $request->input('hora_juego');
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

        // Manejo de imágenes
        if ($request->hasFile('logo_equipo_local')) {
            $partido->logo_equipo_local = $request->file('logo_equipo_local')->store('logos', 'public');
        }

        if ($request->hasFile('logo_equipo_visitante')) {
            $partido->logo_equipo_visitante = $request->file('logo_equipo_visitante')->store('logos', 'public');
        }

        $partido->save();

        return redirect()->route('partidos.index')->with('success', 'Partido creado correctamente.');
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

        return response()->json(['success' => true]);
    }

    /**
     * Update the tarjetas for the specified partido.
     */
    public function actualizarTarjetas(Request $request, $id)
    {
        $partido = Partidos::findOrFail($id);

        $tipo = $request->input('tipo');
        $equipo = $request->input('equipo');

        if ($equipo === 'local') {
            $partido->{$tipo . '_local'} += 1;
        } else {
            $partido->{$tipo . '_visitante'} += 1;
        }

        $partido->save();

        return response()->json(['success' => true]);
    }
}