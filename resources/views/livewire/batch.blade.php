<div>
    <div class="mx-auto max-w-7xl px-6 py-6">
        <div class="space-y-6">

            @if ($batch)

                {{-- Header --}}
                <section class="overflow-hidden rounded-2xl border border-zinc-200 bg-white shadow-sm">
                    <div class="flex flex-col gap-5 px-6 py-6 lg:flex-row lg:items-end lg:justify-between">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-[0.22em] text-teal-600">
                                Batch Representative Panel
                            </p>

                            <h1 class="mt-1 text-2xl font-semibold tracking-tight text-zinc-900">
                                {{ str($batch->level)->headline() }} • Batch {{ $batch->yeargrad }}
                            </h1>

                            <p class="mt-2 text-sm text-zinc-500">
                                School Year: {{ $batch->schoolyear }}
                            </p>
                        </div>

                        <div class="w-full lg:w-80">
                            <flux:input
                                wire:model.live.debounce.300ms="search"
                                :label="__('Search Alumni')"
                                type="text"
                                placeholder="Search name, username, or email..."
                            />
                        </div>
                    </div>
                </section>

                {{-- Members Table --}}
                <section class="overflow-hidden rounded-2xl border border-zinc-200 bg-white shadow-sm">

                    <div class="border-b border-zinc-200 px-6 py-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <h2 class="text-base font-semibold text-zinc-900">Batch Members</h2>
                                <p class="mt-1 text-sm text-zinc-500">
                                    Members under your assigned batch (based on education records).
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-zinc-200">
                            <thead class="bg-zinc-50">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-[0.18em] text-zinc-500">
                                        Full Name
                                    </th>

                                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-[0.18em] text-zinc-500">
                                        Email
                                    </th>

                                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-[0.18em] text-zinc-500">
                                        Level
                                    </th>

                                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-[0.18em] text-zinc-500">
                                        Status
                                    </th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-zinc-100">
                                @forelse ($members as $member)
                                    @php
                                        $fullName = trim(collect([
                                            $member->alumni?->fname,
                                            $member->alumni?->mname,
                                            $member->alumni?->lname
                                        ])->filter()->implode(' '));
                                    @endphp

                                    <tr class="transition hover:bg-zinc-50">

                                        {{-- Name --}}
                                        <td class="px-6 py-4 text-sm text-zinc-900">
                                            {{ $fullName ?: '—' }}
                                        </td>

                                        {{-- Email --}}
                                        <td class="px-6 py-4 text-sm text-zinc-600">
                                            {{ $member->alumni?->user?->email ?? 'No email' }}
                                        </td>

                                        {{-- Level --}}
                                        <td class="px-6 py-4">
                                            <span class="inline-flex rounded-full bg-sky-500/10 px-3 py-1 text-[11px] font-semibold text-sky-600">
                                                {{ str($member->batch?->level ?? 'n/a')->headline() }}
                                            </span>
                                        </td>

                                        {{-- Batch Rep Status --}}
                                        <td class="px-6 py-4">
                                            @if ($member->is_batch_rep)
                                                <span class="inline-flex rounded-full bg-emerald-500/10 px-3 py-1 text-[11px] font-semibold text-emerald-600">
                                                    Representative
                                                </span>
                                            @else
                                                <span class="inline-flex rounded-full bg-zinc-100 px-3 py-1 text-[11px] font-semibold text-zinc-500">
                                                    Member
                                                </span>
                                            @endif
                                        </td>

                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-10 text-center">
                                            <div class="mx-auto max-w-md">
                                                <p class="text-sm font-medium text-zinc-900">
                                                    No alumni found.
                                                </p>
                                                <p class="mt-1 text-sm text-zinc-500">
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
                        <div class="border-t border-zinc-200 px-6 py-4">
                            {{ $members->links() }}
                        </div>
                    @endif
                </section>

            @else

                {{-- No batch assigned --}}
                <section class="rounded-2xl border border-dashed border-zinc-300 bg-zinc-50 px-6 py-10 text-center">
                    <h2 class="text-lg font-semibold text-zinc-900">No batch assigned</h2>
                    <p class="mt-2 text-sm text-zinc-500">
                        Your account is not yet linked to any batch representative role.
                    </p>
                </section>

            @endif

        </div>
    </div>
</div>
