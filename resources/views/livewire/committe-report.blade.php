<div class="min-h-screen  text-gray-800">
    <div class="mx-auto max-w-7xl space-y-6 p-6">

        @if (session()->has('success'))
            <div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
                {{ session('success') }}
            </div>
        @endif

        @if (session()->has('error'))
            <div class="rounded-2xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-700">
                {{ session('error') }}
            </div>
        @endif

        {{-- Header --}}
        <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.22em] text-amber-600">
                    Volunteer Approval Queue
                </p>
                <h1 class="mt-1 text-3xl font-semibold tracking-tight text-gray-900">
                    Volunteer Submissions
                </h1>
                <p class="mt-2 max-w-3xl text-sm text-gray-500">
                    Review each committee submission individually. This now supports alumni with multiple education levels and batch memberships.
                </p>
            </div>

            <div class="flex flex-wrap gap-3">
                <button
                    wire:click="resetFilters"
                    class="inline-flex items-center justify-center rounded-2xl border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 transition hover:bg-gray-50"
                >
                    Reset Filters
                </button>

                <button
                    wire:click="downloadExcel"
                    wire:loading.attr="disabled"
                    class="inline-flex items-center justify-center rounded-2xl bg-emerald-600 px-4 py-2.5 text-sm font-semibold text-white shadow transition hover:bg-emerald-500 disabled:opacity-60"
                >
                    Download CSV
                </button>
            </div>
        </div>

        {{-- Filters --}}
        <div class="rounded-3xl border border-gray-200 bg-white p-5">
            <div class="mb-4 flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
                <h2 class="text-lg font-semibold text-gray-900">Advanced Filters</h2>
                <p class="text-xs text-gray-400">
                    Filter by user, alumni, level, batch, role, committee, and submission status
                </p>
            </div>

            <div class="grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-12">
                <div class="xl:col-span-4">
                    <input
                        type="text"
                        wire:model.live.debounce.300ms="search"
                        placeholder="Search user, alumni, committee, notes, batch..."
                        class="w-full rounded-2xl border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 outline-none placeholder:text-gray-400 focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20"
                    />
                </div>

                <div class="xl:col-span-2">
                    <select
                        wire:model.live="role"
                        class="w-full rounded-2xl border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20"
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
                        class="w-full rounded-2xl border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20"
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
                        class="w-full rounded-2xl border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20"
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
                        wire:model.live="level"
                        class="w-full rounded-2xl border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20"
                    >
                        @foreach ($levels as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="xl:col-span-2">
                    <select
                        wire:model.live="batchId"
                        class="w-full rounded-2xl border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20"
                    >
                        <option value="all">All batches</option>
                        @foreach ($batches as $batch)
                            <option value="{{ $batch->id }}">
                                {{ str($batch->level)->headline() }} • {{ $batch->schoolyear }} @if($batch->yeargrad) • Grad: {{ $batch->yeargrad }} @endif
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="xl:col-span-2">
                    <select
                        wire:model.live="yearGrad"
                        class="w-full rounded-2xl border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20"
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
                        class="w-full rounded-2xl border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20"
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
                        class="w-full rounded-2xl border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20"
                    >
                        <option value="all">All batch rep flags</option>
                        <option value="yes">Batch rep only</option>
                        <option value="no">Non-batch rep only</option>
                    </select>
                </div>

                <div class="xl:col-span-2">
                    <select
                        wire:model.live="hasAlumni"
                        class="w-full rounded-2xl border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20"
                    >
                        <option value="all">All alumni links</option>
                        <option value="yes">With alumni profile</option>
                        <option value="no">No alumni profile</option>
                    </select>
                </div>

                <div class="xl:col-span-2">
                    <select
                        wire:model.live="perPage"
                        class="w-full rounded-2xl border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20"
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
        <div class="overflow-hidden rounded-3xl border border-gray-200 bg-white">
            <div class="border-b border-gray-200 px-5 py-4">
                <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
                    <h2 class="text-lg font-semibold text-gray-900">Volunteer Submissions</h2>
                    <p class="text-xs text-gray-400">
                        One row per committee submission
                    </p>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="border-b border-gray-200 bg-gray-50 text-gray-500">
                        <tr>
                            <th class="px-5 py-4 text-left font-medium">ID</th>
                            <th class="px-5 py-4 text-left font-medium">Full Name</th>
                            <th class="px-5 py-4 text-left font-medium">Level / Batch</th>
                            <th class="px-5 py-4 text-left font-medium">Role</th>
                            <th class="px-5 py-4 text-left font-medium">Committee</th>
                            <th class="px-5 py-4 text-left font-medium">Status</th>
                            <th class="px-5 py-4 text-left font-medium">Actions</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-200">
                        @forelse ($signups as $signup)
                            @php
                                $matchedEducation = null;

                                if ($signup->alumni?->educations?->isNotEmpty()) {
                                    $matchedEducation = $batchId !== 'all'
                                        ? $signup->alumni->educations->firstWhere('batch_id', (int) $batchId)
                                        : $signup->alumni->educations->sortBy(fn($edu) => match($edu->batch?->level) {
                                            'elementary' => 1,
                                            'highschool' => 2,
                                            'college' => 3,
                                            default => 99,
                                        })->first();
                                }
                            @endphp

                            <tr class="transition hover:bg-amber-50/60">
                                <td class="px-3 py-2.5 text-sm font-medium text-gray-800">
                                    {{ $signup->id }}
                                </td>

                                <td class="px-3 py-2.5 text-sm text-gray-700">
                                    {{ $signup->alumni ? trim($signup->alumni->fname . ' ' . $signup->alumni->lname) : 'N/A' }}
                                </td>

                                <td class="px-3 py-2.5 text-sm text-gray-600">
                                    @if ($matchedEducation?->batch)
                                        <div class="flex flex-wrap gap-1">
                                            <span class="rounded-full border border-sky-200 bg-sky-50 px-2 py-0.5 text-[11px] font-medium text-sky-700">
                                                {{ str($matchedEducation->batch->level)->headline() }}
                                            </span>
                                            <span>{{ $matchedEducation->batch->schoolyear }}</span>
                                            @if ($matchedEducation->is_batch_rep)
                                                <span class="rounded-full border border-emerald-200 bg-emerald-50 px-2 py-0.5 text-[11px] font-medium text-emerald-700">
                                                    Rep
                                                </span>
                                            @endif
                                        </div>
                                    @else
                                        N/A
                                    @endif
                                </td>

                                <td class="px-3 py-2.5">
                                    <span class="inline-flex rounded-full border border-violet-200 bg-violet-50 px-2 py-0.5 text-[11px] font-medium text-violet-700">
                                        {{ $signup->user?->getRoleNames()->first() ?? 'User' }}
                                    </span>
                                </td>

                                <td class="px-3 py-2.5 text-sm font-medium text-gray-800">
                                    {{ $signup->committee?->name ?? '—' }}
                                </td>

                                <td class="px-3 py-2.5">
                                    @if ($signup->status === 'pending')
                                        <span class="inline-flex rounded-full border border-amber-200 bg-amber-50 px-2 py-0.5 text-[11px] font-medium text-amber-700">
                                            Pending
                                        </span>
                                    @elseif ($signup->status === 'approved')
                                        <span class="inline-flex rounded-full border border-emerald-200 bg-emerald-50 px-2 py-0.5 text-[11px] font-medium text-emerald-700">
                                            Approved
                                        </span>
                                    @elseif ($signup->status === 'rejected')
                                        <span class="inline-flex rounded-full border border-rose-200 bg-rose-50 px-2 py-0.5 text-[11px] font-medium text-rose-700">
                                            Rejected
                                        </span>
                                    @else
                                        <span class="inline-flex rounded-full border border-gray-200 bg-gray-100 px-2 py-0.5 text-[11px] font-medium text-gray-600">
                                            None
                                        </span>
                                    @endif
                                </td>

                                <td class="px-3 py-2.5">
                                    <div class="flex flex-wrap gap-1.5">
                                        <button
                                            wire:click="openViewModal({{ $signup->id }})"
                                            class="rounded-lg bg-sky-500 px-2.5 py-1 text-[11px] font-semibold text-white transition hover:bg-sky-600"
                                        >
                                            View
                                        </button>

                                        @if ($signup->status === 'pending')
                                            <button
                                                wire:click="openActionModal('approve', {{ $signup->id }})"
                                                class="rounded-lg bg-emerald-600 px-2.5 py-1 text-[11px] font-semibold text-white transition hover:bg-emerald-500"
                                            >
                                                Approve
                                            </button>

                                            <button
                                                wire:click="openActionModal('reject', {{ $signup->id }})"
                                                class="rounded-lg bg-rose-500 px-2.5 py-1 text-[11px] font-semibold text-white transition hover:bg-rose-600"
                                            >
                                                Reject
                                            </button>
                                        @endif

                                        <button
                                            wire:click="openActionModal('delete', {{ $signup->id }})"
                                            class="rounded-lg border border-rose-200 bg-rose-50 px-2.5 py-1 text-[11px] font-semibold text-rose-600 transition hover:bg-rose-100"
                                        >
                                            Remove
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-8 text-center text-sm text-gray-400">
                                    No volunteer submissions found
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="border-t border-gray-200 px-5 py-4">
                {{ $signups->links() }}
            </div>
        </div>
    </div>

    {{-- Action Modal --}}
    @if ($showActionModal)
        <div class="fixed inset-0 z-50">
            <div
                class="absolute inset-0 bg-black/40"
                wire:click="closeActionModal"
            ></div>

            <div class="relative flex min-h-full items-center justify-center px-4 py-6">
                <div class="w-full max-w-md rounded-2xl border border-gray-200 bg-white shadow-xl">
                    <div class="border-b border-gray-200 px-6 py-4">
                        <h2 class="text-lg font-semibold text-gray-900">
                            Confirm Action
                        </h2>
                    </div>

                    <div class="px-6 py-5">
                        <p class="text-sm leading-6 text-gray-600">
                            @if ($selectedAction === 'approve')
                                This will mark the committee submission as approved.
                            @elseif ($selectedAction === 'reject')
                                This will mark the committee submission as rejected.
                            @elseif ($selectedAction === 'delete')
                                This will permanently remove this alumni from the selected committee submission.
                            @endif
                        </p>
                    </div>

                    <div class="flex justify-end gap-3 border-t border-gray-200 px-6 py-4">
                        <button
                            wire:click="closeActionModal"
                            class="rounded-xl border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 transition hover:bg-gray-50"
                        >
                            Cancel
                        </button>

                        <button
                            wire:click="confirmAction"
                            class="rounded-xl px-4 py-2 text-sm font-semibold text-white transition
                                {{ $selectedAction === 'approve'
                                    ? 'bg-emerald-600 hover:bg-emerald-500'
                                    : ($selectedAction === 'reject'
                                        ? 'bg-rose-500 hover:bg-rose-600'
                                        : 'bg-rose-600 hover:bg-rose-700') }}"
                        >
                            Yes,
                            {{ $selectedAction === 'approve'
                                ? 'Approve'
                                : ($selectedAction === 'reject' ? 'Reject' : 'Remove') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- View Modal --}}
    @if ($showViewModal && $selectedSignup)
        <div class="fixed inset-0 z-50">
            <div
                class="absolute inset-0 bg-black/50"
                wire:click="closeViewModal"
            ></div>

            <div class="relative flex min-h-full items-center justify-center px-4 py-6">
                <div class="max-h-[90vh] w-full max-w-4xl overflow-hidden rounded-3xl border border-gray-200 bg-white shadow-2xl">
                    <div class="flex items-center justify-between border-b border-gray-200 px-6 py-4">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-[0.18em] text-amber-600">
                                Volunteer Submission Details
                            </p>
                            <h2 class="mt-1 text-xl font-semibold text-gray-900">
                                {{ $selectedSignup->alumni ? trim($selectedSignup->alumni->fname . ' ' . $selectedSignup->alumni->lname) : ($selectedSignup->user?->username ?? 'Submission') }}
                            </h2>
                        </div>

                        <button
                            wire:click="closeViewModal"
                            class="rounded-xl border border-gray-300 bg-white px-3 py-2 text-sm text-gray-600 transition hover:bg-gray-50"
                        >
                            Close
                        </button>
                    </div>

                    <div class="max-h-[calc(90vh-80px)] space-y-6 overflow-y-auto p-6">
                        <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
                            <div class="rounded-2xl border border-gray-200 bg-gray-50 p-4">
                                <p class="text-xs uppercase tracking-wide text-gray-400">Username</p>
                                <p class="mt-2 text-sm font-medium text-gray-800">{{ $selectedSignup->user?->username ?? 'N/A' }}</p>
                            </div>

                            <div class="rounded-2xl border border-gray-200 bg-gray-50 p-4">
                                <p class="text-xs uppercase tracking-wide text-gray-400">Email</p>
                                <p class="mt-2 text-sm font-medium text-gray-800">{{ $selectedSignup->user?->email ?? 'N/A' }}</p>
                            </div>

                            <div class="rounded-2xl border border-gray-200 bg-gray-50 p-4">
                                <p class="text-xs uppercase tracking-wide text-gray-400">Committee</p>
                                <p class="mt-2 text-sm font-medium text-gray-800">{{ $selectedSignup->committee?->name ?? 'N/A' }}</p>
                            </div>

                            <div class="rounded-2xl border border-gray-200 bg-gray-50 p-4">
                                <p class="text-xs uppercase tracking-wide text-gray-400">Status</p>
                                <p class="mt-2 text-sm font-medium text-gray-800">{{ str($selectedSignup->status ?? 'none')->headline() }}</p>
                            </div>
                        </div>

                        @if ($selectedSignup->alumni)
                            <div class="grid gap-6 xl:grid-cols-2">
                                <div class="rounded-3xl border border-gray-200 bg-gray-50 p-5">
                                    <h4 class="text-lg font-semibold text-gray-900">Personal Information</h4>

                                    <div class="mt-4 grid gap-4 sm:grid-cols-2">
                                        <div>
                                            <p class="text-xs uppercase tracking-wide text-gray-400">First Name</p>
                                            <p class="mt-1 text-sm text-gray-700">{{ $selectedSignup->alumni->fname ?: 'N/A' }}</p>
                                        </div>
                                        <div>
                                            <p class="text-xs uppercase tracking-wide text-gray-400">Middle Name</p>
                                            <p class="mt-1 text-sm text-gray-700">{{ $selectedSignup->alumni->mname ?: 'N/A' }}</p>
                                        </div>
                                        <div>
                                            <p class="text-xs uppercase tracking-wide text-gray-400">Last Name</p>
                                            <p class="mt-1 text-sm text-gray-700">{{ $selectedSignup->alumni->lname ?: 'N/A' }}</p>
                                        </div>
                                        <div>
                                            <p class="text-xs uppercase tracking-wide text-gray-400">Cellphone</p>
                                            <p class="mt-1 text-sm text-gray-700">{{ $selectedSignup->alumni->cellphone ?: 'N/A' }}</p>
                                        </div>
                                        <div class="sm:col-span-2">
                                            <p class="text-xs uppercase tracking-wide text-gray-400">Occupation</p>
                                            <p class="mt-1 text-sm text-gray-700">{{ $selectedSignup->alumni->occupation ?: 'N/A' }}</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="rounded-3xl border border-gray-200 bg-gray-50 p-5">
                                    <h4 class="text-lg font-semibold text-gray-900">Address</h4>

                                    <div class="mt-4 space-y-3">
                                        <div>
                                            <p class="text-xs uppercase tracking-wide text-gray-400">Full Address</p>
                                            <p class="mt-1 text-sm text-gray-700">
                                                {{
                                                    collect([
                                                        $selectedSignup->alumni->address_line_1,
                                                        $selectedSignup->alumni->address_line_2,
                                                        $selectedSignup->alumni->city,
                                                        $selectedSignup->alumni->state_province,
                                                        $selectedSignup->alumni->postal_code,
                                                        $selectedSignup->alumni->country,
                                                    ])->filter()->implode(', ') ?: 'N/A'
                                                }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="rounded-3xl border border-gray-200 bg-gray-50 p-5">
                                <h4 class="text-lg font-semibold text-gray-900">Educational Background</h4>

                                <div class="mt-4 space-y-4">
                                    @forelse ($selectedSignup->alumni->educations->sortBy(fn($edu) => match($edu->batch?->level) {
                                        'elementary' => 1,
                                        'highschool' => 2,
                                        'college' => 3,
                                        default => 99,
                                    }) as $education)
                                        <div class="rounded-2xl border border-gray-200 bg-white p-4">
                                            <div class="flex flex-wrap items-center gap-2">
                                                <span class="rounded-full border border-sky-200 bg-sky-50 px-3 py-1 text-xs font-semibold text-sky-700">
                                                    {{ str($education->batch?->level ?? 'n/a')->headline() }}
                                                </span>

                                                @if ($education->is_batch_rep)
                                                    <span class="rounded-full border border-emerald-200 bg-emerald-50 px-3 py-1 text-xs font-semibold text-emerald-700">
                                                        Batch Representative
                                                    </span>
                                                @endif
                                            </div>

                                            <div class="mt-4 grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
                                                <div>
                                                    <p class="text-xs uppercase tracking-wide text-gray-400">School Year</p>
                                                    <p class="mt-1 text-sm text-gray-700">{{ $education->batch?->schoolyear ?? 'N/A' }}</p>
                                                </div>
                                                <div>
                                                    <p class="text-xs uppercase tracking-wide text-gray-400">Year Graduated</p>
                                                    <p class="mt-1 text-sm text-gray-700">{{ $education->batch?->yeargrad ?? 'N/A' }}</p>
                                                </div>
                                                <div>
                                                    <p class="text-xs uppercase tracking-wide text-gray-400">Did Graduate</p>
                                                    <p class="mt-1 text-sm text-gray-700">{{ $education->did_graduate ? 'Yes' : 'No' }}</p>
                                                </div>
                                                <div>
                                                    <p class="text-xs uppercase tracking-wide text-gray-400">School Year Attended</p>
                                                    <p class="mt-1 text-sm text-gray-700">{{ $education->school_year_attended ?: 'N/A' }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="rounded-2xl border border-dashed border-gray-300 bg-white p-5 text-sm text-gray-400">
                                            No education records found.
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                        @endif

                        <div class="rounded-3xl border border-gray-200 bg-gray-50 p-5">
                            <h4 class="text-lg font-semibold text-gray-900">Submission Notes</h4>
                            <p class="mt-3 text-sm leading-6 text-gray-600">
                                {{ $selectedSignup->notes ?: 'No notes provided.' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
