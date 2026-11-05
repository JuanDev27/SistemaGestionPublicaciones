<?php

namespace App\Http\Controllers;

use App\Models\Publicacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userId = Auth::id();
        $publicaciones = Publicacion::where('usuario_id', $userId)->get();
        return view('posts.index', compact('publicaciones'));
    }

    /**
     * Show the form for creating a new resource.
     */

    public function create()
    {
        return view('posts.create');
    }
    public function store(Request $request)
    {
        $type = $request->input('tipo');
        $validated = $request->validate([
            'tipo' => ['nullable', Rule::in(['PERDIDO', 'HALLADO'])],
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'categoria_id' => 'required|integer|min:1',
            'lugar_id' => 'required|integer|min:1',
            'lugar_detalle' => 'nullable|string|max:255',
            'fecha_evento' => 'required|date',
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
            'imagen.mimes' => 'La imagen debe estar en formato JPG, JPEG, PNG o WEBP.',
            'imagen.max' => 'La imagen no puede superar los 5 MB.',
        ]);

        [$post, $imagePath] = DB::transaction(function () use ($validated, $request) {
            $post = new Publicacion();
            $post->usuario_id = Auth::id();
            $post->fill([
                ...$validated,
                'tipo' => $validated['tipo'] ?? 'PERDIDO',
                'estado' => 'ACTIVA',
                'fecha_creacion' => now(),
                'fecha_estado' => now(),
            ]);
            $post->save();

            $imagePath = null;
            if ($request->hasFile('imagen')) {
                $image = $request->file('imagen');
                $imagePath = $image->storePubliclyAs(
                    "publicaciones/{$post->id}",
                    'imagen.' . $image->extension(),
                    'public'
                );

                if ($imagePath === false) {
                    throw ValidationException::withMessages([
                        'imagen' => 'No fue posible guardar la imagen. Inténtalo nuevamente.',
                    ]);
                }
            }

            return [$post, $imagePath];
        });

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

        return redirect()->route('posts.lost.create')
            ->with('success', 'Publicación creada exitosamente.');
    }


    public function show(string $id)
    {
        $post = Publicacion::findOrFail($id);

        return view('posts.show', compact('post'));
    }

    public function edit(string $id)
    {
        $post = Publicacion::findOrFail($id);

        if ($post->usuario_id !== Auth::id()) {
            abort(403, 'No tienes permiso para editar esta publicación.');
        }

        return view('posts.edit', compact('post'));
    }
    public function update(Request $request, string $id)
    {
        $publicacion = Publicacion::findOrFail($id);

        if ($publicacion->usuario_id !== Auth::id()) {
            abort(403, 'No tienes permiso para actualizar esta publicación.');
        }

        $publicacion->update($request->all());

        return redirect()->route('posts.index')->with('success', 'Publicación actualizada');
    }


    public function destroy(string $id)
    {
        $userId = Auth::id();
        $publicacion = Publicacion::findOrFail($id);

        if ($publicacion->usuario_id !== Auth::id()) {
            abort(403, 'No tienes permiso para borrar esta publicación.');
        }

        $publicacion->delete();

        $publicaciones = Publicacion::where('usuario_id', $userId)->get();

        return view('posts.index', compact('publicaciones'))->with('success', 'Publicación eliminada');

    }
}
