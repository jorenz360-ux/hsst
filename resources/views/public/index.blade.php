<!DOCTYPE html>
<html lang="en" class="scroll-smooth dark">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Holy Spirit School of Tagbilaran</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=DM+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        [x-cloak] { display: none !important; }

        .font-dm-sans { font-family: "DM Sans", system-ui, sans-serif; }
        .font-dm-serif { font-family: "DM Serif Display", Georgia, serif; }

        .hamburger-line { transition: all .22s ease; }
        .hamburger-open .line-1 { transform: translateY(6px) rotate(45deg); }
        .hamburger-open .line-2 { opacity: 0; }
        .hamburger-open .line-3 { transform: translateY(-6px) rotate(-45deg); }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(16px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .animate-fade-up {
            animation: fadeUp .55s ease both;
        }

        .delay-1 { animation-delay: .06s; }
        .delay-2 { animation-delay: .14s; }
        .delay-3 { animation-delay: .22s; }
        .delay-4 { animation-delay: .30s; }
    </style>
</head>
<body
    class="overflow-x-hidden bg-zinc-950 font-dm-sans text-zinc-100 antialiased selection:bg-teal-500/30 selection:text-white [background:radial-gradient(ellipse_60%_40%_at_0%_0%,rgba(13,148,136,0.14)_0%,transparent_60%),radial-gradient(ellipse_45%_35%_at_100%_5%,rgba(20,184,166,0.10)_0%,transparent_55%),linear-gradient(180deg,#09090b_0%,#111113_50%,#09090b_100%)] [background-attachment:fixed]"
>
<div x-data="{ mobileOpen:false }" class="min-h-screen">

    <!-- Header -->
    <header class="sticky top-0 z-50 border-b border-white/10 bg-zinc-950/85 backdrop-blur-xl">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            <div class="flex items-center justify-between py-4">
                <a href="{{ route('home') }}" class="flex items-center gap-4">
                    <div class="flex h-12 w-12 shrink-0 items-center justify-center overflow-hidden rounded-xl border border-white/10 bg-white p-1 shadow-sm sm:h-14 sm:w-14">
                        <img
                            src="{{ asset('images/hsstlogo.jpg') }}"
                            alt="Holy Spirit School of Tagbilaran Logo"
                            class="h-full w-full rounded-md object-contain"
                        >
                    </div>

                    <div class="hidden h-10 w-px bg-white/10 sm:block"></div>

                    <div class="min-w-0 leading-tight">
                        <p class="text-[10px] font-semibold uppercase tracking-[0.22em] text-teal-400 sm:text-[11px]">
                            Official School Portal
                        </p>
                        <h1 class="truncate text-sm font-bold text-white sm:text-base lg:text-lg">
                            Holy Spirit School of Tagbilaran
                        </h1>
                        <p class="hidden text-xs text-zinc-400 md:block">
                            Faith • Learning • Service • Community
                        </p>
                    </div>
                </a>

                <nav class="hidden items-center gap-1 lg:flex">
                    <a href="{{ route('home') }}" class="rounded-lg px-4 py-2 text-sm font-medium text-zinc-300 transition hover:bg-white/5 hover:text-white">
                        Home
                    </a>
                    <a href="{{ route('about-us') }}" class="rounded-lg px-4 py-2 text-sm font-medium text-zinc-300 transition hover:bg-white/5 hover:text-white">
                        About
                    </a>
                    <a href="#core-values" class="rounded-lg px-4 py-2 text-sm font-medium text-zinc-300 transition hover:bg-white/5 hover:text-white">
                        Core Values
                    </a>
                    <a href="#mission-vision" class="rounded-lg px-4 py-2 text-sm font-medium text-zinc-300 transition hover:bg-white/5 hover:text-white">
                        Mission & Vision
                    </a>
                    <a href="#contact" class="rounded-lg px-4 py-2 text-sm font-medium text-zinc-300 transition hover:bg-white/5 hover:text-white">
                        Contact
                    </a>
                </nav>

                <div class="hidden items-center gap-2 lg:flex">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="rounded-[8px] bg-teal-400 px-5 py-2.5 text-sm font-semibold text-zinc-950 transition hover:bg-teal-300">
                                Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="rounded-[8px] border border-white/10 bg-zinc-900 px-5 py-2.5 text-sm font-medium text-zinc-100 transition hover:bg-zinc-800">
                                Log in
                            </a>

                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="rounded-[8px] bg-teal-400 px-5 py-2.5 text-sm font-semibold text-zinc-950 transition hover:bg-teal-300">
                                    Register
                                </a>
                            @endif
                        @endauth
                    @endif
                </div>

                <button
                    @click="mobileOpen = !mobileOpen"
                    :class="mobileOpen ? 'hamburger-open' : ''"
                    class="flex flex-col gap-[4.5px] rounded-[7px] border border-white/12 p-[9px_10px] lg:hidden"
                    aria-label="Toggle Menu"
                >
                    <span class="hamburger-line line-1 block h-[1.5px] w-[18px] rounded bg-zinc-400"></span>
                    <span class="hamburger-line line-2 block h-[1.5px] w-[18px] rounded bg-zinc-400"></span>
                    <span class="hamburger-line line-3 block h-[1.5px] w-[18px] rounded bg-zinc-400"></span>
                </button>
            </div>

            <!-- Mobile Menu -->
            <div
                x-cloak
                x-show="mobileOpen"
                x-transition.opacity.duration.200ms
                class="border-t border-white/10 py-4 lg:hidden"
            >
                <div class="flex flex-col gap-1 text-sm text-zinc-200">
                    <a @click="mobileOpen=false" href="{{ route('home') }}" class="rounded-xl px-4 py-3 hover:bg-zinc-900">
                        Home
                    </a>
                    <a @click="mobileOpen=false" href="{{ route('about-us') }}" class="rounded-xl px-4 py-3 hover:bg-zinc-900">
                        About
                    </a>
                    <a @click="mobileOpen=false" href="#core-values" class="rounded-xl px-4 py-3 hover:bg-zinc-900">
                        Core Values
                    </a>
                    <a @click="mobileOpen=false" href="#mission-vision" class="rounded-xl px-4 py-3 hover:bg-zinc-900">
                        Mission & Vision
                    </a>
                    <a @click="mobileOpen=false" href="#contact" class="rounded-xl px-4 py-3 hover:bg-zinc-900">
                        Contact
                    </a>

                    @if (Route::has('login'))
                        <div class="mt-4 border-t border-white/10 pt-4">
                            @auth
                                <a href="{{ url('/dashboard') }}" class="block rounded-[9px] bg-teal-400 px-4 py-3 text-center text-sm font-semibold text-zinc-950">
                                    Dashboard
                                </a>
                            @else
                                <div class="flex flex-col gap-3">
                                    <a href="{{ route('login') }}" class="block rounded-[9px] border border-white/12 px-4 py-3 text-center text-sm font-medium text-zinc-300">
                                        Log in
                                    </a>
                                    @if (Route::has('register'))
                                        <a href="{{ route('register') }}" class="block rounded-[9px] bg-teal-400 px-4 py-3 text-center text-sm font-semibold text-zinc-950">
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

    <section class="py-14 lg:py-20">
        <div class="mx-auto max-w-[1200px] px-5 md:px-6">
            <div class="mb-10">
                <p class="mb-2 text-[11px] font-semibold uppercase tracking-[0.18em] text-teal-400">
                    Events
                </p>
                <h1 class="font-dm-serif text-[2.2rem] leading-none text-zinc-100 sm:text-[2.7rem]">
                    All Upcoming Events
                </h1>
                <p class="mt-4 max-w-2xl text-[14px] leading-[1.8] text-zinc-400">
                    Discover the latest school and alumni gatherings, reunions, and community celebrations happening at HSST.
                </p>
            </div>

            @if ($events->count())
                <div class="grid gap-5 md:grid-cols-2 xl:grid-cols-2">
                    @foreach ($events as $event)
                        <article class="group overflow-hidden rounded-2xl border border-white/10 bg-white/[0.03] transition hover:-translate-y-1 hover:border-teal-400/20">
                            <div class="relative h-[220px] overflow-hidden">
                                <img
                                    src="{{ asset('images/100yearsevent.jpg') }}"
                                    alt="{{ $event->title }}"
                                    class="h-full w-full object-cover transition duration-500 group-hover:scale-105"
                                >
                                <div class="absolute inset-0 bg-gradient-to-t from-zinc-950/80 to-transparent"></div>
                            </div>

                            <div class="p-5">
                                <span class="inline-flex rounded-full border border-teal-400/20 bg-teal-400/10 px-3 py-1 text-[10px] font-bold uppercase tracking-[0.14em] text-teal-300">
                                    Event
                                </span>

                                <h2 class="mt-4 font-dm-serif text-[1.2rem] leading-[1.3] text-zinc-100">
                                    <a href="{{ route('events.show', $event) }}" class="transition hover:text-teal-300">
                                        {{ $event->title }}
                                    </a>
                                </h2>

                                <p class="mt-3 text-[12.8px] leading-[1.75] text-zinc-400">
                                    {{ \Illuminate\Support\Str::limit($event->description, 150) }}
                                </p>

                                <div class="mt-5 border-t border-white/10 pt-3 text-[11.5px] text-zinc-400">
                                    {{ \Carbon\Carbon::parse($event->event_date)->format('F d, Y') }}

                                    @if ($event->schedules->first()?->schedule_time)
                                        · {{ \Carbon\Carbon::parse($event->schedules->first()->schedule_time)->format('g:i A') }}
                                    @endif

                                    @if ($event->venue)
                                        <div class="mt-1">{{ $event->venue }}</div>
                                    @endif
                                </div>

                                <div class="mt-5">
                                    <a
                                        href="{{ route('events.show', $event) }}"
                                        class="flex w-full items-center justify-center gap-2 border-t border-teal-400/20 bg-teal-400/10 px-4 py-3 text-[12px] font-semibold text-teal-300 transition hover:bg-teal-400/15">
                                        Read more
                                        <span aria-hidden="true">→</span>
                                    </a>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>

                <div class="mt-10">
                    {{ $events->links() }}
                </div>
            @else
                <div class="rounded-2xl border border-white/10 bg-white/[0.03] p-8 text-center">
                    <h2 class="font-dm-serif text-[1.5rem] text-zinc-100">
                        No upcoming events available
                    </h2>
                    <p class="mt-3 text-[14px] text-zinc-400">
                        Please check back later for newly scheduled events and alumni activities.
                    </p>
                </div>
            @endif
        </div>
    </section>

    <!-- Footer -->
    <footer id="contact" class="border-t border-white/10 bg-zinc-950">
        <div class="mx-auto grid max-w-7xl gap-10 px-4 py-10 sm:px-6 lg:grid-cols-[1.2fr_0.8fr_0.8fr] lg:px-8">
            <div>
                <div class="flex items-center gap-3">
                    <div class="flex h-11 w-11 items-center justify-center overflow-hidden rounded-2xl bg-white p-1 shadow-sm">
                        <img src="{{ asset('images/hsstlogo.jpg') }}" alt="HSST Logo" class="h-full w-full object-contain">
                    </div>
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.2em] text-teal-400">Official School Portal</p>
                        <p class="text-base font-bold text-white">Holy Spirit School of Tagbilaran</p>
                    </div>
                </div>

                <p class="mt-5 max-w-md text-sm leading-7 text-zinc-400">
                    A digital home for official announcements, school events, alumni activities, and meaningful community connection at Holy Spirit School of Tagbilaran.
                </p>
            </div>

            <div>
                <h4 class="text-sm font-semibold uppercase tracking-[0.2em] text-zinc-300">Quick links</h4>
                <div class="mt-4 flex flex-col gap-3 text-sm text-zinc-400">
                    <a href="{{ route('home') }}" class="hover:text-white">Home</a>
                    <a href="{{ route('about-us') }}" class="hover:text-white">About Us</a>
                    <a href="#core-values" class="hover:text-white">Core Values</a>
                    <a href="#mission-vision" class="hover:text-white">Mission & Vision</a>
                </div>
            </div>

            <div>
                <h4 class="text-sm font-semibold uppercase tracking-[0.2em] text-zinc-300">Account</h4>
                <div class="mt-4 flex flex-col gap-3 text-sm text-zinc-400">
                    @if (Route::has('login'))
                        <a href="{{ route('login') }}" class="hover:text-white">Log in</a>
                    @endif
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="hover:text-white">Register</a>
                    @endif
                    <a href="{{ url('/dashboard') }}" class="hover:text-white">Dashboard</a>
                </div>
            </div>
        </div>

        <div class="border-t border-white/10">
            <div class="mx-auto flex max-w-7xl flex-col gap-3 px-4 py-6 text-sm text-zinc-500 sm:px-6 md:flex-row md:items-center md:justify-between lg:px-8">
                <p>© 2026 Holy Spirit School of Tagbilaran. All rights reserved.</p>
                <p>Faith · Learning · Service · Community</p>
            </div>
        </div>
    </footer>

</div>
</body>
</html>