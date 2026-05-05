<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                Productos
            </h2>
            <a href="{{ route('productos.create') }}"
               class="inline-flex items-center gap-2 rounded-lg bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm transition hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Nuevo producto
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            {{-- Flash messages --}}
            @if(session('success'))
                <div class="mb-4 rounded-lg bg-green-50 px-4 py-3 text-sm text-green-700 dark:bg-green-900/30 dark:text-green-400">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Filtros --}}
            <div class="mb-6 flex flex-wrap items-center gap-3">
                <input
                    type="text"
                    placeholder="Buscar por nombre..."
                    class="rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-200"
                    id="search-input"
                    onkeyup="filtrarTabla()"
                />
                <select
                    class="rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm shadow-sm focus:border-indigo-500 focus:outline-none dark:border-gray-600 dark:bg-gray-800 dark:text-gray-200"
                    id="filter-disponible"
                    onchange="filtrarTabla()"
                >
                    <option value="">Todos</option>
                    <option value="1">Disponible</option>
                    <option value="0">No disponible</option>
                </select>
            </div>

            {{-- Tabla --}}
            <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm dark:border-gray-700 dark:bg-gray-800">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700" id="tabla-productos">
                    <thead class="bg-gray-50 dark:bg-gray-900/50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">Imagen</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">Nombre</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">Sabor</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">Tamaño</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">Categoría</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">Precio</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">Stock</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">Estado</th>
                            <th class="px-4 py-3 text-right text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                        @forelse($productos as $producto)
                            <tr class="transition hover:bg-gray-50 dark:hover:bg-gray-700/40"
                                data-nombre="{{ strtolower($producto->nombre) }}"
                                data-disponible="{{ $producto->disponible ? '1' : '0' }}">

                                <td class="px-4 py-3">
                                    @if($producto->imagen)
                                        <img src="{{ asset('storage/' . $producto->imagen) }}"
                                             alt="{{ $producto->nombre }}"
                                             class="h-12 w-12 rounded-lg object-cover shadow-sm" />
                                    @else
                                        <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-gray-100 dark:bg-gray-700">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                    @endif
                                </td>

                                <td class="px-4 py-3">
                                    <span class="font-medium text-gray-900 dark:text-gray-100">{{ $producto->nombre }}</span>
                                </td>

                                <td class="px-4 py-3 text-sm text-gray-600 dark:text-gray-300">
                                    {{ $producto->sabor }}
                                </td>

                                <td class="px-4 py-3 text-sm text-gray-600 dark:text-gray-300">
                                    {{ $producto->tamaño }}
                                </td>

                                <td class="px-4 py-3">
                                    <span class="inline-flex items-center rounded-full bg-indigo-50 px-2.5 py-0.5 text-xs font-medium text-indigo-700 dark:bg-indigo-900/40 dark:text-indigo-300">
                                        {{ $producto->categoria }}
                                    </span>
                                </td>

                                <td class="px-4 py-3 text-sm font-semibold text-gray-900 dark:text-gray-100">
                                    ${{ number_format($producto->precio, 2) }}
                                </td>

                                <td class="px-4 py-3">
                                    <span class="text-sm font-medium {{ $producto->stock > 10 ? 'text-green-600 dark:text-green-400' : ($producto->stock > 0 ? 'text-amber-600 dark:text-amber-400' : 'text-red-600 dark:text-red-400') }}">
                                        {{ $producto->stock }}
                                    </span>
                                </td>

                                <td class="px-4 py-3">
                                    @if($producto->disponible)
                                        <span class="inline-flex items-center gap-1 rounded-full bg-green-50 px-2.5 py-0.5 text-xs font-medium text-green-700 dark:bg-green-900/30 dark:text-green-400">
                                            <span class="h-1.5 w-1.5 rounded-full bg-green-500"></span>
                                            Disponible
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 rounded-full bg-red-50 px-2.5 py-0.5 text-xs font-medium text-red-700 dark:bg-red-900/30 dark:text-red-400">
                                            <span class="h-1.5 w-1.5 rounded-full bg-red-500"></span>
                                            No disponible
                                        </span>
                                    @endif
                                </td>

                                <td class="px-4 py-3 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('productos.edit', $producto->id) }}"
                                           class="inline-flex items-center rounded-lg border border-gray-200 bg-white px-3 py-1.5 text-xs font-medium text-gray-700 shadow-sm transition hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 dark:hover:bg-gray-600">
                                            Editar
                                        </a>

                                        <form action="{{ route('productos.destroy', $producto->id) }}" method="POST"
                                              onsubmit="return confirm('¿Eliminar este producto?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="inline-flex items-center rounded-lg border border-red-200 bg-white px-3 py-1.5 text-xs font-medium text-red-600 shadow-sm transition hover:bg-red-50 dark:border-red-800 dark:bg-gray-700 dark:text-red-400 dark:hover:bg-red-900/20">
                                                Eliminar
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="px-4 py-12 text-center text-sm text-gray-500 dark:text-gray-400">
                                    No hay productos registrados.
                                    <a href="{{ route('productos.create') }}" class="ml-1 font-medium text-indigo-600 hover:underline dark:text-indigo-400">Crear el primero</a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Paginación --}}
            @if($productos->hasPages())
                <div class="mt-4">
                    {{ $productos->links() }}
                </div>
            @endif

        </div>
    </div>

    <script>
        function filtrarTabla() {
            const search = document.getElementById('search-input').value.toLowerCase();
            const disponible = document.getElementById('filter-disponible').value;
            const rows = document.querySelectorAll('#tabla-productos tbody tr[data-nombre]');

            rows.forEach(row => {
                const nombre = row.dataset.nombre || '';
                const rowDisponible = row.dataset.disponible || '';

                const matchSearch = nombre.includes(search);
                const matchDisponible = disponible === '' || rowDisponible === disponible;

                row.style.display = matchSearch && matchDisponible ? '' : 'none';
            });
        }
    </script>
</x-app-layout>