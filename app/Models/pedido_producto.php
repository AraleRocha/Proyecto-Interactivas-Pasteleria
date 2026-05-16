<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class pedido_producto extends Model
{
    use SoftDeletes;
 
    protected $table = 'pedido_productos';
 
    protected $fillable = [
        'pedido_id',
        'producto_id',
        'cantidad',
        'precio_unitario',
        'subtotal',
    ];
 
    protected $casts = [
        'precio_unitario' => 'decimal:2',
        'subtotal'        => 'decimal:2',
    ];
 
    public function pedido(): BelongsTo
    {
        return $this->belongsTo(Pedido::class);
    }
 
    public function producto(): BelongsTo
    {
        return $this->belongsTo(Producto::class);
    }
}
