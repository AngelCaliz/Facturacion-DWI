<tbody>
    @foreach($facturas as $factura)
    <tr>
        <td>{{ $factura->Num_factura }}</td>
        <td>{{ $factura->cliente->Nombres }} {{ $factura->cliente->Apellidos }}</td>
        <td>{{ $factura->Fecha_facturacion }}</td>
        <td>${{ number_format($factura->Total, 0) }}</td> {{-- Asumo que tienes un campo Total --}}
        <td>
            <a href="{{ route('facturas.show', $factura->Num_factura) }}" class="btn btn-info btn-sm">
                Visualizar Detalle
            </a>
        </td>
    </tr>
    @endforeach
</tbody>