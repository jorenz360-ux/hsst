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

    /* ── Stat cards ─────────────────────────────────────────── */
    .brd-stat {
        background: #fff;
        border: 1px solid #e8edf5;
        border-radius: 1.1rem;
        padding: 1.25rem 1.4rem;
        box-shadow: 0 1px 6px rgba(15,23,42,.05);
        position: relative;
        overflow: hidden;
    }
    .brd-stat-icon {
        width: 2.4rem; height: 2.4rem; border-radius: .65rem;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0; margin-bottom: .9rem;
    }
    .brd-stat-val {
        font-size: 2rem; font-weight: 800;
        letter-spacing: -.03em; line-height: 1;
        color: #0f172a;
    }
    .brd-stat-label {
        font-size: .72rem; font-weight: 700;
        letter-spacing: .08em; text-transform: uppercase;
        color: #64748b; margin-bottom: .3rem;
    }
    .brd-stat-sub {
        font-size: .72rem; color: #94a3b8; margin-top: .5rem; line-height: 1.5;
    }

    /* ── Section cards ──────────────────────────────────────── */
    .brd-card {
        background: #fff;
        border: 1px solid #e8edf5;
        border-radius: 1.1rem;
        box-shadow: 0 1px 6px rgba(15,23,42,.05);
        overflow: hidden;
    }
    .brd-card-head {
        padding: 1rem 1.4rem;
        border-bottom: 1px solid #f1f5f9;
        display: flex; align-items: center; gap: .7rem;
    }
    .brd-card-icon {
        width: 1.9rem; height: 1.9rem; border-radius: .5rem;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }

    /* ── Table ──────────────────────────────────────────────── */
    .brd-table thead th {
        font-size: .62rem; font-weight: 700;
        letter-spacing: .12em; text-transform: uppercase;
        color: #64748b; padding: .65rem 1.2rem;
        text-align: left; white-space: nowrap;
        background: #f8fafc;
    }
    .brd-table tbody tr {
        border-bottom: 1px solid #f1f5f9;
        transition: background .1s;
    }
    .brd-table tbody tr:last-child { border-bottom: none; }
    .brd-table tbody tr:hover { background: #f8faff; }
    .brd-table td { padding: .8rem 1.2rem; vertical-align: middle; }

    /* ── Chips ──────────────────────────────────────────────── */
    .chip {
        display: inline-flex; align-items: center; gap: .3rem;
        padding: .2rem .6rem; border-radius: 999px;
        font-size: .67rem; font-weight: 700;
        letter-spacing: .04em; white-space: nowrap;
    }
    .chip-dot { width: .4rem; height: .4rem; border-radius: 50%; flex-shrink: 0; }
    .chip-green  { background:#ecfdf5; color:#065f46; border:1px solid #a7f3d0; }
    .chip-slate  { background:#f1f5f9; color:#475569; border:1px solid #e2e8f0; }
    .chip-amber  { background:#fffbeb; color:#92700a; border:1px solid #fde68a; }
    .chip-blue   { background:#eef2ff; color:#1a3fa8; border:1px solid #c7d2fe; }
    .chip-purple { background:#f5f3ff; color:#5b21b6; border:1px solid #ddd6fe; }
    .chip-red    { background:#fef2f2; color:#991b1b; border:1px solid #fecaca; }

    /* ── Level badge ────────────────────────────────────────── */
    .lvl-elem   { background:#f0fdf4; color:#065f46;  border:1px solid #bbf7d0; }
    .lvl-hs     { background:#fef9ee; color:#92700a;  border:1px solid #fde68a; }
    .lvl-col    { background:#f5f3ff; color:#5b21b6;  border:1px solid #ddd6fe; }

    /* ── Avatar ─────────────────────────────────────────────── */
    .brd-avatar {
        width: 2rem; height: 2rem; border-radius: .5rem;
        display: flex; align-items: center; justify-content: center;
        font-size: .68rem; font-weight: 800; color: #fff; flex-shrink: 0;
        background: linear-gradient(135deg, var(--r6) 0%, var(--r8) 100%);
        letter-spacing: .04em;
    }

    /* ── Event row ──────────────────────────────────────────── */
    .event-row {
        padding: .9rem 1.4rem;
        border-bottom: 1px solid #f1f5f9;
        display: flex; align-items: flex-start; justify-content: space-between;
        gap: 1rem;
        transition: background .1s;
    }
    .event-row:last-child { border-bottom: none; }
    .event-row:hover { background: #f8faff; }

    /* ── Announcement row ───────────────────────────────────── */
    .ann-row {
        padding: .9rem 1.4rem;
        border-bottom: 1px solid #f1f5f9;
    }
    .ann-row:last-child { border-bottom: none; }
</style>

@php
    $levelMeta = match($currentBatch?->level) {
        'elementary' => ['label' => 'Elementary',  'class' => 'lvl-elem'],
        'highschool' => ['label' => 'High School', 'class' => 'lvl-hs'],
        'college'    => ['label' => 'College',     'class' => 'lvl-col'],
        default      => ['label' => 'Batch',       'class' => 'chip-slate'],
    };
    $registrationRate = $batchAlumniCount > 0
        ? round(($registeredUsersCount / $batchAlumniCount) * 100)
        : 0;
    $responseRate = $registeredUsersCount > 0
        ? round(($respondedMembersCount / max($batchAlumniCount, 1)) * 100)
        : 0;
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
                    box-shadow:0 8px 32px rgba(10,31,92,.28); position:relative;">

        {{-- Watermark --}}
        <span style="position:absolute;right:2rem;top:50%;transform:translateY(-50%);
                     font-family:Georgia,serif;font-size:6rem;font-weight:900;color:#fff;
                     opacity:.025;letter-spacing:.04em;user-select:none;white-space:nowrap;pointer-events:none;">
            BATCH REP
        </span>

        <div class="relative px-6 py-6 sm:px-8">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
                <div>
                    <div class="flex flex-wrap items-center gap-2 mb-2">
                        <p class="text-[.65rem] font-bold uppercase tracking-[.22em]" style="color:var(--g4);">
                            HSST Alumni Portal
                        </p>
                        @if ($currentBatch)
                            <span class="chip {{ $levelMeta['class'] }}" style="font-size:.6rem;">
                                {{ $levelMeta['label'] }}
                            </span>
                        @endif
                    </div>
                    <h1 class="text-2xl font-bold tracking-tight text-white sm:text-3xl"
                        style="font-family:Georgia,serif;letter-spacing:-.01em;">
                        Batch Representative
                        @if ($currentBatch)
                            &mdash; {{ $currentBatch->schoolyear }}
                        @endif
                    </h1>
                    <p class="mt-1.5 text-sm leading-6" style="color:rgba(255,255,255,.6);max-width:50ch;">
                        Monitor your batch members, track attendance responses, and stay updated with upcoming events and announcements.
                    </p>
                </div>

                {{-- Batch info pill --}}
                @if ($currentBatch)
                    <div class="sm:mt-1 sm:shrink-0 flex flex-col items-start sm:items-end gap-1.5">
                        <div style="background:rgba(255,255,255,.1);border:1px solid rgba(255,255,255,.18);
                                    border-radius:.875rem;padding:.5rem 1rem;">
                            <p class="text-[.6rem] font-bold uppercase tracking-widest" style="color:rgba(255,255,255,.5);">Grad Year</p>
                            <p class="text-xl font-bold text-white" style="font-family:Georgia,serif;">{{ $currentBatch->yeargrad }}</p>
                        </div>
                    </div>
                @endif
            </div>

            {{-- KPI strip --}}
            <div class="mt-5 flex flex-wrap items-center gap-3 pt-5"
                 style="border-top:1px solid rgba(255,255,255,.12);">
                @foreach ([
                    ['Total Alumni',     $batchAlumniCount,       'rgba(255,255,255,.14)', '#fff'],
                    ['Registered',       $registeredUsersCount,   'rgba(16,185,129,.14)',  '#6ee7b7'],
                    ['Responded',        $respondedMembersCount,  'rgba(196,149,42,.14)',  'var(--g4)'],
                    ['Pending RSVP',     $membersWithoutRsvpCount,'rgba(239,68,68,.12)',   '#fca5a5'],
                    ['Upcoming Events',  $upcomingEventsCount,    'rgba(139,92,246,.14)',  '#c4b5fd'],
                ] as [$lbl, $val, $bg, $col])
                    <div style="background:{{ $bg }};border:1px solid {{ $col }}33;
                                border-radius:999px;padding:.3rem .9rem;display:inline-flex;align-items:center;gap:.5rem;">
                        <span style="font-size:.68rem;font-weight:700;color:{{ $col }};opacity:.8;">{{ $lbl }}</span>
                        <strong style="font-size:.8rem;color:{{ $col }};">{{ $val }}</strong>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ── KPI CARDS ────────────────────────────────────────────── --}}
    <div class="grid grid-cols-2 gap-4 sm:grid-cols-2 lg:grid-cols-4">

        {{-- Total Alumni --}}
        <div class="brd-stat">
            <div class="brd-stat-icon" style="background:#eef2ff;">
                <svg class="w-5 h-5" style="color:var(--r6);" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z"/>
                </svg>
            </div>
            <p class="brd-stat-label">Total Alumni</p>
            <p class="brd-stat-val">{{ $batchAlumniCount }}</p>
            <p class="brd-stat-sub">Members listed under your batch.</p>
        </div>

        {{-- Registered --}}
        <div class="brd-stat">
            <div class="brd-stat-icon" style="background:#ecfdf5;">
                <svg class="w-5 h-5" style="color:#059669;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 0 1-1.043 3.296 3.745 3.745 0 0 1-3.296 1.043A3.745 3.745 0 0 1 12 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 0 1-3.296-1.043 3.745 3.745 0 0 1-1.043-3.296A3.745 3.745 0 0 1 3 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 0 1 1.043-3.296 3.746 3.746 0 0 1 3.296-1.043A3.746 3.746 0 0 1 12 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 0 1 3.296 1.043 3.746 3.746 0 0 1 1.043 3.296A3.745 3.745 0 0 1 21 12Z"/>
                </svg>
            </div>
            <p class="brd-stat-label">Registered</p>
            <p class="brd-stat-val" style="color:#059669;">{{ $registeredUsersCount }}</p>
            <p class="brd-stat-sub">
                {{ $registrationRate }}% registration rate.
            </p>
        </div>

        {{-- Responded --}}
        <div class="brd-stat">
            <div class="brd-stat-icon" style="background:#fffbeb;">
                <svg class="w-5 h-5" style="color:#d97706;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5"/>
                </svg>
            </div>
            <p class="brd-stat-label">RSVP Responded</p>
            <p class="brd-stat-val" style="color:#d97706;">{{ $respondedMembersCount }}</p>
            <p class="brd-stat-sub">Confirmed attendance for an event.</p>
        </div>

        {{-- Pending --}}
        <div class="brd-stat">
            <div class="brd-stat-icon" style="background:#fef2f2;">
                <svg class="w-5 h-5" style="color:#dc2626;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z"/>
                </svg>
            </div>
            <p class="brd-stat-label">Pending RSVP</p>
            <p class="brd-stat-val" style="color:#dc2626;">{{ $membersWithoutRsvpCount }}</p>
            <p class="brd-stat-sub">Still need to confirm attendance.</p>
        </div>
    </div>

    {{-- ── MAIN GRID ────────────────────────────────────────────── --}}
    <div class="grid grid-cols-1 gap-5 xl:grid-cols-3">

        {{-- Batch Members Table (2/3 width) --}}
        <div class="brd-card xl:col-span-2">
            <div class="brd-card-head">
                <div class="brd-card-icon" style="background:#eef2ff;">
                    <svg class="w-3.5 h-3.5" style="color:var(--r6);" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z"/>
                    </svg>
                </div>
                <div class="flex-1">
                    <p class="text-sm font-bold" style="color:#1e293b;">Batch Members</p>
                    <p class="text-xs" style="color:#64748b;">Account status and contact details for your batch.</p>
                </div>
                <span class="chip chip-blue" style="font-size:.6rem;">
                    Top {{ min($batchAlumniCount, 10) }} of {{ $batchAlumniCount }}
                </span>
            </div>

            <div class="overflow-x-auto">
                <table class="brd-table min-w-full">
                    <thead>
                        <tr>
                            <th>Member</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Account</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($batchMembers as $member)
                            @php
                                $alumni   = $member->alumni;
                                $initials = strtoupper(substr($alumni->fname ?? 'U', 0, 1) . substr($alumni->lname ?? '', 0, 1));
                                $fullName = trim(($alumni->lname ?? '') . ', ' . ($alumni->fname ?? ''));
                            @endphp
                            <tr>
                                <td style="min-width:180px;">
                                    <div class="flex items-center gap-2.5">
                                        <div class="brd-avatar">{{ $initials }}</div>
                                        <div>
                                            <p class="text-sm font-semibold leading-tight" style="color:#1e293b;">
                                                {{ $fullName }}
                                            </p>
                                            @if ($member->is_batch_rep)
                                                <span class="chip chip-amber" style="font-size:.58rem;margin-top:.2rem;">
                                                    <span class="chip-dot" style="background:#c4952a;"></span>
                                                    Rep
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td style="min-width:140px;">
                                    <span class="text-sm font-mono" style="color:#334155;">
                                        {{ $alumni->user?->username ?? '-' }}
                                    </span>
                                </td>
                                <td style="min-width:180px;">
                                    <span class="text-sm" style="color:#475569;">
                                        {{ $alumni->user?->email ?? '-' }}
                                    </span>
                                </td>
                                <td>
                                    @if ($alumni->user)
                                        <span class="chip chip-green">
                                            <span class="chip-dot" style="background:#10b981;"></span>
                                            Registered
                                        </span>
                                    @else
                                        <span class="chip chip-slate">
                                            <span class="chip-dot" style="background:#94a3b8;"></span>
                                            No Account
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" style="padding:3.5rem 1.5rem; text-align:center;">
                                    <p class="text-sm" style="color:#94a3b8;">No batch members found.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Right sidebar: Events + Announcements --}}
        <div class="space-y-5">

            {{-- Upcoming Events --}}
            <div class="brd-card">
                <div class="brd-card-head">
                    <div class="brd-card-icon" style="background:#fffbeb;">
                        <svg class="w-3.5 h-3.5" style="color:#d97706;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-bold" style="color:#1e293b;">Upcoming Events</p>
                        <p class="text-xs" style="color:#64748b;">Active events your batch can join.</p>
                    </div>
                    <span class="chip chip-amber ml-auto" style="font-size:.6rem;">{{ $upcomingEventsCount }}</span>
                </div>

                @forelse ($upcomingEvents as $event)
                    <a href="{{ route('alumni.events.show', $event) }}" wire:navigate class="event-row" style="text-decoration:none;display:flex;">
                        <div class="min-w-0 flex-1">
                            <p class="text-sm font-semibold leading-snug truncate" style="color:#1e293b;">
                                {{ $event->title }}
                            </p>
                            @if ($event->venue)
                                <p class="text-xs mt-0.5 truncate" style="color:#64748b;">
                                    <svg class="inline w-3 h-3 mr-0.5 -mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z"/>
                                    </svg>
                                    {{ $event->venue }}
                                </p>
                            @endif
                        </div>
                        <div class="shrink-0 text-right">
                            <p class="text-xs font-semibold" style="color:var(--r6);">
                                {{ \Carbon\Carbon::parse($event->event_date)->format('M d') }}
                            </p>
                            <p class="text-xs" style="color:#94a3b8;">
                                {{ \Carbon\Carbon::parse($event->event_date)->format('Y') }}
                            </p>
                        </div>
                    </a>
                @empty
                    <div style="padding:2.5rem 1.4rem; text-align:center;">
                        <p class="text-sm" style="color:#94a3b8;">No upcoming events.</p>
                    </div>
                @endforelse
            </div>

            {{-- Announcements --}}
            <div class="brd-card">
                <div class="brd-card-head">
                    <div class="brd-card-icon" style="background:#f5f3ff;">
                        <svg class="w-3.5 h-3.5" style="color:#7c3aed;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10.34 15.84c-.688-.06-1.386-.09-2.09-.09H7.5a4.5 4.5 0 1 1 0-9h.75c.704 0 1.402-.03 2.09-.09m0 9.18c.253.962.584 1.892.985 2.783.247.55.06 1.21-.463 1.511l-.657.38c-.551.318-1.26.117-1.527-.461a20.845 20.845 0 0 1-1.44-4.282m3.102.069a18.03 18.03 0 0 1-.59-4.59c0-1.586.205-3.124.59-4.59m0 9.18a23.848 23.848 0 0 1 8.835 2.535M10.34 6.66a23.847 23.847 0 0 1 8.835-2.535m0 0A23.74 23.74 0 0 1 18.795 3m.38 1.125a23.91 23.91 0 0 1 1.014 5.395m-1.014 8.855c-.118.38-.245.754-.38 1.125m.38-1.125a23.91 23.91 0 0 0 1.014-5.395m-1.394 0a23.74 23.74 0 0 0-8.835-2.535"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-bold" style="color:#1e293b;">Announcements</p>
                        <p class="text-xs" style="color:#64748b;">Latest reminders for your batch.</p>
                    </div>
                </div>

                @forelse ($announcements as $announcement)
                    <div class="ann-row">
                        <div class="flex items-start gap-2">
                            @if ($announcement->pinned)
                                <svg class="mt-0.5 w-3.5 h-3.5 shrink-0" style="color:var(--g5);" fill="currentColor" viewBox="0 0 24 24">
                                    <path fill-rule="evenodd" d="M6.32 2.577a49.255 49.255 0 0 1 11.36 0c1.497.174 2.57 1.46 2.57 2.93V21a.75.75 0 0 1-1.085.67L12 18.089l-7.165 3.583A.75.75 0 0 1 3.75 21V5.507c0-1.47 1.073-2.756 2.57-2.93Z" clip-rule="evenodd"/>
                                </svg>
                            @endif
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-semibold leading-snug" style="color:#1e293b;">
                                    {{ $announcement->title }}
                                </p>
                                <p class="text-xs mt-1 line-clamp-2 leading-relaxed" style="color:#64748b;">
                                    {{ $announcement->content }}
                                </p>
                                <p class="text-[.65rem] mt-1.5" style="color:#94a3b8;">
                                    {{ ($announcement->published_at
                                        ? \Carbon\Carbon::parse($announcement->published_at)
                                        : $announcement->created_at)->format('M d, Y') }}
                                </p>
                            </div>
                        </div>
                    </div>
                @empty
                    <div style="padding:2.5rem 1.4rem; text-align:center;">
                        <p class="text-sm" style="color:#94a3b8;">No announcements available.</p>
                    </div>
                @endforelse
            </div>

        </div>
    </div>

    {{-- ── REMINDER BANNER ──────────────────────────────────────── --}}
    <div class="brd-card">
        <div style="padding:1.25rem 1.5rem; display:flex; align-items:flex-start; gap:1rem;">
            <div style="width:2.2rem;height:2.2rem;border-radius:.6rem;background:#eef2ff;
                        display:flex;align-items:center;justify-content:center;flex-shrink:0;margin-top:.1rem;">
                <svg class="w-4 h-4" style="color:var(--r6);" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z"/>
                </svg>
            </div>
            <div>
                <p class="text-sm font-bold" style="color:#1e293b;">Batch Representative Reminder</p>
                <p class="mt-1 text-sm leading-relaxed" style="color:#64748b;">
                    Use this dashboard to coordinate attendance and monitor participation from your batch.
                    Payment collection, if needed for certain events, may be coordinated outside the system
                    and followed up manually with your batch members.
                </p>
            </div>
        </div>
    </div>

</div>
</div>
