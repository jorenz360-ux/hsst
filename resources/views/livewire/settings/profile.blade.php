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

    public string $schoolyear = '';
    public string $yeargrad = '';
    public array $yeargradOptions = [];

    public string $address_line_1 = '';
    public string $address_line_2 = '';
    public string $city = '';
    public string $state_province = '';
    public string $postal_code = '';
    public string $country = '';

    public function mount(): void
    {
        $user = Auth::user()?->loadMissing('alumni.batch');

        $this->username = (string) ($user->username ?? '');
        $this->email = (string) ($user->email ?? '');

        $currentYear = (int) now()->year;
        $startYear = $currentYear - 126;
        $this->yeargradOptions = array_reverse(range($startYear, $currentYear));

        $alumni = $user?->alumni;

        if (! $alumni) {
            $this->country = 'Philippines';
            return;
        }

        $this->first_name = (string) ($alumni->fname ?? '');
        $this->middle_name = (string) ($alumni->mname ?? '');
        $this->last_name = (string) ($alumni->lname ?? '');

        $this->yeargrad = (string) ($alumni->batch?->yeargrad ?? '');
        $this->schoolyear = $this->yeargrad !== ''
            ? ((int) $this->yeargrad - 1) . '-' . (int) $this->yeargrad
            : '';

        $this->address_line_1 = (string) ($alumni->address_line_1 ?? '');
        $this->address_line_2 = (string) ($alumni->address_line_2 ?? '');
        $this->city = (string) ($alumni->city ?? '');
        $this->state_province = (string) ($alumni->state_province ?? '');
        $this->postal_code = (string) ($alumni->postal_code ?? '');
        $this->country = (string) ($alumni->country ?? 'Philippines');
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
            'first_name' => ['required', 'string', 'max:255'],
            'middle_name' => ['nullable', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],

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
            'city' => ['required', 'string', 'max:120'],
            'state_province' => ['required', 'string', 'max:120'],
            'postal_code' => ['nullable', 'string', 'max:30'],
            'country' => ['required', 'string', 'max:100'],
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

            $alumniData = [
                'fname' => trim($validated['first_name']),
                'mname' => filled($validated['middle_name'] ?? null) ? trim($validated['middle_name']) : null,
                'lname' => trim($validated['last_name']),
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
        });

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

<section class="w-full p-6 sm:p-8">
    @include('partials.settings-heading')

    <flux:heading class="sr-only">{{ __('Profile Settings') }}</flux:heading>

    <x-settings.layout :heading="__('Profile')" :subheading="__('Update your profile and address information')">
        <form wire:submit="updateProfileInformation" class="my-6 w-full space-y-6">
            <div class="border-b border-white/10 px-4 py-4 sm:px-6">
                <div class="flex flex-wrap items-center gap-2">
                    <button
                        type="button"
                        wire:click="$set('activeTab', 'profile')"
                        class="inline-flex items-center px-4 py-2 text-sm font-medium transition"
                        @class([
                            'bg-[#c6a56b] text-black' => $activeTab === 'profile',
                            'bg-white/5 text-white hover:bg-white/10' => $activeTab !== 'profile',
                        ])
                    >
                        Personal Info
                    </button>

                    <button
                        type="button"
                        wire:click="$set('activeTab', 'address')"
                        class="inline-flex items-center px-4 py-2 text-sm font-medium transition"
                        @class([
                            'bg-[#c6a56b] text-black' => $activeTab === 'address',
                            'bg-white/5 text-white hover:bg-white/10' => $activeTab !== 'address',
                        ])
                    >
                        Address
                    </button>
                </div>
            </div>

            <div class="px-4 py-5 sm:px-6 sm:py-6">
                @if ($activeTab === 'profile')
                    <div class="space-y-6">
                        <div class="grid gap-4 md:grid-cols-2">
                            <flux:input
                                wire:model="first_name"
                                :label="__('First Name')"
                                type="text"
                                required
                                autocomplete="given-name"
                            />

                            <flux:input
                                wire:model="last_name"
                                :label="__('Last Name')"
                                type="text"
                                required
                                autocomplete="family-name"
                            />
                        </div>

                        <div class="grid gap-4 md:grid-cols-2">
                            <flux:input
                                wire:model="middle_name"
                                :label="__('Middle Name')"
                                type="text"
                                autocomplete="additional-name"
                            />

                            <flux:input
                                wire:model="email"
                                :label="__('Email')"
                                type="email"
                                required
                                autocomplete="email"
                            />
                        </div>

                        <div class="grid gap-4 md:grid-cols-2">
                            <flux:select
                                wire:model.live="yeargrad"
                                :label="__('Year Graduated')"
                                required
                            >
                                <option value="">-- Select year --</option>
                                @foreach ($yeargradOptions as $year)
                                    <option value="{{ $year }}">{{ $year }}</option>
                                @endforeach
                            </flux:select>

                            <flux:input
                                wire:model="schoolyear"
                                :label="__('School Year')"
                                type="text"
                                readonly
                            />
                        </div>

                        @if (auth()->user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! auth()->user()->hasVerifiedEmail())
                            <div class="border border-amber-500/20 bg-amber-500/10 p-4 text-sm">
                                <flux:text>
                                    {{ __('Your email address is unverified.') }}
                                    <flux:link class="cursor-pointer text-sm" wire:click.prevent="resendVerificationNotification">
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

                @if ($activeTab === 'address')
                    <div class="space-y-6">
                        <div class="grid gap-4">
                            <flux:textarea
                                wire:model="address_line_1"
                                :label="__('Address Line 1')"
                                rows="3"
                                required
                            />

                            <flux:input
                                wire:model="address_line_2"
                                :label="__('Address Line 2')"
                                type="text"
                            />
                        </div>

                        <div class="grid gap-4 md:grid-cols-2">
                            <flux:input
                                wire:model="city"
                                :label="__('City / Municipality')"
                                type="text"
                                required
                            />

                            <flux:input
                                wire:model="state_province"
                                :label="__('Province / State / Region')"
                                type="text"
                                required
                            />
                        </div>

                        <div class="grid gap-4 md:grid-cols-2">
                            <flux:input
                                wire:model="postal_code"
                                :label="__('Postal / ZIP Code')"
                                type="text"
                            />

                            <flux:input
                                wire:model="country"
                                :label="__('Country')"
                                type="text"
                                required
                            />
                        </div>
                    </div>
                @endif
            </div>

            <div class="flex items-center gap-4">
                <flux:button variant="primary" type="submit" class="w-full sm:w-auto" data-test="update-profile-button">
                    {{ __('Save Changes') }}
                </flux:button>

                <x-action-message class="me-3" on="profile-updated">
                    {{ __('Saved.') }}
                </x-action-message>
            </div>
        </form>

        <livewire:settings.delete-user-form />
    </x-settings.layout>
</section>