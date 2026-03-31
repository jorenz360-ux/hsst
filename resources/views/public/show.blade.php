<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ $event->title }} | Holy Spirit School of Tagbilaran</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Cormorant Garamond: refined serif with old-school gravitas, pairs well with Outfit body --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,600;1,400&family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        :root {
            --navy:      #0b1f5c;
            --navy-deep: #071440;
            --navy-mid:  #153e8a;
            --blue-soft: #e8f0fe;
            --gold:      #c4960a;
            --gold-lt:   #e8b80f;
            --border:    rgba(15, 42, 107, 0.12);
            --border-lt: rgba(15, 42, 107, 0.07);
        }

        [x-cloak] { display: none !important; }

        body {
            font-family: 'Outfit', system-ui, sans-serif;
            background: #fafbff;
            color: #1a1f36;
        }

        .font-display {
            font-family: 'Cormorant Garamond', Georgia, serif;
            font-weight: 600;
        }

        /* ── Eyebrow ── */
        .eyebrow {
            font-family: 'Outfit', sans-serif;
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 0.22em;
            text-transform: uppercase;
            color: var(--navy-mid);
        }

        /* ── Gold accent line ── */
        .gold-rule {
            width: 44px;
            height: 2px;
            background: linear-gradient(90deg, var(--gold), var(--gold-lt));
            border-radius: 1px;
            margin: 14px 0;
        }

        /* ── Thin borders ── */
        .card {
            background: #fff;
            border: 0.5px solid var(--border);
            border-radius: 10px;
        }

        .card-flat {
            background: #fff;
            border: 0.5px solid var(--border);
        }

        .soft-card {
            background: var(--blue-soft);
            border: 0.5px solid rgba(15, 42, 107, 0.14);
            border-radius: 8px;
        }

        /* ── Nav links ── */
        .nav-link {
            color: rgba(255,255,255,0.72);
            font-size: 13.5px;
            font-weight: 500;
            padding: 7px 14px;
            border-radius: 6px;
            transition: color .18s, background .18s;
        }
        .nav-link:hover { color: #fff; background: rgba(255,255,255,.1); }
        .nav-link-active { color: var(--navy); background: #fff; font-weight: 600; }

        /* ── Hamburger ── */
        .hamburger-line { transition: all .22s ease; }
        .hamburger-open .line-1 { transform: translateY(6px) rotate(45deg); }
        .hamburger-open .line-2 { opacity: 0; }
        .hamburger-open .line-3 { transform: translateY(-6px) rotate(-45deg); }

        /* ── Schedule timeline ── */
        .schedule-item { position: relative; }
        .schedule-item + .schedule-item::before {
            content: '';
            position: absolute;
            left: 13px;
            top: -20px;
            height: 20px;
            width: 1px;
            background: var(--border);
        }

        /* ── Page load fade-in ── */
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(14px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .fade-up { animation: fadeUp .55s ease both; }
        .fade-up-2 { animation: fadeUp .55s ease .1s both; }
        .fade-up-3 { animation: fadeUp .55s ease .2s both; }

        /* ── Button ── */
        .btn-primary {
            display: inline-flex; align-items: center; justify-content: center; gap: 7px;
            background: var(--navy-mid); color: #fff;
            font-size: 13px; font-weight: 600; letter-spacing: 0.04em;
            padding: 11px 22px; border-radius: 7px;
            transition: background .18s, transform .12s;
        }
        .btn-primary:hover { background: var(--navy); }
        .btn-primary:active { transform: scale(0.98); }

        .btn-ghost {
            display: inline-flex; align-items: center; justify-content: center; gap: 7px;
            background: #fff; color: var(--navy-mid);
            font-size: 13px; font-weight: 500;
            padding: 11px 22px; border-radius: 7px;
            border: 0.5px solid var(--border);
            transition: background .18s, transform .12s;
        }
        .btn-ghost:hover { background: var(--blue-soft); }
        .btn-ghost:active { transform: scale(0.98); }

        /* ── Meta pill badge ── */
        .badge-amber {
            display: inline-flex; align-items: center;
            background: #fef9ec; border: 0.5px solid #e9c84a;
            color: #7a5b06; border-radius: 5px;
            font-size: 10.5px; font-weight: 600; letter-spacing: 0.12em; text-transform: uppercase;
            padding: 4px 10px;
        }
        .badge-blue {
            display: inline-flex; align-items: center;
            background: var(--blue-soft); border: 0.5px solid rgba(15,42,107,.2);
            color: var(--navy-mid); border-radius: 5px;
            font-size: 10.5px; font-weight: 600; letter-spacing: 0.12em; text-transform: uppercase;
            padding: 4px 10px;
        }
        .badge-green {
            display: inline-flex; align-items: center;
            background: #f0fdf4; border: 0.5px solid #86efac;
            color: #166534; border-radius: 5px;
            font-size: 10.5px; font-weight: 600; letter-spacing: 0.12em; text-transform: uppercase;
            padding: 4px 10px;
        }
    </style>
</head>
<body class="antialiased">

@php
    $bannerUrl = $event->banner_image
        ? \Illuminate\Support\Facades\Storage::disk('s3')->url($event->banner_image)
        : asset('images/100yearsevent.jpg');

    $eventDate = $event->event_date ? \Carbon\Carbon::parse($event->event_date) : null;
@endphp

<div x-data="{ mobileOpen: false }" class="min-h-screen">

    {{-- ══════════════════════════════════════════════
         HEADER
    ══════════════════════════════════════════════ --}}
    <header class="sticky inset-x-0 top-0 z-50 bg-[#0b1f5c]" style="border-bottom:0.5px solid rgba(255,255,255,.1)">
        <div class="mx-auto flex h-[72px] max-w-[1380px] items-center justify-between px-4 sm:px-6 lg:px-8">

            {{-- Logo --}}
            <a href="{{ route('home') }}" class="flex min-w-0 items-center gap-3 transition-opacity hover:opacity-90">
                <div class="flex h-10 w-10 shrink-0 items-center justify-center overflow-hidden rounded-md bg-white p-1">
                    <img src="{{ asset('images/hsstlogo.jpg') }}" alt="HSST Logo" class="h-full w-full object-contain">
                </div>
                <div class="leading-tight">
                    <p class="text-[8.5px] font-bold uppercase tracking-[0.28em] text-white/60">Official Alumni Portal</p>
                    <p class="truncate text-[13px] font-semibold text-white">Holy Spirit School of Tagbilaran</p>
                </div>
            </a>

            {{-- Desktop nav --}}
            <nav class="hidden items-center gap-1 lg:flex">
                <a href="{{ route('home') }}" class="nav-link">Home</a>
                {{-- <a href="{{ route('about-us') }}" class="nav-link">About</a> --}}
                <a href="{{ route('events.index') }}" class="nav-link nav-link-active">Events</a>
                <a href="#event-details" class="nav-link">Details</a>
            </nav>

            {{-- Desktop auth --}}
            <div class="hidden items-center gap-2.5 lg:flex">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="btn-primary py-2 px-5">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="btn-ghost py-2 px-5" style="background:rgba(255,255,255,.08);color:#fff;border-color:rgba(255,255,255,.2)">Log in</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="btn-primary py-2 px-5" style="background:#fff;color:var(--navy)">Register</a>
                        @endif
                    @endauth
                @endif
            </div>

            {{-- Mobile hamburger --}}
            <button
                @click="mobileOpen = !mobileOpen"
                :class="mobileOpen ? 'hamburger-open' : ''"
                class="flex flex-col gap-[5px] rounded-md border border-white/20 bg-white/10 p-3 lg:hidden"
                aria-label="Toggle menu"
            >
                <span class="hamburger-line line-1 block h-[1.5px] w-5 bg-white"></span>
                <span class="hamburger-line line-2 block h-[1.5px] w-5 bg-white"></span>
                <span class="hamburger-line line-3 block h-[1.5px] w-5 bg-white"></span>
            </button>
        </div>
    </header>

    {{-- ══════════════════════════════════════════════
         MOBILE MENU
    ══════════════════════════════════════════════ --}}
    <div
        x-cloak
        x-show="mobileOpen"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 -translate-y-2"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 -translate-y-2"
        class="fixed inset-0 z-[60] bg-[#0b1f5c] lg:hidden"
    >
        <div class="flex h-full flex-col text-white">
            <div class="flex items-center justify-between px-6 py-5" style="border-bottom:0.5px solid rgba(255,255,255,.1)">
                <div>
                    <p class="text-[9px] font-bold uppercase tracking-[0.24em] text-white/60">Navigation</p>
                    <h2 class="mt-0.5 text-lg font-semibold">Event Details</h2>
                </div>
                <button @click="mobileOpen = false"
                    class="flex h-10 w-10 items-center justify-center rounded-lg border border-white/15 text-white/80 transition hover:bg-white/10">
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"><path d="M3 3l10 10M13 3L3 13"/></svg>
                </button>
            </div>

            <nav class="flex-1 overflow-y-auto px-6 py-4">
                <a @click="mobileOpen=false" href="{{ route('home') }}"
                   class="flex items-center py-4 text-[15px] font-medium text-white/80 transition hover:text-white"
                   style="border-bottom:0.5px solid rgba(255,255,255,.08)">Home</a>
                <a @click="mobileOpen=false" href="{{ route('about-us') }}"
                   class="flex items-center py-4 text-[15px] font-medium text-white/80 transition hover:text-white"
                   style="border-bottom:0.5px solid rgba(255,255,255,.08)">About</a>
                <a @click="mobileOpen=false" href="{{ route('events.index') }}"
                   class="flex items-center py-4 text-[15px] font-semibold text-white"
                   style="border-bottom:0.5px solid rgba(255,255,255,.08)">Events</a>
                <a @click="mobileOpen=false" href="#event-details"
                   class="flex items-center py-4 text-[15px] font-medium text-white/80 transition hover:text-white">Details</a>
            </nav>

            @guest
                <div class="px-6 py-6" style="border-top:0.5px solid rgba(255,255,255,.1)">
                    <div class="grid gap-3">
                        <a href="{{ route('login') }}" class="btn-ghost w-full py-3.5 text-[15px]"
                           style="background:rgba(255,255,255,.08);color:#fff;border-color:rgba(255,255,255,.2)">Log in</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="btn-primary w-full py-3.5 text-[15px]"
                               style="background:#fff;color:var(--navy)">Register</a>
                        @endif
                    </div>
                </div>
            @endguest
        </div>
    </div>

    {{-- ══════════════════════════════════════════════
     BREADCRUMB + HERO
══════════════════════════════════════════════ --}}
<section class="bg-white" style="border-bottom:0.5px solid var(--border)">
    <div class="mx-auto max-w-[1380px] px-4 sm:px-6 lg:px-8">

        {{-- Breadcrumb strip --}}
        <div class="flex flex-wrap items-center gap-2.5 py-4" style="border-bottom:0.5px solid var(--border-lt)">
            <a href="{{ route('events.index') }}"
               class="inline-flex items-center gap-1.5 rounded-md px-3 py-1.5 text-sm font-medium text-slate-600 transition hover:bg-slate-50 hover:text-slate-900"
               style="border:0.5px solid var(--border)">
                <svg width="14" height="14" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M10 12L6 8l4-4"/></svg>
                All Events
            </a>
            <span class="badge-blue">Official Event</span>
            @if($event->is_active)
                <span class="badge-green">
                    <span class="mr-1.5 inline-block h-1.5 w-1.5 rounded-full bg-green-500"></span>
                    Active
                </span>
            @endif
            @if($event->dress_code)
                <span class="badge-amber">Dress Code: {{ $event->dress_code }}</span>
            @endif
        </div>

        {{-- Hero: two columns --}}
        <div class="grid gap-8 py-10 lg:grid-cols-[1fr_480px] lg:gap-12 lg:py-14">

            {{-- Left: text --}}
            <div class="fade-up flex flex-col justify-center pr-0 lg:pr-4">
                <p class="eyebrow">HSST Alumni Event</p>
                <div class="gold-rule"></div>

                <h1 class="font-display text-[clamp(2.2rem,4.5vw,4rem)] leading-[1.05] text-[#091852]">
                    {{ $event->title }}
                </h1>

                <p class="mt-5 max-w-xl text-[15px] leading-[1.8] text-slate-600">
                    {{ \Illuminate\Support\Str::limit(strip_tags($event->description ?? 'Stay connected with the HSST Alumni community through this official event page.'), 220) }}
                </p>

                {{-- Quick meta chips --}}
                <div class="mt-7 grid gap-2.5 sm:grid-cols-3">
                    <div class="rounded-xl bg-[#f8fbff] px-4 py-3.5 sm:soft-card">
                        <p class="text-[9.5px] font-bold uppercase tracking-[0.18em] text-[#153e8a]/60">Date</p>
                        <p class="mt-1.5 text-sm font-semibold text-[#091852]">
                            {{ $eventDate ? $eventDate->format('F d, Y') : 'To be announced' }}
                        </p>
                    </div>
                    <div class="rounded-xl bg-[#f8fbff] px-4 py-3.5 sm:soft-card">
                        <p class="text-[9.5px] font-bold uppercase tracking-[0.18em] text-[#153e8a]/60">Time</p>
                        <p class="mt-1.5 text-sm font-semibold text-[#091852]">
                            {{ $eventDate ? $eventDate->format('g:i A') : 'TBA' }}
                        </p>
                    </div>
                    <div class="rounded-xl bg-[#f8fbff] px-4 py-3.5 sm:soft-card">
                        <p class="text-[9.5px] font-bold uppercase tracking-[0.18em] text-[#153e8a]/60">Venue</p>
                        <p class="mt-1.5 text-sm font-semibold text-[#091852]">
                            {{ $event->venue ?: 'To be announced' }}
                        </p>
                    </div>
                </div>

                <div class="mt-7 flex flex-wrap gap-3">
                    <a href="#event-details" class="btn-primary">
                        View Full Details
                        <svg width="14" height="14" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M8 3l5 5-5 5M3 8h10"/></svg>
                    </a>
                    @if(Route::has('register'))
                        <a href="{{ route('register') }}" class="btn-ghost">Join the Alumni Portal</a>
                    @endif
                </div>
            </div>

            {{-- Right: banner image --}}
            <div class="fade-up-2 overflow-hidden rounded-none border-0 shadow-none sm:rounded-xl"
                 style="border:0 solid transparent; sm:border:0.5px solid var(--border);">
                <img
                    src="{{ $bannerUrl }}"
                    alt="{{ $event->title }}"
                    class="h-full min-h-[260px] w-full object-cover object-center transition duration-500 hover:scale-[1.02] sm:min-h-[300px]"
                >
            </div>
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════════
     MAIN CONTENT
══════════════════════════════════════════════ --}}
<section id="event-details" class="py-14 sm:py-16 lg:py-20" style="background:#fafbff">
    <div class="mx-auto max-w-[1380px] px-4 sm:px-6 lg:px-8">
        <div class="grid gap-8 lg:grid-cols-[minmax(0,1fr)_340px] xl:gap-12">

            {{-- ── Main column ── --}}
            <div class="space-y-5">

                {{-- Event Overview --}}
                <div class="rounded-none border-0 bg-transparent px-0 py-0 shadow-none sm:card sm:px-7 sm:py-8 md:sm:px-9 sm:py-10">
                    <p class="eyebrow">About the Event</p>
                    <div class="gold-rule"></div>
                    <h2 class="font-display text-[clamp(1.8rem,3vw,2.8rem)] leading-[1.08] text-[#091852]">
                        Event Overview
                    </h2>
                    <div class="mt-7 max-w-3xl space-y-5 text-[15px] leading-[1.9] text-slate-600">
                        @if ($event->description)
                            {!! nl2br(e($event->description)) !!}
                        @else
                            <p>No event description available yet. Please check back soon for updates.</p>
                        @endif
                    </div>
                </div>

                {{-- Schedule --}}
                @if ($event->schedules->isNotEmpty())
                    <div class="rounded-none border-0 bg-transparent px-0 py-0 shadow-none sm:card sm:px-7 sm:py-8 md:sm:px-9 sm:py-10">
                        <p class="eyebrow">Program Flow</p>
                        <div class="gold-rule"></div>
                        <h2 class="font-display text-[clamp(1.8rem,3vw,2.8rem)] leading-[1.08] text-[#091852]">
                            Event Schedule
                        </h2>

                        <div class="mt-8 space-y-5">
                            @foreach ($event->schedules->sortBy('schedule_time') as $index => $schedule)
                                <div class="schedule-item grid grid-cols-[28px_1fr] gap-5">
                                    <div class="relative z-10 flex h-7 w-7 shrink-0 items-center justify-center rounded-full bg-[#153e8a] text-[10px] font-bold text-white">
                                        {{ $index + 1 }}
                                    </div>

                                    <div class="pb-1">
                                        <p class="text-[10.5px] font-bold uppercase tracking-[0.18em] text-[#153e8a]">
                                            {{ $schedule->schedule_time
                                                ? \Carbon\Carbon::parse($schedule->schedule_time)->format('g:i A')
                                                : 'TBA' }}
                                        </p>

                                        @if ($schedule->title)
                                            <h3 class="mt-1.5 text-[17px] font-semibold text-[#091852]">
                                                {{ $schedule->title }}
                                            </h3>
                                        @endif

                                        @if ($schedule->description)
                                            <p class="mt-2 text-[14.5px] leading-[1.8] text-slate-500">
                                                {{ $schedule->description }}
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            {{-- ── Sidebar ── --}}
            <aside class="space-y-3 lg:sticky lg:top-24 lg:self-start">

                {{-- Event info card --}}
                <div class="overflow-hidden rounded-none border-0 bg-transparent shadow-none sm:rounded-2xl sm:border sm:border-slate-200 sm:bg-white sm:shadow-sm">
                    <div class="border-b border-slate-200 px-0 py-3 sm:px-4">
                        <p class="text-[10px] font-extrabold uppercase tracking-[0.2em] text-[#153e8a]">
                            Event Information
                        </p>
                    </div>

                    <div class="grid grid-cols-1 gap-x-4 gap-y-3 px-0 py-4 sm:grid-cols-2 sm:px-4">
                        <div>
                            <p class="text-[10px] font-bold uppercase tracking-[0.14em] text-slate-400">Date</p>
                            <p class="mt-1 text-[13.5px] font-semibold leading-5 text-[#091852]">
                                {{ $eventDate ? $eventDate->format('M d, Y') : 'To be announced' }}
                            </p>
                        </div>

                        <div>
                            <p class="text-[10px] font-bold uppercase tracking-[0.14em] text-slate-400">Time</p>
                            <p class="mt-1 text-[13.5px] font-semibold leading-5 text-[#091852]">
                                {{ $eventDate ? $eventDate->format('g:i A') : 'To be announced' }}
                            </p>
                        </div>

                        <div class="sm:col-span-2">
                            <p class="text-[10px] font-bold uppercase tracking-[0.14em] text-slate-400">Venue</p>
                            <p class="mt-1 text-[13.5px] font-semibold leading-5 text-[#091852]">
                                {{ $event->venue ?: 'Venue to be announced' }}
                            </p>
                        </div>

                        @if($event->dress_code)
                            <div>
                                <p class="text-[10px] font-bold uppercase tracking-[0.14em] text-slate-400">Dress Code</p>
                                <p class="mt-1 text-[13.5px] font-semibold leading-5 text-[#091852]">
                                    {{ $event->dress_code }}
                                </p>
                            </div>
                        @endif

                        <div class="{{ $event->dress_code ? '' : 'sm:col-span-2' }}">
                            <p class="text-[10px] font-bold uppercase tracking-[0.14em] text-slate-400">Participation</p>
                            <p class="mt-1 text-[13.5px] font-semibold leading-5 text-[#091852]">
                                Open to HSST alumni, faculty, and invited guests
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Stay Connected card --}}
                <div class="overflow-hidden rounded-none border-0 bg-transparent shadow-none sm:rounded-2xl sm:border sm:border-slate-200 sm:bg-[#f8fbff] sm:shadow-sm">
                    <div class="px-0 py-4 sm:px-4">
                        <p class="text-[10px] font-extrabold uppercase tracking-[0.2em] text-[#153e8a]">
                            Stay Connected
                        </p>

                        <h3 class="mt-2 text-[1.05rem] font-bold leading-[1.25] text-[#091852]">
                            Join the alumni portal
                        </h3>

                        <p class="mt-2 text-[13px] leading-6 text-slate-600">
                            Receive updates, reconnect with fellow alumni, and stay informed about upcoming events.
                        </p>

                        <div class="mt-4 grid gap-2">
                            @if (Route::has('register'))
                                <a
                                    href="{{ route('register') }}"
                                    class="inline-flex w-full items-center justify-center rounded bg-[#153e75] px-4 py-2.5 text-sm font-bold uppercase tracking-[0.12em] text-white transition hover:bg-[#0f2f5c]"
                                >
                                    Create Account
                                </a>
                            @endif

                            @if (Route::has('login'))
                                <a
                                    href="{{ route('login') }}"
                                    class="inline-flex w-full items-center justify-center rounded border border-[#153e75]/15 bg-white px-4 py-2.5 text-sm font-semibold text-[#153e75] transition hover:bg-[#eef4ff]"
                                >
                                    Log in
                                </a>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Notice --}}
                <div class="rounded-xl bg-amber-50 px-4 py-3 sm:rounded-2xl sm:border sm:border-amber-200">
                    <div class="flex items-start gap-2.5">
                        <svg class="mt-0.5 h-4 w-4 shrink-0 text-amber-600" viewBox="0 0 16 16" fill="currentColor">
                            <path d="M8 1a7 7 0 1 0 0 14A7 7 0 0 0 8 1Zm0 4a.75.75 0 0 1 .75.75v3.5a.75.75 0 0 1-1.5 0v-3.5A.75.75 0 0 1 8 5Zm0 7.25a1 1 0 1 1 0-2 1 1 0 0 1 0 2Z"/>
                        </svg>

                        <p class="text-[12.5px] leading-6 text-amber-900">
                            Please revisit this page before the event for any changes in venue, schedule, or additional instructions.
                        </p>
                    </div>
                </div>

            </aside>

        </div>
    </div>
</section>

    <footer class="bg-[#071440] pt-14 pb-0">
        <div class="mx-auto grid max-w-[1380px] gap-10 px-4 sm:px-6 lg:grid-cols-[1.4fr_1fr_1fr] lg:gap-14 lg:px-8 pb-12">

            {{-- Brand --}}
            <div>
                <div class="flex items-center gap-3">
                    <div class="flex h-10 w-10 items-center justify-center overflow-hidden rounded-md bg-white p-1">
                        <img src="{{ asset('images/hsstlogo.jpg') }}" alt="HSST Logo" class="h-full w-full object-contain">
                    </div>
                    <div>
                        <p class="text-[8.5px] font-bold uppercase tracking-[0.26em] text-white/55">Official Alumni Portal</p>
                        <p class="text-[13.5px] font-semibold text-white">Holy Spirit School of Tagbilaran</p>
                    </div>
                </div>
                <p class="mt-5 max-w-sm text-[13.5px] leading-[1.8] text-white/45">
                    A digital home for official alumni announcements, school celebrations, milestone events, and meaningful reconnection with the HSST community.
                </p>
            </div>

            {{-- Quick Links --}}
            <div>
                <p class="text-[9.5px] font-bold uppercase tracking-[0.24em] text-white/55">Quick Links</p>
                <div class="mt-5 space-y-3">
                    <a href="{{ route('home') }}" class="block text-[13.5px] text-white/45 transition hover:text-white">Home</a>
                    <a href="{{ route('events.index') }}" class="block text-[13.5px] text-white/45 transition hover:text-white">Events</a>
                    <a href="{{ route('about-us') }}" class="block text-[13.5px] text-white/45 transition hover:text-white">About</a>
                    <a href="#event-details" class="block text-[13.5px] text-white/45 transition hover:text-white">Event Details</a>
                </div>
            </div>

            {{-- Account --}}
            <div>
                <p class="text-[9.5px] font-bold uppercase tracking-[0.24em] text-white/55">Account</p>
                <div class="mt-5 space-y-3">
                    @if(Route::has('login'))
                        <a href="{{ route('login') }}" class="block text-[13.5px] text-white/45 transition hover:text-white">Log in</a>
                    @endif
                    @if(Route::has('register'))
                        <a href="{{ route('register') }}" class="block text-[13.5px] text-white/45 transition hover:text-white">Register</a>
                    @endif
                    <a href="{{ url('/dashboard') }}" class="block text-[13.5px] text-white/45 transition hover:text-white">Dashboard</a>
                </div>
            </div>
        </div>

        {{-- Footer bottom bar --}}
        <div style="border-top:0.5px solid rgba(255,255,255,.08)">
            <div class="mx-auto flex max-w-[1380px] flex-col gap-2 px-4 py-5 sm:px-6 md:flex-row md:items-center md:justify-between lg:px-8">
                <p class="text-[12.5px] text-white/35">
                    © {{ now('Asia/Manila')->format('Y') }} Holy Spirit School of Tagbilaran. All rights reserved.
                </p>
                <p class="text-[12.5px] font-semibold text-[#c4960a]">Truth · Faith · Excellence</p>
            </div>
        </div>
    </footer>

</div>
</body>
</html>