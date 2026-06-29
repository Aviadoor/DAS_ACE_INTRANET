<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - A.C. Enterprises</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body {
            background-color: #e9ecef;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Source Sans Pro', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
        }
        .login-box {
            width: 360px;
        }
        .login-logo {
            font-size: 2.1rem;
            font-weight: 300;
            margin-bottom: 1rem;
            text-align: center;
            color: #495057;
        }
        .login-logo b {
            font-weight: 700;
        }
        .logo-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background-color: #343a40;
            color: #fff;
            width: 35px;
            height: 35px;
            border-radius: 4px;
            font-size: 1.2rem;
            margin-right: 5px;
            vertical-align: text-bottom;
        }
        .card {
            border: 0;
            box-shadow: 0 0 1px rgba(0,0,0,.125), 0 1px 3px rgba(0,0,0,.2);
            border-top: 3px solid #007bff; 
            border-radius: 0.25rem;
        }
        .card-header {
            background-color: transparent;
            border-bottom: 0;
            padding: 1.25rem 1.25rem 0.75rem 1.25rem;
            text-align: center;
            color: #212529;
            font-size: 0.95rem;
        }
        .input-group-text {
            background-color: #fff;
            color: #777;
            border-left: 0;
        }
        .form-control {
            border-right: 0;
        }
        .form-control:focus {
            border-color: #ced4da;
            box-shadow: none;
        }
        .form-control:focus + .input-group-text {
            border-color: #ced4da;
        }
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            font-weight: 400;
        }
        .btn-primary:hover {
            background-color: #0069d9;
            border-color: #0062cc;
        }
        .form-check-label {
            font-weight: 700;
            color: #495057;
            font-size: 0.9rem;
            margin-top: 2px;
        }
    </style>
</head>
<body>

<div class="login-box">
    <div class="login-logo">
        <span class="logo-icon"><i class="fa-solid fa-floppy-disk"></i></span>
        <b>A.C.</b> Enterprises
    </div>
    
    <div class="card">
        <div class="card-header">
            Autenticarse para iniciar sesión
        </div>
        <div class="card-body">
            <!-- 1. Ajustamos el Action para apuntar a tu ruta -->
            <form action="{{ url('/login') }}" method="POST">
                @csrf
                
                <!-- 2. Agregamos 'has-validation' para que Bootstrap maneje bien los bordes rojos -->
                <div class="input-group has-validation mb-3">
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email" value="{{ old('email') }}" autofocus>
                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="input-group has-validation mb-3">
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Contraseña">
                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="row align-items-center mt-2">
                    <div class="col-8">
                        <!-- 3. Agregué el clásico "Recuérdame" en el espacio que tenías libre -->
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember">
                            <label class="form-check-label" for="remember">
                                Recuérdame
                            </label>
                        </div>
                    </div>
                    <div class="col-4">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-sign-in-alt me-1"></i> Acceder
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>