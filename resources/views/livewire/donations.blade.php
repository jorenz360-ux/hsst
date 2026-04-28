<div class="min-h-screen" style="background:#f0f4fb;font-family:'DM Sans',system-ui,sans-serif;">
<style>
    :root {
        --r9:#0a1f5c; --r8:#0f2a7a; --r7:#153591;
        --r6:#1a3fa8; --r5:#2150c8;
        --g5:#c4952a; --g4:#d4a843;
    }

    /* KPI cards */
    .kpi-card {
        background:#fff;border-radius:1.1rem;border:1px solid #e8edf5;
        padding:1.1rem 1.25rem;box-shadow:0 1px 6px rgba(15,23,42,.05);
    }
    .kpi-icon {
        width:2.1rem;height:2.1rem;border-radius:.55rem;flex-shrink:0;
        display:flex;align-items:center;justify-content:center;margin-bottom:.7rem;
    }
    .kpi-label { font-size:.62rem;font-weight:700;letter-spacing:.09em;text-transform:uppercase;color:#64748b;margin-bottom:.2rem; }
    .kpi-value { font-size:1.75rem;font-weight:800;letter-spacing:-.03em;line-height:1.1;color:#0f172a; }
    .kpi-sub   { font-size:.7rem;color:#94a3b8;margin-top:.35rem;line-height:1.4; }

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

    /* ── Donations Table ──────────────────────────────────── */
    .dn-table { width:100%; border-collapse:collapse; }
    .dn-table thead tr { background:var(--r9); }
    .dn-table thead th {
        font-size:.565rem; font-weight:700; letter-spacing:.14em;
        text-transform:uppercase; color:rgba(255,255,255,.5);
        padding:.6rem .9rem; text-align:left; white-space:nowrap; border:none;
    }
    .dn-table thead th.r { text-align:right; }
    .dn-table tbody tr {
        border-bottom:1px solid #f1f5f9;
        border-left:2.5px solid transparent;
        transition:background .1s,border-left-color .1s;
    }
    .dn-table tbody tr:last-child { border-bottom:none; }
    .dn-table tbody tr:hover { background:rgba(26,63,168,.028); border-left-color:var(--r5); }
    .dn-table td { padding:.52rem .9rem; vertical-align:middle; }
    .dn-table td.r { text-align:right; }
    .dn-av {
        width:1.7rem; height:1.7rem; border-radius:.4rem; flex-shrink:0;
        display:flex; align-items:center; justify-content:center;
        font-size:.58rem; font-weight:800; color:#fff;
        background:linear-gradient(135deg,var(--r5) 0%,var(--r8) 100%);
    }
    .dn-ref {
        font-family:ui-monospace,SFMono-Regular,monospace; font-size:.67rem;
        letter-spacing:.02em; background:#f8fafc; border:1px solid #e2e8f0;
        border-radius:.3rem; padding:.12rem .45rem; color:#334155;
    }
    .dn-btn {
        display:inline-flex; align-items:center; gap:.22rem;
        padding:.2rem .5rem; border-radius:.375rem; cursor:pointer;
        font-size:.63rem; font-weight:700; border:1px solid; white-space:nowrap;
        transition:filter .1s,transform .08s;
    }
    .dn-btn:hover { filter:brightness(.93); transform:translateY(-1px); }
    .dn-btn-ok { background:#f0fdf4; border-color:#86efac; color:#15803d; }
    .dn-btn-no { background:#fff5f5; border-color:#fca5a5; color:#dc2626; }
    .dn-btn-or { background:#fffbeb; border-color:#fde68a; color:#92700a; }

    @keyframes dmModalIn {
        from { opacity:0; transform:scale(.96) translateY(10px); }
        to   { opacity:1; transform:scale(1)   translateY(0); }
    }
    .dm-modal {
        background:#fff; border-radius:1.1rem; width:95vw; max-width:27rem;
        box-shadow:0 24px 64px rgba(10,31,92,.22),0 4px 16px rgba(0,0,0,.06);
        animation:dmModalIn .22s cubic-bezier(.34,1.1,.64,1) both;
        overflow:hidden; position:relative;
    }
    .dm-modal-body   { padding:1.5rem 1.5rem 1.25rem; }
    .dm-modal-footer {
        display:flex; gap:.5rem; justify-content:flex-end;
        padding:1rem 1.5rem; background:#f8fafc; border-top:1px solid #f1f5f9;
    }
    .dm-modal-icon {
        width:2.5rem; height:2.5rem; border-radius:.65rem; flex-shrink:0;
        display:flex; align-items:center; justify-content:center;
    }
    .dm-close-btn {
        width:1.75rem; height:1.75rem; border-radius:.4rem; border:none;
        background:#f1f5f9; cursor:pointer; color:#94a3b8; flex-shrink:0;
        display:flex; align-items:center; justify-content:center;
        transition:background .12s,color .12s;
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
    .btn-ghost-dm {
        display:inline-flex; align-items:center; gap:.4rem;
        height:2.375rem; padding:0 .875rem; border-radius:.75rem;
        background:#fff; border:1px solid #e2e8f0;
        color:#475569; font-size:.8rem; font-weight:600;
        transition:background .12s,border-color .12s; cursor:pointer;
    }
    .btn-ghost-dm:hover { background:#f8fafc; border-color:#cbd5e1; color:#1e293b; }
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

        <div class="kpi-card">
            <div class="kpi-icon" style="background:#eef2ff;">
                <svg class="w-4 h-4" style="color:var(--r6);" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm3 0h.008v.008H18V10.5Zm-12 0h.008v.008H6V10.5Z"/>
                </svg>
            </div>
            <p class="kpi-label">Filtered Total</p>
            <p class="kpi-value" style="color:var(--r6);">₱{{ number_format($totalAmount) }}</p>
            <p class="kpi-sub">Across current filter</p>
        </div>

        <div class="kpi-card">
            <div class="kpi-icon" style="background:#fffbeb;">
                <svg class="w-4 h-4" style="color:#d97706;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                </svg>
            </div>
            <p class="kpi-label">Pending Review</p>
            <p class="kpi-value" style="color:#d97706;">{{ $pendingCount }}</p>
            <p class="kpi-sub">Awaiting admin action</p>
        </div>

        <div class="kpi-card">
            <div class="kpi-icon" style="background:#ecfdf5;">
                <svg class="w-4 h-4" style="color:#16a34a;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25Z"/>
                </svg>
            </div>
            <p class="kpi-label">Records Shown</p>
            <p class="kpi-value" style="color:#16a34a;">{{ $donations->total() }}</p>
            <p class="kpi-sub">Matching filter</p>
        </div>

        <div class="kpi-card">
            <div class="kpi-icon" style="background:#fffbeb;">
                <svg class="w-4 h-4" style="color:var(--g5);" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 3c2.755 0 5.455.232 8.083.678.533.09.917.556.917 1.096v1.044a2.25 2.25 0 0 1-.659 1.591l-5.432 5.432a2.25 2.25 0 0 0-.659 1.591v2.927a2.25 2.25 0 0 1-1.244 2.013L9.75 21v-6.568a2.25 2.25 0 0 0-.659-1.591L3.659 7.409A2.25 2.25 0 0 1 3 5.818V4.774c0-.54.384-1.006.917-1.096A48.32 48.32 0 0 1 12 3Z"/>
                </svg>
            </div>
            <p class="kpi-label">Active Filter</p>
            <p class="kpi-value" style="font-size:1.1rem;color:var(--g5);">
                {{ ucfirst($statusFilter === 'all' ? 'All' : $statusFilter) }}
            </p>
            <p class="kpi-sub">{{ $paymentFilter === 'all' ? 'Any payment type' : ucfirst($paymentFilter) }}</p>
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
                <p style="font-size:.68rem;color:#94a3b8;margin:0;">Review submissions, proof and payment state.</p>
            </div>
            <div style="display:flex;align-items:center;gap:.5rem;">
                <span wire:loading style="font-size:.68rem;color:#94a3b8;font-style:italic;">Updating…</span>
                <span style="font-size:.6rem;font-weight:700;background:#eef2ff;color:var(--r6);
                             border:1px solid #c7d2fe;border-radius:999px;padding:.2rem .65rem;">
                    {{ $donations->firstItem() ?? 0 }}–{{ $donations->lastItem() ?? 0 }}
                    <span style="opacity:.6;">of</span> {{ number_format($donations->total()) }}
                </span>
            </div>
        </div>

        <div style="overflow-x:auto;">
            <table class="dn-table">
                <thead>
                    <tr>
                        <th>Donor</th>
                        <th class="r">Amount</th>
                        <th>Reference</th>
                        <th>Submitted</th>
                        <th>Status</th>
                        <th>Payment</th>
                        <th>Receipt</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($donations as $donation)
                        @php
                            $donorEducations = $donation->alumni?->educations ?? collect();
                            $initials = strtoupper(
                                substr($donation->alumni?->fname ?? 'U', 0, 1) .
                                substr($donation->alumni?->lname ?? '', 0, 1)
                            );
                        @endphp
                        <tr>
                            {{-- Donor --}}
                            <td style="min-width:200px;">
                                <div style="display:flex;align-items:center;gap:.5rem;">
                                    <div class="dn-av">{{ $initials }}</div>
                                    <div>
                                        <p style="font-size:.775rem;font-weight:700;color:#1e293b;
                                                   line-height:1.25;white-space:nowrap;">
                                            {{ $donation->alumni?->lname }}, {{ $donation->alumni?->fname }}
                                        </p>
                                        @if ($donorEducations->isNotEmpty())
                                            <div style="display:flex;flex-wrap:wrap;gap:.2rem;margin-top:.2rem;">
                                                @foreach ($donorEducations as $donorEdu)
                                                    @php
                                                        $lvlAbbr = match($donorEdu->batch?->level) {
                                                            'elementary' => 'Elem',
                                                            'highschool' => 'HS',
                                                            'college'    => 'Col',
                                                            default      => null,
                                                        };
                                                    @endphp
                                                    <span class="status-chip chip-blue" style="font-size:.58rem;padding:.08rem .4rem;">
                                                        {{ $lvlAbbr ? $lvlAbbr . ' ' : '' }}{{ $donorEdu->batch?->yeargrad ?? '—' }}
                                                    </span>
                                                @endforeach
                                            </div>
                                        @else
                                            <span style="font-size:.62rem;color:#cbd5e1;">No batch</span>
                                        @endif
                                    </div>
                                </div>
                            </td>

                            {{-- Amount --}}
                            <td class="r" style="min-width:100px;">
                                <span style="font-size:.82rem;font-weight:800;color:#1e293b;
                                             font-variant-numeric:tabular-nums;letter-spacing:-.015em;">
                                    ₱{{ number_format($donation->amount ?? 0, 2) }}
                                </span>
                            </td>

                            {{-- Reference --}}
                            <td style="min-width:130px;">
                                @if ($donation->reference_number)
                                    <span class="dn-ref">{{ $donation->reference_number }}</span>
                                @else
                                    <span style="color:#cbd5e1;font-size:.7rem;">—</span>
                                @endif
                            </td>

                            {{-- Submitted --}}
                            <td style="min-width:105px;">
                                <p style="font-size:.75rem;font-weight:600;color:#334155;margin:0;white-space:nowrap;">
                                    {{ $donation->created_at?->format('M d, Y') ?? '—' }}
                                </p>
                                <p style="font-size:.62rem;color:#94a3b8;margin:.1rem 0 0;">
                                    {{ $donation->created_at?->format('h:i A') ?? '' }}
                                </p>
                            </td>

                            {{-- Review Status --}}
                            <td style="min-width:120px;">
                                @if ($donation->status === 'verified')
                                    <span class="status-chip chip-green">
                                        <span class="status-dot" style="background:#10b981;"></span>Verified
                                    </span>
                                    @if ($donation->reviewed_at)
                                        <p style="font-size:.6rem;color:#94a3b8;margin:.2rem 0 0;">
                                            {{ $donation->reviewed_at->format('M d, Y') }}
                                        </p>
                                    @endif
                                @elseif ($donation->status === 'rejected')
                                    <span class="status-chip chip-red">
                                        <span class="status-dot" style="background:#ef4444;"></span>Rejected
                                    </span>
                                    @if ($donation->rejection_reason)
                                        <p style="font-size:.62rem;color:#dc2626;margin:.2rem 0 0;
                                                   max-width:140px;line-height:1.35;overflow:hidden;
                                                   text-overflow:ellipsis;white-space:nowrap;">
                                            {{ Str::limit($donation->rejection_reason, 42) }}
                                        </p>
                                    @endif
                                @else
                                    <span class="status-chip chip-amber">
                                        <span class="status-dot" style="background:#d97706;"></span>Pending
                                    </span>
                                @endif
                            </td>

                            {{-- Payment --}}
                            <td style="min-width:85px;">
                                @if ($donation->is_paid)
                                    <span class="status-chip chip-blue">
                                        <span class="status-dot" style="background:var(--r6);"></span>Paid
                                    </span>
                                @else
                                    <span class="status-chip chip-slate">Unpaid</span>
                                @endif
                            </td>

                            {{-- Receipt --}}
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
                                            class="dn-btn dn-btn-or">
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
                            <td style="white-space:nowrap;">
                                <div style="display:flex;gap:.28rem;align-items:center;">
                                    @if ($donation->status === 'pending')
                                        <button type="button"
                                                @click="$dispatch('open-verify-modal',{id:{{ $donation->id }}})"
                                                class="dn-btn dn-btn-ok">
                                            <svg style="width:.6rem;height:.6rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/>
                                            </svg>
                                            Verify
                                        </button>
                                        <button wire:click="openRejectModal({{ $donation->id }})"
                                                class="dn-btn dn-btn-no">
                                            <svg style="width:.6rem;height:.6rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                                            </svg>
                                            Reject
                                        </button>
                                    @else
                                        <span style="font-size:.65rem;color:#94a3b8;font-style:italic;">
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
                                <div style="max-width:18rem;margin:0 auto;">
                                    <div style="width:2.75rem;height:2.75rem;border-radius:.75rem;
                                                background:#f0f4fb;border:1px solid #e2e8f0;
                                                display:flex;align-items:center;justify-content:center;
                                                margin:0 auto .75rem;">
                                        <svg style="width:1.2rem;height:1.2rem;color:#94a3b8;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25Z"/>
                                        </svg>
                                    </div>
                                    <p style="font-size:.8125rem;font-weight:600;color:#1e293b;margin:0;">No donations found</p>
                                    <p style="font-size:.72rem;color:#64748b;margin-top:.3rem;">Try adjusting your filters.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div style="padding:.8rem 1.25rem;border-top:1px solid #f1f5f9;background:#fafbff;
                    display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:.75rem;">
            <p style="font-size:.7rem;color:#94a3b8;">
                Showing {{ $donations->firstItem() ?? 0 }}–{{ $donations->lastItem() ?? 0 }}
                of {{ number_format($donations->total()) }} records
            </p>
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
                        <button type="button" @click="$dispatch('open-verify-modal',{id:{{ $donation->id }}})" class="btn-verify">
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
    <div style="position:fixed;inset:0;z-index:9999;background:rgba(10,31,92,.45);"
         x-data @keydown.escape.window="$wire.closeRejectModal()">
        <div style="display:flex;align-items:center;justify-content:center;
                    min-height:100vh;padding:1rem;">
            <div class="dm-modal">
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
                        <button wire:click="closeRejectModal" class="dm-close-btn">
                            <svg style="width:.8rem;height:.8rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>

                    <div style="background:#fef2f2;border:1px solid #fecaca;border-radius:.75rem;
                                padding:.75rem 1rem;display:flex;align-items:flex-start;gap:.6rem;margin-bottom:1rem;">
                        <svg style="width:.9rem;height:.9rem;color:#dc2626;flex-shrink:0;margin-top:.1rem;"
                             fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z"/>
                        </svg>
                        <p style="font-size:.78rem;color:#991b1b;margin:0;line-height:1.6;">
                            The alumni will be notified that their donation was <strong>rejected</strong>. This action can be undone by re-verifying later.
                        </p>
                    </div>

                    <div>
                        <label style="display:block;font-size:.6rem;font-weight:700;letter-spacing:.1em;
                                       text-transform:uppercase;color:#94a3b8;margin-bottom:.35rem;">
                            Reason for rejection <span style="color:#dc2626;">*</span>
                        </label>
                        <textarea wire:model="rejectionReason" rows="3"
                                  placeholder="Explain why this donation is being rejected…"
                                  style="width:100%;border-radius:.75rem;border:1px solid #e2e8f0;
                                         background:#fff;padding:.6rem .875rem;font-size:.8125rem;
                                         color:#0f172a;outline:none;resize:vertical;box-sizing:border-box;
                                         transition:border-color .15s,box-shadow .15s;"
                                  onfocus="this.style.borderColor='#dc2626';this.style.boxShadow='0 0 0 3px rgba(220,38,38,.1)'"
                                  onblur="this.style.borderColor='#e2e8f0';this.style.boxShadow='none'"></textarea>
                        @error('rejectionReason')
                            <p style="font-size:.72rem;color:#dc2626;margin:.3rem 0 0;">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="dm-modal-footer">
                    <button wire:click="closeRejectModal" class="btn-ghost-dm">Cancel</button>
                    <button wire:click="rejectDonation"
                            wire:loading.attr="disabled"
                            wire:target="rejectDonation"
                            class="dm-action-btn"
                            style="background:linear-gradient(135deg,#dc2626,#b91c1c);
                                   box-shadow:0 2px 8px rgba(220,38,38,.22);">
                        <span wire:loading.remove wire:target="rejectDonation"
                              style="display:inline-flex;align-items:center;gap:.35rem;">
                            <svg style="width:.75rem;height:.75rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                            Confirm Reject
                        </span>
                        <span wire:loading wire:target="rejectDonation">Rejecting…</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
@endif

{{-- ════════ VERIFY MODAL ════════ --}}
<div x-data="{ open: false, id: null }"
     @open-verify-modal.window="open = true; id = $event.detail.id"
     x-show="open"
     x-cloak
     x-transition:enter="transition ease-out duration-200"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition ease-in duration-150"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     style="position:fixed;inset:0;z-index:9999;background:rgba(10,31,92,.45);"
     @keydown.escape.window="open = false">

    <div style="display:flex;align-items:center;justify-content:center;
                min-height:100vh;padding:1rem;"
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
                                       color:#0f172a;margin:0;line-height:1.25;">Verify Donation</p>
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
                <button @click="open = false" class="btn-ghost-dm">Cancel</button>
                <button @click="$wire.verifyDonation(id); open = false"
                        class="dm-action-btn"
                        style="background:linear-gradient(135deg,#16a34a,#059669);
                               box-shadow:0 2px 8px rgba(22,163,74,.28);">
                    <svg style="width:.75rem;height:.75rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/>
                    </svg>
                    Verify
                </button>
            </div>
        </div>
    </div>
</div>

{{-- ════════ PROOF MODAL ════════ --}}
<div x-data="{ open:false, url:'', ext:'' }"
     @open-proof-modal.window="open=true; url=$event.detail.url; ext=$event.detail.ext"
     x-show="open" x-cloak
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
     @click.self="open=false" @keydown.escape.window="open=false">

    <div style="display:flex;align-items:center;justify-content:space-between;
                padding:.85rem 1.25rem;flex-shrink:0;">
        <div style="display:flex;align-items:center;gap:.75rem;">
            <div style="width:2.2rem;height:2.2rem;border-radius:.55rem;flex-shrink:0;
                        display:flex;align-items:center;justify-content:center;
                        background:rgba(196,149,42,.22);border:1px solid rgba(196,149,42,.35);
                        backdrop-filter:blur(8px);">
                <svg style="width:.9rem;height:.9rem;color:#fbbf24;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z"/>
                </svg>
            </div>
            <div>
                <p style="font-family:Georgia,serif;font-size:.9rem;font-weight:700;
                           color:#fff;margin:0;line-height:1.2;">Official Receipt</p>
                <template x-if="ext === 'pdf'">
                    <p style="font-size:.65rem;color:rgba(255,255,255,.5);margin:.1rem 0 0;letter-spacing:.04em;text-transform:uppercase;font-weight:600;">PDF Document</p>
                </template>
                <template x-if="ext !== 'pdf'">
                    <p style="font-size:.65rem;color:rgba(255,255,255,.5);margin:.1rem 0 0;letter-spacing:.04em;text-transform:uppercase;font-weight:600;">Image File &middot; click to open full size</p>
                </template>
            </div>
        </div>
        <div style="display:flex;align-items:center;gap:.5rem;">
            <a :href="url" target="_blank"
               style="display:inline-flex;align-items:center;gap:.38rem;
                      padding:.38rem .85rem;border-radius:.55rem;font-size:.75rem;font-weight:700;
                      color:#fff;text-decoration:none;cursor:pointer;
                      background:rgba(255,255,255,.12);border:1px solid rgba(255,255,255,.2);
                      backdrop-filter:blur(8px);transition:background .15s,border-color .15s;"
               onmouseover="this.style.background='rgba(255,255,255,.2)';this.style.borderColor='rgba(255,255,255,.35)'"
               onmouseout="this.style.background='rgba(255,255,255,.12)';this.style.borderColor='rgba(255,255,255,.2)'">
                <svg style="width:.7rem;height:.7rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 0 0 3 8.25v10.5A2.25 2.25 0 0 0 5.25 21h10.5A2.25 2.25 0 0 0 18 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25"/>
                </svg>
                Open in new tab
            </a>
            <button @click="open=false"
                    style="width:2rem;height:2rem;border-radius:.5rem;border:1px solid rgba(255,255,255,.2);
                           background:rgba(255,255,255,.1);backdrop-filter:blur(8px);cursor:pointer;
                           color:rgba(255,255,255,.7);display:flex;align-items:center;justify-content:center;
                           transition:background .15s,color .15s;"
                    onmouseover="this.style.background='rgba(255,255,255,.22)';this.style.color='#fff'"
                    onmouseout="this.style.background='rgba(255,255,255,.1)';this.style.color='rgba(255,255,255,.7)'">
                <svg style="width:.8rem;height:.8rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
    </div>

    <div style="flex:1;overflow:auto;display:flex;align-items:center;justify-content:center;
                padding:.5rem 3rem 1rem;">
        <template x-if="ext === 'pdf'">
            <iframe :src="url"
                    style="width:100%;height:100%;min-height:500px;border:none;
                           border-radius:.75rem;box-shadow:0 8px 48px rgba(0,0,0,.6);"></iframe>
        </template>
        <template x-if="ext !== 'pdf'">
            <img :src="url"
                 style="max-width:100%;max-height:calc(100vh - 120px);object-fit:contain;
                        border-radius:.75rem;box-shadow:0 8px 48px rgba(0,0,0,.65);cursor:zoom-in;"
                 @click="window.open(url,'_blank')" />
        </template>
    </div>

    <p style="text-align:center;font-size:.65rem;color:rgba(255,255,255,.3);
              padding-bottom:.75rem;flex-shrink:0;letter-spacing:.06em;">
        Press <kbd style="font-family:ui-monospace,monospace;background:rgba(255,255,255,.1);
                           border:1px solid rgba(255,255,255,.18);border-radius:.25rem;
                           padding:.05rem .35rem;font-size:.62rem;">ESC</kbd> or click outside to close
    </p>
</div>

</div>
