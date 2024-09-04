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
        <label for="edad" class="form-label">Edad</label>
        <input id="edad" name="edad" type="number" class="form-control" tabindex="3">
    </div>

    <div class="mb-3">
        <label for="posicion" class="form-label">Posición</label>
        <input id="posicion" name="posicion" type="text" class="form-control" tabindex="4">
    </div>

    <div class="mb-3">
        <label for="nacionalidad" class="form-label">Nacionalidad</label>
        <input id="nacionalidad" name="nacionalidad" type="text" class="form-control" tabindex="5">
    </div>

    <a href="{{ route('jugadores.index') }}" class="btn btn-secondary" tabindex="6">Cancelar</a>
    <button type="submit" class="btn btn-primary" tabindex="7">Guardar</button>
</form>
@stop

@section('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    
@stop