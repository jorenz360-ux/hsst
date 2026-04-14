<div class="p-4 sm:p-6">
    <section class="overflow-hidden rounded-2xl border border-zinc-200 bg-white shadow-sm">

        {{-- Header --}}
        <div class="border-b border-zinc-200 px-4 py-4 sm:px-5">
            <div class="flex flex-col gap-2 lg:flex-row lg:items-end lg:justify-between">
                <div>
                    <h2 class="text-base font-semibold text-zinc-900">
                        Batch Participants Workspace
                    </h2>
                    <p class="mt-1 text-xs text-zinc-500 sm:text-sm">
                        Manage RSVP and payment status for your assigned batch.
                    </p>
                </div>

                <div class="rounded-xl border border-zinc-200 bg-zinc-50 px-3 py-1.5 text-[10px] uppercase tracking-[0.16em] text-zinc-500 sm:text-[11px]">
                    {{ str($currentBatch?->level ?? '')->headline() }} • {{ $currentBatch?->schoolyear }}
                </div>
            </div>
        </div>

        {{-- Filters --}}
        <div class="border-b border-zinc-200 px-4 py-4 sm:px-5">
            <div class="grid grid-cols-1 gap-3 xl:grid-cols-4">

                {{-- Event --}}
                <div>
                    <label class="mb-1.5 block text-xs font-medium text-zinc-700">
                        Select Event
                    </label>
                    <select wire:model.live="selectedEvent"
                        class="w-full rounded-xl border border-zinc-300 bg-white px-3 py-2.5 text-sm text-zinc-900">
                        <option value="all">Select an Event</option>
                        @foreach ($allEvents as $eventOption)
                            <option value="{{ $eventOption->id }}">
                                {{ $eventOption->title }} -
                                {{ $eventOption->event_date?->format('M d, Y') }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- RSVP --}}
                <div>
                    <label class="mb-1.5 block text-xs text-zinc-700">RSVP</label>
                    <select wire:model.live="rsvpStatusFilter"
                        class="w-full rounded-xl border border-zinc-300 bg-white px-3 py-2.5 text-sm text-zinc-900">
                        <option value="all">All</option>
                        <option value="attending">Attending</option>
                        <option value="maybe">Maybe</option>
                        <option value="not_attending">Not Attending</option>
                        <option value="no_response">No Response</option>
                    </select>
                </div>

                {{-- Payment --}}
                <div>
                    <label class="mb-1.5 block text-xs text-zinc-700">Payment</label>
                    <select wire:model.live="paymentStatusFilter"
                        class="w-full rounded-xl border border-zinc-300 bg-white px-3 py-2.5 text-sm text-zinc-900">
                        <option value="all">All</option>
                        <option value="paid">Paid</option>
                        <option value="unpaid">Unpaid</option>
                        <option value="waived">Waived</option>
                    </select>
                </div>

                {{-- Search --}}
                <div>
                    <label class="mb-1.5 block text-xs text-zinc-700">Search</label>
                    <input type="text"
                        wire:model.live.debounce.300ms="search"
                        placeholder="Search alumni..."
                        class="w-full rounded-xl border border-zinc-300 bg-white px-3 py-2.5 text-sm text-zinc-900">
                </div>
            </div>

            <div class="mt-3 flex justify-end gap-2">
                <button wire:click="resetEventFilters"
                    class="rounded-xl border border-zinc-300 bg-white px-3 py-2 text-sm text-zinc-700">
                    Reset
                </button>

                <button wire:click="downloadExcel"
                    @disabled($selectedEvent === 'all')
                    class="rounded-xl bg-emerald-500 px-3 py-2 text-sm font-semibold text-white">
                    Export
                </button>
            </div>
        </div>

        {{-- TABLE --}}
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-zinc-50 text-zinc-500">
                    <tr>
                        <th class="px-4 py-3 text-left">Name</th>
                        <th class="px-4 py-3 text-left">Batch</th>
                        <th class="px-4 py-3 text-left">RSVP</th>
                        <th class="px-4 py-3 text-left">Payment</th>
                        <th class="px-4 py-3 text-left">Updated</th>
                        <th class="px-4 py-3 text-left">Action</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-zinc-100">
                    @forelse ($participants as $p)

                        @php
                            $fullName = trim("{$p->fname} {$p->mname} {$p->lname}");
                        @endphp

                        <tr class="hover:bg-zinc-50">

                            {{-- Name --}}
                            <td class="px-4 py-3 text-zinc-900">
                                {{ $fullName ?: '-' }}
                            </td>

                            {{-- Batch --}}
                            <td class="px-4 py-3 text-zinc-600">
                                <span class="text-xs text-sky-600">
                                    {{ str($p->level)->headline() }}
                                </span><br>
                                <span class="text-xs text-zinc-500">
                                    {{ $p->schoolyear }} • {{ $p->yeargrad }}
                                </span>
                            </td>

                            {{-- RSVP --}}
                            <td class="px-4 py-3 text-zinc-600">
                                {{ str($p->rsvp_status ?? 'no_response')->headline() }}
                            </td>

                            {{-- Payment --}}
                            <td class="px-4 py-3 text-zinc-600">
                                {{ str($p->payment_status ?? 'unpaid')->headline() }}
                            </td>

                            {{-- Updated --}}
                            <td class="px-4 py-3 text-zinc-400 text-xs">
                                {{ $p->payment_updated_at
                                    ? \Carbon\Carbon::parse($p->payment_updated_at)->format('M d, Y h:i A')
                                    : '-' }}
                            </td>

                            {{-- Action --}}
                            <td class="px-4 py-3">
                                <select
                                    wire:change="updatePaymentStatus({{ $p->id }}, $event.target.value)"
                                    class="rounded border border-zinc-300 bg-white px-2 py-1 text-xs text-zinc-900">
                                    <option value="unpaid">Unpaid</option>
                                    <option value="paid">Paid</option>
                                    <option value="waived">Waived</option>
                                </select>
                            </td>

                        </tr>

                    @empty
                        <tr>
                            <td colspan="6" class="py-10 text-center text-zinc-500">
                                No records found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="border-t border-zinc-200 px-4 py-3">
            {{ $participants->links() }}
        </div>

    </section>
</div>
