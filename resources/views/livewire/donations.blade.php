<div>
    <div class="mx-auto max-w-7xl space-y-6 px-6 py-6">

        {{-- Header --}}
        <section class="border border-white/10 bg-zinc-900/60 backdrop-blur-sm">
            <div class="flex flex-col gap-5 px-5 py-5 lg:flex-row lg:items-end lg:justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.22em] text-teal-400">
                        Admin Panel
                    </p>

                    <h1 class="mt-1 text-2xl font-semibold tracking-tight text-white">
                        Donation Verification
                    </h1>

                    <p class="mt-2 max-w-2xl text-sm text-zinc-400">
                        Review uploaded donation proofs, verify valid submissions, and reject incorrect or unclear records.
                    </p>
                </div>
            </div>
        </section>

        {{-- Flash Messages --}}
        @if (session('success'))
            <div class="border border-emerald-500/20 bg-emerald-500/10 px-4 py-3 text-sm text-emerald-200">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="border border-red-500/20 bg-red-500/10 px-4 py-3 text-sm text-red-200">
                {{ session('error') }}
            </div>
        @endif

        {{-- Filters --}}
        <section class="border border-white/10 bg-zinc-900/60 backdrop-blur-sm">
            <div class="flex flex-col gap-4 px-5 py-5 lg:flex-row lg:items-center lg:justify-between">

                <div class="flex flex-wrap gap-2">
                    <button
                        wire:click="$set('statusFilter', 'all')"
                        class="rounded-lg border px-4 py-2 text-sm font-medium transition
                            {{ $statusFilter === 'all'
                                ? 'border-teal-500/30 bg-teal-500/10 text-teal-300'
                                : 'border-white/10 bg-zinc-900/40 text-zinc-300 hover:bg-zinc-800' }}">
                        All
                    </button>

                    <button
                        wire:click="$set('statusFilter', 'pending')"
                        class="rounded-lg border px-4 py-2 text-sm font-medium transition
                            {{ $statusFilter === 'pending'
                                ? 'border-amber-500/30 bg-amber-500/10 text-amber-300'
                                : 'border-white/10 bg-zinc-900/40 text-zinc-300 hover:bg-zinc-800' }}">
                        Pending
                    </button>

                    <button
                        wire:click="$set('statusFilter', 'verified')"
                        class="rounded-lg border px-4 py-2 text-sm font-medium transition
                            {{ $statusFilter === 'verified'
                                ? 'border-green-500/30 bg-green-500/10 text-green-300'
                                : 'border-white/10 bg-zinc-900/40 text-zinc-300 hover:bg-zinc-800' }}">
                        Verified
                    </button>

                    <button
                        wire:click="$set('statusFilter', 'rejected')"
                        class="rounded-lg border px-4 py-2 text-sm font-medium transition
                            {{ $statusFilter === 'rejected'
                                ? 'border-red-500/30 bg-red-500/10 text-red-300'
                                : 'border-white/10 bg-zinc-900/40 text-zinc-300 hover:bg-zinc-800' }}">
                        Rejected
                    </button>
                </div>

                <div class="w-full lg:w-80">
                    <input
                        type="text"
                        wire:model.live.debounce.300ms="search"
                        placeholder="Search donor name or reference number..."
                        class="w-full border border-white/10 bg-zinc-900/40 px-4 py-2.5 text-sm text-white outline-none transition placeholder:text-zinc-500 focus:border-teal-400"
                    >
                </div>
            </div>
        </section>

        {{-- Desktop Table --}}
        <section class="hidden overflow-hidden border border-white/10 bg-zinc-900/60 backdrop-blur-sm lg:block">
            <div class="border-b border-white/10 px-5 py-4">
                <h2 class="text-lg font-semibold text-white">Donation Records</h2>
                <p class="mt-1 text-sm text-zinc-400">
                    Only verified donations should be counted in reports and totals.
                </p>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="border-b border-white/10 bg-zinc-950/60 text-zinc-400">
                        <tr>
                            <th class="px-4 py-3 font-medium">Donor</th>
                            <th class="px-4 py-3 font-medium">Amount</th>
                            <th class="px-4 py-3 font-medium">Reference</th>
                            <th class="px-4 py-3 font-medium">Submitted</th>
                            <th class="px-4 py-3 font-medium">Status</th>
                            <th class="px-4 py-3 font-medium">Proof</th>
                            <th class="px-4 py-3 font-medium text-right">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($donations as $donation)
                            <tr class="border-t border-white/10 align-top">
                                <td class="px-4 py-4">
                                    <div>
                                        <p class="font-medium text-white">
                                            {{ trim(($donation->alumni->fname ?? '') . ' ' . ($donation->alumni->lname ?? '')) ?: 'Unknown Donor' }}
                                        </p>
                                        <p class="mt-1 text-xs text-zinc-500">
                                            {{ $donation->alumni->email ?? 'No email' }}
                                        </p>
                                    </div>
                                </td>

                                <td class="px-4 py-4 text-zinc-200">
                                   ₱{{ number_format($donation->amount ?? 0, 2) }}
                                </td>

                                <td class="px-4 py-4 text-zinc-400">
                                    {{ $donation->reference_number ?: '—' }}
                                </td>

                                <td class="px-4 py-4 text-zinc-400">
                                    {{ optional($donation->created_at)->format('M d, Y h:i A') ?: '—' }}
                                </td>

                                <td class="px-4 py-4">
                                    @if ($donation->status === 'verified')
                                        <span class="inline-flex items-center gap-2 rounded-full border border-green-400/30 bg-gradient-to-r from-green-500/15 to-emerald-500/10 px-3 py-1 text-xs font-semibold text-green-200">
                                            <flux:icon name="check-circle" class="h-4 w-4" />
                                            Verified
                                        </span>
                                    @elseif ($donation->status === 'pending')
                                        <span class="inline-flex items-center gap-2 rounded-full border border-amber-400/30 bg-amber-500/10 px-3 py-1 text-xs font-semibold text-amber-200">
                                            <flux:icon name="clock" class="h-4 w-4" />
                                            Pending
                                        </span>
                                    @elseif ($donation->status === 'rejected')
                                        <span class="inline-flex items-center gap-2 rounded-full border border-red-400/30 bg-red-500/10 px-3 py-1 text-xs font-semibold text-red-200">
                                            <flux:icon name="x-circle" class="h-4 w-4" />
                                            Rejected
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-2 rounded-full border border-zinc-700 bg-zinc-800 px-3 py-1 text-xs font-semibold text-zinc-300">
                                            {{ str($donation->status)->headline() }}
                                        </span>
                                    @endif
                                </td>

                                <td class="px-4 py-4">
                                    @if ($donation->or_file_path)
                                        <a
                                            href="{{ Storage::disk('s3')->url($donation->or_file_path) }}"
                                            target="_blank"
                                            class="inline-flex items-center gap-2 rounded-lg border border-white/10 bg-zinc-900/40 px-3 py-2 text-xs font-medium text-zinc-200 transition hover:bg-zinc-800"
                                        >
                                            <flux:icon name="paper-clip" class="h-4 w-4" />
                                            View Proof
                                        </a>
                                    @else
                                        <span class="text-zinc-500">No file</span>
                                    @endif
                                </td>

                                <td class="px-4 py-4">
                                    <div class="flex justify-end gap-2">
                                        @if ($donation->status === 'pending')
                                            <button
                                                wire:click="verifyDonation({{ $donation->id }})"
                                                class="inline-flex items-center gap-2 rounded-lg bg-green-500 px-3 py-2 text-xs font-semibold text-zinc-950 transition hover:bg-green-400"
                                            >
                                                <flux:icon name="check" class="h-4 w-4" />
                                                Verify
                                            </button>

                                            <button
                                                wire:click="openRejectModal({{ $donation->id }})"
                                                class="inline-flex items-center gap-2 rounded-lg bg-red-500 px-3 py-2 text-xs font-semibold text-white transition hover:bg-red-400"
                                            >
                                                <flux:icon name="x-mark" class="h-4 w-4" />
                                                Reject
                                            </button>
                                        @else
                                            <div class="text-right text-xs text-zinc-500">
                                                @if ($donation->reviewed_at)
                                                    Reviewed {{ $donation->reviewed_at->format('M d, Y') }}
                                                @else
                                                    —
                                                @endif
                                            </div>
                                        @endif
                                    </div>
                                </td>
                            </tr>

                            @if ($donation->rejection_reason)
                                <tr class="border-t border-white/5 bg-red-500/5">
                                    <td colspan="7" class="px-4 py-3">
                                        <p class="text-xs font-medium uppercase tracking-wide text-red-300">
                                            Rejection Reason
                                        </p>
                                        <p class="mt-1 text-sm text-red-200">
                                            {{ $donation->rejection_reason }}
                                        </p>
                                    </td>
                                </tr>
                            @endif
                        @empty
                            <tr>
                                <td colspan="7" class="px-4 py-10 text-center text-zinc-500">
                                    No donation submissions found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="border-t border-white/10 px-5 py-4">
                {{ $donations->links() }}
            </div>
        </section>

        {{-- Mobile / Tablet Cards --}}
        <div class="space-y-4 lg:hidden">
            @forelse ($donations as $donation)
                <section class="border border-white/10 bg-zinc-900/60 backdrop-blur-sm">
                    <div class="space-y-4 p-5">
                        <div class="flex items-start justify-between gap-3">
                            <div>
                                <h3 class="font-semibold text-white">
                                    {{ trim(($donation->alumni->fname ?? '') . ' ' . ($donation->alumni->lname ?? '')) ?: 'Unknown Donor' }}
                                </h3>
                                <p class="mt-1 text-sm text-zinc-400">
                                    ₱{{ number_format(($donation->amount ?? 0) / 100, 2) }}
                                </p>
                            </div>

                            @if ($donation->status === 'verified')
                                <span class="inline-flex items-center gap-2 rounded-full border border-green-400/30 bg-gradient-to-r from-green-500/15 to-emerald-500/10 px-3 py-1 text-xs font-semibold text-green-200">
                                    <flux:icon name="check-circle" class="h-4 w-4" />
                                    Verified
                                </span>
                            @elseif ($donation->status === 'pending')
                                <span class="inline-flex items-center gap-2 rounded-full border border-amber-400/30 bg-amber-500/10 px-3 py-1 text-xs font-semibold text-amber-200">
                                    <flux:icon name="clock" class="h-4 w-4" />
                                    Pending
                                </span>
                            @elseif ($donation->status === 'rejected')
                                <span class="inline-flex items-center gap-2 rounded-full border border-red-400/30 bg-red-500/10 px-3 py-1 text-xs font-semibold text-red-200">
                                    <flux:icon name="x-circle" class="h-4 w-4" />
                                    Rejected
                                </span>
                            @endif
                        </div>

                        <div class="grid gap-3 sm:grid-cols-2">
                            <div class="border border-white/10 bg-zinc-900/40 p-3">
                                <p class="text-xs text-zinc-500">Reference Number</p>
                                <p class="mt-1 text-sm text-white">{{ $donation->reference_number ?: '—' }}</p>
                            </div>

                            <div class="border border-white/10 bg-zinc-900/40 p-3">
                                <p class="text-xs text-zinc-500">Submitted At</p>
                                <p class="mt-1 text-sm text-white">
                                    {{ optional($donation->created_at)->format('M d, Y h:i A') ?: '—' }}
                                </p>
                            </div>

                            @if ($donation->remarks)
                                <div class="border border-white/10 bg-zinc-900/40 p-3 sm:col-span-2">
                                    <p class="text-xs text-zinc-500">Remarks</p>
                                    <p class="mt-1 text-sm text-white">{{ $donation->remarks }}</p>
                                </div>
                            @endif

                            @if ($donation->rejection_reason)
                                <div class="border border-red-500/20 bg-red-500/10 p-3 sm:col-span-2">
                                    <p class="text-xs text-red-300">Rejection Reason</p>
                                    <p class="mt-1 text-sm text-red-200">{{ $donation->rejection_reason }}</p>
                                </div>
                            @endif
                        </div>

                        <div class="flex flex-wrap gap-2">
                            @if ($donation->or_file_path)
                                <a
                                    href="{{ Storage::disk('s3')->url($donation->or_file_path) }}"
                                    target="_blank"
                                    class="inline-flex items-center gap-2 rounded-lg border border-white/10 bg-zinc-900/40 px-3 py-2 text-xs font-medium text-zinc-200 transition hover:bg-zinc-800"
                                >
                                    <flux:icon name="paper-clip" class="h-4 w-4" />
                                    View Proof
                                </a>
                            @endif

                            @if ($donation->status === 'pending')
                                <button
                                    wire:click="verifyDonation({{ $donation->id }})"
                                    class="inline-flex items-center gap-2 rounded-lg bg-green-500 px-3 py-2 text-xs font-semibold text-zinc-950 transition hover:bg-green-400"
                                >
                                    <flux:icon name="check" class="h-4 w-4" />
                                    Verify
                                </button>

                                <button
                                    wire:click="openRejectModal({{ $donation->id }})"
                                    class="inline-flex items-center gap-2 rounded-lg bg-red-500 px-3 py-2 text-xs font-semibold text-white transition hover:bg-red-400"
                                >
                                    <flux:icon name="x-mark" class="h-4 w-4" />
                                    Reject
                                </button>
                            @endif
                        </div>
                    </div>
                </section>
            @empty
                <div class="border border-white/10 bg-zinc-900/60 px-4 py-10 text-center text-zinc-500">
                    No donation submissions found.
                </div>
            @endforelse

            <div>
                {{ $donations->links() }}
            </div>
        </div>
    </div>
</div>