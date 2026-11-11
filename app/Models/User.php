<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'usuarios';
    public $timestamps = false;

    public function publicaciones()
    {
        return $this->hasMany(Publicacion::class, 'usuario_id');
    }

    protected $fillable = [
        'nombres',
        'apellidos',
        'correo',
        'telefono',
        'password',
        'programa_academico',
        'codigo_estudiantil',
        'rol',
        'estado',
        'fecha_registro',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'password' => 'hashed',
        'fecha_registro' => 'datetime',
    ];

    public function getAuthPassword()
    {
        return $this->password;
    }

    public function getEmailForPasswordReset()
    {
        return $this->correo;
    }

    public function routeNotificationForMail($notification = null)
    {
        return $this->correo;
    }

    public function getRememberTokenName()
    {
        return '';
    }
}
