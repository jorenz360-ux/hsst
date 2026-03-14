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
                             <p class="text-[12px] font-medium text-zinc-100">
                                 {{ $event->dress_code }}
                            </p>
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

                <div class="flex flex-col gap-3.5 sm:flex-row lg:flex-col">
                    <a href="#" class="flex flex-1 flex-col overflow-hidden rounded-2xl border border-white/10 bg-white/[0.03] no-underline transition hover:border-white/15">
                        <div class="flex h-[108px] items-center justify-center bg-[linear-gradient(155deg,rgba(62,207,174,0.10)_0%,rgba(9,9,11,0.97)_100%)] text-[11px] italic text-zinc-600">
                            Event photo
                        </div>
                        <div class="flex flex-1 flex-col gap-[7px] p-5">
                            <span class="inline-block w-fit rounded border border-cyan-400/20 bg-cyan-400/10 px-2 py-[3px] text-[10px] font-bold uppercase tracking-[0.14em] text-cyan-400">
                                Event
                            </span>
                            <div class="text-[14.5px] font-semibold leading-[1.4] tracking-[-0.01em] text-zinc-100">
                                Foundation Day Celebration 2026
                            </div>
                            <p class="text-[12.5px] font-light leading-[1.65] text-zinc-600">
                                Join us for the annual Foundation Day with cultural programs and recognition ceremonies.
                            </p>
                            <div class="mt-auto border-t border-white/10 pt-2.5 text-[11.5px] text-zinc-600">
                                March 22, 2026
                            </div>
                        </div>
                    </a>

                    <a href="#" class="flex flex-1 flex-col overflow-hidden rounded-2xl border border-white/10 bg-white/[0.03] no-underline transition hover:border-white/15">
                        <div class="flex h-[108px] items-center justify-center bg-[linear-gradient(155deg,rgba(167,139,250,0.10)_0%,rgba(9,9,11,0.97)_100%)] text-[11px] italic text-zinc-600">
                            Alumni photo
                        </div>
                        <div class="flex flex-1 flex-col gap-[7px] p-5">
                            <span class="inline-block w-fit rounded border border-violet-400/20 bg-violet-400/10 px-2 py-[3px] text-[10px] font-bold uppercase tracking-[0.14em] text-violet-400">
                                Alumni
                            </span>
                            <div class="text-[14.5px] font-semibold leading-[1.4] tracking-[-0.01em] text-zinc-100">
                                Batch 2010 Grand Reunion Registration
                            </div>
                            <p class="text-[12.5px] font-light leading-[1.65] text-zinc-600">
                                Registration is open for the Batch 2010 Grand Reunion this April in Tagbilaran City.
                            </p>
                            <div class="mt-auto border-t border-white/10 pt-2.5 text-[11.5px] text-zinc-600">
                                April 5, 2026
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </section>
</div>