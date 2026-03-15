<div class="mx-auto max-w-5xl space-y-6 p-6">
    {{-- Page Title --}}
    <div class="flex items-start justify-between gap-4">
        <div>
            <p class="text-xs font-semibold uppercase tracking-[0.22em] text-teal-400">
                User Management
            </p>
            <h1 class="mt-1 text-2xl font-semibold tracking-tight text-white">
                Create User
            </h1>
            <p class="mt-2 text-sm text-zinc-400">
                Create a new alumni account and assign the appropriate batch information.
            </p>
        </div>

        <a href="{{ route('manage-users') }}"
           class="inline-flex items-center rounded-xl border border-white/10 bg-zinc-900 px-3 py-2 text-sm font-medium text-zinc-200 transition hover:bg-zinc-800">
            Back
        </a>
    </div>

    {{-- Flash success --}}
    @if (session('success'))
        <div class="rounded-2xl border border-emerald-500/20 bg-emerald-500/10 p-4 text-emerald-200">
            {{ session('success') }}
        </div>
    @endif

    {{-- Generated Credentials --}}
    @if ($showCredentials)
        <div class="rounded-2xl border border-cyan-500/20 bg-cyan-500/10 p-4">
            <h3 class="mb-2 text-sm font-semibold text-cyan-200">
                Temporary Login Credentials
            </h3>

            <div class="space-y-1 text-sm text-cyan-100">
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
                class="mt-3 inline-flex items-center rounded-xl bg-cyan-500 px-3 py-1.5 text-xs font-semibold text-zinc-950 transition hover:bg-cyan-400"
            >
                Copy Credentials
            </button>

            <p class="mt-2 text-xs text-cyan-200/80">
                User will be required to change password on first login.
            </p>
        </div>
    @endif

    <form wire:submit.prevent="save" class="space-y-6">
        {{-- Info --}}
        <div class="rounded-2xl border border-white/10 bg-white/[0.03] p-4 text-sm text-zinc-300">
            Username and password will be <span class="font-semibold text-white">auto-generated</span>
            and shown after account creation.
        </div>

        {{-- Alumni Profile --}}
        <div class="rounded-3xl border border-white/10 bg-white/[0.03] p-6 shadow-sm space-y-5">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-semibold text-white">Alumni Profile</h2>
                    <p class="mt-1 text-sm text-zinc-400">Personal information</p>
                </div>
                <span class="rounded-full border border-white/10 bg-white/5 px-3 py-1 text-xs text-zinc-400">
                    ALUMNI
                </span>
            </div>

            <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                <div>
                    <label class="block text-sm font-medium text-zinc-200">Last Name</label>
                    <input
                        type="text"
                        wire:model.defer="lname"
                        class="mt-1 w-full rounded-xl border border-white/10 bg-zinc-950 px-3 py-2 text-sm text-white outline-none transition focus:border-teal-400/30 focus:ring-2 focus:ring-teal-500/30"
                    >
                    @error('lname')
                        <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-zinc-200">First Name</label>
                    <input
                        type="text"
                        wire:model.defer="fname"
                        class="mt-1 w-full rounded-xl border border-white/10 bg-zinc-950 px-3 py-2 text-sm text-white outline-none transition focus:border-teal-400/30 focus:ring-2 focus:ring-teal-500/30"
                    >
                    @error('fname')
                        <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-zinc-200">Middle Name</label>
                    <input
                        type="text"
                        wire:model.defer="mname"
                        class="mt-1 w-full rounded-xl border border-white/10 bg-zinc-950 px-3 py-2 text-sm text-white outline-none transition focus:border-teal-400/30 focus:ring-2 focus:ring-teal-500/30"
                    >
                    @error('mname')
                        <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        {{-- Batch Assignment --}}
        <div class="rounded-3xl border border-white/10 bg-white/[0.03] p-6 shadow-sm space-y-5">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-semibold text-white">Batch Assignment</h2>
                    <p class="mt-1 text-sm text-zinc-400">Assign the alumnus to a specific batch</p>
                </div>
                <span class="rounded-full border border-white/10 bg-white/5 px-3 py-1 text-xs text-zinc-400">
                    BATCH
                </span>
            </div>

            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <div>
                    <label class="block text-sm font-medium text-zinc-200">Select Batch</label>
                    <select
                        wire:model="batch_id"
                        class="mt-1 w-full rounded-xl border border-white/10 bg-zinc-950 px-3 py-2 text-sm text-white outline-none transition focus:border-teal-400/30 focus:ring-2 focus:ring-teal-500/30"
                    >
                        <option value="">-- Choose batch --</option>
                        @foreach($batches as $batch)
                            <option value="{{ $batch->id }}">
                                {{ $batch->school_year }} • Grad: {{ $batch->yeargrad }}
                            </option>
                        @endforeach
                    </select>
                    @error('batch_id')
                        <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center gap-3 pt-7 md:pt-0">
                    <input
                        id="is_rep"
                        type="checkbox"
                        wire:model="is_batch_rep"
                        @disabled($this->batchHasRep)
                        class="h-4 w-4 rounded border-white/20 bg-zinc-950 text-teal-400 focus:ring-teal-500/40 disabled:cursor-not-allowed disabled:opacity-50"
                    >
                    <label for="is_rep" class="text-sm text-zinc-200">
                        Mark as Batch Representative
                    </label>
                </div>
            </div>

            @if($this->batchHasRep)
                <div class="rounded-2xl border border-amber-500/20 bg-amber-500/10 p-3 text-amber-200">
                    This batch already has a representative. Unassign the current rep first.
                </div>
            @endif
        </div>

        {{-- Actions --}}
        <div class="flex items-center justify-end gap-3">
            <button
                type="button"
                wire:click="resetForm"
                class="rounded-xl border border-white/10 bg-zinc-900 px-4 py-2 text-sm font-medium text-zinc-200 transition hover:bg-zinc-800"
            >
                Clear
            </button>

            <button
                type="submit"
                @disabled($this->batchHasRep && $this->is_batch_rep)
                class="rounded-xl bg-teal-500 px-4 py-2 text-sm font-semibold text-zinc-950 transition hover:bg-teal-400 disabled:cursor-not-allowed disabled:opacity-50"
            >
                Create User
            </button>
        </div>
    </form>
</div>