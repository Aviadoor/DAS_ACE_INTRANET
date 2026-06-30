@extends('layouts.index')

{{-- Título de la vista --}}
@section('page-title', 'Permisos')

{{-- Botones superiores --}}
@section('header-actions')
    <a href="{{ route('permiso.create') }}" class="btn btn-success btn-sm flex-fill flex-sm-grow-0 text-center">
        <i class="fas fa-plus"></i> Nuevo permiso
    </a>
@endsection

{{-- Cabeceras de la tabla --}}
@section('table-head')
    <th>Nombre</th>
    <th>Slug</th>
    <th>Descripción</th>
    <th>Estado</th>
    <th>Acciones</th>
@endsection

{{-- Cuerpo de la tabla --}}
@section('table-body')
    @forelse ($permisos as $permiso)
        <tr>
            <td class="fw-bold">{{ $permiso->Nombre }}</td>
            <td><span class="badge bg-secondary">{{ $permiso->Slug }}</span></td>
            <td>{{ strlen($permiso->Descripcion) > 50 ? substr($permiso->Descripcion, 0, 50) . '...' : $permiso->Descripcion }}</td>
            <td>
                @if($permiso->Habilitado)
                    <span class="badge bg-success">Activo</span>
                @else
                    <span class="badge bg-danger">Inactivo</span>
                @endif
            </td>
            <td>
                <a href="{{ route('permiso.show', $permiso->id) }}" class="btn action-btn btn-view" title="Ver">
                    <i class="fas fa-eye"></i>
                </a>
                <a href="{{ route('permiso.edit', $permiso->id) }}" class="btn action-btn btn-edit" title="Editar">
                    <i class="fas fa-pen"></i>
                </a>
                <form action="{{ route('permiso.destroy', $permiso->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('¿Estás seguro de que deseas eliminar este permiso?');">
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
        <div class="text-center text-muted">No hay permisos registrados.</div>
    @endforelse
@endsection