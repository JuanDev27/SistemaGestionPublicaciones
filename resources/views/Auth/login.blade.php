<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <title>Login</title>
</head>

<body>
    <div class="login-wrapper">
        <h2 class="login-title">Iniciar sesión</h2>
        @if ($errors->any())
            <div class="error-box">
                @foreach ($errors->all() as $error)
                    <p class="error-text">{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="login-form">
            @csrf
            <input type="email" name="email" placeholder="Email" value="{{ old('email') }}" required autofocus>
            <input type="password" name="password" placeholder="Contraseña" required>
            <button type="submit">Entrar</button>
        </form>

        <div class="register-link">
            <a href="{{ route('register') }}">¿No tienes cuenta?</a>
        </div>
    </div>
</body>

</html>