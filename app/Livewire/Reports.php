<?php

namespace App\Livewire;

use App\Models\Batch;
use App\Models\Donation;
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

    public function render()
    {
        $donationQuery = $this->baseDonationQuery();

        $donations = (clone $donationQuery)
            ->latest()
            ->paginate(10, ['*'], 'donationsPage');

        $totalDonationsAmount = (clone $donationQuery)->sum('amount');
        $totalDonationCount = (clone $donationQuery)->count();

        $batchReports = $this->baseBatchQuery()->get();
        $allBatches = $this->availableBatches();

        return view('livewire.reports', [
            'donations' => $donations,
            'totalDonationsAmount' => $totalDonationsAmount,
            'totalDonationCount' => $totalDonationCount,
            'batchReports' => $batchReports,
            'allBatches' => $allBatches,
            'totalBatchMembers' => $batchReports->sum('alumni_count'),
            'isBatchRepresentative' => $this->isBatchRepresentative(),
            'isReunionCoordinator' => $this->isReunionCoordinator(),
        ]);
    }
}