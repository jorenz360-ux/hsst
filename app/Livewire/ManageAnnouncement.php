<?php

namespace App\Livewire;

use App\Models\Announcement;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('Admin | Announcements Management')]
class ManageAnnouncement extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';

    public int $perPage = 8;
    public string $search = '';

    // Create form
    public string $announceTitle = '';
    public string $announceBody  = '';

    // Edit form
    public ?int $editingId = null;
    public string $editTitle = '';
    public string $editBody  = '';

    // Delete form
    public ?int $deleteId = null;
    public string $deleteTitle = '';

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    protected function createRules(): array
    {
        return [
            'announceTitle' => ['required', 'string', 'max:150'],
            'announceBody'  => ['required', 'string', 'max:5000'],
        ];
    }

    protected function editRules(): array
    {
        return [
            'editTitle' => ['required', 'string', 'max:150'],
            'editBody'  => ['required', 'string', 'max:5000'],
        ];
    }

    protected function canCreate(): bool
    {
        return auth()->user()?->can('announcement.create') ?? false;
    }

    protected function canUpdate(): bool
    {
        return (auth()->user()?->can('announcement.update') ?? false)
            || $this->canCreate();
    }

    protected function canDelete(): bool
    {
        return (auth()->user()?->can('announcement.delete') ?? false)
            || $this->canCreate();
    }

    protected function authorizeCreate(): void
    {
        abort_unless($this->canCreate(), 403);
    }

    protected function authorizeUpdate(): void
    {
        abort_unless($this->canUpdate(), 403);
    }

    protected function authorizeDelete(): void
    {
        abort_unless($this->canDelete(), 403);
    }

    protected function announcementQuery()
    {
        return Announcement::query()
            ->select([
                'id',
                'title',
                'body',
                'is_published',
                'published_at',
                'pinned',
                'expires_at',
                'created_by',
                'created_at',
            ])
            ->with([
                'creator:id,alumni_id',
                'creator.alumni:id,fname,lname',
            ])
            ->when(
                filled($this->search),
                fn ($query) => $query->where(function ($q) {
                    $q->where('title', 'like', '%' . trim($this->search) . '%')
                      ->orWhere('body', 'like', '%' . trim($this->search) . '%');
                })
            )
            ->orderByDesc('pinned')
            ->orderByDesc('published_at')
            ->orderByDesc('created_at');
    }

    public function render()
    {
        return view('livewire.announcement', [
            'announcements' => $this->announcementQuery()->paginate($this->perPage),
        ]);
    }

    public function store(): void
    {
        $this->authorizeCreate();

        $validated = $this->validate($this->createRules());

        Announcement::create([
            'title'        => trim($validated['announceTitle']),
            'body'         => trim($validated['announceBody']),
            'is_published' => true,
            'published_at' => now(),
            'pinned'       => false,
            'expires_at'   => null,
            'created_by'   => auth()->id(),
        ]);

        $this->resetCreateForm();

        session()->flash('status', 'Announcement published successfully.');
        $this->dispatch('announcement-saved');
        $this->dispatch('close-modal', name: 'create-announcement');
    }

    public function startEdit(int $id): void
    {
        $this->authorizeUpdate();

        $announcement = Announcement::query()->findOrFail($id);

        $this->editingId = $announcement->id;
        $this->editTitle = $announcement->title;
        $this->editBody  = $announcement->body;

        $this->resetValidation();

        $this->dispatch('open-modal', name: 'edit-announcement');
    }

    public function updateAnnouncement(): void
    {
        $this->authorizeUpdate();

        if (! $this->editingId) {
            return;
        }

        $validated = $this->validate($this->editRules());

        $announcement = Announcement::query()->findOrFail($this->editingId);

        $announcement->update([
            'title' => trim($validated['editTitle']),
            'body'  => trim($validated['editBody']),
        ]);

        $updatedId = $announcement->id;

        $this->resetEditForm();

        session()->flash('status', 'Announcement updated successfully.');
        $this->dispatch('announcement-updated', id: $updatedId);
        $this->dispatch('close-modal', name: 'edit-announcement');
    }

    public function confirmDelete(int $id): void
    {
        $this->authorizeDelete();

        $announcement = Announcement::query()->findOrFail($id);

        $this->deleteId    = $announcement->id;
        $this->deleteTitle = $announcement->title;

        $this->resetValidation();

        $this->dispatch('open-modal', name: 'delete-announcement');
    }

    public function destroyAnnouncement(): void
    {
        $this->authorizeDelete();

        if (! $this->deleteId) {
            return;
        }

        $deletedId = $this->deleteId;

        Announcement::query()
            ->whereKey($this->deleteId)
            ->delete();

        $this->resetDeleteForm();

        $this->fixPaginationAfterDelete();

        session()->flash('status', 'Announcement deleted successfully.');
        $this->dispatch('announcement-deleted', id: $deletedId);
        $this->dispatch('close-modal', name: 'delete-announcement');
    }

    protected function fixPaginationAfterDelete(): void
    {
        $total = $this->announcementQuery()->count();
        $lastPage = max((int) ceil($total / $this->perPage), 1);

        if ($this->getPage() > $lastPage) {
            $this->setPage($lastPage);
        }
    }

    public function resetCreateForm(): void
    {
        $this->reset(['announceTitle', 'announceBody']);
        $this->resetValidation();
    }

    public function resetEditForm(): void
    {
        $this->reset(['editingId', 'editTitle', 'editBody']);
        $this->resetValidation();
    }

    public function resetDeleteForm(): void
    {
        $this->reset(['deleteId', 'deleteTitle']);
        $this->resetValidation();
    }
}