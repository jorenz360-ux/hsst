<x-layouts.auth title="Sign up">
    <div
        x-data="{
            step: 1,
            totalSteps: 3,

            validateStep(stepNumber) {
                const section = this.$root.querySelector(`[data-step='${stepNumber}']`);
                if (!section) return true;

                const fields = section.querySelectorAll('input, select, textarea');
                for (const field of fields) {
                    if (!field.checkValidity()) {
                        field.reportValidity();
                        field.focus();
                        return false;
                    }
                }
                return true;
            },

            nextStep() {
                if (this.validateStep(this.step) && this.step < this.totalSteps) {
                    this.step++;
                }
            },

            prevStep() {
                if (this.step > 1) {
                    this.step--;
                }
            }
        }"
        class="flex flex-col gap-6"
    >
        <x-auth-header
            :title="__('Create an account')"
            :description="__('Complete the steps below to create your alumni account.')"
        />

        <x-auth-session-status class="text-center" :status="session('status')" />

        {{-- Stepper Header --}}
        <div class="rounded-2xl border border-zinc-200 bg-white/80 p-4 shadow-sm dark:border-zinc-700 dark:bg-zinc-900/80">
            <div class="flex items-center justify-between gap-2">
                {{-- Step 1 --}}
                <div class="flex flex-1 items-center gap-3">
                    <div
                        class="flex h-10 w-10 items-center justify-center rounded-full text-sm font-semibold transition"
                        :class="step >= 1
                            ? 'bg-teal-500 text-white'
                            : 'bg-zinc-200 text-zinc-600 dark:bg-zinc-800 dark:text-zinc-400'"
                    >
                        1
                    </div>
                    <div class="min-w-0">
                        <p class="text-sm font-semibold text-zinc-900 dark:text-zinc-100">Account</p>
                        <p class="text-xs text-zinc-500 dark:text-zinc-400">Basic login details</p>
                    </div>
                </div>

                <div class="hidden h-px flex-1 bg-zinc-200 dark:bg-zinc-700 md:block"></div>

                {{-- Step 2 --}}
                <div class="flex flex-1 items-center gap-3">
                    <div
                        class="flex h-10 w-10 items-center justify-center rounded-full text-sm font-semibold transition"
                        :class="step >= 2
                            ? 'bg-teal-500 text-white'
                            : 'bg-zinc-200 text-zinc-600 dark:bg-zinc-800 dark:text-zinc-400'"
                    >
                        2
                    </div>
                    <div class="min-w-0">
                        <p class="text-sm font-semibold text-zinc-900 dark:text-zinc-100">Alumni Info</p>
                        <p class="text-xs text-zinc-500 dark:text-zinc-400">Personal details</p>
                    </div>
                </div>

                <div class="hidden h-px flex-1 bg-zinc-200 dark:bg-zinc-700 md:block"></div>

                {{-- Step 3 --}}
                <div class="flex flex-1 items-center gap-3">
                    <div
                        class="flex h-10 w-10 items-center justify-center rounded-full text-sm font-semibold transition"
                        :class="step >= 3
                            ? 'bg-teal-500 text-white'
                            : 'bg-zinc-200 text-zinc-600 dark:bg-zinc-800 dark:text-zinc-400'"
                    >
                        3
                    </div>
                    <div class="min-w-0">
                        <p class="text-sm font-semibold text-zinc-900 dark:text-zinc-100">Security</p>
                        <p class="text-xs text-zinc-500 dark:text-zinc-400">Password and finish</p>
                    </div>
                </div>
            </div>

            {{-- Progress Bar --}}
            <div class="mt-4 h-2 overflow-hidden rounded-full bg-zinc-200 dark:bg-zinc-800">
                <div
                    class="h-full rounded-full bg-teal-500 transition-all duration-300"
                    :style="`width: ${(step / totalSteps) * 100}%`"
                ></div>
            </div>
        </div>

        {{-- novalidate is important so hidden required fields do not block submit --}}
        <form method="POST" action="{{ route('register.store') }}" class="flex flex-col gap-6" novalidate>
            @csrf

            {{-- debug marker --}}
            <input type="hidden" name="_debug_register" value="1">

            <div class="rounded-2xl border border-zinc-200 bg-white/80 p-5 shadow-sm dark:border-zinc-700 dark:bg-zinc-900/80">
                {{-- STEP 1 --}}
                <div x-show="step === 1" x-transition.opacity.duration.200ms class="space-y-5" data-step="1">
                    <div>
                        <h2 class="text-lg font-semibold text-zinc-900 dark:text-zinc-100">Account Setup</h2>
                        <p class="mt-1 text-sm text-zinc-600 dark:text-zinc-400">
                            Start by choosing your login credentials.
                        </p>
                    </div>

                    <flux:input
                        name="username"
                        :label="__('Username')"
                        :value="old('username')"
                        type="text"
                        autocomplete="username"
                        :placeholder="__('Username')"
                        required
                    />

                    <flux:input
                        name="email"
                        :label="__('Email address')"
                        :value="old('email')"
                        type="email"
                        autocomplete="email"
                        placeholder="email@example.com"
                        required
                    />
                </div>

                {{-- STEP 2 --}}
                <div x-show="step === 2" x-transition.opacity.duration.200ms class="space-y-5" data-step="2">
                    <div>
                        <h2 class="text-lg font-semibold text-zinc-900 dark:text-zinc-100">Alumni Information</h2>
                        <p class="mt-1 text-sm text-zinc-600 dark:text-zinc-400">
                            Provide your basic alumni details.
                        </p>
                    </div>

                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                        <flux:input
                            name="fname"
                            :label="__('First name')"
                            :value="old('fname')"
                            type="text"
                            autocomplete="given-name"
                            :placeholder="__('First name')"
                            required
                        />

                        <flux:input
                            name="lname"
                            :label="__('Last name')"
                            :value="old('lname')"
                            type="text"
                            autocomplete="family-name"
                            :placeholder="__('Last name')"
                            required
                        />
                    </div>

                    <flux:input
                        name="mname"
                        :label="__('Middle name')"
                        :value="old('mname')"
                        type="text"
                        autocomplete="additional-name"
                        :placeholder="__('Middle name (optional)')"
                    />

                    <flux:input
                        name="yeargrad"
                        :label="__('Year Graduated')"
                        :value="old('yeargrad')"
                        type="number"
                        min="1900"
                        max="{{ now()->year }}"
                        :placeholder="__('e.g. 2015')"
                        required
                    />
                </div>

                {{-- STEP 3 --}}
                <div x-show="step === 3" x-transition.opacity.duration.200ms class="space-y-5" data-step="3">
                    <div>
                        <h2 class="text-lg font-semibold text-zinc-900 dark:text-zinc-100">Security & Confirmation</h2>
                        <p class="mt-1 text-sm text-zinc-600 dark:text-zinc-400">
                            Set your password and review your registration before submitting.
                        </p>
                    </div>

                    <flux:input
                        name="password"
                        :label="__('Password')"
                        type="password"
                        autocomplete="new-password"
                        :placeholder="__('Password')"
                        viewable
                        required
                    />

                    <flux:input
                        name="password_confirmation"
                        :label="__('Confirm password')"
                        type="password"
                        autocomplete="new-password"
                        :placeholder="__('Confirm password')"
                        viewable
                        required
                    />

                    <div class="rounded-xl border border-teal-200 bg-teal-50 p-4 text-sm text-teal-900 dark:border-teal-900/40 dark:bg-teal-950/20 dark:text-teal-200">
                        By creating an account, you confirm that the information you provided is accurate and belongs to you as an alumnus/alumna of Holy Spirit School of Tagbilaran.
                    </div>
                </div>
            </div>

            {{-- Stepper Actions --}}
            <div class="flex items-center justify-between gap-3">
                <button
                    type="button"
                    @click="prevStep()"
                    x-show="step > 1"
                    x-transition.opacity
                    class="inline-flex items-center rounded-xl border border-zinc-200 bg-white px-4 py-2 text-sm font-medium text-zinc-700 shadow-sm transition hover:bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900 dark:text-zinc-200 dark:hover:bg-zinc-800"
                >
                    Back
                </button>

                <div class="ml-auto flex items-center gap-3">
                    <button
                        type="button"
                        @click="nextStep()"
                        x-show="step < totalSteps"
                        x-transition.opacity
                        class="inline-flex items-center rounded-xl bg-teal-500 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-teal-600"
                    >
                        Next
                    </button>

                    <flux:button
                        type="submit"
                        variant="primary"
                        class="w-full md:w-auto"
                        x-show="step === totalSteps"
                        x-transition.opacity
                        data-test="register-user-button"
                    >
                        {{ __('Create account') }}
                    </flux:button>
                </div>
            </div>
        </form>

        <div class="space-x-1 rtl:space-x-reverse text-center text-sm text-zinc-600 dark:text-zinc-400">
            <span>{{ __('Already have an account?') }}</span>
            <flux:link :href="route('login')" wire:navigate>{{ __('Log in') }}</flux:link>
        </div>
    </div>
</x-layouts.auth>