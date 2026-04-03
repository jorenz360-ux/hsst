<div class="min-h-screen bg-[#0b1120]">
    <div class="mx-auto max-w-7xl space-y-4 px-3 py-4 sm:space-y-6 sm:px-6 sm:py-6 lg:px-8">

        {{-- Header --}}
        <section class="overflow-hidden rounded-2xl border border-white/10 bg-gradient-to-br from-[#0f172a] via-[#020617] to-[#1e3a8a]/20 shadow-[0_20px_60px_rgba(0,0,0,0.45)] sm:rounded-3xl">
            <div class="flex flex-col gap-4 px-4 py-5 sm:px-6 sm:py-6 lg:flex-row lg:items-end lg:justify-between">
                <div class="max-w-3xl">
                    <p class="text-[11px] font-semibold uppercase tracking-[0.2em] text-blue-400 sm:text-xs sm:tracking-[0.24em]">
                        Event Registration
                    </p>

                    <h1 class="mt-2 text-xl font-bold tracking-tight text-white sm:text-3xl">
                        {{ $event->title }}
                    </h1>

                    <p class="mt-3 text-sm leading-6 text-slate-400 sm:text-[15px]">
                        Register for the event, review required and optional payment items, and upload your proof of payment for verification.
                    </p>
                </div>

                <a href="{{ route('dashboard') }}"
                   wire:navigate
                   class="inline-flex items-center justify-center rounded-xl border border-white/10 bg-white/5 px-4 py-2.5 text-sm font-medium text-slate-200 transition hover:bg-white/10">
                    Back to Dashboard
                </a>
            </div>
        </section>

        {{-- Alerts --}}
        @if (session('success'))
            <div class="rounded-2xl border border-emerald-500/20 bg-emerald-500/10 px-4 py-4 text-sm text-emerald-300 sm:px-5">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="rounded-2xl border border-rose-500/20 bg-rose-500/10 px-4 py-4 text-sm text-rose-300 sm:px-5">
                {{ session('error') }}
            </div>
        @endif

        <div class="grid gap-4 xl:grid-cols-[1.2fr_0.8fr] xl:gap-6">

            {{-- LEFT --}}
            <div class="space-y-4 sm:space-y-6">

                {{-- Event Summary --}}
                <section class="rounded-2xl border border-white/10 bg-[#020617] shadow-[0_16px_40px_rgba(0,0,0,0.4)] sm:rounded-3xl">
                    <div class="border-b border-white/10 px-4 py-4 sm:px-5">
                        <h2 class="text-base font-semibold text-white sm:text-lg">Event Summary</h2>
                        <p class="mt-1 text-sm text-slate-400">
                            Your registration record is created automatically when you open this page.
                        </p>
                    </div>

                    <div class="grid gap-3 p-4 sm:grid-cols-2 sm:gap-4 sm:p-5">
                        <div class="rounded-xl border border-white/10 bg-white/5 p-4 sm:rounded-2xl">
                            <p class="text-[11px] uppercase tracking-wide text-slate-500">Venue</p>
                            <p class="mt-2 text-sm font-medium text-white">
                                {{ $event->venue ?: 'No venue set' }}
                            </p>
                        </div>

                        <div class="rounded-xl border border-white/10 bg-white/5 p-4 sm:rounded-2xl">
                            <p class="text-[11px] uppercase tracking-wide text-slate-500">Event Date</p>
                            <p class="mt-2 text-sm font-medium text-white">
                                {{ optional($event->event_date)->format('M d, Y • h:i A') }}
                            </p>
                        </div>

                        <div class="rounded-xl border border-white/10 bg-white/5 p-4 sm:rounded-2xl">
                            <p class="text-[11px] uppercase tracking-wide text-slate-500">Dress Code</p>
                            <p class="mt-2 text-sm font-medium text-white">
                                {{ $event->dress_code ?: 'No dress code specified' }}
                            </p>
                        </div>

                        <div class="rounded-xl border border-white/10 bg-white/5 p-4 sm:rounded-2xl">
                            <p class="text-[11px] uppercase tracking-wide text-slate-500">Registration Record</p>
                            <p class="mt-2 text-sm font-medium text-white">
                                #{{ $registration->id }}
                            </p>
                        </div>
                    </div>
                </section>

                {{-- Program Schedule --}}
                @if ($event->schedules->isNotEmpty())
                    <section class="rounded-2xl border border-white/10 bg-[#020617] shadow-[0_16px_40px_rgba(0,0,0,0.4)] sm:rounded-3xl">
                        <div class="border-b border-white/10 px-4 py-4 sm:px-5">
                            <h2 class="text-base font-semibold text-white sm:text-lg">Program Schedule</h2>
                            <p class="mt-1 text-sm text-slate-400">
                                Event activities and timeline.
                            </p>
                        </div>

                        <div class="space-y-3 p-4 sm:p-5">
                            @foreach ($event->schedules as $schedule)
                                <div class="rounded-xl border border-white/10 bg-white/5 p-4 sm:rounded-2xl">
                                    <div class="flex flex-col gap-2 sm:flex-row sm:items-start sm:justify-between">
                                        <div class="min-w-0">
                                            <p class="text-sm font-semibold text-white">
                                                {{ $schedule->title }}
                                            </p>
                                            @if ($schedule->description)
                                                <p class="mt-1 text-sm text-slate-400">
                                                    {{ $schedule->description }}
                                                </p>
                                            @endif
                                        </div>

                                        @if ($schedule->schedule_time)
                                            <span class="inline-flex w-fit rounded-full border border-white/10 bg-white/5 px-3 py-1 text-xs text-slate-300">
                                                {{ \Illuminate\Support\Carbon::parse($schedule->schedule_time)->format('h:i A') }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </section>
                @endif

                {{-- Payment Selection --}}
                <section class="rounded-2xl border border-white/10 bg-[#020617] shadow-[0_16px_40px_rgba(0,0,0,0.4)] sm:rounded-3xl">
                    <div class="border-b border-white/10 px-4 py-4 sm:px-5">
                        <h2 class="text-base font-semibold text-white sm:text-lg">Payment Items</h2>
                        <p class="mt-1 text-sm text-slate-400">
                            Base registration comes first. Add-on items unlock only after registration payment is submitted or verified.
                        </p>
                    </div>

                    <div class="space-y-4 p-4 sm:p-5">
                        @php
                            $selectedTarget = (string) ($selectedItemId ?? 'base');
                        @endphp

                        {{-- Base registration fee --}}
                        <label for="payment-target-base"
                               class="block cursor-pointer rounded-xl border border-blue-400/20 bg-blue-500/10 p-4 transition hover:bg-blue-500/15 sm:rounded-2xl {{ $selectedTarget === 'base' ? 'ring-2 ring-blue-500/50' : '' }}">
                            <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
                                <div class="flex gap-3">
                                    <input
                                        id="payment-target-base"
                                        type="radio"
                                        wire:model.live="selectedItemId"
                                        value="base"
                                        wire:key="payment-target-base"
                                        class="mt-1 h-4 w-4 border-slate-500 bg-slate-900 text-blue-500 focus:ring-blue-500"
                                    >

                                    <div>
                                        <div class="flex flex-wrap items-center gap-2">
                                            <p class="text-sm font-semibold text-white">
                                                Event Registration Fee
                                            </p>

                                            @php
                                                $baseBadgeClasses = match($this->basePaymentStatus) {
                                                    'paid' => 'border-emerald-400/20 bg-emerald-400/10 text-emerald-300',
                                                    'pending' => 'border-amber-400/20 bg-amber-400/10 text-amber-300',
                                                    'rejected' => 'border-rose-400/20 bg-rose-400/10 text-rose-300',
                                                    'not_required' => 'border-sky-400/20 bg-sky-400/10 text-sky-300',
                                                    default => 'border-indigo-400/15 bg-indigo-400/10 text-indigo-200',
                                                };

                                                $baseBadgeLabel = match($this->basePaymentStatus) {
                                                    'paid' => 'Verified',
                                                    'pending' => 'Pending',
                                                    'rejected' => 'Rejected',
                                                    'not_required' => 'Not Required',
                                                    default => 'Unpaid',
                                                };
                                            @endphp

                                            <span class="rounded-full border px-2 py-0.5 text-[10px] font-semibold uppercase tracking-wide {{ $baseBadgeClasses }}">
                                                {{ $baseBadgeLabel }}
                                            </span>
                                        </div>

                                        <p class="mt-1 text-sm text-slate-400">
                                            This is the main event registration payment.
                                        </p>
                                    </div>
                                </div>

                                <p class="text-sm font-semibold text-white sm:shrink-0">
                                    ₱{{ number_format($this->baseRegistrationFee / 100, 2) }}
                                </p>
                            </div>
                        </label>

                        {{-- Registration items --}}
                        @forelse ($registrationItems as $item)
                            @php
                                $locked = ! $this->baseRegistrationSatisfied;
                                $itemValue = 'item_' . $item->id;
                            @endphp

                            <label for="payment-target-{{ $item->id }}"
                                   class="block rounded-xl border border-white/10 bg-white/5 p-4 transition sm:rounded-2xl
                                   {{ $locked ? 'cursor-not-allowed opacity-60' : 'cursor-pointer hover:bg-white/10' }}
                                   {{ $selectedTarget === $itemValue ? 'ring-2 ring-blue-500/50 border-blue-400/30' : '' }}">
                                <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
                                    <div class="flex gap-3">
                                        <input
                                            id="payment-target-{{ $item->id }}"
                                            type="radio"
                                            wire:model.live="selectedItemId"
                                            value="{{ $itemValue }}"
                                            wire:key="payment-target-{{ $item->id }}"
                                            @disabled($locked)
                                            class="mt-1 h-4 w-4 border-slate-500 bg-slate-900 text-blue-500 focus:ring-blue-500"
                                        >

                                        <div class="min-w-0">
                                            <div class="flex flex-wrap items-center gap-2">
                                                <p class="text-sm font-semibold text-white">
                                                    {{ $item->name }}
                                                </p>

                                                @if ($item->is_required)
                                                    <span class="rounded-full border border-rose-400/20 bg-rose-400/10 px-2 py-0.5 text-[10px] font-semibold uppercase tracking-wide text-rose-300">
                                                        Required
                                                    </span>
                                                @else
                                                    <span class="rounded-full border border-sky-400/20 bg-sky-400/10 px-2 py-0.5 text-[10px] font-semibold uppercase tracking-wide text-sky-300">
                                                        Optional
                                                    </span>
                                                @endif
                                            </div>

                                            @if ($item->description)
                                                <p class="mt-1 text-sm text-slate-400">
                                                    {{ $item->description }}
                                                </p>
                                            @endif

                                            @if ($item->schedule)
                                                <p class="mt-1 text-xs text-slate-500">
                                                    Linked to {{ $item->schedule->title }}
                                                    @if ($item->schedule->schedule_time)
                                                        • {{ \Illuminate\Support\Carbon::parse($item->schedule->schedule_time)->format('h:i A') }}
                                                    @endif
                                                </p>
                                            @endif

                                            @if ($locked)
                                                <p class="mt-2 text-xs text-amber-300">
                                                    Complete the event registration payment first to unlock this item.
                                                </p>
                                            @endif
                                        </div>
                                    </div>

                                    <p class="text-sm font-semibold text-white sm:shrink-0">
                                        ₱{{ number_format($item->price / 100, 2) }}
                                    </p>
                                </div>
                            </label>
                        @empty
                            <div class="rounded-xl border border-dashed border-white/10 px-4 py-8 text-center sm:rounded-2xl">
                                <p class="text-sm text-slate-400">No additional registration items for this event.</p>
                            </div>
                        @endforelse
                    </div>
                </section>

                {{-- Upload form --}}
                <section class="rounded-2xl border border-white/10 bg-[#020617] shadow-[0_16px_40px_rgba(0,0,0,0.4)] sm:rounded-3xl">
                    <div class="border-b border-white/10 px-4 py-4 sm:px-5">
                        <h2 class="text-base font-semibold text-white sm:text-lg">Upload Proof of Payment</h2>
                        <p class="mt-1 text-sm text-slate-400">
                            Submit one payment proof at a time for the selected item.
                        </p>
                    </div>

                    <div class="p-4 sm:p-5">
                        @if ($this->paymentStatus === 'paid')
                            <div class="rounded-xl border border-emerald-500/20 bg-emerald-500/10 px-4 py-4 text-sm text-emerald-300 sm:rounded-2xl">
                                This payment target is already verified.
                            </div>
                        @elseif ($this->paymentStatus === 'pending')
                            <div class="rounded-xl border border-amber-500/20 bg-amber-500/10 px-4 py-4 text-sm text-amber-300 sm:rounded-2xl">
                                This payment target is already under review. Please wait for admin verification.
                            </div>
                        @elseif ($this->amountDue <= 0)
                            <div class="rounded-xl border border-sky-500/20 bg-sky-500/10 px-4 py-4 text-sm text-sky-300 sm:rounded-2xl">
                                No payment is required for the selected target.
                            </div>
                        @else
                            <form wire:submit.prevent="submitProof" class="space-y-5">
                                <div class="rounded-xl border border-white/10 bg-white/5 p-4 sm:rounded-2xl">
                                    <p class="text-[11px] uppercase tracking-wide text-slate-500">Selected Payment Target</p>
                                    <div class="mt-2 flex items-center justify-between gap-3">
                                        <p class="text-sm font-medium text-white">
                                            {{ $this->selectedLabel }}
                                        </p>
                                        <p class="text-lg font-semibold text-white">
                                            ₱{{ number_format($this->amountDue / 100, 2) }}
                                        </p>
                                    </div>
                                </div>

                                <div>
                                    <label class="mb-1 block text-sm font-medium text-slate-300">
                                        Reference Number <span class="text-slate-500">(optional)</span>
                                    </label>
                                    <input
                                        type="text"
                                        wire:model.defer="reference_number"
                                        placeholder="Enter reference number"
                                        class="w-full rounded-xl border border-white/10 bg-slate-950/70 px-4 py-2.5 text-sm text-white outline-none transition focus:border-blue-400 focus:ring-2 focus:ring-blue-500/20 sm:rounded-2xl"
                                    >
                                    @error('reference_number')
                                        <p class="mt-1 text-sm text-rose-400">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="mb-1 block text-sm font-medium text-slate-300">
                                        Remarks <span class="text-slate-500">(optional)</span>
                                    </label>
                                    <textarea
                                        wire:model.defer="remarks"
                                        rows="4"
                                        placeholder="Add remarks if needed"
                                        class="w-full rounded-xl border border-white/10 bg-slate-950/70 px-4 py-2.5 text-sm text-white outline-none transition focus:border-blue-400 focus:ring-2 focus:ring-blue-500/20 sm:rounded-2xl"
                                    ></textarea>
                                    @error('remarks')
                                        <p class="mt-1 text-sm text-rose-400">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="mb-1 block text-sm font-medium text-slate-300">
                                        Proof of Payment
                                    </label>
                                    <input
                                        type="file"
                                        wire:model="proof"
                                        accept=".jpg,.jpeg,.png,.pdf"
                                        class="block w-full rounded-xl border border-white/10 bg-slate-950/70 px-4 py-3 text-sm text-white file:mr-4 file:rounded-xl file:border-0 file:bg-[#1E3A8A] file:px-4 file:py-2 file:text-sm file:font-semibold file:text-white hover:file:bg-[#2746c7] sm:rounded-2xl"
                                    >
                                    <p class="mt-2 text-xs text-slate-500">
                                        Accepted formats: JPG, JPEG, PNG, PDF. Max size: 5MB.
                                    </p>

                                    <div wire:loading wire:target="proof" class="mt-2 text-sm text-blue-400">
                                        Uploading file...
                                    </div>

                                    @error('proof')
                                        <p class="mt-1 text-sm text-rose-400">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="border-t border-white/10 pt-5">
                                    <button
                                        type="submit"
                                        @disabled(! $this->canSubmit)
                                        class="inline-flex w-full items-center justify-center rounded-xl bg-[#1E3A8A] px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-[#2746c7] disabled:cursor-not-allowed disabled:opacity-50 sm:w-auto sm:rounded-2xl"
                                    >
                                        Submit Proof
                                    </button>
                                </div>
                            </form>
                        @endif
                    </div>
                </section>
            </div>

            {{-- RIGHT --}}
            <div class="space-y-4 sm:space-y-6">

                {{-- Registration status --}}
                <section class="rounded-2xl border border-white/10 bg-[#020617] shadow-[0_16px_40px_rgba(0,0,0,0.4)] sm:rounded-3xl">
                    <div class="border-b border-white/10 px-4 py-4 sm:px-5">
                        <h2 class="text-base font-semibold text-white sm:text-lg">Registration Status</h2>
                    </div>

                    <div class="grid gap-3 p-4 sm:p-5">
                        <div class="rounded-xl border border-white/10 bg-white/5 p-4 sm:rounded-2xl">
                            <p class="text-[11px] uppercase tracking-wide text-slate-500">Registration ID</p>
                            <p class="mt-2 text-sm font-medium text-white">#{{ $registration->id }}</p>
                        </div>

                        <div class="rounded-xl border border-white/10 bg-white/5 p-4 sm:rounded-2xl">
                            <p class="text-[11px] uppercase tracking-wide text-slate-500">Base Registration Payment</p>
                            <p class="mt-2 text-sm font-medium text-white">
                                {{ str($this->basePaymentStatus)->replace('_', ' ')->headline() }}
                            </p>
                        </div>

                        <div class="rounded-xl border border-white/10 bg-white/5 p-4 sm:rounded-2xl">
                            <p class="text-[11px] uppercase tracking-wide text-slate-500">Selected Target Status</p>
                            <p class="mt-2 text-sm font-medium text-white">
                                {{ str($this->paymentStatus)->replace('_', ' ')->headline() }}
                            </p>
                        </div>

                        <div class="rounded-xl border border-white/10 bg-white/5 p-4 sm:rounded-2xl">
                            <p class="text-[11px] uppercase tracking-wide text-slate-500">Current Target</p>
                            <p class="mt-2 text-sm font-medium text-white">
                                {{ $this->selectedLabel }}
                            </p>
                        </div>

                        <div class="rounded-xl border border-white/10 bg-white/5 p-4 sm:rounded-2xl">
                            <p class="text-[11px] uppercase tracking-wide text-slate-500">Amount Due</p>
                            <p class="mt-2 text-lg font-semibold text-white">
                                ₱{{ number_format($this->amountDue / 100, 2) }}
                            </p>
                        </div>
                    </div>
                </section>

                {{-- Payment instructions --}}
                <section class="rounded-2xl border border-white/10 bg-gradient-to-br from-[#1E3A8A]/20 to-sky-500/10 p-5 shadow-[0_16px_40px_rgba(0,0,0,0.35)] sm:rounded-3xl sm:p-6">
                    <h2 class="text-base font-semibold text-white sm:text-lg">Payment Instructions</h2>
                    <p class="mt-2 text-sm leading-6 text-slate-300">
                        Use the official payment channel provided by the organizers, then upload a clear proof of payment.
                    </p>

                    <div class="mt-5 space-y-3 text-sm">
                        <div class="rounded-xl border border-white/10 bg-black/30 p-4 text-slate-200 sm:rounded-2xl">
                            <p class="text-slate-400">GCash</p>
                            <p class="mt-1 font-medium">09XX-XXX-XXXX</p>
                        </div>

                        <div class="rounded-xl border border-white/10 bg-black/30 p-4 text-slate-200 sm:rounded-2xl">
                            <p class="text-slate-400">Account Name</p>
                            <p class="mt-1 font-medium">Holy Spirit School Alumni Association</p>
                        </div>

                        <div class="rounded-xl border border-white/10 bg-black/30 p-4 text-slate-200 sm:rounded-2xl">
                            <p class="text-slate-400">Reminder</p>
                            <p class="mt-1">
                                Use the exact amount and make sure the uploaded proof is clear and readable.
                            </p>
                        </div>
                    </div>
                </section>

                {{-- Payment history --}}
                <section class="rounded-2xl border border-white/10 bg-[#020617] shadow-[0_16px_40px_rgba(0,0,0,0.4)] sm:rounded-3xl">
                    <div class="border-b border-white/10 px-4 py-4 sm:px-5">
                        <h2 class="text-base font-semibold text-white sm:text-lg">Payment History</h2>
                    </div>

                    <div class="space-y-3 p-4 sm:p-5">
                        @forelse ($paymentHistory as $history)
                            <div class="rounded-xl border border-white/10 bg-white/5 p-4 sm:rounded-2xl">
                                <div class="flex flex-col gap-2 sm:flex-row sm:items-start sm:justify-between">
                                    <div class="min-w-0">
                                        <p class="text-sm font-medium text-white">
                                            {{ $history->registrationItem?->name ?? 'Event Registration Fee' }}
                                        </p>
                                        <p class="mt-1 text-xs text-slate-500">
                                            {{ optional($history->created_at)->format('M d, Y • h:i A') }}
                                        </p>
                                    </div>

                                    <div class="text-left sm:text-right">
                                        <p class="text-sm font-semibold text-white">
                                            ₱{{ number_format($history->amount / 100, 2) }}
                                        </p>
                                        <p class="mt-1 text-xs text-slate-400">
                                            {{ str($history->status)->headline() }}
                                        </p>
                                    </div>
                                </div>

                                @if ($history->reference_number)
                                    <p class="mt-2 text-xs text-slate-400">
                                        Ref #: {{ $history->reference_number }}
                                    </p>
                                @endif

                                @if ($history->remarks)
                                    <p class="mt-2 text-xs text-slate-500">
                                        {{ $history->remarks }}
                                    </p>
                                @endif
                            </div>
                        @empty
                            <div class="rounded-xl border border-dashed border-white/10 px-4 py-8 text-center sm:rounded-2xl">
                                <p class="text-sm text-slate-400">No payment submissions yet.</p>
                            </div>
                        @endforelse
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>