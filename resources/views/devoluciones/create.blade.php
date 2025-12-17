@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow border-0">
            <div class="card-header bg-danger text-white fw-bold">
                <i class="bi bi-arrow-return-left"></i> Registrar Devolución
            </div>
            <div class="card-body p-4">
                
                <form action="{{ route('devoluciones.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">1. Seleccionar Factura Afectada</label>
                        <select name="cod_detallefactura" id="selectFactura" class="form-select" required>
                            <option value="">Seleccione...</option>
                            @foreach($facturas as $fac)
                                <option value="{{ $fac->Num_factura }}">
                                    Factura #{{ $fac->Num_factura }} - {{ $fac->cliente->Nombres ?? '' }} (S/. {{ $fac->total_factura }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">2. Seleccionar Artículo a Devolver</label>
                        <select name="cod_detallearticulo" id="selectArticulo" class="form-select" disabled required>
                            <option value="">Primero seleccione una factura...</option>
                        </select>
                        <div class="form-text text-muted" id="infoCompra"></div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Cantidad a Devolver</label>
                            <input type="number" name="cantidad" class="form-control" min="1" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Motivo</label>
                            <select name="Motivo" class="form-select">
                                <option>Producto Defectuoso</option>
                                <option>Error en Pedido</option>
                                <option>Cambio de Opinión</option>
                            </select>
                        </div>
                    </div>

                    <div class="alert alert-warning d-flex align-items-center mt-2" role="alert">
                        <i class="bi bi-info-circle-fill me-2"></i>
                        <div>
                            Al registrar la devolución, el <strong>Stock</strong> del artículo aumentará automáticamente.
                        </div>
                    </div>

                    <div class="d-grid mt-4">
                        <button type="submit" class="btn btn-danger">Confirmar Devolución</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Script para cargar artículos dinámicamente según la factura
    document.getElementById('selectFactura').addEventListener('change', function() {
        const facturaId = this.value;
        const selectArt = document.getElementById('selectArticulo');
        
        if (!facturaId) {
            selectArt.innerHTML = '<option value="">Seleccione...</option>';
            selectArt.disabled = true;
            return;
        }

        // Llamada a la API interna que creamos en web.php
        fetch(`/api/factura/${facturaId}/detalles`)
            .then(response => response.json())
            .then(data => {
                selectArt.innerHTML = '<option value="">Seleccione artículo...</option>';
                data.forEach(item => {
                    // Creamos la opción mostrando qué compró y cuántos
                    const option = document.createElement('option');
                    option.value = item.cod_articulo;
                    option.text = `${item.articulo.descripcion} (Compró: ${item.cantidad})`;
                    selectArt.add(option);
                });
                selectArt.disabled = false;
            })
            .catch(error => console.error('Error:', error));
    });
</script>
@endpush