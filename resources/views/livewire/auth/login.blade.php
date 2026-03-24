<x-layouts.auth title="Sign in">
    <div class="">
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
                    Log in to your account
                </h1>

                <p class="mt-3 max-w-md text-sm leading-7 text-[#9e988c]">
                    Enter your username and password below to access the Holy Spirit School of Tagbilaran alumni portal.
                </p>
            </div>

            <x-auth-session-status
                class="mb-5 border border-[#c6a56b]/20 bg-[#c6a56b]/10 px-4 py-3 text-center text-sm text-[#d6d0c4]"
                :status="session('status')"
            />

            <form method="POST" action="{{ route('login.store') }}" class="flex flex-col gap-5">
                @csrf

                <div class="[&_[data-flux-label]]:text-[#d6d0c4] [&_input]:border-white/10 [&_input]:bg-[#0b0b0c] [&_input]:text-white [&_input]:placeholder:text-[#6f6a61] [&_input]:focus:border-[#c6a56b] [&_input]:focus:ring-[#c6a56b]/20">
                    <flux:input
                        name="username"
                        :label="__('Username')"
                        :value="old('username')"
                        type="text"
                        required
                        autofocus
                        autocomplete="username"
                        placeholder="your-username"
                    />
                </div>

                <div class="relative [&_[data-flux-label]]:text-[#d6d0c4] [&_input]:border-white/10 [&_input]:bg-[#0b0b0c] [&_input]:text-white [&_input]:placeholder:text-[#6f6a61] [&_input]:focus:border-[#c6a56b] [&_input]:focus:ring-[#c6a56b]/20">
                    <flux:input
                        name="password"
                        :label="__('Password')"
                        type="password"
                        required
                        autocomplete="current-password"
                        :placeholder="__('Password')"
                        viewable
                    />

                    @if (Route::has('password.request'))
                        <flux:link
                            class="absolute end-0 top-0 text-sm text-[#c6a56b] hover:text-[#d8b67a]"
                            :href="route('password.request')"
                            wire:navigate
                        >
                            {{ __('Forgot your password?') }}
                        </flux:link>
                    @endif
                </div>

                <div class="[&_[data-flux-label]]:text-[#d6d0c4] [&_[data-flux-checkbox]]:border-white/20 [&_[data-flux-checkbox][data-checked]]:border-[#c6a56b] [&_[data-flux-checkbox][data-checked]]:bg-[#c6a56b]">
                    <flux:checkbox name="remember" :label="__('Remember me')" :checked="old('remember')" />
                </div>

                <div class="pt-2">
                    <flux:button
                        variant="primary"
                        type="submit"
                        class="w-full !border-0 !bg-[#c6a56b] !text-black hover:!bg-[#d8b67a]"
                        data-test="login-button"
                    >
                        {{ __('Log in') }}
                    </flux:button>
                </div>
            </form>

            @if (Route::has('register'))
                <div class="mt-6 border-t border-white/10 pt-5 text-center text-sm text-[#9e988c]">
                    <span>{{ __('Don\'t have an account?') }}</span>
                    <flux:link :href="route('register')" wire:navigate class="ml-1 text-[#c6a56b] hover:text-[#d8b67a]">
                        {{ __('Sign up') }}
                    </flux:link>
                </div>
            @endif
        </div>
    </div>
</x-layouts.auth>