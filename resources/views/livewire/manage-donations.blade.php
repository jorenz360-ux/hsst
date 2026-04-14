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
                        <option value="paid">Paid</option>
                        <option value="unpaid">Unpaid</option>
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
    <div class="md-card hidden lg:block">
        <div class="md-card-head">
            <div class="md-card-icon" style="background:#fffbeb;">
                <svg class="w-3.5 h-3.5" style="color:var(--g5);" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm3 0h.008v.008H18V10.5Zm-12 0h.008v.008H6V10.5Z"/>
                </svg>
            </div>
            <div class="flex-1">
                <p class="text-sm font-bold" style="color:#1e293b;">Donation Records</p>
                <p class="text-xs" style="color:#64748b;">Review submission details, payment state, and uploaded proof.</p>
            </div>
            <span class="chip chip-blue" style="font-size:.6rem;">
                {{ $donations->firstItem() ?? 0 }}–{{ $donations->lastItem() ?? 0 }} of {{ number_format($donations->total()) }}
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="md-table min-w-full">
                <thead>
                    <tr>
                        <th>Donor</th>
                        <th>Batch</th>
                        <th class="right">Amount</th>
                        <th>Date Submitted</th>
                        <th>Review Status</th>
                        <th>Payment</th>
                        <th>Reference</th>
                        <th>OR File</th>
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
                            <td style="min-width:190px;">
                                <div class="flex items-start gap-2.5">
                                    <div class="md-avatar mt-0.5">{{ $initials }}</div>
                                    <div>
                                        <p class="text-sm font-semibold leading-tight" style="color:#1e293b;">
                                            {{ $d->alumni?->lname }}, {{ $d->alumni?->fname }}{{ $d->alumni?->mname ? ' '.$d->alumni->mname : '' }}
                                        </p>
                                        @if ($d->remarks)
                                            <p class="text-xs mt-0.5 max-w-[160px] leading-snug" style="color:#64748b;">
                                                {{ $d->remarks }}
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            </td>

                            {{-- Batch --}}
                            <td style="min-width:130px;">
                                @if ($batch)
                                    <p class="text-sm font-semibold" style="color:#1e293b;">{{ $batch->yeargrad }}</p>
                                    <p class="text-xs" style="color:#64748b;">{{ $batch->schoolyear }}</p>
                                    <span class="chip {{ $lvlClass }}" style="font-size:.58rem;margin-top:.25rem;">{{ $lvlLabel }}</span>
                                @else
                                    <span class="text-xs" style="color:#cbd5e1;">—</span>
                                @endif
                            </td>

                            {{-- Amount --}}
                            <td class="right" style="min-width:100px;">
                                <p class="text-sm font-bold" style="color:#1e293b;">₱{{ number_format($d->amount, 2) }}</p>
                            </td>

                            {{-- Date --}}
                            <td style="min-width:145px;">
                                <p class="text-sm" style="color:#334155;">
                                    {{ ($d->date_donated ?? $d->created_at)?->format('M d, Y') ?? '—' }}
                                </p>
                                <p class="text-xs mt-0.5" style="color:#94a3b8;">
                                    {{ ($d->date_donated ?? $d->created_at)?->format('h:i A') ?? '' }}
                                </p>
                                @if ($d->date_donated && $d->created_at)
                                    <p class="text-xs mt-0.5" style="color:#cbd5e1;">
                                        rec. {{ $d->created_at->format('M d') }}
                                    </p>
                                @endif
                            </td>

                            {{-- Review Status --}}
                            <td style="min-width:140px;">
                                @if ($d->status === 'verified')
                                    <span class="chip chip-green">
                                        <span class="chip-dot" style="background:#10b981;"></span>
                                        Verified
                                    </span>
                                    @if ($d->reviewed_at)
                                        <p class="text-xs mt-0.5" style="color:#94a3b8;">
                                            {{ $d->reviewed_at->format('M d, Y') }}
                                        </p>
                                    @endif
                                @elseif ($d->status === 'rejected')
                                    <span class="chip chip-red">
                                        <span class="chip-dot" style="background:#ef4444;"></span>
                                        Rejected
                                    </span>
                                    @if ($d->rejection_reason)
                                        <p class="text-xs mt-1 max-w-[180px] leading-snug" style="color:#dc2626;">
                                            {{ $d->rejection_reason }}
                                        </p>
                                    @endif
                                @else
                                    <span class="chip chip-amber">
                                        <span class="chip-dot" style="background:#d97706;"></span>
                                        Pending
                                    </span>
                                @endif
                            </td>

                            {{-- Payment --}}
                            <td style="min-width:110px;">
                                @if ($d->is_paid)
                                    <span class="chip chip-teal">
                                        <span class="chip-dot" style="background:#0d9488;"></span>
                                        Paid
                                    </span>
                                    @if ($d->paid_at)
                                        <p class="text-xs mt-0.5" style="color:#94a3b8;">{{ $d->paid_at->format('M d, Y') }}</p>
                                    @endif
                                @else
                                    <span class="chip chip-slate">Unpaid</span>
                                @endif
                            </td>

                            {{-- Reference --}}
                            <td style="min-width:120px;">
                                @if ($d->reference_number)
                                    <span class="text-xs font-mono" style="color:#334155;">{{ $d->reference_number }}</span>
                                @else
                                    <span class="text-xs" style="color:#cbd5e1;">—</span>
                                @endif
                            </td>

                            {{-- OR File --}}
                            <td>
                                @if ($d->or_file_path)
                                    <a href="{{ Storage::disk('s3')->url($d->or_file_path) }}"
                                       target="_blank"
                                       style="display:inline-flex;align-items:center;gap:.3rem;
                                              padding:.2rem .6rem;border-radius:.5rem;
                                              background:#fffbeb;border:1px solid #fde68a;
                                              font-size:.68rem;font-weight:700;color:#92700a;
                                              transition:background .12s;"
                                       onmouseover="this.style.background='#fef3c7'"
                                       onmouseout="this.style.background='#fffbeb'">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z"/>
                                        </svg>
                                        View OR
                                    </a>
                                @else
                                    <span class="text-xs" style="color:#cbd5e1;">No file</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" style="padding:3.5rem 1.5rem;text-align:center;">
                                <div style="max-width:20rem;margin:0 auto;">
                                    <div style="width:3rem;height:3rem;border-radius:.875rem;background:#f0f4fb;
                                                border:1px solid #e2e8f0;display:flex;align-items:center;
                                                justify-content:center;margin:0 auto .75rem;">
                                        <svg style="width:1.4rem;height:1.4rem;color:#94a3b8;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25Z"/>
                                        </svg>
                                    </div>
                                    <p class="text-sm font-semibold" style="color:#1e293b;">No donations found</p>
                                    <p class="text-xs mt-1" style="color:#64748b;">Try adjusting your search or filters.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div style="padding:.85rem 1.4rem;border-top:1px solid #f1f5f9;background:#fafbff;
                    display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:.75rem;">
            <p class="text-xs" style="color:#64748b;">
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

            <div class="mob-card">
                <div class="flex items-start justify-between gap-3">
                    <div>
                        <p class="text-sm font-bold" style="color:#1e293b;">{{ $fullName ?: 'Unknown Donor' }}</p>
                        @if ($batch)
                            <p class="text-xs mt-0.5" style="color:#64748b;">
                                Batch {{ $batch->yeargrad }} &bull; {{ $batch->schoolyear }}
                            </p>
                        @endif
                    </div>
                    <p class="text-base font-bold shrink-0" style="color:#1e293b;">₱{{ number_format($d->amount, 2) }}</p>
                </div>

                @if ($d->remarks)
                    <p class="text-xs mt-2 leading-relaxed" style="color:#64748b;">{{ $d->remarks }}</p>
                @endif

                <div class="mt-3 grid grid-cols-2 gap-2 text-xs">
                    <div>
                        <p style="color:#94a3b8;font-size:.6rem;font-weight:700;text-transform:uppercase;letter-spacing:.08em;">Submitted</p>
                        <p class="mt-0.5" style="color:#334155;">
                            {{ ($d->date_donated ?? $d->created_at)?->format('M d, Y') ?? '—' }}
                        </p>
                    </div>
                    <div>
                        <p style="color:#94a3b8;font-size:.6rem;font-weight:700;text-transform:uppercase;letter-spacing:.08em;">Reference</p>
                        <p class="mt-0.5 font-mono" style="color:#334155;">{{ $d->reference_number ?? '—' }}</p>
                    </div>
                </div>

                <div class="mt-3 flex flex-wrap items-center gap-1.5">
                    {{-- review status --}}
                    @if ($d->status === 'verified')
                        <span class="chip chip-green"><span class="chip-dot" style="background:#10b981;"></span>Verified</span>
                    @elseif ($d->status === 'rejected')
                        <span class="chip chip-red"><span class="chip-dot" style="background:#ef4444;"></span>Rejected</span>
                    @else
                        <span class="chip chip-amber"><span class="chip-dot" style="background:#d97706;"></span>Pending</span>
                    @endif

                    {{-- payment --}}
                    @if ($d->is_paid)
                        <span class="chip chip-teal"><span class="chip-dot" style="background:#0d9488;"></span>Paid</span>
                    @else
                        <span class="chip chip-slate">Unpaid</span>
                    @endif

                    {{-- OR file --}}
                    @if ($d->or_file_path)
                        <a href="{{ Storage::disk('s3')->url($d->or_file_path) }}" target="_blank"
                           class="chip chip-amber ml-auto">View OR</a>
                    @endif
                </div>

                @if ($d->status === 'rejected' && $d->rejection_reason)
                    <div class="mt-2 rounded-lg px-3 py-2" style="background:#fef2f2;border:1px solid #fecaca;">
                        <p class="text-xs" style="color:#dc2626;">{{ $d->rejection_reason }}</p>
                    </div>
                @endif
            </div>
        @empty
            <div style="border:2px dashed #e2e8f0;border-radius:1rem;padding:3rem 1.5rem;text-align:center;background:#fff;">
                <p class="text-sm" style="color:#94a3b8;">No donations found.</p>
            </div>
        @endforelse

        {{-- mobile pagination --}}
        @if ($donations->hasPages())
            <div style="background:#fff;border:1px solid #e8edf5;border-radius:1rem;
                        padding:.85rem 1.1rem;display:flex;align-items:center;
                        justify-content:space-between;flex-wrap:wrap;gap:.75rem;">
                <p class="text-xs" style="color:#64748b;">
                    {{ $donations->firstItem() ?? 0 }}–{{ $donations->lastItem() ?? 0 }} of {{ $donations->total() }}
                </p>
                <div class="[&>*]:!shadow-none">{{ $donations->links() }}</div>
            </div>
        @endif
    </div>

</div>
</div>
