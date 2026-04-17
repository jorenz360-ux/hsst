<?php

namespace App\Livewire;

use App\Models\Batch;
use App\Models\Donation;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('Donation Verification')]
class Donations extends Component
{
    use WithPagination;

    public string $statusFilter  = 'all';
    public string $paymentFilter = 'all'; // all | paid | unpaid
    public string $search        = '';
    public ?int   $batchFilter   = null;
    public string $dateFrom      = '';
    public string $dateTo        = '';
    public string $amountMin     = '';
    public string $amountMax     = '';

    public ?int   $rejectingDonationId = null;
    public string $rejectionReason     = '';

    protected string $paginationTheme = 'tailwind';

    public function updatingSearch(): void        { $this->resetPage(); }
    public function updatingStatusFilter(): void  { $this->resetPage(); }
    public function updatingPaymentFilter(): void { $this->resetPage(); }
    public function updatingBatchFilter(): void   { $this->resetPage(); }
    public function updatingDateFrom(): void      { $this->resetPage(); }
    public function updatingDateTo(): void        { $this->resetPage(); }
    public function updatingAmountMin(): void     { $this->resetPage(); }
    public function updatingAmountMax(): void     { $this->resetPage(); }

    public function clearFilters(): void
    {
        $this->statusFilter  = 'all';
        $this->paymentFilter = 'all';
        $this->search        = '';
        $this->batchFilter   = null;
        $this->dateFrom      = '';
        $this->dateTo        = '';
        $this->amountMin     = '';
        $this->amountMax     = '';
        $this->resetPage();
    }

    public function verifyDonation(int $donationId): void
    {
        $donation = Donation::findOrFail($donationId);

        if ($donation->status !== 'pending') {
            session()->flash('error', 'Only pending donations can be verified.');
            return;
        }

        $donation->update([
            'status'           => 'verified',
            'reviewed_by'      => Auth::id(),
            'reviewed_at'      => now(),
            'rejection_reason' => null,
            'paid_at'          => now(),
        ]);

        session()->flash('success', 'Donation verified successfully.');
    }

    public function openRejectModal(int $donationId): void
    {
        $this->rejectingDonationId = $donationId;
        $this->rejectionReason     = '';
    }

    public function closeRejectModal(): void
    {
        $this->rejectingDonationId = null;
        $this->rejectionReason     = '';
    }

    public function rejectDonation(): void
    {
        $this->validate([
            'rejectingDonationId' => ['required', 'integer', 'exists:donations,id'],
            'rejectionReason'     => ['required', 'string', 'max:1000'],
        ]);

        $donation = Donation::findOrFail($this->rejectingDonationId);

        if ($donation->status !== 'pending') {
            session()->flash('error', 'Only pending donations can be rejected.');
            $this->closeRejectModal();
            return;
        }

        $donation->update([
            'status'           => 'rejected',
            'reviewed_by'      => Auth::id(),
            'reviewed_at'      => now(),
            'rejection_reason' => $this->rejectionReason,
            'paid_at'          => null,
        ]);

        $this->closeRejectModal();
        session()->flash('success', 'Donation rejected successfully.');
    }

    protected function baseQuery(): Builder
    {
        return Donation::query()
            ->with(['alumni.educations.batch', 'reviewer'])
            ->when($this->statusFilter !== 'all',
                fn (Builder $q) => $q->where('status', $this->statusFilter)
            )
            ->when($this->paymentFilter === 'paid',
                fn (Builder $q) => $q->where('is_paid', true)
            )
            ->when($this->paymentFilter === 'unpaid',
                fn (Builder $q) => $q->where('is_paid', false)
            )
            ->when($this->batchFilter,
                fn (Builder $q) => $q->whereHas('alumni.educations', function (Builder $eq) {
                    $eq->where('batch_id', $this->batchFilter);
                })
            )
            ->when($this->dateFrom !== '', function (Builder $q) {
                $q->where(function (Builder $sub) {
                    $sub->whereDate('date_donated', '>=', $this->dateFrom)
                        ->orWhereDate('created_at', '>=', $this->dateFrom);
                });
            })
            ->when($this->dateTo !== '', function (Builder $q) {
                $q->where(function (Builder $sub) {
                    $sub->whereDate('date_donated', '<=', $this->dateTo)
                        ->orWhereDate('created_at', '<=', $this->dateTo);
                });
            })
            ->when($this->amountMin !== '',
                fn (Builder $q) => $q->where('amount', '>=', (float) $this->amountMin)
            )
            ->when($this->amountMax !== '',
                fn (Builder $q) => $q->where('amount', '<=', (float) $this->amountMax)
            )
            ->when($this->search !== '', function (Builder $q) {
                $term = trim($this->search);
                $q->where(function (Builder $sub) use ($term) {
                    $sub->where('reference_number', 'like', "%{$term}%")
                        ->orWhere('remarks', 'like', "%{$term}%")
                        ->orWhereHas('alumni', function (Builder $aq) use ($term) {
                            $aq->where('fname', 'like', "%{$term}%")
                               ->orWhere('lname', 'like', "%{$term}%")
                               ->orWhereRaw("CONCAT(fname, ' ', lname) LIKE ?", ["%{$term}%"]);
                        });
                });
            });
    }

    public function render()
    {
        $query = $this->baseQuery();

        $donations    = (clone $query)->latest()->paginate(10);
        $totalAmount  = (clone $query)->sum('amount');
        $pendingCount = (clone $query)->where('status', 'pending')->count();

        $batches = Batch::orderByDesc('yeargrad')->get(['id', 'yeargrad', 'schoolyear']);

        $hasActiveFilters = $this->statusFilter  !== 'all'
                         || $this->paymentFilter !== 'all'
                         || $this->batchFilter   !== null
                         || $this->dateFrom      !== ''
                         || $this->dateTo        !== ''
                         || $this->amountMin     !== ''
                         || $this->amountMax     !== ''
                         || $this->search        !== '';

        return view('livewire.donations', [
            'donations'        => $donations,
            'batches'          => $batches,
            'totalAmount'      => $totalAmount,
            'pendingCount'     => $pendingCount,
            'hasActiveFilters' => $hasActiveFilters,
        ]);
    }
}
