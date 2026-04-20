<div class="min-h-screen" style="background:#f0f4fb; font-family:'DM Sans',system-ui,sans-serif;"
     x-data="{
         modal: false,
         action: null,
         userId: null,
         name: '',
         open(action, userId, name) {
             this.action = action;
             this.userId = userId;
             this.name = name;
             this.modal = true;
         },
         confirm() {
             if (this.action === 'approve') $wire.approve(this.userId);
             else $wire.reject(this.userId);
             this.modal = false;
         }
     }">

<style>
    :root {
        --r9: #0a1f5c; --r8: #0f2a7a; --r7: #153591; --r6: #1a3fa8; --r5: #2150c8;
        --g5: #c4952a; --g4: #d4a843;
    }

    .ps-label {
        display: block; font-size: .65rem; font-weight: 700;
        letter-spacing: .1em; text-transform: uppercase; color: #64748b; margin-bottom: .35rem;
    }

    .btn-primary {
        display: inline-flex; align-items: center; gap: .4rem;
        height: 2.25rem; padding: 0 .9rem; border-radius: .7rem;
        background: linear-gradient(135deg,var(--r6) 0%,var(--r8) 100%);
        box-shadow: 0 3px 12px rgba(21,53,145,.28), inset 0 1px 0 rgba(255,255,255,.1);
        color: #fff; font-size: .75rem; font-weight: 700;
        transition: filter .15s, transform .1s; cursor: pointer; border: none; white-space: nowrap;
    }
    .btn-primary:hover  { filter: brightness(1.08); }
    .btn-primary:active { transform: translateY(1px); }
    .btn-primary:disabled { opacity: .6; cursor: not-allowed; filter: none; }

    .btn-danger {
        display: inline-flex; align-items: center; gap: .4rem;
        height: 2.25rem; padding: 0 .875rem; border-radius: .7rem;
        background: #fef2f2; border: 1px solid #fecaca; color: #991b1b;
        font-size: .75rem; font-weight: 600;
        transition: background .12s, border-color .12s; cursor: pointer; white-space: nowrap;
    }
    .btn-danger:hover { background: #fee2e2; border-color: #fca5a5; }
    .btn-danger:disabled { opacity: .6; cursor: not-allowed; }

    .status-chip {
        display: inline-flex; align-items: center; gap: .3rem;
        padding: .22rem .65rem; border-radius: 999px;
        font-size: .67rem; font-weight: 700; letter-spacing: .04em; white-space: nowrap;
    }
    .status-dot { width: .42rem; height: .42rem; border-radius: 50%; flex-shrink: 0; }
    .chip-blue { background:#eef2ff; color:#1a3fa8; border:1px solid #c7d2fe; }
    .chip-staff { background:#f0fdf4; color:#166534; border:1px solid #bbf7d0; }
    .chip-ssps  { background:#fdf4ff; color:#7e22ce; border:1px solid #e9d5ff; }

    .sum-chip {
        display: inline-flex; align-items: center; gap: .45rem;
        padding: .3rem .8rem; border-radius: 999px;
        font-size: .68rem; font-weight: 700; white-space: nowrap;
    }

    .ps-avatar {
        width: 2.1rem; height: 2.1rem; border-radius: .55rem;
        display: flex; align-items: center; justify-content: center;
        font-size: .7rem; font-weight: 800; color: #fff; flex-shrink: 0;
        letter-spacing: .04em;
        background: linear-gradient(135deg,var(--r6),var(--r8));
    }

    .ps-table thead th {
        font-size: .61rem; font-weight: 700; letter-spacing: .14em;
        text-transform: uppercase; color: #64748b;
        padding: .7rem 1rem; text-align: left; white-space: nowrap;
    }
    .ps-table thead th:last-child { text-align: right; }
    .ps-table tbody tr {
        transition: background .12s; border-bottom: 1px solid #f1f5f9;
    }
    .ps-table tbody tr:last-child { border-bottom: none; }
    .ps-table tbody tr:hover { background: #f8faff; }
    .ps-table td { padding: .9rem 1rem; vertical-align: middle; }
    .ps-table td:last-child { text-align: right; }

    .role-chip {
        display: inline-flex; align-items: center;
        padding: .2rem .6rem; border-radius: 999px;
        font-size: .66rem; font-weight: 700; letter-spacing: .04em; white-space: nowrap;
    }
    .role-staff    { background:#eef2ff; color:#1a3fa8; border:1px solid #c7d2fe; }
    .role-employee { background:#f0fdf4; color:#166534; border:1px solid #bbf7d0; }
    .role-ssps     { background:#fdf4ff; color:#7e22ce; border:1px solid #e9d5ff; }
    .role-default  { background:#f1f5f9; color:#475569; border:1px solid #e2e8f0; }
    [x-cloak] { display: none !important; }
</style>

<div class="space-y-5 px-4 py-6 sm:px-6 lg:px-8 mx-auto max-w-screen-xl">

    {{-- ════════════════════════════════════════════════════════
         HEADER
    ════════════════════════════════════════════════════════ --}}
    <section class="overflow-hidden rounded-2xl"
             style="background:linear-gradient(155deg,var(--r8) 0%,var(--r7) 45%,var(--r6) 100%);
                    box-shadow:0 8px 32px rgba(10,31,92,.28);">
        <div class="relative px-6 py-6 sm:px-8">
            <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
                <div>
                    <p class="text-[.65rem] font-bold uppercase tracking-[.22em]"
                       style="color:var(--g4);">
                        HSST Alumni Portal &middot; Admin Control
                    </p>
                    <h1 class="mt-2 text-2xl font-bold tracking-tight text-white sm:text-3xl"
                        style="font-family:Georgia,serif;letter-spacing:-.01em;">
                        Pending Non-Alumni Registrations
                    </h1>
                    <p class="mt-1.5 text-sm leading-6" style="color:rgba(255,255,255,.6);max-width:48ch;">
                        Review and approve or reject registration requests from staff,
                        employees, and SSPS members awaiting account activation.
                    </p>
                </div>

                <div class="flex flex-wrap items-center gap-2 lg:shrink-0 lg:mt-1">
                    <span class="sum-chip" style="background:rgba(255,255,255,.1);color:rgba(255,255,255,.75);border:1px solid rgba(255,255,255,.14);">
                        <span class="status-dot" style="background:rgba(255,255,255,.5);"></span>
                        {{ $pending->total() }} pending
                    </span>
                </div>
            </div>
        </div>
    </section>

    {{-- ════════════════════════════════════════════════════════
         FLASH MESSAGE
    ════════════════════════════════════════════════════════ --}}
    @if (session('success'))
        <div class="rounded-2xl px-5 py-4 flex items-start gap-3"
             style="background:#ecfdf5;border:1px solid #a7f3d0;">
            <svg class="w-4 h-4 mt-0.5 flex-shrink-0" style="color:#059669;"
                 fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
            </svg>
            <p class="text-sm font-semibold" style="color:#065f46;">{{ session('success') }}</p>
        </div>
    @endif

    {{-- ════════════════════════════════════════════════════════
         TABLE CARD
    ════════════════════════════════════════════════════════ --}}
    <section class="overflow-hidden rounded-2xl bg-white"
             style="border:1px solid #e2e8f0; box-shadow:0 1px 6px rgba(15,23,42,.05);">

        <div class="flex flex-col gap-2 px-5 py-4 sm:flex-row sm:items-center sm:justify-between"
             style="border-bottom:1px solid #f1f5f9;">
            <div>
                <h2 class="text-base font-bold text-slate-900">Registration Queue</h2>
                <p class="mt-0.5 text-xs text-slate-500">
                    {{ $pending->total() }} {{ $pending->total() === 1 ? 'registration' : 'registrations' }} awaiting review
                    &bull; {{ $pending->count() }} on this page
                </p>
            </div>
        </div>

        <div class="overflow-x-auto">
            @if ($pending->isEmpty())
                <div style="padding:4rem 2rem;">
                    <div style="max-width:22rem;margin:0 auto;text-align:center;">
                        <div style="width:3.5rem;height:3.5rem;border-radius:1rem;
                                    background:#f0f4fb;border:1px solid #e2e8f0;
                                    display:flex;align-items:center;justify-content:center;
                                    margin:0 auto 1rem;">
                            <svg style="width:1.5rem;height:1.5rem;color:#94a3b8;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z"/>
                            </svg>
                        </div>
                        <h3 style="font-size:1rem;font-weight:700;color:#1e293b;margin-bottom:.4rem;">
                            No pending registrations
                        </h3>
                        <p style="font-size:.8125rem;color:#64748b;line-height:1.6;">
                            All non-alumni registration requests have been reviewed.
                        </p>
                    </div>
                </div>
            @else
                <table class="ps-table min-w-full">
                    <thead style="background:#f8fafc;border-bottom:1px solid #e2e8f0;">
                        <tr>
                            <th>Name</th>
                            <th>Position</th>
                            <th>Role</th>
                            <th>Years at HSST</th>
                            <th>Contact</th>
                            <th>Registered</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pending as $user)
                            @php
                                $initials = strtoupper(
                                    substr($user->staff->fname ?? '?', 0, 1)
                                    . substr($user->staff->lname ?? '', 0, 1)
                                );
                                $role = $user->getRoleNames()->first() ?? 'unknown';
                                $roleClass = match($role) {
                                    'staff'       => 'role-staff',
                                    'employee'    => 'role-employee',
                                    'ssps-member' => 'role-ssps',
                                    default       => 'role-default',
                                };
                                $roleLabel = match($role) {
                                    'staff'       => 'Staff',
                                    'employee'    => 'Employee',
                                    'ssps-member' => 'SSPS Member',
                                    default       => ucfirst($role),
                                };
                            @endphp
                            <tr>
                                {{-- Name --}}
                                <td style="min-width:200px;">
                                    <div class="flex items-center gap-3">
                                        <div class="ps-avatar">{{ $initials }}</div>
                                        <div class="min-w-0">
                                            <p class="text-sm font-bold text-slate-900 leading-tight">
                                                {{ $user->staff->fname }} {{ $user->staff->lname }}
                                            </p>
                                            @if ($user->staff->mname)
                                                <p class="text-[.68rem] text-slate-400 mt-0.5">{{ $user->staff->mname }}</p>
                                            @endif
                                        </div>
                                    </div>
                                </td>

                                {{-- Position --}}
                                <td style="min-width:160px;">
                                    <span class="text-sm text-slate-700">{{ $user->staff->position }}</span>
                                </td>

                                {{-- Role --}}
                                <td style="min-width:120px;">
                                    <span class="role-chip {{ $roleClass }}">{{ $roleLabel }}</span>
                                </td>

                                {{-- Years --}}
                                <td style="min-width:120px;">
                                    <span class="text-sm text-slate-700">{{ $user->staff->years_working }} yr{{ $user->staff->years_working == 1 ? '' : 's' }}</span>
                                </td>

                                {{-- Contact --}}
                                <td style="min-width:200px;">
                                    <div class="flex items-center gap-1.5">
                                        <svg class="w-3 h-3 text-slate-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75"/>
                                        </svg>
                                        <span class="text-xs text-slate-600 truncate max-w-[180px]">{{ $user->email }}</span>
                                    </div>
                                </td>

                                {{-- Registered --}}
                                <td style="min-width:140px;">
                                    <p class="text-xs font-semibold text-slate-700 leading-tight">
                                        {{ $user->created_at->format('M d, Y') }}
                                    </p>
                                    <p class="text-[.65rem] text-slate-400 mt-0.5">
                                        {{ $user->created_at->diffForHumans() }}
                                    </p>
                                </td>

                                {{-- Actions --}}
                                <td style="min-width:180px;">
                                    <div class="flex flex-wrap items-center justify-end gap-1.5">
                                        <button
                                            @click="open('approve', {{ $user->id }}, '{{ addslashes($user->staff->fname . ' ' . $user->staff->lname) }}')"
                                            wire:loading.attr="disabled"
                                            wire:target="approve({{ $user->id }})"
                                            type="button"
                                            class="btn-primary"
                                        >
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                            </svg>
                                            Approve
                                        </button>
                                        <button
                                            @click="open('reject', {{ $user->id }}, '{{ addslashes($user->staff->fname . ' ' . $user->staff->lname) }}')"
                                            wire:loading.attr="disabled"
                                            wire:target="reject({{ $user->id }})"
                                            type="button"
                                            class="btn-danger"
                                        >
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/>
                                            </svg>
                                            Reject
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>

        @if (!$pending->isEmpty())
            <div class="px-5 py-4" style="border-top:1px solid #f1f5f9;background:#fafbff;">
                {{ $pending->links() }}
            </div>
        @endif
    </section>

</div>

    {{-- ════════════════════════════════════════════════════════
         CONFIRMATION MODAL
    ════════════════════════════════════════════════════════ --}}
    <div x-show="modal"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-50 flex items-center justify-center px-4"
         style="background:rgba(10,31,92,.45);backdrop-filter:blur(4px);"
         @keydown.escape.window="modal = false"
         x-cloak>

        <div x-show="modal"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-95"
             class="relative w-full max-w-sm rounded-2xl bg-white p-6"
             style="box-shadow:0 20px 60px rgba(10,31,92,.25);"
             @click.outside="modal = false">

            {{-- Icon --}}
            <div class="flex justify-center mb-4">
                <div class="flex h-12 w-12 items-center justify-center rounded-full"
                     :style="action === 'approve'
                         ? 'background:#eef2ff;border:1.5px solid #c7d2fe;'
                         : 'background:#fef2f2;border:1.5px solid #fecaca;'">
                    <template x-if="action === 'approve'">
                        <svg class="w-5 h-5" style="color:#1a3fa8;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                        </svg>
                    </template>
                    <template x-if="action === 'reject'">
                        <svg class="w-5 h-5" style="color:#991b1b;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/>
                        </svg>
                    </template>
                </div>
            </div>

            {{-- Title --}}
            <h3 class="text-center text-base font-bold text-slate-900 mb-1"
                x-text="action === 'approve' ? 'Approve Registration' : 'Reject Registration'"></h3>

            {{-- Body --}}
            <p class="text-center text-sm text-slate-500 leading-6 mb-6">
                <template x-if="action === 'approve'">
                    <span>Approve <strong x-text="name" class="text-slate-700"></strong>? They will be notified and can log in immediately.</span>
                </template>
                <template x-if="action === 'reject'">
                    <span>Reject <strong x-text="name" class="text-slate-700"></strong>? This will permanently delete their registration and cannot be undone.</span>
                </template>
            </p>

            {{-- Actions --}}
            <div class="flex gap-2">
                <button type="button"
                        @click="modal = false"
                        class="flex-1 h-10 rounded-xl border border-slate-200 text-sm font-semibold text-slate-600 hover:bg-slate-50 transition-colors">
                    Cancel
                </button>
                <button type="button"
                        @click="confirm()"
                        class="flex-1 h-10 rounded-xl text-sm font-bold text-white transition-all"
                        :style="action === 'approve'
                            ? 'background:linear-gradient(135deg,#1a3fa8,#0f2a7a);box-shadow:0 3px 12px rgba(21,53,145,.3);'
                            : 'background:linear-gradient(135deg,#dc2626,#991b1b);box-shadow:0 3px 12px rgba(220,38,38,.3);'"
                        x-text="action === 'approve' ? 'Yes, Approve' : 'Yes, Reject'">
                </button>
            </div>

        </div>
    </div>

</div>
</div>
