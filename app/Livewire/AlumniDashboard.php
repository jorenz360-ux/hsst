<?php

namespace App\Livewire;

use App\Models\Announcement;
use App\Models\Donation;
use App\Models\Event;
use App\Models\EventRegistration;
use App\Models\Payment;
use App\Services\PayMongoService;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class AlumniDashboard extends Component
{
    public array $myEventRegs = [];

    public int $paidTotal = 0;          // centavos
    public ?string $lastPaidAt = null;
    public ?int $lastPaidAmount = null; // centavos

    public Collection $latestAnnouncements;
    public Collection $upcomingEvents;

    public function mount(): void
    {
        $alumniId = $this->alumniId();

        $this->latestAnnouncements = collect();
        $this->upcomingEvents = collect();

        if ($alumniId) {
            $this->loadDonationSummary($alumniId);
        }

        $this->loadUpcomingEvents();

        if ($alumniId && $this->upcomingEvents->isNotEmpty()) {
            $this->loadMyEventRegistrations($alumniId);
        }

        $this->loadLatestAnnouncements();
    }

    protected function alumniId(): ?int
    {
        return Auth::user()?->alumni_id;
    }

    protected function loadDonationSummary(int $alumniId): void
    {
        $paidQuery = Donation::query()
            ->where('alumni_id', $alumniId)
            ->whereNotNull('paid_at')
            ->whereNotNull('paymongo_checkout_session_id');

        $this->paidTotal = (int) (clone $paidQuery)->sum('amount');

        $lastPayment = (clone $paidQuery)
            ->select(['amount', 'paid_at'])
            ->latest('paid_at')
            ->first();

        $this->lastPaidAmount = $lastPayment?->amount ? (int) $lastPayment->amount : null;
        $this->lastPaidAt = $lastPayment?->paid_at?->format('M d, Y h:i A');
    }

    protected function loadUpcomingEvents(): void
    {
        $this->upcomingEvents = Event::query()
            ->select([
                'id',
                'title',
                'venue',
                'event_date',
                'registration_fee',
                'dress_code',
                'is_active',
            ])
            ->where('is_active', true)
            ->whereDate('event_date', '>=', now()->toDateString())
            ->orderBy('event_date')
            ->limit(4)
            ->get();
    }

    protected function loadMyEventRegistrations(int $alumniId): void
    {
        $eventIds = $this->upcomingEvents->pluck('id')->all();

        $registrations = EventRegistration::query()
            ->select(['id', 'event_id', 'status', 'paid_at', 'fee_paid'])
            ->where('alumni_id', $alumniId)
            ->whereIn('event_id', $eventIds)
            ->get();

        $this->myEventRegs = $registrations
            ->keyBy('event_id')
            ->map(fn ($registration) => [
                'id' => $registration->id,
                'status' => $registration->status,
                'paid_at' => $registration->paid_at,
                'fee_paid' => $registration->fee_paid,
            ])
            ->toArray();
    }

    protected function loadLatestAnnouncements(): void
    {
        $this->latestAnnouncements = Announcement::query()
            ->select(['id', 'title', 'body', 'created_at', 'published_at', 'pinned'])
            ->where('is_published', true)
            ->where(function ($query) {
                $query->whereNull('published_at')
                    ->orWhere('published_at', '<=', now());
            })
            ->where(function ($query) {
                $query->whereNull('expires_at')
                    ->orWhere('expires_at', '>', now());
            })
            ->latest('published_at')
            ->latest('id')
            ->limit(5)
            ->get();
    }

    // public function registerOrPay(int $eventId, PayMongoService $paymongo)
    // {
    //     $alumniId = $this->alumniId();

    //     abort_if(!$alumniId, 403, 'Alumni profile is required.');

    //     $event = Event::query()
    //         ->select([
    //             'id',
    //             'title',
    //             'registration_fee',
    //             'is_active',
    //             'event_date',
    //         ])
    //         ->whereKey($eventId)
    //         ->firstOrFail();

    //     abort_if(
    //         !$event->is_active || $event->event_date->isPast(),
    //         403,
    //         'This event is no longer available for registration.'
    //     );

    //     $registration = EventRegistration::firstOrCreate(
    //         [
    //             'event_id' => $event->id,
    //             'alumni_id' => $alumniId,
    //         ],
    //         [
    //             'status' => 'pending',
    //             'fee_paid' => 0,
    //         ]
    //     );

    //     if ($registration->paid_at || $registration->status === 'paid') {
    //         session()->flash('status', 'You are already registered and paid for this event.');
    //         return;
    //     }

    //     $amountCentavos = (int) $event->registration_fee;

    //     if ($amountCentavos <= 0) {
    //         $registration->update([
    //             'status' => 'paid',
    //             'paid_at' => now(),
    //             'fee_paid' => 0,
    //         ]);

    //         $this->loadUpcomingEvents();
    //         $this->loadMyEventRegistrations($alumniId);

    //         session()->flash('status', 'Registered successfully.');
    //         return;
    //     }

    //     $payment = Payment::create([
    //         'alumni_id' => $alumniId,
    //         'registration_id' => $registration->id,
    //         'amount' => $amountCentavos,
    //         'mode' => 'gcash',
    //         'remarks' => null,
    //         'paid_at' => null,
    //         'is_paid' => false,
    //     ]);

    //     $baseUrl = rtrim(config('app.url'), '/');

    //     $payload = [
    //         'payment_method_types' => ['gcash'],
    //         'line_items' => [[
    //             'name' => 'Event Registration: ' . $event->title,
    //             'amount' => $amountCentavos,
    //             'currency' => 'PHP',
    //             'quantity' => 1,
    //         ]],
    //         'success_url' => $baseUrl . route('paymongo.return', absolute: false),
    //         'cancel_url' => $baseUrl . route('paymongo.return', absolute: false),
    //         'metadata' => [
    //             'payment_id' => (string) $payment->id,
    //             'registration_id' => (string) $registration->id,
    //             'event_id' => (string) $event->id,
    //             'alumni_id' => (string) $alumniId,
    //             'type' => 'event_registration',
    //         ],
    //     ];

    //     $response = $paymongo->createCheckoutSession($payload);

    //     $checkoutId = data_get($response, 'data.id');
    //     $checkoutUrl = data_get($response, 'data.attributes.checkout_url');

    //     abort_if(
    //         blank($checkoutId) || blank($checkoutUrl),
    //         500,
    //         'Unable to create checkout session.'
    //     );

    //     $payment->update([
    //         'paymongo_checkout_session_id' => $checkoutId,
    //     ]);

    //     return redirect()->away($checkoutUrl);
    // }
    public function registerOrPay(int $eventId)
{
    $alumniId = $this->alumniId();

    abort_if(!$alumniId, 403, 'Alumni profile is required.');

    $event = Event::query()
        ->select([
            'id',
            'title',
            'registration_fee',
            'is_active',
            'event_date',
        ])
        ->whereKey($eventId)
        ->firstOrFail();

    abort_if(
        !$event->is_active || $event->event_date->isPast(),
        403,
        'This event is no longer available for registration.'
    );

    $registration = EventRegistration::firstOrCreate(
        [
            'event_id' => $event->id,
            'alumni_id' => $alumniId,
        ],
        [
            'status' => 'pending',
            'fee_paid' => 0,
        ]
    );

    if ($registration->paid_at || $registration->status === 'paid') {
        session()->flash('status', 'You are already registered and paid for this event.');
        return;
    }

    $amountCentavos = (int) $event->registration_fee;

    // Free event
    if ($amountCentavos <= 0) {
        $registration->update([
            'status' => 'paid',
            'paid_at' => now(),
            'fee_paid' => 0,
        ]);

        $this->loadUpcomingEvents();
        $this->loadMyEventRegistrations($alumniId);

        session()->flash('status', 'Registered successfully.');
        return;
    }

    // Paid event: create/update payment record for manual processing
    $payment = Payment::firstOrCreate(
        [
            'registration_id' => $registration->id,
        ],
        [
            'alumni_id' => $alumniId,
            'amount' => $amountCentavos,
            'mode' => 'manual',
            'remarks' => null,
            'paid_at' => null,
            'is_paid' => false,
        ]
    );

    // Mark registration as waiting for payment / verification
    if ($registration->status !== 'paid') {
        $registration->update([
            'status' => 'pending',
        ]);
    }

    // Redirect to manual payment instructions / upload page
    return redirect()->route('event-registration.payment', [
        'registration' => $registration->id,
    ]);
}

    public function render()
    {
        return view('livewire.alumni-dashboard');
    }
}