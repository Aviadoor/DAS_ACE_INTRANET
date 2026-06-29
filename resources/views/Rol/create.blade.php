@extends('layouts.create')

@section('page-title', 'Crear Nuevo Rol')
@section('back-url', route('rol.index'))

@section('form-content')
<form action="{{ route('rol.store') }}" method="POST">
    @csrf

    <div class="row g-3 mb-4">
        <div class="col-12">
            <label for="Rol" class="form-label fw-bold">Nombre del Rol</label>
            <input type="text" 
                class="form-control @error('Rol') is-invalid @enderror" 
                id="Rol" 
                name="Rol" 
                value="{{ old('Rol') }}" 
                placeholder="Ej: Administrador, Supervisor, Caja..." 
                required>
            @error('Rol')
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
                    placeholder="Describe brevemente las responsabilidades o funciones de este rol...">{{ old('Descripcion') }}</textarea>
            @error('Descripcion')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-dark text-white py-3">
            <h5 class="card-title mb-0" style="font-size: 1rem;">
                <i class="fas fa-key me-2 text-info"></i> Asignar Permisos al Rol
            </h5>
        </div>
        <div class="card-body bg-light">
            <p class="text-muted small mb-3">Selecciona uno o más permisos que tendrá este rol dentro del sistema:</p>
            
            <div class="row g-3">
                @forelse($permisos as $permiso)
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="form-check p-3 bg-white border rounded shadow-sm h-100 d-flex align-items-center">
                            <input class="form-check-input ms-0 me-2" 
                                type="checkbox" 
                                name="permisos[]" 
                                value="{{ $permiso->id }}" 
                                id="permiso_{{ $permiso->id }}"
                                {{ is_array(old('permisos')) && in_array($permiso->id, old('permisos')) ? 'checked' : '' }}>
                            
                            <label class="form-check-label text-dark fw-semibold" for="permiso_{{ $permiso->id }}" style="cursor: pointer; font-size: 0.9rem;">
                                {{ $permiso->Nombre }}
                                @if($permiso->Slug)
                                    <br><span class="badge bg-secondary font-monospace" style="font-size: 0.75rem;">{{ $permiso->Slug }}</span>
                                @endif
                            </label>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center text-muted py-3">
                        <i class="fas fa-info-circle me-1"></i> No hay permisos registrados en el sistema.
                    </div>
                @endforelse
            </div>
            
            @error('permisos')
                <div class="text-danger small mt-2 d-block">
                    <i class="fas fa-exclamation-circle me-1"></i> {{ $message }}
                </div>
            @enderror
        </div>
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-primary" id="btnGuardarPersonal">Guardar</button>
    </div>
</form>
@endsection