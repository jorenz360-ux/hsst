<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Donation;
use App\Models\Event;
use App\Models\Alumni;
use App\Models\User;
use App\Models\Announcement;
use App\Models\Batch;

class Dashboard extends Component
{
    use WithPagination;

    public string $title = 'Dashboard';

    public function render()
    {
        $paidDonationsQuery = Donation::query()
            ->select([
                'id',
                'alumni_id',
                'amount',
                'remarks',
                'paid_at',
                'date_donated',
                'created_at',
            ])
            ->whereNotNull('paid_at');

        $donations = (clone $paidDonationsQuery)
            ->with(['alumni:id,lname,fname,mname'])
            ->latest('paid_at')
            ->paginate(5);

        $allDonationsTotal = (clone $paidDonationsQuery)->sum('amount');

        $donationsThisMonth = Donation::query()
            ->whereNotNull('paid_at')
            ->whereYear('paid_at', now()->year)
            ->whereMonth('paid_at', now()->month)
            ->sum('amount');

        $upcomingEventsCount = Event::query()
            ->where('is_active', true)
            ->whereDate('event_date', '>=', now()->toDateString())
            ->count();

        $latestPayments = Donation::query()
            ->select([
                'id',
                'alumni_id',
                'amount',
                'paid_at',
                'paymongo_checkout_session_id',
            ])
            ->with(['alumni:id,lname,fname,mname'])
            ->whereNotNull('paid_at')
            ->latest('paid_at')
            ->limit(5)
            ->get();

        $upcomingEvents = Event::query()
            ->select([
                'id',
                'title',
                'venue',
                'event_date',
                'dress_code',
                'registration_fee',
                'is_active',
            ])
            ->where('is_active', true)
            ->whereDate('event_date', '>=', now()->toDateString())
            ->orderBy('event_date')
            ->limit(4)
            ->get();

        $totalAlumni = Alumni::count();
        $totalUsers = User::count();
        $totalBatches = Batch::count();

        $publishedAnnouncementsCount = Announcement::query()
            ->where('is_published', true)
            ->where(function ($query) {
                $query->whereNull('published_at')
                    ->orWhere('published_at', '<=', now());
            })
            ->where(function ($query) {
                $query->whereNull('expires_at')
                    ->orWhere('expires_at', '>', now());
            })
            ->count();

        $recentAnnouncements = Announcement::query()
            ->select([
                'id',
                'title',
                'is_published',
                'pinned',
                'published_at',
                'created_at',
            ])
            ->latest('published_at')
            ->latest('created_at')
            ->limit(5)
            ->get();

        return view('livewire.dashboard', [
            'donations' => $donations,
            'allDonationsTotal' => $allDonationsTotal,
            'donationsThisMonth' => $donationsThisMonth,
            'upcomingEventsCount' => $upcomingEventsCount,
            'latestPayments' => $latestPayments,
            'upcomingEvents' => $upcomingEvents,
            'totalAlumni' => $totalAlumni,
            'totalUsers' => $totalUsers,
            'totalBatches' => $totalBatches,
            'publishedAnnouncementsCount' => $publishedAnnouncementsCount,
            'recentAnnouncements' => $recentAnnouncements,
        ]);
    }
}