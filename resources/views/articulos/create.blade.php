@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Registrar Artículo</h1>
    <a href="{{ route('articulos.index') }}" class="btn btn-outline-dark">Volver</a>
</div>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-dark text-warning fw-bold">
                <i class="bi bi-pen me-2"></i> Datos del Nuevo Producto
            </div>
            <div class="card-body p-4">
                <form action="{{ route('articulos.store') }}" method="POST">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label">Código Único (ID)</label>
                            <input type="number" name="id_articulo" class="form-control" placeholder="Ej: 1001" required>
                        </div>
                        <div class="col-md-8">
                            <label class="form-label">Descripción del Producto</label>
                            <input type="text" name="descripcion" class="form-control" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Tipo/Categoría</label>
                            <select name="cod_tipo_articulo" class="form-select" required>
                                @foreach($tipos as $tipo)
                                    <option value="{{ $tipo->id_tipoarticulo }}">{{ $tipo->descripcion_articulo }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Proveedor</label>
                            <select name="cod_proveedor" class="form-select" required>
                                @foreach($proveedores as $prov)
                                    <option value="{{ $prov->No_documento }}">{{ $prov->Nombre_comercial }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Precio Costo (Compra)</label>
                            <div class="input-group">
                                <span class="input-group-text">S/.</span>
                                <input type="number" name="precio_costo" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Precio Venta</label>
                            <div class="input-group">
                                <span class="input-group-text">S/.</span>
                                <input type="number" name="precio_venta" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold text-danger">Stock Inicial</label>
                            <input type="number" name="stock" class="form-control border-danger" required>
                        </div>
                        
                        <div class="col-12">
                            <label class="form-label">Fecha Ingreso</label>
                            <input type="date" name="fecha_ingreso" class="form-control" value="{{ date('Y-m-d') }}" required>
                        </div>
                    </div>

                    <div class="d-grid mt-4">
                        <button type="submit" class="btn btn-warning text-dark fw-bold">Guardar Artículo</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection