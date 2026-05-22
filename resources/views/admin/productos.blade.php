<x-app-layout :title="__('Pasteles')">
    <x-amo-styles />

    {{-- ══════ MAIN ══════ --}}
    <main class="amo-main">

        {{-- Page title --}}
        <div style="display:flex;justify-content:space-between;align-items:flex-start;flex-wrap:wrap;gap:16px;margin-bottom:32px;">
            <div>
                <h2 style="font-family:'Playfair Display',serif;font-size:32px;font-weight:600;color:var(--on-surface);line-height:1.2;">
                    Inventario de Pasteles
                </h2>
                <p style="font-size:16px;color:var(--on-surface-variant);margin-top:4px;">
                    Gestione la disponibilidad y stock de sus creaciones artesanales.
                </p>
            </div>
            <a href="{{ route('productos.create') }}" class="amo-btn-primary">
                <span class="material-symbols-outlined" style="font-size:20px;">add</span>
                Nuevo Pastel
            </a>
        </div>

        {{-- Flash --}}
        @if(session('success'))
            <div class="amo-flash-ok">{{ session('success') }}</div>
        @endif

        {{-- Metric Cards --}}
        <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(180px,1fr));gap:20px;margin-bottom:32px;">
            <div class="amo-metric-card">
                <span class="amo-metric-label">Total SKU</span>
                <span class="amo-metric-value primary">{{ $productos->count() }}</span>
                <span class="amo-metric-sub" style="color:#16a34a;">
                    <span class="material-symbols-outlined" style="font-size:14px;">trending_up</span> Catálogo activo
                </span>
            </div>
            <div class="amo-metric-card">
                <span class="amo-metric-label">Poco Stock</span>
                <span class="amo-metric-value">{{ $productos->filter(fn($p) => $p->stock > 0 && $p->stock <= 5)->count() }}</span>
                <span class="amo-metric-sub" style="color:var(--primary);">
                    <span class="material-symbols-outlined" style="font-size:14px;">warning</span> Acción requerida
                </span>
            </div>
            <div class="amo-metric-card">
                <span class="amo-metric-label">Disponibles</span>
                <span class="amo-metric-value">{{ $productos->where('disponible', true)->count() }}</span>
                <span class="amo-metric-sub" style="color:#16a34a;">
                    <span class="material-symbols-outlined" style="font-size:14px;">cake</span> En tienda
                </span>
            </div>
            <div class="amo-metric-card" style="border:1px solid rgba(151,49,0,0.15);">
                <span class="amo-metric-label" style="color:var(--primary);">Valor Stock</span>
                <span class="amo-metric-value">
                    ${{ number_format($productos->sum(fn($p) => $p->precio * $p->stock), 0) }}
                </span>
                <span class="amo-metric-sub" style="color:var(--on-surface-variant);opacity:.6;">Inventario activo</span>
            </div>
        </div>

        {{-- Table Card --}}
        <div class="amo-table-card">

            {{-- Toolbar --}}
            <div class="amo-table-toolbar">
                <div></div>
                <div style="display:flex;align-items:center;gap:10px;flex-wrap:wrap;">
                    <form method="GET" style="display:flex;align-items:center;gap:10px;flex-wrap:wrap;">
                        <select class="amo-filter-select" id="filter-categoria" name="categoria" onchange="filtrarTabla()">
                            <option value="">Todas las categorías</option>
                            @foreach(['Boda','Cumpleaños','Bautizo','XV Años','Sin Gluten'] as $cat)
                                <option value="{{ $cat }}" @selected(request('categoria') === $cat)>
                                    {{ $cat }}
                                </option>
                            @endforeach
                        </select>

                        <button
                            type="submit"
                            formaction="{{ route('reportes.pasteles.stream') }}"
                            formtarget="_blank"
                            class="amo-icon-btn"
                            title="Ver reporte"
                        >
                            <span class="material-symbols-outlined">visibility</span>
                        </button>

                        <button
                            type="submit"
                            formaction="{{ route('reportes.pasteles.descargar') }}"
                            class="amo-icon-btn"
                            title="Descargar PDF"
                        >
                            <span class="material-symbols-outlined">download</span>
                        </button>
                    </form>
                </div>
            </div>

            {{-- Table --}}
            <div style="overflow-x:auto;">
                <table id="tabla-productos">
                    <thead>
                        <tr>
                            <th>Imagen</th>
                            <th>Nombre</th>
                            <th>Sabor</th>
                            <th>Tamaño</th>
                            <th>Categoría</th>
                            <th>Precio</th>
                            <th>Stock</th>
                            <th>Estado</th>
                            <th style="text-align:right;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($productos as $producto)
                            @php
                                $stockPct = $producto->stock > 0 ? min(100, ($producto->stock / max($producto->stock, 30)) * 100) : 0;
                                $stockColor = $producto->stock > 10 ? '#16a34a' : ($producto->stock > 0 ? '#d97706' : '#dc2626');
                            @endphp
                            <tr data-nombre="{{ strtolower($producto->nombre) }}"
                                data-categoria="{{ strtolower($producto->categoria) }}"
                                data-disponible="{{ $producto->disponible ? '1' : '0' }}">

                                {{-- Imagen --}}
                                <td>
                                    @if($producto->imagen)
                                        <div style="width:56px;height:56px;border-radius:10px;overflow:hidden;border:1px solid var(--surface-container-highest);box-shadow:0 2px 8px rgba(0,0,0,0.06);">
                                            <img src="{{ asset('storage/' . $producto->imagen) }}"
                                                 alt="{{ $producto->nombre }}"
                                                 style="width:100%;height:100%;object-fit:cover;">
                                        </div>
                                    @else
                                        <div style="width:56px;height:56px;border-radius:10px;background:var(--surface-container);display:flex;align-items:center;justify-content:center;">
                                            <span class="material-symbols-outlined" style="color:var(--on-surface-variant);font-size:22px;">image_not_supported</span>
                                        </div>
                                    @endif
                                </td>

                                {{-- Nombre --}}
                                <td>
                                    <p style="font-weight:600;font-size:14px;color:var(--on-surface);">{{ $producto->nombre }}</p>
                                </td>

                                {{-- Sabor --}}
                                <td style="color:var(--on-surface-variant);">{{ $producto->sabor }}</td>

                                {{-- Tamaño --}}
                                <td style="color:var(--on-surface-variant);">{{ $producto->tamano }}</td>

                                {{-- Categoría --}}
                                <td>
                                    <span class="amo-badge amo-badge-classic">{{ $producto->categoria }}</span>
                                </td>

                                {{-- Precio --}}
                                <td>
                                    <span style="font-weight:700;color:var(--primary);">${{ number_format($producto->precio, 2) }}</span>
                                </td>

                                {{-- Stock --}}
                                <td>
                                    <div class="amo-stock-bar">
                                        <div class="amo-bar-track">
                                            <div class="amo-bar-fill" style="width:{{ $stockPct }}%;background:{{ $stockColor }};"></div>
                                        </div>
                                        <span style="font-size:13px;font-weight:600;color:{{ $stockColor }};">{{ $producto->stock }}</span>
                                    </div>
                                </td>

                                {{-- Estado --}}
                                <td>
                                    @if($producto->disponible)
                                        <span class="amo-status-badge amo-status-on">
                                            <span class="amo-status-dot"></span> Disponible
                                        </span>
                                    @else
                                        <span class="amo-status-badge amo-status-off">
                                            <span class="amo-status-dot"></span> No disponible
                                        </span>
                                    @endif
                                </td>

                                {{-- Acciones --}}
                                <td style="text-align:right;">
                                    <div style="display:flex;justify-content:flex-end;gap:8px;align-items:center;">
                                        <a href="{{ route('productos.edit', $producto->id) }}" class="amo-btn-edit">
                                            <span class="material-symbols-outlined" style="font-size:15px;margin-right:4px;">edit</span>Editar
                                        </a>
                                        <form action="{{ route('productos.destroy', $producto->id) }}" method="POST"
                                              onsubmit="return confirm('¿Eliminar este producto?')" style="margin:0;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="amo-btn-del">
                                                <span class="material-symbols-outlined" style="font-size:15px;margin-right:4px;">delete</span>Eliminar
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" style="text-align:center;padding:48px 24px;">
                                    <span class="material-symbols-outlined" style="font-size:48px;color:var(--outline-variant);display:block;margin-bottom:12px;">inventory_2</span>
                                    <p style="color:var(--on-surface-variant);font-size:15px;">No hay productos registrados.</p>
                                    <a href="{{ route('productos.create') }}" class="amo-btn-primary" style="margin-top:16px;display:inline-flex;">
                                        <span class="material-symbols-outlined" style="font-size:18px;">add</span> Crear el primero
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if(method_exists($productos, 'links'))
            <div class="amo-pagination">
                <span style="font-size:13px;color:var(--on-surface-variant);">
                    Mostrando {{ $productos->firstItem() }}–{{ $productos->lastItem() }} de {{ $productos->count() }} pasteles
                </span>
                <div style="display:flex;align-items:center;gap:6px;">
                    {{ $productos->links() }}
                </div>
            </div>
            @endif
        </div>
    </main>

    <script>
        function filtrarTabla() {
            const search = document.getElementById('search-input')?.value.toLowerCase() ?? '';
            const categoria = document.getElementById('filter-categoria').value.toLowerCase();
            const disponible = document.getElementById('filter-disponible')?.value ?? '';
            const rows = document.querySelectorAll('#tabla-productos tbody tr[data-nombre]');

            rows.forEach(row => {
                const nombre = row.dataset.nombre || '';
                const rowCategoria = row.dataset.categoria || '';
                const rowDisp = row.dataset.disponible || '';

                const matchSearch = nombre.includes(search);
                const matchCategoria = categoria === '' || rowCategoria.includes(categoria);
                const matchDisponible = disponible === '' || rowDisp === disponible;

                row.style.display = matchSearch && matchCategoria && matchDisponible ? '' : 'none';
            });
        }
    </script>
</x-app-layout>