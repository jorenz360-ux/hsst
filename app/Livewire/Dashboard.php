<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use App\Models\Donation;
use App\Models\Event;
class Dashboard extends Component
{
    use WithPagination;

    public $title;


public function render()
{
    $donationsQuery = Donation::query()
        ->select([
            'id',
            'alumni_id',
            'amount',
            'remarks',
            'paid_at',
            'date_donated',
            'created_at',
        ])
        ->whereNotNull('paid_at'); // only paid

        $donationsThisMonth = Donation::query()
            ->whereNotNull('paid_at')
            ->whereYear('paid_at', now()->year)
            ->whereMonth('paid_at', now()->month)
            ->sum('amount');

         $upcomingEventsCount = Event::query()
        ->where('is_active', true)
        ->where('event_date', '>=', now())
        ->count();

        $latestPayments = Donation::query()
        ->select(['id','alumni_id','amount','paid_at','paymongo_checkout_session_id'])
        ->with(['alumni:id,lname,fname,mname'])
        ->whereNotNull('paid_at')
        ->latest('paid_at')
        ->limit(5)
        ->get();
        
    $donations = (clone $donationsQuery)
        ->latest('id')
        ->paginate(5);

    $allDonationsTotal = (clone $donationsQuery)->sum('amount');

    return view('livewire.dashboard', compact('donations', 'allDonationsTotal', 'donationsThisMonth','upcomingEventsCount', 'latestPayments'));
}

}