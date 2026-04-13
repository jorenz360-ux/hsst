{{-- resources/views/livewire/auth/login.blade.php --}}
<!doctype html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Sign In — HSST Alumni Portal</title>

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;0,9..40,700;1,9..40,400&family=DM+Serif+Display:ital@0;1&display=swap"
        rel="stylesheet"
    />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --royal-900: #0a1f5c;
            --royal-800: #0f2a7a;
            --royal-700: #153591;
            --royal-600: #1a3fa8;
            --royal-500: #2150c8;
            --gold-500:  #c4952a;
            --gold-400:  #d4a843;
            --gold-200:  #f0dfa8;
            --gold-100:  #faf3de;
        }

        body {
            font-family: "DM Sans", system-ui, sans-serif;
        }
        .font-display {
            font-family: "DM Serif Display", Georgia, serif;
        }

        /* Gold shimmer on the submit button */
        .btn-royal {
            background: linear-gradient(135deg, var(--royal-600) 0%, var(--royal-800) 100%);
            box-shadow: 0 4px 20px rgba(21, 53, 145, 0.35), inset 0 1px 0 rgba(255,255,255,0.12);
            transition: box-shadow 0.2s ease, transform 0.1s ease, filter 0.2s ease;
        }
        .btn-royal:hover {
            filter: brightness(1.07);
            box-shadow: 0 8px 28px rgba(21, 53, 145, 0.42), inset 0 1px 0 rgba(255,255,255,0.14);
        }
        .btn-royal:active {
            transform: translateY(1px);
            box-shadow: 0 2px 10px rgba(21, 53, 145, 0.3);
        }

        /* Input focus state — royal blue ring with faint gold tint */
        .field-input:focus {
            outline: none;
            border-color: var(--royal-600);
            background: #ffffff;
            box-shadow: 0 0 0 3px rgba(26, 63, 168, 0.12);
        }
        .field-input:hover:not(:focus) {
            border-color: #94a3b8;
            background: #ffffff;
        }
        .field-input.is-error {
            border-color: #ef4444;
            box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1);
        }

        /* Sidebar ornament lines */
        .ornament-line {
            width: 40px;
            height: 2px;
            background: var(--gold-500);
            border-radius: 2px;
        }

        /* Gold divider */
        .gold-divider {
            width: 48px;
            height: 2px;
            background: linear-gradient(90deg, var(--gold-500), transparent);
            border-radius: 2px;
        }

        /* Trust badge */
        .trust-badge {
            background: rgba(255,255,255,0.08);
            border: 1px solid rgba(255,255,255,0.14);
            backdrop-filter: blur(4px);
        }

        /* Quote marks */
        .sidebar-quote::before {
            content: '\201C';
            font-family: "DM Serif Display", Georgia, serif;
            font-size: 4rem;
            line-height: 0;
            color: var(--gold-500);
            opacity: 0.5;
            vertical-align: -1.6rem;
            margin-right: 0.15rem;
        }

        /* Checkbox custom */
        input[type="checkbox"]:checked {
            background-color: var(--royal-600);
            border-color: var(--royal-600);
        }

        /* Subtle page texture */
        .page-bg {
            background-color: #f0f4fb;
            background-image:
                radial-gradient(circle at 80% 10%, rgba(26,63,168,0.07) 0%, transparent 45%),
                radial-gradient(circle at 10% 90%, rgba(196,149,42,0.05) 0%, transparent 40%);
        }

        /* Smooth password toggle */
        .pw-toggle {
            transition: color 0.15s ease;
        }
    </style>
</head>
<body class="h-full antialiased page-bg">

<div class="min-h-screen flex flex-col md:flex-row">

    {{-- ================================================================== --}}
    {{-- SIDEBAR — Desktop only                                              --}}
    {{-- ================================================================== --}}
    <aside class="hidden md:flex md:flex-col md:w-[340px] lg:w-[400px] xl:w-[440px] flex-shrink-0 relative overflow-hidden"
           style="background: linear-gradient(160deg, var(--royal-700) 0%, var(--royal-900) 100%);">

        {{-- Background texture overlays --}}
        <div class="absolute inset-0 pointer-events-none">
            <div class="absolute top-0 right-0 w-64 h-64 rounded-full opacity-10"
                 style="background: radial-gradient(circle, rgba(255,255,255,0.3) 0%, transparent 70%); transform: translate(30%, -30%);"></div>
            <div class="absolute bottom-0 left-0 w-80 h-80 rounded-full opacity-8"
                 style="background: radial-gradient(circle, rgba(196,149,42,0.25) 0%, transparent 70%); transform: translate(-40%, 40%);"></div>
            <div class="absolute inset-0 opacity-[0.03]"
                 style="background-image: repeating-linear-gradient(45deg, #fff 0, #fff 1px, transparent 0, transparent 50%); background-size: 14px 14px;"></div>
        </div>

        <div class="relative flex h-full flex-col px-8 py-9 lg:px-10">

            {{-- School Identity --}}
            <div class="flex items-center gap-4 mb-10">
                <div class="h-14 w-14 flex-shrink-0 rounded-2xl overflow-hidden border-2 shadow-lg"
                     style="border-color: rgba(196,149,42,0.5); box-shadow: 0 4px 16px rgba(0,0,0,0.3);">
                    <img
                        src="{{ asset('images/hsstlogo.jpg') }}"
                        alt="HSST Logo"
                        class="h-full w-full object-contain bg-white"
                    >
                </div>
                <div>
                    <p class="text-white font-bold text-sm leading-snug">
                        Holy Spirit School<br>of Tagbilaran
                    </p>
                    <p class="text-xs mt-0.5 font-medium" style="color: var(--gold-400);">
                        Alumni Portal
                    </p>
                </div>
            </div>

            {{-- Main Headline --}}
            <div class="mb-8">
                <div class="ornament-line mb-5"></div>

                <h1 class="font-display text-white leading-tight tracking-[-0.02em]"
                    style="font-size: clamp(2rem, 3vw, 2.6rem);">
                    Your alma mater<br>
                    <em>remembers you.</em>
                </h1>

                <p class="mt-5 text-sm leading-7" style="color: rgba(255,255,255,0.72); max-width: 28ch;">
                    Sign in to access your alumni account, stay connected with your
                    batch, and be part of the HSST reunion legacy.
                </p>
            </div>

            {{-- Trust Indicators --}}
            <div class="space-y-3 mb-8">
                <div class="trust-badge rounded-2xl px-4 py-3 flex items-center gap-3">
                    <div class="flex-shrink-0 w-9 h-9 rounded-xl flex items-center justify-center"
                         style="background: rgba(196,149,42,0.18); border: 1px solid rgba(196,149,42,0.3);">
                        <svg class="w-4 h-4" style="color: var(--gold-400);" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.955 11.955 0 003 10c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-white text-sm font-semibold leading-tight">Secure & Private</p>
                        <p class="text-xs mt-0.5" style="color: rgba(255,255,255,0.6);">Your data is protected</p>
                    </div>
                </div>

                <div class="trust-badge rounded-2xl px-4 py-3 flex items-center gap-3">
                    <div class="flex-shrink-0 w-9 h-9 rounded-xl flex items-center justify-center"
                         style="background: rgba(196,149,42,0.18); border: 1px solid rgba(196,149,42,0.3);">
                        <svg class="w-4 h-4" style="color: var(--gold-400);" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-white text-sm font-semibold leading-tight">Alumni Community</p>
                        <p class="text-xs mt-0.5" style="color: rgba(255,255,255,0.6);">Connect with your batch</p>
                    </div>
                </div>

                <div class="trust-badge rounded-2xl px-4 py-3 flex items-center gap-3">
                    <div class="flex-shrink-0 w-9 h-9 rounded-xl flex items-center justify-center"
                         style="background: rgba(196,149,42,0.18); border: 1px solid rgba(196,149,42,0.3);">
                        <svg class="w-4 h-4" style="color: var(--gold-400);" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-white text-sm font-semibold leading-tight">Reunion Events</p>
                        <p class="text-xs mt-0.5" style="color: rgba(255,255,255,0.6);">Register & track gatherings</p>
                    </div>
                </div>
            </div>

            {{-- Legacy Quote --}}
            <div class="mt-auto">
                <div class="gold-divider mb-4"></div>
                <p class="text-sm leading-7 italic" style="color: rgba(255,255,255,0.65);">
                    <span class="sidebar-quote"></span>Once a Holy Spirit student,
                    always part of the family.
                </p>
            </div>

            {{-- Register Footer --}}
            @if (Route::has('register'))
            <div class="mt-6 pt-5" style="border-top: 1px solid rgba(255,255,255,0.1);">
                <p class="text-xs" style="color: rgba(255,255,255,0.55);">New to the portal?</p>
                <a
                    href="{{ route('register') }}"
                    class="inline-flex items-center gap-1.5 mt-1 text-sm font-semibold hover:underline transition"
                    style="color: var(--gold-400);"
                >
                    Create your alumni account
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/>
                    </svg>
                </a>
            </div>
            @endif

        </div>
    </aside>

    {{-- ================================================================== --}}
    {{-- MAIN CONTENT — Form area                                            --}}
    {{-- ================================================================== --}}
    <main class="flex-1 flex flex-col min-h-screen md:min-h-0 bg-white md:bg-transparent">

        {{-- ---- Mobile Header ------------------------------------------- --}}
        <div class="md:hidden flex-shrink-0"
             style="background: linear-gradient(160deg, var(--royal-700) 0%, var(--royal-900) 100%);">
            <div class="px-5 py-4 flex items-center justify-between">
                {{-- Back button --}}
                <button
                    type="button"
                    onclick="history.back()"
                    class="inline-flex items-center gap-1.5 text-sm font-semibold text-white/80 hover:text-white transition"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 18l-6-6 6-6"/>
                    </svg>
                    Back
                </button>

                {{-- School identity --}}
                <div class="flex items-center gap-3">
                    <div class="h-9 w-9 rounded-xl overflow-hidden border shadow-sm"
                         style="border-color: rgba(196,149,42,0.45);">
                        <img src="{{ asset('images/hsstlogo.jpg') }}" alt="HSST Logo" class="h-full w-full object-contain bg-white">
                    </div>
                    <div class="text-right">
                        <p class="text-white font-bold text-sm leading-tight">HSST</p>
                        <p class="text-xs font-medium" style="color: var(--gold-400);">Alumni Portal</p>
                    </div>
                </div>
            </div>

            {{-- Mobile welcome strip --}}
            <div class="px-5 pb-6 pt-2">
                <h2 class="font-display text-white text-2xl leading-tight">
                    Welcome back, alumna/<wbr>alumnus.
                </h2>
                <p class="mt-1.5 text-sm" style="color: rgba(255,255,255,0.65);">
                    Sign in to access your alumni account.
                </p>
            </div>
        </div>

        {{-- ---- Form Container ------------------------------------------ --}}
        <div class="flex flex-1 items-center justify-center px-5 py-8 sm:px-8 md:px-14 lg:px-20 xl:px-28">
            <div class="w-full max-w-[440px]">

                {{-- Desktop heading (hidden on mobile — shown in mobile header) --}}
                <div class="hidden md:block mb-8">
                    <p class="text-xs font-bold uppercase tracking-[0.15em] mb-3" style="color: var(--gold-500);">
                        Alumni Portal
                    </p>
                    <h2 class="font-display text-slate-900 leading-tight tracking-[-0.02em]"
                        style="font-size: clamp(1.9rem, 3vw, 2.4rem);">
                        Welcome back.
                    </h2>
                    <p class="mt-2.5 text-sm leading-6 text-slate-500">
                        Enter your credentials to access your account.
                    </p>
                </div>

                {{-- Status Message --}}
                @if (session('status'))
                    <div class="mb-5 rounded-2xl border px-4 py-3 text-sm leading-6"
                         style="border-color: #a7f3d0; background: #ecfdf5; color: #065f46;">
                        {{ session('status') }}
                    </div>
                @endif

                {{-- ---- Login Form --------------------------------------- --}}
                <form method="POST" action="{{ route('login.store') }}" novalidate>
                    @csrf

                    <div class="space-y-5">

                        {{-- Username --}}
                        <div>
                            <label for="username"
                                   class="block text-xs font-bold uppercase tracking-[0.1em] mb-2"
                                   style="color: #475569;">
                                Username
                            </label>
                            <div class="relative">
                                <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4"
                                      style="color: #94a3b8;">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/>
                                    </svg>
                                </span>
                                <input
                                    id="username"
                                    name="username"
                                    type="text"
                                    value="{{ old('username') }}"
                                    required
                                    autofocus
                                    autocomplete="username"
                                    placeholder="Enter your username"
                                    class="field-input {{ $errors->has('username') ? 'is-error' : '' }} w-full h-13 rounded-2xl border bg-slate-50 pl-11 pr-4 text-sm text-slate-900 transition placeholder:text-slate-400"
                                    style="height: 3.25rem; border-color: {{ $errors->has('username') ? '#ef4444' : '#e2e8f0' }};"
                                >
                            </div>
                            @error('username')
                                <p class="mt-2 text-xs leading-5 text-red-600 flex items-center gap-1.5">
                                    <svg class="w-3.5 h-3.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- Password --}}
                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <label for="password"
                                       class="block text-xs font-bold uppercase tracking-[0.1em]"
                                       style="color: #475569;">
                                    Password
                                </label>
                                @if (Route::has('password.request'))
                                    <a
                                        href="{{ route('password.request') }}"
                                        class="text-xs font-semibold transition hover:underline"
                                        style="color: var(--royal-600);"
                                    >
                                        Forgot password?
                                    </a>
                                @endif
                            </div>

                            <div class="relative">
                                <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4"
                                      style="color: #94a3b8;">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/>
                                    </svg>
                                </span>
                                <input
                                    id="password"
                                    name="password"
                                    type="password"
                                    required
                                    autocomplete="current-password"
                                    placeholder="Enter your password"
                                    class="field-input {{ $errors->has('password') ? 'is-error' : '' }} w-full rounded-2xl border bg-slate-50 pl-11 pr-12 text-sm text-slate-900 transition placeholder:text-slate-400"
                                    style="height: 3.25rem; border-color: {{ $errors->has('password') ? '#ef4444' : '#e2e8f0' }};"
                                >
                                {{-- Show / hide toggle --}}
                                <button
                                    type="button"
                                    id="togglePassword"
                                    aria-label="Toggle password visibility"
                                    class="pw-toggle absolute inset-y-0 right-0 flex items-center pr-4 text-slate-400 hover:text-slate-600"
                                >
                                    {{-- Eye open --}}
                                    <svg id="iconEyeOpen" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                    {{-- Eye closed --}}
                                    <svg id="iconEyeClosed" class="w-4 h-4 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88"/>
                                    </svg>
                                </button>
                            </div>

                            @error('password')
                                <p class="mt-2 text-xs leading-5 text-red-600 flex items-center gap-1.5">
                                    <svg class="w-3.5 h-3.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- Remember me --}}
                        <div class="flex items-center">
                            <label for="remember" class="inline-flex cursor-pointer items-center gap-3 select-none">
                                <input
                                    id="remember"
                                    name="remember"
                                    type="checkbox"
                                    {{ old('remember') ? 'checked' : '' }}
                                    class="h-4 w-4 rounded border-slate-300 transition"
                                    style="accent-color: var(--royal-600);"
                                >
                                <span class="text-sm text-slate-600">Keep me signed in</span>
                            </label>
                        </div>

                        {{-- Submit --}}
                        <button
                            type="submit"
                            data-test="login-button"
                            class="btn-royal w-full inline-flex items-center justify-center gap-2 rounded-2xl text-sm font-bold text-white"
                            style="height: 3.25rem; color: white;"
                        >
                            <svg class="w-4 h-4 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75"/>
                            </svg>
                            Sign in to Portal
                        </button>

                    </div>
                </form>

                {{-- ---- Support Section ---------------------------------- --}}
                <div class="mt-8 rounded-2xl px-5 py-4"
                     style="background: #f8faff; border: 1px solid #e2e8f0;">
                    <p class="text-xs font-bold uppercase tracking-[0.1em] mb-2" style="color: var(--royal-600);">
                        Need help signing in?
                    </p>
                    <p class="text-sm leading-6 text-slate-500">
                        If you forgot your credentials or need access, please contact
                        your batch representative or
                        <a href="mailto:support@hsst.edu.ph"
                           class="font-semibold hover:underline transition"
                           style="color: var(--royal-600);">
                            reach out to the admin team.
                        </a>
                    </p>
                </div>

                {{-- Mobile register link --}}
                @if (Route::has('register'))
                <p class="mt-6 text-center text-sm text-slate-500 md:hidden">
                    Not yet registered?
                    <a href="{{ route('register') }}" class="font-bold hover:underline" style="color: var(--royal-600);">
                        Create your account
                    </a>
                </p>
                @endif

            </div>
        </div>

        {{-- ---- Footer -------------------------------------------------- --}}
        <div class="flex-shrink-0 px-5 py-4 text-center md:text-left md:px-14 lg:px-20 xl:px-28"
             style="border-top: 1px solid #e2e8f0;">
            <p class="text-xs text-slate-400">
                &copy; {{ date('Y') }} Holy Spirit School of Tagbilaran &mdash; Alumni Portal.
                All rights reserved.
            </p>
        </div>

    </main>

</div>

{{-- Password toggle script --}}
<script>
(function () {
    var btn   = document.getElementById('togglePassword');
    var input = document.getElementById('password');
    var open  = document.getElementById('iconEyeOpen');
    var closed = document.getElementById('iconEyeClosed');

    if (!btn || !input) return;

    btn.addEventListener('click', function () {
        var isPassword = input.type === 'password';
        input.type = isPassword ? 'text' : 'password';
        open.classList.toggle('hidden', isPassword);
        closed.classList.toggle('hidden', !isPassword);
    });
})();
</script>

</body>
</html>
