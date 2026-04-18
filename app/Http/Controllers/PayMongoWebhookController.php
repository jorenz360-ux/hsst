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
        if (! $this->verifySignature($request)) {
            return response()->json(['error' => 'Invalid signature'], 401);
        }

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

    private function verifySignature(Request $request): bool
    {
        $secret = config('services.paymongo.webhook_secret');

        if (blank($secret)) {
            return false;
        }

        $header = $request->header('Paymongo-Signature');

        if (blank($header)) {
            return false;
        }

        // Header format: t=<timestamp>,te=<test_hmac>,li=<live_hmac>
        $parts = [];
        foreach (explode(',', $header) as $part) {
            [$key, $value] = array_pad(explode('=', $part, 2), 2, '');
            $parts[$key] = $value;
        }

        $timestamp = $parts['t'] ?? '';

        if (blank($timestamp)) {
            return false;
        }

        $signed = $timestamp . '.' . $request->getContent();
        $expected = hash_hmac('sha256', $signed, $secret);

        $candidate = $parts['li'] ?? $parts['te'] ?? '';

        return hash_equals($expected, $candidate);
    }
}