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

        .delay-1 { animation-delay: .06s; }
        .delay-2 { animation-delay: .14s; }
        .delay-3 { animation-delay: .22s; }
        .delay-4 { animation-delay: .32s; }

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

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(16px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes blink {
            0%, 100% { opacity: 1; }
            50% { opacity: .4; }
        }

        .animate-fade-up {
            animation: fadeUp .52s ease both;
        }

        .animate-blink-soft {
            animation: blink 2.4s ease-in-out infinite;
        }
    </style>
</head>
<body
    class="overflow-x-hidden bg-zinc-950 font-dm-sans leading-relaxed text-zinc-100 antialiased selection:bg-teal-500/30 selection:text-white [background:radial-gradient(ellipse_60%_40%_at_0%_0%,rgba(13,148,136,0.14)_0%,transparent_60%),radial-gradient(ellipse_45%_35%_at_100%_5%,rgba(20,184,166,0.10)_0%,transparent_55%),linear-gradient(180deg,#09090b_0%,#111113_50%,#09090b_100%)] [background-attachment:fixed]"
>
<div x-data="{ mobileOpen:false }">

    <!-- HEADER -->
    <header class="sticky top-0 z-[200] border-b border-white/10 bg-zinc-950/85 backdrop-blur-[20px]">
        <div class="mx-auto flex h-[62px] max-w-[1200px] items-center justify-between gap-4 px-6">
            <a href="{{ route('home') }}" class="flex shrink-0 items-center gap-[13px]">
                <div class="h-[38px] w-[38px] shrink-0 overflow-hidden rounded-[9px] border border-white/12 bg-white p-[3px] sm:h-[42px] sm:w-[42px]">
                    <img
                        src="{{ asset('images/hsstlogo.jpg') }}"
                        alt="HSST Logo"
                        class="h-full w-full rounded-[5px] object-contain"
                    >
                </div>

                <div>
                    <span class="block text-[8.5px] font-semibold uppercase leading-none tracking-[0.22em] text-teal-400">
                        Official School Portal
                    </span>
                    <span class="mt-[2px] block text-[13.5px] font-semibold leading-[1.3] tracking-[-0.01em] text-zinc-100">
                        Holy Spirit School of Tagbilaran
                    </span>
                </div>
            </a>

            <nav class="hidden items-center gap-px lg:flex">
                <a href="{{ route('home') }}" class="rounded-md px-[13px] py-[6px] text-[13px] font-normal text-zinc-400 transition hover:bg-white/5 hover:text-zinc-100">
                    Home
                </a>
                <a href="{{ route('about-us') }}" class="rounded-md px-[13px] py-[6px] text-[13px] font-normal text-zinc-400 transition hover:bg-white/5 hover:text-zinc-100">
                    About
                </a>
                <a href="#what-we-do" class="rounded-md px-[13px] py-[6px] text-[13px] font-normal text-zinc-400 transition hover:bg-white/5 hover:text-zinc-100">
                    What We Do
                </a>
                <a href="#news" class="rounded-md px-[13px] py-[6px] text-[13px] font-normal text-zinc-400 transition hover:bg-white/5 hover:text-zinc-100">
                    News & Events
                </a>
                <a href="#contact" class="rounded-md px-[13px] py-[6px] text-[13px] font-normal text-zinc-400 transition hover:bg-white/5 hover:text-zinc-100">
                    Contact
                </a>
            </nav>

            <div class="hidden shrink-0 items-center gap-2 lg:flex">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="rounded-[7px] bg-teal-400 px-[17px] py-[7px] text-[13px] font-semibold tracking-[-0.01em] text-zinc-950 transition hover:-translate-y-px hover:bg-teal-300 hover:shadow-[0_4px_16px_rgba(62,207,174,0.25)]">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="rounded-[7px] border border-white/12 bg-transparent px-[15px] py-[7px] text-[13px] font-medium text-zinc-400 transition hover:bg-white/5 hover:text-zinc-100">
                            Log in
                        </a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="rounded-[7px] bg-teal-400 px-[17px] py-[7px] text-[13px] font-semibold tracking-[-0.01em] text-zinc-950 transition hover:-translate-y-px hover:bg-teal-300 hover:shadow-[0_4px_16px_rgba(62,207,174,0.25)]">
                                Sign Up
                            </a>
                        @endif
                    @endauth
                @endif
            </div>

            <button
                @click="mobileOpen = !mobileOpen"
                :class="mobileOpen ? 'hamburger-open' : ''"
                class="flex flex-col gap-[4.5px] rounded-[7px] border border-white/12 p-[9px_10px] lg:hidden"
                aria-label="Menu"
            >
                <span class="hamburger-line line-1 block h-[1.5px] w-[18px] rounded bg-zinc-400"></span>
                <span class="hamburger-line line-2 block h-[1.5px] w-[18px] rounded bg-zinc-400"></span>
                <span class="hamburger-line line-3 block h-[1.5px] w-[18px] rounded bg-zinc-400"></span>
            </button>
        </div>
    </header>

    <!-- MOBILE NAV -->
    <div
        x-cloak
        x-show="mobileOpen"
        x-transition.opacity.duration.200ms
        class="fixed inset-x-0 top-[62px] z-[190] flex flex-col gap-0.5 border-t border-white/10 bg-zinc-950/95 px-6 py-5 backdrop-blur-[24px] lg:hidden"
    >
        <a @click="mobileOpen=false" href="{{ route('home') }}" class="block rounded-[9px] px-3.5 py-3 text-[15px] font-normal text-zinc-400 transition hover:bg-white/5 hover:text-zinc-100">Home</a>
        <a @click="mobileOpen=false" href="{{ route('about-us') }}" class="block rounded-[9px] px-3.5 py-3 text-[15px] font-normal text-zinc-400 transition hover:bg-white/5 hover:text-zinc-100">About</a>
        <a @click="mobileOpen=false" href="#what-we-do" class="block rounded-[9px] px-3.5 py-3 text-[15px] font-normal text-zinc-400 transition hover:bg-white/5 hover:text-zinc-100">What We Do</a>
        <a @click="mobileOpen=false" href="#news" class="block rounded-[9px] px-3.5 py-3 text-[15px] font-normal text-zinc-400 transition hover:bg-white/5 hover:text-zinc-100">News & Events</a>
        <a @click="mobileOpen=false" href="#contact" class="block rounded-[9px] px-3.5 py-3 text-[15px] font-normal text-zinc-400 transition hover:bg-white/5 hover:text-zinc-100">Contact</a>

        @if (Route::has('login'))
            <div class="my-2 h-px bg-white/10"></div>

            @auth
                <a href="{{ url('/dashboard') }}" class="block rounded-[9px] bg-teal-400 px-3 py-3 text-center text-sm font-semibold text-zinc-950 transition hover:bg-teal-300">
                    Dashboard
                </a>
            @else
                <a href="{{ route('login') }}" class="block rounded-[9px] border border-white/12 px-3 py-3 text-center text-sm font-medium text-zinc-400 transition hover:text-zinc-100">
                    Log in
                </a>

                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="mt-1.5 block rounded-[9px] bg-teal-400 px-3 py-3 text-center text-sm font-semibold text-zinc-950 transition hover:bg-teal-300">
                        Sign Up
                    </a>
                @endif
            @endauth
        @endif
    </div>

    <!-- HERO -->
 <section class="relative isolate overflow-hidden min-h-[70vh]">
    {{-- Background image --}}
    <div class="absolute inset-0 -z-20">
        <img
            src="{{ asset('images/herosection.jpg') }}"
            alt="HSST alumni reunion background"
            class="h-full w-full object-cover object-center"
        >
    </div>

    {{-- Dark overlay for readability --}}
    <div class="absolute inset-0 -z-10 bg-zinc-950/65"></div>

    {{-- Optional gradient for better text contrast --}}
    <div class="absolute inset-0 -z-10 bg-gradient-to-b from-zinc-950/40 via-zinc-950/55 to-zinc-950/75"></div>

    {{-- Content --}}
    <div class="mx-auto flex min-h-[88vh] max-w-[1200px] items-center justify-center px-5 py-16 text-center md:px-6 lg:px-8">
        <div class="max-w-4xl">
            <div class="animate-fade-up delay-1 mb-6 inline-flex items-center gap-2 rounded-full border border-teal-400/20 bg-teal-400/10 px-3 py-[5px] pl-2 text-[10.5px] font-semibold uppercase tracking-[0.2em] text-teal-300">
                <span class="h-1.5 w-1.5 rounded-full bg-teal-400 animate-blink-soft"></span>
                Faith · Learning · Service · Community
            </div>

           <h1 class="animate-fade-up delay-2 mb-6 font-dm-serif text-[2.5rem] font-normal leading-[1.05] tracking-[-0.02em] text-white sm:text-[3rem] md:text-[3.8rem] lg:text-[4.8rem]">
                Reconnect, Remember, and<br>
                <span class="bg-gradient-to-r from-teal-300 via-teal-200 to-cyan-300 bg-clip-text italic text-transparent">
                    Celebrate with HSST Alumni
                </span>
            </h1>

            <p class="animate-fade-up delay-3 mx-auto mb-10 max-w-2xl text-[15.5px] leading-[1.9] text-zinc-200 md:text-[16.5px]">
                Stay updated with school announcements, upcoming events, alumni activities,
                and important community information from the Holy Spirit School of Tagbilaran.
            </p>

            <div class="animate-fade-up delay-4 mb-14 flex flex-col items-center justify-center gap-3 sm:flex-row sm:flex-wrap">
                <a href="#news" class="rounded-[10px] bg-teal-400 px-[28px] py-3 text-sm font-semibold tracking-[-0.01em] text-zinc-950 shadow-[0_4px_20px_rgba(62,207,174,0.25)] transition hover:-translate-y-0.5 hover:bg-teal-300 hover:shadow-[0_8px_30px_rgba(62,207,174,0.35)]">
                    Explore News & Events
                </a>

                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="rounded-[10px] border border-white/15 bg-white/[0.06] px-6 py-[11px] text-sm font-medium text-zinc-100 backdrop-blur-sm transition hover:border-white/25 hover:bg-white/[0.1]">
                        Create an Account
                    </a>
                @endif
            </div>
        </div>
    </div>
</section>

    <hr class="mx-auto max-w-[1200px] border-white/10">

    <!-- WHAT WE DO -->
    <section id="what-we-do">
        <div class="mx-auto max-w-[1200px] px-5 py-12 md:px-6 lg:py-[4.5rem]">
            <div class="mb-10 grid grid-cols-1 items-end gap-4 lg:grid-cols-[1.2fr_.8fr] lg:gap-12">
                <div>
                    <div class="mb-3 inline-flex items-center gap-2 text-[10px] font-bold uppercase tracking-[0.22em] text-teal-400 before:h-px before:w-5 before:bg-teal-400/50 before:content-['']">
                        What we do
                    </div>
                    <h2 class="font-dm-serif text-[1.7rem] font-normal leading-[1.12] tracking-[-0.018em] text-zinc-100 sm:text-[2rem] lg:text-[2.5rem]">
                        One digital home for school updates, events, and community engagement.
                    </h2>
                </div>

                <p class="max-w-[480px] text-[15px] font-light leading-[1.8] text-zinc-400">
                    This platform helps HSST share official announcements, highlight events, support alumni, and strengthen engagement across the school community.
                </p>
            </div>

            <div class="grid grid-cols-1 gap-2.5 sm:grid-cols-2 xl:grid-cols-4 xl:gap-3.5">
                <div class="rounded-2xl border border-white/10 bg-white/[0.03] p-6 transition hover:-translate-y-[3px] hover:border-teal-400/20 hover:bg-white/[0.05]">
                    <div class="mb-[1.1rem] flex h-[34px] w-[34px] items-center justify-center rounded-[9px] border border-teal-400/20 bg-teal-400/10 text-[11px] font-bold tracking-[0.08em] text-teal-400">01</div>
                    <h4 class="mb-2 text-sm font-semibold tracking-[-0.01em] text-zinc-100">School Announcements</h4>
                    <p class="text-[12.5px] font-light leading-[1.7] text-zinc-600">Share important updates, official notices, and information from the school directly to students, families, and alumni.</p>
                </div>

                <div class="rounded-2xl border border-white/10 bg-white/[0.03] p-6 transition hover:-translate-y-[3px] hover:border-teal-400/20 hover:bg-white/[0.05]">
                    <div class="mb-[1.1rem] flex h-[34px] w-[34px] items-center justify-center rounded-[9px] border border-cyan-400/20 bg-cyan-400/10 text-[11px] font-bold tracking-[0.08em] text-cyan-400">02</div>
                    <h4 class="mb-2 text-sm font-semibold tracking-[-0.01em] text-zinc-100">Event Promotion</h4>
                    <p class="text-[12.5px] font-light leading-[1.7] text-zinc-600">Promote reunions, campus activities, and special gatherings through a dedicated, always-visible public page.</p>
                </div>

                <div class="rounded-2xl border border-white/10 bg-white/[0.03] p-6 transition hover:-translate-y-[3px] hover:border-teal-400/20 hover:bg-white/[0.05]">
                    <div class="mb-[1.1rem] flex h-[34px] w-[34px] items-center justify-center rounded-[9px] border border-emerald-400/20 bg-emerald-400/10 text-[11px] font-bold tracking-[0.08em] text-emerald-400">03</div>
                    <h4 class="mb-2 text-sm font-semibold tracking-[-0.01em] text-zinc-100">Alumni Engagement</h4>
                    <p class="text-[12.5px] font-light leading-[1.7] text-zinc-600">Keep alumni connected with organized updates, shared opportunities, and meaningful participation in school life.</p>
                </div>

                <div class="rounded-2xl border border-white/10 bg-white/[0.03] p-6 transition hover:-translate-y-[3px] hover:border-teal-400/20 hover:bg-white/[0.05]">
                    <div class="mb-[1.1rem] flex h-[34px] w-[34px] items-center justify-center rounded-[9px] border border-sky-400/20 bg-sky-400/10 text-[11px] font-bold tracking-[0.08em] text-sky-400">04</div>
                    <h4 class="mb-2 text-sm font-semibold tracking-[-0.01em] text-zinc-100">Community Connection</h4>
                    <p class="text-[12.5px] font-light leading-[1.7] text-zinc-600">Build a stronger bridge between the school, alumni, families, and the wider Tagbilaran community.</p>
                </div>
            </div>
        </div>
    </section>

    <hr class="mx-auto max-w-[1200px] border-white/10">

    <!-- NEWS -->
  <livewire:public-announcements/>

    <hr class="mx-auto max-w-[1200px] border-white/10">

    <!-- CTA -->
    <div class="mx-auto max-w-[1200px] px-5 pb-16 pt-12 md:px-6 lg:pb-[5.5rem] lg:pt-[4.5rem]">
        <div class="relative grid grid-cols-1 items-center gap-10 overflow-hidden rounded-[22px] border border-teal-400/20 bg-[linear-gradient(135deg,rgba(13,148,136,0.22)_0%,rgba(20,184,166,0.12)_35%,rgba(9,9,11,0.6)_100%)] p-10 lg:grid-cols-[1.5fr_.5fr] lg:gap-12 lg:p-14">
            <div class="pointer-events-none absolute inset-0 bg-[linear-gradient(135deg,rgba(9,9,11,0.55)_0%,rgba(9,9,11,0.75)_100%)]"></div>

            <div class="relative z-[1]">
                <div class="mb-3 text-[10px] font-bold uppercase tracking-[0.22em] text-teal-400/75">
                    Stay connected with HSST
                </div>
                <h2 class="mb-3.5 font-dm-serif text-[1.6rem] font-normal leading-[1.13] tracking-[-0.016em] text-zinc-100 sm:text-[1.9rem] lg:text-[2.3rem]">
                    Access school updates, alumni activities, and community events in one place.
                </h2>
                <p class="text-sm font-light leading-[1.8] text-zinc-300/60">
                    Create your account to receive updates, explore announcements, and stay engaged with school and alumni activities from Holy Spirit School of Tagbilaran.
                </p>
            </div>

            <div class="relative z-[1] flex flex-col gap-2.5">
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="block rounded-[9px] bg-teal-400 px-5 py-[13px] text-center text-sm font-semibold text-zinc-950 transition hover:-translate-y-px hover:bg-teal-300">
                        Create Account
                    </a>
                @endif

                @if (Route::has('login'))
                    <a href="{{ route('login') }}" class="block rounded-[9px] border border-white/15 px-5 py-3 text-center text-sm font-medium text-zinc-300 transition hover:border-white/25 hover:text-zinc-100">
                        Log in
                    </a>
                @endif
            </div>
        </div>
    </div>

    <!-- FOOTER -->
    <footer id="contact" class="border-t border-white/10 bg-zinc-950">
        <div class="mx-auto grid max-w-[1200px] grid-cols-1 gap-8 px-5 py-10 md:grid-cols-2 md:px-6 lg:grid-cols-[1.4fr_1fr_1fr] lg:gap-12 lg:py-14">
            <div class="md:col-span-2 lg:col-span-1">
                <a href="{{ route('home') }}" class="flex items-center gap-[13px]">
                    <div class="h-[38px] w-[38px] shrink-0 overflow-hidden rounded-[9px] border border-white/12 bg-white p-[3px]">
                        <img
                            src="{{ asset('images/hsstlogo.jpg') }}"
                            alt="HSST Logo"
                            class="h-full w-full rounded-[5px] object-contain"
                        >
                    </div>

                    <div>
                        <span class="block text-[8.5px] font-semibold uppercase leading-none tracking-[0.22em] text-teal-400">
                            Official School Portal
                        </span>
                        <span class="mt-[2px] block text-[13.5px] font-semibold leading-[1.3] tracking-[-0.01em] text-zinc-100">
                            Holy Spirit School of Tagbilaran
                        </span>
                    </div>
                </a>

                <p class="mt-4 max-w-[270px] text-[13px] font-light leading-[1.75] text-zinc-600">
                    A digital home for official announcements, school events, alumni activities, and community connection at Holy Spirit School of Tagbilaran.
                </p>
            </div>

            <div>
                <div class="mb-4 text-[10px] font-bold uppercase tracking-[0.2em] text-zinc-600">Quick Links</div>
                <a href="{{ route('home') }}" class="mb-2 block text-[13.5px] font-light text-zinc-400 transition hover:text-zinc-100">Home</a>
                <a href="{{ route('about-us') }}" class="mb-2 block text-[13.5px] font-light text-zinc-400 transition hover:text-zinc-100">About Us</a>
                <a href="#what-we-do" class="mb-2 block text-[13.5px] font-light text-zinc-400 transition hover:text-zinc-100">What We Do</a>
                <a href="#news" class="mb-2 block text-[13.5px] font-light text-zinc-400 transition hover:text-zinc-100">News & Events</a>
            </div>

            <div>
                <div class="mb-4 text-[10px] font-bold uppercase tracking-[0.2em] text-zinc-600">Account</div>
                @if (Route::has('login'))
                    <a href="{{ route('login') }}" class="mb-2 block text-[13.5px] font-light text-zinc-400 transition hover:text-zinc-100">Log in</a>
                @endif
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="mb-2 block text-[13.5px] font-light text-zinc-400 transition hover:text-zinc-100">Register</a>
                @endif
                <a href="{{ url('/dashboard') }}" class="mb-2 block text-[13.5px] font-light text-zinc-400 transition hover:text-zinc-100">Dashboard</a>
            </div>
        </div>

        <div class="mx-auto flex max-w-[1200px] flex-col gap-2 border-t border-white/10 px-5 py-4 md:flex-row md:items-center md:justify-between md:px-6">
            <p class="text-[11.5px] font-light text-zinc-600">© 2026 Holy Spirit School of Tagbilaran. All rights reserved.</p>
            <p class="text-[11.5px] font-light text-zinc-600">Faith · Learning · Service · Community</p>
        </div>
    </footer>
</div>
</body>
</html>