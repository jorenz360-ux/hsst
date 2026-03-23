<!DOCTYPE html>
<html lang="en" class="scroll-smooth dark">
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
                <a href="#homecoming" class="rounded-xl px-4 py-2 text-sm text-[#d6d0c4] transition hover:bg-white/5 hover:text-white">Home</a>
                <a href="#features" class="rounded-xl px-4 py-2 text-sm text-[#d6d0c4] transition hover:bg-white/5 hover:text-white">Features</a>
                <a href="#events" class="rounded-xl px-4 py-2 text-sm text-[#d6d0c4] transition hover:bg-white/5 hover:text-white">Events</a>
                <a href="#announcements" class="rounded-xl px-4 py-2 text-sm text-[#d6d0c4] transition hover:bg-white/5 hover:text-white">Announcements</a>
                <a href="#contact" class="rounded-xl px-4 py-2 text-sm text-[#d6d0c4] transition hover:bg-white/5 hover:text-white">Contact</a>
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
            <a @click="mobileOpen=false" href="#homecoming" class="rounded-xl px-4 py-3 text-sm text-[#d6d0c4] hover:bg-white/5 hover:text-white">Home</a>
            <a @click="mobileOpen=false" href="#features" class="rounded-xl px-4 py-3 text-sm text-[#d6d0c4] hover:bg-white/5 hover:text-white">Features</a>
            <a @click="mobileOpen=false" href="#events" class="rounded-xl px-4 py-3 text-sm text-[#d6d0c4] hover:bg-white/5 hover:text-white">Events</a>
            <a @click="mobileOpen=false" href="#announcements" class="rounded-xl px-4 py-3 text-sm text-[#d6d0c4] hover:bg-white/5 hover:text-white">Announcements</a>
            <a @click="mobileOpen=false" href="#contact" class="rounded-xl px-4 py-3 text-sm text-[#d6d0c4] hover:bg-white/5 hover:text-white">Contact</a>
        </div>

        @if (Route::has('login'))
            <div class="my-4 h-px bg-white/10"></div>

            @auth
                <a href="{{ url('/dashboard') }}" class="block bg-[#c6a56b] px-4 py-3 text-center text-sm font-semibold text-black">
                    Dashboard
                </a>
            @else
                <a href="{{ route('login') }}" class="block border border-white/15 px-4 py-3 text-center text-sm font-medium text-[#f5f1e8]">
                    Log in
                </a>

                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="mt-2 block bg-[#c6a56b] px-4 py-3 text-center text-sm font-semibold text-black">
                        Register
                    </a>
                @endif
            @endauth
        @endif
    </div>

    {{-- HERO --}}
    <section class="relative min-h-[95vh] overflow-hidden">
        <div class="absolute inset-0">
            <img
                src="{{ asset('images/herosection.jpg') }}"
                alt="HSST alumni community"
                class="h-full w-full object-cover object-center"
            >
        </div>

        <div class="absolute inset-0 bg-black/60"></div>
        <div class="absolute inset-0 bg-[linear-gradient(90deg,rgba(0,0,0,0.70)_0%,rgba(0,0,0,0.42)_45%,rgba(0,0,0,0.60)_100%)]"></div>

        <div class="relative z-10 mx-auto flex min-h-[95vh] max-w-[1320px] items-center px-5 pt-24 md:px-6 lg:px-8">
            <div class="max-w-3xl">
                <p class="text-[11px] font-semibold uppercase tracking-[0.34em] text-[#c6a56b]">
                    Holy Spirit School of Tagbilaran
                </p>

                <h1 class="mt-5 font-display text-[3rem] leading-[0.94] tracking-[-0.03em] text-white sm:text-[4rem] lg:text-[5.8rem]">
                    Come home
                    <br>
                    to memory,
                    <br>
                    legacy, and connection.
                </h1>

                <p class="mt-6 max-w-2xl text-[15px] leading-8 text-[#d6d0c4] sm:text-[17px]">
                    Discover official announcements, upcoming alumni gatherings, and school celebrations through a refined digital home built for every HSSTian.
                </p>

                <div class="mt-10 flex flex-col gap-4 sm:flex-row">
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="inline-flex items-center justify-center bg-[#c6a56b] px-7 py-4 text-sm font-semibold uppercase tracking-[0.18em] text-black transition hover:bg-[#d8b67a]">
                            Join the Alumni Network
                        </a>
                    @endif

                    <a href="#events" class="inline-flex items-center justify-center border border-white/20 px-7 py-4 text-sm font-medium uppercase tracking-[0.18em] text-white transition hover:bg-white/10">
                        Explore Events
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- HOMECOMING --}}
    <section id="homecoming" class="bg-[#111315] py-20 lg:py-28">
        <div class="mx-auto grid max-w-[1320px] items-center gap-12 px-5 md:px-6 lg:grid-cols-[0.95fr_1.05fr] lg:px-8">
            <div class="overflow-hidden">
                <img
                    src="{{ asset('images/hsstlogo.jpg') }}"
                    alt="HSST Logo"
                    class="mx-auto aspect-square w-full max-w-[460px] object-contain bg-[#17191c] p-10"
                >
            </div>

            <div>
                <p class="text-[11px] font-semibold uppercase tracking-[0.28em] text-[#c6a56b]">
                    Grand Alumni Homecoming
                </p>

                <h2 class="mt-5 font-display text-[2.2rem] leading-[1.03] text-white sm:text-[2.8rem] lg:text-[3.6rem]">
                    Whether you studied in 1926 or graduated in 2026, you remain part of the HSST family.
                </h2>

                <p class="mt-6 max-w-2xl text-[15px] leading-8 text-[#d6d0c4]">
                    The HSST Alumni Homecoming is a celebration of shared history, friendship, and return. It brings together generations of graduates in one meaningful space to reconnect with classmates, revisit the campus, and renew a lifelong bond with the school.
                </p>

                <div class="mt-10 grid gap-6 sm:grid-cols-2">
                    <div>
                        <h3 class="text-lg font-semibold text-white">What to expect</h3>
                        <p class="mt-3 text-sm leading-7 text-[#9e988c]">
                            Reunion moments, featured gatherings, school updates, and a more graceful registration experience.
                        </p>
                    </div>

                    <div>
                        <h3 class="text-lg font-semibold text-white">Why it matters</h3>
                        <p class="mt-3 text-sm leading-7 text-[#9e988c]">
                            It strengthens alumni-school connection and gives every HSSTian a central place to stay informed and involved.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- FEATURES --}}
    <section id="features" class="bg-[#0b0b0c] py-20 lg:py-28">
        <div class="mx-auto max-w-[1320px] px-5 md:px-6 lg:px-8">
            <div class="mb-14 grid gap-6 lg:grid-cols-[1.1fr_.9fr] lg:items-end">
                <div>
                    <p class="text-[11px] font-semibold uppercase tracking-[0.30em] text-[#c6a56b]">
                        Platform Features
                    </p>
                    <h2 class="mt-4 font-display text-[2rem] leading-[1.04] text-white sm:text-[2.5rem] lg:text-[3.1rem]">
                        Built for participation, not just display.
                    </h2>
                </div>

                <p class="max-w-[560px] text-[15px] leading-8 text-[#9e988c]">
                    A more elegant and organized platform for official alumni communication, announcements, event participation, and trusted school-managed updates.
                </p>
            </div>

            <div class="grid gap-10 md:grid-cols-2 xl:grid-cols-4">
                <div>
                    <p class="text-[11px] font-semibold uppercase tracking-[0.30em] text-[#c6a56b]">01</p>
                    <h3 class="mt-4 text-lg font-semibold text-white">Official Announcements</h3>
                    <p class="mt-3 text-sm leading-7 text-[#9e988c]">
                        Publish trusted school and alumni updates in one clear communication channel.
                    </p>
                </div>

                <div>
                    <p class="text-[11px] font-semibold uppercase tracking-[0.30em] text-[#c6a56b]">02</p>
                    <h3 class="mt-4 text-lg font-semibold text-white">Event Registration</h3>
                    <p class="mt-3 text-sm leading-7 text-[#9e988c]">
                        Support reunions, homecomings, and alumni participation with a smoother flow.
                    </p>
                </div>

                <div>
                    <p class="text-[11px] font-semibold uppercase tracking-[0.30em] text-[#c6a56b]">03</p>
                    <h3 class="mt-4 text-lg font-semibold text-white">Admin Verification</h3>
                    <p class="mt-3 text-sm leading-7 text-[#9e988c]">
                        Give organizers and administrators a more reliable workflow for reviewing submissions.
                    </p>
                </div>
            </div>
        </div>
    </section>

    {{-- EVENTS --}}
    <section id="events" class="bg-[#111315] py-20 lg:py-28">
        <div class="mx-auto max-w-[1320px] px-5 md:px-6 lg:px-8">
            <div class="mb-10 flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
                <div>
                    <p class="mb-3 text-[11px] font-semibold uppercase tracking-[0.30em] text-[#c6a56b]">
                        Upcoming Events
                    </p>
                    <h2 class="font-display text-[2rem] leading-[1.04] text-white sm:text-[2.5rem]">
                        School & alumni gatherings
                    </h2>
                </div>

                <a href="{{ route('events.index') }}"
                   class="text-sm font-medium text-[#d6d0c4] transition hover:text-white">
                    View all events
                </a>
            </div>

            @if ($events->isNotEmpty())
                <div class="grid gap-10 md:grid-cols-2 xl:grid-cols-3">
                    @foreach ($events as $event)
                        <article class="group">
                            <div class="overflow-hidden bg-[#17191c]">
                                <img
                                    src="{{ asset('images/100yearsevent.jpg') }}"
                                    alt="{{ $event->title }}"
                                    class="h-[320px] w-full object-cover transition duration-700 group-hover:scale-105"
                                >
                            </div>

                            <div class="pt-5">
                                <p class="text-[11px] font-semibold uppercase tracking-[0.28em] text-[#c6a56b]">
                                    {{ \Carbon\Carbon::parse($event->event_date)->format('F d, Y') }}
                                    @if ($event->schedules->first()?->schedule_time)
                                        · {{ \Carbon\Carbon::parse($event->schedules->first()->schedule_time)->format('g:i A') }}
                                    @endif
                                </p>

                                <h3 class="mt-3 font-display text-[1.8rem] leading-[1.18] text-white transition group-hover:text-[#c6a56b]">
                                    <a href="{{ route('events.show', $event) }}">
                                        {{ $event->title }}
                                    </a>
                                </h3>

                                @if ($event->venue)
                                    <p class="mt-3 text-sm text-[#d6d0c4]">
                                        {{ $event->venue }}
                                    </p>
                                @endif

                                @if ($event->dress_code)
                                    <p class="mt-1 text-sm text-[#9e988c]">
                                        Dress Code: {{ $event->dress_code }}
                                    </p>
                                @endif

                                <p class="mt-4 text-sm leading-7 text-[#9e988c]">
                                    {{ \Illuminate\Support\Str::limit($event->description, 150) }}
                                </p>

                                <div class="mt-6">
                                    <a
                                        href="{{ route('events.show', $event) }}"
                                        class="inline-flex border-b border-[#c6a56b] pb-1 text-sm font-medium uppercase tracking-[0.18em] text-[#c6a56b] transition hover:text-[#d8b67a]"
                                    >
                                        Read more
                                    </a>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
            @else
                <div class="border border-white/10 bg-[#17191c] p-8">
                    <p class="text-sm uppercase tracking-[0.24em] text-[#c6a56b]">Events</p>
                    <h3 class="mt-4 font-display text-[1.8rem] text-white">No upcoming event yet</h3>
                    <p class="mt-3 max-w-xl text-sm leading-7 text-[#9e988c]">
                        Please check back soon for the next scheduled school or alumni event.
                    </p>
                </div>
            @endif
        </div>
    </section>

    {{-- ANNOUNCEMENTS --}}
    <section id="announcements" class="bg-[#0b0b0c] py-20 lg:py-28">
        <div class="mx-auto max-w-[1320px] px-5 md:px-6 lg:px-8">
            <div class="mb-10 flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
                <div>
                    <p class="mb-3 text-[11px] font-semibold uppercase tracking-[0.30em] text-[#c6a56b]">
                        Announcements
                    </p>
                    <h2 class="font-display text-[2rem] leading-[1.04] text-white sm:text-[2.5rem]">
                        Important notices & updates
                    </h2>
                </div>
            </div>

            <div class="grid gap-8 md:grid-cols-2 xl:grid-cols-3">
                @forelse ($announcements as $announcement)
                    <article class="border-t border-white/15 pt-5">
                        <div class="mb-4 flex flex-wrap items-center gap-2">
                            <span class="inline-flex border border-[#c6a56b]/30 px-3 py-1 text-[10px] font-semibold uppercase tracking-[0.18em] text-[#c6a56b]">
                                Announcement
                            </span>

                            @if ($announcement->pinned)
                                <span class="inline-flex border border-amber-400/30 px-3 py-1 text-[10px] font-semibold uppercase tracking-[0.18em] text-amber-300">
                                    Pinned
                                </span>
                            @endif
                        </div>

                        <h3 class="text-[1.08rem] font-semibold leading-[1.45] text-white">
                            {{ $announcement->title }}
                        </h3>

                        <p class="mt-4 text-sm leading-7 text-[#9e988c]">
                            {{ \Illuminate\Support\Str::limit(strip_tags($announcement->content), 190) }}
                        </p>

                        <div class="mt-5 text-[12px] text-[#d6d0c4]">
                            @if ($announcement->published_at)
                                {{ $announcement->published_at->format('F d, Y') }}
                            @else
                                Recently published
                            @endif
                        </div>
                    </article>
                @empty
                    <div class="border border-white/10 bg-[#17191c] p-8 text-sm text-[#9e988c]">
                        No announcements available right now.
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    {{-- FINAL CTA --}}
    <section class="bg-[#111315] py-20 lg:py-28">
        <div class="mx-auto max-w-[1320px] px-5 md:px-6 lg:px-8">
            <div class="grid gap-10 lg:grid-cols-[1.2fr_.8fr] lg:items-center">
                <div>
                    <p class="text-[11px] font-semibold uppercase tracking-[0.30em] text-[#c6a56b]">
                        Join the HSST Network
                    </p>
                    <h2 class="mt-4 font-display text-[2rem] leading-[1.05] text-white sm:text-[2.5rem] lg:text-[3rem]">
                        Ready to reconnect with the HSST community?
                    </h2>
                    <p class="mt-5 max-w-2xl text-[15px] leading-8 text-[#d6d0c4]">
                        Create your account to receive updates, participate in alumni activities, and stay connected through one secure school-managed platform.
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
    </section>

    {{-- FOOTER --}}
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
                    <a href="#homecoming" class="block text-sm text-[#d6d0c4] transition hover:text-white">Home</a>
                    <a href="#features" class="block text-sm text-[#d6d0c4] transition hover:text-white">Features</a>
                    <a href="#events" class="block text-sm text-[#d6d0c4] transition hover:text-white">Events</a>
                    <a href="#announcements" class="block text-sm text-[#d6d0c4] transition hover:text-white">Announcements</a>
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