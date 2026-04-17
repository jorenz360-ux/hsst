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
    .kpi-icon { width:2.25rem;height:2.25rem;border-radius:.625rem;display:flex;align-items:center;justify-content:center;flex-shrink:0; }
    .kpi-label { font-size:.6rem;font-weight:700;letter-spacing:.14em;text-transform:uppercase;color:#94a3b8; }
    .kpi-value { font-size:1.45rem;font-weight:800;color:#0f172a;line-height:1.1;margin-top:.2rem; }
    .kpi-sub   { font-size:.68rem;font-weight:600;margin-top:.3rem; }

    /* Section cards */
    .db-card { background:#fff;border-radius:1.25rem;border:1px solid #e2e8f0;overflow:hidden;box-shadow:0 1px 6px rgba(15,23,42,.05); }
    .db-card-header { display:flex;align-items:center;justify-content:space-between;padding:.9rem 1.25rem;border-bottom:1px solid #f1f5f9; }
    .db-card-eyebrow { font-size:.6rem;font-weight:700;letter-spacing:.16em;text-transform:uppercase;color:var(--g5); }
    .db-card-title   { font-size:.9rem;font-weight:800;color:#0f172a;margin-top:.1rem; }

    /* Table */
    .db-table { width:100%;border-collapse:collapse; }
    .db-table thead th {
        font-size:.6rem;font-weight:700;letter-spacing:.14em;text-transform:uppercase;color:#64748b;
        padding:.65rem 1.1rem;text-align:left;white-space:nowrap;
        background:#f8fafc;border-bottom:1px solid #e2e8f0;
    }
    .db-table tbody tr { border-bottom:1px solid #f1f5f9;transition:background .1s; }
    .db-table tbody tr:last-child { border-bottom:none; }
    .db-table tbody tr:hover { background:#f8faff; }
    .db-table td { padding:.75rem 1.1rem;vertical-align:middle; }

    /* Chips */
    .sc { display:inline-flex;align-items:center;gap:.3rem;padding:.18rem .6rem;border-radius:999px;font-size:.67rem;font-weight:700;white-space:nowrap; }
    .sd { width:.42rem;height:.42rem;border-radius:50%;flex-shrink:0; }
    .sc-green  { background:#ecfdf5;color:#065f46;border:1px solid #a7f3d0; }
    .sc-amber  { background:#fffbeb;color:#92700a;border:1px solid #fde68a; }
    .sc-red    { background:#fff5f5;color:#dc2626;border:1px solid #fca5a5; }
    .sc-slate  { background:#f1f5f9;color:#475569;border:1px solid #e2e8f0; }
    .sc-blue   { background:#eef2ff;color:var(--r6);border:1px solid #c7d2fe; }
    .sc-purple { background:#f5f3ff;color:#5b21b6;border:1px solid #ddd6fe; }
    .sc-sky    { background:#f0f9ff;color:#0369a1;border:1px solid #bae6fd; }
    .sc-elem   { background:#f0fdf4;color:#065f46;border:1px solid #bbf7d0; }
    .sc-hs     { background:#fffbeb;color:#92700a;border:1px solid #fde68a; }
    .sc-col    { background:#f5f3ff;color:#5b21b6;border:1px solid #ddd6fe; }

    /* Avatar */
    .db-avatar {
        width:2rem;height:2rem;border-radius:.5rem;
        display:flex;align-items:center;justify-content:center;
        font-size:.7rem;font-weight:800;color:#fff;flex-shrink:0;
        background:linear-gradient(135deg,var(--r6),var(--r8));
        box-shadow:0 2px 6px rgba(21,53,145,.22);
    }

    /* Header action buttons */
    .btn-header { display:inline-flex;align-items:center;gap:.4rem;height:2.125rem;padding:0 .875rem;border-radius:.65rem;background:rgba(255,255,255,.13);border:1px solid rgba(255,255,255,.2);color:#fff;font-size:.75rem;font-weight:600;transition:background .15s;text-decoration:none;white-space:nowrap;cursor:pointer; }
    .btn-header:hover { background:rgba(255,255,255,.2); }
    .btn-header-gold { background:linear-gradient(135deg,var(--g5),#a37522);border-color:transparent;box-shadow:0 3px 10px rgba(196,149,42,.3); }
    .btn-header-gold:hover { filter:brightness(1.08); }

    /* Sum chip */
    .sum-chip { display:inline-flex;align-items:center;gap:.5rem;padding:.35rem .85rem;border-radius:999px;font-size:.7rem;font-weight:700;white-space:nowrap; }

    /* Filter inputs */
    .f-input {
        height:2.1rem;border-radius:.6rem;border:1px solid #e2e8f0;background:#fff;
        padding:0 .75rem;font-size:.78rem;color:#0f172a;outline:none;
        transition:border-color .15s,box-shadow .15s;width:100%;box-sizing:border-box;
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

    /* Action buttons */
    .btn-view    { display:inline-flex;align-items:center;gap:.2rem;padding:.2rem .55rem;border-radius:.4rem;cursor:pointer;background:#eef2ff;border:1px solid #c7d2fe;font-size:.67rem;font-weight:700;color:var(--r6);transition:background .12s; }
    .btn-view:hover { background:#e0e7ff; }
    .btn-approve { display:inline-flex;align-items:center;gap:.2rem;padding:.2rem .55rem;border-radius:.4rem;cursor:pointer;background:#ecfdf5;border:1px solid #a7f3d0;font-size:.67rem;font-weight:700;color:#065f46;transition:background .12s; }
    .btn-approve:hover { background:#d1fae5; }
    .btn-reject  { display:inline-flex;align-items:center;gap:.2rem;padding:.2rem .55rem;border-radius:.4rem;cursor:pointer;background:#fff5f5;border:1px solid #fca5a5;font-size:.67rem;font-weight:700;color:#dc2626;transition:background .12s; }
    .btn-reject:hover { background:#fee2e2; }
    .btn-remove  { display:inline-flex;align-items:center;gap:.2rem;padding:.2rem .55rem;border-radius:.4rem;cursor:pointer;background:#f8fafc;border:1px solid #e2e8f0;font-size:.67rem;font-weight:700;color:#64748b;transition:background .12s; }
    .btn-remove:hover { background:#f1f5f9; }

    /* Detail info cell */
    .detail-cell { background:#f8fafc;border:1px solid #f1f5f9;border-radius:.65rem;padding:.65rem .875rem; }
    .detail-label { font-size:.58rem;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:#94a3b8;margin:0 0 .25rem; }
    .detail-value { font-size:.8125rem;color:#1e293b;margin:0;font-weight:500; }
</style>

<div class="space-y-5 px-4 py-6 sm:px-6 lg:px-8 mx-auto max-w-screen-2xl">

    {{-- ════════ HEADER BANNER ════════ --}}
    <section class="overflow-hidden rounded-2xl"
             style="background:linear-gradient(155deg,var(--r8) 0%,var(--r7) 45%,var(--r6) 100%);
                    box-shadow:0 8px 32px rgba(10,31,92,.28);">
        <div style="position:relative;padding:1.5rem 2rem;">
            <span style="position:absolute;right:2rem;top:50%;transform:translateY(-50%);
                         font-family:Georgia,serif;font-size:5.5rem;font-weight:900;color:#fff;
                         opacity:.025;letter-spacing:.04em;user-select:none;white-space:nowrap;pointer-events:none;">
                VOLUNTEERS
            </span>

            <div class="relative flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
                <div>
                    <p style="font-size:.65rem;font-weight:800;letter-spacing:.22em;text-transform:uppercase;color:var(--g4);margin:0 0 .4rem;">
                        HSSTian Alumni Association &middot; Admin Panel
                    </p>
                    <h1 style="font-size:1.6rem;font-weight:800;color:#fff;margin:0 0 .35rem;
                               font-family:Georgia,serif;letter-spacing:-.01em;">
                        Volunteer Submissions
                    </h1>
                    <p style="font-size:.8125rem;color:rgba(255,255,255,.55);max-width:52ch;margin:0;">
                        Review committee submissions individually. Supports alumni with multiple education levels and batch memberships.
                    </p>
                </div>

                <div class="flex flex-wrap items-center gap-2 lg:mt-1 lg:shrink-0">
                    <button wire:click="resetFilters" class="btn-header">
                        <svg style="width:.8rem;height:.8rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99"/>
                        </svg>
                        Reset Filters
                    </button>
                    <button wire:click="downloadExcel"
                            wire:loading.attr="disabled"
                            class="btn-header btn-header-gold">
                        <svg style="width:.8rem;height:.8rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3"/>
                        </svg>
                        <span wire:loading.remove wire:target="downloadExcel">Download CSV</span>
                        <span wire:loading wire:target="downloadExcel">Generating…</span>
                    </button>
                </div>
            </div>

            {{-- Summary strip --}}
            <div class="mt-4 flex flex-wrap items-center gap-2 pt-4" style="border-top:1px solid rgba(255,255,255,.12);">
                <span class="sum-chip" style="background:rgba(255,255,255,.14);color:#fff;border:1px solid rgba(255,255,255,.18);">
                    <svg style="width:.8rem;height:.8rem;opacity:.7;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z"/>
                    </svg>
                    <span style="color:rgba(255,255,255,.55);">Total Submissions</span>
                    <strong>{{ $signups->total() }}</strong>
                </span>
                <span class="sum-chip" style="background:rgba(251,191,36,.14);color:#fde68a;border:1px solid rgba(251,191,36,.2);">
                    <span class="sd" style="background:#fde68a;"></span>
                    Page {{ $signups->currentPage() }} of {{ $signups->lastPage() }}
                </span>
                <span class="sum-chip" style="background:rgba(255,255,255,.08);color:rgba(255,255,255,.4);border:1px solid rgba(255,255,255,.1);font-size:.62rem;margin-left:auto;">
                    {{ now()->format('l, F j, Y') }}
                </span>
            </div>
        </div>
    </section>

    @include('partials.toast')

    {{-- ════════ KPI ROW ════════ --}}
    <div class="grid grid-cols-2 gap-3 sm:grid-cols-4">
        <div class="kpi-card" style="border-left:3px solid var(--r6);">
            <div>
                <p class="kpi-label">Total</p>
                <p class="kpi-value">{{ $signups->total() }}</p>
                <p class="kpi-sub" style="color:var(--r6);">Submissions</p>
            </div>
            <div class="kpi-icon" style="background:#eef2ff;">
                <svg class="w-4 h-4" style="color:var(--r6);" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z"/>
                </svg>
            </div>
        </div>
        <div class="kpi-card" style="border-left:3px solid #d97706;">
            <div>
                <p class="kpi-label">Showing</p>
                <p class="kpi-value">{{ $signups->count() }}</p>
                <p class="kpi-sub" style="color:#d97706;">This page</p>
            </div>
            <div class="kpi-icon" style="background:#fffbeb;">
                <svg class="w-4 h-4" style="color:#d97706;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 12h16.5m-16.5 3.75h16.5M3.75 19.5h16.5M5.625 4.5h12.75a1.875 1.875 0 0 1 0 3.75H5.625a1.875 1.875 0 0 1 0-3.75Z"/>
                </svg>
            </div>
        </div>
        <div class="kpi-card" style="border-left:3px solid #16a34a;">
            <div>
                <p class="kpi-label">Status Filter</p>
                <p class="kpi-value" style="font-size:.95rem;margin-top:.35rem;">
                    {{ $volunteerStatus === 'all' ? 'All' : str($volunteerStatus)->headline() }}
                </p>
                <p class="kpi-sub" style="color:#16a34a;">Current filter</p>
            </div>
            <div class="kpi-icon" style="background:#ecfdf5;">
                <svg class="w-4 h-4" style="color:#16a34a;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                </svg>
            </div>
        </div>
        <div class="kpi-card" style="border-left:3px solid var(--g5);">
            <div>
                <p class="kpi-label">Committee</p>
                <p class="kpi-value" style="font-size:.85rem;margin-top:.35rem;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;max-width:120px;">
                    {{ $committeeId === 'all' ? 'All' : ($committees->firstWhere('id', $committeeId)?->name ?? 'All') }}
                </p>
                <p class="kpi-sub" style="color:var(--g5);">Active filter</p>
            </div>
            <div class="kpi-icon" style="background:#fffbeb;">
                <svg class="w-4 h-4" style="color:var(--g5);" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z"/>
                </svg>
            </div>
        </div>
    </div>

    {{-- ════════ FILTERS ════════ --}}
    <div class="db-card">
        <div class="db-card-header">
            <div>
                <p class="db-card-eyebrow">Advanced Filters</p>
                <p class="db-card-title">Refine Submissions</p>
            </div>
            <span style="font-size:.72rem;color:#94a3b8;">
                Filter by user, level, batch, role, committee, and status
            </span>
        </div>

        <div style="padding:1rem 1.25rem;display:flex;flex-direction:column;gap:.75rem;">

            {{-- Row 1 --}}
            <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(200px,1fr));gap:.65rem;align-items:end;">
                <div style="grid-column:span 2;min-width:0;">
                    <span class="f-label">Search</span>
                    <div style="position:relative;">
                        <svg style="position:absolute;left:.65rem;top:50%;transform:translateY(-50%);width:.8rem;height:.8rem;color:#94a3b8;pointer-events:none;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/>
                        </svg>
                        <input type="text" wire:model.live.debounce.300ms="search"
                               placeholder="Name, committee, email, batch…"
                               class="f-input" style="padding-left:2rem;">
                    </div>
                </div>

                <div>
                    <span class="f-label">Role</span>
                    <select wire:model.live="role" class="f-select">
                        @foreach ($roles as $r)
                            <option value="{{ $r }}">{{ $r === 'all' ? 'All roles' : str($r)->headline() }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <span class="f-label">Committee</span>
                    <select wire:model.live="committeeId" class="f-select">
                        <option value="all">All committees</option>
                        @foreach ($committees as $committee)
                            <option value="{{ $committee->id }}">{{ $committee->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <span class="f-label">Status</span>
                    <select wire:model.live="volunteerStatus" class="f-select">
                        @foreach ($volunteerStatuses as $status)
                            <option value="{{ $status }}">{{ $status === 'all' ? 'All statuses' : str($status)->headline() }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <span class="f-label">Level</span>
                    <select wire:model.live="level" class="f-select">
                        @foreach ($levels as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- Row 2 --}}
            <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(180px,1fr));gap:.65rem;align-items:end;">
                <div>
                    <span class="f-label">Batch</span>
                    <select wire:model.live="batchId" class="f-select">
                        <option value="all">All batches</option>
                        @foreach ($batches as $batch)
                            <option value="{{ $batch->id }}">
                                {{ str($batch->level)->headline() }} · {{ $batch->schoolyear }}@if($batch->yeargrad) · {{ $batch->yeargrad }}@endif
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <span class="f-label">Grad Year</span>
                    <select wire:model.live="yearGrad" class="f-select">
                        <option value="all">All grad years</option>
                        @foreach ($yearGrads as $grad)
                            <option value="{{ $grad }}">{{ $grad }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <span class="f-label">School Year</span>
                    <select wire:model.live="schoolyear" class="f-select">
                        <option value="all">All school years</option>
                        @foreach ($schoolyears as $sy)
                            <option value="{{ $sy }}">{{ $sy }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <span class="f-label">Batch Rep</span>
                    <select wire:model.live="isBatchRep" class="f-select">
                        <option value="all">All</option>
                        <option value="yes">Batch rep only</option>
                        <option value="no">Non-batch rep only</option>
                    </select>
                </div>

                <div>
                    <span class="f-label">Alumni Link</span>
                    <select wire:model.live="hasAlumni" class="f-select">
                        <option value="all">All</option>
                        <option value="yes">With alumni profile</option>
                        <option value="no">No alumni profile</option>
                    </select>
                </div>

                <div>
                    <span class="f-label">Per Page</span>
                    <select wire:model.live="perPage" class="f-select">
                        <option value="10">10 per page</option>
                        <option value="25">25 per page</option>
                        <option value="50">50 per page</option>
                        <option value="100">100 per page</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    {{-- ════════ TABLE ════════ --}}
    <div class="db-card">
        <div class="db-card-header">
            <div>
                <p class="db-card-eyebrow">Records</p>
                <p class="db-card-title">Volunteer Submissions</p>
            </div>
            <div style="display:flex;align-items:center;gap:.75rem;">
                <span wire:loading style="font-size:.72rem;color:#94a3b8;">Loading…</span>
                <span style="font-size:.72rem;color:#94a3b8;">
                    {{ $signups->firstItem() ?? 0 }}–{{ $signups->lastItem() ?? 0 }} of {{ number_format($signups->total()) }}
                </span>
            </div>
        </div>

        <div style="overflow-x:auto;">
            <table class="db-table">
                <thead>
                    <tr>
                        <th style="width:48px;">#</th>
                        <th>Full Name</th>
                        <th>Level / Batch</th>
                        <th>Role</th>
                        <th>Committee</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($signups as $signup)
                        @php
                            $matchedEducation = null;
                            if ($signup->alumni?->educations?->isNotEmpty()) {
                                $matchedEducation = $batchId !== 'all'
                                    ? $signup->alumni->educations->firstWhere('batch_id', (int) $batchId)
                                    : $signup->alumni->educations->sortBy(fn($edu) => match($edu->batch?->level) {
                                        'elementary' => 1, 'highschool' => 2, 'college' => 3, default => 99,
                                    })->first();
                            }
                            $levelClass = match($matchedEducation?->batch?->level) {
                                'elementary' => 'sc-elem',
                                'highschool' => 'sc-hs',
                                'college'    => 'sc-col',
                                default      => 'sc-slate',
                            };
                        @endphp

                        <tr>
                            {{-- ID --}}
                            <td>
                                <span style="font-size:.72rem;font-weight:700;color:#94a3b8;">{{ $signup->id }}</span>
                            </td>

                            {{-- Name --}}
                            <td style="min-width:190px;">
                                <div style="display:flex;align-items:center;gap:.6rem;">
                                    <div class="db-avatar">
                                        {{ strtoupper(substr($signup->alumni->fname ?? $signup->user?->username ?? '?', 0, 1)) }}
                                    </div>
                                    <div>
                                        <p style="font-size:.8125rem;font-weight:600;color:#0f172a;margin:0;">
                                            {{ $signup->alumni
                                                ? trim($signup->alumni->fname . ' ' . $signup->alumni->lname)
                                                : ($signup->user?->username ?? 'N/A') }}
                                        </p>
                                        <p style="font-size:.68rem;color:#94a3b8;margin:.1rem 0 0;">
                                            {{ $signup->user?->email ?? '' }}
                                        </p>
                                    </div>
                                </div>
                            </td>

                            {{-- Level / Batch --}}
                            <td style="min-width:160px;">
                                @if ($matchedEducation?->batch)
                                    <div style="display:flex;flex-wrap:wrap;gap:.3rem;align-items:center;">
                                        <span class="sc {{ $levelClass }}">
                                            {{ str($matchedEducation->batch->level)->headline() }}
                                        </span>
                                        <span style="font-size:.72rem;color:#475569;">{{ $matchedEducation->batch->schoolyear }}</span>
                                        @if ($matchedEducation->is_batch_rep)
                                            <span class="sc sc-green" style="font-size:.6rem;">Rep</span>
                                        @endif
                                    </div>
                                @else
                                    <span style="font-size:.72rem;color:#cbd5e1;">—</span>
                                @endif
                            </td>

                            {{-- Role --}}
                            <td>
                                <span class="sc sc-purple">
                                    {{ str($signup->user?->getRoleNames()->first() ?? 'user')->headline() }}
                                </span>
                            </td>

                            {{-- Committee --}}
                            <td style="min-width:130px;">
                                <span style="font-size:.8rem;font-weight:600;color:#1e293b;">
                                    {{ $signup->committee?->name ?? '—' }}
                                </span>
                            </td>

                            {{-- Status --}}
                            <td>
                                @if ($signup->status === 'approved')
                                    <span class="sc sc-green"><span class="sd" style="background:#16a34a;"></span> Approved</span>
                                @elseif ($signup->status === 'pending')
                                    <span class="sc sc-amber"><span class="sd" style="background:#d97706;"></span> Pending</span>
                                @elseif ($signup->status === 'rejected')
                                    <span class="sc sc-red"><span class="sd" style="background:#ef4444;"></span> Rejected</span>
                                @else
                                    <span class="sc sc-slate">None</span>
                                @endif
                            </td>

                            {{-- Actions --}}
                            <td style="white-space:nowrap;">
                                <div style="display:flex;gap:.3rem;flex-wrap:wrap;">
                                    <button wire:click="openViewModal({{ $signup->id }})" class="btn-view">
                                        <svg style="width:.6rem;height:.6rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                                        </svg>
                                        View
                                    </button>

                                    @if ($signup->status === 'pending')
                                        <button wire:click="openActionModal('approve', {{ $signup->id }})" class="btn-approve">
                                            <svg style="width:.6rem;height:.6rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/>
                                            </svg>
                                            Approve
                                        </button>
                                        <button wire:click="openActionModal('reject', {{ $signup->id }})" class="btn-reject">
                                            <svg style="width:.6rem;height:.6rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                                            </svg>
                                            Reject
                                        </button>
                                    @endif

                                    <button wire:click="openActionModal('delete', {{ $signup->id }})" class="btn-remove">
                                        <svg style="width:.6rem;height:.6rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"/>
                                        </svg>
                                        Remove
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" style="padding:3.5rem 1.5rem;text-align:center;">
                                <div style="max-width:20rem;margin:0 auto;">
                                    <div style="width:3rem;height:3rem;border-radius:.875rem;background:#f0f4fb;border:1px solid #e2e8f0;display:flex;align-items:center;justify-content:center;margin:0 auto .75rem;">
                                        <svg style="width:1.4rem;height:1.4rem;color:#94a3b8;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z"/>
                                        </svg>
                                    </div>
                                    <p style="font-size:.875rem;font-weight:600;color:#1e293b;margin:0;">No submissions found</p>
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
            <div class="[&>*]:!shadow-none">{{ $signups->links() }}</div>
        </div>
    </div>

</div>

{{-- ════════ ACTION MODAL ════════ --}}
@if ($showActionModal)
    <div style="position:fixed;inset:0;z-index:9999;display:flex;align-items:center;justify-content:center;background:rgba(0,0,0,.5);">
        <div wire:click.self="closeActionModal" style="position:absolute;inset:0;"></div>
        <div style="position:relative;background:#fff;border-radius:1rem;padding:1.5rem;
                    width:95vw;max-width:24rem;box-shadow:0 20px 50px rgba(0,0,0,.2);">

            {{-- Icon + title --}}
            <div style="display:flex;align-items:center;gap:.625rem;margin-bottom:1rem;">
                @if ($selectedAction === 'approve')
                    <div style="width:2.25rem;height:2.25rem;border-radius:.6rem;background:#ecfdf5;border:1px solid #a7f3d0;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                        <svg style="width:1rem;height:1rem;color:#065f46;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                    </div>
                    <span style="font-size:.9rem;font-weight:800;color:#0f172a;">Approve Submission</span>
                @elseif ($selectedAction === 'reject')
                    <div style="width:2.25rem;height:2.25rem;border-radius:.6rem;background:#fff5f5;border:1px solid #fca5a5;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                        <svg style="width:1rem;height:1rem;color:#dc2626;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                    </div>
                    <span style="font-size:.9rem;font-weight:800;color:#0f172a;">Reject Submission</span>
                @else
                    <div style="width:2.25rem;height:2.25rem;border-radius:.6rem;background:#f1f5f9;border:1px solid #e2e8f0;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                        <svg style="width:1rem;height:1rem;color:#64748b;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"/></svg>
                    </div>
                    <span style="font-size:.9rem;font-weight:800;color:#0f172a;">Remove Submission</span>
                @endif
            </div>

            <p style="font-size:.8125rem;color:#475569;line-height:1.6;margin:0 0 1.25rem;">
                @if ($selectedAction === 'approve')
                    This will mark the committee submission as <strong style="color:#065f46;">approved</strong>. The alumni will be assigned to this committee.
                @elseif ($selectedAction === 'reject')
                    This will mark the committee submission as <strong style="color:#dc2626;">rejected</strong>.
                @else
                    This will <strong style="color:#dc2626;">permanently remove</strong> this alumni from the selected committee submission. This cannot be undone.
                @endif
            </p>

            <div style="display:flex;gap:.5rem;justify-content:flex-end;">
                <button wire:click="closeActionModal"
                        style="padding:.45rem .9rem;border-radius:.6rem;border:1px solid #e2e8f0;background:#fff;font-size:.8rem;font-weight:600;color:#475569;cursor:pointer;">
                    Cancel
                </button>
                <button wire:click="confirmAction"
                        style="padding:.45rem 1rem;border-radius:.6rem;border:none;font-size:.8rem;font-weight:700;color:#fff;cursor:pointer;
                               background:{{ $selectedAction === 'approve' ? '#16a34a' : ($selectedAction === 'reject' ? '#dc2626' : '#475569') }};"
                        onmouseover="this.style.filter='brightness(1.1)'"
                        onmouseout="this.style.filter='brightness(1)'">
                    Yes,
                    {{ $selectedAction === 'approve' ? 'Approve' : ($selectedAction === 'reject' ? 'Reject' : 'Remove') }}
                </button>
            </div>
        </div>
    </div>
@endif

{{-- ════════ VIEW MODAL ════════ --}}
@if ($showViewModal && $selectedSignup)
    <div style="position:fixed;inset:0;z-index:9999;display:flex;align-items:center;justify-content:center;background:rgba(0,0,0,.55);">
        <div wire:click.self="closeViewModal" style="position:absolute;inset:0;"></div>

        <div style="position:relative;background:#fff;border-radius:1.25rem;
                    width:95vw;max-width:56rem;max-height:92vh;
                    display:flex;flex-direction:column;
                    box-shadow:0 25px 60px rgba(0,0,0,.25);overflow:hidden;">

            {{-- Modal header --}}
            <div style="display:flex;align-items:center;justify-content:space-between;
                        padding:1.1rem 1.5rem;border-bottom:1px solid #f1f5f9;flex-shrink:0;">
                <div style="display:flex;align-items:center;gap:.75rem;">
                    <div class="db-avatar" style="width:2.5rem;height:2.5rem;font-size:.85rem;border-radius:.625rem;">
                        {{ strtoupper(substr($selectedSignup->alumni->fname ?? $selectedSignup->user?->username ?? '?', 0, 1)) }}
                    </div>
                    <div>
                        <p style="font-size:.6rem;font-weight:700;letter-spacing:.16em;text-transform:uppercase;color:var(--g5);margin:0;">
                            Volunteer Submission Details
                        </p>
                        <p style="font-size:1rem;font-weight:800;color:#0f172a;margin:.1rem 0 0;">
                            {{ $selectedSignup->alumni
                                ? trim($selectedSignup->alumni->fname . ' ' . $selectedSignup->alumni->lname)
                                : ($selectedSignup->user?->username ?? 'Submission') }}
                        </p>
                    </div>
                </div>
                <button wire:click="closeViewModal"
                        style="width:2rem;height:2rem;border-radius:.5rem;border:1px solid #e2e8f0;
                               background:#f8fafc;cursor:pointer;font-size:1.1rem;color:#64748b;">
                    &times;
                </button>
            </div>

            {{-- Modal body --}}
            <div style="overflow-y:auto;flex:1;padding:1.25rem 1.5rem;display:flex;flex-direction:column;gap:1rem;">

                {{-- Quick info row --}}
                <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(150px,1fr));gap:.6rem;">
                    <div class="detail-cell">
                        <p class="detail-label">Username</p>
                        <p class="detail-value">{{ $selectedSignup->user?->username ?? 'N/A' }}</p>
                    </div>
                    <div class="detail-cell">
                        <p class="detail-label">Email</p>
                        <p class="detail-value" style="word-break:break-all;">{{ $selectedSignup->user?->email ?? 'N/A' }}</p>
                    </div>
                    <div class="detail-cell">
                        <p class="detail-label">Committee</p>
                        <p class="detail-value">{{ $selectedSignup->committee?->name ?? 'N/A' }}</p>
                    </div>
                    <div class="detail-cell">
                        <p class="detail-label">Status</p>
                        <div style="margin-top:.2rem;">
                            @if ($selectedSignup->status === 'approved')
                                <span class="sc sc-green"><span class="sd" style="background:#16a34a;"></span> Approved</span>
                            @elseif ($selectedSignup->status === 'pending')
                                <span class="sc sc-amber"><span class="sd" style="background:#d97706;"></span> Pending</span>
                            @elseif ($selectedSignup->status === 'rejected')
                                <span class="sc sc-red"><span class="sd" style="background:#ef4444;"></span> Rejected</span>
                            @else
                                <span class="sc sc-slate">None</span>
                            @endif
                        </div>
                    </div>
                </div>

                @if ($selectedSignup->alumni)
                    {{-- Personal info + Address --}}
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:.75rem;">

                        <div style="background:#f8fafc;border:1px solid #e2e8f0;border-radius:.875rem;padding:1rem;">
                            <p style="font-size:.72rem;font-weight:800;letter-spacing:.12em;text-transform:uppercase;color:var(--g5);margin:0 0 .75rem;">Personal Information</p>
                            <div style="display:grid;grid-template-columns:1fr 1fr;gap:.5rem;">
                                <div class="detail-cell">
                                    <p class="detail-label">First Name</p>
                                    <p class="detail-value">{{ $selectedSignup->alumni->fname ?: 'N/A' }}</p>
                                </div>
                                <div class="detail-cell">
                                    <p class="detail-label">Middle Name</p>
                                    <p class="detail-value">{{ $selectedSignup->alumni->mname ?: 'N/A' }}</p>
                                </div>
                                <div class="detail-cell">
                                    <p class="detail-label">Last Name</p>
                                    <p class="detail-value">{{ $selectedSignup->alumni->lname ?: 'N/A' }}</p>
                                </div>
                                <div class="detail-cell">
                                    <p class="detail-label">Cellphone</p>
                                    <p class="detail-value">{{ $selectedSignup->alumni->cellphone ?: 'N/A' }}</p>
                                </div>
                                <div class="detail-cell" style="grid-column:span 2;">
                                    <p class="detail-label">Occupation</p>
                                    <p class="detail-value">{{ $selectedSignup->alumni->occupation ?: 'N/A' }}</p>
                                </div>
                            </div>
                        </div>

                        <div style="background:#f8fafc;border:1px solid #e2e8f0;border-radius:.875rem;padding:1rem;">
                            <p style="font-size:.72rem;font-weight:800;letter-spacing:.12em;text-transform:uppercase;color:var(--g5);margin:0 0 .75rem;">Address</p>
                            <div class="detail-cell">
                                <p class="detail-label">Full Address</p>
                                <p class="detail-value" style="line-height:1.5;">
                                    {{
                                        collect([
                                            $selectedSignup->alumni->address_line_1,
                                            $selectedSignup->alumni->address_line_2,
                                            $selectedSignup->alumni->city,
                                            $selectedSignup->alumni->state_province,
                                            $selectedSignup->alumni->postal_code,
                                            $selectedSignup->alumni->country,
                                        ])->filter()->implode(', ') ?: 'N/A'
                                    }}
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- Education records --}}
                    <div style="background:#f8fafc;border:1px solid #e2e8f0;border-radius:.875rem;padding:1rem;">
                        <p style="font-size:.72rem;font-weight:800;letter-spacing:.12em;text-transform:uppercase;color:var(--g5);margin:0 0 .75rem;">Educational Background</p>

                        <div style="display:flex;flex-direction:column;gap:.5rem;">
                            @forelse ($selectedSignup->alumni->educations->sortBy(fn($edu) => match($edu->batch?->level) {
                                'elementary' => 1, 'highschool' => 2, 'college' => 3, default => 99,
                            }) as $education)
                                @php
                                    $eduLvlClass = match($education->batch?->level) {
                                        'elementary' => 'sc-elem', 'highschool' => 'sc-hs', 'college' => 'sc-col', default => 'sc-slate',
                                    };
                                @endphp
                                <div style="background:#fff;border:1px solid #e8edf5;border-radius:.65rem;padding:.75rem 1rem;">
                                    <div style="display:flex;flex-wrap:wrap;gap:.4rem;align-items:center;margin-bottom:.6rem;">
                                        <span class="sc {{ $eduLvlClass }}">{{ str($education->batch?->level ?? 'n/a')->headline() }}</span>
                                        @if ($education->is_batch_rep)
                                            <span class="sc sc-green" style="font-size:.6rem;">Batch Representative</span>
                                        @endif
                                    </div>
                                    <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:.5rem;">
                                        <div class="detail-cell">
                                            <p class="detail-label">School Year</p>
                                            <p class="detail-value">{{ $education->batch?->schoolyear ?? 'N/A' }}</p>
                                        </div>
                                        <div class="detail-cell">
                                            <p class="detail-label">Year Graduated</p>
                                            <p class="detail-value">{{ $education->batch?->yeargrad ?? 'N/A' }}</p>
                                        </div>
                                        <div class="detail-cell">
                                            <p class="detail-label">Did Graduate</p>
                                            <p class="detail-value">{{ $education->did_graduate ? 'Yes' : 'No' }}</p>
                                        </div>
                                        <div class="detail-cell">
                                            <p class="detail-label">Year Attended</p>
                                            <p class="detail-value">{{ $education->school_year_attended ?: 'N/A' }}</p>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div style="border:1.5px dashed #e2e8f0;border-radius:.65rem;padding:1.25rem;text-align:center;">
                                    <p style="font-size:.8rem;color:#94a3b8;margin:0;">No education records found.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                @endif

                {{-- Notes --}}
                <div style="background:#f8fafc;border:1px solid #e2e8f0;border-radius:.875rem;padding:1rem;">
                    <p style="font-size:.72rem;font-weight:800;letter-spacing:.12em;text-transform:uppercase;color:var(--g5);margin:0 0 .5rem;">Submission Notes</p>
                    <p style="font-size:.8125rem;color:#475569;line-height:1.65;margin:0;">
                        {{ $selectedSignup->notes ?: 'No notes provided.' }}
                    </p>
                </div>

                {{-- Modal actions --}}
                @if ($selectedSignup->status === 'pending')
                    <div style="display:flex;gap:.5rem;padding-top:.25rem;">
                        <button wire:click="openActionModal('approve', {{ $selectedSignup->id }}); closeViewModal()" class="btn-approve" style="padding:.4rem .9rem;font-size:.78rem;">
                            <svg style="width:.7rem;height:.7rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                            Approve
                        </button>
                        <button wire:click="openActionModal('reject', {{ $selectedSignup->id }}); closeViewModal()" class="btn-reject" style="padding:.4rem .9rem;font-size:.78rem;">
                            <svg style="width:.7rem;height:.7rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                            Reject
                        </button>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endif

</div>
