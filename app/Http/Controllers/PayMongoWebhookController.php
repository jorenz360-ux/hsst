<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Donation;
use App\Models\Payment;
use App\Models\EventRegistration;

class PayMongoWebhookController extends Controller
{
    public function handle(Request $request)
    {
        $payload = $request->all();

        // PayMongo event type
        $type = data_get($payload, 'data.attributes.type');

        // Only handle successful checkout payment
        if ($type !== 'checkout_session.payment.paid') {
            return response()->json(['ok' => true], 200);
        }

        // Checkout session id from webhook payload
        $checkoutSessionId = data_get($payload, 'data.attributes.data.id');

        if (!$checkoutSessionId) {
            return response()->json(['ok' => true], 200);
        }

        // 1) Try donation first
        $donation = Donation::where('paymongo_checkout_session_id', $checkoutSessionId)->first();

        if ($donation) {
            // Idempotent: if already paid, do nothing
            if (!$donation->paid_at) {
                $donation->update([
                    'paid_at' => now(),
                    'date_donated' => now(),
                ]);
            }

            return response()->json(['ok' => true], 200);
        }

        // 2) Try event payment (payments table)
        $payment = Payment::where('paymongo_checkout_session_id', $checkoutSessionId)->first();

        if ($payment) {
            // Idempotent
            if (!$payment->paid_at) {
                $payment->update([
                    'paid_at' => now(),
                    'is_paid' => true,
                    'date_paid' => now(), // keep if you still use this column
                ]);

                // If linked to an event registration, mark it paid too
                if ($payment->registration_id) {
                    EventRegistration::whereKey($payment->registration_id)
                        ->whereNull('paid_at')
                        ->update([
                            'paid_at' => now(),
                            'status' => 'paid',
                        ]);
                }
            }

            return response()->json(['ok' => true], 200);
        }

        // If not found, still return 200 to avoid webhook retries loop
        return response()->json(['ok' => true], 200);
    }
}