<x-layouts.full-page :title="__('Registration Pending')">
<style>
    :root {
        --royal-900: #0a1f5c;
        --royal-800: #0f2a7a;
        --royal-700: #153591;
        --gold-500:  #c4952a;
        --gold-400:  #d4a843;
    }
    body { font-family: "DM Sans", system-ui, sans-serif; }
    .font-display { font-family: "DM Serif Display", Georgia, serif; }
</style>

<div class="min-h-screen flex items-center justify-center px-5 py-16"
     style="background: linear-gradient(160deg, var(--royal-700) 0%, var(--royal-900) 100%);">

    <div class="pointer-events-none fixed inset-0" aria-hidden="true">
        <div class="absolute top-0 right-0 w-96 h-96 rounded-full opacity-10"
             style="background: radial-gradient(circle, rgba(255,255,255,0.3) 0%, transparent 70%); transform: translate(30%,-30%);"></div>
        <div class="absolute bottom-0 left-0 w-[32rem] h-[32rem] rounded-full opacity-10"
             style="background: radial-gradient(circle, rgba(196,149,42,0.3) 0%, transparent 70%); transform: translate(-40%,40%);"></div>
        <div class="absolute inset-0 opacity-[0.03]"
             style="background-image: repeating-linear-gradient(45deg,#fff 0,#fff 1px,transparent 0,transparent 50%); background-size:14px 14px;"></div>
    </div>

    <div class="relative w-full max-w-md text-center">

        <div class="flex justify-center mb-7">
            <div class="h-16 w-16 rounded-2xl overflow-hidden border-2 shadow-xl"
                 style="border-color: rgba(196,149,42,0.5); box-shadow: 0 6px 24px rgba(0,0,0,0.35);">
                <img src="{{ asset('images/hsstlogo.jpg') }}" alt="HSST Logo" class="h-full w-full object-contain bg-white">
            </div>
        </div>

        <div class="flex justify-center mb-6">
            <div class="flex items-center justify-center"
                 style="width:4rem;height:4rem;border-radius:50%;flex-shrink:0;background:rgba(196,149,42,0.18);border:2px solid rgba(196,149,42,0.4);">
                <svg class="w-8 h-8" style="color: var(--gold-400);" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/>
                </svg>
            </div>
        </div>

        <div class="mb-1.5 w-10 h-0.5 mx-auto rounded-full" style="background: var(--gold-500);"></div>
        <h1 class="font-display text-white leading-tight tracking-[-0.02em] mt-4 mb-4"
            style="font-size: clamp(1.8rem, 5vw, 2.4rem);">
            Registration Submitted
        </h1>

        <p class="text-sm leading-7 mb-8" style="color: rgba(255,255,255,0.72); max-width: 34ch; margin-left: auto; margin-right: auto;">
            Your registration is pending approval by the reunion coordinator.
            You will receive an email once your account has been reviewed.
        </p>

        <div class="h-px w-16 mx-auto mb-8" style="background: rgba(196,149,42,0.4);"></div>

        <a href="{{ route('login') }}"
           class="inline-flex items-center gap-2 rounded-2xl px-6 h-11 text-sm font-bold transition"
           style="background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2); color: white;">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 18l-6-6 6-6"/>
            </svg>
            Back to Sign In
        </a>

        <p class="mt-8 text-xs" style="color: rgba(255,255,255,0.35);">
            &copy; {{ date('Y') }} Holy Spirit School of Tagbilaran &mdash; Alumni Portal
        </p>

    </div>
</div>
</x-layouts.full-page>
