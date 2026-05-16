<x-app-layout :title="__('Nuevo Pastel')">
    <x-amo-styles />

    {{-- ══════ MAIN ══════ --}}
    <main class="amo-main">

        {{-- Breadcrumb + Title --}}
        <div style="margin-bottom:28px;">
            <nav class="amo-breadcrumb">
                <a href="{{ route('productos.index') }}">Inventario</a>
                <span class="material-symbols-outlined" style="font-size:15px;">chevron_right</span>
                <span class="current">Nuevo Pastel</span>
            </nav>
            <h1 style="font-family:'Playfair Display',serif;font-size:36px;font-weight:700;color:var(--on-surface);line-height:1.1;margin-bottom:6px;">
                Crear Nuevo Pastel
            </h1>
            <p style="font-size:15px;color:var(--on-surface-variant);max-width:560px;">
                Registre una nueva creación artesanal. Complete los detalles del sabor, tamaño y disponibilidad para los clientes.
            </p>
        </div>

        {{-- Error banner --}}
        @if($errors->any())
            <div class="amo-error-banner">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- BENTO GRID --}}
        <form action="{{ route('productos.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div style="display:grid;grid-template-columns:1fr 340px;gap:24px;align-items:start;">

                {{-- ── LEFT COLUMN ── --}}
                <div>
                    {{-- Información General --}}
                    <div class="amo-card">
                        <div class="amo-card-header">
                            <span class="material-symbols-outlined" style="color:var(--secondary);">edit_note</span>
                            <h3>Información General</h3>
                        </div>
                        <div class="amo-card-body">
                            <div class="amo-grid-2" style="margin-bottom:20px;">
                                {{-- Nombre --}}
                                <div class="amo-col-span-2">
                                    <label for="nombre" class="amo-label">
                                        Nombre del Pastel <span style="color:var(--error);">*</span>
                                    </label>
                                    <input type="text" id="nombre" name="nombre"
                                           value="{{ old('nombre') }}"
                                           placeholder="Ej. Terciopelo Rojo Clásico"
                                           class="amo-input @error('nombre') error @enderror">
                                    @error('nombre')
                                        <p class="amo-error-msg">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- Sabor --}}
                                <div>
                                    <label for="sabor" class="amo-label">
                                        Sabor <span style="color:var(--error);">*</span>
                                    </label>
                                    <input type="text" id="sabor" name="sabor"
                                           value="{{ old('sabor') }}"
                                           placeholder="Ej. Vainilla de Papantla"
                                           class="amo-input @error('sabor') error @enderror">
                                    @error('sabor')
                                        <p class="amo-error-msg">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- Categoría --}}
                                <div>
                                    <label for="categoria" class="amo-label">
                                        Categoría <span style="color:var(--error);">*</span>
                                    </label>
                                    <select id="categoria" name="categoria" class="amo-select @error('categoria') error @enderror">
                                        <option value="">Seleccionar</option>
                                        @foreach(['Boda','Cumpleaños','Bautizo','XV Años','Aniversarios','Baby Showers','Graduaciones'] as $cat)
                                            <option value="{{ $cat }}" {{ old('categoria') === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                                        @endforeach
                                    </select>
                                    @error('categoria')
                                        <p class="amo-error-msg">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            {{-- Tips --}}
                            <div style="margin-top:20px;display:flex;flex-direction:column;gap:12px;">
                                <div class="amo-tip">
                                    <div class="amo-tip-icon primary-fixed">
                                        <span class="material-symbols-outlined" style="color:var(--primary);font-size:20px;">palette</span>
                                    </div>
                                    <div>
                                        <p style="font-size:13px;font-weight:600;color:var(--on-surface);">Nombre memorable</p>
                                        <p style="font-size:12px;color:var(--on-surface-variant);margin-top:2px;">Un nombre evocador ayuda a que los clientes recuerden y compartan tu creación.</p>
                                    </div>
                                </div>
                                <div class="amo-tip">
                                    <div class="amo-tip-icon secondary-container">
                                        <span class="material-symbols-outlined" style="color:var(--secondary);font-size:20px;">description</span>
                                    </div>
                                    <div>
                                        <p style="font-size:13px;font-weight:600;color:var(--on-surface);">Descripción completa</p>
                                        <p style="font-size:12px;color:var(--on-surface-variant);margin-top:2px;">Incluye la ocasión ideal, ingredientes especiales y personalización disponible.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Precio e Inventario --}}
                    <div class="amo-card">
                        <div class="amo-card-header">
                            <span class="material-symbols-outlined" style="color:var(--secondary);">payments</span>
                            <h3>Precio e Inventario</h3>
                        </div>
                        <div class="amo-card-body">
                            <div class="amo-grid-3">
                                {{-- Precio --}}
                                <div>
                                    <label for="precio" class="amo-label">
                                        Precio (MXN) <span style="color:var(--error);">*</span>
                                    </label>
                                    <div class="amo-input-prefix">
                                        <span class="prefix">$</span>
                                        <input type="number" id="precio" name="precio"
                                               value="{{ old('precio') }}"
                                               min="0" step="0.01" placeholder="0.00"
                                               class="amo-input @error('precio') error @enderror">
                                    </div>
                                    @error('precio')
                                        <p class="amo-error-msg">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- Stock --}}
                                <div>
                                    <label for="stock" class="amo-label">Stock Inicial</label>
                                    <input type="number" id="stock" name="stock"
                                           value="{{ old('stock', 0) }}"
                                           min="0"
                                           class="amo-input @error('stock') error @enderror">
                                    @error('stock')
                                        <p class="amo-error-msg">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- Tamaño --}}
                                <div>
                                    <label for="tamano" class="amo-label">
                                        Tamaño <span style="color:var(--error);">*</span>
                                    </label>
                                    <select id="tamano" name="tamano" class="amo-select @error('tamano') error @enderror">
                                        <option value="">Seleccionar</option>
                                        @foreach(['Pequeño - 5 personas','Mediano - 10 personas','Grande - 20 personas'] as $tam)
                                            <option value="{{ $tam }}" {{ old('tamano') === $tam ? 'selected' : '' }}>{{ $tam }}</option>
                                        @endforeach
                                    </select>
                                    @error('tamano')
                                        <p class="amo-error-msg">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ── RIGHT COLUMN ── --}}
                <div style="display:flex;flex-direction:column;gap:20px;">

                    {{-- Imagen --}}
                    <div class="amo-card">
                        <div class="amo-card-header">
                            <span class="material-symbols-outlined" style="color:var(--secondary);">image</span>
                            <h3>Imagen</h3>
                        </div>
                        <div class="amo-card-body">
                            <div class="amo-drop-zone" id="drop-zone">
                                <img id="preview-img" src="" alt="Preview" style="display:none;max-height:160px;border-radius:8px;object-fit:contain;">
                                <div id="placeholder-content">
                                    <span class="material-symbols-outlined drop-icon">cloud_upload</span>
                                    <div>
                                        <p style="font-size:14px;font-weight:600;color:var(--on-surface);">Subir Fotografía</p>
                                        <p style="font-size:12px;color:var(--on-surface-variant);margin-top:4px;">Arrastra o haz clic para buscar</p>
                                    </div>
                                </div>
                                <input type="file" id="imagen" name="imagen" accept="image/*"
                                       onchange="previewImagen(this)">
                            </div>
                            <p style="font-size:12px;color:var(--on-surface-variant);margin-top:10px;text-align:center;font-style:italic;">
                                PNG, JPG, WEBP · Máx. 2 MB
                            </p>
                            @error('imagen')
                                <p class="amo-error-msg" style="text-align:center;">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- Visibilidad --}}
                    <div class="amo-card">
                        <div class="amo-card-header">
                            <span class="material-symbols-outlined" style="color:var(--secondary);">visibility</span>
                            <h3>Visibilidad</h3>
                        </div>
                        <div class="amo-card-body">
                            <div class="amo-toggle-wrap">
                                <div>
                                    <p class="amo-toggle-label">Disponible</p>
                                    <p class="amo-toggle-sub">Mostrar en tienda online</p>
                                </div>
                                <label class="amo-switch">
                                    <input type="hidden" name="disponible" value="0">
                                    <input type="checkbox" name="disponible" value="1"
                                           {{ old('disponible', true) ? 'checked' : '' }}>
                                    <div class="amo-switch-track"></div>
                                </label>
                            </div>
                        </div>
                    </div>

                    {{-- Actions --}}
                    <div style="display:flex;flex-direction:column;gap:10px;">
                        <button type="submit" class="amo-btn-primary full-width">
                            <span class="material-symbols-outlined" style="font-size:20px;">save</span>
                            Guardar Pastel
                        </button>
                        <a href="{{ route('productos.index') }}" class="amo-btn-ghost">
                            Cancelar
                        </a>
                    </div>
                </div>{{-- /right column --}}
            </div>{{-- /bento grid --}}
        </form>
    </main>

    <script>
        function previewImagen(input) {
            const preview     = document.getElementById('preview-img');
            const placeholder = document.getElementById('placeholder-content');
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = e => {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                    placeholder.style.display = 'none';
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        // Drag-and-drop visual feedback
        const zone = document.getElementById('drop-zone');
        zone.addEventListener('dragover',  e => { e.preventDefault(); zone.style.borderColor = 'var(--primary)'; zone.style.background = 'rgba(151,49,0,0.04)'; });
        zone.addEventListener('dragleave', () => { zone.style.borderColor = ''; zone.style.background = ''; });
        zone.addEventListener('drop',      e => { zone.style.borderColor = ''; zone.style.background = ''; });
    </script>
</x-app-layout>