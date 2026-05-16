<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class producto extends Model
{
    use SoftDeletes;

    protected $casts = [
        'imagenes' => 'array'
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
}
