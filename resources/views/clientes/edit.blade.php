@extends('layouts.app')

@section('content')
<div class="container mt-4">

    <div class="d-flex justify-content-between mb-3">
        <h2 class="text-warning">Editar Cliente</h2>
        <a href="{{ route('clientes.index') }}" class="btn btn-dark">
            ← Volver al listado
        </a>
    </div>

    <div class="card shadow">
        <div class="card-header bg-dark text-warning fw-bold">
            Actualizar Información del Cliente
        </div>

        <div class="card-body">

            <form action="{{ route('clientes.update', $cliente->Documento) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row g-3">

                    {{-- Tipo Documento --}}
                    <div class="col-md-4">
                        <label class="form-label">Tipo de Documento</label>
                        <select name="cod_tipo_documento" class="form-select" required>
                            @foreach ($tiposDoc as $tipo)
                                <option value="{{ $tipo->id_tipo_documento }}"
                                    {{ $cliente->cod_tipo_documento == $tipo->id_tipo_documento ? 'selected' : '' }}>
                                    {{ $tipo->Descripcion }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Documento --}}
                    <div class="col-md-8">
                        <label class="form-label">Documento</label>
                        <input type="text" class="form-control"
                            value="{{ $cliente->Documento }}" readonly>
                    </div>

                    {{-- Nombres --}}
                    <div class="col-md-6">
                        <label class="form-label">Nombres</label>
                        <input type="text" name="Nombres" class="form-control"
                            value="{{ $cliente->Nombres }}" required>
                    </div>

                    {{-- Apellidos --}}
                    <div class="col-md-6">
                        <label class="form-label">Apellidos</label>
                        <input type="text" name="Apellidos" class="form-control"
                            value="{{ $cliente->Apellidos }}" required>
                    </div>

                    {{-- Ciudad --}}
                    <div class="col-md-6">
                        <label class="form-label">Ciudad</label>
                        <select name="cod_ciudad" class="form-select" required>
                            @foreach ($ciudades as $ciudad)
                                <option value="{{ $ciudad->Codigo_ciudad }}"
                                    {{ $cliente->cod_ciudad == $ciudad->Codigo_ciudad ? 'selected' : '' }}>
                                    {{ $ciudad->Nombre_ciudad }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Dirección --}}
                    <div class="col-md-6">
                        <label class="form-label">Dirección</label>
                        <input type="text" name="Direccion" class="form-control"
                            value="{{ $cliente->Direccion }}" required>
                    </div>

                    {{-- Teléfono --}}
                    <div class="col-md-12">
                        <label class="form-label">Teléfono</label>
                        <input type="text" name="Telefono" class="form-control"
                            value="{{ $cliente->Telefono }}" required>
                    </div>

                </div>

                <div class="d-grid mt-4">
                    <button type="submit" class="btn btn-warning fw-bold">
                        Actualizar Cliente
                    </button>
                </div>

            </form>

        </div>
    </div>

</div>
@endsection