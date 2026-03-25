<!DOCTYPE html>
<html lang="en" class="scroll-smooth dark">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>HSST Events | Holy Spirit School of Tagbilaran</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        [x-cloak] { display: none !important; }

        .font-body { font-family: "Inter", system-ui, sans-serif; }
        .font-display { font-family: "DM Serif Display", Georgia, serif; }

        .hamburger-line { transition: all .22s ease; }
        .hamburger-open .line-1 { transform: translateY(6px) rotate(45deg); }
        .hamburger-open .line-2 { opacity: 0; }
        .hamburger-open .line-3 { transform: translateY(-6px) rotate(-45deg); }

        .glass-panel {
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
        }
    </style>
</head>
<body class="overflow-x-hidden bg-[#0b0b0c] font-body text-[#f5f1e8] antialiased">
<div x-data="{ mobileOpen:false }" class="min-h-screen">

    {{-- HEADER --}}
    <header class="sticky top-0 z-50 border-b border-white/10 bg-[#0b0b0c]/80 glass-panel">
        <div class="mx-auto max-w-[1320px] px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between py-4">
                <a href="{{ route('home') }}" class="flex items-center gap-4">
                    <div class="flex h-12 w-12 shrink-0 items-center justify-center overflow-hidden rounded-2xl border border-white/10 bg-white p-1 sm:h-14 sm:w-14">
                        <img
                            src="{{ asset('images/hsstlogo.jpg') }}"
                            alt="Holy Spirit School of Tagbilaran Logo"
                            class="h-full w-full rounded-xl object-contain"
                        >
                    </div>

                    <div class="hidden h-10 w-px bg-white/10 sm:block"></div>

                    <div class="min-w-0 leading-tight">
                        <p class="text-[10px] font-semibold uppercase tracking-[0.24em] text-[#c6a56b] sm:text-[11px]">
                            Official Alumni Portal
                        </p>
                        <h1 class="truncate text-sm font-bold text-white sm:text-base lg:text-lg">
                            Holy Spirit School of Tagbilaran
                        </h1>
                        <p class="hidden text-xs text-[#9e988c] md:block">
                            Truth in Love · Faith · Learning · Community
                        </p>
                    </div>
                </a>

                <nav class="hidden items-center gap-1 lg:flex">
                    <a href="{{ route('home') }}" class="rounded-xl px-4 py-2 text-sm font-medium text-[#d6d0c4] transition hover:bg-white/5 hover:text-white">
                        Home
                    </a>
                    <a href="{{ route('about-us') }}" class="rounded-xl px-4 py-2 text-sm font-medium text-[#d6d0c4] transition hover:bg-white/5 hover:text-white">
                        About
                    </a>
                    <a href="{{ route('events.index') }}" class="rounded-xl bg-white/5 px-4 py-2 text-sm font-medium text-white">
                        Events
                    </a>
                    <a href="#event-calendar" class="rounded-xl px-4 py-2 text-sm font-medium text-[#d6d0c4] transition hover:bg-white/5 hover:text-white">
                        Calendar
                    </a>
                    <a href="#upcoming-events" class="rounded-xl px-4 py-2 text-sm font-medium text-[#d6d0c4] transition hover:bg-white/5 hover:text-white">
                        Upcoming
                    </a>
                </nav>

                <div class="hidden items-center gap-2 lg:flex">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="bg-[#c6a56b] px-5 py-2.5 text-sm font-semibold text-black transition hover:bg-[#d8b67a]">
                                Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="border border-white/15 px-5 py-2.5 text-sm font-medium text-[#f5f1e8] transition hover:bg-white/10">
                                Log in
                            </a>

                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="bg-[#c6a56b] px-5 py-2.5 text-sm font-semibold text-black transition hover:bg-[#d8b67a]">
                                    Register
                                </a>
                            @endif
                        @endauth
                    @endif
                </div>

                <button
                    @click="mobileOpen = !mobileOpen"
                    :class="mobileOpen ? 'hamburger-open' : ''"
                    class="flex flex-col gap-[4.5px] rounded-xl border border-white/12 bg-white/5 p-[9px_10px] lg:hidden"
                    aria-label="Toggle Menu"
                >
                    <span class="hamburger-line line-1 block h-[1.5px] w-[18px] rounded bg-slate-300"></span>
                    <span class="hamburger-line line-2 block h-[1.5px] w-[18px] rounded bg-slate-300"></span>
                    <span class="hamburger-line line-3 block h-[1.5px] w-[18px] rounded bg-slate-300"></span>
                </button>
            </div>

            <div
                x-cloak
                x-show="mobileOpen"
                x-transition.opacity.duration.200ms
                class="border-t border-white/10 py-4 lg:hidden"
            >
                <div class="flex flex-col gap-1 text-sm text-[#d6d0c4]">
                    <a @click="mobileOpen=false" href="{{ route('home') }}" class="rounded-xl px-4 py-3 hover:bg-white/5">Home</a>
                    <a @click="mobileOpen=false" href="{{ route('about-us') }}" class="rounded-xl px-4 py-3 hover:bg-white/5">About</a>
                    <a @click="mobileOpen=false" href="{{ route('events.index') }}" class="rounded-xl px-4 py-3 hover:bg-white/5">Events</a>
                    <a @click="mobileOpen=false" href="#event-calendar" class="rounded-xl px-4 py-3 hover:bg-white/5">Calendar</a>
                    <a @click="mobileOpen=false" href="#upcoming-events" class="rounded-xl px-4 py-3 hover:bg-white/5">Upcoming</a>
                </div>
            </div>
        </div>
    </header>

    {{-- HERO --}}
    <section class="relative overflow-hidden py-16 lg:py-24">
        <div class="mx-auto max-w-[1320px] px-5 md:px-6 lg:px-8">
            <div class="grid items-center gap-10 lg:grid-cols-[1.05fr_.95fr]">
                <div>
                    <p class="text-[11px] font-semibold uppercase tracking-[0.28em] text-[#c6a56b]">
                        HSST Events & Gatherings
                    </p>

                    <h1 class="mt-5 font-display text-[2.6rem] leading-[1.02] tracking-[-0.02em] text-white sm:text-[3.4rem] lg:text-[4.4rem]">
                        A calendar of return,
                        celebration, and
                        community.
                    </h1>

                    <p class="mt-6 max-w-2xl text-[15px] leading-8 text-[#d6d0c4] sm:text-base">
                        Explore reunions, school celebrations, alumni programs, and community gatherings through a quieter, more elegant public events experience.
                    </p>

                    <div class="mt-8 flex flex-col gap-3 sm:flex-row">
                        <a href="#upcoming-events" class="inline-flex items-center justify-center bg-[#c6a56b] px-6 py-3.5 text-sm font-semibold uppercase tracking-[0.16em] text-black transition hover:bg-[#d8b67a]">
                            Explore Events
                        </a>
                        <a href="#event-calendar" class="inline-flex items-center justify-center border border-white/15 px-6 py-3.5 text-sm font-medium uppercase tracking-[0.16em] text-white transition hover:bg-white/10">
                            Browse Calendar
                        </a>
                    </div>
                </div>

                @if ($featuredEvent)
                    <div class="overflow-hidden border border-white/10 bg-[#17191c]">
                        <div class="relative h-[300px] overflow-hidden">
                            <img
                                src="{{ asset('images/100yearsevent.jpg') }}"
                                alt="{{ $featuredEvent->title }}"
                                class="h-full w-full object-cover"
                            >
                            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>

                            <div class="absolute left-5 top-5">
                                <span class="inline-flex border border-[#c6a56b]/30 bg-[#c6a56b]/10 px-3 py-1 text-[10px] font-semibold uppercase tracking-[0.16em] text-[#c6a56b]">
                                    Featured Event
                                </span>
                            </div>

                            <div class="absolute inset-x-0 bottom-0 p-5">
                                <h2 class="font-display text-[1.5rem] leading-[1.1] text-white sm:text-[1.9rem]">
                                    {{ $featuredEvent->title }}
                                </h2>
                            </div>
                        </div>

                        <div class="p-6">
                            <p class="text-[14px] leading-7 text-[#9e988c]">
                                {{ \Illuminate\Support\Str::limit($featuredEvent->description, 180) }}
                            </p>

                            <div class="mt-5 grid gap-3 sm:grid-cols-2">
                                <div class="border border-white/10 bg-[#111315] p-4">
                                    <div class="text-[10px] font-semibold uppercase tracking-[0.16em] text-[#6f6a61]">Date</div>
                                    <div class="mt-2 text-sm font-medium text-white">
                                        {{ \Carbon\Carbon::parse($featuredEvent->event_date)->format('F d, Y') }}
                                    </div>
                                </div>

                                <div class="border border-white/10 bg-[#111315] p-4">
                                    <div class="text-[10px] font-semibold uppercase tracking-[0.16em] text-[#6f6a61]">Time</div>
                                    <div class="mt-2 text-sm font-medium text-white">
                                        @if ($featuredEvent->schedules->first()?->schedule_time)
                                            {{ \Carbon\Carbon::parse($featuredEvent->schedules->first()->schedule_time)->format('g:i A') }}
                                        @else
                                            To be announced
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="mt-3 border border-white/10 bg-[#111315] p-4">
                                <div class="text-[10px] font-semibold uppercase tracking-[0.16em] text-[#6f6a61]">Venue</div>
                                <div class="mt-2 text-sm font-medium text-white">
                                    {{ $featuredEvent->venue ?: 'Venue to be announced' }}
                                </div>
                            </div>

                            <div class="mt-6">
                                <a
                                    href="{{ route('events.show', $featuredEvent) }}"
                                    class="inline-flex w-full items-center justify-center bg-[#c6a56b] px-5 py-3 text-sm font-semibold uppercase tracking-[0.14em] text-black transition hover:bg-[#d8b67a]"
                                >
                                    View Featured Event
                                </a>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>

    {{-- CALENDAR --}}
    <section id="event-calendar" class="pb-16 lg:pb-24">
        <div class="mx-auto max-w-[1320px] px-5 md:px-6 lg:px-8">
            <div class="mb-10 flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
                <div>
                    <div class="mb-3 inline-flex items-center gap-2 text-[11px] font-semibold uppercase tracking-[0.22em] text-[#c6a56b] before:h-px before:w-6 before:bg-[#c6a56b]/50 before:content-['']">
                        Event Calendar
                    </div>
                    <h2 class="font-display text-[2rem] leading-[1.05] tracking-[-0.02em] text-white sm:text-[2.45rem]">
                        Browse events by date
                    </h2>
                </div>

                <p class="max-w-[560px] text-[15px] leading-8 text-[#9e988c]">
                    Explore the monthly calendar, then choose a date to view scheduled events.
                </p>
            </div>

            <div class="grid gap-6 xl:grid-cols-[1.2fr_.8fr]">
                <div class="overflow-hidden border border-white/10 bg-[#17191c]">
                    <div class="flex flex-col gap-4 border-b border-white/10 px-5 py-5 sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <h3 class="text-lg font-semibold text-white">{{ $calendarLabel }}</h3>
                            <p class="mt-1 text-sm text-[#9e988c]">
                                Dates with events show a count.
                            </p>
                        </div>

                        <div class="flex items-center gap-2">
                            <a
                                href="{{ route('events.index', ['month' => $prevMonth, 'date' => $selectedDate]) }}#event-calendar"
                                class="border border-white/10 px-3 py-2 text-sm font-medium text-[#d6d0c4] transition hover:bg-white/5"
                            >
                                Prev
                            </a>

                            <a
                                href="{{ route('events.index', ['month' => now()->format('Y-m'), 'date' => now()->toDateString()]) }}#event-calendar"
                                class="bg-[#c6a56b] px-3 py-2 text-sm font-medium text-black transition hover:bg-[#d8b67a]"
                            >
                                Today
                            </a>

                            <a
                                href="{{ route('events.index', ['month' => $nextMonth, 'date' => $selectedDate]) }}#event-calendar"
                                class="border border-white/10 px-3 py-2 text-sm font-medium text-[#d6d0c4] transition hover:bg-white/5"
                            >
                                Next
                            </a>
                        </div>
                    </div>

                    <div class="grid grid-cols-7 border-b border-white/10 bg-[#111315] text-center text-[11px] font-semibold uppercase tracking-wide text-[#6f6a61]">
                        @foreach (['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'] as $dayName)
                            <div class="px-2 py-3">{{ $dayName }}</div>
                        @endforeach
                    </div>

                    <div class="grid grid-cols-7">
                        @foreach ($calendarDays as $day)
                            <a
                                href="{{ route('events.index', ['month' => $currentMonth, 'date' => $day['date']]) }}#event-calendar"
                                class="
                                    min-h-[110px] border-b border-r border-white/10 p-2 transition
                                    {{ $day['isCurrentMonth'] ? 'bg-[#17191c] hover:bg-[#1d2024]' : 'bg-[#111315] text-[#5b5750]' }}
                                    {{ $day['isSelected'] ? 'ring-1 ring-inset ring-[#c6a56b]' : '' }}
                                "
                            >
                                <div class="flex items-start justify-between">
                                    <span class="
                                        inline-flex h-8 w-8 items-center justify-center rounded-full text-sm font-semibold
                                        {{ $day['isToday'] ? 'bg-[#c6a56b] text-black' : 'text-[#d6d0c4]' }}
                                    ">
                                        {{ $day['day'] }}
                                    </span>

                                    @if ($day['count'] > 0)
                                        <span class="border border-[#c6a56b]/25 bg-[#c6a56b]/10 px-2 py-0.5 text-[11px] font-medium text-[#c6a56b]">
                                            {{ $day['count'] }}
                                        </span>
                                    @endif
                                </div>

                                <div class="mt-3 space-y-1">
                                    @foreach (collect($day['events'])->take(2) as $event)
                                        <div class="truncate border border-white/10 bg-[#111315] px-2 py-1 text-[11px] text-[#d6d0c4]">
                                            {{ $event->title }}
                                        </div>
                                    @endforeach

                                    @if ($day['count'] > 2)
                                        <div class="text-[11px] text-[#6f6a61]">
                                            +{{ $day['count'] - 2 }} more
                                        </div>
                                    @endif
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>

                <div class="overflow-hidden border border-white/10 bg-[#17191c]">
                    <div class="border-b border-white/10 px-5 py-5">
                        <h3 class="text-lg font-semibold text-white">{{ $selectedDateLabel }}</h3>
                        <p class="mt-1 text-sm text-[#9e988c]">
                            Events scheduled on the selected date.
                        </p>
                    </div>

                    <div class="p-5">
                        @forelse ($selectedDayEvents as $event)
                            <article class="mb-4 border border-white/10 bg-[#111315] p-4 last:mb-0">
                                <h4 class="font-semibold text-white">
                                    {{ $event->title }}
                                </h4>

                                <p class="mt-2 text-sm leading-7 text-[#9e988c]">
                                    {{ \Illuminate\Support\Str::limit($event->description, 120) }}
                                </p>

                                <div class="mt-4 grid gap-3">
                                    <div class="border border-white/10 bg-[#17191c] p-3">
                                        <div class="text-[10px] font-semibold uppercase tracking-[0.16em] text-[#6f6a61]">Venue</div>
                                        <div class="mt-1 text-sm text-white">
                                            {{ $event->venue ?: 'Venue to be announced' }}
                                        </div>
                                    </div>

                                    <div class="border border-white/10 bg-[#17191c] p-3">
                                        <div class="text-[10px] font-semibold uppercase tracking-[0.16em] text-[#6f6a61]">Time</div>
                                        <div class="mt-1 text-sm text-white">
                                            @if ($event->schedules->first()?->schedule_time)
                                                {{ \Carbon\Carbon::parse($event->schedules->first()->schedule_time)->format('g:i A') }}
                                            @else
                                                To be announced
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-4">
                                    <a
                                        href="{{ route('events.show', $event) }}"
                                        class="inline-flex w-full items-center justify-center bg-[#c6a56b] px-4 py-3 text-sm font-semibold uppercase tracking-[0.14em] text-black transition hover:bg-[#d8b67a]"
                                    >
                                        View Details
                                    </a>
                                </div>
                            </article>
                        @empty
                            <div class="border border-dashed border-white/10 bg-[#111315] p-6 text-center">
                                <p class="text-sm font-medium text-[#d6d0c4]">No events scheduled on this date.</p>
                                <p class="mt-2 text-sm text-[#6f6a61]">Try another date or browse the upcoming events below.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- UPCOMING EVENTS --}}
    <section id="upcoming-events" class="pb-16 lg:pb-24">
        <div class="mx-auto max-w-[1320px] px-5 md:px-6 lg:px-8">
            <div class="mb-10 flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
                <div>
                    <div class="mb-3 inline-flex items-center gap-2 text-[11px] font-semibold uppercase tracking-[0.22em] text-[#c6a56b] before:h-px before:w-6 before:bg-[#c6a56b]/50 before:content-['']">
                        Upcoming Events
                    </div>
                    <h2 class="font-display text-[2rem] leading-[1.05] tracking-[-0.02em] text-white sm:text-[2.45rem]">
                        All upcoming gatherings
                    </h2>
                </div>

                <p class="max-w-[560px] text-[15px] leading-8 text-[#9e988c]">
                    Browse school-managed events, alumni activities, and celebrations prepared for the HSST community.
                </p>
            </div>
 
@if ($events->count())
    <div class="grid gap-8 md:grid-cols-2 xl:grid-cols-2">
        @foreach ($events as $event)
            @php
                $bannerUrl = $event->banner_image
                    ? \Illuminate\Support\Facades\Storage::disk('s3')->url($event->banner_image)
                    : asset('images/100yearsevent.jpg');
            @endphp

            <article class="group overflow-hidden border border-white/8 bg-[#141618] transition duration-300 hover:border-[#c6a56b]/40 hover:bg-[#181b1f]">
                <div class="relative overflow-hidden bg-[#17191c]">
                    <img
                        src="{{ $bannerUrl }}"
                        alt="{{ $event->title }}"
                        class="h-[260px] w-full object-cover transition duration-700 group-hover:scale-105"
                    >

                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/10 to-transparent"></div>

                    <div class="absolute left-4 top-4">
                        <span class="inline-flex items-center bg-black/60 px-3 py-1 text-[10px] font-semibold uppercase tracking-[0.2em] text-white backdrop-blur-sm">
                            Upcoming Event
                        </span>
                    </div>
                </div>

                <div class="p-6">
                    <p class="text-[11px] font-semibold uppercase tracking-[0.26em] text-[#c6a56b]">
                        {{ \Carbon\Carbon::parse($event->event_date)->format('F d, Y') }}
                        @if ($event->schedules->first()?->schedule_time)
                            · {{ \Carbon\Carbon::parse($event->schedules->first()->schedule_time)->format('g:i A') }}
                        @endif
                    </p>

                    <h2 class="mt-3 font-display text-[1.6rem] leading-[1.15] text-white">
                        <a href="{{ route('events.show', $event) }}" class="transition hover:text-[#c6a56b]">
                            {{ $event->title }}
                        </a>
                    </h2>

                    <p class="mt-4 text-[14px] leading-7 text-[#9e988c]">
                        {{ \Illuminate\Support\Str::limit($event->description, 170) }}
                    </p>

                    <div class="mt-5 grid gap-3 sm:grid-cols-2">
                        <div class="border border-white/10 bg-[#111315] p-4">
                            <div class="text-[10px] font-semibold uppercase tracking-[0.16em] text-[#6f6a61]">
                                Date
                            </div>
                            <div class="mt-2 text-sm font-medium text-white">
                                {{ \Carbon\Carbon::parse($event->event_date)->format('F d, Y') }}
                            </div>
                        </div>

                        <div class="border border-white/10 bg-[#111315] p-4">
                            <div class="text-[10px] font-semibold uppercase tracking-[0.16em] text-[#6f6a61]">
                                Venue
                            </div>
                            <div class="mt-2 text-sm font-medium text-white">
                                {{ $event->venue ?: 'Venue to be announced' }}
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 flex flex-col gap-3 sm:flex-row">
                        <a
                            href="{{ route('events.show', $event) }}"
                            class="inline-flex flex-1 items-center justify-center bg-[#c6a56b] px-5 py-3 text-sm font-semibold uppercase tracking-[0.14em] text-black transition hover:bg-[#d8b67a]"
                        >
                            View Event
                        </a>

                        @if (Route::has('register'))
                            <a
                                href="{{ route('register') }}"
                                class="inline-flex flex-1 items-center justify-center border border-white/15 px-5 py-3 text-sm font-medium text-white transition hover:bg-white/10"
                            >
                                Join HSST Portal
                            </a>
                        @endif
                    </div>
                </div>
            </article>
        @endforeach
    </div>

    <div class="mt-10">
        {{ $events->links() }}
    </div>
@else
    <div class="border border-white/10 bg-[#17191c] p-10 text-center">
        <div class="mx-auto mb-4 flex h-14 w-14 items-center justify-center bg-[#c6a56b]/10 text-lg font-bold text-[#c6a56b]">
            HS
        </div>
        <h2 class="font-display text-[1.7rem] text-white">
            No upcoming events available
        </h2>
        <p class="mx-auto mt-3 max-w-xl text-[14px] leading-7 text-[#9e988c]">
            Please check back soon for newly scheduled school events, alumni celebrations, and upcoming HSST activities.
        </p>
    </div>
@endif
        </div>
    </section>

    {{-- CTA --}}
    <section class="pb-20">
        <div class="mx-auto max-w-[1320px] px-5 md:px-6 lg:px-8">
            <div class="border border-white/10 bg-[#111315] p-8 sm:p-10 lg:p-14">
                <div class="grid items-center gap-8 lg:grid-cols-[1.2fr_.8fr]">
                    <div>
                        <div class="mb-3 text-[11px] font-semibold uppercase tracking-[0.20em] text-[#c6a56b]">
                            Be part of the next HSST gathering
                        </div>

                        <h2 class="font-display text-[2rem] leading-[1.06] tracking-[-0.02em] text-white sm:text-[2.4rem] lg:text-[2.9rem]">
                            Ready to reconnect with the HSST community?
                        </h2>

                        <p class="mt-4 max-w-2xl text-[15px] leading-8 text-[#d6d0c4]">
                            Create your account to stay updated on alumni events, school programs, and upcoming celebrations through one secure official portal.
                        </p>
                    </div>

                    <div class="flex flex-col gap-3">
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="block bg-[#c6a56b] px-6 py-4 text-center text-sm font-semibold uppercase tracking-[0.16em] text-black transition hover:bg-[#d8b67a]">
                                Create Account
                            </a>
                        @endif

                        @if (Route::has('login'))
                            <a href="{{ route('login') }}" class="block border border-white/15 px-6 py-4 text-center text-sm font-medium text-white transition hover:bg-white/10">
                                Log in to Existing Account
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- FOOTER --}}
    <footer id="contact" class="border-t border-white/10 bg-[#0b0b0c]">
        <div class="mx-auto grid max-w-[1320px] gap-10 px-4 py-10 sm:px-6 lg:grid-cols-[1.2fr_0.8fr_0.8fr] lg:px-8">
            <div>
                <div class="flex items-center gap-3">
                    <div class="flex h-11 w-11 items-center justify-center overflow-hidden rounded-2xl border border-white/10 bg-white p-1 shadow-sm">
                        <img src="{{ asset('images/hsstlogo.jpg') }}" alt="HSST Logo" class="h-full w-full object-contain">
                    </div>
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.2em] text-[#c6a56b]">Official Alumni Portal</p>
                        <p class="text-base font-bold text-white">Holy Spirit School of Tagbilaran</p>
                    </div>
                </div>

                <p class="mt-5 max-w-md text-sm leading-7 text-[#9e988c]">
                    A digital home for official announcements, school events, alumni activities, and meaningful community connection at Holy Spirit School of Tagbilaran.
                </p>
            </div>

            <div>
                <h4 class="text-sm font-semibold uppercase tracking-[0.2em] text-[#d6d0c4]">Quick links</h4>
                <div class="mt-4 flex flex-col gap-3 text-sm text-[#9e988c]">
                    <a href="{{ route('home') }}" class="transition hover:text-white">Home</a>
                    <a href="{{ route('about-us') }}" class="transition hover:text-white">About Us</a>
                    <a href="{{ route('events.index') }}" class="transition hover:text-white">Events</a>
                    <a href="#event-calendar" class="transition hover:text-white">Calendar</a>
                    <a href="#upcoming-events" class="transition hover:text-white">Upcoming</a>
                </div>
            </div>

            <div>
                <h4 class="text-sm font-semibold uppercase tracking-[0.2em] text-[#d6d0c4]">Account</h4>
                <div class="mt-4 flex flex-col gap-3 text-sm text-[#9e988c]">
                    @if (Route::has('login'))
                        <a href="{{ route('login') }}" class="transition hover:text-white">Log in</a>
                    @endif
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="transition hover:text-white">Register</a>
                    @endif
                    <a href="{{ url('/dashboard') }}" class="transition hover:text-white">Dashboard</a>
                </div>
            </div>
        </div>

        <div class="border-t border-white/10">
            <div class="mx-auto flex max-w-[1320px] flex-col gap-3 px-4 py-6 text-sm text-[#6f6a61] sm:px-6 md:flex-row md:items-center md:justify-between lg:px-8">
                <p>© 2026 Holy Spirit School of Tagbilaran. All rights reserved.</p>
                <p>Truth in Love · Faith · Learning · Community</p>
            </div>
        </div>
    </footer>

</div>
</body>
</html>