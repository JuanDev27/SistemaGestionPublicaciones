<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Message extends Model
{
    use HasFactory;

    protected $table = 'mensajes';
    public $timestamps = false;

    protected $fillable = [
        'conversacion_id',
        'remitente_id',
        'contenido',
    ];

    protected $casts = [
        'fecha_envio' => 'datetime',
    ];

    public function conversation(): BelongsTo
    {
        return $this->belongsTo(Conversation::class, 'conversacion_id');
    }

    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'remitente_id');
    }

    public function notification(): HasOne
    {
        return $this->hasOne(Notification::class, 'mensaje_id');
    }
}
