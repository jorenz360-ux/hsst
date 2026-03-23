<!DOCTYPE html>
<html lang="en" class="scroll-smooth dark">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ $event->title }} | Holy Spirit School of Tagbilaran</title>

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
<div x-data="{ mobileOpen:false }">

    {{-- HEADER --}}
    <header class="fixed inset-x-0 top-0 z-50 border-b border-white/10 bg-[#0b0b0c]/70 glass-panel">
        <div class="mx-auto flex h-[80px] max-w-[1320px] items-center justify-between px-5 md:px-6 lg:px-8">
            <a href="{{ route('home') }}" class="flex min-w-0 items-center gap-3">
                <div class="flex h-12 w-12 shrink-0 items-center justify-center overflow-hidden rounded-2xl border border-white/10 bg-white p-1">
                    <img
                        src="{{ asset('images/hsstlogo.jpg') }}"
                        alt="HSST Logo"
                        class="h-full w-full rounded-xl object-contain"
                    >
                </div>

                <div class="min-w-0">
                    <p class="text-[10px] font-semibold uppercase tracking-[0.24em] text-[#c6a56b]">
                        Official Alumni Portal
                    </p>
                    <p class="truncate text-[15px] font-semibold text-white">
                        Holy Spirit School of Tagbilaran
                    </p>
                </div>
            </a>

            <nav class="hidden items-center gap-1 lg:flex">
                <a href="{{ route('home') }}" class="rounded-xl px-4 py-2 text-sm text-[#d6d0c4] transition hover:bg-white/5 hover:text-white">Home</a>
                <a href="{{ route('about-us') }}" class="rounded-xl px-4 py-2 text-sm text-[#d6d0c4] transition hover:bg-white/5 hover:text-white">About</a>
                <a href="{{ route('events.index') }}" class="rounded-xl bg-white/5 px-4 py-2 text-sm text-white">Events</a>
                <a href="#event-details" class="rounded-xl px-4 py-2 text-sm text-[#d6d0c4] transition hover:bg-white/5 hover:text-white">Details</a>
            </nav>

            <div class="hidden items-center gap-2 lg:flex">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="rounded-none bg-[#c6a56b] px-5 py-2.5 text-sm font-semibold text-black transition hover:bg-[#d8b67a]">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="rounded-none border border-white/15 px-4 py-2.5 text-sm font-medium text-[#f5f1e8] transition hover:bg-white/10">
                            Log in
                        </a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="rounded-none bg-[#c6a56b] px-5 py-2.5 text-sm font-semibold text-black transition hover:bg-[#d8b67a]">
                                Register
                            </a>
                        @endif
                    @endauth
                @endif
            </div>

            <button
                @click="mobileOpen = !mobileOpen"
                :class="mobileOpen ? 'hamburger-open' : ''"
                class="flex flex-col gap-[4.5px] rounded-xl border border-white/10 bg-white/5 p-[10px_11px] lg:hidden"
                aria-label="Menu"
            >
                <span class="hamburger-line line-1 block h-[1.5px] w-[18px] rounded bg-slate-200"></span>
                <span class="hamburger-line line-2 block h-[1.5px] w-[18px] rounded bg-slate-200"></span>
                <span class="hamburger-line line-3 block h-[1.5px] w-[18px] rounded bg-slate-200"></span>
            </button>
        </div>
    </header>

    {{-- MOBILE NAV --}}
    <div
        x-cloak
        x-show="mobileOpen"
        x-transition.opacity.duration.200ms
        class="fixed inset-x-0 top-[80px] z-40 border-t border-white/10 bg-[#0b0b0c]/95 px-5 py-5 glass-panel lg:hidden"
    >
        <div class="flex flex-col gap-1">
            <a @click="mobileOpen=false" href="{{ route('home') }}" class="rounded-xl px-4 py-3 text-sm text-[#d6d0c4] hover:bg-white/5 hover:text-white">Home</a>
            <a @click="mobileOpen=false" href="{{ route('about-us') }}" class="rounded-xl px-4 py-3 text-sm text-[#d6d0c4] hover:bg-white/5 hover:text-white">About</a>
            <a @click="mobileOpen=false" href="{{ route('events.index') }}" class="rounded-xl px-4 py-3 text-sm text-[#d6d0c4] hover:bg-white/5 hover:text-white">Events</a>
        </div>
    </div>

    {{-- HERO --}}
    <section class="relative min-h-[75vh] overflow-hidden">
        <div class="absolute inset-0">
            <img
                src="{{ asset('images/100yearsevent.jpg') }}"
                alt="{{ $event->title }}"
                class="h-full w-full object-cover object-center"
            >
        </div>

        <div class="absolute inset-0 bg-black/65"></div>
        <div class="absolute inset-0 bg-[linear-gradient(180deg,rgba(0,0,0,0.42)_0%,rgba(0,0,0,0.75)_65%,rgba(11,11,12,1)_100%)]"></div>

        <div class="relative z-10 mx-auto flex min-h-[75vh] max-w-[1320px] items-end px-5 pb-14 pt-28 md:px-6 lg:px-8">
            <div class="max-w-4xl">
                <p class="text-[11px] font-semibold uppercase tracking-[0.34em] text-[#c6a56b]">
                    Official Event Details
                </p>

                <h1 class="mt-5 font-display text-[2.7rem] leading-[0.95] tracking-[-0.03em] text-white sm:text-[3.8rem] lg:text-[5rem]">
                    {{ $event->title }}
                </h1>

                <div class="mt-6 flex flex-col gap-3 text-sm text-[#d6d0c4] sm:flex-row sm:flex-wrap sm:items-center sm:gap-6">
                    <span>
                        @if ($event->event_date)
                            {{ \Carbon\Carbon::parse($event->event_date)->format('F d, Y') }}
                        @else
                            Date to be announced
                        @endif
                    </span>

                    <span>{{ $event->venue ?: 'Venue to be announced' }}</span>

                    @if ($event->schedules->first()?->schedule_time)
                        <span>{{ \Carbon\Carbon::parse($event->schedules->first()->schedule_time)->format('g:i A') }}</span>
                    @endif
                </div>

                <div class="mt-8 flex flex-col gap-3 sm:flex-row">
                    <a href="{{ route('events.index') }}"
                       class="inline-flex items-center justify-center border border-white/20 px-6 py-3 text-sm font-medium uppercase tracking-[0.16em] text-white transition hover:bg-white/10">
                        Back to Events
                    </a>

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}"
                           class="inline-flex items-center justify-center bg-[#c6a56b] px-6 py-3 text-sm font-semibold uppercase tracking-[0.16em] text-black transition hover:bg-[#d8b67a]">
                            Join the Alumni Portal
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </section>

    {{-- DETAILS --}}
    <section id="event-details" class="bg-[#0b0b0c] py-20 lg:py-24">
        <div class="mx-auto max-w-[1100px] px-5 md:px-6 lg:px-8">

            <div class="grid gap-12 lg:grid-cols-[1.2fr_.8fr]">

                {{-- MAIN CONTENT --}}
                <div>
                    <div>
                        <p class="text-[11px] font-semibold uppercase tracking-[0.30em] text-[#c6a56b]">
                            About This Event
                        </p>
                        <h2 class="mt-4 font-display text-[2rem] leading-[1.04] text-white sm:text-[2.6rem]">
                            Event Overview
                        </h2>
                        <div class="mt-4 h-px w-full bg-white/15"></div>
                    </div>

                    <div class="mt-8 space-y-6 text-[15px] leading-8 text-[#d6d0c4]">
                        @if ($event->description)
                            {!! nl2br(e($event->description)) !!}
                        @else
                            <p>No event description available yet.</p>
                        @endif
                    </div>

                    @if ($event->schedules->isNotEmpty())
                        <div class="mt-16">
                            <p class="text-[11px] font-semibold uppercase tracking-[0.30em] text-[#c6a56b]">
                                Program Flow
                            </p>
                            <h2 class="mt-4 font-display text-[2rem] leading-[1.04] text-white sm:text-[2.6rem]">
                                Event Schedule
                            </h2>
                            <div class="mt-4 h-px w-full bg-white/15"></div>

                            <div class="mt-8 space-y-8">
                                @foreach ($event->schedules as $schedule)
                                    <div class="border-l border-[#c6a56b]/40 pl-5">
                                        <div class="text-[11px] font-semibold uppercase tracking-[0.18em] text-[#c6a56b]">
                                            @if ($schedule->schedule_time)
                                                {{ \Carbon\Carbon::parse($schedule->schedule_time)->format('g:i A') }}
                                            @else
                                                TBA
                                            @endif
                                        </div>

                                        @if ($schedule->title)
                                            <h3 class="mt-2 text-lg font-semibold text-white">
                                                {{ $schedule->title }}
                                            </h3>
                                        @endif

                                        @if ($schedule->description)
                                            <p class="mt-3 text-sm leading-7 text-[#9e988c]">
                                                {{ $schedule->description }}
                                            </p>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

                {{-- SIDEBAR --}}
                <aside class="space-y-5">
                    <div class="border border-white/10 bg-[#111315] p-6">
                        <p class="text-[11px] font-semibold uppercase tracking-[0.20em] text-[#6f6a61]">
                            Event Information
                        </p>

                        <div class="mt-5 space-y-5">
                            <div>
                                <p class="text-[10px] font-semibold uppercase tracking-[0.16em] text-[#6f6a61]">Date</p>
                                <p class="mt-2 text-sm text-white">
                                    @if ($event->event_date)
                                        {{ \Carbon\Carbon::parse($event->event_date)->format('l, F d, Y') }}
                                    @else
                                        To be announced
                                    @endif
                                </p>
                            </div>

                            <div>
                                <p class="text-[10px] font-semibold uppercase tracking-[0.16em] text-[#6f6a61]">Location</p>
                                <p class="mt-2 text-sm text-white">
                                    {{ $event->venue ?: 'Venue to be announced' }}
                                </p>
                            </div>

                            @if ($event->schedules->first()?->schedule_time)
                                <div>
                                    <p class="text-[10px] font-semibold uppercase tracking-[0.16em] text-[#6f6a61]">Time</p>
                                    <p class="mt-2 text-sm text-white">
                                        {{ \Carbon\Carbon::parse($event->schedules->first()->schedule_time)->format('g:i A') }}
                                    </p>
                                </div>
                            @endif

                            @if ($event->dress_code)
                                <div>
                                    <p class="text-[10px] font-semibold uppercase tracking-[0.16em] text-[#6f6a61]">Dress Code</p>
                                    <p class="mt-2 text-sm text-white">
                                        {{ $event->dress_code }}
                                    </p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="border border-[#c6a56b]/20 bg-[#c6a56b]/10 p-6">
                        <p class="text-[11px] font-semibold uppercase tracking-[0.18em] text-[#c6a56b]">
                            Reminder
                        </p>
                        <p class="mt-3 text-sm leading-7 text-[#d6d0c4]">
                            Please check this page again before the event date for updates regarding schedule, venue, and additional instructions.
                        </p>
                    </div>
                </aside>
            </div>
        </div>
    </section>

    {{-- SAME FOOTER --}}
    <footer id="contact" class="border-t border-white/10 bg-[#0b0b0c]">
        <div class="mx-auto grid max-w-[1320px] gap-10 px-5 py-12 md:px-6 lg:grid-cols-[1.3fr_.8fr_.8fr] lg:px-8 lg:py-16">
            <div>
                <a href="{{ route('home') }}" class="flex items-center gap-3">
                    <div class="flex h-11 w-11 shrink-0 items-center justify-center overflow-hidden rounded-2xl border border-white/10 bg-white p-1">
                        <img
                            src="{{ asset('images/hsstlogo.jpg') }}"
                            alt="HSST Logo"
                            class="h-full w-full rounded-xl object-contain"
                        >
                    </div>

                    <div>
                        <p class="text-[10px] font-semibold uppercase tracking-[0.24em] text-[#c6a56b]">
                            Official Alumni Portal
                        </p>
                        <p class="text-[15px] font-semibold text-white">
                            Holy Spirit School of Tagbilaran
                        </p>
                    </div>
                </a>

                <p class="mt-5 max-w-[390px] text-sm leading-7 text-[#9e988c]">
                    A digital home for official announcements, alumni events, school celebrations, and a stronger connection between HSST and its graduates.
                </p>

                <p class="mt-4 text-sm text-[#6f6a61]">
                    Managed by HSST Administration &amp; Alumni Office
                </p>
            </div>

            <div>
                <p class="mb-4 text-[11px] font-semibold uppercase tracking-[0.22em] text-[#6f6a61]">Quick Links</p>
                <div class="space-y-3">
                    <a href="{{ route('home') }}" class="block text-sm text-[#d6d0c4] transition hover:text-white">Home</a>
                    <a href="{{ route('events.index') }}" class="block text-sm text-[#d6d0c4] transition hover:text-white">Events</a>
                    <a href="#event-details" class="block text-sm text-[#d6d0c4] transition hover:text-white">Details</a>
                </div>
            </div>

            <div>
                <p class="mb-4 text-[11px] font-semibold uppercase tracking-[0.22em] text-[#6f6a61]">Account</p>
                <div class="space-y-3">
                    @if (Route::has('login'))
                        <a href="{{ route('login') }}" class="block text-sm text-[#d6d0c4] transition hover:text-white">Log in</a>
                    @endif

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="block text-sm text-[#d6d0c4] transition hover:text-white">Register</a>
                    @endif

                    <a href="{{ url('/dashboard') }}" class="block text-sm text-[#d6d0c4] transition hover:text-white">Dashboard</a>
                </div>
            </div>
        </div>

        <div class="mx-auto flex max-w-[1320px] flex-col gap-2 border-t border-white/10 px-5 py-5 text-sm text-[#6f6a61] md:flex-row md:items-center md:justify-between md:px-6 lg:px-8">
            <p>© 2026 Holy Spirit School of Tagbilaran. All rights reserved.</p>
            <p>Truth in Love · Faith · Learning · Community</p>
        </div>
    </footer>
</div>
</body>
</html>