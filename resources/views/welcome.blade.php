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
    </style>
</head>

<body class="overflow-x-hidden bg-white font-body text-slate-800 antialiased">
<div x-data="{ mobileOpen: false }">

    {{-- HEADER (Dark royal blue background, white text, solid buttons, sharp corners) --}}
    <header class="sticky inset-x-0 top-0 z-50 bg-[#0F2A6B] shadow-lg">
        <div class="mx-auto flex h-[72px] max-w-[1320px] items-center justify-between px-5 md:px-6 lg:px-8">
            <a href="{{ route('home') }}" class="flex min-w-0 items-center gap-3 transition hover:opacity-80">
                <div class="flex h-11 w-11 shrink-0 items-center justify-center overflow-hidden border border-white/20 bg-white p-1 shadow-sm">
                    <img src="{{ asset('images/hsstlogo.jpg') }}" alt="HSST Logo" class="h-full w-full object-contain">
                </div>
                <div class="min-w-0">
                    <p class="text-[9px] font-semibold uppercase tracking-[0.28em] text-white/80">Official Alumni Portal</p>
                    <p class="truncate text-[13px] font-semibold text-white">Holy Spirit School of Tagbilaran</p>
                </div>
            </a>

            <nav class="hidden items-center gap-1 lg:flex">
                <a href="#homecoming" class="px-4 py-2 text-sm text-white/90 transition hover:bg-white/10 hover:text-white">Homecoming</a>
                <a href="#gallery" class="px-4 py-2 text-sm text-white/90 transition hover:bg-white/10 hover:text-white">Gallery</a>
                <a href="#events" class="px-4 py-2 text-sm text-white/90 transition hover:bg-white/10 hover:text-white">Events</a>
                <a href="#announcements" class="px-4 py-2 text-sm text-white/90 transition hover:bg-white/10 hover:text-white">Announcements</a>
                <a href="#contact" class="px-4 py-2 text-sm text-white/90 transition hover:bg-white/10 hover:text-white">Contact</a>
            </nav>

            <div class="hidden items-center gap-2 lg:flex">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="bg-white px-5 py-2 text-sm font-semibold text-[#0F2A6B] transition hover:bg-slate-100 shadow-md">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="bg-white px-4 py-2 text-sm font-medium text-[#0F2A6B] transition hover:bg-slate-100">Log in</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="bg-white px-5 py-2 text-sm font-semibold text-[#0F2A6B] transition hover:bg-slate-100 shadow-md">Register</a>
                        @endif
                    @endauth
                @endif
            </div>

            <button @click="mobileOpen = !mobileOpen" :class="mobileOpen ? 'hamburger-open' : ''" class="flex flex-col gap-[4.5px] border border-white/20 bg-white/10 p-2.5 lg:hidden" aria-label="Menu">
                <span class="hamburger-line line-1 block h-[1.5px] w-[18px] rounded bg-white"></span>
                <span class="hamburger-line line-2 block h-[1.5px] w-[18px] rounded bg-white"></span>
                <span class="hamburger-line line-3 block h-[1.5px] w-[18px] rounded bg-white"></span>
            </button>
        </div>
    </header>

    {{-- MOBILE NAV (Dark royal blue background, solid buttons, sharp corners) --}}
    <div x-cloak x-show="mobileOpen" x-transition.opacity.duration.200ms class="fixed inset-x-0 top-[72px] z-40 border-t border-white/20 bg-[#0F2A6B] px-5 py-5 shadow-lg lg:hidden">
        <div class="flex flex-col gap-1">
            <a @click="mobileOpen=false" href="#homecoming" class="px-4 py-3 text-sm text-white/90 hover:bg-white/10 hover:text-white">Homecoming</a>
            <a @click="mobileOpen=false" href="#gallery" class="px-4 py-3 text-sm text-white/90 hover:bg-white/10 hover:text-white">Gallery</a>
            <a @click="mobileOpen=false" href="#events" class="px-4 py-3 text-sm text-white/90 hover:bg-white/10 hover:text-white">Events</a>
            <a @click="mobileOpen=false" href="#announcements" class="px-4 py-3 text-sm text-white/90 hover:bg-white/10 hover:text-white">Announcements</a>
            <a @click="mobileOpen=false" href="#contact" class="px-4 py-3 text-sm text-white/90 hover:bg-white/10 hover:text-white">Contact</a>
        </div>

        @if (Route::has('login'))
            <div class="my-4 h-px bg-white/20"></div>
            @auth
                <a href="{{ url('/dashboard') }}" class="block bg-white px-4 py-3 text-center text-sm font-semibold text-[#0F2A6B]">Dashboard</a>
            @else
                <a href="{{ route('login') }}" class="block bg-white px-4 py-3 text-center text-sm font-medium text-[#0F2A6B]">Log in</a>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="mt-2 block bg-white px-4 py-3 text-center text-sm font-semibold text-[#0F2A6B]">Register</a>
                @endif
            @endauth
        @endif
    </div>

    {{-- HERO SECTION (dark gradient overlay, solid buttons, sharp corners) --}}
    <section class="relative overflow-hidden">
        <div class="absolute inset-0">
            <img src="{{ asset('images/herosection.jpg') }}" alt="HSST campus or alumni event" class="h-full w-full object-cover object-center">
            <div class="absolute inset-0 bg-gradient-to-r from-black/80 via-black/60 to-transparent"></div>
        </div>

        <div class="relative z-10 mx-auto max-w-[1320px] px-5 py-20 md:px-6 lg:py-28">
            <div class="max-w-3xl">
                <div class="inline-flex items-center gap-2 bg-white/20 px-4 py-1.5 border border-white/30">
                    <span class="h-2 w-2 rounded-full bg-white"></span>
                    <p class="text-[10px] font-semibold uppercase tracking-[0.24em] text-white">Holy Spirit School of Tagbilaran</p>
                </div>

                <h1 class="mt-6 font-display text-[3rem] leading-[0.95] tracking-[-0.03em] text-white sm:text-[4rem] lg:text-[5rem]">
                    Forever part of the <span class="text-white">HSST alumni family.</span>
                </h1>

                <p class="mt-6 max-w-2xl text-[15px] leading-8 text-white/90 sm:text-[17px]">
                    Reconnect through official announcements, alumni events, school milestones, and one welcoming digital home designed for every HSST graduate.
                </p>

                <div class="mt-10 flex flex-col gap-4 sm:flex-row">
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="inline-flex items-center justify-center bg-white px-7 py-4 text-sm font-semibold uppercase tracking-[0.16em] text-[#1E3A8A] transition hover:bg-slate-100 shadow-lg">Join the Alumni Network</a>
                    @endif
                    <a href="#events" class="inline-flex items-center justify-center bg-[#1E3A8A] px-7 py-4 text-sm font-medium uppercase tracking-[0.16em] text-white transition hover:bg-[#1E40AF]">Explore Events</a>
                </div>

                <div class="mt-12 grid max-w-xl grid-cols-3 gap-4 border-t border-white/20 pt-8">
                    <div><p class="text-2xl font-extrabold text-white">100+</p><p class="mt-1 text-xs text-white/80">Years of legacy</p></div>
                    <div><p class="text-2xl font-extrabold text-white">Alumni</p><p class="mt-1 text-xs text-white/80">Across generations</p></div>
                    <div><p class="text-2xl font-extrabold text-white">1 Home</p><p class="mt-1 text-xs text-white/80">Official digital portal</p></div>
                </div>
            </div>
        </div>
    </section>

    {{-- HOMECOMING SECTION (White cards with blue accents, sharp corners) --}}
    <section id="homecoming" class="py-20 lg:py-28 bg-white">
        <div class="mx-auto max-w-[1320px] px-5 md:px-6 lg:px-8">
            <div class="max-w-4xl">
                <p class="text-[11px] font-semibold uppercase tracking-[0.28em] text-[#1E3A8A]">Grand Alumni Homecoming</p>
                <h2 class="mt-4 font-display text-[2.3rem] leading-[1.04] text-slate-900 sm:text-[3rem] lg:text-[3.5rem]">
                    Whether you studied decades ago or graduated recently, you remain part of the HSST story.
                </h2>
                <p class="mt-6 max-w-3xl text-[15px] leading-8 text-slate-600">
                    The HSST Alumni Homecoming celebrates friendship, tradition, and return. It brings together generations of graduates to revisit campus memories, strengthen bonds, and continue a shared legacy of faith, learning, and community.
                </p>
            </div>

            <div class="mt-14 grid gap-6 md:grid-cols-2">
                <div class="border border-slate-200 bg-white p-8 shadow-sm transition hover:shadow-md hover:border-[#1E3A8A]/30">
                    <p class="text-[11px] font-semibold uppercase tracking-[0.22em] text-[#1E3A8A]">What to expect</p>
                    <h3 class="mt-3 text-xl font-semibold text-slate-900">A warmer alumni experience</h3>
                    <p class="mt-4 text-sm leading-7 text-slate-600">Reunion updates, featured gatherings, school news, and a smoother portal experience thoughtfully designed for alumni returning home.</p>
                </div>
                <div class="border border-slate-200 bg-white p-8 shadow-sm transition hover:shadow-md hover:border-[#1E3A8A]/30">
                    <p class="text-[11px] font-semibold uppercase tracking-[0.22em] text-[#1E3A8A]">Why it matters</p>
                    <h3 class="mt-3 text-xl font-semibold text-slate-900">One stronger connection across generations</h3>
                    <p class="mt-4 text-sm leading-7 text-slate-600">It gives every HSSTian one trusted place to stay informed, participate in alumni activities, and remain connected with the school community.</p>
                </div>
            </div>
        </div>
    </section>

{{-- GALLERY SECTION (Carousel, sharp corners, images not cropped) --}}
<section id="gallery" class="py-20 lg:py-28 bg-slate-50">
    <div class="mx-auto max-w-[1320px] px-5 md:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto mb-12">
            <p class="text-[11px] font-semibold uppercase tracking-[0.30em] text-[#1E3A8A] mb-2">Campus Memories</p>
            <h2 class="font-display text-[2rem] leading-[1.1] text-slate-900 sm:text-[2.6rem]">Moments that define our spirit</h2>
            <p class="mt-3 text-slate-600">A glimpse of the vibrant life and cherished traditions at Holy Spirit School of Tagbilaran.</p>
        </div>

        <div x-data="carousel()" class="relative">
            <div class="relative overflow-hidden shadow-xl bg-slate-200">
                <img :src="images[currentIndex]" alt="HSST campus scene" class="w-full h-[400px] md:h-[500px] object-contain bg-slate-200">
                
                <button @click="prev()" class="absolute left-4 top-1/2 -translate-y-1/2 bg-white p-2 shadow-lg transition hover:bg-slate-100">
                    <svg class="w-6 h-6 text-slate-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>
                <button @click="next()" class="absolute right-4 top-1/2 -translate-y-1/2 bg-white p-2 shadow-lg transition hover:bg-slate-100">
                    <svg class="w-6 h-6 text-slate-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
            </div>

            <div class="flex justify-center gap-2 mt-6">
                <template x-for="(_, idx) in images" :key="idx">
                    <button @click="currentIndex = idx" class="w-2.5 h-2.5 transition-all" :class="currentIndex === idx ? 'bg-[#1E3A8A] w-6' : 'bg-slate-300 hover:bg-slate-400'"></button>
                </template>
            </div>
        </div>
    </div>
</section>

    {{-- EVENTS SECTION (Light gray background, sharp corners) --}}
    <section id="events" class="py-20 lg:py-28 bg-slate-50">
        <div class="mx-auto max-w-[1320px] px-5 md:px-6 lg:px-8">
            <div class="mb-10 flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
                <div>
                    <p class="mb-3 text-[11px] font-semibold uppercase tracking-[0.30em] text-[#1E3A8A]">Upcoming Events</p>
                    <h2 class="font-display text-[2rem] leading-[1.04] text-slate-900 sm:text-[2.6rem]">Alumni News and Events</h2>
                </div>
                <a href="{{ route('events.index') }}" class="text-sm font-semibold uppercase tracking-[0.12em] text-[#1E3A8A] transition hover:text-[#1E40AF]">View All</a>
            </div>

            @if ($events->isNotEmpty())
                <div class="grid gap-8 md:grid-cols-2 xl:grid-cols-3">
                    @foreach ($events as $event)
                        @php
                            $bannerUrl = $event->banner_image ? \Illuminate\Support\Facades\Storage::disk('s3')->url($event->banner_image) : asset('images/100yearsevent.jpg');
                        @endphp
                        <article class="group relative border border-slate-200 bg-white shadow-sm transition hover:shadow-xl">
                            <div class="relative h-56 overflow-hidden">
                                <img src="{{ $bannerUrl }}" alt="{{ $event->title }}" class="h-full w-full object-cover transition duration-700 group-hover:scale-105">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/30 via-transparent to-transparent"></div>
                                <div class="absolute left-4 top-4"><span class="inline-flex bg-[#1E3A8A] px-3 py-1 text-[10px] font-semibold uppercase tracking-[0.18em] text-white">Upcoming</span></div>
                            </div>
                            <div class="p-6">
                                <p class="text-[11px] font-semibold uppercase tracking-[0.28em] text-[#1E3A8A]">
                                    {{ \Carbon\Carbon::parse($event->event_date)->format('F d, Y') }}
                                    @if ($event->schedules->first()?->schedule_time) · {{ \Carbon\Carbon::parse($event->schedules->first()->schedule_time)->format('g:i A') }} @endif
                                </p>
                                <h3 class="mt-3 font-display text-[1.6rem] leading-[1.12] text-slate-900 transition group-hover:text-[#1E3A8A]">
                                    <a href="{{ route('events.show', ['event' => $event->slug]) }}">{{ $event->title }}</a>
                                </h3>
                                @if ($event->venue) <p class="mt-3 text-sm font-medium text-slate-700">{{ $event->venue }}</p> @endif
                                @if ($event->dress_code) <p class="mt-1 text-xs text-slate-500">Dress Code: {{ $event->dress_code }}</p> @endif
                                <p class="mt-4 text-sm leading-6 text-slate-600">{{ \Illuminate\Support\Str::limit($event->description, 140) }}</p>
                                <div class="mt-6">
                                    <a href="{{ route('events.show', $event) }}" class="inline-flex items-center gap-2 text-sm font-semibold uppercase tracking-[0.14em] text-[#1E3A8A] transition hover:gap-3 hover:text-[#1E40AF]">Read more <span aria-hidden="true">→</span></a>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
            @else
                <div class="border border-slate-200 bg-white p-8 text-center shadow-sm">
                    <p class="text-sm font-semibold uppercase tracking-[0.24em] text-[#1E3A8A]">Events</p>
                    <h3 class="mt-4 font-display text-[1.8rem] text-slate-900">No upcoming event yet</h3>
                    <p class="mt-3 max-w-xl mx-auto text-sm leading-7 text-slate-600">Please check back soon for the next scheduled school or alumni event.</p>
                </div>
            @endif
        </div>
    </section>

    {{-- ANNOUNCEMENTS SECTION (White background, sharp corners) --}}
    <section id="announcements" class="py-20 lg:py-28 bg-white">
        <div class="mx-auto max-w-[1320px] px-5 md:px-6 lg:px-8">
            <div class="mb-10">
                <p class="mb-3 text-[11px] font-semibold uppercase tracking-[0.30em] text-[#1E3A8A]">Announcements</p>
                <h2 class="font-display text-[2rem] leading-[1.04] text-slate-900 sm:text-[2.5rem]">Important notices & updates</h2>
            </div>
            <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
                @forelse ($announcements as $announcement)
                    <article class="border border-slate-200 bg-white p-6 shadow-sm transition hover:shadow-md hover:border-[#1E3A8A]/30">
                        <div class="mb-4 flex flex-wrap items-center gap-2">
                            <span class="inline-flex bg-[#1E3A8A]/10 px-3 py-1 text-[10px] font-semibold uppercase tracking-[0.18em] text-[#1E3A8A] border border-[#1E3A8A]/20">Announcement</span>
                            @if ($announcement->pinned) <span class="inline-flex bg-[#1E3A8A] px-3 py-1 text-[10px] font-semibold uppercase tracking-[0.18em] text-white">Pinned</span> @endif
                        </div>
                        <h3 class="text-lg font-semibold leading-[1.4] text-slate-900">{{ $announcement->title }}</h3>
                        <p class="mt-4 text-sm leading-6 text-slate-600">{{ \Illuminate\Support\Str::limit(strip_tags($announcement->content), 180) }}</p>
                        <div class="mt-5 text-[11px] font-medium text-slate-500">@if ($announcement->published_at) {{ $announcement->published_at->format('F d, Y') }} @else Recently published @endif</div>
                    </article>
                @empty
                    <div class="border border-slate-200 bg-white p-8 text-center text-sm text-slate-600">No announcements available right now.</div>
                @endforelse
            </div>
        </div>
    </section>

    {{-- FINAL CTA (Royal blue background, solid buttons, sharp corners) --}}
    <section class="relative overflow-hidden bg-[#1E3A8A] py-20 lg:py-24">
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,rgba(255,255,255,0.1),transparent_40%)]"></div>
        <div class="relative z-10 mx-auto max-w-[1320px] px-5 md:px-6 lg:px-8">
            <div class="grid gap-10 lg:grid-cols-[1.2fr_.8fr] lg:items-center">
                <div>
                    <p class="text-[11px] font-semibold uppercase tracking-[0.30em] text-white/80">Join the HSST Network</p>
                    <h2 class="mt-4 font-display text-[2rem] leading-[1.05] text-white sm:text-[2.6rem] lg:text-[3rem]">Ready to reconnect with the HSST community?</h2>
                    <p class="mt-5 max-w-2xl text-[15px] leading-7 text-white/90">Create your account to receive updates, participate in alumni activities, and stay connected through one secure school-managed platform.</p>
                </div>
                <div class="flex flex-col gap-3">
                    @if (Route::has('register')) <a href="{{ route('register') }}" class="block bg-white px-6 py-4 text-center text-sm font-semibold uppercase tracking-[0.16em] text-[#1E3A8A] transition hover:bg-slate-100 shadow-lg">Create Account</a> @endif
                    @if (Route::has('login')) <a href="{{ route('login') }}" class="block bg-white px-6 py-4 text-center text-sm font-medium text-[#1E3A8A] transition hover:bg-slate-100">Log in to Existing Account</a> @endif
                </div>
            </div>
        </div>
    </section>

    {{-- FOOTER (Light gray) --}}
    <footer id="contact" class="bg-slate-100 text-slate-600">
        <div class="mx-auto grid max-w-[1320px] gap-10 px-5 py-12 md:px-6 lg:grid-cols-[1.3fr_.8fr_.8fr] lg:px-8 lg:py-16">
            <div>
                <a href="{{ route('home') }}" class="flex items-center gap-3">
                    <div class="flex h-11 w-11 shrink-0 items-center justify-center overflow-hidden border border-slate-200 bg-white p-1 shadow-sm"><img src="{{ asset('images/hsstlogo.jpg') }}" alt="HSST Logo" class="h-full w-full rounded-lg object-contain"></div>
                    <div><p class="text-[9px] font-semibold uppercase tracking-[0.24em] text-[#1E3A8A]">Official Alumni Portal</p><p class="text-[13px] font-semibold text-slate-900">Holy Spirit School of Tagbilaran</p></div>
                </a>
                <p class="mt-5 max-w-[390px] text-sm leading-7 text-slate-600">A digital home for official announcements, alumni events, school celebrations, and a stronger connection between HSST and its graduates.</p>
                <p class="mt-4 text-xs text-slate-500">Managed by HSST Administration &amp; Alumni Office</p>
            </div>
            <div>
                <p class="mb-4 text-[10px] font-semibold uppercase tracking-[0.22em] text-[#1E3A8A]">Quick Links</p>
                <div class="space-y-2"><a href="#homecoming" class="block text-sm text-slate-600 transition hover:text-[#1E3A8A]">Homecoming</a><a href="#gallery" class="block text-sm text-slate-600 transition hover:text-[#1E3A8A]">Gallery</a><a href="#events" class="block text-sm text-slate-600 transition hover:text-[#1E3A8A]">Events</a><a href="#announcements" class="block text-sm text-slate-600 transition hover:text-[#1E3A8A]">Announcements</a></div>
            </div>
            <div>
                <p class="mb-4 text-[10px] font-semibold uppercase tracking-[0.22em] text-[#1E3A8A]">Account</p>
                <div class="space-y-2">@if (Route::has('login')) <a href="{{ route('login') }}" class="block text-sm text-slate-600 transition hover:text-[#1E3A8A]">Log in</a> @endif @if (Route::has('register')) <a href="{{ route('register') }}" class="block text-sm text-slate-600 transition hover:text-[#1E3A8A]">Register</a> @endif <a href="{{ url('/dashboard') }}" class="block text-sm text-slate-600 transition hover:text-[#1E3A8A]">Dashboard</a></div>
            </div>
        </div>
        <div class="mx-auto flex max-w-[1320px] flex-col gap-2 border-t border-slate-200 px-5 py-5 text-xs text-slate-500 md:flex-row md:items-center md:justify-between md:px-6 lg:px-8">
            <p>© 2026 Holy Spirit School of Tagbilaran. All rights reserved.</p>
            <p>Truth in Love · Faith · Learning · Community</p>
        </div>
    </footer>
</div>

<script>
    function carousel() {
        return {
            images: [
                '{{ asset("images/image3.jpg") }}',
                '{{ asset("images/image4.jpg") }}',
                '{{ asset("images/image5.jpg") }}',
            ],
            currentIndex: 0,
            prev() {
                this.currentIndex = (this.currentIndex - 1 + this.images.length) % this.images.length;
            },
            next() {
                this.currentIndex = (this.currentIndex + 1) % this.images.length;
            }
        }
    }
</script>
</body>
</html>