<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover" />
    <title>Holy Spirit School of Tagbilaran Alumni Portal</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        [x-cloak] { display: none !important; }

        .font-body { font-family: "Inter", system-ui, sans-serif; }
        .font-display { font-family: "DM Serif Display", Georgia, serif; }

        .hamburger-line {
            transition: all 0.22s ease;
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

<body class="overflow-x-hidden bg-white font-body text-slate-800 antialiased">
<div x-data="{ mobileOpen: false }" class="min-h-screen bg-white">

    {{-- HEADER --}}
    <header class="sticky inset-x-0 top-0 z-50 border-b border-white/10 bg-[#0F2A6B]/95 px-4 backdrop-blur-md sm:px-6 lg:px-8">
        <div class="mx-auto flex h-[76px] max-w-[1380px] items-center justify-between">
            <a href="{{ route('home') }}" class="flex min-w-0 items-center gap-3 transition hover:opacity-90">
                <div class="flex h-11 w-11 shrink-0 items-center justify-center overflow-hidden border border-white/20 bg-white p-1 shadow-sm">
                    <img src="{{ asset('images/hsstlogo.jpg') }}" alt="HSST Logo" class="h-full w-full object-contain">
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
                <a href="#homecoming" class="px-4 py-2 text-sm font-semibold text-white/85 transition hover:bg-white/10 hover:text-white">Homecoming</a>
                <a href="#gallery" class="px-4 py-2 text-sm font-semibold text-white/85 transition hover:bg-white/10 hover:text-white">Gallery</a>
                <a href="#events" class="px-4 py-2 text-sm font-semibold text-white/85 transition hover:bg-white/10 hover:text-white">Events</a>
                <a href="#announcements" class="px-4 py-2 text-sm font-semibold text-white/85 transition hover:bg-white/10 hover:text-white">Announcements</a>
                <a href="#contact" class="px-4 py-2 text-sm font-semibold text-white/85 transition hover:bg-white/10 hover:text-white">Contact</a>
            </nav>

            <div class="hidden items-center gap-3 lg:flex">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="inline-flex items-center justify-center border border-white bg-white px-5 py-2.5 text-sm font-bold text-[#0F2A6B] transition hover:bg-slate-100">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="inline-flex items-center justify-center  px-5 py-2.5 text-sm font-semibold text-white transition">
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
                class="flex flex-col gap-[4.5px] border border-white/20 p-3 lg:hidden"
                aria-label="Menu"
            >
                <span class="hamburger-line line-1 block h-[1.5px] w-[20px] rounded bg-white"></span>
                <span class="hamburger-line line-2 block h-[1.5px] w-[20px] rounded bg-white"></span>
                <span class="hamburger-line line-3 block h-[1.5px] w-[20px] rounded bg-white"></span>
            </button>
        </div>
    </header>

    {{-- MOBILE MENU --}}
    <div
        x-cloak
        x-show="mobileOpen"
        x-transition.opacity.duration.200ms
        class="fixed inset-x-0 top-[76px] z-40 border-t border-white/10 bg-[#0F2A6B] px-4 py-5 shadow-2xl lg:hidden"
    >
        <div class="mx-auto max-w-[1380px]">
            <div class="flex flex-col">
                <a @click="mobileOpen=false" href="#homecoming" class="border-b border-white/10 px-2 py-4 text-base font-semibold text-white/90">Homecoming</a>
                <a @click="mobileOpen=false" href="#gallery" class="border-b border-white/10 px-2 py-4 text-base font-semibold text-white/90">Gallery</a>
                <a @click="mobileOpen=false" href="#events" class="border-b border-white/10 px-2 py-4 text-base font-semibold text-white/90">Events</a>
                <a @click="mobileOpen=false" href="#announcements" class="border-b border-white/10 px-2 py-4 text-base font-semibold text-white/90">Announcements</a>
                <a @click="mobileOpen=false" href="#contact" class="px-2 py-4 text-base font-semibold text-white/90">Contact</a>
            </div>

            @if (Route::has('login'))
                <div class="mt-5 grid gap-3">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="block bg-white px-4 py-4 text-center text-base font-bold text-[#0F2A6B]">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="block border border-white/20 bg-white/10 px-4 py-4 text-center text-base font-semibold text-white">
                            Log in
                        </a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="block bg-white px-4 py-4 text-center text-base font-bold text-[#0F2A6B]">
                                Register
                            </a>
                        @endif
                    @endauth
                </div>
            @endif
        </div>
    </div>

    {{-- HERO --}}
    <section class="relative overflow-hidden">
        <div class="absolute inset-0">
            <img
                src="{{ asset('images/hsstherosect.png') }}"
                alt="HSST campus or alumni event"
                class="h-full w-full object-cover object-center"
            >
         <div class="absolute inset-0 bg-[linear-gradient(90deg,rgba(15,23,42,0.94)_0%,rgba(15,23,42,0.82)_38%,rgba(15,23,42,0.56)_62%,rgba(15,23,42,0.24)_100%)]"></div>
<div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,rgba(255,255,255,0.06),transparent_28%)]"></div>
        </div>

        <div class="relative z-10 mx-auto max-w-[1380px] px-4 py-14 sm:px-6 sm:py-16 md:py-24 lg:px-8 lg:py-32 2xl:py-36">
            <div class="max-w-3xl">

                <h1 class="mt-6 font-display text-[2.8rem] leading-[1.02] tracking-[-0.03em] text-white sm:text-[3.8rem] lg:text-[5rem] 2xl:text-[5.8rem]">
                    Reconnect with the
                    <span class="text-white">HSSTian alumni legacy.</span>
                </h1>

                <p class="mt-6 max-w-2xl text-base leading-8 text-white/90 md:text-lg">
                    Stay connected through official announcements, alumni events, school milestones,
                    and one trusted digital home built for every Holy Spirit School of Tagbilaran graduate.
                </p>

                <div class="mt-10 flex flex-col gap-4 sm:flex-row">
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="inline-flex items-center justify-center bg-white px-8 py-4 text-sm font-bold uppercase tracking-[0.16em] text-[#0F2A6B] transition hover:bg-slate-100">
                            Join the Alumni Network
                        </a>
                    @endif

                   <a href="#events" class="inline-flex items-center justify-center bg-[#1E3A8A] px-8 py-4 text-sm font-bold uppercase tracking-[0.16em] text-white transition hover:bg-[#1E40AF]">
    Explore Events
</a>
                </div>

                @php
                    $yearsOfLegacy = now()->year - 1926;
                @endphp

                <div class="mt-12 grid max-w-xl grid-cols-3 gap-4 border-t border-white/15 pt-8">
                    <div>
                        <p class="text-2xl font-extrabold text-white">{{ $yearsOfLegacy }}+</p>
                        <p class="mt-1 text-xs font-medium text-white/80">Years of legacy</p>
                    </div>

                    <div>
                        <p class="text-2xl font-extrabold text-white">Alumni</p>
                        <p class="mt-1 text-xs font-medium text-white/80">Across generations</p>
                    </div>

                    <div>
                        <p class="text-2xl font-extrabold text-white">1 Home</p>
                        <p class="mt-1 text-xs font-medium text-white/80">Official digital portal</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- HOMECOMING --}}
    <section id="homecoming" class="bg-white">
        <div class="mx-auto max-w-[1380px] px-4 py-14 sm:px-6 md:py-20 lg:px-8 lg:py-24">
            <div class="max-w-4xl">
                <p class="text-[11px] font-extrabold uppercase tracking-[0.28em] text-[#1E3A8A]">
                    Grand Alumni Homecoming
                </p>

                <h2 class="mt-4 font-display text-[2.1rem] leading-[1.08] text-slate-900 sm:text-[2.8rem] lg:text-[3.5rem]">
                    No matter when you graduated, you remain part of the HSST story.
                </h2>

                <p class="mt-6 max-w-3xl text-base leading-8 text-slate-600 md:text-lg">
                    The HSST Alumni Homecoming celebrates friendship, shared memories, and a lasting
                    connection to the school community. It brings together generations of graduates
                    to honor tradition, revisit milestones, and continue a legacy rooted in faith,
                    learning, and service.
                </p>
            </div>
        </div>
    </section>

    {{-- GALLERY --}}
    <section id="gallery" class="bg-slate-50">
        <div class="mx-auto max-w-[1380px] px-4 py-14 sm:px-6 md:py-20 lg:px-8 lg:py-24">
           <div class="mx-auto mb-12 max-w-3xl text-center">
                <p class="mb-3 text-[11px] font-extrabold uppercase tracking-[0.30em] text-[#1E3A8A]">
                    100 Years of HSST
                </p>
                <h2 class="font-display text-[2rem] leading-[1.08] text-slate-900 sm:text-[2.6rem] lg:text-[3rem]">
                    Honoring a century of faith, excellence, and community
                </h2>
                <p class="mt-4 text-base leading-7 text-slate-600">
                    As Holy Spirit School of Tagbilaran celebrates its 100th anniversary, we remember the people, milestones, and traditions that shaped generations of alumni.
                </p>
            </div>

            <div
                x-data="carousel()"
                x-init="init()"
                @mouseenter="stopAutoSlide()"
                @mouseleave="startAutoSlide()"
                @touchstart.passive="handleTouchStart"
                @touchmove.passive="handleTouchMove"
                @touchend.passive="handleTouchEnd"
                class="relative"
            >
                <div class="relative overflow-visible bg-transparent shadow-none sm:overflow-hidden sm:bg-slate-200 sm:shadow-xl">
                    <img
                        :src="images[currentIndex]"
                        alt="HSST campus scene"
                        class="h-[320px] w-full object-contain bg-transparent transition-all duration-500 sm:h-[420px] sm:bg-slate-200 md:h-[500px] lg:h-[580px]"
                    >

                 <button
                    @click="prev()"
                    class="absolute left-3 top-1/2 hidden -translate-y-1/2 bg-white p-2.5 shadow-lg transition hover:bg-slate-100 focus:outline-none focus:ring-2 focus:ring-[#1E3A8A] sm:block"
                >
                    <svg class="h-6 w-6 text-slate-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>

                <button
                    @click="next()"
                    class="absolute right-3 top-1/2 hidden -translate-y-1/2 bg-white p-2.5 shadow-lg transition hover:bg-slate-100 focus:outline-none focus:ring-2 focus:ring-[#1E3A8A] sm:block"
                >
                    <svg class="h-6 w-6 text-slate-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
                </div>

                <div class="mt-6 flex justify-center gap-3">
                    <template x-for="(_, idx) in images" :key="idx">
                        <button
                            @click="currentIndex = idx"
                            class="h-2.5 transition-all focus:outline-none"
                            :class="currentIndex === idx ? 'bg-[#1E3A8A] w-7' : 'bg-slate-300 w-2.5 hover:bg-slate-400'"
                        ></button>
                    </template>
                </div>
            </div>
        </div>
    </section>

    {{-- EVENTS --}}
    <section id="events" class="bg-white">
        <div class="mx-auto max-w-[1380px] px-4 py-14 sm:px-6 md:py-20 lg:px-8 lg:py-24">
            <div class="mb-12 flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
                <div class="max-w-3xl">
                    <p class="mb-3 text-[11px] font-extrabold uppercase tracking-[0.30em] text-[#1E3A8A]">
                        Upcoming Events
                    </p>
                    <h2 class="font-display text-[2rem] leading-[1.08] text-slate-900 sm:text-[2.6rem] lg:text-[3rem]">
                        Alumni news and events
                    </h2>
                </div>

                <a href="{{ route('events.index') }}" class="text-sm font-bold uppercase tracking-[0.12em] text-[#1E3A8A] transition hover:text-[#1E40AF]">
                    View All
                </a>
            </div>

            @if ($events->isNotEmpty())
                <div class="grid gap-10 md:grid-cols-2 xl:grid-cols-3">
                    @foreach ($events as $event)
                        @php
                            $bannerUrl = $event->banner_image
                                ? \Illuminate\Support\Facades\Storage::disk('s3')->url($event->banner_image)
                                : asset('images/100yearsevent.jpg');
                        @endphp

                        <article class="group border-b border-slate-200 pb-8">
                            <div class="relative overflow-hidden bg-slate-100">
                                <img
                                    src="{{ $bannerUrl }}"
                                    alt="{{ $event->title }}"
                                    class="h-[280px] w-full object-cover transition duration-700 group-hover:scale-105 sm:h-[320px]"
                                >
                                <div class="absolute inset-0 bg-gradient-to-t from-black/25 via-transparent to-transparent"></div>

                                <div class="absolute left-4 top-4">
                                    <span class="inline-flex bg-[#1E3A8A] px-3 py-1 text-[10px] font-extrabold uppercase tracking-[0.18em] text-white">
                                        Upcoming
                                    </span>
                                </div>
                            </div>

                            <div class="pt-5">
                                <p class="text-[11px] font-extrabold uppercase tracking-[0.28em] text-[#1E3A8A]">
                                    {{ \Carbon\Carbon::parse($event->event_date)->format('F d, Y') }}
                                    @if ($event->schedules->first()?->schedule_time)
                                        · {{ \Carbon\Carbon::parse($event->schedules->first()->schedule_time)->format('g:i A') }}
                                    @endif
                                </p>

                                <h3 class="mt-3 font-display text-[1.65rem] leading-[1.18] text-slate-900 transition group-hover:text-[#1E3A8A]">
                                    <a href="{{ route('events.show', ['event' => $event->slug]) }}">
                                        {{ $event->title }}
                                    </a>
                                </h3>

                                @if ($event->venue)
                                    <p class="mt-3 text-sm font-semibold text-slate-700">{{ $event->venue }}</p>
                                @endif

                                @if ($event->dress_code)
                                    <p class="mt-1 text-xs text-slate-500">Dress Code: {{ $event->dress_code }}</p>
                                @endif

                                <p class="mt-4 text-sm leading-7 text-slate-600">
                                    {{ \Illuminate\Support\Str::limit($event->description, 155) }}
                                </p>

                                <div class="mt-6">
                                    <a href="{{ route('events.show', $event) }}" class="inline-flex items-center gap-2 text-sm font-bold uppercase tracking-[0.14em] text-[#1E3A8A] transition hover:gap-3 hover:text-[#1E40AF]">
                                        Read more
                                        <span aria-hidden="true">→</span>
                                    </a>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
            @else
                <div class="border-y border-slate-200 py-12 text-center">
                    <p class="text-sm font-extrabold uppercase tracking-[0.24em] text-[#1E3A8A]">Events</p>
                    <h3 class="mt-4 font-display text-[1.8rem] text-slate-900">No upcoming event yet</h3>
                    <p class="mx-auto mt-3 max-w-xl text-sm leading-7 text-slate-600">
                        Please check back soon for the next scheduled school or alumni event.
                    </p>
                </div>
            @endif
        </div>
    </section>

    {{-- ANNOUNCEMENTS --}}
    <section id="announcements" class="bg-slate-50">
        <div class="mx-auto max-w-[1380px] px-4 py-14 sm:px-6 md:py-20 lg:px-8 lg:py-24">
            <div class="mb-12">
                <p class="mb-3 text-[11px] font-extrabold uppercase tracking-[0.30em] text-[#1E3A8A]">
                    Announcements
                </p>
                <h2 class="font-display text-[2rem] leading-[1.08] text-slate-900 sm:text-[2.5rem] lg:text-[3rem]">
                    Important notices and updates
                </h2>
            </div>

            <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
                @forelse ($announcements as $announcement)
                    <article class="border-b border-slate-200 pb-6">
                        <div class="mb-4 flex flex-wrap items-center gap-2">
                            <span class="inline-flex border border-[#1E3A8A]/20 bg-[#1E3A8A]/10 px-3 py-1 text-[10px] font-extrabold uppercase tracking-[0.18em] text-[#1E3A8A]">
                                Announcement
                            </span>

                            @if ($announcement->pinned)
                                <span class="inline-flex bg-[#1E3A8A] px-3 py-1 text-[10px] font-extrabold uppercase tracking-[0.18em] text-white">
                                    Pinned
                                </span>
                            @endif
                        </div>

                        <h3 class="text-xl font-bold leading-snug text-slate-900">
                            {{ $announcement->title }}
                        </h3>

                        <p class="mt-4 text-sm leading-7 text-slate-600">
                            {{ \Illuminate\Support\Str::limit(strip_tags($announcement->content), 190) }}
                        </p>

                        <div class="mt-5 text-[11px] font-medium text-slate-500">
                            @if ($announcement->published_at)
                                {{ $announcement->published_at->format('F d, Y') }}
                            @else
                                Recently published
                            @endif
                        </div>
                    </article>
                @empty
                    <div class="border-y border-slate-200 py-10 text-sm text-slate-600">
                        No announcements available right now.
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    {{-- CTA --}}
    <section class="relative overflow-hidden bg-[#1E3A8A]">
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,rgba(255,255,255,0.1),transparent_40%)]"></div>

        <div class="relative z-10 mx-auto max-w-[1380px] px-4 py-14 sm:px-6 md:py-20 lg:grid lg:grid-cols-[1.2fr_.8fr] lg:items-center lg:gap-10 lg:px-8 lg:py-24">
            <div>
                <p class="text-[11px] font-extrabold uppercase tracking-[0.30em] text-white/80">
                    Join the HSST Network
                </p>

                <h2 class="mt-4 font-display text-[1.9rem] leading-[1.08] text-white sm:text-[2.5rem] lg:text-[3rem]">
                    Ready to reconnect with the HSST community?
                </h2>

                <p class="mt-5 max-w-2xl text-base leading-8 text-white/90">
                    Create your account to receive updates, participate in alumni activities,
                    and stay connected through one secure school-managed platform.
                </p>
            </div>

            <div class="mt-8 flex flex-col gap-4 lg:mt-0">
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
    </section>

    {{-- FOOTER --}}
    <footer id="contact" class="bg-white text-slate-600">
        <div class="mx-auto grid max-w-[1380px] gap-10 px-4 py-12 sm:px-6 md:py-16 lg:grid-cols-[1.3fr_.8fr_.8fr] lg:px-8">
            <div>
                <a href="{{ route('home') }}" class="flex items-center gap-3">
                    <div class="flex h-11 w-11 shrink-0 items-center justify-center overflow-hidden border border-slate-200 bg-white p-1 shadow-sm">
                        <img src="{{ asset('images/hsstlogo.jpg') }}" alt="HSST Logo" class="h-full w-full object-contain">
                    </div>
                    <div>
                        <p class="text-sm font-bold text-slate-900">Holy Spirit School of Tagbilaran</p>
                        <p class="text-xs text-slate-500">Official Alumni Portal</p>
                    </div>
                </a>

                <p class="mt-5 max-w-[390px] text-sm leading-7 text-slate-600">
                    A digital home for official announcements, alumni events, school celebrations,
                    and a stronger connection between HSST and its graduates.
                </p>

                <p class="mt-4 text-xs text-slate-500">
                    Managed by HSST Administration & Alumni Office
                </p>
            </div>

            <div>
                <p class="mb-4 text-[10px] font-extrabold uppercase tracking-[0.22em] text-[#1E3A8A]">
                    Quick Links
                </p>

                <div class="space-y-2">
                    <a href="#homecoming" class="block text-sm text-slate-600 transition hover:text-[#1E3A8A]">Homecoming</a>
                    <a href="#gallery" class="block text-sm text-slate-600 transition hover:text-[#1E3A8A]">Gallery</a>
                    <a href="#events" class="block text-sm text-slate-600 transition hover:text-[#1E3A8A]">Events</a>
                    <a href="#announcements" class="block text-sm text-slate-600 transition hover:text-[#1E3A8A]">Announcements</a>
                </div>
            </div>

            <div>
                <p class="mb-4 text-[10px] font-extrabold uppercase tracking-[0.22em] text-[#1E3A8A]">
                    Account
                </p>

                <div class="space-y-2">
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

        <div class="mx-auto flex max-w-[1380px] flex-col gap-2 border-t border-slate-200 px-4 py-5 text-xs text-slate-500 sm:px-6 md:flex-row md:items-center md:justify-between lg:px-8">
            <p>© 2026 Holy Spirit School of Tagbilaran. All rights reserved.</p>
            <p>Truth in Love · Faith · Learning · Community</p>
        </div>
    </footer>
</div>

<script>
    function carousel() {
        return {
            images: [
                @json(asset('images/image5.jpg')),
                  @json(asset('images/100YEARSLOGOELEMENT.jpg')),
                @json(asset('images/image3.jpg')),
                @json(asset('images/image4.jpg'))
            ],
            currentIndex: 0,
            interval: null,
            touchStartX: 0,
            touchEndX: 0,

            init() {
                this.startAutoSlide();
            },

            startAutoSlide() {
                this.stopAutoSlide();

                this.interval = setInterval(() => {
                    this.next();
                }, 4000);
            },

            stopAutoSlide() {
                if (this.interval) {
                    clearInterval(this.interval);
                    this.interval = null;
                }
            },

            prev() {
                this.currentIndex =
                    (this.currentIndex - 1 + this.images.length) % this.images.length;
            },

            next() {
                this.currentIndex =
                    (this.currentIndex + 1) % this.images.length;
            },

            handleTouchStart(e) {
                this.touchStartX = e.touches[0].clientX;
            },

            handleTouchMove(e) {
                this.touchEndX = e.touches[0].clientX;
            },

            handleTouchEnd() {
                const diff = this.touchStartX - this.touchEndX;

                if (Math.abs(diff) > 50) {
                    if (diff > 0) {
                        this.next();
                    } else {
                        this.prev();
                    }
                }

                this.touchStartX = 0;
                this.touchEndX = 0;
            }
        };
    }
</script>
</body>
</html>