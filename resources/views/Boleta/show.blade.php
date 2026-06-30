@extends('layouts.show')

@section('page-title', 'Detalle de Boleta #' . $boleta->id)
@section('back-url', route('boleta.index'))

@section('show-content')
    <div class="row g-3 mb-3">
        <div class="col-12 col-md-6">
            <label class="form-label">Personal</label>
            <input type="text" class="form-control-readonly" value="{{ $boleta->personal?->Codigo_Documento }}">
            <input type="text" class="form-control-readonly" value="{{ $boleta->personal?->Nombre_1 . " " . $boleta->personal?->Nombre_2 . " " . $boleta->personal?->Apellido_1 . " " . $boleta->personal?->Apellido_2 }}" readonly>
        </div>
        <div class="col-12 col-md-6">
            <label class="form-label">Fecha de Inicio</label>
            <input type="text" class="form-control-readonly" value="{{ $boleta->Fecha_Inicio }}" readonly>
        </div>
    </div>

    <div class="row g-3 mb-3">
        <div class="col-12 col-md-6">
            <label class="form-label">Días Laborados</label>
            <input type="text" class="form-control-readonly" value="{{ $boleta->Dias_Laborados }}" readonly>
        </div>
        <div class="col-12 col-md-6">
            <label class="form-label">Total de Horas</label>
            <input type="text" class="form-control-readonly" value="{{ $boleta->Total_Horas }}" readonly>
        </div>
    </div>

    <div class="row g-3 mb-3">
        <div class="col-12 col-md-4">
            <label class="form-label">Sueldo Bruto</label>
            <input type="text" class="form-control-readonly fw-bold text-secondary" value="S/ {{ number_format($boleta->Sueldo_Bruto, 2) }}" readonly>
        </div>
        <div class="col-12 col-md-4">
            <label class="form-label">Prima de Seguro</label>
            <input type="text" class="form-control-readonly text-danger" value="S/ {{ number_format($boleta->Prima_Seguro, 2) }}" readonly>
        </div>
        <div class="col-12 col-md-4">
            <label class="form-label">Sueldo Neto</label>
            <input type="text" class="form-control-readonly fw-bold text-success" value="S/ {{ number_format($boleta->Sueldo_Neto, 2) }}" readonly>
        </div>
    </div>
@endsection