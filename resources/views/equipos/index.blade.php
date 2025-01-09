@extends('adminlte::page')

@section('title', 'Listado de Equipos')

@section('content_header')
    <h1 class="text-center">Listado de Equipos</h1>
@stop

@section('content')
<a href="{{ route('equipos.create') }}" class="btn btn-primary mb-3">Crear Equipo</a>

<div class="card shadow-sm">
    <div class="card-body">
        <table id="equipos" class="table table-striped table-bordered shadow-lg" style="width:100%; white-space: nowrap;">
            <thead class="bg-primary text-white">
                <tr class="text-center">
                    <th scope="col">Nombre del Equipo</th>
                    <th scope="col">Logo</th>
                    <th scope="col" class="actions-column">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($equipos as $equipo)
                    <tr>
                        <td class="align-middle text-center">{{ $equipo->nombre }}</td>
                        <td class="align-middle text-center">
                            @if($equipo->fotografia)
                                <img src="{{ asset('storage/' . $equipo->fotografia) }}" alt="Logo de {{ $equipo->nombre }}" class="img-thumbnail" style="max-width: 100px; max-height: 50px;">
                            @else
                                <small>No disponible</small>
                            @endif
                        </td>
                        <td class="actions-column text-center">
                            <a href="{{ route('equipos.show', $equipo->id) }}" class="btn btn-info btn-sm">👁 Ver</a>
                            <a href="{{ route('equipos.edit', $equipo->id) }}" class="btn btn-warning btn-sm">✏️ Editar</a>
                            <form action="{{ route('equipos.destroy', $equipo->id) }}" method="POST" class="d-inline" onsubmit="return confirmDelete('{{ $equipo->nombre }}')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">❌ Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@stop

@section('css')
    {{-- Estilos adicionales --}}
    <link rel="stylesheet" href="/css/admin_custom.css">
    <link href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/fixedheader/3.1.9/css/fixedHeader.bootstrap5.min.css" rel="stylesheet">
    <style>
        .fixed-card {
            position: fixed;
            top: 60px; /* Ajusta esto según la altura de tu encabezado */
            left: 0;
            right: 0;
            z-index: 1000;
        }
    
        .fixed-header {
            position: fixed;
            top: 0;
            background: white;
            z-index: 1010;
        }
    
        table.dataTable {
            
            width: 100% !important;
        }
    
        .actions-column {
            width: 150px;
            text-align: center;
        }
    
        .img-thumbnail {
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
    
        .btn-sm {
            padding: 5px 10px;
            font-size: 0.85rem;
        }
    
        .btn {
            margin: 2px;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }
    
        .btn i {
            position: fixed;
            font-size: 0.85rem;
        }
    </style>    
@stop

@section('js')
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/fixedheader/3.1.9/js/dataTables.fixedHeader.min.js"></script>
<script>
    $(document).ready(function() {
        var table = $('#equipos').DataTable({
            "lengthMenu": [[5, 10, 50, -1], [5, 10, 50, "Todos"]],
            "responsive": true,
            "language": {
                url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json'
            }
        });

        // Activar el encabezado fijo
        new $.fn.dataTable.FixedHeader(table);
    });

    function confirmDelete(nombre) {
        return confirm(`¿Está seguro de eliminar el equipo "${nombre}"?`);
    }
</script>
@stop