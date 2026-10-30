<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class CamposPublicacion extends Component
{
    public $post; // Para almacenar la variable post

    public function __construct($post = null)
    {
        $this->post = $post;
    }

    public function render()
    {
        return view('components.campos-publicacion');
    }
}
