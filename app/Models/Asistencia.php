<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Asistencia extends Model
{
    use HasFactory;

    protected $fillable = [
        'evento_id', 'docente_id', 'confirmado', 'asistio', 'observaciones'
    ];

    protected $casts = [
        'confirmado' => 'boolean',
        'asistio' => 'boolean',
        'fecha_inscripcion' => 'datetime'
    ];

    // Relación con Evento
    public function evento(): BelongsTo
    {
        return $this->belongsTo(Evento::class);
    }

    // Relación con Docente
    public function docente(): BelongsTo
    {
        return $this->belongsTo(Docente::class);
    }
}