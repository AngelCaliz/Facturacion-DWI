@extends('layouts.app') 

@section('content')
<div class="container">
    <h2>Detalle de Factura #{{ $factura->Num_factura }}</h2>
    <hr>
    
    <div class="row">
        <div class="col-md-6">
            <h4>Datos del Cliente</h4>
            <p><strong>Nombre:</strong> {{ $factura->cliente->Nombres }} {{ $factura->cliente->Apellidos }}</p>
            <p><strong>Documento:</strong> {{ $factura->cliente->Documento }}</p>
            <p><strong>Dirección:</strong> {{ $factura->cliente->Direccion }}</p>
        </div>
        <div class="col-md-6">
            <h4>Detalles de la Transacción</h4>
            <p><strong>Fecha:</strong> {{ $factura->Fecha_facturacion }}</p>
            <p><strong>Método de Pago:</strong> {{ $factura->formaPago->nombre_forma_pago }}</p>
            <p><strong>Empleado:</strong> {{ $factura->Nombre_empleado }}</p>
        </div>
    </div>
    
    <h4 class="mt-4">Artículos Facturados</h4>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Código</th>
                <th>Descripción</th>
                <th>Cantidad</th>
                <th>Precio Unitario</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($factura->detalles as $detalle)
            <tr>
                <td>{{ $detalle->cod_articulo }}</td>
                <td>{{ $detalle->articulo->descripcion }}</td>
                <td>{{ $detalle->cantidad }}</td>
                <td>${{ number_format($detalle->total / $detalle->cantidad, 2) }}</td>
                <td>${{ number_format($detalle->total, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="4" class="text-right"><strong>IVA:</strong></td>
                <td><strong>${{ number_format($factura->IVA, 2) }}</strong></td>
            </tr>
            <tr>
                <td colspan="4" class="text-right"><strong>TOTAL FACTURA:</strong></td>
                <td><strong>${{ number_format($factura->total_factura, 2) }}</strong></td>
            </tr>
        </tfoot>
    </table>

        <a href="{{ route('facturas.pdf', $factura->Num_factura) }}"
   class="btn btn-danger">
    Descargar PDF
</a>

  <a href="{{ route('facturas.excel', $factura->Num_factura) }}"
       class="btn btn-success">
        Exportar Excel
    </a>

    
    <a href="{{ route('facturas.index') }}" class="btn btn-secondary">Volver al Historial</a>
</div>
@endsection