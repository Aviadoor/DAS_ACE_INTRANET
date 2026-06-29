@extends('layouts.create')

@section('page-title', 'Crear Nuevo Permiso')
@section('back-url', route('permiso.index'))

@section('form-content')
<form action="{{ route('permiso.store') }}" method="POST">
    @csrf

    <div class="row g-3 mb-4">
        <div class="col-12 col-md-6">
            <label for="Nombre" class="form-label fw-bold">Nombre del Permiso</label>
            <input type="text" 
                class="form-control @error('Nombre') is-invalid @enderror" 
                id="Nombre" 
                name="Nombre" 
                value="{{ old('Nombre') }}" 
                placeholder="Ej: Crear Usuarios" 
                required>
            @error('Nombre')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="col-12 col-md-6">
            <label for="Slug" class="form-label fw-bold">Llave / Slug</label>
            <input type="text" 
                class="form-control @error('Slug') is-invalid @enderror" 
                id="Slug" 
                name="Slug" 
                value="{{ old('Slug') }}" 
                placeholder="Ej: crear-usuarios" 
                required>
            @error('Slug')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-12">
            <label for="Descripcion" class="form-label fw-bold">Descripción</label>
            <textarea class="form-control @error('Descripcion') is-invalid @enderror" 
                    id="Descripcion" 
                    name="Descripcion" 
                    rows="3" 
                    style="resize: none;" 
                    placeholder="Describe brevemente la función de este permiso...">{{ old('Descripcion') }}</textarea>
            @error('Descripcion')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="row g-3 mb-4 border rounded p-3 bg-light shadow-sm mx-0">
        <div class="col-12">
            <div class="form-check form-switch fs-5 mb-0">
                <input class="form-check-input" type="checkbox" role="switch" id="Habilitado" name="Habilitado" value="1" {{ old('Habilitado', true) ? 'checked' : '' }}>
                <label class="form-check-label ms-2 text-dark fw-semibold" for="Habilitado" style="font-size: 1rem;">
                    Permiso Habilitado
                </label>
            </div>
            <small class="text-muted">Si se desactiva, los usuarios con este permiso perderán el acceso correspondiente.</small>
        </div>
    </div>

    <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Guardar</button>
    </div>
</form>
@endsection