<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Factura #{{ $factura->Num_factura }}</title>
    <style>
        body { font-family: DejaVu Sans; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #000; padding: 5px; }
        th { background: #eee; }
    </style>
</head>
<body>

<h2>Detalle de Factura #{{ $factura->Num_factura }}</h2>

<h4>Datos del Cliente</h4>
<p><strong>Nombre:</strong> {{ $factura->cliente->Nombres }} {{ $factura->cliente->Apellidos }}</p>
<p><strong>Documento:</strong> {{ $factura->cliente->Documento }}</p>
<p><strong>Dirección:</strong> {{ $factura->cliente->Direccion }}</p>

<h4>Detalles de la Transacción</h4>
<p><strong>Fecha:</strong> {{ $factura->Fecha_facturacion }}</p>
<p><strong>Método de Pago:</strong> {{ $factura->formaPago->nombre_forma_pago }}</p>
<p><strong>Empleado:</strong> {{ $factura->Nombre_empleado }}</p>

<table>
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
</table>

<p><strong>IVA:</strong> ${{ number_format($factura->IVA, 2) }}</p>
<p><strong>TOTAL:</strong> ${{ number_format($factura->total_factura, 2) }}</p>

</body>
</html>
