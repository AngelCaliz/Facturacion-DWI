@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Registrar <span class="text-warning">Cliente</span></h1>
    <a href="{{ route('clientes.index') }}" class="btn btn-outline-dark">
        <i class="bi bi-arrow-left"></i> Volver al Listado
    </a>
</div>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow border-0">
            <div class="card-header bg-dark text-warning fw-bold">
                <i class="bi bi-person-fill me-2"></i> Información Personal
            </div>
            <div class="card-body p-4">
                
                <form action="{{ route('clientes.store') }}" method="POST">
                    @csrf

                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label">Tipo Doc.</label>
                            <select name="cod_tipo_documento" class="form-select" required>
                                <option value="">Seleccione...</option>
                                @foreach($tiposDoc as $tipo)
                                    <option value="{{ $tipo->id_tipo_documento }}">{{ $tipo->Descripcion }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-8">
                            <label class="form-label">Número Documento</label>
                            <input type="text" name="Documento" class="form-control" required maxlength="15">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Nombres</label>
                            <input type="text" name="Nombres" class="form-control" required maxlength="30">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Apellidos</label>
                            <input type="text" name="Apellidos" class="form-control" required maxlength="30">
                        </div>

                        <hr class="my-3">
                        
                        <div class="col-md-6">
                            <label class="form-label">Ciudad</label>
                            <select name="cod_ciudad" class="form-select" required>
                                <option value="">Seleccione...</option>
                                @foreach($ciudades as $ciudad)
                                    <option value="{{ $ciudad->Codigo_ciudad }}">{{ $ciudad->Nombre_ciudad }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Dirección</label>
                            <input type="text" name="Direccion" class="form-control" required maxlength="20">
                        </div>

                        <div class="col-md-12">
                            <label class="form-label">Teléfono</label>
                            <input type="text" name="Telefono" class="form-control" required maxlength="20">
                        </div>
                    </div>

                    <div class="d-grid mt-4">
                        <button type="submit" class="btn btn-warning text-dark fw-bold">Guardar Cliente</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection