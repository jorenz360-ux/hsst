<div class="min-h-screen" style="background:#f0f4fb; font-family:'DM Sans',system-ui,sans-serif;">
<style>
    :root { --r9:#0a1f5c;--r8:#0f2a7a;--r7:#153591;--r6:#1a3fa8;--r5:#2150c8;--g5:#c4952a;--g4:#d4a843; }

    .rp-field {
        height:2.375rem;border-radius:.75rem;border:1px solid #e2e8f0;background:#fff;
        padding:0 .875rem;font-size:.8125rem;color:#0f172a;outline:none;
        transition:border-color .15s,box-shadow .15s;width:100%;
    }
    .rp-field::placeholder{color:#94a3b8;}
    .rp-field:hover{border-color:#94a3b8;}
    .rp-field:focus{border-color:var(--r6);box-shadow:0 0 0 3px rgba(26,63,168,.1);}

    .rp-select {
        height:2.375rem;border-radius:.75rem;border:1px solid #e2e8f0;
        background:#fff url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%2394a3b8' stroke-width='2'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' d='M19 9l-7 7-7-7'/%3E%3C/svg%3E") no-repeat right .75rem center/.85rem;
        padding:0 2rem 0 .875rem;font-size:.8125rem;color:#0f172a;outline:none;
        appearance:none;width:100%;cursor:pointer;transition:border-color .15s,box-shadow .15s;
    }
    .rp-select:hover{border-color:#94a3b8;}
    .rp-select:focus{border-color:var(--r6);box-shadow:0 0 0 3px rgba(26,63,168,.1);}

    .rp-label{display:block;font-size:.62rem;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:#64748b;margin-bottom:.3rem;}

    .rp-stat{background:#fff;border:1px solid #e8edf5;border-radius:1.1rem;padding:1.1rem 1.25rem;box-shadow:0 1px 6px rgba(15,23,42,.05);}
    .rp-stat-icon{width:2.1rem;height:2.1rem;border-radius:.55rem;display:flex;align-items:center;justify-content:center;margin-bottom:.75rem;}
    .rp-stat-val{font-size:1.85rem;font-weight:800;letter-spacing:-.03em;line-height:1;color:#0f172a;}
    .rp-stat-lbl{font-size:.65rem;font-weight:700;letter-spacing:.08em;text-transform:uppercase;color:#64748b;margin-bottom:.25rem;}
    .rp-stat-sub{font-size:.7rem;color:#94a3b8;margin-top:.4rem;line-height:1.4;}

    .rp-card{background:#fff;border:1px solid #e8edf5;border-radius:1.1rem;box-shadow:0 1px 6px rgba(15,23,42,.05);overflow:hidden;}
    .rp-card-head{padding:.9rem 1.4rem;border-bottom:1px solid #f1f5f9;display:flex;align-items:center;gap:.65rem;}
    .rp-card-icon{width:1.9rem;height:1.9rem;border-radius:.5rem;display:flex;align-items:center;justify-content:center;flex-shrink:0;}

    .rp-table thead th{font-size:.6rem;font-weight:700;letter-spacing:.12em;text-transform:uppercase;color:#64748b;padding:.65rem 1rem;text-align:left;background:#f8fafc;white-space:nowrap;}
    .rp-table tbody tr{border-bottom:1px solid #f1f5f9;transition:background .1s;}
    .rp-table tbody tr:last-child{border-bottom:none;}
    .rp-table tbody tr:hover{background:#f8faff;}
    .rp-table td{padding:.75rem 1rem;vertical-align:middle;}

    .rp-avatar{width:2rem;height:2rem;border-radius:.5rem;display:flex;align-items:center;justify-content:center;font-size:.65rem;font-weight:800;color:#fff;flex-shrink:0;background:linear-gradient(135deg,var(--r6) 0%,var(--r8) 100%);}

    .chip{display:inline-flex;align-items:center;gap:.28rem;padding:.18rem .55rem;border-radius:999px;font-size:.65rem;font-weight:700;letter-spacing:.03em;white-space:nowrap;}
    .chip-dot{width:.38rem;height:.38rem;border-radius:50%;flex-shrink:0;}
    .chip-green {background:#ecfdf5;color:#065f46;border:1px solid #a7f3d0;}
    .chip-slate {background:#f1f5f9;color:#475569;border:1px solid #e2e8f0;}
    .chip-amber {background:#fffbeb;color:#92700a;border:1px solid #fde68a;}
    .chip-blue  {background:#eef2ff;color:#1a3fa8;border:1px solid #c7d2fe;}
    .chip-purple{background:#f5f3ff;color:#5b21b6;border:1px solid #ddd6fe;}
    .chip-red   {background:#fef2f2;color:#991b1b;border:1px solid #fecaca;}
    .chip-teal  {background:#f0fdfa;color:#0f766e;border:1px solid #99f6e4;}

    .btn-primary{display:inline-flex;align-items:center;gap:.4rem;height:2.375rem;padding:0 1rem;border-radius:.75rem;background:var(--r6);border:none;color:#fff;font-size:.8rem;font-weight:700;cursor:pointer;transition:background .12s;white-space:nowrap;}
    .btn-primary:hover{background:var(--r7);}
    .btn-primary:disabled{background:#94a3b8;cursor:not-allowed;}
    .btn-ghost{display:inline-flex;align-items:center;gap:.4rem;height:2.375rem;padding:0 .875rem;border-radius:.75rem;background:#fff;border:1px solid #e2e8f0;color:#475569;font-size:.8rem;font-weight:600;cursor:pointer;transition:background .12s,border-color .12s;white-space:nowrap;}
    .btn-ghost:hover{background:#f8fafc;border-color:#cbd5e1;color:#1e293b;}
    .btn-export{display:inline-flex;align-items:center;gap:.4rem;height:2.375rem;padding:0 1rem;border-radius:.75rem;background:#059669;border:none;color:#fff;font-size:.8rem;font-weight:700;cursor:pointer;transition:background .12s;white-space:nowrap;}
    .btn-export:hover{background:#047857;}
    .btn-export:disabled{background:#94a3b8;cursor:not-allowed;}
</style>

@php
    $levelMeta = match($currentBatch?->level) {
        'elementary' => ['label'=>'Elementary','bg'=>'#f0fdf4','color'=>'#065f46','border'=>'#bbf7d0'],
        'highschool' => ['label'=>'High School','bg'=>'#fef9ee','color'=>'#92700a','border'=>'#fde68a'],
        'college'    => ['label'=>'College',    'bg'=>'#f5f3ff','color'=>'#5b21b6','border'=>'#ddd6fe'],
        default      => ['label'=>'Batch',      'bg'=>'#f1f5f9','color'=>'#475569','border'=>'#e2e8f0'],
    };
    $totalBatch = $batchSummary['totalCount'] ?? 0;
@endphp

<div class="space-y-5 px-4 py-6 sm:px-6 lg:px-8 mx-auto max-w-screen-xl">

    {{-- ── BATCH SWITCHER (multi-rep only) ────────────────────── --}}
    @if ($repEducations->count() > 1)
    <div style="background:#fff;border:1px solid #e2e8f0;border-radius:.875rem;padding:.6rem 1.1rem;
                display:flex;align-items:center;gap:.75rem;flex-wrap:wrap;">
        <svg style="width:.9rem;height:.9rem;color:#64748b;flex-shrink:0;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z"/>
        </svg>
        <span style="font-size:.65rem;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:#64748b;white-space:nowrap;">Viewing Batch</span>
        <select wire:model.live="selectedBatchId"
                style="height:2rem;border-radius:.6rem;border:1px solid #e2e8f0;background:#f8fafc;
                       padding:0 1.75rem 0 .65rem;font-size:.8rem;color:#0f172a;outline:none;
                       appearance:none;cursor:pointer;flex:1;min-width:180px;max-width:320px;
                       background-image:url(\"data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%2394a3b8' stroke-width='2'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' d='M19 9l-7 7-7-7'/%3E%3C/svg%3E\");
                       background-repeat:no-repeat;background-position:right .5rem center;background-size:.8rem;">
            @foreach ($repEducations as $edu)
            <option value="{{ $edu->batch_id }}">
                {{ ucfirst($edu->batch?->level ?? 'Batch') }} — {{ $edu->batch?->schoolyear }}
                @if ($edu->batch?->yeargrad) ({{ $edu->batch->yeargrad }}) @endif
            </option>
            @endforeach
        </select>
        <span class="chip chip-blue" style="font-size:.6rem;flex-shrink:0;">{{ $repEducations->count() }} batches</span>
    </div>
    @endif

    {{-- ── HEADER ──────────────────────────────────────────────── --}}
    <section class="overflow-hidden rounded-2xl"
             style="background:linear-gradient(155deg,var(--r8) 0%,var(--r7) 45%,var(--r6) 100%);
                    box-shadow:0 8px 32px rgba(10,31,92,.28);position:relative;">
        <span style="position:absolute;right:2rem;top:50%;transform:translateY(-50%);
                     font-family:Georgia,serif;font-size:6rem;font-weight:900;color:#fff;
                     opacity:.025;letter-spacing:.04em;user-select:none;white-space:nowrap;pointer-events:none;">
            REPORTS
        </span>
        <div class="relative px-6 py-6 sm:px-8">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
                <div>
                    <div class="flex flex-wrap items-center gap-2 mb-2">
                        <p class="text-[.65rem] font-bold uppercase tracking-[.22em]" style="color:var(--g4);">
                            HSST Alumni Portal &middot; Batch Representative Panel
                        </p>
                        <span class="chip" style="background:{{ $levelMeta['bg'] }};color:{{ $levelMeta['color'] }};border:1px solid {{ $levelMeta['border'] }};font-size:.58rem;">
                            {{ $levelMeta['label'] }}
                        </span>
                    </div>
                    <h1 class="text-2xl font-black tracking-tight" style="color:#fff;letter-spacing:-.02em;">
                        Batch Reports
                    </h1>
                    <p class="mt-1 text-sm" style="color:rgba(255,255,255,.65);">
                        {{ $currentBatch?->schoolyear }}
                        @if ($currentBatch?->yeargrad) &middot; Graduating Class of {{ $currentBatch->yeargrad }} @endif
                    </p>
                </div>
                <div style="background:rgba(255,255,255,.1);border:1px solid rgba(255,255,255,.18);
                            border-radius:1rem;padding:.75rem 1.25rem;text-align:right;flex-shrink:0;">
                    <p style="font-size:.6rem;font-weight:700;letter-spacing:.12em;text-transform:uppercase;color:rgba(255,255,255,.55);">Batch Members</p>
                    <p style="font-size:2rem;font-weight:900;color:#fff;line-height:1;letter-spacing:-.03em;">{{ $totalBatch }}</p>
                    <p style="font-size:.68rem;color:rgba(255,255,255,.5);margin-top:.2rem;">Total enrolled</p>
                </div>
            </div>
        </div>
    </section>

    {{-- ── BATCH SUMMARY STATS ────────────────────────────────── --}}
    <div class="grid grid-cols-2 gap-3 sm:grid-cols-4">
        <div class="rp-stat">
            <div class="rp-stat-icon" style="background:#eef2ff;">
                <svg style="width:1.1rem;height:1.1rem;color:var(--r6);" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z"/>
                </svg>
            </div>
            <p class="rp-stat-lbl">Total Members</p>
            <p class="rp-stat-val">{{ $batchSummary['totalCount'] }}</p>
            <p class="rp-stat-sub">In your batch</p>
        </div>
        <div class="rp-stat">
            <div class="rp-stat-icon" style="background:#ecfdf5;">
                <svg style="width:1.1rem;height:1.1rem;color:#059669;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                </svg>
            </div>
            <p class="rp-stat-lbl">Registered</p>
            <p class="rp-stat-val" style="color:#059669;">{{ $batchSummary['registeredCount'] }}</p>
            <p class="rp-stat-sub">Have portal accounts</p>
        </div>
        <div class="rp-stat">
            <div class="rp-stat-icon" style="background:#f5f3ff;">
                <svg style="width:1.1rem;height:1.1rem;color:#7c3aed;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.636 50.636 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.903 59.903 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489a50.702 50.702 0 0 1 3.741-3.342M6.75 15a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Zm0 0v-3.675A55.378 55.378 0 0 1 12 8.443m-7.007 11.55A5.981 5.981 0 0 0 6.75 15.75v-1.5"/>
                </svg>
            </div>
            <p class="rp-stat-lbl">Graduated</p>
            <p class="rp-stat-val" style="color:#7c3aed;">{{ $batchSummary['graduatedCount'] }}</p>
            <p class="rp-stat-sub">Completed studies</p>
        </div>
        <div class="rp-stat">
            <div class="rp-stat-icon" style="background:#f1f5f9;">
                <svg style="width:1.1rem;height:1.1rem;color:#94a3b8;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z"/>
                </svg>
            </div>
            <p class="rp-stat-lbl">No Account</p>
            <p class="rp-stat-val" style="color:#94a3b8;">{{ $batchSummary['noAccountCount'] }}</p>
            <p class="rp-stat-sub">Not yet registered</p>
        </div>
    </div>

    {{-- ── VOLUNTEER / COMMITTEE SIGNUPS ──────────────────────── --}}
    @if ($volunteerStats->isNotEmpty())
    <div class="rp-card">
        <div class="rp-card-head">
            <div class="rp-card-icon" style="background:#eef2ff;">
                <svg style="width:1rem;height:1rem;color:var(--r6);" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z"/>
                </svg>
            </div>
            <div>
                <p class="text-sm font-bold" style="color:#1e293b;">Volunteer / Committee Signups</p>
                <p class="text-xs" style="color:#64748b;">Members from your batch who signed up for committees</p>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="rp-table min-w-full">
                <thead>
                    <tr>
                        <th>Committee</th>
                        <th style="text-align:center;">Total Signups</th>
                        <th style="text-align:center;">Approved</th>
                        <th style="text-align:center;">Pending</th>
                        <th style="text-align:center;">Declined</th>
                        <th>Coverage</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($volunteerStats as $vs)
                    <tr>
                        <td>
                            <p class="text-sm font-semibold" style="color:#1e293b;">{{ $vs->committee_name }}</p>
                        </td>
                        <td style="text-align:center;">
                            <span class="text-sm font-bold" style="color:#1e293b;">{{ $vs->total }}</span>
                        </td>
                        <td style="text-align:center;">
                            <span class="chip chip-green">{{ $vs->approved }}</span>
                        </td>
                        <td style="text-align:center;">
                            <span class="chip chip-amber">{{ $vs->pending }}</span>
                        </td>
                        <td style="text-align:center;">
                            <span class="chip chip-red">{{ $vs->declined }}</span>
                        </td>
                        <td style="min-width:120px;">
                            @php $pct = $totalBatch > 0 ? round(($vs->total / $totalBatch) * 100) : 0; @endphp
                            <div style="display:flex;align-items:center;gap:.5rem;">
                                <div style="flex:1;height:.35rem;background:#e2e8f0;border-radius:999px;overflow:hidden;">
                                    <div style="height:100%;width:{{ $pct }}%;background:var(--r6);border-radius:999px;"></div>
                                </div>
                                <span style="font-size:.7rem;color:#64748b;min-width:2rem;">{{ $pct }}%</span>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif

    {{-- ── EVENT PARTICIPANTS REPORT ───────────────────────────── --}}
    <div class="rp-card">
        <div class="rp-card-head" style="justify-content:space-between;flex-wrap:wrap;gap:.75rem;">
            <div style="display:flex;align-items:center;gap:.65rem;">
                <div class="rp-card-icon" style="background:#fffbeb;">
                    <svg style="width:1rem;height:1rem;color:#c4952a;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5"/>
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-bold" style="color:#1e293b;">Event Participants</p>
                    <p class="text-xs" style="color:#64748b;">RSVP & payment tracking per event</p>
                </div>
            </div>
            <div style="display:flex;gap:.5rem;align-items:center;flex-wrap:wrap;">
                <button wire:click="resetEventFilters" class="btn-ghost">
                    <svg style="width:.8rem;height:.8rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99"/>
                    </svg>
                    Reset
                </button>
                <button wire:click="downloadExcel"
                        @disabled($selectedEvent === 'all')
                        class="btn-export">
                    <svg style="width:.8rem;height:.8rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3"/>
                    </svg>
                    Export CSV
                </button>
            </div>
        </div>

        {{-- Filters --}}
        <div style="padding:.9rem 1.4rem;border-bottom:1px solid #f1f5f9;background:#fafbff;">
            <div class="grid grid-cols-1 gap-3 sm:grid-cols-2 lg:grid-cols-4">
                <div>
                    <label class="rp-label">Event</label>
                    <select wire:model.live="selectedEvent" class="rp-select">
                        <option value="all">— Select Event —</option>
                        @foreach ($allEvents as $ev)
                            <option value="{{ $ev->id }}">
                                {{ $ev->title }} · {{ $ev->event_date?->format('M d, Y') }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="rp-label">RSVP Status</label>
                    <select wire:model.live="rsvpStatusFilter" class="rp-select">
                        <option value="all">All</option>
                        <option value="attending">Attending</option>
                        <option value="maybe">Maybe</option>
                        <option value="not_attending">Not Attending</option>
                        <option value="no_response">No Response</option>
                    </select>
                </div>
                <div>
                    <label class="rp-label">Payment Status</label>
                    <select wire:model.live="paymentStatusFilter" class="rp-select">
                        <option value="all">All</option>
                        <option value="paid">Paid</option>
                        <option value="unpaid">Unpaid</option>
                        <option value="waived">Waived</option>
                    </select>
                </div>
                <div>
                    <label class="rp-label">Search</label>
                    <div style="position:relative;">
                        <svg style="position:absolute;left:.65rem;top:50%;transform:translateY(-50%);width:.8rem;height:.8rem;color:#94a3b8;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z"/>
                        </svg>
                        <input type="text"
                               wire:model.live.debounce.300ms="search"
                               placeholder="Search alumni…"
                               class="rp-field" style="padding-left:2.1rem;">
                    </div>
                </div>
            </div>
        </div>

        {{-- Event Stats (visible when an event is selected) --}}
        @if ($selectedEventModel)
        <div style="padding:.9rem 1.4rem;border-bottom:1px solid #f1f5f9;">
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:.75rem;flex-wrap:wrap;gap:.5rem;">
                <p style="font-size:.72rem;font-weight:700;letter-spacing:.08em;text-transform:uppercase;color:#64748b;">
                    {{ $selectedEventModel->title }}
                    @if ($selectedEventModel->event_date)
                        &middot; {{ $selectedEventModel->event_date->format('F d, Y') }}
                    @endif
                    @if ($selectedEventModel->venue)
                        &middot; {{ $selectedEventModel->venue }}
                    @endif
                </p>
                @if (($selectedEventModel->registration_fee ?? 0) > 0)
                    <span class="chip chip-amber">
                        Fee: ₱{{ number_format($selectedEventModel->registration_fee / 100, 2) }}
                    </span>
                @else
                    <span class="chip chip-green">Free Event</span>
                @endif
            </div>

            {{-- RSVP + Payment mini-stats --}}
            <div class="grid grid-cols-2 gap-2 sm:grid-cols-4 lg:grid-cols-7">
                @php
                    $miniStats = [
                        ['label'=>'Attending',    'val'=>$attendingParticipantsCount,    'color'=>'#059669','bg'=>'#ecfdf5'],
                        ['label'=>'Maybe',        'val'=>$maybeParticipantsCount,        'color'=>'#c4952a','bg'=>'#fffbeb'],
                        ['label'=>'Not Attending','val'=>$notAttendingParticipantsCount, 'color'=>'#ef4444','bg'=>'#fef2f2'],
                        ['label'=>'No Response',  'val'=>$noResponseCount,               'color'=>'#94a3b8','bg'=>'#f1f5f9'],
                        ['label'=>'Paid',         'val'=>$paidParticipantsCount,         'color'=>'#059669','bg'=>'#ecfdf5'],
                        ['label'=>'Unpaid',       'val'=>$unpaidParticipantsCount,       'color'=>'#ef4444','bg'=>'#fef2f2'],
                        ['label'=>'Waived',       'val'=>$waivedParticipantsCount,       'color'=>'#7c3aed','bg'=>'#f5f3ff'],
                    ];
                @endphp
                @foreach ($miniStats as $ms)
                <div style="background:{{ $ms['bg'] }};border-radius:.65rem;padding:.5rem .75rem;text-align:center;">
                    <p style="font-size:1.25rem;font-weight:800;color:{{ $ms['color'] }};line-height:1;">{{ $ms['val'] }}</p>
                    <p style="font-size:.58rem;font-weight:700;letter-spacing:.08em;text-transform:uppercase;color:{{ $ms['color'] }};opacity:.7;margin-top:.2rem;">{{ $ms['label'] }}</p>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        {{-- Table --}}
        @if ($selectedEvent === 'all')
        <div style="padding:3rem 1.5rem;text-align:center;">
            <div style="width:3rem;height:3rem;border-radius:.875rem;background:#f0f4fb;border:1px solid #e2e8f0;
                        display:flex;align-items:center;justify-content:center;margin:0 auto .75rem;">
                <svg style="width:1.4rem;height:1.4rem;color:#94a3b8;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5"/>
                </svg>
            </div>
            <p class="text-sm font-semibold" style="color:#1e293b;">Select an Event</p>
            <p class="text-xs mt-1" style="color:#64748b;">Choose an event above to view participant details.</p>
        </div>
        @else
        <div class="overflow-x-auto">
            <table class="rp-table min-w-full">
                <thead>
                    <tr>
                        <th>Member</th>
                        <th>Level</th>
                        <th>RSVP</th>
                        <th>Payment</th>
                        <th>Last Updated</th>
                        <th>Update Payment</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($participants as $p)
                    @php
                        $fullName = trim(
                            ($p->lname ?? '') . ', ' .
                            ($p->fname ?? '') .
                            ($p->mname ? ' ' . $p->mname : '')
                        );
                        $initials = strtoupper(substr($p->fname ?? 'U', 0, 1) . substr($p->lname ?? '', 0, 1));

                        $rsvpMeta = match($p->rsvp_status ?? 'no_response') {
                            'attending'     => ['chip-green',  '#10b981', 'Attending'],
                            'maybe'         => ['chip-amber',  '#c4952a', 'Maybe'],
                            'not_attending' => ['chip-red',    '#ef4444', 'Not Attending'],
                            default         => ['chip-slate',  '#94a3b8', 'No Response'],
                        };
                        $payMeta = match($p->payment_status ?? 'unpaid') {
                            'paid'   => ['chip-green',  '#10b981', 'Paid'],
                            'waived' => ['chip-purple', '#7c3aed', 'Waived'],
                            default  => ['chip-red',    '#ef4444', 'Unpaid'],
                        };
                        [$lvlAbbr, $lvlChip] = match($p->display_level ?? '') {
                            'elementary' => ['ELM', 'chip-green'],
                            'highschool' => ['HS',  'chip-amber'],
                            'college'    => ['COL', 'chip-purple'],
                            default      => ['—',   'chip-slate'],
                        };
                    @endphp
                    <tr>
                        <td style="min-width:180px;">
                            <div style="display:flex;align-items:center;gap:.6rem;">
                                <div class="rp-avatar">{{ $initials }}</div>
                                <p class="text-sm font-semibold" style="color:#1e293b;">{{ $fullName ?: '—' }}</p>
                            </div>
                        </td>
                        <td>
                            <span class="chip {{ $lvlChip }}" style="font-size:.65rem;font-weight:800;">{{ $lvlAbbr }}</span>
                            @if ($p->yeargrad)
                                <p class="text-xs mt-0.5" style="color:#94a3b8;">{{ $p->yeargrad }}</p>
                            @endif
                        </td>
                        <td>
                            <span class="chip {{ $rsvpMeta[0] }}">
                                <span class="chip-dot" style="background:{{ $rsvpMeta[1] }};"></span>
                                {{ $rsvpMeta[2] }}
                            </span>
                        </td>
                        <td>
                            <span class="chip {{ $payMeta[0] }}">
                                <span class="chip-dot" style="background:{{ $payMeta[1] }};"></span>
                                {{ $payMeta[2] }}
                            </span>
                        </td>
                        <td>
                            <p class="text-xs" style="color:#94a3b8;">
                                {{ $p->payment_updated_at
                                    ? \Carbon\Carbon::parse($p->payment_updated_at)->format('M d, Y h:i A')
                                    : '—' }}
                            </p>
                        </td>
                        <td>
                            <select wire:change="updatePaymentStatus({{ $p->id }}, $event.target.value)"
                                    style="height:1.9rem;border-radius:.5rem;border:1px solid #e2e8f0;
                                           background:#fff;padding:0 1.5rem 0 .6rem;font-size:.75rem;
                                           color:#0f172a;outline:none;cursor:pointer;appearance:none;
                                           background-image:url(\"data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%2394a3b8' stroke-width='2'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' d='M19 9l-7 7-7-7'/%3E%3C/svg%3E\");
                                           background-repeat:no-repeat;background-position:right .4rem center;background-size:.75rem;">
                                <option value="unpaid"  @selected(($p->payment_status ?? 'unpaid') === 'unpaid')>Unpaid</option>
                                <option value="paid"    @selected(($p->payment_status ?? '') === 'paid')>Paid</option>
                                <option value="waived"  @selected(($p->payment_status ?? '') === 'waived')>Waived</option>
                            </select>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" style="padding:3rem 1.5rem;text-align:center;">
                            <p class="text-sm font-semibold" style="color:#1e293b;">No records found</p>
                            <p class="text-xs mt-1" style="color:#64748b;">Try adjusting your filters.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($participants->hasPages())
        <div style="padding:.85rem 1.2rem;border-top:1px solid #f1f5f9;background:#fafbff;">
            {{ $participants->links() }}
        </div>
        @endif
        @endif

    </div>

</div>
</div>
