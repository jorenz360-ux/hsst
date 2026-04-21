<?php

namespace App\Livewire;

use App\Models\Alumni;
use App\Models\Event;
use App\Models\EventRegistration;
use App\Models\EventRsvp;
use App\Models\Staff;
use App\Models\StaffEventRsvp;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;
use Symfony\Component\HttpFoundation\StreamedResponse;

#[Title('Admin | Attendance Reports')]
class AttendanceReport extends Component
{
    use WithPagination;

    public string $selectedEvent = 'all';
    public string $rsvpStatusFilter = 'all';
    public string $paymentStatusFilter = 'all';
    public string $levelFilter = 'all';
    public string $search = '';

    protected $queryString = [
        'selectedEvent' => ['except' => 'all'],
        'rsvpStatusFilter' => ['except' => 'all'],
        'paymentStatusFilter' => ['except' => 'all'],
        'levelFilter' => ['except' => 'all'],
        'search' => ['except' => ''],
    ];

    public function updatingSelectedEvent(): void
    {
        $this->resetPage();
    }

    public function updatingRsvpStatusFilter(): void
    {
        $this->resetPage();
    }

    public function updatingPaymentStatusFilter(): void
    {
        $this->resetPage();
    }

    public function updatingLevelFilter(): void
    {
        $this->resetPage();
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function resetEventFilters(): void
    {
        $this->selectedEvent = 'all';
        $this->rsvpStatusFilter = 'all';
        $this->paymentStatusFilter = 'all';
        $this->levelFilter = 'all';
        $this->search = '';
        $this->resetPage();
    }

    public function updatePaymentStatus(int $alumniId, string $status): void
    {
        $allowedStatuses = ['unpaid', 'pending', 'paid', 'rejected'];

        if (! in_array($status, $allowedStatuses, true)) {
            session()->flash('error', 'Invalid payment status.');
            return;
        }

        if ($this->selectedEvent === 'all') {
            session()->flash('error', 'Please select an event first.');
            return;
        }

        EventRegistration::updateOrCreate(
            [
                'event_id' => (int) $this->selectedEvent,
                'alumni_id' => $alumniId,
            ],
            [
                'payment_status' => $status,
            ]
        );

        session()->flash('success', 'Payment status updated successfully.');
    }

    public function downloadExcel(): StreamedResponse
    {
        if ($this->selectedEvent === 'all') {
            abort(422, 'Please select an event first.');
        }

        $selectedEvent = $this->selectedEventModel();

        abort_unless($selectedEvent, 404, 'Selected event not found.');

        $participants = $this->reportQuery($selectedEvent->id)->get();

        $filename = 'reunion-attendance-report-event-' . $selectedEvent->id . '-' . now()->format('Y-m-d-His') . '.csv';

        return response()->streamDownload(function () use ($participants, $selectedEvent) {
            $handle = fopen('php://output', 'w');

            fputcsv($handle, [
                'Batch',
                'Level',
                'Alumni Name',
                'RSVP Status',
                'Guests',
                'Event Fee',
                'Payment Status',
                'Updated At',
            ]);

            foreach ($participants as $participant) {
                $fullName = trim(collect([
                    $participant->fname,
                    $participant->mname,
                    $participant->lname,
                ])->filter()->implode(' '));

                $rsvpStatus = match($participant->rsvp_status ?? 'no_response') {
                    'attending' => 'Attending',
                    'maybe' => 'Maybe',
                    'not_attending' => 'Not Attending',
                    default => 'No Response Yet',
                };

                $paymentStatus = match($participant->payment_status ?? 'unpaid') {
                    'paid' => 'Paid',
                    'pending' => 'Pending',
                    'rejected' => 'Rejected',
                    default => 'Unpaid',
                };

                $batchLevel = match($participant->batch_level ?? '') {
                    'elementary' => 'Elementary',
                    'highschool' => 'High School',
                    'college' => 'College',
                    default => '-',
                };

                $eventFee = ($selectedEvent->registration_fee ?? 0) > 0
                    ? number_format(($selectedEvent->registration_fee ?? 0) / 100, 2)
                    : 'Free';

                $updatedAt = $participant->payment_updated_at
                    ? \Carbon\Carbon::parse($participant->payment_updated_at)->format('M d, Y h:i A')
                    : '-';

                fputcsv($handle, [
                    $participant->batch_label ?: '-',
                    $batchLevel,
                    $fullName ?: '-',
                    $rsvpStatus,
                    $participant->guest_count ?? 0,
                    $eventFee,
                    $paymentStatus,
                    $updatedAt,
                ]);
            }

            fclose($handle);
        }, $filename, [
            'Content-Type' => 'text/csv',
        ]);
    }

    protected function selectedEventModel(): ?Event
    {
        if ($this->selectedEvent === 'all') {
            return null;
        }

        return Event::query()
            ->select(['id', 'title', 'event_date', 'venue', 'registration_fee', 'is_active'])
            ->find((int) $this->selectedEvent);
    }

    protected function availableEvents()
    {
        return Event::query()
            ->where('is_active', true)
            ->whereNotNull('event_date')
            ->orderBy('event_date')
            ->get(['id', 'title', 'event_date', 'venue', 'registration_fee']);
    }

    protected function reportQuery(int $eventId)
    {
        $query = Alumni::query()
            ->select(['alumni.id', 'alumni.fname', 'alumni.lname', 'alumni.mname'])
            ->leftJoin('event_rsvps', function ($join) use ($eventId) {
                $join->on('event_rsvps.alumni_id', '=', 'alumni.id')
                    ->where('event_rsvps.event_id', '=', $eventId);
            })
            ->leftJoin('batches', 'batches.id', '=', 'event_rsvps.batch_id')
            ->leftJoin('event_registrations', function ($join) use ($eventId) {
                $join->on('event_registrations.alumni_id', '=', 'alumni.id')
                    ->where('event_registrations.event_id', '=', $eventId);
            })
            ->addSelect([
                'batches.schoolyear',
                'batches.yeargrad',
                'batches.level as batch_level',
                'event_rsvps.id as rsvp_id',
                'event_rsvps.status as rsvp_status',
                'event_rsvps.guest_count',
                'event_rsvps.updated_at as rsvp_updated_at',
                'event_registrations.id as registration_id',
                'event_registrations.payment_status',
                'event_registrations.updated_at as payment_updated_at',
            ])
            ->selectRaw("
                CASE
                    WHEN batches.schoolyear IS NOT NULL THEN batches.schoolyear
                    WHEN batches.yeargrad IS NOT NULL THEN CAST(batches.yeargrad AS CHAR)
                    ELSE 'No Batch'
                END as batch_label
            ")
            ->orderBy('batches.yeargrad')
            ->orderBy('alumni.lname')
            ->orderBy('alumni.fname');

        if ($this->levelFilter !== 'all') {
            $query->where('batches.level', $this->levelFilter);
        }

        if ($this->rsvpStatusFilter !== 'all') {
            if ($this->rsvpStatusFilter === 'no_response') {
                $query->whereNull('event_rsvps.id');
            } else {
                $query->where('event_rsvps.status', $this->rsvpStatusFilter);
            }
        }

        if ($this->paymentStatusFilter !== 'all') {
            $query->where('event_registrations.payment_status', $this->paymentStatusFilter);
        }

        if ($this->search !== '') {
            $search = trim($this->search);

            $query->where(function ($q) use ($search) {
                $q->where('alumni.fname', 'like', "%{$search}%")
                    ->orWhere('alumni.lname', 'like', "%{$search}%")
                    ->orWhere('alumni.mname', 'like', "%{$search}%")
                    ->orWhere('batches.schoolyear', 'like', "%{$search}%")
                    ->orWhere('batches.yeargrad', 'like', "%{$search}%");
            });
        }

        return $query;
    }

    protected function staffReportQuery(int $eventId)
    {
        return Staff::query()
            ->select(['staff.id', 'staff.fname', 'staff.lname', 'staff.position'])
            ->leftJoin('staff_event_rsvps', function ($join) use ($eventId) {
                $join->on('staff_event_rsvps.staff_id', '=', 'staff.id')
                    ->where('staff_event_rsvps.event_id', '=', $eventId);
            })
            ->addSelect(['staff_event_rsvps.status as rsvp_status'])
            ->whereHas('user', fn ($q) => $q->where('is_active', true))
            ->orderBy('staff.lname')
            ->orderBy('staff.fname');
    }

    public function render()
    {
        $selectedEvent = $this->selectedEventModel();
        $allEvents = $this->availableEvents();

        $participants = collect();
        $staffParticipants = collect();

        $attendingParticipantsCount = 0;
        $maybeParticipantsCount = 0;
        $notAttendingParticipantsCount = 0;
        $noResponseCount = 0;
        $paidParticipantsCount = 0;
        $unpaidParticipantsCount = 0;
        $pendingParticipantsCount = 0;
        $rejectedParticipantsCount = 0;

        $staffAttendingCount = 0;
        $staffMaybeCount = 0;
        $staffNotAttendingCount = 0;
        $staffNoResponseCount = 0;

        if ($selectedEvent) {
            $participants = $this->reportQuery($selectedEvent->id)->paginate(10);
            $staffParticipants = $this->staffReportQuery($selectedEvent->id)->get();

            $attendingParticipantsCount = EventRsvp::query()
                ->where('event_id', $selectedEvent->id)
                ->where('status', EventRsvp::STATUS_ATTENDING)
                ->count();

            $maybeParticipantsCount = EventRsvp::query()
                ->where('event_id', $selectedEvent->id)
                ->where('status', EventRsvp::STATUS_MAYBE)
                ->count();

            $notAttendingParticipantsCount = EventRsvp::query()
                ->where('event_id', $selectedEvent->id)
                ->where('status', EventRsvp::STATUS_NOT_ATTENDING)
                ->count();

            $noResponseCount = Alumni::query()
                ->leftJoin('event_rsvps', function ($join) use ($selectedEvent) {
                    $join->on('event_rsvps.alumni_id', '=', 'alumni.id')
                        ->where('event_rsvps.event_id', '=', $selectedEvent->id);
                })
                ->whereNull('event_rsvps.id')
                ->count();

            $paidParticipantsCount = EventRegistration::query()
                ->where('event_id', $selectedEvent->id)
                ->where('payment_status', 'paid')
                ->count();

            $unpaidParticipantsCount = EventRegistration::query()
                ->where('event_id', $selectedEvent->id)
                ->where('payment_status', 'unpaid')
                ->count();

            $pendingParticipantsCount = EventRegistration::query()
                ->where('event_id', $selectedEvent->id)
                ->where('payment_status', 'pending')
                ->count();

            $rejectedParticipantsCount = EventRegistration::query()
                ->where('event_id', $selectedEvent->id)
                ->where('payment_status', 'rejected')
                ->count();

            $staffAttendingCount    = StaffEventRsvp::where('event_id', $selectedEvent->id)->where('status', StaffEventRsvp::STATUS_ATTENDING)->count();
            $staffMaybeCount        = StaffEventRsvp::where('event_id', $selectedEvent->id)->where('status', StaffEventRsvp::STATUS_MAYBE)->count();
            $staffNotAttendingCount = StaffEventRsvp::where('event_id', $selectedEvent->id)->where('status', StaffEventRsvp::STATUS_NOT_ATTENDING)->count();
            $staffNoResponseCount   = Staff::whereHas('user', fn ($q) => $q->where('is_active', true))
                ->leftJoin('staff_event_rsvps', function ($join) use ($selectedEvent) {
                    $join->on('staff_event_rsvps.staff_id', '=', 'staff.id')
                        ->where('staff_event_rsvps.event_id', '=', $selectedEvent->id);
                })
                ->whereNull('staff_event_rsvps.id')
                ->count();
        }

        return view('livewire.attendance-report', [
            'allEvents' => $allEvents,
            'selectedEventModel' => $selectedEvent,
            'participants' => $participants,
            'staffParticipants' => $staffParticipants,
            'attendingParticipantsCount' => $attendingParticipantsCount,
            'maybeParticipantsCount' => $maybeParticipantsCount,
            'notAttendingParticipantsCount' => $notAttendingParticipantsCount,
            'noResponseCount' => $noResponseCount,
            'paidParticipantsCount' => $paidParticipantsCount,
            'unpaidParticipantsCount' => $unpaidParticipantsCount,
            'pendingParticipantsCount' => $pendingParticipantsCount,
            'rejectedParticipantsCount' => $rejectedParticipantsCount,
            'staffAttendingCount' => $staffAttendingCount,
            'staffMaybeCount' => $staffMaybeCount,
            'staffNotAttendingCount' => $staffNotAttendingCount,
            'staffNoResponseCount' => $staffNoResponseCount,
        ]);
    }
}
