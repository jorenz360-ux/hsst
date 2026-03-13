<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Payment;
use App\Models\EventRegistration;
use App\Services\PayMongoService;

class EventPayment extends Component
{
    public EventRegistration $registration;

    public ?string $remarks = null;

    public function mount(EventRegistration $registration): void
    {
        $user = Auth::user();
        abort_if($registration->alumni_id !== $user->alumni_id, 403);
        abort_if($registration->paid_at !== null || $registration->status === 'paid', 403);

        $this->registration = $registration->loadMissing('event:id,title,registration_fee');
    }

   public function pay(PayMongoService $paymongo)
{
    $this->validate([
        'remarks' => ['nullable', 'string', 'max:500'],
    ]);

    $user = Auth::user();
    $alumniId = $user->alumni_id;


    $amountCentavos = (int) $this->registration->event->registration_fee;
    abort_if($amountCentavos < 1, 422, 'Invalid event fee.');


    $payment = Payment::create([
        'alumni_id' => $alumniId,
        'registration_id' => $this->registration->id, 
        'amount' => $amountCentavos,
        'mode' => 'gcash',
        'remarks' => $this->remarks,
        'paid_at' => null,
        'is_paid' => false,
    ]);

    $baseUrl = rtrim(config('app.url'), '/');

    $payload = [
        'payment_method_types' => ['gcash'],
        'line_items' => [[
            'name'     => 'Event Registration: ' . ($this->registration->event->title ?? 'Event'),
            'amount'   => $amountCentavos,
            'currency' => 'PHP',
            'quantity' => 1,
        ]],
        'success_url' => $baseUrl . route('paymongo.return', absolute: false),
        'cancel_url'  => $baseUrl . route('paymongo.return', absolute: false),

        'metadata' => [
            'type'            => 'event_registration',
            'payment_id'      => (string) $payment->id,
            'registration_id' => (string) $this->registration->id,
            'event_id'        => (string) $this->registration->event_id,
            'alumni_id'       => (string) $alumniId,
        ],
    ];

    try {
        $json = $paymongo->createCheckoutSession($payload);
    } catch (\Throwable $e) {
        logger()->error('PayMongo event checkout failed', [
            'message' => $e->getMessage(),
            'payload' => $payload,
            'payment_id' => $payment->id,
        ]);

        $this->addError('paymongo', 'Payment gateway error. Please try again.');
        return;
    }

    $checkoutId  = data_get($json, 'data.id');
    $checkoutUrl = data_get($json, 'data.attributes.checkout_url');

    if (!$checkoutId || !$checkoutUrl) {
        logger()->error('PayMongo event checkout missing fields', [
            'response' => $json,
            'payment_id' => $payment->id,
        ]);

        $this->addError('paymongo', 'Payment gateway error. Please try again.');
        return;
    }

    $payment->update([
        'paymongo_checkout_session_id' => $checkoutId,
    ]);

    return redirect()->away($checkoutUrl);
}
    public function render()
    {
        return view('livewire.event-payment', [
            'event' => $this->registration->event,
            'registration' => $this->registration,
        ]);
    }
}