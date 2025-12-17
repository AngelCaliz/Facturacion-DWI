@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Editar Artículo</h1>
    <a href="{{ route('articulos.index') }}" class="btn btn-outline-dark">Volver</a>
</div>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-primary text-white fw-bold">
                <i class="bi bi-pencil-square me-2"></i> Actualizar Datos del Artículo
            </div>

            <div class="card-body p-4">
                <form action="{{ route('articulos.update', $articulo->id_articulo) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row g-3">

                        <div class="col-md-4">
                            <label class="form-label">Código Artículo (ID)</label>
                            <input type="number" class="form-control" value="{{ $articulo->id_articulo }}" readonly>
                        </div>

                        <div class="col-md-8">
                            <label class="form-label">Descripción</label>
                            <input type="text" name="descripcion" class="form-control" value="{{ $articulo->descripcion }}" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Tipo / Categoría</label>
                            <select name="cod_tipo_articulo" class="form-select" required>
                                @foreach($tipos as $tipo)
                                    <option value="{{ $tipo->id_tipoarticulo }}"
                                        {{ $articulo->cod_tipo_articulo == $tipo->id_tipoarticulo ? 'selected' : '' }}>
                                        {{ $tipo->descripcion_articulo }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Proveedor</label>
                            <select name="cod_proveedor" class="form-select" required>
                                @foreach($proveedores as $prov)
                                    <option value="{{ $prov->No_documento }}"
                                        {{ $articulo->cod_proveedor == $prov->No_documento ? 'selected' : '' }}>
                                        {{ $prov->Nombre_comercial }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Precio Costo</label>
                            <div class="input-group">
                                <span class="input-group-text">S/.</span>
                                <input type="number" name="precio_costo" class="form-control" value="{{ $articulo->precio_costo }}" required>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Precio Venta</label>
                            <div class="input-group">
                                <span class="input-group-text">S/.</span>
                                <input type="number" name="precio_venta" class="form-control" value="{{ $articulo->precio_venta }}" required>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label text-danger fw-bold">Stock</label>
                            <input type="number" name="stock" class="form-control border-danger" value="{{ $articulo->stock }}" required>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label">Fecha de Ingreso</label>
                            <input type="date" name="fecha_ingreso" class="form-control" value="{{ $articulo->fecha_ingreso }}" required>
                        </div>

                    </div>

                    <div class="d-grid mt-4">
                        <button type="submit" class="btn btn-warning text-dark fw-bold">
                            Guardar Cambios
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
@endsection