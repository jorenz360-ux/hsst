<div class="min-h-screen  bg-gray-50 text-gray-800">
    <div class="mx-auto max-w-7xl space-y-6 p-6">

        {{-- Header --}}
        <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.22em] text-amber-600">
                    User Management
                </p>
                <h1 class="mt-1 text-3xl font-semibold tracking-tight text-gray-900">
                    Manage Users
                </h1>
                <p class="mt-2 max-w-2xl text-sm text-gray-500">
                    View, filter, and manage user accounts linked to alumni records, multiple education levels, and assigned roles.
                </p>
            </div>

            <div class="flex flex-wrap gap-3">
                <button
                    wire:click="resetFilters"
                    class="inline-flex items-center justify-center rounded-2xl border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 transition hover:bg-gray-50"
                >
                    Reset Filters
                </button>

                <a
                    href="{{ route('users.create') }}"
                    wire:navigate
                    class="inline-flex items-center justify-center rounded-2xl bg-amber-500 px-4 py-2.5 text-sm font-semibold text-white shadow transition hover:bg-amber-600"
                >
                    Add User
                </a>
            </div>
        </div>

        {{-- Stat Cards --}}
        <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
            <div class="rounded-3xl border border-amber-200 bg-amber-50 p-5">
                <p class="text-sm text-amber-600">Total Users</p>
                <div class="mt-2 text-3xl font-semibold text-amber-700">
                    {{ $users->total() }}
                </div>
                <p class="mt-2 text-xs text-amber-500">Current filtered result set</p>
            </div>

            <div class="rounded-3xl border border-violet-200 bg-violet-50 p-5">
                <p class="text-sm text-violet-600">With Alumni Profile</p>
                <div class="mt-2 text-3xl font-semibold text-violet-700">
                    {{ $users->getCollection()->whereNotNull('alumni_id')->count() }}
                </div>
            </div>

            <div class="rounded-3xl border border-sky-200 bg-sky-50 p-5">
                <p class="text-sm text-sky-600">Batch Representatives</p>
                <div class="mt-2 text-3xl font-semibold text-sky-700">
                    {{ $users->getCollection()->filter(fn($u) => $u->alumni?->educations?->contains(fn($edu) => $edu->is_batch_rep))->count() }}
                </div>
            </div>

            <div class="rounded-3xl border border-gray-200 bg-white p-5">
                <p class="text-sm text-gray-500">Active Role Filter</p>
                <div class="mt-2 text-xl font-semibold text-gray-900">
                    {{ $role === 'all' ? 'All Roles' : str($role)->headline() }}
                </div>
            </div>
        </div>

        {{-- Filters --}}
        <div class="rounded-3xl border border-gray-200 bg-white p-5">
            <h2 class="mb-4 text-lg font-semibold text-gray-900">Advanced Filters</h2>

            <div class="grid grid-cols-1 gap-4 xl:grid-cols-12">
                <div class="xl:col-span-3">
                    <input
                        type="text"
                        wire:model.live.debounce.300ms="search"
                        placeholder="Search username, email, alumni, batch..."
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
                        wire:model.live="isBatchRep"
                        class="w-full rounded-2xl border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20"
                    >
                        <option value="all">All Rep Status</option>
                        <option value="yes">Batch Rep Only</option>
                        <option value="no">Non-Rep Only</option>
                    </select>
                </div>

                <div class="xl:col-span-1">
                    <select
                        wire:model.live="hasAlumni"
                        class="w-full rounded-2xl border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20"
                    >
                        <option value="all">All</option>
                        <option value="yes">With Alumni</option>
                        <option value="no">No Alumni</option>
                    </select>
                </div>

                <div class="xl:col-span-2">
                    <select
                        wire:model.live="perPage"
                        class="w-full rounded-2xl border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20"
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
        <div class="overflow-hidden rounded-3xl border border-gray-200 bg-white">
            <div class="border-b border-gray-100 px-6 py-4">
                <h2 class="text-lg font-semibold text-gray-900">User Directory</h2>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="border-b border-gray-100 bg-gray-50 text-xs font-semibold uppercase tracking-wide text-gray-400">
                        <tr>
                            <th class="px-5 py-3 text-left font-medium">ID</th>
                            <th class="px-5 py-3 text-left font-medium">User</th>
                            <th class="px-5 py-3 text-left font-medium">Full Name</th>
                            <th class="px-5 py-3 text-left font-medium">Education Levels</th>
                            <th class="px-5 py-3 text-left font-medium">Role</th>
                            <th class="px-5 py-3 text-left font-medium">Actions</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100">
                        @forelse ($users as $user)
                            <tr class="transition hover:bg-amber-50/50">
                                <td class="px-5 py-4 text-gray-500">{{ $user->id }}</td>

                                <td class="px-5 py-4">
                                    <div class="space-y-0.5">
                                        <p class="font-medium text-gray-900">{{ $user->username }}</p>
                                        <p class="text-xs text-gray-400">{{ $user->email }}</p>
                                    </div>
                                </td>

                                <td class="px-5 py-4 text-gray-700">
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
                                                <span class="inline-flex items-center gap-1 rounded-full border border-gray-200 bg-gray-50 px-2.5 py-1 text-xs text-gray-600">
                                                    <span class="font-semibold text-amber-600">
                                                        {{ str($education->batch?->level ?? 'n/a')->headline() }}
                                                    </span>
                                                    <span class="text-gray-300">•</span>
                                                    <span>{{ $education->batch?->schoolyear ?? 'N/A' }}</span>
                                                    @if ($education->is_batch_rep)
                                                        <span class="rounded-full border border-amber-200 bg-amber-50 px-2 py-0.5 text-[10px] font-semibold text-amber-600">
                                                            Rep
                                                        </span>
                                                    @endif
                                                </span>
                                            @endforeach
                                        </div>
                                    @else
                                        <span class="text-gray-400">N/A</span>
                                    @endif
                                </td>

                                <td class="px-5 py-4">
                                    <span class="rounded-full border border-violet-200 bg-violet-50 px-2.5 py-1 text-xs font-medium text-violet-700">
                                        {{ $user->getRoleNames()->first() ?? 'User' }}
                                    </span>
                                </td>

                                <td class="px-5 py-4">
                                    <div class="flex flex-wrap gap-2">
                                        <button
                                            wire:click="view({{ $user->id }})"
                                            class="rounded-xl border border-sky-200 bg-sky-50 px-3 py-1.5 text-xs font-semibold text-sky-700 transition hover:bg-sky-100"
                                        >
                                            View
                                        </button>

                                        <button
                                            wire:click="edit({{ $user->id }})"
                                            class="rounded-xl border border-amber-200 bg-amber-50 px-3 py-1.5 text-xs font-semibold text-amber-700 transition hover:bg-amber-100"
                                        >
                                            Edit
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-12 text-center">
                                    <flux:icon name="users" class="mx-auto h-7 w-7 text-gray-300" />
                                    <p class="mt-2 text-sm text-gray-400">No users found</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="border-t border-gray-100 px-5 py-4">
                {{ $users->links() }}
            </div>
        </div>

        {{-- View Modal --}}
        @if ($showViewModal && $selectedUser)
            <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4">
                <div class="max-h-[90vh] w-full max-w-4xl overflow-hidden rounded-3xl border border-gray-200 bg-white shadow-2xl">
                    <div class="flex items-center justify-between border-b border-gray-200 px-6 py-4">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-[0.18em] text-amber-600">
                                Alumni Details
                            </p>
                            <h3 class="mt-1 text-xl font-semibold text-gray-900">
                                {{ $selectedUser->alumni ? trim($selectedUser->alumni->fname . ' ' . $selectedUser->alumni->lname) : $selectedUser->username }}
                            </h3>
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
                                <p class="mt-2 text-sm font-medium text-gray-900">{{ $selectedUser->username }}</p>
                            </div>

                            <div class="rounded-2xl border border-gray-200 bg-gray-50 p-4">
                                <p class="text-xs uppercase tracking-wide text-gray-400">Email</p>
                                <p class="mt-2 text-sm font-medium text-gray-900">{{ $selectedUser->email }}</p>
                            </div>

                            <div class="rounded-2xl border border-gray-200 bg-gray-50 p-4">
                                <p class="text-xs uppercase tracking-wide text-gray-400">Role</p>
                                <p class="mt-2 text-sm font-medium text-gray-900">{{ $selectedUser->getRoleNames()->first() ?? 'User' }}</p>
                            </div>

                            <div class="rounded-2xl border border-gray-200 bg-gray-50 p-4">
                                <p class="text-xs uppercase tracking-wide text-gray-400">Has Alumni Profile</p>
                                <p class="mt-2 text-sm font-medium text-gray-900">{{ $selectedUser->alumni ? 'Yes' : 'No' }}</p>
                            </div>
                        </div>

                        @if ($selectedUser->alumni)
                            <div class="grid gap-6 xl:grid-cols-2">
                                <div class="rounded-3xl border border-gray-200 bg-gray-50 p-5">
                                    <h4 class="text-lg font-semibold text-gray-900">Personal Information</h4>

                                    <div class="mt-4 grid gap-4 sm:grid-cols-2">
                                        <div>
                                            <p class="text-xs uppercase tracking-wide text-gray-400">Prefix</p>
                                            <p class="mt-1 text-sm text-gray-700">{{ $selectedUser->alumni->prefix ?: 'N/A' }}</p>
                                        </div>
                                        <div>
                                            <p class="text-xs uppercase tracking-wide text-gray-400">Suffix</p>
                                            <p class="mt-1 text-sm text-gray-700">{{ $selectedUser->alumni->suffix ?: 'N/A' }}</p>
                                        </div>
                                        <div>
                                            <p class="text-xs uppercase tracking-wide text-gray-400">First Name</p>
                                            <p class="mt-1 text-sm text-gray-700">{{ $selectedUser->alumni->fname ?: 'N/A' }}</p>
                                        </div>
                                        <div>
                                            <p class="text-xs uppercase tracking-wide text-gray-400">Middle Name</p>
                                            <p class="mt-1 text-sm text-gray-700">{{ $selectedUser->alumni->mname ?: 'N/A' }}</p>
                                        </div>
                                        <div>
                                            <p class="text-xs uppercase tracking-wide text-gray-400">Last Name</p>
                                            <p class="mt-1 text-sm text-gray-700">{{ $selectedUser->alumni->lname ?: 'N/A' }}</p>
                                        </div>
                                        <div>
                                            <p class="text-xs uppercase tracking-wide text-gray-400">Cellphone</p>
                                            <p class="mt-1 text-sm text-gray-700">{{ $selectedUser->alumni->cellphone ?: 'N/A' }}</p>
                                        </div>
                                        <div class="sm:col-span-2">
                                            <p class="text-xs uppercase tracking-wide text-gray-400">Occupation</p>
                                            <p class="mt-1 text-sm text-gray-700">{{ $selectedUser->alumni->occupation ?: 'N/A' }}</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="rounded-3xl border border-gray-200 bg-gray-50 p-5">
                                    <h4 class="text-lg font-semibold text-gray-900">Address</h4>

                                    <div class="mt-4 grid gap-4 sm:grid-cols-2">
                                        <div class="sm:col-span-2">
                                            <p class="text-xs uppercase tracking-wide text-gray-400">Address Line 1</p>
                                            <p class="mt-1 text-sm text-gray-700">{{ $selectedUser->alumni->address_line_1 ?: 'N/A' }}</p>
                                        </div>
                                        <div class="sm:col-span-2">
                                            <p class="text-xs uppercase tracking-wide text-gray-400">Address Line 2</p>
                                            <p class="mt-1 text-sm text-gray-700">{{ $selectedUser->alumni->address_line_2 ?: 'N/A' }}</p>
                                        </div>
                                        <div>
                                            <p class="text-xs uppercase tracking-wide text-gray-400">City</p>
                                            <p class="mt-1 text-sm text-gray-700">{{ $selectedUser->alumni->city ?: 'N/A' }}</p>
                                        </div>
                                        <div>
                                            <p class="text-xs uppercase tracking-wide text-gray-400">Province / State</p>
                                            <p class="mt-1 text-sm text-gray-700">{{ $selectedUser->alumni->state_province ?: 'N/A' }}</p>
                                        </div>
                                        <div>
                                            <p class="text-xs uppercase tracking-wide text-gray-400">Postal Code</p>
                                            <p class="mt-1 text-sm text-gray-700">{{ $selectedUser->alumni->postal_code ?: 'N/A' }}</p>
                                        </div>
                                        <div>
                                            <p class="text-xs uppercase tracking-wide text-gray-400">Country</p>
                                            <p class="mt-1 text-sm text-gray-700">{{ $selectedUser->alumni->country ?: 'N/A' }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="rounded-3xl border border-gray-200 bg-gray-50 p-5">
                                <h4 class="text-lg font-semibold text-gray-900">Educational Background</h4>

                                <div class="mt-4 space-y-4">
                                    @forelse ($selectedUser->alumni->educations->sortBy(fn($edu) => match($edu->batch?->level) {
                                        'elementary' => 1,
                                        'highschool' => 2,
                                        'college' => 3,
                                        default => 99,
                                    }) as $education)
                                        <div class="rounded-2xl border border-gray-200 bg-white p-4">
                                            <div class="flex flex-wrap items-center gap-2">
                                                <span class="rounded-full border border-amber-200 bg-amber-50 px-3 py-1 text-xs font-semibold text-amber-700">
                                                    {{ str($education->batch?->level ?? 'n/a')->headline() }}
                                                </span>

                                                @if ($education->is_batch_rep)
                                                    <span class="rounded-full border border-sky-200 bg-sky-50 px-3 py-1 text-xs font-semibold text-sky-700">
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
                        @else
                            <div class="rounded-2xl border border-dashed border-gray-300 bg-gray-50 p-5 text-sm text-gray-400">
                                This user does not have an alumni profile yet.
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
