<div class="min-h-screen" style="background:#f0f4fb;font-family:'DM Sans',system-ui,sans-serif;">
<style>
    :root {
        --r9:#0a1f5c; --r8:#0f2a7a; --r7:#153591;
        --r6:#1a3fa8; --r5:#2150c8;
        --g5:#c4952a; --g4:#d4a843;
    }

    /* KPI cards */
    .kpi-card {
        background:#fff;border-radius:1rem;border:1px solid #e2e8f0;
        padding:1rem 1.125rem;box-shadow:0 1px 4px rgba(15,23,42,.04);
        display:flex;align-items:flex-start;justify-content:space-between;gap:.75rem;
    }
    .kpi-icon {
        width:2.25rem;height:2.25rem;border-radius:.625rem;
        display:flex;align-items:center;justify-content:center;flex-shrink:0;
    }
    .kpi-label { font-size:.6rem;font-weight:700;letter-spacing:.14em;text-transform:uppercase;color:#94a3b8; }
    .kpi-value { font-size:1.45rem;font-weight:800;color:#0f172a;line-height:1.1;margin-top:.2rem; }
    .kpi-sub   { font-size:.68rem;font-weight:600;margin-top:.3rem; }

    /* Section cards */
    .db-card {
        background:#fff;border-radius:1.25rem;border:1px solid #e2e8f0;
        overflow:hidden;box-shadow:0 1px 6px rgba(15,23,42,.05);
    }
    .db-card-header {
        display:flex;align-items:center;justify-content:space-between;
        padding:.9rem 1.25rem;border-bottom:1px solid #f1f5f9;
    }
    .db-card-eyebrow { font-size:.6rem;font-weight:700;letter-spacing:.16em;text-transform:uppercase;color:var(--g5); }
    .db-card-title   { font-size:.9rem;font-weight:800;color:#0f172a;margin-top:.1rem; }

    /* Table */
    .db-table { width:100%;border-collapse:collapse; }
    .db-table thead th {
        font-size:.6rem;font-weight:700;letter-spacing:.14em;
        text-transform:uppercase;color:#64748b;
        padding:.65rem 1.1rem;text-align:left;white-space:nowrap;
        background:#f8fafc;border-bottom:1px solid #e2e8f0;
    }
    .db-table thead th.right { text-align:right; }
    .db-table tbody tr { border-bottom:1px solid #f1f5f9;transition:background .1s; }
    .db-table tbody tr:last-child { border-bottom:none; }
    .db-table tbody tr:hover { background:#f8faff; }
    .db-table td { padding:.8rem 1.1rem;vertical-align:middle; }
    .db-table td.right { text-align:right; }

    /* Chips */
    .status-chip { display:inline-flex;align-items:center;gap:.3rem;padding:.2rem .6rem;border-radius:999px;font-size:.68rem;font-weight:700;white-space:nowrap; }
    .status-dot  { width:.42rem;height:.42rem;border-radius:50%;flex-shrink:0; }
    .chip-green  { background:#ecfdf5;color:#065f46;border:1px solid #a7f3d0; }
    .chip-slate  { background:#f1f5f9;color:#475569;border:1px solid #e2e8f0; }
    .chip-blue   { background:#eef2ff;color:var(--r6);border:1px solid #c7d2fe; }
    .chip-amber  { background:#fffbeb;color:#92700a;border:1px solid #fde68a; }
    .chip-red    { background:#fff5f5;color:#dc2626;border:1px solid #fca5a5; }

    /* Avatar */
    .db-avatar {
        width:2rem;height:2rem;border-radius:.5rem;
        display:flex;align-items:center;justify-content:center;
        font-size:.7rem;font-weight:800;color:#fff;flex-shrink:0;
        background:linear-gradient(135deg,var(--r6),var(--r8));
        box-shadow:0 2px 6px rgba(21,53,145,.22);letter-spacing:.04em;
    }

    /* Header action buttons */
    .btn-header-action {
        display:inline-flex;align-items:center;gap:.4rem;
        height:2.125rem;padding:0 .875rem;border-radius:.65rem;
        background:rgba(255,255,255,.13);border:1px solid rgba(255,255,255,.2);
        color:#fff;font-size:.75rem;font-weight:600;
        transition:background .15s;text-decoration:none;white-space:nowrap;cursor:pointer;
    }
    .btn-header-action:hover { background:rgba(255,255,255,.2); }

    /* Sum chip in header */
    .sum-chip { display:inline-flex;align-items:center;gap:.5rem;padding:.35rem .85rem;border-radius:999px;font-size:.7rem;font-weight:700;white-space:nowrap; }

    /* Filter inputs */
    .f-input {
        height:2.1rem;border-radius:.6rem;border:1px solid #e2e8f0;background:#fff;
        padding:0 .75rem;font-size:.78rem;color:#0f172a;outline:none;
        transition:border-color .15s,box-shadow .15s;width:100%;
    }
    .f-input::placeholder { color:#94a3b8; }
    .f-input:focus { border-color:var(--r6);box-shadow:0 0 0 3px rgba(26,63,168,.08); }
    .f-select {
        height:2.1rem;border-radius:.6rem;border:1px solid #e2e8f0;
        background:#fff url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%2394a3b8' stroke-width='2'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' d='M19 9l-7 7-7-7'/%3E%3C/svg%3E") no-repeat right .6rem center / .75rem;
        padding:0 1.75rem 0 .75rem;font-size:.78rem;color:#0f172a;
        outline:none;appearance:none;width:100%;cursor:pointer;
        transition:border-color .15s,box-shadow .15s;
    }
    .f-select:focus { border-color:var(--r6);box-shadow:0 0 0 3px rgba(26,63,168,.08); }
    .f-label { display:block;font-size:.6rem;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:#94a3b8;margin-bottom:.25rem; }

    /* Status pill filter */
    .spill {
        display:inline-flex;align-items:center;gap:.3rem;
        padding:.28rem .7rem;border-radius:2rem;font-size:.76rem;font-weight:600;
        border:1px solid #e2e8f0;background:#fff;color:#64748b;
        cursor:pointer;transition:all .15s;white-space:nowrap;
    }
    .spill:hover  { border-color:#94a3b8;color:#1e293b; }
    .spill.sp-all      { background:#0f172a;border-color:#0f172a;color:#fff; }
    .spill.sp-pending  { background:#fffbeb;border-color:#fde68a;color:#92700a; }
    .spill.sp-verified { background:#ecfdf5;border-color:#a7f3d0;color:#065f46; }
    .spill.sp-rejected { background:#fff5f5;border-color:#fca5a5;color:#dc2626; }

    /* Action buttons */
    .btn-verify {
        display:inline-flex;align-items:center;gap:.25rem;padding:.22rem .6rem;
        border-radius:.45rem;cursor:pointer;background:#ecfdf5;
        border:1px solid #a7f3d0;font-size:.68rem;font-weight:700;color:#065f46;
        transition:background .12s;
    }
    .btn-verify:hover { background:#d1fae5; }
    .btn-reject-sm {
        display:inline-flex;align-items:center;gap:.25rem;padding:.22rem .6rem;
        border-radius:.45rem;cursor:pointer;background:#fff5f5;
        border:1px solid #fca5a5;font-size:.68rem;font-weight:700;color:#dc2626;
        transition:background .12s;
    }
    .btn-reject-sm:hover { background:#fee2e2; }
    .btn-view-proof {
        display:inline-flex;align-items:center;gap:.3rem;padding:.2rem .6rem;
        border-radius:.5rem;cursor:pointer;background:#fffbeb;
        border:1px solid #fde68a;font-size:.68rem;font-weight:700;color:#92700a;
        transition:background .12s;
    }
    .btn-view-proof:hover { background:#fef3c7; }

    [x-cloak] { display:none !important; }
</style>

<div class="space-y-5 px-4 py-6 sm:px-6 lg:px-8 mx-auto max-w-screen-2xl">

    {{-- ════════ HEADER BANNER ════════ --}}
    <section class="overflow-hidden rounded-2xl"
             style="background:linear-gradient(155deg,var(--r8) 0%,var(--r7) 45%,var(--r6) 100%);
                    box-shadow:0 8px 32px rgba(10,31,92,.28);">
        <div style="position:relative;padding:1.5rem 2rem;">
            <span style="position:absolute;right:2rem;top:50%;transform:translateY(-50%);
                         font-family:Georgia,serif;font-size:6rem;font-weight:900;color:#fff;
                         opacity:.025;letter-spacing:.05em;user-select:none;white-space:nowrap;pointer-events:none;">
                DONATIONS
            </span>

            <div class="relative flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
                <div>
                    <p style="font-size:.65rem;font-weight:800;letter-spacing:.22em;text-transform:uppercase;color:var(--g4);margin:0 0 .4rem;">
                        HSSTian Alumni Association &middot; Admin Panel
                    </p>
                    <h1 style="font-size:1.6rem;font-weight:800;color:#fff;margin:0 0 .35rem;
                               font-family:Georgia,serif;letter-spacing:-.01em;">
                        Donation Verification
                    </h1>
                    <p style="font-size:.8125rem;color:rgba(255,255,255,.55);max-width:50ch;margin:0;">
                        Review uploaded donation proofs, verify valid submissions, and reject incorrect or unclear records.
                    </p>
                </div>
                <div class="flex flex-wrap items-center gap-2 lg:mt-1 lg:shrink-0">
                    <a href="{{ route('dashboard') }}" wire:navigate class="btn-header-action">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"/>
                        </svg>
                        Dashboard
                    </a>
                </div>
            </div>

            {{-- Summary strip --}}
            <div class="mt-4 flex flex-wrap items-center gap-2 pt-4" style="border-top:1px solid rgba(255,255,255,.12);">
                <span class="sum-chip" style="background:rgba(255,255,255,.14);color:#fff;border:1px solid rgba(255,255,255,.18);">
                    <svg class="w-3.5 h-3.5" style="opacity:.7;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75"/>
                    </svg>
                    <span style="color:rgba(255,255,255,.55);">Filtered Total</span>
                    <strong>₱{{ number_format($totalAmount, 2) }}</strong>
                </span>
                <span class="sum-chip" style="background:rgba(251,191,36,.14);color:#fde68a;border:1px solid rgba(251,191,36,.2);">
                    <span class="status-dot" style="background:#fde68a;"></span>
                    Pending: <strong>{{ $pendingCount }}</strong>
                </span>
                @if ($hasActiveFilters)
                    <button wire:click="clearFilters"
                            class="sum-chip"
                            style="background:rgba(220,38,38,.15);color:#fca5a5;border:1px solid rgba(220,38,38,.2);cursor:pointer;">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                        Clear Filters
                    </button>
                @endif
                <span class="sum-chip" style="background:rgba(255,255,255,.08);color:rgba(255,255,255,.4);border:1px solid rgba(255,255,255,.1);font-size:.62rem;margin-left:auto;">
                    {{ now()->format('l, F j, Y') }}
                </span>
            </div>
        </div>
    </section>

    {{-- ════════ KPI ROW ════════ --}}
    <div class="grid grid-cols-2 gap-3 sm:grid-cols-4">

        <div class="kpi-card" style="border-left:3px solid var(--r6);">
            <div>
                <p class="kpi-label">Filtered Total</p>
                <p class="kpi-value">₱{{ number_format($totalAmount) }}</p>
                <p class="kpi-sub" style="color:var(--r6);">Current filter</p>
            </div>
            <div class="kpi-icon" style="background:#eef2ff;">
                <svg class="w-4 h-4" style="color:var(--r6);" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9"/>
                </svg>
            </div>
        </div>

        <div class="kpi-card" style="border-left:3px solid #d97706;">
            <div>
                <p class="kpi-label">Pending Review</p>
                <p class="kpi-value">{{ $pendingCount }}</p>
                <p class="kpi-sub" style="color:#d97706;">Awaiting action</p>
            </div>
            <div class="kpi-icon" style="background:#fffbeb;">
                <svg class="w-4 h-4" style="color:#d97706;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                </svg>
            </div>
        </div>

        <div class="kpi-card" style="border-left:3px solid #16a34a;">
            <div>
                <p class="kpi-label">Records Shown</p>
                <p class="kpi-value">{{ $donations->total() }}</p>
                <p class="kpi-sub" style="color:#16a34a;">Matching filter</p>
            </div>
            <div class="kpi-icon" style="background:#ecfdf5;">
                <svg class="w-4 h-4" style="color:#16a34a;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                </svg>
            </div>
        </div>

        <div class="kpi-card" style="border-left:3px solid var(--g5);">
            <div>
                <p class="kpi-label">Status Filter</p>
                <p class="kpi-value" style="font-size:1rem;margin-top:.35rem;">
                    {{ ucfirst($statusFilter === 'all' ? 'All' : $statusFilter) }}
                </p>
                <p class="kpi-sub" style="color:var(--g5);">
                    {{ $paymentFilter === 'all' ? 'Any payment' : ucfirst($paymentFilter) }}
                </p>
            </div>
            <div class="kpi-icon" style="background:#fffbeb;">
                <svg class="w-4 h-4" style="color:var(--g5);" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 3c2.755 0 5.455.232 8.083.678.533.09.917.556.917 1.096v1.044a2.25 2.25 0 0 1-.659 1.591l-5.432 5.432a2.25 2.25 0 0 0-.659 1.591v2.927a2.25 2.25 0 0 1-1.244 2.013L9.75 21v-6.568a2.25 2.25 0 0 0-.659-1.591L3.659 7.409A2.25 2.25 0 0 1 3 5.818V4.774c0-.54.384-1.006.917-1.096A48.32 48.32 0 0 1 12 3Z"/>
                </svg>
            </div>
        </div>
    </div>

    @include('partials.toast')

    {{-- ════════ FILTERS ════════ --}}
    <div class="db-card">
        <div class="db-card-header">
            <div>
                <p class="db-card-eyebrow">Filters</p>
                <p class="db-card-title">Refine Results</p>
            </div>
            @if ($hasActiveFilters)
                <button wire:click="clearFilters"
                        style="display:inline-flex;align-items:center;gap:.3rem;
                               padding:.3rem .7rem;border-radius:.5rem;cursor:pointer;
                               background:#fff5f5;border:1px solid #fca5a5;
                               font-size:.72rem;font-weight:700;color:#dc2626;">
                    <svg style="width:.65rem;height:.65rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                    Clear all
                </button>
            @endif
        </div>

        <div style="padding:1rem 1.25rem;display:flex;flex-direction:column;gap:.875rem;">

            {{-- Row 1: Status + Search --}}
            <div style="display:flex;flex-wrap:wrap;gap:.75rem;align-items:flex-end;">
                <div style="flex:1;min-width:220px;">
                    <span class="f-label">Review Status</span>
                    <div style="display:flex;flex-wrap:wrap;gap:.3rem;">
                        <button wire:click="$set('statusFilter','all')"
                                class="spill {{ $statusFilter === 'all' ? 'sp-all' : '' }}">All</button>
                        <button wire:click="$set('statusFilter','pending')"
                                class="spill {{ $statusFilter === 'pending' ? 'sp-pending' : '' }}">
                            <span class="status-dot" style="background:#d97706;"></span> Pending
                        </button>
                        <button wire:click="$set('statusFilter','verified')"
                                class="spill {{ $statusFilter === 'verified' ? 'sp-verified' : '' }}">
                            <span class="status-dot" style="background:#16a34a;"></span> Verified
                        </button>
                        <button wire:click="$set('statusFilter','rejected')"
                                class="spill {{ $statusFilter === 'rejected' ? 'sp-rejected' : '' }}">
                            <span class="status-dot" style="background:#dc2626;"></span> Rejected
                        </button>
                    </div>
                </div>
                <div style="flex:1;min-width:200px;max-width:280px;">
                    <span class="f-label">Search</span>
                    <div style="position:relative;">
                        <svg style="position:absolute;left:.65rem;top:50%;transform:translateY(-50%);
                                    width:.8rem;height:.8rem;color:#94a3b8;pointer-events:none;"
                             fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/>
                        </svg>
                        <input type="text"
                               wire:model.live.debounce.300ms="search"
                               placeholder="Donor, reference…"
                               class="f-input"
                               style="padding-left:2rem;">
                    </div>
                </div>
            </div>

            {{-- Row 2: Payment + Batch + Date range + Amount range --}}
            <div style="display:flex;flex-wrap:wrap;gap:.75rem;align-items:flex-end;">

                {{-- Payment --}}
                <div style="min-width:130px;flex:1;">
                    <span class="f-label">Payment</span>
                    <select wire:model.live="paymentFilter" class="f-select">
                        <option value="all">All</option>
                        <option value="paid">Paid</option>
                        <option value="unpaid">Unpaid</option>
                    </select>
                </div>

                {{-- Batch --}}
                <div style="min-width:160px;flex:2;">
                    <span class="f-label">Batch (Year Grad)</span>
                    <select wire:model.live="batchFilter" class="f-select">
                        <option value="">All Batches</option>
                        @foreach ($batches as $batch)
                            <option value="{{ $batch->id }}">
                                {{ $batch->yeargrad }}
                                @if ($batch->schoolyear) ({{ $batch->schoolyear }}) @endif
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Date range --}}
                <div style="min-width:130px;flex:1;">
                    <span class="f-label">Date From</span>
                    <input type="date" wire:model.live="dateFrom" class="f-input">
                </div>
                <div style="min-width:130px;flex:1;">
                    <span class="f-label">Date To</span>
                    <input type="date" wire:model.live="dateTo" class="f-input">
                </div>

                {{-- Amount range --}}
                <div style="min-width:110px;flex:1;">
                    <span class="f-label">Amount Min (₱)</span>
                    <input type="number" wire:model.live.debounce.400ms="amountMin"
                           placeholder="0" min="0" class="f-input">
                </div>
                <div style="min-width:110px;flex:1;">
                    <span class="f-label">Amount Max (₱)</span>
                    <input type="number" wire:model.live.debounce.400ms="amountMax"
                           placeholder="∞" min="0" class="f-input">
                </div>
            </div>
        </div>
    </div>

    {{-- ════════ DESKTOP TABLE ════════ --}}
    <div class="db-card hidden lg:block">
        <div class="db-card-header">
            <div>
                <p class="db-card-eyebrow">Records</p>
                <p class="db-card-title">Donation Submissions</p>
            </div>
            <div style="display:flex;align-items:center;gap:.75rem;">
                <span wire:loading style="font-size:.72rem;color:#94a3b8;">Loading…</span>
                <span style="font-size:.72rem;color:#94a3b8;">
                    {{ $donations->total() }} {{ Str::plural('record', $donations->total()) }}
                </span>
            </div>
        </div>

        <div style="overflow-x:auto;">
            <table class="db-table">
                <thead>
                    <tr>
                        <th>Donor</th>
                        <th class="right">Amount</th>
                        <th>Reference</th>
                        <th>Submitted</th>
                        <th>Status</th>
                        <th>Payment</th>
                        <th>Proof</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($donations as $donation)
                        <tr>
                            {{-- Donor --}}
                            <td style="min-width:190px;">
                                <div style="display:flex;align-items:center;gap:.625rem;">
                                    <div>
                                        @php
                                            $donorEducations = $donation->alumni?->educations ?? collect();
                                        @endphp
                                        @if ($donorEducations->isNotEmpty())
                                            <div style="display:flex;flex-wrap:wrap;gap:.2rem;margin-top:.15rem;">
                                            @foreach ($donorEducations as $donorEdu)
                                                @php
                                                    $lvlAbbr = match($donorEdu->batch?->level) {
                                                        'elementary' => 'Elem',
                                                        'highschool' => 'HS',
                                                        'college'    => 'Col',
                                                        default      => null,
                                                    };
                                                @endphp
                                                <span class="status-chip chip-blue" style="font-size:.6rem;">
                                                    {{ $lvlAbbr ? $lvlAbbr . ' ' : '' }}{{ $donorEdu->batch?->yeargrad ?? '—' }}
                                                </span>
                                            @endforeach
                                            </div>
                                        @else
                                            <span style="font-size:.68rem;color:#cbd5e1;margin:.1rem 0 0;display:block;">No batch</span>
                                        @endif
                                    </div>
                                </div>
                            </td>

                            {{-- Amount --}}
                            <td class="right" style="min-width:100px;">
                                <span style="font-size:.9rem;font-weight:800;color:#0f172a;">
                                    ₱{{ number_format($donation->amount ?? 0, 2) }}
                                </span>
                            </td>

                            {{-- Reference --}}
                            <td style="min-width:130px;">
                                @if ($donation->reference_number)
                                    <span style="font-family:monospace;font-size:.75rem;color:#334155;">
                                        {{ $donation->reference_number }}
                                    </span>
                                @else
                                    <span style="color:#cbd5e1;font-size:.75rem;">—</span>
                                @endif
                            </td>

                            {{-- Submitted --}}
                            <td style="min-width:110px;">
                                <p style="font-size:.78rem;color:#334155;margin:0;">
                                    {{ $donation->created_at?->format('M d, Y') ?? '—' }}
                                </p>
                                <p style="font-size:.68rem;color:#94a3b8;margin:.1rem 0 0;">
                                    {{ $donation->created_at?->format('h:i A') ?? '' }}
                                </p>
                            </td>

                            {{-- Review Status --}}
                            <td style="min-width:120px;">
                                @if ($donation->status === 'verified')
                                    <span class="status-chip chip-green">
                                        <span class="status-dot" style="background:#16a34a;"></span> Verified
                                    </span>
                                    @if ($donation->reviewed_at)
                                        <p style="font-size:.67rem;color:#94a3b8;margin:.25rem 0 0;">
                                            {{ $donation->reviewed_at->format('M d, Y') }}
                                        </p>
                                    @endif
                                @elseif ($donation->status === 'rejected')
                                    <span class="status-chip chip-red">
                                        <span class="status-dot" style="background:#ef4444;"></span> Rejected
                                    </span>
                                    @if ($donation->rejection_reason)
                                        <p style="font-size:.67rem;color:#dc2626;margin:.25rem 0 0;max-width:150px;line-height:1.3;">
                                            {{ $donation->rejection_reason }}
                                        </p>
                                    @endif
                                @else
                                    <span class="status-chip chip-amber">
                                        <span class="status-dot" style="background:#d97706;"></span> Pending
                                    </span>
                                @endif
                            </td>

                            {{-- Payment --}}
                            <td style="min-width:90px;">
                                @if ($donation->is_paid)
                                    <span class="status-chip chip-blue">
                                        <span class="status-dot" style="background:var(--r6);"></span> Paid
                                    </span>
                                @else
                                    <span class="status-chip chip-slate">Unpaid</span>
                                @endif
                            </td>

                            {{-- Proof --}}
                            <td>
                                @if ($donation->or_file_path)
                                    @php
                                        /** @var \Illuminate\Filesystem\FilesystemAdapter $s3 */
                                        $s3       = Storage::disk('s3');
                                        $proofUrl = $s3->url($donation->or_file_path);
                                        $proofExt = strtolower(pathinfo($donation->or_file_path, PATHINFO_EXTENSION));
                                    @endphp
                                    <button type="button" x-data
                                            @click="$dispatch('open-proof-modal',{url:'{{ $proofUrl }}',ext:'{{ $proofExt }}'})"
                                            class="btn-view-proof">
                                        <svg style="width:.65rem;height:.65rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z"/>
                                        </svg>
                                        View
                                    </button>
                                @else
                                    <span style="font-size:.72rem;color:#cbd5e1;">No file</span>
                                @endif
                            </td>

                            {{-- Actions --}}
                            <td style="white-space:nowrap;">
                                <div style="display:flex;gap:.3rem;">
                                    @if ($donation->status === 'pending')
                                        <button wire:click="verifyDonation({{ $donation->id }})"
                                                wire:confirm="Verify this donation?"
                                                class="btn-verify">
                                            <svg style="width:.65rem;height:.65rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/>
                                            </svg>
                                            Verify
                                        </button>
                                        <button wire:click="openRejectModal({{ $donation->id }})"
                                                class="btn-reject-sm">
                                            <svg style="width:.65rem;height:.65rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                                            </svg>
                                            Reject
                                        </button>
                                    @else
                                        <span style="font-size:.7rem;color:#94a3b8;">
                                            @if ($donation->reviewed_at)
                                                Reviewed {{ $donation->reviewed_at->format('M d') }}
                                            @else
                                                —
                                            @endif
                                        </span>
                                    @endif
                                </div>
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
                                    <p style="font-size:.875rem;font-weight:600;color:#1e293b;margin:0;">No donations found</p>
                                    <p style="font-size:.78rem;color:#64748b;margin:.35rem 0 0;">Try adjusting your filters.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div style="padding:.85rem 1.25rem;border-top:1px solid #f1f5f9;background:#fafbff;
                    display:flex;align-items:center;justify-content:flex-end;">
            <div class="[&>*]:!shadow-none">{{ $donations->links() }}</div>
        </div>
    </div>

    {{-- ════════ MOBILE CARDS ════════ --}}
    <div class="lg:hidden space-y-3">
        @forelse ($donations as $donation)
            <div style="background:#fff;border:1px solid #e2e8f0;border-radius:1.1rem;
                        padding:1.1rem;box-shadow:0 1px 4px rgba(15,23,42,.04);">

                <div style="display:flex;align-items:flex-start;justify-content:space-between;gap:.75rem;">
                    <div style="display:flex;align-items:center;gap:.6rem;">
                        <div class="db-avatar" style="width:2.25rem;height:2.25rem;font-size:.75rem;">
                            {{ strtoupper(substr($donation->alumni->fname ?? '?', 0, 1)) }}
                        </div>
                        <div>
                            <p style="font-size:.875rem;font-weight:700;color:#0f172a;margin:0;">
                                {{ trim(($donation->alumni->fname ?? '') . ' ' . ($donation->alumni->lname ?? '')) ?: 'Unknown' }}
                            </p>
                            @php $mBatch = $donation->alumni?->educations?->first()?->batch; @endphp
                            @if ($mBatch)
                                <span class="status-chip chip-blue" style="font-size:.6rem;margin:.15rem 0 .1rem;">
                                    Batch {{ $mBatch->yeargrad }}
                                </span>
                            @endif
                            <p style="font-size:.9rem;font-weight:800;color:#0f172a;margin:.1rem 0 0;">
                                ₱{{ number_format($donation->amount ?? 0, 2) }}
                            </p>
                        </div>
                    </div>
                    <div style="display:flex;flex-direction:column;gap:.3rem;align-items:flex-end;">
                        @if ($donation->status === 'verified')
                            <span class="status-chip chip-green"><span class="status-dot" style="background:#16a34a;"></span> Verified</span>
                        @elseif ($donation->status === 'rejected')
                            <span class="status-chip chip-red"><span class="status-dot" style="background:#ef4444;"></span> Rejected</span>
                        @else
                            <span class="status-chip chip-amber"><span class="status-dot" style="background:#d97706;"></span> Pending</span>
                        @endif
                        @if ($donation->is_paid)
                            <span class="status-chip chip-blue" style="font-size:.62rem;">Paid</span>
                        @else
                            <span class="status-chip chip-slate" style="font-size:.62rem;">Unpaid</span>
                        @endif
                    </div>
                </div>

                <div style="margin-top:.85rem;display:grid;grid-template-columns:1fr 1fr;gap:.5rem;">
                    <div style="background:#f8fafc;border:1px solid #f1f5f9;border-radius:.65rem;padding:.6rem .75rem;">
                        <p style="font-size:.58rem;font-weight:700;letter-spacing:.08em;text-transform:uppercase;color:#94a3b8;margin:0 0 .2rem;">Reference</p>
                        <p style="font-size:.78rem;font-family:monospace;color:#334155;margin:0;">{{ $donation->reference_number ?: '—' }}</p>
                    </div>
                    <div style="background:#f8fafc;border:1px solid #f1f5f9;border-radius:.65rem;padding:.6rem .75rem;">
                        <p style="font-size:.58rem;font-weight:700;letter-spacing:.08em;text-transform:uppercase;color:#94a3b8;margin:0 0 .2rem;">Submitted</p>
                        <p style="font-size:.78rem;color:#334155;margin:0;">{{ $donation->created_at?->format('M d, Y') ?? '—' }}</p>
                    </div>
                    @if ($donation->remarks)
                        <div style="grid-column:span 2;background:#f8fafc;border:1px solid #f1f5f9;border-radius:.65rem;padding:.6rem .75rem;">
                            <p style="font-size:.58rem;font-weight:700;letter-spacing:.08em;text-transform:uppercase;color:#94a3b8;margin:0 0 .2rem;">Remarks</p>
                            <p style="font-size:.78rem;color:#334155;margin:0;">{{ $donation->remarks }}</p>
                        </div>
                    @endif
                    @if ($donation->rejection_reason)
                        <div style="grid-column:span 2;background:#fff5f5;border:1px solid #fca5a5;border-left:3px solid #ef4444;border-radius:.65rem;padding:.6rem .75rem;">
                            <p style="font-size:.58rem;font-weight:700;letter-spacing:.08em;text-transform:uppercase;color:#dc2626;margin:0 0 .2rem;">Rejection Reason</p>
                            <p style="font-size:.78rem;color:#dc2626;margin:0;">{{ $donation->rejection_reason }}</p>
                        </div>
                    @endif
                </div>

                <div style="margin-top:.85rem;display:flex;flex-wrap:wrap;gap:.4rem;">
                    @if ($donation->or_file_path)
                        @php
                            /** @var \Illuminate\Filesystem\FilesystemAdapter $s3m */
                            $s3m      = Storage::disk('s3');
                            $pUrlM    = $s3m->url($donation->or_file_path);
                            $pExtM    = strtolower(pathinfo($donation->or_file_path, PATHINFO_EXTENSION));
                        @endphp
                        <button type="button" x-data
                                @click="$dispatch('open-proof-modal',{url:'{{ $pUrlM }}',ext:'{{ $pExtM }}'})"
                                class="btn-view-proof">
                            <svg style="width:.65rem;height:.65rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z"/>
                            </svg>
                            View Proof
                        </button>
                    @endif
                    @if ($donation->status === 'pending')
                        <button wire:click="verifyDonation({{ $donation->id }})" wire:confirm="Verify this donation?" class="btn-verify">
                            <svg style="width:.65rem;height:.65rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/>
                            </svg>
                            Verify
                        </button>
                        <button wire:click="openRejectModal({{ $donation->id }})" class="btn-reject-sm">
                            <svg style="width:.65rem;height:.65rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                            Reject
                        </button>
                    @endif
                </div>
            </div>
        @empty
            <div style="background:#fff;border:1px solid #e2e8f0;border-radius:1.1rem;
                        padding:3rem 1.5rem;text-align:center;">
                <p style="font-size:.875rem;font-weight:600;color:#1e293b;margin:0;">No donations found</p>
                <p style="font-size:.78rem;color:#64748b;margin:.35rem 0 0;">Try adjusting your filters.</p>
            </div>
        @endforelse

        <div>{{ $donations->links() }}</div>
    </div>

</div>

{{-- ════════ REJECT MODAL ════════ --}}
@if ($rejectingDonationId)
    <div style="position:fixed;inset:0;z-index:9999;display:flex;align-items:center;
                justify-content:center;background:rgba(0,0,0,.5);">
        <div style="background:#fff;border-radius:1rem;padding:1.5rem;
                    width:95vw;max-width:26rem;box-shadow:0 20px 50px rgba(0,0,0,.2);">
            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1rem;">
                <div style="display:flex;align-items:center;gap:.5rem;">
                    <div style="width:2rem;height:2rem;border-radius:.5rem;background:#fee2e2;
                                border:1px solid #fca5a5;display:flex;align-items:center;justify-content:center;">
                        <svg style="width:.9rem;height:.9rem;color:#dc2626;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </div>
                    <span style="font-size:.875rem;font-weight:700;color:#0f172a;">Reject Donation</span>
                </div>
                <button wire:click="closeRejectModal"
                        style="width:1.75rem;height:1.75rem;border-radius:.4rem;border:none;
                               background:#f1f5f9;cursor:pointer;font-size:1.1rem;color:#64748b;">&times;</button>
            </div>
            <div style="margin-bottom:1rem;">
                <label style="display:block;font-size:.6rem;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:#94a3b8;margin-bottom:.25rem;">
                    Reason <span style="color:#dc2626;">*</span>
                </label>
                <textarea wire:model="rejectionReason" rows="3"
                          placeholder="Explain why this donation is being rejected…"
                          style="width:100%;border-radius:.75rem;border:1px solid #e2e8f0;
                                 background:#fff;padding:.6rem .875rem;font-size:.8125rem;
                                 color:#0f172a;outline:none;resize:vertical;box-sizing:border-box;"
                          onfocus="this.style.borderColor='#dc2626';this.style.boxShadow='0 0 0 3px rgba(220,38,38,.1)'"
                          onblur="this.style.borderColor='#e2e8f0';this.style.boxShadow='none'"></textarea>
                @error('rejectionReason')
                    <p style="font-size:.72rem;color:#dc2626;margin:.3rem 0 0;">{{ $message }}</p>
                @enderror
            </div>
            <div style="display:flex;gap:.5rem;justify-content:flex-end;">
                <button wire:click="closeRejectModal"
                        style="padding:.45rem .9rem;border-radius:.6rem;border:1px solid #e2e8f0;
                               background:#fff;font-size:.8rem;font-weight:600;color:#475569;cursor:pointer;">
                    Cancel
                </button>
                <button wire:click="rejectDonation"
                        style="padding:.45rem .9rem;border-radius:.6rem;border:none;background:#dc2626;
                               font-size:.8rem;font-weight:700;color:#fff;cursor:pointer;"
                        onmouseover="this.style.background='#b91c1c'"
                        onmouseout="this.style.background='#dc2626'">
                    Confirm Reject
                </button>
            </div>
        </div>
    </div>
@endif

{{-- ════════ PROOF MODAL ════════ --}}
<div x-data="{ open:false, url:'', ext:'' }"
     @open-proof-modal.window="open=true; url=$event.detail.url; ext=$event.detail.ext"
     x-show="open" x-cloak x-transition.opacity
     style="position:fixed;inset:0;z-index:9999;display:flex;align-items:center;
            justify-content:center;background:rgba(0,0,0,.55);"
     @click.self="open=false" @keydown.escape.window="open=false">
    <div style="background:#fff;border-radius:1rem;padding:1.25rem;max-width:52rem;width:95vw;
                max-height:92vh;display:flex;flex-direction:column;gap:1rem;
                box-shadow:0 25px 60px rgba(0,0,0,.25);">
        <div style="display:flex;justify-content:space-between;align-items:center;">
            <span style="font-size:.875rem;font-weight:700;color:#0f172a;">Donation Proof</span>
            <div style="display:flex;gap:.5rem;align-items:center;">
                <a :href="url" target="_blank"
                   style="font-size:.72rem;font-weight:600;color:var(--r5);text-decoration:none;
                          padding:.25rem .6rem;border:1px solid #bfdbfe;border-radius:.4rem;background:#eff6ff;">
                    Open in new tab
                </a>
                <button @click="open=false"
                        style="width:1.75rem;height:1.75rem;border-radius:.4rem;border:none;
                               background:#f1f5f9;cursor:pointer;font-size:1.1rem;color:#64748b;">&times;</button>
            </div>
        </div>
        <div style="overflow:auto;flex:1;border-radius:.5rem;background:#f8fafc;border:1px solid #e2e8f0;
                    display:flex;align-items:center;justify-content:center;min-height:16rem;">
            <template x-if="ext === 'pdf'">
                <iframe :src="url" style="width:100%;height:70vh;border:none;border-radius:.5rem;"></iframe>
            </template>
            <template x-if="ext !== 'pdf'">
                <img :src="url" style="max-width:100%;max-height:70vh;object-fit:contain;border-radius:.375rem;" />
            </template>
        </div>
    </div>
</div>

</div>
