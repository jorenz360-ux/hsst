<div>
    <div class="mx-auto max-w-6xl space-y-6 px-6 py-6">

        {{-- Header --}}
        <section class="border border-white/10 bg-zinc-900/60 backdrop-blur-sm">
            <div class="flex flex-col gap-5 px-5 py-5 lg:flex-row lg:items-end lg:justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.22em] text-teal-400">
                        Alumni Donation
                    </p>

                    <h1 class="mt-1 text-2xl font-semibold tracking-tight text-white">
                        Support the Alumni Association
                    </h1>

                    <p class="mt-2 max-w-2xl text-sm text-zinc-400">
                        You may donate multiple times. After sending your donation through the official payment channel, upload your proof for verification.
                    </p>
                </div>

                <div class="flex flex-wrap gap-2">
                    <span class="inline-flex items-center gap-2 rounded-full border border-white/10 bg-zinc-900/40 px-3.5 py-1.5 text-xs font-semibold text-zinc-300">
                        <flux:icon name="banknotes" class="h-4 w-4" />
                        Manual Donation Flow
                    </span>
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

        <div class="grid gap-6 xl:grid-cols-[1.15fr_0.85fr]">

            {{-- Donation Form --}}
            <section class="border border-white/10 bg-zinc-900/60 backdrop-blur-sm">
                <div class="border-b border-white/10 px-5 py-4">
                    <h2 class="text-lg font-semibold text-white">Submit a New Donation</h2>
                    <p class="mt-1 text-sm text-zinc-400">
                        Fill in the donation details and upload a clear receipt or screenshot.
                    </p>
                </div>

                <div class="p-5">
                    <form wire:submit.prevent="submitDonation" class="space-y-5">

                        {{-- Amount --}}
                        <div>
                            <label class="mb-1 block text-sm font-medium text-zinc-300">
                                Donation Amount
                            </label>

                            <div class="grid grid-cols-2 gap-2 sm:grid-cols-4">
                                @foreach ([100, 300, 500, 1000] as $preset)
                                    <button
                                        type="button"
                                        wire:click="$set('amount', {{ $preset }})"
                                        class="rounded-lg border border-white/10 bg-zinc-900/40 px-3 py-2 text-sm text-zinc-200 transition hover:bg-zinc-800"
                                    >
                                        ₱{{ number_format($preset, 2) }}
                                    </button>
                                @endforeach
                            </div>

                            <input
                                type="number"
                                wire:model.defer="amount"
                                min="1"
                                step="1"
                                placeholder="Enter donation amount in pesos"
                                class="mt-3 w-full border border-white/10 bg-zinc-900/40 px-4 py-2.5 text-sm text-white outline-none transition placeholder:text-zinc-500 focus:border-teal-400"
                            >

                            @error('amount')
                                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Reference Number --}}
                        <div>
                            <label class="mb-1 block text-sm font-medium text-zinc-300">
                                Reference Number <span class="text-zinc-500">(optional)</span>
                            </label>
                            <input
                                type="text"
                                wire:model.defer="reference_number"
                                placeholder="e.g. GCash or bank transfer reference"
                                class="w-full border border-white/10 bg-zinc-900/40 px-4 py-2.5 text-sm text-white outline-none transition placeholder:text-zinc-500 focus:border-teal-400"
                            >
                            @error('reference_number')
                                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Remarks --}}
                        <div>
                            <label class="mb-1 block text-sm font-medium text-zinc-300">
                                Remarks <span class="text-zinc-500">(optional)</span>
                            </label>
                            <textarea
                                wire:model.defer="remarks"
                                rows="4"
                                placeholder="Add a short message or note..."
                                class="w-full border border-white/10 bg-zinc-900/40 px-4 py-2.5 text-sm text-white outline-none transition placeholder:text-zinc-500 focus:border-teal-400"
                            ></textarea>
                            @error('remarks')
                                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Proof Upload --}}
                        <div>
                            <label class="mb-1 block text-sm font-medium text-zinc-300">
                                Official Receipt / Proof of Donation
                            </label>
                            <input
                                type="file"
                                wire:model="proof"
                                accept=".jpg,.jpeg,.png,.pdf"
                                class="block w-full border border-white/10 bg-zinc-900/40 px-4 py-3 text-sm text-white file:mr-4 file:rounded-lg file:border-0 file:bg-teal-500 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-zinc-950 hover:file:bg-teal-400"
                            >
                            <p class="mt-2 text-xs text-zinc-500">
                                Accepted formats: JPG, JPEG, PNG, PDF. Maximum size: 5MB.
                            </p>

                            <div wire:loading wire:target="proof" class="mt-2 text-sm text-teal-400">
                                Uploading file...
                            </div>

                            @error('proof')
                                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        @if ($proof)
                            <div class="border border-teal-500/20 bg-teal-500/10 p-4 text-sm text-teal-200">
                                File selected successfully and ready for submission.
                            </div>
                        @endif

                        <div class="flex justify-end border-t border-white/10 pt-5">
                            <button
                                type="submit"
                                class="inline-flex items-center gap-2 rounded-lg bg-teal-500 px-5 py-2.5 text-sm font-semibold text-zinc-950 transition hover:bg-teal-400 cursor-pointer"
                            >
                                <flux:icon name="arrow-up-tray" class="h-4 w-4" />
                                Submit Donation Proof
                            </button>
                        </div>
                    </form>
                </div>
            </section>

            <div class="space-y-6">

                {{-- Donation Summary --}}
                <section class="border border-white/10 bg-zinc-900/60 backdrop-blur-sm">
                    <div class="border-b border-white/10 px-5 py-4">
                        <h2 class="text-lg font-semibold text-white">Donation Summary</h2>
                    </div>

                    <div class="grid gap-3 p-5 text-sm">
                        <div class="border border-white/10 bg-zinc-900/40 p-4">
                            <p class="text-zinc-400">Donor</p>
                            <p class="mt-1 font-medium text-white">
                                {{ auth()->user()->username ?? 'Authenticated User' }}
                            </p>
                        </div>

                        <div class="border border-white/10 bg-zinc-900/40 p-4">
                            <p class="text-zinc-400">Current Entry</p>
                            <p class="mt-1 text-lg font-semibold text-white">
                                ₱{{ number_format((int) ($amount ?? 0), 2) }}
                            </p>
                        </div>

                        <div class="border border-white/10 bg-zinc-900/40 p-4">
                            <p class="text-zinc-400">Total Verified Donations</p>
                            <p class="mt-1 text-lg font-semibold text-white">
                                ₱{{ number_format(($verifiedTotal ?? 0) / 100, 2) }}
                            </p>
                        </div>

                        <div class="border border-white/10 bg-zinc-900/40 p-4">
                            <p class="text-zinc-400">Pending Donations</p>
                            <p class="mt-1 text-lg font-semibold text-white">
                                {{ $pendingCount ?? 0 }}
                            </p>
                        </div>
                    </div>
                </section>

                {{-- Payment Instructions --}}
                <section class="border border-white/10 bg-zinc-900/60 backdrop-blur-sm">
                    <div class="border-b border-white/10 px-5 py-4">
                        <h2 class="text-lg font-semibold text-white">Payment Instructions</h2>
                    </div>

                    <div class="space-y-3 p-5 text-sm">
                        <div class="border border-white/10 bg-zinc-900/40 p-4 text-zinc-200">
                            <p class="text-zinc-500">GCash</p>
                            <p class="mt-1 font-medium">09XX-XXX-XXXX</p>
                        </div>

                        <div class="border border-white/10 bg-zinc-900/40 p-4 text-zinc-200">
                            <p class="text-zinc-500">Account Name</p>
                            <p class="mt-1 font-medium">Holy Spirit School Alumni Association</p>
                        </div>

                        <div class="border border-white/10 bg-zinc-900/40 p-4 text-zinc-200">
                            <p class="text-zinc-500">Reminder</p>
                            <p class="mt-1">
                                Use the exact amount you entered and upload a clear, readable proof of payment.
                            </p>
                        </div>
                    </div>
                </section>
            </div>
        </div>

        {{-- Donation History --}}
        <section class="border border-white/10 bg-zinc-900/60 backdrop-blur-sm">
            <div class="flex flex-col gap-4 border-b border-white/10 px-5 py-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h2 class="text-lg font-semibold text-white">Donation History</h2>
                    <p class="mt-1 text-sm text-zinc-400">
                        Your submitted donations and their verification status.
                    </p>
                </div>
            </div>

            {{-- Desktop Table --}}
            <div class="hidden overflow-x-auto lg:block">
                <table class="w-full text-left text-sm">
                    <thead class="border-b border-white/10 bg-zinc-950/50 text-zinc-400">
                        <tr>
                            <th class="px-4 py-3 font-medium">Amount</th>
                            <th class="px-4 py-3 font-medium">Reference</th>
                            <th class="px-4 py-3 font-medium">Submitted</th>
                            <th class="px-4 py-3 font-medium">Verified</th>
                            <th class="px-4 py-3 font-medium">Status</th>
                            <th class="px-4 py-3 font-medium">Proof</th>
                            <th class="px-4 py-3 font-medium">Remarks</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($donations as $donation)
                            <tr class="border-t border-white/10">
                                <td class="px-4 py-4 text-white">
                                    ₱{{ number_format($donation->amount ?? 0, 2) }}
                                </td>

                                <td class="px-4 py-4 text-zinc-400">
                                    {{ $donation->reference_number ?: '—' }}
                                </td>

                                <td class="px-4 py-4 text-zinc-400">
                                    {{ optional($donation->created_at)->format('M d, Y h:i A') ?: '—' }}
                                </td>

                                <td class="px-4 py-4 text-zinc-400">
                                    {{ optional($donation->paid_at)->format('M d, Y h:i A') ?: '—' }}
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

                                <td class="px-4 py-4 text-zinc-400">
                                    {{ $donation->remarks ?: '—' }}
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
                                    No donations submitted yet.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Mobile Cards --}}
            <div class="space-y-4 p-5 lg:hidden">
                @forelse ($donations as $donation)
                    <div class="border border-white/10 bg-zinc-900/40 p-4">
                        <div class="flex items-start justify-between gap-3">
                            <div>
                                <p class="text-lg font-semibold text-white">
                                   ₱{{ number_format($donation->amount ?? 0, 2) }}
                                </p>
                                <p class="mt-1 text-xs text-zinc-500">
                                    {{ optional($donation->created_at)->format('M d, Y h:i A') ?: '—' }}
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

                        <div class="mt-4 grid gap-3 sm:grid-cols-2">
                            <div class="border border-white/10 bg-zinc-900/30 p-3">
                                <p class="text-xs text-zinc-500">Reference Number</p>
                                <p class="mt-1 text-sm text-white">{{ $donation->reference_number ?: '—' }}</p>
                            </div>

                            <div class="border border-white/10 bg-zinc-900/30 p-3">
                                <p class="text-xs text-zinc-500">Verified At</p>
                                <p class="mt-1 text-sm text-white">
                                    {{ optional($donation->paid_at)->format('M d, Y h:i A') ?: '—' }}
                                </p>
                            </div>

                            @if ($donation->remarks)
                                <div class="border border-white/10 bg-zinc-900/30 p-3 sm:col-span-2">
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

                        @if ($donation->or_file_path)
                            <div class="mt-4">
                                <a
                                    href="{{ Storage::disk('s3')->url($donation->or_file_path) }}"
                                    target="_blank"
                                    class="inline-flex items-center gap-2 rounded-lg border border-white/10 bg-zinc-900/40 px-3 py-2 text-xs font-medium text-zinc-200 transition hover:bg-zinc-800"
                                >
                                    <flux:icon name="paper-clip" class="h-4 w-4" />
                                    View Proof
                                </a>
                            </div>
                        @endif
                    </div>
                @empty
                    <div class="text-center text-zinc-500">
                        No donations submitted yet.
                    </div>
                @endforelse
            </div>
        </section>
    </div>
</div>