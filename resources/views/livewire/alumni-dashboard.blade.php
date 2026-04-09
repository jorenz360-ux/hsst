<div class="min-h-screen">
    <div class="mx-auto max-w-screen-2xl px-4 py-6 sm:px-6 sm:py-8 lg:px-8 xl:px-12">

        {{-- ===== HEADER ===== --}}
        <section class="mb-6 overflow-hidden border  bg-white">

            <div class="flex flex-col gap-5 px-6 py-7 sm:px-8 lg:flex-row lg:items-center lg:justify-between">
                <div>
                    <p class="text-[10px] font-semibold uppercase tracking-[.2em] text-[#b88a3d]">Alumni Portal</p>
                    <h1 class="mt-1.5 font-serif text-[26px] font-normal leading-tight text-[#091852] sm:text-[32px]">
                        Welcome back, {{ $user->username ?? 'Alumnus' }}
                    </h1>
                    <p class="mt-1.5 text-sm text-[#7a7060]">
                        View upcoming reunion events, confirm your attendance, and check your payment status.
                    </p>
                </div>

                <div class="flex shrink-0 flex-col gap-3 sm:flex-row">
                    <a href="{{ route('profile.edit') }}"
                       class="inline-flex items-center justify-center border border-[#e8e2d6] bg-white px-5 py-3 text-sm font-medium text-[#1a1410] transition hover:bg-[#faf9f7] hover:border-[#d0c8bc]">
                        Update Profile
                    </a>
                    <a href="{{ route('profile.edit') }}#volunteer-section"
                       class="inline-flex items-center justify-center bg-[#d4b06a] px-5 py-3 text-sm font-medium text-[#091852] transition hover:bg-[#c9a458] active:scale-[.98]">
                        Committee Interest
                    </a>
                </div>
            </div>
        </section>

        {{-- ===== SECTION LABEL ===== --}}
        <div class="mb-4">
            <h2 class="text-[18px] font-semibold text-[#1a1410]">Active Events</h2>
            <p class="mt-0.5 text-[13px] text-[#7a7060]">
                Browse active reunion events, confirm your attendance, and view your payment status.
            </p>
        </div>

        {{-- ===== EVENT CARDS GRID ===== --}}
        {{-- Mobile: single column stack | md: 2-col | xl: 3-col --}}
        <div class="grid grid-cols-1 gap-4 md:grid-cols-2 md:gap-5 xl:grid-cols-3 xl:gap-6">

            @forelse ($upcomingEvents as $event)
              @php
                $userRsvp = $event->rsvps->firstWhere('alumni_id', auth()->user()?->alumni_id);

                $rsvpLabel = match($userRsvp?->status) {
                    'attending'     => 'Attending',
                    'maybe'         => 'Maybe',
                    'not_attending' => 'Not Attending',
                    default         => 'No Response',
                };

                $categoryLabel = match($userRsvp?->status) {
                    'attending'     => 'Confirmed',
                    'maybe'         => 'Maybe',
                    'not_attending' => 'Unavailable',
                    default         => 'Event',
                };

                $bannerUrl = $event->banner_image
                    ? \Illuminate\Support\Facades\Storage::disk('s3')->url($event->banner_image)
                    : 'https://placehold.co/900x700?text=Event+Banner';
            @endphp

                   <article class="group">
    <a href="{{ route('alumni.events.show', $event) }}" class="block">
        {{-- Banner --}}
        <div class="aspect-[4/3] w-full overflow-hidden bg-neutral-200">
            <img
                src="{{ $bannerUrl }}"
                alt="{{ $event->title }}"
                class="h-full w-full object-cover transition duration-500 group-hover:scale-[1.03]"
                loading="lazy"
            >
        </div>

        {{-- Content --}}
        <div class="pt-4">
            {{-- Tags --}}
            <div class="mb-4 flex flex-wrap gap-2">
                <span class="inline-flex items-center border border-black px-2.5 py-1 text-[12px] font-semibold tracking-tight text-black">
                    {{ $categoryLabel }}
                </span>

                @if($event->registration_fee > 0)
                    <span class="inline-flex items-center bg-[#f5d400] px-2.5 py-1 text-[12px] font-semibold tracking-tight text-black">
                        Paid Event
                    </span>
                @else
                    <span class="inline-flex items-center bg-[#f5d400] px-2.5 py-1 text-[12px] font-semibold tracking-tight text-black">
                        Free
                    </span>
                @endif
            </div>

            {{-- Title --}}
            <h3 class="font-serif text-[30px] leading-[1.05] tracking-[-0.02em] text-[#161616]">
                {{ $event->title }}
            </h3>

            {{-- Meta --}}
            <div class="mt-4 space-y-3 text-[15px] text-[#1f1f1f]">
                <div class="flex items-start gap-3">
                    <svg class="mt-0.5 size-5 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                    </svg>
                    <span>{{ $event->event_date?->format('M d, Y • h:i A') }}</span>
                </div>

                <div class="flex items-start gap-3">
                    <svg class="mt-0.5 size-5 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                    </svg>
                    <span>{{ $event->venue ?: 'Venue TBA' }}</span>
                </div>
            </div>
        </div>
    </a>
</article>

            @empty
                <div class="col-span-full border border-dashed border-[#e8e2d6] bg-white py-20 text-center text-sm text-[#9a9080]">
                    No active events yet
                </div>
            @endforelse

        </div>

        {{-- Pagination --}}
        @if ($upcomingEvents->hasPages())
            <div class="mt-6">
                {{ $upcomingEvents->links() }}
            </div>
        @endif

    </div>
</div>
