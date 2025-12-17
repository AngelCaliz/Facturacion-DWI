<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Factura;
use App\Models\Cliente;
use App\Models\Articulo;
use App\Models\Devolucion;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $mesActual = now()->format('Y-m'); // 2025-09

        return view('admin.dashboard', [
            // 💰 Ventas totales
            'ventasTotales' => Factura::sum('total_factura'),

            // 👥 Clientes
            'totalClientes' => Cliente::count(),

            // 📦 Stock total
            'stockTotal' => Articulo::sum('stock'),

            // 🔄 Devoluciones del mes (USANDO Fecha_devolucion)
            'devolucionesMes' => Devolucion::where('Fecha_devolucion', 'like', "$mesActual%")
                ->count(),
        ]);
    }
}
