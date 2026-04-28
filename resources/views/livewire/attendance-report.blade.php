<div class="min-h-screen" style="background:#f0f4fb; font-family:'DM Sans',system-ui,sans-serif;">

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

    .ar-field {
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
        font-family: inherit;
    }
    .ar-field::placeholder { color: #94a3b8; }
    .ar-field:hover  { border-color: #94a3b8; }
    .ar-field:focus  { border-color: var(--r6); box-shadow: 0 0 0 3px rgba(26,63,168,.1); }
    .ar-field-icon   { padding-left: 2.4rem; }

    .ar-select {
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
        font-family: inherit;
    }
    .ar-select:hover { border-color: #94a3b8; }
    .ar-select:focus { border-color: var(--r6); box-shadow: 0 0 0 3px rgba(26,63,168,.1); }

    .ar-label {
        display: block;
        font-size: .65rem;
        font-weight: 700;
        letter-spacing: .1em;
        text-transform: uppercase;
        color: #64748b;
        margin-bottom: .35rem;
    }

    /* Status chips */
    .status-chip {
        display: inline-flex; align-items: center; gap: .3rem;
        padding: .2rem .6rem; border-radius: 999px;
        font-size: .68rem; font-weight: 700; letter-spacing: .04em; white-space: nowrap;
    }
    .status-dot { width:.45rem; height:.45rem; border-radius:50%; flex-shrink:0; }

    .chip-green  { background:#ecfdf5; color:#065f46; border:1px solid #a7f3d0; }
    .chip-amber  { background:#fffbeb; color:#92700a; border:1px solid #fde68a; }
    .chip-red    { background:#fef2f2; color:#991b1b; border:1px solid #fecaca; }
    .chip-slate  { background:#f1f5f9; color:#475569; border:1px solid #e2e8f0; }
    .chip-blue   { background:#eef2ff; color:var(--r6); border:1px solid #c7d2fe; }
    .chip-sky    { background:#f0f9ff; color:#0369a1; border:1px solid #bae6fd; }

    /* Table */
    .ar-table thead th {
        font-size: .62rem;
        font-weight: 700;
        letter-spacing: .14em;
        text-transform: uppercase;
        color: #64748b;
        padding: .7rem 1rem;
        text-align: left;
        white-space: nowrap;
    }
    .ar-table tbody tr {
        transition: background .12s;
        border-bottom: 1px solid #f1f5f9;
    }
    .ar-table tbody tr:last-child { border-bottom: none; }
    .ar-table tbody tr:hover { background: #f8faff; }
    .ar-table td { padding: .8rem 1rem; vertical-align: middle; }

    /* Stat cards */
    .stat-card {
        border-radius: 1rem;
        padding: .875rem 1rem;
        border: 1px solid;
    }
    .stat-label { font-size: .6rem; font-weight: 700; letter-spacing: .12em; text-transform: uppercase; margin-bottom: .3rem; }
    .stat-value { font-size: 1.5rem; font-weight: 800; line-height: 1; }

    /* Buttons */
    .btn-primary {
        display: inline-flex; align-items: center; gap: .4rem;
        height: 2.375rem; padding: 0 1rem;
        border-radius: .75rem;
        background: linear-gradient(135deg, var(--r6) 0%, var(--r8) 100%);
        box-shadow: 0 4px 14px rgba(21,53,145,.25);
        color: #fff; font-size: .8rem; font-weight: 700;
        transition: filter .15s; cursor: pointer; border: none; font-family: inherit; white-space: nowrap;
    }
    .btn-primary:hover { filter: brightness(1.08); }
    .btn-primary:disabled { opacity: .45; cursor: not-allowed; }

    .btn-ghost {
        display: inline-flex; align-items: center; gap: .4rem;
        height: 2.375rem; padding: 0 .875rem;
        border-radius: .75rem;
        background: #fff; border: 1px solid #e2e8f0;
        color: #475569; font-size: .8rem; font-weight: 600;
        transition: background .12s, border-color .12s;
        cursor: pointer; font-family: inherit; white-space: nowrap;
    }
    .btn-ghost:hover { background: #f8fafc; border-color: #cbd5e1; color: #1e293b; }

    .btn-green {
        display: inline-flex; align-items: center; gap: .4rem;
        height: 2.375rem; padding: 0 1rem;
        border-radius: .75rem;
        background: #065f46; color: #fff;
        font-size: .8rem; font-weight: 700;
        transition: background .12s; cursor: pointer; border: none; font-family: inherit; white-space: nowrap;
    }
    .btn-green:hover { background: #047857; }
    .btn-green:disabled { opacity: .45; cursor: not-allowed; }

    /* Payment select inline */
    .pay-select {
        height: 1.875rem;
        border-radius: .5rem;
        border: 1px solid #e2e8f0;
        background: #fff url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%2394a3b8' stroke-width='2'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' d='M19 9l-7 7-7-7'/%3E%3C/svg%3E") no-repeat right .5rem center / .75rem;
        padding: 0 1.75rem 0 .625rem;
        font-size: .72rem; color: #0f172a;
        outline: none; appearance: none;
        cursor: pointer; font-family: inherit;
        transition: border-color .15s;
    }
    .pay-select:focus { border-color: var(--r6); box-shadow: 0 0 0 2px rgba(26,63,168,.1); }

    /* Sum chips */
    .sum-chip {
        display: inline-flex; align-items: center; gap: .5rem;
        padding: .35rem .85rem; border-radius: 999px;
        font-size: .7rem; font-weight: 700; white-space: nowrap;
    }
</style>

<div class="space-y-5 px-4 py-6 sm:px-6 lg:px-8 mx-auto max-w-screen-2xl">

    {{-- ════════════════════════════════════════════════════════════
         HEADER BANNER
    ════════════════════════════════════════════════════════════ --}}
    <section class="overflow-hidden rounded-2xl"
             style="background:linear-gradient(155deg,var(--r8) 0%,var(--r7) 45%,var(--r6) 100%);
                    box-shadow:0 8px 32px rgba(10,31,92,.28);">
        <div class="pointer-events-none absolute inset-0 overflow-hidden" aria-hidden="true"
             style="position:relative;">
            <span style="position:absolute;right:2rem;top:50%;transform:translateY(-50%);
                         font-family:Georgia,serif;font-size:7rem;font-weight:900;color:#fff;
                         opacity:.025;letter-spacing:.05em;user-select:none;white-space:nowrap;">
                ATTENDANCE
            </span>
        </div>

        <div class="relative px-6 py-6 sm:px-8">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
                <div>
                    <p class="text-[.65rem] font-bold uppercase tracking-[.22em]" style="color:var(--g4);">
                        HSST Alumni Portal &middot; Admin Control
                    </p>
                    <h1 class="mt-2 text-2xl font-bold tracking-tight text-white sm:text-3xl"
                        style="font-family:Georgia,serif;letter-spacing:-.01em;">
                        Attendance Report
                    </h1>
                    <p class="mt-1.5 text-sm leading-6" style="color:rgba(255,255,255,.6);max-width:50ch;">
                        View all alumni attendees, RSVP responses, and payment records per event.
                    </p>
                </div>
                <div class="flex items-center gap-2 sm:mt-1 sm:shrink-0">
                    <span class="sum-chip" style="background:rgba(255,255,255,.14);color:#fff;border:1px solid rgba(255,255,255,.18);">
                        All Batches
                    </span>
                </div>
            </div>

            {{-- Stats strip (only when an event is selected) --}}
            @if ($selectedEvent !== 'all')
                <div class="mt-5 pt-5" style="border-top:1px solid rgba(255,255,255,.12);">
                    <div class="grid grid-cols-2 gap-2 sm:grid-cols-4 lg:grid-cols-8">
                        {{-- RSVP --}}
                        <div class="rounded-xl px-3 py-2.5"
                             style="background:rgba(16,185,129,.16);border:1px solid rgba(16,185,129,.22);">
                            <p class="stat-label" style="color:#6ee7b7;">Attending</p>
                            <p class="stat-value text-white">{{ $attendingParticipantsCount }}</p>
                        </div>
                        <div class="rounded-xl px-3 py-2.5"
                             style="background:rgba(196,149,42,.16);border:1px solid rgba(196,149,42,.22);">
                            <p class="stat-label" style="color:var(--g4);">Maybe</p>
                            <p class="stat-value text-white">{{ $maybeParticipantsCount }}</p>
                        </div>
                        <div class="rounded-xl px-3 py-2.5"
                             style="background:rgba(239,68,68,.14);border:1px solid rgba(239,68,68,.2);">
                            <p class="stat-label" style="color:#fca5a5;">Not Attending</p>
                            <p class="stat-value text-white">{{ $notAttendingParticipantsCount }}</p>
                        </div>
                        <div class="rounded-xl px-3 py-2.5"
                             style="background:rgba(255,255,255,.1);border:1px solid rgba(255,255,255,.14);">
                            <p class="stat-label" style="color:rgba(255,255,255,.5);">No Response</p>
                            <p class="stat-value text-white">{{ $noResponseCount }}</p>
                        </div>
                        {{-- Payment --}}
                        <div class="rounded-xl px-3 py-2.5"
                             style="background:rgba(14,165,233,.15);border:1px solid rgba(14,165,233,.22);">
                            <p class="stat-label" style="color:#7dd3fc;">Paid</p>
                            <p class="stat-value text-white">{{ $paidParticipantsCount }}</p>
                        </div>
                        <div class="rounded-xl px-3 py-2.5"
                             style="background:rgba(255,255,255,.1);border:1px solid rgba(255,255,255,.14);">
                            <p class="stat-label" style="color:rgba(255,255,255,.5);">Unpaid</p>
                            <p class="stat-value text-white">{{ $unpaidParticipantsCount }}</p>
                        </div>
                        <div class="rounded-xl px-3 py-2.5"
                             style="background:rgba(196,149,42,.16);border:1px solid rgba(196,149,42,.22);">
                            <p class="stat-label" style="color:var(--g4);">Pending</p>
                            <p class="stat-value text-white">{{ $pendingParticipantsCount }}</p>
                        </div>
                        <div class="rounded-xl px-3 py-2.5"
                             style="background:rgba(239,68,68,.14);border:1px solid rgba(239,68,68,.2);">
                            <p class="stat-label" style="color:#fca5a5;">Rejected</p>
                            <p class="stat-value text-white">{{ $rejectedParticipantsCount }}</p>
                        </div>
                    </div>

                    {{-- Total Paid Amount --}}
                    <div class="mt-3 flex items-center justify-between rounded-xl px-4 py-3"
                         style="background:rgba(16,185,129,.18);border:1px solid rgba(16,185,129,.28);">
                        <div class="flex items-center gap-2">
                            <svg class="h-4 w-4 shrink-0" style="color:#6ee7b7;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75"/>
                            </svg>
                            <p class="stat-label mb-0" style="color:#6ee7b7; margin-bottom:0;">Total Collected (Paid)</p>
                        </div>
                        <p class="text-xl font-extrabold text-white">
                            ₱{{ number_format((float) $totalPaidAmount, 2) }}
                        </p>
                    </div>
                </div>
            @endif
        </div>
    </section>

    @include('partials.toast')

    {{-- ════════════════════════════════════════════════════════════
         FILTER BAR
    ════════════════════════════════════════════════════════════ --}}
    <section class="rounded-2xl bg-white"
             style="border:1px solid #e2e8f0; box-shadow:0 1px 6px rgba(15,23,42,.05);">
        <div class="flex items-center justify-between px-5 py-3" style="border-bottom:1px solid #f1f5f9;">
            <div class="flex items-center gap-2">
                <svg class="w-4 h-4" style="color:var(--r6);" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 3c2.755 0 5.455.232 8.083.678.533.09.917.556.917 1.096v1.044a2.25 2.25 0 0 1-.659 1.591l-5.432 5.432a2.25 2.25 0 0 0-.659 1.591v2.927a2.25 2.25 0 0 1-1.244 2.013L9.75 21v-6.568a2.25 2.25 0 0 0-.659-1.591L3.659 7.409A2.25 2.25 0 0 1 3 5.818V4.774c0-.54.384-1.006.917-1.096A48.32 48.32 0 0 1 12 3Z"/>
                </svg>
                <span class="text-xs font-bold uppercase tracking-[.14em] text-slate-500">Smart Filters</span>
            </div>
            <button wire:click="resetEventFilters" class="text-[.68rem] font-bold transition hover:underline"
                    style="color:var(--r6);">
                Reset
            </button>
        </div>

        <div class="px-5 py-4">
            <div class="grid grid-cols-1 gap-3 sm:grid-cols-2 xl:grid-cols-5">

                {{-- Event --}}
                <div>
                    <label class="ar-label">Event</label>
                    <select wire:model.live="selectedEvent" class="ar-select">
                        <option value="all">Select an event…</option>
                        @foreach ($allEvents as $eventOption)
                            <option value="{{ $eventOption->id }}">
                                {{ $eventOption->title }}@if($eventOption->event_date) — {{ $eventOption->event_date->format('M d, Y') }}@endif
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Level --}}
                <div>
                    <label class="ar-label">Level</label>
                    <select wire:model.live="levelFilter" class="ar-select">
                        <option value="all">All Levels</option>
                        <option value="elementary">Elementary</option>
                        <option value="highschool">High School</option>
                        <option value="college">College</option>
                    </select>
                </div>

                {{-- RSVP --}}
                <div>
                    <label class="ar-label">RSVP Status</label>
                    <select wire:model.live="rsvpStatusFilter" class="ar-select">
                        <option value="all">All Responses</option>
                        <option value="attending">Attending</option>
                        <option value="maybe">Maybe</option>
                        <option value="not_attending">Not Attending</option>
                        <option value="no_response">No Response Yet</option>
                    </select>
                </div>

                {{-- Payment --}}
                <div>
                    <label class="ar-label">Payment Status</label>
                    <select wire:model.live="paymentStatusFilter" class="ar-select">
                        <option value="all">All Payment Status</option>
                        <option value="paid">Paid</option>
                        <option value="unpaid">Unpaid</option>
                        <option value="pending">Pending</option>
                        <option value="rejected">Rejected</option>
                    </select>
                </div>

                {{-- Search --}}
                <div>
                    <label class="ar-label">Search</label>
                    <div class="relative">
                        <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3"
                              style="color:#94a3b8;">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z"/>
                            </svg>
                        </span>
                        <input type="text"
                               wire:model.live.debounce.300ms="search"
                               placeholder="Name or batch…"
                               class="ar-field ar-field-icon" />
                    </div>
                </div>

            </div>

            <div class="mt-4 flex items-center justify-end gap-2">
                <button type="button" wire:click="resetEventFilters" class="btn-ghost">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99"/>
                    </svg>
                    Reset Filters
                </button>
                <button type="button"
                        wire:click="downloadExcel"
                        @disabled($selectedEvent === 'all')
                        class="btn-green">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3"/>
                    </svg>
                    Download CSV
                </button>
            </div>
        </div>
    </section>

    {{-- ════════════════════════════════════════════════════════════
         TABLE
    ════════════════════════════════════════════════════════════ --}}
    <section class="overflow-hidden rounded-2xl bg-white"
             style="border:1px solid #e2e8f0; box-shadow:0 1px 6px rgba(15,23,42,.05);">

        <div class="flex flex-col gap-2 px-5 py-4 sm:flex-row sm:items-center sm:justify-between"
             style="border-bottom:1px solid #f1f5f9;">
            <div>
                <h2 class="text-base font-bold text-slate-900">Attendee Records</h2>
                <p class="mt-0.5 text-xs text-slate-500">
                    RSVP responses and payment status per registered alumni.
                </p>
            </div>
            @if ($selectedEvent !== 'all' && method_exists($participants, 'total'))
                <span class="status-chip chip-blue self-start sm:self-auto">
                    <span class="status-dot" style="background:var(--r6);"></span>
                    {{ $participants->total() }} record{{ $participants->total() !== 1 ? 's' : '' }}
                </span>
            @endif
        </div>

        <div class="overflow-x-auto">
            <table class="ar-table min-w-full">
                <thead style="background:#f8fafc; border-bottom:1px solid #e2e8f0;">
                    <tr>
                        <th>Batch</th>
                        <th>Level</th>
                        <th>Alumni Name</th>
                        <th>RSVP</th>
                        <th style="text-align:center;">Guests</th>
                        <th style="text-align:right;">Fee</th>
                        <th>Payment</th>
                        <th>Updated</th>
                        <th>Update Status</th>
                    </tr>
                </thead>

                <tbody>
                    @if ($selectedEvent === 'all')
                        <tr>
                            <td colspan="9" class="px-5 py-14 text-center">
                                <svg class="mx-auto h-8 w-8 mb-2" style="color:#cbd5e1;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5"/>
                                </svg>
                                <p class="text-sm font-semibold text-slate-500">Select an event to view attendance records</p>
                                <p class="mt-0.5 text-xs text-slate-400">Use the filter above to choose an event first.</p>
                            </td>
                        </tr>
                    @else
                        @forelse ($participants as $participant)
                            @php
                                $fullName = trim(collect([
                                    $participant->fname,
                                    $participant->mname,
                                    $participant->lname,
                                ])->filter()->map(fn($n) => ucwords(strtolower($n)))->implode(' '));

                                $rsvpStatus = $participant->rsvp_status ?? 'no_response';
                                [$rsvpChip, $rsvpDot, $rsvpLabel] = match($rsvpStatus) {
                                    'attending'     => ['chip-green',  '#065f46', 'Attending'],
                                    'maybe'         => ['chip-amber',  '#c4952a', 'Maybe'],
                                    'not_attending' => ['chip-red',    '#991b1b', 'Not Attending'],
                                    default         => ['chip-slate',  '#94a3b8', 'No Response'],
                                };

                                $paymentStatus = $participant->payment_status ?? 'unpaid';
                                [$payChip, $payDot, $payLabel] = match($paymentStatus) {
                                    'paid'     => ['chip-sky',   '#0369a1', 'Paid'],
                                    'pending'  => ['chip-amber', '#c4952a', 'Pending'],
                                    'rejected' => ['chip-red',   '#991b1b', 'Rejected'],
                                    default    => ['chip-slate', '#94a3b8', 'Unpaid'],
                                };

                                $batchLevel = match($participant->batch_level ?? '') {
                                    'elementary' => 'Elementary',
                                    'highschool' => 'High School',
                                    'college'    => 'College',
                                    default      => '—',
                                };
                            @endphp

                            <tr>
                                <td>
                                    <span class="text-sm font-semibold text-slate-700">
                                        {{ $participant->batch_label ?: '—' }}
                                    </span>
                                </td>

                                <td>
                                    <span class="text-xs text-slate-400">{{ $batchLevel }}</span>
                                </td>

                                <td>
                                    <span class="text-sm font-semibold text-slate-800">
                                        {{ $fullName ?: '—' }}
                                    </span>
                                </td>

                                <td>
                                    <span class="status-chip {{ $rsvpChip }}">
                                        <span class="status-dot" style="background:{{ $rsvpDot }};"></span>
                                        {{ $rsvpLabel }}
                                    </span>
                                </td>

                                <td style="text-align:center;">
                                    <span class="text-sm text-slate-600">{{ $participant->guest_count ?? 0 }}</span>
                                </td>

                                <td style="text-align:right;">
                                    <span class="text-sm font-bold text-slate-800">
                                        @if(($selectedEventModel?->registration_fee ?? 0) > 0)
                                            ₱{{ number_format($selectedEventModel->registration_fee / 100, 2) }}
                                        @else
                                            <span class="status-chip chip-green" style="font-size:.62rem;">Free</span>
                                        @endif
                                    </span>
                                </td>

                                <td>
                                    <span class="status-chip {{ $payChip }}">
                                        <span class="status-dot" style="background:{{ $payDot }};"></span>
                                        {{ $payLabel }}
                                    </span>
                                </td>

                                <td>
                                    @if($participant->payment_updated_at)
                                        <div class="flex flex-col">
                                            <span class="text-xs text-slate-600">
                                                {{ \Carbon\Carbon::parse($participant->payment_updated_at)->format('M d, Y') }}
                                            </span>
                                            <span class="text-[.68rem] text-slate-400">
                                                {{ \Carbon\Carbon::parse($participant->payment_updated_at)->format('h:i A') }}
                                            </span>
                                        </div>
                                    @else
                                        <span class="text-xs text-slate-300">—</span>
                                    @endif
                                </td>

                                <td>
                                    <select
                                        wire:change="updatePaymentStatus({{ $participant->id }}, $event.target.value)"
                                        class="pay-select"
                                    >
                                        <option value="unpaid"   @selected($paymentStatus === 'unpaid')>Unpaid</option>
                                        <option value="pending"  @selected($paymentStatus === 'pending')>Pending</option>
                                        <option value="paid"     @selected($paymentStatus === 'paid')>Paid</option>
                                        <option value="rejected" @selected($paymentStatus === 'rejected')>Rejected</option>
                                    </select>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="px-5 py-14 text-center">
                                    <svg class="mx-auto h-7 w-7 mb-2" style="color:#cbd5e1;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z"/>
                                    </svg>
                                    <p class="text-sm font-semibold text-slate-500">No records found</p>
                                    <p class="mt-0.5 text-xs text-slate-400">Try adjusting your filters.</p>
                                </td>
                            </tr>
                        @endforelse
                    @endif
                </tbody>
            </table>
        </div>

        @if ($selectedEvent !== 'all' && method_exists($participants, 'links'))
            <div class="flex flex-col gap-3 px-5 py-4 text-sm sm:flex-row sm:items-center sm:justify-between"
                 style="border-top:1px solid #f1f5f9;">
                <p class="text-xs text-slate-400">
                    Showing {{ $participants->firstItem() ?? 0 }}–{{ $participants->lastItem() ?? 0 }}
                    of {{ $participants->total() }}
                </p>
                <div class="[&>*]:!shadow-none">
                    {{ $participants->links() }}
                </div>
            </div>
        @endif
    </section>

    {{-- ════════════════════════════════════════════════════════════
         STAFF ATTENDANCE TABLE
    ════════════════════════════════════════════════════════════ --}}
    @if ($selectedEvent !== 'all')
    <section class="overflow-hidden rounded-2xl bg-white"
             style="border:1px solid #e2e8f0; box-shadow:0 1px 6px rgba(15,23,42,.05);">

        <div class="flex flex-col gap-2 px-5 py-4 sm:flex-row sm:items-center sm:justify-between"
             style="border-bottom:1px solid #f1f5f9;">
            <div>
                <h2 class="text-base font-bold text-slate-900">Staff Attendance</h2>
                <p class="mt-0.5 text-xs text-slate-500">
                    RSVP responses from school staff and employees.
                </p>
            </div>
            <div class="flex flex-wrap gap-2">
                <span class="status-chip chip-green">
                    <span class="status-dot" style="background:#065f46;"></span>
                    {{ $staffAttendingCount }} Attending
                </span>
                <span class="status-chip chip-amber">
                    <span class="status-dot" style="background:#c4952a;"></span>
                    {{ $staffMaybeCount }} Maybe
                </span>
                <span class="status-chip chip-red">
                    <span class="status-dot" style="background:#991b1b;"></span>
                    {{ $staffNotAttendingCount }} Not Attending
                </span>
                <span class="status-chip chip-slate">
                    <span class="status-dot" style="background:#94a3b8;"></span>
                    {{ $staffNoResponseCount }} No Response
                </span>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="ar-table min-w-full">
                <thead style="background:#f8fafc; border-bottom:1px solid #e2e8f0;">
                    <tr>
                        <th>Staff Name</th>
                        <th>Position</th>
                        <th>RSVP</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($staffParticipants as $staff)
                        @php
                            $fullName = trim(collect([$staff->fname, $staff->lname])
                                ->filter()
                                ->map(fn($n) => ucwords(strtolower($n)))
                                ->implode(' '));

                            $rsvpStatus = $staff->rsvp_status ?? 'no_response';
                            [$rsvpChip, $rsvpDot, $rsvpLabel] = match($rsvpStatus) {
                                'attending'     => ['chip-green', '#065f46', 'Attending'],
                                'maybe'         => ['chip-amber', '#c4952a', 'Maybe'],
                                'not_attending' => ['chip-red',   '#991b1b', 'Not Attending'],
                                default         => ['chip-slate', '#94a3b8', 'No Response'],
                            };
                        @endphp
                        <tr>
                            <td>
                                <span class="text-sm font-semibold text-slate-800">{{ $fullName ?: '—' }}</span>
                            </td>
                            <td>
                                <span class="text-xs text-slate-500">{{ $staff->position ?: '—' }}</span>
                            </td>
                            <td>
                                <span class="status-chip {{ $rsvpChip }}">
                                    <span class="status-dot" style="background:{{ $rsvpDot }};"></span>
                                    {{ $rsvpLabel }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-5 py-10 text-center">
                                <p class="text-sm font-semibold text-slate-500">No active staff found</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
    @endif

</div>
</div>
