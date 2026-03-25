<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Holy Spirit School of Tagbilaran Alumni Portal</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        [x-cloak] { display: none !important; }

        .font-body { font-family: "Inter", system-ui, sans-serif; }
        .font-display { font-family: "DM Serif Display", Georgia, serif; }

        /* Hamburger animation */
        .hamburger-line { transition: all .22s ease; }
        .hamburger-open .line-1 { transform: translateY(6px) rotate(45deg); }
        .hamburger-open .line-2 { opacity: 0; }
        .hamburger-open .line-3 { transform: translateY(-6px) rotate(-45deg); }

        /* Glassmorphism */
        .glass {
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            background: rgba(17, 19, 21, 0.75);
            border: 1px solid rgba(255, 255, 255, 0.08);
        }
        .glass-light {
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            background: rgba(255, 255, 255, 0.85);
            border: 1px solid rgba(0, 0, 0, 0.05);
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #0f0f10;
        }
        ::-webkit-scrollbar-thumb {
            background: #c6a56b;
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #d8b67a;
        }
    </style>
</head>
<body class="overflow-x-hidden bg-[#0b0b0c] font-body text-[#e6e1d4] antialiased">
<div x-data="{ mobileOpen: false }">

    {{-- HEADER (Glass, sticky) --}}
    <header class="sticky inset-x-0 top-0 z-50 border-b border-white/10 bg-[#111315]/80 backdrop-blur-xl">
        <div class="mx-auto flex h-[72px] max-w-[1320px] items-center justify-between px-5 md:px-6 lg:px-8">
            <a href="{{ route('home') }}" class="flex min-w-0 items-center gap-3 transition hover:opacity-80">
                <div class="flex h-11 w-11 shrink-0 items-center justify-center overflow-hidden rounded-xl border border-white/10 bg-white/95 p-1 shadow-sm">
                    <img
                        src="{{ asset('images/hsstlogo.jpg') }}"
                        alt="HSST Logo"
                        class="h-full w-full object-contain"
                    >
                </div>
                <div class="min-w-0">
                    <p class="text-[9px] font-semibold uppercase tracking-[0.28em] text-[#c6a56b]">
                        Official Alumni Portal
                    </p>
                    <p class="truncate text-[13px] font-semibold text-white">
                        Holy Spirit School of Tagbilaran
                    </p>
                </div>
            </a>

            <nav class="hidden items-center gap-1 lg:flex">
                <a href="#homecoming" class="rounded-xl px-4 py-2 text-sm text-[#e0dbc8] transition hover:bg-white/5 hover:text-[#c6a56b]">Homecoming</a>
                <a href="#events" class="rounded-xl px-4 py-2 text-sm text-[#e0dbc8] transition hover:bg-white/5 hover:text-[#c6a56b]">Events</a>
                <a href="#announcements" class="rounded-xl px-4 py-2 text-sm text-[#e0dbc8] transition hover:bg-white/5 hover:text-[#c6a56b]">Announcements</a>
                <a href="#contact" class="rounded-xl px-4 py-2 text-sm text-[#e0dbc8] transition hover:bg-white/5 hover:text-[#c6a56b]">Contact</a>
            </nav>

            <div class="hidden items-center gap-2 lg:flex">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="rounded-full bg-[#c6a56b] px-5 py-2 text-sm font-semibold text-black transition hover:bg-[#d8b67a] shadow-[0_8px_20px_rgba(198,165,107,0.2)]">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="rounded-full border border-white/15 bg-white/5 px-4 py-2 text-sm font-medium text-[#e0dbc8] transition hover:bg-white/10 hover:text-white">
                            Log in
                        </a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="rounded-full bg-[#c6a56b] px-5 py-2 text-sm font-semibold text-black transition hover:bg-[#d8b67a] shadow-[0_8px_20px_rgba(198,165,107,0.2)]">
                                Register
                            </a>
                        @endif
                    @endauth
                @endif
            </div>

            <button
                @click="mobileOpen = !mobileOpen"
                :class="mobileOpen ? 'hamburger-open' : ''"
                class="flex flex-col gap-[4.5px] rounded-xl border border-white/10 bg-white/5 p-2.5 shadow-sm lg:hidden"
                aria-label="Menu"
            >
                <span class="hamburger-line line-1 block h-[1.5px] w-[18px] rounded bg-white"></span>
                <span class="hamburger-line line-2 block h-[1.5px] w-[18px] rounded bg-white"></span>
                <span class="hamburger-line line-3 block h-[1.5px] w-[18px] rounded bg-white"></span>
            </button>
        </div>
    </header>

    {{-- MOBILE NAV (Glass) --}}
    <div
        x-cloak
        x-show="mobileOpen"
        x-transition.opacity.duration.200ms
        class="fixed inset-x-0 top-[72px] z-40 border-t border-white/10 bg-[#111315]/95 backdrop-blur-xl px-5 py-5 shadow-lg lg:hidden"
    >
        <div class="flex flex-col gap-1">
            <a @click="mobileOpen=false" href="#homecoming" class="rounded-xl px-4 py-3 text-sm text-[#e0dbc8] hover:bg-white/5 hover:text-[#c6a56b]">Homecoming</a>
            <a @click="mobileOpen=false" href="#events" class="rounded-xl px-4 py-3 text-sm text-[#e0dbc8] hover:bg-white/5 hover:text-[#c6a56b]">Events</a>
            <a @click="mobileOpen=false" href="#announcements" class="rounded-xl px-4 py-3 text-sm text-[#e0dbc8] hover:bg-white/5 hover:text-[#c6a56b]">Announcements</a>
            <a @click="mobileOpen=false" href="#contact" class="rounded-xl px-4 py-3 text-sm text-[#e0dbc8] hover:bg-white/5 hover:text-[#c6a56b]">Contact</a>
        </div>

        @if (Route::has('login'))
            <div class="my-4 h-px bg-white/10"></div>

            @auth
                <a href="{{ url('/dashboard') }}" class="block rounded-full bg-[#c6a56b] px-4 py-3 text-center text-sm font-semibold text-black">
                    Dashboard
                </a>
            @else
                <a href="{{ route('login') }}" class="block rounded-full border border-white/15 bg-white/5 px-4 py-3 text-center text-sm font-medium text-[#e0dbc8]">
                    Log in
                </a>

                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="mt-2 block rounded-full bg-[#c6a56b] px-4 py-3 text-center text-sm font-semibold text-black">
                        Register
                    </a>
                @endif
            @endauth
        @endif
    </div>

    {{-- HERO SECTION (with subtle radial gradient) --}}
    <section class="relative overflow-hidden">
        {{-- Background image with overlay --}}
        <div class="absolute inset-0">
            <img
                src="{{ asset('images/herosection.jpg') }}"
                alt="HSST alumni community"
                class="h-full w-full object-cover object-center"
            >
            <div class="absolute inset-0 bg-gradient-to-r from-[#0b0b0c]/90 via-[#0b0b0c]/60 to-[#0b0b0c]/30"></div>
        </div>

        <div class="relative z-10 mx-auto max-w-[1320px] px-5 py-20 md:px-6 lg:py-28">
            <div class="max-w-3xl">
                <div class="inline-flex items-center gap-2 rounded-full border border-[#c6a56b]/30 bg-[#c6a56b]/10 px-4 py-1.5 backdrop-blur-sm">
                    <span class="h-2 w-2 rounded-full bg-[#c6a56b]"></span>
                    <p class="text-[10px] font-semibold uppercase tracking-[0.24em] text-[#c6a56b]">
                        Holy Spirit School of Tagbilaran
                    </p>
                </div>

                <h1 class="mt-6 font-display text-[3rem] leading-[0.95] tracking-[-0.03em] text-white sm:text-[4rem] lg:text-[5rem]">
                    Forever part of the
                    <span class="text-[#c6a56b]">HSST alumni family.</span>
                </h1>

                <p class="mt-6 max-w-2xl text-[15px] leading-8 text-[#d6cfbe] sm:text-[17px]">
                    Reconnect through official announcements, alumni events, school milestones, and one welcoming digital home designed for every HSST graduate.
                </p>

                <div class="mt-10 flex flex-col gap-4 sm:flex-row">
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="inline-flex items-center justify-center rounded-full bg-[#c6a56b] px-7 py-4 text-sm font-semibold uppercase tracking-[0.16em] text-black transition hover:bg-[#d8b67a] shadow-[0_12px_28px_rgba(198,165,107,0.3)]">
                            Join the Alumni Network
                        </a>
                    @endif

                    <a href="#events" class="inline-flex items-center justify-center rounded-full border border-white/20 bg-white/5 px-7 py-4 text-sm font-medium uppercase tracking-[0.16em] text-[#e0dbc8] transition hover:bg-white/10 hover:text-white">
                        Explore Events
                    </a>
                </div>

                <div class="mt-12 grid max-w-xl grid-cols-3 gap-4 border-t border-white/10 pt-8">
                    <div>
                        <p class="text-2xl font-extrabold text-[#c6a56b]">100+</p>
                        <p class="mt-1 text-xs text-[#9e988c]">Years of legacy</p>
                    </div>
                    <div>
                        <p class="text-2xl font-extrabold text-[#c6a56b]">Alumni</p>
                        <p class="mt-1 text-xs text-[#9e988c]">Across generations</p>
                    </div>
                    <div>
                        <p class="text-2xl font-extrabold text-[#c6a56b]">1 Home</p>
                        <p class="mt-1 text-xs text-[#9e988c]">Official digital portal</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- HOMECOMING SECTION (Clean cards) --}}
    <section id="homecoming" class="py-20 lg:py-28 bg-[#0f1115]">
        <div class="mx-auto max-w-[1320px] px-5 md:px-6 lg:px-8">
            <div class="max-w-4xl">
                <p class="text-[11px] font-semibold uppercase tracking-[0.28em] text-[#c6a56b]">
                    Grand Alumni Homecoming
                </p>
                <h2 class="mt-4 font-display text-[2.3rem] leading-[1.04] text-white sm:text-[3rem] lg:text-[3.5rem]">
                    Whether you studied decades ago or graduated recently, you remain part of the HSST story.
                </h2>
                <p class="mt-6 max-w-3xl text-[15px] leading-8 text-[#b4ad9c]">
                    The HSST Alumni Homecoming celebrates friendship, tradition, and return. It brings together generations of graduates to revisit campus memories, strengthen bonds, and continue a shared legacy of faith, learning, and community.
                </p>
            </div>

            <div class="mt-14 grid gap-6 md:grid-cols-2">
                <div class="rounded-2xl border border-white/10 bg-[#1a1c20] p-8 transition hover:border-[#c6a56b]/30 hover:shadow-[0_12px_28px_rgba(0,0,0,0.3)]">
                    <p class="text-[11px] font-semibold uppercase tracking-[0.22em] text-[#c6a56b]">
                        What to expect
                    </p>
                    <h3 class="mt-3 text-xl font-semibold text-white">
                        A warmer alumni experience
                    </h3>
                    <p class="mt-4 text-sm leading-7 text-[#b4ad9c]">
                        Reunion updates, featured gatherings, school news, and a smoother portal experience thoughtfully designed for alumni returning home.
                    </p>
                </div>

                <div class="rounded-2xl border border-white/10 bg-[#1a1c20] p-8 transition hover:border-[#c6a56b]/30 hover:shadow-[0_12px_28px_rgba(0,0,0,0.3)]">
                    <p class="text-[11px] font-semibold uppercase tracking-[0.22em] text-[#c6a56b]">
                        Why it matters
                    </p>
                    <h3 class="mt-3 text-xl font-semibold text-white">
                        One stronger connection across generations
                    </h3>
                    <p class="mt-4 text-sm leading-7 text-[#b4ad9c]">
                        It gives every HSSTian one trusted place to stay informed, participate in alumni activities, and remain connected with the school community.
                    </p>
                </div>
            </div>
        </div>
    </section>

    {{-- EVENTS SECTION (Cards with hover effect) --}}
    <section id="events" class="py-20 lg:py-28 bg-[#0b0b0c]">
        <div class="mx-auto max-w-[1320px] px-5 md:px-6 lg:px-8">
            <div class="mb-10 flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
                <div>
                    <p class="mb-3 text-[11px] font-semibold uppercase tracking-[0.30em] text-[#c6a56b]">
                        Upcoming Events
                    </p>
                    <h2 class="font-display text-[2rem] leading-[1.04] text-white sm:text-[2.6rem]">
                        Alumni News and Events
                    </h2>
                </div>

                <a href="{{ route('events.index') }}"
                   class="text-sm font-semibold uppercase tracking-[0.12em] text-[#c6a56b] transition hover:text-[#d8b67a]">
                    View All
                </a>
            </div>

            @if ($events->isNotEmpty())
                <div class="grid gap-8 md:grid-cols-2 xl:grid-cols-3">
                    @foreach ($events as $event)
                        @php
                            $bannerUrl = $event->banner_image
                                ? \Illuminate\Support\Facades\Storage::disk('s3')->url($event->banner_image)
                                : asset('images/100yearsevent.jpg');
                        @endphp

                        <article class="group relative rounded-2xl overflow-hidden border border-white/10 bg-[#1a1c20] transition hover:border-[#c6a56b]/40 hover:shadow-[0_20px_40px_rgba(0,0,0,0.4)]">
                            <div class="relative h-56 overflow-hidden">
                                <img
                                    src="{{ $bannerUrl }}"
                                    alt="{{ $event->title }}"
                                    class="h-full w-full object-cover transition duration-700 group-hover:scale-105"
                                >
                                <div class="absolute inset-0 bg-gradient-to-t from-[#0b0b0c] via-transparent to-transparent opacity-60"></div>
                                <div class="absolute left-4 top-4">
                                    <span class="inline-flex rounded-full bg-[#c6a56b]/90 px-3 py-1 text-[10px] font-semibold uppercase tracking-[0.18em] text-black backdrop-blur-sm">
                                        Upcoming
                                    </span>
                                </div>
                            </div>

                            <div class="p-6">
                                <p class="text-[11px] font-semibold uppercase tracking-[0.28em] text-[#c6a56b]">
                                    {{ \Carbon\Carbon::parse($event->event_date)->format('F d, Y') }}
                                    @if ($event->schedules->first()?->schedule_time)
                                        · {{ \Carbon\Carbon::parse($event->schedules->first()->schedule_time)->format('g:i A') }}
                                    @endif
                                </p>

                                <h3 class="mt-3 font-display text-[1.6rem] leading-[1.12] text-white transition group-hover:text-[#c6a56b]">
                                    <a href="{{ route('events.show', ['event' => $event->slug]) }}">
                                        {{ $event->title }}
                                    </a>
                                </h3>

                                @if ($event->venue)
                                    <p class="mt-3 text-sm font-medium text-[#d6cfbe]">
                                        {{ $event->venue }}
                                    </p>
                                @endif

                                @if ($event->dress_code)
                                    <p class="mt-1 text-xs text-[#9e988c]">
                                        Dress Code: {{ $event->dress_code }}
                                    </p>
                                @endif

                                <p class="mt-4 text-sm leading-6 text-[#b4ad9c]">
                                    {{ \Illuminate\Support\Str::limit($event->description, 140) }}
                                </p>

                                <div class="mt-6">
                                    <a
                                        href="{{ route('events.show', $event) }}"
                                        class="inline-flex items-center gap-2 text-sm font-semibold uppercase tracking-[0.14em] text-[#c6a56b] transition hover:gap-3 hover:text-[#d8b67a]"
                                    >
                                        Read more
                                        <span aria-hidden="true">→</span>
                                    </a>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
            @else
                <div class="rounded-2xl border border-white/10 bg-[#1a1c20] p-8 text-center">
                    <p class="text-sm font-semibold uppercase tracking-[0.24em] text-[#c6a56b]">Events</p>
                    <h3 class="mt-4 font-display text-[1.8rem] text-white">No upcoming event yet</h3>
                    <p class="mt-3 max-w-xl mx-auto text-sm leading-7 text-[#b4ad9c]">
                        Please check back soon for the next scheduled school or alumni event.
                    </p>
                </div>
            @endif
        </div>
    </section>

    {{-- ANNOUNCEMENTS SECTION (Clean cards) --}}
    <section id="announcements" class="py-20 lg:py-28 bg-[#0f1115]">
        <div class="mx-auto max-w-[1320px] px-5 md:px-6 lg:px-8">
            <div class="mb-10">
                <p class="mb-3 text-[11px] font-semibold uppercase tracking-[0.30em] text-[#c6a56b]">
                    Announcements
                </p>
                <h2 class="font-display text-[2rem] leading-[1.04] text-white sm:text-[2.5rem]">
                    Important notices & updates
                </h2>
            </div>

            <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
                @forelse ($announcements as $announcement)
                    <article class="rounded-2xl border border-white/10 bg-[#1a1c20] p-6 transition hover:border-[#c6a56b]/30 hover:shadow-[0_12px_28px_rgba(0,0,0,0.3)]">
                        <div class="mb-4 flex flex-wrap items-center gap-2">
                            <span class="inline-flex rounded-full bg-[#c6a56b]/10 px-3 py-1 text-[10px] font-semibold uppercase tracking-[0.18em] text-[#c6a56b] border border-[#c6a56b]/20">
                                Announcement
                            </span>

                            @if ($announcement->pinned)
                                <span class="inline-flex rounded-full bg-[#c6a56b] px-3 py-1 text-[10px] font-semibold uppercase tracking-[0.18em] text-black">
                                    Pinned
                                </span>
                            @endif
                        </div>

                        <h3 class="text-lg font-semibold leading-[1.4] text-white">
                            {{ $announcement->title }}
                        </h3>

                        <p class="mt-4 text-sm leading-6 text-[#b4ad9c]">
                            {{ \Illuminate\Support\Str::limit(strip_tags($announcement->content), 180) }}
                        </p>

                        <div class="mt-5 text-[11px] font-medium text-[#9e988c]">
                            @if ($announcement->published_at)
                                {{ $announcement->published_at->format('F d, Y') }}
                            @else
                                Recently published
                            @endif
                        </div>
                    </article>
                @empty
                    <div class="rounded-2xl border border-white/10 bg-[#1a1c20] p-8 text-center text-sm text-[#b4ad9c]">
                        No announcements available right now.
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    {{-- FINAL CTA (Gold accent) --}}
    <section class="relative overflow-hidden bg-gradient-to-br from-[#0b0b0c] to-[#1a1c20] py-20 lg:py-24">
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,rgba(198,165,107,0.12),transparent_40%)]"></div>
        <div class="relative z-10 mx-auto max-w-[1320px] px-5 md:px-6 lg:px-8">
            <div class="grid gap-10 lg:grid-cols-[1.2fr_.8fr] lg:items-center">
                <div>
                    <p class="text-[11px] font-semibold uppercase tracking-[0.30em] text-[#c6a56b]">
                        Join the HSST Network
                    </p>
                    <h2 class="mt-4 font-display text-[2rem] leading-[1.05] text-white sm:text-[2.6rem] lg:text-[3rem]">
                        Ready to reconnect with the HSST community?
                    </h2>
                    <p class="mt-5 max-w-2xl text-[15px] leading-7 text-[#d6cfbe]">
                        Create your account to receive updates, participate in alumni activities, and stay connected through one secure school-managed platform.
                    </p>
                </div>

                <div class="flex flex-col gap-3">
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="block rounded-full bg-[#c6a56b] px-6 py-4 text-center text-sm font-semibold uppercase tracking-[0.16em] text-black transition hover:bg-[#d8b67a] shadow-[0_12px_28px_rgba(198,165,107,0.3)]">
                            Create Account
                        </a>
                    @endif

                    @if (Route::has('login'))
                        <a href="{{ route('login') }}" class="block rounded-full border border-white/20 bg-white/5 px-6 py-4 text-center text-sm font-medium text-[#e0dbc8] transition hover:bg-white/10 hover:text-white">
                            Log in to Existing Account
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </section>

    {{-- FOOTER (Dark) --}}
    <footer id="contact" class="bg-[#0a0a0c] text-[#b4ad9c]">
        <div class="mx-auto grid max-w-[1320px] gap-10 px-5 py-12 md:px-6 lg:grid-cols-[1.3fr_.8fr_.8fr] lg:px-8 lg:py-16">
            <div>
                <a href="{{ route('home') }}" class="flex items-center gap-3">
                    <div class="flex h-11 w-11 shrink-0 items-center justify-center overflow-hidden rounded-xl border border-white/10 bg-white p-1 shadow-sm">
                        <img
                            src="{{ asset('images/hsstlogo.jpg') }}"
                            alt="HSST Logo"
                            class="h-full w-full rounded-lg object-contain"
                        >
                    </div>
                    <div>
                        <p class="text-[9px] font-semibold uppercase tracking-[0.24em] text-[#c6a56b]">
                            Official Alumni Portal
                        </p>
                        <p class="text-[13px] font-semibold text-white">
                            Holy Spirit School of Tagbilaran
                        </p>
                    </div>
                </a>
                <p class="mt-5 max-w-[390px] text-sm leading-7 text-[#b4ad9c]">
                    A digital home for official announcements, alumni events, school celebrations, and a stronger connection between HSST and its graduates.
                </p>
                <p class="mt-4 text-xs text-[#7f796f]">
                    Managed by HSST Administration &amp; Alumni Office
                </p>
            </div>

            <div>
                <p class="mb-4 text-[10px] font-semibold uppercase tracking-[0.22em] text-[#c6a56b]">Quick Links</p>
                <div class="space-y-2">
                    <a href="#homecoming" class="block text-sm text-[#b4ad9c] transition hover:text-[#c6a56b]">Homecoming</a>
                    <a href="#events" class="block text-sm text-[#b4ad9c] transition hover:text-[#c6a56b]">Events</a>
                    <a href="#announcements" class="block text-sm text-[#b4ad9c] transition hover:text-[#c6a56b]">Announcements</a>
                </div>
            </div>

            <div>
                <p class="mb-4 text-[10px] font-semibold uppercase tracking-[0.22em] text-[#c6a56b]">Account</p>
                <div class="space-y-2">
                    @if (Route::has('login'))
                        <a href="{{ route('login') }}" class="block text-sm text-[#b4ad9c] transition hover:text-[#c6a56b]">Log in</a>
                    @endif
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="block text-sm text-[#b4ad9c] transition hover:text-[#c6a56b]">Register</a>
                    @endif
                    <a href="{{ url('/dashboard') }}" class="block text-sm text-[#b4ad9c] transition hover:text-[#c6a56b]">Dashboard</a>
                </div>
            </div>
        </div>

        <div class="mx-auto flex max-w-[1320px] flex-col gap-2 border-t border-white/10 px-5 py-5 text-xs text-[#7f796f] md:flex-row md:items-center md:justify-between md:px-6 lg:px-8">
            <p>© 2026 Holy Spirit School of Tagbilaran. All rights reserved.</p>
            <p>Truth in Love · Faith · Learning · Community</p>
        </div>
    </footer>
</div>
</body>
</html>