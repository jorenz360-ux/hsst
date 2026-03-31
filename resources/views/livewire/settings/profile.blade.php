<?php

use App\Models\Alumni;
use App\Models\Batch;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Livewire\Volt\Component;



new class extends Component {
    public string $activeTab = 'profile';

    public string $username = '';
    public string $email = '';

    public string $first_name = '';
    public string $middle_name = '';
    public string $last_name = '';

    public string $occupation = '';

    public string $schoolyear = '';
    public string $yeargrad = '';
    public array $yeargradOptions = [];

    public string $address_line_1 = '';
    public string $address_line_2 = '';
    public string $city = '';
    public string $state_province = '';
    public string $postal_code = '';
    public string $country = '';

    public bool $wants_committee_member = false;
    public bool $is_priest_concelebrate = false;
    public bool $is_medical_practitioner = false;
    public string $medical_specialty = '';

    public bool $hasSavedInvolvement = false;

    public function mount(): void
    {
        $user = Auth::user()?->loadMissing([
            'alumni.batch',
            'alumni.involvement',
        ]);

        $this->username = (string) ($user->username ?? '');
        $this->email    = (string) ($user->email ?? '');

        $currentYear          = (int) now()->year;
        $startYear            = $currentYear - 126;
        $this->yeargradOptions = array_reverse(range($startYear, $currentYear));

        $alumni = $user?->alumni;

        if (! $alumni) {
            $this->country = 'Philippines';
            return;
        }

        $this->first_name  = (string) ($alumni->fname ?? '');
        $this->middle_name = (string) ($alumni->mname ?? '');
        $this->last_name   = (string) ($alumni->lname ?? '');

        $this->occupation = (string) ($alumni->occupation ?? '');

        $this->yeargrad   = (string) ($alumni->batch?->yeargrad ?? '');
        $this->schoolyear = $this->yeargrad !== ''
            ? ((int) $this->yeargrad - 1) . '-' . (int) $this->yeargrad
            : '';

        $this->address_line_1  = (string) ($alumni->address_line_1 ?? '');
        $this->address_line_2  = (string) ($alumni->address_line_2 ?? '');
        $this->city            = (string) ($alumni->city ?? '');
        $this->state_province  = (string) ($alumni->state_province ?? '');
        $this->postal_code     = (string) ($alumni->postal_code ?? '');
        $this->country         = (string) ($alumni->country ?? 'Philippines');

        $involvement = $alumni->involvement;

        $this->wants_committee_member  = (bool) ($involvement?->wants_committee_member ?? false);
        $this->is_priest_concelebrate  = (bool) ($involvement?->is_priest_concelebrate ?? false);
        $this->is_medical_practitioner = (bool) ($involvement?->is_medical_practitioner ?? false);
        $this->medical_specialty       = (string) ($involvement?->medical_specialty ?? '');

        $this->hasSavedInvolvement =
            $this->wants_committee_member ||
            $this->is_priest_concelebrate ||
            $this->is_medical_practitioner;
    }

    public function updatedYeargrad($value): void
    {
        if (blank($value)) {
            $this->schoolyear = '';
            return;
        }

        $year             = (int) $value;
        $this->schoolyear = ($year - 1) . '-' . $year;
    }

    public function updatedIsMedicalPractitioner($value): void
    {
        if (! $value) {
            $this->medical_specialty = '';
        }
    }

    protected function rules(): array
    {
        $user = Auth::user();

        return [
            'first_name'  => ['required', 'string', 'max:255'],
            'middle_name' => ['nullable', 'string', 'max:255'],
            'last_name'   => ['required', 'string', 'max:255'],
            'occupation' => ['nullable' , 'string', 'max:255'],

            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class, 'email')->ignore($user->id),
            ],

            'yeargrad' => ['required', 'integer', 'min:1900', 'max:' . now()->year],

            'address_line_1' => ['required', 'string', 'max:255'],
            'address_line_2' => ['nullable', 'string', 'max:255'],
            'city'           => ['required', 'string', 'max:120'],
            'state_province' => ['required', 'string', 'max:120'],
            'postal_code'    => ['nullable', 'string', 'max:30'],
            'country'        => ['required', 'string', 'max:100'],

            //  nullable so unchecked (false) values are not stripped
            'wants_committee_member'  => ['nullable', 'boolean'],
            'is_priest_concelebrate'  => ['nullable', 'boolean'],
            'is_medical_practitioner' => ['nullable', 'boolean'],

            'medical_specialty' => [
                'nullable',
                'string',
                'max:255',
                Rule::requiredIf(fn () => $this->is_medical_practitioner),
            ],
        ];
    }

    protected function messages(): array
    {
        return [
            'medical_specialty.required' => 'Please specify your field of specialty.',
        ];
    }

    public function updateProfileInformation(): void
    {
        $user = Auth::user();

        $validated = $this->validate();

        $yeargrad   = (int) $validated['yeargrad'];
        $schoolyear = ($yeargrad - 1) . '-' . $yeargrad;

        DB::transaction(function () use ($user, $validated, $yeargrad, $schoolyear) {
            $batch = Batch::query()->firstOrCreate(
                ['yeargrad' => $yeargrad],
                ['schoolyear' => $schoolyear]
            );

            $alumniData = [
                'fname'    => trim($validated['first_name']),
                'mname'    => filled($validated['middle_name'] ?? null) ? trim($validated['middle_name']) : null,
                'lname'    => trim($validated['last_name']),
                'occupation' => trim($validated['occupation'] ?? null) ? trim($validated['occupation']) : null,
                'batch_id' => $batch->id,
                'is_batch_rep' => $user->alumni?->is_batch_rep ?? false,

                'address_line_1' => trim($validated['address_line_1']),
                'address_line_2' => filled($validated['address_line_2'] ?? null) ? trim($validated['address_line_2']) : null,
                'city'           => trim($validated['city']),
                'state_province' => trim($validated['state_province']),
                'postal_code'    => filled($validated['postal_code'] ?? null) ? trim($validated['postal_code']) : null,
                'country'        => trim($validated['country']),
            ];

            if ($user->alumni_id) {
                $user->alumni()->update($alumniData);
                $alumni = $user->alumni()->first();
            } else {
                $alumni = Alumni::query()->create($alumniData);
                $user->forceFill(['alumni_id' => $alumni->id])->save();
            }

            // Read directly from $this properties — $validated can drop
            //    unchecked boolean values, causing them to always save as false.
            $alumni->involvement()->updateOrCreate(
                ['alumni_id' => $alumni->id],
                [
                    'wants_committee_member'  => $this->wants_committee_member,
                    'is_priest_concelebrate'  => $this->is_priest_concelebrate,
                    'is_medical_practitioner' => $this->is_medical_practitioner,
                    'medical_specialty'       => $this->is_medical_practitioner
                        ? trim($this->medical_specialty ?? '')
                        : null,
                ]
            );

            if ($validated['email'] !== $user->email) {
                $user->forceFill([
                    'email'             => trim($validated['email']),
                    'email_verified_at' => null,
                ])->save();
            }
        });

        $this->hasSavedInvolvement =
            $this->wants_committee_member ||
            $this->is_priest_concelebrate ||
            $this->is_medical_practitioner;

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

<section class="w-full px-3 py-4 sm:px-5 sm:py-6 lg:px-6">
    @include('partials.settings-heading')

    <flux:heading class="sr-only">{{ __('Profile Settings') }}</flux:heading>

    <x-settings.layout :heading="__('Profile')" :subheading="__('Manage your alumni information, address details, and reunion involvement preferences.')">
        <form wire:submit="updateProfileInformation" class="my-6 w-full space-y-6">

            {{-- ── Hero Banner ── --}}
            <div class="overflow-hidden rounded-2xl border border-white/10 bg-gradient-to-br from-slate-950 via-zinc-900 to-indigo-950/40 shadow-[0_18px_50px_rgba(0,0,0,0.28)] sm:rounded-3xl">
                <div class="px-5 py-5 sm:px-6 sm:py-6">
                    <p class="text-[11px] font-semibold uppercase tracking-[0.22em] text-indigo-300">
                        Alumni Account
                    </p>

                    <div class="mt-2 flex flex-col gap-3 lg:flex-row lg:items-end lg:justify-between">
                        <div>
                            <h2 class="text-xl font-bold tracking-tight text-white sm:text-2xl">
                                Edit Your Profile
                            </h2>
                            <p class="mt-2 max-w-2xl text-sm leading-6 text-zinc-400">
                                Keep your alumni details updated so you can participate in reunion activities,
                                receive announcements, and stay connected with the community.
                            </p>
                        </div>

                        <div class="inline-flex w-fit items-center rounded-full border border-emerald-400/20 bg-emerald-400/10 px-3 py-1 text-[11px] font-semibold uppercase tracking-wide text-emerald-300">
                            {{ auth()->user()?->alumni ? 'Profile Active' : 'Profile Setup Needed' }}
                        </div>
                    </div>
                </div>
            </div>

            {{-- ── Tab Bar ── --}}
            <div class="rounded-2xl border border-white/10 bg-zinc-900/60 p-3 shadow-[0_16px_40px_rgba(0,0,0,0.22)] backdrop-blur-sm sm:rounded-3xl sm:p-4">
                <div class="flex flex-wrap gap-2">
                    <button
                        type="button"
                        wire:click="$set('activeTab', 'profile')"
                        class="inline-flex items-center rounded-xl px-4 py-2.5 text-sm font-medium transition"
                        @class([
                            'bg-[#c6a56b] text-black shadow-sm' => $activeTab === 'profile',
                            'border border-white/10 bg-white/[0.03] text-white hover:bg-white/[0.06]' => $activeTab !== 'profile',
                        ])
                    >
                        Personal Information
                    </button>

                    <button
                        type="button"
                        wire:click="$set('activeTab', 'address')"
                        class="inline-flex items-center rounded-xl px-4 py-2.5 text-sm font-medium transition"
                        @class([
                            'bg-[#c6a56b] text-black shadow-sm' => $activeTab === 'address',
                            'border border-white/10 bg-white/[0.03] text-white hover:bg-white/[0.06]' => $activeTab !== 'address',
                        ])
                    >
                        Address Details
                    </button>

                    <button
                        type="button"
                        wire:click="$set('activeTab', 'involvement')"
                        class="inline-flex items-center rounded-xl px-4 py-2.5 text-sm font-medium transition"
                        @class([
                            'bg-[#c6a56b] text-black shadow-sm' => $activeTab === 'involvement',
                            'border border-white/10 bg-white/[0.03] text-white hover:bg-white/[0.06]' => $activeTab !== 'involvement',
                        ])
                    >
                        Be Involved
                    </button>
                </div>
            </div>

            {{-- ── Tab Content ── --}}
            <div class="rounded-2xl border border-white/10 bg-zinc-900/60 shadow-[0_16px_40px_rgba(0,0,0,0.22)] backdrop-blur-sm sm:rounded-3xl">

                {{-- Section heading --}}
                <div class="border-b border-white/10 px-5 py-4 sm:px-6">
                    @if ($activeTab === 'profile')
                        <h3 class="text-base font-semibold text-white sm:text-lg">Personal Information</h3>
                        <p class="mt-1 text-sm text-zinc-400">Update your alumni identity and graduation details.</p>
                    @endif

                    @if ($activeTab === 'address')
                        <h3 class="text-base font-semibold text-white sm:text-lg">Address Details</h3>
                        <p class="mt-1 text-sm text-zinc-400">Keep your current address updated for communication and records.</p>
                    @endif

                    @if ($activeTab === 'involvement')
                        <h3 class="text-base font-semibold text-white sm:text-lg">Be Involved</h3>
                        <p class="mt-1 text-sm text-zinc-400">Share how you would like to participate in the reunion.</p>
                    @endif
                </div>

                <div class="px-5 py-5 sm:px-6 sm:py-6">

    {{-- ════════════ PROFILE TAB ════════════ --}}
    @if ($activeTab === 'profile')
        <div class="space-y-6">
            <div class="grid gap-4 md:grid-cols-2">
                <flux:input wire:model="first_name" :label="__('First Name')" type="text" required autocomplete="given-name" />
                <flux:input wire:model="last_name" :label="__('Last Name')" type="text" required autocomplete="family-name" />
            </div>

            <div class="grid gap-4 md:grid-cols-2">
                <flux:input wire:model="middle_name" :label="__('Middle Name')" type="text" autocomplete="additional-name" />
                <flux:input wire:model="email" :label="__('Email Address')" type="email" required autocomplete="email" />
            </div>

            <div class="grid gap-4 md:grid-cols-2">
                <flux:select wire:model.live="yeargrad" :label="__('Year Graduated')" required>
                    <option value="">-- Select year --</option>
                    @foreach ($yeargradOptions as $year)
                        <option value="{{ $year }}">{{ $year }}</option>
                    @endforeach
                </flux:select>

                <flux:input wire:model="schoolyear" :label="__('School Year')" type="text" readonly />
            </div>

            <div class="grid gap-4 md:grid-cols-2">
                <flux:input
                    wire:model="occupation"
                    :label="__('Occupation')"
                    type="text"
                    placeholder="e.g. Teacher, Engineer, Nurse, Business Owner"
                    autocomplete="organization-title"
                />

                <div></div>
            </div>

            @if (auth()->user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! auth()->user()->hasVerifiedEmail())
                <div class="rounded-2xl border border-amber-500/20 bg-amber-500/10 p-4 text-sm">
                    <flux:text class="text-zinc-200">
                        {{ __('Your email address is unverified.') }}
                        <flux:link class="cursor-pointer text-sm text-amber-300" wire:click.prevent="resendVerificationNotification">
                            {{ __('Click here to re-send the verification email.') }}
                        </flux:link>
                    </flux:text>

                    @if (session('status') === 'verification-link-sent')
                        <flux:text class="mt-2 font-medium !text-green-600 dark:!text-green-400">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </flux:text>
                    @endif
                </div>
            @endif
        </div>
    @endif

    {{-- ════════════ ADDRESS TAB ════════════ --}}
    @if ($activeTab === 'address')
        <div class="space-y-6">
            <div class="grid gap-4">
                <flux:textarea wire:model="address_line_1" :label="__('Address Line 1')" rows="3" required />
                <flux:input wire:model="address_line_2" :label="__('Address Line 2')" type="text" />
            </div>

            <div class="grid gap-4 md:grid-cols-2">
                <flux:input wire:model="city" :label="__('City / Municipality')" type="text" required />
                <flux:input wire:model="state_province" :label="__('Province / State / Region')" type="text" required />
            </div>

            <div class="grid gap-4 md:grid-cols-2">
                <flux:input wire:model="postal_code" :label="__('Postal / ZIP Code')" type="text" />
                <flux:input wire:model="country" :label="__('Country')" type="text" required />
            </div>
        </div>
    @endif

    {{-- ════════════ INVOLVEMENT TAB ════════════ --}}
    @if ($activeTab === 'involvement')
        <div id="volunteer-section" class="space-y-6">

            {{-- Intro banner --}}
            <div class="overflow-hidden rounded-2xl border border-indigo-400/15 bg-gradient-to-br from-slate-950 via-zinc-900 to-indigo-950/40">
                <div class="px-5 py-5 sm:px-6 sm:py-6">
                    <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
                        <div>
                            <p class="text-[11px] font-semibold uppercase tracking-[0.24em] text-indigo-300">
                                Reunion Participation
                            </p>

                            <h3 class="mt-2 text-lg font-semibold text-white sm:text-xl">
                                Be Involved in the Celebration
                            </h3>

                            <p class="mt-3 max-w-2xl text-sm leading-6 text-zinc-400">
                                Let the organizing team know how you would like to participate in the reunion.
                                You may serve as a committee member, concelebrate in the Thanksgiving Mass,
                                or help in the Medical Mission.
                            </p>
                        </div>

                        <div class="shrink-0">
                            @if ($hasSavedInvolvement)
                                <span class="inline-flex items-center rounded-full border border-emerald-400/20 bg-emerald-400/10 px-3 py-1 text-[11px] font-semibold uppercase tracking-wide text-emerald-300">
                                    Preferences Saved
                                </span>
                            @else
                                <span class="inline-flex items-center rounded-full border border-amber-400/20 bg-amber-400/10 px-3 py-1 text-[11px] font-semibold uppercase tracking-wide text-amber-300">
                                    No Selection Yet
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            {{-- Current involvement summary --}}
            @if ($hasSavedInvolvement)
                <div class="rounded-2xl border border-emerald-400/15 bg-emerald-500/[0.08] p-4 sm:p-5">
                    <p class="text-sm font-semibold text-emerald-300">Current Involvement</p>

                    <div class="mt-3 flex flex-wrap gap-2">
                        @if ($wants_committee_member)
                            <span class="inline-flex items-center rounded-full border border-white/10 bg-white/[0.06] px-3 py-1 text-xs font-medium text-white">
                                Committee Member
                            </span>
                        @endif

                        @if ($is_priest_concelebrate)
                            <span class="inline-flex items-center rounded-full border border-white/10 bg-white/[0.06] px-3 py-1 text-xs font-medium text-white">
                                Priest for Thanksgiving Mass
                            </span>
                        @endif

                        @if ($is_medical_practitioner)
                            <span class="inline-flex items-center rounded-full border border-white/10 bg-white/[0.06] px-3 py-1 text-xs font-medium text-white">
                                Medical Mission Volunteer
                            </span>
                        @endif
                    </div>

                    @if ($is_medical_practitioner && filled($medical_specialty))
                        <p class="mt-3 text-sm text-zinc-300">
                            <span class="font-medium text-white">Specialty:</span>
                            {{ $medical_specialty }}
                        </p>
                    @endif
                </div>
            @endif

            {{-- Checkboxes --}}
            <div class="grid gap-4">

                {{-- Committee Member --}}
                <label class="group block cursor-pointer rounded-2xl border border-white/10 bg-white/[0.03] p-4 transition hover:border-indigo-400/20 hover:bg-indigo-400/10 has-[:checked]:border-indigo-400/30 has-[:checked]:bg-indigo-500/10">
                    <div class="flex items-start gap-3">
                        <input
                            type="checkbox"
                            wire:model.live="wants_committee_member"
                            class="mt-1 h-4 w-4 rounded border-white/20 bg-transparent text-indigo-500 focus:ring-indigo-400"
                        >
                        <div>
                            <p class="text-sm font-semibold text-white">
                                I want to volunteer as a Committee Member
                            </p>
                            <p class="mt-1 text-sm leading-6 text-zinc-400">
                                Help in planning, coordination, preparation, and reunion support activities.
                            </p>
                        </div>
                    </div>
                </label>

                {{-- Priest --}}
                <label class="group block cursor-pointer rounded-2xl border border-white/10 bg-white/[0.03] p-4 transition hover:border-indigo-400/20 hover:bg-indigo-400/10 has-[:checked]:border-indigo-400/30 has-[:checked]:bg-indigo-500/10">
                    <div class="flex items-start gap-3">
                        <input
                            type="checkbox"
                            wire:model.live="is_priest_concelebrate"
                            class="mt-1 h-4 w-4 rounded border-white/20 bg-transparent text-indigo-500 focus:ring-indigo-400"
                        >
                        <div>
                            <p class="text-sm font-semibold text-white">
                                I am a Priest and I want to concelebrate in the Thanksgiving Mass
                            </p>
                            <p class="mt-1 text-sm leading-6 text-zinc-400">
                                Indicate your participation in the liturgical celebration during the reunion.
                            </p>
                        </div>
                    </div>
                </label>

                {{-- Medical Practitioner --}}
                <label class="group block cursor-pointer rounded-2xl border border-white/10 bg-white/[0.03] p-4 transition hover:border-indigo-400/20 hover:bg-indigo-400/10 has-[:checked]:border-indigo-400/30 has-[:checked]:bg-indigo-500/10">
                    <div class="flex items-start gap-3">
                        <input
                            type="checkbox"
                            wire:model.live="is_medical_practitioner"
                            class="mt-1 h-4 w-4 rounded border-white/20 bg-transparent text-indigo-500 focus:ring-indigo-400"
                        >
                        <div class="w-full">
                            <p class="text-sm font-semibold text-white">
                                I am a Medical Practitioner and I want to help in the Medical Mission
                            </p>
                            <p class="mt-1 text-sm leading-6 text-zinc-400">
                                Offer your medical expertise and support during the medical mission activity.
                            </p>

                            @if ($is_medical_practitioner)
                                <div class="mt-4">
                                    <flux:input
                                        wire:model="medical_specialty"
                                        :label="__('Field of Specialty')"
                                        type="text"
                                        placeholder="e.g. Internal Medicine, Pediatrics, Dentistry"
                                    />
                                    @error('medical_specialty')
                                        <p class="mt-1 text-xs text-rose-400">{{ $message }}</p>
                                    @enderror
                                </div>
                            @endif
                        </div>
                    </div>
                </label>
            </div>

            {{-- None selected notice --}}
            @if (! $wants_committee_member && ! $is_priest_concelebrate && ! $is_medical_practitioner)
                <div class="rounded-2xl border border-dashed border-white/10 bg-white/[0.02] p-4 text-sm text-zinc-400">
                    You have not selected any reunion involvement yet.
                </div>
            @endif

            {{-- Footer note --}}
            <div class="rounded-2xl border border-indigo-400/15 bg-indigo-500/10 p-4 sm:p-5">
                <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <p class="text-sm font-semibold text-white">Your participation matters</p>
                        <p class="mt-1 text-sm text-zinc-300">
                            These details help the reunion organizers identify volunteers and plan activities more efficiently.
                        </p>
                    </div>

                    <div class="inline-flex shrink-0 items-center rounded-full border border-indigo-400/20 bg-indigo-400/10 px-3 py-1 text-[11px] font-semibold uppercase tracking-wide text-indigo-200">
                        Holy Spirit School Alumni
                    </div>
                </div>
            </div>

        </div>
    @endif

</div>
            </div>

            {{-- ── Save Bar ── --}}
            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <div class="text-sm text-zinc-400">
                    Make sure your information is updated before registering for reunion activities.
                </div>

                <div class="flex items-center gap-4">
                    <x-action-message class="me-3 text-sm text-emerald-400" on="profile-updated">
                        {{ __('Saved.') }}
                    </x-action-message>

                    <flux:button
                        variant="primary"
                        type="submit"
                        class="w-full sm:w-auto"
                        data-test="update-profile-button"
                    >
                        {{ __('Save Changes') }}
                    </flux:button>
                </div>
            </div>

        </form>

        @unless(auth()->user()?->hasRole('reunion-coordinator'))
            <livewire:settings.delete-user-form />
        @endunless
    </x-settings.layout>
</section>