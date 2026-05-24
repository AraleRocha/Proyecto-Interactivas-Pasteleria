<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class producto extends Model
{
    use SoftDeletes;

    protected $casts = [
        'imagenes' => 'array',
        'disponible' => 'boolean'
    ];

    protected $fillable = [
        'nombre',
        'sabor',
        'tamano',
        'categoria',
        'precio',
        'stock',
        'disponible',
        'imagen'
    ];

    // Calcular de manera automática la disponibilidad según el stock
    protected static function booted()
    {
        static::saving(function ($producto) {

            if ($producto->stock <= 0) {
                $producto->disponible = false;
            } else {
                $producto->disponible = true;
            }

        });
    }
}
