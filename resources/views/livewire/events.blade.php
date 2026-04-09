<div class="min-h-screen text-gray-800">
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
                class="fixed right-4 top-4 z-[9999] w-full max-w-sm overflow-hidden rounded-2xl border border-emerald-200 bg-white p-4 shadow-xl"
                role="alert"
            >
                <div class="flex items-start gap-3">
                    <div class="mt-0.5 flex h-10 w-10 shrink-0 items-center justify-center rounded-xl border border-emerald-200 bg-emerald-50 text-emerald-600">
                        <flux:icon name="check-circle" class="h-5 w-5" />
                    </div>

                    <div class="min-w-0 flex-1">
                        <p class="text-sm font-semibold text-gray-900">Success</p>
                        <p class="mt-0.5 text-sm text-gray-500">
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
                    <p class="text-xs font-semibold uppercase tracking-[0.22em] text-amber-600">
                        Events Management
                    </p>
                    <h1 class="mt-1 text-2xl font-bold tracking-tight text-gray-900">
                        Events Management
                    </h1>
                    <p class="mt-1 text-sm text-gray-500">
                        Manage events through a calendar-first dashboard with quick payment validation tools.
                    </p>
                </div>

                <div class="flex items-center gap-2">
                    @can('create.event')
                        <flux:button
                            href="{{ route('create-event') }}"
                            wire:navigate
                            class="bg-amber-500 text-white hover:bg-amber-600"
                        >
                            <flux:icon name="plus" class="mr-2 h-4 w-4" />
                            Create Event
                        </flux:button>
                    @endcan
                </div>
            </div>

            {{-- Stats --}}
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
                <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
                    <p class="text-sm text-gray-500">Total Events</p>
                    <p class="mt-2 text-3xl font-bold text-gray-900">{{ $stats['total'] }}</p>
                </div>
                <div class="rounded-2xl border border-amber-200 bg-amber-50 p-5 shadow-sm">
                    <p class="text-sm text-amber-600">Upcoming</p>
                    <p class="mt-2 text-3xl font-bold text-amber-700">{{ $stats['upcoming'] }}</p>
                </div>
                <div class="rounded-2xl border border-sky-200 bg-sky-50 p-5 shadow-sm">
                    <p class="text-sm text-sky-600">Past</p>
                    <p class="mt-2 text-3xl font-bold text-sky-700">{{ $stats['past'] }}</p>
                </div>
                <div class="rounded-2xl border border-emerald-200 bg-emerald-50 p-5 shadow-sm">
                    <p class="text-sm text-emerald-600">Active</p>
                    <p class="mt-2 text-3xl font-bold text-emerald-700">{{ $stats['active'] }}</p>
                </div>
            </div>

            {{-- Tabs --}}
            <div class="rounded-2xl border border-gray-200 bg-gray-100 p-1 shadow-sm">
                <div class="grid w-full grid-cols-2 gap-1">
                    <button
                        wire:click="$set('tab', 'events')"
                        class="{{ $tab === 'events'
                            ? 'bg-white text-amber-600 shadow-sm'
                            : 'text-gray-500 hover:text-gray-700' }}
                            rounded-xl px-4 py-2.5 text-sm font-medium transition"
                    >
                        Calendar View
                    </button>

                    <button
                        wire:click="$set('tab', 'payments')"
                        class="{{ $tab === 'payments'
                            ? 'bg-white text-violet-600 shadow-sm'
                            : 'text-gray-500 hover:text-gray-700' }}
                            rounded-xl px-4 py-2.5 text-sm font-medium transition"
                    >
                        Payment Validation
                    </button>
                </div>
            </div>

            {{-- Payments Tab --}}
            @if ($tab === 'payments')
                <div class="space-y-5">
                    <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
                        <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                            <div>
                                <label class="mb-2 block text-sm font-medium text-gray-700">Search</label>
                                <input
                                    type="text"
                                    wire:model.live.debounce.300ms="paymentSearch"
                                    placeholder="Alumni, event, item, reference..."
                                    class="w-full rounded-xl border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 outline-none transition placeholder:text-gray-400 focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20"
                                />
                            </div>

                            <div>
                                <label class="mb-2 block text-sm font-medium text-gray-700">Payment Type</label>
                                <select
                                    wire:model.live="paymentType"
                                    class="w-full rounded-xl border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 outline-none transition focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20"
                                >
                                    <option value="all">All</option>
                                    <option value="registration">Base Registration</option>
                                    <option value="item">Registration Items</option>
                                </select>
                            </div>

                            <div>
                                <label class="mb-2 block text-sm font-medium text-gray-700">Per page</label>
                                <select
                                    wire:model.live="paymentPerPage"
                                    class="w-full rounded-xl border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 outline-none transition focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20"
                                >
                                    <option value="10">10</option>
                                    <option value="25">25</option>
                                    <option value="50">50</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">
                        <div class="border-b border-gray-100 px-6 py-4">
                            <h2 class="text-base font-semibold text-gray-900">Pending Payment Validations</h2>
                            <p class="mt-0.5 text-sm text-gray-400">
                                Review whether the proof is for the base registration fee or a registration item.
                            </p>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="min-w-full text-left text-sm">
                                <thead class="border-b border-gray-100 bg-gray-50 text-xs font-semibold uppercase tracking-wide text-gray-400">
                                    <tr>
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

                                <tbody class="divide-y divide-gray-100">
                                    @forelse($pendingPayments as $payment)
                                        <tr class="transition hover:bg-amber-50/50">
                                            <td class="px-5 py-4 font-medium text-gray-900">
                                                {{ $payment->registration->alumni->fname ?? '' }}
                                                {{ $payment->registration->alumni->lname ?? '' }}
                                            </td>

                                            <td class="px-5 py-4 text-gray-600">
                                                {{ $payment->registration->event->title ?? '—' }}
                                            </td>

                                            <td class="px-5 py-4">
                                                <div class="space-y-1">
                                                    <p class="font-medium text-gray-800">
                                                        {{ $payment->registrationItem?->name ?? 'Event Registration Fee' }}
                                                    </p>

                                                    @if ($payment->registrationItem)
                                                        <span class="inline-flex rounded-full border border-violet-200 bg-violet-50 px-2.5 py-1 text-xs font-medium text-violet-700">
                                                            Registration Item
                                                        </span>

                                                        @if ($payment->registrationItem->schedule)
                                                            <p class="text-xs text-gray-400">
                                                                Linked to {{ $payment->registrationItem->schedule->title }}
                                                            </p>
                                                        @endif
                                                    @else
                                                        <span class="inline-flex rounded-full border border-emerald-200 bg-emerald-50 px-2.5 py-1 text-xs font-medium text-emerald-700">
                                                            Base Registration
                                                        </span>
                                                    @endif
                                                </div>
                                            </td>

                                            <td class="px-5 py-4 text-right">
                                                <span class="font-semibold text-gray-900">₱{{ number_format($payment->amount / 100, 2) }}</span>
                                            </td>

                                            <td class="px-5 py-4">
                                                <span class="font-mono text-xs text-gray-500">{{ $payment->reference_number ?? '—' }}</span>
                                            </td>

                                            <td class="px-5 py-4">
                                                @if($payment->or_file_path)
                                                    <a
                                                        href="{{ Storage::disk('s3')->url($payment->or_file_path) }}"
                                                        target="_blank"
                                                        class="inline-flex items-center gap-1.5 rounded-lg border border-amber-200 bg-amber-50 px-2.5 py-1.5 text-xs font-medium text-amber-700 transition hover:bg-amber-100"
                                                    >
                                                        <flux:icon name="paper-clip" class="h-3.5 w-3.5" />
                                                        View OR
                                                    </a>
                                                @else
                                                    <span class="text-xs text-gray-300">No file</span>
                                                @endif
                                            </td>

                                            <td class="px-5 py-4">
                                                <div class="flex flex-col">
                                                    <span class="text-gray-700">{{ $payment->created_at->format('M d, Y') }}</span>
                                                    <span class="text-xs text-gray-400">{{ $payment->created_at->format('h:i A') }}</span>
                                                </div>
                                            </td>

                                            <td class="px-5 py-4">
                                                <div class="flex justify-end gap-2">
                                                    <button
                                                        wire:click="approvePayment({{ $payment->id }})"
                                                        wire:loading.attr="disabled"
                                                        class="inline-flex items-center rounded-xl bg-emerald-600 px-3 py-2 text-sm font-medium text-white transition hover:bg-emerald-500 disabled:opacity-50"
                                                    >
                                                        Approve
                                                    </button>

                                                    <button
                                                        wire:click="rejectPayment({{ $payment->id }})"
                                                        wire:loading.attr="disabled"
                                                        class="inline-flex items-center rounded-xl border border-rose-200 bg-rose-50 px-3 py-2 text-sm font-medium text-rose-600 transition hover:bg-rose-100 disabled:opacity-50"
                                                    >
                                                        Reject
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="px-5 py-12 text-center">
                                                <flux:icon name="inbox" class="mx-auto h-7 w-7 text-gray-300" />
                                                <p class="mt-2 text-sm text-gray-400">No pending payment validations.</p>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="flex flex-col gap-3 border-t border-gray-100 px-5 py-4 text-sm sm:flex-row sm:items-center sm:justify-between">
                            <p class="text-gray-400">
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
                <div class="space-y-6">
                    {{-- Filters --}}
                    <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
                        <div class="grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-4">
                            <div>
                                <label class="mb-2 block text-sm font-medium text-gray-700">Search</label>
                                <input
                                    type="text"
                                    wire:model.live.debounce.300ms="search"
                                    placeholder="Search title or venue..."
                                    class="w-full rounded-xl border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 outline-none transition placeholder:text-gray-400 focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20"
                                />
                            </div>

                            <div>
                                <label class="mb-2 block text-sm font-medium text-gray-700">Status</label>
                                <select
                                    wire:model.live="status"
                                    class="w-full rounded-xl border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 outline-none transition focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20"
                                >
                                    <option value="upcoming">Upcoming</option>
                                    <option value="past">Past</option>
                                    <option value="all">All</option>
                                </select>
                            </div>

                            <div>
                                <label class="mb-2 block text-sm font-medium text-gray-700">Visibility</label>
                                <select
                                    wire:model.live="active"
                                    class="w-full rounded-xl border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 outline-none transition focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20"
                                >
                                    <option value="all">All</option>
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                </select>
                            </div>

                            <div>
                                <label class="mb-2 block text-sm font-medium text-gray-700">List Per Page</label>
                                <select
                                    wire:model.live="perPage"
                                    class="w-full rounded-xl border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 outline-none transition focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20"
                                >
                                    <option value="10">10</option>
                                    <option value="25">25</option>
                                    <option value="50">50</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    {{-- Event List Table --}}
                    <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">
                        <div class="border-b border-gray-100 px-6 py-4">
                            <h2 class="text-base font-semibold text-gray-900">Event List</h2>
                            <p class="mt-0.5 text-sm text-gray-400">
                                Detailed tabular view for searching, reviewing, and editing events.
                            </p>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="min-w-full text-left text-sm">
                                <thead class="border-b border-gray-100 bg-gray-50 text-xs font-semibold uppercase tracking-wide text-gray-400">
                                    <tr>
                                        <th class="px-5 py-3 font-medium">Title</th>
                                        <th class="px-5 py-3 font-medium">Venue</th>
                                        <th class="px-5 py-3 font-medium">Date</th>
                                        <th class="px-5 py-3 font-medium text-right">Fee</th>
                                        <th class="px-5 py-3 font-medium">Active</th>
                                        <th class="px-5 py-3 font-medium">Event Banner</th>
                                        <th class="px-5 py-3 font-medium text-right">Actions</th>
                                    </tr>
                                </thead>

                                <tbody class="divide-y divide-gray-100">
                                    @forelse ($events as $event)
                                        <tr class="transition hover:bg-amber-50/40">
                                            <td class="px-5 py-4 font-medium text-gray-900">
                                                {{ $event['title'] }}
                                            </td>

                                            <td class="px-5 py-4 text-gray-600">
                                                {{ $event['venue'] }}
                                            </td>

                                            <td class="px-5 py-4">
                                                <div class="flex flex-col">
                                                    <span class="text-gray-800">
                                                        {{ $event['event_date']->format('M d, Y') }}
                                                    </span>
                                                    <span class="text-xs text-gray-400">
                                                        {{ $event['event_date']->format('h:i A') }}
                                                    </span>
                                                </div>
                                            </td>

                                            <td class="px-5 py-4 text-right">
                                                <span class="font-semibold text-gray-900">₱{{ $event['fee_pesos'] }}</span>
                                            </td>

                                            <td class="px-5 py-4">
                                                @if ($event['is_active'])
                                                    <span class="inline-flex rounded-full border border-emerald-200 bg-emerald-50 px-2.5 py-1 text-xs font-medium text-emerald-700">
                                                        Active
                                                    </span>
                                                @else
                                                    <span class="inline-flex rounded-full border border-gray-200 bg-gray-100 px-2.5 py-1 text-xs font-medium text-gray-500">
                                                        Inactive
                                                    </span>
                                                @endif
                                            </td>

                                            <td class="px-5 py-4">
                                                @if (filled($event['banner_image']))
                                                    <span class="inline-flex rounded-full border border-emerald-200 bg-emerald-50 px-2.5 py-1 text-xs font-medium text-emerald-700">
                                                        Has banner
                                                    </span>
                                                @else
                                                    <span class="inline-flex rounded-full border border-gray-200 bg-gray-100 px-2.5 py-1 text-xs font-medium text-gray-400">
                                                        No banner
                                                    </span>
                                                @endif
                                            </td>

                                            <td class="px-5 py-4">
                                                @can('edit.event')
                                                    <div class="flex justify-end gap-2">
                                                        <button
                                                            type="button"
                                                            wire:click="toggleActive({{ $event['id'] }})"
                                                            wire:loading.attr="disabled"
                                                            class="inline-flex items-center rounded-xl border border-gray-300 bg-white px-3 py-2 text-sm font-medium text-gray-600 transition hover:bg-gray-50 disabled:opacity-50"
                                                        >
                                                            {{ $event['is_active'] ? 'Disable' : 'Enable' }}
                                                        </button>

                                                        <a
                                                            href="{{ route('events.edit', ['event' => $event['slug']]) }}"
                                                            wire:navigate
                                                            class="inline-flex items-center rounded-xl bg-amber-500 px-3 py-2 text-sm font-medium text-white transition hover:bg-amber-600"
                                                        >
                                                            Edit
                                                        </a>
                                                    </div>
                                                @endcan
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="px-5 py-12 text-center">
                                                <flux:icon name="calendar" class="mx-auto h-7 w-7 text-gray-300" />
                                                <p class="mt-2 text-sm text-gray-400">No events found.</p>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="flex flex-col gap-3 border-t border-gray-100 px-5 py-4 text-sm sm:flex-row sm:items-center sm:justify-between">
                            <p class="text-gray-400">
                                Showing {{ $events->firstItem() ?? 0 }}–{{ $events->lastItem() ?? 0 }} of {{ $events->total() }}
                            </p>

                            <div class="[&>*]:!shadow-none">
                                {{ $events->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    @endcan
</div>
