<div>
    <div class="mx-auto max-w-4xl space-y-6">
        {{-- Page Header --}}
        <div class="flex flex-col gap-2">
            <flux:heading size="lg" class="!text-zinc-900 dark:!text-white">
                Create Event
            </flux:heading>
            <flux:subheading class="!text-zinc-600 dark:!text-zinc-400">
                Add a new reunion event for alumni registration.
            </flux:subheading>
        </div>

        {{-- Flash Messages --}}
        @if (session()->has('success'))
            <div class="rounded-2xl border border-emerald-500/20 bg-emerald-500/10 p-4 text-sm text-emerald-700 dark:text-emerald-400">
                {{ session('success') }}
            </div>
        @endif

        @if (session()->has('error'))
            <div class="rounded-2xl border border-red-500/20 bg-red-500/10 p-4 text-sm text-red-700 dark:text-red-400">
                {{ session('error') }}
            </div>
        @endif

        @if (session('status'))
            <div class="rounded-2xl border border-emerald-500/20 bg-emerald-500/10 p-4">
                <flux:text class="font-medium !text-emerald-700 dark:!text-emerald-400">
                    {{ session('status') }}
                </flux:text>
            </div>
        @endif

        {{-- Form Card --}}
        <div class="rounded-3xl border border-zinc-200 bg-white p-6 shadow-sm dark:border-zinc-800 dark:bg-zinc-900">
            <form class="space-y-6" wire:submit.prevent="save">
                {{-- Basic Information --}}
                <div class="space-y-5">
                    <div>
                        <h2 class="text-sm font-semibold uppercase tracking-wide text-zinc-500 dark:text-zinc-400">
                            Basic Information
                        </h2>
                    </div>

                    <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                        <div class="space-y-1 md:col-span-2">
                            <flux:input
                                label="Title"
                                placeholder="e.g., Alumni Grand Reunion 2026"
                                wire:model.defer="title"
                            />
                            @error('title')
                                <p class="text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-1">
                            <flux:input
                                label="Venue"
                                placeholder="e.g., School Gymnasium"
                                wire:model.defer="venue"
                            />
                            @error('venue')
                                <p class="text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-1">
                            <flux:input
                                label="Dress Code"
                                placeholder="e.g., Formal or Semi-Formal"
                                wire:model.defer="dress_code"
                            />
                            @error('dress_code')
                                <p class="text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Schedule & Fee --}}
                <div class="space-y-5 border-t border-zinc-200 pt-6 dark:border-zinc-800">
                    <div>
                        <h2 class="text-sm font-semibold uppercase tracking-wide text-zinc-500 dark:text-zinc-400">
                            Schedule & Registration
                        </h2>
                    </div>

                    <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                        <div class="space-y-1">
                            <flux:input
                                label="Event Date & Time"
                                type="datetime-local"
                                wire:model.defer="event_date"
                            />
                            <p class="text-xs text-zinc-500 dark:text-zinc-400">
                                Use your local time. Example: 2026-05-01 18:00
                            </p>
                            @error('event_date')
                                <p class="text-sm text-red-500">{{ $message }}</p>
                            @enderror
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
                            <p class="text-xs text-zinc-500 dark:text-zinc-400">
                                Enter the amount in pesos. Stored as centavos in the database.
                            </p>
                            @error('registration_fee')
                                <p class="text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Description --}}
                <div class="space-y-5 border-t border-zinc-200 pt-6 dark:border-zinc-800">
                    <div>
                        <h2 class="text-sm font-semibold uppercase tracking-wide text-zinc-500 dark:text-zinc-400">
                            Additional Details
                        </h2>
                    </div>

                    <div class="space-y-1">
                        <flux:textarea
                            label="Description"
                            rows="5"
                            placeholder="Include program details, dress code, reminders, payment notes, or other important event information."
                            wire:model.defer="description"
                        />
                        @error('description')
                            <p class="text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Visibility --}}
                <div class="space-y-5 border-t border-zinc-200 pt-6 dark:border-zinc-800">
                    <div class="rounded-2xl border border-zinc-200 bg-zinc-50 p-4 dark:border-zinc-800 dark:bg-zinc-950/50">
                        <div class="flex items-center justify-between gap-4">
                            <div>
                                <p class="text-sm font-semibold text-zinc-900 dark:text-zinc-100">
                                    Active Event
                                </p>
                                <p class="mt-1 text-xs text-zinc-500 dark:text-zinc-400">
                                    If disabled, alumni will not see this event in the registration list.
                                </p>
                            </div>

                            <label class="inline-flex items-center gap-2">
                                <input
                                    type="checkbox"
                                    wire:model.defer="is_active"
                                    class="rounded border-zinc-300 text-teal-600 focus:ring-teal-500 dark:border-zinc-700 dark:bg-zinc-900"
                                >
                                <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">
                                    Enabled
                                </span>
                            </label>
                        </div>

                        @error('is_active')
                            <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Actions --}}
                <div class="flex flex-col-reverse gap-3 border-t border-zinc-200 pt-6 sm:flex-row sm:items-center sm:justify-end dark:border-zinc-800">
                    <flux:button
                        type="button"
                        wire:click="resetForm"
                        wire:loading.attr="disabled"
                        class="w-full sm:w-auto"
                    >
                        Reset
                    </flux:button>

                    <flux:button
                        type="submit"
                        variant="primary"
                        wire:loading.attr="disabled"
                        class="w-full sm:w-auto"
                    >
                        <span wire:loading.remove>Save Event</span>
                        <span wire:loading>Saving...</span>
                    </flux:button>
                </div>
            </form>
        </div>
    </div>
</div>