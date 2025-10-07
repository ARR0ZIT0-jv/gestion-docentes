<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pago extends Model
{
    use HasFactory;

    protected $fillable = [
        'docente_id', 'monto', 'concepto', 'periodo', 'fecha_pago',
        'metodo', 'comprobante', 'observaciones', 'verificado'
    ];

    protected $casts = [
        'monto' => 'decimal:2',
        'fecha_pago' => 'date',
        'verificado' => 'boolean'
    ];

    // Relación con Docente
    public function docente(): BelongsTo
    {
        return $this->belongsTo(Docente::class);
    }

    // Método para formatear el monto
    public function getMontoFormateadoAttribute()
    {
        return '$ ' . number_format($this->monto, 2);
    }

    // Método para obtener el estado de verificación
    public function getEstadoAttribute()
    {
        return $this->verificado ? 'Verificado' : 'Pendiente';
    }

    // Método para obtener la clase CSS del estado
    public function getEstadoClaseAttribute()
    {
        return $this->verificado ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800';
    }
}