<div>
    <div class="mx-auto max-w-7xl space-y-5 px-4 py-4 pb-24 sm:px-5 sm:py-5 sm:pb-5 lg:space-y-6 lg:p-6">

        {{-- Header --}}
        <section class="overflow-hidden rounded-3xl border border-zinc-200 bg-white shadow-sm dark:border-white/10 dark:bg-white/[0.03]">
            <div class="flex flex-col gap-5 px-4 py-5 sm:px-6 sm:py-6 lg:flex-row lg:items-end lg:justify-between lg:px-7">
                <div class="min-w-0">
                    <p class="text-[11px] font-semibold uppercase tracking-[0.24em] text-teal-500 dark:text-teal-400">
                        Alumni Portal
                    </p>

                    <h1 class="mt-2 text-2xl font-semibold tracking-tight text-zinc-900 dark:text-white sm:text-3xl">
                        Welcome back, {{ auth()->user()->username ?? 'Alumnus' }}
                    </h1>

                    <p class="mt-2 max-w-2xl text-sm leading-6 text-zinc-600 dark:text-zinc-400">
                        Stay connected with Holy Spirit School of Tagbilaran through announcements, events, and alumni activities.
                    </p>
                </div>

                <div class="grid grid-cols-1 gap-2 sm:grid-cols-2 lg:flex lg:flex-wrap lg:justify-end">
                    <a
                        href="#"
                        class="inline-flex items-center justify-center rounded-2xl border border-zinc-200 bg-white px-4 py-2.5 text-sm font-medium text-zinc-700 transition hover:bg-zinc-50 dark:border-white/10 dark:bg-zinc-900 dark:text-zinc-200 dark:hover:bg-zinc-800"
                    >
                        Edit Profile
                    </a>

                    <a
                        href="#upcoming-events"
                        class="inline-flex items-center justify-center rounded-2xl bg-teal-500 px-4 py-2.5 text-sm font-semibold text-zinc-950 transition hover:bg-teal-400"
                    >
                        View Events
                    </a>
                </div>
            </div>
        </section>

        {{-- Profile Status Banner --}}
        @if(auth()->user()->alumni)
            <section class="rounded-2xl border border-teal-500/20 bg-teal-500/10 px-4 py-4 sm:rounded-3xl sm:px-5 sm:py-5">
                <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <h2 class="text-base font-semibold text-teal-900 dark:text-teal-200 sm:text-lg">
                            Profile Complete
                        </h2>
                        <p class="mt-1 text-sm leading-6 text-teal-800 dark:text-teal-300">
                            Your alumni account is linked to your batch information and ready for alumni activities.
                        </p>
                    </div>

                    <span class="inline-flex w-fit items-center rounded-full border border-teal-500/20 bg-white/70 px-3 py-1 text-xs font-medium text-teal-700 dark:bg-zinc-950/40 dark:text-teal-300">
                        Active Alumni Profile
                    </span>
                </div>
            </section>
        @else
            <section class="rounded-2xl border border-amber-500/20 bg-amber-500/10 px-4 py-4 sm:rounded-3xl sm:px-5 sm:py-5">
                <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <h2 class="text-base font-semibold text-amber-900 dark:text-amber-200 sm:text-lg">
                            Complete Your Alumni Profile
                        </h2>
                        <p class="mt-1 text-sm leading-6 text-amber-800 dark:text-amber-300">
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
            </section>
        @endif

        {{-- Summary Tiles --}}
        <section class="space-y-3">
            {{-- Very small screens: horizontal scroll --}}
            <div class="sm:hidden">
                <div class="-mx-4 overflow-x-auto px-4 pb-1 [scrollbar-width:none] [&::-webkit-scrollbar]:hidden">
                    <div class="flex gap-3 w-max">
                        <div class="w-[220px] rounded-2xl border border-zinc-200 bg-white p-4 shadow-sm dark:border-white/10 dark:bg-white/[0.03]">
                            <p class="text-xs text-zinc-500 dark:text-zinc-400">My Batch</p>
                            <div class="mt-2 text-xl font-semibold tracking-tight text-zinc-900 dark:text-white">
                                {{ auth()->user()->alumni?->batch?->schoolyear ?? 'Not set' }}
                            </div>
                            <p class="mt-2 text-xs text-zinc-500 dark:text-zinc-400">
                                Grad: {{ auth()->user()->alumni?->batch?->yeargrad ?? '—' }}
                            </p>
                        </div>

                        <div class="w-[220px] rounded-2xl border border-zinc-200 bg-white p-4 shadow-sm dark:border-white/10 dark:bg-white/[0.03]">
                            <p class="text-xs text-zinc-500 dark:text-zinc-400">Upcoming Events</p>
                            <div class="mt-2 text-2xl font-semibold tracking-tight text-zinc-900 dark:text-white">
                                {{ isset($upcomingEvents) ? $upcomingEvents->count() : 0 }}
                            </div>
                            <p class="mt-2 text-xs text-cyan-600 dark:text-cyan-400">
                                Events currently open
                            </p>
                        </div>

                        <div class="w-[220px] rounded-2xl border border-zinc-200 bg-white p-4 shadow-sm dark:border-white/10 dark:bg-white/[0.03]">
                            <p class="text-xs text-zinc-500 dark:text-zinc-400">Total Donated</p>
                            <div class="mt-2 text-xl font-semibold tracking-tight text-zinc-900 dark:text-white">
                                ₱{{ number_format(($totalDonated ?? 0) / 100, 2) }}
                            </div>
                            <p class="mt-2 text-xs text-teal-600 dark:text-teal-400">
                                Your contribution history
                            </p>
                        </div>

                        <div class="w-[220px] rounded-2xl border border-zinc-200 bg-white p-4 shadow-sm dark:border-white/10 dark:bg-white/[0.03]">
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

            {{-- sm and up: grid --}}
            <div class="hidden sm:grid sm:grid-cols-2 sm:gap-3 xl:grid-cols-4">
                <div class="rounded-2xl border border-zinc-200 bg-white p-4 shadow-sm dark:border-white/10 dark:bg-white/[0.03] sm:rounded-3xl sm:p-5">
                    <p class="text-xs text-zinc-500 dark:text-zinc-400 sm:text-sm">My Batch</p>
                    <div class="mt-2 text-xl font-semibold tracking-tight text-zinc-900 dark:text-white sm:text-2xl">
                        {{ auth()->user()->alumni?->batch?->schoolyear ?? 'Not set' }}
                    </div>
                    <p class="mt-2 text-xs text-zinc-500 dark:text-zinc-400 sm:text-sm">
                        Grad: {{ auth()->user()->alumni?->batch?->yeargrad ?? '—' }}
                    </p>
                </div>

                <div class="rounded-2xl border border-zinc-200 bg-white p-4 shadow-sm dark:border-white/10 dark:bg-white/[0.03] sm:rounded-3xl sm:p-5">
                    <p class="text-xs text-zinc-500 dark:text-zinc-400 sm:text-sm">Upcoming Events</p>
                    <div class="mt-2 text-2xl font-semibold tracking-tight text-zinc-900 dark:text-white sm:text-3xl">
                        {{ isset($upcomingEvents) ? $upcomingEvents->count() : 0 }}
                    </div>
                    <p class="mt-2 text-xs text-cyan-600 dark:text-cyan-400 sm:text-sm">
                        Events currently open
                    </p>
                </div>

                <div class="rounded-2xl border border-zinc-200 bg-white p-4 shadow-sm dark:border-white/10 dark:bg-white/[0.03] sm:rounded-3xl sm:p-5">
                    <p class="text-xs text-zinc-500 dark:text-zinc-400 sm:text-sm">Total Donated</p>
                    <div class="mt-2 text-xl font-semibold tracking-tight text-zinc-900 dark:text-white sm:text-3xl">
                        ₱{{ number_format(($totalDonated ?? 0) / 100, 2) }}
                    </div>
                    <p class="mt-2 text-xs text-teal-600 dark:text-teal-400 sm:text-sm">
                        Your contribution history
                    </p>
                </div>

                <div class="rounded-2xl border border-zinc-200 bg-white p-4 shadow-sm dark:border-white/10 dark:bg-white/[0.03] sm:rounded-3xl sm:p-5">
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

        {{-- Main Layout --}}
        <div class="grid gap-5 xl:grid-cols-[1.3fr_0.7fr] xl:gap-6">

            {{-- Main Content --}}
            <div class="space-y-5 xl:space-y-6">

                {{-- Upcoming Events --}}
                <section
                    id="upcoming-events"
                    class="rounded-2xl border border-zinc-200 bg-white px-4 py-5 shadow-sm dark:border-white/10 dark:bg-white/[0.03] sm:rounded-3xl sm:px-5 sm:py-5"
                >
                    <div class="mb-4">
                        <h2 class="text-lg font-semibold text-zinc-900 dark:text-white">
                            Upcoming Events
                        </h2>
                        <p class="mt-1 text-sm text-zinc-600 dark:text-zinc-400">
                            Stay updated on reunions, celebrations, and school activities.
                        </p>
                    </div>

                    <div class="grid gap-4 md:grid-cols-2">
                        @forelse (($upcomingEvents ?? collect()) as $event)
                            @php
                                $registration = $myEventRegs[$event->id] ?? null;
                                $status = $registration['status'] ?? null;
                            @endphp

                            <article class="rounded-2xl border border-zinc-200 bg-zinc-50 p-4 transition hover:shadow-sm dark:border-white/10 dark:bg-zinc-900/70 sm:rounded-3xl sm:p-5">
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

                                <div class="mt-4 space-y-2 text-sm sm:grid sm:grid-cols-2 sm:gap-3 sm:space-y-0">
                                    <div class="flex items-center justify-between rounded-xl bg-white px-3 py-2 dark:bg-zinc-950/60 sm:block sm:border sm:border-zinc-200 sm:p-3 dark:sm:border-white/10">
                                        <p class="text-zinc-500 dark:text-zinc-400">Dress Code</p>
                                        <p class="font-medium text-zinc-900 dark:text-white">
                                            {{ $event->dress_code ?: '—' }}
                                        </p>
                                    </div>

                                    <div class="flex items-center justify-between rounded-xl bg-white px-3 py-2 dark:bg-zinc-950/60 sm:block sm:border sm:border-zinc-200 sm:p-3 dark:sm:border-white/10">
                                        <p class="text-zinc-500 dark:text-zinc-400">Fee</p>
                                        <p class="font-medium text-zinc-900 dark:text-white">
                                            ₱{{ number_format(($event->registration_fee ?? 0) / 100, 2) }}
                                        </p>
                                    </div>
                                </div>

                                <div class="mt-4 space-y-3 border-t border-zinc-200 pt-4 dark:border-white/10 sm:flex sm:items-center sm:justify-between sm:space-y-0">
                                    <div>
                                        @if (!$registration)
                                            <span class="inline-flex items-center rounded-full border border-zinc-200 bg-white px-2.5 py-1 text-xs font-medium text-zinc-600 dark:border-zinc-700 dark:bg-zinc-800 dark:text-zinc-300">
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
                                        @if (!$registration)
                                            <flux:button
                                                type="button"
                                                variant="primary"
                                                wire:click="registerOrPay({{ $event->id }})"
                                                class="w-full sm:w-auto"
                                            >
                                                Register Now
                                            </flux:button>
                                        @elseif ($status === 'pending')
                                            <flux:button
                                                type="button"
                                                variant="ghost"
                                                disabled
                                                class="w-full sm:w-auto"
                                            >
                                                Pending
                                            </flux:button>
                                        @elseif ($status === 'paid')
                                            <flux:button
                                                type="button"
                                                variant="ghost"
                                                disabled
                                                class="w-full sm:w-auto"
                                            >
                                                Registered
                                            </flux:button>
                                        @elseif ($status === 'cancelled')
                                            <flux:button
                                                type="button"
                                                variant="primary"
                                                wire:click="registerOrPay({{ $event->id }})"
                                                class="w-full sm:w-auto"
                                            >
                                                Register Again
                                            </flux:button>
                                        @else
                                            <flux:button
                                                type="button"
                                                variant="ghost"
                                                disabled
                                                class="w-full sm:w-auto"
                                            >
                                                {{ str($status)->headline() }}
                                            </flux:button>
                                        @endif
                                    </div>
                                </div>
                            </article>
                        @empty
                            <div class="rounded-2xl border border-zinc-200 bg-zinc-50 p-4 text-sm text-zinc-500 dark:border-white/10 dark:bg-zinc-900/70 dark:text-zinc-400 md:col-span-2">
                                No upcoming events available right now.
                            </div>
                        @endforelse
                    </div>
                </section>

                {{-- Announcements Carousel --}}
                <section
                    x-data="{
                        current: 0,
                        total: {{ max(($latestAnnouncements ?? collect())->count(), 1) }},
                        timer: null,
                        start() {
                            if (this.total <= 1) return;
                            this.timer = setInterval(() => this.next(), 5000);
                        },
                        stop() {
                            if (this.timer) clearInterval(this.timer);
                        },
                        next() {
                            this.current = (this.current + 1) % this.total;
                        },
                        prev() {
                            this.current = (this.current - 1 + this.total) % this.total;
                        }
                    }"
                    x-init="start()"
                    @mouseenter="stop()"
                    @mouseleave="start()"
                    class="rounded-2xl border border-zinc-200 bg-white px-4 py-5 shadow-sm dark:border-white/10 dark:bg-white/[0.03] sm:rounded-3xl sm:px-5 sm:py-5"
                >
                    <div class="mb-4 flex items-start justify-between gap-3">
                        <div>
                            <h2 class="text-lg font-semibold text-zinc-900 dark:text-white">
                                Latest Announcements
                            </h2>
                            <p class="mt-1 text-sm text-zinc-600 dark:text-zinc-400">
                                Important notices and official updates from HSST.
                            </p>
                        </div>

                        @if(($latestAnnouncements ?? collect())->count() > 1)
                            <div class="hidden sm:flex items-center gap-2">
                                <button
                                    type="button"
                                    @click="prev()"
                                    class="inline-flex h-9 w-9 items-center justify-center rounded-full border border-zinc-200 bg-white text-zinc-600 transition hover:bg-zinc-50 dark:border-white/10 dark:bg-zinc-900 dark:text-zinc-300"
                                >
                                    ‹
                                </button>
                                <button
                                    type="button"
                                    @click="next()"
                                    class="inline-flex h-9 w-9 items-center justify-center rounded-full border border-zinc-200 bg-white text-zinc-600 transition hover:bg-zinc-50 dark:border-white/10 dark:bg-zinc-900 dark:text-zinc-300"
                                >
                                    ›
                                </button>
                            </div>
                        @endif
                    </div>

                    @if(($latestAnnouncements ?? collect())->count())
                        <div class="relative min-h-[210px] overflow-hidden">
                            @foreach(($latestAnnouncements ?? collect()) as $index => $announcement)
                                <article
                                    x-show="current === {{ $index }}"
                                    x-transition:enter="transition ease-out duration-400"
                                    x-transition:enter-start="opacity-0 translate-x-3"
                                    x-transition:enter-end="opacity-100 translate-x-0"
                                    x-transition:leave="transition ease-in duration-300"
                                    x-transition:leave-start="opacity-100 translate-x-0"
                                    x-transition:leave-end="opacity-0 -translate-x-3"
                                    class="absolute inset-0 flex h-full flex-col rounded-2xl border border-zinc-200 bg-zinc-50 p-4 dark:border-white/10 dark:bg-zinc-900/70 sm:p-5"
                                >
                                    <div class="flex items-start justify-between gap-3">
                                        <div class="min-w-0">
                                            <h3 class="text-base font-semibold text-zinc-900 dark:text-white">
                                                {{ $announcement->title }}
                                            </h3>

                                            <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">
                                                {{ $announcement->published_at?->format('M d, Y h:i A') ?? $announcement->created_at?->format('M d, Y h:i A') }}
                                            </p>
                                        </div>

                                        @if($announcement->pinned ?? false)
                                            <span class="inline-flex shrink-0 items-center rounded-full border border-amber-500/20 bg-amber-500/10 px-2.5 py-1 text-xs font-medium text-amber-700 dark:text-amber-300">
                                                Pinned
                                            </span>
                                        @endif
                                    </div>

                                    @if(!empty($announcement->content))
                                        <p class="mt-4 text-sm leading-6 text-zinc-600 dark:text-zinc-300">
                                            {{ \Illuminate\Support\Str::limit(strip_tags($announcement->content), 320) }}
                                        </p>
                                    @endif
                                </article>
                            @endforeach
                        </div>

                        @if(($latestAnnouncements ?? collect())->count() > 1)
                            <div class="mt-4 flex items-center justify-between sm:justify-center sm:gap-3">
                                <button
                                    type="button"
                                    @click="prev()"
                                    class="inline-flex h-10 w-10 items-center justify-center rounded-full border border-zinc-200 bg-white text-zinc-600 transition hover:bg-zinc-50 dark:border-white/10 dark:bg-zinc-900 dark:text-zinc-300 sm:hidden"
                                >
                                    ‹
                                </button>

                                <div class="flex items-center gap-2">
                                    @foreach(($latestAnnouncements ?? collect()) as $index => $announcement)
                                        <button
                                            type="button"
                                            @click="current = {{ $index }}"
                                            class="h-2.5 rounded-full transition-all"
                                            :class="current === {{ $index }} ? 'w-6 bg-teal-500' : 'w-2.5 bg-zinc-300 dark:bg-zinc-700'"
                                            aria-label="Go to announcement {{ $index + 1 }}"
                                        ></button>
                                    @endforeach
                                </div>

                                <button
                                    type="button"
                                    @click="next()"
                                    class="inline-flex h-10 w-10 items-center justify-center rounded-full border border-zinc-200 bg-white text-zinc-600 transition hover:bg-zinc-50 dark:border-white/10 dark:bg-zinc-900 dark:text-zinc-300 sm:hidden"
                                >
                                    ›
                                </button>
                            </div>
                        @endif
                    @else
                        <div class="rounded-2xl border border-zinc-200 bg-zinc-50 p-4 text-sm text-zinc-500 dark:border-white/10 dark:bg-zinc-900/70 dark:text-zinc-400">
                            No announcements available.
                        </div>
                    @endif
                </section>
            </div>

            {{-- Sidebar / Utility Column --}}
            <aside class="space-y-5 xl:space-y-6">

                {{-- My Profile --}}
                <section id="profile-section" class="rounded-2xl border border-zinc-200 bg-white px-4 py-5 shadow-sm dark:border-white/10 dark:bg-white/[0.03] sm:rounded-3xl sm:px-5 sm:py-5">
                    <h2 class="text-lg font-semibold text-zinc-900 dark:text-white">
                        My Profile
                    </h2>
                    <p class="mt-1 text-sm text-zinc-600 dark:text-zinc-400">
                        Your linked alumni information.
                    </p>

                    <div class="mt-4 space-y-3">
                        <div class="rounded-2xl bg-zinc-50 px-4 py-3 dark:bg-zinc-900/70 sm:border sm:border-zinc-200 dark:sm:border-white/10">
                            <p class="text-sm text-zinc-500 dark:text-zinc-400">Full Name</p>
                            <p class="mt-1 font-medium text-zinc-900 dark:text-white">
                                @if(auth()->user()->alumni)
                                    {{ trim(auth()->user()->alumni->fname . ' ' . auth()->user()->alumni->lname) }}
                                @else
                                    Not yet completed
                                @endif
                            </p>
                        </div>

                        <div class="rounded-2xl bg-zinc-50 px-4 py-3 dark:bg-zinc-900/70 sm:border sm:border-zinc-200 dark:sm:border-white/10">
                            <p class="text-sm text-zinc-500 dark:text-zinc-400">Email</p>
                            <p class="mt-1 break-all font-medium text-zinc-900 dark:text-white">
                                {{ auth()->user()->email }}
                            </p>
                        </div>

                        <div class="rounded-2xl bg-zinc-50 px-4 py-3 dark:bg-zinc-900/70 sm:border sm:border-zinc-200 dark:sm:border-white/10">
                            <p class="text-sm text-zinc-500 dark:text-zinc-400">Batch</p>
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

                {{-- Quick Actions - Icon Buttons --}}
                <section class="overflow-hidden rounded-2xl border border-white/10 bg-gradient-to-br from-teal-500/15 to-cyan-500/10 px-4 py-5 shadow-sm sm:rounded-3xl sm:px-5 sm:py-5">
                    <h2 class="text-lg font-semibold text-zinc-900 dark:text-white">
                        Quick Actions
                    </h2>
                    <p class="mt-1 text-sm text-zinc-600 dark:text-zinc-300">
                        Shortcuts to common alumni tasks.
                    </p>

                    <div class="mt-4 grid grid-cols-3 gap-3">
                        <a
                            href="#upcoming-events"
                            class="group flex flex-col items-center justify-center rounded-2xl border border-white/10 bg-zinc-950/80 px-3 py-4 text-center transition hover:bg-zinc-900"
                        >
                            <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-teal-500/15 text-teal-300">
                                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 2v3M16 2v3M3.5 9.5h17M5 5h14a1 1 0 0 1 1 1v13a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V6a1 1 0 0 1 1-1Z"/>
                                </svg>
                            </div>
                            <span class="mt-2 text-xs font-medium text-zinc-200">
                                Events
                            </span>
                        </a>

                        <a
                            href="#profile-section"
                            class="group flex flex-col items-center justify-center rounded-2xl border border-white/10 bg-zinc-950/80 px-3 py-4 text-center transition hover:bg-zinc-900"
                        >
                            <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-cyan-500/15 text-cyan-300">
                                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 12a4 4 0 1 0 0-8 4 4 0 0 0 0 8Zm-7 9a7 7 0 0 1 14 0"/>
                                </svg>
                            </div>
                            <span class="mt-2 text-xs font-medium text-zinc-200">
                                Profile
                            </span>
                        </a>

                        <a
                            href="#"
                            class="group flex flex-col items-center justify-center rounded-2xl border border-white/10 bg-zinc-950/80 px-3 py-4 text-center transition hover:bg-zinc-900"
                        >
                            <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-violet-500/15 text-violet-300">
                                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v8m-4-4h8"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M20 12a8 8 0 1 1-16 0a8 8 0 0 1 16 0Z"/>
                                </svg>
                            </div>
                            <span class="mt-2 text-xs font-medium text-zinc-200">
                                Donations
                            </span>
                        </a>
                    </div>
                </section>
            </aside>
        </div>
    </div>

    {{-- Sticky Mobile Bottom Actions --}}
    <div class="fixed inset-x-0 bottom-0 z-40 border-t border-zinc-200 bg-white/95 backdrop-blur sm:hidden dark:border-white/10 dark:bg-zinc-950/95">
        <div class="grid grid-cols-3 px-2 py-2">
            <a
                href="#profile-section"
                class="flex flex-col items-center justify-center rounded-2xl px-3 py-2 text-zinc-600 transition hover:bg-zinc-100 dark:text-zinc-300 dark:hover:bg-white/5"
            >
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 12a4 4 0 1 0 0-8 4 4 0 0 0 0 8Zm-7 9a7 7 0 0 1 14 0"/>
                </svg>
                <span class="mt-1 text-[11px] font-medium">Profile</span>
            </a>

            <a
                href="#upcoming-events"
                class="flex flex-col items-center justify-center rounded-2xl px-3 py-2 text-zinc-600 transition hover:bg-zinc-100 dark:text-zinc-300 dark:hover:bg-white/5"
            >
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 2v3M16 2v3M3.5 9.5h17M5 5h14a1 1 0 0 1 1 1v13a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V6a1 1 0 0 1 1-1Z"/>
                </svg>
                <span class="mt-1 text-[11px] font-medium">Events</span>
            </a>

            <a
                href="#"
                class="flex flex-col items-center justify-center rounded-2xl px-3 py-2 text-zinc-600 transition hover:bg-zinc-100 dark:text-zinc-300 dark:hover:bg-white/5"
            >
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v8m-4-4h8"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M20 12a8 8 0 1 1-16 0a8 8 0 0 1 16 0Z"/>
                </svg>
                <span class="mt-1 text-[11px] font-medium">History</span>
            </a>
        </div>
    </div>
</div>