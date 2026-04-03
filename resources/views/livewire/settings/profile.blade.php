<?php

use App\Models\Alumni;
use App\Models\Batch;
use App\Models\Committee;
use App\Models\User;
use App\Models\VolunteerSignup;
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

    // New committee interest fields
    public array $committeeOptions = [];
    public array $selectedCommitteeIds = [];
    public string $volunteer_notes = '';

    public bool $hasCommitteeInterest = false;
    public array $savedCommitteeItems = [];

    public function mount(): void
    {
        $user = Auth::user()?->loadMissing([
            'alumni.batch',
        ]);

        $this->username = (string) ($user->username ?? '');
        $this->email    = (string) ($user->email ?? '');

        $currentYear = (int) now()->year;
        $startYear = $currentYear - 126;
        $this->yeargradOptions = array_reverse(range($startYear, $currentYear));

        $this->committeeOptions = Committee::query()
            ->where('is_active', true)
            ->orderBy('name')
            ->get(['id', 'name'])
            ->map(fn ($committee) => [
                'id' => (string) $committee->id,
                'name' => (string) $committee->name,
            ])
            ->values()
            ->all();

        $alumni = $user?->alumni;

        if (! $alumni) {
            $this->country = 'Philippines';
            $this->refreshCommitteeState((int) ($user?->id ?? 0));
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

        $this->address_line_1 = (string) ($alumni->address_line_1 ?? '');
        $this->address_line_2 = (string) ($alumni->address_line_2 ?? '');
        $this->city = (string) ($alumni->city ?? '');
        $this->state_province = (string) ($alumni->state_province ?? '');
        $this->postal_code = (string) ($alumni->postal_code ?? '');
        $this->country = (string) ($alumni->country ?? 'Philippines');

        $this->refreshCommitteeState((int) $user->id);
    }

    public function updatedYeargrad($value): void
    {
        if (blank($value)) {
            $this->schoolyear = '';
            return;
        }

        $year = (int) $value;
        $this->schoolyear = ($year - 1) . '-' . $year;
    }

    protected function rules(): array
    {
        $user = Auth::user();

        return [
            'first_name'  => ['required', 'string', 'max:255'],
            'middle_name' => ['nullable', 'string', 'max:255'],
            'last_name'   => ['required', 'string', 'max:255'],
            'occupation'  => ['nullable', 'string', 'max:255'],

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

            'selectedCommitteeIds'   => ['nullable', 'array'],
            'selectedCommitteeIds.*' => ['string', Rule::exists('committees', 'id')],
            'volunteer_notes'        => ['nullable', 'string', 'max:1000'],
        ];
    }

    public function updateProfileInformation(): void
    {
        $user = Auth::user();

        $validated = $this->validate();

        $yeargrad = (int) $validated['yeargrad'];
        $schoolyear = ($yeargrad - 1) . '-' . $yeargrad;

        DB::transaction(function () use ($user, $validated, $yeargrad, $schoolyear) {
            $batch = Batch::query()->firstOrCreate(
                ['yeargrad' => $yeargrad],
                ['schoolyear' => $schoolyear]
            );

            $occupation = isset($validated['occupation']) ? trim((string) $validated['occupation']) : '';

            $alumniData = [
                'fname' => trim($validated['first_name']),
                'mname' => filled($validated['middle_name'] ?? null) ? trim($validated['middle_name']) : null,
                'lname' => trim($validated['last_name']),
                'occupation' => $occupation !== '' ? $occupation : null,
                'batch_id' => $batch->id,
                'is_batch_rep' => $user->alumni?->is_batch_rep ?? false,

                'address_line_1' => trim($validated['address_line_1']),
                'address_line_2' => filled($validated['address_line_2'] ?? null) ? trim($validated['address_line_2']) : null,
                'city' => trim($validated['city']),
                'state_province' => trim($validated['state_province']),
                'postal_code' => filled($validated['postal_code'] ?? null) ? trim($validated['postal_code']) : null,
                'country' => trim($validated['country']),
            ];

            if ($user->alumni_id) {
                $user->alumni()->update($alumniData);
                $alumni = $user->alumni()->first();
            } else {
                $alumni = Alumni::query()->create($alumniData);
                $user->forceFill(['alumni_id' => $alumni->id])->save();
            }

            if ($validated['email'] !== $user->email) {
                $user->forceFill([
                    'email' => trim($validated['email']),
                    'email_verified_at' => null,
                ])->save();
            }

            $this->syncCommitteeInterest($user, $alumni);
        });

        $this->refreshCommitteeState((int) $user->id);

        $this->dispatch('profile-updated');
    }

    protected function syncCommitteeInterest(User $user, Alumni $alumni): void
    {
        $selectedIds = collect($this->selectedCommitteeIds)
            ->filter()
            ->map(fn ($id) => (int) $id)
            ->unique()
            ->values();

        $notes = trim($this->volunteer_notes);
        $notes = $notes !== '' ? $notes : null;

        $existing = VolunteerSignup::query()
            ->where('user_id', $user->id)
            ->get()
            ->keyBy('committee_id');

        foreach ($selectedIds as $committeeId) {
            $signup = $existing->get($committeeId);

            if ($signup) {
                if ($signup->status === 'pending') {
                    $signup->update([
                        'notes' => $notes,
                    ]);
                }

                continue;
            }

            VolunteerSignup::create([
                'user_id' => $user->id,
                'alumni_id' => $alumni->id,
                'committee_id' => $committeeId,
                'notes' => $notes,
                'status' => 'pending',
            ]);
        }

        VolunteerSignup::query()
            ->where('user_id', $user->id)
            ->where('status', 'pending')
            ->when(
                $selectedIds->isNotEmpty(),
                fn ($query) => $query->whereNotIn('committee_id', $selectedIds->all()),
                fn ($query) => $query
            )
            ->delete();
    }

    protected function refreshCommitteeState(int $userId): void
    {
        if ($userId <= 0) {
            $this->savedCommitteeItems = [];
            $this->selectedCommitteeIds = [];
            $this->volunteer_notes = '';
            $this->hasCommitteeInterest = false;
            return;
        }

        $signups = VolunteerSignup::query()
            ->join('committees', 'committees.id', '=', 'volunteer_signups.committee_id')
            ->where('volunteer_signups.user_id', $userId)
            ->select(
                'volunteer_signups.committee_id',
                'volunteer_signups.status',
                'volunteer_signups.notes',
                'committees.name as committee_name'
            )
            ->orderBy('committees.name')
            ->get();

        $this->savedCommitteeItems = $signups
            ->map(fn ($signup) => [
                'id' => (string) $signup->committee_id,
                'name' => (string) $signup->committee_name,
                'status' => (string) $signup->status,
            ])
            ->values()
            ->all();

        $this->selectedCommitteeIds = $signups
            ->pluck('committee_id')
            ->map(fn ($id) => (string) $id)
            ->values()
            ->all();

        $this->volunteer_notes = (string) ($signups->pluck('notes')->filter()->first() ?? '');
        $this->hasCommitteeInterest = ! empty($this->savedCommitteeItems);
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

    public function statusBadgeClasses(string $status): string
    {
        return match ($status) {
            'approved' => 'border-emerald-400/20 bg-emerald-400/10 text-emerald-300',
            'contacted' => 'border-sky-400/20 bg-sky-400/10 text-sky-300',
            'declined' => 'border-rose-400/20 bg-rose-400/10 text-rose-300',
            default => 'border-amber-400/20 bg-amber-400/10 text-amber-300',
        };
    }
};
?>

<section class="w-full min-h-screen bg-[#f7f5f1] px-4 py-8 sm:px-6 lg:px-8">

    {{-- @include('partials.settings-heading') --}}

    <flux:heading class="sr-only">{{ __('Profile Settings') }}</flux:heading>

    {{-- Page Header --}}
    <div class="mb-7">
        <p class="text-[10px] font-semibold uppercase tracking-[.2em] text-[#b88a3d] mb-1">Account</p>
        <h1 class="font-serif text-[28px] font-normal leading-tight text-[#091852] sm:text-[32px]">Profile Settings</h1>
        <p class="mt-1 text-sm text-[#7a7060]">Manage your alumni information and reunion participation.</p>
    </div>

    <form wire:submit="updateProfileInformation" class="w-full max-w-3xl space-y-5">

        {{-- Tab Bar --}}
        <div class="flex gap-1 rounded-2xl bg-[#ede9e0] p-1.5">
            <button
                type="button"
                wire:click="$set('activeTab', 'profile')"
                @class([
                    'flex flex-1 items-center justify-center gap-2 rounded-xl px-4 py-2.5 text-[13px] font-medium transition-all duration-150',
                    'bg-white text-[#091852] shadow-sm' => $activeTab === 'profile',
                    'text-[#7a7060] hover:bg-white/50 hover:text-[#1a1410]' => $activeTab !== 'profile',
                ])
            >
                <svg class="h-3.5 w-3.5 shrink-0" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.6">
                    <circle cx="10" cy="7" r="3"/><path d="M4 17c0-3.314 2.686-6 6-6s6 2.686 6 6"/>
                </svg>
                Personal
            </button>

            <button
                type="button"
                wire:click="$set('activeTab', 'address')"
                @class([
                    'flex flex-1 items-center justify-center gap-2 rounded-xl px-4 py-2.5 text-[13px] font-medium transition-all duration-150',
                    'bg-white text-[#091852] shadow-sm' => $activeTab === 'address',
                    'text-[#7a7060] hover:bg-white/50 hover:text-[#1a1410]' => $activeTab !== 'address',
                ])
            >
                <svg class="h-3.5 w-3.5 shrink-0" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.6">
                    <path d="M10 2C7.239 2 5 4.239 5 7c0 4.418 5 11 5 11s5-6.582 5-11c0-2.761-2.239-5-5-5z"/><circle cx="10" cy="7" r="1.5"/>
                </svg>
                Address
            </button>

            <button
                type="button"
                wire:click="$set('activeTab', 'committee')"
                @class([
                    'flex flex-1 items-center justify-center gap-2 rounded-xl px-4 py-2.5 text-[13px] font-medium transition-all duration-150',
                    'bg-white text-[#091852] shadow-sm' => $activeTab === 'committee',
                    'text-[#7a7060] hover:bg-white/50 hover:text-[#1a1410]' => $activeTab !== 'committee',
                ])
            >
                <svg class="h-3.5 w-3.5 shrink-0" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.6">
                    <path d="M3 5h14M3 10h14M3 15h8"/>
                </svg>
                Committee
            </button>
        </div>

        {{-- ───────────────────────────────────────────── --}}
        {{-- PROFILE TAB                                   --}}
        {{-- ───────────────────────────────────────────── --}}
        @if ($activeTab === 'profile')
            <div class="overflow-hidden rounded-[20px] border border-[#e8e2d6] bg-white">

                {{-- Card Header --}}
                <div class="flex items-center gap-3.5 border-b border-[#f0ebe1] px-5 py-4 sm:px-6">
                    <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-[10px] bg-[#faf4e6]">
                        <svg class="h-4.5 w-4.5 text-[#b88a3d]" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.6">
                            <circle cx="10" cy="7" r="3"/><path d="M4 17c0-3.314 2.686-6 6-6s6 2.686 6 6"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-[15px] font-medium text-[#1a1410]">Personal Information</h3>
                        <p class="mt-0.5 text-xs text-[#9a9080]">Your alumni identity and graduation details</p>
                    </div>
                </div>

                <div class="space-y-4 px-5 py-5 sm:px-6">

                    {{-- Name Row --}}
                    <div class="grid gap-4 sm:grid-cols-2">
                        <div>
                            <label class="mb-1.5 block text-[11px] font-semibold uppercase tracking-[.06em] text-[#9a9080]">First Name</label>
                            <input
                                wire:model="first_name"
                                type="text"
                                required
                                autocomplete="given-name"
                                class="w-full rounded-[10px] border border-[#e0dbd0] bg-[#faf9f7] px-3.5 py-2.5 text-sm text-[#1a1410] outline-none transition focus:border-[#d4b06a] focus:bg-white focus:ring-0"
                            />
                            @error('first_name') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="mb-1.5 block text-[11px] font-semibold uppercase tracking-[.06em] text-[#9a9080]">Last Name</label>
                            <input
                                wire:model="last_name"
                                type="text"
                                required
                                autocomplete="family-name"
                                class="w-full rounded-[10px] border border-[#e0dbd0] bg-[#faf9f7] px-3.5 py-2.5 text-sm text-[#1a1410] outline-none transition focus:border-[#d4b06a] focus:bg-white focus:ring-0"
                            />
                            @error('last_name') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    {{-- Middle & Email --}}
                    <div class="grid gap-4 sm:grid-cols-2">
                        <div>
                            <label class="mb-1.5 block text-[11px] font-semibold uppercase tracking-[.06em] text-[#9a9080]">Middle Name</label>
                            <input
                                wire:model="middle_name"
                                type="text"
                                autocomplete="additional-name"
                                class="w-full rounded-[10px] border border-[#e0dbd0] bg-[#faf9f7] px-3.5 py-2.5 text-sm text-[#1a1410] outline-none transition focus:border-[#d4b06a] focus:bg-white focus:ring-0"
                            />
                        </div>
                        <div>
                            <label class="mb-1.5 block text-[11px] font-semibold uppercase tracking-[.06em] text-[#9a9080]">Email Address</label>
                            <input
                                wire:model="email"
                                type="email"
                                required
                                autocomplete="email"
                                class="w-full rounded-[10px] border border-[#e0dbd0] bg-[#faf9f7] px-3.5 py-2.5 text-sm text-[#1a1410] outline-none transition focus:border-[#d4b06a] focus:bg-white focus:ring-0"
                            />
                            @error('email') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="border-t border-[#f0ebe1]"></div>

                    {{-- Year Grad & School Year --}}
                    <div class="grid gap-4 sm:grid-cols-2">
                        <div>
                            <label class="mb-1.5 block text-[11px] font-semibold uppercase tracking-[.06em] text-[#9a9080]">Year Graduated</label>
                            <select
                                wire:model.live="yeargrad"
                                required
                                class="w-full rounded-[10px] border border-[#e0dbd0] bg-[#faf9f7] px-3.5 py-2.5 text-sm text-[#1a1410] outline-none transition focus:border-[#d4b06a] focus:bg-white focus:ring-0"
                            >
                                <option value="">-- Select year --</option>
                                @foreach ($yeargradOptions as $year)
                                    <option value="{{ $year }}" @selected($yeargrad == $year)>{{ $year }}</option>
                                @endforeach
                            </select>
                            @error('yeargrad') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="mb-1.5 block text-[11px] font-semibold uppercase tracking-[.06em] text-[#9a9080]">School Year</label>
                            <input
                                wire:model="schoolyear"
                                type="text"
                                readonly
                                class="w-full cursor-not-allowed rounded-[10px] border border-[#e0dbd0] bg-[#f5f3ef] px-3.5 py-2.5 text-sm text-[#9a9080] outline-none"
                            />
                        </div>
                    </div>

                    {{-- Occupation --}}
                    <div>
                        <label class="mb-1.5 block text-[11px] font-semibold uppercase tracking-[.06em] text-[#9a9080]">Occupation</label>
                        <input
                            wire:model="occupation"
                            type="text"
                            placeholder="e.g. Teacher, Engineer, Nurse, Business Owner"
                            autocomplete="organization-title"
                            class="w-full rounded-[10px] border border-[#e0dbd0] bg-[#faf9f7] px-3.5 py-2.5 text-sm text-[#1a1410] outline-none transition placeholder:text-[#c0bbb0] focus:border-[#d4b06a] focus:bg-white focus:ring-0"
                        />
                    </div>

                    {{-- Email verification notice --}}
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
        @endif

        {{-- ───────────────────────────────────────────── --}}
        {{-- ADDRESS TAB                                   --}}
        {{-- ───────────────────────────────────────────── --}}
        @if ($activeTab === 'address')
            <div class="overflow-hidden rounded-[20px] border border-[#e8e2d6] bg-white">

                <div class="flex items-center gap-3.5 border-b border-[#f0ebe1] px-5 py-4 sm:px-6">
                    <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-[10px] bg-[#faf4e6]">
                        <svg class="h-4.5 w-4.5 text-[#b88a3d]" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.6">
                            <path d="M10 2C7.239 2 5 4.239 5 7c0 4.418 5 11 5 11s5-6.582 5-11c0-2.761-2.239-5-5-5z"/><circle cx="10" cy="7" r="1.5"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-[15px] font-medium text-[#1a1410]">Address Details</h3>
                        <p class="mt-0.5 text-xs text-[#9a9080]">Keep your address updated for communication and records</p>
                    </div>
                </div>

                <div class="space-y-4 px-5 py-5 sm:px-6">

                    <div>
                        <label class="mb-1.5 block text-[11px] font-semibold uppercase tracking-[.06em] text-[#9a9080]">Address Line 1</label>
                        <textarea
                            wire:model="address_line_1"
                            rows="3"
                            required
                            class="w-full resize-none rounded-[10px] border border-[#e0dbd0] bg-[#faf9f7] px-3.5 py-2.5 text-sm text-[#1a1410] outline-none transition focus:border-[#d4b06a] focus:bg-white focus:ring-0"
                        ></textarea>
                        @error('address_line_1') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="mb-1.5 block text-[11px] font-semibold uppercase tracking-[.06em] text-[#9a9080]">
                            Address Line 2 <span class="normal-case tracking-normal text-[#b0ab9e]">(optional)</span>
                        </label>
                        <input
                            wire:model="address_line_2"
                            type="text"
                            placeholder="Unit, floor, building name"
                            class="w-full rounded-[10px] border border-[#e0dbd0] bg-[#faf9f7] px-3.5 py-2.5 text-sm text-[#1a1410] outline-none transition placeholder:text-[#c0bbb0] focus:border-[#d4b06a] focus:bg-white focus:ring-0"
                        />
                    </div>

                    <div class="border-t border-[#f0ebe1]"></div>

                    <div class="grid gap-4 sm:grid-cols-2">
                        <div>
                            <label class="mb-1.5 block text-[11px] font-semibold uppercase tracking-[.06em] text-[#9a9080]">City / Municipality</label>
                            <input
                                wire:model="city"
                                type="text"
                                required
                                class="w-full rounded-[10px] border border-[#e0dbd0] bg-[#faf9f7] px-3.5 py-2.5 text-sm text-[#1a1410] outline-none transition focus:border-[#d4b06a] focus:bg-white focus:ring-0"
                            />
                            @error('city') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="mb-1.5 block text-[11px] font-semibold uppercase tracking-[.06em] text-[#9a9080]">Province / State / Region</label>
                            <input
                                wire:model="state_province"
                                type="text"
                                required
                                class="w-full rounded-[10px] border border-[#e0dbd0] bg-[#faf9f7] px-3.5 py-2.5 text-sm text-[#1a1410] outline-none transition focus:border-[#d4b06a] focus:bg-white focus:ring-0"
                            />
                            @error('state_province') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="grid gap-4 sm:grid-cols-2">
                        <div>
                            <label class="mb-1.5 block text-[11px] font-semibold uppercase tracking-[.06em] text-[#9a9080]">
                                Postal / ZIP Code <span class="normal-case tracking-normal text-[#b0ab9e]">(optional)</span>
                            </label>
                            <input
                                wire:model="postal_code"
                                type="text"
                                class="w-full rounded-[10px] border border-[#e0dbd0] bg-[#faf9f7] px-3.5 py-2.5 text-sm text-[#1a1410] outline-none transition focus:border-[#d4b06a] focus:bg-white focus:ring-0"
                            />
                        </div>
                        <div>
                            <label class="mb-1.5 block text-[11px] font-semibold uppercase tracking-[.06em] text-[#9a9080]">Country</label>
                            <input
                                wire:model="country"
                                type="text"
                                required
                                class="w-full rounded-[10px] border border-[#e0dbd0] bg-[#faf9f7] px-3.5 py-2.5 text-sm text-[#1a1410] outline-none transition focus:border-[#d4b06a] focus:bg-white focus:ring-0"
                            />
                            @error('country') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                        </div>
                    </div>

                </div>
            </div>
        @endif

        {{-- ───────────────────────────────────────────── --}}
        {{-- COMMITTEE TAB                                 --}}
        {{-- ───────────────────────────────────────────── --}}
        @if ($activeTab === 'committee')
            <div class="overflow-hidden rounded-[20px] border border-[#e8e2d6] bg-white">

                <div class="flex items-center gap-3.5 border-b border-[#f0ebe1] px-5 py-4 sm:px-6">
                    <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-[10px] bg-[#faf4e6]">
                        <svg class="h-4.5 w-4.5 text-[#b88a3d]" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.6">
                            <path d="M3 5h14M3 10h14M3 15h8"/>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-[15px] font-medium text-[#1a1410]">Committee Interest</h3>
                        <p class="mt-0.5 text-xs text-[#9a9080]">Choose committees you want to support for the reunion</p>
                    </div>
                    {{-- Overall status badge --}}
                    @if ($hasCommitteeInterest)
                        <span class="inline-flex items-center gap-1.5 rounded-full border border-emerald-200 bg-emerald-50 px-3 py-1 text-[11px] font-semibold uppercase tracking-wide text-emerald-800">
                            <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                            Interest Submitted
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1.5 rounded-full border border-[#f0d496] bg-[#faf4e6] px-3 py-1 text-[11px] font-semibold uppercase tracking-wide text-[#92601c]">
                            <span class="h-1.5 w-1.5 rounded-full bg-[#d4a017]"></span>
                            No Committee Yet
                        </span>
                    @endif
                </div>

                <div class="space-y-5 px-5 py-5 sm:px-6">

                    {{-- Saved committee interest summary --}}
                    @if (! empty($savedCommitteeItems))
                        <div class="rounded-[14px] border border-[#e0dbd0] bg-[#faf9f7] p-4">
                            <div class="mb-3 flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-[#1a1410]">Current Selections</p>
                                    <p class="mt-0.5 text-xs text-[#9a9080]">Submitted interests and their organizer review status</p>
                                </div>
                                <span class="rounded-full border border-[#e0dbd0] bg-white px-2.5 py-1 text-[11px] font-semibold text-[#7a7060]">
                                    {{ count($savedCommitteeItems) }} selected
                                </span>
                            </div>
                            <div class="flex flex-wrap gap-2">
                                @foreach ($savedCommitteeItems as $item)
                                    <span @class([
                                        'inline-flex items-center gap-1.5 rounded-full border px-3 py-1 text-[11px] font-medium',
                                        $this->statusBadgeClasses($item['status']),
                                    ])>
                                        <span class="h-1.5 w-1.5 rounded-full bg-current opacity-70"></span>
                                        {{ $item['name'] }}
                                        <span class="ml-0.5 uppercase tracking-wide opacity-70">{{ $item['status'] }}</span>
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    {{-- Section label --}}
                    <div>
                        <p class="text-sm font-medium text-[#1a1410]">Select committee(s)</p>
                        <p class="mt-0.5 text-xs text-[#9a9080]">You may choose more than one. Pending selections can still be updated later.</p>
                    </div>

                    {{-- Committee grid --}}
                    <div class="grid gap-2.5 sm:grid-cols-2 xl:grid-cols-3">
                        @foreach ($committeeOptions as $committee)
                            <label @class([
                                'group relative flex min-h-[80px] cursor-pointer rounded-[14px] border p-3.5 transition-all duration-150',
                                'border-[#d4b06a] bg-white ring-2 ring-[#d4b06a]/20' => in_array($committee['id'], $selectedCommitteeIds ?? []),
                                'border-[#e0dbd0] bg-[#faf9f7] hover:border-[#d4b06a]/50 hover:bg-white' => ! in_array($committee['id'], $selectedCommitteeIds ?? []),
                            ])>
                                <input
                                    type="checkbox"
                                    wire:model.live="selectedCommitteeIds"
                                    value="{{ $committee['id'] }}"
                                    class="peer sr-only"
                                >

                                <div class="flex items-start gap-3">
                                    {{-- Custom checkbox --}}
                                    <div @class([
                                        'mt-0.5 flex h-5 w-5 shrink-0 items-center justify-center rounded-[6px] border transition-all duration-150',
                                        'border-[#d4b06a] bg-[#d4b06a]' => in_array($committee['id'], $selectedCommitteeIds ?? []),
                                        'border-[#d0c8bc] bg-white' => ! in_array($committee['id'], $selectedCommitteeIds ?? []),
                                    ])>
                                        <svg @class([
                                            'h-3 w-3 text-white transition-opacity',
                                            'opacity-100' => in_array($committee['id'], $selectedCommitteeIds ?? []),
                                            'opacity-0' => ! in_array($committee['id'], $selectedCommitteeIds ?? []),
                                        ]) viewBox="0 0 12 10" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                            <polyline points="1,5 4,8 11,1"/>
                                        </svg>
                                    </div>

                                    <div class="min-w-0">
                                        <p class="text-[13px] font-medium leading-5 text-[#1a1410]">
                                            {{ $committee['name'] }}
                                        </p>
                                        @if (! empty($committee['description']))
                                            <p class="mt-0.5 text-[11px] leading-4 text-[#9a9080]">
                                                {{ $committee['description'] }}
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            </label>
                        @endforeach
                    </div>

                    @error('selectedCommitteeIds')
                        <p class="text-sm text-rose-500">{{ $message }}</p>
                    @enderror
                    @error('selectedCommitteeIds.*')
                        <p class="text-sm text-rose-500">{{ $message }}</p>
                    @enderror

                    {{-- Empty state --}}
                    @if (empty($selectedCommitteeIds))
                        <div class="rounded-[14px] border border-dashed border-[#d0c8bc] bg-[#faf9f7] px-5 py-6 text-center">
                            <div class="mx-auto mb-2 flex h-9 w-9 items-center justify-center rounded-full bg-[#f0ebe1]">
                                <svg class="h-4 w-4 text-[#b0ab9e]" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5">
                                    <path d="M3 5h14M3 10h14M3 15h8"/>
                                </svg>
                            </div>
                            <p class="text-sm font-medium text-[#1a1410]">No committee selected yet</p>
                            <p class="mt-1 text-xs text-[#9a9080]">Choose at least one committee above to be involved in reunion preparations.</p>
                        </div>
                    @endif

                    <div class="border-t border-[#f0ebe1]"></div>

                    {{-- Notes + Hint row --}}
                    <div class="grid gap-4 lg:grid-cols-[1fr_240px]">
                        <div>
                            <label class="mb-1.5 block text-[11px] font-semibold uppercase tracking-[.06em] text-[#9a9080]">Skills / Notes</label>
                            <textarea
                                wire:model="volunteer_notes"
                                rows="4"
                                placeholder="Share any skills, experience, preferred committee role, or helpful notes..."
                                class="w-full resize-none rounded-[10px] border border-[#e0dbd0] bg-[#faf9f7] px-3.5 py-2.5 text-sm text-[#1a1410] outline-none transition placeholder:text-[#c0bbb0] focus:border-[#d4b06a] focus:bg-white focus:ring-0"
                            ></textarea>
                            <p class="mt-2 text-xs text-[#9a9080]">
                                e.g. documentation, logistics, hosting, design, registration, sponsorship, medical support, or program assistance.
                            </p>
                        </div>

                        <div class="rounded-[14px] border border-[#f0d496] bg-[#faf4e6] p-4">
                            <p class="text-[13px] font-medium text-[#7a5c1e]">How this works</p>
                            <p class="mt-2 text-xs leading-5 text-[#92601c]">
                                Organizers will review your selected committee interests. Already reviewed entries are preserved, while pending ones can still be updated from this page before the deadline.
                            </p>
                        </div>
                    </div>

                </div>
            </div>
        @endif

        {{-- ───────────────────────────────────────────── --}}
        {{-- Save Bar                                      --}}
        {{-- ───────────────────────────────────────────── --}}
        <div class="flex flex-col gap-3 rounded-[16px] border border-[#e8e2d6] bg-white px-5 py-4 sm:flex-row sm:items-center sm:justify-between sm:px-6">
            <p class="text-xs text-[#9a9080]">
                Keep your alumni information and committee interest updated before reunion activities begin.
            </p>

            <div class="flex items-center gap-4">
                <x-action-message class="text-xs font-medium text-emerald-600" on="profile-updated">
                    {{ __('Changes saved.') }}
                </x-action-message>

                <button
                    type="submit"
                    data-test="update-profile-button"
                    class="inline-flex items-center gap-2 rounded-[10px] bg-[#d4b06a] px-5 py-2.5 text-sm font-medium text-[#091852] transition hover:bg-[#c9a458] active:scale-[.98]"
                >
                    <svg class="h-4 w-4" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.6">
                        <path d="M4 13V16h3l9-9-3-3-9 9zM14.5 4.5l1 1"/>
                    </svg>
                    {{ __('Save Changes') }}
                </button>
            </div>
        </div>

    </form>

 

</section>