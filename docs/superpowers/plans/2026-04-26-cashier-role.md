# Cashier Role & Generic Staff Account Creation Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Add a `cashier` role that can verify donation receipts, and extend the Add User page to support generic non-alumni staff accounts via a User Type toggle.

**Architecture:** New `cashier` Spatie role seeded alongside existing roles. `LoginResponse` gains a role-based redirect so cashiers land on `/donations`. `CreateUser` component gains a `userType` toggle (`alumni` | `staff`) with a `staffRole` dropdown populated from a `STAFF_ROLES` constant — no `Alumni` or `AlumniEducation` records are created for staff.

**Tech Stack:** Laravel 12, Livewire 3, Spatie Permission, Pest 4, SQLite (tests)

---

## File Map

| File | Change |
|------|--------|
| `database/seeders/RoleSeeder.php` | Add `cashier` to roles array |
| `app/Actions/Fortify/LoginResponse.php` | Redirect cashier → `donations` route |
| `routes/web.php` | Add `cashier` to `/donations` middleware |
| `app/Livewire/CreateUser.php` | Add `userType`, `staffRole`, staff save/username logic |
| `resources/views/livewire/create-user.blade.php` | User Type radio + conditional sections + staff role dropdown |
| `tests/Feature/CashierRoleTest.php` | New feature test file |

---

## Task 1: Seed the cashier role

**Files:**
- Modify: `database/seeders/RoleSeeder.php:12-18`

- [ ] **Step 1: Add `cashier` to the roles array**

Open `database/seeders/RoleSeeder.php`. Change the `$roles` array from:

```php
$roles = [
    'super-admin',
    'reunion-coordinator',
    'ssps',
    'batch-representative',
    'alumni',
];
```

to:

```php
$roles = [
    'super-admin',
    'reunion-coordinator',
    'ssps',
    'batch-representative',
    'alumni',
    'cashier',
];
```

- [ ] **Step 2: Run the seeder to verify it works**

```bash
php artisan db:seed --class=RoleSeeder
```

Expected: no errors. Run `php artisan tinker --execute="echo \Spatie\Permission\Models\Role::where('name','cashier')->exists() ? 'ok' : 'missing';"` to confirm `ok`.

- [ ] **Step 3: Commit**

```bash
git add database/seeders/RoleSeeder.php
git commit -m "feat: seed cashier role"
```

---

## Task 2: Redirect cashier to donations on login

**Files:**
- Create: `tests/Feature/CashierRoleTest.php`
- Modify: `app/Actions/Fortify/LoginResponse.php`

- [ ] **Step 1: Write the failing test**

Create `tests/Feature/CashierRoleTest.php`:

```php
<?php

use App\Actions\Fortify\LoginResponse;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

beforeEach(function () {
    Role::firstOrCreate(['name' => 'cashier',              'guard_name' => 'web']);
    Role::firstOrCreate(['name' => 'reunion-coordinator',  'guard_name' => 'web']);
    Role::firstOrCreate(['name' => 'alumni',               'guard_name' => 'web']);
    Role::firstOrCreate(['name' => 'batch-representative', 'guard_name' => 'web']);
});

test('cashier login response redirects to donations route', function () {
    $user = User::factory()->create(['is_active' => true]);
    $user->syncRoles(['cashier']);

    $request = Request::create('/login', 'POST');
    $request->setUserResolver(fn () => $user);

    $response = app(LoginResponse::class)->toResponse($request);

    expect($response->getTargetUrl())->toContain(route('donations', absolute: false));
});

test('non-cashier login response redirects to dashboard', function () {
    $user = User::factory()->create(['is_active' => true]);
    $user->syncRoles(['alumni']);

    $request = Request::create('/login', 'POST');
    $request->setUserResolver(fn () => $user);

    $response = app(LoginResponse::class)->toResponse($request);

    expect($response->getTargetUrl())->toContain(route('dashboard', absolute: false));
});
```

- [ ] **Step 2: Run the test to verify it fails**

```bash
php artisan test tests/Feature/CashierRoleTest.php --filter="cashier login response"
```

Expected: FAIL — cashier redirects to `/dashboard` not `/donations`.

- [ ] **Step 3: Update LoginResponse to redirect cashier**

Replace the entire contents of `app/Actions/Fortify/LoginResponse.php`:

```php
<?php

namespace App\Actions\Fortify;

use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;

class LoginResponse implements LoginResponseContract
{
    public function toResponse($request)
    {
        $user = $request->user();

        if (! $user) {
            return redirect()->route('home');
        }

        if ($user->hasRole('cashier')) {
            return redirect()->route('donations');
        }

        return redirect()->route('dashboard');
    }
}
```

- [ ] **Step 4: Run the tests to verify they pass**

```bash
php artisan test tests/Feature/CashierRoleTest.php
```

Expected: both tests PASS.

- [ ] **Step 5: Commit**

```bash
git add app/Actions/Fortify/LoginResponse.php tests/Feature/CashierRoleTest.php
git commit -m "feat: redirect cashier to donations on login"
```

---

## Task 3: Grant cashier access to the donations route

**Files:**
- Modify: `routes/web.php:100-102`
- Modify: `tests/Feature/CashierRoleTest.php` (append tests)

- [ ] **Step 1: Write the failing test**

Append these two tests to `tests/Feature/CashierRoleTest.php`:

```php
test('cashier can access donations page', function () {
    $user = User::factory()->create(['is_active' => true]);
    $user->syncRoles(['cashier']);

    $this->actingAs($user)
        ->get(route('donations'))
        ->assertStatus(200);
});

test('cashier cannot access dashboard', function () {
    $user = User::factory()->create(['is_active' => true]);
    $user->syncRoles(['cashier']);

    $this->actingAs($user)
        ->get(route('dashboard'))
        ->assertStatus(403);
});
```

- [ ] **Step 2: Run tests to verify they fail**

```bash
php artisan test tests/Feature/CashierRoleTest.php --filter="cashier can access donations"
```

Expected: FAIL with 403 (cashier not in route middleware yet).

- [ ] **Step 3: Add cashier to the donations route middleware**

In `routes/web.php`, find line 100-102:

```php
Route::get('/donations', ManageDonations::class)
    ->middleware(['auth', 'role:batch-representative|super-admin'])
    ->name('donations');
```

Change to:

```php
Route::get('/donations', ManageDonations::class)
    ->middleware(['auth', 'role:batch-representative|cashier|super-admin'])
    ->name('donations');
```

- [ ] **Step 4: Run all cashier tests**

```bash
php artisan test tests/Feature/CashierRoleTest.php
```

Expected: all 4 tests PASS.

- [ ] **Step 5: Commit**

```bash
git add routes/web.php tests/Feature/CashierRoleTest.php
git commit -m "feat: grant cashier access to donations route"
```

---

## Task 4: Extend CreateUser with staff account support

**Files:**
- Modify: `app/Livewire/CreateUser.php`
- Modify: `tests/Feature/CashierRoleTest.php` (append Livewire tests)

- [ ] **Step 1: Write the failing Livewire tests**

Append to `tests/Feature/CashierRoleTest.php`:

```php
test('admin can create a cashier staff account without alumni record', function () {
    $admin = User::factory()->create(['is_active' => true]);
    $admin->syncRoles(['reunion-coordinator']);

    \Livewire\Livewire::actingAs($admin)
        ->test(\App\Livewire\CreateUser::class)
        ->set('userType', 'staff')
        ->set('fname', 'Maria')
        ->set('lname', 'Santos')
        ->set('email', 'cashier@hsst.test')
        ->set('staffRole', 'cashier')
        ->call('save')
        ->assertHasNoErrors()
        ->assertSet('fname', '');

    $created = \App\Models\User::where('email', 'cashier@hsst.test')->first();

    expect($created)->not->toBeNull()
        ->and($created->hasRole('cashier'))->toBeTrue()
        ->and($created->alumni_id)->toBeNull()
        ->and(str_starts_with($created->username, 'staff-'))->toBeTrue();
});

test('creating staff account does not require batch fields', function () {
    $admin = User::factory()->create(['is_active' => true]);
    $admin->syncRoles(['reunion-coordinator']);

    \Livewire\Livewire::actingAs($admin)
        ->test(\App\Livewire\CreateUser::class)
        ->set('userType', 'staff')
        ->set('fname', 'Jose')
        ->set('lname', 'Reyes')
        ->set('email', 'jose@hsst.test')
        ->set('staffRole', 'cashier')
        ->call('save')
        ->assertHasNoErrors();
});
```

- [ ] **Step 2: Run the failing tests**

```bash
php artisan test tests/Feature/CashierRoleTest.php --filter="admin can create"
```

Expected: FAIL — `userType` property does not exist.

- [ ] **Step 3: Replace `app/Livewire/CreateUser.php` with the updated component**

```php
<?php

namespace App\Livewire;

use App\Mail\WelcomeCredentials;
use App\Models\Alumni;
use App\Models\AlumniEducation;
use App\Models\Batch;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\Attributes\Title;

#[Title('Add User')]
class CreateUser extends Component
{
    const STAFF_ROLES = ['cashier'];

    // User type toggle
    public string $userType = 'alumni'; // 'alumni' | 'staff'
    public string $staffRole = '';

    // Alumni / shared fields
    public string $lname = '';
    public string $fname = '';
    public string $mname = '';
    public string $email = '';

    // Alumni-only education fields
    public ?int $batch_id = null;
    public bool $is_batch_rep = false;
    public bool $did_graduate = true;
    public string $school_year_attended = '';

    public function getBatchesProperty()
    {
        return Batch::query()
            ->orderByRaw("FIELD(level, 'elementary', 'highschool', 'college')")
            ->orderByDesc('yeargrad')
            ->get()
            ->groupBy('level');
    }

    public function getBatchHasRepProperty(): bool
    {
        if (blank($this->batch_id)) return false;

        return AlumniEducation::where('batch_id', $this->batch_id)
            ->where('is_batch_rep', true)
            ->exists();
    }

    public function updatedBatchId(): void
    {
        if ($this->batchHasRep) {
            $this->is_batch_rep = false;
        }
    }

    public function updatedUserType(): void
    {
        $this->reset([
            'batch_id', 'is_batch_rep', 'did_graduate', 'school_year_attended',
            'staffRole',
        ]);
        $this->resetValidation();
    }

    public function resetForm(): void
    {
        $this->reset([
            'userType', 'staffRole',
            'lname', 'fname', 'mname', 'email',
            'batch_id', 'is_batch_rep', 'did_graduate', 'school_year_attended',
        ]);
    }

    public function save(): void
    {
        if ($this->userType === 'staff') {
            $this->saveStaff();
        } else {
            $this->saveAlumni();
        }
    }

    private function saveStaff(): void
    {
        $this->validate([
            'lname'     => 'required|string|max:80',
            'fname'     => 'required|string|max:80',
            'mname'     => 'nullable|string|max:80',
            'email'     => 'required|email|max:255|unique:users,email',
            'staffRole' => ['required', Rule::in(self::STAFF_ROLES)],
        ]);

        $username          = $this->generateStaffUsername();
        $temporaryPassword = $this->generateTempPassword();

        $user = User::create([
            'username'             => $username,
            'password'             => Hash::make($temporaryPassword),
            'must_change_password' => true,
            'email'                => $this->email,
        ]);

        $user->syncRoles([$this->staffRole]);

        $fullName = trim("{$this->fname} {$this->lname}");
        Mail::to($this->email)->send(new WelcomeCredentials($fullName, $username, $temporaryPassword));

        session()->flash('success', ucfirst($this->staffRole) . " account created. Credentials sent to {$this->email}.");

        $this->resetForm();
    }

    private function saveAlumni(): void
    {
        $this->validate([
            'lname'                => 'required|string|max:80',
            'fname'                => 'required|string|max:80',
            'mname'                => 'nullable|string|max:80',
            'email'                => 'required|email|max:255|unique:users,email',
            'batch_id'             => 'required|exists:batches,id',
            'is_batch_rep'         => 'boolean',
            'did_graduate'         => 'boolean',
            'school_year_attended' => 'nullable|string|max:50',
        ]);

        $username          = $this->generateAlumniUsername();
        $temporaryPassword = $this->generateTempPassword();

        DB::transaction(function () use ($username, $temporaryPassword) {
            if ($this->is_batch_rep) {
                AlumniEducation::where('batch_id', $this->batch_id)
                    ->where('is_batch_rep', true)
                    ->update(['is_batch_rep' => false]);
            }

            $alumni = Alumni::create([
                'lname' => $this->lname,
                'fname' => $this->fname,
                'mname' => $this->mname ?: null,
            ]);

            AlumniEducation::create([
                'alumni_id'            => $alumni->id,
                'batch_id'             => $this->batch_id,
                'is_batch_rep'         => $this->is_batch_rep,
                'did_graduate'         => $this->did_graduate,
                'school_year_attended' => $this->school_year_attended ?: null,
            ]);

            $user = User::create([
                'username'             => $username,
                'password'             => Hash::make($temporaryPassword),
                'alumni_id'            => $alumni->id,
                'must_change_password' => true,
                'email'                => $this->email,
            ]);

            $roleToAssign = $this->is_batch_rep ? 'batch-representative' : 'alumni';
            $user->syncRoles([$roleToAssign]);
        });

        $fullName = trim("{$this->fname} {$this->lname}");
        Mail::to($this->email)->send(new WelcomeCredentials($fullName, $username, $temporaryPassword));

        session()->flash('success', $this->is_batch_rep
            ? "Batch representative account created. Credentials sent to {$this->email}."
            : "Alumni account created. Credentials sent to {$this->email}."
        );

        $this->resetForm();
    }

    protected function generateAlumniUsername(): string
    {
        $base = strtolower(
            preg_replace('/[^a-z]/i', '', $this->lname)
            . substr($this->fname, 0, 1)
        );

        $year     = Batch::whereKey($this->batch_id)->value('yeargrad') ?? '0000';
        $username = "batch{$year}-{$base}";
        $original = $username;
        $i        = 1;

        while (User::where('username', $username)->exists()) {
            $username = $original . $i++;
        }

        return $username;
    }

    protected function generateStaffUsername(): string
    {
        $base     = 'staff-' . strtolower(preg_replace('/[^a-z]/i', '', $this->lname) . substr($this->fname, 0, 1));
        $username = $base;
        $i        = 1;

        while (User::where('username', $username)->exists()) {
            $username = $base . $i++;
        }

        return $username;
    }

    protected function generateTempPassword(int $length = 14): string
    {
        return collect(str_split('ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnopqrstuvwxyz23456789!@#$%'))
            ->shuffle()
            ->take($length)
            ->implode('');
    }

    public function render()
    {
        return view('livewire.create-user', [
            'batches'    => $this->batches,
            'staffRoles' => self::STAFF_ROLES,
        ]);
    }
}
```

Note: the old `generateUsername()` is renamed to `generateAlumniUsername()` to match the new branching structure.

- [ ] **Step 4: Run the Livewire tests**

```bash
php artisan test tests/Feature/CashierRoleTest.php
```

Expected: all 6 tests PASS.

- [ ] **Step 5: Commit**

```bash
git add app/Livewire/CreateUser.php tests/Feature/CashierRoleTest.php
git commit -m "feat: extend CreateUser with generic staff account support"
```

---

## Task 5: Update the create-user blade view

**Files:**
- Modify: `resources/views/livewire/create-user.blade.php`

No automated test for UI; verify manually by loading `/users/create` in the browser.

- [ ] **Step 1: Add User Type radio above the Alumni Profile card**

In `resources/views/livewire/create-user.blade.php`, find the line that starts the form:

```blade
    <form wire:submit.prevent="save" class="space-y-4">

        {{-- ── INFO BANNER ─────────────────────────────────────── --}}
```

Insert the following block immediately after `<form wire:submit.prevent="save" class="space-y-4">` and before the info banner:

```blade
        {{-- ── USER TYPE ──────────────────────────────────────── --}}
        <div class="section-card">
            <div class="section-header">
                <div class="section-icon" style="background:#f0fdf4;">
                    <svg class="w-4 h-4" style="color:#059669;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-700 text-slate-800" style="font-weight:700;">User Type</p>
                    <p class="text-xs" style="color:#64748b;">Select the account type to create</p>
                </div>
            </div>
            <div class="section-body">
                <div class="flex gap-4">
                    <label class="flex cursor-pointer items-center gap-2.5 rounded-xl px-4 py-3 flex-1"
                           style="border:1px solid {{ $userType === 'alumni' ? 'var(--r6)' : '#e2e8f0' }};
                                  background:{{ $userType === 'alumni' ? '#eef2ff' : '#fafafa' }};">
                        <input type="radio" wire:model.live="userType" value="alumni" class="sr-only">
                        <div class="w-4 h-4 rounded-full border-2 flex items-center justify-center flex-shrink-0"
                             style="border-color:{{ $userType === 'alumni' ? 'var(--r6)' : '#cbd5e1' }};">
                            @if($userType === 'alumni')
                                <div class="w-2 h-2 rounded-full" style="background:var(--r6);"></div>
                            @endif
                        </div>
                        <div>
                            <p class="text-sm font-semibold" style="color:#1e293b;">Alumni</p>
                            <p class="text-xs" style="color:#64748b;">Requires batch assignment</p>
                        </div>
                    </label>

                    <label class="flex cursor-pointer items-center gap-2.5 rounded-xl px-4 py-3 flex-1"
                           style="border:1px solid {{ $userType === 'staff' ? 'var(--r6)' : '#e2e8f0' }};
                                  background:{{ $userType === 'staff' ? '#eef2ff' : '#fafafa' }};">
                        <input type="radio" wire:model.live="userType" value="staff" class="sr-only">
                        <div class="w-4 h-4 rounded-full border-2 flex items-center justify-center flex-shrink-0"
                             style="border-color:{{ $userType === 'staff' ? 'var(--r6)' : '#cbd5e1' }};">
                            @if($userType === 'staff')
                                <div class="w-2 h-2 rounded-full" style="background:var(--r6);"></div>
                            @endif
                        </div>
                        <div>
                            <p class="text-sm font-semibold" style="color:#1e293b;">Staff</p>
                            <p class="text-xs" style="color:#64748b;">Non-alumni system account</p>
                        </div>
                    </label>
                </div>
            </div>
        </div>
```

- [ ] **Step 2: Wrap the Batch Assignment card in a conditional**

Find the batch assignment section opening div:

```blade
        {{-- ── BATCH ASSIGNMENT ────────────────────────────────── --}}
        <div class="section-card">
```

Wrap the entire batch assignment card (from `{{-- ── BATCH ASSIGNMENT` down to its closing `</div>` after the `section-body` div) with:

```blade
        @if ($userType === 'alumni')
        {{-- ── BATCH ASSIGNMENT ────────────────────────────────── --}}
        <div class="section-card">
            ... (existing batch assignment content unchanged) ...
        </div>
        @endif
```

- [ ] **Step 3: Add Staff Role card (shown when userType === 'staff')**

Immediately after the `@endif` from step 2, add:

```blade
        @if ($userType === 'staff')
        {{-- ── STAFF ROLE ──────────────────────────────────────── --}}
        <div class="section-card">
            <div class="section-header">
                <div class="section-icon" style="background:#f5f3ff;">
                    <svg class="w-4 h-4" style="color:#7c3aed;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285Z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-700 text-slate-800" style="font-weight:700;">Staff Role</p>
                    <p class="text-xs" style="color:#64748b;">Select the system role to assign</p>
                </div>
            </div>
            <div class="section-body">
                <div>
                    <label class="cu-label">Role</label>
                    <select wire:model.defer="staffRole" class="cu-select">
                        <option value="">-- Select role --</option>
                        @foreach ($staffRoles as $role)
                            <option value="{{ $role }}">{{ ucfirst($role) }}</option>
                        @endforeach
                    </select>
                    @error('staffRole')
                        <p class="cu-error">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>
        @endif
```

- [ ] **Step 4: Update the header description text**

In the header section, find:

```blade
                    <p class="mt-1.5 text-sm leading-6" style="color:rgba(255,255,255,.6);max-width:44ch;">
                        Register a batch representative account. Credentials will be
                        emailed automatically on creation.
                    </p>
```

Change to:

```blade
                    <p class="mt-1.5 text-sm leading-6" style="color:rgba(255,255,255,.6);max-width:44ch;">
                        Register an alumni or staff account. Credentials will be
                        emailed automatically on creation.
                    </p>
```

- [ ] **Step 5: Verify in browser**

Start the dev server with `composer dev`. Navigate to `/users/create` and confirm:
- User Type radio shows two options: Alumni and Staff
- Selecting Alumni shows the Batch Assignment card
- Selecting Staff hides the Batch Assignment card and shows the Staff Role dropdown with "Cashier"
- Creating a cashier account succeeds and shows the success toast

- [ ] **Step 6: Run the full test suite to catch regressions**

```bash
php artisan test
```

Expected: all tests PASS.

- [ ] **Step 7: Commit**

```bash
git add resources/views/livewire/create-user.blade.php
git commit -m "feat: add user type toggle and staff role section to create-user form"
```

---

## Self-Review Checklist

- [x] **Spec coverage — Role seeded:** Task 1
- [x] **Spec coverage — Login redirect for cashier:** Task 2
- [x] **Spec coverage — Cashier access to /donations:** Task 3
- [x] **Spec coverage — Cashier sees all batches:** ManageDonations batch-scoping already only fires for `batch-representative`; no change needed
- [x] **Spec coverage — No Alumni/AlumniEducation for staff:** `saveStaff()` creates only a `User` record
- [x] **Spec coverage — Generic STAFF_ROLES constant:** Task 4, `const STAFF_ROLES = ['cashier']`
- [x] **Spec coverage — Username format `staff-{lastname}{firstinitial}`:** `generateStaffUsername()` in Task 4
- [x] **Spec coverage — Dashboard blocked for cashier:** Cashier not in dashboard route middleware; tested in Task 3
- [x] **Type consistency:** `generateUsername()` renamed to `generateAlumniUsername()` throughout; `generateStaffUsername()` added; both return `string`
- [x] **No placeholders:** All steps contain complete code
