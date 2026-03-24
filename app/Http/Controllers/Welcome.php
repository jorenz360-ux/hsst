<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\Event;

class Welcome extends Controller
{
    public function index()
    {
        $events = Event::query()
            ->select([
                'id',
                'title',
                'slug',
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
                        'schedule_time',
                        'sort_order',
                    ])
                    ->orderBy('sort_order')
                    ->orderBy('schedule_time'),
            ])
            ->whereNotNull('event_date')
            ->whereDate('event_date', '>=', today())
            ->orderBy('event_date', 'asc')
            ->take(8)
            ->get();

        $announcements = Announcement::query()
            ->select([
                'id',
                'title',
                'pinned',
                'published_at',
                'created_at',
            ])
            ->where('is_published', true)
            ->where(function ($query) {
                $query->whereNull('published_at')
                    ->orWhere('published_at', '<=', now());
            })
            ->where(function ($query) {
                $query->whereNull('expires_at')
                    ->orWhere('expires_at', '>', now());
            })
            ->orderByDesc('pinned')
            ->orderByDesc('published_at')
            ->orderByDesc('created_at')
            ->take(3)
            ->get();

        return view('welcome', [
            'events' => $events,
            'announcements' => $announcements,
        ]);
    }
}