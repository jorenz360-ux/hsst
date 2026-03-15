<div>
    <div class="mx-auto max-w-4xl space-y-6 p-6">
    {{-- Page Header --}}
    <div class="flex flex-col gap-3">
        <p class="text-xs font-semibold uppercase tracking-[0.22em] text-teal-400">
            Alumni Giving
        </p>
        <div>
            <h1 class="text-3xl font-semibold tracking-tight text-zinc-900 dark:text-white">
                Make a Donation
            </h1>
            <p class="mt-2 max-w-2xl text-sm text-zinc-600 dark:text-zinc-400">
                Support the alumni reunion program and help strengthen community initiatives for Holy Spirit School of Tagbilaran.
            </p>
        </div>
    </div>

    {{-- Alerts --}}
    @if (session('info'))
        <div class="rounded-2xl border border-blue-200 bg-blue-50 px-4 py-3 text-sm text-blue-900 dark:border-blue-900/40 dark:bg-blue-950/20 dark:text-blue-200">
            {{ session('info') }}
        </div>
    @endif

    @if (session()->has('success'))
        <div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-900 dark:border-emerald-900/40 dark:bg-emerald-950/20 dark:text-emerald-200">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid gap-6 lg:grid-cols-[1.1fr_0.9fr]">
        {{-- Donation Form --}}
        <div class="rounded-3xl border border-zinc-200 bg-white p-6 shadow-sm dark:border-white/10 dark:bg-white/[0.03]">
            <div class="mb-6">
                <h2 class="text-lg font-semibold text-zinc-900 dark:text-white">
                    Donation Details
                </h2>
                <p class="mt-1 text-sm text-zinc-600 dark:text-zinc-400">
                    Enter your intended donation amount and an optional message.
                </p>
            </div>

            <form class="space-y-5" wire:submit.prevent="pay">
                <div>
                    <flux:input
                        label="Donation Amount (₱)"
                        type="number"
                        min="1"
                        step="1"
                        placeholder="e.g., 100"
                        wire:model.defer="amount"
                    />
                    @error('amount')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <flux:textarea
                        label="Remarks (optional)"
                        rows="4"
                        placeholder="Leave a short message…"
                        wire:model.defer="remarks"
                    />
                    @error('remarks')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                @if((auth()->user()->alumni_id))
                    <div class="rounded-2xl border border-amber-200 bg-amber-50 px-4 py-3 text-sm text-amber-900 dark:border-amber-900/40 dark:bg-amber-950/20 dark:text-amber-200">
                     This feature is not yet available
                    </div>
                @endif

                <div class="flex flex-col gap-3 border-t border-zinc-200 pt-5 dark:border-white/10 sm:flex-row sm:items-center sm:justify-end">
                    <flux:button type="button" wire:click="resetForm">
                        Reset
                    </flux:button>

                    {{-- Enable this later when implemented --}}
                    {{--
                    <flux:button type="submit" variant="primary">
                        Proceed to Checkout
                    </flux:button>
                    --}}
                </div>
            </form>
        </div>

        {{-- Side Panel --}}
        <div class="space-y-6">
            {{-- Donation Guidance --}}
            <div class="rounded-3xl border border-zinc-200 bg-white p-6 shadow-sm dark:border-white/10 dark:bg-white/[0.03]">
                <h3 class="text-lg font-semibold text-zinc-900 dark:text-white">
                    Donation Guide
                </h3>
                <p class="mt-2 text-sm leading-6 text-zinc-600 dark:text-zinc-400">
                    Donations help support reunion activities, alumni engagement programs, and community-related initiatives. Every contribution, no matter the amount, is appreciated.
                </p>

                <div class="mt-5 grid gap-3">
                    <div class="rounded-2xl border border-zinc-200 bg-zinc-50 p-4 dark:border-white/10 dark:bg-zinc-900/70">
                        <p class="text-xs uppercase tracking-[0.14em] text-zinc-500 dark:text-zinc-400">
                            Suggested Gift
                        </p>
                        <p class="mt-1 text-base font-semibold text-zinc-900 dark:text-white">
                            ₱100 – ₱1,000+
                        </p>
                    </div>

                    <div class="rounded-2xl border border-zinc-200 bg-zinc-50 p-4 dark:border-white/10 dark:bg-zinc-900/70">
                        <p class="text-xs uppercase tracking-[0.14em] text-zinc-500 dark:text-zinc-400">
                            Purpose
                        </p>
                        <p class="mt-1 text-sm text-zinc-700 dark:text-zinc-300">
                            Reunion support, alumni activities, and future community projects
                        </p>
                    </div>
                </div>
            </div>

            {{-- Checkout Status --}}
            <div class="rounded-3xl border border-zinc-200 bg-gradient-to-br from-zinc-50 to-zinc-100 p-6 shadow-sm dark:border-white/10 dark:bg-gradient-to-br dark:from-zinc-900 dark:to-zinc-950">
                <div class="flex items-start gap-3">
                    <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-zinc-900 text-white dark:bg-white dark:text-zinc-900">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>

                    <div class="flex-1">
                        <h3 class="text-lg font-semibold text-zinc-900 dark:text-white">
                            Checkout
                        </h3>
                        <p class="mt-1 text-sm leading-6 text-zinc-600 dark:text-zinc-400">
                            This feature is not yet available and will be enabled in a future update based on client readiness and deployment schedule.
                        </p>
                    </div>
                </div>

                <div class="mt-5">
                    <flux:button
                        type="button"
                        variant="primary"
                        disabled
                        class="w-full"
                    >
                        Coming Soon
                    </flux:button>
                </div>
            </div>
        </div>
    </div>
</div>
</div>