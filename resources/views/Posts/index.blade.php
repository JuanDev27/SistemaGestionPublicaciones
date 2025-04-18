<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Publicaciones</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
</head>

<body>
    <div id="publicaciones">
        <h1 id="P_titulo">Bienvenido a la página de publicaciones</h1>
        @if($publicaciones->count())
            @foreach ($publicaciones as $post)
                <h2>{{ $post->titulo }}</h2>
                <div id="contenido">
                    <p>{{ $post->contenido }}</p>
                    <p>Fecha: {{ $post->created_at }}</p>
                    <p>Autor: {{ $post->user->email }}</p>

                    @if($post->usuario_id === Auth::id())
                        <!-- Botón Editar -->
                        <a href="{{ route('posts.edit', $post->id) }}">
                            <button type="submit" class="btn btn-success">Editar</button>
                        </a>
                        <!-- Eliminar -->
                        <form action="{{ route('posts.destroy', $post->id) }}" method="POST" style="display:inline;"
                            onsubmit="return confirm('¿Estás seguro de que deseas eliminar esta publicación?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Eliminar</button>
                        </form>
                    @endif

                    <a href="{{ route('posts.show', $post->id) }}">
                        <button type="button" class="btn btn-warning mt-2">Detalles</button>
                    </a>
                </div>
            @endforeach
        @else
            <p>No hay publicaciones para mostrar.</p>
        @endif
    </div>

    <!-- Botón Publicar -->
    <a href="{{ route('posts.create') }}">
        <button type="submit" class="publicar">
            Publicar
        </button>
    </a>

    <!-- Botón Cerrar sesión -->
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="cerrar-sesion">Cerrar sesión</button>
    </form>
</body>

</html>
