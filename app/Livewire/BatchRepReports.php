<?php

namespace App\Livewire;

use App\Models\Alumni;
use App\Models\AlumniEducation;
use App\Models\Event;
use App\Models\EventRegistration;
use App\Models\EventRsvp;
use App\Models\VolunteerSignup;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
        'selectedEvent'       => ['except' => 'all'],
        'rsvpStatusFilter'    => ['except' => 'all'],
        'paymentStatusFilter' => ['except' => 'all'],
        'search'              => ['except' => ''],
    ];

    public function updatingSelectedEvent(): void        { $this->resetPage(); }
    public function updatingRsvpStatusFilter(): void     { $this->resetPage(); }
    public function updatingPaymentStatusFilter(): void  { $this->resetPage(); }
    public function updatingSearch(): void               { $this->resetPage(); }

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

        $batchId = $this->repBatchId();
        abort_unless($batchId, 403, 'You are not assigned to any batch representative role.');

        $alumni = Alumni::query()
            ->where('id', $alumniId)
            ->whereHas('educations', fn ($q) => $q->where('batch_id', $batchId))
            ->first();

        if (! $alumni) {
            session()->flash('error', 'Alumni record not found in your assigned batch.');
            return;
        }

        EventRegistration::updateOrCreate(
            ['event_id' => (int) $this->selectedEvent, 'alumni_id' => $alumniId],
            ['status' => $status, 'fee_paid' => $status === 'paid' ? 1 : 0]
        );

        session()->flash('success', 'Payment status updated successfully.');
    }

    public function downloadExcel(): StreamedResponse
    {
        if ($this->selectedEvent === 'all') {
            abort(422, 'Please select an event first.');
        }

        $batchId = $this->repBatchId();
        abort_unless($batchId, 403, 'You are not assigned to any batch representative role.');

        $selectedEvent = $this->selectedEventModel();
        abort_unless($selectedEvent, 404, 'Selected event not found.');

        $participants = $this->participantsQuery($selectedEvent->id, $batchId)->get();

        $filename = 'batch-participants-event-' . $selectedEvent->id . '-' . now()->format('Y-m-d-His') . '.csv';

        return response()->streamDownload(function () use ($participants, $selectedEvent) {
            $handle = fopen('php://output', 'w');

            fputcsv($handle, ['Alumni Name', 'Level', 'Batch', 'School Year', 'RSVP Status', 'Event Fee', 'Payment Status', 'Updated At']);

            foreach ($participants as $p) {
                $fullName = trim(collect([$p->fname, $p->mname, $p->lname])->filter()->implode(' '));

                $rsvpStatus = match ($p->rsvp_status ?? 'no_response') {
                    'attending'     => 'Attending',
                    'maybe'         => 'Maybe',
                    'not_attending' => 'Not Attending',
                    default         => 'No Response Yet',
                };

                $paymentStatus = match ($p->payment_status ?? 'unpaid') {
                    'paid'   => 'Paid',
                    'waived' => 'Waived',
                    default  => 'Unpaid',
                };

                $eventFee = ($selectedEvent->registration_fee ?? 0) > 0
                    ? number_format(($selectedEvent->registration_fee ?? 0) / 100, 2)
                    : 'Free';

                $updatedAt = $p->payment_updated_at
                    ? \Carbon\Carbon::parse($p->payment_updated_at)->format('M d, Y h:i A')
                    : '-';

                fputcsv($handle, [
                    $fullName ?: '-',
                    $p->display_level ? str($p->display_level)->headline()->toString() : '-',
                    $p->yeargrad ?? '-',
                    $p->schoolyear ?? '-',
                    $rsvpStatus,
                    $eventFee,
                    $paymentStatus,
                    $updatedAt,
                ]);
            }

            fclose($handle);
        }, $filename, ['Content-Type' => 'text/csv']);
    }

    // ── Helpers ──────────────────────────────────────────────────────────────

    protected function repEducation(): ?AlumniEducation
    {
        return Auth::user()?->alumni?->educations()
            ->with('batch')
            ->where('is_batch_rep', true)
            ->first();
    }

    protected function repBatchId(): ?int
    {
        $id = $this->repEducation()?->batch_id;
        return $id ? (int) $id : null;
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

    protected function availableEvents(): Collection
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
                'alumni.id', 'alumni.fname', 'alumni.lname', 'alumni.mname',
                'alumni_educations.batch_id', 'batches.level', 'batches.yeargrad', 'batches.schoolyear',
            ])
            ->join('alumni_educations', function ($join) use ($batchId) {
                $join->on('alumni_educations.alumni_id', '=', 'alumni.id')
                    ->where('alumni_educations.batch_id', '=', $batchId);
            })
            ->join('batches', 'batches.id', '=', 'alumni_educations.batch_id')
            ->leftJoin('event_rsvps', function ($join) use ($eventId, $batchId) {
                $join->on('event_rsvps.alumni_id', '=', 'alumni.id')
                    ->where('event_rsvps.event_id', '=', $eventId)
                    ->where(function ($q) use ($batchId) {
                        $q->where('event_rsvps.batch_id', '=', $batchId)
                          ->orWhereNull('event_rsvps.batch_id');
                    });
            })
            ->leftJoin('batches as rsvp_batch', 'rsvp_batch.id', '=', 'event_rsvps.batch_id')
            ->leftJoin('event_registrations', function ($join) use ($eventId) {
                $join->on('event_registrations.alumni_id', '=', 'alumni.id')
                    ->where('event_registrations.event_id', '=', $eventId);
            })
            ->addSelect([
                'event_rsvps.id as rsvp_id',
                'event_rsvps.status as rsvp_status',
                'event_rsvps.updated_at as rsvp_updated_at',
                DB::raw('COALESCE(rsvp_batch.level, batches.level) as display_level'),
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
            $s = trim($this->search);
            $query->where(function ($q) use ($s) {
                $q->where('alumni.fname', 'like', "%{$s}%")
                    ->orWhere('alumni.lname', 'like', "%{$s}%")
                    ->orWhere('alumni.mname', 'like', "%{$s}%");
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
            options: ['path' => request()->url(), 'query' => request()->query()]
        );
    }

    protected function rsvpCounts(int $eventId, int $batchId): array
    {
        $base = Alumni::query()
            ->join('alumni_educations', function ($join) use ($batchId) {
                $join->on('alumni_educations.alumni_id', '=', 'alumni.id')
                    ->where('alumni_educations.batch_id', '=', $batchId);
            })
            ->leftJoin('event_rsvps', function ($join) use ($eventId, $batchId) {
                $join->on('event_rsvps.alumni_id', '=', 'alumni.id')
                    ->where('event_rsvps.event_id', '=', $eventId)
                    ->where(function ($q) use ($batchId) {
                        $q->where('event_rsvps.batch_id', '=', $batchId)
                          ->orWhereNull('event_rsvps.batch_id');
                    });
            });

        return [
            'attendingParticipantsCount'    => (clone $base)->where('event_rsvps.status', EventRsvp::STATUS_ATTENDING)->count(),
            'maybeParticipantsCount'        => (clone $base)->where('event_rsvps.status', EventRsvp::STATUS_MAYBE)->count(),
            'notAttendingParticipantsCount' => (clone $base)->where('event_rsvps.status', EventRsvp::STATUS_NOT_ATTENDING)->count(),
            'noResponseCount'               => (clone $base)->whereNull('event_rsvps.id')->count(),
        ];
    }

    protected function paymentCounts(int $eventId, int $batchId): array
    {
        $base = EventRegistration::query()
            ->where('event_id', $eventId)
            ->whereHas('alumni.educations', fn ($q) => $q->where('batch_id', $batchId));

        return [
            'paidParticipantsCount'   => (clone $base)->where('status', 'paid')->count(),
            'unpaidParticipantsCount' => (clone $base)->where('status', 'unpaid')->count(),
            'waivedParticipantsCount' => (clone $base)->where('status', 'waived')->count(),
        ];
    }

    protected function batchSummaryStats(int $batchId): array
    {
        $base = AlumniEducation::query()->where('batch_id', $batchId);

        return [
            'totalCount'      => (clone $base)->count(),
            'registeredCount' => (clone $base)->whereHas('alumni.user')->count(),
            'graduatedCount'  => (clone $base)->where('did_graduate', true)->count(),
            'noAccountCount'  => (clone $base)->whereDoesntHave('alumni.user')->count(),
        ];
    }

    protected function volunteerStats(int $batchId): Collection
    {
        return VolunteerSignup::query()
            ->join('committees', 'committees.id', '=', 'volunteer_signups.committee_id')
            ->join('alumni', 'alumni.id', '=', 'volunteer_signups.alumni_id')
            ->join('alumni_educations', function ($join) use ($batchId) {
                $join->on('alumni_educations.alumni_id', '=', 'alumni.id')
                    ->where('alumni_educations.batch_id', '=', $batchId);
            })
            ->select([
                'committees.name as committee_name',
                DB::raw('COUNT(*) as total'),
                DB::raw("SUM(CASE WHEN volunteer_signups.status = 'approved' THEN 1 ELSE 0 END) as approved"),
                DB::raw("SUM(CASE WHEN volunteer_signups.status = 'pending' THEN 1 ELSE 0 END) as pending"),
                DB::raw("SUM(CASE WHEN volunteer_signups.status = 'declined' THEN 1 ELSE 0 END) as declined"),
            ])
            ->groupBy('committees.id', 'committees.name')
            ->get();
    }

    public function render()
    {
        $repEducation = $this->repEducation();

        abort_unless($repEducation?->batch_id, 403, 'You are not assigned to any batch representative role.');

        $batchId      = (int) $repEducation->batch_id;
        $currentBatch = $repEducation->batch;

        $selectedEvent = $this->selectedEventModel();
        $allEvents     = $this->availableEvents();
        $participants  = $this->emptyPaginator();

        $eventStats = [
            'attendingParticipantsCount'    => 0,
            'maybeParticipantsCount'        => 0,
            'notAttendingParticipantsCount' => 0,
            'noResponseCount'               => 0,
            'paidParticipantsCount'         => 0,
            'unpaidParticipantsCount'       => 0,
            'waivedParticipantsCount'       => 0,
        ];

        if ($selectedEvent) {
            $participants = $this->participantsQuery($selectedEvent->id, $batchId)->paginate(15);

            $eventStats = array_merge(
                $eventStats,
                $this->rsvpCounts($selectedEvent->id, $batchId),
                $this->paymentCounts($selectedEvent->id, $batchId),
            );
        }

        return view('livewire.batch-rep-reports', [
            'currentBatch'       => $currentBatch,
            'allEvents'          => $allEvents,
            'selectedEventModel' => $selectedEvent,
            'participants'       => $participants,
            'batchSummary'       => $this->batchSummaryStats($batchId),
            'volunteerStats'     => $this->volunteerStats($batchId),
            ...$eventStats,
        ]);
    }
}
