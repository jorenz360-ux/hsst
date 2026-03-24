<div>
    <div class="min-h-screen bg-zinc-950 text-zinc-100 p-6">

    {{-- Toast --}}
    <div class="fixed bottom-0 right-1 z-50 w-full max-w-sm">
        @if (session('status'))
            <x-toast/>
        @endif
    </div>

    {{-- Header Card --}}
    <div class="p-5 rounded-2xl border border-white/10 bg-zinc-900/70 shadow-sm">
        <flux:heading size="lg" class="text-white">Announcements</flux:heading>
        <flux:subheading class="text-zinc-400">
            Create announcements to notify alumni.
        </flux:subheading>

        <div class="mt-4">
            {{-- KEEP MODAL TRIGGER --}}
            <flux:modal.trigger name="create-announcement">
                <flux:button
                    icon="plus"
                    variant="primary" color="orange"
                >
                    New announcement
                </flux:button>
            </flux:modal.trigger>
        </div>

        {{-- Modal --}}
        <flux:modal name="create-announcement" class="md:w-[32rem]">
            <div class="space-y-6">
                <div>
                    <flux:heading size="lg">Create announcement</flux:heading>
                    <flux:text class="mt-2 text-zinc-400">This will notify alumni.</flux:text>
                </div>

                <flux:input
                    label="Title"
                    wire:model.defer="announceTitle"
                    class="bg-zinc-950 border-white/10 text-white focus:border-amber-400 focus:ring-amber-500/20"
                />

                <flux:textarea
                    label="Message"
                    wire:model.defer="announceBody"
                    rows="5"
                    class="bg-zinc-950 border-white/10 text-white focus:border-amber-400 focus:ring-amber-500/20"
                />

                <div class="flex gap-2">
                    <flux:spacer />

                    <flux:modal.close>
                        <flux:button variant="ghost" type="button">
                            Cancel
                        </flux:button>
                    </flux:modal.close>

                    <flux:button
                        type="button"
                        wire:click="store"
                        class="bg-amber-500 text-zinc-950 hover:bg-amber-400"
                    >
                        Publish
                    </flux:button>
                </div>
            </div>
        </flux:modal>
    </div>

    {{-- Table --}}
    <div class="ui-surface mt-4 rounded-2xl border border-white/10 bg-zinc-900/70">
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">

                <thead class="border-b border-white/10 bg-zinc-950/80 text-zinc-400">
                    <tr>
                        <th class="px-4 py-3 text-left font-medium">Title</th>
                        <th class="px-4 py-3 text-left font-medium">Message</th>
                        <th class="px-4 py-3 text-left font-medium">Status</th>
                        <th class="px-4 py-3 text-left font-medium">Posted</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-white/10">
                    @forelse($announcements as $a)
                        <tr class="hover:bg-amber-500/[0.04] transition">

                            {{-- Title --}}
                            <td class="px-4 py-3 align-top">
                                <div class="flex items-center gap-2">
                                    <span class="font-medium text-white">
                                        {{ $a->title }}
                                    </span>

                                    @if($a->pinned)
                                        <span class="rounded-full border border-amber-500/20 bg-amber-500/10 px-2 py-0.5 text-xs text-amber-300">
                                            Pinned
                                        </span>
                                    @endif
                                </div>
                            </td>

                            {{-- Message --}}
                            <td class="px-4 py-3 text-zinc-300">
                                <div class="max-w-xl whitespace-pre-line">
                                    {{ \Illuminate\Support\Str::limit($a->body, 160) }}
                                </div>
                            </td>

                            {{-- Status --}}
                            <td class="px-4 py-3">
                                @if($a->is_published)
                                    <span class="rounded-full border border-emerald-500/20 bg-emerald-500/10 px-2 py-0.5 text-xs text-emerald-300">
                                        Published
                                    </span>
                                @else
                                    <span class="rounded-full border border-zinc-700 bg-zinc-800 px-2 py-0.5 text-xs text-zinc-300">
                                        Draft
                                    </span>
                                @endif
                            </td>

                            {{-- Date --}}
                            <td class="px-4 py-3 text-zinc-400 whitespace-nowrap">
                                {{ optional($a->published_at)->timezone('Asia/Manila')->format('M d, Y h:i A') ?? '—' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-4 py-10 text-center text-zinc-500">
                                No announcements yet.
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
        </div>
    </div>

    {{-- Pagination --}}
    @if(method_exists($announcements, 'links'))
        <div class="mt-2">
            {{ $announcements->links() }}
        </div>
    @endif

</div>
</div>