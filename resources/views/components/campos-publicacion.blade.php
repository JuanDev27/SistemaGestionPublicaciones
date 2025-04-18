<div>
    <div class="mb-3">
        <label for="titulo" class="form-label">Título</label>
        <input type="text" class="form-control" id="titulo" name="titulo"
            value="{{ old('titulo', $post->titulo ?? '') }}" required>
    </div>

    <div class="mb-3">
        <label for="contenido" class="form-label">Contenido</label>
        <textarea class="form-control" id="contenido" name="contenido" rows="5"
            required>{{ old('contenido', $post->contenido ?? '') }}</textarea>
    </div>
</div>