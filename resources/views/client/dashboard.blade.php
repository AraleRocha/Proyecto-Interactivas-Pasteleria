<x-app-layout title="Mi Dashboard">
    <div style="max-width:1200px;margin:0 auto;padding:24px;">
        <h1 style="font-family:'Playfair Display',serif;font-size:clamp(30px,4vw,46px);font-weight:700;margin:0;">
            Mi dashboard
        </h1>
        <p style="color:var(--on-surface-variant);margin-top:6px;">Resumen de tus pedidos.</p>

        <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:20px;margin:28px 0;">
            <div class="amo-card" style="padding:22px;">
                <div class="amo-label">Mis pedidos</div>
                <div style="font-family:'Playfair Display',serif;font-size:40px;font-weight:700;color:var(--primary);">{{ $misPedidos }}</div>
            </div>
            <div class="amo-card" style="padding:22px;">
                <div class="amo-label">Pendientes</div>
                <div style="font-family:'Playfair Display',serif;font-size:40px;font-weight:700;color:var(--primary);">{{ $pendientes }}</div>
            </div>
            <div class="amo-card" style="padding:22px;">
                <div class="amo-label">Horneando</div>
                <div style="font-family:'Playfair Display',serif;font-size:40px;font-weight:700;color:var(--primary);">{{ $horneando }}</div>
            </div>
            <div class="amo-card" style="padding:22px;">
                <div class="amo-label">Listos</div>
                <div style="font-family:'Playfair Display',serif;font-size:40px;font-weight:700;color:var(--primary);">{{ $listos }}</div>
            </div>
        </div>

        <div class="amo-card" style="padding:22px;">
            <h3 style="font-family:'Playfair Display',serif;font-size:22px;margin-bottom:14px;">Estado de mis pedidos</h3>
            <canvas id="chartCliente" style="max-height:320px;"></canvas>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const canvas = document.getElementById('chartCliente');
            if (!canvas) return;
            new Chart(canvas, {
                type: 'doughnut',
                data: {
                    labels: @json($labels),
                    datasets: [{
                        data: @json($data)
                    }]
                },
                options: {
                    responsive: true,
                    animation: {
                        duration: 800
                    },
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    }
                }
            });
        });
    </script>
    {{-- Chatbot --}}
    @include('components.chatbot')
</x-app-layout>