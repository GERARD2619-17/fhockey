@extends('adminlte::page')

@section('title', 'Crear Partido')

@section('content_header')
    <h1>Crear Partido</h1>
@stop

@section('content')
    <form action="{{ route('partidos.store') }}" method="POST">
        @csrf

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Información del Partido</h3>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label for="equipo_local">Equipo Local</label>
                    <select name="equipo_local" id="equipo_local" class="form-control" required>
                        <option value="" disabled selected>Selecciona un equipo</option>
                        @foreach($equipos as $equipo)
                            <option value="{{ $equipo->id }}" {{ old('equipo_local') == $equipo->id ? 'selected' : '' }}>
                                {{ $equipo->nombre }}
                            </option>
                        @endforeach
                    </select>
                    @error('equipo_local')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="equipo_visitante">Equipo Visitante</label>
                    <select name="equipo_visitante" id="equipo_visitante" class="form-control" required>
                        <option value="" disabled selected>Selecciona un equipo</option>
                        @foreach($equipos as $equipo)
                            <option value="{{ $equipo->id }}" {{ old('equipo_visitante') == $equipo->id ? 'selected' : '' }}>
                                {{ $equipo->nombre }}
                            </option>
                        @endforeach
                    </select>
                    @error('equipo_visitante')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="fecha_juego">Fecha del Juego</label>
                    <input type="date" name="fecha_juego" id="fecha_juego" class="form-control" value="{{ old('fecha_juego') }}" required>
                    @error('fecha_juego')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="hora_juego">Hora del Juego</label>
                    <input type="time" name="hora_juego" id="hora_juego" class="form-control" value="{{ old('hora_juego') }}" required>
                    @error('hora_juego')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>


            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Guardar</button>
                <a href="{{ route('partidos.index') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </div>
    </form>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script>
        // Puedes agregar scripts adicionales aquí si es necesario
    </script>
@stop