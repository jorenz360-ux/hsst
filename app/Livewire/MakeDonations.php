<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Donation;
use App\Services\PayMongoService;
use Livewire\Attributes\Title;

#[Title('Make Donation')]
class MakeDonations extends Component


{
    public int|string $amount = '';
    public ?string $remarks = null;

    public function rules(): array
    {
        return [
            'amount' => ['required', 'integer', 'min:1'],
            'remarks' => ['nullable', 'string', 'max:500'],
        ];
    }

   public function pay(PayMongoService $paymongo)
{
    $this->validate([
        'amount' => ['required', 'integer', 'min:1'],
        'remarks' => ['nullable', 'string', 'max:500'],
    ]);

    $alumniId = Auth::user()->alumni_id;

    // Create donation record (NOT paid yet)
    $donation = Donation::create([
        'alumni_id' => $alumniId,
        'amount' => (int) $this->amount,      // pesos
        'remarks' => $this->remarks,
        'date_donated' => null,               // set after paid
    ]);

    $amountCentavos = ((int) $this->amount) * 100;
$baseUrl = rtrim(config('app.url'), '/'); 
    $payload = [
        'payment_method_types' => ['gcash'],
        'line_items' => [[
            'name' => 'Donation',
            'amount' => $amountCentavos,
            'currency' => 'PHP',
            'quantity' => 1,
        ]],
         'success_url' => $baseUrl . route('paymongo.return', absolute: false),
         'cancel_url'  => $baseUrl . route('paymongo.return', absolute: false),
        'metadata' => [
            'donation_id' => (string) $donation->id,
            'alumni_id' => (string) $alumniId,
        ],
    ];

    $json = $paymongo->createCheckoutSession($payload);

    $checkoutId  = data_get($json, 'data.id');
    $checkoutUrl = data_get($json, 'data.attributes.checkout_url');

    $donation->update([
        'paymongo_checkout_session_id' => $checkoutId,
    ]);
// logger()->info('PayMongo checkout response', $json);
// dd($json);
    return redirect()->away($checkoutUrl);
}

    public function resetForm(): void
    {
        $this->reset(['amount', 'remarks']);
    }

    public function render()
    {
        return view('livewire.make-donations');
    }
}