<div>
  <div class="max-w-4xl mx-auto">
        <div>
            <flux:heading size="lg">Create Event</flux:heading>
            <flux:subheading>Add a new reunion event for alumni registration.</flux:subheading>
        </div>

        {{-- Success / Error (simple, compatible with free Flux) --}}
        @if (session()->has('success'))
            <div class="rounded-lg border p-4 text-sm">
                {{ session('success') }}
            </div>
        @endif

        @if (session()->has('error'))
            <div class="rounded-lg border p-4 text-sm">
                {{ session('error') }}
            </div>
        @endif

       <form class="space-y-5" wire:submit.prevent="save">
    {{-- Success flash --}}
    @if (session('status'))
        <div class="rounded-lg border p-4">
            <flux:text class="font-medium !text-green-600 !dark:text-green-400">
                {{ session('status') }}
            </flux:text>
        </div>
    @endif

    <div class="space-y-1">
        <flux:input
            label="Title"
            placeholder="e.g., Alumni Grand Reunion 2026"
            wire:model.defer="title"
        />
        @error('title') <p class="text-sm text-red-500">{{ $message }}</p> @enderror
    </div>
 <div class="space-y-1">
        <flux:input
            label="Dress Code"
            placeholder="Formal or Semi-Fornal"
            wire:model.defer="dress_code"
        />
        @error('title') <p class="text-sm text-red-500">{{ $message }}</p> @enderror
    </div>
    <div class="space-y-1">
        <flux:input
            label="Venue"
            placeholder="e.g., School Gymnasium"
            wire:model.defer="venue"
        />
        @error('venue') <p class="text-sm text-red-500">{{ $message }}</p> @enderror
    </div>

    <div class="space-y-1">
        <flux:input
            label="Event Date & Time"
            type="datetime-local"
            wire:model.defer="event_date"
        />
        <p class="text-xs opacity-70">Use your local time. (Example: 2026-05-01 18:00)</p>
        @error('event_date') <p class="text-sm text-red-500">{{ $message }}</p> @enderror
    </div>

    <div class="space-y-1">
        <flux:input
            label="Registration Fee (₱)"
            type="number"
            min="0"
            step="1"
            placeholder="e.g., 300"
            wire:model.defer="registration_fee"
        />
        <p class="text-xs opacity-70">Enter amount in pesos. (Stored as centavos in DB.)</p>
        @error('registration_fee') <p class="text-sm text-red-500">{{ $message }}</p> @enderror
    </div>

    <div class="space-y-1">
        <flux:textarea
            label="Description (optional)"
            rows="4"
            placeholder="Include program details, dress code, reminders, etc."
            wire:model.defer="description"
        />
        @error('description') <p class="text-sm text-red-500">{{ $message }}</p> @enderror
    </div>

    {{-- Active toggle --}}
    <div class="rounded-lg border p-4">
        <div class="flex items-center justify-between gap-4">
            <div>
                <p class="text-sm font-medium">Active</p>
                <p class="text-xs opacity-70">If disabled, alumni won’t see this event.</p>
            </div>

            <label class="inline-flex items-center gap-2">
                <input type="checkbox" wire:model.defer="is_active" class="rounded">
                <span class="text-sm">Enabled</span>
            </label>
        </div>

        @error('is_active') <p class="mt-2 text-sm text-red-500">{{ $message }}</p> @enderror
    </div>

    {{-- Actions --}}
    <div class="flex items-center justify-end gap-3">
        <flux:button type="button" wire:click="resetForm" wire:loading.attr="disabled">
            Reset
        </flux:button>

        <flux:button type="submit" variant="primary" wire:loading.attr="disabled">
            <span wire:loading.remove>Save Event</span>
            <span wire:loading>Saving...</span>
        </flux:button>
    </div>
</form>
</div>
</div>