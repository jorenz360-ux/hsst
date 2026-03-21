<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use App\Models\Alumni;

class Batch extends Component
{
    use WithPagination;

    public string $search = '';
    public $batch = null;

    protected $paginationTheme = 'tailwind';

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function render()
    {
        $user = Auth::user();

        if (! $user || ! $user->alumni) {
            abort(403);
        }

        // Optional: only allow batch reps
        if (! $user->alumni->is_batch_rep) {
            abort(403);
        }

        $batchId = $user->alumni->batch_id;
        $this->batch = $user->alumni->batch;

        $members = Alumni::with('user')
            ->where('batch_id', $batchId)
            ->where(function ($query) {
                $query->where('fname', 'like', '%' . $this->search . '%')
                    ->orWhere('mname', 'like', '%' . $this->search . '%')
                    ->orWhere('lname', 'like', '%' . $this->search . '%')
                    ->orWhereHas('user', function ($q) {
                        $q->where('email', 'like', '%' . $this->search . '%');
                    });
            })
            ->orderBy('lname')
            ->orderBy('fname')
            ->paginate(10);

        return view('livewire.batch', [
            'members' => $members,
            'batch' => $this->batch,
        ]);
    }
}