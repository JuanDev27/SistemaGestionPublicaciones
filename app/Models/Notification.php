<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notification extends Model
{
    use HasFactory;

    protected $table = 'notificaciones';
    public $timestamps = false;

    protected $fillable = [
        'usuario_id',
        'mensaje_id',
        'leida',
    ];

    protected $casts = [
        'leida' => 'boolean',
        'fecha_creacion' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function message(): BelongsTo
    {
        return $this->belongsTo(Message::class, 'mensaje_id');
    }
}
