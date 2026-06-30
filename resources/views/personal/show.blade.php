@extends('layouts.show')

@section('page-title', 'Detalle del Trabajador: ' . $personal->Nombre_1 . ' ' . $personal->Apellido_1)
@section('back-url', route('personal.index'))

@section('show-content')
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-dark text-white py-3">
            <h5 class="card-title mb-0" style="font-size: 1rem;">
                <i class="fas fa-user me-2 text-info"></i> Información Personal
            </h5>
        </div>
        <div class="card-body bg-light">
            <div class="row g-3">
                <div class="col-12 col-md-6 d-flex flex-column">
                    <label class="form-label fw-bold">Nombres</label>
                    <input type="text" class="form-control" value="{{ $personal->Nombre_1 }} {{ $personal->Nombre_2 }}" readonly style="background-color: #e9ecef;">
                </div>
                
                <div class="col-12 col-md-6 d-flex flex-column">
                    <label class="form-label fw-bold">Apellidos</label>
                    <input type="text" class="form-control" value="{{ $personal->Apellido_1 }} {{ $personal->Apellido_2 }}" readonly style="background-color: #e9ecef;">
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-dark text-white py-3">
            <h5 class="card-title mb-0" style="font-size: 1rem;">
                <i class="fas fa-id-card me-2 text-info"></i> Datos de Contacto y Documentación
            </h5>
        </div>
        <div class="card-body bg-light">
            <div class="row g-3">
                <div class="col-12 col-md-4 d-flex flex-column">
                    <label class="form-label fw-bold">ID Tipo Documento</label>
                    <input type="text" class="form-control" value="{{ $personal->documento->Documento}}" readonly style="background-color: #e9ecef;">
                </div>

                <div class="col-12 col-md-4 d-flex flex-column">
                    <label class="form-label fw-bold">N° de Documento</label>
                    <input type="text" class="form-control" value="{{ $personal->Codigo_Documento }}" readonly style="background-color: #e9ecef;">
                </div>

                <div class="col-12 col-md-4 d-flex flex-column">
                    <label class="form-label fw-bold">Teléfono</label>
                    <input type="text" class="form-control" value="{{ $personal->telefono }}" readonly style="background-color: #e9ecef;">
                </div>
            </div>
        </div>
    </div>
@endsection