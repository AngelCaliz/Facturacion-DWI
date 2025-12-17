@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Inventario de <span class="text-warning">Artículos</span></h1>
    <a href="{{ route('articulos.create') }}" class="btn btn-warning fw-bold text-dark">
        <i class="bi bi-box-seam"></i> Nuevo Artículo
    </a>
</div>

<div class="card shadow-sm border-0">
    <div class="card-body p-0">
        <table class="table table-hover align-middle mb-0">
            <thead class="bg-dark text-white">
                <tr>
                    <th class="ps-3">Código</th>
                    <th>Descripción</th>
                    <th>Categoría</th>
                    <th>Proveedor</th>
                    <th class="text-end">Costo</th>
                    <th class="text-end">Precio Venta</th>
                    <th class="text-center">Stock</th>
                    <th class="text-center">Estado</th>
                    <th class="text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($articulos as $art)
                    <tr>
                        <td class="ps-3"><small class="text-muted">#{{ $art->id_articulo }}</small></td>
                        <td class="fw-bold">{{ $art->descripcion }}</td>
                        <td><span class="badge bg-light text-dark border">{{ $art->tipoArticulo->descripcion_articulo ?? 'General' }}</span></td>
                        <td>{{ $art->proveedor->Nombre_comercial ?? 'N/A' }}</td>
                        <td class="text-end">S/. {{ number_format($art->precio_costo, 2) }}</td>
                        <td class="text-end fw-bold text-success">S/. {{ number_format($art->precio_venta, 2) }}</td>
                        <td class="text-center">
                            <span class="badge {{ $art->stock < 10 ? 'bg-danger' : 'bg-primary' }} rounded-pill px-3">
                                {{ $art->stock }}
                            </span>
                        </td>
                        <td class="text-center">
                            @if($art->stock > 0)
                                <span class="badge bg-success-subtle text-success border border-success">Disponible</span>
                            @else
                                <span class="badge bg-danger-subtle text-danger border border-danger">Agotado</span>
                            @endif
                        </td>

                        
                        <td class="text-center">
                            <a href="{{ route('articulos.edit', $art->id_articulo) }}" 
                               class="btn btn-sm btn-primary">
                                <i class="bi bi-pencil-square"></i>
                            </a>

                            <form action="{{ route('articulos.destroy', $art->id_articulo) }}" 
                                  method="POST"
                                  class="d-inline"
                                  onsubmit="return confirm('¿Deseas eliminar este artículo?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">
                                    <i class="bi bi-trash3-fill"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="9" class="text-center py-4 text-muted">No hay artículos en inventario.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection