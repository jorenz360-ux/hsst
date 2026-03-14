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

    <!-- Hero -->
    <section class="relative overflow-hidden">
        <div class="absolute inset-0 -z-10">
            <div class="absolute left-0 top-0 h-72 w-72 rounded-full bg-teal-500/15 blur-3xl"></div>
            <div class="absolute right-0 top-10 h-80 w-80 rounded-full bg-cyan-500/10 blur-3xl"></div>
        </div>

        <div class="mx-auto grid max-w-7xl grid-cols-1 items-center gap-12 px-6 py-16 lg:grid-cols-2 lg:gap-16 lg:py-24">
            <div>
                <p class="animate-fade-up delay-1 mb-4 text-sm font-semibold uppercase tracking-[0.25em] text-teal-300">
                    Holy Spirit School of Tagbilaran
                </p>

                <h1 class="animate-fade-up delay-2 font-dm-serif mb-6 text-4xl font-normal leading-tight text-white md:text-5xl lg:text-6xl">
                    Forming minds, nurturing values, and building a
                    <span class="bg-gradient-to-r from-teal-300 via-teal-200 to-cyan-300 bg-clip-text text-transparent italic">
                        faith-centered community.
                    </span>
                </h1>

                <p class="animate-fade-up delay-3 max-w-2xl text-lg leading-relaxed text-zinc-300">
                    Holy Spirit School of Tagbilaran is committed to providing quality education rooted in truth, love, discipline, and service. The school continues to shape learners into responsible, compassionate, and future-ready individuals.
                </p>
            </div>

            <div class="animate-fade-up delay-4 flex justify-center lg:justify-end">
                <div class="w-full max-w-xl rounded-[28px] border border-white/15 bg-white/5 p-4 shadow-[0_20px_60px_rgba(0,0,0,0.35)] backdrop-blur-md transition hover:scale-[1.01]">
                    <img
                        src="{{ asset('images/colorxplained.jpg') }}"
                        alt="Holy Spirit School of Tagbilaran"
                        class="h-[320px] w-full rounded-2xl object-cover md:h-[400px]"
                        loading="lazy"
                    >
                </div>
            </div>
        </div>
    </section>

    <hr class="mx-auto max-w-7xl border-white/10">

    <!-- About Section -->
    <section class="py-16 lg:py-24">
        <div class="mx-auto grid max-w-7xl grid-cols-1 items-center gap-12 px-6 lg:grid-cols-2">
            <div>
                <img
                    src="{{ asset('images/logoabout.jpg') }}"
                    alt="Students and school community"
                    class="h-[300px] w-full rounded-2xl border border-white/10 object-cover shadow-lg md:h-[420px]"
                    loading="lazy"
                >
            </div>

            <div>
                <span class="mb-4 inline-block rounded-full border border-teal-400/20 bg-teal-400/10 px-4 py-1.5 text-sm font-semibold text-teal-300">
                    About the School
                </span>

                <h2 class="font-dm-serif mb-5 text-3xl font-normal text-white md:text-4xl">
                    A tradition of excellence in education and character formation
                </h2>

                <div class="space-y-4 text-zinc-400 leading-relaxed">
                    <p>
                        Holy Spirit School of Tagbilaran has long been dedicated to academic excellence while fostering spiritual growth, moral responsibility, and a deep sense of community.
                    </p>
                    <p>
                        Beyond classroom learning, the school encourages students to become disciplined, compassionate, and socially responsible individuals who can contribute meaningfully to society.
                    </p>
                    <p>
                        This platform also serves as a bridge between the school and its alumni, helping preserve the school’s legacy and strengthen its connections across generations.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <hr class="mx-auto max-w-7xl border-white/10">

    <!-- Core Values -->
    <section id="core-values" class="py-16 lg:py-24">
        <div class="mx-auto max-w-7xl px-6">
            <div class="mx-auto mb-14 max-w-3xl text-center">
                <p class="mb-3 text-[10px] font-bold uppercase tracking-[0.22em] text-teal-400">
                    Core Values
                </p>
                <h2 class="font-dm-serif mb-4 text-3xl font-normal text-white md:text-4xl">
                    The values that shape the HSST community
                </h2>
                <p class="leading-relaxed text-zinc-400">
                    These principles guide the school in forming learners who are academically capable, morally grounded, spiritually centered, and socially responsible.
                </p>
            </div>

            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                <div class="rounded-2xl border border-white/10 bg-white/[0.03] p-6 transition hover:-translate-y-1 hover:border-teal-400/20 hover:bg-white/[0.05]">
                    <div class="mb-4 text-3xl">📘</div>
                    <h3 class="mb-2 text-xl font-semibold text-white">Excellence</h3>
                    <p class="text-sm leading-relaxed text-zinc-400">
                        HSST encourages academic growth, discipline, and a commitment to doing one’s best in all areas of learning and life.
                    </p>
                </div>

                <div class="rounded-2xl border border-white/10 bg-white/[0.03] p-6 transition hover:-translate-y-1 hover:border-teal-400/20 hover:bg-white/[0.05]">
                    <div class="mb-4 text-3xl">💚</div>
                    <h3 class="mb-2 text-xl font-semibold text-white">Faith</h3>
                    <p class="text-sm leading-relaxed text-zinc-400">
                        The school nurtures a strong spiritual foundation that inspires learners to live with purpose, humility, and trust in God.
                    </p>
                </div>

                <div class="rounded-2xl border border-white/10 bg-white/[0.03] p-6 transition hover:-translate-y-1 hover:border-teal-400/20 hover:bg-white/[0.05]">
                    <div class="mb-4 text-3xl">🤝</div>
                    <h3 class="mb-2 text-xl font-semibold text-white">Service</h3>
                    <p class="text-sm leading-relaxed text-zinc-400">
                        Students are formed to care for others, contribute to the community, and use their talents for meaningful service.
                    </p>
                </div>

                <div class="rounded-2xl border border-white/10 bg-white/[0.03] p-6 transition hover:-translate-y-1 hover:border-teal-400/20 hover:bg-white/[0.05]">
                    <div class="mb-4 text-3xl">🌱</div>
                    <h3 class="mb-2 text-xl font-semibold text-white">Integrity</h3>
                    <p class="text-sm leading-relaxed text-zinc-400">
                        HSST promotes honesty, responsibility, and moral courage so learners grow into trustworthy and principled individuals.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <hr class="mx-auto max-w-7xl border-white/10">

    <!-- Mission and Vision -->
    <section id="mission-vision" class="py-16 lg:py-24">
        <div class="mx-auto max-w-7xl px-6">
            <div class="mb-12 text-center">
                <p class="mb-3 text-[10px] font-bold uppercase tracking-[0.22em] text-teal-400">
                    Mission & Vision
                </p>
                <h2 class="font-dm-serif text-3xl font-normal text-white md:text-4xl">
                    Guided by purpose, driven by service
                </h2>
            </div>

            <div class="grid gap-8 lg:grid-cols-2">
                <div class="rounded-2xl border border-white/10 bg-white/[0.04] p-8 shadow-sm">
                    <h3 class="mb-4 text-2xl font-bold text-teal-300">Our Mission</h3>
                    <p class="leading-relaxed text-zinc-400">
                        To provide quality Catholic education that develops intellectual competence, spiritual maturity, moral integrity, and a genuine commitment to service in the community.
                    </p>
                </div>

                <div class="rounded-2xl border border-white/10 bg-white/[0.04] p-8 shadow-sm">
                    <h3 class="mb-4 text-2xl font-bold text-teal-300">Our Vision</h3>
                    <p class="leading-relaxed text-zinc-400">
                        To form Christ-centered, compassionate, disciplined, and competent individuals who become active contributors to society and faithful stewards of the values they have learned.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Legacy Section -->
    <section class="py-16 lg:py-24">
        <div class="mx-auto max-w-7xl px-6">
            <div class="rounded-3xl border border-teal-400/20 bg-[linear-gradient(135deg,rgba(13,148,136,0.22)_0%,rgba(20,184,166,0.12)_35%,rgba(9,9,11,0.6)_100%)] p-8 text-white shadow-xl md:p-12">
                <div class="max-w-3xl">
                    <h2 class="font-dm-serif mb-4 text-3xl font-normal md:text-4xl">
                        A legacy that continues beyond graduation
                    </h2>
                    <p class="text-lg leading-relaxed text-zinc-200/90">
                        The school’s impact lives on through its students and alumni. This system helps strengthen that connection by supporting school engagement, alumni participation, and community-building initiatives.
                    </p>
                </div>
            </div>
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