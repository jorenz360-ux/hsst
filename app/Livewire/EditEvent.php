<?php

namespace App\Livewire;

use App\Models\Event;
use Illuminate\Support\Carbon;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Edit Event')]
class EditEvent extends Component
{
    public array $itemRows = [];
    public Event $event;

    public string $title = '';
    public string $dress_code = '';
    public string $venue = '';
    public string $event_date = '';
    public int $registration_fee = 0;
    public ?string $description = null;
    public bool $is_active = true;

    public array $scheduleRows = [];

    public function mount(Event $event): void
    {
        $this->event = $event;

        $this->title = $event->title;
        $this->venue = $event->venue;
        $this->dress_code = $event->dress_code ?? '';
        $this->event_date = $event->event_date->format('Y-m-d\TH:i');
        $this->registration_fee = (int) ($event->registration_fee / 100);
        $this->description = $event->description;
        $this->is_active = (bool) $event->is_active;

        $this->scheduleRows = $event->schedules()
            ->orderBy('sort_order')
            ->orderBy('schedule_time')
            ->get()
            ->map(fn ($schedule) => [
                'id' => $schedule->id,
                'schedule_time' => $schedule->schedule_time
                    ? Carbon::parse($schedule->schedule_time)->format('H:i')
                    : '',
                'title' => $schedule->title,
                'dress_code' => $schedule->dress_code,
                'description' => $schedule->description,
                'sort_order' => $schedule->sort_order,
            ])
            ->toArray();
        $this->itemRows = $event->registrationItems()
            ->get()
            ->map(fn ($item) => [
                'id' => $item->id,
                'name' => $item->name,
                'price' => $item->price / 100,
                'event_schedule_id' => $item->event_schedule_id,
            ])
            ->toArray();
    }

        public function addItemRow()
    {
        $this->itemRows[] = [
            'id' => null,
            'name' => '',
            'price' => 0,
            'event_schedule_id' => null,
        ];
    }

    public function removeItemRow($index)
    {
        unset($this->itemRows[$index]);
        $this->itemRows = array_values($this->itemRows);
    }
    public function saveItems()
    {
        $keptIds = [];

        foreach ($this->itemRows as $row) {
            $item = $this->event->registrationItems()->updateOrCreate(
                ['id' => $row['id'] ?? null],
                [
                    'name' => $row['name'],
                    'price' => $row['price'] * 100,
                    'event_schedule_id' => $row['event_schedule_id'] ?: null,
                ]
            );

            $keptIds[] = $item->id;
        }

        $this->event->registrationItems()
            ->whereNotIn('id', $keptIds)
            ->delete();

        session()->flash('status', 'Registration items saved.');
    }
    public function update(): void
    {
        $validated = $this->validate([
            'title' => ['required', 'string', 'max:255'],
            'dress_code' => ['required', 'string', 'max:150'],
            'venue' => ['required', 'string', 'max:255'],
            'event_date' => ['required', 'date'],
            'registration_fee' => ['required', 'integer', 'min:0'],
            'description' => ['nullable', 'string', 'max:5000'],
            'is_active' => ['boolean'],
        ]);

        $this->event->update([
            'title' => $validated['title'],
            'dress_code' => $validated['dress_code'],
            'venue' => $validated['venue'],
            'event_date' => Carbon::parse($validated['event_date']),
            'registration_fee' => ((int) $validated['registration_fee']) * 100,
            'description' => $validated['description'] ?? null,
            'is_active' => (bool) $validated['is_active'],
        ]);

        session()->flash('status', 'Event updated.');
    }

    public function addScheduleRow(): void
    {
        $this->scheduleRows[] = [
            'id' => null,
            'schedule_time' => '',
            'title' => '',
            'description' => '',
            'sort_order' => count($this->scheduleRows) + 1,
        ];
    }

    public function removeScheduleRow(int $index): void
    {
        unset($this->scheduleRows[$index]);
        $this->scheduleRows = array_values($this->scheduleRows);
    }

    public function saveSchedules(): void
    {
        $validated = $this->validate([
            'scheduleRows' => ['array'],
            'scheduleRows.*.id' => ['nullable', 'integer', 'exists:event_schedules,id'],
            'scheduleRows.*.schedule_time' => ['nullable', 'date_format:H:i'],
            'scheduleRows.*.title' => ['required', 'string', 'max:150'],
            'scheduleRows.*.description' => ['nullable', 'string'],
            'scheduleRows.*.sort_order' => ['nullable', 'integer', 'min:0'],
        ], [
            'scheduleRows.*.title.required' => 'Each schedule item must have a title.',
            'scheduleRows.*.schedule_time.date_format' => 'Schedule time must be in HH:MM format.',
        ]);
 
        $keptIds = [];

        foreach ($validated['scheduleRows'] as $index => $row) {
            $schedule = $this->event->schedules()->updateOrCreate(
                ['id' => $row['id'] ?? null],
                [
                    'schedule_time' => $row['schedule_time'] ?: null,
                    'title' => $row['title'],
                    'description' => $row['description'] ?: null,
                    'sort_order' => $row['sort_order'] ?? ($index + 1),
                ]
            );

            $keptIds[] = $schedule->id;
        }

        $this->event->schedules()
            ->whereNotIn('id', $keptIds)
            ->delete();

        $this->scheduleRows = $this->event->schedules()
            ->orderBy('sort_order')
            ->orderBy('schedule_time')
            ->get()
            ->map(fn ($schedule) => [
                'id' => $schedule->id,
                'schedule_time' => $schedule->schedule_time
                    ? Carbon::parse($schedule->schedule_time)->format('H:i')
                    : '',
                'title' => $schedule->title,
                'description' => $schedule->description,
                'sort_order' => $schedule->sort_order,
            ])
            ->toArray();

        session()->flash('status', 'Event schedule saved successfully.');
    }

    public function render()
    {
        return view('livewire.edit-event');
    }
}