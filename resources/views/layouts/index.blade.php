@extends('layouts.app')

@section('title')
    @yield('page-title', 'Lista de Registros')
@endsection

@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <style>
        .main-card {
            background-color: #ffffff;
            border: 1px solid #e0e0e0;
            border-radius: 4px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        }
        .action-btn { padding: 0.2rem 0.5rem; font-size: 0.8rem; margin: 0 1px; color: white !important; }
        .btn-view { background-color: #6c757d; }
        .btn-edit { background-color: #007bff; }
        .btn-delete { background-color: #ffc107; }
        @yield('custom-css')
    </style>
@endpush

@section('content')
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center mb-3 gap-3">
        <h4 class="m-0 text-secondary" style="font-weight: 500;">@yield('page-title')</h4>
        
        <div class="d-flex gap-2 w-100 w-sm-auto justify-content-start justify-content-sm-end">
            @yield('header-actions')
        </div>
    </div>

    <div class="main-card p-3">
        <div class="table-responsive">
            <table id="dataTable" class="table table-hover text-center w-100 text-nowrap">
                <thead>
                    <tr>
                        @yield('table-head')
                    </tr>
                </thead>
                <tbody>
                    @yield('table-body')
                </tbody>
            </table>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function() {
            var table = $('#dataTable').DataTable({
                "language": { "url": "//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json" },
                "paging": true,
                "pageLength": 15,
                "lengthChange": false, 
                "info": false,         
                "searching": true,     
                "ordering": true,
                "autoWidth": false,
                "dom": 'rt<"bottom d-flex justify-content-center mt-3"p><"clear">'
            });
            
            $('#customSearch').on('keyup', function() {
                table.search(this.value).draw();
            });
        });
    </script>
    @yield('custom-scripts')
@endpush