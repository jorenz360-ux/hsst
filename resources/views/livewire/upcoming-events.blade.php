<div>
<div class="rounded-xl border border-zinc-200 bg-white p-4 dark:border-zinc-700 dark:bg-zinc-900 mb-2">
    <div class="flex items-center justify-between">
        <h2 class="text-base font-semibold text-zinc-900 dark:text-zinc-100">Upcoming Events</h2>
        {{-- <a href="{{ route('event-view') }}"
           class="text-sm text-indigo-600 hover:text-indigo-700 dark:text-indigo-400">
            View all
        </a> --}}
    </div>

    <div class="mt-4 space-y-3">
        @forelse($events as $event)
            <div class="rounded-lg border border-zinc-200 p-3 dark:border-zinc-700">
                <div class="flex items-start justify-between gap-3">
                    <div>
                        <p class="font-medium text-zinc-900 dark:text-zinc-100">{{ $event->title }}</p>
                        <p class="text-sm text-zinc-600 dark:text-zinc-400">{{ $event->venue }}</p>
                        <p class="mt-1 text-sm text-zinc-900 dark:text-zinc-100">
                            {{ $event->event_date->format('M d, Y • h:i A') }}
                        </p>
                    </div>

                    <div class="text-right">
                        <p class="text-sm font-medium text-zinc-900 dark:text-zinc-100">
                            ₱{{ number_format($event->registration_fee / 100, 0) }}
                        </p>

                        {{-- Payment later: for now just a placeholder --}}
                        <button
                            type="button"
                            class="mt-2 inline-flex items-center justify-center rounded-lg bg-indigo-600 px-3 py-1.5 text-xs font-medium text-white hover:bg-indigo-700"
                        >
                            Register
                        </button>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-sm text-zinc-600 dark:text-zinc-400">No upcoming events yet.</p>
        @endforelse
    </div>
</div>
</div>
