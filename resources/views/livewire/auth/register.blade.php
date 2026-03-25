<x-layouts.auth title="Sign up">
    <div class="">
        <div
            x-data="registrationWizard()"
            x-init="init()"
            class="relative overflow-hidden border border-white/10 bg-[#111315]/90 text-[#f5f1e8] shadow-[0_30px_80px_rgba(0,0,0,0.45)] backdrop-blur-xl"
        >
            {{-- Ambient background --}}
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,rgba(198,165,107,0.16),transparent_26%)]"></div>
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_bottom_left,rgba(255,255,255,0.04),transparent_22%)]"></div>
            <div class="absolute inset-0 bg-[linear-gradient(180deg,rgba(255,255,255,0.03)_0%,rgba(255,255,255,0)_100%)]"></div>

            <div class="relative px-4 py-4 sm:px-5 sm:py-5">
                {{-- Header – compact --}}
                <div class="mb-4 flex flex-col items-center text-center">
                    <div class="flex h-14 w-14 items-center justify-center overflow-hidden rounded-2xl border border-white/10 bg-white/95 p-1.5 shadow-[0_8px_20px_rgba(0,0,0,0.18)] sm:h-16 sm:w-16">
                        <img
                            src="{{ asset('images/hsstlogo.jpg') }}"
                            alt="HSST Logo"
                            class="h-full w-full object-contain"
                        >
                    </div>
                    <p class="mt-2 text-[10px] font-semibold uppercase tracking-[0.28em] text-[#c6a56b]">
                        Holy Spirit School of Tagbilaran
                    </p>
                    <h1 class="mt-2 font-['DM_Serif_Display'] text-[1.7rem] leading-[1.1] tracking-[-0.02em] text-white sm:text-[2rem]">
                        Create your alumni account
                    </h1>
                    <p class="mt-1 max-w-xl text-xs leading-5 text-[#9e988c] sm:text-[13px]">
                        Join the alumni portal to manage your profile, receive updates, and participate in upcoming reunion activities.
                    </p>
                </div>

                <x-auth-session-status
                    class="mb-3 border border-[#c6a56b]/20 bg-[#c6a56b]/10 px-3 py-2 text-center text-xs text-[#e6decd]"
                    :status="session('status')"
                />

                {{-- COMPACT PROGRESS AREA – only current step info --}}
                <div class="mb-4 overflow-hidden border border-white/10 bg-[#0b0b0c]/80">
                    <div class="px-3 py-3">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-[10px] font-semibold uppercase tracking-[0.24em] text-[#c6a56b]">
                                    Step <span x-text="currentStep"></span> of <span x-text="totalSteps"></span>
                                </p>
                                <h2 class="mt-1 text-base font-semibold text-white" x-text="steps[currentStep-1].title"></h2>
                                <p class="mt-0.5 text-xs leading-5 text-[#9e988c]" x-text="steps[currentStep-1].description"></p>
                            </div>
                            {{-- Mini step dots --}}
                            <div class="flex gap-1">
                                <template x-for="(_, idx) in steps" :key="idx">
                                    <div
                                        class="h-1.5 w-4 rounded-full transition-all"
                                        :class="currentStep > idx+1 ? 'bg-[#c6a56b]' : (currentStep === idx+1 ? 'bg-[#c6a56b]' : 'bg-white/20')"
                                    ></div>
                                </template>
                            </div>
                        </div>
                        {{-- Progress bar --}}
                        <div class="mt-2 h-1 overflow-hidden rounded-full bg-white/10">
                            <div
                                class="h-full rounded-full bg-[#c6a56b] transition-all duration-500 ease-out"
                                :style="`width: ${(currentStep / totalSteps) * 100}%`"
                            ></div>
                        </div>
                    </div>
                </div>

                <form method="POST" action="{{ route('register.store') }}" class="space-y-4" novalidate>
                    @csrf

                    {{-- Step container --}}
                    <div class="overflow-hidden border border-white/10 bg-[#0b0b0c]/85 shadow-[inset_0_1px_0_rgba(255,255,255,0.03)]">
                        {{-- Step header --}}
                        <div class="border-b border-white/10 px-4 py-3 sm:px-5">
                            <div class="flex flex-col gap-1 sm:flex-row sm:items-end sm:justify-between">
                                <div>
                                    <p class="text-[10px] font-semibold uppercase tracking-[0.24em] text-[#c6a56b]">
                                        Step <span x-text="currentStep"></span> of <span x-text="totalSteps"></span>
                                    </p>
                                    <h2 class="mt-1 text-base font-semibold tracking-[-0.02em] text-white sm:text-lg">
                                        <span x-show="currentStep === 1">Account setup</span>
                                        <span x-show="currentStep === 2">Personal information</span>
                                        <span x-show="currentStep === 3">Address details</span>
                                        <span x-show="currentStep === 4">Security setup</span>
                                    </h2>
                                    <p class="mt-0.5 text-xs leading-5 text-[#9e988c] sm:text-sm">
                                        <span x-show="currentStep === 1">Choose the login details you will use for your alumni portal account.</span>
                                        <span x-show="currentStep === 2">Tell us who you are and when you graduated.</span>
                                        <span x-show="currentStep === 3">Provide your current mailing or residential address.</span>
                                        <span x-show="currentStep === 4">Set a secure password and complete your registration.</span>
                                    </p>
                                </div>
                            </div>
                        </div>

                        {{-- Step content – compact --}}
                        <div class="px-4 py-4 sm:px-5 sm:py-5">
                            {{-- STEP 1: ACCOUNT --}}
                            <section
                                x-show="currentStep === 1"
                                x-transition:enter="transition ease-out duration-300"
                                x-transition:enter-start="opacity-0 translate-y-3"
                                x-transition:enter-end="opacity-100 translate-y-0"
                                x-transition:leave="transition ease-in duration-200"
                                x-transition:leave-start="opacity-100 translate-y-0"
                                x-transition:leave-end="opacity-0 -translate-y-2"
                                class="space-y-4"
                                data-step="1"
                            >
                                <div class="grid grid-cols-1 gap-3 lg:grid-cols-2">
                                    <div class="space-y-1.5">
                                        <label for="username" class="block text-xs font-medium text-[#d6d0c4]">
                                            Username
                                        </label>
                                        <div class="rounded-lg border border-white/10 bg-[#111315] transition focus-within:border-[#c6a56b] focus-within:ring-2 focus-within:ring-[#c6a56b]/15">
                                            <flux:input
                                                id="username"
                                                name="username"
                                                :value="old('username')"
                                                type="text"
                                                autocomplete="username"
                                                :placeholder="__('Choose a username')"
                                                required
                                                class="!border-0 !bg-transparent !text-white placeholder:!text-[#6f6a61] !text-sm"
                                            />
                                        </div>
                                        <p class="text-[11px] leading-4 text-[#7f796f]">
                                            Use a memorable username for future login.
                                        </p>
                                    </div>

                                    <div class="space-y-1.5">
                                        <label for="email" class="block text-xs font-medium text-[#d6d0c4]">
                                            Email address
                                        </label>
                                        <div class="rounded-lg border border-white/10 bg-[#111315] transition focus-within:border-[#c6a56b] focus-within:ring-2 focus-within:ring-[#c6a56b]/15">
                                            <flux:input
                                                id="email"
                                                name="email"
                                                :value="old('email')"
                                                type="email"
                                                autocomplete="email"
                                                placeholder="email@example.com"
                                                required
                                                class="!border-0 !bg-transparent !text-white placeholder:!text-[#6f6a61] !text-sm"
                                            />
                                        </div>
                                        <p class="text-[11px] leading-4 text-[#7f796f]">
                                            We will use this for account-related notifications.
                                        </p>
                                    </div>
                                </div>
                            </section>

                            {{-- STEP 2: PERSONAL --}}
                            <section
                                x-show="currentStep === 2"
                                x-transition:enter="transition ease-out duration-300"
                                x-transition:enter-start="opacity-0 translate-y-3"
                                x-transition:enter-end="opacity-100 translate-y-0"
                                x-transition:leave="transition ease-in duration-200"
                                x-transition:leave-start="opacity-100 translate-y-0"
                                x-transition:leave-end="opacity-0 -translate-y-2"
                                class="space-y-4"
                                data-step="2"
                            >
                                <div class="grid grid-cols-1 gap-3 lg:grid-cols-2">
                                    <div class="space-y-1.5">
                                        <label for="fname" class="block text-xs font-medium text-[#d6d0c4]">
                                            First name
                                        </label>
                                        <div class="rounded-lg border border-white/10 bg-[#111315] transition focus-within:border-[#c6a56b] focus-within:ring-2 focus-within:ring-[#c6a56b]/15">
                                            <flux:input
                                                id="fname"
                                                name="fname"
                                                :value="old('fname')"
                                                type="text"
                                                autocomplete="given-name"
                                                :placeholder="__('First name')"
                                                required
                                                class="!border-0 !bg-transparent !text-white placeholder:!text-[#6f6a61] !text-sm"
                                            />
                                        </div>
                                    </div>

                                    <div class="space-y-1.5">
                                        <label for="lname" class="block text-xs font-medium text-[#d6d0c4]">
                                            Last name
                                        </label>
                                        <div class="rounded-lg border border-white/10 bg-[#111315] transition focus-within:border-[#c6a56b] focus-within:ring-2 focus-within:ring-[#c6a56b]/15">
                                            <flux:input
                                                id="lname"
                                                name="lname"
                                                :value="old('lname')"
                                                type="text"
                                                autocomplete="family-name"
                                                :placeholder="__('Last name')"
                                                required
                                                class="!border-0 !bg-transparent !text-white placeholder:!text-[#6f6a61] !text-sm"
                                            />
                                        </div>
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 gap-3 lg:grid-cols-2">
                                    <div class="space-y-1.5">
                                        <label for="mname" class="block text-xs font-medium text-[#d6d0c4]">
                                            Middle name <span class="text-[#7f796f]">(optional)</span>
                                        </label>
                                        <div class="rounded-lg border border-white/10 bg-[#111315] transition focus-within:border-[#c6a56b] focus-within:ring-2 focus-within:ring-[#c6a56b]/15">
                                            <flux:input
                                                id="mname"
                                                name="mname"
                                                :value="old('mname')"
                                                type="text"
                                                autocomplete="additional-name"
                                                :placeholder="__('Middle name')"
                                                class="!border-0 !bg-transparent !text-white placeholder:!text-[#6f6a61] !text-sm"
                                            />
                                        </div>
                                    </div>

                                    <div class="space-y-1.5">
                                        <label for="yeargrad" class="block text-xs font-medium text-[#d6d0c4]">
                                            Year graduated
                                        </label>
                                        <div class="rounded-lg border border-white/10 bg-[#111315] transition focus-within:border-[#c6a56b] focus-within:ring-2 focus-within:ring-[#c6a56b]/15">
                                            <flux:input
                                                id="yeargrad"
                                                name="yeargrad"
                                                :value="old('yeargrad')"
                                                type="number"
                                                min="1900"
                                                max="{{ now()->year }}"
                                                :placeholder="__('e.g. 2015')"
                                                required
                                                class="!border-0 !bg-transparent !text-white placeholder:!text-[#6f6a61] !text-sm"
                                            />
                                        </div>
                                        <p class="text-[11px] leading-4 text-[#7f796f]">
                                            Enter the year you graduated from HSST.
                                        </p>
                                    </div>
                                </div>
                            </section>

                            {{-- STEP 3: ADDRESS with toggle for line 2 --}}
                            <section
                                x-show="currentStep === 3"
                                x-transition:enter="transition ease-out duration-300"
                                x-transition:enter-start="opacity-0 translate-y-3"
                                x-transition:enter-end="opacity-100 translate-y-0"
                                x-transition:leave="transition ease-in duration-200"
                                x-transition:leave-start="opacity-100 translate-y-0"
                                x-transition:leave-end="opacity-0 -translate-y-2"
                                class="space-y-4"
                                data-step="3"
                            >
                                {{-- <div class="rounded-xl border border-[#c6a56b]/15 bg-[#c6a56b]/[0.05] px-3 py-2 text-xs leading-5 text-[#d8d1c2]">
                                    Enter your address manually as requested. Use your current residential or mailing address.
                                </div> --}}
                                <div class="space-y-1.5 xl:col-span-2">
                                    <label for="google_autocomplete" class="block text-xs font-medium text-[#d6d0c4]">
                                        Search address
                                    </label>
                                    <div class="rounded-lg border border-white/10 bg-[#111315] transition focus-within:border-[#c6a56b] focus-within:ring-2 focus-within:ring-[#c6a56b]/15">
                                        <input
                                            id="google_autocomplete"
                                            type="text"
                                            placeholder="Start typing your address..."
                                            class="w-full rounded-lg border-0 bg-transparent px-3 py-2 text-sm text-white placeholder:text-[#6f6a61] focus:outline-none focus:ring-0"
                                        >
                                    </div>
                                    <p class="text-[11px] leading-4 text-[#7f796f]">
                                        Select a suggested address to auto-fill the fields below. You can still edit them manually.
                                    </p>
                                </div>
                                <div class="grid grid-cols-1 gap-3 xl:grid-cols-2">
                                    <div class="space-y-1.5 xl:col-span-2">
                                        <label for="address_line_1" class="block text-xs font-medium text-[#d6d0c4]">
                                            Address line 1
                                        </label>
                                        <div class="rounded-lg border border-white/10 bg-[#111315] transition focus-within:border-[#c6a56b] focus-within:ring-2 focus-within:ring-[#c6a56b]/15">
                                            <flux:textarea
                                                id="address_line_1"
                                                name="address_line_1"
                                                rows="2"
                                                :placeholder="__('House/Unit No., Street, Barangay / District')"
                                                required
                                                class="!border-0 !bg-transparent !text-white placeholder:!text-[#6f6a61] !text-sm"
                                            >{{ old('address_line_1') }}</flux:textarea>
                                        </div>
                                        <p class="text-[11px] leading-4 text-[#7f796f]">
                                            Include the main street address and local area details.
                                        </p>
                                    </div>

                                    {{-- Toggle button for Address Line 2 --}}
                                    <div class="xl:col-span-2">
                                        <button
                                            type="button"
                                            @click="showAddressLine2 = !showAddressLine2"
                                            class="inline-flex items-center gap-1 text-xs font-medium text-[#c6a56b] hover:text-[#d8b67a] transition"
                                            :aria-expanded="showAddressLine2"
                                        >
                                            <span x-text="showAddressLine2 ? '− Hide' : '+ Add'"></span>
                                            <span>apartment, suite, or other details</span>
                                        </button>
                                    </div>

                                    {{-- Address line 2 – conditionally shown --}}
                                    <div
                                        x-show="showAddressLine2"
                                        x-transition.duration.200ms
                                        class="space-y-1.5 xl:col-span-2"
                                    >
                                        <label for="address_line_2" class="block text-xs font-medium text-[#d6d0c4]">
                                            Address line 2 <span class="text-[#7f796f]">(optional)</span>
                                        </label>
                                        <div class="rounded-lg border border-white/10 bg-[#111315] transition focus-within:border-[#c6a56b] focus-within:ring-2 focus-within:ring-[#c6a56b]/15">
                                            <flux:input
                                                id="address_line_2"
                                                name="address_line_2"
                                                :value="old('address_line_2')"
                                                type="text"
                                                autocomplete="address-line2"
                                                :placeholder="__('Subdivision, building, floor, unit, etc.')"
                                                class="!border-0 !bg-transparent !text-white placeholder:!text-[#6f6a61] !text-sm"
                                            />
                                        </div>
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 gap-3 lg:grid-cols-2 xl:grid-cols-4">
                                    <div class="space-y-1.5 xl:col-span-2">
                                        <label for="city" class="block text-xs font-medium text-[#d6d0c4]">
                                            City / Municipality
                                        </label>
                                        <div class="rounded-lg border border-white/10 bg-[#111315] transition focus-within:border-[#c6a56b] focus-within:ring-2 focus-within:ring-[#c6a56b]/15">
                                            <flux:input
                                                id="city"
                                                name="city"
                                                :value="old('city')"
                                                type="text"
                                                autocomplete="address-level2"
                                                :placeholder="__('City or municipality')"
                                                required
                                                class="!border-0 !bg-transparent !text-white placeholder:!text-[#6f6a61] !text-sm"
                                            />
                                        </div>
                                    </div>

                                    <div class="space-y-1.5 xl:col-span-2">
                                        <label for="state_province" class="block text-xs font-medium text-[#d6d0c4]">
                                            Province / State / Region
                                        </label>
                                        <div class="rounded-lg border border-white/10 bg-[#111315] transition focus-within:border-[#c6a56b] focus-within:ring-2 focus-within:ring-[#c6a56b]/15">
                                            <flux:input
                                                id="state_province"
                                                name="state_province"
                                                :value="old('state_province')"
                                                type="text"
                                                autocomplete="address-level1"
                                                :placeholder="__('Province, state, or region')"
                                                required
                                                class="!border-0 !bg-transparent !text-white placeholder:!text-[#6f6a61] !text-sm"
                                            />
                                        </div>
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 gap-3 lg:grid-cols-3">
                                    <div class="space-y-1.5">
                                        <label for="postal_code" class="block text-xs font-medium text-[#d6d0c4]">
                                            Postal / ZIP
                                        </label>
                                        <div class="rounded-lg border border-white/10 bg-[#111315] transition focus-within:border-[#c6a56b] focus-within:ring-2 focus-within:ring-[#c6a56b]/15">
                                            <flux:input
                                                id="postal_code"
                                                name="postal_code"
                                                :value="old('postal_code')"
                                                type="text"
                                                autocomplete="postal-code"
                                                :placeholder="__('Postal or ZIP code')"
                                                required
                                                class="!border-0 !bg-transparent !text-white placeholder:!text-[#6f6a61] !text-sm"
                                            />
                                        </div>
                                    </div>

                                    <div class="space-y-1.5 lg:col-span-2">
                                        <label for="country" class="block text-xs font-medium text-[#d6d0c4]">
                                            Country
                                        </label>
                                        <div class="rounded-lg border border-white/10 bg-[#111315] transition focus-within:border-[#c6a56b] focus-within:ring-2 focus-within:ring-[#c6a56b]/15">
                                            <flux:input
                                                id="country"
                                                name="country"
                                                :value="old('country', 'Philippines')"
                                                type="text"
                                                autocomplete="country-name"
                                                :placeholder="__('Country')"
                                                required
                                                class="!border-0 !bg-transparent !text-white placeholder:!text-[#6f6a61] !text-sm"
                                            />
                                        </div>
                                    </div>
                                </div>
                            </section>

                            {{-- STEP 4: SECURITY --}}
                            <section
                                x-show="currentStep === 4"
                                x-transition:enter="transition ease-out duration-300"
                                x-transition:enter-start="opacity-0 translate-y-3"
                                x-transition:enter-end="opacity-100 translate-y-0"
                                x-transition:leave="transition ease-in duration-200"
                                x-transition:leave-start="opacity-100 translate-y-0"
                                x-transition:leave-end="opacity-0 -translate-y-2"
                                class="space-y-4"
                                data-step="4"
                            >
                                <div class="grid grid-cols-1 gap-3 lg:grid-cols-2">
                                    <div class="space-y-1.5">
                                        <label for="password" class="block text-xs font-medium text-[#d6d0c4]">
                                            Password
                                        </label>
                                        <div class="rounded-lg border border-white/10 bg-[#111315] transition focus-within:border-[#c6a56b] focus-within:ring-2 focus-within:ring-[#c6a56b]/15">
                                            <flux:input
                                                id="password"
                                                name="password"
                                                type="password"
                                                autocomplete="new-password"
                                                :placeholder="__('Create a password')"
                                                viewable
                                                required
                                                class="!border-0 !bg-transparent !text-white placeholder:!text-[#6f6a61] !text-sm"
                                            />
                                        </div>
                                        <p class="text-[11px] leading-4 text-[#7f796f]">
                                            Use a strong password with letters, numbers, and symbols if possible.
                                        </p>
                                    </div>

                                    <div class="space-y-1.5">
                                        <label for="password_confirmation" class="block text-xs font-medium text-[#d6d0c4]">
                                            Confirm password
                                        </label>
                                        <div class="rounded-lg border border-white/10 bg-[#111315] transition focus-within:border-[#c6a56b] focus-within:ring-2 focus-within:ring-[#c6a56b]/15">
                                            <flux:input
                                                id="password_confirmation"
                                                name="password_confirmation"
                                                type="password"
                                                autocomplete="new-password"
                                                :placeholder="__('Confirm your password')"
                                                viewable
                                                required
                                                class="!border-0 !bg-transparent !text-white placeholder:!text-[#6f6a61] !text-sm"
                                            />
                                        </div>
                                    </div>
                                </div>

                                <div class="rounded-xl border border-[#c6a56b]/20 bg-[#c6a56b]/10 p-3 text-xs leading-5 text-[#e2dacb]">
                                    By creating an account, you confirm that the information you provided is accurate and belongs to you as an alumnus or alumna of Holy Spirit School of Tagbilaran.
                                </div>
                            </section>
                        </div>
                    </div>

                    {{-- Footer actions – compact --}}
                    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                        <div class="text-xs text-[#8f8a80]">
                            Already registered?
                            <flux:link :href="route('login')" wire:navigate class="ml-1 text-[#c6a56b] hover:text-[#d8b67a]">
                                {{ __('Log in') }}
                            </flux:link>
                        </div>

                        <div class="flex items-center justify-end gap-2">
                            <button
                                type="button"
                                @click="prevStep()"
                                x-show="currentStep > 1"
                                x-transition.opacity
                                class="inline-flex items-center justify-center rounded-lg border border-white/10 bg-white/5 px-3 py-2 text-xs font-medium text-[#d6d0c4] transition hover:bg-white/10"
                            >
                                Back
                            </button>

                            <button
                                type="button"
                                @click="nextStep()"
                                x-show="currentStep < totalSteps"
                                x-transition.opacity
                                class="inline-flex items-center justify-center rounded-lg bg-[#c6a56b] px-4 py-2 text-xs font-semibold text-black transition hover:bg-[#d8b67a] shadow-[0_8px_20px_rgba(198,165,107,0.18)]"
                            >
                                Continue
                            </button>

                            <flux:button
                                type="submit"
                                variant="primary"
                                x-show="currentStep === totalSteps"
                                x-transition.opacity
                                data-test="register-user-button"
                                class="!rounded-lg !border-0 !bg-[#c6a56b] !px-4 !py-2 !text-xs !font-semibold !text-black hover:!bg-[#d8b67a] shadow-[0_8px_20px_rgba(198,165,107,0.18)]"
                            >
                                {{ __('Create account') }}
                            </flux:button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@if(config('services.google_maps.api_key'))
    <script
        async
        defer
        src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google_maps.api_key') }}&libraries=places&callback=initGoogleAddressAutocomplete"
    ></script>
@endif
<script>
    let googleAddressAutocompleteInstance = null;

    function initGoogleAddressAutocomplete() {
        const autocompleteInput = document.getElementById('google_autocomplete');

        if (!autocompleteInput || !window.google || !google.maps || !google.maps.places) {
            return;
        }

        googleAddressAutocompleteInstance = new google.maps.places.Autocomplete(autocompleteInput, {
            types: ['address'],
            fields: ['address_components', 'formatted_address'],
        });

        googleAddressAutocompleteInstance.addListener('place_changed', handleGooglePlaceChanged);
    }

    function handleGooglePlaceChanged() {
        if (!googleAddressAutocompleteInstance) return;

        const place = googleAddressAutocompleteInstance.getPlace();
        if (!place || !place.address_components) return;

        const components = {
            street_number: '',
            route: '',
            subpremise: '',
            locality: '',
            postal_town: '',
            administrative_area_level_1: '',
            postal_code: '',
            country: '',
            neighborhood: '',
            sublocality: '',
            sublocality_level_1: '',
        };

        for (const component of place.address_components) {
            const type = component.types[0];
            if (components.hasOwnProperty(type)) {
                components[type] = component.long_name;
            }
        }

        const addressLine1Parts = [
            components.street_number,
            components.route,
        ].filter(Boolean);

        const addressLine2Parts = [
            components.subpremise,
        ].filter(Boolean);

        const cityValue =
            components.locality ||
            components.postal_town ||
            components.sublocality_level_1 ||
            components.sublocality ||
            components.neighborhood;

        const addressLine1 = addressLine1Parts.join(' ').trim();
        const addressLine2 = addressLine2Parts.join(', ').trim();

        setFieldValue('address_line_1', addressLine1);
        setFieldValue('address_line_2', addressLine2);
        setFieldValue('city', cityValue);
        setFieldValue('state_province', components.administrative_area_level_1);
        setFieldValue('postal_code', components.postal_code);
        setFieldValue('country', components.country);

        const addressLine1Field = document.getElementById('address_line_1');
        if (addressLine1Field) {
            addressLine1Field.focus();
        }
    }

    function setFieldValue(fieldId, value) {
        const field = document.getElementById(fieldId);
        if (!field) return;

        field.value = value || '';

        field.dispatchEvent(new Event('input', { bubbles: true }));
        field.dispatchEvent(new Event('change', { bubbles: true }));
    }

    function registrationWizard() {
        return {
            currentStep: 1,
            totalSteps: 4,
            showAddressLine2: {{ old('address_line_2') ? 'true' : 'false' }},
            steps: [
                { title: 'Account', description: 'Login details' },
                { title: 'Personal', description: 'Basic alumni identity' },
                { title: 'Address', description: 'Current location details' },
                { title: 'Security', description: 'Password and finish' }
            ],

            init() {
                this.$nextTick(() => {
                    this.focusFirstField();

                    if (this.currentStep === 3) {
                        setTimeout(() => {
                            if (typeof initGoogleAddressAutocomplete === 'function') {
                                initGoogleAddressAutocomplete();
                            }
                        }, 200);
                    }
                });
            },

            getStepElement(stepNumber) {
                return this.$root.querySelector(`[data-step='${stepNumber}']`);
            },

            getFocusableFields(stepNumber) {
                const section = this.getStepElement(stepNumber);
                if (!section) return [];

                return Array.from(
                    section.querySelectorAll('input, select, textarea')
                ).filter(field => field.offsetParent !== null && !field.disabled);
            },

            focusFirstField() {
                const firstField = this.getFocusableFields(this.currentStep)[0];
                if (firstField) firstField.focus();
            },

            validateStep(stepNumber) {
                const fields = this.getFocusableFields(stepNumber);

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
                if (!this.validateStep(this.currentStep)) return;

                if (this.currentStep < this.totalSteps) {
                    this.currentStep++;
                    this.$nextTick(() => {
                        this.focusFirstField();

                        if (this.currentStep === 3) {
                            setTimeout(() => {
                                if (typeof initGoogleAddressAutocomplete === 'function') {
                                    initGoogleAddressAutocomplete();
                                }
                            }, 200);
                        }
                    });
                }
            },

            prevStep() {
                if (this.currentStep > 1) {
                    this.currentStep--;
                    this.$nextTick(() => this.focusFirstField());
                }
            }
        };
    }
</script>
</x-layouts.auth>