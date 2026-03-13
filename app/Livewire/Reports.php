<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Title;
#[Title('Reports')]

class Reports extends Component
{
   public function render()
{
    $totalEvents = \App\Models\Event::count();

    $activeEvents = \App\Models\Event::where('is_active', true)->count();

    $publishedAnnouncements = \App\Models\Announcement::where('is_published', true)->count();

    $totalSchedules = \App\Models\EventSchedule::count();

    $upcomingEvents = \App\Models\Event::query()
        ->withCount('schedules')
        ->whereNotNull('event_date')
        ->where('event_date', '>=', now())
        ->orderBy('event_date', 'asc')
        ->limit(5)
        ->get();

    $latestAnnouncements = \App\Models\Announcement::query()
        ->where('is_published', true)
        ->orderByDesc('published_at')
        ->orderByDesc('created_at')
        ->limit(5)
        ->get();

    return view('livewire.reports', [
        'totalEvents' => $totalEvents,
        'activeEvents' => $activeEvents,
        'publishedAnnouncements' => $publishedAnnouncements,
        'totalSchedules' => $totalSchedules,
        'upcomingEvents' => $upcomingEvents,
        'latestAnnouncements' => $latestAnnouncements,
    ]);
}
}
