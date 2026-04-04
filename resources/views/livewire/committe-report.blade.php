<div class="min-h-screen rounded-2xl bg-zinc-950 text-zinc-100">
    <div class="mx-auto max-w-7xl space-y-6 p-6">

        @if (session()->has('success'))
            <div class="rounded-2xl border border-emerald-500/20 bg-emerald-500/10 px-4 py-3 text-sm text-emerald-300">
                {{ session('success') }}
            </div>
        @endif

        @if (session()->has('error'))
            <div class="rounded-2xl border border-rose-500/20 bg-rose-500/10 px-4 py-3 text-sm text-rose-300">
                {{ session('error') }}
            </div>
        @endif

        {{-- Header --}}
        <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.22em] text-amber-400">
                    Volunteer Approval Queue
                </p>
                <h1 class="mt-1 text-3xl font-semibold tracking-tight text-white">
                    Volunteer Submissions
                </h1>
                <p class="mt-2 max-w-3xl text-sm text-zinc-400">
                    Review each committee submission individually. This view is optimized for one submission per row so approvals are easier to scan, filter, and manage.
                </p>
            </div>

            <div class="flex flex-wrap gap-3">
                <button
                    wire:click="resetFilters"
                    class="inline-flex items-center justify-center rounded-2xl border border-white/10 bg-zinc-900 px-4 py-2.5 text-sm font-medium text-zinc-200 transition hover:bg-zinc-800"
                >
                    Reset Filters
                </button>

                <button
                    wire:click="downloadExcel"
                    wire:loading.attr="disabled"
                    class="inline-flex items-center justify-center rounded-2xl border border-emerald-500/20 bg-emerald-500 px-4 py-2.5 text-sm font-semibold text-zinc-950 shadow transition hover:bg-emerald-400 disabled:opacity-60"
                >
                    Download CSV
                </button>
            </div>
        </div>

        {{-- Filters --}}
        <div class="rounded-3xl border border-white/10 bg-zinc-900/60 p-5">
            <div class="mb-4 flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
                <h2 class="text-lg font-semibold text-white">Advanced Filters</h2>
                <p class="text-xs text-zinc-500">
                    Filter by user, alumni, batch, role, committee, and submission status
                </p>
            </div>

            <div class="grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-12">
                <div class="xl:col-span-4">
                    <input
                        type="text"
                        wire:model.live.debounce.300ms="search"
                        placeholder="Search user, alumni, committee, notes, batch..."
                        class="w-full rounded-2xl border border-white/10 bg-zinc-950 px-4 py-2.5 text-sm text-white outline-none focus:border-amber-400 focus:ring-2 focus:ring-amber-500/20"
                    />
                </div>

                <div class="xl:col-span-2">
                    <select
                        wire:model.live="role"
                        class="w-full rounded-2xl border border-white/10 bg-zinc-950 px-4 py-2.5 text-sm text-white focus:border-amber-400 focus:ring-2 focus:ring-amber-500/20"
                    >
                        @foreach ($roles as $r)
                            <option value="{{ $r }}">
                                {{ $r === 'all' ? 'All roles' : str($r)->headline() }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="xl:col-span-2">
                    <select
                        wire:model.live="committeeId"
                        class="w-full rounded-2xl border border-white/10 bg-zinc-950 px-4 py-2.5 text-sm text-white focus:border-amber-400 focus:ring-2 focus:ring-amber-500/20"
                    >
                        <option value="all">All committees</option>
                        @foreach ($committees as $committee)
                            <option value="{{ $committee->id }}">{{ $committee->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="xl:col-span-2">
                    <select
                        wire:model.live="volunteerStatus"
                        class="w-full rounded-2xl border border-white/10 bg-zinc-950 px-4 py-2.5 text-sm text-white focus:border-amber-400 focus:ring-2 focus:ring-amber-500/20"
                    >
                        @foreach ($volunteerStatuses as $status)
                            <option value="{{ $status }}">
                                {{ $status === 'all' ? 'All statuses' : str($status)->headline() }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="xl:col-span-2">
                    <select
                        wire:model.live="batchId"
                        class="w-full rounded-2xl border border-white/10 bg-zinc-950 px-4 py-2.5 text-sm text-white focus:border-amber-400 focus:ring-2 focus:ring-amber-500/20"
                    >
                        <option value="all">All batches</option>
                        @foreach ($batches as $batch)
                            <option value="{{ $batch->id }}">
                                {{ $batch->schoolyear }} @if($batch->yeargrad) • Grad: {{ $batch->yeargrad }} @endif
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="xl:col-span-2">
                    <select
                        wire:model.live="yearGrad"
                        class="w-full rounded-2xl border border-white/10 bg-zinc-950 px-4 py-2.5 text-sm text-white focus:border-amber-400 focus:ring-2 focus:ring-amber-500/20"
                    >
                        <option value="all">All grad years</option>
                        @foreach ($yearGrads as $grad)
                            <option value="{{ $grad }}">{{ $grad }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="xl:col-span-2">
                    <select
                        wire:model.live="schoolyear"
                        class="w-full rounded-2xl border border-white/10 bg-zinc-950 px-4 py-2.5 text-sm text-white focus:border-amber-400 focus:ring-2 focus:ring-amber-500/20"
                    >
                        <option value="all">All school years</option>
                        @foreach ($schoolyears as $sy)
                            <option value="{{ $sy }}">{{ $sy }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="xl:col-span-2">
                    <select
                        wire:model.live="isBatchRep"
                        class="w-full rounded-2xl border border-white/10 bg-zinc-950 px-4 py-2.5 text-sm text-white focus:border-amber-400 focus:ring-2 focus:ring-amber-500/20"
                    >
                        <option value="all">All batch rep flags</option>
                        <option value="yes">Batch rep only</option>
                        <option value="no">Non-batch rep only</option>
                    </select>
                </div>

                <div class="xl:col-span-2">
                    <select
                        wire:model.live="hasAlumni"
                        class="w-full rounded-2xl border border-white/10 bg-zinc-950 px-4 py-2.5 text-sm text-white focus:border-amber-400 focus:ring-2 focus:ring-amber-500/20"
                    >
                        <option value="all">All alumni links</option>
                        <option value="yes">With alumni profile</option>
                        <option value="no">No alumni profile</option>
                    </select>
                </div>

                <div class="xl:col-span-2">
                    <select
                        wire:model.live="perPage"
                        class="w-full rounded-2xl border border-white/10 bg-zinc-950 px-4 py-2.5 text-sm text-white focus:border-amber-400 focus:ring-2 focus:ring-amber-500/20"
                    >
                        <option value="10">10 per page</option>
                        <option value="25">25 per page</option>
                        <option value="50">50 per page</option>
                        <option value="100">100 per page</option>
                    </select>
                </div>
            </div>
        </div>

        {{-- Table --}}
        <div class="overflow-hidden rounded-3xl border border-white/10 bg-zinc-900/70">
            <div class="border-b border-white/10 px-5 py-4">
                <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
                    <h2 class="text-lg font-semibold text-white">Volunteer Submissions</h2>
                    <p class="text-xs text-zinc-500">
                        One row per committee submission
                    </p>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-zinc-950/80 text-zinc-400">
                        <tr>
                            <th class="px-5 py-4 text-left">ID</th>
                            <th class="px-5 py-4 text-left">Full Name</th>
                            <th class="px-5 py-4 text-left">Role</th>
                            <th class="px-5 py-4 text-left">Committee</th>
                            <th class="px-5 py-4 text-left">Status</th>
                            <th class="px-5 py-4 text-left">Actions</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-white/7">
    @forelse ($signups as $signup)
        <tr class="transition hover:bg-amber-500/[0.04]">
            <td class="px-3 py-2.5 text-sm text-white">
                {{ $signup->id }}
            </td>

            <td class="px-3 py-2.5 text-sm text-zinc-300">
                {{ $signup->alumni ? trim($signup->alumni->fname . ' ' . $signup->alumni->lname) : 'N/A' }}
            </td>

            <td class="px-3 py-2.5">
                <span class="inline-flex rounded-full bg-violet-500/10 px-2 py-0.5 text-[11px] font-medium text-violet-300">
                    {{ $signup->user?->getRoleNames()->first() ?? 'User' }}
                </span>
            </td>

            <td class="px-3 py-2.5 text-sm text-white">
                <div class="font-medium leading-tight">
                    {{ $signup->committee?->name ?? '—' }}
                </div>
            </td>

            <td class="px-3 py-2.5">
                @if ($signup->status === 'pending')
                    <span class="inline-flex rounded-full bg-amber-500/10 px-2 py-0.5 text-[11px] font-medium text-amber-300">
                        Pending
                    </span>
                @elseif ($signup->status === 'approved')
                    <span class="inline-flex rounded-full bg-emerald-500/10 px-2 py-0.5 text-[11px] font-medium text-emerald-300">
                        Approved
                    </span>
                @elseif ($signup->status === 'rejected')
                    <span class="inline-flex rounded-full bg-rose-500/10 px-2 py-0.5 text-[11px] font-medium text-rose-300">
                        Rejected
                    </span>
                @else
                    <span class="inline-flex rounded-full bg-zinc-800 px-2 py-0.5 text-[11px] font-medium text-zinc-300">
                        None
                    </span>
                @endif
            </td>

            <td class="px-3 py-2.5">
                @if ($signup->status === 'pending')
                    <div class="flex flex-wrap gap-1.5">
                        <button
                            wire:click="openActionModal('approve', {{ $signup->id }})"
                            class="rounded-lg bg-emerald-500 px-2.5 py-1 text-[11px] font-semibold text-zinc-950 transition hover:bg-emerald-400"
                        >
                            Approve
                        </button>

                        <button
                            wire:click="openActionModal('reject', {{ $signup->id }})"
                            class="rounded-lg bg-rose-500 px-2.5 py-1 text-[11px] font-semibold text-white transition hover:bg-rose-400"
                        >
                            Reject
                        </button>
                    </div>
                @else
                    <span class="text-[11px] text-zinc-500">—</span>
                @endif
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="6" class="py-8 text-center text-sm text-zinc-500">
                No volunteer submissions found
            </td>
        </tr>
    @endforelse
</tbody>
                </table>
            </div>

            <div class="border-t border-white/10 px-5 py-4">
                {{ $signups->links() }}
            </div>
        </div>
    </div>
    @if ($showActionModal)
    <div class="fixed inset-0 z-50">
        <div
            class="absolute inset-0 bg-black/60"
            wire:click="closeActionModal"
        ></div>

        <div class="relative flex min-h-full items-center justify-center px-4 py-6">
            <div class="w-full max-w-md rounded-2xl border border-white/10 bg-zinc-900 shadow-2xl">
                <div class="border-b border-white/10 px-6 py-4">
                    <h2 class="text-lg font-semibold text-white">
                        Confirm Action
                    </h2>
                </div>

                <div class="px-6 py-5">
                   <p class="text-sm leading-6 text-zinc-300">
                        {{ $selectedAction === 'approve'
                            ? 'This will mark the committee submission as approved.'
                            : 'This will mark the committee submission as rejected.' }}
                    </p>
                </div>

                <div class="flex justify-end gap-3 border-t border-white/10 px-6 py-4">
                    <button
                        wire:click="closeActionModal"
                        class="rounded-xl border border-white/10 px-4 py-2 text-sm font-medium text-zinc-300 transition hover:bg-white/5"
                    >
                        Cancel
                    </button>

                    <button
                        wire:click="confirmAction"
                        class="rounded-xl px-4 py-2 text-sm font-semibold transition {{ $selectedAction === 'approve' ? 'bg-emerald-500 text-zinc-950 hover:bg-emerald-400' : 'bg-rose-500 text-white hover:bg-rose-400' }}"
                    >
                        Yes, {{ $selectedAction === 'approve' ? 'Approve' : 'Reject' }}
                    </button>
                </div>
            </div>
        </div>
    </div>
@endif
</div>