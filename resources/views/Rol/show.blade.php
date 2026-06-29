@extends('layouts.show')

@section('page-title', 'Detalle del Rol ' . $rol->id)
@section('back-url', route('rol.index'))

@section('show-content')
    <div class="row g-3 mb-4 align-items-stretch">
        <div class="col-12 col-md-6 d-flex flex-column">
            <label class="form-label fw-bold">Rol</label>
            <input type="text" class="form-control h-100" value="{{ $rol->Rol }}" readonly style="background-color: #e9ecef; min-height: 58px;">
        </div>
        <div class="col-12 col-md-6 d-flex flex-column">
            <label class="form-label fw-bold">Descripción</label>
            <textarea class="form-control h-100" readonly style="background-color: #e9ecef; resize: none; min-height: 58px;">{{ trim($rol->Descripcion) }}</textarea>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-header bg-dark text-white py-3">
            <h5 class="card-title mb-0" style="font-size: 1rem;">
                <i class="fas fa-key me-2 text-info"></i> Permisos Asignados a este Rol
            </h5>
        </div>
        <div class="card-body p-3">
            <div class="table-responsive">
                <table id="tabla-permisos" class="table table-striped table-hover table-bordered w-100 align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Nombre</th>
                            <th>Llave de Sistema (Slug)</th>
                            <th>Descripcion</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($rol->permisos as $permiso)
                            <tr>
                                <td>{{ $permiso->Nombre }}</td> {{-- Ajusta según tus columnas en BD --}}
                                <td>
                                    <span class="badge bg-secondary">{{ $permiso->Slug ?? $permiso->Nombre }}</span>
                                </td>
                                <td>{{ $permiso->Descripcion}}</td>
                            </tr>
                        @empty
                            {{-- Se deja vacío; DataTables maneja automáticamente el texto de "No hay registros" --}}
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#tabla-permisos').DataTable({
                responsive: true,
                autoWidth: false,
                pageLength: 5, // Como es un detalle, 5 registros por página suele ser cómodo
                lengthMenu: [5, 10, 25, 50],
                language: {
                    "decimal": "",
                    "emptyTable": "No hay permisos asignados a este rol",
                    "info": "Mostrando _START_ a _END_ de _TOTAL_ permisos",
                    "infoEmpty": "Mostrando 0 a 0 de 0 permisos",
                    "infoFiltered": "(filtrado de _MAX_ permisos totales)",
                    "infoPostFix": "",
                    "thousands": ",",
                    "lengthMenu": "Mostrar _MENU_ registros",
                    "loadingRecords": "Cargando...",
                    "processing": "Procesando...",
                    "search": "Buscar:",
                    "zeroRecords": "No se encontraron permisos coincidentes",
                    "paginate": {
                        "first": "Primero",
                        "last": "Último",
                        "next": "Siguiente",
                        "previous": "Anterior"
                    }
                }
            });
        });
    </script>
@endpush

@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <style>
        /* Pequeño ajuste estético para integrar el buscador de DataTables en Bootstrap 5 */
        .dataTables_filter input {
            border-radius: 4px;
            padding: 0.375rem 0.75rem;
            border: 1px solid #ced4da;
        }
        .dataTables_length select {
            border-radius: 4px;
            border: 1px solid #ced4da;
        }
    </style>
@endpush