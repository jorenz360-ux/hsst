<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Events · Holy Spirit School of Tagbilaran</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;0,800;0,900;1,400;1,500;1,700;1,900&family=EB+Garamond:ital,wght@0,400;0,500;0,600;1,400;1,500;1,600&family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet"/>
  <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            ink:    { DEFAULT:'#12100e', soft:'#3a3530', muted:'#6b6860' },
            paper:  { DEFAULT:'#faf8f4', dark:'#f0ece3', darker:'#e4ddd0', rule:'#d4c9b8' },
            royal:  { DEFAULT:'#1a3fc4', dark:'#0f2580', deeper:'#091852', light:'#2952d9', pale:'#94b0f8', frost:'#eef2ff' },
            spirit: { DEFAULT:'#c4960a', light:'#e8b80f', pale:'#f5e4a0' },
            crimson:{ DEFAULT:'#c41a2e', light:'#e8314a', pale:'#fde8eb' },
            teal:   { DEFAULT:'#0a7c68', light:'#0f9980', pale:'#d4f0eb' },
          },
          fontFamily: {
            display:  ['"Playfair Display"','Georgia','serif'],
            garamond: ['"EB Garamond"','Georgia','serif'],
            sans:     ['"Inter"','system-ui','sans-serif'],
          },
          keyframes: {
            fadeUp: { from:{opacity:0,transform:'translateY(20px)'}, to:{opacity:1,transform:'translateY(0)'} },
            fadeIn: { from:{opacity:0}, to:{opacity:1} },
          },
          animation: {
            'fade-up': 'fadeUp .85s cubic-bezier(.22,1,.36,1) both',
            'fade-in': 'fadeIn 1s ease both',
          },
          screens: {
            'xs': '375px',
          }
        }
      }
    }
  </script>

  <style>
    :root {
      --ink:    #12100e;
      --paper:  #faf8f4;
      --paper-dark: #f0ece3;
      --rule:   #d4c9b8;
      --royal:  #1a3fc4;
      --spirit: #c4960a;
      --crimson:#c41a2e;
      --teal:   #0a7c68;
    }

    *,*::before,*::after { box-sizing:border-box; margin:0; padding:0; }
    html { scroll-behavior:smooth; }
    body { font-family:'Inter',sans-serif; background:var(--paper); color:var(--ink); overflow-x:hidden; }

    ::-webkit-scrollbar { width:4px; }
    ::-webkit-scrollbar-track { background:var(--paper); }
    ::-webkit-scrollbar-thumb { background:var(--rule); border-radius:0; }

    /* ── Progress bar ── */
    #pgbar {
      position:fixed; top:0; left:0; height:2px;
      background:var(--crimson);
      z-index:9999; width:0; transition:width .1s linear;
    }

    /* ── Reveal ── */
    .reveal { opacity:0; transform:translateY(18px); transition:opacity .7s cubic-bezier(.22,1,.36,1),transform .7s cubic-bezier(.22,1,.36,1); }
    .reveal.on { opacity:1; transform:none; }
    .d1{transition-delay:.1s;} .d2{transition-delay:.2s;} .d3{transition-delay:.3s;} .d4{transition-delay:.4s;}

    /* ── NAV ── */
    #nav { transition:background .35s ease, border-color .35s ease, backdrop-filter .35s ease; }
    #nav.scrolled {
      background:rgba(250,248,244,.97);
      border-bottom:1px solid var(--rule);
      backdrop-filter:blur(10px);
    }

    /* ── Editorial type ── */
    .kicker {
      font-family:'Inter',sans-serif;
      font-size:.67rem; font-weight:700;
      letter-spacing:.22em; text-transform:uppercase;
    }
    /* Mobile kicker slightly larger for readability */
    @media(max-width:639px){ .kicker { font-size:.62rem; } }

    .display { font-family:'Playfair Display',serif; letter-spacing:-.015em; line-height:1.05; }
    .garamond { font-family:'EB Garamond',serif; font-size:1.08rem; line-height:1.9; }
    .caption-text {
      font-family:'Inter',sans-serif;
      font-size:.68rem; letter-spacing:.1em; text-transform:uppercase; color:#6b6860;
    }
    .col-rule { border-top:1px solid var(--rule); }
    .col-rule-thick { border-top:2px solid var(--ink); }

    /* ── Card hover (desktop only) ── */
    @media(min-width:768px){
      .ed-card { transition:transform .3s cubic-bezier(.22,1,.36,1),box-shadow .3s; }
      .ed-card:hover { transform:translateY(-4px); box-shadow:0 12px 40px rgba(18,16,14,.1); }
    }

    /* ── Ornament ── */
    .ornament { display:flex; align-items:center; gap:.75rem; }
    .ornament::before,.ornament::after { content:''; flex:1; border-top:1px solid var(--rule); }

    /* ── Hero ── */
    .hero-gradient {
      background:linear-gradient(
        160deg,
        rgba(9,24,52,.96) 0%,
        rgba(14,38,90,.88) 40%,
        rgba(20,52,140,.6) 65%,
        rgba(20,52,140,.18) 100%
      );
    }

    /* ── Calendar ── */
    .cal-day {
      min-height:52px;
      border-bottom:1px solid var(--rule);
      border-right:1px solid var(--rule);
      padding:.35rem;
      transition:background .15s;
    }
    @media(min-width:640px){ .cal-day { min-height:88px; padding:.5rem; } }
    @media(min-width:1024px){ .cal-day { min-height:110px; padding:.75rem; } }
    .cal-day:hover { background:rgba(26,63,196,.04); }
    .cal-day.selected { box-shadow:inset 0 0 0 1.5px var(--royal); }
    .cal-day.other-month { opacity:.4; }
    .cal-today-badge { background:var(--royal); color:#fff; }
    .cal-count { background:rgba(26,63,196,.08); color:var(--royal); border:1px solid rgba(26,63,196,.15); }
    .cal-event-pill { background:rgba(26,63,196,.06); border:1px solid rgba(26,63,196,.12); color:var(--royal); }

    /* ── Event image overlay ── */
    .event-overlay {
      background:linear-gradient(180deg,rgba(9,24,52,.04) 0%,rgba(9,24,52,.16) 40%,rgba(9,24,52,.72) 100%);
    }

    /* ── Mobile menu ── */
    #mobile-menu { transition:transform .3s cubic-bezier(.22,1,.36,1); }
    #mobile-menu.hidden { display:none; }

    /* ── Touch-friendly tap targets ── */
    @media(max-width:767px){
      .touch-target { min-height:44px; min-width:44px; display:flex; align-items:center; justify-content:center; }
    }
  </style>
</head>
<body class="antialiased">

<div id="pgbar"></div>

<!-- ════════════════════════════════════════
     MASTHEAD TOP STRIP — desktop only
════════════════════════════════════════ -->
<div class="bg-ink text-paper/50 border-b border-paper/10 hidden md:block">
  <div class="max-w-7xl mx-auto px-6 py-1.5 flex items-center justify-between">
    <span class="caption-text" style="color:rgba(250,248,244,.4);">{{ now('Asia/Manila')->format('l, F j, Y') }}</span>
    <div class="flex items-center gap-3">
      <span class="caption-text" style="color:rgba(250,248,244,.4);">Est. 1926</span>
      <span class="caption-text" style="color:rgba(250,248,244,.4);">Tagbilaran, Bohol, Philippines</span>
    </div>
    <span class="caption-text" style="color:rgba(250,248,244,.4);">In Veritate et Caritate</span>
  </div>
</div>

<!-- ════════════════════════════════════════
     NAV — fixed on mobile, relative on md+
════════════════════════════════════════ -->
<header id="nav" class="fixed inset-x-0 top-0 z-50 md:relative md:z-auto">
  <div class="max-w-7xl mx-auto px-4 sm:px-6">

    <div class="flex items-center justify-between py-3 md:py-4">

      <!-- Logo -->
      <a href="{{ route('home') }}" class="flex items-center gap-2.5 group">
        <div class="h-8 w-8 rounded-full bg-royal flex items-center justify-center flex-shrink-0 md:hidden">
          <span class="kicker text-white text-[.5rem]" style="letter-spacing:.04em;">HSST</span>
        </div>
        <img src="{{ asset('images/hsstlogo.jpg') }}" alt="HSST Logo" class="h-8 md:h-9 w-auto object-contain hidden md:block"/>
        <div class="leading-tight">
          <p class="font-display font-bold text-sm text-white md:text-ink transition-colors duration-300" id="logo-text" style="letter-spacing:-.01em;">HSSTian</p>
          <p class="caption-text text-[.54rem] text-white/50 md:text-ink/40 transition-colors duration-300" id="logo-sub">Alumni Association</p>
        </div>
      </a>

      <!-- Desktop nav links -->
      <nav class="hidden md:flex items-center gap-7" id="nav-links">
        <a href="{{ route('home') }}" class="caption-text text-ink/60 hover:text-ink transition-colors">Home</a>
        <a href="{{ route('history') }}" class="caption-text text-ink/60 hover:text-ink transition-colors">History</a>
        <a href="{{ route('events.index') }}" class="caption-text text-ink font-bold border-b-2 pb-0.5" style="border-color:var(--royal);">Events</a>
        <a href="{{ route('home') }}#crusade" class="caption-text text-ink/60 hover:text-ink transition-colors">CRUSADE</a>
        <a href="{{ route('home') }}#contact" class="caption-text text-ink/60 hover:text-ink transition-colors">Contact</a>
      </nav>

      <!-- Desktop auth -->
      <div class="hidden md:flex items-center gap-3" id="auth-links">
        @if (Route::has('login'))
          @auth
            <a href="{{ url('/dashboard') }}" class="caption-text bg-ink text-paper px-4 py-2 hover:opacity-80 transition-opacity">Dashboard</a>
          @else
            <a id="login-btn" href="{{ route('login') }}" class="caption-text border border-ink/20 text-ink/60 px-4 py-2 hover:border-ink/50 hover:text-ink transition-all">Login</a>
            @if (Route::has('register'))
              <a href="{{ route('register') }}" class="caption-text bg-ink text-paper px-4 py-2 hover:opacity-80 transition-opacity">Register</a>
            @endif
          @endauth
        @endif
      </div>

      <!-- Mobile hamburger -->
      <button id="mobile-menu-btn" type="button"
        class="md:hidden touch-target text-white transition-colors w-10 h-10 flex items-center justify-center"
        aria-label="Open menu" aria-expanded="false">
        <svg id="menu-open-icon" class="w-6 h-6 block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
        </svg>
        <svg id="menu-close-icon" class="w-6 h-6 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
        </svg>
      </button>
    </div>

    <!-- Desktop sub-rule -->
    <hr class="col-rule hidden md:block"/>
    <div class="hidden md:flex items-center justify-center py-1.5">
      <span class="caption-text text-ink/30 text-[.6rem]" style="letter-spacing:.3em;">HOLY SPIRIT SCHOOL OF TAGBILARAN · EVENTS & GATHERINGS</span>
    </div>
    <hr class="col-rule hidden md:block"/>

  </div>
</header>

<!-- ════════════════════════════════════════
     MOBILE MENU — full screen overlay
════════════════════════════════════════ -->
<div id="mobile-menu" class="fixed inset-0 z-[9999] hidden md:hidden bg-ink text-paper">
  <div class="flex h-dvh flex-col">
    <!-- Header -->
    <div class="flex items-center justify-between px-5 py-5 border-b border-paper/10">
      <div>
        <p class="caption-text text-paper/40 text-[.6rem]" style="letter-spacing:.25em;">THE HSSTIAN</p>
        <h2 class="font-display text-xl font-bold text-paper mt-0.5">Navigation</h2>
      </div>
      <button type="button" id="close-mobile-menu"
        class="touch-target w-10 h-10 flex items-center justify-center border border-paper/15 text-paper/60 hover:bg-paper/10 transition-colors text-sm">
        ✕
      </button>
    </div>
    <!-- Links -->
    <nav class="flex-1 overflow-y-auto px-5 py-4 flex flex-col">
      <a href="{{ route('home') }}" class="mobile-nav-link border-b border-paper/8 py-4 font-display text-lg text-paper/80">Home</a>
      <a href="{{ route('history') }}" class="mobile-nav-link border-b border-paper/8 py-4 font-display text-lg text-paper/80">History</a>
      <a href="{{ route('events.index') }}" class="mobile-nav-link border-b border-paper/8 py-4 font-display text-lg text-paper font-bold">Events</a>
      <a href="{{ route('home') }}#crusade" class="mobile-nav-link border-b border-paper/8 py-4 font-display text-lg text-paper/80">CRUSADE</a>
      <a href="{{ route('home') }}#contact" class="mobile-nav-link py-4 font-display text-lg text-paper/80">Contact</a>
    </nav>
    <!-- Auth -->
    <div class="border-t border-paper/10 px-5 py-5 flex flex-col gap-3">
      @if (Route::has('login'))
        @auth
          <a href="{{ url('/dashboard') }}" class="flex items-center justify-center py-3.5 bg-paper caption-text text-ink hover:opacity-90 transition-opacity">Dashboard</a>
        @else
          <a href="{{ route('login') }}" class="flex items-center justify-center py-3.5 border border-paper/15 caption-text text-paper/70 hover:bg-paper/5 transition-colors">Login</a>
          @if (Route::has('register'))
            <a href="{{ route('register') }}" class="flex items-center justify-center py-3.5 bg-paper caption-text text-ink hover:opacity-90 transition-opacity">Register</a>
          @endif
        @endauth
      @endif
    </div>
  </div>
</div>

<!-- ════════════════════════════════════════
     HERO — mobile-first magazine cover
════════════════════════════════════════ -->
<section class="relative flex items-end overflow-hidden pt-16 md:pt-0"
  style="min-height:65vh;">
  <!-- BG image -->
  <div class="absolute inset-0">
    <img src="{{ asset('images/hsstherosect1.png') }}" alt="HSST Events"
      class="absolute inset-0 h-full w-full object-cover object-center"/>
    <div class="absolute inset-0 hero-gradient"></div>
    <!-- Subtle noise -->
    <div class="absolute inset-0 opacity-[.04]"
      style="background-image:url(data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='200' height='200'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='200' height='200' filter='url(%23n)' opacity='1'/%3E%3C/svg%3E);"></div>
  </div>

  <!-- Vertical rule — xl only -->
  <div class="pointer-events-none absolute right-12 top-0 bottom-0 hidden xl:flex flex-col items-center justify-center opacity-10">
    <div class="h-64 w-px bg-white"></div>
    <div class="my-3 caption-text text-white" style="writing-mode:vertical-rl;letter-spacing:.3em;font-size:.6rem;">HOLY SPIRIT SCHOOL · EVENTS</div>
    <div class="h-64 w-px bg-white"></div>
  </div>

  <!-- Content — mobile: compact padding, desktop: generous -->
  <div class="relative z-10 w-full max-w-7xl mx-auto px-5 sm:px-8 pb-12 sm:pb-16 md:pb-24">
    <div class="max-w-3xl">

      <!-- Kicker -->
      <div class="mb-4 sm:mb-6 flex items-center gap-3 animate-fade-up" style="animation-delay:.1s;">
        <div class="h-px w-8 sm:w-10 flex-shrink-0" style="background:var(--spirit);"></div>
        <span class="kicker" style="color:var(--spirit);letter-spacing:.2em;">HSST Events & Gatherings</span>
      </div>

      <!-- Headline: clamp starts at 2.2rem on mobile -->
      <h1 class="display text-white mb-4 sm:mb-6 animate-fade-up"
        style="font-size:clamp(2.2rem,8vw,6.5rem);animation-delay:.2s;">
        A calendar of<br/>
        <em style="color:var(--spirit);">return,</em> celebration<br class="hidden sm:block"/>
        &amp; community.
      </h1>

      <!-- Body copy — hidden on very small, visible from xs -->
      <p class="garamond text-white/70 mb-6 sm:mb-8 max-w-xl animate-fade-up"
        style="font-size:clamp(.95rem,1.5vw,1.15rem);animation-delay:.32s;">
        Explore reunions, school celebrations, alumni programs, and community gatherings
        through one official events portal for the HSST community.
      </p>

      <!-- CTAs: stacked on mobile, row on sm+ -->
      <div class="flex flex-col sm:flex-row gap-3 animate-fade-up" style="animation-delay:.42s;">
        <a href="#upcoming-events"
          class="flex items-center justify-center gap-2 bg-paper text-ink caption-text font-bold px-6 sm:px-8 py-3.5 hover:opacity-90 transition-opacity">
          Explore Events
          <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
          </svg>
        </a>
        <a href="#event-calendar"
          class="flex items-center justify-center border border-white/30 text-white/80 caption-text px-6 sm:px-8 py-3.5 hover:border-white/60 hover:text-white transition-all">
          Browse Calendar
        </a>
      </div>

    </div>
  </div>

  <!-- Fade to paper -->
  <div class="absolute inset-x-0 bottom-0 h-16 sm:h-20" style="background:linear-gradient(to top,var(--paper),transparent);"></div>
</section>

<!-- ════════════════════════════════════════
     EVENT CALENDAR
════════════════════════════════════════ -->
<section id="event-calendar" class="py-12 sm:py-20 lg:py-28" style="background:var(--paper-dark);">
  <div class="max-w-7xl mx-auto px-4 sm:px-6">

    <!-- Section header -->
    <div class="mb-8 sm:mb-12 reveal">
      <hr class="col-rule-thick mb-3"/>
      <!-- On mobile: stacked; on sm+: side by side -->
      <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-3">
        <div>
          <span class="kicker text-royal">Event Calendar</span>
          <h2 class="display text-ink mt-2" style="font-size:clamp(1.6rem,3.5vw,3rem);">
            Browse events <em style="color:var(--royal);">by date.</em>
          </h2>
        </div>
        <!-- Calendar nav — full width row on mobile -->
        <div class="flex items-center gap-2">
          <a href="{{ route('events.index', ['month' => $prevMonth, 'date' => $selectedDate]) }}#event-calendar"
            class="flex-1 sm:flex-none touch-target caption-text border border-ink/20 text-ink/60 px-3 sm:px-4 py-2 hover:border-ink/50 hover:text-ink transition-all text-center">
            ← Prev
          </a>
          <a href="{{ route('events.index', ['month' => now()->format('Y-m'), 'date' => now()->toDateString()]) }}#event-calendar"
            class="flex-1 sm:flex-none touch-target caption-text bg-ink text-paper px-3 sm:px-4 py-2 hover:opacity-80 transition-opacity font-bold text-center">
            Today
          </a>
          <a href="{{ route('events.index', ['month' => $nextMonth, 'date' => $selectedDate]) }}#event-calendar"
            class="flex-1 sm:flex-none touch-target caption-text border border-ink/20 text-ink/60 px-3 sm:px-4 py-2 hover:border-ink/50 hover:text-ink transition-all text-center">
            Next →
          </a>
        </div>
      </div>
      <hr class="col-rule mt-3"/>
    </div>

    <!-- Calendar grid + selected date panel -->
    <!-- Mobile: stacked. xl: side by side -->
    <div class="flex flex-col xl:grid xl:grid-cols-[1.3fr_.7fr] gap-6 xl:gap-8 reveal">

      <!-- ── Calendar grid ── -->
      <div class="border border-ink/10" style="background:var(--paper);">

        <!-- Month bar -->
        <div class="flex items-center justify-between px-4 sm:px-5 py-3 sm:py-4 border-b border-ink/10">
          <h3 class="display text-ink font-bold" style="font-size:clamp(1rem,2vw,1.35rem);">{{ $calendarLabel }}</h3>
          <span class="caption-text text-ink/35 hidden sm:block">Dates with events show a count</span>
        </div>

        <!-- Day of week header -->
        <div class="grid grid-cols-7 border-b border-ink/10" style="background:var(--paper-dark);">
          @foreach (['Su','Mo','Tu','We','Th','Fr','Sa'] as $dayName)
            <div class="py-2 sm:py-3 text-center caption-text text-ink/40 text-[.55rem] sm:text-[.6rem]">{{ $dayName }}</div>
          @endforeach
        </div>

        <!-- Days -->
        <div class="grid grid-cols-7">
          @foreach ($calendarDays as $day)
            <a href="{{ route('events.index', ['month' => $currentMonth, 'date' => $day['date']]) }}#event-calendar"
              class="cal-day {{ !$day['isCurrentMonth'] ? 'other-month' : '' }} {{ $day['isSelected'] ? 'selected' : '' }}">
              <div class="flex items-start justify-between gap-0.5">
                <!-- Day number -->
                <span class="inline-flex h-5 w-5 sm:h-6 sm:w-6 lg:h-7 lg:w-7 items-center justify-center text-[10px] sm:text-xs lg:text-sm font-bold {{ $day['isToday'] ? 'cal-today-badge rounded-full' : 'text-ink' }}">
                  {{ $day['day'] }}
                </span>
                @if ($day['count'] > 0)
                  <span class="cal-count rounded-sm px-1 py-0.5 text-[8px] sm:text-[10px] font-bold hidden sm:inline-block">{{ $day['count'] }}</span>
                  <!-- Mobile: dot indicator -->
                  <span class="sm:hidden w-1.5 h-1.5 rounded-full mt-1 flex-shrink-0" style="background:var(--royal);opacity:.7;"></span>
                @endif
              </div>
              <!-- Event pills: hidden on mobile, visible sm+ -->
              <div class="mt-1 space-y-0.5 hidden sm:block">
                @foreach (collect($day['events'])->take(2) as $event)
                  <div class="cal-event-pill truncate rounded-sm px-1 sm:px-1.5 py-0.5 text-[8px] sm:text-[9px] lg:text-[10px] font-medium">
                    {{ $event->title }}
                  </div>
                @endforeach
                @if ($day['count'] > 2)
                  <div class="caption-text text-ink/30 text-[8px]">+{{ $day['count'] - 2 }} more</div>
                @endif
              </div>
            </a>
          @endforeach
        </div>

      </div>

      <!-- ── Selected date panel ── -->
      <div class="border border-ink/10 flex flex-col" style="background:var(--paper);">

        <div class="px-4 sm:px-6 py-4 sm:py-5 border-b border-ink/10">
          <span class="kicker block mb-1" style="color:var(--royal);">Selected Date</span>
          <h3 class="display text-ink font-bold" style="font-size:clamp(1rem,2vw,1.25rem);line-height:1.2;">{{ $selectedDateLabel }}</h3>
          <p class="caption-text text-ink/35 mt-1" style="letter-spacing:.06em;text-transform:none;font-size:.7rem;">Events scheduled on this date</p>
        </div>

        <div class="flex-1 p-4 sm:p-5 space-y-4 overflow-y-auto">
          @forelse ($selectedDayEvents as $event)
            <article class="border border-ink/8 p-4 sm:p-5 ed-card" style="background:var(--paper-dark);">
              <span class="kicker block mb-2" style="color:var(--spirit);">
                {{ \Carbon\Carbon::parse($event->event_date)->format('g:i A') }}
              </span>
              <h4 class="display text-ink font-bold mb-3" style="font-size:1.05rem;line-height:1.25;">
                {{ $event->title }}
              </h4>
              <p class="garamond text-ink/60 mb-4" style="font-size:.9rem;line-height:1.7;">
                {{ \Illuminate\Support\Str::limit($event->description, 120) }}
              </p>
              <hr class="col-rule mb-4"/>
              <div class="grid grid-cols-2 gap-3 mb-4">
                <div>
                  <p class="caption-text text-ink/35 mb-1" style="font-size:.6rem;">Venue</p>
                  <p class="caption-text text-ink font-bold" style="letter-spacing:.04em;text-transform:none;font-size:.7rem;">{{ $event->venue ?: 'TBA' }}</p>
                </div>
                <div>
                  <p class="caption-text text-ink/35 mb-1" style="font-size:.6rem;">Date</p>
                  <p class="caption-text text-ink font-bold" style="letter-spacing:.04em;text-transform:none;font-size:.7rem;">{{ \Carbon\Carbon::parse($event->event_date)->format('M d, Y') }}</p>
                </div>
              </div>
              <a href="{{ route('events.show', $event) }}"
                class="touch-target w-full flex items-center justify-center py-3 caption-text font-bold text-paper hover:opacity-80 transition-opacity"
                style="background:var(--royal);">
                View Details →
              </a>
            </article>
          @empty
            <div class="flex flex-col items-center justify-center h-full py-10 sm:py-12 text-center">
              <span class="display text-ink/20 font-bold" style="font-size:4rem;">—</span>
              <p class="caption-text text-ink/40 mt-3 font-bold">No events on this date</p>
              <p class="caption-text text-ink/25 mt-1" style="letter-spacing:.06em;text-transform:none;font-size:.7rem;">Try another date or browse upcoming events below</p>
            </div>
          @endforelse
        </div>

      </div>

    </div>

  </div>
</section>

<!-- ════════════════════════════════════════
     UPCOMING EVENTS — newspaper grid
════════════════════════════════════════ -->
<section id="upcoming-events" class="py-12 sm:py-20 lg:py-28" style="background:var(--paper);">
  <div class="max-w-7xl mx-auto px-4 sm:px-6">

    <!-- Section header -->
    <div class="mb-8 sm:mb-12 reveal">
      <hr class="col-rule-thick mb-3"/>
      <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-1">
        <div>
          <span class="kicker" style="color:var(--spirit);">Schedule</span>
          <h2 class="display text-ink mt-2" style="font-size:clamp(1.6rem,3.5vw,3rem);">
            All Upcoming <em style="color:var(--spirit);">Gatherings.</em>
          </h2>
        </div>
        <span class="caption-text text-ink/30" style="margin-bottom:.25rem;">HSST Community · {{ now('Asia/Manila')->format('Y') }}</span>
      </div>
      <hr class="col-rule mt-3"/>
    </div>

    @if ($events->count())

      <!-- Grid: 1 col mobile → 2 col md → 3 col xl -->
      <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 border border-ink/8">
        @foreach ($events as $i => $event)
          @php
            $bannerUrl = $event->banner_image
              ? \Illuminate\Support\Facades\Storage::disk('s3')->url($event->banner_image)
              : asset('images/100yearsevent.jpg');
          @endphp

          <article class="ed-card group border-b border-r border-ink/8 flex flex-col" style="background:var(--paper);">

            <!-- Image -->
            <div class="relative overflow-hidden" style="height:200px;">
              <img src="{{ $bannerUrl }}" alt="{{ $event->title }}"
                class="absolute inset-0 h-full w-full object-cover transition duration-700 group-hover:scale-105"/>
              <div class="absolute inset-0 event-overlay"></div>
              <div class="absolute top-3 sm:top-4 left-3 sm:left-4">
                <span class="caption-text font-bold px-2.5 sm:px-3 py-1 sm:py-1.5 text-paper" style="background:var(--royal);">Upcoming</span>
              </div>
              <div class="absolute bottom-3 sm:bottom-4 left-3 sm:left-4">
                <span class="caption-text text-white/70" style="font-size:.62rem;letter-spacing:.15em;">
                  {{ \Carbon\Carbon::parse($event->event_date)->format('F d, Y') }}
                </span>
              </div>
            </div>

            <!-- Content -->
            <div class="flex flex-col flex-1 p-5 sm:p-7">

              <div class="flex items-center justify-between mb-3 sm:mb-4">
                <span class="kicker" style="color:var(--spirit);">{{ \Carbon\Carbon::parse($event->event_date)->format('g:i A') }}</span>
                <span class="caption-text text-ink/30" style="font-size:.6rem;">{{ \Carbon\Carbon::parse($event->event_date)->format('M Y') }}</span>
              </div>

              <h2 class="display text-ink font-bold mb-3 sm:mb-4 group-hover:text-royal transition-colors" style="font-size:clamp(1.1rem,2vw,1.4rem);line-height:1.2;">
                <a href="{{ route('events.show', $event) }}">{{ $event->title }}</a>
              </h2>

              <p class="garamond text-ink/60 flex-1 mb-4 sm:mb-5" style="font-size:.96rem;line-height:1.75;">
                {{ \Illuminate\Support\Str::limit($event->description, 150) }}
              </p>

              <hr class="col-rule mb-4 sm:mb-5"/>

              <div class="flex items-center justify-between">
                @if($event->venue)
                  <span class="caption-text text-ink/40" style="letter-spacing:.05em;text-transform:none;font-size:.68rem;">
                    📍 {{ $event->venue }}
                  </span>
                @else
                  <span></span>
                @endif
                <a href="{{ route('events.show', $event) }}"
                  class="caption-text font-bold text-royal border-b border-royal/30 hover:border-royal pb-0.5 transition-all">
                  Read More →
                </a>
              </div>

            </div>
          </article>
        @endforeach
      </div>

      @if ($events->hasPages())
        <div class="mt-8 sm:mt-10 pt-6 sm:pt-8 border-t border-ink/10 reveal">
          {{ $events->links() }}
        </div>
      @endif

    @else

      <div class="border border-ink/8 p-10 sm:p-16 text-center reveal" style="background:var(--paper-dark);">
        <span class="display text-ink/15 font-black block" style="font-size:5rem;line-height:.7;">"</span>
        <h3 class="display text-ink font-bold mt-2" style="font-size:1.6rem;">No upcoming events at this time.</h3>
        <p class="garamond text-ink/50 mt-3 max-w-md mx-auto" style="font-size:.98rem;">
          Please check back soon for newly scheduled school events, alumni celebrations, and upcoming HSST activities.
        </p>
        <div class="ornament mt-8">
          <span class="caption-text text-ink/30" style="font-size:.6rem;letter-spacing:.25em;">IN VERITATE ET CARITATE</span>
        </div>
      </div>

    @endif

  </div>
</section>

<!-- ════════════════════════════════════════
     CTA
════════════════════════════════════════ -->
<section class="py-20 sm:py-24 lg:py-32 text-center" style="background:var(--ink);">
  <div class="max-w-3xl mx-auto px-5 sm:px-6">

    <div class="flex items-center justify-center gap-4 mb-6 reveal">
      <div class="h-px flex-1 max-w-24" style="background:rgba(250,248,244,.12);"></div>
      <span class="caption-text font-bold" style="color:var(--spirit);letter-spacing:.3em;font-size:.62rem;">JOIN THE COMMUNITY</span>
      <div class="h-px flex-1 max-w-24" style="background:rgba(250,248,244,.12);"></div>
    </div>

    <h2 class="display text-paper font-bold mb-4 sm:mb-5 reveal d1" style="font-size:clamp(1.9rem,5vw,4rem);">
      Ready to <em style="color:var(--spirit);">reconnect?</em>
    </h2>

    <p class="garamond mb-8 sm:mb-10 reveal d2" style="color:rgba(250,248,244,.5);max-width:36rem;margin-left:auto;margin-right:auto;">
      Create your account to stay updated on alumni events, school programs, and upcoming
      celebrations through one secure official portal.
    </p>

    <!-- Stacked on mobile, row on sm+ -->
    <div class="flex flex-col sm:flex-row gap-3 justify-center reveal d2">
      @if (Route::has('register'))
        <a href="{{ route('register') }}"
          class="touch-target caption-text font-bold bg-paper text-ink px-8 sm:px-10 py-4 hover:opacity-90 transition-opacity">
          Create Account
        </a>
      @endif
      @if (Route::has('login'))
        <a href="{{ route('login') }}"
          class="touch-target caption-text font-bold border border-paper/25 text-paper/70 px-8 sm:px-10 py-4 hover:border-paper/60 hover:text-paper transition-all">
          Log in
        </a>
      @endif
    </div>

    <p class="caption-text mt-10 sm:mt-12 reveal d3" style="color:rgba(250,248,244,.15);letter-spacing:.25em;font-size:.62rem;">
      IN VERITATE ET CARITATE · TRUTH AND LOVE · 1926–2026
    </p>

  </div>
</section>

<!-- ════════════════════════════════════════
     FOOTER
════════════════════════════════════════ -->
<footer id="contact" class="bg-ink pt-12 sm:pt-16 pb-8">
  <div class="max-w-7xl mx-auto px-4 sm:px-6">

    <!-- Brand colophon -->
    <div class="text-center pb-8 sm:pb-10 mb-8 sm:mb-10 border-b border-paper/8">
      <p class="caption-text text-paper/25 mb-2" style="letter-spacing:.3em;">THE OFFICIAL JOURNAL OF</p>
      <h2 class="display text-paper font-bold" style="font-size:clamp(1.4rem,4vw,3rem);">HSSTian Alumni Association</h2>
      <p class="caption-text text-paper/30 mt-2" style="letter-spacing:.15em;">HOLY SPIRIT SCHOOL OF TAGBILARAN · BOHOL, PHILIPPINES</p>
      <div class="flex items-center justify-center gap-4 mt-4">
        <div class="h-px flex-1 max-w-32 bg-paper/10"></div>
        <span class="caption-text font-bold" style="color:var(--spirit);letter-spacing:.22em;font-size:.65rem;">IN VERITATE ET CARITATE</span>
        <div class="h-px flex-1 max-w-32 bg-paper/10"></div>
      </div>
    </div>

    <!-- Footer columns: stacked on mobile, 2-col on sm, 4-col on md -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-8 sm:gap-10 pb-10 sm:pb-12 border-b border-paper/8">

      <!-- Brand -->
      <div class="col-span-2 md:col-span-2">
        <div class="flex items-center gap-3 mb-4">
          <div class="h-8 w-8 rounded-full bg-royal flex items-center justify-center flex-shrink-0">
            <span class="kicker text-white text-[.48rem]" style="letter-spacing:.04em;">HSST</span>
          </div>
          <div>
            <p class="display text-paper font-bold text-base">HSSTian</p>
            <p class="caption-text text-paper/25 text-[.55rem]" style="letter-spacing:.22em;">Alumni Association</p>
          </div>
        </div>
        <p class="garamond text-paper/30 max-w-xs mb-4" style="font-size:.9rem;line-height:1.7;">
          United by faith. Driven by service. Forever Crusaders.
          Tagbilaran City, Bohol, Philippines.
        </p>
        <p class="caption-text font-bold mb-1" style="color:var(--spirit);">In Veritate et Caritate</p>
        <p class="caption-text text-paper/20 italic" style="letter-spacing:.06em;text-transform:none;font-size:.68rem;">In Truth and in Love</p>
      </div>

      <!-- Quick links -->
      <div>
        <p class="caption-text font-bold text-paper/40 mb-4 sm:mb-5" style="letter-spacing:.2em;">Quick Links</p>
        <ul class="space-y-3">
          <li><a href="{{ route('home') }}" class="caption-text text-paper/25 hover:text-paper/70 transition-colors" style="letter-spacing:.08em;text-transform:none;font-size:.8rem;">Home</a></li>
          <li><a href="{{ route('history') }}" class="caption-text text-paper/25 hover:text-paper/70 transition-colors" style="letter-spacing:.08em;text-transform:none;font-size:.8rem;">History</a></li>
          <li><a href="{{ route('events.index') }}" class="caption-text text-paper/60 hover:text-paper/70 transition-colors" style="letter-spacing:.08em;text-transform:none;font-size:.8rem;">Events</a></li>
          <li><a href="#event-calendar" class="caption-text text-paper/25 hover:text-paper/70 transition-colors" style="letter-spacing:.08em;text-transform:none;font-size:.8rem;">Calendar</a></li>
          <li><a href="{{ route('home') }}#crusade" class="caption-text text-paper/25 hover:text-paper/70 transition-colors" style="letter-spacing:.08em;text-transform:none;font-size:.8rem;">CRUSADE</a></li>
        </ul>
      </div>

      <!-- Contact -->
      <div>
        <p class="caption-text font-bold text-paper/40 mb-4 sm:mb-5" style="letter-spacing:.2em;">Contact</p>
        <ul class="space-y-4">
          <li class="flex gap-2.5 items-start">
            <svg class="w-3 h-3 sm:w-3.5 sm:h-3.5 text-paper/30 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
            </svg>
            <span class="caption-text text-paper/25" style="letter-spacing:.04em;text-transform:none;font-size:.72rem;">alumni@hss-tagbilaran.edu.ph</span>
          </li>
          <li class="flex gap-2.5 items-start">
            <svg class="w-3 h-3 sm:w-3.5 sm:h-3.5 text-paper/30 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
            </svg>
            <span class="caption-text text-paper/25" style="letter-spacing:.04em;text-transform:none;font-size:.72rem;">J.A. Clarin, Purok 3, Dao District, Tagbilaran City, Bohol 6300</span>
          </li>
        </ul>
      </div>

    </div>

    <!-- Bottom bar -->
    <div class="pt-6 sm:pt-8 flex flex-col items-center sm:flex-row sm:justify-between gap-3 text-center sm:text-left">
      <p class="caption-text text-paper/15" style="letter-spacing:.08em;text-transform:none;font-size:.7rem;">
        © {{ now('Asia/Manila')->format('Y') }} HSSTian Alumni Association · Holy Spirit School of Tagbilaran. All rights reserved.
      </p>
      <p class="caption-text font-bold" style="color:var(--spirit);opacity:.5;letter-spacing:.25em;font-size:.62rem;">
        CRUSADERS FOREVER ✦
      </p>
    </div>

  </div>
</footer>

<!-- ════════════════════════════════════════
     JAVASCRIPT
════════════════════════════════════════ -->
<script>
  // Progress bar
  window.addEventListener('scroll', () => {
    const pct = (window.scrollY / (document.body.scrollHeight - window.innerHeight)) * 100;
    document.getElementById('pgbar').style.width = pct + '%';
  }, { passive: true });

  // ── Mobile menu ──
  const mobileMenuBtn      = document.getElementById('mobile-menu-btn');
  const mobileMenu         = document.getElementById('mobile-menu');
  const menuOpenIcon       = document.getElementById('menu-open-icon');
  const menuCloseIcon      = document.getElementById('menu-close-icon');
  const closeMobileMenuBtn = document.getElementById('close-mobile-menu');

  function openMobileMenu() {
    mobileMenu.classList.remove('hidden');
    menuOpenIcon.classList.add('hidden');
    menuCloseIcon.classList.remove('hidden');
    mobileMenuBtn.setAttribute('aria-expanded', 'true');
    document.body.style.overflow = 'hidden';
  }
  function closeMobileMenu() {
    mobileMenu.classList.add('hidden');
    menuOpenIcon.classList.remove('hidden');
    menuCloseIcon.classList.add('hidden');
    mobileMenuBtn.setAttribute('aria-expanded', 'false');
    document.body.style.overflow = '';
  }

  mobileMenuBtn?.addEventListener('click', () =>
    mobileMenu.classList.contains('hidden') ? openMobileMenu() : closeMobileMenu()
  );
  closeMobileMenuBtn?.addEventListener('click', closeMobileMenu);
  document.querySelectorAll('.mobile-nav-link').forEach(l => l.addEventListener('click', closeMobileMenu));

  // ── Nav scroll state ──
  const nav            = document.getElementById('nav');
  const logoText       = document.getElementById('logo-text');
  const logoSub        = document.getElementById('logo-sub');
  const navLinks       = document.getElementById('nav-links');
  const loginBtn       = document.getElementById('login-btn');
  const mobileMenuButton = document.getElementById('mobile-menu-btn');

  function setScrolledNav() {
    nav.classList.add('scrolled');
    logoText?.classList.replace('text-white','text-ink');
    logoSub?.classList.remove('text-white/50'); logoSub?.classList.add('text-ink/40');
    navLinks?.querySelectorAll('a').forEach(a => {
      a.classList.remove('text-white/70','hover:text-white');
      a.classList.add('text-ink/60','hover:text-ink');
    });
    loginBtn?.classList.remove('border-white/25','text-white/80','hover:border-white/60','hover:text-white');
    loginBtn?.classList.add('border-ink/20','text-ink/60','hover:border-ink/50','hover:text-ink');
    mobileMenuButton?.classList.replace('text-white','text-ink');
  }
  function setTopNav() {
    nav.classList.remove('scrolled');
    logoText?.classList.replace('text-ink','text-white');
    logoSub?.classList.remove('text-ink/40'); logoSub?.classList.add('text-white/50');
    navLinks?.querySelectorAll('a').forEach(a => {
      a.classList.remove('text-ink/60','hover:text-ink');
      a.classList.add('text-white/70','hover:text-white');
    });
    loginBtn?.classList.remove('border-ink/20','text-ink/60','hover:border-ink/50','hover:text-ink');
    loginBtn?.classList.add('border-white/25','text-white/80','hover:border-white/60','hover:text-white');
    mobileMenuButton?.classList.replace('text-ink','text-white');
  }

  function handleNavScroll() { window.scrollY > 60 ? setScrolledNav() : setTopNav(); }
  window.addEventListener('scroll', handleNavScroll, { passive: true });
  handleNavScroll();

  // ── Reveal on scroll ──
  const ro = new IntersectionObserver(entries => {
    entries.forEach(e => { if (e.isIntersecting) { e.target.classList.add('on'); ro.unobserve(e.target); } });
  }, { threshold: 0.08 });
  document.querySelectorAll('.reveal').forEach(el => ro.observe(el));
</script>
</body>
</html>