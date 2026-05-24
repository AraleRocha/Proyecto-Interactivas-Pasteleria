<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Livewire\Volt\Component;

new class extends Component
{
    public string $name = '';
    public string $email = '';

    /**
     * Mount the component.
     */
    public function mount(): void
    {
        $this->name = Auth::user()->name;
        $this->email = Auth::user()->email;
    }

    /**
     * Update the profile information for the currently authenticated user.
     */
    public function updateProfileInformation(): void
    {
        $user = Auth::user();

        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($user->id)],
        ]);

        $user->fill($validated);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        $this->dispatch('profile-updated', name: $user->name);
    }

    /**
     * Send an email verification notification to the current user.
     */
    public function sendVerification(): void
    {
        $user = Auth::user();

        if ($user->hasVerifiedEmail()) {
            $this->redirectIntended(default: route('dashboard', absolute: false));

            return;
        }

        $user->sendEmailVerificationNotification();

        Session::flash('status', 'verification-link-sent');
    }
}; ?>

<section class="amo-card" style="max-width:820px;margin:auto;">

    <div class="amo-card-header">
        <span class="material-symbols-outlined" style="color:var(--primary);">
            account_circle
        </span>

        <div>
            <h3>Mi perfil</h3>

            <p style="font-size:13px;color:var(--on-surface-variant);margin-top:2px;">
                Actualiza tu información personal y correo electrónico.
            </p>
        </div>
    </div>

    <div class="amo-card-body">

        <form wire:submit="updateProfileInformation">

            <div class="amo-grid-2">

                {{-- Nombre --}}
                <div>
                    <label for="name" class="amo-label">
                        Nombre completo
                    </label>

                    <input
                        wire:model="name"
                        id="name"
                        name="name"
                        type="text"
                        class="amo-input"
                        required
                        autofocus
                        autocomplete="name">

                    @error('name')
                        <p class="amo-error-msg">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Email --}}
                <div>
                    <label for="email" class="amo-label">
                        Correo electrónico
                    </label>

                    <input
                        wire:model="email"
                        id="email"
                        name="email"
                        type="email"
                        class="amo-input"
                        required
                        autocomplete="username">

                    @error('email')
                        <p class="amo-error-msg">{{ $message }}</p>
                    @enderror
                </div>

            </div>

            {{-- Verificación --}}
            @if (
                auth()->user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail
                && ! auth()->user()->hasVerifiedEmail()
            )

                <div style="
                    margin-top:22px;
                    padding:18px;
                    border-radius:18px;
                    background:rgba(254,203,198,0.25);
                    border:1px solid rgba(225,191,180,0.6);
                ">

                    <div style="display:flex;gap:14px;align-items:flex-start;">

                        <span class="material-symbols-outlined"
                              style="color:var(--primary);font-size:28px;">
                            mark_email_unread
                        </span>

                        <div>

                            <p style="
                                font-weight:600;
                                margin-bottom:6px;
                                color:var(--on-surface);
                            ">
                                Tu correo electrónico no ha sido verificado
                            </p>

                            <p style="
                                font-size:14px;
                                line-height:1.6;
                                color:var(--on-surface-variant);
                            ">
                                Verifica tu correo para acceder a todas las funciones de tu cuenta.
                            </p>

                            <button
                                wire:click.prevent="sendVerification"
                                type="button"
                                class="amo-btn-ghost"
                                style="
                                    margin-top:14px;
                                    width:auto;
                                    display:inline-flex;
                                    align-items:center;
                                    gap:8px;
                                ">

                                <span class="material-symbols-outlined">
                                    outgoing_mail
                                </span>

                                Reenviar verificación
                            </button>

                            @if (session('status') === 'verification-link-sent')

                                <p style="
                                    margin-top:12px;
                                    color:#15803d;
                                    font-size:13px;
                                    font-weight:600;
                                ">
                                    Se envió un nuevo enlace de verificación.
                                </p>

                            @endif

                        </div>

                    </div>

                </div>

            @endif

            {{-- Botón --}}
            <div style="
                display:flex;
                align-items:center;
                gap:14px;
                margin-top:28px;
            ">

                <button type="submit" class="amo-btn-primary">

                    <span class="material-symbols-outlined">
                        save
                    </span>

                    Guardar cambios
                </button>

                <x-action-message on="profile-updated">

                    <span style="
                        color:#15803d;
                        font-size:14px;
                        font-weight:600;
                    ">
                        Perfil actualizado correctamente
                    </span>

                </x-action-message>

            </div>

        </form>

    </div>
</section>
