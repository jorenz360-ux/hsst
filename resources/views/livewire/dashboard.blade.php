<div>
<div class="min-h-screen" style="background:#f0f4ff;">
  <div class="space-y-6 p-5 md:p-7">

    {{-- ══════════════════════════════════════
         CONTROL HEADER
    ══════════════════════════════════════ --}}
    <section class="overflow-hidden rounded-xl shadow-md" style="background:linear-gradient(135deg,#091852 0%,#0f2580 55%,#1a3fc4 100%);">
      <div class="relative px-6 py-6 md:px-8 md:py-7">

        {{-- Subtle decorative text --}}
        <div class="pointer-events-none absolute inset-0 flex items-center justify-end overflow-hidden pr-8 opacity-[.04]">
          <span style="font-family:'Georgia',serif;font-size:8rem;font-weight:900;color:#fff;white-space:nowrap;line-height:1;">HSST</span>
        </div>

        <div class="relative flex flex-col gap-5 lg:flex-row lg:items-center lg:justify-between">
          <div>
            <p class="text-[.65rem] font-bold tracking-[.24em] uppercase" style="color:#c4960a;">HSSTian Alumni Association · Admin Panel</p>
            <h1 class="mt-2 text-2xl font-bold tracking-tight text-white md:text-3xl" style="font-family:'Georgia',serif;letter-spacing:-.01em;">
              Admin Dashboard
            </h1>
            <p class="mt-1.5 text-sm" style="color:rgba(255,255,255,.45);">
              Manage donations, alumni records, events, and announcements from one central workspace.
            </p>
          </div>

          <div class="flex flex-wrap gap-2.5 shrink-0">
            <a href="#"
               class="inline-flex items-center gap-2 rounded px-4 py-2.5 text-xs font-bold text-white transition hover:opacity-80"
               style="background:rgba(255,255,255,.12);border:1px solid rgba(255,255,255,.18);letter-spacing:.1em;text-transform:uppercase;">
              <flux:icon name="plus" class="h-3.5 w-3.5"/>
              Create Event
            </a>
            <a href="#"
               class="inline-flex items-center gap-2 rounded px-4 py-2.5 text-xs font-bold text-white transition hover:opacity-80"
               style="background:rgba(255,255,255,.12);border:1px solid rgba(255,255,255,.18);letter-spacing:.1em;text-transform:uppercase;">
              <flux:icon name="megaphone" class="h-3.5 w-3.5"/>
              Post Announcement
            </a>
            <a href="#"
               class="inline-flex items-center gap-2 rounded px-4 py-2.5 text-xs font-bold transition hover:opacity-90"
               style="background:#c4960a;color:#fff;border:1px solid #a07a08;letter-spacing:.1em;text-transform:uppercase;">
              <flux:icon name="banknotes" class="h-3.5 w-3.5"/>
              Verify Donations
            </a>
          </div>
        </div>

      </div>
    </section>

    {{-- ══════════════════════════════════════
         KPI OVERVIEW ROW
    ══════════════════════════════════════ --}}
    <section class="grid gap-3 grid-cols-2 sm:grid-cols-3 xl:grid-cols-6">

      {{-- Total Donations --}}
      <div class="rounded-lg bg-white p-4 shadow-sm" style="border:1px solid rgba(26,63,196,.1);border-left:3px solid #1a3fc4;">
        <div class="flex items-start justify-between gap-2">
          <div class="min-w-0">
            <p class="text-[.65rem] font-bold uppercase tracking-[.18em] text-slate-400">Total Donations</p>
            <p class="mt-1.5 text-xl font-bold text-slate-900 leading-none">₱{{ number_format($allDonationsTotal) }}</p>
            <p class="mt-1.5 text-[.7rem] font-medium" style="color:#1a3fc4;">All confirmed gifts</p>
          </div>
          <div class="w-8 h-8 rounded flex items-center justify-center shrink-0" style="background:#eef2ff;">
            <flux:icon name="banknotes" class="h-4 w-4" style="color:#1a3fc4;"/>
          </div>
        </div>
      </div>

      {{-- This Month --}}
      <div class="rounded-lg bg-white p-4 shadow-sm" style="border:1px solid rgba(196,150,10,.15);border-left:3px solid #c4960a;">
        <div class="flex items-start justify-between gap-2">
          <div class="min-w-0">
            <p class="text-[.65rem] font-bold uppercase tracking-[.18em] text-slate-400">This Month</p>
            <p class="mt-1.5 text-xl font-bold text-slate-900 leading-none">₱{{ number_format($donationsThisMonth) }}</p>
            <p class="mt-1.5 text-[.7rem] font-medium" style="color:#c4960a;">{{ now()->format('F Y') }}</p>
          </div>
          <div class="w-8 h-8 rounded flex items-center justify-center shrink-0" style="background:#fdf3d7;">
            <flux:icon name="arrow-trending-up" class="h-4 w-4" style="color:#c4960a;"/>
          </div>
        </div>
      </div>

      {{-- Alumni --}}
      <div class="rounded-lg bg-white p-4 shadow-sm" style="border:1px solid rgba(26,63,196,.1);border-left:3px solid #0a7c68;">
        <div class="flex items-start justify-between gap-2">
          <div class="min-w-0">
            <p class="text-[.65rem] font-bold uppercase tracking-[.18em] text-slate-400">Alumni</p>
            <p class="mt-1.5 text-xl font-bold text-slate-900 leading-none">{{ number_format($totalAlumni) }}</p>
            <p class="mt-1.5 text-[.7rem] font-medium" style="color:#0a7c68;">Registered profiles</p>
          </div>
          <div class="w-8 h-8 rounded flex items-center justify-center shrink-0" style="background:#d4f0eb;">
            <flux:icon name="users" class="h-4 w-4" style="color:#0a7c68;"/>
          </div>
        </div>
      </div>

      {{-- Upcoming Events --}}
      <div class="rounded-lg bg-white p-4 shadow-sm" style="border:1px solid rgba(26,63,196,.1);border-left:3px solid #7c3aed;">
        <div class="flex items-start justify-between gap-2">
          <div class="min-w-0">
            <p class="text-[.65rem] font-bold uppercase tracking-[.18em] text-slate-400">Events</p>
            <p class="mt-1.5 text-xl font-bold text-slate-900 leading-none">{{ $upcomingEventsCount }}</p>
            <p class="mt-1.5 text-[.7rem] font-medium" style="color:#7c3aed;">Upcoming scheduled</p>
          </div>
          <div class="w-8 h-8 rounded flex items-center justify-center shrink-0" style="background:#f5f3ff;">
            <flux:icon name="calendar-days" class="h-4 w-4" style="color:#7c3aed;"/>
          </div>
        </div>
      </div>

      {{-- Announcements --}}
      <div class="rounded-lg bg-white p-4 shadow-sm" style="border:1px solid rgba(26,63,196,.1);border-left:3px solid #0ea5e9;">
        <div class="flex items-start justify-between gap-2">
          <div class="min-w-0">
            <p class="text-[.65rem] font-bold uppercase tracking-[.18em] text-slate-400">Announcements</p>
            <p class="mt-1.5 text-xl font-bold text-slate-900 leading-none">{{ $publishedAnnouncementsCount }}</p>
            <p class="mt-1.5 text-[.7rem] font-medium" style="color:#0ea5e9;">Live &amp; visible</p>
          </div>
          <div class="w-8 h-8 rounded flex items-center justify-center shrink-0" style="background:#e0f2fe;">
            <flux:icon name="megaphone" class="h-4 w-4" style="color:#0ea5e9;"/>
          </div>
        </div>
      </div>

      {{-- Users --}}
      <div class="rounded-lg bg-white p-4 shadow-sm" style="border:1px solid rgba(26,63,196,.1);border-left:3px solid #64748b;">
        <div class="flex items-start justify-between gap-2">
          <div class="min-w-0">
            <p class="text-[.65rem] font-bold uppercase tracking-[.18em] text-slate-400">Users</p>
            <p class="mt-1.5 text-xl font-bold text-slate-900 leading-none">{{ number_format($totalUsers) }}</p>
            <p class="mt-1.5 text-[.7rem] font-medium text-slate-400">System accounts</p>
          </div>
          <div class="w-8 h-8 rounded flex items-center justify-center shrink-0 bg-slate-100">
            <flux:icon name="user-circle" class="h-4 w-4 text-slate-500"/>
          </div>
        </div>
      </div>

    </section>

    {{-- ══════════════════════════════════════
         PRIORITY ACTION PANEL
    ══════════════════════════════════════ --}}
    <section class="rounded-lg overflow-hidden shadow-sm" style="border:1px solid rgba(196,150,10,.25);background:linear-gradient(135deg,#fffbeb,#fdf3d7 80%);">
      <div class="flex items-center gap-3 px-5 py-3.5" style="background:rgba(196,150,10,.1);border-bottom:1px solid rgba(196,150,10,.2);">
        <div class="w-6 h-6 rounded flex items-center justify-center" style="background:#c4960a;">
          <flux:icon name="exclamation-triangle" class="h-3.5 w-3.5 text-white"/>
        </div>
        <p class="text-xs font-bold uppercase tracking-[.18em]" style="color:#92700a;">Priority Actions · Needs Your Attention</p>
      </div>
      <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-0 divide-y sm:divide-y-0 sm:divide-x" style="divide-color:rgba(196,150,10,.2);">

        <a href="#"
           class="flex items-center gap-3 px-5 py-4 hover:bg-amber-50/50 transition-colors group">
          <div class="w-9 h-9 rounded flex items-center justify-center shrink-0" style="background:rgba(196,150,10,.15);">
            <flux:icon name="clock" class="h-4.5 w-4.5" style="color:#c4960a;"/>
          </div>
          <div>
            <p class="text-xs font-bold uppercase tracking-[.12em] text-slate-400">Donations</p>
            <p class="text-base font-bold text-slate-800 group-hover:text-amber-700 transition-colors">Verify Records</p>
          </div>
          <flux:icon name="chevron-right" class="h-4 w-4 text-slate-300 ml-auto group-hover:text-amber-500 transition-colors"/>
        </a>

        <a href="#"
           class="flex items-center gap-3 px-5 py-4 hover:bg-amber-50/50 transition-colors group">
          <div class="w-9 h-9 rounded flex items-center justify-center shrink-0" style="background:rgba(26,63,196,.1);">
            <flux:icon name="identification" class="h-4.5 w-4.5" style="color:#1a3fc4;"/>
          </div>
          <div>
            <p class="text-xs font-bold uppercase tracking-[.12em] text-slate-400">Alumni</p>
            <p class="text-base font-bold text-slate-800 group-hover:text-blue-700 transition-colors">Review Profiles</p>
          </div>
          <flux:icon name="chevron-right" class="h-4 w-4 text-slate-300 ml-auto group-hover:text-blue-500 transition-colors"/>
        </a>

        <a href="#"
           class="flex items-center gap-3 px-5 py-4 hover:bg-amber-50/50 transition-colors group">
          <div class="w-9 h-9 rounded flex items-center justify-center shrink-0" style="background:rgba(14,165,233,.1);">
            <flux:icon name="document-text" class="h-4.5 w-4.5" style="color:#0ea5e9;"/>
          </div>
          <div>
            <p class="text-xs font-bold uppercase tracking-[.12em] text-slate-400">Announcements</p>
            <p class="text-base font-bold text-slate-800 group-hover:text-sky-700 transition-colors">
              @php $draftCount = $recentAnnouncements->where('is_published', false)->count(); @endphp
              {{ $draftCount > 0 ? $draftCount . ' Draft' . ($draftCount > 1 ? 's' : '') : 'All Published' }}
            </p>
          </div>
          <flux:icon name="chevron-right" class="h-4 w-4 text-slate-300 ml-auto group-hover:text-sky-500 transition-colors"/>
        </a>

        <a href="#"
           class="flex items-center gap-3 px-5 py-4 hover:bg-amber-50/50 transition-colors group">
          <div class="w-9 h-9 rounded flex items-center justify-center shrink-0" style="background:rgba(124,58,237,.1);">
            <flux:icon name="calendar-days" class="h-4.5 w-4.5" style="color:#7c3aed;"/>
          </div>
          <div>
            <p class="text-xs font-bold uppercase tracking-[.12em] text-slate-400">Events</p>
            <p class="text-base font-bold text-slate-800 group-hover:text-violet-700 transition-colors">{{ $upcomingEventsCount }} Upcoming</p>
          </div>
          <flux:icon name="chevron-right" class="h-4 w-4 text-slate-300 ml-auto group-hover:text-violet-500 transition-colors"/>
        </a>

      </div>
    </section>

    {{-- ══════════════════════════════════════
         MAIN CONTENT GRID
    ══════════════════════════════════════ --}}
    <div class="grid gap-6 xl:grid-cols-[1.4fr_0.6fr]">

      {{-- LEFT: Tables --}}
      <div class="space-y-6">

        {{-- Recent Payments --}}
        <section class="overflow-hidden rounded-lg bg-white shadow-sm" style="border:1px solid rgba(26,63,196,.1);">
          <div class="flex items-center justify-between px-5 py-4" style="border-bottom:1px solid rgba(26,63,196,.08);">
            <div>
              <p class="text-[.62rem] font-bold uppercase tracking-[.18em]" style="color:#c4960a;">Latest Confirmed</p>
              <h2 class="mt-0.5 text-base font-bold text-slate-900">Recent Payments</h2>
            </div>
            <a href="#"
               class="text-[.65rem] font-bold uppercase tracking-[.12em] transition hover:opacity-70"
               style="color:#1a3fc4;">
              View All →
            </a>
          </div>

          <div class="overflow-x-auto">
            <table class="w-full text-left">
              <thead style="background:#f4f7ff;border-bottom:1px solid rgba(26,63,196,.08);">
                <tr>
                  <th class="px-5 py-3 text-[.62rem] font-bold uppercase tracking-[.15em] text-slate-400">Donor</th>
                  <th class="px-5 py-3 text-[.62rem] font-bold uppercase tracking-[.15em] text-slate-400">Amount</th>
                  <th class="px-5 py-3 text-[.62rem] font-bold uppercase tracking-[.15em] text-slate-400">Date & Time</th>
                  <th class="px-5 py-3 text-[.62rem] font-bold uppercase tracking-[.15em] text-slate-400">Reference</th>
                </tr>
              </thead>
              <tbody>
                @forelse ($latestPayments as $payment)
                  <tr class="border-b border-slate-100 hover:bg-blue-50/30 transition-colors">
                    <td class="px-5 py-3.5">
                      <div class="flex items-center gap-2.5">
                        <div class="w-7 h-7 rounded-full flex items-center justify-center text-xs font-bold text-white shrink-0"
                             style="background:#1a3fc4;">
                          {{ strtoupper(substr($payment->alumni->fname ?? 'U', 0, 1)) }}
                        </div>
                        <span class="text-sm font-medium text-slate-800">
                          {{ trim(($payment->alumni->fname ?? '') . ' ' . ($payment->alumni->lname ?? '')) ?: 'Unknown Donor' }}
                        </span>
                      </div>
                    </td>
                    <td class="px-5 py-3.5">
                      <span class="text-sm font-bold" style="color:#0a7c68;">₱{{ number_format($payment->amount) }}</span>
                    </td>
                    <td class="px-5 py-3.5 text-sm text-slate-500">
                      {{ optional($payment->paid_at)->format('M d, Y · g:i A') ?? '-' }}
                    </td>
                    <td class="px-5 py-3.5">
                      @if($payment->paymongo_checkout_session_id)
                        <span class="font-mono text-[.7rem] text-slate-400">
                          {{ substr($payment->paymongo_checkout_session_id, 0, 14) }}…
                        </span>
                      @else
                        <span class="text-slate-300">-</span>
                      @endif
                    </td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="4" class="px-5 py-10 text-center">
                      <div class="flex flex-col items-center gap-2">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center" style="background:#f4f7ff;">
                          <flux:icon name="banknotes" class="h-5 w-5 text-slate-300"/>
                        </div>
                        <p class="text-sm text-slate-400">No confirmed payments yet.</p>
                      </div>
                    </td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </section>

        {{-- Donations (Paginated) --}}
        <section class="overflow-hidden rounded-lg bg-white shadow-sm" style="border:1px solid rgba(26,63,196,.1);">
          <div class="flex items-center justify-between px-5 py-4" style="border-bottom:1px solid rgba(26,63,196,.08);">
            <div>
              <p class="text-[.62rem] font-bold uppercase tracking-[.18em]" style="color:#c4960a;">Full Record</p>
              <h2 class="mt-0.5 text-base font-bold text-slate-900">Donation Ledger</h2>
            </div>
            <span class="inline-flex items-center rounded px-2.5 py-1 text-[.62rem] font-bold uppercase tracking-[.1em]"
                  style="background:#eef2ff;color:#1a3fc4;">
              Paginated
            </span>
          </div>

          <div class="overflow-x-auto">
            <table class="w-full text-left">
              <thead style="background:#f4f7ff;border-bottom:1px solid rgba(26,63,196,.08);">
                <tr>
                  <th class="px-5 py-3 text-[.62rem] font-bold uppercase tracking-[.15em] text-slate-400">Donor</th>
                  <th class="px-5 py-3 text-[.62rem] font-bold uppercase tracking-[.15em] text-slate-400">Amount</th>
                  <th class="px-5 py-3 text-[.62rem] font-bold uppercase tracking-[.15em] text-slate-400">Remarks</th>
                  <th class="px-5 py-3 text-[.62rem] font-bold uppercase tracking-[.15em] text-slate-400">Date</th>
                </tr>
              </thead>
              <tbody>
                @forelse ($donations as $donation)
                  <tr class="border-b border-slate-100 hover:bg-blue-50/30 transition-colors">
                    <td class="px-5 py-3.5">
                      <div class="flex items-center gap-2.5">
                        <div class="w-7 h-7 rounded-full flex items-center justify-center text-xs font-bold shrink-0"
                             style="background:#f4f7ff;color:#1a3fc4;border:1px solid rgba(26,63,196,.15);">
                          {{ strtoupper(substr($donation->alumni->fname ?? 'U', 0, 1)) }}
                        </div>
                        <span class="text-sm font-medium text-slate-800">
                          {{ trim(($donation->alumni->fname ?? '') . ' ' . ($donation->alumni->lname ?? '')) ?: 'Unknown Donor' }}
                        </span>
                      </div>
                    </td>
                    <td class="px-5 py-3.5">
                      <span class="text-sm font-bold text-slate-800">₱{{ number_format($donation->amount) }}</span>
                    </td>
                    <td class="px-5 py-3.5 text-sm text-slate-500 max-w-[180px] truncate">
                      {{ $donation->remarks ?: '-' }}
                    </td>
                    <td class="px-5 py-3.5 text-sm text-slate-400">
                      {{ optional($donation->paid_at)->format('M d, Y') ?? '-' }}
                    </td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="4" class="px-5 py-10 text-center">
                      <div class="flex flex-col items-center gap-2">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center" style="background:#f4f7ff;">
                          <flux:icon name="archive-box" class="h-5 w-5 text-slate-300"/>
                        </div>
                        <p class="text-sm text-slate-400">No donation records found.</p>
                      </div>
                    </td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>

          <div class="px-5 py-4" style="border-top:1px solid rgba(26,63,196,.08);background:#f9faff;">
            {{ $donations->links() }}
          </div>
        </section>

        {{-- Recent Announcements --}}
        <section class="overflow-hidden rounded-lg bg-white shadow-sm" style="border:1px solid rgba(26,63,196,.1);">
          <div class="flex items-center justify-between px-5 py-4" style="border-bottom:1px solid rgba(26,63,196,.08);">
            <div>
              <p class="text-[.62rem] font-bold uppercase tracking-[.18em]" style="color:#c4960a;">Content</p>
              <h2 class="mt-0.5 text-base font-bold text-slate-900">Recent Announcements</h2>
            </div>
            <a href="#"
               class="text-[.65rem] font-bold uppercase tracking-[.12em] transition hover:opacity-70"
               style="color:#1a3fc4;">
              Manage →
            </a>
          </div>

          <div class="divide-y" style="divide-color:rgba(26,63,196,.06);">
            @forelse ($recentAnnouncements as $announcement)
              <div class="flex items-start gap-4 px-5 py-4 hover:bg-blue-50/20 transition-colors">
                <div class="w-2 h-2 rounded-full mt-2 shrink-0
                  {{ $announcement->is_published ? '' : '' }}"
                  style="background:{{ $announcement->is_published ? '#0a7c68' : '#94a3b8' }};margin-top:6px;">
                </div>
                <div class="flex-1 min-w-0">
                  <div class="flex items-start justify-between gap-3">
                    <p class="text-sm font-semibold text-slate-800 leading-snug">{{ $announcement->title }}</p>
                    <div class="flex flex-wrap gap-1.5 shrink-0">
                      @if($announcement->pinned)
                        <span class="inline-flex items-center gap-1 rounded px-2 py-0.5 text-[.6rem] font-bold uppercase tracking-[.1em]"
                              style="background:#eef2ff;color:#1a3fc4;">
                          <flux:icon name="bookmark" class="h-2.5 w-2.5"/> Pinned
                        </span>
                      @endif
                      @if($announcement->is_published)
                        <span class="inline-flex items-center gap-1 rounded px-2 py-0.5 text-[.6rem] font-bold uppercase tracking-[.1em]"
                              style="background:#d4f0eb;color:#0a7c68;">
                          <flux:icon name="check" class="h-2.5 w-2.5"/> Live
                        </span>
                      @else
                        <span class="inline-flex items-center gap-1 rounded px-2 py-0.5 text-[.6rem] font-bold uppercase tracking-[.1em]"
                              style="background:#f1f5f9;color:#94a3b8;">
                          <flux:icon name="document-text" class="h-2.5 w-2.5"/> Draft
                        </span>
                      @endif
                    </div>
                  </div>
                  <p class="mt-0.5 text-[.72rem] text-slate-400">
                    {{ $announcement->published_at?->format('M d, Y · g:i A') ?? $announcement->created_at?->format('M d, Y · g:i A') }}
                  </p>
                </div>
              </div>
            @empty
              <div class="flex flex-col items-center gap-2 px-5 py-10">
                <div class="w-10 h-10 rounded-full flex items-center justify-center" style="background:#f4f7ff;">
                  <flux:icon name="megaphone" class="h-5 w-5 text-slate-300"/>
                </div>
                <p class="text-sm text-slate-400">No announcements yet.</p>
              </div>
            @endforelse
          </div>
        </section>

      </div>

      {{-- RIGHT SIDEBAR --}}
      <aside class="space-y-6">

        {{-- Upcoming Events --}}
        <section class="overflow-hidden rounded-lg bg-white shadow-sm" style="border:1px solid rgba(26,63,196,.1);">
          <div class="flex items-center justify-between px-5 py-4" style="border-bottom:1px solid rgba(26,63,196,.08);">
            <div>
              <p class="text-[.62rem] font-bold uppercase tracking-[.18em]" style="color:#c4960a;">Scheduled</p>
              <h2 class="mt-0.5 text-base font-bold text-slate-900">Upcoming Events</h2>
            </div>
            <a href="#"
               class="text-[.65rem] font-bold uppercase tracking-[.12em] transition hover:opacity-70"
               style="color:#1a3fc4;">
              All →
            </a>
          </div>

          <div class="divide-y" style="divide-color:rgba(26,63,196,.06);">
            @forelse ($upcomingEvents as $event)
              <div class="px-5 py-4 hover:bg-blue-50/20 transition-colors">
                <div class="flex items-start gap-3">
                  {{-- Calendar date block --}}
                  <div class="shrink-0 w-12 rounded overflow-hidden text-center" style="border:1px solid rgba(26,63,196,.15);">
                    <div class="py-0.5 text-[.55rem] font-bold text-white" style="background:#1a3fc4;letter-spacing:.15em;">
                      {{ optional($event->event_date)->format('M') }}
                    </div>
                    <div class="py-1 text-lg font-bold text-slate-800" style="background:#f4f7ff;">
                      {{ optional($event->event_date)->format('d') }}
                    </div>
                  </div>
                  <div class="flex-1 min-w-0">
                    <p class="text-sm font-semibold text-slate-800 leading-snug">{{ $event->title }}</p>
                    <p class="mt-0.5 text-[.72rem] text-slate-400 truncate">
                      <flux:icon name="map-pin" class="h-2.5 w-2.5 inline"/>
                      {{ $event->venue ?: 'Venue TBA' }}
                    </p>
                  </div>
                </div>
                <div class="mt-3 grid grid-cols-2 gap-2">
                  <div class="rounded px-3 py-2" style="background:#f4f7ff;border:1px solid rgba(26,63,196,.08);">
                    <p class="text-[.6rem] font-bold uppercase tracking-[.1em] text-slate-400">Dress Code</p>
                    <p class="mt-0.5 text-xs font-semibold text-slate-700">{{ $event->dress_code ?: '-' }}</p>
                  </div>
                  <div class="rounded px-3 py-2" style="background:#f4f7ff;border:1px solid rgba(26,63,196,.08);">
                    <p class="text-[.6rem] font-bold uppercase tracking-[.1em] text-slate-400">Reg. Fee</p>
                    <p class="mt-0.5 text-xs font-semibold" style="color:#1a3fc4;">
                      ₱{{ number_format(($event->registration_fee ?? 0) / 100, 2) }}
                    </p>
                  </div>
                </div>
              </div>
            @empty
              <div class="flex flex-col items-center gap-2 px-5 py-10">
                <div class="w-10 h-10 rounded-full flex items-center justify-center" style="background:#f4f7ff;">
                  <flux:icon name="calendar-days" class="h-5 w-5 text-slate-300"/>
                </div>
                <p class="text-sm text-slate-400">No upcoming events.</p>
              </div>
            @endforelse
          </div>
        </section>

        {{-- System Summary --}}
        <section class="overflow-hidden rounded-lg bg-white shadow-sm" style="border:1px solid rgba(26,63,196,.1);">
          <div class="px-5 py-4" style="border-bottom:1px solid rgba(26,63,196,.08);">
            <p class="text-[.62rem] font-bold uppercase tracking-[.18em]" style="color:#c4960a;">System Overview</p>
            <h2 class="mt-0.5 text-base font-bold text-slate-900">Record Summary</h2>
          </div>

          <div class="p-5 space-y-3">
            <div class="flex items-center justify-between rounded px-4 py-3" style="background:#f4f7ff;border:1px solid rgba(26,63,196,.08);">
              <div class="flex items-center gap-2.5">
                <flux:icon name="user-circle" class="h-4 w-4 text-slate-400"/>
                <span class="text-sm text-slate-600">System Users</span>
              </div>
              <span class="text-sm font-bold text-slate-900">{{ number_format($totalUsers) }}</span>
            </div>

            <div class="flex items-center justify-between rounded px-4 py-3" style="background:#f4f7ff;border:1px solid rgba(26,63,196,.08);">
              <div class="flex items-center gap-2.5">
                <flux:icon name="rectangle-group" class="h-4 w-4 text-slate-400"/>
                <span class="text-sm text-slate-600">Alumni Batches</span>
              </div>
              <span class="text-sm font-bold text-slate-900">{{ number_format($totalBatches) }}</span>
            </div>

            <div class="flex items-center justify-between rounded px-4 py-3" style="background:#f4f7ff;border:1px solid rgba(26,63,196,.08);">
              <div class="flex items-center gap-2.5">
                <flux:icon name="users" class="h-4 w-4 text-slate-400"/>
                <span class="text-sm text-slate-600">Alumni Profiles</span>
              </div>
              <span class="text-sm font-bold text-slate-900">{{ number_format($totalAlumni) }}</span>
            </div>

            <div class="flex items-center justify-between rounded px-4 py-3" style="background:#f4f7ff;border:1px solid rgba(26,63,196,.08);">
              <div class="flex items-center gap-2.5">
                <flux:icon name="calendar-days" class="h-4 w-4 text-slate-400"/>
                <span class="text-sm text-slate-600">Upcoming Events</span>
              </div>
              <span class="text-sm font-bold text-slate-900">{{ $upcomingEventsCount }}</span>
            </div>

            <div class="flex items-center justify-between rounded px-4 py-3" style="background:#f4f7ff;border:1px solid rgba(26,63,196,.08);">
              <div class="flex items-center gap-2.5">
                <flux:icon name="megaphone" class="h-4 w-4 text-slate-400"/>
                <span class="text-sm text-slate-600">Published Posts</span>
              </div>
              <span class="text-sm font-bold text-slate-900">{{ $publishedAnnouncementsCount }}</span>
            </div>
          </div>
        </section>

      </aside>
    </div>

    {{-- ══════════════════════════════════════
         BOTTOM UTILITY SHORTCUTS
    ══════════════════════════════════════ --}}
    <section class="rounded-lg bg-white shadow-sm overflow-hidden" style="border:1px solid rgba(26,63,196,.1);">
      <div class="px-5 py-3.5" style="border-bottom:1px solid rgba(26,63,196,.08);background:linear-gradient(135deg,#091852,#1a3fc4);">
        <p class="text-[.62rem] font-bold uppercase tracking-[.22em] text-white/50">Quick Navigation</p>
        <p class="mt-0.5 text-sm font-bold text-white">Management Shortcuts</p>
      </div>
      <div class="grid grid-cols-2 sm:grid-cols-4 gap-0 divide-y sm:divide-y-0 sm:divide-x" style="divide-color:rgba(26,63,196,.08);">

        <a href="#"
           class="flex items-center gap-3 px-5 py-4 hover:bg-blue-50/40 transition-colors group">
          <div class="w-8 h-8 rounded flex items-center justify-center shrink-0" style="background:#eef2ff;">
            <flux:icon name="users" class="h-4 w-4" style="color:#1a3fc4;"/>
          </div>
          <div>
            <p class="text-xs font-bold text-slate-800 group-hover:text-blue-700 transition-colors">Alumni</p>
            <p class="text-[.65rem] text-slate-400">Manage profiles</p>
          </div>
        </a>

        <a href="#"
           class="flex items-center gap-3 px-5 py-4 hover:bg-blue-50/40 transition-colors group">
          <div class="w-8 h-8 rounded flex items-center justify-center shrink-0" style="background:#eef2ff;">
            <flux:icon name="rectangle-group" class="h-4 w-4" style="color:#1a3fc4;"/>
          </div>
          <div>
            <p class="text-xs font-bold text-slate-800 group-hover:text-blue-700 transition-colors">Batches</p>
            <p class="text-[.65rem] text-slate-400">Representatives</p>
          </div>
        </a>

        <a href="#"
           class="flex items-center gap-3 px-5 py-4 hover:bg-blue-50/40 transition-colors group">
          <div class="w-8 h-8 rounded flex items-center justify-center shrink-0" style="background:#eef2ff;">
            <flux:icon name="chart-bar" class="h-4 w-4" style="color:#1a3fc4;"/>
          </div>
          <div>
            <p class="text-xs font-bold text-slate-800 group-hover:text-blue-700 transition-colors">Reports</p>
            <p class="text-[.65rem] text-slate-400">Export &amp; analytics</p>
          </div>
        </a>

        <a href="#"
           class="flex items-center gap-3 px-5 py-4 hover:bg-blue-50/40 transition-colors group">
          <div class="w-8 h-8 rounded flex items-center justify-center shrink-0" style="background:#eef2ff;">
            <flux:icon name="cog-6-tooth" class="h-4 w-4" style="color:#1a3fc4;"/>
          </div>
          <div>
            <p class="text-xs font-bold text-slate-800 group-hover:text-blue-700 transition-colors">Settings</p>
            <p class="text-[.65rem] text-slate-400">System config</p>
          </div>
        </a>

      </div>
    </section>

  </div>
</div>
</div>
