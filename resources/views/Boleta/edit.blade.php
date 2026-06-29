@extends('layouts.edit')

@section('page-title', 'Editar Boleta')
@section('back-url', route('boleta.index'))

@section('form-content')
    <form action="{{ route('boleta.update', $boleta->id) }}" method="POST">
        @csrf
        @method('PUT') 
        
        <div class="row g-3 mb-3">
            <div class="col-12 col-md-6">
                <label for="fk_id_personal" class="form-label">Personal</label>
                <select class="form-control @error('fk_id_personal') is-invalid @enderror" id="fk_id_personal" name="fk_id_personal">
                    <option value="">Seleccione un empleado</option>
                    @foreach($personas as $persona)
                        <option value="{{ $persona->id }}" {{ $id_persona == $persona->id ? 'selected' : '' }}>
                            {{ $persona->Codigo_Documento}} - {{ $persona->Nombre_1 }} {{ $persona->Apellido_1 }}
                        </option>
                    @endforeach
                </select>
                @error('fk_id_personal') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-12 col-md-6">
                <label for="Fecha_Inicio" class="form-label">Fecha de Inicio</label>
                <input type="date" class="form-control @error('Fecha_Inicio') is-invalid @enderror" id="Fecha_Inicio" name="Fecha_Inicio" value="{{ old('Fecha_Inicio', $boleta->Fecha_Inicio) }}">
                @error('Fecha_Inicio') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
        </div>

        <div class="row g-3 mb-3">
            <div class="col-12 col-md-6">
                <label for="Dias_Laborados" class="form-label">Días Laborados</label>
                <input type="number" class="form-control @error('Dias_Laborados') is-invalid @enderror" id="Dias_Laborados" name="Dias_Laborados" value="{{ old('Dias_Laborados', $boleta->Dias_Laborados) }}" placeholder="0">
                @error('Dias_Laborados') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-12 col-md-6">
                <label for="Total_Horas" class="form-label">Total de Horas</label>
                <input type="number" step="0.5" class="form-control @error('Total_Horas') is-invalid @enderror" id="Total_Horas" name="Total_Horas" value="{{ old('Total_Horas', $boleta->Total_Horas) }}" placeholder="0">
                @error('Total_Horas') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
        </div>

        <div class="row g-3 mb-4">
            <div class="col-12 col-md-4">
                <label for="Sueldo_Bruto" class="form-label">Sueldo Bruto</label>
                <input type="number" step="0.01" class="form-control @error('Sueldo_Bruto') is-invalid @enderror" id="Sueldo_Bruto" name="Sueldo_Bruto" value="{{ old('Sueldo_Bruto', $boleta->Sueldo_Bruto) }}" placeholder="0.00">
                @error('Sueldo_Bruto') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-12 col-md-4">
                <label for="Prima_Seguro" class="form-label">Prima de Seguro</label>
                <input type="number" step="0.01" class="form-control @error('Prima_Seguro') is-invalid @enderror" id="Prima_Seguro" name="Prima_Seguro" value="{{ old('Prima_Seguro', $boleta->Prima_Seguro) }}" placeholder="0.00">
                @error('Prima_Seguro') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-12 col-md-4">
                <label for="Sueldo_Neto" class="form-label">Sueldo Neto</label>
                <input type="number" step="0.01" class="form-control @error('Sueldo_Neto') is-invalid @enderror" id="Sueldo_Neto" name="Sueldo_Neto" value="{{ old('Sueldo_Neto', $boleta->Sueldo_Neto) }}" placeholder="0.00">
                @error('Sueldo_Neto') <div class="invalid-feedback">{{ $message }}</div> @enderror
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