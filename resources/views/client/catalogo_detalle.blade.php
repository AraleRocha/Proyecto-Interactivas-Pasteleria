{{-- resources/views/catalogo/show.blade.php --}}
<x-app-layout :title="$producto->nombre">
    <x-amo-styles />

    <style>
        .det-breadcrumb {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 13px;
            color: var(--on-surface-variant);
            margin-bottom: 32px;
        }
        .det-breadcrumb a {
            text-decoration: none;
            color: inherit;
        }
        .det-breadcrumb a:hover { color: var(--primary); }
        .det-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 48px;
            padding: 10px 30px;
            margin-bottom: 64px;
        }
        .det-gallery {
            position: sticky;
            top: 100px;
        }
        .det-main-img {
            border-radius: 24px;
            overflow: hidden;
            background: var(--surface-container-low);
            aspect-ratio: 1/1;
        }
        .det-main-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .det-cat-badge {
            display: inline-block;
            background: var(--primary-fixed);
            color: var(--primary);
            padding: 6px 16px;
            border-radius: 40px;
            font-size: 12px;
            font-weight: 700;
            margin-bottom: 20px;
        }
        .det-title {
            font-family: 'Playfair Display', serif;
            font-size: clamp(32px, 4vw, 44px);
            font-weight: 700;
            margin-bottom: 12px;
        }
        .det-sabor {
            font-size: 18px;
            color: var(--on-surface-variant);
            margin-bottom: 24px;
            font-style: italic;
        }
        .det-price-row {
            display: flex;
            align-items: baseline;
            justify-content: space-between;
            padding: 20px 0;
            border-top: 1px solid var(--outline-variant);
            border-bottom: 1px solid var(--outline-variant);
            margin-bottom: 28px;
        }
        .det-price {
            font-size: 44px;
            font-weight: 700;
            color: var(--primary);
            font-family: 'Playfair Display', serif;
        }
        .det-stock {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: var(--surface-container-high);
            padding: 4px 12px;
            border-radius: 40px;
            font-size: 13px;
            font-weight: 600;
        }
        .det-stock.ok { background: #dcfce7; color: #166534; }
        .det-stock.low { background: #fef9c3; color: #713f12; }
        .det-stock.out { background: #fee2e2; color: #991b1b; }
        .det-specs {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
            margin-bottom: 32px;
        }
        .det-spec {
            background: var(--surface-container-low);
            border-radius: 16px;
            padding: 16px;
            display: flex;
            gap: 12px;
            align-items: center;
        }
        .det-spec .material-symbols-outlined {
            font-size: 24px;
            color: var(--primary);
        }
        .det-actions {
            display: flex;
            flex-direction: column;
            gap: 12px;
            margin-bottom: 32px;
        }
        .det-trust {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
            font-size: 13px;
            color: var(--on-surface-variant);
        }
        .det-trust span {
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        .det-suggestions {
            margin-top: 64px;
        }
        .det-suggestions h2 {
            font-family: 'Playfair Display', serif;
            font-size: 28px;
            margin-bottom: 24px;
        }
        .det-sug-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
            gap: 24px;
        }
        @media (max-width: 780px) {
            .det-grid { grid-template-columns: 1fr; }
            .det-gallery { position: static; }
        }
    </style>

    <nav class="det-breadcrumb">
        <a href="{{ route('catalogo.index') }}">Catálogo</a>
        <span class="material-symbols-outlined" style="font-size:16px;">chevron_right</span>
        <span class="current">{{ $producto->nombre }}</span>
    </nav>

    <div class="det-grid">
        {{-- Galería --}}
        <div class="det-gallery">
            <div class="det-main-img">
                @if($producto->imagen)
                    <img src="{{ asset('storage/' . $producto->imagen) }}" alt="{{ $producto->nombre }}">
                @else
                    <div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;">
                        <span class="material-symbols-outlined" style="font-size:80px;color:var(--outline-variant);">cake</span>
                    </div>
                @endif
            </div>
        </div>

        {{-- Info --}}
        <div class="det-info">
            <span class="det-cat-badge">{{ $producto->categoria }}</span>
            <h1 class="det-title">{{ $producto->nombre }}</h1>
            <p class="det-sabor">{{ $producto->sabor }}</p>

            <div class="det-price-row">
                <div>
                    <span class="det-price">${{ number_format($producto->precio, 0) }}</span>
                    <span style="font-size:14px;color:var(--on-surface-variant);"> MXN</span>
                </div>
                @php
                    $stockClass = $producto->stock > 10 ? 'ok' : ($producto->stock > 0 ? 'low' : 'out');
                    $stockLabel = $producto->stock > 10 ? 'Disponible' : ($producto->stock > 0 ? "Últimas {$producto->stock}" : 'Sin stock');
                @endphp
                <div class="det-stock {{ $stockClass }}">
                    <span class="material-symbols-outlined" style="font-size:14px;">inventory</span>
                    {{ $stockLabel }}
                </div>
            </div>

            <div class="det-specs">
                <div class="det-spec">
                    <span class="material-symbols-outlined">straighten</span>
                    <div><strong>Tamaño</strong><br>{{ $producto->tamano }}</div>
                </div>
                <div class="det-spec">
                    <span class="material-symbols-outlined">schedule</span>
                    <div><strong>Anticipo</strong><br>48 horas</div>
                </div>
            </div>

            <div class="det-actions">
                @if($producto->stock > 0)
                    <button class="amo-btn-primary" onclick="abrirModal()">
                        <span class="material-symbols-outlined">shopping_bag</span> Realizar pedido
                    </button>
                @else
                    <button class="amo-btn-primary" disabled style="opacity:0.5;cursor:not-allowed;">
                        <span class="material-symbols-outlined">remove_shopping_cart</span> Sin stock
                    </button>
                @endif
            </div>

            <div class="det-trust">
                <span><span class="material-symbols-outlined">verified</span> Ingredientes naturales</span>
                <span><span class="material-symbols-outlined">local_shipping</span> Entrega en SLP</span>
                <span><span class="material-symbols-outlined">handshake</span> Hecho a pedido</span>
            </div>
        </div>
    </div>

    {{-- Sugerencias --}}
    @if($sugerencias->count())
        <div class="det-suggestions">
            <h2>También te puede gustar</h2>
            <div class="det-sug-grid">
                @foreach($sugerencias as $sug)
                    <a href="{{ route('catalogo.show', $sug->id) }}" class="amo-card" style="text-decoration:none;display:block;">
                        <div style="aspect-ratio:4/3;overflow:hidden;">
                            @if($sug->imagen)
                                <img src="{{ asset('storage/' . $sug->imagen) }}" alt="{{ $sug->nombre }}" style="width:100%;height:100%;object-fit:cover;">
                            @endif
                        </div>
                        <div class="amo-card-body">
                            <h3 style="font-family:'Playfair Display',serif;font-weight:600;margin:0 0 4px;">{{ $sug->nombre }}</h3>
                            <p style="font-size:13px;color:var(--on-surface-variant);">{{ $sug->sabor }}</p>
                            <p style="font-weight:700;color:var(--primary);">${{ number_format($sug->precio,0) }}</p>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    @endif

    {{-- Modal pedido --}}
<div
    class="det-modal-overlay"
    id="modal-overlay"
    onclick="handleOverlayClick(event)"
>
    <div class="det-modal">

        <div class="det-modal-handle"></div>

        <h2>Realizar pedido</h2>

        <p class="det-modal-sub">
            Completa los datos para confirmar tu pedido.
        </p>

        <div class="det-modal-summary">

            <div>
                <p class="det-modal-summary-name">
                    {{ $producto->nombre }}
                </p>

                <p style="font-size:12px;">
                    {{ $producto->tamano }}
                    ·
                    {{ $producto->sabor }}
                </p>
            </div>

            <p class="det-modal-summary-price">
                ${{ number_format($producto->precio, 0) }}
            </p>

        </div>

        <form action="{{ route('pedidos.agregar') }}" method="POST">
            @csrf

            <input type="hidden" name="producto_id" value="{{ $producto->id }}">

            <label class="det-modal-label">Cantidad *</label>
            <input
                type="number"
                name="cantidad"
                class="det-modal-input"
                min="1"
                max="{{ $producto->stock }}"
                value="1"
                required
            >

            <button type="submit" class="det-modal-submit">Agregar al pedido</button>
        </form>

    </div>
</div>

    <style>
        /* Modal styles (complemento) */
        .det-modal-overlay {
            position: fixed; inset: 0; z-index: 100;
            background: rgba(0,0,0,0.6); backdrop-filter: blur(4px);
            display: flex; align-items: center; justify-content: center;
            opacity: 0; pointer-events: none;
            transition: opacity 0.3s;
        }
        .det-modal-overlay.open { opacity: 1; pointer-events: all; }
        .det-modal {
            background: var(--surface-container-lowest);
            border-radius: 24px;
            padding: 32px;
            width: 100%; max-width: 520px;
            transform: translateY(40px);
            transition: transform 0.35s;
            max-height: 90vh; overflow-y: auto;
        }
        .det-modal-overlay.open .det-modal { transform: translateY(0); }
        .det-modal-handle {
            width: 40px; height: 4px; background: var(--outline-variant);
            border-radius: 9999px; margin: 0 auto 20px;
        }
        .det-modal h2 {
            font-family: 'Playfair Display', serif;
            font-size: 26px; font-weight: 700;
        }
        .det-modal-sub { color: var(--on-surface-variant); margin-bottom: 24px; }
        .det-modal-summary {
            background: var(--surface-container-low);
            border-radius: 16px;
            padding: 16px;
            display: flex;
            justify-content: space-between;
            margin-bottom: 24px;
        }
        .det-modal-summary-name { font-weight: 700; }
        .det-modal-summary-price {
            font-family: 'Playfair Display', serif;
            font-size: 22px; font-weight: 700; color: var(--primary);
        }
        .det-modal-label {
            display: block; font-size: 12px; font-weight: 600;
            margin-bottom: 6px; color: var(--on-surface-variant);
        }
        .det-modal-input, .det-modal-textarea {
            width: 100%; padding: 12px;
            border: 1px solid var(--outline-variant);
            border-radius: 12px;
            background: var(--surface);
            margin-bottom: 16px;
        }
        .det-modal-row { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
        .det-modal-submit {
            width: 100%; padding: 14px;
            background: var(--primary); color: white;
            border: none; border-radius: 12px;
            font-weight: 700; cursor: pointer;
        }
        @media (max-width: 600px) {
            .det-modal-row { grid-template-columns: 1fr; }
        }
    </style>

    <script>
        function abrirModal() {
            document.getElementById('modal-overlay').classList.add('open');
            document.body.style.overflow = 'hidden';
        }
        function cerrarModal() {
            document.getElementById('modal-overlay').classList.remove('open');
            document.body.style.overflow = '';
        }
        function handleOverlayClick(e) {
            if (e.target === document.getElementById('modal-overlay')) cerrarModal();
        }
        document.addEventListener('keydown', e => { if (e.key === 'Escape') cerrarModal(); });

        // Wishlist visual
        const wishBtn = document.getElementById('wish-btn');
        if (wishBtn) {
            wishBtn.addEventListener('click', () => {
                const icon = document.getElementById('wish-icon');
                const isOn = icon.textContent.trim() === 'favorite';
                icon.textContent = isOn ? 'favorite_border' : 'favorite';
                icon.style.color = isOn ? '' : 'var(--primary)';
                wishBtn.style.background = isOn ? '' : 'var(--primary-fixed)';
            });
        }
    </script>
</x-app-layout>