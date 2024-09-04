@extends('adminlte::page')

@section('title', 'Editar Equipo')

@section('content_header')
    <h1>Editar Equipo</h1>
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

                <form action="{{ route('equipos.update', $equipo->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="form-group">
                        <label for="nombre">Nombre del Equipo:</label>
                        <input type="text" name="nombre" class="form-control" id="nombre" value="{{ old('nombre', $equipo->nombre) }}">
                    </div>
                
                    <div class="form-group">
                        <label for="fotografia">Fotografía del Equipo:</label>
                        @if($equipo->fotografia)
                            <div>
                                <img src="{{ asset('storage/' . $equipo->fotografia) }}" alt="{{ $equipo->nombre }}" class="img-fluid" style="max-width: 100%;">
                                <p><small>Actual</small></p>
                            </div>
                        @else
                            <p>No disponible</p>
                        @endif
                        <input type="file" name="fotografia" class="form-control-file" id="fotografia">
                    </div>
                
                    <button type="submit" class="btn btn-primary">Actualizar</button>
                    <a href="{{ route('equipos.index') }}" class="btn btn-secondary">Cancelar</a>
                </form>
            </div>
        </div>
    </div>
@stop
