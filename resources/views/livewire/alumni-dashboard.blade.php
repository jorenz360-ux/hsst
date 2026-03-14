
   <div class="space-y-8">
  
    <div class="grid grid-cols-1 gap-4 lg:grid-cols-3">
        {{-- Verification/Profile status + CTA --}}
        <div class="lg:col-span-2 rounded-xl border border-zinc-200 bg-white p-5 dark:border-zinc-700 dark:bg-zinc-900">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <h2 class="text-base font-semibold text-zinc-900 dark:text-zinc-100">Your Account Status</h2>
                    <p class="mt-1 text-sm text-zinc-600 dark:text-zinc-400">
                        Complete your profile and get verified to unlock full features.
                    </p>
                </div>

                {{-- Status badge (UI preview) --}}
                <span class="inline-flex items-center rounded-full px-2.5 py-1 text-xs font-medium
                             bg-amber-100 text-amber-800 dark:bg-amber-500/15 dark:text-amber-300">
                    Pending Verification
                </span>
            </div>

            {{-- Progress-like checklist (UI preview) --}}
            <div class="mt-4 grid grid-cols-1 gap-3 sm:grid-cols-2">
                <div class="flex items-center gap-3 rounded-lg border border-zinc-200 p-3 dark:border-zinc-700">
                    <span class="inline-flex h-8 w-8 items-center justify-center rounded-full
                                 bg-green-100 text-green-700 dark:bg-green-500/15 dark:text-green-300">
                        ✓
                    </span>
                    <div class="min-w-0">
                        <p class="text-sm font-medium text-zinc-900 dark:text-zinc-100">Account created</p>
                        <p class="text-xs text-zinc-600 dark:text-zinc-400">Username & email saved</p>
                    </div>
                </div>

                <div class="flex items-center gap-3 rounded-lg border border-zinc-200 p-3 dark:border-zinc-700">
                    <span class="inline-flex h-8 w-8 items-center justify-center rounded-full
                                 bg-amber-100 text-amber-800 dark:bg-amber-500/15 dark:text-amber-300">
                        !
                    </span>
                    <div class="min-w-0">
                        <p class="text-sm font-medium text-zinc-900 dark:text-zinc-100">Profile completion</p>
                        <p class="text-xs text-zinc-600 dark:text-zinc-400">Some fields need review</p>
                    </div>
                </div>
            </div>

            {{-- CTA buttons --}}
            <div class="mt-5 flex flex-col gap-2 sm:flex-row sm:items-center">
                <a href="#"
                   class="inline-flex justify-center rounded-lg bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-700">
                    Complete Profile
                </a>

                <a href="#"
                   class="inline-flex justify-center rounded-lg border border-zinc-200 px-4 py-2 text-sm font-medium
                          text-zinc-900 hover:bg-zinc-50 dark:border-zinc-700 dark:text-zinc-100 dark:hover:bg-zinc-800/40">
                    View Verification Status
                </a>

                <p class="text-xs text-zinc-600 dark:text-zinc-400 sm:ml-auto">
                    Tip: Verified alumni can register & pay for events smoothly.
                </p>
            </div>
        </div>

        {{-- My donation total + Donate button --}}
        <div class="rounded-xl border border-zinc-200 bg-white p-5 dark:border-zinc-700 dark:bg-zinc-900">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <h2 class="text-base font-semibold text-zinc-900 dark:text-zinc-100">My Donations</h2>
                    <p class="mt-1 text-sm text-zinc-600 dark:text-zinc-400">Paid total</p>
                </div>

                <span class="inline-flex items-center rounded-full px-2.5 py-1 text-xs font-medium
                             bg-green-100 text-green-700 dark:bg-green-500/15 dark:text-green-300">
                    Paid
                </span>
            </div>

           <p class="mt-4 text-3xl font-semibold text-zinc-900 dark:text-zinc-100">
                ₱{{ number_format($paidTotal, 2) }}
            </p>
            <p class="mt-1 text-xs text-zinc-600 dark:text-zinc-400">
                Last donation:
                @if($lastPaidAt)
                    <span class="font-medium text-zinc-900 dark:text-zinc-100">
                        ₱{{ number_format(($lastPaidAmount ?? 0), 2) }}
                    </span>
                    <span class="opacity-70">• {{ $lastPaidAt }}</span>
                @else
                    —
                @endif
            </p>

            <div class="mt-5 flex items-center gap-2">
                @can('donations.create')
                        <flux:sidebar.item  class="inline-flex w-full justify-center rounded-lg bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-700" icon="banknotes" :href="route('make-donations')" wire:navigate>
                        {{ __('Donate') }}
                    </flux:sidebar.item>
                 @endcan   
                <a href="#"
                   class="inline-flex w-full justify-center rounded-lg border border-zinc-200 px-4 py-2 text-sm font-medium
                          text-zinc-900 hover:bg-zinc-50 dark:border-zinc-700 dark:text-zinc-100 dark:hover:bg-zinc-800/40">
                    View History
                </a>
            </div>

            <p class="mt-3 text-xs text-zinc-600 dark:text-zinc-400">
                Donations help fund the event and support batch projects.
            </p>
        </div>
    </div>

    </div>
    </div>

    {{-- Row 3: Announcements preview --}}
    <div class="rounded-xl border border-zinc-200 bg-white dark:border-zinc-700 dark:bg-zinc-900">
         <div class="flex items-center justify-between border-b border-zinc-200 px-5 py-4 dark:border-zinc-700">
            <div>
                <h2 class="text-base font-semibold text-zinc-900 dark:text-zinc-100">Announcements</h2>
              </div>
        </div>
       <div class="divide-y divide-zinc-100 dark:divide-zinc-800">
            @forelse($latestAnnouncements as $a)
                <div class="px-5 py-4">
                    <div class="flex items-start justify-between gap-4">
                        <div class="min-w-0">
                            <p class="font-medium text-zinc-900 dark:text-zinc-100 truncate">
                                {{ $a->title }}
                            </p>

                            <p class="mt-1 text-sm text-zinc-600 dark:text-zinc-400 line-clamp-2">
                                {{ \Illuminate\Support\Str::limit(strip_tags($a->body), 140) }}
                            </p>
                        </div>

                        <p class="text-xs text-zinc-600 dark:text-zinc-400 whitespace-nowrap">
                            {{ optional($a->created_at)->format('M d, Y') }}
                        </p>
                    </div>

                    <div class="mt-3">
                        {{-- <a href="{{ route('announcements.show', $a->id) }}"
                        class="text-sm font-medium text-indigo-600 hover:text-indigo-700 dark:text-indigo-400">
                            Read more
                        </a> --}}
                    </div>
                </div>
            @empty
                <div class="px-5 py-8">
                    <p class="text-sm text-zinc-600 dark:text-zinc-400">No announcements yet.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
