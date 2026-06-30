@extends('layouts.index')

@section('page-title', 'Gestión de Personal')

@section('header-actions')
    <a href="{{ route('personal.create') }}" class="btn btn-success btn-sm flex-fill flex-sm-grow-0 text-center">
        <i class="fas fa-plus"></i> Nuevo Trabajador
    </a>
@endsection

@section('table-head')
    <th>Documento</th>
    <th>Nombres</th>
    <th>Apellidos</th>
    <th>Teléfono</th>
    <th>Acciones</th>
@endsection

@section('table-body')
    @forelse ($personal as $trabajador)
        <tr>
            <td class="fw-bold">{{ $trabajador->Codigo_Documento }}</td>
            <td>{{ $trabajador->Nombre_1 }} {{ $trabajador->Nombre_2 }}</td>
            <td>{{ $trabajador->Apellido_1 }} {{ $trabajador->Apellido_2 }}</td>
            <td>{{ $trabajador->telefono }}</td>
            <td>
                <a href="{{ route('personal.show', $trabajador->id) }}" class="btn action-btn btn-view" title="Ver">
                    <i class="fas fa-eye"></i>
                </a>
                <a href="{{ route('personal.edit', $trabajador->id) }}" class="btn action-btn btn-edit" title="Editar">
                    <i class="fas fa-pen"></i>
                </a>
                <form action="{{ route('personal.destroy', $trabajador->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('¿Estás seguro de que deseas eliminar a este trabajador?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn action-btn btn-delete" title="Eliminar">
                        <i class="fas fa-trash"></i> 
                    </button>
                </form>
            </td>
        </tr>
    @empty
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <div class="text-center text-muted">No hay personal registrado.</div>
    @endforelse
@endsection