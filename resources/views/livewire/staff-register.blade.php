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
        color: white;
    }
    .btn-royal:hover { filter: brightness(1.07); box-shadow: 0 8px 28px rgba(21,53,145,0.42), inset 0 1px 0 rgba(255,255,255,0.14); }
    .btn-royal:active { transform: translateY(1px); box-shadow: 0 2px 10px rgba(21,53,145,0.3); }
    .btn-royal:disabled { opacity: 0.7; cursor: not-allowed; filter: none; }

    .btn-ghost {
        background: white;
        border: 1px solid #e2e8f0;
        color: #475569;
        transition: background 0.15s ease, border-color 0.15s ease;
    }
    .btn-ghost:hover { background: #f8fafc; border-color: #cbd5e1; }

    .field-input {
        height: 3.25rem;
        width: 100%;
        border-radius: 1rem;
        border: 1px solid #e2e8f0;
        background: #f8fafc;
        padding-left: 1rem;
        padding-right: 1rem;
        font-size: 0.875rem;
        color: #0f172a;
        outline: none;
        transition: border-color 0.15s, box-shadow 0.15s, background 0.15s;
    }
    .field-input::placeholder { color: #94a3b8; }
    .field-input:hover:not(:focus) { border-color: #94a3b8; background: #ffffff; }
    .field-input:focus {
        border-color: var(--royal-600);
        background: #ffffff;
        box-shadow: 0 0 0 3px rgba(26,63,168,0.12);
    }
    .field-input.is-error {
        border-color: #ef4444;
        box-shadow: 0 0 0 3px rgba(239,68,68,0.1);
    }

    .field-select {
        height: 3.25rem;
        width: 100%;
        border-radius: 1rem;
        border: 1px solid #e2e8f0;
        background: #f8fafc;
        padding: 0 1rem;
        font-size: 0.875rem;
        color: #0f172a;
        outline: none;
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%2394a3b8' stroke-width='2'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' d='M19 9l-7 7-7-7'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 1rem center;
        background-size: 1rem;
        padding-right: 2.5rem;
        transition: border-color 0.15s, box-shadow 0.15s, background-color 0.15s;
        cursor: pointer;
    }
    .field-select:hover { border-color: #94a3b8; background-color: #ffffff; }
    .field-select:focus {
        border-color: var(--royal-600);
        background-color: #ffffff;
        box-shadow: 0 0 0 3px rgba(26,63,168,0.12);
    }
    .field-select.is-error {
        border-color: #ef4444;
        box-shadow: 0 0 0 3px rgba(239,68,68,0.1);
    }

    .field-label {
        display: block;
        font-size: 0.7rem;
        font-weight: 700;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        color: #475569;
        margin-bottom: 0.5rem;
    }
    .field-label .opt {
        font-weight: 400;
        letter-spacing: normal;
        text-transform: none;
        color: #94a3b8;
        font-size: 0.7rem;
    }

    .field-error-msg {
        margin-top: 0.4rem;
        font-size: 0.72rem;
        line-height: 1.4;
        color: #dc2626;
    }

    .section-title {
        font-size: 0.7rem;
        font-weight: 700;
        letter-spacing: 0.12em;
        text-transform: uppercase;
        color: var(--royal-600);
        padding-bottom: 0.6rem;
        border-bottom: 2px solid var(--gold-200);
        margin-bottom: 1.25rem;
    }

    .ornament-line { width: 40px; height: 2px; background: var(--gold-500); border-radius: 2px; }
    .gold-divider  { width: 48px; height: 2px; background: linear-gradient(90deg, var(--gold-500), transparent); border-radius: 2px; }

    .sidebar-quote::before {
        content: '\201C';
        font-family: "DM Serif Display", Georgia, serif;
        font-size: 3.5rem;
        line-height: 0;
        color: var(--gold-500);
        opacity: 0.5;
        vertical-align: -1.4rem;
        margin-right: 0.1rem;
    }

    .page-bg {
        background-color: #f0f4fb;
        background-image:
            radial-gradient(circle at 80% 10%, rgba(26,63,168,0.07) 0%, transparent 45%),
            radial-gradient(circle at 10% 90%, rgba(196,149,42,0.05) 0%, transparent 40%);
    }
</style>

<div class="min-h-screen flex flex-col lg:flex-row page-bg">

    {{-- ================================================================== --}}
    {{-- SIDEBAR                                                              --}}
    {{-- ================================================================== --}}
    <aside class="hidden lg:flex lg:flex-col lg:w-[340px] xl:w-[390px] flex-shrink-0 relative overflow-hidden"
           style="background: linear-gradient(160deg, var(--royal-700) 0%, var(--royal-900) 100%);">

        <div class="absolute inset-0 pointer-events-none">
            <div class="absolute top-0 right-0 w-64 h-64 rounded-full opacity-10"
                 style="background: radial-gradient(circle, rgba(255,255,255,0.3) 0%, transparent 70%); transform: translate(30%,-30%);"></div>
            <div class="absolute bottom-0 left-0 w-80 h-80 rounded-full opacity-8"
                 style="background: radial-gradient(circle, rgba(196,149,42,0.25) 0%, transparent 70%); transform: translate(-40%,40%);"></div>
            <div class="absolute inset-0 opacity-[0.03]"
                 style="background-image: repeating-linear-gradient(45deg,#fff 0,#fff 1px,transparent 0,transparent 50%); background-size:14px 14px;"></div>
        </div>

        <div class="relative flex h-full flex-col px-8 py-9 xl:px-10">

            {{-- School identity --}}
            <div class="flex items-center gap-4 mb-9">
                <div class="h-14 w-14 flex-shrink-0 rounded-2xl overflow-hidden border-2 shadow-lg"
                     style="border-color: rgba(196,149,42,0.5); box-shadow: 0 4px 16px rgba(0,0,0,0.3);">
                    <img src="{{ asset('images/hsstlogo.jpg') }}" alt="HSST Logo" class="h-full w-full object-contain bg-white">
                </div>
                <div>
                    <p class="text-white font-bold text-sm leading-snug">Holy Spirit School<br>of Tagbilaran</p>
                    <p class="text-xs mt-0.5 font-medium" style="color: var(--gold-400);">2026 Reunion</p>
                </div>
            </div>

            {{-- Headline --}}
            <div class="mb-8">
                <div class="ornament-line mb-5"></div>
                <h1 class="font-display text-white leading-tight tracking-[-0.02em]"
                    style="font-size: clamp(1.8rem, 2.6vw, 2.4rem);">
                    You're part of<br><em>the family too.</em>
                </h1>
                <p class="mt-4 text-sm leading-7" style="color: rgba(255,255,255,0.72); max-width: 28ch;">
                    Register as a school employee, staff member, or SSPS personnel
                    to signify your attendance at the HSST 2026 Reunion.
                </p>
            </div>

            {{-- Info list --}}
            <div class="space-y-3 mt-2">
                @foreach([
                    ['Fill in your details', 'Name, address, and work information.'],
                    ['Choose your account type', 'Staff, employee, or SSPS member.'],
                    ['Wait for approval', 'A coordinator will review and activate your account.'],
                ] as [$step, $desc])
                <div class="flex items-start gap-3">
                    <div class="mt-0.5 flex-shrink-0 w-5 h-5 rounded-full flex items-center justify-center"
                         style="background: rgba(196,149,42,0.25); border: 1px solid rgba(196,149,42,0.4);">
                        <svg class="w-3 h-3" style="color: var(--gold-400);" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-white leading-snug">{{ $step }}</p>
                        <p class="text-xs mt-0.5" style="color: rgba(255,255,255,0.55);">{{ $desc }}</p>
                    </div>
                </div>
                @endforeach
            </div>

            {{-- Quote --}}
            <div class="mt-auto">
                <div class="gold-divider mb-4"></div>
                <p class="text-sm leading-7 italic" style="color: rgba(255,255,255,0.65);">
                    <span class="sidebar-quote"></span>Once a Holy Spirit family,
                    always together.
                </p>
            </div>

            {{-- Login footer --}}
            <div class="mt-6 pt-5" style="border-top: 1px solid rgba(255,255,255,0.1);">
                <p class="text-xs" style="color: rgba(255,255,255,0.55);">Already have an account?</p>
                <a
                    href="{{ route('login') }}"
                    class="inline-flex items-center gap-1.5 mt-1 text-sm font-semibold hover:underline transition"
                    style="color: var(--gold-400);"
                >
                    Sign in to your account
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/>
                    </svg>
                </a>
            </div>

        </div>
    </aside>

    {{-- ================================================================== --}}
    {{-- MAIN                                                                --}}
    {{-- ================================================================== --}}
    <main class="flex-1 flex flex-col bg-white lg:bg-transparent">

        {{-- Mobile Header --}}
        <div class="lg:hidden flex-shrink-0"
             style="background: linear-gradient(160deg, var(--royal-700) 0%, var(--royal-900) 100%);">
            <div class="px-5 py-4 flex items-center justify-between">
                <a href="{{ route('register') }}"
                   class="inline-flex items-center gap-1.5 text-sm font-semibold text-white/80 hover:text-white transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 18l-6-6 6-6"/>
                    </svg>
                    Back
                </a>
                <div class="flex items-center gap-3">
                    <div class="h-9 w-9 rounded-xl overflow-hidden border shadow-sm"
                         style="border-color: rgba(196,149,42,0.45);">
                        <img src="{{ asset('images/hsstlogo.jpg') }}" alt="HSST Logo" class="h-full w-full object-contain bg-white">
                    </div>
                    <div class="text-right">
                        <p class="text-white font-bold text-sm leading-tight">HSST</p>
                        <p class="text-xs font-medium" style="color: var(--gold-400);">2026 Reunion</p>
                    </div>
                </div>
            </div>
            <div class="px-5 pb-6 pt-1">
                <h2 class="font-display text-white text-2xl leading-tight">Staff & Employee Registration</h2>
                <p class="mt-1.5 text-sm" style="color: rgba(255,255,255,0.65);">Your account will be reviewed before activation.</p>
            </div>
        </div>

        {{-- Page header --}}
        <div class="flex-shrink-0 px-5 py-5 sm:px-8 lg:px-12 xl:px-16"
             style="border-bottom: 1px solid #e2e8f0; background: linear-gradient(180deg, #ffffff 0%, #f8fafc 100%);">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <p class="hidden lg:block text-xs font-bold uppercase tracking-[0.15em] mb-2"
                       style="color: var(--gold-500);">2026 Reunion</p>
                    <h2 class="font-display text-slate-900 leading-tight tracking-[-0.02em]"
                        style="font-size: clamp(1.6rem, 2.8vw, 2.1rem);">
                        Staff & Employee Registration
                    </h2>
                    <p class="mt-2 text-sm leading-6 text-slate-500">
                        Fill in all fields below. Your account will be pending until a coordinator approves it.
                    </p>
                </div>
                <a
                    href="{{ route('register') }}"
                    class="btn-ghost hidden lg:inline-flex items-center gap-2 rounded-xl px-3 py-2 text-sm font-semibold shadow-sm"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 18l-6-6 6-6"/>
                    </svg>
                    Back
                </a>
            </div>
        </div>

        {{-- Form --}}
        <form method="POST" action="{{ route('register.staff.store') }}" class="flex-1 px-5 py-8 sm:px-8 lg:px-12 xl:px-16">
            @csrf

            <div class="max-w-2xl space-y-10">

                {{-- ---- Personal Information ---- --}}
                <div>
                    <p class="section-title">Personal Information</p>
                    <div class="space-y-5">

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <div>
                                <label for="fname" class="field-label">First Name</label>
                                <input type="text" id="fname" name="fname"
                                       value="{{ old('fname') }}"
                                       placeholder="e.g. Maria"
                                       class="field-input {{ $errors->has('fname') ? 'is-error' : '' }}">
                                @error('fname')<p class="field-error-msg">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label for="lname" class="field-label">Last Name</label>
                                <input type="text" id="lname" name="lname"
                                       value="{{ old('lname') }}"
                                       placeholder="e.g. Santos"
                                       class="field-input {{ $errors->has('lname') ? 'is-error' : '' }}">
                                @error('lname')<p class="field-error-msg">{{ $message }}</p>@enderror
                            </div>
                        </div>

                        <div>
                            <label for="mname" class="field-label">Middle Name <span class="opt">(optional)</span></label>
                            <input type="text" id="mname" name="mname"
                                   value="{{ old('mname') }}"
                                   placeholder="e.g. Cruz"
                                   class="field-input {{ $errors->has('mname') ? 'is-error' : '' }}">
                            @error('mname')<p class="field-error-msg">{{ $message }}</p>@enderror
                        </div>

                    </div>
                </div>

                {{-- ---- Address ---- --}}
                <div>
                    <p class="section-title">Address</p>
                    <div class="space-y-5">

                        <div>
                            <label for="address_line_1" class="field-label">Street Address</label>
                            <input type="text" id="address_line_1" name="address_line_1"
                                   value="{{ old('address_line_1') }}"
                                   placeholder="e.g. 123 Rizal St."
                                   class="field-input {{ $errors->has('address_line_1') ? 'is-error' : '' }}">
                            @error('address_line_1')<p class="field-error-msg">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label for="address_line_2" class="field-label">Address Line 2 <span class="opt">(optional)</span></label>
                            <input type="text" id="address_line_2" name="address_line_2"
                                   value="{{ old('address_line_2') }}"
                                   placeholder="Barangay, unit, floor, etc."
                                   class="field-input {{ $errors->has('address_line_2') ? 'is-error' : '' }}">
                            @error('address_line_2')<p class="field-error-msg">{{ $message }}</p>@enderror
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <div>
                                <label for="city" class="field-label">City / Municipality</label>
                                <input type="text" id="city" name="city"
                                       value="{{ old('city') }}"
                                       placeholder="e.g. Tagbilaran City"
                                       class="field-input {{ $errors->has('city') ? 'is-error' : '' }}">
                                @error('city')<p class="field-error-msg">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label for="state_province" class="field-label">Province / State</label>
                                <input type="text" id="state_province" name="state_province"
                                       value="{{ old('state_province') }}"
                                       placeholder="e.g. Bohol"
                                       class="field-input {{ $errors->has('state_province') ? 'is-error' : '' }}">
                                @error('state_province')<p class="field-error-msg">{{ $message }}</p>@enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <div>
                                <label for="postal_code" class="field-label">Postal / ZIP Code</label>
                                <input type="text" id="postal_code" name="postal_code"
                                       value="{{ old('postal_code') }}"
                                       placeholder="e.g. 6300"
                                       class="field-input {{ $errors->has('postal_code') ? 'is-error' : '' }}">
                                @error('postal_code')<p class="field-error-msg">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label for="country" class="field-label">Country</label>
                                <input type="text" id="country" name="country"
                                       value="{{ old('country', 'Philippines') }}"
                                       placeholder="e.g. Philippines"
                                       class="field-input {{ $errors->has('country') ? 'is-error' : '' }}">
                                @error('country')<p class="field-error-msg">{{ $message }}</p>@enderror
                            </div>
                        </div>

                    </div>
                </div>

                {{-- ---- Work Details ---- --}}
                <div>
                    <p class="section-title">Work Details</p>
                    <div class="space-y-5">

                        <div>
                            <label for="position" class="field-label">Position</label>
                            <input type="text" id="position" name="position"
                                   value="{{ old('position') }}"
                                   placeholder="e.g. Faculty, Principal, Admin Staff"
                                   class="field-input {{ $errors->has('position') ? 'is-error' : '' }}">
                            @error('position')<p class="field-error-msg">{{ $message }}</p>@enderror
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <div>
                                <label for="years_working" class="field-label">Years Working at HSST</label>
                                <input type="number" id="years_working" name="years_working"
                                       value="{{ old('years_working') }}"
                                       min="1" max="99"
                                       placeholder="e.g. 5"
                                       class="field-input {{ $errors->has('years_working') ? 'is-error' : '' }}">
                                @error('years_working')<p class="field-error-msg">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label for="contact_no" class="field-label">Contact Number <span class="opt">(optional)</span></label>
                                <input type="text" id="contact_no" name="contact_no"
                                       value="{{ old('contact_no') }}"
                                       placeholder="e.g. 09171234567"
                                       class="field-input {{ $errors->has('contact_no') ? 'is-error' : '' }}">
                                @error('contact_no')<p class="field-error-msg">{{ $message }}</p>@enderror
                            </div>
                        </div>

                        <div>
                            <label for="account_type" class="field-label">Account Type</label>
                            <select id="account_type" name="account_type"
                                    class="field-select {{ $errors->has('account_type') ? 'is-error' : '' }}">
                                <option value="">Select account type...</option>
                                <option value="staff"       {{ old('account_type') === 'staff'       ? 'selected' : '' }}>Staff</option>
                                <option value="employee"    {{ old('account_type') === 'employee'    ? 'selected' : '' }}>Employee</option>
                                <option value="ssps-member" {{ old('account_type') === 'ssps-member' ? 'selected' : '' }}>SSPS Member</option>
                            </select>
                            @error('account_type')<p class="field-error-msg">{{ $message }}</p>@enderror
                        </div>

                    </div>
                </div>

                {{-- ---- Account Setup ---- --}}
                <div>
                    <p class="section-title">Account Setup</p>
                    <div class="space-y-5">

                        <div>
                            <label for="email" class="field-label">Email Address</label>
                            <input type="email" id="email" name="email"
                                   value="{{ old('email') }}"
                                   placeholder="you@example.com"
                                   autocomplete="email"
                                   class="field-input {{ $errors->has('email') ? 'is-error' : '' }}">
                            <p class="mt-1.5 text-xs text-slate-400">Used for account notifications and recovery.</p>
                            @error('email')<p class="field-error-msg">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label for="password" class="field-label">Password</label>
                            <input type="password" id="password" name="password"
                                   autocomplete="new-password"
                                   placeholder="Min. 8 characters"
                                   class="field-input {{ $errors->has('password') ? 'is-error' : '' }}">
                            @error('password')<p class="field-error-msg">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label for="password_confirmation" class="field-label">Confirm Password</label>
                            <input type="password" id="password_confirmation" name="password_confirmation"
                                   autocomplete="new-password"
                                   placeholder="Re-enter your password"
                                   class="field-input">
                        </div>

                    </div>
                </div>

                {{-- ---- Submit ---- --}}
                <div class="pt-2 pb-8">
                    <button type="submit"
                            class="btn-royal inline-flex h-12 w-full sm:w-auto items-center justify-center gap-2 rounded-2xl px-8 text-sm font-bold">
                        Submit Registration
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/>
                        </svg>
                    </button>
                    <p class="mt-3 text-xs text-slate-400">
                        Are you an alumni?
                        <a href="{{ route('register') }}" class="font-semibold hover:underline" style="color: var(--royal-600);">
                            Alumni registration
                        </a>
                    </p>
                </div>

            </div>
        </form>

    </main>
</div>
