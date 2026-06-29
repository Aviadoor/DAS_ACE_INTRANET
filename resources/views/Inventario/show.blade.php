@extends('layouts.show')

@section('page-title', 'Artículo: ' . $articulo->Modelo)
@section('back-url', route('inventario.index'))

@section('show-content')
    <div class="row g-3 mb-3">
        <div class="col-12 col-md-4">
            <label class="form-label">Modelo</label>
            <input type="text" class="form-control-readonly" value="{{ $articulo->Modelo}}" readonly>
        </div>
        <div class="col-12 col-md-4">
            <label class="form-label">Unidad</label>
            <input type="text" class="form-control-readonly" value="{{ $articulo->unidad->Unidad ?? 'Sin Unidad' }}" readonly>
        </div>
        <div class="col-12 col-md-4">
            <label class="form-label">Stock</label>
            <input type="text" class="form-control-readonly" value="{{ $articulo->Stock }}" readonly>
        </div>
    </div>

    <div class="row g-3 mb-3">
        <div class="col-md-12">
            <label class="form-label">Descripción</label>
            <textarea class="form-control-readonly" rows="2" readonly>{{ $articulo->Descripcion }}</textarea>
        </div>
    </div>

    <div class="row g-3 mb-3">
        <div class="col-12 col-md-6">
            <label class="form-label">Costo</label>
            <input type="text" class="form-control-readonly" value="{{ number_format($articulo->Costo, 3) }}" readonly>
        </div>
        <div class="col-12 col-md-6">
            <label class="form-label">Precio de Venta</label>
            <input type="text" class="form-control-readonly" value="{{ number_format($articulo->PrecioVenta, 3) }}" readonly>
        </div>
    </div>

    <div class="row g-3 mb-3">
        <div class="col-6 col-md-3">
            <label class="form-label">Peso (kg)</label>
            <input type="text" class="form-control-readonly" value="{{ $articulo->Peso }}" readonly>
        </div>
        <div class="col-6 col-md-3">
            <label class="form-label">Largo (mm)</label>
            <input type="text" class="form-control-readonly" value="{{ $articulo->Largo }}" readonly>
        </div>
        <div class="col-6 col-md-3">
            <label class="form-label">Ancho (mm)</label>
            <input type="text" class="form-control-readonly" value="{{ $articulo->Ancho }}" readonly>
        </div>
        <div class="col-6 col-md-3">
            <label class="form-label">Alto (mm)</label>
            <input type="text" class="form-control-readonly" value="{{ $articulo->Alto }}" readonly>
        </div>
    </div>
@endsection