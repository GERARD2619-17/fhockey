@extends('adminlte::page')

@section('title', 'Editar Partido')

@section('content_header')
    <h1>Editar Partido</h1>
@stop

@section('content')
    <form action="{{ route('partidos.update', $partido->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="equipo_local">Equipo Local</label>
            <input type="text" name="equipo_local" id="equipo_local" class="form-control" value="{{ $partido->equipo_local }}" required>
        </div>

        <div class="form-group">
            <label for="logo_equipo_local">Logo Equipo Local</label>
            <input type="file" name="logo_equipo_local" id="logo_equipo_local" class="form-control">
            @if($partido->logo_equipo_local)
                <img src="{{ asset('storage/' . $partido->logo_equipo_local) }}" alt="Logo de {{ $partido->equipo_local }}" style="max-width: 100px; max-height: 50px;">
            @endif
        </div>

        <div class="form-group">
            <label for="equipo_visitante">Equipo Visitante</label>
            <input type="text" name="equipo_visitante" id="equipo_visitante" class="form-control" value="{{ $partido->equipo_visitante }}" required>
        </div>

        <div class="form-group">
            <label for="logo_equipo_visitante">Logo Equipo Visitante</label>
            <input type="file" name="logo_equipo_visitante" id="logo_equipo_visitante" class="form-control">
            @if($partido->logo_equipo_visitante)
                <img src="{{ asset('storage/' . $partido->logo_equipo_visitante) }}" alt="Logo de {{ $partido->equipo_visitante }}" style="max-width: 100px; max-height: 50px;">
            @endif
        </div>

        <div class="form-group">
            <label for="fecha_juego">Fecha del Juego</label>
            <input type="date" name="fecha_juego" id="fecha_juego" class="form-control" value="{{ $partido->fecha_juego }}" required>
        </div>

        <div class="form-group">
            <label for="hora_juego">Hora del Juego</label>
            <input type="time" name="hora_juego" id="hora_juego" class="form-control" value="{{ $partido->hora_juego }}" required>
        </div>

        <div class="form-group">
            <label for="estado">Estado</label>
            <select name="estado" id="estado" class="form-control" required>
                <option value="no_iniciado" {{ $partido->estado == 'no_iniciado' ? 'selected' : '' }}>No Iniciado</option>
                <option value="primer_tiempo" {{ $partido->estado == 'primer_tiempo' ? 'selected' : '' }}>Primer Tiempo</option>
                <option value="segundo_tiempo" {{ $partido->estado == 'segundo_tiempo' ? 'selected' : '' }}>Segundo Tiempo</option>
                <option value="finalizado" {{ $partido->estado == 'finalizado' ? 'selected' : '' }}>Finalizado</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
    </form>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop
