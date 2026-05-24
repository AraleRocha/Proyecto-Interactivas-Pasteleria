<x-app-layout title="Usuarios">
    <style>
        .adm-wrap{
            max-width: 1280px;
            margin: 0 auto;
            padding: 24px;
        }

        .adm-head{
            display:flex;
            justify-content:space-between;
            align-items:flex-start;
            gap:16px;
            flex-wrap:wrap;
            margin-bottom:24px;
        }

        .adm-title{
            font-family:'Playfair Display', serif;
            font-size:clamp(28px,4vw,42px);
            font-weight:700;
            margin:0;
        }

        .adm-sub{
            color:var(--on-surface-variant);
            margin-top:6px;
        }

        .adm-card{
            background:var(--surface-container-low);
            border:1px solid var(--outline-variant);
            border-radius:24px;
            overflow:hidden;
        }

        .adm-table-wrap{
            overflow-x:auto;
        }

        .adm-table{
            width:100%;
            border-collapse:collapse;
            min-width:1000px;
        }

        .adm-table th,
        .adm-table td{
            padding:14px 16px;
            border-bottom:1px solid var(--outline-variant);
            text-align:left;
            vertical-align:top;
            font-size:14px;
        }

        .adm-table th{
            font-size:12px;
            text-transform:uppercase;
            letter-spacing:.06em;
            color:var(--on-surface-variant);
            background:var(--surface-container-lowest);
        }

        .adm-id{
            font-weight:700;
            color:var(--primary);
        }

        .adm-badge{
            display:inline-flex;
            align-items:center;
            gap:6px;
            padding:8px 12px;
            border-radius:999px;
            font-size:12px;
            font-weight:700;
            white-space:nowrap;
        }

        .role-admin{
            background:#dbeafe;
            color:#1e40af;
        }

        .role-cliente{
            background:#dcfce7;
            color:#166534;
        }

        .btn-detail,
        .btn-edit,
        .btn-del,
        .btn-create{
            border:none;
            border-radius:12px;
            padding:10px 14px;
            font-weight:700;
            font-size:13px;
            cursor:pointer;
            text-decoration:none;
            display:inline-flex;
            align-items:center;
            gap:8px;
            transition:all .2s ease;
            box-shadow:0 2px 8px rgba(0,0,0,.06);
        }

        .btn-edit{
            background:var(--primary-fixed);
            color:var(--primary);
        }

        .btn-edit:hover{
            transform:translateY(-1px);
            background:var(--primary-fixed-dim);
        }

        .btn-del{
            background:#fef2f2;
            color:#991b1b;
            border:1px solid #fecdd3;
        }

        .btn-del:hover{
            background:#fee2e2;
            transform:translateY(-1px);
        }

        .btn-detail{
            background:var(--surface-container-high);
            color:var(--on-surface);
            border:1px solid var(--outline-variant);
        }

        .btn-detail:hover{
            background:var(--surface-container-highest);
            transform:translateY(-1px);
        }

        .btn-create{
            background:var(--primary);
            color:#fff;
            box-shadow:0 4px 14px rgba(151,49,0,0.18);
        }

        .btn-create:hover{
            opacity:.92;
            transform:translateY(-1px);
        }

        .btn-row{
            display:flex;
            gap:8px;
            flex-wrap:wrap;
        }

        .empty{
            padding:60px 20px;
            text-align:center;
            color:var(--on-surface-variant);
        }
    </style>

    <div class="adm-wrap">
        <div class="adm-head">
            <div>
                <h1 class="adm-title">Usuarios</h1>
                <p class="adm-sub">Listado general de cuentas registradas.</p>
            </div>

            <a href="{{ route('admin.usuarios.create') }}" class="btn-create">
                <span class="material-symbols-outlined" style="font-size:18px;">person_add</span>
                Nuevo usuario
            </a>
        </div>

        @if(session('success'))
            <div class="amo-flash-ok" style="margin-bottom:20px;">
                {{ session('success') }}
            </div>
        @endif

        @if($usuarios->count())
            <div class="adm-card">
                <div class="adm-table-wrap">
                    <table class="adm-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Correo</th>
                                <th>Rol</th>
                                <th>Fecha registro</th>
                                <th style="text-align:right;">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($usuarios as $usuario)
                                <tr>
                                    <td>
                                        <span class="adm-id">#{{ str_pad($usuario->id, 5, '0', STR_PAD_LEFT) }}</span>
                                    </td>

                                    <td>
                                        <strong>{{ $usuario->name }}</strong>
                                    </td>

                                    <td>
                                        {{ $usuario->email }}
                                    </td>

                                    <td>
                                        @if($usuario->role === 'admin')
                                            <span class="adm-badge role-admin">
                                                Administrador
                                            </span>
                                        @else
                                            <span class="adm-badge role-cliente">
                                                Cliente
                                            </span>
                                        @endif
                                    </td>

                                    <td>
                                        {{ $usuario->created_at?->format('d/m/Y H:i') }}
                                    </td>

                                    <td style="text-align:right;">
                                        <div style="display:flex;justify-content:flex-end;gap:8px;align-items:center;">
                                            <a href="{{ route('admin.usuarios.edit', $usuario) }}" class="amo-btn-edit">
                                                <span class="material-symbols-outlined" style="font-size:15px;margin-right:4px;">edit</span>
                                                Editar
                                            </a>

                                            <form method="POST" style="margin:0;">
                                                @csrf

                                                <button type="button"
                                                    class="amo-btn-del"
                                                    onclick="prepararEliminacion(
                                                        '{{ route('admin.usuarios.destroy', $usuario) }}',
                                                        '¿Eliminar al usuario {{ $usuario->name }}?',
                                                        'DELETE'
                                                    )">

                                                    <span class="material-symbols-outlined"
                                                        style="font-size:15px;margin-right:4px;">
                                                        delete
                                                    </span>

                                                    Eliminar
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div style="margin-top:24px;">
                {{ $usuarios->links() }}
            </div>
        @else
            <div class="adm-card empty">
                No hay usuarios registrados.
            </div>
        @endif
    </div>
</x-app-layout>

