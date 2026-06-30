@extends('layouts.index')

{{-- Título de la vista --}}
@section('page-title', 'Lista de Boletas')

{{-- Botones superiores --}}
@section('header-actions')
    <a href="{{ route('boleta.create') }}" class="btn btn-success btn-sm flex-fill flex-sm-grow-0 text-center">
        <i class="fas fa-plus"></i> Nueva Boleta
    </a>
@endsection

{{-- Cabeceras de la tabla --}}
@section('table-head')
    <th>Personal</th>
    <th>Días Lab.</th>
    <th>Total Horas</th>
    <th>Fecha Inicio</th>
    <th>Prima Seguro</th>
    <th>Sueldo Neto</th>
    <th>Acciones</th>
@endsection

{{-- Cuerpo de la tabla --}}
@section('table-body')
    @forelse ($boletas as $boleta)
    <div hidden>{{ $boleta->id_fk_personal ?? null }}</div>
        <tr>
            <td>{{ $boleta->personal?->Nombre_1 ?? 'Sin personal' }}</td>
            <td>{{ $boleta->Dias_Laborados }}</td>
            <td>{{ $boleta->Total_Horas }}</td>
            <td>{{ $boleta->Fecha_Inicio }}</td>
            
            <td>{{ number_format($boleta->Prima_Seguro, 2) }}</td>
            <td class="text-success fw-bold">{{ number_format($boleta->Sueldo_Neto, 2) }}</td>
            
            <td>
                <a href="{{ route('boleta.show', $boleta->id) }}" class="btn action-btn btn-view" title="Ver">
                    <i class="fas fa-eye"></i>
                </a>
                <a href="{{ route('boleta.edit', $boleta->id) }}" class="btn action-btn btn-edit" title="Editar">
                    <i class="fas fa-pen"></i>
                </a>
                <form action="{{ route('boleta.destroy', $boleta->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('¿Estás seguro de que deseas eliminar esta boleta?');">
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
            <td></td>
            <td></td>
        </tr>
        <div class="text-center text-muted">No hay ventas boletas registradas.</div>
    @endforelse
@endsection