<div class="min-h-screen rounded-2xl text-zinc-900">
    <div class="space-y-6 p-4 sm:p-6">
        @if ($scopeBatchId)
            <div class="rounded-2xl border border-amber-500/20 bg-amber-50 px-4 py-3 text-sm text-amber-700">
                Viewing donations for your assigned batch only.
            </div>
        @endif

        {{-- Header --}}
        <div class="flex flex-col gap-4 xl:flex-row xl:items-start xl:justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.22em] text-amber-600">
                    Donations Management
                </p>
                <h1 class="text-2xl font-bold tracking-tight text-zinc-900 sm:text-3xl">
                    Manage Donations
                </h1>
                <p class="mt-1 text-sm text-zinc-500">
                    Search, filter, and review donation submissions.
                </p>

                @if ($currentEducation?->batch)
                    <div class="mt-3 inline-flex flex-wrap items-center gap-2 rounded-xl border border-zinc-200 bg-zinc-50 px-3 py-2 text-xs text-zinc-600">
                        <span class="font-medium text-zinc-900">Assigned Batch:</span>
                        <span>{{ $currentEducation->batch->yeargrad ?? '—' }}</span>
                        <span class="text-zinc-400">•</span>
                        <span>{{ $currentEducation->batch->schoolyear ?? '—' }}</span>
                        @if ($currentEducation->batch->level ?? null)
                            <span class="text-zinc-400">•</span>
                            <span>{{ str($currentEducation->batch->level)->headline() }}</span>
                        @endif
                    </div>
                @endif
            </div>

            <div class="grid grid-cols-1 gap-3 sm:grid-cols-2 xl:min-w-[320px]">
                <div class="rounded-2xl border border-emerald-500/20 bg-emerald-50 p-4 shadow-sm">
                    <p class="text-xs font-medium uppercase tracking-wide text-zinc-500">
                        Verified Paid Total
                    </p>
                    <p class="mt-2 text-lg font-semibold text-zinc-900 sm:text-xl">
                        ₱{{ number_format($verifiedPaidTotal, 2) }}
                    </p>
                </div>

                <div class="rounded-2xl border border-amber-500/20 bg-amber-50 p-4 shadow-sm">
                    <p class="text-xs font-medium uppercase tracking-wide text-zinc-500">
                        Pending
                    </p>
                    <p class="mt-2 text-lg font-semibold text-zinc-900 sm:text-xl">
                        {{ $pendingCount }}
                    </p>
                </div>
            </div>
        </div>

        {{-- Filters --}}
        <div class="rounded-2xl border border-zinc-200 bg-zinc-50 p-4 shadow-sm sm:p-5">
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-4">
                <div>
                    <label class="mb-2 block text-sm font-medium text-zinc-700">
                        Search
                    </label>
                    <input
                        type="text"
                        wire:model.live.debounce.300ms="search"
                        placeholder="Name, reference, remarks, or status..."
                        class="w-full rounded-xl border border-zinc-300 bg-white px-4 py-2.5 text-sm text-zinc-900 outline-none transition placeholder:text-zinc-400 focus:border-amber-400 focus:ring-2 focus:ring-amber-500/20"
                    />
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-zinc-700">
                        Status
                    </label>
                    <select
                        wire:model.live="status"
                        class="w-full rounded-xl border border-zinc-300 bg-white px-4 py-2.5 text-sm text-zinc-900 outline-none transition focus:border-amber-400 focus:ring-2 focus:ring-amber-500/20"
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
                    <label class="mb-2 block text-sm font-medium text-zinc-700">
                        Sort
                    </label>
                    <select
                        wire:model.live="sort"
                        class="w-full rounded-xl border border-zinc-300 bg-white px-4 py-2.5 text-sm text-zinc-900 outline-none transition focus:border-amber-400 focus:ring-2 focus:ring-amber-500/20"
                    >
                        <option value="latest">Latest</option>
                        <option value="oldest">Oldest</option>
                        <option value="amount_desc">Amount (High to Low)</option>
                        <option value="amount_asc">Amount (Low to High)</option>
                    </select>
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-zinc-700">
                        Per Page
                    </label>
                    <select
                        wire:model.live="perPage"
                        class="w-full rounded-xl border border-zinc-300 bg-white px-4 py-2.5 text-sm text-zinc-900 outline-none transition focus:border-amber-400 focus:ring-2 focus:ring-amber-500/20"
                    >
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                    </select>
                </div>
            </div>
        </div>

        {{-- Mobile List --}}
        <div class="space-y-4 lg:hidden">
            @forelse ($donations as $d)
                @php
                    $education = $scopeBatchId
                        ? $d->alumni?->educations?->firstWhere('batch_id', $scopeBatchId)
                        : $d->alumni?->educations?->first();

                    $batch = $education?->batch;

                    $fullName = trim(collect([
                        $d->alumni?->lname ? $d->alumni->lname . ',' : null,
                        $d->alumni?->fname,
                        $d->alumni?->mname,
                    ])->filter()->implode(' '));
                @endphp

                <div class="rounded-2xl border border-zinc-200 bg-white p-4 shadow-sm">
                    <div class="flex items-start justify-between gap-3">
                        <div>
                            <h3 class="text-sm font-semibold text-zinc-900">
                                {{ $fullName ?: 'Unknown Donor' }}
                            </h3>
                            <p class="mt-1 text-xs text-zinc-500">
                                {{ $batch?->yeargrad ?? '—' }} • {{ $batch?->schoolyear ?? '—' }}
                            </p>
                        </div>

                        <div class="text-right">
                            <p class="text-sm font-semibold text-zinc-900">
                                ₱{{ number_format($d->amount, 2) }}
                            </p>
                        </div>
                    </div>

                    @if ($d->remarks)
                        <p class="mt-3 text-xs text-zinc-500">
                            {{ $d->remarks }}
                        </p>
                    @endif

                    <div class="mt-4 grid grid-cols-2 gap-3 text-xs">
                        <div>
                            <p class="text-zinc-500">Submission</p>
                            <p class="mt-1 text-zinc-700">
                                {{ $d->date_donated?->format('M d, Y h:i A') ?? $d->created_at?->format('M d, Y h:i A') ?? '—' }}
                            </p>
                        </div>

                        <div>
                            <p class="text-zinc-500">Reference</p>
                            <p class="mt-1 break-all text-zinc-700">
                                {{ $d->reference_number ?? '—' }}
                            </p>
                        </div>
                    </div>

                    <div class="mt-4 flex flex-wrap items-center gap-2">
                        @if ($d->status === 'verified')
                            <span class="inline-flex rounded-full border border-emerald-500/20 bg-emerald-500/10 px-2.5 py-1 text-xs font-medium text-emerald-600">
                                Verified
                            </span>
                        @elseif ($d->status === 'rejected')
                            <span class="inline-flex rounded-full border border-rose-500/20 bg-rose-500/10 px-2.5 py-1 text-xs font-medium text-rose-600">
                                Rejected
                            </span>
                        @else
                            <span class="inline-flex rounded-full border border-amber-500/20 bg-amber-500/10 px-2.5 py-1 text-xs font-medium text-amber-600">
                                Pending
                            </span>
                        @endif

                        @if ($d->is_paid)
                            <span class="inline-flex rounded-full border border-sky-500/20 bg-sky-500/10 px-2.5 py-1 text-xs font-medium text-sky-600">
                                Paid
                            </span>
                        @else
                            <span class="inline-flex rounded-full border border-zinc-200 bg-zinc-100 px-2.5 py-1 text-xs font-medium text-zinc-600">
                                Unpaid
                            </span>
                        @endif
                    </div>

                    @if ($d->status === 'rejected' && $d->rejection_reason)
                        <div class="mt-3 rounded-xl border border-rose-500/15 bg-rose-50 px-3 py-2 text-xs text-rose-600">
                            {{ $d->rejection_reason }}
                        </div>
                    @endif

                    <div class="mt-4 flex items-center justify-between gap-3">
                        <div class="text-xs text-zinc-500">
                            Created {{ $d->created_at?->format('M d, Y') ?? '—' }}
                        </div>

                        @if ($d->or_file_path)
                            <a
                                href="{{ Storage::disk('s3')->url($d->or_file_path) }}"
                                target="_blank"
                                class="inline-flex items-center rounded-lg border border-amber-500/20 bg-amber-500/10 px-3 py-1.5 text-xs font-medium text-amber-600 transition hover:bg-amber-500/20"
                            >
                                View OR
                            </a>
                        @else
                            <span class="text-xs text-zinc-500">No file</span>
                        @endif
                    </div>
                </div>
            @empty
                <div class="rounded-2xl border border-dashed border-zinc-300 bg-zinc-50 px-4 py-12 text-center text-sm text-zinc-500">
                    No donations found.
                </div>
            @endforelse
        </div>

        {{-- Desktop Table --}}
        <div class="hidden overflow-hidden rounded-2xl border border-zinc-200 bg-white shadow-sm lg:block">
            <div class="border-b border-zinc-200 px-5 py-4">
                <h2 class="text-base font-semibold text-zinc-900">
                    Donation Records
                </h2>
                <p class="mt-1 text-sm text-zinc-500">
                    Review donation submissions, payment state, and uploaded proof.
                </p>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="border-b border-zinc-200 bg-zinc-50 text-zinc-500">
                        <tr>
                            <th class="px-5 py-3 font-medium">Donor</th>
                            <th class="px-5 py-3 font-medium">Batch / Education</th>
                            <th class="px-5 py-3 font-medium text-right">Amount</th>
                            <th class="px-5 py-3 font-medium">Submission</th>
                            <th class="px-5 py-3 font-medium">Review Status</th>
                            <th class="px-5 py-3 font-medium">Payment</th>
                            <th class="px-5 py-3 font-medium">Reference</th>
                            <th class="px-5 py-3 font-medium">OR File</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-zinc-100">
                        @forelse ($donations as $d)
                            @php
                                $education = $scopeBatchId
                                    ? $d->alumni?->educations?->firstWhere('batch_id', $scopeBatchId)
                                    : $d->alumni?->educations?->first();

                                $batch = $education?->batch;
                            @endphp

                            <tr class="transition hover:bg-amber-50">
                                <td class="px-5 py-4 align-top">
                                    <div class="font-medium text-zinc-900">
                                        {{ $d->alumni?->lname }}, {{ $d->alumni?->fname }}{{ $d->alumni?->mname ? ' ' . $d->alumni->mname : '' }}
                                    </div>

                                    @if ($d->remarks)
                                        <div class="mt-1 max-w-xs text-xs text-zinc-500">
                                            {{ $d->remarks }}
                                        </div>
                                    @endif
                                </td>

                                <td class="px-5 py-4 align-top text-zinc-600">
                                    <div>{{ $batch?->yeargrad ?? '—' }}</div>
                                    <div class="text-xs text-zinc-500">
                                        {{ $batch?->schoolyear ?? '—' }}
                                    </div>
                                    @if ($batch?->level)
                                        <div class="mt-1 text-xs text-zinc-500">
                                            {{ str($batch->level)->headline() }}
                                        </div>
                                    @endif
                                </td>

                                <td class="px-5 py-4 align-top text-right font-medium text-zinc-900">
                                    ₱{{ number_format($d->amount, 2) }}
                                </td>

                                <td class="px-5 py-4 align-top text-zinc-600">
                                    <div>
                                        {{ $d->date_donated?->format('M d, Y h:i A') ?? $d->created_at?->format('M d, Y h:i A') ?? '—' }}
                                    </div>
                                    <div class="mt-1 text-xs text-zinc-500">
                                        Created {{ $d->created_at?->format('M d, Y') ?? '—' }}
                                    </div>
                                </td>

                                <td class="px-5 py-4 align-top">
                                    @if ($d->status === 'verified')
                                        <span class="inline-flex rounded-full border border-emerald-500/20 bg-emerald-500/10 px-2.5 py-1 text-xs font-medium text-emerald-600">
                                            Verified
                                        </span>
                                    @elseif ($d->status === 'rejected')
                                        <div class="space-y-1">
                                            <span class="inline-flex rounded-full border border-rose-500/20 bg-rose-500/10 px-2.5 py-1 text-xs font-medium text-rose-600">
                                                Rejected
                                            </span>
                                            @if ($d->rejection_reason)
                                                <div class="max-w-[220px] text-xs text-rose-500">
                                                    {{ $d->rejection_reason }}
                                                </div>
                                            @endif
                                        </div>
                                    @else
                                        <span class="inline-flex rounded-full border border-amber-500/20 bg-amber-500/10 px-2.5 py-1 text-xs font-medium text-amber-600">
                                            Pending
                                        </span>
                                    @endif
                                </td>

                                <td class="px-5 py-4 align-top">
                                    @if ($d->is_paid)
                                        <span class="inline-flex rounded-full border border-sky-500/20 bg-sky-500/10 px-2.5 py-1 text-xs font-medium text-sky-600">
                                            Paid
                                        </span>
                                        @if ($d->paid_at)
                                            <div class="mt-1 text-xs text-zinc-500">
                                                {{ $d->paid_at->format('M d, Y h:i A') }}
                                            </div>
                                        @endif
                                    @else
                                        <span class="inline-flex rounded-full border border-zinc-200 bg-zinc-100 px-2.5 py-1 text-xs font-medium text-zinc-600">
                                            Unpaid
                                        </span>
                                    @endif
                                </td>

                                <td class="px-5 py-4 align-top text-xs text-zinc-500">
                                    {{ $d->reference_number ?? '—' }}
                                </td>

                                <td class="px-5 py-4 align-top">
                                    @if ($d->or_file_path)
                                        <a
                                            href="{{ Storage::disk('s3')->url($d->or_file_path) }}"
                                            target="_blank"
                                            class="inline-flex items-center rounded-lg border border-amber-500/20 bg-amber-500/10 px-2.5 py-1 text-xs font-medium text-amber-600 transition hover:bg-amber-500/20"
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

            <div class="flex flex-col gap-3 border-t border-zinc-200 px-5 py-4 text-sm sm:flex-row sm:items-center sm:justify-between">
                <p class="text-zinc-500">
                    Showing {{ $donations->firstItem() ?? 0 }}–{{ $donations->lastItem() ?? 0 }} of {{ $donations->total() }}
                </p>

                <div class="[&>*]:!shadow-none">
                    {{ $donations->links() }}
                </div>
            </div>
        </div>

        {{-- Mobile Pagination --}}
        <div class="lg:hidden">
            <div class="flex flex-col gap-3 border border-zinc-200 bg-white px-4 py-4 text-sm rounded-2xl sm:flex-row sm:items-center sm:justify-between">
                <p class="text-zinc-500">
                    Showing {{ $donations->firstItem() ?? 0 }}–{{ $donations->lastItem() ?? 0 }} of {{ $donations->total() }}
                </p>

                <div class="[&>*]:!shadow-none">
                    {{ $donations->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
