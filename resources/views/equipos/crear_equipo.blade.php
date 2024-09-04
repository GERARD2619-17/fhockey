@extends('adminlte::page')

@section('title', 'Crear Equipo')

@section('content_header')
    <h1>Crear Equipo</h1>
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

                <form action="{{ route('equipos.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="nombre">Nombre del Equipo:</label>
                        <input type="text" name="nombre" class="form-control" id="nombre" value="{{ old('nombre') }}">
                    </div>

                    <div class="form-group">
                        <label for="fotografia">Fotografía del Equipo:</label>
                        <input type="file" name="fotografia" class="form-control-file" id="fotografia">
                    </div>

                    <button type="submit" class="btn btn-primary">Crear</button>
                </form>
            </div>
        </div>
    </div>
@stop