<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>HSSTian Alumni Association - Holy Spirit School of Tagbilaran</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Libre+Baskerville:ital,wght@0,400;0,700;1,400&family=Nunito:wght@300;400;500;600;700;800&display=swap" rel="stylesheet"/>

  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            royal:  { DEFAULT:'#1a3fc4', dark:'#0f2580', deeper:'#091852', light:'#2952d9', pale:'#94b0f8', frost:'#e8eeff' },
            spirit: { DEFAULT:'#c4960a', light:'#e8b80f' },
          },
          fontFamily: {
            serif: ['"Libre Baskerville"','Georgia','serif'],
            sans:  ['"Nunito"','sans-serif'],
          },
          keyframes: {
            fadeUp:   { from:{ opacity:0, transform:'translateY(32px)' }, to:{ opacity:1, transform:'translateY(0)' } },
            fadeIn:   { from:{ opacity:0 }, to:{ opacity:1 } },
            floatUp:  { '0%,100%':{ transform:'translateY(0)' }, '50%':{ transform:'translateY(-10px)' } },
            shimmer:  { from:{ backgroundPosition:'-600px 0' }, to:{ backgroundPosition:'600px 0' } },
            glow:     { '0%,100%':{ opacity:.1 }, '50%':{ opacity:.22 } },
            ticker:   { from:{ transform:'translateX(0)' }, to:{ transform:'translateX(-50%)' } },
            countUp:  { from:{ opacity:0, transform:'scale(.85)' }, to:{ opacity:1, transform:'scale(1)' } },
            pulse3:   { '0%,100%':{ transform:'scale(1)', opacity:.6 }, '50%':{ transform:'scale(1.08)', opacity:1 } },
          },
          animation: {
            'fade-up':    'fadeUp .85s cubic-bezier(.22,1,.36,1) both',
            'fade-in':    'fadeIn 1s ease both',
            'float':      'floatUp 4s ease-in-out infinite',
            'glow':       'glow 5s ease-in-out infinite',
            'ticker':     'ticker 30s linear infinite',
            'count-up':   'countUp .7s cubic-bezier(.22,1,.36,1) both',
            'pulse-ring': 'pulse3 2.5s ease-in-out infinite',
          }
        }
      }
    }
  </script>

  <style>
    :root{
      --royal:#1a3fc4; --royal-dark:#0f2580; --royal-deeper:#091852;
      --spirit:#c4960a; --white:#fff; --frost:#e8eeff;
    }
    *,*::before,*::after{box-sizing:border-box;margin:0;padding:0;}
    html{scroll-behavior:smooth;}
    body{font-family:'Nunito',sans-serif;background:#fff;color:#091852;overflow-x:hidden;}

    /* SCROLLBAR */
    ::-webkit-scrollbar{width:5px;}
    ::-webkit-scrollbar-track{background:#e8eeff;}
    ::-webkit-scrollbar-thumb{background:var(--royal);border-radius:10px;}

    /* PROGRESS */
    #pgbar{position:fixed;top:0;left:0;height:3px;background:linear-gradient(90deg,#1a3fc4,#94b0f8,#c4960a);z-index:9999;width:0;transition:width .12s linear;}

    /* REVEAL */
    .reveal{opacity:0;transform:translateY(28px);transition:opacity .75s cubic-bezier(.22,1,.36,1),transform .75s cubic-bezier(.22,1,.36,1);}
    .reveal.on{opacity:1;transform:none;}
    .d1{transition-delay:.1s;}.d2{transition-delay:.2s;}.d3{transition-delay:.3s;}.d4{transition-delay:.4s;}.d5{transition-delay:.5s;}

    /* NAV */
    #nav{transition:background .4s,box-shadow .4s;}
    #nav.scrolled{background:rgba(255,255,255,.97);box-shadow:0 2px 24px rgba(26,63,196,.1);}

    /* HERO */
    .hero-bg{background:linear-gradient(150deg,#091852 0%,#0f2580 40%,#1a3fc4 80%,#2952d9 100%);}
    .wave-clip{clip-path:polygon(0 0,100% 0,100% 88%,55% 100%,0 94%);}

    /* GRAIN */
    .grain{position:relative;}
    .grain::after{content:'';position:absolute;inset:0;background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='250' height='250'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='250' height='250' filter='url(%23n)' opacity='.03'/%3E%3C/svg%3E");pointer-events:none;z-index:1;}

    /* CARDS */
    .card{transition:transform .3s cubic-bezier(.22,1,.36,1),box-shadow .3s;border-radius:1.25rem;}
    .card:hover{transform:translateY(-6px);box-shadow:0 24px 56px rgba(26,63,196,.14);}

    /* DONATION PROGRESS */
    .progress-track{background:#dce6fd;border-radius:999px;overflow:hidden;height:12px;}
    .progress-fill{height:100%;border-radius:999px;background:linear-gradient(90deg,#1a3fc4,#94b0f8);animation:shimmer 2.5s linear infinite;background-size:600px 100%;}

    /* CRUSADE PILLARS */
    .pillar{border-left:3px solid var(--royal);padding-left:1rem;}

    /* EYEBROW */
    .eyebrow{font-size:.7rem;font-weight:700;letter-spacing:.22em;text-transform:uppercase;}

    /* TICKER */
    .ticker-wrap{overflow:hidden;white-space:nowrap;}
    .ticker-inner{display:inline-block;animation:ticker 30s linear infinite;}
    .ticker-inner:hover{animation-play-state:paused;}

    /* GOLD ACCENT */
    .gold-line{width:48px;height:3px;background:linear-gradient(90deg,var(--spirit),var(--spirit-light,#e8b80f));border-radius:2px;}

    /* DONATE BUTTON PULSE */
    .donate-btn{position:relative;}
    .donate-btn::before{content:'';position:absolute;inset:-4px;border-radius:9999px;border:2px solid rgba(26,63,196,.3);animation:pulse3 2.5s ease-in-out infinite;}

    /* CROSS symbol */
    .cross{display:inline-flex;align-items:center;justify-content:center;}

    /* QUOTE marks */
    .open-quote{font-size:5rem;line-height:.7;font-family:'Libre Baskerville',serif;color:var(--royal);opacity:.18;display:block;}
  </style>
</head>
<body class="antialiased">

<!-- SCROLL PROGRESS -->
<div id="pgbar"></div>

<!-- ═══════ NAV ═══════ -->
<header id="nav" class="fixed inset-x-0 top-0 z-50 py-4">
  <div class="max-w-6xl mx-auto px-6 flex items-center justify-between">

    <!-- Logo -->
    <a href="#" class="flex items-center gap-3 group">
      <div class="w-10 h-10 rounded-full flex items-center justify-center shadow-lg" style="background:linear-gradient(135deg,#091852,#1a3fc4);">
        <img 
            src="{{ asset('images/hsstlogo.jpg') }}" 
            alt="HSST Logo" 
            class="h-8 md:h-10 w-auto object-contain"
        />
      </div>
      <div class="leading-tight">
        <p class="font-serif text-white font-bold text-sm group-[.scrolled]:text-royal-deeper transition-colors" id="logo-text">HSSTian</p>
        <p class="text-white/50 text-[.58rem] font-sans font-700 tracking-[.15em] uppercase group-[.scrolled]:text-royal/50" id="logo-sub">Alumni Association</p>
      </div>
    </a>

    <!-- Nav links -->
    <nav class="hidden md:flex items-center gap-8 text-xs font-bold tracking-wide text-white/70" id="nav-links">
      <a href="#about"    class="hover:text-white transition-colors uppercase tracking-widest">About</a>
      <a href="#events"   class="hover:text-white transition-colors uppercase tracking-widest">Events</a>
      <a href="#crusade"  class="hover:text-white transition-colors uppercase tracking-widest">CRUSADE</a>
      <a href="#stories"  class="hover:text-white transition-colors uppercase tracking-widest">Stories</a>
      <a href="#news"     class="hover:text-white transition-colors uppercase tracking-widest">News</a>
      <a href="#contact"  class="hover:text-white transition-colors uppercase tracking-widest">Contact</a>
    </nav>

    <a href="#crusade" class="hidden md:inline-flex donate-btn items-center gap-2 bg-spirit text-white font-bold text-xs px-6 py-2.5 rounded-full hover:bg-spirit-light transition-colors shadow-lg">
      ✦ Donate Now
    </a>
  </div>
</header>

<!-- ═══════ HERO ═══════ -->
<section class="relative grain hero-bg wave-clip min-h-screen flex items-center pt-24 pb-40 overflow-hidden">

  <!-- Glowing orbs -->
  <div class="absolute top-16 right-0 w-[480px] h-[480px] rounded-full opacity-10 animate-glow pointer-events-none" style="background:radial-gradient(circle,#2952d9,transparent 70%);"></div>
  <div class="absolute -bottom-20 -left-16 w-96 h-96 rounded-full opacity-10 animate-glow pointer-events-none" style="animation-delay:2s;background:radial-gradient(circle,#94b0f8,transparent 70%);"></div>

  <!-- Decorative cross pattern -->
  <div class="absolute right-12 top-1/2 -translate-y-1/2 hidden xl:flex flex-col items-center gap-0 opacity-5 pointer-events-none animate-float" style="animation-delay:.5s;">
    <div class="w-px h-32 bg-white"></div>
    <div class="w-32 h-px bg-white -mt-px"></div>
    <div class="w-px h-32 bg-white -mt-px"></div>
  </div>

  <!-- Crest circle -->
  <div class="absolute right-20 top-1/2 -translate-y-1/2 hidden xl:block pointer-events-none opacity-8">
    <svg width="360" height="360" viewBox="0 0 360 360" fill="none" xmlns="http://www.w3.org/2000/svg">
      <circle cx="180" cy="180" r="170" stroke="white" stroke-width="1" stroke-dasharray="6 10" opacity=".12"/>
      <circle cx="180" cy="180" r="130" stroke="white" stroke-width=".8" opacity=".08"/>
      <text x="180" y="190" text-anchor="middle" font-size="36" font-family="serif" fill="white" opacity=".06" font-weight="bold">HSS</text>
    </svg>
  </div>

  <div class="relative z-10 max-w-6xl mx-auto px-6">
    <div class="max-w-3xl">

      <!-- Eyebrow -->
      <div class="flex items-center gap-3 mb-6 animate-fade-up" style="animation-delay:.1s;">
        <div class="w-8 h-px bg-spirit"></div>
        <span class="eyebrow text-spirit">Holy Spirit School of Tagbilaran · Est. 1926</span>
      </div>

      <!-- Headline -->
      <h1 class="font-serif text-white mb-6 animate-fade-up leading-[1.05]" style="font-size:clamp(3.2rem,7vw,6rem);animation-delay:.2s;">
        Once a<br/>
        <em class="text-royal-pale italic">Crusader,</em><br/>
        Always a<br/>
        Crusader.
      </h1>

      <p class="text-white/60 font-sans text-base leading-relaxed max-w-xl mb-10 animate-fade-up" style="animation-delay:.32s;">
        Welcome home, HSSTian. Join thousands of alumni united by faith, service, and the spirit of the Holy Cross - and help shape the next 100 years of Holy Spirit School.
      </p>

      <!-- CTAs -->
      <div class="flex flex-wrap gap-4 mb-14 animate-fade-up" style="animation-delay:.42s;">
        <a href="#crusade" class="group relative overflow-hidden bg-spirit hover:bg-spirit-light text-white font-bold text-sm px-8 py-3.5 rounded-full flex items-center gap-2 shadow-xl transition-all duration-300">
          <span>Join the CRUSADE</span>
          <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        </a>
        <a href="#about" class="text-white/70 hover:text-white border border-white/25 hover:border-white/50 font-semibold text-sm px-8 py-3.5 rounded-full transition-all duration-300">
          Learn More
        </a>
      </div>

      <!-- Social proof -->
      <div class="flex flex-wrap gap-8 animate-fade-up" style="animation-delay:.52s;">
        <div>
          <p class="font-serif text-3xl font-bold text-white">100<span class="text-spirit">+</span></p>
          <p class="text-white/40 text-xs font-sans mt-0.5 uppercase tracking-wider">Years of Excellence</p>
        </div>
        <div class="w-px bg-white/10 self-stretch"></div>
        <div>
          <p class="font-serif text-3xl font-bold text-white">100K<span class="text-spirit">+</span></p>
          <p class="text-white/40 text-xs font-sans mt-0.5 uppercase tracking-wider">Living Alumni</p>
        </div>
        <div class="w-px bg-white/10 self-stretch"></div>
        <div>
          <p class="font-serif text-3xl font-bold text-white">3</p>
          <p class="text-white/40 text-xs font-sans mt-0.5 uppercase tracking-wider">CRUSADE Pillars</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ═══════ TICKER ═══════ -->
<div class="bg-royal py-3 ticker-wrap overflow-hidden">
  <div class="ticker-inner text-white/60 text-xs font-sans font-semibold tracking-widest uppercase">
    <span class="mx-8">HSSTian Alumni Centennial Celebration</span>
    <span class="mx-3 text-spirit">✦</span>
    <span class="mx-8">CRUSADE Campaign - Target: PhP 100,000 per Batch</span>
    <span class="mx-3 text-spirit">✦</span>
    <span class="mx-8">Crusaders Athletic Fund Now Open</span>
    <span class="mx-3 text-spirit">✦</span>
    <span class="mx-8">Every Gift Leaves a Lasting Impact</span>
    <span class="mx-3 text-spirit">✦</span>
    <span class="mx-8">Faculty Development Fund - Donate Today</span>
    <span class="mx-3 text-spirit">✦</span>
    <span class="mx-8">Elevating Campus Experience for Future Crusaders</span>
    <span class="mx-3 text-spirit">✦</span>
    <!-- duplicate -->
    <span class="mx-8">HSSTian Alumni Centennial Celebration</span>
    <span class="mx-3 text-spirit">✦</span>
    <span class="mx-8">CRUSADE Campaign - Target: PhP 100,000 per Batch</span>
    <span class="mx-3 text-spirit">✦</span>
    <span class="mx-8">Crusaders Athletic Fund Now Open</span>
    <span class="mx-3 text-spirit">✦</span>
    <span class="mx-8">Every Gift Leaves a Lasting Impact</span>
    <span class="mx-3 text-spirit">✦</span>
    <span class="mx-8">Faculty Development Fund - Donate Today</span>
    <span class="mx-3 text-spirit">✦</span>
    <span class="mx-8">Elevating Campus Experience for Future Crusaders</span>
    <span class="mx-3 text-spirit">✦</span>
  </div>
</div>

<!-- ═══════ ABOUT ═══════ -->
<section id="about" class="py-28 bg-white">
  <div class="max-w-6xl mx-auto px-6">
    <div class="grid lg:grid-cols-2 gap-20 items-center">

      <!-- Left visual -->
      <div class="reveal relative">
        <!-- Main card -->
        <div class="rounded-3xl overflow-hidden shadow-2xl" style="background:linear-gradient(145deg,#091852,#1a3fc4);">
          <div class="h-72 flex flex-col items-center justify-center gap-4 p-10 text-center">
            <!-- Cross icon -->
            <div class="relative w-20 h-20 flex items-center justify-center mb-2">
              <div class="absolute w-4 h-20 bg-white/15 rounded-full"></div>
              <div class="absolute w-20 h-4 bg-white/15 rounded-full"></div>
              <div class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center z-10">
                <span class="text-white font-serif font-bold text-sm">HSS</span>
              </div>
            </div>
            <p class="text-white/90 font-serif italic text-xl leading-snug">"In Veritate et Caritate"</p>
            <p class="text-white/40 text-xs font-sans tracking-widest uppercase">In Truth and in Love</p>
          </div>
          <div class="bg-white/5 px-8 py-6 flex justify-between text-center border-t border-white/10">
            <div><p class="font-serif text-2xl font-bold text-white">1926</p><p class="text-white/40 text-xs mt-0.5 font-sans">Founded</p></div>
            <div class="w-px bg-white/10"></div>
            <div><p class="font-serif text-2xl font-bold text-white">Tagbilaran</p><p class="text-white/40 text-xs mt-0.5 font-sans">Bohol, Philippines</p></div>
            <div class="w-px bg-white/10"></div>
            <div><p class="font-serif text-2xl font-bold text-white">100<span class="text-spirit">yrs</span></p><p class="text-white/40 text-xs mt-0.5 font-sans">Centennial</p></div>
          </div>
        </div>

        <!-- Floating badge -->
        <div class="absolute -bottom-6 -right-6 bg-spirit rounded-2xl p-5 shadow-xl animate-float">
          <p class="text-white font-serif font-bold text-2xl">100K+</p>
          <p class="text-white/80 text-xs font-sans mt-0.5">Living Alumni</p>
        </div>
      </div>

      <!-- Right text -->
      <div>
        <span class="eyebrow text-royal reveal">About the Association</span>
        <div class="gold-line my-4 reveal d1"></div>
        <h2 class="font-serif text-royal-deeper reveal d1" style="font-size:clamp(2rem,3.5vw,2.8rem);line-height:1.15;">
          Rooted in Faith.<br/>
          Driven by Service.<br/>
          <em class="text-royal">United as One.</em>
        </h2>
        <p class="text-royal-deeper/60 font-sans text-sm leading-relaxed mt-5 mb-4 reveal d2">
          The HSSTian Alumni Association is the official organization of graduates of Holy Spirit School of Tagbilaran - the Crusaders. For generations, we have carried the school's mission of truth, love, and excellence far beyond the campus gates.
        </p>
        <p class="text-royal-deeper/60 font-sans text-sm leading-relaxed mb-8 reveal d2">
          As we approach our Centennial, we are called once again to give back - to the school that shaped our character, deepened our faith, and ignited our purpose. The HSSTian Alumni Association is the bridge between the legacy of the past and the promise of the future.
        </p>
        <div class="flex flex-wrap gap-3 reveal d3">
          <span class="bg-royal-frost text-royal text-xs font-bold px-4 py-2 rounded-full border border-royal/10">Faith-Based Community</span>
          <span class="bg-royal-frost text-royal text-xs font-bold px-4 py-2 rounded-full border border-royal/10">Scholarship Programs</span>
          <span class="bg-royal-frost text-royal text-xs font-bold px-4 py-2 rounded-full border border-royal/10">Athletic Excellence</span>
          <span class="bg-royal-frost text-royal text-xs font-bold px-4 py-2 rounded-full border border-royal/10">Campus Development</span>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ═══════ CRUSADE DONATION ═══════ -->
<section id="crusade" class="py-32 relative overflow-hidden">
  <div class="absolute inset-0" style="background:linear-gradient(160deg,#091852 0%,#0f2580 50%,#1a3fc4 100%);"></div>
  <!-- Decorative -->
  <div class="absolute top-0 left-0 w-full h-full opacity-5 pointer-events-none" style="background-image:radial-gradient(circle at 20% 30%,white 1px,transparent 1px),radial-gradient(circle at 80% 70%,white 1px,transparent 1px);background-size:48px 48px;"></div>
  <div class="absolute right-0 top-1/2 -translate-y-1/2 w-96 h-96 rounded-full opacity-10 animate-glow pointer-events-none" style="background:radial-gradient(circle,#94b0f8,transparent 70%);"></div>

  <div class="relative z-10 max-w-6xl mx-auto px-6">

    <!-- Section header -->
    <div class="text-center mb-16">
      <span class="eyebrow text-spirit reveal">Centennial Giving Campaign</span>
      <div class="flex justify-center my-4 reveal d1"><div class="gold-line"></div></div>
      <h2 class="font-serif text-white reveal d1" style="font-size:clamp(2.5rem,5vw,4rem);line-height:1.1;">
        Join the <em class="text-spirit">CRUSADE.</em>
      </h2>
      <p class="text-white/50 font-sans text-base max-w-2xl mx-auto mt-4 leading-relaxed reveal d2">
        Be generous. Join us in shaping a brighter future for our students and community, where every gift - regardless of size - leaves a lasting impact.
      </p>
    </div>

    <!-- Hero donation card -->
    <div class="bg-white/8 border border-white/12 rounded-3xl p-8 md:p-12 mb-10 reveal d2 backdrop-blur-sm">
      <div class="grid md:grid-cols-2 gap-10 items-center">
        <div>
          <p class="text-spirit eyebrow mb-3">Your Legacy Gift</p>
          <h3 class="font-serif text-white text-2xl md:text-3xl leading-snug mb-4">
            Your generosity can leave an <em>enduring legacy.</em>
          </h3>
          <p class="text-white/55 font-sans text-sm leading-relaxed mb-6">
            Although <strong class="text-spirit font-bold">PhP 100,000 per batch</strong> is recommended, every gift - no matter the amount - is invaluable and will be cherished deeply.
          </p>
          <p class="text-white/55 font-sans text-sm leading-relaxed mb-8">
            Your support will fuel our Centennial Celebrations, enhancing campus life, expanding financial aid, and driving academic and athletic excellence.
          </p>

          <!-- Progress bar -->
          <div class="mb-2 flex justify-between items-center">
            <span class="text-white/50 text-xs font-sans font-semibold">Campaign Progress</span>
            <span class="text-spirit text-xs font-bold font-sans">62% funded</span>
          </div>
          <div class="progress-track mb-3">
            <div class="progress-fill" style="width:62%;background:linear-gradient(90deg,#1a3fc4,#94b0f8);"></div>
          </div>
          <div class="flex justify-between text-xs font-sans text-white/35">
            <span>₱2,320,000 raised</span>
            <span>Goal: ₱3,750,000</span>
          </div>
        </div>

        <!-- Donate form panel -->
        <div class="bg-white rounded-2xl p-8 shadow-2xl">
          <p class="font-serif text-royal-deeper font-bold text-lg mb-1">Make Your Gift Today</p>
          <p class="text-royal/50 text-xs font-sans mb-6">Choose an amount or enter your own</p>

          <!-- Amount selector -->
          <div class="grid grid-cols-3 gap-2 mb-4" id="amount-grid">
            <button onclick="selectAmt(this,'500')"   class="amt-btn bg-royal-frost border border-royal/15 text-royal font-bold text-sm py-2.5 rounded-xl hover:bg-royal hover:text-white transition-all">₱500</button>
            <button onclick="selectAmt(this,'1000')"  class="amt-btn bg-royal-frost border border-royal/15 text-royal font-bold text-sm py-2.5 rounded-xl hover:bg-royal hover:text-white transition-all">₱1,000</button>
            <button onclick="selectAmt(this,'5000')"  class="amt-btn bg-royal-frost border border-royal/15 text-royal font-bold text-sm py-2.5 rounded-xl hover:bg-royal hover:text-white transition-all">₱5,000</button>
            <button onclick="selectAmt(this,'10000')" class="amt-btn bg-royal-frost border border-royal/15 text-royal font-bold text-sm py-2.5 rounded-xl hover:bg-royal hover:text-white transition-all">₱10,000</button>
            <button onclick="selectAmt(this,'50000')" class="amt-btn bg-royal-frost border border-royal/15 text-royal font-bold text-sm py-2.5 rounded-xl hover:bg-royal hover:text-white transition-all">₱50,000</button>
            <button onclick="selectAmt(this,'100000')" class="amt-btn bg-spirit text-white font-bold text-xs py-2.5 rounded-xl hover:bg-spirit-light transition-all border border-spirit">₱100,000 ✦</button>
          </div>

          <!-- Custom amount -->
          <div class="mb-4">
            <label class="text-royal/60 text-xs font-sans font-semibold block mb-1.5">Or enter custom amount (PhP)</label>
            <div class="flex items-center border-2 border-royal/15 focus-within:border-royal rounded-xl overflow-hidden transition-colors">
              <span class="px-3 text-royal/50 font-bold font-sans text-sm">₱</span>
              <input id="custom-amt" type="number" placeholder="Enter amount" class="flex-1 py-2.5 pr-4 text-sm font-sans font-semibold text-royal-deeper outline-none" oninput="clearSelected()"/>
            </div>
          </div>

          <!-- Name -->
          <div class="mb-4">
            <label class="text-royal/60 text-xs font-sans font-semibold block mb-1.5">Full Name</label>
            <input type="text" placeholder="Juan dela Cruz" class="w-full border-2 border-royal/15 focus:border-royal rounded-xl px-4 py-2.5 text-sm font-sans text-royal-deeper outline-none transition-colors"/>
          </div>

          <!-- Batch year -->
          <div class="mb-6">
            <label class="text-royal/60 text-xs font-sans font-semibold block mb-1.5">Batch Year</label>
            <input type="text" placeholder="e.g. 1998, 2005, 2012" class="w-full border-2 border-royal/15 focus:border-royal rounded-xl px-4 py-2.5 text-sm font-sans text-royal-deeper outline-none transition-colors"/>
          </div>

          <button class="donate-btn w-full bg-royal hover:bg-royal-dark text-white font-bold text-sm py-3.5 rounded-xl transition-all duration-300 hover:shadow-xl hover:shadow-royal/30 flex items-center justify-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
            Give Now - Fueled by Compassion
          </button>
          <p class="text-center text-royal/30 text-xs font-sans mt-3">All donations are acknowledged & deeply cherished 🙏</p>
        </div>
      </div>
    </div>

    <!-- 3 Pillars -->
    <div class="text-center mb-8 reveal">
      <p class="text-white/40 eyebrow">CRUSADE focuses on three key areas</p>
    </div>
    <div class="grid md:grid-cols-3 gap-5">

      <div class="card reveal d1 bg-white/8 border border-white/12 p-8 backdrop-blur-sm hover:bg-white/12 transition-colors">
        <div class="w-12 h-12 rounded-xl bg-spirit/20 flex items-center justify-center mb-5">
          <svg class="w-6 h-6 text-spirit" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
        </div>
        <p class="eyebrow text-spirit mb-2">Pillar One</p>
        <h4 class="font-serif text-white text-xl font-bold mb-3">Elevating Campus Experience</h4>
        <p class="text-white/45 font-sans text-xs leading-relaxed">
          Transformative upgrades to learning spaces, facilities, and technology - ensuring every student thrives in an environment worthy of their potential.
        </p>
      </div>

      <div class="card reveal d2 bg-royal border border-royal-light/40 p-8">
        <div class="w-12 h-12 rounded-xl bg-white/15 flex items-center justify-center mb-5">
          <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
        </div>
        <p class="eyebrow text-white/50 mb-2">Pillar Two</p>
        <h4 class="font-serif text-white text-xl font-bold mb-3">Faculty Development</h4>
        <p class="text-white/60 font-sans text-xs leading-relaxed">
          Investing in the dedicated educators who shape future Crusaders - through training, scholarships, and professional growth programs.
        </p>
      </div>

      <div class="card reveal d3 bg-white/8 border border-white/12 p-8 backdrop-blur-sm hover:bg-white/12 transition-colors">
        <div class="w-12 h-12 rounded-xl bg-spirit/20 flex items-center justify-center mb-5">
          <svg class="w-6 h-6 text-spirit" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/></svg>
        </div>
        <p class="eyebrow text-spirit mb-2">Pillar Three</p>
        <h4 class="font-serif text-white text-xl font-bold mb-3">Crusaders Athletic Fund</h4>
        <p class="text-white/45 font-sans text-xs leading-relaxed">
          Empowering student-athletes to reach new heights - funding equipment, training, and competitions that build character through sportsmanship.
        </p>
      </div>
    </div>
  </div>
</section>

<!-- ═══════ EVENTS ═══════ -->
<section id="events" class="py-28 bg-royal-frost">
  <div class="max-w-6xl mx-auto px-6">

    <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-14">
      <div>
        <span class="eyebrow text-royal reveal">Upcoming</span>
        <div class="gold-line my-3 reveal d1"></div>
        <h2 class="font-serif text-royal-deeper reveal d1" style="font-size:clamp(2rem,3.5vw,2.8rem);line-height:1.15;">Alumni Events</h2>
      </div>
      <a href="#" class="text-royal text-xs font-bold font-sans hover:underline reveal d2 uppercase tracking-widest self-start md:self-auto">View All →</a>
    </div>

    <div class="grid md:grid-cols-3 gap-6">

      <div class="card reveal d1 bg-white border border-royal/10 overflow-hidden group">
        <div class="h-4 bg-spirit"></div>
        <div class="p-7">
          <div class="flex items-start justify-between mb-5">
            <div class="w-14 h-14 rounded-2xl flex flex-col items-center justify-center" style="background:linear-gradient(135deg,#091852,#1a3fc4);">
              <span class="font-serif font-bold text-white text-xl leading-none">12</span>
              <span class="text-white/60 text-[.6rem] font-sans uppercase tracking-wide">Apr</span>
            </div>
            <span class="bg-royal-frost text-royal text-[.65rem] font-bold px-3 py-1 rounded-full border border-royal/15 uppercase tracking-wider">Annual</span>
          </div>
          <h3 class="font-serif text-royal-deeper text-lg font-bold mb-2 group-hover:text-royal transition-colors">Centennial Homecoming Gala</h3>
          <p class="text-royal/50 text-xs font-sans leading-relaxed mb-4">Grand reunion celebration for all Crusader batches. Formal evening, awards night, and Centennial launch.</p>
          <div class="flex items-center gap-2 text-royal/40 text-xs font-sans">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
            Tagbilaran City, Bohol
          </div>
        </div>
      </div>

      <div class="card reveal d2 bg-royal overflow-hidden group">
        <div class="h-4 bg-spirit-light"></div>
        <div class="p-7">
          <div class="flex items-start justify-between mb-5">
            <div class="w-14 h-14 rounded-2xl flex flex-col items-center justify-center bg-white/15">
              <span class="font-serif font-bold text-white text-xl leading-none">03</span>
              <span class="text-white/50 text-[.6rem] font-sans uppercase tracking-wide">May</span>
            </div>
            <span class="bg-spirit text-white text-[.65rem] font-bold px-3 py-1 rounded-full uppercase tracking-wider">Featured</span>
          </div>
          <h3 class="font-serif text-white text-lg font-bold mb-2">CRUSADE Launch Assembly</h3>
          <p class="text-white/50 text-xs font-sans leading-relaxed mb-4">Official launch of the Centennial giving campaign. All batch representatives and alumni leaders invited.</p>
          <div class="flex items-center gap-2 text-white/35 text-xs font-sans">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
            Holy Spirit School Campus
          </div>
        </div>
      </div>

      <div class="card reveal d3 bg-white border border-royal/10 overflow-hidden group">
        <div class="h-4 bg-royal/40"></div>
        <div class="p-7">
          <div class="flex items-start justify-between mb-5">
            <div class="w-14 h-14 rounded-2xl flex flex-col items-center justify-center border-2 border-royal/20">
              <span class="font-serif font-bold text-royal text-xl leading-none">20</span>
              <span class="text-royal/50 text-[.6rem] font-sans uppercase tracking-wide">Jun</span>
            </div>
            <span class="bg-green-50 text-green-700 text-[.65rem] font-bold px-3 py-1 rounded-full uppercase tracking-wider">Virtual</span>
          </div>
          <h3 class="font-serif text-royal-deeper text-lg font-bold mb-2 group-hover:text-royal transition-colors">HSSTian Alumni Town Hall</h3>
          <p class="text-royal/50 text-xs font-sans leading-relaxed mb-4">Online gathering for all alumni. Centennial updates, CRUSADE progress report, and open forum.</p>
          <div class="flex items-center gap-2 text-royal/40 text-xs font-sans">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945"/></svg>
            Online · All Crusaders Welcome
          </div>
        </div>
      </div>

    </div>
  </div>
</section>

<!-- ═══════ ALUMNI STORIES ═══════ -->
<section id="stories" class="py-28 bg-white">
  <div class="max-w-6xl mx-auto px-6">
    <div class="text-center mb-16">
      <span class="eyebrow text-royal reveal">Alumni Voices</span>
      <div class="flex justify-center my-4 reveal d1"><div class="gold-line"></div></div>
      <h2 class="font-serif text-royal-deeper reveal d1" style="font-size:clamp(2rem,3.5vw,2.8rem);line-height:1.15;">
        Crusaders Who<br/><em class="text-royal">Carried the Cross.</em>
      </h2>
    </div>

    <div class="grid md:grid-cols-3 gap-7">

      <div class="card reveal d1 bg-royal-frost border border-royal/10 p-8">
        <span class="open-quote">"</span>
        <blockquote class="font-serif italic text-royal-deeper text-base leading-relaxed mb-6 -mt-4">
          Holy Spirit didn't just teach me lessons. It taught me values. The CRUSADE is our chance to give that same gift to the next generation of Crusaders.
        </blockquote>
        <div class="flex items-center gap-3">
          <div class="w-10 h-10 rounded-full flex items-center justify-center font-sans font-bold text-white text-xs" style="background:linear-gradient(135deg,#0f2580,#1a3fc4);">MC</div>
          <div>
            <p class="font-sans font-bold text-royal-deeper text-sm">Maria Corazon Reyes</p>
            <p class="text-royal/40 text-xs font-sans">Batch 1998 · Educator</p>
          </div>
        </div>
      </div>

      <div class="card reveal d2 bg-royal-deeper p-8">
        <span class="open-quote" style="color:rgba(196,150,10,.3)">"</span>
        <blockquote class="font-serif italic text-white/80 text-base leading-relaxed mb-6 -mt-4">
          Being a Crusader is a lifelong identity. When I heard about the CRUSADE campaign, I didn't hesitate - this school gave me everything. It's our turn to give back.
        </blockquote>
        <div class="flex items-center gap-3">
          <div class="w-10 h-10 rounded-full bg-white/15 flex items-center justify-center font-sans font-bold text-white text-xs">JP</div>
          <div>
            <p class="font-sans font-bold text-white text-sm">Jose Paolo Dizon</p>
            <p class="text-white/35 text-xs font-sans">Batch 2005 · Engineer, Cebu</p>
          </div>
        </div>
      </div>

      <div class="card reveal d3 bg-royal-frost border border-royal/10 p-8">
        <span class="open-quote">"</span>
        <blockquote class="font-serif italic text-royal-deeper text-base leading-relaxed mb-6 -mt-4">
          I grew up in a simple home in Tagbilaran. HSS believed in me before I believed in myself. A PhP 1,000 gift from a hundred alumni changes one child's entire trajectory.
        </blockquote>
        <div class="flex items-center gap-3">
          <div class="w-10 h-10 rounded-full flex items-center justify-center font-sans font-bold text-white text-xs" style="background:linear-gradient(135deg,#1a3fc4,#2952d9);">AL</div>
          <div>
            <p class="font-sans font-bold text-royal-deeper text-sm">Ana Luz Santillan</p>
            <p class="text-royal/40 text-xs font-sans">Batch 2012 · Nurse, Dubai</p>
          </div>
        </div>
      </div>

    </div>
  </div>
</section>

<!-- ═══════ NEWS ═══════ -->
<section id="news" class="py-28 bg-royal-frost">
  <div class="max-w-6xl mx-auto px-6">

    <div class="flex items-end justify-between mb-14">
      <div>
        <span class="eyebrow text-royal reveal">Latest</span>
        <div class="gold-line my-3 reveal d1"></div>
        <h2 class="font-serif text-royal-deeper reveal d1" style="font-size:clamp(2rem,3.5vw,2.8rem);line-height:1.15;">News &amp; Updates</h2>
      </div>
      <a href="#" class="text-royal text-xs font-bold uppercase tracking-widest font-sans hover:underline reveal d2 mb-2">All News →</a>
    </div>

    <div class="grid md:grid-cols-3 gap-6">

      <div class="card reveal d1 bg-white border border-royal/10 overflow-hidden group md:col-span-2">
        <div class="h-48 relative overflow-hidden" style="background:linear-gradient(135deg,#091852,#1a3fc4,#2952d9);">
          <div class="absolute inset-0 flex items-center justify-center opacity-10">
            <p class="font-serif text-white font-black" style="font-size:8rem;">100</p>
          </div>
          <div class="absolute bottom-0 inset-x-0 p-6 flex items-end justify-between">
            <span class="bg-spirit text-white text-[.65rem] font-bold px-3 py-1.5 rounded-full uppercase tracking-wider">Centennial</span>
       <span class="text-white/40 text-xs font-sans">
            {{ now('Asia/Manila')->format('F j, Y') }}
        </span>
          </div>
        </div>
        <div class="p-7">
          <p class="eyebrow text-royal mb-2">Major Milestone · 5 min read</p>
          <h3 class="font-serif text-royal-deeper text-xl font-bold mb-3 group-hover:text-royal transition-colors leading-snug">
            Holy Spirit School of Tagbilaran Marks 100 Years: A Century of Crusaders
          </h3>
          <p class="text-royal/50 font-sans text-sm leading-relaxed">
            From its humble beginnings in 1926 to educating over 10,000 alumni across the globe, HSS celebrates a century of faith, service, and excellence - and looks boldly to the next hundred years.
          </p>
        </div>
      </div>

      <div class="flex flex-col gap-5">
        <div class="card reveal d2 bg-white border border-royal/10 overflow-hidden group flex-1">
          <div class="h-28" style="background:linear-gradient(135deg,#0f2580,#2952d9);"></div>
          <div class="p-5">
            <p class="eyebrow text-royal mb-1">CRUSADE · 3 min read</p>
            <h3 class="font-serif text-royal-deeper text-sm font-bold group-hover:text-royal transition-colors leading-snug">CRUSADE Campaign Surpasses 60% Goal in First Month</h3>
            <p class="text-royal/35 text-xs font-sans mt-2">Feb 20, 2025</p>
          </div>
        </div>
        <div class="card reveal d3 bg-white border border-royal/10 overflow-hidden group flex-1">
          <div class="h-28" style="background:linear-gradient(135deg,#1a3fc4,#94b0f8);"></div>
          <div class="p-5">
            <p class="eyebrow text-royal mb-1">Athletics · 2 min read</p>
            <h3 class="font-serif text-royal-deeper text-sm font-bold group-hover:text-royal transition-colors leading-snug">Crusaders Win Regional Championship - 3rd Year in a Row</h3>
            <p class="text-royal/35 text-xs font-sans mt-2">Jan 15, 2025</p>
          </div>
        </div>
      </div>

    </div>
  </div>
</section>

<!-- ═══════ SECONDARY CTA ═══════ -->
<section class="py-24 relative overflow-hidden" style="background:linear-gradient(150deg,#091852,#1a3fc4);">
  <div class="absolute inset-0 pointer-events-none opacity-5" style="background-image:radial-gradient(circle at 25% 50%,white 1px,transparent 1px);background-size:36px 36px;"></div>
  <div class="max-w-3xl mx-auto px-6 text-center relative z-10">
    <span class="eyebrow text-spirit reveal">Together, We Are Crusaders</span>
    <h2 class="font-serif text-white reveal d1 mt-4 mb-5" style="font-size:clamp(2.4rem,5vw,4rem);line-height:1.1;">
      Together, fueled by<br/><em class="text-spirit">compassion and dedication,</em><br/>we create meaningful change.
    </h2>
    <p class="text-white/50 font-sans text-sm leading-relaxed mb-10 reveal d2 max-w-xl mx-auto">
      No gift is too small. No Crusader is forgotten. Join thousands of alumni who are building the next chapter of Holy Spirit School.
    </p>
    <div class="flex flex-wrap gap-4 justify-center reveal d3">
      <a href="#crusade" class="group relative overflow-hidden bg-spirit hover:bg-spirit-light text-white font-bold text-sm px-10 py-4 rounded-full flex items-center gap-2 shadow-xl transition-all duration-300">
        <span>Donate to CRUSADE</span>
        <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
      </a>
      <a href="#contact" class="text-white/70 hover:text-white border border-white/25 hover:border-white/50 font-semibold text-sm px-10 py-4 rounded-full transition-all duration-300">
        Get in Touch
      </a>
    </div>
  </div>
</section>

<!-- ═══════ FOOTER / CONTACT ═══════ -->
<footer id="contact" class="bg-royal-deeper pt-20 pb-8">
  <div class="max-w-6xl mx-auto px-6">
    <div class="grid md:grid-cols-4 gap-12 pb-16 border-b border-white/8">

      <!-- Brand col -->
      <div class="md:col-span-2">
        <div class="flex items-center gap-3 mb-5">
          <div class="w-10 h-10 rounded-full flex items-center justify-center shadow" style="background:linear-gradient(135deg,#0f2580,#1a3fc4);">
            <span class="text-white font-serif font-bold text-xs">HSS</span>
          </div>
          <div>
            <p class="font-serif text-white font-bold text-base">HSSTian Alumni Association</p>
            <p class="text-white/30 text-[.6rem] font-sans tracking-widest uppercase">Holy Spirit School of Tagbilaran</p>
          </div>
        </div>
        <p class="text-white/35 font-sans text-xs leading-relaxed max-w-xs mb-6">
          United by faith. Driven by service. Forever Crusaders. - Tagbilaran City, Bohol, Philippines.
        </p>
        <p class="text-spirit text-xs font-bold font-sans uppercase tracking-wider mb-2">In Veritate et Caritate</p>
        <p class="text-white/25 text-xs font-sans italic">In Truth and in Love</p>
      </div>

      <div>
        <p class="text-white/50 text-xs font-bold uppercase tracking-widest mb-5 font-sans">Quick Links</p>
        <ul class="space-y-3 text-white/30 text-xs font-sans">
          <li><a href="#about"   class="hover:text-white transition-colors">About Us</a></li>
          <li><a href="#crusade" class="hover:text-white transition-colors">CRUSADE Donation</a></li>
          <li><a href="#events"  class="hover:text-white transition-colors">Events</a></li>
          <li><a href="#stories" class="hover:text-white transition-colors">Alumni Stories</a></li>
          <li><a href="#news"    class="hover:text-white transition-colors">News & Updates</a></li>
        </ul>
      </div>

      <div>
        <p class="text-white/50 text-xs font-bold uppercase tracking-widest mb-5 font-sans">Contact Us</p>
        <ul class="space-y-3 text-white/30 text-xs font-sans leading-relaxed">
          <li class="flex gap-2 items-start">
            <svg class="w-3.5 h-3.5 text-royal-pale mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
            alumni@hss-tagbilaran.edu.ph
          </li>
          <li class="flex gap-2 items-start">
            <svg class="w-3.5 h-3.5 text-royal-pale mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
            +63 38 501 0000
          </li>
          <li class="flex gap-2 items-start">
            <svg class="w-3.5 h-3.5 text-royal-pale mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
            Holy Spirit School, Tagbilaran City, Bohol 6300
          </li>
        </ul>
        <div class="flex gap-2 mt-6">
          <a href="#" class="w-8 h-8 rounded-full border border-white/12 hover:bg-royal hover:border-royal flex items-center justify-center transition-all">
            <svg class="w-3.5 h-3.5 text-white/40" fill="currentColor" viewBox="0 0 24 24"><path d="M18.77 7.46H14.5v-1.9c0-.9.6-1.1 1-1.1h3V.5h-4.33C10.24.5 9.5 3.44 9.5 5.32v2.15h-3v4h3v12h5v-12h3.85l.42-4z"/></svg>
          </a>
          <a href="#" class="w-8 h-8 rounded-full border border-white/12 hover:bg-royal hover:border-royal flex items-center justify-center transition-all">
            <svg class="w-3.5 h-3.5 text-white/40" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
          </a>
        </div>
      </div>
    </div>

    <div class="pt-8 flex flex-col md:flex-row items-center justify-between gap-4 text-white/20 text-xs font-sans">
      <p>© <span class="text-white/40 text-xs font-sans">
    {{ now('Asia/Manila')->format('Y') }}
</span>HSSTian Alumni Association · Holy Spirit School of Tagbilaran. All rights reserved.</p>
      <p class="text-spirit/60 font-bold tracking-widest uppercase text-[.65rem]">Crusaders Forever ✦</p>
    </div>
  </div>
</footer>

<!-- ═══════ SCRIPTS ═══════ -->
<script>
  // Scroll progress
  window.addEventListener('scroll', () => {
    const pct = (scrollY / (document.body.scrollHeight - innerHeight)) * 100;
    document.getElementById('pgbar').style.width = pct + '%';
  });

  // Nav scroll style
  const nav = document.getElementById('nav');
  const logoText = document.getElementById('logo-text');
  const logoSub  = document.getElementById('logo-sub');
  const navLinks = document.getElementById('nav-links');
  window.addEventListener('scroll', () => {
    if (scrollY > 60) {
      nav.classList.add('scrolled');
      logoText.classList.replace('text-white','text-royal-deeper');
      logoSub.classList.replace('text-white/50','text-royal/50');
      navLinks.querySelectorAll('a').forEach(a => {
        a.classList.replace('text-white/70','text-royal-deeper/70');
      });
    } else {
      nav.classList.remove('scrolled');
      logoText.classList.replace('text-royal-deeper','text-white');
      logoSub.classList.replace('text-royal/50','text-white/50');
      navLinks.querySelectorAll('a').forEach(a => {
        a.classList.replace('text-royal-deeper/70','text-white/70');
      });
    }
  });

  // Intersection reveal
  const ro = new IntersectionObserver(entries => {
    entries.forEach(e => { if (e.isIntersecting) { e.target.classList.add('on'); ro.unobserve(e.target); } });
  }, { threshold: 0.1 });
  document.querySelectorAll('.reveal').forEach(el => ro.observe(el));

  // Donation amount selector
  function selectAmt(btn, val) {
    document.querySelectorAll('.amt-btn').forEach(b => {
      b.classList.remove('bg-royal','text-white','border-royal');
      b.classList.add('bg-royal-frost','text-royal','border-royal/15');
    });
    btn.classList.remove('bg-royal-frost','text-royal','border-royal/15');
    btn.classList.add('bg-royal','text-white','border-royal');
    document.getElementById('custom-amt').value = '';
  }
  function clearSelected() {
    document.querySelectorAll('.amt-btn').forEach(b => {
      b.classList.remove('bg-royal','text-white','border-royal');
      b.classList.add('bg-royal-frost','text-royal','border-royal/15');
    });
  }
</script>
</body>
</html>