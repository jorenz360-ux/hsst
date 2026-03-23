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
        class="relative overflow-hidden border border-white/10 bg-[#111315] text-[#f5f1e8] shadow-[0_20px_60px_rgba(0,0,0,0.35)]"
    >
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,rgba(198,165,107,0.12),transparent_28%)]"></div>
        <div class="absolute inset-0 bg-[linear-gradient(180deg,rgba(255,255,255,0.02)_0%,rgba(255,255,255,0)_100%)]"></div>

        <div class="relative px-6 py-8 sm:px-8 sm:py-10">
            {{-- Logo / Brand --}}
            <div class="mb-8 flex flex-col items-center text-center">
                <div class="flex h-20 w-20 items-center justify-center overflow-hidden rounded-2xl border border-white/10 bg-white p-2 shadow-sm">
                    <img
                        src="{{ asset('images/hsstlogo.jpg') }}"
                        alt="HSST Logo"
                        class="h-full w-full object-contain"
                    >
                </div>

                <p class="mt-4 text-[11px] font-semibold uppercase tracking-[0.30em] text-[#c6a56b]">
                    Official Alumni Portal
                </p>

                <h1 class="mt-4 font-['DM_Serif_Display'] text-[2rem] leading-[1.02] tracking-[-0.02em] text-white sm:text-[2.4rem]">
                    Create an account
                </h1>

                <p class="mt-3 max-w-md text-sm leading-7 text-[#9e988c]">
                    Complete the steps below to create your Holy Spirit School of Tagbilaran alumni account.
                </p>
            </div>

            <x-auth-session-status
                class="mb-5 border border-[#c6a56b]/20 bg-[#c6a56b]/10 px-4 py-3 text-center text-sm text-[#d6d0c4]"
                :status="session('status')"
            />

            {{-- Stepper Header --}}
            <div class="mb-6 border border-white/10 bg-[#0b0b0c] p-4 sm:p-5">
                <div class="grid gap-4 md:grid-cols-3">
                    {{-- Step 1 --}}
                    <div class="flex items-center gap-3">
                        <div
                            class="flex h-10 w-10 items-center justify-center rounded-full border text-sm font-semibold transition"
                            :class="step >= 1
                                ? 'border-[#c6a56b] bg-[#c6a56b] text-black'
                                : 'border-white/15 bg-white/5 text-[#9e988c]'"
                        >
                            1
                        </div>
                        <div class="min-w-0">
                            <p class="text-sm font-semibold text-white">Account</p>
                            <p class="text-xs text-[#9e988c]">Basic login details</p>
                        </div>
                    </div>

                    {{-- Step 2 --}}
                    <div class="flex items-center gap-3">
                        <div
                            class="flex h-10 w-10 items-center justify-center rounded-full border text-sm font-semibold transition"
                            :class="step >= 2
                                ? 'border-[#c6a56b] bg-[#c6a56b] text-black'
                                : 'border-white/15 bg-white/5 text-[#9e988c]'"
                        >
                            2
                        </div>
                        <div class="min-w-0">
                            <p class="text-sm font-semibold text-white">Alumni Info</p>
                            <p class="text-xs text-[#9e988c]">Personal details</p>
                        </div>
                    </div>

                    {{-- Step 3 --}}
                    <div class="flex items-center gap-3">
                        <div
                            class="flex h-10 w-10 items-center justify-center rounded-full border text-sm font-semibold transition"
                            :class="step >= 3
                                ? 'border-[#c6a56b] bg-[#c6a56b] text-black'
                                : 'border-white/15 bg-white/5 text-[#9e988c]'"
                        >
                            3
                        </div>
                        <div class="min-w-0">
                            <p class="text-sm font-semibold text-white">Security</p>
                            <p class="text-xs text-[#9e988c]">Password and finish</p>
                        </div>
                    </div>
                </div>

                {{-- Progress Bar --}}
                <div class="mt-5 h-2 overflow-hidden rounded-full bg-white/10">
                    <div
                        class="h-full rounded-full bg-[#c6a56b] transition-all duration-300"
                        :style="`width: ${(step / totalSteps) * 100}%`"
                    ></div>
                </div>
            </div>

            <form method="POST" action="{{ route('register.store') }}" class="flex flex-col gap-6" novalidate>
                @csrf
                <input type="hidden" name="_debug_register" value="1">

                <div class="border border-white/10 bg-[#0b0b0c] p-5 sm:p-6">
                    {{-- STEP 1 --}}
                    <div x-show="step === 1" x-transition.opacity.duration.200ms class="space-y-5" data-step="1">
                        <div>
                            <h2 class="text-lg font-semibold text-white">Account Setup</h2>
                            <p class="mt-1 text-sm text-[#9e988c]">
                                Start by choosing your login credentials.
                            </p>
                        </div>

                        <div class="[&_[data-flux-label]]:text-[#d6d0c4] [&_input]:border-white/10 [&_input]:bg-[#111315] [&_input]:text-white [&_input]:placeholder:text-[#6f6a61] [&_input]:focus:border-[#c6a56b] [&_input]:focus:ring-[#c6a56b]/20">
                            <flux:input
                                name="username"
                                :label="__('Username')"
                                :value="old('username')"
                                type="text"
                                autocomplete="username"
                                :placeholder="__('Username')"
                                required
                            />
                        </div>

                        <div class="[&_[data-flux-label]]:text-[#d6d0c4] [&_input]:border-white/10 [&_input]:bg-[#111315] [&_input]:text-white [&_input]:placeholder:text-[#6f6a61] [&_input]:focus:border-[#c6a56b] [&_input]:focus:ring-[#c6a56b]/20">
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
                    </div>

                    {{-- STEP 2 --}}
                    <div x-show="step === 2" x-transition.opacity.duration.200ms class="space-y-5" data-step="2">
                        <div>
                            <h2 class="text-lg font-semibold text-white">Alumni Information</h2>
                            <p class="mt-1 text-sm text-[#9e988c]">
                                Provide your basic alumni details.
                            </p>
                        </div>

                        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                            <div class="[&_[data-flux-label]]:text-[#d6d0c4] [&_input]:border-white/10 [&_input]:bg-[#111315] [&_input]:text-white [&_input]:placeholder:text-[#6f6a61] [&_input]:focus:border-[#c6a56b] [&_input]:focus:ring-[#c6a56b]/20">
                                <flux:input
                                    name="fname"
                                    :label="__('First name')"
                                    :value="old('fname')"
                                    type="text"
                                    autocomplete="given-name"
                                    :placeholder="__('First name')"
                                    required
                                />
                            </div>

                            <div class="[&_[data-flux-label]]:text-[#d6d0c4] [&_input]:border-white/10 [&_input]:bg-[#111315] [&_input]:text-white [&_input]:placeholder:text-[#6f6a61] [&_input]:focus:border-[#c6a56b] [&_input]:focus:ring-[#c6a56b]/20">
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
                        </div>

                        <div class="[&_[data-flux-label]]:text-[#d6d0c4] [&_input]:border-white/10 [&_input]:bg-[#111315] [&_input]:text-white [&_input]:placeholder:text-[#6f6a61] [&_input]:focus:border-[#c6a56b] [&_input]:focus:ring-[#c6a56b]/20">
                            <flux:input
                                name="mname"
                                :label="__('Middle name')"
                                :value="old('mname')"
                                type="text"
                                autocomplete="additional-name"
                                :placeholder="__('Middle name (optional)')"
                            />
                        </div>

                        <div class="[&_[data-flux-label]]:text-[#d6d0c4] [&_input]:border-white/10 [&_input]:bg-[#111315] [&_input]:text-white [&_input]:placeholder:text-[#6f6a61] [&_input]:focus:border-[#c6a56b] [&_input]:focus:ring-[#c6a56b]/20">
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
                    </div>

                    {{-- STEP 3 --}}
                    <div x-show="step === 3" x-transition.opacity.duration.200ms class="space-y-5" data-step="3">
                        <div>
                            <h2 class="text-lg font-semibold text-white">Security & Confirmation</h2>
                            <p class="mt-1 text-sm text-[#9e988c]">
                                Set your password and review your registration before submitting.
                            </p>
                        </div>

                        <div class="[&_[data-flux-label]]:text-[#d6d0c4] [&_input]:border-white/10 [&_input]:bg-[#111315] [&_input]:text-white [&_input]:placeholder:text-[#6f6a61] [&_input]:focus:border-[#c6a56b] [&_input]:focus:ring-[#c6a56b]/20">
                            <flux:input
                                name="password"
                                :label="__('Password')"
                                type="password"
                                autocomplete="new-password"
                                :placeholder="__('Password')"
                                viewable
                                required
                            />
                        </div>

                        <div class="[&_[data-flux-label]]:text-[#d6d0c4] [&_input]:border-white/10 [&_input]:bg-[#111315] [&_input]:text-white [&_input]:placeholder:text-[#6f6a61] [&_input]:focus:border-[#c6a56b] [&_input]:focus:ring-[#c6a56b]/20">
                            <flux:input
                                name="password_confirmation"
                                :label="__('Confirm password')"
                                type="password"
                                autocomplete="new-password"
                                :placeholder="__('Confirm password')"
                                viewable
                                required
                            />
                        </div>

                        <div class="border border-[#c6a56b]/20 bg-[#c6a56b]/10 p-4 text-sm leading-7 text-[#d6d0c4]">
                            By creating an account, you confirm that the information you provided is accurate and belongs to you as an alumnus or alumna of Holy Spirit School of Tagbilaran.
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
                        class="inline-flex items-center border border-white/15 bg-white/5 px-4 py-2 text-sm font-medium text-[#d6d0c4] transition hover:bg-white/10"
                    >
                        Back
                    </button>

                    <div class="ml-auto flex items-center gap-3">
                        <button
                            type="button"
                            @click="nextStep()"
                            x-show="step < totalSteps"
                            x-transition.opacity
                            class="inline-flex items-center bg-[#c6a56b] px-4 py-2 text-sm font-semibold text-black transition hover:bg-[#d8b67a]"
                        >
                            Next
                        </button>

                        <flux:button
                            type="submit"
                            variant="primary"
                            class="w-full !border-0 !bg-[#c6a56b] !text-black hover:!bg-[#d8b67a] md:w-auto"
                            x-show="step === totalSteps"
                            x-transition.opacity
                            data-test="register-user-button"
                        >
                            {{ __('Create account') }}
                        </flux:button>
                    </div>
                </div>
            </form>

            <div class="mt-6 border-t border-white/10 pt-5 text-center text-sm text-[#9e988c]">
                <span>{{ __('Already have an account?') }}</span>
                <flux:link :href="route('login')" wire:navigate class="ml-1 text-[#c6a56b] hover:text-[#d8b67a]">
                    {{ __('Log in') }}
                </flux:link>
            </div>
        </div>
    </div>
</x-layouts.auth>