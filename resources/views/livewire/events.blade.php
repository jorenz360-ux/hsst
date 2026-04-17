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

    .ev-field {
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
    .ev-field::placeholder { color: #94a3b8; }
    .ev-field:hover  { border-color: #94a3b8; }
    .ev-field:focus  { border-color: var(--r6); box-shadow: 0 0 0 3px rgba(26,63,168,.1); }
    .ev-field-icon   { padding-left: 2.4rem; }

    .ev-select {
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
    .ev-select:hover { border-color: #94a3b8; }
    .ev-select:focus { border-color: var(--r6); box-shadow: 0 0 0 3px rgba(26,63,168,.1); }

    .ev-label {
        display: block;
        font-size: .65rem;
        font-weight: 700;
        letter-spacing: .1em;
        text-transform: uppercase;
        color: #64748b;
        margin-bottom: .35rem;
    }

    /* Status chips */
    .chip-green  { background:#ecfdf5; color:#065f46; border:1px solid #a7f3d0; }
    .chip-red    { background:#fef2f2; color:#991b1b; border:1px solid #fecaca; }
    .chip-amber  { background:#fffbeb; color:#92700a; border:1px solid #fde68a; }
    .chip-slate  { background:#f1f5f9; color:#475569; border:1px solid #e2e8f0; }
    .chip-blue   { background:#eef2ff; color:#1a3fa8; border:1px solid #c7d2fe; }
    .chip-violet { background:#f5f3ff; color:#5b21b6; border:1px solid #ddd6fe; }

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
    .ev-table thead th {
        font-size: .62rem;
        font-weight: 700;
        letter-spacing: .14em;
        text-transform: uppercase;
        color: #64748b;
        padding: .7rem 1.1rem;
        text-align: left;
        white-space: nowrap;
    }
    .ev-table thead th:last-child { text-align: right; }
    .ev-table tbody tr {
        transition: background .12s;
        border-bottom: 1px solid #f1f5f9;
    }
    .ev-table tbody tr:last-child { border-bottom: none; }
    .ev-table tbody tr:hover { background: #f8faff; }
    .ev-table td {
        padding: .85rem 1.1rem;
        vertical-align: middle;
    }
    .ev-table td:last-child { text-align: right; }

    /* Buttons */
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
    .btn-action-edit {
        background: var(--r6); border: 1px solid var(--r7); color: #fff;
    }
    .btn-action-edit:hover { background: var(--r7); }
    .btn-action-ghost {
        background: #fff; border: 1px solid #e2e8f0; color: #475569;
    }
    .btn-action-ghost:hover { background: #f0f4fb; border-color: #c7d2fe; color: var(--r6); }
    .btn-action-danger {
        background: #fff; border: 1px solid #fecaca; color: #dc2626;
    }
    .btn-action-danger:hover { background: #fef2f2; border-color: #fca5a5; }
    .btn-action-approve {
        background: #065f46; border: 1px solid #065f46; color: #fff;
    }
    .btn-action-approve:hover { background: #047857; }

    /* Summary chip */
    .sum-chip {
        display: inline-flex; align-items: center; gap: .5rem;
        padding: .35rem .85rem;
        border-radius: 999px;
        font-size: .7rem; font-weight: 700;
        white-space: nowrap;
    }

    /* Tab switcher */
    .ev-tab-bar {
        display: flex;
        gap: .25rem;
        background: rgba(255,255,255,.12);
        border: 1px solid rgba(255,255,255,.16);
        border-radius: 1rem;
        padding: .25rem;
    }
    .ev-tab {
        flex: 1;
        padding: .5rem 1.25rem;
        border-radius: .75rem;
        font-size: .8rem;
        font-weight: 600;
        cursor: pointer;
        border: none;
        transition: background .15s, color .15s, box-shadow .15s;
        color: rgba(255,255,255,.6);
        background: transparent;
    }
    .ev-tab:hover { color: #fff; background: rgba(255,255,255,.1); }
    .ev-tab.active-events {
        background: #fff;
        color: var(--r6);
        box-shadow: 0 2px 8px rgba(10,31,92,.15);
    }
    .ev-tab.active-payments {
        background: #fff;
        color: #5b21b6;
        box-shadow: 0 2px 8px rgba(10,31,92,.15);
    }
</style>

@can('create.event')
    @include('partials.toast')

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
                    EVENTS
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
                            Events Management
                        </h1>
                        <p class="mt-1.5 text-sm leading-6" style="color:rgba(255,255,255,.6);max-width:48ch;">
                            Manage events and validate payment submissions from the alumni community.
                        </p>
                    </div>

                    {{-- Actions + Tab switcher --}}
                    <div class="flex flex-col gap-3 lg:mt-1 lg:shrink-0 lg:items-end">
                        @can('create.event')
                            <a href="{{ route('create-event') }}" wire:navigate class="btn-gold self-start lg:self-auto">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                                </svg>
                                Create Event
                            </a>
                        @endcan

                        {{-- Tab switcher --}}
                        <div class="ev-tab-bar">
                            <button
                                wire:click="$set('tab', 'events')"
                                class="ev-tab {{ $tab === 'events' ? 'active-events' : '' }}"
                            >
                                <svg class="inline-block w-3.5 h-3.5 mr-1 -mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5"/>
                                </svg>
                                Calendar View
                            </button>
                            <button
                                wire:click="$set('tab', 'payments')"
                                class="ev-tab {{ $tab === 'payments' ? 'active-payments' : '' }}"
                            >
                                <svg class="inline-block w-3.5 h-3.5 mr-1 -mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Z"/>
                                </svg>
                                Payment Validation
                            </button>
                        </div>
                    </div>
                </div>

                {{-- Summary strip --}}
                <div class="mt-5 flex flex-wrap items-center gap-2 pt-5"
                     style="border-top:1px solid rgba(255,255,255,.12);">
                    <span class="sum-chip" style="background:rgba(255,255,255,.14);color:#fff;border:1px solid rgba(255,255,255,.18);">
                        <svg class="w-3.5 h-3.5 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5"/>
                        </svg>
                        <span class="text-white/60 font-semibold">Total</span>
                        <strong>{{ $stats['total'] }}</strong>
                    </span>

                    <span class="sum-chip" style="background:rgba(196,149,42,.14);color:var(--g4);border:1px solid rgba(196,149,42,.22);">
                        <span class="status-dot" style="background:var(--g4);"></span>
                        Upcoming: <strong>{{ $stats['upcoming'] }}</strong>
                    </span>

                    <span class="sum-chip" style="background:rgba(99,102,241,.14);color:#a5b4fc;border:1px solid rgba(99,102,241,.2);">
                        <span class="status-dot" style="background:#a5b4fc;"></span>
                        Past: <strong>{{ $stats['past'] }}</strong>
                    </span>

                    <span class="sum-chip" style="background:rgba(16,185,129,.14);color:#6ee7b7;border:1px solid rgba(16,185,129,.2);">
                        <span class="status-dot" style="background:#6ee7b7;"></span>
                        Active: <strong>{{ $stats['active'] }}</strong>
                    </span>
                </div>
            </div>
        </section>

        {{-- ════════════════════════════════════════════════════════════
             PAYMENTS TAB
        ════════════════════════════════════════════════════════════ --}}
        @if ($tab === 'payments')
            {{-- Filter bar --}}
            <section class="rounded-2xl bg-white"
                     style="border:1px solid #e2e8f0; box-shadow:0 1px 6px rgba(15,23,42,.05);">
                <div class="flex items-center gap-2 px-5 py-3" style="border-bottom:1px solid #f1f5f9;">
                    <svg class="w-4 h-4" style="color:var(--r6);" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 3c2.755 0 5.455.232 8.083.678.533.09.917.556.917 1.096v1.044a2.25 2.25 0 0 1-.659 1.591l-5.432 5.432a2.25 2.25 0 0 0-.659 1.591v2.927a2.25 2.25 0 0 1-1.244 2.013L9.75 21v-6.568a2.25 2.25 0 0 0-.659-1.591L3.659 7.409A2.25 2.25 0 0 1 3 5.818V4.774c0-.54.384-1.006.917-1.096A48.32 48.32 0 0 1 12 3Z"/>
                    </svg>
                    <span class="text-xs font-bold uppercase tracking-[.14em] text-slate-500">Filters</span>
                </div>
                <div class="px-5 py-4">
                    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
                        <div class="sm:col-span-1">
                            <label class="ev-label">Search</label>
                            <div class="relative">
                                <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3" style="color:#94a3b8;">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z"/>
                                    </svg>
                                </span>
                                <input
                                    type="text"
                                    wire:model.live.debounce.300ms="paymentSearch"
                                    placeholder="Alumni, event, item, reference..."
                                    class="ev-field ev-field-icon"
                                />
                            </div>
                        </div>
                        <div>
                            <label class="ev-label">Payment Type</label>
                            <select wire:model.live="paymentType" class="ev-select">
                                <option value="all">All Types</option>
                                <option value="registration">Base Registration</option>
                                <option value="item">Registration Items</option>
                            </select>
                        </div>
                        <div>
                            <label class="ev-label">Per Page</label>
                            <select wire:model.live="paymentPerPage" class="ev-select">
                                <option value="10">10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                            </select>
                        </div>
                    </div>
                </div>
            </section>

            {{-- Payments table --}}
            <section class="overflow-hidden rounded-2xl bg-white"
                     style="border:1px solid #e2e8f0; box-shadow:0 1px 6px rgba(15,23,42,.05);">
                <div class="flex flex-col gap-2 px-5 py-4 sm:flex-row sm:items-center sm:justify-between"
                     style="border-bottom:1px solid #f1f5f9;">
                    <div>
                        <h2 class="text-base font-bold text-slate-900">Pending Payment Validations</h2>
                        <p class="mt-0.5 text-xs text-slate-500">
                            Review whether the proof is for the base registration fee or a registration item.
                        </p>
                    </div>
                    <span class="status-chip chip-amber self-start sm:self-auto">
                        <span class="status-dot" style="background:#c4952a;"></span>
                        {{ $pendingPayments->total() }} pending
                    </span>
                </div>

                <div class="overflow-x-auto">
                    <table class="ev-table min-w-full">
                        <thead style="background:#f8fafc; border-bottom:1px solid #e2e8f0;">
                            <tr>
                                <th>Alumni</th>
                                <th>Event</th>
                                <th>Paid For</th>
                                <th style="text-align:right;">Amount</th>
                                <th>Reference</th>
                                <th>Proof</th>
                                <th>Submitted</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pendingPayments as $payment)
                                <tr>
                                    <td>
                                        <span class="text-sm font-semibold text-slate-800">
                                            {{ ucwords(strtolower($payment->registration->alumni->fname ?? '')) }}
                                            {{ ucwords(strtolower($payment->registration->alumni->lname ?? '')) }}
                                        </span>
                                    </td>

                                    <td>
                                        <span class="text-sm text-slate-600">
                                            {{ $payment->registration->event->title ?? '-' }}
                                        </span>
                                    </td>

                                    <td>
                                        <div class="space-y-1">
                                            <p class="text-sm font-medium text-slate-800">
                                                {{ $payment->registrationItem?->name ?? 'Event Registration Fee' }}
                                            </p>
                                            @if ($payment->registrationItem)
                                                <span class="status-chip chip-violet">
                                                    <span class="status-dot" style="background:#5b21b6;"></span>
                                                    Registration Item
                                                </span>
                                                @if ($payment->registrationItem->schedule)
                                                    <p class="text-xs text-slate-400 mt-0.5">
                                                        {{ $payment->registrationItem->schedule->title }}
                                                    </p>
                                                @endif
                                            @else
                                                <span class="status-chip chip-green">
                                                    <span class="status-dot" style="background:#065f46;"></span>
                                                    Base Registration
                                                </span>
                                            @endif
                                        </div>
                                    </td>

                                    <td style="text-align:right;">
                                        <span class="text-sm font-bold text-slate-900">₱{{ number_format($payment->amount / 100, 2) }}</span>
                                    </td>

                                    <td>
                                        <span class="font-mono text-xs text-slate-400">{{ $payment->reference_number ?? '-' }}</span>
                                    </td>

                                    <td>
                                        @if($payment->or_file_path)
                                            <a
                                                href="{{ Storage::disk('s3')->url($payment->or_file_path) }}"
                                                target="_blank"
                                                class="btn-action btn-action-ghost"
                                            >
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="m18.375 12.739-7.693 7.693a4.5 4.5 0 0 1-6.364-6.364l10.94-10.94A3 3 0 1 1 19.5 7.372L8.552 18.32m.009-.01-.01.01m5.699-9.941-7.81 7.81a1.5 1.5 0 0 0 2.112 2.13"/>
                                                </svg>
                                                View OR
                                            </a>
                                        @else
                                            <span class="text-xs text-slate-300">No file</span>
                                        @endif
                                    </td>

                                    <td>
                                        <div class="flex flex-col">
                                            <span class="text-sm text-slate-700">{{ $payment->created_at->format('M d, Y') }}</span>
                                            <span class="text-xs text-slate-400">{{ $payment->created_at->format('h:i A') }}</span>
                                        </div>
                                    </td>

                                    <td>
                                        <div class="flex justify-end gap-1.5">
                                            <button
                                                wire:click="approvePayment({{ $payment->id }})"
                                                wire:loading.attr="disabled"
                                                class="btn-action btn-action-approve"
                                            >
                                                Approve
                                            </button>
                                            <button
                                                wire:click="rejectPayment({{ $payment->id }})"
                                                wire:loading.attr="disabled"
                                                class="btn-action btn-action-danger"
                                            >
                                                Reject
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="px-5 py-14 text-center">
                                        <svg class="mx-auto h-7 w-7" style="color:#cbd5e1;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 13.5h3.86a2.25 2.25 0 0 1 2.012 1.244l.256.512a2.25 2.25 0 0 0 2.013 1.244h3.218a2.25 2.25 0 0 0 2.013-1.244l.256-.512a2.25 2.25 0 0 1 2.013-1.244h3.859m-19.5.338V18a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18v-4.162c0-.224-.034-.447-.1-.661L19.24 5.338a2.25 2.25 0 0 0-2.15-1.588H6.911a2.25 2.25 0 0 0-2.15 1.588L2.35 13.177a2.25 2.25 0 0 0-.1.661Z"/>
                                        </svg>
                                        <p class="mt-2 text-sm text-slate-400">No pending payment validations.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="flex flex-col gap-3 px-5 py-4 text-sm sm:flex-row sm:items-center sm:justify-between"
                     style="border-top:1px solid #f1f5f9;">
                    <p class="text-xs text-slate-400">
                        Showing {{ $pendingPayments->firstItem() ?? 0 }}–{{ $pendingPayments->lastItem() ?? 0 }}
                        of {{ $pendingPayments->total() }}
                    </p>
                    <div class="[&>*]:!shadow-none">
                        {{ $pendingPayments->links() }}
                    </div>
                </div>
            </section>
        @endif

        {{-- ════════════════════════════════════════════════════════════
             EVENTS TAB
        ════════════════════════════════════════════════════════════ --}}
        @if ($tab === 'events')
            {{-- Filter bar --}}
            <section class="rounded-2xl bg-white"
                     style="border:1px solid #e2e8f0; box-shadow:0 1px 6px rgba(15,23,42,.05);">
                <div class="flex items-center gap-2 px-5 py-3" style="border-bottom:1px solid #f1f5f9;">
                    <svg class="w-4 h-4" style="color:var(--r6);" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 3c2.755 0 5.455.232 8.083.678.533.09.917.556.917 1.096v1.044a2.25 2.25 0 0 1-.659 1.591l-5.432 5.432a2.25 2.25 0 0 0-.659 1.591v2.927a2.25 2.25 0 0 1-1.244 2.013L9.75 21v-6.568a2.25 2.25 0 0 0-.659-1.591L3.659 7.409A2.25 2.25 0 0 1 3 5.818V4.774c0-.54.384-1.006.917-1.096A48.32 48.32 0 0 1 12 3Z"/>
                    </svg>
                    <span class="text-xs font-bold uppercase tracking-[.14em] text-slate-500">Smart Filters</span>
                </div>
                <div class="px-5 py-4">
                    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2 xl:grid-cols-4">
                        <div class="xl:col-span-1">
                            <label class="ev-label">Search</label>
                            <div class="relative">
                                <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3" style="color:#94a3b8;">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z"/>
                                    </svg>
                                </span>
                                <input
                                    type="text"
                                    wire:model.live.debounce.300ms="search"
                                    placeholder="Search title or venue..."
                                    class="ev-field ev-field-icon"
                                />
                            </div>
                        </div>
                        <div>
                            <label class="ev-label">Status</label>
                            <select wire:model.live="status" class="ev-select">
                                <option value="upcoming">Upcoming</option>
                                <option value="past">Past</option>
                                <option value="all">All</option>
                            </select>
                        </div>
                        <div>
                            <label class="ev-label">Visibility</label>
                            <select wire:model.live="active" class="ev-select">
                                <option value="all">All</option>
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                        <div>
                            <label class="ev-label">Per Page</label>
                            <select wire:model.live="perPage" class="ev-select">
                                <option value="10">10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                            </select>
                        </div>
                    </div>
                </div>
            </section>

            {{-- Events table --}}
            <section class="overflow-hidden rounded-2xl bg-white"
                     style="border:1px solid #e2e8f0; box-shadow:0 1px 6px rgba(15,23,42,.05);">
                <div class="flex flex-col gap-2 px-5 py-4 sm:flex-row sm:items-center sm:justify-between"
                     style="border-bottom:1px solid #f1f5f9;">
                    <div>
                        <h2 class="text-base font-bold text-slate-900">Event List</h2>
                        <p class="mt-0.5 text-xs text-slate-500">
                            Detailed tabular view for searching, reviewing, and editing events.
                        </p>
                    </div>
                    <span class="status-chip chip-blue self-start sm:self-auto">
                        <span class="status-dot" style="background:var(--r6);"></span>
                        {{ $events->total() }} events
                    </span>
                </div>

                <div class="overflow-x-auto">
                    <table class="ev-table min-w-full">
                        <thead style="background:#f8fafc; border-bottom:1px solid #e2e8f0;">
                            <tr>
                                <th>Title</th>
                                <th>Venue</th>
                                <th>Date</th>
                                <th style="text-align:right;">Fee</th>
                                <th>Status</th>
                                <th>Banner</th>
                                @can('edit.event')
                                    <th>Actions</th>
                                @endcan
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($events as $event)
                                <tr>
                                    <td>
                                        <span class="text-sm font-semibold text-slate-900">{{ $event['title'] }}</span>
                                    </td>

                                    <td>
                                        <span class="text-sm text-slate-500">{{ $event['venue'] }}</span>
                                    </td>

                                    <td>
                                        <div class="flex flex-col">
                                            <span class="text-sm text-slate-700">{{ $event['event_date']->format('M d, Y') }}</span>
                                            <span class="text-xs text-slate-400">{{ $event['event_date']->format('h:i A') }}</span>
                                        </div>
                                    </td>

                                    <td style="text-align:right;">
                                        <span class="text-sm font-bold text-slate-900">₱{{ $event['fee_pesos'] }}</span>
                                    </td>

                                    <td>
                                        @if ($event['is_active'])
                                            <span class="status-chip chip-green">
                                                <span class="status-dot" style="background:#065f46;"></span>
                                                Active
                                            </span>
                                        @else
                                            <span class="status-chip chip-slate">
                                                <span class="status-dot" style="background:#94a3b8;"></span>
                                                Inactive
                                            </span>
                                        @endif
                                    </td>

                                    <td>
                                        @if (filled($event['banner_image']))
                                            <span class="status-chip chip-blue">
                                                <span class="status-dot" style="background:var(--r6);"></span>
                                                Has banner
                                            </span>
                                        @else
                                            <span class="status-chip chip-slate">
                                                No banner
                                            </span>
                                        @endif
                                    </td>

                                    @can('edit.event')
                                        <td>
                                            <div class="flex justify-end gap-1.5">
                                                <button
                                                    type="button"
                                                    wire:click="toggleActive({{ $event['id'] }})"
                                                    wire:loading.attr="disabled"
                                                    class="btn-action btn-action-ghost"
                                                >
                                                    {{ $event['is_active'] ? 'Disable' : 'Enable' }}
                                                </button>
                                                <a
                                                    href="{{ route('events.edit', ['event' => $event['slug']]) }}"
                                                    wire:navigate
                                                    class="btn-action btn-action-edit"
                                                >
                                                    Edit
                                                </a>
                                            </div>
                                        </td>
                                    @endcan
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-5 py-14 text-center">
                                        <svg class="mx-auto h-7 w-7" style="color:#cbd5e1;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5"/>
                                        </svg>
                                        <p class="mt-2 text-sm text-slate-400">No events found.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="flex flex-col gap-3 px-5 py-4 text-sm sm:flex-row sm:items-center sm:justify-between"
                     style="border-top:1px solid #f1f5f9;">
                    <p class="text-xs text-slate-400">
                        Showing {{ $events->firstItem() ?? 0 }}–{{ $events->lastItem() ?? 0 }}
                        of {{ $events->total() }}
                    </p>
                    <div class="[&>*]:!shadow-none">
                        {{ $events->links() }}
                    </div>
                </div>
            </section>
        @endif

    </div>
@endcan
</div>
