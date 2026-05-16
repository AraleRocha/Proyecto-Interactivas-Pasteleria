<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class pago extends Model
{
    use SoftDeletes;
 
    protected $fillable = [
        'pedido_id',
        'metodo_pago',
        'estado_pago',
        'monto',
    ];
 
    protected $casts = [
        'monto' => 'decimal:2',
    ];
 
    public function pedido(): BelongsTo
    {
        return $this->belongsTo(Pedido::class);
    }
}
