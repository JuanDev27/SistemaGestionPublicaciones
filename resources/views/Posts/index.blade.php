<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Objetos perdidos</title>
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
</head>

<body class="posts-page">
    <header class="posts-header">
        <div>
            <p class="eyebrow">Comunidad universitaria</p>
            <h1>Objetos perdidos</h1>
        </div>
        <div class="header-actions">
            <a href="{{ route('posts.create') }}" class="publish-link">+ Publicar hallazgo</a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="logout-button">Cerrar sesión</button>
            </form>
        </div>
    </header>

    @if (session('success'))
        <div class="success-message">{{ session('success') }}</div>
    @endif

    <main class="posts-content">
        <div class="list-heading">
            <h2>Hallazgos recientes</h2>
            <span>{{ $publicaciones->count() }} publicaciones</span>
        </div>

        @if ($publicaciones->count())
            <div class="posts-grid">
                @foreach ($publicaciones as $post)
                    <article class="post-card">
                        @if ($post->imagen)
                            <img src="{{ asset('storage/' . $post->imagen) }}" alt="Imagen de {{ $post->titulo }}" class="post-image">
                        @else
                            <div class="post-image post-image-empty">Sin imagen</div>
                        @endif
                        <div class="post-body">
                            <div class="post-status">{{ $post->encontrado ? 'Encontrado' : 'Reportado' }}</div>
                            <h3>{{ $post->titulo }}</h3>
                            <p>{{ $post->contenido }}</p>
                            <dl>
                                <div><dt>Lugar</dt><dd>{{ $post->lugar }}</dd></div>
                                <div><dt>Fecha</dt><dd>{{ optional($post->fecha_hallazgo)->format('d/m/Y') }}</dd></div>
                                <div><dt>Publicado por</dt><dd>{{ $post->user->name ?? $post->user->email }}</dd></div>
                            </dl>
                            <div class="post-footer">
                                <span class="category-tag">{{ $post->categoria }}</span>
                                @if ($post->usuario_id === Auth::id())
                                    <a href="{{ route('posts.edit', $post->id) }}">Editar</a>
                                @endif
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        @else
            <div class="empty-posts">Todavía no hay objetos publicados.</div>
        @endif
    </main>
</body>

</html>
