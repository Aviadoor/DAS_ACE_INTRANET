@extends('layouts.show')

@section('page-title', 'Detalle del Permiso: ' . $permiso->Nombre)
@section('back-url', route('permiso.index'))

@section('show-content')
    <div class="row g-3 mb-4 align-items-stretch">
        <div class="col-12 col-md-4 d-flex flex-column">
            <label class="form-label fw-bold">Nombre</label>
            <input type="text" class="form-control h-100" value="{{ $permiso->Nombre }}" readonly style="background-color: #e9ecef; min-height: 58px;">
        </div>
        <div class="col-12 col-md-4 d-flex flex-column">
            <label class="form-label fw-bold">Slug</label>
            <input type="text" class="form-control h-100" value="{{ $permiso->Slug }}" readonly style="background-color: #e9ecef; min-height: 58px;">
        </div>
        <div class="col-12 col-md-4 d-flex flex-column">
            <label class="form-label fw-bold">Estado</label>
            <div class="form-control h-100 d-flex align-items-center" style="background-color: #e9ecef; min-height: 58px;">
                @if($permiso->Habilitado)
                    <span class="badge bg-success fs-6"><i class="fas fa-check-circle me-1"></i> Habilitado</span>
                @else
                    <span class="badge bg-danger fs-6"><i class="fas fa-times-circle me-1"></i> Inhabilitado</span>
                @endif
            </div>
        </div>
    </div>

    <div class="row g-3 mb-4 align-items-stretch">
        <div class="col-12 d-flex flex-column">
            <label class="form-label fw-bold">Descripción</label>
            <textarea class="form-control h-100" readonly style="background-color: #e9ecef; resize: none; min-height: 80px;">{{ trim($permiso->Descripcion) }}</textarea>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-header bg-dark text-white py-3">
            <h5 class="card-title mb-0" style="font-size: 1rem;">
                <i class="fas fa-users-cog me-2 text-info"></i> Roles que poseen este permiso
            </h5>
        </div>
        <div class="card-body p-3">
            <div class="table-responsive">
                <table id="tabla-roles" class="table table-striped table-hover table-bordered w-100 align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Rol</th>
                            <th>Descripción</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- Asegúrate de que el modelo Permiso tenga la relación roles() definida --}}
                        @if(isset($permiso->roles))
                            @forelse($permiso->roles as $rol)
                                <tr>
                                    <td class="fw-bold">{{ $rol->Rol }}</td>
                                    <td>{{ $rol->Descripcion }}</td>
                                </tr>
                            @empty
                            @endforelse
                        @endif
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
            $('#tabla-roles').DataTable({
                responsive: true,
                autoWidth: false,
                pageLength: 5,
                lengthMenu: [5, 10, 25, 50],
                language: {
                    "decimal": "",
                    "emptyTable": "Ningún rol tiene asignado este permiso actualmente",
                    "info": "Mostrando _START_ a _END_ de _TOTAL_ roles",
                    "infoEmpty": "Mostrando 0 a 0 de 0 roles",
                    "infoFiltered": "(filtrado de _MAX_ roles totales)",
                    "infoPostFix": "",
                    "thousands": ",",
                    "lengthMenu": "Mostrar _MENU_ registros",
                    "loadingRecords": "Cargando...",
                    "processing": "Procesando...",
                    "search": "Buscar:",
                    "zeroRecords": "No se encontraron roles coincidentes",
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