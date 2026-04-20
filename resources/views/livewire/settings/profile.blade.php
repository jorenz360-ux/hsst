<?php

use App\Models\Alumni;
use App\Models\AlumniEducation;
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

    public string $prefix = '';
    public string $first_name = '';
    public string $middle_name = '';
    public string $last_name = '';
    public string $suffix = '';

    public string $cellphone = '';
    public string $occupation = '';

    /** @var array<string, array{enabled: bool, batch_id: string, did_graduate: string, school_year_attended: string, schoolyear: string}> */
    public array $educations = [
        'elementary' => ['enabled' => false, 'batch_id' => '', 'did_graduate' => '1', 'school_year_attended' => '', 'schoolyear' => ''],
        'highschool' => ['enabled' => false, 'batch_id' => '', 'did_graduate' => '1', 'school_year_attended' => '', 'schoolyear' => ''],
        'college'    => ['enabled' => false, 'batch_id' => '', 'did_graduate' => '1', 'school_year_attended' => '', 'schoolyear' => ''],
    ];

    public array $batchesByLevel = [
        'elementary' => [],
        'highschool' => [],
        'college'    => [],
    ];

    public string $address_line_1 = '';
    public string $address_line_2 = '';
    public string $city = '';
    public string $state_province = '';
    public string $postal_code = '';
    public string $country = '';

    public array $committeeOptions = [];
    public array $selectedCommitteeIds = [];
    public string $volunteer_notes = '';

    public bool $hasCommitteeInterest = false;
    public array $savedCommitteeItems = [];

    public array $prefixOptions = [
        'Mr.',
        'Mrs.',
        'Ms.',
        'Dr.',
        'Atty.',
        'Engr.',
        'Rev.',
        'Hon.',
    ];

    public array $suffixOptions = [
        'Jr.',
        'Sr.',
        'II',
        'III',
        'IV',
    ];

    public function mount(): void
    {
        if (Auth::user()?->staff_id) {
            $this->redirect(route('staff-profile.edit'), navigate: true);
            return;
        }

        $user = Auth::user()?->loadMissing([
            'alumni.educations.batch',
        ]);

        $this->username = (string) ($user->username ?? '');
        $this->email    = (string) ($user->email ?? '');

        foreach (['elementary', 'highschool', 'college'] as $level) {
            $this->batchesByLevel[$level] = Batch::where('level', $level)
                ->orderBy('yeargrad', 'desc')
                ->get(['id', 'yeargrad', 'schoolyear'])
                ->map(fn ($b) => [
                    'id'         => $b->id,
                    'yeargrad'   => $b->yeargrad,
                    'schoolyear' => $b->schoolyear,
                ])
                ->all();
        }

        $this->committeeOptions = Committee::query()
            ->where('is_active', true)
            ->orderBy('name')
            ->get(['id', 'name'])
            ->map(fn ($c) => [
                'id'   => (string) $c->id,
                'name' => (string) $c->name,
            ])
            ->values()
            ->all();

        $alumni = $user?->alumni;

        if (! $alumni) {
            $this->country = 'Philippines';
            $this->refreshCommitteeState((int) ($user?->id ?? 0));
            return;
        }

        $this->prefix      = (string) ($alumni->prefix ?? '');
        $this->first_name  = (string) ($alumni->fname ?? '');
        $this->middle_name = (string) ($alumni->mname ?? '');
        $this->last_name   = (string) ($alumni->lname ?? '');
        $this->suffix      = (string) ($alumni->suffix ?? '');

        $this->cellphone  = (string) ($alumni->cellphone ?? '');
        $this->occupation = (string) ($alumni->occupation ?? '');

        $this->address_line_1 = (string) ($alumni->address_line_1 ?? '');
        $this->address_line_2 = (string) ($alumni->address_line_2 ?? '');
        $this->city           = (string) ($alumni->city ?? '');
        $this->state_province = (string) ($alumni->state_province ?? '');
        $this->postal_code    = (string) ($alumni->postal_code ?? '');
        $this->country        = (string) ($alumni->country ?? 'Philippines');

        foreach ($alumni->educations as $edu) {
            $level = $edu->batch?->level;
            if ($level && array_key_exists($level, $this->educations)) {
                $this->educations[$level] = [
                    'enabled'              => true,
                    'batch_id'             => (string) $edu->batch_id,
                    'did_graduate'         => $edu->did_graduate ? '1' : '0',
                    'school_year_attended' => (string) ($edu->school_year_attended ?? ''),
                    'schoolyear'           => (string) ($edu->batch?->schoolyear ?? ''),
                ];
            }
        }

        $this->refreshCommitteeState((int) $user->id);
    }

    public function updatedEducations($value, $key): void
    {
        // $key is dot-notation e.g. 'elementary.batch_id'
        $parts = explode('.', $key);
        if (count($parts) === 2 && $parts[1] === 'batch_id') {
            $level = $parts[0];
            if (array_key_exists($level, $this->educations)) {
                $batchId = (int) $value;
                $batch   = collect($this->batchesByLevel[$level] ?? [])->firstWhere('id', $batchId);
                $this->educations[$level]['schoolyear'] = $batch ? (string) $batch['schoolyear'] : '';
            }
        }
    }

    protected function rules(): array
    {
        $user   = Auth::user();
        $levels = ['elementary', 'highschool', 'college'];

        $rules = [
            'prefix'      => ['nullable', 'string', 'max:20'],
            'first_name'  => ['required', 'string', 'max:255'],
            'middle_name' => ['nullable', 'string', 'max:255'],
            'last_name'   => ['required', 'string', 'max:255'],
            'suffix'      => ['nullable', 'string', 'max:20'],

            'cellphone'  => ['required', 'string', 'max:30'],
            'occupation' => ['nullable', 'string', 'max:255'],

            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class, 'email')->ignore($user->id),
            ],

            'educations' => ['required', 'array'],

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

        foreach ($levels as $level) {
            $rules["educations.$level.enabled"]              = ['boolean'];
            $rules["educations.$level.batch_id"]             = ['nullable', 'integer', Rule::exists('batches', 'id')];
            $rules["educations.$level.did_graduate"]         = ['nullable', Rule::in(['0', '1'])];
            $rules["educations.$level.school_year_attended"] = ['nullable', 'string', 'max:50'];
        }

        return $rules;
    }

    public function updateProfileInformation(): void
    {
        $user = Auth::user();

        $validated = $this->validate();

        $enabledCount = collect($this->educations)
            ->filter(fn ($e) => (bool) ($e['enabled'] ?? false))
            ->count();

        if ($enabledCount === 0) {
            $this->addError('educations', 'Please select at least one education level.');
            return;
        }

        foreach (['elementary', 'highschool', 'college'] as $level) {
            $edu = $this->educations[$level];
            if (! (bool) ($edu['enabled'] ?? false)) {
                continue;
            }

            if (blank($edu['batch_id'])) {
                $this->addError("educations.$level.batch_id", 'Please select a batch.');
                return;
            }

            if (($edu['did_graduate'] ?? '1') === '0' && blank($edu['school_year_attended'])) {
                $this->addError("educations.$level.school_year_attended", 'School year attended is required.');
                return;
            }
        }

        DB::transaction(function () use ($user, $validated) {
            $occupation = isset($validated['occupation']) ? trim((string) $validated['occupation']) : '';

            $alumniData = [
                'prefix'     => filled($validated['prefix'] ?? null) ? trim($validated['prefix']) : null,
                'fname'      => trim($validated['first_name']),
                'mname'      => filled($validated['middle_name'] ?? null) ? trim($validated['middle_name']) : null,
                'lname'      => trim($validated['last_name']),
                'suffix'     => filled($validated['suffix'] ?? null) ? trim($validated['suffix']) : null,
                'cellphone'  => trim($validated['cellphone']),
                'occupation' => $occupation !== '' ? $occupation : null,

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

            if ($validated['email'] !== $user->email) {
                $user->forceFill([
                    'email'             => trim($validated['email']),
                    'email_verified_at' => null,
                ])->save();
            }

            $this->syncEducations($alumni);
            $this->syncCommitteeInterest($user, $alumni);
        });

        $this->refreshCommitteeState((int) $user->id);
        $this->dispatch('profile-updated');
    }

    protected function syncEducations(Alumni $alumni): void
    {
        foreach (['elementary', 'highschool', 'college'] as $level) {
            $edu     = $this->educations[$level];
            $enabled = (bool) ($edu['enabled'] ?? false);

            if (! $enabled) {
                AlumniEducation::query()
                    ->where('alumni_id', $alumni->id)
                    ->whereHas('batch', fn ($q) => $q->where('level', $level))
                    ->delete();
                continue;
            }

            $batchId     = (int) ($edu['batch_id'] ?? 0);
            $didGraduate = ($edu['did_graduate'] ?? '1') === '1';
            $schoolYear  = $didGraduate ? null : (trim($edu['school_year_attended'] ?? '') ?: null);

            $existing = AlumniEducation::query()
                ->where('alumni_id', $alumni->id)
                ->whereHas('batch', fn ($q) => $q->where('level', $level))
                ->first();

            if ($existing) {
                $existing->update([
                    'batch_id'             => $batchId,
                    'did_graduate'         => $didGraduate,
                    'school_year_attended' => $schoolYear,
                ]);
            } else {
                AlumniEducation::create([
                    'alumni_id'            => $alumni->id,
                    'batch_id'             => $batchId,
                    'did_graduate'         => $didGraduate,
                    'school_year_attended' => $schoolYear,
                    'is_batch_rep'         => false,
                ]);
            }
        }
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
                    $signup->update(['notes' => $notes]);
                }
                continue;
            }

            VolunteerSignup::create([
                'user_id'      => $user->id,
                'alumni_id'    => $alumni->id,
                'committee_id' => $committeeId,
                'notes'        => $notes,
                'status'       => 'pending',
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
            $this->savedCommitteeItems  = [];
            $this->selectedCommitteeIds = [];
            $this->volunteer_notes      = '';
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
            ->map(fn ($s) => [
                'id'     => (string) $s->committee_id,
                'name'   => (string) $s->committee_name,
                'status' => (string) $s->status,
            ])
            ->values()
            ->all();

        $this->selectedCommitteeIds = $signups
            ->pluck('committee_id')
            ->map(fn ($id) => (string) $id)
            ->values()
            ->all();

        $this->volunteer_notes      = (string) ($signups->pluck('notes')->filter()->first() ?? '');
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
            'approved'  => 'border-emerald-400/20 bg-emerald-400/10 text-emerald-300',
            'contacted' => 'border-sky-400/20 bg-sky-400/10 text-sky-300',
            'declined'  => 'border-rose-400/20 bg-rose-400/10 text-rose-300',
            default     => 'border-amber-400/20 bg-amber-400/10 text-amber-300',
        };
    }
};
?>
{{-- bg-[#f7f5f1] --}}
<section class="min-h-screen w-full  px-4 py-8 sm:px-6 lg:px-8">
    <flux:heading class="sr-only">{{ __('Profile Settings') }}</flux:heading>

    <div class="mb-7">
        <p class="mb-1 text-[10px] font-semibold uppercase tracking-[.2em] text-[#b88a3d]">Account</p>
        <h1 class="font-serif text-[28px] font-normal leading-tight text-[#091852] sm:text-[32px]">Profile Settings</h1>
        <p class="mt-1 text-sm text-[#7a7060]">Manage your alumni information and reunion participation.</p>
    </div>

    <form wire:submit="updateProfileInformation" class="w-full max-w-4xl space-y-5">

        {{-- Tab Navigation --}}
        <div class="flex gap-1 rounded-2xl bg-[#ede9e0] p-1.5">
            @foreach ([
                'profile'   => ['svg' => '<circle cx="10" cy="7" r="3"/><path d="M4 17c0-3.314 2.686-6 6-6s6 2.686 6 6"/>', 'label' => 'Personal'],
                'education' => ['svg' => '<path d="M10 14l7-4-7-4-7 4 7 4zm0 0l4.95-2.75A9.5 9.5 0 0115.5 16a9.5 9.5 0 01-5.5 1.6A9.5 9.5 0 014.5 16a9.5 9.5 0 01.55-4.75L10 14z"/>', 'label' => 'Education'],
                'address'   => ['svg' => '<path d="M10 2C7.239 2 5 4.239 5 7c0 4.418 5 11 5 11s5-6.582 5-11c0-2.761-2.239-5-5-5z"/><circle cx="10" cy="7" r="1.5"/>', 'label' => 'Address'],
                'committee' => ['svg' => '<path d="M3 5h14M3 10h14M3 15h8"/>', 'label' => 'Committee'],
            ] as $tab => $meta)
                <button
                    type="button"
                    wire:click="$set('activeTab', '{{ $tab }}')"
                    @class([
                        'flex flex-1 items-center justify-center gap-2 rounded-xl px-3 py-2.5 text-[12px] font-medium transition-all duration-150',
                        'bg-white text-[#091852] shadow-sm'                          => $activeTab === $tab,
                        'text-[#7a7060] hover:bg-white/50 hover:text-[#1a1410]'     => $activeTab !== $tab,
                    ])
                >
                    <svg class="h-3.5 w-3.5 shrink-0" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.6">
                        {!! $meta['svg'] !!}
                    </svg>
                    <span class="hidden sm:inline">{{ $meta['label'] }}</span>
                </button>
            @endforeach
        </div>

        {{-- ── PERSONAL TAB ── --}}
        @if ($activeTab === 'profile')
            <div class="overflow-hidden rounded-[20px] border border-[#e8e2d6] bg-white">
                <div class="flex items-center gap-3.5 border-b border-[#f0ebe1] px-5 py-4 sm:px-6">
                    <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-[10px] bg-[#faf4e6]">
                        <svg class="h-4.5 w-4.5 text-[#b88a3d]" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.6">
                            <circle cx="10" cy="7" r="3"/><path d="M4 17c0-3.314 2.686-6 6-6s6 2.686 6 6"/>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-[15px] font-medium text-[#1a1410]">Personal Information</h3>
                        <p class="mt-0.5 text-xs text-[#9a9080]">Your name, contact, and account details</p>
                    </div>
                    <button
                        type="submit"
                        class="inline-flex items-center gap-1.5 rounded-[9px] bg-[#d4b06a] px-3.5 py-2 text-xs font-medium text-[#091852] transition hover:bg-[#c9a458] active:scale-[.97]"
                    >
                        <svg class="h-3.5 w-3.5" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.8">
                            <path d="M4 13V16h3l9-9-3-3-9 9zM14.5 4.5l1 1"/>
                        </svg>
                        Save
                    </button>
                </div>

                <div class="space-y-4 px-5 py-5 sm:px-6">
                    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                        <div>
                            <label class="mb-1.5 block text-[11px] font-semibold uppercase tracking-[.06em] text-[#9a9080]">Prefix</label>
                            <select
                                wire:model="prefix"
                                class="w-full rounded-[10px] border border-[#e0dbd0] bg-[#faf9f7] px-3.5 py-2.5 text-sm text-[#1a1410] outline-none transition focus:border-[#d4b06a] focus:bg-white focus:ring-0"
                            >
                                <option value="">Select prefix</option>
                                @foreach ($prefixOptions as $option)
                                    <option value="{{ $option }}">{{ $option }}</option>
                                @endforeach
                            </select>
                            @error('prefix') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                        </div>

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
                            <label class="mb-1.5 block text-[11px] font-semibold uppercase tracking-[.06em] text-[#9a9080]">Middle Name</label>
                            <input
                                wire:model="middle_name"
                                type="text"
                                autocomplete="additional-name"
                                class="w-full rounded-[10px] border border-[#e0dbd0] bg-[#faf9f7] px-3.5 py-2.5 text-sm text-[#1a1410] outline-none transition focus:border-[#d4b06a] focus:bg-white focus:ring-0"
                            />
                            @error('middle_name') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
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

                    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                        <div>
                            <label class="mb-1.5 block text-[11px] font-semibold uppercase tracking-[.06em] text-[#9a9080]">Suffix</label>
                            <select
                                wire:model="suffix"
                                class="w-full rounded-[10px] border border-[#e0dbd0] bg-[#faf9f7] px-3.5 py-2.5 text-sm text-[#1a1410] outline-none transition focus:border-[#d4b06a] focus:bg-white focus:ring-0"
                            >
                                <option value="">Select suffix</option>
                                @foreach ($suffixOptions as $option)
                                    <option value="{{ $option }}">{{ $option }}</option>
                                @endforeach
                            </select>
                            @error('suffix') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="mb-1.5 block text-[11px] font-semibold uppercase tracking-[.06em] text-[#9a9080]">Cellphone #</label>
                            <input
                                wire:model="cellphone"
                                type="text"
                                required
                                autocomplete="tel"
                                placeholder="e.g. 09171234567"
                                class="w-full rounded-[10px] border border-[#e0dbd0] bg-[#faf9f7] px-3.5 py-2.5 text-sm text-[#1a1410] outline-none transition placeholder:text-[#c0bbb0] focus:border-[#d4b06a] focus:bg-white focus:ring-0"
                            />
                            @error('cellphone') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                        </div>

                        <div class="sm:col-span-2">
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

                    <div>
                        <label class="mb-1.5 block text-[11px] font-semibold uppercase tracking-[.06em] text-[#9a9080]">Occupation</label>
                        <input
                            wire:model="occupation"
                            type="text"
                            placeholder="e.g. Teacher, Engineer, Nurse, Business Owner"
                            autocomplete="organization-title"
                            class="w-full rounded-[10px] border border-[#e0dbd0] bg-[#faf9f7] px-3.5 py-2.5 text-sm text-[#1a1410] outline-none transition placeholder:text-[#c0bbb0] focus:border-[#d4b06a] focus:bg-white focus:ring-0"
                        />
                        @error('occupation') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
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
        @endif

        {{-- ── EDUCATION TAB ── --}}
        @if ($activeTab === 'education')
            <div class="overflow-hidden rounded-[20px] border border-[#e8e2d6] bg-white">
                <div class="flex items-center gap-3.5 border-b border-[#f0ebe1] px-5 py-4 sm:px-6">
                    <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-[10px] bg-[#faf4e6]">
                        <svg class="h-4.5 w-4.5 text-[#b88a3d]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
                            <path d="M12 14l9-5-9-5-9 5 9 5z"/>
                            <path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-[15px] font-medium text-[#1a1410]">Education Background</h3>
                        <p class="mt-0.5 text-xs text-[#9a9080]">Select the level(s) you attended at HSST</p>
                    </div>
                    <button
                        type="submit"
                        class="inline-flex items-center gap-1.5 rounded-[9px] bg-[#d4b06a] px-3.5 py-2 text-xs font-medium text-[#091852] transition hover:bg-[#c9a458] active:scale-[.97]"
                    >
                        <svg class="h-3.5 w-3.5" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.8">
                            <path d="M4 13V16h3l9-9-3-3-9 9zM14.5 4.5l1 1"/>
                        </svg>
                        Save
                    </button>
                </div>

                <div class="space-y-4 px-5 py-5 sm:px-6">
                    <p class="text-xs text-[#9a9080]">
                        Enable each level you attended at HSST. You may belong to Elementary, High School, College, or multiple levels.
                    </p>

                    @error('educations')
                        <p class="rounded-[10px] border border-rose-200 bg-rose-50 px-4 py-2.5 text-sm text-rose-600">{{ $message }}</p>
                    @enderror

                    @foreach (['elementary' => 'Elementary', 'highschool' => 'High School', 'college' => 'College'] as $level => $label)
                        <div class="overflow-hidden rounded-[14px] border @if($educations[$level]['enabled']) border-[#d4b06a] @else border-[#e0dbd0] @endif transition-colors">
                            {{-- Level toggle header --}}
                            <label @class([
                                'flex cursor-pointer items-center gap-3.5 px-4 py-3.5 transition',
                                'bg-[#faf4e6]' => $educations[$level]['enabled'],
                                'bg-[#faf9f7]' => ! $educations[$level]['enabled'],
                            ])>
                                <div class="relative shrink-0">
                                    <input
                                        wire:model.live="educations.{{ $level }}.enabled"
                                        type="checkbox"
                                        value="1"
                                        class="sr-only peer"
                                    />
                                    <div class="h-5 w-9 rounded-full border border-[#d0c8bc] bg-white transition peer-checked:border-[#d4b06a] peer-checked:bg-[#d4b06a]"></div>
                                    <div class="absolute left-0.5 top-0.5 h-4 w-4 rounded-full bg-[#b0ab9e] shadow-sm transition-all peer-checked:translate-x-4 peer-checked:bg-white"></div>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-[#1a1410]">{{ $label }}</p>
                                    <p class="text-xs text-[#9a9080]">
                                        @if ($educations[$level]['enabled'])
                                            Active - fill in your batch details below
                                        @else
                                            Toggle to add your {{ strtolower($label) }} record
                                        @endif
                                    </p>
                                </div>
                                @if ($educations[$level]['enabled'])
                                    <span class="ml-auto shrink-0 inline-flex items-center gap-1 rounded-full border border-emerald-200 bg-emerald-50 px-2.5 py-0.5 text-[10px] font-semibold uppercase tracking-wide text-emerald-700">
                                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                        Active
                                    </span>
                                @endif
                            </label>

                            @if ($educations[$level]['enabled'])
                                <div class="border-t border-[#f0ebe1] bg-white px-4 py-4 space-y-4">
                                    {{-- Did you graduate? --}}
                                    <div>
                                        <label class="mb-2 block text-[11px] font-semibold uppercase tracking-[.06em] text-[#9a9080]">
                                            Did you graduate at this level?
                                        </label>
                                        <div class="flex gap-3">
                                            <label class="flex items-center gap-2 rounded-[10px] border border-[#e0dbd0] bg-[#faf9f7] px-4 py-2.5 cursor-pointer transition hover:border-[#d4b06a]/50">
                                                <input
                                                    wire:model.live="educations.{{ $level }}.did_graduate"
                                                    type="radio"
                                                    value="1"
                                                    class="h-4 w-4 border-slate-300 text-[#d4b06a] focus:ring-[#d4b06a]"
                                                />
                                                <span class="text-sm font-medium text-[#1a1410]">Yes</span>
                                            </label>
                                            <label class="flex items-center gap-2 rounded-[10px] border border-[#e0dbd0] bg-[#faf9f7] px-4 py-2.5 cursor-pointer transition hover:border-[#d4b06a]/50">
                                                <input
                                                    wire:model.live="educations.{{ $level }}.did_graduate"
                                                    type="radio"
                                                    value="0"
                                                    class="h-4 w-4 border-slate-300 text-[#d4b06a] focus:ring-[#d4b06a]"
                                                />
                                                <span class="text-sm font-medium text-[#1a1410]">No</span>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="grid gap-4 sm:grid-cols-2">
                                        {{-- Batch select --}}
                                        <div>
                                            <label class="mb-1.5 block text-[11px] font-semibold uppercase tracking-[.06em] text-[#9a9080]">
                                                @if ($educations[$level]['did_graduate'] === '1')
                                                    Graduation Year
                                                @else
                                                    Batch / Year
                                                @endif
                                            </label>
                                            <select
                                                wire:model.live="educations.{{ $level }}.batch_id"
                                                class="w-full rounded-[10px] border border-[#e0dbd0] bg-[#faf9f7] px-3.5 py-2.5 text-sm text-[#1a1410] outline-none transition focus:border-[#d4b06a] focus:bg-white focus:ring-0"
                                            >
                                                <option value="">-- Select batch --</option>
                                                @foreach ($batchesByLevel[$level] as $batch)
                                                    <option value="{{ $batch['id'] }}" @selected((string)$educations[$level]['batch_id'] === (string)$batch['id'])>
                                                        {{ strtoupper($label) }} • {{ $batch['schoolyear'] }} • Grad {{ $batch['yeargrad'] }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error("educations.$level.batch_id")
                                                <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        {{-- School year display / attended input --}}
                                        @if ($educations[$level]['did_graduate'] === '1')
                                            <div>
                                                <label class="mb-1.5 block text-[11px] font-semibold uppercase tracking-[.06em] text-[#9a9080]">School Year</label>
                                                <input
                                                    type="text"
                                                    value="{{ $educations[$level]['schoolyear'] }}"
                                                    readonly
                                                    class="w-full cursor-not-allowed rounded-[10px] border border-[#e0dbd0] bg-[#f5f3ef] px-3.5 py-2.5 text-sm text-[#9a9080] outline-none"
                                                />
                                            </div>
                                        @else
                                            <div>
                                                <label class="mb-1.5 block text-[11px] font-semibold uppercase tracking-[.06em] text-[#9a9080]">School Year Attended</label>
                                                <input
                                                    wire:model="educations.{{ $level }}.school_year_attended"
                                                    type="text"
                                                    placeholder="e.g. 2012-2014"
                                                    class="w-full rounded-[10px] border border-[#e0dbd0] bg-[#faf9f7] px-3.5 py-2.5 text-sm text-[#1a1410] outline-none transition placeholder:text-[#c0bbb0] focus:border-[#d4b06a] focus:bg-white focus:ring-0"
                                                />
                                                <p class="mt-1 text-xs text-[#9a9080]">Example: 2012-2014</p>
                                                @error("educations.$level.school_year_attended")
                                                    <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- ── ADDRESS TAB ── --}}
        @if ($activeTab === 'address')
            <div class="overflow-hidden rounded-[20px] border border-[#e8e2d6] bg-white">
                <div class="flex items-center gap-3.5 border-b border-[#f0ebe1] px-5 py-4 sm:px-6">
                    <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-[10px] bg-[#faf4e6]">
                        <svg class="h-4.5 w-4.5 text-[#b88a3d]" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.6">
                            <path d="M10 2C7.239 2 5 4.239 5 7c0 4.418 5 11 5 11s5-6.582 5-11c0-2.761-2.239-5-5-5z"/><circle cx="10" cy="7" r="1.5"/>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-[15px] font-medium text-[#1a1410]">Address Details</h3>
                        <p class="mt-0.5 text-xs text-[#9a9080]">Keep your address updated for communication and records</p>
                    </div>
                    <button
                        type="submit"
                        class="inline-flex items-center gap-1.5 rounded-[9px] bg-[#d4b06a] px-3.5 py-2 text-xs font-medium text-[#091852] transition hover:bg-[#c9a458] active:scale-[.97]"
                    >
                        <svg class="h-3.5 w-3.5" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.8">
                            <path d="M4 13V16h3l9-9-3-3-9 9zM14.5 4.5l1 1"/>
                        </svg>
                        Save
                    </button>
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
                        @error('address_line_2') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
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
                            @error('postal_code') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
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

        {{-- ── COMMITTEE TAB ── --}}
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

                    <div class="flex items-center gap-2">
                        @if ($hasCommitteeInterest)
                            <span class="hidden sm:inline-flex items-center gap-1.5 rounded-full border border-emerald-200 bg-emerald-50 px-3 py-1 text-[11px] font-semibold uppercase tracking-wide text-emerald-800">
                                <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                Submitted
                            </span>
                        @else
                            <span class="hidden sm:inline-flex items-center gap-1.5 rounded-full border border-[#f0d496] bg-[#faf4e6] px-3 py-1 text-[11px] font-semibold uppercase tracking-wide text-[#92601c]">
                                <span class="h-1.5 w-1.5 rounded-full bg-[#d4a017]"></span>
                                None yet
                            </span>
                        @endif

                        <button
                            type="submit"
                            class="inline-flex items-center gap-1.5 rounded-[9px] bg-[#d4b06a] px-3.5 py-2 text-xs font-medium text-[#091852] transition hover:bg-[#c9a458] active:scale-[.97]"
                        >
                            <svg class="h-3.5 w-3.5" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.8">
                                <path d="M4 13V16h3l9-9-3-3-9 9zM14.5 4.5l1 1"/>
                            </svg>
                            Save
                        </button>
                    </div>
                </div>

                <div class="space-y-5 px-5 py-5 sm:px-6">
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

                    <div>
                        <p class="text-sm font-medium text-[#1a1410]">Select committee(s)</p>
                        <p class="mt-0.5 text-xs text-[#9a9080]">You may choose more than one. Pending selections can still be updated later.</p>
                    </div>

                    <div class="grid gap-2.5 sm:grid-cols-2 xl:grid-cols-3">
                        @foreach ($committeeOptions as $committee)
                            <label @class([
                                'group relative flex min-h-[80px] cursor-pointer rounded-[14px] border p-3.5 transition-all duration-150',
                                'border-[#d4b06a] bg-white ring-2 ring-[#d4b06a]/20'                     => in_array($committee['id'], $selectedCommitteeIds ?? []),
                                'border-[#e0dbd0] bg-[#faf9f7] hover:border-[#d4b06a]/50 hover:bg-white' => ! in_array($committee['id'], $selectedCommitteeIds ?? []),
                            ])>
                                <input
                                    type="checkbox"
                                    wire:model.live="selectedCommitteeIds"
                                    value="{{ $committee['id'] }}"
                                    class="peer sr-only"
                                >

                                <div class="flex items-start gap-3">
                                    <div @class([
                                        'mt-0.5 flex h-5 w-5 shrink-0 items-center justify-center rounded-[6px] border transition-all duration-150',
                                        'border-[#d4b06a] bg-[#d4b06a]' => in_array($committee['id'], $selectedCommitteeIds ?? []),
                                        'border-[#d0c8bc] bg-white'     => ! in_array($committee['id'], $selectedCommitteeIds ?? []),
                                    ])>
                                        <svg @class([
                                            'h-3 w-3 text-white transition-opacity',
                                            'opacity-100' => in_array($committee['id'], $selectedCommitteeIds ?? []),
                                            'opacity-0'   => ! in_array($committee['id'], $selectedCommitteeIds ?? []),
                                        ]) viewBox="0 0 12 10" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                            <polyline points="1,5 4,8 11,1"/>
                                        </svg>
                                    </div>

                                    <div class="min-w-0">
                                        <p class="text-[13px] font-medium leading-5 text-[#1a1410]">{{ $committee['name'] }}</p>
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
                            @error('volunteer_notes') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
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

        {{-- ── BOTTOM PANEL ── --}}
        <div class="grid gap-4 lg:grid-cols-[1.35fr_0.85fr]">
            {{-- Account & Security --}}
            <div class="overflow-hidden rounded-[20px] border border-[#e8e2d6] bg-white">
                <div class="border-b border-[#f0ebe1] px-5 py-4 sm:px-6">
                    <p class="text-[11px] font-semibold uppercase tracking-[.18em] text-[#b88a3d]">Account & Security</p>
                    <h3 class="mt-1 text-[17px] font-medium text-[#1a1410]">Keep your account updated</h3>
                    <p class="mt-1 text-sm leading-6 text-[#7a7060]">
                        Review your alumni details, education records, and password before reunion activities begin.
                    </p>
                </div>

                <div class="flex flex-col gap-4 px-5 py-5 sm:px-6">
                    <div class="flex items-start gap-3 rounded-[16px] border border-[#f0ebe1] bg-[#faf9f7] p-4">
                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-[12px] bg-[#faf4e6]">
                            <svg class="h-4.5 w-4.5 text-[#b88a3d]" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.6">
                                <path d="M10 6V4a3 3 0 1 0-6 0v2"/>
                                <rect x="3" y="6" width="14" height="11" rx="2"/>
                            </svg>
                        </div>
                        <div class="min-w-0 flex-1">
                            <p class="text-sm font-medium text-[#1a1410]">Password & Security</p>
                            <p class="mt-1 text-xs leading-5 text-[#9a9080]">
                                Change your password anytime to keep your reunion account secure.
                            </p>
                        </div>
                    </div>

                    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                        <p class="text-xs leading-5 text-[#9a9080]">
                            Use a password that is easy for you to remember but hard for others to guess.
                        </p>
                        <div class="flex shrink-0 gap-2">
                            <a
                                href="{{ route('password-help.edit') }}"
                                wire:navigate
                                class="inline-flex items-center justify-center gap-2 rounded-[10px] border border-[#e0dbd0] bg-[#faf9f7] px-4 py-2.5 text-sm font-medium text-[#7a7060] transition hover:bg-[#f5f3ef]"
                            >
                                Password Help
                            </a>
                            <a
                                href="{{ route('user-password.edit') }}"
                                wire:navigate
                                class="inline-flex items-center justify-center gap-2 rounded-[10px] border border-[#d4b06a] bg-[#faf4e6] px-4 py-2.5 text-sm font-medium text-[#091852] transition hover:bg-[#f5ecd7]"
                            >
                                <svg class="h-4 w-4" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.6">
                                    <path d="M4 13V16h3l9-9-3-3-9 9zM14.5 4.5l1 1"/>
                                </svg>
                                Change Password
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Save panel --}}
            <div class="overflow-hidden rounded-[20px] border border-[#e8e2d6] bg-white">
                <div class="border-b border-[#f0ebe1] px-5 py-4 sm:px-6">
                    <p class="text-[11px] font-semibold uppercase tracking-[.18em] text-[#b88a3d]">Save Updates</p>
                    <h3 class="mt-1 text-[17px] font-medium text-[#1a1410]">Apply your changes</h3>
                    <p class="mt-1 text-sm leading-6 text-[#7a7060]">
                        Save any updates to your profile, education, address, or committee details.
                    </p>
                </div>

                <div class="flex h-full flex-col justify-between gap-5 px-5 py-5 sm:px-6">
                    <div class="rounded-[16px] border border-dashed border-[#ddd6c8] bg-[#faf9f7] px-4 py-4">
                        <x-action-message class="text-sm font-medium text-emerald-600" on="profile-updated">
                            {{ __('Changes saved successfully.') }}
                        </x-action-message>
                        <p class="text-xs leading-5 text-[#9a9080]">
                            Make sure all information is correct before saving.
                        </p>
                    </div>

                    <button
                        type="submit"
                        data-test="update-profile-button"
                        class="inline-flex w-full items-center justify-center gap-2 rounded-[12px] bg-[#d4b06a] px-5 py-3 text-sm font-medium text-[#091852] transition hover:bg-[#c9a458] active:scale-[.98]"
                    >
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
