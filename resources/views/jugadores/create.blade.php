@extends('adminlte::page')

@section('title', 'Nuevo Jugador')

@section('content_header')
<h1>Registrar un Jugador</h1>
@stop

@section('content')
<form action="{{ route('jugadores.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="mb-3">
        <label for="fotografia" class="form-label">Fotografía</label>
        <input id="fotografia" name="fotografia" type="file" class="form-control" tabindex="1">
    </div>

    <div class="mb-3">
        <label for="nombre" class="form-label">Nombre</label>
        <input id="nombre" name="nombre" type="text" class="form-control" tabindex="2">
    </div>

    <div class="mb-3">
        <label for="fecha_nacimiento" class="form-label">Fecha de Nacimiento</label>
        <input id="fecha_nacimiento" name="fecha_nacimiento" type="date" class="form-control" tabindex="3" onchange="calcularEdad()">
    </div>

    <div class="mb-3">
        <label for="edad" class="form-label">Edad</label>
        <input id="edad" name="edad" type="number" class="form-control" tabindex="4" readonly>
    </div>

    <div class="mb-3">
        <label for="posicion" class="form-label">Posición</label>
        <input id="posicion" name="posicion" type="text" class="form-control" tabindex="5">
    </div>

    <div class="mb-3">
        <label for="nacionalidad" class="form-label">Nacionalidad</label>
        <input id="nacionalidad" name="nacionalidad" type="text" class="form-control" tabindex="6">
    </div>

    <div class="mb-3">
        <label for="equipo_id" class="form-label">Equipo</label>
        <select id="equipo_id" name="equipo_id" class="form-control select2" tabindex="7">
            <option value="">Selecciona un equipo</option>
            @foreach($equipos as $equipo)
                <option value="{{ $equipo->id }}">{{ $equipo->nombre }}</option>
            @endforeach
        </select>
    </div>

    <a href="{{ route('jugadores.index') }}" class="btn btn-secondary" tabindex="8">Cancelar</a>
    <button type="submit" class="btn btn-primary" tabindex="9">Guardar</button>
</form>
@stop

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                theme: 'classic',
                placeholder: 'Selecciona un equipo',
                allowClear: true
            });
        });

        function calcularEdad() {
            const fechaNacimiento = new Date(document.getElementById('fecha_nacimiento').value);
            const hoy = new Date();
            let edad = hoy.getFullYear() - fechaNacimiento.getFullYear();
            const mes = hoy.getMonth() - fechaNacimiento.getMonth();
            
            if (mes < 0 || (mes === 0 && hoy.getDate() < fechaNacimiento.getDate())) {
                edad--;
            }
            
            document.getElementById('edad').value = edad;
        }
    </script>
@stop