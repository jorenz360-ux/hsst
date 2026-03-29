{{-- resources/views/auth/login.blade.php --}}
<!doctype html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Sign In - HSST Alumni Portal</title>

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600;700&family=DM+Serif+Display:ital@0;1&display=swap"
        rel="stylesheet"
    />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: "DM Sans", system-ui, sans-serif;
        }

        .font-display {
            font-family: "DM Serif Display", serif;
        }
    </style>
</head>
<body class="h-full bg-slate-100 text-slate-900 antialiased">
    <div class="min-h-screen bg-[radial-gradient(circle_at_top_right,rgba(37,99,235,0.08),transparent_24%),linear-gradient(180deg,#f8fbff_0%,#eef3fb_100%)]">
        <div class="mx-auto min-h-screen max-w-7xl">
            <div class="w-full overflow-hidden sm:rounded-[28px] sm:border sm:border-slate-200/80 sm:bg-white sm:shadow-[0_24px_60px_rgba(15,23,42,0.12)] md:rounded-none md:border-0 md:bg-transparent md:shadow-none">
                <div class="grid min-h-screen grid-cols-1 md:grid-cols-[320px_minmax(0,1fr)] lg:grid-cols-[360px_minmax(0,1fr)]">

                    {{-- Desktop Sidebar --}}
                    <aside class="relative hidden overflow-hidden bg-gradient-to-b from-[#153eaf] to-[#0f2f83] text-white md:flex md:flex-col">
                        <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,rgba(255,255,255,0.14),transparent_24%)]"></div>

                        <div class="relative flex h-full flex-col p-6 lg:p-7">
                            <div class="mb-8 flex items-center gap-3">
                                <div class="flex h-14 w-14 items-center justify-center overflow-hidden rounded-2xl border border-white/20 bg-white/10 shadow-inner backdrop-blur">
                                    <img
                                        src="{{ asset('images/hsstlogo.jpg') }}"
                                        alt="HSST Logo"
                                        class="h-full w-full object-contain bg-white"
                                    >
                                </div>

                                <div>
                                    <p class="text-sm font-bold leading-tight">
                                        Holy Spirit School of Tagbilaran
                                    </p>
                                    <p class="mt-1 text-xs text-white/70">
                                        Alumni Portal
                                    </p>
                                </div>
                            </div>

                            <div class="mb-8">
                                <p class="mb-3 text-[11px] font-bold uppercase tracking-[0.18em] text-white/70">
                                    Welcome back
                                </p>

                                <h1 class="font-display text-4xl leading-none tracking-[-0.03em] text-white">
                                    Sign in to continue.
                                </h1>

                                <p class="mt-4 max-w-xs text-sm leading-7 text-white/80">
                                    Access your alumni account to manage your profile,
                                    view announcements, and stay updated on events and
                                    registrations.
                                </p>
                            </div>

                            <div class="space-y-3">
                                <div class="flex items-center gap-3 rounded-2xl border border-white/20 bg-white/15 px-4 py-3">
                                    <div class="flex h-9 w-9 items-center justify-center rounded-full border border-white/20 bg-white/10 text-sm font-bold">
                                        1
                                    </div>
                                    <div>
                                        <p class="text-sm font-bold text-white">Sign in</p>
                                        <p class="text-xs text-white/70">Username and password</p>
                                    </div>
                                </div>

                                <div class="flex items-center gap-3 rounded-2xl border border-white/15 bg-white/8 px-4 py-3">
                                    <div class="flex h-9 w-9 items-center justify-center rounded-full border border-white/20 bg-white/10 text-sm font-bold">
                                        2
                                    </div>
                                    <div>
                                        <p class="text-sm font-bold text-white">Access portal</p>
                                        <p class="text-xs text-white/70">Secure alumni account entry</p>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-auto border-t border-white/15 pt-5 text-sm leading-6 text-white/75">
                                <p>Don’t have an account yet?</p>
                                @if (Route::has('register'))
                                    <a
                                        href="{{ route('register') }}"
                                        class="mt-1 inline-block font-semibold text-white hover:underline"
                                    >
                                        Create your alumni account
                                    </a>
                                @endif
                            </div>
                        </div>
                    </aside>

                    {{-- Main --}}
                    <main class="flex min-h-screen flex-col bg-gradient-to-b from-white to-slate-50 md:min-h-0">

                        {{-- Mobile Header --}}
                      {{-- Mobile Header --}}
<div class="border-b border-white/10 bg-gradient-to-b from-[#153eaf] to-[#0f2f83] md:hidden">
    <div class="flex items-center justify-between px-4 py-4">
        <button
            type="button"
            onclick="history.back()"
            class="inline-flex items-center gap-2 rounded-xl border border-white/20 bg-white/10 px-3 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-white/15"
        >
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 18l-6-6 6-6" />
            </svg>
            Back
        </button>

        <div class="flex items-center gap-3">
            <div class="flex h-10 w-10 items-center justify-center overflow-hidden rounded-xl border border-white/20 bg-white/10 shadow-sm backdrop-blur">
                <img
                    src="{{ asset('images/hsstlogo.jpg') }}"
                    alt="HSST Logo"
                    class="h-full w-full object-contain bg-white"
                >
            </div>

            <div class="text-right">
                <p class="text-[10px] font-bold uppercase tracking-[0.16em] text-white/75">
                    Alumni Portal
                </p>
                <p class="text-sm font-bold leading-tight text-white">
                    HSST
                </p>
            </div>
        </div>
    </div>
</div>

                        {{-- Main Header --}}
                        <div class="border-b border-slate-200 bg-[radial-gradient(circle_at_top_right,rgba(37,99,235,0.05),transparent_22%),linear-gradient(180deg,#ffffff_0%,#f8fafc_100%)] px-4 py-6 sm:px-6 md:px-8 md:py-7">
                            <div class="flex items-start justify-between gap-4">
                                <div>
                                    <p class="mb-2 text-[11px] font-bold uppercase tracking-[0.14em] text-blue-700">
                                        Step 1 of 2
                                    </p>

                                    <h2 class="font-display text-[1.9rem] leading-tight tracking-[-0.03em] text-slate-900 sm:text-[2.05rem]">
                                        Log in to your account
                                    </h2>

                                    <p class="mt-2 max-w-2xl text-sm leading-7 text-slate-500">
                                        Enter your credentials below to access the Holy Spirit
                                        School of Tagbilaran alumni portal.
                                    </p>
                                </div>

                                <button
                                    type="button"
                                    onclick="history.back()"
                                    class="hidden md:inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 18l-6-6 6-6" />
                                    </svg>
                                    Back
                                </button>
                            </div>

                            <div class="mt-5 h-2 w-full overflow-hidden rounded-full bg-slate-200">
                                <div class="h-full w-1/2 rounded-full bg-gradient-to-r from-blue-600 to-blue-700"></div>
                            </div>
                        </div>

                        {{-- Form Section --}}
                        <div class="flex flex-1 items-center px-4 py-6 sm:px-6 md:px-10 lg:px-14 md:py-10">
                            <div class="w-full max-w-2xl">
                                @if (session('status'))
                                    <div class="mb-5 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm leading-6 text-emerald-800">
                                        {{ session('status') }}
                                    </div>
                                @endif

                                <form method="POST" action="{{ route('login.store') }}" novalidate>
                                    @csrf

                                    <div class="rounded-[20px] border border-slate-200 bg-white p-5 shadow-[0_10px_24px_rgba(15,23,42,0.08)] sm:p-6 md:rounded-none md:border-0 md:bg-transparent md:p-0 md:shadow-none">
                                        <div class="space-y-5">

                                            {{-- Username --}}
                                            <div>
                                                <label for="username" class="mb-2 block text-xs font-bold tracking-[0.01em] text-slate-500">
                                                    Username
                                                </label>

                                                <div class="relative">
                                                    <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                            <path d="M20 21a8 8 0 0 0-16 0"></path>
                                                            <circle cx="12" cy="7" r="4"></circle>
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
                                                        class="@error('username') border-red-500 ring-red-100 @else border-slate-200 @enderror h-12 w-full rounded-[14px] border bg-slate-50 pl-11 pr-4 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 hover:border-slate-300 hover:bg-white focus:border-blue-600 focus:bg-white focus:ring-4 focus:ring-blue-100"
                                                    >
                                                </div>

                                                @error('username')
                                                    <p class="mt-2 text-xs leading-5 text-red-600">{{ $message }}</p>
                                                @enderror
                                            </div>

                                            {{-- Password --}}
                                            <div>
                                                <div class="mb-2 flex items-center justify-between gap-3">
                                                    <label for="password" class="block text-xs font-bold tracking-[0.01em] text-slate-500">
                                                        Password
                                                    </label>

                                                    @if (Route::has('password.request'))
                                                        <a
                                                            href="{{ route('password.request') }}"
                                                            class="text-xs font-semibold text-blue-700 hover:underline"
                                                        >
                                                            Forgot password?
                                                        </a>
                                                    @endif
                                                </div>

                                                <div class="relative">
                                                    <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                            <rect x="3" y="11" width="18" height="10" rx="2"></rect>
                                                            <path d="M7 11V8a5 5 0 0 1 10 0v3"></path>
                                                        </svg>
                                                    </span>

                                                    <input
                                                        id="password"
                                                        name="password"
                                                        type="password"
                                                        required
                                                        autocomplete="current-password"
                                                        placeholder="Enter your password"
                                                        class="@error('password') border-red-500 ring-red-100 @else border-slate-200 @enderror h-12 w-full rounded-[14px] border bg-slate-50 pl-11 pr-4 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 hover:border-slate-300 hover:bg-white focus:border-blue-600 focus:bg-white focus:ring-4 focus:ring-blue-100"
                                                    >
                                                </div>

                                                @error('password')
                                                    <p class="mt-2 text-xs leading-5 text-red-600">{{ $message }}</p>
                                                @enderror
                                            </div>

                                            {{-- Remember --}}
                                            <div class="flex items-center justify-between gap-4">
                                                <label for="remember" class="inline-flex cursor-pointer items-center gap-2.5 text-sm text-slate-600">
                                                    <input
                                                        id="remember"
                                                        name="remember"
                                                        type="checkbox"
                                                        {{ old('remember') ? 'checked' : '' }}
                                                        class="h-4 w-4 rounded border-slate-300 text-blue-600 focus:ring-blue-500"
                                                    >
                                                    <span>Remember me</span>
                                                </label>
                                            </div>

                                            {{-- Submit --}}
                                            <button
                                                type="submit"
                                                data-test="login-button"
                                                class="inline-flex h-12 w-full items-center justify-center rounded-[14px] bg-gradient-to-b from-blue-600 to-blue-700 px-5 text-sm font-bold text-white shadow-[0_16px_30px_rgba(37,99,235,0.18)] transition hover:brightness-105 active:translate-y-[1px]"
                                            >
                                                Sign in
                                            </button>
                                        </div>
                                    </div>

                                    @if (Route::has('register'))
                                        <div class="pt-5 text-center text-sm text-slate-500 md:text-left">
                                            Don’t have an account?
                                            <a
                                                href="{{ route('register') }}"
                                                class="font-bold text-blue-700 hover:underline"
                                            >
                                                Sign up here
                                            </a>
                                        </div>
                                    @endif
                                </form>
                            </div>
                        </div>
                    </main>
                </div>
            </div>
        </div>
    </div>
</body>
</html>