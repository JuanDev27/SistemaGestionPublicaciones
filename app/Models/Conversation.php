<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Conversation extends Model
{
    use HasFactory;

    protected $table = 'conversaciones';
    public $timestamps = false;

    protected $fillable = [
        'publicacion_id',
        'iniciador_id',
        'estado',
    ];

    protected $casts = [
        'fecha_creacion' => 'datetime',
    ];

    public function publication(): BelongsTo
    {
        return $this->belongsTo(Publicacion::class, 'publicacion_id');
    }

    public function initiator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'iniciador_id');
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class, 'conversacion_id')
            ->orderBy('fecha_envio')
            ->orderBy('id');
    }

    public function notifications(): HasMany
    {
        return $this->hasManyThrough(
            Notification::class,
            Message::class,
            'conversacion_id',
            'mensaje_id'
        );
    }

    public function includesUser(int $userId): bool
    {
        return (int) $this->iniciador_id === $userId
            || (int) $this->publication->usuario_id === $userId;
    }
}
