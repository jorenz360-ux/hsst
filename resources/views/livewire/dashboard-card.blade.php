
 <div>
 @can('payments.view')
     <div class="p-4 rounded-lg border border-gray-200 dark:border-gray-700 shadow-sm">
    {{-- <h2 class="text-lg font-semibold">{{ $title }}</h2>
    <p>{{ $slot }}</p> --}}
    <div class="space-y-6">
        <div>
            <flux:heading size="lg">{{ $title ?? 'Dashboard' }}</flux:heading>
            <flux:subheading>Your recent activity.</flux:subheading>
        </div>

        @if (session('info'))
            <div class="rounded-lg border p-4 text-sm">
                {{ session('info') }}
            </div>
        @endif

        <div>
            <flux:heading size="lg">My Donations</flux:heading>
            <flux:subheading>Payments you’ve made through the system.</flux:subheading>
        </div>

        <div class="overflow-x-auto rounded-lg border">
            <div class="rounded-lg border border-gray-800 bg-gray-900 p-4">
    <div class="grid grid-cols-1 gap-3 md:grid-cols-4">
        <div class="md:col-span-2">
            <label class="block text-xs font-medium text-gray-300">Search</label>
            <input
                type="text"
                wire:model.live.debounce.400ms="search"
                placeholder="Search remarks or amount…"
                class="mt-1 w-full rounded-md border border-gray-700 bg-gray-800 px-3 py-2 text-sm text-gray-100 placeholder:text-gray-500 focus:border-indigo-500 focus:ring-indigo-500"
            />
        </div>

        <div>
            <label class="block text-xs font-medium text-gray-300">From</label>
            <input
                type="date"
                wire:model.live="from"
                class="mt-1 w-full rounded-md border border-gray-700 bg-gray-800 px-3 py-2 text-sm text-gray-100 focus:border-indigo-500 focus:ring-indigo-500"
            />
        </div>

        <div>
            <label class="block text-xs font-medium text-gray-300">To</label>
            <input
                type="date"
                wire:model.live="to"
                class="mt-1 w-full rounded-md border border-gray-700 bg-gray-800 px-3 py-2 text-sm text-gray-100 focus:border-indigo-500 focus:ring-indigo-500"
            />
        </div>
    </div>

    <div class="mt-3 flex items-center justify-between">
        <p class="text-xs text-gray-400">
            Showing {{ $donations->total() }} result(s)
        </p>

        <button
            type="button"
            wire:click="resetFilters"
            class="rounded-md border border-gray-700 bg-gray-800 px-3 py-2 text-xs font-medium text-gray-200 hover:bg-gray-700"
        >
            Reset Filters
        </button>
    </div>
</div>
        <table class="min-w-full text-sm text-gray-200 bg-gray-900">
            <thead class="bg-gray-800/70">
                <tr class="border-b border-gray-700">
                    <th class="px-4 py-3 text-left font-medium text-gray-200">Date</th>
                    <th class="px-4 py-3 text-left font-medium text-gray-200">Amount</th>
                    <th class="px-4 py-3 text-left font-medium text-gray-200">Remarks</th>
                    <th class="px-4 py-3 text-left font-medium text-gray-200">Status</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-800">
                @forelse($donations as $donation)
                    <tr class="hover:bg-gray-800/50">
                        <td class="px-4 py-3 whitespace-nowrap text-gray-200">
                            @php
                                $dt = $donation->paid_at ?? $donation->date_donated;
                            @endphp

                            {{ $dt ? $dt->timezone('Asia/Manila')->format('M d, Y h:i A') : '—' }}
                        </td>

                        <td class="px-4 py-3 whitespace-nowrap text-gray-200">
                            ₱{{ number_format((int) $donation->amount, 2) }}
                        </td>

                        <td class="px-4 py-3 text-gray-200">
                            {{ $donation->remarks ?: '—' }}
                        </td>

                        <td class="px-4 py-3 whitespace-nowrap">
                            @if($donation->paid_at)
                                <span class="inline-flex items-center rounded-full border border-emerald-800 bg-emerald-950/50 px-2 py-1 text-xs text-emerald-200">
                                    Paid
                                </span>
                            @else
                                <span class="inline-flex items-center rounded-full border border-amber-800 bg-amber-950/50 px-2 py-1 text-xs text-amber-200">
                                    Pending
                                </span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-4 py-6 text-center text-gray-400">
                            No donations yet.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        </div>

        <div>
            {{ $donations->links() }}
        </div>
</div>
</div>
    @endcan
    @can('announcement.create')
      This is for the admin you can add announcemnt here so that all alumni will notify
    @endcan
 </div>