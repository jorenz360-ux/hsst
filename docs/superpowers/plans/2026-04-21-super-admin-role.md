# Super-Admin Role Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Add a `super-admin` role that bypasses all permission checks via Spatie's wildcard gate, so the site owner has unrestricted access to all current and future features.

**Architecture:** Spatie Laravel Permission v6 has a built-in `super_admin_role_gate_enabled` config flag that registers a `Gate::before()` callback — any user with the named role automatically passes every `can()` check. Route-level `role:` middleware is a direct role check (not a gate check), so those routes must also explicitly list `super-admin`. Direct `hasRole('reunion-coordinator')` calls in views are also direct checks and must be updated separately.

**Tech Stack:** Laravel 12, Spatie Laravel Permission ^6.24, Livewire 3, Pest 4

---

## File Map

| File | Change |
|------|--------|
| `config/permission.php` | Add `super_admin_role_gate_enabled` and `super_admin_role_gate_name` keys |
| `database/seeders/RoleSeeder.php` | Add `'super-admin'` to seeded roles |
| `routes/web.php` | Add `super-admin` to all `role:` middleware strings |
| `resources/views/components/layouts/app/sidebar.blade.php` | Include `super-admin` in `hasRole` check on line 33 |
| `resources/views/livewire/reports.blade.php` | Include `super-admin` in `hasRole` check on line 31 |
| `tests/Feature/SuperAdminRoleTest.php` | New feature tests |

---

## Task 1: Write Failing Tests

**Files:**
- Create: `tests/Feature/SuperAdminRoleTest.php`

- [ ] **Step 1: Create the test file**

```php
<?php

use App\Models\User;
use Spatie\Permission\Models\Role;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

beforeEach(function () {
    Role::firstOrCreate(['name' => 'super-admin', 'guard_name' => 'web']);
    Role::firstOrCreate(['name' => 'reunion-coordinator', 'guard_name' => 'web']);
    Role::firstOrCreate(['name' => 'alumni', 'guard_name' => 'web']);
    Role::firstOrCreate(['name' => 'batch-representative', 'guard_name' => 'web']);
});

test('super-admin can access coordinator-only password reset requests route', function () {
    $user = User::factory()->create();
    $user->assignRole('super-admin');

    $response = $this->actingAs($user)->get(route('admin.password-reset-requests'));

    $response->assertStatus(200);
});

test('super-admin can access coordinator-only attendance reports route', function () {
    $user = User::factory()->create();
    $user->assignRole('super-admin');

    $response = $this->actingAs($user)->get(route('reports.attendance'));

    $response->assertStatus(200);
});

test('super-admin can access coordinator-only view-donations route', function () {
    $user = User::factory()->create();
    $user->assignRole('super-admin');

    $response = $this->actingAs($user)->get(route('view-donations'));

    $response->assertStatus(200);
});

test('super-admin can access batch-representative-only donations route', function () {
    $user = User::factory()->create();
    $user->assignRole('super-admin');

    $response = $this->actingAs($user)->get(route('donations'));

    $response->assertStatus(200);
});

test('super-admin can access the dashboard', function () {
    $user = User::factory()->create();
    $user->assignRole('super-admin');

    $response = $this->actingAs($user)->get(route('dashboard'));

    $response->assertStatus(200);
});

test('alumni cannot access coordinator-only routes', function () {
    $user = User::factory()->create();
    $user->assignRole('alumni');

    $response = $this->actingAs($user)->get(route('admin.password-reset-requests'));

    $response->assertStatus(403);
});

test('reunion-coordinator still has access to their routes', function () {
    $user = User::factory()->create();
    $user->assignRole('reunion-coordinator');

    $response = $this->actingAs($user)->get(route('view-donations'));

    $response->assertStatus(200);
});
```

- [ ] **Step 2: Run the tests to confirm they all fail**

```bash
php artisan test tests/Feature/SuperAdminRoleTest.php
```

Expected: All `super-admin` tests FAIL with 403. The `alumni` and `reunion-coordinator` tests may pass or fail depending on current state — note the results.

---

## Task 2: Enable the Super-Admin Gate in Config

**Files:**
- Modify: `config/permission.php`

- [ ] **Step 1: Add the super-admin gate keys**

In `config/permission.php`, add the following two keys after the `'enable_wildcard_permission'` line (line 169):

```php
    /*
     * When set to true, a role named as defined in 'super_admin_role_gate_name' will
     * automatically pass all Gate::allows() checks.
     */
    'super_admin_role_gate_enabled' => true,
    'super_admin_role_gate_name' => 'super-admin',
```

The file section around line 169 should look like this after the edit:

```php
    'enable_wildcard_permission' => false,

    /*
     * When set to true, a role named as defined in 'super_admin_role_gate_name' will
     * automatically pass all Gate::allows() checks.
     */
    'super_admin_role_gate_enabled' => true,
    'super_admin_role_gate_name' => 'super-admin',
```

- [ ] **Step 2: Clear the permission cache**

```bash
php artisan cache:clear
```

Expected output: `Application cache cleared successfully.`

- [ ] **Step 3: Commit**

```bash
git add config/permission.php
git commit -m "config: enable super-admin wildcard gate in Spatie permission"
```

---

## Task 3: Seed the Super-Admin Role

**Files:**
- Modify: `database/seeders/RoleSeeder.php`

- [ ] **Step 1: Add super-admin to the roles array**

Replace the `$roles` array in `database/seeders/RoleSeeder.php`:

```php
$roles = [
    'super-admin',
    'reunion-coordinator',
    'ssps',
    'batch-representative',
    'alumni',
];
```

- [ ] **Step 2: Run the seeder to create the role in the database**

```bash
php artisan db:seed --class=RoleSeeder
```

Expected output: `Running seeder...` then completion without error. The `roles` table will now have a `super-admin` row.

- [ ] **Step 3: Commit**

```bash
git add database/seeders/RoleSeeder.php
git commit -m "feat: add super-admin role to RoleSeeder"
```

---

## Task 4: Update Route Middleware to Include Super-Admin

**Files:**
- Modify: `routes/web.php`

The `role:` middleware is a direct role check (not a Gate check), so the wildcard gate does NOT cover it. Every `role:` string that does not already include `super-admin` must be updated.

- [ ] **Step 1: Update all affected route middleware strings**

Make these exact replacements in `routes/web.php`:

| Old string | New string |
|-----------|-----------|
| `'role:reunion-coordinator'` | `'role:reunion-coordinator\|super-admin'` |
| `'role:reunion-coordinator\|ssps'` | `'role:reunion-coordinator\|ssps\|super-admin'` |
| `'role:batch-representative'` | `'role:batch-representative\|super-admin'` |
| `'role:ssps\|reunion-coordinator'` | `'role:ssps\|reunion-coordinator\|super-admin'` |
| `'role:reunion-coordinator\|ssps\|batch-representative'` | `'role:reunion-coordinator\|ssps\|batch-representative\|super-admin'` |
| `'role:reunion-coordinator\|ssps\|alumni\|batch-representative\|staff\|employee\|ssps-member'` | `'role:reunion-coordinator\|ssps\|alumni\|batch-representative\|staff\|employee\|ssps-member\|super-admin'` |

After the edit, the affected routes should look like:

```php
Route::get('/admin/password-reset-requests', PasswordResetRequests::class)
    ->middleware(['auth', 'role:reunion-coordinator|super-admin'])
    ->name('admin.password-reset-requests');

Route::get('/attendace-reports', AttendanceReport::class)
    ->middleware(['auth', 'role:reunion-coordinator|super-admin'])
    ->name('reports.attendance');

Route::get('/committe-reports', CommitteReport::class)
    ->middleware(['auth', 'role:reunion-coordinator|super-admin'])
    ->name('reports.committe');

Route::get('/batch-reports', BatchRepReports::class)
    ->middleware(['auth', 'role:batch-representative|super-admin'])
    ->name('reports.batch-rep');

Route::get('/view-batch', Batch::class)
    ->middleware(['auth', 'role:batch-representative|super-admin'])
    ->name('view-batch');

Route::get('/view-donations', Donations::class)
    ->middleware(['auth', 'role:reunion-coordinator|super-admin'])
    ->name('view-donations');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified', 'role:reunion-coordinator|ssps|alumni|batch-representative|staff|employee|ssps-member|super-admin'])
    ->name('dashboard');

Route::get('/manage-users', ManageUsers::class)
    ->middleware(['auth', 'verified', 'role:reunion-coordinator|ssps|super-admin'])
    ->name('manage-users');

Route::get('/users/create', CreateUser::class)
    ->middleware(['auth', 'role:reunion-coordinator|ssps|super-admin'])
    ->name('users.create');

Route::get('/reports', Reports::class)
    ->middleware(['auth', 'role:reunion-coordinator|ssps|batch-representative|super-admin'])
    ->name('reports');

Route::get('/donations', ManageDonations::class)
    ->middleware(['auth', 'role:batch-representative|super-admin'])
    ->name('donations');

Route::get(uri: '/create/events', action: CreateEvents::class)
    ->middleware(['auth', 'role:ssps|reunion-coordinator|super-admin'])
    ->name('create-event');

Route::get(uri: '/view/events', action: Events::class)
    ->middleware(['auth', 'role:ssps|reunion-coordinator|super-admin'])
    ->name('event-view');

Route::get(uri: '/announcement', action: ManageAnnouncement::class)
    ->middleware(['auth', 'role:ssps|reunion-coordinator|super-admin'])
    ->name('manage-announcement');

Route::get('/admin/pending-staff', \App\Livewire\Admin\PendingStaff::class)
    ->middleware(['auth', 'role:reunion-coordinator|super-admin'])
    ->name('admin.pending-staff');
```

- [ ] **Step 2: Run the super-admin route tests**

```bash
php artisan test tests/Feature/SuperAdminRoleTest.php
```

Expected: All tests PASS.

- [ ] **Step 3: Commit**

```bash
git add routes/web.php
git commit -m "feat: allow super-admin on all role-protected routes"
```

---

## Task 5: Fix hasRole Checks in Views

**Files:**
- Modify: `resources/views/components/layouts/app/sidebar.blade.php`
- Modify: `resources/views/livewire/reports.blade.php`

These files use `hasRole('reunion-coordinator')` directly. The wildcard gate does NOT cover `hasRole()` calls — they check the roles table directly.

- [ ] **Step 1: Update sidebar.blade.php report route logic**

In `resources/views/components/layouts/app/sidebar.blade.php`, replace the `@php` block starting at line 29:

```php
@php
    $user = auth()->user();
    $reportRoute = null;

    if ($user?->hasRole('reunion-coordinator') || $user?->hasRole('super-admin')) {
        $reportRoute = route('reports');
    } elseif ($user?->hasRole('batch-representative')) {
        $reportRoute = route('reports.batch-rep');
    }
@endphp
```

- [ ] **Step 2: Find and update the second hasRole check in sidebar.blade.php**

Search for `hasRole('reunion-coordinator')` at line 117 in the same file. This controls what sidebar navigation items are shown to coordinators. Update it to include `super-admin`:

```php
@if ($user?->hasRole('reunion-coordinator') || $user?->hasRole('super-admin'))
```

- [ ] **Step 3: Update reports.blade.php access label**

In `resources/views/livewire/reports.blade.php`, replace the `@php` block at line 30:

```php
@php
    $accessLabel = (auth()->user()?->hasRole('reunion-coordinator') || auth()->user()?->hasRole('super-admin'))
        ? 'Admin Ready'
        : 'Batch Rep Ready';
@endphp
```

- [ ] **Step 4: Commit**

```bash
git add resources/views/components/layouts/app/sidebar.blade.php
git add resources/views/livewire/reports.blade.php
git commit -m "feat: include super-admin in hasRole view checks"
```

---

## Task 6: Assign Super-Admin Role to Owner Account

- [ ] **Step 1: Assign the role via tinker**

```bash
php artisan tinker
```

Then run inside tinker:

```php
$user = \App\Models\User::where('email', 'jorenz360@gmail.com')->firstOrFail();
$user->assignRole('super-admin');
echo "Assigned super-admin to: " . $user->email;
```

Expected output: `Assigned super-admin to: jorenz360@gmail.com`

Exit tinker with `exit` or Ctrl+D.

- [ ] **Step 2: Verify the role is assigned**

```bash
php artisan tinker --execute="\$u = \App\Models\User::where('email','jorenz360@gmail.com')->first(); echo implode(', ', \$u->getRoleNames()->toArray());"
```

Expected output: includes `super-admin`

---

## Task 7: Run Full Test Suite

- [ ] **Step 1: Run all tests**

```bash
php artisan test
```

Expected: All tests PASS. If any existing test fails that was passing before, investigate before proceeding.

- [ ] **Step 2: Clear permission cache on production (when deploying)**

```bash
php artisan permission:cache-reset
```

This flushes Spatie's 24-hour permission cache so the new role and config take effect immediately on the live server.

---

## Manual Smoke Test Checklist

After completing all tasks, verify in the browser while logged in as the super-admin account:

- [ ] Dashboard loads (shows admin dashboard content)
- [ ] `/admin/password-reset-requests` is accessible
- [ ] `/manage-users` is accessible
- [ ] `/view-donations` is accessible
- [ ] `/donations` is accessible (batch-rep route)
- [ ] `/view-batch` is accessible
- [ ] `/reports` is accessible and shows "Admin Ready" label
- [ ] Sidebar shows coordinator-level navigation items
- [ ] Log in as a regular `alumni` user — confirm they still cannot access `/admin/password-reset-requests` (should get 403)
