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

        $this->redirectIntended(
            default: route('dashboard', absolute: false),
            navigate: true
        );
    }
};

?>

<div class="min-h-screen flex items-center justify-center bg-[#fff8f6] px-6 py-10">
    <div class="w-full max-w-md bg-white rounded-3xl shadow-xl border border-[#f1dfda] p-8">

        <!-- Logo -->
        <div class="flex flex-col items-center mb-8 gap-2">
            <span class="material-symbols-outlined text-[#4d2c26] text-5xl">
                bakery_dining
            </span>

            <h1 class="font-serif text-3xl font-semibold text-[#341712]">
                Amoretti
            </h1>
        </div>

        <!-- Header -->
        <div class="mb-8 text-center">
            <h2 class="text-3xl font-bold text-[#341712] mb-2">
                Bienvenido de nuevo
            </h2>

            <p class="text-[#6b5b58] text-sm">
                Ingresa tus credenciales para continuar
            </p>
        </div>

        <!-- Session Status -->
        <x-auth-session-status
            class="mb-4 text-sm text-green-700 bg-green-50 rounded-xl p-3"
            :status="session('status')"
        />

        <!-- Form -->
        <form wire:submit.prevent="login" class="space-y-6">

            <!-- Email -->
            <div>
                <x-input-label
                    for="email"
                    :value="__('Correo electrónico')"
                    class="mb-2 text-[#341712] font-semibold"
                />

                <x-text-input
                    wire:model.defer="form.email"
                    id="email"
                    type="email"
                    name="email"
                    required
                    autofocus
                    autocomplete="username"
                    class="block w-full rounded-xl border-[#d5c2bf] bg-[#fff1ed] focus:border-[#4d2c26] focus:ring-[#4d2c26]"
                />

                <x-input-error
                    :messages="$errors->get('form.email')"
                    class="mt-2 text-sm"
                />
            </div>

            <!-- Password -->
            <div>
                <div class="flex items-center justify-between mb-2">
                    <x-input-label
                        for="password"
                        :value="__('Contraseña')"
                        class="text-[#341712] font-semibold"
                    />

                    @if (Route::has('password.request'))
                        <a
                            href="{{ route('password.request') }}"
                            wire:navigate
                            class="text-sm text-[#7b5455] hover:text-[#341712] transition"
                        >
                            ¿Olvidaste tu contraseña?
                        </a>
                    @endif
                </div>

                <x-text-input
                    wire:model.defer="form.password"
                    id="password"
                    type="password"
                    name="password"
                    required
                    autocomplete="current-password"
                    class="block w-full rounded-xl border-[#d5c2bf] bg-[#fff1ed] focus:border-[#4d2c26] focus:ring-[#4d2c26]"
                />

                <x-input-error
                    :messages="$errors->get('form.password')"
                    class="mt-2 text-sm"
                />
            </div>

            <!-- Remember -->
            <div class="flex items-center">
                <input
                    wire:model="form.remember"
                    id="remember"
                    type="checkbox"
                    class="rounded border-[#d5c2bf] text-[#4d2c26] focus:ring-[#4d2c26]"
                >

                <label for="remember" class="ml-2 text-sm text-[#341712]">
                    Recordarme
                </label>
            </div>

            <!-- Button -->
            <div>
                <x-primary-button
                    class="w-full justify-center rounded-xl bg-[#4d2c26] py-3 text-white hover:opacity-90 transition"
                >
                    {{ __('Iniciar sesión') }}
                </x-primary-button>
            </div>
        </form>

        <!-- Divider -->
        <div class="relative my-8">
            <div class="absolute inset-0 flex items-center">
                <div class="w-full border-t border-[#ead7d2]"></div>
            </div>

            <div class="relative flex justify-center text-xs uppercase">
                <span class="bg-white px-4 text-[#8a7a77]">
                    O
                </span>
            </div>
        </div>

        <!-- Register -->
        <div class="text-center text-sm text-[#6b5b58]">
            ¿No tienes cuenta?

            <a
                href="{{ route('register') }}"
                wire:navigate
                class="font-semibold text-[#7b5455] hover:text-[#341712]"
            >
                Crear una cuenta
            </a>
        </div>
    </div>
</div>