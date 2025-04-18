<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles de la Publicación</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/show.css') }}">
</head>

<body>
    <div class="container mt-5">
        <!-- Título de la publicación -->
        <h1 class="mb-4" id="P_titulo">Detalles de la Publicación</h1>

        <!-- Muestra los detalles de la publicación -->
        <div class="card" id="publicaciones">
            <div class="card-header">
                <h2>{{ $post->titulo }}</h2>
            </div>
            <div class="card-body" id="contenido">
                <p><strong>ID:</strong> {{ $post->id }}</p>
                <p><strong>Título:</strong> {{ $post->titulo }}</p>
                <p><strong>Contenido:</strong> {{ $post->contenido }}</p>
                <p><strong>Fecha de Creación:</strong> {{ $post->created_at->format('d-m-Y H:i') }}</p>
                <p><strong>Subido por:</strong> {{ $post->user->name }} ({{ $post->user->email }})</p>
            </div>
            <div class="card-footer">
            <x-boton-volver route="posts.index" />
            </div>
        </div>
    </div>

    <!-- Bootstrap JS (opcional para interactuar con elementos dinámicos) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
