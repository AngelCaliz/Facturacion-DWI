<?php

namespace App\Http\Controllers;


use App\Models\Factura;

use Barryvdh\DomPDF\Facade\Pdf;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpFoundation\StreamedResponse;

use App\Models\DetalleFactura;
use App\Models\Articulo;
use App\Models\Cliente;
use App\Models\FormaPago;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; 
use Illuminate\Support\Str; // Necesario si Num_factura se genera con Str::padLeft, pero aquí usamos str_pad

class FacturaController extends Controller
{
    // HISTORIAL DE VENTAS (INDEX)
    public function index()
    {
        $facturas = Factura::with('cliente')->latest()->get(); 
        return view('facturas.index', compact('facturas'));
    }

    /**  NUEVO: VISUALIZAR DETALLE (SHOW) */
    public function show(string $numFactura)
    {
        // Carga la factura completa con Eager Loading
        $factura = Factura::where('Num_factura', $numFactura)
                        ->with('cliente', 'detalles.articulo', 'formaPago') 
                        ->firstOrFail(); 

        return view('facturas.show', compact('factura'));
    }
    
    // FORMULARIO DE NUEVA VENTA (CREATE)
    public function create() {
        $clientes = Cliente::all();
        $articulos = Articulo::where('stock', '>', 0)->get(); 
        $formasPago = FormaPago::all();
        
        $nextId = Factura::count() + 1; 
        
        return view('facturas.create', compact('clientes', 'articulos', 'formasPago', 'nextId'));
    }
    
    public function getDetalles($id)
    {
        $detalles = DetalleFactura::where('cod_factura', $id)->with('articulo')->get();
        return response()->json($detalles);
    }
    
    // GUARDADO (STORE)
    public function store(Request $request) {
        
        try {
            DB::transaction(function () use ($request) {
                
                // 1. Guardar Cabecera de Factura
                $factura = Factura::create([
                    'Num_factura' => $request->Num_factura,
                    'cod_cliente' => $request->cod_cliente,
                    'Nombre_empleado' => 'Admin', 
                    'Fecha_facturacion' => date('d/m/Y'),
                    'cod_formapago' => $request->cod_formapago,
                    'total_factura' => $request->total_factura,
                    'IVA' => $request->iva_calculado 
                ]);
                

                // 2. Procesar Detalles y Restar Stock
                foreach ($request->detalles as $item) {
                    
                    DetalleFactura::create([
                        'cod_factura' => $factura->Num_factura,
                        'cod_articulo' => $item['id_articulo'],
                        'cantidad' => $item['cantidad'],
                        'total' => $item['subtotal']
                    ]);

                    $articulo = Articulo::find($item['id_articulo']);
                    $articulo->stock = $articulo->stock - $item['cantidad'];
                    $articulo->save();
                }
            });

            return redirect()->route('facturas.index')->with('success', 'Venta registrada y stock actualizado.');

        } catch (\Exception $e) {
            return back()->with('error', 'Error al procesar la venta: ' . $e->getMessage());
        }
    }
    
    /** NUEVO: ELIMINAR (DESTROY) - CON REVERSIÓN DE STOCK */
    public function destroy(string $numFactura)
    {
        // Carga la factura completa para poder revertir el stock
        $factura = Factura::where('Num_factura', $numFactura)->with('detalles')->firstOrFail();

        DB::beginTransaction();
        try {
            // 1. Revertir el stock de cada artículo
            foreach ($factura->detalles as $detalle) {
                $articulo = Articulo::find($detalle->cod_articulo);
                if ($articulo) {
                    $articulo->stock += $detalle->cantidad; // Sumar de nuevo al stock
                    $articulo->save();
                }
            }

            // 2. Eliminar los detalles y la cabecera
            $factura->detalles()->delete();
            $factura->delete();

            DB::commit();
            return redirect()->route('facturas.index')->with('success', 'Factura eliminada y stock revertido correctamente.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('facturas.index')->with('error', 'Error al eliminar la factura: ' . $e->getMessage());
        }
    }


    public function pdf($id)
{
    $factura = Factura::with([
        'cliente',
        'formaPago',
        'detalles.articulo'
    ])->findOrFail($id);

    $pdf = Pdf::loadView('facturas.pdf', compact('factura'));

    return $pdf->download('Factura_'.$factura->Num_factura.'.pdf');
}


public function excel($numFactura)
{
    $factura = Factura::with(['cliente', 'detalles.articulo', 'formaPago'])
        ->where('Num_factura', $numFactura)
        ->firstOrFail();

    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // =============================
    // CONFIGURACIÓN GENERAL
    // =============================
    $sheet->getDefaultRowDimension()->setRowHeight(20);
    $sheet->getStyle('A1:Z100')->getFont()->setName('Calibri')->setSize(11);

    // =============================
    // LOGO (opcional)
    // =============================
    /*
    $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
    $drawing->setPath(public_path('logo.png'));
    $drawing->setHeight(80);
    $drawing->setCoordinates('A1');
    $drawing->setWorksheet($sheet);
    */

    // =============================
    // CABECERA EMPRESA
    // =============================
    $sheet->mergeCells('A1:C1');
    $sheet->setCellValue('A1', 'EMPRESA INVENTARIO SYS');
    $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);

    $sheet->mergeCells('A2:C2');
    $sheet->setCellValue('A2', 'RUC: 123456789');

    $sheet->mergeCells('A3:C3');
    $sheet->setCellValue('A3', 'Av. Principal 123 - Lima');

    // =============================
    // TÍTULO FACTURA
    // =============================
    $sheet->mergeCells('D1:E3');
    $sheet->setCellValue('D1', 'FACTURA');
    $sheet->getStyle('D1')->getFont()->setBold(true)->setSize(18);
    $sheet->getStyle('D1')->getAlignment()
        ->setHorizontal('center')
        ->setVertical('center');

    $sheet->getStyle('D1:E3')->applyFromArray([
        'borders' => [
            'outline' => ['borderStyle' => 'medium']
        ]
    ]);

    // =============================
    // DATOS CLIENTE
    // =============================
    $sheet->mergeCells('A5:C5');
    $sheet->setCellValue('A5', 'DATOS DEL CLIENTE');
    $sheet->getStyle('A5')->getFont()->setBold(true);

    $sheet->setCellValue('A6', 'Nombre:');
    $sheet->setCellValue('B6', $factura->cliente->Nombres . ' ' . $factura->cliente->Apellidos);

    $sheet->setCellValue('A7', 'Documento:');
    $sheet->setCellValue('B7', $factura->cliente->Documento);

    $sheet->setCellValue('A8', 'Dirección:');
    $sheet->setCellValue('B8', $factura->cliente->Direccion);

    // =============================
    // DATOS FACTURA
    // =============================
    $sheet->mergeCells('D5:E5');
    $sheet->setCellValue('D5', 'DATOS DE LA FACTURA');
    $sheet->getStyle('D5')->getFont()->setBold(true);

    $sheet->setCellValue('D6', 'N° Factura:');
    $sheet->setCellValue('E6', $factura->Num_factura);

    $sheet->setCellValue('D7', 'Fecha:');
    $sheet->setCellValue('E7', $factura->Fecha_facturacion);

    $sheet->setCellValue('D8', 'Forma Pago:');
    $sheet->setCellValue('E8', $factura->formaPago->nombre_forma_pago);

    // =============================
    // CAJAS CLIENTE / FACTURA
    // =============================
    $sheet->getStyle('A5:C8')->applyFromArray([
        'borders' => ['outline' => ['borderStyle' => 'thin']]
    ]);

    $sheet->getStyle('D5:E8')->applyFromArray([
        'borders' => ['outline' => ['borderStyle' => 'thin']]
    ]);

    // =============================
    // TABLA DETALLE
    // =============================
    $sheet->fromArray([
        ['Código', 'Descripción', 'Cant.', 'P. Unit.', 'Subtotal']
    ], null, 'A10');

    $sheet->getStyle('A10:E10')->applyFromArray([
        'font' => ['bold' => true],
        'fill' => [
            'fillType' => 'solid',
            'startColor' => ['rgb' => 'D9D9D9']
        ],
        'borders' => [
            'allBorders' => ['borderStyle' => 'medium']
        ],
        'alignment' => [
            'horizontal' => 'center'
        ]
    ]);

    $row = 11;
    foreach ($factura->detalles as $detalle) {
        $sheet->fromArray([
            $detalle->cod_articulo,
            $detalle->articulo->descripcion,
            $detalle->cantidad,
            $detalle->total / $detalle->cantidad,
            $detalle->total
        ], null, 'A' . $row);
        $row++;
    }

    $sheet->getStyle("A11:E" . ($row - 1))->applyFromArray([
        'borders' => [
            'allBorders' => ['borderStyle' => 'thin']
        ]
    ]);

    // =============================
    // FORMATO MONEDA
    // =============================
    $sheet->getStyle("D11:E" . $row)
        ->getNumberFormat()
        ->setFormatCode('"S/." #,##0.00');

    // =============================
    // TOTALES
    // =============================
    $sheet->mergeCells("A{$row}:C{$row}");
    $sheet->setCellValue("D{$row}", 'IVA');
    $sheet->setCellValue("E{$row}", $factura->IVA);

    $sheet->mergeCells("A" . ($row + 1) . ":C" . ($row + 1));
    $sheet->setCellValue("D" . ($row + 1), 'TOTAL');
    $sheet->setCellValue("E" . ($row + 1), $factura->total_factura);

    $sheet->getStyle("D{$row}:E" . ($row + 1))->getFont()->setBold(true);
    $sheet->getStyle("A{$row}:E" . ($row + 1))->applyFromArray([
        'borders' => ['allBorders' => ['borderStyle' => 'medium']]
    ]);

    // =============================
    // AUTO AJUSTE
    // =============================
    foreach (['A', 'B', 'C', 'D', 'E'] as $col) {
        $sheet->getColumnDimension($col)->setAutoSize(true);
    }

    // =============================
    // DESCARGA
    // =============================
    $writer = new Xlsx($spreadsheet);

    return new StreamedResponse(function () use ($writer) {
        $writer->save('php://output');
    }, 200, [
        'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        'Content-Disposition' => 'attachment; filename="Factura_'.$factura->Num_factura.'.xlsx"',
    ]);
}


}