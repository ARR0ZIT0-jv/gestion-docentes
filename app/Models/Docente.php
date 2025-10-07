<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Docente extends Model
{
    use HasFactory;

    protected $fillable = [
        'codigo', 'nombres', 'apellidos', 'email', 'telefono',
        'departamento', 'grado_academico', 'fecha_ingreso', 'activo'
    ];

    protected $casts = [
        'fecha_ingreso' => 'date',
        'activo' => 'boolean'
    ];

    // Relación con Usuario
    public function usuario(): HasOne
    {
        return $this->hasOne(Usuario::class);
    }

    // Relación con Directiva
    public function directivas(): HasMany
    {
        return $this->hasMany(Directiva::class);
    }

    // Relación con CargosUniversitarios
    public function cargosUniversitarios(): HasMany
    {
        return $this->hasMany(CargoUniversitario::class);
    }

    // Relación con Pagos
   // Agregar esta relación al modelo Docente
public function pagos()
{
    return $this->hasMany(Pago::class);
}

// Método para calcular el total pagado por el docente
public function getTotalPagadoAttribute()
{
    return $this->pagos()->sum('monto');
}

// Método para obtener los últimos pagos
public function getUltimosPagos($limit = 5)
{
    return $this->pagos()->orderBy('fecha_pago', 'desc')->limit($limit)->get();
}

    // Relación con Eventos (a través de asistencias)
  public function eventos(): BelongsToMany
{
    return $this->belongsToMany(Evento::class, 'asistencias')
                ->withPivot('confirmado', 'asistio', 'observaciones')
                ->withTimestamps();
}

    // Relación con Archivos (docente que subió el archivo)
    public function archivosSubidos(): HasMany
    {
        return $this->hasMany(Archivo::class);
    }

    // Método para nombre completo
    public function getNombreCompletoAttribute()
    {
        return $this->nombres . ' ' . $this->apellidos;
    }
    // Agregar esta relación al modelo Docente
// Relación con Directiva

}
