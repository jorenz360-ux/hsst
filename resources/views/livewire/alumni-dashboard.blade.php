<div>
    <div class="mx-auto max-w-7xl space-y-6 p-6">
    {{-- Header --}}
    <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
        <div>
            <p class="text-xs font-semibold uppercase tracking-[0.22em] text-teal-400">
                Alumni Portal
            </p>
            <h1 class="mt-1 text-3xl font-semibold tracking-tight text-zinc-900 dark:text-white">
                Welcome back, {{ auth()->user()->username ?? 'Alumnus' }}
            </h1>
            <p class="mt-2 max-w-2xl text-sm text-zinc-600 dark:text-zinc-400">
                Stay connected with Holy Spirit School of Tagbilaran through announcements, events, and alumni activities.
            </p>
        </div>

        <div class="flex flex-wrap gap-3">
            <a
                href="#"
                class="inline-flex items-center justify-center rounded-2xl border border-zinc-200 bg-white px-4 py-2.5 text-sm font-medium text-zinc-700 shadow-sm transition hover:bg-zinc-50 dark:border-white/10 dark:bg-zinc-900 dark:text-zinc-200 dark:hover:bg-zinc-800"
            >
                Edit Profile
            </a>

            <a
                href="#upcoming-events"
                class="inline-flex items-center justify-center rounded-2xl bg-teal-500 px-4 py-2.5 text-sm font-semibold text-zinc-950 shadow-sm transition hover:bg-teal-400"
            >
                View Events
            </a>
        </div>
    </div>

    {{-- Profile Status Banner --}}
    @if(auth()->user()->alumni)
        <div class="rounded-3xl border border-teal-500/20 bg-teal-500/10 p-5">
            <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                <div>
                    <h2 class="text-lg font-semibold text-teal-900 dark:text-teal-200">
                        Profile Complete
                    </h2>
                    <p class="mt-1 text-sm text-teal-800 dark:text-teal-300">
                        Your alumni account is linked to your batch information and ready for alumni activities.
                    </p>
                </div>

                <span class="inline-flex w-fit items-center rounded-full border border-teal-500/20 bg-white/60 px-3 py-1 text-xs font-medium text-teal-700 dark:bg-zinc-950/40 dark:text-teal-300">
                    Active Alumni Profile
                </span>
            </div>
        </div>
    @else
        <div class="rounded-3xl border border-amber-500/20 bg-amber-500/10 p-5">
            <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                <div>
                    <h2 class="text-lg font-semibold text-amber-900 dark:text-amber-200">
                        Complete Your Alumni Profile
                    </h2>
                    <p class="mt-1 text-sm text-amber-800 dark:text-amber-300">
                        Add your alumni details to unlock batch-related features and a more personalized experience.
                    </p>
                </div>

                <a
                    href="#"
                    class="inline-flex w-fit items-center rounded-2xl bg-amber-500 px-4 py-2 text-sm font-semibold text-zinc-950 transition hover:bg-amber-400"
                >
                    Complete Profile
                </a>
            </div>
        </div>
    @endif

    {{-- Summary Cards --}}
    <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
        <div class="rounded-3xl border border-zinc-200 bg-white p-5 shadow-sm dark:border-white/10 dark:bg-white/[0.03]">
            <p class="text-sm text-zinc-500 dark:text-zinc-400">My Batch</p>
            <div class="mt-2 text-2xl font-semibold tracking-tight text-zinc-900 dark:text-white">
                {{ auth()->user()->alumni?->batch?->schoolyear ?? 'Not set' }}
            </div>
            <p class="mt-2 text-sm text-zinc-500 dark:text-zinc-400">
                Grad: {{ auth()->user()->alumni?->batch?->yeargrad ?? '—' }}
            </p>
        </div>

        <div class="rounded-3xl border border-zinc-200 bg-white p-5 shadow-sm dark:border-white/10 dark:bg-white/[0.03]">
            <p class="text-sm text-zinc-500 dark:text-zinc-400">Upcoming Events</p>
            <div class="mt-2 text-3xl font-semibold tracking-tight text-zinc-900 dark:text-white">
                {{ isset($upcomingEvents) ? $upcomingEvents->count() : 0 }}
            </div>
            <p class="mt-2 text-sm text-cyan-500 dark:text-cyan-400">
                Events currently open
            </p>
        </div>

        <div class="rounded-3xl border border-zinc-200 bg-white p-5 shadow-sm dark:border-white/10 dark:bg-white/[0.03]">
            <p class="text-sm text-zinc-500 dark:text-zinc-400">Total Donated</p>
            <div class="mt-2 text-3xl font-semibold tracking-tight text-zinc-900 dark:text-white">
                ₱{{ number_format(($totalDonated ?? 0) / 100, 2) }}
            </div>
            <p class="mt-2 text-sm text-teal-500 dark:text-teal-400">
                Your contribution history
            </p>
        </div>

        <div class="rounded-3xl border border-zinc-200 bg-white p-5 shadow-sm dark:border-white/10 dark:bg-white/[0.03]">
            <p class="text-sm text-zinc-500 dark:text-zinc-400">This Month</p>
            <div class="mt-2 text-3xl font-semibold tracking-tight text-zinc-900 dark:text-white">
                ₱{{ number_format(($donationsThisMonth ?? 0) / 100, 2) }}
            </div>
            <p class="mt-2 text-sm text-zinc-500 dark:text-zinc-400">
                {{ now()->format('F Y') }}
            </p>
        </div>
    </div>

    <div class="grid gap-6 xl:grid-cols-[1.35fr_0.65fr]">
        <div class="space-y-6">
            {{-- Upcoming Events --}}
            <section id="upcoming-events" class="rounded-3xl border border-zinc-200 bg-white p-5 shadow-sm dark:border-white/10 dark:bg-white/[0.03]">
                <div class="mb-4 flex items-center justify-between">
                    <div>
                        <h2 class="text-lg font-semibold text-zinc-900 dark:text-white">Upcoming Events</h2>
                        <p class="text-sm text-zinc-600 dark:text-zinc-400">
                            Stay updated on reunions, celebrations, and school activities.
                        </p>
                    </div>
                </div>

                <div class="grid gap-4 md:grid-cols-2">
                    @forelse (($upcomingEvents ?? collect()) as $event)
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
                        <div class="rounded-2xl border border-zinc-200 bg-zinc-50 p-4 text-sm text-zinc-500 dark:border-white/10 dark:bg-zinc-900/70 dark:text-zinc-400 md:col-span-2">
                            No upcoming events available right now.
                        </div>
                    @endforelse
                </div>
            </section>

            {{-- Announcements --}}
            <section class="rounded-3xl border border-zinc-200 bg-white p-5 shadow-sm dark:border-white/10 dark:bg-white/[0.03]">
                <div class="mb-4">
                    <h2 class="text-lg font-semibold text-zinc-900 dark:text-white">Latest Announcements</h2>
                    <p class="text-sm text-zinc-600 dark:text-zinc-400">
                        Important notices and official updates from HSST.
                    </p>
                </div>

                <div class="space-y-3">
                @forelse (($latestAnnouncements ?? collect()) as $announcement)
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

                            @if($announcement->pinned ?? false)
                                <span class="inline-flex items-center rounded-full border border-amber-500/20 bg-amber-500/10 px-2.5 py-1 text-xs font-medium text-amber-300">
                                    Pinned
                                </span>
                            @endif
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
            {{-- Profile Card --}}
            <section class="rounded-3xl border border-zinc-200 bg-white p-5 shadow-sm dark:border-white/10 dark:bg-white/[0.03]">
                <h2 class="text-lg font-semibold text-zinc-900 dark:text-white">My Profile</h2>
                <p class="mt-1 text-sm text-zinc-600 dark:text-zinc-400">
                    Your linked alumni information.
                </p>

                <div class="mt-4 space-y-3 text-sm">
                    <div class="rounded-2xl border border-zinc-200 bg-zinc-50 p-4 dark:border-white/10 dark:bg-zinc-900/70">
                        <p class="text-zinc-500 dark:text-zinc-400">Full Name</p>
                        <p class="mt-1 font-medium text-zinc-900 dark:text-white">
                            @if(auth()->user()->alumni)
                                {{ trim(auth()->user()->alumni->fname . ' ' . auth()->user()->alumni->lname) }}
                            @else
                                Not yet completed
                            @endif
                        </p>
                    </div>

                    <div class="rounded-2xl border border-zinc-200 bg-zinc-50 p-4 dark:border-white/10 dark:bg-zinc-900/70">
                        <p class="text-zinc-500 dark:text-zinc-400">Email</p>
                        <p class="mt-1 font-medium text-zinc-900 dark:text-white">
                            {{ auth()->user()->email }}
                        </p>
                    </div>

                    <div class="rounded-2xl border border-zinc-200 bg-zinc-50 p-4 dark:border-white/10 dark:bg-zinc-900/70">
                        <p class="text-zinc-500 dark:text-zinc-400">Batch</p>
                        <p class="mt-1 font-medium text-zinc-900 dark:text-white">
                            {{ auth()->user()->alumni?->batch?->schoolyear ?? 'Not set' }}
                        </p>
                    </div>
                </div>

                <a
                    href="#"
                    class="mt-4 inline-flex w-full items-center justify-center rounded-2xl bg-teal-500 px-4 py-2.5 text-sm font-semibold text-zinc-950 transition hover:bg-teal-400"
                >
                    Manage Profile
                </a>
            </section>

            {{-- Quick Actions --}}
            <section class="rounded-3xl border border-zinc-200 bg-gradient-to-br from-teal-500/15 to-cyan-500/10 p-5 shadow-sm dark:border-white/10">
                <h2 class="text-lg font-semibold text-zinc-900 dark:text-white">Quick Actions</h2>
                <p class="mt-1 text-sm text-zinc-600 dark:text-zinc-300">
                    Shortcuts to common alumni tasks.
                </p>

                <div class="mt-4 grid gap-3">
                    <a href="#upcoming-events" class="rounded-2xl border border-white/10 bg-zinc-950/70 px-4 py-3 text-sm font-medium text-zinc-200 transition hover:bg-zinc-900">
                        Browse Events
                    </a>
                    <a href="#" class="rounded-2xl border border-white/10 bg-zinc-950/70 px-4 py-3 text-sm font-medium text-zinc-200 transition hover:bg-zinc-900">
                        Update Profile
                    </a>
                    <a href="#" class="rounded-2xl border border-white/10 bg-zinc-950/70 px-4 py-3 text-sm font-medium text-zinc-200 transition hover:bg-zinc-900">
                        View Donation History
                    </a>
                </div>
            </section>
        </aside>
    </div>
</div>
</div>