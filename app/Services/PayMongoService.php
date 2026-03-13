<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class PayMongoService
{
    public function createCheckoutSession(array $attributes): array
    {
        $secret = config('services.paymongo.secret');

        $res = Http::withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => 'Basic ' . base64_encode($secret . ':'),
        ])->post('https://api.paymongo.com/v1/checkout_sessions', [
            'data' => ['attributes' => $attributes],
        ]);

        if (!$res->successful()) {
            throw new \RuntimeException($res->body());
        }

        return $res->json();
    }
}