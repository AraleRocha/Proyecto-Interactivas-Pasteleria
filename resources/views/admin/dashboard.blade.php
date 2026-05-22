<x-app-layout title="Dashboard Admin">
    <x-amo-styles />

    <style>
        .dash-wrap{max-width:1300px;margin:0 auto;padding:24px;}
        .dash-title{font-family:'Playfair Display',serif;font-size:clamp(30px,4vw,46px);font-weight:700;margin:0;}
        .dash-sub{color:var(--on-surface-variant);margin-top:6px;}
        .dash-cards{display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:20px;margin:28px 0;}
        .dash-card{background:var(--surface-container-lowest);border:1px solid var(--outline-variant);border-radius:24px;padding:22px;box-shadow:0 4px 18px rgba(0,0,0,.04);}
        .dash-label{font-size:12px;font-weight:700;letter-spacing:.08em;text-transform:uppercase;color:var(--on-surface-variant);}
        .dash-value{font-family:'Playfair Display',serif;font-size:40px;font-weight:700;color:var(--primary);margin-top:8px;}
        .dash-grid{display:grid;grid-template-columns:1fr 1fr;gap:24px;}
        .dash-panel{background:var(--surface-container-lowest);border:1px solid var(--outline-variant);border-radius:24px;padding:22px;}
        .dash-panel h3{font-family:'Playfair Display',serif;font-size:22px;margin-bottom:14px;}
        @media(max-width:900px){.dash-grid{grid-template-columns:1fr;}}
    </style>

    <div class="dash-wrap">
        <h1 class="dash-title">Dashboard Admin</h1>
        <p class="dash-sub">Resumen general de pedidos y catálogo.</p>

        <div class="dash-cards">
            <div class="dash-card">
                <div class="dash-label">Pedidos totales</div>
                <div class="dash-value">{{ $totalPedidos }}</div>
            </div>

            <div class="dash-card">
                <div class="dash-label">Productos</div>
                <div class="dash-value">{{ $totalProductos }}</div>
            </div>

            <div class="dash-card">
                <div class="dash-label">Stock bajo</div>
                <div class="dash-value">{{ $stockBajo }}</div>
            </div>

            <div class="dash-card">
                <div class="dash-label">Sin stock</div>
                <div class="dash-value">{{ $sinStock }}</div>
            </div>
        </div>

        <div class="dash-grid">
            <div class="dash-panel">
                <h3>Pedidos por estado</h3>
                <canvas id="chartPedidos"></canvas>
            </div>

            <div class="dash-panel">
                <h3>Pasteles por categoría</h3>
                <canvas id="chartProductos" style="max-height:300px;"></canvas>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const pedidosCtx = document.getElementById('chartPedidos');
        new Chart(pedidosCtx, {
            type: 'bar',
            data: {
                labels: @json($pedidosLabels),
                datasets: [{
                    label: 'Pedidos',
                    data: @json($pedidosData),
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: { beginAtZero: true, precision: 0 }
                }
            }
        });

        const productosCtx = document.getElementById('chartProductos');
        new Chart(productosCtx, {
            type: 'doughnut',
            data: {
                labels: @json($productosCategoriasLabels),
                datasets: [{
                    data: @json($productosCategoriasData),
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    </script>
</x-app-layout>