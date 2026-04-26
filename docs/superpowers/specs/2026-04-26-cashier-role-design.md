# Cashier Role & Generic Staff Account Creation

**Date:** 2026-04-26
**Status:** Approved

## Summary

Add a `cashier` Spatie role whose sole capability is verifying (approving/rejecting) donation receipts uploaded by batch representatives. The existing Add User page is extended to support non-alumni "Staff" accounts with a generic role picker, so future staff roles can be added without revisiting this flow.

---

## 1. New Spatie Role

- Role name: `cashier`
- Added via `RoleSeeder` (or a dedicated seeder run in the existing seeder chain)
- No Spatie permissions assigned — access is controlled entirely by route middleware role checks
- Future non-alumni staff roles (e.g. `secretary`, `treasurer`) follow the same pattern: seed the role, add it to the relevant routes, add it to the staff role list in `CreateUser`

---

## 2. CreateUser Form — User Type Split

**File:** `app/Livewire/CreateUser.php` + `resources/views/livewire/create-user.blade.php`

A **User Type** radio is added at the top of the form with two options:

### Alumni (default)
- Existing behaviour unchanged
- Batch fields shown (batch, is_batch_rep, did_graduate, school_year_attended)
- Assigns `alumni` or `batch-representative` role
- Creates `Alumni` + `AlumniEducation` records
- Username format: `batch{yeargrad}-{lastname}{firstinitial}`

### Staff
- Batch/graduation fields hidden
- A **Role** dropdown appears, populated from a constant array in `CreateUser.php`:
  ```php
  const STAFF_ROLES = ['cashier'];
  ```
  Adding a new staff role in future = seed it + add it to this array.
- No `Alumni` or `AlumniEducation` record created
- Username format: `staff-{lastname}{firstinitial}` (with numeric suffix if taken)
- Assigns the selected role via `$user->syncRoles([$selectedRole])`
- Welcome email sent with credentials (same `WelcomeCredentials` mailable)

**Validation:** When type is `staff`, batch fields are excluded from validation. `staffRole` is required and must be one of `STAFF_ROLES`.

---

## 3. Route & Access Control

### `/donations` route (ManageDonations)
```
role:batch-representative|cashier|super-admin
```
Cashier sees **all donations across all batches** — the batch-scoping in `ManageDonations::mount()` only applies to `batch-representative`, so cashier is unaffected.

Approve/reject actions already block `batch-representative` via `abort_if` — cashier passes through without any changes needed.

### `/dashboard` route
`cashier` is **not** added to the dashboard route middleware. Cashiers never land on the dashboard.

### Login Redirect
`FortifyServiceProvider::redirectTo()` gets a `cashier` case:
```php
if ($user->hasRole('cashier')) {
    return route('donations');
}
```
This runs before the default dashboard redirect.

---

## 4. No Cashier Dashboard

Cashiers have no dashboard view. On login they go directly to `/donations`. No new Livewire component or view is required.

---

## Out of Scope

- Cashiers cannot create users, manage events, manage announcements, or view reports
- No UI changes to ManageDonations (cashier sees the existing admin-style full view)
- No email notifications triggered by cashier approve/reject actions (unless already present)
