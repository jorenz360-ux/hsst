<div class="mx-auto max-w-2xl px-4 py-10">
    <h1 class="mb-1 text-2xl font-bold text-gray-900">Non-Alumni Registration</h1>
    <p class="mb-8 text-sm text-gray-500">For HSST employees and staff who are not alumni.</p>

    <form wire:submit="save" class="space-y-6">
        {{-- Name --}}
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
            <div>
                <flux:label for="fname">First Name <span class="text-red-500">*</span></flux:label>
                <flux:input id="fname" wire:model="fname" type="text" />
                @error('fname') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>
            <div>
                <flux:label for="lname">Last Name <span class="text-red-500">*</span></flux:label>
                <flux:input id="lname" wire:model="lname" type="text" />
                @error('lname') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>
            <div>
                <flux:label for="mname">Middle Name</flux:label>
                <flux:input id="mname" wire:model="mname" type="text" />
            </div>
        </div>

        {{-- Address --}}
        <div class="space-y-4">
            <div>
                <flux:label for="address_line_1">Address Line 1 <span class="text-red-500">*</span></flux:label>
                <flux:input id="address_line_1" wire:model="address_line_1" type="text" />
                @error('address_line_1') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>
            <div>
                <flux:label for="address_line_2">Address Line 2</flux:label>
                <flux:input id="address_line_2" wire:model="address_line_2" type="text" />
            </div>
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                <div>
                    <flux:label for="city">City <span class="text-red-500">*</span></flux:label>
                    <flux:input id="city" wire:model="city" type="text" />
                    @error('city') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>
                <div>
                    <flux:label for="state_province">State / Province <span class="text-red-500">*</span></flux:label>
                    <flux:input id="state_province" wire:model="state_province" type="text" />
                    @error('state_province') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>
                <div>
                    <flux:label for="postal_code">Postal Code <span class="text-red-500">*</span></flux:label>
                    <flux:input id="postal_code" wire:model="postal_code" type="text" />
                    @error('postal_code') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>
            </div>
            <div>
                <flux:label for="country">Country <span class="text-red-500">*</span></flux:label>
                <flux:input id="country" wire:model="country" type="text" />
                @error('country') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        {{-- Work Info --}}
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
            <div>
                <flux:label for="position">Position <span class="text-red-500">*</span></flux:label>
                <flux:input id="position" wire:model="position" type="text" placeholder="e.g. Faculty, Principal" />
                @error('position') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>
            <div>
                <flux:label for="years_working">Years Working at HSST <span class="text-red-500">*</span></flux:label>
                <flux:input id="years_working" wire:model="years_working" type="number" min="1" max="99" />
                @error('years_working') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        {{-- Account Type --}}
        <div>
            <flux:label for="account_type">Account Type <span class="text-red-500">*</span></flux:label>
            <flux:select id="account_type" wire:model="account_type">
                <option value="">Select type...</option>
                <option value="staff">Staff</option>
                <option value="employee">Employee</option>
                <option value="ssps-member">SSPS Member</option>
            </flux:select>
            @error('account_type') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
        </div>

        {{-- Account Credentials --}}
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
            <div>
                <flux:label for="email">Email <span class="text-red-500">*</span></flux:label>
                <flux:input id="email" wire:model="email" type="email" />
                @error('email') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
            <div>
                <flux:label for="password">Password <span class="text-red-500">*</span></flux:label>
                <flux:input id="password" wire:model="password" type="password" />
                @error('password') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>
            <div>
                <flux:label for="password_confirmation">Confirm Password <span class="text-red-500">*</span></flux:label>
                <flux:input id="password_confirmation" wire:model="password_confirmation" type="password" />
            </div>
        </div>

        <div>
            <flux:button type="submit" variant="primary" wire:loading.attr="disabled">
                <span wire:loading.remove>Submit Registration</span>
                <span wire:loading>Submitting...</span>
            </flux:button>
        </div>
    </form>

    <p class="mt-6 text-sm text-gray-500">
        Are you an alumni? <a href="{{ route('login') }}" class="text-amber-600 underline">Log in here</a>.
    </p>
</div>
