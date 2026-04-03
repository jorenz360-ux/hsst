<div class="min-h-screen bg-[#0b1120]">
    <div class="mx-auto max-w-7xl space-y-4 px-3 py-4 sm:space-y-6 sm:px-6 sm:py-6 lg:px-8">

        {{-- Header --}}
        <section class="overflow-hidden rounded-2xl border border-white/10 bg-gradient-to-br from-[#0f172a] via-[#020617] to-[#1e3a8a]/20 shadow-[0_20px_60px_rgba(0,0,0,0.45)] sm:rounded-3xl">
            <div class="flex flex-col gap-4 px-4 py-5 sm:px-6 sm:py-6 lg:flex-row lg:items-end lg:justify-between">
                <div class="max-w-3xl">
                    <p class="text-[11px] font-semibold uppercase tracking-[0.2em] text-blue-400 sm:text-xs sm:tracking-[0.24em]">
                        Event Details
                    </p>

                    <h1 class="mt-2 text-xl font-bold tracking-tight text-white sm:text-3xl">
                        {{ $event->title }}
                    </h1>

                    <p class="mt-3 text-sm leading-6 text-slate-400 sm:text-[15px]">
                        Review the event details and let the organizers know whether you will attend.
                    </p>
                </div>

                <a href="{{ route('dashboard') }}"
                   wire:navigate
                   class="inline-flex items-center justify-center rounded-xl border border-white/10 bg-white/5 px-4 py-2.5 text-sm font-medium text-slate-200 transition hover:bg-white/10">
                    Back to Dashboard
                </a>
            </div>
        </section>

        {{-- Alerts --}}
        @if (session('success'))
            <div class="rounded-2xl border border-emerald-500/20 bg-emerald-500/10 px-4 py-4 text-sm text-emerald-300 sm:px-5">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="rounded-2xl border border-rose-500/20 bg-rose-500/10 px-4 py-4 text-sm text-rose-300 sm:px-5">
                {{ session('error') }}
            </div>
        @endif

        @php
            $currentStatus = $this->rsvpStatus ?? null;

            $statusBadgeClasses = match($currentStatus) {
                'attending' => 'border-emerald-400/20 bg-emerald-500/10 text-emerald-300',
                'maybe' => 'border-amber-400/20 bg-amber-500/10 text-amber-300',
                'not_attending' => 'border-rose-400/20 bg-rose-500/10 text-rose-300',
                default => 'border-slate-400/20 bg-slate-500/10 text-slate-300',
            };

            $statusLabel = match($currentStatus) {
                'attending' => 'Attending',
                'maybe' => 'Maybe Attending',
                'not_attending' => 'Not Attending',
                default => 'No Response Yet',
            };

            $isPastEvent = optional($event->event_date)?->isPast() ?? false;
        @endphp

        <div class="grid gap-4 xl:grid-cols-[1.2fr_0.8fr] xl:gap-6">

            {{-- LEFT --}}
            <div class="space-y-4 sm:space-y-6">

                {{-- RSVP SECTION --}}
                <section class="rounded-2xl border border-white/10 bg-[#020617] shadow-[0_16px_40px_rgba(0,0,0,0.4)] sm:rounded-3xl">
                    <div class="border-b border-white/10 px-4 py-4 sm:px-5">
                        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                            <div>
                                <h2 class="text-base font-semibold text-white sm:text-lg">Attendance Confirmation</h2>
                                <p class="mt-1 text-sm text-slate-400">
                                    Confirm whether you will participate in this event.
                                </p>
                            </div>

                            <span class="inline-flex w-fit rounded-full border px-3 py-1 text-[11px] font-semibold uppercase tracking-wide {{ $statusBadgeClasses }}">
                                {{ $statusLabel }}
                            </span>
                        </div>
                    </div>
<div class="p-4 sm:p-5">
    @if ($isPastEvent)
        <div class="rounded-xl border border-slate-500/20 bg-slate-500/10 px-4 py-4 text-sm text-slate-300 sm:rounded-2xl">
            This event has already ended. RSVP is now closed.
        </div>
    @else
        <div class="space-y-3">
            <p class="text-sm font-medium text-white">Will you attend this event?</p>

            <div class="grid gap-3 sm:grid-cols-3">
                <label for="rsvp-attending"
                    class="cursor-pointer rounded-xl border px-4 py-4 transition sm:rounded-2xl
                    {{ $rsvpStatus === 'attending'
                        ? 'border-emerald-400/30 bg-emerald-500/15 text-emerald-300'
                        : 'border-white/10 bg-white/5 text-white hover:bg-white/10' }}">
                    <div class="flex items-start gap-3">
                        <input
                            id="rsvp-attending"
                            type="radio"
                            wire:model.live="rsvpStatus"
                            value="attending"
                            class="mt-1 h-4 w-4 border-slate-500 bg-slate-900 text-emerald-500 focus:ring-emerald-500"
                        >
                        <div>
                            <p class="text-sm font-semibold">Attend</p>
                            <p class="mt-1 text-xs text-slate-400">
                                I plan to join this event.
                            </p>
                        </div>
                    </div>
                </label>

                <label for="rsvp-maybe"
                    class="cursor-pointer rounded-xl border px-4 py-4 transition sm:rounded-2xl
                    {{ $rsvpStatus === 'maybe'
                        ? 'border-amber-400/30 bg-amber-500/15 text-amber-300'
                        : 'border-white/10 bg-white/5 text-white hover:bg-white/10' }}">
                    <div class="flex items-start gap-3">
                        <input
                            id="rsvp-maybe"
                            type="radio"
                            wire:model.live="rsvpStatus"
                            value="maybe"
                            class="mt-1 h-4 w-4 border-slate-500 bg-slate-900 text-amber-500 focus:ring-amber-500"
                        >
                        <div>
                            <p class="text-sm font-semibold">Maybe</p>
                            <p class="mt-1 text-xs text-slate-400">
                                I am still unsure for now.
                            </p>
                        </div>
                    </div>
                </label>

                <label for="rsvp-not-attending"
                    class="cursor-pointer rounded-xl border px-4 py-4 transition sm:rounded-2xl
                    {{ $rsvpStatus === 'not_attending'
                        ? 'border-rose-400/30 bg-rose-500/15 text-rose-300'
                        : 'border-white/10 bg-white/5 text-white hover:bg-white/10' }}">
                    <div class="flex items-start gap-3">
                        <input
                            id="rsvp-not-attending"
                            type="radio"
                            wire:model.live="rsvpStatus"
                            value="not_attending"
                            class="mt-1 h-4 w-4 border-slate-500 bg-slate-900 text-rose-500 focus:ring-rose-500"
                        >
                        <div>
                            <p class="text-sm font-semibold">Not Attending</p>
                            <p class="mt-1 text-xs text-slate-400">
                                I will not be able to attend.
                            </p>
                        </div>
                    </div>
                </label>
            </div>

            <div class="flex flex-col gap-3 border-t border-white/10 pt-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <p class="text-[11px] uppercase tracking-wide text-slate-500">Current Response</p>
                    <p class="mt-1 text-sm font-medium text-white">
                        {{ $statusLabel }}
                    </p>
                </div>

                <button
                    type="button"
                    wire:click="saveRsvp"
                    class="inline-flex items-center justify-center rounded-xl bg-[#1E3A8A] px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-[#2746c7] sm:rounded-2xl"
                >
                    Save RSVP
                </button>
            </div>

            <div class="rounded-xl border border-white/10 bg-white/5 p-4 sm:rounded-2xl">
                <p class="text-sm text-slate-400">
                    You can still update your response anytime before the event schedule closes.
                </p>
            </div>
        </div>
    @endif
</div>
                </section>

                {{-- Event Summary --}}
                <section class="rounded-2xl border border-white/10 bg-[#020617] shadow-[0_16px_40px_rgba(0,0,0,0.4)] sm:rounded-3xl">
                    <div class="border-b border-white/10 px-4 py-4 sm:px-5">
                        <h2 class="text-base font-semibold text-white sm:text-lg">Event Summary</h2>
                        <p class="mt-1 text-sm text-slate-400">
                            Important details about this reunion activity.
                        </p>
                    </div>

                    <div class="grid gap-3 p-4 sm:grid-cols-2 sm:gap-4 sm:p-5">
                        <div class="rounded-xl border border-white/10 bg-white/5 p-4 sm:rounded-2xl">
                            <p class="text-[11px] uppercase tracking-wide text-slate-500">Venue</p>
                            <p class="mt-2 text-sm font-medium text-white">
                                {{ $event->venue ?: 'No venue set' }}
                            </p>
                        </div>

                        <div class="rounded-xl border border-white/10 bg-white/5 p-4 sm:rounded-2xl">
                            <p class="text-[11px] uppercase tracking-wide text-slate-500">Event Date</p>
                            <p class="mt-2 text-sm font-medium text-white">
                                {{ optional($event->event_date)->format('M d, Y • h:i A') ?: 'Date not set' }}
                            </p>
                        </div>

                        <div class="rounded-xl border border-white/10 bg-white/5 p-4 sm:rounded-2xl">
                            <p class="text-[11px] uppercase tracking-wide text-slate-500">Dress Code</p>
                            <p class="mt-2 text-sm font-medium text-white">
                                {{ $event->dress_code ?: 'No dress code specified' }}
                            </p>
                        </div>

                        <div class="rounded-xl border border-white/10 bg-white/5 p-4 sm:rounded-2xl">
                            <p class="text-[11px] uppercase tracking-wide text-slate-500">Registration Fee</p>
                            <p class="mt-2 text-sm font-medium text-white">
                                @if(($event->registration_fee ?? 0) > 0)
                                    ₱{{ number_format(($event->registration_fee ?? 0) / 100, 2) }}
                                @else
                                    Free Event
                                @endif
                            </p>
                        </div>
                    </div>

                    @if ($event->description)
                        <div class="border-t border-white/10 px-4 py-4 sm:px-5">
                            <p class="text-[11px] uppercase tracking-wide text-slate-500">Description</p>
                            <div class="mt-2 text-sm leading-7 text-slate-300">
                                {!! nl2br(e($event->description)) !!}
                            </div>
                        </div>
                    @endif
                </section>

                {{-- Program Schedule --}}
                @if ($event->schedules->isNotEmpty())
                    <section class="rounded-2xl border border-white/10 bg-[#020617] shadow-[0_16px_40px_rgba(0,0,0,0.4)] sm:rounded-3xl">
                        <div class="border-b border-white/10 px-4 py-4 sm:px-5">
                            <h2 class="text-base font-semibold text-white sm:text-lg">Program Schedule</h2>
                            <p class="mt-1 text-sm text-slate-400">
                                Event activities and timeline.
                            </p>
                        </div>

                        <div class="space-y-3 p-4 sm:p-5">
                            @foreach ($event->schedules as $schedule)
                                <div class="rounded-xl border border-white/10 bg-white/5 p-4 sm:rounded-2xl">
                                    <div class="flex flex-col gap-2 sm:flex-row sm:items-start sm:justify-between">
                                        <div class="min-w-0">
                                            <p class="text-sm font-semibold text-white">
                                                {{ $schedule->title }}
                                            </p>

                                            @if ($schedule->description)
                                                <p class="mt-1 text-sm text-slate-400">
                                                    {{ $schedule->description }}
                                                </p>
                                            @endif
                                        </div>

                                        @if ($schedule->schedule_time)
                                            <span class="inline-flex w-fit rounded-full border border-white/10 bg-white/5 px-3 py-1 text-xs text-slate-300">
                                                {{ \Illuminate\Support\Carbon::parse($schedule->schedule_time)->format('h:i A') }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </section>
                @endif
            </div>

            {{-- RIGHT --}}
            <div class="space-y-4 sm:space-y-6">

                {{-- Attendance Status --}}
                <section class="rounded-2xl border border-white/10 bg-[#020617] shadow-[0_16px_40px_rgba(0,0,0,0.4)] sm:rounded-3xl">
                    <div class="border-b border-white/10 px-4 py-4 sm:px-5">
                        <h2 class="text-base font-semibold text-white sm:text-lg">My Attendance Status</h2>
                    </div>

                    <div class="grid gap-3 p-4 sm:p-5">
                        <div class="rounded-xl border border-white/10 bg-white/5 p-4 sm:rounded-2xl">
                            <p class="text-[11px] uppercase tracking-wide text-slate-500">Current RSVP</p>
                            <p class="mt-2 text-sm font-medium text-white">{{ $statusLabel }}</p>
                        </div>

                        <div class="rounded-xl border border-white/10 bg-white/5 p-4 sm:rounded-2xl">
                            <p class="text-[11px] uppercase tracking-wide text-slate-500">Event Date</p>
                            <p class="mt-2 text-sm font-medium text-white">
                                {{ optional($event->event_date)->format('M d, Y • h:i A') ?: 'Date not set' }}
                            </p>
                        </div>

                        <div class="rounded-xl border border-white/10 bg-white/5 p-4 sm:rounded-2xl">
                            <p class="text-[11px] uppercase tracking-wide text-slate-500">Venue</p>
                            <p class="mt-2 text-sm font-medium text-white">
                                {{ $event->venue ?: 'Venue TBA' }}
                            </p>
                        </div>

                        <div class="rounded-xl border border-white/10 bg-white/5 p-4 sm:rounded-2xl">
                            <p class="text-[11px] uppercase tracking-wide text-slate-500">Fee</p>
                            <p class="mt-2 text-lg font-semibold text-white">
                                @if(($event->registration_fee ?? 0) > 0)
                                    ₱{{ number_format(($event->registration_fee ?? 0) / 100, 2) }}
                                @else
                                    Free
                                @endif
                            </p>
                        </div>
                    </div>
                </section>

                {{-- Event Attendance Overview --}}
                <section class="rounded-2xl border border-white/10 bg-gradient-to-br from-[#1E3A8A]/20 to-sky-500/10 p-5 shadow-[0_16px_40px_rgba(0,0,0,0.35)] sm:rounded-3xl sm:p-6">
                    <h2 class="text-base font-semibold text-white sm:text-lg">Attendance Overview</h2>
                    <p class="mt-2 text-sm leading-6 text-slate-300">
                        A quick look at the current event response summary from alumni.
                    </p>

                    <div class="mt-5 grid gap-3">
                        <div class="rounded-xl border border-white/10 bg-black/30 p-4 text-slate-200 sm:rounded-2xl">
                            <p class="text-slate-400">Attending</p>
                            <p class="mt-1 text-lg font-semibold text-white">{{ $attendingCount ?? 0 }}</p>
                        </div>

                        <div class="rounded-xl border border-white/10 bg-black/30 p-4 text-slate-200 sm:rounded-2xl">
                            <p class="text-slate-400">Maybe</p>
                            <p class="mt-1 text-lg font-semibold text-white">{{ $maybeCount ?? 0 }}</p>
                        </div>

                        <div class="rounded-xl border border-white/10 bg-black/30 p-4 text-slate-200 sm:rounded-2xl">
                            <p class="text-slate-400">Not Attending</p>
                            <p class="mt-1 text-lg font-semibold text-white">{{ $notAttendingCount ?? 0 }}</p>
                        </div>
                    </div>
                </section>

                {{-- Reminder --}}
                <section class="rounded-2xl border border-white/10 bg-[#020617] shadow-[0_16px_40px_rgba(0,0,0,0.4)] sm:rounded-3xl">
                    <div class="border-b border-white/10 px-4 py-4 sm:px-5">
                        <h2 class="text-base font-semibold text-white sm:text-lg">Reminder</h2>
                    </div>

                    <div class="space-y-3 p-4 text-sm leading-6 text-slate-400 sm:p-5">
                        <p>
                            Please update your RSVP as early as possible so the organizers can prepare seating, food, materials, and logistics properly.
                        </p>

                        <p>
                            If your plans change, you may return to this page and update your attendance response before the event date.
                        </p>
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>