<?php

use Livewire\Volt\Component;
use App\Models\PasswordResetRequest;

new class extends Component {
    public bool $requestSent = false;

    public function notifyAdmin(): void
    {
        $user = auth()->user();

        if (! $user) {
            session()->flash('status', 'You must be logged in to submit a password reset request.');
            return;
        }

        $existingPending = PasswordResetRequest::query()
            ->where('user_id', $user->id)
            ->whereIn('status', ['pending', 'processing'])
            ->exists();

        if ($existingPending) {
            session()->flash('status', 'You already have an active password reset request. Please wait for admin assistance.');
            return;
        }

        $fullName = null;

        if ($user->alumni) {
            $fullName = trim(
                collect([
                    $user->alumni->fname,
                    $user->alumni->mname,
                    $user->alumni->lname,
                ])->filter()->implode(' ')
            );
        }

        PasswordResetRequest::create([
            'user_id' => $user->id,
            'username' => $user->username,
            'email' => $user->email,
            'full_name' => $fullName,
            'status' => 'pending',
            'requested_at' => now(),
        ]);

        $this->requestSent = true;

        session()->flash('status', 'Your password reset request has been submitted. Please wait for admin assistance.');
    }
};
?>

<section class="min-h-screen w-full bg-slate-50 px-4 py-8 sm:px-6 lg:px-8">
    <div class="mx-auto max-w-5xl">
        <div class="mb-8">
            <p class="mb-2 text-xs font-semibold uppercase tracking-[0.2em] text-blue-600">Account Support</p>
            <h1 class="text-3xl font-bold tracking-tight text-slate-900 sm:text-4xl">
                Password Help
            </h1>
            <p class="mt-2 max-w-2xl text-sm text-slate-600 sm:text-base">
                Since email reset is not available yet, you can send a password reset request directly to the reunion administrator.
            </p>
        </div>

        <div class="grid gap-5 lg:grid-cols-2">
            <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                <div class="border-b border-slate-100 px-5 py-4 sm:px-6">
                    <div class="flex items-start gap-3">
                        <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-slate-100 text-slate-700">
                            <svg class="h-5 w-5" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.7">
                                <path d="M3 5h14v10H3z"/>
                                <path d="m4 6 6 5 6-5"/>
                            </svg>
                        </div>

                        <div>
                            <h2 class="text-base font-semibold text-slate-900">Email Reset</h2>
                            <p class="mt-1 text-sm text-slate-500">
                                This feature is not available yet.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="space-y-4 px-5 py-5 sm:px-6">
                    <p class="text-sm leading-6 text-slate-600">
                        Password reset through email will be added in a future update once mail integration is ready.
                    </p>

                    <button
                        type="button"
                        disabled
                        class="inline-flex w-full cursor-not-allowed items-center justify-center rounded-xl bg-slate-200 px-5 py-3 text-sm font-medium text-slate-500"
                    >
                        Coming Soon
                    </button>
                </div>
            </div>

            <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                <div class="border-b border-slate-100 px-5 py-4 sm:px-6">
                    <div class="flex items-start gap-3">
                        <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-blue-50 text-blue-700">
                            <svg class="h-5 w-5" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.7">
                                <circle cx="10" cy="7" r="3"/>
                                <path d="M4 17c0-3.314 2.686-6 6-6s6 2.686 6 6"/>
                            </svg>
                        </div>

                        <div>
                            <h2 class="text-base font-semibold text-slate-900">Notify Admin</h2>
                            <p class="mt-1 text-sm text-slate-500">
                                Request direct help from the reunion administrator.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="space-y-4 px-5 py-5 sm:px-6">
                    <p class="text-sm leading-6 text-slate-600">
                        Use this option if you forgot your password. The admin can manually reset it and provide you with a temporary password.
                    </p>

                    @if (session('status'))
                        <div class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3">
                            <p class="text-sm text-emerald-700">
                                {{ session('status') }}
                            </p>
                        </div>
                    @endif

                    <button
                        type="button"
                        wire:click="notifyAdmin"
                        class="inline-flex w-full items-center justify-center rounded-xl bg-blue-600 px-5 py-3 text-sm font-medium text-white transition hover:bg-blue-700"
                    >
                        Notify Admin for Password Reset
                    </button>
                </div>
            </div>
        </div>

        <div class="mt-6">
            <a
                href="{{ route('profile.edit') }}"
                wire:navigate
                class="inline-flex items-center gap-2 text-sm font-medium text-slate-700 hover:text-slate-900"
            >
                ← Back to Profile
            </a>
        </div>
    </div>
</section>