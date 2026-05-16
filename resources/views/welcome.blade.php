<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Amoretti - Welcome</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Serif:wght@400;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        .hero-overlay {
            background: linear-gradient(to bottom, rgba(52, 23, 18, 0.2), rgba(52, 23, 18, 0.6));
        }
        :root {
            --color-primary: #341712;
            --color-primary-container: #4d2c26;
            --color-surface: #fff8f6;
        }
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        .font-display {
            font-family: 'Noto Serif', serif;
        }
    </style>
</head>
<body class="bg-background text-on-background font-body-md selection:bg-primary-container selection:text-white">
    <main class="relative min-h-screen w-full flex items-center justify-center overflow-hidden">
        <!-- Background Hero Image -->
        <div class="absolute inset-0 z-0">
            <img alt="Artisan Pastries Background" class="w-full h-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCEhBfBRl6knO_S_oXIlJ_JS1EQ0XQa3UA6ikMvg9k0b0cP0T1qDOttO9064pW_LfG5b2HA50ti32MeX02d9BlXd0mgnTNILrSSV2Toixz5NYaKgsN8qpIe2Y8OjY--EydfpocTWOLax0VjCpHS8jRkoq3Lp96XUHIVdalSr1hHiK9HBbCGqBJdxPoRBI26JJFvXqHxQQvReYWtrmq29h1y7hPEujQERAUktCKB-8TXExJsyvq_erVpixRtZXh1agjfDkfZyHj1xuo"/>
            <div class="absolute inset-0 hero-overlay backdrop-blur-[2px]"></div>
        </div>

        <!-- Content Canvas -->
        <div class="relative z-10 w-full max-w-md px-4">
            <div class="bg-white/95 backdrop-blur-md p-8 rounded-xl shadow-2xl border border-[#d5c2bf] flex flex-col items-center text-center space-y-6 transition-all duration-300">
                <!-- Logo & Brand Section -->
                <div class="space-y-2 mb-4">
                    <span class="material-symbols-outlined text-[#4d2c26] text-5xl mb-2" style="font-variation-settings: 'FILL' 0;">bakery_dining</span>
                    <h1 class="font-display text-5xl font-bold text-[#341712]">Amoretti</h1>
                    <p class="text-[#514442] max-w-xs mx-auto italic">
                        Momentos de dulzura elaborados artesanalmente, con la tradición francesa y el cariño local.
                    </p>
                </div>

                <div class="w-full flex flex-col space-y-3 pt-2">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="w-full py-4 bg-[#4d2c26] text-white font-semibold rounded-lg shadow-sm hover:opacity-90 active:scale-[0.98] transition-all duration-200 uppercase tracking-widest text-center">
                                Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="w-full py-4 bg-[#4d2c26] text-white font-semibold rounded-lg shadow-sm hover:opacity-90 active:scale-[0.98] transition-all duration-200 uppercase tracking-widest text-center">
                                Iniciar Sesión
                            </a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="w-full py-4 bg-[#fecbcb] text-[#7b5455] font-semibold rounded-lg border border-[#d5c2bf] hover:bg-[#ecbaba] active:scale-[0.98] transition-all duration-200 uppercase tracking-widest text-center">
                                    Crear Cuenta
                                </a>
                            @endif
                        @endauth
                    @endif
                </div>
            </div>

            <!-- Social/Trust Indicators -->
            <div class="mt-8 flex justify-center gap-6">
                <div class="flex flex-col items-center text-white">
                    <span class="font-semibold text-lg">4.9/5</span>
                    <span class="text-xs opacity-80">Calificación</span>
                </div>
                <div class="w-px h-8 bg-white/30"></div>
                <div class="flex flex-col items-center text-white">
                    <span class="font-semibold text-lg">15+</span>
                    <span class="text-xs opacity-80">Años de Tradición</span>
                </div>
                <div class="w-px h-8 bg-white/30"></div>
                <div class="flex flex-col items-center text-white">
                    <span class="font-semibold text-lg">24h</span>
                    <span class="text-xs opacity-80">Repostería Fresca</span>
                </div>
            </div>
        </div>
    </main>
</body>
</html>