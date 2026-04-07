<div>
<div class="min-h-screen bg-[#F7F6F2] text-stone-900">
    <div class="space-y-8 p-6">

        {{-- Hero Header --}}
        <section class="overflow-hidden rounded-xl border border-[#E8E5DC] bg-gradient-to-br from-white via-[#F7F6F2] to-indigo-50/50 shadow-sm">
            <div class="flex flex-col gap-6 px-6 py-6 lg:flex-row lg:items-end lg:justify-between">
                <div class="max-w-2xl">
                    <p class="text-xs font-semibold uppercase tracking-[0.24em] text-indigo-600">
                        Admin Control Panel
                    </p>
                    <h1 class="mt-2 text-3xl font-bold tracking-tight text-stone-900 sm:text-4xl">
                        Dashboard
                    </h1>
                    <p class="mt-3 text-sm leading-6 text-stone-500">
                        Manage donations, alumni activity, events, and announcements from one central workspace.
                    </p>
                </div>

                <div class="flex flex-wrap gap-3">
                    <a
                        href="#"
                        class="inline-flex items-center gap-2 rounded-xl border border-[#E8E5DC] bg-white px-4 py-2.5 text-sm font-medium text-stone-700 shadow-sm transition hover:bg-[#F7F6F2]"
                    >
                        <flux:icon name="megaphone" class="h-4 w-4" />
                        Create Announcement
                    </a>

                   <flux:button
                    icon="plus"
                      variant="primary"
                      color="orange"
                >
                    Add Event
                </flux:button>
                </div>
            </div>
        </section>

        {{-- Stat Cards --}}
        <section class="grid gap-4 sm:grid-cols-2 xl:grid-cols-5">
            <div class="rounded-xl border border-[#E8E5DC] bg-white p-5 shadow-sm">
                <p class="text-sm text-stone-500">Total Donations</p>
                <div class="mt-2 text-3xl font-semibold tracking-tight text-stone-900">
                    ₱{{ number_format($allDonationsTotal) }}
                </div>
                <p class="mt-2 text-sm text-indigo-600">All paid donations</p>
            </div>

            <div class="rounded-xl border border-[#E8E5DC] bg-white p-5 shadow-sm">
                <p class="text-sm text-stone-500">This Month</p>
                <div class="mt-2 text-3xl font-semibold tracking-tight text-stone-900">
                    ₱{{ number_format($donationsThisMonth) }}
                </div>
                <p class="mt-2 text-sm text-violet-600">{{ now()->format('F Y') }}</p>
            </div>

            <div class="rounded-xl border border-[#E8E5DC] bg-white p-5 shadow-sm">
                <p class="text-sm text-stone-500">Upcoming Events</p>
                <div class="mt-2 text-3xl font-semibold tracking-tight text-stone-900">
                    {{ $upcomingEventsCount }}
                </div>
                <p class="mt-2 text-sm text-sky-600">Active scheduled events</p>
            </div>

            <div class="rounded-xl border border-[#E8E5DC] bg-white p-5 shadow-sm">
                <p class="text-sm text-stone-500">Alumni</p>
                <div class="mt-2 text-3xl font-semibold tracking-tight text-stone-900">
                    {{ number_format($totalAlumni) }}
                </div>
                <p class="mt-2 text-sm text-emerald-600">Registered alumni profiles</p>
            </div>

            <div class="rounded-xl border border-[#E8E5DC] bg-white p-5 shadow-sm">
                <p class="text-sm text-stone-500">Published Posts</p>
                <div class="mt-2 text-3xl font-semibold tracking-tight text-stone-900">
                    {{ $publishedAnnouncementsCount }}
                </div>
                <p class="mt-2 text-sm text-rose-500">Visible announcements</p>
            </div>
        </section>

        <div class="grid gap-6 xl:grid-cols-[1.35fr_0.65fr]">
            <div class="space-y-6">

                {{-- Latest Payments --}}
                <section class="overflow-hidden rounded-xl border border-[#E8E5DC] bg-white shadow-sm">
                    <div class="flex items-center justify-between border-b border-[#EDE9E0] px-6 py-4">
                        <div>
                            <h2 class="text-lg font-semibold text-stone-900">Latest Payments</h2>
                            <p class="text-sm text-stone-500">Most recent paid donations</p>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm">
                            <thead class="border-b border-[#EDE9E0] bg-[#F7F6F2] text-stone-500">
                                <tr>
                                    <th class="px-4 py-3 font-medium">Donor</th>
                                    <th class="px-4 py-3 font-medium">Amount</th>
                                    <th class="px-4 py-3 font-medium">Paid At</th>
                                    <th class="px-4 py-3 font-medium">Reference</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-[#EDE9E0]">
                                @forelse ($latestPayments as $payment)
                                    <tr class="transition hover:bg-[#F7F6F2]">
                                        <td class="px-4 py-3 text-stone-900">
                                            {{ trim(($payment->alumni->fname ?? '') . ' ' . ($payment->alumni->lname ?? '')) ?: 'Unknown Donor' }}
                                        </td>
                                        <td class="px-4 py-3 text-stone-700">
                                            ₱{{ number_format($payment->amount) }}
                                        </td>
                                        <td class="px-4 py-3 text-stone-500">
                                            {{ optional($payment->paid_at)->format('M d, Y h:i A') }}
                                        </td>
                                        <td class="px-4 py-3 text-stone-400">
                                            {{ $payment->paymongo_checkout_session_id ?: '—' }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-4 py-8 text-center text-stone-400">
                                            No paid donations yet.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </section>

                {{-- Donations --}}
                <section class="overflow-hidden rounded-xl border border-[#E8E5DC] bg-white shadow-sm">
                    <div class="flex items-center justify-between border-b border-[#EDE9E0] px-6 py-4">
                        <div>
                            <h2 class="text-lg font-semibold text-stone-900">Donations</h2>
                            <p class="text-sm text-stone-500">Paginated paid donation records</p>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm">
                            <thead class="border-b border-[#EDE9E0] bg-[#F7F6F2] text-stone-500">
                                <tr>
                                    <th class="px-4 py-3 font-medium">Donor</th>
                                    <th class="px-4 py-3 font-medium">Amount</th>
                                    <th class="px-4 py-3 font-medium">Remarks</th>
                                    <th class="px-4 py-3 font-medium">Date</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-[#EDE9E0]">
                                @forelse ($donations as $donation)
                                    <tr class="transition hover:bg-[#F7F6F2]">
                                        <td class="px-4 py-3 text-stone-900">
                                            {{ trim(($donation->alumni->fname ?? '') . ' ' . ($donation->alumni->lname ?? '')) ?: 'Unknown Donor' }}
                                        </td>
                                        <td class="px-4 py-3 text-stone-700">
                                            ₱{{ number_format($donation->amount) }}
                                        </td>
                                        <td class="px-4 py-3 text-stone-500">
                                            {{ $donation->remarks ?: '—' }}
                                        </td>
                                        <td class="px-4 py-3 text-stone-500">
                                            {{ optional($donation->paid_at)->format('M d, Y') }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-4 py-8 text-center text-stone-400">
                                            No donation records found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="border-t border-[#EDE9E0] px-6 py-4">
                        {{ $donations->links() }}
                    </div>
                </section>

                {{-- Recent Announcements --}}
                <section class="rounded-xl border border-[#E8E5DC] bg-white shadow-sm">
                    <div class="flex items-center justify-between border-b border-[#EDE9E0] px-6 py-4">
                        <div>
                            <h2 class="text-lg font-semibold text-stone-900">Recent Announcements</h2>
                            <p class="text-sm text-stone-500">Latest content updates</p>
                        </div>
                    </div>

                    <div class="space-y-3 p-5">
                        @forelse ($recentAnnouncements as $announcement)
                            <div class="rounded-xl border border-[#EDE9E0] bg-[#F7F6F2] p-4">
                                <div class="flex items-start justify-between gap-3">
                                    <div>
                                        <h3 class="font-medium text-stone-900">{{ $announcement->title }}</h3>
                                        <p class="mt-1 text-sm text-stone-500">
                                            {{ $announcement->published_at?->format('M d, Y h:i A') ?? $announcement->created_at?->format('M d, Y h:i A') }}
                                        </p>
                                    </div>

                                    <div class="flex flex-wrap gap-2">
                                        @if($announcement->pinned)
                                            <span class="inline-flex items-center gap-1 rounded-full border border-indigo-200 bg-indigo-50 px-2.5 py-1 text-xs text-indigo-600">
                                                <flux:icon name="bookmark" class="h-3.5 w-3.5" />
                                                Pinned
                                            </span>
                                        @endif

                                        @if($announcement->is_published)
                                            <span class="inline-flex items-center gap-1 rounded-full border border-emerald-200 bg-emerald-50 px-2.5 py-1 text-xs text-emerald-600">
                                                <flux:icon name="check" class="h-3.5 w-3.5" />
                                                Published
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1 rounded-full border border-[#E8E5DC] bg-[#EDE9E0] px-2.5 py-1 text-xs text-stone-500">
                                                <flux:icon name="document-text" class="h-3.5 w-3.5" />
                                                Draft
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="rounded-xl border border-[#EDE9E0] bg-[#F7F6F2] p-4 text-sm text-stone-400">
                                No announcements yet.
                            </div>
                        @endforelse
                    </div>
                </section>
            </div>

            {{-- Sidebar --}}
            <aside class="space-y-6">
                <section class="rounded-[24px] border border-[#E8E5DC] bg-white shadow-sm">
                    <div class="flex items-center justify-between border-b border-[#EDE9E0] px-6 py-4">
                        <div>
                            <h2 class="text-lg font-semibold text-stone-900">Upcoming Events</h2>
                            <p class="text-sm text-stone-500">Next active scheduled activities</p>
                        </div>
                    </div>

                    <div class="space-y-4 p-5">
                        @forelse ($upcomingEvents as $event)
                            <div class="rounded-xl border border-[#EDE9E0] bg-[#F7F6F2] p-4">
                                <div class="flex items-start justify-between gap-3">
                                    <div>
                                        <h3 class="font-medium text-stone-900">{{ $event->title }}</h3>
                                        <p class="mt-1 text-sm text-stone-500">{{ $event->venue ?: 'No venue set' }}</p>
                                    </div>

                                    <span class="inline-flex items-center rounded-full border border-violet-200 bg-violet-50 px-2.5 py-1 text-xs text-violet-600">
                                        {{ optional($event->event_date)->format('M d, Y') }}
                                    </span>
                                </div>

                                <div class="mt-4 grid grid-cols-2 gap-3 text-sm">
                                    <div class="rounded-xl border border-[#E8E5DC] bg-white p-3">
                                        <p class="text-stone-400">Dress Code</p>
                                        <p class="mt-1 font-medium text-stone-900">{{ $event->dress_code ?: '—' }}</p>
                                    </div>

                                    <div class="rounded-xl border border-[#E8E5DC] bg-white p-3">
                                        <p class="text-stone-400">Fee</p>
                                        <p class="mt-1 font-medium text-indigo-600">
                                            ₱{{ number_format(($event->registration_fee ?? 0) / 100, 2) }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="rounded-xl border border-[#EDE9E0] bg-[#F7F6F2] p-4 text-sm text-stone-400">
                                No upcoming events found.
                            </div>
                        @endforelse
                    </div>
                </section>

                <section class="overflow-hidden rounded-[24px] border border-[#E8E5DC] bg-white shadow-sm">
                    <div class="border-b border-[#EDE9E0] px-6 py-4">
                        <h2 class="text-lg font-semibold text-stone-900">System Summary</h2>
                        <p class="mt-1 text-sm text-stone-500">Current records across core modules</p>
                    </div>

                    <div class="space-y-3 p-5">
                        <div class="rounded-xl border border-[#EDE9E0] bg-[#F7F6F2] p-4">
                            <p class="text-sm text-stone-500">Users</p>
                            <p class="mt-1 text-xl font-semibold text-stone-900">{{ number_format($totalUsers) }}</p>
                        </div>

                        <div class="rounded-xl border border-[#EDE9E0] bg-[#F7F6F2] p-4">
                            <p class="text-sm text-stone-500">Batches</p>
                            <p class="mt-1 text-xl font-semibold text-stone-900">{{ number_format($totalBatches) }}</p>
                        </div>

                        <div class="rounded-xl border border-[#EDE9E0] bg-[#F7F6F2] p-4">
                            <p class="text-sm text-stone-500">Alumni Profiles</p>
                            <p class="mt-1 text-xl font-semibold text-stone-900">{{ number_format($totalAlumni) }}</p>
                        </div>
                    </div>
                </section>
            </aside>
        </div>
    </div>
</div>


</div>
