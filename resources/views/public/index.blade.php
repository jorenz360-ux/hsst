<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
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
    </style>
</head>
<body class="overflow-x-hidden bg-white font-body text-slate-800 antialiased">
<div x-data="{ mobileOpen:false }" class="min-h-screen">

    {{-- HEADER --}}
    <header class="sticky inset-x-0 top-0 z-50 border-b border-white/10 bg-[#0F2A6B]/95 px-4 backdrop-blur-md sm:px-6 lg:px-8">
        <div class="mx-auto flex h-[76px] max-w-[1380px] items-center justify-between">
            <a href="{{ route('home') }}" class="flex min-w-0 items-center gap-3 transition hover:opacity-90">
                <div class="flex h-11 w-11 shrink-0 items-center justify-center overflow-hidden border border-white/20 bg-white p-1 shadow-sm">
                    <img
                        src="{{ asset('images/hsstlogo.jpg') }}"
                        alt="Holy Spirit School of Tagbilaran Logo"
                        class="h-full w-full object-contain"
                    >
                </div>

                <div class="min-w-0">
                    <p class="text-[9px] font-extrabold uppercase tracking-[0.28em] text-white/75">
                        Official Alumni Portal
                    </p>
                    <h1 class="truncate text-[13px] font-bold text-white">
                        Holy Spirit School of Tagbilaran
                    </h1>
                </div>
            </a>

            <nav class="hidden items-center gap-1 lg:flex">
                <a href="{{ route('home') }}" class="px-4 py-2 text-sm font-semibold text-white/85 transition hover:bg-white/10 hover:text-white">
                    Home
                </a>
                <a href="{{ route('about-us') }}" class="px-4 py-2 text-sm font-semibold text-white/85 transition hover:bg-white/10 hover:text-white">
                    About
                </a>
                <a href="{{ route('events.index') }}" class="bg-white px-4 py-2 text-sm font-bold text-[#0F2A6B]">
                    Events
                </a>
                <a href="#event-calendar" class="px-4 py-2 text-sm font-semibold text-white/85 transition hover:bg-white/10 hover:text-white">
                    Calendar
                </a>
                <a href="#upcoming-events" class="px-4 py-2 text-sm font-semibold text-white/85 transition hover:bg-white/10 hover:text-white">
                    Upcoming
                </a>
            </nav>

            <div class="hidden items-center gap-3 lg:flex">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="inline-flex items-center justify-center bg-white px-5 py-2.5 text-sm font-bold text-[#0F2A6B] transition hover:bg-slate-100">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="inline-flex items-center justify-center border border-white/20 bg-white/10 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-white/15">
                            Log in
                        </a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="inline-flex items-center justify-center bg-white px-5 py-2.5 text-sm font-bold text-[#0F2A6B] transition hover:bg-slate-100">
                                Register
                            </a>
                        @endif
                    @endauth
                @endif
            </div>

            <button
                @click="mobileOpen = !mobileOpen"
                :class="mobileOpen ? 'hamburger-open' : ''"
                class="flex flex-col gap-[4.5px] border border-white/20 bg-white/10 p-3 lg:hidden"
                aria-label="Toggle Menu"
            >
                <span class="hamburger-line line-1 block h-[1.5px] w-[20px] rounded bg-white"></span>
                <span class="hamburger-line line-2 block h-[1.5px] w-[20px] rounded bg-white"></span>
                <span class="hamburger-line line-3 block h-[1.5px] w-[20px] rounded bg-white"></span>
            </button>
        </div>
    </header>

    {{-- MOBILE MENU --}}
    <div
        x-cloak
        x-show="mobileOpen"
        x-transition.opacity.duration.200ms
        class="fixed inset-x-0 top-[76px] z-40 border-t border-white/10 bg-[#0F2A6B] px-4 py-5 shadow-2xl lg:hidden"
    >
        <div class="mx-auto max-w-[1380px]">
            <div class="flex flex-col">
                <a @click="mobileOpen=false" href="{{ route('home') }}" class="border-b border-white/10 px-2 py-4 text-base font-semibold text-white/90">Home</a>
                <a @click="mobileOpen=false" href="{{ route('about-us') }}" class="border-b border-white/10 px-2 py-4 text-base font-semibold text-white/90">About</a>
                <a @click="mobileOpen=false" href="{{ route('events.index') }}" class="border-b border-white/10 px-2 py-4 text-base font-semibold text-white/90">Events</a>
                <a @click="mobileOpen=false" href="#event-calendar" class="border-b border-white/10 px-2 py-4 text-base font-semibold text-white/90">Calendar</a>
                <a @click="mobileOpen=false" href="#upcoming-events" class="px-2 py-4 text-base font-semibold text-white/90">Upcoming</a>
            </div>

            @if (Route::has('login'))
                <div class="mt-5 grid gap-3">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="block bg-white px-4 py-4 text-center text-base font-bold text-[#0F2A6B]">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="block border border-white/20 bg-white/10 px-4 py-4 text-center text-base font-semibold text-white">
                            Log in
                        </a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="block bg-white px-4 py-4 text-center text-base font-bold text-[#0F2A6B]">
                                Register
                            </a>
                        @endif
                    @endauth
                </div>
            @endif
        </div>
    </div>

    {{-- HERO --}}
    <section class="relative overflow-hidden">
        <div class="absolute inset-0">
            <div class="h-full w-full bg-[linear-gradient(120deg,#0F2A6B_0%,#1E3A8A_45%,#dbeafe_100%)]"></div>
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,rgba(255,255,255,0.14),transparent_28%)]"></div>
        </div>

        <div class="relative z-10 mx-auto max-w-[1380px] px-4 py-14 sm:px-6 md:py-20 lg:px-8 lg:py-24">
            <div class="grid items-center gap-10 lg:grid-cols-[1.05fr_.95fr]">
                <div>
                    <p class="text-[11px] font-extrabold uppercase tracking-[0.28em] text-white/80">
                        HSST Events & Gatherings
                    </p>

                    <h1 class="mt-5 font-display text-[2.6rem] leading-[1.02] tracking-[-0.02em] text-white sm:text-[3.4rem] lg:text-[4.4rem]">
                        A calendar of return,
                        celebration, and
                        community.
                    </h1>

                    <p class="mt-6 max-w-2xl text-[15px] leading-8 text-white/90 sm:text-base">
                        Explore reunions, school celebrations, alumni programs, and community gatherings through one official public events experience for the HSST community.
                    </p>

                    <div class="mt-8 flex flex-col gap-3 sm:flex-row">
                        <a href="#upcoming-events" class="inline-flex items-center justify-center bg-white px-6 py-3.5 text-sm font-bold uppercase tracking-[0.16em] text-[#0F2A6B] transition hover:bg-slate-100">
                            Explore Events
                        </a>
                        <a href="#event-calendar" class="inline-flex items-center justify-center border border-white/20 bg-white/10 px-6 py-3.5 text-sm font-semibold uppercase tracking-[0.16em] text-white transition hover:bg-white/15">
                            Browse Calendar
                        </a>
                    </div>
                </div>

                @if ($featuredEvent)
                    <div class="border border-white/20 bg-white/10 backdrop-blur-sm">
                        <div class="relative h-[300px] overflow-hidden">
                            <img
                                src="{{ asset('images/100yearsevent.jpg') }}"
                                alt="{{ $featuredEvent->title }}"
                                class="h-full w-full object-cover"
                            >
                            <div class="absolute inset-0 bg-gradient-to-t from-[#0F2A6B]/85 via-[#0F2A6B]/20 to-transparent"></div>

                            <div class="absolute left-5 top-5">
                                <span class="inline-flex bg-white px-3 py-1 text-[10px] font-extrabold uppercase tracking-[0.18em] text-[#0F2A6B]">
                                    Featured Event
                                </span>
                            </div>

                            <div class="absolute inset-x-0 bottom-0 p-5">
                                <h2 class="font-display text-[1.5rem] leading-[1.1] text-white sm:text-[1.9rem]">
                                    {{ $featuredEvent->title }}
                                </h2>
                            </div>
                        </div>

                        <div class="bg-white p-6">
                            <p class="text-[14px] leading-7 text-slate-600">
                                {{ \Illuminate\Support\Str::limit($featuredEvent->description, 180) }}
                            </p>

                            <div class="mt-5 grid gap-3 sm:grid-cols-2">
                                <div class="border border-slate-200 bg-slate-50 p-4">
                                    <div class="text-[10px] font-extrabold uppercase tracking-[0.16em] text-[#1E3A8A]">Date</div>
                                    <div class="mt-2 text-sm font-semibold text-slate-900">
                                        {{ \Carbon\Carbon::parse($featuredEvent->event_date)->format('F d, Y') }}
                                    </div>
                                </div>

                                <div class="border border-slate-200 bg-slate-50 p-4">
                                    <div class="text-[10px] font-extrabold uppercase tracking-[0.16em] text-[#1E3A8A]">Time</div>
                                    <div class="mt-2 text-sm font-semibold text-slate-900">
                                        @if ($featuredEvent->schedules->first()?->schedule_time)
                                            {{ \Carbon\Carbon::parse($featuredEvent->schedules->first()->schedule_time)->format('g:i A') }}
                                        @else
                                            To be announced
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="mt-3 border border-slate-200 bg-slate-50 p-4">
                                <div class="text-[10px] font-extrabold uppercase tracking-[0.16em] text-[#1E3A8A]">Venue</div>
                                <div class="mt-2 text-sm font-semibold text-slate-900">
                                    {{ $featuredEvent->venue ?: 'Venue to be announced' }}
                                </div>
                            </div>

                            <div class="mt-6">
                                <a
                                    href="{{ route('events.show', $featuredEvent) }}"
                                    class="inline-flex w-full items-center justify-center bg-[#1E3A8A] px-5 py-3 text-sm font-bold uppercase tracking-[0.14em] text-white transition hover:bg-[#1E40AF]"
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
    <section id="event-calendar" class="bg-white py-14 md:py-20 lg:py-24">
        <div class="mx-auto max-w-[1380px] px-4 sm:px-6 lg:px-8">
            <div class="mb-10 flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
                <div>
                    <div class="mb-3 inline-flex items-center gap-2 text-[11px] font-extrabold uppercase tracking-[0.22em] text-[#1E3A8A] before:h-px before:w-6 before:bg-[#1E3A8A]/40 before:content-['']">
                        Event Calendar
                    </div>
                    <h2 class="font-display text-[2rem] leading-[1.05] tracking-[-0.02em] text-slate-900 sm:text-[2.45rem]">
                        Browse events by date
                    </h2>
                </div>

                <p class="max-w-[560px] text-[15px] leading-8 text-slate-600">
                    Explore the monthly calendar, then choose a date to view scheduled events.
                </p>
            </div>

            <div class="grid gap-8 xl:grid-cols-[1.2fr_.8fr]">
                <div class="border border-slate-200 bg-white">
                    <div class="flex flex-col gap-4 border-b border-slate-200 px-5 py-5 sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <h3 class="text-lg font-bold text-slate-900">{{ $calendarLabel }}</h3>
                            <p class="mt-1 text-sm text-slate-500">
                                Dates with events show a count.
                            </p>
                        </div>

                        <div class="flex items-center gap-2">
                            <a
                                href="{{ route('events.index', ['month' => $prevMonth, 'date' => $selectedDate]) }}#event-calendar"
                                class="border border-slate-200 px-3 py-2 text-sm font-semibold text-slate-700 transition hover:bg-slate-50"
                            >
                                Prev
                            </a>

                            <a
                                href="{{ route('events.index', ['month' => now()->format('Y-m'), 'date' => now()->toDateString()]) }}#event-calendar"
                                class="bg-[#1E3A8A] px-3 py-2 text-sm font-bold text-white transition hover:bg-[#1E40AF]"
                            >
                                Today
                            </a>

                            <a
                                href="{{ route('events.index', ['month' => $nextMonth, 'date' => $selectedDate]) }}#event-calendar"
                                class="border border-slate-200 px-3 py-2 text-sm font-semibold text-slate-700 transition hover:bg-slate-50"
                            >
                                Next
                            </a>
                        </div>
                    </div>

                    <div class="grid grid-cols-7 border-b border-slate-200 bg-slate-50 text-center text-[11px] font-extrabold uppercase tracking-wide text-slate-500">
                        @foreach (['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'] as $dayName)
                            <div class="px-2 py-3">{{ $dayName }}</div>
                        @endforeach
                    </div>

                    <div class="grid grid-cols-7">
                        @foreach ($calendarDays as $day)
                            <a
                                href="{{ route('events.index', ['month' => $currentMonth, 'date' => $day['date']]) }}#event-calendar"
                                class="
                                    min-h-[110px] border-b border-r border-slate-200 p-2 transition
                                    {{ $day['isCurrentMonth'] ? 'bg-white hover:bg-slate-50' : 'bg-slate-50 text-slate-400' }}
                                    {{ $day['isSelected'] ? 'ring-1 ring-inset ring-[#1E3A8A]' : '' }}
                                "
                            >
                                <div class="flex items-start justify-between">
                                    <span class="
                                        inline-flex h-8 w-8 items-center justify-center rounded-full text-sm font-bold
                                        {{ $day['isToday'] ? 'bg-[#1E3A8A] text-white' : 'text-slate-800' }}
                                    ">
                                        {{ $day['day'] }}
                                    </span>

                                    @if ($day['count'] > 0)
                                        <span class="border border-[#1E3A8A]/15 bg-[#1E3A8A]/10 px-2 py-0.5 text-[11px] font-semibold text-[#1E3A8A]">
                                            {{ $day['count'] }}
                                        </span>
                                    @endif
                                </div>

                                <div class="mt-3 space-y-1">
                                    @foreach (collect($day['events'])->take(2) as $event)
                                        <div class="truncate border border-slate-200 bg-slate-50 px-2 py-1 text-[11px] text-slate-700">
                                            {{ $event->title }}
                                        </div>
                                    @endforeach

                                    @if ($day['count'] > 2)
                                        <div class="text-[11px] text-slate-400">
                                            +{{ $day['count'] - 2 }} more
                                        </div>
                                    @endif
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>

                <div class="border border-slate-200 bg-slate-50">
                    <div class="border-b border-slate-200 bg-white px-5 py-5">
                        <h3 class="text-lg font-bold text-slate-900">{{ $selectedDateLabel }}</h3>
                        <p class="mt-1 text-sm text-slate-500">
                            Events scheduled on the selected date.
                        </p>
                    </div>

                    <div class="p-5">
                        @forelse ($selectedDayEvents as $event)
                            <article class="mb-4 border border-slate-200 bg-white p-4 last:mb-0">
                                <h4 class="font-bold text-slate-900">
                                    {{ $event->title }}
                                </h4>

                                <p class="mt-2 text-sm leading-7 text-slate-600">
                                    {{ \Illuminate\Support\Str::limit($event->description, 120) }}
                                </p>

                                <div class="mt-4 grid gap-3">
                                    <div class="border border-slate-200 bg-slate-50 p-3">
                                        <div class="text-[10px] font-extrabold uppercase tracking-[0.16em] text-[#1E3A8A]">Venue</div>
                                        <div class="mt-1 text-sm font-semibold text-slate-900">
                                            {{ $event->venue ?: 'Venue to be announced' }}
                                        </div>
                                    </div>

                                    <div class="border border-slate-200 bg-slate-50 p-3">
                                        <div class="text-[10px] font-extrabold uppercase tracking-[0.16em] text-[#1E3A8A]">Time</div>
                                        <div class="mt-1 text-sm font-semibold text-slate-900">
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
                                        class="inline-flex w-full items-center justify-center bg-[#1E3A8A] px-4 py-3 text-sm font-bold uppercase tracking-[0.14em] text-white transition hover:bg-[#1E40AF]"
                                    >
                                        View Details
                                    </a>
                                </div>
                            </article>
                        @empty
                            <div class="border border-dashed border-slate-300 bg-white p-6 text-center">
                                <p class="text-sm font-semibold text-slate-700">No events scheduled on this date.</p>
                                <p class="mt-2 text-sm text-slate-500">Try another date or browse the upcoming events below.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- UPCOMING EVENTS --}}
    <section id="upcoming-events" class="bg-slate-50 py-14 md:py-20 lg:py-24">
        <div class="mx-auto max-w-[1380px] px-4 sm:px-6 lg:px-8">
            <div class="mb-10 flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
                <div>
                    <div class="mb-3 inline-flex items-center gap-2 text-[11px] font-extrabold uppercase tracking-[0.22em] text-[#1E3A8A] before:h-px before:w-6 before:bg-[#1E3A8A]/40 before:content-['']">
                        Upcoming Events
                    </div>
                    <h2 class="font-display text-[2rem] leading-[1.05] tracking-[-0.02em] text-slate-900 sm:text-[2.45rem]">
                        All upcoming gatherings
                    </h2>
                </div>

                <p class="max-w-[560px] text-[15px] leading-8 text-slate-600">
                    Browse school-managed events, alumni activities, and celebrations prepared for the HSST community.
                </p>
            </div>

            @if ($events->count())
                <div class="grid gap-10 md:grid-cols-2 xl:grid-cols-2">
                    @foreach ($events as $event)
                        @php
                            $bannerUrl = $event->banner_image
                                ? \Illuminate\Support\Facades\Storage::disk('s3')->url($event->banner_image)
                                : asset('images/100yearsevent.jpg');
                        @endphp

                        <article class="group border-b border-slate-200 pb-8">
                            <div class="relative overflow-hidden bg-slate-100">
                                <img
                                    src="{{ $bannerUrl }}"
                                    alt="{{ $event->title }}"
                                    class="h-[260px] w-full object-cover transition duration-700 group-hover:scale-105"
                                >

                                <div class="absolute inset-0 bg-gradient-to-t from-[#0F2A6B]/45 via-transparent to-transparent"></div>

                                <div class="absolute left-4 top-4">
                                    <span class="inline-flex items-center bg-[#1E3A8A] px-3 py-1 text-[10px] font-extrabold uppercase tracking-[0.2em] text-white">
                                        Upcoming Event
                                    </span>
                                </div>
                            </div>

                            <div class="pt-5">
                                <p class="text-[11px] font-extrabold uppercase tracking-[0.26em] text-[#1E3A8A]">
                                    {{ \Carbon\Carbon::parse($event->event_date)->format('F d, Y') }}
                                    @if ($event->schedules->first()?->schedule_time)
                                        · {{ \Carbon\Carbon::parse($event->schedules->first()->schedule_time)->format('g:i A') }}
                                    @endif
                                </p>

                                <h2 class="mt-3 font-display text-[1.6rem] leading-[1.15] text-slate-900">
                                    <a href="{{ route('events.show', $event) }}" class="transition hover:text-[#1E3A8A]">
                                        {{ $event->title }}
                                    </a>
                                </h2>

                                <p class="mt-4 text-[14px] leading-7 text-slate-600">
                                    {{ \Illuminate\Support\Str::limit($event->description, 170) }}
                                </p>

                                <div class="mt-5 grid gap-3 sm:grid-cols-2">
                                    <div class="border border-slate-200 bg-white p-4">
                                        <div class="text-[10px] font-extrabold uppercase tracking-[0.16em] text-[#1E3A8A]">
                                            Date
                                        </div>
                                        <div class="mt-2 text-sm font-semibold text-slate-900">
                                            {{ \Carbon\Carbon::parse($event->event_date)->format('F d, Y') }}
                                        </div>
                                    </div>

                                    <div class="border border-slate-200 bg-white p-4">
                                        <div class="text-[10px] font-extrabold uppercase tracking-[0.16em] text-[#1E3A8A]">
                                            Venue
                                        </div>
                                        <div class="mt-2 text-sm font-semibold text-slate-900">
                                            {{ $event->venue ?: 'Venue to be announced' }}
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-6 flex flex-col gap-3 sm:flex-row">
                                    <a
                                        href="{{ route('events.show', $event) }}"
                                        class="inline-flex flex-1 items-center justify-center bg-[#1E3A8A] px-5 py-3 text-sm font-bold uppercase tracking-[0.14em] text-white transition hover:bg-[#1E40AF]"
                                    >
                                        View Event
                                    </a>

                                    @if (Route::has('register'))
                                        <a
                                            href="{{ route('register') }}"
                                            class="inline-flex flex-1 items-center justify-center border border-slate-300 bg-white px-5 py-3 text-sm font-semibold text-[#1E3A8A] transition hover:bg-slate-50"
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
                <div class="border-y border-slate-200 py-12 text-center">
                    <div class="mx-auto mb-4 flex h-14 w-14 items-center justify-center bg-[#1E3A8A]/10 text-lg font-bold text-[#1E3A8A]">
                        HS
                    </div>
                    <h2 class="font-display text-[1.7rem] text-slate-900">
                        No upcoming events available
                    </h2>
                    <p class="mx-auto mt-3 max-w-xl text-[14px] leading-7 text-slate-600">
                        Please check back soon for newly scheduled school events, alumni celebrations, and upcoming HSST activities.
                    </p>
                </div>
            @endif
        </div>
    </section>

    {{-- CTA --}}
    <section class="bg-[#1E3A8A] py-14 md:py-20">
        <div class="mx-auto max-w-[1380px] px-4 sm:px-6 lg:px-8">
            <div class="bg-white/10 p-8 backdrop-blur-sm sm:p-10 lg:p-14">
                <div class="grid items-center gap-8 lg:grid-cols-[1.2fr_.8fr]">
                    <div>
                        <div class="mb-3 text-[11px] font-extrabold uppercase tracking-[0.20em] text-white/80">
                            Be part of the next HSST gathering
                        </div>

                        <h2 class="font-display text-[2rem] leading-[1.06] tracking-[-0.02em] text-white sm:text-[2.4rem] lg:text-[2.9rem]">
                            Ready to reconnect with the HSST community?
                        </h2>

                        <p class="mt-4 max-w-2xl text-[15px] leading-8 text-white/90">
                            Create your account to stay updated on alumni events, school programs, and upcoming celebrations through one secure official portal.
                        </p>
                    </div>

                    <div class="flex flex-col gap-3">
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="block bg-white px-6 py-4 text-center text-sm font-bold uppercase tracking-[0.16em] text-[#1E3A8A] transition hover:bg-slate-100">
                                Create Account
                            </a>
                        @endif

                        @if (Route::has('login'))
                            <a href="{{ route('login') }}" class="block border border-white/20 bg-white/10 px-6 py-4 text-center text-sm font-semibold text-white transition hover:bg-white/15">
                                Log in to Existing Account
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- FOOTER --}}
    <footer id="contact" class="bg-white">
        <div class="mx-auto grid max-w-[1380px] gap-10 px-4 py-12 sm:px-6 lg:grid-cols-[1.2fr_0.8fr_0.8fr] lg:px-8">
            <div>
                <div class="flex items-center gap-3">
                    <div class="flex h-11 w-11 items-center justify-center overflow-hidden border border-slate-200 bg-white p-1 shadow-sm">
                        <img src="{{ asset('images/hsstlogo.jpg') }}" alt="HSST Logo" class="h-full w-full object-contain">
                    </div>
                    <div>
                        <p class="text-xs font-extrabold uppercase tracking-[0.2em] text-[#1E3A8A]">Official Alumni Portal</p>
                        <p class="text-base font-bold text-slate-900">Holy Spirit School of Tagbilaran</p>
                    </div>
                </div>

                <p class="mt-5 max-w-md text-sm leading-7 text-slate-600">
                    A digital home for official announcements, school events, alumni activities, and meaningful community connection at Holy Spirit School of Tagbilaran.
                </p>
            </div>

            <div>
                <h4 class="text-sm font-extrabold uppercase tracking-[0.2em] text-[#1E3A8A]">Quick links</h4>
                <div class="mt-4 flex flex-col gap-3 text-sm text-slate-600">
                    <a href="{{ route('home') }}" class="transition hover:text-[#1E3A8A]">Home</a>
                    <a href="{{ route('about-us') }}" class="transition hover:text-[#1E3A8A]">About Us</a>
                    <a href="{{ route('events.index') }}" class="transition hover:text-[#1E3A8A]">Events</a>
                    <a href="#event-calendar" class="transition hover:text-[#1E3A8A]">Calendar</a>
                    <a href="#upcoming-events" class="transition hover:text-[#1E3A8A]">Upcoming</a>
                </div>
            </div>

            <div>
                <h4 class="text-sm font-extrabold uppercase tracking-[0.2em] text-[#1E3A8A]">Account</h4>
                <div class="mt-4 flex flex-col gap-3 text-sm text-slate-600">
                    @if (Route::has('login'))
                        <a href="{{ route('login') }}" class="transition hover:text-[#1E3A8A]">Log in</a>
                    @endif
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="transition hover:text-[#1E3A8A]">Register</a>
                    @endif
                    <a href="{{ url('/dashboard') }}" class="transition hover:text-[#1E3A8A]">Dashboard</a>
                </div>
            </div>
        </div>

        <div class="border-t border-slate-200">
            <div class="mx-auto flex max-w-[1380px] flex-col gap-3 px-4 py-6 text-sm text-slate-500 sm:px-6 md:flex-row md:items-center md:justify-between lg:px-8">
                <p>© 2026 Holy Spirit School of Tagbilaran. All rights reserved.</p>
                <p>Truth in Love · Faith · Learning · Community</p>
            </div>
        </div>
    </footer>

</div>
</body>
</html>