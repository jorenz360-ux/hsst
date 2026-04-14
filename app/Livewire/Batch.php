<?php

namespace App\Livewire;

use App\Models\Alumni;
use App\Models\AlumniEducation;
use App\Models\Event;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('My Batch')]
class Batch extends Component
{
    use WithPagination;

    public string $search = '';
    public string $filterAccount = 'all';   // all | registered | no_account
    public string $filterGrad    = 'all';   // all | graduated | not_graduated
    public string $filterRsvp    = 'all';   // all | attending | maybe | not_attending | no_rsvp
    public $batch = null;

    protected $paginationTheme = 'tailwind';

    public function updatingSearch(): void    { $this->resetPage(); }
    public function updatingFilterAccount(): void { $this->resetPage(); }
    public function updatingFilterGrad(): void    { $this->resetPage(); }
    public function updatingFilterRsvp(): void    { $this->resetPage(); }

    public function resetFilters(): void
    {
        $this->reset(['search', 'filterAccount', 'filterGrad', 'filterRsvp']);
        $this->resetPage();
    }

    public function render()
    {
        $user = Auth::user()?->loadMissing(['alumni.educations.batch']);

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

        // Active events (for RSVP column)
        $activeEvents = Event::query()
            ->where('is_active', true)
            ->whereDate('event_date', '>=', now()->toDateString())
            ->orderBy('event_date')
            ->get(['id', 'title', 'event_date', 'venue']);

        $activeEventIds = $activeEvents->pluck('id');

        // Base query
        $baseQuery = AlumniEducation::query()
            ->with([
                'batch:id,level,yeargrad,schoolyear',
                'alumni:id,prefix,fname,mname,lname,suffix,occupation,cellphone',
                'alumni.user:id,alumni_id,username,email',
                'alumni.eventRsvps' => fn ($q) => $q->whereIn('event_id', $activeEventIds)
                    ->with('event:id,title,event_date'),
                'alumni.involvement:alumni_id,wants_committee_member,is_priest_concelebrate,is_medical_practitioner,medical_specialty',
            ])
            ->where('batch_id', $batchId);

        // ── Stats (unfiltered, unsearched) ──────────────────────────
        $totalCount      = (clone $baseQuery)->count();
        $registeredCount = (clone $baseQuery)->whereHas('alumni.user')->count();
        $graduatedCount  = (clone $baseQuery)->where('did_graduate', true)->count();
        $respondedCount  = (clone $baseQuery)->whereHas('alumni.eventRsvps', function ($q) use ($activeEventIds) {
            $q->whereIn('event_id', $activeEventIds)->where('status', 'attending');
        })->count();

        // ── Filtered + searched members ─────────────────────────────
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
            'batch'                   => $this->batch,
            'representativeEducation' => $representativeEducation,
            'activeEvents'            => $activeEvents,
            'members'                 => $members,
            'totalCount'              => $totalCount,
            'registeredCount'         => $registeredCount,
            'graduatedCount'          => $graduatedCount,
            'respondedCount'          => $respondedCount,
        ]);
    }
}
