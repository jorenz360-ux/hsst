<div>
    <section id="news">
        <div class="mx-auto max-w-[1200px] px-5 py-12 md:px-6 lg:py-[4.5rem]">
            <div class="mb-8 flex flex-col items-start justify-between gap-4 sm:flex-row sm:items-end">
                <div>
                    <div class="mb-3 inline-flex items-center gap-2 text-[10px] font-bold uppercase tracking-[0.22em] text-teal-400 before:h-px before:w-5 before:bg-teal-400/50 before:content-['']">
                        News & Events
                    </div>
                    <h2 class="font-dm-serif text-[1.7rem] font-normal leading-[1.12] tracking-[-0.018em] text-zinc-100 sm:text-[2rem] lg:text-[2.5rem]">
                        Latest announcements and upcoming school events
                    </h2>
                </div>

                <a href="#" class="whitespace-nowrap border-b border-teal-400/20 pb-px text-[13px] font-medium text-teal-400 transition hover:text-teal-300">
                    View all →
                </a>
            </div>

       <div class="grid grid-cols-1 gap-3.5 lg:grid-cols-[1.55fr_1fr]">
    {{-- Main Event Card --}}
    @if ($event)
        <a href="#"
            class="flex flex-col overflow-hidden rounded-2xl border border-white/10 bg-white/[0.03] text-left no-underline transition hover:-translate-y-0.5 hover:border-teal-400/20">
            
            <div class="relative h-[220px] overflow-hidden">
                <img
                    src="{{ asset('images/100yearsevent.jpg') }}"
                    alt="{{ $event->title }}"
                    class="h-full w-full object-cover"
                >
                <div class="absolute inset-0 bg-[linear-gradient(155deg,rgba(13,148,136,0.16)_0%,rgba(9,9,11,0.70)_100%)]"></div>
            </div>

            <div class="flex flex-1 flex-col gap-[7px] p-6">
                <span class="inline-block w-fit rounded border border-teal-400/20 bg-teal-400/10 px-2 py-[3px] text-[10px] font-bold uppercase tracking-[0.14em] text-teal-400">
                    Event
                </span>

                <div class="font-dm-serif text-[19px] font-normal leading-[1.28] text-zinc-100">
                    {{ $event->title }}
                </div>

                @if($event->dress_code)
                    <p class="text-[12px] font-medium text-zinc-100">
                        {{ $event->dress_code }}
                    </p>
                @endif

                <p class="text-[12.5px] font-light leading-[1.65] text-zinc-100">
                    {{ \Illuminate\Support\Str::limit($event->description, 600) }}
                </p>

                <div class="mt-auto border-t border-white/10 pt-2.5 text-[11.5px] text-zinc-600">
                    {{ \Carbon\Carbon::parse($event->event_date)->format('F d, Y') }}
                    @if($event->schedules->first()?->schedule_time)
                        · {{ \Carbon\Carbon::parse($event->schedules->first()->schedule_time)->format('g:i A') }}
                    @endif
                    @if($event->venue)
                        · {{ $event->venue }}
                    @endif
                </div>
            </div>
        </a>
    @else
        <div class="flex flex-col overflow-hidden rounded-2xl border border-white/10 bg-white/[0.03] text-left">
            <div class="relative h-[220px] overflow-hidden">
                <img
                    src="{{ asset('images/100yearsevent.jpg') }}"
                    alt="No upcoming event"
                    class="h-full w-full object-cover opacity-60"
                >
                <div class="absolute inset-0 bg-[linear-gradient(155deg,rgba(63,63,70,0.20)_0%,rgba(9,9,11,0.82)_100%)]"></div>
            </div>

            <div class="flex flex-1 flex-col gap-[7px] p-6">
                <span class="inline-block w-fit rounded border border-zinc-700 bg-zinc-800 px-2 py-[3px] text-[10px] font-bold uppercase tracking-[0.14em] text-zinc-300">
                    Event
                </span>

                <div class="font-dm-serif text-[19px] font-normal leading-[1.28] text-zinc-100">
                    No upcoming event yet
                </div>

                <p class="text-[12.5px] font-light leading-[1.65] text-zinc-600">
                    Please check back soon for the next scheduled school or alumni event.
                </p>

                <div class="mt-auto border-t border-white/10 pt-2.5 text-[11.5px] text-zinc-600">
                    Stay tuned for updates
                </div>
            </div>
        </div>
    @endif

    {{-- Announcement Carousel --}}
    <div
        x-data="{
            current: 0,
            total: {{ max($announcements->count(), 1) }},
            init() {
                if (this.total > 1) {
                    setInterval(() => {
                        this.next()
                    }, 5000)
                }
            },
            next() {
                this.current = (this.current + 1) % this.total
            },
            prev() {
                this.current = (this.current - 1 + this.total) % this.total
            }
        }"
        class="relative overflow-hidden rounded-2xl border border-white/10 bg-white/[0.03]"
    >
        @if ($announcements->count())
            <div class="relative h-full min-h-[220px]">
                @foreach ($announcements as $index => $announcement)
                    <div
                        x-show="current === {{ $index }}"
                        x-transition:enter="transition ease-out duration-500"
                        x-transition:enter-start="opacity-0 translate-x-3"
                        x-transition:enter-end="opacity-100 translate-x-0"
                        x-transition:leave="transition ease-in duration-300"
                        x-transition:leave-start="opacity-100 translate-x-0"
                        x-transition:leave-end="opacity-0 -translate-x-3"
                        class="absolute inset-0 flex h-full flex-col"
                    >
                        <div class="flex h-[108px] items-center justify-center bg-[linear-gradient(155deg,rgba(168,85,247,0.12)_0%,rgba(9,9,11,0.97)_100%)] px-4 text-center">
                            <div>
                                <span class="inline-block rounded border border-violet-400/20 bg-violet-400/10 px-2 py-[3px] text-[10px] font-bold uppercase tracking-[0.14em] text-violet-400">
                                    Announcement
                                </span>
                                @if($announcement->pinned)
                                    <span class="ml-2 inline-block rounded border border-amber-400/20 bg-amber-400/10 px-2 py-[3px] text-[10px] font-bold uppercase tracking-[0.14em] text-amber-300">
                                        Pinned
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="flex flex-1 flex-col gap-[8px] p-5">
                            <div class="text-[15px] font-semibold leading-[1.4] tracking-[-0.01em] text-zinc-100">
                                {{ $announcement->title }}
                            </div>

                            <p class="text-[12.5px] font-light leading-[1.7] text-zinc-300">
                                {{ \Illuminate\Support\Str::limit(strip_tags($announcement->content), 220) }}
                            </p>

                            <div class="mt-auto border-t border-white/10 pt-2.5 text-[11.5px] text-zinc-500">
                                @if($announcement->published_at)
                                    {{ $announcement->published_at->format('F d, Y') }}
                                @else
                                    Recently published
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Controls --}}
            @if($announcements->count() > 1)
                <div class="absolute inset-x-0 bottom-3 z-10 flex items-center justify-between px-4">
                    <div class="flex items-center gap-1.5">
                        @foreach ($announcements as $index => $announcement)
                            <button
                                type="button"
                                @click="current = {{ $index }}"
                                class="h-2 rounded-full transition-all"
                                :class="current === {{ $index }} ? 'w-6 bg-white' : 'w-2 bg-white/30'"
                                aria-label="Go to slide {{ $index + 1 }}"
                            ></button>
                        @endforeach
                    </div>

                    <div class="flex items-center gap-2">
                        <button
                            type="button"
                            @click="prev()"
                            class="inline-flex h-8 w-8 items-center justify-center rounded-full border border-white/10 bg-black/30 text-zinc-300 transition hover:border-white/20 hover:text-white"
                            aria-label="Previous announcement"
                        >
                            ‹
                        </button>
                        <button
                            type="button"
                            @click="next()"
                            class="inline-flex h-8 w-8 items-center justify-center rounded-full border border-white/10 bg-black/30 text-zinc-300 transition hover:border-white/20 hover:text-white"
                            aria-label="Next announcement"
                        >
                            ›
                        </button>
                    </div>
                </div>
            @endif
        @else
            <div class="flex h-full min-h-[220px] flex-col">
                <div class="flex h-[108px] items-center justify-center bg-[linear-gradient(155deg,rgba(113,113,122,0.10)_0%,rgba(9,9,11,0.97)_100%)] text-[11px] italic text-zinc-600">
                    No active announcements
                </div>

                <div class="flex flex-1 flex-col gap-[7px] p-5">
                    <span class="inline-block w-fit rounded border border-zinc-700 bg-zinc-800 px-2 py-[3px] text-[10px] font-bold uppercase tracking-[0.14em] text-zinc-300">
                        Announcement
                    </span>

                    <div class="text-[14.5px] font-semibold leading-[1.4] tracking-[-0.01em] text-zinc-100">
                        No announcements available
                    </div>

                    <p class="text-[12.5px] font-light leading-[1.65] text-zinc-600">
                        Please check back later for important school and alumni updates.
                    </p>

                    <div class="mt-auto border-t border-white/10 pt-2.5 text-[11.5px] text-zinc-600">
                        Stay tuned
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
        </div>
    </section>
</div>