<div>
    {{-- Knowing others is intelligence; knowing yourself is true wisdom. --}}
    <div class="mx-auto max-w-7xl px-6 py-6">
    <div class="space-y-6">
        @if ($batch)
            {{-- Header --}}
            <section class="overflow-hidden rounded-2xl border border-white/10 bg-zinc-900/80 shadow-[0_10px_30px_rgba(0,0,0,0.25)] backdrop-blur">
                <div class="flex flex-col gap-5 px-6 py-6 lg:flex-row lg:items-end lg:justify-between">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.22em] text-teal-400">
                            Batch Representative Panel
                        </p>

                        <h1 class="mt-1 text-2xl font-semibold tracking-tight text-white">
                            Batch {{ $batch->yeargrad }}
                        </h1>

                        <p class="mt-2 text-sm text-zinc-400">
                            School Year: {{ $batch->schoolyear }}
                        </p>
                    </div>

                    <div class="w-full lg:w-80">
                        <flux:input
                            wire:model.live.debounce.300ms="search"
                            :label="__('Search Alumni')"
                            type="text"
                            placeholder="Search name or email..."
                        />
                    </div>
                </div>
            </section>

            {{-- Members Table --}}
            <section class="overflow-hidden rounded-2xl border border-white/10 bg-zinc-900/80 shadow-[0_10px_30px_rgba(0,0,0,0.25)] backdrop-blur">
                <div class="border-b border-white/10 px-6 py-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <h2 class="text-base font-semibold text-white">Batch Members</h2>
                            <p class="mt-1 text-sm text-zinc-400">
                                View all alumni under your assigned batch.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-white/10">
                        <thead class="bg-white/[0.03]">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-[0.18em] text-zinc-400">
                                    First Name
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-[0.18em] text-zinc-400">
                                    Middle Name
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-[0.18em] text-zinc-400">
                                    Last Name
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-[0.18em] text-zinc-400">
                                    Email
                                </th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-white/5">
                            @forelse ($members as $member)
                                <tr class="transition hover:bg-white/[0.03]">
                                    <td class="px-6 py-4 text-sm text-white">
                                        {{ $member->fname }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-zinc-300">
                                        {{ $member->mname ?: '—' }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-white">
                                        {{ $member->lname }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-zinc-300">
                                        {{ $member->user->email ?? 'No email' }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-10 text-center">
                                        <div class="mx-auto max-w-md">
                                            <p class="text-sm font-medium text-white">
                                                No alumni found.
                                            </p>
                                            <p class="mt-1 text-sm text-zinc-400">
                                                Try adjusting your search or check if members are assigned to this batch.
                                            </p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                @if ($members->hasPages())
                    <div class="border-t border-white/10 px-6 py-4">
                        {{ $members->links() }}
                    </div>
                @endif
            </section>
        @else
            <section class="rounded-2xl border border-dashed border-white/10 bg-zinc-900/60 px-6 py-10 text-center">
                <h2 class="text-lg font-semibold text-white">No batch assigned</h2>
                <p class="mt-2 text-sm text-zinc-400">
                    Your account is not yet linked to any batch.
                </p>
            </section>
        @endif
    </div>
</div>
</div>
 