<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <title>Crear cuenta</title>
</head>

<body class="login-page register-page">
    <main class="register-card" aria-labelledby="register-title">
        <div class="institution-icon" aria-hidden="true">
            <svg viewBox="0 0 24 24" role="img">
                <path d="M3 9.5 12 4l9 5.5v1.7H3V9.5Zm2 3.2h2v5H5v-5Zm6 0h2v5h-2v-5Zm6 0h2v5h-2v-5ZM3 20h18v1H3v-1Z" />
            </svg>
        </div>

        <h1 id="register-title" class="register-title">Crear cuenta universitaria</h1>
        <p class="register-subtitle">Únete a la comunidad académica digital. Ingresa tus datos<br>institucionales para validar tu matrícula.</p>

        @if ($errors->any())
            <div class="login-alert" role="alert">
                <span class="alert-icon" aria-hidden="true">!</span>
                <div>
                    <strong>No se pudo crear la cuenta</strong>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                <button type="button" class="alert-close" aria-label="Cerrar mensaje" onclick="this.parentElement.remove()">×</button>
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}" class="register-form">
            @csrf

            <div class="register-field register-field-wide">
                <div class="field-heading">
                    <label for="email">Correo institucional</label>
                    <span class="domain-hint">Usa @uniautonoma.edu.co</span>
                </div>
                <div class="input-wrapper">
                    <span class="input-icon" aria-hidden="true">@</span>
                    <input id="email" type="email" name="email" placeholder="usuario@uniautonoma.edu.co"
                        value="{{ old('email') }}" autocomplete="email" required autofocus>
                </div>
                <small>Debe pertenecer a un dominio válido (@uniautonoma.edu.co).</small>
            </div>

            <div class="register-field">
                <label for="name">Nombres</label>
                <div class="input-wrapper">
                    <span class="input-icon" aria-hidden="true">♙</span>
                    <input id="name" type="text" name="name" placeholder="Tus nombres"
                        value="{{ old('name') }}" autocomplete="given-name" required>
                </div>
            </div>

            <div class="register-field">
                <label for="lastname">Apellidos</label>
                <div class="input-wrapper">
                    <span class="input-icon" aria-hidden="true">♙</span>
                    <input id="lastname" type="text" name="lastname" placeholder="Tus apellidos"
                        value="{{ old('lastname') }}" autocomplete="family-name" required>
                </div>
            </div>

            <div class="register-field">
                <label for="codigo_estudiantil">Código estudiantil</label>
                <div class="input-wrapper">
                    <span class="input-icon" aria-hidden="true">#</span>
                    <input id="codigo_estudiantil" type="text" name="codigo_estudiantil" placeholder="Ej. 2024108BA"
                        value="{{ old('codigo_estudiantil') }}" required>
                </div>
            </div>

            <div class="register-field">
                <label for="facultad">Facultad / carrera</label>
                <div class="input-wrapper select-wrapper">
                    <span class="input-icon" aria-hidden="true">⌂</span>
                    <select id="facultad" name="facultad" required>
                        <option value="" disabled {{ old('facultad') ? '' : 'selected' }}>Selecciona tu programa</option>
                        <option value="Ingeniería" {{ old('facultad') === 'Ingeniería' ? 'selected' : '' }}>Ingeniería</option>
                        <option value="Ciencias Administrativas" {{ old('facultad') === 'Ciencias Administrativas' ? 'selected' : '' }}>Ciencias Administrativas</option>
                        <option value="Ciencias Sociales" {{ old('facultad') === 'Ciencias Sociales' ? 'selected' : '' }}>Ciencias Sociales</option>
                        <option value="Educación" {{ old('facultad') === 'Educación' ? 'selected' : '' }}>Educación</option>
                        <option value="Salud" {{ old('facultad') === 'Salud' ? 'selected' : '' }}>Salud</option>
                    </select>
                </div>
            </div>

            <div class="register-field register-field-wide password-field">
                <label for="password">Contraseña</label>
                <div class="input-wrapper">
                    <span class="input-icon" aria-hidden="true">●</span>
                    <input id="password" type="password" name="password" placeholder="Mínimo 8 caracteres seguros"
                        autocomplete="new-password" required>
                    <button type="button" class="password-toggle" aria-label="Mostrar contraseña"
                        aria-controls="password" aria-pressed="false">◉</button>
                </div>
                <div class="password-strength"><span></span><span></span><span></span><em>Muy débil</em></div>
            </div>

            <div class="register-field register-field-wide">
                <label for="password_confirmation">Confirmar contraseña</label>
                <div class="input-wrapper">
                    <span class="input-icon" aria-hidden="true">●</span>
                    <input id="password_confirmation" type="password" name="password_confirmation"
                        placeholder="Repite tu contraseña" autocomplete="new-password" required>
                </div>
            </div>

            <label class="terms-option">
                <input type="checkbox" required>
                <span>He leído y acepto los <a href="#">Términos del Servicio de Campus</a> y el reglamento de protección de datos institucionales de la universidad.</span>
            </label>

            <button type="submit" class="register-submit">Registrarse <span aria-hidden="true">→</span></button>
        </form>

        <p class="register-link">¿Ya tienes tu cuenta universitaria? <a href="{{ route('login') }}">Iniciar sesión</a></p>
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
