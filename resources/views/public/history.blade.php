<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>HSST Events | Holy Spirit School of Tagbilaran</title>

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

        .eyebrow {
            font-size: 11px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.24em;
        }

        .gold-line {
            width: 52px;
            height: 3px;
            border-radius: 999px;
            background: linear-gradient(90deg, #c4960a, #e8b80f);
        }

        .section-shell {
            border: 1px solid rgba(30, 58, 138, 0.10);
            background: #ffffff;
            box-shadow: 0 18px 48px rgba(15, 42, 107, 0.08);
        }

        .soft-panel {
            border: 1px solid rgba(30, 58, 138, 0.10);
            background: #f8fbff;
        }

        .royal-card {
            border: 1px solid rgba(30, 58, 138, 0.10);
            background: #ffffff;
            transition: transform .28s ease, box-shadow .28s ease, border-color .28s ease;
        }

        .royal-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 50px rgba(15, 42, 107, 0.10);
            border-color: rgba(30, 58, 138, 0.18);
        }

        .hero-glow::before {
            content: "";
            position: absolute;
            inset: 0;
            background:
                radial-gradient(circle at 82% 18%, rgba(255,255,255,0.16), transparent 22%),
                radial-gradient(circle at 78% 30%, rgba(147,197,253,0.18), transparent 28%);
            pointer-events: none;
        }

        .event-image-overlay {
            background: linear-gradient(
                180deg,
                rgba(9,24,82,0.06) 0%,
                rgba(9,24,82,0.18) 40%,
                rgba(9,24,82,0.76) 100%
            );
        }

        .nav-link {
            color: rgba(255,255,255,.78);
            transition: color .2s ease, background .2s ease;
        }

        .nav-link:hover {
            color: #fff;
            background: rgba(255,255,255,.08);
        }

        .nav-link-active {
            background: #fff;
            color: #0F2A6B;
        }

        .hero-pattern {
            position: absolute;
            inset: 0;
            background-image:
                radial-gradient(circle at 20% 25%, rgba(255,255,255,.08) 1px, transparent 1px),
                radial-gradient(circle at 80% 70%, rgba(255,255,255,.07) 1px, transparent 1px);
            background-size: 42px 42px, 52px 52px;
            opacity: .35;
            pointer-events: none;
        }
    </style>
</head>
<body class="overflow-x-hidden bg-white font-body text-slate-800 antialiased">
<div x-data="{ mobileOpen:false }" class="min-h-screen">

    {{-- HEADER --}}
    <header class="sticky inset-x-0 top-0 z-50 border-b border-white/10 bg-[rgba(9,24,82,0.92)] backdrop-blur-md">
        <div class="mx-auto flex h-[78px] max-w-[1380px] items-center justify-between px-4 sm:px-6 lg:px-8">
            <a href="{{ route('home') }}" class="flex min-w-0 items-center gap-3 transition hover:opacity-95">
                <div class="flex h-11 w-11 shrink-0 items-center justify-center overflow-hidden rounded border border-white/18 bg-white p-1 shadow-sm">
                    <img
                        src="{{ asset('images/hsstlogo.jpg') }}"
                        alt="Holy Spirit School of Tagbilaran Logo"
                        class="h-full w-full object-contain"
                    >
                </div>

                <div class="min-w-0">
                    <p class="text-[9px] font-extrabold uppercase tracking-[0.28em] text-white/70">
                        Official Alumni Portal
                    </p>
                    <h1 class="truncate text-[13px] font-bold text-white">
                        Holy Spirit School of Tagbilaran
                    </h1>
                </div>
            </a>

            <nav class="hidden items-center gap-2 lg:flex">
                <a href="{{ route('home') }}" class="nav-link rounded px-4 py-2 text-sm font-semibold">
                    Home
                </a>
                <a href="{{ route('about-us') }}" class="nav-link rounded px-4 py-2 text-sm font-semibold">
                    About
                </a>
                <a href="{{ route('events.index') }}" class="nav-link rounded px-4 py-2 text-sm font-bold">
                    Events
                </a>
                 <a href="{{ route('history') }}" class="nav-link-active rounded px-4 py-2 text-sm font-bold">
                History
            </a>
                <a href="#event-calendar" class="nav-link rounded px-4 py-2 text-sm font-semibold">
                    Calendar
                </a>
                <a href="#upcoming-events" class="nav-link rounded px-4 py-2 text-sm font-semibold">
                    Upcoming
                </a>
            </nav>

            <div class="hidden items-center gap-3 lg:flex">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="inline-flex items-center justify-center rounded bg-white px-5 py-2.5 text-sm font-bold text-[#0F2A6B] transition hover:bg-[#f3f6ff]">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="inline-flex items-center justify-center rounded border border-white/20 bg-white/10 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-white/15">
                            Log in
                        </a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="inline-flex items-center justify-center rounded bg-white px-5 py-2.5 text-sm font-bold text-[#0F2A6B] transition hover:bg-[#f3f6ff]">
                                Register
                            </a>
                        @endif
                    @endauth
                @endif
            </div>

            <button
                @click="mobileOpen = !mobileOpen"
                :class="mobileOpen ? 'hamburger-open' : ''"
                class="flex flex-col gap-[4.5px] rounded border border-white/20 bg-white/10 p-3 lg:hidden"
                aria-label="Toggle Menu"
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
        x-transition.opacity.duration.250ms
        class="fixed inset-0 z-[60] bg-[#153e75] lg:hidden"
    >
        <div class="flex h-full flex-col text-white">
            <div class="flex items-center justify-between border-b border-white/10 px-6 py-5">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.22em] text-white/70">
                        Menu
                    </p>
                    <h2 class="mt-1 text-lg font-bold text-white">
                        HSST Events
                    </h2>
                </div>

                <button
                    type="button"
                    @click="mobileOpen = false"
                    class="inline-flex h-11 w-11 items-center justify-center rounded border border-white/15 text-white transition hover:bg-white/10"
                >
                    ✕
                </button>
            </div>

            <div class="flex-1 overflow-y-auto px-6 py-6">
                <nav class="flex flex-col">
                    <a @click="mobileOpen=false" href="{{ route('home') }}" class="border-b border-white/10 py-4 text-base font-semibold text-white/90">Home</a>
                    <a @click="mobileOpen=false" href="{{ route('about-us') }}" class="border-b border-white/10 py-4 text-base font-semibold text-white/90">About</a>
                    <a @click="mobileOpen=false" href="{{ route('events.index') }}" class="border-b border-white/10 py-4 text-base font-semibold text-white">Events</a>
                    <a @click="mobileOpen=false" href="#event-calendar" class="border-b border-white/10 py-4 text-base font-semibold text-white/90">Calendar</a>
                     <a @click="mobileOpen=false" href="{{ route('history') }}" class="border-b border-white/10 py-4 text-base font-semibold text-white/90">
                History
            </a>
                    <a @click="mobileOpen=false" href="#upcoming-events" class="py-4 text-base font-semibold text-white/90">Upcoming</a>
                </nav>
            </div>

            @if (Route::has('login'))
                <div class="border-t border-white/10 px-6 py-6">
                    <div class="grid gap-3">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="block rounded-xl bg-white px-4 py-4 text-center text-base font-bold text-[#153e75]">
                                Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="block rounded-xl border border-white/20 bg-white/10 px-4 py-4 text-center text-base font-semibold text-white">
                                Log in
                            </a>

                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="block rounded-xl bg-white px-4 py-4 text-center text-base font-bold text-[#153e75]">
                                    Register
                                </a>
                            @endif
                        @endauth
                    </div>
                </div>
            @endif
        </div>
    </div>
<div class="min-h-screen bg-[#f8fbff] text-[#10224f]">


<section class="relative overflow-hidden bg-[#0f2a6b] text-white
                sm:mx-auto sm:mt-6 sm:max-w-5xl sm:rounded-[1.75rem] sm:shadow-[0_20px_50px_rgba(15,42,107,0.25)]">

    <!-- background image -->
    <div class="absolute inset-0 sm:rounded-[1.75rem] overflow-hidden">
        <img
            src="{{ asset('images/hsstherosect.png') }}"
            alt="Holy Spirit School of Tagbilaran"
            class="h-full w-full object-cover object-center"
        >

        <div class="absolute inset-0 bg-[linear-gradient(135deg,rgba(9,24,82,0.88)_0%,rgba(21,62,117,0.76)_48%,rgba(31,79,196,0.68)_100%)]"></div>
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,rgba(255,255,255,0.10),transparent_28%)]"></div>
    </div>

    <!-- content -->
    <div class="relative mx-auto max-w-5xl px-4 py-12 sm:px-8 sm:py-16 lg:py-20">
        <div class="max-w-3xl">
            <p class="text-[12px] font-bold uppercase tracking-[0.24em] text-[#d7b24a]">
                Est. 1926
            </p>

            <h2 class="mt-3 font-serif text-3xl font-bold leading-tight sm:text-4xl lg:text-5xl">
                A century of faith,
                learning, and service
            </h2>

            <p class="mt-5 max-w-2xl text-base leading-8 text-white/85 sm:text-lg sm:leading-9">
                From a humble dormitory for girls in Tagbilaran to a thriving institution that continues
                to shape lives, Holy Spirit School of Tagbilaran carries a legacy built on mission,
                excellence, and love for community.
            </p>
        </div>
    </div>
</section>
{{-- Quick facts --}}
<section class="border-b border-[#e4ecff] bg-white">
    <div class="mx-auto max-w-5xl px-4 py-6 sm:px-6 sm:py-8">
        <div class="grid grid-cols-1 gap-0 sm:gap-4 sm:grid-cols-3">
            <div class="border-b border-[#e4ecff] bg-white px-0 py-5 sm:rounded-2xl sm:border sm:border-[#dfe8ff] sm:bg-[#f8fbff] sm:p-5">
                <p class="text-sm font-semibold uppercase tracking-[0.16em] text-[#3559c7]">Founded</p>
                <p class="mt-2 text-2xl font-extrabold text-[#091852]">1926</p>
            </div>

            <div class="border-b border-[#e4ecff] bg-white px-0 py-5 sm:rounded-2xl sm:border sm:border-[#dfe8ff] sm:bg-[#f8fbff] sm:p-5">
                <p class="text-sm font-semibold uppercase tracking-[0.16em] text-[#3559c7]">Location</p>
                <p class="mt-2 text-xl font-extrabold text-[#091852]">Tagbilaran City, Bohol</p>
            </div>

            <div class="bg-white px-0 py-5 sm:rounded-2xl sm:border sm:border-[#dfe8ff] sm:bg-[#f8fbff] sm:p-5">
                <p class="text-sm font-semibold uppercase tracking-[0.16em] text-[#3559c7]">Current Name</p>
                <p class="mt-2 text-xl font-extrabold text-[#091852]">HSST, Inc.</p>
            </div>
        </div>
    </div>
</section>

{{-- Story content --}}
<section class="bg-[#f8fbff]">
    <div class="mx-auto max-w-4xl px-4 py-10 sm:px-6 sm:py-14 lg:py-16">

        <div class="border-0 bg-transparent p-0 shadow-none sm:rounded-[1.75rem] sm:border sm:border-[#dfe8ff] sm:bg-white sm:p-8 sm:shadow-[0_18px_45px_rgba(15,42,107,0.06)] lg:p-10">
            <div class="mb-8">
                <p class="text-sm font-bold uppercase tracking-[0.22em] text-[#3559c7]">
                    Short History
                </p>
                <div class="mt-3 h-1 w-16 rounded-full bg-[#d7b24a]"></div>
            </div>

            <div class="space-y-6 text-[17px] leading-9 text-[#243a69] sm:text-[18px] sm:leading-10">
                <p>
                    “That old sleepy town” aptly describes Tagbilaran circa 1926. It was truly a small,
                    nondescript town with only one main thoroughfare leading to Plaza Rizal with the
                    Gobierno fronting it. Just a stone’s throw away was the old stone church where
                    San Jose was venerated as its Patron Saint.
                </p>

                <p>
                    Holy Spirit School of Tagbilaran is one link in the chain of educational institutions
                    owned and operated by the Mission Congregation of the Servants of the Holy Spirit (SSpS)
                    all over the world. It was founded in 1926 by the late Msgr. Gelacio Ramirez, a diocesan
                    priest. It started as a dormitory to shelter girls who were studying in Bohol National
                    High School. Like a mustard seed which grew into a tree, it developed until it reached
                    the stature that it has today.
                </p>

                <p>
                    On October 16, 1926, on the feast of Nuestra Señora del Pilar, the first three SSpS Sisters
                    — Sr. Laeticia, Sr. Blasia, and Sr. Josaphata — arrived in Tagbilaran. This was in answer
                    to the request made by Father Gelacio Ramirez for the SSpS Sisters to work in his parish
                    in Tagbilaran, Bohol.
                </p>

                <p>
                    Realizing the missionary zeal of the three pioneer Sisters, Father Ramirez helped them open
                    a Kindergarten with 19 enrollees on November 1. This was the humble beginning of the
                    elementary and high school which soon followed. The school was called Saint Joseph’s Academy
                    in honor of the Patron of Tagbilaran. With a total of forty-nine learners, the school year
                    began in 1927–1928.
                </p>

                <p>
                    The following year, 1928–1929, brought in more than two hundred learners from Kindergarten
                    to Grade Seven and First Year High School. Enrollment consistently increased every year until
                    the outbreak of the war, when it reached five hundred sixty-six. Classes were temporarily
                    suspended during the war years and resumed on June 4, 1945 after World War II.
                </p>

                <p>
                    Post-World War II saw a big stride in the development of Saint Joseph’s Academy. A permit
                    to offer a two-year course leading to the title of Elementary Teacher’s Certificate was
                    obtained from the Bureau of Private Schools. Consequently, the school name changed from
                    Saint Joseph’s Academy to Saint Joseph’s Junior College in July 1950.
                </p>

                <p>
                    The early fifties witnessed the beginning of college courses in Music, Education, and
                    Liberal Arts. Accordingly, the façade of the school got a new look with the signboard
                    Saint Joseph’s College in July 1957, and later College of the Holy Spirit in July 1965.
                </p>

                <p>
                    In 1974, the college department was phased out. Thus, in the next school year, the name
                    of the school was changed to Holy Spirit School.
                </p>

                <p>
                    The school celebrated its Golden Jubilee in October 1976 and its Diamond Jubilee in July 2001.
                </p>

                <p>
                    In 2005–2006, Holy Spirit School fully bloomed in its gender advocacy in the province of
                    Bohol. In 2007–2008, the HSS WINGS structure and program was elevated to the province level.
                </p>

                <p>
                    In July 2013, the school name changed from Holy Spirit School to Holy Spirit School of
                    Tagbilaran (HSST), Inc.
                </p>

                <p>
                    Holy Spirit School of Tagbilaran, with separate Grade School and High School, underwent its
                    first survey visit as an Integrated Basic Education Program in January 2015. This took place
                    more than two and a half years after the expiration of its re-accreditation status in 2012,
                    due to major problems involving ownership of the school corporation, the buildings and lot,
                    as well as damage caused by the October 2013 earthquake.
                </p>

                <p>
                    As part of its continuing mission to provide a conducive atmosphere for meaningful teaching
                    and learning, Holy Spirit School of Tagbilaran acquired a new three-hectare site located
                    at J.A. Clarin, Purok 3, Dao District, Tagbilaran City.
                </p>

                <p>
                    The Nursery, Kindergarten 1, Kindergarten 2, and Grade School Department transferred to the
                    new school site on January 11, 2016, while the Junior High School continued classes in the
                    old campus on Remolador Street.
                </p>

                <p>
                    During school year 2016–2017, the whole school population was fully transferred to the new
                    school location with the completion of two school buildings.
                </p>

                <p>
                    In the same school year, the new Senior High School as part of the basic education program
                    was opened. The Academic Track offered Accountancy, Business and Management (ABM), General
                    Academic Strand (GAS), and Science, Technology, Engineering, and Mathematics (STEM).
                </p>

                <p>
                    In February 2018, the Junior and Senior High School building was completed, and the transfer
                    of learners to the high school building took place in the first week of March 2018.
                </p>
            </div>
        </div>
    </div>
</section>

{{-- Timeline --}}
<section class="bg-white">
    <div class="mx-auto max-w-5xl px-4 py-10 sm:px-6 sm:py-14 lg:py-16">
        <div class="mb-8">
            <p class="text-sm font-bold uppercase tracking-[0.22em] text-[#3559c7]">
                Timeline of Names
            </p>
            <h3 class="mt-3 text-2xl font-extrabold text-[#091852] sm:text-3xl">
                The institution through the years
            </h3>
        </div>

        <div class="space-y-0 sm:space-y-4">
            <div class="border-b border-[#e4ecff] bg-white px-0 py-5 sm:rounded-2xl sm:border sm:border-[#dfe8ff] sm:bg-[#f8fbff] sm:p-5">
                <p class="text-sm font-bold uppercase tracking-[0.18em] text-[#3559c7]">1926</p>
                <h4 class="mt-2 text-xl font-extrabold text-[#091852]">Saint Joseph’s Academy (S.J.A.)</h4>
                <p class="mt-2 text-[16px] leading-8 text-[#344b78]">Grade School – 1926</p>
                <p class="text-[16px] leading-8 text-[#344b78]">High School – 1928</p>
            </div>

            <div class="border-b border-[#e4ecff] bg-white px-0 py-5 sm:rounded-2xl sm:border sm:border-[#dfe8ff] sm:bg-[#f8fbff] sm:p-5">
                <p class="text-sm font-bold uppercase tracking-[0.18em] text-[#3559c7]">July 1950</p>
                <h4 class="mt-2 text-xl font-extrabold text-[#091852]">Saint Joseph’s Junior College (S.J.J.C.)</h4>
            </div>

            <div class="border-b border-[#e4ecff] bg-white px-0 py-5 sm:rounded-2xl sm:border sm:border-[#dfe8ff] sm:bg-[#f8fbff] sm:p-5">
                <p class="text-sm font-bold uppercase tracking-[0.18em] text-[#3559c7]">July 1957</p>
                <h4 class="mt-2 text-xl font-extrabold text-[#091852]">Saint Joseph’s College (S.J.C.)</h4>
            </div>

            <div class="border-b border-[#e4ecff] bg-white px-0 py-5 sm:rounded-2xl sm:border sm:border-[#dfe8ff] sm:bg-[#f8fbff] sm:p-5">
                <p class="text-sm font-bold uppercase tracking-[0.18em] text-[#3559c7]">July 1965</p>
                <h4 class="mt-2 text-xl font-extrabold text-[#091852]">College of the Holy Spirit (C.H.S.)</h4>
            </div>

            <div class="border-b border-[#e4ecff] bg-white px-0 py-5 sm:rounded-2xl sm:border sm:border-[#dfe8ff] sm:bg-[#f8fbff] sm:p-5">
                <p class="text-sm font-bold uppercase tracking-[0.18em] text-[#3559c7]">July 1974</p>
                <h4 class="mt-2 text-xl font-extrabold text-[#091852]">Holy Spirit School (H.S.S.)</h4>
            </div>

            <div class="bg-white px-0 py-5 sm:rounded-2xl sm:border sm:border-[#dfe8ff] sm:bg-[#f8fbff] sm:p-5">
                <p class="text-sm font-bold uppercase tracking-[0.18em] text-[#3559c7]">July 2013</p>
                <h4 class="mt-2 text-xl font-extrabold text-[#091852]">Holy Spirit School of Tagbilaran (H.S.S.T.) Inc.</h4>
            </div>
        </div>
    </div>
</section>

{{-- Bottom CTA --}}
<section class="bg-[#0f2a6b] text-white sm:mx-auto sm:mb-8 sm:max-w-5xl sm:rounded-[1.75rem] sm:shadow-[0_20px_50px_rgba(15,42,107,0.25)]">
    <div class="mx-auto max-w-5xl px-4 py-10 text-center sm:px-6 sm:py-14">
        <h3 class="text-2xl font-extrabold leading-tight text-white sm:text-3xl">
            Once a Crusader, always a Crusader
        </h3>

        <p class="mx-auto mt-4 max-w-2xl text-base leading-8 text-white/80 sm:text-lg">
            Thank you for being part of the continuing story of Holy Spirit School of Tagbilaran.
        </p>

        <div class="mt-7 flex flex-col items-center justify-center gap-3 sm:flex-row">
            <a
                href="{{ url('/') }}"
                class="inline-flex items-center justify-center rounded-full bg-[#d7b24a] px-6 py-3 text-sm font-bold uppercase tracking-[0.16em] text-white transition hover:bg-[#c29d35]"
            >
                Back to Home
            </a>

            <a
                href="{{ route('register') }}"
                class="inline-flex items-center justify-center rounded-full border border-white/20 px-6 py-3 text-sm font-bold uppercase tracking-[0.16em] text-white transition hover:bg-white/10"
            >
                Join the Community
            </a>
        </div>
    </div>
</section>
  
</div>

    {{-- FOOTER --}}
    <footer id="contact" class="bg-[#091852] pt-16 pb-8">
        <div class="mx-auto grid max-w-[1380px] gap-10 px-4 sm:px-6 lg:grid-cols-[1.2fr_0.8fr_0.8fr] lg:px-8">
            <div>
                <div class="flex items-center gap-3">
                    <div class="flex h-11 w-11 items-center justify-center overflow-hidden rounded border border-white/15 bg-white p-1 shadow-sm">
                        <img src="{{ asset('images/hsstlogo.jpg') }}" alt="HSST Logo" class="h-full w-full object-contain">
                    </div>
                    <div>
                        <p class="text-xs font-extrabold uppercase tracking-[0.2em] text-white/65">Official Alumni Portal</p>
                        <p class="text-base font-bold text-white">Holy Spirit School of Tagbilaran</p>
                    </div>
                </div>

                <p class="mt-5 max-w-md text-sm leading-7 text-white/55">
                    A digital home for official announcements, school events, alumni activities, and meaningful community connection at Holy Spirit School of Tagbilaran.
                </p>
            </div>

            <div>
                <h4 class="text-sm font-extrabold uppercase tracking-[0.2em] text-white/70">Quick links</h4>
                <div class="mt-4 flex flex-col gap-3 text-sm text-white/55">
                    <a href="{{ route('home') }}" class="transition hover:text-white">Home</a>
                    {{-- <a href="{{ route('about-us') }}" class="transition hover:text-white">About Us</a> --}}
                    <a href="{{ route('events.index') }}" class="transition hover:text-white">Events</a>
                    <a href="#event-calendar" class="transition hover:text-white">Calendar</a>
                    <a href="#upcoming-events" class="transition hover:text-white">Upcoming</a>
                </div>
            </div>

            <div>
                <h4 class="text-sm font-extrabold uppercase tracking-[0.2em] text-white/70">Account</h4>
                <div class="mt-4 flex flex-col gap-3 text-sm text-white/55">
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

        <div class="mt-10 border-t border-white/10">
            <div class="mx-auto flex max-w-[1380px] flex-col gap-3 px-4 py-6 text-sm text-white/40 sm:px-6 md:flex-row md:items-center md:justify-between lg:px-8">
                <p>© {{ now('Asia/Manila')->format('Y') }} Holy Spirit School of Tagbilaran. All rights reserved.</p>
                <p class="text-[#d4af37]">Truth in Love · Faith · Learning · Community</p>
            </div>
        </div>
    </footer>

</div>
</body>
</html>