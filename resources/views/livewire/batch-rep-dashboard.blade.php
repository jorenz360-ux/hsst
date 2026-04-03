<div>
    <div class="space-y-6 p-8">
        {{-- Header --}}
        <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
            <div>
                <h1 class="text-2xl font-bold tracking-tight text-zinc-900 dark:text-white">
                    Batch Representative Dashboard
                </h1>
                <p class="mt-1 text-sm text-zinc-600 dark:text-zinc-400">
                    Monitor your batch members, track attendance responses, review upcoming events, and stay updated with announcements.
                </p>
            </div>
        </div>

        {{-- Summary Cards --}}
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
            <div class="rounded-2xl border border-zinc-200 bg-white p-5 shadow-sm dark:border-zinc-800 dark:bg-zinc-900">
                <p class="text-sm font-medium text-zinc-500 dark:text-zinc-400">
                    Total Batch Alumni
                </p>
                <h2 class="mt-2 text-3xl font-bold text-zinc-900 dark:text-white">
                    {{ $batchAlumniCount }}
                </h2>
                <p class="mt-2 text-xs text-zinc-500 dark:text-zinc-400">
                    All alumni currently listed under your batch.
                </p>
            </div>

            <div class="rounded-2xl border border-zinc-200 bg-white p-5 shadow-sm dark:border-zinc-800 dark:bg-zinc-900">
                <p class="text-sm font-medium text-zinc-500 dark:text-zinc-400">
                    Registered Users
                </p>
                <h2 class="mt-2 text-3xl font-bold text-zinc-900 dark:text-white">
                    {{ $registeredUsersCount }}
                </h2>
                <p class="mt-2 text-xs text-zinc-500 dark:text-zinc-400">
                    Batch members who already created an account in the system.
                </p>
            </div>

            <div class="rounded-2xl border border-zinc-200 bg-white p-5 shadow-sm dark:border-zinc-800 dark:bg-zinc-900">
                <p class="text-sm font-medium text-zinc-500 dark:text-zinc-400">
                    Upcoming Events
                </p>
                <h2 class="mt-2 text-3xl font-bold text-zinc-900 dark:text-white">
                    {{ $upcomingEventsCount }}
                </h2>
                <p class="mt-2 text-xs text-zinc-500 dark:text-zinc-400">
                    Active reunion events your batch may join.
                </p>
            </div>

            <div class="rounded-2xl border border-zinc-200 bg-white p-5 shadow-sm dark:border-zinc-800 dark:bg-zinc-900">
                <p class="text-sm font-medium text-zinc-500 dark:text-zinc-400">
                    Attendance Coordination
                </p>
                <h2 class="mt-2 text-3xl font-bold text-zinc-900 dark:text-white">
                    {{ $respondedMembersCount ?? 0 }}
                </h2>
                <p class="mt-2 text-xs text-zinc-500 dark:text-zinc-400">
                    Batch members who already responded to at least one event.
                </p>
            </div>
        </div>

        {{-- Secondary Summary --}}
        <div class="grid grid-cols-1 gap-4 lg:grid-cols-3">
            <div class="rounded-2xl border border-zinc-200 bg-white p-5 shadow-sm dark:border-zinc-800 dark:bg-zinc-900 lg:col-span-1">
                <p class="text-sm font-medium text-zinc-500 dark:text-zinc-400">
                    Pending Responses
                </p>
                <h2 class="mt-2 text-3xl font-bold text-zinc-900 dark:text-white">
                    {{ $membersWithoutRsvpCount ?? 0 }}
                </h2>
                <p class="mt-2 text-xs text-zinc-500 dark:text-zinc-400">
                    Batch members who still need to confirm attendance for upcoming events.
                </p>
            </div>

            <div class="overflow-hidden rounded-2xl border border-zinc-200 bg-white shadow-sm dark:border-zinc-800 dark:bg-zinc-900 lg:col-span-2">
                <div class="border-b border-zinc-200 px-5 py-4 dark:border-zinc-800">
                    <h2 class="text-base font-semibold text-zinc-900 dark:text-white">
                        Upcoming Events
                    </h2>
                    <p class="mt-1 text-sm text-zinc-600 dark:text-zinc-400">
                        Review active events and coordinate attendance with your batch members.
                    </p>
                </div>

                <div class="divide-y divide-zinc-200 dark:divide-zinc-800">
                    @forelse ($upcomingEvents as $event)
                        <div class="flex flex-col gap-3 px-5 py-4 sm:flex-row sm:items-center sm:justify-between">
                            <div>
                                <p class="font-medium text-zinc-900 dark:text-zinc-100">
                                    {{ $event->title }}
                                </p>
                                <p class="mt-1 text-sm text-zinc-600 dark:text-zinc-400">
                                    {{ $event->venue ?? 'No venue specified' }}
                                </p>
                                <p class="mt-1 text-xs text-zinc-500 dark:text-zinc-500">
                                    Encourage your batch members to confirm attendance early.
                                </p>
                            </div>

                            <div class="text-sm text-zinc-600 dark:text-zinc-400">
                                {{ \Carbon\Carbon::parse($event->event_date)->format('M d, Y h:i A') }}
                            </div>
                        </div>
                    @empty
                        <div class="px-5 py-10 text-center text-sm text-zinc-500 dark:text-zinc-400">
                            No upcoming events found.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- Main Grid --}}
        <div class="grid grid-cols-1 gap-6 xl:grid-cols-3">
            {{-- Batch Members --}}
            <div class="overflow-hidden rounded-2xl border border-zinc-200 bg-white shadow-sm dark:border-zinc-800 dark:bg-zinc-900 xl:col-span-2">
                <div class="border-b border-zinc-200 px-5 py-4 dark:border-zinc-800">
                    <h2 class="text-base font-semibold text-zinc-900 dark:text-white">
                        Batch Members
                    </h2>
                    <p class="mt-1 text-sm text-zinc-600 dark:text-zinc-400">
                        Keep track of account availability and follow up with members for event attendance confirmation.
                    </p>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm">
                        <thead class="border-b border-zinc-200 bg-zinc-50 text-zinc-600 dark:border-zinc-800 dark:bg-zinc-950/60 dark:text-zinc-400">
                            <tr>
                                <th class="px-5 py-3 font-medium">Name</th>
                                <th class="px-5 py-3 font-medium">Email</th>
                                <th class="px-5 py-3 font-medium">Username</th>
                                <th class="px-5 py-3 font-medium">Account</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-zinc-200 dark:divide-zinc-800">
                            @forelse ($batchMembers as $member)
                                <tr class="transition hover:bg-zinc-50 dark:hover:bg-zinc-800/40">
                                    <td class="px-5 py-4 font-medium text-zinc-900 dark:text-zinc-100">
                                        {{ $member->lname }}, {{ $member->fname }}{{ $member->mname ? ' ' . $member->mname : '' }}
                                    </td>

                                    <td class="px-5 py-4 text-zinc-700 dark:text-zinc-300">
                                        {{ $member->user?->email ?? '—' }}
                                    </td>

                                    <td class="px-5 py-4 text-zinc-700 dark:text-zinc-300">
                                        {{ $member->user?->username ?? '—' }}
                                    </td>

                                    <td class="px-5 py-4">
                                        @if ($member->user)
                                            <span class="inline-flex rounded-full border border-emerald-500/20 bg-emerald-500/10 px-2.5 py-1 text-xs font-medium text-emerald-600 dark:text-emerald-400">
                                                Registered
                                            </span>
                                        @else
                                            <span class="inline-flex rounded-full border border-zinc-500/20 bg-zinc-500/10 px-2.5 py-1 text-xs font-medium text-zinc-600 dark:text-zinc-400">
                                                No Account
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-5 py-12 text-center text-sm text-zinc-500 dark:text-zinc-400">
                                        No batch members found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Announcements --}}
            <div class="overflow-hidden rounded-2xl border border-zinc-200 bg-white shadow-sm dark:border-zinc-800 dark:bg-zinc-900">
                <div class="border-b border-zinc-200 px-5 py-4 dark:border-zinc-800">
                    <h2 class="text-base font-semibold text-zinc-900 dark:text-white">
                        Announcements
                    </h2>
                    <p class="mt-1 text-sm text-zinc-600 dark:text-zinc-400">
                        Latest reminders and updates relevant to your batch.
                    </p>
                </div>

                <div class="divide-y divide-zinc-200 dark:divide-zinc-800">
                    @forelse ($announcements as $announcement)
                        <div class="px-5 py-4">
                            <p class="font-medium text-zinc-900 dark:text-zinc-100">
                                {{ $announcement->title }}
                            </p>

                            <p class="mt-2 line-clamp-3 text-sm text-zinc-600 dark:text-zinc-400">
                                {{ $announcement->content }}
                            </p>

                            <p class="mt-3 text-xs text-zinc-500 dark:text-zinc-500">
                                {{ $announcement->published_at
                                    ? \Carbon\Carbon::parse($announcement->published_at)->format('M d, Y h:i A')
                                    : $announcement->created_at->format('M d, Y h:i A') }}
                            </p>
                        </div>
                    @empty
                        <div class="px-5 py-10 text-center text-sm text-zinc-500 dark:text-zinc-400">
                            No announcements available.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- Coordination Note --}}
        <div class="rounded-2xl border border-zinc-200 bg-white p-5 shadow-sm dark:border-zinc-800 dark:bg-zinc-900">
            <h2 class="text-base font-semibold text-zinc-900 dark:text-white">
                Batch Representative Reminder
            </h2>
            <p class="mt-2 text-sm leading-6 text-zinc-600 dark:text-zinc-400">
                Use this dashboard to coordinate attendance and monitor participation from your batch. Payment collection, if needed for certain events, may be coordinated outside the system and followed up manually with your batch members.
            </p>
        </div>
    </div>
</div>