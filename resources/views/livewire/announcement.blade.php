<div
    x-data="{
        removingId: null,
        recentlyUpdated: null,
        recentlyCreated: false,

        markDeleted(id) {
            this.removingId = id;

            setTimeout(() => {
                this.removingId = null;
            }, 700);
        },

        markUpdated(id) {
            this.recentlyUpdated = id;

            setTimeout(() => {
                this.recentlyUpdated = null;
            }, 1500);
        },

        markCreated() {
            this.recentlyCreated = true;

            setTimeout(() => {
                this.recentlyCreated = false;
            }, 1500);
        }
    }"
    x-on:announcement-deleted.window="markDeleted($event.detail.id)"
    x-on:announcement-updated.window="markUpdated($event.detail.id)"
    x-on:announcement-saved.window="markCreated()"
    x-on:open-modal.window="$flux.modal($event.detail.name).show()"
    x-on:close-modal.window="$flux.modal($event.detail.name).close()"
    class="min-h-screen p-4 text-gray-800 sm:p-6"
>
    <div class="mx-auto max-w-7xl space-y-4">

        {{-- Flash message --}}
        @if (session('status'))
            <div
                x-data="{ show: true }"
                x-show="show"
                x-transition.opacity.duration.300ms
                class="rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700"
            >
                <div class="flex items-center justify-between gap-4">
                    <span>{{ session('status') }}</span>
                    <button
                        type="button"
                        x-on:click="show = false"
                        class="text-emerald-500 transition hover:text-emerald-700"
                    >
                        ✕
                    </button>
                </div>
            </div>
        @endif

        {{-- Header --}}
        <div class="rounded-3xl border border-gray-200 bg-white p-5 shadow-sm sm:p-6">
            <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
                <div>
                    <flux:heading size="xl" class="text-gray-900">Announcements</flux:heading>
                    <flux:subheading class="mt-1 text-gray-500">
                        Create, edit, and manage announcements for alumni.
                    </flux:subheading>
                </div>

                <div class="flex flex-col gap-3 sm:flex-row sm:items-center">
                    <div class="relative w-full sm:w-80">
                        <flux:icon name="magnifying-glass" class="absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-gray-400" />
                        <input
                            type="text"
                            wire:model.live.debounce.300ms="search"
                            placeholder="Search title or message..."
                            class="w-full rounded-2xl border border-gray-300 bg-white py-3 pl-9 pr-4 text-sm text-gray-900 outline-none transition placeholder:text-gray-400 focus:border-sky-500 focus:ring-2 focus:ring-sky-500/20"
                        >
                    </div>

                    <flux:modal.trigger name="create-announcement">
                        <button
                            type="button"
                            wire:click="resetCreateForm"
                            class="inline-flex items-center justify-center rounded-2xl bg-amber-500 px-4 py-3 text-sm font-semibold text-white transition hover:bg-amber-600"
                        >
                            New announcement
                        </button>
                    </flux:modal.trigger>
                </div>
            </div>
        </div>

        {{-- Table --}}
        <div class="overflow-hidden rounded-3xl border border-gray-200 bg-white shadow-sm">
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="border-b border-gray-100 bg-gray-50 text-xs font-semibold uppercase tracking-wide text-gray-400">
                        <tr>
                            <th class="px-4 py-3 text-left font-medium">Title</th>
                            <th class="px-4 py-3 text-left font-medium">Message</th>
                            <th class="px-4 py-3 text-left font-medium">Status</th>
                            <th class="px-4 py-3 text-left font-medium">Posted</th>
                            <th class="px-4 py-3 text-left font-medium">Author</th>
                            <th class="px-4 py-3 text-right font-medium">Actions</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100">
                        @forelse ($announcements as $a)
                            <tr
                                wire:key="announcement-{{ $a->id }}"
                                x-show="removingId !== {{ $a->id }}"
                                x-transition:leave.duration.500ms
                                x-transition:leave.opacity
                                :class="recentlyUpdated === {{ $a->id }} ? 'bg-sky-50' : ''"
                                class="transition duration-300 hover:bg-gray-50/80"
                            >
                                {{-- Title --}}
                                <td class="px-4 py-4 align-top">
                                    <div class="flex flex-wrap items-center gap-2">
                                        <span class="font-semibold text-gray-900">
                                            {{ $a->title }}
                                        </span>

                                        @if ($a->pinned)
                                            <span class="rounded-full border border-amber-200 bg-amber-50 px-2.5 py-1 text-[11px] font-medium text-amber-700">
                                                Pinned
                                            </span>
                                        @endif
                                    </div>
                                </td>

                                {{-- Message --}}
                                <td class="px-4 py-4 align-top text-gray-600">
                                    <div class="max-w-xl whitespace-pre-line break-words leading-6">
                                        {{ \Illuminate\Support\Str::limit($a->body, 160) }}
                                    </div>
                                </td>

                                {{-- Status --}}
                                <td class="px-4 py-4 align-top">
                                    @if ($a->is_published)
                                        <span class="rounded-full border border-emerald-200 bg-emerald-50 px-2.5 py-1 text-[11px] font-medium text-emerald-700">
                                            Published
                                        </span>
                                    @else
                                        <span class="rounded-full border border-gray-200 bg-gray-100 px-2.5 py-1 text-[11px] font-medium text-gray-500">
                                            Draft
                                        </span>
                                    @endif
                                </td>

                                {{-- Posted --}}
                                <td class="whitespace-nowrap px-4 py-4 align-top text-gray-500">
                                    {{ optional($a->published_at ?? $a->created_at)?->timezone('Asia/Manila')->format('M d, Y h:i A') ?? '—' }}
                                </td>

                                {{-- Author --}}
                                <td class="px-4 py-4 align-top text-gray-500">
                                    {{ trim(($a->creator?->alumni?->fname ?? '') . ' ' . ($a->creator?->alumni?->lname ?? '')) ?: 'Unknown' }}
                                </td>

                                {{-- Actions --}}
                                <td class="px-4 py-4 align-top">
                                    <div class="flex items-center justify-end gap-2">
                                        <button
                                            type="button"
                                            wire:click="startEdit({{ $a->id }})"
                                            wire:loading.attr="disabled"
                                            wire:target="startEdit({{ $a->id }})"
                                            class="inline-flex items-center rounded-2xl border border-sky-200 bg-sky-50 px-3.5 py-2 text-xs font-semibold text-sky-700 transition hover:bg-sky-100 disabled:cursor-not-allowed disabled:opacity-60"
                                        >
                                            Edit
                                        </button>

                                        <button
                                            type="button"
                                            wire:click="confirmDelete({{ $a->id }})"
                                            wire:loading.attr="disabled"
                                            wire:target="confirmDelete({{ $a->id }})"
                                            class="inline-flex items-center rounded-2xl border border-rose-200 bg-rose-50 px-3.5 py-2 text-xs font-semibold text-rose-600 transition hover:bg-rose-100 disabled:cursor-not-allowed disabled:opacity-60"
                                        >
                                            Delete
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-14 text-center">
                                    <flux:icon name="megaphone" class="mx-auto h-7 w-7 text-gray-300" />
                                    <p class="mt-2 text-sm text-gray-400">No announcements found.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Pagination --}}
        @if (method_exists($announcements, 'links'))
            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <p class="text-sm text-gray-400">
                    Showing {{ $announcements->firstItem() ?? 0 }}–{{ $announcements->lastItem() ?? 0 }}
                    of {{ $announcements->total() }}
                </p>

                <div class="[&>*]:!shadow-none">
                    {{ $announcements->links() }}
                </div>
            </div>
        @endif
    </div>

    {{-- Create Modal --}}
    <flux:modal name="create-announcement" class="md:w-[38rem]">
        <form wire:submit.prevent="store" class="space-y-6 rounded-3xl p-1 text-gray-800">
            <div>
                <flux:heading size="lg" class="text-gray-900">Create announcement</flux:heading>
                <flux:text class="mt-2 text-gray-500">
                    Publish a new announcement for alumni.
                </flux:text>
            </div>

            <div class="space-y-4">
                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700">Title</label>
                    <input
                        type="text"
                        wire:model.defer="announceTitle"
                        class="w-full rounded-2xl border border-gray-300 bg-white px-4 py-3 text-sm text-gray-900 outline-none transition placeholder:text-gray-400 focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20"
                        placeholder="Enter announcement title"
                    >
                    @error('announceTitle')
                        <p class="mt-2 text-xs text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700">Message</label>
                    <textarea
                        wire:model.defer="announceBody"
                        rows="7"
                        class="w-full rounded-2xl border border-gray-300 bg-white px-4 py-3 text-sm text-gray-900 outline-none transition placeholder:text-gray-400 focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20"
                        placeholder="Write your announcement message here..."
                    ></textarea>
                    @error('announceBody')
                        <p class="mt-2 text-xs text-rose-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex items-center justify-end gap-2 border-t border-gray-200 pt-4">
                <flux:modal.close>
                    <button
                        type="button"
                        wire:click="resetCreateForm"
                        class="inline-flex items-center rounded-2xl border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-600 transition hover:bg-gray-50"
                    >
                        Cancel
                    </button>
                </flux:modal.close>

                <button
                    type="submit"
                    wire:loading.attr="disabled"
                    wire:target="store"
                    class="inline-flex items-center rounded-2xl bg-amber-500 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-amber-600 disabled:cursor-not-allowed disabled:opacity-60"
                >
                    <span wire:loading.remove wire:target="store">Publish announcement</span>
                    <span wire:loading wire:target="store">Publishing...</span>
                </button>
            </div>
        </form>
    </flux:modal>

    {{-- Edit Modal --}}
    <flux:modal name="edit-announcement" class="md:w-[38rem]">
        <form wire:submit.prevent="updateAnnouncement" class="space-y-6 rounded-3xl p-1 text-gray-800">
            <div>
                <flux:heading size="lg" class="text-gray-900">Edit announcement</flux:heading>
                <flux:text class="mt-2 text-gray-500">
                    Update the selected announcement details.
                </flux:text>
            </div>

            <div class="space-y-4">
                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700">Title</label>
                    <input
                        type="text"
                        wire:model.defer="editTitle"
                        class="w-full rounded-2xl border border-gray-300 bg-white px-4 py-3 text-sm text-gray-900 outline-none transition placeholder:text-gray-400 focus:border-sky-500 focus:ring-2 focus:ring-sky-500/20"
                        placeholder="Enter announcement title"
                    >
                    @error('editTitle')
                        <p class="mt-2 text-xs text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700">Message</label>
                    <textarea
                        wire:model.defer="editBody"
                        rows="7"
                        class="w-full rounded-2xl border border-gray-300 bg-white px-4 py-3 text-sm text-gray-900 outline-none transition placeholder:text-gray-400 focus:border-sky-500 focus:ring-2 focus:ring-sky-500/20"
                        placeholder="Update the announcement message..."
                    ></textarea>
                    @error('editBody')
                        <p class="mt-2 text-xs text-rose-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex items-center justify-end gap-2 border-t border-gray-200 pt-4">
                <flux:modal.close>
                    <button
                        type="button"
                        wire:click="resetEditForm"
                        class="inline-flex items-center rounded-2xl border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-600 transition hover:bg-gray-50"
                    >
                        Cancel
                    </button>
                </flux:modal.close>

                <button
                    type="submit"
                    wire:loading.attr="disabled"
                    wire:target="updateAnnouncement"
                    class="inline-flex items-center rounded-2xl bg-sky-500 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-sky-600 disabled:cursor-not-allowed disabled:opacity-60"
                >
                    <span wire:loading.remove wire:target="updateAnnouncement">Save changes</span>
                    <span wire:loading wire:target="updateAnnouncement">Updating...</span>
                </button>
            </div>
        </form>
    </flux:modal>

    {{-- Delete Modal --}}
    <flux:modal name="delete-announcement" class="md:w-[31rem]">
        <div class="space-y-6 rounded-3xl p-1 text-gray-800">
            <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full border border-rose-200 bg-rose-50">
                <svg class="h-7 w-7 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 9v4m0 4h.01M10.29 3.86l-7.5 13A2 2 0 0 0 4.5 20h15a2 2 0 0 0 1.71-3.14l-7.5-13a2 2 0 0 0-3.42 0Z" />
                </svg>
            </div>

            <div class="text-center">
                <h3 class="text-xl font-semibold text-gray-900">Delete announcement?</h3>
                <p class="mt-2 text-sm leading-6 text-gray-500">
                    You are about to permanently delete
                    <span class="font-medium text-gray-800">"{{ $deleteTitle }}"</span>.
                </p>
            </div>

            <div class="rounded-2xl border border-rose-200 bg-rose-50 p-4 text-sm text-rose-700">
                This action cannot be undone.
            </div>

            <div class="flex items-center justify-end gap-2 border-t border-gray-200 pt-4">
                <flux:modal.close>
                    <button
                        type="button"
                        wire:click="resetDeleteForm"
                        class="inline-flex items-center rounded-2xl border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-600 transition hover:bg-gray-50"
                    >
                        Cancel
                    </button>
                </flux:modal.close>

                <button
                    type="button"
                    wire:click="destroyAnnouncement"
                    wire:loading.attr="disabled"
                    wire:target="destroyAnnouncement"
                    class="inline-flex items-center rounded-2xl bg-rose-500 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-rose-600 disabled:cursor-not-allowed disabled:opacity-60"
                >
                    <span wire:loading.remove wire:target="destroyAnnouncement">Yes, delete it</span>
                    <span wire:loading wire:target="destroyAnnouncement">Deleting...</span>
                </button>
            </div>
        </div>
    </flux:modal>
</div>
