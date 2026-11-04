<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <title>Iniciar sesión</title>
</head>

<body class="login-page">
    <main class="login-card" aria-labelledby="login-title">
        <div class="institution-icon" aria-hidden="true">
            <svg viewBox="0 0 24 24" role="img">
                <path d="M3 9.5 12 4l9 5.5v1.7H3V9.5Zm2 3.2h2v5H5v-5Zm6 0h2v5h-2v-5Zm6 0h2v5h-2v-5ZM3 20h18v1H3v-1Z" />
            </svg>
        </div>

        <h1 id="login-title" class="login-title">Iniciar sesión</h1>
        <p class="login-subtitle">Accede con tus credenciales institucionales para<br>gestionar y reportar objetos perdidos.</p>

        @if ($errors->any())
            <div class="login-alert" role="alert">
                <span class="alert-icon" aria-hidden="true">!</span>
                <div>
                    <strong>Error de autenticación</strong>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                <button type="button" class="alert-close" aria-label="Cerrar mensaje" onclick="this.parentElement.remove()">×</button>
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="login-form">
            @csrf

            <label for="email">Correo institucional</label>
            <div class="input-wrapper">
                <span class="input-icon" aria-hidden="true">@</span>
                <input id="email" type="email" name="email" placeholder="usuario@institucion.edu.co"
                    value="{{ old('email') }}" autocomplete="email" required autofocus>
            </div>

            <label for="password">Contraseña</label>
            <div class="input-wrapper">
                <span class="input-icon" aria-hidden="true">●</span>
                <input id="password" type="password" name="password" placeholder="Ingresa tu contraseña"
                    autocomplete="current-password" required>
                <button type="button" class="password-toggle" aria-label="Mostrar contraseña"
                    aria-controls="password" aria-pressed="false">◉</button>
            </div>

            <div class="login-options">
                <label class="remember-option">
                    <input type="checkbox" name="remember" value="1">
                    <span>Recordarme en este equipo</span>
                </label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}">¿Olvidaste tu contraseña?</a>
                @endif
            </div>

            <button type="submit" class="login-submit">Ingresar a la Plataforma <span aria-hidden="true">→</span></button>
        </form>

        <p class="register-link">¿No tienes una cuenta todavía? <a href="{{ route('register') }}">Regístrate aquí</a> <span aria-hidden="true">↗</span></p>
        <p class="support-text">Soporte: Dirección Institucional Edificio 4, Piso 1</p>
    </main>

    <script>
        const passwordInput = document.getElementById('password');
        const passwordToggle = document.querySelector('.password-toggle');

        passwordToggle.addEventListener('click', () => {
            const isPasswordVisible = passwordInput.type === 'text';
            passwordInput.type = isPasswordVisible ? 'password' : 'text';
            passwordToggle.setAttribute('aria-pressed', String(!isPasswordVisible));
            passwordToggle.setAttribute('aria-label', isPasswordVisible ? 'Mostrar contraseña' : 'Ocultar contraseña');
            passwordToggle.textContent = isPasswordVisible ? '◉' : '◎';
        });
    </script>
</body>

</html>
