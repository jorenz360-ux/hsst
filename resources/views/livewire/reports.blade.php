<div>
    <div class="space-y-6">
        {{-- Header --}}
        <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
            <div>
                <h1 class="text-2xl font-bold tracking-tight text-zinc-900 dark:text-white">
                    Reports
                </h1>
                <p class="mt-1 text-sm text-zinc-600 dark:text-zinc-400">
                    View, filter, and download donation and batch reports.
                </p>
            </div>
        </div>

        {{-- Tabs --}}
        <div class="rounded-2xl border border-zinc-200 bg-white p-1 shadow-sm dark:border-zinc-800 dark:bg-zinc-900">
            <div class="grid grid-cols-2 gap-1">
                <button
                    wire:click="$set('tab', 'donations')"
                    class="{{ $tab === 'donations'
                        ? 'bg-zinc-900 text-white shadow-sm dark:bg-zinc-100 dark:text-zinc-900'
                        : 'text-zinc-600 hover:bg-zinc-100 dark:text-zinc-400 dark:hover:bg-zinc-800' }} rounded-xl px-4 py-2.5 text-sm font-medium transition"
                >
                    Donation Report
                </button>

                <button
                    wire:click="$set('tab', 'batches')"
                    class="{{ $tab === 'batches'
                        ? 'bg-zinc-900 text-white shadow-sm dark:bg-zinc-100 dark:text-zinc-900'
                        : 'text-zinc-600 hover:bg-zinc-100 dark:text-zinc-400 dark:hover:bg-zinc-800' }} rounded-xl px-4 py-2.5 text-sm font-medium transition"
                >
                    By Batch Report
                </button>
            </div>
        </div>

        {{-- Donation Report --}}
        @if ($tab === 'donations')
            <div class="space-y-6">
                {{-- Filters / Actions --}}
                <div class="rounded-2xl border border-zinc-200 bg-white p-5 shadow-sm dark:border-zinc-800 dark:bg-zinc-900">
                    <div class="grid grid-cols-1 gap-4 xl:grid-cols-4">
                        <div>
                            <label class="mb-2 block text-sm font-medium text-zinc-700 dark:text-zinc-300">
                                Start Date
                            </label>
                            <input
                                type="date"
                                wire:model.live="donationStartDate"
                                class="w-full rounded-xl border border-zinc-300 bg-white px-4 py-2.5 text-sm text-zinc-900 outline-none transition placeholder:text-zinc-400 focus:border-teal-500 focus:ring-2 focus:ring-teal-500/20 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-100"
                            />
                        </div>

                        <div>
                            <label class="mb-2 block text-sm font-medium text-zinc-700 dark:text-zinc-300">
                                End Date
                            </label>
                            <input
                                type="date"
                                wire:model.live="donationEndDate"
                                class="w-full rounded-xl border border-zinc-300 bg-white px-4 py-2.5 text-sm text-zinc-900 outline-none transition placeholder:text-zinc-400 focus:border-teal-500 focus:ring-2 focus:ring-teal-500/20 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-100"
                            />
                        </div>

                        <div class="flex items-end">
                            <button
                                type="button"
                                wire:click="resetDonationFilters"
                                class="inline-flex w-full items-center justify-center rounded-xl border border-zinc-300 px-4 py-2.5 text-sm font-medium text-zinc-700 transition hover:bg-zinc-100 dark:border-zinc-700 dark:text-zinc-200 dark:hover:bg-zinc-800"
                            >
                                Reset Filters
                            </button>
                        </div>

                        <div class="flex items-end">
                            <button
                                type="button"
                                wire:click="downloadDonations"
                                class="inline-flex w-full items-center justify-center rounded-xl bg-teal-600 px-4 py-2.5 text-sm font-medium text-white transition hover:bg-teal-700"
                            >
                                Download CSV
                            </button>
                        </div>
                    </div>
                </div>

                {{-- Summary --}}
                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                    <div class="rounded-2xl border border-zinc-200 bg-white p-5 shadow-sm dark:border-zinc-800 dark:bg-zinc-900">
                        <p class="text-sm font-medium text-zinc-500 dark:text-zinc-400">
                            Total Donations
                        </p>
                        <h2 class="mt-2 text-3xl font-bold text-zinc-900 dark:text-white">
                            ₱{{ number_format($totalDonationsAmount, 2) }}
                        </h2>
                    </div>

                    <div class="rounded-2xl border border-zinc-200 bg-white p-5 shadow-sm dark:border-zinc-800 dark:bg-zinc-900">
                        <p class="text-sm font-medium text-zinc-500 dark:text-zinc-400">
                            Donation Entries
                        </p>
                        <h2 class="mt-2 text-3xl font-bold text-zinc-900 dark:text-white">
                            {{ $totalDonationCount }}
                        </h2>
                    </div>
                </div>

                {{-- Donation Table --}}
                <div class="overflow-hidden rounded-2xl border border-zinc-200 bg-white shadow-sm dark:border-zinc-800 dark:bg-zinc-900">
                    <div class="border-b border-zinc-200 px-5 py-4 dark:border-zinc-800">
                        <h2 class="text-base font-semibold text-zinc-900 dark:text-white">
                            Donation Records
                        </h2>
                        <p class="mt-1 text-sm text-zinc-600 dark:text-zinc-400">
                            @if ($isBatchRepresentative)
                                Showing donations for your assigned batch only.
                            @else
                                Showing donation records across all available batches.
                            @endif
                        </p>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm">
                            <thead class="border-b border-zinc-200 bg-zinc-50 text-zinc-600 dark:border-zinc-800 dark:bg-zinc-950/60 dark:text-zinc-400">
                                <tr>
                                    <th class="px-5 py-3 font-medium">Donor</th>
                                    <th class="px-5 py-3 font-medium">Batch</th>
                                    <th class="px-5 py-3 font-medium">School Year</th>
                                    <th class="px-5 py-3 font-medium text-right">Amount</th>
                                    <th class="px-5 py-3 font-medium">Date</th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-zinc-200 dark:divide-zinc-800">
                                @forelse ($donations as $donation)
                                    <tr class="transition hover:bg-zinc-50 dark:hover:bg-zinc-800/40">
                                        <td class="px-5 py-4 text-zinc-900 dark:text-zinc-100">
                                            @if ($donation->alumni)
                                                {{ $donation->alumni->fname }} {{ $donation->alumni->lname }}
                                            @else
                                                —
                                            @endif
                                        </td>

                                        <td class="px-5 py-4 text-zinc-700 dark:text-zinc-300">
                                            {{ $donation->alumni?->batch?->yeargrad ?? '—' }}
                                        </td>

                                        <td class="px-5 py-4 text-zinc-700 dark:text-zinc-300">
                                            {{ $donation->alumni?->batch?->schoolyear ?? '—' }}
                                        </td>

                                        <td class="px-5 py-4 text-right font-medium text-zinc-900 dark:text-zinc-100">
                                            ₱{{ number_format($donation->amount, 2) }}
                                        </td>

                                        <td class="px-5 py-4 text-zinc-700 dark:text-zinc-300">
                                            {{ $donation->created_at?->format('M d, Y h:i A') ?? '—' }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-5 py-12 text-center text-sm text-zinc-500 dark:text-zinc-400">
                                            No donation records found.
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
        @endif

        {{-- Batch Report --}}
        @if ($tab === 'batches')
            <div class="space-y-6">
                {{-- Filter / Info / Download --}}
                <div class="rounded-2xl border border-zinc-200 bg-white p-5 shadow-sm dark:border-zinc-800 dark:bg-zinc-900">
                    <div class="grid grid-cols-1 gap-4 xl:grid-cols-3">
                        <div class="xl:col-span-2">
                            @if (! $isBatchRepresentative)
                                <label class="mb-2 block text-sm font-medium text-zinc-700 dark:text-zinc-300">
                                    Select Batch
                                </label>
                                <select
                                    wire:model.live="selectedBatch"
                                    class="w-full rounded-xl border border-zinc-300 bg-white px-4 py-2.5 text-sm text-zinc-900 outline-none transition focus:border-teal-500 focus:ring-2 focus:ring-teal-500/20 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-100"
                                >
                                    <option value="all">All Batches</option>
                                    @foreach ($allBatches as $batch)
                                        <option value="{{ $batch->id }}">
                                            Batch {{ $batch->yeargrad }} ({{ $batch->schoolyear }})
                                        </option>
                                    @endforeach
                                </select>
                            @else
                                <label class="mb-2 block text-sm font-medium text-zinc-700 dark:text-zinc-300">
                                    Assigned Batch
                                </label>

                                @php
                                    $myBatch = $allBatches->first();
                                @endphp

                                <div class="rounded-xl border border-zinc-200 bg-zinc-50 px-4 py-2.5 text-sm text-zinc-700 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-200">
                                    {{ $myBatch?->yeargrad ? 'Batch ' . $myBatch->yeargrad . ' (' . $myBatch->schoolyear . ')' : 'No batch assigned' }}
                                </div>
                            @endif
                        </div>

                        <div class="flex items-end">
                            <button
                                type="button"
                                wire:click="downloadBatchReport"
                                class="inline-flex w-full items-center justify-center rounded-xl bg-teal-600 px-4 py-2.5 text-sm font-medium text-white transition hover:bg-teal-700"
                            >
                                Download CSV
                            </button>
                        </div>
                    </div>
                </div>

                {{-- Batch Summary --}}
                <div class="rounded-2xl border border-zinc-200 bg-white p-5 shadow-sm dark:border-zinc-800 dark:bg-zinc-900">
                    <p class="text-sm font-medium text-zinc-500 dark:text-zinc-400">
                        @if ($isBatchRepresentative)
                            Your Batch Member Count
                        @else
                            Total Batch Records
                        @endif
                    </p>

                    <h2 class="mt-2 text-3xl font-bold text-zinc-900 dark:text-white">
                        {{ $batchReports->count() }}
                    </h2>
                </div>

                {{-- Batch Table --}}
                <div class="overflow-hidden rounded-2xl border border-zinc-200 bg-white shadow-sm dark:border-zinc-800 dark:bg-zinc-900">
                    <div class="border-b border-zinc-200 px-5 py-4 dark:border-zinc-800">
                        <h2 class="text-base font-semibold text-zinc-900 dark:text-white">
                            Alumni by Batch
                        </h2>
                        <p class="mt-1 text-sm text-zinc-600 dark:text-zinc-400">
                            @if ($isBatchRepresentative)
                                Summary of members in your assigned batch.
                            @else
                                Summary of total alumni members per batch.
                            @endif
                        </p>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm">
                            <thead class="border-b border-zinc-200 bg-zinc-50 text-zinc-600 dark:border-zinc-800 dark:bg-zinc-950/60 dark:text-zinc-400">
                                <tr>
                                    <th class="px-5 py-3 font-medium">Year Graduated</th>
                                    <th class="px-5 py-3 font-medium">School Year</th>
                                    <th class="px-5 py-3 font-medium text-right">Total Members</th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-zinc-200 dark:divide-zinc-800">
                                @forelse ($batchReports as $batch)
                                    <tr class="transition hover:bg-zinc-50 dark:hover:bg-zinc-800/40">
                                        <td class="px-5 py-4 font-medium text-zinc-900 dark:text-zinc-100">
                                            {{ $batch->yeargrad }}
                                        </td>

                                        <td class="px-5 py-4 text-zinc-700 dark:text-zinc-300">
                                            {{ $batch->schoolyear }}
                                        </td>

                                        <td class="px-5 py-4 text-right font-medium text-zinc-900 dark:text-zinc-100">
                                            {{ $batch->alumni_count }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="px-5 py-12 text-center text-sm text-zinc-500 dark:text-zinc-400">
                                            No batch records found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>