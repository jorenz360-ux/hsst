<?php

namespace App\Livewire;

use App\Models\EventRegistration;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;

class EventRegistrationPaymentPage extends Component
{
    use WithFileUploads;

    public EventRegistration $registration;
    public Payment $payment;

    public $proof;
    public ?string $reference_number = null;
    public ?string $remarks = null;

    public function mount(EventRegistration $registration): void
    {
        $user = Auth::user();
        $alumniId = $user?->alumni_id;

        abort_if(!$alumniId, 403, 'Alumni profile is required.');

        $registration->load(['event', 'alumni']);

        // Secure ownership check
        abort_if((int) $registration->alumni_id !== (int) $alumniId, 403, 'Unauthorized access.');

        $this->registration = $registration;

        $this->payment = Payment::firstOrCreate(
            [
                'registration_id' => $registration->id,
            ],
            [
                'alumni_id' => $registration->alumni_id,
                'amount' => (int) ($registration->event->registration_fee ?? 0),
                'mode' => 'manual',
                'remarks' => null,
                'paid_at' => null,
                'is_paid' => false,
            ]
        );

        $this->reference_number = $this->payment->reference_number ?? null;
        $this->remarks = $this->payment->remarks ?? null;
    }

    public function submitProof(): void
    {
        $validated = $this->validate([
            'proof' => ['required', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:5120'],
            'reference_number' => ['nullable', 'string', 'max:100'],
            'remarks' => ['nullable', 'string', 'max:1000'],
        ]);

        DB::transaction(function () use ($validated) {
            $proofPath = $this->proof->store('event-payment-proofs', 'public');

            $this->payment->update([
                'reference_number' => $validated['reference_number'] ?: null,
                'remarks' => $validated['remarks'] ?: null,
                'proof_path' => $proofPath,
                'mode' => 'manual',
                'is_paid' => false,
            ]);

            // Status depends on your workflow naming
            $this->registration->update([
                'status' => 'pending',
            ]);
        });

        $this->proof = null;

        session()->flash('success', 'Payment proof uploaded successfully. Please wait for admin verification.');
    }

    public function render()
    {
        return view('livewire.event-registration-payment-page');
    }
}