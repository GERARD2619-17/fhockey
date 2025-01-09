@extends('adminlte::page')

@section('title', 'Editar Jugador')

@section('content_header')
<h1>Editar Jugador: {{ $jugador->nombre }}</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header bg-primary text-white">
        <h3>{{ $jugador->nombre }}</h3>
    </div>
    <div class="card-body">
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
            
            <div class="row">
                <div class="col-md-4">
                    @if($jugador->fotografia)
                        <img src="{{ asset('storage/' . $jugador->fotografia) }}" alt="Foto de {{ $jugador->nombre }}" class="img-fluid rounded mb-3">
                    @else
                        <img src="https://via.placeholder.com/150" alt="No disponible" class="img-fluid rounded mb-3">
                    @endif
                    <div class="form-group">
                        <label for="fotografia">Actualizar fotografía</label>
                        <input id="fotografia" name="fotografia" type="file" class="form-control-file">
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="form-group">
                        <label><strong>Nombre:</strong></label>
                        <input type="text" name="nombre" class="form-control" value="{{ old('nombre', $jugador->nombre) }}">
                    </div>
                    
                    <div class="form-group">
                        <label><strong>Edad:</strong></label>
                        <input type="number" name="edad" class="form-control" value="{{ old('edad', $jugador->edad) }}" readonly>
                    </div>
                    
                    <div class="form-group">
                        <label><strong>Posición:</strong></label>
                        <input type="text" name="posicion" class="form-control" value="{{ old('posicion', $jugador->posicion) }}">
                    </div>
                    
                    <div class="form-group">
                        <label><strong>Nacionalidad:</strong></label>
                        <input type="text" name="nacionalidad" class="form-control" value="{{ old('nacionalidad', $jugador->nacionalidad) }}">
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Guardar cambios</button>
            <a href="{{ route('jugadores.index') }}" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</div>
@stop

@section('css')
    {{-- Agregar aquí estilos adicionales --}}
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script> console.log("Hi, I'm using the Laravel-AdminLTE package!"); </script>
@stop
