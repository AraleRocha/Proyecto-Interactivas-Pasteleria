<?php

use App\Livewire\Actions\Logout;
use Livewire\Volt\Component;

new class extends Component
{
    /**
     * Log the current user out of the application.
     */
    public function logout(Logout $logout): void
    {
        $logout();

        $this->redirect('/', navigate: true);
    }
}; ?>

<nav x-data="{ open: false }" class="nav-root">
<style>
    .nav-root {
        position: sticky; top: 0; z-index: 50;
        background: rgba(255,255,255,0.92);
        backdrop-filter: blur(12px);
        border-bottom: 1px solid var(--outline-variant);
        box-shadow: 0 1px 12px rgba(61,31,13,0.06);
    }

    .nav-inner {
        max-width: 1280px; margin: 0 auto;
        padding: 0 32px;
        height: 64px;
        display: flex; align-items: center; justify-content: space-between; gap: 24px;
    }

    /* ── Logo ── */
    .nav-logo {
        display: flex; align-items: center; gap: 10px;
        text-decoration: none; flex-shrink: 0;
    }
    .nav-logo-icon {
        width: 36px; height: 36px; border-radius: 10px;
        background: var(--primary);
        display: flex; align-items: center; justify-content: center;
    }
    .nav-logo-icon .material-symbols-outlined {
        font-size: 20px; color: #fff;
        font-variation-settings: 'FILL' 1,'wght' 400,'GRAD' 0,'opsz' 24;
    }
    .nav-logo-name {
        font-family: 'Playfair Display', serif;
        font-size: 18px; font-weight: 700;
        color: var(--on-surface); letter-spacing: -0.01em;
    }

    /* ── Links ── */
    .nav-links {
        display: flex; align-items: center; gap: 2px;
        flex: 1; margin-left: 32px;
    }
    .nav-link {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 7px 14px; border-radius: 9px;
        font-size: 13px; font-weight: 600;
        color: var(--on-surface-variant);
        text-decoration: none;
        transition: background 0.15s, color 0.15s;
        position: relative;
    }
    .nav-link:hover {
        background: var(--surface-container-low);
        color: var(--on-surface);
    }
    .nav-link.active {
        background: var(--primary-fixed);
        color: var(--primary);
    }
    .nav-link .material-symbols-outlined { font-size: 17px; }

    /* ── Derecha: usuario ── */
    .nav-right { display: flex; align-items: center; gap: 12px; }

    .nav-user-btn {
        display: flex; align-items: center; gap: 8px;
        padding: 6px 12px 6px 6px;
        border-radius: 10px; border: 1px solid var(--outline-variant);
        background: var(--surface-container-low);
        cursor: pointer; transition: background 0.15s;
        font-size: 13px; font-weight: 600; color: var(--on-surface);
    }
    .nav-user-btn:hover { background: var(--surface-container); }
    .nav-avatar {
        width: 28px; height: 28px; border-radius: 8px;
        background: var(--secondary-container);
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }
    .nav-avatar .material-symbols-outlined {
        font-size: 16px; color: var(--secondary);
        font-variation-settings: 'FILL' 1,'wght' 400,'GRAD' 0,'opsz' 24;
    }
    .nav-chevron {
        font-size: 16px; color: var(--on-surface-variant);
        transition: transform 0.2s;
    }

    /* ── Dropdown ── */
    .nav-dropdown {
        min-width: 200px;
        background: var(--surface-container-lowest);
        border: 1px solid var(--outline-variant);
        border-radius: 14px;
        box-shadow: 0 8px 32px rgba(61,31,13,0.12);
        overflow: hidden; padding: 6px;
    }
    .nav-drop-header {
        padding: 10px 14px 8px;
        border-bottom: 1px solid var(--outline-variant);
        margin-bottom: 4px;
    }
    .nav-drop-name { font-size: 13px; font-weight: 700; color: var(--on-surface); }
    .nav-drop-email { font-size: 11px; color: var(--on-surface-variant); margin-top: 1px; }

    .nav-drop-item {
        display: flex; align-items: center; gap: 8px;
        padding: 8px 12px; border-radius: 8px;
        font-size: 13px; font-weight: 500; color: var(--on-surface);
        text-decoration: none; cursor: pointer; width: 100%;
        background: none; border: none; text-align: left;
        transition: background 0.15s;
    }
    .nav-drop-item:hover { background: var(--surface-container-low); }
    .nav-drop-item .material-symbols-outlined { font-size: 17px; color: var(--on-surface-variant); }
    .nav-drop-item.danger { color: var(--error); }
    .nav-drop-item.danger .material-symbols-outlined { color: var(--error); }
    .nav-drop-sep { height: 1px; background: var(--outline-variant); margin: 4px 0; }

    /* ── Hamburger ── */
    .nav-hamburger {
        display: none; align-items: center; justify-content: center;
        width: 36px; height: 36px; border-radius: 9px;
        background: var(--surface-container-low);
        border: 1px solid var(--outline-variant);
        cursor: pointer; color: var(--on-surface-variant);
        transition: background 0.15s;
    }
    .nav-hamburger:hover { background: var(--surface-container); }
    .nav-hamburger .material-symbols-outlined { font-size: 20px; }

    /* ── Mobile menu ── */
    .nav-mobile {
        border-top: 1px solid var(--outline-variant);
        padding: 12px 16px;
        background: var(--surface-container-lowest);
        display: flex; flex-direction: column; gap: 4px;
    }
    .nav-mobile-link {
        display: flex; align-items: center; gap: 10px;
        padding: 10px 14px; border-radius: 10px;
        font-size: 14px; font-weight: 600; color: var(--on-surface-variant);
        text-decoration: none; transition: background 0.15s, color 0.15s;
    }
    .nav-mobile-link:hover, .nav-mobile-link.active {
        background: var(--surface-container-low); color: var(--primary);
    }
    .nav-mobile-link .material-symbols-outlined { font-size: 18px; }
    .nav-mobile-sep {
        height: 1px; background: var(--outline-variant); margin: 8px 0;
    }
    .nav-mobile-user {
        padding: 10px 14px; display: flex; align-items: center; gap: 10px;
    }
    .nav-mobile-avatar {
        width: 36px; height: 36px; border-radius: 10px;
        background: var(--secondary-container);
        display: flex; align-items: center; justify-content: center; flex-shrink: 0;
    }
    .nav-mobile-avatar .material-symbols-outlined {
        font-size: 20px; color: var(--secondary);
        font-variation-settings: 'FILL' 1,'wght' 400,'GRAD' 0,'opsz' 24;
    }
    .nav-mobile-name { font-size: 14px; font-weight: 700; color: var(--on-surface); }
    .nav-mobile-email { font-size: 12px; color: var(--on-surface-variant); }

    @media (max-width: 768px) {
        .nav-links { display: none; }
        .nav-user-btn { display: none; }
        .nav-hamburger { display: flex; }
        .nav-inner { padding: 0 16px; }
    }
</style>

    <div class="nav-inner">

        {{-- Logo --}}
        <a href="{{ route('dashboard') }}" class="nav-logo" wire:navigate>
            <div class="nav-logo-icon">
                <span class="material-symbols-outlined">cake</span>
            </div>
            <span class="nav-logo-name">Amoretti</span>
        </a>

        {{-- Links desktop --}}
        <div class="nav-links">
            <a href="{{ route('dashboard') }}"
               class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
               wire:navigate>
                <span class="material-symbols-outlined">dashboard</span>
                Dashboard
            </a>

            @if(auth()->user()->role === 'admin')
                <a href="{{ route('productos.index') }}"
                   class="nav-link {{ request()->routeIs('productos.*') ? 'active' : '' }}"
                   wire:navigate>
                    <span class="material-symbols-outlined">inventory_2</span>
                    Productos
                </a>
                <a href="{{ route('productos.index') }}"
                   class="nav-link {{ request()->routeIs('productos.*') ? 'active' : '' }}"
                   wire:navigate>
                    <span class="material-symbols-outlined">inventory_2</span>
                    Pedidos
                </a>
            @endif

            <a href="{{ route('catalogo.index') }}"
               class="nav-link {{ request()->routeIs('catalogo.*') ? 'active' : '' }}"
               wire:navigate>
                <span class="material-symbols-outlined">storefront</span>
                Catálogo
            </a>

            <a href="{{ route('pedidos.index') }}"
               class="nav-link {{ request()->routeIs('pedidos.*') ? 'active' : '' }}"
               wire:navigate>
                <span class="material-symbols-outlined">receipt_long</span>
                {{ auth()->user()->role === 'admin' ? 'Pedidos' : 'Mis pedidos' }}
            </a>
        </div>

        {{-- Usuario desktop --}}
        <div class="nav-right">
            <x-dropdown align="right" width="56">
                <x-slot name="trigger">
                    <button class="nav-user-btn">
                        <div class="nav-avatar">
                            <span class="material-symbols-outlined">person</span>
                        </div>
                        <span x-data="{{ json_encode(['name' => auth()->user()->name]) }}"
                              x-text="name"
                              x-on:profile-updated.window="name = $event.detail.name">
                        </span>
                        <span class="material-symbols-outlined nav-chevron">expand_more</span>
                    </button>
                </x-slot>

                <x-slot name="content">
                    <div class="nav-dropdown">
                        {{-- Info usuario --}}
                        <div class="nav-drop-header">
                            <p class="nav-drop-name">{{ auth()->user()->name }}</p>
                            <p class="nav-drop-email">{{ auth()->user()->email }}</p>
                        </div>

                        {{-- Perfil --}}
                        <a href="{{ route('profile') }}" class="nav-drop-item" wire:navigate>
                            <span class="material-symbols-outlined">manage_accounts</span>
                            Mi perfil
                        </a>

                        <div class="nav-drop-sep"></div>

                        {{-- Logout --}}
                        <button wire:click="logout" class="nav-drop-item danger">
                            <span class="material-symbols-outlined">logout</span>
                            Cerrar sesión
                        </button>
                    </div>
                </x-slot>
            </x-dropdown>

            {{-- Hamburger mobile --}}
            <button @click="open = !open" class="nav-hamburger">
                <span class="material-symbols-outlined" x-show="!open">menu</span>
                <span class="material-symbols-outlined" x-show="open" x-cloak>close</span>
            </button>
        </div>
    </div>

    {{-- Mobile menu --}}
    <div class="nav-mobile" :class="{'block': open, 'hidden': !open}" x-show="open" x-cloak
         x-transition:enter="transition ease-out duration-150"
         x-transition:enter-start="opacity-0 -translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0">

        {{-- Info usuario --}}
        <div class="nav-mobile-user">
            <div class="nav-mobile-avatar">
                <span class="material-symbols-outlined">person</span>
            </div>
            <div>
                <p class="nav-mobile-name">{{ auth()->user()->name }}</p>
                <p class="nav-mobile-email">{{ auth()->user()->email }}</p>
            </div>
        </div>

        <div class="nav-mobile-sep"></div>

        <a href="{{ route('dashboard') }}"
           class="nav-mobile-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
           wire:navigate @click="open = false">
            <span class="material-symbols-outlined">dashboard</span>
            Dashboard
        </a>

        @if(auth()->user()->role === 'admin')
            <a href="{{ route('productos.index') }}"
               class="nav-mobile-link {{ request()->routeIs('productos.*') ? 'active' : '' }}"
               wire:navigate @click="open = false">
                <span class="material-symbols-outlined">inventory_2</span>
                Productos
            </a>
        @endif

        <a href="{{ route('catalogo.index') }}"
           class="nav-mobile-link {{ request()->routeIs('catalogo.*') ? 'active' : '' }}"
           wire:navigate @click="open = false">
            <span class="material-symbols-outlined">storefront</span>
            Catálogo
        </a>

        <a href="{{ route('pedidos.index') }}"
           class="nav-mobile-link {{ request()->routeIs('pedidos.*') ? 'active' : '' }}"
           wire:navigate @click="open = false">
            <span class="material-symbols-outlined">receipt_long</span>
            {{ auth()->user()->role === 'admin' ? 'Pedidos' : 'Mis pedidos' }}
        </a>

        <div class="nav-mobile-sep"></div>

        <a href="{{ route('profile') }}"
           class="nav-mobile-link"
           wire:navigate @click="open = false">
            <span class="material-symbols-outlined">manage_accounts</span>
            Mi perfil
        </a>

        <button wire:click="logout" class="nav-mobile-link danger"
                style="color:var(--error);background:none;border:none;cursor:pointer;width:100%;text-align:left;">
            <span class="material-symbols-outlined" style="color:var(--error);">logout</span>
            Cerrar sesión
        </button>
    </div>
</nav>