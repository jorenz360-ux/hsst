
<div class="min-h-screen text-gray-800">
        <div class="space-y-6 p-6">
          <div>
            <div class="space-y-6">
                <div class="flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.2em] text-blue-600">Admin Panel</p>
                        <h1 class="text-2xl font-bold text-slate-900">Password Reset Requests</h1>
                        <p class="mt-1 text-sm text-slate-500">
                            Review and process password reset requests submitted by users.
                        </p>
                    </div>

                    <div class="grid gap-3 sm:grid-cols-2">
                        <div>
                            <label class="mb-1 block text-xs font-medium uppercase tracking-wide text-slate-500">Filter Status</label>
                            <select wire:model.live="status" class="w-full rounded-xl border border-slate-300 px-3 py-2 text-sm">
                                <option value="all">All</option>
                                <option value="pending">Pending</option>
                                <option value="processing">Processing</option>
                                <option value="resolved">Resolved</option>
                                <option value="rejected">Rejected</option>
                            </select>
                        </div>

                        <div>
                            <label class="mb-1 block text-xs font-medium uppercase tracking-wide text-slate-500">Search</label>
                            <input
                                type="text"
                                wire:model.live.debounce.400ms="search"
                                placeholder="Search username, name, email..."
                                class="w-full rounded-xl border border-slate-300 px-3 py-2 text-sm"
                            >
                        </div>
                    </div>
                </div>

                @if (session('status'))
                    <div class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
                        {{ session('status') }}
                    </div>
                @endif

                <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-slate-200">
                            <thead class="bg-slate-50">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">User</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Username</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Email</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Requested</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Status</th>
                                    <th class="px-4 py-3 text-right text-xs font-semibold uppercase tracking-wide text-slate-500">Actions</th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-slate-100 bg-white">
                                @forelse ($requests as $request)
                                    <tr class="align-top">
                                        <td class="px-4 py-4 text-sm text-slate-800">
                                            {{ $request->full_name ?: 'N/A' }}
                                        </td>

                                        <td class="px-4 py-4 text-sm text-slate-700">
                                            {{ $request->username ?: 'N/A' }}
                                        </td>

                                        <td class="px-4 py-4 text-sm text-slate-700">
                                            {{ $request->email ?: 'N/A' }}
                                        </td>

                                        <td class="px-4 py-4 text-sm text-slate-700">
                                            {{ optional($request->requested_at)->format('M d, Y h:i A') ?: 'N/A' }}
                                        </td>

                                        <td class="px-4 py-4 text-sm">
                                            @php
                                                $statusClasses = match ($request->status) {
                                                    'pending' => 'bg-amber-100 text-amber-700',
                                                    'processing' => 'bg-blue-100 text-blue-700',
                                                    'resolved' => 'bg-emerald-100 text-emerald-700',
                                                    'rejected' => 'bg-rose-100 text-rose-700',
                                                    default => 'bg-slate-100 text-slate-700',
                                                };
                                            @endphp

                                            <span class="inline-flex rounded-full px-2.5 py-1 text-xs font-semibold {{ $statusClasses }}">
                                                {{ ucfirst($request->status) }}
                                            </span>
                                        </td>

                                        <td class="px-4 py-4">
                                            <div class="flex flex-wrap justify-end gap-2">
                                                @if ($request->status === 'pending')
                                                    <button
                                                        wire:click="markProcessing({{ $request->id }})"
                                                        type="button"
                                                        class="rounded-lg border border-blue-200 bg-blue-50 px-3 py-2 text-xs font-medium text-blue-700 hover:bg-blue-100"
                                                    >
                                                        Mark Processing
                                                    </button>
                                                @endif

                                                @if (in_array($request->status, ['pending', 'processing']))
                                                    <button
                                                        wire:click="resetPassword({{ $request->id }})"
                                                        type="button"
                                                        class="rounded-lg bg-slate-900 px-3 py-2 text-xs font-medium text-white hover:bg-slate-800"
                                                    >
                                                        Reset Password
                                                    </button>

                                                    <button
                                                        wire:click="markRejected({{ $request->id }})"
                                                        type="button"
                                                        class="rounded-lg border border-rose-200 bg-rose-50 px-3 py-2 text-xs font-medium text-rose-700 hover:bg-rose-100"
                                                    >
                                                        Reject
                                                    </button>
                                                @endif
                                            </div>

                                            @if ($request->notes)
                                                <div class="mt-3 rounded-lg bg-slate-50 p-3 text-xs text-slate-600">
                                                    <span class="font-semibold text-slate-700">Notes:</span><br>
                                                    {!! nl2br(e($request->notes)) !!}
                                                </div>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-4 py-8 text-center text-sm text-slate-500">
                                            No password reset requests found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="border-t border-slate-200 px-4 py-4">
                        {{ $requests->links() }}
                    </div>
                </div>
            </div>
            </div>
        </div>
</div>
