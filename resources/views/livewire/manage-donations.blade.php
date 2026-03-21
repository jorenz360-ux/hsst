<div>
    <div class="space-y-6">
        @if ($scopeBatchId)
            <div class="rounded-2xl border border-amber-200 bg-amber-50 px-4 py-3 text-sm text-amber-900 dark:border-amber-900/40 dark:bg-amber-900/20 dark:text-amber-200">
                Viewing donations for your batch only.
            </div>
        @endif

        {{-- Header --}}
        <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
            <div>
                <h1 class="text-2xl font-bold tracking-tight text-zinc-900 dark:text-white">
                    Manage Donations
                </h1>
                <p class="mt-1 text-sm text-zinc-600 dark:text-zinc-400">
                    Search, filter, and review donation submissions.
                </p>
            </div>

            <div class="grid grid-cols-2 gap-3 sm:min-w-[280px]">
                <div class="rounded-2xl border border-zinc-200 bg-white p-4 shadow-sm dark:border-zinc-800 dark:bg-zinc-900">
                    <p class="text-xs font-medium uppercase tracking-wide text-zinc-500 dark:text-zinc-400">
                        Verified Paid Total
                    </p>
                    <p class="mt-2 text-lg font-semibold text-zinc-900 dark:text-zinc-100">
                        ₱{{ number_format($verifiedPaidTotal, 2) }}
                    </p>
                </div>

                <div class="rounded-2xl border border-zinc-200 bg-white p-4 shadow-sm dark:border-zinc-800 dark:bg-zinc-900">
                    <p class="text-xs font-medium uppercase tracking-wide text-zinc-500 dark:text-zinc-400">
                        Pending
                    </p>
                    <p class="mt-2 text-lg font-semibold text-zinc-900 dark:text-zinc-100">
                        {{ $pendingCount }}
                    </p>
                </div>
            </div>
        </div>

        {{-- Filters --}}
        <div class="rounded-2xl border border-zinc-200 bg-white p-5 shadow-sm dark:border-zinc-800 dark:bg-zinc-900">
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-4">
                <div>
                    <label class="mb-2 block text-sm font-medium text-zinc-700 dark:text-zinc-300">
                        Search
                    </label>
                    <input
                        type="text"
                        wire:model.live.debounce.300ms="search"
                        placeholder="Name, reference, remarks, or status..."
                        class="w-full rounded-xl border border-zinc-300 bg-white px-4 py-2.5 text-sm text-zinc-900 outline-none transition placeholder:text-zinc-400 focus:border-teal-500 focus:ring-2 focus:ring-teal-500/20 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-100"
                    />
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-zinc-700 dark:text-zinc-300">
                        Status
                    </label>
                    <select
                        wire:model.live="status"
                        class="w-full rounded-xl border border-zinc-300 bg-white px-4 py-2.5 text-sm text-zinc-900 outline-none transition focus:border-teal-500 focus:ring-2 focus:ring-teal-500/20 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-100"
                    >
                        <option value="all">All</option>
                        <option value="pending">Pending Review</option>
                        <option value="verified">Verified</option>
                        <option value="rejected">Rejected</option>
                        <option value="paid">Paid</option>
                        <option value="unpaid">Unpaid</option>
                    </select>
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-zinc-700 dark:text-zinc-300">
                        Sort
                    </label>
                    <select
                        wire:model.live="sort"
                        class="w-full rounded-xl border border-zinc-300 bg-white px-4 py-2.5 text-sm text-zinc-900 outline-none transition focus:border-teal-500 focus:ring-2 focus:ring-teal-500/20 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-100"
                    >
                        <option value="latest">Latest</option>
                        <option value="oldest">Oldest</option>
                        <option value="amount_desc">Amount (High to Low)</option>
                        <option value="amount_asc">Amount (Low to High)</option>
                    </select>
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-zinc-700 dark:text-zinc-300">
                        Per Page
                    </label>
                    <select
                        wire:model.live="perPage"
                        class="w-full rounded-xl border border-zinc-300 bg-white px-4 py-2.5 text-sm text-zinc-900 outline-none transition focus:border-teal-500 focus:ring-2 focus:ring-teal-500/20 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-100"
                    >
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                    </select>
                </div>
            </div>
        </div>

        {{-- Table --}}
        <div class="overflow-hidden rounded-2xl border border-zinc-200 bg-white shadow-sm dark:border-zinc-800 dark:bg-zinc-900">
            <div class="border-b border-zinc-200 px-5 py-4 dark:border-zinc-800">
                <h2 class="text-base font-semibold text-zinc-900 dark:text-white">
                    Donation Records
                </h2>
                <p class="mt-1 text-sm text-zinc-600 dark:text-zinc-400">
                    Review donation submissions, payment state, and uploaded proof.
                </p>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="border-b border-zinc-200 bg-zinc-50 text-zinc-600 dark:border-zinc-800 dark:bg-zinc-950/60 dark:text-zinc-400">
                        <tr>
                            <th class="px-5 py-3 font-medium">Donor</th>
                            <th class="px-5 py-3 font-medium">Batch</th>
                            <th class="px-5 py-3 font-medium text-right">Amount</th>
                            <th class="px-5 py-3 font-medium">Submission</th>
                            <th class="px-5 py-3 font-medium">Review Status</th>
                            <th class="px-5 py-3 font-medium">Reference</th>
                            <th class="px-5 py-3 font-medium">OR File</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-zinc-200 dark:divide-zinc-800">
                        @forelse ($donations as $d)
                            <tr class="transition hover:bg-zinc-50 dark:hover:bg-zinc-800/40">
                                <td class="px-5 py-4">
                                    <div class="font-medium text-zinc-900 dark:text-zinc-100">
                                        {{ $d->alumni?->lname }}, {{ $d->alumni?->fname }}{{ $d->alumni?->mname ? ' ' . $d->alumni->mname : '' }}
                                    </div>
                                    @if ($d->remarks)
                                        <div class="mt-1 text-xs text-zinc-500 dark:text-zinc-400">
                                            {{ $d->remarks }}
                                        </div>
                                    @endif
                                </td>

                                <td class="px-5 py-4 text-zinc-700 dark:text-zinc-300">
                                    <div>{{ $d->alumni?->batch?->yeargrad ?? '—' }}</div>
                                    <div class="text-xs text-zinc-500 dark:text-zinc-400">
                                        {{ $d->alumni?->batch?->schoolyear ?? '—' }}
                                    </div>
                                </td>

                                <td class="px-5 py-4 text-right font-medium text-zinc-900 dark:text-zinc-100">
                                    ₱{{ number_format($d->amount, 2) }}
                                </td>

                                <td class="px-5 py-4 text-zinc-700 dark:text-zinc-300">
                                    <div>
                                        {{ $d->date_donated?->format('M d, Y h:i A') ?? $d->created_at?->format('M d, Y h:i A') ?? '—' }}
                                    </div>
                                    <div class="mt-1 text-xs text-zinc-500 dark:text-zinc-400">
                                        Created {{ $d->created_at?->format('M d, Y') ?? '—' }}
                                    </div>
                                </td>

                                <td class="px-5 py-4">
                                    @if ($d->status === 'verified')
                                        <span class="inline-flex rounded-full border border-emerald-500/20 bg-emerald-500/10 px-2.5 py-1 text-xs font-medium text-emerald-600 dark:text-emerald-400">
                                            Verified
                                        </span>
                                    @elseif ($d->status === 'rejected')
                                        <div class="space-y-1">
                                            <span class="inline-flex rounded-full border border-red-500/20 bg-red-500/10 px-2.5 py-1 text-xs font-medium text-red-600 dark:text-red-400">
                                                Rejected
                                            </span>
                                            @if ($d->rejection_reason)
                                                <div class="text-xs text-red-500 dark:text-red-400">
                                                    {{ $d->rejection_reason }}
                                                </div>
                                            @endif
                                        </div>
                                    @else
                                        <span class="inline-flex rounded-full border border-amber-500/20 bg-amber-500/10 px-2.5 py-1 text-xs font-medium text-amber-600 dark:text-amber-400">
                                            Pending
                                        </span>
                                    @endif
                                </td>


                                <td class="px-5 py-4 text-xs text-zinc-600 dark:text-zinc-400">
                                    {{ $d->reference_number ?? '—' }}
                                </td>

                                <td class="px-5 py-4">
                                    @if ($d->or_file_path)
                                        <a
                                            href="{{ Storage::disk('s3')->url($d->or_file_path) }}"
                                            target="_blank"
                                            class="inline-flex items-center rounded-lg border border-teal-500/20 bg-teal-500/10 px-2.5 py-1 text-xs font-medium text-teal-600 transition hover:bg-teal-500/20 dark:text-teal-400"
                                        >
                                            View OR
                                        </a>
                                    @else
                                        <span class="text-xs text-zinc-500 dark:text-zinc-400">No file</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-5 py-12 text-center text-sm text-zinc-500 dark:text-zinc-400">
                                    No donations found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="flex flex-col gap-3 border-t border-zinc-200 px-5 py-4 text-sm sm:flex-row sm:items-center sm:justify-between dark:border-zinc-800">
                <p class="text-zinc-600 dark:text-zinc-400">
                    Showing {{ $donations->firstItem() ?? 0 }}–{{ $donations->lastItem() ?? 0 }} of {{ $donations->total() }}
                </p>

                <div class="[&>*]:!shadow-none">
                    {{ $donations->links() }}
                </div>
            </div>
        </div>
    </div>
</div>