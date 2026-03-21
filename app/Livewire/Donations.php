<?php

namespace App\Livewire;

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

    public string $statusFilter = 'all';
    public string $search = '';

    public ?int $rejectingDonationId = null;
    public string $rejectionReason = '';

    protected string $paginationTheme = 'tailwind';

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingStatusFilter(): void
    {
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
            'status' => 'verified',
            'reviewed_by' => Auth::id(),
            'reviewed_at' => now(),
            'rejection_reason' => null,
            'paid_at' => now(),
        ]);

        session()->flash('success', 'Donation verified successfully.');
    }

    public function openRejectModal(int $donationId): void
    {
        $this->rejectingDonationId = $donationId;
        $this->rejectionReason = '';
    }

    public function closeRejectModal(): void
    {
        $this->rejectingDonationId = null;
        $this->rejectionReason = '';
    }

    public function rejectDonation(): void
    {
        $this->validate([
            'rejectingDonationId' => ['required', 'integer', 'exists:donations,id'],
            'rejectionReason' => ['required', 'string', 'max:1000'],
        ]);

        $donation = Donation::findOrFail($this->rejectingDonationId);

        if ($donation->status !== 'pending') {
            session()->flash('error', 'Only pending donations can be rejected.');
            $this->closeRejectModal();
            return;
        }

        $donation->update([
            'status' => 'rejected',
            'reviewed_by' => Auth::id(),
            'reviewed_at' => now(),
            'rejection_reason' => $this->rejectionReason,
            'paid_at' => null,
        ]);

        $this->closeRejectModal();

        session()->flash('success', 'Donation rejected successfully.');
    }

    public function render()
    {
        $donations = Donation::query()
            ->with(['alumni', 'reviewer'])
            ->when(
                $this->statusFilter !== 'all',
                fn (Builder $query) => $query->where('status', $this->statusFilter)
            )
            ->when($this->search !== '', function (Builder $query) {
                $search = trim($this->search);

                $query->where(function (Builder $subQuery) use ($search) {
                    $subQuery
                        ->where('reference_number', 'like', "%{$search}%")
                        ->orWhere('remarks', 'like', "%{$search}%")
                        ->orWhereHas('alumni', function (Builder $alumniQuery) use ($search) {
                            $alumniQuery
                                ->where('fname', 'like', "%{$search}%")
                                ->orWhere('lname', 'like', "%{$search}%")
                                ->orWhereRaw("CONCAT(fname, ' ', lname) LIKE ?", ["%{$search}%"]);
                        });
                });
            })
            ->latest()
            ->paginate(10);

        return view('livewire.donations', [
            'donations' => $donations,
        ]);
    }
}