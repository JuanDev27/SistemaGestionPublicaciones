<?php

namespace App\Http\Controllers;

use App\Models\Publicacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Throwable;

class PostController extends Controller
{
    public function index()
    {
        $publicaciones = Publicacion::with('user')
            ->orderByDesc('fecha_creacion')
            ->get();

        return view('posts.index', compact('publicaciones'));
    }

    public function create()
    {
        return view('posts.create');
    }

    public function storePerdido(Request $request)
    {
        $validated = $request->validate([
            'titulo' => ['required', 'string', 'max:255'],
            'descripcion' => ['required', 'string'],
            'categoria_id' => ['required', 'integer', 'min:1'],
            'lugar_id' => ['required', 'integer', 'min:1'],
            'lugar_detalle' => ['nullable', 'string', 'max:255'],
            'fecha_evento' => ['required', 'date', 'before_or_equal:today'],
            'hora_evento' => ['nullable', 'date_format:H:i'],
            'imagen' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
        ]);

        return $this->savePublication(
            $request,
            $validated,
            'PERDIDO',
            'Objeto extraviado registrado exitosamente.'
        );
    }

    public function storeEncontrado(Request $request)
    {
        $validated = $request->validate([
            'titulo' => ['required', 'string', 'max:255'],
            'descripcion' => ['required', 'string'],
            'categoria_id' => ['required', 'integer', 'min:1'],
            'lugar_id' => ['required', 'integer', 'min:1'],
            'lugar_detalle' => ['nullable', 'string', 'max:255'],
            'fecha_evento' => ['required', 'date', 'before_or_equal:today'],
            'hora_evento' => ['nullable', 'date_format:H:i'],
            'custodia_actual' => ['required', 'string', 'max:255'],
            'imagen' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
        ], [
            'custodia_actual.required' => 'Indica quién tiene actualmente el objeto hallado.',
            'imagen.required' => 'Debes adjuntar una imagen del objeto hallado.',
            'imagen.image' => 'El archivo adjunto debe ser una imagen.',
            'imagen.mimes' => 'La imagen debe ser JPG, JPEG, PNG o WEBP.',
            'imagen.max' => 'La imagen no puede superar los 5 MB.',
        ]);

        return $this->savePublication(
            $request,
            $validated,
            'HALLADO',
            'Hallazgo publicado exitosamente.'
        );
    }

    public function store(Request $request)
    {
        $type = $request->input('tipo', 'PERDIDO');
        $validated = $request->validate([
            'tipo' => ['nullable', Rule::in(['PERDIDO', 'HALLADO'])],
            'titulo' => ['required', 'string', 'max:255'],
            'descripcion' => ['required', 'string'],
            'categoria_id' => ['required', 'integer', 'min:1'],
            'lugar_id' => ['required', 'integer', 'min:1'],
            'lugar_detalle' => ['nullable', 'string', 'max:255'],
            'fecha_evento' => ['required', 'date'],
            'hora_evento' => ['nullable', 'date_format:H:i'],
            'custodia_actual' => [
                Rule::requiredIf($type === 'HALLADO'),
                'nullable',
                'string',
                'max:255',
            ],
            'imagen' => [
                Rule::requiredIf($type === 'HALLADO'),
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],
        ], [
            'custodia_actual.required' => 'Indica quién tiene actualmente el objeto hallado.',
            'imagen.required' => 'Debes adjuntar una imagen para publicar un objeto hallado.',
            'imagen.image' => 'El archivo adjunto debe ser una imagen.',
            'imagen.mimes' => 'La imagen debe ser JPG, JPEG, PNG o WEBP.',
            'imagen.max' => 'La imagen no puede superar los 5 MB.',
        ]);

        $imagePath = null;

        try {
            $post = DB::transaction(function () use ($validated, $request, &$imagePath) {
                $post = new Publicacion();
                $post->usuario_id = Auth::id();
                $post->fill([
                    'tipo' => $validated['tipo'] ?? 'PERDIDO',
                    'titulo' => $validated['titulo'],
                    'descripcion' => $validated['descripcion'],
                    'categoria_id' => $validated['categoria_id'],
                    'lugar_id' => $validated['lugar_id'],
                    'lugar_detalle' => $validated['lugar_detalle'] ?? null,
                    'fecha_evento' => $validated['fecha_evento'],
                    'hora_evento' => $validated['hora_evento'] ?? null,
                    'custodia_actual' => $validated['custodia_actual'] ?? null,
                    'estado' => 'ACTIVA',
                    'fecha_creacion' => now(),
                    'fecha_estado' => now(),
                ]);
                $post->save();

                $imagePath = $this->storeImage($request, $post);

                return $post;
            });
        } catch (Throwable $exception) {
            if ($imagePath) {
                Storage::disk('public')->delete($imagePath);
            }

            report($exception);

            $message = 'No fue posible guardar la publicación. Inténtalo nuevamente.';

            if ($request->expectsJson()) {
                return response()->json(['message' => $message], 500);
            }

            return redirect()->back()
                ->withInput()
                ->with('error', $message);
        }

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Publicación creada exitosamente.',
                'data' => [
                    'id' => $post->id,
                    'usuario_id' => $post->usuario_id,
                    'tipo' => $post->tipo,
                    'estado' => $post->estado,
                    'imagen' => $imagePath,
                ],
            ], 201);
        }

        return redirect()->route('posts.index')
            ->with('success', 'Publicación creada exitosamente.');
    }

    public function show(string $id)
    {
        $post = Publicacion::with('user')->findOrFail($id);

        return view('posts.show', compact('post'));
    }

    public function edit(string $id)
    {
        $post = Publicacion::findOrFail($id);

        if ((int) $post->usuario_id !== (int) Auth::id()) {
            abort(403, 'No tienes permiso para editar esta publicación.');
        }

        return view('posts.edit', compact('post'));
    }

    public function update(Request $request, string $id)
    {
        $publicacion = Publicacion::findOrFail($id);

        if ((int) $publicacion->usuario_id !== (int) Auth::id()) {
            abort(403, 'No tienes permiso para actualizar esta publicación.');
        }

        $type = $request->input('tipo', $publicacion->tipo);
        $validated = $request->validate([
            'tipo' => ['sometimes', 'required', Rule::in(['PERDIDO', 'HALLADO'])],
            'titulo' => ['sometimes', 'required', 'string', 'max:255'],
            'descripcion' => ['sometimes', 'required', 'string'],
            'categoria_id' => ['sometimes', 'required', 'integer', 'min:1'],
            'lugar_id' => ['sometimes', 'required', 'integer', 'min:1'],
            'lugar_detalle' => ['sometimes', 'nullable', 'string', 'max:255'],
            'fecha_evento' => ['sometimes', 'required', 'date'],
            'hora_evento' => ['sometimes', 'nullable', 'date_format:H:i'],
            'custodia_actual' => [
                Rule::requiredIf($type === 'HALLADO' && blank($publicacion->custodia_actual)),
                'nullable',
                'string',
                'max:255',
            ],
            'imagen' => [
                Rule::requiredIf($type === 'HALLADO' && !$publicacion->imagen),
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],
        ]);

        $imagePath = null;

        try {
            DB::transaction(function () use ($validated, $request, $publicacion, &$imagePath) {
                unset($validated['imagen']);
                $publicacion->fill($validated);
                $publicacion->save();

                $imagePath = $this->storeImage($request, $publicacion);
            });
        } catch (Throwable $exception) {
            if ($imagePath) {
                Storage::disk('public')->delete($imagePath);
            }

            throw $exception;
        }

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Publicación actualizada exitosamente.',
                'data' => $publicacion->fresh(),
            ]);
        }

        return redirect()->route('posts.index')
            ->with('success', 'Publicación actualizada exitosamente.');
    }

    public function destroy(string $id)
    {
        $publicacion = Publicacion::findOrFail($id);

        if ((int) $publicacion->usuario_id !== (int) Auth::id()) {
            abort(403, 'No tienes permiso para borrar esta publicación.');
        }

        $publicacion->delete();
        Storage::disk('public')->deleteDirectory("publicaciones/{$publicacion->id}");

        if (request()->expectsJson()) {
            return response()->noContent();
        }

        return redirect()->route('posts.index')
            ->with('success', 'Publicación eliminada exitosamente.');
    }

    private function savePublication(Request $request, array $attributes, string $type, string $message)
    {
        $imagePath = null;

        try {
            $post = DB::transaction(function () use ($request, $attributes, $type, &$imagePath) {
                $post = new Publicacion();
                $post->usuario_id = Auth::id();
                $post->fill([
                    'tipo' => $type,
                    'titulo' => $attributes['titulo'],
                    'descripcion' => $attributes['descripcion'],
                    'categoria_id' => $attributes['categoria_id'],
                    'lugar_id' => $attributes['lugar_id'],
                    'lugar_detalle' => $attributes['lugar_detalle'] ?? null,
                    'fecha_evento' => $attributes['fecha_evento'],
                    'hora_evento' => $attributes['hora_evento'] ?? null,
                    'custodia_actual' => $attributes['custodia_actual'] ?? null,
                    'estado' => 'ACTIVA',
                    'fecha_creacion' => now(),
                    'fecha_estado' => now(),
                ]);
                $post->save();

                $imagePath = $this->storeImage($request, $post);

                return $post;
            });
        } catch (Throwable $exception) {
            if ($imagePath) {
                Storage::disk('public')->delete($imagePath);
            }

            report($exception);

            $errorMessage = 'No fue posible guardar la publicación. Inténtalo nuevamente.';

            if ($request->expectsJson()) {
                return response()->json(['message' => $errorMessage], 500);
            }

            return redirect()->back()
                ->withInput()
                ->with('error', $errorMessage);
        }

        if ($request->expectsJson()) {
            return response()->json([
                'message' => $message,
                'data' => $post,
            ], 201);
        }

        return redirect()->route('posts.index')->with('success', $message);
    }

    private function storeImage(Request $request, Publicacion $post): ?string
    {
        if (!$request->hasFile('imagen')) {
            return null;
        }

        $directory = "publicaciones/{$post->id}";
        $image = $request->file('imagen');
        $path = $image->storePubliclyAs(
            $directory,
            'imagen.' . $image->extension(),
            'public'
        );

        if ($path === false) {
            throw ValidationException::withMessages([
                'imagen' => 'No fue posible guardar la imagen. Inténtalo nuevamente.',
            ]);
        }

        $oldImages = array_diff(
            Storage::disk('public')->files($directory),
            [$path]
        );
        Storage::disk('public')->delete($oldImages);

        return $path;
    }
}
