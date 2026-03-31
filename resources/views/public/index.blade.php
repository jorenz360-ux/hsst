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

        .eyebrow {
            font-size: 11px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.24em;
        }

        .gold-line {
            width: 52px;
            height: 3px;
            border-radius: 999px;
            background: linear-gradient(90deg, #c4960a, #e8b80f);
        }

        .section-shell {
            border: 1px solid rgba(30, 58, 138, 0.10);
            background: #ffffff;
            box-shadow: 0 18px 48px rgba(15, 42, 107, 0.08);
        }

        .soft-panel {
            border: 1px solid rgba(30, 58, 138, 0.10);
            background: #f8fbff;
        }

        .royal-card {
            border: 1px solid rgba(30, 58, 138, 0.10);
            background: #ffffff;
            transition: transform .28s ease, box-shadow .28s ease, border-color .28s ease;
        }

        .royal-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 50px rgba(15, 42, 107, 0.10);
            border-color: rgba(30, 58, 138, 0.18);
        }

        .hero-glow::before {
            content: "";
            position: absolute;
            inset: 0;
            background:
                radial-gradient(circle at 82% 18%, rgba(255,255,255,0.16), transparent 22%),
                radial-gradient(circle at 78% 30%, rgba(147,197,253,0.18), transparent 28%);
            pointer-events: none;
        }

        .event-image-overlay {
            background: linear-gradient(
                180deg,
                rgba(9,24,82,0.06) 0%,
                rgba(9,24,82,0.18) 40%,
                rgba(9,24,82,0.76) 100%
            );
        }

        .nav-link {
            color: rgba(255,255,255,.78);
            transition: color .2s ease, background .2s ease;
        }

        .nav-link:hover {
            color: #fff;
            background: rgba(255,255,255,.08);
        }

        .nav-link-active {
            background: #fff;
            color: #0F2A6B;
        }

        .hero-pattern {
            position: absolute;
            inset: 0;
            background-image:
                radial-gradient(circle at 20% 25%, rgba(255,255,255,.08) 1px, transparent 1px),
                radial-gradient(circle at 80% 70%, rgba(255,255,255,.07) 1px, transparent 1px);
            background-size: 42px 42px, 52px 52px;
            opacity: .35;
            pointer-events: none;
        }
    </style>
</head>
<body class="overflow-x-hidden bg-white font-body text-slate-800 antialiased">
<div x-data="{ mobileOpen:false }" class="min-h-screen">

    {{-- HEADER --}}
    <header class="sticky inset-x-0 top-0 z-50 border-b border-white/10 bg-[rgba(9,24,82,0.92)] backdrop-blur-md">
        <div class="mx-auto flex h-[78px] max-w-[1380px] items-center justify-between px-4 sm:px-6 lg:px-8">
            <a href="{{ route('home') }}" class="flex min-w-0 items-center gap-3 transition hover:opacity-95">
                <div class="flex h-11 w-11 shrink-0 items-center justify-center overflow-hidden rounded border border-white/18 bg-white p-1 shadow-sm">
                    <img
                        src="{{ asset('images/hsstlogo.jpg') }}"
                        alt="Holy Spirit School of Tagbilaran Logo"
                        class="h-full w-full object-contain"
                    >
                </div>

                <div class="min-w-0">
                    <p class="text-[9px] font-extrabold uppercase tracking-[0.28em] text-white/70">
                        Official Alumni Portal
                    </p>
                    <h1 class="truncate text-[13px] font-bold text-white">
                        Holy Spirit School of Tagbilaran
                    </h1>
                </div>
            </a>

            <nav class="hidden items-center gap-2 lg:flex">
                <a href="{{ route('home') }}" class="nav-link rounded px-4 py-2 text-sm font-semibold">
                    Home
                </a>
                <a href="{{ route('about-us') }}" class="nav-link rounded px-4 py-2 text-sm font-semibold">
                    About
                </a>
                <a href="{{ route('events.index') }}" class="nav-link-active rounded px-4 py-2 text-sm font-bold">
                    Events
                </a>
                <a href="#event-calendar" class="nav-link rounded px-4 py-2 text-sm font-semibold">
                    Calendar
                </a>
                <a href="#upcoming-events" class="nav-link rounded px-4 py-2 text-sm font-semibold">
                    Upcoming
                </a>
            </nav>

            <div class="hidden items-center gap-3 lg:flex">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="inline-flex items-center justify-center rounded bg-white px-5 py-2.5 text-sm font-bold text-[#0F2A6B] transition hover:bg-[#f3f6ff]">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="inline-flex items-center justify-center rounded border border-white/20 bg-white/10 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-white/15">
                            Log in
                        </a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="inline-flex items-center justify-center rounded bg-white px-5 py-2.5 text-sm font-bold text-[#0F2A6B] transition hover:bg-[#f3f6ff]">
                                Register
                            </a>
                        @endif
                    @endauth
                @endif
            </div>

            <button
                @click="mobileOpen = !mobileOpen"
                :class="mobileOpen ? 'hamburger-open' : ''"
                class="flex flex-col gap-[4.5px] rounded border border-white/20 bg-white/10 p-3 lg:hidden"
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
        x-transition.opacity.duration.250ms
        class="fixed inset-0 z-[60] bg-[#153e75] lg:hidden"
    >
        <div class="flex h-full flex-col text-white">
            <div class="flex items-center justify-between border-b border-white/10 px-6 py-5">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.22em] text-white/70">
                        Menu
                    </p>
                    <h2 class="mt-1 text-lg font-bold text-white">
                        HSST Events
                    </h2>
                </div>

                <button
                    type="button"
                    @click="mobileOpen = false"
                    class="inline-flex h-11 w-11 items-center justify-center rounded border border-white/15 text-white transition hover:bg-white/10"
                >
                    ✕
                </button>
            </div>

            <div class="flex-1 overflow-y-auto px-6 py-6">
                <nav class="flex flex-col">
                    <a @click="mobileOpen=false" href="{{ route('home') }}" class="border-b border-white/10 py-4 text-base font-semibold text-white/90">Home</a>
                    <a @click="mobileOpen=false" href="{{ route('about-us') }}" class="border-b border-white/10 py-4 text-base font-semibold text-white/90">About</a>
                    <a @click="mobileOpen=false" href="{{ route('events.index') }}" class="border-b border-white/10 py-4 text-base font-semibold text-white">Events</a>
                    <a @click="mobileOpen=false" href="#event-calendar" class="border-b border-white/10 py-4 text-base font-semibold text-white/90">Calendar</a>
                    <a @click="mobileOpen=false" href="#upcoming-events" class="py-4 text-base font-semibold text-white/90">Upcoming</a>
                </nav>
            </div>

            @if (Route::has('login'))
                <div class="border-t border-white/10 px-6 py-6">
                    <div class="grid gap-3">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="block rounded-xl bg-white px-4 py-4 text-center text-base font-bold text-[#153e75]">
                                Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="block rounded-xl border border-white/20 bg-white/10 px-4 py-4 text-center text-base font-semibold text-white">
                                Log in
                            </a>

                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="block rounded-xl bg-white px-4 py-4 text-center text-base font-bold text-[#153e75]">
                                    Register
                                </a>
                            @endif
                        @endauth
                    </div>
                </div>
            @endif
        </div>
    </div>

    {{-- HERO --}}
<section class="relative overflow-hidden bg-[linear-gradient(150deg,#091852_0%,#0f2580_42%,#1a3fc4_82%,#2952d9_100%)] hero-glow">
    <div class="hero-pattern"></div>
    <div class="absolute inset-0 bg-[linear-gradient(90deg,rgba(9,24,82,0.76)_0%,rgba(9,24,82,0.56)_45%,rgba(9,24,82,0.18)_100%)]"></div>

    <div class="relative z-10 mx-auto max-w-[1380px] px-4 py-16 sm:px-6 md:py-24 lg:px-8 lg:py-28">
        <div class="grid items-center gap-10 lg:grid-cols-[1.05fr_.95fr]">
            <div>
                <p class="eyebrow text-[#dbeafe]">
                    HSST Events & Gatherings
                </p>

                <div class="gold-line mt-4"></div>

                <h1 class="mt-6 font-display text-[2.7rem] leading-[1.02] tracking-[-0.02em] text-white sm:text-[3.5rem] lg:text-[4.6rem]">
                    A calendar of return,
                    celebration, and
                    community.
                </h1>

                <p class="mt-6 max-w-2xl text-[15px] leading-8 text-white/85 sm:text-base">
                    Explore reunions, school celebrations, alumni programs, and community gatherings through one official public events experience for the HSST community.
                </p>

                <div class="mt-8 flex flex-col gap-3 sm:flex-row">
                    <a href="#upcoming-events" class="inline-flex items-center justify-center rounded bg-white px-7 py-3.5 text-sm font-bold uppercase tracking-[0.16em] text-[#0F2A6B] transition hover:bg-[#f3f6ff]">
                        Explore Events
                    </a>
                    <a href="#event-calendar" class="inline-flex items-center justify-center rounded border border-white/20 bg-white/10 px-7 py-3.5 text-sm font-semibold uppercase tracking-[0.16em] text-white transition hover:bg-white/15">
                        Browse Calendar
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

   {{-- CALENDAR --}}
    <section id="event-calendar" class="bg-[#eef4ff] py-16 md:py-20 lg:py-24">
        <div class="mx-auto max-w-[1380px] px-4 sm:px-6 lg:px-8">
            <div class="mb-10 flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
                <div>
                    <div class="eyebrow text-[#1E3A8A]">Event Calendar</div>
                    <div class="gold-line my-4"></div>
                    <h2 class="font-display text-[2rem] leading-[1.05] tracking-[-0.02em] text-[#091852] sm:text-[2.6rem]">
                        Browse events by date
                    </h2>
                </div>

                <p class="max-w-[560px] text-[15px] leading-8 text-slate-600">
                    Explore the monthly calendar, then choose a date to view scheduled events.
                </p>
            </div>

            <div class="grid gap-8 xl:grid-cols-[1.2fr_.8fr]">
                {{-- CALENDAR PANEL --}}
                <div class="overflow-hidden rounded-none border-0 bg-transparent shadow-none sm:rounded-[2rem] sm:border sm:border-[#d9e5ff] sm:bg-white sm:shadow-[0_18px_40px_rgba(15,23,42,0.06)]">
                    <div class="flex flex-col gap-4 border-b border-[#d9e5ff] px-0 py-0 sm:px-5 sm:py-5 sm:flex-row sm:items-center sm:justify-between">
                        <div class="px-0 pt-0 sm:px-0 sm:pt-0">
                            <h3 class="text-lg font-bold text-[#091852]">{{ $calendarLabel }}</h3>
                            <p class="mt-1 text-sm text-slate-500">
                                Dates with events show a count.
                            </p>
                        </div>

                        <div class="flex items-center gap-2 overflow-x-auto pb-1 sm:pb-0">
                            <a
                                href="{{ route('events.index', ['month' => $prevMonth, 'date' => $selectedDate]) }}#event-calendar"
                                class="shrink-0 rounded border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700 transition hover:bg-slate-50"
                            >
                                Prev
                            </a>

                            <a
                                href="{{ route('events.index', ['month' => now()->format('Y-m'), 'date' => now()->toDateString()]) }}#event-calendar"
                                class="shrink-0 rounded bg-[#153e75] px-4 py-2 text-sm font-bold text-white transition hover:bg-[#0f2f5c]"
                            >
                                Today
                            </a>

                            <a
                                href="{{ route('events.index', ['month' => $nextMonth, 'date' => $selectedDate]) }}#event-calendar"
                                class="shrink-0 rounded border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700 transition hover:bg-slate-50"
                            >
                                Next
                            </a>
                        </div>
                    </div>

                    <div class="mt-5 sm:mt-0">
                        <div class="grid grid-cols-7 border-y border-[#d9e5ff] bg-[#f8fbff] text-center text-[10px] font-extrabold uppercase tracking-wide text-slate-500 sm:text-[11px]">
                            @foreach (['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'] as $dayName)
                                <div class="px-1 py-3 sm:px-2">{{ $dayName }}</div>
                            @endforeach
                        </div>

                        <div class="grid grid-cols-7">
                            @foreach ($calendarDays as $day)
                                <a
                                    href="{{ route('events.index', ['month' => $currentMonth, 'date' => $day['date']]) }}#event-calendar"
                                    class="
                                        min-h-[88px] border-b border-r border-[#d9e5ff] p-2 transition sm:min-h-[118px] sm:p-3
                                        {{ $day['isCurrentMonth'] ? 'bg-white hover:bg-[#f8fbff]' : 'bg-[#f3f7ff] text-slate-400' }}
                                        {{ $day['isSelected'] ? 'ring-2 ring-inset ring-[#153e75]' : '' }}
                                    "
                                >
                                    <div class="flex items-start justify-between gap-1">
                                        <span class="
                                            inline-flex h-7 w-7 items-center justify-center rounded text-xs font-bold sm:h-8 sm:w-8 sm:text-sm
                                            {{ $day['isToday'] ? 'bg-[#153e75] text-white' : 'text-slate-800' }}
                                        ">
                                            {{ $day['day'] }}
                                        </span>

                                        @if ($day['count'] > 0)
                                            <span class="rounded border border-[#1E3A8A]/15 bg-[#eaf1ff] px-1.5 py-0.5 text-[10px] font-semibold text-[#153e75] sm:px-2 sm:text-[11px]">
                                                {{ $day['count'] }}
                                            </span>
                                        @endif
                                    </div>

                                    <div class="mt-2 space-y-1 sm:mt-3 sm:space-y-1.5">
                                        @foreach (collect($day['events'])->take(2) as $event)
                                            <div class="truncate rounded-md border border-[#dbe7ff] bg-[#f8fbff] px-1.5 py-1 text-[10px] font-medium text-[#153e75] sm:rounded-lg sm:px-2 sm:text-[11px]">
                                                {{ $event->title }}
                                            </div>
                                        @endforeach

                                        @if ($day['count'] > 2)
                                            <div class="text-[10px] text-slate-400 sm:text-[11px]">
                                                +{{ $day['count'] - 2 }} more
                                            </div>
                                        @endif
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- SELECTED DATE EVENTS PANEL --}}
                <div class="overflow-hidden rounded-none border-0 bg-transparent shadow-none sm:rounded-[2rem] sm:border sm:border-[#d9e5ff] sm:bg-[#f8fbff] sm:shadow-[0_18px_40px_rgba(15,23,42,0.06)]">
                    <div class="border-b border-[#d9e5ff] bg-transparent px-0 py-0 sm:bg-white sm:px-5 sm:py-5">
                        <h3 class="text-lg font-bold text-[#091852]">{{ $selectedDateLabel }}</h3>
                        <p class="mt-1 text-sm text-slate-500">
                            Events scheduled on the selected date.
                        </p>
                    </div>

                    <div class="px-0 py-5 sm:p-5">
                        @forelse ($selectedDayEvents as $event)
                            <article class="mb-5 rounded-none border-0 bg-transparent p-0 last:mb-0 sm:rounded-[1.5rem] sm:border sm:border-[#dbe7ff] sm:bg-white sm:p-4">
                                <h4 class="font-bold text-slate-900">
                                    {{ $event->title }}
                                </h4>

                                <p class="mt-2 text-sm leading-7 text-slate-600">
                                    {{ \Illuminate\Support\Str::limit($event->description, 120) }}
                                </p>

                                <div class="mt-4 grid gap-3">
                                    <div class="rounded-2xl bg-white/70 p-3 sm:border sm:border-[#dbe7ff] sm:bg-white">
                                        <div class="text-[10px] font-extrabold uppercase tracking-[0.16em] text-[#1E3A8A]">Venue</div>
                                        <div class="mt-1 text-sm font-semibold text-slate-900">
                                            {{ $event->venue ?: 'Venue to be announced' }}
                                        </div>
                                    </div>

                                    <div class="rounded-2xl bg-white/70 p-3 sm:border sm:border-[#dbe7ff] sm:bg-white">
                                        <div class="text-[10px] font-extrabold uppercase tracking-[0.16em] text-[#1E3A8A]">Time</div>
                                        <div class="mt-1 text-sm font-semibold text-slate-900">
                                            {{ \Carbon\Carbon::parse($event->event_date)->format('g:i A') }}
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-4">
                                    <a
                                        href="{{ route('events.show', $event) }}"
                                        class="inline-flex w-full items-center justify-center rounded bg-[#153e75] px-4 py-3 text-sm font-bold uppercase tracking-[0.14em] text-white transition hover:bg-[#0f2f5c]"
                                    >
                                        View Details
                                    </a>
                                </div>
                            </article>
                        @empty
                            <div class="rounded-none border-0 bg-transparent p-0 text-center sm:rounded-[1.5rem] sm:border sm:border-dashed sm:border-[#c7d8ff] sm:bg-white sm:p-6">
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
    <section id="upcoming-events" class="bg-white py-16 md:py-20 lg:py-24">
        <div class="mx-auto max-w-[1380px] px-4 sm:px-6 lg:px-8">
            <div class="mb-10 flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
                <div>
                    <div class="eyebrow text-[#1E3A8A]">Upcoming Events</div>
                    <div class="gold-line my-4"></div>
                    <h2 class="font-display text-[2rem] leading-[1.05] tracking-[-0.02em] text-[#091852] sm:text-[2.6rem]">
                        All upcoming gatherings
                    </h2>
                </div>

                <p class="max-w-[560px] text-[15px] leading-8 text-slate-600">
                    Browse school-managed events, alumni activities, and celebrations prepared for the HSST community.
                </p>
            </div>

            @if ($events->count())
                <div class="grid gap-8 md:grid-cols-3 xl:grid-cols-3">
                    @foreach ($events as $event)
                        @php
                            $bannerUrl = $event->banner_image
                                ? \Illuminate\Support\Facades\Storage::disk('s3')->url($event->banner_image)
                                : asset('images/100yearsevent.jpg');
                        @endphp

                        <article class="group flex h-full flex-col overflow-hidden rounded-none border-0 bg-transparent shadow-none sm:rounded-[1rem] sm:border sm:border-slate-200 sm:bg-white sm:shadow-[0_18px_40px_rgba(15,23,42,0.06)]">
                            {{-- IMAGE --}}
                            <div class="relative overflow-hidden bg-slate-100">
                                <img
                                    src="{{ $bannerUrl }}"
                                    alt="{{ $event->title }}"
                                    class="h-[240px] w-full object-cover transition duration-700 group-hover:scale-105 sm:h-[280px]"
                                >

                                <div class="absolute inset-0 event-image-overlay"></div>

                                <div class="absolute left-4 top-4">
                                    <span class="inline-flex items-center rounded bg-white px-3 py-1 text-[10px] font-extrabold uppercase tracking-[0.2em] text-[#153e75] shadow-sm">
                                        Upcoming Event
                                    </span>
                                </div>
                            </div>

                            {{-- CONTENT --}}
                            <div class="flex flex-1 flex-col px-0 pb-0 pt-5 sm:p-6 sm:p-7">

                                {{-- DATE --}}
                                <p class="text-[11px] font-extrabold uppercase tracking-[0.22em] text-[#1E3A8A] sm:tracking-[0.26em]">
                                    {{ \Carbon\Carbon::parse($event->event_date)->format('F d, Y') }}
                                    · {{ \Carbon\Carbon::parse($event->event_date)->format('g:i A') }}
                                </p>

                                {{-- TITLE --}}
                                <h2 class="mt-3 font-display text-[1.45rem] leading-[1.15] text-[#091852] sm:text-[1.75rem] sm:leading-[1.12]">
                                    <a href="{{ route('events.show', $event) }}" class="transition hover:text-[#153e75]">
                                        {{ $event->title }}
                                    </a>
                                </h2>

                                {{-- DESCRIPTION --}}
                                <p class="mt-4 text-[14px] leading-7 text-slate-600">
                                    {{ \Illuminate\Support\Str::limit($event->description, 170) }}
                                </p>

                                {{-- BUTTON --}}
                                <div class="mt-auto pt-6">
                                    <a
                                        href="{{ route('events.show', $event) }}"
                                        class="inline-flex w-full items-center justify-center rounded bg-[#153e75] px-5 py-3 text-sm font-bold uppercase tracking-[0.14em] text-white transition hover:bg-[#0f2f5c]"
                                    >
                                        READ MORE →
                                    </a>
                                </div>

                            </div>
                        </article>
                    @endforeach
                </div>

                <div class="mt-10">
                    {{ $events->links() }}
                </div>
            @else
                <div class="py-12 text-center sm:rounded-[2rem] sm:border sm:border-slate-200 sm:bg-white sm:px-6 sm:shadow-[0_18px_40px_rgba(15,23,42,0.06)]">
                    <div class="mx-auto mb-4 flex h-14 w-14 items-center justify-center rounded bg-[#1E3A8A]/10 text-lg font-bold text-[#1E3A8A]">
                        HS
                    </div>
                    <h2 class="font-display text-[1.8rem] text-slate-900">
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
    <section class="bg-[linear-gradient(150deg,#091852,#1a3fc4)] py-16 md:py-20">
        <div class="mx-auto max-w-[1380px] px-4 sm:px-6 lg:px-8">
            <div class="overflow-hidden rounded-[2rem] border border-white/12 bg-white/10 p-8 backdrop-blur-sm sm:p-10 lg:p-14">
                <div class="grid items-center gap-8 lg:grid-cols-[1.2fr_.8fr]">
                    <div>
                        <div class="eyebrow text-white/75">
                            Be part of the next HSST gathering
                        </div>

                        <div class="gold-line my-4"></div>

                        <h2 class="font-display text-[2rem] leading-[1.06] tracking-[-0.02em] text-white sm:text-[2.4rem] lg:text-[3rem]">
                            Ready to reconnect with the HSST community?
                        </h2>

                        <p class="mt-4 max-w-2xl text-[15px] leading-8 text-white/85">
                            Create your account to stay updated on alumni events, school programs, and upcoming celebrations through one secure official portal.
                        </p>
                    </div>

                    <div class="flex flex-col gap-3">
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="block rounded bg-white px-6 py-4 text-center text-sm font-bold uppercase tracking-[0.16em] text-[#153e75] transition hover:bg-[#f3f6ff]">
                                Create Account
                            </a>
                        @endif

                        @if (Route::has('login'))
                            <a href="{{ route('login') }}" class="block rounded border border-white/20 bg-white/10 px-6 py-4 text-center text-sm font-semibold text-white transition hover:bg-white/15">
                                Log in to Existing Account
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- FOOTER --}}
    <footer id="contact" class="bg-[#091852] pt-16 pb-8">
        <div class="mx-auto grid max-w-[1380px] gap-10 px-4 sm:px-6 lg:grid-cols-[1.2fr_0.8fr_0.8fr] lg:px-8">
            <div>
                <div class="flex items-center gap-3">
                    <div class="flex h-11 w-11 items-center justify-center overflow-hidden rounded border border-white/15 bg-white p-1 shadow-sm">
                        <img src="{{ asset('images/hsstlogo.jpg') }}" alt="HSST Logo" class="h-full w-full object-contain">
                    </div>
                    <div>
                        <p class="text-xs font-extrabold uppercase tracking-[0.2em] text-white/65">Official Alumni Portal</p>
                        <p class="text-base font-bold text-white">Holy Spirit School of Tagbilaran</p>
                    </div>
                </div>

                <p class="mt-5 max-w-md text-sm leading-7 text-white/55">
                    A digital home for official announcements, school events, alumni activities, and meaningful community connection at Holy Spirit School of Tagbilaran.
                </p>
            </div>

            <div>
                <h4 class="text-sm font-extrabold uppercase tracking-[0.2em] text-white/70">Quick links</h4>
                <div class="mt-4 flex flex-col gap-3 text-sm text-white/55">
                    <a href="{{ route('home') }}" class="transition hover:text-white">Home</a>
                    {{-- <a href="{{ route('about-us') }}" class="transition hover:text-white">About Us</a> --}}
                    <a href="{{ route('events.index') }}" class="transition hover:text-white">Events</a>
                    <a href="#event-calendar" class="transition hover:text-white">Calendar</a>
                    <a href="#upcoming-events" class="transition hover:text-white">Upcoming</a>
                </div>
            </div>

            <div>
                <h4 class="text-sm font-extrabold uppercase tracking-[0.2em] text-white/70">Account</h4>
                <div class="mt-4 flex flex-col gap-3 text-sm text-white/55">
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

        <div class="mt-10 border-t border-white/10">
            <div class="mx-auto flex max-w-[1380px] flex-col gap-3 px-4 py-6 text-sm text-white/40 sm:px-6 md:flex-row md:items-center md:justify-between lg:px-8">
                <p>© {{ now('Asia/Manila')->format('Y') }} Holy Spirit School of Tagbilaran. All rights reserved.</p>
                <p class="text-[#d4af37]">Truth in Love · Faith · Learning · Community</p>
            </div>
        </div>
    </footer>

</div>
</body>
</html>