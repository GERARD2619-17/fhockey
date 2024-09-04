@extends('adminlte::page')

@section('title', 'Detalle del Jugador')

@section('content_header')
    <h1>Detalle del Jugador: {{ $jugador->nombre }}</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header bg-primary text-white">
        <h3>{{ $jugador->nombre }}</h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-4">
                @if($jugador->fotografia)
                    <img src="{{ asset('storage/' . $jugador->fotografia) }}" alt="Foto de {{ $jugador->nombre }}" class="img-fluid rounded">
                @else
                    <img src="https://via.placeholder.com/150" alt="No disponible" class="img-fluid rounded">
                @endif
            </div>
            <div class="col-md-8">
                <p><strong>Nombre:</strong> {{ $jugador->nombre }}</p>
                <p><strong>Edad:</strong> {{ $jugador->edad }} años</p>
                <p><strong>Posición:</strong> {{ $jugador->posicion }}</p>
                <p><strong>Nacionalidad:</strong> {{ $jugador->nacionalidad }}</p>
            </div>
        </div>
    </div>
    <div class="card-footer">
        <a href="{{ route('jugadores.index') }}" class="btn btn-secondary">Volver al listado</a>
    </div>
</div>
@stop

@section('css')
    {{-- Agregar aquí hojas de estilo adicionales --}}
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop
