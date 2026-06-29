@extends('layouts.index')

{{-- Título de la vista --}}
@section('page-title', 'Roles')

{{-- Botones superiores --}}
@section('header-actions')
    <a href="{{ route('rol.create') }}" class="btn btn-success btn-sm flex-fill flex-sm-grow-0 text-center">
        <i class="fas fa-plus"></i> Nuevo rol
    </a>
@endsection

{{-- Cabeceras de la tabla --}}
@section('table-head')
    <th>Rol</th>
    <th>Descripcion</th>
    <th>Acciones</th>
@endsection

{{-- Cuerpo de la tabla --}}
@section('table-body')
    @forelse ($roles as $rol)
    <div hidden>{{ $rol->id }}</div>
        <tr>
            <td>{{ $rol->Rol }}</td>
            <td>{{ $rol->Descripcion }}</td>
            <td>
                <a href="{{ route('rol.show', $rol->id) }}" class="btn action-btn btn-view" title="Ver">
                    <i class="fas fa-eye"></i>
                </a>
                <a href="{{ route('rol.edit', $rol->id) }}" class="btn action-btn btn-edit" title="Editar">
                    <i class="fas fa-pen"></i>
                </a>
                <form action="{{ route('rol.destroy', $rol->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('¿Estás seguro de que deseas eliminar este rol?');">
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
            <td colspan="8" class="text-center text-muted">No hay roles registrados.</td>
        </tr>
    @endforelse
@endsection