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

    /* ── Fields ── */
    .ee-field {
        width: 100%;
        border-radius: .75rem;
        border: 1px solid #e2e8f0;
        background: #fff;
        padding: .625rem .875rem;
        font-size: .8125rem;
        color: #0f172a;
        outline: none;
        transition: border-color .15s, box-shadow .15s;
        font-family: inherit;
    }
    .ee-field::placeholder { color: #94a3b8; }
    .ee-field:hover  { border-color: #94a3b8; }
    .ee-field:focus  { border-color: var(--r6); box-shadow: 0 0 0 3px rgba(26,63,168,.1); }

    .ee-label {
        display: block;
        font-size: .62rem;
        font-weight: 700;
        letter-spacing: .1em;
        text-transform: uppercase;
        color: #64748b;
        margin-bottom: .35rem;
    }
    .ee-hint  { font-size: .71rem; color: #94a3b8; margin-top: .28rem; }
    .ee-error { font-size: .74rem; color: #dc2626; margin-top: .28rem; font-weight: 500; }

    /* ── Cards ── */
    .ee-card {
        background: #fff;
        border-radius: 1.25rem;
        border: 1px solid #e2e8f0;
        box-shadow: 0 1px 6px rgba(15,23,42,.05);
        overflow: hidden;
    }
    .ee-card-header {
        padding: .9rem 1.25rem;
        border-bottom: 1px solid #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: .75rem;
    }
    .ee-card-header-left { display: flex; align-items: center; gap: .6rem; }
    .ee-card-icon {
        width: 1.75rem; height: 1.75rem;
        border-radius: .5rem;
        display: flex; align-items: center; justify-content: center;
        background: #eef2ff; color: var(--r6); flex-shrink: 0;
    }
    .ee-card-icon.gold  { background: #fef9ee; color: var(--g5); }
    .ee-card-icon.green { background: #ecfdf5; color: #065f46; }
    .ee-card-title { font-size: .82rem; font-weight: 700; color: #1e293b; }
    .ee-card-sub   { font-size: .69rem; color: #94a3b8; margin-top: .08rem; }
    .ee-card-body  { padding: 1.25rem; }

    /* ── Buttons ── */
    .btn-primary {
        display: inline-flex; align-items: center; justify-content: center; gap: .4rem;
        height: 2.375rem; padding: 0 1.1rem;
        border-radius: .75rem;
        background: linear-gradient(135deg, var(--r6) 0%, var(--r8) 100%);
        box-shadow: 0 4px 14px rgba(21,53,145,.25), inset 0 1px 0 rgba(255,255,255,.1);
        color: #fff; font-size: .8rem; font-weight: 700;
        transition: filter .15s, transform .1s;
        cursor: pointer; border: none; font-family: inherit; white-space: nowrap;
    }
    .btn-primary:hover  { filter: brightness(1.08); }
    .btn-primary:active { transform: translateY(1px); }
    .btn-primary:disabled { opacity: .6; cursor: not-allowed; }

    .btn-gold-sm {
        display: inline-flex; align-items: center; justify-content: center; gap: .35rem;
        height: 2.125rem; padding: 0 .875rem;
        border-radius: .65rem;
        background: linear-gradient(135deg, var(--g5) 0%, #a37522 100%);
        box-shadow: 0 3px 10px rgba(196,149,42,.25);
        color: #fff; font-size: .75rem; font-weight: 700;
        transition: filter .15s, transform .1s;
        cursor: pointer; border: none; font-family: inherit; white-space: nowrap;
    }
    .btn-gold-sm:hover  { filter: brightness(1.07); }
    .btn-gold-sm:active { transform: translateY(1px); }

    .btn-ghost {
        display: inline-flex; align-items: center; justify-content: center; gap: .4rem;
        height: 2.375rem; padding: 0 1rem;
        border-radius: .75rem;
        background: #fff; border: 1px solid #e2e8f0;
        color: #475569; font-size: .8rem; font-weight: 600;
        transition: background .12s, border-color .12s, color .12s;
        cursor: pointer; font-family: inherit; text-decoration: none; white-space: nowrap;
    }
    .btn-ghost:hover { background: #f8fafc; border-color: #cbd5e1; color: #1e293b; }

    .btn-add {
        display: inline-flex; align-items: center; gap: .3rem;
        height: 2rem; padding: 0 .75rem;
        border-radius: .6rem;
        background: #eef2ff; border: 1px solid #c7d2fe;
        color: var(--r6); font-size: .74rem; font-weight: 700;
        transition: background .12s; cursor: pointer; border: none; font-family: inherit;
        white-space: nowrap;
    }
    .btn-add:hover { background: #e0e7ff; }

    .btn-save-section {
        display: inline-flex; align-items: center; justify-content: center; gap: .4rem;
        height: 2.25rem; padding: 0 1.1rem;
        border-radius: .7rem;
        background: var(--r6); border: 1px solid var(--r7);
        color: #fff; font-size: .775rem; font-weight: 700;
        transition: background .12s; cursor: pointer; font-family: inherit; white-space: nowrap;
    }
    .btn-save-section:hover { background: var(--r7); }

    .btn-remove {
        display: inline-flex; align-items: center; gap: .3rem;
        height: 1.875rem; padding: 0 .65rem;
        border-radius: .5rem;
        background: #fff; border: 1px solid #fecaca;
        color: #dc2626; font-size: .72rem; font-weight: 600;
        transition: background .12s; cursor: pointer; font-family: inherit; white-space: nowrap;
    }
    .btn-remove:hover { background: #fef2f2; border-color: #fca5a5; }

    /* ── Chips ── */
    .status-chip {
        display: inline-flex; align-items: center; gap: .3rem;
        padding: .2rem .6rem; border-radius: 999px;
        font-size: .68rem; font-weight: 700; letter-spacing: .04em; white-space: nowrap;
    }
    .status-dot { width:.45rem; height:.45rem; border-radius:50%; flex-shrink:0; }
    .chip-green  { background:#ecfdf5; color:#065f46; border:1px solid #a7f3d0; }
    .chip-slate  { background:#f1f5f9; color:#475569; border:1px solid #e2e8f0; }
    .chip-blue   { background:#eef2ff; color:var(--r6); border:1px solid #c7d2fe; }
    .chip-amber  { background:#fffbeb; color:#92700a; border:1px solid #fde68a; }

    .sum-chip {
        display: inline-flex; align-items: center; gap: .5rem;
        padding: .35rem .85rem; border-radius: 999px;
        font-size: .7rem; font-weight: 700; white-space: nowrap;
    }

    /* ── Toggle ── */
    .ee-toggle { display: inline-flex; align-items: center; cursor: pointer; user-select: none; gap: .6rem; }
    .ee-toggle input[type=checkbox] { display: none; }
    .ee-toggle-track {
        width: 2.5rem; height: 1.375rem; border-radius: 999px;
        background: #e2e8f0; transition: background .2s;
        position: relative; flex-shrink: 0;
    }
    .ee-toggle input:checked ~ .ee-toggle-track { background: var(--r6); }
    .ee-toggle-thumb {
        position: absolute; top: .1875rem; left: .1875rem;
        width: 1rem; height: 1rem; border-radius: 50%;
        background: #fff; box-shadow: 0 1px 3px rgba(0,0,0,.2); transition: left .2s;
    }
    .ee-toggle input:checked ~ .ee-toggle-track .ee-toggle-thumb { left: 1.3125rem; }

    /* ── Timeline (schedule rows) ── */
    .timeline-item {
        position: relative;
        padding-left: 2.25rem;
    }
    .timeline-item::before {
        content: '';
        position: absolute; left: .6rem; top: 2.2rem; bottom: -1.25rem;
        width: 2px; background: #e2e8f0;
    }
    .timeline-item:last-child::before { display: none; }
    .timeline-dot {
        position: absolute; left: .1rem; top: .85rem;
        width: 1rem; height: 1rem; border-radius: 50%;
        background: var(--r6); border: 2px solid #fff;
        box-shadow: 0 0 0 2px var(--r6);
        display: flex; align-items: center; justify-content: center;
    }
    .timeline-dot-inner {
        width: .3rem; height: .3rem; border-radius: 50%; background: #fff;
    }

    /* ── Item card (reg items) ── */
    .item-card {
        border: 1px solid #e2e8f0;
        border-radius: 1rem;
        background: #f8fafc;
        overflow: hidden;
    }
    .item-card-num {
        width: 1.5rem; height: 1.5rem; border-radius: .4rem;
        background: var(--r6); color: #fff;
        font-size: .65rem; font-weight: 800;
        display: inline-flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }

    /* ── Upload zone ── */
    .ee-upload-zone {
        border: 2px dashed #e2e8f0; border-radius: 1rem;
        padding: 1.5rem 1rem; text-align: center; cursor: pointer;
        transition: border-color .15s, background .15s; background: #f8fafc;
    }
    .ee-upload-zone:hover { border-color: var(--r5); background: #f0f4fb; }
</style>

<div class="space-y-5 px-4 py-6 sm:px-6 lg:px-8 mx-auto max-w-screen-2xl">

    {{-- ════════════════════════════════════════════════════════════
         HEADER BANNER
    ════════════════════════════════════════════════════════════ --}}
    <section class="overflow-hidden rounded-2xl"
             style="background:linear-gradient(155deg,var(--r8) 0%,var(--r7) 45%,var(--r6) 100%);
                    box-shadow:0 8px 32px rgba(10,31,92,.28);">
        <div class="pointer-events-none absolute inset-0 overflow-hidden" aria-hidden="true"
             style="position:relative;">
            <span style="position:absolute;right:2rem;top:50%;transform:translateY(-50%);
                         font-family:Georgia,serif;font-size:7rem;font-weight:900;color:#fff;
                         opacity:.025;letter-spacing:.05em;user-select:none;white-space:nowrap;">
                EDIT EVENT
            </span>
        </div>

        <div class="relative px-6 py-6 sm:px-8">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
                <div>
                    <p class="text-[.65rem] font-bold uppercase tracking-[.22em]" style="color:var(--g4);">
                        HSST Alumni Portal &middot; Admin Control
                    </p>
                    <h1 class="mt-2 text-2xl font-bold tracking-tight text-white sm:text-3xl"
                        style="font-family:Georgia,serif;letter-spacing:-.01em;">
                        {{ $event->title }}
                    </h1>
                    <p class="mt-1.5 text-sm leading-6" style="color:rgba(255,255,255,.6);max-width:52ch;">
                        Update event details, manage the program schedule, and configure paid registration items.
                    </p>
                </div>

                <div class="flex items-center gap-2 sm:mt-1 sm:shrink-0">
                    <a href="{{ route('event-view') }}" wire:navigate
                       style="display:inline-flex;align-items:center;gap:.4rem;height:2.375rem;padding:0 .875rem;
                              border-radius:.75rem;background:rgba(255,255,255,.12);border:1px solid rgba(255,255,255,.2);
                              color:#fff;font-size:.8rem;font-weight:600;text-decoration:none;transition:background .15s;">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18"/>
                        </svg>
                        Back to Events
                    </a>
                </div>
            </div>

            {{-- Summary strip --}}
            <div class="mt-5 flex flex-wrap items-center gap-2 pt-5"
                 style="border-top:1px solid rgba(255,255,255,.12);">
                @if($event->event_date)
                    <span class="sum-chip" style="background:rgba(255,255,255,.14);color:#fff;border:1px solid rgba(255,255,255,.18);">
                        <svg class="w-3.5 h-3.5 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5"/>
                        </svg>
                        {{ \Carbon\Carbon::parse($event->event_date)->format('M d, Y · h:i A') }}
                    </span>
                @endif
                @if($event->venue)
                    <span class="sum-chip" style="background:rgba(196,149,42,.14);color:var(--g4);border:1px solid rgba(196,149,42,.22);">
                        <svg class="w-3.5 h-3.5 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z"/>
                        </svg>
                        {{ $event->venue }}
                    </span>
                @endif
                <span class="sum-chip" style="background:{{ $event->is_active ? 'rgba(16,185,129,.14)' : 'rgba(239,68,68,.1)' }};
                             color:{{ $event->is_active ? '#6ee7b7' : '#fca5a5' }};
                             border:1px solid {{ $event->is_active ? 'rgba(16,185,129,.2)' : 'rgba(239,68,68,.18)' }};">
                    <span style="width:.45rem;height:.45rem;border-radius:50%;
                                 background:{{ $event->is_active ? '#6ee7b7' : '#fca5a5' }};
                                 flex-shrink:0;display:inline-block;"></span>
                    {{ $event->is_active ? 'Active' : 'Inactive' }}
                </span>
            </div>
        </div>
    </section>

    @include('partials.toast')

    {{-- ════════════════════════════════════════════════════════════
         MAIN GRID
    ════════════════════════════════════════════════════════════ --}}
    <div class="grid gap-5 xl:grid-cols-[1.1fr_.9fr]">

        {{-- ── LEFT: Event Details form ── --}}
        <div class="space-y-5">
            <form wire:submit.prevent="update" class="space-y-5">

                {{-- Core details card --}}
                <div class="ee-card">
                    <div class="ee-card-header">
                        <div class="ee-card-header-left">
                            <div class="ee-card-icon">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5"/>
                                </svg>
                            </div>
                            <div>
                                <p class="ee-card-title">Event Details</p>
                                <p class="ee-card-sub">Basic info alumni see when browsing</p>
                            </div>
                        </div>
                    </div>
                    <div class="ee-card-body">
                        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">

                            <div class="md:col-span-2">
                                <label class="ee-label">Title <span style="color:#dc2626;">*</span></label>
                                <input type="text" wire:model.defer="title"
                                       placeholder="Event title" class="ee-field" />
                                @error('title') <p class="ee-error">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="ee-label">Venue <span style="color:#dc2626;">*</span></label>
                                <input type="text" wire:model.defer="venue"
                                       placeholder="e.g. School Gymnasium" class="ee-field" />
                                @error('venue') <p class="ee-error">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="ee-label">Dress Code</label>
                                <input type="text" wire:model.defer="dress_code"
                                       placeholder="e.g. Formal Attire" class="ee-field" />
                                @error('dress_code') <p class="ee-error">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="ee-label">Event Date & Time <span style="color:#dc2626;">*</span></label>
                                <input type="datetime-local" wire:model.defer="event_date" class="ee-field" />
                                @error('event_date') <p class="ee-error">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="ee-label">Registration Fee (₱) <span style="color:#dc2626;">*</span></label>
                                <input type="number" min="0" step="1"
                                       wire:model.defer="registration_fee"
                                       placeholder="0" class="ee-field" />
                                <p class="ee-hint">Amount in pesos.</p>
                                @error('registration_fee') <p class="ee-error">{{ $message }}</p> @enderror
                            </div>

                        </div>
                    </div>
                </div>

                {{-- Description card --}}
                <div class="ee-card">
                    <div class="ee-card-header">
                        <div class="ee-card-header-left">
                            <div class="ee-card-icon">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25H12"/>
                                </svg>
                            </div>
                            <div>
                                <p class="ee-card-title">Description</p>
                                <p class="ee-card-sub">Program details, reminders, payment notes</p>
                            </div>
                        </div>
                    </div>
                    <div class="ee-card-body">
                        <textarea wire:model.defer="description" rows="6"
                                  placeholder="Add program details, reminders, registration instructions, and other important information."
                                  class="ee-field" style="resize:vertical;"></textarea>
                        @error('description') <p class="ee-error">{{ $message }}</p> @enderror
                    </div>
                </div>

                {{-- Banner card --}}
                <div class="ee-card">
                    <div class="ee-card-header">
                        <div class="ee-card-header-left">
                            <div class="ee-card-icon gold">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="ee-card-title">Event Banner</p>
                                <p class="ee-card-sub">JPG, PNG, WEBP &bull; Max 2MB</p>
                            </div>
                        </div>
                    </div>
                    <div class="ee-card-body space-y-3">
                        <input type="file" wire:model="new_banner_image"
                               accept="image/png,image/jpeg,image/jpg,image/webp"
                               class="hidden" id="bannerUpload" />

                        {{-- New upload preview --}}
                        @if ($new_banner_image)
                            <div class="relative overflow-hidden rounded-xl"
                                 style="border:1px solid #e2e8f0;">
                                <img src="{{ $new_banner_image->temporaryUrl() }}"
                                     class="h-48 w-full object-cover" alt="New banner preview" />
                                <div class="absolute inset-x-0 bottom-0 flex items-center justify-between px-3 py-2"
                                     style="background:linear-gradient(to top,rgba(0,0,0,.6),transparent);">
                                    <span class="text-xs font-semibold text-white">New banner preview</span>
                                    <button type="button"
                                            onclick="document.getElementById('bannerUpload').click()"
                                            style="background:rgba(255,255,255,.18);color:#fff;border:1px solid rgba(255,255,255,.3);
                                                   border-radius:.5rem;padding:.2rem .65rem;font-size:.72rem;font-weight:600;cursor:pointer;">
                                        Replace
                                    </button>
                                </div>
                            </div>

                        {{-- Current banner --}}
                        @elseif ($event->banner_image && !$remove_banner_image)
                            <div class="relative overflow-hidden rounded-xl"
                                 style="border:1px solid #e2e8f0;">
                                <img src="{{ Storage::disk('s3')->url($event->banner_image) }}"
                                     alt="{{ $event->title }}"
                                     class="h-48 w-full object-cover" />
                                <div class="absolute inset-x-0 bottom-0 flex items-center justify-between px-3 py-2"
                                     style="background:linear-gradient(to top,rgba(0,0,0,.6),transparent);">
                                    <span class="text-xs font-semibold text-white">Current banner</span>
                                    <button type="button"
                                            onclick="document.getElementById('bannerUpload').click()"
                                            style="background:rgba(255,255,255,.18);color:#fff;border:1px solid rgba(255,255,255,.3);
                                                   border-radius:.5rem;padding:.2rem .65rem;font-size:.72rem;font-weight:600;cursor:pointer;">
                                        Replace
                                    </button>
                                </div>
                            </div>

                        {{-- No banner / removed --}}
                        @else
                            <label for="bannerUpload" class="ee-upload-zone block">
                                <svg class="mx-auto h-8 w-8 mb-2" style="color:#cbd5e1;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5m-13.5-9L12 3m0 0 4.5 4.5M12 3v13.5"/>
                                </svg>
                                <p class="text-sm font-semibold" style="color:#475569;">Click to upload banner</p>
                                <p class="text-xs mt-0.5" style="color:#94a3b8;">Poster or event cover image</p>
                            </label>
                        @endif

                        <div wire:loading wire:target="new_banner_image"
                             class="text-xs font-medium" style="color:var(--r6);">
                            Uploading image...
                        </div>
                        @error('new_banner_image') <p class="ee-error">{{ $message }}</p> @enderror

                        @if ($event->banner_image && !$new_banner_image)
                            <label class="flex items-center gap-2.5 cursor-pointer select-none">
                                <input type="checkbox" wire:model="remove_banner_image"
                                       style="width:1rem;height:1rem;border-radius:.25rem;
                                              accent-color:#dc2626;cursor:pointer;" />
                                <span class="text-xs font-medium" style="color:#dc2626;">
                                    Remove current banner
                                </span>
                            </label>
                        @endif
                    </div>
                </div>

                {{-- Visibility + Save bar --}}
                <div class="ee-card">
                    <div class="ee-card-header">
                        <div class="ee-card-header-left">
                            <div class="ee-card-icon green">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                                </svg>
                            </div>
                            <p class="ee-card-title">Visibility</p>
                        </div>
                    </div>
                    <div class="ee-card-body">
                        <div class="flex items-center justify-between gap-4 rounded-xl px-4 py-3"
                             style="background:#f8fafc;border:1px solid #f1f5f9;">
                            <div>
                                <p class="text-sm font-semibold text-slate-800">Publish event</p>
                                <p class="mt-0.5 text-xs text-slate-400">
                                    When enabled, alumni can see and register for this event.
                                </p>
                            </div>
                            <label class="ee-toggle">
                                <input type="checkbox" wire:model.defer="is_active" />
                                <div class="ee-toggle-track">
                                    <div class="ee-toggle-thumb"></div>
                                </div>
                            </label>
                        </div>
                        @error('is_active') <p class="ee-error mt-2">{{ $message }}</p> @enderror
                    </div>
                </div>

                {{-- Save / Cancel --}}
                <div class="flex items-center justify-end gap-2.5">
                    <a href="{{ route('event-view') }}" wire:navigate class="btn-ghost">
                        Cancel
                    </a>
                    <button type="submit" wire:loading.attr="disabled" class="btn-primary">
                        <span wire:loading.remove wire:target="update">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/>
                            </svg>
                            Save Changes
                        </span>
                        <span wire:loading wire:target="update">Saving...</span>
                    </button>
                </div>

            </form>
        </div>

        {{-- ── RIGHT: Schedule + Items ── --}}
        <div class="space-y-5">

            {{-- Program Schedule --}}
            <div class="ee-card">
                <div class="ee-card-header">
                    <div class="ee-card-header-left">
                        <div class="ee-card-icon">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="ee-card-title">Program Schedule</p>
                            <p class="ee-card-sub">{{ count($scheduleRows) }} item{{ count($scheduleRows) !== 1 ? 's' : '' }}</p>
                        </div>
                    </div>
                    <button type="button" wire:click="addScheduleRow" class="btn-add">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                        </svg>
                        Add Item
                    </button>
                </div>

                <div class="ee-card-body">
                    @forelse($scheduleRows as $index => $row)
                        <div class="timeline-item mb-5" wire:key="sched-{{ $index }}">
                            <div class="timeline-dot"><div class="timeline-dot-inner"></div></div>

                            <div class="rounded-xl p-3.5" style="border:1px solid #e2e8f0;background:#fff;">
                                <div class="mb-3 flex items-center justify-between gap-2">
                                    <span class="status-chip chip-blue" style="font-size:.62rem;">
                                        Item {{ $index + 1 }}
                                    </span>
                                    <button type="button"
                                            wire:click="removeScheduleRow({{ $index }})"
                                            class="btn-remove">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/>
                                        </svg>
                                        Remove
                                    </button>
                                </div>

                                <div class="grid grid-cols-2 gap-3 mb-3">
                                    <div>
                                        <label class="ee-label">Time</label>
                                        <input type="time"
                                               wire:model.defer="scheduleRows.{{ $index }}.schedule_time"
                                               class="ee-field" />
                                    </div>
                                    <div>
                                        <label class="ee-label">Order</label>
                                        <input type="number" min="0"
                                               wire:model.defer="scheduleRows.{{ $index }}.sort_order"
                                               class="ee-field" />
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="ee-label">Title</label>
                                    <input type="text"
                                           wire:model.defer="scheduleRows.{{ $index }}.title"
                                           placeholder="e.g. Gala Dinner"
                                           class="ee-field" />
                                </div>

                                <div>
                                    <label class="ee-label">Notes <span style="color:#94a3b8;font-weight:500;text-transform:none;letter-spacing:0;">(optional)</span></label>
                                    <textarea rows="2"
                                              wire:model.defer="scheduleRows.{{ $index }}.description"
                                              placeholder="Optional notes..."
                                              class="ee-field" style="resize:none;"></textarea>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="rounded-xl px-5 py-10 text-center"
                             style="border:2px dashed #e2e8f0;">
                            <svg class="mx-auto h-8 w-8 mb-2" style="color:#cbd5e1;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                            </svg>
                            <p class="text-sm font-semibold text-slate-600">No schedule items yet</p>
                            <p class="mt-0.5 text-xs text-slate-400">
                                Add the event timeline — registration, dinner, closing remarks.
                            </p>
                            <button type="button" wire:click="addScheduleRow"
                                    class="mt-3 btn-add" style="margin:auto;margin-top:.75rem;">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                                </svg>
                                Add First Item
                            </button>
                        </div>
                    @endforelse
                </div>

                @if(count($scheduleRows) > 0)
                    <div class="flex justify-end px-5 py-3.5" style="border-top:1px solid #f1f5f9;">
                        <button type="button" wire:click="saveSchedules" class="btn-save-section">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/>
                            </svg>
                            Save Schedule
                        </button>
                    </div>
                @endif
            </div>

            {{-- Registration Items --}}
            <div class="ee-card">
                <div class="ee-card-header">
                    <div class="ee-card-header-left">
                        <div class="ee-card-icon gold">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 0 0 3 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 0 0 5.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 0 0 9.568 3Z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6Z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="ee-card-title">Registration Items</p>
                            <p class="ee-card-sub">{{ count($itemRows) }} item{{ count($itemRows) !== 1 ? 's' : '' }} &bull; Paid add-ons</p>
                        </div>
                    </div>
                    <button type="button" wire:click="addItemRow" class="btn-add">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                        </svg>
                        Add Item
                    </button>
                </div>

                <div class="ee-card-body space-y-3">
                    @forelse($itemRows as $index => $item)
                        <div class="item-card" wire:key="item-{{ $index }}">
                            <div class="flex items-center justify-between gap-2 px-3.5 py-2.5"
                                 style="border-bottom:1px solid #e2e8f0;background:#fff;">
                                <div class="flex items-center gap-2">
                                    <div class="item-card-num">{{ $index + 1 }}</div>
                                    <span class="text-xs font-semibold text-slate-600">
                                        {{ $item['name'] ?: 'Untitled Item' }}
                                    </span>
                                </div>
                                <button type="button"
                                        wire:click="removeItemRow({{ $index }})"
                                        class="btn-remove">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/>
                                    </svg>
                                    Remove
                                </button>
                            </div>

                            <div class="grid grid-cols-1 gap-3 p-3.5 sm:grid-cols-2">
                                <div class="sm:col-span-2">
                                    <label class="ee-label">Item Name</label>
                                    <input type="text"
                                           wire:model.defer="itemRows.{{ $index }}.name"
                                           placeholder="e.g. Gala Dinner Ticket"
                                           class="ee-field" />
                                </div>

                                <div>
                                    <label class="ee-label">Price (₱)</label>
                                    <input type="number" min="0" step="1"
                                           wire:model.defer="itemRows.{{ $index }}.price"
                                           placeholder="0"
                                           class="ee-field" />
                                </div>

                                <div>
                                    <label class="ee-label">Linked Schedule</label>
                                    <select wire:model.defer="itemRows.{{ $index }}.event_schedule_id"
                                            class="ee-field" style="appearance:none;
                                            background-image:url(\"data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%2394a3b8' stroke-width='2'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' d='M19 9l-7 7-7-7'/%3E%3C/svg%3E\");
                                            background-repeat:no-repeat;background-position:right .7rem center;background-size:.9rem;
                                            padding-right:2.2rem;cursor:pointer;">
                                        <option value="">No schedule linked</option>
                                        @foreach($scheduleRows as $schedule)
                                            <option value="{{ $schedule['id'] }}">
                                                {{ $schedule['title'] ?: 'Untitled Schedule' }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="rounded-xl px-5 py-10 text-center"
                             style="border:2px dashed #e2e8f0;">
                            <svg class="mx-auto h-8 w-8 mb-2" style="color:#cbd5e1;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 0 0 3 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 0 0 5.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 0 0 9.568 3Z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6Z"/>
                            </svg>
                            <p class="text-sm font-semibold text-slate-600">No registration items yet</p>
                            <p class="mt-0.5 text-xs text-slate-400">
                                Add payable items like dinner tickets, shirts, or other event add-ons.
                            </p>
                            <button type="button" wire:click="addItemRow"
                                    class="btn-add" style="margin:auto;margin-top:.75rem;">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                                </svg>
                                Add First Item
                            </button>
                        </div>
                    @endforelse
                </div>

                @if(count($itemRows) > 0)
                    <div class="flex justify-end px-5 py-3.5" style="border-top:1px solid #f1f5f9;">
                        <button type="button" wire:click="saveItems" class="btn-save-section">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/>
                            </svg>
                            Save Items
                        </button>
                    </div>
                @endif
            </div>

        </div>
    </div>
</div>
</div>
