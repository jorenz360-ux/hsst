<div class="min-h-screen" style="background:#f0f4fb; font-family:'DM Sans',system-ui,sans-serif;">

<style>
    :root {
        --r9: #0a1f5c; --r8: #0f2a7a; --r7: #153591; --r6: #1a3fa8; --r5: #2150c8;
        --g5: #c4952a; --g4: #d4a843;
    }

    /* Inputs */
    .pr-field {
        height: 2.5rem; border-radius: .75rem;
        border: 1px solid #e2e8f0; background: #fff;
        padding: 0 .875rem; font-size: .8125rem; color: #0f172a;
        outline: none; transition: border-color .15s, box-shadow .15s; width: 100%;
    }
    .pr-field::placeholder { color: #94a3b8; }
    .pr-field:hover  { border-color: #94a3b8; }
    .pr-field:focus  { border-color: var(--r6); box-shadow: 0 0 0 3px rgba(26,63,168,.1); }
    .pr-field-icon   { padding-left: 2.4rem; }

    .pr-select {
        height: 2.5rem; border-radius: .75rem;
        border: 1px solid #e2e8f0;
        background: #fff url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%2394a3b8' stroke-width='2'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' d='M19 9l-7 7-7-7'/%3E%3C/svg%3E") no-repeat right .75rem center / .9rem;
        padding: 0 2.2rem 0 .875rem; font-size: .8125rem; color: #0f172a;
        outline: none; appearance: none;
        transition: border-color .15s, box-shadow .15s; width: 100%; cursor: pointer;
    }
    .pr-select:hover { border-color: #94a3b8; }
    .pr-select:focus { border-color: var(--r6); box-shadow: 0 0 0 3px rgba(26,63,168,.1); }

    .pr-label {
        display: block; font-size: .65rem; font-weight: 700;
        letter-spacing: .1em; text-transform: uppercase; color: #64748b; margin-bottom: .35rem;
    }

    /* Buttons */
    .btn-primary {
        display: inline-flex; align-items: center; gap: .4rem;
        height: 2.25rem; padding: 0 .9rem; border-radius: .7rem;
        background: linear-gradient(135deg,var(--r6) 0%,var(--r8) 100%);
        box-shadow: 0 3px 12px rgba(21,53,145,.28), inset 0 1px 0 rgba(255,255,255,.1);
        color: #fff; font-size: .75rem; font-weight: 700;
        transition: filter .15s, transform .1s; cursor: pointer; border: none; white-space: nowrap;
    }
    .btn-primary:hover  { filter: brightness(1.08); }
    .btn-primary:active { transform: translateY(1px); }

    .btn-gold {
        display: inline-flex; align-items: center; gap: .4rem;
        height: 2.25rem; padding: 0 .9rem; border-radius: .7rem;
        background: linear-gradient(135deg,var(--g5) 0%,#a37522 100%);
        box-shadow: 0 3px 12px rgba(196,149,42,.28), inset 0 1px 0 rgba(255,255,255,.12);
        color: #fff; font-size: .75rem; font-weight: 700;
        transition: filter .15s, transform .1s; cursor: pointer; border: none; white-space: nowrap;
    }
    .btn-gold:hover  { filter: brightness(1.07); }
    .btn-gold:active { transform: translateY(1px); }

    .btn-ghost {
        display: inline-flex; align-items: center; gap: .4rem;
        height: 2.25rem; padding: 0 .875rem; border-radius: .7rem;
        background: #fff; border: 1px solid #e2e8f0; color: #475569;
        font-size: .75rem; font-weight: 600;
        transition: background .12s, border-color .12s; cursor: pointer; white-space: nowrap;
    }
    .btn-ghost:hover { background: #f8fafc; border-color: #cbd5e1; }

    .btn-danger {
        display: inline-flex; align-items: center; gap: .4rem;
        height: 2.25rem; padding: 0 .875rem; border-radius: .7rem;
        background: #fef2f2; border: 1px solid #fecaca; color: #991b1b;
        font-size: .75rem; font-weight: 600;
        transition: background .12s, border-color .12s; cursor: pointer; white-space: nowrap;
    }
    .btn-danger:hover { background: #fee2e2; border-color: #fca5a5; }

    .btn-processing {
        display: inline-flex; align-items: center; gap: .4rem;
        height: 2.25rem; padding: 0 .875rem; border-radius: .7rem;
        background: #eff6ff; border: 1px solid #bfdbfe; color: #1e40af;
        font-size: .75rem; font-weight: 600;
        transition: background .12s; cursor: pointer; white-space: nowrap;
    }
    .btn-processing:hover { background: #dbeafe; }

    /* Status chip */
    .status-chip {
        display: inline-flex; align-items: center; gap: .3rem;
        padding: .22rem .65rem; border-radius: 999px;
        font-size: .67rem; font-weight: 700; letter-spacing: .04em; white-space: nowrap;
    }
    .status-dot { width: .42rem; height: .42rem; border-radius: 50%; flex-shrink: 0; }

    .chip-pending    { background:#fffbeb; color:#92700a;  border:1px solid #fde68a; }
    .chip-processing { background:#eff6ff; color:#1e40af;  border:1px solid #bfdbfe; }
    .chip-resolved   { background:#ecfdf5; color:#065f46;  border:1px solid #a7f3d0; }
    .chip-rejected   { background:#fef2f2; color:#991b1b;  border:1px solid #fecaca; }
    .chip-default    { background:#f1f5f9; color:#475569;  border:1px solid #e2e8f0; }
    .chip-blue       { background:#eef2ff; color:#1a3fa8;  border:1px solid #c7d2fe; }

    /* Avatar */
    .pr-avatar {
        width: 2.1rem; height: 2.1rem; border-radius: .55rem;
        display: flex; align-items: center; justify-content: center;
        font-size: .7rem; font-weight: 800; color: #fff; flex-shrink: 0;
        letter-spacing: .04em;
    }
    .pr-avatar-pending    { background: linear-gradient(135deg,#d97706,#92400e); }
    .pr-avatar-processing { background: linear-gradient(135deg,var(--r6),var(--r8)); }
    .pr-avatar-resolved   { background: linear-gradient(135deg,#059669,#065f46); }
    .pr-avatar-rejected   { background: linear-gradient(135deg,#dc2626,#991b1b); }
    .pr-avatar-default    { background: linear-gradient(135deg,#64748b,#334155); }

    /* Table */
    .pr-table thead th {
        font-size: .61rem; font-weight: 700; letter-spacing: .14em;
        text-transform: uppercase; color: #64748b;
        padding: .7rem 1rem; text-align: left; white-space: nowrap;
    }
    .pr-table thead th:last-child { text-align: right; }
    .pr-table tbody tr {
        transition: background .12s; border-bottom: 1px solid #f1f5f9;
    }
    .pr-table tbody tr:last-child { border-bottom: none; }
    .pr-table tbody tr:hover { background: #f8faff; }
    .pr-table td { padding: .9rem 1rem; vertical-align: middle; }
    .pr-table td:last-child { text-align: right; }

    /* Summary chip in header */
    .sum-chip {
        display: inline-flex; align-items: center; gap: .45rem;
        padding: .3rem .8rem; border-radius: 999px;
        font-size: .68rem; font-weight: 700; white-space: nowrap;
    }

    /* Notes pill */
    .notes-pill {
        display: block; font-size: .7rem; color: #475569;
        background: #f8fafc; border: 1px solid #e2e8f0;
        border-radius: .6rem; padding: .45rem .7rem;
        max-width: 220px; margin-top: .5rem;
        line-height: 1.5;
    }

    /* Temp password alert */
    .temp-pw-alert {
        border-radius: 1rem;
        background: linear-gradient(135deg,#ecfdf5,#d1fae5);
        border: 1px solid #6ee7b7;
        padding: 1rem 1.25rem;
        display: flex; align-items: flex-start; gap: .875rem;
    }
    .temp-pw-badge {
        font-family: 'Courier New', monospace;
        font-size: .9rem; font-weight: 800; letter-spacing: .08em;
        background: #065f46; color: #fff;
        padding: .3rem .85rem; border-radius: .5rem;
        user-select: all; cursor: text;
    }
</style>

<div class="space-y-5 px-4 py-6 sm:px-6 lg:px-8 mx-auto max-w-screen-xl">

    {{-- ════════════════════════════════════════════════════════
         CONTROL HEADER
    ════════════════════════════════════════════════════════ --}}
    <section class="overflow-hidden rounded-2xl"
             style="background:linear-gradient(155deg,var(--r8) 0%,var(--r7) 45%,var(--r6) 100%);
                    box-shadow:0 8px 32px rgba(10,31,92,.28);">
        <div class="relative px-6 py-6 sm:px-8">
            <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
                <div>
                    <p class="text-[.65rem] font-bold uppercase tracking-[.22em]"
                       style="color:var(--g4);">
                        HSST Alumni Portal &middot; Admin Control
                    </p>
                    <h1 class="mt-2 text-2xl font-bold tracking-tight text-white sm:text-3xl"
                        style="font-family:Georgia,serif;letter-spacing:-.01em;">
                        Password Reset Requests
                    </h1>
                    <p class="mt-1.5 text-sm leading-6" style="color:rgba(255,255,255,.6);max-width:48ch;">
                        Review, process, and resolve password reset requests submitted
                        by alumni and registered users.
                    </p>
                </div>

                {{-- Status summary chips --}}
                <div class="flex flex-wrap items-center gap-2 lg:shrink-0 lg:mt-1">
                    <span class="sum-chip" style="background:rgba(255,255,255,.1);color:rgba(255,255,255,.75);border:1px solid rgba(255,255,255,.14);">
                        <span class="status-dot" style="background:rgba(255,255,255,.5);"></span>
                        {{ $requests->total() }} {{ $status === 'all' ? 'total' : $status }}
                    </span>
                </div>
            </div>

            {{-- Filter bar inside header --}}
            <div class="mt-5 pt-5 flex flex-col gap-3 sm:flex-row sm:items-end"
                 style="border-top:1px solid rgba(255,255,255,.12);">

                {{-- Search --}}
                <div class="flex-1 max-w-sm">
                    <label class="pr-label" style="color:rgba(255,255,255,.5);">Search</label>
                    <div class="relative">
                        <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3"
                              style="color:#94a3b8;">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z"/>
                            </svg>
                        </span>
                        <input
                            type="text"
                            wire:model.live.debounce.400ms="search"
                            placeholder="Username, name, or email…"
                            class="pr-field pr-field-icon"
                        >
                    </div>
                </div>

                {{-- Status filter --}}
                <div style="width:180px;">
                    <label class="pr-label" style="color:rgba(255,255,255,.5);">Status</label>
                    <select wire:model.live="status" class="pr-select">
                        <option value="all">All Statuses</option>
                        <option value="pending">Pending</option>
                        <option value="processing">Processing</option>
                        <option value="resolved">Resolved</option>
                        <option value="rejected">Rejected</option>
                    </select>
                </div>

                {{-- Current filter chip --}}
                <div class="flex items-center gap-2 pb-0.5">
                    @php
                        $filterColors = [
                            'all'        => ['rgba(255,255,255,.12)','rgba(255,255,255,.7)'],
                            'pending'    => ['rgba(217,119,6,.25)','#fde68a'],
                            'processing' => ['rgba(37,99,235,.3)','#93c5fd'],
                            'resolved'   => ['rgba(5,150,105,.25)','#6ee7b7'],
                            'rejected'   => ['rgba(220,38,38,.25)','#fca5a5'],
                        ];
                        [$fcBg, $fcText] = $filterColors[$status] ?? $filterColors['all'];
                    @endphp
                    <span class="sum-chip"
                          style="background:{{ $fcBg }};color:{{ $fcText }};border:1px solid {{ $fcText }}33;">
                        <span class="status-dot" style="background:{{ $fcText }};"></span>
                        {{ $status === 'all' ? 'Showing all' : ucfirst($status) . ' only' }}
                    </span>
                </div>
            </div>
        </div>
    </section>

    {{-- ════════════════════════════════════════════════════════
         FLASH / STATUS MESSAGE
    ════════════════════════════════════════════════════════ --}}
    @if (session('status'))
        @php
            $flashMsg = session('status');
            $isTempPw = str_contains($flashMsg, 'Temporary password:');

            if ($isTempPw) {
                preg_match('/Temporary password:\s*(\S+)/i', $flashMsg, $matches);
                $tempPw = $matches[1] ?? '';
                $flashPrefix = Str::before($flashMsg, 'Temporary password:');
            }
        @endphp

        @if ($isTempPw)
            <div class="temp-pw-alert">
                <div class="flex-shrink-0 w-9 h-9 rounded-xl flex items-center justify-center"
                     style="background:#065f46;">
                    <svg class="w-4.5 h-4.5" style="width:1.1rem;height:1.1rem;color:#6ee7b7;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                    </svg>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-bold text-emerald-900">Password Reset Successful</p>
                    <p class="text-xs text-emerald-700 mt-0.5 mb-3">
                        {{ trim($flashPrefix) }} Copy the temporary password below and share it with the user securely.
                        They will be required to change it on next login.
                    </p>
                    <div class="flex flex-wrap items-center gap-3">
                        <span class="temp-pw-badge" id="tempPwDisplay">{{ $tempPw }}</span>
                        <button
                            type="button"
                            onclick="navigator.clipboard.writeText('{{ addslashes($tempPw) }}').then(()=>{ this.textContent='Copied!'; setTimeout(()=>this.textContent='Copy Password',2000); })"
                            class="btn-ghost"
                            style="height:2rem;font-size:.72rem;"
                        >
                            Copy Password
                        </button>
                    </div>
                </div>
            </div>
        @else
            @php
                $isError = str_contains(strtolower($flashMsg), 'not') || str_contains(strtolower($flashMsg), 'already') || str_contains(strtolower($flashMsg), 'invalid');
            @endphp
            <div class="rounded-2xl px-5 py-4 flex items-start gap-3"
                 style="{{ $isError
                    ? 'background:#fef2f2;border:1px solid #fecaca;'
                    : 'background:#ecfdf5;border:1px solid #a7f3d0;' }}">
                <svg class="w-4 h-4 mt-0.5 flex-shrink-0"
                     style="color:{{ $isError ? '#dc2626' : '#059669' }};"
                     fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    @if ($isError)
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z"/>
                    @else
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                    @endif
                </svg>
                <p class="text-sm font-semibold"
                   style="color:{{ $isError ? '#991b1b' : '#065f46' }};">
                    {{ $flashMsg }}
                </p>
            </div>
        @endif
    @endif

    {{-- ════════════════════════════════════════════════════════
         REQUESTS TABLE
    ════════════════════════════════════════════════════════ --}}
    <section class="overflow-hidden rounded-2xl bg-white"
             style="border:1px solid #e2e8f0; box-shadow:0 1px 6px rgba(15,23,42,.05);">

        {{-- Table header --}}
        <div class="flex flex-col gap-2 px-5 py-4 sm:flex-row sm:items-center sm:justify-between"
             style="border-bottom:1px solid #f1f5f9;">
            <div>
                <h2 class="text-base font-bold text-slate-900">Request Queue</h2>
                <p class="mt-0.5 text-xs text-slate-500">
                    {{ $requests->total() }} {{ $requests->total() === 1 ? 'request' : 'requests' }}
                    &bull; {{ $requests->count() }} on this page
                    @if ($status !== 'all') &bull; filtered by <strong>{{ $status }}</strong> @endif
                </p>
            </div>
            @if ($status !== 'all')
                <span class="status-chip chip-{{ $status }}">
                    <span class="status-dot" style="background:{{ match($status) {
                        'pending' => '#d97706', 'processing' => '#2563eb',
                        'resolved' => '#059669', 'rejected' => '#dc2626', default => '#64748b'
                    } }};"></span>
                    {{ ucfirst($status) }}
                </span>
            @endif
        </div>

        {{-- Table --}}
        <div class="overflow-x-auto">
            <table class="pr-table min-w-full">
                <thead style="background:#f8fafc;border-bottom:1px solid #e2e8f0;">
                    <tr>
                        <th>Requester</th>
                        <th>Contact</th>
                        <th>Requested</th>
                        <th>Status</th>
                        <th>Notes</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($requests as $request)
                        @php
                            $initials = strtoupper(
                                substr($request->full_name ?: ($request->username ?: '?'), 0, 1)
                                . (str_contains($request->full_name ?? '', ' ')
                                    ? substr(strrchr($request->full_name, ' '), 1, 1)
                                    : substr($request->username ?? '', 1, 1))
                            );

                            $statusChipClass = match($request->status) {
                                'pending'    => 'chip-pending',
                                'processing' => 'chip-processing',
                                'resolved'   => 'chip-resolved',
                                'rejected'   => 'chip-rejected',
                                default      => 'chip-default',
                            };
                            $statusDotColor = match($request->status) {
                                'pending'    => '#d97706',
                                'processing' => '#2563eb',
                                'resolved'   => '#059669',
                                'rejected'   => '#dc2626',
                                default      => '#64748b',
                            };
                            $avatarClass = 'pr-avatar pr-avatar-' . ($request->status ?? 'default');
                        @endphp

                        <tr>
                            {{-- Requester --}}
                            <td style="min-width:200px;">
                                <div class="flex items-center gap-3">
                                    <div class="{{ $avatarClass }}">{{ $initials }}</div>
                                    <div class="min-w-0">
                                        <p class="text-sm font-bold text-slate-900 leading-tight truncate">
                                            {{ $request->full_name ?: 'Unknown Name' }}
                                        </p>
                                    </div>
                                </div>
                            </td>

                            {{-- Contact --}}
                            <td style="min-width:180px;">
                                @if ($request->email)
                                    <div class="flex items-center gap-1.5">
                                        <svg class="w-3 h-3 text-slate-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75"/>
                                        </svg>
                                        <span class="text-xs text-slate-600 truncate max-w-[160px]">{{ $request->email }}</span>
                                    </div>
                                @else
                                    <span class="text-xs text-slate-400">-</span>
                                @endif
                            </td>

                            {{-- Requested at --}}
                            <td style="min-width:140px;">
                                @if ($request->requested_at)
                                    <p class="text-xs font-semibold text-slate-700 leading-tight">
                                        {{ $request->requested_at->format('M d, Y') }}
                                    </p>
                                    <p class="text-[.68rem] text-slate-400 mt-0.5">
                                        {{ $request->requested_at->format('g:i A') }}
                                    </p>
                                    <p class="text-[.65rem] text-slate-300 mt-0.5">
                                        {{ $request->requested_at->diffForHumans() }}
                                    </p>
                                @else
                                    <span class="text-xs text-slate-400">-</span>
                                @endif
                            </td>

                            {{-- Status --}}
                            <td style="min-width:110px;">
                                <span class="status-chip {{ $statusChipClass }}">
                                    <span class="status-dot" style="background:{{ $statusDotColor }};"></span>
                                    {{ ucfirst($request->status) }}
                                </span>

                                @if ($request->resolved_at)
                                    <p class="text-[.63rem] text-slate-400 mt-1.5">
                                        Closed {{ $request->resolved_at->diffForHumans() }}
                                    </p>
                                @endif
                            </td>

                            {{-- Notes --}}
                            <td style="min-width:160px; max-width:220px;">
                                @if ($request->notes)
                                    @php
                                        $notePreview = Str::limit($request->notes, 80);
                                        $hasTempPw = str_contains($request->notes, 'Temporary Password:');
                                    @endphp
                                    <div class="notes-pill">
                                        @if ($hasTempPw)
                                            @php
                                                preg_match('/Temporary Password:\s*(\S+)/i', $request->notes, $nm);
                                                $notePw = $nm[1] ?? '';
                                            @endphp
                                            <span class="text-[.62rem] font-bold text-slate-500 block mb-1">TEMP PASSWORD</span>
                                            <span class="font-mono font-bold text-slate-800" style="font-size:.72rem;user-select:all;">{{ $notePw }}</span>
                                        @else
                                            <span class="text-slate-500">{{ $notePreview }}</span>
                                        @endif
                                    </div>
                                @else
                                    <span class="text-xs text-slate-300">-</span>
                                @endif
                            </td>

                            {{-- Actions --}}
                            <td style="min-width:200px;">
                                <div class="flex flex-wrap items-center justify-end gap-1.5">

                                    @if ($request->status === 'pending')
                                        <button
                                            wire:click="markProcessing({{ $request->id }})"
                                            type="button"
                                            class="btn-processing"
                                        >
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99"/>
                                            </svg>
                                            Processing
                                        </button>
                                    @endif

                                    @if (in_array($request->status, ['pending', 'processing']))
                                        <button
                                            wire:click="resetPassword({{ $request->id }})"
                                            type="button"
                                            class="btn-gold"
                                            onclick="return confirm('Reset password for {{ addslashes($request->full_name ?: $request->username) }}? A temporary password will be generated.')"
                                        >
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 5.25a3 3 0 0 1 3 3m3 0a6 6 0 0 1-7.029 5.912c-.563-.097-1.159.026-1.563.43L10.5 17.25H8.25v2.25H6v2.25H2.25v-2.818c0-.597.237-1.17.659-1.591l6.499-6.499c.404-.404.527-1 .43-1.563A6 6 0 1 1 21.75 8.25Z"/>
                                            </svg>
                                            Reset Password
                                        </button>

                                        <button
                                            wire:click="markRejected({{ $request->id }})"
                                            type="button"
                                            class="btn-danger"
                                        >
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/>
                                            </svg>
                                            Reject
                                        </button>
                                    @endif

                                    @if (in_array($request->status, ['resolved', 'rejected']))
                                        <span class="text-[.68rem] text-slate-400 italic">
                                            {{ $request->status === 'resolved' ? 'Closed · Resolved' : 'Closed · Rejected' }}
                                        </span>
                                    @endif

                                </div>
                            </td>
                        </tr>

                    @empty
                        <tr>
                            <td colspan="6" style="padding:4rem 2rem;">
                                <div style="max-width:22rem;margin:0 auto;text-align:center;">
                                    <div style="width:3.5rem;height:3.5rem;border-radius:1rem;
                                                background:#f0f4fb;border:1px solid #e2e8f0;
                                                display:flex;align-items:center;justify-content:center;
                                                margin:0 auto 1rem;">
                                        <svg style="width:1.5rem;height:1.5rem;color:#94a3b8;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 5.25a3 3 0 0 1 3 3m3 0a6 6 0 0 1-7.029 5.912c-.563-.097-1.159.026-1.563.43L10.5 17.25H8.25v2.25H6v2.25H2.25v-2.818c0-.597.237-1.17.659-1.591l6.499-6.499c.404-.404.527-1 .43-1.563A6 6 0 1 1 21.75 8.25Z"/>
                                        </svg>
                                    </div>
                                    <h3 style="font-size:1rem;font-weight:700;color:#1e293b;margin-bottom:.4rem;">
                                        No requests found
                                    </h3>
                                    <p style="font-size:.8125rem;color:#64748b;line-height:1.6;margin-bottom:1.25rem;">
                                        @if ($search)
                                            No results for <strong>"{{ $search }}"</strong>.
                                            Try a different search term.
                                        @elseif ($status !== 'all')
                                            There are no <strong>{{ $status }}</strong> requests right now.
                                        @else
                                            No password reset requests have been submitted yet.
                                        @endif
                                    </p>
                                    @if ($search || $status !== 'all')
                                        <button
                                            wire:click="$set('search', '')"
                                            onclick="@this.set('status', 'all')"
                                            type="button"
                                            class="btn-ghost"
                                        >
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
        <div class="px-5 py-4" style="border-top:1px solid #f1f5f9;background:#fafbff;">
            {{ $requests->links() }}
        </div>
    </section>

</div>
</div>
