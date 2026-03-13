<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Title;

#[Title('Users')]
class ManageUsers extends Component
{
    use WithPagination;

    public string $search = '';
    public string $role = 'all';
    public int $perPage = 5;

    protected $queryString = [
        'search' => ['except' => ''],
        'role'   => ['except' => 'all'],
        'page'   => ['except' => 1],
    ];

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingRole(): void
    {
        $this->resetPage();
    }

    public function updatingPerPage(): void
    {
        $this->resetPage();
    }

    public function render()
    {
        $users = User::query()
            ->with(['roles', 'alumni.batch'])
            ->when($this->search !== '', function ($q) {
                $s = '%' . $this->search . '%';

                $q->where(function ($query) use ($s) {
                    $query->where('username', 'like', $s)
                          ->orWhere('email', 'like', $s)
                          ->orWhereHas('alumni', function ($aq) use ($s) {
                              $aq->where('fname', 'like', $s)
                                 ->orWhere('lname', 'like', $s)
                                 ->orWhereRaw("CONCAT(fname, ' ', lname) LIKE ?", [$s]);
                          })
                          ->orWhereHas('alumni.batch', function ($bq) use ($s) {
                              $bq->where('schoolyear', 'like', $s)
                                 ->orWhere('yeargrad', 'like', $s);
                          });
                });
            })
            ->when($this->role !== 'all', function ($q) {
                $q->whereHas('roles', fn ($rq) => $rq->where('name', $this->role));
            })
            ->latest()
            ->paginate($this->perPage);

        return view('livewire.manage-users', [
            'users' => $users,
            'roles' => ['all', 'reunion-coordinator', 'ssps', 'batch-representative', 'alumni'],
        ]);
    }
}