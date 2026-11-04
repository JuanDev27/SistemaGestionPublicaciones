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

        <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data" class="found-form">
            @csrf

            <div class="form-grid">
                <div class="field image-field">
                    <label for="imagen">Fotografía del objeto hallado <b>*</b></label>
                    <label for="imagen" class="image-upload">
                        <span class="upload-icon">↑</span>
                        <span>Selecciona una imagen</span>
                        <small>JPG, PNG o WEBP (máx. 5 MB)</small>
                    </label>
                    <input id="imagen" type="file" name="imagen" accept="image/jpeg,image/png,image/webp" required>
                </div>

                <div class="field">
                    <label for="titulo">Título descriptivo del hallazgo <small>Sé claro y específico</small></label>
                    <input id="titulo" type="text" name="titulo" value="{{ old('titulo') }}"
                        placeholder="Ej. Calculadora científica Casio fx-991" required>
                </div>

                <div class="field field-wide">
                    <label for="contenido">Descripción detallada <small>Indica marca, modelo, color o señas distintivas</small></label>
                    <textarea id="contenido" name="contenido" rows="4" placeholder="Describe el objeto encontrado..." required>{{ old('contenido') }}</textarea>
                </div>

                <div class="field field-wide">
                    <label for="categoria">Categoría del objeto</label>
                    <select id="categoria" name="categoria" required>
                        <option value="" disabled {{ old('categoria') ? '' : 'selected' }}>Selecciona una categoría</option>
                        @foreach (['Dispositivos electrónicos', 'Documentos e identificación', 'Útiles y libros', 'Prendas', 'Otros'] as $categoria)
                            <option value="{{ $categoria }}" {{ old('categoria') === $categoria ? 'selected' : '' }}>{{ $categoria }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="field field-wide">
                    <label for="lugar">Lugar exacto del campus</label>
                    <input id="lugar" type="text" name="lugar" value="{{ old('lugar') }}"
                        placeholder="Ej. Mesa 4, segundo piso, Biblioteca Central" required>
                </div>

                <div class="field">
                    <label for="fecha_hallazgo">Fecha del hallazgo</label>
                    <input id="fecha_hallazgo" type="date" name="fecha_hallazgo" value="{{ old('fecha_hallazgo', now()->format('Y-m-d')) }}" required>
                </div>

                <div class="field">
                    <label for="encontrado">Estado del objeto</label>
                    <select id="encontrado" name="encontrado" required>
                        <option value="1" {{ old('encontrado', '1') === '1' ? 'selected' : '' }}>Encontrado y bajo custodia</option>
                        <option value="0" {{ old('encontrado') === '0' ? 'selected' : '' }}>Solo reportar ubicación</option>
                    </select>
                </div>
            </div>

            <label class="safety-option">
                <input type="checkbox" name="confirmacion" value="1" required>
                <span>Confirmo que la información es verdadera y que tengo el objeto o conozco su ubicación.</span>
            </label>

            <button type="submit" class="publish-button">Publicar Hallazgo en la Comunidad <span>↗</span></button>
        </form>
    </main>
</body>

</html>
