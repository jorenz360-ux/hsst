<!DOCTYPE html>
<html lang="en" class="scroll-smooth dark">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Holy Spirit School of Tagbilaran Alumni Portal</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        [x-cloak] { display: none !important; }

        .font-body { font-family: "Inter", system-ui, sans-serif; }
        .font-display { font-family: "DM Serif Display", Georgia, serif; }

        .delay-1 { animation-delay: .08s; }
        .delay-2 { animation-delay: .16s; }
        .delay-3 { animation-delay: .24s; }
        .delay-4 { animation-delay: .32s; }
        .delay-5 { animation-delay: .40s; }
        .delay-6 { animation-delay: .48s; }

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
            from { opacity: 0; transform: translateY(18px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes floatSoft {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-8px); }
        }

        @keyframes blink {
            0%, 100% { opacity: 1; }
            50% { opacity: .45; }
        }

        .animate-fade-up {
            animation: fadeUp .62s cubic-bezier(.22,1,.36,1) both;
        }

        .animate-float-soft {
            animation: floatSoft 5s ease-in-out infinite;
        }

        .animate-blink-soft {
            animation: blink 2.2s ease-in-out infinite;
        }

        .glass-panel {
            backdrop-filter: blur(18px);
            -webkit-backdrop-filter: blur(18px);
        }
    </style>
</head>
<body
    class="overflow-x-hidden bg-[#050816] font-body leading-relaxed text-slate-100 antialiased selection:bg-indigo-400/30 selection:text-white [background:
    radial-gradient(circle_at_top_left,rgba(99,102,241,0.18),transparent_28%),
    radial-gradient(circle_at_top_right,rgba(16,185,129,0.10),transparent_24%),
    radial-gradient(circle_at_bottom_right,rgba(245,158,11,0.08),transparent_18%),
    linear-gradient(180deg,#050816_0%,#070b18_32%,#090d1f_62%,#050816_100%)] [background-attachment:fixed]"
>
<div x-data="{ mobileOpen:false }">

    <!-- HEADER -->
    <header class="sticky top-0 z-[300] border-b border-white/10 bg-[#050816]/80 glass-panel">
        <div class="mx-auto flex h-[78px] max-w-[1320px] items-center justify-between gap-4 px-5 md:px-6 lg:px-8">
            <a href="{{ route('home') }}" class="flex min-w-0 shrink-0 items-center gap-3">
                <div class="h-12 w-12 shrink-0 overflow-hidden rounded-2xl border border-white/10 bg-white p-[4px] shadow-[0_14px_36px_rgba(0,0,0,0.28)]">
                    <img
                        src="{{ asset('images/hsstlogo.jpg') }}"
                        alt="HSST Logo"
                        class="h-full w-full rounded-xl object-contain"
                    >
                </div>

                <div class="min-w-0">
                    <span class="block text-[10px] font-semibold uppercase leading-none tracking-[0.26em] text-emerald-300/90">
                        Official Alumni Portal
                    </span>
                    <span class="mt-1 block truncate text-[14px] font-semibold leading-[1.2] tracking-[-0.01em] text-white sm:text-[15px]">
                        Holy Spirit School of Tagbilaran
                    </span>
                </div>
            </a>

            <nav class="hidden items-center gap-1 lg:flex">
                {{-- <a href="{{ route('home') }}" class="rounded-xl px-4 py-2 text-[14px] font-medium text-slate-300 transition hover:bg-white/5 hover:text-white">
                    Home
                </a> --}}
                {{-- <a href="{{ route('about-us') }}" class="rounded-xl px-4 py-2 text-[14px] font-medium text-slate-300 transition hover:bg-white/5 hover:text-white">
                    About
                </a> --}}
                <a href="#homecoming" class="rounded-xl px-4 py-2 text-[14px] font-medium text-slate-300 transition hover:bg-white/5 hover:text-white">
                    Homecoming
                </a>
                <a href="#features" class="rounded-xl px-4 py-2 text-[14px] font-medium text-slate-300 transition hover:bg-white/5 hover:text-white">
                    Features
                </a>
                <a href="#how-it-works" class="rounded-xl px-4 py-2 text-[14px] font-medium text-slate-300 transition hover:bg-white/5 hover:text-white">
                    How It Works
                </a>
                <a href="#news" class="rounded-xl px-4 py-2 text-[14px] font-medium text-slate-300 transition hover:bg-white/5 hover:text-white">
                    News
                </a>
                <a href="#contact" class="rounded-xl px-4 py-2 text-[14px] font-medium text-slate-300 transition hover:bg-white/5 hover:text-white">
                    Contact
                </a>
            </nav>

            <div class="hidden shrink-0 items-center gap-2 lg:flex">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="rounded-2xl bg-indigo-500 px-5 py-2.5 text-[14px] font-semibold text-white shadow-[0_16px_34px_rgba(99,102,241,0.28)] transition hover:-translate-y-0.5 hover:bg-indigo-400">
                            Go to Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="rounded-2xl border border-white/10 bg-white/5 px-4 py-2.5 text-[14px] font-medium text-slate-200 transition hover:bg-white/10 hover:text-white">
                            Log in
                        </a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="rounded-2xl bg-indigo-500 px-5 py-2.5 text-[14px] font-semibold text-white shadow-[0_16px_34px_rgba(99,102,241,0.28)] transition hover:-translate-y-0.5 hover:bg-indigo-400">
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

    <!-- MOBILE NAV -->
    <div
        x-cloak
        x-show="mobileOpen"
        x-transition.opacity.duration.200ms
        class="fixed inset-x-0 top-[78px] z-[250] border-t border-white/10 bg-[#050816]/95 px-5 py-5 glass-panel lg:hidden"
    >
        <div class="flex flex-col gap-1">
            <a @click="mobileOpen=false" href="{{ route('home') }}" class="rounded-xl px-4 py-3 text-[15px] font-medium text-slate-200 transition hover:bg-white/5 hover:text-white">Home</a>
            {{-- <a @click="mobileOpen=false" href="{{ route('about-us') }}" class="rounded-xl px-4 py-3 text-[15px] font-medium text-slate-200 transition hover:bg-white/5 hover:text-white">About</a> --}}
            <a @click="mobileOpen=false" href="#homecoming" class="rounded-xl px-4 py-3 text-[15px] font-medium text-slate-200 transition hover:bg-white/5 hover:text-white">Homecoming</a>
            <a @click="mobileOpen=false" href="#features" class="rounded-xl px-4 py-3 text-[15px] font-medium text-slate-200 transition hover:bg-white/5 hover:text-white">Features</a>
            <a @click="mobileOpen=false" href="#how-it-works" class="rounded-xl px-4 py-3 text-[15px] font-medium text-slate-200 transition hover:bg-white/5 hover:text-white">How It Works</a>
            <a @click="mobileOpen=false" href="#news" class="rounded-xl px-4 py-3 text-[15px] font-medium text-slate-200 transition hover:bg-white/5 hover:text-white">News</a>
            <a @click="mobileOpen=false" href="#contact" class="rounded-xl px-4 py-3 text-[15px] font-medium text-slate-200 transition hover:bg-white/5 hover:text-white">Contact</a>
        </div>

        @if (Route::has('login'))
            <div class="my-4 h-px bg-white/10"></div>

            @auth
                <a href="{{ url('/dashboard') }}" class="block rounded-2xl bg-indigo-500 px-4 py-3 text-center text-sm font-semibold text-white transition hover:bg-indigo-400">
                    Go to Dashboard
                </a>
            @else
                <a href="{{ route('login') }}" class="block rounded-2xl border border-white/10 bg-white/5 px-4 py-3 text-center text-sm font-medium text-slate-200 transition hover:bg-white/10 hover:text-white">
                    Log in
                </a>

                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="mt-2 block rounded-2xl bg-indigo-500 px-4 py-3 text-center text-sm font-semibold text-white transition hover:bg-indigo-400">
                        Register
                    </a>
                @endif
            @endauth
        @endif
    </div>

    <!-- HERO -->
    <section class="relative isolate overflow-hidden">
        <div class="absolute inset-0 -z-30">
            <img
                src="{{ asset('images/herosection.jpg') }}"
                alt="HSST alumni community"
                class="h-full w-full object-cover object-center"
            >
        </div>

        <div class="absolute inset-0 -z-20 bg-[#050816]/80"></div>
        <div class="absolute inset-0 -z-10 bg-[linear-gradient(180deg,rgba(5,8,22,0.42)_0%,rgba(5,8,22,0.76)_38%,rgba(5,8,22,0.96)_100%)]"></div>
        <div class="absolute -left-24 top-24 -z-10 h-72 w-72 rounded-full bg-indigo-500/20 blur-3xl"></div>
        <div class="absolute right-0 top-1/3 -z-10 h-80 w-80 rounded-full bg-emerald-400/10 blur-3xl"></div>
        <div class="absolute inset-x-0 bottom-0 -z-10 h-48 bg-gradient-to-t from-[#050816] to-transparent"></div>

        <div class="mx-auto grid min-h-[94vh] max-w-[1320px] items-center gap-14 px-5 py-16 md:px-6 lg:grid-cols-[1.08fr_.92fr] lg:px-8 lg:py-20">
            <div class="max-w-3xl">
                <div class="animate-fade-up delay-1 mb-5 inline-flex items-center gap-2 rounded-full border border-indigo-400/20 bg-indigo-400/10 px-4 py-1.5 text-[11px] font-semibold uppercase tracking-[0.20em] text-indigo-100">
                    <span class="h-1.5 w-1.5 rounded-full bg-emerald-400 animate-blink-soft"></span>
                    Legacy. Community. Homecoming.
                </div>

                <h1 class="animate-fade-up delay-2 max-w-4xl font-display text-[2.9rem] leading-[0.96] tracking-[-0.035em] text-white sm:text-[3.8rem] md:text-[4.7rem] lg:text-[5.5rem]">
                    Come Home,
                    <span class="bg-gradient-to-r from-white via-indigo-100 to-emerald-100 bg-clip-text text-transparent italic">
                        HSSTians
                    </span>
                </h1>

                <p class="animate-fade-up delay-3 mt-5 max-w-2xl text-lg leading-8 text-slate-200 sm:text-[1.14rem]">
                    Reconnect. Celebrate. Belong again.
                </p>

                <p class="animate-fade-up delay-4 mt-5 max-w-2xl text-[15.5px] leading-8 text-slate-300 sm:text-[16.5px]">
                    Join the official HSST Alumni Portal to receive announcements, discover upcoming events, register for homecoming activities, and through one trusted digital platform.
                </p>

                <div class="animate-fade-up delay-5 mt-8 flex flex-col items-start gap-3 sm:flex-row sm:flex-wrap">
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="rounded-2xl bg-indigo-500 px-7 py-3.5 text-sm font-semibold text-white shadow-[0_20px_44px_rgba(99,102,241,0.30)] transition hover:-translate-y-0.5 hover:bg-indigo-400">
                            Join the Alumni Network
                        </a>
                    @endif

                    <a href="#homecoming" class="rounded-2xl border border-white/12 bg-white/5 px-7 py-3.5 text-sm font-medium text-white transition hover:bg-white/10">
                        Explore Homecoming
                    </a>
                </div>

                <div class="animate-fade-up delay-6 mt-10 grid max-w-2xl grid-cols-1 gap-3 sm:grid-cols-3">
                    <div class="rounded-2xl border border-white/10 bg-white/5 p-4 glass-panel">
                        <div class="text-2xl font-bold tracking-[-0.03em] text-white">100K+</div>
                        <p class="mt-1 text-xs uppercase tracking-[0.18em] text-slate-400">Alumni network</p>
                    </div>

                    <div class="rounded-2xl border border-white/10 bg-white/5 p-4 glass-panel">
                        <div class="text-2xl font-bold tracking-[-0.03em] text-white">Since 1926</div>
                        <p class="mt-1 text-xs uppercase tracking-[0.18em] text-slate-400">Shared legacy</p>
                    </div>

                    <div class="rounded-2xl border border-white/10 bg-white/5 p-4 glass-panel">
                        <div class="text-2xl font-bold tracking-[-0.03em] text-white">All-in-one</div>
                        <p class="mt-1 text-xs uppercase tracking-[0.18em] text-slate-400">Portal access</p>
                    </div>
                </div>
            </div>

            <div class="animate-fade-up delay-6 lg:justify-self-end">
                <div class="relative overflow-hidden rounded-[34px] border border-white/10 bg-[linear-gradient(180deg,rgba(15,23,42,0.92)_0%,rgba(10,14,28,0.96)_100%)] shadow-[0_28px_90px_rgba(0,0,0,0.42)]">
                    <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,rgba(99,102,241,0.16),transparent_28%)]"></div>
                    <div class="relative border-b border-white/10 px-6 py-5">
                        <div class="flex items-start justify-between gap-3">
                            <div>
                                <p class="text-[11px] font-semibold uppercase tracking-[0.22em] text-indigo-200">Welcome Back</p>
                                <h3 class="mt-1 text-xl font-semibold tracking-[-0.02em] text-white">Your alumni experience starts here</h3>
                            </div>

                            <div class="flex items-center gap-2">
                                <span class="h-2.5 w-2.5 rounded-full bg-emerald-400"></span>
                                <span class="h-2.5 w-2.5 rounded-full bg-amber-300"></span>
                                <span class="h-2.5 w-2.5 rounded-full bg-indigo-400"></span>
                            </div>
                        </div>
                    </div>

                    <div class="relative grid gap-4 p-6">
                        <div class="rounded-[28px] border border-white/10 bg-white/[0.04] p-5">
                            <div class="flex items-start justify-between gap-4">
                                <div>
                                    <div class="text-[11px] font-semibold uppercase tracking-[0.18em] text-emerald-300">Grand Homecoming</div>
                                    <p class="mt-2 text-sm leading-7 text-slate-200">
                                        Celebrate a shared legacy with fellow HSSTians through reunions, updates, and school-wide alumni activities.
                                    </p>
                                </div>
                                <div class="rounded-2xl border border-emerald-400/20 bg-emerald-400/10 px-3 py-1 text-xs font-semibold text-emerald-300">
                                    Featured
                                </div>
                            </div>
                        </div>

                        <div class="grid gap-4 sm:grid-cols-2">
                            <div class="rounded-[26px] border border-white/10 bg-white/[0.04] p-5">
                                <div class="mb-3 inline-flex h-10 w-10 items-center justify-center rounded-2xl bg-indigo-500/15 text-sm font-bold text-indigo-200">
                                    01
                                </div>
                                <h4 class="text-sm font-semibold text-white">Announcements</h4>
                                <p class="mt-2 text-sm leading-7 text-slate-400">
                                    Read official school and alumni news in one trusted place.
                                </p>
                            </div>

                            <div class="rounded-[26px] border border-white/10 bg-white/[0.04] p-5">
                                <div class="mb-3 inline-flex h-10 w-10 items-center justify-center rounded-2xl bg-amber-400/15 text-sm font-bold text-amber-200">
                                    02
                                </div>
                                <h4 class="text-sm font-semibold text-white">Event Registration</h4>
                                <p class="mt-2 text-sm leading-7 text-slate-400">
                                    Join alumni celebrations and campus activities with ease.
                                </p>
                            </div>
                        </div>

                        <div class="grid gap-4 sm:grid-cols-2">
                            {{-- <div class="rounded-[26px] border border-white/10 bg-white/[0.04] p-5">
                                <div class="mb-3 inline-flex h-10 w-10 items-center justify-center rounded-2xl bg-emerald-400/15 text-sm font-bold text-emerald-200">
                                    03
                                </div>
                                <h4 class="text-sm font-semibold text-white">Proof Upload</h4>
                                <p class="mt-2 text-sm leading-7 text-slate-400">
                                    Submit payment proofs securely for school verification.
                                </p>
                            </div> --}}

                            <div class="rounded-[26px] border border-white/10 bg-white/[0.04] p-5">
                                <div class="mb-3 inline-flex h-10 w-10 items-center justify-center rounded-2xl bg-sky-400/15 text-sm font-bold text-sky-200">
                                    03
                                </div>
                                <h4 class="text-sm font-semibold text-white">Admin Review</h4>
                                <p class="mt-2 text-sm leading-7 text-slate-400">
                                    Enjoy a more organized and verified alumni workflow.
                                </p>
                            </div>
                        </div>

                        <div class="rounded-[26px] border border-white/10 bg-gradient-to-r from-indigo-500/12 via-white/[0.04] to-emerald-500/10 p-5">
                            <div class="flex items-center justify-between gap-4">
                                <div>
                                    <div class="text-[11px] font-semibold uppercase tracking-[0.18em] text-slate-300">Built for connection</div>
                                    <p class="mt-2 text-sm leading-7 text-slate-200">
                                        More than a system — a digital home for the HSST alumni family.
                                    </p>
                                </div>

                                <div class="animate-float-soft rounded-2xl border border-white/10 bg-white/5 px-4 py-2 text-sm font-semibold text-white">
                                    HSST
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
                    <div class="text-[11px] font-semibold uppercase tracking-[0.18em] text-slate-400">Community</div>
                    <p class="mt-2 text-sm leading-7 text-slate-200">
                        Celebrate a living connection between generations of alumni and the school they call home.
                    </p>
                </div>

                <div class="rounded-2xl border border-white/10 bg-[#0d1326]/80 p-5">
                    <div class="text-[11px] font-semibold uppercase tracking-[0.18em] text-slate-400">Convenience</div>
                    <p class="mt-2 text-sm leading-7 text-slate-200">
                        Access announcements, and events through one polished experience.
                    </p>
                </div>

                <div class="rounded-2xl border border-white/10 bg-[#0d1326]/80 p-5">
                    <div class="text-[11px] font-semibold uppercase tracking-[0.18em] text-slate-400">Credibility</div>
                    <p class="mt-2 text-sm leading-7 text-slate-200">
                        Receive school-managed updates and verification flows with stronger trust and organization.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- HOMECOMING -->
    <section id="homecoming" class="pt-20 lg:pt-24">
        <div class="mx-auto max-w-[1320px] px-5 md:px-6 lg:px-8">
            <div class="grid items-center gap-8 lg:grid-cols-[.92fr_1.08fr] lg:gap-14">
                <div class="relative overflow-hidden rounded-[34px] border border-white/10 bg-white/[0.04] p-4 shadow-[0_22px_70px_rgba(0,0,0,0.26)] glass-panel">
                    <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_left,rgba(99,102,241,0.10),transparent_26%)]"></div>
                    <div class="relative overflow-hidden rounded-[28px] border border-white/10 bg-[#0b1020]">
                        <img
                            src="{{ asset('images/hsstlogo.jpg') }}"
                            alt="HSST Logo"
                            class="mx-auto aspect-square w-full max-w-[460px] object-contain p-10 md:p-12"
                        >
                    </div>
                </div>

                <div>
                    <div class="mb-4 inline-flex items-center gap-2 text-[11px] font-bold uppercase tracking-[0.22em] text-indigo-200 before:h-px before:w-6 before:bg-indigo-400/50 before:content-['']">
                        Grand Alumni Homecoming
                    </div>

                    <h2 class="font-display text-[2.1rem] leading-[1.04] tracking-[-0.02em] text-white sm:text-[2.7rem] lg:text-[3.35rem]">
                        Whether you studied in 1926 or graduated in 2026,
                        <span class="text-indigo-200">you are part of our alumni family.</span>
                    </h2>

                    <p class="mt-6 max-w-2xl text-[15.5px] leading-8 text-slate-300">
                        The HSST Alumni Homecoming is a celebration of memory, belonging, and shared legacy. It is a chance to reconnect with classmates, revisit your alma mater, and take part in a growing community that continues to welcome every HSSTian home.
                    </p>

                    <div class="mt-8 grid gap-4 sm:grid-cols-2">
                        <div class="rounded-[28px] border border-white/10 bg-white/[0.04] p-5">
                            <div class="mb-2 text-sm font-semibold text-white">What to expect</div>
                            <p class="text-sm leading-7 text-slate-400">
                                Reunion moments, campus visits, announcements, featured activities, and a smoother event registration experience.
                            </p>
                        </div>

                        <div class="rounded-[28px] border border-white/10 bg-white/[0.04] p-5">
                            <div class="mb-2 text-sm font-semibold text-white">Why it matters</div>
                            <p class="text-sm leading-7 text-slate-400">
                                It strengthens alumni-school connection and gives every graduate a central space to stay informed and involved.
                            </p>
                        </div>
                    </div>

                    <div class="mt-8 flex flex-col items-start gap-3 sm:flex-row sm:flex-wrap">
                        <a href="#news" class="rounded-2xl bg-indigo-500 px-7 py-3.5 text-sm font-semibold text-white shadow-[0_18px_42px_rgba(99,102,241,0.28)] transition hover:-translate-y-0.5 hover:bg-indigo-400">
                            View Announcements
                        </a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="rounded-2xl border border-white/12 bg-white/5 px-7 py-3.5 text-sm font-medium text-white transition hover:bg-white/10">
                                Register Now
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- EXPECTATIONS / EXPERIENCE -->
    <section class="pt-16 lg:pt-20">
        <div class="mx-auto max-w-[1320px] px-5 md:px-6 lg:px-8">
            <div class="mb-10 text-center">
                <div class="mb-3 inline-flex items-center gap-2 text-[11px] font-bold uppercase tracking-[0.22em] text-emerald-200 before:h-px before:w-6 before:bg-emerald-400/50 before:content-[''] after:h-px after:w-6 after:bg-emerald-400/50 after:content-['']">
                    Homecoming Experience
                </div>

                <h2 class="font-display text-[2rem] leading-[1.05] tracking-[-0.02em] text-white sm:text-[2.45rem]">
                    A more meaningful, more organized alumni experience.
                </h2>

                <p class="mx-auto mt-4 max-w-2xl text-[15px] leading-8 text-slate-400">
                    Designed to make every HSSTian feel invited, informed, and ready to participate.
                </p>
            </div>

            <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
                <div class="rounded-[30px] border border-white/10 bg-white/[0.04] p-6 shadow-[0_12px_28px_rgba(0,0,0,0.18)] transition duration-300 hover:-translate-y-1 hover:border-indigo-400/20">
                    <div class="mb-5 flex h-12 w-12 items-center justify-center rounded-2xl border border-indigo-400/20 bg-indigo-400/10 text-sm font-bold text-indigo-200">
                        01
                    </div>
                    <h3 class="text-base font-semibold tracking-[-0.01em] text-white">Reconnect with classmates</h3>
                    <p class="mt-3 text-sm leading-7 text-slate-400">
                        Revisit friendships, memories, and stories that shaped your HSST journey.
                    </p>
                </div>

                <div class="rounded-[30px] border border-white/10 bg-white/[0.04] p-6 shadow-[0_12px_28px_rgba(0,0,0,0.18)] transition duration-300 hover:-translate-y-1 hover:border-emerald-400/20">
                    <div class="mb-5 flex h-12 w-12 items-center justify-center rounded-2xl border border-emerald-400/20 bg-emerald-400/10 text-sm font-bold text-emerald-200">
                        02
                    </div>
                    <h3 class="text-base font-semibold tracking-[-0.01em] text-white">Join school activities</h3>
                    <p class="mt-3 text-sm leading-7 text-slate-400">
                        Take part in featured events, campus-related celebrations, and alumni gatherings.
                    </p>
                </div>

                <div class="rounded-[30px] border border-white/10 bg-white/[0.04] p-6 shadow-[0_12px_28px_rgba(0,0,0,0.18)] transition duration-300 hover:-translate-y-1 hover:border-amber-300/20">
                    <div class="mb-5 flex h-12 w-12 items-center justify-center rounded-2xl border border-amber-300/20 bg-amber-300/10 text-sm font-bold text-amber-200">
                        03
                    </div>
                    <h3 class="text-base font-semibold tracking-[-0.01em] text-white">Stay updated officially</h3>
                    <p class="mt-3 text-sm leading-7 text-slate-400">
                        Receive announcements, event notices, and alumni information through a trusted channel.
                    </p>
                </div>

                <div class="rounded-[30px] border border-white/10 bg-white/[0.04] p-6 shadow-[0_12px_28px_rgba(0,0,0,0.18)] transition duration-300 hover:-translate-y-1 hover:border-sky-400/20">
                    <div class="mb-5 flex h-12 w-12 items-center justify-center rounded-2xl border border-sky-400/20 bg-sky-400/10 text-sm font-bold text-sky-200">
                        04
                    </div>
                    <h3 class="text-base font-semibold tracking-[-0.01em] text-white">Complete tasks online</h3>
                    <p class="mt-3 text-sm leading-7 text-slate-400">
                        Register, upload proof of payment, and monitor important school-managed flows more easily.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- FEATURES -->
    <section id="features" class="pt-20 lg:pt-24">
        <div class="mx-auto max-w-[1320px] px-5 md:px-6 lg:px-8">
            <div class="mb-12 grid items-end gap-6 lg:grid-cols-[1.15fr_.85fr] lg:gap-14">
                <div>
                    <div class="mb-4 inline-flex items-center gap-2 text-[11px] font-bold uppercase tracking-[0.22em] text-indigo-200 before:h-px before:w-6 before:bg-indigo-400/50 before:content-['']">
                        Platform Features
                    </div>

                    <h2 class="font-display text-[2rem] leading-[1.05] tracking-[-0.02em] text-white sm:text-[2.55rem] lg:text-[3.05rem]">
                        Built for real alumni participation,
                        <span class="text-indigo-200">not just information display.</span>
                    </h2>
                </div>

                <p class="max-w-[560px] text-[15px] leading-8 text-slate-400">
                    The platform helps HSST organize communication and simplify event participation in one refined and reliable system.
                </p>
            </div>

            <div class="grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-4">
                <div class="group rounded-[32px] border border-white/10 bg-white/[0.04] p-6 shadow-[0_12px_28px_rgba(0,0,0,0.18)] transition duration-300 hover:-translate-y-1 hover:border-indigo-400/20">
                    <div class="mb-5 flex h-12 w-12 items-center justify-center rounded-2xl border border-indigo-400/20 bg-indigo-400/10 text-sm font-bold text-indigo-200">
                        01
                    </div>
                    <h3 class="text-base font-semibold tracking-[-0.01em] text-white">Official Announcements</h3>
                    <p class="mt-3 text-sm leading-7 text-slate-400">
                        Publish trusted school and alumni updates in a clearer, more visible communication channel.
                    </p>
                </div>

                <div class="group rounded-[32px] border border-white/10 bg-white/[0.04] p-6 shadow-[0_12px_28px_rgba(0,0,0,0.18)] transition duration-300 hover:-translate-y-1 hover:border-emerald-400/20">
                    <div class="mb-5 flex h-12 w-12 items-center justify-center rounded-2xl border border-emerald-400/20 bg-emerald-400/10 text-sm font-bold text-emerald-200">
                        02
                    </div>
                    <h3 class="text-base font-semibold tracking-[-0.01em] text-white">Event Registration</h3>
                    <p class="mt-3 text-sm leading-7 text-slate-400">
                        Make reunions, alumni celebrations, and participation flows easier to understand and complete.
                    </p>
                </div>

                <div class="group rounded-[32px] border border-white/10 bg-white/[0.04] p-6 shadow-[0_12px_28px_rgba(0,0,0,0.18)] transition duration-300 hover:-translate-y-1 hover:border-amber-300/20">
                    <div class="mb-5 flex h-12 w-12 items-center justify-center rounded-2xl border border-amber-300/20 bg-amber-300/10 text-sm font-bold text-amber-200">
                        03
                    </div>
                    <h3 class="text-base font-semibold tracking-[-0.01em] text-white">Payment Proof Upload</h3>
                    <p class="mt-3 text-sm leading-7 text-slate-400">
                        Support upload-based proof submission for registrations and alumni-related transactions.
                    </p>
                </div>

                <div class="group rounded-[32px] border border-white/10 bg-white/[0.04] p-6 shadow-[0_12px_28px_rgba(0,0,0,0.18)] transition duration-300 hover:-translate-y-1 hover:border-sky-400/20">
                    <div class="mb-5 flex h-12 w-12 items-center justify-center rounded-2xl border border-sky-400/20 bg-sky-400/10 text-sm font-bold text-sky-200">
                        04
                    </div>
                    <h3 class="text-base font-semibold tracking-[-0.01em] text-white">Admin Verification</h3>
                    <p class="mt-3 text-sm leading-7 text-slate-400">
                        Give administrators a cleaner workflow for reviewing submissions and organizing alumni participation.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- HOW IT WORKS -->
    <section id="how-it-works" class="pt-20 lg:pt-24">
        <div class="mx-auto max-w-[1320px] px-5 md:px-6 lg:px-8">
            <div class="mb-10 text-center">
                <div class="mb-3 inline-flex items-center gap-2 text-[11px] font-bold uppercase tracking-[0.22em] text-emerald-200 before:h-px before:w-6 before:bg-emerald-400/50 before:content-[''] after:h-px after:w-6 after:bg-emerald-400/50 after:content-['']">
                    How It Works
                </div>
                <h2 class="font-display text-[2rem] leading-[1.05] tracking-[-0.02em] text-white sm:text-[2.45rem]">
                    Simple enough for every HSST alumni user.
                </h2>
                <p class="mx-auto mt-4 max-w-2xl text-[15px] leading-8 text-slate-400">
                    The platform is built to make participation easy from the very first visit.
                </p>
            </div>

            <div class="grid gap-4 lg:grid-cols-3">
                <div class="rounded-[30px] border border-white/10 bg-white/[0.04] p-6 shadow-[0_12px_28px_rgba(0,0,0,0.18)]">
                    <div class="mb-4 inline-flex h-11 w-11 items-center justify-center rounded-2xl bg-indigo-500 text-sm font-bold text-white">
                        1
                    </div>
                    <h3 class="text-base font-semibold text-white">Create an account</h3>
                    <p class="mt-3 text-sm leading-7 text-slate-400">
                        Register securely as an HSST alumni and access the portal with ease.
                    </p>
                </div>

                <div class="rounded-[30px] border border-white/10 bg-white/[0.04] p-6 shadow-[0_12px_28px_rgba(0,0,0,0.18)]">
                    <div class="mb-4 inline-flex h-11 w-11 items-center justify-center rounded-2xl bg-emerald-400 text-sm font-bold text-[#07101f]">
                        2
                    </div>
                    <h3 class="text-base font-semibold text-white">Browse updates</h3>
                    <p class="mt-3 text-sm leading-7 text-slate-400">
                        Read announcements, featured activities, and school-managed alumni posts.
                    </p>
                </div>

                <div class="rounded-[30px] border border-white/10 bg-white/[0.04] p-6 shadow-[0_12px_28px_rgba(0,0,0,0.18)]">
                    <div class="mb-4 inline-flex h-11 w-11 items-center justify-center rounded-2xl bg-amber-300 text-sm font-bold text-[#07101f]">
                        3
                    </div>
                    <h3 class="text-base font-semibold text-white">Join events</h3>
                    <p class="mt-3 text-sm leading-7 text-slate-400">
                        Register for homecoming, reunions, and alumni activities more clearly and quickly.
                    </p>
                </div>

                {{-- <div class="rounded-[30px] border border-white/10 bg-white/[0.04] p-6 shadow-[0_12px_28px_rgba(0,0,0,0.18)]">
                    <div class="mb-4 inline-flex h-11 w-11 items-center justify-center rounded-2xl bg-sky-400 text-sm font-bold text-[#07101f]">
                        4
                    </div>
                    <h3 class="text-base font-semibold text-white">Upload proof of payment</h3>
                    <p class="mt-3 text-sm leading-7 text-slate-400">
                        Submit payment proof for review and wait for admin verification inside the system.
                    </p>
                </div> --}}
            </div>
        </div>
    </section>

    <!-- WHY THIS PORTAL MATTERS -->
    <section class="pt-20">
        <div class="mx-auto max-w-[1320px] px-5 md:px-6 lg:px-8">
            <div class="overflow-hidden rounded-[36px] border border-white/10 bg-white/[0.04] p-8 shadow-[0_18px_54px_rgba(0,0,0,0.22)] glass-panel sm:p-10 lg:p-12">
                <div class="grid gap-8 lg:grid-cols-[1.1fr_.9fr] lg:items-center">
                    <div>
                        <div class="mb-3 text-[11px] font-bold uppercase tracking-[0.20em] text-indigo-200/90">
                            Why this portal matters
                        </div>
                        <h2 class="font-display text-[1.95rem] leading-[1.08] tracking-[-0.02em] text-white sm:text-[2.35rem] lg:text-[2.95rem]">
                            A better digital home for the school and its graduates.
                        </h2>
                        <p class="mt-4 max-w-2xl text-[15px] leading-8 text-slate-300">
                            Instead of scattered updates and manual coordination, HSST now has one organized space for alumni communication, homecoming participation, and stronger long-term connection.
                        </p>
                    </div>

                    <div class="grid gap-4 sm:grid-cols-2">
                        <div class="rounded-3xl border border-white/10 bg-[#0c1224]/80 p-5">
                            <div class="text-sm font-semibold text-white">Centralized communication</div>
                            <p class="mt-2 text-sm leading-7 text-slate-400">One source for updates, events, and school-managed public information.</p>
                        </div>
                        <div class="rounded-3xl border border-white/10 bg-[#0c1224]/80 p-5">
                            <div class="text-sm font-semibold text-white">Cleaner participation flow</div>
                            <p class="mt-2 text-sm leading-7 text-slate-400">Help alumni understand what to do, where to go, and how to join.</p>
                        </div>
                        <div class="rounded-3xl border border-white/10 bg-[#0c1224]/80 p-5">
                            <div class="text-sm font-semibold text-white">Better admin control</div>
                            <p class="mt-2 text-sm leading-7 text-slate-400">Support review, organization, and verification inside one platform.</p>
                        </div>
                        <div class="rounded-3xl border border-white/10 bg-[#0c1224]/80 p-5">
                            <div class="text-sm font-semibold text-white">Stronger alumni identity</div>
                            <p class="mt-2 text-sm leading-7 text-slate-400">Build a more visible and lasting connection across generations of HSSTians.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- NEWS -->
    <section id="news" class="pt-20 lg:pt-24">
        <div class="mx-auto max-w-[1320px] px-5 md:px-6 lg:px-8">
            <div class="mb-8 flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
                <div class="max-w-2xl">
                    <div class="mb-3 inline-flex items-center gap-2 text-[11px] font-bold uppercase tracking-[0.22em] text-indigo-200 before:h-px before:w-6 before:bg-indigo-400/50 before:content-['']">
                        Latest News & Events
                    </div>
                    <h2 class="font-display text-[2rem] leading-[1.05] tracking-[-0.02em] text-white sm:text-[2.45rem]">
                        Stay informed with the latest official updates.
                    </h2>
                </div>

                <p class="max-w-[560px] text-[15px] leading-8 text-slate-400">
                    Browse announcements, featured activities, and alumni events from Holy Spirit School of Tagbilaran.
                </p>
            </div>

            <livewire:public-announcements/>
        </div>
    </section>

    <!-- FINAL CTA -->
    <section class="py-20 lg:py-24">
        <div class="mx-auto max-w-[1320px] px-5 md:px-6 lg:px-8">
            <div class="relative overflow-hidden rounded-[38px] border border-white/10 bg-[linear-gradient(135deg,rgba(79,70,229,0.18),rgba(15,23,42,0.88),rgba(16,185,129,0.10))] p-8 shadow-[0_20px_60px_rgba(0,0,0,0.24)] glass-panel sm:p-10 lg:p-14">
                <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,rgba(255,255,255,0.10),transparent_24%)]"></div>
                <div class="absolute -right-14 -top-14 h-40 w-40 rounded-full bg-indigo-400/20 blur-3xl"></div>
                <div class="absolute -left-10 bottom-0 h-32 w-32 rounded-full bg-emerald-400/10 blur-3xl"></div>

                <div class="relative z-10 grid items-center gap-8 lg:grid-cols-[1.25fr_.75fr] lg:gap-12">
                    <div>
                        <div class="mb-3 text-[11px] font-bold uppercase tracking-[0.20em] text-indigo-100/90">
                            Join the HSST network
                        </div>

                        <h2 class="font-display text-[2rem] leading-[1.06] tracking-[-0.02em] text-white sm:text-[2.4rem] lg:text-[3rem]">
                            Ready to come home and reconnect with HSST?
                        </h2>

                        <p class="mt-4 max-w-2xl text-[15px] leading-8 text-slate-200">
                            Create your account to receive updates, and participate in alumni activities through one secure school-managed platform.
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
        <div class="mx-auto grid max-w-[1320px] grid-cols-1 gap-10 px-5 py-12 md:px-6 lg:grid-cols-[1.3fr_.8fr_.8fr] lg:gap-14 lg:px-8 lg:py-16">
            <div>
                <a href="{{ route('home') }}" class="flex items-center gap-3">
                    <div class="h-11 w-11 shrink-0 overflow-hidden rounded-2xl border border-white/10 bg-white p-[4px]">
                        <img
                            src="{{ asset('images/hsstlogo.jpg') }}"
                            alt="HSST Logo"
                            class="h-full w-full rounded-xl object-contain"
                        >
                    </div>

                    <div>
                        <span class="block text-[10px] font-semibold uppercase leading-none tracking-[0.24em] text-emerald-300/90">
                            Official Alumni Portal
                        </span>
                        <span class="mt-1 block text-[15px] font-semibold leading-[1.2] tracking-[-0.01em] text-white">
                            Holy Spirit School of Tagbilaran
                        </span>
                    </div>
                </a>

                <p class="mt-5 max-w-[380px] text-[14px] leading-7 text-slate-400">
                    A modern digital home for official announcements, alumni participation, event registration, and stronger school-community connection.
                </p>

                <p class="mt-4 text-sm text-slate-500">
                    Managed by HSST Administration &amp; Alumni Office
                </p>
            </div>

            <div>
                <div class="mb-4 text-[11px] font-bold uppercase tracking-[0.18em] text-slate-500">Quick Links</div>
                <div class="space-y-3">
                    {{-- <a href="{{ route('home') }}" class="block text-[14px] text-slate-300 transition hover:text-white">Home</a> --}}
                    {{-- <a href="{{ route('about-us') }}" class="block text-[14px] text-slate-300 transition hover:text-white">About Us</a> --}}
                    <a href="#homecoming" class="block text-[14px] text-slate-300 transition hover:text-white">Homecoming</a>
                    <a href="#features" class="block text-[14px] text-slate-300 transition hover:text-white">Features</a>
                    <a href="#how-it-works" class="block text-[14px] text-slate-300 transition hover:text-white">How It Works</a>
                    <a href="#news" class="block text-[14px] text-slate-300 transition hover:text-white">News & Events</a>
                </div>
            </div>

            <div>
                <div class="mb-4 text-[11px] font-bold uppercase tracking-[0.18em] text-slate-500">Account</div>
                <div class="space-y-3">
                    @if (Route::has('login'))
                        <a href="{{ route('login') }}" class="block text-[14px] text-slate-300 transition hover:text-white">Log in</a>
                    @endif

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="block text-[14px] text-slate-300 transition hover:text-white">Register</a>
                    @endif

                    <a href="{{ url('/dashboard') }}" class="block text-[14px] text-slate-300 transition hover:text-white">Dashboard</a>
                </div>
            </div>
        </div>

        <div class="mx-auto flex max-w-[1320px] flex-col gap-2 border-t border-white/10 px-5 py-5 text-sm text-slate-500 md:flex-row md:items-center md:justify-between md:px-6 lg:px-8">
            <p>© 2026 Holy Spirit School of Tagbilaran. All rights reserved.</p>
            <p>Truth in Love · Faith · Learning · Community</p>
        </div>
    </footer>
</div>
</body>
</html>