<x-mail::message>
# {{ $config['titulo'] }}

Hola, **{{ $cliente->name }}**

{{ $config['mensaje'] }}

---

## Detalle del pedido

<x-mail::panel>
**Pedido:** #{{ str_pad($pedido->id, 5, '0', STR_PAD_LEFT) }}

**Fecha:** {{ $pedido->fecha_pedido->format('d/m/Y H:i') }}

@if($pedido->fecha_entrega && !in_array($pedido->estado, ['cancelado','rechazado']))
**Entrega:** {{ $pedido->fecha_entrega->format('d/m/Y') }}
@endif

@if($pedido->pago)
**Método de pago:** {{ ucfirst($pedido->pago->metodo_pago) }}
@endif

**Estado:** {{ \App\Models\Pedido::ESTADOS[$pedido->estado] ?? ucfirst($pedido->estado) }}
</x-mail::panel>

@if($pedido->productos->count())

## Productos

<x-mail::table>
| Producto | Cantidad | Subtotal |
|:----------|:--------:|----------:|
@foreach($pedido->productos as $item)
| {{ $item->producto?->nombre ?? '—' }} | x{{ $item->cantidad }} | ${{ number_format($item->subtotal,0) }} |
@endforeach
</x-mail::table>

@endif

## Total

# ${{ number_format($pedido->total,0) }} MXN


@if(in_array($pedido->estado, ['cancelado', 'rechazado']))
<x-mail::panel>
¿Tienes alguna pregunta? Escríbenos a mariana@amoretti.mx
</x-mail::panel>
@endif

Gracias,<br>
{{ config('app.name') }}
</x-mail::message>