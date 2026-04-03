<div class="min-h-screen bg-[#f7f5f1]">
    <div class="mx-auto max-w-screen-2xl px-4 py-6 sm:px-6 sm:py-8 lg:px-8 xl:px-12">

        {{-- ===== HEADER ===== --}}
        <section class="mb-6 -mx-4 bg-white sm:mx-0 sm:overflow-hidden sm:rounded-[20px] sm:border sm:border-[#e8e2d6]">
            <div class="h-1.5 w-full bg-gradient-to-r from-[#d4b06a] via-[#b88a3d] to-[#c9a458]"></div>

            <div class="flex flex-col gap-5 px-6 py-7 sm:px-8 lg:flex-row lg:items-center lg:justify-between">
                <div>
                    <p class="text-[10px] font-semibold uppercase tracking-[.2em] text-[#b88a3d]">Alumni Portal</p>
                    <h1 class="mt-1.5 font-serif text-[28px] font-normal leading-tight text-[#091852] sm:text-[34px]">
                        Welcome back, {{ $user->username ?? 'Alumnus' }}
                    </h1>
                    <p class="mt-1.5 text-sm text-[#7a7060]">
                        View upcoming reunion events, confirm your attendance, and check your payment status.
                    </p>
                </div>

                <div class="flex shrink-0 flex-col gap-3 sm:flex-row">
                    <a href="{{ route('profile.edit') }}"
                       class="inline-flex items-center justify-center rounded-[10px] border border-[#e8e2d6] bg-white px-5 py-2.5 text-sm font-medium text-[#1a1410] transition hover:bg-[#faf9f7] hover:border-[#d0c8bc]">
                        Update Profile
                    </a>
                    <a href="{{ route('profile.edit') }}#volunteer-section"
                       class="inline-flex items-center justify-center rounded-[10px] bg-[#d4b06a] px-5 py-2.5 text-sm font-medium text-[#091852] transition hover:bg-[#c9a458] active:scale-[.98]">
                        Committee Interest
                    </a>
                </div>
            </div>
        </section>

        {{-- ===== BODY: two-column on lg+ ===== --}}
        <div class="lg:flex lg:items-start lg:gap-6 xl:gap-8">

            {{-- ===== LEFT: Events (main) ===== --}}
            <div class="min-w-0 flex-1 space-y-6">

                {{-- Active Events --}}
                <section class="-mx-4 bg-white sm:mx-0 sm:overflow-hidden sm:rounded-[20px] sm:border sm:border-[#e8e2d6]">
                    <div class="border-b-2 border-[#e8e2d6] px-6 py-5 sm:px-8">
                        <h2 class="text-[18px] font-semibold text-[#1a1410]">Active Events</h2>
                        <p class="mt-0.5 text-[13px] text-[#7a7060]">
                            Browse active reunion events, confirm your attendance, and view your payment status.
                        </p>
                    </div>

                    <div>

                        @forelse ($upcomingEvents as $event)
                            @php
                                $userRsvp = $event->rsvps->firstWhere('alumni_id', auth()->user()?->alumni_id);

                                $rsvpLabel = match($userRsvp?->status) {
                                    'attending'     => 'Attending',
                                    'maybe'         => 'Maybe',
                                    'not_attending' => 'Not Attending',
                                    default         => 'No Response Yet',
                                };

                                $rsvpBadgeClasses = match($userRsvp?->status) {
                                    'attending'     => 'bg-emerald-50 text-emerald-700 ring-emerald-600/20',
                                    'maybe'         => 'bg-amber-50 text-amber-700 ring-amber-600/20',
                                    'not_attending' => 'bg-rose-50 text-rose-700 ring-rose-600/20',
                                    default         => 'bg-[#f0ebe1] text-[#7a7060] ring-[#d0c8bc]/40',
                                };

                                $userRegistration = $event->registrations->firstWhere('alumni_id', auth()->user()?->alumni_id);

                                if (($event->registration_fee ?? 0) <= 0) {
                                    $paymentLabel        = 'Free';
                                    $paymentBadgeClasses = 'bg-emerald-50 text-emerald-700 ring-emerald-600/20';
                                } else {
                                    $paymentStatus = $userRegistration?->status ?? 'unpaid';
                                    $paymentLabel  = match($paymentStatus) {
                                        'paid'   => 'Paid',
                                        'waived' => 'Waived',
                                        default  => 'Unpaid',
                                    };
                                    $paymentBadgeClasses = match($paymentStatus) {
                                        'paid'   => 'bg-sky-50 text-sky-700 ring-sky-600/20',
                                        'waived' => 'bg-violet-50 text-violet-700 ring-violet-600/20',
                                        default  => 'bg-amber-50 text-amber-700 ring-amber-600/20',
                                    };
                                }
                            @endphp

                            <article class="border-b-2 border-[#e8e2d6] px-6 py-6 last:border-b-0 transition hover:bg-[#faf9f7] sm:px-8">

                                {{-- Title + status badges --}}
                                <div class="flex flex-wrap items-center gap-2">
                                    <h3 class="text-[16px] font-semibold leading-snug text-[#1a1410]">
                                        {{ $event->title }}
                                    </h3>
                                    <span class="inline-flex items-center rounded-full px-2.5 py-1 text-[11px] font-semibold uppercase tracking-wide ring-1 ring-inset {{ $rsvpBadgeClasses }}">
                                        {{ $rsvpLabel }}
                                    </span>
                                    <span class="inline-flex items-center rounded-full px-2.5 py-1 text-[11px] font-semibold uppercase tracking-wide ring-1 ring-inset {{ $paymentBadgeClasses }}">
                                        {{ $paymentLabel }}
                                    </span>
                                </div>

                                {{-- Meta chips --}}
                                <div class="mt-3 flex flex-wrap gap-2">
                                    <span class="inline-flex items-center gap-1.5 rounded-lg bg-[#f0ebe1] px-3 py-1.5 text-[13px] text-[#7a7060]">
                                        <svg class="size-3.5 shrink-0 text-[#9a9080]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" /></svg>
                                        {{ $event->event_date?->format('M d, Y • h:i A') }}
                                    </span>
                                    <span class="inline-flex items-center gap-1.5 rounded-lg bg-[#f0ebe1] px-3 py-1.5 text-[13px] text-[#7a7060]">
                                        <svg class="size-3.5 shrink-0 text-[#9a9080]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" /><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" /></svg>
                                        {{ $event->venue ?: 'Venue TBA' }}
                                    </span>
                                </div>

                                @if ($event->description)
                                    <p class="mt-3 text-[13px] leading-6 text-[#7a7060]">
                                        {{ \Illuminate\Support\Str::limit(strip_tags($event->description), 200) }}
                                    </p>
                                @endif

                                {{-- Bottom row: fee + CTA --}}
                                <div class="mt-5 flex flex-col gap-4 border-t border-[#f0ebe1] pt-5 sm:flex-row sm:items-center sm:justify-between">
                                    <div>
                                        <p class="text-[11px] font-semibold uppercase tracking-[.06em] text-[#9a9080]">Event Fee</p>
                                        <p class="mt-1 text-[22px] font-semibold text-[#1a1410]">
                                            @if(($event->registration_fee ?? 0) > 0)
                                                ₱{{ number_format(($event->registration_fee ?? 0) / 100, 2) }}
                                            @else
                                                <span class="text-[#b88a3d]">Free</span>
                                            @endif
                                        </p>
                                    </div>

                                    <a href="{{ route('alumni.events.show', $event) }}"
                                       class="inline-flex w-full items-center justify-center rounded-[10px] bg-[#d4b06a] px-6 py-2.5 text-sm font-medium text-[#091852] transition hover:bg-[#c9a458] active:scale-[.98] sm:w-auto sm:shrink-0">
                                        View Details &amp; RSVP
                                    </a>
                                </div>

                            </article>
                        @empty
                            <div class="px-6 py-16 text-center text-sm text-[#9a9080]">
                                No active events yet
                            </div>
                        @endforelse

                    </div>

                    @if ($upcomingEvents->hasPages())
                        <div class="border-t-2 border-[#e8e2d6] px-6 py-5 sm:px-8">
                            {{ $upcomingEvents->links() }}
                        </div>
                    @endif
                </section>

            </div>
        </div>

    </div>
</div>
