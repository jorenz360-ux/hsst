# Non-Alumni Self-Registration Design

**Date:** 2026-04-19  
**Status:** Approved

## Overview

Allow non-alumni school personnel (staff, employees, ssps-members) to self-register and signify attendance at the HSST Reunion 2026 event. These users are not alumni and have no batch/graduation history.

## Data Model

### New: `staff` table

| Column | Type | Notes |
|---|---|---|
| `id` | bigint PK | |
| `fname` | string(80) | |
| `lname` | string(80) | |
| `mname` | string(80), nullable | |
| `address_line_1` | string | |
| `address_line_2` | string, nullable | |
| `city` | string | |
| `state_province` | string | |
| `postal_code` | string | |
| `country` | string | default 'Philippines' |
| `years_working` | integer | years worked at HSST |
| `position` | string | e.g. Principal, Faculty |
| `timestamps` | | |

### Changes to `users` table

Add nullable `staff_id` foreign key referencing `staff.id` with cascade delete. Only one of `alumni_id` or `staff_id` will be non-null per user.

### New `Staff` Eloquent Model

- `App\Models\Staff`
- `hasOne` relationship to `User` via `staff_id`
- Follows same name accessor pattern as `Alumni` (ucwords formatting)

### Changes to `User` Model

- Add `staff_id` to `$fillable`
- Add `staff()` belongsTo relationship

## Roles

Three new Spatie roles added via a seeder/migration:

- `staff`
- `employee`
- `ssps-member`

All three have identical permissions: signify attendance (RSVP) to events only. No access to donations, payments, batch info, or admin features.

The self-registration form presents a dropdown for the user to select their type.

## Registration Flow

### Route
`GET /register/staff` — public, unauthenticated

### Livewire Component
`App\Livewire\StaffRegister`

### Form Fields
- First name, last name, middle name (optional)
- Address (line 1, line 2 optional, city, state/province, postal code, country)
- Years working at HSST (integer)
- Position (text field — dropdown values to be added later by client)
- Account type: staff / employee / ssps-member (select)
- Email
- Password + password confirmation

### On Submit
1. Validate all fields
2. Create `Staff` record
3. Generate username from name (e.g. `staff-smithj`)
4. Create `User` with `staff_id`, email, hashed password, `is_active = false`
5. Assign selected role via Spatie
6. Show "pending approval" page — do NOT auto-login
7. Notify `reunion-coordinator` (email or in-app pending list)

### Username Generation
Pattern: `staff-{lname}{first initial of fname}`, with numeric suffix if taken.

## Dashboard Access

Non-alumni users (staff/employee/ssps-member) see a simplified dashboard:
- Upcoming events list
- RSVP / "Signify Attendance" button per event
- No donations section, no batch info, no payment flows

The existing `dashboard.blade.php` role-conditional includes will be extended to handle these three new roles.

## Admin Approval Flow

### Pending List
A new page in the admin panel (`/admin/pending-staff`) visible only to `reunion-coordinator` shows all non-alumni users with `is_active = false`. Displays: name, position, account type, years working, registration date.

### Approve / Reject Actions
- **Approve** — sets `is_active = true`, sends email notifying the user their account is active
- **Reject** — deletes the `User` and `Staff` records, sends email notifying the user their registration was declined

### Notification to Coordinator
After a non-alumni self-registers, an email is sent to the `reunion-coordinator` notifying them of a pending approval. The existing mail infrastructure (Mailtrap in dev, production SMTP) handles delivery.

## Out of Scope

- Position dropdown values (to be added later)
- Email verification
- Donations or event payments for non-alumni users
