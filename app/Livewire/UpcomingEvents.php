<?php

namespace App\Livewire;

use App\Models\Event;
use Livewire\Component;

class UpcomingEvents extends Component
{
    public function render()
    {
        $events = Event::query()
            ->select(['id','title','venue','event_date','registration_fee','is_active'])
            ->where('is_active', true)
            ->where('event_date', '>=', now())
            ->orderBy('event_date')
            ->limit(6) // dashboard preview
            ->get();

        return view('livewire.upcoming-events', [
            'events' => $events,
        ]);
    }
}