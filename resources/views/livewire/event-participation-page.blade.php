<div class="min-h-screen">
    <div class="mx-auto max-w-7xl space-y-4 px-3 py-4 sm:space-y-6 sm:px-6 sm:py-6 lg:px-8">

        {{-- Header --}}
        <section class="overflow-hidden border border-[#e8e2d6] bg-white">
            <div class="h-1.5 w-full bg-gradient-to-r from-[#d4b06a] via-[#b88a3d] to-[#c9a458]"></div>
            <div class="flex flex-col gap-4 px-4 py-5 sm:px-6 sm:py-6 lg:flex-row lg:items-end lg:justify-between">
                <div class="max-w-3xl">
                    <p class="text-[11px] font-semibold uppercase tracking-[0.2em] text-[#b88a3d] sm:text-xs sm:tracking-[0.24em]">
                        Event Details
                    </p>

                    <h1 class="mt-2 font-serif text-xl font-bold tracking-tight text-[#091852] sm:text-3xl">
                        {{ $event->title }}
                    </h1>

                    <p class="mt-3 text-sm leading-6 text-[#7a7060] sm:text-[15px]">
                        Review the event details and let the organizers know whether you will attend.
                    </p>
                </div>

                <a href="{{ route('dashboard') }}"
                   wire:navigate
                   class="inline-flex items-center justify-center border border-[#e8e2d6] bg-white px-4 py-2.5 text-sm font-medium text-[#1a1410] transition hover:bg-[#faf9f7] hover:border-[#d0c8bc]">
                    Back to Dashboard
                </a>
            </div>
        </section>

        {{-- Alerts --}}
        @if (session('success'))
            <div class="border border-emerald-200 bg-emerald-50 px-4 py-4 text-sm text-emerald-700 sm:px-5">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="border border-rose-200 bg-rose-50 px-4 py-4 text-sm text-rose-700 sm:px-5">
                {{ session('error') }}
            </div>
        @endif

        @php
            $currentStatus = $this->rsvpStatus ?? null;

            $statusBadgeClasses = match($currentStatus) {
                'attending'     => 'border-emerald-300 bg-emerald-50 text-emerald-700',
                'maybe'         => 'border-amber-300 bg-amber-50 text-amber-700',
                'not_attending' => 'border-rose-300 bg-rose-50 text-rose-700',
                default         => 'border-[#d0c8bc] bg-[#f0ebe1] text-[#7a7060]',
            };

            $statusLabel = match($currentStatus) {
                'attending'     => 'Attending',
                'maybe'         => 'Maybe Attending',
                'not_attending' => 'Not Attending',
                default         => 'No Response Yet',
            };

            $isPastEvent = optional($event->event_date)?->isPast() ?? false;
        @endphp

        <div class="grid gap-4 xl:grid-cols-[1.2fr_0.8fr] xl:gap-6">

            {{-- LEFT --}}
            <div class="space-y-4 sm:space-y-6">

                {{-- RSVP SECTION --}}
                <section class="border border-[#e8e2d6] bg-white">
                    <div class="border-b border-[#e8e2d6] px-4 py-4 sm:px-5">
                        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                            <div>
                                <h2 class="text-base font-semibold text-[#1a1410] sm:text-lg">Attendance Confirmation</h2>
                                <p class="mt-1 text-sm text-[#7a7060]">
                                    Confirm whether you will participate in this event.
                                </p>
                            </div>

                            <span class="inline-flex w-fit border px-3 py-1 text-[11px] font-semibold uppercase tracking-wide {{ $statusBadgeClasses }}">
                                {{ $statusLabel }}
                            </span>
                        </div>
                    </div>

                    <div class="p-4 sm:p-5">
                        @if ($isPastEvent)
                            <div class="border border-[#e8e2d6] bg-[#f7f5f1] px-4 py-4 text-sm text-[#7a7060]">
                                This event has already ended. RSVP is now closed.
                            </div>
                        @else
                            <div class="space-y-3">
                                <p class="text-sm font-medium text-[#1a1410]">Will you attend this event?</p>

                                <div class="grid gap-3 sm:grid-cols-3">
                                    <label for="rsvp-attending"
                                        class="cursor-pointer border px-4 py-4 transition
                                        {{ $rsvpStatus === 'attending'
                                            ? 'border-emerald-400 bg-emerald-50 text-emerald-700'
                                            : 'border-[#e8e2d6] bg-white text-[#1a1410] hover:bg-[#faf9f7]' }}">
                                        <div class="flex items-start gap-3">
                                            <input
                                                id="rsvp-attending"
                                                type="radio"
                                                wire:model.live="rsvpStatus"
                                                value="attending"
                                                class="mt-1 h-4 w-4 border-[#d0c8bc] text-emerald-600 focus:ring-emerald-500"
                                            >
                                            <div>
                                                <p class="text-sm font-semibold">Attend</p>
                                                <p class="mt-1 text-xs text-[#7a7060]">
                                                    I plan to join this event.
                                                </p>
                                            </div>
                                        </div>
                                    </label>

                                    <label for="rsvp-maybe"
                                        class="cursor-pointer border px-4 py-4 transition
                                        {{ $rsvpStatus === 'maybe'
                                            ? 'border-amber-400 bg-amber-50 text-amber-700'
                                            : 'border-[#e8e2d6] bg-white text-[#1a1410] hover:bg-[#faf9f7]' }}">
                                        <div class="flex items-start gap-3">
                                            <input
                                                id="rsvp-maybe"
                                                type="radio"
                                                wire:model.live="rsvpStatus"
                                                value="maybe"
                                                class="mt-1 h-4 w-4 border-[#d0c8bc] text-amber-600 focus:ring-amber-500"
                                            >
                                            <div>
                                                <p class="text-sm font-semibold">Maybe</p>
                                                <p class="mt-1 text-xs text-[#7a7060]">
                                                    I am still unsure for now.
                                                </p>
                                            </div>
                                        </div>
                                    </label>

                                    <label for="rsvp-not-attending"
                                        class="cursor-pointer border px-4 py-4 transition
                                        {{ $rsvpStatus === 'not_attending'
                                            ? 'border-rose-400 bg-rose-50 text-rose-700'
                                            : 'border-[#e8e2d6] bg-white text-[#1a1410] hover:bg-[#faf9f7]' }}">
                                        <div class="flex items-start gap-3">
                                            <input
                                                id="rsvp-not-attending"
                                                type="radio"
                                                wire:model.live="rsvpStatus"
                                                value="not_attending"
                                                class="mt-1 h-4 w-4 border-[#d0c8bc] text-rose-600 focus:ring-rose-500"
                                            >
                                            <div>
                                                <p class="text-sm font-semibold">Not Attending</p>
                                                <p class="mt-1 text-xs text-[#7a7060]">
                                                    I will not be able to attend.
                                                </p>
                                            </div>
                                        </div>
                                    </label>
                                </div>

                                <div class="flex flex-col gap-3 border-t border-[#e8e2d6] pt-4 sm:flex-row sm:items-center sm:justify-between">
                                    <div>
                                        <p class="text-[11px] uppercase tracking-wide text-[#9a9080]">Current Response</p>
                                        <p class="mt-1 text-sm font-medium text-[#1a1410]">
                                            {{ $statusLabel }}
                                        </p>
                                    </div>

                                    <button
                                        type="button"
                                        wire:click="saveRsvp"
                                        class="inline-flex items-center justify-center bg-[#d4b06a] px-5 py-2.5 text-sm font-semibold text-[#091852] transition hover:bg-[#c9a458] active:scale-[.98]"
                                    >
                                        Save RSVP
                                    </button>
                                </div>

                                <div class="border border-[#e8e2d6] bg-[#faf9f7] p-4">
                                    <p class="text-sm text-[#7a7060]">
                                        You can still update your response anytime before the event schedule closes.
                                    </p>
                                </div>
                            </div>
                        @endif
                    </div>
                </section>

                {{-- Event Summary --}}
                <section class="border border-[#e8e2d6] bg-white">
                    <div class="border-b border-[#e8e2d6] px-4 py-4 sm:px-5">
                        <h2 class="text-base font-semibold text-[#1a1410] sm:text-lg">Event Summary</h2>
                        <p class="mt-1 text-sm text-[#7a7060]">
                            Important details about this reunion activity.
                        </p>
                    </div>

                    <div class="grid gap-3 p-4 sm:grid-cols-2 sm:gap-4 sm:p-5">
                        <div class="border border-[#e8e2d6] bg-[#faf9f7] p-4">
                            <p class="text-[11px] uppercase tracking-wide text-[#9a9080]">Venue</p>
                            <p class="mt-2 text-sm font-medium text-[#1a1410]">
                                {{ $event->venue ?: 'No venue set' }}
                            </p>
                        </div>

                        <div class="border border-[#e8e2d6] bg-[#faf9f7] p-4">
                            <p class="text-[11px] uppercase tracking-wide text-[#9a9080]">Event Date</p>
                            <p class="mt-2 text-sm font-medium text-[#1a1410]">
                                {{ optional($event->event_date)->format('M d, Y • h:i A') ?: 'Date not set' }}
                            </p>
                        </div>

                        <div class="border border-[#e8e2d6] bg-[#faf9f7] p-4">
                            <p class="text-[11px] uppercase tracking-wide text-[#9a9080]">Dress Code</p>
                            <p class="mt-2 text-sm font-medium text-[#1a1410]">
                                {{ $event->dress_code ?: 'No dress code specified' }}
                            </p>
                        </div>

                        <div class="border border-[#e8e2d6] bg-[#faf9f7] p-4">
                            <p class="text-[11px] uppercase tracking-wide text-[#9a9080]">Registration Fee</p>
                            <p class="mt-2 text-sm font-medium text-[#1a1410]">
                                @if(($event->registration_fee ?? 0) > 0)
                                    ₱{{ number_format(($event->registration_fee ?? 0) / 100, 2) }}
                                @else
                                    Free Event
                                @endif
                            </p>
                        </div>
                    </div>

                    @if ($event->description)
                        <div class="border-t border-[#e8e2d6] px-4 py-4 sm:px-5">
                            <p class="text-[11px] uppercase tracking-wide text-[#9a9080]">Description</p>
                            <div class="mt-2 text-sm leading-7 text-[#4a4235]">
                                {!! nl2br(e($event->description)) !!}
                            </div>
                        </div>
                    @endif
                </section>

                {{-- Program Schedule --}}
                @if ($event->schedules->isNotEmpty())
                    <section class="border border-[#e8e2d6] bg-white">
                        <div class="border-b border-[#e8e2d6] px-4 py-4 sm:px-5">
                            <h2 class="text-base font-semibold text-[#1a1410] sm:text-lg">Program Schedule</h2>
                            <p class="mt-1 text-sm text-[#7a7060]">
                                Event activities and timeline.
                            </p>
                        </div>

                        <div class="space-y-3 p-4 sm:p-5">
                            @foreach ($event->schedules as $schedule)
                                <div class="border border-[#e8e2d6] bg-[#faf9f7] p-4">
                                    <div class="flex flex-col gap-2 sm:flex-row sm:items-start sm:justify-between">
                                        <div class="min-w-0">
                                            <p class="text-sm font-semibold text-[#1a1410]">
                                                {{ $schedule->title }}
                                            </p>

                                            @if ($schedule->description)
                                                <p class="mt-1 text-sm text-[#7a7060]">
                                                    {{ $schedule->description }}
                                                </p>
                                            @endif
                                        </div>

                                        @if ($schedule->schedule_time)
                                            <span class="inline-flex w-fit border border-[#e8e2d6] bg-white px-3 py-1 text-xs text-[#7a7060]">
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
                <section class="border border-[#e8e2d6] bg-white">
                    <div class="border-b border-[#e8e2d6] px-4 py-4 sm:px-5">
                        <h2 class="text-base font-semibold text-[#1a1410] sm:text-lg">My Attendance Status</h2>
                    </div>

                    <div class="grid gap-3 p-4 sm:p-5">
                        <div class="border border-[#e8e2d6] bg-[#faf9f7] p-4">
                            <p class="text-[11px] uppercase tracking-wide text-[#9a9080]">Current RSVP</p>
                            <p class="mt-2 text-sm font-medium text-[#1a1410]">{{ $statusLabel }}</p>
                        </div>

                        <div class="border border-[#e8e2d6] bg-[#faf9f7] p-4">
                            <p class="text-[11px] uppercase tracking-wide text-[#9a9080]">Event Date</p>
                            <p class="mt-2 text-sm font-medium text-[#1a1410]">
                                {{ optional($event->event_date)->format('M d, Y • h:i A') ?: 'Date not set' }}
                            </p>
                        </div>

                        <div class="border border-[#e8e2d6] bg-[#faf9f7] p-4">
                            <p class="text-[11px] uppercase tracking-wide text-[#9a9080]">Venue</p>
                            <p class="mt-2 text-sm font-medium text-[#1a1410]">
                                {{ $event->venue ?: 'Venue TBA' }}
                            </p>
                        </div>

                        <div class="border border-[#e8e2d6] bg-[#faf9f7] p-4">
                            <p class="text-[11px] uppercase tracking-wide text-[#9a9080]">Fee</p>
                            <p class="mt-2 text-lg font-semibold text-[#1a1410]">
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
                <section class="border border-[#e8e2d6] bg-white p-5 sm:p-6">
                    <h2 class="text-base font-semibold text-[#1a1410] sm:text-lg">Attendance Overview</h2>
                    <p class="mt-2 text-sm leading-6 text-[#7a7060]">
                        A quick look at the current event response summary from alumni.
                    </p>

                    <div class="mt-5 grid gap-3">
                        <div class="border border-[#e8e2d6] bg-[#faf9f7] p-4">
                            <p class="text-sm text-[#7a7060]">Attending</p>
                            <p class="mt-1 text-lg font-semibold text-emerald-700">{{ $attendingCount ?? 0 }}</p>
                        </div>

                        <div class="border border-[#e8e2d6] bg-[#faf9f7] p-4">
                            <p class="text-sm text-[#7a7060]">Maybe</p>
                            <p class="mt-1 text-lg font-semibold text-amber-600">{{ $maybeCount ?? 0 }}</p>
                        </div>

                        <div class="border border-[#e8e2d6] bg-[#faf9f7] p-4">
                            <p class="text-sm text-[#7a7060]">Not Attending</p>
                            <p class="mt-1 text-lg font-semibold text-rose-600">{{ $notAttendingCount ?? 0 }}</p>
                        </div>
                    </div>
                </section>

                {{-- Reminder --}}
                <section class="border border-[#e8e2d6] bg-white">
                    <div class="border-b border-[#e8e2d6] px-4 py-4 sm:px-5">
                        <h2 class="text-base font-semibold text-[#1a1410] sm:text-lg">Reminder</h2>
                    </div>

                    <div class="space-y-3 p-4 text-sm leading-6 text-[#7a7060] sm:p-5">
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
