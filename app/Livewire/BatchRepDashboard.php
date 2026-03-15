<?php

namespace App\Livewire;

use App\Models\Alumni;
use App\Models\Announcement;
use App\Models\Donation;
use App\Models\Event;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class BatchRepDashboard extends Component
{
    public function render()
    {
        $user = Auth::user();
        $alumni = $user->alumni;
        $batchId = $alumni?->batch_id;

        abort_unless($batchId, 403);

        $batchAlumniCount = Alumni::where('batch_id', $batchId)->count();

        $registeredUsersCount = Alumni::where('batch_id', $batchId)
            ->whereHas('user')
            ->count();

        $batchRepCount = Alumni::where('batch_id', $batchId)
            ->where('is_batch_rep', true)
            ->count();

        $upcomingEventsCount = Event::query()
            ->where('is_active', true)
            ->whereDate('event_date', '>=', now()->toDateString())
            ->count();

        $batchDonationTotal = Donation::query()
            ->whereNotNull('paid_at')
            ->whereHas('alumni', fn ($q) => $q->where('batch_id', $batchId))
            ->sum('amount');

        $batchDonationsThisMonth = Donation::query()
            ->whereNotNull('paid_at')
            ->whereYear('paid_at', now()->year)
            ->whereMonth('paid_at', now()->month)
            ->whereHas('alumni', fn ($q) => $q->where('batch_id', $batchId))
            ->sum('amount');

        $batchMembers = Alumni::query()
            ->with('user:id,alumni_id,username,email')
            ->where('batch_id', $batchId)
            ->orderBy('lname')
            ->orderBy('fname')
            ->limit(10)
            ->get();

        $upcomingEvents = Event::query()
            ->where('is_active', true)
            ->whereDate('event_date', '>=', now()->toDateString())
            ->orderBy('event_date')
            ->limit(5)
            ->get();

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
            ->latest('published_at')
            ->latest('created_at')
            ->limit(5)
            ->get();

        return view('livewire.batch-rep-dashboard', [
            'batchAlumniCount' => $batchAlumniCount,
            'registeredUsersCount' => $registeredUsersCount,
            'batchRepCount' => $batchRepCount,
            'upcomingEventsCount' => $upcomingEventsCount,
            'batchDonationTotal' => $batchDonationTotal,
            'batchDonationsThisMonth' => $batchDonationsThisMonth,
            'batchMembers' => $batchMembers,
            'upcomingEvents' => $upcomingEvents,
            'announcements' => $announcements,
        ]);
    }
}