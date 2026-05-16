<x-app-layout :title="__('Editar Pastel')">
    <x-amo-styles />

    {{-- ══════ MAIN ══════ --}}
    <main class="amo-main">

        {{-- Breadcrumb + Title --}}
        <div style="margin-bottom:28px;">
            <nav class="amo-breadcrumb">
                <a href="{{ route('productos.index') }}">Inventario</a>
                <span class="material-symbols-outlined" style="font-size:15px;">chevron_right</span>
                <span class="current">Editar Pastel</span>
            </nav>
            <div style="display:flex;align-items:center;gap:16px;flex-wrap:wrap;">
                <div>
                    <h1 style="font-family:'Playfair Display',serif;font-size:36px;font-weight:700;color:var(--on-surface);line-height:1.1;margin-bottom:6px;">
                        Editar Pastel
                    </h1>
                    <p style="font-size:15px;color:var(--on-surface-variant);max-width:560px;">
                        Modifica los detalles de <strong>{{ $producto->nombre }}</strong>. Los cambios se reflejarán de inmediato en la tienda.
                    </p>
                </div>
                <div style="margin-left:auto;">
                    @if($producto->disponible)
                        <span class="amo-status-badge amo-status-on" style="font-size:13px;padding:6px 14px;">
                            <span class="amo-status-dot"></span> Publicado
                        </span>
                    @else
                        <span class="amo-status-badge amo-status-off" style="font-size:13px;padding:6px 14px;">
                            <span class="amo-status-dot"></span> No disponible
                        </span>
                    @endif
                </div>
            </div>
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

        {{-- Flash de éxito --}}
        @if(session('success'))
            <div class="amo-flash-ok">{{ session('success') }}</div>
        @endif

        {{-- BENTO GRID --}}
        <form action="{{ route('productos.update', $producto->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

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
                            <div class="amo-grid-2">
                                {{-- Nombre --}}
                                <div class="amo-col-span-2">
                                    <label for="nombre" class="amo-label">
                                        Nombre del Pastel <span style="color:var(--error);">*</span>
                                    </label>
                                    <input type="text" id="nombre" name="nombre"
                                           value="{{ old('nombre', $producto->nombre) }}"
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
                                           value="{{ old('sabor', $producto->sabor) }}"
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
                                    <select id="categoria" name="categoria"
                                            class="amo-select @error('categoria') error @enderror">
                                        <option value="">Seleccionar</option>
                                        @foreach(['Boda','Cumpleaños','Bautizo','XV Años','Aniversarios','Baby Showers','Graduaciones'] as $cat)
                                            <option value="{{ $cat }}"
                                                {{ old('categoria', $producto->categoria) === $cat ? 'selected' : '' }}>
                                                {{ $cat }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('categoria')
                                        <p class="amo-error-msg">{{ $message }}</p>
                                    @enderror
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
                                               value="{{ old('precio', $producto->precio) }}"
                                               min="0" step="0.01" placeholder="0.00"
                                               class="amo-input @error('precio') error @enderror">
                                    </div>
                                    @error('precio')
                                        <p class="amo-error-msg">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- Stock --}}
                                <div>
                                    <label for="stock" class="amo-label">Stock Actual</label>
                                    <input type="number" id="stock" name="stock"
                                           value="{{ old('stock', $producto->stock) }}"
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
                                    <select id="tamano" name="tamano"
                                            class="amo-select @error('tamano') error @enderror">
                                        <option value="">Seleccionar</option>
                                        @foreach(['Pequeño - 5 personas','Mediano - 10 personas','Grande - 20 personas'] as $tam)
                                            <option value="{{ $tam }}"
                                                {{ old('tamano', $producto->tamano) === $tam ? 'selected' : '' }}>
                                                {{ $tam }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('tamano')
                                        <p class="amo-error-msg">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            {{-- Alertas de stock --}}
                            @if($producto->stock <= 5 && $producto->stock > 0)
                                <div style="margin-top:16px;display:flex;align-items:center;gap:8px;padding:10px 14px;background:#fffbeb;border:1px solid #fcd34d;border-radius:8px;">
                                    <span class="material-symbols-outlined" style="color:#d97706;font-size:18px;">warning</span>
                                    <p style="font-size:13px;color:#92400e;">Stock bajo: solo quedan <strong>{{ $producto->stock }}</strong> unidades.</p>
                                </div>
                            @elseif($producto->stock == 0)
                                <div style="margin-top:16px;display:flex;align-items:center;gap:8px;padding:10px 14px;background:#fef2f2;border:1px solid #fecdd3;border-radius:8px;">
                                    <span class="material-symbols-outlined" style="color:var(--error);font-size:18px;">inventory_2</span>
                                    <p style="font-size:13px;color:var(--error);">Sin stock disponible. Actualiza el inventario.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>{{-- /left --}}

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
                                @if($producto->imagen)
                                    <img id="preview-img"
                                         src="{{ asset('storage/' . $producto->imagen) }}"
                                         alt="{{ $producto->nombre }}"
                                         style="max-height:160px;border-radius:8px;object-fit:contain;">
                                    <div id="placeholder-content" style="display:none;">
                                        <span class="material-symbols-outlined drop-icon">cloud_upload</span>
                                        <div>
                                            <p style="font-size:14px;font-weight:600;color:var(--on-surface);">Cambiar Fotografía</p>
                                            <p style="font-size:12px;color:var(--on-surface-variant);margin-top:4px;">Arrastra o haz clic para buscar</p>
                                        </div>
                                    </div>
                                @else
                                    <img id="preview-img" src="" alt="Preview"
                                         style="display:none;max-height:160px;border-radius:8px;object-fit:contain;">
                                    <div id="placeholder-content">
                                        <span class="material-symbols-outlined drop-icon">cloud_upload</span>
                                        <div>
                                            <p style="font-size:14px;font-weight:600;color:var(--on-surface);">Subir Fotografía</p>
                                            <p style="font-size:12px;color:var(--on-surface-variant);margin-top:4px;">Arrastra o haz clic para buscar</p>
                                        </div>
                                    </div>
                                @endif
                                <input type="file" id="imagen" name="imagen" accept="image/*"
                                       onchange="previewImagen(this)">
                            </div>

                            {{-- Opción eliminar imagen actual --}}
                            @if($producto->imagen)
                                <div style="margin-top:12px;display:flex;align-items:center;justify-content:space-between;">
                                    <span style="font-size:12px;color:var(--on-surface-variant);display:flex;align-items:center;gap:4px;">
                                        <span class="material-symbols-outlined" style="font-size:14px;">photo</span> Imagen guardada
                                    </span>
                                    <label style="display:flex;align-items:center;gap:6px;cursor:pointer;">
                                        <input type="checkbox" name="eliminar_imagen" value="1" id="eliminar_imagen"
                                               style="accent-color:var(--error);width:14px;height:14px;">
                                        <span style="font-size:12px;color:var(--error);font-weight:600;">Eliminar imagen</span>
                                    </label>
                                </div>
                            @endif

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
                                    {{-- hidden garantiza que siempre llegue el campo al controller --}}
                                    <input type="hidden" name="disponible" value="0">
                                    <input type="checkbox" name="disponible" value="1"
                                           {{ old('disponible', $producto->disponible) ? 'checked' : '' }}>
                                    <div class="amo-switch-track"></div>
                                </label>
                            </div>
                        </div>
                    </div>

                    {{-- Metadatos --}}
                    <div class="amo-card">
                        <div class="amo-card-header">
                            <span class="material-symbols-outlined" style="color:var(--secondary);">info</span>
                            <h3>Información</h3>
                        </div>
                        <div class="amo-card-body" style="display:flex;flex-direction:column;gap:10px;">
                            <div style="display:flex;justify-content:space-between;font-size:13px;">
                                <span style="color:var(--on-surface-variant);">ID del producto</span>
                                <span style="font-weight:600;color:var(--on-surface);">#{{ $producto->id }}</span>
                            </div>
                            <div style="display:flex;justify-content:space-between;font-size:13px;">
                                <span style="color:var(--on-surface-variant);">Creado</span>
                                <span style="font-weight:600;color:var(--on-surface);">{{ $producto->created_at->format('d M Y') }}</span>
                            </div>
                            <div style="display:flex;justify-content:space-between;font-size:13px;">
                                <span style="color:var(--on-surface-variant);">Última edición</span>
                                <span style="font-weight:600;color:var(--on-surface);">{{ $producto->updated_at->diffForHumans() }}</span>
                            </div>
                        </div>
                    </div>

                    {{-- Acciones --}}
                    <div style="display:flex;flex-direction:column;gap:10px;">
                        <button type="submit" class="amo-btn-primary full-width">
                            <span class="material-symbols-outlined" style="font-size:20px;">save</span>
                            Guardar Cambios
                        </button>
                        <a href="{{ route('productos.index') }}" class="amo-btn-ghost">
                            Cancelar
                        </a>
                    </div>
                </div>{{-- /right --}}
            </div>{{-- /grid --}}
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
                    if (placeholder) placeholder.style.display = 'none';
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        // Drag-and-drop
        const zone = document.getElementById('drop-zone');
        zone.addEventListener('dragover',  e => { e.preventDefault(); zone.style.borderColor = 'var(--primary)'; zone.style.background = 'rgba(151,49,0,0.04)'; });
        zone.addEventListener('dragleave', ()  => { zone.style.borderColor = ''; zone.style.background = ''; });
        zone.addEventListener('drop',      ()  => { zone.style.borderColor = ''; zone.style.background = ''; });

        // Si marcan eliminar → limpiar preview
        const chkEliminar = document.getElementById('eliminar_imagen');
        if (chkEliminar) {
            chkEliminar.addEventListener('change', () => {
                if (chkEliminar.checked) {
                    const preview = document.getElementById('preview-img');
                    const ph      = document.getElementById('placeholder-content');
                    preview.style.display = 'none';
                    if (ph) { ph.style.display = 'flex'; }
                    // limpiar el input de archivo por si acaso
                    document.getElementById('imagen').value = '';
                }
            });
        }
    </script>
</x-app-layout>