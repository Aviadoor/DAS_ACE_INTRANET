@extends('layouts.index')

{{-- Título de la vista --}}
@section('page-title', 'Lista de Artículos')

{{-- Botones superiores --}}
@section('header-actions')
    <a href="{{ route('inventario.create') }}" class="btn btn-success btn-sm flex-fill flex-sm-grow-0 text-center">
        <i class="fas fa-plus"></i> Nuevo item
    </a>
@endsection

{{-- Cabeceras de la tabla --}}
@section('table-head')
    <th>Modelo</th>
    <th class="text-start">Descripción</th>
    <th>Costo</th>
    <th>PrecioVenta</th>
    <th>Stock</th>
    <th>Acciones</th>
@endsection

{{-- Cuerpo de la tabla --}}
@section('table-body')
    @forelse ($articulos as $articulo)
        <tr>
            <td>{{ $articulo->Modelo }}</td>
            <td class="text-start">{{ $articulo->Descripcion }}</td>
            <td>{{ number_format($articulo->Costo, 2) }}</td>
            <td>{{ number_format($articulo->PrecioVenta, 2) }}</td>
            <td class="{{ $articulo->Stock <= 0 ? 'text-danger fw-bold' : '' }}">
                {{ $articulo->Stock }}
            </td>
            <td>
                <a href="{{ route('inventario.show', $articulo->id) }}" class="btn action-btn btn-view" title="Ver">
                    <i class="fas fa-eye"></i>
                </a>
                <a href="{{ route('inventario.edit', $articulo->id) }}" class="btn action-btn btn-edit" title="Editar">
                    <i class="fas fa-pen"></i>
                </a>
                <form action="{{ route('inventario.destroy', $articulo->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('¿Estás seguro de que deseas eliminar esta venta?');">
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
        <div class="text-center text-muted">No hay articulos registrados.</div>
    @endforelse
@endsection