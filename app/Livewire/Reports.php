<?php

namespace App\Livewire;

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
    public string $selectedBatch = 'all';

    public string $selectedEvent = 'all';
    public string $registrationStatus = 'all';

    protected $queryString = [
        'tab' => ['except' => 'donations'],
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

    public function updatingDonationStartDate(): void
    {
        $this->resetPage('donationsPage');
    }

    public function updatingDonationEndDate(): void
    {
        $this->resetPage('donationsPage');
    }

    public function updatingSelectedEvent(): void
    {
        $this->resetPage('eventRegistrationsPage');
    }

    public function updatingRegistrationStatus(): void
    {
        $this->resetPage('eventRegistrationsPage');
    }

    public function updatedSelectedBatch(): void
    {
        if ($this->isBatchRepresentative()) {
            $this->selectedBatch = (string) ($this->getUserBatchId() ?? 'all');
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

    protected function baseDonationQuery(): Builder
    {
        $query = Donation::query()->with([
            'alumni.batch',
        ]);

        if ($this->isBatchRepresentative()) {
            $batchId = $this->getUserBatchId();

            if (! $batchId) {
                return $query->whereRaw('1 = 0');
            }

            $query->whereHas('alumni', function (Builder $q) use ($batchId) {
                $q->where('batch_id', $batchId);
            });
        } else {
            if ($this->selectedBatch !== 'all') {
                $selectedBatchId = (int) $this->selectedBatch;

                $query->whereHas('alumni', function (Builder $q) use ($selectedBatchId) {
                    $q->where('batch_id', $selectedBatchId);
                });
            }
        }

        if ($this->donationStartDate) {
            $query->whereDate('created_at', '>=', $this->donationStartDate);
        }

        if ($this->donationEndDate) {
            $query->whereDate('created_at', '<=', $this->donationEndDate);
        }

        return $query;
    }

    protected function baseBatchQuery(): Builder
    {
        $query = Batch::query()
            ->withCount('alumni')
            ->orderBy('yeargrad', 'desc');

        if ($this->isBatchRepresentative()) {
            $batchId = $this->getUserBatchId();

            if (! $batchId) {
                return $query->whereRaw('1 = 0');
            }

            return $query->where('id', $batchId);
        }

        if ($this->selectedBatch !== 'all') {
            $query->where('id', (int) $this->selectedBatch);
        }

        return $query;
    }

    protected function baseEventRegistrationQuery(): Builder
    {
        $query = EventRegistration::query()
            ->with([
                'event:id,title,slug,event_date,venue',
                'alumni:id,fname,lname,batch_id',
                'alumni.batch:id,yeargrad,schoolyear',
            ]);

        if ($this->selectedEvent !== 'all') {
            $query->where('event_id', (int) $this->selectedEvent);
        }

        if ($this->registrationStatus !== 'all') {
            $query->where('status', $this->registrationStatus);
        }

        if ($this->isBatchRepresentative()) {
            $batchId = $this->getUserBatchId();

            if (! $batchId) {
                return $query->whereRaw('1 = 0');
            }

            $query->whereHas('alumni', function (Builder $q) use ($batchId) {
                $q->where('batch_id', $batchId);
            });
        }

        return $query;
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
                    ? trim($donation->alumni->fname . ' ' . $donation->alumni->lname)
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
        $batches = $this->baseBatchQuery()->get();

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
                    ? trim($registration->alumni->fname . ' ' . $registration->alumni->lname)
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

    public function render()
    {
        $donationQuery = $this->baseDonationQuery();

        $donations = (clone $donationQuery)
            ->latest()
            ->paginate(10, ['*'], 'donationsPage');

        $totalDonationsAmount = (clone $donationQuery)->sum('amount');
        $totalDonationCount = (clone $donationQuery)->count();

        $batchReports = $this->baseBatchQuery()->get();

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
            'totalBatchMembers' => $batchReports->sum('alumni_count'),

            'eventRegistrations' => $eventRegistrations,
            'totalEventRegistrations' => $totalEventRegistrations,
            'paidEventRegistrations' => $paidEventRegistrations,
            'pendingEventRegistrations' => $pendingEventRegistrations,
            'rejectedEventRegistrations' => $rejectedEventRegistrations,

            'allBatches' => $this->availableBatches(),
            'allEvents' => $this->availableEvents(),

            'isBatchRepresentative' => $this->isBatchRepresentative(),
            'isReunionCoordinator' => $this->isReunionCoordinator(),
        ]);
    }
}