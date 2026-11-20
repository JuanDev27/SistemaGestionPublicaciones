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
            <a href="{{ route('posts.lost.create') }}" class="publish-link">+ Objeto que perdí</a>
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
            <span>{{ $publicaciones->total() }} publicaciones</span>
        </div>

        <form class="publication-filters" method="GET" action="{{ route('posts.index') }}" role="search">
            <div class="filter-search">
                <label class="sr-only" for="publication-search">Buscar publicaciones</label>
                <input
                    id="publication-search"
                    name="search"
                    type="search"
                    value="{{ $search }}"
                    placeholder="Buscar por objeto o palabra clave"
                    autocomplete="off"
                >
                <button type="submit" aria-label="Buscar">🔍</button>
            </div>
            <div class="filter-fields">
                <div class="filter-field">
                    <label for="filter-category">Categoría</label>
                    <select id="filter-category" name="categoria_id">
                        <option value="">Todas las categorías</option>
                        @foreach ($categories as $id => $name)
                            <option value="{{ $id }}" @selected(($filters['categoria_id'] ?? '') == $id)>{{ $name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="filter-field">
                    <label for="filter-place">Ubicación</label>
                    <select id="filter-place" name="lugar_id">
                        <option value="">Todas las ubicaciones</option>
                        @foreach ($places as $id => $name)
                            <option value="{{ $id }}" @selected(($filters['lugar_id'] ?? '') == $id)>{{ $name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="filter-field">
                    <label for="filter-date-from">Desde</label>
                    <input
                        id="filter-date-from"
                        type="date"
                        name="fecha_desde"
                        value="{{ $filters['fecha_desde'] ?? '' }}"
                    >
                </div>
                <div class="filter-field">
                    <label for="filter-date-to">Hasta</label>
                    <input
                        id="filter-date-to"
                        type="date"
                        name="fecha_hasta"
                        value="{{ $filters['fecha_hasta'] ?? '' }}"
                    >
                </div>
            </div>
            @if ($errors->any())
                <div class="filter-error" role="alert">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="filter-actions">
                <button type="submit" class="apply-filters-button">Aplicar filtros</button>
                <a href="{{ route('posts.index') }}" class="clear-filters-link">Limpiar búsqueda y filtros</a>
            </div>
        </form>

        @if ($publicaciones->count())
            <div class="posts-grid">
                @foreach ($publicaciones as $post)
                    <article class="post-card">
                        @if ($post->imagen)
                            <button
                                type="button"
                                class="post-image-button"
                                data-image-preview="{{ asset('storage/' . $post->imagen) }}"
                                data-image-alt="Vista previa de {{ $post->titulo }}"
                                aria-label="Ampliar imagen de {{ $post->titulo }}"
                            >
                                <img src="{{ asset('storage/' . $post->imagen) }}" alt="Imagen de {{ $post->titulo }}" class="post-image">
                            </button>
                        @else
                            <div class="post-image post-image-empty">Sin imagen</div>
                        @endif
                        <div class="post-body">
                            <div class="post-status">
                                {{ $post->tipo === 'PERDIDO' ? 'Perdido' : ($post->tipo === 'ENCONTRADO' ? 'Encontrado' : 'Reportado') }}
                            </div>
                            <h3>{{ $post->titulo }}</h3>
                            <p>{{ $post->descripcion }}</p>
                            <dl>
                                <div><dt>Lugar</dt><dd>{{ $post->lugar ?? ($places[$post->lugar_id] ?? ($post->lugar_detalle ?: '')) }}</dd></div>
                                <div><dt>Fecha</dt><dd>{{ optional($post->fecha_evento ?? $post->fecha_hallazgo)->format('d/m/Y') }}</dd></div>
                                <div><dt>Publicado por</dt><dd>{{ $post->user->name ?? $post->user->email }}</dd></div>
                            </dl>
                            <div class="post-footer">
                                <span class="category-tag">{{ $post->categoria ?? ($categories[$post->categoria_id] ?? '') }}</span>
                                <div class="post-links">
                                    <a href="{{ route('posts.show', $post->id) }}">Ver detalle y contactar</a>
                                    @if ($post->usuario_id === Auth::id())
                                        <a href="{{ route('posts.edit', $post->id) }}">Editar</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
            @if ($publicaciones->hasPages())
                <nav class="pagination" aria-label="Paginación de publicaciones">
                    @if ($publicaciones->onFirstPage())
                        <span class="pagination-disabled">Anterior</span>
                    @else
                        <a href="{{ $publicaciones->previousPageUrl() }}" rel="prev">Anterior</a>
                    @endif

                    @php
                        $lastPage = $publicaciones->lastPage();
                        $firstVisiblePage = max(1, $publicaciones->currentPage() - 2);
                        $lastVisiblePage = min($lastPage, $publicaciones->currentPage() + 2);
                    @endphp

                    @if ($firstVisiblePage > 1)
                        <a href="{{ $publicaciones->url(1) }}">1</a>
                        @if ($firstVisiblePage > 2)
                            <span aria-hidden="true">…</span>
                        @endif
                    @endif

                    @foreach ($publicaciones->getUrlRange($firstVisiblePage, $lastVisiblePage) as $page => $url)
                        @if ($page === $publicaciones->currentPage())
                            <span aria-current="page" class="pagination-current">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}">{{ $page }}</a>
                        @endif
                    @endforeach

                    @if ($lastVisiblePage < $lastPage)
                        @if ($lastVisiblePage < $lastPage - 1)
                            <span aria-hidden="true">…</span>
                        @endif
                        <a href="{{ $publicaciones->url($lastPage) }}">{{ $lastPage }}</a>
                    @endif

                    @if ($publicaciones->hasMorePages())
                        <a href="{{ $publicaciones->nextPageUrl() }}" rel="next">Siguiente</a>
                    @else
                        <span class="pagination-disabled">Siguiente</span>
                    @endif
                </nav>
            @endif
        @else
            <div class="empty-posts">
                @if ($search !== '')
                    No se encontraron objetos que coincidan con tu búsqueda
                @elseif (($filters['categoria_id'] ?? '') !== ''
                    || ($filters['lugar_id'] ?? '') !== ''
                    || ($filters['fecha_desde'] ?? '') !== ''
                    || ($filters['fecha_hasta'] ?? '') !== '')
                    No se encontraron publicaciones con los filtros seleccionados.
                @else
                    Todavía no hay objetos publicados.
                @endif
            </div>
        @endif
    </main>

    <div class="image-preview-modal" id="image-preview-modal" hidden>
        <button type="button" class="image-preview-backdrop" data-close-image-preview aria-label="Cerrar vista previa"></button>
        <section class="image-preview-dialog" role="dialog" aria-modal="true" aria-label="Vista previa de publicación">
            <button type="button" class="image-preview-close" data-close-image-preview aria-label="Cerrar vista previa">&times;</button>
            <img id="wall-image-preview" alt="">
        </section>
    </div>

    <script>
        const imagePreviewModal = document.getElementById('image-preview-modal');
        const wallImagePreview = document.getElementById('wall-image-preview');
        let previousFocus = null;

        document.querySelectorAll('[data-image-preview]').forEach((button) => {
            button.addEventListener('click', () => {
                previousFocus = button;
                wallImagePreview.src = button.dataset.imagePreview;
                wallImagePreview.alt = button.dataset.imageAlt;
                imagePreviewModal.hidden = false;
                document.body.classList.add('image-preview-open');
                imagePreviewModal.querySelector('.image-preview-close').focus();
            });
        });

        const closeImagePreview = () => {
            imagePreviewModal.hidden = true;
            document.body.classList.remove('image-preview-open');
            wallImagePreview.removeAttribute('src');
            if (previousFocus) {
                previousFocus.focus();
            }
        };

        document.querySelectorAll('[data-close-image-preview]').forEach((button) => {
            button.addEventListener('click', closeImagePreview);
        });

        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape' && !imagePreviewModal.hidden) {
                closeImagePreview();
            }
        });
    </script>
</body>

</html>
