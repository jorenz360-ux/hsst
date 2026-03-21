<?php

namespace App\Livewire;

use App\Models\Donation;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Title('Make Donation')]
class MakeDonations extends Component
{
    use WithFileUploads;

    public int|string $amount = '';
    public ?string $remarks = null;
    public ?string $reference_number = null;
    public $proof;

    public function rules(): array
    {
        return [
            'amount' => ['required', 'integer', 'min:1'],
            'remarks' => ['nullable', 'string', 'max:500'],
            'reference_number' => ['nullable', 'string', 'max:100'],
            'proof' => ['required', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:5120'],
        ];
    }

    public function submitDonation(): void
    {
        $validated = $this->validate();

        $user = Auth::user();
        $alumniId = $user?->alumni_id;

        abort_if(! $alumniId, 403, 'Alumni profile is required.');

        $proofPath = $this->proof->storePublicly('donation-proofs', 's3');

        Donation::create([
            'alumni_id' => $alumniId,
            'amount' => ((int) $validated['amount']), // store in centavos
            'date_donated' => now(),
            'remarks' => $validated['remarks'] ?: null,
            'reference_number' => $validated['reference_number'] ?: null,
            'or_file_path' => $proofPath,
            'status' => 'pending',
            'paid_at' => null,
        ]);

        $this->resetForm();

        session()->flash('success', 'Donation proof submitted successfully. Please wait for verification.');
    }

    public function resetForm(): void
    {
        $this->reset([
            'amount',
            'remarks',
            'reference_number',
            'proof',
        ]);

        $this->resetValidation();
    }

    public function render()
    {
        $alumniId = Auth::user()?->alumni_id;

        $donations = Donation::where('alumni_id', $alumniId)
            ->latest()
            ->get();

        $verifiedTotal = Donation::where('alumni_id', $alumniId)
            ->where('status', 'verified')
            ->sum('amount');

        $pendingCount = Donation::where('alumni_id', $alumniId)
            ->where('status', 'pending')
            ->count();

        return view('livewire.make-donations', [
            'donations' => $donations,
            'verifiedTotal' => $verifiedTotal,
            'pendingCount' => $pendingCount,
        ]);
    }
}