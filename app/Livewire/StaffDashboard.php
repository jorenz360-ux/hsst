<?php

namespace App\Livewire;

use App\Models\Event;
use App\Models\StaffEventRsvp;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class StaffDashboard extends Component
{
    public function saveRsvp(int $eventId, string $status): void
    {
        if (! in_array($status, StaffEventRsvp::statuses(), true)) {
            session()->flash('error', 'Invalid attendance response.');
            return;
        }

        $staffId = Auth::user()?->staff_id;

        abort_if(! $staffId, 403);

        $event = Event::find($eventId);

        if ($event?->event_date?->isPast()) {
            session()->flash('error', 'This event has already ended.');
            return;
        }

        StaffEventRsvp::updateOrCreate(
            ['event_id' => $eventId, 'staff_id' => $staffId],
            ['status' => $status]
        );

        $message = match ($status) {
            StaffEventRsvp::STATUS_ATTENDING     => 'Marked as Attending.',
            StaffEventRsvp::STATUS_MAYBE         => 'Marked as Maybe.',
            StaffEventRsvp::STATUS_NOT_ATTENDING => 'Marked as Not Attending.',
            default                              => 'RSVP updated.',
        };

        session()->flash('success', $message);
    }

    protected function getEvents(): Collection
    {
        return Event::query()
            ->select(['id', 'title', 'venue', 'event_date', 'registration_fee', 'is_active'])
            ->where('is_active', true)
            ->orderBy('event_date')
            ->get();
    }

    protected function getMyRsvps(Collection $events): array
    {
        $staffId = Auth::user()?->staff_id;

        if (! $staffId || $events->isEmpty()) {
            return [];
        }

        return StaffEventRsvp::query()
            ->whereIn('event_id', $events->pluck('id'))
            ->where('staff_id', $staffId)
            ->get()
            ->keyBy('event_id')
            ->map(fn ($rsvp) => $rsvp->status)
            ->toArray();
    }

    public function render()
    {
        $events = $this->getEvents();

        return view('livewire.staff-dashboard', [
            'events'   => $events,
            'myRsvps'  => $this->getMyRsvps($events),
        ]);
    }
}
