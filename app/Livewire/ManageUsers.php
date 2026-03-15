<?php

namespace App\Livewire;

use App\Models\Batch;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Title;

#[Title('Users')]
class ManageUsers extends Component
{
    use WithPagination;

    public const DEFAULT_ROLE = 'all';
    public const DEFAULT_BATCH = 'all';
    public const DEFAULT_YEAR_GRAD = 'all';
    public const DEFAULT_SCHOOL_YEAR = 'all';
    public const DEFAULT_BATCH_REP = 'all';
    public const DEFAULT_HAS_ALUMNI = 'all';
    public const DEFAULT_PER_PAGE = 10;

    public string $search = '';
    public string $role = self::DEFAULT_ROLE;
    public string $batchId = self::DEFAULT_BATCH;
    public string $yearGrad = self::DEFAULT_YEAR_GRAD;
    public string $schoolyear = self::DEFAULT_SCHOOL_YEAR;
    public string $isBatchRep = self::DEFAULT_BATCH_REP;
    public string $hasAlumni = self::DEFAULT_HAS_ALUMNI;
    public int $perPage = self::DEFAULT_PER_PAGE;

    protected $queryString = [
        'search' => ['except' => ''],
        'role' => ['except' => self::DEFAULT_ROLE],
        'batchId' => ['except' => self::DEFAULT_BATCH],
        'yearGrad' => ['except' => self::DEFAULT_YEAR_GRAD],
        'schoolyear' => ['except' => self::DEFAULT_SCHOOL_YEAR],
        'isBatchRep' => ['except' => self::DEFAULT_BATCH_REP],
        'hasAlumni' => ['except' => self::DEFAULT_HAS_ALUMNI],
        'perPage' => ['except' => self::DEFAULT_PER_PAGE],
        'page' => ['except' => 1],
    ];

    public function updated($property): void
    {
        if (in_array($property, [
            'search',
            'role',
            'batchId',
            'yearGrad',
            'schoolyear',
            'isBatchRep',
            'hasAlumni',
            'perPage',
        ], true)) {
            $this->resetPage();
        }
    }

    public function resetFilters(): void
    {
        $this->search = '';
        $this->role = self::DEFAULT_ROLE;
        $this->batchId = self::DEFAULT_BATCH;
        $this->yearGrad = self::DEFAULT_YEAR_GRAD;
        $this->schoolyear = self::DEFAULT_SCHOOL_YEAR;
        $this->isBatchRep = self::DEFAULT_BATCH_REP;
        $this->hasAlumni = self::DEFAULT_HAS_ALUMNI;
        $this->perPage = self::DEFAULT_PER_PAGE;

        $this->resetPage();
    }

    public function edit(int $userId)
    {
        return $this->redirect(route('users.edit', $userId), navigate: true);
    }

    protected function getRoleOptions(): array
    {
        return [
            'all',
            'reunion-coordinator',
            'ssps',
            'batch-representative',
            'alumni',
        ];
    }

    protected function getUsersQuery()
    {
        return User::query()
            ->with(['roles', 'alumni.batch'])
            ->when($this->search !== '', function ($query) {
                $search = '%' . trim($this->search) . '%';

                $query->where(function ($q) use ($search) {
                    $q->where('username', 'like', $search)
                        ->orWhere('email', 'like', $search)
                        ->orWhereHas('alumni', function ($aq) use ($search) {
                            $aq->where('fname', 'like', $search)
                                ->orWhere('lname', 'like', $search)
                                ->orWhere('mname', 'like', $search)
                                ->orWhereRaw("CONCAT(fname, ' ', lname) LIKE ?", [$search])
                                ->orWhereRaw("CONCAT(lname, ', ', fname) LIKE ?", [$search]);
                        })
                        ->orWhereHas('alumni.batch', function ($bq) use ($search) {
                            $bq->where('schoolyear', 'like', $search)
                                ->orWhere('yeargrad', 'like', $search);
                        });
                });
            })
            ->when($this->role !== self::DEFAULT_ROLE, function ($query) {
                $query->whereHas('roles', function ($roleQuery) {
                    $roleQuery->where('name', $this->role);
                });
            })
            ->when($this->hasAlumni === 'yes', function ($query) {
                $query->whereNotNull('alumni_id');
            })
            ->when($this->hasAlumni === 'no', function ($query) {
                $query->whereNull('alumni_id');
            })
            ->when($this->batchId !== self::DEFAULT_BATCH, function ($query) {
                $query->whereHas('alumni', function ($alumniQuery) {
                    $alumniQuery->where('batch_id', $this->batchId);
                });
            })
            ->when($this->yearGrad !== self::DEFAULT_YEAR_GRAD, function ($query) {
                $query->whereHas('alumni.batch', function ($batchQuery) {
                    $batchQuery->where('yeargrad', $this->yearGrad);
                });
            })
            ->when($this->schoolyear !== self::DEFAULT_SCHOOL_YEAR, function ($query) {
                $query->whereHas('alumni.batch', function ($batchQuery) {
                    $batchQuery->where('schoolyear', $this->schoolyear);
                });
            })
            ->when($this->isBatchRep === 'yes', function ($query) {
                $query->whereHas('alumni', function ($alumniQuery) {
                    $alumniQuery->where('is_batch_rep', true);
                });
            })
            ->when($this->isBatchRep === 'no', function ($query) {
                $query->whereHas('alumni', function ($alumniQuery) {
                    $alumniQuery->where('is_batch_rep', false);
                });
            });
    }

    protected function getBatchOptions()
    {
        return Batch::query()
            ->orderByDesc('yeargrad')
            ->orderByDesc('schoolyear')
            ->get(['id', 'schoolyear', 'yeargrad']);
    }

    protected function getyearGradOptions()
    {
        return Batch::query()
            ->whereNotNull('yeargrad')
            ->select('yeargrad')
            ->distinct()
            ->orderByDesc('yeargrad')
            ->pluck('yeargrad');
    }

    protected function getSchoolyearOptions()
    {
        return Batch::query()
            ->whereNotNull('schoolyear')
            ->select('schoolyear')
            ->distinct()
            ->orderByDesc('schoolyear')
            ->pluck('schoolyear');
    }

    public function render()
    {
        $usersQuery = $this->getUsersQuery();

        $users = $usersQuery
            ->latest('id')
            ->paginate($this->perPage);

        return view('livewire.manage-users', [
            'users' => $users,
            'roles' => $this->getRoleOptions(),
            'batches' => $this->getBatchOptions(),
            'yearGrads' => $this->getyearGradOptions(),
            'schoolyears' => $this->getSchoolyearOptions(),
        ]);
    }
}