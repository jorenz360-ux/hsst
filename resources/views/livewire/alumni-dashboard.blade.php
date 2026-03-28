@php
    $user = auth()->user();
    $alumni = $user?->alumni;
@endphp

<div>
    <div class="mx-auto max-w-7xl space-y-4 px-3 py-4 sm:space-y-6 sm:px-4 sm:py-6 lg:px-4">

        {{-- Header --}}
        <section class="overflow-hidden rounded-2xl border border-white/10 bg-gradient-to-br from-slate-950 via-zinc-900 to-indigo-950/40 shadow-[0_20px_60px_rgba(0,0,0,0.35)] sm:rounded-3xl">
            <div class="flex flex-col gap-4 px-4 py-5 sm:px-6 sm:py-6 lg:flex-row lg:items-end lg:justify-between">
                <div class="max-w-3xl">
                    <p class="text-[11px] font-semibold uppercase tracking-[0.2em] text-indigo-400 sm:text-xs sm:tracking-[0.24em]">
                        Alumni Portal
                    </p>

                    <h1 class="mt-2 text-xl font-bold tracking-tight text-white sm:text-3xl">
                        Welcome back, {{ $user->username ?? 'Alumnus' }}
                    </h1>

                    <p class="mt-3 text-sm leading-6 text-zinc-400 sm:text-[15px]">
                        Stay connected with Holy Spirit School of Tagbilaran through alumni updates,
                        upcoming events, and your personal activity summary.
                    </p>
                </div>

              <div class="grid w-full grid-cols-1 gap-2 sm:flex sm:w-auto sm:justify-end sm:self-center">
    <a
        href="{{ route('profile.edit') }}#volunteer-section"
        class="inline-flex items-center justify-center rounded-xl bg-orange-500 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-orange-400"
    >
        Be Involved
    </a>
</div>
            </div>
        </section>

        {{-- Profile Status --}}
        @if($alumni)
            <section class="rounded-2xl border border-emerald-500/20 bg-emerald-500/[0.08] px-4 py-4 sm:px-5">
                <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <p class="text-sm font-semibold text-emerald-300">Profile Complete</p>
                        <p class="mt-1 text-sm text-emerald-400/90">
                            Your alumni account is active and ready for event registration.
                        </p>
                    </div>

                    <span class="inline-flex w-fit items-center rounded-full border border-emerald-400/20 bg-emerald-400/10 px-3 py-1 text-[11px] font-semibold uppercase tracking-wide text-emerald-300">
                        Active
                    </span>
                </div>
            </section>
        @endif

        {{-- Overview --}}
        <section class="rounded-2xl border border-white/10 bg-zinc-900/60 shadow-[0_16px_40px_rgba(0,0,0,0.25)] backdrop-blur-sm sm:rounded-3xl">
            <div class="border-b border-white/10 px-4 py-4 sm:px-5">
                <h2 class="text-base font-semibold text-white sm:text-lg">Overview</h2>
                <p class="mt-1 text-sm text-zinc-400">
                    A quick summary of your alumni activity and available events.
                </p>
            </div>

            <div class="grid gap-3 p-4 sm:grid-cols-2 sm:gap-4 sm:p-5 xl:grid-cols-4">
                <div class="rounded-xl border border-indigo-500/10 bg-white/[0.03] p-4 sm:rounded-2xl">
                    <p class="text-[11px] font-medium uppercase tracking-wide text-zinc-400">My Batch</p>
                    <p class="mt-2 text-base font-semibold text-white sm:mt-3 sm:text-lg">
                        {{ $alumni?->batch?->schoolyear ?? 'Not set' }}
                    </p>
                </div>

                <div class="rounded-xl border border-indigo-500/10 bg-white/[0.03] p-4 sm:rounded-2xl">
                    <p class="text-[11px] font-medium uppercase tracking-wide text-zinc-400">Upcoming Events</p>
                    <p class="mt-2 text-xl font-bold text-white sm:mt-3 sm:text-2xl">
                        {{ $upcomingEvents->count() ?? 0 }}
                    </p>
                </div>

                <div class="rounded-xl border border-indigo-500/10 bg-white/[0.03] p-4 sm:rounded-2xl">
                    <p class="text-[11px] font-medium uppercase tracking-wide text-zinc-400">Total Donated</p>
                    <p class="mt-2 text-base font-semibold text-white sm:mt-3 sm:text-lg">
                        ₱{{ number_format(($paidTotal ?? 0) / 100, 2) }}
                    </p>
                </div>

                <div class="rounded-xl border border-indigo-500/10 bg-white/[0.03] p-4 sm:rounded-2xl">
                    <p class="text-[11px] font-medium uppercase tracking-wide text-zinc-400">Last Donation</p>
                    <p class="mt-2 text-base font-semibold text-white sm:mt-3 sm:text-lg">
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

        <div class="grid gap-4 xl:grid-cols-[1.35fr_0.65fr] xl:gap-6">

            {{-- EVENTS --}}
            <section id="upcoming-events" class="rounded-2xl border border-white/10 bg-zinc-900/60 shadow-[0_16px_40px_rgba(0,0,0,0.25)] backdrop-blur-sm sm:rounded-3xl">
                <div class="border-b border-white/10 px-4 py-4 sm:px-5">
                    <h2 class="text-base font-semibold text-white sm:text-lg">Upcoming Events</h2>
                    <p class="mt-1 text-sm text-zinc-400">
                        Explore upcoming alumni activities and their available registration items.
                    </p>
                </div>

                <div class="space-y-3 p-4 sm:space-y-4 sm:p-5">
                    @forelse ($upcomingEvents as $event)
                        @php
                            $registration = $myEventRegs[$event->id] ?? null;
                            $paymentStatus = $registration['payment_status'] ?? 'unregistered';

                            $statusClasses = match ($paymentStatus) {
                                'paid' => 'border-emerald-400/20 bg-emerald-400/10 text-emerald-300',
                                'pending' => 'border-amber-400/20 bg-amber-400/10 text-amber-300',
                                'rejected' => 'border-rose-400/20 bg-rose-400/10 text-rose-300',
                                'not_required' => 'border-sky-400/20 bg-sky-400/10 text-sky-300',
                                default => 'border-indigo-400/15 bg-indigo-400/10 text-indigo-200',
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

                        <article class="overflow-hidden rounded-2xl border border-white/10 bg-white/[0.03] sm:rounded-3xl">
                            <div class="space-y-4 px-4 py-4 sm:space-y-5 sm:px-5 sm:py-5">
                                <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
                                    <div class="min-w-0 flex-1">
                                        <div class="flex flex-wrap items-center gap-2">
                                            <h3 class="text-base font-semibold text-white sm:text-lg">
                                                {{ $event->title }}
                                            </h3>

                                            <span class="inline-flex items-center rounded-full border px-2.5 py-1 text-[10px] font-semibold uppercase tracking-wide sm:text-[11px] {{ $statusClasses }}">
                                                {{ $statusLabel }}
                                            </span>
                                        </div>

                                        <div class="mt-3 flex flex-wrap gap-2 text-[11px] text-zinc-400 sm:text-xs">
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

                                    <div class="w-full lg:max-w-xs">
                                        <div class="rounded-xl border border-indigo-500/10 bg-slate-950/50 p-4 sm:rounded-2xl">
                                            <div class="flex items-center justify-between gap-3 lg:block">
                                                <div>
                                                    <p class="text-[11px] font-medium uppercase tracking-wide text-zinc-500">
                                                        Registration Fee
                                                    </p>
                                                    <p class="mt-1 text-xl font-bold text-white sm:text-2xl">
                                                        ₱{{ number_format(($event->registration_fee ?? 0) / 100, 2) }}
                                                    </p>
                                                </div>
                                            </div>

                                            <div class="mt-4">
                                                <a
                                                    href="{{ route('alumni.events.show', $event) }}"
                                                    wire:navigate
                                                    class="inline-flex w-full items-center justify-center rounded-xl bg-indigo-500 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-indigo-400"
                                                >
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
                                </div>

                                @if ($event->registrationItems->count())
                                    <div class="space-y-2 sm:space-y-3">
                                        @foreach ($event->registrationItems as $item)
                                            @php
                                                $itemStatus = $myEventItemPayments[$event->id][$item->id] ?? 'unpaid';

                                                $itemBadgeClasses = match ($itemStatus) {
                                                    'verified' => 'border-emerald-400/20 bg-emerald-400/10 text-emerald-300',
                                                    'pending' => 'border-amber-400/20 bg-amber-400/10 text-amber-300',
                                                    'rejected' => 'border-rose-400/20 bg-rose-400/10 text-rose-300',
                                                    default => 'border-indigo-400/15 bg-indigo-400/10 text-indigo-200',
                                                };

                                                $itemBadgeLabel = match ($itemStatus) {
                                                    'verified' => 'Verified',
                                                    'pending' => 'Pending',
                                                    'rejected' => 'Rejected',
                                                    default => 'Unpaid',
                                                };
                                            @endphp

                                            <div class="rounded-xl border border-white/10 bg-white/[0.03] px-4 py-3 sm:rounded-2xl">
                                                <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
                                                    <div class="min-w-0">
                                                        <div class="flex flex-wrap items-center gap-2">
                                                            <p class="text-sm font-medium text-white">
                                                                {{ $item->name }}
                                                            </p>

                                                            @if ($item->is_required)
                                                                <span class="rounded-full border border-rose-400/20 bg-rose-400/10 px-2 py-0.5 text-[10px] font-semibold uppercase tracking-wide text-rose-300">
                                                                    Required
                                                                </span>
                                                            @else
                                                                <span class="rounded-full border border-sky-400/20 bg-sky-400/10 px-2 py-0.5 text-[10px] font-semibold uppercase tracking-wide text-sky-300">
                                                                    Optional
                                                                </span>
                                                            @endif

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

                                                    <div class="shrink-0 text-left sm:text-right">
                                                        <p class="text-sm font-semibold text-white">
                                                            ₱{{ number_format($item->price / 100, 2) }}
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </article>
                    @empty
                        <div class="rounded-2xl border border-dashed border-white/10 bg-white/[0.02] px-5 py-10 text-center sm:rounded-3xl sm:px-6 sm:py-12">
                            <h3 class="text-base font-semibold text-white sm:text-lg">No upcoming events yet</h3>
                            <p class="mt-2 text-sm text-zinc-400">
                                New alumni events will appear here once they are published.
                            </p>
                        </div>
                    @endforelse
                </div>
            </section>

            {{-- SIDEBAR --}}
            <aside class="space-y-4 sm:space-y-6">
{{-- Be Involved CTA --}}
<section class="overflow-hidden rounded-2xl border border-indigo-400/15 bg-gradient-to-br from-indigo-950/80 via-slate-950 to-zinc-900 shadow-[0_16px_40px_rgba(0,0,0,0.25)] sm:rounded-3xl">
    <div class="border-b border-white/10 px-4 py-4 sm:px-5">
        <div class="flex items-start justify-between gap-3">
            <div>
                <p class="text-[11px] font-semibold uppercase tracking-[0.22em] text-indigo-300">
                    Be Involved
                </p>

                <h2 class="mt-2 text-base font-semibold text-white sm:text-lg">
                    {{ $hasVolunteerInfo ? 'Your Reunion Involvement' : 'Be Involved in the Reunion' }}
                </h2>
            </div>

            <span
                @class([
                    'inline-flex items-center rounded-full border px-2.5 py-1 text-[10px] font-semibold uppercase tracking-wide',
                    'border-emerald-400/20 bg-emerald-400/10 text-emerald-300' => $hasVolunteerInfo,
                    'border-indigo-400/20 bg-indigo-400/10 text-indigo-200' => ! $hasVolunteerInfo,
                ])
            >
                {{ $hasVolunteerInfo ? 'Saved' : 'Open' }}
            </span>
        </div>
    </div>

    <div class="space-y-4 px-4 py-4 sm:px-5 sm:py-5">
        @if($hasVolunteerInfo)
            <div class="rounded-2xl border border-emerald-400/15 bg-emerald-500/[0.08] p-4">
                <p class="text-sm font-medium text-emerald-300">
                    Your involvement preferences have been submitted.
                </p>
                <p class="mt-1 text-xs leading-5 text-zinc-400">
                    You may still update your preferences anytime before the reunion.
                </p>
            </div>

            @if(!empty($volunteerRoles))
                <div class="space-y-2">
                    <p class="text-[11px] font-semibold uppercase tracking-[0.18em] text-zinc-500">
                        Selected Involvement
                    </p>

                    <div class="flex flex-wrap gap-2">
                        @foreach($volunteerRoles as $role)
                            <span class="inline-flex items-center rounded-full border border-white/10 bg-white/[0.05] px-3 py-1.5 text-xs font-medium text-white">
                                {{ $role }}
                            </span>
                        @endforeach
                    </div>
                </div>
            @endif

            @if($volunteerSpecialty)
                <div class="rounded-2xl border border-white/10 bg-white/[0.04] p-3">
                    <p class="text-[11px] font-semibold uppercase tracking-[0.18em] text-zinc-500">
                        Field of Specialty
                    </p>
                    <p class="mt-2 text-sm text-white">
                        {{ $volunteerSpecialty }}
                    </p>
                </div>
            @endif
        @endif

        <a
            href="{{ route('profile.edit') }}#volunteer-section"
            class="inline-flex w-full items-center justify-center rounded-xl bg-indigo-500 px-4 py-3 text-sm font-semibold text-white transition hover:bg-indigo-400"
        >
            {{ $hasVolunteerInfo ? 'Update Volunteer Info' : 'Complete Volunteer Info' }}
        </a>
    </div>
</section>

                <section class="rounded-2xl border border-white/10 bg-zinc-900/60 shadow-[0_16px_40px_rgba(0,0,0,0.25)] backdrop-blur-sm sm:rounded-3xl">
                    <div class="border-b border-white/10 px-4 py-4 sm:px-5">
                        <h2 class="text-base font-semibold text-white sm:text-lg">Quick Actions</h2>
                    </div>

                    <div class="grid gap-2 p-4 sm:space-y-3 sm:p-5">
                        <a href="#upcoming-events"
                           class="flex items-center justify-between rounded-xl border border-white/10 bg-white/[0.03] px-4 py-3 text-sm text-zinc-200 transition hover:border-indigo-400/20 hover:bg-indigo-400/10 sm:rounded-2xl">
                            <span>Browse Events</span>
                            <span>→</span>
                        </a>

                        <a href="#profile-section"
                           class="flex items-center justify-between rounded-xl border border-white/10 bg-white/[0.03] px-4 py-3 text-sm text-zinc-200 transition hover:border-indigo-400/20 hover:bg-indigo-400/10 sm:rounded-2xl">
                            <span>Update Profile</span>
                            <span>→</span>
                        </a>

                        <a href="{{ route('profile.edit') }}#volunteer-section"
                           class="flex items-center justify-between rounded-xl border border-white/10 bg-white/[0.03] px-4 py-3 text-sm text-zinc-200 transition hover:border-indigo-400/20 hover:bg-indigo-400/10 sm:rounded-2xl">
                            <span>Be Involved</span>
                            <span>→</span>
                        </a>
                    </div>
                </section>

                <section class="rounded-2xl border border-white/10 bg-zinc-900/60 shadow-[0_16px_40px_rgba(0,0,0,0.25)] backdrop-blur-sm sm:rounded-3xl">
                    <div class="border-b border-white/10 px-4 py-4 sm:px-5">
                        <h2 class="text-base font-semibold text-white sm:text-lg">Recent Activity</h2>
                    </div>

                    <div class="grid gap-2 p-4 sm:gap-3 sm:p-5">
                        <div class="rounded-xl border border-indigo-500/10 bg-white/[0.03] p-4 sm:rounded-2xl">
                            <p class="text-[11px] uppercase tracking-wide text-zinc-500">Last Donation</p>
                            <p class="mt-2 text-sm font-medium text-white">
                                {{ $lastPaidAt ? $lastPaidAt : 'No donation recorded yet' }}
                            </p>
                        </div>

                        <div class="rounded-xl border border-indigo-500/10 bg-white/[0.03] p-4 sm:rounded-2xl">
                            <p class="text-[11px] uppercase tracking-wide text-zinc-500">Announcements</p>
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