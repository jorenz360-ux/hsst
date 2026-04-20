<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>HSSTian Alumni Association - Holy Spirit School of Tagbilaran</title>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;0,800;0,900;1,400;1,500;1,700;1,900&family=EB+Garamond:ital,wght@0,400;0,500;0,600;1,400;1,500;1,600&family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet"/>
  <script src="https://cdn.tailwindcss.com"></script>
  <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            royal:  { DEFAULT:'#1a3fc4', dark:'#0f2580', deeper:'#091852', light:'#2952d9', pale:'#94b0f8', frost:'#eef2ff' },
            gold:   { DEFAULT:'#c4960a', light:'#e8b80f', pale:'#fdf3d7', dark:'#a07a08' },
            ink:    { DEFAULT:'#0d1526', soft:'#2d3a52', muted:'#5a6a85' },
            snow:   { DEFAULT:'#f4f7ff' },
          },
          fontFamily: {
            display:  ['"Playfair Display"','Georgia','serif'],
            garamond: ['"EB Garamond"','Georgia','serif'],
            sans:     ['"Inter"','system-ui','sans-serif'],
          },
          keyframes: {
            fadeUp: { from:{opacity:0,transform:'translateY(22px)'}, to:{opacity:1,transform:'translateY(0)'} },
            fadeIn: { from:{opacity:0}, to:{opacity:1} },
            ticker: { from:{transform:'translateX(0)'}, to:{transform:'translateX(-50%)'} },
          },
          animation: {
            'fade-up': 'fadeUp .9s cubic-bezier(.22,1,.36,1) both',
            'fade-in': 'fadeIn 1s ease both',
            'ticker':  'ticker 36s linear infinite',
          },
        },
      },
    };
  </script>
  <style>
    :root {
      --royal:       #1a3fc4;
      --royal-dark:  #0f2580;
      --royal-deeper:#091852;
      --royal-frost: #eef2ff;
      --gold:        #c4960a;
      --gold-light:  #e8b80f;
      --gold-pale:   #fdf3d7;
      --ink:         #0d1526;
      --ink-muted:   #5a6a85;
      --snow:        #f4f7ff;
    }

    *,*::before,*::after { box-sizing:border-box; margin:0; padding:0; }
    html { scroll-behavior:smooth; }
    body { font-family:'Inter',sans-serif; background:#fff; color:var(--ink); overflow-x:hidden; }

    ::-webkit-scrollbar { width:4px; }
    ::-webkit-scrollbar-track { background:var(--snow); }
    ::-webkit-scrollbar-thumb { background:var(--royal-frost); border-radius:2px; }
    ::-webkit-scrollbar-thumb:hover { background:var(--royal); }

    #pgbar {
      position:fixed; top:0; left:0; height:3px;
      background:linear-gradient(90deg,var(--royal),var(--gold));
      z-index:9999; width:0; transition:width .1s linear;
    }

    /* Reveal */
    .reveal { opacity:0; transform:translateY(20px); transition:opacity .75s cubic-bezier(.22,1,.36,1),transform .75s cubic-bezier(.22,1,.36,1); }
    .reveal.on { opacity:1; transform:none; }
    .d1{transition-delay:.1s;} .d2{transition-delay:.2s;} .d3{transition-delay:.3s;} .d4{transition-delay:.4s;} .d5{transition-delay:.5s;}

    /* Typography */
    .display  { font-family:'Playfair Display',serif; letter-spacing:-.02em; line-height:1.08; }
    .garamond { font-family:'EB Garamond',serif; font-size:1.05rem; line-height:1.85; }
    .kicker   { font-family:'Inter',sans-serif; font-size:.65rem; font-weight:700; letter-spacing:.22em; text-transform:uppercase; }

    /* Section tag */
    .section-tag { display:inline-flex; align-items:center; gap:.65rem; }
    .section-tag .bar { width:28px; height:2px; background:var(--gold); display:block; }

    /* NAV */
    #nav { transition:background .3s ease,box-shadow .3s ease; }
    #nav.scrolled {
      background:rgba(255,255,255,.97);
      box-shadow:0 1px 28px rgba(26,63,196,.09);
      backdrop-filter:blur(12px);
    }

    /* Hero gradient */
    .hero-grad {
      background:linear-gradient(
        110deg,
        rgba(9,24,82,.97) 0%,
        rgba(15,37,128,.90) 35%,
        rgba(26,63,196,.65) 62%,
        rgba(26,63,196,.12) 100%
      );
    }

    /* Blue section */
    .section-blue { background:linear-gradient(135deg,var(--royal-deeper),var(--royal-dark) 55%,var(--royal) 100%); }

    /* Shimmer bar */
    @keyframes shimmer { from{background-position:-400px 0} to{background-position:400px 0} }
    .shimmer {
      background:linear-gradient(90deg,var(--gold) 0%,var(--gold-light) 50%,var(--gold) 100%);
      background-size:400px 100%;
      animation:shimmer 2.5s linear infinite;
    }

    /* Gold divider */
    .gold-divider { width:44px; height:3px; background:linear-gradient(90deg,var(--gold),var(--gold-light)); display:block; }

    /* Pull quote */
    .pull-quote {
      font-family:'Playfair Display',serif;
      font-style:italic;
      font-size:clamp(1.25rem,2.2vw,1.75rem);
      line-height:1.45; color:var(--ink);
      border-left:3px solid var(--royal);
      padding-left:1.25rem;
    }

    /* Open quote */
    .open-quote { font-family:'Playfair Display',serif; font-size:6rem; line-height:.6; opacity:.1; display:block; color:var(--royal); }

    /* Card hover */
    .hover-card { transition:transform .3s cubic-bezier(.22,1,.36,1),box-shadow .3s; }
    .hover-card:hover { transform:translateY(-5px); box-shadow:0 18px 50px rgba(26,63,196,.13); }

    /* Article link underline */
    .article-link { position:relative; }
    .article-link::after { content:''; position:absolute; bottom:0; left:0; width:0; height:1px; background:var(--royal); transition:width .3s ease; }
    .article-link:hover::after { width:100%; }

    /* Ticker */
    .ticker-wrap { overflow:hidden; white-space:nowrap; }
    .ticker-inner { display:inline-block; animation:ticker 36s linear infinite; }
    .ticker-inner:hover { animation-play-state:paused; }

    /* Stat number */
    .stat-num {
      font-family:'Playfair Display',serif;
      font-size:clamp(2.4rem,5vw,3.4rem);
      font-weight:800; line-height:1;
      background:linear-gradient(135deg,#fff,rgba(255,255,255,.7));
      -webkit-background-clip:text;
      -webkit-text-fill-color:transparent;
    }
    .stat-num .gold-txt { -webkit-text-fill-color:var(--gold); }

    /* FAQ */
    .faq-item summary { list-style:none; cursor:pointer; }
    .faq-item summary::-webkit-details-marker { display:none; }
    .faq-item[open] summary .faq-icon { transform:rotate(45deg); }
    .faq-icon { transition:transform .3s cubic-bezier(.22,1,.36,1); }

    /* Form */
    .form-input {
      width:100%; border:1px solid rgba(26,63,196,.14);
      background:#f4f7ff; padding:.75rem 1rem;
      font-size:.875rem; color:var(--ink);
      transition:border-color .2s,box-shadow .2s; outline:none;
    }
    .form-input:focus { border-color:var(--royal); box-shadow:0 0 0 3px rgba(26,63,196,.07); }
    .form-input::placeholder { color:var(--ink-muted); }

    /* Donate ring */
    @keyframes ring { 0%,100%{transform:scale(1);opacity:.5} 50%{transform:scale(1.05);opacity:.9} }
    .donate-ring::before { content:''; position:absolute; inset:-3px; border:1.5px solid rgba(196,150,10,.5); animation:ring 2.5s ease-in-out infinite; }

    /* Amt btn */
    .amt-btn { transition:all .2s; }
    .amt-btn.selected { background:var(--royal) !important; color:#fff !important; border-color:var(--royal) !important; }
  </style>
</head>
<body class="antialiased">

<div id="pgbar"></div>

<!-- ══════════════════════════════════════
     TOP STRIP
══════════════════════════════════════ -->
<div class="hidden md:block" style="background:var(--royal-deeper);">
  <div class="max-w-7xl mx-auto px-6 py-2 flex items-center justify-between">
    <span class="kicker text-white/35">{{ now('Asia/Manila')->format('l, F j, Y') }}</span>
    <span class="kicker font-bold" style="color:var(--gold);letter-spacing:.3em;">In Veritate et Caritate</span>
    <div class="flex items-center gap-5">
      <span class="kicker text-white/35">Est. 1926</span>
      <span class="kicker text-white/35">Tagbilaran, Bohol, Philippines</span>
    </div>
  </div>
</div>

<!-- ══════════════════════════════════════
     STICKY NAVBAR
══════════════════════════════════════ -->
<header id="nav" class="fixed inset-x-0 top-0 z-50 md:relative md:z-auto md:top-auto md:fixed">
  <div class="max-w-7xl mx-auto px-6">
    <div class="flex items-center justify-between py-4">

      <!-- Logo -->
      <a href="#" class="flex items-center gap-3">
        <img src="{{ asset('images/hsstlogo.jpg') }}" alt="HSST Logo" class="h-9 w-auto object-contain"/>
        <div>
          <p class="font-display font-bold text-sm leading-none text-white md:text-ink transition-colors duration-300" id="logo-text" style="letter-spacing:-.01em;text-shadow:0 1px 8px rgba(0,0,0,.7),0 0 20px rgba(0,0,0,.4);">HSSTian</p>
          <p class="kicker text-[.52rem] text-white/50 md:text-ink/40 transition-colors duration-300 mt-0.5" id="logo-sub" style="letter-spacing:.18em;text-shadow:0 1px 6px rgba(0,0,0,.7);">Alumni Association</p>
        </div>
      </a>

      <!-- Desktop links -->
      <nav class="hidden md:flex items-center gap-7" id="nav-links">
        <a href="#about"    class="kicker text-[.62rem] text-white/70 md:text-ink/55 hover:text-white md:hover:text-ink transition-colors">About</a>
        <a href="{{ route('history') }}" class="kicker text-[.62rem] text-white/70 md:text-ink/55 hover:text-white md:hover:text-ink transition-colors">History</a>
        <a href="#events"   class="kicker text-[.62rem] text-white/70 md:text-ink/55 hover:text-white md:hover:text-ink transition-colors">Events</a>
        <a href="#crusade"  class="kicker text-[.62rem] text-white/70 md:text-ink/55 hover:text-white md:hover:text-ink transition-colors">CRUSADE</a>
        <a href="#stories"  class="kicker text-[.62rem] text-white/70 md:text-ink/55 hover:text-white md:hover:text-ink transition-colors">Stories</a>
        <a href="#news"     class="kicker text-[.62rem] text-white/70 md:text-ink/55 hover:text-white md:hover:text-ink transition-colors">News</a>
        <a href="#faq"      class="kicker text-[.62rem] text-white/70 md:text-ink/55 hover:text-white md:hover:text-ink transition-colors">FAQ</a>
        <a href="#contact"  class="kicker text-[.62rem] text-white/70 md:text-ink/55 hover:text-white md:hover:text-ink transition-colors">Contact</a>
      </nav>

      <!-- Desktop auth -->
      <div class="hidden md:flex items-center gap-2.5" id="auth-links">
        <a id="login-btn" href="{{ route('login') }}"
           class="kicker text-[.62rem] border border-white/25 md:border-ink/20 text-white/75 md:text-ink/55 px-4 py-2.5 hover:border-royal/50 hover:text-royal transition-all">
          Login
        </a>
        <a href="{{ route('register') }}"
           class="kicker text-[.62rem] px-4 py-2.5 bg-white md:bg-ink text-ink md:text-white hover:opacity-85 transition-opacity">
          Register
        </a>
        <a href="{{ route('register.staff') }}"
           class="kicker text-[.62rem] border border-white/25 md:border-ink/20 text-white/75 md:text-ink/55 px-4 py-2.5 hover:border-royal/50 hover:text-royal transition-all">
          Staff / Employee
        </a>
        <a href="#crusade"
           class="kicker text-[.62rem] px-5 py-2.5 font-bold text-ink hover:opacity-90 transition-opacity"
           style="background:var(--gold);letter-spacing:.18em;">
          ✦ Donate
        </a>
      </div>

      <!-- Mobile hamburger -->
      <button id="mobile-menu-btn" type="button" class="md:hidden text-white transition-colors" aria-label="Open menu" aria-expanded="false">
        <svg id="menu-open-icon" class="w-6 h-6 block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
        </svg>
        <svg id="menu-close-icon" class="w-6 h-6 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
        </svg>
      </button>
    </div>

    <!-- Gold rule (desktop) -->
    <div class="hidden md:block h-px" style="background:linear-gradient(90deg,transparent,rgba(196,150,10,.25),transparent);"></div>
  </div>
</header>

<!-- ══════════════════════════════════════
     MOBILE MENU
══════════════════════════════════════ -->
<div id="mobile-menu" class="fixed inset-0 z-[9999] hidden md:hidden" style="background:var(--royal-deeper);">
  <div class="flex h-dvh flex-col">
    <div class="flex items-center justify-between px-6 py-5 border-b border-white/10">
      <div>
        <p class="kicker text-white/35 text-[.58rem]" style="letter-spacing:.28em;">Navigation</p>
        <h2 class="font-display text-xl font-bold text-white mt-1">HSSTian Alumni</h2>
      </div>
      <button type="button" id="close-mobile-menu"
              class="w-10 h-10 flex items-center justify-center border border-white/15 text-white/50 hover:bg-white/8 transition-colors">
        ✕
      </button>
    </div>
    <nav class="flex-1 overflow-y-auto px-6 py-4 flex flex-col">
      <a href="#about"   class="mobile-nav-link border-b border-white/8 py-4 font-display text-lg text-white/80 hover:text-white transition-colors">About</a>
      <a href="#events"  class="mobile-nav-link border-b border-white/8 py-4 font-display text-lg text-white/80 hover:text-white transition-colors">Events</a>
      <a href="#crusade" class="mobile-nav-link border-b border-white/8 py-4 font-display text-lg text-white/80 hover:text-white transition-colors">CRUSADE</a>
      <a href="#stories" class="mobile-nav-link border-b border-white/8 py-4 font-display text-lg text-white/80 hover:text-white transition-colors">Stories</a>
      <a href="{{ route('history') }}" class="mobile-nav-link border-b border-white/8 py-4 font-display text-lg text-white/80 hover:text-white transition-colors">History</a>
      <a href="#news"    class="mobile-nav-link border-b border-white/8 py-4 font-display text-lg text-white/80 hover:text-white transition-colors">News</a>
      <a href="#faq"     class="mobile-nav-link border-b border-white/8 py-4 font-display text-lg text-white/80 hover:text-white transition-colors">FAQ</a>
      <a href="#contact" class="mobile-nav-link py-4 font-display text-lg text-white/80 hover:text-white transition-colors">Contact</a>
    </nav>
    <div class="border-t border-white/10 px-6 py-5 flex flex-col gap-3">
      <a href="{{ route('login') }}"    class="flex items-center justify-center py-3 border border-white/15 kicker text-white/70 hover:bg-white/5 transition-colors">Login</a>
      <a href="{{ route('register') }}"       class="flex items-center justify-center py-3 bg-white kicker text-ink hover:opacity-90 transition-opacity">Register (Alumni)</a>
      <a href="{{ route('register.staff') }}" class="flex items-center justify-center py-3 border border-white/15 kicker text-white/70 hover:bg-white/5 transition-colors">Staff / Employee</a>
      <a href="#crusade"                      class="flex items-center justify-center py-3 kicker font-bold text-ink hover:opacity-90 transition-opacity" style="background:var(--gold);">✦ Donate Now</a>
    </div>
  </div>
</div>

<!-- ══════════════════════════════════════
     HERO BANNER
══════════════════════════════════════ -->
<section class="relative overflow-hidden flex flex-col md:min-h-screen md:justify-end">

  <!-- Image: fixed height on mobile (stacked), full-bleed absolute on desktop -->
  <div class="relative h-[45vh] shrink-0 md:absolute md:inset-0 md:h-auto">
    <img src="{{ asset('images/hsstherosect1.png') }}" alt="Holy Spirit School of Tagbilaran"
         class="absolute inset-0 h-full w-full object-cover object-center"/>
    <!-- Desktop gradient -->
    <div class="absolute inset-0 hero-grad hidden md:block"></div>
    <!-- Mobile: top vignette only so hamburger stays readable -->
    <div class="absolute inset-x-0 top-0 h-28 md:hidden" style="background:linear-gradient(to bottom,rgba(0,0,0,.52),transparent)"></div>
    <div class="absolute inset-0 opacity-[.03]"
         style="background-image:url(data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='200' height='200'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='200' height='200' filter='url(%23n)' opacity='1'/%3E%3C/svg%3E);"></div>
  </div>

  <!-- Decorative vertical rule (desktop only) -->
  <div class="pointer-events-none absolute right-14 top-0 bottom-0 hidden xl:flex flex-col items-center justify-center opacity-15">
    <div class="h-48 w-px" style="background:linear-gradient(to bottom,transparent,var(--gold),transparent);"></div>
    <div class="my-4 kicker text-white text-[.56rem]" style="writing-mode:vertical-rl;letter-spacing:.3em;">HOLY SPIRIT SCHOOL · EST. 1926</div>
    <div class="h-48 w-px" style="background:linear-gradient(to bottom,transparent,var(--gold),transparent);"></div>
  </div>

  <!-- Content: dark navy bg on mobile, transparent on desktop -->
  <div class="relative z-10 w-full max-w-7xl mx-auto px-6 sm:px-8 pb-10 sm:pb-24 md:pb-32 pt-0 md:pt-0 bg-[rgb(9,24,82)] md:bg-transparent">

    <!-- Mobile masthead: gold rule → logo + HSST identity → centennial year -->
    <div class="md:hidden">
      <div class="h-[2px] w-full" style="background:linear-gradient(to right,var(--gold) 0%,rgba(255,255,255,.08) 100%)"></div>
      <div class="flex items-center gap-3 px-1 py-3">
        <img src="{{ asset('images/hsstlogo.jpg') }}" alt="HSST" class="w-10 h-10 rounded-full object-cover shrink-0" style="border:1px solid rgba(255,255,255,.18)"/>
        <div class="flex flex-col leading-none gap-1">
          <span class="display text-white" style="font-size:1.45rem;letter-spacing:.06em;line-height:1;">HSST</span>
          <span class="kicker text-white/40 text-[.5rem]" style="letter-spacing:.2em;">HOLY SPIRIT SCHOOL · TAGBILARAN</span>
        </div>
        <div class="ml-auto flex flex-col items-end leading-none gap-1">
          <span class="kicker text-[.5rem] text-white/35" style="letter-spacing:.15em;">CENTENNIAL</span>
          <span class="kicker font-bold" style="font-size:.72rem;color:var(--gold);letter-spacing:.1em;">1926–2026</span>
        </div>
      </div>
      <div class="h-px mb-5" style="background:rgba(255,255,255,.06)"></div>
    </div>

    <div class="max-w-3xl">

      <div class="mb-5 flex items-center gap-3 animate-fade-up" style="animation-delay:.1s;">
        <span class="gold-divider"></span>
        <span class="kicker" style="color:var(--gold);letter-spacing:.28em;">Centennial Edition · 1926–2026</span>
      </div>

      <h1 class="display text-white mb-6 animate-fade-up" style="font-size:clamp(2.8rem,8vw,6.2rem);animation-delay:.2s;">
        Come home<br/>
        <em style="color:var(--gold);">to memory,</em><br class="hidden sm:block"/>
        legacy &amp; connection.
      </h1>

      <p class="garamond text-white/70 mb-9 max-w-xl animate-fade-up" style="font-size:clamp(1rem,1.6vw,1.15rem);animation-delay:.32s;">
        Welcome home, HSSTian. Thousands of alumni, united by faith, service,
        and the spirit of the Holy Cross, gather to shape the next century
        of Holy Spirit School.
      </p>

      <div class="flex flex-col sm:flex-row gap-3 mb-14 animate-fade-up" style="animation-delay:.42s;">
        <a href="{{ route('register') }}"
           class="inline-flex items-center justify-center gap-2 text-ink kicker font-bold px-8 py-4 hover:opacity-90 transition-opacity"
           style="background:var(--gold);">
          Alumni Registration
          <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        </a>
        <a href="{{ route('register.staff') }}"
           class="inline-flex items-center justify-center gap-2 border border-white/35 text-white/85 kicker px-8 py-4 hover:border-white/70 hover:text-white transition-all">
          Staff / Employee
          <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        </a>
      </div>

      <div class="flex flex-wrap items-center gap-4 animate-fade-up" style="animation-delay:.52s;">
        <div class="flex items-center gap-2 border border-white/15 px-4 py-2.5">
          <svg class="w-3.5 h-3.5 shrink-0" style="color:var(--gold);" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
          <span class="kicker text-white/65">Grand Reunion · <span style="color:var(--gold);">2026</span></span>
        </div>
        <div class="flex items-center gap-2 border border-white/15 px-4 py-2.5">
          <svg class="w-3.5 h-3.5 shrink-0" style="color:var(--gold);" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0"/></svg>
          <span class="kicker text-white/65">100K<span style="color:var(--gold);">+</span> Alumni</span>
        </div>
        <div class="flex items-center gap-2 border border-white/15 px-4 py-2.5">
          <svg class="w-3.5 h-3.5 shrink-0" style="color:var(--gold);" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12z"/></svg>
          <span class="kicker text-white/65">Centennial · <span style="color:var(--gold);">Est. 1926</span></span>
        </div>
      </div>

    </div>
  </div>

  <!-- Bottom white fade (desktop only) -->
  <div class="hidden md:block absolute inset-x-0 bottom-0 h-24" style="background:linear-gradient(to top,#ffffff,transparent);"></div>
</section>

<!-- ══════════════════════════════════════
     ALUMNI LEGACY STATS
══════════════════════════════════════ -->
<section class="section-blue py-16 sm:py-20">
  <div class="max-w-7xl mx-auto px-6">

    <div class="text-center mb-10 reveal">
      <div class="section-tag justify-center">
        <span class="bar"></span>
        <span class="kicker" style="color:var(--gold);">A Century of Impact</span>
        <span class="bar"></span>
      </div>
      <h2 class="display text-white mt-3" style="font-size:clamp(1.6rem,3vw,2.5rem);">Alumni Legacy at a Glance</h2>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-4 gap-0 border border-white/10">
      <div class="p-8 sm:p-10 text-center border-b md:border-b-0 border-r border-white/10 reveal d1">
        <p class="stat-num">100<span class="gold-txt">+</span></p>
        <p class="kicker text-white/40 mt-3">Years of History</p>
        <p class="garamond text-white/20 mt-1" style="font-size:.85rem;">Est. 1926</p>
      </div>
      <div class="p-8 sm:p-10 text-center border-b md:border-b-0 border-r border-white/10 reveal d2">
        <p class="stat-num">100K<span class="gold-txt">+</span></p>
        <p class="kicker text-white/40 mt-3">Living Graduates</p>
        <p class="garamond text-white/20 mt-1" style="font-size:.85rem;">Across the globe</p>
      </div>
      <div class="p-8 sm:p-10 text-center border-b md:border-b-0 border-r border-white/10 reveal d3">
        <p class="stat-num">50<span class="gold-txt">+</span></p>
        <p class="kicker text-white/40 mt-3">Alumni Batches</p>
        <p class="garamond text-white/20 mt-1" style="font-size:.85rem;">Celebrating together</p>
      </div>
      <div class="p-8 sm:p-10 text-center reveal d4">
        <p class="stat-num">10<span class="gold-txt">+</span></p>
        <p class="kicker text-white/40 mt-3">Grand Reunions</p>
        <p class="garamond text-white/20 mt-1" style="font-size:.85rem;">Memories renewed</p>
      </div>
    </div>

  </div>
</section>

<!-- ══════════════════════════════════════
     ANNOUNCEMENT TICKER
══════════════════════════════════════ -->
<div class="flex items-stretch border-y" style="background:var(--ink);border-color:rgba(255,255,255,.06);">
  <div class="shrink-0 flex items-center px-5 border-r border-white/10" style="background:var(--gold);">
    <span class="kicker text-ink font-bold">LATEST</span>
  </div>
  <div class="ticker-wrap flex-1 py-3">
    <div class="ticker-inner kicker text-white/45" style="letter-spacing:.13em;">
      <span class="mx-8">HSSTian Alumni Centennial Celebration - 1926 to 2026</span>
      <span class="mx-3" style="color:var(--gold);">✦</span>
      <span class="mx-8">CRUSADE Campaign · Target: PhP 100,000 per Batch</span>
      <span class="mx-3" style="color:var(--gold);">✦</span>
      <span class="mx-8">Crusaders Scholarship Fund Now Open</span>
      <span class="mx-3" style="color:var(--gold);">✦</span>
      <span class="mx-8">Every Gift Leaves a Lasting Impact</span>
      <span class="mx-3" style="color:var(--gold);">✦</span>
      <span class="mx-8">Faculty Development Fund · Donate Today</span>
      <span class="mx-3" style="color:var(--gold);">✦</span>
      <span class="mx-8">Elevating Campus Experience for Future Crusaders</span>
      <span class="mx-3" style="color:var(--gold);">✦</span>
      <span class="mx-8">HSSTian Alumni Centennial Celebration - 1926 to 2026</span>
      <span class="mx-3" style="color:var(--gold);">✦</span>
      <span class="mx-8">CRUSADE Campaign · Target: PhP 100,000 per Batch</span>
      <span class="mx-3" style="color:var(--gold);">✦</span>
      <span class="mx-8">Crusaders Scholarship Fund Now Open</span>
      <span class="mx-3" style="color:var(--gold);">✦</span>
      <span class="mx-8">Every Gift Leaves a Lasting Impact</span>
      <span class="mx-3" style="color:var(--gold);">✦</span>
      <span class="mx-8">Faculty Development Fund · Donate Today</span>
      <span class="mx-3" style="color:var(--gold);">✦</span>
      <span class="mx-8">Elevating Campus Experience for Future Crusaders</span>
      <span class="mx-3" style="color:var(--gold);">✦</span>
    </div>
  </div>
</div>

<!-- ══════════════════════════════════════
     ABOUT - ALUMNI COMMUNITY
══════════════════════════════════════ -->
<section id="about" class="py-20 sm:py-28 bg-white">
  <div class="max-w-7xl mx-auto px-6">
    <div class="grid items-center gap-12 lg:grid-cols-2 lg:gap-20">

      <!-- Left: carousel -->
      <div class="order-2 lg:order-1 reveal">
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
            start() { this.stop(); this.interval = setInterval(()=>{ this.current=(this.current+1)%this.slides.length; },4200); },
            stop()  { if(this.interval) clearInterval(this.interval); },
            next()  { this.current=(this.current+1)%this.slides.length; },
            prev()  { this.current=(this.current-1+this.slides.length)%this.slides.length; }
          }"
          x-init="start()"
          @mouseenter="stop()"
          @mouseleave="start()"
        >
          <div class="relative overflow-hidden" style="aspect-ratio:4/5;background:var(--royal-frost);">
            <template x-for="(slide, index) in slides" :key="index">
              <div x-show="current===index"
                   x-transition:enter="transition ease-out duration-700"
                   x-transition:enter-start="opacity-0"
                   x-transition:enter-end="opacity-100"
                   x-transition:leave="transition ease-in duration-400"
                   x-transition:leave-start="opacity-100"
                   x-transition:leave-end="opacity-0"
                   class="absolute inset-0">
                <img :src="slide" alt="HSST Centennial" class="w-full h-full object-contain"/>
              </div>
            </template>
            <button @click="prev()" type="button"
                    class="absolute left-3 top-1/2 -translate-y-1/2 z-10 w-9 h-9 flex items-center justify-center bg-white/90 text-ink border border-ink/10 hover:bg-white transition-colors text-xs shadow-sm">&#10094;</button>
            <button @click="next()" type="button"
                    class="absolute right-3 top-1/2 -translate-y-1/2 z-10 w-9 h-9 flex items-center justify-center bg-white/90 text-ink border border-ink/10 hover:bg-white transition-colors text-xs shadow-sm">&#10095;</button>
            <div class="absolute top-3 left-3 px-3 py-1.5" style="background:var(--royal);">
              <span class="kicker text-white font-bold">HSST Centennial</span>
            </div>
          </div>

          <div class="flex justify-center gap-2 mt-4">
            <template x-for="(slide, index) in slides" :key="'dot-'+index">
              <button @click="current=index" type="button"
                      class="h-1.5 rounded-full transition-all duration-300"
                      :class="current===index ? 'w-7 bg-royal' : 'w-2 bg-ink/20 hover:bg-ink/35'"></button>
            </template>
          </div>
          <p class="kicker text-ink/30 mt-3 text-center text-[.57rem]" style="letter-spacing:.2em;">Holy Spirit School · Tagbilaran City, Bohol · Est. 1926</p>
        </div>

        <div class="mt-5 grid grid-cols-3 border divide-x" style="border-color:rgba(26,63,196,.1);divide-color:rgba(26,63,196,.1);">
          <div class="py-4 text-center">
            <p class="display font-bold text-xl" style="color:var(--royal);">1926</p>
            <p class="kicker text-ink/35 mt-1 text-[.6rem]">Founded</p>
          </div>
          <div class="py-4 text-center">
            <p class="display font-bold text-xl" style="color:var(--royal);">Tagbilaran</p>
            <p class="kicker text-ink/35 mt-1 text-[.6rem]">Bohol, Philippines</p>
          </div>
          <div class="py-4 text-center">
            <p class="display font-bold text-xl" style="color:var(--royal);">100<span style="color:var(--gold);">yrs</span></p>
            <p class="kicker text-ink/35 mt-1 text-[.6rem]">Centennial</p>
          </div>
        </div>
      </div>

      <!-- Right: text -->
      <div class="order-1 lg:order-2">
        <div class="section-tag reveal">
          <span class="bar"></span>
          <span class="kicker" style="color:var(--gold);">Our Community</span>
        </div>

        <h2 class="display text-ink reveal d1 mt-3" style="font-size:clamp(2.2rem,4vw,3.4rem);">
          Rooted in Faith.<br/>
          Driven by Service.<br/>
          <em style="color:var(--royal);">United as One.</em>
        </h2>

        <div class="flex flex-wrap gap-2 mt-5 mb-7 reveal d2">
          <span class="kicker text-[.62rem] border px-3 py-1.5" style="border-color:rgba(26,63,196,.2);color:var(--royal);background:var(--royal-frost);">Faith-Based Community</span>
          <span class="kicker text-[.62rem] border px-3 py-1.5" style="border-color:rgba(10,124,104,.2);color:#0a7c68;background:#d4f0eb;">Scholarship Programs</span>
          <span class="kicker text-[.62rem] border px-3 py-1.5" style="border-color:rgba(196,150,10,.2);color:var(--gold);background:var(--gold-pale);">Academic Excellence</span>
          <span class="kicker text-[.62rem] border px-3 py-1.5" style="border-color:rgba(196,26,46,.2);color:#c41a2e;background:#fde8eb;">Campus Development</span>
        </div>

        <p class="garamond text-ink/65 reveal d2 mb-5">
          The HSSTian Alumni Association is the official organization of graduates
          of Holy Spirit School of Tagbilaran - the Crusaders. For generations, we have
          carried the school's mission of truth, love, and excellence far beyond the
          campus gates, into every corner of the Philippines and the world.
        </p>
        <p class="garamond text-ink/65 reveal d2 mb-8">
          As we approach our Centennial, we are called once again to give back - to the
          school that shaped our character, deepened our faith, and ignited our purpose.
          The HSSTian Alumni Association is the bridge between the legacy of the past
          and the promise of the future.
        </p>

        <div class="reveal d3 mb-8">
          <blockquote class="pull-quote">
            "Whether you studied in <span style="color:var(--royal);">1926</span>
            or <span style="color:var(--royal);">{{ now('Asia/Manila')->format('Y') }}</span>,
            you are part of our alumni family."
          </blockquote>
        </div>

        <div class="flex flex-wrap gap-3 reveal d4">
          <a href="#events" class="kicker font-bold text-white px-7 py-3.5 hover:opacity-90 transition-opacity" style="background:var(--royal);">View Activities</a>
          <a href="#crusade" class="kicker font-bold border px-7 py-3.5 hover:opacity-85 transition-all" style="border-color:var(--gold);color:var(--gold);">Donate Now</a>
        </div>
      </div>

    </div>
  </div>
</section>

<!-- ══════════════════════════════════════
     UPCOMING REUNION EVENTS
══════════════════════════════════════ -->
<section id="events" class="py-20 sm:py-28" style="background:var(--snow);">
  <div class="max-w-7xl mx-auto px-6">

    <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 mb-12 reveal">
      <div>
        <div class="section-tag mb-1">
          <span class="bar"></span>
          <span class="kicker" style="color:var(--gold);">Mark Your Calendar</span>
        </div>
        <h2 class="display text-ink mt-2" style="font-size:clamp(2rem,3.5vw,3rem);">Upcoming Reunion Events</h2>
      </div>
      <a href="{{ route('events.index') }}"
         class="kicker font-bold border-b-2 pb-0.5 hover:opacity-70 transition-opacity self-start sm:self-end shrink-0"
         style="color:var(--royal);border-color:var(--gold);">
        View All Events →
      </a>
    </div>

    @if ($events->isNotEmpty())
      <div class="grid gap-6 sm:gap-7 md:grid-cols-2 xl:grid-cols-3">
        @foreach ($events as $event)
          @php
            $eventDate = \Carbon\Carbon::parse($event->event_date);
            $isFeatured = $loop->first;
            $bannerUrl = $event->banner_image
              ? \Illuminate\Support\Facades\Storage::disk('s3')->url($event->banner_image)
              : asset('images/100yearsevent.jpg');
          @endphp

          <article class="hover-card reveal d{{ $loop->iteration }} flex flex-col bg-white overflow-hidden group"
                   style="border:1px solid rgba(26,63,196,.1);box-shadow:0 2px 14px rgba(26,63,196,.05);">
            <div class="relative h-52 overflow-hidden">
              <img src="{{ $bannerUrl }}" alt="{{ $event->title }}"
                   class="h-full w-full object-cover transition duration-700 group-hover:scale-105"/>
              <div class="absolute inset-0" style="background:linear-gradient(to bottom,transparent 40%,rgba(9,24,82,.5));"></div>

              <div class="absolute top-4 left-4 bg-white px-3 py-2 text-center min-w-[52px] shadow-sm">
                <span class="display font-bold text-ink block text-xl leading-none">{{ $eventDate->format('d') }}</span>
                <span class="kicker text-ink/45 block mt-0.5 text-[.57rem]">{{ $eventDate->format('M') }}</span>
              </div>

              <div class="absolute top-4 right-4">
                @if ($isFeatured)
                  <span class="kicker font-bold px-3 py-1.5 text-ink" style="background:var(--gold);">Featured</span>
                @else
                  <span class="kicker font-bold px-3 py-1.5 bg-white/90" style="color:var(--royal);">Upcoming</span>
                @endif
              </div>
            </div>

            <div class="flex flex-1 flex-col p-6">
              <span class="kicker text-[.6rem] mb-2" style="color:var(--royal);">{{ $eventDate->format('F Y') }}</span>
              <h3 class="display font-bold text-ink text-lg leading-snug mb-3 group-hover:text-royal transition-colors">
                {{ $event->title }}
              </h3>
              <p class="garamond text-ink/55 mb-4 flex-1" style="font-size:.95rem;line-height:1.8;">
                {{ \Illuminate\Support\Str::limit($event->description ?: 'Stay tuned for more details about this upcoming alumni event.', 110) }}
              </p>
              <div class="flex items-center gap-2 kicker text-[.6rem] text-ink/40 mb-5">
                <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                </svg>
                <span>{{ $event->venue ?: 'Venue to be announced' }}</span>
              </div>
              @if (Route::has('events.show'))
                <a href="{{ route('events.show', $event->slug) }}"
                   class="kicker font-bold article-link inline-block self-start transition-colors text-[.65rem]"
                   style="color:var(--royal);">
                  View Details →
                </a>
              @endif
            </div>
          </article>
        @endforeach
      </div>
    @else
      <div class="reveal border p-12 text-center" style="border-color:rgba(26,63,196,.1);background:white;">
        <p class="display text-2xl text-ink mb-2">No upcoming events yet</p>
        <p class="garamond text-ink/45">Please check back soon for the latest alumni gatherings and centennial activities.</p>
      </div>
    @endif

  </div>
</section>

<!-- ══════════════════════════════════════
     FEATURED ANNOUNCEMENTS
══════════════════════════════════════ -->
<section id="news" class="py-20 sm:py-28 bg-white">
  <div class="max-w-7xl mx-auto px-6">

    <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 mb-12 reveal">
      <div>
        <div class="section-tag mb-1">
          <span class="bar"></span>
          <span class="kicker" style="color:var(--gold);">What's Happening</span>
        </div>
        <h2 class="display text-ink mt-2" style="font-size:clamp(2rem,3.5vw,3rem);">Featured Announcements</h2>
      </div>
      @if(Route::has('announcements.index'))
        <a href="{{ route('announcements.index') }}"
           class="kicker font-bold border-b-2 pb-0.5 hover:opacity-70 transition-opacity self-start sm:self-end shrink-0"
           style="color:var(--royal);border-color:var(--gold);">
          All Announcements →
        </a>
      @endif
    </div>

    @if ($announcements->isNotEmpty())
      @php
        $featuredAnnouncement = $announcements->first();
        $sideAnnouncements = $announcements->slice(1, 2);
        $featuredDate = $featuredAnnouncement->published_at
          ? \Carbon\Carbon::parse($featuredAnnouncement->published_at)
          : \Carbon\Carbon::parse($featuredAnnouncement->created_at);
      @endphp

      <div class="grid md:grid-cols-3 gap-0 border" style="border-color:rgba(26,63,196,.1);">

        <article class="md:col-span-2 border-r hover-card group" style="border-color:rgba(26,63,196,.1);">
          <div class="h-56 relative overflow-hidden" style="background:linear-gradient(135deg,var(--royal-deeper),var(--royal) 60%,#2952d9);">
            <div class="absolute inset-0 flex items-center justify-center opacity-[.06]">
              <p class="display text-white font-black" style="font-size:9rem;">{{ $featuredAnnouncement->pinned ? '★' : 'HSST' }}</p>
            </div>
            <div class="absolute inset-x-0 bottom-0 p-6 flex items-end justify-between">
              <span class="kicker font-bold px-3 py-1.5 text-ink" style="background:var(--gold);">
                {{ $featuredAnnouncement->pinned ? 'Pinned' : 'Announcement' }}
              </span>
              <span class="kicker text-white/40 text-[.6rem]">{{ $featuredDate->timezone('Asia/Manila')->format('F j, Y') }}</span>
            </div>
          </div>
          <div class="p-8">
            <span class="kicker text-[.6rem] block mb-3" style="color:var(--royal);">{{ $featuredAnnouncement->pinned ? 'Important Update' : 'Latest Update' }}</span>
            <h3 class="display text-ink text-2xl font-bold mb-4 leading-snug group-hover:text-royal transition-colors">
              {{ $featuredAnnouncement->title }}
            </h3>
            <p class="garamond text-ink/55" style="font-size:.98rem;">
              {{ \Illuminate\Support\Str::limit($featuredAnnouncement->body ?? 'Stay tuned for the latest alumni news and official announcements.', 200) }}
            </p>
            @if(Route::has('announcements.show'))
              <div class="mt-6">
                <a href="{{ route('announcements.show', $featuredAnnouncement->id) }}"
                   class="kicker font-bold article-link hover:opacity-70 transition-opacity text-[.65rem]"
                   style="color:var(--royal);">
                  Read Full Article →
                </a>
              </div>
            @endif
          </div>
        </article>

        <div class="flex flex-col divide-y" style="divide-color:rgba(26,63,196,.1);">
          @forelse ($sideAnnouncements as $announcement)
            @php
              $newsDate = $announcement->published_at
                ? \Carbon\Carbon::parse($announcement->published_at)
                : \Carbon\Carbon::parse($announcement->created_at);
            @endphp
            <article class="hover-card group flex-1 flex flex-col">
              <div class="h-28" style="background:{{ $loop->first ? 'linear-gradient(135deg,var(--royal-deeper),#2952d9)' : 'linear-gradient(135deg,#a07a08,#e8b80f)' }};"></div>
              <div class="p-6 flex-1 flex flex-col">
                <span class="kicker text-ink/35 block mb-1 text-[.6rem]">{{ $announcement->pinned ? 'Pinned Update' : 'Announcement' }}</span>
                <h3 class="display text-ink font-bold text-sm leading-snug group-hover:text-royal transition-colors flex-1">
                  {{ \Illuminate\Support\Str::limit($announcement->title, 85) }}
                </h3>
                <p class="kicker text-ink/30 mt-3 text-[.6rem]" style="text-transform:none;letter-spacing:.04em;">{{ $newsDate->timezone('Asia/Manila')->format('M j, Y') }}</p>
                @if(Route::has('announcements.show'))
                  <a href="{{ route('announcements.show', $announcement->id) }}"
                     class="kicker font-bold article-link mt-3 inline-block text-[.62rem]"
                     style="color:var(--royal);">
                    Read More →
                  </a>
                @endif
              </div>
            </article>
          @empty
            <article class="hover-card group flex-1 flex flex-col">
              <div class="h-28" style="background:linear-gradient(135deg,var(--royal-deeper),#2952d9);"></div>
              <div class="p-6">
                <p class="kicker text-ink/40 mb-1 text-[.6rem]">Announcement</p>
                <h3 class="display text-ink font-bold text-sm leading-snug">More updates will be posted soon</h3>
              </div>
            </article>
            <article class="hover-card group flex-1 flex flex-col">
              <div class="h-28" style="background:linear-gradient(135deg,#a07a08,#e8b80f);"></div>
              <div class="p-6">
                <p class="kicker text-ink/40 mb-1 text-[.6rem]">Announcement</p>
                <h3 class="display text-ink font-bold text-sm leading-snug">Stay tuned for Centennial news</h3>
              </div>
            </article>
          @endforelse
        </div>

      </div>
    @else
      <div class="reveal border p-12 text-center" style="border-color:rgba(26,63,196,.1);">
        <p class="display text-2xl text-ink mb-2">No announcements yet</p>
        <p class="garamond text-ink/45">Please check back soon for the latest alumni announcements.</p>
      </div>
    @endif

  </div>
</section>

<!-- ══════════════════════════════════════
     BATCH HIGHLIGHTS / SUCCESS STORIES
══════════════════════════════════════ -->
<section id="stories" class="py-20 sm:py-28" style="background:var(--snow);">
  <div class="max-w-7xl mx-auto px-6">

    <div class="text-center mb-14 reveal">
      <div class="section-tag justify-center">
        <span class="bar"></span>
        <span class="kicker" style="color:var(--gold);">Alumni Voices</span>
        <span class="bar"></span>
      </div>
      <h2 class="display text-ink mt-3" style="font-size:clamp(2rem,3.5vw,3rem);">
        Crusaders Who <em style="color:var(--royal);">Carried the Cross.</em>
      </h2>
      <p class="garamond text-ink/50 mt-4 max-w-xl mx-auto">
        From Tagbilaran to the world - HSSTians who turned school values into extraordinary lives.
      </p>
    </div>

    <div class="grid md:grid-cols-3 gap-6">

      <div class="reveal d1 bg-white p-8" style="border-top:3px solid var(--royal);box-shadow:0 2px 16px rgba(26,63,196,.06);">
        <span class="open-quote">"</span>
        <blockquote class="garamond italic text-ink/75 text-base leading-relaxed mb-7 -mt-3">
          As Holy Spirit School of Tagbilaran celebrates 100 years of inspiring young minds and souls,
          I'm filled with pride and purpose, eager to join its historic celebration. My own journey was
          shaped by HSST's values and teachings, and now it's our chance to pay it forward. Together,
          with just PhP1,000 from 100 of us, we can empower the next generation and create lasting change.
          Let's come together to invest in the future through our beloved Alma Mater.
        </blockquote>
        <div class="border-t pt-5" style="border-color:rgba(26,63,196,.1);">
          <div class="flex items-center gap-3">
            <div class="w-10 h-10 flex items-center justify-center kicker font-bold text-white shrink-0"
                 style="background:linear-gradient(135deg,var(--royal-dark),var(--royal));">SS</div>
            <div>
              <p class="kicker font-bold text-ink text-[.68rem]">Steven Sarigumba Suganob</p>
              <p class="kicker text-ink/35 mt-0.5 text-[.58rem]" style="text-transform:none;letter-spacing:.08em;">Elementary Batch 1987 · Philadelphia, PA, USA</p>
            </div>
          </div>
        </div>
      </div>

      <div class="reveal d2 p-8" style="background:var(--royal-deeper);border-top:3px solid var(--gold);">
        <span class="open-quote" style="color:var(--gold);">"</span>
        <blockquote class="garamond italic text-white/75 text-base leading-relaxed mb-7 -mt-3">
          I spent four formative years at HSS, where my values took root and my closest friendships were formed.
          For over twenty years, I have served as an international civil servant with the World Health Organization,
          and the values I carry from HSS continue to guide me today.
        </blockquote>
        <div class="border-t pt-5" style="border-color:rgba(255,255,255,.1);">
          <div class="flex items-center gap-3">
            <div class="w-10 h-10 flex items-center justify-center kicker font-bold text-white shrink-0"
                 style="background:rgba(255,255,255,.1);border:1px solid rgba(255,255,255,.15);">GPV</div>
            <div>
              <p class="kicker font-bold text-white text-[.68rem]">Gemma Payot Vestal</p>
              <p class="kicker text-white/35 mt-0.5 text-[.58rem]" style="text-transform:none;letter-spacing:.08em;">High School Class 1982 · Cairo, Egypt</p>
            </div>
          </div>
        </div>
      </div>

      <div class="reveal d3 bg-white p-8" style="border-top:3px solid #0a7c68;box-shadow:0 2px 16px rgba(26,63,196,.06);">
        <span class="open-quote" style="color:#0a7c68;">"</span>
        <blockquote class="garamond italic text-ink/75 text-base leading-relaxed mb-7 -mt-3">
          It was an immense sense of pride to be a student of Saint Joseph's College, circa 1960s.
          During BIDSAL time, SJC's students walked proud and tall reaping almost all the medals from
          religion, spelling, dance and declamation contests. Now in my twilight years here in the USA,
          my SJC memories warm my heart with joy, nostalgia &amp; gratitude.
        </blockquote>
        <div class="border-t pt-5" style="border-color:rgba(26,63,196,.1);">
          <div class="flex items-center gap-3">
            <div class="w-10 h-10 flex items-center justify-center kicker font-bold text-white shrink-0"
                 style="background:#0a7c68;">EE</div>
            <div>
              <p class="kicker font-bold text-ink text-[.68rem]">Estela Enerio</p>
              <p class="kicker text-ink/35 mt-0.5 text-[.58rem]" style="text-transform:none;letter-spacing:.08em;">Saint Joseph's College · Elem '54 · HS '60 · College '62 · USA</p>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
</section>

<!-- ══════════════════════════════════════
     SUPPORT - CRUSADE DONATION
══════════════════════════════════════ -->
<section id="crusade" class="relative py-20 sm:py-28 overflow-hidden" style="background:var(--ink);">

  <div class="pointer-events-none absolute inset-0 opacity-[.035]"
       style="background-image:radial-gradient(circle at 50% 50%,rgba(255,255,255,1) 1px,transparent 1px);background-size:32px 32px;"></div>
  <div class="absolute top-0 left-0 w-full h-1 shimmer"></div>

  <div class="relative z-10 max-w-7xl mx-auto px-6">

    <div class="text-center mb-14 reveal">
      <div class="section-tag justify-center">
        <span class="bar"></span>
        <span class="kicker" style="color:var(--gold);">Centennial Giving Campaign</span>
        <span class="bar"></span>
      </div>
      <h2 class="display text-white mt-4" style="font-size:clamp(2.4rem,6vw,5rem);">
        Join the <em style="color:var(--gold);">CRUSADE.</em>
      </h2>
      <p class="garamond mt-4 max-w-xl mx-auto" style="color:rgba(255,255,255,.5);">
        Be generous. Join us in shaping a brighter future for our students and community,
        where every gift - regardless of size - leaves a lasting impact.
      </p>
    </div>

    <div class="reveal d1 grid md:grid-cols-2 gap-0 border border-white/10 mb-14">

      <div class="p-8 md:p-12 border-b md:border-b-0 md:border-r border-white/10">
        <span class="kicker block mb-4" style="color:var(--gold);">Your Legacy Gift</span>
        <h3 class="display text-white mb-5" style="font-size:clamp(1.6rem,3vw,2.4rem);">
          Your generosity can leave an <em>enduring legacy.</em>
        </h3>
        <p class="garamond mb-5" style="color:rgba(255,255,255,.5);">
          Although <strong style="color:var(--gold);">PhP 100,000 per batch</strong> is recommended,
          every gift - no matter the amount - is invaluable and deeply cherished.
        </p>
        <p class="garamond" style="color:rgba(255,255,255,.5);">
          Your support will fuel our Centennial Celebrations, enhancing campus life,
          expanding financial aid, and driving academic and scholarship excellence.
        </p>

        <div class="mt-8 space-y-5">
          <div class="flex gap-4 items-start">
            <div class="w-6 h-6 flex-shrink-0 flex items-center justify-center mt-0.5 kicker text-ink font-bold text-[.58rem]" style="background:var(--gold);">I</div>
            <div>
              <p class="kicker font-bold text-white/70">Elevating Campus Experience</p>
              <p class="kicker text-white/30 mt-1 text-[.62rem]" style="text-transform:none;letter-spacing:.04em;">Transformative upgrades to learning spaces and technology</p>
            </div>
          </div>
          <div class="flex gap-4 items-start">
            <div class="w-6 h-6 flex-shrink-0 flex items-center justify-center mt-0.5 kicker text-white font-bold text-[.58rem]" style="background:var(--royal);">II</div>
            <div>
              <p class="kicker font-bold text-white/70">Faculty Development</p>
              <p class="kicker text-white/30 mt-1 text-[.62rem]" style="text-transform:none;letter-spacing:.04em;">Investing in the educators who shape future Crusaders</p>
            </div>
          </div>
          <div class="flex gap-4 items-start">
            <div class="w-6 h-6 flex-shrink-0 flex items-center justify-center mt-0.5 kicker text-white font-bold text-[.58rem]" style="background:#0a7c68;">III</div>
            <div>
              <p class="kicker font-bold text-white/70">Crusaders Scholarship Fund</p>
              <p class="kicker text-white/30 mt-1 text-[.62rem]" style="text-transform:none;letter-spacing:.04em;">Empowering students to reach new heights</p>
            </div>
          </div>
        </div>
      </div>

      <div class="p-8 md:p-12 bg-white">
        <p class="display font-bold text-ink text-xl mb-1">Make Your Gift Today</p>
        <p class="kicker text-ink/40 mb-7 text-[.65rem]">Choose an amount or enter your own</p>

        <div class="mb-5 grid grid-cols-3 gap-2" id="amount-grid">
          <button onclick="selectAmt(this,'500')"    class="amt-btn border border-ink/15 bg-snow py-2.5 kicker font-bold text-ink hover:bg-ink hover:text-white hover:border-ink transition-all text-[.65rem]">₱500</button>
          <button onclick="selectAmt(this,'1000')"   class="amt-btn border border-ink/15 bg-snow py-2.5 kicker font-bold text-ink hover:bg-ink hover:text-white hover:border-ink transition-all text-[.65rem]">₱1,000</button>
          <button onclick="selectAmt(this,'5000')"   class="amt-btn border border-ink/15 bg-snow py-2.5 kicker font-bold text-ink hover:bg-ink hover:text-white hover:border-ink transition-all text-[.65rem]">₱5,000</button>
          <button onclick="selectAmt(this,'10000')"  class="amt-btn border border-ink/15 bg-snow py-2.5 kicker font-bold text-ink hover:bg-ink hover:text-white hover:border-ink transition-all text-[.65rem]">₱10,000</button>
          <button onclick="selectAmt(this,'50000')"  class="amt-btn border border-ink/15 bg-snow py-2.5 kicker font-bold text-ink hover:bg-ink hover:text-white hover:border-ink transition-all text-[.65rem]">₱50,000</button>
          <button onclick="selectAmt(this,'100000')" class="amt-btn border-2 py-2.5 kicker font-bold text-ink transition-all text-[.65rem]" style="background:var(--gold);border-color:var(--gold);">₱100,000 ✦</button>
        </div>

        <div class="mb-4">
          <label class="kicker text-ink/45 block mb-1.5 text-[.62rem]">Or enter custom amount (PhP)</label>
          <div class="flex items-center border border-ink/15 focus-within:border-royal transition-colors" style="background:#f4f7ff;">
            <span class="px-3 kicker font-bold text-ink/35 text-[.65rem]">₱</span>
            <input id="custom-amt" type="number" placeholder="Enter amount"
                   class="flex-1 py-3 pr-4 kicker text-ink outline-none bg-transparent text-[.72rem]"
                   oninput="clearSelected()"/>
          </div>
        </div>

        <div class="mb-4">
          <label class="kicker text-ink/45 block mb-1.5 text-[.62rem]">Full Name</label>
          <input type="text" placeholder="Juan dela Cruz" class="form-input"/>
        </div>

        <div class="mb-7">
          <label class="kicker text-ink/45 block mb-1.5 text-[.62rem]">Batch Year</label>
          <input type="text" placeholder="e.g. 1998, 2005, 2012" class="form-input"/>
        </div>

        <button type="button" class="donate-ring relative w-full flex items-center justify-center gap-2 text-ink kicker font-bold py-4 hover:opacity-90 transition-opacity" style="background:var(--gold);">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
          </svg>
          Give Now · Fueled by Compassion
        </button>
        <p class="kicker text-ink/25 text-center mt-3 text-[.6rem]" style="text-transform:none;letter-spacing:.06em;">All donations are acknowledged &amp; deeply cherished</p>
        <p class="text-center mt-2 text-[.72rem] text-ink/40" style="font-family:inherit;">
          Have an account?
          <a href="{{ route('login') }}" class="text-ink/70 underline underline-offset-2 hover:text-ink transition-colors">Sign in</a>
          to donate with your alumni profile.
        </p>
      </div>
    </div>

    <div class="grid md:grid-cols-3 gap-0 border border-white/10 reveal d2">
      <div class="p-8 border-b md:border-b-0 md:border-r border-white/10">
        <div class="flex items-center gap-3 mb-5">
          <div class="w-9 h-9 flex items-center justify-center" style="background:var(--gold);">
            <svg class="w-4 h-4 text-ink" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
            </svg>
          </div>
          <span class="kicker font-bold" style="color:var(--gold);">Pillar One</span>
        </div>
        <h4 class="display text-white text-xl font-bold mb-3">Elevating Campus Experience</h4>
        <p class="garamond" style="color:rgba(255,255,255,.4);font-size:.93rem;">
          Transformative upgrades to learning spaces, facilities, and technology -
          ensuring every student thrives in an environment worthy of their potential.
        </p>
      </div>

      <div class="p-8 border-b md:border-b-0 md:border-r border-white/10" style="background:rgba(26,63,196,.12);">
        <div class="flex items-center gap-3 mb-5">
          <div class="w-9 h-9 flex items-center justify-center" style="background:var(--royal);">
            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
            </svg>
          </div>
          <span class="kicker font-bold text-white/45">Pillar Two</span>
        </div>
        <h4 class="display text-white text-xl font-bold mb-3">Faculty Development</h4>
        <p class="garamond" style="color:rgba(255,255,255,.5);font-size:.93rem;">
          Investing in the dedicated educators who shape future Crusaders - through training,
          scholarships, and professional growth programs.
        </p>
      </div>

      <div class="p-8">
        <div class="flex items-center gap-3 mb-5">
          <div class="w-9 h-9 flex items-center justify-center" style="background:#0a7c68;">
            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
            </svg>
          </div>
          <span class="kicker font-bold" style="color:#0f9980;">Pillar Three</span>
        </div>
        <h4 class="display text-white text-xl font-bold mb-3">Crusaders Scholarship Fund</h4>
        <p class="garamond" style="color:rgba(255,255,255,.4);font-size:.93rem;">
          Empowering deserving students to reach new heights - funding equipment, training,
          and opportunities that build character through excellence.
        </p>
      </div>
    </div>

  </div>
</section>

<!-- ══════════════════════════════════════
     FAQ
══════════════════════════════════════ -->
<section id="faq" class="py-20 sm:py-28 bg-white">
  <div class="max-w-3xl mx-auto px-6">

    <div class="text-center mb-12 reveal">
      <div class="section-tag justify-center mb-1">
        <span class="bar"></span>
        <span class="kicker" style="color:var(--gold);">Common Questions</span>
        <span class="bar"></span>
      </div>
      <h2 class="display text-ink mt-3" style="font-size:clamp(2rem,3.5vw,3rem);">Frequently Asked Questions</h2>
      <p class="garamond text-ink/50 mt-4">Everything you need to know about the HSSTian Alumni Association and the Centennial.</p>
    </div>

    <div class="space-y-3 reveal d1">

      <details class="faq-item border" style="border-color:rgba(26,63,196,.12);">
        <summary class="flex items-center justify-between p-5 hover:bg-blue-50/50 transition-colors">
          <span class="font-display font-semibold text-ink text-base pr-4">Who can join the HSSTian Alumni Association?</span>
          <span class="faq-icon w-7 h-7 flex items-center justify-center shrink-0 text-xl font-light" style="color:var(--royal);">+</span>
        </summary>
        <div class="px-5 pb-6">
          <p class="garamond text-ink/60">Any graduate of Holy Spirit School of Tagbilaran - whether elementary, high school, or college - is automatically a member of the HSSTian Alumni Association. All Crusaders, past and present, are welcome home.</p>
        </div>
      </details>

      <details class="faq-item border" style="border-color:rgba(26,63,196,.12);">
        <summary class="flex items-center justify-between p-5 hover:bg-blue-50/50 transition-colors">
          <span class="font-display font-semibold text-ink text-base pr-4">What is the CRUSADE campaign?</span>
          <span class="faq-icon w-7 h-7 flex items-center justify-center shrink-0 text-xl font-light" style="color:var(--royal);">+</span>
        </summary>
        <div class="px-5 pb-6">
          <p class="garamond text-ink/60">CRUSADE is our Centennial giving campaign with three pillars: Elevating Campus Experience, Faculty Development, and the Crusaders Scholarship Fund. The recommended donation is PhP 100,000 per batch, but every contribution of any amount is warmly welcomed and deeply cherished.</p>
        </div>
      </details>

      <details class="faq-item border" style="border-color:rgba(26,63,196,.12);">
        <summary class="flex items-center justify-between p-5 hover:bg-blue-50/50 transition-colors">
          <span class="font-display font-semibold text-ink text-base pr-4">When is the Centennial Grand Reunion?</span>
          <span class="faq-icon w-7 h-7 flex items-center justify-center shrink-0 text-xl font-light" style="color:var(--royal);">+</span>
        </summary>
        <div class="px-5 pb-6">
          <p class="garamond text-ink/60">The Centennial Grand Reunion is scheduled for 2026, commemorating 100 years of Holy Spirit School of Tagbilaran. Please visit the Events section above or check official alumni announcements for the exact dates and schedule of activities.</p>
        </div>
      </details>

      <details class="faq-item border" style="border-color:rgba(26,63,196,.12);">
        <summary class="flex items-center justify-between p-5 hover:bg-blue-50/50 transition-colors">
          <span class="font-display font-semibold text-ink text-base pr-4">How do I register as a batch representative?</span>
          <span class="faq-icon w-7 h-7 flex items-center justify-center shrink-0 text-xl font-light" style="color:var(--royal);">+</span>
        </summary>
        <div class="px-5 pb-6">
          <p class="garamond text-ink/60">Create an account on this platform and complete your alumni profile. Batch representative registration is handled through official alumni coordination. For inquiries, please use the contact form below or reach us at alumni@hss-tagbilaran.edu.ph.</p>
        </div>
      </details>

      <details class="faq-item border" style="border-color:rgba(26,63,196,.12);">
        <summary class="flex items-center justify-between p-5 hover:bg-blue-50/50 transition-colors">
          <span class="font-display font-semibold text-ink text-base pr-4">How are donations used?</span>
          <span class="faq-icon w-7 h-7 flex items-center justify-center shrink-0 text-xl font-light" style="color:var(--royal);">+</span>
        </summary>
        <div class="px-5 pb-6">
          <p class="garamond text-ink/60">All donations go directly toward the three CRUSADE pillars: campus improvement projects, faculty training and development, and student scholarships. Full transparency reports are provided to all donors and batch representatives.</p>
        </div>
      </details>

      <details class="faq-item border" style="border-color:rgba(26,63,196,.12);">
        <summary class="flex items-center justify-between p-5 hover:bg-blue-50/50 transition-colors">
          <span class="font-display font-semibold text-ink text-base pr-4">Can I donate on behalf of my batch?</span>
          <span class="faq-icon w-7 h-7 flex items-center justify-center shrink-0 text-xl font-light" style="color:var(--royal);">+</span>
        </summary>
        <div class="px-5 pb-6">
          <p class="garamond text-ink/60">Yes! You can coordinate with your batch representative to pool contributions and donate collectively. This is the recommended approach to meet the PhP 100,000 per batch target. Contact us for bulk donation coordination.</p>
        </div>
      </details>

    </div>
  </div>
</section>

<!-- ══════════════════════════════════════
     CTA BANNER
══════════════════════════════════════ -->
<section class="relative overflow-hidden py-24 sm:py-32 section-blue">
  <div class="absolute top-0 left-0 right-0 h-1 shimmer"></div>
  <div class="pointer-events-none absolute inset-0 flex items-center justify-center overflow-hidden opacity-[.04]">
    <p class="display text-white font-black" style="font-size:16vw;white-space:nowrap;line-height:1;">CRUSADERS</p>
  </div>

  <div class="relative z-10 max-w-3xl mx-auto px-6 text-center">
    <div class="section-tag justify-center mb-5 reveal">
      <span class="bar"></span>
      <span class="kicker" style="color:var(--gold);">Together, We Are Crusaders</span>
      <span class="bar"></span>
    </div>

    <h2 class="display text-white reveal d1 mb-6" style="font-size:clamp(2.4rem,6vw,4.5rem);">
      Together, fueled by<br/>
      <em style="color:var(--gold);">compassion &amp; dedication,</em><br/>
      we create meaningful change.
    </h2>

    <p class="garamond reveal d2 mb-10 max-w-lg mx-auto" style="color:rgba(255,255,255,.5);">
      No gift is too small. No Crusader is forgotten. Join thousands of alumni who
      are building the next chapter of Holy Spirit School.
    </p>

    <div class="flex flex-wrap gap-4 justify-center reveal d3">
      <a href="#crusade"
         class="kicker font-bold text-ink px-10 py-4 hover:opacity-90 transition-opacity flex items-center gap-2"
         style="background:var(--gold);">
        Donate to CRUSADE
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
        </svg>
      </a>
      <a href="#contact"
         class="kicker font-bold border border-white/25 text-white/70 px-10 py-4 hover:border-white/60 hover:text-white transition-all">
        Get in Touch
      </a>
    </div>

    <p class="kicker mt-12 text-white/18 reveal d4" style="letter-spacing:.22em;font-size:.6rem;">
      IN VERITATE ET CARITATE · TRUTH AND LOVE · 1926–2026
    </p>
  </div>
</section>

<!-- ══════════════════════════════════════
     CONTACT SECTION
══════════════════════════════════════ -->
<section id="contact" class="py-20 sm:py-28" style="background:var(--snow);">
  <div class="max-w-7xl mx-auto px-6">

    <div class="text-center mb-14 reveal">
      <div class="section-tag justify-center mb-1">
        <span class="bar"></span>
        <span class="kicker" style="color:var(--gold);">Reach Out</span>
        <span class="bar"></span>
      </div>
      <h2 class="display text-ink mt-3" style="font-size:clamp(2rem,3.5vw,3rem);">Get in Touch</h2>
      <p class="garamond text-ink/50 mt-4 max-w-lg mx-auto">
        Have a question, batch inquiry, or want to get involved? We'd love to hear from you.
      </p>
    </div>

    <div class="grid md:grid-cols-3 gap-8">

      <div class="space-y-5 reveal d1">
        <div class="bg-white p-6 border" style="border-color:rgba(26,63,196,.1);box-shadow:0 2px 14px rgba(26,63,196,.05);">
          <div class="w-10 h-10 flex items-center justify-center mb-4" style="background:var(--royal-frost);">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color:var(--royal);">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
            </svg>
          </div>
          <p class="kicker font-bold text-ink mb-1 text-[.65rem]">Email Us</p>
          <p class="garamond text-ink/60 text-sm">alumni@hss-tagbilaran.edu.ph</p>
        </div>

        <div class="bg-white p-6 border" style="border-color:rgba(26,63,196,.1);box-shadow:0 2px 14px rgba(26,63,196,.05);">
          <div class="w-10 h-10 flex items-center justify-center mb-4" style="background:var(--royal-frost);">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color:var(--royal);">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
            </svg>
          </div>
          <p class="kicker font-bold text-ink mb-1 text-[.65rem]">Call Us</p>
          <p class="garamond text-ink/60 text-sm">+63 38 501 0000</p>
        </div>

        <div class="bg-white p-6 border" style="border-color:rgba(26,63,196,.1);box-shadow:0 2px 14px rgba(26,63,196,.05);">
          <div class="w-10 h-10 flex items-center justify-center mb-4" style="background:var(--royal-frost);">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color:var(--royal);">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
            </svg>
          </div>
          <p class="kicker font-bold text-ink mb-1 text-[.65rem]">Visit Us</p>
          <p class="garamond text-ink/60 text-sm">Holy Spirit School, Tagbilaran City, Bohol 6300</p>
        </div>
      </div>

      <div class="md:col-span-2 bg-white p-8 border reveal d2" style="border-color:rgba(26,63,196,.1);box-shadow:0 2px 18px rgba(26,63,196,.06);">
        <p class="display font-bold text-ink text-xl mb-1">Send a Message</p>
        <p class="kicker text-ink/40 mb-7 text-[.65rem]">We'll get back to you as soon as possible</p>

        <div class="grid sm:grid-cols-2 gap-4 mb-4">
          <div>
            <label class="kicker text-ink/45 block mb-1.5 text-[.62rem]">Full Name</label>
            <input type="text" placeholder="Juan dela Cruz" class="form-input"/>
          </div>
          <div>
            <label class="kicker text-ink/45 block mb-1.5 text-[.62rem]">Email Address</label>
            <input type="email" placeholder="juan@example.com" class="form-input"/>
          </div>
        </div>

        <div class="mb-4">
          <label class="kicker text-ink/45 block mb-1.5 text-[.62rem]">Batch Year (optional)</label>
          <input type="text" placeholder="e.g. 1998, 2005, 2012" class="form-input"/>
        </div>

        <div class="mb-7">
          <label class="kicker text-ink/45 block mb-1.5 text-[.62rem]">Message</label>
          <textarea rows="5" placeholder="Your message here..." class="form-input resize-none"></textarea>
        </div>

        <button type="button" class="kicker font-bold text-white px-8 py-4 hover:opacity-90 transition-opacity" style="background:var(--royal);">
          Send Message →
        </button>
      </div>

    </div>
  </div>
</section>

<!-- ══════════════════════════════════════
     ELEGANT FOOTER
══════════════════════════════════════ -->
<footer style="background:var(--ink);" class="pt-16 pb-8">
  <div class="max-w-7xl mx-auto px-6">

    <div class="text-center pb-10 mb-10 border-b border-white/8">
      <p class="kicker text-white/20 mb-2" style="letter-spacing:.3em;">THE OFFICIAL PORTAL OF</p>
      <h2 class="display text-white font-bold" style="font-size:clamp(1.8rem,4vw,3rem);">HSSTian Alumni Association</h2>
      <p class="kicker text-white/25 mt-2" style="letter-spacing:.2em;">HOLY SPIRIT SCHOOL OF TAGBILARAN · BOHOL, PHILIPPINES</p>
      <div class="flex items-center justify-center gap-4 mt-5">
        <div class="h-px flex-1 max-w-24" style="background:linear-gradient(90deg,transparent,var(--gold));"></div>
        <span class="kicker font-bold" style="color:var(--gold);letter-spacing:.28em;font-size:.62rem;">IN VERITATE ET CARITATE</span>
        <div class="h-px flex-1 max-w-24" style="background:linear-gradient(90deg,var(--gold),transparent);"></div>
      </div>
    </div>

    <div class="grid md:grid-cols-4 gap-10 pb-12 border-b border-white/8">

      <div class="md:col-span-2">
        <div class="flex items-center gap-3 mb-4">
          <img src="{{ asset('images/hsstlogo.jpg') }}" alt="HSST Logo" class="h-8 w-auto object-contain opacity-75"/>
          <div>
            <p class="display text-white font-bold text-base">HSSTian</p>
            <p class="kicker text-[.53rem]" style="letter-spacing:.22em;color:rgba(255,255,255,.55);">Alumni Association</p>
          </div>
        </div>
        <p class="garamond max-w-xs mb-5" style="font-size:.9rem;line-height:1.7;color:rgba(255,255,255,.55);">
          United by faith. Driven by service. Forever Crusaders.
          Tagbilaran City, Bohol, Philippines.
        </p>
        <p class="kicker font-bold mb-1" style="color:var(--gold);">In Veritate et Caritate</p>
        <p class="kicker italic" style="letter-spacing:.06em;text-transform:none;font-size:.67rem;color:rgba(255,255,255,.45);">In Truth and in Love</p>
        <div class="flex gap-2 mt-5">
          <a href="#" class="w-9 h-9 flex items-center justify-center transition-all" style="border:1px solid rgba(255,255,255,.15);color:rgba(255,255,255,.5);">
            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24">
              <path d="M18.77 7.46H14.5v-1.9c0-.9.6-1.1 1-1.1h3V.5h-4.33C10.24.5 9.5 3.44 9.5 5.32v2.15h-3v4h3v12h5v-12h3.85l.42-4z"/>
            </svg>
          </a>
          <a href="#" class="w-9 h-9 flex items-center justify-center transition-all" style="border:1px solid rgba(255,255,255,.15);color:rgba(255,255,255,.5);">
            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24">
              <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
            </svg>
          </a>
        </div>
      </div>

      <div>
        <p class="kicker font-bold mb-5" style="letter-spacing:.22em;color:rgba(255,255,255,.6);">Quick Links</p>
        <ul class="space-y-3">
          <li><a href="#about"   class="kicker transition-colors" style="text-transform:none;font-size:.78rem;letter-spacing:.06em;color:rgba(255,255,255,.55);">About Us</a></li>
          <li><a href="{{ route('history') }}" class="kicker transition-colors" style="text-transform:none;font-size:.78rem;letter-spacing:.06em;color:rgba(255,255,255,.55);">History</a></li>
          <li><a href="#crusade" class="kicker transition-colors" style="text-transform:none;font-size:.78rem;letter-spacing:.06em;color:rgba(255,255,255,.55);">CRUSADE Donation</a></li>
          <li><a href="#events"  class="kicker transition-colors" style="text-transform:none;font-size:.78rem;letter-spacing:.06em;color:rgba(255,255,255,.55);">Events</a></li>
          <li><a href="#stories" class="kicker transition-colors" style="text-transform:none;font-size:.78rem;letter-spacing:.06em;color:rgba(255,255,255,.55);">Alumni Stories</a></li>
          <li><a href="#news"    class="kicker transition-colors" style="text-transform:none;font-size:.78rem;letter-spacing:.06em;color:rgba(255,255,255,.55);">News &amp; Updates</a></li>
          <li><a href="#faq"     class="kicker transition-colors" style="text-transform:none;font-size:.78rem;letter-spacing:.06em;color:rgba(255,255,255,.55);">FAQ</a></li>
        </ul>
      </div>

      <div>
        <p class="kicker font-bold mb-5" style="letter-spacing:.22em;color:rgba(255,255,255,.6);">Contact</p>
        <ul class="space-y-4">
          <li class="flex gap-2.5 items-start">
            <svg class="w-3.5 h-3.5 mt-0.5 shrink-0" style="color:rgba(255,255,255,.5);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
            </svg>
            <span class="kicker" style="text-transform:none;font-size:.74rem;letter-spacing:.04em;color:rgba(255,255,255,.55);">alumni@hss-tagbilaran.edu.ph</span>
          </li>
          <li class="flex gap-2.5 items-start">
            <svg class="w-3.5 h-3.5 mt-0.5 shrink-0" style="color:rgba(255,255,255,.5);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
            </svg>
            <span class="kicker" style="text-transform:none;font-size:.74rem;letter-spacing:.04em;color:rgba(255,255,255,.55);">+63 38 501 0000</span>
          </li>
          <li class="flex gap-2.5 items-start">
            <svg class="w-3.5 h-3.5 mt-0.5 shrink-0" style="color:rgba(255,255,255,.5);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
            </svg>
            <span class="kicker" style="text-transform:none;font-size:.74rem;letter-spacing:.04em;color:rgba(255,255,255,.55);">Holy Spirit School, Tagbilaran City, Bohol 6300</span>
          </li>
        </ul>
      </div>

    </div>

    <div class="pt-8 flex flex-col md:flex-row items-center justify-between gap-3">
      <div class="flex flex-col md:flex-row items-center gap-3">
        <p class="kicker" style="text-transform:none;font-size:.68rem;letter-spacing:.08em;color:rgba(255,255,255,.45);">
          © {{ now('Asia/Manila')->format('Y') }} HSSTian Alumni Association · Holy Spirit School of Tagbilaran. All rights reserved.
        </p>
        <a href="{{ route('privacy') }}" class="kicker transition-colors" style="text-transform:none;font-size:.68rem;letter-spacing:.08em;color:rgba(255,255,255,.5);">
          Privacy Policy
        </a>
      </div>
      <p class="kicker font-bold" style="color:var(--gold);opacity:.45;letter-spacing:.25em;font-size:.6rem;">
        CRUSADERS FOREVER ✦
      </p>
    </div>

  </div>
</footer>

<!-- ══════════════════════════════════════
     JAVASCRIPT
══════════════════════════════════════ -->
<script>
  // ── Mobile Menu ───────────────────────
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
    document.body.classList.add('overflow-hidden');
  }
  function closeMobileMenu() {
    mobileMenu.classList.add('hidden');
    menuOpenIcon.classList.remove('hidden');
    menuCloseIcon.classList.add('hidden');
    mobileMenuBtn.setAttribute('aria-expanded', 'false');
    document.body.classList.remove('overflow-hidden');
  }
  mobileMenuBtn?.addEventListener('click', () =>
    mobileMenu.classList.contains('hidden') ? openMobileMenu() : closeMobileMenu()
  );
  closeMobileMenuBtn?.addEventListener('click', closeMobileMenu);
  document.querySelectorAll('.mobile-nav-link').forEach(l => l.addEventListener('click', closeMobileMenu));

  // ── Progress Bar ──────────────────────
  window.addEventListener('scroll', () => {
    const pct = (window.scrollY / (document.body.scrollHeight - window.innerHeight)) * 100;
    document.getElementById('pgbar').style.width = pct + '%';
  });

  // ── Nav scroll state ──────────────────
  const nav              = document.getElementById('nav');
  const logoText         = document.getElementById('logo-text');
  const logoSub          = document.getElementById('logo-sub');
  const navLinks         = document.getElementById('nav-links');
  const loginBtn         = document.getElementById('login-btn');
  const mobileMenuButton = document.getElementById('mobile-menu-btn');

  function setScrolledNav() {
    nav.classList.add('scrolled');
    logoText?.classList.replace('text-white', 'text-ink');
    logoSub?.classList.remove('text-white/50');
    logoSub?.classList.add('text-ink/40');
    navLinks?.querySelectorAll('a').forEach(a => {
      a.classList.remove('text-white/70', 'hover:text-white');
      a.classList.add('text-ink/60', 'hover:text-ink');
    });
    loginBtn?.classList.remove('border-white/25', 'text-white/75', 'hover:border-white/60', 'hover:text-white');
    loginBtn?.classList.add('border-ink/20', 'text-ink/55', 'hover:border-royal/50', 'hover:text-royal');
    mobileMenuButton?.classList.replace('text-white', 'text-ink');
  }

  function setTopNav() {
    nav.classList.remove('scrolled');
    logoText?.classList.replace('text-ink', 'text-white');
    logoSub?.classList.remove('text-ink/40');
    logoSub?.classList.add('text-white/50');
    navLinks?.querySelectorAll('a').forEach(a => {
      a.classList.remove('text-ink/60', 'hover:text-ink');
      a.classList.add('text-white/70', 'hover:text-white');
    });
    loginBtn?.classList.remove('border-ink/20', 'text-ink/55', 'hover:border-royal/50', 'hover:text-royal');
    loginBtn?.classList.add('border-white/25', 'text-white/75', 'hover:border-white/60', 'hover:text-white');
    mobileMenuButton?.classList.replace('text-ink', 'text-white');
  }

  function handleNavScroll() {
    window.scrollY > 60 ? setScrolledNav() : setTopNav();
  }
  window.addEventListener('scroll', handleNavScroll);
  handleNavScroll();

  // ── Reveal on scroll ──────────────────
  const ro = new IntersectionObserver(entries => {
    entries.forEach(e => {
      if (e.isIntersecting) { e.target.classList.add('on'); ro.unobserve(e.target); }
    });
  }, { threshold: 0.08 });
  document.querySelectorAll('.reveal').forEach(el => ro.observe(el));

  // ── Donation amount selector ──────────
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
