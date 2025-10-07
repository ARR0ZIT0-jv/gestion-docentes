<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventario extends Model
{
    use HasFactory;

    protected $fillable = [
        'codigo_inventario', 'nombre', 'descripcion', 'categoria',
        'marca', 'modelo', 'numero_serie', 'valor', 'fecha_adquisicion',
        'estado', 'ubicacion', 'observaciones'
    ];

    protected $casts = [
        'valor' => 'decimal:2',
        'fecha_adquisicion' => 'date'
    ];
}