<?php

namespace App\Livewire;

use App\Models\Alumni;
use App\Models\Announcement;
use App\Models\Batch;
use App\Models\Donation;
use App\Models\Event;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class Dashboard extends Component
{
    use WithPagination;

    public string $title = 'Dashboard';

    protected $paginationTheme = 'tailwind';

    protected $queryString = [
        'donationsPage' => ['except' => 1],
        'latestPaymentsPage' => ['except' => 1],
        'upcomingEventsPage' => ['except' => 1],
        'announcementsPage' => ['except' => 1],
    ];

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
            ->paginate(3, ['*'], 'donationsPage');

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
            ->paginate(3, ['*'], 'latestPaymentsPage');

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
            ->paginate(4, ['*'], 'upcomingEventsPage');

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
            ->paginate(3, ['*'], 'announcementsPage');

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