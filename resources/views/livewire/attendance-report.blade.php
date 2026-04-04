<div class="p-4 sm:p-6 lg:p-8">
    <div class="mx-auto max-w-7xl rounded-[1.75rem] border border-white/10 bg-zinc-900/80 shadow-[0_20px_50px_rgba(0,0,0,0.30)] backdrop-blur">
        <section class="overflow-hidden rounded-[1.75rem]">
            <div class="border-b border-white/10 px-4 py-5 sm:px-6">
                <div class="flex flex-col gap-3 lg:flex-row lg:items-end lg:justify-between">
                    <div>
                        <h2 class="text-lg font-semibold text-white">
                           Admin Attendance | Report
                        </h2>
                        <p class="mt-1 text-sm text-zinc-400">
                            View all alumni attendees, RSVP responses, and payment records per event.
                        </p>
                    </div>

                    <div class="rounded-2xl border border-white/10 bg-zinc-950/70 px-4 py-2 text-xs uppercase tracking-[0.18em] text-zinc-500">
                        All Batches
                    </div>
                </div>
            </div>

            @if ($selectedEvent !== 'all')
                <div class="grid grid-cols-2 gap-3 border-b border-white/10 px-4 py-4 sm:grid-cols-4 xl:grid-cols-7 sm:px-6">
                    <div class="rounded-2xl border border-emerald-500/15 bg-emerald-500/5 px-4 py-3">
                        <p class="text-[11px] uppercase tracking-[0.18em] text-emerald-300/70">Attending</p>
                        <p class="mt-1 text-xl font-semibold text-emerald-300">{{ $attendingParticipantsCount }}</p>
                    </div>

                    <div class="rounded-2xl border border-amber-500/15 bg-amber-500/5 px-4 py-3">
                        <p class="text-[11px] uppercase tracking-[0.18em] text-amber-300/70">Maybe</p>
                        <p class="mt-1 text-xl font-semibold text-amber-300">{{ $maybeParticipantsCount }}</p>
                    </div>

                    <div class="rounded-2xl border border-rose-500/15 bg-rose-500/5 px-4 py-3">
                        <p class="text-[11px] uppercase tracking-[0.18em] text-rose-300/70">Not Attending</p>
                        <p class="mt-1 text-xl font-semibold text-rose-300">{{ $notAttendingParticipantsCount }}</p>
                    </div>

                    <div class="rounded-2xl border border-zinc-500/15 bg-zinc-500/5 px-4 py-3">
                        <p class="text-[11px] uppercase tracking-[0.18em] text-zinc-300/70">No Response</p>
                        <p class="mt-1 text-xl font-semibold text-zinc-200">{{ $noResponseCount }}</p>
                    </div>

                    <div class="rounded-2xl border border-sky-500/15 bg-sky-500/5 px-4 py-3">
                        <p class="text-[11px] uppercase tracking-[0.18em] text-sky-300/70">Paid</p>
                        <p class="mt-1 text-xl font-semibold text-sky-300">{{ $paidParticipantsCount }}</p>
                    </div>

                    <div class="rounded-2xl border border-amber-500/15 bg-amber-500/5 px-4 py-3">
                        <p class="text-[11px] uppercase tracking-[0.18em] text-amber-300/70">Unpaid</p>
                        <p class="mt-1 text-xl font-semibold text-amber-300">{{ $unpaidParticipantsCount }}</p>
                    </div>

                    <div class="rounded-2xl border border-violet-500/15 bg-violet-500/5 px-4 py-3">
                        <p class="text-[11px] uppercase tracking-[0.18em] text-violet-300/70">Waived</p>
                        <p class="mt-1 text-xl font-semibold text-violet-300">{{ $waivedParticipantsCount }}</p>
                    </div>
                </div>
            @endif

            <div class="border-b border-white/10 px-4 py-4 sm:px-6">
                <div class="grid grid-cols-1 gap-4 xl:grid-cols-4">
                    <div>
                        <label class="mb-2 block text-sm font-medium text-zinc-300">Select Event</label>
                        <select
                            wire:model.live="selectedEvent"
                            class="w-full rounded-2xl border border-white/10 bg-zinc-950 px-4 py-3 text-sm text-zinc-100 outline-none transition focus:border-emerald-400 focus:ring-2 focus:ring-emerald-500/20"
                        >
                            <option value="all">Select an Event</option>
                            @foreach ($allEvents as $eventOption)
                                <option value="{{ $eventOption->id }}">
                                    {{ $eventOption->title }}
                                    @if ($eventOption->event_date)
                                        — {{ $eventOption->event_date->format('M d, Y') }}
                                    @endif
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium text-zinc-300">RSVP Status</label>
                        <select
                            wire:model.live="rsvpStatusFilter"
                            class="w-full rounded-2xl border border-white/10 bg-zinc-950 px-4 py-3 text-sm text-zinc-100 outline-none transition focus:border-emerald-400 focus:ring-2 focus:ring-emerald-500/20"
                        >
                            <option value="all">All Responses</option>
                            <option value="attending">Attending</option>
                            <option value="maybe">Maybe</option>
                            <option value="not_attending">Not Attending</option>
                            <option value="no_response">No Response Yet</option>
                        </select>
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium text-zinc-300">Payment Status</label>
                        <select
                            wire:model.live="paymentStatusFilter"
                            class="w-full rounded-2xl border border-white/10 bg-zinc-950 px-4 py-3 text-sm text-zinc-100 outline-none transition focus:border-emerald-400 focus:ring-2 focus:ring-emerald-500/20"
                        >
                            <option value="all">All Payment Status</option>
                            <option value="paid">Paid</option>
                            <option value="unpaid">Unpaid</option>
                            <option value="waived">Waived</option>
                        </select>
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium text-zinc-300">Search Alumni or Batch</label>
                        <input
                            type="text"
                            wire:model.live.debounce.300ms="search"
                            placeholder="Search by name or batch"
                            class="w-full rounded-2xl border border-white/10 bg-zinc-950 px-4 py-3 text-sm text-zinc-100 outline-none transition placeholder:text-zinc-500 focus:border-emerald-400 focus:ring-2 focus:ring-emerald-500/20"
                        >
                    </div>
                </div>

                <div class="mt-4 flex flex-col gap-3 sm:flex-row sm:justify-end">
                    <button
                        type="button"
                        wire:click="resetEventFilters"
                        class="inline-flex items-center justify-center rounded-2xl border border-white/10 bg-zinc-950 px-4 py-3 text-sm font-medium text-zinc-200 transition hover:bg-zinc-800"
                    >
                        Reset Filters
                    </button>

                    <button
                        type="button"
                        wire:click="downloadExcel"
                        @disabled($selectedEvent === 'all')
                        class="inline-flex items-center justify-center rounded-2xl bg-emerald-500 px-4 py-3 text-sm font-semibold text-zinc-950 transition hover:bg-emerald-400 disabled:cursor-not-allowed disabled:opacity-50"
                    >
                        Download Excel
                    </button>
                </div>
            </div>

            @if (session()->has('success'))
                <div class="border-b border-emerald-500/20 bg-emerald-500/10 px-4 py-3 text-sm text-emerald-300 sm:px-6">
                    {{ session('success') }}
                </div>
            @endif

            <div class="hidden sm:block">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-[13px]">
    <thead class="border-b border-white/10 bg-zinc-950/80 text-zinc-400">
        <tr>
            <th class="px-3 py-2.5 font-medium">Batch</th>
            <th class="px-3 py-2.5 font-medium">Alumni Name</th>
            <th class="px-3 py-2.5 font-medium">RSVP</th>
            <th class="px-3 py-2.5 font-medium">Fee</th>
            <th class="px-3 py-2.5 font-medium">Payment</th>
            <th class="px-3 py-2.5 font-medium">Updated</th>
            <th class="px-3 py-2.5 font-medium">Action</th>
        </tr>
    </thead>

    <tbody class="divide-y divide-white/10">
        @if ($selectedEvent === 'all')
            <tr>
                <td colspan="7" class="px-4 py-10 text-center text-sm text-zinc-500">
                    Please select an event first to view all attendee records.
                </td>
            </tr>
        @else
            @forelse ($participants as $participant)
                @php
                    $fullName = trim(collect([
                        $participant->fname,
                        $participant->mname,
                        $participant->lname,
                    ])->filter()->implode(' '));

                    $rsvpStatus = $participant->rsvp_status ?? 'no_response';

                    $rsvpBadgeClasses = match($rsvpStatus) {
                        'attending' => 'border-emerald-500/20 bg-emerald-500/10 text-emerald-300',
                        'maybe' => 'border-amber-500/20 bg-amber-500/10 text-amber-300',
                        'not_attending' => 'border-rose-500/20 bg-rose-500/10 text-rose-300',
                        default => 'border-zinc-500/20 bg-zinc-500/10 text-zinc-300',
                    };

                    $rsvpLabel = match($rsvpStatus) {
                        'attending' => 'Attending',
                        'maybe' => 'Maybe',
                        'not_attending' => 'Not Attending',
                        default => 'No Response',
                    };

                    $paymentStatus = $participant->payment_status ?? 'unpaid';

                    $paymentBadgeClasses = match($paymentStatus) {
                        'paid' => 'border-sky-500/20 bg-sky-500/10 text-sky-300',
                        'waived' => 'border-violet-500/20 bg-violet-500/10 text-violet-300',
                        default => 'border-amber-500/20 bg-amber-500/10 text-amber-300',
                    };
                @endphp

                <tr class="transition hover:bg-emerald-500/[0.04]">
                    <td class="px-3 py-2.5 text-zinc-300 whitespace-nowrap">
                        {{ $participant->batch_label ?: '—' }}
                    </td>

                    <td class="px-3 py-2.5 text-zinc-100">
                        {{ $fullName ?: '—' }}
                    </td>

                    <td class="px-3 py-2.5">
                        <span class="inline-flex rounded-full border px-2 py-0.5 text-[10px] font-semibold uppercase tracking-[0.1em] {{ $rsvpBadgeClasses }}">
                            {{ $rsvpLabel }}
                        </span>
                    </td>

                    <td class="px-3 py-2.5 text-zinc-300 whitespace-nowrap">
                        @if(($selectedEventModel?->registration_fee ?? 0) > 0)
                            ₱{{ number_format(($selectedEventModel?->registration_fee ?? 0) / 100, 2) }}
                        @else
                            Free
                        @endif
                    </td>

                    <td class="px-3 py-2.5">
                        <span class="inline-flex rounded-full border px-2 py-0.5 text-[10px] font-semibold uppercase tracking-[0.1em] {{ $paymentBadgeClasses }}">
                            {{ str($paymentStatus)->headline() }}
                        </span>
                    </td>

                    <td class="px-3 py-2.5 text-zinc-300 whitespace-nowrap">
                        {{ $participant->payment_updated_at ? \Carbon\Carbon::parse($participant->payment_updated_at)->format('M d, Y h:i A') : '—' }}
                    </td>

                    <td class="px-3 py-2.5">
                        <select
                            wire:change="updatePaymentStatus({{ $participant->id }}, $event.target.value)"
                            class="rounded-lg border border-white/10 bg-zinc-950 px-2.5 py-1.5 text-[12px] text-zinc-200 outline-none transition focus:border-emerald-400 focus:ring-1 focus:ring-emerald-500/20"
                        >
                            <option value="unpaid" @selected($paymentStatus === 'unpaid')>Unpaid</option>
                            <option value="paid" @selected($paymentStatus === 'paid')>Paid</option>
                            <option value="waived" @selected($paymentStatus === 'waived')>Waived</option>
                        </select>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="px-4 py-10 text-center text-sm text-zinc-500">
                        No attendee records found for the current filters.
                    </td>
                </tr>
            @endforelse
        @endif
    </tbody>
</table>
                </div>

                @if ($selectedEvent !== 'all' && method_exists($participants, 'links'))
                    <div class="flex flex-col gap-3 border-t border-white/10 px-6 py-4 text-sm sm:flex-row sm:items-center sm:justify-between">
                        <p class="text-zinc-400">
                            Showing {{ $participants->firstItem() ?? 0 }}–{{ $participants->lastItem() ?? 0 }} of {{ $participants->total() }}
                        </p>

                        <div class="[&>*]:!shadow-none">
                            {{ $participants->links() }}
                        </div>
                    </div>
                @endif
            </div>
        </section>
    </div>
</div>