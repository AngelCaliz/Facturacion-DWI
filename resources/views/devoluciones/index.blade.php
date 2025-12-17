@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Devoluciones Registradas</h1>
    <a href="{{ route('devoluciones.create') }}" class="btn btn-danger">
        <i class="bi bi-arrow-return-left"></i> Nueva Devolución
    </a>
</div>

<div class="card shadow-sm border-0">
    <div class="card-body">
        <table class="table table-hover">
            <thead class="table-light">
                <tr>
                    <th>Fecha</th>
                    <th>Factura Origen</th>
                    <th>Artículo</th>
                    <th>Motivo</th>
                    <th class="text-center">Cant. Devuelta</th>
                </tr>
            </thead>
            <tbody>
                @forelse($devoluciones as $dev)
                    <tr>
                        <td>{{ $dev->Fecha_devolucion }}</td>
                        <td><a href="#" class="text-decoration-none fw-bold">#{{ $dev->cod_detallefactura }}</a></td>
                        <td>{{ $dev->articuloDevuelto->descripcion ?? 'Artículo eliminado' }}</td>
                        <td><span class="badge bg-warning text-dark">{{ $dev->Motivo }}</span></td>
                        <td class="text-center fw-bold text-danger">- {{ $dev->cantidad }}</td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center py-4">No hay devoluciones.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection