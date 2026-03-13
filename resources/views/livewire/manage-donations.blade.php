<div>
   @if($scopeBatchId)
    <div class="rounded-xl border border-amber-200 bg-amber-50 p-3 text-amber-900
                dark:border-amber-900/40 dark:bg-amber-900/20 dark:text-amber-200">
        Viewing donations for your batch only.
    </div>
   @endif
   <div class="space-y-6 mt-2">
    <div class="flex items-start justify-between gap-4">
        <div>
            <h1 class="text-xl font-semibold text-zinc-900 dark:text-zinc-100">Manage Donations</h1>
            <p class="mt-1 text-sm text-zinc-600 dark:text-zinc-400">Search, filter, and review donation payments.</p>
        </div>

        <div class="text-right">
            <p class="text-xs text-zinc-600 dark:text-zinc-400">Paid total</p>
            <p class="text-lg font-semibold text-zinc-900 dark:text-zinc-100">
                ₱{{ number_format($paidTotal / 100, 2) }}
            </p>
        </div>
    </div>

    {{-- Filters --}}
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-4">
        <div>
            <label class="text-xs font-medium text-zinc-600 dark:text-zinc-400">Search</label>
            <input
                type="text"
                wire:model.live.debounce.300ms="search"
                placeholder="Name or checkout session id..."
                class="mt-1 w-full rounded-lg border border-zinc-200 bg-white px-3 py-2 text-sm text-zinc-900
                       dark:border-zinc-700 dark:bg-zinc-900 dark:text-zinc-100"
            />
        </div>

        <div>
            <label class="text-xs font-medium text-zinc-600 dark:text-zinc-400">Status</label>
            <select wire:model.live="status"
                class="mt-1 w-full rounded-lg border border-zinc-200 bg-white px-3 py-2 text-sm text-zinc-900
                       dark:border-zinc-700 dark:bg-zinc-900 dark:text-zinc-100">
                <option value="all">All</option>
                <option value="paid">Paid</option>
                <option value="unpaid">Unpaid</option>
            </select>
        </div>

        <div>
            <label class="text-xs font-medium text-zinc-600 dark:text-zinc-400">Sort</label>
            <select wire:model.live="sort"
                class="mt-1 w-full rounded-lg border border-zinc-200 bg-white px-3 py-2 text-sm text-zinc-900
                       dark:border-zinc-700 dark:bg-zinc-900 dark:text-zinc-100">
                <option value="latest">Latest</option>
                <option value="oldest">Oldest</option>
                <option value="amount_desc">Amount (high → low)</option>
                <option value="amount_asc">Amount (low → high)</option>
            </select>
        </div>

        <div>
            <label class="text-xs font-medium text-zinc-600 dark:text-zinc-400">Per page</label>
            <select wire:model.live="perPage"
                class="mt-1 w-full rounded-lg border border-zinc-200 bg-white px-3 py-2 text-sm text-zinc-900
                       dark:border-zinc-700 dark:bg-zinc-900 dark:text-zinc-100">
                <option value="10">10</option>
                <option value="25">25</option>
                <option value="50">50</option>
            </select>
        </div>
    </div>

    {{-- Table --}}
    <div class="overflow-hidden rounded-xl border border-zinc-200 bg-white dark:border-zinc-700 dark:bg-zinc-900">
        <div class="overflow-x-auto">
            <table class="min-w-full text-left text-sm">
                <thead class="bg-zinc-50 text-xs uppercase text-zinc-600 dark:bg-zinc-800/60 dark:text-zinc-300">
                    <tr>
                        <th class="px-4 py-3">Donor</th>
                        <th class="px-4 py-3">Batch</th>
                        <th class="px-4 py-3 text-right">Amount</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3">Paid at</th>
                        <th class="px-4 py-3">Session</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-zinc-100 dark:divide-zinc-800">
                    @forelse($donations as $d)
                        <tr class="hover:bg-zinc-50/70 dark:hover:bg-zinc-800/40">
                            <td class="px-4 py-3 font-medium text-zinc-900 dark:text-zinc-100">
                                {{ $d->alumni?->lname }}, {{ $d->alumni?->fname }} {{ $d->alumni?->mname }}
                            </td>

                            <td class="px-4 py-3 text-zinc-700 dark:text-zinc-300">
                                {{ $d->alumni?->batch?->yeargrad ?? '—' }}
                            </td>

                            <td class="px-4 py-3 text-right text-zinc-900 dark:text-zinc-100">
                                ₱{{ number_format($d->amount / 100, 2) }}
                            </td>

                            <td class="px-4 py-3">
                                @if($d->paid_at)
                                    <span class="inline-flex items-center rounded-full px-2 py-1 text-xs font-medium
                                        bg-green-100 text-green-700 dark:bg-green-500/15 dark:text-green-300">
                                        Paid
                                    </span>
                                @else
                                    <span class="inline-flex items-center rounded-full px-2 py-1 text-xs font-medium
                                        bg-zinc-100 text-zinc-700 dark:bg-zinc-700/40 dark:text-zinc-300">
                                        Unpaid
                                    </span>
                                @endif
                            </td>

                            <td class="px-4 py-3 text-zinc-700 dark:text-zinc-300">
                                {{ $d->paid_at ? $d->paid_at->format('M d, Y h:i A') : '—' }}
                            </td>

                            <td class="px-4 py-3 text-xs text-zinc-600 dark:text-zinc-400">
                                {{ $d->paymongo_checkout_session_id ?? '—' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-10 text-center text-sm text-zinc-600 dark:text-zinc-400">
                                No donations found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="flex items-center justify-between border-t border-zinc-200 px-4 py-3 text-sm dark:border-zinc-700">
            <p class="text-zinc-600 dark:text-zinc-400">
                Showing {{ $donations->firstItem() ?? 0 }}–{{ $donations->lastItem() ?? 0 }} of {{ $donations->total() }}
            </p>
            <div class="text-zinc-900 dark:text-zinc-100">
                {{ $donations->links() }}
            </div>
        </div>
    </div>
</div>
</div>