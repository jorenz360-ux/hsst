<!DOCTYPE html>
<html lang="en" class="scroll-smooth dark">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ $event->title }} | Holy Spirit School of Tagbilaran</title>

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
                    <a href="#event-details" class="rounded-xl px-4 py-2 text-sm font-medium text-slate-300 transition hover:bg-white/5 hover:text-white">
                        Details
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
                    <a @click="mobileOpen=false" href="#event-details" class="rounded-xl px-4 py-3 hover:bg-white/5">
                        Details
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

    <!-- HERO / EVENT HEAD -->
    <section class="relative overflow-hidden py-12 sm:py-14 lg:py-20">
        <div class="absolute inset-0 -z-30">
            <img
                src="{{ asset('images/100yearsevent.jpg') }}"
                alt="{{ $event->title }}"
                class="h-full w-full object-cover object-center opacity-30"
            >
        </div>
        <div class="absolute inset-0 -z-20 bg-[linear-gradient(180deg,rgba(5,8,22,0.48)_0%,rgba(5,8,22,0.80)_50%,rgba(5,8,22,0.98)_100%)]"></div>
        <div class="absolute -left-24 top-24 -z-10 h-72 w-72 rounded-full bg-indigo-500/20 blur-3xl"></div>
        <div class="absolute right-0 top-1/3 -z-10 h-80 w-80 rounded-full bg-emerald-400/10 blur-3xl"></div>

        <div class="mx-auto max-w-[1180px] px-5 md:px-6">
            <a
                href="{{ route('events.index') }}"
                class="animate-fade-up delay-1 mb-8 inline-flex items-center gap-2 rounded-full border border-white/10 bg-white/5 px-4 py-2 text-sm text-slate-300 transition hover:bg-white/10 hover:text-white"
            >
                <span aria-hidden="true">←</span>
                Back to events
            </a>

            <div class="overflow-hidden rounded-[34px] border border-white/10 bg-white/[0.04] shadow-[0_24px_80px_rgba(0,0,0,0.34)] glass-panel">
                <div class="relative h-[300px] sm:h-[380px] lg:h-[460px]">
                    <img
                        src="{{ asset('images/100yearsevent.jpg') }}"
                        alt="{{ $event->title }}"
                        class="h-full w-full object-cover"
                    >
                    <div class="absolute inset-0 bg-gradient-to-t from-[#050816] via-[#050816]/38 to-transparent"></div>

                    <div class="absolute inset-x-0 bottom-0 p-6 sm:p-8 lg:p-10">
                        <div class="animate-fade-up delay-2 inline-flex rounded-full border border-indigo-400/20 bg-indigo-400/10 px-3 py-1 text-[10px] font-bold uppercase tracking-[0.14em] text-indigo-200">
                            Official Event Details
                        </div>

                        <h1 class="animate-fade-up delay-3 mt-4 max-w-4xl font-display text-[2.15rem] leading-[1.02] tracking-[-0.03em] text-white sm:text-[2.9rem] lg:text-[3.9rem]">
                            {{ $event->title }}
                        </h1>

                        <p class="animate-fade-up delay-4 mt-4 max-w-2xl text-[14.5px] leading-7 text-slate-200 sm:text-[15.5px]">
                            Stay informed, prepare ahead, and be part of another meaningful HSST gathering.
                        </p>
                    </div>
                </div>

                <div id="event-details" class="grid gap-0 lg:grid-cols-[1.42fr_0.92fr]">
                    <!-- MAIN CONTENT -->
                    <div class="p-6 sm:p-8 lg:p-10">
                        <div class="rounded-[28px] border border-white/10 bg-white/[0.03] p-6 sm:p-7">
                            <div class="mb-3 text-[11px] font-semibold uppercase tracking-[0.18em] text-indigo-200">
                                About this event
                            </div>

                            <h2 class="font-display text-[1.6rem] leading-none text-white sm:text-[1.9rem]">
                                Event Overview
                            </h2>

                            <div class="mt-5 text-[15px] leading-[1.95] text-slate-300">
                                {!! nl2br(e($event->description ?: 'No description available yet.')) !!}
                            </div>
                        </div>

                        @if ($event->schedules->isNotEmpty())
                            <div class="mt-10">
                                <div class="mb-5">
                                    <div class="mb-2 text-[11px] font-semibold uppercase tracking-[0.18em] text-emerald-200">
                                        Program Flow
                                    </div>
                                    <h2 class="font-display text-[1.7rem] leading-none text-white sm:text-[2rem]">
                                        Event Schedule
                                    </h2>
                                </div>

                                <div class="space-y-4">
                                    @foreach ($event->schedules as $schedule)
                                        <div class="group relative overflow-hidden rounded-[26px] border border-white/10 bg-white/[0.04] p-5 shadow-[0_12px_28px_rgba(0,0,0,0.18)] transition duration-300 hover:border-indigo-400/20 sm:p-6">
                                            <div class="absolute inset-y-0 left-0 w-[3px] bg-gradient-to-b from-indigo-400 via-emerald-300 to-amber-300 opacity-80"></div>

                                            <div class="grid gap-4 sm:grid-cols-[120px_1fr] sm:gap-6">
                                                <div class="shrink-0">
                                                    <div class="inline-flex rounded-2xl border border-indigo-400/20 bg-indigo-400/10 px-3.5 py-2.5 text-[12px] font-semibold text-indigo-200">
                                                        @if ($schedule->schedule_time)
                                                            {{ \Carbon\Carbon::parse($schedule->schedule_time)->format('g:i A') }}
                                                        @else
                                                            TBA
                                                        @endif
                                                    </div>
                                                </div>

                                                <div>
                                                    @if ($schedule->title)
                                                        <h3 class="text-[15px] font-semibold leading-[1.45] text-white sm:text-[16px]">
                                                            {{ $schedule->title }}
                                                        </h3>
                                                    @endif

                                                    @if ($schedule->description)
                                                        <p class="mt-2 text-[13px] leading-[1.85] text-slate-400">
                                                            {{ $schedule->description }}
                                                        </p>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- SIDEBAR -->
                    <aside class="border-t border-white/10 bg-[#0b1020]/70 p-6 sm:p-8 lg:border-l lg:border-t-0 lg:p-10">
                        <div class="sticky top-24 space-y-5">
                            <div>
                                <div class="mb-2 text-[11px] font-semibold uppercase tracking-[0.18em] text-slate-500">
                                    Quick Information
                                </div>
                                <h2 class="font-display text-[1.55rem] leading-none text-white">
                                    Event Details
                                </h2>
                            </div>

                            <div class="space-y-3">
                                <div class="rounded-[24px] border border-white/10 bg-white/[0.04] p-4">
                                    <div class="text-[10px] font-semibold uppercase tracking-[0.16em] text-slate-500">Date</div>
                                    <div class="mt-2 text-sm font-medium text-white">
                                        @if ($event->event_date)
                                            {{ \Carbon\Carbon::parse($event->event_date)->format('F d, Y') }}
                                        @else
                                            To be announced
                                        @endif
                                    </div>
                                </div>

                                <div class="rounded-[24px] border border-white/10 bg-white/[0.04] p-4">
                                    <div class="text-[10px] font-semibold uppercase tracking-[0.16em] text-slate-500">Time</div>
                                    <div class="mt-2 text-sm font-medium text-white">
                                        @if ($event->schedules->first()?->schedule_time)
                                            {{ \Carbon\Carbon::parse($event->schedules->first()->schedule_time)->format('g:i A') }}
                                        @elseif ($event->event_date)
                                            {{ \Carbon\Carbon::parse($event->event_date)->format('g:i A') }}
                                        @else
                                            To be announced
                                        @endif
                                    </div>
                                </div>

                                <div class="rounded-[24px] border border-white/10 bg-white/[0.04] p-4">
                                    <div class="text-[10px] font-semibold uppercase tracking-[0.16em] text-slate-500">Venue</div>
                                    <div class="mt-2 text-sm font-medium text-white">
                                        {{ $event->venue ?: 'To be announced' }}
                                    </div>
                                </div>

                                <div class="rounded-[24px] border border-white/10 bg-white/[0.04] p-4">
                                    <div class="text-[10px] font-semibold uppercase tracking-[0.16em] text-slate-500">Dress Code</div>
                                    <div class="mt-2 text-sm font-medium text-white">
                                        {{ $event->dress_code ?: 'Not specified' }}
                                    </div>
                                </div>
                            </div>

                            <div class="rounded-[26px] border border-emerald-400/15 bg-emerald-400/[0.06] p-5">
                                <div class="text-[11px] uppercase tracking-[0.16em] text-emerald-300/85">
                                    Reminder
                                </div>
                                <p class="mt-2 text-[13px] leading-[1.8] text-slate-300">
                                    Please review the event details and schedule carefully. Updates may be posted by the school before the actual event date.
                                </p>
                            </div>

                            <div class="rounded-[26px] border border-indigo-400/15 bg-indigo-400/[0.06] p-5">
                                <div class="text-[11px] uppercase tracking-[0.16em] text-indigo-200/90">
                                    Need more updates?
                                </div>
                                <p class="mt-2 text-[13px] leading-[1.8] text-slate-300">
                                    Stay connected through the official alumni portal for announcements, registrations, and future HSST activities.
                                </p>

                                <div class="mt-4 flex flex-col gap-3">
                                    @if (Route::has('register'))
                                        <a href="{{ route('register') }}" class="inline-flex items-center justify-center rounded-2xl bg-indigo-500 px-4 py-3 text-sm font-semibold text-white transition hover:bg-indigo-400">
                                            Join the Alumni Network
                                        </a>
                                    @endif

                                    <a href="{{ route('events.index') }}" class="inline-flex items-center justify-center rounded-2xl border border-white/10 bg-white/5 px-4 py-3 text-sm font-medium text-white transition hover:bg-white/10">
                                        Browse More Events
                                    </a>
                                </div>
                            </div>
                        </div>
                    </aside>
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
                    <a href="#event-details" class="transition hover:text-white">Event Details</a>
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