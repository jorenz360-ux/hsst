<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ $event->title }} | Holy Spirit School of Tagbilaran</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700;800&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        [x-cloak] { display: none !important; }

        body {
            font-family: 'Inter', sans-serif;
            background: #ffffff;
            color: #111827;
        }

        .font-display {
            font-family: 'Playfair Display', Georgia, serif;
        }

        .brand-blue {
            background-color: #173f9e;
        }

        .brand-blue-text {
            color: #173f9e;
        }

        .brand-blue-border {
            border-color: #173f9e;
        }

        .gold-text {
            color: #b68b2c;
        }

        .section-line::after {
            content: '';
            display: block;
            width: 90px;
            height: 2px;
            margin-top: 14px;
            background: #173f9e;
        }

        .schedule-line {
            position: relative;
        }

        .schedule-line::before {
            content: '';
            position: absolute;
            left: 13px;
            top: 24px;
            bottom: -24px;
            width: 2px;
            background: #dbe4f5;
        }

        .schedule-line:last-child::before {
            display: none;
        }

        .hamburger-line {
            transition: all .22s ease;
        }

        .hamburger-open .line-1 {
            transform: translateY(6px) rotate(45deg);
        }

        .hamburger-open .line-2 {
            opacity: 0;
        }

        .hamburger-open .line-3 {
            transform: translateY(-6px) rotate(-45deg);
        }
    </style>
</head>
<body class="antialiased">
@php
    $bannerUrl = $event->banner_image
        ? \Illuminate\Support\Facades\Storage::disk('s3')->url($event->banner_image)
        : asset('images/100yearsevent.jpg');

    $eventDate = $event->event_date ? \Carbon\Carbon::parse($event->event_date) : null;
    $firstSchedule = $event->schedules->sortBy('schedule_time')->first();
@endphp

<div x-data="{ mobileOpen: false }" class="min-h-screen">

    {{-- HEADER ONLY BLUE --}}
    <header class="sticky top-0 z-50 brand-blue border-b border-white/10">
        <div class="mx-auto flex h-20 max-w-[1360px] items-center justify-between px-4 sm:px-6 lg:px-8">
            <a href="{{ route('home') }}" class="flex items-center gap-3">
                <div class="flex h-12 w-12 items-center justify-center overflow-hidden bg-white">
                    <img src="{{ asset('images/hsstlogo.jpg') }}" alt="HSST Logo" class="h-full w-full object-contain">
                </div>

                <div class="leading-tight">
                    <p class="text-[10px] font-semibold uppercase tracking-[0.28em] text-white/70">Official Alumni Portal</p>
                    <p class="text-lg font-semibold text-white">Holy Spirit School of Tagbilaran</p>
                </div>
            </a>

            <nav class="hidden items-center gap-8 lg:flex">
                <a href="{{ route('home') }}" class="text-sm font-medium text-white/85 hover:text-white">Home</a>
                <a href="{{ route('about-us') }}" class="text-sm font-medium text-white/85 hover:text-white">About</a>
                <a href="{{ route('events.index') }}" class="bg-white px-5 py-3 text-sm font-semibold text-[#173f9e]">Events</a>
                <a href="#event-details" class="text-sm font-medium text-white/85 hover:text-white">Details</a>
            </nav>

            <div class="hidden items-center gap-3 lg:flex">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}"
                           class="bg-white px-5 py-3 text-sm font-semibold text-[#173f9e] transition hover:bg-slate-100">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}"
                           class="border border-white/25 px-5 py-3 text-sm font-medium text-white transition hover:bg-white/10">
                            Log in
                        </a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}"
                               class="bg-white px-5 py-3 text-sm font-semibold text-[#173f9e] transition hover:bg-slate-100">
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
                aria-label="Toggle menu"
            >
                <span class="hamburger-line line-1 block h-[1.5px] w-5 bg-white"></span>
                <span class="hamburger-line line-2 block h-[1.5px] w-5 bg-white"></span>
                <span class="hamburger-line line-3 block h-[1.5px] w-5 bg-white"></span>
            </button>
        </div>

        <div
            x-cloak
            x-show="mobileOpen"
            x-transition.opacity.duration.200ms
            class="border-t border-white/10 brand-blue lg:hidden"
        >
            <div class="space-y-1 px-4 py-4">
                <a href="{{ route('home') }}" class="block px-3 py-3 text-white/85">Home</a>
                <a href="{{ route('about-us') }}" class="block px-3 py-3 text-white/85">About</a>
                <a href="{{ route('events.index') }}" class="block px-3 py-3 text-white">Events</a>
                <a href="#event-details" class="block px-3 py-3 text-white/85">Details</a>

                @guest
                    <div class="grid grid-cols-2 gap-3 pt-3">
                        <a href="{{ route('login') }}" class="border border-white/20 px-4 py-3 text-center text-sm font-medium text-white">
                            Log in
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="bg-white px-4 py-3 text-center text-sm font-semibold text-[#173f9e]">
                                Register
                            </a>
                        @endif
                    </div>
                @endguest
            </div>
        </div>
    </header>

    {{-- HERO WHITE --}}
    <section class="bg-white">
        <div class="mx-auto max-w-[1360px] px-4 py-10 sm:px-6 lg:px-8 lg:py-14">
            <div class="mb-6 flex flex-wrap items-center gap-3">
                <a href="{{ route('events.index') }}"
                   class="inline-flex items-center gap-2 border border-slate-300 px-4 py-2 text-sm font-medium text-slate-700 transition hover:bg-slate-50">
                    <span>←</span>
                    <span>Back to Events</span>
                </a>

                <span class="inline-flex items-center border border-slate-300 px-4 py-2 text-xs font-semibold uppercase tracking-[0.2em] text-slate-700">
                    Official Event Details
                </span>
            </div>

            <div class="grid gap-8 lg:grid-cols-[1.02fr_0.98fr] lg:items-center lg:gap-10">
                <div class="border border-slate-200 bg-white px-6 py-7 sm:px-8 sm:py-9 lg:px-10">
                    <div class="mb-5 flex flex-wrap items-center gap-3">
                        <span class="inline-flex items-center border border-blue-100 bg-blue-50 px-3 py-1.5 text-[11px] font-semibold uppercase tracking-[0.18em] text-[#173f9e]">
                            {{ $event->is_active ? 'Active Event' : 'Event Details' }}
                        </span>

                        @if($event->dress_code)
                            <span class="inline-flex items-center border border-amber-200 bg-amber-50 px-3 py-1.5 text-[11px] font-semibold uppercase tracking-[0.18em] text-amber-800">
                                Dress Code: {{ $event->dress_code }}
                            </span>
                        @endif
                    </div>

                    <h1 class="font-display text-[clamp(2.4rem,5vw,4.9rem)] leading-[0.95] text-black">
                        {{ $event->title }}
                    </h1>

                    <p class="mt-5 max-w-2xl text-[15px] leading-8 text-slate-600 sm:text-[16px]">
                        {{ \Illuminate\Support\Str::limit(strip_tags($event->description ?? 'Stay connected with the HSST Alumni community through this official event page.'), 220) }}
                    </p>

                    <div class="mt-8 grid gap-4 sm:grid-cols-2 xl:grid-cols-3">
                        <div class="border border-slate-200 bg-white px-4 py-4">
                            <p class="text-[11px] font-semibold uppercase tracking-[0.18em] text-slate-400">Date</p>
                            <p class="mt-2 text-[15px] font-semibold text-black">
                                {{ $eventDate ? $eventDate->format('F d, Y') : 'To be announced' }}
                            </p>
                        </div>

                        <div class="border border-slate-200 bg-white px-4 py-4">
                            <p class="text-[11px] font-semibold uppercase tracking-[0.18em] text-slate-400">Venue</p>
                            <p class="mt-2 text-[15px] font-semibold text-black">
                                {{ $event->venue ?: 'Venue to be announced' }}
                            </p>
                        </div>

                        <div class="border border-slate-200 bg-white px-4 py-4 sm:col-span-2 xl:col-span-1">
                            <p class="text-[11px] font-semibold uppercase tracking-[0.18em] text-slate-400">Time</p>
                            <p class="mt-2 text-[15px] font-semibold text-black">
                                @if($firstSchedule?->schedule_time)
                                    {{ \Carbon\Carbon::parse($firstSchedule->schedule_time)->format('g:i A') }}
                                @else
                                    Time to be announced
                                @endif
                            </p>
                        </div>
                    </div>

                    <div class="mt-8 flex flex-col gap-3 sm:flex-row">
                        <a href="#event-details"
                           class="inline-flex items-center justify-center bg-[#173f9e] px-6 py-3.5 text-sm font-semibold text-white transition hover:bg-[#12327f]">
                            View Full Details
                        </a>

                        @if(Route::has('register'))
                            <a href="{{ route('register') }}"
                               class="inline-flex items-center justify-center border border-[#173f9e] bg-white px-6 py-3.5 text-sm font-semibold text-[#173f9e] transition hover:bg-blue-50">
                                Join the Alumni Portal
                            </a>
                        @endif
                    </div>
                </div>

                <div class="overflow-hidden border border-slate-200 bg-white">
                    <img
                        src="{{ $bannerUrl }}"
                        alt="{{ $event->title }}"
                        class="h-full min-h-[320px] w-full object-cover object-center"
                    >
                </div>
            </div>
        </div>
    </section>

    {{-- MAIN WHITE --}}
    <section id="event-details" class="bg-white py-14 sm:py-16 lg:py-20">
        <div class="mx-auto max-w-[1360px] px-4 sm:px-6 lg:px-8">
            <div class="grid gap-10 lg:grid-cols-[minmax(0,1fr)_360px] xl:gap-16">
                <div class="space-y-12">
                    <section class="border border-slate-200 bg-white px-6 py-8 sm:px-8 sm:py-10">
                        <div class="section-line">
                            <p class="text-[11px] font-semibold uppercase tracking-[0.24em] brand-blue-text">About the Event</p>
                            <h2 class="mt-3 font-display text-[clamp(2rem,3vw,3.2rem)] leading-none text-black">
                                Event Overview
                            </h2>
                        </div>

                        <div class="mt-8 max-w-4xl text-[15px] leading-8 text-slate-700 sm:text-[16px]">
                            @if ($event->description)
                                {!! nl2br(e($event->description)) !!}
                            @else
                                <p>No event description available yet. Please check back soon for updates.</p>
                            @endif
                        </div>
                    </section>

                    @if ($event->schedules->isNotEmpty())
                        <section class="border border-slate-200 bg-white px-6 py-8 sm:px-8 sm:py-10">
                            <div class="section-line">
                                <p class="text-[11px] font-semibold uppercase tracking-[0.24em] brand-blue-text">Program Flow</p>
                                <h2 class="mt-3 font-display text-[clamp(2rem,3vw,3rem)] leading-none text-black">
                                    Event Schedule
                                </h2>
                            </div>

                            <div class="mt-8 space-y-8">
                                @foreach ($event->schedules->sortBy('schedule_time') as $index => $schedule)
                                    <div class="schedule-line grid grid-cols-[28px_1fr] gap-5">
                                        <div class="relative z-10 mt-1 flex h-7 w-7 items-center justify-center rounded-full bg-[#173f9e] text-[11px] font-bold text-white">
                                            {{ $index + 1 }}
                                        </div>

                                        <div class="pb-2">
                                            <p class="text-[12px] font-semibold uppercase tracking-[0.18em] text-[#173f9e]">
                                                @if ($schedule->schedule_time)
                                                    {{ \Carbon\Carbon::parse($schedule->schedule_time)->format('g:i A') }}
                                                @else
                                                    TBA
                                                @endif
                                            </p>

                                            @if ($schedule->title)
                                                <h3 class="mt-2 text-xl font-semibold text-black">
                                                    {{ $schedule->title }}
                                                </h3>
                                            @endif

                                            @if ($schedule->description)
                                                <p class="mt-3 text-[15px] leading-8 text-slate-600">
                                                    {{ $schedule->description }}
                                                </p>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </section>
                    @endif
                </div>

                <aside class="space-y-6 lg:sticky lg:top-28 lg:self-start">
                    <div class="border border-slate-200 bg-white p-6 sm:p-7">
                        <h3 class="text-sm font-bold uppercase tracking-[0.22em] text-[#173f9e]">
                            Event Information
                        </h3>

                        <div class="mt-6 space-y-5">
                            <div class="border-b border-slate-100 pb-4">
                                <p class="text-[11px] font-semibold uppercase tracking-[0.16em] text-slate-400">Date</p>
                                <p class="mt-2 text-[15px] font-semibold text-black">
                                    {{ $eventDate ? $eventDate->format('l, F d, Y') : 'To be announced' }}
                                </p>
                            </div>

                            <div class="border-b border-slate-100 pb-4">
                                <p class="text-[11px] font-semibold uppercase tracking-[0.16em] text-slate-400">Venue</p>
                                <p class="mt-2 text-[15px] font-semibold text-black">
                                    {{ $event->venue ?: 'Venue to be announced' }}
                                </p>
                            </div>

                            <div class="border-b border-slate-100 pb-4">
                                <p class="text-[11px] font-semibold uppercase tracking-[0.16em] text-slate-400">Start Time</p>
                                <p class="mt-2 text-[15px] font-semibold text-black">
                                    @if($firstSchedule?->schedule_time)
                                        {{ \Carbon\Carbon::parse($firstSchedule->schedule_time)->format('g:i A') }}
                                    @else
                                        To be announced
                                    @endif
                                </p>
                            </div>

                            @if($event->dress_code)
                                <div class="border-b border-slate-100 pb-4">
                                    <p class="text-[11px] font-semibold uppercase tracking-[0.16em] text-slate-400">Dress Code</p>
                                    <p class="mt-2 text-[15px] font-semibold text-black">
                                        {{ $event->dress_code }}
                                    </p>
                                </div>
                            @endif

                            <div>
                                <p class="text-[11px] font-semibold uppercase tracking-[0.16em] text-slate-400">Participation</p>
                                <p class="mt-2 text-[15px] font-semibold text-black">
                                    Open to HSST alumni, faculty, and invited guests
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="border border-slate-200 bg-white p-6 sm:p-7">
                        <p class="text-[11px] font-semibold uppercase tracking-[0.24em] text-[#173f9e]">
                            Stay Connected
                        </p>

                        <h3 class="mt-3 font-display text-3xl leading-tight text-black">
                            Join the official alumni portal
                        </h3>

                        <p class="mt-4 text-sm leading-7 text-slate-600">
                            Create your account to receive updates, reconnect with fellow alumni, and stay informed about upcoming school events.
                        </p>

                        <div class="mt-6 space-y-3">
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}"
                                   class="block w-full bg-[#173f9e] px-5 py-3.5 text-center text-sm font-semibold text-white transition hover:bg-[#12327f]">
                                    Create Account
                                </a>
                            @endif

                            @if (Route::has('login'))
                                <a href="{{ route('login') }}"
                                   class="block w-full border border-[#173f9e] bg-white px-5 py-3.5 text-center text-sm font-medium text-[#173f9e] transition hover:bg-blue-50">
                                    Log in
                                </a>
                            @endif
                        </div>
                    </div>

                    <div class="border border-slate-200 bg-slate-50 px-5 py-5">
                        <p class="text-sm leading-7 text-slate-700">
                            Please revisit this page before the event date for any changes in venue, schedule, or additional instructions.
                        </p>
                    </div>
                </aside>
            </div>
        </div>
    </section>

    {{-- FOOTER WHITE --}}
    <footer class="border-t border-slate-200 bg-white">
        <div class="mx-auto max-w-[1360px] px-4 py-12 sm:px-6 lg:px-8">
            <div class="grid gap-10 lg:grid-cols-[1.4fr_1fr_1fr]">
                <div>
                    <div class="flex items-center gap-3">
                        <div class="flex h-11 w-11 items-center justify-center overflow-hidden border border-slate-200 bg-white">
                            <img src="{{ asset('images/hsstlogo.jpg') }}" alt="HSST Logo" class="h-full w-full object-contain">
                        </div>
                        <div>
                            <p class="text-[10px] font-semibold uppercase tracking-[0.22em] text-[#173f9e]">Official Alumni Portal</p>
                            <p class="text-base font-semibold text-black">Holy Spirit School of Tagbilaran</p>
                        </div>
                    </div>

                    <p class="mt-5 max-w-md text-sm leading-7 text-slate-600">
                        A digital home for official alumni announcements, school celebrations, milestone events, and meaningful reconnection with the HSST community.
                    </p>
                </div>

                <div>
                    <p class="text-[11px] font-bold uppercase tracking-[0.22em] text-[#173f9e]">Quick Links</p>
                    <div class="mt-5 space-y-3">
                        <a href="{{ route('home') }}" class="block text-sm text-slate-600 hover:text-[#173f9e]">Home</a>
                        <a href="{{ route('events.index') }}" class="block text-sm text-slate-600 hover:text-[#173f9e]">Events</a>
                        <a href="{{ route('about-us') }}" class="block text-sm text-slate-600 hover:text-[#173f9e]">About</a>
                        <a href="#event-details" class="block text-sm text-slate-600 hover:text-[#173f9e]">Details</a>
                    </div>
                </div>

                <div>
                    <p class="text-[11px] font-bold uppercase tracking-[0.22em] text-[#173f9e]">Account</p>
                    <div class="mt-5 space-y-3">
                        @if(Route::has('login'))
                            <a href="{{ route('login') }}" class="block text-sm text-slate-600 hover:text-[#173f9e]">Log in</a>
                        @endif
                        @if(Route::has('register'))
                            <a href="{{ route('register') }}" class="block text-sm text-slate-600 hover:text-[#173f9e]">Register</a>
                        @endif
                        <a href="{{ url('/dashboard') }}" class="block text-sm text-slate-600 hover:text-[#173f9e]">Dashboard</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="border-t border-slate-200">
            <div class="mx-auto flex max-w-[1360px] flex-col gap-2 px-4 py-5 text-sm text-slate-500 sm:px-6 md:flex-row md:items-center md:justify-between lg:px-8">
                <p>© {{ now()->year }} Holy Spirit School of Tagbilaran. All rights reserved.</p>
                <p class="font-medium text-[#173f9e]">Truth · Faith · Excellence</p>
            </div>
        </div>
    </footer>
</div>
</body>
</html>