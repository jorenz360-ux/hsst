<?php

use Livewire\Volt\Component;

new class extends Component {
    public bool $requestSent = false;

    public function notifyAdmin(): void
    {
        // SIMPLE VERSION:
        // Later you can replace this with database save, notification, or email.

        $this->requestSent = true;

        session()->flash('status', 'Your password reset request has been sent to the admin. Please wait for assistance.');
    }
};
?>

<section class="min-h-screen w-full bg-[#f7f5f1] px-4 py-8 sm:px-6 lg:px-8">
    <div class="mb-7">
        <p class="mb-1 text-[10px] font-semibold uppercase tracking-[.2em] text-[#b88a3d]">Account</p>
        <h1 class="font-serif text-[28px] font-normal leading-tight text-[#091852] sm:text-[32px]">
            Password Help
        </h1>
        <p class="mt-1 text-sm text-[#7a7060]">
            Choose how you would like to reset or recover your password.
        </p>
    </div>

    <div class="grid gap-4 lg:grid-cols-2">
        {{-- Reset via Email --}}
        <div class="overflow-hidden rounded-[20px] border border-[#e8e2d6] bg-white">
            <div class="flex items-center gap-3.5 border-b border-[#f0ebe1] px-5 py-4 sm:px-6">
                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-[12px] bg-[#faf4e6]">
                    <svg class="h-5 w-5 text-[#b88a3d]" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.6">
                        <path d="M3 5h14v10H3z"/>
                        <path d="m4 6 6 5 6-5"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-[15px] font-medium text-[#1a1410]">Reset via Email</h3>
                    <p class="mt-0.5 text-xs text-[#9a9080]">
                        Receive a password reset link in your email.
                    </p>
                </div>
            </div>

            <div class="space-y-4 px-5 py-5 sm:px-6">
                <p class="text-sm leading-6 text-[#7a7060]">
                    Choose this option if you can still access your email and want to reset your password yourself.
                </p>

                <a
                    href="{{ route('password.request') }}"
                    wire:navigate
                    class="inline-flex w-full items-center justify-center gap-2 rounded-[10px] bg-[#d4b06a] px-5 py-3 text-sm font-medium text-[#091852] transition hover:bg-[#c9a458] active:scale-[.98]"
                >
                    <svg class="h-4 w-4" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.6">
                        <path d="M3 5h14v10H3z"/>
                        <path d="m4 6 6 5 6-5"/>
                    </svg>
                    Continue with Email Reset
                </a>
            </div>
        </div>

        {{-- Notify Admin --}}
        <div class="overflow-hidden rounded-[20px] border border-[#e8e2d6] bg-white">
            <div class="flex items-center gap-3.5 border-b border-[#f0ebe1] px-5 py-4 sm:px-6">
                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-[12px] bg-[#faf4e6]">
                    <svg class="h-5 w-5 text-[#b88a3d]" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.6">
                        <circle cx="10" cy="7" r="3"/>
                        <path d="M4 17c0-3.314 2.686-6 6-6s6 2.686 6 6"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-[15px] font-medium text-[#1a1410]">Notify Admin</h3>
                    <p class="mt-0.5 text-xs text-[#9a9080]">
                        Ask the reunion administrator for password assistance.
                    </p>
                </div>
            </div>

            <div class="space-y-4 px-5 py-5 sm:px-6">
                <p class="text-sm leading-6 text-[#7a7060]">
                    Choose this option if you no longer have access to your email or need help resetting your password.
                </p>

                @if (session('status'))
                    <div class="rounded-[14px] border border-emerald-200 bg-emerald-50 p-4">
                        <p class="text-sm text-emerald-700">{{ session('status') }}</p>
                    </div>
                @endif

                <button
                    type="button"
                    wire:click="notifyAdmin"
                    class="inline-flex w-full items-center justify-center gap-2 rounded-[10px] border border-[#d4b06a] bg-[#faf4e6] px-5 py-3 text-sm font-medium text-[#091852] transition hover:bg-[#f5ecd7]"
                >
                    <svg class="h-4 w-4" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.6">
                        <path d="M4 4h12v9H8l-4 3V4z"/>
                    </svg>
                    Notify Admin for Password Reset
                </button>
            </div>
        </div>
    </div>

    <div class="mt-5">
        <a
            href="{{ route('profile.edit') }}"
            wire:navigate
            class="inline-flex items-center gap-2 text-sm font-medium text-[#091852] underline underline-offset-2 hover:no-underline"
        >
            ← Back to Profile
        </a>
    </div>
</section>