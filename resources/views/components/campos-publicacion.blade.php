@props(['categorias', 'lugares', 'post' => null])

@php
    $publicacion = $post ?? null;
    $fechaActual = old('fecha_evento', $publicacion?->fecha_evento?->format('Y-m-d'));
    $horaActual = old('hora', $publicacion && $publicacion->hora ? substr($publicacion->hora, 0, 5) : '');
@endphp

<div>
    <div class="mb-3">
        <label for="titulo" class="form-label">Título</label>
        <input type="text" class="form-control @error('titulo') is-invalid @enderror" id="titulo"
            name="titulo" value="{{ old('titulo', $publicacion?->titulo) }}" required>
        @error('titulo')
            <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="descripcion" class="form-label">Descripción</label>
        <textarea class="form-control @error('descripcion') is-invalid @enderror" id="descripcion"
            name="descripcion" rows="5" required>{{ old('descripcion', $publicacion?->descripcion) }}</textarea>
        @error('descripcion')
            <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
    </div>

    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="categoria_id" class="form-label">Categoría</label>
            <select class="form-select @error('categoria_id') is-invalid @enderror" id="categoria_id"
                name="categoria_id" required>
                <option value="">Selecciona una categoría</option>
                @foreach ($categorias as $categoria)
                    <option value="{{ $categoria->id }}"
                        @selected((string) old('categoria_id', $publicacion?->categoria_id) === (string) $categoria->id)>
                        {{ $categoria->nombre }}
                    </option>
                @endforeach
            </select>
            @error('categoria_id')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6 mb-3">
            <label for="lugar_id" class="form-label">Lugar</label>
            <select class="form-select @error('lugar_id') is-invalid @enderror" id="lugar_id" name="lugar_id"
                required>
                <option value="">Selecciona un lugar</option>
                @foreach ($lugares as $lugar)
                    <option value="{{ $lugar->id }}"
                        @selected((string) old('lugar_id', $publicacion?->lugar_id) === (string) $lugar->id)>
                        {{ $lugar->nombre }}
                    </option>
                @endforeach
            </select>
            @error('lugar_id')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="fecha_evento" class="form-label">Fecha del extravío</label>
            <input type="date" class="form-control @error('fecha_evento') is-invalid @enderror"
                id="fecha_evento" name="fecha_evento" value="{{ $fechaActual }}"
                max="{{ now()->toDateString() }}" required>
            @error('fecha_evento')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6 mb-3">
            <label for="hora" class="form-label">Hora</label>
            <input type="time" class="form-control @error('hora') is-invalid @enderror" id="hora"
                name="hora" value="{{ $horaActual }}" required>
            @error('hora')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="mb-3">
        <label for="detalle_lugar" class="form-label">Detalle del lugar</label>
        <input type="text" class="form-control @error('detalle_lugar') is-invalid @enderror"
            id="detalle_lugar" name="detalle_lugar"
            value="{{ old('detalle_lugar', $publicacion?->detalle_lugar) }}"
            placeholder="Ej. Segundo piso, junto a la ventana" required>
        @error('detalle_lugar')
            <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="custodia" class="form-label">Custodia</label>
        <input type="text" class="form-control @error('custodia') is-invalid @enderror" id="custodia"
            name="custodia" value="{{ old('custodia', $publicacion?->custodia) }}"
            placeholder="Ej. Portería del bloque A" required>
        @error('custodia')
            <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
    </div>
</div>
