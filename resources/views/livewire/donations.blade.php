<div class="min-h-screen bg-gray-50 text-gray-800">
    <div class="mx-auto max-w-7xl space-y-6 px-4 py-8 sm:px-6">

        {{-- Header --}}
        <section class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">
            <div class="border-l-4 border-l-amber-500 px-6 py-6">
                <p class="text-xs font-semibold uppercase tracking-[0.22em] text-amber-600">
                    Admin Panel
                </p>
                <h1 class="mt-1 text-2xl font-semibold tracking-tight text-gray-900">
                    Donation Verification
                </h1>
                <p class="mt-1.5 max-w-2xl text-sm text-gray-500">
                    Review uploaded donation proofs, verify valid submissions, and reject incorrect or unclear records.
                </p>
            </div>
        </section>

        {{-- Flash Messages --}}
        @if (session('success'))
            <div class="flex items-start gap-3 rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
                <flux:icon name="check-circle" class="mt-0.5 h-4 w-4 shrink-0 text-emerald-500" />
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="flex items-start gap-3 rounded-2xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-700">
                <flux:icon name="x-circle" class="mt-0.5 h-4 w-4 shrink-0 text-rose-500" />
                {{ session('error') }}
            </div>
        @endif

        {{-- Filters --}}
        <section class="rounded-2xl border border-gray-200 bg-white shadow-sm">
            <div class="flex flex-col gap-4 px-5 py-4 sm:flex-row sm:items-center sm:justify-between">

                {{-- Segmented status filter --}}
                <div class="inline-flex rounded-xl bg-gray-100 p-1 gap-0.5">
                    <button
                        wire:click="$set('statusFilter', 'all')"
                        class="rounded-lg px-4 py-2 text-sm font-medium transition
                            {{ $statusFilter === 'all'
                                ? 'bg-white text-gray-900 shadow-sm'
                                : 'text-gray-500 hover:text-gray-700' }}">
                        All
                    </button>

                    <button
                        wire:click="$set('statusFilter', 'pending')"
                        class="rounded-lg px-4 py-2 text-sm font-medium transition
                            {{ $statusFilter === 'pending'
                                ? 'bg-white text-amber-600 shadow-sm'
                                : 'text-gray-500 hover:text-gray-700' }}">
                        Pending
                    </button>

                    <button
                        wire:click="$set('statusFilter', 'verified')"
                        class="rounded-lg px-4 py-2 text-sm font-medium transition
                            {{ $statusFilter === 'verified'
                                ? 'bg-white text-emerald-600 shadow-sm'
                                : 'text-gray-500 hover:text-gray-700' }}">
                        Verified
                    </button>

                    <button
                        wire:click="$set('statusFilter', 'rejected')"
                        class="rounded-lg px-4 py-2 text-sm font-medium transition
                            {{ $statusFilter === 'rejected'
                                ? 'bg-white text-rose-600 shadow-sm'
                                : 'text-gray-500 hover:text-gray-700' }}">
                        Rejected
                    </button>
                </div>

                <div class="w-full sm:w-72">
                    <div class="relative">
                        <flux:icon name="magnifying-glass" class="absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-gray-400" />
                        <input
                            type="text"
                            wire:model.live.debounce.300ms="search"
                            placeholder="Search donor or reference..."
                            class="w-full rounded-xl border border-gray-300 bg-white py-2.5 pl-9 pr-4 text-sm text-gray-900 outline-none transition placeholder:text-gray-400 focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20"
                        >
                    </div>
                </div>
            </div>
        </section>

        {{-- Desktop Table --}}
        <section class="hidden overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm lg:block">
            <div class="border-b border-gray-100 px-6 py-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-base font-semibold text-gray-900">Donation Records</h2>
                        <p class="mt-0.5 text-xs text-gray-400">Only verified donations are counted in reports and totals.</p>
                    </div>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="border-b border-gray-100 bg-gray-50 text-xs font-semibold uppercase tracking-wide text-gray-400">
                        <tr>
                            <th class="px-6 py-3">Donor</th>
                            <th class="px-6 py-3">Amount</th>
                            <th class="px-6 py-3">Reference</th>
                            <th class="px-6 py-3">Submitted</th>
                            <th class="px-6 py-3">Status</th>
                            <th class="px-6 py-3">Proof</th>
                            <th class="px-6 py-3 text-right">Actions</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100">
                        @forelse ($donations as $donation)
                            <tr class="align-top transition hover:bg-amber-50/40">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-amber-100 text-xs font-bold text-amber-700">
                                            {{ strtoupper(substr($donation->alumni->fname ?? '?', 0, 1)) }}
                                        </div>
                                        <div>
                                            <p class="font-medium text-gray-900">
                                                {{ trim(($donation->alumni->fname ?? '') . ' ' . ($donation->alumni->lname ?? '')) ?: 'Unknown Donor' }}
                                            </p>
                                            <p class="mt-0.5 text-xs text-gray-400">
                                                {{ $donation->alumni->email ?? 'No email' }}
                                            </p>
                                        </div>
                                    </div>
                                </td>

                                <td class="px-6 py-4">
                                    <span class="text-base font-semibold text-gray-900">₱{{ number_format($donation->amount ?? 0, 2) }}</span>
                                </td>

                                <td class="px-6 py-4">
                                    <span class="font-mono text-xs text-gray-500">{{ $donation->reference_number ?: '—' }}</span>
                                </td>

                                <td class="px-6 py-4 text-xs text-gray-400">
                                    {{ $donation->created_at?->format('M d, Y') ?: '—' }}<br>
                                    <span class="text-gray-300">{{ $donation->created_at?->format('h:i A') }}</span>
                                </td>

                                <td class="px-6 py-4">
                                    @if ($donation->status === 'verified')
                                        <span class="inline-flex items-center gap-1.5 rounded-full border border-emerald-200 bg-emerald-50 px-2.5 py-1 text-xs font-semibold text-emerald-700">
                                            <flux:icon name="check-circle" class="h-3.5 w-3.5" />
                                            Verified
                                        </span>
                                    @elseif ($donation->status === 'pending')
                                        <span class="inline-flex items-center gap-1.5 rounded-full border border-amber-200 bg-amber-50 px-2.5 py-1 text-xs font-semibold text-amber-700">
                                            <flux:icon name="clock" class="h-3.5 w-3.5" />
                                            Pending
                                        </span>
                                    @elseif ($donation->status === 'rejected')
                                        <span class="inline-flex items-center gap-1.5 rounded-full border border-rose-200 bg-rose-50 px-2.5 py-1 text-xs font-semibold text-rose-700">
                                            <flux:icon name="x-circle" class="h-3.5 w-3.5" />
                                            Rejected
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 rounded-full border border-gray-200 bg-gray-100 px-2.5 py-1 text-xs font-semibold text-gray-600">
                                            {{ str($donation->status)->headline() }}
                                        </span>
                                    @endif
                                </td>

                                <td class="px-6 py-4">
                                    @if ($donation->or_file_path)
                                        <a
                                            href="{{ Storage::disk('s3')->url($donation->or_file_path) }}"
                                            target="_blank"
                                            class="inline-flex items-center gap-1.5 rounded-lg border border-amber-200 bg-amber-50 px-3 py-1.5 text-xs font-medium text-amber-700 transition hover:bg-amber-100"
                                        >
                                            <flux:icon name="paper-clip" class="h-3.5 w-3.5" />
                                            View Proof
                                        </a>
                                    @else
                                        <span class="text-xs text-gray-300">No file</span>
                                    @endif
                                </td>

                                <td class="px-6 py-4">
                                    <div class="flex justify-end gap-2">
                                        @if ($donation->status === 'pending')
                                            <button
                                                wire:click="verifyDonation({{ $donation->id }})"
                                                class="inline-flex items-center gap-1.5 rounded-lg bg-emerald-600 px-3 py-1.5 text-xs font-semibold text-white transition hover:bg-emerald-500"
                                            >
                                                <flux:icon name="check" class="h-3.5 w-3.5" />
                                                Verify
                                            </button>

                                            <button
                                                wire:click="openRejectModal({{ $donation->id }})"
                                                class="inline-flex items-center gap-1.5 rounded-lg border border-rose-200 bg-rose-50 px-3 py-1.5 text-xs font-semibold text-rose-600 transition hover:bg-rose-100"
                                            >
                                                <flux:icon name="x-mark" class="h-3.5 w-3.5" />
                                                Reject
                                            </button>
                                        @else
                                            <span class="text-right text-xs text-gray-300">
                                                @if ($donation->reviewed_at)
                                                    Reviewed<br>{{ $donation->reviewed_at->format('M d, Y') }}
                                                @else
                                                    —
                                                @endif
                                            </span>
                                        @endif
                                    </div>
                                </td>
                            </tr>

                            @if ($donation->rejection_reason)
                                <tr class="bg-rose-50">
                                    <td colspan="7" class="border-l-4 border-l-rose-400 px-6 py-3">
                                        <p class="text-xs font-semibold uppercase tracking-wide text-rose-500">Rejection Reason</p>
                                        <p class="mt-0.5 text-sm text-rose-700">{{ $donation->rejection_reason }}</p>
                                    </td>
                                </tr>
                            @endif
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-16 text-center">
                                    <flux:icon name="inbox" class="mx-auto h-8 w-8 text-gray-300" />
                                    <p class="mt-2 text-sm text-gray-400">No donation submissions found.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="border-t border-gray-100 px-6 py-4">
                {{ $donations->links() }}
            </div>
        </section>

        {{-- Mobile / Tablet Cards --}}
        <div class="space-y-3 lg:hidden">
            @forelse ($donations as $donation)
                <section class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">
                    <div class="p-5">
                        <div class="flex items-start justify-between gap-3">
                            <div class="flex items-center gap-3">
                                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-amber-100 text-sm font-bold text-amber-700">
                                    {{ strtoupper(substr($donation->alumni->fname ?? '?', 0, 1)) }}
                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-900">
                                        {{ trim(($donation->alumni->fname ?? '') . ' ' . ($donation->alumni->lname ?? '')) ?: 'Unknown Donor' }}
                                    </h3>
                                    <p class="mt-0.5 text-base font-semibold text-gray-700">
                                        ₱{{ number_format($donation->amount ?? 0, 2) }}
                                    </p>
                                </div>
                            </div>

                            @if ($donation->status === 'verified')
                                <span class="inline-flex items-center gap-1.5 rounded-full border border-emerald-200 bg-emerald-50 px-2.5 py-1 text-xs font-semibold text-emerald-700">
                                    <flux:icon name="check-circle" class="h-3.5 w-3.5" />
                                    Verified
                                </span>
                            @elseif ($donation->status === 'pending')
                                <span class="inline-flex items-center gap-1.5 rounded-full border border-amber-200 bg-amber-50 px-2.5 py-1 text-xs font-semibold text-amber-700">
                                    <flux:icon name="clock" class="h-3.5 w-3.5" />
                                    Pending
                                </span>
                            @elseif ($donation->status === 'rejected')
                                <span class="inline-flex items-center gap-1.5 rounded-full border border-rose-200 bg-rose-50 px-2.5 py-1 text-xs font-semibold text-rose-700">
                                    <flux:icon name="x-circle" class="h-3.5 w-3.5" />
                                    Rejected
                                </span>
                            @endif
                        </div>

                        <div class="mt-4 grid gap-2 sm:grid-cols-2">
                            <div class="rounded-xl border border-gray-100 bg-gray-50 p-3">
                                <p class="text-xs text-gray-400">Reference Number</p>
                                <p class="mt-1 font-mono text-sm font-medium text-gray-700">{{ $donation->reference_number ?: '—' }}</p>
                            </div>

                            <div class="rounded-xl border border-gray-100 bg-gray-50 p-3">
                                <p class="text-xs text-gray-400">Submitted At</p>
                                <p class="mt-1 text-sm font-medium text-gray-700">
                                    {{ $donation->created_at?->format('M d, Y h:i A') ?: '—' }}
                                </p>
                            </div>

                            @if ($donation->remarks)
                                <div class="rounded-xl border border-gray-100 bg-gray-50 p-3 sm:col-span-2">
                                    <p class="text-xs text-gray-400">Remarks</p>
                                    <p class="mt-1 text-sm text-gray-700">{{ $donation->remarks }}</p>
                                </div>
                            @endif

                            @if ($donation->rejection_reason)
                                <div class="rounded-xl border-l-4 border-l-rose-400 border border-rose-100 bg-rose-50 p-3 sm:col-span-2">
                                    <p class="text-xs font-semibold uppercase tracking-wide text-rose-500">Rejection Reason</p>
                                    <p class="mt-1 text-sm text-rose-700">{{ $donation->rejection_reason }}</p>
                                </div>
                            @endif
                        </div>

                        <div class="mt-4 flex flex-wrap gap-2">
                            @if ($donation->or_file_path)
                                <a
                                    href="{{ Storage::disk('s3')->url($donation->or_file_path) }}"
                                    target="_blank"
                                    class="inline-flex items-center gap-1.5 rounded-lg border border-amber-200 bg-amber-50 px-3 py-2 text-xs font-medium text-amber-700 transition hover:bg-amber-100"
                                >
                                    <flux:icon name="paper-clip" class="h-3.5 w-3.5" />
                                    View Proof
                                </a>
                            @endif

                            @if ($donation->status === 'pending')
                                <button
                                    wire:click="verifyDonation({{ $donation->id }})"
                                    class="inline-flex items-center gap-1.5 rounded-lg bg-emerald-600 px-3 py-2 text-xs font-semibold text-white transition hover:bg-emerald-500"
                                >
                                    <flux:icon name="check" class="h-3.5 w-3.5" />
                                    Verify
                                </button>

                                <button
                                    wire:click="openRejectModal({{ $donation->id }})"
                                    class="inline-flex items-center gap-1.5 rounded-lg border border-rose-200 bg-rose-50 px-3 py-2 text-xs font-semibold text-rose-600 transition hover:bg-rose-100"
                                >
                                    <flux:icon name="x-mark" class="h-3.5 w-3.5" />
                                    Reject
                                </button>
                            @endif
                        </div>
                    </div>
                </section>
            @empty
                <div class="rounded-2xl border border-gray-200 bg-white px-4 py-16 text-center">
                    <flux:icon name="inbox" class="mx-auto h-8 w-8 text-gray-300" />
                    <p class="mt-2 text-sm text-gray-400">No donation submissions found.</p>
                </div>
            @endforelse

            <div>
                {{ $donations->links() }}
            </div>
        </div>
    </div>
</div>
