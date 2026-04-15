<div>
<div class="min-h-screen" style="background:#f0f4fb; font-family:'DM Sans',system-ui,sans-serif;">

@once
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.3/dist/chart.umd.min.js"></script>
@endonce

<style>
    :root {
        --r9: #0a1f5c; --r8: #0f2a7a; --r7: #153591; --r6: #1a3fa8; --r5: #2150c8;
        --g5: #c4952a; --g4: #d4a843;
    }

    /* KPI cards */
    .kpi-card {
        background: #fff; border-radius: 1rem;
        border: 1px solid #e2e8f0; padding: 1rem 1.125rem;
        box-shadow: 0 1px 4px rgba(15,23,42,.04);
        display: flex; align-items: flex-start; justify-content: space-between; gap: .75rem;
    }
    .kpi-icon {
        width: 2.25rem; height: 2.25rem; border-radius: .625rem;
        display: flex; align-items: center; justify-content: center; flex-shrink: 0;
    }
    .kpi-label { font-size: .6rem; font-weight: 700; letter-spacing: .14em; text-transform: uppercase; color: #94a3b8; }
    .kpi-value { font-size: 1.45rem; font-weight: 800; color: #0f172a; line-height: 1.1; margin-top: .2rem; }
    .kpi-sub   { font-size: .68rem; font-weight: 600; margin-top: .3rem; }

    /* Cards */
    .db-card {
        background: #fff; border-radius: 1.25rem;
        border: 1px solid #e2e8f0; overflow: hidden;
        box-shadow: 0 1px 6px rgba(15,23,42,.05);
    }
    .db-card-header {
        display: flex; align-items: center; justify-content: space-between;
        padding: .9rem 1.25rem; border-bottom: 1px solid #f1f5f9;
    }
    .db-card-eyebrow { font-size: .6rem; font-weight: 700; letter-spacing: .16em; text-transform: uppercase; color: var(--g5); }
    .db-card-title   { font-size: .9rem; font-weight: 800; color: #0f172a; margin-top: .1rem; }
    .db-card-link    { font-size: .68rem; font-weight: 700; color: var(--r6); text-decoration: none; letter-spacing: .06em; transition: opacity .15s; }
    .db-card-link:hover { opacity: .7; }

    /* Table */
    .db-table thead th {
        font-size: .6rem; font-weight: 700; letter-spacing: .14em;
        text-transform: uppercase; color: #64748b;
        padding: .65rem 1.1rem; text-align: left; white-space: nowrap;
        background: #f8fafc; border-bottom: 1px solid #e2e8f0;
    }
    .db-table tbody tr { border-bottom: 1px solid #f1f5f9; transition: background .1s; }
    .db-table tbody tr:last-child { border-bottom: none; }
    .db-table tbody tr:hover { background: #f8faff; }
    .db-table td { padding: .8rem 1.1rem; vertical-align: middle; }

    /* Chips */
    .status-chip { display:inline-flex; align-items:center; gap:.3rem; padding:.2rem .6rem; border-radius:999px; font-size:.68rem; font-weight:700; white-space:nowrap; }
    .status-dot  { width:.42rem; height:.42rem; border-radius:50%; flex-shrink:0; }
    .chip-green  { background:#ecfdf5; color:#065f46; border:1px solid #a7f3d0; }
    .chip-slate  { background:#f1f5f9; color:#475569; border:1px solid #e2e8f0; }
    .chip-blue   { background:#eef2ff; color:var(--r6); border:1px solid #c7d2fe; }
    .chip-amber  { background:#fffbeb; color:#92700a; border:1px solid #fde68a; }

    /* Avatar */
    .db-avatar {
        width: 2rem; height: 2rem; border-radius: .5rem;
        display: flex; align-items: center; justify-content: center;
        font-size: .7rem; font-weight: 800; color: #fff; flex-shrink: 0;
        background: linear-gradient(135deg, var(--r6), var(--r8));
        box-shadow: 0 2px 6px rgba(21,53,145,.22);
        letter-spacing: .04em;
    }

    /* Shortcut cards */
    .shortcut-item {
        display: flex; align-items: center; gap: .875rem;
        padding: .875rem 1.25rem;
        transition: background .12s; cursor: pointer; text-decoration: none;
    }
    .shortcut-item:hover { background: #f8faff; }
    .shortcut-icon {
        width: 2.25rem; height: 2.25rem; border-radius: .625rem;
        display: flex; align-items: center; justify-content: center; flex-shrink: 0;
        background: #eef2ff;
    }
    .shortcut-title { font-size: .82rem; font-weight: 700; color: #1e293b; }
    .shortcut-sub   { font-size: .68rem; color: #94a3b8; margin-top: .05rem; }

    /* Sum chip */
    .sum-chip { display:inline-flex; align-items:center; gap:.5rem; padding:.35rem .85rem; border-radius:999px; font-size:.7rem; font-weight:700; white-space:nowrap; }

    /* Calendar block */
    .cal-block {
        width: 2.75rem; flex-shrink: 0; border-radius: .5rem; overflow: hidden;
        border: 1px solid #e2e8f0; text-align: center;
    }
    .cal-month { font-size: .52rem; font-weight: 800; letter-spacing: .15em; text-transform: uppercase; color: #fff; padding: .2rem 0; background: var(--r6); }
    .cal-day   { font-size: 1.1rem; font-weight: 800; color: #1e293b; padding: .2rem 0; background: #f0f4fb; }

    /* Quick action btn */
    .btn-header-action {
        display: inline-flex; align-items: center; gap: .4rem;
        height: 2.125rem; padding: 0 .875rem; border-radius: .65rem;
        background: rgba(255,255,255,.13); border: 1px solid rgba(255,255,255,.2);
        color: #fff; font-size: .75rem; font-weight: 600;
        transition: background .15s; text-decoration: none; white-space: nowrap;
    }
    .btn-header-action:hover { background: rgba(255,255,255,.2); }
    .btn-header-gold {
        background: linear-gradient(135deg, var(--g5), #a37522);
        border-color: transparent;
        box-shadow: 0 3px 10px rgba(196,149,42,.3);
    }
    .btn-header-gold:hover { filter: brightness(1.08); }
</style>

<div class="space-y-5 px-4 py-6 sm:px-6 lg:px-8 mx-auto max-w-screen-2xl">

    {{-- ════════════════════════════════════════════════════════════
         HEADER BANNER
    ════════════════════════════════════════════════════════════ --}}
    <section class="overflow-hidden rounded-2xl"
             style="background:linear-gradient(155deg,var(--r8) 0%,var(--r7) 45%,var(--r6) 100%);
                    box-shadow:0 8px 32px rgba(10,31,92,.28);">
        <div class="pointer-events-none absolute inset-0 overflow-hidden" aria-hidden="true" style="position:relative;">
            <span style="position:absolute;right:2rem;top:50%;transform:translateY(-50%);
                         font-family:Georgia,serif;font-size:7rem;font-weight:900;color:#fff;
                         opacity:.025;letter-spacing:.05em;user-select:none;white-space:nowrap;">
                DASHBOARD
            </span>
        </div>

        <div class="relative px-6 py-6 sm:px-8">
            <div class="flex flex-col gap-5 lg:flex-row lg:items-start lg:justify-between">
                <div>
                    <p class="text-[.65rem] font-bold uppercase tracking-[.22em]" style="color:var(--g4);">
                        HSSTian Alumni Association &middot; Admin Panel
                    </p>
                    <h1 class="mt-2 text-2xl font-bold tracking-tight text-white sm:text-3xl"
                        style="font-family:Georgia,serif;letter-spacing:-.01em;">
                        Admin Dashboard
                    </h1>
                    <p class="mt-1.5 text-sm" style="color:rgba(255,255,255,.55);max-width:50ch;">
                        Manage donations, alumni records, events, and announcements from one central workspace.
                    </p>
                </div>

                <div class="flex flex-wrap items-center gap-2 lg:mt-1 lg:shrink-0">
                    <a href="{{ route('create-event') }}" wire:navigate class="btn-header-action">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                        </svg>
                        Create Event
                    </a>
                    <a href="{{ route('manage-announcement') }}" wire:navigate class="btn-header-action">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10.34 15.84c-.688-.06-1.386-.09-2.09-.09H7.5a4.5 4.5 0 1 1 0-9h.75c.704 0 1.402-.03 2.09-.09m0 9.18c.253.962.584 1.892.985 2.783.247.55.06 1.21-.463 1.511l-.657.38c-.551.318-1.26.117-1.527-.461a20.845 20.845 0 0 1-1.44-4.282m3.102.069a18.03 18.03 0 0 1-.59-4.59c0-1.586.205-3.124.59-4.59m0 9.18a23.848 23.848 0 0 1 8.835 2.535M10.34 6.66a23.847 23.847 0 0 1 8.835-2.535m0 0A23.74 23.74 0 0 1 18.795 3m.38 1.125a23.91 23.91 0 0 1 1.014 5.395m-1.014 8.855c-.118.38-.245.754-.38 1.125m.38-1.125a23.91 23.91 0 0 0 1.014-5.395m-1.394 0A21.967 21.967 0 0 1 21 12c0 1.268-.21 2.487-.597 3.625"/>
                        </svg>
                        Announcement
                    </a>
                    <a href="{{ route('donations') }}" wire:navigate class="btn-header-action btn-header-gold">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75"/>
                        </svg>
                        Verify Donations
                    </a>
                </div>
            </div>

            {{-- Summary strip --}}
            <div class="mt-5 flex flex-wrap items-center gap-2 pt-5" style="border-top:1px solid rgba(255,255,255,.12);">
                <span class="sum-chip" style="background:rgba(255,255,255,.14);color:#fff;border:1px solid rgba(255,255,255,.18);">
                    <svg class="w-3.5 h-3.5 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75"/>
                    </svg>
                    <span style="color:rgba(255,255,255,.55);">Total Donations</span>
                    <strong>₱{{ number_format($allDonationsTotal) }}</strong>
                </span>
                <span class="sum-chip" style="background:rgba(196,149,42,.14);color:var(--g4);border:1px solid rgba(196,149,42,.22);">
                    <span class="status-dot" style="background:var(--g4);"></span>
                    This Month: <strong>₱{{ number_format($donationsThisMonth) }}</strong>
                </span>
                <span class="sum-chip" style="background:rgba(16,185,129,.14);color:#6ee7b7;border:1px solid rgba(16,185,129,.2);">
                    <span class="status-dot" style="background:#6ee7b7;"></span>
                    Alumni: <strong>{{ number_format($totalAlumni) }}</strong>
                </span>
                <span class="sum-chip" style="background:rgba(255,255,255,.08);color:rgba(255,255,255,.45);border:1px solid rgba(255,255,255,.12);font-size:.62rem;" style="margin-left:auto;">
                    {{ now()->format('l, F j, Y') }}
                </span>
            </div>
        </div>
    </section>

    {{-- ════════════════════════════════════════════════════════════
         KPI ROW
    ════════════════════════════════════════════════════════════ --}}
    <div class="grid grid-cols-2 gap-3 sm:grid-cols-3 xl:grid-cols-6">

        <div class="kpi-card" style="border-left:3px solid var(--r6);">
            <div>
                <p class="kpi-label">Total Donations</p>
                <p class="kpi-value">₱{{ number_format($allDonationsTotal) }}</p>
                <p class="kpi-sub" style="color:var(--r6);">All confirmed gifts</p>
            </div>
            <div class="kpi-icon" style="background:#eef2ff;">
                <svg class="w-4 h-4" style="color:var(--r6);" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75"/>
                </svg>
            </div>
        </div>

        <div class="kpi-card" style="border-left:3px solid var(--g5);">
            <div>
                <p class="kpi-label">This Month</p>
                <p class="kpi-value">₱{{ number_format($donationsThisMonth) }}</p>
                <p class="kpi-sub" style="color:var(--g5);">{{ now()->format('F Y') }}</p>
            </div>
            <div class="kpi-icon" style="background:#fef9ee;">
                <svg class="w-4 h-4" style="color:var(--g5);" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18 9 11.25l4.306 4.306a11.95 11.95 0 0 1 5.814-5.518l2.74-1.22m0 0-5.94-2.281m5.94 2.28-2.28 5.941"/>
                </svg>
            </div>
        </div>

        <div class="kpi-card" style="border-left:3px solid #059669;">
            <div>
                <p class="kpi-label">Alumni</p>
                <p class="kpi-value">{{ number_format($totalAlumni) }}</p>
                <p class="kpi-sub" style="color:#059669;">Registered profiles</p>
            </div>
            <div class="kpi-icon" style="background:#ecfdf5;">
                <svg class="w-4 h-4" style="color:#059669;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z"/>
                </svg>
            </div>
        </div>

        <div class="kpi-card" style="border-left:3px solid #7c3aed;">
            <div>
                <p class="kpi-label">Events</p>
                <p class="kpi-value">{{ $upcomingEventsCount }}</p>
                <p class="kpi-sub" style="color:#7c3aed;">Upcoming scheduled</p>
            </div>
            <div class="kpi-icon" style="background:#f5f3ff;">
                <svg class="w-4 h-4" style="color:#7c3aed;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5"/>
                </svg>
            </div>
        </div>

        <div class="kpi-card" style="border-left:3px solid #0ea5e9;">
            <div>
                <p class="kpi-label">Announcements</p>
                <p class="kpi-value">{{ $publishedAnnouncementsCount }}</p>
                <p class="kpi-sub" style="color:#0ea5e9;">Live &amp; visible</p>
            </div>
            <div class="kpi-icon" style="background:#e0f2fe;">
                <svg class="w-4 h-4" style="color:#0ea5e9;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.34 15.84c-.688-.06-1.386-.09-2.09-.09H7.5a4.5 4.5 0 1 1 0-9h.75c.704 0 1.402-.03 2.09-.09m0 9.18c.253.962.584 1.892.985 2.783.247.55.06 1.21-.463 1.511l-.657.38c-.551.318-1.26.117-1.527-.461a20.845 20.845 0 0 1-1.44-4.282m3.102.069a18.03 18.03 0 0 1-.59-4.59c0-1.586.205-3.124.59-4.59m0 9.18a23.848 23.848 0 0 1 8.835 2.535M10.34 6.66a23.847 23.847 0 0 1 8.835-2.535m0 0A23.74 23.74 0 0 1 18.795 3m.38 1.125a23.91 23.91 0 0 1 1.014 5.395m-1.014 8.855c-.118.38-.245.754-.38 1.125m.38-1.125a23.91 23.91 0 0 0 1.014-5.395m-1.394 0A21.967 21.967 0 0 1 21 12c0 1.268-.21 2.487-.597 3.625"/>
                </svg>
            </div>
        </div>

        <div class="kpi-card" style="border-left:3px solid #64748b;">
            <div>
                <p class="kpi-label">Users</p>
                <p class="kpi-value">{{ number_format($totalUsers) }}</p>
                <p class="kpi-sub text-slate-400">System accounts</p>
            </div>
            <div class="kpi-icon bg-slate-100">
                <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z"/>
                </svg>
            </div>
        </div>

    </div>

    {{-- ════════════════════════════════════════════════════════════
         CHARTS ROW
    ════════════════════════════════════════════════════════════ --}}
    @php
        $chartPayments = $latestPayments->sortBy('paid_at')->values();
        $chartLabels   = $chartPayments->map(fn($p) => optional($p->paid_at)->format('M d') ?? 'N/A')->toJson();
        $chartAmounts  = $chartPayments->map(fn($p) => (int)$p->amount)->toJson();

        $overviewTotal = $totalAlumni + $totalUsers + $totalBatches + $upcomingEventsCount + $publishedAnnouncementsCount;
    @endphp

    <div class="grid grid-cols-1 gap-5 lg:grid-cols-[1.6fr_1fr]">

        {{-- Bar chart: Recent confirmed payments --}}
        <div class="db-card"
             x-data="{
                chart: null,
                init() {
                    const ctx = this.$refs.barCanvas.getContext('2d');
                    this.chart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: {{ $chartLabels }},
                            datasets: [{
                                label: 'Amount (₱)',
                                data: {{ $chartAmounts }},
                                backgroundColor: 'rgba(26,63,168,.18)',
                                borderColor: '#1a3fa8',
                                borderWidth: 2,
                                borderRadius: 6,
                                borderSkipped: false,
                                hoverBackgroundColor: 'rgba(26,63,168,.32)',
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: { display: false },
                                tooltip: {
                                    callbacks: {
                                        label: ctx => ' ₱' + Number(ctx.parsed.y).toLocaleString()
                                    }
                                }
                            },
                            scales: {
                                x: {
                                    grid: { display: false },
                                    ticks: { font: { size: 11, family: 'DM Sans, system-ui' }, color: '#94a3b8' }
                                },
                                y: {
                                    grid: { color: '#f1f5f9' },
                                    border: { dash: [4,4] },
                                    ticks: {
                                        font: { size: 11, family: 'DM Sans, system-ui' }, color: '#94a3b8',
                                        callback: v => '₱' + Number(v).toLocaleString()
                                    }
                                }
                            }
                        }
                    });
                },
                destroy() { this.chart?.destroy(); }
             }"
             x-init="init()"
             x-on:livewire:navigating.window="destroy()">

            <div class="db-card-header">
                <div>
                    <p class="db-card-eyebrow">Confirmed Payments</p>
                    <p class="db-card-title">Recent Payment Activity</p>
                </div>
                <a href="{{ route('donations') }}" wire:navigate class="db-card-link">View All →</a>
            </div>

            <div class="p-5" style="height:240px;">
                @if($chartPayments->isEmpty())
                    <div class="flex h-full flex-col items-center justify-center gap-2">
                        <svg class="h-8 w-8" style="color:#e2e8f0;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 0 1 3 19.875v-6.75ZM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V8.625ZM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V4.125Z"/>
                        </svg>
                        <p class="text-xs text-slate-400">No confirmed payments yet</p>
                    </div>
                @else
                    <canvas x-ref="barCanvas"></canvas>
                @endif
            </div>
        </div>

        {{-- Donut chart: Platform overview --}}
        <div class="db-card"
             x-data="{
                chart: null,
                init() {
                    const ctx = this.$refs.donutCanvas.getContext('2d');
                    this.chart = new Chart(ctx, {
                        type: 'doughnut',
                        data: {
                            labels: ['Alumni', 'Users', 'Batches', 'Events', 'Posts'],
                            datasets: [{
                                data: [{{ $totalAlumni }}, {{ $totalUsers }}, {{ $totalBatches }}, {{ $upcomingEventsCount }}, {{ $publishedAnnouncementsCount }}],
                                backgroundColor: ['#1a3fa8','#059669','#7c3aed','#f59e0b','#0ea5e9'],
                                borderColor: ['#fff','#fff','#fff','#fff','#fff'],
                                borderWidth: 3,
                                hoverOffset: 5
                            }]
                        },
                        options: {
                            cutout: '70%',
                            plugins: {
                                legend: { display: false },
                                tooltip: { callbacks: { label: ctx => ' ' + ctx.label + ': ' + Number(ctx.parsed).toLocaleString() } }
                            }
                        }
                    });
                },
                destroy() { this.chart?.destroy(); }
             }"
             x-init="init()"
             x-on:livewire:navigating.window="destroy()">

            <div class="db-card-header">
                <div>
                    <p class="db-card-eyebrow">System Overview</p>
                    <p class="db-card-title">Platform Breakdown</p>
                </div>
            </div>

            <div class="flex items-center gap-5 p-5">
                {{-- Donut --}}
                <div style="position:relative;width:8rem;height:8rem;flex-shrink:0;">
                    <canvas x-ref="donutCanvas" width="128" height="128"></canvas>
                    <div style="position:absolute;inset:0;display:flex;flex-direction:column;
                                align-items:center;justify-content:center;pointer-events:none;">
                        <span style="font-size:1.4rem;font-weight:800;color:#0f172a;line-height:1;">{{ number_format($overviewTotal) }}</span>
                        <span style="font-size:.58rem;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:.08em;">total</span>
                    </div>
                </div>

                {{-- Legend --}}
                <div class="flex-1 space-y-2">
                    @php
                        $overviewItems = [
                            ['Alumni',      $totalAlumni,                   '#1a3fa8'],
                            ['Users',       $totalUsers,                    '#059669'],
                            ['Batches',     $totalBatches,                  '#7c3aed'],
                            ['Events',      $upcomingEventsCount,           '#f59e0b'],
                            ['Posts',       $publishedAnnouncementsCount,   '#0ea5e9'],
                        ];
                    @endphp
                    @foreach($overviewItems as [$label, $count, $color])
                        <div class="flex items-center gap-2">
                            <div style="width:.45rem;height:.45rem;border-radius:50%;background:{{ $color }};flex-shrink:0;"></div>
                            <span class="flex-1 text-xs text-slate-500 truncate">{{ $label }}</span>
                            <span class="text-xs font-bold text-slate-800">{{ number_format($count) }}</span>
                            <div class="w-14 rounded-full overflow-hidden" style="background:#f1f5f9;height:.3rem;">
                                <div style="width:{{ $overviewTotal > 0 ? round($count/$overviewTotal*100) : 0 }}%;height:100%;background:{{ $color }};border-radius:999px;"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

    </div>

    {{-- ════════════════════════════════════════════════════════════
         MAIN CONTENT GRID
    ════════════════════════════════════════════════════════════ --}}
    <div class="grid gap-5 xl:grid-cols-[1.4fr_.6fr]">

        {{-- LEFT --}}
        <div class="space-y-5">

            {{-- Recent Payments --}}
            <div class="db-card">
                <div class="db-card-header">
                    <div>
                        <p class="db-card-eyebrow">Latest Confirmed</p>
                        <p class="db-card-title">Recent Payments</p>
                    </div>
                    <a href="{{ route('donations') }}" wire:navigate class="db-card-link">View All →</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="db-table min-w-full">
                        <thead>
                            <tr>
                                <th>Donor</th>
                                <th style="text-align:right;">Amount</th>
                                <th>Date &amp; Time</th>
                                <th>Reference</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($latestPayments as $payment)
                                <tr>
                                    <td>
                                        <div class="flex items-center gap-2.5">
                                            <div class="db-avatar">
                                                {{ strtoupper(substr($payment->alumni->fname ?? 'U', 0, 1)) }}
                                            </div>
                                            <span class="text-sm font-semibold text-slate-800">
                                                {{ ucwords(strtolower(trim(($payment->alumni->fname ?? '') . ' ' . ($payment->alumni->lname ?? '')))) ?: 'Unknown Donor' }}
                                            </span>
                                        </div>
                                    </td>
                                    <td style="text-align:right;">
                                        <span class="text-sm font-bold" style="color:#059669;">₱{{ number_format($payment->amount) }}</span>
                                    </td>
                                    <td>
                                        <div class="flex flex-col">
                                            <span class="text-xs text-slate-600">{{ optional($payment->paid_at)->format('M d, Y') ?? '—' }}</span>
                                            <span class="text-[.68rem] text-slate-400">{{ optional($payment->paid_at)->format('g:i A') ?? '' }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        @if($payment->paymongo_checkout_session_id)
                                            <span class="font-mono text-[.7rem] text-slate-400">
                                                {{ substr($payment->paymongo_checkout_session_id, 0, 14) }}…
                                            </span>
                                        @else
                                            <span class="text-slate-300 text-xs">—</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-5 py-12 text-center">
                                        <svg class="mx-auto h-7 w-7 mb-2" style="color:#e2e8f0;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75"/>
                                        </svg>
                                        <p class="text-sm text-slate-400">No confirmed payments yet.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Donation Ledger --}}
            <div class="db-card">
                <div class="db-card-header">
                    <div>
                        <p class="db-card-eyebrow">Full Record</p>
                        <p class="db-card-title">Donation Ledger</p>
                    </div>
                    <span class="status-chip chip-blue" style="font-size:.62rem;">Paginated</span>
                </div>
                <div class="overflow-x-auto">
                    <table class="db-table min-w-full">
                        <thead>
                            <tr>
                                <th>Donor</th>
                                <th style="text-align:right;">Amount</th>
                                <th>Remarks</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($donations as $donation)
                                <tr>
                                    <td>
                                        <div class="flex items-center gap-2.5">
                                            <div style="width:1.75rem;height:1.75rem;border-radius:.45rem;
                                                        display:flex;align-items:center;justify-content:center;
                                                        font-size:.65rem;font-weight:800;color:var(--r6);flex-shrink:0;
                                                        background:#eef2ff;border:1px solid #c7d2fe;">
                                                {{ strtoupper(substr($donation->alumni->fname ?? 'U', 0, 1)) }}
                                            </div>
                                            <span class="text-sm font-medium text-slate-800">
                                                {{ ucwords(strtolower(trim(($donation->alumni->fname ?? '') . ' ' . ($donation->alumni->lname ?? '')))) ?: 'Unknown Donor' }}
                                            </span>
                                        </div>
                                    </td>
                                    <td style="text-align:right;">
                                        <span class="text-sm font-bold text-slate-800">₱{{ number_format($donation->amount) }}</span>
                                    </td>
                                    <td>
                                        <span class="text-xs text-slate-500 truncate block max-w-[160px]">{{ $donation->remarks ?: '—' }}</span>
                                    </td>
                                    <td>
                                        <span class="text-xs text-slate-400">{{ optional($donation->paid_at)->format('M d, Y') ?? '—' }}</span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-5 py-12 text-center">
                                        <p class="text-sm text-slate-400">No donation records found.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="px-5 py-3.5" style="border-top:1px solid #f1f5f9;">
                    {{ $donations->links() }}
                </div>
            </div>

            {{-- Recent Announcements --}}
            <div class="db-card">
                <div class="db-card-header">
                    <div>
                        <p class="db-card-eyebrow">Content</p>
                        <p class="db-card-title">Recent Announcements</p>
                    </div>
                    <a href="{{ route('manage-announcement') }}" wire:navigate class="db-card-link">Manage →</a>
                </div>
                <div>
                    @forelse($recentAnnouncements as $announcement)
                        <div class="flex items-start gap-3.5 px-5 py-4 transition hover:bg-slate-50/60"
                             style="border-bottom:1px solid #f1f5f9;">
                            <div style="width:.45rem;height:.45rem;border-radius:50%;margin-top:.4rem;flex-shrink:0;
                                        background:{{ $announcement->is_published ? '#059669' : '#94a3b8' }};"></div>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-start justify-between gap-3">
                                    <p class="text-sm font-semibold text-slate-800 leading-snug">{{ $announcement->title }}</p>
                                    <div class="flex gap-1.5 shrink-0">
                                        @if($announcement->pinned)
                                            <span class="status-chip chip-blue" style="font-size:.62rem;">Pinned</span>
                                        @endif
                                        @if($announcement->is_published)
                                            <span class="status-chip chip-green" style="font-size:.62rem;">Live</span>
                                        @else
                                            <span class="status-chip chip-slate" style="font-size:.62rem;">Draft</span>
                                        @endif
                                    </div>
                                </div>
                                <p class="mt-0.5 text-[.7rem] text-slate-400">
                                    {{ $announcement->published_at?->format('M d, Y · g:i A') ?? $announcement->created_at?->format('M d, Y · g:i A') }}
                                </p>
                            </div>
                        </div>
                    @empty
                        <div class="flex flex-col items-center gap-2 px-5 py-12">
                            <svg class="h-7 w-7" style="color:#e2e8f0;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M10.34 15.84c-.688-.06-1.386-.09-2.09-.09H7.5a4.5 4.5 0 1 1 0-9h.75c.704 0 1.402-.03 2.09-.09m0 9.18c.253.962.584 1.892.985 2.783.247.55.06 1.21-.463 1.511l-.657.38c-.551.318-1.26.117-1.527-.461a20.845 20.845 0 0 1-1.44-4.282m3.102.069a18.03 18.03 0 0 1-.59-4.59c0-1.586.205-3.124.59-4.59m0 9.18a23.848 23.848 0 0 1 8.835 2.535M10.34 6.66a23.847 23.847 0 0 1 8.835-2.535"/>
                            </svg>
                            <p class="text-sm text-slate-400">No announcements yet.</p>
                        </div>
                    @endforelse
                </div>
            </div>

        </div>

        {{-- RIGHT SIDEBAR --}}
        <aside class="space-y-5">

            {{-- Upcoming Events --}}
            <div class="db-card">
                <div class="db-card-header">
                    <div>
                        <p class="db-card-eyebrow">Scheduled</p>
                        <p class="db-card-title">Upcoming Events</p>
                    </div>
                    <a href="{{ route('event-view') }}" wire:navigate class="db-card-link">All →</a>
                </div>

                <div>
                    @forelse($upcomingEvents as $event)
                        <div class="px-4 py-4 transition hover:bg-slate-50/60"
                             style="border-bottom:1px solid #f1f5f9;">
                            <div class="flex items-start gap-3">
                                <div class="cal-block">
                                    <div class="cal-month">{{ optional($event->event_date)->format('M') }}</div>
                                    <div class="cal-day">{{ optional($event->event_date)->format('d') }}</div>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-semibold text-slate-800 leading-snug">{{ $event->title }}</p>
                                    <p class="mt-0.5 text-[.7rem] text-slate-400 flex items-center gap-1 truncate">
                                        <svg class="w-2.5 h-2.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z"/>
                                        </svg>
                                        {{ $event->venue ?: 'Venue TBA' }}
                                    </p>
                                </div>
                            </div>
                            <div class="mt-2.5 grid grid-cols-2 gap-2">
                                <div class="rounded-lg px-2.5 py-1.5" style="background:#f8fafc;border:1px solid #f1f5f9;">
                                    <p class="text-[.58rem] font-700 uppercase tracking-[.1em] text-slate-400">Dress Code</p>
                                    <p class="mt-0.5 text-xs font-semibold text-slate-700 truncate">{{ $event->dress_code ?: '—' }}</p>
                                </div>
                                <div class="rounded-lg px-2.5 py-1.5" style="background:#f8fafc;border:1px solid #f1f5f9;">
                                    <p class="text-[.58rem] font-700 uppercase tracking-[.1em] text-slate-400">Reg. Fee</p>
                                    <p class="mt-0.5 text-xs font-semibold" style="color:var(--r6);">
                                        ₱{{ number_format(($event->registration_fee ?? 0) / 100, 2) }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="flex flex-col items-center gap-2 px-5 py-12">
                            <svg class="h-7 w-7" style="color:#e2e8f0;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5"/>
                            </svg>
                            <p class="text-sm text-slate-400">No upcoming events.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- Record Summary --}}
            <div class="db-card">
                <div class="db-card-header">
                    <div>
                        <p class="db-card-eyebrow">System Overview</p>
                        <p class="db-card-title">Record Summary</p>
                    </div>
                </div>
                <div class="p-4 space-y-2">
                    @foreach([
                        ['System Users',       $totalUsers,                    '#64748b', 'bg-slate-100'],
                        ['Alumni Batches',      $totalBatches,                  '#7c3aed', '#f5f3ff'],
                        ['Alumni Profiles',     $totalAlumni,                   '#059669', '#ecfdf5'],
                        ['Upcoming Events',     $upcomingEventsCount,           '#f59e0b', '#fffbeb'],
                        ['Published Posts',     $publishedAnnouncementsCount,   '#0ea5e9', '#e0f2fe'],
                    ] as [$label, $val, $color, $bg])
                        <div class="flex items-center justify-between rounded-xl px-3.5 py-2.5"
                             style="background:{{ $bg }};border:1px solid {{ $bg }};">
                            <span class="text-xs font-medium text-slate-600">{{ $label }}</span>
                            <span class="text-sm font-bold" style="color:{{ $color }};">{{ number_format($val) }}</span>
                        </div>
                    @endforeach
                </div>
            </div>

        </aside>
    </div>

    {{-- ════════════════════════════════════════════════════════════
         QUICK NAVIGATION
    ════════════════════════════════════════════════════════════ --}}
    <div class="db-card">
        <div class="db-card-header" style="background:linear-gradient(155deg,var(--r8),var(--r6));border-bottom:none;">
            <div>
                <p style="font-size:.6rem;font-weight:700;letter-spacing:.16em;text-transform:uppercase;color:rgba(255,255,255,.45);">Quick Navigation</p>
                <p style="font-size:.9rem;font-weight:800;color:#fff;margin-top:.1rem;">Management Shortcuts</p>
            </div>
        </div>
        <div class="grid grid-cols-2 sm:grid-cols-4 divide-y sm:divide-y-0 sm:divide-x" style="divide-color:#f1f5f9;">
            <a href="{{ route('view-batch') }}" wire:navigate class="shortcut-item">
                <div class="shortcut-icon"><svg class="w-4 h-4" style="color:var(--r6);" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z"/></svg></div>
                <div><p class="shortcut-title">Alumni</p><p class="shortcut-sub">Manage profiles</p></div>
            </a>
            <a href="{{ route('manage-users') }}" wire:navigate class="shortcut-item">
                <div class="shortcut-icon"><svg class="w-4 h-4" style="color:var(--r6);" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z"/></svg></div>
                <div><p class="shortcut-title">Users</p><p class="shortcut-sub">Accounts &amp; roles</p></div>
            </a>
            <a href="{{ route('reports.attendance') }}" wire:navigate class="shortcut-item">
                <div class="shortcut-icon"><svg class="w-4 h-4" style="color:var(--r6);" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 0 1 3 19.875v-6.75ZM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V8.625ZM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V4.125Z"/></svg></div>
                <div><p class="shortcut-title">Reports</p><p class="shortcut-sub">Attendance &amp; data</p></div>
            </a>
            <a href="{{ route('donations') }}" wire:navigate class="shortcut-item">
                <div class="shortcut-icon"><svg class="w-4 h-4" style="color:var(--r6);" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75"/></svg></div>
                <div><p class="shortcut-title">Donations</p><p class="shortcut-sub">Verify &amp; manage</p></div>
            </a>
        </div>
    </div>

</div>
</div>
</div>
