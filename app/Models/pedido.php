<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class pedido extends Model
{
    use SoftDeletes;
 
    protected $fillable = [
        'user_id',
        'fecha_pedido',
        'fecha_entrega',
        'estado',
        'total',
    ];
 
    protected $casts = [
        'fecha_pedido'  => 'datetime',
        'fecha_entrega' => 'date',
        'total'         => 'decimal:2',
    ];

    public const ESTADOS = [
        'borrador'       => 'Borrador',
        'pendiente'      => 'Pendiente',
        'por_confirmar'  => 'Por confirmar',
        'horneando'      => 'Horneando',
        'listo'          => 'Listo para entrega',
        'rechazado'      => 'Rechazado',
        'cancelado'      => 'Cancelado',
    ];
    
    /* ── Relaciones ── */
 
    public function user()
    {
        return $this->belongsTo(User::class);
    }
 
    public function productos()
    {
        return $this->hasMany(Pedido_Producto::class);
    }
 
    public function pago()
    {
        return $this->hasOne(Pago::class);
    }
 
    /* ── Helpers ── */
 
    public function recalcularTotal(): void
    {
        $this->total = $this->productos()->sum('subtotal');
        $this->save();
    }
}
