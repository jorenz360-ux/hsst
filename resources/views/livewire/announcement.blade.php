<div
    x-data="{
        removingId: null,
        recentlyUpdated: null,
        recentlyCreated: false,

        markDeleted(id) {
            this.removingId = id;
            setTimeout(() => { this.removingId = null; }, 700);
        },

        markUpdated(id) {
            this.recentlyUpdated = id;
            setTimeout(() => { this.recentlyUpdated = null; }, 1500);
        },

        markCreated() {
            this.recentlyCreated = true;
            setTimeout(() => { this.recentlyCreated = false; }, 1500);
        }
    }"
    x-on:announcement-deleted.window="markDeleted($event.detail.id)"
    x-on:announcement-updated.window="markUpdated($event.detail.id)"
    x-on:announcement-saved.window="markCreated()"
    x-on:open-modal.window="$flux.modal($event.detail.name).show()"
    x-on:close-modal.window="$flux.modal($event.detail.name).close()"
    class="min-h-screen"
    style="background:#f0f4fb; font-family:'DM Sans',system-ui,sans-serif;"
>

{{-- ── STYLES ──────────────────────────────────────────────────── --}}
<style>
    :root {
        --r9:#0a1f5c; --r8:#0f2a7a; --r7:#153591; --r6:#1a3fa8; --r5:#2150c8;
        --g5:#c4952a; --g4:#d4a843;
    }

    .an-field {
        width:100%; border-radius:.875rem; border:1px solid #e2e8f0;
        background:#f8fafc; padding:.7rem 1rem; font-size:.8125rem;
        color:#0f172a; outline:none; transition:border-color .15s,box-shadow .15s;
        font-family:inherit;
    }
    .an-field::placeholder { color:#94a3b8; }
    .an-field:hover  { border-color:#94a3b8; background:#fff; }
    .an-field:focus  { border-color:var(--r6); background:#fff; box-shadow:0 0 0 3px rgba(26,63,168,.1); }
    .an-field.is-error { border-color:#ef4444; box-shadow:0 0 0 3px rgba(239,68,68,.1); }

    .an-field-search {
        height:2.5rem; border-radius:.75rem; border:1px solid rgba(255,255,255,.2);
        background:rgba(255,255,255,.12); padding:0 .875rem 0 2.4rem;
        font-size:.8125rem; color:#fff; outline:none; width:100%;
        transition:border-color .15s,box-shadow .15s,background .15s;
    }
    .an-field-search::placeholder { color:rgba(255,255,255,.45); }
    .an-field-search:focus {
        border-color:rgba(255,255,255,.45); background:rgba(255,255,255,.18);
        box-shadow:0 0 0 3px rgba(255,255,255,.08);
    }

    .an-label {
        display:block; font-size:.68rem; font-weight:700;
        letter-spacing:.1em; text-transform:uppercase; color:#475569; margin-bottom:.45rem;
    }

    /* Buttons */
    .btn-primary {
        display:inline-flex; align-items:center; gap:.4rem;
        height:2.375rem; padding:0 1rem; border-radius:.75rem;
        background:linear-gradient(135deg,var(--r6) 0%,var(--r8) 100%);
        box-shadow:0 4px 14px rgba(21,53,145,.28),inset 0 1px 0 rgba(255,255,255,.1);
        color:#fff; font-size:.8rem; font-weight:700;
        transition:filter .15s,transform .1s; cursor:pointer; border:none; white-space:nowrap;
    }
    .btn-primary:hover  { filter:brightness(1.08); }
    .btn-primary:active { transform:translateY(1px); }
    .btn-primary:disabled { opacity:.6; cursor:not-allowed; filter:none; }

    .btn-gold {
        display:inline-flex; align-items:center; gap:.4rem;
        height:2.375rem; padding:0 1.1rem; border-radius:.75rem;
        background:linear-gradient(135deg,var(--g5) 0%,#a37522 100%);
        box-shadow:0 4px 14px rgba(196,149,42,.3),inset 0 1px 0 rgba(255,255,255,.12);
        color:#fff; font-size:.8rem; font-weight:700;
        transition:filter .15s,transform .1s; cursor:pointer; border:none; white-space:nowrap;
    }
    .btn-gold:hover  { filter:brightness(1.07); }
    .btn-gold:active { transform:translateY(1px); }
    .btn-gold:disabled { opacity:.6; cursor:not-allowed; filter:none; }

    .btn-ghost {
        display:inline-flex; align-items:center; gap:.4rem;
        height:2.25rem; padding:0 .875rem; border-radius:.7rem;
        background:#fff; border:1px solid #e2e8f0; color:#475569;
        font-size:.75rem; font-weight:600;
        transition:background .12s,border-color .12s,color .12s;
        cursor:pointer; white-space:nowrap;
    }
    .btn-ghost:hover { background:#f8fafc; border-color:#cbd5e1; }
    .btn-ghost:disabled { opacity:.5; cursor:not-allowed; }

    .btn-edit {
        display:inline-flex; align-items:center; gap:.35rem;
        height:2rem; padding:0 .75rem; border-radius:.6rem;
        background:#eef2ff; border:1px solid #c7d2fe; color:#1a3fa8;
        font-size:.72rem; font-weight:700;
        transition:background .12s; cursor:pointer; white-space:nowrap;
    }
    .btn-edit:hover { background:#dbeafe; border-color:#93c5fd; }
    .btn-edit:disabled { opacity:.5; cursor:not-allowed; }

    .btn-delete {
        display:inline-flex; align-items:center; gap:.35rem;
        height:2rem; padding:0 .75rem; border-radius:.6rem;
        background:#fef2f2; border:1px solid #fecaca; color:#991b1b;
        font-size:.72rem; font-weight:700;
        transition:background .12s; cursor:pointer; white-space:nowrap;
    }
    .btn-delete:hover { background:#fee2e2; border-color:#fca5a5; }
    .btn-delete:disabled { opacity:.5; cursor:not-allowed; }

    .btn-danger {
        display:inline-flex; align-items:center; gap:.4rem;
        height:2.375rem; padding:0 1.1rem; border-radius:.75rem;
        background:linear-gradient(135deg,#dc2626,#991b1b);
        box-shadow:0 4px 14px rgba(220,38,38,.25);
        color:#fff; font-size:.8rem; font-weight:700;
        transition:filter .15s; cursor:pointer; border:none; white-space:nowrap;
    }
    .btn-danger:hover  { filter:brightness(1.07); }
    .btn-danger:disabled { opacity:.6; cursor:not-allowed; filter:none; }

    /* Status chips */
    .chip {
        display:inline-flex; align-items:center; gap:.3rem;
        padding:.22rem .65rem; border-radius:999px;
        font-size:.67rem; font-weight:700; letter-spacing:.04em; white-space:nowrap;
    }
    .chip-dot { width:.42rem; height:.42rem; border-radius:50%; flex-shrink:0; }
    .chip-published { background:#ecfdf5; color:#065f46; border:1px solid #a7f3d0; }
    .chip-draft     { background:#f1f5f9; color:#475569; border:1px solid #e2e8f0; }
    .chip-pinned    { background:#fef9ee; color:#92700a; border:1px solid #fde68a; }
    .chip-blue      { background:#eef2ff; color:#1a3fa8; border:1px solid #c7d2fe; }

    /* Table */
    .an-table thead th {
        font-size:.61rem; font-weight:700; letter-spacing:.14em;
        text-transform:uppercase; color:#64748b;
        padding:.65rem 1rem; text-align:left; white-space:nowrap;
    }
    .an-table thead th:last-child { text-align:right; }
    .an-table tbody tr { border-bottom:1px solid #f1f5f9; transition:background .12s; }
    .an-table tbody tr:last-child { border-bottom:none; }
    .an-table tbody tr:hover { background:#f8faff; }
    .an-table td { padding:.85rem 1rem; vertical-align:top; }
    .an-table td:last-child { text-align:right; vertical-align:middle; }

    /* Modal form fields */
    .modal-field {
        width:100%; border-radius:.875rem; border:1px solid #e2e8f0;
        background:#f8fafc; padding:.75rem 1rem; font-size:.875rem;
        color:#0f172a; outline:none; transition:border-color .15s,box-shadow .15s;
        font-family:inherit;
    }
    .modal-field::placeholder { color:#94a3b8; }
    .modal-field:hover  { border-color:#94a3b8; background:#fff; }
    .modal-field:focus  { border-color:var(--r6); background:#fff; box-shadow:0 0 0 3px rgba(26,63,168,.1); }

    .modal-label {
        display:block; font-size:.7rem; font-weight:700;
        letter-spacing:.1em; text-transform:uppercase; color:#475569; margin-bottom:.5rem;
    }
</style>

<div class="space-y-5 px-4 py-6 sm:px-6 lg:px-8 mx-auto max-w-screen-xl">

    {{-- ════════════════════════════════════════════════════════
         CONTROL HEADER
    ════════════════════════════════════════════════════════ --}}
    <section class="overflow-hidden rounded-2xl"
             style="background:linear-gradient(155deg,var(--r8) 0%,var(--r7) 45%,var(--r6) 100%);
                    box-shadow:0 8px 32px rgba(10,31,92,.28);">
        <div class="relative px-6 py-6 sm:px-8">
            <div class="flex flex-col gap-5 lg:flex-row lg:items-start lg:justify-between">

                {{-- Title --}}
                <div>
                    <p class="text-[.65rem] font-bold uppercase tracking-[.22em]" style="color:var(--g4);">
                        HSST Alumni Portal &middot; Admin Control
                    </p>
                    <h1 class="mt-2 text-2xl font-bold tracking-tight text-white sm:text-3xl"
                        style="font-family:Georgia,serif;letter-spacing:-.01em;">
                        Announcements
                    </h1>
                    <p class="mt-1.5 text-sm leading-6" style="color:rgba(255,255,255,.6);max-width:46ch;">
                        Create, publish, and manage announcements visible to all registered alumni.
                    </p>
                </div>

                {{-- Actions --}}
                <div class="flex flex-wrap items-center gap-3 lg:mt-1 lg:shrink-0">
                    {{-- Search --}}
                    <div class="relative w-full sm:w-72">
                        <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3"
                              style="color:rgba(255,255,255,.45);">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z"/>
                            </svg>
                        </span>
                        <input
                            type="text"
                            wire:model.live.debounce.300ms="search"
                            placeholder="Search title or message…"
                            class="an-field-search"
                        >
                    </div>

                    {{-- New Announcement --}}
                    <flux:modal.trigger name="create-announcement">
                        <button
                            type="button"
                            wire:click="resetCreateForm"
                            class="btn-gold"
                        >
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                            </svg>
                            New Announcement
                        </button>
                    </flux:modal.trigger>
                </div>
            </div>

            {{-- Stats strip --}}
            <div class="mt-5 pt-5 flex flex-wrap items-center gap-2"
                 style="border-top:1px solid rgba(255,255,255,.12);">
                <span class="chip chip-blue" style="background:rgba(255,255,255,.12);color:rgba(255,255,255,.75);border-color:rgba(255,255,255,.18);">
                    {{ $announcements->total() }} {{ $announcements->total() === 1 ? 'announcement' : 'announcements' }}
                </span>
                @if ($search)
                    <span class="chip" style="background:rgba(196,149,42,.2);color:var(--g4);border:1px solid rgba(196,149,42,.3);">
                        Results for &ldquo;{{ $search }}&rdquo;
                    </span>
                @endif
                <span x-show="recentlyCreated" x-transition.opacity
                      class="chip"
                      style="background:rgba(16,185,129,.18);color:#6ee7b7;border:1px solid rgba(16,185,129,.25);">
                    ✓ Published
                </span>
            </div>
        </div>
    </section>

    @include('partials.toast')

    {{-- ════════════════════════════════════════════════════════
         TABLE
    ════════════════════════════════════════════════════════ --}}
    <section class="overflow-hidden rounded-2xl bg-white"
             style="border:1px solid #e2e8f0;box-shadow:0 1px 6px rgba(15,23,42,.05);">

        {{-- Table header --}}
        <div class="flex flex-col gap-2 px-5 py-4 sm:flex-row sm:items-center sm:justify-between"
             style="border-bottom:1px solid #f1f5f9;">
            <div>
                <h2 class="text-base font-bold text-slate-900">Announcement Board</h2>
                <p class="mt-0.5 text-xs text-slate-500">
                    Showing {{ $announcements->firstItem() ?? 0 }}–{{ $announcements->lastItem() ?? 0 }}
                    of {{ $announcements->total() }}
                    @if ($search) matching <strong class="text-slate-700">"{{ $search }}"</strong> @endif
                </p>
            </div>
        </div>

        {{-- Table --}}
        <div class="overflow-x-auto">
            <table class="an-table min-w-full">
                <thead style="background:#f8fafc;border-bottom:1px solid #e2e8f0;">
                    <tr>
                        <th>Announcement</th>
                        <th>Status</th>
                        <th>Published</th>
                        <th>Author</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($announcements as $a)
                        @php
                            $authorName = trim(
                                ($a->creator?->alumni?->fname ?? '') . ' ' . ($a->creator?->alumni?->lname ?? '')
                            ) ?: 'Unknown';
                            $dateDisplay = $a->published_at ?? $a->created_at;
                            $bodyPreview = \Illuminate\Support\Str::limit(strip_tags($a->body), 120);
                        @endphp

                        <tr
                            wire:key="announcement-{{ $a->id }}"
                            x-show="removingId !== {{ $a->id }}"
                            x-transition:leave.duration.500ms
                            x-transition:leave.opacity
                            :class="recentlyUpdated === {{ $a->id }} ? 'bg-blue-50/60' : ''"
                        >
                            {{-- Content --}}
                            <td style="min-width:280px;max-width:400px;">
                                <div class="flex flex-wrap items-center gap-2 mb-1.5">
                                    @if ($a->pinned)
                                        <span class="chip chip-pinned" style="font-size:.62rem;">
                                            <svg class="w-2.5 h-2.5" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 2a.75.75 0 0 1 .75.75v.258a33.186 33.186 0 0 1 6.668 1.698.75.75 0 0 1-.232 1.464l-.338-.034a33.22 33.22 0 0 1 1.197 2.298.75.75 0 0 1-.753 1.064l-.345-.034a33.17 33.17 0 0 1-.85 1.564.75.75 0 0 1-1.305-.057 33.02 33.02 0 0 1-.94-1.836 16.38 16.38 0 0 0-3.043.27.75.75 0 0 1-.87-.614 16.43 16.43 0 0 0-.148-.727.75.75 0 0 1 .75-.891l.342.034c.07-.226.147-.454.23-.683a.75.75 0 0 1 1.4.536 32.48 32.48 0 0 0-.287.821l-.337-.034a31.47 31.47 0 0 0-1.02-1.98.75.75 0 0 1-.33-1.004l.33-.658H10.75V2.75A.75.75 0 0 1 10 2ZM5.025 6.5a.75.75 0 0 1 .75.75.75.75 0 0 1-.75.75.75.75 0 0 1-.75-.75.75.75 0 0 1 .75-.75Zm-.834 3.75a.75.75 0 0 0-1.09.67v5.83a.75.75 0 0 0 1.09.67L10 14.5l5.81 2.92a.75.75 0 0 0 1.09-.67V10.92a.75.75 0 0 0-1.09-.67L10 13.17l-5.81-2.92Z" clip-rule="evenodd"/>
                                            </svg>
                                            Pinned
                                        </span>
                                    @endif
                                    @if ($a->expires_at && $a->expires_at->isPast())
                                        <span class="chip chip-draft" style="font-size:.62rem;">Expired</span>
                                    @endif
                                </div>
                                <p class="text-sm font-bold text-slate-900 leading-snug">{{ $a->title }}</p>
                                <p class="mt-1 text-xs leading-5 text-slate-500">{{ $bodyPreview }}</p>
                            </td>

                            {{-- Status --}}
                            <td style="min-width:100px;">
                                @if ($a->is_published)
                                    <span class="chip chip-published">
                                        <span class="chip-dot" style="background:#10b981;"></span>
                                        Published
                                    </span>
                                @else
                                    <span class="chip chip-draft">
                                        <span class="chip-dot" style="background:#94a3b8;"></span>
                                        Draft
                                    </span>
                                @endif
                            </td>

                            {{-- Date --}}
                            <td style="min-width:130px;">
                                @if ($dateDisplay)
                                    <p class="text-xs font-semibold text-slate-700 leading-tight">
                                        {{ $dateDisplay->timezone('Asia/Manila')->format('M d, Y') }}
                                    </p>
                                    <p class="text-[.68rem] text-slate-400 mt-0.5">
                                        {{ $dateDisplay->timezone('Asia/Manila')->format('g:i A') }}
                                    </p>
                                    <p class="text-[.65rem] text-slate-300 mt-0.5">
                                        {{ $dateDisplay->diffForHumans() }}
                                    </p>
                                @else
                                    <span class="text-xs text-slate-400">-</span>
                                @endif
                            </td>

                            {{-- Author --}}
                            <td style="min-width:130px;">
                                <div class="flex items-center gap-2">
                                    <div style="width:1.75rem;height:1.75rem;border-radius:.5rem;
                                                background:linear-gradient(135deg,var(--r6),var(--r8));
                                                display:flex;align-items:center;justify-content:center;
                                                font-size:.65rem;font-weight:800;color:#fff;flex-shrink:0;">
                                        {{ strtoupper(substr($authorName, 0, 1)) }}
                                    </div>
                                    <p class="text-xs font-semibold text-slate-700 leading-tight">{{ $authorName }}</p>
                                </div>
                            </td>

                            {{-- Actions --}}
                            <td style="min-width:130px;">
                                <div class="flex items-center justify-end gap-1.5">
                                    <button
                                        type="button"
                                        wire:click="startEdit({{ $a->id }})"
                                        wire:loading.attr="disabled"
                                        wire:target="startEdit({{ $a->id }})"
                                        class="btn-edit"
                                    >
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Z"/>
                                        </svg>
                                        Edit
                                    </button>

                                    <button
                                        type="button"
                                        wire:click="confirmDelete({{ $a->id }})"
                                        wire:loading.attr="disabled"
                                        wire:target="confirmDelete({{ $a->id }})"
                                        class="btn-delete"
                                    >
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"/>
                                        </svg>
                                        Delete
                                    </button>
                                </div>
                            </td>
                        </tr>

                    @empty
                        <tr>
                            <td colspan="5" style="padding:4rem 2rem;">
                                <div style="max-width:22rem;margin:0 auto;text-align:center;">
                                    <div style="width:3.5rem;height:3.5rem;border-radius:1rem;
                                                background:#f0f4fb;border:1px solid #e2e8f0;
                                                display:flex;align-items:center;justify-content:center;
                                                margin:0 auto 1rem;">
                                        <svg style="width:1.5rem;height:1.5rem;color:#94a3b8;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M10.34 15.84c-.688-.06-1.386-.09-2.09-.09H7.5a4.5 4.5 0 1 1 0-9h.75c.704 0 1.402-.03 2.09-.09m0 9.18c.253.962.584 1.892.985 2.783.247.55.06 1.21-.463 1.511l-.657.38c-.551.318-1.26.117-1.527-.461a20.845 20.845 0 0 1-1.44-4.282m3.102.069a18.03 18.03 0 0 1-.59-4.59c0-1.586.205-3.124.59-4.59m0 9.18a23.848 23.848 0 0 1 8.835 2.535M10.34 6.66a23.847 23.847 0 0 1 8.835-2.535m0 0A23.74 23.74 0 0 1 18.795 3m.38 1.125a23.91 23.91 0 0 1 1.014 5.395m-1.014 8.855c-.118.38-.245.754-.38 1.125m.38-1.125a23.91 23.91 0 0 0 1.014-5.395m0-3.46c.495.413.811 1.035.811 1.73 0 .695-.316 1.317-.811 1.73m0-3.46a24.347 24.347 0 0 1 0 3.46"/>
                                        </svg>
                                    </div>
                                    <h3 style="font-size:1rem;font-weight:700;color:#1e293b;margin-bottom:.4rem;">
                                        No announcements found
                                    </h3>
                                    <p style="font-size:.8125rem;color:#64748b;line-height:1.6;margin-bottom:1.25rem;">
                                        @if ($search)
                                            No results for <strong>"{{ $search }}"</strong>. Try a different search term.
                                        @else
                                            No announcements have been published yet. Create your first one.
                                        @endif
                                    </p>
                                    <flux:modal.trigger name="create-announcement">
                                        <button type="button" wire:click="resetCreateForm" class="btn-gold">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                                            </svg>
                                            New Announcement
                                        </button>
                                    </flux:modal.trigger>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if (method_exists($announcements, 'links'))
            <div class="flex flex-col gap-3 px-5 py-4 sm:flex-row sm:items-center sm:justify-between"
                 style="border-top:1px solid #f1f5f9;background:#fafbff;">
                <p class="text-xs text-slate-400">
                    Showing {{ $announcements->firstItem() ?? 0 }}–{{ $announcements->lastItem() ?? 0 }}
                    of {{ $announcements->total() }}
                </p>
                <div>{{ $announcements->links() }}</div>
            </div>
        @endif
    </section>

</div>

{{-- ════════════════════════════════════════════════════════════════
     CREATE MODAL
════════════════════════════════════════════════════════════════ --}}
<flux:modal name="create-announcement" class="md:w-[40rem]">
    <form wire:submit.prevent="store" class="text-slate-800">

        {{-- Modal header --}}
        <div class="px-6 py-5" style="background:linear-gradient(135deg,var(--r8),var(--r6));border-radius:inherit inherit 0 0;">
            <p class="text-[.62rem] font-bold uppercase tracking-[.2em]" style="color:var(--g4);">Admin Control</p>
            <h3 class="mt-1 text-lg font-bold text-white" style="font-family:Georgia,serif;">New Announcement</h3>
            <p class="mt-0.5 text-xs" style="color:rgba(255,255,255,.6);">
                This will be published immediately and visible to all alumni.
            </p>
        </div>

        {{-- Body --}}
        <div class="space-y-4 p-6">

            <div>
                <label class="modal-label">Title</label>
                <input
                    type="text"
                    wire:model.defer="announceTitle"
                    class="modal-field"
                    placeholder="Enter a clear, concise announcement title"
                >
                @error('announceTitle')
                    <p class="mt-1.5 text-xs text-red-600 flex items-center gap-1">
                        <svg class="w-3 h-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <div>
                <label class="modal-label">Message</label>
                <textarea
                    wire:model.defer="announceBody"
                    rows="7"
                    class="modal-field"
                    placeholder="Write your announcement message here…"
                    style="resize:vertical;"
                ></textarea>
                @error('announceBody')
                    <p class="mt-1.5 text-xs text-red-600 flex items-center gap-1">
                        <svg class="w-3 h-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <div class="rounded-xl px-4 py-3 text-xs leading-5"
                 style="background:#f0f4fb;border:1px solid #e2e8f0;color:#475569;">
                <strong class="text-slate-700">Note:</strong> This announcement will be published immediately
                with your account as the author and will appear on the alumni board.
            </div>
        </div>

        {{-- Footer --}}
        <div class="flex items-center justify-end gap-2 px-6 py-4"
             style="border-top:1px solid #e2e8f0;background:#f8fafc;">
            <flux:modal.close>
                <button type="button" wire:click="resetCreateForm" class="btn-ghost">
                    Cancel
                </button>
            </flux:modal.close>
            <button
                type="submit"
                wire:loading.attr="disabled"
                wire:target="store"
                class="btn-gold"
            >
                <span wire:loading.remove wire:target="store" class="flex items-center gap-1.5">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.34 15.84c-.688-.06-1.386-.09-2.09-.09H7.5a4.5 4.5 0 1 1 0-9h.75c.704 0 1.402-.03 2.09-.09m0 9.18c.253.962.584 1.892.985 2.783.247.55.06 1.21-.463 1.511l-.657.38c-.551.318-1.26.117-1.527-.461a20.845 20.845 0 0 1-1.44-4.282m3.102.069a18.03 18.03 0 0 1-.59-4.59c0-1.586.205-3.124.59-4.59m0 9.18a23.848 23.848 0 0 1 8.835 2.535M10.34 6.66a23.847 23.847 0 0 1 8.835-2.535m0 0A23.74 23.74 0 0 1 18.795 3m.38 1.125a23.91 23.91 0 0 1 1.014 5.395m-1.014 8.855c-.118.38-.245.754-.38 1.125m.38-1.125a23.91 23.91 0 0 0 1.014-5.395m0-3.46c.495.413.811 1.035.811 1.73 0 .695-.316 1.317-.811 1.73m0-3.46a24.347 24.347 0 0 1 0 3.46"/>
                    </svg>
                    Publish Announcement
                </span>
                <span wire:loading wire:target="store">Publishing…</span>
            </button>
        </div>

    </form>
</flux:modal>

{{-- ════════════════════════════════════════════════════════════════
     EDIT MODAL
════════════════════════════════════════════════════════════════ --}}
@if ($showEditModal)
    <div style="position:fixed;inset:0;z-index:60;display:flex;align-items:center;justify-content:center;
                background:rgba(10,31,92,.55);backdrop-filter:blur(4px);padding:1.25rem;"
         wire:click.self="resetEditForm">

        <div style="width:100%;max-width:40rem;background:#fff;border-radius:1.25rem;overflow:hidden;
                    box-shadow:0 32px 80px rgba(10,31,92,.3),0 0 0 1px rgba(26,63,168,.1);">

            <form wire:submit.prevent="updateAnnouncement">

                {{-- Header --}}
                <div style="background:linear-gradient(135deg,var(--r8) 0%,var(--r6) 100%);padding:1.25rem 1.5rem;">
                    <div class="flex items-start justify-between gap-4">
                        <div class="flex items-center gap-3">
                            <div style="width:2.25rem;height:2.25rem;border-radius:.6rem;
                                        background:rgba(255,255,255,.15);border:1px solid rgba(255,255,255,.25);
                                        display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                <svg style="width:1rem;height:1rem;color:#fff;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Z"/>
                                </svg>
                            </div>
                            <div>
                                <p style="font-size:.62rem;font-weight:700;text-transform:uppercase;letter-spacing:.2em;color:var(--g4);">
                                    Admin Control
                                </p>
                                <h3 style="margin-top:.2rem;font-size:1rem;font-weight:700;color:#fff;font-family:Georgia,serif;">
                                    Edit Announcement
                                </h3>
                                <p style="margin-top:.2rem;font-size:.75rem;color:rgba(255,255,255,.6);">
                                    Update the title or body. Changes take effect immediately.
                                </p>
                            </div>
                        </div>
                        <button type="button" wire:click="resetEditForm"
                                style="flex-shrink:0;width:1.75rem;height:1.75rem;border-radius:.4rem;
                                       background:rgba(255,255,255,.12);border:1px solid rgba(255,255,255,.2);
                                       color:#fff;cursor:pointer;display:flex;align-items:center;justify-content:center;">
                            <svg style="width:.75rem;height:.75rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                </div>

                {{-- Body --}}
                <div style="padding:1.5rem;background:#f8fafc;display:flex;flex-direction:column;gap:1rem;">

                    <div>
                        <label class="modal-label">Title</label>
                        <input type="text" wire:model.defer="editTitle"
                               class="modal-field" placeholder="Enter announcement title">
                        @error('editTitle')
                            <p style="margin-top:.35rem;font-size:.74rem;color:#dc2626;font-weight:500;display:flex;align-items:center;gap:.3rem;">
                                <svg style="width:.75rem;height:.75rem;flex-shrink:0;" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div>
                        <label class="modal-label">Message</label>
                        <textarea wire:model.defer="editBody" rows="7"
                                  class="modal-field" placeholder="Update the announcement message…"
                                  style="resize:vertical;"></textarea>
                        @error('editBody')
                            <p style="margin-top:.35rem;font-size:.74rem;color:#dc2626;font-weight:500;display:flex;align-items:center;gap:.3rem;">
                                <svg style="width:.75rem;height:.75rem;flex-shrink:0;" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                </div>

                {{-- Footer --}}
                <div style="display:flex;align-items:center;justify-content:flex-end;gap:.625rem;
                            padding:.875rem 1.5rem;border-top:1px solid #e2e8f0;background:#fff;">
                    <button type="button" wire:click="resetEditForm" class="btn-ghost">
                        Cancel
                    </button>
                    <button type="submit"
                            wire:loading.attr="disabled"
                            wire:target="updateAnnouncement"
                            class="btn-primary">
                        <span wire:loading.remove wire:target="updateAnnouncement" class="flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                            </svg>
                            Save Changes
                        </span>
                        <span wire:loading wire:target="updateAnnouncement">Saving…</span>
                    </button>
                </div>

            </form>
        </div>
    </div>
@endif

{{-- ════════════════════════════════════════════════════════════════
     DELETE MODAL
════════════════════════════════════════════════════════════════ --}}
{{-- ════════════════════════════════════════════════════════════════ --}}
{{-- DELETE CONFIRMATION MODAL                                         --}}
{{-- ════════════════════════════════════════════════════════════════ --}}
@if ($showDeleteModal)
    <div style="position:fixed;inset:0;z-index:60;display:flex;align-items:center;justify-content:center;
                background:rgba(10,31,92,.55);backdrop-filter:blur(4px);padding:1.25rem;"
         wire:click.self="resetDeleteForm">

        <div style="width:100%;max-width:26rem;background:#fff;border-radius:1.25rem;overflow:hidden;
                    box-shadow:0 32px 80px rgba(10,31,92,.3),0 0 0 1px rgba(220,38,38,.12);">

            {{-- Header --}}
            <div style="background:linear-gradient(135deg,#991b1b 0%,#dc2626 100%);padding:1.25rem 1.5rem;">
                <div class="flex items-center gap-3">
                    <div style="width:2.25rem;height:2.25rem;border-radius:.6rem;
                                background:rgba(255,255,255,.15);border:1px solid rgba(255,255,255,.25);
                                display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                        <svg style="width:1.1rem;height:1.1rem;color:#fff;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z"/>
                        </svg>
                    </div>
                    <div>
                        <p style="font-size:.62rem;font-weight:700;text-transform:uppercase;letter-spacing:.2em;color:rgba(255,255,255,.65);">
                            Destructive Action
                        </p>
                        <h3 style="margin-top:.2rem;font-size:1rem;font-weight:700;color:#fff;font-family:Georgia,serif;">
                            Delete Announcement
                        </h3>
                    </div>
                </div>
            </div>

            {{-- Body --}}
            <div style="padding:1.4rem 1.5rem;space-y:1rem;">
                <p style="font-size:.875rem;color:#374151;line-height:1.65;margin-bottom:1rem;">
                    You are about to permanently delete:
                </p>

                <div style="background:#f8fafc;border:1px solid #e2e8f0;border-radius:.875rem;padding:.875rem 1rem;margin-bottom:1rem;">
                    <p style="font-size:.62rem;font-weight:700;text-transform:uppercase;letter-spacing:.1em;color:#94a3b8;margin-bottom:.25rem;">
                        Announcement
                    </p>
                    <p style="font-size:.875rem;font-weight:700;color:#111827;">&ldquo;{{ $deleteTitle }}&rdquo;</p>
                </div>

                <div style="background:#fef2f2;border:1px solid #fecaca;border-radius:.875rem;padding:.75rem 1rem;">
                    <p style="font-size:.75rem;font-weight:600;color:#991b1b;line-height:1.55;">
                        This will permanently remove the announcement from the alumni board. Alumni will no longer be able to see it.
                    </p>
                </div>
            </div>

            {{-- Footer --}}
            <div style="display:flex;align-items:center;justify-content:flex-end;gap:.625rem;
                        padding:.875rem 1.5rem;border-top:1px solid #f1f5f9;background:#fafbff;">
                <button type="button" wire:click="resetDeleteForm" class="btn-ghost">
                    Cancel
                </button>
                <button
                    type="button"
                    wire:click="destroyAnnouncement"
                    wire:loading.attr="disabled"
                    wire:target="destroyAnnouncement"
                    style="display:inline-flex;align-items:center;gap:.4rem;height:2.375rem;padding:0 1.1rem;
                           border-radius:.75rem;background:linear-gradient(135deg,#dc2626 0%,#991b1b 100%);
                           box-shadow:0 4px 14px rgba(220,38,38,.3);
                           color:#fff;font-size:.8rem;font-weight:700;border:none;cursor:pointer;
                           transition:filter .15s;"
                    onmouseover="this.style.filter='brightness(1.1)'"
                    onmouseout="this.style.filter='none'">
                    <span wire:loading.remove wire:target="destroyAnnouncement" style="display:inline-flex;align-items:center;gap:.4rem;">
                        <svg style="width:.9rem;height:.9rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"/>
                        </svg>
                        Yes, Delete It
                    </span>
                    <span wire:loading wire:target="destroyAnnouncement">Deleting…</span>
                </button>
            </div>

        </div>
    </div>
@endif

</div>
