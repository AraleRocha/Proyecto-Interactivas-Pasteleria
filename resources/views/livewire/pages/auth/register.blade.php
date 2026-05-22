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
}; ?>

<div>
    <header class="space-y-2 mb-6">
        <h2 class="font-display text-3xl font-semibold text-[#341712]">Crear una cuenta</h2>
        <p class="text-[#514442]">Regístrate para comenzar tu viaje gastronómico.</p>
    </header>

    <form wire:submit="register" class="space-y-5">
        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" class="block text-sm font-semibold text-[#221a17] mb-1" />
            <x-text-input wire:model="name" id="name" class="block mt-1 w-full bg-[#fff1ed] border-[#d5c2bf] rounded-xl focus:border-[#4d2c26] focus:ring-1 focus:ring-[#4d2c26] py-3" type="text" name="name" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2 text-red-600 text-sm" />
        </div>

        <!-- Email -->
        <div>
            <x-input-label for="email" :value="__('Email')" class="block text-sm font-semibold text-[#221a17] mb-1" />
            <x-text-input wire:model="email" id="email" class="block mt-1 w-full bg-[#fff1ed] border-[#d5c2bf] rounded-xl focus:border-[#4d2c26] focus:ring-1 focus:ring-[#4d2c26] py-3" type="email" name="email" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-600 text-sm" />
        </div>

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Password')" class="block text-sm font-semibold text-[#221a17] mb-1" />
            <x-text-input wire:model="password" id="password" class="block mt-1 w-full bg-[#fff1ed] border-[#d5c2bf] rounded-xl focus:border-[#4d2c26] focus:ring-1 focus:ring-[#4d2c26] py-3" type="password" name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-600 text-sm" />
        </div>

        <!-- Confirm Password -->
        <div>
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="block text-sm font-semibold text-[#221a17] mb-1" />
            <x-text-input wire:model="password_confirmation" id="password_confirmation" class="block mt-1 w-full bg-[#fff1ed] border-[#d5c2bf] rounded-xl focus:border-[#4d2c26] focus:ring-1 focus:ring-[#4d2c26] py-3" type="password" name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-red-600 text-sm" />
        </div>


        <div class="flex items-center justify-end mt-4">
            <x-primary-button class="w-full justify-center py-3 bg-[#4d2c26] hover:opacity-90 active:scale-[0.98] transition rounded-xl text-white font-semibold">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>

    <div class="text-center pt-6">
        <p class="text-[#514442]">
            ¿Ya tienes cuenta?
            <a href="{{ route('login') }}" class="font-bold text-[#7b5455] hover:text-[#341712] transition-colors" wire:navigate>Inicia sesión</a>
        </p>
    </div>
</div>