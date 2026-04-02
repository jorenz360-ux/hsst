<?php

namespace App\Livewire;

use App\Models\Donation;
use App\Models\Event;
use App\Models\EventRegistration;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class AlumniDashboard extends Component
{
    use WithPagination;

    public array $myEventRegs = [];

    public int $paidTotal = 0;
    public ?string $lastPaidAt = null;
    public ?int $lastPaidAmount = null;

    public bool $hasVolunteerInfo = false;
    public array $volunteerRoles = [];
    public ?string $volunteerSpecialty = null;

    public int $perPage = 4;

    protected $queryString = [
        'page' => ['except' => 1],
    ];

    public function mount(): void
    {
        $alumniId = $this->alumniId();

        if ($alumniId) {
            $this->loadDonationSummary($alumniId);
            $this->loadVolunteerInfo();
        }
    }

    protected function alumniId(): ?int
    {
        return Auth::user()?->alumni_id;
    }

    protected function loadVolunteerInfo(): void
    {
        $user = Auth::user()?->loadMissing('alumni.involvement');

        $involvement = $user?->alumni?->involvement;

        if (! $involvement) {
            $this->hasVolunteerInfo = false;
            $this->volunteerRoles = [];
            $this->volunteerSpecialty = null;
            return;
        }

        $roles = [];

        if ((bool) $involvement->wants_committee_member) {
            $roles[] = 'Committee Member';
        }

        if ((bool) $involvement->is_priest_concelebrate) {
            $roles[] = 'Priest for Thanksgiving Mass';
        }

        if ((bool) $involvement->is_medical_practitioner) {
            $roles[] = 'Medical Practitioner for Medical Mission';
        }

        $this->volunteerRoles = $roles;
        $this->volunteerSpecialty = filled($involvement->medical_specialty)
            ? $involvement->medical_specialty
            : null;

        $this->hasVolunteerInfo = ! empty($roles) || filled($this->volunteerSpecialty);
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

        $this->lastPaidAmount = $lastPayment?->amount
            ? (int) $lastPayment->amount
            : null;

        $this->lastPaidAt = $lastPayment?->created_at?->format('M d, Y h:i A');
    }

    protected function getUpcomingEvents(): LengthAwarePaginator
    {
        return Event::query()
            ->select([
                'id',
                'slug',
                'title',
                'venue',
                'event_date',
                'registration_fee',
                'dress_code',
                'description',
                'is_active',
            ])
            ->where('is_active', true)
            ->whereDate('event_date', '>=', now()->toDateString())
            ->orderBy('event_date')
            ->paginate($this->perPage);
    }

    protected function loadMyEventRegistrations(int $alumniId, array $eventIds, $events): void
    {
        if (empty($eventIds)) {
            $this->myEventRegs = [];
            return;
        }

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
                },
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
            ->map(function (EventRegistration $registration) use ($events) {
                $basePayment = $registration->payments->firstWhere('event_registration_item_id', null);

                return [
                    'id' => $registration->id,
                    'status' => $registration->status,
                    'payment_status' => $this->mapBasePaymentStatus($registration, $basePayment, $events),
                ];
            })
            ->toArray();
    }

    protected function mapBasePaymentStatus(EventRegistration $registration, $basePayment, $events): string
    {
        $event = $events->getCollection()->firstWhere('id', $registration->event_id);
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

    public function updatingPage(): void
    {
        $this->myEventRegs = [];
    }

    public function render()
    {
        $user = Auth::user();
        $alumniId = $this->alumniId();
        $upcomingEvents = $this->getUpcomingEvents();

        if ($alumniId) {
            $this->loadMyEventRegistrations(
                $alumniId,
                $upcomingEvents->getCollection()->pluck('id')->all(),
                $upcomingEvents
            );
        }

        return view('livewire.alumni-dashboard', [
            'user' => $user,
            'alumni' => $user?->alumni,
            'upcomingEvents' => $upcomingEvents,
        ]);
    }
}