{{--
    Shared toast partial.
    Handles session keys: success, status, error, deleted.
    Green for success/status, red for error/deleted.
    Usage: @include('partials.toast')
--}}
@php
    $toastMessage = session('success') ?? session('status') ?? null;
    $toastError   = session('error')   ?? session('deleted') ?? null;
@endphp

@if ($toastMessage)
    <div
        x-data="{ show: true, progress: 100 }"
        x-init="
            let start = null;
            const dur = 4000;
            const tick = (ts) => {
                if (!start) start = ts;
                progress = Math.max(0, 100 - ((ts - start) / dur) * 100);
                if (ts - start < dur) requestAnimationFrame(tick);
                else show = false;
            };
            requestAnimationFrame(tick);
        "
        x-show="show"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-3 scale-95"
        x-transition:enter-end="opacity-100 translate-y-0 scale-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0 scale-100"
        x-transition:leave-end="opacity-0 translate-y-3 scale-95"
        class="fixed right-5 top-5 z-[9999] w-full max-w-sm overflow-hidden"
        style="border-radius:1rem;background:#d1fae5;border:1px solid #a7f3d0;
               box-shadow:0 8px 30px rgba(5,150,105,.18),0 2px 8px rgba(5,150,105,.1);"
    >
        <div style="display:flex;align-items:flex-start;gap:.875rem;padding:.875rem 1rem;">
            <div style="width:2.25rem;height:2.25rem;border-radius:50%;flex-shrink:0;
                         background:#059669;display:flex;align-items:center;justify-content:center;
                         box-shadow:0 2px 8px rgba(5,150,105,.35);">
                <svg style="width:1.1rem;height:1.1rem;color:#fff;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/>
                </svg>
            </div>
            <div style="flex:1;min-width:0;">
                <p style="font-size:.875rem;font-weight:700;color:#064e3b;line-height:1.3;">Success</p>
                <p style="font-size:.8125rem;color:#065f46;margin-top:.2rem;line-height:1.45;opacity:.85;">{{ $toastMessage }}</p>
            </div>
            <button @click="show = false"
                    style="flex-shrink:0;width:1.5rem;height:1.5rem;border-radius:.375rem;
                           background:transparent;border:none;cursor:pointer;
                           display:flex;align-items:center;justify-content:center;
                           color:#065f46;opacity:.6;transition:opacity .15s;"
                    onmouseover="this.style.opacity='1'" onmouseout="this.style.opacity='.6'">
                <svg style="width:.75rem;height:.75rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        <div style="height:3px;background:rgba(5,150,105,.2);">
            <div style="height:100%;background:#059669;border-radius:999px;transition:width .1s linear;"
                 :style="`width:${progress}%`"></div>
        </div>
    </div>
@endif

@if ($toastError)
    <div
        x-data="{ show: true, progress: 100 }"
        x-init="
            let start = null;
            const dur = 4000;
            const tick = (ts) => {
                if (!start) start = ts;
                progress = Math.max(0, 100 - ((ts - start) / dur) * 100);
                if (ts - start < dur) requestAnimationFrame(tick);
                else show = false;
            };
            requestAnimationFrame(tick);
        "
        x-show="show"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-3 scale-95"
        x-transition:enter-end="opacity-100 translate-y-0 scale-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0 scale-100"
        x-transition:leave-end="opacity-0 translate-y-3 scale-95"
        class="fixed right-5 top-5 z-[9999] w-full max-w-sm overflow-hidden"
        style="border-radius:1rem;background:#fee2e2;border:1px solid #fca5a5;
               box-shadow:0 8px 30px rgba(220,38,38,.15),0 2px 8px rgba(220,38,38,.08);"
    >
        <div style="display:flex;align-items:flex-start;gap:.875rem;padding:.875rem 1rem;">
            <div style="width:2.25rem;height:2.25rem;border-radius:50%;flex-shrink:0;
                         background:#dc2626;display:flex;align-items:center;justify-content:center;
                         box-shadow:0 2px 8px rgba(220,38,38,.3);">
                <svg style="width:1.1rem;height:1.1rem;color:#fff;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/>
                </svg>
            </div>
            <div style="flex:1;min-width:0;">
                <p style="font-size:.875rem;font-weight:700;color:#7f1d1d;line-height:1.3;">Error</p>
                <p style="font-size:.8125rem;color:#991b1b;margin-top:.2rem;line-height:1.45;opacity:.85;">{{ $toastError }}</p>
            </div>
            <button @click="show = false"
                    style="flex-shrink:0;width:1.5rem;height:1.5rem;border-radius:.375rem;
                           background:transparent;border:none;cursor:pointer;
                           display:flex;align-items:center;justify-content:center;
                           color:#991b1b;opacity:.6;transition:opacity .15s;"
                    onmouseover="this.style.opacity='1'" onmouseout="this.style.opacity='.6'">
                <svg style="width:.75rem;height:.75rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        <div style="height:3px;background:rgba(220,38,38,.2);">
            <div style="height:100%;background:#dc2626;border-radius:999px;transition:width .1s linear;"
                 :style="`width:${progress}%`"></div>
        </div>
    </div>
@endif
