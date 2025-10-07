<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Directiva extends Model
{
    use HasFactory;

    protected $fillable = [
        'docente_id', 'cargo', 'descripcion', 'fecha_inicio', 'fecha_fin', 'vigente'
    ];

    protected $casts = [
        'fecha_inicio' => 'date',
        'fecha_fin' => 'date',
        'vigente' => 'boolean'
    ];

    // Relación con Docente
    public function docente(): BelongsTo
    {
        return $this->belongsTo(Docente::class);
    }
}