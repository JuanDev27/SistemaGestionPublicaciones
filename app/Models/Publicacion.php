<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Publicacion extends Model
{
    use HasFactory;

    protected $table = 'publicaciones';
    public $timestamps = false;

    protected $fillable = [
        'tipo',
        'titulo',
        'descripcion',
        'categoria_id',
        'lugar_id',
        'lugar_detalle',
        'fecha_evento',
        'hora_evento',
        'custodia_actual',
        'estado',
        'fecha_creacion',
        'fecha_estado',
    ];

    protected $casts = [
        'fecha_evento' => 'date',
        'fecha_creacion' => 'datetime',
        'fecha_estado' => 'datetime',
    ];

    public function getImagenAttribute($value = null): ?string
    {
        $directory = "publicaciones/{$this->getKey()}";

        foreach (['jpg', 'jpeg', 'png', 'webp'] as $extension) {
            $path = "{$directory}/imagen.{$extension}";

            if (Storage::disk('public')->exists($path)) {
                return $path;
            }
        }

        return null;
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }
}
