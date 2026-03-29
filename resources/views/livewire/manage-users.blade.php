<div class="min-h-screen bg-zinc-950 text-zinc-100 rounded-2xl">
    <div class="mx-auto max-w-7xl space-y-6 p-6">

    {{-- Header --}}
    <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
        <div>
            <p class="text-xs font-semibold uppercase tracking-[0.22em] text-amber-400">
                User Management
            </p>
            <h1 class="mt-1 text-3xl font-semibold tracking-tight text-white">
                Manage Users
            </h1>
            <p class="mt-2 max-w-2xl text-sm text-zinc-400">
                View, filter, and manage user accounts linked to alumni records, batches, and assigned roles.
            </p>
        </div> 

        <div class="flex flex-wrap gap-3">
            <button
                wire:click="resetFilters"
                class="inline-flex items-center justify-center rounded-2xl border border-white/10 bg-zinc-900 px-4 py-2.5 text-sm font-medium text-zinc-200 transition hover:bg-zinc-800"
            >
                Reset Filters
            </button>

            <a
                href="{{ route('users.create') }}"
                wire:navigate
                class="inline-flex items-center justify-center rounded-2xl bg-amber-500 px-4 py-2.5 text-sm font-semibold text-zinc-950 shadow hover:bg-amber-400"
            >
                Add User
            </a>
        </div>
    </div>

    {{-- Stat Cards --}}
    <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
        <div class="rounded-3xl border border-amber-500/10 bg-zinc-900/70 p-5">
            <p class="text-sm text-zinc-400">Total Users</p>
            <div class="mt-2 text-3xl font-semibold text-white">
                {{ $users->total() }}
            </div>
            <p class="mt-2 text-sm text-amber-400">Current filtered result set</p>
        </div>

        <div class="rounded-3xl border border-violet-500/10 bg-zinc-900/70 p-5">
            <p class="text-sm text-zinc-400">With Alumni Profile</p>
            <div class="mt-2 text-3xl font-semibold text-white">
                {{ $users->getCollection()->whereNotNull('alumni_id')->count() }}
            </div>
        </div>

        <div class="rounded-3xl border border-sky-500/10 bg-zinc-900/70 p-5">
            <p class="text-sm text-zinc-400">Batch Representatives</p>
            <div class="mt-2 text-3xl font-semibold text-white">
                {{ $users->getCollection()->filter(fn($u) => $u->alumni?->is_batch_rep)->count() }}
            </div>
        </div>

        <div class="rounded-3xl border border-rose-500/10 bg-zinc-900/70 p-5">
            <p class="text-sm text-zinc-400">Active Role Filter</p>
            <div class="mt-2 text-xl font-semibold text-white">
                {{ $role === 'all' ? 'All Roles' : str($role)->headline() }}
            </div>
        </div>
    </div>

    {{-- Filters --}}
    <div class="rounded-3xl border border-white/10 bg-zinc-900/60 p-5">
        <h2 class="text-lg font-semibold text-white mb-4">Advanced Filters</h2>

        <div class="grid grid-cols-1 gap-4 xl:grid-cols-12">

            {{-- Search --}}
            <div class="xl:col-span-4">
                <input
                    type="text"
                    wire:model.live.debounce.300ms="search"
                    placeholder="Search..."
                    class="w-full rounded-2xl border border-white/10 bg-zinc-950 px-4 py-2.5 text-sm text-white outline-none focus:border-amber-400 focus:ring-2 focus:ring-amber-500/20"
                />
            </div>

            {{-- Role --}}
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

        </div>
    </div>

    {{-- Table --}}
    <div class="overflow-hidden rounded-3xl border border-white/10 bg-zinc-900/70">

        <div class="border-b border-white/10 px-5 py-4">
            <h2 class="text-lg font-semibold text-white">User Directory</h2>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-zinc-950/80 text-zinc-400">
                    <tr>
                        <th class="px-5 py-4">Id</th>
                        <th class="px-5 py-4">User</th>
                        <th class="px-5 py-4">Full Name</th>
                        <th class="px-5 py-4">Batch</th>
                        <th class="px-5 py-4">Role</th>
                        <th class="px-5 py-4">Actions</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-white/10">
                    @forelse ($users as $user)
                        <tr class="hover:bg-amber-500/[0.04] transition">
                              <td class="px-5 py-4 text-white">{{ $user->id}}</td>
                            <td class="px-5 py-4 text-white">{{ $user->username }}</td>

                            <td class="px-5 py-4 text-zinc-300">
                                {{ $user->alumni ? $user->alumni->fname . ' ' . $user->alumni->lname : 'N/A' }}
                            </td>

                            <td class="px-5 py-4 text-zinc-400">
                                {{ $user->alumni?->batch?->schoolyear ?? 'N/A' }}
                            </td>

                            <td class="px-5 py-4">
                                <span class="rounded-full bg-violet-500/10 px-2 py-1 text-xs text-violet-300">
                                    {{ $user->getRoleNames()->first() ?? 'User' }}
                                </span>
                            </td>

                            <td class="px-5 py-4">
                                <button class="text-amber-400 hover:text-amber-300">
                                    Edit
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-10 text-zinc-500">
                                No users found
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="border-t border-white/10 px-5 py-4">
            {{ $users->links() }}
        </div>
    </div>

    </div>
</div>