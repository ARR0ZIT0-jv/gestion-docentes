<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Archivo extends Model
{
    use HasFactory;

    protected $fillable = [
        'titulo', 'descripcion', 'nombre_archivo', 'ruta_archivo',
        'extension', 'tamanio', 'tipo', 'docente_id', 'evento_id', 'cargo_id'
    ];

    // Relación con Docente (quien subió el archivo)
    public function docente(): BelongsTo
    {
        return $this->belongsTo(Docente::class);
    }

    // Relación con Evento
    public function evento(): BelongsTo
    {
        return $this->belongsTo(Evento::class);
    }

    // Relación con CargoUniversitario
    public function cargoUniversitario(): BelongsTo
    {
        return $this->belongsTo(CargoUniversitario::class, 'cargo_id');
    }
}