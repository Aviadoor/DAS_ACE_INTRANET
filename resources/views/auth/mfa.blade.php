<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Verificación de Segundo Factor</title>
    <style>
        body { font-family: sans-serif; background-color: #f3f4f6; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .card { background: white; padding: 30px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); width: 100%; max-width: 400px; text-align: center; }
        .input-group { margin: 20px 0; }
        input[type="text"] { width: 100%; padding: 10px; font-size: 18px; text-align: center; letter-spacing: 4px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; }
        button { width: 100%; padding: 12px; background-color: #3b82f6; color: white; border: none; font-size: 16px; border-radius: 4px; cursor: pointer; }
        button:hover { background-color: #2563eb; }
        .error { color: #dc2626; font-size: 14px; margin-top: 5px; }
        .status { color: #16a34a; font-size: 14px; margin-bottom: 15px; }
        .resend-btn { background: none; color: #4b5563; text-decoration: underline; font-size: 14px; cursor: pointer; border: none; margin-top: 15px; }
    </style>
</head>
<body>

<div class="card">
    <h2>Verificación de Seguridad</h2>
    <p>Hemos enviado un código de 6 dígitos a tu correo electrónico para confirmar tu identidad.</p>

    @if (session('status'))
        <div class="status">{{ session('status') }}</div>
    @endif

    <form action="{{ route('mfa.verify') }}" method="POST">
        @csrf
        <div class="input-group">
            <input type="text" name="code" placeholder="000000" maxlength="6" required autocomplete="off">
            @error('code')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit">Verificar Código</button>
    </form>

    <form action="{{ route('mfa.resend') }}" method="POST">
        @csrf
        <button type="submit" class="resend-btn">¿No recibiste el código? Solicitar uno nuevo</button>
    </form>
</div>

</body>
</html>