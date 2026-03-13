<div>
  <div class="space-y-6">
    <div>
        <h1 class="text-2xl font-semibold text-zinc-900 dark:text-zinc-100">Upcoming Events</h1>
        <p class="mt-1 text-sm text-zinc-600 dark:text-zinc-400">See what’s coming next.</p>
    </div>

    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
        @forelse($events as $event)
            <div class="rounded-xl border border-zinc-200 bg-white p-4 dark:border-zinc-700 dark:bg-zinc-900">
                <div class="font-semibold text-zinc-900 dark:text-zinc-100">{{ $event->title }}</div>
                <div class="mt-1 text-sm text-zinc-600 dark:text-zinc-400">{{ $event->venue }}</div>

                <div class="mt-3 text-sm text-zinc-900 dark:text-zinc-100">
                    {{ $event->event_date->format('M d, Y • h:i A') }}
                </div>

                <div class="mt-2 text-sm text-zinc-900 dark:text-zinc-100">
                    Fee: ₱{{ number_format($event->registration_fee / 100, 0) }}
                </div>

                @if($event->description)
                    <p class="mt-3 line-clamp-3 text-sm text-zinc-600 dark:text-zinc-400">
                        {{ $event->description }}
                    </p>
                @endif

                {{-- <div class="mt-4">
                    @guest
                        <a href="{{ route('login') }}"
                           class="inline-flex w-full justify-center rounded-lg bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-700">
                            Login to Register
                        </a>
                    @else
                        @if(auth()->user()->alumni_id === null)
                            <a href="{{ route('profile') }}"
                               class="inline-flex w-full justify-center rounded-lg border border-zinc-200 px-4 py-2 text-sm font-medium
                                      text-zinc-900 hover:bg-zinc-50 dark:border-zinc-700 dark:text-zinc-100 dark:hover:bg-zinc-800/40">
                                Complete Profile to Register
                            </a>
                        @else
                            <a href="{{ route('events.show', $event->id) }}"
                               class="inline-flex w-full justify-center rounded-lg bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-700">
                                View / Register
                            </a>
                        @endif
                    @endguest
                </div> --}}
            </div>
        @empty
            <div class="col-span-full rounded-xl border border-zinc-200 bg-white p-8 text-center dark:border-zinc-700 dark:bg-zinc-900">
                <p class="text-sm text-zinc-600 dark:text-zinc-400">No upcoming events yet.</p>
            </div>
        @endforelse
    </div>

    {{ $events->links() }}
</div>
</div>
