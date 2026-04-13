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
                            $fullName     = $user->alumni ? trim($user->alumni->fname . ' ' . $user->alumni->lname) : null;
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
                                                    default => '—',
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
                                    <span class="text-xs text-slate-400">—</span>
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

                                    <button wire:click="edit({{ $user->id }})"
                                            class="btn-action btn-action-edit">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125"/>
                                        </svg>
                                        Edit
                                    </button>
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
                                        <p class="detail-val">{{ $val ?: '—' }}</p>
                                    </div>
                                @endforeach
                                <div class="sm:col-span-2">
                                    <p class="detail-label">Occupation</p>
                                    <p class="detail-val">{{ $suAlumni->occupation ?: '—' }}</p>
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
                                    <p class="detail-val">{{ $suAlumni->address_line_1 ?: '—' }}</p>
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
                                        <p class="detail-val">{{ $val ?: '—' }}</p>
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
                                                  style="font-size:.65rem;margin-left:auto;">
                                                {{ $edu->did_graduate ? 'Graduated' : 'Attended (No Grad)' }}
                                            </span>
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
                                                    <p class="detail-val">{{ $val ?: '—' }}</p>
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

</div>
