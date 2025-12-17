@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Gestión de <span class="text-warning">Clientes</span></h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('clientes.create') }}" class="btn btn-warning fw-bold text-dark">
            <i class="bi bi-person-plus"></i> Nuevo Cliente
        </a>
    </div>
</div>

<div class="card shadow-sm border-0">
    <div class="card-body">
        <form action="{{ route('clientes.index') }}" method="GET" class="row g-3 mb-4">
            <div class="col-md-10">
                <input type="text" name="busqueda" class="form-control" placeholder="Buscar por Documento, Nombre o Apellido..." value="{{ request('busqueda') }}">
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-dark w-100">
                    <i class="bi bi-search"></i> Buscar
                </button>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="bg-dark text-white">
                    <tr>
                        <th class="ps-3">Documento</th>
                        <th>Nombres y Apellidos</th>
                        <th>Dirección</th>
                        <th>Ciudad</th>
                        <th>Teléfono</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($clientes as $cliente)
                        <tr>
                            <td class="ps-3 fw-bold">{{ $cliente->Documento }}</td>
                            <td>{{ $cliente->Nombres }} {{ $cliente->Apellidos }}</td>
                            <td>{{ $cliente->Direccion }}</td>
                            <td><span class="badge bg-light text-dark border">{{ $cliente->ciudad->Nombre_ciudad ?? 'Sin ciudad' }}</span></td>
                            <td>{{ $cliente->Telefono }}</td>
                            {{-- Dentro de tu tabla, en la columna Acciones --}}
<td>
    {{-- 1. EDITAR (Lápiz: bi-pencil) --}}
    <a href="{{ route('clientes.edit', $cliente->Documento) }}" class="btn btn-sm btn-outline-dark" title="Editar Cliente">
        <i class="bi bi-pencil"></i>
    </a>
    
    {{-- 2. ELIMINAR (Papelera: bi-trash) --}}
    <form action="{{ route('clientes.destroy', $cliente->Documento) }}" method="POST" style="display:inline;">
        @csrf
        @method('DELETE') 
        <button type="submit" class="btn btn-sm btn-outline-danger" 
                title="Eliminar Cliente"
                onclick="return confirm('¿Está seguro de eliminar a {{ $cliente->Nombres }}? Esto no se puede deshacer.')">
            <i class="bi bi-trash"></i>
        </button>
    </form>
</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">
                                No se encontraron clientes registrados.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection