  <div class="mx-auto max-w-7xl space-y-6 px-6 py-6">
        {{-- Page Header --}}
        <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-indigo-600 dark:text-indigo-400">
                    Event Management
                </p>
                <h1 class="mt-1 text-2xl font-bold tracking-tight text-zinc-900 dark:text-white">
                    Edit Event
                </h1> 
                <p class="mt-1 text-sm text-zinc-600 dark:text-zinc-400">
                    Update event details, manage the program schedule, and configure paid registration items.
                </p>
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('event-view') }}"
                   class="inline-flex items-center rounded-xl border border-zinc-200 bg-white px-4 py-2 text-sm font-medium text-zinc-700 transition hover:bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900 dark:text-zinc-200 dark:hover:bg-zinc-800/70"
                   wire:navigate>
                    Back to Events
                </a>
            </div>
        </div>

        {{-- Toast --}}
        <div class="fixed bottom-4 right-4 z-50 w-full max-w-sm">
            @if (session('status'))
                <x-toast />
            @endif
        </div>

        {{-- Main Grid --}}
        <div class="grid gap-6 xl:grid-cols-[1.05fr_.95fr]">
            {{-- Left Column: Event Details --}}
            <section class="rounded-3xl border border-zinc-200 bg-white shadow-sm dark:border-zinc-800 dark:bg-zinc-900">
                <div class="border-b border-zinc-200 px-6 py-5 dark:border-zinc-800">
                    <h2 class="text-lg font-semibold text-zinc-900 dark:text-white">Event Details</h2>
                    <p class="mt-1 text-sm text-zinc-600 dark:text-zinc-400">
                        Basic information alumni will see when browsing the event.
                    </p>
                </div>

                <form wire:submit.prevent="update" class="space-y-5 p-6">
                    <div class="grid gap-5 md:grid-cols-2">
                        <div class="space-y-1.5 md:col-span-2">
                            <label class="text-xs font-semibold uppercase tracking-wide text-zinc-500 dark:text-zinc-400">
                                Title
                            </label>
                            <input
                                wire:model.defer="title"
                                type="text"
                                class="w-full rounded-xl border border-zinc-200 bg-white px-4 py-2.5 text-sm text-zinc-900 shadow-sm outline-none transition placeholder:text-zinc-400 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-100 dark:placeholder:text-zinc-500"
                                placeholder="Enter event title" />
                            @error('title') <p class="text-sm text-rose-500">{{ $message }}</p> @enderror
                        </div>

                        <div class="space-y-1.5">
                            <label class="text-xs font-semibold uppercase tracking-wide text-zinc-500 dark:text-zinc-400">
                                Dress Code
                            </label>
                            <input
                                wire:model.defer="dress_code"
                                type="text"
                                class="w-full rounded-xl border border-zinc-200 bg-white px-4 py-2.5 text-sm text-zinc-900 shadow-sm outline-none transition placeholder:text-zinc-400 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-100 dark:placeholder:text-zinc-500"
                                placeholder="e.g. Formal Attire" />
                            @error('dress_code') <p class="text-sm text-rose-500">{{ $message }}</p> @enderror
                        </div>

                        <div class="space-y-1.5">
                            <label class="text-xs font-semibold uppercase tracking-wide text-zinc-500 dark:text-zinc-400">
                                Venue
                            </label>
                            <input
                                wire:model.defer="venue"
                                type="text"
                                class="w-full rounded-xl border border-zinc-200 bg-white px-4 py-2.5 text-sm text-zinc-900 shadow-sm outline-none transition placeholder:text-zinc-400 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-100 dark:placeholder:text-zinc-500"
                                placeholder="Enter venue" />
                            @error('venue') <p class="text-sm text-rose-500">{{ $message }}</p> @enderror
                        </div>

                        <div class="space-y-1.5">
                            <label class="text-xs font-semibold uppercase tracking-wide text-zinc-500 dark:text-zinc-400">
                                Event Date & Time
                            </label>
                            <input
                                type="datetime-local"
                                wire:model.defer="event_date"
                                class="w-full rounded-xl border border-zinc-200 bg-white px-4 py-2.5 text-sm text-zinc-900 shadow-sm outline-none transition focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-100" />
                            @error('event_date') <p class="text-sm text-rose-500">{{ $message }}</p> @enderror
                        </div>

                        <div class="space-y-1.5">
                            <label class="text-xs font-semibold uppercase tracking-wide text-zinc-500 dark:text-zinc-400">
                                Registration Fee (₱)
                            </label>
                            <input
                                type="number"
                                min="0"
                                step="1"
                                wire:model.defer="registration_fee"
                                class="w-full rounded-xl border border-zinc-200 bg-white px-4 py-2.5 text-sm text-zinc-900 shadow-sm outline-none transition placeholder:text-zinc-400 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-100 dark:placeholder:text-zinc-500"
                                placeholder="0" />
                            @error('registration_fee') <p class="text-sm text-rose-500">{{ $message }}</p> @enderror
                        </div>
                        <div class="space-y-1.5 md:col-span-2">
                            <label class="text-xs font-semibold uppercase tracking-wide text-zinc-500 dark:text-zinc-400">
                                Event Banner
                            </label>

                            {{-- current banner --}}
                            @if ($event->banner_image && !$new_banner_image && !$remove_banner_image)
                                <div class="overflow-hidden rounded-2xl border border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-950">
                                    <img
                                        src="{{ Storage::disk('s3')->url($event->banner_image) }}"
                                        alt="{{ $title ?: $event->title }}"
                                        class="h-56 w-full object-cover"
                                    >
                                </div>
                            @endif

                            {{-- new uploaded preview --}}
                            @if ($new_banner_image)
                                <div class="overflow-hidden rounded-2xl border border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-950">
                                    <img
                                        src="{{ $new_banner_image->temporaryUrl() }}"
                                        alt="New banner preview"
                                        class="h-56 w-full object-cover"
                                    >
                                </div>
                            @endif

                            <input
                                type="file"
                                wire:model="new_banner_image"
                                accept="image/png,image/jpeg,image/jpg,image/webp"
                                class="w-full rounded-xl border border-zinc-200 bg-white px-4 py-2.5 text-sm text-zinc-900 shadow-sm outline-none transition file:mr-3 file:rounded-lg file:border-0 file:bg-indigo-600 file:px-4 file:py-2 file:text-sm file:font-medium file:text-white hover:file:bg-indigo-700 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-100"
                            />

                            <div wire:loading wire:target="new_banner_image" class="text-sm text-indigo-600">
                                Uploading banner...
                            </div>

                            @error('new_banner_image')
                                <p class="text-sm text-rose-500">{{ $message }}</p>
                            @enderror

                            @if ($event->banner_image)
                                <label class="inline-flex items-center gap-3 pt-1">
                                    <input
                                        type="checkbox"
                                        wire:model="remove_banner_image"
                                        class="h-4 w-4 rounded border-zinc-300 text-rose-600 focus:ring-rose-500 dark:border-zinc-600 dark:bg-zinc-900"
                                    >
                                    <span class="text-sm text-zinc-700 dark:text-zinc-300">
                                        Remove current banner
                                    </span>
                                </label>
                            @endif

                            <p class="text-xs text-zinc-500 dark:text-zinc-400">
                                Accepted: JPG, PNG, WEBP. Max: 2MB.
                            </p>
                        </div>
                        <div class="space-y-1.5 md:col-span-2">
                            <label class="text-xs font-semibold uppercase tracking-wide text-zinc-500 dark:text-zinc-400">
                                Description
                            </label>
                            <textarea
                                rows="5"
                                wire:model.defer="description"
                                class="w-full rounded-xl border border-zinc-200 bg-white px-4 py-3 text-sm text-zinc-900 shadow-sm outline-none transition placeholder:text-zinc-400 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-100 dark:placeholder:text-zinc-500"
                                placeholder="Add a short description for this event"></textarea>
                            @error('description') <p class="text-sm text-rose-500">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="flex items-center justify-between rounded-2xl border border-zinc-200 bg-zinc-50/70 px-4 py-4 dark:border-zinc-800 dark:bg-zinc-950/60">
                        <div>
                            <p class="text-sm font-semibold text-zinc-900 dark:text-zinc-100">Event Visibility</p>
                            <p class="mt-1 text-xs text-zinc-600 dark:text-zinc-400">
                                Disable this if you want to hide the event from alumni.
                            </p>
                        </div>

                        <label class="inline-flex items-center gap-3">
                            <input
                                type="checkbox"
                                wire:model.defer="is_active"
                                class="h-4 w-4 rounded border-zinc-300 text-indigo-600 focus:ring-indigo-500 dark:border-zinc-600 dark:bg-zinc-900">
                            <span class="text-sm font-medium text-zinc-800 dark:text-zinc-200">Enabled</span>
                        </label>
                    </div>

                    <div class="flex flex-col-reverse gap-3 border-t border-zinc-200 pt-5 sm:flex-row sm:justify-end dark:border-zinc-800">
                        <a href="{{ route('event-view') }}"
                           class="inline-flex items-center justify-center rounded-xl border border-zinc-200 bg-white px-4 py-2.5 text-sm font-medium text-zinc-700 transition hover:bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900 dark:text-zinc-200 dark:hover:bg-zinc-800/70"
                           wire:navigate>
                            Cancel
                        </a>

                        <button
                            type="submit"
                            class="inline-flex items-center justify-center rounded-xl bg-indigo-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-700 disabled:cursor-not-allowed disabled:opacity-70"
                            wire:loading.attr="disabled">
                            <span wire:loading.remove wire:target="update">Save Changes</span>
                            <span wire:loading wire:target="update">Saving...</span>
                        </button>
                    </div>
                </form>
            </section>

            {{-- Right Column --}}
            <div class="space-y-6">
                {{-- Program Schedule --}}
                <section class="rounded-3xl border border-zinc-200 bg-white shadow-sm dark:border-zinc-800 dark:bg-zinc-900">
                    <div class="flex items-start justify-between gap-4 border-b border-zinc-200 px-6 py-5 dark:border-zinc-800">
                        <div>
                            <h2 class="text-lg font-semibold text-zinc-900 dark:text-white">Program Schedule</h2>
                            <p class="mt-1 text-sm text-zinc-600 dark:text-zinc-400">
                                Add the event timeline and activity flow.
                            </p>
                        </div>

                        <button
                            type="button"
                            wire:click="addScheduleRow"
                            class="inline-flex items-center rounded-xl bg-indigo-600 px-3.5 py-2 text-xs font-semibold text-white transition hover:bg-indigo-700">
                            + Add Item
                        </button>
                    </div>

                    <div class="space-y-4 p-6">
                        @forelse($scheduleRows as $index => $row)
                            <div class="rounded-2xl border border-zinc-200 bg-zinc-50/60 p-4 dark:border-zinc-800 dark:bg-zinc-950/50">
                                <div class="grid gap-4">
                                    <div class="grid gap-4 sm:grid-cols-2">
                                        <div class="space-y-1.5">
                                            <label class="text-xs font-semibold uppercase tracking-wide text-zinc-500 dark:text-zinc-400">
                                                Time
                                            </label>
                                            <input
                                                type="time"
                                                wire:model.defer="scheduleRows.{{ $index }}.schedule_time"
                                                class="w-full rounded-xl border border-zinc-200 bg-white px-4 py-2.5 text-sm text-zinc-900 shadow-sm outline-none transition focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 dark:border-zinc-700 dark:bg-zinc-900 dark:text-zinc-100">
                                        </div>

                                        <div class="space-y-1.5">
                                            <label class="text-xs font-semibold uppercase tracking-wide text-zinc-500 dark:text-zinc-400">
                                                Title
                                            </label>
                                            <input
                                                type="text"
                                                wire:model.defer="scheduleRows.{{ $index }}.title"
                                                class="w-full rounded-xl border border-zinc-200 bg-white px-4 py-2.5 text-sm text-zinc-900 shadow-sm outline-none transition placeholder:text-zinc-400 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 dark:border-zinc-700 dark:bg-zinc-900 dark:text-zinc-100 dark:placeholder:text-zinc-500"
                                                placeholder="e.g. Gala Dinner">
                                        </div>
                                    </div>

                                    <div class="space-y-1.5">
                                        <label class="text-xs font-semibold uppercase tracking-wide text-zinc-500 dark:text-zinc-400">
                                            Description
                                        </label>
                                        <textarea
                                            rows="3"
                                            wire:model.defer="scheduleRows.{{ $index }}.description"
                                            class="w-full rounded-xl border border-zinc-200 bg-white px-4 py-3 text-sm text-zinc-900 shadow-sm outline-none transition placeholder:text-zinc-400 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 dark:border-zinc-700 dark:bg-zinc-900 dark:text-zinc-100 dark:placeholder:text-zinc-500"
                                            placeholder="Optional notes for this schedule item"></textarea>
                                    </div>

                                    <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
                                        <div class="w-full max-w-[8rem] space-y-1.5">
                                            <label class="text-xs font-semibold uppercase tracking-wide text-zinc-500 dark:text-zinc-400">
                                                Order
                                            </label>
                                            <input
                                                type="number"
                                                min="0"
                                                wire:model.defer="scheduleRows.{{ $index }}.sort_order"
                                                class="w-full rounded-xl border border-zinc-200 bg-white px-4 py-2.5 text-sm text-zinc-900 shadow-sm outline-none transition focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 dark:border-zinc-700 dark:bg-zinc-900 dark:text-zinc-100">
                                        </div>

                                        <button
                                            type="button"
                                            wire:click="removeScheduleRow({{ $index }})"
                                            class="inline-flex items-center justify-center rounded-xl border border-rose-200 bg-white px-4 py-2.5 text-sm font-medium text-rose-600 transition hover:bg-rose-50 dark:border-rose-900/50 dark:bg-zinc-900 dark:text-rose-400 dark:hover:bg-rose-950/20">
                                            Remove Item
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="rounded-2xl border border-dashed border-zinc-300 px-6 py-10 text-center dark:border-zinc-700">
                                <p class="text-sm font-medium text-zinc-700 dark:text-zinc-300">No schedule items yet</p>
                                <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">
                                    Add the timeline for this event, such as registration, dinner, or closing remarks.
                                </p>
                            </div>
                        @endforelse
                    </div>

                    <div class="border-t border-zinc-200 px-6 py-4 dark:border-zinc-800">
                        <div class="flex justify-end">
                            <button
                                type="button"
                                wire:click="saveSchedules"
                                class="inline-flex items-center rounded-xl bg-zinc-900 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-zinc-800 dark:bg-zinc-100 dark:text-zinc-900 dark:hover:bg-zinc-200">
                                Save Schedule
                            </button>
                        </div>
                    </div>
                </section>

                {{-- Registration Items --}}
                <section class="rounded-3xl border border-zinc-200 bg-white shadow-sm dark:border-zinc-800 dark:bg-zinc-900">
                    <div class="flex items-start justify-between gap-4 border-b border-zinc-200 px-6 py-5 dark:border-zinc-800">
                        <div>
                            <h2 class="text-lg font-semibold text-zinc-900 dark:text-white">Registration Items</h2>
                            <p class="mt-1 text-sm text-zinc-600 dark:text-zinc-400">
                                Define optional or required paid items such as dinner, shirts, or other add-ons.
                            </p>
                        </div>

                        <button
                            type="button"
                            wire:click="addItemRow"
                            class="inline-flex items-center rounded-xl bg-indigo-600 px-3.5 py-2 text-xs font-semibold text-white transition hover:bg-indigo-700">
                            + Add Item
                        </button>
                    </div>

                    <div class="space-y-4 p-6">
                        @forelse($itemRows as $index => $item)
                            <div class="rounded-2xl border border-zinc-200 bg-zinc-50/60 p-4 dark:border-zinc-800 dark:bg-zinc-950/50">
                                <div class="grid gap-4">
                                    <div class="grid gap-4 md:grid-cols-2">
                                        <div class="space-y-1.5 md:col-span-2">
                                            <label class="text-xs font-semibold uppercase tracking-wide text-zinc-500 dark:text-zinc-400">
                                                Item Name
                                            </label>
                                            <input
                                                type="text"
                                                wire:model.defer="itemRows.{{ $index }}.name"
                                                placeholder="e.g. Gala Dinner"
                                                class="w-full rounded-xl border border-zinc-200 bg-white px-4 py-2.5 text-sm text-zinc-900 shadow-sm outline-none transition placeholder:text-zinc-400 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 dark:border-zinc-700 dark:bg-zinc-900 dark:text-zinc-100 dark:placeholder:text-zinc-500">
                                        </div>

                                        <div class="space-y-1.5">
                                            <label class="text-xs font-semibold uppercase tracking-wide text-zinc-500 dark:text-zinc-400">
                                                Price (₱)
                                            </label>
                                            <input
                                                type="number"
                                                min="0"
                                                step="1"
                                                wire:model.defer="itemRows.{{ $index }}.price"
                                                placeholder="0"
                                                class="w-full rounded-xl border border-zinc-200 bg-white px-4 py-2.5 text-sm text-zinc-900 shadow-sm outline-none transition placeholder:text-zinc-400 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 dark:border-zinc-700 dark:bg-zinc-900 dark:text-zinc-100 dark:placeholder:text-zinc-500">
                                        </div>

                                        <div class="space-y-1.5">
                                            <label class="text-xs font-semibold uppercase tracking-wide text-zinc-500 dark:text-zinc-400">
                                                Linked Schedule
                                            </label>
                                            <select
                                                wire:model.defer="itemRows.{{ $index }}.event_schedule_id"
                                                class="w-full rounded-xl border border-zinc-200 bg-white px-4 py-2.5 text-sm text-zinc-900 shadow-sm outline-none transition focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 dark:border-zinc-700 dark:bg-zinc-900 dark:text-zinc-100">
                                                <option value="">No schedule</option>
                                                @foreach($scheduleRows as $schedule)
                                                    <option value="{{ $schedule['id'] }}">
                                                        {{ $schedule['title'] ?: 'Untitled Schedule' }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="flex justify-end">
                                        <button
                                            type="button"
                                            wire:click="removeItemRow({{ $index }})"
                                            class="inline-flex items-center justify-center rounded-xl border border-rose-200 bg-white px-4 py-2.5 text-sm font-medium text-rose-600 transition hover:bg-rose-50 dark:border-rose-900/50 dark:bg-zinc-900 dark:text-rose-400 dark:hover:bg-rose-950/20">
                                            Remove Item
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="rounded-2xl border border-dashed border-zinc-300 px-6 py-10 text-center dark:border-zinc-700">
                                <p class="text-sm font-medium text-zinc-700 dark:text-zinc-300">No registration items yet</p>
                                <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">
                                    Add payable items like dinner tickets, shirts, or other event add-ons.
                                </p>
                            </div>
                        @endforelse
                    </div>

                    <div class="border-t border-zinc-200 px-6 py-4 dark:border-zinc-800">
                        <div class="flex justify-end">
                            <button
                                type="button"
                                wire:click="saveItems"
                                class="inline-flex items-center rounded-xl bg-zinc-900 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-zinc-800 dark:bg-zinc-100 dark:text-zinc-900 dark:hover:bg-zinc-200">
                                Save Registration Items
                            </button>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>