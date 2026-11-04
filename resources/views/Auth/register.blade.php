<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#0f4d34">
    <meta name="description"
        content="Crea tu cuenta para publicar y encontrar objetos perdidos dentro de la comunidad universitaria.">

    <title>Crear cuenta | Objetos Perdidos</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/register.css') }}">
</head>

<body class="register-page">

    <main class="register-shell">

        {{-- Panel de bienvenida / información de la comunidad --}}
        <section class="register-intro" aria-labelledby="intro-title">
            <div class="brand">
                <span class="brand-mark" aria-hidden="true">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"
                        stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="10.5" cy="10.5" r="6.5"></circle>
                        <path d="m15.5 15.5 4.5 4.5"></path>
                        <path d="M8.2 10.8c.5-1.4 1.7-2.3 3.2-2.3"></path>
                    </svg>
                </span>
                <span class="brand-name">Objetos <span>Perdidos</span></span>
            </div>

            <div class="intro-copy">
                <span class="intro-kicker">Comunidad universitaria</span>
                <h2 id="intro-title">Lo que se pierde, puede volver a encontrarse.</h2>
                <p>
                    Publica los objetos que encontraste y consulta los que otros reportaron.
                    Una comunidad atenta hace la diferencia.
                </p>
            </div>

            <ul class="benefit-list">
                <li>
                    <span class="benefit-icon" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 5v14M5 12h14"></path>
                        </svg>
                    </span>
                    <div>
                        <strong>Publica en segundos</strong>
                        <span>Comparte una foto y una breve descripción del objeto.</span>
                    </div>
                </li>
                <li>
                    <span class="benefit-icon" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path d="M18 8a6 6 0 0 0-12 0c0 7-3 7-3 9h18c0-2-3-2-3-9"></path>
                            <path d="M10 21h4"></path>
                        </svg>
                    </span>
                    <div>
                        <strong>Encuentra coincidencias</strong>
                        <span>Revisa las publicaciones y reconoce tu objeto.</span>
                    </div>
                </li>
                <li>
                    <span class="benefit-icon" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 3 4.5 6v5.5c0 4.6 3.2 8 7.5 9.5 4.3-1.5 7.5-4.9 7.5-9.5V6L12 3Z"></path>
                            <path d="m9 12 2 2 4-4"></path>
                        </svg>
                    </span>
                    <div>
                        <strong>Contacto seguro</strong>
                        <span>Coordina la entrega dentro del campus, sin exponer tus datos.</span>
                    </div>
                </li>
            </ul>

            <div class="intro-note">
                <span class="intro-note-icon" aria-hidden="true">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path d="M4 6h16v12H4z"></path>
                        <path d="m4 7 8 6 8-6"></path>
                    </svg>
                </span>
                <p>
                    Registro exclusivo para la comunidad
                    <strong>@uniautonoma.edu.co</strong>
                </p>
            </div>
        </section>

        {{-- Formulario de creación de cuenta --}}
        <section class="register-panel" aria-labelledby="register-title">
            <header class="register-heading">
                <span class="eyebrow">Únete a la comunidad</span>
                <h1 id="register-title">Crea tu cuenta</h1>
                <p>Completa tus datos para empezar a publicar y recuperar objetos.</p>
            </header>

            @if ($errors->any())
                <div class="alert-box" role="alert">
                    <span class="alert-icon" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9"
                            stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="9"></circle>
                            <path d="M12 7.5v5"></path>
                            <path d="M12 16.5h.01"></path>
                        </svg>
                    </span>
                    <div>
                        <strong>Revisa los datos ingresados</strong>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <form method="POST" action="{{ route('register.store') }}" class="register-form">
                @csrf

                <div class="field-row">
                    <div class="field">
                        <label for="name">Nombre</label>
                        <input id="name" type="text" name="name" value="{{ old('name') }}"
                            placeholder="Ej. Ana María" autocomplete="given-name" required autofocus
                            @error('name') aria-invalid="true" @enderror>
                        @error('name')
                            <p class="field-error">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    aria-hidden="true">
                                    <circle cx="12" cy="12" r="9"></circle>
                                    <path d="M12 8v5"></path>
                                    <path d="M12 16h.01"></path>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div class="field">
                        <label for="lastname">Apellido</label>
                        <input id="lastname" type="text" name="lastname" value="{{ old('lastname') }}"
                            placeholder="Ej. Rodríguez" autocomplete="family-name" required
                            @error('lastname') aria-invalid="true" @enderror>
                        @error('lastname')
                            <p class="field-error">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    aria-hidden="true">
                                    <circle cx="12" cy="12" r="9"></circle>
                                    <path d="M12 8v5"></path>
                                    <path d="M12 16h.01"></path>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>

                <div class="field">
                    <label for="phone">
                        Teléfono
                        <span class="optional">(opcional)</span>
                    </label>
                    <input id="phone" type="tel" name="phone" value="{{ old('phone') }}"
                        placeholder="Ej. 300 123 4567" autocomplete="tel" inputmode="tel"
                        @error('phone') aria-invalid="true" @enderror>
                    @error('phone')
                        <p class="field-error">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                aria-hidden="true">
                                <circle cx="12" cy="12" r="9"></circle>
                                <path d="M12 8v5"></path>
                                <path d="M12 16h.01"></path>
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div class="field">
                    <label for="email">Correo institucional</label>
                    <div class="input-with-icon">
                        <span class="input-icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"
                                stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="5" width="18" height="14" rx="2"></rect>
                                <path d="m3.5 7 8.5 6 8.5-6"></path>
                            </svg>
                        </span>
                        <input id="email" type="email" name="email" value="{{ old('email') }}"
                            placeholder="tu.nombre@uniautonoma.edu.co" autocomplete="email" required
                            aria-describedby="email-help @error('email') email-error @enderror"
                            @error('email') aria-invalid="true" @enderror>
                    </div>
                    <p id="email-help" class="field-hint">
                        Debe terminar en <strong>@uniautonoma.edu.co</strong>
                    </p>
                    @error('email')
                        <p id="email-error" class="field-error">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                aria-hidden="true">
                                <circle cx="12" cy="12" r="9"></circle>
                                <path d="M12 8v5"></path>
                                <path d="M12 16h.01"></path>
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div class="field">
                    <label for="password">Contraseña</label>
                    <div class="password-control">
                        <input id="password" type="password" name="password" placeholder="Crea una contraseña segura"
                            autocomplete="new-password" required
                            aria-describedby="password-help @error('password') password-error @enderror"
                            @error('password') aria-invalid="true" @enderror>
                        <button type="button" class="password-toggle" data-password-toggle="password"
                            aria-label="Mostrar contraseña" aria-pressed="false">
                            <svg class="icon-eye" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"
                                aria-hidden="true">
                                <path d="M2.5 12s3.5-6 9.5-6 9.5 6 9.5 6-3.5 6-9.5 6-9.5-6-9.5-6Z"></path>
                                <circle cx="12" cy="12" r="2.5"></circle>
                            </svg>
                            <svg class="icon-eye-off" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"
                                aria-hidden="true">
                                <path
                                    d="M3 3l18 18M10.6 10.6a2 2 0 0 0 2.8 2.8M9.9 5.2A9.8 9.8 0 0 1 12 5c6 0 9.5 7 9.5 7a17 17 0 0 1-2.1 2.9M6.6 6.6C4 8.3 2.5 12 2.5 12s3.5 7 9.5 7a9.7 9.7 0 0 0 4.2-.9">
                                </path>
                            </svg>
                        </button>
                    </div>
                    <p id="password-help" class="field-hint">
                        Usa al menos 8 caracteres e incluye mayúsculas, minúsculas y números.
                    </p>
                    @error('password')
                        <p id="password-error" class="field-error">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                aria-hidden="true">
                                <circle cx="12" cy="12" r="9"></circle>
                                <path d="M12 8v5"></path>
                                <path d="M12 16h.01"></path>
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div class="field">
                    <label for="password_confirmation">Confirmar contraseña</label>
                    <div class="password-control">
                        <input id="password_confirmation" type="password" name="password_confirmation"
                            placeholder="Repite tu contraseña" autocomplete="new-password" required>
                        <button type="button" class="password-toggle" data-password-toggle="password_confirmation"
                            aria-label="Mostrar contraseña" aria-pressed="false">
                            <svg class="icon-eye" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"
                                aria-hidden="true">
                                <path d="M2.5 12s3.5-6 9.5-6 9.5 6 9.5 6-3.5 6-9.5 6-9.5-6-9.5-6Z"></path>
                                <circle cx="12" cy="12" r="2.5"></circle>
                            </svg>
                            <svg class="icon-eye-off" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"
                                aria-hidden="true">
                                <path
                                    d="M3 3l18 18M10.6 10.6a2 2 0 0 0 2.8 2.8M9.9 5.2A9.8 9.8 0 0 1 12 5c6 0 9.5 7 9.5 7a17 17 0 0 1-2.1 2.9M6.6 6.6C4 8.3 2.5 12 2.5 12s3.5 7 9.5 7a9.7 9.7 0 0 0 4.2-.9">
                                </path>
                            </svg>
                        </button>
                    </div>
                </div>

                <label class="terms">
                    <input type="checkbox" name="terms" value="1" required @checked(old('terms'))>
                    <span>
                        Acepto los términos y condiciones y autorizo el tratamiento de mis datos
                        personales para el uso de la plataforma.
                    </span>
                </label>

                <button type="submit" class="submit-btn">
                    <span data-button-label>Crear mi cuenta</span>
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M5 12h14"></path>
                        <path d="m13 6 6 6-6 6"></path>
                    </svg>
                </button>
            </form>

            <footer class="form-footer">
                <p>¿Ya tienes una cuenta? <a href="{{ route('login') }}">Inicia sesión</a></p>
            </footer>
        </section>
    </main>

    <script>
        document.querySelectorAll('[data-password-toggle]').forEach((toggle) => {
            const input = document.getElementById(toggle.dataset.passwordToggle);

            if (!input) {
                return;
            }

            toggle.addEventListener('click', () => {
                const isHidden = input.type === 'password';

                input.type = isHidden ? 'text' : 'password';
                toggle.setAttribute('aria-pressed', String(isHidden));
                toggle.setAttribute('aria-label', isHidden ? 'Ocultar contraseña' : 'Mostrar contraseña');
            });
        });

        const registerForm = document.querySelector('.register-form');

        if (registerForm) {
            registerForm.addEventListener('submit', () => {
                const submitButton = registerForm.querySelector('.submit-btn');
                const buttonLabel = submitButton?.querySelector('[data-button-label]');

                if (!submitButton) {
                    return;
                }

                submitButton.disabled = true;
                submitButton.classList.add('is-loading');

                if (buttonLabel) {
                    buttonLabel.textContent = 'Creando tu cuenta…';
                }
            });
        }
    </script>

</body>

</html>
