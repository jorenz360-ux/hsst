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

    .ce-field {
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
    .ce-field::placeholder { color: #94a3b8; }
    .ce-field:hover  { border-color: #94a3b8; }
    .ce-field:focus  { border-color: var(--r6); box-shadow: 0 0 0 3px rgba(26,63,168,.1); }

    .ce-label {
        display: block;
        font-size: .65rem;
        font-weight: 700;
        letter-spacing: .1em;
        text-transform: uppercase;
        color: #64748b;
        margin-bottom: .35rem;
    }

    .ce-hint { font-size: .72rem; color: #94a3b8; margin-top: .3rem; }
    .ce-error { font-size: .75rem; color: #dc2626; margin-top: .3rem; }

    .ce-card {
        background: #fff;
        border-radius: 1.25rem;
        border: 1px solid #e2e8f0;
        box-shadow: 0 1px 6px rgba(15,23,42,.05);
        overflow: hidden;
    }
    .ce-card-header {
        padding: 1rem 1.25rem;
        border-bottom: 1px solid #f1f5f9;
        display: flex;
        align-items: center;
        gap: .6rem;
    }
    .ce-card-icon {
        width: 1.75rem; height: 1.75rem;
        border-radius: .5rem;
        display: flex; align-items: center; justify-content: center;
        background: #eef2ff;
        color: var(--r6);
        flex-shrink: 0;
    }
    .ce-card-title { font-size: .8rem; font-weight: 700; color: #1e293b; }
    .ce-card-sub   { font-size: .7rem; color: #94a3b8; margin-top: .1rem; }
    .ce-card-body  { padding: 1.25rem; }

    .btn-gold {
        display: inline-flex; align-items: center; justify-content: center; gap: .4rem;
        width: 100%; height: 2.625rem;
        border-radius: .75rem;
        background: linear-gradient(135deg, var(--g5) 0%, #a37522 100%);
        box-shadow: 0 4px 14px rgba(196,149,42,.3), inset 0 1px 0 rgba(255,255,255,.12);
        color: #fff; font-size: .8375rem; font-weight: 700;
        transition: filter .15s, transform .1s;
        cursor: pointer; border: none; font-family: inherit;
    }
    .btn-gold:hover  { filter: brightness(1.07); }
    .btn-gold:active { transform: translateY(1px); }
    .btn-gold:disabled { opacity: .6; cursor: not-allowed; }

    .btn-ghost-full {
        display: inline-flex; align-items: center; justify-content: center; gap: .4rem;
        width: 100%; height: 2.625rem;
        border-radius: .75rem;
        background: #fff; border: 1px solid #e2e8f0;
        color: #475569; font-size: .8375rem; font-weight: 600;
        transition: background .12s, border-color .12s, color .12s;
        cursor: pointer; font-family: inherit;
    }
    .btn-ghost-full:hover { background: #f8fafc; border-color: #cbd5e1; color: #1e293b; }

    .ce-upload-zone {
        border: 2px dashed #e2e8f0;
        border-radius: 1rem;
        padding: 1.75rem 1.25rem;
        text-align: center;
        cursor: pointer;
        transition: border-color .15s, background .15s;
        background: #f8fafc;
    }
    .ce-upload-zone:hover { border-color: var(--r5); background: #f0f4fb; }

    .ce-toggle {
        position: relative;
        display: inline-flex;
        align-items: center;
        cursor: pointer;
        user-select: none;
        gap: .6rem;
    }
    .ce-toggle input[type=checkbox] { display: none; }
    .ce-toggle-track {
        width: 2.5rem; height: 1.375rem;
        border-radius: 999px;
        background: #e2e8f0;
        transition: background .2s;
        position: relative; flex-shrink: 0;
    }
    .ce-toggle input:checked ~ .ce-toggle-track { background: var(--r6); }
    .ce-toggle-thumb {
        position: absolute;
        top: .1875rem; left: .1875rem;
        width: 1rem; height: 1rem;
        border-radius: 50%;
        background: #fff;
        box-shadow: 0 1px 3px rgba(0,0,0,.2);
        transition: left .2s;
    }
    .ce-toggle input:checked ~ .ce-toggle-track .ce-toggle-thumb { left: 1.3125rem; }

    .sum-chip {
        display: inline-flex; align-items: center; gap: .5rem;
        padding: .35rem .85rem;
        border-radius: 999px;
        font-size: .7rem; font-weight: 700;
        white-space: nowrap;
    }
</style>

<div class="space-y-5 px-4 py-6 sm:px-6 lg:px-8 mx-auto max-w-screen-xl">

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
                CREATE EVENT
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
                        Create Event
                    </h1>
                    <p class="mt-1.5 text-sm leading-6" style="color:rgba(255,255,255,.6);max-width:46ch;">
                        Add a new reunion event for alumni registration and payment.
                    </p> 
                </div>

                <div class="flex items-center gap-2 sm:mt-1 sm:shrink-0">
                    <a href="{{ route('event-view') }}" wire:navigate
                       style="display:inline-flex;align-items:center;gap:.4rem;height:2.375rem;padding:0 .875rem;
                              border-radius:.75rem;background:rgba(255,255,255,.12);border:1px solid rgba(255,255,255,.2);
                              color:#fff;font-size:.8rem;font-weight:600;text-decoration:none;
                              transition:background .15s;">
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
                <span class="sum-chip" style="background:rgba(255,255,255,.14);color:#fff;border:1px solid rgba(255,255,255,.18);">
                    <svg class="w-3.5 h-3.5 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                    </svg>
                    New Event
                </span>
                <span class="sum-chip" style="background:rgba(196,149,42,.14);color:var(--g4);border:1px solid rgba(196,149,42,.22);">
                    Fill in all required fields before saving.
                </span>
            </div>
        </div>
    </section>

    {{-- Flash messages --}}
    @if (session()->has('success'))
        <div class="flex items-center gap-3 rounded-xl px-4 py-3"
             style="background:#ecfdf5;border:1px solid #a7f3d0;">
            <svg class="w-4 h-4 shrink-0" style="color:#065f46;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
            </svg>
            <p class="text-sm font-medium" style="color:#065f46;">{{ session('success') }}</p>
        </div>
    @endif
    @if (session()->has('error'))
        <div class="flex items-center gap-3 rounded-xl px-4 py-3"
             style="background:#fef2f2;border:1px solid #fecaca;">
            <svg class="w-4 h-4 shrink-0" style="color:#dc2626;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z"/>
            </svg>
            <p class="text-sm font-medium" style="color:#991b1b;">{{ session('error') }}</p>
        </div>
    @endif
    @if (session('status'))
        <div class="flex items-center gap-3 rounded-xl px-4 py-3"
             style="background:#ecfdf5;border:1px solid #a7f3d0;">
            <svg class="w-4 h-4 shrink-0" style="color:#065f46;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
            </svg>
            <p class="text-sm font-medium" style="color:#065f46;">{{ session('status') }}</p>
        </div>
    @endif

    {{-- ════════════════════════════════════════════════════════════
         FORM
    ════════════════════════════════════════════════════════════ --}}
    <form wire:submit.prevent="save" class="grid grid-cols-1 gap-5 xl:grid-cols-12">

        {{-- LEFT: Main fields --}}
        <div class="space-y-5 xl:col-span-8">

            {{-- Event Details --}}
            <div class="ce-card">
                <div class="ce-card-header">
                    <div class="ce-card-icon">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5"/>
                        </svg>
                    </div>
                    <div>
                        <p class="ce-card-title">Event Details</p>
                        <p class="ce-card-sub">Basic information about the event</p>
                    </div>
                </div>
                <div class="ce-card-body">
                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">

                        {{-- Title --}}
                        <div class="md:col-span-2">
                            <label class="ce-label">Title <span style="color:#dc2626;">*</span></label>
                            <input
                                type="text"
                                wire:model.defer="title"
                                placeholder="e.g., Alumni Grand Reunion 2026"
                                class="ce-field"
                            />
                            @error('title') <p class="ce-error">{{ $message }}</p> @enderror
                        </div>

                        {{-- Venue --}}
                        <div>
                            <label class="ce-label">Venue <span style="color:#dc2626;">*</span></label>
                            <input
                                type="text"
                                wire:model.defer="venue"
                                placeholder="e.g., School Gymnasium"
                                class="ce-field"
                            />
                            @error('venue') <p class="ce-error">{{ $message }}</p> @enderror
                        </div>

                        {{-- Dress Code --}}
                        <div>
                            <label class="ce-label">Dress Code</label>
                            <input
                                type="text"
                                wire:model.defer="dress_code"
                                placeholder="e.g., Formal or Semi-Formal"
                                class="ce-field"
                            />
                            @error('dress_code') <p class="ce-error">{{ $message }}</p> @enderror
                        </div>

                        {{-- Event Date --}}
                        <div>
                            <label class="ce-label">Event Date & Time <span style="color:#dc2626;">*</span></label>
                            <input
                                type="datetime-local"
                                wire:model.defer="event_date"
                                class="ce-field"
                            />
                            <p class="ce-hint">Use your local time.</p>
                            @error('event_date') <p class="ce-error">{{ $message }}</p> @enderror
                        </div>

                        {{-- Registration Fee --}}
                        <div>
                            <label class="ce-label">Registration Fee (₱) <span style="color:#dc2626;">*</span></label>
                            <input
                                type="number"
                                min="0"
                                step="1"
                                wire:model.defer="registration_fee"
                                placeholder="e.g., 300"
                                class="ce-field"
                            />
                            <p class="ce-hint">Amount in pesos.</p>
                            @error('registration_fee') <p class="ce-error">{{ $message }}</p> @enderror
                        </div>

                    </div>
                </div>
            </div>

            {{-- Description --}}
            <div class="ce-card">
                <div class="ce-card-header">
                    <div class="ce-card-icon">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25H12"/>
                        </svg>
                    </div>
                    <div>
                        <p class="ce-card-title">Additional Details</p>
                        <p class="ce-card-sub">Program info, reminders, and notes for alumni</p>
                    </div>
                </div>
                <div class="ce-card-body">
                    <label class="ce-label">Description</label>
                    <textarea
                        wire:model.defer="description"
                        rows="7"
                        placeholder="Include program details, reminders, registration instructions, payment notes, and other important information."
                        class="ce-field"
                        style="resize:vertical;"
                    ></textarea>
                    @error('description') <p class="ce-error">{{ $message }}</p> @enderror
                </div>
            </div>

        </div>

        {{-- RIGHT: Utility panel --}}
        <div class="space-y-5 xl:col-span-4">

            {{-- Banner Upload --}}
            <div class="ce-card">
                <div class="ce-card-header">
                    <div class="ce-card-icon">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="ce-card-title">Event Banner</p>
                        <p class="ce-card-sub">JPG, PNG, WEBP &bull; Max 2MB</p>
                    </div>
                </div>
                <div class="ce-card-body space-y-3">
                    <input
                        type="file"
                        wire:model="banner"
                        accept="image/*"
                        class="hidden"
                        id="bannerUpload"
                    />

                    @if ($banner)
                        <div class="relative overflow-hidden rounded-xl" style="border:1px solid #e2e8f0;">
                            <img
                                src="{{ $banner->temporaryUrl() }}"
                                class="h-48 w-full object-cover"
                            />
                            <button
                                type="button"
                                onclick="document.getElementById('bannerUpload').click()"
                                style="position:absolute;top:.625rem;right:.625rem;
                                       background:rgba(15,23,42,.75);color:#fff;
                                       border:none;border-radius:.5rem;
                                       padding:.25rem .75rem;font-size:.72rem;font-weight:600;
                                       cursor:pointer;backdrop-filter:blur(4px);"
                            >
                                Replace
                            </button>
                        </div>
                    @else
                        <label for="bannerUpload" class="ce-upload-zone block">
                            <svg class="mx-auto h-8 w-8 mb-2" style="color:#cbd5e1;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5m-13.5-9L12 3m0 0 4.5 4.5M12 3v13.5"/>
                            </svg>
                            <p class="text-sm font-semibold" style="color:#475569;">Click to upload banner</p>
                            <p class="text-xs mt-0.5" style="color:#94a3b8;">Poster or event cover image</p>
                        </label>
                    @endif

                    <div wire:loading wire:target="banner"
                         class="text-xs font-medium" style="color:var(--r6);">
                        Uploading image...
                    </div>

                    @error('banner') <p class="ce-error">{{ $message }}</p> @enderror
                </div>
            </div>

            {{-- Visibility --}}
            <div class="ce-card">
                <div class="ce-card-header">
                    <div class="ce-card-icon">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                        </svg>
                    </div>
                    <p class="ce-card-title">Visibility</p>
                </div>
                <div class="ce-card-body">
                    <label class="ce-toggle">
                        <input
                            type="checkbox"
                            wire:model.defer="is_active"
                            id="isActiveToggle"
                        />
                        <div class="ce-toggle-track">
                            <div class="ce-toggle-thumb"></div>
                        </div>
                        <span class="text-sm font-semibold text-slate-700">Publish event</span>
                    </label>
                    <p class="mt-2 text-xs text-slate-400">
                        When enabled, alumni can see and register for this event.
                    </p>
                    @error('is_active') <p class="ce-error">{{ $message }}</p> @enderror
                </div>
            </div>

            {{-- Actions --}}
            <div class="ce-card">
                <div class="ce-card-header">
                    <div class="ce-card-icon">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                        </svg>
                    </div>
                    <p class="ce-card-title">Actions</p>
                </div>
                <div class="ce-card-body space-y-2.5">
                    <button type="submit" wire:loading.attr="disabled" class="btn-gold">
                        <span wire:loading.remove wire:target="save">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                            </svg>
                            Save Event
                        </span>
                        <span wire:loading wire:target="save">Saving...</span>
                    </button>

                    <button
                        type="button"
                        wire:click="resetForm"
                        wire:loading.attr="disabled"
                        class="btn-ghost-full"
                    >
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99"/>
                        </svg>
                        Reset Form
                    </button>
                </div>
            </div>

        </div>
    </form>

</div>
</div>
