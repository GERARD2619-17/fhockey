@extends('adminlte::page')

@section('title', 'Editar Partido')

@section('content_header')
    <h1>Editar Partido</h1>
@stop

@section('content')
    <form action="{{ route('partidos.update', $partido->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="row">
            <div class="col-md-5 text-center">
                <h4>{{ $partido->equipo_local->nombre }}</h4>
                @php
                    $fotografiaLocal = $partido->equipo_local->fotografia ?? null;
                    $fotografiaLocal = $fotografiaLocal ? str_replace('\\', '/', $fotografiaLocal) : null;
                @endphp
                @if($fotografiaLocal)
                    <img src="{{ asset('storage/' . $fotografiaLocal) }}" alt="Logo de {{ $partido->equipo_local->nombre }}" style="max-width: 100px; max-height: 100px;">
                @else
                    <p>No hay logo disponible</p>
                @endif
            </div>
            
            <div class="col-md-2 text-center">
                <h4>VS</h4>
            </div>
            
            <div class="col-md-5 text-center">
                <h4>{{ $partido->equipo_visitante->nombre }}</h4>
                @php
                    $fotografiaVisitante = $partido->equipo_visitante->fotografia ?? null;
                    $fotografiaVisitante = $fotografiaVisitante ? str_replace('\\', '/', $fotografiaVisitante) : null;
                @endphp
                @if($fotografiaVisitante)
                    <img src="{{ asset('storage/' . $fotografiaVisitante) }}" alt="Logo de {{ $partido->equipo_visitante->nombre }}" style="max-width: 100px; max-height: 100px;">
                @else
                    <p>No hay logo disponible</p>
                @endif
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="fecha_juego">Fecha del Juego</label>
                    <input type="date" name="fecha_juego" id="fecha_juego" class="form-control" value="{{ \Carbon\Carbon::parse($partido->fecha_juego)->format('Y-m-d') }}" required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="hora_juego">Hora del Juego</label>
                    <input type="time" name="hora_juego" id="hora_juego" class="form-control" value="{{ \Carbon\Carbon::parse($partido->hora_juego)->format('H:i') }}" required>
                </div>
            </div>
        </div>

        <input type="hidden" name="equipo_local_id" value="{{ $partido->equipo_local_id }}">
        <input type="hidden" name="equipo_visitante_id" value="{{ $partido->equipo_visitante_id }}">
        <input type="hidden" name="tiempo_seleccionado" value="{{ $partido->tiempo_seleccionado }}">

        <button type="submit" class="btn btn-primary mt-3">Guardar Cambios</button>
    </form>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop