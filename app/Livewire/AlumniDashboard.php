<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Donation;
use App\Models\Event;
use App\Models\EventRegistration;
use App\Models\Announcement;
use App\Models\Payment;
use App\Services\PayMongoService;
class AlumniDashboard extends Component
{
    public array $myEventRegs = []; 
    public int $paidTotal = 0;              // centavos
    public ?string $lastPaidAt = null;      // formatted
    public ?int $lastPaidAmount = null;     // centavos
    public $latestAnnouncements;
    public $upcomingEvents; // collection

    public function mount(): void
    {
        $user = Auth::user();
        $alumniId = $user?->alumni_id;
        
        if ($alumniId) {
            $paidQuery = Donation::query()
                ->where('alumni_id', $alumniId)
                ->whereNotNull('paid_at')
                ->whereNotNull('paymongo_checkout_session_id');

            $this->paidTotal = (int) $paidQuery->sum('amount');

            $last = (clone $paidQuery)
                ->select(['amount', 'paid_at'])
                ->latest('paid_at')
                ->first();

            $this->lastPaidAmount = $last?->amount ? (int) $last->amount : null;
            $this->lastPaidAt = $last?->paid_at?->format('M d, Y h:i A');
        }

       
        $this->upcomingEvents = Event::query()
            ->select(['id','title','venue','event_date','registration_fee'])
            ->where('is_active', true)
            ->where('event_date', '>=', now())
            ->orderBy('event_date')
            ->limit(4)
            ->get();

        if ($alumniId) {
            $eventIds = $this->upcomingEvents->pluck('id')->all();

            $regs = EventRegistration::query()
                ->select(['id','event_id','status','paid_at'])
                ->where('alumni_id', $alumniId)
                ->whereIn('event_id', $eventIds)
                ->get();

            $this->myEventRegs = $regs->keyBy('event_id')->map(fn ($r) => [
                'id' => $r->id,
                'status' => $r->status,
                'paid_at' => $r->paid_at,
            ])->toArray();
        }

        $this->latestAnnouncements = Announcement::query()
            ->select(['id', 'title', 'body', 'created_at'])
            ->where('is_published', true)
            ->latest('id')
            ->limit(5)
            ->get();
    }
 public function registerOrPay(int $eventId, PayMongoService $paymongo)
{
    $user = Auth::user();
    $alumniId = $user?->alumni_id;
    abort_if(!$alumniId, 403);

    $event = Event::query()
        ->select(['id','title','registration_fee','is_active','event_date'])
        ->whereKey($eventId)
        ->firstOrFail();

    abort_if(!$event->is_active || $event->event_date->isPast(), 403);

    $registration = EventRegistration::firstOrCreate(
        ['event_id' => $event->id, 'alumni_id' => $alumniId],
        ['status' => 'pending', 'fee_paid' => 0]
    );

    if ($registration->paid_at || $registration->status === 'paid') {
        session()->flash('status', 'Already registered and paid.');
        return;
    }

    if ((int) $event->registration_fee === 0) {
        $registration->update(['status' => 'paid', 'paid_at' => now(), 'fee_paid' => 0]);
        session()->flash('status', 'Registered successfully.');
        return;
    }

    // Amount in centavos (if your event fee is stored in centavos)
    $amountCentavos = (int) $event->registration_fee;

    $payment = Payment::create([
        'alumni_id' => $alumniId,
        'registration_id' => $registration->id,
        'amount' => $amountCentavos,
        'mode' => 'gcash',
        'remarks' => null,
        'paid_at' => null,
        'is_paid' => false,
    ]);

    $baseUrl = rtrim(config('app.url'), '/');

    $payload = [
        'payment_method_types' => ['gcash'],
        'line_items' => [[
            'name' => 'Event Registration: ' . $event->title,
            'amount' => $amountCentavos,
            'currency' => 'PHP',
            'quantity' => 1,
        ]],
        'success_url' => $baseUrl . route('paymongo.return', absolute: false),
        'cancel_url'  => $baseUrl . route('paymongo.return', absolute: false),
        'metadata' => [
            'payment_id' => (string) $payment->id,
            'registration_id' => (string) $registration->id,
            'event_id' => (string) $event->id,
            'alumni_id' => (string) $alumniId,
            'type' => 'event_registration',
        ],
    ];

    $json = $paymongo->createCheckoutSession($payload);

    $checkoutId  = data_get($json, 'data.id');
    $checkoutUrl = data_get($json, 'data.attributes.checkout_url');

    $payment->update(['paymongo_checkout_session_id' => $checkoutId]);

    return redirect()->away($checkoutUrl);
}
    public function render()
    {
        return view('livewire.alumni-dashboard');
    }
}