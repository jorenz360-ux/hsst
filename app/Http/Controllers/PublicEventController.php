<?php

namespace App\Http\Controllers;

use App\Models\Event;

class PublicEventController extends Controller
{
    public function index()
    {
        $events = Event::query()
            ->select([
                'id',
                'title',
                'venue',
                'event_date',
                'description',
                'dress_code',
            ])
            ->with([
                'schedules' => fn ($query) => $query
                    ->select([
                        'id',
                        'event_id',
                        'title',
                        'description',
                        'schedule_time',
                        'sort_order',
                    ])
                    ->orderBy('sort_order')
                    ->orderBy('schedule_time'),
            ])
            ->whereNotNull('event_date')
            ->whereDate('event_date', '>=', today())
            ->orderBy('event_date', 'asc')
            ->paginate(9);

        return view('public.index', compact('events'));
    }

 public function show(Event $event)
{
    $event->load([
        'schedules' => fn ($query) => $query
            ->select([
                'id',
                'event_id',
                'title',
                'description',
                'schedule_time',
                'sort_order',
            ])
            ->orderBy('sort_order')
            ->orderBy('schedule_time'),
    ]);

    return view('public.show', [
        'event' => $event,
    ]);
}
}