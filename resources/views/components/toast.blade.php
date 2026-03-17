<div
    x-data="{ show: true }"
    x-init="setTimeout(() => show = false, 3500)"
    x-show="show"
    x-transition:enter="transform ease-out duration-300"
    x-transition:enter-start="translate-y-2 opacity-0"
    x-transition:enter-end="translate-y-0 opacity-100"
    x-transition:leave="transform ease-in duration-200"
    x-transition:leave-start="translate-y-0 opacity-100"
    x-transition:leave-end="translate-y-2 opacity-0"
    class="relative overflow-hidden rounded-2xl border border-emerald-300/30 bg-emerald-900 p-4 shadow-[0_16px_50px_rgba(0,0,0,0.35)] backdrop-blur-md"
>
    <div class="pointer-events-none absolute inset-0 bg-gradient-to-r from-emerald-500/10 via-transparent to-transparent"></div>

    <div class="relative flex items-start gap-3">
        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl border border-emerald-200/30 bg-emerald-300/15 text-emerald-100">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M16.704 5.29a1 1 0 010 1.414l-7.2 7.2a1 1 0 01-1.414 0l-3-3a1 1 0 111.414-1.414l2.293 2.293 6.493-6.493a1 1 0 011.414 0z" clip-rule="evenodd"/>
            </svg>
        </div>

        <div class="min-w-0 flex-1">
            <p class="text-[11px] font-semibold uppercase tracking-[0.16em] text-emerald-100/90">
                Success
            </p>
            <p class="mt-1 text-sm leading-[1.7] text-white">
                {{ session('status') }}
            </p>
        </div>

        <button
            type="button"
            @click="show = false"
            class="inline-flex h-8 w-8 items-center justify-center rounded-lg border border-white/15 bg-white/5 text-emerald-50/70 transition hover:bg-white/10 hover:text-white"
            aria-label="Close notification"
        >
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
            </svg>
        </button>
    </div>

    <div class="absolute inset-x-0 bottom-0 h-[3px] bg-white/10">
        <div
            class="h-full origin-left bg-emerald-200/90"
            style="animation: toast-shrink 3.5s linear forwards;"
        ></div>
    </div>
</div>