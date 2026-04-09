<div class="min-h-screen text-zinc-900">
<div class="mx-auto max-w-5xl space-y-6 p-6">

    {{-- Header --}}
    <div class="flex items-start justify-between gap-4">
        <div>
            <p class="text-xs font-semibold uppercase tracking-[0.22em] text-amber-600">
                User Management
            </p>
            <h1 class="mt-1 text-2xl font-semibold tracking-tight text-zinc-900">
                Create User
            </h1>
            <p class="mt-2 text-sm text-zinc-500">
                Create a new alumni account and assign the appropriate batch information.
            </p>
        </div>

        <a href="{{ route('manage-users') }}"
           class="inline-flex items-center rounded-xl border border-zinc-300 bg-white px-3 py-2 text-sm font-medium text-zinc-700 transition hover:bg-zinc-50">
            Back
        </a>
    </div>

    {{-- Success --}}
    @if (session('success'))
        <div class="rounded-2xl border border-emerald-500/20 bg-emerald-50 p-4 text-emerald-700">
            {{ session('success') }}
        </div>
    @endif

    {{-- Generated Credentials --}}
    @if ($showCredentials)
        <div class="rounded-2xl border border-violet-500/20 bg-violet-50 p-4">
            <h3 class="mb-2 text-sm font-semibold text-violet-700">
                Temporary Login Credentials
            </h3>

            <div class="space-y-1 text-sm text-violet-800">
                <div><strong>Username:</strong> {{ $generatedUsername }}</div>
                <div><strong>Password:</strong> {{ $generatedPassword }}</div>
            </div>

            <button
                type="button"
                onclick="navigator.clipboard.writeText(
                    'Username: {{ $generatedUsername }}\nPassword: {{ $generatedPassword }}'
                )"
                class="mt-3 inline-flex items-center rounded-xl bg-violet-500 px-3 py-1.5 text-xs font-semibold text-white hover:bg-violet-600"
            >
                Copy Credentials
            </button>

            <p class="mt-2 text-xs text-violet-600">
                User will be required to change password on first login.
            </p>
        </div>
    @endif

    <form wire:submit.prevent="save" class="space-y-6">

        {{-- Info --}}
        <div class="rounded-2xl border border-zinc-200 bg-zinc-50 p-4 text-sm text-zinc-600">
            Username and password will be <span class="font-semibold text-zinc-900">auto-generated</span>.
        </div>

        {{-- Alumni Profile --}}
        <div class="rounded-3xl border border-zinc-200 bg-white p-6 space-y-5">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-semibold text-zinc-900">Alumni Profile</h2>
                    <p class="text-sm text-zinc-500">Personal information</p>
                </div>
                <span class="rounded-full border border-zinc-200 bg-zinc-100 px-3 py-1 text-xs text-zinc-500">
                    ALUMNI
                </span>
            </div>

            <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                @foreach (['lname' => 'Last Name', 'fname' => 'First Name', 'mname' => 'Middle Name'] as $field => $label)
                    <div>
                        <label class="block text-sm text-zinc-700">{{ $label }}</label>
                        <input
                            type="text"
                            wire:model.defer="{{ $field }}"
                            class="mt-1 w-full rounded-xl border border-zinc-300 bg-white px-3 py-2 text-zinc-900 focus:border-amber-400 focus:ring-2 focus:ring-amber-500/20"
                        >
                        @error($field)
                            <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Batch --}}
        <div class="rounded-3xl border border-zinc-200 bg-white p-6 space-y-5">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-semibold text-zinc-900">Batch Assignment</h2>
                    <p class="text-sm text-zinc-500">Assign the alumnus</p>
                </div>
                <span class="rounded-full border border-zinc-200 bg-zinc-100 px-3 py-1 text-xs text-zinc-500">
                    BATCH
                </span>
            </div>

            <div class="grid md:grid-cols-2 gap-4">
                <div>
                    <select
                        wire:model="batch_id"
                        class="w-full rounded-xl border border-zinc-300 bg-white px-3 py-2 text-zinc-900 focus:border-amber-400 focus:ring-2 focus:ring-amber-500/20"
                    >
                        <option value="">-- Choose batch --</option>
                        @foreach($batches as $batch)
                            <option value="{{ $batch->id }}">
                                {{ $batch->school_year }} • Grad: {{ $batch->yeargrad }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="flex items-center gap-3">
                    <input
                        type="checkbox"
                        wire:model="is_batch_rep"
                        class="text-amber-400 bg-white border-zinc-300 focus:ring-amber-500/30"
                    >
                    <label class="text-sm text-zinc-700">
                        Batch Representative
                    </label>
                </div>
            </div>

            @if($this->batchHasRep)
                <div class="rounded-2xl border border-amber-500/20 bg-amber-50 p-3 text-amber-700">
                    This batch already has a representative.
                </div>
            @endif
        </div>

        {{-- Actions --}}
        <div class="flex justify-end gap-3">
            <button
                type="button"
                wire:click="resetForm"
                class="rounded-xl border border-zinc-300 bg-white px-4 py-2 text-zinc-700 hover:bg-zinc-50"
            >
                Clear
            </button>

            <button
                type="submit"
                class="rounded-xl bg-amber-500 px-4 py-2 text-sm font-semibold text-white hover:bg-amber-600 disabled:opacity-50"
            >
                Create User
            </button>
        </div>

    </form>
</div>
</div>
