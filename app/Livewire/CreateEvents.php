<?php

namespace App\Livewire;

use App\Models\Event;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Title;

#[Title('Add Event')]
class CreateEvents extends Component
{
    use WithFileUploads;

    public string $title = '';
    public string $venue = '';
    public string $dress_code = '';
    public string $event_date = '';
    public ?int $registration_fee = 0;
    public ?string $description = null;
    public bool $is_active = true;

    public $banner = null;

    protected function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'venue' => ['required', 'string', 'max:255'],
            'dress_code' => ['required', 'string', 'max:255'],
            'event_date' => ['required', 'date'],
            'registration_fee' => ['nullable', 'integer', 'min:0'],
            'description' => ['required', 'string', 'max:5000'],
            'is_active' => ['boolean'],
            'banner' => ['nullable', 'image', 'max:6048'], // 2MB
        ];
    }

    protected array $messages = [
        'title.required' => 'The event title is required.',
        'venue.required' => 'The venue is required.',
        'dress_code.required' => 'The dress code is required.',
        'event_date.required' => 'The event date and time is required.',
        'event_date.date' => 'Please provide a valid event date and time.',
        'registration_fee.integer' => 'The registration fee must be a whole number.',
        'registration_fee.min' => 'The registration fee cannot be negative.',
        'description.required' => 'The description is required.',
        'banner.image' => 'The uploaded file must be an image.',
        'banner.max' => 'The banner image must not exceed 6MB.',
    ];

    public function updatedBanner(): void
    {
        $this->validateOnly('banner');
    }

    public function save(): void
    {
        $validated = $this->validate();

        $feeCentavos = ((int) ($validated['registration_fee'] ?? 0)) * 100;
        $eventDate = Carbon::parse($validated['event_date']);

        $bannerPath = null;

        if ($this->banner) {
            $bannerPath = $this->banner->storePublicly('event-banners', 's3');
        }

        Event::create([
            'title' => trim($validated['title']),
            'venue' => trim($validated['venue']),
            'dress_code' => trim($validated['dress_code']),
            'event_date' => $eventDate,
            'registration_fee' => $feeCentavos,
            'description' => trim($validated['description']),
            'is_active' => (bool) $validated['is_active'],
            'banner_image' => $bannerPath,
            'created_by' => Auth::id(),
        ]);

        $this->resetForm();

        session()->flash('status', 'Event created successfully.');
    }

    public function resetForm(): void
    {
        $this->reset([
            'title',
            'venue',
            'dress_code',
            'event_date',
            'registration_fee',
            'description',
            'is_active',
            'banner',
        ]);

        $this->registration_fee = 0;
        $this->is_active = true;

        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function render()
    {
        return view('livewire.create-events');
    }
}