<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Holy Spirit School of Tagbilaran</title>
  
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    
    tailwind.config = {
      theme: {
        extend: {
          fontFamily: {
            sans: ['Inter', 'ui-sans-serif', 'system-ui', 'sans-serif'],
          },
          boxShadow: {
            premium: '0 20px 60px rgba(0, 0, 0, 0.35)',
            soft: '0 10px 30px rgba(0, 0, 0, 0.25)',
          },
          backgroundImage: {
            'hero-glow-dark': 'radial-gradient(circle at top left, rgba(244,63,94,0.18), transparent 30%), radial-gradient(circle at top right, rgba(245,158,11,0.14), transparent 26%), linear-gradient(180deg, rgb(9 9 11) 0%, rgb(24 24 27) 100%)',
            'cta-glow-dark': 'linear-gradient(135deg, rgba(225,29,72,0.95), rgba(245,158,11,0.92))',
          },
          animation: {
            float: 'float 5s ease-in-out infinite',
          },
          keyframes: {
            float: {
              '0%, 100%': { transform: 'translateY(0px)' },
              '50%': { transform: 'translateY(-6px)' },
            },
          },
        }
      }
    }
  </script>
  <style>
    [x-cloak] { display: none !important; }
    
  </style>
</head>
<body class="bg-zinc-950 text-zinc-100 antialiased selection:bg-rose-500/30 selection:text-rose-100">
  <div x-data="landingPage()" class="min-h-screen">

<!-- Header -->
<header x-data="{ mobileOpen:false }" class="sticky top-0 z-50 border-b border-white/10 bg-zinc-950/85 backdrop-blur-xl">

<div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

<!-- Top Bar -->
<div class="flex items-center justify-between py-4">

<div class="flex items-center gap-4">
<div class="flex h-12 w-12 items-center justify-center overflow-hidden rounded-2xl bg-white p-1 shadow-soft">
    <img
        src="{{ asset('images/hsstlogo.jpg') }}"
        alt="HSSA Logo"
        class="h-full w-full object-contain"
    >
</div>

<div class="leading-tight">
<p class="text-xs font-semibold uppercase tracking-[0.2em] text-zinc-400">
Alumni Association
</p>
<h1 class="text-sm font-bold text-white sm:text-base">
Holy Spirit School of Tagbilaran
</h1>
</div>
</div>

<!-- Desktop Auth -->
<div class="hidden items-center gap-3 lg:flex">
@if (Route::has('login'))
@auth
<a href="{{ url('/dashboard') }}" class="rounded-full bg-zinc-800 px-5 py-2 text-sm font-medium text-zinc-100 hover:bg-rose-500 hover:text-white">
Dashboard
</a>
@else
<a href="{{ route('login') }}" class="rounded-full bg-zinc-800 px-5 py-2 text-sm font-medium text-zinc-100 hover:bg-rose-500 hover:text-white">
Log in
</a>

@if (Route::has('register'))
<a href="{{ route('register') }}" class="rounded-full bg-white px-5 py-2 text-sm font-medium text-zinc-900 hover:bg-rose-500 hover:text-white">
Register
</a>
@endif
@endauth
@endif
</div>

<!-- Hamburger -->
<button @click="mobileOpen=!mobileOpen"
class="inline-flex items-center justify-center rounded-2xl border border-white/10 bg-zinc-900 p-3 text-zinc-200 lg:hidden">

<svg x-show="!mobileOpen" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
d="M4 6h16M4 12h16M4 18h16"/>
</svg>

<svg x-show="mobileOpen" x-cloak class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
d="M6 18L18 6M6 6l12 12"/>
</svg>

</button>

</div>

<!-- Desktop Navigation -->
<div class="hidden border-t border-white/10 lg:flex lg:items-center lg:justify-center">

<nav class="flex items-center gap-2 py-2 text-sm font-medium text-white">

<a href="{{ route('home') }}" class="rounded-xl px-5 py-3 hover:bg-white/5 hover:text-green-200">
Home
</a>

<!-- Who We Are -->
<div class="group relative">
<button class="flex items-center gap-2 rounded-xl px-5 py-3 hover:bg-white/5 hover:text-green-200">
Who We Are
<svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
d="M19 9l-7 7-7-7"/>
</svg>
</button>

<div class="absolute left-0 top-full hidden min-w-[220px] border border-zinc-200 bg-white shadow-xl group-hover:block">
<a href="{{ route('about-us') }}" class="block px-6 py-4 text-[#005b36] hover:bg-zinc-100">
About Us
</a>
<a href="#our-board" class="block px-6 py-4 text-[#005b36] hover:bg-zinc-100">
Our Board
</a>
</div>
</div>

<!-- What We Do -->
<div class="group relative">
<button class="flex items-center gap-2 rounded-xl px-5 py-3 hover:bg-white/5 hover:text-green-200">
What We Do
</button>

<div class="absolute left-0 top-full hidden min-w-[220px] border border-zinc-200 bg-white shadow-xl group-hover:block">
<a href="#reunions" class="block px-6 py-4 text-[#005b36] hover:bg-zinc-100">Reunions</a>
<a href="#hall-of-fame" class="block px-6 py-4 text-[#005b36] hover:bg-zinc-100">Hall of Fame</a>
</div>
</div>

<a href="#news" class="rounded-xl px-5 py-3 hover:bg-white/5 hover:text-green-200">
News & Events
</a>

</nav>
</div>

</div>

<!-- MOBILE MENU -->
<div x-show="mobileOpen" x-transition x-cloak class="border-t border-white/10 bg-zinc-950 lg:hidden">

<div class="mx-auto flex max-w-7xl flex-col gap-1 px-4 py-4 text-sm text-zinc-200">

<a @click="mobileOpen=false" href="{{ route('home') }}" class="rounded-xl px-4 py-3 hover:bg-zinc-900">
Home
</a>

<!-- Who We Are -->
<div x-data="{open:false}">
<button @click="open=!open"
class="flex w-full justify-between rounded-xl px-4 py-3 hover:bg-zinc-900">

Who We Are
<svg :class="{'rotate-180':open}" class="h-4 w-4 transition">
<path stroke="currentColor" stroke-width="2" d="M19 9l-7 7-7-7"/>
</svg>

</button>

<div x-show="open" x-transition class="ml-4 flex flex-col">
<a href="{{ route('about-us') }}" class="px-4 py-2 text-zinc-400 hover:text-white">About Us</a>
<a href="#our-board" class="px-4 py-2 text-zinc-400 hover:text-white">Our Board</a>
</div>
</div>

<!-- What We Do -->
<div x-data="{open:false}">
<button @click="open=!open"
class="flex w-full justify-between rounded-xl px-4 py-3 hover:bg-zinc-900">

What We Do
<svg :class="{'rotate-180':open}" class="h-4 w-4 transition">
<path stroke="currentColor" stroke-width="2" d="M19 9l-7 7-7-7"/>
</svg>

</button>

<div x-show="open" x-transition class="ml-4 flex flex-col">
<a href="#reunions" class="px-4 py-2 text-zinc-400 hover:text-white">Reunions</a>
<a href="#hall-of-fame" class="px-4 py-2 text-zinc-400 hover:text-white">Hall of Fame</a>
</div>
</div>

<a @click="mobileOpen=false" href="#news" class="rounded-xl px-4 py-3 hover:bg-zinc-900">
News & Events
</a>

</div>

</div>

</header>
<livewire:public-announcements />
 
    <!-- Footer -->
    <footer class="border-t border-white/10 bg-zinc-950">
      <div class="mx-auto flex max-w-7xl flex-col gap-3 px-4 py-8 text-sm text-zinc-400 sm:px-6 md:flex-row md:items-center md:justify-between lg:px-8">
        <p>© 2026 Holy Spirit School of Tagbilaran. All rights reserved.</p>
        <p>Built for connection, celebration, and community.</p>
      </div>
    </footer>
  </div>
</body>
</html>