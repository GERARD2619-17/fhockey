@extends('adminlte::page')

@section('title', 'Listado de Partidos')

@section('content_header')
    <h1>Listado de Partidos</h1>
@stop

@section('content')
<a href="{{ route('partidos.create') }}" class="btn btn-primary mb-3">Crear Partido</a>

<div class="table-responsive">
    <table id="partidos" class="table table-striped table-bordered shadow-lg" style="width:100%; white-space: nowrap;">
        <thead class="bg-primary text-white">
            <tr>
                <th scope="col">Equipo Local</th>
                <th scope="col">Logo Local</th>
                <th scope="col">Equipo Visitante</th>
                <th scope="col">Logo Visitante</th>
                <th scope="col">Fecha del Juego</th>
                <th scope="col">Hora del Juego</th>
                <th scope="col">Estado</th>
                <th scope="col" class="actions-column">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($partidos as $partido)
                @php
                    $equipoLocal = json_decode($partido->equipo_local, true);
                    $equipoVisitante = json_decode($partido->equipo_visitante, true);
                    
                    // Función para obtener el valor seguro
                    $getValue = function($array, $key, $default = 'No disponible') {
                        return isset($array[$key]) ? $array[$key] : $default;
                    };
                @endphp
                <tr>
                    <td>{{ $getValue($equipoLocal, 'nombre') }}</td>
                    <td>
                        @php
                            $fotografiaLocal = $getValue($equipoLocal, 'fotografia');
                            $fotografiaLocal = str_replace('\\', '/', $fotografiaLocal);
                        @endphp
                        @if($fotografiaLocal && $fotografiaLocal !== 'No disponible')
                            <img src="{{ asset('storage/' . $fotografiaLocal) }}" alt="Logo de {{ $getValue($equipoLocal, 'nombre') }}" style="max-width: 100px; max-height: 50px;">
                        @else
                            No disponible
                        @endif
                    </td>
                    <td>{{ $getValue($equipoVisitante, 'nombre') }}</td>
                    <td>
                        @php
                            $fotografiaVisitante = $getValue($equipoVisitante, 'fotografia');
                            $fotografiaVisitante = str_replace('\\', '/', $fotografiaVisitante);
                        @endphp
                        @if($fotografiaVisitante && $fotografiaVisitante !== 'No disponible')
                            <img src="{{ asset('storage/' . $fotografiaVisitante) }}" alt="Logo de {{ $getValue($equipoVisitante, 'nombre') }}" style="max-width: 100px; max-height: 50px;">
                        @else
                            No disponible
                        @endif
                    </td>
                    <td>{{ \Carbon\Carbon::parse($partido->fecha_juego)->format('d/m/Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($partido->hora_juego)->format('H:i') }}</td>
                    <td>{{ ucfirst($partido->estado) }}</td>
                    <td class="actions-column">
                        <a href="{{ route('partidos.show', $partido->id) }}" class="btn btn-info btn-sm">Ver</a>
                        <a href="{{ route('partidos.edit', $partido->id) }}" class="btn btn-warning btn-sm">Editar</a>
                        <form action="{{ route('partidos.destroy', $partido->id) }}" method="POST" class="d-inline" onsubmit="return confirmDelete('{{ $getValue($equipoLocal, 'nombre') }} vs {{ $getValue($equipoVisitante, 'nombre') }}')">
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
    <link rel="stylesheet" href="/css/admin_custom.css">
    <link href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <style>
        .table-responsive {
            max-height: 600px;
            overflow-y: auto;
        }
        table.dataTable {
            width: 100% !important;
        }
        .actions-column {
            width: 150px;
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
        $('#partidos').DataTable({
            "lengthMenu": [[5, 10, 50, -1],[5, 10, 50, "All"]]
        });
    });

    function confirmDelete(partido) {
        return confirm(`¿Está seguro de eliminar el partido "${partido}"?`);
    }
</script>
@stop