<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ $event->title }} | Holy Spirit School of Tagbilaran</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;0,800;1,400;1,700&family=EB+Garamond:ital,wght@0,400;0,500;0,600;1,400;1,500&family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        :root {
            --ink:        #12100e;
            --paper:      #faf8f4;
            --paper-dark: #f0ece3;
            --rule:       #d4c9b8;
            --royal:      #1a3fc4;
            --spirit:     #c4960a;
        }

        [x-cloak] { display: none !important; }

        body {
            font-family: 'Inter', system-ui, sans-serif;
            background: var(--paper);
            color: var(--ink);
            overflow-x: hidden;
        }

        /* ── Editorial type ── */
        .kicker {
            font-family: 'Inter', sans-serif;
            font-size: .67rem;
            font-weight: 700;
            letter-spacing: .22em;
            text-transform: uppercase;
        }

        .display {
            font-family: 'Playfair Display', Georgia, serif;
            letter-spacing: -.015em;
            line-height: 1.05;
        }

        .garamond {
            font-family: 'EB Garamond', Georgia, serif;
            font-size: 1.08rem;
            line-height: 1.9;
        }

        .caption-text {
            font-family: 'Inter', sans-serif;
            font-size: .68rem;
            letter-spacing: .1em;
            text-transform: uppercase;
            color: #6b6860;
        }

        .col-rule       { border-top: 1px solid var(--rule); }
        .col-rule-thick { border-top: 2px solid var(--ink); }

        /* ── Nav scroll behavior (desktop) ── */
        #nav { transition: background .35s ease, border-color .35s ease, backdrop-filter .35s ease; }
        #nav.scrolled {
            background: rgba(250,248,244,.97);
            border-bottom: 1px solid var(--rule);
            backdrop-filter: blur(10px);
        }

        /* ── Progress bar ── */
        #pgbar {
            position: fixed; top: 0; left: 0; height: 2px;
            background: var(--spirit);
            z-index: 9999; width: 0; transition: width .1s linear;
        }

        /* ── Badges ── */
        .badge-amber {
            display: inline-flex; align-items: center;
            background: #fef9ec; border: 0.5px solid #e9c84a;
            color: #7a5b06;
            font-family: 'Inter', sans-serif;
            font-size: .62rem; font-weight: 700; letter-spacing: .12em; text-transform: uppercase;
            padding: 4px 10px;
        }
        .badge-blue {
            display: inline-flex; align-items: center;
            background: #eef2ff; border: 0.5px solid rgba(26,63,196,.2);
            color: var(--royal);
            font-family: 'Inter', sans-serif;
            font-size: .62rem; font-weight: 700; letter-spacing: .12em; text-transform: uppercase;
            padding: 4px 10px;
        }
        .badge-green {
            display: inline-flex; align-items: center;
            background: #f0fdf4; border: 0.5px solid #86efac;
            color: #166534;
            font-family: 'Inter', sans-serif;
            font-size: .62rem; font-weight: 700; letter-spacing: .12em; text-transform: uppercase;
            padding: 4px 10px;
        }

        /* ── Schedule timeline ── */
        .schedule-item { position: relative; }
        .schedule-item + .schedule-item::before {
            content: '';
            position: absolute;
            left: 13px; top: -20px;
            height: 20px; width: 1px;
            background: var(--rule);
        }

        /* ── Card hover (desktop) ── */
        @media (min-width: 768px) {
            .ed-card { transition: transform .3s cubic-bezier(.22,1,.36,1), box-shadow .3s; }
            .ed-card:hover { transform: translateY(-2px); box-shadow: 0 10px 36px rgba(18,16,14,.08); }
        }

        /* ── Reveal ── */
        .reveal { opacity: 0; transform: translateY(18px); transition: opacity .7s cubic-bezier(.22,1,.36,1), transform .7s cubic-bezier(.22,1,.36,1); }
        .reveal.on { opacity: 1; transform: none; }
        .d1 { transition-delay: .1s; } .d2 { transition-delay: .2s; }

        /* ── Fade up ── */
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(14px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .fade-up   { animation: fadeUp .6s cubic-bezier(.22,1,.36,1) both; }
        .fade-up-2 { animation: fadeUp .6s cubic-bezier(.22,1,.36,1) .1s both; }

        /* ── Touch targets ── */
        @media (max-width: 767px) {
            .touch-target { min-height: 44px; display: flex; align-items: center; justify-content: center; }
        }
    </style>
</head>
<body class="antialiased">

<div id="pgbar"></div>

@php
    $bannerUrl = $event->banner_image
        ? \Illuminate\Support\Facades\Storage::disk('s3')->url($event->banner_image)
        : asset('images/100yearsevent.jpg');

    $eventDate = $event->event_date ? \Carbon\Carbon::parse($event->event_date) : null;
@endphp

<div x-data="{ mobileOpen: false }">

{{-- ══════════════════════════════════════════════
     TOP STRIP — desktop only
══════════════════════════════════════════════ --}}
<div style="background:var(--ink);" class="hidden md:block border-b border-white/10">
    <div class="max-w-7xl mx-auto px-6 py-1.5 flex items-center justify-between">
        <span class="caption-text" style="color:rgba(250,248,244,.4);">{{ now('Asia/Manila')->format('l, F j, Y') }}</span>
        <span class="caption-text" style="color:rgba(250,248,244,.4);">Est. 1926 · Tagbilaran, Bohol</span>
        <span class="caption-text" style="color:rgba(250,248,244,.4);">In Veritate et Caritate</span>
    </div>
</div>

{{-- ══════════════════════════════════════════════
     NAV
══════════════════════════════════════════════ --}}
<header id="nav" class="fixed inset-x-0 top-0 z-50 md:relative md:z-auto">
    <div class="max-w-7xl mx-auto px-4 sm:px-6">
        <div class="flex items-center justify-between py-3 md:py-4">

            {{-- Logo --}}
            <a href="{{ route('home') }}" class="flex items-center gap-2.5">
                <div class="h-8 w-8 rounded-full flex items-center justify-center flex-shrink-0 md:hidden"
                     style="background:var(--royal);">
                    <span class="kicker text-white text-[.5rem]" style="letter-spacing:.04em;">HSST</span>
                </div>
                <img src="{{ asset('images/hsstlogo.jpg') }}" alt="HSST Logo"
                     class="h-8 md:h-9 w-auto object-contain hidden md:block" />
                <div class="leading-tight">
                    <p class="display font-bold text-sm text-white md:text-ink" style="letter-spacing:-.01em;">HSSTian</p>
                    <p class="caption-text text-[.54rem] text-white/50 md:text-ink/40">Alumni Association</p>
                </div>
            </a>

            {{-- Desktop nav --}}
            <nav class="hidden md:flex items-center gap-7">
                <a href="{{ route('home') }}" class="caption-text text-ink/60 hover:text-ink transition-colors">Home</a>
                <a href="{{ route('history') }}" class="caption-text text-ink/60 hover:text-ink transition-colors">History</a>
                <a href="{{ route('events.index') }}" class="caption-text text-ink font-bold border-b-2 pb-0.5" style="border-color:var(--royal);">Events</a>
                <a href="{{ route('home') }}#crusade" class="caption-text text-ink/60 hover:text-ink transition-colors">CRUSADE</a>
                <a href="{{ route('home') }}#contact" class="caption-text text-ink/60 hover:text-ink transition-colors">Contact</a>
            </nav>

            {{-- Desktop auth --}}
            <div class="hidden md:flex items-center gap-3">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}"
                           class="caption-text px-4 py-2 hover:opacity-80 transition-opacity"
                           style="background:var(--ink);color:var(--paper);">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}"
                           class="caption-text border border-ink/20 text-ink/60 px-4 py-2 hover:border-ink/50 hover:text-ink transition-all">Login</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}"
                               class="caption-text px-4 py-2 hover:opacity-80 transition-opacity"
                               style="background:var(--ink);color:var(--paper);">Register</a>
                        @endif
                    @endauth
                @endif
            </div>

            {{-- Mobile hamburger --}}
            <button @click="mobileOpen = true"
                class="md:hidden w-10 h-10 flex items-center justify-center text-white"
                aria-label="Open menu">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
        </div>

        {{-- Desktop sub-rule --}}
        <hr class="col-rule hidden md:block"/>
        <div class="hidden md:flex items-center justify-center py-1.5">
            <span class="caption-text text-ink/30 text-[.6rem]" style="letter-spacing:.3em;">
                HOLY SPIRIT SCHOOL OF TAGBILARAN · EVENTS &amp; GATHERINGS
            </span>
        </div>
        <hr class="col-rule hidden md:block"/>
    </div>
</header>

{{-- ══════════════════════════════════════════════
     MOBILE MENU
══════════════════════════════════════════════ --}}
<div x-cloak x-show="mobileOpen"
     x-transition:enter="transition ease-out duration-200"
     x-transition:enter-start="opacity-0 -translate-y-2"
     x-transition:enter-end="opacity-100 translate-y-0"
     x-transition:leave="transition ease-in duration-150"
     x-transition:leave-start="opacity-100 translate-y-0"
     x-transition:leave-end="opacity-0 -translate-y-2"
     class="fixed inset-0 z-[60] md:hidden"
     style="background:var(--ink);">
    <div class="flex h-full flex-col" style="color:var(--paper);">

        <div class="flex items-center justify-between px-5 py-5 border-b border-white/10">
            <div>
                <p class="caption-text text-[.6rem]" style="color:rgba(250,248,244,.4);letter-spacing:.25em;">THE HSSTIAN</p>
                <h2 class="display text-xl font-bold mt-0.5" style="color:var(--paper);">Navigation</h2>
            </div>
            <button @click="mobileOpen = false"
                class="w-10 h-10 flex items-center justify-center border border-white/15 hover:bg-white/10 transition-colors"
                style="color:rgba(250,248,244,.6);">✕</button>
        </div>

        <nav class="flex-1 overflow-y-auto px-5 py-4 flex flex-col">
            <a @click="mobileOpen=false" href="{{ route('home') }}"
               class="display text-lg py-4 border-b border-white/8 hover:opacity-80"
               style="color:rgba(250,248,244,.8);">Home</a>
            <a @click="mobileOpen=false" href="{{ route('history') }}"
               class="display text-lg py-4 border-b border-white/8 hover:opacity-80"
               style="color:rgba(250,248,244,.8);">History</a>
            <a @click="mobileOpen=false" href="{{ route('events.index') }}"
               class="display text-lg font-bold py-4 border-b border-white/8"
               style="color:var(--paper);">Events</a>
            <a @click="mobileOpen=false" href="{{ route('home') }}#crusade"
               class="display text-lg py-4 border-b border-white/8 hover:opacity-80"
               style="color:rgba(250,248,244,.8);">CRUSADE</a>
            <a @click="mobileOpen=false" href="{{ route('home') }}#contact"
               class="display text-lg py-4 hover:opacity-80"
               style="color:rgba(250,248,244,.8);">Contact</a>
        </nav>

        @guest
            <div class="border-t border-white/10 px-5 py-5 flex flex-col gap-3">
                <a href="{{ route('login') }}"
                   class="flex items-center justify-center py-3.5 border border-white/15 caption-text hover:bg-white/5 transition-colors"
                   style="color:rgba(250,248,244,.7);">Login</a>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}"
                       class="flex items-center justify-center py-3.5 caption-text font-bold hover:opacity-90 transition-opacity"
                       style="background:var(--paper);color:var(--ink);">Register</a>
                @endif
            </div>
        @endguest
    </div>
</div>

{{-- ══════════════════════════════════════════════
     BREADCRUMB + HERO
══════════════════════════════════════════════ --}}
<section style="background:var(--paper); border-bottom:1px solid var(--rule);">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 pt-16 md:pt-0">

        {{-- Breadcrumb strip --}}
        <div class="flex flex-wrap items-center gap-2.5 py-4" style="border-bottom:1px solid var(--rule);">
            <a href="{{ route('events.index') }}"
               class="inline-flex items-center gap-1.5 px-3 py-1.5 caption-text text-ink/60 hover:text-ink transition-colors border border-ink/15 hover:border-ink/30">
                <svg width="12" height="12" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M10 12L6 8l4-4"/></svg>
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
        <div class="grid gap-8 py-10 lg:grid-cols-[1fr_480px] lg:gap-16 lg:py-16">

            {{-- Left: text --}}
            <div class="fade-up flex flex-col justify-center">
                <span class="kicker" style="color:var(--royal);">HSST Alumni Event</span>
                <div class="mt-3 mb-5 h-px w-11" style="background:linear-gradient(90deg,var(--spirit),#e8b80f);"></div>

                <h1 class="display font-bold text-ink" style="font-size:clamp(2.1rem,4.5vw,4rem);">
                    {{ $event->title }}
                </h1>

                <p class="garamond mt-5 max-w-xl text-ink/60">
                    {{ \Illuminate\Support\Str::limit(strip_tags($event->description ?? 'Stay connected with the HSST Alumni community through this official event page.'), 220) }}
                </p>

                {{-- Quick meta chips --}}
                <div class="mt-7 grid gap-px sm:grid-cols-3 border border-ink/10" style="background:var(--rule);">
                    <div class="px-4 py-3.5" style="background:var(--paper-dark);">
                        <p class="caption-text text-ink/35 text-[.6rem]">Date</p>
                        <p class="display font-bold text-ink mt-1.5" style="font-size:.92rem;line-height:1.3;">
                            {{ $eventDate ? $eventDate->format('F d, Y') : 'To be announced' }}
                        </p>
                    </div>
                    <div class="px-4 py-3.5" style="background:var(--paper-dark);">
                        <p class="caption-text text-ink/35 text-[.6rem]">Time</p>
                        <p class="display font-bold text-ink mt-1.5" style="font-size:.92rem;line-height:1.3;">
                            {{ $eventDate ? $eventDate->format('g:i A') : 'TBA' }}
                        </p>
                    </div>
                    <div class="px-4 py-3.5" style="background:var(--paper-dark);">
                        <p class="caption-text text-ink/35 text-[.6rem]">Venue</p>
                        <p class="display font-bold text-ink mt-1.5" style="font-size:.92rem;line-height:1.3;">
                            {{ $event->venue ?: 'To be announced' }}
                        </p>
                    </div>
                </div>

                <div class="mt-7 flex flex-wrap gap-3">
                    <a href="#event-details"
                       class="touch-target inline-flex items-center gap-2 caption-text font-bold px-7 py-3.5 hover:opacity-90 transition-opacity"
                       style="background:var(--ink);color:var(--paper);">
                        View Full Details
                        <svg width="13" height="13" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M8 3l5 5-5 5M3 8h10"/></svg>
                    </a>
                    @if(Route::has('register'))
                        <a href="{{ route('register') }}"
                           class="touch-target inline-flex items-center gap-2 caption-text border border-ink/20 text-ink/60 px-7 py-3.5 hover:border-ink/50 hover:text-ink transition-all">
                            Join the Alumni Portal
                        </a>
                    @endif
                </div>
            </div>

            {{-- Right: banner image --}}
            <div class="fade-up-2 overflow-hidden border border-ink/10" style="min-height:280px;">
                <img
                    src="{{ $bannerUrl }}"
                    alt="{{ $event->title }}"
                    class="h-full w-full object-cover object-center transition duration-500 hover:scale-[1.02]"
                    style="min-height:280px;"
                >
            </div>
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════════
     MAIN CONTENT
══════════════════════════════════════════════ --}}
<section id="event-details" class="py-14 sm:py-20" style="background:var(--paper-dark);">
    <div class="max-w-7xl mx-auto px-4 sm:px-6">
        <div class="grid gap-8 lg:grid-cols-[minmax(0,1fr)_340px] xl:gap-12">

            {{-- ── Main column ── --}}
            <div class="space-y-6">

                {{-- Event Overview --}}
                <div class="border border-ink/10 p-7 sm:p-10 ed-card reveal" style="background:var(--paper);">
                    <span class="kicker" style="color:var(--royal);">About the Event</span>
                    <div class="mt-3 mb-5 h-px w-11" style="background:linear-gradient(90deg,var(--spirit),#e8b80f);"></div>
                    <h2 class="display font-bold text-ink" style="font-size:clamp(1.8rem,3vw,2.8rem);">
                        Event Overview
                    </h2>
                    <div class="mt-7 garamond text-ink/60 max-w-3xl space-y-5">
                        @if ($event->description)
                            {!! nl2br(e($event->description)) !!}
                        @else
                            <p>No event description available yet. Please check back soon for updates.</p>
                        @endif
                    </div>
                </div>

                {{-- Schedule --}}
                @if ($event->schedules->isNotEmpty())
                    <div class="border border-ink/10 p-7 sm:p-10 ed-card reveal" style="background:var(--paper);">
                        <span class="kicker" style="color:var(--royal);">Program Flow</span>
                        <div class="mt-3 mb-5 h-px w-11" style="background:linear-gradient(90deg,var(--spirit),#e8b80f);"></div>
                        <h2 class="display font-bold text-ink" style="font-size:clamp(1.8rem,3vw,2.8rem);">
                            Event Schedule
                        </h2>

                        <div class="mt-8 space-y-5">
                            @foreach ($event->schedules->sortBy('schedule_time') as $index => $schedule)
                                <div class="schedule-item grid grid-cols-[28px_1fr] gap-5">
                                    <div class="relative z-10 flex h-7 w-7 shrink-0 items-center justify-center text-[10px] font-bold text-white"
                                         style="background:var(--royal);">
                                        {{ $index + 1 }}
                                    </div>
                                    <div class="pb-1">
                                        <p class="kicker" style="color:var(--spirit);">
                                            {{ $schedule->schedule_time
                                                ? \Carbon\Carbon::parse($schedule->schedule_time)->format('g:i A')
                                                : 'TBA' }}
                                        </p>
                                        @if ($schedule->title)
                                            <h3 class="display font-bold text-ink mt-1.5" style="font-size:1.1rem;line-height:1.25;">
                                                {{ $schedule->title }}
                                            </h3>
                                        @endif
                                        @if ($schedule->description)
                                            <p class="garamond text-ink/55 mt-2" style="font-size:.9rem;line-height:1.8;">
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
            <aside class="space-y-4 lg:sticky lg:top-24 lg:self-start">

                {{-- Event info card --}}
                <div class="border border-ink/10 ed-card overflow-hidden reveal" style="background:var(--paper);">
                    <div class="px-5 py-3.5 border-b border-ink/8" style="background:var(--paper-dark);">
                        <span class="kicker" style="color:var(--royal);">Event Information</span>
                    </div>
                    <div class="grid grid-cols-2 gap-x-4 gap-y-4 p-5">
                        <div>
                            <p class="caption-text text-ink/35 text-[.6rem] mb-1">Date</p>
                            <p class="display font-bold text-ink leading-5" style="font-size:.88rem;">
                                {{ $eventDate ? $eventDate->format('M d, Y') : 'To be announced' }}
                            </p>
                        </div>
                        <div>
                            <p class="caption-text text-ink/35 text-[.6rem] mb-1">Time</p>
                            <p class="display font-bold text-ink leading-5" style="font-size:.88rem;">
                                {{ $eventDate ? $eventDate->format('g:i A') : 'TBA' }}
                            </p>
                        </div>
                        <div class="col-span-2">
                            <p class="caption-text text-ink/35 text-[.6rem] mb-1">Venue</p>
                            <p class="display font-bold text-ink leading-5" style="font-size:.88rem;">
                                {{ $event->venue ?: 'To be announced' }}
                            </p>
                        </div>
                        @if($event->dress_code)
                            <div>
                                <p class="caption-text text-ink/35 text-[.6rem] mb-1">Dress Code</p>
                                <p class="display font-bold text-ink leading-5" style="font-size:.88rem;">
                                    {{ $event->dress_code }}
                                </p>
                            </div>
                        @endif
                        <div class="{{ $event->dress_code ? '' : 'col-span-2' }}">
                            <p class="caption-text text-ink/35 text-[.6rem] mb-1">Participation</p>
                            <p class="caption-text text-ink/70 leading-5" style="letter-spacing:.04em;text-transform:none;font-size:.72rem;">
                                Open to HSST alumni, faculty, and invited guests
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Stay Connected --}}
                <div class="border border-ink/10 ed-card overflow-hidden reveal d1" style="background:var(--paper-dark);">
                    <div class="p-5">
                        <span class="kicker" style="color:var(--royal);">Stay Connected</span>
                        <h3 class="display font-bold text-ink mt-2" style="font-size:1.15rem;line-height:1.25;">
                            Join the alumni portal
                        </h3>
                        <p class="garamond text-ink/55 mt-2" style="font-size:.88rem;line-height:1.7;">
                            Receive updates, reconnect with fellow alumni, and stay informed about upcoming events.
                        </p>
                        <div class="mt-4 flex flex-col gap-2.5">
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}"
                                   class="touch-target flex items-center justify-center py-3 caption-text font-bold hover:opacity-80 transition-opacity"
                                   style="background:var(--ink);color:var(--paper);">
                                    Create Account
                                </a>
                            @endif
                            @if (Route::has('login'))
                                <a href="{{ route('login') }}"
                                   class="touch-target flex items-center justify-center py-3 caption-text border border-ink/20 text-ink/60 hover:border-ink/50 hover:text-ink transition-all">
                                    Log in
                                </a>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Notice --}}
                <div class="border border-spirit/30 p-4 reveal d2" style="background:#fef9ec;">
                    <div class="flex items-start gap-2.5">
                        <svg class="mt-0.5 h-4 w-4 shrink-0" style="color:var(--spirit);" viewBox="0 0 16 16" fill="currentColor">
                            <path d="M8 1a7 7 0 1 0 0 14A7 7 0 0 0 8 1Zm0 4a.75.75 0 0 1 .75.75v3.5a.75.75 0 0 1-1.5 0v-3.5A.75.75 0 0 1 8 5Zm0 7.25a1 1 0 1 1 0-2 1 1 0 0 1 0 2Z"/>
                        </svg>
                        <p class="garamond" style="font-size:.88rem;line-height:1.7;color:#78350f;">
                            Please revisit this page before the event for any changes in venue, schedule, or additional instructions.
                        </p>
                    </div>
                </div>

            </aside>
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════════
     CTA
══════════════════════════════════════════════ --}}
<section class="py-20 sm:py-24 text-center" style="background:var(--ink);">
    <div class="max-w-3xl mx-auto px-5 sm:px-6">

        <div class="flex items-center justify-center gap-4 mb-6 reveal">
            <div class="h-px flex-1 max-w-24" style="background:rgba(250,248,244,.12);"></div>
            <span class="caption-text font-bold" style="color:var(--spirit);letter-spacing:.3em;font-size:.62rem;">JOIN THE COMMUNITY</span>
            <div class="h-px flex-1 max-w-24" style="background:rgba(250,248,244,.12);"></div>
        </div>

        <h2 class="display font-bold mb-5 reveal d1" style="color:var(--paper);font-size:clamp(1.9rem,5vw,4rem);">
            Ready to <em style="color:var(--spirit);">reconnect?</em>
        </h2>

        <p class="garamond mb-10 reveal d1" style="color:rgba(250,248,244,.5);max-width:36rem;margin-left:auto;margin-right:auto;">
            Create your account to stay updated on alumni events, school programs, and upcoming celebrations through one secure official portal.
        </p>

        <div class="flex flex-col sm:flex-row gap-3 justify-center reveal d2">
            @if (Route::has('register'))
                <a href="{{ route('register') }}"
                   class="touch-target caption-text font-bold px-10 py-4 hover:opacity-90 transition-opacity"
                   style="background:var(--paper);color:var(--ink);">
                    Create Account
                </a>
            @endif
            @if (Route::has('login'))
                <a href="{{ route('login') }}"
                   class="touch-target caption-text font-bold border border-white/25 px-10 py-4 hover:border-white/60 transition-all"
                   style="color:rgba(250,248,244,.7);">
                    Log in
                </a>
            @endif
        </div>

        <p class="caption-text mt-12 reveal d2" style="color:rgba(250,248,244,.15);letter-spacing:.25em;font-size:.62rem;">
            IN VERITATE ET CARITATE · TRUTH AND LOVE · 1926–2026
        </p>
    </div>
</section>

{{-- ══════════════════════════════════════════════
     FOOTER
══════════════════════════════════════════════ --}}
<footer id="contact" style="background:var(--ink);" class="pt-12 sm:pt-16 pb-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6">

        {{-- Brand colophon --}}
        <div class="text-center pb-10 mb-10 border-b border-white/8">
            <p class="caption-text mb-2" style="color:rgba(250,248,244,.25);letter-spacing:.3em;">THE OFFICIAL JOURNAL OF</p>
            <h2 class="display font-bold" style="color:var(--paper);font-size:clamp(1.4rem,4vw,3rem);">HSSTian Alumni Association</h2>
            <p class="caption-text mt-2" style="color:rgba(250,248,244,.3);letter-spacing:.15em;">HOLY SPIRIT SCHOOL OF TAGBILARAN · BOHOL, PHILIPPINES</p>
            <div class="flex items-center justify-center gap-4 mt-4">
                <div class="h-px flex-1 max-w-32" style="background:rgba(250,248,244,.1);"></div>
                <span class="caption-text font-bold" style="color:var(--spirit);letter-spacing:.22em;font-size:.65rem;">IN VERITATE ET CARITATE</span>
                <div class="h-px flex-1 max-w-32" style="background:rgba(250,248,244,.1);"></div>
            </div>
        </div>

        {{-- Footer columns --}}
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8 sm:gap-10 pb-10 sm:pb-12 border-b border-white/8">

            {{-- Brand --}}
            <div class="col-span-2 md:col-span-2">
                <div class="flex items-center gap-3 mb-4">
                    <div class="h-8 w-8 rounded-full flex items-center justify-center flex-shrink-0"
                         style="background:var(--royal);">
                        <span class="kicker text-white text-[.48rem]" style="letter-spacing:.04em;">HSST</span>
                    </div>
                    <div>
                        <p class="display font-bold text-base" style="color:var(--paper);">HSSTian</p>
                        <p class="caption-text text-[.55rem]" style="color:rgba(250,248,244,.25);letter-spacing:.22em;">Alumni Association</p>
                    </div>
                </div>
                <p class="garamond max-w-xs mb-4" style="color:rgba(250,248,244,.3);font-size:.9rem;line-height:1.7;">
                    United by faith. Driven by service. Forever Crusaders.
                    Tagbilaran City, Bohol, Philippines.
                </p>
                <p class="caption-text font-bold mb-1" style="color:var(--spirit);">In Veritate et Caritate</p>
                <p class="caption-text italic" style="color:rgba(250,248,244,.2);letter-spacing:.06em;text-transform:none;font-size:.68rem;">In Truth and in Love</p>
            </div>

            {{-- Quick links --}}
            <div>
                <p class="caption-text font-bold mb-4 sm:mb-5" style="color:rgba(250,248,244,.4);letter-spacing:.2em;">Quick Links</p>
                <ul class="space-y-3">
                    <li><a href="{{ route('home') }}" class="caption-text hover:opacity-70 transition-opacity" style="color:rgba(250,248,244,.25);letter-spacing:.08em;text-transform:none;font-size:.8rem;">Home</a></li>
                    <li><a href="{{ route('history') }}" class="caption-text hover:opacity-70 transition-opacity" style="color:rgba(250,248,244,.25);letter-spacing:.08em;text-transform:none;font-size:.8rem;">History</a></li>
                    <li><a href="{{ route('events.index') }}" class="caption-text hover:opacity-70 transition-opacity" style="color:rgba(250,248,244,.6);letter-spacing:.08em;text-transform:none;font-size:.8rem;">Events</a></li>
                    <li><a href="#event-details" class="caption-text hover:opacity-70 transition-opacity" style="color:rgba(250,248,244,.25);letter-spacing:.08em;text-transform:none;font-size:.8rem;">Event Details</a></li>
                    <li><a href="{{ route('home') }}#crusade" class="caption-text hover:opacity-70 transition-opacity" style="color:rgba(250,248,244,.25);letter-spacing:.08em;text-transform:none;font-size:.8rem;">CRUSADE</a></li>
                </ul>
            </div>

            {{-- Contact --}}
            <div>
                <p class="caption-text font-bold mb-4 sm:mb-5" style="color:rgba(250,248,244,.4);letter-spacing:.2em;">Contact</p>
                <ul class="space-y-4">
                    <li class="flex gap-2.5 items-start">
                        <svg class="w-3 h-3 sm:w-3.5 sm:h-3.5 mt-0.5 shrink-0" style="color:rgba(250,248,244,.3);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        <span class="caption-text" style="color:rgba(250,248,244,.25);letter-spacing:.04em;text-transform:none;font-size:.72rem;">alumni@hss-tagbilaran.edu.ph</span>
                    </li>
                    <li class="flex gap-2.5 items-start">
                        <svg class="w-3 h-3 sm:w-3.5 sm:h-3.5 mt-0.5 shrink-0" style="color:rgba(250,248,244,.3);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        </svg>
                        <span class="caption-text" style="color:rgba(250,248,244,.25);letter-spacing:.04em;text-transform:none;font-size:.72rem;">J.A. Clarin, Purok 3, Dao District, Tagbilaran City, Bohol 6300</span>
                    </li>
                </ul>
            </div>
        </div>

        {{-- Bottom bar --}}
        <div class="pt-6 sm:pt-8 flex flex-col items-center sm:flex-row sm:justify-between gap-3 text-center sm:text-left">
            <p class="caption-text" style="color:rgba(250,248,244,.15);letter-spacing:.08em;text-transform:none;font-size:.7rem;">
                © {{ now('Asia/Manila')->format('Y') }} HSSTian Alumni Association · Holy Spirit School of Tagbilaran. All rights reserved.
            </p>
            <p class="caption-text font-bold" style="color:var(--spirit);opacity:.5;letter-spacing:.25em;font-size:.62rem;">
                CRUSADERS FOREVER ✦
            </p>
        </div>
    </div>
</footer>

</div>{{-- end x-data --}}

<script>
    // Progress bar
    window.addEventListener('scroll', () => {
        const pct = (window.scrollY / (document.body.scrollHeight - window.innerHeight)) * 100;
        document.getElementById('pgbar').style.width = pct + '%';
    }, { passive: true });

    // Nav scroll behavior (desktop only)
    const nav = document.getElementById('nav');
    window.addEventListener('scroll', () => {
        nav.classList.toggle('scrolled', window.scrollY > 40);
    }, { passive: true });

    // Reveal animations
    const reveals = document.querySelectorAll('.reveal');
    const observer = new IntersectionObserver(entries => {
        entries.forEach(e => {
            if (e.isIntersecting) { e.target.classList.add('on'); observer.unobserve(e.target); }
        });
    }, { threshold: .12 });
    reveals.forEach(el => observer.observe(el));
</script>
</body>
</html>
