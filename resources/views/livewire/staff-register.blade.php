<style>
    :root {
        --royal-900: #0a1f5c;
        --royal-800: #0f2a7a;
        --royal-700: #153591;
        --royal-600: #1a3fa8;
        --royal-500: #2150c8;
        --gold-500:  #c4952a;
        --gold-400:  #d4a843;
    }

    body { font-family: "DM Sans", system-ui, sans-serif; }
    .font-display { font-family: "DM Serif Display", Georgia, serif; }

    .btn-royal {
        background: linear-gradient(135deg, var(--royal-600) 0%, var(--royal-800) 100%);
        box-shadow: 0 4px 20px rgba(21,53,145,0.35), inset 0 1px 0 rgba(255,255,255,0.12);
        transition: box-shadow 0.2s ease, transform 0.1s ease, filter 0.2s ease;
        color: white;
    }
    .btn-royal:hover  { filter: brightness(1.07); box-shadow: 0 8px 28px rgba(21,53,145,0.42), inset 0 1px 0 rgba(255,255,255,0.14); }
    .btn-royal:active { transform: translateY(1px); box-shadow: 0 2px 10px rgba(21,53,145,0.3); }
    .btn-royal:disabled { opacity: 0.7; cursor: not-allowed; filter: none; }

    .btn-ghost {
        background: white; border: 1px solid #e2e8f0; color: #475569;
        transition: background 0.15s ease, border-color 0.15s ease;
    }
    .btn-ghost:hover { background: #f8fafc; border-color: #cbd5e1; }

    .field-input {
        height: 3.25rem; width: 100%; border-radius: 1rem;
        border: 1px solid #e2e8f0; background: #f8fafc;
        padding-left: 1rem; padding-right: 1rem; font-size: 0.875rem;
        color: #0f172a; outline: none;
        transition: border-color 0.15s, box-shadow 0.15s, background 0.15s;
    }
    .field-input::placeholder { color: #94a3b8; }
    .field-input:hover:not(:focus) { border-color: #94a3b8; background: #fff; }
    .field-input:focus { border-color: var(--royal-600); background: #fff; box-shadow: 0 0 0 3px rgba(26,63,168,0.12); }
    .field-input.is-error { border-color: #ef4444; box-shadow: 0 0 0 3px rgba(239,68,68,0.1); }

    .field-textarea {
        width: 100%; border-radius: 1rem; border: 1px solid #e2e8f0;
        background: #f8fafc; padding: 0.75rem 1rem; font-size: 0.875rem;
        color: #0f172a; outline: none; resize: vertical; font-family: inherit;
        transition: border-color 0.15s, box-shadow 0.15s, background 0.15s;
    }
    .field-textarea::placeholder { color: #94a3b8; }
    .field-textarea:hover:not(:focus) { border-color: #94a3b8; background: #fff; }
    .field-textarea:focus { border-color: var(--royal-600); background: #fff; box-shadow: 0 0 0 3px rgba(26,63,168,0.12); }
    .field-textarea.is-error { border-color: #ef4444; box-shadow: 0 0 0 3px rgba(239,68,68,0.1); }

    .field-select {
        height: 3.25rem; width: 100%; border-radius: 1rem;
        border: 1px solid #e2e8f0; background: #f8fafc;
        padding: 0 2.5rem 0 1rem; font-size: 0.875rem; color: #0f172a;
        outline: none; appearance: none; cursor: pointer;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%2394a3b8' stroke-width='2'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' d='M19 9l-7 7-7-7'/%3E%3C/svg%3E");
        background-repeat: no-repeat; background-position: right 1rem center; background-size: 1rem;
        transition: border-color 0.15s, box-shadow 0.15s, background-color 0.15s;
    }
    .field-select:hover { border-color: #94a3b8; background-color: #fff; }
    .field-select:focus { border-color: var(--royal-600); background-color: #fff; box-shadow: 0 0 0 3px rgba(26,63,168,0.12); }
    .field-select.is-error { border-color: #ef4444; box-shadow: 0 0 0 3px rgba(239,68,68,0.1); }

    .field-label {
        display: block; font-size: 0.7rem; font-weight: 700;
        letter-spacing: 0.1em; text-transform: uppercase; color: #475569; margin-bottom: 0.5rem;
    }
    .field-label .opt { font-weight: 400; letter-spacing: normal; text-transform: none; color: #94a3b8; font-size: 0.7rem; }

    .field-error { margin-top: 0.4rem; font-size: 0.72rem; color: #dc2626; display: none; }

    .ornament-line { width: 40px; height: 2px; background: var(--gold-500); border-radius: 2px; }
    .gold-divider  { width: 48px; height: 2px; background: linear-gradient(90deg, var(--gold-500), transparent); border-radius: 2px; }

    .sidebar-quote::before {
        content: '\201C'; font-family: "DM Serif Display", Georgia, serif;
        font-size: 3.5rem; line-height: 0; color: var(--gold-500);
        opacity: 0.5; vertical-align: -1.4rem; margin-right: 0.1rem;
    }

    .progress-fill {
        transition: width 0.35s cubic-bezier(0.4,0,0.2,1);
        background: linear-gradient(90deg, var(--royal-600), var(--royal-500));
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

            <div id="stepNav" class="space-y-2.5"></div>

            <div class="mt-auto">
                <div class="gold-divider mb-4"></div>
                <p class="text-sm leading-7 italic" style="color: rgba(255,255,255,0.65);">
                    <span class="sidebar-quote"></span>Once a Holy Spirit family, always together.
                </p>
            </div>

            <div class="mt-6 pt-5" style="border-top: 1px solid rgba(255,255,255,0.1);">
                <p class="text-xs" style="color: rgba(255,255,255,0.55);">Already have an account?</p>
                <a href="{{ route('login') }}"
                   class="inline-flex items-center gap-1.5 mt-1 text-sm font-semibold hover:underline transition"
                   style="color: var(--gold-400);">
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
    <main class="flex-1 flex flex-col min-h-screen lg:min-h-0 bg-white lg:bg-transparent">

        {{-- Mobile header --}}
        <div class="lg:hidden flex-shrink-0"
             style="background: linear-gradient(160deg, var(--royal-700) 0%, var(--royal-900) 100%);">
            <div class="px-5 py-4 flex items-center justify-between">
                <button type="button" onclick="history.back()"
                        class="inline-flex items-center gap-1.5 text-sm font-semibold text-white/80 hover:text-white transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 18l-6-6 6-6"/>
                    </svg>
                    Back
                </button>
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

        {{-- Step header --}}
        <div class="flex-shrink-0 px-5 py-5 sm:px-8 lg:px-12 xl:px-16"
             style="border-bottom: 1px solid #e2e8f0; background: linear-gradient(180deg, #ffffff 0%, #f8fafc 100%);">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <p class="hidden lg:block text-xs font-bold uppercase tracking-[0.15em] mb-2"
                       style="color: var(--gold-500);">2026 Reunion</p>
                    <p id="eyebrow" class="text-xs font-bold uppercase tracking-[0.12em] mb-1.5 lg:hidden"
                       style="color: var(--royal-600);">Step 1 of 4</p>
                    <h2 id="stepTitle" class="font-display text-slate-900 leading-tight tracking-[-0.02em]"
                        style="font-size: clamp(1.6rem, 2.8vw, 2.1rem);">Personal information</h2>
                    <p id="stepDesc" class="mt-2 text-sm leading-6 text-slate-500">
                        Tell us your name so we know who you are.
                    </p>
                </div>
                <button type="button" onclick="history.back()"
                        class="btn-ghost hidden lg:inline-flex items-center gap-2 rounded-xl px-3 py-2 text-sm font-semibold shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 18l-6-6 6-6"/>
                    </svg>
                    Back
                </button>
            </div>
            <div class="mt-5 h-1.5 w-full overflow-hidden rounded-full bg-slate-200">
                <div id="progressFill" class="progress-fill h-full rounded-full" style="width: 25%;"></div>
            </div>
        </div>

        {{-- Livewire form --}}
        <form wire:submit="save" novalidate class="flex flex-col flex-1 lg:min-h-screen">

            {{-- Hidden real submit — JS clicks this on the final step so Livewire's wire:submit intercepts correctly --}}
            <button type="submit" id="realSubmit" tabindex="-1" aria-hidden="true"
                    style="position:absolute;width:1px;height:1px;overflow:hidden;opacity:0;pointer-events:none;"></button>

            <div class="flex-1 overflow-y-auto px-5 py-7 sm:px-8 lg:px-12 xl:px-16 lg:py-10">

                {{-- ===================================================== --}}
                {{-- PANEL 1 — Personal Information                         --}}
                {{-- ===================================================== --}}
                <section id="panel-1" class="panel">
                    <div class="max-w-2xl">
                        <div class="grid gap-5 sm:grid-cols-3">

                            <div>
                                <label for="fname" class="field-label">First name</label>
                                <input type="text" id="fname" wire:model="fname"
                                       placeholder="First name" autocomplete="given-name"
                                       class="field-input @error('fname') is-error @enderror">
                                <p id="err-fname" class="field-error"></p>
                                @error('fname') <p class="field-error" style="display:block;">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label for="lname" class="field-label">Last name</label>
                                <input type="text" id="lname" wire:model="lname"
                                       placeholder="Last name" autocomplete="family-name"
                                       class="field-input @error('lname') is-error @enderror">
                                <p id="err-lname" class="field-error"></p>
                                @error('lname') <p class="field-error" style="display:block;">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label for="mname" class="field-label">
                                    Middle name <span class="opt">(optional)</span>
                                </label>
                                <input type="text" id="mname" wire:model="mname"
                                       placeholder="Middle name" autocomplete="additional-name"
                                       class="field-input">
                            </div>

                        </div>
                    </div>
                </section>

                {{-- ===================================================== --}}
                {{-- PANEL 2 — Address                                       --}}
                {{-- ===================================================== --}}
                <section id="panel-2" class="panel" style="display:none;">
                    <div class="max-w-2xl space-y-5">

                        <div>
                            <label for="address_line_1" class="field-label">Street address</label>
                            <textarea id="address_line_1" wire:model="address_line_1"
                                      placeholder="House/Unit no., street name, barangay or district"
                                      class="field-textarea @error('address_line_1') is-error @enderror"
                                      style="min-height:5rem;"></textarea>
                            <p id="err-addr1" class="field-error"></p>
                            @error('address_line_1') <p class="field-error" style="display:block;">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="address_line_2" class="field-label">
                                Address line 2 <span class="opt">(optional)</span>
                            </label>
                            <input type="text" id="address_line_2" wire:model="address_line_2"
                                   placeholder="Subdivision, building, floor, unit, etc."
                                   class="field-input">
                        </div>

                        <div class="grid gap-5 sm:grid-cols-2">
                            <div>
                                <label for="city" class="field-label">City / Municipality</label>
                                <input type="text" id="city" wire:model="city"
                                       placeholder="City or municipality" autocomplete="address-level2"
                                       class="field-input @error('city') is-error @enderror">
                                <p id="err-city" class="field-error"></p>
                                @error('city') <p class="field-error" style="display:block;">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label for="state_province" class="field-label">Province / State</label>
                                <input type="text" id="state_province" wire:model="state_province"
                                       placeholder="Province or state" autocomplete="address-level1"
                                       class="field-input @error('state_province') is-error @enderror">
                                <p id="err-province" class="field-error"></p>
                                @error('state_province') <p class="field-error" style="display:block;">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label for="postal_code" class="field-label">Postal / ZIP code</label>
                                <input type="text" id="postal_code" wire:model="postal_code"
                                       placeholder="Postal or ZIP code" autocomplete="postal-code"
                                       class="field-input @error('postal_code') is-error @enderror">
                                <p id="err-postal" class="field-error"></p>
                                @error('postal_code') <p class="field-error" style="display:block;">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label for="country" class="field-label">Country</label>
                                <input type="text" id="country" wire:model="country"
                                       autocomplete="country-name"
                                       class="field-input @error('country') is-error @enderror">
                                <p id="err-country" class="field-error"></p>
                                @error('country') <p class="field-error" style="display:block;">{{ $message }}</p> @enderror
                            </div>
                        </div>

                    </div>
                </section>

                {{-- ===================================================== --}}
                {{-- PANEL 3 — Work Details                                  --}}
                {{-- ===================================================== --}}
                <section id="panel-3" class="panel" style="display:none;">
                    <div class="max-w-2xl space-y-5">

                        <div>
                            <label for="position" class="field-label">Position</label>
                            <input type="text" id="position" wire:model="position"
                                   placeholder="e.g. Faculty, Principal, Admin Staff"
                                   class="field-input @error('position') is-error @enderror">
                            <p id="err-position" class="field-error"></p>
                            @error('position') <p class="field-error" style="display:block;">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="years_working" class="field-label">Years working at HSST</label>
                            <input type="number" id="years_working" wire:model="years_working"
                                   min="1" max="99" placeholder="e.g. 5"
                                   class="field-input @error('years_working') is-error @enderror">
                            <p id="err-years" class="field-error"></p>
                            @error('years_working') <p class="field-error" style="display:block;">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="account_type" class="field-label">Account type</label>
                            <select id="account_type" wire:model="account_type"
                                    class="field-select @error('account_type') is-error @enderror">
                                <option value="">Select account type...</option>
                                <option value="staff">Staff</option>
                                <option value="employee">Employee</option>
                                <option value="ssps-member">SSPS Member</option>
                            </select>
                            <p id="err-account-type" class="field-error"></p>
                            @error('account_type') <p class="field-error" style="display:block;">{{ $message }}</p> @enderror
                        </div>

                    </div>
                </section>

                {{-- ===================================================== --}}
                {{-- PANEL 4 — Account Credentials                          --}}
                {{-- ===================================================== --}}
                <section id="panel-4" class="panel" style="display:none;">
                    <div class="max-w-2xl space-y-5">

                        <div>
                            <label for="email" class="field-label">Email address</label>
                            <input type="email" id="email" wire:model="email"
                                   placeholder="you@example.com" autocomplete="email"
                                   class="field-input @error('email') is-error @enderror">
                            <p class="mt-1.5 text-xs text-slate-400">For account notifications and recovery.</p>
                            <p id="err-email" class="field-error"></p>
                            @error('email') <p class="field-error" style="display:block;">{{ $message }}</p> @enderror
                        </div>

                        <div class="grid gap-5 sm:grid-cols-2">
                            <div>
                                <label for="password" class="field-label">Password</label>
                                <div class="relative">
                                    <input type="password" id="password" wire:model="password"
                                           placeholder="Create a password" autocomplete="new-password"
                                           class="field-input @error('password') is-error @enderror"
                                           style="padding-right:3rem;">
                                    <button type="button" id="togglePw" aria-label="Toggle password visibility"
                                            class="absolute inset-y-0 right-0 flex items-center pr-4 text-slate-400 hover:text-slate-600 transition-colors">
                                        <svg id="eyeOpen" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        </svg>
                                        <svg id="eyeClosed" style="display:none;" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88"/>
                                        </svg>
                                    </button>
                                </div>
                                <p id="err-password" class="field-error"></p>
                                @error('password') <p class="field-error" style="display:block;">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label for="password_confirmation" class="field-label">Confirm password</label>
                                <input type="password" id="password_confirmation" wire:model="password_confirmation"
                                       placeholder="Re-enter your password" autocomplete="new-password"
                                       class="field-input">
                                <p id="err-confirm" class="field-error"></p>
                            </div>
                        </div>

                        <div class="rounded-2xl px-5 py-4 text-sm leading-6"
                             style="background:#eff6ff; border:1px solid #bfdbfe; color:#1e40af;">
                            By registering, you confirm that you are a current or former employee, staff member,
                            or SSPS personnel of Holy Spirit School of Tagbilaran. Your account will be reviewed
                            before activation. By registering, you also agree to our
                            <a href="{{ route('privacy') }}" target="_blank" class="underline font-semibold hover:opacity-80">Privacy Policy</a>.
                        </div>

                    </div>
                </section>

            </div>

            {{-- Footer actions --}}
            <div class="flex-shrink-0 px-5 py-4 sm:px-8 lg:px-12 xl:px-16"
                 style="border-top: 1px solid #e2e8f0; background: #f8fafc;">
                <div class="max-w-2xl flex items-center justify-between gap-3">

                    <button type="button" id="btnBack" onclick="prevStep()"
                            class="btn-ghost h-11 rounded-2xl px-5 text-sm font-semibold"
                            style="display:none;">
                        Back
                    </button>

                    <div class="flex items-center gap-4 ml-auto">
                        <a href="{{ route('login') }}"
                           class="hidden sm:inline text-sm font-semibold hover:underline transition"
                           style="color: var(--royal-600);">
                            Already have an account?
                        </a>

                        <button type="button" id="btnNext" onclick="nextStep()"
                                wire:loading.attr="disabled"
                                wire:target="save"
                                class="btn-royal inline-flex h-11 items-center justify-center gap-2 rounded-2xl px-6 text-sm font-bold">
                            <span id="btnNextLabel">Continue</span>
                            <svg id="btnNextArrow" class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/>
                            </svg>
                            <svg wire:loading wire:target="save" class="w-4 h-4 animate-spin" style="display:none;" fill="none" viewBox="0 0 24 24">
                                <circle cx="12" cy="12" r="10" stroke="white" stroke-width="2" opacity="0.3"/>
                                <path fill="white" d="M4 12a8 8 0 018-8v2a6 6 0 00-6 6H4z"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <p class="sm:hidden mt-4 text-center text-sm text-slate-500">
                    Already have an account?
                    <a href="{{ route('login') }}" class="font-bold hover:underline" style="color: var(--royal-600);">Sign in</a>
                </p>
            </div>

        </form>

        {{-- Page footer --}}
        <div class="flex-shrink-0 px-5 py-4 text-center lg:text-left lg:px-12 xl:px-16"
             style="border-top: 1px solid #e2e8f0;">
            <p class="text-xs text-slate-400">
                &copy; {{ date('Y') }} Holy Spirit School of Tagbilaran &mdash; Alumni Portal. All rights reserved.
                &ensp;&bull;&ensp;
                Are you an alumni?
                <a href="{{ route('register') }}" class="font-semibold hover:underline" style="color: var(--royal-600);">
                    Alumni registration
                </a>
            </p>
        </div>

    </main>
</div>

<script>
const STEPS = [
    { short: 'Profile',  sub: 'Name details',     title: 'Personal information', desc: 'Tell us your name so we know who you are.' },
    { short: 'Address',  sub: 'Current location', title: 'Address details',       desc: 'Provide your current mailing or residential address.' },
    { short: 'Work',     sub: 'Role at HSST',     title: 'Work details',          desc: "Tell us your role and how long you've been at HSST." },
    { short: 'Account',  sub: 'Login & security', title: 'Account setup',         desc: 'Set up your email and a secure password.' },
];

let currentStep = 1;
const totalSteps = STEPS.length;

function buildNav() {
    const nav = document.getElementById('stepNav');
    if (!nav) return;
    nav.innerHTML = '';
    STEPS.forEach((s, i) => {
        const n        = i + 1;
        const isDone   = n < currentStep;
        const isActive = n === currentStep;

        const wrap = isDone
            ? 'background:rgba(196,149,42,0.12);border:1px solid rgba(196,149,42,0.3);'
            : isActive
            ? 'background:rgba(255,255,255,0.14);border:1px solid rgba(255,255,255,0.22);'
            : 'background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.1);';

        const dotBg = isDone
            ? 'background:rgba(196,149,42,0.85);color:#fff;'
            : isActive
            ? 'background:rgba(255,255,255,0.18);color:#fff;border:1px solid rgba(255,255,255,0.3);'
            : 'background:rgba(255,255,255,0.08);color:rgba(255,255,255,0.55);border:1px solid rgba(255,255,255,0.12);';

        const subColor = isDone ? 'rgba(196,149,42,0.8)' : isActive ? 'rgba(255,255,255,0.65)' : 'rgba(255,255,255,0.4)';
        const dotLabel = isDone ? '✓' : n;

        nav.innerHTML += `
            <div style="display:flex;align-items:center;gap:0.75rem;border-radius:0.875rem;padding:0.7rem 1rem;${wrap}">
                <div style="flex-shrink:0;width:2rem;height:2rem;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:0.8rem;font-weight:700;${dotBg}">${dotLabel}</div>
                <div>
                    <p style="font-size:0.8rem;font-weight:700;color:#fff;line-height:1.2;">${s.short}</p>
                    <p style="font-size:0.7rem;color:${subColor};margin-top:0.1rem;">${s.sub}</p>
                </div>
            </div>`;
    });
}

function updateHeader() {
    const s = STEPS[currentStep - 1];
    const eyebrow = document.getElementById('eyebrow');
    if (eyebrow) eyebrow.textContent = `Step ${currentStep} of ${totalSteps}`;
    document.getElementById('stepTitle').textContent = s.title;
    document.getElementById('stepDesc').textContent  = s.desc;
    document.getElementById('progressFill').style.width = `${(currentStep / totalSteps) * 100}%`;
    document.getElementById('btnBack').style.display    = currentStep === 1 ? 'none' : 'inline-flex';
    document.getElementById('btnNextLabel').textContent = currentStep === totalSteps ? 'Submit Registration' : 'Continue';
    document.getElementById('btnNextArrow').style.display = currentStep === totalSteps ? 'none' : 'inline-block';
}

function showPanel(n) {
    document.querySelectorAll('.panel').forEach(p => p.style.display = 'none');
    const el = document.getElementById('panel-' + n);
    if (el) el.style.display = 'block';
}

function clearErrors() {
    document.querySelectorAll('.field-error[id]').forEach(el => {
        el.textContent = '';
        el.style.display = 'none';
    });
    document.querySelectorAll('.field-input,.field-textarea,.field-select').forEach(el => {
        el.classList.remove('is-error');
    });
}

function showError(fieldId, errId, msg) {
    const f = document.getElementById(fieldId);
    const e = document.getElementById(errId);
    if (f) f.classList.add('is-error');
    if (e) { e.textContent = msg; e.style.display = 'block'; }
}

function validateStep(step) {
    clearErrors();
    let ok = true;
    if (step === 1) {
        if (!document.getElementById('fname').value.trim())
            { showError('fname', 'err-fname', 'First name is required.'); ok = false; }
        if (!document.getElementById('lname').value.trim())
            { showError('lname', 'err-lname', 'Last name is required.'); ok = false; }
    }
    if (step === 2) {
        if (!document.getElementById('address_line_1').value.trim())
            { showError('address_line_1','err-addr1',   'Street address is required.'); ok = false; }
        if (!document.getElementById('city').value.trim())
            { showError('city',          'err-city',    'City / municipality is required.'); ok = false; }
        if (!document.getElementById('state_province').value.trim())
            { showError('state_province','err-province','Province / state is required.'); ok = false; }
        if (!document.getElementById('postal_code').value.trim())
            { showError('postal_code',   'err-postal',  'Postal / ZIP code is required.'); ok = false; }
        if (!document.getElementById('country').value.trim())
            { showError('country',       'err-country', 'Country is required.'); ok = false; }
    }
    if (step === 3) {
        if (!document.getElementById('position').value.trim())
            { showError('position',     'err-position',     'Position is required.'); ok = false; }
        if (!document.getElementById('years_working').value.trim())
            { showError('years_working','err-years',        'Years working is required.'); ok = false; }
        if (!document.getElementById('account_type').value)
            { showError('account_type', 'err-account-type','Please select an account type.'); ok = false; }
    }
    if (step === 4) {
        const email = document.getElementById('email').value.trim();
        const pw    = document.getElementById('password').value;
        const pw2   = document.getElementById('password_confirmation').value;
        if (!email || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email))
            { showError('email',    'err-email',    'Please enter a valid email address.'); ok = false; }
        if (!pw)
            { showError('password', 'err-password', 'Password is required.'); ok = false; }
        if (pw && pw2 && pw !== pw2)
            { showError('password_confirmation','err-confirm','Passwords do not match.'); ok = false; }
    }
    return ok;
}

function nextStep() {
    if (!validateStep(currentStep)) {
        const btn = document.getElementById('btnNext');
        btn.style.transform = 'translateX(-4px)';
        setTimeout(() => btn.style.transform = 'translateX(4px)', 80);
        setTimeout(() => btn.style.transform = '', 160);
        return;
    }
    if (currentStep < totalSteps) {
        currentStep++;
        buildNav();
        updateHeader();
        showPanel(currentStep);
    } else {
        document.getElementById('realSubmit').click();
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

document.getElementById('togglePw').addEventListener('click', function () {
    const input = document.getElementById('password');
    const isText = input.type === 'text';
    input.type = isText ? 'password' : 'text';
    document.getElementById('eyeOpen').style.display   = isText ? 'block' : 'none';
    document.getElementById('eyeClosed').style.display = isText ? 'none'  : 'block';
});

buildNav();
updateHeader();
showPanel(1);
</script>
