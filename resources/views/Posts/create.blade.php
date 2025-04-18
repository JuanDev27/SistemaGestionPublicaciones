<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Publicación</title>
    <!-- Incluir el archivo de Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/create.css') }}"> <!-- Si tienes un archivo de estilos personalizado -->
</head>

<body>
    <div class="container mt-5">
        <h2 class="mb-4">Crear una nueva publicación</h2>
        
        <!-- Formulario para crear la publicación -->
        <form action="{{ route('posts.store') }}" method="POST">
            @csrf 
            <!-- Campos de la publicación mediante componentes Blade -->
            <x-campos-publicacion />
            <button type="submit" class="btn btn-primary">Crear Publicación</button>
        </form>

        <x-boton-volver route="posts.index" />

    </div>

    <!-- Incluir el archivo de Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>

</html>
