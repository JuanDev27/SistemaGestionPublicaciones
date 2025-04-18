<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;


 //AGRUPAR DENTRO DE MIDDLEWARE
Route::middleware(['web'])->group(function () {

    Route::get('/', function () {
        return view('welcome');
    });
    /*LOGIN, REGISTER & LOGOUT */
    Route::get('/login', function () {
        return view('auth.login');
    })->middleware(['guest'])->name('login');

    Route::get('/register', function () {
        return view('auth.register');
    })->middleware(['guest'])->name('register');

    Route::post('/logout', function () {
        auth()->logout();
        return redirect('/login');
    })->name('logout');

    /*HOME PAGE(Redirigir) */
    Route::get('/home', function () {
        return redirect()->route('posts.index'); // Redirige a /posts
    })->middleware(['auth'])->name('home');
    
});

/*RUTAS PROTEGIDAS*/
Route::middleware(['auth'])->group(function () {
    Route::get('/posts', [PostController::class, 'index'])->name('posts.index');


    Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');

    
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');


    Route::get('/posts/{id}', [PostController::class, 'show'])->name('posts.show');


    Route::get('/edit/{id}/', [PostController::class, 'edit'])->name('posts.edit');


    Route::put('/posts/{id}', [PostController::class, 'update'])->name('posts.update');


    Route::delete('/posts/{id}', [PostController::class, 'destroy'])->name('posts.destroy');
    });

    