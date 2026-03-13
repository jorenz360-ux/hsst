<?php

namespace App\Livewire;

use App\Models\Event;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CreateEvents extends Component
{
    public string $title = '';
    public string $venue = '';
    public string $event_date = '';          // from datetime-local input
    public ?int $registration_fee = 0;       // pesos in UI
    public ?string $description = null;
    public bool $is_active = true;

    public function save(): void
    {
        // 1) Validate
        $validated = $this->validate([
            'title' => ['required', 'string', 'max:255'],
            'venue' => ['required', 'string', 'max:255'],
            'event_date' => ['required', 'date'], // "YYYY-MM-DDTHH:MM" is acceptable
            'registration_fee' => ['nullable', 'integer', 'min:0'],
            'description' => ['nullable', 'string', 'max:5000'],
            'is_active' => ['boolean'],
        ]);

        // 2) Convert fee pesos -> centavos
        $feeCentavos = ((int) ($validated['registration_fee'] ?? 0)) * 100;

        // 3) Parse datetime-local to Carbon (stored as DATETIME)
        $eventDate = Carbon::parse($validated['event_date']);

        // 4) Create (assumes events.created_by FK exists)
        Event::create([
            'title' => $validated['title'],
            'venue' => $validated['venue'],
            'event_date' => $eventDate,
            'registration_fee' => $feeCentavos,
            'description' => $validated['description'] ?? null,
            'is_active' => (bool) $validated['is_active'],
            'created_by' => Auth::id(),
        ]);

        // 5) Reset + feedback
        $this->reset(['title', 'venue', 'event_date', 'registration_fee', 'description', 'is_active']);
        $this->is_active = true;
        session()->flash('status', 'Event created successfully.');

        // Optional redirect:
        // $this->redirectRoute('events.index');
    }

    public function resetForm(): void
    {
        $this->reset(['title', 'venue', 'event_date', 'registration_fee', 'description', 'is_active']);
        $this->is_active = true;
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function render()
    {
        return view('livewire.create-events');
    }
}