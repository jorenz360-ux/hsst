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

        .hamburger-line { transition: all .22s ease; }
        .hamburger-open .line-1 { transform: translateY(6px) rotate(45deg); }
        .hamburger-open .line-2 { opacity: 0; }
        .hamburger-open .line-3 { transform: translateY(-6px) rotate(-45deg); }

        .glass-panel {
            backdrop-filter: blur(18px);
            -webkit-backdrop-filter: blur(18px);
        }

        .royal-ring {
            box-shadow: 0 0 0 1px rgba(59, 130, 246, 0.16), 0 20px 50px rgba(2, 6, 23, 0.38);
        }

        .blue-glow {
            box-shadow: 0 18px 40px rgba(37, 99, 235, 0.18);
        }
    </style>
</head>
<body class="overflow-x-hidden bg-[#020617] font-body text-white antialiased">
<div x-data="{ mobileOpen:false }">

    {{-- HEADER --}}
    <header class="fixed inset-x-0 top-0 z-50 border-b border-white/10 bg-[#020817]/78 glass-panel">
        <div class="mx-auto flex h-[82px] max-w-[1320px] items-center justify-between px-5 md:px-6 lg:px-8">
            <a href="{{ route('home') }}" class="flex min-w-0 items-center gap-3">
                <div class="flex h-12 w-12 shrink-0 items-center justify-center overflow-hidden rounded-2xl border border-white/10 bg-white/95 p-1 shadow-lg">
                    <img
                        src="{{ asset('images/hsstlogo.jpg') }}"
                        alt="HSST Logo"
                        class="h-full w-full rounded-xl object-contain"
                    >
                </div>

                <div class="min-w-0">
                    <p class="text-[10px] font-semibold uppercase tracking-[0.24em] text-blue-300">
                        Official Alumni Portal
                    </p>
                    <p class="truncate text-[15px] font-semibold text-white">
                        Holy Spirit School of Tagbilaran
                    </p>
                </div>
            </a>

            <nav class="hidden items-center gap-1 lg:flex">
                <a href="#homecoming" class="rounded-xl px-4 py-2 text-sm text-slate-300 transition hover:bg-white/5 hover:text-white">Home</a>
                <a href="#events" class="rounded-xl px-4 py-2 text-sm text-slate-300 transition hover:bg-white/5 hover:text-white">Events</a>
                <a href="#announcements" class="rounded-xl px-4 py-2 text-sm text-slate-300 transition hover:bg-white/5 hover:text-white">Announcements</a>
                <a href="#contact" class="rounded-xl px-4 py-2 text-sm text-slate-300 transition hover:bg-white/5 hover:text-white">Contact</a>
            </nav>

            <div class="hidden items-center gap-2 lg:flex">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="rounded-xl bg-[#2563eb] px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-[#1d4ed8] blue-glow">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="rounded-xl border border-white/12 bg-white/[0.03] px-4 py-2.5 text-sm font-medium text-white transition hover:bg-white/8">
                            Log in
                        </a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="rounded-xl bg-[#2563eb] px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-[#1d4ed8] blue-glow">
                                Register
                            </a>
                        @endif
                    @endauth
                @endif
            </div>

            <button
                @click="mobileOpen = !mobileOpen"
                :class="mobileOpen ? 'hamburger-open' : ''"
                class="flex flex-col gap-[4.5px] rounded-xl border border-white/10 bg-white/[0.04] p-[10px_11px] shadow-sm lg:hidden"
                aria-label="Menu"
            >
                <span class="hamburger-line line-1 block h-[1.5px] w-[18px] rounded bg-white"></span>
                <span class="hamburger-line line-2 block h-[1.5px] w-[18px] rounded bg-white"></span>
                <span class="hamburger-line line-3 block h-[1.5px] w-[18px] rounded bg-white"></span>
            </button>
        </div>
    </header>

    {{-- MOBILE NAV --}}
    <div
        x-cloak
        x-show="mobileOpen"
        x-transition.opacity.duration.200ms
        class="fixed inset-x-0 top-[82px] z-40 border-t border-white/10 bg-[#07101f]/95 px-5 py-5 glass-panel lg:hidden"
    >
        <div class="flex flex-col gap-1">
            <a @click="mobileOpen=false" href="#homecoming" class="rounded-xl px-4 py-3 text-sm text-slate-200 hover:bg-white/5 hover:text-white">Home</a>
            <a @click="mobileOpen=false" href="#events" class="rounded-xl px-4 py-3 text-sm text-slate-200 hover:bg-white/5 hover:text-white">Events</a>
            <a @click="mobileOpen=false" href="#announcements" class="rounded-xl px-4 py-3 text-sm text-slate-200 hover:bg-white/5 hover:text-white">Announcements</a>
            <a @click="mobileOpen=false" href="#contact" class="rounded-xl px-4 py-3 text-sm text-slate-200 hover:bg-white/5 hover:text-white">Contact</a>
        </div>

        @if (Route::has('login'))
            <div class="my-4 h-px bg-white/10"></div>

            @auth
                <a href="{{ url('/dashboard') }}" class="block rounded-xl bg-[#2563eb] px-4 py-3 text-center text-sm font-semibold text-white">
                    Dashboard
                </a>
            @else
                <a href="{{ route('login') }}" class="block rounded-xl border border-white/12 bg-white/[0.03] px-4 py-3 text-center text-sm font-medium text-white">
                    Log in
                </a>

                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="mt-2 block rounded-xl bg-[#2563eb] px-4 py-3 text-center text-sm font-semibold text-white">
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

        <div class="absolute inset-0 bg-[#020617]/78"></div>
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,rgba(37,99,235,0.35),transparent_30%),linear-gradient(110deg,rgba(2,6,23,0.95)_12%,rgba(15,23,42,0.84)_42%,rgba(29,78,216,0.18)_100%)]"></div>
        <div class="absolute inset-0 bg-gradient-to-b from-transparent via-[#020617]/20 to-[#020617]"></div>

        <div class="relative z-10 mx-auto flex min-h-[95vh] max-w-[1320px] items-center px-5 pt-24 md:px-6 lg:px-8">
            <div class="max-w-3xl">
                <p class="text-[11px] font-semibold uppercase tracking-[0.34em] text-blue-300">
                    Holy Spirit School of Tagbilaran
                </p>

                <h1 class="mt-5 font-display text-[3rem] leading-[0.94] tracking-[-0.03em] text-white sm:text-[4rem] lg:text-[5.7rem]">
                    Come home to
                    <br>
                    legacy,
                    <br>
                    belonging, and pride.
                </h1>

                <p class="mt-6 max-w-2xl text-[15px] leading-8 text-slate-300 sm:text-[17px]">
                    Stay connected through official announcements, alumni gatherings, and school celebrations in one refined digital home for every HSSTian.
                </p>

                <div class="mt-10 flex flex-col gap-4 sm:flex-row">
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="inline-flex items-center justify-center rounded-xl bg-[#2563eb] px-7 py-4 text-sm font-semibold uppercase tracking-[0.18em] text-white transition hover:bg-[#1d4ed8] blue-glow">
                            Join the Alumni Network
                        </a>
                    @endif

                    <a href="#events" class="inline-flex items-center justify-center rounded-xl border border-white/15 bg-white/[0.03] px-7 py-4 text-sm font-medium uppercase tracking-[0.18em] text-white transition hover:bg-white/8">
                        Explore Events
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- HOMECOMING --}}
    <section id="homecoming" class="relative bg-[#020617] py-20 lg:py-28">
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_left,rgba(37,99,235,0.10),transparent_30%)]"></div>

        <div class="relative w-full px-5 md:px-8 lg:px-12 xl:px-16">
            <div class="max-w-5xl">
                <p class="text-[11px] font-semibold uppercase tracking-[0.28em] text-blue-400">
                    Grand Alumni Homecoming
                </p>

                <h2 class="mt-5 font-display text-[2.3rem] leading-[1.03] text-white sm:text-[3rem] lg:text-[3.9rem]">
                    Whether you studied in 1926 or graduated in 2026, you remain part of the HSST family.
                </h2>

                <p class="mt-6 max-w-3xl text-[15px] leading-8 text-slate-300">
                    The HSST Alumni Homecoming celebrates shared history, friendship, and return. It brings generations of graduates together to reconnect, revisit campus memories, and renew a lifelong bond with the school.
                </p>
            </div>

            <div class="mt-14 grid gap-6 border-t border-white/10 pt-10 sm:grid-cols-2">
                <div class="royal-ring rounded-[26px] border border-white/10 bg-white/[0.03] p-6">
                    <p class="text-[11px] font-semibold uppercase tracking-[0.22em] text-blue-400">
                        What to expect
                    </p>
                    <h3 class="mt-3 text-lg font-semibold text-white">
                        A more welcoming alumni experience
                    </h3>
                    <p class="mt-4 text-sm leading-7 text-slate-300">
                        Reunion moments, featured gatherings, school updates, and a smoother registration experience thoughtfully designed for returning alumni.
                    </p>
                </div>

                <div class="royal-ring rounded-[26px] border border-white/10 bg-[#0f172a] p-6">
                    <p class="text-[11px] font-semibold uppercase tracking-[0.22em] text-blue-400">
                        Why it matters
                    </p>
                    <h3 class="mt-3 text-lg font-semibold text-white">
                        A stronger connection across generations
                    </h3>
                    <p class="mt-4 text-sm leading-7 text-slate-300">
                        It strengthens the alumni-school bond and gives every HSSTian one trusted place to stay informed, involved, and welcomed back home.
                    </p>
                </div>
            </div>
        </div>
    </section>

    {{-- EVENTS --}}
    <section id="events" class="relative bg-[#071120] py-20 lg:py-28">
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,rgba(37,99,235,0.11),transparent_28%)]"></div>

        <div class="relative mx-auto max-w-[1320px] px-5 md:px-6 lg:px-8">
            <div class="mb-10 flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
                <div>
                    <p class="mb-3 text-[11px] font-semibold uppercase tracking-[0.30em] text-blue-400">
                        Upcoming Events
                    </p>
                    <h2 class="font-display text-[2rem] leading-[1.04] text-white sm:text-[2.5rem]">
                        Alumni News and Events
                    </h2>
                </div>

                <a href="{{ route('events.index') }}"
                   class="text-sm font-semibold uppercase tracking-[0.12em] text-blue-400 transition hover:text-blue-300">
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

                        <article class="group overflow-hidden rounded-[28px] border border-white/10 bg-[#0f172a]/95 shadow-[0_10px_35px_rgba(2,6,23,0.35)] transition duration-300 hover:-translate-y-1 hover:border-blue-500/40 hover:shadow-[0_22px_60px_rgba(37,99,235,0.12)]">
                            <div class="relative overflow-hidden">
                                <img
                                    src="{{ $bannerUrl }}"
                                    alt="{{ $event->title }}"
                                    class="h-[280px] w-full object-cover transition duration-700 group-hover:scale-105"
                                >
                                <div class="absolute inset-0 bg-gradient-to-t from-[#020617]/80 via-[#020617]/15 to-transparent"></div>
                                <div class="absolute left-5 top-5">
                                    <span class="inline-flex rounded-full border border-blue-400/20 bg-[#2563eb]/20 px-3 py-1 text-[10px] font-semibold uppercase tracking-[0.18em] text-blue-200">
                                        Upcoming
                                    </span>
                                </div>
                            </div>

                            <div class="p-6">
                                <p class="text-[11px] font-semibold uppercase tracking-[0.28em] text-blue-400">
                                    {{ \Carbon\Carbon::parse($event->event_date)->format('F d, Y') }}
                                    @if ($event->schedules->first()?->schedule_time)
                                        · {{ \Carbon\Carbon::parse($event->schedules->first()->schedule_time)->format('g:i A') }}
                                    @endif
                                </p>

                                <h3 class="mt-3 font-display text-[1.7rem] leading-[1.16] text-white transition group-hover:text-blue-300">
                                    <a href="{{ route('events.show', ['event' => $event->slug]) }}">
                                        {{ $event->title }}
                                    </a>
                                </h3>

                                @if ($event->venue)
                                    <p class="mt-3 text-sm font-medium text-slate-200">
                                        {{ $event->venue }}
                                    </p>
                                @endif

                                @if ($event->dress_code)
                                    <p class="mt-1 text-sm text-slate-400">
                                        Dress Code: {{ $event->dress_code }}
                                    </p>
                                @endif

                                <p class="mt-4 text-sm leading-7 text-slate-300">
                                    {{ \Illuminate\Support\Str::limit($event->description, 150) }}
                                </p>

                                <div class="mt-6">
                                    <a
                                        href="{{ route('events.show', $event) }}"
                                        class="inline-flex items-center gap-2 text-sm font-semibold uppercase tracking-[0.14em] text-blue-400 transition hover:text-blue-300"
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
                <div class="rounded-[28px] border border-white/10 bg-[#0f172a] p-8 shadow-[0_10px_35px_rgba(2,6,23,0.28)]">
                    <p class="text-sm font-semibold uppercase tracking-[0.24em] text-blue-400">Events</p>
                    <h3 class="mt-4 font-display text-[1.8rem] text-white">No upcoming event yet</h3>
                    <p class="mt-3 max-w-xl text-sm leading-7 text-slate-300">
                        Please check back soon for the next scheduled school or alumni event.
                    </p>
                </div>
            @endif
        </div>
    </section>

    {{-- ANNOUNCEMENTS --}}
    <section id="announcements" class="relative bg-[#020617] py-20 lg:py-28">
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_bottom_left,rgba(37,99,235,0.10),transparent_28%)]"></div>

        <div class="relative mx-auto max-w-[1320px] px-5 md:px-6 lg:px-8">
            <div class="mb-10">
                <p class="mb-3 text-[11px] font-semibold uppercase tracking-[0.30em] text-blue-400">
                    Announcements
                </p>
                <h2 class="font-display text-[2rem] leading-[1.04] text-white sm:text-[2.5rem]">
                    Important notices & updates
                </h2>
            </div>

            <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
                @forelse ($announcements as $announcement)
                    <article class="rounded-[28px] border border-white/10 bg-white/[0.03] p-6 shadow-[0_10px_30px_rgba(2,6,23,0.22)] transition hover:border-blue-500/30 hover:bg-white/[0.04]">
                        <div class="mb-4 flex flex-wrap items-center gap-2">
                            <span class="inline-flex rounded-full border border-blue-400/20 bg-[#2563eb]/15 px-3 py-1 text-[10px] font-semibold uppercase tracking-[0.18em] text-blue-200">
                                Announcement
                            </span>

                            @if ($announcement->pinned)
                                <span class="inline-flex rounded-full bg-[#2563eb] px-3 py-1 text-[10px] font-semibold uppercase tracking-[0.18em] text-white">
                                    Pinned
                                </span>
                            @endif
                        </div>

                        <h3 class="text-[1.08rem] font-semibold leading-[1.45] text-white">
                            {{ $announcement->title }}
                        </h3>

                        <p class="mt-4 text-sm leading-7 text-slate-300">
                            {{ \Illuminate\Support\Str::limit(strip_tags($announcement->content), 190) }}
                        </p>

                        <div class="mt-5 text-[12px] font-medium text-slate-400">
                            @if ($announcement->published_at)
                                {{ $announcement->published_at->format('F d, Y') }}
                            @else
                                Recently published
                            @endif
                        </div>
                    </article>
                @empty
                    <div class="rounded-[28px] border border-white/10 bg-white/[0.03] p-8 text-sm text-slate-300">
                        No announcements available right now.
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    {{-- FINAL CTA --}}
    <section class="relative overflow-hidden bg-[#0b1220] py-20 lg:py-28">
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,rgba(37,99,235,0.18),transparent_30%)]"></div>

        <div class="relative mx-auto max-w-[1320px] px-5 md:px-6 lg:px-8">
            <div class="rounded-[34px] border border-white/10 bg-[linear-gradient(135deg,rgba(15,23,42,0.92),rgba(29,78,216,0.42))] p-8 shadow-[0_18px_60px_rgba(2,6,23,0.35)] lg:p-12">
                <div class="grid gap-10 lg:grid-cols-[1.2fr_.8fr] lg:items-center">
                    <div>
                        <p class="text-[11px] font-semibold uppercase tracking-[0.30em] text-blue-300">
                            Join the HSST Network
                        </p>
                        <h2 class="mt-4 font-display text-[2rem] leading-[1.05] text-white sm:text-[2.5rem] lg:text-[3rem]">
                            Ready to reconnect with the HSST community?
                        </h2>
                        <p class="mt-5 max-w-2xl text-[15px] leading-8 text-slate-200/95">
                            Create your account to receive updates, participate in alumni activities, and stay connected through one secure school-managed platform.
                        </p>
                    </div>

                    <div class="flex flex-col gap-3">
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="block rounded-xl bg-white px-6 py-4 text-center text-sm font-semibold uppercase tracking-[0.16em] text-blue-800 transition hover:bg-blue-50">
                                Create Account
                            </a>
                        @endif

                        @if (Route::has('login'))
                            <a href="{{ route('login') }}" class="block rounded-xl border border-white/15 bg-white/[0.04] px-6 py-4 text-center text-sm font-medium text-white transition hover:bg-white/10">
                                Log in to Existing Account
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- FOOTER --}}
    <footer id="contact" class="border-t border-white/10 bg-[#020617]">
        <div class="mx-auto grid max-w-[1320px] gap-10 px-5 py-12 md:px-6 lg:grid-cols-[1.3fr_.8fr_.8fr] lg:px-8 lg:py-16">
            <div>
                <a href="{{ route('home') }}" class="flex items-center gap-3">
                    <div class="flex h-11 w-11 shrink-0 items-center justify-center overflow-hidden rounded-2xl border border-white/10 bg-white/95 p-1 shadow-sm">
                        <img
                            src="{{ asset('images/hsstlogo.jpg') }}"
                            alt="HSST Logo"
                            class="h-full w-full rounded-xl object-contain"
                        >
                    </div>

                    <div>
                        <p class="text-[10px] font-semibold uppercase tracking-[0.24em] text-blue-300">
                            Official Alumni Portal
                        </p>
                        <p class="text-[15px] font-semibold text-white">
                            Holy Spirit School of Tagbilaran
                        </p>
                    </div>
                </a>

                <p class="mt-5 max-w-[390px] text-sm leading-7 text-slate-300">
                    A digital home for official announcements, alumni events, school celebrations, and a stronger connection between HSST and its graduates.
                </p>

                <p class="mt-4 text-sm text-slate-400">
                    Managed by HSST Administration &amp; Alumni Office
                </p>
            </div>

            <div>
                <p class="mb-4 text-[11px] font-semibold uppercase tracking-[0.22em] text-slate-400">Quick Links</p>
                <div class="space-y-3">
                    <a href="#homecoming" class="block text-sm text-slate-300 transition hover:text-blue-300">Home</a>
                    <a href="#events" class="block text-sm text-slate-300 transition hover:text-blue-300">Events</a>
                    <a href="#announcements" class="block text-sm text-slate-300 transition hover:text-blue-300">Announcements</a>
                </div>
            </div>

            <div>
                <p class="mb-4 text-[11px] font-semibold uppercase tracking-[0.22em] text-slate-400">Account</p>
                <div class="space-y-3">
                    @if (Route::has('login'))
                        <a href="{{ route('login') }}" class="block text-sm text-slate-300 transition hover:text-blue-300">Log in</a>
                    @endif

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="block text-sm text-slate-300 transition hover:text-blue-300">Register</a>
                    @endif

                    <a href="{{ url('/dashboard') }}" class="block text-sm text-slate-300 transition hover:text-blue-300">Dashboard</a>
                </div>
            </div>
        </div>

        <div class="mx-auto flex max-w-[1320px] flex-col gap-2 border-t border-white/10 px-5 py-5 text-sm text-slate-400 md:flex-row md:items-center md:justify-between md:px-6 lg:px-8">
            <p>© 2026 Holy Spirit School of Tagbilaran. All rights reserved.</p>
            <p>Truth in Love · Faith · Learning · Community</p>
        </div>
    </footer>
</div>
</body>
</html>