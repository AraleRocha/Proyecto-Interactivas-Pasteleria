<?php

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    public function register(): void
    {
        $validated = $this->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        event(new Registered($user = User::create($validated)));

        Auth::login($user);

        $this->redirect(route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Amoretti — Crear cuenta</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400;1,600&family=DM+Sans:wght@300;400;500;600&family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root {
            --cream:      #fdf8f4;
            --warm-white: #ffffff;
            --clay:       #973100;
            --clay-deep:  #3d1f0d;
            --clay-faint: #fff1ec;
            --blush:      #fecbc6;
            --cocoa:      #3d1f0d;
            --sand:       #e8ddd8;
            --sand-light: #f5efeb;
            --text-main:  #1e1210;
            --text-sub:   #6b4a42;
            --text-muted: #9e7a72;
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        html, body { height: 100%; }
        body { font-family: 'DM Sans', sans-serif; background: var(--cream); color: var(--text-main); }

        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 300, 'GRAD' 0, 'opsz' 24;
            vertical-align: middle;
        }

        /* ── LAYOUT SPLIT (invertido: form izquierda, deco derecha) ── */
        .auth-wrap {
            display: grid;
            grid-template-columns: 1fr 1fr;
            min-height: 100vh;
        }

        /* ── PANEL FORMULARIO (izquierda) ── */
        .auth-panel-form {
            background: var(--warm-white);
            display: flex; align-items: center; justify-content: center;
            padding: 48px 52px;
            overflow-y: auto;
        }

        .auth-form-wrap {
            width: 100%; max-width: 420px;
            animation: authFade 0.5s ease both;
        }

        .auth-form-title {
            font-family: 'Playfair Display', serif;
            font-size: 30px; font-weight: 700;
            color: var(--text-main); margin-bottom: 6px; line-height: 1.2;
        }
        .auth-form-sub {
            font-size: 14px; color: var(--text-muted);
            margin-bottom: 32px; line-height: 1.6;
        }

        /* ── CAMPOS ── */
        .auth-field { margin-bottom: 18px; }
        .auth-label {
            display: block; font-size: 12px; font-weight: 700;
            letter-spacing: 0.07em; text-transform: uppercase;
            color: var(--text-sub); margin-bottom: 7px;
        }
        .auth-input {
            display: block; width: 100%;
            padding: 13px 16px;
            background: var(--clay-faint);
            border: 1.5px solid var(--sand);
            border-radius: 10px;
            font-size: 15px; color: var(--text-main);
            font-family: 'DM Sans', sans-serif;
            outline: none; transition: border-color 0.2s, box-shadow 0.2s;
        }
        .auth-input:focus {
            border-color: var(--clay);
            box-shadow: 0 0 0 3px rgba(151,49,0,0.08);
        }
        .auth-error {
            font-size: 12px; color: #dc2626;
            margin-top: 5px; display: flex; align-items: center; gap: 4px;
        }

        /* fila de dos columnas para contraseñas */
        .auth-row {
            display: grid; grid-template-columns: 1fr 1fr; gap: 14px;
        }

        /* ── TÉRMINOS ── */
        .auth-terms {
            display: flex; align-items: flex-start; gap: 10px;
            font-size: 13px; color: var(--text-muted);
            margin-bottom: 24px; line-height: 1.5;
        }
        .auth-terms input {
            width: 16px; height: 16px; border-radius: 4px; margin-top: 2px;
            border: 1.5px solid var(--sand); accent-color: var(--clay);
            flex-shrink: 0; cursor: pointer;
        }

        /* ── BOTÓN ── */
        .auth-btn {
            width: 100%; padding: 15px;
            background: var(--clay); color: #fff;
            font-size: 15px; font-weight: 700; letter-spacing: 0.04em;
            border: none; border-radius: 12px; cursor: pointer;
            display: flex; align-items: center; justify-content: center; gap: 8px;
            box-shadow: 0 6px 20px rgba(151,49,0,0.28);
            transition: opacity 0.2s, transform 0.15s;
            font-family: 'DM Sans', sans-serif;
        }
        .auth-btn:hover  { opacity: 0.88; }
        .auth-btn:active { transform: scale(0.98); }

        /* ── DIVIDER ── */
        .auth-divider {
            display: flex; align-items: center; gap: 14px;
            margin: 24px 0; color: var(--text-muted); font-size: 12px;
            letter-spacing: 0.1em; text-transform: uppercase;
        }
        .auth-divider::before,
        .auth-divider::after { content: ''; flex: 1; height: 1px; background: var(--sand); }

        .auth-link-row {
            text-align: center; font-size: 14px; color: var(--text-muted);
        }
        .auth-link-row a {
            color: var(--clay); font-weight: 700; text-decoration: none; transition: opacity 0.2s;
        }
        .auth-link-row a:hover { opacity: 0.75; }

        /* ── PANEL DECORATIVO (derecha) ── */
        .auth-panel-deco {
            position: relative;
            overflow: hidden;
            display: flex; flex-direction: column;
            justify-content: space-between;
            padding: 48px 52px;
        }

        .auth-panel-deco::before {
            content: '';
            position: absolute; inset: 0;
            background: linear-gradient(150deg, #973100 0%, #6b2e18 50%, #3d1f0d 100%);
        }
        .auth-panel-deco::after {
            content: '';
            position: absolute; inset: 0;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.85' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='0.055'/%3E%3C/svg%3E");
            pointer-events: none;
        }

        /* formas decorativas en el panel derecho */
        .auth-deco-ring {
            position: absolute;
            border-radius: 50%;
            border: 1px solid rgba(254,203,198,0.1);
            pointer-events: none;
        }
        .auth-deco-ring-1 { width: 420px; height: 420px; left: -160px; bottom: -100px; }
        .auth-deco-ring-2 { width: 260px; height: 260px; left: -60px;  bottom: -10px; border-color: rgba(254,203,198,0.06); }
        .auth-deco-ring-3 { width: 300px; height: 300px; right: -100px; top: 40px; }

        /* logo superior en el panel deco */
        .auth-deco-logo {
            position: relative; z-index: 2;
            display: flex; align-items: center; gap: 12px;
            justify-content: flex-end;
        }
        .auth-deco-logo-name {
            font-family: 'Playfair Display', serif;
            font-size: 20px; font-weight: 700; color: #fff; letter-spacing: -0.01em;
        }
        .auth-deco-logo-icon {
            width: 40px; height: 40px; border-radius: 10px;
            background: rgba(254,203,198,0.15); backdrop-filter: blur(8px);
            display: flex; align-items: center; justify-content: center;
        }
        .auth-deco-logo-icon .material-symbols-outlined { font-size: 22px; color: var(--blush); }

        /* cuerpo central del panel deco */
        .auth-deco-body {
            position: relative; z-index: 2;
        }
        .auth-deco-eyebrow {
            font-size: 11px; font-weight: 700; letter-spacing: 0.2em;
            text-transform: uppercase; color: var(--blush); opacity: 0.65;
            margin-bottom: 20px;
            display: flex; align-items: center; gap: 10px;
        }
        .auth-deco-eyebrow::after { content: ''; width: 28px; height: 1px; background: currentColor; }

        .auth-deco-headline {
            font-family: 'Playfair Display', serif;
            font-size: clamp(28px, 2.8vw, 42px);
            font-weight: 700; line-height: 1.15;
            color: #fff; margin-bottom: 20px;
        }
        .auth-deco-headline em { font-style: italic; color: var(--blush); }

        .auth-deco-sub {
            font-size: 14px; color: rgba(255,255,255,0.5);
            line-height: 1.8; max-width: 320px;
        }

        /* beneficios */
        .auth-deco-benefits {
            position: relative; z-index: 2;
            display: flex; flex-direction: column; gap: 14px;
        }
        .auth-deco-benefit {
            display: flex; align-items: center; gap: 12px;
            font-size: 13px; color: rgba(255,255,255,0.6);
        }
        .auth-deco-benefit .material-symbols-outlined {
            font-size: 18px; color: var(--blush); opacity: 0.8;
            font-variation-settings: 'FILL' 1, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }

        /* ── RESPONSIVE ── */
        @media (max-width: 860px) {
            .auth-wrap { grid-template-columns: 1fr; }
            .auth-panel-deco { display: none; }
            .auth-panel-form { padding: 40px 24px; min-height: 100vh; }
            .auth-row { grid-template-columns: 1fr; }
        }

        @keyframes authFade {
            from { opacity: 0; transform: translateY(16px); }
            to   { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>
<div class="auth-wrap">

    {{-- ── FORMULARIO (izquierda) ── --}}
    <div class="auth-panel-form">
        <div class="auth-form-wrap">

            <h2 class="auth-form-title">Crear una cuenta</h2>
            <p class="auth-form-sub">Únete a Amoretti y empieza a celebrar con sabor.</p>

            <form wire:submit="register">

                {{-- Nombre --}}
                <div class="auth-field">
                    <label for="name" class="auth-label">Nombre completo</label>
                    <input wire:model="name" id="name" name="name" type="text"
                           class="auth-input" required autofocus autocomplete="name"
                           placeholder="Tu nombre">
                    <x-input-error :messages="$errors->get('name')" class="auth-error" />
                </div>

                {{-- Email --}}
                <div class="auth-field">
                    <label for="email" class="auth-label">Correo electrónico</label>
                    <input wire:model="email" id="email" name="email" type="email"
                           class="auth-input" required autocomplete="username"
                           placeholder="tu@correo.com">
                    <x-input-error :messages="$errors->get('email')" class="auth-error" />
                </div>

                {{-- Contraseñas en fila de dos --}}
                <div class="auth-row">
                    <div class="auth-field">
                        <label for="password" class="auth-label">Contraseña</label>
                        <input wire:model="password" id="password" name="password" type="password"
                               class="auth-input" required autocomplete="new-password"
                               placeholder="••••••••">
                        <x-input-error :messages="$errors->get('password')" class="auth-error" />
                    </div>
                    <div class="auth-field">
                        <label for="password_confirmation" class="auth-label">Confirmar</label>
                        <input wire:model="password_confirmation" id="password_confirmation"
                               name="password_confirmation" type="password"
                               class="auth-input" required autocomplete="new-password"
                               placeholder="••••••••">
                        <x-input-error :messages="$errors->get('password_confirmation')" class="auth-error" />
                    </div>
                </div>

                {{-- Submit --}}
                <button type="submit" class="auth-btn">
                    <span class="material-symbols-outlined" style="font-size:20px;font-variation-settings:'FILL' 1,'wght' 400,'GRAD' 0,'opsz' 24;">person_add</span>
                    Crear cuenta
                </button>
            </form>

            <div class="auth-divider">o</div>

            <div class="auth-link-row">
                ¿Ya tienes cuenta?
                <a href="{{ route('login') }}" wire:navigate> Inicia sesión</a>
            </div>
        </div>
    </div>

    {{-- ── PANEL DECORATIVO (derecha) ── --}}
    <div class="auth-panel-deco">
        <div class="auth-deco-ring auth-deco-ring-1"></div>
        <div class="auth-deco-ring auth-deco-ring-2"></div>
        <div class="auth-deco-ring auth-deco-ring-3"></div>

        <div class="auth-deco-logo">
            <span class="auth-deco-logo-name">Amoretti</span>
            <div class="auth-deco-logo-icon">
                <span class="material-symbols-outlined">cake</span>
            </div>
        </div>

        <div class="auth-deco-body">
            <p class="auth-deco-eyebrow">Bienvenido al obrador</p>
            <h2 class="auth-deco-headline">
                Tu primera cuenta,<br>tu primera <em>celebración</em>
            </h2>
            <p class="auth-deco-sub">
                Accede a pedidos personalizados, historial de compras y ofertas exclusivas para miembros.
            </p>
        </div>

        <div class="auth-deco-benefits">
            <div class="auth-deco-benefit">
                <span class="material-symbols-outlined">verified</span>
                Ingredientes naturales y de temporada
            </div>
            <div class="auth-deco-benefit">
                <span class="material-symbols-outlined">local_shipping</span>
                Entrega a domicilio en SLP
            </div>
            <div class="auth-deco-benefit">
                <span class="material-symbols-outlined">workspace_premium</span>
                Recetas artesanales con más de 12 años
            </div>
            <div class="auth-deco-benefit">
                <span class="material-symbols-outlined">favorite</span>
                Diseños personalizados para cada ocasión
            </div>
        </div>
    </div>

</div>
</body>
</html>