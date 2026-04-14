{{-- resources/views/livewire/auth/forgot-password.blade.php --}}
<!doctype html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Forgot Password — HSST Alumni Portal</title>

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

        .ornament-line {
            width: 40px;
            height: 2px;
            background: var(--gold-500);
            border-radius: 2px;
        }

        .gold-divider {
            width: 48px;
            height: 2px;
            background: linear-gradient(90deg, var(--gold-500), transparent);
            border-radius: 2px;
        }

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

        /* Recovery icon ring */
        .recovery-icon-ring {
            width: 64px;
            height: 64px;
            border-radius: 50%;
            background: linear-gradient(135deg, rgba(196,149,42,0.18) 0%, rgba(196,149,42,0.08) 100%);
            border: 2px solid rgba(196,149,42,0.35);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Success status card */
        .status-card {
            background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
            border: 1px solid #86efac;
            border-radius: 14px;
            padding: 1rem 1.25rem;
        }

        /* Steps list */
        .step-item {
            display: flex;
            align-items: flex-start;
            gap: 0.75rem;
        }
        .step-num {
            flex-shrink: 0;
            width: 22px;
            height: 22px;
            border-radius: 50%;
            background: rgba(196,149,42,0.2);
            border: 1px solid rgba(196,149,42,0.4);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.65rem;
            font-weight: 700;
            color: var(--gold-500);
            margin-top: 1px;
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
                    style="font-size: clamp(1.9rem, 3vw, 2.5rem);">
                    We'll help you<br>
                    <em>get back in.</em>
                </h1>

                <p class="mt-5 text-sm leading-7" style="color: rgba(255,255,255,0.72); max-width: 28ch;">
                    Forgotten passwords happen. Enter your email and we'll send you
                    a secure link to reset your access instantly.
                </p>
            </div>

            {{-- How it works --}}
            <div class="space-y-4 mb-8">
                <p class="text-xs font-semibold uppercase tracking-widest" style="color: rgba(255,255,255,0.45);">
                    How it works
                </p>

                <div class="step-item">
                    <div class="step-num">1</div>
                    <div>
                        <p class="text-white text-sm font-semibold leading-tight">Enter your email</p>
                        <p class="text-xs mt-0.5" style="color: rgba(255,255,255,0.6);">The address linked to your alumni account</p>
                    </div>
                </div>

                <div class="step-item">
                    <div class="step-num">2</div>
                    <div>
                        <p class="text-white text-sm font-semibold leading-tight">Check your inbox</p>
                        <p class="text-xs mt-0.5" style="color: rgba(255,255,255,0.6);">A reset link will arrive within minutes</p>
                    </div>
                </div>

                <div class="step-item">
                    <div class="step-num">3</div>
                    <div>
                        <p class="text-white text-sm font-semibold leading-tight">Set a new password</p>
                        <p class="text-xs mt-0.5" style="color: rgba(255,255,255,0.6);">Follow the link and choose a secure password</p>
                    </div>
                </div>

                <div class="step-item">
                    <div class="step-num">4</div>
                    <div>
                        <p class="text-white text-sm font-semibold leading-tight">Sign in as usual</p>
                        <p class="text-xs mt-0.5" style="color: rgba(255,255,255,0.6);">Return to the portal with your new credentials</p>
                    </div>
                </div>
            </div>

            {{-- Security note --}}
            <div class="trust-badge rounded-2xl px-4 py-3.5 mb-auto">
                <div class="flex items-start gap-3">
                    <div class="flex-shrink-0 w-8 h-8 rounded-lg flex items-center justify-center mt-0.5"
                         style="background: rgba(196,149,42,0.18); border: 1px solid rgba(196,149,42,0.3);">
                        <svg class="w-4 h-4" style="color: var(--gold-400);" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-white text-sm font-semibold leading-tight">Secure Reset</p>
                        <p class="text-xs mt-1 leading-5" style="color: rgba(255,255,255,0.6);">
                            Reset links expire after 60 minutes and can only be used once for your protection.
                        </p>
                    </div>
                </div>
            </div>

            {{-- Footer --}}
            <div class="mt-6 pt-5" style="border-top: 1px solid rgba(255,255,255,0.1);">
                <div class="gold-divider mb-3"></div>
                <p class="text-xs leading-5 italic" style="color: rgba(255,255,255,0.55);">
                    <span class="sidebar-quote"></span>Once a Holy Spirit student,
                    always part of the family.
                </p>
            </div>

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
                {{-- Back to login --}}
                <a
                    href="{{ route('login') }}"
                    wire:navigate
                    class="inline-flex items-center gap-1.5 text-sm font-semibold text-white/80 hover:text-white transition"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 18l-6-6 6-6"/>
                    </svg>
                    Back to Sign In
                </a>

                {{-- School identity --}}
                <div class="flex items-center gap-3">
                    <div class="h-9 w-9 rounded-xl overflow-hidden border shadow-sm"
                         style="border-color: rgba(196,149,42,0.45);">
                        <img src="{{ asset('images/hsstlogo.jpg') }}" alt="HSST Logo" class="h-full w-full object-contain bg-white">
                    </div>
                    <div>
                        <p class="text-white text-xs font-bold leading-tight">Holy Spirit School</p>
                        <p class="text-xs font-medium" style="color: var(--gold-400);">Alumni Portal</p>
                    </div>
                </div>
            </div>

            {{-- Mobile welcome strip --}}
            <div class="px-5 pt-2 pb-6">
                <p class="font-display text-white text-2xl leading-tight">
                    <em>Recover</em> your account.
                </p>
                <p class="text-xs mt-1" style="color: rgba(255,255,255,0.65);">
                    We'll send a reset link to your email address.
                </p>
            </div>
        </div>

        {{-- ---- Scrollable form panel ------------------------------------ --}}
        <div class="flex-1 flex items-center justify-center px-5 py-10 md:py-0 md:px-10 lg:px-16 xl:px-20">
            <div class="w-full max-w-md">

                {{-- Desktop eyebrow --}}
                <div class="hidden md:flex items-center gap-2 mb-5">
                    <div class="h-px flex-1" style="background: linear-gradient(90deg, var(--gold-500), transparent);"></div>
                    <span class="text-xs font-semibold uppercase tracking-widest px-2" style="color: var(--gold-500);">Account Recovery</span>
                    <div class="h-px flex-1" style="background: linear-gradient(90deg, transparent, var(--gold-500));"></div>
                </div>

                {{-- Desktop heading --}}
                <div class="hidden md:block mb-8">
                    <h2 class="font-display text-slate-900 leading-tight tracking-[-0.02em]"
                        style="font-size: clamp(2rem, 3.5vw, 2.8rem);">
                        Forgot your<br><em>password?</em>
                    </h2>
                    <p class="mt-3 text-sm text-slate-500 leading-6">
                        No problem. Enter the email tied to your alumni account and
                        we'll send a secure reset link.
                    </p>
                </div>

                {{-- Recovery icon (mobile) --}}
                <div class="md:hidden flex justify-center mb-6">
                    <div class="recovery-icon-ring">
                        <svg class="w-7 h-7" style="color: var(--gold-500);" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/>
                        </svg>
                    </div>
                </div>

                {{-- ---- Session status (success message) ---------------- --}}
                @if (session('status'))
                <div class="status-card mb-6 flex items-start gap-3">
                    <div class="flex-shrink-0 w-8 h-8 rounded-full bg-emerald-100 flex items-center justify-center mt-0.5">
                        <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-emerald-800 leading-tight">Email sent</p>
                        <p class="text-xs text-emerald-700 mt-0.5 leading-5">{{ session('status') }}</p>
                    </div>
                </div>
                @endif

                {{-- ---- Form --------------------------------------------- --}}
                <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
                    @csrf

                    {{-- Email --}}
                    <div>
                        <label for="email" class="block text-sm font-semibold text-slate-700 mb-1.5">
                            Email Address
                        </label>
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
                                autofocus
                                autocomplete="email"
                                value="{{ old('email') }}"
                                placeholder="your@email.com"
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

                    {{-- Info hint --}}
                    <div class="flex items-start gap-2 px-3.5 py-3 rounded-xl"
                         style="background: rgba(26,63,168,0.05); border: 1px solid rgba(26,63,168,0.1);">
                        <svg class="w-4 h-4 flex-shrink-0 mt-0.5" style="color: var(--royal-600);" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z"/>
                        </svg>
                        <p class="text-xs leading-5" style="color: var(--royal-700);">
                            Use the email address registered to your alumni account. Can't remember it?
                            Contact your coordinator for assistance.
                        </p>
                    </div>

                    {{-- Submit --}}
                    <button
                        id="reset-btn"
                        type="submit"
                        class="btn-royal w-full flex items-center justify-center gap-2 py-3.5 px-6 rounded-xl text-white text-sm font-bold tracking-wide"
                        data-test="email-password-reset-link-button"
                    >
                        <span id="reset-btn-default" class="flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5"/>
                            </svg>
                            Send Reset Link
                        </span>
                        <span id="reset-btn-loading" class="hidden items-center gap-2">
                            <svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>
                            </svg>
                            Sending…
                        </span>
                    </button>
                </form>

                <script>
                    document.querySelector('form').addEventListener('submit', function () {
                        var btn = document.getElementById('reset-btn');
                        btn.disabled = true;
                        btn.style.opacity = '0.75';
                        btn.style.cursor = 'not-allowed';
                        document.getElementById('reset-btn-default').classList.add('hidden');
                        var loading = document.getElementById('reset-btn-loading');
                        loading.classList.remove('hidden');
                        loading.classList.add('flex');
                    });
                </script>

                {{-- ---- Back to login ------------------------------------ --}}
                <div class="mt-6 text-center">
                    <a
                        href="{{ route('login') }}"
                        wire:navigate
                        class="inline-flex items-center gap-1.5 text-sm font-semibold transition hover:underline"
                        style="color: var(--royal-600);"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 18l-6-6 6-6"/>
                        </svg>
                        Back to Sign In
                    </a>
                </div>

                {{-- ---- Support card ------------------------------------ --}}
                <div class="mt-10 rounded-2xl px-5 py-4"
                     style="background: rgba(196,149,42,0.06); border: 1px solid rgba(196,149,42,0.18);">
                    <div class="flex items-start gap-3">
                        <div class="flex-shrink-0 w-8 h-8 rounded-xl flex items-center justify-center"
                             style="background: rgba(196,149,42,0.15); border: 1px solid rgba(196,149,42,0.25);">
                            <svg class="w-4 h-4" style="color: var(--gold-500);" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9 5.25h.008v.008H12v-.008z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-semibold" style="color: var(--royal-800);">Need more help?</p>
                            <p class="text-xs mt-0.5 leading-5 text-slate-500">
                                If you don't receive an email or can't access your registered address,
                                reach out to your batch coordinator or HSST admin.
                            </p>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        {{-- ---- Footer -------------------------------------------------- --}}
        <div class="flex-shrink-0 px-5 py-4 md:px-10 lg:px-16 xl:px-20 hidden md:flex items-center justify-between"
             style="border-top: 1px solid #e5e9f2;">
            <p class="text-xs text-slate-400">
                &copy; {{ date('Y') }} Holy Spirit School of Tagbilaran Alumni Portal
            </p>
            <p class="text-xs text-slate-400">
                Reset links expire after 60 minutes
            </p>
        </div>

    </main>

</div>

</body>
</html>
