<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Lugar;
use App\Models\Publicacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userId = Auth::id();
        $publicaciones = Publicacion::with(['categoria', 'lugar', 'user'])
            ->where('usuario_id', $userId)
            ->get();

        return view('posts.index', compact('publicaciones'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categorias = Categoria::orderBy('nombre')->get();
        $lugares = Lugar::orderBy('nombre')->get();

        return view('posts.create', compact('categorias', 'lugares'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate($this->validationRules());
        $data['usuario_id'] = Auth::id();

        Publicacion::create($data);

        return redirect()->route('posts.index')->with('success', 'Publicación creada exitosamente!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $post = Publicacion::with(['categoria', 'lugar', 'user'])->findOrFail($id);

        return view('posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $post = Publicacion::findOrFail($id);

        if ($post->usuario_id !== Auth::id()) {
            abort(403, 'No tienes permiso para editar esta publicación.');
        }

        $categorias = Categoria::orderBy('nombre')->get();
        $lugares = Lugar::orderBy('nombre')->get();

        return view('posts.edit', compact('post', 'categorias', 'lugares'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $publicacion = Publicacion::findOrFail($id);

        if ($publicacion->usuario_id !== Auth::id()) {
            abort(403, 'No tienes permiso para actualizar esta publicación.');
        }

        $publicacion->update($request->validate($this->validationRules()));

        return redirect()->route('posts.index')->with('success', 'Publicación actualizada');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $userId = Auth::id();
        $publicacion = Publicacion::findOrFail($id);

        if ($publicacion->usuario_id !== Auth::id()) {
            abort(403, 'No tienes permiso para borrar esta publicación.');
        }

        $publicacion->delete();

        $publicaciones = Publicacion::with(['categoria', 'lugar', 'user'])
            ->where('usuario_id', $userId)
            ->get();

        return view('posts.index', compact('publicaciones'))->with('success', 'Publicación eliminada');
    }

    /**
     * Validation rules shared by store and update.
     */
    private function validationRules(): array
    {
        return [
            'titulo' => ['required', 'string', 'max:255'],
            'descripcion' => ['required', 'string'],
            'categoria_id' => ['required', 'exists:categorias,id'],
            'lugar_id' => ['required', 'exists:lugares,id'],
            'fecha_evento' => ['required', 'date', 'before_or_equal:today'],
            'hora' => ['required', 'date_format:H:i'],
            'detalle_lugar' => ['required', 'string', 'max:255'],
            'custodia' => ['required', 'string', 'max:255'],
        ];
    }
}
