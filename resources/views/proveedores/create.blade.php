@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Registrar Proveedor</h1>
    <a href="{{ route('proveedores.index') }}" class="btn btn-sm btn-outline-secondary">
        <i class="bi bi-arrow-left"></i> Volver
    </a>
</div>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <form action="{{ route('proveedores.store') }}" method="POST">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Tipo Documento</label>
                            <select name="cod_tipo_documento" class="form-select" required>
                                @foreach($tiposDoc as $tipo)
                                    <option value="{{ $tipo->id_tipo_documento }}">{{ $tipo->Descripcion }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Número Documento</label>
                            <input type="text" name="No_documento" class="form-control" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Nombre / Razón Social</label>
                            <input type="text" name="Nombre" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Apellido (Opcional)</label>
                            <input type="text" name="Apellido" class="form-control" value="-">
                        </div>

                        <div class="col-12">
                            <label class="form-label">Nombre Comercial</label>
                            <input type="text" name="Nombre_comercial" class="form-control" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Ciudad</label>
                            <select name="cod_ciudad" class="form-select" required>
                                @foreach($ciudades as $ciudad)
                                    <option value="{{ $ciudad->Codigo_ciudad }}">{{ $ciudad->Nombre_ciudad }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Teléfono</label>
                            <input type="text" name="Telefono" class="form-control" required>
                        </div>
                        
                        <div class="col-12">
                            <label class="form-label">Dirección</label>
                            <input type="text" name="direccion" class="form-control" required>
                        </div>
                    </div>
                    
                    <div class="d-grid mt-4">
                        <button type="submit" class="btn btn-primary">Guardar Proveedor</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection