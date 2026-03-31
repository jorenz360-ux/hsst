{{-- resources/views/auth/register.blade.php --}}
<!doctype html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Create Account — HSST Alumni Portal</title>

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
    <div class="min-h-screen bg-[radial-gradient(circle_at_top_right,rgba(37,99,235,0.08),transparent_24%),linear-gradient(180deg,#f8fbff_0%,#eef3fb_100%)] px-0 sm:px-4 lg:px-0">
        <div class="mx-auto min-h-screen max-w-7xl">
            <div class="w-full overflow-hidden bg-white shadow-none sm:rounded-[28px] sm:border sm:border-slate-200/80 sm:shadow-[0_24px_60px_rgba(15,23,42,0.12)] lg:rounded-none lg:border-0 lg:shadow-none">
                <div class="grid min-h-screen grid-cols-1 lg:grid-cols-[340px_minmax(0,1fr)]">

                    {{-- Sidebar --}}
                    <aside class="relative hidden overflow-hidden bg-gradient-to-b from-[#153eaf] to-[#0f2f83] text-white lg:flex lg:flex-col">
                        <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,rgba(255,255,255,0.14),transparent_24%)]"></div>
                        <div class="absolute -bottom-10 -right-10 h-48 w-48 rounded-full bg-white/5 blur-sm"></div>

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
                                    Create account
                                </p>

                                <h1 class="font-display text-4xl leading-none tracking-[-0.03em] text-white">
                                    Join the alumni portal.
                                </h1>

                                <p class="mt-4 max-w-xs text-sm leading-7 text-white/80">
                                    Complete your account setup to access announcements,
                                    upcoming reunions, alumni updates, and your profile dashboard.
                                </p>
                            </div>

                            <div id="stepNav" class="space-y-3"></div>

                            <div class="mt-auto border-t border-white/15 pt-5 text-sm leading-6 text-white/75">
                                <p>Already have an account?</p>
                                <a
                                    href="{{ route('login') }}"
                                    class="mt-1 inline-block font-semibold text-white hover:underline"
                                >
                                    Log in to your account
                                </a>
                            </div>
                        </div>
                    </aside>

                    {{-- Main --}}
                    <main class="flex min-h-screen flex-col bg-gradient-to-b from-white to-slate-50 lg:min-h-0">

                        {{-- Mobile Header --}}
                        <div class="border-b border-white/10 bg-gradient-to-b from-[#153eaf] to-[#0f2f83] lg:hidden">
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

                        <form method="POST" action="{{ route('register') }}" id="registerForm" novalidate class="flex min-h-screen flex-col lg:min-h-0">
                            @csrf

                            {{-- Step Header --}}
                            <div class="border-b border-slate-200 bg-[linear-gradient(180deg,#ffffff_0%,#f8fafc_100%)] px-4 py-6 sm:px-6 md:px-8 md:py-7">
                                <div class="flex items-start justify-between gap-4">
                                    <div>
                                        <p id="eyebrow" class="mb-2 text-[11px] font-bold uppercase tracking-[0.14em] text-blue-700">
                                            Step 1 of 4
                                        </p>

                                        <h2 id="stepTitle" class="font-display text-[1.9rem] leading-tight tracking-[-0.03em] text-slate-900 sm:text-[2.05rem]">
                                            Account setup
                                        </h2>

                                        <p id="stepDesc" class="mt-2 max-w-2xl text-sm leading-7 text-slate-500">
                                            Choose the login credentials for your alumni account.
                                        </p>
                                    </div>

                                    <button
                                        type="button"
                                        onclick="history.back()"
                                        class="hidden lg:inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 18l-6-6 6-6" />
                                        </svg>
                                        Back
                                    </button>
                                </div>

                                <div class="mt-5 h-2 w-full overflow-hidden rounded-full bg-slate-200">
                                    <div id="progressFill" class="h-full w-1/4 rounded-full bg-gradient-to-r from-blue-600 to-blue-700 transition-all duration-300"></div>
                                </div>
                            </div>

                            {{-- Body --}}
                            <div class="flex-1 px-4 py-6 sm:px-6 md:px-8 lg:px-12 xl:px-16 md:py-8 lg:py-10">

                                {{-- PANEL 1 --}}
                                <section id="panel-1" class="panel active">
                                    <div class="mx-auto max-w-3xl rounded-[20px] border border-slate-200 bg-white p-5 shadow-[0_10px_24px_rgba(15,23,42,0.08)] sm:p-6 lg:rounded-none lg:border-0 lg:bg-transparent lg:p-0 lg:shadow-none">
                                        <div class="grid gap-5 md:grid-cols-2">
                                            <div>
                                                <label for="username" class="mb-2 block text-xs font-bold tracking-[0.01em] text-slate-500">
                                                    Username
                                                </label>
                                                <input
                                                    type="text"
                                                    id="username"
                                                    name="username"
                                                    value="{{ old('username') }}"
                                                    placeholder="e.g. jdelacruz"
                                                    autocomplete="username"
                                                    class="h-12 w-full rounded-[14px] border border-slate-200 bg-slate-50 px-4 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 hover:border-slate-300 hover:bg-white focus:border-blue-600 focus:bg-white focus:ring-4 focus:ring-blue-100"
                                                >
                                                <p class="mt-2 text-xs leading-5 text-slate-400">
                                                    This is what you'll use to sign in.
                                                </p>
                                                <p id="err-username" class="field-error mt-2 hidden text-xs leading-5 text-red-600">
                                                    @error('username'){{ $message }}@enderror
                                                </p>
                                            </div>

                                            <div>
                                                <label for="email" class="mb-2 block text-xs font-bold tracking-[0.01em] text-slate-500">
                                                    Email address
                                                </label>
                                                <input
                                                    type="email"
                                                    id="email"
                                                    name="email"
                                                    value="{{ old('email') }}"
                                                    placeholder="you@example.com"
                                                    autocomplete="email"
                                                    class="h-12 w-full rounded-[14px] border border-slate-200 bg-slate-50 px-4 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 hover:border-slate-300 hover:bg-white focus:border-blue-600 focus:bg-white focus:ring-4 focus:ring-blue-100"
                                                >
                                                <p class="mt-2 text-xs leading-5 text-slate-400">
                                                    For account notifications and recovery.
                                                </p>
                                                <p id="err-email" class="field-error mt-2 hidden text-xs leading-5 text-red-600">
                                                    @error('email'){{ $message }}@enderror
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </section>

                                {{-- PANEL 2 --}}
                                <section id="panel-2" class="panel hidden">
                                    <div class="mx-auto max-w-3xl rounded-[20px] border border-slate-200 bg-white p-5 shadow-[0_10px_24px_rgba(15,23,42,0.08)] sm:p-6 lg:rounded-none lg:border-0 lg:bg-transparent lg:p-0 lg:shadow-none">
                                        <div class="grid gap-5 md:grid-cols-2">
                                            <div>
                                                <label for="fname" class="mb-2 block text-xs font-bold tracking-[0.01em] text-slate-500">
                                                    First name
                                                </label>
                                                <input
                                                    type="text"
                                                    id="fname"
                                                    name="fname"
                                                    value="{{ old('fname') }}"
                                                    placeholder="First name"
                                                    autocomplete="given-name"
                                                    class="h-12 w-full rounded-[14px] border border-slate-200 bg-slate-50 px-4 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 hover:border-slate-300 hover:bg-white focus:border-blue-600 focus:bg-white focus:ring-4 focus:ring-blue-100"
                                                >
                                                <p id="err-fname" class="field-error mt-2 hidden text-xs leading-5 text-red-600">
                                                    @error('fname'){{ $message }}@enderror
                                                </p>
                                            </div>

                                            <div>
                                                <label for="lname" class="mb-2 block text-xs font-bold tracking-[0.01em] text-slate-500">
                                                    Last name
                                                </label>
                                                <input
                                                    type="text"
                                                    id="lname"
                                                    name="lname"
                                                    value="{{ old('lname') }}"
                                                    placeholder="Last name"
                                                    autocomplete="family-name"
                                                    class="h-12 w-full rounded-[14px] border border-slate-200 bg-slate-50 px-4 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 hover:border-slate-300 hover:bg-white focus:border-blue-600 focus:bg-white focus:ring-4 focus:ring-blue-100"
                                                >
                                                <p id="err-lname" class="field-error mt-2 hidden text-xs leading-5 text-red-600">
                                                    @error('lname'){{ $message }}@enderror
                                                </p>
                                            </div>

                                            <div>
                                                <label for="mname" class="mb-2 block text-xs font-bold tracking-[0.01em] text-slate-500">
                                                    Middle name <span class="font-normal text-slate-400">(optional)</span>
                                                </label>
                                                <input
                                                    type="text"
                                                    id="mname"
                                                    name="mname"
                                                    value="{{ old('mname') }}"
                                                    placeholder="Middle name"
                                                    autocomplete="additional-name"
                                                    class="h-12 w-full rounded-[14px] border border-slate-200 bg-slate-50 px-4 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 hover:border-slate-300 hover:bg-white focus:border-blue-600 focus:bg-white focus:ring-4 focus:ring-blue-100"
                                                >
                                            </div>

                                            <div>
                                                <label for="yeargrad" class="mb-2 block text-xs font-bold tracking-[0.01em] text-slate-500">
                                                    Year graduated
                                                </label>
                                                <input
                                                    type="number"
                                                    id="yeargrad"
                                                    name="yeargrad"
                                                    value="{{ old('yeargrad') }}"
                                                    placeholder="e.g. 2015"
                                                    min="1950"
                                                    max="{{ now()->year }}"
                                                    class="h-12 w-full rounded-[14px] border border-slate-200 bg-slate-50 px-4 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 hover:border-slate-300 hover:bg-white focus:border-blue-600 focus:bg-white focus:ring-4 focus:ring-blue-100"
                                                >
                                                <p class="mt-2 text-xs leading-5 text-slate-400">
                                                    Year you completed your studies at HSST.
                                                </p>
                                                <p id="err-yeargrad" class="field-error mt-2 hidden text-xs leading-5 text-red-600">
                                                    @error('yeargrad'){{ $message }}@enderror
                                                </p>
                                            </div>

                                            <div class="md:col-span-2">
                                                <label for="occupation" class="mb-2 block text-xs font-bold tracking-[0.01em] text-slate-500">
                                                    Occupation <span class="font-normal text-slate-400">(optional)</span>
                                                </label>
                                                <input
                                                    type="text"
                                                    id="occupation"
                                                    name="occupation"
                                                    value="{{ old('occupation') }}"
                                                    placeholder="e.g. Teacher, Engineer, Nurse, Business Owner"
                                                    autocomplete="organization-title"
                                                    class="h-12 w-full rounded-[14px] border border-slate-200 bg-slate-50 px-4 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 hover:border-slate-300 hover:bg-white focus:border-blue-600 focus:bg-white focus:ring-4 focus:ring-blue-100"
                                                >
                                                <p class="mt-2 text-xs leading-5 text-slate-400">
                                                    Enter your current occupation or profession.
                                                </p>
                                                <p id="err-occupation" class="field-error mt-2 hidden text-xs leading-5 text-red-600">
                                                    @error('occupation'){{ $message }}@enderror
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </section>

                                {{-- PANEL 3 --}}
                                <section id="panel-3" class="panel hidden">
                                    <div class="mx-auto max-w-3xl rounded-[20px] border border-slate-200 bg-white p-5 shadow-[0_10px_24px_rgba(15,23,42,0.08)] sm:p-6 lg:rounded-none lg:border-0 lg:bg-transparent lg:p-0 lg:shadow-none">
                                        <div class="space-y-5">
                                            <div>
                                                <label for="google_autocomplete" class="mb-2 block text-xs font-bold tracking-[0.01em] text-slate-500">
                                                    Search address
                                                </label>

                                                <div class="relative">
                                                    <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                            <circle cx="11" cy="11" r="8" />
                                                            <path d="m21 21-4.35-4.35" />
                                                        </svg>
                                                    </span>

                                                    <input
                                                        type="text"
                                                        id="google_autocomplete"
                                                        placeholder="Start typing your address..."
                                                        autocomplete="off"
                                                        class="h-12 w-full rounded-[14px] border border-slate-200 bg-slate-50 pl-11 pr-4 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 hover:border-slate-300 hover:bg-white focus:border-blue-600 focus:bg-white focus:ring-4 focus:ring-blue-100"
                                                    >
                                                </div>

                                                <p class="mt-2 text-xs leading-5 text-slate-400">
                                                    Select a suggestion to auto-fill the fields below. You can still edit them manually.
                                                </p>
                                            </div>

                                            <div>
                                                <label for="address_line_1" class="mb-2 block text-xs font-bold tracking-[0.01em] text-slate-500">
                                                    Street address
                                                </label>
                                                <textarea
                                                    id="address_line_1"
                                                    name="address_line_1"
                                                    placeholder="House/Unit no., street name, barangay or district"
                                                    class="min-h-[88px] w-full rounded-[14px] border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 hover:border-slate-300 hover:bg-white focus:border-blue-600 focus:bg-white focus:ring-4 focus:ring-blue-100"
                                                >{{ old('address_line_1') }}</textarea>
                                                <p id="err-addr1" class="field-error mt-2 hidden text-xs leading-5 text-red-600">
                                                    @error('address_line_1'){{ $message }}@enderror
                                                </p>
                                            </div>

                                            <div>
                                                <button
                                                    type="button"
                                                    id="toggleAddr2Btn"
                                                    onclick="toggleAddr2()"
                                                    class="inline-flex items-center gap-2 text-sm font-semibold text-blue-700 transition hover:text-blue-800"
                                                >
                                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round">
                                                        <path d="M12 5v14M5 12h14" />
                                                    </svg>
                                                    Add apartment, suite, or other details
                                                </button>
                                            </div>

                                            <div id="addr2wrap" class="{{ old('address_line_2') ? '' : 'hidden' }}">
                                                <label for="address_line_2" class="mb-2 block text-xs font-bold tracking-[0.01em] text-slate-500">
                                                    Address line 2 <span class="font-normal text-slate-400">(optional)</span>
                                                </label>
                                                <input
                                                    type="text"
                                                    id="address_line_2"
                                                    name="address_line_2"
                                                    value="{{ old('address_line_2') }}"
                                                    placeholder="Subdivision, building, floor, unit, etc."
                                                    autocomplete="address-line2"
                                                    class="h-12 w-full rounded-[14px] border border-slate-200 bg-slate-50 px-4 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 hover:border-slate-300 hover:bg-white focus:border-blue-600 focus:bg-white focus:ring-4 focus:ring-blue-100"
                                                >
                                            </div>

                                            <div class="grid gap-5 md:grid-cols-2">
                                                <div>
                                                    <label for="city" class="mb-2 block text-xs font-bold tracking-[0.01em] text-slate-500">
                                                        City / Municipality
                                                    </label>
                                                    <input
                                                        type="text"
                                                        id="city"
                                                        name="city"
                                                        value="{{ old('city') }}"
                                                        placeholder="City or municipality"
                                                        autocomplete="address-level2"
                                                        class="h-12 w-full rounded-[14px] border border-slate-200 bg-slate-50 px-4 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 hover:border-slate-300 hover:bg-white focus:border-blue-600 focus:bg-white focus:ring-4 focus:ring-blue-100"
                                                    >
                                                    <p id="err-city" class="field-error mt-2 hidden text-xs leading-5 text-red-600">
                                                        @error('city'){{ $message }}@enderror
                                                    </p>
                                                </div>

                                                <div>
                                                    <label for="state_province" class="mb-2 block text-xs font-bold tracking-[0.01em] text-slate-500">
                                                        Province / State / Region
                                                    </label>
                                                    <input
                                                        type="text"
                                                        id="state_province"
                                                        name="state_province"
                                                        value="{{ old('state_province') }}"
                                                        placeholder="Province or state"
                                                        autocomplete="address-level1"
                                                        class="h-12 w-full rounded-[14px] border border-slate-200 bg-slate-50 px-4 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 hover:border-slate-300 hover:bg-white focus:border-blue-600 focus:bg-white focus:ring-4 focus:ring-blue-100"
                                                    >
                                                    <p id="err-province" class="field-error mt-2 hidden text-xs leading-5 text-red-600">
                                                        @error('state_province'){{ $message }}@enderror
                                                    </p>
                                                </div>

                                                <div>
                                                    <label for="postal_code" class="mb-2 block text-xs font-bold tracking-[0.01em] text-slate-500">
                                                        Postal / ZIP code
                                                    </label>
                                                    <input
                                                        type="text"
                                                        id="postal_code"
                                                        name="postal_code"
                                                        value="{{ old('postal_code') }}"
                                                        placeholder="Postal or ZIP code"
                                                        autocomplete="postal-code"
                                                        class="h-12 w-full rounded-[14px] border border-slate-200 bg-slate-50 px-4 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 hover:border-slate-300 hover:bg-white focus:border-blue-600 focus:bg-white focus:ring-4 focus:ring-blue-100"
                                                    >
                                                    <p id="err-postal" class="field-error mt-2 hidden text-xs leading-5 text-red-600">
                                                        @error('postal_code'){{ $message }}@enderror
                                                    </p>
                                                </div>

                                                <div>
                                                    <label for="country" class="mb-2 block text-xs font-bold tracking-[0.01em] text-slate-500">
                                                        Country
                                                    </label>
                                                    <input
                                                        type="text"
                                                        id="country"
                                                        name="country"
                                                        value="{{ old('country', 'Philippines') }}"
                                                        autocomplete="country-name"
                                                        class="h-12 w-full rounded-[14px] border border-slate-200 bg-slate-50 px-4 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 hover:border-slate-300 hover:bg-white focus:border-blue-600 focus:bg-white focus:ring-4 focus:ring-blue-100"
                                                    >
                                                    <p id="err-country" class="field-error mt-2 hidden text-xs leading-5 text-red-600">
                                                        @error('country'){{ $message }}@enderror
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </section>

                                {{-- PANEL 4 --}}
                                <section id="panel-4" class="panel hidden">
                                    <div class="mx-auto max-w-3xl rounded-[20px] border border-slate-200 bg-white p-5 shadow-[0_10px_24px_rgba(15,23,42,0.08)] sm:p-6 lg:rounded-none lg:border-0 lg:bg-transparent lg:p-0 lg:shadow-none">
                                        <div class="grid gap-5 md:grid-cols-2">
                                            <div>
                                                <label for="password" class="mb-2 block text-xs font-bold tracking-[0.01em] text-slate-500">
                                                    Password
                                                </label>
                                                <input
                                                    type="password"
                                                    id="password"
                                                    name="password"
                                                    placeholder="Create a password"
                                                    autocomplete="new-password"
                                                    oninput="checkPasswordStrength(this.value)"
                                                    class="h-12 w-full rounded-[14px] border border-slate-200 bg-slate-50 px-4 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 hover:border-slate-300 hover:bg-white focus:border-blue-600 focus:bg-white focus:ring-4 focus:ring-blue-100"
                                                >

                                                <div id="pwStrength" class="mt-3 flex gap-1">
                                                    <div id="bar1" class="h-1 flex-1 rounded-full bg-slate-200"></div>
                                                    <div id="bar2" class="h-1 flex-1 rounded-full bg-slate-200"></div>
                                                    <div id="bar3" class="h-1 flex-1 rounded-full bg-slate-200"></div>
                                                    <div id="bar4" class="h-1 flex-1 rounded-full bg-slate-200"></div>
                                                </div>

                                                <p id="pwLabel" class="mt-2 text-xs leading-5 text-slate-400">
                                                    Use letters, numbers, and symbols for a stronger password.
                                                </p>

                                                <p id="err-password" class="field-error mt-2 hidden text-xs leading-5 text-red-600">
                                                    @error('password'){{ $message }}@enderror
                                                </p>
                                            </div>

                                            <div>
                                                <label for="password_confirmation" class="mb-2 block text-xs font-bold tracking-[0.01em] text-slate-500">
                                                    Confirm password
                                                </label>
                                                <input
                                                    type="password"
                                                    id="password_confirmation"
                                                    name="password_confirmation"
                                                    placeholder="Re-enter your password"
                                                    autocomplete="new-password"
                                                    class="h-12 w-full rounded-[14px] border border-slate-200 bg-slate-50 px-4 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 hover:border-slate-300 hover:bg-white focus:border-blue-600 focus:bg-white focus:ring-4 focus:ring-blue-100"
                                                >
                                                <p id="err-confirm" class="field-error mt-2 hidden text-xs leading-5 text-red-600"></p>
                                            </div>
                                        </div>

                                        <div class="mt-6 rounded-2xl border border-blue-200 bg-blue-50 px-4 py-3 text-sm leading-6 text-blue-900">
                                            By creating an account, you confirm that all information provided is accurate and that you are an alumnus or alumna of Holy Spirit School of Tagbilaran.
                                        </div>
                                    </div>
                                </section>
                            </div>

                            {{-- Footer actions --}}
                            <div class="border-t border-slate-200 bg-slate-50 px-4 py-4 sm:px-6 md:px-8">
                                <div class="mx-auto flex max-w-3xl items-center justify-end gap-3 lg:max-w-none">
                                    <button
                                        type="button"
                                        id="btnBack"
                                        onclick="prevStep()"
                                        class="hidden h-11 rounded-[14px] border border-slate-200 bg-white px-5 text-sm font-semibold text-slate-700 transition hover:border-slate-300 hover:bg-slate-100"
                                    >
                                        Back
                                    </button>

                                    <button
                                        type="button"
                                        id="btnNext"
                                        onclick="nextStep()"
                                        class="inline-flex h-11 items-center justify-center gap-2 rounded-[14px] bg-gradient-to-b from-blue-600 to-blue-700 px-5 text-sm font-bold text-white shadow-[0_16px_30px_rgba(37,99,235,0.18)] transition hover:brightness-105 active:translate-y-[1px]"
                                    >
                                        <span id="btnNextLabel">Continue</span>
                                        <svg id="btnNextIcon" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M5 12h14M12 5l7 7-7 7" />
                                        </svg>
                                    </button>
                                </div>

                                @if (Route::has('login'))
                                    <div class="pt-5 text-center text-sm text-slate-500 lg:text-left">
                                        Already have an account?
                                        <a
                                            href="{{ route('login') }}"
                                            class="font-bold text-blue-700 hover:underline"
                                        >
                                            Log in here
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </form>
                    </main>
                </div>
            </div>
        </div>
    </div>

    <script>
        const STEPS = [
            {
                short: "Account",
                sub: "Username & email",
                title: "Account setup",
                desc: "Choose the login credentials for your alumni account.",
            },
            {
                short: "Personal",
                sub: "Name & graduation year",
                title: "Personal info",
                desc: "Tell us your name and the year you graduated from HSST.",
            },
            {
                short: "Address",
                sub: "Current location",
                title: "Address details",
                desc: "Provide your current mailing or residential address.",
            },
            {
                short: "Security",
                sub: "Password & confirm",
                title: "Security setup",
                desc: "Set a secure password to complete your registration.",
            },
        ];

        let currentStep = 1;
        let isSubmitting = false;
        const totalSteps = STEPS.length;

        function buildNav() {
            const nav = document.getElementById("stepNav");
            if (!nav) return;

            nav.innerHTML = "";

            STEPS.forEach((s, i) => {
                const n = i + 1;
                const isDone = n < currentStep;
                const isActive = n === currentStep;

                const itemClasses = isActive
                    ? "border border-white/20 bg-white/15"
                    : isDone
                    ? "border border-white/15 bg-white/10"
                    : "border border-white/10 bg-white/[0.06]";

                const dotClasses = isDone
                    ? "bg-white text-blue-700 border border-white/20"
                    : isActive
                    ? "bg-white/15 text-white border border-white/20"
                    : "bg-white/10 text-white/75 border border-white/15";

                nav.innerHTML += `
                    <div class="flex items-center gap-3 rounded-2xl px-4 py-3 ${itemClasses}">
                        <div class="flex h-9 w-9 items-center justify-center rounded-full text-sm font-bold ${dotClasses}">
                            ${isDone ? "✓" : n}
                        </div>
                        <div>
                            <p class="text-sm font-bold text-white">${s.short}</p>
                            <p class="text-xs text-white/70">${s.sub}</p>
                        </div>
                    </div>
                `;
            });
        }

        function updateHeader() {
            const s = STEPS[currentStep - 1];
            document.getElementById("eyebrow").textContent = `Step ${currentStep} of ${totalSteps}`;
            document.getElementById("stepTitle").textContent = s.title;
            document.getElementById("stepDesc").textContent = s.desc;
            document.getElementById("progressFill").style.width = `${(currentStep / totalSteps) * 100}%`;

            const btnBack = document.getElementById("btnBack");
            btnBack.classList.toggle("hidden", currentStep === 1);

            document.getElementById("btnNextLabel").textContent =
                currentStep === totalSteps ? "Create account" : "Continue";

            document.getElementById("btnNextIcon").style.display =
                currentStep === totalSteps ? "none" : "inline-block";
        }

        function showPanel(n) {
            document.querySelectorAll(".panel").forEach((panel) => {
                panel.classList.add("hidden");
                panel.classList.remove("block");
            });

            const currentPanel = document.getElementById(`panel-${n}`);
            if (currentPanel) {
                currentPanel.classList.remove("hidden");
                currentPanel.classList.add("block");
            }
        }

        function clearErrors() {
            document.querySelectorAll(".field-error").forEach((el) => {
                if (!el.textContent.trim()) el.classList.add("hidden");
            });

            document.querySelectorAll("input, textarea").forEach((el) => {
                el.classList.remove("border-red-500", "ring-4", "ring-red-100");
            });
        }

        function showError(fieldId, errId, message) {
            const field = document.getElementById(fieldId);
            const err = document.getElementById(errId);

            if (field) {
                field.classList.add("border-red-500", "ring-4", "ring-red-100");
            }

            if (err) {
                err.textContent = message;
                err.classList.remove("hidden");
            }
        }

        function validateStep(step) {
            clearErrors();
            let valid = true;

            if (step === 1) {
                const username = document.getElementById("username").value.trim();
                const email = document.getElementById("email").value.trim();

                if (!username) {
                    showError("username", "err-username", "Please enter a username.");
                    valid = false;
                }

                if (!email || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
                    showError("email", "err-email", "Please enter a valid email address.");
                    valid = false;
                }
            }

            if (step === 2) {
                const fname = document.getElementById("fname").value.trim();
                const lname = document.getElementById("lname").value.trim();
                const yeargrad = document.getElementById("yeargrad").value.trim();

                if (!fname) {
                    showError("fname", "err-fname", "First name is required.");
                    valid = false;
                }

                if (!lname) {
                    showError("lname", "err-lname", "Last name is required.");
                    valid = false;
                }

              if (!yeargrad || yeargrad < 1900 || yeargrad > new Date().getFullYear()) {
                showError(
                    "yeargrad",
                    "err-yeargrad",
                    `Please enter a valid graduation year (1900–${new Date().getFullYear()}).`
                );
                valid = false;
            }
            }

            if (step === 3) {
                const addr1 = document.getElementById("address_line_1").value.trim();
                const city = document.getElementById("city").value.trim();
                const province = document.getElementById("state_province").value.trim();
                const postal = document.getElementById("postal_code").value.trim();
                const country = document.getElementById("country").value.trim();

                if (!addr1) {
                    showError("address_line_1", "err-addr1", "Street address is required.");
                    valid = false;
                }
                if (!city) {
                    showError("city", "err-city", "City / municipality is required.");
                    valid = false;
                }
                if (!province) {
                    showError("state_province", "err-province", "Province / state is required.");
                    valid = false;
                }
                if (!postal) {
                    showError("postal_code", "err-postal", "Postal / ZIP code is required.");
                    valid = false;
                }
                if (!country) {
                    showError("country", "err-country", "Country is required.");
                    valid = false;
                }
            }

            if (step === 4) {
                const pw = document.getElementById("password").value;
                const pw2 = document.getElementById("password_confirmation").value;

                if (!pw) {
                    showError("password", "err-password", "Password is required.");
                    valid = false;
                }

                if (!pw2) {
                    showError("password_confirmation", "err-confirm", "Please confirm your password.");
                    valid = false;
                } else if (pw !== pw2) {
                    showError("password_confirmation", "err-confirm", "Passwords do not match.");
                    valid = false;
                }
            }

            return valid;
        }

        function nextStep() {
            if (isSubmitting) return;

            if (!validateStep(currentStep)) {
                const btn = document.getElementById("btnNext");
                btn.style.transform = "translateX(-4px)";
                setTimeout(() => (btn.style.transform = "translateX(4px)"), 80);
                setTimeout(() => (btn.style.transform = ""), 160);
                return;
            }

            if (currentStep < totalSteps) {
                currentStep++;
                buildNav();
                updateHeader();
                showPanel(currentStep);

                if (currentStep === 3) {
                    setTimeout(() => {
                        if (typeof initGoogleAddressAutocomplete === "function") {
                            initGoogleAddressAutocomplete();
                        }
                    }, 200);
                }
            } else {
                const btn = document.getElementById("btnNext");
                const btnLabel = document.getElementById("btnNextLabel");
                const btnIcon = document.getElementById("btnNextIcon");

                btn.disabled = true;
                isSubmitting = true;
                btnLabel.textContent = "Creating account...";
                btnIcon.style.display = "inline-block";
                btnIcon.innerHTML = `
                    <circle cx="12" cy="12" r="10" fill="none" stroke="white" stroke-width="2" stroke-dasharray="30" stroke-dashoffset="15">
                        <animate attributeName="stroke-dashoffset" dur="0.6s" repeatCount="indefinite" from="0" to="30"/>
                    </circle>
                `;
                btnIcon.setAttribute("viewBox", "0 0 24 24");
                btnIcon.style.width = "16px";
                btnIcon.style.height = "16px";

                document.getElementById("registerForm").submit();
            }
        }

        function prevStep() {
            if (currentStep > 1) {
                clearErrors();
                currentStep--;
                buildNav();
                updateHeader();
                showPanel(currentStep);
            }
        }

        function toggleAddr2() {
            const wrap = document.getElementById("addr2wrap");
            const btn = document.getElementById("toggleAddr2Btn");
            const isHidden = wrap.classList.contains("hidden");

            wrap.classList.toggle("hidden");

            btn.innerHTML = isHidden
                ? `<svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><path d="M5 12h14"/></svg> Hide additional address details`
                : `<svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><path d="M12 5v14M5 12h14"/></svg> Add apartment, suite, or other details`;
        }

        function checkPasswordStrength(val) {
            const bars = [
                document.getElementById("bar1"),
                document.getElementById("bar2"),
                document.getElementById("bar3"),
                document.getElementById("bar4"),
            ];
            const label = document.getElementById("pwLabel");

            let score = 0;
            if (val.length >= 8) score++;
            if (/[A-Z]/.test(val)) score++;
            if (/[0-9]/.test(val)) score++;
            if (/[^A-Za-z0-9]/.test(val)) score++;

            const colors = [
                "bg-slate-200",
                "bg-red-500",
                "bg-amber-500",
                "bg-emerald-500",
                "bg-blue-600"
            ];

            const labels = [
                "Use letters, numbers, and symbols for a stronger password.",
                "Weak — try adding numbers or symbols.",
                "Fair — add uppercase or symbols.",
                "Good password.",
                "Strong password!",
            ];

            bars.forEach((bar, i) => {
                bar.className = "h-1 flex-1 rounded-full bg-slate-200";
                if (i < score) {
                    bar.classList.remove("bg-slate-200");
                    bar.classList.add(colors[score]);
                }
            });

            label.textContent = val.length === 0
                ? "Use letters, numbers, and symbols for a stronger password."
                : labels[score];
        }

        let googleAutocompleteInstance = null;

        function initGoogleAddressAutocomplete() {
            const input = document.getElementById("google_autocomplete");
            if (!input || !window.google?.maps?.places) return;
            if (googleAutocompleteInstance) return;

            googleAutocompleteInstance = new google.maps.places.Autocomplete(input, {
                types: ["address"],
                fields: ["address_components", "formatted_address"],
            });

            googleAutocompleteInstance.addListener("place_changed", () => {
                const place = googleAutocompleteInstance.getPlace();
                if (!place?.address_components) return;

                const c = {};
                for (const comp of place.address_components) {
                    c[comp.types[0]] = comp.long_name;
                }

                const line1 = [c.street_number, c.route].filter(Boolean).join(" ");
                const line2 = c.subpremise || "";
                const city = c.locality || c.postal_town || c.sublocality_level_1 || c.neighborhood || "";

                setVal("address_line_1", line1);
                setVal("address_line_2", line2);
                setVal("city", city);
                setVal("state_province", c.administrative_area_level_1 || "");
                setVal("postal_code", c.postal_code || "");
                setVal("country", c.country || "");

                if (line2) {
                    document.getElementById("addr2wrap").classList.remove("hidden");
                }
            });
        }

        function setVal(id, value) {
            const el = document.getElementById(id);
            if (!el) return;
            el.value = value;
            el.dispatchEvent(new Event("input", { bubbles: true }));
            el.dispatchEvent(new Event("change", { bubbles: true }));
        }

        function jumpToErrorStep() {
            for (let step = 1; step <= totalSteps; step++) {
                const panel = document.getElementById(`panel-${step}`);
                if (!panel) continue;

                const hasVisibleOrServerError = Array.from(panel.querySelectorAll(".field-error")).some(
                    (el) => el.textContent.trim() !== ""
                );

                if (hasVisibleOrServerError) {
                    currentStep = step;
                    buildNav();
                    updateHeader();
                    showPanel(currentStep);

                    if (step === 3 && document.getElementById("address_line_2")?.value) {
                        document.getElementById("addr2wrap").classList.remove("hidden");
                    }

                    panel.querySelectorAll(".field-error").forEach((el) => {
                        if (el.textContent.trim() !== "") el.classList.remove("hidden");
                    });

                    break;
                }
            }
        }

        buildNav();
        updateHeader();
        jumpToErrorStep();
    </script>

    @if(config('services.google_maps.api_key'))
        <script async defer src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google_maps.api_key') }}&libraries=places&callback=initGoogleAddressAutocomplete"></script>
    @else
        <script>
            window.initGoogleAddressAutocomplete = function() {};
        </script>
    @endif
</body>
</html>