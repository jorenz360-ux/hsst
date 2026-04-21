<?php

namespace App\Livewire;

use App\Models\Event;
use App\Models\EventRegistration;
use App\Models\EventRsvp;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Event Participation')]
class EventParticipationPage extends Component
{
    public Event $event;
    public ?EventRegistration $registration = null;
    public ?EventRsvp $rsvp = null;

    public ?string $rsvpStatus = null;
    public ?int $selectedBatchId = null;

    public int $attendingCount = 0;
    public int $maybeCount = 0;
    public int $notAttendingCount = 0;

    public Collection $alumniEducations;

    public function mount(Event $event): void
    {
        $alumniId = Auth::user()?->alumni_id;

        abort_if(! $alumniId, 403, 'Your alumni profile is required before you can continue.');
        abort_if(! $event->is_active, 403, 'This event is currently unavailable.');

        $this->alumniEducations = collect();

        $this->event = $event->load([
            'schedules' => fn ($query) => $query
                ->orderBy('sort_order')
                ->orderBy('schedule_time'),
        ]);

        $this->registration = EventRegistration::firstOrCreate(
            [
                'event_id' => $this->event->id,
                'alumni_id' => $alumniId,
            ],
            [
                'status' => 'unpaid',
                'fee_paid' => 0,
            ]
        );

        $this->alumniEducations = Auth::user()
            ->alumni
            ->educations()
            ->with('batch')
            ->get();

        $this->loadRsvpState();
        $this->loadAttendanceCounts();
    }

    protected function loadRsvpState(): void
    {
        $alumniId = Auth::user()?->alumni_id;

        $this->rsvp = EventRsvp::query()
            ->where('event_id', $this->event->id)
            ->where('alumni_id', $alumniId)
            ->first();

        $this->rsvpStatus = $this->rsvp?->status;

        if ($this->rsvp?->batch_id) {
            $this->selectedBatchId = $this->rsvp->batch_id;
        } elseif ($this->alumniEducations->count() === 1) {
            $this->selectedBatchId = $this->alumniEducations->first()->batch_id;
        }
    }

    protected function loadAttendanceCounts(): void
    {
        $this->attendingCount = EventRsvp::query()
            ->where('event_id', $this->event->id)
            ->where('status', EventRsvp::STATUS_ATTENDING)
            ->count();

        $this->maybeCount = EventRsvp::query()
            ->where('event_id', $this->event->id)
            ->where('status', EventRsvp::STATUS_MAYBE)
            ->count();

        $this->notAttendingCount = EventRsvp::query()
            ->where('event_id', $this->event->id)
            ->where('status', EventRsvp::STATUS_NOT_ATTENDING)
            ->count();
    }

    public function setRsvp(string $status): void
    {
        $allowedStatuses = [
            EventRsvp::STATUS_ATTENDING,
            EventRsvp::STATUS_MAYBE,
            EventRsvp::STATUS_NOT_ATTENDING,
        ];

        if (! in_array($status, $allowedStatuses, true)) {
            session()->put('error', 'Invalid attendance response.');
            return;
        }

        if ($this->event->event_date?->isPast()) {
            session()->put('error', 'This event is already closed.');
            return;
        }

        if ($this->alumniEducations->count() > 1 && ! $this->selectedBatchId) {
            session()->put('error', 'Please select which batch you are attending as.');
            return;
        }

        if ($this->alumniEducations->count() === 1) {
            $this->selectedBatchId = $this->alumniEducations->first()->batch_id;
        }

        $alumniId = Auth::user()?->alumni_id;

        $this->rsvp = EventRsvp::updateOrCreate(
            [
                'event_id' => $this->event->id,
                'alumni_id' => $alumniId,
            ],
            [
                'status' => $status,
                'batch_id' => $this->selectedBatchId,
                'guest_count' => 0,
                'remarks' => null,
            ]
        );

        $this->rsvpStatus = $this->rsvp->status;

        $this->loadAttendanceCounts();

        $message = match ($status) {
            EventRsvp::STATUS_ATTENDING => 'Your RSVP has been marked as Attending.',
            EventRsvp::STATUS_MAYBE => 'Your RSVP has been marked as Maybe.',
            EventRsvp::STATUS_NOT_ATTENDING => 'Your RSVP has been marked as Not Attending.',
            default => 'Your RSVP has been updated.',
        };

        session()->flash('success', $message);
    }

    public function saveRsvp(): void
    {
        if (! in_array($this->rsvpStatus, [
            EventRsvp::STATUS_ATTENDING,
            EventRsvp::STATUS_MAYBE,
            EventRsvp::STATUS_NOT_ATTENDING,
        ], true)) {
            session()->put('error', 'Please select your attendance response first.');
            return;
        }

        $this->setRsvp($this->rsvpStatus);
    }

    public function render()
    {
        return view('livewire.event-participation-page');
    }
}
