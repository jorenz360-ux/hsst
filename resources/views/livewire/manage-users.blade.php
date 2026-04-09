<div class="min-h-screen rounded-2xl bg-zinc-950 text-zinc-100">
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
                    View, filter, and manage user accounts linked to alumni records, multiple education levels, and assigned roles.
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
                    {{ $users->getCollection()->filter(fn($u) => $u->alumni?->educations?->contains(fn($edu) => $edu->is_batch_rep))->count() }}
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
            <h2 class="mb-4 text-lg font-semibold text-white">Advanced Filters</h2>

            <div class="grid grid-cols-1 gap-4 xl:grid-cols-12">
                <div class="xl:col-span-3">
                    <input
                        type="text"
                        wire:model.live.debounce.300ms="search"
                        placeholder="Search username, email, alumni, batch..."
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
                        wire:model.live="level"
                        class="w-full rounded-2xl border border-white/10 bg-zinc-950 px-4 py-2.5 text-sm text-white focus:border-amber-400 focus:ring-2 focus:ring-amber-500/20"
                    >
                        @foreach ($levels as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="xl:col-span-2">
                    <select
                        wire:model.live="isBatchRep"
                        class="w-full rounded-2xl border border-white/10 bg-zinc-950 px-4 py-2.5 text-sm text-white focus:border-amber-400 focus:ring-2 focus:ring-amber-500/20"
                    >
                        <option value="all">All Rep Status</option>
                        <option value="yes">Batch Rep Only</option>
                        <option value="no">Non-Rep Only</option>
                    </select>
                </div>

                <div class="xl:col-span-1">
                    <select
                        wire:model.live="hasAlumni"
                        class="w-full rounded-2xl border border-white/10 bg-zinc-950 px-4 py-2.5 text-sm text-white focus:border-amber-400 focus:ring-2 focus:ring-amber-500/20"
                    >
                        <option value="all">All</option>
                        <option value="yes">With Alumni</option>
                        <option value="no">No Alumni</option>
                    </select>
                </div>

                <div class="xl:col-span-2">
                    <select
                        wire:model.live="perPage"
                        class="w-full rounded-2xl border border-white/10 bg-zinc-950 px-4 py-2.5 text-sm text-white focus:border-amber-400 focus:ring-2 focus:ring-amber-500/20"
                    >
                        <option value="10">10 / page</option>
                        <option value="25">25 / page</option>
                        <option value="50">50 / page</option>
                        <option value="100">100 / page</option>
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
                            <th class="px-5 py-4 text-left">ID</th>
                            <th class="px-5 py-4 text-left">User</th>
                            <th class="px-5 py-4 text-left">Full Name</th>
                            <th class="px-5 py-4 text-left">Education Levels</th>
                            <th class="px-5 py-4 text-left">Role</th>
                            <th class="px-5 py-4 text-left">Actions</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-white/10">
                        @forelse ($users as $user)
                            <tr class="transition hover:bg-amber-500/[0.04]">
                                <td class="px-5 py-4 text-white">{{ $user->id }}</td>

                                <td class="px-5 py-4">
                                    <div class="space-y-1">
                                        <p class="font-medium text-white">{{ $user->username }}</p>
                                        <p class="text-xs text-zinc-400">{{ $user->email }}</p>
                                    </div>
                                </td>

                                <td class="px-5 py-4 text-zinc-300">
                                    {{ $user->alumni ? trim($user->alumni->fname . ' ' . $user->alumni->lname) : 'N/A' }}
                                </td>

                                <td class="px-5 py-4">
                                    @if ($user->alumni?->educations?->isNotEmpty())
                                        <div class="flex flex-wrap gap-2">
                                            @foreach ($user->alumni->educations->sortBy(fn($edu) => match($edu->batch?->level) {
                                                'elementary' => 1,
                                                'highschool' => 2,
                                                'college' => 3,
                                                default => 99,
                                            }) as $education)
                                                <span class="inline-flex items-center gap-1 rounded-full border border-white/10 bg-zinc-950 px-2.5 py-1 text-xs text-zinc-300">
                                                    <span class="font-semibold text-amber-400">
                                                        {{ str($education->batch?->level ?? 'n/a')->headline() }}
                                                    </span>
                                                    <span>•</span>
                                                    <span>{{ $education->batch?->schoolyear ?? 'N/A' }}</span>
                                                    @if ($education->is_batch_rep)
                                                        <span class="rounded-full bg-amber-500/15 px-2 py-0.5 text-[10px] font-semibold text-amber-300">
                                                            Rep
                                                        </span>
                                                    @endif
                                                </span>
                                            @endforeach
                                        </div>
                                    @else
                                        <span class="text-zinc-500">N/A</span>
                                    @endif
                                </td>

                                <td class="px-5 py-4">
                                    <span class="rounded-full bg-violet-500/10 px-2 py-1 text-xs text-violet-300">
                                        {{ $user->getRoleNames()->first() ?? 'User' }}
                                    </span>
                                </td>

                                <td class="px-5 py-4">
                                    <div class="flex flex-wrap gap-2">
                                        <button
                                            wire:click="view({{ $user->id }})"
                                            class="rounded-xl border border-sky-500/20 bg-sky-500/10 px-3 py-1.5 text-xs font-semibold text-sky-300 transition hover:bg-sky-500/20"
                                        >
                                            View
                                        </button>

                                        <button
                                            wire:click="edit({{ $user->id }})"
                                            class="rounded-xl border border-amber-500/20 bg-amber-500/10 px-3 py-1.5 text-xs font-semibold text-amber-300 transition hover:bg-amber-500/20"
                                        >
                                            Edit
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-10 text-center text-zinc-500">
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

        {{-- View Modal --}}
        @if ($showViewModal && $selectedUser)
            <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/70 p-4">
                <div class="max-h-[90vh] w-full max-w-4xl overflow-hidden rounded-3xl border border-white/10 bg-zinc-900 shadow-2xl">
                    <div class="flex items-center justify-between border-b border-white/10 px-6 py-4">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-[0.18em] text-amber-400">
                                Alumni Details
                            </p>
                            <h3 class="mt-1 text-xl font-semibold text-white">
                                {{ $selectedUser->alumni ? trim($selectedUser->alumni->fname . ' ' . $selectedUser->alumni->lname) : $selectedUser->username }}
                            </h3>
                        </div>

                        <button
                            wire:click="closeViewModal"
                            class="rounded-xl border border-white/10 bg-zinc-950 px-3 py-2 text-sm text-zinc-300 transition hover:bg-zinc-800"
                        >
                            Close
                        </button>
                    </div>

                    <div class="max-h-[calc(90vh-80px)] space-y-6 overflow-y-auto p-6">
                        <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
                            <div class="rounded-2xl border border-white/10 bg-zinc-950/70 p-4">
                                <p class="text-xs uppercase tracking-wide text-zinc-500">Username</p>
                                <p class="mt-2 text-sm font-medium text-white">{{ $selectedUser->username }}</p>
                            </div>

                            <div class="rounded-2xl border border-white/10 bg-zinc-950/70 p-4">
                                <p class="text-xs uppercase tracking-wide text-zinc-500">Email</p>
                                <p class="mt-2 text-sm font-medium text-white">{{ $selectedUser->email }}</p>
                            </div>

                            <div class="rounded-2xl border border-white/10 bg-zinc-950/70 p-4">
                                <p class="text-xs uppercase tracking-wide text-zinc-500">Role</p>
                                <p class="mt-2 text-sm font-medium text-white">{{ $selectedUser->getRoleNames()->first() ?? 'User' }}</p>
                            </div>

                            <div class="rounded-2xl border border-white/10 bg-zinc-950/70 p-4">
                                <p class="text-xs uppercase tracking-wide text-zinc-500">Has Alumni Profile</p>
                                <p class="mt-2 text-sm font-medium text-white">{{ $selectedUser->alumni ? 'Yes' : 'No' }}</p>
                            </div>
                        </div>

                        @if ($selectedUser->alumni)
                            <div class="grid gap-6 xl:grid-cols-2">
                                <div class="rounded-3xl border border-white/10 bg-zinc-950/70 p-5">
                                    <h4 class="text-lg font-semibold text-white">Personal Information</h4>

                                    <div class="mt-4 grid gap-4 sm:grid-cols-2">
                                        <div>
                                            <p class="text-xs uppercase tracking-wide text-zinc-500">Prefix</p>
                                            <p class="mt-1 text-sm text-zinc-200">{{ $selectedUser->alumni->prefix ?: 'N/A' }}</p>
                                        </div>
                                        <div>
                                            <p class="text-xs uppercase tracking-wide text-zinc-500">Suffix</p>
                                            <p class="mt-1 text-sm text-zinc-200">{{ $selectedUser->alumni->suffix ?: 'N/A' }}</p>
                                        </div>
                                        <div>
                                            <p class="text-xs uppercase tracking-wide text-zinc-500">First Name</p>
                                            <p class="mt-1 text-sm text-zinc-200">{{ $selectedUser->alumni->fname ?: 'N/A' }}</p>
                                        </div>
                                        <div>
                                            <p class="text-xs uppercase tracking-wide text-zinc-500">Middle Name</p>
                                            <p class="mt-1 text-sm text-zinc-200">{{ $selectedUser->alumni->mname ?: 'N/A' }}</p>
                                        </div>
                                        <div>
                                            <p class="text-xs uppercase tracking-wide text-zinc-500">Last Name</p>
                                            <p class="mt-1 text-sm text-zinc-200">{{ $selectedUser->alumni->lname ?: 'N/A' }}</p>
                                        </div>
                                        <div>
                                            <p class="text-xs uppercase tracking-wide text-zinc-500">Cellphone</p>
                                            <p class="mt-1 text-sm text-zinc-200">{{ $selectedUser->alumni->cellphone ?: 'N/A' }}</p>
                                        </div>
                                        <div class="sm:col-span-2">
                                            <p class="text-xs uppercase tracking-wide text-zinc-500">Occupation</p>
                                            <p class="mt-1 text-sm text-zinc-200">{{ $selectedUser->alumni->occupation ?: 'N/A' }}</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="rounded-3xl border border-white/10 bg-zinc-950/70 p-5">
                                    <h4 class="text-lg font-semibold text-white">Address</h4>

                                    <div class="mt-4 grid gap-4 sm:grid-cols-2">
                                        <div class="sm:col-span-2">
                                            <p class="text-xs uppercase tracking-wide text-zinc-500">Address Line 1</p>
                                            <p class="mt-1 text-sm text-zinc-200">{{ $selectedUser->alumni->address_line_1 ?: 'N/A' }}</p>
                                        </div>
                                        <div class="sm:col-span-2">
                                            <p class="text-xs uppercase tracking-wide text-zinc-500">Address Line 2</p>
                                            <p class="mt-1 text-sm text-zinc-200">{{ $selectedUser->alumni->address_line_2 ?: 'N/A' }}</p>
                                        </div>
                                        <div>
                                            <p class="text-xs uppercase tracking-wide text-zinc-500">City</p>
                                            <p class="mt-1 text-sm text-zinc-200">{{ $selectedUser->alumni->city ?: 'N/A' }}</p>
                                        </div>
                                        <div>
                                            <p class="text-xs uppercase tracking-wide text-zinc-500">Province / State</p>
                                            <p class="mt-1 text-sm text-zinc-200">{{ $selectedUser->alumni->state_province ?: 'N/A' }}</p>
                                        </div>
                                        <div>
                                            <p class="text-xs uppercase tracking-wide text-zinc-500">Postal Code</p>
                                            <p class="mt-1 text-sm text-zinc-200">{{ $selectedUser->alumni->postal_code ?: 'N/A' }}</p>
                                        </div>
                                        <div>
                                            <p class="text-xs uppercase tracking-wide text-zinc-500">Country</p>
                                            <p class="mt-1 text-sm text-zinc-200">{{ $selectedUser->alumni->country ?: 'N/A' }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="rounded-3xl border border-white/10 bg-zinc-950/70 p-5">
                                <h4 class="text-lg font-semibold text-white">Educational Background</h4>

                                <div class="mt-4 space-y-4">
                                    @forelse ($selectedUser->alumni->educations->sortBy(fn($edu) => match($edu->batch?->level) {
                                        'elementary' => 1,
                                        'highschool' => 2,
                                        'college' => 3,
                                        default => 99,
                                    }) as $education)
                                        <div class="rounded-2xl border border-white/10 bg-zinc-900 p-4">
                                            <div class="flex flex-wrap items-center gap-2">
                                                <span class="rounded-full bg-amber-500/15 px-3 py-1 text-xs font-semibold text-amber-300">
                                                    {{ str($education->batch?->level ?? 'n/a')->headline() }}
                                                </span>

                                                @if ($education->is_batch_rep)
                                                    <span class="rounded-full bg-sky-500/15 px-3 py-1 text-xs font-semibold text-sky-300">
                                                        Batch Representative
                                                    </span>
                                                @endif
                                            </div>

                                            <div class="mt-4 grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
                                                <div>
                                                    <p class="text-xs uppercase tracking-wide text-zinc-500">School Year</p>
                                                    <p class="mt-1 text-sm text-zinc-200">{{ $education->batch?->schoolyear ?? 'N/A' }}</p>
                                                </div>
                                                <div>
                                                    <p class="text-xs uppercase tracking-wide text-zinc-500">Year Graduated</p>
                                                    <p class="mt-1 text-sm text-zinc-200">{{ $education->batch?->yeargrad ?? 'N/A' }}</p>
                                                </div>
                                                <div>
                                                    <p class="text-xs uppercase tracking-wide text-zinc-500">Did Graduate</p>
                                                    <p class="mt-1 text-sm text-zinc-200">{{ $education->did_graduate ? 'Yes' : 'No' }}</p>
                                                </div>
                                                <div>
                                                    <p class="text-xs uppercase tracking-wide text-zinc-500">School Year Attended</p>
                                                    <p class="mt-1 text-sm text-zinc-200">{{ $education->school_year_attended ?: 'N/A' }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="rounded-2xl border border-dashed border-white/10 bg-zinc-900 p-5 text-sm text-zinc-500">
                                            No education records found.
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                        @else
                            <div class="rounded-2xl border border-dashed border-white/10 bg-zinc-950/70 p-5 text-sm text-zinc-500">
                                This user does not have an alumni profile yet.
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>