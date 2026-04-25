<?php

namespace App\Livewire;

use App\Models\Alumni;
use App\Models\AlumniEducation;
use App\Models\Event;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('My Batch')]
class Batch extends Component
{
    use WithPagination;

    public ?int $selectedBatchId = null;
    public string $search = '';
    public string $filterAccount = 'all';
    public string $filterGrad    = 'all';
    public string $filterRsvp    = 'all';
    public $batch = null;

    #[Locked]
    public ?int $selectedAlumniId = null;

    protected $paginationTheme = 'tailwind';

    public function viewAlumni(int $id): void
    {
        $this->selectedAlumniId = $id;
    }

    public function closeModal(): void
    {
        $this->selectedAlumniId = null;
    }

    public function updatingSelectedBatchId(): void { $this->resetPage(); }
    public function updatingSearch(): void        { $this->resetPage(); }
    public function updatingFilterAccount(): void { $this->resetPage(); }
    public function updatingFilterGrad(): void    { $this->resetPage(); }
    public function updatingFilterRsvp(): void    { $this->resetPage(); }

    public function resetFilters(): void
    {
        $this->reset(['search', 'filterAccount', 'filterGrad', 'filterRsvp']);
        $this->resetPage();
    }

    #[Computed]
    public function selectedAlumni(): ?Alumni
    {
        if (! $this->selectedAlumniId) {
            return null;
        }

        $repBatchIds = Auth::user()?->alumni?->educations()
            ->where('is_batch_rep', true)
            ->pluck('batch_id')
            ->map(fn ($id) => (int) $id);

        abort_if(! $repBatchIds || $repBatchIds->isEmpty(), 403);

        $batchId = ($this->selectedBatchId && $repBatchIds->contains($this->selectedBatchId))
            ? $this->selectedBatchId
            : $repBatchIds->first();

        return Alumni::with([
            'user:id,alumni_id,username,email',
            'volunteerSignups.committee:id,name,description',
            'eventRsvps.event:id,title,event_date',
            'educations.batch:id,level,yeargrad,schoolyear',
        ])
        ->whereHas('educations', fn ($q) => $q->where('batch_id', $batchId))
        ->find($this->selectedAlumniId);
    }

    public function render()
    {
        $user = Auth::user();

        if (! $user || ! $user->alumni) {
            abort(403);
        }

        $repEducations = $user->alumni->educations()
            ->with('batch')
            ->where('is_batch_rep', true)
            ->get();

        if ($repEducations->isEmpty()) {
            abort(403);
        }

        if (! $this->selectedBatchId || ! $repEducations->contains('batch_id', $this->selectedBatchId)) {
            $this->selectedBatchId = (int) $repEducations->first()->batch_id;
        }

        $repEducation = $repEducations->firstWhere('batch_id', $this->selectedBatchId);
        $batchId    = (int) $repEducation->batch_id;
        $this->batch = $repEducation->batch;

        // Active events (for RSVP column)
        $activeEvents = Event::query()
            ->where('is_active', true)
            ->whereDate('event_date', '>=', now()->toDateString())
            ->orderBy('event_date')
            ->get(['id', 'title', 'event_date', 'venue']);

        $activeEventIds = $activeEvents->pluck('id');

        // Base query scoped to this rep's batch only
        $baseQuery = AlumniEducation::query()
            ->with([
                'batch:id,level,yeargrad,schoolyear',
                'alumni:id,prefix,fname,mname,lname,suffix,occupation,cellphone,city,state_province,postal_code,country',
                'alumni.user:id,alumni_id,username,email',
                'alumni.eventRsvps' => fn ($q) => $q->whereIn('event_id', $activeEventIds)
                    ->with('event:id,title,event_date'),
                'alumni.involvement:alumni_id,wants_committee_member,is_priest_concelebrate,is_medical_practitioner,medical_specialty',
            ])
            ->where('batch_id', $batchId);

        // Stats (unfiltered)
        $totalCount      = (clone $baseQuery)->count();
        $registeredCount = (clone $baseQuery)->whereHas('alumni.user')->count();
        $graduatedCount  = (clone $baseQuery)->where('did_graduate', true)->count();
        $respondedCount  = (clone $baseQuery)->whereHas('alumni.eventRsvps', function ($q) use ($activeEventIds) {
            $q->whereIn('event_id', $activeEventIds)->where('status', 'attending');
        })->count();

        // Filtered + searched members
        $members = (clone $baseQuery)
            ->when($this->search !== '', function ($query) {
                $like = '%' . $this->search . '%';
                $query->whereHas('alumni', function ($q) use ($like) {
                    $q->where('fname', 'like', $like)
                        ->orWhere('mname', 'like', $like)
                        ->orWhere('lname', 'like', $like)
                        ->orWhere('occupation', 'like', $like)
                        ->orWhere('cellphone', 'like', $like)
                        ->orWhereRaw("CONCAT(fname, ' ', lname) LIKE ?", [$like])
                        ->orWhereRaw("CONCAT(lname, ', ', fname) LIKE ?", [$like])
                        ->orWhereHas('user', function ($uq) use ($like) {
                            $uq->where('email', 'like', $like)
                                ->orWhere('username', 'like', $like);
                        });
                });
            })
            ->when($this->filterAccount === 'registered', fn ($q) => $q->whereHas('alumni.user'))
            ->when($this->filterAccount === 'no_account', fn ($q) => $q->whereDoesntHave('alumni.user'))
            ->when($this->filterGrad === 'graduated',     fn ($q) => $q->where('did_graduate', true))
            ->when($this->filterGrad === 'not_graduated', fn ($q) => $q->where('did_graduate', false))
            ->when($this->filterRsvp === 'no_rsvp', function ($q) use ($activeEventIds) {
                $q->whereDoesntHave('alumni.eventRsvps', fn ($rq) => $rq->whereIn('event_id', $activeEventIds));
            })
            ->when(in_array($this->filterRsvp, ['attending', 'maybe', 'not_attending']), function ($q) use ($activeEventIds) {
                $q->whereHas('alumni.eventRsvps', function ($rq) use ($activeEventIds) {
                    $rq->whereIn('event_id', $activeEventIds)->where('status', $this->filterRsvp);
                });
            })
            ->orderByDesc('is_batch_rep')
            ->orderBy(Alumni::select('lname')->whereColumn('alumni.id', 'alumni_educations.alumni_id')->limit(1))
            ->orderBy(Alumni::select('fname')->whereColumn('alumni.id', 'alumni_educations.alumni_id')->limit(1))
            ->paginate(15);

        return view('livewire.batch', [
            'repEducations'   => $repEducations,
            'batch'          => $this->batch,
            'activeEvents'   => $activeEvents,
            'members'        => $members,
            'totalCount'     => $totalCount,
            'registeredCount' => $registeredCount,
            'graduatedCount'  => $graduatedCount,
            'respondedCount'  => $respondedCount,
        ]);
    }
}
