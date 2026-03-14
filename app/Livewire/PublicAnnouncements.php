<?php

namespace App\Livewire;

use App\Models\Announcement;
use App\Models\Event;
use Livewire\Component;

class PublicAnnouncements extends Component
{
    public $selectedAnnouncement = null;
    public bool $showModal = false;

    public function openAnnouncement(int $announcementId): void
    {
        $this->selectedAnnouncement = Announcement::query()
            ->where('is_published', true)
            ->where(function ($query) {
                $query->whereNull('published_at')
                    ->orWhere('published_at', '<=', now());
            })
            ->where(function ($query) {
                $query->whereNull('expires_at')
                    ->orWhere('expires_at', '>', now());
            })
            ->findOrFail($announcementId);

        $this->showModal = true;
    }

    public function closeAnnouncement(): void
    {
        $this->showModal = false;
        $this->selectedAnnouncement = null;
    }

public function render()
{
    $event = Event::query()
        ->with([
            'schedules' => fn ($query) => $query
                ->orderBy('sort_order')
                ->orderBy('schedule_time'),
        ])
        ->select('id', 'title', 'venue', 'event_date', 'description','dress_code')
        ->whereNotNull('event_date')
        ->where('event_date', '>=', now())
        ->orderBy('event_date', 'asc')
        ->first();

    $announcements = Announcement::query()
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
        ->limit(3)
        ->get();

    return view('livewire.public-announcements', [
        'event' => $event,
        'announcements' => $announcements,
    ]);
}
}