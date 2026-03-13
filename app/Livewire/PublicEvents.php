<?php

namespace App\Livewire;

use App\Models\Event;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('Events')]
class PublicEvents extends Component
{
    use WithPagination;

    public int $perPage = 9;

    public function render()
    {
        $events = Event::query()
            ->select(['id','title','venue','event_date','registration_fee','description','is_active'])
            ->where('is_active', true)
            ->where('event_date', '>=', now())
            ->orderBy('event_date')
            ->paginate($this->perPage);

        return view('livewire.public-events', [
            'events' => $events,
        ]);
    }
}