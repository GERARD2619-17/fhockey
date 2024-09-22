<?php

namespace App\Http\Controllers;

use App\Models\Equipos;
use App\Models\Partidos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
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
        DB::beginTransaction();

        try {
            // Validar la solicitud
            $validated = $request->validate([
                'equipo_local' => 'required|exists:equipos,id',
                'equipo_visitante' => 'required|exists:equipos,id|different:equipo_local',
                'fecha_juego' => 'required|date',
                'hora_juego' => 'required',
            ]);
    
            // Crear un nuevo partido
            $partido = new Partidos;
            $partido->equipo_local_id = $validated['equipo_local'];
            $partido->equipo_visitante_id = $validated['equipo_visitante'];
            $partido->fecha_juego = $validated['fecha_juego'];
            $partido->hora_juego = $validated['hora_juego'];
            $partido->estado = 'no_iniciado';
            
            // Inicializar otros campos con valores por defecto
            $partido->goles_local = 0;
            $partido->goles_visitante = 0;
            $partido->tarjetas_amarillas_local = 0;
            $partido->tarjetas_amarillas_visitante = 0;
            $partido->tarjetas_rojas_local = 0;
            $partido->tarjetas_rojas_visitante = 0;
            $partido->tarjetas_verdes_local = 0;
            $partido->tarjetas_verdes_visitante = 0;
            $partido->penales_local = 0;
            $partido->penales_visitante = 0;
    
            $partido->save();
    
            DB::commit();
    
            return redirect()->route('partidos.index')->with('success', 'Partido creado exitosamente');
        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollback();
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error al crear partido: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Hubo un problema al crear el partido. Por favor, intenta de nuevo.');
        }
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
         // Validar la solicitud
         $request->validate([
            'equipo_local_id' => 'required|exists:equipos,id',
            'equipo_visitante_id' => 'required|exists:equipos,id',
            'fecha_juego' => 'required|date',
            'hora_juego' => 'required|date_format:H:i',
            'tiempo_seleccionado' => 'required|integer|min:1',
            'goles_local' => 'nullable|integer|min:0',
            'goles_visitante' => 'nullable|integer|min:0',
            'tarjetas_amarillas_local' => 'nullable|integer|min:0',
            'tarjetas_amarillas_visitante' => 'nullable|integer|min:0',
            'tarjetas_rojas_local' => 'nullable|integer|min:0',
            'tarjetas_rojas_visitante' => 'nullable|integer|min:0',
            'tarjetas_verdes_local' => 'nullable|integer|min:0',
            'tarjetas_verdes_visitante' => 'nullable|integer|min:0',
            'penales_local' => 'nullable|integer|min:0',
            'penales_visitante' => 'nullable|integer|min:0',
            'estado' => 'nullable|string',
            'inicio' => 'nullable|date_format:H:i',
            'descanso_inicio' => 'nullable|date_format:H:i',
        ]);

        // Encontrar el partido a actualizar
        $partido = Partidos::findOrFail($id);
        $partido->equipo_local_id = $request->input('equipo_local_id');
        $partido->equipo_visitante_id = $request->input('equipo_visitante_id');
        $partido->fecha_juego = $request->input('fecha_juego');
        $partido->hora_juego = $request->input('hora_juego');
        $partido->tiempo_seleccionado = $request->input('tiempo_seleccionado');
        $partido->goles_local = $request->input('goles_local', 0);
        $partido->goles_visitante = $request->input('goles_visitante', 0);
        $partido->tarjetas_amarillas_local = $request->input('tarjetas_amarillas_local', 0);
        $partido->tarjetas_amarillas_visitante = $request->input('tarjetas_amarillas_visitante', 0);
        $partido->tarjetas_rojas_local = $request->input('tarjetas_rojas_local', 0);
        $partido->tarjetas_rojas_visitante = $request->input('tarjetas_rojas_visitante', 0);
        $partido->tarjetas_verdes_local = $request->input('tarjetas_verdes_local', 0);
        $partido->tarjetas_verdes_visitante = $request->input('tarjetas_verdes_visitante', 0);
        $partido->penales_local = $request->input('penales_local', 0);
        $partido->penales_visitante = $request->input('penales_visitante', 0);
        $partido->estado = $request->input('estado', 'no_iniciado');
        $partido->inicio = $request->input('inicio');
        $partido->descanso_inicio = $request->input('descanso_inicio');
        $partido->save();

        return redirect()->route('partidos.index')->with('success', 'Partido actualizado exitosamente');
    
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

        return redirect()->route('partidos.index')->with('success', 'Partido eliminado con Ã©xito.');
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
    // Actualizar marcador
    public function actualizarMarcador(Request $request, $id)
    {
        $partido = Partidos::findOrFail($id); // AsegÃºrate de que este sea el modelo correcto

        if ($request->equipo === 'local') {
            $partido->goles_local += 1;
        } else {
            $partido->goles_visitante += 1;
        }
    
        $partido->save();
    
        return response()->json([
            'goles_local' => $partido->goles_local,
            'goles_visitante' => $partido->goles_visitante
        ]);
    }

    // Actualizar tarjetas
    public function actualizarTarjetas(Request $request, $id)
    {
        $partido = Partidos::find($id);

        if ($request->equipo === 'local') {
            if ($request->tipo === 'amarilla') {
                $partido->tarjetas_amarillas_local += 1;
            } elseif ($request->tipo === 'roja') {
                $partido->tarjetas_rojas_local += 1;
            } else {
                $partido->tarjetas_verdes_local += 1;
            }
        } else {
            if ($request->tipo === 'amarilla') {
                $partido->tarjetas_amarillas_visitante += 1;
            } elseif ($request->tipo === 'roja') {
                $partido->tarjetas_rojas_visitante += 1;
            } else {
                $partido->tarjetas_verdes_visitante += 1;
            }
        }
    
        $partido->save();
    
        return response()->json($partido);
    }

    // Asignar penal
    public function asignarPenal(Request $request, $id)
    {
        $partido = Partidos::find($id);

    if ($request->equipo === 'local') {
        $partido->penales_local += 1;
    } else {
        $partido->penales_visitante += 1;
    }

    $partido->save();

    return response()->json($partido);

        $partido->save();

        return response()->json([
            'penales_local' => $partido->penales_local,
            'penales_visitante' => $partido->penales_visitante,
        ]);
    }

    // Actualizar tiempo
    public function actualizarTiempoSeleccionado(Request $request, Partidos $partido)
    {
        Log::info('Actualizando tiempo seleccionado', [
            'partido_id' => $partido->id,
            'tiempo_seleccionado' => $request->tiempo_seleccionado
        ]);
    
        $partido->tiempo_seleccionado = $request->tiempo_seleccionado;
        $saved = $partido->save();
    
        Log::info('Resultado de la actualización', ['saved' => $saved]);
    
        return response()->json([
            'success' => $saved,
            'tiempo_seleccionado' => $partido->tiempo_seleccionado
        ]);
    }
    
    public function actualizarTiempo(Request $request, Partidos $partido)
    {
        Log::info('Actualizando tiempo transcurrido', [
            'partido_id' => $partido->id,
            'tiempo' => $request->tiempo
        ]);
    
        $partido->tiempo_transcurrido = $request->tiempo;
        $saved = $partido->save();
    
        Log::info('Resultado de la actualización', ['saved' => $saved]);
    
        return response()->json([
            'success' => $saved,
            'tiempo_transcurrido' => $partido->tiempo_transcurrido
        ]);
    }

    // Actualizar estado
    public function actualizarEstado(Request $request, Partidos $partido)
    {
        $estado = $request->input('estado');
        $partido->update(['estado' => $estado]);
        return response()->json(['estado' => $partido->estado]);
    }
}
