<div>
    <div class="mx-auto max-w-7xl bg-white dark:bg-zinc-900">
        <div class="space-y-1 pb-24 sm:space-y-5 sm:px-5 sm:py-5 sm:pb-5 lg:space-y-6 lg:px-6 lg:py-6">

            {{-- Header / Hero --}}
            <section class="w-full border-b border-zinc-200 px-4 py-6 dark:border-white/10 sm:overflow-hidden sm:rounded-3xl sm:border sm:bg-white sm:px-6 sm:py-6 sm:shadow-sm dark:sm:bg-white/[0.04]">
                <div class="flex flex-col gap-5 lg:flex-row lg:items-end lg:justify-between">
                    <div class="min-w-0">
                        <p class="text-[11px] font-semibold uppercase tracking-[0.24em] text-teal-500 dark:text-teal-400">
                            Alumni Portal
                        </p>

                        <h1 class="mt-2 text-2xl font-semibold tracking-tight text-zinc-900 dark:text-white sm:text-3xl">
                            Welcome back, {{ auth()->user()->username ?? 'Alumnus' }}
                        </h1>

                        <p class="mt-2 max-w-2xl text-[13.5px] leading-6 text-zinc-600 dark:text-zinc-400">
                            Stay connected with Holy Spirit School of Tagbilaran through announcements, events, and alumni activities.
                        </p>
                    </div>

                    <div class="grid grid-cols-1 gap-2 sm:grid-cols-2 lg:flex lg:flex-wrap lg:justify-end">
                        <a
                            href="#profile-section"
                            class="inline-flex w-full items-center justify-center rounded-2xl border border-zinc-200 bg-white px-4 py-2.5 text-sm font-medium text-zinc-700 transition hover:bg-zinc-50 dark:border-white/10 dark:bg-zinc-900 dark:text-zinc-200 dark:hover:bg-zinc-800 sm:w-auto"
                        >
                            Edit Profile
                        </a>

                        <a
                            href="#upcoming-events"
                            class="inline-flex w-full items-center justify-center rounded-2xl bg-teal-500 px-4 py-2.5 text-sm font-semibold text-zinc-950 transition hover:bg-teal-400 sm:w-auto"
                        >
                            View Events
                        </a>
                    </div>
                </div>
            </section>

            {{-- Profile Status --}}
            @if(auth()->user()->alumni)
                <section class="w-full border-b border-teal-500/20 bg-teal-500/10 px-4 py-4 dark:border-teal-500/20 sm:rounded-3xl sm:border sm:px-5 sm:py-5">
                    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <h2 class="text-[17px] font-semibold text-teal-900 dark:text-teal-200 sm:text-lg">
                                Profile Complete
                            </h2>
                            <p class="mt-1 text-[13.5px] leading-6 text-teal-800 dark:text-teal-300">
                                Your alumni account is linked to your batch information and ready for alumni activities.
                            </p>
                        </div>

                        <span class="inline-flex w-fit items-center rounded-full border border-teal-500/20 bg-white/70 px-3 py-1 text-xs font-medium text-teal-700 dark:bg-zinc-950/40 dark:text-teal-300">
                            Active Alumni Profile
                        </span>
                    </div>
                </section>
            @else
                <section class="w-full border-b border-amber-500/20 bg-amber-500/10 px-4 py-4 dark:border-amber-500/20 sm:rounded-3xl sm:border sm:px-5 sm:py-5">
                    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <h2 class="text-[17px] font-semibold text-amber-900 dark:text-amber-200 sm:text-lg">
                                Complete Your Alumni Profile
                            </h2>
                            <p class="mt-1 text-[13.5px] leading-6 text-amber-800 dark:text-amber-300">
                                Add your alumni details to unlock batch-related features and a more personalized experience.
                            </p>
                        </div>

                        <a
                            href="#profile-section"
                            class="inline-flex w-fit items-center rounded-2xl bg-amber-500 px-4 py-2 text-sm font-semibold text-zinc-950 transition hover:bg-amber-400"
                        >
                            Complete Profile
                        </a>
                    </div>
                </section>
            @endif

            {{-- Summary --}}
            <section class="w-full border-b border-zinc-200 px-4 py-5 dark:border-white/10 sm:rounded-3xl sm:border sm:bg-white sm:px-5 sm:py-5 sm:shadow-sm dark:sm:bg-white/[0.04]">
                <div class="mb-3">
                    <h2 class="text-[17px] font-semibold text-zinc-900 dark:text-white sm:text-lg">
                        Overview
                    </h2>
                    <p class="mt-1 text-[13.5px] leading-6 text-zinc-600 dark:text-zinc-400">
                        A quick look at your alumni activity.
                    </p>
                </div>

                <div class="sm:hidden">
                    <div class="-mx-4 overflow-x-auto px-4 pb-1 [scrollbar-width:none] [&::-webkit-scrollbar]:hidden">
                        <div class="flex w-max gap-2">
                            <div class="min-w-[220px] rounded-2xl border border-zinc-200/80 bg-zinc-50 px-4 py-4 dark:border-white/10 dark:bg-white/[0.03]">
                                <p class="text-xs text-zinc-500 dark:text-zinc-400">My Batch</p>
                                <div class="mt-2 text-xl font-semibold tracking-tight text-zinc-900 dark:text-white">
                                    {{ auth()->user()->alumni?->batch?->schoolyear ?? 'Not set' }}
                                </div>
                                <p class="mt-2 text-xs text-zinc-500 dark:text-zinc-400">
                                    Grad: {{ auth()->user()->alumni?->batch?->yeargrad ?? '—' }}
                                </p>
                            </div>

                            <div class="min-w-[220px] rounded-2xl border border-zinc-200/80 bg-zinc-50 px-4 py-4 dark:border-white/10 dark:bg-white/[0.03]">
                                <p class="text-xs text-zinc-500 dark:text-zinc-400">Upcoming Events</p>
                                <div class="mt-2 text-2xl font-semibold tracking-tight text-zinc-900 dark:text-white">
                                    {{ isset($upcomingEvents) ? $upcomingEvents->count() : 0 }}
                                </div>
                                <p class="mt-2 text-xs text-cyan-600 dark:text-cyan-400">
                                    Events currently open
                                </p>
                            </div>

                            <div class="min-w-[220px] rounded-2xl border border-zinc-200/80 bg-zinc-50 px-4 py-4 dark:border-white/10 dark:bg-white/[0.03]">
                                <p class="text-xs text-zinc-500 dark:text-zinc-400">Total Donated</p>
                                <div class="mt-2 text-xl font-semibold tracking-tight text-zinc-900 dark:text-white">
                                    ₱{{ number_format(($totalDonated ?? 0) / 100, 2) }}
                                </div>
                                <p class="mt-2 text-xs text-teal-600 dark:text-teal-400">
                                    Your contribution history
                                </p>
                            </div>

                            <div class="min-w-[220px] rounded-2xl border border-zinc-200/80 bg-zinc-50 px-4 py-4 dark:border-white/10 dark:bg-white/[0.03]">
                                <p class="text-xs text-zinc-500 dark:text-zinc-400">This Month</p>
                                <div class="mt-2 text-xl font-semibold tracking-tight text-zinc-900 dark:text-white">
                                    ₱{{ number_format(($donationsThisMonth ?? 0) / 100, 2) }}
                                </div>
                                <p class="mt-2 text-xs text-zinc-500 dark:text-zinc-400">
                                    {{ now()->format('F Y') }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="hidden sm:grid sm:grid-cols-2 sm:gap-3 xl:grid-cols-4">
                    <div class="rounded-2xl border border-zinc-200 bg-zinc-50 p-4 dark:border-white/10 dark:bg-white/[0.03] sm:rounded-3xl sm:p-5">
                        <p class="text-xs text-zinc-500 dark:text-zinc-400 sm:text-sm">My Batch</p>
                        <div class="mt-2 text-xl font-semibold tracking-tight text-zinc-900 dark:text-white sm:text-2xl">
                            {{ auth()->user()->alumni?->batch?->schoolyear ?? 'Not set' }}
                        </div>
                        <p class="mt-2 text-xs text-zinc-500 dark:text-zinc-400 sm:text-sm">
                            Grad: {{ auth()->user()->alumni?->batch?->yeargrad ?? '—' }}
                        </p>
                    </div>

                    <div class="rounded-2xl border border-zinc-200 bg-zinc-50 p-4 dark:border-white/10 dark:bg-white/[0.03] sm:rounded-3xl sm:p-5">
                        <p class="text-xs text-zinc-500 dark:text-zinc-400 sm:text-sm">Upcoming Events</p>
                        <div class="mt-2 text-2xl font-semibold tracking-tight text-zinc-900 dark:text-white sm:text-3xl">
                            {{ isset($upcomingEvents) ? $upcomingEvents->count() : 0 }}
                        </div>
                        <p class="mt-2 text-xs text-cyan-600 dark:text-cyan-400 sm:text-sm">
                            Events currently open
                        </p>
                    </div>

                    <div class="rounded-2xl border border-zinc-200 bg-zinc-50 p-4 dark:border-white/10 dark:bg-white/[0.03] sm:rounded-3xl sm:p-5">
                        <p class="text-xs text-zinc-500 dark:text-zinc-400 sm:text-sm">Total Donated</p>
                        <div class="mt-2 text-xl font-semibold tracking-tight text-zinc-900 dark:text-white sm:text-3xl">
                            ₱{{ number_format(($totalDonated ?? 0) / 100, 2) }}
                        </div>
                        <p class="mt-2 text-xs text-teal-600 dark:text-teal-400 sm:text-sm">
                            Your contribution history
                        </p>
                    </div>

                    <div class="rounded-2xl border border-zinc-200 bg-zinc-50 p-4 dark:border-white/10 dark:bg-white/[0.03] sm:rounded-3xl sm:p-5">
                        <p class="text-xs text-zinc-500 dark:text-zinc-400 sm:text-sm">This Month</p>
                        <div class="mt-2 text-xl font-semibold tracking-tight text-zinc-900 dark:text-white sm:text-3xl">
                            ₱{{ number_format(($donationsThisMonth ?? 0) / 100, 2) }}
                        </div>
                        <p class="mt-2 text-xs text-zinc-500 dark:text-zinc-400 sm:text-sm">
                            {{ now()->format('F Y') }}
                        </p>
                    </div>
                </div>
            </section>

            <div class="grid gap-1 xl:grid-cols-[1.3fr_0.7fr] xl:gap-6">

                <div class="space-y-1 xl:space-y-6">
                    <section id="upcoming-events" class="w-full border-b border-zinc-200 px-4 py-5 dark:border-white/10 sm:rounded-3xl sm:border sm:bg-white sm:px-5 sm:py-5 sm:shadow-sm dark:sm:bg-white/[0.04]">
                        <div class="mb-4">
                            <h2 class="text-[17px] font-semibold text-zinc-900 dark:text-white sm:text-lg">
                                Upcoming Events
                            </h2>
                            <p class="mt-1 text-[13.5px] leading-6 text-zinc-600 dark:text-zinc-400">
                                Stay updated on reunions, celebrations, and school activities.
                            </p>
                        </div>

                        <div class="divide-y divide-zinc-200 dark:divide-white/10 sm:grid sm:grid-cols-2 sm:gap-4 sm:divide-y-0">
                            @forelse (($upcomingEvents ?? collect()) as $event)
                                @php
                                    $registration = $myEventRegs[$event->id] ?? null;
                                    $status = $registration['status'] ?? null;
                                @endphp

                                <article class="py-4 first:pt-0 last:pb-0 sm:rounded-3xl sm:border sm:border-zinc-200 sm:bg-zinc-50 sm:p-5 dark:sm:border-white/10 dark:sm:bg-white/[0.03]">
                                    <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
                                        <div class="min-w-0">
                                            <h3 class="text-base font-semibold text-zinc-900 dark:text-white">
                                                {{ $event->title }}
                                            </h3>
                                            <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">
                                                {{ $event->venue ?: 'No venue set' }}
                                            </p>
                                        </div>

                                        <span class="inline-flex w-fit rounded-full bg-cyan-500/10 px-2.5 py-1 text-xs font-medium text-cyan-700 dark:text-cyan-300">
                                            {{ optional($event->event_date)->format('M d, Y') }}
                                        </span>
                                    </div>

                                    <div class="mt-4 space-y-2 text-sm">
                                        <div class="flex items-center justify-between rounded-xl bg-zinc-50 px-3 py-2 dark:bg-white/[0.03] sm:border sm:border-zinc-200 sm:bg-white sm:p-3 dark:sm:border-white/10 dark:sm:bg-zinc-950/40">
                                            <p class="text-zinc-500 dark:text-zinc-400">Dress Code</p>
                                            <p class="font-medium text-zinc-900 dark:text-white">
                                                {{ $event->dress_code ?: '—' }}
                                            </p>
                                        </div>

                                        <div class="flex items-center justify-between rounded-xl bg-zinc-50 px-3 py-2 dark:bg-white/[0.03] sm:border sm:border-zinc-200 sm:bg-white sm:p-3 dark:sm:border-white/10 dark:sm:bg-zinc-950/40">
                                            <p class="text-zinc-500 dark:text-zinc-400">Fee</p>
                                            <p class="font-medium text-zinc-900 dark:text-white">
                                                ₱{{ number_format(($event->registration_fee ?? 0) / 100, 2) }}
                                            </p>
                                        </div>
                                    </div>

                                    <div class="mt-4 space-y-3 border-t border-zinc-200 pt-4 dark:border-white/10 sm:flex sm:items-center sm:justify-between sm:space-y-0">
                                        <div>
                                            @if (!$registration)
                                                <span class="inline-flex items-center rounded-full border border-zinc-200 bg-white px-2.5 py-1 text-xs font-medium text-zinc-600 dark:border-zinc-700 dark:bg-zinc-900 dark:text-zinc-300">
                                                    Not Registered
                                                </span>
                                            @elseif ($status === 'pending')
                                                <span class="inline-flex items-center rounded-full border border-amber-500/20 bg-amber-500/10 px-2.5 py-1 text-xs font-medium text-amber-700 dark:text-amber-300">
                                                    Waiting for Approval
                                                </span>
                                            @elseif ($status === 'paid')
                                                <span class="inline-flex items-center rounded-full border border-teal-500/20 bg-teal-500/10 px-2.5 py-1 text-xs font-medium text-teal-700 dark:text-teal-300">
                                                    Registered
                                                </span>
                                            @elseif ($status === 'cancelled')
                                                <span class="inline-flex items-center rounded-full border border-red-500/20 bg-red-500/10 px-2.5 py-1 text-xs font-medium text-red-700 dark:text-red-300">
                                                    Cancelled
                                                </span>
                                            @else
                                                <span class="inline-flex items-center rounded-full border border-cyan-500/20 bg-cyan-500/10 px-2.5 py-1 text-xs font-medium text-cyan-700 dark:text-cyan-300">
                                                    {{ str($status)->headline() }}
                                                </span>
                                            @endif
                                        </div>

                                        <div class="w-full sm:w-auto">
                                            {{-- keep your existing flux button logic here --}}
                                        </div>
                                    </div>
                                </article>
                            @empty
                                <div class="flex min-h-[160px] items-center justify-center py-8 text-center sm:rounded-2xl sm:border sm:border-dashed sm:border-zinc-300 sm:bg-zinc-50 dark:sm:border-white/10 dark:sm:bg-white/[0.03] sm:col-span-2">
                                    <div>
                                        <p class="text-sm font-medium text-zinc-700 dark:text-zinc-200">
                                            No upcoming events available
                                        </p>
                                        <p class="mt-1 text-[13px] text-zinc-500 dark:text-zinc-400">
                                            Please check back soon for new alumni activities and event schedules.
                                        </p>
                                    </div>
                                </div>
                            @endforelse
                        </div>
                    </section>

                    <section class="w-full border-b border-zinc-200 px-4 py-5 dark:border-white/10 sm:rounded-3xl sm:border sm:bg-white sm:px-5 sm:py-5 sm:shadow-sm dark:sm:bg-white/[0.04]">
                        <div class="mb-4">
                            <h2 class="text-[17px] font-semibold text-zinc-900 dark:text-white sm:text-lg">
                                Latest Announcements
                            </h2>
                            <p class="mt-1 text-[13.5px] leading-6 text-zinc-600 dark:text-zinc-400">
                                Important notices and official updates from HSST.
                            </p>
                        </div>

                        <div class="flex min-h-[180px] items-center justify-center rounded-2xl border border-dashed border-zinc-300 bg-zinc-50 px-4 py-8 text-center dark:border-white/10 dark:bg-white/[0.03]">
                            <div>
                                <p class="text-sm font-medium text-zinc-700 dark:text-zinc-200">
                                    Announcement carousel goes here
                                </p>
                                <p class="mt-1 text-[13px] text-zinc-500 dark:text-zinc-400">
                                    Use the flatter mobile style and only add stronger card framing on larger screens.
                                </p>
                            </div>
                        </div>
                    </section>
                </div>

                <aside class="space-y-1 xl:space-y-6">
                    <section id="profile-section" class="w-full border-b border-zinc-200 px-4 py-5 dark:border-white/10 sm:rounded-3xl sm:border sm:bg-white sm:px-5 sm:py-5 sm:shadow-sm dark:sm:bg-white/[0.04]">
                        <h2 class="text-[17px] font-semibold text-zinc-900 dark:text-white sm:text-lg">
                            My Profile
                        </h2>
                        <p class="mt-1 text-[13.5px] leading-6 text-zinc-600 dark:text-zinc-400">
                            Your linked alumni information.
                        </p>
                    </section>

                    <section class="w-full border-b border-zinc-200 px-4 py-5 dark:border-white/10 sm:rounded-3xl sm:border sm:bg-gradient-to-br sm:from-teal-500/10 sm:to-cyan-500/10 sm:px-5 sm:py-5 sm:shadow-sm">
                        <h2 class="text-[17px] font-semibold text-zinc-900 dark:text-white sm:text-lg">
                            Quick Actions
                        </h2>
                        <p class="mt-1 text-[13.5px] leading-6 text-zinc-600 dark:text-zinc-300">
                            Shortcuts to common alumni tasks.
                        </p>
                    </section>
                </aside>
            </div>
        </div>
    </div>
</div>