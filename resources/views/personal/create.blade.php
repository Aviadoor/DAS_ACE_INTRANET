@extends('layouts.create')

@section('page-title', 'Registrar Nuevo Trabajador')
@section('back-url', route('personal.index'))

@section('form-content')
<form action="{{ route('personal.store') }}" method="POST" id="formPersonal">
    @csrf

    <div class="row g-3 mb-4">
        <div class="col-12">
            <label for="Nombre_1" class="form-label fw-bold">Primer Nombre <span class="text-danger">*</span></label>
            <input type="text" class="form-control  @error('Nombre_1') is-invalid @enderror" id="Nombre_1" name="Nombre_1">
            @error('Nombre_1') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
        <div class="col-12">
            <label for="Nombre_2" class="form-label fw-bold">Segundo Nombre</label>
            <input type="text" class="form-control  @error('Nombre_2') is-invalid @enderror" id="Nombre_2" name="Nombre_2">
            @error('Nombre_2') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
        <div class="col-12">
            <label for="Apellido_1" class="form-label fw-bold">Primer Apellido <span class="text-danger">*</span></label>
            <input type="text" class="form-control  @error('Apellido_1') is-invalid @enderror" id="Apellido_1" name="Apellido_1">
            @error('Apellido_1') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
        <div class="col-12">
            <label for="Apellido_2" class="form-label fw-bold">Segundo Apellido</label>
            <input type="text" class="form-control  @error('Apellido_2') is-invalid @enderror" id="Apellido_2" name="Apellido_2">
            @error('Apellido_2') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
    </div>

    <hr class="my-4">

    <div class="row g-3 mb-4">
        <div class="col-12 col-md-4">
            <label for="fk_id_tipo_documento" class="form-label fw-bold">Tipo Documento <span class="text-danger">*</span></label>
            <select class="form-select" id="fk_id_tipo_documento" name="fk_id_tipo_documento">
                <option value="">Seleccione...</option>
                @foreach($tiposDocumentos as $tipo)
                    <option value="{{ $tipo->id }}">{{ $tipo->Documento }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-12 col-md-4">
            <label for="Codigo_Documento" class="form-label fw-bold">N° de Documento <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="Codigo_Documento" name="Codigo_Documento">
        </div>
        
        <div class="col-12 col-md-4">
            <label for="Telefono" class="form-label fw-bold">Teléfono <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="Telefono" name="Telefono">
        </div>
    </div>

    <div id="error-container" class="alert alert-danger d-none mb-3"></div>

    <div class="modal-footer">
        <button type="submit" class="btn btn-primary" id="btnGuardar">Guardar Trabajador</button>
    </div>
</form>

@push('scripts')
<script>
    document.getElementById('formPersonal').addEventListener('submit', function(e) {
        e.preventDefault(); // Evita que la página recargue mostrando el JSON crudo
        
        let form = this;
        let submitBtn = document.getElementById('btnGuardar');
        let errorContainer = document.getElementById('error-container');
        let formData = new FormData(form);
        
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Guardando...';
        errorContainer.classList.add('d-none');
        errorContainer.innerHTML = '';

        fetch(form.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(response => {
            if (!response.ok) throw response;
            return response.json();
        })
        .then(data => {
            if (data.id) {
                window.location.href = "{{ route('personal.index') }}"; 
            }
        })
        .catch(async error => {
            submitBtn.disabled = false;
            submitBtn.innerHTML = 'Guardar Trabajador';
            
            if (error.status === 422) {
                let errData = await error.json();
                let errorsHTML = '<ul class="mb-0">';
                for (let field in errData.errors) {
                    errorsHTML += `<li>${errData.errors[field][0]}</li>`;
                }
                errorsHTML += '</ul>';
                errorContainer.innerHTML = errorsHTML;
                errorContainer.classList.remove('d-none');
            } else {
                alert('Ocurrió un error inesperado al guardar.');
            }
        });
    });
</script>
@endpush
@endsection