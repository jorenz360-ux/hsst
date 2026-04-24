<div class="min-h-screen" style="background:#f0f4fb; font-family:'DM Sans',system-ui,sans-serif;">
<style>
    :root {
        --r9: #0a1f5c; --r8: #0f2a7a; --r7: #153591;
        --r6: #1a3fa8; --r5: #2150c8;
        --g5: #c4952a; --g4: #d4a843;
    }

    /* Fields */
    .bt-field {
        height: 2.375rem; border-radius: .75rem;
        border: 1px solid #e2e8f0; background: #fff;
        padding: 0 .875rem; font-size: .8125rem; color: #0f172a;
        outline: none; transition: border-color .15s, box-shadow .15s; width: 100%;
    }
    .bt-field::placeholder { color: #94a3b8; }
    .bt-field:hover  { border-color: #94a3b8; }
    .bt-field:focus  { border-color: var(--r6); box-shadow: 0 0 0 3px rgba(26,63,168,.1); }
    .bt-field-icon   { padding-left: 2.3rem; }

    .bt-select {
        height: 2.375rem; border-radius: .75rem;
        border: 1px solid #e2e8f0;
        background: #fff url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%2394a3b8' stroke-width='2'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' d='M19 9l-7 7-7-7'/%3E%3C/svg%3E") no-repeat right .75rem center / .85rem;
        padding: 0 2rem 0 .875rem; font-size: .8125rem; color: #0f172a;
        outline: none; appearance: none; width: 100%; cursor: pointer;
        transition: border-color .15s, box-shadow .15s;
    }
    .bt-select:hover { border-color: #94a3b8; }
    .bt-select:focus { border-color: var(--r6); box-shadow: 0 0 0 3px rgba(26,63,168,.1); }

    .bt-label {
        display: block; font-size: .62rem; font-weight: 700;
        letter-spacing: .1em; text-transform: uppercase;
        color: #64748b; margin-bottom: .3rem;
    }

    /* Buttons */
    .btn-ghost {
        display: inline-flex; align-items: center; gap: .4rem;
        height: 2.375rem; padding: 0 .875rem; border-radius: .75rem;
        background: #fff; border: 1px solid #e2e8f0;
        color: #475569; font-size: .8rem; font-weight: 600;
        transition: background .12s, border-color .12s; cursor: pointer; white-space: nowrap;
    }
    .btn-ghost:hover { background: #f8fafc; border-color: #cbd5e1; color: #1e293b; }

    /* Stat cards */
    .bt-stat {
        background: #fff; border: 1px solid #e8edf5;
        border-radius: 1.1rem; padding: 1.1rem 1.25rem;
        box-shadow: 0 1px 6px rgba(15,23,42,.05);
    }
    .bt-stat-icon {
        width: 2.1rem; height: 2.1rem; border-radius: .55rem;
        display: flex; align-items: center; justify-content: center; margin-bottom: .75rem;
    }
    .bt-stat-val { font-size: 1.85rem; font-weight: 800; letter-spacing: -.03em; line-height: 1; color: #0f172a; }
    .bt-stat-lbl { font-size: .65rem; font-weight: 700; letter-spacing: .08em; text-transform: uppercase; color: #64748b; margin-bottom: .25rem; }
    .bt-stat-sub { font-size: .7rem; color: #94a3b8; margin-top: .4rem; line-height: 1.4; }

    /* Card */
    .bt-card {
        background: #fff; border: 1px solid #e8edf5;
        border-radius: 1.1rem; box-shadow: 0 1px 6px rgba(15,23,42,.05); overflow: hidden;
    }
    .bt-card-head {
        padding: .9rem 1.4rem; border-bottom: 1px solid #f1f5f9;
        display: flex; align-items: center; gap: .65rem;
    }
    .bt-card-icon {
        width: 1.9rem; height: 1.9rem; border-radius: .5rem;
        display: flex; align-items: center; justify-content: center; flex-shrink: 0;
    }

    /* Table */
    .bt-table thead th {
        font-size: .6rem; font-weight: 700; letter-spacing: .12em; text-transform: uppercase;
        color: #64748b; padding: .65rem 1rem; text-align: left;
        background: #f8fafc; white-space: nowrap;
    }
    .bt-table tbody tr { border-bottom: 1px solid #f1f5f9; transition: background .1s; }
    .bt-table tbody tr:last-child { border-bottom: none; }
    .bt-table tbody tr:hover { background: #f8faff; }
    .bt-table td { padding: .75rem 1rem; vertical-align: middle; }

    /* Avatar */
    .bt-avatar {
        width: 2rem; height: 2rem; border-radius: .5rem;
        display: flex; align-items: center; justify-content: center;
        font-size: .65rem; font-weight: 800; color: #fff; flex-shrink: 0;
        background: linear-gradient(135deg, var(--r6) 0%, var(--r8) 100%);
    }

    /* Chips */
    .chip {
        display: inline-flex; align-items: center; gap: .28rem;
        padding: .18rem .55rem; border-radius: 999px;
        font-size: .65rem; font-weight: 700; letter-spacing: .03em; white-space: nowrap;
    }
    .chip-dot { width: .38rem; height: .38rem; border-radius: 50%; flex-shrink: 0; }
    .chip-green  { background:#ecfdf5; color:#065f46; border:1px solid #a7f3d0; }
    .chip-slate  { background:#f1f5f9; color:#475569; border:1px solid #e2e8f0; }
    .chip-amber  { background:#fffbeb; color:#92700a; border:1px solid #fde68a; }
    .chip-blue   { background:#eef2ff; color:#1a3fa8; border:1px solid #c7d2fe; }
    .chip-purple { background:#f5f3ff; color:#5b21b6; border:1px solid #ddd6fe; }
    .chip-red    { background:#fef2f2; color:#991b1b; border:1px solid #fecaca; }
    .chip-teal   { background:#f0fdfa; color:#0f766e; border:1px solid #99f6e4; }
    .chip-orange { background:#fff7ed; color:#9a3412; border:1px solid #fdba74; }

    /* Involvement icons */
    .inv-icon {
        display: inline-flex; align-items: center; justify-content: center;
        width: 1.4rem; height: 1.4rem; border-radius: .35rem;
        font-size: .6rem; font-weight: 700;
    }
</style>

@php
    $levelMeta = match($batch?->level) {
        'elementary' => ['label' => 'Elementary', 'bg' => '#f0fdf4', 'color' => '#065f46', 'border' => '#bbf7d0'],
        'highschool' => ['label' => 'High School','bg' => '#fef9ee', 'color' => '#92700a', 'border' => '#fde68a'],
        'college'    => ['label' => 'College',    'bg' => '#f5f3ff', 'color' => '#5b21b6', 'border' => '#ddd6fe'],
        default      => ['label' => 'Batch',      'bg' => '#f1f5f9', 'color' => '#475569', 'border' => '#e2e8f0'],
    };
    $hasFilters = $search !== '' || $filterAccount !== 'all' || $filterGrad !== 'all' || $filterRsvp !== 'all';
@endphp

<div class="space-y-5 px-4 py-6 sm:px-6 lg:px-8 mx-auto max-w-screen-xl">

    {{-- ── HEADER ──────────────────────────────────────────────── --}}
    @if ($batch)
    <section class="overflow-hidden rounded-2xl"
             style="background:linear-gradient(155deg,var(--r8) 0%,var(--r7) 45%,var(--r6) 100%);
                    box-shadow:0 8px 32px rgba(10,31,92,.28); position:relative;">
        <span style="position:absolute;right:2rem;top:50%;transform:translateY(-50%);
                     font-family:Georgia,serif;font-size:6rem;font-weight:900;color:#fff;
                     opacity:.025;letter-spacing:.04em;user-select:none;white-space:nowrap;pointer-events:none;">
            MY BATCH
        </span>

        <div class="relative px-6 py-6 sm:px-8">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
                <div>
                    <div class="flex flex-wrap items-center gap-2 mb-2">
                        <p class="text-[.65rem] font-bold uppercase tracking-[.22em]" style="color:var(--g4);">
                            HSST Alumni Portal &middot; Batch Representative Panel
                        </p>
                        <span class="chip" style="background:{{ $levelMeta['bg'] }};color:{{ $levelMeta['color'] }};border:1px solid {{ $levelMeta['border'] }};font-size:.58rem;">
                            {{ $levelMeta['label'] }}
                        </span>
                    </div>
                    <h1 class="text-2xl font-bold tracking-tight text-white sm:text-3xl"
                        style="font-family:Georgia,serif;letter-spacing:-.01em;">
                        Batch {{ $batch->yeargrad }}
                        <span style="opacity:.5;font-weight:400;font-size:1.4rem;">&mdash; {{ $batch->schoolyear }}</span>
                    </h1>
                    <p class="mt-1.5 text-sm leading-6" style="color:rgba(255,255,255,.6);max-width:50ch;">
                        View and manage all alumni members assigned to your batch, track account registration, graduation status, and event attendance.
                    </p>
                </div>

                <div class="sm:shrink-0 flex items-start gap-2.5">
                    {{-- Batch info pills --}}
                    <div style="background:rgba(255,255,255,.1);border:1px solid rgba(255,255,255,.18);
                                border-radius:.875rem;padding:.5rem 1rem;text-align:center;">
                        <p class="text-[.58rem] font-bold uppercase tracking-widest" style="color:rgba(255,255,255,.5);">Members</p>
                        <p class="text-xl font-bold text-white" style="font-family:Georgia,serif;">{{ $totalCount }}</p>
                    </div>
                    <div style="background:rgba(255,255,255,.1);border:1px solid rgba(255,255,255,.18);
                                border-radius:.875rem;padding:.5rem 1rem;text-align:center;">
                        <p class="text-[.58rem] font-bold uppercase tracking-widest" style="color:rgba(255,255,255,.5);">Registered</p>
                        <p class="text-xl font-bold" style="color:#6ee7b7;font-family:Georgia,serif;">{{ $registeredCount }}</p>
                    </div>
                </div>
            </div>

            {{-- KPI strip --}}
            <div class="mt-5 flex flex-wrap items-center gap-2 pt-5"
                 style="border-top:1px solid rgba(255,255,255,.12);">
                @foreach ([
                    ['Total Members',   $totalCount,      'rgba(255,255,255,.14)', 'rgba(255,255,255,.9)'],
                    ['Registered',      $registeredCount, 'rgba(16,185,129,.14)',  '#6ee7b7'],
                    ['Graduated',       $graduatedCount,  'rgba(139,92,246,.14)',  '#c4b5fd'],
                    ['Attending Events',$respondedCount,  'rgba(196,149,42,.14)',  'var(--g4)'],
                    ['Active Events',   $activeEvents->count(), 'rgba(96,165,250,.14)', '#93c5fd'],
                ] as [$lbl, $val, $bg, $col])
                    <div style="background:{{ $bg }};border:1px solid {{ $col }}33;border-radius:999px;
                                padding:.28rem .85rem;display:inline-flex;align-items:center;gap:.45rem;">
                        <span style="font-size:.65rem;font-weight:700;color:{{ $col }};opacity:.85;">{{ $lbl }}</span>
                        <strong style="font-size:.78rem;color:{{ $col }};">{{ $val }}</strong>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ── STAT CARDS ───────────────────────────────────────────── --}}
    <div class="grid grid-cols-2 gap-4 lg:grid-cols-4">
        <div class="bt-stat">
            <div class="bt-stat-icon" style="background:#eef2ff;">
                <svg class="w-4 h-4" style="color:var(--r6);" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z"/>
                </svg>
            </div>
            <p class="bt-stat-lbl">Total Alumni</p>
            <p class="bt-stat-val">{{ $totalCount }}</p>
            <p class="bt-stat-sub">Members in this batch.</p>
        </div>

        <div class="bt-stat">
            <div class="bt-stat-icon" style="background:#ecfdf5;">
                <svg class="w-4 h-4" style="color:#059669;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                </svg>
            </div>
            <p class="bt-stat-lbl">Registered</p>
            <p class="bt-stat-val" style="color:#059669;">{{ $registeredCount }}</p>
            <p class="bt-stat-sub">
                {{ $totalCount > 0 ? round(($registeredCount / $totalCount) * 100) : 0 }}% have accounts.
            </p>
        </div>

        <div class="bt-stat">
            <div class="bt-stat-icon" style="background:#f5f3ff;">
                <svg class="w-4 h-4" style="color:#7c3aed;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.636 50.636 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.903 59.903 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489a50.702 50.702 0 0 1 3.741-1.342M6.75 15a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Zm0 0v-3.675A55.378 55.378 0 0 1 12 8.443m-7.007 11.55A5.981 5.981 0 0 0 6.75 15.75v-1.5"/>
                </svg>
            </div>
            <p class="bt-stat-lbl">Graduated</p>
            <p class="bt-stat-val" style="color:#7c3aed;">{{ $graduatedCount }}</p>
            <p class="bt-stat-sub">Confirmed graduates.</p>
        </div>

        <div class="bt-stat">
            <div class="bt-stat-icon" style="background:#fffbeb;">
                <svg class="w-4 h-4" style="color:#d97706;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5"/>
                </svg>
            </div>
            <p class="bt-stat-lbl">RSVP Attending</p>
            <p class="bt-stat-val" style="color:#d97706;">{{ $respondedCount }}</p>
            <p class="bt-stat-sub">Confirmed for an upcoming event.</p>
        </div>
    </div>

    {{-- ── ACTIVE EVENTS STRIP ──────────────────────────────────── --}}
    @if ($activeEvents->isNotEmpty())
    <div class="bt-card">
        <div class="bt-card-head">
            <div class="bt-card-icon" style="background:#fffbeb;">
                <svg class="w-3.5 h-3.5" style="color:#d97706;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5"/>
                </svg>
            </div>
            <div>
                <p class="text-sm font-bold" style="color:#1e293b;">Upcoming Events</p>
                <p class="text-xs" style="color:#64748b;">Active events your batch members can RSVP to.</p>
            </div>
            <span class="chip chip-amber ml-auto" style="font-size:.6rem;">{{ $activeEvents->count() }} active</span>
        </div>
        <div class="px-5 py-3 flex flex-wrap gap-2.5">
            @foreach ($activeEvents as $event)
                <div style="background:#f8fafc;border:1px solid #e2e8f0;border-radius:.75rem;
                            padding:.5rem .9rem;display:flex;align-items:center;gap:.65rem;">
                    <div style="width:2.1rem;height:2.1rem;border-radius:.45rem;background:#fffbeb;
                                border:1px solid #fde68a;display:flex;flex-direction:column;
                                align-items:center;justify-content:center;flex-shrink:0;">
                        <span style="font-size:.55rem;font-weight:700;color:#92700a;line-height:1;text-transform:uppercase;">
                            {{ $event->event_date->format('M') }}
                        </span>
                        <span style="font-size:.8rem;font-weight:800;color:#92700a;line-height:1;">
                            {{ $event->event_date->format('d') }}
                        </span>
                    </div>
                    <div>
                        <p class="text-xs font-semibold" style="color:#1e293b;">{{ $event->title }}</p>
                        @if ($event->venue)
                            <p class="text-xs" style="color:#94a3b8;">{{ $event->venue }}</p>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    @endif

    {{-- ── FILTERS ──────────────────────────────────────────────── --}}
    <div class="bt-card">
        <div class="bt-card-head">
            <div class="bt-card-icon" style="background:#eef2ff;">
                <svg class="w-3.5 h-3.5" style="color:var(--r6);" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 3c2.755 0 5.455.232 8.083.678.533.09.917.556.917 1.096v1.044a2.25 2.25 0 0 1-.659 1.591l-5.432 5.432a2.25 2.25 0 0 0-.659 1.591v2.927a2.25 2.25 0 0 1-1.244 2.013L9.75 21v-6.568a2.25 2.25 0 0 0-.659-1.591L3.659 7.409A2.25 2.25 0 0 1 3 5.818V4.774c0-.54.384-1.006.917-1.096A48.32 48.32 0 0 1 12 3Z"/>
                </svg>
            </div>
            <span class="text-xs font-bold uppercase tracking-[.14em]" style="color:#475569;">Filters</span>
            @if ($hasFilters)
                <button wire:click="resetFilters"
                        class="ml-auto text-[.68rem] font-bold transition hover:underline"
                        style="color:var(--r6);">Clear All</button>
            @endif
        </div>

        <div class="px-5 py-4">
            <div class="grid grid-cols-1 gap-3 sm:grid-cols-2 lg:grid-cols-4">
                {{-- Search --}}
                <div class="lg:col-span-2">
                    <label class="bt-label">Search</label>
                    <div class="relative">
                        <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3" style="color:#94a3b8;">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z"/>
                            </svg>
                        </span>
                        <input type="text" wire:model.live.debounce.300ms="search"
                               placeholder="Name, username, email, occupation…"
                               class="bt-field bt-field-icon">
                    </div>
                </div>

                {{-- Account filter --}}
                <div>
                    <label class="bt-label">Account</label>
                    <select wire:model.live="filterAccount" class="bt-select">
                        <option value="all">All Status</option>
                        <option value="registered">Registered</option>
                        <option value="no_account">No Account</option>
                    </select>
                </div>

                {{-- Graduation filter --}}
                <div>
                    <label class="bt-label">Graduation</label>
                    <select wire:model.live="filterGrad" class="bt-select">
                        <option value="all">All</option>
                        <option value="graduated">Graduated</option>
                        <option value="not_graduated">Did Not Graduate</option>
                    </select>
                </div>

                @if ($activeEvents->isNotEmpty())
                {{-- RSVP filter (only show when there are active events) --}}
                <div class="sm:col-span-2 lg:col-span-4">
                    <label class="bt-label">RSVP Status (Upcoming Events)</label>
                    <div class="flex flex-wrap gap-2 mt-1">
                        @foreach ([
                            ['all',           'All',           'chip-slate'],
                            ['attending',     'Attending',     'chip-green'],
                            ['maybe',         'Maybe',         'chip-amber'],
                            ['not_attending', 'Not Attending', 'chip-red'],
                            ['no_rsvp',       'No RSVP',       'chip-slate'],
                        ] as [$val, $lbl, $cls])
                            <button wire:click="$set('filterRsvp', '{{ $val }}')"
                                    class="chip {{ $cls }}"
                                    style="{{ $filterRsvp === $val ? 'outline:2px solid currentColor;outline-offset:1px;' : '' }}">
                                {{ $lbl }}
                            </button>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>

    {{-- ── MEMBERS TABLE ────────────────────────────────────────── --}}
    <div class="bt-card">
        <div class="bt-card-head">
            <div class="bt-card-icon" style="background:#eef2ff;">
                <svg class="w-3.5 h-3.5" style="color:var(--r6);" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z"/>
                </svg>
            </div>
            <div class="flex-1">
                <p class="text-sm font-bold" style="color:#1e293b;">Batch Members</p>
                <p class="text-xs" style="color:#64748b;">Alumni assigned to Batch {{ $batch->yeargrad }}.</p>
            </div>
            <span class="chip chip-blue" style="font-size:.6rem;">
                {{ $members->total() }} {{ Str::plural('member', $members->total()) }}
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="bt-table min-w-full">
                <thead>
                    <tr>
                        <th>Member</th>
                        <th>Contact</th>
                        <th>Level</th>
                        <th>Graduation</th>
                        <th>Occupation</th>
                        <th>Address</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($members as $member)
                        @php
                            $al       = $member->alumni;
                            $name     = trim(($al->lname ?? '') . ', ' . ($al->fname ?? '') . ($al->mname ? ' ' . $al->mname : ''));
                            $initials = strtoupper(substr($al->fname ?? 'U', 0, 1) . substr($al->lname ?? '', 0, 1));

                            // RSVPs keyed by event_id
                            $rsvpMap  = $al->eventRsvps?->keyBy('event_id') ?? collect();

                            // Involvement
                            $inv = $al->involvement;
                        @endphp
                        <tr>
                            <td style="min-width:200px;">
                                <div class="flex items-center gap-2.5">
                                    <div class="bt-avatar">{{ $initials }}</div>
                                    <div>
                                        <p class="text-sm font-semibold leading-tight" style="color:#1e293b;">
                                            {{ $name ?: '-' }}
                                        </p>
                                        @if ($al->occupation)
                                            <p class="text-xs mt-0.5 truncate max-w-[160px]" style="color:#64748b;">{{ $al->occupation }}</p>
                                        @endif
                                        @if ($member->is_batch_rep)
                                            <span class="chip chip-amber" style="font-size:.58rem;margin-top:.25rem;">
                                                <span class="chip-dot" style="background:#c4952a;"></span>
                                                Rep
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </td>

                            {{-- Contact --}}
                            <td style="min-width:170px;">
                                @if ($al->user?->email)
                                    <p class="text-xs truncate max-w-[160px]" style="color:#334155;">{{ $al->user->email }}</p>
                                @endif
                            </td>

                            {{-- Level --}}
                            <td>
                                @php
                                    [$lvlAbbr, $lvlChip] = match($batch->level) {
                                        'elementary' => ['ELM', 'chip-green'],
                                        'highschool' => ['HS',  'chip-amber'],
                                        'college'    => ['COL', 'chip-purple'],
                                        default      => [$batch->level ?? '—', 'chip-slate'],
                                    };
                                @endphp
                                <span class="chip {{ $lvlChip }}" style="font-size:.65rem;font-weight:800;letter-spacing:.04em;">
                                    {{ $lvlAbbr }}
                                </span>
                            </td>

                            {{-- Graduation --}}
                            <td>
                                @if ($member->did_graduate)
                                    <span class="chip chip-purple">
                                        <span class="chip-dot" style="background:#7c3aed;"></span>
                                        Graduated
                                    </span>
                                @else
                                    <span class="chip chip-slate">Did Not Graduate</span>
                                @endif
                                @if ($member->school_year_attended)
                                    <p class="text-xs mt-0.5" style="color:#94a3b8;">{{ $member->school_year_attended }}</p>
                                @endif
                            </td>


                            {{-- Occupation --}}
                            <td style="min-width:140px;">
                                @if ($al->occupation)
                                    <p class="text-xs truncate max-w-[160px]" style="color:#334155;">{{ $al->occupation }}</p>
                                @else
                                    <span class="text-xs" style="color:#cbd5e1;">—</span>
                                @endif
                            </td>

                            {{-- Address --}}
                            <td style="min-width:160px;">
                                @php
                                    $tableAddr = collect([$al->city, $al->state_province, $al->postal_code, $al->country])->filter()->implode(', ');
                                @endphp
                                @if ($tableAddr)
                                    <p class="text-xs truncate max-w-[180px]" style="color:#334155;" title="{{ $tableAddr }}">{{ $tableAddr }}</p>
                                @else
                                    <span class="text-xs" style="color:#cbd5e1;">—</span>
                                @endif
                            </td>

                            {{-- Actions --}}
                            <td>
                                <button wire:click="viewAlumni({{ $al->id }})"
                                        title="View full profile"
                                        style="display:inline-flex;align-items:center;gap:.35rem;height:1.9rem;
                                               padding:0 .7rem;border-radius:.6rem;border:1px solid #c7d2fe;
                                               background:#eef2ff;color:#1a3fa8;font-size:.7rem;font-weight:600;
                                               cursor:pointer;transition:background .12s,border-color .12s;white-space:nowrap;">
                                    <svg style="width:.85rem;height:.85rem;flex-shrink:0;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7Z"/>
                                    </svg>
                                    View
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ $activeEvents->isNotEmpty() ? 9 : 8 }}"
                                style="padding:3.5rem 1.5rem; text-align:center;">
                                <div style="max-width:20rem;margin:0 auto;">
                                    <div style="width:3rem;height:3rem;border-radius:.875rem;background:#f0f4fb;
                                                border:1px solid #e2e8f0;display:flex;align-items:center;
                                                justify-content:center;margin:0 auto .75rem;">
                                        <svg style="width:1.4rem;height:1.4rem;color:#94a3b8;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z"/>
                                        </svg>
                                    </div>
                                    <p class="text-sm font-semibold" style="color:#1e293b;">No members found</p>
                                    <p class="text-xs mt-1" style="color:#64748b;">Try adjusting your search or filters.</p>
                                    @if ($hasFilters)
                                        <button wire:click="resetFilters"
                                                class="btn-ghost mt-3" style="margin:0 auto;margin-top:.75rem;">
                                            Clear Filters
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if ($members->hasPages())
            <div style="padding:.85rem 1.2rem; border-top:1px solid #f1f5f9; background:#fafbff;">
                {{ $members->links() }}
            </div>
        @endif
    </div>

    @else
    {{-- ── NO BATCH ─────────────────────────────────────────────── --}}
    <section style="border:2px dashed #e2e8f0;border-radius:1.25rem;padding:4rem 2rem;text-align:center;background:#fff;">
        <div style="width:3.5rem;height:3.5rem;border-radius:1rem;background:#f0f4fb;
                    border:1px solid #e2e8f0;display:flex;align-items:center;justify-content:center;margin:0 auto 1rem;">
            <svg style="width:1.5rem;height:1.5rem;color:#94a3b8;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 0 0 5.636 5.636m12.728 12.728A9 9 0 0 1 5.636 5.636m12.728 12.728L5.636 5.636"/>
            </svg>
        </div>
        <h2 class="text-base font-bold" style="color:#1e293b;">No Batch Assigned</h2>
        <p class="mt-1 text-sm" style="color:#64748b;">Your account is not yet linked to any batch representative role.</p>
    </section>
    @endif


    {{-- ── ALUMNI DETAIL MODAL ──────────────────────────────────── --}}
    @if ($selectedAlumniId && $this->selectedAlumni)
    @php
        $sal         = $this->selectedAlumni;
        $salFname    = $sal->fname ?? '';
        $salMname    = $sal->mname ?? '';
        $salLname    = $sal->lname ?? '';
        $salFullName = trim(
            ($sal->prefix ? $sal->prefix . ' ' : '') .
            $salFname . ' ' .
            ($salMname ? $salMname . ' ' : '') .
            $salLname .
            ($sal->suffix ? ', ' . $sal->suffix : '')
        );
        $salInitials = strtoupper(substr($sal->fname ?? 'U', 0, 1) . substr($sal->lname ?? '', 0, 1));

        // Prefer Google formatted address, fall back to individual fields
        $salAddress = $sal->formatted_address ?: collect([
            $sal->address_line_1, $sal->address_line_2,
            $sal->city,
            $sal->state_province ? ($sal->city ? ', ' . $sal->state_province : $sal->state_province) : null,
            $sal->postal_code,
            $sal->country,
        ])->filter()->implode(' ');

        // Structured address parts for the detail rows
        $salAddrParts = [
            'Line 1'       => $sal->address_line_1,
            'Line 2'       => $sal->address_line_2,
            'City'         => $sal->city,
            'State / Prov' => $sal->state_province,
            'Postal Code'  => $sal->postal_code,
            'Country'      => $sal->country,
        ];
    @endphp
    <div wire:click.self="closeModal"
         style="position:fixed;inset:0;z-index:50;display:flex;align-items:center;justify-content:center;
                background:rgba(10,31,92,.45);backdrop-filter:blur(3px);padding:1rem;">
        <div style="background:#fff;border-radius:1.25rem;width:100%;max-width:34rem;
                    box-shadow:0 20px 60px rgba(10,31,92,.25);overflow:hidden;display:flex;flex-direction:column;max-height:92vh;">

            {{-- Modal Header --}}
            <div style="background:linear-gradient(135deg,var(--r8) 0%,var(--r6) 100%);padding:1.4rem 1.5rem;
                        display:flex;align-items:center;justify-content:space-between;flex-shrink:0;">
                <div class="flex items-center gap-3">
                    <div style="width:3rem;height:3rem;border-radius:.75rem;flex-shrink:0;
                                display:flex;align-items:center;justify-content:center;
                                font-size:.9rem;font-weight:800;color:#fff;
                                background:rgba(255,255,255,.15);border:1.5px solid rgba(255,255,255,.25);">
                        {{ $salInitials }}
                    </div>
                    <div>
                        <p style="font-size:1rem;font-weight:700;color:#fff;line-height:1.2;">{{ $salFullName ?: '—' }}</p>
                        @if ($sal->occupation)
                            <p style="font-size:.72rem;color:rgba(255,255,255,.65);margin-top:.2rem;">{{ $sal->occupation }}</p>
                        @endif
                        <div class="flex items-center gap-1.5" style="margin-top:.35rem;">
                            @if ($sal->user)
                                <span class="chip chip-green" style="font-size:.58rem;">
                                    <span class="chip-dot" style="background:#10b981;"></span>
                                    Registered
                                </span>
                            @else
                                <span class="chip chip-slate" style="font-size:.58rem;background:rgba(255,255,255,.1);border-color:rgba(255,255,255,.2);color:rgba(255,255,255,.7);">
                                    No Account
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
                <button wire:click="closeModal"
                        style="width:1.9rem;height:1.9rem;border-radius:.5rem;border:1px solid rgba(255,255,255,.25);
                               background:rgba(255,255,255,.1);color:#fff;cursor:pointer;display:flex;
                               align-items:center;justify-content:center;flex-shrink:0;align-self:flex-start;">
                    <svg style="width:.9rem;height:.9rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            {{-- Modal Body --}}
            <div style="padding:1.25rem 1.5rem;display:flex;flex-direction:column;gap:0;overflow-y:auto;">

                {{-- ① Personal Information --}}
                <div style="padding-bottom:.9rem;">
                    <p style="font-size:.6rem;font-weight:700;letter-spacing:.12em;text-transform:uppercase;color:#94a3b8;margin-bottom:.6rem;">Personal Information</p>
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:.35rem .75rem;">
                        @if ($sal->prefix)
                        <div>
                            <p style="font-size:.58rem;font-weight:600;text-transform:uppercase;letter-spacing:.08em;color:#94a3b8;margin-bottom:.1rem;">Prefix</p>
                            <p style="font-size:.8rem;color:#334155;">{{ $sal->prefix }}</p>
                        </div>
                        @endif
                        <div>
                            <p style="font-size:.58rem;font-weight:600;text-transform:uppercase;letter-spacing:.08em;color:#94a3b8;margin-bottom:.1rem;">First Name</p>
                            <p style="font-size:.8rem;color:#334155;">{{ $salFname ?: '—' }}</p>
                        </div>
                        @if ($salMname)
                        <div>
                            <p style="font-size:.58rem;font-weight:600;text-transform:uppercase;letter-spacing:.08em;color:#94a3b8;margin-bottom:.1rem;">Middle Name</p>
                            <p style="font-size:.8rem;color:#334155;">{{ $salMname }}</p>
                        </div>
                        @endif
                        <div>
                            <p style="font-size:.58rem;font-weight:600;text-transform:uppercase;letter-spacing:.08em;color:#94a3b8;margin-bottom:.1rem;">Last Name</p>
                            <p style="font-size:.8rem;color:#334155;">{{ $salLname ?: '—' }}</p>
                        </div>
                        @if ($sal->suffix)
                        <div>
                            <p style="font-size:.58rem;font-weight:600;text-transform:uppercase;letter-spacing:.08em;color:#94a3b8;margin-bottom:.1rem;">Suffix</p>
                            <p style="font-size:.8rem;color:#334155;">{{ $sal->suffix }}</p>
                        </div>
                        @endif
                        @if ($sal->occupation)
                        <div style="grid-column:1/-1;">
                            <p style="font-size:.58rem;font-weight:600;text-transform:uppercase;letter-spacing:.08em;color:#94a3b8;margin-bottom:.1rem;">Occupation</p>
                            <p style="font-size:.8rem;color:#334155;">{{ $sal->occupation }}</p>
                        </div>
                        @endif
                    </div>
                </div>

                {{-- ② Contact --}}
                <div style="border-top:1px solid #f1f5f9;padding:.9rem 0;">
                    <p style="font-size:.6rem;font-weight:700;letter-spacing:.12em;text-transform:uppercase;color:#94a3b8;margin-bottom:.6rem;">Contact</p>
                    @if ($sal->user?->email || $sal->cellphone || $sal->user?->username)
                    <div style="display:flex;flex-direction:column;gap:.4rem;">
                        @if ($sal->user?->email)
                        <div style="display:flex;align-items:center;gap:.5rem;">
                            <svg style="width:.8rem;height:.8rem;color:#64748b;flex-shrink:0;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75"/>
                            </svg>
                            <span style="font-size:.8rem;color:#334155;">{{ $sal->user->email }}</span>
                        </div>
                        @endif
                        @if ($sal->cellphone)
                        <div style="display:flex;align-items:center;gap:.5rem;">
                            <svg style="width:.8rem;height:.8rem;color:#64748b;flex-shrink:0;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 6.75Z"/>
                            </svg>
                            <span style="font-size:.8rem;color:#334155;">{{ $sal->cellphone }}</span>
                        </div>
                        @endif
                        @if ($sal->user?->username)
                        <div style="display:flex;align-items:center;gap:.5rem;">
                            <svg style="width:.8rem;height:.8rem;color:#64748b;flex-shrink:0;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z"/>
                            </svg>
                            <span style="font-size:.8rem;color:#64748b;font-family:monospace;">@{{ $sal->user->username }}</span>
                        </div>
                        @endif
                    </div>
                    @else
                        <p style="font-size:.8rem;color:#cbd5e1;">No contact info on file.</p>
                    @endif
                </div>

                {{-- ③ Address --}}
                @php $hasAddress = collect($salAddrParts)->filter()->isNotEmpty(); @endphp
                @if ($hasAddress)
                <div style="border-top:1px solid #f1f5f9;padding:.9rem 0;">
                    <p style="font-size:.6rem;font-weight:700;letter-spacing:.12em;text-transform:uppercase;color:#94a3b8;margin-bottom:.6rem;">Address</p>
                    @if ($sal->formatted_address)
                        <div style="display:flex;align-items:flex-start;gap:.5rem;margin-bottom:.5rem;">
                            <svg style="width:.8rem;height:.8rem;color:#64748b;flex-shrink:0;margin-top:.15rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z"/>
                            </svg>
                            <span style="font-size:.8rem;color:#334155;line-height:1.5;">{{ $sal->formatted_address }}</span>
                        </div>
                    @endif
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:.3rem .75rem;">
                        @foreach ($salAddrParts as $label => $val)
                            @if ($val)
                            <div>
                                <p style="font-size:.58rem;font-weight:600;text-transform:uppercase;letter-spacing:.08em;color:#94a3b8;margin-bottom:.1rem;">{{ $label }}</p>
                                <p style="font-size:.78rem;color:#334155;">{{ $val }}</p>
                            </div>
                            @endif
                        @endforeach
                    </div>
                </div>
                @endif

                {{-- ④ Education Records --}}
                @if ($sal->educations->isNotEmpty())
                <div style="border-top:1px solid #f1f5f9;padding:.9rem 0;">
                    <p style="font-size:.6rem;font-weight:700;letter-spacing:.12em;text-transform:uppercase;color:#94a3b8;margin-bottom:.6rem;">Education</p>
                    <div style="display:flex;flex-direction:column;gap:.5rem;">
                        @foreach ($sal->educations as $edu)
                        @php
                            $eduLevelMeta = match($edu->batch?->level) {
                                'elementary' => ['chip-green',  '#065f46'],
                                'highschool' => ['chip-amber',  '#92700a'],
                                'college'    => ['chip-purple', '#5b21b6'],
                                default      => ['chip-slate',  '#475569'],
                            };
                        @endphp
                        <div style="background:#f8fafc;border:1px solid #f1f5f9;border-radius:.65rem;padding:.6rem .85rem;">
                            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:.35rem;flex-wrap:wrap;gap:.3rem;">
                                <div style="display:flex;align-items:center;gap:.5rem;">
                                    <span class="chip {{ $eduLevelMeta[0] }}" style="font-size:.6rem;">
                                        {{ ucfirst($edu->batch?->level ?? 'Unknown') }}
                                    </span>
                                    <span style="font-size:.8rem;font-weight:600;color:#1e293b;">
                                        {{ $edu->batch?->yeargrad ?? '—' }}
                                        @if ($edu->batch?->schoolyear)
                                            <span style="font-size:.7rem;color:#64748b;font-weight:400;">({{ $edu->batch->schoolyear }})</span>
                                        @endif
                                    </span>
                                </div>
                                <div style="display:flex;gap:.3rem;flex-wrap:wrap;">
                                    @if ($edu->did_graduate)
                                        <span class="chip chip-green" style="font-size:.58rem;">
                                            <span class="chip-dot" style="background:#10b981;"></span>
                                            Graduated
                                        </span>
                                    @else
                                        <span class="chip chip-red" style="font-size:.58rem;">
                                            <span class="chip-dot" style="background:#ef4444;"></span>
                                            Did Not Graduate
                                        </span>
                                    @endif
                                    @if ($edu->is_batch_rep)
                                        <span class="chip chip-amber" style="font-size:.58rem;">
                                            <span class="chip-dot" style="background:#c4952a;"></span>
                                            Batch Rep
                                        </span>
                                    @endif
                                </div>
                            </div>
                            @if ($edu->school_year_attended)
                            <p style="font-size:.72rem;color:#64748b;">
                                School Year Attended: <span style="color:#334155;font-weight:500;">{{ $edu->school_year_attended }}</span>
                            </p>
                            @endif
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                {{-- ⑤ Involvement (Volunteer Signups) --}}
                <div style="border-top:1px solid #f1f5f9;padding:.9rem 0;">
                    <p style="font-size:.6rem;font-weight:700;letter-spacing:.12em;text-transform:uppercase;color:#94a3b8;margin-bottom:.6rem;">Involvement</p>
                    @if ($sal->volunteerSignups->count())
                    <div style="display:flex;flex-direction:column;gap:.45rem;">
                        @foreach ($sal->volunteerSignups as $signup)
                        @php
                            $signupStyle = match($signup->status) {
                                'approved'  => ['chip-green',  '#10b981'],
                                'contacted' => ['chip-blue',   '#1a3fa8'],
                                'declined'  => ['chip-red',    '#ef4444'],
                                default     => ['chip-amber',  '#c4952a'], // pending
                            };
                        @endphp
                        <div style="background:#f8fafc;border:1px solid #f1f5f9;border-radius:.65rem;padding:.55rem .85rem;">
                            <div style="display:flex;align-items:center;justify-content:space-between;gap:.5rem;">
                                <p style="font-size:.8rem;font-weight:600;color:#1e293b;">
                                    {{ $signup->committee?->name ?? '—' }}
                                </p>
                                <span class="chip {{ $signupStyle[0] }}" style="font-size:.6rem;flex-shrink:0;">
                                    <span class="chip-dot" style="background:{{ $signupStyle[1] }};"></span>
                                    {{ ucfirst($signup->status) }}
                                </span>
                            </div>
                            @if ($signup->committee?->description)
                                <p style="font-size:.7rem;color:#64748b;margin-top:.2rem;">{{ $signup->committee->description }}</p>
                            @endif
                            @if ($signup->notes)
                                <p style="font-size:.72rem;color:#64748b;margin-top:.3rem;font-style:italic;">"{{ $signup->notes }}"</p>
                            @endif
                        </div>
                        @endforeach
                    </div>
                    @else
                        <p style="font-size:.8rem;color:#cbd5e1;">No volunteer signups on file.</p>
                    @endif
                </div>

                {{-- ⑥ Event RSVPs --}}
                @if ($sal->eventRsvps->count())
                <div style="border-top:1px solid #f1f5f9;padding:.9rem 0 0;">
                    <p style="font-size:.6rem;font-weight:700;letter-spacing:.12em;text-transform:uppercase;color:#94a3b8;margin-bottom:.6rem;">Event RSVPs</p>
                    <div style="display:flex;flex-direction:column;gap:.45rem;">
                        @foreach ($sal->eventRsvps as $rsvp)
                            @if ($rsvp->event)
                            @php
                                $rsvpStyle = match($rsvp->status) {
                                    'attending'     => ['chip-green',  '#10b981'],
                                    'maybe'         => ['chip-amber',  '#c4952a'],
                                    'not_attending' => ['chip-red',    '#ef4444'],
                                    default         => ['chip-slate',  '#94a3b8'],
                                };
                            @endphp
                            <div style="background:#f8fafc;border:1px solid #f1f5f9;border-radius:.65rem;padding:.55rem .85rem;">
                                <div style="display:flex;align-items:center;justify-content:space-between;gap:.5rem;">
                                    <p style="font-size:.8rem;font-weight:500;color:#1e293b;">{{ $rsvp->event->title }}</p>
                                    <span class="chip {{ $rsvpStyle[0] }}" style="font-size:.6rem;flex-shrink:0;">
                                        <span class="chip-dot" style="background:{{ $rsvpStyle[1] }};"></span>
                                        {{ ucfirst(str_replace('_', ' ', $rsvp->status)) }}
                                    </span>
                                </div>
                                <div style="display:flex;gap:1rem;margin-top:.3rem;flex-wrap:wrap;">
                                    @if ($rsvp->event->event_date)
                                    <p style="font-size:.7rem;color:#94a3b8;">
                                        {{ \Carbon\Carbon::parse($rsvp->event->event_date)->format('M d, Y') }}
                                    </p>
                                    @endif
                                    @if ($rsvp->guest_count)
                                    <p style="font-size:.7rem;color:#64748b;">
                                        Guests: <span style="font-weight:600;">{{ $rsvp->guest_count }}</span>
                                    </p>
                                    @endif
                                </div>
                                @if ($rsvp->remarks)
                                <p style="font-size:.72rem;color:#64748b;margin-top:.3rem;font-style:italic;">"{{ $rsvp->remarks }}"</p>
                                @endif
                            </div>
                            @endif
                        @endforeach
                    </div>
                </div>
                @endif

            </div>{{-- end modal body --}}
        </div>
    </div>
    @endif

</div>
</div>
