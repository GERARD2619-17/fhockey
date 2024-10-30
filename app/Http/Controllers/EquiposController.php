<?php

namespace App\Http\Controllers;

use App\Models\equipos;
use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class EquiposController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         // Obtener todos los equipos
         $equipos = Equipos::all();
         return view('equipos.index', compact('equipos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
         // Mostrar la vista para crear un nuevo equipo
         return view('equipos.crear_equipo');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
         // Validar los datos del formulario
         $request->validate([
            'nombre' => 'required',
            'fotografia' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Crear un nuevo equipo
        $equipo = new Equipos;
        $equipo->nombre = $request->nombre;

        if ($request->hasFile('fotografia')) {
            // Crear una carpeta con el nombre del equipo
            $folderName = 'logos/' . $equipo->nombre;
            $path = $request->file('fotografia')->storeAs(
                $folderName, 
                $request->nombre . '.' . $request->file('fotografia')->getClientOriginalExtension(), 
                'public'
            );
            $equipo->fotografia = $path;
        }

        $equipo->save();

        return redirect()->route('equipos.index');
    }
    /**
     * Display the specified resource.
     */
    public function show(equipos $equipo)
    {
        // Mostrar la vista del equipo especificado
        return view('equipos.show', compact('equipo'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(equipos $equipo)
    {
         // Mostrar la vista para editar el equipo especificado
         return view('equipos.edit', compact('equipo'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, equipos $equipo)
    {
        // Validar los datos del formulario
        $request->validate([
            'nombre' => 'required|string|max:255',
            'fotografia' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $equipo->nombre = $request->input('nombre');

        // Manejo de la fotografía
        if ($request->hasFile('fotografia')) {
            // Elimina la fotografía anterior si existe
            if ($equipo->fotografia) {
                Storage::delete('public/' . $equipo->fotografia);
            }

            // Guarda la nueva fotografía en la carpeta del equipo
            $folderName = 'logos/' . $equipo->nombre;
            $filename = $request->nombre . '.' . $request->file('fotografia')->getClientOriginalExtension();
            $path = $request->file('fotografia')->storeAs($folderName, $filename, 'public');
            $equipo->fotografia = $path;
        }

        $equipo->save();

        return redirect()->route('equipos.index')->with('success', 'Equipo actualizado con éxito.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(equipos $equipo)
    {
        // Obtener la ruta de la carpeta del equipo
        $folderName = 'logos/' . $equipo->nombre;

        // Verificar si la carpeta existe y eliminarla
        if (File::exists(storage_path('app/public/' . $folderName))) {
            File::deleteDirectory(storage_path('app/public/' . $folderName));
        }

        // Eliminar el equipo de la base de datos
        $equipo->delete();

        return redirect()->route('equipos.index');
    }
}
