<?php

namespace App\Livewire\Admin;

use App\Models\PasswordResetRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithPagination;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Livewire\Attributes\Title;

#[Title('Admin | Password reset request')]
class PasswordResetRequests extends Component
{
    use WithPagination;

    public string $status = 'pending';
    public string $search = '';

    public ?int $selectedRequestId = null;
    public string $adminNotes = '';

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingStatus(): void
    {
        $this->resetPage();
    }

    public function markProcessing(int $requestId): void
    {
        $request = PasswordResetRequest::findOrFail($requestId);

        if ($request->status !== 'pending') {
            session()->flash('status', 'Only pending requests can be marked as processing.');
            return;
        }

        $request->update([
            'status' => 'processing',
        ]);

        session()->flash('status', 'Request marked as processing.');
    }

    public function markRejected(int $requestId): void
    {
        $request = PasswordResetRequest::findOrFail($requestId);

        if (in_array($request->status, ['resolved', 'rejected'])) {
            session()->flash('status', 'This request is already closed.');
            return;
        }

        $request->update([
            'status' => 'rejected',
            'notes' => $this->adminNotes ?: $request->notes,
            'resolved_at' => now(),
            'resolved_by' => auth()->id(),
        ]);

        $this->adminNotes = '';

        session()->flash('status', 'Request rejected.');
    }

    public function resetPassword(int $requestId): void
    {
        $request = PasswordResetRequest::findOrFail($requestId);

        if (! $request->user_id) {
            session()->flash('status', 'This request is not linked to a valid user.');
            return;
        }

        $user = User::find($request->user_id);

        if (! $user) {
            session()->flash('status', 'User not found.');
            return;
        }

        $temporaryPassword = 'HNU-' . strtoupper(Str::random(8));

        $user->update([
            'password' => Hash::make($temporaryPassword),
            'must_change_password' => true,
        ]);

        $request->update([
            'status' => 'resolved',
            'notes' => trim(($request->notes ? $request->notes . "\n\n" : '') . 'Temporary Password: ' . $temporaryPassword),
            'resolved_at' => now(),
            'resolved_by' => auth()->id(),
        ]);

        session()->flash('status', "Password reset successful. Temporary password: {$temporaryPassword}");
    }

    public function render()
    {
        $requests = PasswordResetRequest::query()
            ->when($this->status !== 'all', function ($query) {
                $query->where('status', $this->status);
            })
            ->when($this->search !== '', function ($query) {
                $query->where(function ($sub) {
                    $sub->where('username', 'like', '%' . $this->search . '%')
                        ->orWhere('email', 'like', '%' . $this->search . '%')
                        ->orWhere('full_name', 'like', '%' . $this->search . '%');
                });
            })
            ->latest('requested_at')
            ->paginate(10);

        return view('livewire.admin.password-reset-requests', [
            'requests' => $requests,
        ]);
    }
}