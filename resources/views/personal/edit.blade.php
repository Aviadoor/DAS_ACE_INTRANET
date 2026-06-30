@extends('layouts.edit')

@section('page-title', 'Editar Trabajador')
@section('back-url', route('personal.index'))

@section('form-content')

<form action="{{ route('personal.update', $personal->id) }}" method="POST" id="formPersonalEdit">
    @csrf
    @method('PUT')

    <div class="row g-3 mb-4">
        <div class="col-12">
            <label for="Nombre_1" class="form-label fw-bold">Primer Nombre <span class="text-danger">*</span></label>
            <input type="text" class="form-control  @error('Nombre_1') is-invalid @enderror" id="Nombre_1" name="Nombre_1" value="{{ $personal->Nombre_1 }}">
            @error('Nombre_1') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
        <div class="col-12">
            <label for="Nombre_2" class="form-label fw-bold">Segundo Nombre</label>
            <input type="text" class="form-control  @error('Nombre_2') is-invalid @enderror" id="Nombre_2" name="Nombre_2" value="{{ $personal->Nombre_2 }}">
            @error('Nombre_2') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
        <div class="col-12">
            <label for="Apellido_1" class="form-label fw-bold">Primer Apellido <span class="text-danger">*</span></label>
            <input type="text" class="form-control  @error('Apellido_1') is-invalid @enderror" id="Apellido_1" name="Apellido_1" value="{{ $personal->Apellido_1 }}">
            @error('Apellido_1') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
        <div class="col-12">
            <label for="Apellido_2" class="form-label fw-bold">Segundo Apellido</label>
            <input type="text" class="form-control  @error('Apellido_2') is-invalid @enderror" id="Apellido_2" name="Apellido_2" value="{{ $personal->Apellido_2 }}">
            @error('Apellido_2') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
    </div>

    <hr class="my-4">

    <div class="row g-3 mb-4">
        <div class="col-12 col-md-4">
            <label for="fk_id_tipo_documento" class="form-label fw-bold">Tipo Documento <span class="text-danger">*</span></label>
            <select class="form-select" id="fk_id_tipo_documento" name="fk_id_tipo_documento" required>
                @foreach($tiposDocumentos as $tipo)
                    <option value="{{ $tipo->id }}" {{ $personal->fk_id_tipo_documento == $tipo->id ? 'selected' : '' }}>
                        {{ $tipo->Documento }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-12 col-md-4">
            <label for="Codigo_Documento" class="form-label fw-bold">N° de Documento <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="Codigo_Documento" name="Codigo_Documento" value="{{ $personal->Codigo_Documento }}" required>
        </div>
        
        <div class="col-12 col-md-4">
            <label for="Telefono" class="form-label fw-bold">Teléfono <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="Telefono" name="Telefono" value="{{ $personal->telefono }}" required>
        </div>
    </div>

    <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
    </div>
</form>
@endsection