<div class="bg-[#0b1120] min-h-screen">
    <div class="mx-auto max-w-7xl space-y-6 px-3 py-4 sm:px-4 sm:py-6 lg:px-4">

        {{-- Header --}}
        <section class="overflow-hidden rounded-2xl border border-white/10 bg-gradient-to-br from-[#0f172a] via-[#020617] to-[#1e3a8a]/20 shadow-[0_20px_60px_rgba(0,0,0,0.45)] sm:rounded-3xl">
            <div class="flex flex-col gap-4 px-4 py-5 sm:px-6 sm:py-6 lg:flex-row lg:items-end lg:justify-between">

                <div class="max-w-3xl">
                    <p class="text-[11px] font-semibold uppercase tracking-[0.24em] text-blue-400">
                        Alumni Portal
                    </p>

                    <h1 class="mt-2 text-2xl font-bold tracking-tight text-white sm:text-3xl">
                        Welcome back, {{ $user->username ?? 'Alumnus' }}
                    </h1>

                    <p class="mt-3 text-sm leading-6 text-slate-400 sm:text-[15px]">
                        View active reunion events, check your donation summary, and update your alumni participation details.
                    </p>
                </div>

                <div class="grid w-full grid-cols-1 gap-2 sm:flex sm:w-auto sm:justify-end">
                    <a href="{{ route('profile.edit') }}"
                       class="inline-flex items-center justify-center rounded-xl border border-white/10 bg-white/5 px-4 py-2.5 text-sm font-semibold text-white hover:bg-white/10">
                        Update Profile
                    </a>

                    <a href="{{ route('profile.edit') }}#volunteer-section"
                       class="inline-flex items-center justify-center rounded-xl bg-[#1E3A8A] px-4 py-2.5 text-sm font-semibold text-white hover:bg-[#2746c7]">
                        Be Involved
                    </a>
                </div>

            </div>
        </section>

        {{-- Profile Status --}}
        @if($alumni)
            <section class="rounded-2xl border border-emerald-400/20 bg-emerald-500/10 px-4 py-4 sm:px-5">
                <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <p class="text-sm font-semibold text-emerald-300">Profile Complete</p>
                        <p class="mt-1 text-sm text-emerald-400/80">
                            Your alumni account is active and ready for event registration.
                        </p>
                    </div>

                    <span class="inline-flex rounded-full border border-emerald-400/20 bg-emerald-500/10 px-3 py-1 text-[11px] font-semibold uppercase text-emerald-300">
                        Active
                    </span>
                </div>
            </section>
        @endif

        {{-- Overview --}}
        <section class="rounded-2xl border border-white/10 bg-[#020617] shadow-[0_16px_40px_rgba(0,0,0,0.4)] sm:rounded-3xl">
            <div class="border-b border-white/10 px-4 py-4 sm:px-5">
                <h2 class="text-base font-semibold text-white sm:text-lg">Overview</h2>
                <p class="mt-1 text-sm text-slate-400">
                    A quick summary of your alumni account and participation.
                </p>
            </div>

            <div class="grid gap-3 p-4 sm:grid-cols-2 sm:gap-4 sm:p-5 xl:grid-cols-4">
                @foreach([
                    ['label'=>'My Batch','value'=>$alumni?->batch?->schoolyear ?? 'Not set'],
                    ['label'=>'Active Events','value'=>$upcomingEvents->total()],
                    ['label'=>'Total Donated','value'=>'₱'.number_format(($paidTotal ?? 0)/100,2)],
                    ['label'=>'Last Donation','value'=>$lastPaidAt ? '₱'.number_format(($lastPaidAmount ?? 0)/100,2) : 'No donation yet']
                ] as $item)
                    <div class="rounded-2xl border border-white/10 bg-white/5 p-4">
                        <p class="text-[11px] uppercase tracking-wide text-slate-400">{{ $item['label'] }}</p>
                        <p class="mt-3 text-lg font-semibold text-white">{{ $item['value'] }}</p>
                    </div>
                @endforeach
            </div>
        </section>

        {{-- Events --}}
        <section class="rounded-2xl border border-white/10 bg-[#020617] shadow-[0_16px_40px_rgba(0,0,0,0.4)] sm:rounded-3xl">

            <div class="border-b border-white/10 px-4 py-4 sm:px-5">
                <h2 class="text-lg font-semibold text-white">Active Events</h2>
                <p class="text-sm text-slate-400">
                    Browse all currently active reunion events.
                </p>
            </div>

            <div class="space-y-4 p-4 sm:p-5">

                @forelse ($upcomingEvents as $event)

                    <article class="rounded-2xl border border-white/10 bg-white/5 p-5 hover:bg-white/10 transition">

                        <div class="flex flex-col gap-4 lg:flex-row lg:justify-between">

                            <div class="flex-1">
                                <h3 class="text-lg font-semibold text-white">
                                    {{ $event->title }}
                                </h3>

                                <div class="mt-2 flex flex-wrap gap-2 text-xs text-slate-400">
                                    <span class="px-3 py-1 rounded-full border border-white/10 bg-white/5">
                                        {{ $event->event_date?->format('M d, Y • h:i A') }}
                                    </span>

                                    <span class="px-3 py-1 rounded-full border border-white/10 bg-white/5">
                                        {{ $event->venue ?: 'Venue TBA' }}
                                    </span>
                                </div>

                                @if ($event->description)
                                    <p class="mt-3 text-sm text-slate-400">
                                        {{ \Illuminate\Support\Str::limit(strip_tags($event->description), 150) }}
                                    </p>
                                @endif
                            </div>

                            <div class="w-full lg:max-w-xs">
                                <div class="rounded-xl border border-white/10 bg-black/40 p-4">
                                    <p class="text-xs text-slate-400 uppercase">Registration Fee</p>

                                    <p class="text-xl font-bold text-white mt-1">
                                        ₱{{ number_format(($event->registration_fee ?? 0)/100,2) }}
                                    </p>

                                    <a href="{{ route('alumni.events.show', $event) }}"
                                       class="mt-4 inline-flex w-full items-center justify-center rounded-xl bg-[#1E3A8A] px-4 py-2 text-sm font-semibold text-white hover:bg-[#2746c7]">
                                        View Event
                                    </a>
                                </div>
                            </div>

                        </div>

                    </article>

                @empty
                    <div class="text-center py-10 text-slate-400">
                        No active events yet
                    </div>
                @endforelse

            </div>

            @if ($upcomingEvents->hasPages())
                <div class="border-t border-white/10 px-4 py-4">
                    {{ $upcomingEvents->links() }}
                </div>
            @endif

        </section>

    </div>
</div>