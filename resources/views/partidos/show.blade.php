@extends('adminlte::page')

@section('title', 'Detalles del Partido')

@section('content_header')
    <h1>Detalles del Partido</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3>{{ $partido->equipo_local->nombre }} vs {{ $partido->equipo_visitante->nombre }}</h3>
        </div>
        <div class="card-body">

            <div class="row mb-3">
                <div class="col-md-6">
                    <h4>Equipo Local</h4>
                    <p><strong>Nombre:</strong> {{ $partido->equipo_local->nombre }}</p>

                    @php
                        $fotografiaLocal = str_replace('\\', '/', $partido->equipo_local->fotografia ?? null);
                    @endphp
                    @if($fotografiaLocal)
                        <img src="{{ asset('storage/' . $fotografiaLocal) }}" alt="Logo de {{ $partido->equipo_local->nombre }}" class="img-fluid" style="max-width: 200px; max-height: 100px;">
                    @else
                        <p>No disponible</p>
                    @endif

                    <p><strong>Goles:</strong> {{ $partido->goles_local }}</p>
                    <p><strong>Tarjetas Amarillas:</strong> {{ $partido->tarjetas_amarillas_local }}</p>
                    <p><strong>Tarjetas Rojas:</strong> {{ $partido->tarjetas_rojas_local }}</p>
                    <p><strong>Tarjetas Verdes:</strong> {{ $partido->tarjetas_verdes_local }}</p>
                    <p><strong>Penales:</strong> {{ $partido->penales_local }}</p>

                </div>
                <div class="col-md-6">
                    <h4>Equipo Visitante</h4>
                    <p><strong>Nombre:</strong> {{ $partido->equipo_visitante->nombre }}</p>

                    @php
                        $fotografiaVisitante = str_replace('\\', '/', $partido->equipo_visitante->fotografia ?? null);
                    @endphp
                    @if($fotografiaVisitante)
                        <img src="{{ asset('storage/' . $fotografiaVisitante) }}" alt="Logo de {{ $partido->equipo_visitante->nombre }}" class="img-fluid" style="max-width: 200px; max-height: 100px;">
                    @else
                        <p>No disponible</p>
                    @endif

                    <p><strong>Goles:</strong> {{ $partido->goles_visitante }}</p>
                    <p><strong>Tarjetas Amarillas:</strong> {{ $partido->tarjetas_amarillas_visitante }}</p>
                    <p><strong>Tarjetas Rojas:</strong> {{ $partido->tarjetas_rojas_visitante }}</p>
                    <p><strong>Tarjetas Verdes:</strong> {{ $partido->tarjetas_verdes_visitante }}</p>
                    <p><strong>Penales:</strong> {{ $partido->penales_visitante }}</p>
                </div>
            </div>

            <p><strong>Fecha del Juego:</strong> {{ \Carbon\Carbon::parse($partido->fecha_juego)->format('d/m/Y') }}</p>
            <p><strong>Hora del Juego:</strong> {{ \Carbon\Carbon::parse($partido->hora_juego)->format('H:i') }}</p>
            <p><strong>Estado:</strong> {{ ucfirst(str_replace('_', ' ', $partido->estado)) }}</p>

            <div class="mt-4">
                <a href="{{ route('partidos.paneljuego', $partido->id) }}" class="btn btn-warning">Ir al Panel de Juego</a>
                <a href="{{ route('partidos.index') }}" class="btn btn-secondary">Volver al Listado</a>
            </div>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script> console.log('Vista de Detalles del Partido'); </script>
@stop
