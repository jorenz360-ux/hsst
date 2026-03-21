<?php

namespace App\Livewire;

use App\Models\Event;
use App\Models\Payment;
use Illuminate\Database\Eloquent\Builder;
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

    protected $queryString = [
        'tab' => ['except' => 'events'],
        'search' => ['except' => ''],
        'status' => ['except' => 'upcoming'],
        'active' => ['except' => 'all'],
        'page' => ['except' => 1],
    ];

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

    public function render()
    {
        $now = now();

        $events = Event::query()
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
            })
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

            // Base registration payment only
            if (is_null($payment->event_registration_item_id)) {
                $payment->registration->update([
                    'status' => 'paid',
                    // 'fee_paid' => 1,
                ]);
            }
        });

        session()->flash('status', is_null($payment->event_registration_item_id)
            ? 'Registration payment verified.'
            : 'Registration item payment verified.');
        session()->flash('status_id', now()->timestamp . '-' . uniqid());
    }

    public function rejectPayment(int $paymentId): void
    {
        abort_unless(auth()->user()->can('edit.event'), 403);

        $payment = Payment::query()
            ->findOrFail($paymentId);

        $payment->update([
            'status' => 'rejected',
            'verified_by' => auth()->id(),
            'verified_at' => now(),
        ]);

        session()->flash('status', 'Payment rejected.');
        session()->flash('status_id', now()->timestamp . '-' . uniqid());
    }
}