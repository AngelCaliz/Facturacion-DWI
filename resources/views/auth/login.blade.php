<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login | Sistema de Facturación</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">

    <style>
        body {
            background: #0f0f0f;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Roboto', sans-serif;
        }

        .login-card {
            width: 100%;
            max-width: 400px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 10px 25px rgba(0,0,0,.4);
            overflow: hidden;
        }

        .login-header {
            background: #000;
            color: #ffc107;
            text-align: center;
            padding: 25px;
        }

        .login-header i {
            font-size: 3rem;
        }

        .login-header h4 {
            margin-top: 10px;
            font-weight: bold;
            letter-spacing: 1px;
        }

        .login-body {
            padding: 25px;
        }

        .form-control:focus {
            border-color: #ffc107;
            box-shadow: 0 0 0 .2rem rgba(255,193,7,.25);
        }

        .btn-login {
            background: #000;
            color: #ffc107;
            font-weight: bold;
            border: none;
        }

        .btn-login:hover {
            background: #ffc107;
            color: #000;
        }
    </style>
</head>
<body>

<div class="login-card">

    <!-- CABECERA -->
    <div class="login-header">
        <i class="bi bi-box-seam"></i>
        <h4>SISTEMA DE FACTURACIÓN</h4>
        <small>Acceso al sistema</small>
    </div>

    <!-- CUERPO -->
    <div class="login-body">

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- EMAIL -->
            <div class="mb-3">
                <label class="form-label fw-bold">Correo electrónico</label>
                <div class="input-group">
                    <span class="input-group-text bg-dark text-warning">
                        <i class="bi bi-envelope"></i>
                    </span>
                    <input type="email"
                           name="email"
                           class="form-control @error('email') is-invalid @enderror"
                           placeholder=""
                           required>
                </div>

                @error('email')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            <!-- PASSWORD -->
            <div class="mb-4">
                <label class="form-label fw-bold">Contraseña</label>
                <div class="input-group">
                    <span class="input-group-text bg-dark text-warning">
                        <i class="bi bi-lock-fill"></i>
                    </span>
                    <input type="password"
                           name="password"
                           class="form-control"
                           placeholder=""
                           required>
                </div>
            </div>

            <!-- BOTÓN -->
            <div class="d-grid">
                <button type="submit" class="btn btn-login btn-lg">
                    <i class="bi bi-box-arrow-in-right me-1"></i> Ingresar
                </button>
            </div>
        </form>

    </div>
</div>

</body>
</html>
