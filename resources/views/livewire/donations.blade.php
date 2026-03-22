<div class="min-h-screen bg-zinc-950 text-zinc-100 rounded-2xl">
    <div class="mx-auto max-w-7xl space-y-6 px-6 py-6">

        {{-- Header --}}
        <section class="rounded-2xl border border-white/10 bg-zinc-900/70 shadow-sm">
            <div class="flex flex-col gap-5 px-5 py-5 lg:flex-row lg:items-end lg:justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.22em] text-amber-400">
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
            <div class="rounded-2xl border border-emerald-500/20 bg-emerald-500/10 px-4 py-3 text-sm text-emerald-200">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="rounded-2xl border border-rose-500/20 bg-rose-500/10 px-4 py-3 text-sm text-rose-200">
                {{ session('error') }}
            </div>
        @endif

        {{-- Filters --}}
        <section class="rounded-2xl border border-white/10 bg-zinc-900/70 shadow-sm">
            <div class="flex flex-col gap-4 px-5 py-5 lg:flex-row lg:items-center lg:justify-between">

                <div class="flex flex-wrap gap-2">
                    <button
                        wire:click="$set('statusFilter', 'all')"
                        class="rounded-xl border px-4 py-2 text-sm font-medium transition
                            {{ $statusFilter === 'all'
                                ? 'border-amber-500/30 bg-amber-500/10 text-amber-300'
                                : 'border-white/10 bg-zinc-950 text-zinc-300 hover:bg-zinc-800' }}">
                        All
                    </button>

                    <button
                        wire:click="$set('statusFilter', 'pending')"
                        class="rounded-xl border px-4 py-2 text-sm font-medium transition
                            {{ $statusFilter === 'pending'
                                ? 'border-amber-500/30 bg-amber-500/10 text-amber-300'
                                : 'border-white/10 bg-zinc-950 text-zinc-300 hover:bg-zinc-800' }}">
                        Pending
                    </button>

                    <button
                        wire:click="$set('statusFilter', 'verified')"
                        class="rounded-xl border px-4 py-2 text-sm font-medium transition
                            {{ $statusFilter === 'verified'
                                ? 'border-emerald-500/30 bg-emerald-500/10 text-emerald-300'
                                : 'border-white/10 bg-zinc-950 text-zinc-300 hover:bg-zinc-800' }}">
                        Verified
                    </button>

                    <button
                        wire:click="$set('statusFilter', 'rejected')"
                        class="rounded-xl border px-4 py-2 text-sm font-medium transition
                            {{ $statusFilter === 'rejected'
                                ? 'border-rose-500/30 bg-rose-500/10 text-rose-300'
                                : 'border-white/10 bg-zinc-950 text-zinc-300 hover:bg-zinc-800' }}">
                        Rejected
                    </button>
                </div>

                <div class="w-full lg:w-80">
                    <input
                        type="text"
                        wire:model.live.debounce.300ms="search"
                        placeholder="Search donor name or reference number..."
                        class="w-full rounded-xl border border-white/10 bg-zinc-950 px-4 py-2.5 text-sm text-white outline-none transition placeholder:text-zinc-500 focus:border-amber-400 focus:ring-2 focus:ring-amber-500/20"
                    >
                </div>
            </div>
        </section>

        {{-- Desktop Table --}}
        <section class="hidden overflow-hidden rounded-2xl border border-white/10 bg-zinc-900/70 shadow-sm lg:block">
            <div class="border-b border-white/10 px-5 py-4">
                <h2 class="text-lg font-semibold text-white">Donation Records</h2>
                <p class="mt-1 text-sm text-zinc-400">
                    Only verified donations should be counted in reports and totals.
                </p>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="border-b border-white/10 bg-zinc-950/80 text-zinc-400">
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

                    <tbody class="divide-y divide-white/10">
                        @forelse ($donations as $donation)
                            <tr class="align-top transition hover:bg-amber-500/[0.04]">
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
                                        <span class="inline-flex items-center gap-2 rounded-full border border-emerald-400/30 bg-emerald-500/10 px-3 py-1 text-xs font-semibold text-emerald-200">
                                            <flux:icon name="check-circle" class="h-4 w-4" />
                                            Verified
                                        </span>
                                    @elseif ($donation->status === 'pending')
                                        <span class="inline-flex items-center gap-2 rounded-full border border-amber-400/30 bg-amber-500/10 px-3 py-1 text-xs font-semibold text-amber-200">
                                            <flux:icon name="clock" class="h-4 w-4" />
                                            Pending
                                        </span>
                                    @elseif ($donation->status === 'rejected')
                                        <span class="inline-flex items-center gap-2 rounded-full border border-rose-400/30 bg-rose-500/10 px-3 py-1 text-xs font-semibold text-rose-200">
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
                                            class="inline-flex items-center gap-2 rounded-lg border border-amber-500/20 bg-amber-500/10 px-3 py-2 text-xs font-medium text-amber-300 transition hover:bg-amber-500/20"
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
                                                class="inline-flex items-center gap-2 rounded-lg bg-emerald-500 px-3 py-2 text-xs font-semibold text-zinc-950 transition hover:bg-emerald-400"
                                            >
                                                <flux:icon name="check" class="h-4 w-4" />
                                                Verify
                                            </button>

                                            <button
                                                wire:click="openRejectModal({{ $donation->id }})"
                                                class="inline-flex items-center gap-2 rounded-lg bg-rose-500 px-3 py-2 text-xs font-semibold text-white transition hover:bg-rose-400"
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
                                <tr class="bg-rose-500/5">
                                    <td colspan="7" class="px-4 py-3">
                                        <p class="text-xs font-medium uppercase tracking-wide text-rose-300">
                                            Rejection Reason
                                        </p>
                                        <p class="mt-1 text-sm text-rose-200">
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
                <section class="rounded-2xl border border-white/10 bg-zinc-900/70 shadow-sm">
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
                                <span class="inline-flex items-center gap-2 rounded-full border border-emerald-400/30 bg-emerald-500/10 px-3 py-1 text-xs font-semibold text-emerald-200">
                                    <flux:icon name="check-circle" class="h-4 w-4" />
                                    Verified
                                </span>
                            @elseif ($donation->status === 'pending')
                                <span class="inline-flex items-center gap-2 rounded-full border border-amber-400/30 bg-amber-500/10 px-3 py-1 text-xs font-semibold text-amber-200">
                                    <flux:icon name="clock" class="h-4 w-4" />
                                    Pending
                                </span>
                            @elseif ($donation->status === 'rejected')
                                <span class="inline-flex items-center gap-2 rounded-full border border-rose-400/30 bg-rose-500/10 px-3 py-1 text-xs font-semibold text-rose-200">
                                    <flux:icon name="x-circle" class="h-4 w-4" />
                                    Rejected
                                </span>
                            @endif
                        </div>

                        <div class="grid gap-3 sm:grid-cols-2">
                            <div class="rounded-xl border border-white/10 bg-zinc-950 p-3">
                                <p class="text-xs text-zinc-500">Reference Number</p>
                                <p class="mt-1 text-sm text-white">{{ $donation->reference_number ?: '—' }}</p>
                            </div>

                            <div class="rounded-xl border border-white/10 bg-zinc-950 p-3">
                                <p class="text-xs text-zinc-500">Submitted At</p>
                                <p class="mt-1 text-sm text-white">
                                    {{ optional($donation->created_at)->format('M d, Y h:i A') ?: '—' }}
                                </p>
                            </div>

                            @if ($donation->remarks)
                                <div class="rounded-xl border border-white/10 bg-zinc-950 p-3 sm:col-span-2">
                                    <p class="text-xs text-zinc-500">Remarks</p>
                                    <p class="mt-1 text-sm text-white">{{ $donation->remarks }}</p>
                                </div>
                            @endif

                            @if ($donation->rejection_reason)
                                <div class="rounded-xl border border-rose-500/20 bg-rose-500/10 p-3 sm:col-span-2">
                                    <p class="text-xs text-rose-300">Rejection Reason</p>
                                    <p class="mt-1 text-sm text-rose-200">{{ $donation->rejection_reason }}</p>
                                </div>
                            @endif
                        </div>

                        <div class="flex flex-wrap gap-2">
                            @if ($donation->or_file_path)
                                <a
                                    href="{{ Storage::disk('s3')->url($donation->or_file_path) }}"
                                    target="_blank"
                                    class="inline-flex items-center gap-2 rounded-lg border border-amber-500/20 bg-amber-500/10 px-3 py-2 text-xs font-medium text-amber-300 transition hover:bg-amber-500/20"
                                >
                                    <flux:icon name="paper-clip" class="h-4 w-4" />
                                    View Proof
                                </a>
                            @endif

                            @if ($donation->status === 'pending')
                                <button
                                    wire:click="verifyDonation({{ $donation->id }})"
                                    class="inline-flex items-center gap-2 rounded-lg bg-emerald-500 px-3 py-2 text-xs font-semibold text-zinc-950 transition hover:bg-emerald-400"
                                >
                                    <flux:icon name="check" class="h-4 w-4" />
                                    Verify
                                </button>

                                <button
                                    wire:click="openRejectModal({{ $donation->id }})"
                                    class="inline-flex items-center gap-2 rounded-lg bg-rose-500 px-3 py-2 text-xs font-semibold text-white transition hover:bg-rose-400"
                                >
                                    <flux:icon name="x-mark" class="h-4 w-4" />
                                    Reject
                                </button>
                            @endif
                        </div>
                    </div>
                </section>
            @empty
                <div class="rounded-2xl border border-white/10 bg-zinc-900/70 px-4 py-10 text-center text-zinc-500">
                    No donation submissions found.
                </div>
            @endforelse

            <div>
                {{ $donations->links() }}
            </div>
        </div>
    </div>
</div>