<div class="min-h-screen">
    <div class="mx-auto max-w-screen-xl px-4 py-6 sm:px-6 sm:py-8 lg:px-8">

        {{-- Header --}}
        <section class="mb-6 overflow-hidden border border-[#e8e2d6] bg-white">
            <div class="h-1.5 w-full bg-gradient-to-r from-[#d4b06a] via-[#b88a3d] to-[#c9a458]"></div>
            <div class="px-6 py-7 sm:px-8">
                <p class="text-[10px] font-semibold uppercase tracking-[.2em] text-[#b88a3d]">Staff Portal</p>
                <h1 class="mt-1.5 font-serif text-[26px] font-normal leading-tight text-[#091852] sm:text-[32px]">
                    Welcome, {{ auth()->user()->staff?->fname ?? 'Staff' }}!
                </h1>
                <p class="mt-1.5 text-sm text-[#7a7060]">
                    Review the upcoming reunion events and confirm your attendance below.
                </p>
            </div>
        </section>

        @include('partials.toast')

        {{-- Section label --}}
        <div class="mb-4">
            <h2 class="text-[18px] font-semibold text-[#1a1410]">Attendance Confirmation</h2>
            <p class="mt-0.5 text-[13px] text-[#7a7060]">
                Let the organizers know whether you will attend each reunion event.
            </p>
        </div>

        {{-- Events table --}}
        <section class="border border-[#e8e2d6] bg-white">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-[#e8e2d6] bg-[#faf9f7]">
                            <th class="px-5 py-3.5 text-left text-[11px] font-semibold uppercase tracking-[.12em] text-[#9a9080]">Event</th>
                            <th class="px-5 py-3.5 text-left text-[11px] font-semibold uppercase tracking-[.12em] text-[#9a9080]">Date & Venue</th>
                            <th class="px-5 py-3.5 text-left text-[11px] font-semibold uppercase tracking-[.12em] text-[#9a9080]">Your Status</th>
                            <th class="px-5 py-3.5 text-left text-[11px] font-semibold uppercase tracking-[.12em] text-[#9a9080]">Attendance</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#e8e2d6]">
                        @forelse ($events as $event)
                            @php
                                $status     = $myRsvps[$event->id] ?? null;
                                $isPast     = $event->event_date?->isPast();

                                $badgeClass = match($status) {
                                    'attending'     => 'border-emerald-300 bg-emerald-50 text-emerald-700',
                                    'maybe'         => 'border-amber-300 bg-amber-50 text-amber-700',
                                    'not_attending' => 'border-rose-300 bg-rose-50 text-rose-700',
                                    default         => 'border-[#d0c8bc] bg-[#f0ebe1] text-[#7a7060]',
                                };

                                $badgeLabel = match($status) {
                                    'attending'     => 'Attending',
                                    'maybe'         => 'Maybe',
                                    'not_attending' => 'Not Attending',
                                    default         => 'No Response',
                                };
                            @endphp
                            <tr class="hover:bg-[#faf9f7] transition-colors">
                                {{-- Event name --}}
                                <td class="px-5 py-4">
                                    <p class="font-semibold text-[#1a1410]">{{ $event->title }}</p>
                                    @if(($event->registration_fee ?? 0) > 0)
                                        <span class="mt-1 inline-flex items-center bg-[#f5d400] px-2 py-0.5 text-[11px] font-semibold text-black">
                                            Paid — ₱{{ number_format($event->registration_fee / 100, 2) }}
                                        </span>
                                    @else
                                        <span class="mt-1 inline-flex items-center border border-[#e8e2d6] px-2 py-0.5 text-[11px] font-semibold text-[#7a7060]">
                                            Free
                                        </span>
                                    @endif
                                </td>

                                {{-- Date & Venue --}}
                                <td class="px-5 py-4 text-[#4a4235]">
                                    <p>{{ $event->event_date?->format('M d, Y') }}</p>
                                    <p class="text-[#9a9080]">{{ $event->event_date?->format('h:i A') }}</p>
                                    <p class="mt-1 text-xs text-[#7a7060]">{{ $event->venue ?: 'Venue TBA' }}</p>
                                </td>

                                {{-- Status badge --}}
                                <td class="px-5 py-4">
                                    <span class="inline-flex border px-2.5 py-1 text-[11px] font-semibold uppercase tracking-wide {{ $badgeClass }}">
                                        {{ $badgeLabel }}
                                    </span>
                                </td>

                                {{-- Action buttons --}}
                                <td class="px-5 py-4">
                                    @if ($isPast)
                                        <span class="text-xs text-[#9a9080] italic">Event ended</span>
                                    @else
                                        <div class="flex flex-wrap gap-2">
                                            <button
                                                type="button"
                                                wire:click="saveRsvp({{ $event->id }}, 'attending')"
                                                class="border px-3 py-1.5 text-xs font-semibold transition active:scale-[.97]
                                                    {{ $status === 'attending'
                                                        ? 'border-emerald-400 bg-emerald-50 text-emerald-700'
                                                        : 'border-[#e8e2d6] bg-white text-[#1a1410] hover:border-emerald-300 hover:bg-emerald-50 hover:text-emerald-700' }}"
                                            >
                                                Attending
                                            </button>

                                            <button
                                                type="button"
                                                wire:click="saveRsvp({{ $event->id }}, 'maybe')"
                                                class="border px-3 py-1.5 text-xs font-semibold transition active:scale-[.97]
                                                    {{ $status === 'maybe'
                                                        ? 'border-amber-400 bg-amber-50 text-amber-700'
                                                        : 'border-[#e8e2d6] bg-white text-[#1a1410] hover:border-amber-300 hover:bg-amber-50 hover:text-amber-700' }}"
                                            >
                                                Maybe
                                            </button>

                                            <button
                                                type="button"
                                                wire:click="saveRsvp({{ $event->id }}, 'not_attending')"
                                                class="border px-3 py-1.5 text-xs font-semibold transition active:scale-[.97]
                                                    {{ $status === 'not_attending'
                                                        ? 'border-rose-400 bg-rose-50 text-rose-700'
                                                        : 'border-[#e8e2d6] bg-white text-[#1a1410] hover:border-rose-300 hover:bg-rose-50 hover:text-rose-700' }}"
                                            >
                                                Not Attending
                                            </button>
                                        </div>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-20 text-center text-sm text-[#9a9080]">
                                    No active events at the moment.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Footer note --}}
            @if ($events->isNotEmpty())
                <div class="border-t border-[#e8e2d6] bg-[#faf9f7] px-5 py-3">
                    <p class="text-xs text-[#9a9080]">
                        You can update your response anytime before an event ends.
                    </p>
                </div>
            @endif
        </section>

    </div>
</div>
