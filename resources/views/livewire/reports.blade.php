<div class="min-h-screen bg-zinc-950 text-zinc-100 rounded-2xl">
    <div class="mx-auto max-w-7xl space-y-8 px-6 py-6">

        {{-- Premium Header --}}
        <section class="overflow-hidden rounded-[28px] border border-white/10 bg-gradient-to-br from-zinc-900 via-zinc-900 to-violet-950/30 shadow-[0_24px_80px_rgba(0,0,0,0.45)]">
            <div class="flex flex-col gap-6 px-6 py-6 lg:flex-row lg:items-end lg:justify-between">
                <div class="max-w-3xl">
                    <p class="text-xs font-semibold uppercase tracking-[0.26em] text-amber-400">
                        Reports Center
                    </p>

                    <h1 class="mt-2 text-3xl font-bold tracking-tight text-white sm:text-4xl">
                        Reports & Analytics
                    </h1>

                    <p class="mt-3 text-sm leading-6 text-zinc-400 sm:text-[15px]">
                        View, filter, and export donation insights and alumni batch summaries
                        through a premium reporting workspace built for administrators.
                    </p>
                </div>

                <div class="grid grid-cols-2 gap-3 sm:w-auto">
                    <div class="rounded-2xl border border-white/10 bg-white/[0.04] px-4 py-3 backdrop-blur">
                        <p class="text-xs uppercase tracking-[0.18em] text-zinc-500">Module</p>
                        <p class="mt-1 text-sm font-semibold text-white">Reporting</p>
                    </div>

                    <div class="rounded-2xl border border-white/10 bg-white/[0.04] px-4 py-3 backdrop-blur">
                        <p class="text-xs uppercase tracking-[0.18em] text-zinc-500">Access</p>
                        <p class="mt-1 text-sm font-semibold text-emerald-300">Admin Ready</p>
                    </div>
                </div>
            </div>
        </section>

        {{-- Premium Tabs --}}
        <div class="rounded-[24px] border border-white/10 bg-zinc-900/80 p-1.5 shadow-[0_10px_30px_rgba(0,0,0,0.25)] backdrop-blur">
            <div class="grid grid-cols-2 gap-1.5">
                <button
                    wire:click="$set('tab', 'donations')"
                    class="{{ $tab === 'donations'
                        ? 'bg-amber-500 text-zinc-950 shadow-[0_8px_24px_rgba(245,158,11,0.28)]'
                        : 'text-zinc-400 hover:bg-white/[0.04]' }} rounded-2xl px-4 py-3 text-sm font-semibold transition"
                >
                    Donation Report
                </button>

                <button
                    wire:click="$set('tab', 'batches')"
                    class="{{ $tab === 'batches'
                        ? 'bg-violet-500 text-white shadow-[0_8px_24px_rgba(139,92,246,0.28)]'
                        : 'text-zinc-400 hover:bg-white/[0.04]' }} rounded-2xl px-4 py-3 text-sm font-semibold transition"
                >
                    By Batch Report
                </button>
            </div>
        </div>

        {{-- Donation Report --}}
        @if ($tab === 'donations')
            <div class="space-y-6">

                {{-- Premium Filter Bar --}}
                <section class="rounded-[24px] border border-white/10 bg-zinc-900/70 p-6 shadow-[0_12px_32px_rgba(0,0,0,0.22)] backdrop-blur">
                    <div class="mb-5 flex flex-col gap-2">
                        <h2 class="text-lg font-semibold text-white">Donation Filters</h2>
                        <p class="text-sm text-zinc-400">
                            Narrow the report period and export high-confidence donation records.
                        </p>
                    </div>

                    <div class="grid grid-cols-1 gap-4 xl:grid-cols-4">
                        <div>
                            <label class="mb-2 block text-sm font-medium text-zinc-300">
                                Start Date
                            </label>
                            <input
                                type="date"
                                wire:model.live="donationStartDate"
                                class="w-full rounded-2xl border border-white/10 bg-zinc-950 px-4 py-3 text-sm text-zinc-100 outline-none transition focus:border-amber-400 focus:ring-2 focus:ring-amber-500/20"
                            />
                        </div>

                        <div>
                            <label class="mb-2 block text-sm font-medium text-zinc-300">
                                End Date
                            </label>
                            <input
                                type="date"
                                wire:model.live="donationEndDate"
                                class="w-full rounded-2xl border border-white/10 bg-zinc-950 px-4 py-3 text-sm text-zinc-100 outline-none transition focus:border-amber-400 focus:ring-2 focus:ring-amber-500/20"
                            />
                        </div>

                        <div class="flex items-end">
                            <button
                                type="button"
                                wire:click="resetDonationFilters"
                                class="inline-flex w-full items-center justify-center rounded-2xl border border-white/10 bg-zinc-950 px-4 py-3 text-sm font-medium text-zinc-200 transition hover:bg-zinc-800"
                            >
                                Reset Filters
                            </button>
                        </div>

                        <div class="flex items-end">
                            <button
                                type="button"
                                wire:click="downloadDonations"
                                class="inline-flex w-full items-center justify-center rounded-2xl bg-amber-500 px-4 py-3 text-sm font-semibold text-zinc-950 shadow-[0_10px_28px_rgba(245,158,11,0.25)] transition hover:bg-amber-400"
                            >
                                Download CSV
                            </button>
                        </div>
                    </div>
                </section>

                {{-- Premium Summary Cards --}}
                <section class="grid grid-cols-1 gap-4 md:grid-cols-2">
                    <div class="rounded-[24px] border border-amber-500/10 bg-gradient-to-br from-zinc-900 to-amber-950/20 p-6 shadow-[0_14px_34px_rgba(0,0,0,0.24)]">
                        <p class="text-sm font-medium text-zinc-400">
                            Total Donations
                        </p>
                        <h2 class="mt-3 text-3xl font-bold tracking-tight text-white sm:text-4xl">
                            ₱{{ number_format($totalDonationsAmount, 2) }}
                        </h2>
                        <p class="mt-3 text-sm text-amber-300">
                            Verified collection within selected range
                        </p>
                    </div>

                    <div class="rounded-[24px] border border-violet-500/10 bg-gradient-to-br from-zinc-900 to-violet-950/20 p-6 shadow-[0_14px_34px_rgba(0,0,0,0.24)]">
                        <p class="text-sm font-medium text-zinc-400">
                            Donation Entries
                        </p>
                        <h2 class="mt-3 text-3xl font-bold tracking-tight text-white sm:text-4xl">
                            {{ $totalDonationCount }}
                        </h2>
                        <p class="mt-3 text-sm text-violet-300">
                            Total matching records in current report
                        </p>
                    </div>
                </section>

                {{-- Premium Donation Table --}}
                <section class="overflow-hidden rounded-[24px] border border-white/10 bg-zinc-900/75 shadow-[0_18px_40px_rgba(0,0,0,0.28)] backdrop-blur">
                    <div class="flex flex-col gap-3 border-b border-white/10 px-6 py-5 lg:flex-row lg:items-end lg:justify-between">
                        <div>
                            <h2 class="text-lg font-semibold text-white">
                                Donation Records
                            </h2>
                            <p class="mt-1 text-sm text-zinc-400">
                                @if ($isBatchRepresentative)
                                    Showing donations for your assigned batch only.
                                @else
                                    Showing donation records across all available batches.
                                @endif
                            </p>
                        </div>

                        <div class="rounded-2xl border border-white/10 bg-zinc-950/70 px-4 py-2 text-xs uppercase tracking-[0.18em] text-zinc-500">
                            Live Report Table
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm">
                            <thead class="border-b border-white/10 bg-zinc-950/80 text-zinc-400">
                                <tr>
                                    <th class="px-6 py-4 font-medium">Donor</th>
                                    <th class="px-6 py-4 font-medium">Batch</th>
                                    <th class="px-6 py-4 font-medium">School Year</th>
                                    <th class="px-6 py-4 text-right font-medium">Amount</th>
                                    <th class="px-6 py-4 font-medium">Date</th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-white/10">
                                @forelse ($donations as $donation)
                                    <tr class="transition hover:bg-amber-500/[0.04]">
                                        <td class="px-6 py-4 text-zinc-100">
                                            @if ($donation->alumni)
                                                {{ $donation->alumni->fname }} {{ $donation->alumni->lname }}
                                            @else
                                                —
                                            @endif
                                        </td>

                                        <td class="px-6 py-4 text-zinc-300">
                                            {{ $donation->alumni?->batch?->yeargrad ?? '—' }}
                                        </td>

                                        <td class="px-6 py-4 text-zinc-300">
                                            {{ $donation->alumni?->batch?->schoolyear ?? '—' }}
                                        </td>

                                        <td class="px-6 py-4 text-right font-semibold text-white">
                                            ₱{{ number_format($donation->amount, 2) }}
                                        </td>

                                        <td class="px-6 py-4 text-zinc-300">
                                            {{ $donation->created_at?->format('M d, Y h:i A') ?? '—' }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-14 text-center text-sm text-zinc-500">
                                            No donation records found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="flex flex-col gap-3 border-t border-white/10 px-6 py-4 text-sm sm:flex-row sm:items-center sm:justify-between">
                        <p class="text-zinc-400">
                            Showing {{ $donations->firstItem() ?? 0 }}–{{ $donations->lastItem() ?? 0 }} of {{ $donations->total() }}
                        </p>

                        <div class="[&>*]:!shadow-none">
                            {{ $donations->links() }}
                        </div>
                    </div>
                </section>
            </div>
        @endif

        {{-- Batch Report --}}
        @if ($tab === 'batches')
            <div class="space-y-6">

                {{-- Premium Filter / Action --}}
                <section class="rounded-[24px] border border-white/10 bg-zinc-900/70 p-6 shadow-[0_12px_32px_rgba(0,0,0,0.22)] backdrop-blur">
                    <div class="mb-5">
                        <h2 class="text-lg font-semibold text-white">Batch Report Controls</h2>
                        <p class="mt-1 text-sm text-zinc-400">
                            Review alumni totals by batch and export summary data.
                        </p>
                    </div>

                    <div class="grid grid-cols-1 gap-4 xl:grid-cols-3">
                        <div class="xl:col-span-2">
                            @if (! $isBatchRepresentative)
                                <label class="mb-2 block text-sm font-medium text-zinc-300">
                                    Select Batch
                                </label>
                                <select
                                    wire:model.live="selectedBatch"
                                    class="w-full rounded-2xl border border-white/10 bg-zinc-950 px-4 py-3 text-sm text-zinc-100 outline-none transition focus:border-violet-400 focus:ring-2 focus:ring-violet-500/20"
                                >
                                    <option value="all">All Batches</option>
                                    @foreach ($allBatches as $batch)
                                        <option value="{{ $batch->id }}">
                                            Batch {{ $batch->yeargrad }} ({{ $batch->schoolyear }})
                                        </option>
                                    @endforeach
                                </select>
                            @else
                                <label class="mb-2 block text-sm font-medium text-zinc-300">
                                    Assigned Batch
                                </label>

                                @php
                                    $myBatch = $allBatches->first();
                                @endphp

                                <div class="rounded-2xl border border-white/10 bg-zinc-950 px-4 py-3 text-sm text-zinc-200">
                                    {{ $myBatch?->yeargrad ? 'Batch ' . $myBatch->yeargrad . ' (' . $myBatch->schoolyear . ')' : 'No batch assigned' }}
                                </div>
                            @endif
                        </div>

                        <div class="flex items-end">
                            <button
                                type="button"
                                wire:click="downloadBatchReport"
                                class="inline-flex w-full items-center justify-center rounded-2xl bg-violet-500 px-4 py-3 text-sm font-semibold text-white shadow-[0_10px_28px_rgba(139,92,246,0.25)] transition hover:bg-violet-400"
                            >
                                Download CSV
                            </button>
                        </div>
                    </div>
                </section>

                {{-- Premium Batch Summary --}}
                <section class="rounded-[24px] border border-white/10 bg-gradient-to-br from-zinc-900 to-violet-950/20 p-6 shadow-[0_14px_34px_rgba(0,0,0,0.24)]">
                    <p class="text-sm font-medium text-zinc-400">
                        @if ($isBatchRepresentative)
                            Your Batch Member Count
                        @else
                            Total Batch Records
                        @endif
                    </p>

                    <h2 class="mt-3 text-3xl font-bold tracking-tight text-white sm:text-4xl">
                        {{ $batchReports->count() }}
                    </h2>

                    <p class="mt-3 text-sm text-violet-300">
                        Consolidated alumni totals based on current batch scope
                    </p>
                </section>

                {{-- Premium Batch Table --}}
                <section class="overflow-hidden rounded-[24px] border border-white/10 bg-zinc-900/75 shadow-[0_18px_40px_rgba(0,0,0,0.28)] backdrop-blur">
                    <div class="flex flex-col gap-3 border-b border-white/10 px-6 py-5 lg:flex-row lg:items-end lg:justify-between">
                        <div>
                            <h2 class="text-lg font-semibold text-white">
                                Alumni by Batch
                            </h2>
                            <p class="mt-1 text-sm text-zinc-400">
                                @if ($isBatchRepresentative)
                                    Summary of members in your assigned batch.
                                @else
                                    Summary of total alumni members per batch.
                                @endif
                            </p>
                        </div>

                        <div class="rounded-2xl border border-white/10 bg-zinc-950/70 px-4 py-2 text-xs uppercase tracking-[0.18em] text-zinc-500">
                            Summary Matrix
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm">
                            <thead class="border-b border-white/10 bg-zinc-950/80 text-zinc-400">
                                <tr>
                                    <th class="px-6 py-4 font-medium">Year Graduated</th>
                                    <th class="px-6 py-4 font-medium">School Year</th>
                                    <th class="px-6 py-4 text-right font-medium">Total Members</th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-white/10">
                                @forelse ($batchReports as $batch)
                                    <tr class="transition hover:bg-violet-500/[0.04]">
                                        <td class="px-6 py-4 font-semibold text-white">
                                            {{ $batch->yeargrad }}
                                        </td>

                                        <td class="px-6 py-4 text-zinc-300">
                                            {{ $batch->schoolyear }}
                                        </td>

                                        <td class="px-6 py-4 text-right font-semibold text-white">
                                            {{ $batch->alumni_count }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="px-6 py-14 text-center text-sm text-zinc-500">
                                            No batch records found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </section>
            </div>
        @endif
    </div>
</div>