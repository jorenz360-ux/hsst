<?php

namespace App\Livewire;

use App\Models\Donation;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Livewire\WithPagination;

class ManageDonations extends Component
{
    use WithPagination;

    public string $search = '';
    public string $status = 'all';   // all | paid | unpaid
    public int $perPage = 5;

    // Optional: show label on UI
    public ?int $scopeBatchId = null;

    protected $queryString = [
        'search' => ['except' => ''],
        'status' => ['except' => 'all'],
        'page'   => ['except' => 1],
    ];

    public function mount(): void
    {
        $user = auth()->user();

        // If batch rep, lock scope to their batch
        if ($user?->hasRole('batch-representative')) {
            $this->scopeBatchId = $user->alumni?->batch_id;

            // If somehow no alumni/batch linked, block (avoid leaking data)
            abort_if(blank($this->scopeBatchId), 403);
        }
    }

    public function updatingSearch(): void { $this->resetPage(); }
    public function updatingStatus(): void { $this->resetPage(); }
    public function updatingPerPage(): void { $this->resetPage(); }

    public function render()
    {
        $user = auth()->user();

        $query = Donation::query()
            ->select(['id','alumni_id','amount','paymongo_checkout_session_id','paid_at','created_at'])
            ->with(['alumni:id,fname,mname,lname,batch_id', 'alumni.batch:id,yeargrad'])
            // 🔒 Batch scope (only if batch rep)
            ->when($user->hasRole('batch-representative'), function (Builder $q) {
                $q->whereHas('alumni', fn (Builder $aq) =>
                    $aq->where('batch_id', $this->scopeBatchId)
                );
            })
            // Search
            ->when($this->search !== '', function (Builder $q) {
                $term = '%' . $this->search . '%';

                $q->where(function (Builder $qq) use ($term) {
                    $qq->whereHas('alumni', function (Builder $aq) use ($term) {
                        $aq->where('fname', 'like', $term)
                           ->orWhere('lname', 'like', $term)
                           ->orWhere('mname', 'like', $term);
                    })->orWhere('paymongo_checkout_session_id', 'like', $term);
                });
            })
            // Status filter
            ->when($this->status !== 'all', function (Builder $q) {
                $this->status === 'paid'
                    ? $q->whereNotNull('paid_at')
                    : $q->whereNull('paid_at');
            })
            ->orderByDesc('created_at');

        $donations = $query->paginate($this->perPage);

        // Totals (respect the same scope + filters)
        $paidTotal = (clone $query)->whereNotNull('paid_at')->sum('amount');

        return view('livewire.manage-donations', [
            'donations' => $donations,
            'paidTotal' => $paidTotal,
            'scopeBatchId' => $this->scopeBatchId,
        ]);
    }
}