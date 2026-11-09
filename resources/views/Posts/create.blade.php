<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Publicar hallazgo</title>
    <link rel="stylesheet" href="{{ asset('css/create.css') }}">
</head>

<body class="found-page">
    <main class="found-card">
        <header class="found-header">
            <a href="{{ route('posts.index') }}" class="back-link">←</a>
            <h1>Publicar Hallazgo</h1>
            <span class="header-user" aria-hidden="true">●</span>
        </header>

        <section class="found-intro">
            <span class="found-badge" aria-hidden="true">✓</span>
            <div>
                <h2>¿Encontraste algo en el campus?</h2>
                <p>Gracias por ayudar. Publicar un hallazgo ayuda a que su dueño lo recupere con total tranquilidad y rapidez.</p>
            </div>
        </section>

        @if (session('error'))
            <div class="form-errors" role="alert">{{ session('error') }}</div>
        @endif

        @if ($errors->any())
            <div class="form-errors" role="alert">
                <strong>Revisa la información:</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('posts.found.store') }}" method="POST" enctype="multipart/form-data" class="found-form">
            @csrf

            <div class="form-grid">
                <div class="field image-field">
                    <label for="imagen">Fotografía del objeto hallado <b>*</b></label>
                    <label for="imagen" class="image-upload" tabindex="0">
                        <span class="upload-icon">↑</span>
                        <span>Selecciona una imagen</span>
                        <small>JPG, PNG o WEBP (máx. 5 MB)</small>
                    </label>
                    <input id="imagen" type="file" name="imagen" accept="image/jpeg,image/png,image/webp"
                        aria-required="true" aria-describedby="imagen-error">
                    <small id="imagen-error" class="field-error" role="alert" hidden>Selecciona una imagen del objeto hallado.</small>
                </div>

                <div class="field">
                    <label for="titulo">Título descriptivo del hallazgo <small>Sé claro y específico</small></label>
                    <input id="titulo" type="text" name="titulo" maxlength="80" value="{{ old('titulo') }}"
                        placeholder="Ej. Calculadora científica Casio fx-991" required>
                </div>

                <div class="field field-wide">
                    <label for="descripcion">Descripción detallada <small>Indica marca, modelo, color o señas distintivas</small></label>
                    <textarea id="descripcion" name="descripcion" rows="4" placeholder="Describe el objeto encontrado..." required>{{ old('descripcion') }}</textarea>
                </div>

                <div class="field">
                    <label for="categoria_id">Categoría</label>
                    <select id="categoria_id" name="categoria_id" required>
                        <option value="">Selecciona una categoría</option>
                        @foreach ($categories as $id => $name)
                            <option value="{{ $id }}" @selected((string) old('categoria_id') === (string) $id)>{{ $id }}. {{ $name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="field">
                    <label for="lugar_id">Lugar</label>
                    <select id="lugar_id" name="lugar_id" required>
                        <option value="">Selecciona un lugar</option>
                        @foreach ($places as $id => $name)
                            <option value="{{ $id }}" @selected((string) old('lugar_id') === (string) $id)>{{ $id }}. {{ $name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="field">
                    <label for="lugar_detalle">Detalle del lugar <small>Opcional</small></label>
                    <input id="lugar_detalle" type="text" name="lugar_detalle" maxlength="150"
                        value="{{ old('lugar_detalle') }}" placeholder="Ej. Mesa 4, segundo piso">
                </div>

                <div class="field">
                    <label for="fecha_evento">Fecha del hallazgo</label>
                    <input id="fecha_evento" type="date" name="fecha_evento"
                        value="{{ old('fecha_evento', now()->format('Y-m-d')) }}" max="{{ now()->toDateString() }}" required>
                </div>

                <div class="field">
                    <label for="hora_evento">Hora del hallazgo</label>
                    <input id="hora_evento" type="time" name="hora_evento"
                        value="{{ old('hora_evento', now()->format('H:i')) }}" required>
                </div>

                <div class="field field-wide">
                    <label for="custodia_actual">Custodia actual</label>
                    <input id="custodia_actual" type="text" name="custodia_actual" maxlength="100"
                        value="{{ old('custodia_actual') }}" placeholder="¿Quién tiene actualmente el objeto?" required>
                </div>
            </div>

            <label class="safety-option">
                <input type="checkbox" name="confirmacion" value="1" required>
                <span>Confirmo que la información es verdadera y que tengo el objeto o conozco su ubicación.</span>
            </label>

            <button type="submit" class="publish-button">Publicar Hallazgo en la Comunidad <span>↗</span></button>
        </form>
    </main>
    <script>
        const foundForm = document.querySelector('.found-form');
        const imageInput = document.getElementById('imagen');
        const imageLabel = document.querySelector('.image-upload');
        const imageError = document.getElementById('imagen-error');

        imageLabel.addEventListener('keydown', function (event) {
            if (event.key === 'Enter' || event.key === ' ') {
                event.preventDefault();
                imageInput.click();
            }
        });

        imageInput.addEventListener('change', function () {
            imageError.hidden = imageInput.files.length > 0;
        });

        foundForm.addEventListener('submit', function (event) {
            if (imageInput.files.length === 0) {
                event.preventDefault();
                imageError.hidden = false;
                imageLabel.focus();
            }
        });
    </script>
</body>

</html>
