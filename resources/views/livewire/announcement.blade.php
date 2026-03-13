<div>
     {{-- Admin UI --}}
      <div class="p-4 rounded-lg border border-gray-200 dark:border-gray-700 shadow-sm">
    <flux:heading size="lg">Announcements</flux:heading>
    <flux:subheading>Create announcements to notify alumni.</flux:subheading>

    <div class="mt-4">
        <flux:modal.trigger name="create-announcement">
            <flux:button variant="primary" icon="plus">New announcement</flux:button>
        </flux:modal.trigger>
    </div>

    <flux:modal name="create-announcement" class="md:w-[32rem]">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Create announcement</flux:heading>
                <flux:text class="mt-2">This will notify alumni.</flux:text>
            </div>

            <flux:input label="Title" wire:model.defer="announceTitle" placeholder="e.g., Reunion schedule update" />

            <flux:textarea label="Message" wire:model.defer="announceBody" rows="5" placeholder="Write your announcement..." />

            <div class="flex gap-2">
                <flux:spacer />

                <flux:modal.close>
                    <flux:button variant="ghost" type="button">Cancel</flux:button>
                </flux:modal.close>

                <flux:button variant="primary" type="button" wire:click="store">
                    Publish
                </flux:button>
            </div>
        </div>
    </flux:modal>
</div>
<div class="ui-surface mt-4">
    <div class="overflow-x-auto">
        <table class="min-w-full text-sm">
            <thead class="ui-thead">
                <tr>
                    <th class="px-4 py-3 text-left font-medium">Title</th>
                    <th class="px-4 py-3 text-left font-medium">Message</th>
                    <th class="px-4 py-3 text-left font-medium">Status</th>
                    <th class="px-4 py-3 text-left font-medium">Posted</th>
                    {{-- <th class="px-4 py-3 text-left font-medium">By</th> --}}
                </tr>
            </thead>

            <tbody class="ui-tbody">
                @forelse($announcements as $a)
                    <tr class="ui-trow">
                        <td class="px-4 py-3 align-top">
                            <div class="flex items-center gap-2">
                                <span class="font-medium text-zinc-900 dark:text-zinc-100">
                                    {{ $a->title }}
                                </span>

                                @if($a->pinned)
                                    <span class="inline-flex items-center rounded-full border border-amber-300 bg-amber-50 px-2 py-0.5 text-xs font-medium text-amber-700 dark:border-amber-800 dark:bg-amber-950/40 dark:text-amber-200">
                                        Pinned
                                    </span>
                                @endif
                            </div>
                        </td>

                        <td class="px-4 py-3 text-zinc-700 dark:text-zinc-300">
                            <div class="max-w-xl whitespace-pre-line">
                                {{ \Illuminate\Support\Str::limit($a->body, 160) }}
                            </div>
                        </td>

                        <td class="px-4 py-3">
                            @if($a->is_published)
                                <span class="inline-flex items-center rounded-full border border-emerald-300 bg-emerald-50 px-2 py-0.5 text-xs font-medium text-emerald-700 dark:border-emerald-800 dark:bg-emerald-950/40 dark:text-emerald-200">
                                    Published
                                </span>
                            @else
                                <span class="inline-flex items-center rounded-full border border-zinc-300 bg-zinc-50 px-2 py-0.5 text-xs font-medium text-zinc-700 dark:border-zinc-700 dark:bg-zinc-900 dark:text-zinc-200">
                                    Draft
                                </span>
                            @endif
                        </td>

                        <td class="px-4 py-3 whitespace-nowrap text-zinc-700 dark:text-zinc-300">
                            {{ optional($a->published_at)->timezone('Asia/Manila')->format('M d, Y h:i A') ?? '—' }}
                        </td>

                        {{--
                        <td class="px-4 py-3 whitespace-nowrap text-zinc-700 dark:text-zinc-300">
                            {{ $a->creator?->alumni?->fname ?? '—' }}
                        </td>
                        --}}
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-10 text-center text-zinc-600 dark:text-zinc-400">
                            No announcements yet.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

    {{-- Pagination (if $announcements is a paginator) --}}
    @if(method_exists($announcements, 'links'))
        <div>
            {{ $announcements->links() }}
        </div>
    @endif
</div>
