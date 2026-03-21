<?php

namespace App\Livewire;

use App\Models\Event;
use App\Models\EventRegistration;
use App\Models\Payment;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Title('Event Payment')]
class EventRegistrationPaymentPage extends Component
{
    use WithFileUploads;

    public Event $event;
    public EventRegistration $registration;
    public ?Payment $payment = null;

    public Collection $registrationItems;
    public Collection $paymentHistory;

    public $proof;
    // public ?string $reference_number = null;
    public ?string $remarks = null;

    /**
     * null = base registration fee
     * int  = event_registration_items.id
     */
    public ?int $selectedItemId = null;

    public function mount(Event $event): void
    {
        $alumniId = Auth::user()?->alumni_id;

        abort_if(! $alumniId, 403, 'Alumni profile is required.');
        abort_if(! $event->is_active, 403, 'This event is not available.');
        abort_if($event->event_date?->isPast(), 403, 'This event is no longer available.');

        $this->event = $event->load([
            'registrationItems' => fn ($query) => $query
                ->where('is_active', true)
                ->orderBy('sort_order')
                ->with('schedule:id,title,schedule_time'),
            'schedules' => fn ($query) => $query
                ->orderBy('sort_order')
                ->orderBy('schedule_time'),
        ]);

        // Registration must exist first
        $this->registration = EventRegistration::firstOrCreate(
            [
                'event_id' => $this->event->id,
                'alumni_id' => $alumniId,
            ],
            [
                'status' => 'pending',
                'fee_paid' => 0,
            ]
        );

        $this->registrationItems = $this->event->registrationItems;

        // Default selected target = base registration fee
        $this->selectedItemId = null;

        $this->refreshPaymentState();
    }

    protected function refreshPaymentState(): void
    {
        $this->payment = Payment::query()
            ->with('registrationItem:id,name')
            ->where('registration_id', $this->registration->id)
            ->latest('id')
            ->first();

        $this->paymentHistory = Payment::query()
            ->with('registrationItem:id,name')
            ->where('registration_id', $this->registration->id)
            ->latest('id')
            ->get();

        // $this->reference_number = null;
        $this->remarks = null;
    }

    public function getSelectedItemProperty()
    {
        if (! $this->selectedItemId) {
            return null;
        }

        return $this->registrationItems->firstWhere('id', $this->selectedItemId);
    }

    public function getSelectedLabelProperty(): string
    {
        return $this->selectedItem?->name ?? 'Event Registration Fee';
    }

    public function getAmountDueProperty(): int
    {
        if ($this->selectedItemId) {
            return (int) ($this->selectedItem?->price ?? 0);
        }

        return (int) ($this->event->registration_fee ?? 0);
    }

    public function getBaseRegistrationFeeProperty(): int
    {
        return (int) ($this->event->registration_fee ?? 0);
    }

    public function getBasePaymentProperty(): ?Payment
    {
        return Payment::query()
            ->where('registration_id', $this->registration->id)
            ->whereNull('event_registration_item_id')
            ->latest('id')
            ->first();
    }

    public function getBasePaymentStatusProperty(): string
    {
        if ($this->baseRegistrationFee <= 0) {
            return 'not_required';
        }

        return match ($this->basePayment?->status) {
            'pending' => 'pending',
            'verified' => 'paid',
            'rejected' => 'rejected',
            default => 'unpaid',
        };
    }

    public function getBaseRegistrationSatisfiedProperty(): bool
    {
        if ($this->baseRegistrationFee <= 0) {
            return true;
        }

        return in_array($this->basePaymentStatus, ['pending', 'paid'], true);
    }

    public function getPaymentStatusProperty(): string
    {
        if (! $this->selectedItemId) {
            return $this->basePaymentStatus;
        }

        $itemPayment = Payment::query()
            ->where('registration_id', $this->registration->id)
            ->where('event_registration_item_id', $this->selectedItemId)
            ->latest('id')
            ->first();

        return match ($itemPayment?->status) {
            'pending' => 'pending',
            'verified' => 'paid',
            'rejected' => 'rejected',
            default => 'unpaid',
        };
    }

    public function getCanSelectItemsProperty(): bool
    {
        return $this->baseRegistrationSatisfied;
    }

    public function getCanSubmitProperty(): bool
    {
        if ($this->amountDue <= 0) {
            return false;
        }

        if ($this->selectedItemId && ! $this->baseRegistrationSatisfied) {
            return false;
        }

        return in_array($this->paymentStatus, ['unpaid', 'rejected'], true);
    }

    public function updatedSelectedItemId($value): void
    {
        $this->selectedItemId = blank($value) ? null : (int) $value;
        $this->resetValidation();
        $this->proof = null;
        // $this->reference_number = null;
        $this->remarks = null;
    }

    public function submitProof(): void
    {
        if ($this->amountDue <= 0) {
            session()->flash('error', 'The selected payment target does not require payment.');
            return;
        }

        if ($this->selectedItemId && ! $this->baseRegistrationSatisfied) {
            session()->flash('error', 'Please complete the event registration payment first before paying for add-on items.');
            return;
        }

        if (! $this->canSubmit) {
            session()->flash('error', 'You cannot submit payment proof for this item at this stage.');
            return;
        }

        $validated = $this->validate([
            'selectedItemId' => ['nullable', 'integer', 'exists:event_registration_items,id'],
            'proof' => ['required', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:5120'],
            // 'reference_number' => ['nullable', 'string', 'max:100'],
            'remarks' => ['nullable', 'string', 'max:1000'],
        ]);

        DB::transaction(function () use ($validated) {
            $proofPath = $this->proof->storePublicly('event-payment-proofs', 's3');

            Payment::create([
                'registration_id' => $this->registration->id,
                'alumni_id' => $this->registration->alumni_id,
                'event_registration_item_id' => $validated['selectedItemId'] ?? null,
                'amount' => $this->amountDue,
                'mode' => 'manual',
                // 'reference_number' => $validated['reference_number'] ?: null,
                'remarks' => $validated['remarks'] ?: null,
                'or_file_path' => $proofPath,
                'status' => 'pending',
            ]);

            $this->registration->update([
                'status' => 'pending',
                'fee_paid' => $this->baseRegistrationSatisfied ? 1 : 0,
            ]);
        });

        $this->proof = null;
        // $this->reference_number = null;
        $this->remarks = null;

        $this->refreshPaymentState();

        session()->flash('success', 'Payment proof uploaded successfully. Please wait for admin verification.');
    }

    public function render()
    {
        return view('livewire.event-registration-payment-page');
    }
}