<?php

namespace App\Livewire;

use App\Models\Alumni;
use App\Models\AlumniInvolvement;
use App\Models\Batch;
use App\Models\Donation;
use App\Models\Event;
use App\Models\EventRegistration;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;
use Symfony\Component\HttpFoundation\StreamedResponse;

#[Title('Admin | Reports')]
class Reports extends Component
{
    use WithPagination;

    public string $tab = 'donations';

    public ?string $donationStartDate = null;
    public ?string $donationEndDate = null;

    /**
     * Global batch filter applied to all tabs.
     */
    public string $selectedBatch = 'all';

    public string $selectedEvent = 'all';
    public string $registrationStatus = 'all';

    /**
     * Alumni involvement filters
     * all | involved
     */
    public string $involvementType = 'all'; // all | committee | priest | medical

    protected $queryString = [
        'tab' => ['except' => 'donations'],
        'selectedBatch' => ['except' => 'all'],
        'selectedEvent' => ['except' => 'all'],
        'registrationStatus' => ['except' => 'all'],
        'involvementType' => ['except' => 'all'],
    ];

    public function mount(): void
    {
        if ($this->isBatchRepresentative()) {
            $batchId = $this->getUserBatchId();

            if ($batchId !== null) {
                $this->selectedBatch = (string) $batchId;
            }
        }
    }

    public function updatingTab(): void
    {
        $this->resetAllPages();
    }

    public function updatingDonationStartDate(): void
    {
        $this->resetPage('donationsPage');
    }

    public function updatingDonationEndDate(): void
    {
        $this->resetPage('donationsPage');
    }

    public function updatingSelectedBatch(): void
    {
        $this->resetAllPages();
    }

    public function updatingSelectedEvent(): void
    {
        $this->resetPage('eventRegistrationsPage');
    }

    public function updatingRegistrationStatus(): void
    {
        $this->resetPage('eventRegistrationsPage');
    }

    public function updatingInvolvementType(): void
    {
        $this->resetPage('involvementPage');
    }

    public function updatedSelectedBatch($value): void
    {
        if ($this->isBatchRepresentative()) {
            $this->selectedBatch = (string) ($this->getUserBatchId() ?? 'all');

            return;
        }

        if ($value !== 'all' && ! Batch::query()->whereKey((int) $value)->exists()) {
            $this->selectedBatch = 'all';
        }
    }

    public function resetDonationFilters(): void
    {
        $this->donationStartDate = null;
        $this->donationEndDate = null;
        $this->resetPage('donationsPage');
    }

    public function resetEventFilters(): void
    {
        $this->selectedEvent = 'all';
        $this->registrationStatus = 'all';
        $this->resetPage('eventRegistrationsPage');
    }

    public function resetInvolvementFilters(): void
    {
        $this->involvementType = 'all';
        $this->resetPage('involvementPage');
    }

    public function resetBatchFilter(): void
    {
        if ($this->isBatchRepresentative()) {
            $this->selectedBatch = (string) ($this->getUserBatchId() ?? 'all');
        } else {
            $this->selectedBatch = 'all';
        }

        $this->resetAllPages();
    }

    protected function resetAllPages(): void
    {
        $this->resetPage('donationsPage');
        $this->resetPage('batchMembersPage');
        $this->resetPage('eventRegistrationsPage');
        $this->resetPage('involvementPage');
    }

    protected function user()
    {
        return Auth::user();
    }

    protected function isReunionCoordinator(): bool
    {
        return $this->user()?->hasRole('reunion-coordinator') ?? false;
    }

    protected function isBatchRepresentative(): bool
    {
        return $this->user()?->hasRole('batch-representative') ?? false;
    }

    protected function getUserBatchId(): ?int
    {
        $batchId = $this->user()?->alumni?->batch_id;

        return $batchId ? (int) $batchId : null;
    }

    protected function resolvedBatchId(): ?int
    {
        if ($this->isBatchRepresentative()) {
            return $this->getUserBatchId();
        }

        if ($this->selectedBatch === 'all') {
            return null;
        }

        return (int) $this->selectedBatch;
    }

    protected function applyBatchScopeToAlumniRelation(Builder $query, string $relation = 'alumni'): Builder
    {
        $batchId = $this->resolvedBatchId();

        if ($batchId === null) {
            return $query;
        }

        return $query->whereHas($relation, function (Builder $q) use ($batchId) {
            $q->where('batch_id', $batchId);
        });
    }

    protected function baseDonationQuery(): Builder
    {
        $query = Donation::query()
            ->with([
                'alumni:id,fname,lname,mname,batch_id',
                'alumni.batch:id,yeargrad,schoolyear',
            ]);

        $query = $this->applyBatchScopeToAlumniRelation($query);

        if ($this->donationStartDate) {
            $query->whereDate('created_at', '>=', $this->donationStartDate);
        }

        if ($this->donationEndDate) {
            $query->whereDate('created_at', '<=', $this->donationEndDate);
        }

        return $query;
    }

    protected function baseBatchSummaryQuery(): Builder
    {
        $query = Batch::query()
            ->withCount('alumni')
            ->orderBy('yeargrad', 'desc');

        $batchId = $this->resolvedBatchId();

        if ($batchId !== null) {
            $query->where('id', $batchId);
        }

        return $query;
    }

    protected function baseBatchMembersQuery(): Builder
    {
        $query = Alumni::query()
            ->with([
                'batch:id,yeargrad,schoolyear',
            ])
            ->select([
                'id',
                'fname',
                'lname',
                'mname',
                'batch_id',
            ])
            ->orderBy('lname')
            ->orderBy('fname');

        $batchId = $this->resolvedBatchId();

        if ($batchId !== null) {
            $query->where('batch_id', $batchId);
        }

        return $query;
    }

    protected function baseEventRegistrationQuery(): Builder
    {
        $query = EventRegistration::query()
            ->with([
                'event:id,title,slug,event_date,venue',
                'alumni:id,fname,lname,mname,batch_id',
                'alumni.batch:id,yeargrad,schoolyear',
            ]);

        if ($this->selectedEvent !== 'all') {
            $query->where('event_id', (int) $this->selectedEvent);
        }

        if ($this->registrationStatus !== 'all') {
            $query->where('status', $this->registrationStatus);
        }

        $query = $this->applyBatchScopeToAlumniRelation($query);

        return $query;
    }

    protected function baseInvolvementQuery(): Builder
    {
        $query = AlumniInvolvement::query()
            ->with([
                'alumni:id,fname,lname,mname,batch_id',
                'alumni.batch:id,yeargrad,schoolyear',
            ]);

        $query = $this->applyBatchScopeToAlumniRelation($query);

        return match ($this->involvementType) {
            'committee' => $query->where('wants_committee_member', true),
            'priest' => $query->where('is_priest_concelebrate', true),
            'medical' => $query->where('is_medical_practitioner', true),
            default => $query,
        };
    }

    protected function availableBatches()
    {
        if ($this->isBatchRepresentative()) {
            $batchId = $this->getUserBatchId();

            if (! $batchId) {
                return collect();
            }

            return Batch::query()
                ->where('id', $batchId)
                ->orderBy('yeargrad', 'desc')
                ->get(['id', 'yeargrad', 'schoolyear']);
        }

        return Batch::query()
            ->orderBy('yeargrad', 'desc')
            ->get(['id', 'yeargrad', 'schoolyear']);
    }

    protected function availableEvents()
    {
        return Event::query()
            ->whereNotNull('event_date')
            ->orderBy('event_date', 'desc')
            ->get(['id', 'title', 'event_date']);
    }

    protected function selectedBatchModel(): ?Batch
    {
        $batchId = $this->resolvedBatchId();

        if (! $batchId) {
            return null;
        }

        return Batch::query()
            ->select(['id', 'yeargrad', 'schoolyear'])
            ->find($batchId);
    }

    public function downloadDonations(): StreamedResponse
    {
        $donations = $this->baseDonationQuery()
            ->latest()
            ->get();

        $filename = 'donation-report-' . now()->format('Y-m-d-His') . '.csv';

        return response()->streamDownload(function () use ($donations) {
            $handle = fopen('php://output', 'w');

            fputcsv($handle, [
                'Donor Name',
                'Batch',
                'School Year',
                'Amount',
                'Date',
            ]);

            foreach ($donations as $donation) {
                $donorName = $donation->alumni
                    ? trim(collect([
                        $donation->alumni->fname,
                        $donation->alumni->mname,
                        $donation->alumni->lname,
                    ])->filter()->implode(' '))
                    : '—';

                fputcsv($handle, [
                    $donorName,
                    $donation->alumni?->batch?->yeargrad ?? '—',
                    $donation->alumni?->batch?->schoolyear ?? '—',
                    $donation->amount,
                    $donation->created_at?->format('Y-m-d h:i A') ?? '—',
                ]);
            }

            fclose($handle);
        }, $filename, [
            'Content-Type' => 'text/csv',
        ]);
    }

    public function downloadBatchReport(): StreamedResponse
    {
        $batches = $this->baseBatchSummaryQuery()->get();

        $filename = 'batch-report-' . now()->format('Y-m-d-His') . '.csv';

        return response()->streamDownload(function () use ($batches) {
            $handle = fopen('php://output', 'w');

            fputcsv($handle, [
                'Year Graduated',
                'School Year',
                'Total Members',
            ]);

            foreach ($batches as $batch) {
                fputcsv($handle, [
                    $batch->yeargrad,
                    $batch->schoolyear,
                    $batch->alumni_count,
                ]);
            }

            fclose($handle);
        }, $filename, [
            'Content-Type' => 'text/csv',
        ]);
    }

    public function downloadEventRegistrations(): StreamedResponse
    {
        $registrations = $this->baseEventRegistrationQuery()
            ->latest()
            ->get();

        $filename = 'event-registrations-report-' . now()->format('Y-m-d-His') . '.csv';

        return response()->streamDownload(function () use ($registrations) {
            $handle = fopen('php://output', 'w');

            fputcsv($handle, [
                'Event',
                'Event Date',
                'Alumni Name',
                'Batch',
                'School Year',
                'Registration Status',
                'Registered At',
            ]);

            foreach ($registrations as $registration) {
                $alumniName = $registration->alumni
                    ? trim(collect([
                        $registration->alumni->fname,
                        $registration->alumni->mname,
                        $registration->alumni->lname,
                    ])->filter()->implode(' '))
                    : '—';

                fputcsv($handle, [
                    $registration->event?->title ?? '—',
                    $registration->event?->event_date?->format('Y-m-d h:i A') ?? '—',
                    $alumniName,
                    $registration->alumni?->batch?->yeargrad ?? '—',
                    $registration->alumni?->batch?->schoolyear ?? '—',
                    $registration->status ?? '—',
                    $registration->created_at?->format('Y-m-d h:i A') ?? '—',
                ]);
            }

            fclose($handle);
        }, $filename, [
            'Content-Type' => 'text/csv',
        ]);
    }

    public function downloadInvolvementReport(): StreamedResponse
    {
        $involvements = $this->baseInvolvementQuery()
            ->latest()
            ->get();

        $filename = 'alumni-involvement-report-' . now()->format('Y-m-d-His') . '.csv';

        return response()->streamDownload(function () use ($involvements) {
            $handle = fopen('php://output', 'w');

            fputcsv($handle, [
                'Alumni Name',
                'Batch',
                'School Year',
                'Committee Member',
                'Priest Concelebrate',
                'Medical Practitioner',
                'Medical Specialty',
                'Submitted At',
            ]);

            foreach ($involvements as $involvement) {
                $alumniName = $involvement->alumni
                    ? trim(collect([
                        $involvement->alumni->fname,
                        $involvement->alumni->mname,
                        $involvement->alumni->lname,
                    ])->filter()->implode(' '))
                    : '—';

                fputcsv($handle, [
                    $alumniName,
                    $involvement->alumni?->batch?->yeargrad ?? '—',
                    $involvement->alumni?->batch?->schoolyear ?? '—',
                    $involvement->wants_committee_member ? 'Yes' : 'No',
                    $involvement->is_priest_concelebrate ? 'Yes' : 'No',
                    $involvement->is_medical_practitioner ? 'Yes' : 'No',
                    $involvement->medical_specialty ?? '—',
                    $involvement->created_at?->format('Y-m-d h:i A') ?? '—',
                ]);
            }

            fclose($handle);
        }, $filename, [
            'Content-Type' => 'text/csv',
        ]);
    }

    public function render()
    {
        $donationQuery = $this->baseDonationQuery();

        $donations = (clone $donationQuery)
            ->latest()
            ->paginate(10, ['*'], 'donationsPage');

        $totalDonationsAmount = (clone $donationQuery)->sum('amount');
        $totalDonationCount = (clone $donationQuery)->count();

        $batchSummaryQuery = $this->baseBatchSummaryQuery();
        $batchReports = (clone $batchSummaryQuery)->get();

        $batchMembersQuery = $this->baseBatchMembersQuery();
        $batchMembers = (clone $batchMembersQuery)
            ->paginate(10, ['*'], 'batchMembersPage');

        $eventRegistrationQuery = $this->baseEventRegistrationQuery();

        $eventRegistrations = (clone $eventRegistrationQuery)
            ->latest()
            ->paginate(10, ['*'], 'eventRegistrationsPage');

        $totalEventRegistrations = (clone $eventRegistrationQuery)->count();
        $paidEventRegistrations = (clone $eventRegistrationQuery)->where('status', 'paid')->count();
        $pendingEventRegistrations = (clone $eventRegistrationQuery)->where('status', 'pending')->count();
        $rejectedEventRegistrations = (clone $eventRegistrationQuery)->where('status', 'rejected')->count();

        $involvementQuery = $this->baseInvolvementQuery();

        $involvements = (clone $involvementQuery)
            ->latest()
            ->paginate(10, ['*'], 'involvementPage');

        $totalInvolvements = (clone $involvementQuery)->count();

        $committeeCount = AlumniInvolvement::query()
            ->when($this->resolvedBatchId(), function ($query, $batchId) {
                $query->whereHas('alumni', fn ($q) => $q->where('batch_id', $batchId));
            })
            ->where('wants_committee_member', true)
            ->count();

        $priestCount = AlumniInvolvement::query()
            ->when($this->resolvedBatchId(), function ($query, $batchId) {
                $query->whereHas('alumni', fn ($q) => $q->where('batch_id', $batchId));
            })
            ->where('is_priest_concelebrate', true)
            ->count();

        $medicalCount = AlumniInvolvement::query()
            ->when($this->resolvedBatchId(), function ($query, $batchId) {
                $query->whereHas('alumni', fn ($q) => $q->where('batch_id', $batchId));
            })
            ->where('is_medical_practitioner', true)
            ->count();

        return view('livewire.reports', [
            'donations' => $donations,
            'totalDonationsAmount' => $totalDonationsAmount,
            'totalDonationCount' => $totalDonationCount,

            'batchReports' => $batchReports,
            'batchMembers' => $batchMembers,
            'totalBatchMembers' => (clone $batchMembersQuery)->count(),

            'eventRegistrations' => $eventRegistrations,
            'totalEventRegistrations' => $totalEventRegistrations,
            'paidEventRegistrations' => $paidEventRegistrations,
            'pendingEventRegistrations' => $pendingEventRegistrations,
            'rejectedEventRegistrations' => $rejectedEventRegistrations,

            'involvements' => $involvements,
            'totalInvolvements' => $totalInvolvements,
            'committeeCount' => $committeeCount,
            'priestCount' => $priestCount,
            'medicalCount' => $medicalCount,

            'allBatches' => $this->availableBatches(),
            'allEvents' => $this->availableEvents(),
            'currentBatch' => $this->selectedBatchModel(),

            'isBatchRepresentative' => $this->isBatchRepresentative(),
            'isReunionCoordinator' => $this->isReunionCoordinator(),
        ]);
    }
}