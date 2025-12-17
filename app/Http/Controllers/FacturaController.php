<?php

namespace App\Http\Controllers;

use App\Models\Factura;
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

    /** 🚨 NUEVO: VISUALIZAR DETALLE (SHOW) */
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
    
    /** 🚨 NUEVO: ELIMINAR (DESTROY) - CON REVERSIÓN DE STOCK */
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
}