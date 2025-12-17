@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h2 fw-bold text-dark">Nueva Venta <span class="text-warning">#{{ str_pad($nextId, 6, '0', STR_PAD_LEFT) }}</span></h1>
    <a href="{{ route('facturas.index') }}" class="btn btn-outline-dark">
        <i class="bi bi-clock-history"></i> Ver Historial
    </a>
</div>

<form action="{{ route('facturas.store') }}" method="POST" id="formVenta">
    @csrf
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-dark text-white fw-bold">
            <i class="bi bi-person-lines-fill text-warning me-2"></i> Datos del Cliente y Venta
        </div>
        <div class="card-body bg-white">
            <div class="row g-3">
                <div class="col-md-3">
                    <label class="form-label fw-bold">Número Factura</label>
                    <input type="text" name="Num_factura" class="form-control bg-light" value="{{ str_pad($nextId, 6, '0', STR_PAD_LEFT) }}" readonly>
                </div>
                
                <div class="col-md-5">
                    <label class="form-label fw-bold">Cliente</label>
                    <div class="input-group">
                        <select name="cod_cliente" class="form-select" required>
                            <option value="">Seleccione Cliente...</option>
                            @foreach($clientes as $cliente)
                                <option value="{{ $cliente->Documento }}">
                                    {{ $cliente->Nombres }} {{ $cliente->Apellidos }} ({{ $cliente->Documento }})
                                </option>
                            @endforeach
                        </select>
                        <a href="{{ route('clientes.create') }}" class="btn btn-warning" title="Nuevo Cliente"><i class="bi bi-plus-lg"></i></a>
                    </div>
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-bold">Forma de Pago</label>
                    <select name="cod_formapago" class="form-select" required>
                        @foreach($formasPago as $fp)
                            <option value="{{ $fp->id_formapago }}">{{ $fp->Descripcion_formapago }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-warning text-dark fw-bold">
                    <i class="bi bi-cart-plus me-2"></i> Agregar Artículo
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Buscar Producto</label>
                        <select id="selectProducto" class="form-select">
                            <option value="">Seleccione...</option>
                            @foreach($articulos as $art)
                                <option value="{{ $art->id_articulo }}" 
                                        data-nombre="{{ $art->descripcion }}"
                                        data-precio="{{ $art->precio_venta }}"
                                        data-stock="{{ $art->stock }}">
                                    {{ $art->descripcion }} (Stock: {{ $art->stock }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label">Stock Actual</label>
                            <input type="text" id="showStock" class="form-control-plaintext fw-bold text-end" value="-" readonly>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Precio</label>
                            <input type="text" id="showPrecio" class="form-control-plaintext fw-bold text-end text-success" value="S/. 0.00" readonly>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Cantidad</label>
                        <input type="number" id="inputCantidad" class="form-control border-warning" value="1" min="1">
                    </div>

                    <div class="d-grid">
                        <button type="button" class="btn btn-dark" onclick="agregarItem()">
                            Agregar a la Lista <i class="bi bi-arrow-right"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-body p-0">
                    <table class="table table-striped mb-0">
                        <thead class="bg-dark text-white">
                            <tr>
                                <th>Descripción</th>
                                <th class="text-center">Cant.</th>
                                <th class="text-end">P. Unit</th>
                                <th class="text-end">Subtotal</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody id="tablaDetalles">
                            </tbody>
                        <tfoot class="bg-light fw-bold">
                            <tr>
                                <td colspan="3" class="text-end text-muted">Subtotal</td>
                                <td class="text-end" id="lblSubtotal">S/. 0.00</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td colspan="3" class="text-end text-muted">IVA (18%)</td>
                                <td class="text-end" id="lblIVA">S/. 0.00</td>
                                <td></td>
                            </tr>
                            <tr class="fs-5 border-top border-dark">
                                <td colspan="3" class="text-end">TOTAL A PAGAR</td>
                                <td class="text-end text-success" id="lblTotal">S/. 0.00</td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            
            <input type="hidden" name="total_factura" id="inputTotal">
            <input type="hidden" name="iva_calculado" id="inputIVA">

            <div class="d-grid mt-4">
                <button type="submit" class="btn btn-lg btn-warning fw-bold shadow">
                    <i class="bi bi-check-circle-fill me-2"></i> FINALIZAR VENTA
                </button>
            </div>
        </div>
    </div>
</form>

@endsection

@push('scripts')
<script>
    let totalFactura = 0;

    // Detectar cambio en el select de producto para mostrar stock y precio
    document.getElementById('selectProducto').addEventListener('change', function() {
        const option = this.options[this.selectedIndex];
        if(option.value) {
            document.getElementById('showStock').value = option.dataset.stock;
            document.getElementById('showPrecio').value = 'S/. ' + parseFloat(option.dataset.precio).toFixed(2);
        } else {
            document.getElementById('showStock').value = '-';
            document.getElementById('showPrecio').value = 'S/. 0.00';
        }
    });

    function agregarItem() {
        const select = document.getElementById('selectProducto');
        const option = select.options[select.selectedIndex];
        const cantidad = parseInt(document.getElementById('inputCantidad').value);

        // Validaciones
        if (!option.value) return alert('Seleccione un producto');
        if (cantidad < 1) return alert('Cantidad inválida');
        if (cantidad > parseInt(option.dataset.stock)) return alert('Stock insuficiente');

        const id = option.value;
        const nombre = option.dataset.nombre;
        const precio = parseFloat(option.dataset.precio);
        const subtotal = precio * cantidad;

        // Crear fila HTML
        const fila = `
            <tr>
                <td>
                    ${nombre}
                    <input type="hidden" name="detalles[${id}][id_articulo]" value="${id}">
                </td>
                <td class="text-center">
                    ${cantidad}
                    <input type="hidden" name="detalles[${id}][cantidad]" value="${cantidad}">
                </td>
                <td class="text-end">S/. ${precio.toFixed(2)}</td>
                <td class="text-end">S/. ${subtotal.toFixed(2)}</td>
                <td class="text-center">
                    <input type="hidden" name="detalles[${id}][subtotal]" value="${subtotal}">
                    <button type="button" class="btn btn-sm btn-outline-danger border-0" onclick="eliminarFila(this, ${subtotal})">
                        <i class="bi bi-trash"></i>
                    </button>
                </td>
            </tr>
        `;

        // Agregar al DOM
        document.getElementById('tablaDetalles').insertAdjacentHTML('beforeend', fila);
        
        // Actualizar Totales
        actualizarTotales(subtotal);

        // Resetear inputs pequeños
        select.value = "";
        document.getElementById('inputCantidad').value = 1;
        document.getElementById('showStock').value = "-";
        document.getElementById('showPrecio').value = "S/. 0.00";
    }

    function eliminarFila(btn, monto) {
        btn.closest('tr').remove();
        actualizarTotales(-monto);
    }

    function actualizarTotales(monto) {
        totalFactura += monto;
        
        // Cálculo del IVA (Asumiendo que el precio ya incluye IVA, lo desglosamos)
        // O si el precio es + IVA, sería: total * 0.18. 
        // Usaremos lógica estándar: Base Imponible + 18%
        
        // Para simplificar según PDF: Total Factura es la suma. IVA se calcula de ahí.
        const iva = totalFactura * 0.18; 
        const totalConImpuestos = totalFactura + iva;

        // Renderizar en tabla
        document.getElementById('lblSubtotal').innerText = 'S/. ' + totalFactura.toFixed(2);
        document.getElementById('lblIVA').innerText = 'S/. ' + iva.toFixed(2);
        document.getElementById('lblTotal').innerText = 'S/. ' + totalConImpuestos.toFixed(2);

        // Guardar en inputs ocultos para enviar al Backend
        document.getElementById('inputTotal').value = totalConImpuestos;
        document.getElementById('inputIVA').value = iva;
    }
</script>
@endpush