<div>
     <!-- Hero -->
    <section id="home" class="relative overflow-hidden bg-hero-glow-dark">
      <div class="absolute inset-0">
        <div class="absolute left-10 top-24 h-28 w-28 rounded-full bg-rose-500/20 blur-3xl"></div>
        <div class="absolute right-8 top-10 h-40 w-40 rounded-full bg-amber-400/20 blur-3xl"></div>
        <div class="absolute bottom-0 left-1/3 h-40 w-40 rounded-full bg-fuchsia-500/10 blur-3xl"></div>
      </div>

      <div class="relative mx-auto grid max-w-7xl gap-12 px-4 py-20 sm:px-6 md:py-24 lg:grid-cols-2 lg:items-center lg:px-8 lg:py-28">
        <div>
          <span class="inline-flex items-center gap-2 rounded-full border border-white/10 bg-zinc-900/80 px-4 py-2 text-sm font-semibold text-rose-400 shadow-soft backdrop-blur">
            <span class="h-2 w-2 rounded-full bg-rose-500"></span>
         <h1>News and Events</h1>
          </span>

          <h2 class="mt-6 max-w-3xl text-4xl font-black tracking-tight text-white sm:text-5xl lg:text-6xl">
            Reconnect. Celebrate. Remember.
          </h2>

          <p class="mt-6 max-w-2xl text-base leading-8 text-zinc-300 sm:text-lg">
            Join the <span class="font-semibold text-white">Grand Alumni Reunion 2026</span> for an unforgettable gathering of memories, milestones, friendship, and school pride. Celebrate your journey with classmates, teachers, and fellow alumni in one premium evening of connection.
          </p>

          <div class="mt-8 flex flex-wrap gap-4">
            <a href="{{ route('register') }}" class="px-5 py-2 rounded-full bg-white text-zinc-900 hover:bg-rose-500 hover:text-white transition text-sm font-medium">
                  Register
            </a>
            <a href="#details" class="inline-flex items-center rounded-full border border-white/15 bg-zinc-900/80 px-6 py-3 text-sm font-semibold text-zinc-100 transition hover:bg-zinc-800">
              View Event Details
            </a>
          </div>

          <div class="mt-10 grid gap-4 sm:grid-cols-3">
            <div class="rounded-3xl border border-white/10 bg-zinc-900/70 p-5 shadow-soft backdrop-blur">
                <p class="text-xs font-semibold uppercase tracking-[0.18em] text-zinc-400">Date</p>
                <p class="mt-2 text-base font-bold text-white">
                    {{ $event?->event_date?->format('F j, Y') ?? 'To be announced' }}
                </p>
            </div>

            <div class="rounded-3xl border border-white/10 bg-zinc-900/70 p-5 shadow-soft backdrop-blur">
                <p class="text-xs font-semibold uppercase tracking-[0.18em] text-zinc-400">Time</p>
                <p class="mt-2 text-base font-bold text-white">
                    {{ $event?->event_date?->format('g:i A') . "-" . "Onward" ?? 'To be announced' }}
                </p>
            </div>

            <div class="rounded-3xl border border-white/10 bg-zinc-900/70 p-5 shadow-soft backdrop-blur">
                <p class="text-xs font-semibold uppercase tracking-[0.18em] text-zinc-400">Venue</p>
                <p class="mt-2 text-base font-bold text-white">
                    {{ $event?->venue ?? 'To be announced' }}
                </p>
            </div>
        </div>
        </div>

        <div class="relative">
          <div class="absolute -left-6 top-10 hidden h-28 w-28 rounded-3xl bg-zinc-800/60 shadow-premium backdrop-blur md:block"></div>
          <div class="absolute -right-3 top-20 hidden h-20 w-20 rounded-2xl bg-amber-400/20 shadow-soft lg:block"></div>

          <div class="relative rounded-[2rem] border border-white/10 bg-gradient-to-br from-rose-600 via-rose-500 to-amber-500 p-8 text-white shadow-premium sm:p-10">
            <div class="flex items-start justify-between gap-4">
              <div>
                <p class="text-sm font-semibold uppercase tracking-[0.18em] text-white/80">Featured Event</p>
                <h3 class="mt-3 text-3xl font-bold tracking-tight sm:text-4xl">Grand Night of Alumni Pride</h3>
              </div>
              <div class="rounded-2xl bg-white/15 p-3 backdrop-blur animate-float">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M5 3v4M3 5h4m10-2v4m-2-2h4M7 21l10-10M17 21h4v-4M3 17h4v4" />
                </svg>
              </div>
            </div>

            <p class="mt-5 max-w-lg text-sm leading-7 text-white/90 sm:text-base">
              An elegant celebration filled with class tributes, recognition, dinner fellowship, photo moments, entertainment, and meaningful reconnections.
            </p>

            <div class="mt-8 grid gap-4 sm:grid-cols-2">
              <div class="rounded-3xl border border-white/20 bg-white/10 p-5 backdrop-blur">
                <p class="text-sm font-semibold text-white">Batch Tributes</p>
                <p class="mt-2 text-sm text-white/80">Special presentations, memories, and recognition for each batch.</p>
              </div>
              <div class="rounded-3xl border border-white/20 bg-white/10 p-5 backdrop-blur">
                <p class="text-sm font-semibold text-white">Photo Moments</p>
                <p class="mt-2 text-sm text-white/80">Capture timeless memories with classmates and mentors.</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- About -->
    <section id="about" class="mx-auto max-w-7xl px-4 py-16 sm:px-6 md:py-24 lg:px-8">
      <div class="grid gap-6 lg:grid-cols-[1.1fr_.9fr]">
        <div class="rounded-[2rem] border border-white/10 bg-zinc-900 p-8 shadow-soft sm:p-10">
          <p class="text-sm font-semibold uppercase tracking-[0.18em] text-rose-400">About the Reunion</p>
          <h2 class="mt-4 text-3xl font-bold tracking-tight text-white sm:text-4xl">A premium celebration of memories, milestones, and community.</h2>
          <p class="mt-5 text-base leading-8 text-zinc-300">
            This reunion is more than a gathering. It is a homecoming experience designed to bring alumni together for one memorable night of celebration, nostalgia, recognition, and fellowship.
          </p>
          <p class="mt-4 text-base leading-8 text-zinc-300">
            From reconnecting with classmates to honoring shared memories and celebrating where life has taken everyone, this event is built to feel warm, meaningful, and unforgettable.
          </p>
        </div>

        <div class="rounded-[2rem] border border-white/10 bg-zinc-900 p-8 shadow-soft sm:p-10">
          <p class="text-sm font-semibold uppercase tracking-[0.18em] text-zinc-400">Why attend</p>
          <div class="mt-6 grid gap-4">
            <div class="rounded-2xl bg-zinc-800/80 p-5">
              <h3 class="font-semibold text-white">Reconnect with classmates</h3>
              <p class="mt-2 text-sm leading-6 text-zinc-300">Rebuild connections and relive old memories with familiar faces.</p>
            </div>
            <div class="rounded-2xl bg-zinc-800/80 p-5">
              <h3 class="font-semibold text-white">Celebrate shared milestones</h3>
              <p class="mt-2 text-sm leading-6 text-zinc-300">Honor the journey of every batch, teacher, and alumni story.</p>
            </div>
            <div class="rounded-2xl bg-zinc-800/80 p-5">
              <h3 class="font-semibold text-white">Enjoy a polished event experience</h3>
              <p class="mt-2 text-sm leading-6 text-zinc-300">From dinner fellowship to photo sessions, everything is prepared with care.</p>
            </div>
          </div>
        </div>
      </div>
    </section>

      <section id="announcements" class="mx-auto max-w-7xl px-4 py-16 sm:px-6 md:py-24 lg:px-8">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.18em] text-rose-400">
                    Latest Announcements
                </p>
                <h2 class="mt-3 text-3xl font-bold tracking-tight text-white sm:text-4xl">
                    Important updates for all alumni
                </h2>
                <p class="mt-3 max-w-2xl text-base leading-7 text-zinc-300">
                    Stay informed about registration deadlines, venue notes, program changes, and other official reunion reminders.
                </p>
            </div>

            <a href="#register"
               class="inline-flex items-center rounded-full border border-white/10 bg-zinc-900 px-5 py-3 text-sm font-semibold text-zinc-100 transition hover:bg-zinc-800">
                Get Your Slot
            </a>
        </div>

        @if($announcements->count())
            <div class="mt-10 grid gap-6 md:grid-cols-2 xl:grid-cols-3">
                @foreach($announcements as $announcement)
                    <article class="group flex h-full flex-col justify-between rounded-[2rem] border border-white/10 bg-zinc-900 p-6 shadow-md transition duration-300 hover:-translate-y-1 hover:shadow-2xl sm:p-7">
                        <div>
                            <div class="mb-4 flex items-center justify-between gap-3">
                                <p class="text-xs font-semibold uppercase tracking-[0.18em] text-rose-400">
                                    {{ ($announcement->published_at ?? $announcement->created_at)?->format('F j, Y') }}
                                </p>

                                @if($announcement->pinned)
                                    <span class="inline-flex items-center gap-1 rounded-full bg-amber-100 px-3 py-1 text-xs font-semibold text-amber-700">
                                        <span>📌</span>
                                        <span>Pinned</span>
                                    </span>
                                @endif
                            </div>

                            <h3 class="text-xl font-bold tracking-tight text-white">
                                {{ $announcement->title }}
                            </h3>

                            <p class="mt-4 text-sm leading-7 text-zinc-300">
                                {{ \Illuminate\Support\Str::limit($announcement->body, 140) }}
                            </p>
                        </div>

                        <button
                            wire:click="openAnnouncement({{ $announcement->id }})"
                            type="button"
                            class="mt-6 inline-flex w-fit items-center rounded-full bg-white px-4 py-2.5 text-sm font-semibold text-zinc-900 transition hover:bg-rose-500 hover:text-white"
                        >
                            Read more
                        </button>
                    </article>
                @endforeach
            </div>
        @else
            <div class="mt-10 rounded-[2rem] border border-white/10 bg-zinc-900 p-8 text-center shadow-md">
                <p class="text-zinc-300">No announcements available at the moment.</p>
            </div>
        @endif
    </section>

    @if($showModal && $selectedAnnouncement)
        <div
            class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 p-4 backdrop-blur-sm"
            wire:click="closeAnnouncement"
        >
            <div
                class="relative w-full max-w-2xl rounded-[2rem] border border-white/10 bg-zinc-900 p-7 shadow-2xl sm:p-8"
                wire:click.stop
            >
                <button
                    wire:click="closeAnnouncement"
                    type="button"
                    class="absolute right-5 top-5 flex h-10 w-10 items-center justify-center rounded-full bg-zinc-800 text-xl text-zinc-300 transition hover:bg-zinc-700"
                >
                    &times;
                </button>

                <div class="pr-12">
                    <div class="mb-4 flex flex-wrap items-center gap-3">
                        <p class="text-xs font-semibold uppercase tracking-[0.18em] text-rose-400">
                            {{ ($selectedAnnouncement->published_at ?? $selectedAnnouncement->created_at)?->format('F j, Y') }}
                        </p>

                        @if($selectedAnnouncement->pinned)
                            <span class="inline-flex items-center gap-1 rounded-full bg-amber-100 px-3 py-1 text-xs font-semibold text-amber-700">
                                <span>📌</span>
                                <span>Pinned</span>
                            </span>
                        @endif
                    </div>

                    <h3 class="text-2xl font-bold tracking-tight text-white sm:text-3xl">
                        {{ $selectedAnnouncement->title }}
                    </h3>

                    <div class="mt-5 whitespace-pre-line text-sm leading-8 text-zinc-300 sm:text-base">
                        {{ $selectedAnnouncement->body }}
                    </div>

                    <div class="mt-8">
                        <button
                            wire:click="closeAnnouncement"
                            type="button"
                            class="inline-flex items-center rounded-full border border-white/10 bg-zinc-800 px-5 py-2.5 text-sm font-semibold text-zinc-100 transition hover:bg-zinc-700"
                        >
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Details -->
    <section id="details" class="mx-auto max-w-7xl px-4 py-16 sm:px-6 md:py-24 lg:px-8">
      <div class="rounded-[2.25rem] bg-zinc-900 px-6 py-10 text-white shadow-premium ring-1 ring-white/10 sm:px-10 sm:py-12 lg:px-12">
        <div class="flex flex-col gap-6 lg:flex-row lg:items-end lg:justify-between">
          <div>
            <p class="text-sm font-semibold uppercase tracking-[0.18em] text-zinc-400">Event Details</p>
            <h2 class="mt-3 text-3xl font-bold tracking-tight sm:text-4xl">Everything you need before the big day</h2>
          </div>
          <a href="#schedule" class="inline-flex items-center rounded-full border border-white/15 px-5 py-3 text-sm font-semibold text-white transition hover:bg-white/10">
            View Full Program
          </a>
        </div>

       <div class="mt-10 grid gap-4 md:grid-cols-2 xl:grid-cols-4">
    <div class="rounded-3xl border border-white/10 bg-white/5 p-6 backdrop-blur">
        <p class="text-xs font-semibold uppercase tracking-[0.18em] text-zinc-400">Event</p>
        <p class="mt-3 text-lg font-bold text-white">
            {{ $event?->title ?? 'To be announced' }}
        </p>
    </div>

    <div class="rounded-3xl border border-white/10 bg-white/5 p-6 backdrop-blur">
        <p class="text-xs font-semibold uppercase tracking-[0.18em] text-zinc-400">Date</p>
        <p class="mt-3 text-lg font-bold text-white">
            {{ $event?->event_date?->format('F j, Y') ?? 'To be announced' }}
        </p>
    </div>

    <div class="rounded-3xl border border-white/10 bg-white/5 p-6 backdrop-blur">
        <p class="text-xs font-semibold uppercase tracking-[0.18em] text-zinc-400">Time</p>
        <p class="mt-3 text-lg font-bold text-white">
            {{ $event?->event_date?->format('g:i A') . "-" . "Onward"?? 'To be announced' }}
        </p>
    </div>

    <div class="rounded-3xl border border-white/10 bg-white/5 p-6 backdrop-blur">
        <p class="text-xs font-semibold uppercase tracking-[0.18em] text-zinc-400">Venue</p>
        <p class="mt-3 text-lg font-bold text-white">
            {{ $event?->venue ?? 'To be announced' }}
        </p>
    </div>
       </div>
      </div>
    </section>

    <!-- Schedule -->
    <section id="schedule" class="mx-auto max-w-7xl px-4 py-16 sm:px-6 md:py-24 lg:px-8">
      <p class="text-sm font-semibold uppercase tracking-[0.18em] text-rose-400">Program Schedule</p>
      <h2 class="mt-3 text-3xl font-bold tracking-tight text-white sm:text-4xl">A full evening of fellowship and celebration</h2>
      <p class="mt-3 max-w-2xl text-base leading-7 text-zinc-300">A quick overview of the activities prepared to make the reunion smooth, enjoyable, and memorable for everyone.</p>

      <div class="mt-10 grid gap-4">
    @forelse($event?->schedules ?? [] as $schedule)
        <div class="rounded-[2rem] border border-white/10 bg-zinc-900 p-6 shadow-soft md:grid md:grid-cols-[170px_1fr] md:items-center md:gap-6">
            <p class="text-sm font-bold uppercase tracking-[0.18em] text-rose-400">
                {{ $schedule->schedule_time ? \Carbon\Carbon::parse($schedule->schedule_time)->format('g:i A') : 'TBA' }}
            </p>

            <div class="mt-2 md:mt-0">
                <h3 class="text-lg font-bold tracking-tight text-white">
                    {{ $schedule->title }}
                </h3>

                <p class="mt-2 text-sm leading-7 text-zinc-300">
                    {{ $schedule->description ?: 'No description available.' }}
                </p>
            </div>
        </div>
    @empty
        <div class="rounded-[2rem] border border-white/10 bg-zinc-900 p-6 shadow-soft">
            <p class="text-sm text-zinc-300">No program schedule available yet.</p>
        </div>
    @endforelse
</div>
    </section>
 
 
 

    <!-- CTA -->
    <section id="register" class="mx-auto max-w-7xl px-4 py-16 sm:px-6 md:py-24 lg:px-8">
      <div class="rounded-[2.5rem] bg-cta-glow-dark px-6 py-12 text-white shadow-premium sm:px-10 sm:py-14 lg:px-14">
        <div class="max-w-3xl">
          <p class="text-sm font-semibold uppercase tracking-[0.18em] text-white/80">Reserve your place</p>
          <h2 class="mt-3 text-3xl font-black tracking-tight sm:text-4xl lg:text-5xl">Ready to join the celebration?</h2>
          <p class="mt-5 text-base leading-8 text-white/90 sm:text-lg">
            Secure your slot and be part of a memorable gathering filled with nostalgia, connection, laughter, and alumni pride.
          </p>
          <div class="mt-8 flex flex-wrap gap-4">
            <a href="#" class="inline-flex items-center rounded-full bg-white px-6 py-3 text-sm font-semibold text-zinc-900 shadow-soft transition hover:bg-zinc-100">
              Register Now
            </a>
            <a href="#announcements" class="inline-flex items-center rounded-full border border-white/30 px-6 py-3 text-sm font-semibold text-white transition hover:bg-white/10">
              View Announcements
            </a>
          </div>
        </div>
      </div>
    </section>

    <!-- Contact -->
    <section id="contact" class="mx-auto max-w-7xl px-4 pb-16 sm:px-6 md:pb-24 lg:px-8">
      <div class="rounded-[2rem] border border-white/10 bg-zinc-900 p-8 shadow-soft sm:p-10">
        <div class="flex flex-col gap-8 lg:flex-row lg:items-start lg:justify-between">
          <div class="max-w-2xl">
            <p class="text-sm font-semibold uppercase tracking-[0.18em] text-rose-400">Contact the Organizers</p>
            <h2 class="mt-3 text-3xl font-bold tracking-tight text-white sm:text-4xl">Need help or have questions?</h2>
            <p class="mt-4 text-base leading-8 text-zinc-300">
              For registration concerns, event questions, sponsorships, or alumni coordination, reach out to the organizing committee using the details below.
            </p>
          </div>
          <div class="grid w-full gap-4 md:grid-cols-3 lg:max-w-3xl">
            <div class="rounded-3xl bg-zinc-800/80 p-5">
              <p class="text-xs font-semibold uppercase tracking-[0.18em] text-zinc-400">Email</p>
              <p class="mt-3 font-semibold text-white">alumni@example.com</p>
            </div>
            <div class="rounded-3xl bg-zinc-800/80 p-5">
              <p class="text-xs font-semibold uppercase tracking-[0.18em] text-zinc-400">Phone</p>
              <p class="mt-3 font-semibold text-white">+63 9XX XXX XXXX</p>
            </div>
            <div class="rounded-3xl bg-zinc-800/80 p-5">
              <p class="text-xs font-semibold uppercase tracking-[0.18em] text-zinc-400">Facebook</p>
              <p class="mt-3 font-semibold text-white">School Alumni Association</p>
            </div>
          </div>
        </div>
      </div>
    </section>

</div>