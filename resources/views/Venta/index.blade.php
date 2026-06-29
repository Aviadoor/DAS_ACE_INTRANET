@extends('layouts.index')

{{-- Título de la vista --}}
@section('page-title', 'Lista de Ventas')

{{-- Botones superiores --}}
@section('header-actions')
    <a href="{{ route('venta.create') }}" class="btn btn-success btn-sm flex-fill flex-sm-grow-0 text-center">
        <i class="fas fa-plus"></i> Nueva venta
    </a>
@endsection

{{-- Cabeceras de la tabla --}}
@section('table-head')
    <th>Cliente</th>
    <th>Fecha Emision</th>
    <th>Fecha Entrega</th>
    <th>Vendedor</th>
    <th>Total</th>
    <th>Acciones</th>
@endsection

{{-- Cuerpo de la tabla --}}
@section('table-body')
    @forelse ($ventas as $venta)
        <tr>
            <td>{{ $venta->Nombre_Cliente }}</td>
            <td>{{ $venta->Fecha_Emision }}</td>
            <td>{{ $venta->Fecha_Entrega }}</td>
            <td>{{ $venta->personal->Nombre_1 }}</td>
            <td>{{ $venta->Total }}</td>
            <td>
                <a href="{{ route('venta.show', $venta->id) }}" class="btn action-btn btn-view" title="Ver">
                    <i class="fas fa-eye"></i>
                </a>
                <a href="{{ route('venta.edit', $venta->id) }}" class="btn action-btn btn-edit" title="Editar">
                    <i class="fas fa-pen"></i>
                </a>
                <form action="{{ route('venta.destroy', $venta->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('¿Estás seguro de que deseas eliminar este artículo?');">
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
            <td colspan="6" class="text-center text-muted">No hay ventas registradas.</td>
        </tr>
    @endforelse
@endsection