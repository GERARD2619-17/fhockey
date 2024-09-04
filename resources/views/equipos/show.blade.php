@extends('adminlte::page')

@section('title', 'Detalles del Equipo')

@section('content_header')
    <h1>Detalles del Equipo</h1>
@stop

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="nombre">Nombre del Equipo:</label>
                            <p>{{ $equipo->nombre }}</p>
                        </div>

                        <div class="form-group">
                            <label for="fotografia">Fotografía del Equipo:</label>
                            @if($equipo->fotografia)
                                <div>
                                    <img src="{{ asset('storage/' . $equipo->fotografia) }}" alt="{{ $equipo->nombre }}" class="img-fluid" style="max-width: 100%;">
                                </div>
                            @else
                                <p>No disponible</p>
                            @endif
                        </div>

                        <!-- Botón para volver a la lista -->
                        <a href="{{ route('equipos.index') }}" class="btn btn-primary">Volver a la lista</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
