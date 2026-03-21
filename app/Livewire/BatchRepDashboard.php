<?php

namespace App\Livewire;

use App\Models\Alumni;
use App\Models\Announcement;
use App\Models\Donation;
use App\Models\Event;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Batch Representative Dashboard')]
class BatchRepDashboard extends Component
{
    public function render()
    {
        $user = Auth::user();
        $batchId = $user?->alumni?->batch_id;

        abort_unless($batchId, 403);

        $now = now();
        $today = $now->toDateString();

        $batchAlumniQuery = Alumni::query()
            ->where('batch_id', $batchId);

        $paidBatchDonationsQuery = Donation::query()
            ->whereNotNull('paid_at')
            ->whereHas('alumni', function ($query) use ($batchId) {
                $query->where('batch_id', $batchId);
            });

        $upcomingEventsQuery = Event::query()
            ->where('is_active', true)
            ->whereDate('event_date', '>=', $today);

        $batchAlumniCount = (clone $batchAlumniQuery)->count();

        $registeredUsersCount = (clone $batchAlumniQuery)
            ->whereHas('user')
            ->count();

        $upcomingEventsCount = (clone $upcomingEventsQuery)->count();

        $batchDonationTotal = (clone $paidBatchDonationsQuery)->sum('amount');

        $batchDonationsThisMonth = (clone $paidBatchDonationsQuery)
            ->whereYear('paid_at', $now->year)
            ->whereMonth('paid_at', $now->month)
            ->sum('amount');

        $batchMembers = (clone $batchAlumniQuery)
            ->with('user:id,alumni_id,username,email')
            ->orderBy('lname')
            ->orderBy('fname')
            ->limit(10)
            ->get();

        $upcomingEvents = (clone $upcomingEventsQuery)
            ->orderBy('event_date')
            ->limit(5)
            ->get();

        $announcements = Announcement::query()
            ->where('is_published', true)
            ->where(function ($query) use ($now) {
                $query->whereNull('published_at')
                    ->orWhere('published_at', '<=', $now);
            })
            ->where(function ($query) use ($now) {
                $query->whereNull('expires_at')
                    ->orWhere('expires_at', '>', $now);
            })
            ->orderByDesc('published_at')
            ->orderByDesc('created_at')
            ->limit(5)
            ->get();

        return view('livewire.batch-rep-dashboard', [
            'batchAlumniCount' => $batchAlumniCount,
            'registeredUsersCount' => $registeredUsersCount,
            'upcomingEventsCount' => $upcomingEventsCount,
            'batchDonationTotal' => $batchDonationTotal,
            'batchDonationsThisMonth' => $batchDonationsThisMonth,
            'batchMembers' => $batchMembers,
            'upcomingEvents' => $upcomingEvents,
            'announcements' => $announcements,
        ]);
    }
}