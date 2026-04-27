<div class="min-h-screen bg-[#f7f5f1]">
    <div class="mx-auto max-w-6xl px-4 py-8 sm:px-6 lg:px-8">

        @include('partials.toast')

        {{-- ===== HEADER ===== --}}
        <section class="mb-6 border border-[#e8e2d6] bg-white">
            <div class="h-1 w-full bg-[#091852]"></div>
            <div class="flex flex-col gap-4 px-6 py-6 sm:flex-row sm:items-end sm:justify-between sm:px-8">
                <div>
                    <p class="text-[10px] font-semibold uppercase tracking-[.2em] text-[#b88a3d]">HSST Alumni · Donation Portal</p>
                    <h1 class="mt-1.5 font-serif text-[26px] font-normal leading-tight text-[#091852] sm:text-[32px]">
                        Support the <em>Alumni Association</em>
                    </h1>
                    <p class="mt-1.5 max-w-prose text-[13px] leading-6 text-[#7a7060]">
                        Send your donation through the official payment channel, then upload your proof of payment for admin verification.
                    </p>
                </div>
                <div class="flex shrink-0 items-center gap-2 border border-[#e0dbd0] bg-[#faf9f7] px-3.5 py-2 text-[11px] font-semibold text-[#7a7060]">
                    <svg class="h-3.5 w-3.5 text-[#b88a3d]" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.6">
                        <path d="M2 10h16M6 6l-4 4 4 4M14 6l4 4-4 4"/>
                    </svg>
                    Manual Donation Flow
                </div>
            </div>
        </section>

        <div class="grid gap-5 xl:grid-cols-[1.2fr_0.8fr]">

            {{-- ===== DONATION FORM ===== --}}
            <div class="border border-[#e8e2d6] bg-white">

                <div class="border-b border-[#1a3fa8] bg-[#091852] px-6 py-4">
                    <h2 class="font-serif text-[17px] font-normal text-white">Submit a Donation</h2>
                    <p class="mt-0.5 text-[11px] text-white/50">Fill in the details and attach a clear proof of payment.</p>
                </div>

                <div class="px-6 py-6">
                    <form wire:submit.prevent="submitDonation" class="space-y-6">

                        {{-- Amount --}}
                        <div>
                            <label class="mb-2 block text-[10px] font-bold uppercase tracking-[.12em] text-[#7a7060]">
                                Donation Amount
                            </label>
                            <div class="mb-3 grid grid-cols-4 gap-2">
                                @foreach ([100, 300, 500, 1000] as $preset)
                                    <button type="button"
                                            wire:click="$set('amount', {{ $preset }})"
                                            class="border py-3 text-center text-[13px] font-bold transition
                                                   {{ (int)($amount ?? 0) === $preset
                                                       ? 'border-[#091852] bg-[#091852] text-white'
                                                       : 'border-[#e0dbd0] bg-white text-[#1a1410] hover:border-[#091852] hover:bg-[#f0f4ff]' }}">
                                        ₱{{ number_format($preset) }}
                                    </button>
                                @endforeach
                            </div>
                            <input type="number"
                                   wire:model.live.debounce.300ms="amount"
                                   min="1" step="1"
                                   placeholder="Or enter a custom amount…"
                                   class="w-full border border-[#e0dbd0] bg-[#faf9f7] px-4 py-3 text-[14px] text-[#1a1410] outline-none transition placeholder:text-[#c0bbb0] focus:border-[#091852] focus:bg-white">
                            @error('amount')
                                <p class="mt-1.5 text-xs text-rose-500">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Reference --}}
                        <div>
                            <label class="mb-2 block text-[10px] font-bold uppercase tracking-[.12em] text-[#7a7060]">
                                Reference Number
                                <span class="font-normal normal-case tracking-normal text-[#b0ab9e]">— optional</span>
                            </label>
                            <input type="text"
                                   wire:model.defer="reference_number"
                                   placeholder="GCash ref, bank transaction ID…"
                                   class="w-full border border-[#e0dbd0] bg-[#faf9f7] px-4 py-3 text-[14px] text-[#1a1410] outline-none transition placeholder:text-[#c0bbb0] focus:border-[#091852] focus:bg-white">
                            @error('reference_number')
                                <p class="mt-1.5 text-xs text-rose-500">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Remarks --}}
                        <div>
                            <label class="mb-2 block text-[10px] font-bold uppercase tracking-[.12em] text-[#7a7060]">
                                Remarks
                                <span class="font-normal normal-case tracking-normal text-[#b0ab9e]">— optional</span>
                            </label>
                            <textarea wire:model.defer="remarks"
                                      rows="2"
                                      placeholder="Short note or message…"
                                      class="w-full resize-none border border-[#e0dbd0] bg-[#faf9f7] px-4 py-3 text-[14px] text-[#1a1410] outline-none transition placeholder:text-[#c0bbb0] focus:border-[#091852] focus:bg-white"></textarea>
                            @error('remarks')
                                <p class="mt-1.5 text-xs text-rose-500">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Proof Upload --}}
                        <div>
                            <label class="mb-2 block text-[10px] font-bold uppercase tracking-[.12em] text-[#7a7060]">
                                Official Receipt / Proof of Payment
                                <span class="text-rose-400">*</span>
                            </label>

                            <label class="flex cursor-pointer flex-col items-center justify-center gap-3 border border-dashed border-[#d4b06a] bg-[#fdfcf9] px-5 py-8 text-center transition hover:border-[#b88a3d] hover:bg-[#faf4e6]">
                                @if ($proof)
                                    <div class="flex h-10 w-10 items-center justify-center border border-emerald-200 bg-emerald-50">
                                        <svg class="h-5 w-5 text-emerald-600" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="2">
                                            <polyline points="4,10 8,14 16,6"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-[13px] font-semibold text-emerald-800">File ready — click to replace</p>
                                        <p class="mt-0.5 text-[11px] text-emerald-600">{{ $proof->getClientOriginalName() }}</p>
                                    </div>
                                @else
                                    <div class="flex h-10 w-10 items-center justify-center border border-[#e8d9b0] bg-[#faf4e6]">
                                        <svg class="h-5 w-5 text-[#b88a3d]" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.6">
                                            <path d="M10 14V4M6 8l4-4 4 4"/><path d="M4 16h12"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-[13px] font-semibold text-[#1a1410]">Click to upload proof</p>
                                        <p class="mt-0.5 text-[11px] text-[#9a9080]">JPG, JPEG, PNG, PDF · max 5 MB</p>
                                    </div>
                                @endif
                                <input type="file" wire:model="proof" accept=".jpg,.jpeg,.png,.pdf" class="sr-only">
                            </label>

                            <div wire:loading wire:target="proof"
                                 class="mt-2 flex items-center gap-2 text-[11px] text-[#b88a3d]">
                                <svg class="h-3.5 w-3.5 animate-spin" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M12 2v4M12 18v4M4.93 4.93l2.83 2.83M16.24 16.24l2.83 2.83M2 12h4M18 12h4"/>
                                </svg>
                                Uploading…
                            </div>
                            @error('proof')
                                <p class="mt-1.5 text-xs text-rose-500">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Submit --}}
                        <div class="border-t border-[#f0ebe1] pt-5">
                            <button type="submit"
                                    wire:loading.attr="disabled"
                                    wire:target="submitDonation"
                                    class="inline-flex w-full items-center justify-center gap-2.5 bg-[#091852] px-6 py-3.5 text-[13px] font-semibold uppercase tracking-[.08em] text-white transition hover:bg-[#0f2a7a] active:scale-[.98] disabled:opacity-60">
                                <span wire:loading.remove wire:target="submitDonation"
                                      style="display:inline-flex;align-items:center;gap:.5rem;">
                                    <svg class="h-4 w-4" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.8">
                                        <path d="M10 14V4M6 8l4-4 4 4"/><path d="M4 16h12"/>
                                    </svg>
                                    Submit Donation Proof
                                </span>
                                <span wire:loading wire:target="submitDonation">Submitting…</span>
                            </button>
                        </div>

                    </form>
                </div>
            </div>

            {{-- ===== RIGHT COLUMN ===== --}}
            <div class="space-y-4">

                {{-- Contribution Summary --}}
                <div class="border border-[#e8e2d6] bg-white">
                    <div class="border-b border-[#1a3fa8] bg-[#091852] px-5 py-3.5">
                        <h2 class="font-serif text-[15px] font-normal text-white">Your Contribution</h2>
                    </div>
                    <div class="divide-y divide-[#f0ebe1]">
                        <div class="px-5 py-4">
                            <p class="text-[10px] font-bold uppercase tracking-[.12em] text-[#9a9080]">Donor</p>
                            <p class="mt-1.5 text-[14px] font-medium text-[#1a1410]">
                                {{ auth()->user()->username ?? 'Authenticated User' }}
                            </p>
                        </div>
                        <div class="flex items-end justify-between gap-2 px-5 py-4">
                            <div>
                                <p class="text-[10px] font-bold uppercase tracking-[.12em] text-[#9a9080]">This Entry</p>
                                <p class="mt-1 font-serif text-[26px] font-normal leading-none text-[#091852]">
                                    ₱{{ number_format((int) ($amount ?? 0), 2) }}
                                </p>
                            </div>
                            <div class="text-right">
                                <p class="text-[10px] font-bold uppercase tracking-[.12em] text-[#9a9080]">Pending</p>
                                <p class="mt-1 font-serif text-[26px] font-normal leading-none text-[#b88a3d]">
                                    {{ $pendingCount ?? 0 }}
                                </p>
                            </div>
                        </div>
                        <div class="bg-[#091852]/[.03] px-5 py-5">
                            <p class="text-[10px] font-bold uppercase tracking-[.12em] text-[#9a9080]">Total Verified</p>
                            <p class="mt-1 font-serif text-[36px] font-normal leading-none tracking-tight text-[#091852]">
                                ₱{{ number_format(($verifiedTotal ?? 0) / 100, 2) }}
                            </p>
                            <p class="mt-1.5 text-[10px] font-semibold uppercase tracking-widest text-[#b88a3d]">confirmed</p>
                        </div>
                    </div>
                </div>

                {{-- Payment Instructions --}}
                <div class="border border-[#e8e2d6] bg-white">
                    <div class="border-b border-[#a37522] bg-[#b88a3d] px-5 py-3.5">
                        <h2 class="font-serif text-[15px] font-normal text-white">Payment Instructions</h2>
                        <p class="mt-0.5 text-[10px] text-white/70">Send through these official channels only.</p>
                    </div>
                    <div class="divide-y divide-[#f5f2ec] px-5">
                        <div class="py-3.5">
                            <p class="text-[10px] font-bold uppercase tracking-[.12em] text-[#9a9080]">GCash Number</p>
                            <p class="mt-1 font-mono text-[16px] font-semibold tracking-wide text-[#1a1410]">
                                09XX-XXX-XXXX
                            </p>
                        </div>
                        <div class="py-3.5">
                            <p class="text-[10px] font-bold uppercase tracking-[.12em] text-[#9a9080]">Account Name</p>
                            <p class="mt-1 text-[13px] font-medium leading-5 text-[#1a1410]">
                                Holy Spirit School Alumni Association
                            </p>
                        </div>
                        <div class="py-3.5">
                            <p class="text-[10px] font-bold uppercase tracking-[.12em] text-[#9a9080]">Reminder</p>
                            <p class="mt-1 text-[12px] leading-5 text-[#7a7060]">
                                Use the exact amount entered and upload a clear, readable screenshot or receipt.
                            </p>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        {{-- ===== DONATION HISTORY ===== --}}
        <div class="mt-5 border border-[#e8e2d6] bg-white">

            <div class="border-b border-[#1a3fa8] bg-[#091852] px-6 py-4">
                <h2 class="font-serif text-[17px] font-normal text-white">Donation History</h2>
                <p class="mt-0.5 text-[11px] text-white/50">Your submitted donations and their verification status.</p>
            </div>

            {{-- Desktop Table --}}
            <div class="hidden overflow-x-auto lg:block">
                <table style="width:100%;border-collapse:collapse;">
                    <thead>
                        <tr style="background:#0a1f5c;">
                            @foreach(['Amount','Reference','Submitted','Status','Receipt','Remarks'] as $col)
                                <th style="font-size:.565rem;font-weight:700;letter-spacing:.14em;text-transform:uppercase;
                                           color:rgba(255,255,255,.5);padding:.6rem .9rem;text-align:left;
                                           white-space:nowrap;border:none;">{{ $col }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($donations as $donation)
                            <tr style="border-bottom:1px solid #f5f2ec;border-left:2.5px solid transparent;
                                       transition:background .1s,border-left-color .1s;"
                                onmouseover="this.style.background='rgba(9,24,82,.028)';this.style.borderLeftColor='#1a3fa8'"
                                onmouseout="this.style.background='';this.style.borderLeftColor='transparent'">

                                <td style="padding:.55rem .9rem;min-width:110px;">
                                    <span style="font-size:.82rem;font-weight:800;color:#091852;
                                                 font-variant-numeric:tabular-nums;letter-spacing:-.015em;">
                                        ₱{{ number_format($donation->amount ?? 0, 2) }}
                                    </span>
                                </td>

                                <td style="padding:.55rem .9rem;min-width:130px;">
                                    @if ($donation->reference_number)
                                        <span style="font-family:ui-monospace,SFMono-Regular,monospace;font-size:.67rem;
                                                     letter-spacing:.02em;background:#f8fafc;border:1px solid #e2e8f0;
                                                     padding:.12rem .45rem;color:#334155;">
                                            {{ $donation->reference_number }}
                                        </span>
                                    @else
                                        <span style="font-size:.7rem;color:#cbd5e1;">—</span>
                                    @endif
                                </td>

                                <td style="padding:.55rem .9rem;min-width:120px;">
                                    <p style="font-size:.75rem;font-weight:600;color:#334155;white-space:nowrap;">
                                        {{ optional($donation->created_at)->format('M d, Y') ?: '—' }}
                                    </p>
                                    <p style="font-size:.62rem;color:#94a3b8;margin-top:.1rem;">
                                        {{ optional($donation->created_at)->format('h:i A') ?: '' }}
                                    </p>
                                </td>

                                <td style="padding:.55rem .9rem;min-width:115px;">
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
                                    @if ($donation->rejection_reason)
                                        <p style="font-size:.62rem;color:#dc2626;margin-top:.25rem;
                                                   max-width:160px;line-height:1.35;">
                                            {{ Str::limit($donation->rejection_reason, 50) }}
                                        </p>
                                    @endif
                                </td>

                                <td style="padding:.55rem .9rem;">
                                    @if ($donation->or_file_path)
                                        @php
                                            /** @var \Illuminate\Filesystem\FilesystemAdapter $mdS3 */
                                            $mdS3    = Storage::disk('s3');
                                            $mdOrUrl = $mdS3->url($donation->or_file_path);
                                            $mdOrExt = strtolower(pathinfo($donation->or_file_path, PATHINFO_EXTENSION));
                                        @endphp
                                        <button type="button" x-data
                                                @click="$dispatch('open-or-modal',{url:'{{ $mdOrUrl }}',ext:'{{ $mdOrExt }}'})"
                                                style="display:inline-flex;align-items:center;gap:.22rem;
                                                       padding:.2rem .5rem;font-size:.63rem;font-weight:700;
                                                       border:1px solid #fde68a;background:#fffbeb;color:#92700a;
                                                       cursor:pointer;transition:filter .1s;"
                                                onmouseover="this.style.filter='brightness(.93)'"
                                                onmouseout="this.style.filter=''">
                                            <svg style="width:.6rem;height:.6rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z"/>
                                            </svg>
                                            View OR
                                        </button>
                                    @else
                                        <span style="font-size:.68rem;color:#cbd5e1;">No file</span>
                                    @endif
                                </td>

                                <td style="padding:.55rem .9rem;max-width:200px;">
                                    <p style="font-size:.72rem;color:#7a7060;overflow:hidden;
                                               text-overflow:ellipsis;white-space:nowrap;">
                                        {{ $donation->remarks ?: '—' }}
                                    </p>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" style="padding:3.5rem 1.5rem;text-align:center;">
                                    <div style="max-width:18rem;margin:0 auto;">
                                        <div style="width:2.75rem;height:2.75rem;border:1px solid #e2e8f0;
                                                    background:#f7f5f1;display:flex;align-items:center;
                                                    justify-content:center;margin:0 auto .75rem;">
                                            <svg style="width:1.2rem;height:1.2rem;color:#b0ab9e;" fill="none" stroke="currentColor" viewBox="0 0 20 20" stroke-width="1.5">
                                                <rect x="3" y="4" width="14" height="13"/><path d="M3 8h14"/>
                                            </svg>
                                        </div>
                                        <p style="font-size:.8125rem;font-weight:600;color:#1a1410;">No donations submitted yet</p>
                                        <p style="font-size:.72rem;color:#9a9080;margin-top:.3rem;">Your donation history will appear here after submission.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Mobile Cards --}}
            <div class="divide-y divide-[#f5f2ec] lg:hidden">
                @forelse ($donations as $donation)
                    @php
                        $mStatusColor = match($donation->status) {
                            'verified' => '#10b981',
                            'rejected' => '#ef4444',
                            default    => '#f59e0b',
                        };
                    @endphp
                    <article>
                        <div style="height:3px;background:{{ $mStatusColor }};"></div>
                        <div class="px-5 py-4 sm:px-6">
                            <div class="flex items-start justify-between gap-3">
                                <div>
                                    <p class="font-serif text-[22px] font-normal leading-none text-[#091852]">
                                        ₱{{ number_format($donation->amount ?? 0, 2) }}
                                    </p>
                                    <p class="mt-1 text-[11px] text-[#9a9080]">
                                        {{ optional($donation->created_at)->format('M d, Y · h:i A') ?: '—' }}
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

                            <div class="mt-3 grid grid-cols-2 gap-2">
                                <div class="border border-[#e0dbd0] bg-[#faf9f7] px-3 py-2.5">
                                    <p class="text-[9px] font-bold uppercase tracking-[.12em] text-[#9a9080]">Reference</p>
                                    <p class="mt-1 font-mono text-[12px] text-[#1a1410]">{{ $donation->reference_number ?: '—' }}</p>
                                </div>
                                <div class="border border-[#e0dbd0] bg-[#faf9f7] px-3 py-2.5">
                                    <p class="text-[9px] font-bold uppercase tracking-[.12em] text-[#9a9080]">Submitted</p>
                                    <p class="mt-1 text-[12px] text-[#1a1410]">{{ optional($donation->created_at)->format('M d, Y') ?: '—' }}</p>
                                </div>
                                @if ($donation->remarks)
                                    <div class="col-span-2 border border-[#e0dbd0] bg-[#faf9f7] px-3 py-2.5">
                                        <p class="text-[9px] font-bold uppercase tracking-[.12em] text-[#9a9080]">Remarks</p>
                                        <p class="mt-1 text-[12px] text-[#1a1410]">{{ $donation->remarks }}</p>
                                    </div>
                                @endif
                                @if ($donation->rejection_reason)
                                    <div class="col-span-2 border border-rose-200 bg-rose-50 px-3 py-2.5">
                                        <p class="text-[9px] font-bold uppercase tracking-[.12em] text-rose-500">Rejection Reason</p>
                                        <p class="mt-1 text-[12px] text-rose-700">{{ $donation->rejection_reason }}</p>
                                    </div>
                                @endif
                            </div>

                            @if ($donation->or_file_path)
                                @php
                                    /** @var \Illuminate\Filesystem\FilesystemAdapter $mbS3 */
                                    $mbS3    = Storage::disk('s3');
                                    $mbOrUrl = $mbS3->url($donation->or_file_path);
                                    $mbOrExt = strtolower(pathinfo($donation->or_file_path, PATHINFO_EXTENSION));
                                @endphp
                                <div class="mt-3">
                                    <button type="button" x-data
                                            @click="$dispatch('open-or-modal',{url:'{{ $mbOrUrl }}',ext:'{{ $mbOrExt }}'})"
                                            class="inline-flex items-center gap-1.5 border border-[#fde68a] bg-[#fffbeb] px-3 py-1.5 text-[11px] font-bold text-[#92700a] transition hover:bg-[#fef3c7] cursor-pointer">
                                        <svg style="width:.6rem;height:.6rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z"/>
                                        </svg>
                                        View OR
                                    </button>
                                </div>
                            @endif
                        </div>
                    </article>
                @empty
                    <div class="flex flex-col items-center gap-2 py-14 text-center">
                        <div class="flex h-10 w-10 items-center justify-center border border-[#e0dbd0] bg-[#f7f5f1]">
                            <svg class="h-5 w-5 text-[#b0ab9e]" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5">
                                <rect x="3" y="4" width="14" height="13"/><path d="M3 8h14"/>
                            </svg>
                        </div>
                        <p class="text-sm font-medium text-[#1a1410]">No donations submitted yet</p>
                        <p class="text-xs text-[#9a9080]">Your donation history will appear here after submission.</p>
                    </div>
                @endforelse
            </div>

        </div>

    </div>

    {{-- OR File Preview Modal --}}
<div x-data="{ open: false, url: '', ext: '' }"
     @open-or-modal.window="open = true; url = $event.detail.url; ext = $event.detail.ext"
     x-show="open"
     x-cloak
     x-transition:enter="transition ease-out duration-200"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition ease-in duration-150"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     style="position:fixed;inset:0;z-index:9999;
            backdrop-filter:blur(24px) saturate(1.2) brightness(.45);
            -webkit-backdrop-filter:blur(24px) saturate(1.2) brightness(.45);
            background:rgba(4,10,30,.72);
            display:flex;flex-direction:column;"
     @click.self="open = false"
     @keydown.escape.window="open = false">

    <div style="display:flex;align-items:center;justify-content:space-between;
                padding:.85rem 1.25rem;flex-shrink:0;">
        <div style="display:flex;align-items:center;gap:.75rem;">
            <div style="width:2.2rem;height:2.2rem;border-radius:.55rem;flex-shrink:0;
                        display:flex;align-items:center;justify-content:center;
                        background:rgba(196,149,42,.22);border:1px solid rgba(196,149,42,.35);
                        backdrop-filter:blur(8px);">
                <svg style="width:.9rem;height:.9rem;color:#fbbf24;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z"/>
                </svg>
            </div>
            <div>
                <p style="font-family:Georgia,serif;font-size:.9rem;font-weight:700;
                           color:#fff;margin:0;line-height:1.2;">Official Receipt</p>
                <template x-if="ext === 'pdf'">
                    <p style="font-size:.65rem;color:rgba(255,255,255,.5);margin:.1rem 0 0;letter-spacing:.04em;text-transform:uppercase;font-weight:600;">PDF Document</p>
                </template>
                <template x-if="ext !== 'pdf'">
                    <p style="font-size:.65rem;color:rgba(255,255,255,.5);margin:.1rem 0 0;letter-spacing:.04em;text-transform:uppercase;font-weight:600;">Image File &middot; click to open full size</p>
                </template>
            </div>
        </div>
        <div style="display:flex;align-items:center;gap:.5rem;">
            <a :href="url" target="_blank"
               style="display:inline-flex;align-items:center;gap:.38rem;
                      padding:.38rem .85rem;border-radius:.55rem;font-size:.75rem;font-weight:700;
                      color:#fff;text-decoration:none;cursor:pointer;
                      background:rgba(255,255,255,.12);border:1px solid rgba(255,255,255,.2);
                      backdrop-filter:blur(8px);transition:background .15s,border-color .15s;"
               onmouseover="this.style.background='rgba(255,255,255,.2)';this.style.borderColor='rgba(255,255,255,.35)'"
               onmouseout="this.style.background='rgba(255,255,255,.12)';this.style.borderColor='rgba(255,255,255,.2)'">
                <svg style="width:.7rem;height:.7rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 0 0 3 8.25v10.5A2.25 2.25 0 0 0 5.25 21h10.5A2.25 2.25 0 0 0 18 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25"/>
                </svg>
                Open in new tab
            </a>
            <button @click="open = false"
                    style="width:2rem;height:2rem;border-radius:.5rem;border:1px solid rgba(255,255,255,.2);
                           background:rgba(255,255,255,.1);backdrop-filter:blur(8px);cursor:pointer;
                           color:rgba(255,255,255,.7);display:flex;align-items:center;justify-content:center;
                           transition:background .15s,color .15s;"
                    onmouseover="this.style.background='rgba(255,255,255,.22)';this.style.color='#fff'"
                    onmouseout="this.style.background='rgba(255,255,255,.1)';this.style.color='rgba(255,255,255,.7)'">
                <svg style="width:.8rem;height:.8rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
    </div>

    <div style="flex:1;overflow:auto;display:flex;align-items:center;justify-content:center;
                padding:.5rem 3rem 1rem;">
        <template x-if="ext === 'pdf'">
            <iframe :src="url"
                    style="width:100%;height:100%;min-height:500px;border:none;
                           border-radius:.75rem;box-shadow:0 8px 48px rgba(0,0,0,.6);"></iframe>
        </template>
        <template x-if="ext !== 'pdf'">
            <img :src="url"
                 style="max-width:100%;max-height:calc(100vh - 120px);object-fit:contain;
                        border-radius:.75rem;box-shadow:0 8px 48px rgba(0,0,0,.65);cursor:zoom-in;"
                 @click="window.open(url,'_blank')" />
        </template>
    </div>

    <p style="text-align:center;font-size:.65rem;color:rgba(255,255,255,.3);
              padding-bottom:.75rem;flex-shrink:0;letter-spacing:.06em;">
        Press <kbd style="font-family:ui-monospace,monospace;background:rgba(255,255,255,.1);
                           border:1px solid rgba(255,255,255,.18);border-radius:.25rem;
                           padding:.05rem .35rem;font-size:.62rem;">ESC</kbd> or click outside to close
    </p>
</div>
</div>
