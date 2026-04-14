<?php

namespace App\Livewire;

use App\Models\Alumni;
use App\Models\AlumniEducation;
use App\Models\Event;
use App\Models\EventRegistration;
use App\Models\EventRsvp;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;
use Symfony\Component\HttpFoundation\StreamedResponse;

#[Title('Batch Representative Reports')]
class BatchRepReports extends Component
{
    use WithPagination;

    public string $selectedEvent = 'all';
    public string $rsvpStatusFilter = 'all';
    public string $paymentStatusFilter = 'all';
    public string $search = '';

    protected $paginationTheme = 'tailwind';

    protected $queryString = [
        'selectedEvent' => ['except' => 'all'],
        'rsvpStatusFilter' => ['except' => 'all'],
        'paymentStatusFilter' => ['except' => 'all'],
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

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function resetEventFilters(): void
    {
        $this->selectedEvent = 'all';
        $this->rsvpStatusFilter = 'all';
        $this->paymentStatusFilter = 'all';
        $this->search = '';
        $this->resetPage();
    }

    public function updatePaymentStatus(int $alumniId, string $status): void
    {
        $allowedStatuses = ['unpaid', 'paid', 'waived'];

        if (! in_array($status, $allowedStatuses, true)) {
            session()->flash('error', 'Invalid payment status.');
            return;
        }

        if ($this->selectedEvent === 'all') {
            session()->flash('error', 'Please select an event first.');
            return;
        }

        $batchId = $this->representativeBatchId();

        abort_unless($batchId, 403, 'You are not assigned to any batch representative role.');

        $alumni = Alumni::query()
            ->where('id', $alumniId)
            ->whereHas('educations', function ($query) use ($batchId) {
                $query->where('batch_id', $batchId);
            })
            ->first();

        if (! $alumni) {
            session()->flash('error', 'Alumni record not found in your assigned batch.');
            return;
        }

        EventRegistration::updateOrCreate(
            [
                'event_id' => (int) $this->selectedEvent,
                'alumni_id' => $alumniId,
            ],
            [
                'status' => $status,
                'fee_paid' => $status === 'paid' ? 1 : 0,
            ]
        );

        session()->flash('success', 'Payment status updated successfully.');
    }

    public function downloadExcel(): StreamedResponse
    {
        if ($this->selectedEvent === 'all') {
            abort(422, 'Please select an event first.');
        }

        $batchId = $this->representativeBatchId();
        abort_unless($batchId, 403, 'You are not assigned to any batch representative role.');

        $selectedEvent = $this->selectedEventModel();
        abort_unless($selectedEvent, 404, 'Selected event not found.');

        $participants = $this->participantsQuery($selectedEvent->id, $batchId)->get();

        $filename = 'batch-participants-event-' . $selectedEvent->id . '-' . now()->format('Y-m-d-His') . '.csv';

        return response()->streamDownload(function () use ($participants, $selectedEvent) {
            $handle = fopen('php://output', 'w');

            fputcsv($handle, [
                'Alumni Name',
                'Level',
                'Batch',
                'School Year',
                'RSVP Status',
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

                $rsvpStatus = match ($participant->rsvp_status ?? 'no_response') {
                    'attending' => 'Attending',
                    'maybe' => 'Maybe',
                    'not_attending' => 'Not Attending',
                    default => 'No Response Yet',
                };

                $paymentStatus = match ($participant->payment_status ?? 'unpaid') {
                    'paid' => 'Paid',
                    'waived' => 'Waived',
                    default => 'Unpaid',
                };

                $eventFee = ($selectedEvent->registration_fee ?? 0) > 0
                    ? number_format(($selectedEvent->registration_fee ?? 0) / 100, 2)
                    : 'Free';

                $updatedAt = $participant->payment_updated_at
                    ? \Carbon\Carbon::parse($participant->payment_updated_at)->format('M d, Y h:i A')
                    : '-';

                fputcsv($handle, [
                    $fullName ?: '-',
                    $participant->level ? str($participant->level)->headline()->toString() : '-',
                    $participant->yeargrad ?? '-',
                    $participant->schoolyear ?? '-',
                    $rsvpStatus,
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

    protected function user()
    {
        return Auth::user();
    }

    protected function representativeEducation(): ?AlumniEducation
    {
        return $this->user()?->alumni?->educations()
            ->with('batch')
            ->where('is_batch_rep', true)
            ->first();
    }

    protected function representativeBatchId(): ?int
    {
        return $this->representativeEducation()?->batch_id
            ? (int) $this->representativeEducation()->batch_id
            : null;
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

    protected function participantsQuery(int $eventId, int $batchId)
    {
        $query = Alumni::query()
            ->select([
                'alumni.id',
                'alumni.fname',
                'alumni.lname',
                'alumni.mname',
                'alumni_educations.batch_id',
                'batches.level',
                'batches.yeargrad',
                'batches.schoolyear',
            ])
            ->join('alumni_educations', function ($join) use ($batchId) {
                $join->on('alumni_educations.alumni_id', '=', 'alumni.id')
                    ->where('alumni_educations.batch_id', '=', $batchId);
            })
            ->join('batches', 'batches.id', '=', 'alumni_educations.batch_id')
            ->leftJoin('event_rsvps', function ($join) use ($eventId) {
                $join->on('event_rsvps.alumni_id', '=', 'alumni.id')
                    ->where('event_rsvps.event_id', '=', $eventId);
            })
            ->leftJoin('event_registrations', function ($join) use ($eventId) {
                $join->on('event_registrations.alumni_id', '=', 'alumni.id')
                    ->where('event_registrations.event_id', '=', $eventId);
            })
            ->addSelect([
                'event_rsvps.id as rsvp_id',
                'event_rsvps.status as rsvp_status',
                'event_rsvps.updated_at as rsvp_updated_at',
                'event_registrations.id as registration_id',
                'event_registrations.status as payment_status',
                'event_registrations.updated_at as payment_updated_at',
            ])
            ->orderBy('alumni.lname')
            ->orderBy('alumni.fname');

        if ($this->rsvpStatusFilter !== 'all') {
            if ($this->rsvpStatusFilter === 'no_response') {
                $query->whereNull('event_rsvps.id');
            } else {
                $query->where('event_rsvps.status', $this->rsvpStatusFilter);
            }
        }

        if ($this->paymentStatusFilter !== 'all') {
            if ($this->paymentStatusFilter === 'unpaid') {
                $query->where(function ($q) {
                    $q->whereNull('event_registrations.id')
                        ->orWhere('event_registrations.status', 'unpaid');
                });
            } else {
                $query->where('event_registrations.status', $this->paymentStatusFilter);
            }
        }

        if (trim($this->search) !== '') {
            $search = trim($this->search);

            $query->where(function ($q) use ($search) {
                $q->where('alumni.fname', 'like', "%{$search}%")
                    ->orWhere('alumni.lname', 'like', "%{$search}%")
                    ->orWhere('alumni.mname', 'like', "%{$search}%");
            });
        }

        return $query;
    }

    protected function emptyPaginator(): LengthAwarePaginator
    {
        return new Paginator(
            items: collect(),
            total: 0,
            perPage: 10,
            currentPage: $this->getPage(),
            options: [
                'path' => request()->url(),
                'query' => request()->query(),
            ]
        );
    }

    protected function rsvpCounts(int $eventId, int $batchId): array
    {
        $baseQuery = Alumni::query()
            ->join('alumni_educations', function ($join) use ($batchId) {
                $join->on('alumni_educations.alumni_id', '=', 'alumni.id')
                    ->where('alumni_educations.batch_id', '=', $batchId);
            })
            ->leftJoin('event_rsvps', function ($join) use ($eventId) {
                $join->on('event_rsvps.alumni_id', '=', 'alumni.id')
                    ->where('event_rsvps.event_id', '=', $eventId);
            });

        return [
            'attendingParticipantsCount' => (clone $baseQuery)
                ->where('event_rsvps.status', EventRsvp::STATUS_ATTENDING)
                ->count(),

            'maybeParticipantsCount' => (clone $baseQuery)
                ->where('event_rsvps.status', EventRsvp::STATUS_MAYBE)
                ->count(),

            'notAttendingParticipantsCount' => (clone $baseQuery)
                ->where('event_rsvps.status', EventRsvp::STATUS_NOT_ATTENDING)
                ->count(),

            'noResponseCount' => (clone $baseQuery)
                ->whereNull('event_rsvps.id')
                ->count(),
        ];
    }

    protected function paymentCounts(int $eventId, int $batchId): array
    {
        $baseQuery = EventRegistration::query()
            ->where('event_id', $eventId)
            ->whereHas('alumni.educations', fn ($query) => $query->where('batch_id', $batchId));

        return [
            'paidParticipantsCount' => (clone $baseQuery)->where('status', 'paid')->count(),
            'unpaidParticipantsCount' => (clone $baseQuery)->where('status', 'unpaid')->count(),
            'waivedParticipantsCount' => (clone $baseQuery)->where('status', 'waived')->count(),
        ];
    }

    public function render()
    {
        $representativeEducation = $this->representativeEducation();
        $batchId = $this->representativeBatchId();

        abort_unless($batchId, 403, 'You are not assigned to any batch representative role.');

        $selectedEvent = $this->selectedEventModel();
        $allEvents = $this->availableEvents();

        $participants = $this->emptyPaginator();

        $stats = [
            'attendingParticipantsCount' => 0,
            'maybeParticipantsCount' => 0,
            'notAttendingParticipantsCount' => 0,
            'paidParticipantsCount' => 0,
            'unpaidParticipantsCount' => 0,
            'waivedParticipantsCount' => 0,
            'noResponseCount' => 0,
        ];

        if ($selectedEvent) {
            $participants = $this->participantsQuery($selectedEvent->id, $batchId)->paginate(10);

            $stats = array_merge(
                $stats,
                $this->rsvpCounts($selectedEvent->id, $batchId),
                $this->paymentCounts($selectedEvent->id, $batchId),
            );
        }

        return view('livewire.batch-rep-reports', [
            'allEvents' => $allEvents,
            'selectedEventModel' => $selectedEvent,
            'participants' => $participants,
            'currentBatch' => $representativeEducation?->batch,

            'attendingParticipantsCount' => $stats['attendingParticipantsCount'],
            'maybeParticipantsCount' => $stats['maybeParticipantsCount'],
            'notAttendingParticipantsCount' => $stats['notAttendingParticipantsCount'],
            'paidParticipantsCount' => $stats['paidParticipantsCount'],
            'unpaidParticipantsCount' => $stats['unpaidParticipantsCount'],
            'waivedParticipantsCount' => $stats['waivedParticipantsCount'],
            'noResponseCount' => $stats['noResponseCount'],
        ]);
    }
}