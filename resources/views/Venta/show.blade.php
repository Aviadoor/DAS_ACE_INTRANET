@extends('layouts.show')

{{-- Título de la vista --}}
@section('page-title', 'Detalles de Venta')
@section('back-url', route('venta.index'))

@section('show-content')
    <div class="row g-3 mb-3">
        <div class="col-12 col-md-6">
            <label class="form-label">Cliente</label>
            <input type="text" class="form-control-readonly" value="{{ $venta->Nombre_Cliente }}" readonly>
        </div>
        <div class="col-12 col-md-6">
            <label class="form-label">Vendedor</label>
            <input type="text" class="form-control-readonly" value="{{ $venta->personal->Nombre_1 }}" readonly>
        </div>
    </div>

    <div class="row g-3 mb-3">
        <div class="col-12 col-md-6">
            <label class="form-label">Fecha Emision</label>
            <input type="text" class="form-control-readonly" value="{{ $venta->Fecha_Emision }}" readonly>
        </div>
        <div class="col-12 col-md-6">
            <label class="form-label">Fecha Entrega</label>
            <input type="text" class="form-control-readonly" value="{{ $venta->Fecha_Entrega }}" readonly>
        </div>
        <div class="col-12 col-md-6">
            <label class="form-label">Fecha Cobro</label>
            <input type="text" class="form-control-readonly" value="{{ $venta->Fecha_Cobro }}" readonly>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-hover table-sm text-center w-100" id="tablaModalArticulos">
            <thead>
                <tr>
                    <th class="text-start">Modelo</th>
                    <th class="text-start">Descripción</th>
                    <th>Stock</th>
                    <th>Precio</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                {{-- Aquí iteramos sobre TODOS los artículos enviados desde el controlador --}}
                @foreach($articulos as $art)
                    <tr class="articulo-row">
                        <td class="text-start modelo-col">{{ $art->Modelo }}</td>
                        <td class="text-start desc-col">{{ $art->Descripcion }}</td>                        
                        <td id="td_stock" class="">{{ $art->pivot->cantidad }}</td>
                        
                        <td>S/ {{ $art->PrecioVenta }}</td>
                        <td class="fw-bold">S/ {{ $art->PrecioVenta*$art->pivot->cantidad }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="row g-3 mb-4 justify-content-end">
        <div class="col-12 col-md-8 row g-3">
            <div class="col-6 col-md-3">
                <label for="Cuotas" class="form-label">Cuotas</label>
                <input type="number" class="form-control" id="Cuotas" name="Cuotas" value="{{ old('Cuotas', 1) }}" min="1" readonly>
            </div>
            <div class="col-6 col-md-3">
                <label for="MontoCancelado" class="form-label">Monto Cancelado</label>
                <input type="number" step="0.01" class="form-control" id="MontoCancelado" name="MontoCancelado" value="{{ $venta->MontoCancelado }}" readonly>
            </div>
            <div class="col-6 col-md-3">
                <label for="Subtotal" class="form-label text-secondary fw-bold">Subtotal</label>
                <input type="number" step="0.01" class="form-control text-end bg-light" id="Subtotal" name="Subtotal" value="{{ $venta->Subtotal }}" readonly>
            </div>
            <div class="col-6 col-md-3">
                <label for="Total" class="form-label text-success fw-bold">Total</label>
                <input type="number" step="0.01" class="form-control text-end fw-bold bg-light" id="Total" name="Total" value="{{ $venta->Total }}" readonly>
            </div>
        </div>
    </div>
@endsection