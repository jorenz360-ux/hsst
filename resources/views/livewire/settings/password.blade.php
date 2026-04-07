<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;
use Livewire\Volt\Component;

new class extends Component {
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
            'password' => $validated['password'],
        ]);

        $this->reset('current_password', 'password', 'password_confirmation');

        $this->dispatch('password-updated');
    }
}; ?>

<section class="min-h-screen w-full bg-[#f7f5f1] px-4 py-8 sm:px-6 lg:px-8">
    <flux:heading class="sr-only">{{ __('Password Settings') }}</flux:heading>

    <div class="mb-7">
        <p class="mb-1 text-[10px] font-semibold uppercase tracking-[.2em] text-[#b88a3d]">Account</p>
        <h1 class="font-serif text-[28px] font-normal leading-tight text-[#091852] sm:text-[32px]">
            Update Password
        </h1>
        <p class="mt-1 text-sm text-[#7a7060]">
            Keep your reunion account secure by using a strong password that only you know.
        </p>
    </div>

    <div class="overflow-hidden rounded-[20px] border border-[#e8e2d6] bg-white">
        <div class="flex items-center gap-3.5 border-b border-[#f0ebe1] px-5 py-4 sm:px-6">
            <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-[10px] bg-[#faf4e6]">
                <svg class="h-4.5 w-4.5 text-[#b88a3d]" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.6">
                    <path d="M10 6V4a3 3 0 1 0-6 0v2"/>
                    <rect x="3" y="6" width="14" height="11" rx="2"/>
                </svg>
            </div>
            <div>
                <h3 class="text-[15px] font-medium text-[#1a1410]">Password & Security</h3>
                <p class="mt-0.5 text-xs text-[#9a9080]">
                    Update your password to keep your account protected
                </p>
            </div>
        </div>

        <form method="POST" wire:submit="updatePassword" class="space-y-5 px-5 py-5 sm:px-6">
            <div class="grid gap-5">
                <div>
                    <label class="mb-1.5 block text-[11px] font-semibold uppercase tracking-[.06em] text-[#9a9080]">
                        Current Password
                    </label>
                    <input
                        wire:model="current_password"
                        type="password"
                        required
                        autocomplete="current-password"
                        class="w-full rounded-[10px] border border-[#e0dbd0] bg-[#faf9f7] px-3.5 py-2.5 text-sm text-[#1a1410] outline-none transition focus:border-[#d4b06a] focus:bg-white focus:ring-0"
                    />
                    @error('current_password')
                        <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="mb-1.5 block text-[11px] font-semibold uppercase tracking-[.06em] text-[#9a9080]">
                        New Password
                    </label>
                    <input
                        wire:model="password"
                        type="password"
                        required
                        autocomplete="new-password"
                        class="w-full rounded-[10px] border border-[#e0dbd0] bg-[#faf9f7] px-3.5 py-2.5 text-sm text-[#1a1410] outline-none transition focus:border-[#d4b06a] focus:bg-white focus:ring-0"
                    />
                    @error('password')
                        <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="mb-1.5 block text-[11px] font-semibold uppercase tracking-[.06em] text-[#9a9080]">
                        Confirm New Password
                    </label>
                    <input
                        wire:model="password_confirmation"
                        type="password"
                        required
                        autocomplete="new-password"
                        class="w-full rounded-[10px] border border-[#e0dbd0] bg-[#faf9f7] px-3.5 py-2.5 text-sm text-[#1a1410] outline-none transition focus:border-[#d4b06a] focus:bg-white focus:ring-0"
                    />
                </div>
            </div>

            <div class="rounded-[14px] border border-[#f0d496] bg-[#faf4e6] p-4">
                <p class="text-[13px] font-medium text-[#7a5c1e]">Helpful reminder</p>
                <p class="mt-2 text-xs leading-5 text-[#92601c]">
                    Choose a password that is easy for you to remember but difficult for others to guess.
                </p>
            </div>

            <div class="flex flex-col gap-3 border-t border-[#f0ebe1] pt-4 sm:flex-row sm:items-center sm:justify-between">
                <x-action-message class="text-sm font-medium text-emerald-600" on="password-updated">
                    {{ __('Password updated successfully.') }}
                </x-action-message>

                <button
                    type="submit"
                    data-test="update-password-button"
                    class="inline-flex items-center justify-center gap-2 rounded-[10px] bg-[#d4b06a] px-5 py-2.5 text-sm font-medium text-[#091852] transition hover:bg-[#c9a458] active:scale-[.98]"
                >
                    <svg class="h-4 w-4" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.6">
                        <path d="M4 13V16h3l9-9-3-3-9 9zM14.5 4.5l1 1"/>
                    </svg>
                    {{ __('Save Password') }}
                </button>
            </div>
        </form>
    </div>
</section>
