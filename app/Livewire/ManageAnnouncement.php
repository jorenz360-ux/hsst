<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Announcement;
use Livewire\WithPagination;
use Livewire\Attributes\Title;

#[Title('Announcement')]
class ManageAnnouncement extends Component
{
    public string $announceTitle = '';
    public string $announceBody  = '';

  use WithPagination;

    public function render()
    {
       $announcements = Announcement::query()
    ->select(['id','title','body','is_published','published_at','pinned','expires_at','created_by'])
    ->where('is_published', true)
    ->where(fn ($q) => $q->whereNull('expires_at')->orWhere('expires_at', '>', now()))
    ->with([
        'creator:id,alumni_id',                 // select only needed columns from users
        'creator.alumni:id,fname,lname',        // select name from alumni table
    ])
    ->orderByDesc('pinned')
    ->orderByDesc('published_at')
    ->paginate(5);
        return view('livewire.announcement', compact('announcements'));
    }

    public function store(): void
    {
        abort_unless(auth()->user()?->can('announcement.create'), 403);

        $this->validate([
            'announceTitle' => ['required', 'string', 'max:150'],
            'announceBody'  => ['required', 'string', 'max:5000'],
        ]);

        Announcement::create([
            'title'        => $this->announceTitle,
            'body'         => $this->announceBody,
            'is_published' => true,
            'published_at' => now(),
            'pinned'       => false,
            'expires_at'   => null,
            'created_by'   => auth()->id(),
        ]);

        $this->reset(['announceTitle', 'announceBody']);
        session()->flash('status', 'Announcement published.');
    }
}
