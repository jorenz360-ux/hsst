# Super-Admin Role Design

**Date:** 2026-04-21
**Project:** HSST Reunion 2026 (evolving into HSST official school website)
**Status:** Approved

---

## Background

The project is expected to grow beyond a reunion management app into Holy Spirit School of Tagbilaran's (HSST) official school website. New modules (news, faculty pages, admissions, public content) will be added over time. Each new module will introduce new permissions. A `super-admin` role is needed that automatically covers all current and future permissions without requiring manual updates to seeders every time a feature is added.

The existing `reunion-coordinator` role has broad access but is scoped to reunion-specific permissions. It is not a sustainable long-term admin role as the site expands.

---

## Goal

Introduce a `super-admin` role that:

- Bypasses all `can()` permission checks system-wide
- Requires no permission assignments — it works by Spatie's wildcard gate mechanism
- Can be assigned to the site owner/developer
- Does not break or alter any existing roles or their permissions

---

## Approach

Use Spatie Laravel Permission's built-in **super-admin gate** feature. When enabled, any user with the `super-admin` role automatically passes every `Gate::allows()` / `@can()` / `can:` middleware check without needing individual permissions assigned.

This is the preferred approach over a seeded role with all permissions because:

- New permissions added in the future are automatically covered — no seeder maintenance
- Existing roles and their permission matrices are untouched
- Spatie supports this pattern natively via `super_admin_role_gate_enabled`

---

## Changes Required

### 1. `config/permission.php`

Enable the wildcard gate and set the role name:

```php
'super_admin_role_gate_enabled' => true,
'super_admin_role_gate_name' => 'super-admin',
```

### 2. `database/seeders/RoleSeeder.php`

Add `'super-admin'` to the list of seeded roles. No permissions need to be assigned.

### 3. `routes/web.php`

Add `super-admin` to `role:` middleware groups that currently only list `reunion-coordinator`, so route-level role checks don't block the super-admin. Affected routes include:

- `/admin/password-reset-requests` — `role:reunion-coordinator`
- `/attendace-reports` — `role:reunion-coordinator`
- `/committe-reports` — `role:reunion-coordinator`
- `/view-donations` — `role:reunion-coordinator`

All other routes that use `can:` middleware are automatically covered by the wildcard gate.

### 4. `resources/views/dashboard.blade.php`

The admin dashboard is currently shown via `@can('view.admin.dashboard')`. Since the wildcard gate handles `can()` checks, this works automatically for `super-admin`. No change needed here.

The following views use direct `hasRole('reunion-coordinator')` checks that the wildcard gate does NOT cover. These must be updated to also match `super-admin`:

- `resources/views/components/layouts/app/sidebar.blade.php` — lines 33 and 117 (sidebar navigation visibility)
- `resources/views/livewire/reports.blade.php` — line 31 (access label logic)

### 5. Account Assignment

After running migrations/seeders, assign the `super-admin` role to the owner account via `php artisan tinker`:

```php
$user = \App\Models\User::where('email', 'jorenz360@gmail.com')->first();
$user->assignRole('super-admin');
```

---

## What Does NOT Change

- `reunion-coordinator`, `ssps`, `batch-representative`, `alumni` roles — untouched
- All existing permissions and their assignments — untouched
- All Livewire components and their internal `hasRole()` / `can()` logic — covered by wildcard gate (except direct `hasRole()` calls, audited in changes above)

---

## Future Considerations

As the site expands into a full school website:

- New roles (e.g., `teacher`, `student`, `public-editor`) should follow the existing Spatie RBAC pattern
- New permissions should be added to `PermissionSeeder` as modules are built
- `super-admin` will cover all new permissions automatically
- The `reunion-coordinator` role may eventually be retired or repurposed as an event-management-specific role

---

## Testing

- Assign `super-admin` to a test user
- Verify they can access: `/admin/password-reset-requests`, `/manage-users`, `/view-donations`, `/batch-reports`, `/donations`, `/reports`
- Verify existing roles are unaffected (a `reunion-coordinator` user should still have the same access as before)
- Verify an `alumni` user cannot access admin routes
