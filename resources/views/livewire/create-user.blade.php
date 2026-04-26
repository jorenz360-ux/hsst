<div class="min-h-screen" style="background:#f0f4fb; font-family:'DM Sans',system-ui,sans-serif;">

<style>
    :root {
        --r9: #0a1f5c;
        --r8: #0f2a7a;
        --r7: #153591;
        --r6: #1a3fa8;
        --r5: #2150c8;
        --g5: #c4952a;
        --g4: #d4a843;
    }

    .cu-label {
        display: block;
        font-size: .65rem;
        font-weight: 700;
        letter-spacing: .1em;
        text-transform: uppercase;
        color: #64748b;
        margin-bottom: .35rem;
    }

    .cu-field {
        height: 2.5rem;
        border-radius: .75rem;
        border: 1px solid #e2e8f0;
        background: #fff;
        padding: 0 .875rem;
        font-size: .8125rem;
        color: #0f172a;
        outline: none;
        transition: border-color .15s, box-shadow .15s;
        width: 100%;
    }
    .cu-field::placeholder { color: #94a3b8; }
    .cu-field:hover  { border-color: #94a3b8; }
    .cu-field:focus  { border-color: var(--r6); box-shadow: 0 0 0 3px rgba(26,63,168,.1); }

    .cu-select {
        height: 2.5rem;
        border-radius: .75rem;
        border: 1px solid #e2e8f0;
        background: #fff url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%2394a3b8' stroke-width='2'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' d='M19 9l-7 7-7-7'/%3E%3C/svg%3E") no-repeat right .75rem center / .9rem;
        padding: 0 2.2rem 0 .875rem;
        font-size: .8125rem;
        color: #0f172a;
        outline: none;
        appearance: none;
        transition: border-color .15s, box-shadow .15s;
        width: 100%;
        cursor: pointer;
    }
    .cu-select:hover { border-color: #94a3b8; }
    .cu-select:focus { border-color: var(--r6); box-shadow: 0 0 0 3px rgba(26,63,168,.1); }

    .btn-primary {
        display: inline-flex; align-items: center; gap: .4rem;
        height: 2.375rem; padding: 0 1.25rem;
        border-radius: .75rem;
        background: linear-gradient(135deg, var(--r6) 0%, var(--r8) 100%);
        box-shadow: 0 4px 14px rgba(21,53,145,.28), inset 0 1px 0 rgba(255,255,255,.1);
        color: #fff; font-size: .8rem; font-weight: 700;
        transition: filter .15s, box-shadow .15s, transform .1s;
        cursor: pointer; border: none; white-space: nowrap;
    }
    .btn-primary:hover  { filter: brightness(1.08); }
    .btn-primary:active { transform: translateY(1px); }

    .btn-gold {
        display: inline-flex; align-items: center; gap: .4rem;
        height: 2.375rem; padding: 0 1.25rem;
        border-radius: .75rem;
        background: linear-gradient(135deg, var(--g5) 0%, #a37522 100%);
        box-shadow: 0 4px 14px rgba(196,149,42,.3), inset 0 1px 0 rgba(255,255,255,.12);
        color: #fff; font-size: .8rem; font-weight: 700;
        transition: filter .15s, transform .1s;
        cursor: pointer; border: none; white-space: nowrap;
    }
    .btn-gold:hover  { filter: brightness(1.07); }
    .btn-gold:active { transform: translateY(1px); }

    .btn-ghost {
        display: inline-flex; align-items: center; gap: .4rem;
        height: 2.375rem; padding: 0 1rem;
        border-radius: .75rem;
        background: #fff; border: 1px solid #e2e8f0;
        color: #475569; font-size: .8rem; font-weight: 600;
        transition: background .12s, border-color .12s, color .12s;
        cursor: pointer; text-decoration: none; white-space: nowrap;
    }
    .btn-ghost:hover { background: #f8fafc; border-color: #cbd5e1; color: #1e293b; }

    .level-badge {
        display: inline-flex; align-items: center;
        padding: .15rem .6rem;
        border-radius: .4rem;
        font-size: .62rem; font-weight: 700; letter-spacing: .06em; text-transform: uppercase;
        white-space: nowrap;
    }
    .level-elem   { background:#f0fdf4; color:#065f46; border:1px solid #bbf7d0; }
    .level-hs     { background:#fef9ee; color:#92700a; border:1px solid #fde68a; }
    .level-col    { background:#f5f3ff; color:#5b21b6; border:1px solid #ddd6fe; }

    .cu-error { font-size: .7rem; color: #dc2626; margin-top: .3rem; }

    .section-card {
        background: #fff;
        border-radius: 1.25rem;
        border: 1px solid #e8edf5;
        box-shadow: 0 1px 6px rgba(15,23,42,.05);
        overflow: hidden;
    }
    .section-header {
        padding: 1.1rem 1.5rem;
        border-bottom: 1px solid #f1f5f9;
        display: flex; align-items: center; gap: .75rem;
    }
    .section-icon {
        width: 2.1rem; height: 2.1rem; border-radius: .6rem;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }
    .section-body { padding: 1.4rem 1.5rem; }
</style>

<div class="space-y-5 px-4 py-6 sm:px-6 lg:px-8 mx-auto max-w-screen-2xl">
 
    {{-- ── HEADER ──────────────────────────────────────────────── --}}
    <section class="overflow-hidden rounded-2xl"
             style="background:linear-gradient(155deg,var(--r8) 0%,var(--r7) 45%,var(--r6) 100%);
                    box-shadow:0 8px 32px rgba(10,31,92,.28); position:relative;">
        <span style="position:absolute;right:1.5rem;top:50%;transform:translateY(-50%);
                     font-family:Georgia,serif;font-size:5rem;font-weight:900;color:#fff;
                     opacity:.03;letter-spacing:.05em;user-select:none;white-space:nowrap;pointer-events:none;">
            CREATE USER
        </span>

        <div class="relative px-6 py-6 sm:px-8">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
                <div>
                    <p class="text-[.65rem] font-bold uppercase tracking-[.22em]" style="color:var(--g4);">
                        HSST Alumni Portal &middot; Admin Control
                    </p>
                    <h1 class="mt-2 text-2xl font-bold tracking-tight text-white sm:text-3xl"
                        style="font-family:Georgia,serif;letter-spacing:-.01em;">
                        Create User
                    </h1>
                    <p class="mt-1.5 text-sm leading-6" style="color:rgba(255,255,255,.6);max-width:44ch;">
                        Register an alumni or staff account. Credentials will be
                        emailed automatically on creation.
                    </p>
                </div>

                <div class="sm:mt-1 sm:shrink-0">
                    <a href="{{ route('manage-users') }}" wire:navigate class="btn-ghost">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18"/>
                        </svg>
                        Back to Users
                    </a>
                </div>
            </div>
        </div>
    </section>

    @include('partials.toast')

    <form wire:submit.prevent="save" class="space-y-4">

        {{-- ── USER TYPE ──────────────────────────────────────────────────── --}}
        <div class="section-card">
            <div class="section-header">
                <div class="section-icon" style="background:#f0fdf4;">
                    <svg class="w-4 h-4" style="color:#059669;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-700 text-slate-800" style="font-weight:700;">User Type</p>
                    <p class="text-xs" style="color:#64748b;">Select the account type to create</p>
                </div>
            </div>
            <div class="section-body">
                <div class="flex gap-4">
                    <label class="flex cursor-pointer items-center gap-2.5 rounded-xl px-4 py-3 flex-1"
                           style="border:1px solid {{ $userType === 'alumni' ? 'var(--r6)' : '#e2e8f0' }};
                                  background:{{ $userType === 'alumni' ? '#eef2ff' : '#fafafa' }};">
                        <input type="radio" wire:model.live="userType" value="alumni" class="sr-only">
                        <div class="w-4 h-4 rounded-full border-2 flex items-center justify-center flex-shrink-0"
                             style="border-color:{{ $userType === 'alumni' ? 'var(--r6)' : '#cbd5e1' }};">
                            @if($userType === 'alumni')
                                <div class="w-2 h-2 rounded-full" style="background:var(--r6);"></div>
                            @endif
                        </div>
                        <div>
                            <p class="text-sm font-semibold" style="color:#1e293b;">Alumni</p>
                            <p class="text-xs" style="color:#64748b;">Requires batch assignment</p>
                        </div>
                    </label>

                    <label class="flex cursor-pointer items-center gap-2.5 rounded-xl px-4 py-3 flex-1"
                           style="border:1px solid {{ $userType === 'staff' ? 'var(--r6)' : '#e2e8f0' }};
                                  background:{{ $userType === 'staff' ? '#eef2ff' : '#fafafa' }};">
                        <input type="radio" wire:model.live="userType" value="staff" class="sr-only">
                        <div class="w-4 h-4 rounded-full border-2 flex items-center justify-center flex-shrink-0"
                             style="border-color:{{ $userType === 'staff' ? 'var(--r6)' : '#cbd5e1' }};">
                            @if($userType === 'staff')
                                <div class="w-2 h-2 rounded-full" style="background:var(--r6);"></div>
                            @endif
                        </div>
                        <div>
                            <p class="text-sm font-semibold" style="color:#1e293b;">Staff</p>
                            <p class="text-xs" style="color:#64748b;">Non-alumni system account</p>
                        </div>
                    </label>
                </div>
            </div>
        </div>

        {{-- ── INFO BANNER ─────────────────────────────────────── --}}
        <div class="flex items-start gap-3 rounded-xl px-4 py-3.5"
             style="background:#eef2ff;border:1px solid #c7d2fe;">
            <svg class="mt-0.5 w-4 h-4 shrink-0" style="color:var(--r6);" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z"/>
            </svg>
            <p class="text-sm" style="color:var(--r6);">
                A <strong>username</strong> and <strong>temporary password</strong> will be
                auto-generated and emailed to the address provided below.
            </p>
        </div>

        {{-- ── ALUMNI PROFILE ──────────────────────────────────── --}}
        <div class="section-card">
            <div class="section-header">
                <div class="section-icon" style="background:#eef2ff;">
                    <svg class="w-4 h-4" style="color:var(--r6);" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-700 text-slate-800" style="font-weight:700;">Alumni Profile</p>
                    <p class="text-xs" style="color:#64748b;">Personal information</p>
                </div>
            </div>

            <div class="section-body space-y-4">
                {{-- Name row --}}
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                    @foreach (['lname' => 'Last Name', 'fname' => 'First Name', 'mname' => 'Middle Name'] as $field => $label)
                        <div>
                            <label class="cu-label">{{ $label }}</label>
                            <input type="text" wire:model.defer="{{ $field }}"
                                   class="cu-field"
                                   placeholder="{{ $label }}">
                            @error($field)
                                <p class="cu-error">{{ $message }}</p>
                            @enderror
                        </div>
                    @endforeach
                </div>

                {{-- Email --}}
                <div>
                    <label class="cu-label">Email Address</label>
                    <div class="relative">
                        <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3" style="color:#94a3b8;">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75"/>
                            </svg>
                        </span>
                        <input type="email" wire:model.defer="email"
                               placeholder="representative@email.com"
                               class="cu-field" style="padding-left:2.4rem;">
                    </div>
                    @error('email')
                        <p class="cu-error">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs" style="color:#94a3b8;">Login credentials will be sent to this address.</p>
                </div>
            </div>
        </div>

        @if ($userType === 'alumni')
        {{-- ── BATCH ASSIGNMENT ────────────────────────────────── --}}
        <div class="section-card">
            <div class="section-header">
                <div class="section-icon" style="background:#fef9ee;">
                    <svg class="w-4 h-4" style="color:#92700a;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.636 50.636 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.903 59.903 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489a50.702 50.702 0 0 1 3.741-1.342M6.75 15a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Zm0 0v-3.675A55.378 55.378 0 0 1 12 8.443m-7.007 11.55A5.981 5.981 0 0 0 6.75 15.75v-1.5"/>
                    </svg>
                </div>
                <div>
                    <p class="text-sm" style="font-weight:700;color:#1e293b;">Batch Assignment</p>
                    <p class="text-xs" style="color:#64748b;">Select the level and graduation batch</p>
                </div>
            </div>

            <div class="section-body space-y-4">
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    {{-- Batch select grouped by level --}}
                    <div>
                        <label class="cu-label">Batch</label>
                        <select wire:model.live="batch_id" class="cu-select">
                            <option value="">-- Choose batch --</option>
                            @foreach ($batches as $level => $levelBatches)
                                @php
                                    $levelLabel = match($level) {
                                        'elementary' => 'Elementary',
                                        'highschool' => 'High School',
                                        'college'    => 'College',
                                        default      => ucfirst($level),
                                    };
                                @endphp
                                <optgroup label="{{ $levelLabel }}">
                                    @foreach ($levelBatches as $batch)
                                        <option value="{{ $batch->id }}">
                                            {{ $batch->schoolyear }} &bull; Grad {{ $batch->yeargrad }}
                                        </option>
                                    @endforeach
                                </optgroup>
                            @endforeach
                        </select>
                        @error('batch_id')
                            <p class="cu-error">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Level indicator (read-only, derived from selected batch) --}}
                    <div>
                        <label class="cu-label">Education Level</label>
                        @php
                            $selectedLevel = null;
                            if ($batch_id) {
                                foreach ($batches as $lvl => $lvlBatches) {
                                    if ($lvlBatches->contains('id', $batch_id)) {
                                        $selectedLevel = $lvl;
                                        break;
                                    }
                                }
                            }
                            $levelMeta = match($selectedLevel) {
                                'elementary' => ['label' => 'Elementary',  'class' => 'level-elem'],
                                'highschool' => ['label' => 'High School', 'class' => 'level-hs'],
                                'college'    => ['label' => 'College',     'class' => 'level-col'],
                                default      => null,
                            };
                        @endphp
                        <div class="flex h-10 items-center">
                            @if ($levelMeta)
                                <span class="level-badge {{ $levelMeta['class'] }}">
                                    {{ $levelMeta['label'] }}
                                </span>
                            @else
                                <span class="text-xs" style="color:#94a3b8;">Select a batch above</span>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Batch rep toggle --}}
                <label class="flex cursor-pointer items-start gap-3 rounded-xl p-3.5"
                       style="border:1px solid #e2e8f0; background:#fafafa; transition:background .12s;"
                       onmouseover="this.style.background='#f0f4fb'" onmouseout="this.style.background='#fafafa'">
                    <div class="relative mt-0.5 flex-shrink-0">
                        <input type="checkbox" wire:model.live="is_batch_rep"
                               class="sr-only peer">
                        <div class="h-5 w-9 rounded-full transition-colors duration-200"
                             style="background: {{ $is_batch_rep ? 'var(--r6)' : '#cbd5e1' }};"></div>
                        <div class="absolute top-0.5 left-0.5 h-4 w-4 rounded-full bg-white shadow transition-transform duration-200"
                             style="transform: translateX({{ $is_batch_rep ? '1rem' : '0' }});"></div>
                    </div>
                    <div>
                        <p class="text-sm font-semibold" style="color:#1e293b;">Batch Representative</p>
                        <p class="text-xs mt-0.5" style="color:#64748b;">
                            Grants elevated access to manage batch-level content and communications.
                        </p>
                    </div>
                </label>

                @if ($this->batchHasRep)
                    <div class="flex items-start gap-3 rounded-xl px-4 py-3"
                         style="background:#fffbeb;border:1px solid #fde68a;">
                        <svg class="mt-0.5 w-4 h-4 shrink-0" style="color:#92700a;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z"/>
                        </svg>
                        <p class="text-sm" style="color:#92700a;">
                            This batch already has a representative. Saving will transfer the role to this new account.
                        </p>
                    </div>
                @endif
            </div>
        </div>
        @endif

        @if ($userType === 'staff')
        {{-- ── STAFF ROLE ──────────────────────────────────────── --}}
        <div class="section-card">
            <div class="section-header">
                <div class="section-icon" style="background:#f5f3ff;">
                    <svg class="w-4 h-4" style="color:#7c3aed;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285Z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-700 text-slate-800" style="font-weight:700;">Staff Role</p>
                    <p class="text-xs" style="color:#64748b;">Select the system role to assign</p>
                </div>
            </div>
            <div class="section-body">
                <div>
                    <label class="cu-label">Role</label>
                    <select wire:model.defer="staffRole" class="cu-select">
                        <option value="">-- Select role --</option>
                        @foreach ($staffRoles as $role)
                            <option value="{{ $role }}">{{ ucfirst($role) }}</option>
                        @endforeach
                    </select>
                    @error('staffRole')
                        <p class="cu-error">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>
        @endif

        {{-- ── ACTIONS ─────────────────────────────────────────── --}}
        <div class="flex items-center justify-end gap-3 pb-2">
            <button type="button" wire:click="resetForm" class="btn-ghost">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99"/>
                </svg>
                Clear Form
            </button>

            <button type="submit" class="btn-gold">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75"/>
                </svg>
                Create &amp; Send Credentials
            </button>
        </div>

    </form>
</div>
</div>
