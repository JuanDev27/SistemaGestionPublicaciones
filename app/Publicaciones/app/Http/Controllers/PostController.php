<?php

namespace App\Http\Controllers;

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
        $request->validate([
            'titulo' => 'required|string|max:255',
            'contenido' => 'required|string',
        ]);

        $post = new Publicacion();
        $post->titulo = $request->titulo;
        $post->contenido = $request->contenido;
        $post->usuario_id = Auth::id(); 
        $post->save();

        return redirect()->route('posts.index')->with('success', 'Publicación creada exitosamente!');

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
