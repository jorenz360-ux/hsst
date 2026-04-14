<div class="min-h-screen bg-[#f7f5f1]">
    <div class="mx-auto max-w-6xl px-4 py-8 sm:px-6 lg:px-8">

        {{-- ===== HEADER ===== --}}
        <div class="mb-7 flex flex-col gap-5 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="text-[10px] font-semibold uppercase tracking-[.2em] text-[#b88a3d]">Alumni Association</p>
                <h1 class="mt-1 font-serif text-[28px] font-normal leading-tight text-[#091852] sm:text-[34px]">
                    Support the <span class="italic">Alumni Association</span>
                </h1>
                <p class="mt-1.5 max-w-xl text-sm leading-6 text-[#7a7060]">
                    You may donate multiple times. After sending your donation through the official payment channel,
                    upload your proof for verification.
                </p>
            </div>

            <span class="inline-flex w-fit items-center gap-2 rounded-full border border-[#e0dbd0] bg-white px-3.5 py-1.5 text-[11px] font-semibold text-[#7a7060]">
                <svg class="h-3.5 w-3.5 text-[#b88a3d]" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.6">
                    <path d="M2 10h16M6 6l-4 4 4 4M14 6l4 4-4 4"/>
                </svg>
                Manual Donation Flow
            </span>
        </div>

        {{-- Flash Messages --}}
        @if (session('success'))
            <div class="mb-5 flex items-center gap-3 rounded-[14px] border border-emerald-200 bg-emerald-50 px-4 py-3.5">
                <span class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-emerald-100">
                    <svg class="h-3.5 w-3.5 text-emerald-700" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="2"><polyline points="4,10 8,14 16,6"/></svg>
                </span>
                <p class="text-sm text-emerald-800">{{ session('success') }}</p>
            </div>
        @endif

        @if (session('error'))
            <div class="mb-5 flex items-center gap-3 rounded-[14px] border border-rose-200 bg-rose-50 px-4 py-3.5">
                <span class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-rose-100">
                    <svg class="h-3.5 w-3.5 text-rose-700" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="2"><path d="M10 6v5M10 14h.01"/></svg>
                </span>
                <p class="text-sm text-rose-800">{{ session('error') }}</p>
            </div>
        @endif

        <div class="grid gap-5 xl:grid-cols-[1.2fr_0.8fr]">

            {{-- ===== DONATION FORM ===== --}}
            <div class="overflow-hidden rounded-[20px] border border-[#e8e2d6] bg-white">

                <div class="border-b border-[#f0ebe1] px-5 py-4 sm:px-6">
                    <div class="flex items-center gap-3.5">
                        <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-[10px] bg-[#faf4e6]">
                            <svg class="h-4.5 w-4.5 text-[#b88a3d]" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.6">
                                <path d="M2 8h16v9a1 1 0 01-1 1H3a1 1 0 01-1-1V8zM2 8V6a2 2 0 012-2h12a2 2 0 012 2v2"/>
                                <path d="M10 4v16"/>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-[15px] font-medium text-[#1a1410]">Submit a New Donation</h2>
                            <p class="mt-0.5 text-xs text-[#9a9080]">Fill in the donation details and upload a clear receipt or screenshot.</p>
                        </div>
                    </div>
                </div>

                <div class="px-5 py-5 sm:px-6">
                    <form wire:submit.prevent="submitDonation" class="space-y-5">

                        {{-- Amount Presets --}}
                        <div>
                            <label class="mb-1.5 block text-[11px] font-semibold uppercase tracking-[.06em] text-[#9a9080]">Donation Amount</label>

                            <div class="mb-3 grid grid-cols-2 gap-2 sm:grid-cols-4">
                                @foreach ([100, 300, 500, 1000] as $preset)
                                    <button
                                        type="button"
                                        wire:click="$set('amount', {{ $preset }})"
                                        class="rounded-[10px] border border-[#e0dbd0] bg-[#faf9f7] px-3 py-2.5 text-sm font-medium text-[#1a1410] transition hover:border-[#d4b06a] hover:bg-[#faf4e6]"
                                    >
                                        ₱{{ number_format($preset) }}
                                    </button>
                                @endforeach
                            </div>

                            <input
                                type="number"
                                wire:model.defer="amount"
                                min="1"
                                step="1"
                                placeholder="Or enter a custom amount in pesos"
                                class="w-full rounded-[10px] border border-[#e0dbd0] bg-[#faf9f7] px-3.5 py-2.5 text-sm text-[#1a1410] outline-none transition placeholder:text-[#c0bbb0] focus:border-[#d4b06a] focus:bg-white"
                            >
                            @error('amount')
                                <p class="mt-1.5 text-xs text-rose-500">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Reference Number --}}
                        <div>
                            <label class="mb-1.5 block text-[11px] font-semibold uppercase tracking-[.06em] text-[#9a9080]">
                                Reference Number
                                <span class="ml-1 normal-case tracking-normal text-[#b0ab9e]">(optional)</span>
                            </label>
                            <input
                                type="text"
                                wire:model.defer="reference_number"
                                placeholder="e.g. GCash or bank transfer reference"
                                class="w-full rounded-[10px] border border-[#e0dbd0] bg-[#faf9f7] px-3.5 py-2.5 text-sm text-[#1a1410] outline-none transition placeholder:text-[#c0bbb0] focus:border-[#d4b06a] focus:bg-white"
                            >
                            @error('reference_number')
                                <p class="mt-1.5 text-xs text-rose-500">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Remarks --}}
                        <div>
                            <label class="mb-1.5 block text-[11px] font-semibold uppercase tracking-[.06em] text-[#9a9080]">
                                Remarks
                                <span class="ml-1 normal-case tracking-normal text-[#b0ab9e]">(optional)</span>
                            </label>
                            <textarea
                                wire:model.defer="remarks"
                                rows="3"
                                placeholder="Add a short message or note..."
                                class="w-full resize-none rounded-[10px] border border-[#e0dbd0] bg-[#faf9f7] px-3.5 py-2.5 text-sm text-[#1a1410] outline-none transition placeholder:text-[#c0bbb0] focus:border-[#d4b06a] focus:bg-white"
                            ></textarea>
                            @error('remarks')
                                <p class="mt-1.5 text-xs text-rose-500">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Proof Upload --}}
                        <div>
                            <label class="mb-1.5 block text-[11px] font-semibold uppercase tracking-[.06em] text-[#9a9080]">
                                Official Receipt / Proof of Donation
                            </label>

                            <label class="flex cursor-pointer flex-col items-center justify-center gap-2 rounded-[14px] border border-dashed border-[#d4b06a]/50 bg-[#faf4e6]/40 px-5 py-6 text-center transition hover:border-[#d4b06a] hover:bg-[#faf4e6]">
                                <div class="flex h-10 w-10 items-center justify-center rounded-full bg-[#faf4e6] border border-[#e8d9b0]">
                                    <svg class="h-5 w-5 text-[#b88a3d]" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5">
                                        <path d="M10 14V4M6 8l4-4 4 4"/><path d="M4 16h12"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-[#1a1410]">Click to upload proof</p>
                                    <p class="mt-0.5 text-xs text-[#9a9080]">JPG, JPEG, PNG, PDF - max 5MB</p>
                                </div>
                                <input
                                    type="file"
                                    wire:model="proof"
                                    accept=".jpg,.jpeg,.png,.pdf"
                                    class="sr-only"
                                >
                            </label>

                            <div wire:loading wire:target="proof" class="mt-2 flex items-center gap-2 text-xs text-[#b88a3d]">
                                <svg class="h-3.5 w-3.5 animate-spin" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2v4M12 18v4M4.93 4.93l2.83 2.83M16.24 16.24l2.83 2.83M2 12h4M18 12h4"/></svg>
                                Uploading file...
                            </div>

                            @error('proof')
                                <p class="mt-1.5 text-xs text-rose-500">{{ $message }}</p>
                            @enderror

                            @if ($proof)
                                <div class="mt-2.5 flex items-center gap-2 rounded-[10px] border border-emerald-200 bg-emerald-50 px-3.5 py-2.5">
                                    <svg class="h-4 w-4 shrink-0 text-emerald-600" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.8"><polyline points="4,10 8,14 16,6"/></svg>
                                    <p class="text-xs font-medium text-emerald-800">File selected and ready for submission.</p>
                                </div>
                            @endif
                        </div>

                        <div class="flex justify-end border-t border-[#f0ebe1] pt-4">
                            <button
                                type="submit"
                                class="inline-flex items-center gap-2 rounded-[10px] bg-[#d4b06a] px-5 py-2.5 text-sm font-medium text-[#091852] transition hover:bg-[#c9a458] active:scale-[.98]"
                            >
                                <svg class="h-4 w-4" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.8">
                                    <path d="M10 14V4M6 8l4-4 4 4"/><path d="M4 16h12"/>
                                </svg>
                                Submit Donation Proof
                            </button>
                        </div>

                    </form>
                </div>
            </div>

            {{-- ===== RIGHT COLUMN ===== --}}
            <div class="space-y-5">

                {{-- Donation Summary --}}
                <div class="overflow-hidden rounded-[20px] border border-[#e8e2d6] bg-white">
                    <div class="flex items-center gap-3.5 border-b border-[#f0ebe1] px-5 py-4 sm:px-6">
                        <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-[10px] bg-[#faf4e6]">
                            <svg class="h-4.5 w-4.5 text-[#b88a3d]" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.6">
                                <rect x="3" y="3" width="14" height="14" rx="2"/><path d="M7 10h6M7 13h4"/>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-[15px] font-medium text-[#1a1410]">Donation Summary</h2>
                            <p class="mt-0.5 text-xs text-[#9a9080]">Your alumni account contribution at a glance.</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 divide-x divide-y divide-[#f0ebe1]">
                        <div class="px-5 py-4">
                            <p class="text-[10px] font-semibold uppercase tracking-[.1em] text-[#9a9080]">Donor</p>
                            <p class="mt-1.5 text-[13px] font-medium text-[#1a1410] leading-5">
                                {{ auth()->user()->username ?? 'Authenticated User' }}
                            </p>
                        </div>
                        <div class="px-5 py-4">
                            <p class="text-[10px] font-semibold uppercase tracking-[.1em] text-[#9a9080]">Current Entry</p>
                            <p class="mt-1.5 text-[18px] font-medium text-[#091852]">
                                ₱{{ number_format((int) ($amount ?? 0), 2) }}
                            </p>
                        </div>
                        <div class="px-5 py-4">
                            <p class="text-[10px] font-semibold uppercase tracking-[.1em] text-[#9a9080]">Total Verified</p>
                            <p class="mt-1.5 text-[18px] font-medium text-[#091852]">
                                ₱{{ number_format(($verifiedTotal ?? 0) / 100, 2) }}
                            </p>
                        </div>
                        <div class="px-5 py-4">
                            <p class="text-[10px] font-semibold uppercase tracking-[.1em] text-[#9a9080]">Pending</p>
                            <p class="mt-1.5 text-[18px] font-medium text-[#b88a3d]">
                                {{ $pendingCount ?? 0 }}
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Payment Instructions --}}
                <div class="overflow-hidden rounded-[20px] border border-[#e8e2d6] bg-white">
                    <div class="flex items-center gap-3.5 border-b border-[#f0ebe1] px-5 py-4 sm:px-6">
                        <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-[10px] bg-[#faf4e6]">
                            <svg class="h-4.5 w-4.5 text-[#b88a3d]" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.6">
                                <rect x="2" y="5" width="16" height="11" rx="2"/><path d="M2 9h16"/>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-[15px] font-medium text-[#1a1410]">Payment Instructions</h2>
                            <p class="mt-0.5 text-xs text-[#9a9080]">Send your donation through these official channels.</p>
                        </div>
                    </div>

                    <div class="divide-y divide-[#f5f2ec] px-5 py-2 sm:px-6">
                        <div class="py-3.5">
                            <p class="text-[10px] font-semibold uppercase tracking-[.1em] text-[#9a9080]">GCash Number</p>
                            <p class="mt-1 text-[14px] font-medium text-[#1a1410]">09XX-XXX-XXXX</p>
                        </div>
                        <div class="py-3.5">
                            <p class="text-[10px] font-semibold uppercase tracking-[.1em] text-[#9a9080]">Account Name</p>
                            <p class="mt-1 text-[13px] font-medium text-[#1a1410]">Holy Spirit School Alumni Association</p>
                        </div>
                        <div class="py-3.5">
                            <p class="text-[10px] font-semibold uppercase tracking-[.1em] text-[#9a9080]">Reminder</p>
                            <p class="mt-1 text-[13px] leading-5 text-[#7a7060]">
                                Use the exact amount you entered and upload a clear, readable proof of payment.
                            </p>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        {{-- ===== DONATION HISTORY ===== --}}
        <div class="mt-5 overflow-hidden rounded-[20px] border border-[#e8e2d6] bg-white">

            <div class="border-b border-[#f0ebe1] px-5 py-4 sm:px-6">
                <div class="flex items-center gap-3.5">
                    <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-[10px] bg-[#faf4e6]">
                        <svg class="h-4.5 w-4.5 text-[#b88a3d]" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.6">
                            <path d="M3 4h14v13H3zM3 8h14"/><path d="M7 4V2M13 4V2"/>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-[15px] font-medium text-[#1a1410]">Donation History</h2>
                        <p class="mt-0.5 text-xs text-[#9a9080]">Your submitted donations and their verification status.</p>
                    </div>
                </div>
            </div>

            {{-- Desktop Table --}}
            <div class="hidden overflow-x-auto lg:block">
                <table class="w-full text-left text-sm">
                    <thead class="border-b border-[#f0ebe1] bg-[#faf9f7]">
                        <tr>
                            @foreach(['Amount','Reference','Submitted','Verified','Status','Proof','Remarks'] as $col)
                                <th class="px-5 py-3 text-[10px] font-semibold uppercase tracking-[.1em] text-[#9a9080]">{{ $col }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#f5f2ec]">
                        @forelse ($donations as $donation)
                            <tr class="transition hover:bg-[#faf9f7]">
                                <td class="px-5 py-4 text-[14px] font-medium text-[#091852]">
                                    ₱{{ number_format($donation->amount ?? 0, 2) }}
                                </td>
                                <td class="px-5 py-4 text-[13px] text-[#7a7060]">
                                    {{ $donation->reference_number ?: '-' }}
                                </td>
                                <td class="px-5 py-4 text-[13px] text-[#7a7060]">
                                    {{ optional($donation->created_at)->format('M d, Y h:i A') ?: '-' }}
                                </td>
                                <td class="px-5 py-4 text-[13px] text-[#7a7060]">
                                    {{ optional($donation->paid_at)->format('M d, Y h:i A') ?: '-' }}
                                </td>
                                <td class="px-5 py-4">
                                    @if ($donation->status === 'verified')
                                        <span class="inline-flex items-center gap-1.5 rounded-full border border-emerald-200 bg-emerald-50 px-2.5 py-1 text-[10px] font-semibold uppercase tracking-wide text-emerald-800">
                                            <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>Verified
                                        </span>
                                    @elseif ($donation->status === 'pending')
                                        <span class="inline-flex items-center gap-1.5 rounded-full border border-[#f0d496] bg-[#faf4e6] px-2.5 py-1 text-[10px] font-semibold uppercase tracking-wide text-[#92601c]">
                                            <span class="h-1.5 w-1.5 rounded-full bg-[#d4a017]"></span>Pending
                                        </span>
                                    @elseif ($donation->status === 'rejected')
                                        <span class="inline-flex items-center gap-1.5 rounded-full border border-rose-200 bg-rose-50 px-2.5 py-1 text-[10px] font-semibold uppercase tracking-wide text-rose-700">
                                            <span class="h-1.5 w-1.5 rounded-full bg-rose-400"></span>Rejected
                                        </span>
                                    @endif
                                </td>
                                <td class="px-5 py-4">
                                    @if ($donation->or_file_path)
                                        <a
                                            href="{{ Storage::disk('s3')->url($donation->or_file_path) }}"
                                            target="_blank"
                                            class="inline-flex items-center gap-1.5 rounded-[8px] border border-[#e0dbd0] bg-[#faf9f7] px-3 py-1.5 text-xs font-medium text-[#1a1410] transition hover:border-[#d4b06a] hover:bg-[#faf4e6]"
                                        >
                                            <svg class="h-3 w-3 text-[#b88a3d]" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.8">
                                                <path d="M4 8h8M8 4l4 4-4 4"/>
                                            </svg>
                                            View Proof
                                        </a>
                                    @else
                                        <span class="text-xs text-[#b0ab9e]">No file</span>
                                    @endif
                                </td>
                                <td class="px-5 py-4 text-[13px] text-[#7a7060]">
                                    {{ $donation->remarks ?: '-' }}
                                </td>
                            </tr>

                            @if ($donation->rejection_reason)
                                <tr class="bg-rose-50">
                                    <td colspan="7" class="px-5 py-3">
                                        <p class="text-[10px] font-semibold uppercase tracking-[.1em] text-rose-500">Rejection Reason</p>
                                        <p class="mt-1 text-xs text-rose-700">{{ $donation->rejection_reason }}</p>
                                    </td>
                                </tr>
                            @endif

                        @empty
                            <tr>
                                <td colspan="7" class="px-5 py-14 text-center">
                                    <div class="flex flex-col items-center gap-2">
                                        <div class="flex h-10 w-10 items-center justify-center rounded-full bg-[#f0ebe1]">
                                            <svg class="h-5 w-5 text-[#b0ab9e]" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5">
                                                <rect x="3" y="4" width="14" height="13" rx="2"/><path d="M3 8h14"/>
                                            </svg>
                                        </div>
                                        <p class="text-sm font-medium text-[#1a1410]">No donations submitted yet</p>
                                        <p class="text-xs text-[#9a9080]">Your donation history will appear here after submission.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Mobile Cards --}}
            <div class="divide-y divide-[#f5f2ec] px-5 py-2 lg:hidden sm:px-6">
                @forelse ($donations as $donation)
                    <article class="py-5">
                        <div class="flex items-start justify-between gap-3">
                            <div>
                                <p class="text-[18px] font-medium text-[#091852]">
                                    ₱{{ number_format($donation->amount ?? 0, 2) }}
                                </p>
                                <p class="mt-0.5 text-xs text-[#9a9080]">
                                    {{ optional($donation->created_at)->format('M d, Y h:i A') ?: '-' }}
                                </p>
                            </div>

                            @if ($donation->status === 'verified')
                                <span class="inline-flex items-center gap-1.5 rounded-full border border-emerald-200 bg-emerald-50 px-2.5 py-1 text-[10px] font-semibold uppercase tracking-wide text-emerald-800">
                                    <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>Verified
                                </span>
                            @elseif ($donation->status === 'pending')
                                <span class="inline-flex items-center gap-1.5 rounded-full border border-[#f0d496] bg-[#faf4e6] px-2.5 py-1 text-[10px] font-semibold uppercase tracking-wide text-[#92601c]">
                                    <span class="h-1.5 w-1.5 rounded-full bg-[#d4a017]"></span>Pending
                                </span>
                            @elseif ($donation->status === 'rejected')
                                <span class="inline-flex items-center gap-1.5 rounded-full border border-rose-200 bg-rose-50 px-2.5 py-1 text-[10px] font-semibold uppercase tracking-wide text-rose-700">
                                    <span class="h-1.5 w-1.5 rounded-full bg-rose-400"></span>Rejected
                                </span>
                            @endif
                        </div>

                        <div class="mt-3.5 grid gap-2.5 sm:grid-cols-2">
                            <div class="rounded-[10px] border border-[#e0dbd0] bg-[#faf9f7] px-3.5 py-3">
                                <p class="text-[10px] font-semibold uppercase tracking-[.1em] text-[#9a9080]">Reference Number</p>
                                <p class="mt-1 text-[13px] text-[#1a1410]">{{ $donation->reference_number ?: '-' }}</p>
                            </div>
                            <div class="rounded-[10px] border border-[#e0dbd0] bg-[#faf9f7] px-3.5 py-3">
                                <p class="text-[10px] font-semibold uppercase tracking-[.1em] text-[#9a9080]">Verified At</p>
                                <p class="mt-1 text-[13px] text-[#1a1410]">{{ optional($donation->paid_at)->format('M d, Y h:i A') ?: '-' }}</p>
                            </div>

                            @if ($donation->remarks)
                                <div class="rounded-[10px] border border-[#e0dbd0] bg-[#faf9f7] px-3.5 py-3 sm:col-span-2">
                                    <p class="text-[10px] font-semibold uppercase tracking-[.1em] text-[#9a9080]">Remarks</p>
                                    <p class="mt-1 text-[13px] text-[#1a1410]">{{ $donation->remarks }}</p>
                                </div>
                            @endif

                            @if ($donation->rejection_reason)
                                <div class="rounded-[10px] border border-rose-200 bg-rose-50 px-3.5 py-3 sm:col-span-2">
                                    <p class="text-[10px] font-semibold uppercase tracking-[.1em] text-rose-500">Rejection Reason</p>
                                    <p class="mt-1 text-[13px] text-rose-700">{{ $donation->rejection_reason }}</p>
                                </div>
                            @endif
                        </div>

                        @if ($donation->or_file_path)
                            <div class="mt-3.5">
                                <a
                                    href="{{ Storage::disk('s3')->url($donation->or_file_path) }}"
                                    target="_blank"
                                    class="inline-flex items-center gap-1.5 rounded-[8px] border border-[#e0dbd0] bg-[#faf9f7] px-3 py-1.5 text-xs font-medium text-[#1a1410] transition hover:border-[#d4b06a] hover:bg-[#faf4e6]"
                                >
                                    <svg class="h-3 w-3 text-[#b88a3d]" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.8">
                                        <path d="M4 8h8M8 4l4 4-4 4"/>
                                    </svg>
                                    View Proof
                                </a>
                            </div>
                        @endif
                    </article>
                @empty
                    <div class="flex flex-col items-center gap-2 py-14 text-center">
                        <div class="flex h-10 w-10 items-center justify-center rounded-full bg-[#f0ebe1]">
                            <svg class="h-5 w-5 text-[#b0ab9e]" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5">
                                <rect x="3" y="4" width="14" height="13" rx="2"/><path d="M3 8h14"/>
                            </svg>
                        </div>
                        <p class="text-sm font-medium text-[#1a1410]">No donations submitted yet</p>
                        <p class="text-xs text-[#9a9080]">Your donation history will appear here after submission.</p>
                    </div>
                @endforelse
            </div>

        </div>

    </div>
</div>