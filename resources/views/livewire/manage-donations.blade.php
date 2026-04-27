<div class="min-h-screen" style="background:#f0f4fb; font-family:'DM Sans',system-ui,sans-serif;">
<style>
    :root {
        --r9:#0a1f5c; --r8:#0f2a7a; --r7:#153591;
        --r6:#1a3fa8; --r5:#2150c8;
        --g5:#c4952a; --g4:#d4a843;
    }

    .md-label {
        display:block; font-size:.62rem; font-weight:700;
        letter-spacing:.1em; text-transform:uppercase;
        color:#64748b; margin-bottom:.3rem;
    }
    .md-field {
        height:2.375rem; border-radius:.75rem;
        border:1px solid #e2e8f0; background:#fff;
        padding:0 .875rem; font-size:.8125rem; color:#0f172a;
        outline:none; transition:border-color .15s,box-shadow .15s; width:100%;
    }
    .md-field::placeholder { color:#94a3b8; }
    .md-field:hover  { border-color:#94a3b8; }
    .md-field:focus  { border-color:var(--r6); box-shadow:0 0 0 3px rgba(26,63,168,.1); }
    .md-field-icon   { padding-left:2.3rem; }

    .md-select {
        height:2.375rem; border-radius:.75rem;
        border:1px solid #e2e8f0;
        background:#fff url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%2394a3b8' stroke-width='2'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' d='M19 9l-7 7-7-7'/%3E%3C/svg%3E") no-repeat right .75rem center / .85rem;
        padding:0 2rem 0 .875rem; font-size:.8125rem; color:#0f172a;
        outline:none; appearance:none; width:100%; cursor:pointer;
        transition:border-color .15s,box-shadow .15s;
    }
    .md-select:hover { border-color:#94a3b8; }
    .md-select:focus { border-color:var(--r6); box-shadow:0 0 0 3px rgba(26,63,168,.1); }

    .btn-ghost {
        display:inline-flex; align-items:center; gap:.4rem;
        height:2.375rem; padding:0 .875rem; border-radius:.75rem;
        background:#fff; border:1px solid #e2e8f0;
        color:#475569; font-size:.8rem; font-weight:600;
        transition:background .12s,border-color .12s; cursor:pointer; white-space:nowrap;
    }
    .btn-ghost:hover { background:#f8fafc; border-color:#cbd5e1; color:#1e293b; }

    /* stat cards */
    .md-stat {
        background:#fff; border:1px solid #e8edf5;
        border-radius:1.1rem; padding:1.1rem 1.25rem;
        box-shadow:0 1px 6px rgba(15,23,42,.05);
    }
    .md-stat-icon {
        width:2.1rem; height:2.1rem; border-radius:.55rem;
        display:flex; align-items:center; justify-content:center; margin-bottom:.7rem;
    }
    .md-stat-lbl { font-size:.62rem; font-weight:700; letter-spacing:.09em; text-transform:uppercase; color:#64748b; margin-bottom:.2rem; }
    .md-stat-val { font-size:1.75rem; font-weight:800; letter-spacing:-.03em; line-height:1.1; color:#0f172a; }
    .md-stat-sub { font-size:.7rem; color:#94a3b8; margin-top:.35rem; line-height:1.4; }

    /* card */
    .md-card { background:#fff; border:1px solid #e8edf5; border-radius:1.1rem; box-shadow:0 1px 6px rgba(15,23,42,.05); overflow:hidden; }
    .md-card-head {
        padding:.9rem 1.4rem; border-bottom:1px solid #f1f5f9;
        display:flex; align-items:center; gap:.65rem;
    }
    .md-card-icon {
        width:1.9rem; height:1.9rem; border-radius:.5rem;
        display:flex; align-items:center; justify-content:center; flex-shrink:0;
    }

    /* table */
    .md-table thead th {
        font-size:.6rem; font-weight:700; letter-spacing:.12em; text-transform:uppercase;
        color:#64748b; padding:.65rem 1rem; text-align:left;
        background:#f8fafc; white-space:nowrap;
    }
    .md-table thead th.right { text-align:right; }
    .md-table tbody tr { border-bottom:1px solid #f1f5f9; transition:background .1s; }
    .md-table tbody tr:last-child { border-bottom:none; }
    .md-table tbody tr:hover { background:#fffbf0; }
    .md-table td { padding:.8rem 1rem; vertical-align:top; }
    .md-table td.right { text-align:right; }

    /* avatar */
    .md-avatar {
        width:2rem; height:2rem; border-radius:.5rem; flex-shrink:0;
        display:flex; align-items:center; justify-content:center;
        font-size:.65rem; font-weight:800; color:#fff;
        background:linear-gradient(135deg,var(--r6) 0%,var(--r8) 100%);
    }

    /* chips */
    .chip {
        display:inline-flex; align-items:center; gap:.28rem;
        padding:.18rem .55rem; border-radius:999px;
        font-size:.65rem; font-weight:700; white-space:nowrap;
    }
    .chip-dot { width:.38rem; height:.38rem; border-radius:50%; flex-shrink:0; }
    .chip-green  { background:#ecfdf5; color:#065f46; border:1px solid #a7f3d0; }
    .chip-amber  { background:#fffbeb; color:#92700a; border:1px solid #fde68a; }
    .chip-red    { background:#fef2f2; color:#991b1b; border:1px solid #fecaca; }
    .chip-blue   { background:#eef2ff; color:#1a3fa8; border:1px solid #c7d2fe; }
    .chip-slate  { background:#f1f5f9; color:#475569; border:1px solid #e2e8f0; }
    .chip-purple { background:#f5f3ff; color:#5b21b6; border:1px solid #ddd6fe; }
    .chip-teal   { background:#f0fdfa; color:#0f766e; border:1px solid #99f6e4; }

    /* level tags */
    .lvl-elem  { background:#f0fdf4; color:#065f46; border:1px solid #bbf7d0; }
    .lvl-hs    { background:#fef9ee; color:#92700a; border:1px solid #fde68a; }
    .lvl-col   { background:#f5f3ff; color:#5b21b6; border:1px solid #ddd6fe; }

    /* mobile card */
    .mob-card {
        background:#fff; border:1px solid #e8edf5; border-radius:1rem;
        box-shadow:0 1px 4px rgba(15,23,42,.05); padding:1rem 1.1rem;
    }

    /* ── Donation Table ─────────────────────────────────── */
    .dt-table { width:100%; border-collapse:collapse; }
    .dt-table thead tr { background:var(--r9); }
    .dt-table thead th {
        font-size:.565rem; font-weight:700; letter-spacing:.14em;
        text-transform:uppercase; color:rgba(255,255,255,.5);
        padding:.6rem .9rem; text-align:left; white-space:nowrap; border:none;
    }
    .dt-table thead th.r { text-align:right; }
    .dt-table tbody tr {
        border-bottom:1px solid #f1f5f9;
        border-left:2.5px solid transparent;
        transition:background .1s, border-left-color .1s;
    }
    .dt-table tbody tr:last-child { border-bottom:none; }
    .dt-table tbody tr:hover {
        background:rgba(26,63,168,.028);
        border-left-color:var(--r5);
    }
    .dt-table td { padding:.5rem .9rem; vertical-align:middle; }
    .dt-table td.r { text-align:right; }

    .dt-av {
        width:1.65rem; height:1.65rem; border-radius:.4rem; flex-shrink:0;
        display:flex; align-items:center; justify-content:center;
        font-size:.58rem; font-weight:800; color:#fff;
        background:linear-gradient(135deg,var(--r5) 0%,var(--r8) 100%);
    }
    .dt-btn {
        display:inline-flex; align-items:center; gap:.22rem;
        padding:.2rem .5rem; border-radius:.375rem; cursor:pointer;
        font-size:.63rem; font-weight:700; border:1px solid; white-space:nowrap;
        transition:filter .1s, transform .08s;
    }
    .dt-btn:hover { filter:brightness(.93); transform:translateY(-1px); }
    .dt-btn-ok { background:#f0fdf4; border-color:#86efac; color:#15803d; }
    .dt-btn-no { background:#fff5f5; border-color:#fca5a5; color:#dc2626; }
    .dt-btn-or { background:#fffbeb; border-color:#fde68a; color:#92700a; }
    .dt-ref {
        font-family:ui-monospace,SFMono-Regular,monospace; font-size:.67rem;
        letter-spacing:.02em; background:#f8fafc; border:1px solid #e2e8f0;
        border-radius:.3rem; padding:.12rem .45rem; color:#334155;
    }

    /* ── Mobile Donation Cards ──────────────────────────── */
    .dc-card {
        background:#fff; border:1px solid #e8edf5; border-radius:1rem;
        box-shadow:0 1px 4px rgba(15,23,42,.05); overflow:hidden;
    }
    .dc-card-inner { padding:.875rem 1rem; }
    .dc-meta-label {
        font-size:.575rem; font-weight:700; text-transform:uppercase;
        letter-spacing:.1em; color:#94a3b8; margin-bottom:.2rem;
    }

    /* ── Decision Modals ────────────────────────────────────── */
    @keyframes dmModalIn {
        from { opacity:0; transform:scale(.96) translateY(10px); }
        to   { opacity:1; transform:scale(1)   translateY(0);    }
    }
    .dm-modal {
        background:#fff;
        border-radius:1.1rem;
        width:95vw;
        max-width:27rem;
        box-shadow:0 24px 64px rgba(10,31,92,.22), 0 4px 16px rgba(0,0,0,.06);
        animation:dmModalIn .22s cubic-bezier(.34,1.1,.64,1) both;
        overflow:hidden;
        position:relative;
    }
    .dm-modal-body   { padding:1.5rem 1.5rem 1.25rem; }
    .dm-modal-footer {
        display:flex; gap:.5rem; justify-content:flex-end;
        padding:1rem 1.5rem;
        background:#f8fafc;
        border-top:1px solid #f1f5f9;
    }
    .dm-modal-icon {
        width:2.5rem; height:2.5rem; border-radius:.65rem; flex-shrink:0;
        display:flex; align-items:center; justify-content:center;
    }
    .dm-close-btn {
        width:1.75rem; height:1.75rem; border-radius:.4rem; border:none;
        background:#f1f5f9; cursor:pointer; color:#94a3b8; flex-shrink:0;
        display:flex; align-items:center; justify-content:center;
        transition:background .12s, color .12s;
    }
    .dm-close-btn:hover { background:#e2e8f0; color:#475569; }
    .dm-action-btn {
        display:inline-flex; align-items:center; gap:.4rem;
        padding:.45rem 1.1rem; border-radius:.7rem; border:none;
        font-size:.8rem; font-weight:700; color:#fff; cursor:pointer;
        transition:filter .12s;
    }
    .dm-action-btn:hover { filter:brightness(1.08); }
    .dm-action-btn:disabled { opacity:.65; cursor:not-allowed; filter:none; }
</style>

@php
    $isBatchRep  = $scopeBatchId !== null;
    $hasFilters  = $search !== '' || $status !== 'all' || $sort !== 'latest';
    $currentBatch = $currentEducation?->batch;

    $levelMeta = match($currentBatch?->level) {
        'elementary' => ['label'=>'Elementary',  'class'=>'lvl-elem'],
        'highschool' => ['label'=>'High School', 'class'=>'lvl-hs'],
        'college'    => ['label'=>'College',     'class'=>'lvl-col'],
        default      => null,
    };
@endphp

<div class="space-y-5 px-4 py-6 sm:px-6 lg:px-8 mx-auto max-w-screen-xl">

    {{-- ── HEADER ──────────────────────────────────────────────── --}}
    <section class="overflow-hidden rounded-2xl"
             style="background:linear-gradient(155deg,var(--r8) 0%,var(--r7) 45%,var(--r6) 100%);
                    box-shadow:0 8px 32px rgba(10,31,92,.28);position:relative;">
        <span style="position:absolute;right:2rem;top:50%;transform:translateY(-50%);
                     font-family:Georgia,serif;font-size:6rem;font-weight:900;color:#fff;
                     opacity:.025;letter-spacing:.04em;user-select:none;white-space:nowrap;pointer-events:none;">
            DONATIONS
        </span>

        <div class="relative px-6 py-6 sm:px-8">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
                <div>
                    <div class="flex flex-wrap items-center gap-2 mb-2">
                        <p class="text-[.65rem] font-bold uppercase tracking-[.22em]" style="color:var(--g4);">
                            HSST Alumni Portal &middot; {{ $isBatchRep ? 'Batch Representative Panel' : 'Admin Control' }}
                        </p>
                        @if ($isBatchRep && $levelMeta)
                            <span class="chip {{ $levelMeta['class'] }}" style="font-size:.58rem;">{{ $levelMeta['label'] }}</span>
                        @endif
                    </div>
                    <h1 class="text-2xl font-bold tracking-tight text-white sm:text-3xl"
                        style="font-family:Georgia,serif;letter-spacing:-.01em;">
                        Manage Donations
                        @if ($isBatchRep && $currentBatch)
                            <span style="opacity:.5;font-weight:400;font-size:1.3rem;">&mdash; Batch {{ $currentBatch->yeargrad }}</span>
                        @endif
                    </h1>
                    <p class="mt-1.5 text-sm leading-6" style="color:rgba(255,255,255,.6);max-width:50ch;">
                        {{ $isBatchRep
                            ? 'Viewing donation submissions from your assigned batch members only.'
                            : 'Search, filter, and review all donation submissions across all batches.' }}
                    </p>
                </div>

                {{-- Batch rep: submit donation button --}}
                @if ($isBatchRep)
                    <button wire:click="openUploadModal"
                            style="display:inline-flex;align-items:center;gap:.4rem;
                                   height:2.25rem;padding:0 1rem;border-radius:.7rem;cursor:pointer;
                                   background:linear-gradient(135deg,var(--g5),#a37522);
                                   border:none;color:#fff;font-size:.78rem;font-weight:700;
                                   box-shadow:0 3px 10px rgba(196,149,42,.35);
                                   transition:filter .15s;white-space:nowrap;"
                            onmouseover="this.style.filter='brightness(1.08)'"
                            onmouseout="this.style.filter='brightness(1)'">
                        <svg style="width:.8rem;height:.8rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5m-13.5-9L12 3m0 0 4.5 4.5M12 3v13.5"/>
                        </svg>
                        Submit Batch Donation
                    </button>
                @endif

                {{-- summary pills --}}
                <div class="sm:shrink-0 flex flex-wrap items-start gap-2.5">
                    <div style="background:rgba(16,185,129,.14);border:1px solid rgba(16,185,129,.25);
                                border-radius:.875rem;padding:.5rem 1rem;text-align:center;">
                        <p class="text-[.58rem] font-bold uppercase tracking-widest" style="color:rgba(255,255,255,.5);">Verified Total</p>
                        <p class="text-lg font-bold" style="color:#6ee7b7;font-family:Georgia,serif;">
                            ₱{{ number_format($verifiedPaidTotal, 2) }}
                        </p>
                    </div>
                    <div style="background:rgba(251,191,36,.14);border:1px solid rgba(251,191,36,.25);
                                border-radius:.875rem;padding:.5rem 1rem;text-align:center;">
                        <p class="text-[.58rem] font-bold uppercase tracking-widest" style="color:rgba(255,255,255,.5);">Pending</p>
                        <p class="text-lg font-bold" style="color:var(--g4);font-family:Georgia,serif;">{{ $pendingCount }}</p>
                    </div>
                </div>
            </div>

            {{-- kpi strip --}}
            <div class="mt-5 flex flex-wrap items-center gap-2 pt-5"
                 style="border-top:1px solid rgba(255,255,255,.12);">
                @foreach ([
                    ['Total Records',  $totalCount,    'rgba(255,255,255,.14)', 'rgba(255,255,255,.9)'],
                    ['Pending',        $pendingCount,  'rgba(251,191,36,.14)',  'var(--g4)'],
                    ['Verified',       $verifiedCount, 'rgba(16,185,129,.14)', '#6ee7b7'],
                    ['Rejected',       $rejectedCount, 'rgba(239,68,68,.12)',  '#fca5a5'],
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

    @include('partials.toast')

    {{-- ── STAT CARDS ───────────────────────────────────────────── --}}
    <div class="grid grid-cols-2 gap-4 lg:grid-cols-4">

        <div class="md-stat">
            <div class="md-stat-icon" style="background:#eef2ff;">
                <svg class="w-4 h-4" style="color:var(--r6);" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18Z"/>
                </svg>
            </div>
            <p class="md-stat-lbl">Total Records</p>
            <p class="md-stat-val">{{ $totalCount }}</p>
            <p class="md-stat-sub">All donation submissions.</p>
        </div>

        <div class="md-stat">
            <div class="md-stat-icon" style="background:#ecfdf5;">
                <svg class="w-4 h-4" style="color:#059669;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm3 0h.008v.008H18V10.5Zm-12 0h.008v.008H6V10.5Z"/>
                </svg>
            </div>
            <p class="md-stat-lbl">Verified Total</p>
            <p class="md-stat-val" style="color:#059669;font-size:1.35rem;">₱{{ number_format($verifiedPaidTotal, 2) }}</p>
            <p class="md-stat-sub">Sum of all verified donations.</p>
        </div>

        <div class="md-stat">
            <div class="md-stat-icon" style="background:#fffbeb;">
                <svg class="w-4 h-4" style="color:#d97706;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                </svg>
            </div>
            <p class="md-stat-lbl">Pending Review</p>
            <p class="md-stat-val" style="color:#d97706;">{{ $pendingCount }}</p>
            <p class="md-stat-sub">Awaiting admin verification.</p>
        </div>

        <div class="md-stat">
            <div class="md-stat-icon" style="background:#fef2f2;">
                <svg class="w-4 h-4" style="color:#dc2626;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m9.75 9.75 4.5 4.5m0-4.5-4.5 4.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                </svg>
            </div>
            <p class="md-stat-lbl">Rejected</p>
            <p class="md-stat-val" style="color:#dc2626;">{{ $rejectedCount }}</p>
            <p class="md-stat-sub">Submissions marked as rejected.</p>
        </div>
    </div>

    {{-- ── FILTER BAR ───────────────────────────────────────────── --}}
    <div class="md-card">
        <div class="md-card-head">
            <div class="md-card-icon" style="background:#eef2ff;">
                <svg class="w-3.5 h-3.5" style="color:var(--r6);" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 3c2.755 0 5.455.232 8.083.678.533.09.917.556.917 1.096v1.044a2.25 2.25 0 0 1-.659 1.591l-5.432 5.432a2.25 2.25 0 0 0-.659 1.591v2.927a2.25 2.25 0 0 1-1.244 2.013L9.75 21v-6.568a2.25 2.25 0 0 0-.659-1.591L3.659 7.409A2.25 2.25 0 0 1 3 5.818V4.774c0-.54.384-1.006.917-1.096A48.32 48.32 0 0 1 12 3Z"/>
                </svg>
            </div>
            <span class="text-xs font-bold uppercase tracking-[.14em]" style="color:#475569;">Filters</span>
            @if ($hasFilters)
                <button wire:click="$set('search','')" onclick="setTimeout(()=>{ @this.set('status','all'); @this.set('sort','latest'); },10)"
                        class="ml-auto text-[.68rem] font-bold transition hover:underline" style="color:var(--r6);">
                    Clear All
                </button>
            @endif
        </div>

        <div class="px-5 py-4">
            <div class="grid grid-cols-1 gap-3 sm:grid-cols-2 lg:grid-cols-4">

                {{-- Search --}}
                <div class="sm:col-span-2">
                    <label class="md-label">Search</label>
                    <div class="relative">
                        <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3" style="color:#94a3b8;">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z"/>
                            </svg>
                        </span>
                        <input type="text" wire:model.live.debounce.300ms="search"
                               placeholder="Name, reference number, remarks…"
                               class="md-field md-field-icon">
                    </div>
                </div>

                {{-- Status --}}
                <div>
                    <label class="md-label">Status</label>
                    <select wire:model.live="status" class="md-select">
                        <option value="all">All Statuses</option>
                        <option value="pending">Pending Review</option>
                        <option value="verified">Verified</option>
                        <option value="rejected">Rejected</option>
                    </select>
                </div>

                {{-- Sort + Per page --}}
                <div class="flex gap-2">
                    <div class="flex-1">
                        <label class="md-label">Sort</label>
                        <select wire:model.live="sort" class="md-select">
                            <option value="latest">Latest</option>
                            <option value="oldest">Oldest</option>
                            <option value="amount_desc">Amount ↓</option>
                            <option value="amount_asc">Amount ↑</option>
                        </select>
                    </div>
                    <div style="width:90px;">
                        <label class="md-label">Per page</label>
                        <select wire:model.live="perPage" class="md-select">
                            <option value="10">10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                        </select>
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- ── TABLE (desktop) ─────────────────────────────────────── --}}
    <div class="hidden lg:block" style="background:#fff;border:1px solid #e8edf5;
             border-radius:1.1rem;box-shadow:0 1px 6px rgba(15,23,42,.05);overflow:hidden;">

        {{-- Card header --}}
        <div style="display:flex;align-items:center;gap:.65rem;padding:.8rem 1.1rem .8rem 1.25rem;
                    border-bottom:1px solid #f1f5f9;">
            <div style="width:1.9rem;height:1.9rem;border-radius:.5rem;background:#eef2ff;flex-shrink:0;
                        display:flex;align-items:center;justify-content:center;">
                <svg style="width:.85rem;height:.85rem;color:var(--r6);" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm3 0h.008v.008H18V10.5Zm-12 0h.008v.008H6V10.5Z"/>
                </svg>
            </div>
            <div style="flex:1;">
                <p style="font-size:.8125rem;font-weight:700;color:#1e293b;margin:0;">Donation Records</p>
                <p style="font-size:.68rem;color:#94a3b8;margin:0;">Review submissions, payment state, and uploaded proof.</p>
            </div>
            <span style="font-size:.6rem;font-weight:700;background:#eef2ff;color:var(--r6);
                         border:1px solid #c7d2fe;border-radius:999px;padding:.2rem .65rem;">
                {{ $donations->firstItem() ?? 0 }}–{{ $donations->lastItem() ?? 0 }}
                <span style="opacity:.6;">of</span> {{ number_format($donations->total()) }}
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="dt-table">
                <thead>
                    <tr>
                        <th>Donor</th>
                        <th>Batch</th>
                        <th class="r">Amount</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Reference</th>
                        <th>Receipt</th>
                        @if (!auth()->user()?->hasRole('batch-representative'))
                            <th>Actions</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @forelse ($donations as $d)
                        @php
                            $education = $scopeBatchId
                                ? $d->alumni?->educations?->firstWhere('batch_id', $scopeBatchId)
                                : $d->alumni?->educations?->first();
                            $batch = $education?->batch;
                            $initials = strtoupper(
                                substr($d->alumni?->fname ?? 'U', 0, 1) .
                                substr($d->alumni?->lname ?? '', 0, 1)
                            );
                            $lvlClass = match($batch?->level) {
                                'elementary' => 'lvl-elem',
                                'highschool' => 'lvl-hs',
                                'college'    => 'lvl-col',
                                default      => 'chip-slate',
                            };
                            $lvlLabel = match($batch?->level) {
                                'elementary' => 'Elem',
                                'highschool' => 'H.S.',
                                'college'    => 'Col',
                                default      => '—',
                            };
                        @endphp
                        <tr>
                            {{-- Donor --}}
                            <td style="min-width:185px;">
                                <div style="display:flex;align-items:center;gap:.5rem;">
                                    <div class="dt-av">{{ $initials }}</div>
                                    <div>
                                        <p style="font-size:.775rem;font-weight:700;color:#1e293b;
                                                   line-height:1.25;white-space:nowrap;">
                                            {{ $d->alumni?->lname }}, {{ $d->alumni?->fname }}
                                        </p>
                                        @if ($d->remarks)
                                            <p style="font-size:.63rem;color:#94a3b8;margin-top:.1rem;
                                                       max-width:155px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">
                                                {{ $d->remarks }}
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            </td>

                            {{-- Batch --}}
                            <td style="min-width:115px;">
                                @if ($batch)
                                    <div style="display:flex;align-items:center;gap:.3rem;">
                                        <span style="font-size:.775rem;font-weight:700;color:#1e293b;">{{ $batch->yeargrad }}</span>
                                        <span class="chip {{ $lvlClass }}" style="font-size:.52rem;padding:.08rem .35rem;">{{ $lvlLabel }}</span>
                                    </div>
                                    <p style="font-size:.62rem;color:#94a3b8;margin-top:.15rem;">{{ $batch->schoolyear }}</p>
                                @else
                                    <span style="font-size:.7rem;color:#cbd5e1;">—</span>
                                @endif
                            </td>

                            {{-- Amount --}}
                            <td class="r" style="min-width:95px;">
                                <span style="font-size:.82rem;font-weight:800;color:#1e293b;
                                             font-variant-numeric:tabular-nums;letter-spacing:-.015em;">
                                    ₱{{ number_format($d->amount, 2) }}
                                </span>
                            </td>

                            {{-- Date --}}
                            <td style="min-width:105px;">
                                <p style="font-size:.75rem;font-weight:600;color:#334155;white-space:nowrap;">
                                    {{ ($d->date_donated ?? $d->created_at)?->format('M d, Y') ?? '—' }}
                                </p>
                                <p style="font-size:.62rem;color:#94a3b8;margin-top:.1rem;">
                                    {{ ($d->date_donated ?? $d->created_at)?->format('h:i A') ?? '' }}
                                </p>
                            </td>

                            {{-- Review Status --}}
                            <td style="min-width:125px;">
                                @if ($d->status === 'verified')
                                    <span class="chip chip-green">
                                        <span class="chip-dot" style="background:#10b981;"></span>Verified
                                    </span>
                                    @if ($d->reviewed_at)
                                        <p style="font-size:.6rem;color:#94a3b8;margin-top:.2rem;">
                                            {{ $d->reviewed_at->format('M d, Y') }}
                                        </p>
                                    @endif
                                @elseif ($d->status === 'rejected')
                                    <span class="chip chip-red">
                                        <span class="chip-dot" style="background:#ef4444;"></span>Rejected
                                    </span>
                                    @if ($d->rejection_reason)
                                        <p style="font-size:.62rem;color:#dc2626;margin-top:.2rem;
                                                   max-width:155px;line-height:1.35;">
                                            {{ Str::limit($d->rejection_reason, 48) }}
                                        </p>
                                    @endif
                                @else
                                    <span class="chip chip-amber">
                                        <span class="chip-dot" style="background:#d97706;"></span>Pending
                                    </span>
                                @endif
                            </td>

                            {{-- Reference --}}
                            <td style="min-width:115px;">
                                @if ($d->reference_number)
                                    <span class="dt-ref">{{ $d->reference_number }}</span>
                                @else
                                    <span style="font-size:.7rem;color:#cbd5e1;">—</span>
                                @endif
                            </td>

                            {{-- Receipt --}}
                            <td>
                                @if ($d->or_file_path)
                                    @php
                                        /** @var \Illuminate\Filesystem\FilesystemAdapter $s3 */
                                        $s3    = Storage::disk('s3');
                                        $orUrl = $s3->url($d->or_file_path);
                                        $orExt = strtolower(pathinfo($d->or_file_path, PATHINFO_EXTENSION));
                                    @endphp
                                    <button type="button" x-data
                                            @click="$dispatch('open-or-modal', { url: '{{ $orUrl }}', ext: '{{ $orExt }}' })"
                                            class="dt-btn dt-btn-or">
                                        <svg style="width:.6rem;height:.6rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z"/>
                                        </svg>
                                        View OR
                                    </button>
                                @else
                                    <span style="font-size:.68rem;color:#cbd5e1;">No file</span>
                                @endif
                            </td>

                            {{-- Actions --}}
                            @if (!auth()->user()?->hasRole('batch-representative'))
                                <td style="white-space:nowrap;">
                                    <div style="display:flex;gap:.28rem;align-items:center;">
                                        @if ($d->status !== 'verified' && $d->status !== 'rejected')
                                            <button wire:click="openApproveModal({{ $d->id }})"
                                                    class="dt-btn dt-btn-ok">
                                                <svg style="width:.6rem;height:.6rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/>
                                                </svg>
                                                Approve
                                            </button>
                                        @endif
                                        @if ($d->status !== 'rejected' && $d->status !== 'verified')
                                            <button wire:click="openRejectModal({{ $d->id }})"
                                                    class="dt-btn dt-btn-no">
                                                <svg style="width:.6rem;height:.6rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                                                </svg>
                                                Reject
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            @endif
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" style="padding:3.5rem 1.5rem;text-align:center;">
                                <div style="max-width:18rem;margin:0 auto;">
                                    <div style="width:2.75rem;height:2.75rem;border-radius:.75rem;
                                                background:#f0f4fb;border:1px solid #e2e8f0;
                                                display:flex;align-items:center;justify-content:center;
                                                margin:0 auto .75rem;">
                                        <svg style="width:1.2rem;height:1.2rem;color:#94a3b8;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25Z"/>
                                        </svg>
                                    </div>
                                    <p style="font-size:.8125rem;font-weight:600;color:#1e293b;">No donations found</p>
                                    <p style="font-size:.72rem;color:#64748b;margin-top:.3rem;">Try adjusting your search or filters.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div style="padding:.8rem 1.25rem;border-top:1px solid #f1f5f9;background:#fafbff;
                    display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:.75rem;">
            <p style="font-size:.7rem;color:#94a3b8;">
                Showing {{ $donations->firstItem() ?? 0 }}–{{ $donations->lastItem() ?? 0 }}
                of {{ number_format($donations->total()) }} records
            </p>
            <div class="[&>*]:!shadow-none">{{ $donations->links() }}</div>
        </div>
    </div>

    {{-- ── MOBILE CARDS ─────────────────────────────────────────── --}}
    <div class="space-y-3 lg:hidden">
        @forelse ($donations as $d)
            @php
                $education = $scopeBatchId
                    ? $d->alumni?->educations?->firstWhere('batch_id', $scopeBatchId)
                    : $d->alumni?->educations?->first();
                $batch = $education?->batch;
                $fullName = trim(collect([
                    $d->alumni?->lname ? $d->alumni->lname . ',' : null,
                    $d->alumni?->fname,
                    $d->alumni?->mname,
                ])->filter()->implode(' '));
            @endphp

            @php
                $statusColor = match($d->status) {
                    'verified' => '#10b981',
                    'rejected' => '#ef4444',
                    default    => '#f59e0b',
                };
            @endphp
            <div class="dc-card">
                {{-- status-color top strip --}}
                <div style="height:3px;background:{{ $statusColor }};"></div>

                <div class="dc-card-inner">
                    {{-- Row 1: name + amount --}}
                    <div style="display:flex;justify-content:space-between;align-items:flex-start;gap:.75rem;">
                        <div style="min-width:0;">
                            <p style="font-size:.8125rem;font-weight:700;color:#1e293b;line-height:1.25;
                                       overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">
                                {{ $fullName ?: 'Unknown Donor' }}
                            </p>
                            <div style="display:flex;align-items:center;gap:.35rem;margin-top:.25rem;flex-wrap:wrap;">
                                @if ($batch)
                                    <span style="font-size:.68rem;color:#64748b;">Batch {{ $batch->yeargrad }}</span>
                                    <span style="font-size:.55rem;color:#cbd5e1;">·</span>
                                    @php
                                        $mobLvlClass = match($batch?->level) {
                                            'elementary' => 'lvl-elem',
                                            'highschool' => 'lvl-hs',
                                            'college'    => 'lvl-col',
                                            default      => 'chip-slate',
                                        };
                                        $mobLvlLabel = match($batch?->level) {
                                            'elementary' => 'Elem',
                                            'highschool' => 'H.S.',
                                            'college'    => 'Col',
                                            default      => '—',
                                        };
                                    @endphp
                                    <span class="chip {{ $mobLvlClass }}" style="font-size:.55rem;padding:.08rem .35rem;">{{ $mobLvlLabel }}</span>
                                @endif
                            </div>
                        </div>
                        <div style="text-align:right;flex-shrink:0;">
                            <p style="font-size:.9rem;font-weight:800;color:#1e293b;
                                       font-variant-numeric:tabular-nums;letter-spacing:-.02em;">
                                ₱{{ number_format($d->amount, 2) }}
                            </p>
                            <div style="margin-top:.2rem;">
                                @if ($d->status === 'verified')
                                    <span class="chip chip-green" style="font-size:.58rem;">
                                        <span class="chip-dot" style="background:#10b981;"></span>Verified
                                    </span>
                                @elseif ($d->status === 'rejected')
                                    <span class="chip chip-red" style="font-size:.58rem;">
                                        <span class="chip-dot" style="background:#ef4444;"></span>Rejected
                                    </span>
                                @else
                                    <span class="chip chip-amber" style="font-size:.58rem;">
                                        <span class="chip-dot" style="background:#f59e0b;"></span>Pending
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>

                    @if ($d->remarks)
                        <p style="font-size:.7rem;color:#94a3b8;margin-top:.5rem;line-height:1.45;
                                   overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">
                            {{ $d->remarks }}
                        </p>
                    @endif

                    {{-- Row 2: meta grid --}}
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:.5rem .75rem;margin-top:.75rem;
                                padding-top:.75rem;border-top:1px solid #f1f5f9;">
                        <div>
                            <p class="dc-meta-label">Date</p>
                            <p style="font-size:.73rem;font-weight:600;color:#334155;">
                                {{ ($d->date_donated ?? $d->created_at)?->format('M d, Y') ?? '—' }}
                            </p>
                        </div>
                        <div>
                            <p class="dc-meta-label">Reference</p>
                            @if ($d->reference_number)
                                <span class="dt-ref" style="font-size:.65rem;">{{ $d->reference_number }}</span>
                            @else
                                <p style="font-size:.73rem;color:#cbd5e1;">—</p>
                            @endif
                        </div>
                    </div>

                    @if ($d->status === 'rejected' && $d->rejection_reason)
                        <div style="margin-top:.65rem;background:#fef2f2;border:1px solid #fecaca;
                                    border-radius:.6rem;padding:.55rem .75rem;">
                            <p style="font-size:.7rem;color:#dc2626;line-height:1.45;">{{ $d->rejection_reason }}</p>
                        </div>
                    @endif

                    {{-- Row 3: footer actions --}}
                    <div style="display:flex;align-items:center;gap:.5rem;margin-top:.75rem;
                                padding-top:.65rem;border-top:1px solid #f1f5f9;flex-wrap:wrap;">
                        @if ($d->or_file_path)
                            <a href="{{ Storage::disk('s3')->url($d->or_file_path) }}" target="_blank"
                               class="dt-btn dt-btn-or" style="text-decoration:none;">
                                <svg style="width:.6rem;height:.6rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z"/>
                                </svg>
                                View OR
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div style="border:2px dashed #e2e8f0;border-radius:1rem;padding:3rem 1.5rem;
                        text-align:center;background:#fff;">
                <p style="font-size:.8125rem;color:#94a3b8;">No donations found.</p>
            </div>
        @endforelse

        {{-- mobile pagination --}}
        @if ($donations->hasPages())
            <div style="background:#fff;border:1px solid #e8edf5;border-radius:1rem;
                        padding:.8rem 1.1rem;display:flex;align-items:center;
                        justify-content:space-between;flex-wrap:wrap;gap:.75rem;">
                <p style="font-size:.7rem;color:#94a3b8;">
                    {{ $donations->firstItem() ?? 0 }}–{{ $donations->lastItem() ?? 0 }} of {{ $donations->total() }}
                </p>
                <div class="[&>*]:!shadow-none">{{ $donations->links() }}</div>
            </div>
        @endif
    </div>

    {{-- ── Batch Donation Upload Modal (batch-rep only) ── --}}
    @if ($isBatchRep && $showUploadModal)
        <div style="position:fixed;inset:0;z-index:9999;display:flex;align-items:center;
                    justify-content:center;background:rgba(0,0,0,.5);">
            <div style="background:#fff;border-radius:1.1rem;padding:1.5rem;
                        width:95vw;max-width:30rem;
                        box-shadow:0 20px 50px rgba(0,0,0,.2);">

                {{-- Header --}}
                <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1.25rem;">
                    <div style="display:flex;align-items:center;gap:.6rem;">
                        <div style="width:2.25rem;height:2.25rem;border-radius:.6rem;
                                    background:linear-gradient(135deg,var(--g5),#a37522);
                                    display:flex;align-items:center;justify-content:center;
                                    box-shadow:0 3px 8px rgba(196,149,42,.3);">
                            <svg style="width:1rem;height:1rem;color:#fff;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5m-13.5-9L12 3m0 0 4.5 4.5M12 3v13.5"/>
                            </svg>
                        </div>
                        <div>
                            <p style="font-size:.875rem;font-weight:800;color:#0f172a;margin:0;">Submit Batch Donation</p>
                            @if ($currentBatch)
                                <p style="font-size:.7rem;color:#64748b;margin:.1rem 0 0;">Batch {{ $currentBatch->yeargrad }}</p>
                            @endif
                        </div>
                    </div>
                    <button wire:click="closeUploadModal"
                            style="width:1.75rem;height:1.75rem;border-radius:.4rem;border:none;
                                   background:#f1f5f9;cursor:pointer;font-size:1.1rem;color:#64748b;">
                        &times;
                    </button>
                </div>

                {{-- Amount --}}
                <div style="margin-bottom:.85rem;">
                    <label class="md-label">
                        Total Amount (₱) <span style="color:#dc2626;">*</span>
                    </label>
                    <input type="number"
                           wire:model="uploadAmount"
                           placeholder="e.g. 5000"
                           min="1"
                           class="md-field">
                    @error('uploadAmount')
                        <p style="font-size:.72rem;color:#dc2626;margin:.25rem 0 0;">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Reference Number --}}
                <div style="margin-bottom:.85rem;">
                    <label class="md-label">Reference / Transaction Number</label>
                    <input type="text"
                           wire:model="uploadReference"
                           placeholder="GCash ref, bank transaction ID…"
                           class="md-field">
                    @error('uploadReference')
                        <p style="font-size:.72rem;color:#dc2626;margin:.25rem 0 0;">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Remarks --}}
                <div style="margin-bottom:.85rem;">
                    <label class="md-label">Remarks <span style="color:#94a3b8;">(optional)</span></label>
                    <textarea wire:model="uploadRemarks"
                              rows="2"
                              placeholder="Additional notes about this donation…"
                              style="width:100%;border-radius:.75rem;border:1px solid #e2e8f0;
                                     background:#fff;padding:.6rem .875rem;font-size:.8125rem;
                                     color:#0f172a;outline:none;resize:vertical;box-sizing:border-box;"
                              onfocus="this.style.borderColor='var(--r6)';this.style.boxShadow='0 0 0 3px rgba(26,63,168,.1)'"
                              onblur="this.style.borderColor='#e2e8f0';this.style.boxShadow='none'"></textarea>
                    @error('uploadRemarks')
                        <p style="font-size:.72rem;color:#dc2626;margin:.25rem 0 0;">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Proof file --}}
                <div style="margin-bottom:1.25rem;">
                    <label class="md-label">
                        Proof of Payment <span style="color:#dc2626;">*</span>
                        <span style="color:#94a3b8;text-transform:none;letter-spacing:normal;">(JPG, PNG, or PDF · max 5 MB)</span>
                    </label>
                    <label style="display:block;border:2px dashed #e2e8f0;border-radius:.875rem;
                                  padding:1.25rem;text-align:center;cursor:pointer;
                                  transition:border-color .15s,background .15s;background:#fafbff;"
                           onmouseover="this.style.borderColor='var(--r6)';this.style.background='#f0f4ff'"
                           onmouseout="this.style.borderColor='#e2e8f0';this.style.background='#fafbff'">
                        <input type="file"
                               wire:model="uploadProof"
                               accept=".jpg,.jpeg,.png,.pdf"
                               style="display:none;">
                        @if ($uploadProof)
                            <div style="display:flex;align-items:center;justify-content:center;gap:.5rem;">
                                <svg style="width:1rem;height:1rem;color:#16a34a;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0z"/>
                                </svg>
                                <span style="font-size:.8rem;font-weight:600;color:#065f46;">
                                    {{ $uploadProof->getClientOriginalName() }}
                                </span>
                            </div>
                            <p style="font-size:.7rem;color:#94a3b8;margin:.35rem 0 0;">Click to change file</p>
                        @else
                            <svg style="width:1.5rem;height:1.5rem;color:#94a3b8;margin:0 auto .5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5m-13.5-9L12 3m0 0 4.5 4.5M12 3v13.5"/>
                            </svg>
                            <p style="font-size:.8rem;font-weight:600;color:#475569;margin:0;">Click to upload proof</p>
                            <p style="font-size:.7rem;color:#94a3b8;margin:.25rem 0 0;">JPG, PNG, or PDF up to 5 MB</p>
                        @endif
                    </label>
                    <div wire:loading wire:target="uploadProof"
                         style="font-size:.72rem;color:#94a3b8;margin-top:.35rem;text-align:center;">
                        Uploading…
                    </div>
                    @error('uploadProof')
                        <p style="font-size:.72rem;color:#dc2626;margin:.3rem 0 0;">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Footer --}}
                <div style="display:flex;gap:.5rem;justify-content:flex-end;">
                    <button wire:click="closeUploadModal"
                            style="padding:.45rem .9rem;border-radius:.6rem;border:1px solid #e2e8f0;
                                   background:#fff;font-size:.8rem;font-weight:600;color:#475569;cursor:pointer;">
                        Cancel
                    </button>
                    <button wire:click="submitBatchDonation"
                            wire:loading.attr="disabled"
                            wire:target="submitBatchDonation,uploadProof"
                            style="display:inline-flex;align-items:center;gap:.4rem;
                                   padding:.45rem 1rem;border-radius:.6rem;border:none;
                                   background:linear-gradient(135deg,var(--g5),#a37522);
                                   font-size:.8rem;font-weight:700;color:#fff;cursor:pointer;
                                   transition:filter .12s;"
                            onmouseover="this.style.filter='brightness(1.08)'"
                            onmouseout="this.style.filter='brightness(1)'">
                        <span wire:loading.remove wire:target="submitBatchDonation">Submit Donation</span>
                        <span wire:loading wire:target="submitBatchDonation">Submitting…</span>
                    </button>
                </div>
            </div>
        </div>
    @endif

    {{-- ── Approve Donation Modal ──────────────────────────────── --}}
    @if (!auth()->user()?->hasRole('batch-representative'))
        <div x-data="{ open: false }"
             @open-approve-modal.window="open = true"
             @close-approve-modal.window="open = false"
             x-show="open"
             x-cloak
             x-transition.opacity
             style="position:fixed;inset:0;z-index:9999;background:rgba(10,31,92,.45);"
             @keydown.escape.window="open = false">

            <div style="display:flex;align-items:center;justify-content:center;min-height:100vh;padding:1rem;"
                 @click.self="open = false">
            <div class="dm-modal" @click.stop>
                <div style="height:3px;background:linear-gradient(90deg,#16a34a,#059669);"></div>

                <div class="dm-modal-body">
                    <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:1.25rem;">
                        <div style="display:flex;align-items:center;gap:.75rem;">
                            <div class="dm-modal-icon"
                                 style="background:linear-gradient(135deg,#16a34a,#059669);
                                        box-shadow:0 3px 10px rgba(22,163,74,.28);">
                                <svg style="width:1rem;height:1rem;color:#fff;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/>
                                </svg>
                            </div>
                            <div>
                                <p style="font-family:Georgia,serif;font-size:.9375rem;font-weight:700;
                                           color:#0f172a;margin:0;line-height:1.25;">Approve Donation</p>
                                <p style="font-size:.72rem;color:#64748b;margin:.15rem 0 0;">Mark this submission as verified</p>
                            </div>
                        </div>
                        <button @click="open = false" class="dm-close-btn">
                            <svg style="width:.8rem;height:.8rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>

                    <div style="background:#f0fdf4;border:1px solid #bbf7d0;border-radius:.75rem;
                                padding:.875rem 1rem;display:flex;align-items:flex-start;gap:.6rem;">
                        <svg style="width:.9rem;height:.9rem;color:#16a34a;flex-shrink:0;margin-top:.1rem;"
                             fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z"/>
                        </svg>
                        <p style="font-size:.78rem;color:#166534;margin:0;line-height:1.6;">
                            This will mark the donation as <strong>verified</strong> and record your review timestamp. The alumni will see their submission as approved.
                        </p>
                    </div>
                </div>

                <div class="dm-modal-footer">
                    <button @click="open = false" class="btn-ghost">Cancel</button>
                    <button wire:click="confirmApprove"
                            wire:loading.attr="disabled"
                            wire:target="confirmApprove"
                            class="dm-action-btn"
                            style="background:linear-gradient(135deg,#16a34a,#059669);
                                   box-shadow:0 2px 8px rgba(22,163,74,.28);">
                        <span wire:loading.remove wire:target="confirmApprove"
                              style="display:inline-flex;align-items:center;gap:.35rem;">
                            <svg style="width:.75rem;height:.75rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/>
                            </svg>
                            Approve
                        </span>
                        <span wire:loading wire:target="confirmApprove">Approving…</span>
                    </button>
                </div>
            </div>
            </div>
        </div>
    @endif

    {{-- ── Reject Donation Modal ───────────────────────────────── --}}
    @if (!auth()->user()?->hasRole('batch-representative'))
        <div x-data="{ open: false }"
             @open-reject-modal.window="open = true"
             @close-reject-modal.window="open = false"
             x-show="open"
             x-cloak
             x-transition.opacity
             style="position:fixed;inset:0;z-index:9999;background:rgba(10,31,92,.45);"
             @keydown.escape.window="open = false">

            <div style="display:flex;align-items:center;justify-content:center;min-height:100vh;padding:1rem;"
                 @click.self="open = false">
            <div class="dm-modal" @click.stop>
                <div style="height:3px;background:linear-gradient(90deg,#dc2626,#b91c1c);"></div>

                <div class="dm-modal-body">
                    <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:1.25rem;">
                        <div style="display:flex;align-items:center;gap:.75rem;">
                            <div class="dm-modal-icon"
                                 style="background:linear-gradient(135deg,#dc2626,#b91c1c);
                                        box-shadow:0 3px 10px rgba(220,38,38,.28);">
                                <svg style="width:1rem;height:1rem;color:#fff;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </div>
                            <div>
                                <p style="font-family:Georgia,serif;font-size:.9375rem;font-weight:700;
                                           color:#0f172a;margin:0;line-height:1.25;">Reject Donation</p>
                                <p style="font-size:.72rem;color:#64748b;margin:.15rem 0 0;">Provide a reason for the rejection</p>
                            </div>
                        </div>
                        <button @click="open = false" class="dm-close-btn">
                            <svg style="width:.8rem;height:.8rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>

                    <div>
                        <label class="md-label">Reason for rejection <span style="color:#dc2626;">*</span></label>
                        <textarea wire:model="rejectReason"
                                  rows="3"
                                  placeholder="Explain why this donation is being rejected…"
                                  style="width:100%;border-radius:.75rem;border:1px solid #e2e8f0;
                                         background:#fff;padding:.6rem .875rem;font-size:.8125rem;
                                         color:#0f172a;outline:none;resize:vertical;box-sizing:border-box;
                                         transition:border-color .15s,box-shadow .15s;"
                                  onfocus="this.style.borderColor='#dc2626';this.style.boxShadow='0 0 0 3px rgba(220,38,38,.1)'"
                                  onblur="this.style.borderColor='#e2e8f0';this.style.boxShadow='none'"></textarea>
                        @error('rejectReason')
                            <p style="font-size:.72rem;color:#dc2626;margin-top:.3rem;">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="dm-modal-footer">
                    <button @click="open = false" class="btn-ghost">Cancel</button>
                    <button wire:click="submitReject"
                            wire:loading.attr="disabled"
                            wire:target="submitReject"
                            class="dm-action-btn"
                            style="background:linear-gradient(135deg,#dc2626,#b91c1c);
                                   box-shadow:0 2px 8px rgba(220,38,38,.22);">
                        <span wire:loading.remove wire:target="submitReject"
                              style="display:inline-flex;align-items:center;gap:.35rem;">
                            <svg style="width:.75rem;height:.75rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                            Confirm Reject
                        </span>
                        <span wire:loading wire:target="submitReject">Rejecting…</span>
                    </button>
                </div>
            </div>
            </div>
        </div>
    @endif

    {{-- OR File Preview Modal --}}
    <div x-data="{ open: false, url: '', ext: '' }"
         @open-or-modal.window="open = true; url = $event.detail.url; ext = $event.detail.ext"
         x-show="open"
         x-cloak
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         style="position:fixed;inset:0;z-index:9999;
                backdrop-filter:blur(24px) saturate(1.2) brightness(.45);
                -webkit-backdrop-filter:blur(24px) saturate(1.2) brightness(.45);
                background:rgba(4,10,30,.72);
                display:flex;flex-direction:column;"
         @click.self="open = false"
         @keydown.escape.window="open = false">

        {{-- Floating toolbar --}}
        <div style="display:flex;align-items:center;justify-content:space-between;
                    padding:.85rem 1.25rem;flex-shrink:0;">

            {{-- Left: title + badge --}}
            <div style="display:flex;align-items:center;gap:.75rem;">
                <div style="width:2.2rem;height:2.2rem;border-radius:.55rem;flex-shrink:0;
                            display:flex;align-items:center;justify-content:center;
                            background:rgba(196,149,42,.22);
                            border:1px solid rgba(196,149,42,.35);
                            backdrop-filter:blur(8px);">
                    <svg style="width:.9rem;height:.9rem;color:#fbbf24;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z"/>
                    </svg>
                </div>
                <div>
                    <p style="font-family:Georgia,serif;font-size:.9rem;font-weight:700;
                               color:#fff;margin:0;line-height:1.2;letter-spacing:-.01em;">Official Receipt</p>
                    <template x-if="ext === 'pdf'">
                        <p style="font-size:.65rem;color:rgba(255,255,255,.5);margin:.1rem 0 0;letter-spacing:.04em;text-transform:uppercase;font-weight:600;">PDF Document</p>
                    </template>
                    <template x-if="ext !== 'pdf'">
                        <p style="font-size:.65rem;color:rgba(255,255,255,.5);margin:.1rem 0 0;letter-spacing:.04em;text-transform:uppercase;font-weight:600;">Image File &middot; click to open full size</p>
                    </template>
                </div>
            </div>

            {{-- Right: actions --}}
            <div style="display:flex;align-items:center;gap:.5rem;">
                <a :href="url" target="_blank"
                   style="display:inline-flex;align-items:center;gap:.38rem;
                          padding:.38rem .85rem;border-radius:.55rem;
                          font-size:.75rem;font-weight:700;color:#fff;
                          text-decoration:none;cursor:pointer;
                          background:rgba(255,255,255,.12);
                          border:1px solid rgba(255,255,255,.2);
                          backdrop-filter:blur(8px);
                          transition:background .15s,border-color .15s;"
                   onmouseover="this.style.background='rgba(255,255,255,.2)';this.style.borderColor='rgba(255,255,255,.35)'"
                   onmouseout="this.style.background='rgba(255,255,255,.12)';this.style.borderColor='rgba(255,255,255,.2)'">
                    <svg style="width:.7rem;height:.7rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 0 0 3 8.25v10.5A2.25 2.25 0 0 0 5.25 21h10.5A2.25 2.25 0 0 0 18 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25"/>
                    </svg>
                    Open in new tab
                </a>
                <button @click="open = false"
                        style="width:2rem;height:2rem;border-radius:.5rem;border:1px solid rgba(255,255,255,.2);
                               background:rgba(255,255,255,.1);backdrop-filter:blur(8px);
                               cursor:pointer;color:rgba(255,255,255,.7);display:flex;
                               align-items:center;justify-content:center;
                               transition:background .15s,color .15s;"
                        onmouseover="this.style.background='rgba(255,255,255,.22)';this.style.color='#fff'"
                        onmouseout="this.style.background='rgba(255,255,255,.1)';this.style.color='rgba(255,255,255,.7)'">
                    <svg style="width:.8rem;height:.8rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>

        {{-- Full-screen preview --}}
        <div style="flex:1;overflow:auto;display:flex;align-items:center;justify-content:center;
                    padding:.5rem 3rem 1rem;">
            <template x-if="ext === 'pdf'">
                <iframe :src="url"
                        style="width:100%;height:100%;min-height:500px;border:none;
                               border-radius:.75rem;
                               box-shadow:0 8px 48px rgba(0,0,0,.6);"></iframe>
            </template>
            <template x-if="ext !== 'pdf'">
                <img :src="url"
                     style="max-width:100%;max-height:calc(100vh - 120px);object-fit:contain;
                            border-radius:.75rem;
                            box-shadow:0 8px 48px rgba(0,0,0,.65);
                            cursor:zoom-in;"
                     @click="window.open(url,'_blank')" />
            </template>
        </div>

        {{-- ESC hint --}}
        <p style="text-align:center;font-size:.65rem;color:rgba(255,255,255,.3);
                  padding-bottom:.75rem;flex-shrink:0;letter-spacing:.06em;">
            Press <kbd style="font-family:ui-monospace,monospace;background:rgba(255,255,255,.1);
                               border:1px solid rgba(255,255,255,.18);border-radius:.25rem;
                               padding:.05rem .35rem;font-size:.62rem;">ESC</kbd> or click outside to close
        </p>
    </div>

</div>
</div>
