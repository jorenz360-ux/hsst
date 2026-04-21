<div class="min-h-screen  text-gray-800">
    <div class="mx-auto max-w-7xl space-y-6 px-4 py-4 sm:px-6 sm:py-6">

        {{-- Header --}}
        <section class="overflow-hidden rounded-[28px] border border-gray-200 bg-white shadow-sm">
            <div class="border-l-4 border-l-amber-500 flex flex-col gap-6 px-5 py-5 sm:px-6 sm:py-6 lg:flex-row lg:items-end lg:justify-between">
                <div class="max-w-3xl">
                    <p class="text-[11px] font-semibold uppercase tracking-[0.26em] text-amber-600 sm:text-xs">
                        Reports Center
                    </p>

                    <h1 class="mt-2 text-2xl font-bold tracking-tight text-gray-900 sm:text-4xl">
                        Reports & Analytics
                    </h1>

                    <p class="mt-3 text-sm leading-6 text-gray-500 sm:text-[15px]">
                        View, filter, and export donation insights, alumni batch summaries,
                        member listings, and event registration reports in one workspace.
                    </p>
                </div>

                <div class="grid grid-cols-1 gap-3 sm:grid-cols-2 sm:w-auto">
                    <div class="rounded-2xl border border-gray-200 bg-gray-50 px-4 py-3">
                        <p class="text-[11px] uppercase tracking-[0.18em] text-gray-400 sm:text-xs">Module</p>
                        <p class="mt-1 text-sm font-semibold text-gray-800">Reporting</p>
                    </div>

                    <div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3">
                        <p class="text-[11px] uppercase tracking-[0.18em] text-emerald-500 sm:text-xs">Access</p>
                        @php
                            $accessLabel = (auth()->user()?->hasRole('reunion-coordinator') || auth()->user()?->hasRole('super-admin'))
                                ? 'Admin Ready'
                                : 'Batch Rep Ready';
                        @endphp
                        <p class="mt-1 text-sm font-semibold text-emerald-700">
                            {{ $accessLabel }}
                        </p>
                    </div>
                </div>
            </div>
        </section>

        {{-- Report Selector --}}
        <section class="rounded-[24px] border border-gray-200 bg-white p-4 shadow-sm sm:p-5">
            <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
                <div class="max-w-2xl">
                    <p class="text-[11px] font-semibold uppercase tracking-[0.24em] text-gray-400 sm:text-xs">
                        Report View
                    </p>
                    <h2 class="mt-2 text-lg font-semibold text-gray-900">
                        Select a report module
                    </h2>
                    <p class="mt-1 text-sm text-gray-500">
                        Switch between donation, batch, and event reports from one dropdown.
                    </p>
                </div>

                <div class="w-full lg:max-w-sm">
                    <label class="mb-2 block text-sm font-medium text-gray-700">
                        Report Type
                    </label>
                    <select
                        wire:model.live="tab"
                        class="w-full rounded-2xl border border-gray-300 bg-white px-4 py-3 text-sm text-gray-900 outline-none transition focus:border-violet-500 focus:ring-2 focus:ring-violet-500/20"
                    >
                        <option value="donations">Donation Report</option>
                        <option value="batches">Batch Report</option>
                        <option value="events">Event Registrations</option>
                    </select>
                </div>
            </div>

            <div class="mt-4 flex flex-wrap gap-3">
                <div class="rounded-2xl border border-gray-200 bg-gray-100 px-4 py-2 text-[11px] uppercase tracking-[0.18em] text-gray-500 sm:text-xs">
                    Current View:
                    <span class="ml-1 font-semibold text-gray-800">
                        {{ match($tab) {
                            'donations' => 'Donation Report',
                            'batches' => 'Batch Report',
                            'events' => 'Event Registrations',
                            default => 'Donation Report',
                        } }}
                    </span>
                </div>
            </div>
        </section>

        {{-- Global Batch Scope --}}
        <section class="rounded-[24px] border border-gray-200 bg-white p-5 shadow-sm sm:p-6">
            <div class="flex flex-col gap-5 xl:flex-row xl:items-end xl:justify-between">
                <div class="max-w-2xl">
                    <p class="text-[11px] font-semibold uppercase tracking-[0.24em] text-sky-600 sm:text-xs">
                        Global Batch Scope
                    </p>
                    <h2 class="mt-2 text-xl font-semibold text-gray-900">
                        Filter reports by alumni batch
                    </h2>
                    <p class="mt-2 text-sm leading-6 text-gray-500">
                        The selected batch applies across donation, batch, and event registration reports.
                    </p>
                </div>

                <div class="grid w-full gap-4 xl:max-w-3xl xl:grid-cols-[minmax(0,1fr)_180px]">
                    <div>
                        @if (! $isBatchRepresentative)
                            <label class="mb-2 block text-sm font-medium text-gray-700">
                                Select Batch
                            </label>
                            <select
                                wire:model.live="selectedBatch"
                                class="w-full rounded-2xl border border-gray-300 bg-white px-4 py-3 text-sm text-gray-900 outline-none transition focus:border-sky-500 focus:ring-2 focus:ring-sky-500/20"
                            >
                                <option value="all">All Batches</option>
                                @foreach ($allBatches as $batch)
                                    <option value="{{ $batch->id }}">
                                        Batch {{ $batch->yeargrad }} ({{ $batch->schoolyear }})
                                    </option>
                                @endforeach
                            </select>
                        @else
                            <label class="mb-2 block text-sm font-medium text-gray-700">
                                Assigned Batch
                            </label>
                            <div class="rounded-2xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm text-gray-700">
                                {{ $currentBatch?->yeargrad ? 'Batch ' . $currentBatch->yeargrad . ' (' . $currentBatch->schoolyear . ')' : 'No batch assigned' }}
                            </div>
                        @endif
                    </div>

                    <div class="flex items-end">
                        <button
                            type="button"
                            wire:click="resetBatchFilter"
                            class="inline-flex w-full items-center justify-center rounded-2xl border border-gray-300 bg-white px-4 py-3 text-sm font-medium text-gray-600 transition hover:bg-gray-50 disabled:cursor-not-allowed disabled:opacity-50"
                            @disabled($isBatchRepresentative)
                        >
                            Reset Batch Filter
                        </button>
                    </div>
                </div>
            </div>

            <div class="mt-5 flex flex-wrap gap-3">
                <div class="rounded-2xl border border-gray-200 bg-gray-100 px-4 py-2 text-[11px] uppercase tracking-[0.18em] text-gray-500 sm:text-xs">
                    Scope:
                    <span class="ml-1 font-semibold text-gray-800">
                        {{ $currentBatch ? 'Batch ' . $currentBatch->yeargrad : 'All Batches' }}
                    </span>
                </div>

                @if ($currentBatch)
                    <div class="rounded-2xl border border-sky-200 bg-sky-50 px-4 py-2 text-[11px] uppercase tracking-[0.18em] text-sky-700 sm:text-xs">
                        {{ $currentBatch->schoolyear }}
                    </div>
                @endif
            </div>
        </section>

        {{-- Donation Report --}}
        @if ($tab === 'donations')
            <div class="space-y-6">

                {{-- Donation Filters --}}
                <section class="rounded-[24px] border border-gray-200 bg-white p-5 shadow-sm sm:p-6">
                    <div class="mb-5 flex flex-col gap-2">
                        <h2 class="text-lg font-semibold text-gray-900">Donation Filters</h2>
                        <p class="text-sm text-gray-500">
                            Narrow the report period and export donation records
                            {{ $currentBatch ? 'for the selected batch.' : 'across all batches.' }}
                        </p>
                    </div>

                    <div class="grid grid-cols-1 gap-4 xl:grid-cols-4">
                        <div>
                            <label class="mb-2 block text-sm font-medium text-gray-700">Start Date</label>
                            <input
                                type="date"
                                wire:model.live="donationStartDate"
                                class="w-full rounded-2xl border border-gray-300 bg-white px-4 py-3 text-sm text-gray-900 outline-none transition focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20"
                            />
                        </div>

                        <div>
                            <label class="mb-2 block text-sm font-medium text-gray-700">End Date</label>
                            <input
                                type="date"
                                wire:model.live="donationEndDate"
                                class="w-full rounded-2xl border border-gray-300 bg-white px-4 py-3 text-sm text-gray-900 outline-none transition focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20"
                            />
                        </div>

                        <div class="flex items-end">
                            <button
                                type="button"
                                wire:click="resetDonationFilters"
                                class="inline-flex w-full items-center justify-center rounded-2xl border border-gray-300 bg-white px-4 py-3 text-sm font-medium text-gray-600 transition hover:bg-gray-50"
                            >
                                Reset Date Filters
                            </button>
                        </div>

                        <div class="flex items-end">
                            <button
                                type="button"
                                wire:click="downloadDonations"
                                class="inline-flex w-full items-center justify-center rounded-2xl bg-amber-500 px-4 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-amber-600"
                            >
                                Download CSV
                            </button>
                        </div>
                    </div>
                </section>

                {{-- Donation Summary --}}
                <section class="grid grid-cols-1 gap-4 md:grid-cols-2">
                    <div class="rounded-[24px] border border-amber-200 bg-amber-50 p-6">
                        <p class="text-sm font-medium text-amber-600">Total Donations</p>
                        <h2 class="mt-3 text-3xl font-bold tracking-tight text-amber-700 sm:text-4xl">
                            ₱{{ number_format($totalDonationsAmount, 2) }}
                        </h2>
                        <p class="mt-3 text-sm text-amber-500">
                            Matching donation amount in current scope
                        </p>
                    </div>

                    <div class="rounded-[24px] border border-violet-200 bg-violet-50 p-6">
                        <p class="text-sm font-medium text-violet-600">Donation Entries</p>
                        <h2 class="mt-3 text-3xl font-bold tracking-tight text-violet-700 sm:text-4xl">
                            {{ $totalDonationCount }}
                        </h2>
                        <p class="mt-3 text-sm text-violet-500">
                            Total matching donation records
                        </p>
                    </div>
                </section>

                {{-- Donation Table --}}
                <section class="overflow-hidden rounded-[24px] border border-gray-200 bg-white shadow-sm">
                    <div class="flex flex-col gap-3 border-b border-gray-100 px-5 py-5 sm:px-6 lg:flex-row lg:items-end lg:justify-between">
                        <div>
                            <h2 class="text-lg font-semibold text-gray-900">Donation Records</h2>
                            <p class="mt-1 text-sm text-gray-500">
                                @if ($currentBatch)
                                    Showing donation records for Batch {{ $currentBatch->yeargrad }} only.
                                @elseif ($isBatchRepresentative)
                                    Showing donations for your assigned batch only.
                                @else
                                    Showing donation records across all available batches.
                                @endif
                            </p>
                        </div>
                        <div class="rounded-2xl border border-gray-200 bg-gray-100 px-4 py-2 text-[11px] uppercase tracking-[0.18em] text-gray-400 sm:text-xs">
                            Live Report Table
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full min-w-[720px] text-left text-sm">
                            <thead class="border-b border-gray-100 bg-gray-50 text-xs font-semibold uppercase tracking-wide text-gray-400">
                                <tr>
                                    <th class="px-5 py-3 font-medium sm:px-6">Donor</th>
                                    <th class="px-5 py-3 font-medium sm:px-6">Batch</th>
                                    <th class="px-5 py-3 font-medium sm:px-6">School Year</th>
                                    <th class="px-5 py-3 text-right font-medium sm:px-6">Amount</th>
                                    <th class="px-5 py-3 font-medium sm:px-6">Date</th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-gray-100">
                                @forelse ($donations as $donation)
                                    <tr class="transition hover:bg-amber-50/50">
                                        <td class="px-5 py-4 font-medium text-gray-900 sm:px-6">
                                            @if ($donation->alumni)
                                                {{ trim(collect([$donation->alumni->fname, $donation->alumni->mname, $donation->alumni->lname])->filter()->implode(' ')) }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td class="px-5 py-4 text-gray-600 sm:px-6">
                                            {{ $donation->alumni?->batch?->yeargrad ?? '-' }}
                                        </td>
                                        <td class="px-5 py-4 text-gray-600 sm:px-6">
                                            {{ $donation->alumni?->batch?->schoolyear ?? '-' }}
                                        </td>
                                        <td class="px-5 py-4 text-right font-semibold text-gray-900 sm:px-6">
                                            ₱{{ number_format($donation->amount, 2) }}
                                        </td>
                                        <td class="px-5 py-4 text-gray-500 sm:px-6">
                                            {{ $donation->created_at?->format('M d, Y h:i A') ?? '-' }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-14 text-center text-sm text-gray-400">
                                            No donation records found for the current batch filter.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="flex flex-col gap-3 border-t border-gray-100 px-5 py-4 text-sm sm:flex-row sm:items-center sm:justify-between sm:px-6">
                        <p class="text-gray-400">
                            Showing {{ $donations->firstItem() ?? 0 }}–{{ $donations->lastItem() ?? 0 }} of {{ $donations->total() }}
                        </p>
                        <div class="[&>*]:!shadow-none">{{ $donations->links() }}</div>
                    </div>
                </section>
            </div>
        @endif

        {{-- Batch Report --}}
        @if ($tab === 'batches')
            <div class="space-y-6">

                {{-- Batch Controls --}}
                <section class="rounded-[24px] border border-gray-200 bg-white p-5 shadow-sm sm:p-6">
                    <div class="mb-5 flex flex-col gap-2">
                        <h2 class="text-lg font-semibold text-gray-900">Batch Report Controls</h2>
                        <p class="text-sm text-gray-500">
                            Review batch totals and alumni member listings based on the active batch scope.
                        </p>
                    </div>

                    <div class="flex flex-col gap-3 sm:flex-row sm:justify-end">
                        <button
                            type="button"
                            wire:click="downloadBatchReport"
                            class="inline-flex items-center justify-center rounded-2xl bg-violet-600 px-4 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-violet-500"
                        >
                            Download Batch Summary
                        </button>

                        <button
                            type="button"
                            wire:click="downloadBatchMembers"
                            class="inline-flex items-center justify-center rounded-2xl border border-gray-300 bg-white px-4 py-3 text-sm font-semibold text-gray-700 transition hover:bg-gray-50"
                        >
                            Download Members List
                        </button>
                    </div>
                </section>

                {{-- Batch Summary Cards --}}
                <section class="grid grid-cols-1 gap-4 md:grid-cols-2">
                    <div class="rounded-[24px] border border-violet-200 bg-violet-50 p-6">
                        <p class="text-sm font-medium text-violet-600">
                            @if ($currentBatch) Selected Batch @else Batch Records @endif
                        </p>
                        <h2 class="mt-3 text-3xl font-bold tracking-tight text-violet-700 sm:text-4xl">
                            {{ $batchReports->count() }}
                        </h2>
                        <p class="mt-3 text-sm text-violet-500">Batch summary rows in current scope</p>
                    </div>

                    <div class="rounded-[24px] border border-sky-200 bg-sky-50 p-6">
                        <p class="text-sm font-medium text-sky-600">Total Alumni Members</p>
                        <h2 class="mt-3 text-3xl font-bold tracking-tight text-sky-700 sm:text-4xl">
                            {{ $totalBatchMembers }}
                        </h2>
                        <p class="mt-3 text-sm text-sky-500">Total alumni covered by the active scope</p>
                    </div>
                </section>

                {{-- Batch Summary Table --}}
                <section class="overflow-hidden rounded-[24px] border border-gray-200 bg-white shadow-sm">
                    <div class="flex flex-col gap-3 border-b border-gray-100 px-5 py-5 sm:px-6 lg:flex-row lg:items-end lg:justify-between">
                        <div>
                            <h2 class="text-lg font-semibold text-gray-900">Alumni by Batch</h2>
                            <p class="mt-1 text-sm text-gray-500">
                                @if ($currentBatch)
                                    Summary for Batch {{ $currentBatch->yeargrad }}.
                                @elseif ($isBatchRepresentative)
                                    Summary of members in your assigned batch.
                                @else
                                    Summary of total alumni members per batch.
                                @endif
                            </p>
                        </div>
                        <div class="rounded-2xl border border-gray-200 bg-gray-100 px-4 py-2 text-[11px] uppercase tracking-[0.18em] text-gray-400 sm:text-xs">
                            Summary Matrix
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full min-w-[560px] text-left text-sm">
                            <thead class="border-b border-gray-100 bg-gray-50 text-xs font-semibold uppercase tracking-wide text-gray-400">
                                <tr>
                                    <th class="px-5 py-3 font-medium sm:px-6">Year Graduated</th>
                                    <th class="px-5 py-3 font-medium sm:px-6">School Year</th>
                                    <th class="px-5 py-3 text-right font-medium sm:px-6">Total Members</th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-gray-100">
                                @forelse ($batchReports as $batch)
                                    <tr class="transition hover:bg-violet-50/50">
                                        <td class="px-5 py-4 font-semibold text-gray-900 sm:px-6">
                                            {{ $batch->yeargrad }}
                                        </td>
                                        <td class="px-5 py-4 text-gray-600 sm:px-6">
                                            {{ $batch->schoolyear }}
                                        </td>
                                        <td class="px-5 py-4 text-right font-semibold text-gray-900 sm:px-6">
                                            {{ $batch->alumni_count }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="px-6 py-14 text-center text-sm text-gray-400">
                                            No batch records found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </section>

                {{-- Batch Members Table --}}
                <section class="overflow-hidden rounded-[24px] border border-gray-200 bg-white shadow-sm">
                    <div class="flex flex-col gap-3 border-b border-gray-100 px-5 py-5 sm:px-6 lg:flex-row lg:items-end lg:justify-between">
                        <div>
                            <h2 class="text-lg font-semibold text-gray-900">Alumni Members</h2>
                            <p class="mt-1 text-sm text-gray-500">
                                @if ($currentBatch)
                                    Showing alumni under Batch {{ $currentBatch->yeargrad }}.
                                @else
                                    Showing alumni across all batches.
                                @endif
                            </p>
                        </div>
                        <div class="rounded-2xl border border-gray-200 bg-gray-100 px-4 py-2 text-[11px] uppercase tracking-[0.18em] text-gray-400 sm:text-xs">
                            Member Directory
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full min-w-[1100px] text-left text-sm">
                            <thead class="border-b border-gray-100 bg-gray-50 text-xs font-semibold uppercase tracking-wide text-gray-400">
                                <tr>
                                    <th class="px-5 py-3 font-medium sm:px-6">Full Name</th>
                                    <th class="px-5 py-3 font-medium sm:px-6">Batch</th>
                                    <th class="px-5 py-3 font-medium sm:px-6">School Year</th>
                                    <th class="px-5 py-3 font-medium sm:px-6">Batch Rep</th>
                                    <th class="px-5 py-3 font-medium sm:px-6">Occupation</th>
                                    <th class="px-5 py-3 font-medium sm:px-6">Address</th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-gray-100">
                                @forelse ($batchMembers as $member)
                                    @php
                                        $fullAddress = collect([
                                            $member->address_line_1,
                                            $member->address_line_2,
                                            $member->city,
                                            $member->state_province,
                                            $member->postal_code,
                                            $member->country,
                                        ])->filter()->implode(', ');
                                    @endphp

                                    <tr class="transition hover:bg-violet-50/40">
                                        <td class="px-5 py-4 font-medium text-gray-900 sm:px-6">
                                            {{ trim(collect([$member->fname, $member->mname, $member->lname])->filter()->implode(' ')) }}
                                        </td>
                                        <td class="px-5 py-4 text-gray-600 sm:px-6">
                                            {{ $member->batch?->yeargrad ?? '-' }}
                                        </td>
                                        <td class="px-5 py-4 text-gray-600 sm:px-6">
                                            {{ $member->batch?->schoolyear ?? '-' }}
                                        </td>
                                        <td class="px-5 py-4 sm:px-6">
                                            @if ($member->is_batch_rep)
                                                <span class="inline-flex rounded-full border border-emerald-200 bg-emerald-50 px-3 py-1 text-[11px] font-semibold uppercase tracking-[0.12em] text-emerald-700">
                                                    Yes
                                                </span>
                                            @else
                                                <span class="inline-flex rounded-full border border-gray-200 bg-gray-100 px-3 py-1 text-[11px] font-semibold uppercase tracking-[0.12em] text-gray-500">
                                                    No
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-5 py-4 text-gray-600 sm:px-6">
                                            {{ $member->occupation ?: '-' }}
                                        </td>
                                        <td class="px-5 py-4 text-gray-600 sm:px-6">
                                            {{ $fullAddress ?: '-' }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-14 text-center text-sm text-gray-400">
                                            No alumni found for the current batch filter.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="flex flex-col gap-3 border-t border-gray-100 px-5 py-4 text-sm sm:flex-row sm:items-center sm:justify-between sm:px-6">
                        <p class="text-gray-400">
                            Showing {{ $batchMembers->firstItem() ?? 0 }}–{{ $batchMembers->lastItem() ?? 0 }} of {{ $batchMembers->total() }}
                        </p>
                        <div class="[&>*]:!shadow-none">{{ $batchMembers->links() }}</div>
                    </div>
                </section>
            </div>
        @endif

        {{-- Event Registration Report --}}
        @if ($tab === 'events')
            <div class="space-y-6">

                {{-- Event Filters --}}
                <section class="rounded-[24px] border border-gray-200 bg-white p-5 shadow-sm sm:p-6">
                    <div class="mb-5">
                        <h2 class="text-lg font-semibold text-gray-900">Event Registration Filters</h2>
                        <p class="mt-1 text-sm text-gray-500">
                            Review registrants by event and registration status.
                        </p>
                    </div>

                    <div class="grid grid-cols-1 gap-4 xl:grid-cols-4">
                        <div>
                            <label class="mb-2 block text-sm font-medium text-gray-700">Select Event</label>
                            <select
                                wire:model.live="selectedEvent"
                                class="w-full rounded-2xl border border-gray-300 bg-white px-4 py-3 text-sm text-gray-900 outline-none transition focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20"
                            >
                                <option value="all">All Events</option>
                                @foreach ($allEvents as $eventOption)
                                    <option value="{{ $eventOption->id }}">
                                        {{ $eventOption->title }}
                                        @if ($eventOption->event_date)
                                            - {{ $eventOption->event_date->format('M d, Y') }}
                                        @endif
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="mb-2 block text-sm font-medium text-gray-700">Registration Status</label>
                            <select
                                wire:model.live="registrationStatus"
                                class="w-full rounded-2xl border border-gray-300 bg-white px-4 py-3 text-sm text-gray-900 outline-none transition focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20"
                            >
                                <option value="all">All Statuses</option>
                                <option value="paid">Paid</option>
                                <option value="pending">Pending</option>
                                <option value="rejected">Rejected</option>
                                <option value="registered">Registered</option>
                            </select>
                        </div>

                        <div class="flex items-end">
                            <button
                                type="button"
                                wire:click="resetEventFilters"
                                class="inline-flex w-full items-center justify-center rounded-2xl border border-gray-300 bg-white px-4 py-3 text-sm font-medium text-gray-600 transition hover:bg-gray-50"
                            >
                                Reset Filters
                            </button>
                        </div>

                        <div class="flex items-end">
                            <button
                                type="button"
                                wire:click="downloadEventRegistrations"
                                class="inline-flex w-full items-center justify-center rounded-2xl bg-emerald-600 px-4 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-emerald-500"
                            >
                                Download CSV
                            </button>
                        </div>
                    </div>
                </section>

                {{-- Event Summary --}}
                <section class="grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-4">
                    <div class="rounded-[24px] border border-emerald-200 bg-emerald-50 p-6">
                        <p class="text-sm font-medium text-emerald-600">Total Registrations</p>
                        <h2 class="mt-3 text-3xl font-bold tracking-tight text-emerald-700 sm:text-4xl">
                            {{ $totalEventRegistrations }}
                        </h2>
                        <p class="mt-3 text-sm text-emerald-500">All matching event registration records</p>
                    </div>

                    <div class="rounded-[24px] border border-sky-200 bg-sky-50 p-6">
                        <p class="text-sm font-medium text-sky-600">Paid</p>
                        <h2 class="mt-3 text-3xl font-bold tracking-tight text-sky-700 sm:text-4xl">
                            {{ $paidEventRegistrations }}
                        </h2>
                        <p class="mt-3 text-sm text-sky-500">Fully verified / paid registrations</p>
                    </div>

                    <div class="rounded-[24px] border border-amber-200 bg-amber-50 p-6">
                        <p class="text-sm font-medium text-amber-600">Pending</p>
                        <h2 class="mt-3 text-3xl font-bold tracking-tight text-amber-700 sm:text-4xl">
                            {{ $pendingEventRegistrations }}
                        </h2>
                        <p class="mt-3 text-sm text-amber-500">Waiting for payment review / completion</p>
                    </div>

                    <div class="rounded-[24px] border border-rose-200 bg-rose-50 p-6">
                        <p class="text-sm font-medium text-rose-600">Rejected</p>
                        <h2 class="mt-3 text-3xl font-bold tracking-tight text-rose-700 sm:text-4xl">
                            {{ $rejectedEventRegistrations }}
                        </h2>
                        <p class="mt-3 text-sm text-rose-500">Rejected registration payment records</p>
                    </div>
                </section>

                {{-- Event Registrations Table --}}
                <section class="overflow-hidden rounded-[24px] border border-gray-200 bg-white shadow-sm">
                    <div class="flex flex-col gap-3 border-b border-gray-100 px-5 py-5 sm:px-6 lg:flex-row lg:items-end lg:justify-between">
                        <div>
                            <h2 class="text-lg font-semibold text-gray-900">Event Registrants</h2>
                            <p class="mt-1 text-sm text-gray-500">
                                Registration report for selected events, statuses,
                                {{ $currentBatch ? 'and the active batch scope.' : 'across all batches.' }}
                            </p>
                        </div>
                        <div class="rounded-2xl border border-gray-200 bg-gray-100 px-4 py-2 text-[11px] uppercase tracking-[0.18em] text-gray-400 sm:text-xs">
                            Registration Report
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full min-w-[920px] text-left text-sm">
                            <thead class="border-b border-gray-100 bg-gray-50 text-xs font-semibold uppercase tracking-wide text-gray-400">
                                <tr>
                                    <th class="px-5 py-3 font-medium sm:px-6">Event</th>
                                    <th class="px-5 py-3 font-medium sm:px-6">Registrant</th>
                                    <th class="px-5 py-3 font-medium sm:px-6">Batch</th>
                                    <th class="px-5 py-3 font-medium sm:px-6">School Year</th>
                                    <th class="px-5 py-3 font-medium sm:px-6">Status</th>
                                    <th class="px-5 py-3 font-medium sm:px-6">Registered At</th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-gray-100">
                                @forelse ($eventRegistrations as $registration)
                                    <tr class="transition hover:bg-emerald-50/40">
                                        <td class="px-5 py-4 text-gray-700 sm:px-6">
                                            {{ $registration->event?->title ?? '-' }}
                                        </td>
                                        <td class="px-5 py-4 font-medium text-gray-900 sm:px-6">
                                            @if ($registration->alumni)
                                                {{ trim(collect([$registration->alumni->fname, $registration->alumni->mname, $registration->alumni->lname])->filter()->implode(' ')) }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td class="px-5 py-4 text-gray-600 sm:px-6">
                                            {{ $registration->alumni?->batch?->yeargrad ?? '-' }}
                                        </td>
                                        <td class="px-5 py-4 text-gray-600 sm:px-6">
                                            {{ $registration->alumni?->batch?->schoolyear ?? '-' }}
                                        </td>
                                        <td class="px-5 py-4 sm:px-6">
                                            @php
                                                $statusClasses = match($registration->status) {
                                                    'paid'       => 'border-sky-200 bg-sky-50 text-sky-700',
                                                    'pending'    => 'border-amber-200 bg-amber-50 text-amber-700',
                                                    'rejected'   => 'border-rose-200 bg-rose-50 text-rose-700',
                                                    default      => 'border-emerald-200 bg-emerald-50 text-emerald-700',
                                                };
                                            @endphp
                                            <span class="inline-flex rounded-full border px-3 py-1 text-[11px] font-semibold uppercase tracking-[0.12em] {{ $statusClasses }}">
                                                {{ $registration->status ?? '-' }}
                                            </span>
                                        </td>
                                        <td class="px-5 py-4 text-gray-500 sm:px-6">
                                            {{ $registration->created_at?->format('M d, Y h:i A') ?? '-' }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-14 text-center text-sm text-gray-400">
                                            No event registration records found for the current filters.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="flex flex-col gap-3 border-t border-gray-100 px-5 py-4 text-sm sm:flex-row sm:items-center sm:justify-between sm:px-6">
                        <p class="text-gray-400">
                            Showing {{ $eventRegistrations->firstItem() ?? 0 }}–{{ $eventRegistrations->lastItem() ?? 0 }} of {{ $eventRegistrations->total() }}
                        </p>
                        <div class="[&>*]:!shadow-none">{{ $eventRegistrations->links() }}</div>
                    </div>
                </section>
            </div>
        @endif
    </div>
</div>
