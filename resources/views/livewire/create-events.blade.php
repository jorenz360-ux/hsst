<div class="min-h-screen rounded-2xl bg-zinc-950 text-zinc-100">
    <div class="mx-auto max-w-7xl space-y-6 p-6">
        {{-- Page Header --}}
        <div class="flex flex-col gap-2 lg:flex-row lg:items-end lg:justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.22em] text-amber-400">
                    Events Management
                </p>
                <flux:heading size="lg" class="!text-white">
                    Create Event
                </flux:heading>
                <flux:subheading class="!text-zinc-400">
                    Add a new reunion event for alumni registration.
                </flux:subheading>
            </div>
        </div>

        {{-- Flash Messages --}}
        @if (session()->has('success'))
            <div class="rounded-2xl border border-emerald-500/20 bg-emerald-500/10 p-4 text-sm text-emerald-300">
                {{ session('success') }}
            </div>
        @endif

        @if (session()->has('error'))
            <div class="rounded-2xl border border-rose-500/20 bg-rose-500/10 p-4 text-sm text-rose-300">
                {{ session('error') }}
            </div>
        @endif

        @if (session('status'))
            <div class="rounded-2xl border border-emerald-500/20 bg-emerald-500/10 p-4">
                <flux:text class="font-medium !text-emerald-300">
                    {{ session('status') }}
                </flux:text>
            </div>
        @endif

        <form wire:submit.prevent="save" class="grid grid-cols-1 gap-6 xl:grid-cols-12">
            {{-- LEFT: Main Form --}}
            <div class="space-y-6 xl:col-span-8">
                {{-- Main Details --}}
                <div class="rounded-3xl border border-white/10 bg-zinc-900/70 p-6 shadow-sm">
                    <div class="mb-5">
                        <h2 class="text-sm font-semibold uppercase tracking-wide text-zinc-400">
                            Event Details
                        </h2>
                    </div>

                    <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                        <div class="space-y-1 md:col-span-2">
                            <flux:input
                                label="Title"
                                placeholder="e.g., Alumni Grand Reunion 2026"
                                wire:model.defer="title"
                                class="border-white/10 bg-zinc-950 text-white focus:border-amber-400 focus:ring-amber-500/20"
                            />
                            @error('title')
                                <p class="text-sm text-rose-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-1">
                            <flux:input
                                label="Venue"
                                placeholder="e.g., School Gymnasium"
                                wire:model.defer="venue"
                                class="border-white/10 bg-zinc-950 text-white focus:border-amber-400 focus:ring-amber-500/20"
                            />
                            @error('venue')
                                <p class="text-sm text-rose-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-1">
                            <flux:input
                                label="Dress Code"
                                placeholder="e.g., Formal or Semi-Formal"
                                wire:model.defer="dress_code"
                                class="border-white/10 bg-zinc-950 text-white focus:border-amber-400 focus:ring-amber-500/20"
                            />
                            @error('dress_code')
                                <p class="text-sm text-rose-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-1">
                            <flux:input
                                label="Event Date & Time"
                                type="datetime-local"
                                wire:model.defer="event_date"
                                class="border-white/10 bg-zinc-950 text-white focus:border-amber-400 focus:ring-amber-500/20"
                            />
                            <p class="text-xs text-zinc-500">
                                Use your local time.
                            </p>
                            @error('event_date')
                                <p class="text-sm text-rose-400">{{ $message }}</p>
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
                                class="border-white/10 bg-zinc-950 text-white focus:border-amber-400 focus:ring-amber-500/20"
                            />
                            <p class="text-xs text-zinc-500">
                                Amount in pesos.
                            </p>
                            @error('registration_fee')
                                <p class="text-sm text-rose-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Description --}}
                <div class="rounded-3xl border border-white/10 bg-zinc-900/70 p-6 shadow-sm">
                    <div class="mb-5">
                        <h2 class="text-sm font-semibold uppercase tracking-wide text-zinc-400">
                            Additional Details
                        </h2>
                    </div>

                    <div class="space-y-1">
                        <flux:textarea
                            label="Description"
                            rows="7"
                            placeholder="Include program details, reminders, registration instructions, payment notes, and other important information."
                            wire:model.defer="description"
                            class="border-white/10 bg-zinc-950 text-white focus:border-amber-400 focus:ring-amber-500/20"
                        />
                        @error('description')
                            <p class="text-sm text-rose-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- RIGHT: Utility Panel --}}
            <div class="space-y-6 xl:col-span-4">
                {{-- Banner Upload --}}
                <div class="rounded-3xl border border-white/10 bg-zinc-900/70 p-6 shadow-sm">
                    <div class="mb-5">
                        <h2 class="text-sm font-semibold uppercase tracking-wide text-zinc-400">
                            Event Banner
                        </h2>
                        <p class="mt-1 text-xs text-zinc-500">
                            Upload 1 image only. JPG, PNG, WEBP. Max 2MB.
                        </p>
                    </div>

                    <div class="space-y-3">
                        <div class="rounded-2xl border-2 border-dashed border-white/10 bg-zinc-950/60 p-5 text-center transition hover:border-amber-400">
                            <input
                                type="file"
                                wire:model="banner"
                                accept="image/*"
                                class="hidden"
                                id="bannerUpload"
                            >

                            <label for="bannerUpload" class="block cursor-pointer">
                                <div class="space-y-2">
                                    <p class="text-sm font-medium text-zinc-300">
                                        Click to upload
                                    </p>
                                    <p class="text-xs text-zinc-500">
                                        Poster or event cover
                                    </p>
                                </div>
                            </label>
                        </div>

                        <div wire:loading wire:target="banner" class="text-xs text-amber-400">
                            Uploading image...
                        </div>

                        @if ($banner)
                            <div class="relative overflow-hidden rounded-2xl border border-white/10 bg-zinc-950">
                                <img
                                    src="{{ $banner->temporaryUrl() }}"
                                    class="h-56 w-full object-cover"
                                >

                                <button
                                    type="button"
                                    onclick="document.getElementById('bannerUpload').click()"
                                    class="absolute right-3 top-3 rounded-lg bg-black/70 px-3 py-1.5 text-xs font-medium text-white transition hover:bg-black"
                                >
                                    Replace
                                </button>
                            </div>
                        @endif

                        @error('banner')
                            <p class="text-sm text-rose-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Visibility --}}
                <div class="rounded-3xl border border-white/10 bg-zinc-900/70 p-6 shadow-sm">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <h2 class="text-sm font-semibold uppercase tracking-wide text-zinc-400">
                                Visibility
                            </h2>
                            <p class="mt-2 text-xs text-zinc-500">
                                When enabled, alumni can see this event in the registration list.
                            </p>
                        </div>

                        <label class="inline-flex items-center gap-2">
                            <input
                                type="checkbox"
                                wire:model.defer="is_active"
                                class="rounded border-white/20 bg-zinc-900 text-amber-500 focus:ring-amber-500/40"
                            >
                            <span class="text-sm font-medium text-zinc-300">
                                Enabled
                            </span>
                        </label>
                    </div>

                    @error('is_active')
                        <p class="mt-3 text-sm text-rose-400">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Actions --}}
                <div class="rounded-3xl border border-white/10 bg-zinc-900/70 p-6 shadow-sm">
                    <div class="mb-4">
                        <h2 class="text-sm font-semibold uppercase tracking-wide text-zinc-400">
                            Actions
                        </h2>
                    </div>

                    <div class="flex flex-col gap-3">
                        <flux:button
                            type="submit"
                            wire:loading.attr="disabled"
                            class="w-full bg-amber-500 text-zinc-950 hover:bg-amber-400"
                        >
                            <span wire:loading.remove>Save Event</span>
                            <span wire:loading>Saving...</span>
                        </flux:button>

                        <flux:button
                            type="button"
                            wire:click="resetForm"
                            wire:loading.attr="disabled"
                            class="w-full border-white/10 bg-zinc-950 text-zinc-200 hover:bg-zinc-800"
                        >
                            Reset Form
                        </flux:button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>