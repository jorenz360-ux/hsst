<?php

namespace App\Livewire;

use App\Models\AlumniEducation;
use App\Models\Donation;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('Batch Donations')]
class ManageDonations extends Component
{
    use WithPagination;

    public string $search = '';
    public string $status = 'all'; // all | pending | verified | rejected | paid | unpaid
    public string $sort = 'latest'; // latest | oldest | amount_desc | amount_asc
    public int $perPage = 10;

    public ?int $scopeBatchId = null;
    public ?int $scopeEducationId = null;

    protected $paginationTheme = 'tailwind';

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
            $education = $this->representativeEducation();

            abort_if(blank($education?->batch_id), 403, 'You are not assigned to any batch.');

            $this->scopeEducationId = $education->id;
            $this->scopeBatchId = (int) $education->batch_id;
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

    protected function representativeEducation(): ?AlumniEducation
    {
        return auth()->user()?->alumni?->educations()
            ->with('batch')
            ->where('is_batch_rep', true)
            ->first();
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
                'alumni:id,fname,mname,lname',
                'alumni.educations' => function ($query) {
                    $query->select([
                        'id',
                        'alumni_id',
                        'batch_id',
                        'is_batch_rep',
                    ])->with([
                        'batch:id,level,yeargrad,schoolyear',
                    ]);
                },
            ])
            ->when($user?->hasRole('batch-representative'), function (Builder $q) {
                $q->whereHas('alumni.educations', function (Builder $aq) {
                    $aq->where('batch_id', $this->scopeBatchId);
                });
            })
            ->when(trim($this->search) !== '', function (Builder $q) {
                $term = '%' . trim($this->search) . '%';

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
            'scopeEducationId' => $this->scopeEducationId,
            'currentEducation' => $this->representativeEducation(),
        ]);
    }
}