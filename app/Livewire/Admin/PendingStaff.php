<?php

namespace App\Livewire\Admin;

use App\Mail\StaffAccountApproved;
use App\Mail\StaffAccountRejected;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('Admin | Pending Staff Registrations')]
class PendingStaff extends Component
{
    use WithPagination;

    public function approve(int $userId): void
    {
        abort_unless(auth()->user()->hasRole('reunion-coordinator'), 403);

        $user = User::whereHas('staff')->where('is_active', false)->findOrFail($userId);

        $user->update(['is_active' => true]);

        Mail::to($user->email)->queue(new StaffAccountApproved($user->staff, $user->username));

        session()->flash('success', "Account approved for {$user->staff->fname} {$user->staff->lname}.");
    }

    public function reject(int $userId): void
    {
        abort_unless(auth()->user()->hasRole('reunion-coordinator'), 403);

        $user = User::whereHas('staff')->where('is_active', false)->findOrFail($userId);

        $fullName = "{$user->staff->fname} {$user->staff->lname}";
        $email = $user->email;

        $user->staff->delete();

        Mail::to($email)->queue(new StaffAccountRejected($fullName));

        session()->flash('success', "Registration for {$fullName} has been rejected and removed.");
    }

    public function render()
    {
        $pending = User::whereHas('staff')
            ->where('is_active', false)
            ->with('staff')
            ->latest()
            ->paginate(15);

        return view('livewire.admin.pending-staff', ['pending' => $pending]);
    }
}
