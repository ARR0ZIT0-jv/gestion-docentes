<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Evento extends Model
{
    use HasFactory;

    protected $fillable = [
        'titulo', 'descripcion', 'fecha_inicio', 'fecha_fin', 
        'lugar', 'tipo', 'estado', 'cupo_maximo'
    ];

    protected $casts = [
        'fecha_inicio' => 'datetime',
        'fecha_fin' => 'datetime',
    ];

    // Relación con docentes (a través de asistencias)
    public function docentes(): BelongsToMany
    {
        return $this->belongsToMany(Docente::class, 'asistencias')
                    ->withPivot('confirmado', 'asistio', 'observaciones')
                    ->withTimestamps();
    }

    // Relación directa con asistencias
    public function asistencias()
    {
        return $this->hasMany(Asistencia::class);
    }

    // Método para verificar si hay cupos disponibles
    public function tieneCuposDisponibles()
    {
        if (!$this->cupo_maximo) return true;
        return $this->docentes()->count() < $this->cupo_maximo;
    }

    // Método para obtener cupos disponibles
    public function cuposDisponibles()
    {
        if (!$this->cupo_maximo) return 'Ilimitado';
        return $this->cupo_maximo - $this->docentes()->count();
    }

    // Método para verificar si el evento está activo
    public function estaActivo()
    {
        return $this->estado === 'planificado' || $this->estado === 'confirmado';
    }
    
}