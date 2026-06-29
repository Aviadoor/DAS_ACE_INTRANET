@extends('layouts.app')

@section('title')
    @yield('page-title', 'Editar Registro')
@endsection

@push('css')
    <style>
        .main-card { background-color: #ffffff; border: 1px solid #e0e0e0; border-radius: 4px; box-shadow: 0 1px 3px rgba(0,0,0,0.05); }
        .btn-volver { background-color: #6c757d; color: white; border: none; font-size: 0.9rem; padding: 0.375rem 1rem; }
        .btn-volver:hover { background-color: #5a6268; color: white; }
        .btn-guardar { background-color: #28a745; color: white; border: none; font-size: 0.9rem; padding: 0.375rem 1rem; }
        .btn-guardar:hover { background-color: #218838; color: white; }
        .form-label { font-weight: 700; font-size: 0.85rem; color: #333; margin-bottom: 0.3rem; }
        .form-control { background-color: #ffffff; border: 1px solid #ced4da; border-radius: 3px; font-size: 0.9rem; color: #495057; padding: 0.4rem 0.75rem; }
        .form-control:focus { box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25); border-color: #80bdff; outline: none; }
        textarea.form-control { resize: none; }
        @yield('custom-css')
    </style>
@endpush

@section('content')
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center mb-3 gap-2">
        <h4 class="m-0 text-dark" style="font-weight: 400;">@yield('page-title')</h4>
        
        <a href="@yield('back-url')" class="btn btn-volver rounded-1">
            <i class="fas fa-reply me-1"></i> Volver
        </a>
    </div>

    <div class="main-card p-3 p-md-4">
        @yield('form-content')
    </div>
@endsection