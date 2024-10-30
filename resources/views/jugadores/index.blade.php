@extends('adminlte::page')

@section('title', 'Listado de Jugadores')

@section('content_header')
    <h1>Listado de Jugadores</h1>
@stop

@section('content')
<a href="{{ route('jugadores.create') }}" class="btn btn-primary mb-3">Crear Jugador</a>

<div class="table-responsive">
    <table id="jugadores" class="table table-striped table-bordered shadow-lg" style="width:100%; white-space: nowrap;">
        <thead class="bg-primary text-white">
            <tr>
                <th scope="col">Nombres</th>
                <th scope="col">Fotografía</th>
                <th scope="col">Edad</th>
                <th scope="col">Posición</th>
                <th scope="col">Nacionalidad</th>
                <th scope="col"> Equipo </th>
                <th scope="col" class="actions-column">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($jugadores as $jugador)
                <tr>
                    <td>{{ $jugador->nombre }}</td>
                    <td>
                        @if($jugador->fotografia)
                            <img src="{{ asset('storage/' . $jugador->fotografia) }}" alt="Foto de {{ $jugador->nombre }}" style="max-width: 100px; max-height: 50px;">
                        @else
                            No disponible
                        @endif
                    </td>
                    <td>{{ $jugador->edad }}</td>
                    <td>{{ $jugador->posicion }}</td>
                    <td>{{ $jugador->nacionalidad }}</td>
                    <td class="actions-column">
                        <a href="{{ route('jugadores.show', $jugador->id) }}" class="btn btn-info btn-sm">Ver</a>
                        <a href="{{ route('jugadores.edit', $jugador->id) }}" class="btn btn-warning btn-sm">Editar</a>
                        <form action="{{ route('jugadores.destroy', $jugador->id) }}" method="POST" class="d-inline" onsubmit="return confirmDelete('{{ $jugador->nombre }}')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@stop

@section('css')
    {{-- Agregar aquí hojas de estilo adicionales --}}
    <link rel="stylesheet" href="/css/admin_custom.css">
    <link href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <style>
        /* Ajuste de tabla para que se adapte al contenido */
        .table-responsive {
            max-height: 600px; /* Ajusta según sea necesario */
            overflow-y: auto;
        }
        table.dataTable {
            width: 100% !important;
        }
        .actions-column {
            width: 200px; /* Ajusta el ancho según sea necesario */
            text-align: center;
        }
    </style>
@stop

@section('js')
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap5.min.js"></script>
<script>
    $(document).ready(function() {
        $('#jugadores').DataTable({
            "lengthMenu": [[5, 10, 50, -1],[5, 10, 50, "All"]]
        });
    });

    function confirmDelete(nombre) {
        return confirm(`¿Está seguro de eliminar el jugador "${nombre}"?`);
    }
</script>
@stop
