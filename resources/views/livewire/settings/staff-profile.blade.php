<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Livewire\Volt\Component;

new class extends Component {

    public string $fname        = '';
    public string $mname        = '';
    public string $lname        = '';
    public string $position     = '';
    public string $years_working = '';
    public string $contact_no   = '';
    public string $email        = '';
    public string $username     = '';

    public string $address_line_1 = '';
    public string $address_line_2 = '';
    public string $city           = '';
    public string $state_province = '';
    public string $postal_code    = '';
    public string $country        = '';

    public function mount(): void
    {
        $user  = Auth::user();
        $staff = $user?->staff;

        if (! $staff) {
            $this->redirect(route('profile.edit'), navigate: true);
            return;
        }

        $this->email    = (string) ($user->email ?? '');
        $this->username = (string) ($user->username ?? '');

        $this->fname         = (string) ($staff->fname ?? '');
        $this->mname         = (string) ($staff->mname ?? '');
        $this->lname         = (string) ($staff->lname ?? '');
        $this->position      = (string) ($staff->position ?? '');
        $this->years_working = (string) ($staff->years_working ?? '');
        $this->contact_no    = (string) ($staff->contact_no ?? '');

        $this->address_line_1 = (string) ($staff->address_line_1 ?? '');
        $this->address_line_2 = (string) ($staff->address_line_2 ?? '');
        $this->city           = (string) ($staff->city ?? '');
        $this->state_province = (string) ($staff->state_province ?? '');
        $this->postal_code    = (string) ($staff->postal_code ?? '');
        $this->country        = (string) ($staff->country ?? 'Philippines');
    }

    public function updateProfile(): void
    {
        $user = Auth::user();

        $validated = $this->validate([
            'fname'        => ['required', 'string', 'max:80'],
            'mname'        => ['nullable', 'string', 'max:80'],
            'lname'        => ['required', 'string', 'max:80'],
            'position'     => ['required', 'string', 'max:100'],
            'years_working'=> ['required', 'integer', 'min:1', 'max:99'],
            'contact_no'   => ['required', (new \Propaganistas\LaravelPhone\Rules\Phone)->country('PH')->international()],
            'email'        => ['required', 'email', 'max:255', Rule::unique(User::class, 'email')->ignore($user->id)],
            'username'     => ['required', 'string', 'max:50', 'alpha_dash', Rule::unique(User::class, 'username')->ignore($user->id)],
            'address_line_1' => ['required', 'string', 'max:255'],
            'address_line_2' => ['nullable', 'string', 'max:255'],
            'city'           => ['required', 'string', 'max:100'],
            'state_province' => ['required', 'string', 'max:100'],
            'postal_code'    => ['nullable', 'string', 'max:20'],
            'country'        => ['required', 'string', 'max:100'],
        ]);

        $user->staff()->update([
            'fname'          => trim($validated['fname']),
            'mname'          => filled($validated['mname'] ?? null) ? trim($validated['mname']) : null,
            'lname'          => trim($validated['lname']),
            'position'       => trim($validated['position']),
            'years_working'  => (int) $validated['years_working'],
            'contact_no'     => filled($validated['contact_no'] ?? null) ? trim($validated['contact_no']) : null,
            'address_line_1' => trim($validated['address_line_1']),
            'address_line_2' => filled($validated['address_line_2'] ?? null) ? trim($validated['address_line_2']) : null,
            'city'           => trim($validated['city']),
            'state_province' => trim($validated['state_province']),
            'postal_code'    => filled($validated['postal_code'] ?? null) ? trim($validated['postal_code']) : null,
            'country'        => trim($validated['country']),
        ]);

        $userChanges = [];

        if ($validated['email'] !== $user->email) {
            $userChanges['email']             = trim($validated['email']);
            $userChanges['email_verified_at'] = null;
        }

        if ($validated['username'] !== $user->username) {
            $userChanges['username'] = trim($validated['username']);
        }

        if ($userChanges) {
            $user->forceFill($userChanges)->save();
        }

        $this->dispatch('profile-updated');
    }

    public function resendVerificationNotification(): void
    {
        $user = Auth::user();

        if ($user->hasVerifiedEmail()) {
            $this->redirectIntended(default: route('dashboard', absolute: false));
            return;
        }

        $user->sendEmailVerificationNotification();
        Session::flash('status', 'verification-link-sent');
    }
};
?>

<section class="min-h-screen w-full px-4 py-8 sm:px-6 lg:px-8">

    <div class="mb-7">
        <p class="mb-1 text-[10px] font-semibold uppercase tracking-[.2em] text-[#b88a3d]">Account</p>
        <h1 class="font-serif text-[28px] font-normal leading-tight text-[#091852] sm:text-[32px]">Profile Settings</h1>
        <p class="mt-1 text-sm text-[#7a7060]">Manage your personal details and work information.</p>
    </div>

    <form wire:submit="updateProfile" class="w-full max-w-4xl space-y-5">

        {{-- Personal & Work --}}
        <div class="overflow-hidden rounded-[20px] border border-[#e8e2d6] bg-white">
            <div class="flex items-center gap-3.5 border-b border-[#f0ebe1] px-5 py-4 sm:px-6">
                <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-[10px] bg-[#faf4e6]">
                    <svg class="h-4.5 w-4.5 text-[#b88a3d]" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.6">
                        <circle cx="10" cy="7" r="3"/><path d="M4 17c0-3.314 2.686-6 6-6s6 2.686 6 6"/>
                    </svg>
                </div>
                <div class="flex-1">
                    <h3 class="text-[15px] font-medium text-[#1a1410]">Personal & Work Information</h3>
                    <p class="mt-0.5 text-xs text-[#9a9080]">Your name, position, and contact details</p>
                </div>
                <button type="submit"
                    class="inline-flex items-center gap-1.5 rounded-[9px] bg-[#d4b06a] px-3.5 py-2 text-xs font-medium text-[#091852] transition hover:bg-[#c9a458] active:scale-[.97]">
                    <svg class="h-3.5 w-3.5" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.8">
                        <path d="M4 13V16h3l9-9-3-3-9 9zM14.5 4.5l1 1"/>
                    </svg>
                    Save
                </button>
            </div>

            <div class="space-y-4 px-5 py-5 sm:px-6">
                {{-- Name row --}}
                <div class="grid gap-4 sm:grid-cols-3">
                    <div>
                        <label class="mb-1.5 block text-[11px] font-semibold uppercase tracking-[.06em] text-[#9a9080]">First Name</label>
                        <input wire:model="fname" type="text" required
                            class="w-full rounded-[10px] border border-[#e0dbd0] bg-[#faf9f7] px-3.5 py-2.5 text-sm text-[#1a1410] outline-none transition focus:border-[#d4b06a] focus:bg-white focus:ring-0" />
                        @error('fname') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="mb-1.5 block text-[11px] font-semibold uppercase tracking-[.06em] text-[#9a9080]">
                            Middle Name <span class="normal-case tracking-normal text-[#b0ab9e]">(optional)</span>
                        </label>
                        <input wire:model="mname" type="text"
                            class="w-full rounded-[10px] border border-[#e0dbd0] bg-[#faf9f7] px-3.5 py-2.5 text-sm text-[#1a1410] outline-none transition focus:border-[#d4b06a] focus:bg-white focus:ring-0" />
                        @error('mname') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="mb-1.5 block text-[11px] font-semibold uppercase tracking-[.06em] text-[#9a9080]">Last Name</label>
                        <input wire:model="lname" type="text" required
                            class="w-full rounded-[10px] border border-[#e0dbd0] bg-[#faf9f7] px-3.5 py-2.5 text-sm text-[#1a1410] outline-none transition focus:border-[#d4b06a] focus:bg-white focus:ring-0" />
                        @error('lname') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                    </div>
                </div>

                {{-- Work row --}}
                <div class="grid gap-4 sm:grid-cols-3">
                    <div class="sm:col-span-2">
                        <label class="mb-1.5 block text-[11px] font-semibold uppercase tracking-[.06em] text-[#9a9080]">Position</label>
                        <input wire:model="position" type="text" required placeholder="e.g. Faculty, Admin Staff"
                            class="w-full rounded-[10px] border border-[#e0dbd0] bg-[#faf9f7] px-3.5 py-2.5 text-sm text-[#1a1410] outline-none transition placeholder:text-[#c0bbb0] focus:border-[#d4b06a] focus:bg-white focus:ring-0" />
                        @error('position') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="mb-1.5 block text-[11px] font-semibold uppercase tracking-[.06em] text-[#9a9080]">Years at HSST</label>
                        <input wire:model="years_working" type="number" min="1" max="99" required
                            class="w-full rounded-[10px] border border-[#e0dbd0] bg-[#faf9f7] px-3.5 py-2.5 text-sm text-[#1a1410] outline-none transition focus:border-[#d4b06a] focus:bg-white focus:ring-0" />
                        @error('years_working') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                    </div>
                </div>

                {{-- Contact, Email & Username --}}
                <div class="grid gap-4 sm:grid-cols-3">
                    <div>
                        <label class="mb-1.5 block text-[11px] font-semibold uppercase tracking-[.06em] text-[#9a9080]">Contact No.</label>
                        <div x-data="phonePicker('{{ $contact_no }}')" class="relative" @click.outside="open = false">
                            <div class="flex overflow-hidden rounded-[10px] border border-[#e0dbd0] bg-[#faf9f7] transition focus-within:border-[#d4b06a] focus-within:bg-white">
                                <button type="button" @click="open = !open"
                                    class="flex shrink-0 items-center gap-1 border-r border-[#e0dbd0] px-2.5 py-2.5 transition hover:bg-[#f5f3ef]">
                                    <span x-text="selected.flag" class="text-base leading-none"></span>
                                    <span x-text="selected.dial" class="text-xs text-[#7a7060]"></span>
                                    <svg class="h-3 w-3 text-[#9a9080] transition-transform" :class="open && 'rotate-180'" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 111.06 1.06l-4.24 4.25a.75.75 0 01-1.06 0L5.21 8.29a.75.75 0 01.02-1.06z" clip-rule="evenodd"/>
                                    </svg>
                                </button>
                                <input x-model="localNumber" type="tel" required placeholder="Enter phone number"
                                    class="w-full bg-transparent px-3 py-2.5 text-sm text-[#1a1410] outline-none placeholder:text-[#c0bbb0]" />
                            </div>
                            <div x-show="open" x-transition
                                class="absolute z-50 mt-1 w-72 overflow-hidden rounded-[12px] border border-[#e0dbd0] bg-white shadow-lg shadow-black/5">
                                <div class="border-b border-[#f0ebe1] p-2">
                                    <input x-model="search" type="text" placeholder="Search country..."
                                        class="w-full rounded-[8px] border border-[#e0dbd0] bg-[#faf9f7] px-3 py-2 text-sm outline-none focus:border-[#d4b06a]" />
                                </div>
                                <ul class="max-h-52 overflow-y-auto py-1">
                                    <template x-for="c in filtered" :key="c.code">
                                        <li>
                                            <button type="button" @click="select(c)"
                                                class="flex w-full items-center gap-3 px-3 py-2 text-left text-sm transition hover:bg-[#faf4e6]"
                                                :class="selected.code === c.code && 'bg-[#faf4e6] font-medium'">
                                                <span x-text="c.flag" class="text-base leading-none"></span>
                                                <span x-text="c.name" class="flex-1 text-[#1a1410]"></span>
                                                <span x-text="c.dial" class="text-xs text-[#9a9080]"></span>
                                            </button>
                                        </li>
                                    </template>
                                    <template x-if="filtered.length === 0">
                                        <li class="px-3 py-4 text-center text-sm text-[#9a9080]">No country found</li>
                                    </template>
                                </ul>
                            </div>
                        </div>
                        @error('contact_no') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="mb-1.5 block text-[11px] font-semibold uppercase tracking-[.06em] text-[#9a9080]">Email Address</label>
                        <input wire:model="email" type="email" required autocomplete="email"
                            class="w-full rounded-[10px] border border-[#e0dbd0] bg-[#faf9f7] px-3.5 py-2.5 text-sm text-[#1a1410] outline-none transition focus:border-[#d4b06a] focus:bg-white focus:ring-0" />
                        @error('email') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="mb-1.5 block text-[11px] font-semibold uppercase tracking-[.06em] text-[#9a9080]">Username</label>
                        <input wire:model="username" type="text" required autocomplete="username"
                            class="w-full rounded-[10px] border border-[#e0dbd0] bg-[#faf9f7] px-3.5 py-2.5 text-sm text-[#1a1410] outline-none transition focus:border-[#d4b06a] focus:bg-white focus:ring-0" />
                        @error('username') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                    </div>
                </div>

                @if (auth()->user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! auth()->user()->hasVerifiedEmail())
                    <div class="rounded-xl border border-amber-200 bg-amber-50 p-4">
                        <p class="text-sm text-amber-800">
                            {{ __('Your email address is unverified.') }}
                            <button type="button" wire:click.prevent="resendVerificationNotification" class="ml-1 font-medium underline underline-offset-2 hover:no-underline">
                                {{ __('Re-send verification email.') }}
                            </button>
                        </p>
                        @if (session('status') === 'verification-link-sent')
                            <p class="mt-2 text-sm font-medium text-green-700">
                                {{ __('A new verification link has been sent to your email address.') }}
                            </p>
                        @endif
                    </div>
                @endif
            </div>
        </div>

        {{-- Address --}}
        <div class="overflow-hidden rounded-[20px] border border-[#e8e2d6] bg-white">
            <div class="flex items-center gap-3.5 border-b border-[#f0ebe1] px-5 py-4 sm:px-6">
                <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-[10px] bg-[#faf4e6]">
                    <svg class="h-4.5 w-4.5 text-[#b88a3d]" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.6">
                        <path d="M10 2C7.239 2 5 4.239 5 7c0 4.418 5 11 5 11s5-6.582 5-11c0-2.761-2.239-5-5-5z"/><circle cx="10" cy="7" r="1.5"/>
                    </svg>
                </div>
                <div class="flex-1">
                    <h3 class="text-[15px] font-medium text-[#1a1410]">Address</h3>
                    <p class="mt-0.5 text-xs text-[#9a9080]">Keep your address updated for records</p>
                </div>
                <button type="submit"
                    class="inline-flex items-center gap-1.5 rounded-[9px] bg-[#d4b06a] px-3.5 py-2 text-xs font-medium text-[#091852] transition hover:bg-[#c9a458] active:scale-[.97]">
                    <svg class="h-3.5 w-3.5" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.8">
                        <path d="M4 13V16h3l9-9-3-3-9 9zM14.5 4.5l1 1"/>
                    </svg>
                    Save
                </button>
            </div>

            <div class="space-y-4 px-5 py-5 sm:px-6">
                <div>
                    <label class="mb-1.5 block text-[11px] font-semibold uppercase tracking-[.06em] text-[#9a9080]">Street Address</label>
                    <input wire:model="address_line_1" type="text" required placeholder="e.g. 123 Rizal St."
                        class="w-full rounded-[10px] border border-[#e0dbd0] bg-[#faf9f7] px-3.5 py-2.5 text-sm text-[#1a1410] outline-none transition placeholder:text-[#c0bbb0] focus:border-[#d4b06a] focus:bg-white focus:ring-0" />
                    @error('address_line_1') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="mb-1.5 block text-[11px] font-semibold uppercase tracking-[.06em] text-[#9a9080]">
                        Address Line 2 <span class="normal-case tracking-normal text-[#b0ab9e]">(optional)</span>
                    </label>
                    <input wire:model="address_line_2" type="text" placeholder="Barangay, unit, floor, etc."
                        class="w-full rounded-[10px] border border-[#e0dbd0] bg-[#faf9f7] px-3.5 py-2.5 text-sm text-[#1a1410] outline-none transition placeholder:text-[#c0bbb0] focus:border-[#d4b06a] focus:bg-white focus:ring-0" />
                    @error('address_line_2') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                </div>

                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <label class="mb-1.5 block text-[11px] font-semibold uppercase tracking-[.06em] text-[#9a9080]">City / Municipality</label>
                        <input wire:model="city" type="text" required
                            class="w-full rounded-[10px] border border-[#e0dbd0] bg-[#faf9f7] px-3.5 py-2.5 text-sm text-[#1a1410] outline-none transition focus:border-[#d4b06a] focus:bg-white focus:ring-0" />
                        @error('city') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="mb-1.5 block text-[11px] font-semibold uppercase tracking-[.06em] text-[#9a9080]">Province / State</label>
                        <input wire:model="state_province" type="text" required
                            class="w-full rounded-[10px] border border-[#e0dbd0] bg-[#faf9f7] px-3.5 py-2.5 text-sm text-[#1a1410] outline-none transition focus:border-[#d4b06a] focus:bg-white focus:ring-0" />
                        @error('state_province') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <label class="mb-1.5 block text-[11px] font-semibold uppercase tracking-[.06em] text-[#9a9080]">
                            Postal / ZIP Code <span class="normal-case tracking-normal text-[#b0ab9e]">(optional)</span>
                        </label>
                        <input wire:model="postal_code" type="text"
                            class="w-full rounded-[10px] border border-[#e0dbd0] bg-[#faf9f7] px-3.5 py-2.5 text-sm text-[#1a1410] outline-none transition focus:border-[#d4b06a] focus:bg-white focus:ring-0" />
                        @error('postal_code') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="mb-1.5 block text-[11px] font-semibold uppercase tracking-[.06em] text-[#9a9080]">Country</label>
                        <input wire:model="country" type="text" required
                            class="w-full rounded-[10px] border border-[#e0dbd0] bg-[#faf9f7] px-3.5 py-2.5 text-sm text-[#1a1410] outline-none transition focus:border-[#d4b06a] focus:bg-white focus:ring-0" />
                        @error('country') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>
        </div>

        {{-- Bottom: Security + Save --}}
        <div class="grid gap-4 lg:grid-cols-[1.35fr_0.85fr]">
            <div class="overflow-hidden rounded-[20px] border border-[#e8e2d6] bg-white">
                <div class="border-b border-[#f0ebe1] px-5 py-4 sm:px-6">
                    <p class="text-[11px] font-semibold uppercase tracking-[.18em] text-[#b88a3d]">Account & Security</p>
                    <h3 class="mt-1 text-[17px] font-medium text-[#1a1410]">Keep your account updated</h3>
                </div>
                <div class="flex flex-col gap-4 px-5 py-5 sm:px-6">
                    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                        <p class="text-xs leading-5 text-[#9a9080]">Change your password anytime to keep your account secure.</p>
                        <div class="flex shrink-0 gap-2">
                            <a href="{{ route('password-help.edit') }}" wire:navigate
                                class="inline-flex items-center justify-center gap-2 rounded-[10px] border border-[#e0dbd0] bg-[#faf9f7] px-4 py-2.5 text-sm font-medium text-[#7a7060] transition hover:bg-[#f5f3ef]">
                                Password Help
                            </a>
                            <a href="{{ route('user-password.edit') }}" wire:navigate
                                class="inline-flex items-center justify-center gap-2 rounded-[10px] border border-[#d4b06a] bg-[#faf4e6] px-4 py-2.5 text-sm font-medium text-[#091852] transition hover:bg-[#f5ecd7]">
                                <svg class="h-4 w-4" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.6">
                                    <path d="M4 13V16h3l9-9-3-3-9 9zM14.5 4.5l1 1"/>
                                </svg>
                                Change Password
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="overflow-hidden rounded-[20px] border border-[#e8e2d6] bg-white">
                <div class="border-b border-[#f0ebe1] px-5 py-4 sm:px-6">
                    <p class="text-[11px] font-semibold uppercase tracking-[.18em] text-[#b88a3d]">Save Updates</p>
                    <h3 class="mt-1 text-[17px] font-medium text-[#1a1410]">Apply your changes</h3>
                </div>
                <div class="flex flex-col gap-5 px-5 py-5 sm:px-6">
                    <div class="rounded-[16px] border border-dashed border-[#ddd6c8] bg-[#faf9f7] px-4 py-4">
                        <x-action-message class="text-sm font-medium text-emerald-600" on="profile-updated">
                            {{ __('Changes saved successfully.') }}
                        </x-action-message>
                        <p class="text-xs leading-5 text-[#9a9080]">Make sure all information is correct before saving.</p>
                    </div>
                    <button type="submit"
                        class="inline-flex w-full items-center justify-center gap-2 rounded-[12px] bg-[#d4b06a] px-5 py-3 text-sm font-medium text-[#091852] transition hover:bg-[#c9a458] active:scale-[.98]">
                        <svg class="h-4 w-4" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.6">
                            <path d="M4 13V16h3l9-9-3-3-9 9zM14.5 4.5l1 1"/>
                        </svg>
                        {{ __('Save Changes') }}
                    </button>
                </div>
            </div>
        </div>

    </form>
</section>

@script
<script>
    Alpine.data('phonePicker', (initial) => ({
        open: false,
        search: '',
        localNumber: '',
        selected: null,
        countries: [
            { code: 'PH', name: 'Philippines',   dial: '+63',  flag: '🇵🇭' },
            { code: 'US', name: 'United States',  dial: '+1',   flag: '🇺🇸' },
            { code: 'CA', name: 'Canada',         dial: '+1',   flag: '🇨🇦' },
            { code: 'AU', name: 'Australia',      dial: '+61',  flag: '🇦🇺' },
            { code: 'GB', name: 'United Kingdom', dial: '+44',  flag: '🇬🇧' },
            { code: 'NZ', name: 'New Zealand',    dial: '+64',  flag: '🇳🇿' },
            { code: 'IE', name: 'Ireland',        dial: '+353', flag: '🇮🇪' },
            { code: 'SG', name: 'Singapore',      dial: '+65',  flag: '🇸🇬' },
            { code: 'HK', name: 'Hong Kong',      dial: '+852', flag: '🇭🇰' },
            { code: 'MY', name: 'Malaysia',       dial: '+60',  flag: '🇲🇾' },
            { code: 'JP', name: 'Japan',          dial: '+81',  flag: '🇯🇵' },
            { code: 'KR', name: 'South Korea',    dial: '+82',  flag: '🇰🇷' },
            { code: 'TW', name: 'Taiwan',         dial: '+886', flag: '🇹🇼' },
            { code: 'AE', name: 'UAE',            dial: '+971', flag: '🇦🇪' },
            { code: 'SA', name: 'Saudi Arabia',   dial: '+966', flag: '🇸🇦' },
            { code: 'QA', name: 'Qatar',          dial: '+974', flag: '🇶🇦' },
            { code: 'KW', name: 'Kuwait',         dial: '+965', flag: '🇰🇼' },
            { code: 'BH', name: 'Bahrain',        dial: '+973', flag: '🇧🇭' },
            { code: 'OM', name: 'Oman',           dial: '+968', flag: '🇴🇲' },
            { code: 'DE', name: 'Germany',        dial: '+49',  flag: '🇩🇪' },
            { code: 'FR', name: 'France',         dial: '+33',  flag: '🇫🇷' },
            { code: 'IT', name: 'Italy',          dial: '+39',  flag: '🇮🇹' },
            { code: 'ES', name: 'Spain',          dial: '+34',  flag: '🇪🇸' },
            { code: 'NL', name: 'Netherlands',    dial: '+31',  flag: '🇳🇱' },
            { code: 'CH', name: 'Switzerland',    dial: '+41',  flag: '🇨🇭' },
            { code: 'SE', name: 'Sweden',         dial: '+46',  flag: '🇸🇪' },
            { code: 'NO', name: 'Norway',         dial: '+47',  flag: '🇳🇴' },
            { code: 'DK', name: 'Denmark',        dial: '+45',  flag: '🇩🇰' },
        ],
        init() {
            this.selected = this.countries[0];

            if (initial && initial.startsWith('+')) {
                // Sort longest dial code first to avoid +1 matching +1868, etc.
                let sorted = [...this.countries].sort((a, b) => b.dial.length - a.dial.length);
                for (let c of sorted) {
                    if (initial.startsWith(c.dial)) {
                        this.selected = c;
                        this.localNumber = initial.slice(c.dial.length);
                        break;
                    }
                }
            } else if (initial) {
                this.localNumber = initial;
            }

            this.$watch('localNumber', () => this.sync());
        },
        get filtered() {
            if (!this.search) return this.countries;
            let q = this.search.toLowerCase();
            return this.countries.filter(c =>
                c.name.toLowerCase().includes(q) || c.dial.includes(this.search)
            );
        },
        select(c) {
            this.selected = c;
            this.open = false;
            this.search = '';
            this.sync();
        },
        sync() {
            let num = this.localNumber.trim();
            if (!num) { $wire.set('contact_no', ''); return; }
            if (num.startsWith('0')) num = num.slice(1);
            $wire.set('contact_no', this.selected.dial + num);
        },
    }));
</script>
@endscript
