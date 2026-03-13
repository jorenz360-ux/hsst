<div class="max-w-5xl mx-auto p-6 space-y-6">
    {{-- Page Title --}}
    <div class="flex items-start justify-between gap-4">
        <div>
            <h1 class="text-2xl font-semibold text-slate-900 dark:text-slate-100">Create User</h1>

        </div>

        {{-- Optional: use Flux button if you want --}}
        {{-- <flux:button variant="ghost" :href="route('manage-users')" wire:navigate>Back</flux:button> --}}
        <a href="{{ route('manage-users') }}"
           class="inline-flex items-center rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm font-medium text-slate-700 shadow-sm hover:bg-slate-50
                  dark:border-slate-700 dark:bg-slate-900 dark:text-slate-200 dark:hover:bg-slate-800">
            Back
        </a>
    </div>

    {{-- Flash success --}}
    @if (session('success'))
        <div class="rounded-xl border border-emerald-200 bg-emerald-50 p-4 text-emerald-900
                    dark:border-emerald-900/40 dark:bg-emerald-900/20 dark:text-emerald-200">
            {{ session('success') }}
        </div>
    @endif
@if ($showCredentials)
    <div class="rounded-xl border border-indigo-200 bg-indigo-50 p-4
                dark:border-indigo-900/40 dark:bg-indigo-900/20">
        <h3 class="text-sm font-semibold text-indigo-900 dark:text-indigo-200 mb-2">
            Temporary Login Credentials
        </h3>

        <div class="space-y-1 text-sm text-indigo-800 dark:text-indigo-200">
            <div>
                <strong>Username:</strong>
                <span id="gen-username">{{ $generatedUsername }}</span>
            </div>
            <div>
                <strong>Password:</strong>
                <span id="gen-password">{{ $generatedPassword }}</span>
            </div>
        </div>

        <button
            type="button"
            onclick="navigator.clipboard.writeText(
                'Username: {{ $generatedUsername }}\nPassword: {{ $generatedPassword }}'
            )"
            class="mt-3 inline-flex items-center rounded-lg bg-indigo-600 px-3 py-1.5
                   text-xs font-semibold text-white hover:bg-indigo-700">
            Copy Credentials
        </button>

        <p class="mt-2 text-xs text-indigo-700 dark:text-indigo-300">
            User will be required to change password on first login.
        </p>
    </div>
@endif

    <form wire:submit.prevent="save" class="space-y-6">
        {{-- USERS (Account) --}}
       <div class="text-sm text-slate-600 dark:text-slate-300">
    Username and password will be <span class="font-semibold">auto-generated</span>
    and shown after account creation.
</div>


        {{-- BATCH-REP (Profile) --}}
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm space-y-4
                    dark:border-slate-700 dark:bg-slate-900 dark:shadow-lg">
            <div class="flex items-center justify-between">
                <h2 class="text-lg font-semibold text-slate-900 dark:text-slate-100">Alumni Profile (ALUMNI)</h2>
                <span class="text-xs text-slate-500 dark:text-slate-400">Personal info</span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-200">Last Name</label>
                    <input type="text" wire:model.defer="lname"
                           class="mt-1 w-full rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm text-slate-900 outline-none
                                  focus:ring-2 focus:ring-slate-400 dark:border-slate-700 dark:bg-slate-950 dark:text-slate-100">
                    @error('lname') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-200">First Name</label>
                    <input type="text" wire:model.defer="fname"
                           class="mt-1 w-full rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm text-slate-900 outline-none
                                  focus:ring-2 focus:ring-slate-400 dark:border-slate-700 dark:bg-slate-950 dark:text-slate-100">
                    @error('fname') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-200">Middle Name</label>
                    <input type="text" wire:model.defer="mname"
                           class="mt-1 w-full rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm text-slate-900 outline-none
                                  focus:ring-2 focus:ring-slate-400 dark:border-slate-700 dark:bg-slate-950 dark:text-slate-100">
                    @error('mname') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>

        {{-- BATCHES (Assignment) --}}
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm space-y-4
                    dark:border-slate-700 dark:bg-slate-900 dark:shadow-lg">
            <div class="flex items-center justify-between">
                <h2 class="text-lg font-semibold text-slate-900 dark:text-slate-100">Batch</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-200">Select Batch</label>
                    <select wire:model="batch_id"
                            class="mt-1 w-full rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm text-slate-900 outline-none
                                   focus:ring-2 focus:ring-slate-400 dark:border-slate-700 dark:bg-slate-950 dark:text-slate-100">
                        <option value="">-- Choose batch --</option>
                        @foreach($batches as $batch)
                            <option value="{{ $batch->id }}">
                                {{ $batch->school_year }} • Grad: {{ $batch->yeargrad }}
                            </option>
                        @endforeach
                    </select>
                    @error('batch_id') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>

                <div class="flex items-center gap-3 mt-6 md:mt-0">
            <input
                id="is_rep"
                type="checkbox"
                wire:model="is_batch_rep"
                @disabled($this->batchHasRep)
                class="h-4 w-4 rounded border-slate-300 text-slate-900 focus:ring-slate-400
                    disabled:cursor-not-allowed disabled:opacity-50
                    dark:border-slate-600 dark:bg-slate-950"
            >
            <label for="is_rep" class="text-sm text-slate-700 dark:text-slate-200">
                Mark as Batch Representative
            </label>
        </div>

        @if($this->batchHasRep)
            <div class="mt-2 rounded-xl border border-amber-200 bg-amber-50 p-3 text-amber-900
                        dark:border-amber-900/40 dark:bg-amber-900/20 dark:text-amber-200">
                This batch already has a representative. Unassign the current rep first.
            </div>
        @endif
            </div>
        </div>

        {{-- Actions --}}
        <div class="flex items-center justify-end gap-3">
            <button type="button"
                    wire:click="resetForm"
                    class="rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm font-medium text-slate-700 shadow-sm hover:bg-slate-50
                           dark:border-slate-700 dark:bg-slate-900 dark:text-slate-200 dark:hover:bg-slate-800">
                Clear
            </button>

            {{-- If Flux button exists in your free tier, you can use it; otherwise keep this Tailwind button --}}
            <button
                type="submit"
                @disabled($this->batchHasRep && $this->is_batch_rep)
                class="rounded-xl bg-slate-900 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-slate-800
                    disabled:cursor-not-allowed disabled:opacity-50
                    dark:bg-slate-100 dark:text-slate-900 dark:hover:bg-white"
            >
                Create User
            </button>
        </div>
    </form>
</div>
