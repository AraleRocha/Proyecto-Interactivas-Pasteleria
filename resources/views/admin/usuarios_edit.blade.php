<x-app-layout title="Editar usuario">
    <x-amo-styles />

    <style>
        .adm-wrap{max-width:900px;margin:0 auto;padding:24px;}
        .adm-title{font-family:'Playfair Display',serif;font-size:clamp(28px,4vw,42px);font-weight:700;margin:0 0 6px;}
        .adm-sub{color:var(--on-surface-variant);margin-bottom:24px;}
        .adm-card{background:var(--surface-container-low);border:1px solid var(--outline-variant);border-radius:24px;padding:24px;}
        .form-grid{display:grid;grid-template-columns:1fr 1fr;gap:16px;}
        .field-label{display:block;font-size:12px;font-weight:700;letter-spacing:.06em;text-transform:uppercase;color:var(--on-surface-variant);margin-bottom:6px;}
        .field-input,.field-select{
            width:100%;padding:12px 14px;border-radius:12px;border:1px solid var(--outline-variant);
            background:var(--surface);font-family:inherit;font-size:14px;outline:none;
        }
        .field-input:focus,.field-select:focus{border-color:var(--primary);}
        .field-error{font-size:12px;color:var(--error);margin-top:6px;}
        .actions{display:flex;gap:12px;flex-wrap:wrap;margin-top:20px;}
        .btn-primary,.btn-ghost{
            border:none;border-radius:14px;padding:12px 16px;font-weight:700;text-decoration:none;cursor:pointer;
            display:inline-flex;align-items:center;gap:8px;
        }
        .btn-primary{background:var(--primary);color:#fff;}
        .btn-ghost{background:var(--surface-container-high);color:var(--on-surface);}
        @media (max-width:700px){.form-grid{grid-template-columns:1fr;}}
    </style>

    <div class="adm-wrap">
        <h1 class="adm-title">Editar usuario</h1>
        <p class="adm-sub">Actualiza datos, rol o contraseña.</p>

        <div class="adm-card">
            <form action="{{ route('usuarios.update', $usuario) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-grid">
                    <div>
                        <label class="field-label">Nombre</label>
                        <input type="text" name="name" class="field-input" value="{{ old('name', $usuario->name) }}" required>
                        @error('name') <div class="field-error">{{ $message }}</div> @enderror
                    </div>

                    <div>
                        <label class="field-label">Correo</label>
                        <input type="email" name="email" class="field-input" value="{{ old('email', $usuario->email) }}" required>
                        @error('email') <div class="field-error">{{ $message }}</div> @enderror
                    </div>

                    <div>
                        <label class="field-label">Rol</label>
                        <select name="role" class="field-select" required>
                            <option value="cliente" @selected(old('role', $usuario->role) === 'cliente')>Cliente</option>
                            <option value="admin" @selected(old('role', $usuario->role) === 'admin')>Administrador</option>
                        </select>
                        @error('role') <div class="field-error">{{ $message }}</div> @enderror
                    </div>

                    <div>
                        <label class="field-label">Nueva contraseña</label>
                        <input type="password" name="password" class="field-input">
                        @error('password') <div class="field-error">{{ $message }}</div> @enderror
                    </div>

                    <div>
                        <label class="field-label">Confirmar nueva contraseña</label>
                        <input type="password" name="password_confirmation" class="field-input">
                    </div>
                </div>

                <div class="actions">
                    <button type="submit" class="btn-primary">Guardar cambios</button>
                    <a href="{{ route('usuarios.index', $usuario) }}" class="btn-ghost">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>