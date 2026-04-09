<?php

namespace App\Livewire;

use App\Models\Alumni;
use App\Models\AlumniEducation;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

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
        $user = Auth::user()?->loadMissing([
            'alumni.educations.batch',
        ]);

        if (! $user || ! $user->alumni) {
            abort(403);
        }

        $representativeEducation = $user->alumni->educations()
            ->with('batch')
            ->where('is_batch_rep', true)
            ->first();

        if (! $representativeEducation) {
            abort(403);
        }

        $batchId = (int) $representativeEducation->batch_id;
        $this->batch = $representativeEducation->batch;

        $members = AlumniEducation::query()
            ->with([
                'batch:id,level,yeargrad,schoolyear',
                'alumni.user:id,alumni_id,username,email',
            ])
            ->where('batch_id', $batchId)
            ->whereHas('alumni', function ($query) {
                $query->where(function ($q) {
                    $q->where('fname', 'like', '%' . $this->search . '%')
                        ->orWhere('mname', 'like', '%' . $this->search . '%')
                        ->orWhere('lname', 'like', '%' . $this->search . '%')
                        ->orWhereRaw("CONCAT(fname, ' ', lname) LIKE ?", ['%' . $this->search . '%'])
                        ->orWhereRaw("CONCAT(lname, ', ', fname) LIKE ?", ['%' . $this->search . '%'])
                        ->orWhereHas('user', function ($userQuery) {
                            $userQuery->where('email', 'like', '%' . $this->search . '%')
                                ->orWhere('username', 'like', '%' . $this->search . '%');
                        });
                });
            })
            ->orderByDesc('is_batch_rep')
            ->orderBy(
                Alumni::select('lname')
                    ->whereColumn('alumni.id', 'alumni_educations.alumni_id')
                    ->limit(1)
            )
            ->orderBy(
                Alumni::select('fname')
                    ->whereColumn('alumni.id', 'alumni_educations.alumni_id')
                    ->limit(1)
            )
            ->paginate(10);

        return view('livewire.batch', [
            'members' => $members,
            'batch' => $this->batch,
            'representativeEducation' => $representativeEducation,
        ]);
    }
}