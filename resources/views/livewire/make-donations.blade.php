<div>
    @if (session('info'))
    <div class="rounded-lg border p-4 text-sm">
        {{ session('info') }}
    </div>
@endif
  <div class="max-w-2xl mx-auto p-6">
        <div>
            <flux:heading size="lg">Make a Donation</flux:heading>
            <flux:subheading>Support the alumni reunion program.</flux:subheading>
        </div>

        @if (session()->has('success'))
            <div class="rounded-lg border p-4 text-sm">
                {{ session('success') }}
            </div>
        @endif

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
                @error('amount') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
            </div>

            <div>
                <flux:textarea
                    label="Remarks (optional)"
                    rows="4"
                    placeholder="Leave a short message…"
                    wire:model.defer="remarks"
                />
                @error('remarks') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
            </div>

            <div class="flex items-center gap-3">
                <div class="flex-1"></div>

                <flux:button type="button" wire:click="resetForm">
                    Reset
                </flux:button>

            <flux:button
                type="submit"
                variant="primary"
                :disabled="is_null(auth()->user()->alumni_id)"
            >
                Submit Donation
            </flux:button>

            @if(is_null(auth()->user()->alumni_id))
                <p class="mt-2 text-sm text-zinc-500">
                    Please complete your profile and verify your Alumni record before donating.
                </p>
            @endif
            </div>
        </form>
</div>
</div>
