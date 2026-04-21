---
title: RSVP Batch Selection for Multi-Level Alumni
date: 2026-04-21
status: approved
---

## Problem

Alumni who attended HSST at multiple levels (e.g., Elementary and High School) have multiple records in `alumni_educations`. When they RSVP for an event, there is no way to record which batch/level they are representing. The attendance report currently guesses using `MAX(batch_id)`, which is inaccurate and makes the Level filter unreliable.

## Goal

Store the batch the alumni is attending as on their RSVP record, and surface a batch picker in the RSVP UI only when the alumni has more than one education record.

---

## Data Layer

### Migration

Add a nullable foreign key `batch_id` to `event_rsvps`:

```php
$table->foreignId('batch_id')->nullable()->constrained('batches')->nullOnDelete();
```

Nullable because:
- Existing RSVPs have no batch selected yet
- Alumni with zero education records (edge case) can still RSVP

### EventRsvp model

Add `batch_id` to `$fillable`.

---

## Backend — EventParticipationPage

### New property

```php
public ?int $selectedBatchId = null;
```

### mount()

After loading the RSVP, also load the alumni's educations with their batch:

```php
$this->alumniEducations = Auth::user()->alumni
    ->educations()
    ->with('batch')
    ->get();
```

If exactly one education exists, set `$selectedBatchId` automatically from it. If the alumni already has an existing RSVP with a `batch_id`, use that (handles the "edit existing RSVP" case).

### setRsvp()

Validation:
- If `$alumniEducations->count() > 1` and `$selectedBatchId` is null → flash error, return early.
- If `$alumniEducations->count() === 1` → force `$selectedBatchId` to that single education's `batch_id`.

Save `batch_id` alongside status:

```php
EventRsvp::updateOrCreate(
    ['event_id' => $eventId, 'alumni_id' => $alumniId],
    ['status' => $status, 'batch_id' => $this->selectedBatchId, ...]
);
```

Batch selection is always editable — changing status or batch re-saves the record.

---

## Frontend — event-participation-page.blade.php

Show the batch picker **only** when `count($alumniEducations) > 1`, placed above the three RSVP radio buttons:

```
┌─────────────────────────────────────────────────────┐
│ Which batch are you attending as?                    │
│ ┌─────────────────────────────────────────────────┐ │
│ │ High School — 2001-2002                     ▾   │ │
│ └─────────────────────────────────────────────────┘ │
└─────────────────────────────────────────────────────┘

[ Attend ]   [ Maybe ]   [ Not Attending ]
```

Dropdown options display: `{Level} — {schoolyear}`, e.g. "High School — 2001-2002", "Elementary — 1995-1996".

Single-level alumni see no extra UI — their batch is silently captured.

---

## Attendance Report — AttendanceReport.php

### reportQuery() change

**Remove** the `MAX(batch_id)` subquery:

```php
// Remove this:
$primaryBatch = DB::table('alumni_educations')
    ->select(['alumni_id', DB::raw('MAX(batch_id) as batch_id')])
    ->groupBy('alumni_id');
```

**Replace** with a direct join on `event_rsvps.batch_id`:

```php
->leftJoin('batches', 'batches.id', '=', 'event_rsvps.batch_id')
```

This means:
- Batch and level columns now reflect what the alumni actually selected
- Alumni who haven't RSVPd yet show no batch (same as before)
- The Level filter (`where('batches.level', ...)`) becomes accurate

---

## Edge Cases

| Scenario | Behaviour |
|---|---|
| Alumni has 0 education records | No batch picker shown; `batch_id` saved as null |
| Alumni has 1 education record | Batch auto-selected; no UI shown |
| Alumni has 2+ education records | Picker required before saving RSVP |
| Alumni changes RSVP status later | Batch picker remains editable |
| Existing RSVPs (pre-migration) | `batch_id` is null; report shows no batch (same as current) |

---

## Files Affected

| File | Change |
|---|---|
| `database/migrations/YYYY_add_batch_id_to_event_rsvps.php` | New migration |
| `app/Models/EventRsvp.php` | Add `batch_id` to `$fillable` |
| `app/Livewire/EventParticipationPage.php` | Add `$selectedBatchId`, update `mount()` and `setRsvp()` |
| `resources/views/livewire/event-participation-page.blade.php` | Conditional batch picker UI |
| `app/Livewire/AttendanceReport.php` | Replace MAX subquery with direct join |
