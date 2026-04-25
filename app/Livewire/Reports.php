<?php

namespace App\Livewire;

use App\Models\AlumniEducation;
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

#[Title('Reports')]
class Reports extends Component
{
    use WithPagination;

    public string $tab = 'donations';

    public ?string $donationStartDate = null;
    public ?string $donationEndDate = null;

    public string $selectedBatch = 'all';
    public string $selectedEvent = 'all';
    public string $registrationStatus = 'all';

    protected $queryString = [
        'tab' => ['except' => 'donations'],
        'selectedBatch' => ['except' => 'all'],
        'selectedEvent' => ['except' => 'all'],
        'registrationStatus' => ['except' => 'all'],
    ];

    public function mount(): void
    {
        if ($this->isBatchRepresentative()) {
            $batchId = $this->getUserRepresentativeBatchIds()->first();

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

    public function updatedSelectedBatch($value): void
    {
        if ($this->isBatchRepresentative()) {
            $this->selectedBatch = (string) ($this->getUserRepresentativeBatchId() ?? 'all');
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

    public function resetBatchFilter(): void
    {
        if ($this->isBatchRepresentative()) {
            $this->selectedBatch = (string) ($this->getUserRepresentativeBatchId() ?? 'all');
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

    protected function getUserRepresentativeBatchIds(): \Illuminate\Support\Collection
    {
        return $this->user()?->alumni?->educations()
            ->where('is_batch_rep', true)
            ->pluck('batch_id')
            ->map(fn ($id) => (int) $id) ?? collect();
    }

    protected function getUserRepresentativeBatchId(): ?int
    {
        $ids = $this->getUserRepresentativeBatchIds();
        if ($ids->isEmpty()) {
            return null;
        }
        if ($this->selectedBatch !== 'all' && $ids->contains((int) $this->selectedBatch)) {
            return (int) $this->selectedBatch;
        }
        return $ids->first();
    }

    protected function resolvedBatchId(): ?int
    {
        if ($this->isBatchRepresentative()) {
            return $this->getUserRepresentativeBatchId();
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

        return $query->whereHas($relation . '.educations', function (Builder $q) use ($batchId) {
            $q->where('batch_id', $batchId);
        });
    }

    protected function baseDonationQuery(): Builder
    {
        $query = Donation::query()
            ->with([
                'alumni:id,fname,lname,mname',
                'alumni.educations.batch:id,level,yeargrad,schoolyear',
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

    protected function baseBatchSummaryQuery()
    {
        $query = Batch::query()
            ->withCount('alumniEducations')
            ->orderByRaw("FIELD(level, 'elementary', 'highschool', 'college')")
            ->orderByDesc('yeargrad');

        $batchId = $this->resolvedBatchId();

        if ($batchId !== null) {
            $query->where('id', $batchId);
        }

        return $query;
    }

    protected function baseBatchMembersQuery(): Builder
    {
        $query = AlumniEducation::query()
            ->with([
                'batch:id,level,yeargrad,schoolyear',
                'alumni:id,fname,lname,mname,occupation,address_line_1,address_line_2,city,state_province,postal_code,country,cellphone',
            ])
            ->orderBy('batch_id')
            ->orderByDesc('is_batch_rep')
            ->orderBy(
                \App\Models\Alumni::select('lname')
                    ->whereColumn('alumni.id', 'alumni_educations.alumni_id')
                    ->limit(1)
            )
            ->orderBy(
                \App\Models\Alumni::select('fname')
                    ->whereColumn('alumni.id', 'alumni_educations.alumni_id')
                    ->limit(1)
            );

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
                'alumni:id,fname,lname,mname',
                'alumni.educations.batch:id,level,yeargrad,schoolyear',
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

    protected function availableBatches()
    {
        if ($this->isBatchRepresentative()) {
            $batchId = $this->getUserRepresentativeBatchId();

            if (! $batchId) {
                return collect();
            }

            return Batch::query()
                ->where('id', $batchId)
                ->orderByRaw("FIELD(level, 'elementary', 'highschool', 'college')")
                ->orderByDesc('yeargrad')
                ->get(['id', 'level', 'yeargrad', 'schoolyear']);
        }

        return Batch::query()
            ->orderByRaw("FIELD(level, 'elementary', 'highschool', 'college')")
            ->orderByDesc('yeargrad')
            ->get(['id', 'level', 'yeargrad', 'schoolyear']);
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
            ->select(['id', 'level', 'yeargrad', 'schoolyear'])
            ->find($batchId);
    }

    protected function matchedEducationForAlumni($alumni, ?int $batchId = null)
    {
        if (! $alumni) {
            return null;
        }

        $educations = $alumni->educations ?? collect();

        if ($batchId) {
            return $educations->firstWhere('batch_id', $batchId)
                ?? $educations->first();
        }

        return $educations->sortBy(fn ($edu) => match($edu->batch?->level) {
            'elementary' => 1,
            'highschool' => 2,
            'college' => 3,
            default => 99,
        })->first();
    }

    public function downloadDonations(): StreamedResponse
    {
        $batchId = $this->resolvedBatchId();

        $donations = $this->baseDonationQuery()
            ->latest()
            ->get();

        $filename = 'donation-report-' . now()->format('Y-m-d-His') . '.csv';

        return response()->streamDownload(function () use ($donations, $batchId) {
            $handle = fopen('php://output', 'w');

            fputcsv($handle, [
                'Donor Name',
                'Level',
                'Batch',
                'School Year',
                'Amount',
                'Date',
            ]);

            foreach ($donations as $donation) {
                $education = $this->matchedEducationForAlumni($donation->alumni, $batchId);

                $donorName = $donation->alumni
                    ? trim(collect([
                        $donation->alumni->fname,
                        $donation->alumni->mname,
                        $donation->alumni->lname,
                    ])->filter()->implode(' '))
                    : '-';

                fputcsv($handle, [
                    $donorName,
                    $education?->batch?->level ? str($education->batch->level)->headline()->toString() : '-',
                    $education?->batch?->yeargrad ?? '-',
                    $education?->batch?->schoolyear ?? '-',
                    $donation->amount,
                    $donation->created_at?->format('Y-m-d h:i A') ?? '-',
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
                'Level',
                'Year Graduated',
                'School Year',
                'Total Membership Records',
            ]);

            foreach ($batches as $batch) {
                fputcsv($handle, [
                    str($batch->level)->headline()->toString(),
                    $batch->yeargrad,
                    $batch->schoolyear,
                    $batch->alumni_educations_count,
                ]);
            }

            fclose($handle);
        }, $filename, [
            'Content-Type' => 'text/csv',
        ]);
    }

    public function downloadBatchMembers(): StreamedResponse
    {
        $members = $this->baseBatchMembersQuery()->get();

        $filename = 'batch-members-report-' . now()->format('Y-m-d-His') . '.csv';

        return response()->streamDownload(function () use ($members) {
            $handle = fopen('php://output', 'w');

            fputcsv($handle, [
                'Full Name',
                'Level',
                'Batch',
                'School Year',
                'Did Graduate',
                'Batch Representative',
                'Occupation',
                'Cellphone',
                'Address Line 1',
                'Address Line 2',
                'City',
                'State/Province',
                'Postal Code',
                'Country',
            ]);

            foreach ($members as $member) {
                $fullName = trim(collect([
                    $member->alumni?->fname,
                    $member->alumni?->mname,
                    $member->alumni?->lname,
                ])->filter()->implode(' '));

                fputcsv($handle, [
                    $fullName ?: '-',
                    $member->batch?->level ? str($member->batch->level)->headline()->toString() : '-',
                    $member->batch?->yeargrad ?? '-',
                    $member->batch?->schoolyear ?? '-',
                    $member->did_graduate ? 'Yes' : 'No',
                    $member->is_batch_rep ? 'Yes' : 'No',
                    $member->alumni?->occupation ?? '-',
                    $member->alumni?->cellphone ?? '-',
                    $member->alumni?->address_line_1 ?? '-',
                    $member->alumni?->address_line_2 ?? '-',
                    $member->alumni?->city ?? '-',
                    $member->alumni?->state_province ?? '-',
                    $member->alumni?->postal_code ?? '-',
                    $member->alumni?->country ?? '-',
                ]);
            }

            fclose($handle);
        }, $filename, [
            'Content-Type' => 'text/csv',
        ]);
    }

    public function downloadEventRegistrations(): StreamedResponse
    {
        $batchId = $this->resolvedBatchId();

        $registrations = $this->baseEventRegistrationQuery()
            ->latest()
            ->get();

        $filename = 'event-registrations-report-' . now()->format('Y-m-d-His') . '.csv';

        return response()->streamDownload(function () use ($registrations, $batchId) {
            $handle = fopen('php://output', 'w');

            fputcsv($handle, [
                'Event',
                'Event Date',
                'Alumni Name',
                'Level',
                'Batch',
                'School Year',
                'Registration Status',
                'Registered At',
            ]);

            foreach ($registrations as $registration) {
                $education = $this->matchedEducationForAlumni($registration->alumni, $batchId);

                $alumniName = $registration->alumni
                    ? trim(collect([
                        $registration->alumni->fname,
                        $registration->alumni->mname,
                        $registration->alumni->lname,
                    ])->filter()->implode(' '))
                    : '-';

                fputcsv($handle, [
                    $registration->event?->title ?? '-',
                    $registration->event?->event_date?->format('Y-m-d h:i A') ?? '-',
                    $alumniName,
                    $education?->batch?->level ? str($education->batch->level)->headline()->toString() : '-',
                    $education?->batch?->yeargrad ?? '-',
                    $education?->batch?->schoolyear ?? '-',
                    $registration->status ?? '-',
                    $registration->created_at?->format('Y-m-d h:i A') ?? '-',
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

            'allBatches' => $this->availableBatches(),
            'allEvents' => $this->availableEvents(),
            'currentBatch' => $this->selectedBatchModel(),

            'isBatchRepresentative' => $this->isBatchRepresentative(),
            'isReunionCoordinator' => $this->isReunionCoordinator(),
            'repBatches' => $this->isBatchRepresentative()
                ? Batch::whereIn('id', $this->getUserRepresentativeBatchIds())->get(['id', 'level', 'yeargrad', 'schoolyear'])
                : collect(),
        ]);
    }
}