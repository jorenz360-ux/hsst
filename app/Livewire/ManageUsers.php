<?php

namespace App\Livewire;

use App\Models\Batch;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('Users')]
class ManageUsers extends Component
{
    use WithPagination;

    public const DEFAULT_ROLE = 'all';
    public const DEFAULT_BATCH = 'all';
    public const DEFAULT_YEAR_GRAD = 'all';
    public const DEFAULT_SCHOOL_YEAR = 'all';
    public const DEFAULT_LEVEL = 'all';
    public const DEFAULT_BATCH_REP = 'all';
    public const DEFAULT_HAS_ALUMNI = 'all';
    public const DEFAULT_PER_PAGE = 10;

    public string $search = '';
    public string $role = self::DEFAULT_ROLE;
    public string $batchId = self::DEFAULT_BATCH;
    public string $yearGrad = self::DEFAULT_YEAR_GRAD;
    public string $schoolyear = self::DEFAULT_SCHOOL_YEAR;
    public string $level = self::DEFAULT_LEVEL;
    public string $isBatchRep = self::DEFAULT_BATCH_REP;
    public string $hasAlumni = self::DEFAULT_HAS_ALUMNI;
    public int $perPage = self::DEFAULT_PER_PAGE;

    public ?int $viewUserId = null;
    public bool $showViewModal = false;

    public ?int $confirmDeleteId = null;
    public bool $showDeleteModal = false;

    public ?int $confirmToggleId = null;
    public bool $showToggleModal = false;

    protected array $queryString = [
        'search' => ['except' => ''],
        'role' => ['except' => self::DEFAULT_ROLE],
        'batchId' => ['except' => self::DEFAULT_BATCH],
        'yearGrad' => ['except' => self::DEFAULT_YEAR_GRAD],
        'schoolyear' => ['except' => self::DEFAULT_SCHOOL_YEAR],
        'level' => ['except' => self::DEFAULT_LEVEL],
        'isBatchRep' => ['except' => self::DEFAULT_BATCH_REP],
        'hasAlumni' => ['except' => self::DEFAULT_HAS_ALUMNI],
        'perPage' => ['except' => self::DEFAULT_PER_PAGE],
        'page' => ['except' => 1],
    ];

    public function updated(string $property): void
    {
        if (in_array($property, [
            'search',
            'role',
            'batchId',
            'yearGrad',
            'schoolyear',
            'level',
            'isBatchRep',
            'hasAlumni',
            'perPage',
        ], true)) {
            $this->normalizePerPage();
            $this->resetPage();
        }
    }

    public function resetFilters(): void
    {
        $this->reset([
            'search',
            'role',
            'batchId',
            'yearGrad',
            'schoolyear',
            'level',
            'isBatchRep',
            'hasAlumni',
            'perPage',
        ]);

        $this->search = '';
        $this->role = self::DEFAULT_ROLE;
        $this->batchId = self::DEFAULT_BATCH;
        $this->yearGrad = self::DEFAULT_YEAR_GRAD;
        $this->schoolyear = self::DEFAULT_SCHOOL_YEAR;
        $this->level = self::DEFAULT_LEVEL;
        $this->isBatchRep = self::DEFAULT_BATCH_REP;
        $this->hasAlumni = self::DEFAULT_HAS_ALUMNI;
        $this->perPage = self::DEFAULT_PER_PAGE;

        $this->resetPage();
    }

    public function edit(int $userId)
    {
        return $this->redirect(route('users.edit', $userId), navigate: true);
    }

    public function view(int $userId): void
    {
        $this->viewUserId = $userId;
        $this->showViewModal = true;
    }

    public function closeViewModal(): void
    {
        $this->showViewModal = false;
        $this->viewUserId = null;
    }

    public function toggleActive(int $userId): void
    {
        $user = User::findOrFail($userId);

        // Prevent deactivating yourself
        if ($user->id === auth()->id()) {
            $this->cancelToggle();
            session()->flash('error', 'You cannot deactivate your own account.');
            return;
        }

        $user->update(['is_active' => ! $user->is_active]);

        $this->cancelToggle();

        session()->flash(
            'success',
            $user->is_active
                ? "Account for {$user->username} has been activated."
                : "Account for {$user->username} has been deactivated."
        );
    }

    public function confirmDelete(int $userId): void
    {
        $this->confirmDeleteId = $userId;
        $this->showDeleteModal = true;
    }

    public function confirmToggle(int $userId): void
    {
        $this->confirmToggleId = $userId;
        $this->showToggleModal = true;
    }

    public function cancelToggle(): void
    {
        $this->confirmToggleId = null;
        $this->showToggleModal = false;
    }

    public function cancelDelete(): void
    {
        $this->confirmDeleteId = null;
        $this->showDeleteModal = false;
    }

    public function deleteUser(): void
    {
        $user = User::find($this->confirmDeleteId);

        if ($user) {
            $alumni = $user->alumni;
            $user->delete();

            if ($alumni) {
                $alumni->delete();
            }
        }

        $this->cancelDelete();
        $this->closeViewModal();
        session()->flash('deleted', 'User account deleted successfully.');
    }

    protected function normalizePerPage(): void
    {
        $allowed = [10, 25, 50, 100];

        if (! in_array($this->perPage, $allowed, true)) {
            $this->perPage = self::DEFAULT_PER_PAGE;
        }
    }

    protected function roleOptions(): array
    {
        return [
            'all',
            'reunion-coordinator',
            'ssps',
            'batch-representative',
            'alumni',
        ];
    }

    protected function levelOptions(): array
    {
        return [
            'all' => 'All Levels',
            'elementary' => 'Elementary',
            'highschool' => 'High School',
            'college' => 'College',
        ];
    }

    protected function usersQuery(): Builder
    {
        $search = trim($this->search);

        return User::query()
            ->with([
                'roles',
                'alumni.educations.batch',
            ])
              ->whereDoesntHave('roles', function ($query) {
                 $query->where('name', 'reunion-coordinator');})
            ->when($search !== '', function (Builder $query) use ($search) {
                $like = '%' . $search . '%';

                $query->where(function (Builder $q) use ($like) {
                    $q->where('username', 'like', $like)
                        ->orWhere('email', 'like', $like)
                        ->orWhereHas('alumni', function (Builder $alumniQuery) use ($like) {
                            $alumniQuery->where('fname', 'like', $like)
                                ->orWhere('lname', 'like', $like)
                                ->orWhere('mname', 'like', $like)
                                ->orWhereRaw("CONCAT(fname, ' ', lname) LIKE ?", [$like])
                                ->orWhereRaw("CONCAT(lname, ', ', fname) LIKE ?", [$like])
                                ->orWhere('cellphone', 'like', $like)
                                ->orWhere('occupation', 'like', $like);
                        })
                        ->orWhereHas('alumni.educations.batch', function (Builder $batchQuery) use ($like) {
                            $batchQuery->where('schoolyear', 'like', $like)
                                ->orWhere('yeargrad', 'like', $like)
                                ->orWhere('level', 'like', $like);
                        });
                });
            })
            ->when($this->role !== self::DEFAULT_ROLE, function (Builder $query) {
                $query->whereHas('roles', function (Builder $roleQuery) {
                    $roleQuery->where('name', $this->role);
                });
            })
            ->when($this->hasAlumni === 'yes', function (Builder $query) {
                $query->whereNotNull('alumni_id');
            })
            ->when($this->hasAlumni === 'no', function (Builder $query) {
                $query->whereNull('alumni_id');
            })
            ->when($this->batchId !== self::DEFAULT_BATCH, function (Builder $query) {
                $query->whereHas('alumni.educations', function (Builder $educationQuery) {
                    $educationQuery->where('batch_id', $this->batchId);
                });
            })
            ->when($this->yearGrad !== self::DEFAULT_YEAR_GRAD, function (Builder $query) {
                $query->whereHas('alumni.educations.batch', function (Builder $batchQuery) {
                    $batchQuery->where('yeargrad', $this->yearGrad);
                });
            })
            ->when($this->schoolyear !== self::DEFAULT_SCHOOL_YEAR, function (Builder $query) {
                $query->whereHas('alumni.educations.batch', function (Builder $batchQuery) {
                    $batchQuery->where('schoolyear', $this->schoolyear);
                });
            })
            ->when($this->level !== self::DEFAULT_LEVEL, function (Builder $query) {
                $query->whereHas('alumni.educations.batch', function (Builder $batchQuery) {
                    $batchQuery->where('level', $this->level);
                });
            })
            ->when($this->isBatchRep === 'yes', function (Builder $query) {
                $query->whereHas('alumni.educations', function (Builder $educationQuery) {
                    $educationQuery->where('is_batch_rep', true);
                });
            })
            ->when($this->isBatchRep === 'no', function (Builder $query) {
                $query->whereHas('alumni.educations', function (Builder $educationQuery) {
                    $educationQuery->where('is_batch_rep', false);
                });
            });
    }

    protected function batchOptions(): Collection
    {
        return Batch::query()
            ->orderByRaw("FIELD(level, 'elementary', 'highschool', 'college')")
            ->orderByDesc('yeargrad')
            ->get(['id', 'level', 'schoolyear', 'yeargrad']);
    }

    protected function yearGradOptions(): Collection
    {
        return Batch::query()
            ->whereNotNull('yeargrad')
            ->select('yeargrad')
            ->distinct()
            ->orderByDesc('yeargrad')
            ->pluck('yeargrad');
    }

    protected function schoolYearOptions(): Collection
    {
        return Batch::query()
            ->whereNotNull('schoolyear')
            ->select('schoolyear')
            ->distinct()
            ->orderByDesc('schoolyear')
            ->pluck('schoolyear');
    }

    protected function selectedUser(): ?User
    {
        if (! $this->viewUserId) {
            return null;
        }

        return User::query()
            ->with([
                'roles',
                'alumni.educations.batch',
            ])
            ->find($this->viewUserId);
    }

    public function render()
    {
        $this->normalizePerPage();

        $users = $this->usersQuery()
            ->latest('id')
            ->paginate($this->perPage);

        return view('livewire.manage-users', [
            'users' => $users,
            'roles' => $this->roleOptions(),
            'levels' => $this->levelOptions(),
            'batches' => $this->batchOptions(),
            'yearGrads' => $this->yearGradOptions(),
            'schoolyears' => $this->schoolYearOptions(),
            'selectedUser' => $this->selectedUser(),
        ]);
    }
}