<div>
<div class="mx-auto max-w-7xl space-y-6 p-6">
    {{-- Header --}}
    <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
        <div>
            <p class="text-xs font-semibold uppercase tracking-[0.22em] text-teal-400">
                Batch Representative Portal
            </p>
            <h1 class="mt-1 text-3xl font-semibold tracking-tight text-zinc-900 dark:text-white">
                My Batch Overview
            </h1>
            <p class="mt-2 max-w-2xl text-sm text-zinc-600 dark:text-zinc-400">
                Track your batch members, upcoming events, announcements, and contribution activity in one place.
            </p>
        </div>

        <div class="flex flex-wrap gap-3">
            <a
                href="#batch-members"
                class="inline-flex items-center justify-center rounded-2xl border border-zinc-200 bg-white px-4 py-2.5 text-sm font-medium text-zinc-700 shadow-sm transition hover:bg-zinc-50 dark:border-white/10 dark:bg-zinc-900 dark:text-zinc-200 dark:hover:bg-zinc-800"
            >
                View Members
            </a>

            <a
                href="#upcoming-events"
                class="inline-flex items-center justify-center rounded-2xl bg-teal-500 px-4 py-2.5 text-sm font-semibold text-zinc-950 shadow-sm transition hover:bg-teal-400"
            >
                Upcoming Events
            </a>
        </div>
    </div>

    {{-- Summary Cards --}}
    <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-6">
        <div class="rounded-3xl border border-zinc-200 bg-white p-5 shadow-sm dark:border-white/10 dark:bg-white/[0.03]">
            <p class="text-sm text-zinc-500 dark:text-zinc-400">Batch Alumni</p>
            <div class="mt-2 text-3xl font-semibold tracking-tight text-zinc-900 dark:text-white">
                {{ number_format($batchAlumniCount) }}
            </div>
            <p class="mt-2 text-sm text-zinc-500 dark:text-zinc-400">Total members in your batch</p>
        </div>

        <div class="rounded-3xl border border-zinc-200 bg-white p-5 shadow-sm dark:border-white/10 dark:bg-white/[0.03]">
            <p class="text-sm text-zinc-500 dark:text-zinc-400">Registered Accounts</p>
            <div class="mt-2 text-3xl font-semibold tracking-tight text-zinc-900 dark:text-white">
                {{ number_format($registeredUsersCount) }}
            </div>
            <p class="mt-2 text-sm text-zinc-500 dark:text-zinc-400">Members with system accounts</p>
        </div>

        <div class="rounded-3xl border border-zinc-200 bg-white p-5 shadow-sm dark:border-white/10 dark:bg-white/[0.03]">
            <p class="text-sm text-zinc-500 dark:text-zinc-400">Batch Reps</p>
            <div class="mt-2 text-3xl font-semibold tracking-tight text-zinc-900 dark:text-white">
                {{ number_format($batchRepCount) }}
            </div>
            <p class="mt-2 text-sm text-zinc-500 dark:text-zinc-400">Assigned representatives</p>
        </div>

        <div class="rounded-3xl border border-zinc-200 bg-white p-5 shadow-sm dark:border-white/10 dark:bg-white/[0.03]">
            <p class="text-sm text-zinc-500 dark:text-zinc-400">Upcoming Events</p>
            <div class="mt-2 text-3xl font-semibold tracking-tight text-zinc-900 dark:text-white">
                {{ number_format($upcomingEventsCount) }}
            </div>
            <p class="mt-2 text-sm text-cyan-500 dark:text-cyan-400">Open active events</p>
        </div>

        <div class="rounded-3xl border border-zinc-200 bg-white p-5 shadow-sm dark:border-white/10 dark:bg-white/[0.03]">
            <p class="text-sm text-zinc-500 dark:text-zinc-400">Total Donations</p>
            <div class="mt-2 text-3xl font-semibold tracking-tight text-zinc-900 dark:text-white">
                ₱{{ number_format($batchDonationTotal / 100, 2) }}
            </div>
            <p class="mt-2 text-sm text-teal-500 dark:text-teal-400">From your batch</p>
        </div>

        <div class="rounded-3xl border border-zinc-200 bg-white p-5 shadow-sm dark:border-white/10 dark:bg-white/[0.03]">
            <p class="text-sm text-zinc-500 dark:text-zinc-400">This Month</p>
            <div class="mt-2 text-3xl font-semibold tracking-tight text-zinc-900 dark:text-white">
                ₱{{ number_format($batchDonationsThisMonth / 100, 2) }}
            </div>
            <p class="mt-2 text-sm text-teal-500 dark:text-teal-400">{{ now()->format('F Y') }}</p>
        </div>
    </div>

    <div class="grid gap-6 xl:grid-cols-[1.35fr_0.65fr]">
        <div class="space-y-6">
            {{-- Batch Members --}}
            <section id="batch-members" class="overflow-hidden rounded-3xl border border-zinc-200 bg-white shadow-sm dark:border-white/10 dark:bg-white/[0.03]">
                <div class="flex flex-col gap-3 border-b border-zinc-200 px-5 py-4 dark:border-white/10 md:flex-row md:items-center md:justify-between">
                    <div>
                        <h2 class="text-lg font-semibold text-zinc-900 dark:text-white">Batch Members</h2>
                        <p class="text-sm text-zinc-600 dark:text-zinc-400">
                            A quick view of alumni under your assigned batch.
                        </p>
                    </div>
                </div>

                <div class="hidden overflow-x-auto lg:block">
                    <table class="min-w-full text-left text-sm">
                        <thead class="bg-zinc-50 text-zinc-600 dark:bg-zinc-900/70 dark:text-zinc-300">
                            <tr>
                                <th class="px-5 py-4 text-xs font-semibold uppercase tracking-[0.14em]">Member</th>
                                <th class="px-5 py-4 text-xs font-semibold uppercase tracking-[0.14em]">Account</th>
                                <th class="px-5 py-4 text-xs font-semibold uppercase tracking-[0.14em]">Email</th>
                                <th class="px-5 py-4 text-xs font-semibold uppercase tracking-[0.14em]">Representative</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-zinc-100 dark:divide-white/10">
                            @forelse ($batchMembers as $member)
                                <tr class="transition hover:bg-zinc-50/80 dark:hover:bg-white/[0.03]">
                                    <td class="px-5 py-4">
                                        <div class="font-medium text-zinc-900 dark:text-white">
                                            {{ trim($member->fname . ' ' . $member->lname) }}
                                        </div>
                                        @if($member->mname)
                                            <div class="mt-1 text-xs text-zinc-500 dark:text-zinc-400">
                                                {{ $member->mname }}
                                            </div>
                                        @endif
                                    </td>
                                    <td class="px-5 py-4">
                                        @if($member->user)
                                            <span class="inline-flex items-center rounded-full border border-teal-500/20 bg-teal-500/10 px-2.5 py-1 text-xs font-medium text-teal-300">
                                                Registered
                                            </span>
                                        @else
                                            <span class="inline-flex items-center rounded-full border border-zinc-200 bg-zinc-100 px-2.5 py-1 text-xs font-medium text-zinc-600 dark:border-zinc-700 dark:bg-zinc-800 dark:text-zinc-300">
                                                No Account
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-5 py-4 text-zinc-600 dark:text-zinc-400">
                                        {{ $member->user?->email ?? '—' }}
                                    </td>
                                    <td class="px-5 py-4">
                                        @if($member->is_batch_rep)
                                            <span class="inline-flex items-center rounded-full border border-cyan-500/20 bg-cyan-500/10 px-2.5 py-1 text-xs font-medium text-cyan-300">
                                                Yes
                                            </span>
                                        @else
                                            <span class="inline-flex items-center rounded-full border border-zinc-200 bg-zinc-100 px-2.5 py-1 text-xs font-medium text-zinc-600 dark:border-zinc-700 dark:bg-zinc-800 dark:text-zinc-300">
                                                No
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-12 text-center text-sm text-zinc-500 dark:text-zinc-400">
                                        No batch members found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Mobile --}}
                <div class="space-y-4 p-4 lg:hidden">
                    @forelse ($batchMembers as $member)
                        <div class="rounded-2xl border border-zinc-200 bg-white p-4 shadow-sm dark:border-white/10 dark:bg-zinc-950/60">
                            <div class="font-medium text-zinc-900 dark:text-white">
                                {{ trim($member->fname . ' ' . $member->lname) }}
                            </div>

                            <div class="mt-3 space-y-2 text-sm">
                                <div class="text-zinc-600 dark:text-zinc-400">
                                    <span class="font-medium text-zinc-800 dark:text-zinc-200">Email:</span>
                                    {{ $member->user?->email ?? '—' }}
                                </div>

                                <div class="flex flex-wrap gap-2">
                                    @if($member->user)
                                        <span class="inline-flex items-center rounded-full border border-teal-500/20 bg-teal-500/10 px-2.5 py-1 text-xs font-medium text-teal-300">
                                            Registered
                                        </span>
                                    @else
                                        <span class="inline-flex items-center rounded-full border border-zinc-200 bg-zinc-100 px-2.5 py-1 text-xs font-medium text-zinc-600 dark:border-zinc-700 dark:bg-zinc-800 dark:text-zinc-300">
                                            No Account
                                        </span>
                                    @endif

                                    @if($member->is_batch_rep)
                                        <span class="inline-flex items-center rounded-full border border-cyan-500/20 bg-cyan-500/10 px-2.5 py-1 text-xs font-medium text-cyan-300">
                                            Batch Rep
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="rounded-2xl border border-zinc-200 bg-white p-8 text-center dark:border-white/10 dark:bg-zinc-950/60">
                            <h3 class="text-lg font-semibold text-zinc-900 dark:text-white">No batch members found</h3>
                        </div>
                    @endforelse
                </div>
            </section>

            {{-- Announcements --}}
            <section class="rounded-3xl border border-zinc-200 bg-white p-5 shadow-sm dark:border-white/10 dark:bg-white/[0.03]">
                <div class="mb-4">
                    <h2 class="text-lg font-semibold text-zinc-900 dark:text-white">Recent Announcements</h2>
                    <p class="text-sm text-zinc-600 dark:text-zinc-400">
                        Important updates you can relay to your batch.
                    </p>
                </div>

                <div class="space-y-3">
                    @forelse ($announcements as $announcement)
                        <div class="rounded-2xl border border-zinc-200 bg-zinc-50 p-4 dark:border-white/10 dark:bg-zinc-900/70">
                            <div class="flex items-start justify-between gap-3">
                                <div>
                                    <h3 class="font-medium text-zinc-900 dark:text-white">
                                        {{ $announcement->title }}
                                    </h3>
                                    <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">
                                        {{ $announcement->published_at?->format('M d, Y h:i A') ?? $announcement->created_at?->format('M d, Y h:i A') }}
                                    </p>
                                </div>

                                <div class="flex gap-2">
                                    @if($announcement->pinned)
                                        <span class="inline-flex items-center rounded-full border border-amber-500/20 bg-amber-500/10 px-2.5 py-1 text-xs font-medium text-amber-300">
                                            Pinned
                                        </span>
                                    @endif

                                    <span class="inline-flex items-center rounded-full border border-teal-500/20 bg-teal-500/10 px-2.5 py-1 text-xs font-medium text-teal-300">
                                        Published
                                    </span>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="rounded-2xl border border-zinc-200 bg-zinc-50 p-4 text-sm text-zinc-500 dark:border-white/10 dark:bg-zinc-900/70 dark:text-zinc-400">
                            No announcements available.
                        </div>
                    @endforelse
                </div>
            </section>
        </div>

        {{-- Sidebar --}}
        <aside class="space-y-6">
            {{-- Upcoming Events --}}
            <section id="upcoming-events" class="rounded-3xl border border-zinc-200 bg-white p-5 shadow-sm dark:border-white/10 dark:bg-white/[0.03]">
                <div class="mb-4">
                    <h2 class="text-lg font-semibold text-zinc-900 dark:text-white">Upcoming Events</h2>
                    <p class="text-sm text-zinc-600 dark:text-zinc-400">
                        Events your batch should prepare for.
                    </p>
                </div>

                <div class="space-y-4">
                    @forelse ($upcomingEvents as $event)
                        <div class="rounded-2xl border border-zinc-200 bg-zinc-50 p-4 dark:border-white/10 dark:bg-zinc-900/70">
                            <div class="flex items-start justify-between gap-3">
                                <div>
                                    <h3 class="font-medium text-zinc-900 dark:text-white">{{ $event->title }}</h3>
                                    <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">{{ $event->venue ?: 'No venue set' }}</p>
                                </div>
                                <span class="rounded-full bg-cyan-500/10 px-2.5 py-1 text-xs font-medium text-cyan-300">
                                    {{ optional($event->event_date)->format('M d, Y') }}
                                </span>
                            </div>

                            <div class="mt-4 grid grid-cols-2 gap-3 text-sm">
                                <div class="rounded-xl border border-zinc-200 bg-white p-3 dark:border-white/10 dark:bg-zinc-950/60">
                                    <p class="text-zinc-500 dark:text-zinc-400">Dress Code</p>
                                    <p class="mt-1 font-medium text-zinc-900 dark:text-white">
                                        {{ $event->dress_code ?: '—' }}
                                    </p>
                                </div>

                                <div class="rounded-xl border border-zinc-200 bg-white p-3 dark:border-white/10 dark:bg-zinc-950/60">
                                    <p class="text-zinc-500 dark:text-zinc-400">Fee</p>
                                    <p class="mt-1 font-medium text-zinc-900 dark:text-white">
                                        ₱{{ number_format(($event->registration_fee ?? 0) / 100, 2) }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="rounded-2xl border border-zinc-200 bg-zinc-50 p-4 text-sm text-zinc-500 dark:border-white/10 dark:bg-zinc-900/70 dark:text-zinc-400">
                            No upcoming events found.
                        </div>
                    @endforelse
                </div>
            </section>

            {{-- Quick Actions --}}
            <section class="rounded-3xl border border-zinc-200 bg-gradient-to-br from-teal-500/15 to-cyan-500/10 p-5 shadow-sm dark:border-white/10">
                <h2 class="text-lg font-semibold text-zinc-900 dark:text-white">Quick Actions</h2>
                <p class="mt-1 text-sm text-zinc-600 dark:text-zinc-300">
                    Useful shortcuts for batch coordination.
                </p>

                <div class="mt-4 grid gap-3">
                    <a href="#batch-members" class="rounded-2xl border border-white/10 bg-zinc-950/70 px-4 py-3 text-sm font-medium text-zinc-200 transition hover:bg-zinc-900">
                        View Batch Members
                    </a>
                    <a href="#upcoming-events" class="rounded-2xl border border-white/10 bg-zinc-950/70 px-4 py-3 text-sm font-medium text-zinc-200 transition hover:bg-zinc-900">
                        Check Events
                    </a>
                    <a href="#contact" class="rounded-2xl border border-white/10 bg-zinc-950/70 px-4 py-3 text-sm font-medium text-zinc-200 transition hover:bg-zinc-900">
                        Contact Admin
                    </a>
                </div>
            </section>
        </aside>
    </div>
</div>
</div>
