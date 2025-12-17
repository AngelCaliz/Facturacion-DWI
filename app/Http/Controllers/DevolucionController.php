<?php

namespace App\Http\Controllers;

use App\Models\Devolucion;
use App\Models\Factura;
use App\Models\DetalleFactura;
use App\Models\Articulo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon; // Necesario para manejar el formato de fecha correctamente

class DevolucionController extends Controller
{
    /** LISTADO DE DEVOLUCIONES (INDEX) */
    public function index() {
        // Carga la devolución junto con la factura original y el artículo devuelto
        $devoluciones = Devolucion::with(['facturaOriginal', 'articuloDevuelto'])->get();
        return view('devoluciones.index', compact('devoluciones'));
    }

    /** FORMULARIO DE CREACIÓN (CREATE) */
    public function create() {
        // Buscamos facturas para seleccionar de cuál vamos a devolver
        $facturas = Factura::all();
        return view('devoluciones.create', compact('facturas'));
    }

    /** Lógica para buscar los items de una factura (para usar con AJAX/Javascript en la vista) */
    public function getDetalles($facturaId) {
        // Asumiendo que el campo es 'cod_factura' en DetalleFactura
        return DetalleFactura::where('cod_factura', $facturaId)->with('articulo')->get(); 
    }

    /** PROCESAR DEVOLUCIÓN (STORE) - ¡CORRECCIÓN CRÍTICA DE FECHA! */
    public function store(Request $request) {
        $request->validate([
            'cod_detallefactura' => 'required|exists:facturas,Num_factura', // ID de la factura
            'cod_detallearticulo' => 'required|exists:articulos,id_articulo', // ID del artículo
            'cantidad' => 'required|integer|min:1',
            'Motivo' => 'required|string|max:50' // Max 15 caracteres según ERD
        ]);

        // Validar que la cantidad a devolver no sea mayor a la cantidad comprada en la factura
        $detalleOriginal = DetalleFactura::where('cod_factura', $request->cod_detallefactura)
                            ->where('cod_articulo', $request->cod_detallearticulo)
                            ->first();

        if (!$detalleOriginal || $request->cantidad > $detalleOriginal->cantidad) {
            return back()->withErrors(['cantidad' => 'La cantidad a devolver excede la compra original.']);
        }

        // Usamos una transacción para asegurar que, si el stock falla, la devolución no se registre.
        try {
            DB::transaction(function () use ($request) {
                // 1. Registrar la devolución
                Devolucion::create([
                    'cod_detallefactura' => $request->cod_detallefactura,
                    'cod_detallearticulo' => $request->cod_detallearticulo,
                    'Motivo' => $request->Motivo,
                    // 🚨 CORRECCIÓN: Usar el formato YYYY-MM-DD compatible con MySQL
                    'Fecha_devolucion' => Carbon::now()->format('Y-m-d'), 
                    'cantidad' => $request->cantidad
                ]);

                // 2. ACTUALIZAR STOCK (Aumentar el inventario)
                $articulo = Articulo::find($request->cod_detallearticulo);
                
                if (!$articulo) {
                    // Si no encuentra el artículo, forzamos la excepción para el rollback
                    throw new \Exception("Artículo con ID " . $request->cod_detallearticulo . " no encontrado.");
                }
                
                $articulo->stock += $request->cantidad;
                $articulo->save();
            });

            return redirect()->route('devoluciones.index')->with('success', 'Devolución registrada y stock restaurado.');

        } catch (\Exception $e) {
            // Si hay un error SQL o cualquier otra excepción, se captura y se muestra
            // Nota: El DB::rollBack() se hace automáticamente al salir de la closure de DB::transaction()
            return back()->with('error', 'Error al procesar la devolución: ' . $e->getMessage())->withInput();
        }
    }
    
    // ... (Puedes añadir edit, update, destroy si los necesitas)
}