<div>
    <div class="mx-auto max-w-7xl space-y-6 px-4 py-6 sm:px-6 lg:px-8">

        {{-- Header --}}
        <section class="overflow-hidden rounded-3xl border border-white/10 bg-gradient-to-br from-zinc-900 via-zinc-900 to-teal-950/40 shadow-[0_20px_60px_rgba(0,0,0,0.35)]">
            <div class="flex flex-col gap-6 px-6 py-6 lg:flex-row lg:items-end lg:justify-between">
                <div class="max-w-3xl">
                    <p class="text-xs font-semibold uppercase tracking-[0.24em] text-teal-400">
                        Alumni Portal
                    </p>

                    <h1 class="mt-2 text-2xl font-bold tracking-tight text-white sm:text-3xl">
                        Welcome back, {{ auth()->user()->username ?? 'Alumnus' }}
                    </h1>

                    <p class="mt-3 text-sm leading-6 text-zinc-400 sm:text-[15px]">
                        Stay connected with Holy Spirit School of Tagbilaran through alumni updates,
                        upcoming events, and your personal activity summary.
                    </p>
                </div>

                <div class="flex flex-wrap gap-3">
                    <a href="#profile-section"
                       class="inline-flex items-center rounded-xl border border-white/10 bg-white/[0.04] px-4 py-2.5 text-sm font-medium text-zinc-200 transition hover:bg-white/[0.08]">
                        Edit Profile
                    </a>

                    <a href="#upcoming-events"
                       class="inline-flex items-center rounded-xl bg-teal-500 px-4 py-2.5 text-sm font-semibold text-zinc-950 transition hover:bg-teal-400">
                        View Events
                    </a>
                </div>
            </div>
        </section>

        {{-- Profile Status --}}
        @if(auth()->user()->alumni)
            <section class="rounded-2xl border border-emerald-500/20 bg-emerald-500/[0.08] px-5 py-4">
                <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <p class="text-sm font-semibold text-emerald-300">Profile Complete</p>
                        <p class="mt-1 text-sm text-emerald-400/90">
                            Your alumni account is active and ready for event registration.
                        </p>
                    </div>

                    <span class="inline-flex w-fit items-center rounded-full border border-emerald-400/20 bg-emerald-400/10 px-3 py-1 text-xs font-semibold uppercase tracking-wide text-emerald-300">
                        Active
                    </span>
                </div>
            </section>
        @endif

        {{-- Overview --}}
        <section class="rounded-3xl border border-white/10 bg-zinc-900/60 shadow-[0_16px_40px_rgba(0,0,0,0.25)] backdrop-blur-sm">
            <div class="border-b border-white/10 px-5 py-4">
                <h2 class="text-lg font-semibold text-white">Overview</h2>
                <p class="mt-1 text-sm text-zinc-400">
                    A quick summary of your alumni activity and available events.
                </p>
            </div>

            <div class="grid gap-4 p-5 sm:grid-cols-2 xl:grid-cols-4">
                <div class="rounded-2xl border border-white/10 bg-white/[0.03] p-4">
                    <p class="text-xs font-medium uppercase tracking-wide text-zinc-400">My Batch</p>
                    <p class="mt-3 text-lg font-semibold text-white">
                        {{ auth()->user()->alumni?->batch?->schoolyear ?? 'Not set' }}
                    </p>
                </div>

                <div class="rounded-2xl border border-white/10 bg-white/[0.03] p-4">
                    <p class="text-xs font-medium uppercase tracking-wide text-zinc-400">Upcoming Events</p>
                    <p class="mt-3 text-2xl font-bold text-white">
                        {{ $upcomingEvents->count() ?? 0 }}
                    </p>
                </div>

                <div class="rounded-2xl border border-white/10 bg-white/[0.03] p-4">
                    <p class="text-xs font-medium uppercase tracking-wide text-zinc-400">Total Donated</p>
                    <p class="mt-3 text-lg font-semibold text-white">
                        ₱{{ number_format(($paidTotal ?? 0) / 100, 2) }}
                    </p>
                </div>

                <div class="rounded-2xl border border-white/10 bg-white/[0.03] p-4">
                    <p class="text-xs font-medium uppercase tracking-wide text-zinc-400">Last Donation</p>
                    <p class="mt-3 text-lg font-semibold text-white">
                        {{ $lastPaidAt ? '₱' . number_format(($lastPaidAmount ?? 0) / 100, 2) : 'No donation yet' }}
                    </p>
                    @if ($lastPaidAt)
                        <p class="mt-1 text-xs text-zinc-500">
                            {{ $lastPaidAt }}
                        </p>
                    @endif
                </div>
            </div>
        </section>

        <div class="grid gap-6 xl:grid-cols-[1.35fr_0.65fr]">

            {{-- EVENTS --}}
            <section id="upcoming-events" class="rounded-3xl border border-white/10 bg-zinc-900/60 shadow-[0_16px_40px_rgba(0,0,0,0.25)] backdrop-blur-sm">
                <div class="border-b border-white/10 px-5 py-4">
                    <h2 class="text-lg font-semibold text-white">Upcoming Events</h2>
                    <p class="mt-1 text-sm text-zinc-400">
                        Explore upcoming alumni activities and their available registration items.
                    </p>
                </div>

                <div class="space-y-4 p-5">
                    @forelse ($upcomingEvents as $event)
                        @php
                            $registration = $myEventRegs[$event->id] ?? null;
                            $paymentStatus = $registration['payment_status'] ?? 'unregistered';

                            $statusClasses = match ($paymentStatus) {
                                'paid' => 'border-emerald-400/20 bg-emerald-400/10 text-emerald-300',
                                'pending' => 'border-amber-400/20 bg-amber-400/10 text-amber-300',
                                'rejected' => 'border-rose-400/20 bg-rose-400/10 text-rose-300',
                                'not_required' => 'border-sky-400/20 bg-sky-400/10 text-sky-300',
                                default => 'border-white/10 bg-white/[0.05] text-zinc-300',
                            };

                            $statusLabel = match ($paymentStatus) {
                                'paid' => 'Payment Verified',
                                'pending' => 'Pending Review',
                                'rejected' => 'Payment Rejected',
                                'not_required' => 'No Payment Required',
                                'unpaid' => 'Payment Needed',
                                default => 'Not Registered',
                            };
                        @endphp

                        <article class="overflow-hidden rounded-3xl border border-white/10 bg-white/[0.03]">
                            <div class="flex flex-col gap-5 px-5 py-5">
                                <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
                                    <div class="min-w-0">
                                        <div class="flex flex-wrap items-center gap-2">
                                            <h3 class="text-lg font-semibold text-white">
                                                {{ $event->title }}
                                            </h3>

                                            <span class="inline-flex items-center rounded-full border px-2.5 py-1 text-[11px] font-semibold uppercase tracking-wide {{ $statusClasses }}">
                                                {{ $statusLabel }}
                                            </span>
                                        </div>

                                        <div class="mt-3 flex flex-wrap gap-2 text-xs text-zinc-400">
                                            <span class="rounded-full border border-white/10 bg-white/[0.03] px-3 py-1">
                                                {{ $event->event_date?->format('M d, Y • h:i A') }}
                                            </span>

                                            <span class="rounded-full border border-white/10 bg-white/[0.03] px-3 py-1">
                                                {{ $event->venue }}
                                            </span>

                                            @if ($event->dress_code)
                                                <span class="rounded-full border border-white/10 bg-white/[0.03] px-3 py-1">
                                                    Dress Code: {{ $event->dress_code }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="w-full max-w-xs rounded-2xl border border-white/10 bg-zinc-950/50 p-4">
                                        <p class="text-xs font-medium uppercase tracking-wide text-zinc-500">
                                            Registration Fee
                                        </p>
                                        <p class="mt-2 text-2xl font-bold text-white">
                                            ₱{{ number_format(($event->registration_fee ?? 0) / 100, 2) }}
                                        </p>

                                        <div class="mt-4">
                                          <a
                                                href="{{ route('alumni.events.show', $event) }}"
                                                wire:navigate
                                                class="inline-flex w-full items-center justify-center rounded-xl bg-teal-500 px-4 py-2.5 text-sm font-semibold text-zinc-950 transition hover:bg-teal-400">
                                                @if ($paymentStatus === 'paid')
                                                    View Registration
                                                @elseif ($paymentStatus === 'pending')
                                                    Check Payment Status
                                                @elseif ($paymentStatus === 'rejected')
                                                    Upload New Proof
                                                @elseif ($paymentStatus === 'not_required')
                                                    Register Now
                                                @elseif ($paymentStatus === 'unpaid')
                                                    Continue Payment
                                                @else
                                                    Register / Pay
                                                @endif
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                @foreach ($event->registrationItems as $item)
    @php
        $itemStatus = $myEventItemPayments[$event->id][$item->id] ?? 'unpaid';

        $itemBadgeClasses = match ($itemStatus) {
            'verified' => 'border-emerald-400/20 bg-emerald-400/10 text-emerald-300',
            'pending' => 'border-amber-400/20 bg-amber-400/10 text-amber-300',
            'rejected' => 'border-rose-400/20 bg-rose-400/10 text-rose-300',
            default => 'border-white/10 bg-white/[0.05] text-zinc-300',
        };

        $itemBadgeLabel = match ($itemStatus) {
            'verified' => 'Verified',
            'pending' => 'Pending',
            'rejected' => 'Rejected',
            default => 'Unpaid',
        };
    @endphp

    <div class="flex items-start justify-between gap-3 rounded-2xl border border-white/10 bg-white/[0.03] px-4 py-3">
        <div class="min-w-0">
            <div class="flex flex-wrap items-center gap-2">
                <p class="text-sm font-medium text-white">
                    {{ $item->name }}
                </p>

                {{-- Required / Optional --}}
                @if ($item->is_required)
                    <span class="rounded-full border border-rose-400/20 bg-rose-400/10 px-2 py-0.5 text-[10px] font-semibold uppercase tracking-wide text-rose-300">
                        Required
                    </span>
                @else
                    <span class="rounded-full border border-sky-400/20 bg-sky-400/10 px-2 py-0.5 text-[10px] font-semibold uppercase tracking-wide text-sky-300">
                        Optional
                    </span>
                @endif

                {{-- ✅ NEW: Payment Status Badge --}}
                <span class="rounded-full border px-2 py-0.5 text-[10px] font-semibold uppercase tracking-wide {{ $itemBadgeClasses }}">
                    {{ $itemBadgeLabel }}
                </span>
            </div>

            @if ($item->description)
                <p class="mt-1 text-xs leading-5 text-zinc-400">
                    {{ $item->description }}
                </p>
            @endif

            @if ($item->schedule)
                <p class="mt-1 text-xs text-zinc-500">
                    Linked to {{ $item->schedule->title }}
                    @if ($item->schedule->schedule_time)
                        • {{ \Illuminate\Support\Carbon::parse($item->schedule->schedule_time)->format('h:i A') }}
                    @endif
                </p>
            @endif

            {{-- ✅ Optional UX hint --}}
            @if ($itemStatus === 'rejected')
                <p class="mt-2 text-xs text-rose-400">
                    Your payment was rejected. Please upload a new proof.
                </p>
            @endif

            @if ($itemStatus === 'pending')
                <p class="mt-2 text-xs text-amber-400">
                    Waiting for admin verification.
                </p>
            @endif
        </div>

        <div class="shrink-0 text-right">
            <p class="text-sm font-semibold text-white">
                ₱{{ number_format($item->price / 100, 2) }}
            </p>
        </div>
    </div>
@endforeach
                            </div>
                        </article>
                    @empty
                        <div class="rounded-3xl border border-dashed border-white/10 bg-white/[0.02] px-6 py-12 text-center">
                            <h3 class="text-lg font-semibold text-white">No upcoming events yet</h3>
                            <p class="mt-2 text-sm text-zinc-400">
                                New alumni events will appear here once they are published.
                            </p>
                        </div>
                    @endforelse
                </div>
            </section>

            {{-- SIDEBAR --}}
            <aside class="space-y-6">
                <section class="rounded-3xl border border-white/10 bg-zinc-900/60 shadow-[0_16px_40px_rgba(0,0,0,0.25)] backdrop-blur-sm">
                    <div class="border-b border-white/10 px-5 py-4">
                        <h2 class="text-lg font-semibold text-white">Quick Actions</h2>
                    </div>

                    <div class="space-y-3 p-5">
                        <a href="#upcoming-events"
                           class="flex items-center justify-between rounded-2xl border border-white/10 bg-white/[0.03] px-4 py-3 text-sm text-zinc-200 transition hover:bg-white/[0.06]">
                            <span>Browse Events</span>
                            <span>→</span>
                        </a>

                        <a href="#profile-section"
                           class="flex items-center justify-between rounded-2xl border border-white/10 bg-white/[0.03] px-4 py-3 text-sm text-zinc-200 transition hover:bg-white/[0.06]">
                            <span>Update Profile</span>
                            <span>→</span>
                        </a>
                    </div>
                </section>

                <section class="rounded-3xl border border-white/10 bg-zinc-900/60 shadow-[0_16px_40px_rgba(0,0,0,0.25)] backdrop-blur-sm">
                    <div class="border-b border-white/10 px-5 py-4">
                        <h2 class="text-lg font-semibold text-white">Recent Activity</h2>
                    </div>

                    <div class="space-y-3 p-5">
                        <div class="rounded-2xl border border-white/10 bg-white/[0.03] p-4">
                            <p class="text-xs uppercase tracking-wide text-zinc-500">Last Donation</p>
                            <p class="mt-2 text-sm font-medium text-white">
                                {{ $lastPaidAt ? $lastPaidAt : 'No donation recorded yet' }}
                            </p>
                        </div>

                        <div class="rounded-2xl border border-white/10 bg-white/[0.03] p-4">
                            <p class="text-xs uppercase tracking-wide text-zinc-500">Announcements</p>
                            <p class="mt-2 text-sm font-medium text-white">
                                {{ $latestAnnouncements->count() }} active post(s)
                            </p>
                        </div>
                    </div>
                </section>
            </aside>
        </div>
    </div>
</div>