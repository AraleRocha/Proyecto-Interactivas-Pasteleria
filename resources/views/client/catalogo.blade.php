{{-- resources/views/catalogo/index.blade.php --}}
<x-app-layout :title="__('Catálogo')">
    <x-amo-styles />

    <style>
        .cat-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 28px;
            margin-bottom: 64px;
        }

        .cat-card {
            background: var(--surface-container-lowest);
            border: 1px solid rgba(225,191,180,0.55);
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 6px 22px rgba(0,0,0,0.05);
            transition: transform 0.25s ease, box-shadow 0.25s ease, border-color 0.25s ease;
            position: relative;
        }

        .cat-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 16px 34px rgba(0,0,0,0.10);
            border-color: rgba(151,49,0,0.18);
        }

        .cat-card-img {
            aspect-ratio: 4/3;
            overflow: hidden;
            position: relative;
            display: block;
            text-decoration: none;
            background: linear-gradient(180deg, rgba(0,0,0,0.02), rgba(0,0,0,0.10));
        }

        .cat-card-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.45s ease;
        }

        .cat-card:hover .cat-card-img img {
            transform: scale(1.06);
        }

        .cat-card-img-placeholder {
            width: 100%;
            height: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 8px;
            color: var(--on-surface-variant);
            background: linear-gradient(135deg, var(--surface-container-low), var(--surface-container));
        }

        .cat-card-img-placeholder .material-symbols-outlined {
            font-size: 42px;
            opacity: 0.35;
        }

        .cat-card-img-placeholder p {
            font-size: 13px;
            opacity: 0.8;
        }

        .cat-badge {
            position: absolute;
            top: 14px;
            left: 14px;
            background: rgba(255,255,255,0.92);
            backdrop-filter: blur(8px);
            padding: 5px 12px;
            border-radius: 9999px;
            font-size: 11px;
            font-weight: 700;
            color: var(--primary);
            box-shadow: 0 6px 18px rgba(0,0,0,0.10);
        }

        .cat-avail {
            position: absolute;
            top: 14px;
            right: 14px;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            box-shadow: 0 0 0 4px rgba(255,255,255,0.85);
        }

        .cat-avail.on {
            background: #22c55e;
        }

        .cat-avail.off {
            background: #ef4444;
        }

        .cat-card-size {
            position: absolute;
            left: 14px;
            bottom: 14px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: rgba(28,27,27,0.72);
            color: white;
            padding: 7px 11px;
            border-radius: 9999px;
            font-size: 12px;
            font-weight: 600;
            backdrop-filter: blur(6px);
        }

        .cat-card-size .material-symbols-outlined {
            font-size: 16px;
        }

        .cat-card-body {
            padding: 18px 18px 20px;
        }

        .cat-card-top {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 12px;
            margin-bottom: 6px;
        }

        .cat-card-name {
            font-family: 'Playfair Display', serif;
            font-size: 20px;
            line-height: 1.15;
            font-weight: 700;
            color: var(--on-surface);
            margin: 0;
        }

        .cat-card-price {
            flex-shrink: 0;
            font-family: 'Playfair Display', serif;
            font-size: 20px;
            font-weight: 700;
            color: var(--primary);
            white-space: nowrap;
        }

        .cat-card-sabor {
            font-size: 13px;
            color: var(--on-surface-variant);
            line-height: 1.5;
            margin: 0 0 14px;
            min-height: 38px;
        }

        .cat-card-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 10px;
            margin-top: 12px;
        }

        .cat-btn-order {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            background: var(--primary);
            color: white;
            border: none;
            padding: 10px 14px;
            border-radius: 14px;
            font-size: 13px;
            font-weight: 700;
            text-decoration: none;
            transition: transform 0.15s ease, opacity 0.15s ease, box-shadow 0.15s ease;
            box-shadow: 0 6px 16px rgba(151,49,0,0.18);
        }

        .cat-btn-order:hover {
            opacity: 0.92;
            transform: translateY(-1px);
        }

        .cat-btn-wish {
            width: 42px;
            height: 42px;
            border-radius: 14px;
            border: 1px solid rgba(225,191,180,0.8);
            background: var(--surface-container-lowest);
            color: var(--on-surface-variant);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: background 0.2s ease, transform 0.15s ease, border-color 0.2s ease;
        }

        .cat-btn-wish:hover {
            background: var(--surface-container-low);
            border-color: rgba(151,49,0,0.20);
            transform: translateY(-1px);
        }

        .cat-card:hover .cat-badge {
            transform: translateY(-1px);
        }
        /* Estilos específicos para el catálogo (grid, hero, filtros) */
        .cat-hero {
            background: linear-gradient(135deg, #3d1f0d 0%, #6b2e18 45%, var(--primary) 100%);
            padding: 48px 40px;
            margin-bottom: 32px;
            position: relative;
            color: white;
        }
        .cat-hero h1 {
            font-family: 'Playfair Display', serif;
            font-size: clamp(36px, 4vw, 56px);
            font-weight: 700;
            max-width: 600px;
            margin: 16px 0;
        }
        .cat-hero h1 em {
            font-style: italic;
            color: var(--blush, #fecbc6);
        }
        .cat-hero p {
            max-width: 480px;
            opacity: 0.8;
            line-height: 1.6;
        }
        .cat-filters {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 16px;
            margin-bottom: 32px;
            padding-bottom: 16px;
            border-bottom: 1px solid var(--outline-variant);
        }
        .cat-tabs {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }
        .cat-tab {
            padding: 8px 20px;
            font-size: 13px;
            font-weight: 600;
            border-radius: 24px;
            background: transparent;
            border: 1px solid var(--outline-variant);
            color: var(--on-surface-variant);
            cursor: pointer;
            transition: all 0.2s;
        }
        .cat-tab.active,
        .cat-tab:hover {
            background: var(--primary);
            border-color: var(--primary);
            color: white;
        }
        .cat-sort {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .cat-sort select {
            padding: 8px 14px;
            border-radius: 40px;
            border: 1px solid var(--outline-variant);
            background: var(--surface-container-lowest);
            font-family: 'Inter', sans-serif;
            font-size: 13px;
        }
        .cat-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 28px;
            margin-bottom: 64px;
        }
        .cat-product-card {
            background: var(--surface-container-lowest);
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0,0,0,0.04);
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .cat-product-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 12px 24px rgba(0,0,0,0.08);
        }
        .cat-card-img {
            aspect-ratio: 4/3;
            overflow: hidden;
            position: relative;
        }
        .cat-card-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.4s;
        }
        .cat-product-card:hover .cat-card-img img {
            transform: scale(1.05);
        }
        .cat-badge {
            position: absolute;
            top: 12px;
            left: 12px;
            background: rgba(255,255,255,0.9);
            backdrop-filter: blur(4px);
            padding: 4px 12px;
            border-radius: 40px;
            font-size: 11px;
            font-weight: 700;
            color: var(--primary);
        }
        .cat-card-body {
            padding: 20px;
        }
        .cat-card-title {
            font-family: 'Playfair Display', serif;
            font-size: 18px;
            font-weight: 700;
            margin-bottom: 4px;
        }
        .cat-card-title a {
            text-decoration: none;
            color: var(--on-surface);
        }
        .cat-card-sabor {
            font-size: 13px;
            color: var(--on-surface-variant);
            margin-bottom: 12px;
        }
        .cat-card-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 16px;
        }
        .cat-price {
            font-size: 20px;
            font-weight: 700;
            color: var(--primary);
            font-family: 'Playfair Display', serif;
        }
        .cat-btn {
            background: var(--primary);
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 40px;
            font-size: 13px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            cursor: pointer;
            transition: opacity 0.2s;
        }
        .cat-btn:hover { opacity: 0.9; }
        .cat-empty {
            text-align: center;
            padding: 80px 20px;
            color: var(--on-surface-variant);
        }
        .cat-bento {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 24px;
            margin-top: 40px;
        }
        .cat-bento-item {
            background: var(--surface-container-low);
            padding: 32px;
        }
        .cat-bento-item.large {
            grid-row: span 2;
            background: linear-gradient(135deg, #3d1f0d, var(--primary));
            color: white;
        }
        .cat-bento-item .material-symbols-outlined {
            font-size: 40px;
            margin-bottom: 16px;
            color: var(--primary);
        }
        .cat-bento-item.large .material-symbols-outlined {
            color: var(--blush);
        }
        @media (max-width: 720px) {
            .cat-bento { grid-template-columns: 1fr; }
        }
    </style>

    {{-- Hero --}}
    <section class="cat-hero">
        <p class="cat-hero-eyebrow" style="font-size:11px;letter-spacing:0.2em;text-transform:uppercase;opacity:0.7;">Colección Artesanal</p>
        <h1>Pasteles para cada <em>celebración</em></h1>
        <p>Creaciones únicas elaboradas con ingredientes de temporada. Cada pieza es un recuerdo que comienza en nuestro obrador.</p>
    </section>

    {{-- Filtros --}}
    <div class="cat-filters mr-5 ml-5">
        <div class="cat-tabs">
            <button class="cat-tab active" data-cat="">Todos</button>
            @foreach(['Boda','Cumpleaños','Bautizo','XV Años','Aniversarios','Baby Showers','Graduaciones'] as $cat)
                <button class="cat-tab" data-cat="{{ strtolower($cat) }}">{{ $cat }}</button>
            @endforeach
        </div>
        <div class="cat-sort">
            <span id="cat-count">{{ $productos->count() }} pasteles</span>
            <select id="sort-select">
                <option value="default">Destacados</option>
                <option value="price-asc">Precio: menor</option>
                <option value="price-desc">Precio: mayor</option>
                <option value="name">Nombre A–Z</option>
            </select>
        </div>
    </div>

    {{-- Grid productos --}}
    <div class="cat-grid" id="product-grid">
 
        @forelse($productos as $producto)
            @php
                $tamanoShort = match(true) {
                    str_contains($producto->tamano, 'Pequeño') => 'Pequeño · 5 pers.',
                    str_contains($producto->tamano, 'Mediano') => 'Mediano · 10 pers.',
                    str_contains($producto->tamano, 'Grande')  => 'Grande · 20 pers.',
                    default => $producto->tamano,
                };
            @endphp
 
            <div class="cat-card"
                 data-categoria="{{ strtolower($producto->categoria) }}"
                 data-precio="{{ $producto->precio }}"
                 data-nombre="{{ strtolower($producto->nombre) }}"
                 data-stock="{{ $producto->stock }}">
 
                {{-- Imagen clickeable --}}
                <a href="{{ route('catalogo.show', $producto->id) }}" class="cat-card-img" style="display:block;text-decoration:none;">
                    @if($producto->imagen)
                        <img src="{{ asset('storage/' . $producto->imagen) }}"
                             alt="{{ $producto->nombre }}"
                             loading="lazy">
                    @else
                        <div class="cat-card-img-placeholder">
                            <span class="material-symbols-outlined">cake</span>
                            <p>Sin imagen</p>
                        </div>
                    @endif
 
                    <span class="cat-badge">{{ $producto->categoria }}</span>
 
                    <div class="cat-card-size">
                        <span class="material-symbols-outlined">people</span>
                        {{ $tamanoShort }}
                    </div>
                </a>
 
                {{-- Body --}}
                <div class="cat-card-body">
                    <div class="cat-card-top">
                        <a href="{{ route('catalogo.show', $producto->id) }}"
                           style="text-decoration:none;flex:1;">
                            <h2 class="cat-card-name">{{ $producto->nombre }}</h2>
                        </a>
                        <span class="cat-card-price">${{ number_format($producto->precio, 0) }}</span>
                    </div>
                    <p class="cat-card-sabor">{{ $producto->sabor }}</p>
 
                    <div class="cat-card-footer">
                        <a href="{{ route('catalogo.show', $producto->id) }}" class="cat-btn-order"
                           style="text-decoration:none;">
                            <span class="material-symbols-outlined" style="font-size:17px;">visibility</span>
                            Ver pastel
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="cat-empty">
                <span class="material-symbols-outlined">cake</span>
                <p>No hay pasteles disponibles en este momento.</p>
            </div>
        @endforelse
    </div>

    {{-- Bento inferior --}}
    <div class="cat-bento">
        <div class="cat-bento-item large">
            <span class="material-symbols-outlined">design_services</span>
            <h3 style="font-family:'Playfair Display',serif;font-size:28px;">Pedido a tu medida</h3>
            <p style="margin-top:8px;">Diseña el pastel de tus sueños con nuestros maestros pasteleros. Personalizamos sabores, tamaños y decoración.</p>
            <a href="#" class="amo-btn-primary" style="margin-top:24px;display:inline-flex;">Solicitar cotización</a>
        </div>
        <div class="cat-bento-item">
            <span class="material-symbols-outlined">workspace_premium</span>
            <h3 style="font-family:'Playfair Display',serif;font-size:22px;">Elaboración artesanal</h3>
            <p>Sin conservadores artificiales, horneado el mismo día.</p>
        </div>
        <div class="cat-bento-item">
            <span class="material-symbols-outlined">local_shipping</span>
            <h3 style="font-family:'Playfair Display',serif;font-size:22px;">Entrega en San Luis Potosí</h3>
            <p>Empaque isotérmico para que llegue perfecto.</p>
        </div>
    </div>

    <script>
        const tabs = document.querySelectorAll('.cat-tab');
        const grid = document.getElementById('product-grid');
        const sortSelect = document.getElementById('sort-select');
        let activeCat = '';

        function filterAndSort() {
            const cards = [...grid.querySelectorAll('.cat-product-card')];
            const sortVal = sortSelect.value;

            // Filtrar
            cards.forEach(card => {
                const match = !activeCat || card.dataset.categoria === activeCat;
                card.style.display = match ? '' : 'none';
            });

            // Ordenar
            const visibleCards = cards.filter(c => c.style.display !== 'none');
            visibleCards.sort((a,b) => {
                if (sortVal === 'price-asc') return parseFloat(a.dataset.precio) - parseFloat(b.dataset.precio);
                if (sortVal === 'price-desc') return parseFloat(b.dataset.precio) - parseFloat(a.dataset.precio);
                if (sortVal === 'name') return a.dataset.nombre.localeCompare(b.dataset.nombre);
                return 0;
            });
            visibleCards.forEach(c => grid.appendChild(c));
            document.getElementById('cat-count').innerText = `${visibleCards.length} pasteles`;
        }

        tabs.forEach(btn => {
            btn.addEventListener('click', () => {
                tabs.forEach(b => b.classList.remove('active'));
                btn.classList.add('active');
                activeCat = btn.dataset.cat;
                filterAndSort();
            });
        });
        sortSelect.addEventListener('change', filterAndSort);
    </script>
</x-app-layout>