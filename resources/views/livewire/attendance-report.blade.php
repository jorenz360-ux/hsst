<div class="p-4 sm:p-6 lg:p-8">
    <div class="mx-auto max-w-7xl rounded-[1.75rem] border border-gray-200 bg-white shadow-[0_4px_24px_rgba(0,0,0,0.07)]">
        <section class="overflow-hidden rounded-[1.75rem]">
            <div class="border-b border-gray-200 px-4 py-5 sm:px-6">
                <div class="flex flex-col gap-3 lg:flex-row lg:items-end lg:justify-between">
                    <div>
                        <h2 class="text-lg font-semibold text-gray-900">
                           Admin Attendance | Report
                        </h2>
                        <p class="mt-1 text-sm text-gray-500">
                            View all alumni attendees, RSVP responses, and payment records per event.
                        </p>
                    </div>

                    <div class="rounded-2xl border border-gray-200 bg-gray-100 px-4 py-2 text-xs uppercase tracking-[0.18em] text-gray-500">
                        All Batches
                    </div>
                </div>
            </div>

            @if ($selectedEvent !== 'all')
                <div class="grid grid-cols-2 gap-3 border-b border-gray-200 px-4 py-4 sm:grid-cols-4 sm:px-6">
                    {{-- RSVP Stats --}}
                    <div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3">
                        <p class="text-[11px] uppercase tracking-[0.18em] text-emerald-600">Attending</p>
                        <p class="mt-1 text-xl font-semibold text-emerald-700">{{ $attendingParticipantsCount }}</p>
                    </div>

                    <div class="rounded-2xl border border-amber-200 bg-amber-50 px-4 py-3">
                        <p class="text-[11px] uppercase tracking-[0.18em] text-amber-600">Maybe</p>
                        <p class="mt-1 text-xl font-semibold text-amber-700">{{ $maybeParticipantsCount }}</p>
                    </div>

                    <div class="rounded-2xl border border-rose-200 bg-rose-50 px-4 py-3">
                        <p class="text-[11px] uppercase tracking-[0.18em] text-rose-600">Not Attending</p>
                        <p class="mt-1 text-xl font-semibold text-rose-700">{{ $notAttendingParticipantsCount }}</p>
                    </div>

                    <div class="rounded-2xl border border-gray-200 bg-gray-100 px-4 py-3">
                        <p class="text-[11px] uppercase tracking-[0.18em] text-gray-500">No Response</p>
                        <p class="mt-1 text-xl font-semibold text-gray-700">{{ $noResponseCount }}</p>
                    </div>

                    {{-- Payment Stats --}}
                    <div class="rounded-2xl border border-sky-200 bg-sky-50 px-4 py-3">
                        <p class="text-[11px] uppercase tracking-[0.18em] text-sky-600">Paid</p>
                        <p class="mt-1 text-xl font-semibold text-sky-700">{{ $paidParticipantsCount }}</p>
                    </div>

                    <div class="rounded-2xl border border-gray-200 bg-gray-100 px-4 py-3">
                        <p class="text-[11px] uppercase tracking-[0.18em] text-gray-500">Unpaid</p>
                        <p class="mt-1 text-xl font-semibold text-gray-700">{{ $unpaidParticipantsCount }}</p>
                    </div>

                    <div class="rounded-2xl border border-amber-200 bg-amber-50 px-4 py-3">
                        <p class="text-[11px] uppercase tracking-[0.18em] text-amber-600">Pending</p>
                        <p class="mt-1 text-xl font-semibold text-amber-700">{{ $pendingParticipantsCount }}</p>
                    </div>

                    <div class="rounded-2xl border border-rose-200 bg-rose-50 px-4 py-3">
                        <p class="text-[11px] uppercase tracking-[0.18em] text-rose-600">Rejected</p>
                        <p class="mt-1 text-xl font-semibold text-rose-700">{{ $rejectedParticipantsCount }}</p>
                    </div>
                </div>
            @endif

            <div class="border-b border-gray-200 px-4 py-4 sm:px-6">
                <div class="grid grid-cols-1 gap-4 xl:grid-cols-4">
                    <div>
                        <label class="mb-2 block text-sm font-medium text-gray-700">Select Event</label>
                        <select
                            wire:model.live="selectedEvent"
                            class="w-full rounded-2xl border border-gray-300 bg-white px-4 py-3 text-sm text-gray-900 outline-none transition focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20"
                        >
                            <option value="all">Select an Event</option>
                            @foreach ($allEvents as $eventOption)
                                <option value="{{ $eventOption->id }}">
                                    {{ $eventOption->title }}
                                    @if ($eventOption->event_date)
                                        - {{ $eventOption->event_date->format('M d, Y') }}
                                    @endif
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium text-gray-700">RSVP Status</label>
                        <select
                            wire:model.live="rsvpStatusFilter"
                            class="w-full rounded-2xl border border-gray-300 bg-white px-4 py-3 text-sm text-gray-900 outline-none transition focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20"
                        >
                            <option value="all">All Responses</option>
                            <option value="attending">Attending</option>
                            <option value="maybe">Maybe</option>
                            <option value="not_attending">Not Attending</option>
                            <option value="no_response">No Response Yet</option>
                        </select>
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium text-gray-700">Payment Status</label>
                        <select
                            wire:model.live="paymentStatusFilter"
                            class="w-full rounded-2xl border border-gray-300 bg-white px-4 py-3 text-sm text-gray-900 outline-none transition focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20"
                        >
                            <option value="all">All Payment Status</option>
                            <option value="paid">Paid</option>
                            <option value="unpaid">Unpaid</option>
                            <option value="pending">Pending</option>
                            <option value="rejected">Rejected</option>
                        </select>
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium text-gray-700">Search Alumni or Batch</label>
                        <input
                            type="text"
                            wire:model.live.debounce.300ms="search"
                            placeholder="Search by name or batch"
                            class="w-full rounded-2xl border border-gray-300 bg-white px-4 py-3 text-sm text-gray-900 outline-none transition placeholder:text-gray-400 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20"
                        >
                    </div>
                </div>

                <div class="mt-4 flex flex-col gap-3 sm:flex-row sm:justify-end">
                    <button
                        type="button"
                        wire:click="resetEventFilters"
                        class="inline-flex items-center justify-center rounded-2xl border border-gray-300 bg-white px-4 py-3 text-sm font-medium text-gray-700 transition hover:bg-gray-50"
                    >
                        Reset Filters
                    </button>

                    <button
                        type="button"
                        wire:click="downloadExcel"
                        @disabled($selectedEvent === 'all')
                        class="inline-flex items-center justify-center rounded-2xl bg-emerald-600 px-4 py-3 text-sm font-semibold text-white transition hover:bg-emerald-500 disabled:cursor-not-allowed disabled:opacity-50"
                    >
                        Download CSV
                    </button>
                </div>
            </div>

            @if (session()->has('success'))
                <div class="border-b border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700 sm:px-6">
                    {{ session('success') }}
                </div>
            @endif

            @if (session()->has('error'))
                <div class="border-b border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-700 sm:px-6">
                    {{ session('error') }}
                </div>
            @endif

            <div class="hidden sm:block">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-[13px]">
                        <thead class="border-b border-gray-200 bg-gray-50 text-gray-500">
                            <tr>
                                <th class="px-3 py-2.5 font-medium">Batch</th>
                                <th class="px-3 py-2.5 font-medium">Level</th>
                                <th class="px-3 py-2.5 font-medium">Alumni Name</th>
                                <th class="px-3 py-2.5 font-medium">RSVP</th>
                                <th class="px-3 py-2.5 font-medium">Guests</th>
                                <th class="px-3 py-2.5 font-medium">Fee</th>
                                <th class="px-3 py-2.5 font-medium">Payment</th>
                                <th class="px-3 py-2.5 font-medium">Updated</th>
                                <th class="px-3 py-2.5 font-medium">Action</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-200">
                            @if ($selectedEvent === 'all')
                                <tr>
                                    <td colspan="9" class="px-4 py-10 text-center text-sm text-gray-400">
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
                                            'attending'     => 'border-emerald-200 bg-emerald-50 text-emerald-700',
                                            'maybe'         => 'border-amber-200 bg-amber-50 text-amber-700',
                                            'not_attending' => 'border-rose-200 bg-rose-50 text-rose-700',
                                            default         => 'border-gray-200 bg-gray-100 text-gray-600',
                                        };

                                        $rsvpLabel = match($rsvpStatus) {
                                            'attending'     => 'Attending',
                                            'maybe'         => 'Maybe',
                                            'not_attending' => 'Not Attending',
                                            default         => 'No Response',
                                        };

                                        $paymentStatus = $participant->payment_status ?? 'unpaid';

                                        $paymentBadgeClasses = match($paymentStatus) {
                                            'paid'     => 'border-sky-200 bg-sky-50 text-sky-700',
                                            'pending'  => 'border-amber-200 bg-amber-50 text-amber-700',
                                            'rejected' => 'border-rose-200 bg-rose-50 text-rose-700',
                                            default    => 'border-gray-200 bg-gray-100 text-gray-600',
                                        };

                                        $batchLevel = match($participant->batch_level ?? '') {
                                            'elementary' => 'Elementary',
                                            'highschool' => 'High School',
                                            'college'    => 'College',
                                            default      => '-',
                                        };
                                    @endphp

                                    <tr class="transition hover:bg-emerald-50/60">
                                        <td class="px-3 py-2.5 text-gray-600 whitespace-nowrap">
                                            {{ $participant->batch_label ?: '-' }}
                                        </td>

                                        <td class="px-3 py-2.5 text-gray-500 whitespace-nowrap text-[12px]">
                                            {{ $batchLevel }}
                                        </td>

                                        <td class="px-3 py-2.5 font-medium text-gray-800">
                                            {{ $fullName ?: '-' }}
                                        </td>

                                        <td class="px-3 py-2.5">
                                            <span class="inline-flex rounded-full border px-2 py-0.5 text-[10px] font-semibold uppercase tracking-[0.1em] {{ $rsvpBadgeClasses }}">
                                                {{ $rsvpLabel }}
                                            </span>
                                        </td>

                                        <td class="px-3 py-2.5 text-gray-600 text-center">
                                            {{ $participant->guest_count ?? 0 }}
                                        </td>

                                        <td class="px-3 py-2.5 text-gray-600 whitespace-nowrap">
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

                                        <td class="px-3 py-2.5 text-gray-500 whitespace-nowrap">
                                            {{ $participant->payment_updated_at ? \Carbon\Carbon::parse($participant->payment_updated_at)->format('M d, Y h:i A') : '-' }}
                                        </td>

                                        <td class="px-3 py-2.5">
                                            <select
                                                wire:change="updatePaymentStatus({{ $participant->id }}, $event.target.value)"
                                                class="rounded-lg border border-gray-300 bg-white px-2.5 py-1.5 text-[12px] text-gray-700 outline-none transition focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500/20"
                                            >
                                                <option value="unpaid"   @selected($paymentStatus === 'unpaid')>Unpaid</option>
                                                <option value="pending"  @selected($paymentStatus === 'pending')>Pending</option>
                                                <option value="paid"     @selected($paymentStatus === 'paid')>Paid</option>
                                                <option value="rejected" @selected($paymentStatus === 'rejected')>Rejected</option>
                                            </select>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="px-4 py-10 text-center text-sm text-gray-400">
                                            No attendee records found for the current filters.
                                        </td>
                                    </tr>
                                @endforelse
                            @endif
                        </tbody>
                    </table>
                </div>

                @if ($selectedEvent !== 'all' && method_exists($participants, 'links'))
                    <div class="flex flex-col gap-3 border-t border-gray-200 px-6 py-4 text-sm sm:flex-row sm:items-center sm:justify-between">
                        <p class="text-gray-500">
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
