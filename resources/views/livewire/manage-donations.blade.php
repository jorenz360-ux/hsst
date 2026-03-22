<div class="min-h-screen bg-zinc-950 text-zinc-100 rounded-2xl">
    <div class="space-y-6 p-6">
        @if ($scopeBatchId)
            <div class="rounded-2xl border border-amber-500/20 bg-amber-500/10 px-4 py-3 text-sm text-amber-200">
                Viewing donations for your batch only.
            </div>
        @endif

        {{-- Header --}}
        <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.22em] text-amber-400">
                    Donations Management
                </p>
                <h1 class="text-2xl font-bold tracking-tight text-white">
                    Manage Donations
                </h1>
                <p class="mt-1 text-sm text-zinc-400">
                    Search, filter, and review donation submissions.
                </p>
            </div>

            <div class="grid grid-cols-2 gap-3 sm:min-w-[280px]">
                <div class="rounded-2xl border border-emerald-500/10 bg-zinc-900 p-4 shadow-sm">
                    <p class="text-xs font-medium uppercase tracking-wide text-zinc-500">
                        Verified Paid Total
                    </p>
                    <p class="mt-2 text-lg font-semibold text-white">
                        ₱{{ number_format($verifiedPaidTotal, 2) }}
                    </p>
                </div>

                <div class="rounded-2xl border border-amber-500/10 bg-zinc-900 p-4 shadow-sm">
                    <p class="text-xs font-medium uppercase tracking-wide text-zinc-500">
                        Pending
                    </p>
                    <p class="mt-2 text-lg font-semibold text-white">
                        {{ $pendingCount }}
                    </p>
                </div>
            </div>
        </div>

        {{-- Filters --}}
        <div class="rounded-2xl border border-white/10 bg-zinc-900 p-5 shadow-sm">
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-4">
                <div>
                    <label class="mb-2 block text-sm font-medium text-zinc-300">
                        Search
                    </label>
                    <input
                        type="text"
                        wire:model.live.debounce.300ms="search"
                        placeholder="Name, reference, remarks, or status..."
                        class="w-full rounded-xl border border-white/10 bg-zinc-950 px-4 py-2.5 text-sm text-zinc-100 outline-none transition placeholder:text-zinc-500 focus:border-amber-400 focus:ring-2 focus:ring-amber-500/20"
                    />
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-zinc-300">
                        Status
                    </label>
                    <select
                        wire:model.live="status"
                        class="w-full rounded-xl border border-white/10 bg-zinc-950 px-4 py-2.5 text-sm text-zinc-100 outline-none transition focus:border-amber-400 focus:ring-2 focus:ring-amber-500/20"
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
                    <label class="mb-2 block text-sm font-medium text-zinc-300">
                        Sort
                    </label>
                    <select
                        wire:model.live="sort"
                        class="w-full rounded-xl border border-white/10 bg-zinc-950 px-4 py-2.5 text-sm text-zinc-100 outline-none transition focus:border-amber-400 focus:ring-2 focus:ring-amber-500/20"
                    >
                        <option value="latest">Latest</option>
                        <option value="oldest">Oldest</option>
                        <option value="amount_desc">Amount (High to Low)</option>
                        <option value="amount_asc">Amount (Low to High)</option>
                    </select>
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-zinc-300">
                        Per Page
                    </label>
                    <select
                        wire:model.live="perPage"
                        class="w-full rounded-xl border border-white/10 bg-zinc-950 px-4 py-2.5 text-sm text-zinc-100 outline-none transition focus:border-amber-400 focus:ring-2 focus:ring-amber-500/20"
                    >
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                    </select>
                </div>
            </div>
        </div>

        {{-- Table --}}
        <div class="overflow-hidden rounded-2xl border border-white/10 bg-zinc-900 shadow-sm">
            <div class="border-b border-white/10 px-5 py-4">
                <h2 class="text-base font-semibold text-white">
                    Donation Records
                </h2>
                <p class="mt-1 text-sm text-zinc-400">
                    Review donation submissions, payment state, and uploaded proof.
                </p>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="border-b border-white/10 bg-zinc-950/80 text-zinc-400">
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

                    <tbody class="divide-y divide-white/10">
                        @forelse ($donations as $d)
                            <tr class="transition hover:bg-amber-500/[0.04]">
                                <td class="px-5 py-4">
                                    <div class="font-medium text-white">
                                        {{ $d->alumni?->lname }}, {{ $d->alumni?->fname }}{{ $d->alumni?->mname ? ' ' . $d->alumni->mname : '' }}
                                    </div>
                                    @if ($d->remarks)
                                        <div class="mt-1 text-xs text-zinc-500">
                                            {{ $d->remarks }}
                                        </div>
                                    @endif
                                </td>

                                <td class="px-5 py-4 text-zinc-300">
                                    <div>{{ $d->alumni?->batch?->yeargrad ?? '—' }}</div>
                                    <div class="text-xs text-zinc-500">
                                        {{ $d->alumni?->batch?->schoolyear ?? '—' }}
                                    </div>
                                </td>

                                <td class="px-5 py-4 text-right font-medium text-white">
                                    ₱{{ number_format($d->amount, 2) }}
                                </td>

                                <td class="px-5 py-4 text-zinc-300">
                                    <div>
                                        {{ $d->date_donated?->format('M d, Y h:i A') ?? $d->created_at?->format('M d, Y h:i A') ?? '—' }}
                                    </div>
                                    <div class="mt-1 text-xs text-zinc-500">
                                        Created {{ $d->created_at?->format('M d, Y') ?? '—' }}
                                    </div>
                                </td>

                                <td class="px-5 py-4">
                                    @if ($d->status === 'verified')
                                        <span class="inline-flex rounded-full border border-emerald-500/20 bg-emerald-500/10 px-2.5 py-1 text-xs font-medium text-emerald-300">
                                            Verified
                                        </span>
                                    @elseif ($d->status === 'rejected')
                                        <div class="space-y-1">
                                            <span class="inline-flex rounded-full border border-rose-500/20 bg-rose-500/10 px-2.5 py-1 text-xs font-medium text-rose-300">
                                                Rejected
                                            </span>
                                            @if ($d->rejection_reason)
                                                <div class="text-xs text-rose-400">
                                                    {{ $d->rejection_reason }}
                                                </div>
                                            @endif
                                        </div>
                                    @else
                                        <span class="inline-flex rounded-full border border-amber-500/20 bg-amber-500/10 px-2.5 py-1 text-xs font-medium text-amber-300">
                                            Pending
                                        </span>
                                    @endif
                                </td>

                                <td class="px-5 py-4 text-xs text-zinc-400">
                                    {{ $d->reference_number ?? '—' }}
                                </td>

                                <td class="px-5 py-4">
                                    @if ($d->or_file_path)
                                        <a
                                            href="{{ Storage::disk('s3')->url($d->or_file_path) }}"
                                            target="_blank"
                                            class="inline-flex items-center rounded-lg border border-amber-500/20 bg-amber-500/10 px-2.5 py-1 text-xs font-medium text-amber-300 transition hover:bg-amber-500/20"
                                        >
                                            View OR
                                        </a>
                                    @else
                                        <span class="text-xs text-zinc-500">No file</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-5 py-12 text-center text-sm text-zinc-500">
                                    No donations found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="flex flex-col gap-3 border-t border-white/10 px-5 py-4 text-sm sm:flex-row sm:items-center sm:justify-between">
                <p class="text-zinc-400">
                    Showing {{ $donations->firstItem() ?? 0 }}–{{ $donations->lastItem() ?? 0 }} of {{ $donations->total() }}
                </p>

                <div class="[&>*]:!shadow-none">
                    {{ $donations->links() }}
                </div>
            </div>
        </div>
    </div>
</div>