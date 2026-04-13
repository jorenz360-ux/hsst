{{-- resources/views/livewire/auth/reset-password.blade.php --}}
<!doctype html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Reset Password — HSST Alumni Portal</title>

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

        body { font-family: "DM Sans", system-ui, sans-serif; }
        .font-display { font-family: "DM Serif Display", Georgia, serif; }

        .btn-royal {
            background: linear-gradient(135deg, var(--royal-600) 0%, var(--royal-800) 100%);
            box-shadow: 0 4px 20px rgba(21,53,145,0.35), inset 0 1px 0 rgba(255,255,255,0.12);
            transition: box-shadow 0.2s ease, transform 0.1s ease, filter 0.2s ease;
        }
        .btn-royal:hover  { filter: brightness(1.07); box-shadow: 0 8px 28px rgba(21,53,145,0.42), inset 0 1px 0 rgba(255,255,255,0.14); }
        .btn-royal:active { transform: translateY(1px); box-shadow: 0 2px 10px rgba(21,53,145,0.3); }

        .field-input:focus {
            outline: none;
            border-color: var(--royal-600);
            background: #ffffff;
            box-shadow: 0 0 0 3px rgba(26,63,168,0.12);
        }
        .field-input:hover:not(:focus) { border-color: #94a3b8; background: #ffffff; }
        .field-input.is-error { border-color: #ef4444; box-shadow: 0 0 0 3px rgba(239,68,68,0.1); }

        .ornament-line { width: 40px; height: 2px; background: var(--gold-500); border-radius: 2px; }
        .gold-divider  { width: 48px; height: 2px; background: linear-gradient(90deg, var(--gold-500), transparent); border-radius: 2px; }

        .trust-badge {
            background: rgba(255,255,255,0.08);
            border: 1px solid rgba(255,255,255,0.14);
            backdrop-filter: blur(4px);
        }

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

        .page-bg {
            background-color: #f0f4fb;
            background-image:
                radial-gradient(circle at 80% 10%, rgba(26,63,168,0.07) 0%, transparent 45%),
                radial-gradient(circle at 10% 90%, rgba(196,149,42,0.05) 0%, transparent 40%);
        }

        /* Password strength meter */
        .strength-bar-track {
            height: 4px;
            background: #e5e7eb;
            border-radius: 4px;
            overflow: hidden;
        }
        .strength-bar-fill {
            height: 100%;
            border-radius: 4px;
            transition: width 0.3s ease, background 0.3s ease;
        }

        /* pw toggle */
        .pw-toggle { transition: color 0.15s ease; }
    </style>
</head>
<body class="h-full antialiased page-bg">

<div class="min-h-screen flex flex-col md:flex-row">

    {{-- ================================================================== --}}
    {{-- SIDEBAR — Desktop only                                              --}}
    {{-- ================================================================== --}}
    <aside class="hidden md:flex md:flex-col md:w-[340px] lg:w-[400px] xl:w-[440px] flex-shrink-0 relative overflow-hidden"
           style="background: linear-gradient(160deg, var(--royal-700) 0%, var(--royal-900) 100%);">

        <div class="absolute inset-0 pointer-events-none">
            <div class="absolute top-0 right-0 w-64 h-64 rounded-full opacity-10"
                 style="background: radial-gradient(circle, rgba(255,255,255,0.3) 0%, transparent 70%); transform: translate(30%,-30%);"></div>
            <div class="absolute bottom-0 left-0 w-80 h-80 rounded-full opacity-8"
                 style="background: radial-gradient(circle, rgba(196,149,42,0.25) 0%, transparent 70%); transform: translate(-40%,40%);"></div>
            <div class="absolute inset-0 opacity-[0.03]"
                 style="background-image: repeating-linear-gradient(45deg,#fff 0,#fff 1px,transparent 0,transparent 50%); background-size: 14px 14px;"></div>
        </div>

        <div class="relative flex h-full flex-col px-8 py-9 lg:px-10">

            {{-- School Identity --}}
            <div class="flex items-center gap-4 mb-10">
                <div class="h-14 w-14 flex-shrink-0 rounded-2xl overflow-hidden border-2 shadow-lg"
                     style="border-color: rgba(196,149,42,0.5); box-shadow: 0 4px 16px rgba(0,0,0,0.3);">
                    <img src="{{ asset('images/hsstlogo.jpg') }}" alt="HSST Logo"
                         class="h-full w-full object-contain bg-white">
                </div>
                <div>
                    <p class="text-white font-bold text-sm leading-snug">Holy Spirit School<br>of Tagbilaran</p>
                    <p class="text-xs mt-0.5 font-medium" style="color: var(--gold-400);">Alumni Portal</p>
                </div>
            </div>

            {{-- Headline --}}
            <div class="mb-8">
                <div class="ornament-line mb-5"></div>
                <h1 class="font-display text-white leading-tight tracking-[-0.02em]"
                    style="font-size: clamp(1.9rem, 3vw, 2.5rem);">
                    Choose a strong<br>
                    <em>new password.</em>
                </h1>
                <p class="mt-5 text-sm leading-7" style="color: rgba(255,255,255,0.72); max-width: 28ch;">
                    Create a password you'll remember but others can't guess. A mix of
                    letters, numbers, and symbols works best.
                </p>
            </div>

            {{-- Tips --}}
            <div class="space-y-3 mb-8">
                <p class="text-xs font-semibold uppercase tracking-widest" style="color: rgba(255,255,255,0.45);">
                    Password tips
                </p>
                <div class="trust-badge rounded-2xl px-4 py-3 flex items-start gap-3">
                    <div class="flex-shrink-0 w-8 h-8 rounded-xl flex items-center justify-center mt-0.5"
                         style="background: rgba(196,149,42,0.18); border: 1px solid rgba(196,149,42,0.3);">
                        <svg class="w-4 h-4" style="color: var(--gold-400);" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-white text-sm font-semibold leading-tight">At least 8 characters</p>
                        <p class="text-xs mt-0.5" style="color: rgba(255,255,255,0.6);">Longer passwords are harder to crack</p>
                    </div>
                </div>
                <div class="trust-badge rounded-2xl px-4 py-3 flex items-start gap-3">
                    <div class="flex-shrink-0 w-8 h-8 rounded-xl flex items-center justify-center mt-0.5"
                         style="background: rgba(196,149,42,0.18); border: 1px solid rgba(196,149,42,0.3);">
                        <svg class="w-4 h-4" style="color: var(--gold-400);" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-white text-sm font-semibold leading-tight">Mix letters & numbers</p>
                        <p class="text-xs mt-0.5" style="color: rgba(255,255,255,0.6);">Add symbols for extra security</p>
                    </div>
                </div>
                <div class="trust-badge rounded-2xl px-4 py-3 flex items-start gap-3">
                    <div class="flex-shrink-0 w-8 h-8 rounded-xl flex items-center justify-center mt-0.5"
                         style="background: rgba(196,149,42,0.18); border: 1px solid rgba(196,149,42,0.3);">
                        <svg class="w-4 h-4" style="color: var(--gold-400);" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-white text-sm font-semibold leading-tight">Don't reuse passwords</p>
                        <p class="text-xs mt-0.5" style="color: rgba(255,255,255,0.6);">Unique passwords keep your account safe</p>
                    </div>
                </div>
            </div>

            {{-- Quote footer --}}
            <div class="mt-auto">
                <div class="gold-divider mb-4"></div>
                <p class="text-sm leading-7 italic" style="color: rgba(255,255,255,0.65);">
                    <span class="sidebar-quote"></span>Once a Holy Spirit student,
                    always part of the family.
                </p>
            </div>

        </div>
    </aside>

    {{-- ================================================================== --}}
    {{-- MAIN CONTENT                                                        --}}
    {{-- ================================================================== --}}
    <main class="flex-1 flex flex-col min-h-screen md:min-h-0 bg-white md:bg-transparent">

        {{-- Mobile Header --}}
        <div class="md:hidden flex-shrink-0"
             style="background: linear-gradient(160deg, var(--royal-700) 0%, var(--royal-900) 100%);">
            <div class="px-5 py-4 flex items-center justify-between">
                <a href="{{ route('login') }}" wire:navigate
                   class="inline-flex items-center gap-1.5 text-sm font-semibold text-white/80 hover:text-white transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 18l-6-6 6-6"/>
                    </svg>
                    Sign In
                </a>
                <div class="flex items-center gap-3">
                    <div class="h-9 w-9 rounded-xl overflow-hidden border shadow-sm"
                         style="border-color: rgba(196,149,42,0.45);">
                        <img src="{{ asset('images/hsstlogo.jpg') }}" alt="HSST Logo"
                             class="h-full w-full object-contain bg-white">
                    </div>
                    <div>
                        <p class="text-white text-xs font-bold leading-tight">Holy Spirit School</p>
                        <p class="text-xs font-medium" style="color: var(--gold-400);">Alumni Portal</p>
                    </div>
                </div>
            </div>
            <div class="px-5 pt-2 pb-6">
                <p class="font-display text-white text-2xl leading-tight">
                    Set a new <em>password.</em>
                </p>
                <p class="text-xs mt-1" style="color: rgba(255,255,255,0.65);">
                    Choose something strong and memorable.
                </p>
            </div>
        </div>

        {{-- Form panel --}}
        <div class="flex-1 flex items-center justify-center px-5 py-10 md:py-0 md:px-10 lg:px-16 xl:px-20">
            <div class="w-full max-w-md">

                {{-- Desktop eyebrow --}}
                <div class="hidden md:flex items-center gap-2 mb-5">
                    <div class="h-px flex-1" style="background: linear-gradient(90deg, var(--gold-500), transparent);"></div>
                    <span class="text-xs font-semibold uppercase tracking-widest px-2" style="color: var(--gold-500);">Password Reset</span>
                    <div class="h-px flex-1" style="background: linear-gradient(90deg, transparent, var(--gold-500));"></div>
                </div>

                {{-- Desktop heading --}}
                <div class="hidden md:block mb-8">
                    <h2 class="font-display text-slate-900 leading-tight tracking-[-0.02em]"
                        style="font-size: clamp(2rem, 3.5vw, 2.8rem);">
                        Set your new<br><em>password.</em>
                    </h2>
                    <p class="mt-3 text-sm text-slate-500 leading-6">
                        Enter and confirm your new password below to regain access to your alumni account.
                    </p>
                </div>

                {{-- Session status --}}
                @if (session('status'))
                <div class="mb-6 flex items-start gap-3 px-4 py-3.5 rounded-2xl"
                     style="background: linear-gradient(135deg,#f0fdf4,#dcfce7); border: 1px solid #86efac;">
                    <div class="flex-shrink-0 w-8 h-8 rounded-full bg-emerald-100 flex items-center justify-center mt-0.5">
                        <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-emerald-800 leading-tight">Success</p>
                        <p class="text-xs text-emerald-700 mt-0.5 leading-5">{{ session('status') }}</p>
                    </div>
                </div>
                @endif

                {{-- Form --}}
                <form method="POST" action="{{ route('password.update') }}" class="space-y-5" id="resetForm">
                    @csrf
                    {{-- Hidden token --}}
                    <input type="hidden" name="token" value="{{ request()->route('token') }}">

                    {{-- Email --}}
                    <div>
                        <label for="email" class="block text-sm font-semibold text-slate-700 mb-1.5">Email Address</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">
                                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/>
                                </svg>
                            </div>
                            <input
                                id="email"
                                name="email"
                                type="email"
                                required
                                autocomplete="email"
                                value="{{ request('email') }}"
                                class="field-input w-full pl-10 pr-4 py-3 rounded-xl border text-sm transition-all duration-150 {{ $errors->has('email') ? 'is-error' : '' }}"
                                style="border-color: {{ $errors->has('email') ? '#ef4444' : '#d1d5db' }}; background: #f9fafb; color: #0f172a;"
                            >
                        </div>
                        @error('email')
                        <p class="mt-1.5 flex items-center gap-1.5 text-xs font-medium text-red-600">
                            <svg class="w-3.5 h-3.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/>
                            </svg>
                            {{ $message }}
                        </p>
                        @enderror
                    </div>

                    {{-- New Password --}}
                    <div>
                        <label for="password" class="block text-sm font-semibold text-slate-700 mb-1.5">New Password</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">
                                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/>
                                </svg>
                            </div>
                            <input
                                id="password"
                                name="password"
                                type="password"
                                required
                                autocomplete="new-password"
                                placeholder="Minimum 8 characters"
                                oninput="checkStrength(this.value)"
                                class="field-input w-full pl-10 pr-11 py-3 rounded-xl border text-sm transition-all duration-150 {{ $errors->has('password') ? 'is-error' : '' }}"
                                style="border-color: {{ $errors->has('password') ? '#ef4444' : '#d1d5db' }}; background: #f9fafb; color: #0f172a;"
                            >
                            <button
                                type="button"
                                onclick="togglePw('password','eyeIcon1')"
                                class="pw-toggle absolute inset-y-0 right-0 flex items-center pr-3.5 text-slate-400 hover:text-slate-600"
                            >
                                <svg id="eyeIcon1" class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                            </button>
                        </div>

                        {{-- Strength meter --}}
                        <div class="mt-2 space-y-1.5" id="strengthSection" style="display:none;">
                            <div class="strength-bar-track">
                                <div class="strength-bar-fill" id="strengthBar" style="width:0%; background:#e5e7eb;"></div>
                            </div>
                            <p id="strengthLabel" class="text-xs font-medium" style="color: #94a3b8;"></p>
                        </div>

                        @error('password')
                        <p class="mt-1.5 flex items-center gap-1.5 text-xs font-medium text-red-600">
                            <svg class="w-3.5 h-3.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/>
                            </svg>
                            {{ $message }}
                        </p>
                        @enderror
                    </div>

                    {{-- Confirm Password --}}
                    <div>
                        <label for="password_confirmation" class="block text-sm font-semibold text-slate-700 mb-1.5">Confirm New Password</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">
                                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.955 11.955 0 003 10c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z"/>
                                </svg>
                            </div>
                            <input
                                id="password_confirmation"
                                name="password_confirmation"
                                type="password"
                                required
                                autocomplete="new-password"
                                placeholder="Re-enter your new password"
                                oninput="checkMatch()"
                                class="field-input w-full pl-10 pr-11 py-3 rounded-xl border text-sm transition-all duration-150 {{ $errors->has('password_confirmation') ? 'is-error' : '' }}"
                                style="border-color: {{ $errors->has('password_confirmation') ? '#ef4444' : '#d1d5db' }}; background: #f9fafb; color: #0f172a;"
                            >
                            <button
                                type="button"
                                onclick="togglePw('password_confirmation','eyeIcon2')"
                                class="pw-toggle absolute inset-y-0 right-0 flex items-center pr-3.5 text-slate-400 hover:text-slate-600"
                            >
                                <svg id="eyeIcon2" class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                            </button>
                        </div>

                        {{-- Match indicator --}}
                        <p id="matchMsg" class="mt-1.5 hidden text-xs font-medium"></p>

                        @error('password_confirmation')
                        <p class="mt-1.5 flex items-center gap-1.5 text-xs font-medium text-red-600">
                            <svg class="w-3.5 h-3.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/>
                            </svg>
                            {{ $message }}
                        </p>
                        @enderror
                    </div>

                    {{-- Submit --}}
                    <button
                        type="submit"
                        class="btn-royal w-full flex items-center justify-center gap-2 py-3.5 px-6 rounded-xl text-white text-sm font-bold tracking-wide"
                        data-test="reset-password-button"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/>
                        </svg>
                        Reset Password
                    </button>
                </form>

                {{-- Back to login --}}
                <div class="mt-6 text-center">
                    <a href="{{ route('login') }}" wire:navigate
                       class="inline-flex items-center gap-1.5 text-sm font-semibold transition hover:underline"
                       style="color: var(--royal-600);">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 18l-6-6 6-6"/>
                        </svg>
                        Back to Sign In
                    </a>
                </div>

            </div>
        </div>

        {{-- Footer --}}
        <div class="flex-shrink-0 px-5 py-4 md:px-10 lg:px-16 xl:px-20 hidden md:flex items-center justify-between"
             style="border-top: 1px solid #e5e9f2;">
            <p class="text-xs text-slate-400">
                &copy; {{ date('Y') }} Holy Spirit School of Tagbilaran Alumni Portal
            </p>
            <p class="text-xs text-slate-400">
                This link is valid for 60 minutes
            </p>
        </div>

    </main>
</div>

<script>
    function togglePw(fieldId, iconId) {
        const field = document.getElementById(fieldId);
        const icon  = document.getElementById(iconId);
        const isHidden = field.type === 'password';
        field.type = isHidden ? 'text' : 'password';
        icon.innerHTML = isHidden
            ? '<path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88"/>'
            : '<path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>';
    }

    function checkStrength(val) {
        const section = document.getElementById('strengthSection');
        const bar     = document.getElementById('strengthBar');
        const label   = document.getElementById('strengthLabel');
        if (!val) { section.style.display = 'none'; return; }
        section.style.display = 'block';

        let score = 0;
        if (val.length >= 8)  score++;
        if (val.length >= 12) score++;
        if (/[A-Z]/.test(val) && /[a-z]/.test(val)) score++;
        if (/\d/.test(val)) score++;
        if (/[^A-Za-z0-9]/.test(val)) score++;

        const levels = [
            { pct: '15%',  color: '#ef4444', text: 'Very weak' },
            { pct: '30%',  color: '#f97316', text: 'Weak' },
            { pct: '55%',  color: '#eab308', text: 'Fair' },
            { pct: '78%',  color: '#22c55e', text: 'Strong' },
            { pct: '100%', color: '#16a34a', text: 'Very strong' },
        ];
        const lvl = levels[Math.min(score, 4)];
        bar.style.width    = lvl.pct;
        bar.style.background = lvl.color;
        label.textContent  = lvl.text;
        label.style.color  = lvl.color;
    }

    function checkMatch() {
        const pw   = document.getElementById('password').value;
        const conf = document.getElementById('password_confirmation').value;
        const msg  = document.getElementById('matchMsg');
        if (!conf) { msg.classList.add('hidden'); return; }
        msg.classList.remove('hidden');
        if (pw === conf) {
            msg.textContent  = '✓ Passwords match';
            msg.style.color  = '#16a34a';
        } else {
            msg.textContent  = '✗ Passwords do not match';
            msg.style.color  = '#ef4444';
        }
    }
</script>

</body>
</html>
