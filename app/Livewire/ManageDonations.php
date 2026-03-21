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
    public string $status = 'all'; // all | pending | verified | rejected | paid | unpaid
    public string $sort = 'latest'; // latest | oldest | amount_desc | amount_asc
    public int $perPage = 10;

    public ?int $scopeBatchId = null;

    protected $queryString = [
        'search' => ['except' => ''],
        'status' => ['except' => 'all'],
        'sort' => ['except' => 'latest'],
        'page' => ['except' => 1],
    ];

    public function mount(): void
    {
        $user = auth()->user();

        if ($user?->hasRole('batch-representative')) {
            $this->scopeBatchId = $user->alumni?->batch_id;

            abort_if(blank($this->scopeBatchId), 403);
        }
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingStatus(): void
    {
        $this->resetPage();
    }

    public function updatingSort(): void
    {
        $this->resetPage();
    }

    public function updatingPerPage(): void
    {
        $this->resetPage();
    }

    protected function baseQuery(): Builder
    {
        $user = auth()->user();

        $query = Donation::query()
            ->select([
                'id',
                'alumni_id',
                'amount',
                'is_paid',
                'paid_at',
                'date_donated',
                'remarks',
                'reference_number',
                'or_file_path',
                'status',
                'reviewed_by',
                'reviewed_at',
                'rejection_reason',
                'created_at',
            ])
            ->with([
                'alumni:id,fname,mname,lname,batch_id',
                'alumni.batch:id,yeargrad,schoolyear',
            ])
            ->when($user?->hasRole('batch-representative'), function (Builder $q) {
                $q->whereHas('alumni', function (Builder $aq) {
                    $aq->where('batch_id', $this->scopeBatchId);
                });
            })
            ->when($this->search !== '', function (Builder $q) {
                $term = '%' . $this->search . '%';

                $q->where(function (Builder $qq) use ($term) {
                    $qq->whereHas('alumni', function (Builder $aq) use ($term) {
                        $aq->where('fname', 'like', $term)
                            ->orWhere('lname', 'like', $term)
                            ->orWhere('mname', 'like', $term);
                    })
                    ->orWhere('reference_number', 'like', $term)
                    ->orWhere('remarks', 'like', $term)
                    ->orWhere('status', 'like', $term);
                });
            })
            ->when($this->status !== 'all', function (Builder $q) {
                match ($this->status) {
                    'pending' => $q->where('status', 'pending'),
                    'verified' => $q->where('status', 'verified'),
                    'rejected' => $q->where('status', 'rejected'),
                    'paid' => $q->where('is_paid', true),
                    'unpaid' => $q->where('is_paid', false),
                    default => $q,
                };
            });

        return match ($this->sort) {
            'oldest' => $query->orderBy('created_at'),
            'amount_desc' => $query->orderByDesc('amount')->orderByDesc('created_at'),
            'amount_asc' => $query->orderBy('amount')->orderByDesc('created_at'),
            default => $query->orderByDesc('created_at'),
        };
    }

    public function render()
    {
        $query = $this->baseQuery();

        $donations = (clone $query)->paginate($this->perPage);

        $verifiedPaidTotal = (clone $this->baseQuery())
            ->where('status', 'verified')
            ->sum('amount');

        $pendingCount = (clone $this->baseQuery())
            ->where('status', 'pending')
            ->count();

        return view('livewire.manage-donations', [
            'donations' => $donations,
            'verifiedPaidTotal' => $verifiedPaidTotal,
            'pendingCount' => $pendingCount,
            'scopeBatchId' => $this->scopeBatchId,
        ]);
    }
}