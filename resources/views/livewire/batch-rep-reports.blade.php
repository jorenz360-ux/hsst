<div class="p-4 sm:p-6">
    <section class="overflow-hidden rounded-2xl border border-white/10 bg-zinc-900/75 shadow-[0_18px_40px_rgba(0,0,0,0.28)] backdrop-blur">
        <div class="border-b border-white/10 px-4 py-4 sm:px-5">
            <div class="flex flex-col gap-2 lg:flex-row lg:items-end lg:justify-between">
                <div>
                    <h2 class="text-base font-semibold text-white">
                        Batch Participants Workspace
                    </h2>
                    <p class="mt-1 text-xs text-zinc-400 sm:text-sm">
                        Select an event, narrow the participant list, and update payment status for your batch.
                    </p>
                </div>

                <div class="rounded-xl border border-white/10 bg-zinc-950/70 px-3 py-1.5 text-[10px] uppercase tracking-[0.16em] text-zinc-500 sm:text-[11px]">
                    Assigned Batch Only
                </div>
            </div>
        </div>

        {{-- Filters --}}
        <div class="border-b border-white/10 px-4 py-4 sm:px-5">
            <div class="grid grid-cols-1 gap-3 xl:grid-cols-4">
                <div>
                    <label class="mb-1.5 block text-xs font-medium text-zinc-300">
                        Select Event
                    </label>
                    <select
                        wire:model.live="selectedEvent"
                        class="w-full rounded-xl border border-white/10 bg-zinc-950 px-3 py-2.5 text-sm text-zinc-100 outline-none transition focus:border-emerald-400 focus:ring-1 focus:ring-emerald-500/20"
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
                    <label class="mb-1.5 block text-xs font-medium text-zinc-300">
                        RSVP Status
                    </label>
                    <select
                        wire:model.live="rsvpStatusFilter"
                        class="w-full rounded-xl border border-white/10 bg-zinc-950 px-3 py-2.5 text-sm text-zinc-100 outline-none transition focus:border-emerald-400 focus:ring-1 focus:ring-emerald-500/20"
                    >
                        <option value="all">All Responses</option>
                        <option value="attending">Attending</option>
                        <option value="maybe">Maybe</option>
                        <option value="not_attending">Not Attending</option>
                        <option value="no_response">No Response Yet</option>
                    </select>
                </div>

                <div>
                    <label class="mb-1.5 block text-xs font-medium text-zinc-300">
                        Payment Status
                    </label>
                    <select
                        wire:model.live="paymentStatusFilter"
                        class="w-full rounded-xl border border-white/10 bg-zinc-950 px-3 py-2.5 text-sm text-zinc-100 outline-none transition focus:border-emerald-400 focus:ring-1 focus:ring-emerald-500/20"
                    >
                        <option value="all">All Payment Status</option>
                        <option value="paid">Paid</option>
                        <option value="unpaid">Unpaid</option>
                        <option value="waived">Waived</option>
                    </select>
                </div>

                <div>
                    <label class="mb-1.5 block text-xs font-medium text-zinc-300">
                        Search Alumni
                    </label>
                    <input
                        type="text"
                        wire:model.live.debounce.300ms="search"
                        placeholder="Search by first, middle, or last name"
                        class="w-full rounded-xl border border-white/10 bg-zinc-950 px-3 py-2.5 text-sm text-zinc-100 outline-none transition placeholder:text-zinc-500 focus:border-emerald-400 focus:ring-1 focus:ring-emerald-500/20"
                    >
                </div>
            </div>

            <div class="mt-3 flex flex-col gap-2 sm:flex-row sm:justify-end">
                <button
                    type="button"
                    wire:click="resetEventFilters"
                    class="inline-flex items-center justify-center rounded-xl border border-white/10 bg-zinc-950 px-3.5 py-2.5 text-sm font-medium text-zinc-200 transition hover:bg-zinc-800"
                >
                    Reset Filters
                </button>

                <button
                    type="button"
                    wire:click="downloadExcel"
                    @disabled($selectedEvent === 'all')
                    class="inline-flex items-center justify-center rounded-xl bg-emerald-500 px-3.5 py-2.5 text-sm font-semibold text-zinc-950 transition hover:bg-emerald-400 disabled:cursor-not-allowed disabled:opacity-50"
                >
                    Download Excel
                </button>
            </div>
        </div>

        {{-- Desktop table --}}
        <div class="hidden sm:block">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-[13px]">
                    <thead class="border-b border-white/10 bg-zinc-950/80 text-zinc-400">
                        <tr>
                            <th class="px-3 py-2.5 font-medium">Name</th>
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
                                <td colspan="6" class="px-4 py-10 text-center text-sm text-zinc-500">
                                    Please select an event first to view batch participant records.
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
                                    <td colspan="6" class="px-4 py-10 text-center text-sm text-zinc-500">
                                        No participant records found for the current filters.
                                    </td>
                                </tr>
                            @endforelse
                        @endif
                    </tbody>
                </table>
            </div>

            @if ($selectedEvent !== 'all' && method_exists($participants, 'links'))
                <div class="flex flex-col gap-2 border-t border-white/10 px-4 py-3 text-sm sm:flex-row sm:items-center sm:justify-between">
                    <p class="text-xs text-zinc-400 sm:text-sm">
                        Showing {{ $participants->firstItem() ?? 0 }}–{{ $participants->lastItem() ?? 0 }} of {{ $participants->total() }}
                    </p>

                    <div class="[&>*]:!shadow-none">
                        {{ $participants->links() }}
                    </div>
                </div>
            @endif
        </div>

        {{-- Mobile list --}}
        <div class="sm:hidden">
            @if ($selectedEvent === 'all')
                <div class="px-4 py-8 text-center text-sm text-zinc-500">
                    Please select an event first to view batch participant records.
                </div>
            @else
                <div class="divide-y divide-white/10">
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

                        <div class="px-4 py-3">
                            <div class="flex items-start justify-between gap-2">
                                <div class="min-w-0">
                                    <p class="truncate text-sm font-semibold text-white">
                                        {{ $fullName ?: '—' }}
                                    </p>

                                    <div class="mt-1.5 flex flex-wrap gap-1.5">
                                        <span class="inline-flex rounded-full border px-2 py-0.5 text-[10px] font-semibold uppercase tracking-[0.08em] {{ $rsvpBadgeClasses }}">
                                            {{ $rsvpLabel }}
                                        </span>

                                        <span class="inline-flex rounded-full border px-2 py-0.5 text-[10px] font-semibold uppercase tracking-[0.08em] {{ $paymentBadgeClasses }}">
                                            {{ str($paymentStatus)->headline() }}
                                        </span>
                                    </div>

                                    <div class="mt-1.5 text-[11px] text-zinc-400">
                                        <span>
                                            @if(($selectedEventModel?->registration_fee ?? 0) > 0)
                                                Fee: ₱{{ number_format(($selectedEventModel?->registration_fee ?? 0) / 100, 2) }}
                                            @else
                                                Free Event
                                            @endif
                                        </span>
                                        <span class="mx-1">•</span>
                                        <span>
                                            {{ $participant->payment_updated_at ? \Carbon\Carbon::parse($participant->payment_updated_at)->format('M d, Y h:i A') : 'No update yet' }}
                                        </span>
                                    </div>
                                </div>

                                <div class="shrink-0">
                                    <select
                                        wire:change="updatePaymentStatus({{ $participant->id }}, $event.target.value)"
                                        class="rounded-lg border border-white/10 bg-zinc-950 px-2 py-1.5 text-[11px] text-zinc-200 outline-none transition focus:border-emerald-400 focus:ring-1 focus:ring-emerald-500/20"
                                    >
                                        <option value="unpaid" @selected($paymentStatus === 'unpaid')>Unpaid</option>
                                        <option value="paid" @selected($paymentStatus === 'paid')>Paid</option>
                                        <option value="waived" @selected($paymentStatus === 'waived')>Waived</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="px-4 py-8 text-center text-sm text-zinc-500">
                            No participant records found for the current filters.
                        </div>
                    @endforelse
                </div>

                @if (method_exists($participants, 'links'))
                    <div class="border-t border-white/10 px-4 py-3">
                        {{ $participants->links() }}
                    </div>
                @endif
            @endif
        </div>
    </section>
</div>