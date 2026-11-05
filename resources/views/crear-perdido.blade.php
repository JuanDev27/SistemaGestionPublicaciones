<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar objeto perdido</title>
    <meta name="description" content="Registra un objeto extraviado para que la comunidad pueda ayudarte a encontrarlo.">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        :root {
            --lost-green: #27ae60;
            --lost-green-dark: #147a4d;
            --lost-ink: #1c2b24;
            --lost-muted: #65786e;
            --lost-border: #d8e5dd;
            --lost-surface: #fbfdfc;
            --lost-danger: #c0392b;
        }

        body {
            min-height: 100vh;
            margin: 0;
            padding: clamp(1rem, 3vw, 2.5rem);
            display: grid;
            place-items: center;
            color: var(--lost-ink);
            font-family: 'Segoe UI', sans-serif;
            background:
                radial-gradient(circle at 12% 15%, rgba(46, 204, 113, 0.22), transparent 34%),
                radial-gradient(circle at 88% 85%, rgba(26, 188, 156, 0.2), transparent 38%),
                linear-gradient(135deg, #0a3b29 0%, #11553a 45%, #0d5b52 75%, #083b43 100%);
        }

        .lost-card {
            width: min(900px, 100%);
            padding: clamp(1.5rem, 4vw, 3rem);
            border-radius: 24px;
            background: #ffffff;
            box-shadow: 0 35px 80px -30px rgba(2, 27, 17, 0.7);
        }

        .lost-header {
            margin-bottom: 1.75rem;
        }

        .lost-badge {
            display: inline-flex;
            padding: 0.38rem 0.75rem;
            color: var(--lost-green-dark);
            border-radius: 999px;
            background: #eaf9f0;
            font-size: 0.68rem;
            font-weight: 800;
            letter-spacing: 0.12em;
            text-transform: uppercase;
        }

        .lost-header h1 {
            margin: 0.8rem 0 0.4rem;
            color: var(--lost-ink);
            font-size: clamp(1.7rem, 3vw, 2.25rem);
            font-weight: 800;
            letter-spacing: -0.04em;
            line-height: 1.1;
        }

        .lost-header p {
            margin: 0;
            color: var(--lost-muted);
            font-size: 0.92rem;
            line-height: 1.6;
        }

        .form-alert {
            margin-bottom: 1.25rem;
            padding: 0.9rem 1rem;
            border-radius: 13px;
            font-size: 0.85rem;
            line-height: 1.5;
        }

        .form-alert-success {
            color: #17693d;
            border: 1px solid #b7ebc9;
            background: #eafaf1;
        }

        .form-alert-error {
            color: #93291f;
            border: 1px solid #ffd2ce;
            background: #fff6f5;
        }

        .form-alert ul {
            margin: 0.4rem 0 0;
            padding-left: 1.1rem;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 1.05rem;
        }

        .form-field {
            display: grid;
            gap: 0.42rem;
            min-width: 0;
        }

        .form-field-full {
            grid-column: 1 / -1;
        }

        .form-field label {
            color: #34493e;
            font-size: 0.82rem;
            font-weight: 700;
        }

        .required-mark {
            color: var(--lost-danger);
        }

        .optional-mark {
            color: #8a9c93;
            font-size: 0.72rem;
            font-weight: 500;
        }

        .field-hint {
            margin: 0;
            color: var(--lost-muted);
            font-size: 0.73rem;
            line-height: 1.5;
        }

        .form-control-file {
            padding: 0.55rem 0.7rem;
        }

        .form-control-file::file-selector-button {
            margin-right: 0.7rem;
            padding: 0.45rem 0.75rem;
            color: var(--lost-green-dark);
            border: 1px solid #b7ebc9;
            border-radius: 8px;
            background: #eafaf1;
            font-size: 0.8rem;
            font-weight: 700;
            cursor: pointer;
        }

        .form-field .form-control,
        .form-field .form-select {
            min-height: 2.85rem;
            padding: 0.78rem 0.95rem;
            color: var(--lost-ink);
            border: 1px solid var(--lost-border);
            border-radius: 12px;
            background-color: var(--lost-surface);
            font-size: 0.9rem;
            transition:
                border-color 0.2s ease,
                box-shadow 0.2s ease,
                background-color 0.2s ease;
        }

        .form-field textarea.form-control {
            min-height: 8rem;
            resize: vertical;
        }

        .form-field .form-control::placeholder {
            color: #9bada4;
        }

        .form-field .form-control:focus,
        .form-field .form-select:focus {
            border-color: var(--lost-green);
            background-color: #ffffff;
            box-shadow: 0 0 0 4px rgba(46, 204, 113, 0.14);
        }

        .form-field .form-control[aria-invalid='true'],
        .form-field .form-select[aria-invalid='true'] {
            border-color: #e79a92;
            background-color: #fffafa;
        }

        .form-field .form-control[aria-invalid='true']:focus,
        .form-field .form-select[aria-invalid='true']:focus {
            border-color: #d95c50;
            box-shadow: 0 0 0 4px rgba(217, 92, 80, 0.13);
        }

        .field-error {
            margin: 0;
            color: var(--lost-danger);
            font-size: 0.74rem;
            font-weight: 600;
            line-height: 1.45;
        }

        .required-note {
            margin: 1rem 0 0;
            color: var(--lost-muted);
            font-size: 0.75rem;
        }

        .form-actions {
            display: flex;
            justify-content: flex-end;
            gap: 0.75rem;
            margin-top: 1.5rem;
            padding-top: 1.25rem;
            border-top: 1px solid #edf4ef;
        }

        .btn-cancel {
            padding: 0.8rem 1.2rem;
            color: #4c6156;
            border: 1px solid var(--lost-border);
            border-radius: 12px;
            background: #ffffff;
            font-size: 0.88rem;
            font-weight: 700;
            text-decoration: none;
            transition:
                border-color 0.2s ease,
                background-color 0.2s ease;
        }

        .btn-cancel:hover {
            color: #34493e;
            border-color: #b9cdc2;
            background: #f5faf7;
        }

        .btn-submit {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 2.85rem;
            padding: 0.8rem 1.35rem;
            color: #ffffff;
            border: 0;
            border-radius: 12px;
            background: linear-gradient(135deg, #2ecc71, #1abc9c);
            box-shadow: 0 14px 28px -14px rgba(39, 174, 96, 0.9);
            font-size: 0.88rem;
            font-weight: 800;
            cursor: pointer;
            transition:
                transform 0.2s ease,
                box-shadow 0.2s ease;
        }

        .btn-submit:hover {
            box-shadow: 0 18px 32px -14px rgba(39, 174, 96, 0.95);
            transform: translateY(-1px);
        }

        .btn-submit:focus-visible,
        .btn-cancel:focus-visible {
            outline: none;
            box-shadow: 0 0 0 4px rgba(46, 204, 113, 0.2);
        }

        @media (max-width: 640px) {
            body {
                padding: 0.75rem;
            }

            .lost-card {
                border-radius: 20px;
            }

            .form-grid {
                grid-template-columns: 1fr;
            }

            .form-actions {
                flex-direction: column-reverse;
            }

            .btn-cancel,
            .btn-submit {
                width: 100%;
                text-align: center;
            }
        }
    </style>
</head>

<body>

    <main class="lost-card">
        <header class="lost-header">
            <span class="lost-badge">Objetos perdidos</span>
            <h1>Registrar objeto extraviado</h1>
            <p>Completa la información del objeto para que otros usuarios puedan ayudarte a encontrarlo.</p>
        </header>

        @if (session('success'))
            <div class="form-alert form-alert-success" role="status">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="form-alert form-alert-error" role="alert">
                {{ session('error') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="form-alert form-alert-error" role="alert">
                <strong>No pudimos registrar el objeto. Revisa los siguientes campos:</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div id="form-client-error" class="form-alert form-alert-error" role="alert" hidden>
            Completa todos los campos obligatorios antes de continuar.
        </div>

        @php
            $categorias = $categorias ?? \App\Models\Categoria::orderBy('nombre')->get();
            $lugares = $lugares ?? \App\Models\Lugar::orderBy('nombre')->get();
        @endphp

        <form id="form-crear-perdido" action="{{ route('posts.store') }}" method="POST"
            enctype="multipart/form-data" novalidate>
            @csrf

            <div class="form-grid">
                <div class="form-field">
                    <label for="categoria_id">Categoría <span class="required-mark">*</span></label>
                    <select id="categoria_id" name="categoria_id"
                        class="form-select @error('categoria_id') is-invalid @enderror" required
                        @error('categoria_id') aria-invalid="true" @enderror>
                        <option value="">Selecciona una categoría</option>
                        @foreach ($categorias as $categoria)
                            <option value="{{ $categoria->id }}"
                                @selected((string) old('categoria_id') === (string) $categoria->id)>
                                {{ $categoria->nombre }}
                            </option>
                        @endforeach
                    </select>
                    @error('categoria_id')
                        <p class="field-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-field">
                    <label for="lugar_id">Lugar <span class="required-mark">*</span></label>
                    <select id="lugar_id" name="lugar_id"
                        class="form-select @error('lugar_id') is-invalid @enderror" required
                        @error('lugar_id') aria-invalid="true" @enderror>
                        <option value="">Selecciona un lugar</option>
                        @foreach ($lugares as $lugar)
                            <option value="{{ $lugar->id }}"
                                @selected((string) old('lugar_id') === (string) $lugar->id)>
                                {{ $lugar->nombre }}
                            </option>
                        @endforeach
                    </select>
                    @error('lugar_id')
                        <p class="field-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-field">
                    <label for="fecha_evento">Fecha de extravío <span class="required-mark">*</span></label>
                    <input type="date" id="fecha_evento" name="fecha_evento"
                        class="form-control @error('fecha_evento') is-invalid @enderror"
                        value="{{ old('fecha_evento') }}" max="{{ now()->toDateString() }}" required
                        @error('fecha_evento') aria-invalid="true" @enderror>
                    @error('fecha_evento')
                        <p class="field-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-field">
                    <label for="hora">Hora <span class="required-mark">*</span></label>
                    <input type="time" id="hora" name="hora"
                        class="form-control @error('hora') is-invalid @enderror" value="{{ old('hora') }}"
                        required @error('hora') aria-invalid="true" @enderror>
                    @error('hora')
                        <p class="field-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-field form-field-full">
                    <label for="titulo">Título <span class="required-mark">*</span></label>
                    <input type="text" id="titulo" name="titulo"
                        class="form-control @error('titulo') is-invalid @enderror" value="{{ old('titulo') }}"
                        placeholder="Ej. Mochila negra con cargador" maxlength="255" required
                        @error('titulo') aria-invalid="true" @enderror>
                    @error('titulo')
                        <p class="field-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-field">
                    <label for="detalle_lugar">Detalle del lugar <span class="required-mark">*</span></label>
                    <input type="text" id="detalle_lugar" name="detalle_lugar"
                        class="form-control @error('detalle_lugar') is-invalid @enderror"
                        value="{{ old('detalle_lugar') }}" placeholder="Ej. Segundo piso, junto a la ventana"
                        maxlength="255" required @error('detalle_lugar') aria-invalid="true" @enderror>
                    @error('detalle_lugar')
                        <p class="field-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-field">
                    <label for="custodia">Custodia <span class="required-mark">*</span></label>
                    <input type="text" id="custodia" name="custodia"
                        class="form-control @error('custodia') is-invalid @enderror" value="{{ old('custodia') }}"
                        placeholder="Ej. Portería del bloque A" maxlength="255" required
                        @error('custodia') aria-invalid="true" @enderror>
                    @error('custodia')
                        <p class="field-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-field form-field-full">
                    <label for="descripcion">Descripción <span class="required-mark">*</span></label>
                    <textarea id="descripcion" name="descripcion"
                        class="form-control @error('descripcion') is-invalid @enderror" rows="5"
                        placeholder="Describe el color, la marca, el material y cualquier detalle que ayude a identificarlo."
                        required @error('descripcion') aria-invalid="true" @enderror>{{ old('descripcion') }}</textarea>
                    @error('descripcion')
                        <p class="field-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-field form-field-full">
                    <label for="imagen">
                        Imagen del objeto
                        <span class="optional-mark">(opcional)</span>
                    </label>
                    <input type="file" id="imagen" name="imagen"
                        class="form-control form-control-file @error('imagen') is-invalid @enderror"
                        accept="image/jpeg,image/png,image/webp"
                        @error('imagen') aria-invalid="true" @enderror>
                    <p class="field-hint">Puedes adjuntar una foto en formato JPG, PNG o WEBP.</p>
                    @error('imagen')
                        <p class="field-error">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <p class="required-note"><span class="required-mark">*</span> Campos obligatorios</p>

            <div class="form-actions">
                <a href="{{ route('posts.index') }}" class="btn-cancel">Cancelar</a>
                <button type="submit" class="btn-submit">Registrar objeto</button>
            </div>
        </form>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.getElementById('form-crear-perdido');
            const clientError = document.getElementById('form-client-error');
            const requiredFields = Array.from(form.querySelectorAll('[required]'));

            const hasValue = (field) => field.value.trim() !== '';

            const markField = (field, isValid) => {
                field.setAttribute('aria-invalid', String(!isValid));
                field.classList.toggle('is-invalid', !isValid);
            };

            requiredFields.forEach((field) => {
                const eventName = field.tagName === 'SELECT' || field.type === 'date' ? 'change' : 'input';

                field.addEventListener(eventName, function () {
                    if (hasValue(field)) {
                        markField(field, true);
                    }

                    const allValid = requiredFields.every(hasValue);

                    if (allValid) {
                        clientError.hidden = true;
                    }
                });
            });

            form.addEventListener('submit', function (event) {
                let firstInvalidField = null;

                requiredFields.forEach((field) => {
                    const isValid = hasValue(field);
                    markField(field, isValid);

                    if (!isValid && !firstInvalidField) {
                        firstInvalidField = field;
                    }
                });

                if (firstInvalidField) {
                    event.preventDefault();
                    clientError.hidden = false;
                    clientError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    firstInvalidField.focus({ preventScroll: true });
                    return;
                }

                clientError.hidden = true;
            });
        });
    </script>

</body>

</html>
