<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/edit.css') }}">
    <title>Editar Publicaciones</title>
</head>

<body>
    <div class="container">
        <h2>Editar Publicación</h2>

        <!-- Formulario para editar la publicación -->
        <form action="{{ route('posts.update', $post->id) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Campos de la publicación mediante componentes Blade -->
            <x-campos-publicacion :post="$post" />

            <button type="submit" class="btn btn-primary">Guardar cambios</button>
        </form>

        <!-- Enlace para volver a la lista de publicaciones -->
        <x-boton-volver route="posts.index" />

    </div>

</body>
</html>