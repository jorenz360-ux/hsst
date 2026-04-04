<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>HSSTian Alumni — The Centennial Chronicle</title>
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
            fadeUp:   { from:{opacity:0,transform:'translateY(20px)'}, to:{opacity:1,transform:'translateY(0)'} },
            fadeIn:   { from:{opacity:0}, to:{opacity:1} },
            ticker:   { from:{transform:'translateX(0)'}, to:{transform:'translateX(-50%)'} },
            scaleIn:  { from:{transform:'scaleX(0)'}, to:{transform:'scaleX(1)'} },
          },
          animation: {
            'fade-up':    'fadeUp .85s cubic-bezier(.22,1,.36,1) both',
            'fade-in':    'fadeIn 1s ease both',
            'ticker':     'ticker 32s linear infinite',
            'scale-in':   'scaleIn .6s cubic-bezier(.22,1,.36,1) both',
          }
        }
      }
    }
  </script>

  <style>
    :root {
      --ink:    #12100e;
      --paper:  #faf8f4;
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

    #pgbar {
      position:fixed; top:0; left:0; height:2px;
      background:var(--crimson);
      z-index:9999; width:0; transition:width .1s linear;
    }

    /* Reveal */
    .reveal { opacity:0; transform:translateY(18px); transition:opacity .7s cubic-bezier(.22,1,.36,1),transform .7s cubic-bezier(.22,1,.36,1); }
    .reveal.on { opacity:1; transform:none; }
    .d1{transition-delay:.1s;} .d2{transition-delay:.2s;} .d3{transition-delay:.3s;} .d4{transition-delay:.4s;} .d5{transition-delay:.5s;}

    /* NAV */
    #nav { transition:all .35s ease; }
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
    .display { font-family:'Playfair Display',serif; letter-spacing:-.015em; line-height:1.05; }
    .garamond { font-family:'EB Garamond',serif; font-size:1.08rem; line-height:1.9; }
    .caption-text {
      font-family:'Inter',sans-serif;
      font-size:.68rem; letter-spacing:.1em; text-transform:uppercase; color:#6b6860;
    }
    .col-rule { border-top:1px solid var(--rule); }
    .col-rule-thick { border-top:2px solid var(--ink); }
    .col-rule-color { border-top:3px solid var(--royal); }

    /* Drop cap */
    .drop-cap::first-letter {
      float:left;
      font-family:'Playfair Display',serif;
      font-size:5rem; line-height:.82;
      padding-right:.1em; padding-top:.04em;
      color:var(--royal); font-weight:700;
    }

    /* Two-column editorial text */
    .two-col { column-count:2; column-gap:2.5rem; column-rule:1px solid var(--rule); }
    @media(max-width:640px){ .two-col{ column-count:1; } }

    /* Pull quote */
    .pull-quote {
      font-family:'Playfair Display',serif;
      font-style:italic;
      font-size:clamp(1.35rem,2.5vw,1.9rem);
      line-height:1.35; color:var(--ink);
      border-left:3px solid var(--royal);
      padding-left:1.25rem;
    }

    /* Big decorative open quote */
    .open-quote {
      font-family:'Playfair Display',serif;
      font-size:7rem; line-height:.6;
      opacity:.12; display:block;
    }

    /* Ticker */
    .ticker-wrap { overflow:hidden; white-space:nowrap; }
    .ticker-inner { display:inline-block; animation:ticker 32s linear infinite; }
    .ticker-inner:hover { animation-play-state:paused; }

    /* Card hover */
    .ed-card { transition:transform .3s cubic-bezier(.22,1,.36,1),box-shadow .3s; }
    .ed-card:hover { transform:translateY(-4px); box-shadow:0 12px 40px rgba(18,16,14,.1); }

    /* Donate pulse */
    @keyframes donateRing { 0%,100%{transform:scale(1);opacity:.4} 50%{transform:scale(1.06);opacity:.9} }
    .donate-ring { position:relative; }
    .donate-ring::before {
      content:''; position:absolute; inset:-3px;
      border:1.5px solid rgba(196,26,46,.4);
      animation:donateRing 2.5s ease-in-out infinite;
    }

    /* Article link underline grow */
    .article-link { position:relative; }
    .article-link::after {
      content:''; position:absolute; bottom:0; left:0;
      width:0; height:1px; background:var(--royal);
      transition:width .3s ease;
    }
    .article-link:hover::after { width:100%; }

    /* Progress bar for shimmer on donation */
    .shimmer-bar {
      background:linear-gradient(90deg,var(--royal) 0%,var(--royal-pale,#94b0f8) 50%,var(--royal) 100%);
      background-size:400px 100%;
      animation:shimmer 2s linear infinite;
    }
    @keyframes shimmer { from{background-position:-400px 0} to{background-position:400px 0} }

    /* Horizontal decorative ornament */
    .ornament { display:flex; align-items:center; gap:.75rem; }
    .ornament::before,.ornament::after { content:''; flex:1; border-top:1px solid var(--rule); }

    /* Hero overlay gradient */
    .hero-gradient {
      background:linear-gradient(
        100deg,
        rgba(9,24,52,.96) 0%,
        rgba(14,38,90,.88) 35%,
        rgba(20,52,140,.6) 62%,
        rgba(20,52,140,.18) 100%
      );
    }

    /* Section label strip */
    .section-label-strip {
      display:inline-flex; align-items:center; gap:.5rem;
      padding:.25rem .75rem .25rem 0;
    }
    .section-label-strip::before {
      content:''; display:block; width:28px; height:2px;
    }

    /* Amt button */
    .amt-btn { transition:all .2s; }
    .amt-btn.selected { background:var(--royal) !important; color:#fff !important; border-color:var(--royal) !important; }
  </style>
</head>
<body class="antialiased">

<div id="pgbar"></div>

<!-- ════════════════════════════════════════
     MASTHEAD TOP STRIP
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
     EDITORIAL MASTHEAD NAV
════════════════════════════════════════ -->
<header id="nav" class="fixed inset-x-0 top-0 z-50 md:relative md:z-auto md:top-auto md:fixed">
  <!-- Desktop nav inner -->
  <div class="max-w-7xl mx-auto px-6">

    <!-- Top info strip on mobile (fixed header only) -->
    {{-- <div class="md:hidden bg-ink text-paper/50 px-0 py-1 flex items-center justify-between">
      <span class="caption-text text-[.58rem]" style="color:rgba(250,248,244,.4);">Vol. 100 · Centennial</span>
      <span class="caption-text text-[.58rem] font-bold" style="color:rgba(250,248,244,.7);">HSSTian Chronicle</span>
      <span class="caption-text text-[.58rem]" style="color:rgba(250,248,244,.4);">1926–2026</span>
    </div> --}}

    <!-- Main nav row -->
    <div class="flex items-center justify-between py-3 md:py-4">
      <!-- Logo + Masthead -->
      <a href="#" class="flex items-center gap-3 group">
        <img
          src="{{ asset('images/hsstlogo.jpg') }}"
          alt="HSST Logo"
          class="h-8 md:h-9 w-auto object-contain"
        />
        <div class="leading-tight">
          <p class="font-display font-bold text-sm text-white md:text-ink transition-colors duration-300" id="logo-text"
             style="letter-spacing:-.01em;">HSSTian</p>
          <p class="caption-text text-[.54rem] text-white/50 md:text-ink/40 transition-colors duration-300" id="logo-sub">Alumni Association</p>
        </div>
      </a>

      <!-- Desktop Links -->
      <nav class="hidden md:flex items-center gap-7" id="nav-links">
        <a href="#about"
           class="caption-text text-white/70 md:text-ink/60 hover:text-white md:hover:text-ink transition-colors">About</a>
        <a href="{{ route('history') }}"
           class="caption-text text-white/70 md:text-ink/60 hover:text-white md:hover:text-ink transition-colors">History</a>
        <a href="#events"
           class="caption-text text-white/70 md:text-ink/60 hover:text-white md:hover:text-ink transition-colors">Events</a>
        <a href="#crusade"
           class="caption-text text-white/70 md:text-ink/60 hover:text-white md:hover:text-ink transition-colors">CRUSADE</a>
        <a href="#stories"
           class="caption-text text-white/70 md:text-ink/60 hover:text-white md:hover:text-ink transition-colors">Stories</a>
        <a href="#news"
           class="caption-text text-white/70 md:text-ink/60 hover:text-white md:hover:text-ink transition-colors">News</a>
        <a href="#contact"
           class="caption-text text-white/70 md:text-ink/60 hover:text-white md:hover:text-ink transition-colors">Contact</a>
      </nav>

      <!-- Desktop Auth + CTA -->
      <div class="hidden md:flex items-center gap-3" id="auth-links">
        <a id="login-btn" href="{{ route('login') }}"
           class="caption-text border border-white/25 md:border-ink/20 text-white/80 md:text-ink/60 px-4 py-2 hover:border-white/60 md:hover:border-ink/50 hover:text-white md:hover:text-ink transition-all">
          Login
        </a>
        <a href="{{ route('register') }}"
           class="caption-text bg-white md:bg-ink text-ink md:text-paper px-4 py-2 hover:opacity-80 transition-opacity">
          Register
        </a>
        <a href="#crusade"
           class="caption-text bg-crimson text-white px-5 py-2 hover:bg-crimson-light transition-colors font-bold" style="letter-spacing:.16em;">
          ✦ Donate
        </a>
      </div>

      <!-- Mobile hamburger -->
      <button id="mobile-menu-btn" type="button"
              class="md:hidden text-white transition-colors" aria-label="Open menu" aria-expanded="false">
        <svg id="menu-open-icon" class="w-6 h-6 block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
        </svg>
        <svg id="menu-close-icon" class="w-6 h-6 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
        </svg>
      </button>
    </div>

    <!-- Nav rule (desktop only) -->
    <hr class="col-rule hidden md:block" />

    <!-- Sub-nav label (desktop) -->
    <div class="hidden md:flex items-center justify-center py-1.5">
      <span class="caption-text text-ink/30 text-[.6rem]" style="letter-spacing:.3em;">
        HOLY SPIRIT SCHOOL OF TAGBILARAN ALUMNI
      </span>
    </div>
    <hr class="col-rule hidden md:block" />

  </div>
</header>

<!-- ════════════════════════════════════════
     MOBILE MENU
════════════════════════════════════════ -->
<div id="mobile-menu" class="fixed inset-0 z-[9999] hidden md:hidden bg-ink text-paper">
  <div class="flex h-dvh flex-col">
    <!-- Mobile menu header -->
    <div class="flex items-center justify-between px-6 py-5 border-b border-paper/10">
      <div>
        <p class="caption-text text-paper/40 text-[.6rem]" style="letter-spacing:.25em;">THE HSST IAN</p>
        <h2 class="font-display text-xl font-bold text-paper mt-0.5">Navigation</h2>
      </div>
      <button type="button" id="close-mobile-menu"
              class="w-10 h-10 flex items-center justify-center border border-paper/15 text-paper/60 hover:bg-paper/10 transition-colors text-sm">
        ✕
      </button>
    </div>
    <!-- Mobile links -->
    <nav class="flex-1 overflow-y-auto px-6 py-4 flex flex-col">
      <a href="#about" class="mobile-nav-link border-b border-paper/8 py-4 font-display text-lg text-paper/80 hover:text-paper transition-colors">About</a>
      <a href="#events" class="mobile-nav-link border-b border-paper/8 py-4 font-display text-lg text-paper/80 hover:text-paper transition-colors">Events</a>
      <a href="#crusade" class="mobile-nav-link border-b border-paper/8 py-4 font-display text-lg text-paper/80 hover:text-paper transition-colors">CRUSADE</a>
      <a href="#stories" class="mobile-nav-link border-b border-paper/8 py-4 font-display text-lg text-paper/80 hover:text-paper transition-colors">Stories</a>
      <a href="{{ route('history') }}" class="mobile-nav-link border-b border-paper/8 py-4 font-display text-lg text-paper/80 hover:text-paper transition-colors">History</a>
      <a href="#news" class="mobile-nav-link border-b border-paper/8 py-4 font-display text-lg text-paper/80 hover:text-paper transition-colors">News</a>
      <a href="#contact" class="mobile-nav-link py-4 font-display text-lg text-paper/80 hover:text-paper transition-colors">Contact</a>
    </nav>
    <!-- Mobile auth -->
    <div class="border-t border-paper/10 px-6 py-5 flex flex-col gap-3">
      <a href="{{ route('login') }}"
         class="flex items-center justify-center py-3 border border-paper/15 caption-text text-paper/70 hover:bg-paper/5 transition-colors">
        Login
      </a>
      <a href="{{ route('register') }}"
         class="flex items-center justify-center py-3 bg-paper caption-text text-ink hover:opacity-90 transition-opacity">
        Register
      </a>
      <a href="#crusade"
         class="flex items-center justify-center py-3 bg-crimson caption-text text-white font-bold hover:bg-crimson-light transition-colors">
        ✦ Donate Now
      </a>
    </div>
  </div>
</div>

<!-- ════════════════════════════════════════
     HERO — MAGAZINE COVER
════════════════════════════════════════ -->
<section class="relative min-h-[80vh] md:min-h-screen flex items-end overflow-hidden pt-24 md:pt-0">

  {{-- Full-bleed background image --}}
  <div class="absolute inset-0">
    <img
      src="{{ asset('images/hsstherosect1.png') }}"
      alt="Holy Spirit School of Tagbilaran"
      class="absolute inset-0 h-full w-full object-cover object-center"
    />
    <div class="absolute inset-0 hero-gradient"></div>
    {{-- Subtle grain --}}
    <div class="absolute inset-0 opacity-[.04]"
         style="background-image:url(data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='200' height='200'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='200' height='200' filter='url(%23n)' opacity='1'/%3E%3C/svg%3E);">
    </div>
  </div>

  {{-- Right-side decorative vertical rule --}}
  <div class="pointer-events-none absolute right-12 top-0 bottom-0 hidden xl:flex flex-col items-center justify-center opacity-10">
    <div class="h-64 w-px bg-white"></div>
    <div class="my-3 caption-text text-white" style="writing-mode:vertical-rl;letter-spacing:.3em;font-size:.6rem;">HOLY SPIRIT SCHOOL · 1926</div>
    <div class="h-64 w-px bg-white"></div>
  </div>

  {{-- Hero content --}}
  <div class="relative z-10 w-full max-w-7xl mx-auto px-6 sm:px-8 pb-16 sm:pb-20 md:pb-28">
    <div class="max-w-3xl">

      {{-- Issue tag --}}
      <div class="mb-6 flex items-center gap-3 animate-fade-up" style="animation-delay:.1s;">
        <div class="h-px w-10" style="background:var(--spirit);"></div>
        <span class="kicker" style="color:var(--spirit); letter-spacing:.25em;">
          Centennial Edition · 1926–2026
        </span>
      </div>

      {{-- Main headline --}}
      <h1 class="display text-white mb-6 animate-fade-up"
          style="font-size:clamp(3rem,8vw,6.5rem);animation-delay:.2s;">
        Come home<br/>
        <em style="color:var(--spirit);">to memory,</em><br class="hidden sm:block"/>
        legacy &amp; connection.
      </h1>

      {{-- Deck text (magazine intro) --}}
      <p class="garamond text-white/70 mb-8 max-w-xl animate-fade-up"
         style="font-size:clamp(1rem,1.5vw,1.15rem);animation-delay:.32s;">
        Welcome home, HSSTian. Thousands of alumni, united by faith, service,
        and the spirit of the Holy Cross, gather to shape the next century
        of Holy Spirit School.
      </p>

      {{-- CTA --}}
      <div class="flex flex-col sm:flex-row gap-3 mb-12 animate-fade-up" style="animation-delay:.42s;">
        <a href="#crusade"
           class="inline-flex items-center justify-center gap-2 bg-crimson text-white caption-text font-bold px-8 py-3.5 hover:bg-crimson-light transition-colors">
          Join the CRUSADE
          <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
          </svg>
        </a>
        <a href="#about"
           class="inline-flex items-center justify-center border border-white/30 text-white/80 caption-text px-8 py-3.5 hover:border-white/60 hover:text-white transition-all">
          Learn More
        </a>
      </div>

      {{-- Stats — editorial data points --}}
      <div class="flex flex-wrap items-start gap-x-8 gap-y-4 animate-fade-up" style="animation-delay:.52s;">
        <div class="border-l-2 pl-4" style="border-color:var(--spirit);">
          <p class="display text-white font-bold" style="font-size:2.2rem;">100<span style="color:var(--spirit);">+</span></p>
          <p class="caption-text text-white/40 mt-0.5">Years of Excellence</p>
        </div>
        <div class="border-l-2 pl-4" style="border-color:rgba(255,255,255,.15);">
          <p class="display text-white font-bold" style="font-size:2.2rem;">100K<span style="color:var(--spirit);">+</span></p>
          <p class="caption-text text-white/40 mt-0.5">Living Alumni</p>
        </div>
        <div class="border-l-2 pl-4" style="border-color:rgba(255,255,255,.15);">
          <p class="display text-white font-bold" style="font-size:2.2rem;">3</p>
          <p class="caption-text text-white/40 mt-0.5">CRUSADE Pillars</p>
        </div>
      </div>

    </div>
  </div>

  {{-- Bottom scrim --}}
  <div class="absolute inset-x-0 bottom-0 h-20" style="background:linear-gradient(to top,var(--paper),transparent);"></div>
</section>

<!-- ════════════════════════════════════════
     WELCOME — EDITORIAL INTRO
════════════════════════════════════════ -->
<section class="bg-paper py-20 sm:py-24">
  <div class="max-w-4xl mx-auto px-6 text-center">

    <div class="ornament mb-5 reveal">
      <span class="kicker text-royal">Welcome Home, Crusaders</span>
    </div>

    {{-- Large pull quote --}}
    <blockquote class="display text-ink reveal d1"
                style="font-size:clamp(1.7rem,3.5vw,2.8rem);line-height:1.2;font-style:italic;">
      "Whether you studied in <span style="color:var(--royal);">1926</span>
      or <span style="color:var(--royal);">{{ now('Asia/Manila')->format('Y') }}</span>,
      you are part of our alumni family."
    </blockquote>

    <hr class="col-rule my-8 reveal d2"/>

    <div class="two-col text-left reveal d2">
      <p class="garamond text-ink/70">
        Our powerful network now includes more than
        <strong class="text-ink">100,000 alumni</strong>, and continues
        to grow each year. No matter where life has taken you, Holy Spirit School
        will always be home. We look forward to welcoming you back.
      </p>
      <p class="garamond text-ink/70 mt-4">
        Please explore the <strong class="text-ink">Calendar of Activities</strong>
        we have prepared for everyone to participate in and enjoy.
        Your presence — and your story — complete this centennial chapter.
      </p>
    </div>

    <div class="mt-10 flex flex-wrap justify-center gap-4 reveal d3">
      <a href="#events"
         class="caption-text font-bold bg-royal text-white px-7 py-3 hover:bg-royal-dark transition-colors">
        View Activities
      </a>
      <a href="#about"
         class="caption-text font-bold border border-ink/20 text-ink/70 px-7 py-3 hover:border-ink/50 hover:text-ink transition-all">
        Learn More
      </a>
    </div>
  </div>
</section>

<!-- ════════════════════════════════════════
     BREAKING NEWS TICKER
════════════════════════════════════════ -->
<div class="flex items-stretch border-y border-ink/10" style="background:var(--ink);">
  {{-- Label --}}
  <div class="shrink-0 flex items-center px-5 border-r border-paper/10" style="background:var(--crimson);">
    <span class="caption-text text-white font-bold" style="letter-spacing:.22em;">LATEST</span>
  </div>
  {{-- Ticker --}}
  <div class="ticker-wrap flex-1 py-2.5">
    <div class="ticker-inner caption-text text-paper/50">
      <span class="mx-8">HSSTian Alumni Centennial Celebration — 1926 to 2026</span>
      <span class="mx-3" style="color:var(--spirit);">✦</span>
      <span class="mx-8">CRUSADE Campaign · Target: PhP 100,000 per Batch</span>
      <span class="mx-3" style="color:var(--spirit);">✦</span>
      <span class="mx-8">Crusaders Scholarship Fund Now Open</span>
      <span class="mx-3" style="color:var(--spirit);">✦</span>
      <span class="mx-8">Every Gift Leaves a Lasting Impact</span>
      <span class="mx-3" style="color:var(--spirit);">✦</span>
      <span class="mx-8">Faculty Development Fund · Donate Today</span>
      <span class="mx-3" style="color:var(--spirit);">✦</span>
      <span class="mx-8">Elevating Campus Experience for Future Crusaders</span>
      <span class="mx-3" style="color:var(--spirit);">✦</span>
      <span class="mx-8">HSSTian Alumni Centennial Celebration — 1926 to 2026</span>
      <span class="mx-3" style="color:var(--spirit);">✦</span>
      <span class="mx-8">CRUSADE Campaign · Target: PhP 100,000 per Batch</span>
      <span class="mx-3" style="color:var(--spirit);">✦</span>
      <span class="mx-8">Crusaders Scholarship Fund Now Open</span>
      <span class="mx-3" style="color:var(--spirit);">✦</span>
      <span class="mx-8">Every Gift Leaves a Lasting Impact</span>
      <span class="mx-3" style="color:var(--spirit);">✦</span>
      <span class="mx-8">Faculty Development Fund · Donate Today</span>
      <span class="mx-3" style="color:var(--spirit);">✦</span>
      <span class="mx-8">Elevating Campus Experience for Future Crusaders</span>
      <span class="mx-3" style="color:var(--spirit);">✦</span>
    </div>
  </div>
</div>

<!-- ════════════════════════════════════════
     ABOUT — FEATURE ARTICLE LAYOUT
════════════════════════════════════════ -->
<section id="about" class="py-20 sm:py-28" style="background:var(--paper);">
  <div class="max-w-7xl mx-auto px-6">

    {{-- Section header --}}
    <div class="mb-12 reveal">
      <hr class="col-rule-thick mb-3"/>
      <div class="flex items-center justify-between">
        <span class="kicker text-royal">Feature Story</span>
        <span class="caption-text text-ink/30">No. 001 · Centennial Issue</span>
      </div>
      <hr class="col-rule mt-3"/>
    </div>

    <div class="grid items-start gap-12 lg:grid-cols-5 lg:gap-16">

      {{-- Text side (3 cols) --}}
      <div class="lg:col-span-3 order-2 lg:order-1">

        <h2 class="display text-ink reveal" style="font-size:clamp(2.2rem,4vw,3.4rem);">
          Rooted in Faith.<br/>
          Driven by Service.<br/>
          <em style="color:var(--royal);">United as One.</em>
        </h2>

        <div class="flex flex-wrap gap-2 mt-5 mb-7 reveal d1">
          <span class="caption-text border border-royal/20 text-royal px-3 py-1.5" style="background:var(--royal-frost,#eef2ff);">Faith-Based Community</span>
          <span class="caption-text border border-teal/20 text-teal px-3 py-1.5" style="background:var(--teal-pale,#d4f0eb);">Scholarship Programs</span>
          <span class="caption-text border border-spirit/20 text-spirit px-3 py-1.5" style="background:var(--spirit-pale,#f5e4a0);">Academic Excellence</span>
          <span class="caption-text border border-crimson/20 text-crimson px-3 py-1.5" style="background:var(--crimson-pale,#fde8eb);">Campus Development</span>
        </div>

        <p class="garamond text-ink/70 drop-cap reveal d2">
          The HSSTian Alumni Association is the official organization of graduates
          of Holy Spirit School of Tagbilaran — the Crusaders. For generations, we have
          carried the school's mission of truth, love, and excellence far beyond the
          campus gates, into every corner of the Philippines and the world.
        </p>

        <p class="garamond text-ink/70 mt-5 reveal d2">
          As we approach our Centennial, we are called once again to give back — to the
          school that shaped our character, deepened our faith, and ignited our purpose.
          The HSSTian Alumni Association is the bridge between the legacy of the past
          and the promise of the future.
        </p>

        {{-- Pull quote --}}
        <div class="my-8 reveal d3">
          <blockquote class="pull-quote">
            "A hundred years of shaping hearts, minds, and lives — and still only beginning."
          </blockquote>
        </div>

      </div>

      {{-- Image side (2 cols) --}}
      <div class="lg:col-span-2 order-1 lg:order-2 reveal d1">
        <div
          x-data="{
            current: 0,
            slides: [
              '{{ asset('images/image1.jpg') }}',
              '{{ asset('images/image2.jpg') }}',
              '{{ asset('images/image3.jpg') }}',
              '{{ asset('images/image4.jpg') }}'
            ],
            interval: null,
            start() { this.stop(); this.interval = setInterval(()=>{ this.current=(this.current+1)%this.slides.length; },4000); },
            stop()  { if(this.interval) clearInterval(this.interval); },
            next()  { this.current=(this.current+1)%this.slides.length; },
            prev()  { this.current=(this.current-1+this.slides.length)%this.slides.length; }
          }"
          x-init="start()"
          @mouseenter="stop()"
          @mouseleave="start()"
        >
          {{-- Photo --}}
          <div class="relative overflow-hidden bg-paper-dark" style="aspect-ratio:4/5;">
            <template x-for="(slide, index) in slides" :key="index">
              <div x-show="current===index"
                   x-transition:enter="transition ease-out duration-600"
                   x-transition:enter-start="opacity-0"
                   x-transition:enter-end="opacity-100"
                   x-transition:leave="transition ease-in duration-400"
                   x-transition:leave-start="opacity-100"
                   x-transition:leave-end="opacity-0"
                   class="absolute inset-0">
                <img :src="slide" alt="HSST Centennial" class="w-full h-full object-contain"/>
              </div>
            </template>
            {{-- Nav arrows --}}
            <button @click="prev()" type="button"
                    class="absolute left-3 top-1/2 -translate-y-1/2 z-10 w-9 h-9 flex items-center justify-center bg-paper/90 text-ink border border-ink/10 hover:bg-paper transition-colors text-xs">
              &#10094;
            </button>
            <button @click="next()" type="button"
                    class="absolute right-3 top-1/2 -translate-y-1/2 z-10 w-9 h-9 flex items-center justify-center bg-paper/90 text-ink border border-ink/10 hover:bg-paper transition-colors text-xs">
              &#10095;
            </button>
            {{-- Badge --}}
            <div class="absolute top-3 left-3 bg-ink px-3 py-1.5">
              <span class="caption-text text-paper font-bold">HSST Centennial</span>
            </div>
          </div>

          {{-- Dots --}}
          <div class="flex justify-center gap-1.5 mt-3">
            <template x-for="(slide, index) in slides" :key="'dot-'+index">
              <button @click="current=index" type="button"
                      class="h-1 rounded-none transition-all duration-300"
                      :class="current===index ? 'w-6 bg-ink' : 'w-1.5 bg-ink/25 hover:bg-ink/40'">
              </button>
            </template>
          </div>

          {{-- Caption --}}
          <p class="caption-text text-ink/40 mt-3 text-center">
            Holy Spirit School · Tagbilaran City, Bohol · Est. 1926
          </p>
        </div>

        {{-- Data strip --}}
        <div class="mt-5 border border-ink/10 grid grid-cols-3 text-center divide-x divide-ink/10">
          <div class="py-4 px-2">
            <p class="display font-bold text-ink text-xl">1926</p>
            <p class="caption-text text-ink/35 mt-1">Founded</p>
          </div>
          <div class="py-4 px-2">
            <p class="display font-bold text-ink text-xl">Tagbilaran</p>
            <p class="caption-text text-ink/35 mt-1">Bohol, Philippines</p>
          </div>
          <div class="py-4 px-2">
            <p class="display font-bold text-ink text-xl">100<span style="color:var(--spirit);">yrs</span></p>
            <p class="caption-text text-ink/35 mt-1">Centennial</p>
          </div>
        </div>
      </div>

    </div>
  </div>
</section>

<!-- ════════════════════════════════════════
     CRUSADE — MAGAZINE CAMPAIGN SPREAD
════════════════════════════════════════ -->
<section id="crusade" class="relative py-20 sm:py-28 overflow-hidden" style="background:var(--ink);">

  {{-- Dot pattern --}}
  <div class="pointer-events-none absolute inset-0 opacity-[.04]"
       style="background-image:radial-gradient(circle at 50% 50%,rgba(250,248,244,1) 1px,transparent 1px);background-size:36px 36px;">
  </div>

  {{-- Crimson accent bar --}}
  <div class="absolute top-0 left-0 w-full h-1" style="background:var(--crimson);"></div>

  <div class="relative z-10 max-w-7xl mx-auto px-6">

    {{-- Section header --}}
    <div class="mb-12 reveal">
      <hr style="border-top:2px solid rgba(250,248,244,.15);" class="mb-3"/>
      <div class="flex items-center justify-between">
        <span class="kicker" style="color:var(--spirit);">Centennial Giving Campaign</span>
        <span class="caption-text" style="color:rgba(250,248,244,.2);">No. 002 · Centennial Issue</span>
      </div>
      <hr style="border-top:1px solid rgba(250,248,244,.08);" class="mt-3"/>
    </div>

    {{-- Headline --}}
    <div class="text-center mb-14 reveal d1">
      <h2 class="display text-paper" style="font-size:clamp(2.5rem,7vw,5.5rem);">
        Join the <em style="color:var(--spirit);">CRUSADE.</em>
      </h2>
      <p class="garamond mt-4 max-w-2xl mx-auto" style="color:rgba(250,248,244,.55);">
        Be generous. Join us in shaping a brighter future for our students and community,
        where every gift — regardless of size — leaves a lasting impact.
      </p>
    </div>

    {{-- Donation form + copy --}}
    <div class="reveal d2 border border-paper/10 grid md:grid-cols-2 gap-0 mb-14">

      {{-- Left: copy --}}
      <div class="p-8 md:p-12 border-b md:border-b-0 md:border-r border-paper/10">
        <span class="kicker block mb-4" style="color:var(--spirit);">Your Legacy Gift</span>
        <h3 class="display text-paper mb-5" style="font-size:clamp(1.6rem,3vw,2.4rem);">
          Your generosity can leave an <em>enduring legacy.</em>
        </h3>
        <p class="garamond mb-4" style="color:rgba(250,248,244,.55);">
          Although <strong style="color:var(--spirit);">PhP 100,000 per batch</strong> is recommended,
          every gift — no matter the amount — is invaluable and will be cherished deeply.
        </p>
        <p class="garamond" style="color:rgba(250,248,244,.55);">
          Your support will fuel our Centennial Celebrations, enhancing campus life,
          expanding financial aid, and driving academic and scholarship excellence.
        </p>

        {{-- Three pillars summary --}}
        <div class="mt-8 space-y-4">
          <div class="flex gap-3 items-start">
            <div class="w-5 h-5 flex-shrink-0 flex items-center justify-center mt-0.5" style="background:var(--spirit);">
              <span class="text-ink caption-text font-bold text-[.6rem]">I</span>
            </div>
            <div>
              <p class="caption-text text-paper/70 font-bold">Elevating Campus Experience</p>
              <p class="caption-text text-paper/35 mt-0.5" style="letter-spacing:.04em;font-size:.65rem;text-transform:none;">Transformative upgrades to learning spaces and technology</p>
            </div>
          </div>
          <div class="flex gap-3 items-start">
            <div class="w-5 h-5 flex-shrink-0 flex items-center justify-center mt-0.5" style="background:var(--royal);">
              <span class="text-white caption-text font-bold text-[.6rem]">II</span>
            </div>
            <div>
              <p class="caption-text text-paper/70 font-bold">Faculty Development</p>
              <p class="caption-text text-paper/35 mt-0.5" style="letter-spacing:.04em;font-size:.65rem;text-transform:none;">Investing in the educators who shape future Crusaders</p>
            </div>
          </div>
          <div class="flex gap-3 items-start">
            <div class="w-5 h-5 flex-shrink-0 flex items-center justify-center mt-0.5" style="background:var(--teal);">
              <span class="text-white caption-text font-bold text-[.6rem]">III</span>
            </div>
            <div>
              <p class="caption-text text-paper/70 font-bold">Crusaders Scholarship Fund</p>
              <p class="caption-text text-paper/35 mt-0.5" style="letter-spacing:.04em;font-size:.65rem;text-transform:none;">Empowering students to reach new heights</p>
            </div>
          </div>
        </div>
      </div>

      {{-- Right: Donation form --}}
      <div class="bg-paper p-8 md:p-12">
        <p class="display font-bold text-ink text-xl mb-1">Make Your Gift Today</p>
        <p class="caption-text text-ink/40 mb-7">Choose an amount or enter your own</p>

        <div class="mb-5 grid grid-cols-3 gap-2" id="amount-grid">
          <button onclick="selectAmt(this,'500')" class="amt-btn border border-ink/15 bg-paper-dark py-2.5 caption-text font-bold text-ink hover:bg-ink hover:text-paper hover:border-ink transition-all">₱500</button>
          <button onclick="selectAmt(this,'1000')" class="amt-btn border border-ink/15 bg-paper-dark py-2.5 caption-text font-bold text-ink hover:bg-ink hover:text-paper hover:border-ink transition-all">₱1,000</button>
          <button onclick="selectAmt(this,'5000')" class="amt-btn border border-ink/15 bg-paper-dark py-2.5 caption-text font-bold text-ink hover:bg-ink hover:text-paper hover:border-ink transition-all">₱5,000</button>
          <button onclick="selectAmt(this,'10000')" class="amt-btn border border-ink/15 bg-paper-dark py-2.5 caption-text font-bold text-ink hover:bg-ink hover:text-paper hover:border-ink transition-all">₱10,000</button>
          <button onclick="selectAmt(this,'50000')" class="amt-btn border border-ink/15 bg-paper-dark py-2.5 caption-text font-bold text-ink hover:bg-ink hover:text-paper hover:border-ink transition-all">₱50,000</button>
          <button onclick="selectAmt(this,'100000')" class="amt-btn border-2 py-2.5 caption-text font-bold text-white transition-all" style="background:var(--spirit);border-color:var(--spirit);">₱100,000 ✦</button>
        </div>

        <div class="mb-4">
          <label class="caption-text text-ink/50 block mb-1.5">Or enter custom amount (PhP)</label>
          <div class="flex items-center border-2 border-ink/15 focus-within:border-ink transition-colors">
            <span class="px-3 caption-text font-bold text-ink/40">₱</span>
            <input id="custom-amt" type="number" placeholder="Enter amount"
                   class="flex-1 py-3 pr-4 caption-text text-ink outline-none bg-transparent"
                   oninput="clearSelected()"/>
          </div>
        </div>

        <div class="mb-4">
          <label class="caption-text text-ink/50 block mb-1.5">Full Name</label>
          <input type="text" placeholder="Juan dela Cruz"
                 class="w-full border-2 border-ink/15 px-4 py-3 caption-text text-ink outline-none focus:border-ink transition-colors bg-paper"/>
        </div>

        <div class="mb-7">
          <label class="caption-text text-ink/50 block mb-1.5">Batch Year</label>
          <input type="text" placeholder="e.g. 1998, 2005, 2012"
                 class="w-full border-2 border-ink/15 px-4 py-3 caption-text text-ink outline-none focus:border-ink transition-colors bg-paper"/>
        </div>

        <button class="donate-ring w-full flex items-center justify-center gap-2 bg-crimson text-white caption-text font-bold py-4 hover:bg-crimson-light transition-colors">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
          </svg>
          Give Now · Fueled by Compassion
        </button>
        <p class="caption-text text-ink/25 text-center mt-3" style="letter-spacing:.06em;text-transform:none;">All donations are acknowledged &amp; deeply cherished</p>
      </div>
    </div>

    {{-- Three pillars -- detailed --}}
    <div class="grid md:grid-cols-3 gap-0 border border-paper/10 reveal d3">
      <div class="p-8 border-b md:border-b-0 md:border-r border-paper/10">
        <div class="flex items-center gap-3 mb-6">
          <div class="w-8 h-8 flex items-center justify-center" style="background:var(--spirit);">
            <svg class="w-4 h-4 text-ink" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
            </svg>
          </div>
          <span class="caption-text font-bold" style="color:var(--spirit);">Pillar One</span>
        </div>
        <h4 class="display text-paper text-xl font-bold mb-3">Elevating Campus Experience</h4>
        <p class="garamond" style="color:rgba(250,248,244,.45);font-size:.95rem;">
          Transformative upgrades to learning spaces, facilities, and technology —
          ensuring every student thrives in an environment worthy of their potential.
        </p>
      </div>

      <div class="p-8 border-b md:border-b-0 md:border-r border-paper/10" style="background:rgba(26,63,196,.12);">
        <div class="flex items-center gap-3 mb-6">
          <div class="w-8 h-8 flex items-center justify-center" style="background:var(--royal);">
            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
            </svg>
          </div>
          <span class="caption-text font-bold text-paper/50">Pillar Two</span>
        </div>
        <h4 class="display text-paper text-xl font-bold mb-3">Faculty Development</h4>
        <p class="garamond" style="color:rgba(250,248,244,.55);font-size:.95rem;">
          Investing in the dedicated educators who shape future Crusaders — through training,
          scholarships, and professional growth programs.
        </p>
      </div>

      <div class="p-8">
        <div class="flex items-center gap-3 mb-6">
          <div class="w-8 h-8 flex items-center justify-center" style="background:var(--teal);">
            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
            </svg>
          </div>
          <span class="caption-text font-bold" style="color:var(--teal-light,#0f9980);">Pillar Three</span>
        </div>
        <h4 class="display text-paper text-xl font-bold mb-3">Crusaders Scholarship Fund</h4>
        <p class="garamond" style="color:rgba(250,248,244,.45);font-size:.95rem;">
          Empowering student-athletes to reach new heights — funding equipment, training,
          and competitions that build character through sportsmanship.
        </p>
      </div>
    </div>

  </div>
</section>

<!-- ════════════════════════════════════════
     EVENTS — EDITORIAL CALENDAR
════════════════════════════════════════ -->
<section id="events" class="py-20 sm:py-28" style="background:var(--paper-dark,#f0ece3);">
  <div class="max-w-7xl mx-auto px-6">

    {{-- Section header --}}
    <div class="mb-12 reveal">
      <hr class="col-rule-thick mb-3"/>
      <div class="flex items-end justify-between">
        <div>
          <span class="kicker text-teal">Upcoming</span>
          <h2 class="display text-ink mt-1" style="font-size:clamp(2rem,3.5vw,3rem);">Alumni Events</h2>
        </div>
        <div class="flex items-end gap-4 mb-1">
          <span class="caption-text text-ink/30">No. 003 · Centennial Issue</span>
          <a href="{{ route('events.index') }}"
             class="caption-text font-bold border-b border-ink/30 text-ink/60 hover:text-ink hover:border-ink transition-all pb-0.5">
            View All →
          </a>
        </div>
      </div>
      <hr class="col-rule mt-3"/>
    </div>

    @if ($events->isNotEmpty())
      <div class="grid gap-8 sm:gap-6 md:grid-cols-2 xl:grid-cols-3">
        @foreach ($events as $event)
          @php
            $eventDate = \Carbon\Carbon::parse($event->event_date);
            $isFeatured = $loop->first;
            $bannerUrl = $event->banner_image
              ? \Illuminate\Support\Facades\Storage::disk('s3')->url($event->banner_image)
              : asset('images/100yearsevent.jpg');
          @endphp

          <article class="ed-card reveal d{{ $loop->iteration }} flex flex-col bg-paper border border-ink/10 overflow-hidden group">
            {{-- Image --}}
            <div class="relative h-52 overflow-hidden">
              <img src="{{ $bannerUrl }}" alt="{{ $event->title }}"
                   class="h-full w-full object-cover transition duration-700 group-hover:scale-105"/>
              <div class="absolute inset-0 bg-gradient-to-b from-transparent via-transparent to-ink/40"></div>

              {{-- Date block --}}
              <div class="absolute top-4 left-4 bg-paper px-3 py-2 text-center min-w-[52px]">
                <span class="display font-bold text-ink block text-xl leading-none">{{ $eventDate->format('d') }}</span>
                <span class="caption-text text-ink/50 block mt-0.5">{{ $eventDate->format('M') }}</span>
              </div>

              {{-- Tag --}}
              <div class="absolute top-4 right-4">
                @if ($isFeatured)
                  <span class="caption-text font-bold px-3 py-1.5 text-white" style="background:var(--crimson);">Featured</span>
                @else
                  <span class="caption-text font-bold px-3 py-1.5 bg-paper/85 text-ink">Upcoming</span>
                @endif
              </div>
            </div>

            {{-- Content --}}
            <div class="flex flex-1 flex-col p-6">
              <span class="kicker text-royal mb-2">{{ $eventDate->format('F Y') }}</span>
              <h3 class="display font-bold text-ink text-lg leading-snug mb-3 group-hover:text-royal transition-colors">
                {{ $event->title }}
              </h3>
              <p class="garamond text-ink/55 mb-4 flex-1" style="font-size:.95rem;line-height:1.75;">
                {{ \Illuminate\Support\Str::limit($event->description ?: 'Stay tuned for more details about this upcoming alumni event.', 110) }}
              </p>
              <div class="flex items-center gap-2 caption-text text-ink/40 mb-5">
                <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                </svg>
                <span>{{ $event->venue ?: 'Venue to be announced' }}</span>
              </div>
              @if (Route::has('events.show'))
                <a href="{{ route('events.show', $event->slug) }}"
                   class="caption-text font-bold text-royal article-link inline-block self-start hover:text-royal-dark transition-colors">
                  Read More →
                </a>
              @endif
            </div>
          </article>
        @endforeach
      </div>
    @else
      <div class="reveal border border-ink/10 bg-paper p-12 text-center">
        <p class="display text-2xl text-ink mb-2">No upcoming events yet</p>
        <p class="garamond text-ink/45">Please check back soon for the latest alumni gatherings and centennial activities.</p>
      </div>
    @endif

  </div>
</section>

<!-- ════════════════════════════════════════
     STORIES — PULL QUOTES EDITORIAL
════════════════════════════════════════ -->
<section id="stories" class="py-20 sm:py-28 bg-paper">
  <div class="max-w-7xl mx-auto px-6">

    {{-- Section header --}}
    <div class="mb-14 reveal">
      <hr class="col-rule-thick mb-3"/>
      <div class="flex items-center justify-between">
        <span class="kicker text-crimson">Alumni Voices</span>
        <span class="caption-text text-ink/30">No. 004 · Centennial Issue</span>
      </div>
      <h2 class="display text-ink mt-2" style="font-size:clamp(2rem,3.5vw,3rem);">
        Crusaders Who <em style="color:var(--royal);">Carried the Cross.</em>
      </h2>
      <hr class="col-rule mt-3"/>
    </div>

    <div class="grid md:grid-cols-3 gap-8">

      {{-- Story 1 --}}
      <div class="reveal d1 border-t-2 pt-7" style="border-color:var(--royal);">
        <span class="open-quote" style="color:var(--royal);">"</span>
        <blockquote class="garamond italic text-ink/80 text-base leading-relaxed mb-7 -mt-4">
          As Holy Spirit School of Tagbilaran celebrates 100 years of inspiring young minds and souls,
          I'm filled with pride and purpose. My own journey was shaped by HSST's values and teachings,
          and now it's our chance to pay it forward. Let's come together to invest in the future
          through our beloved Alma Mater.
        </blockquote>
        <hr class="col-rule mb-5"/>
        <div class="flex items-center gap-3">
          <div class="w-9 h-9 flex items-center justify-center caption-text font-bold text-white shrink-0"
               style="background:linear-gradient(135deg,#0f2580,#1a3fc4);">SS</div>
          <div>
            <p class="caption-text font-bold text-ink">Steven Sarigumba Suganob</p>
            <p class="caption-text text-ink/35 mt-0.5" style="letter-spacing:.1em;font-size:.6rem;text-transform:none;">Elementary Batch 1987</p>
          </div>
        </div>
      </div>

      {{-- Story 2 (highlighted) --}}
      <div class="reveal d2 border-t-2 pt-7" style="border-color:var(--crimson);background:var(--ink);padding:2rem;">
        <span class="open-quote" style="color:var(--crimson);">"</span>
        <blockquote class="garamond italic text-paper/75 text-base leading-relaxed mb-7 -mt-4">
          Being a Crusader is a lifelong identity. When I heard about the CRUSADE campaign,
          I didn't hesitate — this school gave me everything. It's our turn to give back.
        </blockquote>
        <hr style="border-top:1px solid rgba(250,248,244,.12);" class="mb-5"/>
        <div class="flex items-center gap-3">
          <div class="w-9 h-9 flex items-center justify-center caption-text font-bold text-paper shrink-0"
               style="background:rgba(250,248,244,.1);border:1px solid rgba(250,248,244,.15);">JP</div>
          <div>
            <p class="caption-text font-bold text-paper">Jose Paolo Dizon</p>
            <p class="caption-text text-paper/35 mt-0.5" style="letter-spacing:.1em;font-size:.6rem;text-transform:none;">Batch 2005 · Engineer, Cebu</p>
          </div>
        </div>
      </div>

      {{-- Story 3 --}}
      <div class="reveal d3 border-t-2 pt-7" style="border-color:var(--teal);">
        <span class="open-quote" style="color:var(--teal);">"</span>
        <blockquote class="garamond italic text-ink/80 text-base leading-relaxed mb-7 -mt-4">
          I grew up in a simple home in Tagbilaran. HSS believed in me before I believed
          in myself. A gift from a hundred alumni changes one child's entire trajectory.
        </blockquote>
        <hr class="col-rule mb-5"/>
        <div class="flex items-center gap-3">
          <div class="w-9 h-9 flex items-center justify-center caption-text font-bold text-white shrink-0"
               style="background:var(--teal);">AL</div>
          <div>
            <p class="caption-text font-bold text-ink">Ana Luz Santillan</p>
            <p class="caption-text text-ink/35 mt-0.5" style="letter-spacing:.1em;font-size:.6rem;text-transform:none;">Batch 2012 · Nurse, Dubai</p>
          </div>
        </div>
      </div>

    </div>
  </div>
</section>

<!-- ════════════════════════════════════════
     NEWS — NEWSPAPER-COLUMN LAYOUT
════════════════════════════════════════ -->
<section id="news" class="py-20 sm:py-28" style="background:var(--paper-dark,#f0ece3);">
  <div class="max-w-7xl mx-auto px-6">

    {{-- Section header --}}
    <div class="mb-12 reveal">
      <hr class="col-rule-thick mb-3"/>
      <div class="flex items-end justify-between">
        <div>
          <span class="kicker text-spirit">Latest</span>
          <h2 class="display text-ink mt-1" style="font-size:clamp(2rem,3.5vw,3rem);">News &amp; Updates</h2>
        </div>
        <div class="flex items-end gap-4 mb-1">
          <span class="caption-text text-ink/30">No. 005 · Centennial Issue</span>
          @if(Route::has('announcements.index'))
            <a href="{{ route('announcements.index') }}"
               class="caption-text font-bold border-b border-ink/30 text-ink/60 hover:text-ink hover:border-ink transition-all pb-0.5">
              All News →
            </a>
          @endif
        </div>
      </div>
      <hr class="col-rule mt-3"/>
    </div>

    @if ($announcements->isNotEmpty())
      @php
        $featuredAnnouncement = $announcements->first();
        $sideAnnouncements = $announcements->slice(1, 2);
        $featuredDate = $featuredAnnouncement->published_at
          ? \Carbon\Carbon::parse($featuredAnnouncement->published_at)
          : \Carbon\Carbon::parse($featuredAnnouncement->created_at);
      @endphp

      <div class="grid md:grid-cols-3 gap-0 border border-ink/10">

        {{-- Featured article --}}
        <article class="md:col-span-2 border-r border-ink/10 ed-card group">
          {{-- Color masthead for featured --}}
          <div class="h-52 relative overflow-hidden" style="background:linear-gradient(135deg,var(--royal-deeper,#091852),var(--royal),var(--royal-light,#2952d9));">
            <div class="absolute inset-0 flex items-center justify-center opacity-[.07]">
              <p class="display text-white font-black" style="font-size:10rem;">
                {{ $featuredAnnouncement->pinned ? '★' : 'HSST' }}
              </p>
            </div>
            <div class="absolute inset-x-0 bottom-0 p-6 flex items-end justify-between">
              <span class="caption-text font-bold px-3 py-1.5 text-white" style="background:var(--crimson);">
                {{ $featuredAnnouncement->pinned ? 'Pinned' : 'Announcement' }}
              </span>
              <span class="caption-text text-white/40">
                {{ $featuredDate->timezone('Asia/Manila')->format('F j, Y') }}
              </span>
            </div>
          </div>
          <div class="p-8">
            <span class="kicker text-royal block mb-3">{{ $featuredAnnouncement->pinned ? 'Important Update' : 'Latest Update' }}</span>
            <h3 class="display text-ink text-2xl font-bold mb-4 leading-snug group-hover:text-royal transition-colors">
              {{ $featuredAnnouncement->title }}
            </h3>
            <p class="garamond text-ink/55" style="font-size:.98rem;">
              {{ \Illuminate\Support\Str::limit($featuredAnnouncement->body ?? 'Stay tuned for the latest alumni news and official announcements.', 200) }}
            </p>
            @if(Route::has('announcements.show'))
              <div class="mt-6">
                <a href="{{ route('announcements.show', $featuredAnnouncement->id) }}"
                   class="caption-text font-bold text-royal article-link hover:text-royal-dark transition-colors">
                  Read Full Article →
                </a>
              </div>
            @endif
          </div>
        </article>

        {{-- Side articles --}}
        <div class="flex flex-col divide-y divide-ink/10">
          @forelse ($sideAnnouncements as $announcement)
            @php
              $newsDate = $announcement->published_at
                ? \Carbon\Carbon::parse($announcement->published_at)
                : \Carbon\Carbon::parse($announcement->created_at);
            @endphp
            <article class="ed-card group flex-1 flex flex-col">
              <div class="h-28 {{ $loop->first ? '' : '' }}"
                   style="background:{{ $loop->first ? 'linear-gradient(135deg,#0f2580,#2952d9)' : 'linear-gradient(135deg,var(--spirit),#e8b80f)' }};">
              </div>
              <div class="p-6 flex-1 flex flex-col">
                <span class="kicker text-ink/40 block mb-1">
                  {{ $announcement->pinned ? 'Pinned Update' : 'Announcement' }}
                </span>
                <h3 class="display text-ink font-bold text-sm leading-snug group-hover:text-royal transition-colors flex-1">
                  {{ \Illuminate\Support\Str::limit($announcement->title, 85) }}
                </h3>
                <p class="caption-text text-ink/30 mt-3" style="text-transform:none;letter-spacing:.04em;font-size:.67rem;">
                  {{ $newsDate->timezone('Asia/Manila')->format('M j, Y') }}
                </p>
                @if(Route::has('announcements.show'))
                  <a href="{{ route('announcements.show', $announcement->id) }}"
                     class="caption-text font-bold text-royal article-link mt-3 inline-block hover:text-royal-dark transition-colors">
                    Read More →
                  </a>
                @endif
              </div>
            </article>
          @empty
            <article class="ed-card group flex-1 flex flex-col">
              <div class="h-28" style="background:linear-gradient(135deg,#0f2580,#2952d9);"></div>
              <div class="p-6">
                <p class="caption-text text-ink/40 mb-1">Announcement</p>
                <h3 class="display text-ink font-bold text-sm leading-snug">More updates will be posted soon</h3>
                <p class="caption-text text-ink/25 mt-3" style="text-transform:none;">{{ now('Asia/Manila')->format('M j, Y') }}</p>
              </div>
            </article>
            <article class="ed-card group flex-1 flex flex-col">
              <div class="h-28" style="background:linear-gradient(135deg,var(--spirit),#e8b80f);"></div>
              <div class="p-6">
                <p class="caption-text text-ink/40 mb-1">Announcement</p>
                <h3 class="display text-ink font-bold text-sm leading-snug">Stay tuned for Centennial news</h3>
                <p class="caption-text text-ink/25 mt-3" style="text-transform:none;">{{ now('Asia/Manila')->format('M j, Y') }}</p>
              </div>
            </article>
          @endforelse
        </div>

      </div>
    @else
      <div class="reveal border border-ink/10 bg-paper p-12 text-center">
        <p class="display text-2xl text-ink mb-2">No news yet</p>
        <p class="garamond text-ink/45">Please check back soon for the latest alumni announcements and updates.</p>
      </div>
    @endif

  </div>
</section>

<!-- ════════════════════════════════════════
     CTA — EDITORIAL FULL-BLEED
════════════════════════════════════════ -->
<section class="relative overflow-hidden py-24 sm:py-32" style="background:var(--royal-deeper,#091852);">

  {{-- Crimson accent bar --}}
  <div class="absolute top-0 left-0 right-0 h-1" style="background:var(--crimson);"></div>

  {{-- Decorative text behind --}}
  <div class="pointer-events-none absolute inset-0 flex items-center justify-center overflow-hidden opacity-[.04]">
    <p class="display text-paper font-black" style="font-size:18vw;white-space:nowrap;line-height:1;">CRUSADERS</p>
  </div>

  <div class="relative z-10 max-w-3xl mx-auto px-6 text-center">
    <div class="ornament mb-6 reveal" style="--tw-border-opacity:1;">
      <span class="kicker" style="color:var(--spirit);">Together, We Are Crusaders</span>
    </div>

    <h2 class="display text-paper reveal d1 mb-6"
        style="font-size:clamp(2.4rem,6vw,4.5rem);">
      Together, fueled by<br/>
      <em style="color:var(--spirit);">compassion &amp; dedication,</em><br/>
      we create meaningful change.
    </h2>

    <p class="garamond reveal d2 mb-10 max-w-lg mx-auto" style="color:rgba(250,248,244,.5);">
      No gift is too small. No Crusader is forgotten. Join thousands of alumni who
      are building the next chapter of Holy Spirit School.
    </p>

    <div class="flex flex-wrap gap-4 justify-center reveal d3">
      <a href="#crusade"
         class="caption-text font-bold bg-crimson text-white px-10 py-4 hover:bg-crimson-light transition-colors flex items-center gap-2">
        Donate to CRUSADE
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
        </svg>
      </a>
      <a href="#contact"
         class="caption-text font-bold border border-paper/25 text-paper/70 px-10 py-4 hover:border-paper/60 hover:text-paper transition-all">
        Get in Touch
      </a>
    </div>

    {{-- Colophon --}}
    <p class="caption-text mt-12 text-paper/20 reveal d4" style="letter-spacing:.2em;font-size:.62rem;">
      IN VERITATE ET CARITATE · TRUTH AND LOVE · 1926–2026
    </p>
  </div>
</section>

<!-- ════════════════════════════════════════
     FOOTER — MASTHEAD COLOPHON
════════════════════════════════════════ -->
<footer id="contact" class="bg-ink pt-16 pb-8">
  <div class="max-w-7xl mx-auto px-6">

    {{-- Masthead header --}}
    <div class="text-center pb-10 mb-10 border-b border-paper/8">
      <p class="caption-text text-paper/25 mb-2" style="letter-spacing:.3em;">THE OFFICIAL JOURNAL OF</p>
      <h2 class="display text-paper font-bold" style="font-size:clamp(1.8rem,4vw,3rem);">HSSTian Alumni Association</h2>
      <p class="caption-text text-paper/30 mt-2" style="letter-spacing:.2em;">HOLY SPIRIT SCHOOL OF TAGBILARAN · BOHOL, PHILIPPINES</p>
      <div class="flex items-center justify-center gap-4 mt-4">
        <div class="h-px flex-1 max-w-32 bg-paper/10"></div>
        <span class="caption-text font-bold" style="color:var(--spirit);letter-spacing:.22em;font-size:.65rem;">IN VERITATE ET CARITATE</span>
        <div class="h-px flex-1 max-w-32 bg-paper/10"></div>
      </div>
    </div>

    {{-- Footer grid --}}
    <div class="grid md:grid-cols-4 gap-10 pb-12 border-b border-paper/8">

      {{-- About --}}
      <div class="md:col-span-2">
        <div class="flex items-center gap-3 mb-4">
          <img src="{{ asset('images/hsstlogo.jpg') }}" alt="HSST Logo" class="h-8 w-auto object-contain opacity-80"/>
          <div>
            <p class="display text-paper font-bold text-base">HSSTian</p>
            <p class="caption-text text-paper/25 text-[.55rem]" style="letter-spacing:.22em;">Alumni Association</p>
          </div>
        </div>
        <p class="garamond text-paper/30 max-w-xs mb-5" style="font-size:.9rem;line-height:1.7;">
          United by faith. Driven by service. Forever Crusaders.
          Tagbilaran City, Bohol, Philippines.
        </p>
        <p class="caption-text font-bold mb-1" style="color:var(--spirit);">In Veritate et Caritate</p>
        <p class="caption-text text-paper/20 italic" style="letter-spacing:.06em;text-transform:none;font-size:.68rem;">In Truth and in Love</p>
      </div>

      {{-- Quick Links --}}
      <div>
        <p class="caption-text font-bold text-paper/40 mb-5" style="letter-spacing:.2em;">Quick Links</p>
        <ul class="space-y-3">
          <li><a href="#about" class="caption-text text-paper/25 hover:text-paper/70 transition-colors" style="letter-spacing:.08em;text-transform:none;font-size:.8rem;">About Us</a></li>
          <li><a href="{{ route('history') }}" class="caption-text text-paper/25 hover:text-paper/70 transition-colors" style="letter-spacing:.08em;text-transform:none;font-size:.8rem;">History</a></li>
          <li><a href="#crusade" class="caption-text text-paper/25 hover:text-paper/70 transition-colors" style="letter-spacing:.08em;text-transform:none;font-size:.8rem;">CRUSADE Donation</a></li>
          <li><a href="#events" class="caption-text text-paper/25 hover:text-paper/70 transition-colors" style="letter-spacing:.08em;text-transform:none;font-size:.8rem;">Events</a></li>
          <li><a href="#stories" class="caption-text text-paper/25 hover:text-paper/70 transition-colors" style="letter-spacing:.08em;text-transform:none;font-size:.8rem;">Alumni Stories</a></li>
          <li><a href="#news" class="caption-text text-paper/25 hover:text-paper/70 transition-colors" style="letter-spacing:.08em;text-transform:none;font-size:.8rem;">News &amp; Updates</a></li>
        </ul>
      </div>

      {{-- Contact --}}
      <div>
        <p class="caption-text font-bold text-paper/40 mb-5" style="letter-spacing:.2em;">Contact Us</p>
        <ul class="space-y-4">
          <li class="flex gap-2.5 items-start">
            <svg class="w-3.5 h-3.5 text-paper/30 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
            </svg>
            <span class="caption-text text-paper/25" style="letter-spacing:.04em;text-transform:none;font-size:.75rem;">alumni@hss-tagbilaran.edu.ph</span>
          </li>
          <li class="flex gap-2.5 items-start">
            <svg class="w-3.5 h-3.5 text-paper/30 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
            </svg>
            <span class="caption-text text-paper/25" style="letter-spacing:.04em;text-transform:none;font-size:.75rem;">+63 38 501 0000</span>
          </li>
          <li class="flex gap-2.5 items-start">
            <svg class="w-3.5 h-3.5 text-paper/30 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
            </svg>
            <span class="caption-text text-paper/25" style="letter-spacing:.04em;text-transform:none;font-size:.75rem;">Holy Spirit School, Tagbilaran City, Bohol 6300</span>
          </li>
        </ul>

        {{-- Social --}}
        <div class="flex gap-2 mt-6">
          <a href="#" class="w-8 h-8 flex items-center justify-center border border-paper/10 text-paper/25 hover:bg-paper/5 hover:text-paper/60 transition-all">
            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24">
              <path d="M18.77 7.46H14.5v-1.9c0-.9.6-1.1 1-1.1h3V.5h-4.33C10.24.5 9.5 3.44 9.5 5.32v2.15h-3v4h3v12h5v-12h3.85l.42-4z"/>
            </svg>
          </a>
          <a href="#" class="w-8 h-8 flex items-center justify-center border border-paper/10 text-paper/25 hover:bg-paper/5 hover:text-paper/60 transition-all">
            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24">
              <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
            </svg>
          </a>
        </div>
      </div>
    </div>

    {{-- Footer bottom --}}
    <div class="pt-8 flex flex-col md:flex-row items-center justify-between gap-3">
      <p class="caption-text text-paper/15" style="letter-spacing:.08em;text-transform:none;font-size:.7rem;">
        © {{ now('Asia/Manila')->format('Y') }} HSSTian Alumni Association · Holy Spirit School of Tagbilaran. All rights reserved.
      </p>
      <p class="caption-text font-bold" style="color:var(--spirit);opacity:.5;letter-spacing:.25em;font-size:.62rem;">
        CRUSADERS FOREVER ✦
      </p>
    </div>
  </div>
</footer>

<!-- ═══════════��════════════════════════════
     JAVASCRIPT
════════════════════════════════════════ -->
<script>
  // ── Mobile Menu ──────────────────────────
  const mobileMenuBtn     = document.getElementById('mobile-menu-btn');
  const mobileMenu        = document.getElementById('mobile-menu');
  const menuOpenIcon      = document.getElementById('menu-open-icon');
  const menuCloseIcon     = document.getElementById('menu-close-icon');
  const closeMobileMenuBtn= document.getElementById('close-mobile-menu');

  function openMobileMenu() {
    mobileMenu.classList.remove('hidden');
    menuOpenIcon.classList.add('hidden');
    menuCloseIcon.classList.remove('hidden');
    mobileMenuBtn.setAttribute('aria-expanded', 'true');
    document.body.classList.add('overflow-hidden');
  }
  function closeMobileMenu() {
    mobileMenu.classList.add('hidden');
    menuOpenIcon.classList.remove('hidden');
    menuCloseIcon.classList.add('hidden');
    mobileMenuBtn.setAttribute('aria-expanded', 'false');
    document.body.classList.remove('overflow-hidden');
  }

  mobileMenuBtn?.addEventListener('click', () => {
    mobileMenu.classList.contains('hidden') ? openMobileMenu() : closeMobileMenu();
  });
  closeMobileMenuBtn?.addEventListener('click', closeMobileMenu);
  document.querySelectorAll('.mobile-nav-link').forEach(l => l.addEventListener('click', closeMobileMenu));

  // ── Progress Bar ─────────────────────────
  window.addEventListener('scroll', () => {
    const pct = (window.scrollY / (document.body.scrollHeight - window.innerHeight)) * 100;
    document.getElementById('pgbar').style.width = pct + '%';
  });

  // ── Nav scroll state ─────────────────────
  const nav      = document.getElementById('nav');
  const logoText = document.getElementById('logo-text');
  const logoSub  = document.getElementById('logo-sub');
  const navLinks = document.getElementById('nav-links');
  const loginBtn = document.getElementById('login-btn');
  const mobileMenuButton = document.getElementById('mobile-menu-btn');

  function setScrolledNav() {
    nav.classList.add('scrolled');
    logoText?.classList.replace('text-white','text-ink');
    logoSub?.classList.remove('text-white/50');
    logoSub?.classList.add('text-ink/40');
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
    logoSub?.classList.remove('text-ink/40');
    logoSub?.classList.add('text-white/50');
    navLinks?.querySelectorAll('a').forEach(a => {
      a.classList.remove('text-ink/60','hover:text-ink');
      a.classList.add('text-white/70','hover:text-white');
    });
    loginBtn?.classList.remove('border-ink/20','text-ink/60','hover:border-ink/50','hover:text-ink');
    loginBtn?.classList.add('border-white/25','text-white/80','hover:border-white/60','hover:text-white');
    mobileMenuButton?.classList.replace('text-ink','text-white');
  }

  function handleNavScroll() {
    window.scrollY > 60 ? setScrolledNav() : setTopNav();
  }

  window.addEventListener('scroll', handleNavScroll);
  handleNavScroll();

  // ── Reveal on scroll ─────────────────────
  const ro = new IntersectionObserver(entries => {
    entries.forEach(e => {
      if (e.isIntersecting) { e.target.classList.add('on'); ro.unobserve(e.target); }
    });
  }, { threshold: 0.1 });
  document.querySelectorAll('.reveal').forEach(el => ro.observe(el));

  // ── Donation amount selector ──────────────
  function selectAmt(btn, val) {
    document.querySelectorAll('.amt-btn').forEach(b => b.classList.remove('selected'));
    btn.classList.add('selected');
    document.getElementById('custom-amt').value = '';
  }
  function clearSelected() {
    document.querySelectorAll('.amt-btn').forEach(b => b.classList.remove('selected'));
  }
</script>
</body>
</html>
