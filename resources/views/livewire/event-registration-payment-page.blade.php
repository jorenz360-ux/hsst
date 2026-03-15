<div>
   <div class="mx-auto max-w-6xl space-y-6 p-6">
    {{-- Header --}}
    <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
        <div>
            <p class="text-xs font-semibold uppercase tracking-[0.22em] text-teal-400">
                Event Registration Payment
            </p>
            <h1 class="mt-1 text-3xl font-semibold tracking-tight text-zinc-900 dark:text-white">
                {{ $registration->event->title }}
            </h1>
            <p class="mt-2 max-w-2xl text-sm text-zinc-600 dark:text-zinc-400">
                Complete your payment outside the app, then upload your proof of payment for verification.
            </p>
        </div>

        <div>
            <span class="inline-flex items-center rounded-full border border-amber-500/20 bg-amber-500/10 px-3 py-1 text-xs font-medium text-amber-300">
                {{ str($registration->status)->headline() }}
            </span>
        </div>
    </div>

    {{-- Alerts --}}
    @if (session('success'))
        <div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-900 dark:border-emerald-900/40 dark:bg-emerald-950/20 dark:text-emerald-200">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid gap-6 xl:grid-cols-[1.15fr_0.85fr]">
        {{-- Main Upload Form --}}
        <div class="rounded-3xl border border-zinc-200 bg-white p-6 shadow-sm dark:border-white/10 dark:bg-white/[0.03]">
            <div class="mb-6">
                <h2 class="text-lg font-semibold text-zinc-900 dark:text-white">
                    Upload Proof of Payment
                </h2>
                <p class="mt-1 text-sm text-zinc-600 dark:text-zinc-400">
                    After sending your payment through the provided method, upload your screenshot or receipt here.
                </p>
            </div>

            <form wire:submit.prevent="submitProof" class="space-y-5">
                <div>
                    <label class="mb-1 block text-sm font-medium text-zinc-700 dark:text-zinc-300">
                        Reference Number <span class="text-zinc-400">(optional)</span>
                    </label>
                    <input
                        type="text"
                        wire:model.defer="reference_number"
                        placeholder="e.g. GCash ref no. / bank transfer ref no."
                        class="w-full rounded-2xl border border-zinc-200 bg-white px-4 py-2.5 text-sm text-zinc-900 outline-none transition focus:border-teal-400 focus:ring-2 focus:ring-teal-500/20 dark:border-white/10 dark:bg-zinc-950 dark:text-white"
                    >
                    @error('reference_number')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="mb-1 block text-sm font-medium text-zinc-700 dark:text-zinc-300">
                        Remarks <span class="text-zinc-400">(optional)</span>
                    </label>
                    <textarea
                        wire:model.defer="remarks"
                        rows="4"
                        placeholder="Add a short note if needed..."
                        class="w-full rounded-2xl border border-zinc-200 bg-white px-4 py-2.5 text-sm text-zinc-900 outline-none transition focus:border-teal-400 focus:ring-2 focus:ring-teal-500/20 dark:border-white/10 dark:bg-zinc-950 dark:text-white"
                    ></textarea>
                    @error('remarks')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="mb-1 block text-sm font-medium text-zinc-700 dark:text-zinc-300">
                        Proof of Payment
                    </label>
                    <input
                        type="file"
                        wire:model="proof"
                        accept=".jpg,.jpeg,.png,.pdf"
                        class="block w-full rounded-2xl border border-zinc-200 bg-white px-4 py-3 text-sm text-zinc-900 file:mr-4 file:rounded-xl file:border-0 file:bg-teal-500 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-white hover:file:bg-teal-600 dark:border-white/10 dark:bg-zinc-950 dark:text-white"
                    >
                    <p class="mt-2 text-xs text-zinc-500 dark:text-zinc-400">
                        Accepted formats: JPG, JPEG, PNG, PDF. Maximum size: 5MB.
                    </p>

                    <div wire:loading wire:target="proof" class="mt-2 text-sm text-teal-500">
                        Uploading file...
                    </div>

                    @error('proof')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                @if ($proof)
                    <div class="rounded-2xl border border-teal-500/20 bg-teal-500/10 p-4 text-sm text-teal-800 dark:text-teal-200">
                        File selected successfully and ready for submission.
                    </div>
                @endif

                <div class="flex justify-end border-t border-zinc-200 pt-5 dark:border-white/10">
                    <button
                        type="submit"
                        class="inline-flex items-center justify-center rounded-2xl bg-teal-500 px-5 py-2.5 text-sm font-semibold text-zinc-950 shadow-sm transition hover:bg-teal-400"
                    >
                        Submit Proof
                    </button>
                </div>
            </form>
        </div>

        {{-- Sidebar --}}
        <div class="space-y-6">
            {{-- Registration Summary --}}
            <div class="rounded-3xl border border-zinc-200 bg-white p-6 shadow-sm dark:border-white/10 dark:bg-white/[0.03]">
                <h2 class="text-lg font-semibold text-zinc-900 dark:text-white">
                    Registration Summary
                </h2>

                <div class="mt-4 space-y-3 text-sm">
                    <div class="rounded-2xl border border-zinc-200 bg-zinc-50 p-4 dark:border-white/10 dark:bg-zinc-900/70">
                        <p class="text-zinc-500 dark:text-zinc-400">Event</p>
                        <p class="mt-1 font-medium text-zinc-900 dark:text-white">
                            {{ $registration->event->title }}
                        </p>
                    </div>

                    <div class="rounded-2xl border border-zinc-200 bg-zinc-50 p-4 dark:border-white/10 dark:bg-zinc-900/70">
                        <p class="text-zinc-500 dark:text-zinc-400">Venue</p>
                        <p class="mt-1 font-medium text-zinc-900 dark:text-white">
                            {{ $registration->event->venue ?: 'No venue set' }}
                        </p>
                    </div>

                    <div class="rounded-2xl border border-zinc-200 bg-zinc-50 p-4 dark:border-white/10 dark:bg-zinc-900/70">
                        <p class="text-zinc-500 dark:text-zinc-400">Event Date</p>
                        <p class="mt-1 font-medium text-zinc-900 dark:text-white">
                            {{ optional($registration->event->event_date)->format('M d, Y') }}
                        </p>
                    </div>

                    <div class="rounded-2xl border border-zinc-200 bg-zinc-50 p-4 dark:border-white/10 dark:bg-zinc-900/70">
                        <p class="text-zinc-500 dark:text-zinc-400">Amount Due</p>
                        <p class="mt-1 text-lg font-semibold text-zinc-900 dark:text-white">
                            ₱{{ number_format(($payment->amount ?? 0) / 100, 2) }}
                        </p>
                    </div>
                </div>
            </div>

            {{-- Payment Instructions --}}
            <div class="rounded-3xl border border-zinc-200 bg-gradient-to-br from-teal-500/15 to-cyan-500/10 p-6 shadow-sm dark:border-white/10">
                <h2 class="text-lg font-semibold text-zinc-900 dark:text-white">
                    Payment Instructions
                </h2>
                <p class="mt-2 text-sm leading-6 text-zinc-700 dark:text-zinc-300">
                    Please send your payment using the official payment channel provided by the organizers, then upload your receipt or screenshot for verification.
                </p>

                <div class="mt-5 space-y-3 text-sm">
                    <div class="rounded-2xl border border-white/10 bg-zinc-950/70 p-4 text-zinc-200">
                        <p class="text-zinc-400">GCash</p>
                        <p class="mt-1 font-medium">09XX-XXX-XXXX</p>
                    </div>

                    <div class="rounded-2xl border border-white/10 bg-zinc-950/70 p-4 text-zinc-200">
                        <p class="text-zinc-400">Account Name</p>
                        <p class="mt-1 font-medium">Holy Spirit School Alumni Association</p>
                    </div>

                    <div class="rounded-2xl border border-white/10 bg-zinc-950/70 p-4 text-zinc-200">
                        <p class="text-zinc-400">Reminder</p>
                        <p class="mt-1">
                            Use the correct amount and keep your receipt clear and readable.
                        </p>
                    </div>
                </div>
            </div>

            {{-- Current Payment Status --}}
            <div class="rounded-3xl border border-zinc-200 bg-white p-6 shadow-sm dark:border-white/10 dark:bg-white/[0.03]">
                <h2 class="text-lg font-semibold text-zinc-900 dark:text-white">
                    Current Status
                </h2>

                <div class="mt-4">
                    @if ($registration->status === 'paid')
                        <span class="inline-flex items-center rounded-full border border-teal-500/20 bg-teal-500/10 px-3 py-1 text-xs font-medium text-teal-300">
                            Registered
                        </span>
                    @elseif ($registration->status === 'pending')
                        <span class="inline-flex items-center rounded-full border border-amber-500/20 bg-amber-500/10 px-3 py-1 text-xs font-medium text-amber-300">
                            Waiting for Approval
                        </span>
                    @else
                        <span class="inline-flex items-center rounded-full border border-zinc-200 bg-zinc-100 px-3 py-1 text-xs font-medium text-zinc-600 dark:border-zinc-700 dark:bg-zinc-800 dark:text-zinc-300">
                            {{ str($registration->status)->headline() }}
                        </span>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
</div>
