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

        $this->email = (string) ($user->email ?? '');

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
            'contact_no'   => ['nullable', 'string', 'max:30'],
            'email'        => ['required', 'email', 'max:255', Rule::unique(User::class, 'email')->ignore($user->id)],
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

        if ($validated['email'] !== $user->email) {
            $user->forceFill([
                'email'             => trim($validated['email']),
                'email_verified_at' => null,
            ])->save();
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

                {{-- Contact & Email --}}
                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <label class="mb-1.5 block text-[11px] font-semibold uppercase tracking-[.06em] text-[#9a9080]">
                            Contact No. <span class="normal-case tracking-normal text-[#b0ab9e]">(optional)</span>
                        </label>
                        <input wire:model="contact_no" type="text" placeholder="e.g. 09171234567"
                            class="w-full rounded-[10px] border border-[#e0dbd0] bg-[#faf9f7] px-3.5 py-2.5 text-sm text-[#1a1410] outline-none transition placeholder:text-[#c0bbb0] focus:border-[#d4b06a] focus:bg-white focus:ring-0" />
                        @error('contact_no') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="mb-1.5 block text-[11px] font-semibold uppercase tracking-[.06em] text-[#9a9080]">Email Address</label>
                        <input wire:model="email" type="email" required autocomplete="email"
                            class="w-full rounded-[10px] border border-[#e0dbd0] bg-[#faf9f7] px-3.5 py-2.5 text-sm text-[#1a1410] outline-none transition focus:border-[#d4b06a] focus:bg-white focus:ring-0" />
                        @error('email') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
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
