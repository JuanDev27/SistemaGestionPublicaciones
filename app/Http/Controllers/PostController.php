<?php

namespace App\Http\Controllers;

use App\Models\Publicacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function index()
    {
        $publicaciones = Publicacion::with('user')->latest()->get();

        return view('posts.index', compact('publicaciones'));
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'titulo' => 'required|string|max:255',
            'contenido' => 'required|string|max:5000',
            'categoria' => 'required|string|max:100',
            'imagen' => 'required|image|mimes:jpg,jpeg,png,webp|max:5120',
            'lugar' => 'required|string|max:255',
            'fecha_hallazgo' => 'required|date',
            'encontrado' => 'required|boolean',
            'confirmacion' => 'accepted',
        ]);

        $validated['imagen'] = $request->file('imagen')->store('publicaciones', 'public');
        $validated['usuario_id'] = Auth::id();

        Publicacion::create($validated);

        return redirect()->route('posts.index')
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
        $publicacion = Publicacion::findOrFail($id);

        if ($publicacion->usuario_id !== Auth::id()) {
            abort(403, 'No tienes permiso para borrar esta publicación.');
        }

        $publicacion->delete();

        return redirect()->route('posts.index')
            ->with('success', 'Publicación eliminada');
    }
}
