<?php

namespace App\Livewire;

use App\Models\AlumniEducation;
use App\Models\Donation;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

#[Title('Batch Donations')]
class ManageDonations extends Component
{
    use WithPagination, WithFileUploads;

    public string $search = '';
    public string $status = 'all'; // all | pending | verified | rejected | paid | unpaid
    public string $sort = 'latest'; // latest | oldest | amount_desc | amount_asc
    public int $perPage = 10;

    public ?int $scopeBatchId = null;
    public ?int $scopeEducationId = null;

    public ?int $approvingId = null;
    public ?int $rejectingId = null;
    public string $rejectReason = '';

    // Batch donation upload (batch-rep only)
    public bool         $showUploadModal  = false;
    public int|string   $uploadAmount     = '';
    public string       $uploadReference  = '';
    public string       $uploadRemarks    = '';
    public mixed        $uploadProof      = null;

    protected array $rules = [
        'rejectReason'    => 'required|string|max:500',
        'uploadAmount'    => 'required|integer|min:1',
        'uploadReference' => 'nullable|string|max:100',
        'uploadRemarks'   => 'nullable|string|max:500',
        'uploadProof'     => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120',
    ];

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

    public function openApproveModal(int $id): void
    {
        abort_if(auth()->user()?->hasRole('batch-representative'), 403);

        $this->approvingId = $id;
        $this->dispatch('open-approve-modal');
    }

    public function confirmApprove(): void
    {
        abort_if(auth()->user()?->hasRole('batch-representative'), 403);

        Donation::findOrFail($this->approvingId)->update([
            'status'           => 'verified',
            'reviewed_by'      => auth()->id(),
            'reviewed_at'      => now(),
            'rejection_reason' => null,
        ]);

        $this->approvingId = null;
        $this->dispatch('close-approve-modal');
    }

    public function openRejectModal(int $id): void
    {
        abort_if(auth()->user()?->hasRole('batch-representative'), 403);

        $this->rejectingId  = $id;
        $this->rejectReason = '';
        $this->resetValidation();
        $this->dispatch('open-reject-modal');
    }

    public function submitReject(): void
    {
        abort_if(auth()->user()?->hasRole('batch-representative'), 403);

        $this->validate(['rejectReason' => 'required|string|max:500']);

        Donation::findOrFail($this->rejectingId)->update([
            'status'           => 'rejected',
            'reviewed_by'      => auth()->id(),
            'reviewed_at'      => now(),
            'rejection_reason' => trim($this->rejectReason),
        ]);

        $this->rejectingId  = null;
        $this->rejectReason = '';
        $this->dispatch('close-reject-modal');
    }

    public function openUploadModal(): void
    {
        abort_unless(auth()->user()?->hasRole('batch-representative'), 403);

        $this->resetUploadForm();
        $this->showUploadModal = true;
    }

    public function closeUploadModal(): void
    {
        $this->showUploadModal = false;
        $this->resetUploadForm();
    }

    public function submitBatchDonation(): void
    {
        abort_unless(auth()->user()?->hasRole('batch-representative'), 403);

        $this->validate([
            'uploadAmount'    => 'required|integer|min:1',
            'uploadReference' => 'nullable|string|max:100',
            'uploadRemarks'   => 'nullable|string|max:500',
            'uploadProof'     => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120',
        ]);

        $alumniId = auth()->user()?->alumni_id;
        abort_if(! $alumniId, 403, 'Alumni profile required.');

        $education  = $this->representativeEducation();
        $batchYear  = $education?->batch?->yeargrad;
        $defaultRemark = $batchYear
            ? "Batch {$batchYear} collective donation"
            : 'Batch collective donation';

        $proofPath = $this->uploadProof->storePublicly('donation-proofs', 's3');

        Donation::create([
            'alumni_id'        => $alumniId,
            'amount'           => (int) $this->uploadAmount,
            'date_donated'     => now(),
            'remarks'          => trim($this->uploadRemarks) ?: $defaultRemark,
            'reference_number' => trim($this->uploadReference) ?: null,
            'or_file_path'     => $proofPath,
            'status'           => 'pending',
            'paid_at'          => null,
        ]);

        $this->closeUploadModal();
        session()->flash('success', 'Batch donation submitted. Awaiting admin verification.');
    }

    private function resetUploadForm(): void
    {
        $this->uploadAmount    = '';
        $this->uploadReference = '';
        $this->uploadRemarks   = '';
        $this->uploadProof     = null;
        $this->resetValidation([
            'uploadAmount', 'uploadReference', 'uploadRemarks', 'uploadProof',
        ]);
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

        $baseClone = fn () => clone $this->baseQuery();

        $verifiedPaidTotal = $baseClone()->where('status', 'verified')->sum('amount');
        $totalAmount       = $baseClone()->sum('amount');
        $pendingCount      = $baseClone()->where('status', 'pending')->count();
        $verifiedCount     = $baseClone()->where('status', 'verified')->count();
        $rejectedCount     = $baseClone()->where('status', 'rejected')->count();
        $totalCount        = $baseClone()->count();

        return view('livewire.manage-donations', [
            'donations'        => $donations,
            'verifiedPaidTotal'=> $verifiedPaidTotal,
            'totalAmount'      => $totalAmount,
            'pendingCount'     => $pendingCount,
            'verifiedCount'    => $verifiedCount,
            'rejectedCount'    => $rejectedCount,
            'totalCount'       => $totalCount,
            'scopeBatchId'     => $this->scopeBatchId,
            'scopeEducationId' => $this->scopeEducationId,
            'currentEducation' => $this->representativeEducation(),
        ]);
    }
}