<!DOCTYPE html>
<html lang="en" class="scroll-smooth dark">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>HSST Events | Holy Spirit School of Tagbilaran</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        [x-cloak] { display: none !important; }

        .font-body { font-family: "Inter", system-ui, sans-serif; }
        .font-display { font-family: "DM Serif Display", Georgia, serif; }

        .hamburger-line { transition: all .22s ease; }
        .hamburger-open .line-1 { transform: translateY(6px) rotate(45deg); }
        .hamburger-open .line-2 { opacity: 0; }
        .hamburger-open .line-3 { transform: translateY(-6px) rotate(-45deg); }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(18px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes floatSoft {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-8px); }
        }

        .animate-fade-up {
            animation: fadeUp .6s cubic-bezier(.22,1,.36,1) both;
        }

        .animate-float-soft {
            animation: floatSoft 5s ease-in-out infinite;
        }

        .delay-1 { animation-delay: .08s; }
        .delay-2 { animation-delay: .16s; }
        .delay-3 { animation-delay: .24s; }
        .delay-4 { animation-delay: .32s; }

        .glass-panel {
            backdrop-filter: blur(18px);
            -webkit-backdrop-filter: blur(18px);
        }
    </style>
</head>
<body
    class="overflow-x-hidden bg-[#050816] font-body text-slate-100 antialiased selection:bg-indigo-400/30 selection:text-white [background:
    radial-gradient(circle_at_top_left,rgba(99,102,241,0.18),transparent_28%),
    radial-gradient(circle_at_top_right,rgba(16,185,129,0.10),transparent_24%),
    radial-gradient(circle_at_bottom_right,rgba(245,158,11,0.08),transparent_18%),
    linear-gradient(180deg,#050816_0%,#070b18_32%,#090d1f_62%,#050816_100%)] [background-attachment:fixed]"
>
<div x-data="{ mobileOpen:false }" class="min-h-screen">

    <!-- HEADER -->
    <header class="sticky top-0 z-50 border-b border-white/10 bg-[#050816]/80 glass-panel">
        <div class="mx-auto max-w-[1320px] px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between py-4">
                <a href="{{ route('home') }}" class="flex items-center gap-4">
                    <div class="flex h-12 w-12 shrink-0 items-center justify-center overflow-hidden rounded-2xl border border-white/10 bg-white p-1 shadow-[0_14px_36px_rgba(0,0,0,0.28)] sm:h-14 sm:w-14">
                        <img
                            src="{{ asset('images/hsstlogo.jpg') }}"
                            alt="Holy Spirit School of Tagbilaran Logo"
                            class="h-full w-full rounded-xl object-contain"
                        >
                    </div>

                    <div class="hidden h-10 w-px bg-white/10 sm:block"></div>

                    <div class="min-w-0 leading-tight">
                        <p class="text-[10px] font-semibold uppercase tracking-[0.24em] text-emerald-300 sm:text-[11px]">
                            Official Alumni Portal
                        </p>
                        <h1 class="truncate text-sm font-bold text-white sm:text-base lg:text-lg">
                            Holy Spirit School of Tagbilaran
                        </h1>
                        <p class="hidden text-xs text-slate-400 md:block">
                            Truth in Love · Faith · Learning · Community
                        </p>
                    </div>
                </a>

                <nav class="hidden items-center gap-1 lg:flex">
                    <a href="{{ route('home') }}" class="rounded-xl px-4 py-2 text-sm font-medium text-slate-300 transition hover:bg-white/5 hover:text-white">
                        Home
                    </a>
                    <a href="{{ route('about-us') }}" class="rounded-xl px-4 py-2 text-sm font-medium text-slate-300 transition hover:bg-white/5 hover:text-white">
                        About
                    </a>
                    <a href="{{ route('events.index') }}" class="rounded-xl bg-white/5 px-4 py-2 text-sm font-medium text-white">
                        Events
                    </a>
                    <a href="#upcoming-events" class="rounded-xl px-4 py-2 text-sm font-medium text-slate-300 transition hover:bg-white/5 hover:text-white">
                        Upcoming
                    </a>
                    <a href="#contact" class="rounded-xl px-4 py-2 text-sm font-medium text-slate-300 transition hover:bg-white/5 hover:text-white">
                        Contact
                    </a>
                </nav>

                <div class="hidden items-center gap-2 lg:flex">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="rounded-2xl bg-indigo-500 px-5 py-2.5 text-sm font-semibold text-white shadow-[0_16px_34px_rgba(99,102,241,0.28)] transition hover:-translate-y-0.5 hover:bg-indigo-400">
                                Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="rounded-2xl border border-white/10 bg-white/5 px-5 py-2.5 text-sm font-medium text-slate-200 transition hover:bg-white/10">
                                Log in
                            </a>

                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="rounded-2xl bg-indigo-500 px-5 py-2.5 text-sm font-semibold text-white shadow-[0_16px_34px_rgba(99,102,241,0.28)] transition hover:-translate-y-0.5 hover:bg-indigo-400">
                                    Register
                                </a>
                            @endif
                        @endauth
                    @endif
                </div>

                <button
                    @click="mobileOpen = !mobileOpen"
                    :class="mobileOpen ? 'hamburger-open' : ''"
                    class="flex flex-col gap-[4.5px] rounded-xl border border-white/12 bg-white/5 p-[9px_10px] lg:hidden"
                    aria-label="Toggle Menu"
                >
                    <span class="hamburger-line line-1 block h-[1.5px] w-[18px] rounded bg-slate-300"></span>
                    <span class="hamburger-line line-2 block h-[1.5px] w-[18px] rounded bg-slate-300"></span>
                    <span class="hamburger-line line-3 block h-[1.5px] w-[18px] rounded bg-slate-300"></span>
                </button>
            </div>

            <!-- MOBILE MENU -->
            <div
                x-cloak
                x-show="mobileOpen"
                x-transition.opacity.duration.200ms
                class="border-t border-white/10 py-4 lg:hidden"
            >
                <div class="flex flex-col gap-1 text-sm text-slate-200">
                    <a @click="mobileOpen=false" href="{{ route('home') }}" class="rounded-xl px-4 py-3 hover:bg-white/5">
                        Home
                    </a>
                    <a @click="mobileOpen=false" href="{{ route('about-us') }}" class="rounded-xl px-4 py-3 hover:bg-white/5">
                        About
                    </a>
                    <a @click="mobileOpen=false" href="{{ route('events.index') }}" class="rounded-xl px-4 py-3 hover:bg-white/5">
                        Events
                    </a>
                    <a @click="mobileOpen=false" href="#upcoming-events" class="rounded-xl px-4 py-3 hover:bg-white/5">
                        Upcoming
                    </a>
                    <a @click="mobileOpen=false" href="#contact" class="rounded-xl px-4 py-3 hover:bg-white/5">
                        Contact
                    </a>

                    @if (Route::has('login'))
                        <div class="mt-4 border-t border-white/10 pt-4">
                            @auth
                                <a href="{{ url('/dashboard') }}" class="block rounded-2xl bg-indigo-500 px-4 py-3 text-center text-sm font-semibold text-white">
                                    Dashboard
                                </a>
                            @else
                                <div class="flex flex-col gap-3">
                                    <a href="{{ route('login') }}" class="block rounded-2xl border border-white/12 bg-white/5 px-4 py-3 text-center text-sm font-medium text-slate-200">
                                        Log in
                                    </a>
                                    @if (Route::has('register'))
                                        <a href="{{ route('register') }}" class="block rounded-2xl bg-indigo-500 px-4 py-3 text-center text-sm font-semibold text-white">
                                            Register
                                        </a>
                                    @endif
                                </div>
                            @endauth
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </header>

    <!-- HERO -->
    <section class="relative isolate overflow-hidden">
        <div class="absolute inset-0 -z-20 bg-[linear-gradient(180deg,rgba(5,8,22,0.35)_0%,rgba(5,8,22,0.82)_56%,rgba(5,8,22,1)_100%)]"></div>
        <div class="absolute -left-24 top-24 -z-10 h-72 w-72 rounded-full bg-indigo-500/20 blur-3xl"></div>
        <div class="absolute right-0 top-1/3 -z-10 h-80 w-80 rounded-full bg-emerald-400/10 blur-3xl"></div>

        <div class="mx-auto max-w-[1320px] px-5 py-16 md:px-6 lg:px-8 lg:py-20">
            <div class="grid items-center gap-12 lg:grid-cols-[1.08fr_.92fr]">
                <div class="max-w-3xl">
                    <div class="animate-fade-up delay-1 mb-5 inline-flex items-center gap-2 rounded-full border border-indigo-400/20 bg-indigo-400/10 px-4 py-1.5 text-[11px] font-semibold uppercase tracking-[0.20em] text-indigo-100">
                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-400"></span>
                        Alumni Gatherings · School Celebrations · Community Events
                    </div>

                    <h1 class="animate-fade-up delay-2 font-display text-[2.8rem] leading-[0.96] tracking-[-0.035em] text-white sm:text-[3.5rem] md:text-[4.2rem] lg:text-[5rem]">
                        Discover what’s
                        <span class="bg-gradient-to-r from-white via-indigo-100 to-emerald-100 bg-clip-text text-transparent italic">
                            happening next
                        </span>
                        at HSST
                    </h1>

                    <p class="animate-fade-up delay-3 mt-6 max-w-2xl text-[15.5px] leading-8 text-slate-300 sm:text-[16.5px]">
                        Explore upcoming HSST events, alumni homecoming activities, reunions, and school celebrations. Stay informed, register with ease, and reconnect through one official platform.
                    </p>

                    <div class="animate-fade-up delay-4 mt-8 flex flex-col items-start gap-3 sm:flex-row sm:flex-wrap">
                        <a href="#upcoming-events" class="rounded-2xl bg-indigo-500 px-7 py-3.5 text-sm font-semibold text-white shadow-[0_20px_44px_rgba(99,102,241,0.30)] transition hover:-translate-y-0.5 hover:bg-indigo-400">
                            Browse Events
                        </a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="rounded-2xl border border-white/12 bg-white/5 px-7 py-3.5 text-sm font-medium text-white transition hover:bg-white/10">
                                Join the Alumni Network
                            </a>
                        @endif
                    </div>
                </div>

                <div class="animate-fade-up delay-4 lg:justify-self-end">
                    <div class="relative overflow-hidden rounded-[34px] border border-white/10 bg-[linear-gradient(180deg,rgba(15,23,42,0.92)_0%,rgba(10,14,28,0.96)_100%)] shadow-[0_28px_90px_rgba(0,0,0,0.42)]">
                        <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,rgba(99,102,241,0.16),transparent_28%)]"></div>

                        <div class="relative p-6">
                            <div class="mb-5 flex items-center justify-between gap-3">
                                <div>
                                    <p class="text-[11px] font-semibold uppercase tracking-[0.22em] text-indigo-200">Event Highlights</p>
                                    <h3 class="mt-1 text-xl font-semibold tracking-[-0.02em] text-white">Made for alumni connection</h3>
                                </div>

                                <div class="animate-float-soft rounded-2xl border border-white/10 bg-white/5 px-4 py-2 text-sm font-semibold text-white">
                                    HSST
                                </div>
                            </div>

                            <div class="grid gap-4">
                                <div class="rounded-[26px] border border-white/10 bg-white/[0.04] p-5">
                                    <div class="text-[11px] font-semibold uppercase tracking-[0.18em] text-emerald-300">Grand Homecoming</div>
                                    <p class="mt-2 text-sm leading-7 text-slate-300">
                                        Welcome back generations of HSSTians through meaningful reunions and campus-centered celebrations.
                                    </p>
                                </div>

                                <div class="grid gap-4 sm:grid-cols-2">
                                    <div class="rounded-[26px] border border-white/10 bg-white/[0.04] p-5">
                                        <div class="mb-3 inline-flex h-10 w-10 items-center justify-center rounded-2xl bg-indigo-500/15 text-sm font-bold text-indigo-200">
                                            01
                                        </div>
                                        <h4 class="text-sm font-semibold text-white">School Events</h4>
                                        <p class="mt-2 text-sm leading-7 text-slate-400">
                                            Celebrate official programs and community milestones.
                                        </p>
                                    </div>

                                    <div class="rounded-[26px] border border-white/10 bg-white/[0.04] p-5">
                                        <div class="mb-3 inline-flex h-10 w-10 items-center justify-center rounded-2xl bg-amber-400/15 text-sm font-bold text-amber-200">
                                            02
                                        </div>
                                        <h4 class="text-sm font-semibold text-white">Alumni Gatherings</h4>
                                        <p class="mt-2 text-sm leading-7 text-slate-400">
                                            Reconnect with classmates and alumni circles.
                                        </p>
                                    </div>
                                </div>

                                <div class="rounded-[26px] border border-white/10 bg-gradient-to-r from-indigo-500/12 via-white/[0.04] to-emerald-500/10 p-5">
                                    <div class="text-[11px] font-semibold uppercase tracking-[0.18em] text-slate-300">Official access</div>
                                    <p class="mt-2 text-sm leading-7 text-slate-200">
                                        View details, track dates, and enter each event through a consistent and school-managed public experience.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mx-auto max-w-[1320px] px-5 md:px-6 lg:px-8">
            <div class="grid grid-cols-1 gap-3 rounded-[32px] border border-white/10 bg-white/[0.04] p-4 shadow-[0_18px_54px_rgba(0,0,0,0.18)] glass-panel sm:grid-cols-3 sm:p-5">
                <div class="rounded-2xl border border-white/10 bg-[#0d1326]/80 p-5">
                    <div class="text-[11px] font-semibold uppercase tracking-[0.18em] text-slate-400">Purpose</div>
                    <p class="mt-2 text-sm leading-7 text-slate-200">
                        Discover official events, school celebrations, and alumni activities in one organized page.
                    </p>
                </div>

                <div class="rounded-2xl border border-white/10 bg-[#0d1326]/80 p-5">
                    <div class="text-[11px] font-semibold uppercase tracking-[0.18em] text-slate-400">Experience</div>
                    <p class="mt-2 text-sm leading-7 text-slate-200">
                        Enjoy a premium, easy-to-browse event experience consistent with the HSST public portal.
                    </p>
                </div>

                <div class="rounded-2xl border border-white/10 bg-[#0d1326]/80 p-5">
                    <div class="text-[11px] font-semibold uppercase tracking-[0.18em] text-slate-400">Connection</div>
                    <p class="mt-2 text-sm leading-7 text-slate-200">
                        Reconnect with the HSST community through programs designed for belonging and participation.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- EVENTS LIST -->
    <section id="upcoming-events" class="py-16 lg:py-20">
        <div class="mx-auto max-w-[1320px] px-5 md:px-6 lg:px-8">
            <div class="mb-10 flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
                <div>
                    <div class="mb-3 inline-flex items-center gap-2 text-[11px] font-bold uppercase tracking-[0.22em] text-indigo-200 before:h-px before:w-6 before:bg-indigo-400/50 before:content-['']">
                        Upcoming Events
                    </div>
                    <h2 class="font-display text-[2rem] leading-[1.05] tracking-[-0.02em] text-white sm:text-[2.45rem]">
                        All upcoming events and gatherings
                    </h2>
                </div>

                <p class="max-w-[560px] text-[15px] leading-8 text-slate-400">
                    Browse school-managed events, alumni activities, and celebrations prepared for the HSST community.
                </p>
            </div>

            @if ($events->count())
                <div class="grid gap-5 md:grid-cols-2 xl:grid-cols-2">
                    @foreach ($events as $event)
                        <article class="group overflow-hidden rounded-[30px] border border-white/10 bg-white/[0.04] shadow-[0_12px_28px_rgba(0,0,0,0.18)] transition duration-300 hover:-translate-y-1 hover:border-indigo-400/20">
                            <div class="relative h-[240px] overflow-hidden">
                                <img
                                    src="{{ asset('images/100yearsevent.jpg') }}"
                                    alt="{{ $event->title }}"
                                    class="h-full w-full object-cover transition duration-700 group-hover:scale-105"
                                >
                                <div class="absolute inset-0 bg-gradient-to-t from-[#050816]/95 via-[#050816]/20 to-transparent"></div>

                                <div class="absolute left-5 top-5">
                                    <span class="inline-flex rounded-full border border-indigo-400/20 bg-indigo-400/10 px-3 py-1 text-[10px] font-bold uppercase tracking-[0.14em] text-indigo-200">
                                        Upcoming Event
                                    </span>
                                </div>

                                <div class="absolute inset-x-0 bottom-0 p-5">
                                    <h2 class="font-display text-[1.45rem] leading-[1.15] text-white sm:text-[1.6rem]">
                                        <a href="{{ route('events.show', $event) }}" class="transition hover:text-indigo-200">
                                            {{ $event->title }}
                                        </a>
                                    </h2>
                                </div>
                            </div>

                            <div class="p-5 sm:p-6">
                                <p class="text-[13.5px] leading-7 text-slate-400">
                                    {{ \Illuminate\Support\Str::limit($event->description, 170) }}
                                </p>

                                <div class="mt-5 grid gap-3 sm:grid-cols-2">
                                    <div class="rounded-2xl border border-white/10 bg-[#0d1326]/80 p-4">
                                        <div class="text-[10px] font-semibold uppercase tracking-[0.16em] text-slate-500">Date</div>
                                        <div class="mt-2 text-sm font-medium text-white">
                                            {{ \Carbon\Carbon::parse($event->event_date)->format('F d, Y') }}
                                        </div>
                                    </div>

                                    <div class="rounded-2xl border border-white/10 bg-[#0d1326]/80 p-4">
                                        <div class="text-[10px] font-semibold uppercase tracking-[0.16em] text-slate-500">Time</div>
                                        <div class="mt-2 text-sm font-medium text-white">
                                            @if ($event->schedules->first()?->schedule_time)
                                                {{ \Carbon\Carbon::parse($event->schedules->first()->schedule_time)->format('g:i A') }}
                                            @else
                                                To be announced
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-3 rounded-2xl border border-white/10 bg-[#0d1326]/80 p-4">
                                    <div class="text-[10px] font-semibold uppercase tracking-[0.16em] text-slate-500">Venue</div>
                                    <div class="mt-2 text-sm font-medium text-white">
                                        {{ $event->venue ?: 'Venue to be announced' }}
                                    </div>
                                </div>

                                <div class="mt-6 flex flex-col gap-3 sm:flex-row">
                                    <a
                                        href="{{ route('events.show', $event) }}"
                                        class="inline-flex flex-1 items-center justify-center gap-2 rounded-2xl bg-indigo-500 px-5 py-3 text-sm font-semibold text-white transition hover:bg-indigo-400"
                                    >
                                        View event details
                                        <span aria-hidden="true">→</span>
                                    </a>

                                    @if (Route::has('register'))
                                        <a
                                            href="{{ route('register') }}"
                                            class="inline-flex flex-1 items-center justify-center rounded-2xl border border-white/12 bg-white/5 px-5 py-3 text-sm font-medium text-white transition hover:bg-white/10"
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
                <div class="rounded-[32px] border border-white/10 bg-white/[0.04] p-10 text-center shadow-[0_12px_28px_rgba(0,0,0,0.18)]">
                    <div class="mx-auto mb-4 flex h-14 w-14 items-center justify-center rounded-2xl bg-indigo-500/15 text-lg font-bold text-indigo-200">
                        HS
                    </div>
                    <h2 class="font-display text-[1.7rem] text-white">
                        No upcoming events available
                    </h2>
                    <p class="mx-auto mt-3 max-w-xl text-[14px] leading-7 text-slate-400">
                        Please check back soon for newly scheduled school events, alumni celebrations, and upcoming HSST activities.
                    </p>
                </div>
            @endif
        </div>
    </section>

    <!-- CTA -->
    <section class="pb-20">
        <div class="mx-auto max-w-[1320px] px-5 md:px-6 lg:px-8">
            <div class="relative overflow-hidden rounded-[38px] border border-white/10 bg-[linear-gradient(135deg,rgba(79,70,229,0.18),rgba(15,23,42,0.88),rgba(16,185,129,0.10))] p-8 shadow-[0_20px_60px_rgba(0,0,0,0.24)] glass-panel sm:p-10 lg:p-14">
                <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,rgba(255,255,255,0.10),transparent_24%)]"></div>
                <div class="absolute -right-14 -top-14 h-40 w-40 rounded-full bg-indigo-400/20 blur-3xl"></div>
                <div class="absolute -left-10 bottom-0 h-32 w-32 rounded-full bg-emerald-400/10 blur-3xl"></div>

                <div class="relative z-10 grid items-center gap-8 lg:grid-cols-[1.2fr_.8fr]">
                    <div>
                        <div class="mb-3 text-[11px] font-bold uppercase tracking-[0.20em] text-indigo-100/90">
                            Be part of the next HSST gathering
                        </div>

                        <h2 class="font-display text-[2rem] leading-[1.06] tracking-[-0.02em] text-white sm:text-[2.4rem] lg:text-[2.9rem]">
                            Ready to reconnect with the HSST community?
                        </h2>

                        <p class="mt-4 max-w-2xl text-[15px] leading-8 text-slate-200">
                            Create your account to stay updated on alumni events, school programs, and upcoming celebrations through one secure official portal.
                        </p>
                    </div>

                    <div class="flex flex-col gap-3">
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="block rounded-2xl bg-white px-6 py-4 text-center text-sm font-semibold text-[#0b1020] transition hover:-translate-y-0.5 hover:bg-slate-100">
                                Create Account
                            </a>
                        @endif

                        @if (Route::has('login'))
                            <a href="{{ route('login') }}" class="block rounded-2xl border border-white/15 bg-white/5 px-6 py-4 text-center text-sm font-medium text-white transition hover:bg-white/10">
                                Log in to Existing Account
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer id="contact" class="border-t border-white/10 bg-[#040712]">
        <div class="mx-auto grid max-w-[1320px] gap-10 px-4 py-10 sm:px-6 lg:grid-cols-[1.2fr_0.8fr_0.8fr] lg:px-8">
            <div>
                <div class="flex items-center gap-3">
                    <div class="flex h-11 w-11 items-center justify-center overflow-hidden rounded-2xl border border-white/10 bg-white p-1 shadow-sm">
                        <img src="{{ asset('images/hsstlogo.jpg') }}" alt="HSST Logo" class="h-full w-full object-contain">
                    </div>
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.2em] text-emerald-300">Official Alumni Portal</p>
                        <p class="text-base font-bold text-white">Holy Spirit School of Tagbilaran</p>
                    </div>
                </div>

                <p class="mt-5 max-w-md text-sm leading-7 text-slate-400">
                    A digital home for official announcements, school events, alumni activities, and meaningful community connection at Holy Spirit School of Tagbilaran.
                </p>
            </div>

            <div>
                <h4 class="text-sm font-semibold uppercase tracking-[0.2em] text-slate-300">Quick links</h4>
                <div class="mt-4 flex flex-col gap-3 text-sm text-slate-400">
                    <a href="{{ route('home') }}" class="transition hover:text-white">Home</a>
                    <a href="{{ route('about-us') }}" class="transition hover:text-white">About Us</a>
                    <a href="{{ route('events.index') }}" class="transition hover:text-white">Events</a>
                    <a href="#upcoming-events" class="transition hover:text-white">Upcoming</a>
                </div>
            </div>

            <div>
                <h4 class="text-sm font-semibold uppercase tracking-[0.2em] text-slate-300">Account</h4>
                <div class="mt-4 flex flex-col gap-3 text-sm text-slate-400">
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

        <div class="border-t border-white/10">
            <div class="mx-auto flex max-w-[1320px] flex-col gap-3 px-4 py-6 text-sm text-slate-500 sm:px-6 md:flex-row md:items-center md:justify-between lg:px-8">
                <p>© 2026 Holy Spirit School of Tagbilaran. All rights reserved.</p>
                <p>Truth in Love · Faith · Learning · Community</p>
            </div>
        </div>
    </footer>

</div>
</body>
</html>