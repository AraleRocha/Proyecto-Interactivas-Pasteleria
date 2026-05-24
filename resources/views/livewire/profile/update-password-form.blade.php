<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;
use Livewire\Volt\Component;

new class extends Component
{
    public string $current_password = '';
    public string $password = '';
    public string $password_confirmation = '';

    /**
     * Update the password for the currently authenticated user.
     */
    public function updatePassword(): void
    {
        try {
            $validated = $this->validate([
                'current_password' => ['required', 'string', 'current_password'],
                'password' => ['required', 'string', Password::defaults(), 'confirmed'],
            ]);
        } catch (ValidationException $e) {
            $this->reset('current_password', 'password', 'password_confirmation');

            throw $e;
        }

        Auth::user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        $this->reset('current_password', 'password', 'password_confirmation');

        $this->dispatch('password-updated');
    }
}; ?>

<section class="amo-card" style="max-width:820px;margin:auto;">
    <div class="amo-card-header">
        <span class="material-symbols-outlined"
              style="color:var(--primary);">
            lock
        </span>
        <div>
            <h3>Cambiar contraseña</h3>
            <p style="
                font-size:13px;
                color:var(--on-surface-variant);
                margin-top:2px;
            ">
                Mantén tu cuenta protegida utilizando una contraseña segura.
            </p>
        </div>
    </div>

    <div class="amo-card-body">
        <form wire:submit="updatePassword">
            <div class="amo-grid-2">
                {{-- Contraseña actual --}}
                <div class="amo-col-span-2">
                    <label
                        for="update_password_current_password"
                        class="amo-label">
                        Contraseña actual
                    </label>
                    <input
                        wire:model="current_password"
                        id="update_password_current_password"
                        name="current_password"
                        type="password"
                        class="amo-input"
                        autocomplete="current-password">

                    @error('current_password')
                        <p class="amo-error-msg">
                            {{ $message }}
                        </p>
                    @enderror
                </div>
                {{-- Nueva contraseña --}}
                <div>
                    <label
                        for="update_password_password"
                        class="amo-label">
                        Nueva contraseña
                    </label>
                    <input
                        wire:model="password"
                        id="update_password_password"
                        name="password"
                        type="password"
                        class="amo-input"
                        autocomplete="new-password">
                    @error('password')
                        <p class="amo-error-msg">
                            {{ $message }}
                        </p>
                    @enderror
                </div>
                {{-- Confirmación --}}
                <div>
                    <label
                        for="update_password_password_confirmation"
                        class="amo-label">
                        Confirmar contraseña
                    </label>
                    <input
                        wire:model="password_confirmation"
                        id="update_password_password_confirmation"
                        name="password_confirmation"
                        type="password"
                        class="amo-input"
                        autocomplete="new-password">
                    @error('password_confirmation')
                        <p class="amo-error-msg">
                            {{ $message }}
                        </p>
                    @enderror
                </div>
            </div>
            {{-- Tips --}}
            <div style="
                margin-top:22px;
                padding:18px;
                border-radius:18px;
                background:rgba(151,49,0,0.04);
                border:1px solid rgba(225,191,180,0.5);
            ">
                <div style="
                    display:flex;
                    gap:14px;
                    align-items:flex-start;
                ">
                    <span class="material-symbols-outlined"
                          style="
                            color:var(--primary);
                            font-size:28px;
                          ">
                        shield_lock
                    </span>
                    <div>
                        <p style="
                            font-weight:600;
                            margin-bottom:6px;
                            color:var(--on-surface);
                        ">
                            Recomendaciones de seguridad
                        </p>
                        <ul style="
                            margin:0;
                            padding-left:18px;
                            color:var(--on-surface-variant);
                            line-height:1.8;
                            font-size:14px;
                        ">
                            <li>Utiliza al menos 8 caracteres.</li>
                            <li>Combina letras, números y símbolos.</li>
                            <li>No reutilices contraseñas anteriores.</li>
                        </ul>
                    </div>
                </div>
            </div>
            {{-- Botón --}}
            <div style="
                display:flex;
                align-items:center;
                gap:14px;
                margin-top:28px;
            ">
                <button
                    type="submit"
                    class="amo-btn-primary">
                    <span class="material-symbols-outlined">
                        encrypted
                    </span>
                    Actualizar contraseña
                </button>
                <x-action-message on="password-updated">
                    <span style="
                        color:#15803d;
                        font-size:14px;
                        font-weight:600;
                    ">
                        Contraseña actualizada correctamente
                    </span>
                </x-action-message>
            </div>
        </form>
    </div>
</section>