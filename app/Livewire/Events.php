<?php

namespace App\Livewire;

use App\Models\Event;
use App\Models\Payment;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('Events')]
class Events extends Component
{
    use WithPagination;

    public string $tab = 'events';

    public string $search = '';
    public string $status = 'upcoming'; // upcoming|past|all
    public string $active = 'all';      // all|active|inactive
    public int $perPage = 10;

    public string $paymentSearch = '';
    public string $paymentType = 'all'; // all|registration|item
    public int $paymentPerPage = 10;

    public string $calendarMonth;
    public ?string $selectedDate = null;

    protected $queryString = [
        'tab' => ['except' => 'events'],
        'search' => ['except' => ''],
        'status' => ['except' => 'upcoming'],
        'active' => ['except' => 'all'],
        'page' => ['except' => 1],
        'calendarMonth' => ['except' => ''],
        'selectedDate' => ['except' => null],
    ];

    public function mount(): void
    {
        $this->calendarMonth = now()->startOfMonth()->format('Y-m');
        $this->selectedDate ??= now()->toDateString();
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingStatus(): void
    {
        $this->resetPage();
    }

    public function updatingActive(): void
    {
        $this->resetPage();
    }

    public function updatingPerPage(): void
    {
        $this->resetPage();
    }

    public function updatingPaymentSearch(): void
    {
        $this->resetPage(pageName: 'paymentsPage');
    }

    public function updatingPaymentType(): void
    {
        $this->resetPage(pageName: 'paymentsPage');
    }

    public function updatingPaymentPerPage(): void
    {
        $this->resetPage(pageName: 'paymentsPage');
    }

    public function previousMonth(): void
    {
        $this->calendarMonth = Carbon::createFromFormat('Y-m', $this->calendarMonth)
            ->subMonth()
            ->format('Y-m');
    }

    public function nextMonth(): void
    {
        $this->calendarMonth = Carbon::createFromFormat('Y-m', $this->calendarMonth)
            ->addMonth()
            ->format('Y-m');
    }

    public function goToToday(): void
    {
        $this->calendarMonth = now()->startOfMonth()->format('Y-m');
        $this->selectedDate = now()->toDateString();
    }

    public function selectDate(string $date): void
    {
        $this->selectedDate = $date;
    }

    public function render()
    {
        $now = now();

        $baseEventsQuery = Event::query()
            ->select([
                'id',
                'title',
                'venue',
                'event_date',
                'registration_fee',
                'is_active',
                'created_by',
                'created_at',
            ])
            ->with(['creator:id,username'])
            ->when($this->search !== '', function (Builder $q) {
                $term = '%' . $this->search . '%';

                $q->where(function (Builder $qq) use ($term) {
                    $qq->where('title', 'like', $term)
                        ->orWhere('venue', 'like', $term);
                });
            })
            ->when($this->active !== 'all', fn (Builder $q) =>
                $q->where('is_active', $this->active === 'active')
            )
            ->when($this->status !== 'all', function (Builder $q) use ($now) {
                if ($this->status === 'upcoming') {
                    $q->where('event_date', '>=', $now);
                } elseif ($this->status === 'past') {
                    $q->where('event_date', '<', $now);
                }
            });

        $events = (clone $baseEventsQuery)
            ->orderBy('event_date', 'asc')
            ->paginate($this->perPage);

        $events->getCollection()->transform(fn ($e) => [
            'id' => $e->id,
            'title' => $e->title,
            'venue' => $e->venue,
            'event_date' => $e->event_date,
            'fee_pesos' => number_format(((int) $e->registration_fee) / 100, 2),
            'is_active' => (bool) $e->is_active,
            'creator' => $e->creator?->username,
        ]);

        $calendarStart = Carbon::createFromFormat('Y-m', $this->calendarMonth)->startOfMonth();
        $calendarEnd = $calendarStart->copy()->endOfMonth();

        $calendarEvents = (clone $baseEventsQuery)
            ->whereBetween('event_date', [
                $calendarStart->copy()->startOfMonth(),
                $calendarEnd->copy()->endOfMonth(),
            ])
            ->orderBy('event_date', 'asc')
            ->get()
            ->map(fn ($e) => [
                'id' => $e->id,
                'title' => $e->title,
                'venue' => $e->venue,
                'event_date' => $e->event_date,
                'time' => $e->event_date?->format('h:i A'),
                'fee_pesos' => number_format(((int) $e->registration_fee) / 100, 2),
                'is_active' => (bool) $e->is_active,
                'creator' => $e->creator?->username,
                'date_key' => $e->event_date?->toDateString(),
            ]);

        $eventsByDate = $calendarEvents
            ->groupBy('date_key')
            ->map(fn (Collection $items) => $items->values());

        $monthGridStart = $calendarStart->copy()->startOfWeek(Carbon::SUNDAY);
        $monthGridEnd = $calendarEnd->copy()->endOfWeek(Carbon::SATURDAY);

        $calendarDays = collect();
        $cursor = $monthGridStart->copy();

        while ($cursor <= $monthGridEnd) {
            $dateKey = $cursor->toDateString();
            $dayEvents = $eventsByDate->get($dateKey, collect());

            $calendarDays->push([
                'date' => $dateKey,
                'day' => $cursor->day,
                'isCurrentMonth' => $cursor->month === $calendarStart->month,
                'isToday' => $cursor->isToday(),
                'isSelected' => $this->selectedDate === $dateKey,
                'events' => $dayEvents,
                'count' => $dayEvents->count(),
            ]);

            $cursor->addDay();
        }

        $selectedDayEvents = $eventsByDate->get(
            $this->selectedDate ?? now()->toDateString(),
            collect()
        );

        $statsQuery = Event::query();

        $stats = [
            'total' => (clone $statsQuery)->count(),
            'upcoming' => (clone $statsQuery)->where('event_date', '>=', $now)->count(),
            'past' => (clone $statsQuery)->where('event_date', '<', $now)->count(),
            'active' => (clone $statsQuery)->where('is_active', true)->count(),
        ];

        $pendingPayments = Payment::query()
            ->with([
                'registration:id,event_id,alumni_id,status',
                'registration.event:id,title',
                'registration.alumni:id,fname,lname',
                'registrationItem:id,name,event_id,event_schedule_id',
                'registrationItem.schedule:id,title,schedule_time',
            ])
            ->where('status', 'pending')
            ->when($this->paymentSearch !== '', function (Builder $q) {
                $term = '%' . $this->paymentSearch . '%';

                $q->where(function (Builder $qq) use ($term) {
                    $qq->where('reference_number', 'like', $term)
                        ->orWhere('remarks', 'like', $term)
                        ->orWhereHas('registration.alumni', function (Builder $alumniQ) use ($term) {
                            $alumniQ->where('fname', 'like', $term)
                                ->orWhere('lname', 'like', $term);
                        })
                        ->orWhereHas('registration.event', function (Builder $eventQ) use ($term) {
                            $eventQ->where('title', 'like', $term);
                        })
                        ->orWhereHas('registrationItem', function (Builder $itemQ) use ($term) {
                            $itemQ->where('name', 'like', $term);
                        });
                });
            })
            ->when($this->paymentType !== 'all', function (Builder $q) {
                if ($this->paymentType === 'registration') {
                    $q->whereNull('event_registration_item_id');
                }

                if ($this->paymentType === 'item') {
                    $q->whereNotNull('event_registration_item_id');
                }
            })
            ->latest('id')
            ->paginate($this->paymentPerPage, ['*'], 'paymentsPage');

        return view('livewire.events', [
            'events' => $events,
            'pendingPayments' => $pendingPayments,
            'calendarDays' => $calendarDays,
            'selectedDayEvents' => $selectedDayEvents,
            'calendarLabel' => $calendarStart->format('F Y'),
            'selectedDateLabel' => Carbon::parse($this->selectedDate ?? now())->format('F d, Y'),
            'stats' => $stats,
        ]);
    }

    public function toggleActive(int $eventId): void
    {
        abort_unless(auth()->user()->can('edit.event'), 403);

        Event::whereKey($eventId)->update([
            'is_active' => DB::raw('NOT is_active'),
        ]);

        $enabled = Event::whereKey($eventId)->value('is_active');

        session()->flash('status', $enabled ? 'Event enabled.' : 'Event disabled.');
        session()->flash('status_id', now()->timestamp . '-' . uniqid());
    }

    public function approvePayment(int $paymentId): void
    {
        abort_unless(auth()->user()->can('edit.event'), 403);

        $payment = Payment::query()
            ->with(['registration', 'registrationItem'])
            ->findOrFail($paymentId);

        DB::transaction(function () use ($payment) {
            $payment->update([
                'status' => 'verified',
                'verified_by' => auth()->id(),
                'verified_at' => now(),
            ]);

            if (is_null($payment->event_registration_item_id) && $payment->registration) {
                $payment->registration->update([
                    'status' => 'paid',
                ]);
            }
        });

        session()->flash(
            'status',
            is_null($payment->event_registration_item_id)
                ? 'Registration payment verified.'
                : 'Registration item payment verified.'
        );
        session()->flash('status_id', now()->timestamp . '-' . uniqid());
    }

    public function rejectPayment(int $paymentId): void
    {
        abort_unless(auth()->user()->can('edit.event'), 403);

        $payment = Payment::query()->findOrFail($paymentId);

        $payment->update([
            'status' => 'rejected',
            'verified_by' => auth()->id(),
            'verified_at' => now(),
        ]);

        session()->flash('status', 'Payment rejected.');
        session()->flash('status_id', now()->timestamp . '-' . uniqid());
    }
}