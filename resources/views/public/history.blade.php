<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>History · Holy Spirit School of Tagbilaran</title>
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
    .d1{transition-delay:.1s;} .d2{transition-delay:.2s;} .d3{transition-delay:.3s;} .d4{transition-delay:.4s;}

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

    /* Ornament */
    .ornament { display:flex; align-items:center; gap:.75rem; }
    .ornament::before,.ornament::after { content:''; flex:1; border-top:1px solid var(--rule); }

    /* Hero overlay */
    .hero-gradient {
      background:linear-gradient(
        100deg,
        rgba(9,24,52,.96) 0%,
        rgba(14,38,90,.88) 35%,
        rgba(20,52,140,.6) 62%,
        rgba(20,52,140,.18) 100%
      );
    }

    /* Card hover */
    .ed-card { transition:transform .3s cubic-bezier(.22,1,.36,1),box-shadow .3s; }
    .ed-card:hover { transform:translateY(-4px); box-shadow:0 12px 40px rgba(18,16,14,.1); }

    /* Timeline track line */
    .timeline-track::before {
      content:'';
      position:absolute;
      left:0; top:0; bottom:0;
      width:2px;
      background:linear-gradient(180deg, var(--royal) 0%, var(--spirit) 100%);
    }
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
     EDITORIAL NAV
════════════════════════════════════════ -->
<header id="nav" class="fixed inset-x-0 top-0 z-50 md:relative md:z-auto md:top-auto md:fixed">
  <div class="max-w-7xl mx-auto px-6">

    <div class="flex items-center justify-between py-3 md:py-4">
      <!-- Logo + Masthead -->
      <a href="{{ route('home') }}" class="flex items-center gap-3 group">
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
        <a href="{{ route('home') }}"
           class="caption-text text-white/70 md:text-ink/60 hover:text-white md:hover:text-ink transition-colors">Home</a>
        <a href="{{ route('history') }}"
           class="caption-text text-ink font-bold md:text-ink border-b-2 pb-0.5 transition-colors" style="border-color:var(--royal);">History</a>
        <a href="{{ route('events.index') }}"
           class="caption-text text-white/70 md:text-ink/60 hover:text-white md:hover:text-ink transition-colors">Events</a>
        <a href="{{ route('home') }}#crusade"
           class="caption-text text-white/70 md:text-ink/60 hover:text-white md:hover:text-ink transition-colors">CRUSADE</a>
        <a href="{{ route('home') }}#contact"
           class="caption-text text-white/70 md:text-ink/60 hover:text-white md:hover:text-ink transition-colors">Contact</a>
      </nav>

      <!-- Desktop Auth -->
      <div class="hidden md:flex items-center gap-3" id="auth-links">
        @if (Route::has('login'))
          @auth
            <a href="{{ url('/dashboard') }}"
               class="caption-text bg-ink text-paper px-4 py-2 hover:opacity-80 transition-opacity">
              Dashboard
            </a>
          @else
            <a id="login-btn" href="{{ route('login') }}"
               class="caption-text border border-white/25 md:border-ink/20 text-white/80 md:text-ink/60 px-4 py-2 hover:border-white/60 md:hover:border-ink/50 hover:text-white md:hover:text-ink transition-all">
              Login
            </a>
            @if (Route::has('register'))
              <a href="{{ route('register') }}"
                 class="caption-text bg-white md:bg-ink text-ink md:text-paper px-4 py-2 hover:opacity-80 transition-opacity">
                Register
              </a>
            @endif
          @endauth
        @endif
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

    <hr class="col-rule hidden md:block" />
    <div class="hidden md:flex items-center justify-center py-1.5">
      <span class="caption-text text-ink/30 text-[.6rem]" style="letter-spacing:.3em;">
        HOLY SPIRIT SCHOOL OF TAGBILARAN · INSTITUTION HISTORY
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
    <nav class="flex-1 overflow-y-auto px-6 py-4 flex flex-col">
      <a href="{{ route('home') }}" class="mobile-nav-link border-b border-paper/8 py-4 font-display text-lg text-paper/80 hover:text-paper transition-colors">Home</a>
      <a href="{{ route('history') }}" class="mobile-nav-link border-b border-paper/8 py-4 font-display text-lg text-paper font-bold transition-colors">History</a>
      <a href="{{ route('events.index') }}" class="mobile-nav-link border-b border-paper/8 py-4 font-display text-lg text-paper/80 hover:text-paper transition-colors">Events</a>
      <a href="{{ route('home') }}#crusade" class="mobile-nav-link border-b border-paper/8 py-4 font-display text-lg text-paper/80 hover:text-paper transition-colors">CRUSADE</a>
      <a href="{{ route('home') }}#contact" class="mobile-nav-link py-4 font-display text-lg text-paper/80 hover:text-paper transition-colors">Contact</a>
    </nav>
    <div class="border-t border-paper/10 px-6 py-5 flex flex-col gap-3">
      @if (Route::has('login'))
        @auth
          <a href="{{ url('/dashboard') }}"
             class="flex items-center justify-center py-3 bg-paper caption-text text-ink hover:opacity-90 transition-opacity">
            Dashboard
          </a>
        @else
          <a href="{{ route('login') }}"
             class="flex items-center justify-center py-3 border border-paper/15 caption-text text-paper/70 hover:bg-paper/5 transition-colors">
            Login
          </a>
          @if (Route::has('register'))
            <a href="{{ route('register') }}"
               class="flex items-center justify-center py-3 bg-paper caption-text text-ink hover:opacity-90 transition-opacity">
              Register
            </a>
          @endif
        @endauth
      @endif
    </div>
  </div>
</div>

<!-- ════════════════════════════════════════
     HERO — MAGAZINE COVER
════════════════════════════════════════ -->
<section class="relative min-h-[72vh] md:min-h-[80vh] flex items-end overflow-hidden pt-24 md:pt-0">
  <div class="absolute inset-0">
    <img
      src="{{ asset('images/hsstherosect.png') }}"
      alt="Holy Spirit School of Tagbilaran"
      class="absolute inset-0 h-full w-full object-cover object-center"
    />
    <div class="absolute inset-0 hero-gradient"></div>
    <div class="absolute inset-0 opacity-[.04]"
         style="background-image:url(data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='200' height='200'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='200' height='200' filter='url(%23n)' opacity='1'/%3E%3C/svg%3E);">
    </div>
  </div>

  <!-- Vertical rule decoration -->
  <div class="pointer-events-none absolute right-12 top-0 bottom-0 hidden xl:flex flex-col items-center justify-center opacity-10">
    <div class="h-64 w-px bg-white"></div>
    <div class="my-3 caption-text text-white" style="writing-mode:vertical-rl;letter-spacing:.3em;font-size:.6rem;">HOLY SPIRIT SCHOOL · EST. 1926</div>
    <div class="h-64 w-px bg-white"></div>
  </div>

  <div class="relative z-10 w-full max-w-7xl mx-auto px-6 sm:px-8 pb-16 sm:pb-20 md:pb-28">
    <div class="max-w-3xl">

      <div class="mb-6 flex items-center gap-3 animate-fade-up" style="animation-delay:.1s;">
        <div class="h-px w-10" style="background:var(--spirit);"></div>
        <span class="kicker" style="color:var(--spirit); letter-spacing:.25em;">
          Centennial Archive · 1926–2026
        </span>
      </div>

      <h1 class="display text-white mb-6 animate-fade-up"
          style="font-size:clamp(3rem,8vw,6.5rem);animation-delay:.2s;">
        A century of<br/>
        <em style="color:var(--spirit);">faith, learning,</em><br class="hidden sm:block"/>
        and service.
      </h1>

      <p class="garamond text-white/70 mb-8 max-w-xl animate-fade-up"
         style="font-size:clamp(1rem,1.5vw,1.15rem);animation-delay:.32s;">
        From a humble dormitory for girls in Tagbilaran to a thriving institution
        that continues to shape lives — Holy Spirit School of Tagbilaran carries
        a legacy built on mission, excellence, and love for community.
      </p>

      <div class="flex flex-wrap items-start gap-x-8 gap-y-4 animate-fade-up" style="animation-delay:.45s;">
        <div class="border-l-2 pl-4" style="border-color:var(--spirit);">
          <p class="display text-white font-bold" style="font-size:2.2rem;">1926</p>
          <p class="caption-text text-white/40 mt-0.5">Year Founded</p>
        </div>
        <div class="border-l-2 pl-4" style="border-color:rgba(255,255,255,.15);">
          <p class="display text-white font-bold" style="font-size:2.2rem;">100<span style="color:var(--spirit);">+</span></p>
          <p class="caption-text text-white/40 mt-0.5">Years of Excellence</p>
        </div>
        <div class="border-l-2 pl-4" style="border-color:rgba(255,255,255,.15);">
          <p class="display text-white font-bold" style="font-size:2.2rem;">6</p>
          <p class="caption-text text-white/40 mt-0.5">Institutional Names</p>
        </div>
      </div>

    </div>
  </div>

  <div class="absolute inset-x-0 bottom-0 h-20" style="background:linear-gradient(to top,var(--paper),transparent);"></div>
</section>

<!-- ════════════════════════════════════════
     QUICK FACTS — EDITORIAL DATA POINTS
════════════════════════════════════════ -->
<section style="background:var(--paper-dark,#f0ece3);">
  <div class="max-w-7xl mx-auto px-6 py-10 sm:py-12">
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-0 border border-ink/8">

      <div class="p-8 border-b sm:border-b-0 sm:border-r border-ink/8 reveal">
        <span class="kicker block mb-3" style="color:var(--royal);">Founded</span>
        <p class="display text-ink font-bold" style="font-size:3rem;">1926</p>
        <p class="caption-text text-ink/35 mt-2" style="letter-spacing:.08em;text-transform:none;">October 16, on the feast of Nuestra Señora del Pilar</p>
      </div>

      <div class="p-8 border-b sm:border-b-0 sm:border-r border-ink/8 reveal d1">
        <span class="kicker block mb-3" style="color:var(--spirit);">Location</span>
        <p class="display text-ink font-bold" style="font-size:1.9rem;line-height:1.15;">Tagbilaran City,<br/>Bohol</p>
        <p class="caption-text text-ink/35 mt-2" style="letter-spacing:.08em;text-transform:none;">J.A. Clarin, Purok 3, Dao District (current site)</p>
      </div>

      <div class="p-8 reveal d2">
        <span class="kicker block mb-3" style="color:var(--teal);">Current Name</span>
        <p class="display text-ink font-bold" style="font-size:1.9rem;line-height:1.15;">HSST, Inc.</p>
        <p class="caption-text text-ink/35 mt-2" style="letter-spacing:.08em;text-transform:none;">Holy Spirit School of Tagbilaran · Since July 2013</p>
      </div>

    </div>
  </div>
</section>

<!-- ════════════════════════════════════════
     SHORT HISTORY — FEATURE ARTICLE
════════════════════════════════════════ -->
<section class="py-20 sm:py-28" style="background:var(--paper);">
  <div class="max-w-5xl mx-auto px-6">

    <!-- Section header -->
    <div class="mb-12 reveal">
      <hr class="col-rule-thick mb-3"/>
      <div class="flex items-center justify-between">
        <span class="kicker text-royal">Short History</span>
        <span class="caption-text text-ink/30">Centennial Issue · 1926–2026</span>
      </div>
      <h2 class="display text-ink mt-2" style="font-size:clamp(2rem,3.5vw,3rem);">
        The Story of <em style="color:var(--royal);">Holy Spirit School.</em>
      </h2>
      <hr class="col-rule mt-3"/>
    </div>

    <div class="grid items-start gap-14 lg:grid-cols-5">

      <!-- Main narrative (3 cols) -->
      <div class="lg:col-span-3">

        <p class="garamond text-ink/70 drop-cap reveal">
          "That old sleepy town" aptly describes Tagbilaran circa 1926. It was truly a small,
          nondescript town with only one main thoroughfare leading to Plaza Rizal with the
          Gobierno fronting it. Just a stone's throw away was the old stone church where
          San Jose was venerated as its Patron Saint.
        </p>

        <p class="garamond text-ink/70 mt-5 reveal d1">
          Holy Spirit School of Tagbilaran is one link in the chain of educational institutions
          owned and operated by the Mission Congregation of the Servants of the Holy Spirit (SSpS)
          all over the world. It was founded in 1926 by the late Msgr. Gelacio Ramirez, a diocesan
          priest. It started as a dormitory to shelter girls who were studying in Bohol National
          High School. Like a mustard seed which grew into a tree, it developed until it reached
          the stature that it has today.
        </p>

        <!-- Pull quote -->
        <div class="my-10 reveal d2">
          <blockquote class="pull-quote">
            "Like a mustard seed which grew into a tree, it developed until it reached
            the stature that it has today."
          </blockquote>
        </div>

        <p class="garamond text-ink/70 reveal d2">
          On October 16, 1926, on the feast of Nuestra Señora del Pilar, the first three SSpS Sisters
          — Sr. Laeticia, Sr. Blasia, and Sr. Josaphata — arrived in Tagbilaran. This was in answer
          to the request made by Father Gelacio Ramirez for the SSpS Sisters to work in his parish
          in Tagbilaran, Bohol.
        </p>

        <p class="garamond text-ink/70 mt-5 reveal d2">
          Realizing the missionary zeal of the three pioneer Sisters, Father Ramirez helped them open
          a Kindergarten with 19 enrollees on November 1. This was the humble beginning of the
          elementary and high school which soon followed. The school was called Saint Joseph's Academy
          in honor of the Patron of Tagbilaran. With a total of forty-nine learners, the school year
          began in 1927–1928.
        </p>

        <hr class="col-rule my-8 reveal"/>

        <div class="two-col reveal d1">
          <p class="garamond text-ink/70">
            The following year, 1928–1929, brought in more than two hundred learners from Kindergarten
            to Grade Seven and First Year High School. Enrollment consistently increased every year until
            the outbreak of the war, when it reached five hundred sixty-six. Classes were temporarily
            suspended during the war years and resumed on June 4, 1945 after World War II.
          </p>
          <p class="garamond text-ink/70 mt-4">
            Post-World War II saw a big stride in the development of Saint Joseph's Academy. A permit
            to offer a two-year course leading to the title of Elementary Teacher's Certificate was
            obtained from the Bureau of Private Schools. Consequently, the school name changed from
            Saint Joseph's Academy to Saint Joseph's Junior College in July 1950.
          </p>
          <p class="garamond text-ink/70 mt-4">
            The early fifties witnessed the beginning of college courses in Music, Education, and
            Liberal Arts. Accordingly, the façade of the school got a new look with the signboard
            Saint Joseph's College in July 1957, and later College of the Holy Spirit in July 1965.
          </p>
          <p class="garamond text-ink/70 mt-4">
            In 1974, the college department was phased out. Thus, in the next school year, the name
            of the school was changed to Holy Spirit School.
          </p>
        </div>

      </div>

      <!-- Sidebar (2 cols) -->
      <div class="lg:col-span-2 space-y-0 border border-ink/10 reveal d2">

        <div class="p-7 border-b border-ink/10">
          <span class="open-quote" style="color:var(--royal);">"</span>
          <blockquote class="garamond italic text-ink/70 text-base leading-relaxed -mt-4">
            The school celebrated its Golden Jubilee in October 1976 and its Diamond Jubilee
            in July 2001.
          </blockquote>
        </div>

        <div class="p-7 border-b border-ink/10">
          <span class="kicker block mb-3" style="color:var(--spirit);">2005–2006</span>
          <p class="garamond text-ink/65" style="font-size:.98rem;">
            Holy Spirit School fully bloomed in its gender advocacy in the province of Bohol.
            In 2007–2008, the HSS WINGS structure and program was elevated to the province level.
          </p>
        </div>

        <div class="p-7 border-b border-ink/10" style="background:var(--paper-dark,#f0ece3);">
          <span class="kicker block mb-3" style="color:var(--royal);">January 2015</span>
          <p class="garamond text-ink/65" style="font-size:.98rem;">
            HSST underwent its first survey visit as an Integrated Basic Education Program —
            more than two and a half years after challenges involving ownership and damage
            from the October 2013 earthquake.
          </p>
        </div>

        <div class="p-7">
          <span class="kicker block mb-3" style="color:var(--teal);">2016–Present</span>
          <p class="garamond text-ink/65" style="font-size:.98rem;">
            The school transferred fully to its new three-hectare site at J.A. Clarin, Purok 3,
            Dao District, Tagbilaran City — and opened the new Senior High School offering ABM,
            GAS, and STEM tracks.
          </p>
        </div>

      </div>

    </div>

    <!-- Continued narrative -->
    <div class="mt-14 reveal">
      <hr class="col-rule mb-8"/>
      <div class="two-col">
        <p class="garamond text-ink/70">
          In July 2013, the school name changed from Holy Spirit School to Holy Spirit School of
          Tagbilaran (HSST), Inc. Holy Spirit School of Tagbilaran, with separate Grade School and
          High School, underwent its first survey visit as an Integrated Basic Education Program
          in January 2015.
        </p>
        <p class="garamond text-ink/70 mt-4">
          As part of its continuing mission to provide a conducive atmosphere for meaningful teaching
          and learning, Holy Spirit School of Tagbilaran acquired a new three-hectare site located
          at J.A. Clarin, Purok 3, Dao District, Tagbilaran City. The Nursery, Kindergarten 1,
          Kindergarten 2, and Grade School Department transferred to the new school site on
          January 11, 2016.
        </p>
        <p class="garamond text-ink/70 mt-4">
          During school year 2016–2017, the whole school population was fully transferred to the new
          school location with the completion of two school buildings. In the same school year, the
          new Senior High School as part of the basic education program was opened. The Academic Track
          offered Accountancy, Business and Management (ABM), General Academic Strand (GAS), and
          Science, Technology, Engineering, and Mathematics (STEM).
        </p>
        <p class="garamond text-ink/70 mt-4">
          In February 2018, the Junior and Senior High School building was completed, and the transfer
          of learners to the high school building took place in the first week of March 2018.
        </p>
      </div>
    </div>

  </div>
</section>

<!-- ════════════════════════════════════════
     TIMELINE — NEWSPAPER COLUMN
════════════════════════════════════════ -->
<section class="py-20 sm:py-28" style="background:var(--paper-dark,#f0ece3);">
  <div class="max-w-5xl mx-auto px-6">

    <div class="mb-12 reveal">
      <hr class="col-rule-thick mb-3"/>
      <div class="flex items-center justify-between">
        <span class="kicker text-spirit">Record</span>
        <span class="caption-text text-ink/30">From 1926 to Present</span>
      </div>
      <h2 class="display text-ink mt-2" style="font-size:clamp(2rem,3.5vw,3rem);">
        Timeline of <em style="color:var(--spirit);">Institutional Names.</em>
      </h2>
      <hr class="col-rule mt-3"/>
    </div>

    <div class="relative pl-8 timeline-track space-y-0">

      @php
        $entries = [
          ['year'=>'1926',      'name'=>'Saint Joseph\'s Academy (S.J.A.)',                  'note'=>'Grade School (1926) · High School (1928)',               'color'=>'var(--royal)',   'img'=>'SJA.jpeg'],
          ['year'=>'July 1950', 'name'=>'Saint Joseph\'s Junior College (S.J.J.C.)',          'note'=>'Two-year Elementary Teacher\'s Certificate program',      'color'=>'var(--royal)',   'img'=>'SJJC.jpeg'],
          ['year'=>'July 1957', 'name'=>'Saint Joseph\'s College (S.J.C.)',                   'note'=>'College courses in Music, Education, and Liberal Arts',   'color'=>'var(--spirit)',  'img'=>null],
          ['year'=>'July 1965', 'name'=>'College of the Holy Spirit (C.H.S.)',                'note'=>'Name reflects the SSpS congregation\'s mission',          'color'=>'var(--spirit)',  'img'=>null],
          ['year'=>'July 1974', 'name'=>'Holy Spirit School (H.S.S.)',                        'note'=>'College department phased out; return to basic education', 'color'=>'var(--teal)',    'img'=>'HSS1974.jpeg'],
          ['year'=>'July 2013', 'name'=>'Holy Spirit School of Tagbilaran (H.S.S.T.) Inc.',   'note'=>'Current name; full Basic Education program',              'color'=>'var(--crimson)', 'img'=>'HSST.jpeg'],
        ];
      @endphp

      @foreach($entries as $i => $entry)
      <div class="relative pb-10 reveal {{ $i > 0 ? 'd'.min($i,4) : '' }}">
        <!-- Dot -->
        <div class="absolute -left-[1.6rem] top-1.5 w-3.5 h-3.5 rounded-full border-2 border-paper"
             style="background:{{ $entry['color'] }};"></div>

        <div class="border border-ink/8 ed-card overflow-hidden" style="background:var(--paper);">
          <div class="flex flex-col sm:flex-row">

            {{-- Text content --}}
            <div class="flex-1 p-7">
              <span class="kicker" style="color:{{ $entry['color'] }};">{{ $entry['year'] }}</span>
              <h3 class="display text-ink font-bold mt-2 mb-2" style="font-size:1.45rem;line-height:1.2;">
                {{ $entry['name'] }}
              </h3>
              <hr class="col-rule my-4"/>
              <p class="caption-text text-ink/40" style="letter-spacing:.08em;text-transform:none;font-size:.72rem;">
                {{ $entry['note'] }}
              </p>
            </div>

            {{-- Image --}}
            @if($entry['img'])
              <div class="sm:w-48 sm:shrink-0 h-48 sm:h-auto overflow-hidden">
                <img
                  src="{{ asset('images/oldname/' . $entry['img']) }}"
                  alt="{{ $entry['name'] }}"
                  class="w-full h-full object-cover"
                >
              </div>
            @endif

          </div>
        </div>
      </div>
      @endforeach

    </div>

  </div>
</section>

<!-- ════════════════════════════════════════
     CTA — CRUSADERS FOREVER
════════════════════════════════════════ -->
<section class="py-24 sm:py-32 text-center" style="background:var(--ink);">
  <div class="max-w-3xl mx-auto px-6">

    <div class="mb-8 reveal">
      <div class="flex items-center justify-center gap-4 mb-6">
        <div class="h-px flex-1 max-w-24" style="background:rgba(250,248,244,.12);"></div>
        <span class="caption-text font-bold" style="color:var(--spirit);letter-spacing:.3em;font-size:.62rem;">ONCE A CRUSADER</span>
        <div class="h-px flex-1 max-w-24" style="background:rgba(250,248,244,.12);"></div>
      </div>
      <h2 class="display text-paper font-bold reveal" style="font-size:clamp(2.2rem,5vw,4rem);">
        Always a <em style="color:var(--spirit);">Crusader.</em>
      </h2>
    </div>

    <p class="garamond mb-10 reveal d1" style="color:rgba(250,248,244,.5);max-width:36rem;margin-left:auto;margin-right:auto;">
      Thank you for being part of the continuing story of Holy Spirit School of Tagbilaran.
      Your heritage lives on in every learner who walks through these halls.
    </p>

    <div class="flex flex-wrap gap-4 justify-center reveal d2">
      <a href="{{ route('home') }}"
         class="caption-text font-bold bg-paper text-ink px-10 py-4 hover:opacity-90 transition-opacity">
        Back to Home
      </a>
      @if (Route::has('register'))
        <a href="{{ route('register') }}"
           class="caption-text font-bold border border-paper/25 text-paper/70 px-10 py-4 hover:border-paper/60 hover:text-paper transition-all">
          Join the Community
        </a>
      @endif
    </div>

    <p class="caption-text mt-12 reveal d3" style="color:rgba(250,248,244,.15);letter-spacing:.25em;font-size:.62rem;">
      IN VERITATE ET CARITATE · TRUTH AND LOVE · 1926–2026
    </p>

  </div>
</section>

<!-- ════════════════════════════════════════
     FOOTER — MASTHEAD COLOPHON
════════════════════════════════════════ -->
<footer id="contact" class="bg-ink pt-16 pb-8">
  <div class="max-w-7xl mx-auto px-6">

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

    <div class="grid md:grid-cols-4 gap-10 pb-12 border-b border-paper/8">

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

      <div>
        <p class="caption-text font-bold text-paper/40 mb-5" style="letter-spacing:.2em;">Quick Links</p>
        <ul class="space-y-3">
          <li><a href="{{ route('home') }}" class="caption-text text-paper/25 hover:text-paper/70 transition-colors" style="letter-spacing:.08em;text-transform:none;font-size:.8rem;">Home</a></li>
          <li><a href="{{ route('history') }}" class="caption-text text-paper/60 hover:text-paper/70 transition-colors" style="letter-spacing:.08em;text-transform:none;font-size:.8rem;">History</a></li>
          <li><a href="{{ route('events.index') }}" class="caption-text text-paper/25 hover:text-paper/70 transition-colors" style="letter-spacing:.08em;text-transform:none;font-size:.8rem;">Events</a></li>
          <li><a href="{{ route('home') }}#crusade" class="caption-text text-paper/25 hover:text-paper/70 transition-colors" style="letter-spacing:.08em;text-transform:none;font-size:.8rem;">CRUSADE Donation</a></li>
          <li><a href="{{ route('home') }}#contact" class="caption-text text-paper/25 hover:text-paper/70 transition-colors" style="letter-spacing:.08em;text-transform:none;font-size:.8rem;">Contact</a></li>
        </ul>
      </div>

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
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
            </svg>
            <span class="caption-text text-paper/25" style="letter-spacing:.04em;text-transform:none;font-size:.75rem;">J.A. Clarin, Purok 3, Dao District, Tagbilaran City, Bohol 6300</span>
          </li>
        </ul>
      </div>

    </div>

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

<!-- ════════════════════════════════════════
     JAVASCRIPT
════════════════════════════════════════ -->
<script>
  // ── Progress Bar ─────────────────────────
  window.addEventListener('scroll', () => {
    const pct = (window.scrollY / (document.body.scrollHeight - window.innerHeight)) * 100;
    document.getElementById('pgbar').style.width = pct + '%';
  });

  // ── Mobile Menu ──────────────────────────
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

  mobileMenuBtn?.addEventListener('click', () => {
    mobileMenu.classList.contains('hidden') ? openMobileMenu() : closeMobileMenu();
  });
  closeMobileMenuBtn?.addEventListener('click', closeMobileMenu);
  document.querySelectorAll('.mobile-nav-link').forEach(l => l.addEventListener('click', closeMobileMenu));

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
</script>
</body>
</html>
