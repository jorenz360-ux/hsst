<div class="min-h-screen bg-zinc-950 text-zinc-100 rounded-2xl">
    @can('create.event')
        @if (session('status'))
            <div
                wire:key="status-{{ session('status_id') }}"
                x-data="{ show: true }"
                x-init="setTimeout(() => show = false, 2500)"
                x-show="show"
                x-transition:enter="transform ease-out duration-300"
                x-transition:enter-start="translate-y-2 opacity-0"
                x-transition:enter-end="translate-y-0 opacity-100"
                x-transition:leave="transform ease-in duration-200"
                x-transition:leave-start="translate-y-0 opacity-100"
                x-transition:leave-end="translate-y-2 opacity-0"
                class="fixed right-4 top-4 z-[9999] w-full max-w-sm overflow-hidden rounded-2xl border border-emerald-500/20 bg-zinc-900/95 p-4 shadow-2xl backdrop-blur"
                role="alert"
            >
                <div class="flex items-start gap-3">
                    <div class="mt-0.5 flex h-10 w-10 shrink-0 items-center justify-center rounded-xl border border-emerald-500/20 bg-emerald-500/10 text-emerald-400">
                        <flux:icon name="check-circle" class="h-5 w-5" />
                    </div>

                    <div class="min-w-0 flex-1">
                        <p class="text-sm font-semibold text-white">Success</p>
                        <p class="mt-1 text-sm text-zinc-300">
                            {{ session('status') }}
                        </p>
                    </div>
                </div>
            </div>
        @endif

        <div class="space-y-6 p-6">
            {{-- Header --}}
            <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.22em] text-amber-400">
                        Events Management
                    </p>
                    <h1 class="mt-1 text-2xl font-bold tracking-tight text-white">
                        Events Management
                    </h1>
                    <p class="mt-1 text-sm text-zinc-400">
                        Manage reunion events, schedules, registration items, and payment validations in one place.
                    </p>
                </div>

                <div class="flex items-center gap-2">
                    @can('create.event')
                        <flux:button
                            href="{{ route('create-event') }}"
                            wire:navigate
                            class="bg-amber-500 text-zinc-950 hover:bg-amber-400"
                        >
                            <flux:icon name="plus" class="mr-2 h-4 w-4" />
                            Create Event
                        </flux:button>
                    @endcan
                </div>
            </div>

            {{-- Tabs --}}
            <div class="rounded-2xl border border-white/10 bg-zinc-900 p-1 shadow-sm">
                <div class="grid w-full grid-cols-2 gap-1">
                    <button
                        wire:click="$set('tab', 'events')"
                        class="{{ $tab === 'events'
                            ? 'bg-amber-500 text-zinc-950 shadow-sm'
                            : 'text-zinc-400 hover:bg-zinc-800' }}
                            rounded-xl px-4 py-2.5 text-sm font-medium transition"
                    >
                        Events
                    </button>

                    <button
                        wire:click="$set('tab', 'payments')"
                        class="{{ $tab === 'payments'
                            ? 'bg-violet-500 text-white shadow-sm'
                            : 'text-zinc-400 hover:bg-zinc-800' }}
                            rounded-xl px-4 py-2.5 text-sm font-medium transition"
                    >
                        Payment Validation
                    </button>
                </div>
            </div>

            {{-- Payments Tab --}}
            @if ($tab === 'payments')
                <div class="space-y-5">
                    {{-- Payment Filters --}}
                    <div class="rounded-2xl border border-white/10 bg-zinc-900 p-5 shadow-sm">
                        <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                            <div>
                                <label class="mb-2 block text-sm font-medium text-zinc-300">
                                    Search
                                </label>
                                <input
                                    type="text"
                                    wire:model.live.debounce.300ms="paymentSearch"
                                    placeholder="Alumni, event, item, reference..."
                                    class="w-full rounded-xl border border-white/10 bg-zinc-950 px-4 py-2.5 text-sm text-zinc-100 outline-none transition placeholder:text-zinc-500 focus:border-amber-400 focus:ring-2 focus:ring-amber-500/20"
                                />
                            </div>

                            <div>
                                <label class="mb-2 block text-sm font-medium text-zinc-300">
                                    Payment Type
                                </label>
                                <select
                                    wire:model.live="paymentType"
                                    class="w-full rounded-xl border border-white/10 bg-zinc-950 px-4 py-2.5 text-sm text-zinc-100 outline-none transition focus:border-amber-400 focus:ring-2 focus:ring-amber-500/20"
                                >
                                    <option value="all">All</option>
                                    <option value="registration">Base Registration</option>
                                    <option value="item">Registration Items</option>
                                </select>
                            </div>

                            <div>
                                <label class="mb-2 block text-sm font-medium text-zinc-300">
                                    Per page
                                </label>
                                <select
                                    wire:model.live="paymentPerPage"
                                    class="w-full rounded-xl border border-white/10 bg-zinc-950 px-4 py-2.5 text-sm text-zinc-100 outline-none transition focus:border-amber-400 focus:ring-2 focus:ring-amber-500/20"
                                >
                                    <option value="10">10</option>
                                    <option value="25">25</option>
                                    <option value="50">50</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    {{-- Payment Table --}}
                    <div class="overflow-hidden rounded-2xl border border-white/10 bg-zinc-900 shadow-sm">
                        <div class="border-b border-white/10 px-5 py-4">
                            <h2 class="text-base font-semibold text-white">
                                Pending Payment Validations
                            </h2>
                            <p class="mt-1 text-sm text-zinc-400">
                                Review whether the proof is for the base registration fee or a registration item like dinner.
                            </p>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="min-w-full text-left text-sm">
                                <thead class="bg-zinc-950/80">
                                    <tr class="text-zinc-400">
                                        <th class="px-5 py-3 font-medium">Alumni</th>
                                        <th class="px-5 py-3 font-medium">Event</th>
                                        <th class="px-5 py-3 font-medium">Paid For</th>
                                        <th class="px-5 py-3 font-medium text-right">Amount</th>
                                        <th class="px-5 py-3 font-medium">Reference</th>
                                        <th class="px-5 py-3 font-medium">Proof</th>
                                        <th class="px-5 py-3 font-medium">Submitted</th>
                                        <th class="px-5 py-3 font-medium text-right">Actions</th>
                                    </tr>
                                </thead>

                                <tbody class="divide-y divide-white/10">
                                    @forelse($pendingPayments as $payment)
                                        <tr class="transition hover:bg-amber-500/[0.04]">
                                            <td class="px-5 py-4 text-zinc-100">
                                                {{ $payment->registration->alumni->fname }}
                                                {{ $payment->registration->alumni->lname }}
                                            </td>

                                            <td class="px-5 py-4 text-zinc-300">
                                                {{ $payment->registration->event->title }}
                                            </td>

                                            <td class="px-5 py-4">
                                                <div class="space-y-1">
                                                    <p class="font-medium text-zinc-100">
                                                        {{ $payment->registrationItem?->name ?? 'Event Registration Fee' }}
                                                    </p>

                                                    @if ($payment->registrationItem)
                                                        <span class="inline-flex rounded-full border border-violet-500/20 bg-violet-500/10 px-2.5 py-1 text-xs font-medium text-violet-300">
                                                            Registration Item
                                                        </span>

                                                        @if ($payment->registrationItem->schedule)
                                                            <p class="text-xs text-zinc-500">
                                                                Linked to {{ $payment->registrationItem->schedule->title }}
                                                            </p>
                                                        @endif
                                                    @else
                                                        <span class="inline-flex rounded-full border border-emerald-500/20 bg-emerald-500/10 px-2.5 py-1 text-xs font-medium text-emerald-300">
                                                            Base Registration
                                                        </span>
                                                    @endif
                                                </div>
                                            </td>

                                            <td class="px-5 py-4 text-right font-medium text-zinc-100">
                                                ₱{{ number_format($payment->amount / 100, 2) }}
                                            </td>

                                            <td class="px-5 py-4 text-zinc-300">
                                                {{ $payment->reference_number ?? '—' }}
                                            </td>

                                            <td class="px-5 py-4">
                                                @if($payment->or_file_path)
                                                    <a
                                                        href="{{ Storage::disk('s3')->url($payment->or_file_path) }}"
                                                        target="_blank"
                                                        class="inline-flex items-center gap-1 font-medium text-amber-400 hover:text-amber-300"
                                                    >
                                                        <flux:icon name="paper-clip" class="h-4 w-4" />
                                                        View OR
                                                    </a>
                                                @else
                                                    <span class="text-zinc-500">No file</span>
                                                @endif
                                            </td>

                                            <td class="px-5 py-4 text-zinc-300">
                                                <div class="flex flex-col">
                                                    <span>{{ $payment->created_at->format('M d, Y') }}</span>
                                                    <span class="text-xs text-zinc-500">
                                                        {{ $payment->created_at->format('h:i A') }}
                                                    </span>
                                                </div>
                                            </td>

                                            <td class="px-5 py-4">
                                                <div class="flex justify-end gap-2">
                                                    <button
                                                        wire:click="approvePayment({{ $payment->id }})"
                                                        wire:loading.attr="disabled"
                                                        class="inline-flex items-center rounded-xl bg-emerald-600 px-3 py-2 text-sm font-medium text-white transition hover:bg-emerald-700 disabled:opacity-50"
                                                    >
                                                        Approve
                                                    </button>

                                                    <button
                                                        wire:click="rejectPayment({{ $payment->id }})"
                                                        wire:loading.attr="disabled"
                                                        class="inline-flex items-center rounded-xl border border-white/10 bg-zinc-950 px-3 py-2 text-sm font-medium text-zinc-200 transition hover:bg-zinc-800 disabled:opacity-50"
                                                    >
                                                        Reject
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="px-5 py-12 text-center text-sm text-zinc-500">
                                                No pending payment validations.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="flex flex-col gap-3 border-t border-white/10 px-5 py-4 text-sm sm:flex-row sm:items-center sm:justify-between">
                            <p class="text-zinc-400">
                                Showing {{ $pendingPayments->firstItem() ?? 0 }}–{{ $pendingPayments->lastItem() ?? 0 }} of {{ $pendingPayments->total() }}
                            </p>

                            <div class="[&>*]:!shadow-none">
                                {{ $pendingPayments->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Events Tab --}}
            @if ($tab === 'events')
                <div class="rounded-2xl border border-white/10 bg-zinc-900 p-5 shadow-sm">
                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-4">
                        <div>
                            <label class="mb-2 block text-sm font-medium text-zinc-300">
                                Search
                            </label>
                            <input
                                type="text"
                                wire:model.live.debounce.300ms="search"
                                placeholder="Search title or venue..."
                                class="w-full rounded-xl border border-white/10 bg-zinc-950 px-4 py-2.5 text-sm text-zinc-100 outline-none transition placeholder:text-zinc-500 focus:border-amber-400 focus:ring-2 focus:ring-amber-500/20"
                            />
                        </div>

                        <div>
                            <label class="mb-2 block text-sm font-medium text-zinc-300">
                                Status
                            </label>
                            <select
                                wire:model.live="status"
                                class="w-full rounded-xl border border-white/10 bg-zinc-950 px-4 py-2.5 text-sm text-zinc-100 outline-none transition focus:border-amber-400 focus:ring-2 focus:ring-amber-500/20"
                            >
                                <option value="upcoming">Upcoming</option>
                                <option value="past">Past</option>
                                <option value="all">All</option>
                            </select>
                        </div>

                        <div>
                            <label class="mb-2 block text-sm font-medium text-zinc-300">
                                Visibility
                            </label>
                            <select
                                wire:model.live="active"
                                class="w-full rounded-xl border border-white/10 bg-zinc-950 px-4 py-2.5 text-sm text-zinc-100 outline-none transition focus:border-amber-400 focus:ring-2 focus:ring-amber-500/20"
                            >
                                <option value="all">All</option>
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>

                        <div>
                            <label class="mb-2 block text-sm font-medium text-zinc-300">
                                Per page
                            </label>
                            <select
                                wire:model.live="perPage"
                                class="w-full rounded-xl border border-white/10 bg-zinc-950 px-4 py-2.5 text-sm text-zinc-100 outline-none transition focus:border-amber-400 focus:ring-2 focus:ring-amber-500/20"
                            >
                                <option value="10">10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="overflow-hidden rounded-2xl border border-white/10 bg-zinc-900 shadow-sm">
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-left text-sm">
                            <thead class="bg-zinc-950/80">
                                <tr class="text-zinc-400">
                                    <th class="px-5 py-3 font-medium">Title</th>
                                    <th class="px-5 py-3 font-medium">Venue</th>
                                    <th class="px-5 py-3 font-medium">Date</th>
                                    <th class="px-5 py-3 font-medium text-right">Fee</th>
                                    <th class="px-5 py-3 font-medium">Active</th>
                                    <th class="px-5 py-3 font-medium">Created by</th>
                                    <th class="px-5 py-3 font-medium text-right">Actions</th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-white/10">
                                @forelse ($events as $event)
                                    <tr class="transition hover:bg-amber-500/[0.04]">
                                        <td class="px-5 py-4 font-medium text-zinc-100">
                                            {{ $event['title'] }}
                                        </td>

                                        <td class="px-5 py-4 text-zinc-300">
                                            {{ $event['venue'] }}
                                        </td>

                                        <td class="px-5 py-4">
                                            <div class="flex flex-col">
                                                <span class="text-zinc-100">
                                                    {{ $event['event_date']->format('M d, Y') }}
                                                </span>
                                                <span class="text-xs text-zinc-500">
                                                    {{ $event['event_date']->format('h:i A') }}
                                                </span>
                                            </div>
                                        </td>

                                        <td class="px-5 py-4 text-right font-medium text-zinc-100">
                                            ₱{{ $event['fee_pesos'] }}
                                        </td>

                                        <td class="px-5 py-4">
                                            @if ($event['is_active'])
                                                <span class="inline-flex rounded-full border border-emerald-500/20 bg-emerald-500/10 px-2.5 py-1 text-xs font-medium text-emerald-300">
                                                    Active
                                                </span>
                                            @else
                                                <span class="inline-flex rounded-full border border-zinc-500/20 bg-zinc-500/10 px-2.5 py-1 text-xs font-medium text-zinc-400">
                                                    Inactive
                                                </span>
                                            @endif
                                        </td>

                                        <td class="px-5 py-4 text-zinc-300">
                                            {{ $event['creator'] ?? '—' }}
                                        </td>

                                        <td class="px-5 py-4">
                                            @can('edit.event')
                                                <div class="flex justify-end gap-2">
                                                    <button
                                                        type="button"
                                                        wire:click="toggleActive({{ $event['id'] }})"
                                                        wire:loading.attr="disabled"
                                                        class="inline-flex items-center rounded-xl border border-white/10 bg-zinc-950 px-3 py-2 text-sm font-medium text-zinc-200 transition hover:bg-zinc-800 disabled:opacity-50"
                                                    >
                                                        {{ $event['is_active'] ? 'Disable' : 'Enable' }}
                                                    </button>

                                                    <a
                                                        href="{{ route('events.edit', $event['id']) }}"
                                                        wire:navigate
                                                        class="inline-flex items-center rounded-xl bg-amber-500 px-3 py-2 text-sm font-medium text-zinc-950 transition hover:bg-amber-400"
                                                    >
                                                        Edit
                                                    </a>
                                                </div>
                                            @endcan
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="px-5 py-12 text-center text-sm text-zinc-500">
                                            No events found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="flex flex-col gap-3 border-t border-white/10 px-5 py-4 text-sm sm:flex-row sm:items-center sm:justify-between">
                        <p class="text-zinc-400">
                            Showing {{ $events->firstItem() ?? 0 }}–{{ $events->lastItem() ?? 0 }} of {{ $events->total() }}
                        </p>

                        <div class="[&>*]:!shadow-none">
                            {{ $events->links() }}
                        </div>
                    </div>
                </div>
            @endif
        </div>
    @endcan
</div>