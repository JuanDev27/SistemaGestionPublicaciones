<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lugar extends Model
{
    use HasFactory;

    protected $table = 'lugares';

    protected $fillable = [
        'nombre',
    ];

    public function publicaciones()
    {
        return $this->hasMany(Publicacion::class, 'lugar_id');
    }
}
