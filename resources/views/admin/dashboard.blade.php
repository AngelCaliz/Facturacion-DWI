@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2 fw-light">
        Panel de <span class="fw-bold text-warning">Control</span>
    </h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <button type="button" class="btn btn-sm btn-outline-dark">
                Reporte Mensual
            </button>
        </div>
    </div>
</div>

{{-- TARJETAS PRINCIPALES --}}
<div class="row g-4 mb-4">

    {{-- Ventas --}}
    <div class="col-xl-3 col-md-6">
        <div class="card bg-dark text-white h-100 shadow-lg border-warning" style="border-left: 5px solid;">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-uppercase mb-1 text-warning">Ventas Totales (S/.)</h6>
                        <h2 class="mb-0">
                            {{ number_format($ventasTotales ?? 0, 2) }}
                        </h2>
                    </div>
                    <i class="bi bi-currency-dollar fs-1 opacity-50"></i>
                </div>
            </div>
            <div class="card-footer bg-dark border-0 d-flex align-items-center justify-content-between small">
                <a class="text-white text-decoration-none stretched-link"
                   href="{{ route('facturas.index') }}">
                    Ver historial
                </a>
                <div class="text-white"><i class="bi bi-arrow-right"></i></div>
            </div>
        </div>
    </div>

    {{-- Clientes --}}
    <div class="col-xl-3 col-md-6">
        <div class="card bg-white h-100 shadow-lg border-dark" style="border-left: 5px solid;">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-uppercase mb-1 text-dark">Clientes Registrados</h6>
                        <h2 class="mb-0 text-dark">
                            {{ $totalClientes ?? 0 }}
                        </h2>
                    </div>
                    <i class="bi bi-people-fill fs-1 opacity-50 text-dark"></i>
                </div>
            </div>
            <div class="card-footer bg-white border-0 d-flex align-items-center justify-content-between small">
                <a class="text-dark text-decoration-none stretched-link"
                   href="{{ route('clientes.index') }}">
                    Ver clientes
                </a>
                <div class="text-dark"><i class="bi bi-arrow-right"></i></div>
            </div>
        </div>
    </div>

    {{-- Stock --}}
    <div class="col-xl-3 col-md-6">
        <div class="card bg-white h-100 shadow-lg border-dark" style="border-left: 5px solid;">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-uppercase mb-1 text-dark">Artículos en Stock</h6>
                        <h2 class="mb-0 text-dark">
                            {{ $stockTotal ?? 0 }}
                        </h2>
                    </div>
                    <i class="bi bi-boxes fs-1 opacity-50 text-dark"></i>
                </div>
            </div>
            <div class="card-footer bg-white border-0 d-flex align-items-center justify-content-between small">
                <a class="text-dark text-decoration-none stretched-link"
                   href="{{ route('articulos.index') }}">
                    Ver inventario
                </a>
                <div class="text-dark"><i class="bi bi-arrow-right"></i></div>
            </div>
        </div>
    </div>

    {{-- Devoluciones --}}
    <div class="col-xl-3 col-md-6">
        <div class="card bg-white h-100 shadow-lg border-dark" style="border-left: 5px solid;">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-uppercase mb-1 text-dark">Devoluciones (Mes)</h6>
                        <h2 class="mb-0 text-dark">
                            {{ $devolucionesMes ?? 0 }}
                        </h2>
                    </div>
                    <i class="bi bi-arrow-return-left fs-1 opacity-50 text-dark"></i>
                </div>
            </div>
            <div class="card-footer bg-white border-0 d-flex align-items-center justify-content-between small">
                <a class="text-dark text-decoration-none stretched-link"
                   href="{{ route('devoluciones.index') }}">
                    Ver detalles
                </a>
                <div class="text-dark"><i class="bi bi-arrow-right"></i></div>
            </div>
        </div>
    </div>

</div>

{{-- SECCIÓN INFERIOR --}}
<div class="row">

    {{-- Acciones --}}
    <div class="col-md-6">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-dark text-warning fw-bold">
                Acciones Frecuentes
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('facturas.create') }}"
                       class="btn btn-warning text-dark text-start fw-bold">
                        <i class="bi bi-plus-circle me-2"></i> Generar Nueva Venta
                    </a>
                    <a href="{{ route('clientes.create') }}"
                       class="btn btn-outline-dark text-start">
                        <i class="bi bi-person-plus me-2"></i> Registrar Cliente Nuevo
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- Detalles del sistema --}}
    <div class="col-md-6">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-dark text-warning fw-bold">
                Detalles del Sistema
            </div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    Versión Laravel
                    <span class="badge bg-dark rounded-pill">
                        {{ app()->version() }}
                    </span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    Base de Datos
                    <span class="badge bg-dark rounded-pill">
                        {{ config('database.default') }}
                    </span>
                </li>
            </ul>
        </div>
    </div>

</div>

@endsection
