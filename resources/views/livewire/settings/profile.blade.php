<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Livewire\Volt\Component;
use App\Models\Alumni;
use App\Models\Batch;

new class extends Component {
    public string $username = '';
    public string $email = '';
    public string $first_name = '';
    public string $middle_name = '';
    public string $last_name = '';
    public string $schoolyear = '';
    public string $yeargrad = '';
    public array $yeargradOptions = [];

    /**
     * Mount the component.
     */
    public function mount(): void
{
    $user = Auth::user();

    $this->username = $user->username;
    $this->email = $user->email;

    // Build year options (adjust range as you like)
    $currentYear = (int) now()->format('Y');
    $startYear = $currentYear - 126; // last 60 years
    $endYear = $currentYear;        // up to current year

    $this->yeargradOptions = array_reverse(range($startYear, $endYear));

    if ($user->alumni) {
        $this->first_name = $user->alumni->fname ?? '';
        $this->middle_name = $user->alumni->mname ?? '';
        $this->last_name = $user->alumni->lname ?? '';

        $this->yeargrad = (string) ($user->alumni->batch->yeargrad ?? '');

        // auto-fill schoolyear display
        if ($this->yeargrad !== '') {
            $yg = (int) $this->yeargrad;
            $this->schoolyear = ($yg - 1) . '-' . $yg;
        }
    }
}
public function updatedYeargrad($value): void
{
    if (blank($value)) {
        $this->schoolyear = '';
        return;
    }

    $yg = (int) $value;
    $this->schoolyear = ($yg - 1) . '-' . $yg; // "2017-2018"
}
    /**
     * Update the profile information for the currently authenticated user.
     */
   public function updateProfileInformation(): void
{
    $user = Auth::user();

    $validated = $this->validate([
    'first_name' => ['required', 'string', 'max:255'],
    'middle_name' => ['nullable', 'string', 'max:255'],
    'last_name' => ['required', 'string', 'max:255'],

    'yeargrad' => ['required', 'integer', 'min:1900', 'max:' . now()->format('Y')],
    
]);
 $yeargrad = (int) $validated['yeargrad'];
$schoolyear = ($yeargrad - 1) . '-' . $yeargrad;
    // 1) Find or create batch (based on schoolyear + yeargrad)
   $batch = Batch::firstOrCreate(
    ['yeargrad' => $yeargrad], // UNIQUE on yeargrad is ideal now
    ['schoolyear' => $schoolyear]
);

    // 2) Create or update Alumni record
    if ($user->alumni) {
        $user->alumni->update([
            'fname' => $validated['first_name'],
            'mname' => $validated['middle_name'] ?? null,
            'lname' => $validated['last_name'],
            'batch_id' => $batch->id,
        ]);
    } else {
        $alumni = Alumni::create([
            'fname' => $validated['first_name'],
            'mname' => $validated['middle_name'] ?? null,
            'lname' => $validated['last_name'],
            'batch_id' => $batch->id,
            'is_batch_rep' => false,
        ]);

        // 3) Link user to alumni
        $user->update(['alumni_id' => $alumni->id]);
    }

    $this->dispatch('profile-updated');
}

    /**
     * Send an email verification notification to the current user.
     */
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
}; ?>

<section class="w-full">
    @include('partials.settings-heading')

    <flux:heading class="sr-only">{{ __('Profile Settings') }}</flux:heading>

    <x-settings.layout :heading="__('Profile')" :subheading="__('Update your Profile information')">
     <form wire:submit="updateProfileInformation" class="my-6 w-full space-y-6">
    {{-- Inputs --}}
    <flux:input
        wire:model="first_name"
        :label="__('First Name')"
        type="text"
        required
        autocomplete="given-name"
    />

    <flux:input
        wire:model="middle_name"
        :label="__('Middle Name')"
        type="text"
        autocomplete="additional-name"
    />

    <flux:input
        wire:model="last_name"
        :label="__('Last Name')"
        type="text"
        required
        autocomplete="family-name"
    />

    {{-- Year Grad --}}
    <flux:select
        wire:model="yeargrad"
        :label="__('Year Graduated')"
        required
    >
        <option value="">-- Select year --</option>
        @foreach ($yeargradOptions as $year)
            <option value="{{ $year }}">{{ $year }}</option>
        @endforeach
    </flux:select>

    {{-- Auto School Year (readonly) --}}
    <flux:input
        wire:model="schoolyear"
        :label="__('School Year')"
        type="text"
        readonly
    />

    {{-- Email + verification --}}
    <div class="space-y-4">
        <flux:input
            wire:model="email"
            :label="__('Email')"
            type="email"
            required
            autocomplete="email"
        />

        @if (auth()->user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! auth()->user()->hasVerifiedEmail())
            <div class="space-y-2">
                <flux:text>
                    {{ __('Your email address is unverified.') }}
                    <flux:link class="text-sm cursor-pointer" wire:click.prevent="resendVerificationNotification">
                        {{ __('Click here to re-send the verification email.') }}
                    </flux:link>
                </flux:text>

                @if (session('status') === 'verification-link-sent')
                    <flux:text class="font-medium !dark:text-green-400 !text-green-600">
                        {{ __('A new verification link has been sent to your email address.') }}
                    </flux:text>
                @endif
            </div>
        @endif
    </div>

    {{-- Actions --}}
    <div class="flex items-center gap-4">
        <flux:button variant="primary" type="submit" class="w-full sm:w-auto" data-test="update-profile-button">
            {{ __('Save') }}
        </flux:button>

        <x-action-message class="me-3" on="profile-updated">
            {{ __('Saved.') }}
        </x-action-message>
    </div>
</form>

        <livewire:settings.delete-user-form />
    </x-settings.layout>
</section>
