<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Publicacion extends Model
{
    use HasFactory;
    protected $table = 'publicaciones';
    public function user()
{
    return $this->belongsTo(User::class,'usuario_id');/*Pertenece a clase user */
}

protected $fillable = [
    'titulo',
    'contenido',
    'user_id',
];

}
