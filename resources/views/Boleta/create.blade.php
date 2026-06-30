@extends('layouts.create')

@section('page-title', 'Nueva Boleta')
@section('back-url', route('boleta.index'))

@section('form-content')
    <form action="{{ route('boleta.store') }}" method="POST">
        @csrf     
        <div class="col-12 col-md-6">
            <div class="d-flex justify-content-between align-items-center">
                <label for="fk_id_personal" class="form-label mb-0">Personal</label>
                <button type="button" class="btn btn-sm btn-link p-0 text-decoration-none" data-bs-toggle="modal" data-bs-target="#modalCrearPersonal">
                    <i class="fas fa-plus-circle me-1"></i> Agregar nuevo personal
                </button>
            </div>
            <select class="form-control @error('fk_id_personal') is-invalid @enderror" id="fk_id_personal" name="fk_id_personal">
                <option value="">Seleccione un empleado</option>
                @foreach($personas as $persona)
                    <option value="{{ $persona->id }}">{{ $persona->Codigo_Documento }} - {{ $persona->Nombre_1 }} {{ $persona->Apellido_1 }}</option>
                @endforeach
            </select>
            @error('fk_id_personal') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="row g-3 mb-3">
            <div class="col-12 col-md-6">
                <label for="Fecha_Inicio" class="form-label">Fecha de Inicio</label>
                <input type="date" class="form-control @error('Fecha_Incio') is-invalid @enderror" id="Fecha_Inicio" name="Fecha_Inicio" value="{{ old('Fecha_Inicio') }}" placeholder="0">
                @error('Fecha_Inicio') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-12 col-md-6">
                <label for="Dias_Laborados" class="form-label">Días Laborados</label>
                <input type="number" class="form-control @error('Dias_Laborados') is-invalid @enderror" id="Dias_Laborados" name="Dias_Laborados" value="{{ old('Dias_Laborados') }}" placeholder="0">
                @error('Dias_Laborados') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-12 col-md-6">
                <label for="Total_Horas" class="form-label">Total de Horas</label>
                <input type="number" step="0.5" class="form-control @error('Total_Horas') is-invalid @enderror" id="Total_Horas" name="Total_Horas" value="{{ old('Total_Horas') }}" placeholder="0">
                @error('Total_Horas') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
        </div>

        <div class="row g-3 mb-4">
            <div class="col-12 col-md-4">
                <label for="Sueldo_Bruto" class="form-label">Sueldo Bruto</label>
                <input type="number" step="0.01" class="form-control @error('Sueldo_Bruto') is-invalid @enderror" id="Sueldo_Bruto" name="Sueldo_Bruto" value="{{ old('Sueldo_Bruto') }}" placeholder="0.00">
                @error('Sueldo_Bruto') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-12 col-md-4">
                <label for="Prima_Seguro" class="form-label">Prima de Seguro</label>
                <input type="number" step="0.01" class="form-control @error('Prima_Seguro') is-invalid @enderror" id="Prima_Seguro" name="Prima_Seguro" value="{{ old('Prima_Seguro') }}" placeholder="0.00">
                @error('Prima_Seguro') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-12 col-md-4">
                <label for="Sueldo_Neto" class="form-label">Sueldo Neto</label>
                <input type="number" step="0.01" class="form-control @error('Sueldo_Neto') is-invalid @enderror" id="Sueldo_Neto" name="Sueldo_Neto" value="{{ old('Sueldo_Neto') }}" placeholder="0.00">
                @error('Sueldo_Neto') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <button type="submit" class="btn btn-guardar rounded-1 mt-2 w-100 w-sm-auto">
                    <i class="fas fa-save me-1"></i> Guardar
                </button>
            </div>
        </div>
    </form>

    <div class="modal fade" id="modalCrearPersonal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Agregar Nuevo Personal</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="formNuevoPersonal" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label>Primer Nombre</label>
                            <input type="text" name="Nombre_1" class="form-control" required>
                            <label>Segundo Nombre</label>
                            <input type="text" name="Nombre_2" class="form-control">
                            <label>Primer Apellido</label>
                            <input type="text" name="Apellido_1" class="form-control" required>
                            <label>Segundo Apellido</label>
                            <input type="text" name="Apellido_2" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label>Telefono</label>
                            <input type="text" name="Telefono" class="form-control" required>
                        </div>
                        <div class="col-12 col-md-6">
                            <label for="fk_id_unidad" class="form-label">Tipo de Documento</label>
                            <select class="form-control @error('fk_id_tipo_documento') is-invalid @enderror" id="fk_id_tipo_documento" name="fk_id_tipo_documento">
                                <option value="">Seleccione un Documento</option>
                                @foreach($tipos_documentos as $documento)
                                    <option value="{{ $documento->id }}">
                                        {{ $documento->Documento }}
                                    </option>
                                @endforeach
                            </select>
                            @error('fk_id_tipo_documento') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="mb-3">
                            <label>Numero de Documento</label>
                            <input type="text" name="Codigo_Documento" class="form-control" required>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" id="btnGuardarPersonal">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<script>
document.getElementById('btnGuardarPersonal').addEventListener('click', function(e) {
    // 1. Obtener el formulario
    let form = document.getElementById('formNuevoPersonal');
    let formData = new FormData(form);
    
    // 2. Realizar la petición fetch
    fetch("{{ route('personal.store') }}", {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        }
    })
    .then(response => {
        if (!response.ok) {
            return response.json().then(err => { throw err; });
        }
        return response.json();
    })
    .then(data => {
        // A. Agregar al select
        let select = document.getElementById('fk_id_personal');
        let option = document.createElement('option');
        option.value = data.id;
        option.text = data.Codigo_Documento + ' - ' + data.Nombre_1;
        option.selected = true;
        select.add(option);
        
        // B. Cerrar modal
        let modalEl = document.getElementById('modalCrearPersonal');
        let modal = bootstrap.Modal.getInstance(modalEl);
        modal.hide();
        
        // C. Limpiar form
        form.reset();
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Hubo un error al guardar. Revisa los campos.');
    });
});
</script>
@endsection
