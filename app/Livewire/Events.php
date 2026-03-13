<?php

namespace App\Livewire;

use App\Models\Event;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Gate; // optional
#[Title('Events')]
class Events extends Component
{
    use WithPagination;

    public string $search = '';
    public string $status = 'upcoming'; // upcoming|past|all
    public string $active = 'all';      // all|active|inactive
    public int $perPage = 10;

    protected $queryString = [
        'search' => ['except' => ''],
        'status' => ['except' => 'upcoming'],
        'active' => ['except' => 'all'],
        'page'   => ['except' => 1],
    ];

    public function updatingSearch(): void { $this->resetPage(); }
    public function updatingStatus(): void { $this->resetPage(); }
    public function updatingActive(): void { $this->resetPage(); }

    public function render()
    {
        $now = now();

        $events = Event::query()
            // Select only what you need (faster)
            ->select([
                'id', 'title', 'venue', 'event_date', 'registration_fee',
                'is_active', 'created_by', 'created_at',
            ])
            // Avoid N+1 if you show creator info
            ->with(['creator:id,username'])
            // Search (uses LIKE, consider fulltext later if needed)
            ->when($this->search !== '', function (Builder $q) {
                $term = '%' . $this->search . '%';
                $q->where(function (Builder $qq) use ($term) {
                    $qq->where('title', 'like', $term)
                       ->orWhere('venue', 'like', $term);
                });
            })
            // Active filter (hits your is_active index)
            ->when($this->active !== 'all', fn (Builder $q) =>
                $q->where('is_active', $this->active === 'active')
            )
            // Status filter (upcoming/past)
            ->when($this->status !== 'all', function (Builder $q) use ($now) {
                if ($this->status === 'upcoming') {
                    $q->where('event_date', '>=', $now);
                } elseif ($this->status === 'past') {
                    $q->where('event_date', '<', $now);
                }
            })
            // Efficient ordering (uses event_date index)
            ->orderBy('event_date', 'asc')
            ->paginate($this->perPage);

        /**
         * Higher-order transforms (after DB).
         * Keep this lightweight—don’t do heavy filtering here.
         */
        $events->getCollection()->transform(fn ($e) => [
            'id' => $e->id,
            'title' => $e->title,
            'venue' => $e->venue,
            'event_date' => $e->event_date, // Carbon via casts
            'fee_pesos' => number_format(((int) $e->registration_fee) / 100, 0),
            'is_active' => (bool) $e->is_active,
            'creator' => $e->creator?->username,
        ]);

        return view('livewire.events', [
            'events' => $events,
        ]);
    }
    public function toggleActive(int $eventId): void
{
    // Authorize (use Gate/Policy or spatie permission)
    abort_unless(auth()->user()->can('edit.event'), 403);

    Event::whereKey($eventId)->update([
        'is_active' => \DB::raw('NOT is_active'),
    ]);

    $enabled = Event::whereKey($eventId)->value('is_active');
session()->flash('status', $enabled ? 'Event enabled.' : 'Event disabled.');
session()->flash('status_id', now()->timestamp . '-' . uniqid());
}
}
