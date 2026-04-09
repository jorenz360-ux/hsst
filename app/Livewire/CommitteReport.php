<?php

namespace App\Livewire;

use App\Models\Batch;
use App\Models\Committee;
use App\Models\VolunteerSignup;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;
use Symfony\Component\HttpFoundation\StreamedResponse;

#[Title('Admin | Committee Report')]
class CommitteReport extends Component
{
    use WithPagination;

    public bool $showActionModal = false;
    public ?int $selectedSignupId = null;
    public ?string $selectedAction = null;

    public bool $showViewModal = false;
    public ?int $viewSignupId = null;

    public const DEFAULT_ROLE = 'all';
    public const DEFAULT_BATCH = 'all';
    public const DEFAULT_YEAR_GRAD = 'all';
    public const DEFAULT_SCHOOL_YEAR = 'all';
    public const DEFAULT_LEVEL = 'all';
    public const DEFAULT_BATCH_REP = 'all';
    public const DEFAULT_HAS_ALUMNI = 'all';
    public const DEFAULT_VOLUNTEER_STATUS = 'all';
    public const DEFAULT_COMMITTEE = 'all';
    public const DEFAULT_PER_PAGE = 10;

    public string $search = '';
    public string $role = self::DEFAULT_ROLE;
    public string $batchId = self::DEFAULT_BATCH;
    public string $yearGrad = self::DEFAULT_YEAR_GRAD;
    public string $schoolyear = self::DEFAULT_SCHOOL_YEAR;
    public string $level = self::DEFAULT_LEVEL;
    public string $isBatchRep = self::DEFAULT_BATCH_REP;
    public string $hasAlumni = self::DEFAULT_HAS_ALUMNI;
    public string $volunteerStatus = self::DEFAULT_VOLUNTEER_STATUS;
    public string $committeeId = self::DEFAULT_COMMITTEE;
    public int $perPage = self::DEFAULT_PER_PAGE;

    protected array $queryString = [
        'search' => ['except' => ''],
        'role' => ['except' => self::DEFAULT_ROLE],
        'batchId' => ['except' => self::DEFAULT_BATCH],
        'yearGrad' => ['except' => self::DEFAULT_YEAR_GRAD],
        'schoolyear' => ['except' => self::DEFAULT_SCHOOL_YEAR],
        'level' => ['except' => self::DEFAULT_LEVEL],
        'isBatchRep' => ['except' => self::DEFAULT_BATCH_REP],
        'hasAlumni' => ['except' => self::DEFAULT_HAS_ALUMNI],
        'volunteerStatus' => ['except' => self::DEFAULT_VOLUNTEER_STATUS],
        'committeeId' => ['except' => self::DEFAULT_COMMITTEE],
        'perPage' => ['except' => self::DEFAULT_PER_PAGE],
        'page' => ['except' => 1],
    ];

    public function openActionModal(string $action, int $signupId): void
    {
        $this->selectedAction = $action;
        $this->selectedSignupId = $signupId;
        $this->showActionModal = true;
    }

    public function closeActionModal(): void
    {
        $this->reset(['showActionModal', 'selectedSignupId', 'selectedAction']);
    }

    public function openViewModal(int $signupId): void
    {
        $this->viewSignupId = $signupId;
        $this->showViewModal = true;
    }

    public function closeViewModal(): void
    {
        $this->reset(['showViewModal', 'viewSignupId']);
    }

    public function confirmAction(): void
    {
        if (! $this->selectedSignupId || ! $this->selectedAction) {
            return;
        }

        if ($this->selectedAction === 'approve') {
            $this->approveVolunteerSignup($this->selectedSignupId);
        }

        if ($this->selectedAction === 'reject') {
            $this->rejectVolunteerSignup($this->selectedSignupId);
        }

        if ($this->selectedAction === 'delete') {
            $this->deleteVolunteerSignup($this->selectedSignupId);
        }

        $this->closeActionModal();
    }

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
            'volunteerStatus',
            'committeeId',
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
            'volunteerStatus',
            'committeeId',
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
        $this->volunteerStatus = self::DEFAULT_VOLUNTEER_STATUS;
        $this->committeeId = self::DEFAULT_COMMITTEE;
        $this->perPage = self::DEFAULT_PER_PAGE;

        $this->resetPage();
    }

    public function editUser(?int $userId)
    {
        if (! $userId) {
            session()->flash('error', 'This submission is not linked to a user account.');
            return;
        }

        return $this->redirect(route('users.edit', $userId), navigate: true);
    }

    public function approveVolunteerSignup(int $signupId): void
    {
        $signup = VolunteerSignup::query()->findOrFail($signupId);

        $signup->update([
            'status' => 'approved',
        ]);

        session()->flash('success', 'Committee submission approved.');
    }

    public function rejectVolunteerSignup(int $signupId): void
    {
        $signup = VolunteerSignup::query()->findOrFail($signupId);

        $signup->update([
            'status' => 'rejected',
        ]);

        session()->flash('success', 'Committee submission rejected.');
    }

    public function deleteVolunteerSignup(int $signupId): void
    {
        $signup = VolunteerSignup::query()->findOrFail($signupId);

        $signup->delete();

        session()->flash('success', 'Committee submission removed successfully.');
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

    protected function volunteerStatusOptions(): array
    {
        return [
            'all',
            'pending',
            'approved',
            'rejected',
        ];
    }

    protected function levelOptions(): array
    {
        return [
            'all' => 'All levels',
            'elementary' => 'Elementary',
            'highschool' => 'High School',
            'college' => 'College',
        ];
    }

    protected function signupsQuery(): Builder
    {
        $search = trim($this->search);

        return VolunteerSignup::query()
            ->with([
                'user.roles',
                'alumni.educations.batch',
                'committee',
            ])
            ->when($search !== '', function (Builder $query) use ($search) {
                $like = '%' . $search . '%';

                $query->where(function (Builder $q) use ($like) {
                    $q->where('notes', 'like', $like)
                        ->orWhereHas('committee', function (Builder $committeeQuery) use ($like) {
                            $committeeQuery->where('name', 'like', $like);
                        })
                        ->orWhereHas('user', function (Builder $userQuery) use ($like) {
                            $userQuery->where('username', 'like', $like)
                                ->orWhere('email', 'like', $like);
                        })
                        ->orWhereHas('alumni', function (Builder $alumniQuery) use ($like) {
                            $alumniQuery->where('fname', 'like', $like)
                                ->orWhere('lname', 'like', $like)
                                ->orWhere('mname', 'like', $like)
                                ->orWhere('cellphone', 'like', $like)
                                ->orWhere('occupation', 'like', $like)
                                ->orWhereRaw("CONCAT(fname, ' ', lname) LIKE ?", [$like])
                                ->orWhereRaw("CONCAT(lname, ', ', fname) LIKE ?", [$like]);
                        })
                        ->orWhereHas('alumni.educations.batch', function (Builder $batchQuery) use ($like) {
                            $batchQuery->where('schoolyear', 'like', $like)
                                ->orWhere('yeargrad', 'like', $like)
                                ->orWhere('level', 'like', $like);
                        });
                });
            })
            ->when($this->committeeId !== self::DEFAULT_COMMITTEE, function (Builder $query) {
                $query->where('committee_id', $this->committeeId);
            })
            ->when($this->volunteerStatus !== self::DEFAULT_VOLUNTEER_STATUS, function (Builder $query) {
                $query->where('status', $this->volunteerStatus);
            })
            ->when($this->role !== self::DEFAULT_ROLE, function (Builder $query) {
                $query->whereHas('user.roles', function (Builder $roleQuery) {
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

    protected function committeeOptions(): Collection
    {
        return Committee::query()
            ->orderBy('name')
            ->get(['id', 'name']);
    }

    protected function selectedSignup(): ?VolunteerSignup
    {
        if (! $this->viewSignupId) {
            return null;
        }

        return VolunteerSignup::query()
            ->with([
                'user.roles',
                'committee',
                'alumni.educations.batch',
            ])
            ->find($this->viewSignupId);
    }

    protected function matchedEducation($signup)
    {
        if (! $signup?->alumni?->educations?->isNotEmpty()) {
            return null;
        }

        if ($this->batchId !== self::DEFAULT_BATCH) {
            return $signup->alumni->educations->firstWhere('batch_id', (int) $this->batchId)
                ?? $signup->alumni->educations->first();
        }

        return $signup->alumni->educations->sortBy(fn ($edu) => match($edu->batch?->level) {
            'elementary' => 1,
            'highschool' => 2,
            'college' => 3,
            default => 99,
        })->first();
    }

    public function downloadExcel(): StreamedResponse
    {
        $signups = $this->signupsQuery()
            ->latest('id')
            ->get();

        $filename = 'volunteer-signups-' . now()->format('Y-m-d-His') . '.csv';

        return response()->streamDownload(function () use ($signups) {
            $handle = fopen('php://output', 'w');

            fputcsv($handle, [
                'Full Name',
                'Email',
                'Level',
                'Batch',
                'School Year',
                'Batch Representative',
                'Committee',
                'Status',
                'Notes',
            ]);

            foreach ($signups as $signup) {
                $education = $this->matchedEducation($signup);

                $fullName = $signup->alumni
                    ? trim(collect([
                        $signup->alumni->fname,
                        $signup->alumni->mname,
                        $signup->alumni->lname,
                    ])->filter()->implode(' '))
                    : 'N/A';

                fputcsv($handle, [
                    $fullName,
                    $signup->user?->email ?? 'N/A',
                    $education?->batch?->level ? str($education->batch->level)->headline()->toString() : 'N/A',
                    $education?->batch?->yeargrad ?? 'N/A',
                    $education?->batch?->schoolyear ?? 'N/A',
                    $education?->is_batch_rep ? 'Yes' : 'No',
                    $signup->committee?->name ?? 'N/A',
                    $signup->status ?? 'None',
                    $signup->notes ?? '',
                ]);
            }

            fclose($handle);
        }, $filename, [
            'Content-Type' => 'text/csv',
        ]);
    }

    public function render()
    {
        $this->normalizePerPage();

        $signups = $this->signupsQuery()
            ->latest('id')
            ->paginate($this->perPage);

        return view('livewire.committe-report', [
            'signups' => $signups,
            'roles' => $this->roleOptions(),
            'levels' => $this->levelOptions(),
            'batches' => $this->batchOptions(),
            'yearGrads' => $this->yearGradOptions(),
            'schoolyears' => $this->schoolYearOptions(),
            'volunteerStatuses' => $this->volunteerStatusOptions(),
            'committees' => $this->committeeOptions(),
            'selectedSignup' => $this->selectedSignup(),
        ]);
    }
}