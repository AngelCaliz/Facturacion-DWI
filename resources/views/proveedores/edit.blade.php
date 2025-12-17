@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Gestión de <span class="text-warning">Proveedores</span></h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('proveedores.create') }}" class="btn btn-warning fw-bold text-dark">
            <i class="bi bi-plus-lg"></i> Nuevo Proveedor
        </a>
    </div>
</div>

<div class="card shadow-sm border-0">
    <div class="card-body">
        {{-- FORMULARIO DE EDICIÓN --}}
        <form action="{{ route('proveedores.update', $proveedor->No_documento) }}" method="POST">
            @csrf
            @method('PUT')

            {{-- DOCUMENTO --}}
            <div class="mb-3">
                <label class="form-label">Documento</label>
                <input type="text" name="No_documento" class="form-control"
                       value="{{ $proveedor->No_documento }}" readonly>
            </div>

            {{-- TIPO DE DOCUMENTO --}}
            <div class="mb-3">
                <label class="form-label">Tipo de Documento</label>
                <select name="cod_tipo_documento" class="form-control">
                    @foreach($tiposDoc as $tipo)
                        <option value="{{ $tipo->id_tipo_documento }}"
                            {{ $tipo->id_tipo_documento == $proveedor->cod_tipo_documento ? 'selected' : '' }}>
                            {{ $tipo->descripcion }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- NOMBRE --}}
            <div class="mb-3">
                <label class="form-label">Nombre</label>
                <input type="text" name="Nombre" class="form-control"
                       value="{{ $proveedor->Nombre }}" required>
            </div>

            {{-- APELLIDO --}}
            <div class="mb-3">
                <label class="form-label">Apellido</label>
                <input type="text" name="Apellido" class="form-control"
                       value="{{ $proveedor->Apellido }}" required>
            </div>

            {{-- NOMBRE COMERCIAL --}}
            <div class="mb-3">
                <label class="form-label">Nombre Comercial</label>
                <input type="text" name="Nombre_comercial" class="form-control"
                       value="{{ $proveedor->Nombre_comercial }}">
            </div>

            {{-- DIRECCIÓN --}}
            <div class="mb-3">
                <label class="form-label">Dirección</label>
                <input type="text" name="direccion" class="form-control"
                       value="{{ $proveedor->direccion }}" required>
            </div>

            {{-- CIUDAD --}}
            <div class="mb-3">
                <label class="form-label">Ciudad</label>
                <select name="cod_ciudad" class="form-control">
                    @foreach($ciudades as $c)
                        <option value="{{ $c->Codigo_ciudad }}"
                            {{ $c->Codigo_ciudad == $proveedor->cod_ciudad ? 'selected' : '' }}>
                            {{ $c->Nombre_ciudad }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- TELÉFONO --}}
            <div class="mb-3">
                <label class="form-label">Teléfono</label>
                <input type="text" name="Telefono" class="form-control"
                       value="{{ $proveedor->Telefono }}" required>
            </div>

            <button type="submit" class="btn btn-dark">Actualizar Proveedor</button>
        </form>
    </div>
</div>
@endsection