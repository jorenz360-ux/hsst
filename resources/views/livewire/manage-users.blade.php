<div class="min-h-screen" style="background:#f0f4fb; font-family:'DM Sans',system-ui,sans-serif;">

{{-- ════════════════════════════════════════════════════════════════ --}}
{{-- SHARED STYLES                                                    --}}
{{-- ════════════════════════════════════════════════════════════════ --}}
<style>
    :root {
        --r9: #0a1f5c;
        --r8: #0f2a7a;
        --r7: #153591;
        --r6: #1a3fa8;
        --r5: #2150c8;
        --g5: #c4952a;
        --g4: #d4a843;
    }

    .mu-field {
        height: 2.5rem;
        border-radius: .75rem;
        border: 1px solid #e2e8f0;
        background: #fff;
        padding: 0 .875rem;
        font-size: .8125rem;
        color: #0f172a;
        outline: none;
        transition: border-color .15s, box-shadow .15s;
        width: 100%;
    }
    .mu-field::placeholder { color: #94a3b8; }
    .mu-field:hover  { border-color: #94a3b8; }
    .mu-field:focus  { border-color: var(--r6); box-shadow: 0 0 0 3px rgba(26,63,168,.1); }
    .mu-field-icon   { padding-left: 2.4rem; }

    .mu-select {
        height: 2.5rem;
        border-radius: .75rem;
        border: 1px solid #e2e8f0;
        background: #fff url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%2394a3b8' stroke-width='2'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' d='M19 9l-7 7-7-7'/%3E%3C/svg%3E") no-repeat right .75rem center / .9rem;
        padding: 0 2.2rem 0 .875rem;
        font-size: .8125rem;
        color: #0f172a;
        outline: none;
        appearance: none;
        transition: border-color .15s, box-shadow .15s;
        width: 100%;
        cursor: pointer;
    }
    .mu-select:hover { border-color: #94a3b8; }
    .mu-select:focus { border-color: var(--r6); box-shadow: 0 0 0 3px rgba(26,63,168,.1); }

    .mu-label {
        display: block;
        font-size: .65rem;
        font-weight: 700;
        letter-spacing: .1em;
        text-transform: uppercase;
        color: #64748b;
        margin-bottom: .35rem;
    }

    /* Role badges */
    .role-alumni         { background:#eef2ff; color:#1a3fa8; border:1px solid #c7d2fe; }
    .role-batch-rep      { background:#fef9ee; color:#92700a; border:1px solid #fde68a; }
    .role-coordinator    { background:#f5f3ff; color:#5b21b6; border:1px solid #ddd6fe; }
    .role-ssps           { background:#f0fdf4; color:#065f46; border:1px solid #bbf7d0; }
    .role-default        { background:#f1f5f9; color:#475569; border:1px solid #e2e8f0; }

    /* Status chips */
    .chip-green  { background:#ecfdf5; color:#065f46; border:1px solid #a7f3d0; }
    .chip-red    { background:#fef2f2; color:#991b1b; border:1px solid #fecaca; }
    .chip-amber  { background:#fffbeb; color:#92700a; border:1px solid #fde68a; }
    .chip-slate  { background:#f1f5f9; color:#475569; border:1px solid #e2e8f0; }
    .chip-blue   { background:#eef2ff; color:#1a3fa8; border:1px solid #c7d2fe; }

    .status-chip {
        display: inline-flex;
        align-items: center;
        gap: .3rem;
        padding: .2rem .6rem;
        border-radius: 999px;
        font-size: .68rem;
        font-weight: 700;
        letter-spacing: .04em;
        white-space: nowrap;
    }
    .status-dot {
        width: .45rem;
        height: .45rem;
        border-radius: 50%;
        flex-shrink: 0;
    }

    /* Table */
    .mu-table thead th {
        font-size: .62rem;
        font-weight: 700;
        letter-spacing: .14em;
        text-transform: uppercase;
        color: #64748b;
        padding: .7rem 1.1rem;
        text-align: left;
        white-space: nowrap;
    }
    .mu-table thead th:last-child { text-align: right; }
    .mu-table tbody tr {
        transition: background .12s;
        border-bottom: 1px solid #f1f5f9;
    }
    .mu-table tbody tr:last-child { border-bottom: none; }
    .mu-table tbody tr:hover { background: #f8faff; }
    .mu-table td {
        padding: .85rem 1.1rem;
        vertical-align: middle;
    }
    .mu-table td:last-child { text-align: right; }

    /* Btn styles */
    .btn-primary {
        display: inline-flex; align-items: center; gap: .4rem;
        height: 2.375rem; padding: 0 1rem;
        border-radius: .75rem;
        background: linear-gradient(135deg, var(--r6) 0%, var(--r8) 100%);
        box-shadow: 0 4px 14px rgba(21,53,145,.28), inset 0 1px 0 rgba(255,255,255,.1);
        color: #fff; font-size: .8rem; font-weight: 700;
        transition: filter .15s, box-shadow .15s, transform .1s;
        cursor: pointer; border: none; text-decoration: none; white-space: nowrap;
    }
    .btn-primary:hover  { filter: brightness(1.08); }
    .btn-primary:active { transform: translateY(1px); }

    .btn-gold {
        display: inline-flex; align-items: center; gap: .4rem;
        height: 2.375rem; padding: 0 1rem;
        border-radius: .75rem;
        background: linear-gradient(135deg, var(--g5) 0%, #a37522 100%);
        box-shadow: 0 4px 14px rgba(196,149,42,.3), inset 0 1px 0 rgba(255,255,255,.12);
        color: #fff; font-size: .8rem; font-weight: 700;
        transition: filter .15s, transform .1s;
        cursor: pointer; border: none; text-decoration: none; white-space: nowrap;
    }
    .btn-gold:hover  { filter: brightness(1.07); }
    .btn-gold:active { transform: translateY(1px); }

    .btn-ghost {
        display: inline-flex; align-items: center; gap: .4rem;
        height: 2.375rem; padding: 0 .875rem;
        border-radius: .75rem;
        background: #fff; border: 1px solid #e2e8f0;
        color: #475569; font-size: .8rem; font-weight: 600;
        transition: background .12s, border-color .12s, color .12s;
        cursor: pointer; text-decoration: none; white-space: nowrap;
    }
    .btn-ghost:hover { background: #f8fafc; border-color: #cbd5e1; color: #1e293b; }

    .btn-action {
        display: inline-flex; align-items: center; gap: .3rem;
        height: 2rem; padding: 0 .7rem;
        border-radius: .6rem;
        font-size: .72rem; font-weight: 600;
        transition: background .12s, border-color .12s; cursor: pointer; white-space: nowrap;
    }
    .btn-action-view {
        background: #fff; border: 1px solid #e2e8f0; color: #475569;
    }
    .btn-action-view:hover { background: #f0f4fb; border-color: #c7d2fe; color: var(--r6); }
    .btn-action-edit {
        background: var(--r6); border: 1px solid var(--r7); color: #fff;
    }
    .btn-action-edit:hover { background: var(--r7); }

    .btn-action-delete {
        background: #fff; border: 1px solid #fecaca; color: #dc2626;
    }
    .btn-action-delete:hover { background: #fef2f2; border-color: #fca5a5; }

    .btn-action-deactivate {
        background: #fff; border: 1px solid #fde68a; color: #92700a;
    }
    .btn-action-deactivate:hover { background: #fffbeb; border-color: #fbbf24; }

    .btn-action-activate {
        background: #fff; border: 1px solid #a7f3d0; color: #065f46;
    }
    .btn-action-activate:hover { background: #ecfdf5; border-color: #34d399; }

    /* Avatar */
    .mu-avatar {
        width: 2.25rem; height: 2.25rem; border-radius: .625rem;
        display: flex; align-items: center; justify-content: center;
        font-size: .75rem; font-weight: 800; color: #fff; flex-shrink: 0;
        background: linear-gradient(135deg, var(--r6) 0%, var(--r8) 100%);
        box-shadow: 0 2px 8px rgba(21,53,145,.25);
        letter-spacing: .04em;
    }

    /* Modal */
    .mu-modal-overlay {
        position: fixed; inset: 0; z-index: 60;
        display: flex; align-items: center; justify-content: center;
        background: rgba(10,31,92,.55);
        backdrop-filter: blur(4px);
        padding: 1.25rem;
    }
    .mu-modal {
        width: 100%; max-width: 64rem;
        max-height: 90vh;
        background: #fff;
        border-radius: 1.5rem;
        overflow: hidden;
        display: flex; flex-direction: column;
        box-shadow: 0 32px 80px rgba(10,31,92,.3), 0 0 0 1px rgba(26,63,168,.1);
    }

    /* Summary chip */
    .sum-chip {
        display: inline-flex; align-items: center; gap: .5rem;
        padding: .35rem .85rem;
        border-radius: 999px;
        font-size: .7rem; font-weight: 700;
        white-space: nowrap;
    }

    /* Education mini-badge */
    .edu-tag {
        display: inline-flex; align-items: center;
        padding: .15rem .55rem;
        border-radius: .4rem;
        font-size: .65rem; font-weight: 700;
        background: #eef2ff; color: var(--r6); border: 1px solid #c7d2fe;
        white-space: nowrap;
    }
    .edu-tag.hs     { background:#fef9ee; color:#92700a; border-color:#fde68a; }
    .edu-tag.col    { background:#f5f3ff; color:#5b21b6; border-color:#ddd6fe; }
    .edu-tag.elem   { background:#f0fdf4; color:#065f46; border-color:#bbf7d0; }

    /* Sidebar modal detail labels */
    .detail-label {
        font-size: .62rem; font-weight: 700; letter-spacing: .1em;
        text-transform: uppercase; color: #94a3b8; margin-bottom: .25rem;
    }
    .detail-val { font-size: .8125rem; color: #1e293b; font-weight: 500; }
</style>

@php
    $pageUsers = $users->getCollection();
    $totalCount   = $users->total();
    $alumniCount  = $pageUsers->whereNotNull('alumni_id')->count();
    $repCount     = $pageUsers->filter(fn($u) => $u->alumni?->educations?->contains(fn($e) => $e->is_batch_rep))->count();
    $noProfileCount = $pageUsers->whereNull('alumni_id')->count();
    $filteredCount  = $users->count();
@endphp

<div class="space-y-5 px-4 py-6 sm:px-6 lg:px-8 mx-auto max-w-screen-2xl">

    @include('partials.toast')

    {{-- ════════════════════════════════════════════════════════════
         CONTROL HEADER
    ════════════════════════════════════════════════════════════ --}}
    <section class="overflow-hidden rounded-2xl"
             style="background:linear-gradient(155deg,var(--r8) 0%,var(--r7) 45%,var(--r6) 100%);
                    box-shadow:0 8px 32px rgba(10,31,92,.28);">
        {{-- BG watermark --}}
        <div class="pointer-events-none absolute inset-0 overflow-hidden" aria-hidden="true"
             style="position:relative;">
            <span style="position:absolute;right:2rem;top:50%;transform:translateY(-50%);
                         font-family:Georgia,serif;font-size:7rem;font-weight:900;color:#fff;
                         opacity:.025;letter-spacing:.05em;user-select:none;white-space:nowrap;">
                MANAGE USERS
            </span>
        </div>

        <div class="relative px-6 py-6 sm:px-8">
            <div class="flex flex-col gap-5 lg:flex-row lg:items-start lg:justify-between">
                {{-- Title block --}}
                <div>
                    <p class="text-[.65rem] font-bold uppercase tracking-[.22em]"
                       style="color:var(--g4);">
                        HSST Alumni Portal &middot; Admin Control
                    </p>
                    <h1 class="mt-2 text-2xl font-bold tracking-tight text-white sm:text-3xl"
                        style="font-family:Georgia,serif;letter-spacing:-.01em;">
                        Manage Users
                    </h1>
                    <p class="mt-1.5 text-sm leading-6" style="color:rgba(255,255,255,.6);max-width:46ch;">
                        Monitor accounts, review alumni linkages, assign roles, and control
                        access across the reunion platform.
                    </p>
                </div>

                {{-- Actions --}}
                <div class="flex flex-wrap items-center gap-2.5 lg:mt-1 lg:shrink-0">
                    <button wire:click="resetFilters" class="btn-ghost" style="height:2.375rem;">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99"/>
                        </svg>
                        Reset Filters
                    </button>

                    <a href="{{ route('users.create') }}" wire:navigate class="btn-gold">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                        </svg>
                        Add User
                    </a>
                </div>
            </div>

            {{-- Summary strip --}}
            <div class="mt-5 flex flex-wrap items-center gap-2 pt-5"
                 style="border-top:1px solid rgba(255,255,255,.12);">

                <span class="sum-chip" style="background:rgba(255,255,255,.14);color:#fff;border:1px solid rgba(255,255,255,.18);">
                    <svg class="w-3.5 h-3.5 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z"/>
                    </svg>
                    <span class="text-white/60 font-semibold">Total</span>
                    <strong>{{ number_format($totalCount) }}</strong>
                </span>

                <span class="sum-chip" style="background:rgba(16,185,129,.14);color:#6ee7b7;border:1px solid rgba(16,185,129,.2);">
                    <span class="status-dot" style="background:#6ee7b7;"></span>
                    Alumni Linked: <strong>{{ $alumniCount }}</strong>
                </span>

                <span class="sum-chip" style="background:rgba(196,149,42,.14);color:var(--g4);border:1px solid rgba(196,149,42,.22);">
                    <span class="status-dot" style="background:var(--g4);"></span>
                    Batch Reps: <strong>{{ $repCount }}</strong>
                </span>

                <span class="sum-chip" style="background:rgba(239,68,68,.12);color:#fca5a5;border:1px solid rgba(239,68,68,.2);">
                    <span class="status-dot" style="background:#fca5a5;"></span>
                    No Profile: <strong>{{ $noProfileCount }}</strong>
                </span>

                <span class="sum-chip ml-auto" style="background:rgba(255,255,255,.08);color:rgba(255,255,255,.5);border:1px solid rgba(255,255,255,.12);font-size:.62rem;">
                    Showing {{ $filteredCount }} of {{ number_format($totalCount) }} on this page
                </span>
            </div>
        </div>
    </section>

    {{-- ════════════════════════════════════════════════════════════
         SMART FILTER BAR
    ════════════════════════════════════════════════════════════ --}}
    <section class="rounded-2xl bg-white"
             style="border:1px solid #e2e8f0; box-shadow:0 1px 6px rgba(15,23,42,.05);">

        {{-- Filter header --}}
        <div class="flex items-center justify-between px-5 py-3"
             style="border-bottom:1px solid #f1f5f9;">
            <div class="flex items-center gap-2">
                <svg class="w-4 h-4" style="color:var(--r6);" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 3c2.755 0 5.455.232 8.083.678.533.09.917.556.917 1.096v1.044a2.25 2.25 0 0 1-.659 1.591l-5.432 5.432a2.25 2.25 0 0 0-.659 1.591v2.927a2.25 2.25 0 0 1-1.244 2.013L9.75 21v-6.568a2.25 2.25 0 0 0-.659-1.591L3.659 7.409A2.25 2.25 0 0 1 3 5.818V4.774c0-.54.384-1.006.917-1.096A48.32 48.32 0 0 1 12 3Z"/>
                </svg>
                <span class="text-xs font-bold uppercase tracking-[.14em] text-slate-500">Smart Filters</span>
            </div>

            @if ($search || $role !== 'all' || $level !== 'all' || $isBatchRep !== 'all' || $hasAlumni !== 'all')
                <button wire:click="resetFilters"
                        class="text-[.68rem] font-bold transition hover:underline"
                        style="color:var(--r6);">
                    Clear All
                </button>
            @endif
        </div>

        {{-- Filter inputs --}}
        <div class="px-5 py-4">
            <div class="grid grid-cols-1 gap-3 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6">

                {{-- Search --}}
                <div class="xl:col-span-2">
                    <label class="mu-label">Search</label>
                    <div class="relative">
                        <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3" style="color:#94a3b8;">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z"/>
                            </svg> 
                        </span>
                        <input
                            type="text"
                            wire:model.live.debounce.300ms="search"
                            placeholder="Username, email, name, batch…"
                            class="mu-field mu-field-icon"
                        >
                    </div>
                </div>

                {{-- Role --}}
                <div>
                    <label class="mu-label">Role</label>
                    <select wire:model.live="role" class="mu-select">
                        @foreach ($roles as $r)
                            <option value="{{ $r }}">
                                {{ $r === 'all' ? 'All Roles' : str($r)->headline() }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Education Level --}}
                <div>
                    <label class="mu-label">Education Level</label>
                    <select wire:model.live="level" class="mu-select">
                        @foreach ($levels as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Batch Rep --}}
                <div>
                    <label class="mu-label">Batch Rep</label>
                    <select wire:model.live="isBatchRep" class="mu-select">
                        <option value="all">All Status</option>
                        <option value="yes">Rep Only</option>
                        <option value="no">Non-Rep</option>
                    </select>
                </div>

                {{-- Alumni Link + Per Page in one col --}}
                <div class="flex gap-2">
                    <div class="flex-1">
                        <label class="mu-label">Alumni</label>
                        <select wire:model.live="hasAlumni" class="mu-select">
                            <option value="all">All</option>
                            <option value="yes">Linked</option>
                            <option value="no">Unlinked</option>
                        </select>
                    </div>
                    <div style="width:90px;">
                        <label class="mu-label">Per page</label>
                        <select wire:model.live="perPage" class="mu-select">
                            <option value="10">10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </select>
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- ════════════════════════════════════════════════════════════
         MAIN TABLE
    ════════════════════════════════════════════════════════════ --}}
    <section class="overflow-hidden rounded-2xl bg-white"
             style="border:1px solid #e2e8f0; box-shadow:0 1px 6px rgba(15,23,42,.05);">

        {{-- Table header --}}
        <div class="flex flex-col gap-2 px-5 py-4 sm:flex-row sm:items-center sm:justify-between"
             style="border-bottom:1px solid #f1f5f9;">
            <div>
                <h2 class="text-base font-bold text-slate-900">User Directory</h2>
                <p class="mt-0.5 text-xs text-slate-500">
                    Accounts with alumni linkage, role assignments, and education history.
                </p>
            </div>
            <div class="flex items-center gap-2.5">
                <span class="status-chip chip-blue">
                    <span class="status-dot" style="background:var(--r6);"></span>
                    {{ number_format($users->total()) }} total &bull; {{ $filteredCount }} on page
                </span>
            </div>
        </div>

        {{-- Table --}}
        <div class="overflow-x-auto">
            <table class="mu-table min-w-full">
                <thead style="background:#f8fafc; border-bottom:1px solid #e2e8f0;">
                    <tr>
                        <th>User</th>
                        <th>Full Name</th>
                        <th>Role</th>
                        <th>Education / Batch</th>
                        <th>Profile</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($users as $user)
                        @php
                            $fullName     = $user->alumni ? trim(collect([$user->alumni->fname, $user->alumni->mname, $user->alumni->lname])->filter()->implode(' ')) : null;
                            $hasProfile   = filled($user->alumni);
                            $isRep        = $user->alumni?->educations?->contains(fn($e) => $e->is_batch_rep) ?? false;
                            $primaryRole  = $user->getRoleNames()->first() ?? 'user';
                            $occupation   = $user->alumni?->occupation;
                            $educations   = $user->alumni?->educations?->sortBy(fn($e) => match($e->batch?->level) {
                                'elementary' => 1, 'highschool' => 2, 'college' => 3, default => 99,
                            }) ?? collect();

                            $roleClass = match($primaryRole) {
                                'alumni'                => 'role-alumni',
                                'batch-representative'  => 'role-batch-rep',
                                'reunion-coordinator'   => 'role-coordinator',
                                'ssps'                  => 'role-ssps',
                                default                 => 'role-default',
                            };

                            $initials = strtoupper(
                                $hasProfile
                                    ? substr($user->alumni->fname ?? 'U', 0, 1) . substr($user->alumni->lname ?? '', 0, 1)
                                    : substr($user->username ?? 'U', 0, 2)
                            );
                        @endphp

                        <tr>
                            {{-- User Identity --}}
                            <td style="min-width:200px;">
                                <div class="flex items-center gap-3">
                                    <div class="mu-avatar">{{ $initials }}</div>
                                    <div class="min-w-0">
                                        <p class="text-sm font-bold text-slate-900 truncate leading-tight">
                                            {{ $user->username }}
                                        </p>
                                        <p class="text-xs text-slate-400 truncate mt-0.5 leading-tight">
                                            {{ $user->email ?: 'No email' }}
                                        </p>
                                        <p class="text-[.62rem] text-slate-300 mt-0.5">#{{ $user->id }}</p>
                                    </div>
                                </div>
                            </td>

                            {{-- Full Name --}}
                            <td style="min-width:160px;">
                                @if ($fullName)
                                    <p class="text-sm font-semibold text-slate-800 leading-tight">{{ $fullName }}</p>
                                    @if ($occupation)
                                        <p class="text-xs text-slate-400 mt-0.5 truncate max-w-[150px]">{{ $occupation }}</p>
                                    @endif
                                    @if ($isRep)
                                        <span class="status-chip chip-amber mt-1.5" style="font-size:.62rem;">
                                            <span class="status-dot" style="background:#c4952a;"></span>
                                            Batch Rep
                                        </span>
                                    @endif
                                @else
                                    <span class="text-xs text-slate-400 italic">No alumni profile</span>
                                @endif
                            </td>

                            {{-- Role --}}
                            <td style="min-width:130px;">
                                <span class="status-chip {{ $roleClass }}">
                                    {{ $primaryRole === 'all' ? 'User' : str($primaryRole)->headline() }}
                                </span>
                            </td>

                            {{-- Education / Batch --}}
                            <td style="min-width:180px;">
                                @if ($educations->isNotEmpty())
                                    <div class="flex flex-wrap gap-1.5">
                                        @foreach ($educations as $edu)
                                            @php
                                                $levelTag = match($edu->batch?->level) {
                                                    'elementary' => 'elem',
                                                    'highschool' => 'hs',
                                                    'college' => 'col',
                                                    default => '',
                                                };
                                                $levelShort = match($edu->batch?->level) {
                                                    'elementary' => 'Elem',
                                                    'highschool' => 'H.S.',
                                                    'college' => 'Col',
                                                    default => '-',
                                                };
                                            @endphp
                                            <span class="edu-tag {{ $levelTag }}" title="{{ str($edu->batch?->level)->headline() }} &bull; {{ $edu->batch?->schoolyear }} &bull; Grad {{ $edu->batch?->yeargrad }}">
                                                {{ $levelShort }}
                                                @if ($edu->batch?->yeargrad)
                                                    &rsquo;{{ substr($edu->batch->yeargrad, -2) }}
                                                @endif
                                            </span>
                                        @endforeach
                                    </div>
                                @else
                                    <span class="text-xs text-slate-400">-</span>
                                @endif
                            </td>

                            {{-- Profile / Status --}}
                            <td style="min-width:120px;">
                                @if ($hasProfile)
                                    <span class="status-chip chip-green">
                                        <span class="status-dot" style="background:#10b981;"></span>
                                        Linked
                                    </span>
                                @else
                                    <span class="status-chip chip-red">
                                        <span class="status-dot" style="background:#ef4444;"></span>
                                        No Profile
                                    </span>
                                @endif
                            </td>

                            {{-- Actions --}}
                            <td style="min-width:140px; white-space:nowrap;">
                                <div class="flex items-center justify-end gap-2">
                                    <button wire:click="view({{ $user->id }})"
                                            class="btn-action btn-action-view">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                                        </svg>
                                        View
                                    </button>

                                    <button wire:click="confirmReset({{ $user->id }})"
                                            class="btn-action"
                                            style="color:#6366f1;border-color:#c7d2fe;background:#eef2ff;"
                                            title="Reset Password">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 5.25a3 3 0 0 1 3 3m3 0a6 6 0 0 1-7.029 5.912c-.563-.097-1.159.026-1.563.43L10.5 17.25H8.25v2.25H6v2.25H2.25v-2.818c0-.597.237-1.17.659-1.591l6.499-6.499c.404-.404.527-1 .43-1.563A6 6 0 0 1 21.75 8.25Z"/>
                                        </svg>
                                        Reset
                                    </button>

                                    @if ($user->is_active)
                                        <button wire:click="confirmToggle({{ $user->id }})"
                                                class="btn-action btn-action-deactivate">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 0 0 5.636 5.636m12.728 12.728A9 9 0 0 1 5.636 5.636m12.728 12.728L5.636 5.636"/>
                                            </svg>
                                            Deactivate
                                        </button>
                                    @else
                                        <button wire:click="confirmToggle({{ $user->id }})"
                                                class="btn-action btn-action-activate">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                            </svg>
                                            Activate
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="padding:4rem 2rem;">
                                <div style="max-width:22rem; margin:0 auto; text-align:center;">
                                    <div style="width:3.5rem;height:3.5rem;border-radius:1rem;
                                                background:#f0f4fb;border:1px solid #e2e8f0;
                                                display:flex;align-items:center;justify-content:center;
                                                margin:0 auto 1rem;">
                                        <svg style="width:1.5rem;height:1.5rem;color:#94a3b8;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z"/>
                                        </svg>
                                    </div>
                                    <h3 style="font-size:1rem;font-weight:700;color:#1e293b;margin-bottom:.5rem;">
                                        No users found
                                    </h3>
                                    <p style="font-size:.8125rem;color:#64748b;line-height:1.6;margin-bottom:1.5rem;">
                                        No records matched your current filters. Try adjusting
                                        the search or role criteria, or add a new user account.
                                    </p>
                                    <div style="display:flex;align-items:center;justify-content:center;gap:.75rem;flex-wrap:wrap;">
                                        <button wire:click="resetFilters" class="btn-ghost">
                                            Reset Filters
                                        </button>
                                        <a href="{{ route('users.create') }}" wire:navigate class="btn-gold">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                                            </svg>
                                            Add User
                                        </a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="px-5 py-4" style="border-top:1px solid #f1f5f9; background:#fafbff;">
            {{ $users->links() }}
        </div>
    </section>

</div>

{{-- ════════════════════════════════════════════════════════════════ --}}
{{-- VIEW MODAL                                                        --}}
{{-- ════════════════════════════════════════════════════════════════ --}}
@if ($showViewModal && $selectedUser)
    @php
        $su        = $selectedUser;
        $suAlumni  = $su->alumni;
        $suName    = $suAlumni ? trim($suAlumni->fname . ' ' . $suAlumni->lname) : $su->username;
        $suRole    = $su->getRoleNames()->first() ?? 'user';
        $suIsRep   = $suAlumni?->educations?->contains(fn($e) => $e->is_batch_rep) ?? false;
        $suEduList = $suAlumni?->educations?->sortBy(fn($e) => match($e->batch?->level) {
            'elementary' => 1, 'highschool' => 2, 'college' => 3, default => 99,
        }) ?? collect();
        $suInitials = strtoupper(
            $suAlumni
                ? substr($suAlumni->fname ?? 'U', 0, 1) . substr($suAlumni->lname ?? '', 0, 1)
                : substr($su->username ?? 'U', 0, 2)
        );
        $suRoleClass = match($suRole) {
            'alumni'               => 'role-alumni',
            'batch-representative' => 'role-batch-rep',
            'reunion-coordinator'  => 'role-coordinator',
            'ssps'                 => 'role-ssps',
            default                => 'role-default',
        };
    @endphp

    <div class="mu-modal-overlay" wire:click.self="closeViewModal">
        <div class="mu-modal">

            {{-- Modal header --}}
            <div style="background:linear-gradient(135deg,var(--r8) 0%,var(--r6) 100%);
                        padding:1.25rem 1.5rem; flex-shrink:0;">
                <div class="flex items-start justify-between gap-4">
                    <div class="flex items-center gap-4">
                        {{-- Large avatar --}}
                        <div style="width:3.25rem;height:3.25rem;border-radius:.875rem;
                                    display:flex;align-items:center;justify-content:center;
                                    font-size:1.1rem;font-weight:800;color:#fff;flex-shrink:0;
                                    background:rgba(255,255,255,.18);border:2px solid rgba(255,255,255,.3);
                                    letter-spacing:.05em;">
                            {{ $suInitials }}
                        </div>
                        <div>
                            <p class="text-[.62rem] font-bold uppercase tracking-[.2em]"
                               style="color:var(--g4);">User Profile Overview</p>
                            <h3 class="mt-0.5 text-xl font-bold text-white tracking-tight"
                                style="font-family:Georgia,serif;">
                                {{ $suName }}
                            </h3>
                            <div class="flex items-center gap-2 mt-1.5">
                                <span class="status-chip {{ $suRoleClass }}" style="font-size:.62rem;">
                                    {{ str($suRole)->headline() }}
                                </span>
                                @if ($suIsRep)
                                    <span class="status-chip chip-amber" style="font-size:.62rem;">
                                        <span class="status-dot" style="background:#c4952a;"></span>
                                        Batch Rep
                                    </span>
                                @endif
                                <span class="status-chip {{ $suAlumni ? 'chip-green' : 'chip-red' }}" style="font-size:.62rem;">
                                    <span class="status-dot" style="background:{{ $suAlumni ? '#10b981' : '#ef4444' }};"></span>
                                    {{ $suAlumni ? 'Profile Linked' : 'No Alumni Profile' }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center gap-2 shrink-0">
                        <button wire:click="edit({{ $su->id }})" class="btn-gold" style="height:2.1rem;font-size:.75rem;">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Z"/>
                            </svg>
                            Edit
                        </button>
                        <button wire:click="closeViewModal" class="btn-ghost" style="height:2.1rem;font-size:.75rem;background:rgba(255,255,255,.1);border-color:rgba(255,255,255,.2);color:#fff;">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/>
                            </svg>
                            Close
                        </button>
                    </div>
                </div>
            </div>

            {{-- Modal body --}}
            <div style="overflow-y:auto; flex:1; padding:1.5rem; background:#f8fafc;">

                {{-- Account info strip --}}
                <div class="grid gap-3 sm:grid-cols-2 xl:grid-cols-4 mb-5">
                    @foreach ([
                        ['Username',        $su->username],
                        ['Email',           $su->email ?: 'N/A'],
                        ['Role',            str($suRole)->headline()],
                        ['User ID',         '#' . $su->id],
                    ] as [$lbl, $val])
                        <div style="background:#fff;border:1px solid #e2e8f0;border-radius:.875rem;padding:.875rem 1rem;">
                            <p class="detail-label">{{ $lbl }}</p>
                            <p class="detail-val">{{ $val }}</p>
                        </div>
                    @endforeach
                </div>

                @if ($suAlumni)
                    <div class="grid gap-4 xl:grid-cols-2">

                        {{-- Personal Info --}}
                        <div style="background:#fff;border:1px solid #e2e8f0;border-radius:1rem;padding:1.25rem;">
                            <p class="text-[.62rem] font-bold uppercase tracking-[.14em] mb-3"
                               style="color:var(--r6);">Personal Information</p>
                            <div class="grid gap-3.5 sm:grid-cols-2">
                                @foreach ([
                                    ['Prefix',     $suAlumni->prefix],
                                    ['Suffix',     $suAlumni->suffix],
                                    ['First Name', $suAlumni->fname],
                                    ['Middle Name',$suAlumni->mname],
                                    ['Last Name',  $suAlumni->lname],
                                    ['Cellphone',  $suAlumni->cellphone],
                                ] as [$lbl, $val])
                                    <div>
                                        <p class="detail-label">{{ $lbl }}</p>
                                        <p class="detail-val">{{ $val ?: '-' }}</p>
                                    </div>
                                @endforeach
                                <div class="sm:col-span-2">
                                    <p class="detail-label">Occupation</p>
                                    <p class="detail-val">{{ $suAlumni->occupation ?: '-' }}</p>
                                </div>
                            </div>
                        </div>

                        {{-- Address Info --}}
                        <div style="background:#fff;border:1px solid #e2e8f0;border-radius:1rem;padding:1.25rem;">
                            <p class="text-[.62rem] font-bold uppercase tracking-[.14em] mb-3"
                               style="color:var(--r6);">Address</p>
                            <div class="grid gap-3.5 sm:grid-cols-2">
                                <div class="sm:col-span-2">
                                    <p class="detail-label">Street Address</p>
                                    <p class="detail-val">{{ $suAlumni->address_line_1 ?: '-' }}</p>
                                </div>
                                @if ($suAlumni->address_line_2)
                                    <div class="sm:col-span-2">
                                        <p class="detail-label">Address Line 2</p>
                                        <p class="detail-val">{{ $suAlumni->address_line_2 }}</p>
                                    </div>
                                @endif
                                @foreach ([
                                    ['City',        $suAlumni->city],
                                    ['Province',    $suAlumni->state_province],
                                    ['Postal Code', $suAlumni->postal_code],
                                    ['Country',     $suAlumni->country],
                                ] as [$lbl, $val])
                                    <div>
                                        <p class="detail-label">{{ $lbl }}</p>
                                        <p class="detail-val">{{ $val ?: '-' }}</p>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                    </div>

                    {{-- Education Records --}}
                    @if ($suEduList->isNotEmpty())
                        <div class="mt-4"
                             style="background:#fff;border:1px solid #e2e8f0;border-radius:1rem;padding:1.25rem;">
                            <p class="text-[.62rem] font-bold uppercase tracking-[.14em] mb-4"
                               style="color:var(--r6);">Educational Background</p>

                            <div class="space-y-3">
                                @foreach ($suEduList as $edu)
                                    @php
                                        $eduLevelTag = match($edu->batch?->level) {
                                            'elementary' => 'elem', 'highschool' => 'hs', 'college' => 'col', default => '',
                                        };
                                    @endphp
                                    <div style="background:#f8fafc;border:1px solid #e2e8f0;border-radius:.75rem;padding:1rem;">
                                        <div class="flex flex-wrap items-center gap-2 mb-3">
                                            <span class="edu-tag {{ $eduLevelTag }}"
                                                  style="font-size:.7rem;padding:.2rem .7rem;">
                                                {{ str($edu->batch?->level ?? 'n/a')->headline() }}
                                            </span>
                                            @if ($edu->is_batch_rep)
                                                <span class="status-chip chip-amber" style="font-size:.65rem;">
                                                    <span class="status-dot" style="background:#c4952a;"></span>
                                                    Batch Representative
                                                </span>
                                            @endif
                                            <span class="status-chip {{ $edu->did_graduate ? 'chip-green' : 'chip-amber' }}"
                                                  style="font-size:.65rem;">
                                                {{ $edu->did_graduate ? 'Graduated' : 'Attended (No Grad)' }}
                                            </span>
                                            @if ($su->hasAnyRole(['alumni', 'batch-representative']))
                                                <button wire:click="toggleBatchRep({{ $edu->id }})"
                                                        wire:confirm="{{ $edu->is_batch_rep ? 'Remove batch representative status for this level?' : 'Assign batch representative status for this level?' }}"
                                                        style="margin-left:auto;display:inline-flex;align-items:center;gap:.3rem;
                                                               height:1.7rem;padding:0 .65rem;border-radius:.5rem;font-size:.65rem;font-weight:700;
                                                               cursor:pointer;border:1px solid;white-space:nowrap;transition:background .12s;
                                                               {{ $edu->is_batch_rep
                                                                   ? 'background:#fff7ed;color:#9a3412;border-color:#fdba74;'
                                                                   : 'background:#eef2ff;color:#1a3fa8;border-color:#c7d2fe;' }}">
                                                    @if ($edu->is_batch_rep)
                                                        <svg style="width:.7rem;height:.7rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/>
                                                        </svg>
                                                        Remove Rep
                                                    @else
                                                        <svg style="width:.7rem;height:.7rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                                                        </svg>
                                                        Set as Rep
                                                    @endif
                                                </button>
                                            @endif
                                        </div>
                                        <div class="grid gap-3 sm:grid-cols-4">
                                            @foreach ([
                                                ['School Year',      $edu->batch?->schoolyear],
                                                ['Year Graduated',   $edu->batch?->yeargrad],
                                                ['Year Attended',    $edu->school_year_attended],
                                                ['Batch ID',         $edu->batch_id ? '#' . $edu->batch_id : null],
                                            ] as [$lbl, $val])
                                                <div>
                                                    <p class="detail-label">{{ $lbl }}</p>
                                                    <p class="detail-val">{{ $val ?: '-' }}</p>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                @else
                    {{-- No alumni profile state --}}
                    <div class="mt-4" style="border:1px dashed #e2e8f0;border-radius:1rem;
                                             background:#fff;padding:2.5rem;text-align:center;">
                        <div style="width:3rem;height:3rem;border-radius:.875rem;
                                    background:#f0f4fb;border:1px solid #e2e8f0;
                                    display:flex;align-items:center;justify-content:center;margin:0 auto 1rem;">
                            <svg style="width:1.25rem;height:1.25rem;color:#94a3b8;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z"/>
                            </svg>
                        </div>
                        <p style="font-size:.8125rem;color:#64748b;font-weight:600;">
                            This user does not have an alumni profile linked yet.
                        </p>
                        <p style="font-size:.75rem;color:#94a3b8;margin-top:.35rem;">
                            Use the Edit Account action to link or create a profile.
                        </p>
                    </div>
                @endif

            </div>
        </div>
    </div>
@endif

{{-- ════════════════════════════════════════════════════════════════ --}}
{{-- TOGGLE ACTIVE CONFIRMATION MODAL                                  --}}
{{-- ════════════════════════════════════════════════════════════════ --}}
@if ($showToggleModal && $confirmToggleId)
    @php
        $toggleTarget = $users->getCollection()->firstWhere('id', $confirmToggleId)
            ?? \App\Models\User::find($confirmToggleId);
        $isDeactivating = $toggleTarget?->is_active ?? true;
    @endphp

    <div class="mu-modal-overlay" wire:click.self="cancelToggle">
        <div style="width:100%;max-width:26rem;background:#fff;border-radius:1.25rem;overflow:hidden;
                    box-shadow:0 32px 80px rgba(10,31,92,.3),0 0 0 1px {{ $isDeactivating ? 'rgba(196,149,42,.18)' : 'rgba(16,185,129,.18)' }};">

            {{-- Header --}}
            <div style="background:{{ $isDeactivating
                ? 'linear-gradient(135deg,#92700a 0%,#c4952a 100%)'
                : 'linear-gradient(135deg,#065f46 0%,#059669 100%)' }};padding:1.25rem 1.5rem;">
                <div class="flex items-center gap-3">
                    <div style="width:2.25rem;height:2.25rem;border-radius:.6rem;background:rgba(255,255,255,.15);
                                border:1px solid rgba(255,255,255,.25);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                        @if ($isDeactivating)
                            <svg class="w-4 h-4" style="color:#fff;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 0 0 5.636 5.636m12.728 12.728A9 9 0 0 1 5.636 5.636m12.728 12.728L5.636 5.636"/>
                            </svg>
                        @else
                            <svg class="w-4 h-4" style="color:#fff;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                            </svg>
                        @endif
                    </div>
                    <div>
                        <p class="text-[.62rem] font-bold uppercase tracking-[.2em]" style="color:rgba(255,255,255,.65);">
                            Account Status
                        </p>
                        <h3 class="mt-0.5 text-base font-bold text-white">
                            {{ $isDeactivating ? 'Deactivate Account' : 'Activate Account' }}
                        </h3>
                    </div>
                </div>
            </div>

            {{-- Body --}}
            <div style="padding:1.4rem 1.5rem;">
                <p class="text-sm" style="color:#374151;line-height:1.65;">
                    @if ($toggleTarget)
                        You are about to
                        <strong style="color:{{ $isDeactivating ? '#92700a' : '#065f46' }};">
                            {{ $isDeactivating ? 'deactivate' : 'activate' }}
                        </strong>
                        the account for
                        <strong style="color:#111827;">{{ $toggleTarget->username }}</strong>.
                    @else
                        You are about to {{ $isDeactivating ? 'deactivate' : 'activate' }} this account.
                    @endif
                </p>

                <div class="mt-3 rounded-xl px-3.5 py-3"
                     style="background:{{ $isDeactivating ? '#fffbeb' : '#ecfdf5' }};
                            border:1px solid {{ $isDeactivating ? '#fde68a' : '#a7f3d0' }};">
                    <p class="text-xs font-semibold"
                       style="color:{{ $isDeactivating ? '#92700a' : '#065f46' }};">
                        @if ($isDeactivating)
                            This user will be immediately logged out and blocked from signing in.
                        @else
                            This user will be able to log in and access the platform again.
                        @endif
                    </p>
                </div>

                <div class="mt-4 flex justify-end gap-2.5">
                    <button wire:click="cancelToggle" class="btn-ghost">
                        Cancel
                    </button>
                    <button wire:click="toggleActive({{ $confirmToggleId }})"
                            wire:loading.attr="disabled"
                            style="display:inline-flex;align-items:center;gap:.4rem;height:2.375rem;padding:0 1.1rem;
                                   border-radius:.75rem;
                                   background:{{ $isDeactivating
                                       ? 'linear-gradient(135deg,#c4952a 0%,#92700a 100%)'
                                       : 'linear-gradient(135deg,#059669 0%,#065f46 100%)' }};
                                   box-shadow:{{ $isDeactivating
                                       ? '0 4px 14px rgba(196,149,42,.35)'
                                       : '0 4px 14px rgba(5,150,105,.3)' }};
                                   color:#fff;font-size:.8rem;font-weight:700;border:none;cursor:pointer;
                                   transition:filter .15s;"
                            onmouseover="this.style.filter='brightness(1.1)'"
                            onmouseout="this.style.filter='none'">
                        <svg wire:loading.remove class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            @if ($isDeactivating)
                                <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 0 0 5.636 5.636m12.728 12.728A9 9 0 0 1 5.636 5.636m12.728 12.728L5.636 5.636"/>
                            @else
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                            @endif
                        </svg>
                        <svg wire:loading class="w-3.5 h-3.5 animate-spin" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>
                        </svg>
                        {{ $isDeactivating ? 'Yes, Deactivate' : 'Yes, Activate' }}
                    </button>
                </div>
            </div>

        </div>
    </div>
@endif

{{-- ════════════════════════════════════════════════════════════════ --}}
{{-- DELETE CONFIRMATION MODAL                                         --}}
{{-- ════════════════════════════════════════════════════════════════ --}}
@if ($showDeleteModal && $confirmDeleteId)
    @php $deleteTarget = $users->getCollection()->firstWhere('id', $confirmDeleteId)
        ?? \App\Models\User::with('alumni')->find($confirmDeleteId); @endphp

    <div class="mu-modal-overlay" wire:click.self="cancelDelete">
        <div style="width:100%;max-width:26rem;background:#fff;border-radius:1.25rem;overflow:hidden;
                    box-shadow:0 32px 80px rgba(10,31,92,.3),0 0 0 1px rgba(220,38,38,.12);">

            {{-- Modal header --}}
            <div style="background:linear-gradient(135deg,#991b1b 0%,#dc2626 100%);padding:1.25rem 1.5rem;">
                <div class="flex items-center gap-3">
                    <div style="width:2.25rem;height:2.25rem;border-radius:.6rem;background:rgba(255,255,255,.15);
                                border:1px solid rgba(255,255,255,.25);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                        <svg class="w-4 h-4" style="color:#fff;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-[.62rem] font-bold uppercase tracking-[.2em]" style="color:rgba(255,255,255,.65);">Destructive Action</p>
                        <h3 class="mt-0.5 text-base font-bold text-white">Delete User Account</h3>
                    </div>
                </div>
            </div>

            {{-- Modal body --}}
            <div style="padding:1.4rem 1.5rem;">
                <p class="text-sm" style="color:#374151;line-height:1.65;">
                    You are about to permanently delete
                    @if ($deleteTarget)
                        <strong style="color:#111827;">
                            {{ $deleteTarget->alumni ? trim($deleteTarget->alumni->fname . ' ' . $deleteTarget->alumni->lname) : $deleteTarget->username }}
                        </strong>
                        ({{ $deleteTarget->username }}).
                    @else
                        this user account.
                    @endif
                </p>

                <div class="mt-3 rounded-xl px-3.5 py-3" style="background:#fef2f2;border:1px solid #fecaca;">
                    <p class="text-xs font-semibold" style="color:#991b1b;">This will also delete the linked alumni profile. This action cannot be undone.</p>
                </div>

                <div class="mt-4 flex justify-end gap-2.5">
                    <button wire:click="cancelDelete" class="btn-ghost">
                        Cancel
                    </button>
                    <button wire:click="deleteUser"
                            style="display:inline-flex;align-items:center;gap:.4rem;height:2.375rem;padding:0 1.1rem;
                                   border-radius:.75rem;background:linear-gradient(135deg,#dc2626 0%,#991b1b 100%);
                                   box-shadow:0 4px 14px rgba(220,38,38,.3);
                                   color:#fff;font-size:.8rem;font-weight:700;border:none;cursor:pointer;
                                   transition:filter .15s;"
                            onmouseover="this.style.filter='brightness(1.1)'"
                            onmouseout="this.style.filter='none'">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"/>
                        </svg>
                        Yes, Delete
                    </button>
                </div>
            </div>

        </div>
    </div>
@endif

{{-- ════════════════════════════════════════════════════════════════ --}}
{{-- RESET PASSWORD MODAL                                             --}}
{{-- ════════════════════════════════════════════════════════════════ --}}
@if ($showResetModal && $confirmResetId)
    @php $resetTarget = $users->getCollection()->firstWhere('id', $confirmResetId) ?? \App\Models\User::find($confirmResetId); @endphp
    <div class="mu-modal-overlay" wire:click.self="cancelReset">
        <div style="width:100%;max-width:26rem;background:#fff;border-radius:1.25rem;overflow:hidden;
                    box-shadow:0 32px 80px rgba(10,31,92,.3),0 0 0 1px rgba(99,102,241,.18);">

            <div style="background:linear-gradient(135deg,#4338ca 0%,#6366f1 100%);padding:1.25rem 1.5rem;">
                <div class="flex items-center gap-3">
                    <div style="width:2.25rem;height:2.25rem;border-radius:.6rem;background:rgba(255,255,255,.15);
                                border:1px solid rgba(255,255,255,.25);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                        <svg class="w-4 h-4" style="color:#fff;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 5.25a3 3 0 0 1 3 3m3 0a6 6 0 0 1-7.029 5.912c-.563-.097-1.159.026-1.563.43L10.5 17.25H8.25v2.25H6v2.25H2.25v-2.818c0-.597.237-1.17.659-1.591l6.499-6.499c.404-.404.527-1 .43-1.563A6 6 0 0 1 21.75 8.25Z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-[.62rem] font-bold uppercase tracking-[.2em]" style="color:rgba(255,255,255,.65);">Account Security</p>
                        <h3 class="mt-0.5 text-base font-bold text-white">Reset Password</h3>
                    </div>
                </div>
            </div>

            <div style="padding:1.4rem 1.5rem;">
                <p class="text-sm" style="color:#374151;line-height:1.65;">
                    Choose how to reset the password for
                    <strong style="color:#111827;">{{ $resetTarget?->username }}</strong>.
                </p>

                <div class="mt-4 flex flex-col gap-3">
                    {{-- Email option --}}
                    <button wire:click="sendResetEmail"
                            style="display:flex;align-items:flex-start;gap:.85rem;padding:1rem 1.1rem;border-radius:.9rem;
                                   border:1.5px solid #c7d2fe;background:#eef2ff;text-align:left;cursor:pointer;
                                   transition:border-color .15s,background .15s;"
                            onmouseover="this.style.borderColor='#6366f1';this.style.background='#e0e7ff'"
                            onmouseout="this.style.borderColor='#c7d2fe';this.style.background='#eef2ff'">
                        <div style="width:2rem;height:2rem;border-radius:.5rem;background:#6366f1;display:flex;align-items:center;justify-content:center;flex-shrink:0;margin-top:.05rem;">
                            <svg class="w-3.5 h-3.5" style="color:#fff;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-bold" style="color:#3730a3;">Send Reset Link via Email</p>
                            <p class="text-xs mt-0.5" style="color:#6366f1;">
                                Sends a secure reset link to
                                <span style="font-weight:600;">{{ $resetTarget?->email ?: 'no email on file' }}</span>
                            </p>
                        </div>
                    </button>

                    {{-- Manual option --}}
                    <button wire:click="resetPasswordManual"
                            style="display:flex;align-items:flex-start;gap:.85rem;padding:1rem 1.1rem;border-radius:.9rem;
                                   border:1.5px solid #fde68a;background:#fffbeb;text-align:left;cursor:pointer;
                                   transition:border-color .15s,background .15s;"
                            onmouseover="this.style.borderColor='#f59e0b';this.style.background='#fef3c7'"
                            onmouseout="this.style.borderColor='#fde68a';this.style.background='#fffbeb'">
                        <div style="width:2rem;height:2rem;border-radius:.5rem;background:#d97706;display:flex;align-items:center;justify-content:center;flex-shrink:0;margin-top:.05rem;">
                            <svg class="w-3.5 h-3.5" style="color:#fff;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.325.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 0 1 1.37.49l1.296 2.247a1.125 1.125 0 0 1-.26 1.431l-1.003.827c-.293.241-.438.613-.43.992a7.723 7.723 0 0 1 0 .255c-.008.378.137.75.43.991l1.004.827c.424.35.534.955.26 1.43l-1.298 2.247a1.125 1.125 0 0 1-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.47 6.47 0 0 1-.22.128c-.331.183-.581.495-.644.869l-.213 1.281c-.09.543-.56.94-1.11.94h-2.594c-.55 0-1.019-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 0 1-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 0 1-1.369-.49l-1.297-2.247a1.125 1.125 0 0 1 .26-1.431l1.004-.827c.292-.24.437-.613.43-.991a6.932 6.932 0 0 1 0-.255c.007-.38-.138-.751-.43-.992l-1.004-.827a1.125 1.125 0 0 1-.26-1.43l1.297-2.247a1.125 1.125 0 0 1 1.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.086.22-.128.332-.183.582-.495.644-.869l.214-1.28Z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-bold" style="color:#92400e;">Generate Temporary Password</p>
                            <p class="text-xs mt-0.5" style="color:#b45309;">System generates a one-time password. User must change it on next login.</p>
                        </div>
                    </button>
                </div>

                <div class="mt-4 flex justify-end">
                    <button wire:click="cancelReset" class="btn-ghost">Cancel</button>
                </div>
            </div>
        </div>
    </div>
@endif

{{-- ════════════════════════════════════════════════════════════════ --}}
{{-- TEMP PASSWORD RESULT MODAL                                        --}}
{{-- ════════════════════════════════════════════════════════════════ --}}
@if ($showTempPasswordModal && $generatedTempPassword)
    <div class="mu-modal-overlay">
        <div style="width:100%;max-width:24rem;background:#fff;border-radius:1.25rem;overflow:hidden;
                    box-shadow:0 32px 80px rgba(10,31,92,.3),0 0 0 1px rgba(217,119,6,.2);">

            <div style="background:linear-gradient(135deg,#92400e 0%,#d97706 100%);padding:1.25rem 1.5rem;">
                <div class="flex items-center gap-3">
                    <div style="width:2.25rem;height:2.25rem;border-radius:.6rem;background:rgba(255,255,255,.15);
                                border:1px solid rgba(255,255,255,.25);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                        <svg class="w-4 h-4" style="color:#fff;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-[.62rem] font-bold uppercase tracking-[.2em]" style="color:rgba(255,255,255,.65);">Temporary Password</p>
                        <h3 class="mt-0.5 text-base font-bold text-white">Password Reset Successful</h3>
                    </div>
                </div>
            </div>

            <div style="padding:1.4rem 1.5rem;">
                <p class="text-sm" style="color:#374151;line-height:1.65;">
                    Share this temporary password with the user. They will be required to change it upon next login.
                </p>

                <div class="mt-4 rounded-xl px-4 py-3.5" style="background:#fffbeb;border:1.5px solid #fde68a;">
                    <p class="text-[.65rem] font-bold uppercase tracking-widest mb-1.5" style="color:#92400e;">Temporary Password</p>
                    <div class="flex items-center gap-2">
                        <code id="temp-pw-code" class="flex-1 text-lg font-mono font-bold tracking-widest" style="color:#1e293b;letter-spacing:.15em;">
                            {{ $generatedTempPassword }}
                        </code>
                        <button onclick="navigator.clipboard.writeText('{{ $generatedTempPassword }}').then(()=>{this.innerText='Copied!';setTimeout(()=>this.innerText='Copy',1500)})"
                                style="padding:.35rem .75rem;border-radius:.5rem;background:#6366f1;color:#fff;
                                       font-size:.72rem;font-weight:700;border:none;cursor:pointer;">
                            Copy
                        </button>
                    </div>
                </div>

                <div class="mt-3 rounded-xl px-3.5 py-3" style="background:#fef2f2;border:1px solid #fecaca;">
                    <p class="text-xs font-semibold" style="color:#991b1b;">This password will not be shown again. Copy it now before closing.</p>
                </div>

                <div class="mt-4 flex justify-end">
                    <button wire:click="closeTempPasswordModal"
                            style="display:inline-flex;align-items:center;gap:.4rem;height:2.375rem;padding:0 1.25rem;
                                   border-radius:.75rem;background:linear-gradient(135deg,#4338ca 0%,#6366f1 100%);
                                   color:#fff;font-size:.8rem;font-weight:700;border:none;cursor:pointer;">
                        Done
                    </button>
                </div>
            </div>
        </div>
    </div>
@endif

</div>
