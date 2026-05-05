<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('productos.index') }}"
               class="inline-flex items-center rounded-lg p-1.5 text-gray-500 transition hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                Nuevo producto
            </h2>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">

            <form action="{{ route('productos.store') }}" method="POST" enctype="multipart/form-data"
                  class="space-y-6">
                @csrf

                {{-- Errores globales --}}
                @if($errors->any())
                    <div class="rounded-lg bg-red-50 px-4 py-3 dark:bg-red-900/30">
                        <ul class="list-inside list-disc space-y-1 text-sm text-red-700 dark:text-red-400">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- Card principal --}}
                <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm dark:border-gray-700 dark:bg-gray-800">

                    {{-- Sección: Información básica --}}
                    <div class="border-b border-gray-100 px-6 py-4 dark:border-gray-700">
                        <h3 class="text-sm font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">
                            Información básica
                        </h3>
                    </div>

                    <div class="grid gap-5 px-6 py-5 sm:grid-cols-2">

                        {{-- Nombre --}}
                        <div class="sm:col-span-2">
                            <label for="nombre" class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Nombre <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="nombre" name="nombre"
                                   value="{{ old('nombre') }}"
                                   placeholder="Ej. Agua mineral premium"
                                   class="w-full rounded-lg border @error('nombre') border-red-400 @else border-gray-300 @enderror bg-white px-3 py-2 text-sm shadow-sm transition focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 dark:placeholder-gray-500">
                            @error('nombre')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Sabor --}}
                        <div>
                            <label for="sabor" class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Sabor <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="sabor" name="sabor"
                                   value="{{ old('sabor') }}"
                                   placeholder="Ej. Natural, Lima, Fresa..."
                                   class="w-full rounded-lg border @error('sabor') border-red-400 @else border-gray-300 @enderror bg-white px-3 py-2 text-sm shadow-sm transition focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 dark:placeholder-gray-500">
                            @error('sabor')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Tamaño --}}
                        <div>
                            <label for="tamaño" class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Tamaño <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="tamaño" name="tamaño"
                                   value="{{ old('tamaño') }}"
                                   placeholder="Ej. 500ml, 1L, Grande..."
                                   class="w-full rounded-lg border @error('tamaño') border-red-400 @else border-gray-300 @enderror bg-white px-3 py-2 text-sm shadow-sm transition focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 dark:placeholder-gray-500">
                            @error('tamaño')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Categoría --}}
                        <div>
                            <label for="categoria" class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Categoría <span class="text-red-500">*</span>
                            </label>
                            <select id="categoria" name="categoria"
                                    class="w-full rounded-lg border @error('categoria') border-red-400 @else border-gray-300 @enderror bg-white px-3 py-2 text-sm shadow-sm transition focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100">
                                <option value="">— Seleccionar —</option>
                                @foreach(['Agua', 'Refresco', 'Jugo', 'Energizante', 'Té', 'Café', 'Lácteo', 'Otro'] as $cat)
                                    <option value="{{ $cat }}" {{ old('categoria') === $cat ? 'selected' : '' }}>
                                        {{ $cat }}
                                    </option>
                                @endforeach
                            </select>
                            @error('categoria')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Precio --}}
                        <div>
                            <label for="precio" class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Precio <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-sm text-gray-400">$</span>
                                <input type="number" id="precio" name="precio"
                                       value="{{ old('precio') }}"
                                       min="0" step="0.01" placeholder="0.00"
                                       class="w-full rounded-lg border @error('precio') border-red-400 @else border-gray-300 @enderror bg-white py-2 pl-7 pr-3 text-sm shadow-sm transition focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100">
                            </div>
                            @error('precio')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                    </div>

                    {{-- Sección: Inventario y estado --}}
                    <div class="border-b border-t border-gray-100 px-6 py-4 dark:border-gray-700">
                        <h3 class="text-sm font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">
                            Inventario y estado
                        </h3>
                    </div>

                    <div class="grid gap-5 px-6 py-5 sm:grid-cols-2">

                        {{-- Stock --}}
                        <div>
                            <label for="stock" class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Stock
                            </label>
                            <input type="number" id="stock" name="stock"
                                   value="{{ old('stock', 0) }}"
                                   min="0"
                                   class="w-full rounded-lg border @error('stock') border-red-400 @else border-gray-300 @enderror bg-white px-3 py-2 text-sm shadow-sm transition focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100">
                            @error('stock')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Disponible --}}
                        <div class="flex items-end pb-1">
                            <label class="relative inline-flex cursor-pointer items-center gap-3">
                                <input type="hidden" name="disponible" value="0">
                                <input type="checkbox" id="disponible" name="disponible" value="1"
                                       {{ old('disponible', true) ? 'checked' : '' }}
                                       class="peer sr-only">
                                <div class="peer h-6 w-11 rounded-full bg-gray-200 after:absolute after:left-[2px] after:top-[2px] after:h-5 after:w-5 after:rounded-full after:bg-white after:shadow after:transition-all peer-checked:bg-indigo-600 peer-checked:after:translate-x-full dark:bg-gray-700"></div>
                                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Disponible para venta</span>
                            </label>
                        </div>

                    </div>

                    {{-- Sección: Imagen --}}
                    <div class="border-b border-t border-gray-100 px-6 py-4 dark:border-gray-700">
                        <h3 class="text-sm font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">
                            Imagen del producto
                        </h3>
                    </div>

                    <div class="px-6 py-5">
                        <label for="imagen" class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Imagen <span class="text-red-500">*</span>
                        </label>

                        {{-- Zona de drop --}}
                        <div id="drop-zone"
                             class="relative flex min-h-[160px] cursor-pointer flex-col items-center justify-center rounded-xl border-2 border-dashed border-gray-300 bg-gray-50 transition hover:border-indigo-400 hover:bg-indigo-50/30 dark:border-gray-600 dark:bg-gray-700/40 dark:hover:border-indigo-500">

                            <img id="preview-img" src="" alt="Preview" class="hidden h-36 w-auto rounded-lg object-contain p-2" />

                            <div id="placeholder-content" class="flex flex-col items-center gap-2 text-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                    Arrastra una imagen o
                                    <span class="font-medium text-indigo-600 dark:text-indigo-400">haz clic para seleccionar</span>
                                </p>
                                <p class="text-xs text-gray-400">PNG, JPG, WEBP hasta 2MB</p>
                            </div>

                            <input type="file" id="imagen" name="imagen" accept="image/*"
                                   class="absolute inset-0 h-full w-full cursor-pointer opacity-0"
                                   onchange="previewImagen(this)">
                        </div>

                        @error('imagen')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                </div>

                {{-- Botones --}}
                <div class="flex items-center justify-end gap-3">
                    <a href="{{ route('productos.index') }}"
                       class="rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm transition hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-200 dark:hover:bg-gray-700">
                        Cancelar
                    </a>
                    <button type="submit"
                            class="inline-flex items-center gap-2 rounded-lg bg-indigo-600 px-5 py-2 text-sm font-medium text-white shadow-sm transition hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Guardar producto
                    </button>
                </div>

            </form>
        </div>
    </div>

    <script>
        function previewImagen(input) {
            const preview = document.getElementById('preview-img');
            const placeholder = document.getElementById('placeholder-content');
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = e => {
                    preview.src = e.target.result;
                    preview.classList.remove('hidden');
                    placeholder.classList.add('hidden');
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</x-app-layout>