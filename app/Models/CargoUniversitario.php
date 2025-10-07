<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CargoUniversitario extends Model
{
    use HasFactory;

    protected $fillable = [
        'docente_id', 'organo', 'cargo', 'periodo', 'funciones', 'activo'
    ];

    protected $casts = [
        'activo' => 'boolean'
    ];

    // Relación con Docente
    public function docente(): BelongsTo
    {
        return $this->belongsTo(Docente::class);
    }

    // Relación con Archivos
    public function archivos(): HasMany
    {
        return $this->hasMany(Archivo::class, 'cargo_id');
    }
}