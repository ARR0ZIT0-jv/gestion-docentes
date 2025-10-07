<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Usuario extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'docente_id', 'username', 'password', 'rol', 'activo'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'activo' => 'boolean',
        ];
    }

    // Relación con Docente
    public function docente(): BelongsTo
    {
        return $this->belongsTo(Docente::class);
    }

    // Relación con Noticias
    public function noticias(): HasMany
    {
        return $this->hasMany(Noticia::class);
    }

    // Métodos de verificación de rol
    public function isAdministrador(): bool
    {
        return $this->rol === 'administrador';
    }

    public function isDirectiva(): bool
    {
        return $this->rol === 'directiva';
    }

    public function isDocente(): bool
    {
        return $this->rol === 'docente';
    }
}