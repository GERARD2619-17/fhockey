@extends('adminlte::page')

@section('title', 'Editar Jugador')

@section('content_header')
    <h1>Editar Jugador</h1>
@stop

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('jugadores.update', $jugador->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre</label>
                        <input id="nombre" name="nombre" type="text" class="form-control" value="{{ old('nombre', $jugador->nombre) }}">
                    </div>

                    <div class="mb-3">
                        <label for="edad" class="form-label">Edad</label>
                        <input id="edad" name="edad" type="number" class="form-control" value="{{ old('edad', $jugador->edad) }}">
                    </div>

                    <div class="mb-3">
                        <label for="posicion" class="form-label">Posición</label>
                        <input id="posicion" name="posicion" type="text" class="form-control" value="{{ old('posicion', $jugador->posicion) }}">
                    </div>

                    <div class="mb-3">
                        <label for="nacionalidad" class="form-label">Nacionalidad</label>
                        <input id="nacionalidad" name="nacionalidad" type="text" class="form-control" value="{{ old('nacionalidad', $jugador->nacionalidad) }}">
                    </div>

                    <div class="mb-3">
                        <label for="fotografia" class="form-label">Fotografía</label>
                        @if($jugador->fotografia)
                            <div>
                                <img src="{{ asset('storage/' . $jugador->fotografia) }}" alt="{{ $jugador->nombre }}" class="img-fluid" style="max-width: 100%;">
                                <p><small>Actual</small></p>
                            </div>
                        @else
                            <p>No disponible</p>
                        @endif
                        <input id="fotografia" name="fotografia" type="file" class="form-control-file">
                    </div>

                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <a href="{{ route('jugadores.index') }}" class="btn btn-secondary">Cancelar</a>
                </form>
            </div>
        </div>
    </div>
@stop

@section('css')
    {{-- Agregar aquí estilos adicionales --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    <script> console.log("Hi, I'm using the Laravel-AdminLTE package!"); </script>
@stop
