<div>
@can('create.event')
@if (session('status'))
    <div
        wire:key="status-{{ session('status_id') }}"
        x-data="{ show: true }"
        x-init="setTimeout(() => show = false, 2000)"
        x-show="show"
        x-transition.opacity.duration.200ms
        class="fixed top-4 right-4 z-[9999] w-full max-w-sm rounded-xl border border-zinc-200 bg-white p-4 shadow-lg
               dark:border-zinc-700 dark:bg-zinc-900"
        role="alert"
    >
        <p class="text-sm font-medium text-green-600 dark:text-green-400">
            {{ session('status') }}
        </p>
    </div>
@endif
<div class="space-y-6">
    {{-- Header / Actions --}}
    <div class="flex items-start justify-between gap-4">
        <div>
            <h1 class="ui-title">Events</h1>
            <p class="ui-subtitle">Manage upcoming and past reunion events.</p>
        </div>

        @can('create.event')
            <flux:button href="{{ route('create-event') }}" variant="primary" wire:navigate>
                <flux:icon name="plus" class="mr-2" />
                Create Event
            </flux:button>
        @endcan
    </div>

    {{-- Filters --}}
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-4">
        <div>
            <label class="ui-label">Search</label>
            <input
                type="text"
                wire:model.live.debounce.300ms="search"
                placeholder="Search title or venue..."
                class="ui-control"
            />
        </div>

        <div>
            <label class="ui-label">Status</label>
            <select wire:model.live="status" class="ui-control">
                <option value="upcoming">Upcoming</option>
                <option value="past">Past</option>
                <option value="all">All</option>
            </select>
        </div>

        <div>
            <label class="ui-label">Visibility</label>
            <select wire:model.live="active" class="ui-control">
                <option value="all">All</option>
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
            </select>
        </div>

        <div>
            <label class="ui-label">Per page</label>
            <select wire:model.live="perPage" class="ui-control">
                <option value="10">10</option>
                <option value="25">25</option>
                <option value="50">50</option>
            </select>
        </div>
    </div>

    {{-- Table wrapper --}}
    <div class="ui-surface">
        <div class="overflow-x-auto">
            <table class="min-w-full text-left text-sm">
                <thead class="ui-thead">
                    <tr>
                        <th class="px-4 py-3">Title</th>
                        <th class="px-4 py-3">Venue</th>
                        <th class="px-4 py-3">Date</th>
                        <th class="px-4 py-3 text-right">Fee</th>
                        <th class="px-4 py-3">Active</th>
                        <th class="px-4 py-3">Created by</th>
                        <th class="px-4 py-3">Toggle</th>
                    </tr>
                </thead>

                <tbody class="ui-tbody">
                    @forelse ($events as $event)
                        <tr class="ui-trow">
                            <td class="px-4 py-3 font-medium text-zinc-900 dark:text-zinc-100">
                                {{ $event['title'] }}
                            </td>

                            <td class="px-4 py-3 text-zinc-700 dark:text-zinc-300">
                                {{ $event['venue'] }}
                            </td>

                            <td class="px-4 py-3">
                                <div class="flex flex-col">
                                    <span class="text-zinc-900 dark:text-zinc-100">
                                        {{ $event['event_date']->format('M d, Y') }}
                                    </span>
                                    <span class="text-xs text-zinc-600 dark:text-zinc-400">
                                        {{ $event['event_date']->format('h:i A') }}
                                    </span>
                                </div>
                            </td>

                            <td class="px-4 py-3 text-right text-zinc-900 dark:text-zinc-100">
                                ₱{{ $event['fee_pesos'] }}
                            </td>

                            <td class="px-4 py-3">
                                @if($event['is_active'])
                                    <span class="ui-badge ui-badge-active">Active</span>
                                @else
                                    <span class="ui-badge ui-badge-inactive">Inactive</span>
                                @endif
                            </td>

                            <td class="px-4 py-3 text-zinc-700 dark:text-zinc-300">
                                {{ $event['creator'] ?? '—' }}
                            </td>

                            <td class="px-4 py-3">
                                <div class="flex items-center gap-2">
                                    @can('edit.event')
                                        <button
                                            type="button"
                                            wire:click="toggleActive({{ $event['id'] }})"
                                            class="ui-btn-outline-sm"
                                            wire:loading.attr="disabled"
                                        >
                                            {{ $event['is_active'] ? 'Disable' : 'Enable' }}
                                        </button>

                                        <a
                                            href="{{ route('events.edit', $event['id']) }}"
                                            class="ui-btn-accent-sm"
                                            wire:navigate
                                        >
                                            Edit
                                        </a>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-10 text-center text-sm text-zinc-600 dark:text-zinc-400">
                                No events found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Footer --}}
        <div class="flex items-center justify-between border-t border-zinc-200 px-4 py-3 text-sm dark:border-zinc-700">
            <p class="text-zinc-600 dark:text-zinc-400">
                Showing {{ $events->firstItem() ?? 0 }}–{{ $events->lastItem() ?? 0 }} of {{ $events->total() }}
            </p>

            <div class="text-zinc-900 dark:text-zinc-100">
                {{ $events->links() }}
            </div>
        </div>
    </div>
</div>
@endcan
</div>