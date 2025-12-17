@extends('layouts.app')

@section('content')
<div class="pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h3 fw-light">Panel del <span class="fw-bold text-primary">Vendedor</span></h1>
</div>

<div class="row g-4 mb-4">

    <div class="col-xl-4 col-md-6">
        <div class="card bg-white h-100 shadow-sm border-dark" style="border-left: 5px solid;">
            <div class="card-body">
                <h6 class="text-uppercase mb-1 text-dark">Generar Venta</h6>
                <a href="{{ route('facturas.create') }}" class="btn btn-dark w-100 mt-3">
                    <i class="bi bi-plus-circle"></i> Nueva Factura
                </a>
            </div>
        </div>
    </div>

    

</div>

@endsection
