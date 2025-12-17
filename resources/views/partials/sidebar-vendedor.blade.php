<nav class="sidebar d-flex flex-column">
    <div class="brand-logo text-center">
        <i class="bi bi-box-seam fs-2 text-white mb-2"></i>
        <div class="brand-text">INVENTARIO <span class="text-white">SYS</span></div>
    </div>

    <ul class="nav flex-column mt-4">
        <li class="nav-item mb-1">
            <a href="{{ route('vendedor.dashboard') }}" class="nav-link">
                <i class="bi bi-speedometer2 me-2"></i> Dashboard
            </a>
        </li>

        <li class="nav-item mb-1">
            <a href="{{ route('facturas.create') }}" class="nav-link">
                <i class="bi bi-cart-plus me-2"></i> Nueva Venta
            </a>
        </li>

        <li class="nav-item mb-1">
            <a href="{{ route('clientes.index') }}" class="nav-link">
                <i class="bi bi-people-fill me-2"></i> Clientes
            </a>
        </li>
    </ul>

    <div class="mt-auto p-3">
        <div class="card bg-dark text-white border-warning text-center">
            <small class="text-warning">Usuario Activo</small><br>
            <strong>{{ Auth::user()->role }}</strong>
        </div>
    </div>
</nav>
