<x-app-layout :title="'Pedido #' . str_pad($pedido->id, 5, '0', STR_PAD_LEFT)">
    <x-amo-styles />

    <div style="max-width:1100px;margin:0 auto;padding:40px 32px 80px;">
        <h1 style="font-family:'Playfair Display',serif;font-size:40px;font-weight:700;margin-bottom:12px;">
            Pedido #{{ str_pad($pedido->id, 5, '0', STR_PAD_LEFT) }}
        </h1>

        <p style="color:var(--on-surface-variant);margin-bottom:24px;">
            Cliente: {{ $pedido->user->name }} · {{ $pedido->user->email }}
        </p>

        <div style="display:grid;grid-template-columns:1fr .7fr;gap:24px;">
            <div style="background:var(--surface-container-lowest);border:1px solid var(--outline-variant);border-radius:20px;padding:24px;">
                <h3 style="font-family:'Playfair Display',serif;margin-bottom:16px;">Productos</h3>

                @foreach($pedido->productos as $item)
                    <div style="display:flex;justify-content:space-between;gap:16px;padding:12px 0;border-bottom:1px solid var(--outline-variant);">
                        <div>
                            <strong>{{ $item->producto->nombre }}</strong><br>
                            <span style="color:var(--on-surface-variant);font-size:13px;">
                                Cantidad: {{ $item->cantidad }}
                            </span>
                        </div>
                        <strong>${{ number_format($item->subtotal, 0) }}</strong>
                    </div>
                @endforeach
            </div>

            <div style="display:grid;gap:20px;">
                <div style="background:var(--surface-container-lowest);border:1px solid var(--outline-variant);border-radius:20px;padding:24px;">
                    <h3 style="font-family:'Playfair Display',serif;margin-bottom:16px;">Estado actual</h3>

                    <p style="font-size:18px;font-weight:700;">
                        {{ ucfirst(str_replace('_', ' ', $pedido->estado)) }}
                    </p>

                    <p style="color:var(--on-surface-variant);margin-top:8px;">
                        Fecha pedido: {{ $pedido->fecha_pedido->format('d/m/Y H:i') }}
                    </p>

                    @if($pedido->fecha_entrega)
                        <p style="color:var(--on-surface-variant);">
                            Fecha entrega: {{ $pedido->fecha_entrega->format('d/m/Y') }}
                        </p>
                    @endif
                </div>

                <div style="background:var(--surface-container-lowest);border:1px solid var(--outline-variant);border-radius:20px;padding:24px;">
                    <h3 style="font-family:'Playfair Display',serif;margin-bottom:16px;">Acciones</h3>

                    @if($pedido->estado === 'por_confirmar')
                        <form action="{{ route('pedidos.aprobar', $pedido) }}" method="POST" style="margin-bottom:12px;">
                            @csrf
                            <button type="submit" class="btn-primary" style="width:100%;">Aprobar</button>
                        </form>

                        <form action="{{ route('pedidos.rechazar', $pedido) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn-danger" style="width:100%;">Rechazar</button>
                        </form>
                    @endif

                    @if($pedido->estado === 'horneando')
                        <form action="{{ route('pedidos.listo', $pedido) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn-primary" style="width:100%;">Listo para entrega</button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>