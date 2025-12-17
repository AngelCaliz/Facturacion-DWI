@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Gestión de <span class="text-warning">Proveedores</span></h1>

    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('proveedores.create') }}" class="btn btn-warning fw-bold text-dark">
            <i class="bi bi-building-add"></i> Nuevo Proveedor
        </a>
    </div>
</div>

<div class="card shadow-sm border-0">
    <div class="card-body">

        {{-- BUSCADOR --}}
        <form action="{{ route('proveedores.index') }}" method="GET" class="row g-3 mb-4">
            <div class="col-md-10">
                <input type="text" name="busqueda" class="form-control"
                       placeholder="Buscar por Documento, Razón Social o Nombre Comercial..."
                       value="{{ request('busqueda') }}">
            </div>

            <div class="col-md-2">
                <button type="submit" class="btn btn-dark w-100">
                    <i class="bi bi-search"></i> Buscar
                </button>
            </div>
        </form>

        {{-- TABLA --}}
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="bg-dark text-white">
                    <tr>
                        <th class="ps-3">Documento</th>
                        <th>Razón Social</th>
                        <th>Nombre Comercial</th>
                        <th>Contacto</th>
                        <th>Ubicación</th>
                        <th>Acciones</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($proveedores as $prov)
                        <tr>
                            <td class="ps-3 fw-bold">{{ $prov->No_documento }}</td>

                            <td>{{ $prov->Nombre }} {{ $prov->Apellido }}</td>

                            <td>
                                <span class="badge bg-light text-dark border">
                                    {{ $prov->Nombre_comercial }}
                                </span>
                            </td>

                            <td>
                                <i class="bi bi-telephone-fill text-muted"></i>
                                {{ $prov->Telefono }}
                            </td>

                            <td>
                                {{ $prov->ciudad->Nombre_ciudad ?? 'Sin ciudad' }} <br>
                                <small class="text-muted">{{ $prov->direccion }}</small>
                            </td>

                            <td>
                                {{-- Editar --}}
                                <a href="{{ route('proveedores.edit', $prov->No_documento) }}"
                                   class="btn btn-sm btn-outline-dark" title="Editar">
                                    <i class="bi bi-pencil"></i>
                                </a>

                                {{-- Eliminar --}}
                                <form action="{{ route('proveedores.destroy', $prov->No_documento) }}"
                                      method="POST" class="d-inline"
                                      onsubmit="return confirm('¿Eliminar este proveedor?')">
                                    @csrf
                                    @method('DELETE')

                                    <button class="btn btn-sm btn-outline-danger" title="Eliminar">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">
                                No hay proveedores registrados.
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
        </div>
    </div>
</div>
@endsection