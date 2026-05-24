<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public LoginForm $form;

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate();

        $this->form->authenticate();

        session()->regenerate();

        if (Auth::user()->role === 'admin') {

            $this->redirect(
                route('admin.dashboard', absolute: false),
                navigate: true
            );

            return;
        }

        $this->redirect(
            route('client.dashboard', absolute: false),
            navigate: true
        );
    }
};

?>

<div>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400;1,600&family=DM+Sans:wght@300;400;500;600&family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
<style>
    :root {
        --cream:      #fdf8f4;
        --warm-white: #ffffff;
        --clay:       #973100;
        --clay-faint: #fff1ec;
        --blush:      #fecbc6;
        --cocoa:      #3d1f0d;
        --sand:       #e8ddd8;
        --text-main:  #1e1210;
        --text-sub:   #6b4a42;
        --text-muted: #9e7a72;
    }

    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    .al-wrap {
        display: grid;
        grid-template-columns: 1fr 1fr;
        min-height: 100vh;
        font-family: 'DM Sans', sans-serif;
    }

    .al-deco {
        position: relative;
        display: flex; flex-direction: column;
        justify-content: space-between;
        padding: 48px 52px;
        overflow: hidden;
    }
    .al-deco::before {
        content: '';
        position: absolute; inset: 0;
        background: linear-gradient(150deg, #3d1f0d 0%, #6b2e18 55%, #973100 100%);
    }
    .al-deco::after {
        content: '';
        position: absolute; inset: 0;
        background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.85' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='0.055'/%3E%3C/svg%3E");
        pointer-events: none;
    }
    .al-circle {
        position: absolute; border-radius: 50%;
        border: 1px solid rgba(254,203,198,0.12); pointer-events: none;
    }
    .al-c1 { width: 480px; height: 480px; right: -160px; top: -120px; }
    .al-c2 { width: 320px; height: 320px; right: -60px;  top: -20px; border-color: rgba(254,203,198,0.07); }
    .al-c3 { width: 220px; height: 220px; left: -80px;   bottom: 80px; }

    .al-deco-logo {
        position: relative; z-index: 2;
        display: flex; align-items: center; gap: 12px;
    }
    .al-deco-logo-icon {
        width: 44px; height: 44px; border-radius: 12px;
        background: rgba(254,203,198,0.15); backdrop-filter: blur(8px);
        display: flex; align-items: center; justify-content: center;
    }
    .al-deco-logo-icon .material-symbols-outlined { font-size: 24px; color: var(--blush); }
    .al-deco-logo-name {
        font-family: 'Playfair Display', serif;
        font-size: 22px; font-weight: 700; color: #fff;
    }

    .al-deco-body { position: relative; z-index: 2; }
    .al-deco-tag {
        font-size: 11px; font-weight: 700; letter-spacing: 0.2em;
        text-transform: uppercase; color: var(--blush); opacity: 0.7;
        margin-bottom: 20px; display: flex; align-items: center; gap: 10px;
    }
    .al-deco-tag::before { content: ''; width: 28px; height: 1px; background: currentColor; }
    .al-deco-headline {
        font-family: 'Playfair Display', serif;
        font-size: clamp(32px, 3.2vw, 48px); font-weight: 700;
        line-height: 1.1; color: #fff; margin-bottom: 20px;
    }
    .al-deco-headline em { font-style: italic; color: var(--blush); }
    .al-deco-sub { font-size: 15px; color: rgba(255,255,255,0.55); line-height: 1.75; max-width: 340px; }

    .al-deco-footer { position: relative; z-index: 2; display: flex; gap: 28px; }
    .al-stat-num {
        font-family: 'Playfair Display', serif;
        font-size: 36px; font-weight: 700; color: rgba(255,255,255,0.12); line-height: 1;
    }
    .al-stat-label { font-size: 11px; letter-spacing: 0.1em; text-transform: uppercase; color: rgba(255,255,255,0.3); margin-top: 2px; }
    .al-stat-sep   { width: 1px; background: rgba(255,255,255,0.1); align-self: stretch; }

    .al-form-panel {
        background: var(--warm-white);
        display: flex; align-items: center; justify-content: center;
        padding: 48px 56px;
    }
    .al-form-wrap {
        width: 100%; max-width: 460px;
        animation: alFade 0.5s ease both;
    }
    @keyframes alFade {
        from { opacity: 0; transform: translateY(16px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    .al-title {
        font-family: 'Playfair Display', serif;
        font-size: 34px; font-weight: 700; color: var(--text-main); margin-bottom: 6px;
    }
    .al-sub { font-size: 15px; color: var(--text-muted); margin-bottom: 36px; line-height: 1.6; }

    /* Campos */
    .al-field { margin-bottom: 22px; }
    .al-field-row {
        display: flex; justify-content: space-between; align-items: center; margin-bottom: 7px;
    }
    .al-label {
        font-size: 12px; font-weight: 700; letter-spacing: 0.07em;
        text-transform: uppercase; color: var(--text-sub);
    }
    .al-forgot { font-size: 12px; color: var(--text-muted); text-decoration: none; transition: color 0.2s; }
    .al-forgot:hover { color: var(--clay); }

    .al-input {
        display: block; width: 100%; padding: 14px 16px;
        background: var(--clay-faint); border: 1.5px solid var(--sand);
        border-radius: 12px; font-size: 15px; color: var(--text-main);
        font-family: 'DM Sans', sans-serif; outline: none;
        transition: border-color 0.2s, box-shadow 0.2s;
    }
    .al-input:focus { border-color: var(--clay); box-shadow: 0 0 0 3px rgba(151,49,0,0.08); }

    /* Errores Blade (x-input-error renderiza un <p>) */
    .al-field p { font-size: 12px; color: #dc2626; margin-top: 5px; }

    .al-remember {
        display: flex; align-items: center; gap: 8px;
        font-size: 13px; color: var(--text-sub);
        margin-bottom: 26px; cursor: pointer;
    }
    .al-remember input {
        width: 16px; height: 16px; border-radius: 4px;
        accent-color: var(--clay); cursor: pointer;
    }

    /* Status verde */
    .al-status {
        background: #ecfdf5; border: 1px solid #a7f3d0;
        color: #065f46; border-radius: 10px;
        padding: 12px 16px; font-size: 13px; margin-bottom: 20px;
    }

    /* Botón */
    .al-btn {
        width: 100%; padding: 15px; background: var(--clay); color: #fff;
        font-size: 15px; font-weight: 700; letter-spacing: 0.04em;
        border: none; border-radius: 12px; cursor: pointer;
        display: flex; align-items: center; justify-content: center; gap: 8px;
        box-shadow: 0 6px 20px rgba(151,49,0,0.28);
        transition: opacity 0.2s, transform 0.15s; font-family: 'DM Sans', sans-serif;
    }
    .al-btn:hover  { opacity: 0.88; }
    .al-btn:active { transform: scale(0.98); }

    .al-divider {
        display: flex; align-items: center; gap: 14px;
        margin: 26px 0; color: var(--text-muted); font-size: 12px;
        letter-spacing: 0.1em; text-transform: uppercase;
    }
    .al-divider::before, .al-divider::after { content: ''; flex: 1; height: 1px; background: var(--sand); }

    /* Link */
    .al-link-row { text-align: center; font-size: 14px; color: var(--text-muted); }
    .al-link-row a { color: var(--clay); font-weight: 700; text-decoration: none; transition: opacity 0.2s; }
    .al-link-row a:hover { opacity: 0.75; }

    /* Responsive */
    @media (max-width: 860px) {
        .al-wrap { grid-template-columns: 1fr; }
        .al-deco  { display: none; }
        .al-form-panel { padding: 40px 24px; min-height: 100vh; }
    }

    .material-symbols-outlined {
        font-variation-settings: 'FILL' 0, 'wght' 300, 'GRAD' 0, 'opsz' 24;
        vertical-align: middle;
    }
</style>

<div class="al-wrap">

    {{-- Parte izquierda --}}
    <div class="al-deco">
        <div class="al-circle al-c1"></div>
        <div class="al-circle al-c2"></div>
        <div class="al-circle al-c3"></div>

        <div class="al-deco-logo">
            <div class="al-deco-logo-icon">
                <span class="material-symbols-outlined">cake</span>
            </div>
            <span class="al-deco-logo-name">Amoretti</span>
        </div>

        <div class="al-deco-body">
            <p class="al-deco-tag">Pastelería Artesanal</p>
            <h1 class="al-deco-headline">El arte de<br>celebrar con <em>sabor</em></h1>
            <p class="al-deco-sub">Cada pastel es una historia. Ingredientes de temporada, técnicas heredadas y un toque de amor en cada capa.</p>
        </div>

        <div class="al-deco-footer">
            <div>
                <div class="al-stat-num">12</div>
                <div class="al-stat-label">Años de oficio</div>
            </div>
            <div class="al-stat-sep"></div>
            <div>
                <div class="al-stat-num">01</div>
                <div class="al-stat-label">Hecho al día</div>
            </div>
        </div>
    </div>

    {{-- Parte derecha --}}
    <div class="al-form-panel">
        <div class="al-form-wrap">

            <h2 class="al-title">Bienvenido de nuevo</h2>
            <p class="al-sub">Ingresa tus credenciales para continuar.</p>

            <x-auth-session-status class="al-status" :status="session('status')" />

            <form wire:submit.prevent="login">

                {{-- Email --}}
                <div class="al-field">
                    <div class="al-field-row">
                        <label for="email" class="al-label">Correo electrónico</label>
                    </div>
                    <input wire:model.defer="form.email"
                           id="email" name="email" type="email"
                           class="al-input" required autofocus autocomplete="username"
                           placeholder="tu@correo.com">
                    <x-input-error :messages="$errors->get('form.email')" />
                </div>

                {{-- Password --}}
                <div class="al-field">
                    <div class="al-field-row">
                        <label for="password" class="al-label">Contraseña</label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="al-forgot" wire:navigate>
                                ¿Olvidaste tu contraseña?
                            </a>
                        @endif
                    </div>
                    <input wire:model.defer="form.password"
                           id="password" name="password" type="password"
                           class="al-input" required autocomplete="current-password"
                           placeholder="••••••••">
                    <x-input-error :messages="$errors->get('form.password')" />
                </div>

                {{-- Remember --}}
                <label class="al-remember">
                    <input wire:model="form.remember" type="checkbox" name="remember">
                    Mantener sesión iniciada
                </label>

                {{-- Submit --}}
                <button type="submit" class="al-btn">
                    <span class="material-symbols-outlined" style="font-size:20px;font-variation-settings:'FILL' 1,'wght' 400,'GRAD' 0,'opsz' 24;">login</span>
                    Iniciar sesión
                </button>
            </form>

            <div class="al-divider">o</div>

            <div class="al-link-row">
                ¿No tienes cuenta?
                <a href="{{ route('register') }}" wire:navigate>Regístrate aquí</a>
            </div>
        </div>
    </div>

</div>
</div>