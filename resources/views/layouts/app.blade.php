<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema Facturación - IESTP PPD</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --sidebar-bg: #0f0f0f;       /* Negro Profundo */
            --accent-color: #ffc107;     /* Amarillo Bootstrap (Warning) */
            --accent-hover: #ffca2c;
            --text-muted: #b3b3b3;
            --content-bg: #f4f6f9;
        }

        body {
            font-family: 'Roboto', sans-serif;
            background-color: var(--content-bg);
            overflow-x: hidden;
        }

        /* --- SIDEBAR ESTILO BLACK & YELLOW --- */
        .sidebar {
            min-height: 100vh;
            width: 260px;
            background: var(--sidebar-bg);
            color: white;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1000;
            box-shadow: 4px 0 10px rgba(0,0,0,0.1);
        }

        .brand-logo {
            background-color: #000;
            padding: 20px;
            border-bottom: 1px solid #333;
        }

        .brand-text {
            color: var(--accent-color);
            font-weight: 800;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        .sidebar .nav-link {
            color: var(--text-muted);
            padding: 12px 20px;
            font-weight: 500;
            border-left: 4px solid transparent;
            transition: all 0.3s;
        }

        .sidebar .nav-link:hover {
            color: white;
            background: rgba(255, 255, 255, 0.05);
        }

        /* Elemento Activo: Borde amarillo y texto blanco brillante */
        .sidebar .nav-link.active {
            color: var(--sidebar-bg);
            background: var(--accent-color);
            border-left-color: white; /* Pequeño detalle */
            font-weight: bold;
        }
        
        .sidebar .nav-link.active i {
            color: var(--sidebar-bg);
        }

        /* --- CONTENIDO PRINCIPAL --- */
        .main-wrapper {
            margin-left: 260px; /* Mismo ancho que el sidebar */
            padding: 20px;
            transition: margin-left 0.3s;
        }

        /* Tarjetas con toques amarillos */
        .card {
            border: none;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        }
        
        .card-header-custom {
            background: black;
            color: var(--accent-color);
            font-weight: bold;
        }

        /* Botones personalizados */
        .btn-primary {
            background-color: #212529; /* Negro */
            border-color: #212529;
        }
        .btn-primary:hover {
            background-color: #000;
        }

        .btn-accent {
            background-color: var(--accent-color);
            color: black;
            font-weight: bold;
            border: none;
        }
        .btn-accent:hover {
            background-color: var(--accent-hover);
            color: black;
        }

    </style>
</head>
<body>

   @auth
    @if(Auth::user()->role === 'ADMIN')
        @include('partials.sidebar-admin')
    @else
        @include('partials.sidebar-vendedor')
    @endif
@endauth


    <div class="main-wrapper">
        
        <nav class="navbar navbar-light bg-white shadow-sm rounded mb-4 px-3">
            <div class="container-fluid">
                <span class="navbar-text fw-bold text-dark">
                    <i class="bi bi-calendar-event me-1"></i> {{ date('d/m/Y') }}
                </span>
                <div class="d-flex gap-2">
                    
                    <form method="POST" action="{{ route('logout') }}">
    @csrf
    <button type="submit" class="btn btn-sm btn-dark">
        <i class="bi bi-power"></i> Salir
    </button>
</form>

                </div>
            </div>
        </nav>

        @if(session('success'))
            <div class="alert alert-success border-0 shadow-sm d-flex align-items-center" role="alert" style="border-left: 5px solid #198754 !important;">
                <i class="bi bi-check-circle-fill me-2 fs-4 text-success"></i>
                <div>{{ session('success') }}</div>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger border-0 shadow-sm d-flex align-items-center" role="alert" style="border-left: 5px solid #dc3545 !important;">
                <i class="bi bi-exclamation-triangle-fill me-2 fs-4 text-danger"></i>
                <div>{{ session('error') }}</div>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
        
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    @stack('scripts')
</body>
</html>