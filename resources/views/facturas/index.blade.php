@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Historial de Ventas</h1>
    <a href="{{ route('facturas.create') }}" class="btn btn-warning fw-bold">
        <i class="bi bi-plus-circle-fill"></i> Nueva Venta
    </a>
</div>

<div class="card shadow-sm border-0">
    <div class="card-body p-0">
        {{-- Mensajes de Notificación (success/error) --}}
        @if (session('success'))
            <div class="alert alert-success m-3">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger m-3">{{ session('error') }}</div>
        @endif
        
        <table class="table table-hover align-middle mb-0">
            <thead class="bg-dark text-white">
                <tr>
                    <th class="ps-4"># Factura</th>
                    <th>Fecha</th>
                    <th>Cliente</th>
                    <th>Vendedor</th>
                    <th class="text-end">Total</th>
                    <th class="text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($facturas as $fac)
                    <tr>
                        <td class="ps-4 fw-bold text-primary">{{ $fac->Num_factura }}</td>
                        <td>{{ $fac->Fecha_facturacion }}</td>
                        <td>
                            {{ $fac->cliente->Nombres ?? 'Anónimo' }} {{ $fac->cliente->Apellidos ?? '' }}
                            <br><small class="text-muted">{{ $fac->cod_cliente }}</small>
                        </td>
                        <td><span class="badge bg-light text-dark border">{{ $fac->Nombre_empleado }}</span></td>
                        <td class="text-end fw-bold">S/. {{ number_format($fac->total_factura, 2) }}</td>
                        
                        {{-- 🚨 Columna de ACCIONES FUNCIONALES 🚨 --}}
                        <td class="text-center">
                            
                            {{-- 1. VISUALIZAR DETALLE (Ojo: bi-eye) --}}
                            <a href="{{ route('facturas.show', $fac->Num_factura) }}" class="btn btn-sm btn-outline-dark" title="Visualizar Detalle">
                                <i class="bi bi-eye"></i>
                            </a>

                            {{-- 2. ELIMINAR FACTURA (Papelera: bi-trash) --}}
                            <form action="{{ route('facturas.destroy', $fac->Num_factura) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE') 
                                <button type="submit" class="btn btn-sm btn-outline-danger" 
                                        title="Eliminar Factura"
                                        onclick="return confirm('¿Está seguro de eliminar la Factura #{{ $fac->Num_factura }}? El stock de los artículos será revertido.')">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">
                            <i class="bi bi-receipt fs-1 d-block mb-2 opacity-50"></i>
                            No hay ventas registradas aún.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection