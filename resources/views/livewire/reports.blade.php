<div>
<div class="mx-auto max-w-7xl space-y-6">
    <div>
        <h1 class="text-xl font-semibold text-zinc-900 dark:text-zinc-100">Reports</h1>
        <p class="mt-1 text-sm text-zinc-600 dark:text-zinc-400">
            Overview of events, schedules, and announcements.
        </p>
    </div>

    <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
        <div class="rounded-2xl border border-zinc-200 bg-white p-5 shadow-sm dark:border-zinc-700 dark:bg-zinc-900">
            <p class="text-xs font-medium uppercase tracking-[0.18em] text-zinc-500 dark:text-zinc-400">Total Events</p>
            <p class="mt-3 text-3xl font-bold text-zinc-900 dark:text-zinc-100">{{ $totalEvents }}</p>
        </div>

        <div class="rounded-2xl border border-zinc-200 bg-white p-5 shadow-sm dark:border-zinc-700 dark:bg-zinc-900">
            <p class="text-xs font-medium uppercase tracking-[0.18em] text-zinc-500 dark:text-zinc-400">Active Events</p>
            <p class="mt-3 text-3xl font-bold text-zinc-900 dark:text-zinc-100">{{ $activeEvents }}</p>
        </div>

        <div class="rounded-2xl border border-zinc-200 bg-white p-5 shadow-sm dark:border-zinc-700 dark:bg-zinc-900">
            <p class="text-xs font-medium uppercase tracking-[0.18em] text-zinc-500 dark:text-zinc-400">Published Announcements</p>
            <p class="mt-3 text-3xl font-bold text-zinc-900 dark:text-zinc-100">{{ $publishedAnnouncements }}</p>
        </div>

        <div class="rounded-2xl border border-zinc-200 bg-white p-5 shadow-sm dark:border-zinc-700 dark:bg-zinc-900">
            <p class="text-xs font-medium uppercase tracking-[0.18em] text-zinc-500 dark:text-zinc-400">Schedule Items</p>
            <p class="mt-3 text-3xl font-bold text-zinc-900 dark:text-zinc-100">{{ $totalSchedules }}</p>
        </div>
    </div>

    <div class="grid gap-6 lg:grid-cols-2">
        <div class="rounded-2xl border border-zinc-200 bg-white p-5 shadow-sm dark:border-zinc-700 dark:bg-zinc-900">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-base font-semibold text-zinc-900 dark:text-zinc-100">Upcoming Events</h2>
                    <p class="mt-1 text-sm text-zinc-600 dark:text-zinc-400">Nearest scheduled events.</p>
                </div>
            </div>

            <div class="mt-4 space-y-3">
                @forelse($upcomingEvents as $event)
                    <div class="rounded-xl border border-zinc-200 p-4 dark:border-zinc-700">
                        <div class="flex items-start justify-between gap-3">
                            <div>
                                <p class="font-medium text-zinc-900 dark:text-zinc-100">{{ $event->title }}</p>
                                <p class="mt-1 text-sm text-zinc-600 dark:text-zinc-400">{{ $event->venue }}</p>
                            </div>

                            <div class="text-right">
                                <p class="text-sm font-medium text-zinc-900 dark:text-zinc-100">
                                    {{ $event->event_date?->format('M d, Y') }}
                                </p>
                                <p class="text-xs text-zinc-500 dark:text-zinc-400">
                                    {{ $event->event_date?->format('g:i A') }}
                                </p>
                            </div>
                        </div>

                        <div class="mt-3 flex items-center justify-between">
                            <span class="text-xs text-zinc-500 dark:text-zinc-400">
                                {{ $event->schedules_count }} schedule item(s)
                            </span>

                            <span class="inline-flex rounded-full px-2.5 py-1 text-xs font-medium
                                {{ $event->is_active ? 'bg-green-100 text-green-700 dark:bg-green-950/40 dark:text-green-400' : 'bg-zinc-100 text-zinc-700 dark:bg-zinc-800 dark:text-zinc-300' }}">
                                {{ $event->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </div>
                    </div>
                @empty
                    <p class="text-sm text-zinc-600 dark:text-zinc-400">No upcoming events found.</p>
                @endforelse
            </div>
        </div>

        <div class="rounded-2xl border border-zinc-200 bg-white p-5 shadow-sm dark:border-zinc-700 dark:bg-zinc-900">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-base font-semibold text-zinc-900 dark:text-zinc-100">Latest Announcements</h2>
                    <p class="mt-1 text-sm text-zinc-600 dark:text-zinc-400">Recently published updates.</p>
                </div>
            </div>

            <div class="mt-4 space-y-3">
                @forelse($latestAnnouncements as $announcement)
                    <div class="rounded-xl border border-zinc-200 p-4 dark:border-zinc-700">
                        <div class="flex items-start justify-between gap-3">
                            <div>
                                <p class="font-medium text-zinc-900 dark:text-zinc-100">{{ $announcement->title }}</p>
                                <p class="mt-1 text-sm text-zinc-600 dark:text-zinc-400">
                                    {{ \Illuminate\Support\Str::limit($announcement->body, 90) }}
                                </p>
                            </div>

                            @if($announcement->pinned)
                                <span class="inline-flex rounded-full bg-amber-100 px-2.5 py-1 text-xs font-medium text-amber-700 dark:bg-amber-950/40 dark:text-amber-400">
                                    Pinned
                                </span>
                            @endif
                        </div>

                        <p class="mt-3 text-xs text-zinc-500 dark:text-zinc-400">
                            {{ ($announcement->published_at ?? $announcement->created_at)?->format('M d, Y g:i A') }}
                        </p>
                    </div>
                @empty
                    <p class="text-sm text-zinc-600 dark:text-zinc-400">No announcements found.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
</div>
