<div>
    <div class="mb-6 flex items-center justify-between">
        <h1 class="text-2xl font-bold text-gray-900">Pending Non-Alumni Registrations</h1>
    </div>

    @if (session('success'))
        <div class="mb-4 rounded-lg bg-green-50 p-4 text-sm text-green-800">{{ session('success') }}</div>
    @endif

    @if ($pending->isEmpty())
        <div class="rounded-lg border border-dashed border-gray-300 p-10 text-center text-gray-500">
            No pending registrations.
        </div>
    @else
        <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead class="bg-gray-50 text-xs font-semibold uppercase tracking-wider text-gray-500">
                    <tr>
                        <th class="px-4 py-3 text-left">Name</th>
                        <th class="px-4 py-3 text-left">Position</th>
                        <th class="px-4 py-3 text-left">Type</th>
                        <th class="px-4 py-3 text-left">Years at HSST</th>
                        <th class="px-4 py-3 text-left">Email</th>
                        <th class="px-4 py-3 text-left">Registered</th>
                        <th class="px-4 py-3 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach ($pending as $user)
                        <tr>
                            <td class="px-4 py-3 font-medium text-gray-900">
                                {{ $user->staff->fname }} {{ $user->staff->lname }}
                            </td>
                            <td class="px-4 py-3 text-gray-600">{{ $user->staff->position }}</td>
                            <td class="px-4 py-3">
                                <span class="rounded-full bg-blue-100 px-2 py-0.5 text-xs font-medium text-blue-700">
                                    {{ $user->getRoleNames()->first() }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-gray-600">{{ $user->staff->years_working }}</td>
                            <td class="px-4 py-3 text-gray-600">{{ $user->email }}</td>
                            <td class="px-4 py-3 text-gray-500">{{ $user->created_at->format('M d, Y') }}</td>
                            <td class="px-4 py-3">
                                <div class="flex gap-2">
                                    <flux:button
                                        size="sm"
                                        variant="primary"
                                        wire:click="approve({{ $user->id }})"
                                        wire:confirm="Approve this registration?"
                                    >Approve</flux:button>
                                    <flux:button
                                        size="sm"
                                        variant="danger"
                                        wire:click="reject({{ $user->id }})"
                                        wire:confirm="Reject and delete this registration?"
                                    >Reject</flux:button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4">{{ $pending->links() }}</div>
    @endif
</div>
