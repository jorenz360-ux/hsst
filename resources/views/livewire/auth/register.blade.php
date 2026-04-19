{{-- resources/views/livewire/auth/register.blade.php --}}
<!doctype html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Create Account - HSST Alumni Portal</title>

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

        /* Premium button */
        .btn-royal {
            background: linear-gradient(135deg, var(--royal-600) 0%, var(--royal-800) 100%);
            box-shadow: 0 4px 20px rgba(21,53,145,0.35), inset 0 1px 0 rgba(255,255,255,0.12);
            transition: box-shadow 0.2s ease, transform 0.1s ease, filter 0.2s ease;
            color: white;
        }
        .btn-royal:hover { filter: brightness(1.07); box-shadow: 0 8px 28px rgba(21,53,145,0.42), inset 0 1px 0 rgba(255,255,255,0.14); }
        .btn-royal:active { transform: translateY(1px); box-shadow: 0 2px 10px rgba(21,53,145,0.3); }
        .btn-royal:disabled { opacity: 0.7; cursor: not-allowed; filter: none; }

        /* Ghost back button */
        .btn-ghost {
            background: white;
            border: 1px solid #e2e8f0;
            color: #475569;
            transition: background 0.15s ease, border-color 0.15s ease;
        }
        .btn-ghost:hover { background: #f8fafc; border-color: #cbd5e1; }

        /* Inputs */
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
        .field-input.with-icon-left { padding-left: 2.75rem; }
        .field-input-textarea {
            width: 100%;
            border-radius: 1rem;
            border: 1px solid #e2e8f0;
            background: #f8fafc;
            padding: 0.75rem 1rem;
            font-size: 0.875rem;
            color: #0f172a;
            outline: none;
            transition: border-color 0.15s, box-shadow 0.15s, background 0.15s;
            resize: vertical;
            font-family: inherit;
        }
        .field-input-textarea::placeholder { color: #94a3b8; }
        .field-input-textarea:hover:not(:focus) { border-color: #94a3b8; background: #ffffff; }
        .field-input-textarea:focus {
            border-color: var(--royal-600);
            background: #ffffff;
            box-shadow: 0 0 0 3px rgba(26,63,168,0.12);
        }
        .field-input-textarea.is-error { border-color: #ef4444; box-shadow: 0 0 0 3px rgba(239,68,68,0.1); }

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

        /* Field label */
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

        /* Error message */
        .field-error-msg {
            margin-top: 0.4rem;
            font-size: 0.72rem;
            line-height: 1.4;
            color: #dc2626;
            display: flex;
            align-items: center;
            gap: 0.35rem;
        }

        /* Sidebar */
        .trust-badge {
            background: rgba(255,255,255,0.08);
            border: 1px solid rgba(255,255,255,0.14);
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

        /* Radio / checkbox card */
        .choice-card {
            border: 1px solid #e2e8f0;
            border-radius: 1rem;
            background: #fff;
            padding: 0.85rem 1rem;
            cursor: pointer;
            transition: border-color 0.15s, background 0.15s;
        }
        .choice-card:hover { border-color: #93c5fd; background: #eff6ff; }
        .choice-card:has(input:checked) {
            border-color: var(--royal-600);
            background: #eff6ff;
            box-shadow: 0 0 0 3px rgba(26,63,168,0.08);
        }

        /* Education level card */
        .edu-card {
            border: 1px solid #e2e8f0;
            border-radius: 1.25rem;
            background: #f8fafc;
            padding: 1.25rem;
        }
        .edu-card .include-toggle {
            border: 1px solid #e2e8f0;
            border-radius: 0.75rem;
            background: white;
            padding: 0.4rem 0.85rem;
            font-size: 0.8rem;
            font-weight: 600;
            color: #475569;
            cursor: pointer;
            transition: border-color 0.15s, background 0.15s;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        /* Progress bar */
        .progress-fill {
            transition: width 0.35s cubic-bezier(0.4,0,0.2,1);
            background: linear-gradient(90deg, var(--royal-600), var(--royal-500));
        }

        /* Page background */
        .page-bg {
            background-color: #f0f4fb;
            background-image:
                radial-gradient(circle at 80% 10%, rgba(26,63,168,0.07) 0%, transparent 45%),
                radial-gradient(circle at 10% 90%, rgba(196,149,42,0.05) 0%, transparent 40%);
        }

        input[type="radio"], input[type="checkbox"] {
            accent-color: var(--royal-600);
        }
    </style>
</head>
<body class="h-full antialiased page-bg">

@php
    $committeeOptions = \App\Models\Committee::query()
        ->where('is_active', true)
        ->orderBy('name')
        ->get();

    $oldVolunteerInterest = old('volunteer_interest', 'later');
    $oldCommittees = old('committees', []);
@endphp

<div class="min-h-screen flex flex-col lg:flex-row">

    {{-- ================================================================== --}}
    {{-- SIDEBAR                                                              --}}
    {{-- ================================================================== --}}
    <aside class="hidden lg:flex lg:flex-col lg:w-[340px] xl:w-[390px] flex-shrink-0 relative overflow-hidden"
           style="background: linear-gradient(160deg, var(--royal-700) 0%, var(--royal-900) 100%);">

        {{-- Background overlays --}}
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
                    <p class="text-xs mt-0.5 font-medium" style="color: var(--gold-400);">Alumni Portal</p>
                </div>
            </div>

            {{-- Headline --}}
            <div class="mb-8">
                <div class="ornament-line mb-5"></div>
                <h1 class="font-display text-white leading-tight tracking-[-0.02em]"
                    style="font-size: clamp(1.8rem, 2.6vw, 2.4rem);">
                    Join your<br><em>alumni family.</em>
                </h1>
                <p class="mt-4 text-sm leading-7" style="color: rgba(255,255,255,0.72); max-width: 28ch;">
                    Complete your account to access announcements, reunion events,
                    and stay connected with your batch.
                </p>
            </div>

            {{-- Step navigation (built by JS) --}}
            <div id="stepNav" class="space-y-2.5"></div>

            {{-- Legacy quote --}}
            <div class="mt-auto">
                <div class="gold-divider mb-4"></div>
                <p class="text-sm leading-7 italic" style="color: rgba(255,255,255,0.65);">
                    <span class="sidebar-quote"></span>Once a Holy Spirit student,
                    always part of the family.
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
    <main class="flex-1 flex flex-col min-h-screen lg:min-h-0 bg-white lg:bg-transparent">

        {{-- ---- Mobile Header ------------------------------------------- --}}
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
                        <p class="text-xs font-medium" style="color: var(--gold-400);">Alumni Portal</p>
                    </div>
                </div>
            </div>
            <div class="px-5 pb-6 pt-1">
                <h2 class="font-display text-white text-2xl leading-tight">Create your alumni account.</h2>
                <p class="mt-1.5 text-sm" style="color: rgba(255,255,255,0.65);">Complete the steps below to register.</p>
            </div>
        </div>

        {{-- ---- Form ---------------------------------------------------- --}}
        <form method="POST" action="{{ route('register') }}" id="registerForm" novalidate
              class="flex flex-col flex-1 lg:min-h-screen">
            @csrf

            {{-- Step header --}}
            <div class="flex-shrink-0 px-5 py-5 sm:px-8 lg:px-12 xl:px-16"
                 style="border-bottom: 1px solid #e2e8f0; background: linear-gradient(180deg, #ffffff 0%, #f8fafc 100%);">

                <div class="flex items-start justify-between gap-4">
                    <div>
                        {{-- Desktop heading only --}}
                        <p class="hidden lg:block text-xs font-bold uppercase tracking-[0.15em] mb-2"
                           style="color: var(--gold-500);">Alumni Portal</p>

                        <p id="eyebrow" class="text-xs font-bold uppercase tracking-[0.12em] mb-1.5 lg:hidden"
                           style="color: var(--royal-600);">Step 1 of 5</p>

                        <h2 id="stepTitle"
                            class="font-display text-slate-900 leading-tight tracking-[-0.02em]"
                            style="font-size: clamp(1.6rem, 2.8vw, 2.1rem);">
                            Personal information
                        </h2>

                        <p id="stepDesc" class="mt-2 text-sm leading-6 text-slate-500">
                            Tell us about yourself - your name, contact number, and occupation.
                        </p>
                    </div>

                    <button
                        type="button"
                        onclick="history.back()"
                        class="btn-ghost hidden lg:inline-flex items-center gap-2 rounded-xl px-3 py-2 text-sm font-semibold shadow-sm"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 18l-6-6 6-6"/>
                        </svg>
                        Back
                    </button>
                </div>

                {{-- Progress bar --}}
                <div class="mt-5 h-1.5 w-full overflow-hidden rounded-full bg-slate-200">
                    <div id="progressFill" class="progress-fill h-full rounded-full" style="width: 20%;"></div>
                </div>
            </div>

            {{-- Panels body --}}
            <div class="flex-1 overflow-y-auto px-5 py-7 sm:px-8 lg:px-12 xl:px-16 lg:py-10">

                {{-- ===================================================== --}}
                {{-- PANEL 1 - Profile & Alumni Levels                      --}}
                {{-- ===================================================== --}}
                @php
                    $batchOptions = \App\Models\Batch::query()
                        ->orderByRaw("FIELD(level, 'elementary', 'highschool', 'college')")
                        ->orderByDesc('yeargrad')
                        ->get()
                        ->groupBy('level');

                    $educationLevels = [
                        'elementary' => 'Elementary',
                        'highschool' => 'High School',
                        'college'    => 'College',
                    ];
                @endphp

                <section id="panel-1" class="panel">
                    <div class="max-w-3xl space-y-6">

                        {{-- Personal details grid --}}
                        <div class="grid gap-5 sm:grid-cols-2">

                            <div>
                                <label for="prefix" class="field-label">
                                    Prefix <span class="opt">(optional)</span>
                                </label>
                                <select id="prefix" name="prefix" class="field-select">
                                    <option value="">Select prefix</option>
                                    <option value="Mr."   {{ old('prefix') === 'Mr.'   ? 'selected' : '' }}>Mr.</option>
                                    <option value="Mrs."  {{ old('prefix') === 'Mrs.'  ? 'selected' : '' }}>Mrs.</option>
                                    <option value="Ms."   {{ old('prefix') === 'Ms.'   ? 'selected' : '' }}>Ms.</option>
                                    <option value="Dr."   {{ old('prefix') === 'Dr.'   ? 'selected' : '' }}>Dr.</option>
                                    <option value="Atty." {{ old('prefix') === 'Atty.' ? 'selected' : '' }}>Atty.</option>
                                    <option value="Engr." {{ old('prefix') === 'Engr.' ? 'selected' : '' }}>Engr.</option>
                                    <option value="Rev."  {{ old('prefix') === 'Rev.'  ? 'selected' : '' }}>Rev.</option>
                                    <option value="Hon."  {{ old('prefix') === 'Hon.'  ? 'selected' : '' }}>Hon.</option>
                                </select>
                            </div>

                            <div>
                                <label for="suffix" class="field-label">
                                    Suffix <span class="opt">(optional)</span>
                                </label>
                                <select id="suffix" name="suffix" class="field-select">
                                    <option value="">Select suffix</option>
                                    <option value="Jr."  {{ old('suffix') === 'Jr.'  ? 'selected' : '' }}>Jr.</option>
                                    <option value="Sr."  {{ old('suffix') === 'Sr.'  ? 'selected' : '' }}>Sr.</option>
                                    <option value="II"   {{ old('suffix') === 'II'   ? 'selected' : '' }}>II</option>
                                    <option value="III"  {{ old('suffix') === 'III'  ? 'selected' : '' }}>III</option>
                                    <option value="IV"   {{ old('suffix') === 'IV'   ? 'selected' : '' }}>IV</option>
                                </select>
                            </div>

                            <div>
                                <label for="fname" class="field-label">First name</label>
                                <input
                                    type="text" id="fname" name="fname"
                                    value="{{ old('fname') }}"
                                    placeholder="First name"
                                    autocomplete="given-name"
                                    class="field-input {{ $errors->has('fname') ? 'is-error' : '' }}"
                                >
                                <p id="err-fname" class="field-error mt-2 hidden text-xs leading-5 text-red-600">
                                    @error('fname'){{ $message }}@enderror
                                </p>
                            </div>

                            <div>
                                <label for="lname" class="field-label">Last name</label>
                                <input
                                    type="text" id="lname" name="lname"
                                    value="{{ old('lname') }}"
                                    placeholder="Last name"
                                    autocomplete="family-name"
                                    class="field-input {{ $errors->has('lname') ? 'is-error' : '' }}"
                                >
                                <p id="err-lname" class="field-error mt-2 hidden text-xs leading-5 text-red-600">
                                    @error('lname'){{ $message }}@enderror
                                </p>
                            </div>

                            <div>
                                <label for="mname" class="field-label">
                                    Middle name <span class="opt">(optional)</span>
                                </label>
                                <input
                                    type="text" id="mname" name="mname"
                                    value="{{ old('mname') }}"
                                    placeholder="Middle name"
                                    autocomplete="additional-name"
                                    class="field-input"
                                >
                            </div>

                            <div>
                                <label for="cellphone" class="field-label">Cellphone #</label>
                                <input
                                    type="text" id="cellphone" name="cellphone"
                                    value="{{ old('cellphone') }}"
                                    placeholder="e.g. 09171234567"
                                    autocomplete="tel"
                                    class="field-input {{ $errors->has('cellphone') ? 'is-error' : '' }}"
                                >
                                <p id="err-cellphone" class="field-error mt-2 hidden text-xs leading-5 text-red-600">
                                    @error('cellphone'){{ $message }}@enderror
                                </p>
                            </div>

                            <div class="sm:col-span-2">
                                <label for="occupation" class="field-label">
                                    Occupation <span class="opt">(optional)</span>
                                </label>
                                <input
                                    type="text" id="occupation" name="occupation"
                                    value="{{ old('occupation') }}"
                                    placeholder="e.g. Teacher, Engineer, Nurse"
                                    autocomplete="organization-title"
                                    class="field-input"
                                >
                            </div>
                        </div>

                    </div>
                </section>

                {{-- ===================================================== --}}
                {{-- PANEL 2 - Alumni Level                                  --}}
                {{-- ===================================================== --}}
                <section id="panel-2" class="panel hidden">
                    <div class="max-w-3xl space-y-6">

                        <div class="space-y-4">
                            @foreach ($educationLevels as $levelKey => $levelLabel)
                                @php
                                    $enabled             = old("educations.$levelKey.enabled");
                                    $didGraduate         = old("educations.$levelKey.did_graduate", '1');
                                    $batchId             = old("educations.$levelKey.batch_id");
                                    $schoolYearAttended  = old("educations.$levelKey.school_year_attended");
                                @endphp

                                <div class="edu-card">
                                    <div class="flex items-start justify-between gap-4 mb-3">
                                        <div>
                                            <h4 class="text-sm font-bold text-slate-900">{{ $levelLabel }}</h4>
                                            <p class="text-xs text-slate-500 mt-0.5">
                                                Add your {{ strtolower($levelLabel) }} batch details.
                                            </p>
                                        </div>
                                        <label class="include-toggle">
                                            <input
                                                type="checkbox"
                                                name="educations[{{ $levelKey }}][enabled]"
                                                value="1"
                                                class="h-4 w-4 rounded"
                                                {{ $enabled ? 'checked' : '' }}
                                                onchange="toggleEducationSection('{{ $levelKey }}')"
                                            >
                                            Include
                                        </label>
                                    </div>

                                    <div id="education-fields-{{ $levelKey }}" class="{{ $enabled ? '' : 'hidden' }}">
                                        <div class="grid gap-4 sm:grid-cols-2 pt-3" style="border-top: 1px solid #e2e8f0;">

                                            <div>
                                                <label class="field-label">Did you graduate at this level?</label>
                                                <div class="grid gap-2 sm:grid-cols-2">
                                                    <label class="choice-card flex items-start gap-3">
                                                        <input
                                                            type="radio"
                                                            name="educations[{{ $levelKey }}][did_graduate]"
                                                            value="1"
                                                            class="mt-0.5 h-4 w-4"
                                                            {{ $didGraduate == '1' ? 'checked' : '' }}
                                                            onchange="toggleEducationGraduateFields('{{ $levelKey }}')"
                                                        >
                                                        <div>
                                                            <p class="text-sm font-bold text-slate-900">Yes</p>
                                                            <p class="text-xs text-slate-500">I graduated.</p>
                                                        </div>
                                                    </label>
                                                    <label class="choice-card flex items-start gap-3">
                                                        <input
                                                            type="radio"
                                                            name="educations[{{ $levelKey }}][did_graduate]"
                                                            value="0"
                                                            class="mt-0.5 h-4 w-4"
                                                            {{ $didGraduate === '0' ? 'checked' : '' }}
                                                            onchange="toggleEducationGraduateFields('{{ $levelKey }}')"
                                                        >
                                                        <div>
                                                            <p class="text-sm font-bold text-slate-900">No</p>
                                                            <p class="text-xs text-slate-500">I attended only.</p>
                                                        </div>
                                                    </label>
                                                </div>
                                            </div>

                                            <div id="batch-wrap-{{ $levelKey }}">
                                                <label for="batch_id_{{ $levelKey }}" class="field-label">Batch</label>
                                                <select
                                                    id="batch_id_{{ $levelKey }}"
                                                    name="educations[{{ $levelKey }}][batch_id]"
                                                    class="field-select"
                                                >
                                                    <option value="">Select batch</option>
                                                    @foreach (($batchOptions[$levelKey] ?? collect()) as $batch)
                                                        <option value="{{ $batch->id }}" {{ (string)$batchId === (string)$batch->id ? 'selected' : '' }}>
                                                            {{ strtoupper($levelLabel) }} &bull; {{ $batch->schoolyear }} &bull; Grad {{ $batch->yeargrad }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <p id="err-batch-{{ $levelKey }}" class="field-error mt-2 hidden text-xs leading-5 text-red-600">
                                                    @error("educations.$levelKey.batch_id"){{ $message }}@enderror
                                                </p>
                                            </div>

                                            <div id="school-year-wrap-{{ $levelKey }}" class="{{ $didGraduate === '0' ? '' : 'hidden' }}">
                                                <label for="school_year_attended_{{ $levelKey }}" class="field-label">School Year Attended</label>
                                                <input
                                                    type="text"
                                                    id="school_year_attended_{{ $levelKey }}"
                                                    name="educations[{{ $levelKey }}][school_year_attended]"
                                                    value="{{ $schoolYearAttended }}"
                                                    placeholder="e.g. 2012–2014"
                                                    class="field-input"
                                                >
                                                <p class="mt-1.5 text-xs text-slate-400">Required if you attended but did not graduate.</p>
                                                <p id="err-school-year-{{ $levelKey }}" class="field-error mt-2 hidden text-xs leading-5 text-red-600">
                                                    @error("educations.$levelKey.school_year_attended"){{ $message }}@enderror
                                                </p>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <p id="err-educations" class="field-error mt-4 hidden text-xs leading-5 text-red-600">
                            @error('educations'){{ $message }}@enderror
                        </p>

                    </div>
                </section>

                {{-- ===================================================== --}}
                {{-- PANEL 3 - Address                                       --}}
                {{-- ===================================================== --}}
                <section id="panel-3" class="panel hidden">
                    <div class="max-w-2xl space-y-5">

                        <div>
                            <label for="google_autocomplete" class="field-label">Search address</label>
                            <div class="relative">
                                <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                        <circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/>
                                    </svg>
                                </span>
                                <input
                                    type="text"
                                    id="google_autocomplete"
                                    placeholder="Start typing your address..."
                                    autocomplete="off"
                                    class="field-input with-icon-left"
                                >
                            </div>
                            <p class="mt-1.5 text-xs text-slate-400">
                                Select a suggestion to auto-fill the fields below. You can still edit them manually.
                            </p>
                        </div>

                        <div>
                            <label for="address_line_1" class="field-label">Street address</label>
                            <textarea
                                id="address_line_1"
                                name="address_line_1"
                                placeholder="House/Unit no., street name, barangay or district"
                                class="field-input-textarea {{ $errors->has('address_line_1') ? 'is-error' : '' }}"
                                style="min-height: 5.5rem;"
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
                                class="inline-flex items-center gap-2 text-sm font-semibold transition hover:underline"
                                style="color: var(--royal-600);"
                            >
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round">
                                    <path d="M12 5v14M5 12h14"/>
                                </svg>
                                Add apartment, suite, or other details
                            </button>
                        </div>

                        <div id="addr2wrap" class="{{ old('address_line_2') ? '' : 'hidden' }}">
                            <label for="address_line_2" class="field-label">
                                Address line 2 <span class="opt">(optional)</span>
                            </label>
                            <input
                                type="text" id="address_line_2" name="address_line_2"
                                value="{{ old('address_line_2') }}"
                                placeholder="Subdivision, building, floor, unit, etc."
                                autocomplete="address-line2"
                                class="field-input"
                            >
                        </div>

                        <div class="grid gap-5 sm:grid-cols-2">
                            <div>
                                <label for="city" class="field-label">City / Municipality</label>
                                <input
                                    type="text" id="city" name="city"
                                    value="{{ old('city') }}"
                                    placeholder="City or municipality"
                                    autocomplete="address-level2"
                                    class="field-input {{ $errors->has('city') ? 'is-error' : '' }}"
                                >
                                <p id="err-city" class="field-error mt-2 hidden text-xs leading-5 text-red-600">
                                    @error('city'){{ $message }}@enderror
                                </p>
                            </div>

                            <div>
                                <label for="state_province" class="field-label">Province / State / Region</label>
                                <input
                                    type="text" id="state_province" name="state_province"
                                    value="{{ old('state_province') }}"
                                    placeholder="Province or state"
                                    autocomplete="address-level1"
                                    class="field-input {{ $errors->has('state_province') ? 'is-error' : '' }}"
                                >
                                <p id="err-province" class="field-error mt-2 hidden text-xs leading-5 text-red-600">
                                    @error('state_province'){{ $message }}@enderror
                                </p>
                            </div>

                            <div>
                                <label for="postal_code" class="field-label">Postal / ZIP code</label>
                                <input
                                    type="text" id="postal_code" name="postal_code"
                                    value="{{ old('postal_code') }}"
                                    placeholder="Postal or ZIP code"
                                    autocomplete="postal-code"
                                    class="field-input {{ $errors->has('postal_code') ? 'is-error' : '' }}"
                                >
                                <p id="err-postal" class="field-error mt-2 hidden text-xs leading-5 text-red-600">
                                    @error('postal_code'){{ $message }}@enderror
                                </p>
                            </div>

                            <div>
                                <label for="country" class="field-label">Country</label>
                                <input
                                    type="text" id="country" name="country"
                                    value="{{ old('country', 'Philippines') }}"
                                    autocomplete="country-name"
                                    class="field-input {{ $errors->has('country') ? 'is-error' : '' }}"
                                >
                                <p id="err-country" class="field-error mt-2 hidden text-xs leading-5 text-red-600">
                                    @error('country'){{ $message }}@enderror
                                </p>
                            </div>
                        </div>

                    </div>
                </section>

                {{-- ===================================================== --}}
                {{-- PANEL 4 - Volunteer Interest                            --}}
                {{-- ===================================================== --}}
                <section id="panel-4" class="panel hidden">
                    <div class="max-w-2xl space-y-6">

                        {{-- Volunteer card --}}
                        <div class="rounded-2xl p-6" style="background: #f0f4fb; border: 1px solid #dbeafe;">
                            <div class="flex items-start gap-4 mb-5">
                                <div class="flex-shrink-0 w-10 h-10 rounded-2xl flex items-center justify-center"
                                     style="background: rgba(26,63,168,0.1); border: 1px solid rgba(26,63,168,0.15);">
                                    <svg class="w-5 h-5" style="color: var(--royal-600);" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs font-bold uppercase tracking-[0.12em] mb-1" style="color: var(--royal-600);">
                                        Volunteer Committee Interest
                                    </p>
                                    <h3 class="font-display text-xl text-slate-900">Would you like to volunteer?</h3>
                                    <p class="mt-1.5 text-sm leading-6 text-slate-500">
                                        This is optional. You may express interest now or decide after logging in.
                                    </p>
                                </div>
                            </div>

                            <div class="grid gap-3 sm:grid-cols-2">
                                <label class="choice-card flex items-start gap-3">
                                    <input
                                        type="radio"
                                        name="volunteer_interest"
                                        value="yes"
                                        class="mt-0.5 h-4 w-4"
                                        {{ $oldVolunteerInterest === 'yes' ? 'checked' : '' }}
                                        onchange="toggleVolunteerFields()"
                                    >
                                    <div>
                                        <p class="text-sm font-bold text-slate-900">Yes, I want to volunteer</p>
                                        <p class="mt-1 text-xs text-slate-500">I'm interested in joining a committee.</p>
                                    </div>
                                </label>

                                <label class="choice-card flex items-start gap-3">
                                    <input
                                        type="radio"
                                        name="volunteer_interest"
                                        value="later"
                                        class="mt-0.5 h-4 w-4"
                                        {{ $oldVolunteerInterest !== 'yes' ? 'checked' : '' }}
                                        onchange="toggleVolunteerFields()"
                                    >
                                    <div>
                                        <p class="text-sm font-bold text-slate-900">Maybe later</p>
                                        <p class="mt-1 text-xs text-slate-500">Create my account first.</p>
                                    </div>
                                </label>
                            </div>

                            <p id="err-volunteer-interest" class="field-error mt-3 hidden text-xs leading-5 text-red-600">
                                @error('volunteer_interest'){{ $message }}@enderror
                            </p>

                            <div id="volunteerFields" class="{{ $oldVolunteerInterest === 'yes' ? '' : 'hidden' }} mt-5 space-y-5 pt-5"
                                 style="border-top: 1px solid #dbeafe;">
                                <div>
                                    <label class="field-label">Select committee(s) you are interested in</label>
                                    <div class="grid gap-3 sm:grid-cols-2 mt-1">
                                        @foreach ($committeeOptions as $committee)
                                            <label class="choice-card flex items-start gap-3">
                                                <input
                                                    type="checkbox"
                                                    name="committees[]"
                                                    value="{{ $committee->id }}"
                                                    class="mt-0.5 h-4 w-4 rounded"
                                                    {{ in_array($committee->id, $oldCommittees) ? 'checked' : '' }}
                                                >
                                                <span class="text-sm text-slate-700">{{ $committee->name }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                    <p class="mt-2 text-xs text-slate-400">
                                        You may choose more than one. Organizers can confirm assignments later.
                                    </p>
                                    <p id="err-committees" class="field-error mt-2 hidden text-xs leading-5 text-red-600">
                                        @error('committees'){{ $message }}@enderror
                                        @error('committees.*'){{ $message }}@enderror
                                    </p>
                                </div>

                                <div>
                                    <label for="volunteer_notes" class="field-label">
                                        Skills / notes <span class="opt">(optional)</span>
                                    </label>
                                    <textarea
                                        id="volunteer_notes"
                                        name="volunteer_notes"
                                        rows="4"
                                        placeholder="Example: I can help with logistics, hosting, design, documentation, sponsorships, medical support, or coordination."
                                        class="field-input-textarea"
                                    >{{ old('volunteer_notes') }}</textarea>
                                    <p class="mt-1.5 text-xs text-slate-400">
                                        Share any skills, experience, or preferred role.
                                    </p>
                                    <p id="err-volunteer-notes" class="field-error mt-2 hidden text-xs leading-5 text-red-600">
                                        @error('volunteer_notes'){{ $message }}@enderror
                                    </p>
                                </div>
                            </div>
                        </div>

                        {{-- Confirmation notice --}}
                        <div class="rounded-2xl px-5 py-4 text-sm leading-6" style="background:#eff6ff; border:1px solid #bfdbfe; color:#1e40af;">
                            By creating an account, you confirm that all information provided is accurate and that you are an alumnus or alumna of Holy Spirit School of Tagbilaran.
                            By registering, you also agree to our <a href="{{ route('privacy') }}" target="_blank" class="underline font-semibold hover:opacity-80">Privacy Policy</a>.
                        </div>

                    </div>
                </section>

                {{-- ===================================================== --}}
                {{-- PANEL 5 - Account credentials                          --}}
                {{-- ===================================================== --}}
                <section id="panel-5" class="panel hidden">
                    <div class="max-w-2xl space-y-5">

                        <div class="grid gap-5 sm:grid-cols-2">

                            <div class="sm:col-span-2">
                                <label for="username" class="field-label">Username</label>
                                <input
                                    type="text" id="username" name="username"
                                    value="{{ old('username') }}"
                                    placeholder="e.g. jdelacruz"
                                    autocomplete="username"
                                    class="field-input {{ $errors->has('username') ? 'is-error' : '' }}"
                                >
                                <p class="mt-1.5 text-xs text-slate-400">This is what you'll use to sign in.</p>
                                <p id="err-username" class="field-error mt-2 hidden text-xs leading-5 text-red-600">
                                    @error('username'){{ $message }}@enderror
                                </p>
                            </div>

                            <div class="sm:col-span-2">
                                <label for="email" class="field-label">Email address</label>
                                <input
                                    type="email" id="email" name="email"
                                    value="{{ old('email') }}"
                                    placeholder="you@example.com"
                                    autocomplete="email"
                                    class="field-input {{ $errors->has('email') ? 'is-error' : '' }}"
                                >
                                <p class="mt-1.5 text-xs text-slate-400">For account notifications and recovery.</p>
                                <p id="err-email" class="field-error mt-2 hidden text-xs leading-5 text-red-600">
                                    @error('email'){{ $message }}@enderror
                                </p>
                            </div>

                            <div>
                                <label for="password" class="field-label">Password</label>
                                <div class="relative">
                                    <input
                                        type="password" id="password" name="password"
                                        placeholder="Create a password"
                                        autocomplete="new-password"
                                        oninput="checkPasswordStrength(this.value)"
                                        class="field-input {{ $errors->has('password') ? 'is-error' : '' }}"
                                        style="padding-right: 3rem;"
                                    >
                                    <button
                                        type="button"
                                        id="togglePasswordNew"
                                        aria-label="Toggle password visibility"
                                        class="absolute inset-y-0 right-0 flex items-center pr-4 text-slate-400 hover:text-slate-600 transition-colors"
                                    >
                                        <svg id="eyeOpenNew" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        </svg>
                                        <svg id="eyeClosedNew" class="w-4 h-4 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88"/>
                                        </svg>
                                    </button>
                                </div>

                                {{-- Strength meter --}}
                                <div id="pwStrength" class="mt-2.5 flex gap-1.5">
                                    <div id="bar1" class="h-1 flex-1 rounded-full bg-slate-200 transition-colors"></div>
                                    <div id="bar2" class="h-1 flex-1 rounded-full bg-slate-200 transition-colors"></div>
                                    <div id="bar3" class="h-1 flex-1 rounded-full bg-slate-200 transition-colors"></div>
                                    <div id="bar4" class="h-1 flex-1 rounded-full bg-slate-200 transition-colors"></div>
                                </div>
                                <p id="pwLabel" class="mt-1.5 text-xs text-slate-400">
                                    Use letters, numbers, and symbols for a stronger password.
                                </p>
                                <p id="err-password" class="field-error mt-2 hidden text-xs leading-5 text-red-600">
                                    @error('password'){{ $message }}@enderror
                                </p>
                            </div>

                            <div>
                                <label for="password_confirmation" class="field-label">Confirm password</label>
                                <input
                                    type="password" id="password_confirmation" name="password_confirmation"
                                    placeholder="Re-enter your password"
                                    autocomplete="new-password"
                                    class="field-input"
                                >
                                <p id="err-confirm" class="field-error mt-2 hidden text-xs leading-5 text-red-600"></p>
                            </div>

                        </div>
                    </div>
                </section>

            </div>

            {{-- ---- Footer actions --------------------------------------- --}}
            <div class="flex-shrink-0 px-5 py-4 sm:px-8 lg:px-12 xl:px-16"
                 style="border-top: 1px solid #e2e8f0; background: #f8fafc;">
                <div class="max-w-3xl flex items-center justify-between gap-3">

                    <button
                        type="button"
                        id="btnBack"
                        onclick="prevStep()"
                        class="btn-ghost hidden h-11 rounded-2xl px-5 text-sm font-semibold"
                    >
                        Back
                    </button>

                    <div class="flex items-center gap-4 ml-auto">
                        @if (Route::has('login'))
                            <a href="{{ route('login') }}"
                               class="hidden sm:inline text-sm font-semibold hover:underline transition"
                               style="color: var(--royal-600);">
                                Already have an account?
                            </a>
                        @endif

                        <button
                            type="button"
                            id="btnNext"
                            onclick="nextStep()"
                            class="btn-royal inline-flex h-11 items-center justify-center gap-2 rounded-2xl px-6 text-sm font-bold"
                        >
                            <span id="btnNextLabel">Continue</span>
                            <svg id="btnNextIcon" class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/>
                            </svg>
                        </button>
                    </div>

                </div>

                @if (Route::has('login'))
                    <p class="sm:hidden mt-4 text-center text-sm text-slate-500">
                        Already have an account?
                        <a href="{{ route('login') }}" class="font-bold hover:underline" style="color: var(--royal-600);">Sign in</a>
                    </p>
                @endif
            </div>

        </form>

        {{-- Footer --}}
        <div class="flex-shrink-0 px-5 py-4 text-center lg:text-left lg:px-12 xl:px-16"
             style="border-top: 1px solid #e2e8f0;">
            <p class="text-xs text-slate-400">
                &copy; {{ date('Y') }} Holy Spirit School of Tagbilaran &mdash; Alumni Portal. All rights reserved.
                &ensp;&bull;&ensp;
                Not an alumni?
                <a href="{{ route('register.staff') }}" class="font-semibold hover:underline" style="color: var(--royal-600);">
                    Employee / Staff registration
                </a>
            </p>
        </div>

    </main>
</div>

{{-- ================================================================== --}}
{{-- SCRIPTS                                                              --}}
{{-- ================================================================== --}}
<script>
const STEPS = [
    { short: "Profile",  sub: "Personal details",         title: "Personal information",    desc: "Tell us about yourself - your name, contact number, and occupation." },
    { short: "Alumni",   sub: "Levels attended",          title: "Alumni membership",        desc: "Select the HSST level or levels you attended." },
    { short: "Address",  sub: "Current location",         title: "Address details",          desc: "Provide your current mailing or residential address." },
    { short: "Interest", sub: "Volunteer interest",       title: "Involvement",              desc: "Optionally share your committee interest." },
    { short: "Account",  sub: "Login & security",         title: "Account setup",            desc: "Choose your login credentials and secure your account." },
];

let currentStep = 1;
let isSubmitting = false;
const totalSteps = STEPS.length;

// ---- Sidebar step nav ------------------------------------------------
function buildNav() {
    const nav = document.getElementById("stepNav");
    if (!nav) return;
    nav.innerHTML = "";

    STEPS.forEach((s, i) => {
        const n       = i + 1;
        const isDone  = n < currentStep;
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
        const label    = isDone ? '✓' : n;

        nav.innerHTML += `
            <div style="display:flex;align-items:center;gap:0.75rem;border-radius:0.875rem;padding:0.7rem 1rem;${wrap}">
                <div style="flex-shrink:0;width:2rem;height:2rem;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:0.8rem;font-weight:700;${dotBg}">
                    ${label}
                </div>
                <div>
                    <p style="font-size:0.8rem;font-weight:700;color:#fff;line-height:1.2;">${s.short}</p>
                    <p style="font-size:0.7rem;color:${subColor};margin-top:0.1rem;">${s.sub}</p>
                </div>
            </div>
        `;
    });
}

// ---- Header update ---------------------------------------------------
function updateHeader() {
    const s = STEPS[currentStep - 1];

    const eyebrow = document.getElementById("eyebrow");
    if (eyebrow) eyebrow.textContent = `Step ${currentStep} of ${totalSteps}`;

    document.getElementById("stepTitle").textContent = s.title;
    document.getElementById("stepDesc").textContent  = s.desc;
    document.getElementById("progressFill").style.width = `${(currentStep / totalSteps) * 100}%`;

    document.getElementById("btnBack").classList.toggle("hidden", currentStep === 1);

    const label = document.getElementById("btnNextLabel");
    const icon  = document.getElementById("btnNextIcon");
    label.textContent  = currentStep === totalSteps ? "Create account" : "Continue";
    icon.style.display = currentStep === totalSteps ? "none" : "inline-block";
}

// ---- Panel switch ----------------------------------------------------
function showPanel(n) {
    document.querySelectorAll(".panel").forEach(p => {
        p.classList.add("hidden");
        p.classList.remove("block");
    });
    const panel = document.getElementById(`panel-${n}`);
    if (panel) { panel.classList.remove("hidden"); panel.classList.add("block"); }
}

// ---- Error helpers ---------------------------------------------------
function clearErrors() {
    document.querySelectorAll(".field-error").forEach(el => {
        if (!el.textContent.trim()) el.classList.add("hidden");
    });
    document.querySelectorAll("input, textarea, select").forEach(el => {
        el.classList.remove("border-red-500", "ring-4", "ring-red-100", "is-error");
    });
}

function showError(fieldId, errId, message) {
    const field = document.getElementById(fieldId);
    const err   = document.getElementById(errId);
    if (field) field.classList.add("is-error");
    if (err)   { err.textContent = message; err.classList.remove("hidden"); }
}

// ---- Validation ------------------------------------------------------
function validateStep(step) {
    clearErrors();
    let valid = true;

    if (step === 1) {
        const fname     = document.getElementById("fname").value.trim();
        const lname     = document.getElementById("lname").value.trim();
        const cellphone = document.getElementById("cellphone").value.trim();

        if (!fname)     { showError("fname",     "err-fname",     "First name is required.");        valid = false; }
        if (!lname)     { showError("lname",     "err-lname",     "Last name is required.");         valid = false; }
        if (!cellphone) { showError("cellphone", "err-cellphone", "Cellphone number is required."); valid = false; }
    }

    if (step === 2) {
        const levels = ['elementary', 'highschool', 'college'];
        let selectedCount = 0;

        levels.forEach(level => {
            const enabled = document.querySelector(`input[name="educations[${level}][enabled]"]`)?.checked;
            if (!enabled) return;
            selectedCount++;

            const batchSelect  = document.getElementById(`batch_id_${level}`);
            const didGraduate  = document.querySelector(`input[name="educations[${level}][did_graduate]"]:checked`)?.value;
            const schoolYear   = document.getElementById(`school_year_attended_${level}`)?.value.trim();

            if (!batchSelect?.value) {
                const err = document.getElementById(`err-batch-${level}`);
                if (err) { err.textContent = "Please select a batch."; err.classList.remove("hidden"); }
                batchSelect?.classList.add("is-error");
                valid = false;
            }
            if (didGraduate === undefined) { valid = false; }
            if (didGraduate === "0" && !schoolYear) {
                const err = document.getElementById(`err-school-year-${level}`);
                if (err) { err.textContent = "Please enter the school year attended."; err.classList.remove("hidden"); }
                document.getElementById(`school_year_attended_${level}`)?.classList.add("is-error");
                valid = false;
            }
        });

        if (selectedCount === 0) {
            const err = document.getElementById("err-educations");
            if (err) { err.textContent = "Please include at least one alumni level."; err.classList.remove("hidden"); }
            valid = false;
        }
    }

    if (step === 3) {
        const addr1    = document.getElementById("address_line_1").value.trim();
        const city     = document.getElementById("city").value.trim();
        const province = document.getElementById("state_province").value.trim();
        const postal   = document.getElementById("postal_code").value.trim();
        const country  = document.getElementById("country").value.trim();

        if (!addr1)    { showError("address_line_1", "err-addr1",    "Street address is required.");       valid = false; }
        if (!city)     { showError("city",           "err-city",     "City / municipality is required.");  valid = false; }
        if (!province) { showError("state_province", "err-province", "Province / state is required.");     valid = false; }
        if (!postal)   { showError("postal_code",    "err-postal",   "Postal / ZIP code is required.");    valid = false; }
        if (!country)  { showError("country",        "err-country",  "Country is required.");              valid = false; }
    }

    if (step === 4) {
        const volunteerInterest   = document.querySelector('input[name="volunteer_interest"]:checked')?.value;
        const selectedCommittees  = document.querySelectorAll('input[name="committees[]"]:checked');

        if (volunteerInterest === "yes" && selectedCommittees.length === 0) {
            const err = document.getElementById("err-committees");
            if (err) { err.textContent = "Please choose at least one committee if you want to volunteer."; err.classList.remove("hidden"); }
            valid = false;
        }
    }

    if (step === 5) {
        const username = document.getElementById("username").value.trim();
        const email    = document.getElementById("email").value.trim();
        const pw       = document.getElementById("password").value;
        const pw2      = document.getElementById("password_confirmation").value;

        if (!username)                                          { showError("username", "err-username", "Please enter a username.");          valid = false; }
        if (!email || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) { showError("email", "err-email", "Please enter a valid email address."); valid = false; }
        if (!pw)                                                { showError("password", "err-password", "Password is required.");             valid = false; }
        if (!pw2)  { showError("password_confirmation", "err-confirm", "Please confirm your password.");  valid = false; }
        else if (pw !== pw2) { showError("password_confirmation", "err-confirm", "Passwords do not match."); valid = false; }
    }

    return valid;
}

// ---- Navigation ------------------------------------------------------
function nextStep() {
    if (isSubmitting) return;
    if (!validateStep(currentStep)) {
        const btn = document.getElementById("btnNext");
        btn.style.transform = "translateX(-4px)";
        setTimeout(() => btn.style.transform = "translateX(4px)", 80);
        setTimeout(() => btn.style.transform = "", 160);
        return;
    }

    if (currentStep < totalSteps) {
        currentStep++;
        buildNav();
        updateHeader();
        showPanel(currentStep);

        if (currentStep === 3) {
            setTimeout(() => {
                if (typeof initGoogleAddressAutocomplete === "function") initGoogleAddressAutocomplete();
            }, 200);
        }
        if (currentStep === 4) setTimeout(() => toggleVolunteerFields(), 50);
    } else {
        const btn      = document.getElementById("btnNext");
        const btnLabel = document.getElementById("btnNextLabel");
        const btnIcon  = document.getElementById("btnNextIcon");

        btn.disabled       = true;
        isSubmitting       = true;
        btnLabel.textContent = "Creating account…";
        btnIcon.style.display = "inline-block";
        btnIcon.innerHTML  = `<circle cx="12" cy="12" r="10" fill="none" stroke="white" stroke-width="2" stroke-dasharray="30" stroke-dashoffset="15"><animate attributeName="stroke-dashoffset" dur="0.6s" repeatCount="indefinite" from="0" to="30"/></circle>`;
        btnIcon.setAttribute("viewBox", "0 0 24 24");
        btnIcon.style.width  = "16px";
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

// ---- UI helpers ------------------------------------------------------
function toggleAddr2() {
    const wrap    = document.getElementById("addr2wrap");
    const btn     = document.getElementById("toggleAddr2Btn");
    const isHidden = wrap.classList.contains("hidden");
    wrap.classList.toggle("hidden");
    btn.innerHTML = isHidden
        ? `<svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><path d="M5 12h14"/></svg> Hide additional address details`
        : `<svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><path d="M12 5v14M5 12h14"/></svg> Add apartment, suite, or other details`;
}

function toggleVolunteerFields() {
    const selected = document.querySelector('input[name="volunteer_interest"]:checked')?.value;
    const wrap     = document.getElementById("volunteerFields");
    if (!wrap) return;
    wrap.classList.toggle("hidden", selected !== "yes");
}

function toggleEducationSection(level) {
    const checkbox = document.querySelector(`input[name="educations[${level}][enabled]"]`);
    const wrap     = document.getElementById(`education-fields-${level}`);
    if (!checkbox || !wrap) return;
    wrap.classList.toggle("hidden", !checkbox.checked);
}

function toggleEducationGraduateFields(level) {
    const selected       = document.querySelector(`input[name="educations[${level}][did_graduate]"]:checked`)?.value;
    const schoolYearWrap = document.getElementById(`school-year-wrap-${level}`);
    if (!schoolYearWrap) return;
    schoolYearWrap.classList.toggle("hidden", selected !== "0");
}

function initEducationSections() {
    ['elementary', 'highschool', 'college'].forEach(level => {
        toggleEducationSection(level);
        toggleEducationGraduateFields(level);
    });
}

// ---- Password strength -----------------------------------------------
function checkPasswordStrength(val) {
    const bars  = ['bar1','bar2','bar3','bar4'].map(id => document.getElementById(id));
    const label = document.getElementById("pwLabel");

    let score = 0;
    if (val.length >= 8)          score++;
    if (/[A-Z]/.test(val))        score++;
    if (/[0-9]/.test(val))        score++;
    if (/[^A-Za-z0-9]/.test(val)) score++;

    const colors = ['bg-slate-200','bg-red-500','bg-amber-500','bg-emerald-500','bg-blue-600'];
    const labels = [
        "Use letters, numbers, and symbols for a stronger password.",
        "Weak - try adding numbers or symbols.",
        "Fair - add uppercase or symbols.",
        "Good password.",
        "Strong password!",
    ];

    bars.forEach((bar, i) => {
        bar.className = "h-1 flex-1 rounded-full transition-colors " + (i < score ? colors[score] : "bg-slate-200");
    });
    label.textContent = val.length === 0 ? labels[0] : labels[score];
}

// ---- Password show/hide (new password field) -------------------------
(function () {
    const btn    = document.getElementById("togglePasswordNew");
    const input  = document.getElementById("password");
    const open   = document.getElementById("eyeOpenNew");
    const closed = document.getElementById("eyeClosedNew");
    if (!btn || !input) return;
    btn.addEventListener("click", () => {
        const isPw = input.type === "password";
        input.type = isPw ? "text" : "password";
        open.classList.toggle("hidden", isPw);
        closed.classList.toggle("hidden", !isPw);
    });
})();

// ---- Error-step jump (server-side validation) ------------------------
function jumpToErrorStep() {
    for (let step = 1; step <= totalSteps; step++) {
        const panel = document.getElementById(`panel-${step}`);
        if (!panel) continue;
        const hasError = Array.from(panel.querySelectorAll(".field-error")).some(el => el.textContent.trim() !== "");
        if (hasError) {
            currentStep = step;
            buildNav();
            updateHeader();
            showPanel(currentStep);
            if (step === 3 && document.getElementById("address_line_2")?.value) {
                document.getElementById("addr2wrap").classList.remove("hidden");
            }
            if (step === 4) toggleVolunteerFields();
            panel.querySelectorAll(".field-error").forEach(el => {
                if (el.textContent.trim() !== "") el.classList.remove("hidden");
            });
            break;
        }
    }
}

// ---- Google Maps autocomplete ----------------------------------------
let googleAutocompleteInstance = null;
function initGoogleAddressAutocomplete() {
    const input = document.getElementById("google_autocomplete");
    if (!input || !window.google?.maps?.places || googleAutocompleteInstance) return;

    googleAutocompleteInstance = new google.maps.places.Autocomplete(input, {
        types: ["address"],
        fields: ["address_components", "formatted_address"],
    });

    googleAutocompleteInstance.addListener("place_changed", () => {
        const place = googleAutocompleteInstance.getPlace();
        if (!place?.address_components) return;
        const c = {};
        for (const comp of place.address_components) c[comp.types[0]] = comp.long_name;

        const line1 = [c.street_number, c.route].filter(Boolean).join(" ");
        const line2 = c.subpremise || "";
        const city  = c.locality || c.postal_town || c.sublocality_level_1 || c.neighborhood || "";

        setVal("address_line_1", line1);
        setVal("address_line_2", line2);
        setVal("city",           city);
        setVal("state_province", c.administrative_area_level_1 || "");
        setVal("postal_code",    c.postal_code || "");
        setVal("country",        c.country || "");
        if (line2) document.getElementById("addr2wrap").classList.remove("hidden");
    });
}

function setVal(id, value) {
    const el = document.getElementById(id);
    if (!el) return;
    el.value = value;
    el.dispatchEvent(new Event("input",  { bubbles: true }));
    el.dispatchEvent(new Event("change", { bubbles: true }));
}

// ---- Init ------------------------------------------------------------
buildNav();
updateHeader();
jumpToErrorStep();
toggleVolunteerFields();
initEducationSections();
</script>

@if(config('services.google_maps.api_key'))
    <script async defer
        src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google_maps.api_key') }}&libraries=places&callback=initGoogleAddressAutocomplete">
    </script>
@else
    <script>window.initGoogleAddressAutocomplete = function() {};</script>
@endif

</body>
</html>
