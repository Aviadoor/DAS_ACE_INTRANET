@extends('layouts.edit')

@section('page-title', 'Editar Artículo')
@section('back-url', route('inventario.index'))

@section('form-content')
    <form action="{{ route('inventario.update', $articulo->id) }}" method="POST">
        @csrf
        @method('PUT') 
        <div class="row g-3 mb-3">
            <div class="col-12 col-md-6">
                <label for="modelo" class="form-label">Modelo</label>
                <input type="text" class="form-control @error('Modelo') is-invalid @enderror" id="modelo" name="Modelo" value="{{ old('Modelo', $articulo->Modelo) }}" placeholder="Ingrese modelo">
                @error('Modelo') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-12 col-md-6">
                <label for="fk_id_unidad" class="form-label">Unidad de Medida</label>
                <select class="form-control @error('fk_id_unidad') is-invalid @enderror" id="fk_id_unidad" name="fk_id_unidad">
                    <option value="">Seleccione una unidad...</option>
                    @foreach($unidades as $unidad)
                        <option value="{{ $unidad->id }}" {{ old('fk_id_unidad', $articulo->fk_id_unidad) == $unidad->id ? 'selected' : '' }}>
                            {{ $unidad->Unidad }} ({{ $unidad->Sigla }})
                        </option>
                    @endforeach
                </select>
                @error('fk_id_unidad') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-12 col-md-6">
                <label for="stock" class="form-label">Stock</label>
                <input type="number" class="form-control @error('Stock') is-invalid @enderror" id="stock" name="Stock" value="{{ old('Stock', $articulo->Stock) }}" placeholder="0">
                @error('Stock') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
        </div>

        <div class="row g-3 mb-3">
            <div class="col-md-12">
                <label for="descripcion" class="form-label">Descripción</label>
                <textarea class="form-control @error('Descripcion') is-invalid @enderror" id="descripcion" name="Descripcion" rows="3" placeholder="Ingrese descripción">{{ old('Descripcion', $articulo->Descripcion) }}</textarea>
                @error('Descripcion') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
        </div>

        <div class="row g-3 mb-3">
            <div class="col-12 col-md-6">
                <label for="costo" class="form-label">Costo</label>
                <input type="number" step="0.01" class="form-control @error('Costo') is-invalid @enderror" id="costo" name="Costo" value="{{ old('Costo', $articulo->Costo) }}" placeholder="0">
                @error('Costo') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-12 col-md-6">
                <label for="precio_venta" class="form-label">Precio de Venta</label>
                <input type="number" step="0.01" class="form-control @error('PrecioVenta') is-invalid @enderror" id="precio_venta" name="PrecioVenta" value="{{ old('PrecioVenta', $articulo->PrecioVenta) }}" placeholder="0">
                @error('PrecioVenta') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
        </div>

        <div class="row g-3 mb-4">
            <div class="col-6 col-md-3">
                <label for="peso" class="form-label">Peso (kg)</label>
                <input type="number" step="0.01" class="form-control @error('Peso') is-invalid @enderror" id="peso" name="Peso" value="{{ old('Peso', $articulo->Peso) }}" placeholder="0">
                @error('Peso') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-6 col-md-3">
                <label for="largo" class="form-label">Largo (mm)</label>
                <input type="number" step="0.01" class="form-control @error('Largo') is-invalid @enderror" id="largo" name="Largo" value="{{ old('Largo', $articulo->Largo) }}" placeholder="0">
                @error('Largo') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-6 col-md-3">
                <label for="ancho" class="form-label">Ancho (mm)</label>
                <input type="number" step="0.01" class="form-control @error('Ancho') is-invalid @enderror" id="ancho" name="Ancho" value="{{ old('Ancho', $articulo->Ancho) }}" placeholder="0">
                @error('Ancho') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-6 col-md-3">
                <label for="alto" class="form-label">Alto (mm)</label>
                <input type="number" step="0.01" class="form-control @error('Alto') is-invalid @enderror" id="alto" name="Alto" value="{{ old('Alto', $articulo->Alto) }}" placeholder="0">
                @error('Alto') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <button type="submit" class="btn btn-guardar rounded-1 mt-2 w-100 w-sm-auto">
                    <i class="fas fa-save me-1"></i> Actualizar
                </button>
            </div>
        </div>
    </form>
@endsection