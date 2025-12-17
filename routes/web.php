<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Controladores
use App\Http\Controllers\ArticuloController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\FacturaController;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\DevolucionController;
use App\Http\Controllers\Auth\LoginController;

/*
|--------------------------------------------------------------------------
| 1. RUTA PRINCIPAL (REDIRECCIÓN SEGÚN ROL)
|--------------------------------------------------------------------------
*/

Route::get('/', function () {

    if (!Auth::check()) {
        return redirect()->route('login');
    }

    return Auth::user()->role === 'ADMIN'
        ? redirect()->route('admin.dashboard')
        : redirect()->route('vendedor.dashboard');

})->name('dashboard');

/*
|--------------------------------------------------------------------------
| 2. LOGIN / LOGOUT
|--------------------------------------------------------------------------
*/

Route::get('/login', [LoginController::class, 'showLoginForm'])
    ->name('login');

Route::post('/login', [LoginController::class, 'login']);

Route::post('/logout', [LoginController::class, 'logout'])
    ->name('logout');

/*
|--------------------------------------------------------------------------
| 3. DASHBOARD ADMIN
|--------------------------------------------------------------------------
*/
use App\Http\Controllers\Admin\AdminDashboardController;

Route::middleware(['auth', 'role:ADMIN'])->group(function () {

    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])
        ->name('admin.dashboard');

});

/*
|--------------------------------------------------------------------------
| 4. DASHBOARD VENDEDOR
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:VENDEDOR'])->group(function () {

    Route::get('/vendedor/dashboard', function () {
        return view('vendedor.dashboard');
    })->name('vendedor.dashboard');

});

/*
|--------------------------------------------------------------------------
| 5. MÓDULO CATÁLOGOS (ADMIN y VENDEDOR)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    Route::resource('clientes', ClienteController::class);

    Route::resource('proveedores', ProveedorController::class)
        ->parameters(['proveedores' => 'proveedor']);

    Route::resource('articulos', ArticuloController::class);

});

/*
|--------------------------------------------------------------------------
| 6. FACTURACIÓN (VENTAS)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    // LISTADO / HISTORIAL
    Route::get('facturas', [FacturaController::class, 'index'])
        ->name('facturas.index');

    // CREAR FACTURA
    Route::get('facturas/create', [FacturaController::class, 'create'])
        ->name('facturas.create');

    Route::post('facturas', [FacturaController::class, 'store'])
        ->name('facturas.store');

    // VER FACTURA
    Route::get('facturas/{numFactura}/show', [FacturaController::class, 'show'])
        ->name('facturas.show');

    // ELIMINAR FACTURA
    Route::delete('facturas/{numFactura}', [FacturaController::class, 'destroy'])
        ->name('facturas.destroy');

});

/*
|--------------------------------------------------------------------------
| 7. DEVOLUCIONES
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    Route::resource('devoluciones', DevolucionController::class);

    Route::get('api/factura/{id}/detalles', [DevolucionController::class, 'getDetalles'])
        ->name('api.factura.detalles');

});
