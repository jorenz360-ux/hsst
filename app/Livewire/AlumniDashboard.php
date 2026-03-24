<?php

namespace App\Livewire;

use App\Models\Announcement;
use App\Models\Donation;
use App\Models\Event;
use App\Models\EventRegistration;
use App\Models\Payment;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class AlumniDashboard extends Component
{
    public array $myEventRegs = [];
    public array $myEventItemPayments = [];

    public int $paidTotal = 0;
    public ?string $lastPaidAt = null;
    public ?int $lastPaidAmount = null;

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
            $this->loadMyEventItemPayments($alumniId);
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
            ->whereNotNull('paymongo_checkout_session_id');

        $this->paidTotal = (int) (clone $paidQuery)->sum('amount');

        $lastPayment = (clone $paidQuery)
            ->select(['amount', 'created_at'])
            ->latest('created_at')
            ->first();

        $this->lastPaidAmount = $lastPayment?->amount ? (int) $lastPayment->amount : null;
        $this->lastPaidAt = $lastPayment?->created_at?->format('M d, Y h:i A');
    }

    protected function loadUpcomingEvents(): void
    {
        $this->upcomingEvents = Event::query()
            ->with([
                'registrationItems:id,event_id,event_schedule_id,name,description,price,is_required,is_active,sort_order',
                'registrationItems.schedule:id,title,schedule_time',
            ])
            ->select([
                'id',
                'slug',
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
            ->with([
                'payments' => function ($query) {
                    $query->select([
                        'id',
                        'registration_id',
                        'event_registration_item_id',
                        'status',
                        'created_at',
                    ])->latest('id');
                }
            ])
            ->select([
                'id',
                'event_id',
                'status',
                'alumni_id',
            ])
            ->where('alumni_id', $alumniId)
            ->whereIn('event_id', $eventIds)
            ->get();

        $this->myEventRegs = $registrations
            ->keyBy('event_id')
            ->map(function ($registration) {
                $basePayment = $registration->payments
                    ->firstWhere('event_registration_item_id', null);

                return [
                    'id' => $registration->id,
                    'status' => $registration->status,
                    'payment_status' => $this->mapBasePaymentStatus($registration, $basePayment),
                ];
            })
            ->toArray();
    }

    protected function mapBasePaymentStatus(EventRegistration $registration, $basePayment): string
    {
        $event = $this->upcomingEvents->firstWhere('id', $registration->event_id);
        $isPaidEvent = (int) ($event?->registration_fee ?? 0) > 0;

        if (! $isPaidEvent) {
            return 'not_required';
        }

        if ($registration->status === 'paid') {
            return 'paid';
        }

        return match ($basePayment?->status) {
            'pending' => 'pending',
            'verified' => 'paid',
            'rejected' => 'rejected',
            default => 'unpaid',
        };
    }

    protected function loadMyEventItemPayments(int $alumniId): void
    {
        $eventIds = $this->upcomingEvents->pluck('id')->all();

        $payments = Payment::query()
            ->with([
                'registration:id,event_id,alumni_id',
            ])
            ->select([
                'id',
                'registration_id',
                'event_registration_item_id',
                'status',
                'created_at',
            ])
            ->whereNotNull('event_registration_item_id')
            ->whereHas('registration', function ($q) use ($alumniId, $eventIds) {
                $q->where('alumni_id', $alumniId)
                  ->whereIn('event_id', $eventIds);
            })
            ->latest('id')
            ->get();

        $grouped = [];

        foreach ($payments as $payment) {
            $eventId = $payment->registration->event_id;
            $itemId = $payment->event_registration_item_id;

            if (! isset($grouped[$eventId][$itemId])) {
                $grouped[$eventId][$itemId] = match ($payment->status) {
                    'verified' => 'verified',
                    'pending' => 'pending',
                    'rejected' => 'rejected',
                    default => 'unpaid',
                };
            }
        }

        $this->myEventItemPayments = $grouped;
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

    public function registerOrPay(int $eventId)
    {
        $alumniId = $this->alumniId();

        abort_if(! $alumniId, 403);

        $event = $this->upcomingEvents->firstWhere('id', $eventId)
            ?? Event::query()->select(['id', 'slug'])->findOrFail($eventId);

        return redirect()->route('alumni.events.show', ['event' => $event->slug]);
    }

    public function render()
    {
        return view('livewire.alumni-dashboard');
    }
}