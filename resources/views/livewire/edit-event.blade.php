<div>
    <div class="mx-auto max-w-4xl space-y-6">
        <div>
            <h1 class="text-xl font-semibold text-zinc-900 dark:text-zinc-100">Edit Event</h1>
            <p class="mt-1 text-sm text-zinc-600 dark:text-zinc-400">Update event details and visibility.</p>
        </div>

        @if (session('status'))
            <div class="rounded-xl border border-zinc-200 bg-white p-4 dark:border-zinc-700 dark:bg-zinc-900">
                <p class="text-sm font-medium text-green-600 dark:text-green-400">{{ session('status') }}</p>
            </div>
        @endif

        <div class="grid gap-6 lg:grid-cols-[1.1fr_.9fr]">
            <div class="rounded-2xl border border-zinc-200 bg-white p-6 shadow-sm dark:border-zinc-700 dark:bg-zinc-900">
                <form wire:submit.prevent="update" class="space-y-5">
                    <div class="space-y-1">
                        <label class="text-xs font-medium text-zinc-600 dark:text-zinc-400">Title</label>
                        <input wire:model.defer="title"
                               class="w-full rounded-lg border border-zinc-200 bg-white px-3 py-2 text-sm text-zinc-900 dark:border-zinc-700 dark:bg-zinc-900 dark:text-zinc-100" />
                        @error('title') <p class="text-sm text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <div class="space-y-1">
                        <label class="text-xs font-medium text-zinc-600 dark:text-zinc-400">Venue</label>
                        <input wire:model.defer="venue"
                               class="w-full rounded-lg border border-zinc-200 bg-white px-3 py-2 text-sm text-zinc-900 dark:border-zinc-700 dark:bg-zinc-900 dark:text-zinc-100" />
                        @error('venue') <p class="text-sm text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <div class="space-y-1">
                        <label class="text-xs font-medium text-zinc-600 dark:text-zinc-400">Event Date & Time</label>
                        <input type="datetime-local" wire:model.defer="event_date"
                               class="w-full rounded-lg border border-zinc-200 bg-white px-3 py-2 text-sm text-zinc-900 dark:border-zinc-700 dark:bg-zinc-900 dark:text-zinc-100" />
                        @error('event_date') <p class="text-sm text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <div class="space-y-1">
                        <label class="text-xs font-medium text-zinc-600 dark:text-zinc-400">Registration Fee (₱)</label>
                        <input type="number" min="0" step="1" wire:model.defer="registration_fee"
                               class="w-full rounded-lg border border-zinc-200 bg-white px-3 py-2 text-sm text-zinc-900 dark:border-zinc-700 dark:bg-zinc-900 dark:text-zinc-100" />
                        @error('registration_fee') <p class="text-sm text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <div class="space-y-1">
                        <label class="text-xs font-medium text-zinc-600 dark:text-zinc-400">Description (optional)</label>
                        <textarea rows="4" wire:model.defer="description"
                                  class="w-full rounded-lg border border-zinc-200 bg-white px-3 py-2 text-sm text-zinc-900 dark:border-zinc-700 dark:bg-zinc-900 dark:text-zinc-100"></textarea>
                        @error('description') <p class="text-sm text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <div class="flex items-center justify-between rounded-xl border border-zinc-200 p-4 dark:border-zinc-700">
                        <div>
                            <p class="text-sm font-medium text-zinc-900 dark:text-zinc-100">Active</p>
                            <p class="text-xs text-zinc-600 dark:text-zinc-400">If disabled, alumni won’t see this event.</p>
                        </div>

                        <label class="inline-flex items-center gap-2">
                            <input type="checkbox" wire:model.defer="is_active" class="rounded">
                            <span class="text-sm text-zinc-900 dark:text-zinc-100">Enabled</span>
                        </label>
                    </div>

                    <div class="flex items-center justify-end gap-3">
                        <a href="{{ route('event-view') }}"
                           class="rounded-lg border border-zinc-200 px-4 py-2 text-sm font-medium text-zinc-900 hover:bg-zinc-50 dark:border-zinc-700 dark:text-zinc-100 dark:hover:bg-zinc-800/40"
                           wire:navigate>
                            Back
                        </a>

                        <button type="submit"
                                class="rounded-lg bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-700"
                                wire:loading.attr="disabled">
                            <span wire:loading.remove>Save Changes</span>
                            <span wire:loading>Saving...</span>
                        </button>
                    </div>
                </form>
            </div>

            <div class="rounded-2xl border border-zinc-200 bg-white p-6 shadow-sm dark:border-zinc-700 dark:bg-zinc-900">
                <div class="flex items-start justify-between gap-3">
                    <div>
                        <h2 class="text-lg font-semibold text-zinc-900 dark:text-zinc-100">Program Schedule</h2>
                        <p class="mt-1 text-sm text-zinc-600 dark:text-zinc-400">
                            Add the timeline for this event.
                        </p>
                    </div>

                    <button type="button"
                            wire:click="addScheduleRow"
                            class="rounded-lg bg-indigo-600 px-3 py-2 text-xs font-medium text-white hover:bg-indigo-700">
                        + Add Item
                    </button>
                </div>

                <div class="mt-5 space-y-4">
                    @forelse($scheduleRows as $index => $row)
                        <div class="rounded-xl border border-zinc-200 p-4 dark:border-zinc-700">
                            <div class="grid gap-3">
                                <div class="grid gap-3 sm:grid-cols-2">
                                    <div class="space-y-1">
                                        <label class="text-xs font-medium text-zinc-600 dark:text-zinc-400">Time</label>
                                        <input type="time"
                                               wire:model.defer="scheduleRows.{{ $index }}.schedule_time"
                                               class="w-full rounded-lg border border-zinc-200 bg-white px-3 py-2 text-sm text-zinc-900 dark:border-zinc-700 dark:bg-zinc-900 dark:text-zinc-100">
                                    </div>

                                    <div class="space-y-1">
                                        <label class="text-xs font-medium text-zinc-600 dark:text-zinc-400">Title</label>
                                        <input type="text"
                                               wire:model.defer="scheduleRows.{{ $index }}.title"
                                               class="w-full rounded-lg border border-zinc-200 bg-white px-3 py-2 text-sm text-zinc-900 dark:border-zinc-700 dark:bg-zinc-900 dark:text-zinc-100">
                                    </div>
                                </div>

                                <div class="space-y-1">
                                    <label class="text-xs font-medium text-zinc-600 dark:text-zinc-400">Description</label>
                                    <textarea rows="2"
                                              wire:model.defer="scheduleRows.{{ $index }}.description"
                                              class="w-full rounded-lg border border-zinc-200 bg-white px-3 py-2 text-sm text-zinc-900 dark:border-zinc-700 dark:bg-zinc-900 dark:text-zinc-100"></textarea>
                                </div>

                                <div class="flex items-center justify-between">
                                    <div class="w-28 space-y-1">
                                        <label class="text-xs font-medium text-zinc-600 dark:text-zinc-400">Order</label>
                                        <input type="number"
                                               min="0"
                                               wire:model.defer="scheduleRows.{{ $index }}.sort_order"
                                               class="w-full rounded-lg border border-zinc-200 bg-white px-3 py-2 text-sm text-zinc-900 dark:border-zinc-700 dark:bg-zinc-900 dark:text-zinc-100">
                                    </div>

                                    <button type="button"
                                            wire:click="removeScheduleRow({{ $index }})"
                                            class="rounded-lg border border-red-200 px-3 py-2 text-sm font-medium text-red-600 hover:bg-red-50 dark:border-red-900/40 dark:text-red-400 dark:hover:bg-red-950/20">
                                        Remove
                                    </button>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="rounded-xl border border-dashed border-zinc-300 p-6 text-center dark:border-zinc-700">
                            <p class="text-sm text-zinc-600 dark:text-zinc-400">No schedule items yet.</p>
                        </div>
                    @endforelse
                </div>

                <div class="mt-5 flex justify-end">
                    <button type="button"
                            wire:click="saveSchedules"
                            class="rounded-lg bg-zinc-900 px-4 py-2 text-sm font-medium text-white hover:bg-zinc-800 dark:bg-zinc-100 dark:text-zinc-900 dark:hover:bg-zinc-200">
                        Save Schedule
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>