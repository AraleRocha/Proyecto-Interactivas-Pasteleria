<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Amoretti') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
{{--Estilos globales--}}
<x-amo-styles />
<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        <livewire:layout.navigation />
        @if (isset($header))
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endif

        <main>
            {{ $slot }}
        </main>

        <x-footer />
    </div>

    {{-- Modal global --}}
    <x-delete-modal
        modalId="global-delete-modal"
        formId="global-delete-form"
        title="Confirmar acción"
        message="¿Seguro que deseas continuar?"
        buttonText="Confirmar"
    />

    <script>
        function prepararEliminacion(actionUrl, mensaje, method = 'DELETE', modalId = 'global-delete-modal') {
            const modal = document.getElementById(modalId);
            if (!modal) return;

            const form = modal.querySelector('form');
            const text = document.getElementById(`${modalId}-message`);
            const methodContainer = document.getElementById(`${modalId}-method`);

            form.action = actionUrl;
            text.textContent = mensaje;

            methodContainer.innerHTML = '';
            if (method && method !== 'POST') {
                methodContainer.innerHTML = `<input type="hidden" name="_method" value="${method}">`;
            }

            modal.classList.add('open');
            document.body.style.overflow = 'hidden';
        }

        function cerrarModal(modalId = 'global-delete-modal') {
            document.getElementById(modalId)?.classList.remove('open');
            document.body.style.overflow = '';
        }

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') cerrarModal();
        });
    </script>

</body>
</html>