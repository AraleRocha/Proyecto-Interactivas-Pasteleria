<?php

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;
use App\Mail\Bienvenida;

new #[Layout('layouts.guest')] class extends Component
{
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    /**
     * Handle an incoming registration request.
     */
    public function register(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        event(new Registered($user = User::create($validated)));

        // Enviar email de bienvenida
        Mail::to($user->email)->queue(new Bienvenida($user));

        Auth::login($user);

        $this->redirect(route('dashboard', absolute: false), navigate: true);
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
        --sand:       #e8ddd8;
        --text-main:  #1e1210;
        --text-sub:   #6b4a42;
        --text-muted: #9e7a72;
    }

    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    .rg-wrap {
        display: grid;
        grid-template-columns: 1fr 1fr;
        min-height: 100vh;
        font-family: 'DM Sans', sans-serif;
    }

    /* ── Panel formulario (izquierda en register) ── */
    .rg-form-panel {
        background: var(--warm-white);
        display: flex; align-items: center; justify-content: center;
        padding: 48px 56px;
        overflow-y: auto;
    }
    .rg-form-wrap {
        width: 100%; max-width: 460px;
        animation: rgFade 0.5s ease both;
    }
    @keyframes rgFade {
        from { opacity: 0; transform: translateY(16px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    .rg-title {
        font-family: 'Playfair Display', serif;
        font-size: 34px; font-weight: 700; color: var(--text-main); margin-bottom: 6px;
    }
    .rg-sub { font-size: 15px; color: var(--text-muted); margin-bottom: 32px; line-height: 1.6; }

    /* Campos */
    .rg-field { margin-bottom: 20px; }
    .rg-label {
        display: block; font-size: 12px; font-weight: 700;
        letter-spacing: 0.07em; text-transform: uppercase;
        color: var(--text-sub); margin-bottom: 7px;
    }
    .rg-input {
        display: block; width: 100%; padding: 13px 16px;
        background: var(--clay-faint); border: 1.5px solid var(--sand);
        border-radius: 12px; font-size: 15px; color: var(--text-main);
        font-family: 'DM Sans', sans-serif; outline: none;
        transition: border-color 0.2s, box-shadow 0.2s;
    }
    .rg-input:focus { border-color: var(--clay); box-shadow: 0 0 0 3px rgba(151,49,0,0.08); }

    /* Errores Blade */
    .rg-field p { font-size: 12px; color: #dc2626; margin-top: 5px; }

    /* Fila dos columnas para contraseñas */
    .rg-row { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }

    /* Botón */
    .rg-btn {
        width: 100%; padding: 15px; background: var(--clay); color: #fff;
        font-size: 15px; font-weight: 700; letter-spacing: 0.04em;
        border: none; border-radius: 12px; cursor: pointer;
        display: flex; align-items: center; justify-content: center; gap: 8px;
        box-shadow: 0 6px 20px rgba(151,49,0,0.28);
        transition: opacity 0.2s, transform 0.15s; font-family: 'DM Sans', sans-serif;
        margin-top: 8px;
    }
    .rg-btn:hover  { opacity: 0.88; }
    .rg-btn:active { transform: scale(0.98); }

    /* Divider */
    .rg-divider {
        display: flex; align-items: center; gap: 14px;
        margin: 24px 0; color: var(--text-muted); font-size: 12px;
        letter-spacing: 0.1em; text-transform: uppercase;
    }
    .rg-divider::before, .rg-divider::after { content: ''; flex: 1; height: 1px; background: var(--sand); }

    /* Link */
    .rg-link-row { text-align: center; font-size: 14px; color: var(--text-muted); }
    .rg-link-row a { color: var(--clay); font-weight: 700; text-decoration: none; transition: opacity 0.2s; }
    .rg-link-row a:hover { opacity: 0.75; }

    /* ── Panel decorativo (derecha en register) ── */
    .rg-deco {
        position: relative;
        display: flex; flex-direction: column;
        justify-content: space-between;
        padding: 48px 52px; overflow: hidden;
    }
    .rg-deco::before {
        content: '';
        position: absolute; inset: 0;
        background: linear-gradient(150deg, #973100 0%, #6b2e18 50%, #3d1f0d 100%);
    }
    .rg-deco::after {
        content: '';
        position: absolute; inset: 0;
        background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.85' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='0.055'/%3E%3C/svg%3E");
        pointer-events: none;
    }
    .rg-circle {
        position: absolute; border-radius: 50%;
        border: 1px solid rgba(254,203,198,0.1); pointer-events: none;
    }
    .rg-c1 { width: 420px; height: 420px; left: -160px; bottom: -100px; }
    .rg-c2 { width: 260px; height: 260px; left: -60px;  bottom: -10px; border-color: rgba(254,203,198,0.06); }
    .rg-c3 { width: 300px; height: 300px; right: -100px; top: 40px; }

    .rg-deco-logo {
        position: relative; z-index: 2;
        display: flex; align-items: center; gap: 12px; justify-content: flex-end;
    }
    .rg-deco-logo-name {
        font-family: 'Playfair Display', serif;
        font-size: 20px; font-weight: 700; color: #fff;
    }
    .rg-deco-logo-icon {
        width: 40px; height: 40px; border-radius: 10px;
        background: rgba(254,203,198,0.15); backdrop-filter: blur(8px);
        display: flex; align-items: center; justify-content: center;
    }
    .rg-deco-logo-icon .material-symbols-outlined { font-size: 22px; color: var(--blush); }

    .rg-deco-body { position: relative; z-index: 2; }
    .rg-deco-tag {
        font-size: 11px; font-weight: 700; letter-spacing: 0.2em;
        text-transform: uppercase; color: var(--blush); opacity: 0.65;
        margin-bottom: 20px; display: flex; align-items: center; gap: 10px;
    }
    .rg-deco-tag::after { content: ''; width: 28px; height: 1px; background: currentColor; }
    .rg-deco-headline {
        font-family: 'Playfair Display', serif;
        font-size: clamp(28px, 2.8vw, 42px); font-weight: 700;
        line-height: 1.15; color: #fff; margin-bottom: 20px;
    }
    .rg-deco-headline em { font-style: italic; color: var(--blush); }
    .rg-deco-sub { font-size: 14px; color: rgba(255,255,255,0.5); line-height: 1.8; max-width: 320px; }

    .rg-deco-benefits { position: relative; z-index: 2; display: flex; flex-direction: column; gap: 14px; }
    .rg-benefit {
        display: flex; align-items: center; gap: 12px;
        font-size: 13px; color: rgba(255,255,255,0.6);
    }
    .rg-benefit .material-symbols-outlined {
        font-size: 18px; color: var(--blush); opacity: 0.8;
        font-variation-settings: 'FILL' 1,'wght' 400,'GRAD' 0,'opsz' 24;
    }

    /* Responsive */
    @media (max-width: 860px) {
        .rg-wrap { grid-template-columns: 1fr; }
        .rg-deco { display: none; }
        .rg-form-panel { padding: 40px 24px; min-height: 100vh; }
        .rg-row { grid-template-columns: 1fr; }
    }

    .material-symbols-outlined {
        font-variation-settings: 'FILL' 0, 'wght' 300, 'GRAD' 0, 'opsz' 24;
        vertical-align: middle;
    }
</style>

<div class="rg-wrap">

    {{-- parte izquierda --}}
    <div class="rg-form-panel">
        <div class="rg-form-wrap">

            <h2 class="rg-title">Crear una cuenta</h2>
            <p class="rg-sub">Únete a Amoretti y empieza a celebrar con sabor.</p>

            <form wire:submit="register">

                {{-- Nombre --}}
                <div class="rg-field">
                    <label for="name" class="rg-label">Nombre completo</label>
                    <input wire:model="name"
                           id="name" name="name" type="text"
                           class="rg-input" required autofocus autocomplete="name"
                           placeholder="Tu nombre">
                    <x-input-error :messages="$errors->get('name')" />
                </div>

                {{-- Email --}}
                <div class="rg-field">
                    <label for="email" class="rg-label">Correo electrónico</label>
                    <input wire:model="email"
                           id="email" name="email" type="email"
                           class="rg-input" required autocomplete="username"
                           placeholder="tu@correo.com">
                    <x-input-error :messages="$errors->get('email')" />
                </div>

                {{-- Contraseñas en fila --}}
                <div class="rg-row">
                    <div class="rg-field">
                        <label for="password" class="rg-label">Contraseña</label>
                        <input wire:model="password"
                               id="password" name="password" type="password"
                               class="rg-input" required autocomplete="new-password"
                               placeholder="••••••••">
                        <x-input-error :messages="$errors->get('password')" />
                    </div>
                    <div class="rg-field">
                        <label for="password_confirmation" class="rg-label">Confirmar</label>
                        <input wire:model="password_confirmation"
                               id="password_confirmation" name="password_confirmation" type="password"
                               class="rg-input" required autocomplete="new-password"
                               placeholder="••••••••">
                        <x-input-error :messages="$errors->get('password_confirmation')" />
                    </div>
                </div>

                {{-- Submit --}}
                <button type="submit" class="rg-btn">
                    <span class="material-symbols-outlined" style="font-size:20px;font-variation-settings:'FILL' 1,'wght' 400,'GRAD' 0,'opsz' 24;">person_add</span>
                    Crear cuenta
                </button>
            </form>

            <div class="rg-divider">o</div>

            <div class="rg-link-row">
                ¿Ya tienes cuenta?
                <a href="{{ route('login') }}" wire:navigate>Inicia sesión</a>
            </div>
        </div>
    </div>

    {{-- parte derecha --}}
    <div class="rg-deco">
        <div class="rg-circle rg-c1"></div>
        <div class="rg-circle rg-c2"></div>
        <div class="rg-circle rg-c3"></div>

        <div class="rg-deco-logo">
            <span class="rg-deco-logo-name">Amoretti</span>
            <div class="rg-deco-logo-icon">
                <span class="material-symbols-outlined">cake</span>
            </div>
        </div>

        <div class="rg-deco-body">
            <p class="rg-deco-tag">Bienvenido al obrador</p>
            <h2 class="rg-deco-headline">Tu primera cuenta,<br>tu primera <em>celebración</em></h2>
            <p class="rg-deco-sub">Accede a un amplio catálogo de pasteles.</p>
        </div>

        <div class="rg-deco-benefits">
            <div class="rg-benefit">
                <span class="material-symbols-outlined">verified</span>
                Ingredientes naturales y de temporada
            </div>
            <div class="rg-benefit">
                <span class="material-symbols-outlined">workspace_premium</span>
                Recetas artesanales con más de 12 años
            </div>
            <div class="rg-benefit">
                <span class="material-symbols-outlined">favorite</span>
                Hermosos diseños para cada ocasión
            </div>
        </div>
    </div>

</div>
</div>