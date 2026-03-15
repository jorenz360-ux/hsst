<div>
    <div class="mx-auto max-w-7xl space-y-6 p-6">
    {{-- Header --}}
    <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
        <div>
            <p class="text-xs font-semibold uppercase tracking-[0.22em] text-teal-400">
                User Management
            </p>
            <h1 class="mt-1 text-3xl font-semibold tracking-tight text-zinc-900 dark:text-white">
                Manage Users
            </h1>
            <p class="mt-2 max-w-2xl text-sm text-zinc-600 dark:text-zinc-400">
                View, filter, and manage user accounts linked to alumni records, batches, and assigned roles.
            </p>
        </div>

        <div class="flex flex-wrap gap-3">
            <button
                type="button"
                wire:click="resetFilters"
                class="inline-flex items-center justify-center rounded-2xl border border-zinc-200 bg-white px-4 py-2.5 text-sm font-medium text-zinc-700 shadow-sm transition hover:bg-zinc-50 dark:border-white/10 dark:bg-zinc-900 dark:text-zinc-200 dark:hover:bg-zinc-800"
            >
                Reset Filters
            </button>

            <a
                href="{{ route('users.create') }}"
                wire:navigate
                class="inline-flex items-center justify-center rounded-2xl bg-teal-500 px-4 py-2.5 text-sm font-semibold text-zinc-950 shadow-sm transition hover:bg-teal-400"
            >
                <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Add User
            </a>
        </div>
    </div>

    {{-- Stat Cards --}}
    <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
        <div class="rounded-3xl border border-zinc-200 bg-white p-5 shadow-sm dark:border-white/10 dark:bg-white/[0.03]">
            <p class="text-sm text-zinc-500 dark:text-zinc-400">Total Users</p>
            <div class="mt-2 text-3xl font-semibold tracking-tight text-zinc-900 dark:text-white">
                {{ $users->total() }}
            </div>
            <p class="mt-2 text-sm text-teal-500 dark:text-teal-400">
                Current filtered result set
            </p>
        </div>

        <div class="rounded-3xl border border-zinc-200 bg-white p-5 shadow-sm dark:border-white/10 dark:bg-white/[0.03]">
            <p class="text-sm text-zinc-500 dark:text-zinc-400">With Alumni Profile</p>
            <div class="mt-2 text-3xl font-semibold tracking-tight text-zinc-900 dark:text-white">
                {{ $users->getCollection()->whereNotNull('alumni_id')->count() }}
            </div>
            <p class="mt-2 text-sm text-zinc-500 dark:text-zinc-400">
                Linked to alumni records
            </p>
        </div>

        <div class="rounded-3xl border border-zinc-200 bg-white p-5 shadow-sm dark:border-white/10 dark:bg-white/[0.03]">
            <p class="text-sm text-zinc-500 dark:text-zinc-400">Batch Representatives</p>
            <div class="mt-2 text-3xl font-semibold tracking-tight text-zinc-900 dark:text-white">
                {{ $users->getCollection()->filter(fn($u) => $u->alumni?->is_batch_rep)->count() }}
            </div>
            <p class="mt-2 text-sm text-zinc-500 dark:text-zinc-400">
                In current page results
            </p>
        </div>

        <div class="rounded-3xl border border-zinc-200 bg-white p-5 shadow-sm dark:border-white/10 dark:bg-white/[0.03]">
            <p class="text-sm text-zinc-500 dark:text-zinc-400">Active Role Filter</p>
            <div class="mt-2 text-xl font-semibold tracking-tight text-zinc-900 dark:text-white">
                {{ $role === 'all' ? 'All Roles' : str($role)->headline() }}
            </div>
            <p class="mt-2 text-sm text-zinc-500 dark:text-zinc-400">
                Current role scope
            </p>
        </div>
    </div>

    {{-- Filters --}}
    <div class="rounded-3xl border border-zinc-200 bg-white/90 p-5 shadow-sm backdrop-blur-sm dark:border-white/10 dark:bg-white/[0.03]">
        <div class="mb-5 flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
            <div>
                <h2 class="text-lg font-semibold text-zinc-900 dark:text-white">Advanced Filters</h2>
                <p class="text-sm text-zinc-600 dark:text-zinc-400">
                    Refine results using account, alumni, and batch-related fields.
                </p>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-4 xl:grid-cols-12">
            {{-- Search --}}
            <div class="xl:col-span-4">
                <label class="mb-1 block text-sm font-medium text-zinc-700 dark:text-zinc-300">
                    Search
                </label>
                <div class="relative">
                    <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-zinc-400">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m21 21-4.35-4.35m1.85-5.15a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z"/>
                        </svg>
                    </span>
                    <input
                        type="text"
                        wire:model.live.debounce.300ms="search"
                        placeholder="Username, email, name, or batch..."
                        class="w-full rounded-2xl border border-zinc-200 bg-white pl-10 pr-4 py-2.5 text-sm text-zinc-900 outline-none transition focus:border-teal-400 focus:ring-2 focus:ring-teal-500/20 dark:border-white/10 dark:bg-zinc-950 dark:text-white"
                    />
                </div>
            </div>

            {{-- Role --}}
            <div class="xl:col-span-2">
                <label class="mb-1 block text-sm font-medium text-zinc-700 dark:text-zinc-300">
                    Role
                </label>
                <select
                    wire:model.live="role"
                    class="w-full rounded-2xl border border-zinc-200 bg-white px-4 py-2.5 text-sm text-zinc-900 outline-none transition focus:border-teal-400 focus:ring-2 focus:ring-teal-500/20 dark:border-white/10 dark:bg-zinc-950 dark:text-white"
                >
                    @foreach ($roles as $r)
                        <option value="{{ $r }}">
                            {{ $r === 'all' ? 'All roles' : str($r)->headline() }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Has Alumni --}}
            <div class="xl:col-span-2">
                <label class="mb-1 block text-sm font-medium text-zinc-700 dark:text-zinc-300">
                    Alumni Profile
                </label>
                <select
                    wire:model.live="hasAlumni"
                    class="w-full rounded-2xl border border-zinc-200 bg-white px-4 py-2.5 text-sm text-zinc-900 outline-none transition focus:border-teal-400 focus:ring-2 focus:ring-teal-500/20 dark:border-white/10 dark:bg-zinc-950 dark:text-white"
                >
                    <option value="all">All</option>
                    <option value="yes">With Alumni</option>
                    <option value="no">Without Alumni</option>
                </select>
            </div>

            {{-- Batch Rep --}}
            <div class="xl:col-span-2">
                <label class="mb-1 block text-sm font-medium text-zinc-700 dark:text-zinc-300">
                    Batch Rep
                </label>
                <select
                    wire:model.live="isBatchRep"
                    class="w-full rounded-2xl border border-zinc-200 bg-white px-4 py-2.5 text-sm text-zinc-900 outline-none transition focus:border-teal-400 focus:ring-2 focus:ring-teal-500/20 dark:border-white/10 dark:bg-zinc-950 dark:text-white"
                >
                    <option value="all">All</option>
                    <option value="yes">Yes</option>
                    <option value="no">No</option>
                </select>
            </div>

            {{-- Per Page --}}
            <div class="xl:col-span-2">
                <label class="mb-1 block text-sm font-medium text-zinc-700 dark:text-zinc-300">
                    Per Page
                </label>
                <select
                    wire:model.live="perPage"
                    class="w-full rounded-2xl border border-zinc-200 bg-white px-4 py-2.5 text-sm text-zinc-900 outline-none transition focus:border-teal-400 focus:ring-2 focus:ring-teal-500/20 dark:border-white/10 dark:bg-zinc-950 dark:text-white"
                >
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                </select>
            </div>

            {{-- Batch --}}
            <div class="xl:col-span-4">
                <label class="mb-1 block text-sm font-medium text-zinc-700 dark:text-zinc-300">
                    Batch
                </label>
                <select
                    wire:model.live="batchId"
                    class="w-full rounded-2xl border border-zinc-200 bg-white px-4 py-2.5 text-sm text-zinc-900 outline-none transition focus:border-teal-400 focus:ring-2 focus:ring-teal-500/20 dark:border-white/10 dark:bg-zinc-950 dark:text-white"
                >
                    <option value="all">All batches</option>
                    @foreach($batches as $batch)
                        <option value="{{ $batch->id }}">
                            {{ $batch->schoolyear }} • Grad: {{ $batch->yeargrad }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Graduation year --}}
            <div class="xl:col-span-3">
                <label class="mb-1 block text-sm font-medium text-zinc-700 dark:text-zinc-300">
                    Graduation year
                </label>
                <select
                    wire:model.live="yearGrad"
                    class="w-full rounded-2xl border border-zinc-200 bg-white px-4 py-2.5 text-sm text-zinc-900 outline-none transition focus:border-teal-400 focus:ring-2 focus:ring-teal-500/20 dark:border-white/10 dark:bg-zinc-950 dark:text-white"
                >
                    <option value="all">All years</option>
                    @foreach($yearGrads as $year)
                        <option value="{{ $year }}">{{ $year }}</option>
                    @endforeach
                </select>
            </div>

            {{-- School year --}}
            <div class="xl:col-span-3">
                <label class="mb-1 block text-sm font-medium text-zinc-700 dark:text-zinc-300">
                    School year
                </label>
                <select
                    wire:model.live="schoolyear"
                    class="w-full rounded-2xl border border-zinc-200 bg-white px-4 py-2.5 text-sm text-zinc-900 outline-none transition focus:border-teal-400 focus:ring-2 focus:ring-teal-500/20 dark:border-white/10 dark:bg-zinc-950 dark:text-white"
                >
                    <option value="all">All school years</option>
                    @foreach($schoolyears as $schoolyearOption)
                        <option value="{{ $schoolyearOption }}">{{ $schoolyearOption }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Active Filter Pills --}}
            <div class="xl:col-span-2">
                <label class="mb-1 block text-sm font-medium text-zinc-700 dark:text-zinc-300">
                    Active Filters
                </label>
                <div class="flex min-h-[42px] flex-wrap items-center gap-2 rounded-2xl border border-dashed border-zinc-200 bg-zinc-50 px-3 py-2 dark:border-white/10 dark:bg-zinc-950">
                    @php
                        $activeCount = collect([
                            $search !== '',
                            $role !== 'all',
                            $hasAlumni !== 'all',
                            $isBatchRep !== 'all',
                            $batchId !== 'all',
                            $yearGrad !== 'all',
                            $schoolyear !== 'all',
                        ])->filter()->count();
                    @endphp

                    @if($activeCount > 0)
                        <span class="inline-flex items-center rounded-full bg-teal-500/10 px-2.5 py-1 text-xs font-medium text-teal-300">
                            {{ $activeCount }} active
                        </span>
                    @else
                        <span class="text-xs text-zinc-500 dark:text-zinc-400">
                            No filters applied
                        </span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Table Layout --}}
    <div class="overflow-hidden rounded-3xl border border-zinc-200 bg-white shadow-sm dark:border-white/10 dark:bg-white/[0.03]">
        {{-- Top Meta --}}
        <div class="flex flex-col gap-3 border-b border-zinc-200 px-5 py-4 dark:border-white/10 md:flex-row md:items-center md:justify-between">
            <div>
                <h2 class="text-lg font-semibold text-zinc-900 dark:text-white">User Directory</h2>
                <p class="text-sm text-zinc-600 dark:text-zinc-400">
                    Browse registered users and linked alumni records.
                </p>
            </div>

            <div class="text-sm text-zinc-500 dark:text-zinc-400">
                Showing
                <span class="font-medium text-zinc-800 dark:text-zinc-200">{{ $users->firstItem() ?? 0 }}</span>
                to
                <span class="font-medium text-zinc-800 dark:text-zinc-200">{{ $users->lastItem() ?? 0 }}</span>
                of
                <span class="font-medium text-zinc-800 dark:text-zinc-200">{{ $users->total() }}</span>
                users
            </div>
        </div>

        {{-- Desktop Table --}}
        <div class="hidden overflow-x-auto lg:block">
            <table class="min-w-full text-left text-sm">
                <thead class="bg-zinc-50 text-zinc-600 dark:bg-zinc-900/70 dark:text-zinc-300">
                    <tr>
                        <th class="px-5 py-4 text-xs font-semibold uppercase tracking-[0.14em]">User</th>
                        <th class="px-5 py-4 text-xs font-semibold uppercase tracking-[0.14em]">Full Name</th>
                        <th class="px-5 py-4 text-xs font-semibold uppercase tracking-[0.14em]">Batch</th>
                        <th class="px-5 py-4 text-xs font-semibold uppercase tracking-[0.14em]">Role</th>
                        <th class="px-5 py-4 text-xs font-semibold uppercase tracking-[0.14em]">Batch Rep</th>
                        <th class="px-5 py-4 text-right text-xs font-semibold uppercase tracking-[0.14em]">Actions</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-zinc-100 dark:divide-white/10">
                    @forelse ($users as $user)
                        <tr wire:key="user-{{ $user->id }}" class="transition hover:bg-zinc-50/80 dark:hover:bg-white/[0.03]">
                            <td class="px-5 py-4 align-top">
                                <div class="flex items-start gap-3">
                                    <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-teal-500/10 text-sm font-semibold text-teal-300">
                                        {{ strtoupper(substr($user->username, 0, 1)) }}
                                    </div>
                                    <div class="min-w-0">
                                        <div class="truncate font-semibold text-zinc-900 dark:text-white">
                                            {{ $user->username }}
                                        </div>
                                        <div class="mt-1 truncate text-sm text-zinc-500 dark:text-zinc-400">
                                            {{ $user->email }}
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <td class="px-5 py-4 align-top">
                                @if ($user->alumni)
                                    <div class="font-medium text-zinc-800 dark:text-zinc-200">
                                        {{ trim($user->alumni->fname . ' ' . $user->alumni->lname) }}
                                    </div>
                                    @if($user->alumni->mname)
                                        <div class="mt-1 text-xs text-zinc-500 dark:text-zinc-400">
                                            {{ $user->alumni->mname }}
                                        </div>
                                    @endif
                                @else
                                    <span class="inline-flex rounded-full border border-zinc-200 bg-zinc-100 px-2.5 py-1 text-xs font-medium text-zinc-600 dark:border-zinc-700 dark:bg-zinc-800 dark:text-zinc-300">
                                        No alumni profile
                                    </span>
                                @endif
                            </td>

                            <td class="px-5 py-4 align-top">
                                @if ($user->alumni?->batch)
                                    <div class="font-medium text-zinc-800 dark:text-zinc-200">
                                        {{ $user->alumni->batch->schoolyear ?? 'N/A' }}
                                    </div>
                                    <div class="mt-1 text-xs text-zinc-500 dark:text-zinc-400">
                                        Grad: {{ $user->alumni->batch->yeargrad ?? 'N/A' }}
                                    </div>
                                @else
                                    <span class="text-zinc-400 italic">N/A</span>
                                @endif
                            </td>

                            <td class="px-5 py-4 align-top">
                                <div class="flex flex-wrap gap-2">
                                    @forelse($user->getRoleNames() as $roleName)
                                        <span class="inline-flex items-center rounded-full border border-teal-500/20 bg-teal-500/10 px-2.5 py-1 text-xs font-medium text-teal-300">
                                            {{ str($roleName)->headline() }}
                                        </span>
                                    @empty
                                        <span class="inline-flex items-center rounded-full border border-zinc-200 bg-zinc-100 px-2.5 py-1 text-xs font-medium text-zinc-600 dark:border-zinc-700 dark:bg-zinc-800 dark:text-zinc-300">
                                            User
                                        </span>
                                    @endforelse
                                </div>
                            </td>

                            <td class="px-5 py-4 align-top">
                                @if($user->alumni?->is_batch_rep)
                                    <span class="inline-flex items-center rounded-full border border-cyan-500/20 bg-cyan-500/10 px-2.5 py-1 text-xs font-medium text-cyan-300">
                                        Yes
                                    </span>
                                @else
                                    <span class="inline-flex items-center rounded-full border border-zinc-200 bg-zinc-100 px-2.5 py-1 text-xs font-medium text-zinc-600 dark:border-zinc-700 dark:bg-zinc-800 dark:text-zinc-300">
                                        No
                                    </span>
                                @endif
                            </td>

                            <td class="px-5 py-4 text-right align-top">
                                <div class="flex justify-end gap-2">
                                    <button
                                        wire:click="edit({{ $user->id }})"
                                        class="inline-flex items-center rounded-xl border border-white/10 bg-zinc-900 px-3 py-2 text-sm font-medium text-zinc-200 transition hover:bg-zinc-800"
                                    >
                                        Edit
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-14 text-center">
                                <div class="mx-auto max-w-md">
                                    <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-zinc-100 text-zinc-400 dark:bg-zinc-900 dark:text-zinc-500">
                                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5V4H2v16h5m10 0v-4a3 3 0 0 0-3-3H10a3 3 0 0 0-3 3v4m10 0H7m8-10a4 4 0 1 1-8 0 4 4 0 0 1 8 0Z"/>
                                        </svg>
                                    </div>
                                    <h3 class="mt-4 text-lg font-semibold text-zinc-900 dark:text-white">
                                        No users found
                                    </h3>
                                    <p class="mt-2 text-sm text-zinc-600 dark:text-zinc-400">
                                        Try changing the active filters or search query.
                                    </p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Mobile Cards --}}
        <div class="space-y-4 p-4 lg:hidden">
            @forelse ($users as $user)
                <div wire:key="user-mobile-{{ $user->id }}" class="rounded-2xl border border-zinc-200 bg-white p-4 shadow-sm dark:border-white/10 dark:bg-zinc-950/60">
                    <div class="flex items-start justify-between gap-3">
                        <div class="flex items-start gap-3">
                            <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-teal-500/10 text-sm font-semibold text-teal-300">
                                {{ strtoupper(substr($user->username, 0, 1)) }}
                            </div>
                            <div>
                                <div class="font-semibold text-zinc-900 dark:text-white">{{ $user->username }}</div>
                                <div class="text-sm text-zinc-500 dark:text-zinc-400">{{ $user->email }}</div>
                            </div>
                        </div>

                        <button
                            wire:click="edit({{ $user->id }})"
                            class="rounded-xl border border-white/10 bg-zinc-900 px-3 py-2 text-xs font-medium text-zinc-200 transition hover:bg-zinc-800"
                        >
                            Edit
                        </button>
                    </div>

                    <div class="mt-4 space-y-3 text-sm">
                        <div>
                            <p class="text-xs uppercase tracking-[0.14em] text-zinc-500">Full Name</p>
                            <p class="mt-1 text-zinc-800 dark:text-zinc-200">
                                {{ $user->alumni ? trim($user->alumni->fname . ' ' . $user->alumni->lname) : 'No alumni profile' }}
                            </p>
                        </div>

                        <div>
                            <p class="text-xs uppercase tracking-[0.14em] text-zinc-500">Batch</p>
                            <p class="mt-1 text-zinc-800 dark:text-zinc-200">
                                @if ($user->alumni?->batch)
                                    {{ $user->alumni->batch->schoolyear ?? 'N/A' }} • Grad: {{ $user->alumni->batch->yeargrad ?? 'N/A' }}
                                @else
                                    N/A
                                @endif
                            </p>
                        </div>

                        <div>
                            <p class="text-xs uppercase tracking-[0.14em] text-zinc-500">Role</p>
                            <div class="mt-2 flex flex-wrap gap-2">
                                @forelse($user->getRoleNames() as $roleName)
                                    <span class="inline-flex items-center rounded-full border border-teal-500/20 bg-teal-500/10 px-2.5 py-1 text-xs font-medium text-teal-300">
                                        {{ str($roleName)->headline() }}
                                    </span>
                                @empty
                                    <span class="inline-flex items-center rounded-full border border-zinc-200 bg-zinc-100 px-2.5 py-1 text-xs font-medium text-zinc-600 dark:border-zinc-700 dark:bg-zinc-800 dark:text-zinc-300">
                                        User
                                    </span>
                                @endforelse
                            </div>
                        </div>

                        <div>
                            <p class="text-xs uppercase tracking-[0.14em] text-zinc-500">Batch Representative</p>
                            <div class="mt-2">
                                @if($user->alumni?->is_batch_rep)
                                    <span class="inline-flex items-center rounded-full border border-cyan-500/20 bg-cyan-500/10 px-2.5 py-1 text-xs font-medium text-cyan-300">
                                        Yes
                                    </span>
                                @else
                                    <span class="inline-flex items-center rounded-full border border-zinc-200 bg-zinc-100 px-2.5 py-1 text-xs font-medium text-zinc-600 dark:border-zinc-700 dark:bg-zinc-800 dark:text-zinc-300">
                                        No
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="rounded-2xl border border-zinc-200 bg-white p-8 text-center dark:border-white/10 dark:bg-zinc-950/60">
                    <h3 class="text-lg font-semibold text-zinc-900 dark:text-white">No users found</h3>
                    <p class="mt-2 text-sm text-zinc-600 dark:text-zinc-400">
                        Try adjusting the filter settings.
                    </p>
                </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        <div class="border-t border-zinc-200 px-5 py-4 dark:border-white/10">
            {{ $users->links() }}
        </div>
    </div>
</div>
</div>