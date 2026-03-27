<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
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
                        alt="HSST Logo"
                        class="h-full w-full object-contain"
                    >
                </div>

                <div class="min-w-0">
                    <p class="text-[9px] font-extrabold uppercase tracking-[0.28em] text-white/75">
                        Official Alumni Portal
                    </p>
                    <p class="truncate text-[13px] font-bold text-white">
                        Holy Spirit School of Tagbilaran
                    </p>
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
                <a href="#event-details" class="px-4 py-2 text-sm font-semibold text-white/85 transition hover:bg-white/10 hover:text-white">
                    Details
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
                aria-label="Menu"
            >
                <span class="hamburger-line line-1 block h-[1.5px] w-[20px] rounded bg-white"></span>
                <span class="hamburger-line line-2 block h-[1.5px] w-[20px] rounded bg-white"></span>
                <span class="hamburger-line line-3 block h-[1.5px] w-[20px] rounded bg-white"></span>
            </button>
        </div>
    </header>

    {{-- MOBILE NAV --}}
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
                <a @click="mobileOpen=false" href="{{ route('events.index') }}" class="px-2 py-4 text-base font-semibold text-white/90">Events</a>
            </div>
        </div>
    </div>

    {{-- HERO --}}
    <section class="relative overflow-hidden">
        <div class="absolute inset-0">
            <img
                src="{{ asset('images/100yearsevent.jpg') }}"
                alt="{{ $event->title }}"
                class="h-full w-full object-cover object-center"
            >
            <div class="absolute inset-0 bg-[linear-gradient(90deg,rgba(15,42,107,0.92)_0%,rgba(15,42,107,0.78)_38%,rgba(15,42,107,0.48)_62%,rgba(15,42,107,0.25)_100%)]"></div>
            <div class="absolute inset-0 bg-[linear-gradient(180deg,rgba(15,42,107,0.08)_0%,rgba(15,42,107,0.62)_78%,rgba(255,255,255,1)_100%)]"></div>
        </div>

        <div class="relative z-10 mx-auto flex min-h-[72vh] max-w-[1380px] items-end px-4 pb-14 pt-28 sm:px-6 lg:px-8 lg:pb-16">
            <div class="max-w-4xl">
                <p class="text-[11px] font-extrabold uppercase tracking-[0.32em] text-white/85">
                    Official Event Details
                </p>

                <h1 class="mt-5 font-display text-[2.7rem] leading-[0.96] tracking-[-0.03em] text-white sm:text-[3.8rem] lg:text-[5rem]">
                    {{ $event->title }}
                </h1>

                <div class="mt-6 flex flex-col gap-3 text-sm text-white/85 sm:flex-row sm:flex-wrap sm:items-center sm:gap-6">
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
                    <a
                        href="{{ route('events.index') }}"
                        class="inline-flex items-center justify-center border border-white/20 bg-white/10 px-6 py-3 text-sm font-semibold uppercase tracking-[0.16em] text-white transition hover:bg-white/15"
                    >
                        Back to Events
                    </a>

                    @if (Route::has('register'))
                        <a
                            href="{{ route('register') }}"
                            class="inline-flex items-center justify-center bg-white px-6 py-3 text-sm font-bold uppercase tracking-[0.16em] text-[#0F2A6B] transition hover:bg-slate-100"
                        >
                            Join the Alumni Portal
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </section>

    {{-- CONTENT --}}
    <section id="event-details" class="bg-white py-14 md:py-20 lg:py-24">
        <div class="mx-auto max-w-[1180px] px-4 sm:px-6 lg:px-8">
            <div class="grid gap-12 lg:grid-cols-[1.2fr_.8fr]">

                {{-- MAIN CONTENT --}}
                <div>
                    <div>
                        <p class="text-[11px] font-extrabold uppercase tracking-[0.30em] text-[#1E3A8A]">
                            About This Event
                        </p>
                        <h2 class="mt-4 font-display text-[2rem] leading-[1.04] text-slate-900 sm:text-[2.6rem]">
                            Event Overview
                        </h2>
                        <div class="mt-4 h-px w-full bg-slate-200"></div>
                    </div>

                    <div class="mt-8 space-y-6 text-[15px] leading-8 text-slate-600">
                        @if ($event->description)
                            {!! nl2br(e($event->description)) !!}
                        @else
                            <p>No event description available yet.</p>
                        @endif
                    </div>

                    @if ($event->schedules->isNotEmpty())
                        <div class="mt-16">
                            <p class="text-[11px] font-extrabold uppercase tracking-[0.30em] text-[#1E3A8A]">
                                Program Flow
                            </p>
                            <h2 class="mt-4 font-display text-[2rem] leading-[1.04] text-slate-900 sm:text-[2.6rem]">
                                Event Schedule
                            </h2>
                            <div class="mt-4 h-px w-full bg-slate-200"></div>

                            <div class="mt-8 space-y-8">
                                @foreach ($event->schedules as $schedule)
                                    <div class="border-l-2 border-[#1E3A8A]/25 pl-5">
                                        <div class="text-[11px] font-extrabold uppercase tracking-[0.18em] text-[#1E3A8A]">
                                            @if ($schedule->schedule_time)
                                                {{ \Carbon\Carbon::parse($schedule->schedule_time)->format('g:i A') }}
                                            @else
                                                TBA
                                            @endif
                                        </div>

                                        @if ($schedule->title)
                                            <h3 class="mt-2 text-lg font-bold text-slate-900">
                                                {{ $schedule->title }}
                                            </h3>
                                        @endif

                                        @if ($schedule->description)
                                            <p class="mt-3 text-sm leading-7 text-slate-600">
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
                    <div class="border border-slate-200 bg-slate-50 p-6">
                        <p class="text-[11px] font-extrabold uppercase tracking-[0.20em] text-[#1E3A8A]">
                            Event Information
                        </p>

                        <div class="mt-5 space-y-5">
                            <div>
                                <p class="text-[10px] font-extrabold uppercase tracking-[0.16em] text-slate-500">Date</p>
                                <p class="mt-2 text-sm font-semibold text-slate-900">
                                    @if ($event->event_date)
                                        {{ \Carbon\Carbon::parse($event->event_date)->format('l, F d, Y') }}
                                    @else
                                        To be announced
                                    @endif
                                </p>
                            </div>

                            <div>
                                <p class="text-[10px] font-extrabold uppercase tracking-[0.16em] text-slate-500">Location</p>
                                <p class="mt-2 text-sm font-semibold text-slate-900">
                                    {{ $event->venue ?: 'Venue to be announced' }}
                                </p>
                            </div>

                            @if ($event->schedules->first()?->schedule_time)
                                <div>
                                    <p class="text-[10px] font-extrabold uppercase tracking-[0.16em] text-slate-500">Time</p>
                                    <p class="mt-2 text-sm font-semibold text-slate-900">
                                        {{ \Carbon\Carbon::parse($event->schedules->first()->schedule_time)->format('g:i A') }}
                                    </p>
                                </div>
                            @endif

                            @if ($event->dress_code)
                                <div>
                                    <p class="text-[10px] font-extrabold uppercase tracking-[0.16em] text-slate-500">Dress Code</p>
                                    <p class="mt-2 text-sm font-semibold text-slate-900">
                                        {{ $event->dress_code }}
                                    </p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="border border-[#1E3A8A]/15 bg-[#1E3A8A]/5 p-6">
                        <p class="text-[11px] font-extrabold uppercase tracking-[0.18em] text-[#1E3A8A]">
                            Reminder
                        </p>
                        <p class="mt-3 text-sm leading-7 text-slate-600">
                            Please check this page again before the event date for updates regarding schedule, venue, and additional instructions.
                        </p>
                    </div>
                </aside>
            </div>
        </div>
    </section>

    {{-- CTA --}}
    <section class="bg-[#1E3A8A] py-14 md:py-20">
        <div class="mx-auto max-w-[1380px] px-4 sm:px-6 lg:px-8">
            <div class="grid gap-8 lg:grid-cols-[1.2fr_.8fr] lg:items-center">
                <div>
                    <p class="text-[11px] font-extrabold uppercase tracking-[0.30em] text-white/80">
                        Stay Connected
                    </p>
                    <h2 class="mt-4 font-display text-[1.9rem] leading-[1.08] text-white sm:text-[2.5rem] lg:text-[3rem]">
                        Be part of upcoming HSST events and alumni activities
                    </h2>
                    <p class="mt-5 max-w-2xl text-base leading-8 text-white/90">
                        Create your account to receive updates, stay informed, and reconnect through one official HSST alumni platform.
                    </p>
                </div>

                <div class="flex flex-col gap-4">
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
    </section>

    {{-- FOOTER --}}
    <footer id="contact" class="bg-white">
        <div class="mx-auto grid max-w-[1380px] gap-10 px-4 py-12 sm:px-6 lg:grid-cols-[1.3fr_.8fr_.8fr] lg:px-8 lg:py-16">
            <div>
                <a href="{{ route('home') }}" class="flex items-center gap-3">
                    <div class="flex h-11 w-11 shrink-0 items-center justify-center overflow-hidden border border-slate-200 bg-white p-1 shadow-sm">
                        <img
                            src="{{ asset('images/hsstlogo.jpg') }}"
                            alt="HSST Logo"
                            class="h-full w-full object-contain"
                        >
                    </div>

                    <div>
                        <p class="text-[10px] font-extrabold uppercase tracking-[0.22em] text-[#1E3A8A]">
                            Official Alumni Portal
                        </p>
                        <p class="text-[15px] font-bold text-slate-900">
                            Holy Spirit School of Tagbilaran
                        </p>
                    </div>
                </a>

                <p class="mt-5 max-w-[390px] text-sm leading-7 text-slate-600">
                    A digital home for official announcements, alumni events, school celebrations, and a stronger connection between HSST and its graduates.
                </p>

                <p class="mt-4 text-sm text-slate-500">
                    Managed by HSST Administration &amp; Alumni Office
                </p>
            </div>

            <div>
                <p class="mb-4 text-[11px] font-extrabold uppercase tracking-[0.22em] text-[#1E3A8A]">Quick Links</p>
                <div class="space-y-3">
                    <a href="{{ route('home') }}" class="block text-sm text-slate-600 transition hover:text-[#1E3A8A]">Home</a>
                    <a href="{{ route('events.index') }}" class="block text-sm text-slate-600 transition hover:text-[#1E3A8A]">Events</a>
                    <a href="#event-details" class="block text-sm text-slate-600 transition hover:text-[#1E3A8A]">Details</a>
                </div>
            </div>

            <div>
                <p class="mb-4 text-[11px] font-extrabold uppercase tracking-[0.22em] text-[#1E3A8A]">Account</p>
                <div class="space-y-3">
                    @if (Route::has('login'))
                        <a href="{{ route('login') }}" class="block text-sm text-slate-600 transition hover:text-[#1E3A8A]">Log in</a>
                    @endif

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="block text-sm text-slate-600 transition hover:text-[#1E3A8A]">Register</a>
                    @endif

                    <a href="{{ url('/dashboard') }}" class="block text-sm text-slate-600 transition hover:text-[#1E3A8A]">Dashboard</a>
                </div>
            </div>
        </div>

        <div class="mx-auto flex max-w-[1380px] flex-col gap-2 border-t border-slate-200 px-4 py-5 text-sm text-slate-500 sm:px-6 md:flex-row md:items-center md:justify-between lg:px-8">
            <p>© 2026 Holy Spirit School of Tagbilaran. All rights reserved.</p>
            <p>Truth in Love · Faith · Learning · Community</p>
        </div>
    </footer>
</div>
</body>
</html>