<div>
   <section id="events" class="py-14 lg:py-20">
    <div class="mx-auto max-w-[1200px] px-5 md:px-6">
        <div class="mb-8 flex items-end justify-between gap-4">
            <div>
                <p class="mb-2 text-[11px] font-semibold uppercase tracking-[0.18em] text-teal-400">
                    Upcoming Events
                </p>
                <h2 class="font-dm-serif text-[1.9rem] leading-none text-zinc-100 sm:text-[2.3rem]">
                    School & Alumni Gatherings
                </h2>
            </div>

            <a href="{{ route('events.index') }}"
               class="hidden text-sm font-medium text-zinc-400 transition hover:text-zinc-100 sm:inline-block">
                View all events
            </a>
        </div>

        @if ($events->isNotEmpty())
            <div class="relative">
                <button
                    type="button"
                    onclick="document.getElementById('events-carousel').scrollBy({ left: -1200, behavior: 'smooth' })"
                    class="absolute left-2 top-1/2 z-10 hidden -translate-y-1/2 rounded-full border border-white/10 bg-zinc-950/80 p-3 text-white backdrop-blur lg:flex"
                    aria-label="Previous events"
                >
                    ‹
                </button>

                <div id="events-carousel" class="no-scrollbar overflow-x-auto scroll-smooth">
                    <div class="flex min-w-max gap-5">
                        @foreach ($events as $event)
                            <article
                                class="group w-[85vw] max-w-[380px] flex-shrink-0 overflow-hidden rounded-2xl border border-white/10 bg-white/[0.03] transition hover:-translate-y-1 hover:border-teal-400/20 sm:w-[48%] lg:w-[calc((100%-2.5rem)/3)]"
                            >
                                <div class="relative h-[220px] overflow-hidden">
                                    <img
                                        src="{{ asset('images/100yearsevent.jpg') }}"
                                        alt="{{ $event->title }}"
                                        class="h-full w-full object-cover transition duration-500 group-hover:scale-105"
                                    >
                                    <div class="absolute inset-0 bg-gradient-to-t from-zinc-950/80 to-transparent"></div>

                                    <div class="absolute left-4 top-4">
                                        <span class="inline-flex rounded-full border border-teal-400/20 bg-teal-400/10 px-3 py-1 text-[10px] font-bold uppercase tracking-[0.14em] text-teal-300">
                                            Upcoming Event
                                        </span>
                                    </div>
                                </div>

                                <div class="flex h-full flex-col p-5">
                                    <h3 class="font-dm-serif text-[1.15rem] leading-[1.3] text-zinc-100">
                                        <a href="{{ route('events.show', $event) }}" class="transition hover:text-teal-300">
                                            {{ $event->title }}
                                        </a>
                                    </h3>

                                    @if ($event->dress_code)
                                        <p class="mt-2 text-[12px] font-medium text-zinc-300">
                                            Dress Code: {{ $event->dress_code }}
                                        </p>
                                    @endif

                                    <p class="mt-3 text-[12.8px] leading-[1.75] text-zinc-400">
                                        {{ \Illuminate\Support\Str::limit($event->description, 140) }}
                                    </p>

                                    <div class="mt-5 border-t border-white/10 pt-3 text-[11.5px] text-zinc-400">
                                        {{ \Carbon\Carbon::parse($event->event_date)->format('F d, Y') }}

                                        @if ($event->schedules->first()?->schedule_time)
                                            · {{ \Carbon\Carbon::parse($event->schedules->first()->schedule_time)->format('g:i A') }}
                                        @endif

                                        @if ($event->venue)
                                            <div class="mt-1">{{ $event->venue }}</div>
                                        @endif
                                    </div>

                                    <div class="mt-5">
                                        <a
                                            href="{{ route('events.show', $event) }}"
                                            class="inline-flex items-center gap-2 rounded-full border border-teal-400/20 bg-teal-400/10 px-4 py-2 text-[12px] font-semibold text-teal-300 transition hover:border-teal-400/30 hover:bg-teal-400/15 hover:text-teal-200"
                                        >
                                            Read more
                                            <span aria-hidden="true">→</span>
                                        </a>
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </div>
                </div>

                <button
                    type="button"
                    onclick="document.getElementById('events-carousel').scrollBy({ left: 1200, behavior: 'smooth' })"
                    class="absolute right-2 top-1/2 z-10 hidden -translate-y-1/2 rounded-full border border-white/10 bg-zinc-950/80 p-3 text-white backdrop-blur lg:flex"
                    aria-label="Next events"
                >
                    ›
                </button>
            </div>

            <div class="mt-4 sm:hidden">
                <a href="{{ route('events.index') }}"
                   class="inline-block text-sm font-medium text-zinc-400 transition hover:text-zinc-100">
                    View all events
                </a>
            </div>
        @else
            <div class="overflow-hidden rounded-2xl border border-white/10 bg-white/[0.03]">
                <div class="relative h-[220px] overflow-hidden">
                    <img
                        src="{{ asset('images/100yearsevent.jpg') }}"
                        alt="No upcoming event"
                        class="h-full w-full object-cover opacity-60"
                    >
                    <div class="absolute inset-0 bg-gradient-to-t from-zinc-950/80 to-transparent"></div>
                </div>

                <div class="p-6">
                    <span class="inline-block rounded-full border border-zinc-700 bg-zinc-800 px-3 py-1 text-[10px] font-bold uppercase tracking-[0.14em] text-zinc-300">
                        Event
                    </span>

                    <h3 class="mt-4 font-dm-serif text-[1.2rem] text-zinc-100">
                        No upcoming event yet
                    </h3>

                    <p class="mt-2 text-[13px] leading-[1.75] text-zinc-400">
                        Please check back soon for the next scheduled school or alumni event.
                    </p>
                </div>
            </div>
        @endif
    </div>
</section>
<section id="announcements" class="py-14 lg:py-20">
    <div class="mx-auto max-w-[1200px] px-5 md:px-6">
        <div class="mb-8 flex items-end justify-between gap-4">
            <div>
                <p class="mb-2 text-[11px] font-semibold uppercase tracking-[0.18em] text-violet-400">
                    Announcements
                </p>
                <h2 class="font-dm-serif text-[1.9rem] leading-none text-zinc-100 sm:text-[2.3rem]">
                    Important Notices & Updates
                </h2>
            </div>

            <a href="#" class="hidden text-sm font-medium text-zinc-400 transition hover:text-zinc-100 sm:inline-block">
                View all announcements
            </a>
        </div>

        <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-3">
            @forelse ($announcements as $announcement)
                <article class="rounded-2xl border border-white/10 bg-white/[0.03] p-6 transition hover:border-violet-400/20 hover:bg-white/[0.05]">
                    <div class="mb-3 flex items-center gap-2">
                        <span class="inline-block rounded-full border border-violet-400/20 bg-violet-400/10 px-3 py-1 text-[10px] font-bold uppercase tracking-[0.14em] text-violet-300">
                            Announcement
                        </span>

                        @if ($announcement->pinned)
                            <span class="inline-block rounded-full border border-amber-400/20 bg-amber-400/10 px-3 py-1 text-[10px] font-bold uppercase tracking-[0.14em] text-amber-300">
                                Pinned
                            </span>
                        @endif
                    </div>

                    <h3 class="text-[1rem] font-semibold leading-[1.45] text-zinc-100">
                        {{ $announcement->title }}
                    </h3>

                    <p class="mt-3 text-[12.8px] leading-[1.75] text-zinc-400">
                        {{ \Illuminate\Support\Str::limit(strip_tags($announcement->content), 180) }}
                    </p>

                    <div class="mt-5 border-t border-white/10 pt-3 text-[11.5px] text-zinc-500">
                        @if ($announcement->published_at)
                            {{ $announcement->published_at->format('F d, Y') }}
                        @else
                            Recently published
                        @endif
                    </div>
                </article>
            @empty
                <div class="rounded-2xl border border-white/10 bg-white/[0.03] p-6 text-zinc-400">
                    No announcements available right now.
                </div>
            @endforelse
        </div>
    </div>
</section>
</div>