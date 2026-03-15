<div>
    <div class="space-y-6 p-6">
    {{-- Header --}}
    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
        <div>
            <p class="text-xs font-semibold uppercase tracking-[0.22em] text-teal-400">
                Admin Overview
            </p>
            <h1 class="mt-1 text-2xl font-semibold tracking-tight text-white">
                Dashboard
            </h1>
            <p class="mt-2 text-sm text-zinc-400">
                Monitor donations, events, alumni activity, and announcements in one place.
            </p>
        </div>

        <div class="flex flex-wrap gap-3">
            <a href="#"
               class="rounded-xl border border-white/10 bg-zinc-900 px-4 py-2 text-sm font-medium text-zinc-200 transition hover:bg-zinc-800">
                Create Announcement
            </a>

            <a href="#"
               class="rounded-xl bg-teal-500 px-4 py-2 text-sm font-semibold text-zinc-950 transition hover:bg-teal-400">
                Add Event
            </a>
        </div>
    </div>

    {{-- Stat Cards --}}
    <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-5">
        <div class="rounded-3xl border border-white/10 bg-white/[0.03] p-5">
            <p class="text-sm text-zinc-400">Total Donations</p>
            <div class="mt-2 text-3xl font-semibold tracking-tight text-white">
                ₱{{ number_format($allDonationsTotal / 100, 2) }}
            </div>
            <p class="mt-2 text-sm text-teal-400">All paid donations</p>
        </div>

        <div class="rounded-3xl border border-white/10 bg-white/[0.03] p-5">
            <p class="text-sm text-zinc-400">This Month</p>
            <div class="mt-2 text-3xl font-semibold tracking-tight text-white">
                ₱{{ number_format($donationsThisMonth / 100, 2) }}
            </div>
            <p class="mt-2 text-sm text-teal-400">{{ now()->format('F Y') }}</p>
        </div>

        <div class="rounded-3xl border border-white/10 bg-white/[0.03] p-5">
            <p class="text-sm text-zinc-400">Upcoming Events</p>
            <div class="mt-2 text-3xl font-semibold tracking-tight text-white">
                {{ $upcomingEventsCount }}
            </div>
            <p class="mt-2 text-sm text-cyan-400">Active scheduled events</p>
        </div>

        <div class="rounded-3xl border border-white/10 bg-white/[0.03] p-5">
            <p class="text-sm text-zinc-400">Alumni</p>
            <div class="mt-2 text-3xl font-semibold tracking-tight text-white">
                {{ number_format($totalAlumni) }}
            </div>
            <p class="mt-2 text-sm text-zinc-400">Registered alumni profiles</p>
        </div>

        <div class="rounded-3xl border border-white/10 bg-white/[0.03] p-5">
            <p class="text-sm text-zinc-400">Published Posts</p>
            <div class="mt-2 text-3xl font-semibold tracking-tight text-white">
                {{ $publishedAnnouncementsCount }}
            </div>
            <p class="mt-2 text-sm text-amber-300">Visible announcements</p>
        </div>
    </div>

    <div class="grid gap-6 xl:grid-cols-[1.35fr_0.65fr]">
        <div class="space-y-6">
            {{-- Latest Payments --}}
            <section class="rounded-3xl border border-white/10 bg-white/[0.03] p-5">
                <div class="mb-4 flex items-center justify-between">
                    <div>
                        <h2 class="text-lg font-semibold text-white">Latest Payments</h2>
                        <p class="text-sm text-zinc-400">Most recent paid donations</p>
                    </div>
                </div>

                <div class="overflow-hidden rounded-2xl border border-white/10">
                    <table class="w-full text-left text-sm">
                        <thead class="bg-zinc-900/80 text-zinc-400">
                            <tr>
                                <th class="px-4 py-3 font-medium">Donor</th>
                                <th class="px-4 py-3 font-medium">Amount</th>
                                <th class="px-4 py-3 font-medium">Paid At</th>
                                <th class="px-4 py-3 font-medium">Reference</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($latestPayments as $payment)
                                <tr class="border-t border-white/10">
                                    <td class="px-4 py-3 text-white">
                                        {{ trim(($payment->alumni->fname ?? '') . ' ' . ($payment->alumni->lname ?? '')) ?: 'Unknown Donor' }}
                                    </td>
                                    <td class="px-4 py-3 text-zinc-300">
                                        ₱{{ number_format($payment->amount / 100, 2) }}
                                    </td>
                                    <td class="px-4 py-3 text-zinc-400">
                                        {{ optional($payment->paid_at)->format('M d, Y h:i A') }}
                                    </td>
                                    <td class="px-4 py-3 text-zinc-500">
                                        {{ $payment->paymongo_checkout_session_id ?: '—' }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-4 py-6 text-center text-zinc-500">
                                        No paid donations yet.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </section>

            {{-- Donations List --}}
            <section class="rounded-3xl border border-white/10 bg-white/[0.03] p-5">
                <div class="mb-4 flex items-center justify-between">
                    <div>
                        <h2 class="text-lg font-semibold text-white">Donations</h2>
                        <p class="text-sm text-zinc-400">Paginated paid donation records</p>
                    </div>
                </div>

                <div class="overflow-hidden rounded-2xl border border-white/10">
                    <table class="w-full text-left text-sm">
                        <thead class="bg-zinc-900/80 text-zinc-400">
                            <tr>
                                <th class="px-4 py-3 font-medium">Donor</th>
                                <th class="px-4 py-3 font-medium">Amount</th>
                                <th class="px-4 py-3 font-medium">Remarks</th>
                                <th class="px-4 py-3 font-medium">Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($donations as $donation)
                                <tr class="border-t border-white/10">
                                    <td class="px-4 py-3 text-white">
                                        {{ trim(($donation->alumni->fname ?? '') . ' ' . ($donation->alumni->lname ?? '')) ?: 'Unknown Donor' }}
                                    </td>
                                    <td class="px-4 py-3 text-zinc-300">
                                        ₱{{ number_format($donation->amount / 100, 2) }}
                                    </td>
                                    <td class="px-4 py-3 text-zinc-400">
                                        {{ $donation->remarks ?: '—' }}
                                    </td>
                                    <td class="px-4 py-3 text-zinc-400">
                                        {{ optional($donation->paid_at)->format('M d, Y') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-4 py-6 text-center text-zinc-500">
                                        No donation records found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $donations->links() }}
                </div>
            </section>

            {{-- Recent Announcements --}}
            <section class="rounded-3xl border border-white/10 bg-white/[0.03] p-5">
                <div class="mb-4 flex items-center justify-between">
                    <div>
                        <h2 class="text-lg font-semibold text-white">Recent Announcements</h2>
                        <p class="text-sm text-zinc-400">Latest content updates</p>
                    </div>
                </div>

                <div class="space-y-3">
                    @forelse ($recentAnnouncements as $announcement)
                        <div class="rounded-2xl border border-white/10 bg-zinc-900/70 p-4">
                            <div class="flex items-start justify-between gap-3">
                                <div>
                                    <h3 class="font-medium text-white">{{ $announcement->title }}</h3>
                                    <p class="mt-1 text-sm text-zinc-400">
                                        {{ $announcement->published_at?->format('M d, Y h:i A') ?? $announcement->created_at?->format('M d, Y h:i A') }}
                                    </p>
                                </div>

                                <div class="flex gap-2">
                                    @if($announcement->pinned)
                                        <span class="rounded-full border border-amber-500/20 bg-amber-500/10 px-2.5 py-1 text-xs text-amber-300">
                                            Pinned
                                        </span>
                                    @endif

                                    @if($announcement->is_published)
                                        <span class="rounded-full border border-teal-500/20 bg-teal-500/10 px-2.5 py-1 text-xs text-teal-300">
                                            Published
                                        </span>
                                    @else
                                        <span class="rounded-full border border-zinc-700 bg-zinc-800 px-2.5 py-1 text-xs text-zinc-300">
                                            Draft
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="rounded-2xl border border-white/10 bg-zinc-900/70 p-4 text-sm text-zinc-500">
                            No announcements yet.
                        </div>
                    @endforelse
                </div>
            </section>
        </div>

        {{-- Right Sidebar --}}
        <aside class="space-y-6">
            {{-- Upcoming Events --}}
            <section class="rounded-3xl border border-white/10 bg-white/[0.03] p-5">
                <div class="mb-4 flex items-center justify-between">
                    <div>
                        <h2 class="text-lg font-semibold text-white">Upcoming Events</h2>
                        <p class="text-sm text-zinc-400">Next active scheduled activities</p>
                    </div>
                </div>

                <div class="space-y-4">
                    @forelse ($upcomingEvents as $event)
                        <div class="rounded-2xl border border-white/10 bg-zinc-900/70 p-4">
                            <div class="flex items-start justify-between gap-3">
                                <div>
                                    <h3 class="font-medium text-white">{{ $event->title }}</h3>
                                    <p class="mt-1 text-sm text-zinc-400">{{ $event->venue ?: 'No venue set' }}</p>
                                </div>
                                <span class="rounded-full bg-cyan-500/10 px-2.5 py-1 text-xs text-cyan-300">
                                    {{ optional($event->event_date)->format('M d, Y') }}
                                </span>
                            </div>

                            <div class="mt-4 grid grid-cols-2 gap-3 text-sm">
                                <div class="rounded-xl border border-white/10 p-3">
                                    <p class="text-zinc-500">Dress Code</p>
                                    <p class="mt-1 font-medium text-white">
                                        {{ $event->dress_code ?: '—' }}
                                    </p>
                                </div>

                                <div class="rounded-xl border border-white/10 p-3">
                                    <p class="text-zinc-500">Fee</p>
                                    <p class="mt-1 font-medium text-white">
                                        ₱{{ number_format(($event->registration_fee ?? 0) / 100, 2) }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="rounded-2xl border border-white/10 bg-zinc-900/70 p-4 text-sm text-zinc-500">
                            No upcoming events found.
                        </div>
                    @endforelse
                </div>
            </section>

            {{-- Quick System Summary --}}
            <section class="rounded-3xl border border-white/10 bg-gradient-to-br from-teal-500/20 to-cyan-500/10 p-5">
                <h2 class="text-lg font-semibold text-white">System Summary</h2>
                <p class="mt-1 text-sm text-zinc-300">Current records across core modules</p>

                <div class="mt-4 space-y-3">
                    <div class="rounded-2xl border border-white/10 bg-zinc-950/60 p-4">
                        <p class="text-sm text-zinc-400">Users</p>
                        <p class="mt-1 text-xl font-semibold text-white">{{ number_format($totalUsers) }}</p>
                    </div>

                    <div class="rounded-2xl border border-white/10 bg-zinc-950/60 p-4">
                        <p class="text-sm text-zinc-400">Batches</p>
                        <p class="mt-1 text-xl font-semibold text-white">{{ number_format($totalBatches) }}</p>
                    </div>

                    <div class="rounded-2xl border border-white/10 bg-zinc-950/60 p-4">
                        <p class="text-sm text-zinc-400">Alumni Profiles</p>
                        <p class="mt-1 text-xl font-semibold text-white">{{ number_format($totalAlumni) }}</p>
                    </div>
                </div>
            </section>
        </aside>
    </div>
</div>
</div>