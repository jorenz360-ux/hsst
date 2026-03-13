<div>
    <div class="space-y-4">
    {{-- Add User --}}
    <div class="flex items-center justify-between">
        <flux:button href="{{ route('users.create') }}" variant="primary" wire:navigate>
            <flux:icon name="plus" class="mr-2" />
            Add User
        </flux:button>
    </div>

    <div class="space-y-4">
<div class="grid grid-cols-1 gap-4 lg:grid-cols-10">

    <!-- Search (50%) -->
    <div class="lg:col-span-5">
        <label class="ui-label mb-1 block">Search</label>
        <input
            type="text"
            wire:model.live.debounce.300ms="search"
            placeholder="Search username, email, full name, or batch..."
            class="ui-control"
        />
    </div>

    <!-- Role (30%) -->
    <div class="lg:col-span-3">
        <label class="ui-label mb-1 block">Role</label>
        <select wire:model.live="role" class="ui-control">
            @foreach ($roles as $r)
                <option value="{{ $r }}">
                    {{ $r === 'all' ? 'All roles' : $r }}
                </option>
            @endforeach
        </select>
    </div>

    <!-- Per Page (20%) -->
    <div class="lg:col-span-2">
        <label class="ui-label mb-1 block">Per page</label>
        <select wire:model.live="perPage" class="ui-control">
            <option value="5">5</option>
            <option value="10">10</option>
            <option value="25">25</option>
            <option value="50">50</option>
        </select>
    </div>

</div>

    {{-- Table wrapper --}}
    <div class="ui-surface">
        <div class="overflow-x-auto">
            <table class="min-w-full text-left text-sm">
                <thead class="ui-thead">
                    <tr>
                        <th class="px-4 py-3 text-sm font-semibold">Username</th>
                        <th class="px-4 py-3 text-sm font-semibold">Full Name</th>
                        <th class="px-4 py-3 text-sm font-semibold">Email</th>
                        <th class="px-4 py-3 text-sm font-semibold">Batch</th>
                        <th class="px-4 py-3 text-sm font-semibold">Role</th>
                        <th class="px-4 py-3 text-right text-sm font-semibold">Actions</th>
                    </tr>
                </thead>

                <tbody class="ui-tbody">
                    @forelse ($users as $user)
                        <tr wire:key="user-{{ $user->id }}" class="ui-trow">
                            <td class="px-4 py-3 font-medium text-zinc-900 dark:text-zinc-100">
                                {{ $user->username }}
                            </td>

                            <td class="px-4 py-3 text-zinc-700 dark:text-zinc-300">
                                @if ($user->alumni)
                                    {{ trim($user->alumni->fname . ' ' . $user->alumni->lname) }}
                                @else
                                    <span class="text-zinc-400 italic">No alumni record</span>
                                @endif
                            </td>

                            <td class="px-4 py-3 text-zinc-600 dark:text-zinc-400">
                                {{ $user->email }}
                            </td>

                            <td class="px-4 py-3 text-zinc-600 dark:text-zinc-400">
                                @if ($user->alumni?->batch)
                                    {{ $user->alumni->batch->schoolyear ?? $user->alumni->batch->yeargrad }}
                                @else
                                    <span class="text-zinc-400 italic">N/A</span>
                                @endif
                            </td>

                            <td class="px-4 py-3">
                                <span class="inline-flex items-center rounded-full border px-2 py-1 text-xs font-medium
                                    border-zinc-200 bg-zinc-50 text-zinc-700
                                    dark:border-zinc-700 dark:bg-zinc-900 dark:text-zinc-200">
                                    {{ $user->getRoleNames()->first() ?? 'user' }}
                                </span>
                            </td>

                            <td class="px-4 py-3 text-right">
                                <flux:button size="sm" variant="ghost" wire:click="edit({{ $user->id }})">
                                    Edit
                                </flux:button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-10 text-center text-sm text-zinc-600 dark:text-zinc-400">
                                No users found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="border-t border-zinc-200 px-4 py-3 dark:border-zinc-700">
            {{ $users->links() }}
        </div>
    </div>
</div>
</div>
</div>