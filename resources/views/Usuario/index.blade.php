@extends('layouts.index')

@section('page-title', 'Usuarios')

@section('header-actions')
    <a href="{{ route('usuario.create') }}" class="btn btn-success btn-sm flex-fill flex-sm-grow-0 text-center">
        <i class="fas fa-plus"></i> Nuevo Usuario
    </a>
@endsection

@section('table-head')
    <th>Username</th>
    <th>Email</th>
    <th>Persona</th>
    <th>Roles</th>
    <th>Estado</th>
    <th>Acciones</th>
@endsection

@section('table-body')
    @forelse ($usuarios as $usuario)
        <div hidden>{{ $usuario->id }}</div>
        <tr>
            <td>{{ $usuario->Username}}</td>
            <td>{{ $usuario->Email}}</td>
            <td>{{ $usuario->persona->Nombre_1 . ' ' . $usuario->persona->Apellido_1}}</td>
            <td>
                @php
                    $Roles = [];
                    foreach ($usuario->roles as $rol) {
                        array_push($Roles, $rol->Rol);
                    }
                @endphp
                {{ implode(', ', $Roles) ?? 'Sin roles' }}
            </td>
            <td>{{ $usuario->Habilitado ? 'Activo' : 'Desactivado'}}</td>
            <td>
                <a href="{{ route('usuario.edit', $usuario->id) }}" class="btn action-btn btn-edit" title="Editar">
                    <i class="fas fa-pen"></i>
                </a>
                <form action="{{ route('usuario.destroy', $usuario->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('¿Estás seguro de que deseas eliminar este usuario?');">
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
            <td colspan="8" class="text-center text-muted">No hay usuarios registrados.</td>
        </tr>
    @endforelse
@endsection