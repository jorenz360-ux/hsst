<div class="min-h-screen bg-[linear-gradient(180deg,#f8fafc_0%,#f1f5f9_100%)] text-slate-800">
    <div class="mx-auto max-w-7xl space-y-6 px-4 py-6 sm:px-6 lg:px-8">

        {{-- Page Header --}}
        <section class="overflow-hidden rounded-[2rem] border border-slate-200 bg-white shadow-sm">
            <div class="relative">
                <div class="absolute inset-x-0 top-0 h-1.5 bg-gradient-to-r from-blue-900 via-blue-700 to-amber-500"></div>

                <div class="flex flex-col gap-5 px-6 py-6 lg:flex-row lg:items-end lg:justify-between">
                    <div class="max-w-3xl">
                        <p class="text-[0.7rem] font-semibold uppercase tracking-[0.26em] text-blue-800">
                            Institutional User Management
                        </p>

                        <h1 class="mt-2 text-3xl font-bold tracking-tight text-slate-900 sm:text-4xl">
                            Manage Users
                        </h1>

                        <p class="mt-3 text-sm leading-6 text-slate-600 sm:text-[0.95rem]">
                            Monitor user accounts, alumni-linked records, education history, and role assignments
                            across the reunion platform with clarity and control.
                        </p>
                    </div>

                    <div class="flex flex-wrap gap-3">
                        <button
                            wire:click="resetFilters"
                            class="inline-flex items-center justify-center rounded-2xl border border-slate-300 bg-white px-4 py-2.5 text-sm font-medium text-slate-700 transition hover:border-slate-400 hover:bg-slate-50"
                        >
                            Reset Filters
                        </button>

                        <a
                            href="{{ route('users.create') }}"
                            wire:navigate
                            class="inline-flex items-center justify-center rounded-2xl bg-blue-900 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-800"
                        >
                            Add User
                        </a>
                    </div>
                </div>

                {{-- Summary Strip --}}
                <div class="border-t border-slate-200 bg-slate-50/80 px-6 py-4">
                    <div class="flex flex-wrap gap-2.5">
                        <span class="inline-flex items-center rounded-full border border-blue-200 bg-blue-50 px-3 py-1.5 text-xs font-semibold text-blue-800">
                            Total Users: {{ $users->total() }}
                        </span>

                        <span class="inline-flex items-center rounded-full border border-slate-200 bg-white px-3 py-1.5 text-xs font-semibold text-slate-700">
                            With Alumni: {{ $users->getCollection()->whereNotNull('alumni_id')->count() }}
                        </span>

                        <span class="inline-flex items-center rounded-full border border-amber-200 bg-amber-50 px-3 py-1.5 text-xs font-semibold text-amber-700">
                            Batch Representatives:
                            {{ $users->getCollection()->filter(fn($u) => $u->alumni?->educations?->contains(fn($edu) => $edu->is_batch_rep))->count() }}
                        </span>

                        <span class="inline-flex items-center rounded-full border border-slate-200 bg-white px-3 py-1.5 text-xs font-semibold text-slate-700">
                            Active Role:
                            {{ $role === 'all' ? 'All Roles' : str($role)->headline() }}
                        </span>

                        <span class="inline-flex items-center rounded-full border border-slate-200 bg-white px-3 py-1.5 text-xs font-semibold text-slate-700">
                            Per Page: {{ $perPage }}
                        </span>
                    </div>
                </div>
            </div>
        </section>

        {{-- Filter Panel --}}
        <section class="rounded-[2rem] border border-slate-200 bg-white shadow-sm">
            <div class="border-b border-slate-200 px-6 py-4">
                <h2 class="text-lg font-semibold text-slate-900">Smart Filter Bar</h2>
                <p class="mt-1 text-sm text-slate-500">
                    Refine the user directory by identity, role, education level, representative status, and alumni linkage.
                </p>
            </div>

            <div class="px-6 py-5">
                <div class="grid grid-cols-1 gap-4 xl:grid-cols-12">
                    <div class="xl:col-span-3">
                        <label class="mb-1.5 block text-xs font-semibold uppercase tracking-wide text-slate-500">
                            Search
                        </label>
                        <input
                            type="text"
                            wire:model.live.debounce.300ms="search"
                            placeholder="Search username, email, alumni, batch..."
                            class="w-full rounded-2xl border border-slate-300 bg-white px-4 py-2.5 text-sm text-slate-900 outline-none placeholder:text-slate-400 focus:border-blue-700 focus:ring-2 focus:ring-blue-700/10"
                        />
                    </div>

                    <div class="xl:col-span-2">
                        <label class="mb-1.5 block text-xs font-semibold uppercase tracking-wide text-slate-500">
                            Role
                        </label>
                        <select
                            wire:model.live="role"
                            class="w-full rounded-2xl border border-slate-300 bg-white px-4 py-2.5 text-sm text-slate-900 focus:border-blue-700 focus:ring-2 focus:ring-blue-700/10"
                        >
                            @foreach ($roles as $r)
                                <option value="{{ $r }}">
                                    {{ $r === 'all' ? 'All roles' : str($r)->headline() }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="xl:col-span-2">
                        <label class="mb-1.5 block text-xs font-semibold uppercase tracking-wide text-slate-500">
                            Education Level
                        </label>
                        <select
                            wire:model.live="level"
                            class="w-full rounded-2xl border border-slate-300 bg-white px-4 py-2.5 text-sm text-slate-900 focus:border-blue-700 focus:ring-2 focus:ring-blue-700/10"
                        >
                            @foreach ($levels as $value => $label)
                                <option value="{{ $value }}">{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="xl:col-span-2">
                        <label class="mb-1.5 block text-xs font-semibold uppercase tracking-wide text-slate-500">
                            Batch Representative
                        </label>
                        <select
                            wire:model.live="isBatchRep"
                            class="w-full rounded-2xl border border-slate-300 bg-white px-4 py-2.5 text-sm text-slate-900 focus:border-blue-700 focus:ring-2 focus:ring-blue-700/10"
                        >
                            <option value="all">All Rep Status</option>
                            <option value="yes">Batch Rep Only</option>
                            <option value="no">Non-Rep Only</option>
                        </select>
                    </div>

                    <div class="xl:col-span-1">
                        <label class="mb-1.5 block text-xs font-semibold uppercase tracking-wide text-slate-500">
                            Alumni Link
                        </label>
                        <select
                            wire:model.live="hasAlumni"
                            class="w-full rounded-2xl border border-slate-300 bg-white px-4 py-2.5 text-sm text-slate-900 focus:border-blue-700 focus:ring-2 focus:ring-blue-700/10"
                        >
                            <option value="all">All</option>
                            <option value="yes">With Alumni</option>
                            <option value="no">No Alumni</option>
                        </select>
                    </div>

                    <div class="xl:col-span-2">
                        <label class="mb-1.5 block text-xs font-semibold uppercase tracking-wide text-slate-500">
                            Display
                        </label>
                        <select
                            wire:model.live="perPage"
                            class="w-full rounded-2xl border border-slate-300 bg-white px-4 py-2.5 text-sm text-slate-900 focus:border-blue-700 focus:ring-2 focus:ring-blue-700/10"
                        >
                            <option value="10">10 / page</option>
                            <option value="25">25 / page</option>
                            <option value="50">50 / page</option>
                            <option value="100">100 / page</option>
                        </select>
                    </div>
                </div>
            </div>
        </section>

        {{-- Directory Table --}}
        <section class="overflow-hidden rounded-[2rem] border border-slate-200 bg-white shadow-sm">
            <div class="flex flex-col gap-3 border-b border-slate-200 px-6 py-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h2 class="text-lg font-semibold text-slate-900">User Directory</h2>
                    <p class="mt-1 text-sm text-slate-500">
                        A structured overview of platform users, linked alumni records, and role assignments.
                    </p>
                </div>

                <div class="inline-flex items-center rounded-full border border-slate-200 bg-slate-50 px-3 py-1.5 text-xs font-semibold text-slate-600">
                    Filtered Result Set: {{ $users->count() }}
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="bg-slate-50 text-[0.72rem] font-semibold uppercase tracking-[0.14em] text-slate-500">
                        <tr class="border-b border-slate-200">
                            <th class="px-5 py-3 text-left">User Identity</th>
                            <th class="px-5 py-3 text-left">Profile</th>
                            <th class="px-5 py-3 text-left">Education / Batch</th>
                            <th class="px-5 py-3 text-left">Role</th>
                            <th class="px-5 py-3 text-left">Status</th>
                            <th class="px-5 py-3 text-right">Actions</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-200">
                        @forelse ($users as $user)
                            @php
                                $fullName = $user->alumni
                                    ? trim($user->alumni->fname . ' ' . $user->alumni->lname)
                                    : 'No alumni profile';

                                $hasProfile = filled($user->alumni);
                                $educationCount = $user->alumni?->educations?->count() ?? 0;
                                $isRep = $user->alumni?->educations?->contains(fn($edu) => $edu->is_batch_rep) ?? false;
                                $primaryRole = $user->getRoleNames()->first() ?? 'User';
                            @endphp

                            <tr class="align-top transition hover:bg-blue-50/30">
                                <td class="px-5 py-4">
                                    <div class="flex items-start gap-3">
                                        <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl bg-blue-900 text-sm font-bold text-white shadow-sm">
                                            {{ strtoupper(substr($user->username ?? 'U', 0, 1)) }}
                                        </div>

                                        <div class="min-w-0">
                                            <p class="truncate font-semibold text-slate-900">
                                                {{ $user->username }}
                                            </p>

                                            <p class="mt-1 truncate text-xs text-slate-500">
                                                {{ $user->email ?: 'No email provided' }}
                                            </p>

                                            <p class="mt-2 text-xs text-slate-400">
                                                User ID #{{ $user->id }}
                                            </p>
                                        </div>
                                    </div>
                                </td>

                                <td class="px-5 py-4">
                                    <div class="space-y-2">
                                        <p class="font-medium text-slate-800">
                                            {{ $fullName }}
                                        </p>

                                        <div class="flex flex-wrap gap-2">
                                            @if ($hasProfile)
                                                <span class="inline-flex items-center rounded-full border border-emerald-200 bg-emerald-50 px-2.5 py-1 text-[11px] font-semibold text-emerald-700">
                                                    Alumni Linked
                                                </span>
                                            @else
                                                <span class="inline-flex items-center rounded-full border border-rose-200 bg-rose-50 px-2.5 py-1 text-[11px] font-semibold text-rose-700">
                                                    No Alumni Profile
                                                </span>
                                            @endif

                                            @if ($isRep)
                                                <span class="inline-flex items-center rounded-full border border-amber-200 bg-amber-50 px-2.5 py-1 text-[11px] font-semibold text-amber-700">
                                                    Batch Representative
                                                </span>
                                            @endif
                                        </div>
                                    </div>
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
                                                <div class="rounded-2xl border border-slate-200 bg-slate-50 px-3 py-2">
                                                    <div class="flex flex-wrap items-center gap-1.5 text-[11px]">
                                                        <span class="font-semibold text-blue-800">
                                                            {{ str($education->batch?->level ?? 'n/a')->headline() }}
                                                        </span>
                                                        <span class="text-slate-300">•</span>
                                                        <span class="text-slate-600">
                                                            {{ $education->batch?->schoolyear ?? 'N/A' }}
                                                        </span>
                                                    </div>

                                                    <div class="mt-1 text-[11px] text-slate-500">
                                                        Year Grad: {{ $education->batch?->yeargrad ?? 'N/A' }}
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <span class="text-sm text-slate-400">No education records</span>
                                    @endif
                                </td>

                                <td class="px-5 py-4">
                                    <span class="inline-flex items-center rounded-full border border-blue-200 bg-blue-50 px-2.5 py-1 text-xs font-semibold text-blue-800">
                                        {{ str($primaryRole)->headline() }}
                                    </span>
                                </td>

                                <td class="px-5 py-4">
                                    <div class="space-y-2">
                                        <div class="flex flex-wrap gap-2">
                                            <span class="inline-flex items-center rounded-full border {{ $hasProfile ? 'border-emerald-200 bg-emerald-50 text-emerald-700' : 'border-rose-200 bg-rose-50 text-rose-700' }} px-2.5 py-1 text-[11px] font-semibold">
                                                {{ $hasProfile ? 'Profile Available' : 'Profile Incomplete' }}
                                            </span>

                                            <span class="inline-flex items-center rounded-full border {{ $educationCount > 0 ? 'border-slate-200 bg-white text-slate-700' : 'border-amber-200 bg-amber-50 text-amber-700' }} px-2.5 py-1 text-[11px] font-semibold">
                                                {{ $educationCount > 0 ? $educationCount . ' Education Record(s)' : 'No Education Data' }}
                                            </span>
                                        </div>

                                        <p class="text-xs text-slate-400">
                                            Review linked alumni data and role alignment before making account changes.
                                        </p>
                                    </div>
                                </td>

                                <td class="px-5 py-4">
                                    <div class="flex flex-wrap items-center justify-end gap-2">
                                        <button
                                            wire:click="view({{ $user->id }})"
                                            class="inline-flex items-center rounded-xl border border-slate-300 bg-white px-3 py-2 text-xs font-semibold text-slate-700 transition hover:border-blue-300 hover:bg-blue-50 hover:text-blue-800"
                                        >
                                            View Details
                                        </button>

                                        <button
                                            wire:click="edit({{ $user->id }})"
                                            class="inline-flex items-center rounded-xl bg-blue-900 px-3 py-2 text-xs font-semibold text-white transition hover:bg-blue-800"
                                        >
                                            Edit Account
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-16 text-center">
                                    <div class="mx-auto max-w-md">
                                        <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl border border-slate-200 bg-slate-50">
                                            <flux:icon name="users" class="h-7 w-7 text-slate-400" />
                                        </div>

                                        <h3 class="mt-4 text-lg font-semibold text-slate-900">
                                            No users found
                                        </h3>

                                        <p class="mt-2 text-sm leading-6 text-slate-500">
                                            No records matched the current filters. Try adjusting your search criteria or
                                            create a new user account to get started.
                                        </p>

                                        <div class="mt-5 flex flex-wrap items-center justify-center gap-3">
                                            <button
                                                wire:click="resetFilters"
                                                class="inline-flex items-center rounded-xl border border-slate-300 bg-white px-4 py-2 text-sm font-medium text-slate-700 transition hover:bg-slate-50"
                                            >
                                                Reset Filters
                                            </button>

                                            <a
                                                href="{{ route('users.create') }}"
                                                wire:navigate
                                                class="inline-flex items-center rounded-xl bg-blue-900 px-4 py-2 text-sm font-semibold text-white transition hover:bg-blue-800"
                                            >
                                                Add User
                                            </a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="border-t border-slate-200 bg-slate-50 px-5 py-4">
                {{ $users->links() }}
            </div>
        </section>

        {{-- View Modal --}}
        @if ($showViewModal && $selectedUser)
            <div class="fixed inset-0 z-50 flex items-center justify-center bg-slate-950/50 p-4 backdrop-blur-sm">
                <div class="max-h-[90vh] w-full max-w-5xl overflow-hidden rounded-[2rem] border border-slate-200 bg-white shadow-2xl">
                    <div class="border-b border-slate-200 bg-slate-50 px-6 py-5">
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <p class="text-[0.7rem] font-semibold uppercase tracking-[0.22em] text-blue-800">
                                    User Profile Overview
                                </p>

                                <h3 class="mt-2 text-2xl font-bold tracking-tight text-slate-900">
                                    {{ $selectedUser->alumni ? trim($selectedUser->alumni->fname . ' ' . $selectedUser->alumni->lname) : $selectedUser->username }}
                                </h3>

                                <p class="mt-1 text-sm text-slate-500">
                                    Linked account details, alumni identity, address, and education records.
                                </p>
                            </div>

                            <button
                                wire:click="closeViewModal"
                                class="inline-flex items-center rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm font-medium text-slate-700 transition hover:bg-slate-50"
                            >
                                Close
                            </button>
                        </div>
                    </div>

                    <div class="max-h-[calc(90vh-96px)] space-y-6 overflow-y-auto p-6">
                        <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
                            <div class="rounded-3xl border border-slate-200 bg-slate-50 p-4">
                                <p class="text-xs uppercase tracking-wide text-slate-400">Username</p>
                                <p class="mt-2 text-sm font-semibold text-slate-900">{{ $selectedUser->username }}</p>
                            </div>

                            <div class="rounded-3xl border border-slate-200 bg-slate-50 p-4">
                                <p class="text-xs uppercase tracking-wide text-slate-400">Email</p>
                                <p class="mt-2 text-sm font-semibold text-slate-900">{{ $selectedUser->email ?: 'N/A' }}</p>
                            </div>

                            <div class="rounded-3xl border border-slate-200 bg-slate-50 p-4">
                                <p class="text-xs uppercase tracking-wide text-slate-400">Role</p>
                                <p class="mt-2 text-sm font-semibold text-slate-900">{{ $selectedUser->getRoleNames()->first() ?? 'User' }}</p>
                            </div>

                            <div class="rounded-3xl border border-slate-200 bg-slate-50 p-4">
                                <p class="text-xs uppercase tracking-wide text-slate-400">Alumni Profile</p>
                                <p class="mt-2 text-sm font-semibold text-slate-900">{{ $selectedUser->alumni ? 'Linked' : 'Not Linked' }}</p>
                            </div>
                        </div>

                        @if ($selectedUser->alumni)
                            <div class="grid gap-6 xl:grid-cols-2">
                                <div class="rounded-[2rem] border border-slate-200 bg-white p-5">
                                    <h4 class="text-lg font-semibold text-slate-900">Personal Information</h4>

                                    <div class="mt-4 grid gap-4 sm:grid-cols-2">
                                        <div>
                                            <p class="text-xs uppercase tracking-wide text-slate-400">Prefix</p>
                                            <p class="mt-1 text-sm text-slate-700">{{ $selectedUser->alumni->prefix ?: 'N/A' }}</p>
                                        </div>
                                        <div>
                                            <p class="text-xs uppercase tracking-wide text-slate-400">Suffix</p>
                                            <p class="mt-1 text-sm text-slate-700">{{ $selectedUser->alumni->suffix ?: 'N/A' }}</p>
                                        </div>
                                        <div>
                                            <p class="text-xs uppercase tracking-wide text-slate-400">First Name</p>
                                            <p class="mt-1 text-sm text-slate-700">{{ $selectedUser->alumni->fname ?: 'N/A' }}</p>
                                        </div>
                                        <div>
                                            <p class="text-xs uppercase tracking-wide text-slate-400">Middle Name</p>
                                            <p class="mt-1 text-sm text-slate-700">{{ $selectedUser->alumni->mname ?: 'N/A' }}</p>
                                        </div>
                                        <div>
                                            <p class="text-xs uppercase tracking-wide text-slate-400">Last Name</p>
                                            <p class="mt-1 text-sm text-slate-700">{{ $selectedUser->alumni->lname ?: 'N/A' }}</p>
                                        </div>
                                        <div>
                                            <p class="text-xs uppercase tracking-wide text-slate-400">Cellphone</p>
                                            <p class="mt-1 text-sm text-slate-700">{{ $selectedUser->alumni->cellphone ?: 'N/A' }}</p>
                                        </div>
                                        <div class="sm:col-span-2">
                                            <p class="text-xs uppercase tracking-wide text-slate-400">Occupation</p>
                                            <p class="mt-1 text-sm text-slate-700">{{ $selectedUser->alumni->occupation ?: 'N/A' }}</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="rounded-[2rem] border border-slate-200 bg-white p-5">
                                    <h4 class="text-lg font-semibold text-slate-900">Address Information</h4>

                                    <div class="mt-4 grid gap-4 sm:grid-cols-2">
                                        <div class="sm:col-span-2">
                                            <p class="text-xs uppercase tracking-wide text-slate-400">Address Line 1</p>
                                            <p class="mt-1 text-sm text-slate-700">{{ $selectedUser->alumni->address_line_1 ?: 'N/A' }}</p>
                                        </div>
                                        <div class="sm:col-span-2">
                                            <p class="text-xs uppercase tracking-wide text-slate-400">Address Line 2</p>
                                            <p class="mt-1 text-sm text-slate-700">{{ $selectedUser->alumni->address_line_2 ?: 'N/A' }}</p>
                                        </div>
                                        <div>
                                            <p class="text-xs uppercase tracking-wide text-slate-400">City</p>
                                            <p class="mt-1 text-sm text-slate-700">{{ $selectedUser->alumni->city ?: 'N/A' }}</p>
                                        </div>
                                        <div>
                                            <p class="text-xs uppercase tracking-wide text-slate-400">Province / State</p>
                                            <p class="mt-1 text-sm text-slate-700">{{ $selectedUser->alumni->state_province ?: 'N/A' }}</p>
                                        </div>
                                        <div>
                                            <p class="text-xs uppercase tracking-wide text-slate-400">Postal Code</p>
                                            <p class="mt-1 text-sm text-slate-700">{{ $selectedUser->alumni->postal_code ?: 'N/A' }}</p>
                                        </div>
                                        <div>
                                            <p class="text-xs uppercase tracking-wide text-slate-400">Country</p>
                                            <p class="mt-1 text-sm text-slate-700">{{ $selectedUser->alumni->country ?: 'N/A' }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="rounded-[2rem] border border-slate-200 bg-white p-5">
                                <h4 class="text-lg font-semibold text-slate-900">Educational Background</h4>

                                <div class="mt-4 space-y-4">
                                    @forelse ($selectedUser->alumni->educations->sortBy(fn($edu) => match($edu->batch?->level) {
                                        'elementary' => 1,
                                        'highschool' => 2,
                                        'college' => 3,
                                        default => 99,
                                    }) as $education)
                                        <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
                                            <div class="flex flex-wrap items-center gap-2">
                                                <span class="rounded-full border border-blue-200 bg-blue-50 px-3 py-1 text-xs font-semibold text-blue-800">
                                                    {{ str($education->batch?->level ?? 'n/a')->headline() }}
                                                </span>

                                                @if ($education->is_batch_rep)
                                                    <span class="rounded-full border border-amber-200 bg-amber-50 px-3 py-1 text-xs font-semibold text-amber-700">
                                                        Batch Representative
                                                    </span>
                                                @endif
                                            </div>

                                            <div class="mt-4 grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
                                                <div>
                                                    <p class="text-xs uppercase tracking-wide text-slate-400">School Year</p>
                                                    <p class="mt-1 text-sm text-slate-700">{{ $education->batch?->schoolyear ?? 'N/A' }}</p>
                                                </div>
                                                <div>
                                                    <p class="text-xs uppercase tracking-wide text-slate-400">Year Graduated</p>
                                                    <p class="mt-1 text-sm text-slate-700">{{ $education->batch?->yeargrad ?? 'N/A' }}</p>
                                                </div>
                                                <div>
                                                    <p class="text-xs uppercase tracking-wide text-slate-400">Did Graduate</p>
                                                    <p class="mt-1 text-sm text-slate-700">{{ $education->did_graduate ? 'Yes' : 'No' }}</p>
                                                </div>
                                                <div>
                                                    <p class="text-xs uppercase tracking-wide text-slate-400">School Year Attended</p>
                                                    <p class="mt-1 text-sm text-slate-700">{{ $education->school_year_attended ?: 'N/A' }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="rounded-2xl border border-dashed border-slate-300 bg-slate-50 p-5 text-sm text-slate-400">
                                            No education records found.
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                        @else
                            <div class="rounded-2xl border border-dashed border-slate-300 bg-slate-50 p-5 text-sm text-slate-500">
                                This user does not have an alumni profile yet.
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>